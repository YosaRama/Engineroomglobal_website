<?php


/**
 * Class - Media Library
 */
class wps_ic_media_library extends wps_ic {

  public static $options;
  public static $response_key;


  public function __construct() {

    if ( ! is_admin()) {
      return;
    }

    $option              = get_option(WPS_IC_SETTINGS);
    $this::$response_key = parent::$response_key;

    $allow_local = get_option('wps_ic_allow_local');

    if ((empty($option['hide_compress']) || $option['hide_compress'] == '') &&
        (!empty($allow_local) && $allow_local == 'true')) {
      add_action('admin_footer', array(__CLASS__, 'media_library_popup'));

      // Register new columns
      add_filter('manage_media_columns', array(__CLASS__, 'wps_compress_column'));
      add_action('manage_media_custom_column', array(__CLASS__, 'wps_compress_column_value'), 10, 2);

      add_filter('wps_ic_pro_exclude', array(__CLASS__, 'wps_ic_pro_exclude_button'), 10, 2);
      add_filter('wps_ic_pro_include', array(__CLASS__, 'wps_ic_pro_include_button'), 10, 2);
    }

    if (!empty($option['hide_compress']) && $option['hide_compress'] == 'true'){
      #add_action('admin_print_scripts', array(__CLASS__, 'wps_ic_hide_compress'), 99);
      add_action('pre_current_active_plugins', array(__CLASS__, 'wps_ic_hide_compress_plugin_list'));
    }

  }


  public static function media_library_popup() {
    echo '<div id="legacy-no-credits" style="display: none;">
      <div id="cdn-popup-inner">

        <div class="cdn-popup-top">
          <img class="popup-icon" src="' . WPS_IC_URI . 'assets/images/legacy/no-credits.svg"/>
        </div>

        <div class="cdn-popup-content">
          <h3>You Don’t Have Enough Credits</h3>
          <p class="ic-content-replace">Purchase or allocate more credits to optimize your image.</p>

        </div>

        <div class="cdn-popup-footer">
          <div class="cta-button-more-credits-container">
            <a href="https://wpcompress.com/pricing/" target="_blank" class="cta-button-more-credits">Get More Credits</a>
          </div>
          <a href="https://app.wpcompress.com" target="_blank" class="cta-button-grey">Go to Portal</a>
        </div>

      </div>
    </div>';
  }


  public static function wps_ic_hide_compress_plugin_list() {
    global $wp_list_table;
    $hidearr   = array('wp-compress-image-optimizer/wp-compress.php');
    $myplugins = $wp_list_table->items;
    foreach ($myplugins as $key => $val) {
      if (in_array($key, $hidearr)) {
        unset($wp_list_table->items[ $key ]);
      }
    }
  }


  public static function wps_ic_hide_compress() {
    echo '<script type="text/javascript">';
    echo 'jQuery(document).ready(function($){';
    echo '$("tr[data-slug=\'wp-compress-image-optimizer\']").hide();';
    echo '$("#wp-compress-image-optimizer-update").hide();';
    echo '});';
    echo '</script>';
  }


  public static function wps_ic_pro_exclude_button($id, $action = '') {

    $output = '';

    if ($action == 'restore') {
      $output .= '<li><a href="#" class="wps-ic-action-disabled" data-attachment_id="' . $id . '">Exclude Disabled</a></li>';
    } else {
      $output .= '<li><a href="#" class="wps-ic-pro-exclude" data-attachment_id="' . $id . '">Exclude</a></li>';
      #$output .= '<li><a href="' . admin_url('admin.php?page=wpcompress&view=debug_tool&attachmentID=' . $id) . '" class="wps-ic-debug" data-attachment_id="' . $id . '">Debug</a></li>';
    }

    return $output;
  }


  public static function wps_ic_pro_include_button($id, $action = '') {
    $output = '';

    $output .= '<button type="button" class="btn btn-success wps-ic-pro-include" data-attachment_id="' . $id . '">Include</button>';

    return $output;
  }


  public static function wps_compress_column($cols) {
    $old                    = $cols;
    $cols                   = array();
    $cols['cb']             = $old['cb'];
    $cols['title']          = $old['title'];
    $cols["wps_ic_all"]     = "";
    $cols["wps_ic_actions"] = "";
    $cols['author']         = $old['author'];
    $cols['parent']         = $old['parent'];
    $cols['comments']       = $old['comments'];
    $cols['date']           = $old['date'];

    return $cols;
  }


