<?php

global $wps_ic, $wpdb;
$no_credits_popup = false;

$reconnect_msg = '';
if ( ! empty($_GET['reconnect'])) {
	// API Key
	$options = get_option(WPS_IC_OPTIONS);
	$apikey  = sanitize_text_field($options['api_key']);
	$siteurl = urlencode(site_url());

	// Setup URI
	$uri = WPS_IC_KEYSURL . '?action=connect_v5&apikey=' . $apikey . '&domain=' . $siteurl . '&hash=' . md5(time()) . '&time_hash=' . time();

	// Verify API Key is our database and user has is confirmed getresponse
	$get = wp_remote_get($uri, array('timeout' => 30, 'sslverify' => false, 'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0'));

	if (wp_remote_retrieve_response_code($get) == 200) {
		$body = wp_remote_retrieve_body($get);
		$body = json_decode($body);

		if ( ! empty($body->data->code) && $body->data->code == 'site-user-different') {
			// Popup Site Already Connected
			$reconnect_msg = 'invalid-api-key';
		}

		if ($body->success == true && $body->data->apikey != '' && $body->data->response_key != '') {
			$options = new wps_ic_options();
			$options->set_option('api_key', $body->data->apikey);
			$options->set_option('response_key', $body->data->response_key);

			// CDN Does exist or we just created it
			$zone_name = $body->data->zone_name;

			if ( ! empty($zone_name)) {
				update_option('ic_cdn_zone_name', $zone_name);
			}

			$settings = get_option(WPS_IC_SETTINGS);

			$sizes = get_intermediate_image_sizes();
			foreach ($sizes as $key => $value) {
				$settings['thumbnails'][ $value ] = 1;
			}

			update_option(WPS_IC_SETTINGS, $settings);
			$reconnect_msg = 'ok';
		}
		else {
			$reconnect_msg = 'api-error';
		}
	}
	else {
		$reconnect_msg = 'api-error';
	}
}

// Reset Cache
$cache_cleared = get_transient('ic_cdn_reset_cache');
if ( ! $cache_cleared) {
	$cache_cleared = false;
}
else {
	$cache_cleared = true;
	delete_transient('ic_cdn_reset_cache');
}

/**
 * Get Credits
 */
$user_credits = $wps_ic->check_account_status();
$allow_local  = $user_credits->account->allow_local;
$allow_cname  = $user_credits->account->allow_cname;
$quota_type   = $user_credits->account->type;

if ( ! empty($_GET['test_lock'])) {
	$allow_cname = 0;
	delete_transient('ic_allow_cname');
}

/**
 * Fetch settings, or if save is triggered save them.
 * - If no settings are saved (bug, deleted options..) regenerate recommended
 */
$settings = get_option(WPS_IC_SETTINGS);

/**
 * Must have settings
 */
$defaults_saved = false;
$defaults = array('retina' => '1', 'preserve_exif' => '0', 'lazy' => '1', 'generate_webp' => '1', 'generate_adaptive' => '1');
foreach ($defaults as $key => $value) {
  if (!isset($settings[$key])) {
    $settings[$key] = $value;
		$defaults_saved = true;
  }
}

if ($defaults_saved) {
  update_option(WPS_IC_SETTINGS, $settings);
}

/**
 * Is the plugin paused? Default: No
 */
$live_cdn = false;
if ( ! empty($settings['live-cdn']) && $settings['live-cdn'] == '1') {
	$live_cdn = true;
}

$statsclass = new wps_ic_stats();

$stats_live        = $statsclass->fetch_live_stats();
$stats_live        = $stats_live->data;
$chart_sample_data = false;

/**
 * Quick fix for PHP undefined notices
 */
$wps_ic_active_settings['optimization']['lossless']    = '';
$wps_ic_active_settings['optimization']['intelligent'] = '';
$wps_ic_active_settings['optimization']['ultra']       = '';

/**
 * Decides which setting is active
 */
if ( ! empty($settings['optimization'])) {
	if ($settings['optimization'] == 'lossless') {
		$wps_ic_active_settings['optimization']['lossless'] = 'class="current"';
	}
	else if ($settings['optimization'] == 'intelligent') {
		$wps_ic_active_settings['optimization']['intelligent'] = 'class="current"';
	}
	else {
		$wps_ic_active_settings['optimization']['ultra'] = 'class="current"';
	}
}
else {
	$wps_ic_active_settings['optimization']['intelligent'] = 'class="current"';
}

/**
 * Get Package/Plan details from API Key Verification
 * - Shows Shared or X Credits left information
 */
$is_unlimited = 0;

