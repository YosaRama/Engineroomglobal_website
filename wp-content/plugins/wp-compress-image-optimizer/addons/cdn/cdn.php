<?php


class wps_addon_cdn {

	public static $settings;
	public static $options;
	public static $excluded_list;
	public static $cdnEnabled;

	public static $emoji_remove;

	public static $isAjax;
	public static $brizyCache;
	public static $replacedJS;
	public static $logger;

	// Predefined API URLs
	public static $apiUrl;
	public static $apiAssetUrl;

	// Site URL, Upload Dir
	public static $updir;
	public static $home_url;
	public static $site_url;
	public static $site_url_scheme;

	// Resolution
	public static $resolutions;
	public static $defined_resolution;

	// SVG Placeholder (empty svg)
	public static $svg_placeholder;

	// Speed Test Variables
	public static $image_count;
	public static $speed_test;
	public static $speed_test_img_count_limit;

	// CSS / JS Variables
	public static $css;
	public static $css_minify;
	public static $js;
	public static $js_minify;

	// Image Compress Variables
	public static $external_url_enabled;
	public static $zone_name;
	public static $is_retina;
	public static $exif;
	public static $webp;
	public static $retina_enabled;
	public static $adaptive_enabled;
	public static $webp_enabled;
	public static $lazy_enabled;

	public function __construct() {
		if ( ! empty($_GET['ignore_ic'])) {
			return;
		}

		if (strpos($_SERVER['REQUEST_URI'], '.xml') !== false) {
			return;
		}

		self::$settings = get_option(WPS_IC_SETTINGS);
		if ( ! empty(self::$settings['live-cdn']) && self::$settings['live-cdn'] == '0') {
			#return;
		}

		self::$cdnEnabled = self::$settings['live-cdn'];
		self::$logger     = new wps_ic_logger();

		// Plugin is NOT Activated
		self::$options = get_option(WPS_IC_OPTIONS);
		$response_key  = self::$options['response_key'];
		if (empty($response_key)) {
			return;
		}

		// Is an ajax request?
		self::$isAjax = (function_exists("wp_doing_ajax") && wp_doing_ajax()) || (defined('DOING_AJAX') && DOING_AJAX);

		// Don't run in admin side!
		if ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize.php") {
			return;
		}

		// TODO: Check this for wpadmin and frontend ajax
		if ( ! self::$isAjax) {
			if (is_admin() || ! empty($_GET['trp-edit-translation']) || ( ! empty($_GET['fl_builder']) || isset($_GET['fl_builder'])) || ! empty($_GET['elementor-preview']) || ! empty($_GET['preview']) || ! empty($_GET['PageSpeed']) || ! empty($_GET['et_fb']) || ! empty($_GET['ct_builder']) || ( ! empty
					($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize.php")) {
				return;
			}
		}

		self::$speed_test_img_count_limit = 10;
		self::$speed_test                 = $this->is_st();
		self::$svg_placeholder            = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAwIiBoZWlnaHQ9IjEwMCI+PHBhdGggZD0iTTIgMmgxMDAwdjEwMEgyeiIgZmlsbD0iI2ZmZiIgb3BhY2l0eT0iMCIvPjwvc3ZnPg==';

		self::$updir = wp_upload_dir();

		// If SpeedTest Then disable LS cache and rocket cache
		if (self::$speed_test) {
			define('LSCACHE_NO_CACHE', true);
			define('DONOTCACHEPAGE', true);
			add_filter('rocket_override_donotcachepage', '__return_true', PHP_INT_MAX);
		}

		if ( ! is_multisite()) {
			self::$site_url = site_url();
			self::$home_url = home_url();
		}
		else {
			self::$site_url = network_site_url();
			self::$home_url = network_home_url();
		}

		self::$site_url_scheme = parse_url(self::$site_url, PHP_URL_SCHEME);
		self::$excluded_list   = get_option('wps_ic_exclude_list');
		self::$brizyCache      = get_option('wps_ic_brizy_cache');

		self::$image_count = 0;

		if (empty(self::$settings['cname']) || ! self::$settings['cname']) {
			self::$zone_name = get_option('ic_cdn_zone_name');
		}
		else {
			$custom_cname    = get_option('ic_custom_cname');
			self::$zone_name = $custom_cname;
		}

		if (empty(self::$zone_name)) {
			return;
		}

		self::$resolutions = array('desktop' => 1920, 'laptop' => 1500, 'laptop' => 1280, 'tablet' => 1024, 'laptop' => 768, 'mobile' => 480, 'xsmobile' => 290);

		self::$is_retina            = 'false';
		self::$webp                 = 'false';
		self::$external_url_enabled = 'false';

		self::$lazy_enabled     = self::$settings['lazy'];
		self::$adaptive_enabled = self::$settings['generate_adaptive'];
		self::$webp_enabled     = self::$settings['generate_webp'];
		self::$retina_enabled   = self::$settings['retina'];

		if ( ! empty(self::$settings['external-url'])) {
			self::$external_url_enabled = self::$settings['external-url'];
		}

		if (empty(self::$settings['emoji-remove'])) {
			self::$settings['emoji-remove'] = 0;
		}

		if (empty(self::$settings['js-minify'])) {
			self::$settings['js-minify'] = 0;
		}

		if (empty(self::$settings['css-minify'])) {
			self::$settings['css-minify'] = 0;
		}

		if (empty(self::$settings['external-url'])) {
			self::$settings['external-url'] = 0;
		}

		if (empty(self::$settings['css'])) {
			self::$settings['css'] = 0;
		}

		if (empty(self::$settings['js'])) {
			self::$settings['js'] = 0;
		}

		if (empty(self::$settings['preserve_exif'])) {
			self::$settings['preserve_exif'] = 0;
		}

		self::$external_url_enabled = self::$settings['external-url'];
		self::$css                  = self::$settings['css'];
		self::$css_minify           = self::$settings['css-minify'];
		self::$js                   = self::$settings['js'];
		self::$js_minify            = self::$settings['js-minify'];
		self::$emoji_remove         = self::$settings['emoji-remove'];
		self::$exif                 = self::$settings['preserve_exif'];

		if ( ! empty(self::$emoji_remove) && self::$emoji_remove == '1') {
			// Remove WP Emoji
			$this->remove_emoji();
		}

		if ( ! empty(self::$retina_enabled) && self::$retina_enabled == '1') {
			if (isset($_COOKIE["ic_pixel_ratio"])) {
				if ($_COOKIE["ic_pixel_ratio"] >= 2) {
					self::$is_retina = 'true';
				}
			}
		}

		/**
		 * Does browser support WebP?
		 */
		if ( ! empty(self::$webp_enabled) && self::$webp_enabled == '1') {
			if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
				self::$webp = 'true';
			}
		}

		// If Optimization Quality is Not set..
		if (empty(self::$settings['optimization']) || self::$settings['optimization'] == '' || self::$settings['optimization'] == '0') {
			self::$settings['optimization'] = 'intelligent';
		}

		$options = self::$options;

		if ( ! empty($_GET['test_zone'])) {
			self::$zone_name = $_GET['test_zone'] . '.wpmediacompress.com/key:' . $options['api_key'];
		}

		if ( ! empty(self::$exif) && self::$exif == '1') {
			self::$apiUrl = 'https://' . self::$zone_name . '/q:' . self::$settings['optimization'] . '/exif:true';
		}
		else {
			self::$apiUrl = 'https://' . self::$zone_name . '/q:' . self::$settings['optimization'] . '';
		}

		self::$apiAssetUrl = 'https://' . self::$zone_name . '/asset:';

		self::$defined_resolution = self::$resolutions['desktop'];
		if ( ! isset($_COOKIE['ic_window_resolution'])) {
			// TODO: Something?
		}
		else {
			$resolution               = $this->find_closes_matching_resolution($_COOKIE['ic_window_resolution']);
			self::$defined_resolution = $resolution;
		}

		if (self::$speed_test || $this->is_mobile()) {
			self::$retina_enabled     = false;
			self::$is_retina          = 'false';
			self::$defined_resolution = self::$resolutions['mobile'];
		}

		self::$logger->log('Zone Name: ' . self::$zone_name);

		if (self::$cdnEnabled == 1) {
			add_filter('wp_get_attachment_image_src', array(&$this, 'change_attachment_image_src'));
			add_filter('wp_calculate_image_srcset', array(&$this, 'change_image_srcset'));
			add_filter('the_content', array(&$this, 'change_content_src'));

			// Favicon
			add_filter('woocommerce_single_product_image_thumbnail_html', array(&$this, 'filter_Woo_gallery_html'), 10, 2);
			add_filter('woocommerce_gallery_image_html_attachment_image_params', array(&$this, 'filter_Woo_gallery'), 10, 4);
		}

	}