  public static function wps_compress_column_value($column_name, $id) {
    global $wps_ic;

    $logo_compressed   = WPS_IC_URI . 'assets/images/compressed.png';
    $logo_uncompressed = WPS_IC_URI . 'assets/images/not-compressed.png';
    $logo_excluded     = WPS_IC_URI . 'assets/images/excluded.png';

    $file_data = get_attached_file($id);
    $type      = wp_check_filetype($file_data);

    $allowed_types         = array();
    $allowed_types['jpg']  = 'jpg';
    $allowed_types['jpeg'] = 'jpeg';
    $allowed_types['gif']  = 'gif';
    $allowed_types['png']  = 'png';

    $output = '';

    // Is file extension allowed
    if ( ! in_array(strtolower($type['ext']), $allowed_types)) {

      /**
       * Extensions is NOT allowed
       */

      if ($column_name == 'wps_ic_all') {
        $output .= '<div class="wps-ic-excluded">';
        $output .= '<img src="' . $logo_excluded . '" />';
        $output .= '<h5>Excluded</h5>';
        $output .= '</div>';
      } else if ($column_name == 'wps_ic_actions') {
        $output .= '<div class="wps-ic-media-actions-toolbox">';
        $output .= '<ul class="wps-ic-include">';
        $output .= '<li class="no-padding">';

        $output .= '<div class="btn-group">';
        $output .= 'Not supported';
        $output .= '</div>';

        $output .= '</li>';
        $output .= '</ul>';
        $output .= '</div>';
      }

      echo $output;
    } else {

      /**
       * First Column
       * - Image Icon & Savings
       */
      if ($column_name == 'wps_ic_all') {

        $output             = '';

        $status             = get_post_meta($id, 'wps_ic_status', true);
        if (!empty($status) && $status['time']+60<=time()) {
          // Unlock, it's old
          $type = $status['type'];
          if ($type == 'restore') {
            // Set it as compressed
          } else {
            // Set it as restore
          }

          clearstatcache();
          $attachmentID = $id;
          $file_data = get_attached_file($attachmentID);
          update_post_meta($attachmentID, 'wps_ic_noncompressed_size', filesize($file_data));
          delete_post_meta($attachmentID, 'wps_ic_compressed_size');
          delete_post_meta($attachmentID, 'wps_ic_locked');
          delete_post_meta($attachmentID, 'wps_ic_data');
          delete_post_meta($attachmentID, 'wps_ic_dimmensions');
          delete_post_meta($attachmentID, 'wps_ic_restoring');
          delete_post_meta($attachmentID, 'wps_ic_in_bulk');
          delete_post_meta($attachmentID, 'wps_ic_state');
          delete_post_meta($attachmentID, 'wps_ic_status');
        }

        $locked             = get_post_meta($id, 'wps_ic_locked', true);
        $compress           = get_post_meta($id, 'wps_ic_data', true);
        $in_process         = get_post_meta($id, 'wps_ic_in_bulk', true);
        $dimmensions        = get_post_meta($id, 'wps_ic_dimmensions', true);
        $excluded           = get_post_meta($id, 'wps_ic_exclude', true);
        $compressed_value   = get_post_meta($id, 'wps_ic_compressed_size', true);
        $uncompressed_value = get_post_meta($id, 'wps_ic_noncompressed_size', true);


        $image_status = get_post_meta($id, 'wps_ic_status', true);
        if ($image_status['time'] <= time() - 60) {
          // Image hanging, finish it
          $type = $image_status['type'];
          if ($type == 'compress') {
            // Compress it
          } else {
            // Restore it
          }
        }

        if ( ! empty($compress) && $compress != 'not_able' && $compress != 'excluded') {
          /**
           * Image is Compressed
           */
          if (empty($dimmensions) || ! is_array($dimmensions)) {
            // Dimensions
            $dimensions                        = getimagesize($file_data);
            $image_dimensions                  = array();
            $image_dimensions['new']['width']  = $dimensions[0];
            $image_dimensions['new']['height'] = $dimensions[0];
            update_post_meta($id, 'wps_ic_dimmensions', $image_dimensions);
          }

        } else {
          /**
           * Image is NOT Compressed
           */
        }

        if ($compress == 'working' && empty($image_status)) {
          update_post_meta($id, 'wps_ic_status', array('time' => time()-60));
        }

        // Image is processing
        if ($locked == 'true' || $in_process == 'true' || ( ! empty($compress) && (empty($compress['new']) && $compress != 'not_able' && $compress != 'excluded' && $compress != 'no_credits'))) {
          $output = '';
          $output .= '<div class="wps-ic-uncompressed">';
          $output .= '<img src="' . $logo_uncompressed . '" />';
          $output .= '<h5>Working...</h5>';
          $output .= '</div>';

          echo '<div class="wp-ic-image-info" id="wp-ic-image-' . $id . '">';
          echo $output;
          echo '</div>';

          return;
        }

        /**
         * Is the image excluded manually?
         */
        if ( ! empty($excluded) || $compress == 'excluded') {
          // Image is Excluded!
          $output .= '<div class="wps-ic-excluded">';
          $output .= '<img src="' . $logo_excluded . '" />';
          $output .= '<h5>Excluded</h5>';
          $output .= '</div>';
        } else if (empty($compress)) {
          /**
           * Image is NOT Compressed
           */
          $output .= '<div class="wps-ic-uncompressed">';
          $output .= '<img src="' . $logo_uncompressed . '" />';
          $output .= '<h5>Not Compressed</h5>';
          $output .= '</div>';
        } else if ($compress == 'not_able') {
          /**
           * We were unable to compress your image
           */
          $output .= '<div class="wps-ic-uncompressed">';
          $output .= '<img src="' . $logo_compressed . '" />';
          $output .= '<h5 class="no-further-savings nfs1">No Further Savings</h5>';
          $output .= '</div>';
        } else if ($compress == 'no_credits') {
          $output .= '<div class="wps-ic-uncompressed">';
          $output .= '<img src="' . $logo_uncompressed . '" />';
          $output .= '<h5>Not Compressed</h5>';
          $output .= '</div>';
        } else {
          /**
           * Image is Compressed
           */

          // Saved total
          $saved_total = $uncompressed_value - $compressed_value;
          $saved_total = size_format($saved_total, 2);

          // Saved
          $saved = ($compressed_value / $uncompressed_value) * 100;
          $saved = round(100 - $saved, 0) . '';

          if ($compressed_value >= $uncompressed_value) {
            /**
             * Compressed Image is larger than Original
             */
            $output .= '<div class="wps-ic-uncompressed">';
            $output .= '<img src="' . $logo_compressed . '" />';
            $output .= '<h5 class="no-further-savings nfs2">No Further Savings</h5>';
            $output .= '</div>';
          } else {
            $output .= '<div class="wps-ic-compressed">';
            $output .= '<img src="' . $logo_compressed . '" />';
            $output .= '<h5>' . $saved . '%</h5>';
            $output .= '<h5>' . $saved_total . '</h5>';
            $output .= '<h5>Saved</h5>';
            $output .= '</div>';
          }

        }

        // Load times
        echo '<div class="wp-ic-image-info" id="wp-ic-image-' . $id . '">';
        echo $output;
        echo '</div>';

      } else if ($column_name == 'wps_ic_actions') {

        /**
         * Actions Column
         * - button, compress information
         */

        $output             = '';
        $locked             = get_post_meta($id, 'wps_ic_locked', true);
        $compress           = get_post_meta($id, 'wps_ic_data', true);
        $in_process         = get_post_meta($id, 'wps_ic_in_bulk', true);
        $dimensions         = get_post_meta($id, 'wps_ic_dimmensions', true);
        $excluded           = get_post_meta($id, 'wps_ic_exclude', true);
        $compressed_value   = get_post_meta($id, 'wps_ic_compressed_size', true);
        $uncompressed_value = get_post_meta($id, 'wps_ic_noncompressed_size', true);

        if (empty($uncompressed_value) || $uncompressed_value == 0) {
          $filesize           = filesize($file_data);
          $uncompressed_value = $filesize;
          update_post_meta($id, 'wps_ic_noncompressed_size', $filesize);
        }

        /**
         * API Key Missing - Plugin not connected
         */
        if (empty(self::$response_key) || ! self::$response_key) {
          echo '<strong>Please connect to the WP Compress API</strong>';

          return;
        }

        /**
         * We are still processing the image!
         */
        if ($locked == 'true' || $in_process == 'true' || (empty($compress['new']) && ! empty($compress) && $compress != 'not_able' && $compress != 'excluded' && $compress != 'no_credits')) {
          echo '<div class="wp-ic-image-actions" id="wp-ic-image-actions-' . $id . '"></div>';
          echo '<div class="wps-ic-image-loading" id="wp-ic-image-loading-' . $id . '"><img src="' . WPS_IC_URI . 'assets/images/spinner.svg" /></div>';

          return;
        }

        if ( ! empty($excluded)) {
          /**
           * Image is excluded
           */
          $output .= '<div class="wps-ic-media-actions-toolbox">';
          $output .= '<ul class="wps-ic-include">';
          $output .= '<li class="no-padding">';

          $output .= '<div class="btn-group">';
          $output .= apply_filters('wps_ic_pro_include', $id);
          $output .= '</div>';

          $output .= '</li>';
          $output .= '</ul>';
          $output .= '</div>';
        } else {

          // Compressed
          $compressed_value   = size_format($compressed_value, 2);
          $uncompressed_value = size_format($uncompressed_value, 2);

          if (empty($dimensions['new']['width']) || $dimensions['new']['width'] == 'NULL') {
            // Dimensions
            $file                = get_attached_file($id);
            $dimensions_metadata = getimagesize($file);

            $dimensions = get_post_meta($id, 'wps_ic_dimmensions', true);
            if ( ! $dimensions || ! is_array($dimensions)) {
              $dimensions = array();
            }

            $dimensions['new']['width']  = $dimensions_metadata[0];
            $dimensions['new']['height'] = $dimensions_metadata[1];
            update_post_meta($id, 'wps_ic_dimmensions', $dimensions_metadata);
          }

          $attachment_dimensions_new = $dimensions['new']['width'] . 'x' . $dimensions['new']['height'];

          if (empty($compress)) {
            /**
             * Image is NOT Compressed
             */
            if (empty($dimensions['old']['width']) || $dimensions['old']['width'] == null) {
              $file                      = get_attached_file($id);
              $dimensions_metadata       = getimagesize($file);
              $attachment_dimensions_new = $dimensions_metadata[0] . 'x' . $dimensions_metadata[1];
            } else {
              $attachment_dimensions_new = $dimensions['old']['width'] . 'x' . $dimensions['old']['height'];
            }

            $output .= '<div class="wps-ic-media-actions">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '<li class="wps-ic-weight"><span>' . $uncompressed_value . '</span></li>';
            $output .= '<li class="wps-ic-size"><span>' . $attachment_dimensions_new . '</span></li>';
            $output .= '<li class="wps-ic-li-no-padding">';
            $output .= '<div class="wps-ic-media-actions-toolbox">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '<li class="wps-ic-action">';

            $output .= '<div class="btn-group">';
            $output .= '<button type="button" class="btn btn-success wps-ic-compress-single" data-image_id="' . $id . '" data-image-weight="' . $uncompressed_value . '">Compress</button>';

            $output .= '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $output .= '<span class="caret"></span>';
            $output .= '<span class="sr-only">Toggle Dropdown</span>';
            $output .= '</button>';
            $output .= '<ul class="dropdown-menu">';
            $output .= apply_filters('wps_ic_pro_exclude', $id);
            $output .= '</ul>';
            $output .= '</div>';

            $output .= '</li>';
            $output .= '</ul>';
            $output .= '</div>';
            $output .= '<div style="height:15px;width:100%;"></div>';

            $output .= '</li>';
            $output .= '</ul>';

            $output .= '</div>';
          } else if ($compress == 'not_able') {
            /**
             * We were not able to compress
             */
            if (empty($dimensions['old']['width']) || $dimensions['old']['width'] == null) {
              $file                      = get_attached_file($id);
              $dimensions_metadata       = getimagesize($file);
              $attachment_dimensions_new = $dimensions_metadata[0] . 'x' . $dimensions_metadata[1];
            } else {
              $attachment_dimensions_new = $dimensions['old']['width'] . 'x' . $dimensions['old']['height'];
            }

            $output .= '<div class="wps-ic-media-actions">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '<li class="wps-ic-weight"><span>' . $uncompressed_value . '</span></li>';
            $output .= '<li class="wps-ic-size"><span>' . $attachment_dimensions_new . '</span></li>';
            $output .= '<li class="wps-ic-li-no-padding">';

            $output .= '<div class="wps-ic-media-actions-toolbox">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '<li class="wps-ic-action">';

            $output .= '<button type="button" class="btn btn-info wps-ic-restore-single" data-type="reset" data-image_id="' . $id . '">Reset</button>';

            $output .= '</li>';
            $output .= '</ul>';
            $output .= '</div>';
            $output .= '<div style="height:15px;width:100%;"></div>';
            $output .= '</li>';
            $output .= '</ul>';

            $output .= '</div>';

            $output .= '</li>';
            $output .= '</ul>';
            $output .= '</div>';
          } else if ($compress == 'no_credits') {
            // No credits
            $file_data          = get_attached_file($id);
            $uncompressed_value = filesize($file_data);
            $uncompressed_value = size_format($uncompressed_value, 2);
            $image_dimensions   = get_post_meta($id, 'wps_ic_dimmensions', true);
            if ( ! $image_dimensions || ! is_array($image_dimensions)) {
              $image_dimensions['old']['width']  = $dimensions[1];
              $image_dimensions['old']['height'] = $dimensions[1];
              $attachment_dimensions_new         = $image_dimensions['old']['width'] . 'x' . $image_dimensions['old']['height'];
            } else {
              $file                      = get_attached_file($id);
              $dimensions_metadata       = getimagesize($file);
              $attachment_dimensions_new = $dimensions_metadata[0] . 'x' . $dimensions_metadata[1];
            }

            $output .= '<div class="wps-ic-media-actions">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '<li class="wps-ic-weight"><span>' . $uncompressed_value . '</span></li>';
            $output .= '<li class="wps-ic-size"><span>' . $attachment_dimensions_new . '</span></li>';
            $output .= '<li class="wps-ic-li-no-padding">';

            $output .= '<div class="wps-ic-media-actions-toolbox">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '<li class="wps-ic-action">';

            $output .= '<div class="btn-group">';
            $output .= '<button type="button" class="btn btn-success wps-ic-compress-single" data-image_id="' . $id . '" data-image-weight="' . $uncompressed_value . '">Compress</button>';

            $output .= '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $output .= '<span class="caret"></span>';
            $output .= '<span class="sr-only">Toggle Dropdown</span>';
            $output .= '</button>';
            $output .= '<ul class="dropdown-menu">';
            $output .= apply_filters('wps_ic_pro_exclude', $id);
            $output .= '</ul>';
            $output .= '</div>';

            $output .= '</li>';
            $output .= '</ul>';
            $output .= '</div>';
            $output .= '<div style="height:15px;width:100%;"></div>';
            $output .= '</li>';
            $output .= '</ul>';

            $output .= '</div>';

            $output .= '</li>';
            $output .= '</ul>';
            $output .= '</div>';
          } else {
            /**
             * Image is Compressed
             */

            if (empty($dimensions['new']['width']) || $dimensions['new']['width'] == 'NULL') {
              // Dimensions
              $dimensions                        = getimagesize($file_data);
              $image_dimensions                  = get_post_meta($id, 'wps_ic_dimmensions', true);
              $image_dimensions['new']['width']  = $dimensions[0];
              $image_dimensions['new']['height'] = $dimensions[1];
              update_post_meta($id, 'wps_ic_dimmensions', $image_dimensions);
              $attachment_dimensions_new = $image_dimensions['new']['width'] . 'x' . $image_dimensions['new']['height'];
            }

            $metadata = wp_get_attachment_metadata($id);
            if (empty($metadata['width']) || $metadata['width'] == null || $metadata['width'] == 'NULL') {
              $dimensions         = getimagesize($file_data);
              $metadata['width']  = $dimensions[0];
              $metadata['height'] = $dimensions[1];
              update_post_meta($id, '_wp_attachment_metadata', $metadata);
            }

            $output .= '<div class="wps-ic-media-actions">';
            $output .= '<div class="wps-ic-half-media-actions">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';

            $output .= '<li class="wps-ic-weight"><span class="strike">' . $uncompressed_value . '</span></li>';
            $output .= '<li class="wps-ic-size"><span>' . $attachment_dimensions_new . '</span></li>';

            $output .= '</ul>';
            $output .= '</div>';
            $output .= '<div class="wps-ic-half-media-actions">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '</li>';

            $output .= '<li class="wps-ic-size-compressed"><span>' . $compressed_value . '</span></li>';

            $output .= '</ul>';
            $output .= '</div>';

            $output .= '<div class="wps-ic-media-actions-toolbox">';
            $output .= '<ul class="wps-ic-noncompressed-icon">';
            $output .= '<li class="wps-ic-action">';

            $output .= '<button type="button" class="btn btn-info wps-ic-restore-single" data-image_id="' . $id . '">Restore</button>';
            #$output .= '<button type="button" class="btn btn-compare wps-ic-recompress-single tooltip" data-image_id="' . $id . '" style="margin-left:5px;" title="Try optimizing with different settings."><i class="icon demo-icon
            # icon-rocket"></i></button>';
            #$output .= '<button type="button" class="btn btn-compare wps-ic-compare-single tooltip" data-image_id="' . $id . '" style="margin-left:5px;" title="Compare original and compressed image."><i class="icon demo-icon
            # icon-eye-1"></i></button>';

            $output .= '</li>';
            $output .= '</ul>';
            $output .= '</div>';

            $output .= '</div>';

          }
        }

        // Load times
        echo '<div class="wps-ic-image-loading" id="wp-ic-image-loading-' . $id . '" style="display:none;"><img src="' . WPS_IC_URI . 'assets/images/spinner.svg" /></div>';
        echo '<div class="wp-ic-image-actions" id="wp-ic-image-actions-' . $id . '">';

        echo $output;

        echo '</div>';
      }
    }
  }


}