// Account Type
if ($quota_type == 'shared') {

	// Shared
	$credits      = wps_ic_size_format($user_credits->credits, 2) . ' Left';
	$credits_type = 'Shared Plan';

}
else if ($quota_type == 'unlimited') {

	// Unlimited
	$credits       = 'Unlimited';
	$local_credits = false;
	$credits_type  = 'Unlimited';
	$allow_local   = 0;
	$is_unlimited  = 1;

}
else if ($quota_type == 'requests') {

	if ($user_credits->bytes->package_local_type == 'shared') {
		$local_credits = 'Shared Credits';
	}
	else {

		if ($user_credits->bytes->local_leftover > 0) {
			$local_credits = number_format($user_credits->bytes->local_leftover, 0) . ' Images Left';
		}
		else {
			if ($user_credits->bytes->local_one_time_leftover > 0) {
				$local_credits = $user_credits->bytes->local_one_time_leftover . ' Images Left';
			}
			else {
				$local_credits = '0 Images Left';
			}
		}

	}

	// Quota
	if ($user_credits->bytes->package_requests_type == 'shared') {
		$credits = 'Shared Credits';
	}
	else {
		if ($user_credits->bytes->leftover > 0) {
			$credits = number_format($user_credits->bytes->leftover, 0) . ' Requests Left';
		}
		else {
			if ($user_credits->bytes->requests_one_time_leftover > 0) {
				$credits = $user_credits->bytes->requests_one_time_leftover . ' Requests Left';
			}
			else {
				$credits = '0 Requests Left';
			}
		}
	}
}
else if ($quota_type == 'shared_requests') {

	// Quota
	if ($user_credits->bytes->leftover > 0) {
		$credits = 'Shared Credits';
	}
	else {
		$credits = '0 Requests Left';
	}
}
else {

	// Bandwidth

	$local_credits = 0;

	// Quota

	if ($user_credits->account->plan == 'free') {
		$credits = 'Free Plan';
	}
	else {
		if ($user_credits->account->type == '' || $user_credits->account->type == 'quota') {

			$credits = $user_credits->formatted->package_without_extra . ' Left';

			$credits          = $user_credits->formatted->package_requests_leftover;
			$credits_one_time = $user_credits->formatted->package_requests_one_time;
			$local            = $user_credits->bytes->package_local_leftover;
			$local_one_time   = $user_credits->bytes->package_local_one_time;

			if ( ! $credits) {
				$credits = 0;
			}
			if ( ! $credits_one_time) {
				$credits_one_time = 0;
			}
			if ( ! $local) {
				$local = 0;
			}
			if ( ! $local_one_time) {
				$local_one_time = 0;
			}

			if ($credits == 0) {
				$credits = $credits_one_time . ' Left';
			}
			else {
				$credits = $credits . ' Left';
			}

			if ($local == 0) {
				$local_credits = $local_one_time . ' Images Left';
			}
			else {
				$local_credits = $local . ' Images Left';
			}

			if ($credits == 0 && $credits_one_time == 0) {
				$no_credits_popup = true;
			}

		}
		else {
			$credits = 'Free Plan';
		}
	}

}

$in_local = true;
if ($allow_local == 1) {
	if ( ! empty($settings['live-cdn']) && $settings['live-cdn'] == '1') {
		$in_local = false;
	}
}

$bg_process = get_option('wps_ic_bg_process');
$cnd_Purged = '';