	/**
	 * Detect SpeedTest like pingdom or gtmetrix
	 * @return bool
	 */
	public function is_st() {

		if ( ! empty($_GET['write_speedtest_log'])) {
			$fp = fopen(WPS_IC_DIR . 'speedtest.txt', 'a+');
			fwrite($fp, 'IP: ' . $_SERVER['REMOTE_ADDR'] . "\r\n");
			fwrite($fp, 'User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n");
			fclose($fp);
		}

		if (is_admin()) {
			return false;
		}

		$ip_list = array(0  => '52.162.212.163',
										 1  => '13.78.216.56',
										 2  => '65.52.113.236',
										 3  => '52.229.122.240',
										 4  => '172.255.48.147',
										 5  => '172.255.48.146',
										 6  => '172.255.48.145',
										 7  => '172.255.48.144',
										 8  => '172.255.48.143',
										 9  => '172.255.48.142',
										 10 => '208.70.247.157',
										 11 => '172.255.48.141',
										 12 => '172.255.48.140',
										 13 => '172.255.48.139',
										 14 => '172.255.48.138',
										 15 => '172.255.48.137',
										 16 => '172.255.48.136',
										 17 => '172.255.48.135',
										 18 => '172.255.48.134',
										 19 => '172.255.48.133',
										 20 => '172.255.48.132',
										 21 => '172.255.48.131',
										 22 => '172.255.48.130',
										 23 => '104.214.48.247',
										 24 => '40.74.243.176',
										 25 => '40.74.243.13',
										 26 => '40.74.242.253',
										 27 => '13.85.82.26',
										 28 => '13.85.24.90',
										 29 => '13.85.24.83',
										 30 => '13.66.7.11',
										 31 => '104.214.72.101',
										 32 => '191.235.99.221',
										 33 => '191.235.98.164',
										 34 => '104.41.2.19',
										 35 => '104.211.165.53',
										 36 => '104.211.143.8',
										 37 => '172.255.61.40',
										 38 => '172.255.61.39',
										 39 => '172.255.61.38',
										 40 => '172.255.61.37',
										 41 => '172.255.61.36',
										 42 => '172.255.61.35',
										 43 => '172.255.61.34',
										 44 => '65.52.36.250',
										 45 => '70.37.83.240',
										 46 => '104.214.110.135',
										 47 => '157.55.189.189',
										 48 => '191.232.194.51',
										 49 => '52.175.57.81',
										 50 => '52.237.236.145',
										 51 => '52.237.250.73',
										 52 => '52.237.235.185',
										 53 => '40.83.89.214',
										 54 => '40.123.218.94',
										 55 => '102.133.169.66',
										 56 => '52.172.14.87',
										 57 => '52.231.199.170',
										 58 => '52.246.165.153',
										 59 => '13.76.97.224',
										 60 => '13.53.162.7',
										 61 => '20.52.36.49',
										 62 => '20.188.63.151',
										 63 => '51.144.102.233',
										 64 => '23.96.34.105');

		$x11        = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'x11');
		$pingdom    = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'pingdom');
		$pingdombot = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'pingbot');
		$gtmetrix   = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'gtmetrix');
		$pageSpeed  = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'pagespeed');
		$google     = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'google page speed');
		$google_ps  = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'lighthouse');

		if ( ! empty($_GET['simulate_test'])) {
			return true;
		}

		if ($x11 !== false) {
			return true;
		}

		if ($pingdom !== false) {
			return true;
		}

		if ($pingdombot !== false) {
			return true;
		}

		if ($pageSpeed !== false) {
			return true;
		}

		if ($gtmetrix !== false) {
			return true;
		}

		if ($google !== false) {
			return true;
		}

		if ($google_ps !== false) {
			return true;
		}

		$userIP = $_SERVER['REMOTE_ADDR'];
		if (in_array($userIP, $ip_list)) {
			return true;
		}
		else {
			return false;
		}
	}


	/**
	 * Remove WP Emoji
	 */
	public function remove_emoji() {
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_styles', 'print_emoji_styles');
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	}


	public function find_closes_matching_resolution($match_resolution) {
		if (is_array(self::$resolutions)) {
			arsort(self::$resolutions);
			foreach (self::$resolutions as $device => $resolution) {
				if ($resolution > $match_resolution) {
					continue;
				}
				else {
					return $resolution;
				}
			}
		}
	}


	public function is_mobile() {
		$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

		if (strpos($userAgent, 'Chrome-Lighthouse')) {
			return true;
		}
		else {
			return false;
		}
	}


	public static function remove_ver($src) {
		if (strpos($src, '?ver=')) {
			$src = remove_query_arg('ver', $src);
		}

		return $src;
	}


	public static function enqueue_css_print() {
		global $css_run, $post;

		if (isset($_GET['brizy-edit-iframe']) || isset($_GET['brizy-edit']) || isset($_GET['preview'])) {
			return;
		}

		if (is_admin() || ! empty($_GET['trp-edit-translation']) || ! empty($_GET['elementor-preview']) || ! empty($_GET['preview']) || ! empty($_GET['PageSpeed']) || ! empty($_GET['et_fb']) || ( ! empty($_GET['fl_builder']) || isset($_GET['fl_builder'])) || ! empty($_GET['ct_builder']) || ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize
		.php")) {
			return;
		}

		wp_styles(); //ensure styles is initialised
		global $wp_styles;

		// Setup MinifyClass
		$uriRewrite = new Minify_CSS_UriRewriter();

		$css_cache = get_transient('wps_ic_css_cache');
		$css_cache = false;

		// Predefined Variables
		$comined_css = '';
		$combined    = array();

		// Setup a List of Modified CSS Files
		$modified_css_files = get_option('wps_ic_modified_css_cache');
		if (empty($modified_css_files)) {
			$modified_css_files = array();
		}

		// Setup a Cache Dir and URL
		$cache_dir = WPS_IC_CACHE . $post->ID;
		$cache_url = WPS_IC_CACHE_URL . $post->ID;

		// If cache dir for post type does not exist, create it
		if ( ! file_exists($cache_dir)) {
			mkdir($cache_dir);
		}

		// If cache expired delete option
		if ( ! $css_cache) {
			delete_option('wps_ic_modified_css_cache');
			delete_option('wps_ic_css_combined_cache');
		}

		// Find real path to WordPress
		$frontend = rtrim(ABSPATH, '/');
		if ( ! $frontend) {
			$frontend = parse_url(get_option('home'));
			$frontend = ! empty($frontend['path']) ? $frontend['path'] : '';
			$frontend = $_SERVER['DOCUMENT_ROOT'] . $frontend;
		}

		$frontend = realpath($frontend);

		$combined['deps']     = array();
		$combined['file_dir'] = $cache_dir . '/combined.css';
		$combined['file_url'] = $cache_url . '/combined.css';

		// Print all loaded Styles (CSS)
		foreach ($wp_styles->queue as $style) {

			if ($style == 'admin-bar') {
				continue;
			}

			$deps    = $wp_styles->registered[ $style ]->deps;
			$handle  = $wp_styles->registered[ $style ]->handle;
			$css_url = $wp_styles->registered[ $style ]->src;
			$extra   = $wp_styles->registered[ $style ]->extra;
			$after   = $extra['after'];

			// We already did this file
			if (isset($modified_css_files[ $post->ID ][ $handle ]) && ! empty($modified_css_files[ $post->ID ][ $handle ])) {
				continue;
			}

			if (strpos($css_url, self::$site_url) === false && preg_match('/(\/wp-content\/[^\"\'=\s]+\.(css|js))/', $css_url) == 0 && preg_match('/(\/wp-includes\/[^\"\'=\s]+\.(css|js))/', $css_url) == 0) {
				continue;
			}

			// CSS filename from URL
			$css_basename = basename($css_url);
			// Remove ?version
			$css_basename = explode('?', $css_basename);
			// CSS filename withou version
			$css_basename = $css_basename[0];

			// Path to CSS File
			$css_path = str_replace(self::$site_url . '/', '', $css_url);
			$css_path = explode('?', $css_path);
			$css_path = ABSPATH . $css_path[0];

			// Figure out was the file changed (by filesize)
			$css_md5_original = filesize($css_path);
			if (in_array($handle, $modified_css_files)) {
				// In array, check if changed
				$css_old_m5 = $modified_css_files[ $post->ID ][ $handle ]['size'];
				if ($css_md5_original !== $css_old_m5) {
					// File has changed
					$modified_css_files[ $post->ID ][ $handle ]['size'] = $css_md5_original;
				}
				else {
					// Do nothing;
					continue;
				}
			}
			else {
				// Not in array
				$modified_css_files[ $post->ID ][ $handle ]['size'] = $css_md5_original;
			}

			// Works
			$modified_css_files[ $post->ID ][ $handle ]['deps']           = $deps;
			$modified_css_files[ $post->ID ][ $handle ]['cache_dir_file'] = $cache_dir . '/' . $handle . '-' . $css_basename;
			$modified_css_files[ $post->ID ][ $handle ]['cache_uri_file'] = $cache_url . '/' . $handle . '-' . $css_basename;
			$modified_css_files[ $post->ID ][ $handle ]['after']          = $after;

			// For Combined
			foreach ($deps as $k => $dep) {
				if ( ! in_array($dep, $combined['deps'])) {
					$combined['deps'][] = $dep;
				}
			}

			// Get CSS File contents
			$css_contents = file_get_contents($css_path);
			if ( ! empty($css_contents)) {

				// Deregister and deque the style and handle
				wp_deregister_style($style);
				wp_deregister_style($handle);
				wp_dequeue_style($style);
				wp_dequeue_style($handle);

				// Figure out the CSS File URL
				$url_parsed = parse_url(self::ensure_scheme($css_url));

				if (substr($url_parsed['path'], 0, 1) === '/') {
					$file_path_ori = $_SERVER['DOCUMENT_ROOT'] . $url_parsed['path'];
				}
				else {
					$file_path_ori = $frontend . '' . $url_parsed['path'];
				}

				// Rewrite CSS Contents
				$css_contents = $uriRewrite::rewrite($css_contents, $url_parsed['scheme'] . '://' . $url_parsed['host'] . '' . $file_path_ori);

				// Is combined into 1 file enabled?
				$comined_css = preg_replace("/url\(\s*['\"]?(?!data:)(?!http)(?![\/'\"])(.+?)['\"]?\s*\)/i", "url(" . dirname($file_path_ori) . "/$1)", $comined_css);

				$comined_css = preg_replace_callback('/(https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|css|jsp|json|js|svg|woff|eot|ttf|woff2)/', array('wps_addon_cdn', 'obstart_replace_url_in_css'), $comined_css);

				$comined_css = preg_replace_callback('/(?:("|\'))(?:(..\/|\/))wp-content\/[^\"\'=\s]+\.(jpg|jpeg|png|gif|svg)(?:("|\'))/', array('wps_addon_cdn', 'replace_path_css'), $comined_css);

				// Combine all css in one large file
				$comined_css .= $css_contents;
			}

		}

		if ( ! $css_cache) {
			update_option('wps_ic_modified_css_cache', $modified_css_files);
			update_option('wps_ic_css_combined_cache', $combined);
		}
		else {
			$combined                  = get_option('wps_ic_css_combined_cache');
			$modified_css_files_option = get_option('wps_ic_modified_css_cache');

			if (empty($modified_css_files_option)) {
				delete_transient('wps_ic_css_cache');
			}
			else {
				$modified_css_files = $modified_css_files_option;
			}
		}

		// Combine all css in one large file
		if ( ! empty($combined['deps'])) {
			foreach ($combined['deps'] as $k => $dep) {
				wp_enqueue_style($dep);
			}
		}

		if ( ! $css_cache && ! empty($comined_css)) {
			file_put_contents($combined['file_dir'], $comined_css);
		}

		if ( ! empty($combined) && file_exists($combined['file_dir']) && filesize($combined['file_dir']) > 0) {
			wp_register_style('wps-ic-combined', $combined['file_url'], array(), false, 'all');
			wp_enqueue_style('wps-ic-combined');
		}

		$css_run = 1;
		set_transient('wps_ic_css_cache', 'true', 2 * 60);
	}


	public function ensure_scheme($url) {
		return preg_replace("/(http(s)?:\/\/|\/\/)(.*)/i", "http$2://$3", $url);
	}


	public static function local() {
		global $ic_running;

		if (is_admin() || strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
			return;
		}

		if ( ! empty($_GET['ignore_ic'])) {
			return;
		}

		$settings     = get_option(WPS_IC_SETTINGS);
		$options      = get_option(WPS_IC_OPTIONS);
		$response_key = $options['response_key'];
		if (empty($response_key)) {
			return;
		}

		self::$isAjax = (function_exists("wp_doing_ajax") && wp_doing_ajax()) || (defined('DOING_AJAX') && DOING_AJAX);

		// Don't run in admin side!
		if ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize.php") {
			return true;
		}

		// TODO: Check this for wpadmin and frontend ajax
		if ( ! self::$isAjax) {
			if (wp_is_json_request() || is_admin() || ! empty($_GET['trp-edit-translation']) || ! empty($_GET['elementor-preview']) || ! empty($_GET['preview']) || ! empty($_GET['PageSpeed']) || ( ! empty($_GET['fl_builder']) || isset($_GET['fl_builder'])) || ! empty($_GET['et_fb']) || ! empty($_GET['ct_builder']) || ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize.php")) {
				return;
			}
		}

		if ( ! is_admin()) {
			if (empty($settings['live-cdn']) || $settings['live-cdn'] == '0') {
				self::buffer_local_go();
			}
		}

	}


	public static function buffer_local_go() {

		if (self::$isAjax) {
			$wps_ic_cdn = new wps_addon_cdn();
		}

		if (self::$speed_test) {
			self::$is_retina = 'false';
		}

		ob_start(array(__CLASS__, 'buffer_local_callback'));
	}


	public static function init() {
		global $ic_running;
		self::$logger = new wps_ic_logger();
		self::$logger->log('Init Start');

		add_filter('upgrader_post_install', array('wps_ic_cache', 'update_css_hash'), 1);
		add_action('upgrader_process_complete', array('wps_ic_cache', 'update_css_hash'), 1);

		if (strpos($_SERVER['REQUEST_URI'], '.xml') !== false) {
			return;
		}

		if (is_admin() || strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
			return;
		}

		if ($ic_running) {
			self::$logger->log('Already Running');

			return;
		}

		$ic_running = true;

		if ( ! empty($_GET['ignore_cdn']) || ! empty($_GET['ignore_ic'])) {
			return;
		}

		$settings = get_option(WPS_IC_SETTINGS);
		if ( ! empty($settings['live-cdn']) && $settings['live-cdn'] == '0') {
			return;
		}

		$options      = get_option(WPS_IC_OPTIONS);
		$response_key = $options['response_key'];
		if (empty($response_key)) {
			return;
		}

		self::$isAjax = (function_exists("wp_doing_ajax") && wp_doing_ajax()) || (defined('DOING_AJAX') && DOING_AJAX);

		// Don't run in admin side!
		if ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize.php") {
			return true;
		}

		// TODO: Check this for wpadmin and frontend ajax
		if ( ! self::$isAjax) {
			if (wp_is_json_request() || is_admin() || ! empty($_GET['trp-edit-translation']) || ! empty($_GET['elementor-preview']) || ! empty($_GET['preview']) || ! empty($_GET['PageSpeed']) || ( ! empty($_GET['fl_builder']) || isset($_GET['fl_builder'])) || ! empty($_GET['et_fb']) || ! empty($_GET['ct_builder']) || ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize.php")) {
				return;
			}
		}

		if ( ! empty(self::$settings['css']) || ! empty(self::$settings['js'])) {
			#$simple_cdn = new wps_cdn_replace();
		}

		add_filter('get_site_icon_url', array('wps_addon_cdn', 'favicon_replace'), 10, 1);

		if ( ! is_admin()) {
			if ( ! empty($settings['live-cdn']) && $settings['live-cdn'] == '1') {
				self::$logger->log('Init Run');
				self::buffer_go();
			}
			else {
				self::$logger->log('Init did NOT Run - live_cdn disabled');
			}
		}
		else {
			self::$logger->log('Init did NOT Run - in admin area?');
		}

	}


	public static function buffer_go() {

		if (self::$isAjax) {
			$wps_ic_cdn = new wps_addon_cdn();
		}

		if (self::$speed_test) {
			self::$is_retina = 'false';
		}

		self::$logger->log('Ob Start Run');
		ob_start(array(__CLASS__, 'buffer_callback'));
	}


	public static function favicon_replace($url) {
		if (empty($url)) {
			return $url;
		}

		if (strpos($url, self::$zone_name) !== false) {
			return $url;
		}

		$url = 'https://' . self::$zone_name . '/minify:false/asset:' . self::reformat_url($url);

		return $url;
	}


	public static function reformat_url($url, $remove_site_url = false) {

		// Check if url is maybe a relative URL (no http or https)
		if (strpos($url, 'http') === false) {
			// Check if url is maybe absolute but without http/s
			if (strpos($url, '//') === 0) {
				// Just needs http/s
				$url .= 'https:' . $url;
			}
			else {
				$url = str_replace('../wp-content', 'wp-content', $url);
				$url_replace  = str_replace('/wp-content', 'wp-content', $url);
				$url = self::$site_url;
				$url = rtrim($url, '/');
				$url .= '/' . $url_replace;
			}
		}

		$parse  = parse_url($url);
		$scheme = str_replace(array('http://', 'https://'), '', self::$site_url_scheme); // Remove ://!!!!
		$host   = '';
		$path   = '';

		if ( ! empty($parse['scheme'])) {
			// Not empty http or https
			$scheme = $parse['scheme'];
		}

		if ( ! empty($parse['host'])) {
			// Not empty http or https
			$host = $parse['host'];
		}

		if ( ! empty($parse['path'])) {
			// Not empty http or https
			$path = $parse['path'];
		}

		if ( ! empty($path) && ! empty($host)) {
			$formatted_url = $scheme . '://' . $host . $path;
		}
		else {
			$formatted_url = $url;
		}

		if (strpos($formatted_url, '?brizy_media') === false) {
			$formatted_url = explode('?', $formatted_url);
			$formatted_url = $formatted_url[0];
		}

		if ($remove_site_url) {
			$formatted_url = str_replace(self::$site_url, '', $formatted_url);
			$formatted_url = ltrim($formatted_url, '/');
		}

		$query = '';

		if ( ! empty($parse['query'])) {
			#$formatted_url .= '?icv=' . WPS_IC_HASH . '&' . $parse['query'];
			$formatted_url .= '?' . $parse['query'];
		}

		return $formatted_url;
	}


	public static function buffer_local_callback($buffer) {
		self::$image_count = 0;
		//Do something with the buffer (HTML)
		if (isset($_GET['brizy-edit-iframe']) || isset($_GET['brizy-edit']) || isset($_GET['preview'])) {
			return $buffer;
		}

		if (self::$cdnEnabled == 0) {
			#$buffer = preg_replace_callback('/<img[^>]* src=\"([^\"]*)\"[^>]*>/i', array('wps_addon_cdn', 'local_image_tags'), $buffer);
		}

		return $buffer;
	}


	public static function buffer_callback($buffer) {
		self::$image_count = 0;
		self::$logger->log('Inside Buffer Callback');

		if (strpos($_SERVER['REQUEST_URI'], 'xmlrpc') !== false) {
			self::$logger->log(print_r($_SERVER, true));
			self::$logger->log(print_r($_GET, true));
			self::$logger->log(print_r($_POST, true));
			self::$logger->log('XMLRPC Request');

			return $buffer;
		}

		//Do something with the buffer (HTML)
		if (isset($_GET['brizy-edit-iframe']) || isset($_GET['brizy-edit']) || isset($_GET['preview'])) {
			self::$logger->log('Exit - Brizy? Preview?');

			return $buffer;
		}

		if (is_admin() || ! empty($_GET['trp-edit-translation']) || ! empty($_GET['elementor-preview']) || ! empty($_GET['preview']) || ! empty($_GET['PageSpeed']) || ! empty($_GET['et_fb']) || ( ! empty($_GET['fl_builder']) || isset($_GET['fl_builder'])) || ! empty($_GET['ct_builder']) || ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize
		.php")) {
			self::$logger->log('Exit - something #864');

			return $buffer;
		}

		$requestURI = $_SERVER['REQUEST_URI'];
		if (strpos($requestURI, 'wp-json') !== false) {
			self::$logger->log('Exit - wp-json? #870');

			return $buffer;
		}

		if (defined('REST_REQUEST') || ! empty($_GET['apikey']) || ! empty($_GET['comms_action'])) {
			self::$logger->log('Exit - REST Request or apikey or comms #875');

			return $buffer;
		}

		self::$logger->log('Buffer with ' . WPS_IC_REPLACE);
		self::$logger->log($buffer);

		if (self::$cdnEnabled == 1) {

			if (self::$isAjax) {
				return $buffer;
			}

			/**
			 * Run Regexp Search & Replace
			 */
			if (WPS_IC_REPLACE == 'regexp') {
				if (defined('BRIZY_VERSION')) {
					// Brizy Fix
					$site_url = str_replace(array('http://', 'https://', '/', '.'), array('', '', '\/', '\.'), self::$home_url);
					$buffer   = preg_replace_callback('/' . $site_url . '\/?(\?brizy_media=(.[^"\',\s)]*))/i', array('wps_addon_cdn', 'obstart_replace_brizy_url'), $buffer);
				}

				// Other regular Images
				$buffer = preg_replace_callback('/<picture[^>]*>/i', array('wps_addon_cdn', 'picture_tag'), $buffer);
				$buffer = preg_replace_callback('/(data-img-url|data-bg)="([^"]+)"/i', array('wps_addon_cdn', 'data_img_url'), $buffer);
				$buffer = preg_replace_callback('/<amp\-img[^>]* src=\"([^\"]*)\"[^>]*>/i', array('wps_addon_cdn', 'replace_amp_links'), $buffer);
				$buffer = preg_replace_callback('/(<img[^>]*>|https?:[^)\'\'"]+\.(css|jsp|json|js|ico))/i', array('wps_addon_cdn', 'find_all_img_and_links'), $buffer);
				$buffer = preg_replace_callback("/url\(\s*['\"]?(?!['\"]?data:)(.*?)['\"]?\s*\)/i", array('wps_addon_cdn', 'background_image_replace'), $buffer);
				$buffer = preg_replace_callback('/srcset="([^"]+)"/i', array('wps_addon_cdn', 'srcset_replace'), $buffer);

				// Was having issues with <use href="XY"..
				#$buffer = preg_replace_callback('/(?:href|link)=(?:"|\')([^"]+)(?:"|\')/i', array('wps_addon_cdn', 'url_simple_att'), $buffer);

				$buffer = preg_replace_callback('/<(?:link|a)(?:.*)(?:href|link)=(?:"|\')([^"]+)(?:"|\')[^>]/i', array('wps_addon_cdn', 'url_simple_att'), $buffer);
				$buffer = preg_replace_callback('/(?:data-src|data-desktop|data-laptop|data-img|data-srcset)=(?:"|\')([^"]+)(?:"|\')/i', array('wps_addon_cdn', 'url_data_att'), $buffer);

				// Brizy Simple Url Replace => Causing issues with product variations
				if (defined('BRIZY_VERSION')) {
					$buffer = preg_replace_callback('/https?:(\/\/[^"\']*\.(?:png|jpg|jpeg|gif|png|svg))/i', array('wps_addon_cdn', 'obstart_replace_brizy_url_simple'), $buffer);
				}

				self::$logger->log('Replaced Content RegExp #907:');
				self::$logger->log($buffer);

				return $buffer;
			}
			else {
				/**
				 * Run PHP DOM Search & Replace
				 */
				$doc    = new DOMDocument();
				$buffer = mb_convert_encoding($buffer, 'HTML-ENTITIES', 'UTF-8');
				@$doc->loadHtml($buffer);

				if ( ! empty(self::$css) || self::$css == '1') {
					$links = $doc->getElementsByTagName('link');
					if ( ! empty($links)) {
						foreach ($links as $link) {
							$href = $link->getAttribute('href');
							if ( ! empty($href)) {
								// Already optimized, see by url
								if (strpos($href, self::$zone_name) !== false || strpos($href, 'map') !== false) {
									continue;
								}

								self::$logger->log('Replaced DOM CSS: ' . $href);
								$link_replace = self::replace_css($href);
								$link->setAttribute('href', $link_replace);
								self::$logger->log('Replaced DOM CSS: ' . $link_replace);
							}
						}
					}
				}

				if ( ! empty(self::$js) || self::$js == '1') {
					$scripts = $doc->getElementsByTagName('script');
					if ( ! empty($scripts)) {
						foreach ($scripts as $script) {
							$src = $script->getAttribute('src');
							if ( ! empty($src)) {
								// Already optimized, see by url
								if (strpos($src, self::$zone_name) !== false) {
									continue;
								}

								$script_Replace = self::replace_js($src);
								$script->setAttribute('src', $script_Replace);
							}
						}
					}
				}

				//Replace Attrs in Image Tag
				$images = $doc->getElementsByTagName('img');
				if ($images) {
					foreach ($images as $img) {
						$class   = '';
						$is_logo = false;

						// Get Image Source and Replace
						$url            = $img->getAttribute('src');
						$existing_class = $img->getAttribute('class');

						// Find Parents
						$parent       = $img->parentNode;
						$parent_id    = $parent->getAttribute('id');
						$parent_class = $parent->getAttribute('class');

						if (strpos($parent_id, 'logo') !== false || strpos($parent_class, 'logo') !== 'false') {
							$is_logo = true;
						}

						// data:image url
						if (strpos($url, 'data:image') !== false) {
							continue;
						}

						// Already optimized, see by url
						if (strpos($url, self::$zone_name) !== false) {
							continue;
						}

						// Already optimized, see by class
						if (strpos($existing_class, 'wps-ic-live-cdn') !== false) {
							continue;
						}

						if ( ! empty($url)) {
							if (strpos($url, 'logo') !== false) {
								$is_logo = true;
							}
						}

						if ( ! empty($existing_class) && ! $is_logo) {
							if (strpos($existing_class, 'logo') !== false) {
								$is_logo = true;
							}
						}

						$url = self::replace_src($url, self::$adaptive_enabled);

						if ( ! empty(self::$lazy_enabled) && self::$lazy_enabled == '1' && ! $is_logo) {
							if ( ! empty($url['placeholder'])) {
								$img->setAttribute('src', $url['placeholder']);
								$img->setAttribute('data-src', $url['src']);
							}
						}
						else {
							$img->setAttribute('src', $url['src']);
						}

						if ( ! empty($_GET['dbg_logo'])) {
							$img->setAttribute('is-logo', $is_logo);
							$img->setAttribute('parent-id', $parent_id);
							$img->setAttribute('parent-logo', $parent_class);
						}

						if ( ! empty($_GET['dbg_replace'])) {
							$img->setAttribute('replaced-from', $url['from']);
							$img->setAttribute('replaced-src-url', $url['src-url']);
						}

						$class = 'wps-ic-live-cdn';
						if ( ! empty($existing_class)) {
							$class .= ' ' . $existing_class;
						}

						$img->setAttribute('class', $class);

						// Get Image SrcSet and Replace
						$srcset = $img->getAttribute('srcset');
						if ( ! empty($srcset)) {
							$newsrcset = self::replace_srcset($srcset);
							if ( ! empty($newsrcset)) {
								$img->setAttribute('srcset', $newsrcset);
							}
						}
					}
				}

				$pictures = $doc->getElementsByTagName('picture');
				if ($pictures) {
					foreach ($pictures as $picture) {
						//Replace Src in Sources
						$sources = $picture->getElementsByTagName('source');
						foreach ($sources as $source) {
							$srcset    = $source->getAttribute('srcset');
							$newsrcset = self::replace_srcset($srcset);
							if ( ! empty($newsrcset)) {
								$source->setAttribute('srcset', $newsrcset);
							}
						}
					}
				}

				$buffered_content = @$doc->saveHTML();

				$buffered_content = preg_replace_callback('/https?:(\/\/[^"\']*\.(?:png|jpg|jpeg|gif|png|svg))/i', array('wps_addon_cdn', 'image_url_replace'), $buffered_content);
				$buffered_content = preg_replace_callback('/[^"\'=\s]+\.(jpe?g|png|gif)/i', array('wps_addon_cdn', 'image_url_replace'), $buffered_content);

				self::$logger->log('Replaced Content DOM #1062:');
				self::$logger->log($buffered_content);

				return $buffered_content;
			}
		}
		else {
			self::$logger->log('Buffer Callback CDN Disabled');
		}

	}


	public static function replace_css($link) {
		// File has already been replaced
		if (strpos($link, self::$zone_name) !== false || strpos($link, 'schema') !== false || strpos($link, 'fbcdn.net') !== false || strpos($link, 'typekit') !== false || strpos($link, 'google') !== false) {
			return $link;
		}

		// Is it an image extension?
		if ( ! self::is_css($link)) {
			return $link;
		}

		// Is the image url on same site url?
		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($link)) {
			return $link;
		}

		if (strpos($link, '?') !== false) {
			$link .= '&icv=' . WPS_IC_HASH;
		}
		else {
			$link .= '?icv=' . WPS_IC_HASH;
		}

		$apiURL = 'https://' . self::$zone_name . '/minify:true/asset:' . self::reformat_url($link);

		return $apiURL;
	}


	public static function is_css($link) {
		if (strpos($link, '.css.map') !== false) {
			return false;
		}

		if (strpos($link, '.css') === false) {
			return false;
		}
		else {
			return true;
		}
	}


	public static function image_url_matching_site_url($image) {
		$site_url = self::$site_url;
		$image    = str_replace(array('https://', 'http://'), '', $image);
		$site_url = str_replace(array('https://', 'http://'), '', $site_url);

		if (strpos($image, 'redditstatic') !== false) {
			// Image does not match site
			return false;
		}

		if (strpos($image, $site_url) === false) {
			// Image not on site
			return false;
		}
		else {
			// Image on site
			return true;
		}

	}


	public static function replace_js($link) {
		// File has already been replaced
		if (strpos($link, self::$zone_name) !== false || strpos($link, 'schema') !== false || strpos($link, 'fbcdn.net') !== false || strpos($link, 'typekit') !== false || strpos($link, 'google') !== false) {
			return $link;
		}

		// Is it an image extension?
		if ( ! self::is_js($link)) {
			return $link;
		}

		// Is the image url on same site url?
		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($link)) {
			return $link;
		}

		$apiURL = 'https://' . self::$zone_name . '/minify:true/asset:' . self::reformat_url($link);

		return $apiURL;
	}


	public static function is_js($link) {
		if (strpos($link, '.js') === false) {
			return false;
		}
		else {
			return true;
		}
	}


	public static function is_relative_url($url) {
		if (strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
			// No http on start, try to figure out
			$url = explode('wp-content', $url);
			$url = '/wp-content' . $url[1];
			$url = self::$site_url . $url;

			// New, maybe working?
			#$url = str_replace('../wp-content', 'wp-content', $url);
			#$url = str_replace('/wp-content', 'wp-content', $url);
			#$url = self::$site_url . '/' . $url;

			return $url;
		}
		else {
			return false;
		}
	}


	public static function replace_src($src, $adaptive = false) {

		// File has already been replaced
		if (strpos($src, self::$zone_name) !== false || strpos($src, 'schema') !== false || strpos($src, 'data:image') !== false || strpos($src, 'fbcdn.net') !== false || strpos($src, 'google') !== false) {
			return array('src' => $src);
		}

		$is_relative = self::is_relative_url($src);
		if ($is_relative !== false) {
			$src = $is_relative;
		}

		// Is it an image extension?
		if ( ! self::is_image($src)) {
			return array('src' => $src, 'from' => 'is_image', 'src-url' => $src);
		}

		// File is excluded
		if (self::is_excluded($src)) {
			return array('src' => $src, 'from' => 'is_excluded', 'src-url' => $src);
		}

		// Is the image url on same site url?
		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($src)) {
			return array('src' => $src, 'from' => 'external_url_enabled', 'src-url' => $src);
		}

		// Is it a speedtest?
		if (self::$speed_test) {
			$size = array(320, 320);
		}
		else {
			$size = self::get_image_size($src);

			if (empty($size) || ($size[0] < 10 || $size[1] < 10)) {
				$size = array(1920, 1920);
			}
		}

		/**
		 * If Adaptive is ON, figure out the original image
		 */
		if ($adaptive && $adaptive == true) {
			$src_find = self::get_full_size($src);
			if ( ! empty($src_find[0])) {
				$src = $src_find[0];
			}
		}

		// LazyLoad Placeholder
		$placeholder_svg = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="' . $size[0] . '" height="' . $size[1] . '"><path d="M2 2h' . $size[0] . 'v' . $size[1] . 'H2z" fill="#fff" opacity="0"/></svg>');

		// File has already been replaced
		if (strpos($src, self::$zone_name) !== false || strpos($src, 'schema') !== false || strpos($src, 'fbcdn.net') !== false) {
			return array('placeholder' => $placeholder_svg, 'src' => $src, 'class' => 'wps-ic-live-cdn wps-ic-lazy-image');
		}

		if (self::$speed_test) {
			$apiURL = self::$apiUrl . '/retina:false/webp:' . self::$webp . '/w:320/url:' . self::reformat_url($src);
		}
		else {
			$apiURL = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $size[0] . '/url:' . self::reformat_url($src);
		}

		$return = array('placeholder' => $placeholder_svg, 'src' => $apiURL, 'class' => 'wps-ic-live-cdn wps-ic-lazy-image', 'from' => 'return', 'src-url' => $src);

		return $return;
	}


	public static function is_image($image) {
		if (strpos($image, '.jpg') === false && strpos($image, '.jpeg') === false && strpos($image, '.png') === false && strpos($image, '.ico') === false && strpos($image, '.svg') === false && strpos($image, '.gif') === false) {
			return false;
		}
		else {
			return true;
		}
	}


	public static function is_excluded($image_element, $image_link = '') {
		if (empty($image_link)) {
			preg_match('@src="([^"]+)"@', $image_element, $match_url);
			if ( ! empty($match_url)) {
				$basename_original = basename($match_url[1]);
			}
			else {
				$basename_original = basename($image_element);
			}
		}
		else {
			$basename_original = basename($image_link);
		}

		preg_match("/([0-9]+)x([0-9]+)\.[a-zA-Z0-9]+/", $basename_original, $matches); //the filename suffix way
		if (empty($matches)) {
			// Full Image
			$basename = $basename_original;
		}
		else {
			// Some thumbnail
			$basename = str_replace('-' . $matches[1] . 'x' . $matches[2], '', $basename_original);
		}

		$basename = sanitize_title($basename);
		if ( ! empty(self::$excluded_list) && in_array($basename, self::$excluded_list)) {
			return true;
		}
		else {
			return false;
		}

	}


	public static function get_image_size($url) {
		preg_match("/([0-9]+)x([0-9]+)\.[a-zA-Z0-9]+/", $url, $matches); //the filename suffix way
		if (isset($matches[1]) && isset($matches[2])) {
			return array($matches[1], $matches[2]);
			$sizes = array($matches[1], $matches[2]);
		}
		elseif ( ! $sizes = self::url_to_path_to_sizes($url)) { //the file

			return array(1024, 1024);
			$sizes = self::url_to_metadata_to_sizes($url);//the DB
		}

		return $sizes;
	}


	public static function url_to_path_to_sizes($image_url) {
		$updir          = self::$updir;
		$baseUrlPattern = "/" . str_replace("/", "\/", preg_replace("/^http[s]{0,1}:\/\//", "^http[s]{0,1}://", $updir['baseurl'])) . "/";

		if (preg_match($baseUrlPattern, $image_url)) {
			$path = preg_replace($baseUrlPattern, $updir['basedir'], $image_url);
		}
		elseif ($image_url[0] == '/') {
			$path = dirname(dirname($updir['basedir'])) . $image_url;
		}
		else {
			$path = dirname(dirname($updir['basedir'])) . '/' . $image_url;
		}

		if (file_exists($path)) {
			return getimagesize($path);
		}

		return false;
	}


	public static function url_to_metadata_to_sizes($image_url) {
		// Thx to https://github.com/kylereicks/picturefill.js.wp/blob/master/inc/class-model-picturefill-wp.php
		global $wpdb;
		$prefix             = $wpdb->prefix;
		$sql                = "SELECT m.meta_value FROM {$prefix}posts p INNER JOIN {$prefix}postmeta m on p.id = m.post_id WHERE m.meta_key = '_wp_attachment_metadata' AND ";
		$original_image_url = $image_url;
		$image_url          = preg_replace('/^(.+?)(-\d+x\d+)?\.(jpg|jpeg|png|gif)((?:\?|#).+)?$/i', '$1.$3', $image_url);
		$meta               = $wpdb->get_var($wpdb->prepare("$sql p.guid='%s';", $image_url));

		//try the other proto (https - http) if full urls are used
		if (empty($meta) && strpos($image_url, 'http://') === 0) {
			$image_url_other_proto = strpos($image_url, 'https') === 0 ? str_replace('https://', 'http://', $image_url) : str_replace('http://', 'https://', $image_url);
			$meta                  = $wpdb->get_var($wpdb->prepare("$sql p.guid='%s';", $image_url_other_proto));
		}

		//try using only path
		if (empty($meta)) {
			$image_path = parse_url($image_url, PHP_URL_PATH); //some sites have different domains in posts guid (site changes, etc.)
			//keep only the last two elements of the path because some CDN's add path elements in front ( Google Cloud adds the project name, etc. )
			$image_path_elements = explode('/', $image_path);
			$image_path_elements = array_slice($image_path_elements, max(0, count($image_path_elements) - 3));
			$meta                = $wpdb->get_var($wpdb->prepare("$sql p.guid like'%%%s';", implode('/', $image_path_elements)));
		}

		//try using the initial URL
		if (empty($meta)) {
			$meta = $wpdb->get_var($wpdb->prepare("$sql p.guid='%s';", $original_image_url));
		}

		if ( ! empty($meta)) { //get the sizes from meta
			$meta = unserialize($meta);
			if (preg_match("/" . preg_quote($meta['file'], '/') . "$/", $original_image_url)) {
				return array($meta['width'], $meta['height']);
			}
			foreach ($meta['sizes'] as $size) {
				if ($size['file'] == wp_basename($original_image_url)) {
					return array($size['width'], $size['height']);
				}
			}
		}

		return array(1, 1);
	}


	public static function get_full_size($url) {
		$attachmentID = self::attachment_url_to_id($url);

		if ($attachmentID == 0 || ! $attachmentID) {
			return false;
		}

		$attachmentSRC = wp_get_attachment_image_src($attachmentID, 'full');

		if ( ! $attachmentSRC || empty($attachmentSRC)) {
			return false;
		}

		// Check is it absolute or relative URL
		if (strpos($attachmentSRC[0], 'http') === false) {
			// Check if url is maybe absolute but without http/s
			if (strpos($attachmentSRC[0], '//') === 0) {
				// Just needs http/s
				$attachmentSRC[0] .= 'https:' . $attachmentSRC[0];
			}
			else {
				$attachmentSRC[0] = str_replace('../wp-content', 'wp-content', $attachmentSRC[0]);
				$url_replace  = str_replace('/wp-content', 'wp-content', $attachmentSRC[0]);
				$attachmentSRC[0] = self::$site_url;
				$attachmentSRC[0] = rtrim($attachmentSRC[0], '/');
				$attachmentSRC[0] .= '/' . $url_replace;
			}
		}

		#$attachmentSRC[0] = urlencode($attachmentSRC[0]);

		return $attachmentSRC;
	}


	/**
	 * Finds the attachment ID by taking the attachment URL and searching through
	 * database for that URL.
	 *
	 * @param $attachment_url
	 *
	 * @return bool|string|void|null
	 */
	public static function attachment_url_to_id($attachment_url, $ignore_size = false) {
		global $wpdb;

		$initial_attachment_url = $attachment_url;
		$https                  = strpos($attachment_url, 'https://');
		$http                   = strpos($attachment_url, 'http://');

		if ( ! $ignore_size) {
			preg_match('/([0-9]+)x([0-9]+)\.(jpg|png|jpeg|gif)/', $attachment_url, $matches);
			if ( ! empty($matches)) {
				// Image is not full
				$image_size     = $matches[0];
				$attachment_url = str_replace(array('-' . $image_size, $image_size), '', $attachment_url) . '.' . $matches[3];
			}
		}

		$attID = attachment_url_to_postid($attachment_url);
		if ($attID && $attID > 0) {
			return $attID;
		}
		else {

			if ($https !== false) {
				// It was HTTPS, turn to http
				$attachment_url = str_replace('https', 'http', $attachment_url);
			}
			else {
				$attachment_url = str_replace('http', 'https', $attachment_url);
			}

			$attID = attachment_url_to_postid($attachment_url);
			if ($attID && $attID > 0) {
				return $attID;
			}
		}

		// If there is no url, return.
		if ($attachment_url == '') {
			return;
		}

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		#$attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
		$attachment_id = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment_url));
		if ( ! $attachment_id) {
			$https = strpos($attachment_url, 'https://');
			$http  = strpos($attachment_url, 'http://');

			if ($https !== false) {
				// It was HTTPS, turn to http
				$attachment_url = str_replace('https', 'http', $attachment_url);
			}
			else {
				$attachment_url = str_replace('http', 'https', $attachment_url);
			}

			$attachment_id = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment_url));
		}

		if ( ! $attachment_id || ! $attachment_id[0]) {
			if ( ! $ignore_size) {
				return self::attachment_url_to_id($initial_attachment_url, true);
			}

			return 0;
		}
		else {

		}

		return $attachment_id[0];

	}


	public static function replace_srcset($srcset) {
		$newsrcset = '';

		$urls = explode(',', $srcset);
		if ( ! empty($urls) && is_array($urls)) {
			foreach ($urls as $i => $url) {
				$url         = trim($url);
				$url_explode = explode(' ', $url);
				$url_find    = trim($url_explode[0]);
				$output      = self::replace_src($url_find);
				$newsrcset   .= $output['src'] . ' ' . $url_explode[1] . ',';
			}

			$newsrcset = rtrim($newsrcset, ',');
		}

		if ( ! empty($newsrcset)) {
			return $newsrcset;
		}
		else {
			return $srcset;
		}
	}


	public static function picture_tag($picture) {
		$class_Addon = 'wps-ic-picture-tag';

		// Get All Atts
		preg_match_all('/class=(["|\'][^"|\']*["|\'])/', $picture[0], $regex_atts);

		if ( ! empty($regex_atts[0])) {
			$other_classes = '';
			if ( ! empty($regex_atts[0][0])) {
				$class = $regex_atts[0][0];
				$class = str_replace(array('class="', 'class=\''), '', $class);
				$class = str_replace(array('"', '\''), '', $class);

				$other_classes = $class;
			}

			$new_class = 'class="' . $other_classes . ' ' . $class_Addon . '"';
		}
		else {
			$new_class = 'class="' . $class_Addon . '"';
		}

		self::$image_count ++;
		$picture[0] = str_replace($regex_atts[0], $new_class, $picture[0]);

		return $picture[0];
	}


	public static function is_cached_html($data) {
		$cache_file = WPS_IC_CACHE . $data['file'] . '.txt';
		if (file_exists($cache_file)) {
			return file_get_contents($cache_file);
		}
		else {
			return false;
		}
	}


	public static function create_cache_file($data) {
		$cache_file = WPS_IC_CACHE . $data['file'] . '.txt';
		$fp         = fopen($cache_file, 'w+');
		file_put_contents($cache_file, $data['content']);
		fclose($fp);
	}


	public static function update_image_stats() {
		if ( ! empty($_GET['apikey']) && ! empty($_GET['imageURL'])) {
			$get_apikey      = sanitize_text_field($_GET['apikey']);
			$image_url       = sanitize_text_field($_GET['imageURL']);
			$compressed_size = sanitize_text_field($_GET['compressed_size']);
			$original_size   = sanitize_text_field($_GET['original_size']);
			$quality         = sanitize_text_field($_GET['quality']);

			if (strpos($image_url, self::$zone_name) !== false) {
				$image_url = explode('url:', $image_url);
				$image_url = $image_url[1];
			}

			$options = get_option(WPS_IC_OPTIONS);
			$apikey  = $options['api_key'];
			if ($apikey !== $get_apikey) {
				wp_send_json_error('Bad Api Key.');
			}

			$attachmentID       = self::attachment_url_to_id($image_url);
			$savings            = $original_size - $compressed_size;
			$savings_percentage = (1 - ($compressed_size / $original_size)) * 100;

			update_post_meta($attachmentID, 'wps_ic_noncompressed_size', $original_size);
			update_post_meta($attachmentID, 'wps_ic_compressed_size', $compressed_size);
			update_post_meta($attachmentID, 'wps_ic_data_live', array('saved' => $savings, 'saved_percent' => $savings_percentage, 'quality' => $quality));

			die('Updated Att ID ' . $attachmentID);
		}
	}


	public function change_content_src($content) {
		if (is_admin() || empty($content)) {
			self::$logger->log('Change Content SRC not running');

			return $content;
		}

		self::$logger->log('Change Content SRC is running with method ' . WPS_IC_REPLACE);
		self::$logger->log($content);
		if (WPS_IC_REPLACE == 'regexp') {
			if (defined('BRIZY_VERSION')) {
				// Brizy Fix
				$site_url = str_replace(array('http://', 'https://', '/', '.'), array('', '', '\/', '\.'), self::$home_url);
				$content  = preg_replace_callback('/' . $site_url . '\/?(\?brizy_media=(.[^"\',\s)]*))/i', array('wps_addon_cdn', 'obstart_replace_brizy_url'), $content);
			}

			// Other regular Images
			$content = preg_replace_callback('/<picture[^>]*>/i', array('wps_addon_cdn', 'picture_tag'), $content);
			$content = preg_replace_callback('/(data-img-url|data-bg)="([^"]+)"/i', array('wps_addon_cdn', 'data_img_url'), $content);
			$content = preg_replace_callback('/<amp\-img[^>]* src=\"([^\"]*)\"[^>]*>/i', array('wps_addon_cdn', 'replace_amp_links'), $content);
			$content = preg_replace_callback('/(<img[^>]*>|https?:[^)\'\'"]+\.(css|jsp|json|js|ico))/i', array('wps_addon_cdn', 'find_all_img_and_links'), $content);
			$content = preg_replace_callback("/url\(\s*['\"]?(?!['\"]?data:)(.*?)['\"]?\s*\)/i", array('wps_addon_cdn', 'background_image_replace'), $content);
			$content = preg_replace_callback('/srcset="([^"]+)"/i', array('wps_addon_cdn', 'srcset_replace'), $content);

			$content = preg_replace_callback('/<(?:link|a)(?:.*)(?:href|link)=(?:"|\')([^"]+)(?:"|\')[^>]/i', array('wps_addon_cdn', 'url_simple_att'), $content);
			$content = preg_replace_callback('/(?:data-src|data-desktop|data-laptop|data-img|data-srcset)=(?:"|\')([^"]+)(?:"|\')/i', array('wps_addon_cdn', 'url_data_att'), $content);

			// Causing issues with use href="xy"
			#$content = preg_replace_callback('/https?:(\/\/[^"\']*\.(?:png|jpg|jpeg|gif|png|svg))/i', array('wps_addon_cdn', 'url_simple'), $content);

			// Brizy Simple Url Replace => Causing issues with product variations
			if (defined('BRIZY_VERSION')) {
				$content = preg_replace_callback('/[^"\s]+\.(jpe?g|png|gif|svg)/i', array('wps_addon_cdn', 'obstart_replace_brizy_url_simple'), $content);
			}

			self::$logger->log('Replaced Content with the_content - regexp #1607');
			self::$logger->log($content);

			return $content;
		}
		else {
			//Load HTML to php
			$doc = new DOMDocument();
			libxml_use_internal_errors(true);
			$buffer = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
			@$doc->loadHtml($buffer);
			libxml_clear_errors();

			//Replace Attrs in Image Tag
			$images = $doc->getElementsByTagName('img');
			$count  = 0;
			if ($images) {
				foreach ($images as $img) {
					$class   = '';
					$is_logo = false;

					$count ++;
					// Get Image Source and Replace
					$url            = $img->getAttribute('src');
					$existing_class = $img->getAttribute('class');

					// data:image url
					if (strpos($url, 'data:image') !== false) {
						continue;
					}

					if (strpos($url, self::$zone_name) !== false) {
						continue;
					}

					if ( ! empty($url)) {
						if (strpos($url, 'logo') !== false) {
							$is_logo = true;
						}
					}

					if ( ! empty($existing_class) && ! $is_logo) {
						if (strpos($existing_class, 'logo') !== false) {
							$is_logo = true;
						}
					}

					$original_url = $url;
					$url          = self::replace_src($url, self::$adaptive_enabled);

					if ( ! empty(self::$lazy_enabled) && self::$lazy_enabled == '1' && ! $is_logo) {
						if ( ! empty($url['placeholder'])) {
							$img->setAttribute('src', $url['placeholder']);
							$img->setAttribute('data-src', $url['src']);
						}
					}
					else {
						$img->setAttribute('src', $url['src']);
					}

					if ( ! empty($_GET['dbg_replace'])) {
						$img->setAttribute('replaced-from', $url['from']);
						$img->setAttribute('replaced-src-url', $url['src-url']);
						$img->setAttribute('replaced-original-url', $original_url);
					}

					$class = 'wps-ic-live-cdn';
					if ( ! empty($existing_class)) {
						$class .= ' ' . $existing_class;
					}

					$img->setAttribute('class', $class);

					// Get Image SrcSet and Replace
					$srcset = $img->getAttribute('srcset');
					if ( ! empty($srcset)) {
						$newsrcset = self::replace_srcset($srcset);
						if ( ! empty($newsrcset)) {
							$img->setAttribute('srcset', $newsrcset);
						}
					}
				}
			}

			$saved = @$doc->saveHTML();
			self::$logger->log('Replaced Content with DOM at #1682');
			self::$logger->log($saved);

			return $saved;
		}
	}


	public function change_image_srcset($sources) {
		if (is_admin()) {
			return $sources;
		}

		//Replace Sources
		foreach ($sources as &$source) {
			if ( ! file_exists($source['url'])) {
				$new_image_url = self::replace_src($source['url']);
				$source['url'] = $new_image_url['src'];
			}
		}

		return $sources;
	}


	public function change_attachment_image_src($image) {
		if ( ! empty($_POST) || is_admin()) {
			return $image;
		}

		if (empty($image) || empty($image[0])) {
			return $image;
		}

		if (strpos($image[0], self::$zone_name) !== false || strpos($image[0], 'schema') !== false || strpos($image[0], 'data:image') !== false || strpos($image[0], 'fbcdn.net') !== false) {
			return $image;
		}

		if (strpos($image[0], '.jpg') !== false || strpos($image[0], '.jpeg') !== false || strpos($image[0], '.png') !== false || strpos($image[0], '.ico') !== false || strpos($image[0], '.svg') !== false || strpos($image[0], '.gif') !== false) {
			return $image;
		}

		if ( ! empty($_GET['dbg_filter'])) {
			return print_r($image, true);
		}

		return $image;
		//Replace url
		$src      = self::replace_src($image[0]);
		$image[0] = $src['src'];

		return $image;
	}


	public function data_img_url($image) {
		$data_image_url = $image[2];
		$data_tag       = $image[1];

		if ( ! empty($data_image_url)) {
			if (strpos($image[0], self::$zone_name) !== false || strpos($image[0], 'schema') !== false || strpos($image[0], 'data:image') !== false || strpos($image[0], 'fbcdn.net') !== false) {
				return $image[0];
			}

			if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg)/', $image[0], $matches)) {
				return $image[0];
			}

			if (self::is_excluded($data_image_url)) {
				return $image[0];
			}

			if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($data_image_url)) {
				return $image[0];
			}

			$size = self::get_image_size($data_image_url);
			if ( ! empty(self::$defined_resolution)) {
				if ($size[0] > self::$defined_resolution) {
					$size[0] = self::$defined_resolution;
				}
			}

			$apiURL = $data_tag . '="https://' . self::$zone_name . '/minify:false/asset:' . self::reformat_url($data_image_url) . '"';

			return $apiURL;
		}
	}


	public function srcset_replace($image) {
		$srcset = $image[0];

		if (strpos($_SERVER['REQUEST_URI'], 'embed') !== false) {
			return $image[0];
		}

		if ( ! empty($srcset)) {
			preg_match_all('/((https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|svg))\s(\d{1,5})/', $srcset, $srcset_links);

			if ( ! empty($srcset_links)) {
				foreach ($srcset_links[1] as $i => $srcset_url) {
					$find_image = $srcset_url;
					$width      = $srcset_links[4][ $i ];

					if (self::$speed_test && $width >= 700) {
						continue;
					}

					if (strpos($srcset_url, 'http') === false && strpos($srcset_url, 'https') === false) {
						$srcset_url = self::$site_url_scheme . '://' . $srcset_url;
					}

					if (strpos($srcset_url, self::$zone_name) !== false) {
						continue;
					}

					if (self::$speed_test && self::$image_count >= self::$speed_test_img_count_limit) {
						$srcset_replace = 'data:image/svg+xml;charset=UTF-8,base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAwIiBoZWlnaHQ9IjEwMDAiPjxwYXRoIGQ9Ik0yIDJoMTAwMHYxMDAwSDJ6IiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwIi8+PC9zdmc+';
					}
					else {
						$srcset_replace = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $width . '/url:' . $srcset_url;
					}

					$srcset = str_replace($find_image, $srcset_replace, $srcset);
				}
			}
		}

		return $srcset;
	}


	public function filter_Woo_gallery_html($html, $attachment_id) {
		// filter...
		$html = preg_replace_callback('/(https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|svg)/', array('wps_addon_cdn', 'obstart_replace_url_in_css'), $html);

		return $html;
	}


	public function filter_Woo_gallery($array, $attachment_id, $image_size, $main_image) {
		// filter...

		return $array;
	}


	public function remove_whitespace($css) {
		// preserve empty comment between property and value
		// http://css-discuss.incutio.com/?page=BoxModelHack
		$css = preg_replace('@/\\*\\s*\\*/\\s*:@', '/*keep*/:', $css);
		$css = preg_replace('@:\\s*/\\*\\s*\\*/@', ':/*keep*/', $css);

		// apply callback to all valid comments (and strip out surrounding ws
		$pattern = '@\\s*/\\*([\\s\\S]*?)\\*/\\s*@';
		$css     = preg_replace_callback($pattern, array($this, 'commentCB'), $css);

		// remove ws around { } and last semicolon in declaration block
		$css = preg_replace('/\\s*{\\s*/', '{', $css);
		$css = preg_replace('/;?\\s*}\\s*/', '}', $css);

		// remove ws surrounding semicolons
		$css = preg_replace('/\\s*;\\s*/', ';', $css);

		// replace any ws involving newlines with a single newline
		$css = preg_replace('/[ \\t]*\\n+\\s*/', "", $css);

		return trim($css);
	}


	public function commentCB($m) {
		$hasSurroundingWs = (trim($m[0]) !== $m[1]);
		$m                = $m[1];
		// $m is the comment content w/o the surrounding tokens,
		// but the return value will replace the entire comment.
		if ($m === 'keep') {
			return '/**/';
		}

		if ($m === '" "') {
			// component of http://tantek.com/CSS/Examples/midpass.html
			return '/*" "*/';
		}

		if (preg_match('@";\\}\\s*\\}/\\*\\s+@', $m)) {
			// component of http://tantek.com/CSS/Examples/midpass.html
			return '/*";}}/* */';
		}

		if ($this->_inHack) {
			// inversion: feeding only to one browser
			$pattern = '@
                    ^/               # comment started like /*/
                    \\s*
                    (\\S[\\s\\S]+?)  # has at least some non-ws content
                    \\s*
                    /\\*             # ends like /*/ or /**/
                @x';
			if (preg_match($pattern, $m, $n)) {
				// end hack mode after this comment, but preserve the hack and comment content
				$this->_inHack = false;

				return "/*/{$n[1]}/**/";
			}
		}

		if (substr($m, - 1) === '\\') { // comment ends like \*/
			// begin hack mode and preserve hack
			$this->_inHack = true;

			return '/*\\*/';
		}

		if ($m !== '' && $m[0] === '/') { // comment looks like /*/ foo */
			// begin hack mode and preserve hack
			$this->_inHack = true;

			return '/*/*/';
		}

		if ($this->_inHack) {
			// a regular comment ends hack mode but should be preserved
			$this->_inHack = false;

			return '/**/';
		}

		// Issue 107: if there's any surrounding whitespace, it may be important, so
		// replace the comment with a single space
		return $hasSurroundingWs ? ' ' : ''; // remove all other comments
	}


	public function enqueue_js_print() {
		global $post;

		if ((empty(self::$settings['js']) && self::$settings['js'] == '0')) {
			return;
		}

		wp_scripts(); //ensure styles is initialised
		global $wp_scripts;

		if (isset($_GET['brizy-edit-iframe']) || isset($_GET['brizy-edit']) || isset($_GET['preview'])) {
			return;
		}

		if (is_admin() || ! empty($_GET['trp-edit-translation']) || ! empty($_GET['elementor-preview']) || ! empty($_GET['PageSpeed']) || ( ! empty($_GET['fl_builder']) || isset($_GET['fl_builder'])) || ! empty($_GET['et_fb']) || ! empty($_GET['ct_builder']) || ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize
		.php")) {
			return;
		}

		$frontend = rtrim(ABSPATH, '/');
		if ( ! $frontend) {
			$frontend = parse_url(get_option('home'));
			$frontend = ! empty($frontend['path']) ? $frontend['path'] : '';
			$frontend = $_SERVER['DOCUMENT_ROOT'] . $frontend;
		}

		$frontend          = realpath($frontend);
		$modified_js_files = array();

		// Print all loaded Styles (CSS)
		foreach ($wp_scripts->queue as $script) {

			if ($script == 'admin-bar') {
				continue;
			}

			$deps   = $script->registered[ $script ]->deps;
			$handle = $script->registered[ $script ]->handle;
			$js_url = $script->registered[ $script ]->src;
			$extra  = $script->registered[ $script ]->extra;
			$after  = $extra['after'];

			// We already did this file
			if (isset($modified_js_files[ $post->ID ][ $handle ]) && ! empty($modified_js_files[ $post->ID ][ $handle ])) {
				continue;
			}

			if (strpos($js_url, self::$site_url) === false && preg_match('/(\/wp-content\/[^\"\'=\s]+\.(css|js))/', $js_url) == 0 && preg_match('/(\/wp-includes\/[^\"\'=\s]+\.(css|js))/', $js_url) == 0) {
				continue;
			}

			$css_basename = basename($js_url);
			$css_basename = explode('?', $css_basename);
			$css_basename = $css_basename[0];

			if ($css_basename == 'retina.js' || $css_basename == 'retina') {
				continue;
			}

			$css_path = str_replace(self::$site_url . '/', '', $js_url);
			$css_path = explode('?', $css_path);
			$css_path = ABSPATH . $css_path[0];

			$js_md5_original = filesize($css_path);
			if (in_array($handle, $modified_js_files)) {
				// In array, check if changed
				$js_old_m5 = $modified_js_files[ $post->ID ][ $handle ]['size'];
				if ($js_md5_original !== $js_old_m5) {
					// File has changed
					$modified_js_files[ $post->ID ][ $handle ]['size'] = $js_md5_original;
				}
				else {
					// Do nothing;
					continue;
				}
			}
			else {
				// Not in array
				$modified_js_files[ $post->ID ][ $handle ]['size'] = $js_md5_original;
			}

			$modified_js_files[ $post->ID ][ $handle ]['cdn_url'] = 'https://' . self::$zone_name . '/' . $js_url;

			wp_deregister_script($script);
			wp_deregister_style($handle);
			wp_dequeue_style($script);
			wp_dequeue_style($handle);
		}

		// Works, if no combine is enabled
		if ( ! empty($modified_js_files)) {
			foreach ($modified_js_files as $postID => $data) {
				foreach ($data as $handle => $js_file) {
					if (is_array($js_file['deps']) && ! empty($js_file['deps'])) {
						foreach ($js_file['deps'] as $k => $dep) {
							wp_enqueue_script($dep);
						}
					}

					if (file_exists($js_file['cache_dir_file'])) {
						wp_register_script($handle, $js_file['cdn_uri'], $js_file['deps'], false, 'all');
						wp_enqueue_script($handle);
					}

				}
			}

		}

	}


	public function process_images_from_content($content) {
		$content = preg_replace_callback('/image=["|\']((https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|svg))["|\']/i', array('wps_addon_cdn', 'image_attr_replace'), $content);

		return $content;
	}


	public function replace_amp_links($image) {
		$imageToReplace = $image[1];

		$size = self::get_image_size($imageToReplace);
		if ( ! empty(self::$defined_resolution)) {
			if ($size[0] > self::$defined_resolution) {
				$size[0] = self::$defined_resolution;
			}
		}

		self::$image_count ++;

		if (self::$speed_test && self::$image_count >= self::$speed_test_img_count_limit) {
			$replace_with = 'data:image/svg+xml;charset=UTF-8,base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAwIiBoZWlnaHQ9IjEwMDAiPjxwYXRoIGQ9Ik0yIDJoMTAwMHYxMDAwSDJ6IiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwIi8+PC9zdmc+';
		}
		else {
			$replace_with = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:1/url:' . self::reformat_url($imageToReplace);
		}

		$str_replace = str_replace($imageToReplace, $replace_with, $image[0]);

		return $str_replace;
	}


	public function local_image_tags($image) {
		$image_source = $image[1];

		// File is not an image
		if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg)/', $image_source, $matches)) {
			return $image[0];
		}

		// File is excluded
		if (self::is_excluded($image_source)) {
			#return $image[0];
		}

		$size = self::get_image_size($image_source);
		if ( ! empty(self::$defined_resolution)) {
			if ($size[0] > self::$defined_resolution) {
				// TODO: Search for other mentionings of defined_resolution
				#$size[0] = self::$defined_resolution;
			}
		}

		#return print_r($size, true);

		$svgAPI = $source_svg = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="' . $size[0] . '" height="' . $size[1] . '"><path d="M2 2h' . $size[0] . 'v' . $size[1] . 'H2z" fill="#fff" opacity="0"/></svg>');

		$class_Addon = '';

		// Is LazyLoading enabled in the plugin?
		if ( ! empty(self::$lazy_enabled) && self::$lazy_enabled == '1') {

			// If Logo remove wps-ic-lazy-image
			if (strpos($image_source, 'logo') !== false) {
				$image_tag = 'src="' . $image_source . '"';
			}
			else {
				$image_tag = 'src="' . $svgAPI . '"';
			}

			$image_tag .= ' loading="lazy"';
			$image_tag .= ' data-src="' . $image_source . '"';

			$image_tag .= ' data-width="' . $size[0] . '"';
			$image_tag .= ' data-height="' . $size[1] . '"';

			// If Logo remove wps-ic-lazy-image
			if (strpos($image_source, 'logo') !== false) {
				// Image is for logo
				$class_Addon .= 'wps-ic-local-lazy wps-ic-logo';
			}
			else {
				// Image is not for logo
				$class_Addon .= 'wps-ic-local-lazy wps-ic-lazy-image ';
			}

		}
		else {
			if ( ! empty(self::$adaptive_enabled) && self::$adaptive_enabled == '1') {
				$image_tag = 'src="' . $image_source . '"';
				$image_tag .= ' data-adaptive="true"';
				$image_tag .= ' data-remove-src="true"';
			}
			else {
				$image_tag = 'src="' . $image_source . '"';
				$image_tag .= ' data-adaptive="false"';
			}

			$image_tag .= ' data-src="' . $image_source . '"';
			$image_tag .= ' data-width="' . $size[0] . '"';
			$image_tag .= ' data-height="' . $size[1] . '"';

			$class_Addon .= 'wps-ic-local-no-lazy ';
		}

		$replace = str_replace('src="' . $image_source . '"', $image_tag, $image[0]);

		return $replace;
	}


	public function isExtensionValid($file, $valid = array('css', 'js')) {
		$extension = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($extension, $valid)) {
			return true;
		}
		else {
			return false;
		}
	}


	public function find_all_img_and_links($image) {
		$image_source = $image;

		if (strpos($_SERVER['REQUEST_URI'], 'embed') !== false) {
			return $image[0];
		}

		// File has already been replaced
		if (strpos($image[0], self::$zone_name) !== false || strpos($image[0], 'schema') !== false || strpos($image[0], 'data:image') !== false || strpos($image[0], 'fbcdn.net') !== false) {
			return $image[0];
		}

		// File is not an image
		if ( ! self::is_image($image[0])) {
			if (strpos($image[0], '.jsp') !== false) {
				return $image[0];
			}
			else {
				// If link is CSS or JS
				if (strpos($image[0], '.css') !== false || strpos($image[0], '.js') !== false) {
					return self::obstart_replace_url_simple($image);
				}
				else {
					return $image[0];
				}
			}

		}

		// File is excluded
		if (self::is_excluded($image[0])) {
			return $image[0];
		}

		// Get the image src from data-src if exists
		preg_match('/data-src=["|\']((https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|svg))["|\']/', $image[0], $match_url);

		if (empty($match_url)) {
			// Try different
			preg_match('/data-img-url=["|\']((https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|svg))["|\']/', $image[0], $match_url);
		}

		if (empty($match_url)) {

			// No lazyload data-src does not exist
			preg_match('/src=["|\']((https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|svg))["|\']/', $image[0], $match_url);

		}
		else {

			// Check is it absolute or relative URL
			if (strpos($match_url[1], 'http') === false) {
				// Check if url is maybe absolute but without http/s
				if (strpos($match_url[1], '//') === 0) {
					// Just needs http/s
					$match_url[1] = 'https:' . $match_url[1];
					$image[0] = $match_url[1];
				}
				else {
					$match_url[1] = str_replace('../wp-content', 'wp-content', $match_url[1]);
					$url_replace  = str_replace('/wp-content', 'wp-content', $match_url[1]);
					$match_url[1] = self::$site_url;
					$match_url[1] = rtrim($match_url[1], '/');
					$match_url[1] .= '/' . $url_replace;
					$image[0] = $match_url[1];
				}
			}

		}

		if (empty($match_url)) {
			// srcset="([^"]+)"
			preg_match('/src=["|\']([^"]+)["|\']/', $image[0], $match_url);
		}

		if ( ! empty($match_url)) {

			if (!empty($_GET['dbg']) && $_GET['dbg'] == 'find_all_img_and_links') {
				return print_r($match_url, true);
			}

			// If lazyload data-src exists read that
			$find  = $match_url[1];

			if (!empty($_GET['dbg']) && $_GET['dbg'] == 'find_all_img_and_links_strpos') {
				return print_r(array(strpos($match_url[1], 'http'), strpos($match_url[1], '//')), true);
			}

			// Check is it absolute or relative URL
			if (strpos($match_url[1], 'http') === false) {
				// Check if url is maybe absolute but without http/s
				if (strpos($match_url[1], '//') === 0) {
					// Just needs http/s
					$match_url[1] = 'https:' . $match_url[1];
				}
				else {
					$match_url[1] = str_replace('../wp-content', 'wp-content', $match_url[1]);
					$url_replace  = str_replace('/wp-content', 'wp-content', $match_url[1]);
					$match_url[1] = self::$site_url;
					$match_url[1] = rtrim($match_url[1], '/');
					$match_url[1] .= '/' . $url_replace;
					$replaceURL   = $match_url[1];
					$image[0]     = str_replace($find, $replaceURL, $image[0]);
				}
			}
		}

		/**
		 * If we didn't find any match url from source, fixed on 14th Sept 2020
		 * Because of Admin Bar Icons getting messed up
		 */
		if (empty($match_url)) {
			return $image[0];
		}
		else {
			// If lazyload data-src exists read that
			$find  = $match_url[1];

			// Check is it absolute or relative URL
			if (strpos($match_url[1], 'http') === false) {
				// Check if url is maybe absolute but without http/s
				if (strpos($match_url[1], '//') === 0) {
					// Just needs http/s
					$match_url[1] = 'https:' . $match_url[1];
				}
				else {
					$match_url[1] = str_replace('../wp-content', 'wp-content', $match_url[1]);
					$url_replace  = str_replace('/wp-content', 'wp-content', $match_url[1]);
					$match_url[1] = self::$site_url;
					$match_url[1] = rtrim($match_url[1], '/');
					$match_url[1] .= '/' . $url_replace;
					$replaceURL   = $match_url[1];
					$image[0]     = str_replace($find, $replaceURL, $image[0]);
				}
			}
		}

		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($image[0])) {
			return $image_source[0];
		}

		preg_match_all('/data\-([a-z\_\-]*)=[\'|"](.*?)[\'|"]/', $image_source[0], $match_data);

		$additional_tags = '';
		if ($match_data && ! empty($match_data[0])) {
			$additional_tags = implode(' ', $match_data[0]);
		}

		preg_match_all('/\s(width|height)=[\'|"](.*?)[\'|"]/', $image_source[0], $match_data);

		$width_attr  = '';
		$height_attr = '';
		if ($match_data && ! empty($match_data)) {
			if ($match_data[1][0] == 'width') {
				$width_attr  = $match_data[2][0];
				$height_attr = $match_data[2][1];
			}
			else if ($match_data[1][0] == 'height') {
				$height_attr = $match_data[2][0];
				$width_attr  = $match_data[2][1];
			}

			if ( ! empty($width_attr)) {
				$width_attr = 'width="' . $width_attr . '"';
			}

			if ( ! empty($height_attr)) {
				$height_attr = 'height="' . $height_attr . '"';
			}

		}

		if (self::$speed_test) {
			self::$is_retina = 'false';
			self::$image_count ++;
		}

		// SrcSet
		$sizes_tag = '';
		$srcset    = '';
		preg_match('/srcset="([^"]+)"/', $image_source[0], $srcset_match);

		if ( ! empty($srcset_match)) {
			$srcset = $srcset_match[1]; // all srcset https://xyz.com/wp-content/uploads/2019/03/WAgenda.jpg 700w, https://xyz.com/wp-content/uploads/2019/03/WAgenda-300x180.jpg 300w
			if ( ! empty($srcset)) {
				preg_match_all('/((https?\:\/\/|\/\/)[^\s]+\S+\.(jpg|jpeg|png|gif|svg))\s(\d{1,5})/', $srcset, $srcset_links);

				if ( ! empty($srcset_links)) {
					foreach ($srcset_links[1] as $i => $srcset_url) {
						$is_svg     = false;
						$find_image = $srcset_url;
						$width      = $srcset_links[4][ $i ];

						if (self::$speed_test && $width > 700) {
							continue;
						}

						if (strpos($find_image, '.svg') !== false) {
							$is_svg = true;
						}

						if (strpos($srcset_url, 'http') === false && strpos($srcset_url, 'https') === false) {
							$srcset_url = self::$site_url_scheme . '://' . $srcset_url;
						}

						if (strpos($srcset_url, self::$zone_name) !== false) {
							continue;
						}

						self::$image_count ++;

						if (self::$speed_test && self::$image_count >= self::$speed_test_img_count_limit) {
							$srcset_replace = 'data:image/svg+xml;charset=UTF-8,base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAwIiBoZWlnaHQ9IjEwMDAiPjxwYXRoIGQ9Ik0yIDJoMTAwMHYxMDAwSDJ6IiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwIi8+PC9zdmc+';
						}
						else {
							if ($is_svg) {
								$srcset_replace = self::$apiAssetUrl . $srcset_url;
							}
							else {
								$srcset_replace = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $width . '/url:' . $srcset_url;
							}
						}
						$srcset = str_replace($find_image, $srcset_replace, $srcset);
					}
				}
			}
		}
		else {
			/**
			 * SrcSet does noo exist add it
			 */
			if ( ! empty(self::$adaptive_enabled) && self::$adaptive_enabled == '1') {
				$do_srcset = true;
				$max_width = 0;
				#$full_image = self::get_full_size($image[0]);
				$full_image = self::get_full_size($match_url[1]);

				if (empty($full_image[0]) || ! $full_image) {
					/**
					 * Not a media library image
					 */
					$do_srcset = false;
					$srcset    = '';
					$sizes_tag = '';
				}
				else {

					$is_svg           = false;
					$full_image_width = $full_image[1];
					$sizes            = array(50, 150, 300, 680, 800, 1024);

					if (strpos($full_image[0], '.svg') !== false) {
						$is_svg = true;
					}

					foreach ($sizes as $i => $size) {
						if ( ! empty($full_image_width) && $size > $full_image_width) {
							break;
						}
						$max_width = $size;
						if ($is_svg) {
							$srcset .= self::$apiAssetUrl . $full_image[0] . ' ' . $size . 'w,';
						}
						else {
							$srcset .= self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $size . '/url:' . $full_image[0] . ' ' . $size . 'w,';
						}
					}

					if ( ! empty($full_image_width) && $max_width < $full_image_width) {
						$max_width = $full_image_width;
					}

					if ( ! empty($_GET['dbg']) && $_GET['dbg'] == 'max_width') {
						return print_r($max_width, true);
					}

					if ( ! empty($full_image_width)) {
						if (strpos($full_image[0], '.svg') !== false) {
							$srcset .= self::$apiAssetUrl . $full_image[0] . ' ' . $full_image_width . 'w,';
						}
						else {
							$srcset .= self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $full_image_width . '/url:' . $full_image[0] . ' ' . $full_image_width . 'w,';
						}
					}

					$srcset    = rtrim($srcset, ',');
					$sizes_tag = ' sizes="(max-width: ' . $max_width . 'px) 100vw, ' . $max_width . 'px"';
				}
			}

		}

		$size = self::get_image_size($match_url[1]);

		if (empty($size) || ($size[0] < 10 || $size[1] < 10)) {
			$size = array(1920, 1920);
		}

		if (self::$speed_test && $size[0] > 320) {
			$size = array(320, 320);
		}

		if (self::$speed_test) {
			$apiURL = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:320/url:' . self::reformat_url($match_url[1]);
		}
		else {
			if (strpos($match_url[1], '.svg') !== false) {
				$apiURL = self::$apiAssetUrl . self::reformat_url($match_url[1]);
			}
			else {
				if (empty($srcset) && ( ! empty(self::$adaptive_enabled) && self::$adaptive_enabled == '1')) {
					$apiURL = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $size[0] . '/url:' . self::reformat_url($match_url[1]);
				}
				else {
					$apiURL = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $size[0] . '/url:' . self::reformat_url($match_url[1]);
				}
			}
		}

		$class_Addon = '';

		if (empty($size[0]) || ! $size[0]) {
			$size    = array();
			$size[0] = '1024';
			$size[1] = '1024';
		}
		$source_svg = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="' . $size[0] . '" height="' . $size[1] . '"><path d="M2 2h' . $size[0] . 'v' . $size[1] . 'H2z" fill="#fff" opacity="0"/></svg>');

		// TODO: IT was source_svg but it was causing problems with SOME sliders (owl)
		$svgAPI = $source_svg;

		if (is_feed()) {
			$svgAPI = $apiURL;
		}

		self::$image_count ++;

		if (self::$speed_test && self::$image_count >= self::$speed_test_img_count_limit) {
			$apiURL = 'data:image/svg+xml;charset=UTF-8,base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAwIiBoZWlnaHQ9IjEwMDAiPjxwYXRoIGQ9Ik0yIDJoMTAwMHYxMDAwSDJ6IiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwIi8+PC9zdmc+';
		}

		$isLogo   = false;
		$imageUrl = strtolower($apiURL);
		if (strpos($imageUrl, 'logo') !== false) {
			$isLogo = true;
		}

		// Is LazyLoading enabled in the plugin?
		if ( ! empty(self::$lazy_enabled) && self::$lazy_enabled == '1') {

			// If Logo remove wps-ic-lazy-image
			if ($isLogo) {
				$image_tag = 'src="' . $apiURL . '"';
			}
			else {
				$image_tag = 'src="' . $svgAPI . '"';
			}

			$image_tag .= ' loading="lazy"';
			$image_tag .= ' data-src="' . $apiURL . '"';

			$image_tag .= ' data-width="' . $size[0] . '"';
			$image_tag .= ' data-height="' . $size[1] . '"';

			// If Logo remove wps-ic-lazy-image
			if ($isLogo) {
				// Image is for logo
				$class_Addon .= 'wps-ic-live-cdn wps-ic-logo';
			}
			else {
				// Image is not for logo
				$class_Addon .= 'wps-ic-live-cdn wps-ic-lazy-image ';
			}

		}
		else {
			if ( ! empty(self::$adaptive_enabled) && self::$adaptive_enabled == '1') {

				if ($isLogo) {
					$image_tag = 'src="' . $apiURL . '"';
				}
				else {
					$image_tag = 'src="' . $svgAPI . '"';
				}

				$image_tag .= ' data-adaptive="true"';
				$image_tag .= ' data-remove-src="true"';
			}
			else {
				$image_tag = 'src="' . $apiURL . '"';
				$image_tag .= ' data-adaptive="false"';
			}

			$image_tag .= ' data-src="' . $apiURL . '"';
			$image_tag .= ' data-width="' . $size[0] . '"';
			$image_tag .= ' data-height="' . $size[1] . '"';

			$class_Addon .= 'wps-ic-no-lazy ';
		}

		// Get All Atts
		preg_match_all('/(alt|title|style|id|class|sizes)=(["|\'][^"|\']*["|\'])/', $image_source[0], $regex_atts);

		$image_extra_atts = '';
		$image_class_atts = '';
		$class_added      = false;

		if ( ! empty($regex_atts[1])) {
			foreach ($regex_atts[1] as $k => $att) {
				$class_list = str_replace('"', '', $regex_atts[2][ $k ]);
				$class_list = str_replace("'", "", $class_list);
				$class_list = trim($class_list);
				if ($att == 'class') {
					$class_added      = true;
					$image_class_atts .= $att . '="' . $class_list . ' ' . $class_Addon . '" ';
				}
				else {
					if ($att == 'sizes') {
						if (( ! empty(self::$adaptive_enabled) && (self::$adaptive_enabled == '0' || self::$adaptive_enabled == 'false'))) {
							$image_extra_atts .= $att . '="' . $class_list . '" ';
						}
					}
					else {
						$image_extra_atts .= $att . '="' . $class_list . '" ';
					}
				}
			}
		}

		if ( ! $class_added) {

			$class_Addon_missing = '';
			$image_class_atts    = 'class="' . $class_Addon . ' ' . $class_Addon_missing . '"';
		}

		$image_class_atts = str_replace('lazyload', '', $image_class_atts);

		if ( ! empty($srcset) && ! self::$speed_test) {
			$srcset_tag = 'data-srcset="' . $srcset . '"' . $sizes_tag;
		}

		if (( ! empty(self::$lazy_enabled) && self::$lazy_enabled == '1') && self::$speed_test && self::$image_count >= self::$speed_test_img_count_limit) {
			// SVG Generator
			return '<img ' . $image_tag . ' ' . $image_class_atts . ' ' . $image_extra_atts . ' ' . $height_attr . ' ' . $width_attr . ' ' . $additional_tags . ' ' . $srcset_tag . ' />';
		}
		else {
			return '<img ' . $image_tag . ' ' . $image_class_atts . ' ' . $image_extra_atts . ' ' . $height_attr . ' ' . $width_attr . ' ' . $additional_tags . ' ' . $srcset_tag . ' />';
		}

	}


	public function obstart_replace_url_simple($image) {
		$asset    = false;
		$image[0] = trim($image[0]);

		if (strpos($image[0], 'simple-social-icons') !== false || strpos($image[0], 'retina.js') !== false || strpos($image[0], 'fbcdn.net') !== false || strpos($image[0], 'schema') !== false || strpos($image[0], 'data:image') !== false || strpos($image[0], 'google') !== false || strpos($image[0], 'typekit') !== false || strpos($image[0],
																																																																																																																																																																			self::$zone_name) !== false) {
			return $image[0];
		}

		// TODO: Maybe
		if (self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') {
			if ( ! self::image_url_matching_site_url($image[0])) {
				return $image[0];
			}
		}

		$minify = 'false';

		if (strpos($image[0], '.css') !== false) {

			if (empty(self::$css) || self::$css == '0') {
				return $image[0];
			}

			if ( ! empty(self::$css_minify) && self::$css_minify == '1') {
				$minify = 'true';
			}

		}
		else if (strpos($image[0], '.jsp') !== false) {
			return $image[0];
		}
		else if (strpos($image[0], '.js') !== false) {

			if (empty(self::$js) || self::$js == '0') {
				return $image[0];
			}

			if ( ! empty(self::$js_minify) && self::$js_minify == '1') {
				$minify = 'true';
			}

			self::$replacedJS .= trim($image[0]) . "\r\n";

		}
		else {
			return $image[0];
		}

		if (strpos($image[0], '?') !== false) {
			$image[0] .= '&icv=' . WPS_IC_HASH;
		}
		else {
			$image[0] .= '?icv=' . WPS_IC_HASH;
		}

		$apiURL = 'https://' . self::$zone_name . '/minify:' . $minify . '/asset:' . self::reformat_url($image[0]);

		$image[0] = str_replace($image[0], $apiURL, $image[0]);

		return $image[0];
	}


	public function image_attr_replace($image) {
		$original_string = $image[0];
		$image_url       = $image[1];

		if (strpos($image[0], 'simple-social-icons') !== false) {
			return $original_string;
		}

		if (self::is_excluded($image[0])) {
			return $original_string;
		}

		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($image_url)) {
			return $original_string;
		}

		if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg|ico|css|jsp|json|js)/', $image_url, $matches)) {
			return $original_string;
		}

		if (strpos($image_url, self::$zone_name) !== false) {
			return $original_string;
		}

		if (strpos($image_url, 'fbcdn.net') !== false) {
			return $original_string;
		}

		$apiURL = 'image="https://' . self::$zone_name . '/minify:false/asset:' . self::reformat_url($image_url) . '"';

		return $apiURL;
	}


	public function image_url_replace($image) {

		$original_url = $find = $image[0]; // http://...

		if (strpos($image[0], 'simple-social-icons') !== false || strpos($image[0], 'retina.js') !== false || strpos($image[0], 'fbcdn.net') !== false || strpos($image[0], 'schema') !== false || strpos($image[0], 'data:image') !== false || strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		// Does it have http or https? If not, add it
		if (strpos($original_url, 'http') === false) {
			if (substr($original_url, 0, 2) == '//') {
				$original_url = ltrim($original_url, '//');
			}
			$original_url = 'https://' . $original_url;
		}

		if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg|ico|css|jsp|json|js)/', $original_url, $matches)) {
			return $find;
		}

		if (strpos($original_url, self::$zone_name) !== false) {
			return $find;
		}

		if (self::is_excluded($original_url)) {
			return $find;
		}

		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($original_url)) {
			return $find;
		}

		$apiURL = 'https://' . self::$zone_name . '/minify:true/asset:' . self::reformat_url($original_url);

		return $apiURL;
	}


	public function background_image_replace($image) {

		$find         = $image[0]; // url(http)
		$original_url = $image[1]; // http://...

		// Does it have http or https? If not, add it
		if (strpos($original_url, 'http') === false) {
			// Check if url is maybe absolute but without http/s
			if (strpos($original_url, '//') === 0) {
				// Just needs http/s
				$original_url .= 'https:' . $original_url;
			}
			else {
				$original_url = str_replace('../wp-content', 'wp-content', $original_url);
				$url_replace  = str_replace('/wp-content', 'wp-content', $original_url);
				$original_url = self::$site_url;
				$original_url = rtrim($original_url, '/');
				$original_url .= '/' . $url_replace;
			}
		}

		if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg|ico|css|jsp|json|js)/', $original_url, $matches)) {
			return $find;
		}

		if (strpos($original_url, self::$zone_name) !== false) {
			return $find;
		}

		if (self::is_excluded($original_url)) {
			return $find;
		}

		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($original_url)) {
			return $find;
		}

		$apiURL = 'https://' . self::$zone_name . '/minify:true/asset:' . self::reformat_url($original_url);

		return "url(" . $apiURL . ")";
	}


	public function obstart_replace_url_in_css($image) {

		$asset    = false;
		$image[0] = trim($image[0]);

		if (strpos($image[0], 'simple-social-icons') !== false) {
			return $image[0];
		}

		if (strpos($image[0], '.jsp') !== false) {
			return $image[0];
		}

		if (strpos($image[0], 'retina.js') !== false) {
			return WPS_IC_URI . 'assets/js/retina.js';
		}

		if (self::is_excluded($image[0])) {
			return $image[0];
		}

		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0') && ! self::image_url_matching_site_url($image[0])) {
			return $image[0];
		}

		if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg|ico|css|js)/', $image[0], $matches)) {
			return $image[0];
		}

		if (strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		if (strpos($image[0], 'fbcdn.net') !== false) {
			return $image[0];
		}

		$is_css   = false;
		$is_js    = false;
		$is_svg   = false;
		$is_image = false;
		$minify   = 'false';

		if (strpos($image[0], 'schema') !== false) {
			return $image[0];
		}

		if (strpos($image[0], '.css') !== false) {
			$is_css = true;
			$asset  = true;

			if (empty(self::$css) || self::$css == '0') {
				return $image[0];
			}

			if ( ! empty(self::$css_minify) && self::$css_minify == '1') {
				$minify = 'true';
			}

		}
		else if (strpos($image[0], '.js') !== false) {
			$is_js = true;
			$asset = true;

			if (empty(self::$js) || self::$js == '0') {
				return $image[0];
			}

			if ( ! empty(self::$js_minify) && self::$js_minify == '1') {
				$minify = 'true';
			}
		}
		else if (strpos($image[0], '.svg') !== false) {
			$is_svg = true;
			$asset  = true;
		}
		else if (strpos($image[0], '.jpg') !== false || strpos($image[0], '.jpeg') !== false || strpos($image[0], '.png') !== false || strpos($image[0], '.ico') !== false || strpos($image[0], '.svg') !== false || strpos($image[0], '.gif') !== false) {
			$is_image = true;
		}
		else {
			return $image[0];
		}

		if (strpos($image[0], 'placeholder.svg') !== false) {
			return $image[0];
		}

		if (self::$speed_test && ! $asset) {
			#self::$image_count ++;
		}

		if (strpos($image[0], 'google') !== false) {
			return $image[0];
		}

		if (strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		$apiURL                = 'https://' . self::$zone_name . '/minify:' . $minify . '/asset:' . self::reformat_url($image[0]);
		$image[0]              = str_replace($image[0], $apiURL, $image[0]);

		return $image[0];
	}


	public static function isUrl($string) {
		$match = preg_match('/^[^?]*\.(jpg|jpeg|gif|png|svg|css|js|ico|woff|woff2|eot)/i', $string);
		if ( ! empty($match)) {
			return true;
		}
		else {
			return false;
		}
	}


	public function url_data_att($image) {
		$url = $image[1];

		if (strpos($_SERVER['REQUEST_URI'], 'embed') !== false) {
			return $image[0];
		}

		if ( ! self::isUrl($url)) {
			return $image[0];
		}

		if (strpos($url, 'simple-social-icons') !== false || strpos($url, 'retina.js') !== false || strpos($url, 'fbcdn.net') !== false || strpos($url, 'schema') !== false || strpos($url, self::$zone_name) !== false || strpos($url, 'google') !== false) {
			return $image[0];
		}

		if (strpos($url, '.jpg') !== false || strpos($url, '.jpeg') !== false || strpos($url, '.png') !== false || strpos($url, '.svg') !== false || strpos($url, '.gif') !== false) {

			$apiURL   = 'https://' . self::$zone_name . '/minify:false/asset:' . self::reformat_url($url);
			$image[0] = str_replace($image[1], $apiURL, $image[0]);

			return $image[0];
		}
		else {
			return $image[0];
		}
	}


	public function url_simple_att($image) {
		$url = $image[1];

		if (strpos($_SERVER['REQUEST_URI'], 'embed') !== false) {
			return $image[0];
		}

		if ( ! self::isUrl($image[1])) {
			return $image[0];
		}

		if (strpos($image[0], 'simple-social-icons') !== false || strpos($image[0], 'retina.js') !== false || strpos($image[0], 'fbcdn.net') !== false || strpos($image[0], 'schema') !== false || strpos($image[0], 'data:image') !== false || strpos($image[0], self::$zone_name) !== false || strpos($image[0], 'google') !== false) {
			return $image[0];
		}

		if (strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		if (strpos($image[0], '.jpg') !== false || strpos($image[0], '.jpeg') !== false || strpos($image[0], '.png') !== false || strpos($image[0], '.svg') !== false || strpos($image[0], '.gif') !== false) {

			$apiURL   = 'https://' . self::$zone_name . '/minify:false/asset:' . self::reformat_url($image[1]);
			$image[0] = str_replace($image[1], $apiURL, $image[0]);

			return $image[0];
		}
		else {
			return $image[0];
		}
	}


	public function url_simple($image) {


		if (strpos($_SERVER['REQUEST_URI'], 'embed') !== false) {
			return $image[0];
		}

		if (strpos($image[0], 'simple-social-icons') !== false || strpos($image[0], 'retina.js') !== false || strpos($image[0], 'fbcdn.net') !== false || strpos($image[0], 'google') !== false || strpos($image[0], 'schema') !== false || strpos($image[0], 'data:image') !== false || strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		if (strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		if (strpos($image[0], '.jpg') !== false || strpos($image[0], '.jpeg') !== false || strpos($image[0], '.png') !== false || strpos($image[0], '.svg') !== false || strpos($image[0], '.gif') !== false) {

			$apiURL                = 'https://' . self::$zone_name . '/minify:false/asset:' . self::reformat_url($image[0]);
			$image[0]              = str_replace($image[0], $apiURL, $image[0]);

			return $image[0];
		}
		else {
			return $image[0];
		}
	}


	public function obstart_replace_brizy_url_simple($image) {

		if (strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		if (strpos($image[0], '.jpg') !== false || strpos($image[0], '.jpeg') !== false || strpos($image[0], '.png') !== false || strpos($image[0], '.svg') !== false || strpos($image[0], '.gif') !== false) {


			$apiURL                = 'https://' . self::$zone_name . '/minify:false/asset:' . self::reformat_url($image[0]);
			$image[0]              = str_replace($image[0], $apiURL, $image[0]);

			return $image[0];
		}
		else {
			return $image[0];
		}
	}


	public function obstart_replace_brizy_url($image) {

		/*
		1	=>	wp-54d0250f421d1d41580d1b84cfbf5a91
		2	=>	iW%3D859%26iH%3D573%26oX%3D49%26oY%3D0%26cW%3D760%26cH%3D573
		3	=>	4
		 */

		#return $image[0];
		$decoded_string = urlencode($image[0]);
		$parsed_url     = parse_url($decoded_string);

		if ( ! isset($parsed_url['query'])) {
			return $image[0];
		}

		parse_str($parsed_url['query'], $params);

		if ( ! isset($params['brizy_media'])) {
			return $image[0];
		}

		if (in_array($params['brizy_media'], self::$brizyCache)) {
			$image[0] = self::$brizyCache[ $params['brizy_media'] ];

			if (self::is_excluded($image[0])) {
				return $image[0];
			}

		}
		else {

			$attachments = get_posts(array('meta_key'   => 'brizy_attachment_uid',
																		 'meta_value' => $params['brizy_media'],
																		 'post_type'  => 'attachment',));

			if (isset($attachments[0])) {
				$attachment = $attachments[0];
			}
			else {
				return $image[0];
			}

			if (self::is_excluded($image[0])) {
				return $image[0];
			}

			if (strpos($image[0], self::$zone_name) !== false) {
				return $image[0];
			}

			$size[0] = self::$defined_resolution;

			if (strpos($image[0], 'http:') === false && strpos($image[0], 'https:') === false) {
				$image[0] = 'http://' . $image[0];
			}

			$real_image                                 = wp_get_attachment_image_src($attachment->ID, 'large');
			self::$brizyCache[ $params['brizy_media'] ] = $real_image[0];
			$image[0]                                   = $real_image[0];
			update_option('wps_ic_brizy_cache', self::$brizyCache);
		}

		if (self::$speed_test && $size[0] > 320) {
			$size = array(320, 320);
		}

		if ( ! empty(self::$exif) && self::$exif == '1') {
			$apiURL = self::$zone_name . '/q:' . self::$settings['optimization'] . '/exif:true/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $size[0] . '/url:' . $image[0];
		}
		else {
			$apiURL = self::$zone_name . '/q:' . self::$settings['optimization'] . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $size[0] . '/url:' . $image[0];
		}

		return $apiURL;
	}


	public function replace_path_css_urls($image) {

		$default = $image[0];

		if ( ! preg_match('/\.(woff|eot|ttf|woff2)/', $image[1])) {
			return $default;
		}

		if (strpos($image[1], 'google') !== false) {
			return $default;
		}

		if (strpos($image[1], self::$zone_name) !== false || strpos($image[1], 'zapwp') !== false) {
			return $default;
		}

		$found_img_src = $image[1];
		$found_img_src = trim($found_img_src, "'");
		$found_img_src = trim($found_img_src, '"');

		if (strpos('../wp-content', self::$site_url) !== false || strpos('./wp-content', self::$site_url) !== false) {
			$found_img_src = str_replace('../wp-content', 'wp-content', $found_img_src);
			$found_img_src = str_replace('./wp-content', 'wp-content', $found_img_src);
			$found_img_src = self::$site_url . '/' . $found_img_src;
		}

		$parse_url = parse_url($found_img_src);
		if (empty($parse_url['host'])) {
			$search_for = $found_img_src;

			if (strpos($found_img_src, self::$zone_name) !== false || strpos($found_img_src, 'zapwp') !== false) {
				return $found_img_src;
			}

			$found_img_src = self::$site_url . $found_img_src;

			$apiURL = 'https://' . self::$zone_name . '/minify:false/asset:' . $found_img_src;

			return "url(" . $apiURL . ")";
		}
		else {
			$apiURL = 'https://' . self::$zone_name . '/minify:false/asset:' . $found_img_src;

			return "url('" . $apiURL . "')";
		}

	}


	public function replace_path_css($image) {
		if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg|woff|eot|ttf|woff2)/', $image[0])) {
			return $image[0];
		}

		if (strpos($image[0], 'google') !== false) {
			return $image[0];
		}

		if (strpos($image[0], self::$zone_name) !== false || strpos($image[0], 'zapwp') !== false) {
			return $image[0];
		}

		$found_img_src = $image[0];
		$found_img_src = trim($found_img_src, "'");
		$found_img_src = trim($found_img_src, '"');

		if (strpos('../wp-content', self::$site_url) !== false || strpos('./wp-content', self::$site_url) !== false) {
			$found_img_src = str_replace('../wp-content', 'wp-content', $found_img_src);
			$found_img_src = str_replace('./wp-content', 'wp-content', $found_img_src);
			$found_img_src = self::$site_url . '/' . $found_img_src;
		}

		$parse_url = parse_url($found_img_src);
		if (empty($parse_url['host'])) {
			$search_for = $found_img_src;

			if (strpos($found_img_src, self::$zone_name) !== false || strpos($found_img_src, 'zapwp') !== false) {
				return $found_img_src;
			}

			#$found_img_src = self::$site_url . $found_img_src;

			$apiURL = 'https://' . self::$zone_name . '/minify:false/asset:' . $found_img_src;

			return self::$site_url . $found_img_src;
		}
		else {
			$apiURL = 'https://' . self::$zone_name . '/minify:false/asset:' . $found_img_src;

			return $apiURL;
		}

		$apiURL                = 'https://' . self::$zone_name . '/minify:false/asset:' . $found_img_src;
		$found_img_src         = str_replace($found_img_src, $apiURL, $found_img_src);

		return $found_img_src;
	}


	public function obstart_replace_url($image) {
		$asset    = false;
		$image[0] = trim($image[0]);

		if (strpos($image[0], 'simple-social-icons') !== false || strpos($image[0], 'retina.js') !== false || strpos($image[0], 'fbcdn.net') !== false || strpos($image[0], 'google') !== false || strpos($image[0], 'schema') !== false || strpos($image[0], self::$zone_name) !== false) {
			return $image[0];
		}

		if ( ! preg_match('/\.(jpg|jpeg|png|gif|svg|ico|css|js)/', $image[0], $matches) && strpos($image[0], '?brizy_media') == false) {
			return $image[0];
		}

		if (self::is_excluded($image[0])) {
			return $image[0];
		}

		if ((self::$external_url_enabled == 'false' || self::$external_url_enabled == '0')) {
			if ( ! self::image_url_matching_site_url($image[0])) {
				return $image[0];
			}
		}

		$is_css   = false;
		$is_js    = false;
		$is_svg   = false;
		$is_image = false;
		$minify   = 'false';

		if (strpos($image[0], '.css') !== false) {
			$is_css = true;
			$asset  = true;

			if (empty(self::$css) || self::$css == '0') {
				return $image[0];
			}

			if ( ! empty(self::$css_minify) && self::$css_minify == '1') {
				$minify = 'true';
			}

		}
		else if (strpos($image[0], '.js') !== false) {
			$is_js = true;
			$asset = true;

			if (empty(self::$js) || self::$js == '0') {
				return $image[0];
			}

			if ( ! empty(self::$js_minify) && self::$js_minify == '1') {
				$minify = 'true';
			}
		}
		else if (strpos($image[0], '.svg') !== false) {
			$is_svg = true;
			$asset  = true;
		}
		else if (strpos($image[0], '.jpg') !== false || strpos($image[0], '.jpeg') !== false || strpos($image[0], '.png') !== false || strpos($image[0], '.ico') !== false || strpos($image[0], '.svg') !== false || strpos($image[0], '.gif') !== false) {
			$is_image = true;
		}
		else {
			return $image[0];
		}

		if (strpos($image[0], 'placeholder.svg') !== false) {
			return $image[0];
		}

		if (self::$speed_test && ! $asset) {
			self::$image_count ++;
		}

		if (( ! empty(self::$lazy_enabled) && self::$lazy_enabled == '1') && ! $asset && self::$speed_test && self::$image_count >= self::$speed_test_img_count_limit) {
			$svgAPI   = self::$svg_placeholder;
			$image[0] = str_replace($image[0], $svgAPI, $image[0]);
		}
		else {
			if ( ! $asset) {


				if (empty(self::$adaptive_enabled) || self::$adaptive_enabled == '0') {
					$size[0] = '1';
				}
				else {
					$size = self::get_image_size($image[0]);
					if ( ! empty(self::$defined_resolution)) {
						if ($size[0] > self::$defined_resolution) {
							$size[0] = self::$defined_resolution;
						}
					}
				}

				if (self::$speed_test && $size[0] > 320) {
					$size = array(320, 320);
				}

				$apiURL = self::$apiUrl . '/retina:' . self::$is_retina . '/webp:' . self::$webp . '/w:' . $size[0] . '/url:' . self::reformat_url($image[0]);

				$image[0]              = str_replace($image[0], $apiURL, $image[0]);
			}
			else {

				if (strpos($image[0], 'google') !== false || strpos($image[0], 'typekit') !== false) {
					return $image[0];
				}

				if (strpos($image[0], self::$zone_name) !== false) {
					return $image[0];
				}

				$apiURL                = 'https://' . self::$zone_name . '/minify:' . $minify . '/asset:' . self::reformat_url($image[0]);
				$image[0]              = str_replace($image[0], $apiURL, $image[0]);
			}
		}

		return $image[0];
	}


	/**
	 * Verify CDN is enabled and that it has got enough bandwidth left over.
	 * In case it's not enabled or does not have enough bandwidth, disable it.
	 */
	public function check_cdn_status() {
		global $wps_ic;

		$cdn_check_transient = get_transient('wps_ic_cdn_check');

		if ( ! $cdn_check_transient) {
			// Check CDN Status

			$call = $wps_ic->curl->call_api(array('cdn_status' => 'true'));

			if ($call) {
				set_transient('wps_ic_cdn_check', 'true', 60 * 2);

				if ( ! $call->success) {
					// CDN Does exist or we just created it
					$settings             = get_option(WPS_IC_SETTINGS);
					$settings['live-cdn'] = '0';
					update_option(WPS_IC_SETTINGS, $settings);
					set_transient('wps_ic_cdn_check_status', 'failed', 60 * 2);
				}
			}
		}

	}


	public function save_post($post_id) {
		delete_post_meta($post_id, '_ic_sources');
		delete_post_meta($post_id, '_ic_cdn_content');
	}


}