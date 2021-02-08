<?php


class wpc_upgrader extends wps_ic {

	public static $options;


	function __construct() {

		if ( ! $this->is_latest() || !empty($_GET['force_update'])) {
			self::$options = get_option(WPS_IC_OPTIONS);

			$settings = get_option(WPS_IC_SETTINGS);

			if (empty($settings['replace-method']) || $settings['replace-method']=='dom') {
				$settings['replace-method'] = 'regexp';
			}

			if ( ! isset($settings['live-cdn'])) {
				$settings['live-cdn'] = '0';

				if (!empty($settings['live_autopilot']) && $settings['live_autopilot'] == '1') {
					$settings['live-cdn'] = '1';
				} else {
					$settings['live-cdn'] = '0';
				}

				update_option(WPS_IC_SETTINGS, $settings);
			}

			// Purge CDN
			$this->purge_cdn();

			// Upgrade CDN
			#$this->upgrade_cdn();
			$this->update_to_latest();
		}

	}


	public function update_to_latest() {
		update_option('wpc_version', parent::$version);
	}


	public function is_latest() {
		$plugin_version = get_option('wpc_version');
		if (empty($plugin_version) || version_compare($plugin_version, parent::$version, '<')) {
			// Must Upgrade
			return false;
		} else {
			return true;
		}
	}


	public function purge_cdn() {
		$options = get_option(WPS_IC_OPTIONS);
		delete_transient('wps_ic_css_cache');
		delete_option('wps_ic_modified_css_cache');
		delete_option('wps_ic_css_combined_cache');

		set_transient('wps_ic_purging_cdn', 'true', 30);
		$url = 'https://keys.wpmediacompress.com/?action=purgeCDN&apikey=' . $options['api_key'];

		$call = wp_remote_get($url, array(
			'timeout'    => 10,
			'sslverify'  => 'false',
			'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0'
		));

		delete_transient('wps_ic_purging_cdn');
	}


	public function upgrade_cdn() {
		$url = 'https://keys.wpmediacompress.com/?action=updateCDN&apikey=' . self::$options['api_key'] . '&site=' . site_url();

		$call = wp_remote_get($url, array(
			'timeout'    => 10,
			'sslverify'  => 'false',
			'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0'
		));
	}


}