if (empty($_GET['view'])) { ?>
  <div class="wrap">
    <div class="wps_ic_wrap wps_ic_settings_page wps_ic_live">

      <div class="wp-compress-header">
        <div class="wp-ic-logo-container">
          <div class="wp-compress-logo">
            <img src="<?php echo WPS_IC_URI; ?>assets/images/logo/blue-icon.svg"/>
            <div class="wp-ic-logo-inner">
              <h3 style="color: #333;">WP Compress <span class="small">v<?php echo $wps_ic::$version; ?></span></h3>
            </div>
          </div>
        </div>
        <div class="wp-ic-header-buttons-container">
          <ul>

						<?php if ( ! empty($live_cdn) && $live_cdn == '1') { ?>
              <li><a href="#" class="wps-ic-service-status active">Live Optimization Active</a></li>
						<?php } else { ?>
              <li><a href="#" class="wps-ic-service-status paused">Live Optimization Paused</a></li>
						<?php } ?>

            <li class="bulk-button" style="<?php if ( ! empty($live_cdn) && $live_cdn == '1') {
							echo 'display:none;';
						} ?>"><a href="<?php echo admin_url('options-general.php?page=wpcompress&view=bulk'); ?>" class="button button-primary">Bulk Optimization</a></li>

            <li><a href="<?php echo admin_url('options-general.php?page=wpcompress&view=advanced_settings'); ?>" class="button button-primary">Advanced Settings</a></li>
          </ul>
        </div>
        <div class="clearfix"></div>
      </div>

			<?php if ($reconnect_msg) { ?>
        <div class="wp-compress-success-message">
					<?php
					if ($reconnect_msg == 'invalid-api-key') {
						?>
            <h3 style="text-align: center;">Invalid API Key!</h3>
					<?php } else if ($reconnect_msg == 'ok') { ?>
            <h3 style="text-align: center;">We have successfully reconnected your plugin!</h3>
					<?php } else { ?>
            <h3 style="text-align: center;">Please contact WP Compress Support!</h3>
					<?php } ?>
          <div class="clearfix"></div>
        </div>
			<?php } ?>

			<?php if ($cache_cleared) { ?>
        <div class="wp-compress-success-message">
          <h3 style="text-align: center;">We have cleared your CDN Cache!</h3>
          <div class="clearfix"></div>
        </div>
			<?php } ?>

			<?php if ( ! empty($_GET['purge_cdn']) && $cnd_Purged == 'true') { ?>
        <div class="wp-compress-success-message">
          <h3 style="text-align: center;">We have cleared your CDN Cache!</h3>
          <div class="clearfix"></div>
        </div>
			<?php } ?>

      <div class="wp-compress-pre-wrapper">
        <div class="wp-compress-pre-subheader">
          <div class="col-6">
            <ul>
              <li>
                <h3>Compression Report</h3>
								<?php
								if (empty($settings['live-cdn']) || $settings['live-cdn'] == '0') {
									// Local Stats

									if (empty($local_stats)) {
										echo '<li><span class="button-sample-data tooltip" title="Chart will update when usage data is available.">Sample Data</span></li>';
									}
									else {
										echo '<li><span class="button-sample-data tooltip" title="Chart data for Local Compression">Local</span></li>';
									}

								}
								else {
									// Live Stats
									if ($user_credits->bytes->cdn_bandwidth == 0 && $user_credits->bytes->cdn_requests == 0) {
										echo '<li><span class="button-sample-data tooltip" title="Chart will update when usage data is available.">Sample Data</span></li>';
									}
									else {
										echo '<li><span class="button-sample-data tooltip" title="Chart data for Live Compression">Live</span></li>';
									}

								}
								?>
              </li>
            </ul>
          </div>
          <div class="col-6 last">
            <ul>
              <li><span class="legend-original"></span>Before</li>
              <li><span class="legend-after"></span>After Optimization</li>
            </ul>
          </div>
        </div>

        <div class="wp-compress-chart" style="height: 400px;">
					<?php echo '<canvas id="canvas"></canvas>'; ?>
        </div>

      </div>
      <div class="wp-compres-settings">

        <div class="wp-compress-settings-row-blank">

          <div class="col-9 text-left white-box margin-right">
            <div class="pre-inner">
              <div class="inner inner-flex">

								<?php

								/**
								 * Is it a multisite installation
								 * TODO: Do we still need this? Test on multisite
								 */
								if (is_multisite()) {
									$blogID = get_current_blog_id();
								}
								else {
									$blogID = 1;
								}

								if (( ! empty($stats_local) || ! empty($stats_live))) {
									$donut_size = 1;

									$savings = false;
									if ($user_credits->bytes->bandwidth_savings > 0) {
										$savings      = true;
										$donut_size   = $user_credits->bytes->bandwidth_savings / 100;
										$donut_size   = number_format($donut_size, 2);
										$user_savings = $user_credits->formatted->bandwidth_savings;
									}
									else {
										$savings      = true;
										$user_savings = 0;
									}

									?>

                  <div class="left-side-box">
                    <div class="user-account-circle">
                      <div id="circle-big" data-value="<?php echo $donut_size; ?>"></div>
                      <div class="dashboard-account-circle-text">
												<?php if ($savings) { ?>
                          <h5><?php echo $user_savings . '%'; ?></h5>
                          <h4>Savings</h4>
												<?php } ?>
                      </div>
                      <!-- -35s == 35% -->
                    </div>
                  </div>

                  <div class="right-side-box">
                    <div class="youve-saved">
											<?php if ( ! empty($stats_live) || ! empty($stats_local)) {?>
                        <h3>You've Saved</h3>
                        <h4><?php echo $user_credits->formatted->bandwidth_savings_bytes; ?></h4>
												<?php
											}
											else {
												?>
                        <h3>No savings yet</h3>
                        <a href="#" class="button-primary button" style="margin-left: 10px;margin-right:10px;">Start</a>
											<?php } ?>
                      <div class="image-credits-remaining">
												<?php
												$local_requests_left = '';
												$requests_left       = '';
												if (empty($settings['live-cdn']) || $settings['live-cdn'] == '0') {
													$requests_left = 'display:none;';
												}
												else {
													$local_requests_left = 'display:none;';
												}
												?>
                        <a href="https://wpcompress.com/pricing" target="_blank" class="button button-primary local-requests-left" style="<?php echo $local_requests_left; ?>">
                          <h5><?php echo $local_credits; ?></h5>
                        </a>
                        <a href="https://wpcompress.com/pricing" target="_blank" class="button button-primary requests-left" style="<?php echo $requests_left; ?>">
                          <h5><?php echo $credits; ?></h5>
                        </a>

                      </div>
                    </div>

                    <div class="stats-boxes">

                      <div class="stats-box-single">
                        <h3><?php echo $user_credits->formatted->cdn_bandwidth; ?></h3>
                        <h5>Optimized</h5>
                      </div>

                      <div class="stats-box-single">
                        <h3><?php echo $user_credits->formatted->original_bandwidth; ?></h3>
                        <h5>Original</h5>
                      </div>

                      <div class="stats-box-single">
                        <h3><?php echo $user_credits->formatted->cdn_requests; ?></h3>
                        <h5>Assets Served</h5>
                      </div>

                      <?php /*
                      <div class="stats-box-single stats-box-projection">
												<?php if ($user_credits->account->projected_flag < 2 || $user_credits->account->type == 'unlimited') { ?>
                          <div class="projected-flag-ok" title="You're projected to have enough credits for this month.">
                            <img src="<?php echo WPS_IC_URI; ?>/assets/images/projected-ok.svg"/>
                          </div>
												<?php } else { ?>
                          <div class="projected-flag-warning red-tooltip" title="You're projected to run out of credits before this month ends.">
                            <img src="<?php echo WPS_IC_URI; ?>/assets/images/projected-alert.svg"/>
                          </div>
												<?php } ?>
                        <div class="projected-text">
                          <h3><?php echo $user_credits->formatted->projected; ?></h3>
                          <h5>Projected</h5>
                        </div>
                      </div>*/?>


                    </div>
                  </div>
								<?php }
								else {
									$donut_size = 0.75;
									?>

                  <div class="left-side-box">
                    <div class="user-account-circle">
                      <div id="circle-big" data-value="<?php echo $donut_size; ?>"></div>
                      <div class="dashboard-account-circle-text">
                        <h5>75%</h5>
                        <h4>Savings</h4>
                      </div>
                      <!-- -35s == 35% -->
                    </div>
                  </div>

                  <div class="right-side-box">
                    <div class="youve-saved">
											<?php if ( ! empty($stats_live) || ! empty($stats_local)) { ?>
                        <h3>You've Saved</h3>
                        <h4><?php echo $user_credits->formatted->bandwidth_savings_bytes; ?></h4>
											<?php } else { ?>
                        <h3>You've Saved</h3>
                        <h4><?php echo 0 . ' MB'; ?></h4>
											<?php } ?>
                      <div class="image-credits-remaining">

												<?php if (empty($settings['live-cdn']) || $settings['live-cdn'] == '0') { ?>
                          <a href="https://wpcompress.com/pricing" target="_blank" class="button button-primary local-requests-left">
                            <h5><?php echo $local_credits; ?></h5>
                          </a>
                          <a href="https://wpcompress.com/pricing" target="_blank" class="button button-primary requests-left" style="display: none;">
                            <h5><?php echo $credits; ?></h5>
                          </a>
												<?php } else { ?>
                          <a href="https://wpcompress.com/pricing" target="_blank" class="button button-primary local-requests-left" style="display: none;">
                            <h5><?php echo $local_credits; ?></h5>
                          </a>
                          <a href="https://wpcompress.com/pricing" target="_blank" class="button button-primary requests-left">
                            <h5><?php echo $credits; ?></h5>
                          </a>
												<?php } ?>
                      </div>
                    </div>

                    <div class="stats-boxes">


                      <div class="stats-box-single">
                        <h3><?php echo $user_credits->formatted->cdn_bandwidth; ?></h3>
                        <h5>Optimized</h5>
                      </div>

                      <div class="stats-box-single">
                        <h3><?php echo $user_credits->formatted->original_bandwidth; ?></h3>
                        <h5>Original</h5>
                      </div>

                      <div class="stats-box-single">
                        <h3><?php echo $user_credits->formatted->cdn_requests; ?></h3>
                        <h5>Assets Served</h5>
                      </div>

                      <div class="stats-box-single stats-box-projection">
												<?php if ($user_credits->account->projected_flag < 2 || $user_credits->account->type == 'unlimited') { ?>
                          <div class="projected-flag-ok" title="You're projected to have enough credits for this month.">
                            <img src="<?php echo WPS_IC_URI; ?>/assets/images/projected-ok.svg"/>
                          </div>
												<?php } else { ?>
                          <div class="projected-flag-warning red-tooltip" title="You're projected to run out of credits before this month ends.">
                            <img src="<?php echo WPS_IC_URI; ?>/assets/images/projected-alert.svg"/>
                          </div>
												<?php } ?>
                        <div class="projected-text">
                          <h3><?php echo $user_credits->formatted->projected; ?></h3>
                          <h5>Projected</h5>
                        </div>
                      </div>


                    </div>
                  </div>
								<?php } ?>
              </div>
            </div>
          </div>

          <div class="col-3 col-autopilot">

            <div class="pre-inner">
              <div class="inner">

                <div class="autopilot-box">
                  <h3>Optimization Mode
										<?php /*<span class="tooltip" title="You may switch between local compression and live image optimization using the Global CDN based on your needs."><i class="fa fa-question-circle"></i></span>*/ ?>
                    <span class="tooltip" title="By disabling Live Mode you pause the WP Compress CDN service."><i class="fa fa-question-circle"></i></span>
                  </h3>

									<?php
									$cdn_popup_class = '';
									if ($no_credits_popup) {
										$cdn_popup_class = 'no-leftover-popup';
									}
									?>
                  <div class="checkbox-container-custom-pause wps-ic-ajax-checkbox ajax-change-span wps-ic-live-cdn-ajax <?php echo $cdn_popup_class; ?>" data-leftover="<?php echo $user_credits->bytes->leftover; ?>" style="padding-top: 0px;">
                    <input type="checkbox" id="wp-ic-setting[live-cdn]" data-on-text="Live CDN" data-off-text="Local" value="1"
                           name="wp-ic-setting[live-cdn]" data-setting_name="live-cdn" data-setting_value="1" <?php if ($live_cdn) {
											echo 'checked="checked"';
										}
										else {
										} ?>/>
                    <div>
                      <label for="wp-ic-setting[live-cdn]" class=""></label>
											<?php if ($settings['live-cdn'] == '1') { ?>
                        <span>Live CDN</span>
											<?php } else { ?>
                        <span>Local</span>
											<?php } ?>
                    </div>
                  </div>


                </div>


              </div>
            </div>
          </div>

          <div class="clearfix"></div>
        </div>

        <div class="wp-compress-settings-row wps-ic-live-compress">

          <div class="col-2 bigger text-center">
            <div class="inner">
              <h3>Optimization Level <span class="tooltip" title="Select your preferred balance of speed and quality. Over-Compression Prevention™ is included in all modes."><i class="fa fa-question-circle"></i></span></h3>

              <div class="wp-ic-select-box">
                <input type="hidden" name="wp-ic-setting[optimization]" id="wp-ic-setting-optimization" value="<?php echo $settings['optimization']; ?>"/>
                <ul>
                  <li <?php echo $wps_ic_active_settings['optimization']['lossless']; ?>><a href="#" class="wps-ic-change-optimization" data-optimization_level="lossless">Lossless</a></li>
                  <li <?php echo $wps_ic_active_settings['optimization']['intelligent']; ?>><a href="#" class="wps-ic-change-optimization" data-optimization_level="intelligent">Intelligent</a></li>
                  <li <?php echo $wps_ic_active_settings['optimization']['ultra']; ?>><a href="#" class="wps-ic-change-optimization" data-optimization_level="ultra">Ultra</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-2 text-center">

            <div class="inner">
              <h3>Retina <span class="tooltip" title="Intelligently show retina enabled images based on device, which can IMPROVES the image qualtiy on retina enabled devices."><i class="fa fa-question-circle"></i></span></h3>

              <div class="checkbox-container-v2 simple">
                <input type="checkbox" id="retina-toggle" value="1" name="wp-ic-setting[retina]" data-setting_name="retina" data-setting_value="1" <?php echo checked($settings['retina'], '1'); ?>/>
                <div>
                  <label for="retina-toggle" class="wp-ic-ajax-checkbox-v2"></label>
                </div>
              </div>

            </div>

          </div>

          <div class="col-2 text-center">

            <div class="inner">
              <h3>Adaptive Images <span class="tooltip" title="Intelligently show images based on device size, which can DRASTICALLY reduce load times on mobile devices."><i class="fa fa-question-circle"></i></span>
              </h3>

              <div class="checkbox-container-v2 informative-input whole-checkbox">
                <input type="checkbox" id="adaptive-images-toggle" value="1" name="wp-ic-setting[generate_adaptive]" data-setting_name="generate_adaptive" data-setting_value="1" <?php echo checked($settings['generate_adaptive'], '1'); ?>/>
                <div>
                  <label for="adaptive-images-toggle" class="adaptive-toggle"></label>
									<?php if ($settings['generate_adaptive'] == '1') { ?>
                    <span>ON</span>
									<?php } else { ?>
                    <span>OFF</span>
									<?php } ?>
                </div>
              </div>

            </div>

          </div>

          <div class="col-2 text-center">
            <div class="inner">
              <h3>WebP <span class="tooltip" title="Serve next-gen image format WebP to supported browsers for additional file-size savings."><i class="fa fa-question-circle"></i></span></h3>

              <div class="checkbox-container-v2 informative-input whole-checkbox">
                <input type="checkbox" id="generate-webp-toggle" value="1"
                       name="wp-ic-setting[generate_webp]" data-setting_name="generate_webp" data-setting_value="1" <?php echo checked($settings['generate_webp'], '1'); ?>/>
                <div>
                  <label for="generate_webp" class="webp-toggle"></label>
									<?php if ($settings['generate_webp'] == '1') { ?>
                    <span>ON</span>
									<?php } else { ?>
                    <span>OFF</span>
									<?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-2 text-center">
            <div class="inner">
              <h3>Lazy Load <span class="tooltip" title="Load your images only when they are in viewport."><i class="fa fa-question-circle"></i></span>
              </h3>

              <div class="checkbox-container-v2 informative-input whole-checkbox" style="display: inline-block;">
                <input type="checkbox" id="cdn-toggle" value="1" name="wp-ic-setting[lazy]" data-setting_name="lazy" data-setting_value="1" <?php echo checked($settings['lazy'], '1'); ?>/>
                <div>
                  <label for="lazy-toggle" class="lazy-toggle"></label>
									<?php if ($settings['lazy'] == '1') { ?>
                    <span>ON</span>
									<?php } else { ?>
                    <span>OFF</span>
									<?php } ?>
                </div>
              </div>
            </div>
          </div>


          <div class="col-2 text-center">
            <div class="inner">
              <h3>Preserve Exif <span class="tooltip" title="An advanced feature for photographers. If you’re unsure of what this means it’s best to leave it off."><i class="fa fa-question-circle"></i></span>
              </h3>

              <div class="checkbox-container-v2 informative-input whole-checkbox" style="display: inline-block;">
                <input type="checkbox" id="cdn-toggle" value="1" name="wp-ic-setting[preserve_exif]" data-setting_name="preserve_exif" data-setting_value="1" <?php echo checked($settings['preserve_exif'], '1'); ?>/>
                <div>
                  <label for="preserve_exif-toggle" class="preserve_exif-toggle"></label>
									<?php if ($settings['preserve_exif'] == '1') { ?>
                    <span>ON</span>
									<?php } else { ?>
                    <span>OFF</span>
									<?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>

        </div>

        <div class="wp-compress-settings-footer">
          <div class="wp-compress-separator"></div>
          <ul>
            <li>
              <a href="https://wpcompress.com/pricing/">Get More Credits</a>
            </li>
            <li>
              <a href="https://wpcompress.com/quick-start/">Getting Started Guide</a>
            </li>
            <li>
              <a href="https://go.crisp.chat/chat/embed/?website_id=afb69c89-31ce-4a64-abc8-6b11e22e3a10">Chat with Support</a>
            </li>
            <li>
              <a href="<?php echo admin_url('options-general.php?page=wpcompress&view=debug_tool'); ?>">Debug Tool</a>
            </li>
            <li>
              <a href="<?php echo admin_url('options-general.php?page=wpcompress&check_account=true'); ?>">Clear Account Cache</a>
            </li>
          </ul>
        </div>

        <div class="wp-compress-settings-footer partners" style="display: none;">
          <ul>
            <li>
              <a href="https://wpcompress.com/go/astra"><img src="<?php echo WPS_IC_URI; ?>assets/partners/astra.png" title="Astra"/></a>
            </li>
            <li>
              <a href="https://wp-pagebuilderframework.com/"><img src="<?php echo WPS_IC_URI; ?>assets/partners/page-builder-framework-logo.png" title="WP PageBuilder Framework"/></a>
            </li>
            <li>
              <a href="https://wpcompress.com/go/swift"><img src="<?php echo WPS_IC_URI; ?>assets/partners/swift.png" title="Swift"/></a>
            </li>
            <li>
              <a href="https://wpcompress.com/go/mainwp"><img src="<?php echo WPS_IC_URI; ?>assets/partners/mainwp.png" title="MainWP"/></a>
            </li>
            <li>
              <a href="https://wpcompress.com/go/cloudways"><img src="<?php echo WPS_IC_URI; ?>assets/partners/cw.png" title="CloudWays"/></a>
            </li>
          </ul>
        </div>

      </div>

    </div>

    <div id="thumbnails-popup" style="display: none;">
      <div id="thumbnails-popup-inner">

        <img src="<?php echo WPS_IC_URI; ?>assets/thumbnails-config.png" style="margin-top: 15px;"/>

        <h3>Thumbnail Options</h3>
        <p>WP Compress Membership makes it easy to fully automate image optimization.</p>


        <a href="#" class="checkbox-container-click wp-ic-thumbnails-select-all" data-checked="false">
          <div class="select-all-thumbs-container" style="border-right: 0px;">
            <h3>Select All Sizes</h3>
          </div>
        </a>

        <div class="popup-wrap" id="checkbox-list-container">

          <h3 style="text-align: center">Loading settings...</h3>

        </div>
      </div>
    </div>

    <div id="lazy-compatibility-popup" style="display: none;">
      <div id="cdn-popup-inner" class="ic-compress-all-popup">

        <div class="cdn-popup-top">
          <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
        </div>

        <div class="cdn-popup-content">
          <h3>Please Confirm Compatibility</h3>
          <p>Advanced features such as serving images with lazy load may conflict with your active themes, plugins or environment. If any issues occur after activating, you can simply toggle it off.</p>
        </div>

      </div>
    </div>

    <div id="generate_adaptive-compatibility-popup" style="display: none;">
      <div id="cdn-popup-inner" class="ic-compress-all-popup">

        <div class="cdn-popup-top">
          <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
        </div>

        <div class="cdn-popup-content">
          <h3>Please Confirm Compatibility</h3>
          <p>Advanced features such as serving Adaptive Images may conflict with your active themes, plugins or environment. If any issues occur after activating, you can simply toggle it off.</p>
        </div>

      </div>
    </div>
    <div id="legacy-enable-popup" style="display: none;">
      <div id="cdn-popup-inner" class="popup-switch-cdn">

        <div class="cdn-popup-top" style="margin-top:20px;">
          <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/local-optimize.svg" style="margin-left: 40px;"/>
        </div>

        <div class="cdn-popup-content">
          <h3>Want to Locally Optimize Images?</h3>
          <p>Switching to local compression allows you to optimize your local media library and disables live optimization. Images will no longer be delivery on-the-fly from our lightning fast CDN Network.</p>
        </div>

      </div>
    </div>
    <div id="no-credits-popup" style="display: none;">
      <div id="cdn-popup-inner" class="ic-compress-all-popup">

        <div class="cdn-popup-top">
          <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
        </div>

        <div class="cdn-popup-content" style="padding-bottom: 50px;">
          <h3>Ooops, you have no quota left.</h3>
          <p>Seems like your account has exhausted all credits and it automatically reverted to "Local" Mode to prevent CDN Issues.</p>
          <a href="https://www.wpcompress.com/pricing" target="_blank" class="button button-primary">Get Credits</a>
        </div>

      </div>
    </div>
    <div id="local-disabled-popup" style="display: none;">
      <div id="cdn-popup-inner" class="popup-switch-cdn">

        <div class="cdn-popup-top" style="margin-top:20px;">
          <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/local-optimize.svg" style="margin-left: 40px;"/>
        </div>

        <div class="cdn-popup-content">
          <h3>Local Mode Locked</h3>
          <p>Your current plan does not support local image optimization. If you have any questions please reach out via chat support or <a href="https://wpcompress.com/support" target="_blank">click here</a>.</p>
        </div>

      </div>
    </div>
    <div id="cdn-popup" style="display: none;">
      <div id="cdn-popup-inner">

        <h3>We are scanning your Media Library</h3>
        <p>We need to verify that all of your images have been pushed to the CDN.</p>

      </div>
    </div>
    <div id="leave-popup" style="display: none;">
      <div id="cdn-popup-inner">

        <div class="wps-ic-inner wps-ic-spinner">
          <img src="<?php echo WPS_IC_URI; ?>assets/images/spinner.svg"/>
        </div>

        <h3>We are working on your Media Library</h3>
        <p>If you refresh or leave this tab our worker will stop until tab is open again.</p>

      </div>
    </div>
    <div id="cdn-reset-popup" style="display: none;">
      <div id="cdn-popup-inner">

        <div class="wps-ic-inner wps-ic-spinner">
          <img src="<?php echo WPS_IC_URI; ?>assets/images/spinner.svg"/>
        </div>

        <h3>We are purging our CDN Cache</h3>
        <p>This might take up to 30 seconds...</p>

      </div>
    </div>
    <div id="stats-reset-popup" style="display: none;">
      <div id="cdn-popup-inner">

        <div class="wps-ic-inner wps-ic-spinner">
          <img src="<?php echo WPS_IC_URI; ?>assets/images/spinner.svg"/>
        </div>

        <h3>We are purging our Stats Database</h3>
        <p>This might take up to 30 seconds...</p>

      </div>
    </div>

  </div>


  <script type="text/javascript">
		<?php
		$labels = array();
		$in_traffic = '';
		$out_traffic = '';
		$images_charts = '';

		function format_KB($value) {
			$value = $value / 1000;
			$value = $value / 1000;

			return round($value, 3);
		}

		$labels_dates = array();
		$limit = 10;

		// Calculate offset
		$item = 0;

		if (empty($settings['live-cdn']) || $settings['live-cdn'] == '0') {
			// Local Data
			$stats_local = $statsclass->fetch_local_stats();

			if (empty($stats_local->data)) {
				$stats = $statsclass->fetch_sample_stats();
				$stats = $stats->data;
			}
			else {
				$stats = $statsclass->fetch_local_stats();
				$stats = $stats->data;
				unset($stats->total);
			}

		}
		else {

			// Live Data
			if ( ! $stats_live) {
				// Sample data
				$stats = $statsclass->fetch_sample_stats();
				$stats = $stats->data;
			}
			else {
				$stats = $statsclass->fetch_live_stats();
				$stats = $stats->data;
			}
		}

		if ($stats) {
			foreach ($stats as $date => $value) {
				$index                            = date('d-m-Y', strtotime($date));
				$labels[ $index ]['date']         = date('m/d/Y', strtotime($date));
				$labels[ $index ]['total_input']  = $value->original;
				$labels[ $index ]['total_output'] = $value->compressed;

				if ($labels[ $index ]['total_input'] < 0) {
					$labels[ $index ]['total_input'] = 0;
				}

				if ($labels[ $index ]['total_output'] < 0) {
					$labels[ $index ]['total_output'] = 0;
				}
			}
		}

		asort($labels);

		$count_labels = count($labels);
		if ($count_labels == 4) {
			$catpercentage = 0.20;
		}
		else if ($count_labels == 3) {
			$catpercentage = 0.12;
		}
		else if ($count_labels <= 2) {
			$catpercentage = 0.05;
		}
		else if ($count_labels >= 5 && $count_labels <= 8) {
			$catpercentage = 0.2;
		}
		else if ($count_labels >= 8 && $count_labels <= 10) {
			$catpercentage = 0.4;
		}
		else {
			$catpercentage = 0.55;
		}

		// Parse to javascript
		$labels_js = '';
		$biggestY = 0;
		if ($labels) {

			foreach ($labels as $date => $data) {
				$labels_js   .= '"' . date('m/d/Y', strtotime($data['date'])) . '",';
				$in_traffic  .= format_KB($data['total_input'] - $data['total_output']) . ',';
				$out_traffic .= format_KB($data['total_output']) . ',';

				$kbIN  = format_KB($data['total_input']);
				$kbOUT = format_KB($data['total_output']);

				if ($kbIN > $kbOUT) {
					if ($biggestY < $kbIN) {
						$biggestY = $kbIN;
					}
				}
				else {
					if ($biggestY < $kbOUT) {
						$biggestY = $kbOUT;
					}
				}

			}

		}

		// Calculate Max
		$biggestY = ceil($biggestY);
		$fig = (int)str_pad('1', 2, '0');
		$maxY = ceil((ceil($biggestY * $fig) / $fig));

		$stepSize = $maxY / 10;

		if ($maxY <= 10) {
			$stepSize = 1;
		}
		else if ($maxY <= 100) {
			$stepSize = 10;
		}
		else if ($maxY <= 500) {
			$stepSize = 25;
		}
		else if ($maxY <= 1000) {
			$stepSize = 100;
		}
		else if ($maxY <= 2000) {
			$stepSize = 200;
		}
		else {
			$stepSize = 500;
		}

		if (! empty($labels) && ! empty($stats)) {


		$out_traffic = rtrim($out_traffic, ',');
		$in_traffic = rtrim($in_traffic, ',');
		$images_charts = rtrim($images_charts, ',');


		$labels_js = rtrim($labels_js, ',');

		function roundUpToAny($n, $x = 5) {
			if ($x < 5) {
				$x = 2;
			}

			return (ceil($n) % $x === 0) ? ceil($n) : round(($n + $x / 2) / $x) * $x;
		}

		?>

    function tooltipValue(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        bytes = bytes * 1000 * 1000;
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1000)));
        return (bytes / Math.pow(1000, i)).toFixed(1) + ' ' + sizes[i];
    }

		<?php
		if (empty($settings['live-cdn']) || $settings['live-cdn'] == '0') {
		?>
    var config = {
        type: 'bar',
        data: {
            labels: [<?php echo $labels_js; ?>],
            datasets: [{
                label: "After Optimization",
                fill: false,
                backgroundColor: '#3c4cdf',
                borderColor: '#3c4cdf',
                data: [
									<?php echo $out_traffic; ?>
                ],
                fill: false,
            }, {
                label: "Original",
                backgroundColor: '#09a8fc',
                borderColor: '#09a8fc',
                data: [
									<?php echo $in_traffic; ?>
                ],
                fill: false,
            }]
        },
        options: {
            legend: false,
            responsive: true,
            title: {
                display: false,
                text: ''
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                itemSort: function (a, b) {
                    return b.datasetIndex - a.datasetIndex
                },
                callbacks: {
                    label: function (tooltipItems, data) {
                        var tooltip = tooltipValue(tooltipItems.yLabel);

                        // Index of the column
                        var indexColumn = tooltipItems.index;
                        var after = data.datasets[0].data[indexColumn];
                        var before = data.datasets[1].data[indexColumn];

                        if (tooltipItems.datasetIndex == 0) {
                            // Original
                            var prefix = 'After ';
                        } else {
                            // Compressed
                            var prefix = 'Before ';
                        }


                        if (tooltipItems.datasetIndex == 0) {
                            return prefix + tooltip;
                        } else {
                            return prefix + tooltipValue(before + after);
                        }
                    }
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            elements: {
                line: {
                    tension: 0.00000001
                }
            },
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    categoryPercentage: <?php echo $catpercentage; ?>,
                    barThickness: 20,
                    stacked: true,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    ticks: {
                        max: <?php echo roundUpToAny($maxY, $stepSize); ?>,
                        beginAtZero: true,
                        stepSize:<?php echo $stepSize; ?>,
                        callback: function (value, index, values) {
                            //return Math.ceil(value) + ' MB';
                            return value + ' MB';
                        }
                    },
                    stacked: true,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'MB'
                    }
                }]
            }
        }
    };
		<?php } else { ?>
    var config = {
        type: 'bar',
        data: {
            labels: [<?php echo $labels_js; ?>],
            datasets: [{
                label: "After Optimization",
                fill: false,
                backgroundColor: '#3c4cdf',
                borderColor: '#3c4cdf',
                data: [
									<?php echo $out_traffic; ?>
                ],
                fill: false,
            }, {
                label: "Original",
                backgroundColor: '#09a8fc',
                borderColor: '#09a8fc',
                data: [
									<?php echo $in_traffic; ?>
                ],
                fill: false,
            }]
        },
        options: {
            legend: false,
            responsive: true,
            title: {
                display: false,
                text: ''
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                itemSort: function (a, b) {
                    return b.datasetIndex - a.datasetIndex
                },
                callbacks: {
                    label: function (tooltipItems, data) {
                        var tooltip = tooltipValue(tooltipItems.yLabel);

                        // Index of the column
                        var indexColumn = tooltipItems.index;
                        var after = data.datasets[0].data[indexColumn];
                        var before = data.datasets[1].data[indexColumn];

                        if (tooltipItems.datasetIndex == 0) {
                            // Original
                            var prefix = 'After ';
                        } else {
                            // Compressed
                            var prefix = 'Before ';
                        }


                        if (tooltipItems.datasetIndex == 0) {
                            return prefix + tooltip;
                        } else {
                            return prefix + tooltipValue(after + before);
                        }
                    }
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            elements: {
                line: {
                    tension: 0.00000001
                }
            },
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    categoryPercentage: <?php echo $catpercentage; ?>,
                    barThickness: 20,
                    stacked: true,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    ticks: {
                        max: <?php echo roundUpToAny($maxY, $stepSize); ?>,
                        beginAtZero: true,
                        stepSize:<?php echo $stepSize; ?>,
                        callback: function (value, index, values) {
                            return Math.ceil(value) + ' MB';
                            //return value + ' MB';
                        }
                    },
                    stacked: true,
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: 'MB'
                    }
                }]
            }
        }
    };
		<?php } ?>

		<?php } ?>

  </script>
  <script type="text/javascript">
      jQuery(document).ready(function ($) {

				<?php if (! empty($labels) && ! empty($stats)) { ?>
          setTimeout(function () {
              if ($('#canvas').length) {
                  var ctx = document.getElementById("canvas").getContext("2d");
                  window.myLine = new Chart(ctx, config);
              }
          }, 200);
				<?php } ?>
      });
  </script>

<?php }
else {
	switch ($_GET['view']) {
		case 'debug_tool':
			include 'debug_tool.php';
			break;
		case 'advanced_settings':
			include 'advanced_settings.php';
			break;
	}
}