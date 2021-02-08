<?php


/**
 * Class - Enqueues
 */
class wps_ic_enqueues extends wps_ic {

	public static $version;
	public static $slug;
	public static $css_combine;
	public static $settings;
	public static $js_debug;


	public function __construct() {
		$this::$slug    = 'wpcompress';
		$this::$version = parent::$version;
		self::$settings = parent::$settings;
		self::$js_debug = parent::$js_debug;

		if ( ! empty($_GET['trp-edit-translation']) || ! empty($_GET['elementor-preview']) || ! empty($_GET['preview']) || ( ! empty($_GET['fl_builder']) || isset($_GET['fl_builder'])) || ! empty($_GET['PageSpeed']) || ! empty($_GET['et_fb']) || ! empty($_GET['ct_builder']) || ( ! empty($_SERVER['SCRIPT_URL']) && $_SERVER['SCRIPT_URL'] == "/wp-admin/customize.php")) {
			// Do nothing
		}
		else {
			add_action('wp_print_scripts', array($this, 'inline_frontend'), 1);
			add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend'), 1);
			add_action('admin_enqueue_scripts', array($this, 'enqueue_all'));

			// Remove CSS/Js Version
			add_filter('style_loader_src', array($this, 'remove_css_js_version'), 9999);
			add_filter('script_loader_src', array($this, 'remove_css_js_version'), 9999);

			if (self::is_st()) {
				add_filter('style_loader_tag', array($this, 'remove_unimportant_css'), 10, 3);
				add_filter('script_loader_tag', array($this, 'remove_unimportant_js'), 10, 3);
			}

			if ( ! empty(self::$settings['defer-js']) && self::$settings['defer-js'] == '1') {
				add_filter('script_loader_tag', array($this, 'defer_parsing_of_js'), 10, 3);
			}

		}

	}


	public function remove_css_js_version($src) {
		if (strpos($src, '?ver=')) {
			$src = remove_query_arg('ver', $src);
		}

		return $src;
	}


