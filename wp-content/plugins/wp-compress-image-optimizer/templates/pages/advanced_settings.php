<?php global $wps_ic, $wpdb;
$settings = get_option(WPS_IC_SETTINGS);

/**
 * Get Credits
 */
$user_credits = $wps_ic->check_account_status();

// 1GB => WPS_IC_GB

$allow_cname = false;

if (!empty($user_credits->account->allow_cname)) {
	$allow_cname = $user_credits->account->allow_cname;
}

if ($allow_cname) {
	set_transient('ic_allow_cname', 'true', 15 * 60);
}
else {
	delete_transient('ic_allow_cname');
}

if ( ! empty($_GET['test_lock'])) {
	delete_transient('ic_allow_cname');
	delete_option('hide_upgrade_notice');
}

$allow_cname = get_transient('ic_allow_cname');
?>
<div class="wrap">
  <div class="wps_ic_wrap wps_ic_settings_page">

    <div class="wp-compress-header">
      <div class="wp-ic-logo-container">
        <div class="wp-compress-logo">
          <img src="<?php echo WPS_IC_URI; ?>assets/images/logo/blue-icon.svg" alt="WP Compress"/>
          <div class="wp-ic-logo-inner">
            <h3 style="color: #333;">WP Compress <span class="small">v<?php echo $wps_ic::$version; ?></span></h3>
          </div>
        </div>
      </div>
      <div class="wp-ic-header-buttons-container">
        <ul>
          <li><a href="<?php echo admin_url('admin.php?page=wpcompress'); ?>" class="button button-primary button-transparent">Back to plugin</a></li>
					<?php
					/*<li><a href="<?php echo admin_url('admin.php?page=wpcompress'); ?>" class="button button-primary button-grd button-save-settings">Save</a></li>*/
					?>
        </ul>

      </div>
      <div class="clearfix"></div>
    </div>

		<?php
		$locked_css_class    = '';
		$locked_tooltip      = '';
		$hide_upgrade_notice = get_option('hide_upgrade_notice');
		if (empty($allow_cname) || ! empty($_GET['test_lock'])) {

			$settings      = get_option(WPS_IC_SETTINGS);
			$lock_settings = array('defer-js', 'external-images', 'emoji-remove', 'css_image_urls');
			foreach ($lock_settings as $k => $v) {
				if ( ! empty($settings[ $v ]) && $settings[ $v ] == '1') {
					$settings[ $v ] = '0';
				}
			}

			update_option(WPS_IC_SETTINGS, $settings);
			$locked_tooltip   = 'title="Advanced options are locked to accounts which have over 1GB of quota."';
			$locked_css_class = 'locked tooltip';
			if ( ! $hide_upgrade_notice || $hide_upgrade_notice == 0) {
				?>
        <div class="upgrade-to-pro-container">
          <div class="inner">
            <h3><img src="<?php echo WPS_IC_URI; ?>assets/images/star.svg" style="padding: 0px 20px;" alt="Upgrade to Pro"/> Upgrade to Pro to get all advanced features</h3>
            <a href="https://wpcompress.com/pricing/" target="_blank" class="upgrade-btn">Upgrade Now</a>
            <a href="#" class="close-pro-btn">
              <i class="fa fa-times"></i>
            </a>
          </div>
        </div>
			<?php } ?>
		<?php } ?>


    <div class="settings-container" style="margin-bottom: 25px">
      <div class="inner">

        <div class="setting-group">
          <div class="setting-header">
            Serve JavaScript via CDN <span class="tooltip" title="We will push all your JS files to our CDN."><i class="fa fa-question-circle"></i></span>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-custom wps-ic-ajax-checkbox" style="display: inline-block;">
              <input type="checkbox" id="js-toggle" value="1" name="wp-ic-setting[js]" data-setting_name="js" data-setting_value="1" <?php echo checked($settings['js'], '1'); ?>/>
              <div>
                <label for="js-toggle" class="js-toggle"></label>
              </div>
              <div class="label-holder">
								<?php if ( ! empty($settings['js']) && $settings['js'] == '1') { ?>
                  On
								<?php } else { ?>
                  Off
								<?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="setting-group">
          <div class="setting-header">
            Defer JavaScript <?php if ( ! empty($locked_css_class)) { ?> <span class="tooltip" title="We will defer all your JS files."><i class="fa fa-question-circle"></i></span> <?php } ?>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-custom wps-ic-ajax-checkbox <?php echo $locked_css_class; ?>" <?php echo $locked_tooltip; ?> style="display: inline-block;">
              <input type="checkbox" id="defer-js-toggle" value="1" name="wp-ic-setting[defer-js]" data-setting_name="defer-js" data-setting_value="1" <?php echo checked($settings['defer-js'], '1'); ?>/>
              <div>
                <label for="defer-js-toggle" class="defer-js-toggle"></label>
              </div>
              <div class="label-holder">
								<?php if ( ! empty($settings['defer-js']) && $settings['defer-js'] == '1') { ?>
                  On
								<?php } else { ?>
                  Off
								<?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="setting-group">
          <div class="setting-header">
            Serve CSS via CDN <span class="tooltip" title="We will push all your CSS files to our CDN."><i class="fa fa-question-circle"></i></span>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-custom wps-ic-ajax-checkbox" style="display: inline-block;">
              <input type="checkbox" id="css-toggle" value="1" name="wp-ic-setting[css]" data-setting_name="css" data-setting_value="1" <?php echo checked($settings['css'], '1'); ?>/>
              <div>
                <label for="css-toggle" class="css-toggle"></label>
              </div>
              <div class="label-holder">
								<?php if ( ! empty($settings['css']) && $settings['css'] == '1') { ?>
                  On
								<?php } else { ?>
                  Off
								<?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="setting-group">
          <div class="setting-header">
            Change image URL inside CSS <?php if ( ! empty($locked_css_class)) { ?><span class="tooltip" title="We will update your image URLs inside CSS files to redirect to CDN."><i class="fa fa-question-circle"></i></span> <?php } ?>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-custom wps-ic-ajax-checkbox <?php echo $locked_css_class; ?>" <?php echo $locked_tooltip; ?> style="display: inline-block;">
              <input type="checkbox" id="css_image_urls-toggle" value="1" name="wp-ic-setting[css_image_urls]" data-setting_name="css_image_urls" data-setting_value="1" <?php echo checked($settings['css_image_urls'], '1'); ?>/>
              <div>
                <label for="css_image_urls-toggle" class="css_image_urls-toggle"></label>
              </div>
              <div class="label-holder">
								<?php if ( ! empty($settings['css_image_urls']) && $settings['css_image_urls'] == '1') { ?>
                  On
								<?php } else { ?>
                  Off
								<?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="setting-group" style="padding-bottom:0px;">
          <div class="setting-header">
            External URLs <?php if ( ! empty($locked_css_class)) { ?><span class="tooltip" title="Optimize and load all images on your website, including those from third party urls."><i class="fa fa-question-circle"></i></span> <?php } ?>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-custom wps-ic-ajax-checkbox <?php echo $locked_css_class; ?>" <?php echo $locked_tooltip; ?> style="display: inline-block;">
              <input type="checkbox" id="external-url-toggle" value="1" name="wp-ic-setting[external-url]" data-setting_name="external-url" data-setting_value="1" <?php echo checked($settings['external-url'], '1'); ?>/>
              <div>
                <label for="external-url-toggle" class="external-url-toggle"></label>
              </div>
              <div class="label-holder">
								<?php if ( ! empty($settings['external-url']) && $settings['external-url'] == '1') { ?>
                  On
								<?php } else { ?>
                  Off
								<?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="setting-group" style="padding-bottom:0px;">
          <div class="setting-header">
            Disable WP Emoji <?php if ( ! empty($locked_css_class)) { ?><span class="tooltip" title="We will remove wp-emoji JavaScript from your site."><i class="fa fa-question-circle"></i></span><?php } ?>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-custom wps-ic-ajax-checkbox <?php echo $locked_css_class; ?>" <?php echo $locked_tooltip; ?> style="display: inline-block;">
              <input type="checkbox" id="emoji-remove-toggle" value="1" name="wp-ic-setting[emoji-remove]" data-setting_name="emoji-remove" data-setting_value="1" <?php echo checked($settings['emoji-remove'], '1'); ?>/>
              <div>
                <label for="emoji-remove-toggle" class="emoji-remove-toggle"></label>
              </div>
              <div class="label-holder">
								<?php if ( ! empty($settings['emoji-remove']) && $settings['emoji-remove'] == '1') { ?>
                  On
								<?php } else { ?>
                  Off
								<?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

		<?php /*
    <div class="settings-container" style="margin-bottom: 25px;display: none;">
      <div class="inner">

        <div style="display: block;width:100%;"><h3>BETA Features</h3></div>

        <div class="setting-group">
          <div class="setting-header">
            Development CDN <span class="tooltip" title="Some description."><i class="fa fa-question-circle"></i></span>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-v2 informative-input whole-checkbox" style="display: inline-block;">
              <input type="checkbox" id="html-cache-toggle" value="1" name="wp-ic-setting[dev-cdn]" data-setting_name="dev-cdn" data-setting_value="1" <?php echo checked($settings['dev-cdn'], '1'); ?>/>
              <div>
                <label for="html-cache-toggle" class="html-cache-toggle"></label>
								<?php if ($settings['dev-cdn'] == '1') { ?>
                  <span>ON</span>
								<?php } else { ?>
                  <span>OFF</span>
								<?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="setting-group">
          <div class="setting-header">
            Enable API v4 <span class="tooltip" title="Some description."><i class="fa fa-question-circle"></i></span>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-v2 informative-input whole-checkbox" style="display: inline-block;">
              <input type="checkbox" id="apiv4-toggle" value="1" name="wp-ic-setting[apiv4]" data-setting_name="apiv4" data-setting_value="1" <?php echo checked($settings['apiv4'], '1'); ?>/>
              <div>
                <label for="apiv4-toggle" class="apiv4-toggle"></label>
								<?php if ($settings['apiv4'] == '1') { ?>
                  <span>ON</span>
								<?php } else { ?>
                  <span>OFF</span>
								<?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="setting-group">
          <div class="setting-header">
            Disable Bunny (Direct CF) <span class="tooltip" title="Some description."><i class="fa fa-question-circle"></i></span>
          </div>
          <div class="setting-value">
            <div class="checkbox-container-v2 informative-input whole-checkbox" style="display: inline-block;">
              <input type="checkbox" id="direct-cf-toggle" value="1" name="wp-ic-setting[direct-cf]" data-setting_name="direct-cf" data-setting_value="1" <?php echo checked($settings['direct-cf'], '1'); ?>/>
              <div>
                <label for="direct-cf-toggle" class="direct-cf-toggle"></label>
								<?php if ($settings['direct-cf'] == '1') { ?>
                  <span>ON</span>
								<?php } else { ?>
                  <span>OFF</span>
								<?php } ?>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    */ ?>

    <div class="settings-container">
      <div class="inner">
        <div class="setting-group full-width">
          <div class="setting-header" style="line-height: 30px;">
            <strong>Custom CDN Domain</strong> <span class="tooltip" title="Custom CNAME DNS propagation can take up to 48 hours, please make sure your cname is working properly after enabling."><i class="fa
        fa-question-circle"></i></span>
          </div>
					<?php
					if ( ! empty($allow_cname)) {
						?>
            <div class="setting-value">
							<?php

							$save      = false;
							$deleted   = false;
							$zone_name = get_option('ic_cdn_zone_name');

							if ( ! empty($_POST['cname_reset'])) {
								$agent   = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0';
								$options = get_option(WPS_IC_OPTIONS);
								$apikey  = $options['api_key'];
								$cname   = get_option('ic_custom_cname');
								$url     = WPS_IC_KEYSURL . '?action=cdn_removecname&apikey=' . $apikey . '&cname=' . $cname . '&zone_name=' . $zone_name . '&time=' . time() . '&no_cache=' . md5(mt_rand(999, 9999));
								$call    = wp_remote_get($url, array('timeout' => 60, 'sslverify' => false, 'user-agent' => $agent));
								delete_option('ic_custom_cname');
								$settings = get_option(WPS_IC_SETTINGS);
								unset($settings['cname']);
								update_option(WPS_IC_SETTINGS, $settings);
								$error   = '';
								$deleted = true;
							}

							if ( ! empty($_POST['cname'])) {
								$error   = '';
								$options = get_option(WPS_IC_OPTIONS);
								$apikey  = $options['api_key'];

								// TODO is cname valid?
								$cname = sanitize_text_field($_POST['cname']);
								$cname = str_replace(array('http://', 'https://'), '', $cname);
								$cname = rtrim($cname, '/');

								if ($zone_name == $cname) {
									$error = 'This domain is invalid, please link a new domain...';
								}

								if (strpos($cname, 'zapwp.com') !== false || strpos($cname, 'zapwp.net') !== false || strpos($cname, 'wpcompress.com') !== false) {
									$error = 'This domain is invalid, please link a new domain...';
								}

								if (empty($error)) {
									$url = WPS_IC_KEYSURL . '?action=cdn_setcname&apikey=' . $apikey . '&cname=' . $cname . '&zone_name=' . $zone_name . '&time=' . time() . '&no_cache=' . md5(mt_rand(999, 9999));

									if ( ! preg_match('/^([a-zA-z0-9\_\-]+)\.([a-zA-z0-9\_\-]+)\.([a-zA-z0-9\_\-]+)$/', $cname, $matches) && ! preg_match('/^([a-zA-z0-9\_\-]+)\.([a-zA-z0-9\_\-]+)\.([a-zA-z0-9\_\-]+)\.([a-zA-z0-9\_\-]+)$/', $cname, $matches)) {
										// Subdomain is not valid
										$error = 'This domain is invalid, please link a new domain...';
										delete_option('ic_custom_cname');
										$settings = get_option(WPS_IC_SETTINGS);
										unset($settings['cname']);
										update_option(WPS_IC_SETTINGS, $settings);
									}
									else {
										$save = true;
										update_option('ic_custom_cname', sanitize_text_field($cname));
										$agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0';
										$call  = wp_remote_get($url, array('timeout' => 60, 'sslverify' => false, 'user-agent' => $agent));
									}
								}
							}

							$custom_cname = get_option('ic_custom_cname');
							if ( ! $custom_cname) {
								$custom_cname = '';
							}

							if ( ! empty($error)) {
								echo '<h4 style="color:#aa0000;">' . $error . '</h2>';
							}
							else {
								if ($save || ! empty($_GET['saved'])) {
									echo '<div class="wps-ic-cname-saved"><span class="ic-round-icon"><i class="icon-ok"></i></span><h4 style="color:#2fb940;">We have saved your changes!</h4></div>';
									echo '<div style="display:block;"></div>';
								}
							}

							if ($deleted || ! empty($_GET['deleted'])) {
								echo '<div class="wps-ic-cname-removed"><span class="ic-round-icon"><i class="icon-attention-alt"></i></span><h4 style="color:#2fb940;">We have removed your custom CNAME!</h4></div>';
								echo '<div style="display:block;"></div>';
							}

							?>
							<?php
							if (empty($custom_cname)) {
								?>
                <p>You can use <i>any domain you own</i> to serve the optimized images and assets.</p>
                <p>Simply create a subdomain on the domain you wish to use, then add a new CNAME record pointing to <strong><?php echo $zone_name; ?></strong></p>
                <form method="post" action="#" style="display: inline-block;margin-top: 10px;">
                  <input type="text" name="cname" placeholder="e.g. Enter Your Subdomain URL Here" value="<?php echo $custom_cname; ?>" style="width: 300px;"/> <input type="submit" class="button-primary" value="Save"/>
                </form>
							<?php } else { ?>
                <div class="checkbox-container-v2 informative-input whole-checkbox" style="display: inline-block;">
                  <input type="checkbox" id="cname-toggle" value="1" name="wp-ic-setting[cname]" data-setting_name="cname" data-setting_value="1" <?php echo checked($settings['cname'], '1'); ?>/>
                  <div>
                    <label for="cname-toggle" class="cname-toggle"></label>
										<?php if ($settings['cname'] == '1') { ?>
                      <span>ON</span>
										<?php } else { ?>
                      <span>OFF</span>
										<?php } ?>
                  </div>
                </div>
                <form method="post" action="#" style="display: inline-block;vertical-align: top;line-height: 55px;">
                  <input type="hidden" name="cname_reset" value="1"/>
                  <p style="margin: 0 10px;display:inline-block;">You have linked custom CNAME <strong><?php echo $custom_cname; ?></strong> to <strong><?php echo $zone_name; ?></strong></p>
                  <input type="submit" class="button-primary" value="Reset" style="vertical-align: middle"/>
                </form>
							<?php } ?>
            </div>
					<?php } else { ?>
            <div class="setting-value">
							<?php

							$save         = false;
							$deleted      = false;
							$zone_name    = get_option('ic_cdn_zone_name');
							$settings     = get_option(WPS_IC_SETTINGS);
							$custom_cname = get_option('ic_custom_cname');
							if ( ! $custom_cname) {
								$custom_cname = '';
							}

							if (empty($allow_cname)) {
								?>
                <p>You can use <i>any domain you own</i> to serve the optimized images and assets.</p>
                <p>Simply create a subdomain on the domain you wish to use, then add a new CNAME record pointing to <strong><?php echo $zone_name; ?></strong></p>
                <form method="post" action="#" style="display: inline-block;margin-top: 10px;">
                  <input type="text" name="cname" placeholder="e.g. Enter Your Subdomain URL Here" value="<?php echo ''; ?>" style="width: 300px;"/>
                  <a class="button-primary button-locked-icon tooltip" target="_blank" title="Advanced options are locked to accounts which have over 1GB of quota." href="https://wpcompress.com/pricing/">Go Pro</a>
                </form>
							<?php } else { ?>
                <div class="checkbox-container-v2 informative-input whole-checkbox" style="display: inline-block;">
                  <input type="checkbox" id="cname-toggle" value="1" name="wp-ic-setting[cname]" data-setting_name="cname" data-setting_value="1" <?php echo checked($settings['cname'], '1'); ?>/>
                  <div>
                    <label for="cname-toggle" class="cname-toggle"></label>
										<?php if ($settings['cname'] == '1') { ?>
                      <span>ON</span>
										<?php } else { ?>
                      <span>OFF</span>
										<?php } ?>
                  </div>
                </div>
                <form method="post" action="#" style="display: inline-block;vertical-align: top;line-height: 55px;">
                  <input type="hidden" name="cname_reset" value="1"/>
                  You have linked custom CNAME <strong><?php echo $custom_cname; ?></strong> to <strong><?php echo $zone_name; ?></strong> <span>&nbsp;</span> <input type="submit" class="button-primary" value="Reset"/>
                </form>
							<?php } ?>
            </div>
					<?php } ?>
        </div>
      </div>
    </div>

  </div>


</div>
<div id="saving-settings-popup" style="display: none;">
  <div id="cdn-popup-inner" class="ajax-settings-popup">

    <div class="cdn-popup-top">
      <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/spinner.svg"/>
    </div>

    <div class="cdn-popup-content with-background">
      <h3>Saving your settings...</h3>
    </div>

  </div>
</div>
<div id="settings-saved-popup" style="display: none;">
  <div id="cdn-popup-inner" class="ajax-settings-saved-popup">

    <div class="cdn-popup-content">
      <lottie-player
        src="<?php echo WPS_IC_URI; ?>assets/lottie-icons/done.json" background="transparent" speed="1" style="width: 200px; height: 200px;margin:0 auto;" autoplay>
      </lottie-player>

      <h3>Your settings have been saved!</h3>
    </div>

  </div>
</div>
<div id="css_combine-compatibility-popup" style="display: none;">
  <div id="cdn-popup-inner" class="">

    <div class="cdn-popup-top">
      <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
    </div>

    <div class="cdn-popup-content">
      <h3>Please Confirm Compatibility</h3>
      <p>Advanced features such as Combine CSS Files may conflict with your active themes, plugins or environment. If any issues occur after activating, you can simply toggle it off.</p>
    </div>

  </div>
</div>
<div id="defer-js-compatibility-popup" style="display: none;">
  <div id="cdn-popup-inner" class="">

    <div class="cdn-popup-top">
      <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
    </div>

    <div class="cdn-popup-content">
      <h3>Please Confirm Compatibility</h3>
      <p>Advanced features such as Defer JavaScript may conflict with your active themes, plugins or environment. If any issues occur after activating, you can simply toggle it off.</p>
    </div>

  </div>
</div>
<div id="js-compatibility-popup" style="display: none;">
  <div id="cdn-popup-inner" class="">

    <div class="cdn-popup-top">
      <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
    </div>

    <div class="cdn-popup-content">
      <h3>Please Confirm Compatibility</h3>
      <p>Advanced features such as serving JavaScript from the CDN may conflict with your active themes, plugins or environment. If any issues occur after activating, you can simply toggle it off.</p>
    </div>

  </div>
</div>
<div id="css-compatibility-popup" style="display: none;">
  <div id="cdn-popup-inner" class="">

    <div class="cdn-popup-top">
      <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
    </div>

    <div class="cdn-popup-content">
      <h3>Please Confirm Compatibility</h3>
      <p>Advanced features such as serving static CSS from the CDN may conflict with your active themes, plugins or environment. If any issues occur after activating, you can simply toggle it off.</p>
    </div>

  </div>
</div>
<div id="locked-popup" style="display: none;">
  <div id="cdn-popup-inner" class="locked-popup">

    <div class="cdn-popup-top">
      <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/rocket.png"/>
    </div>

    <div class="cdn-popup-content">
      <h3>Option Locked</h3>
      <p>Advanced options are locked to account which have over 1GB of quota.</p>
    </div>

  </div>
</div>
<div id="emoji-remove-minify-compatibility-popup" style="display: none;">
  <div id="cdn-popup-inner" class="">

    <div class="cdn-popup-top">
      <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/compatibility.svg"/>
    </div>

    <div class="cdn-popup-content">
      <h3>Please Confirm Compatibility</h3>
      <p>Advanced features such as removing WP Emoji may conflict with your active themes, plugins or environment. If any issues occur after activating, you can simply toggle it off.</p>
    </div>

  </div>
</div>