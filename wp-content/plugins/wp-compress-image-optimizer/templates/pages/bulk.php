<?php
global $wps_ic, $wpdb;
/**
 * Fetch settings, or if save is triggered save them.
 * - If no settings are saved (bug, deleted options..) regenerate recommended
 */
$settings = get_option(WPS_IC_SETTINGS);

/**
 * Is the plugin paused? Default: No
 */
$live_cdn = false;
if ( ! empty($settings['live-cdn']) && $settings['live-cdn'] == '1') {
	$live_cdn = true;
}
?>
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

					<?php if (!$live_cdn) { ?>
            <li><a href="#" class="wps-ic-service-status paused">Live Optimization Paused</a></li>
					<?php } else { ?>
            <li><a href="#" class="wps-ic-service-status active">Live Optimization Active</a></li>
					<?php } ?>

          <li><a href="<?php echo admin_url('options-general.php?page=wpcompress'); ?>" class="button button-primary">Return to Dashboard</a></li>

          <li><a href="<?php echo admin_url('options-general.php?page=wpcompress&view=advanced_settings'); ?>" class="button button-primary">Advanced Settings</a></li>
        </ul>
      </div>
      <div class="clearfix"></div>
    </div>


    <div class="wp-compress-pre-wrapper">

      <div class="wp-compress-bulk-area">
				<?php
				/**
				 * Find uncompressed images
				 */
				$uncompressed_images = $wps_ic->media_library->find_uncompressed_images();
				$compressed_images = $wps_ic->media_library->find_compressed_images();
				?>
        <div class="bulk-finished" style="display: none;text-align: center;">
        </div>
        <div class="bulk-preparing-optimize" style="display: none;text-align: center;">
          <h3>Preparing to Optimize</h3>
          <img src="<?php echo WPS_IC_URI; ?>assets/images/spinner.svg"/>
        </div>
        <div class="bulk-preparing-restore" style="display: none;text-align: center;">
          <h3>Preparing to Restore</h3>
          <img src="<?php echo WPS_IC_URI; ?>assets/images/spinner.svg"/>
        </div>
        <div class="bulk-status" style="display: none;"></div>
        <div class="bulk-status-progress-bar" style="display: none;">
          <div class="progress-bar-outer">
            <div class="progress-bar-inner" style="width: 0%;"></div>
          </div>
        </div>
        <div class="bulk-restore-status-progress" style="display: none;">
          <div class="bulk-images-restored">
            <h3>274/274</h3>
            <h5>Images Restored</h5>
          </div>
        </div>
        <div class="bulk-compress-status-progress" style="display: none;">
          <div class="bulk-images-compressed">
            <h3>274/274</h3>
            <h5>Images Compressed</h5>
          </div>
          <div class="bulk-thumbs-compressed">
            <h3>274/274</h3>
            <h5>Thumbs Compressed</h5>
          </div>
          <div class="bulk-total-savings">
            <h3>232.23MB</h3>
            <h5>Total Savings</h5>
          </div>
          <div class="bulk-thumbs-savings">
            <h3>232.23MB</h3>
            <h5>Thumb Savings</h5>
          </div>
          <div class="bulk-avg-reduction">
            <h3>86%</h3>
            <h5>Average Reduction</h5>
          </div>
        </div>

        <div class="wp-compress-bulk-split" id="bulk-start-container">
          <div class="bulk-split-side">
            <div class="compress-bulk-start" style="padding:25px;">

              <div class="wps-ic-bulk-html-wrapper">
                <div class="wps-ic-bulk-header">
                  <div class="wps-ic-bulk-logo">

                    <div class="logo-holder" style="padding-top: 0px">
                      <img src="<?php echo WPS_IC_URI; ?>assets/images/logo/blue-icon.svg">
                    </div>


                  </div>
                </div>
              </div>
              <h3>We have found that you have <?php echo count($uncompressed_images); ?> uncompressed images.</h3>
              <?php if (count($uncompressed_images) > 0) { ?>
              <a href="<?php echo admin_url('options-general.php?page=wpcompress&view=bulk&action=compress'); ?>" class="button button-primary button-start-bulk-compress">Compress Images</a>
              <?php } ?>
            </div>
          </div>
          <div class="bulk-split-side">
            <div class="restore-bulk-start" style="padding:25px;">

              <div class="wps-ic-bulk-html-wrapper">
                <div class="wps-ic-bulk-header">
                  <div class="wps-ic-bulk-logo">

                    <div class="logo-holder" style="padding-top: 0px">
                      <img src="<?php echo WPS_IC_URI; ?>assets/images/logo/blue-icon.svg">
                    </div>

                  </div>
                </div>
              </div>
              <h3>We have found that you have <?php echo count($compressed_images); ?> compressed images.</h3>

							<?php if (count($compressed_images) > 0) { ?>
              <a href="<?php echo admin_url('options-general.php?page=wpcompress&view=bulk&action=restore'); ?>" class="button button-primary button-start-bulk-restore">Restore Images</a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div id="legacy-stop-process" style="display: none;">
    <div id="cdn-popup-inner">

      <div class="cdn-popup-top">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/process.svg"/>
      </div>

      <div class="cdn-popup-content">
        <h3>Want to Stop Optimizing Images?</h3>
        <p>All remaining images in the queue will not be optimized, you may resume by running bulk optimization again at anytime.</p>
      </div>

    </div>
  </div>
  <div id="legacy-restore-all" style="display: none;">
    <div id="cdn-popup-inner" class="ic-compress-all-popup">

      <div class="cdn-popup-top">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/process.svg"/>
      </div>

      <div class="cdn-popup-content">
        <h3>Want to Restore All Images?</h3>
        <p>Your media library will be restored to their original state, you may stop the process at any time.</p>
      </div>

    </div>
  </div>
  <div id="legacy-no-credits" style="display: none;">
    <div id="cdn-popup-inner">

      <div class="cdn-popup-top">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/no-credits.svg"/>
      </div>

      <div class="cdn-popup-content">
        <h3>You Don’t Have Enough Credits</h3>
        <p class="ic-content-replace">Purchase or allocate more credits to optimize your entire library you’ll need [uncompressed_images] credits, but only have [credits] credits remaining.</p>

      </div>

      <div class="cdn-popup-footer">
        <div class="cta-button-more-credits-container">
          <a href="https://wpcompress.com/pricing/" target="_blank" class="cta-button-more-credits">Get More Credits</a>
        </div>
        <a href="https://app.wpcompress.com" target="_blank" class="cta-button-grey">Go to Portal</a>
        <a href="#" class="cta-button-grey cta-btn-optimize-count">Optimize (X) Images</a>
      </div>

    </div>
  </div>
  <div id="legacy-compress-all" style="display: none;">
    <div id="cdn-popup-inner" class="ic-compress-all-popup">

      <div class="cdn-popup-top">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/process.svg"/>
      </div>

      <div class="cdn-popup-content">
        <h3>Want to Start Optimizing Images?</h3>
        <p>Your media library will be optimized based on the configured settings, you may stop the process at any time.</p>
      </div>

    </div>
  </div>
  <div id="legacy-restore-prepare" style="display: none;">
    <div id="cdn-popup-inner">

      <div class="cdn-popup-top" style="margin-top:20px;">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/preparing.svg" style="margin-left: 40px;"/>
      </div>

      <div class="cdn-popup-content">
        <h3>We're Preparing Your Images</h3>
        <p>Please wait... this can take up to one minute depending on the amount of images that you have in your media library.</p>
      </div>


    </div>
  </div>
  <div id="legacy-compress-prepare" style="display: none;">
    <div id="cdn-popup-inner">

      <div class="cdn-popup-top" style="margin-top:20px;">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/preparing.svg" style="margin-left: 40px;"/>
      </div>

      <div class="cdn-popup-content">
        <h3>We're Preparing Your Images</h3>
        <p>Please wait... this can take up to one minute depending on the amount of images that you have in your media library.</p>
      </div>

    </div>
  </div>
  <div id="legacy-nothing-to-compress" style="display: none;">
    <div id="cdn-popup-inner">

      <div class="cdn-popup-top" style="margin-top:20px;">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/all-done.svg" style="margin-left: 40px;"/>
      </div>

      <div class="cdn-popup-content">
        <h3>Your Images are Optimized!</h3>
        <p>It looks like all of your images are already optimized, look for to faster load times, decreased page sizes and more user engagement!</p>
      </div>

    </div>
  </div>
  <div id="legacy-nothing-to-restore" style="display: none;">
    <div id="cdn-popup-inner">

      <div class="cdn-popup-top" style="margin-top:20px;">
        <img class="popup-icon" src="<?php echo WPS_IC_URI; ?>assets/images/legacy/all-done.svg" style="margin-left: 40px;"/>
      </div>

      <div class="cdn-popup-content">
        <h3>Your Images are Restored!</h3>
        <p>It looks like all of your images are already restored, you may optimize them from the dashboard or media library at any time!</p>
      </div>

    </div>
  </div>
</div>