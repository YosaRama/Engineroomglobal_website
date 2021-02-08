<?php global $wps_ic, $wpdb; ?>
<div class="wrap">
  <div class="wps_ic_wrap wps_ic_settings_page">

    <div class="wp-compress-header">
      <div class="wp-ic-logo-container">
        <div class="wp-compress-logo">
          <img src="<?php echo WPS_IC_URI; ?>assets/images/logo/blue-icon.svg"/>
          <div class="wp-ic-logo-inner">
            <h3 style="color: #333;">WP Compress <span class="small"><?php echo $wps_ic::$version; ?></span></h3>
          </div>
        </div>
      </div>
      <div class="wp-ic-header-buttons-container">
        <ul>
          <li><a href="<?php echo admin_url('admin.php?page=wpcompress'); ?>" class="button button-primary button-transparent">Back to plugin</a></li>
        </ul>

      </div>
    </div>

		<?php

		if ( ! empty($_GET['delete_option'])) {
			delete_option($_GET['delete_option']);
		}

		?>

    <div style="display: none;" id="compress-test-results" class="ic-test-results">
      <textarea id="compress-test-results-textarea" style="visibility: hidden;opacity: none;"></textarea>
      <div class="results-inner">
        <span class="ic-terminal-dot blink"><span></span></span>
      </div>
      <a href="#" class="copy-debug">Copy Debug Results</a>
    </div>

    <table id="information-table" class="wp-list-table widefat fixed striped posts">
      <thead>
      <tr>
        <th>Check Name</th>
        <th>Value</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>Reconnect Plugin</td>
        <td colspan="3">
          <p><?php
						echo '<a href="' . admin_url('admin.php?page=wpcompress&reconnect=true') . '" class="button-primary" style="margin-right:20px;">Reconnect</a>';
						?> Reconnect the plugin to the WP Compress API and CDN. </p>
        </td>
      </tr>
      <tr>
        <td>Enable JavaScript Debug</td>
        <td colspan="3">
          <p>
						<?php
						if ( ! empty($_GET['js_debug'])) {
							update_option('wps_ic_js_debug', sanitize_text_field($_GET['js_debug']));
						}

						if (get_option('wps_ic_js_debug') == 'false') {
							echo '<a href="' . admin_url('admin.php?page=wpcompress&view=debug_tool&js_debug=true') . '" class="button-primary" style="margin-right:20px;">Enable</a>';
						} else {
							echo '<a href="' . admin_url('admin.php?page=wpcompress&view=debug_tool&js_debug=false') . '" class="button-primary" style="margin-right:20px;">Disable</a>';
						}
						?>
            If you are having any sort of issues with our plugin, enabling this option will give you some basic debug output in Console log of your browser.
          </p>
        </td>
      </tr>
      <tr>
        <td>Switch Search & Replace Method</td>
        <td colspan="3">
          <p>
						<?php
						$settings = get_option(WPS_IC_SETTINGS);

						if ( ! empty($_GET['search_replace_method'])) {
							$settings['replace-method'] = $_GET['search_replace_method'];
							update_option(WPS_IC_SETTINGS, $settings);
						}

						if (empty($settings['replace-method']) || $settings['replace-method'] == 'dom') {
							echo '<a href="' . admin_url('admin.php?page=wpcompress&view=debug_tool&search_replace_method=regexp') . '" class="button-primary" style="margin-right:20px;">using DOM currently</a>';
						} else {
							echo '<a href="' . admin_url('admin.php?page=wpcompress&view=debug_tool&search_replace_method=dom') . '" class="button-primary" style="margin-right:20px;">using RegExp Currently</a>';
						}
						?>
            Click to switch between DOM or Regexp
          </p>
        </td>
      </tr>
      <tr>
        <td>Excluded List</td>
        <td>
					<?php
					$excluded = get_option('wps_ic_exclude_list');
					echo print_r($excluded, true);
					?>
        </td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>API Key</td>
        <td colspan="3">
					<?php
					$options = get_option(WPS_IC_OPTIONS);
					echo $options['api_key'];
					?>
        </td>

      </tr>
      <tr>
        <td>CDN Zone Name</td>
        <td>
					<?php
					echo get_option('ic_cdn_zone_name');
					?>
        </td>
        <td>
          <a href="<?php echo admin_url('options-general.php?page=wpcompress&view=debug_tool&delete_option=ic_cdn_zone_name'); ?>">Delete</a>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>Custom CDN Zone Name</td>
        <td>
					<?php
					echo get_option('ic_custom_cname');
					?>
        </td>
        <td><a href="<?php echo admin_url('options-general.php?page=wpcompress&view=debug_tool&delete_option=ic_custom_cname'); ?>">Delete</a></td>
        <td></td>
      </tr>

      <tr>
        <td>Plugin Activated</td>
        <td><?php
					if (is_plugin_active('wp-compress-image-optimizer/wp-compress.php')) {
						echo 'Yes';
						$status = 'OK';
					} else {
						echo 'No';
						$status = 'BAD';
					}
					?></td>
        <td><?php echo $status; ?></td>
        <td>None</td>
      </tr>
      <tr>
        <td>PHP Version</td>
        <td>
					<?php
					$version = phpversion();
					echo $version;
					if (version_compare($version, '7.0', '>=')) {
						$status = 'OK';
					} else {
						$status = 'BAD';
					}
					?>
        </td>
        <td><?php echo $status; ?></td>
        <td>None</td>
      </tr>
      <tr>
        <td>WP Version</td>
        <td>
					<?php
					$wp_version = get_bloginfo('version');
					echo $wp_version;
					if (version_compare($wp_version, '5.0', '>=')) {
						$status = 'OK';
					} else {
						$status = 'BAD';
					}
					?>
        </td>
        <td>
					<?php
					echo $status;
					?>
        </td>
        <td>
          None
        </td>
      </tr>
      <tr>
        <td>Options</td>
        <td colspan="3">
					<?php
					var_dump(get_option(WPS_IC_OPTIONS));
					?>
        </td>
      </tr>
      <tr>
        <td>Settings</td>
        <td colspan="3">
					<?php
					var_dump(get_option(WPS_IC_SETTINGS));
					?>
        </td>
      </tr>
      </tbody>
    </table>


  </div>


</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {


    });
</script>