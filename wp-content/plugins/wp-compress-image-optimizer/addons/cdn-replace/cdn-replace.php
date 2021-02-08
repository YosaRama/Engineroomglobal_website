<?php
require_once WPS_IC_DIR . '/addons/cdn-replace/cdnFilter.php';


class wps_cdn_replace extends wps_addon_cdn {

	public static $options;
	public static $settings;
	public static $zone_name;
	public static $site_url;
	public static $site_scheme;

	public function __construct() {

		if ( ! is_admin() &&
				 ((!empty(parent::$settings['css']) && parent::$settings['css'] == '1') ||
					(!empty(parent::$settings['js']) && parent::$settings['js'] == '1'))) {
			self::$zone_name = parent::$zone_name;
			self::$site_url = parent::$site_url;
			self::$site_scheme = parse_url(self::$site_url, PHP_URL_SCHEME);
			self::$site_url = str_replace(array('http:', 'https:'), '', self::$site_url);

			add_action("template_redirect", array(__CLASS__, 'doReplace'),PHP_INT_MAX);
			add_action("wp_head", array(__CLASS__, 'dnsPrefetch'), 0);
		}
	}


	public static function doReplace() {
		if(strlen(trim(self::$zone_name)) > 0) {

			$exclude = '.php,.gif,.jpg,.jpeg,.png,.svg,.mp4,.mov,.avi,.bmp,.jsp,.jsx';

			if (empty(parent::$settings['css']) || parent::$settings['css'] == '0') {
				$exclude .= ',.css';
			}

			if (empty(parent::$settings['js']) || parent::$settings['js'] == '0') {
				$exclude .= ',.js';
			}


			$exclude = rtrim($exclude, ',');

			$settings = parent::$settings;
			$options = parent::$options;

			$rewriter = new CDNFilter(self::$site_url, (is_ssl() ? 'https://' : 'https://') . self::$zone_name . '/minify:true/asset:', 'wp-content,wp-includes', $exclude, 0, self::$site_scheme);

			$rewriter->startRewrite();
		}
	}


	public static function dnsPrefetch() {
		if (strlen(trim(self::$zone_name)) > 0) {
			echo "<link rel='dns-prefetch' href='//" . self::$zone_name . "' />";
		}
	}

}