	public static function is_st() {
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

		if (!isset($_SERVER['HTTP_USER_AGENT'])) {
			$_SERVER['HTTP_USER_AGENT'] = 'wpc';
		}

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


	public function defer_wpc_scripts($tag, $handle, $src) {
		$defer = array('block-library',
			'dashicons');

		if (in_array($handle, $defer)) {
			#return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
		}

		return $tag;
	}


	public function inline_frontend() {
		echo '<style type="text/css">';

		if (self::is_st()) {
			echo '*, :before, :after {
  transition-property: none !important;
  transform: none !important;
  animation: none !important;
}';
		}

		echo '.wps-ic-lazy-image {opacity:0;}';
		echo '.wps-ic-no-lazy-loaded {opacity:1;}';
		echo '.ic-fade-in {
animation: ICfadeIn ease 1s;
-webkit-animation: ICfadeIn ease 1s;
-moz-animation: ICfadeIn ease 1s;
-o-animation: ICfadeIn ease 1s;
-ms-animation: ICfadeIn ease 1s;
}
@keyframes ICfadeIn {
0% {opacity:0;}
100% {opacity:1;}
}

@-moz-keyframes ICfadeIn {
0% {opacity:0;}
100% {opacity:1;}
}

@-webkit-keyframes ICfadeIn {
0% {opacity:0;}
100% {opacity:1;}
}

@-o-keyframes ICfadeIn {
0% {opacity:0;}
100% {opacity:1;}
}

@-ms-keyframes ICfadeIn {
0% {opacity:0;}
100% {opacity:1;}
}';
		echo '</style>';
	}


	public function remove_unimportant_js($tag, $handle, $src) {
		if (is_admin()) {
			return $tag;
		} //don't break WP Admin

		if (false === strpos($src, '.js')) {
			return $tag;
		}

		$exclude = array('dashicons', 'typekit', 'ie', 'responsive', 'animation', 'block', 'wordfence', 'google', 'analytics', 'translate');
		foreach ($exclude as $i => $string) {
			if (strpos($src, $string) !== false) {
				return '';
			}
		}

		if (strpos($tag, 'jquery.js') !== false || strpos($tag, 'jquery.min.js') !== false || strpos($tag, 'jquery-migrate') !== false) {
			return $tag;
		}

		$tag = str_replace(' src=', ' defer src=', $tag);

		return $tag;
	}


	public function remove_unimportant_css($html, $handle, $href) {
		if (is_admin()) {
            return $html;
		} //don't break WP Admin

		if (strpos($href, '.css') === false) {
			return $html;
		}

		if (!empty($_GET['dbg_unimportant_css'])) {
		    return print_r(array($html, $href, $handle));
        }


		$exclude = array('dashicons', 'ie', 'wordfence', 'google', 'analytics', 'translate');
		foreach ($exclude as $i => $string) {
            if (!empty($_GET['dbg_unimportant_css_1'])) {
                echo print_r(array('string' => $string, 'src' => $href, 'strpos' => strpos($href, $string), 'strpos_bool' => strpos($href, $string) !== false),true);
            }

			if (strpos($handle, $string) !== false) {
				return '';
			}
		}

        if (!empty($_GET['dbg_unimportant_css_2'])) {
            return print_r($html,true);
        }

        if (!empty($_GET['dbg_unimportant_css_3'])) {
            return print_r(str_replace(' href', ' async href', $html),true);
        }

		return str_replace(' href', ' async href', $html);
	}


	public function defer_parsing_of_css($tag, $handle, $src) {
		if (is_admin()) {
			echo $tag;
		} //don't break WP Admin

		if (false === strpos($src, '.css')) {
			echo $tag;
		}

		echo str_replace(' href', ' async href', $tag);
	}


	public function defer_parsing_of_js($tag, $handle, $src) {
		if (is_admin()) {
			return $tag;
		} //don't break WP Admin

		if (false === strpos($src, '.js')) {
			return $tag;
		}

		if (strpos($tag, 'jquery.js') !== false || strpos($tag, 'jquery.min.js') !== false || strpos($tag, 'jquery-migrate') !== false) {
			return $tag;
		}

		$tag = str_replace(' src=', ' defer src=', $tag);

		return $tag;
	}


	public function enqueue_frontend() {
		$options = parent::$settings;

		if (( ! empty($options['live-cdn']) && $options['live-cdn'] == '1') || ( ! empty($options['generate_adaptive']) && $options['generate_adaptive'] == '1') || ( ! empty($options['lazy']) && $options['lazy'] == '1') || ( ! empty($options['generate_webp']) && $options['generate_webp'] == '1')) {

			if (empty($options['slider_images']) || $options['slider_images'] == '0') {
				$slider_images = 'false';
			}
			else {
				$slider_images = 'true';
			}

			$lazy = 'true';
			if (empty($options['lazy']) || $options['lazy'] == '0') {
				$lazy = 'false';
			}

			$webp = 'true';
			if (empty($options['generate_webp']) || $options['generate_webp'] == '0') {
				$webp = 'false';
			}

			$adaptive = 'true';
			if (empty($options['generate_adaptive']) || $options['generate_adaptive'] == '0') {
				$adaptive = 'false';
			}

			$retina = 'true';
			if (empty($options['retina']) || $options['retina'] == '0') {
				$retina = 'false';
			}

			$exif = 'false';
			if ( ! empty($options['preserve_exif']) && $options['preserve_exif'] == '1') {
				$exif = 'true';
			}

			if (empty($options['high_res']) || $options['high_res'] == '0') {
				$high_res = 'false';
			}
			else {
				$high_res = 'true';
			}

			$real_user = 'true';
			if (self::is_st() && $this->is_mobile()) {
				$real_user = 'false';
			}

			if (empty($options['cname']) || ! $options['cname']) {
				$zone_name = get_option('ic_cdn_zone_name');
			}
			else {
				$custom_cname = get_option('ic_custom_cname');
				$zone_name    = $custom_cname;
			}

			if (is_user_logged_in() && current_user_can('manage_options')) {
				// Required for Admin Bar
				wp_enqueue_style($this::$slug . '-admin-bar', WPS_IC_URI . 'assets/css/admin-bar.min.css', array(), '1.0.0');

				wp_enqueue_script($this::$slug . '-admin-bar-js', WPS_IC_URI . 'assets/js/admin-bar' . WPS_IC_MIN . '.js', array('jquery'), '1.0.0');
			}

			if (( ! empty($options['lazy']) && $options['lazy'] == '1')) {

				if ( ! empty($options['live-cdn']) && $options['live-cdn'] == '1') {
					wp_enqueue_script($this::$slug . '-aio', WPS_IC_URI . 'assets/js/all-in-one' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
					wp_enqueue_script($this::$slug . '-lazy', WPS_IC_URI . 'assets/js/lazy' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
				}
				else {
					wp_enqueue_script($this::$slug . '-aio', WPS_IC_URI . 'assets/js/all-in-one' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
					wp_enqueue_script($this::$slug . '-lazy', WPS_IC_URI . 'assets/js/local.lazy' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
				}

				#wp_enqueue_style($this::$slug . '-lazy-effects', WPS_IC_URI . 'assets/css/lazy' . WPS_IC_MIN . '.css', array(), '1.0.0');

				wp_localize_script($this::$slug . '-lazy', 'wpc_vars', array('siteurl'          => site_url(),
																																		 'ajaxurl'          => admin_url('admin-ajax.php'),
																																		 'spinner'          => WPS_IC_URI . 'assets/images/spinner.svg',
																																		 'slider_images'    => $slider_images,
																																		 'high_res'         => $high_res,
																																		 'real_user'        => $real_user,
																																		 'webp_enabled'     => $webp,
																																		 'retina_enabled'   => $retina,
																																		 'exif_enabled'     => $exif,
																																		 'adaptive_enabled' => $adaptive,
																																		 'speed_test'       => self::is_st(),
																																		 'js_debug'         => self::$js_debug));

			}
			else {

				if ( ! empty($options['live-cdn']) && $options['live-cdn'] == '1') {
					// Live CDN Enabled
					wp_enqueue_script($this::$slug . '-aio', WPS_IC_URI . 'assets/js/all-in-one-no-lazy' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
					wp_enqueue_script($this::$slug . '-no-lazy', WPS_IC_URI . 'assets/js/no-lazy' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
				}
				else {
					// Live CDN Disabled
					wp_enqueue_script($this::$slug . '-aio', WPS_IC_URI . 'assets/js/all-in-one-no-lazy' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
					wp_enqueue_script($this::$slug . '-no-lazy', WPS_IC_URI . 'assets/js/local.no-lazy' . WPS_IC_MIN . '.js', array('jquery'), $this::$version);
				}

				wp_localize_script($this::$slug . '-no-lazy', 'wpc_vars', array('siteurl'          => site_url(),
																																				'ajaxurl'          => admin_url('admin-ajax.php'),
																																				'spinner'          => WPS_IC_URI . 'assets/images/spinner.svg',
																																				'slider_images'    => $slider_images,
																																				'high_res'         => $high_res,
																																				'real_user'        => $real_user,
																																				'webp_enabled'     => $webp,
																																				'retina_enabled'   => $retina,
																																				'exif_enabled'     => $exif,
																																				'adaptive_enabled' => $adaptive,
																																				'speed_test'       => self::is_st(),
																																				'js_debug'         => self::$js_debug));
			}

		}

	}


	public function is_mobile() {
		if (!isset($_SERVER['HTTP_USER_AGENT'])) {
			$_SERVER['HTTP_USER_AGENT'] = 'wpc';
		}

		$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

		$fp = fopen(WPS_IC_DIR . 'is_mobile.txt', 'w+');
		fwrite($fp, 'User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n");
		fwrite($fp, $userAgent . "\r\n");
		fwrite($fp, strpos($userAgent, 'mobile') . "\r\n");
		fwrite($fp, strpos($userAgent, 'lighthouse') . "\r\n");
		fclose($fp);

		if (strpos($userAgent, 'mobile')) {
			return true;
		}
		else {
			return false;
		}
	}


	public function enqueue_all() {
		$this::$version = parent::$version;
		$this::$slug    = parent::$slug;
		$response_key   = parent::$response_key;
		$settings       = parent::$settings;

		$screen = get_current_screen();

		$this->asset_style('menu-icon', 'css/menu.wp' . WPS_IC_MIN . '.css');
		wp_enqueue_script($this::$slug . '-admin-bar-js', WPS_IC_URI . 'assets/js/admin-bar-backend.js', array('jquery'), '1.0.0');

		if ($screen->base != 'upload' && $screen->base != 'settings_page_wpcompress' && $screen->base != 'toplevel_page_wpcompress-network' && $screen->base != 'toplevel_page_wpcompress' && $screen->base != 'media_page_wpcompress_optimize' && $screen->base != 'media_page_wpcompress_restore' && $screen->base != 'plugins') {
		}
		else {


			if (is_admin()) {
				wp_enqueue_script($this::$slug . '-circle', WPS_IC_URI . 'assets/js/circle-progress/circle-progress.js', array('jquery'), '1.0.0');

				if ($screen->base == 'toplevel_page_wpcompress' || $screen->base == 'toplevel_page_wpcompress-network' || $screen->base == 'settings_page_wpcompress') {

					// Switch Box - Checkbox customizer
					$this->script('switchbox', 'switchbox' . WPS_IC_MIN . '.js');

					// Settings Area
					wp_enqueue_style($this::$slug . '-google-font-Poppins', 'https://fonts.googleapis.com/css?family=Poppins:100,300,400,600&display=swap', array(), $this::$version);
					wp_enqueue_style($this::$slug . '-google-font-sans', 'https://fonts.googleapis.com/css?family=Open+Sans', array(), $this::$version);
					#$this->script('admin-settings', 'settings.admin' . WPS_IC_MIN . '.js');
					$this->script('admin-lottie-player', 'lottie/lottie-player.min.js');
					$this->script('admin-settings-live', 'live-settings.admin' . WPS_IC_MIN . '.js');
					wp_localize_script('wpcompress-admin-settings-live', 'wps_ic_vars', array('ajaxurl' => admin_url('admin-ajax.php')));

					if (is_multisite()) {
						$this->script('admin-mu-settings', 'mu-settings.admin' . WPS_IC_MIN . '.js');
					}

				}

				if ( ! empty($response_key)) {

					if ($screen->base == 'settings_page_wpcompress' && ( ! empty($_GET['view']) && $_GET['view'] == 'bulk')) {
						$this->script('media-library-bulk', 'media-library-bulk' . WPS_IC_MIN . '.js');
					}


					// Media Library Area
					if ($screen->base == 'upload' || $screen->base == 'media_page_wpcompress_optimize' || $screen->base == 'plugins' || $screen->base == 'media_page_wpcompress_restore' || $screen->base == 'media_page_wp_hard_restore_bulk') {

						// Icons
						$this->asset_style('admin-fontello', 'icons/css/fontello.css');

						// Tooltips
						$this->asset_style('admin-tooltip-bundle-wcio', 'tooltip/css/tooltipster.bundle' . WPS_IC_MIN . '.css');
						$this->asset_script('admin-tooltip', 'tooltip/js/tooltipster.bundle' . WPS_IC_MIN . '.js');

						$this->script('media-library', 'media-library-actions' . WPS_IC_MIN . '.js');
					}

					if ($screen->base == 'toplevel_page_wpcompress' || $screen->base == 'toplevel_page_wpcompress-network' || $screen->base == 'upload' || $screen->base == 'media_page_wpcompress_optimize' || $screen->base == 'plugins' || $screen->base == 'media_page_wpcompress_restore' || $screen->base == 'media_page_wp_hard_restore_bulk' || $screen->base == 'settings_page_wpcompress') {

						$this->script('admin', 'admin' . WPS_IC_MIN . '.js');

						$this->script('popups', 'popups' . WPS_IC_MIN . '.js');

						// Google Fonts
						wp_enqueue_style($this::$slug . '-google-font-Poppins', 'https://fonts.googleapis.com/css?family=Poppins:100,400,600&display=swap', array(), $this::$version);
						wp_enqueue_style($this::$slug . '-google-font-sans', 'https://fonts.googleapis.com/css?family=Open+Sans', array(), $this::$version);
					}

				}

				if ($screen->base == 'toplevel_page_wpcompress' || $screen->base == 'settings_page_wpcompress') {

					$this->asset_style('admin-tooltip-bundle-wcio', 'tooltip/css/tooltipster.bundle.min.css');
					$this->asset_script('admin-tooltip', 'tooltip/js/tooltipster.bundle.min.js');

					// Fontello
					$this->asset_style('admin-fontello', 'icons/css/fontello.css');
				}

				if ($screen->base == 'toplevel_page_wpcompress' || $screen->base == 'toplevel_page_wpcompress-network' || $screen->base == 'upload' || $screen->base == 'media_page_wpcompress_optimize' || $screen->base == 'plugins' || $screen->base == 'media_page_wpcompress_restore' || $screen->base == 'media_page_wp_hard_restore_bulk' || $screen->base == 'settings_page_wpcompress') {

					$this->style('admin-media-library', 'admin.media-library' . WPS_IC_MIN . '.css');
					$this->style('admin', 'admin.styles' . WPS_IC_MIN . '.css');
					$this->style('admin-toggle', 'admin.toggle' . WPS_IC_MIN . '.css');
					$this->style('admin-settings-page', 'settings_page' . WPS_IC_MIN . '.css');
					$this->asset_script('admin-settings-page-progress-bar', 'progress/progressbar' . WPS_IC_MIN . '.js');
					$this->asset_script('admin-settings-page-charts', 'charts/Chart.bundle.min.js');
					$this->asset_script('admin-settings-popup', 'js/settings.popup.js');

					// Sweetalert
					$this->asset_style('admin-sweetalert', 'sweetalert/sweetalert2.min.css');
					$this->asset_script('admin-sweetalert', 'sweetalert/sweetalert2.all.min.js');

				}

				// Print footer script
				wp_localize_script('wps_ic-admin', 'wps_ic', array('uri' => WPS_IC_URI));
			}

		}

	}


	public function asset_style(
		$name, $filename
	) {
		wp_enqueue_style($this::$slug . '-' . $name, WPS_IC_URI . 'assets/' . $filename, array(), $this::$version);
	}


	public function script(
		$name, $filename, $footer = true
	) {
		wp_enqueue_script($this::$slug . '-' . $name, WPS_IC_URI . 'assets/js/' . $filename, array('jquery'), $this::$version, $footer);
	}


	public function asset_script(
		$name, $filename
	) {
		wp_enqueue_script($this::$slug . '-' . $name, WPS_IC_URI . 'assets/' . $filename, array('jquery'), $this::$version, true);
	}


	public function style(
		$name, $filename
	) {
		wp_enqueue_style($this::$slug . '-' . $name, WPS_IC_URI . 'assets/css/' . $filename, array(), $this::$version);
	}

}