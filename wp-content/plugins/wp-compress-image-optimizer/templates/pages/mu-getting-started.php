<div class="wrap">
  <div class="wps_ic_wrap wps_ic_subscribe_container">

    <div class="wp-compress-header" style="background: #383838;">
      <div class="wp-ic-logo-container">
        <div class="wp-compress-logo">
          <img src="<?php echo WPS_IC_URI; ?>assets/images/logo/blue-icon.svg"/>
          <div class="wp-ic-logo-inner">
            <h3 style="color: #fff;">WP Compress</h3>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>

    <?php

    if (empty($response_key) || ! $response_key) {
      ?>


      <div class="wps_ic_form_centered">

        <h2>Welcome to MultiSite Linking</h2>
        <h3 style="text-align: center;">With this tool you are able to link all your WordPress sites with one click.</h3>

          <form method="post" action="<?php echo admin_url('admin.php?page=wpcompress&do=wps_ic_api_connect'); ?>" id="wps_ic_mu_activate_form">
            <div class="wps_ic_activate_form slideInUp animated">
              <div class="wps_ic_form_header">
                <h3>Link Your Websites</h3>
              </div>
              <div class="wps_ic_form_input">
                <label>API Key</label>
                <input type="text" name="apikey" placeholder="251c0fda3e2b4bff5f6d28cf28bf5452f70d32"/>
              </div>
              <div class="wps_ic_form_input pull_right">
                <input type="submit" name="submit" value="Activate"/>
              </div>
            </div>
          </form>

        <div class="wps-ic-form-loading-container" style="display:none;">
          <div class="wps-ic-form-loading"><img src="<?php echo WPS_IC_URI; ?>assets/images/spinner.svg"/></div>
        </div>


        <div class="wps-ic-form-success-container" style="display:none;">
          <div class="wps-ic-form-subscribe" style="display: none;">
            <img src="<?php echo WPS_IC_URI; ?>assets/images/confirmed.svg" alt="Success"/>
            <h3>We have sent confirmation e-mail to your address.</h3>
          </div>

          <div class="wps-ic-form-connect" style="display: none;">
            <img src="<?php echo WPS_IC_URI; ?>assets/images/confirmed.svg" alt="Success"/>
            <h3>We have successfully connected with cloud!</h3>
          </div>

          <div class="wps-ic-form-error" style="display: none;">
            <img src="<?php echo WPS_IC_URI; ?>assets/images/error.svg" alt="Error"/>
            <h3></h3>
            <p>Form will reappear in 5 seconds.</p>
          </div>
        </div>

        <div class="wps_ic_form_other_option">
            <a href="https://app.wpcompress.com/register" class="fadeIn noline" target="_blank">Go to Portal</a>
            <strong style="">OR</strong>
            <a href="https://wpcompress.com/getting-started" target="_blank" class="fadeIn noline" target="_blank">View Getting Started Guide</a>
        </div>


      </div>

    <?php } ?>

  </div>
</div>