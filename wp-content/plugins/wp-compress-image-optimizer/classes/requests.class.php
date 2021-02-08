<?php


/**
 * Class - Requests
 */
class wps_ic_requests {

  public static $api_key;
  public static $options;


  public function __construct() {

    if (is_admin()) {

      $options = new wps_ic_options();
      $log     = new wps_ic_log();

      $options       = $options->get_option();
      self::$api_key = $options['api_key'];
    }

    if ( ! empty($_GET['secret_key'])) {

      $options = new wps_ic_options();
      $log     = new wps_ic_log();

      $options       = $options->get_option();
      self::$api_key = $options['api_key'];

      // A little Cleanup
      $data = array();
      foreach ($_GET as $key => $value) {
        $data[ $key ] = $value;
      }

      if ($data['secret_key'] == self::$api_key) {

        if ( ! empty($data['thumbs'])) {

          if ( ! function_exists('download_url')) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
          }

          $attachment_ID = $data['attachment_ID'];

          $request = stripslashes($data['thumbs']);
          $request = json_decode($request);

          // Fetch existing thumbnails
          $sizes = get_intermediate_image_sizes();

          if (is_array($sizes)) {
            foreach ($sizes as $key => $size) {
              $thumbs[ $size ] = wp_get_attachment_image_src($attachment_ID, $size);
              $thumbs[ $size ] = $thumbs[ $size ][0];
              $thumbs[ $size ] = str_replace(site_url('/'), '', $thumbs[ $size ]);
            }
          }

          // Parse request
          $parse = array();
          foreach ($request as $attachment_ID => $compressed_thumbs) {

            foreach ($compressed_thumbs as $k => $thumb) {
              foreach ($thumb as $key => $value) {
                $thumb_url            = $value;
                $thumb_name           = basename($thumb_url);
                $parse[ $thumb_name ] = $thumb_url;

              }
            }

          }

          if ($thumbs && $parse) {

            foreach ($thumbs as $size => $original_thumb_path) {
              if (file_exists(ABSPATH . $original_thumb_path)) {
                // Add generate thumbnail to queue
                $uploadfile  = get_attached_file($attachment_ID);
                $attach_data = wp_generate_attachment_metadata($attachment_ID, $uploadfile);
                wp_update_attachment_metadata($attachment_ID, $attach_data);
              }

            }
          }

          die();
        }

        if ( ! empty($data['uri'])) {

          // Download image
          self::fetch_compressed($data['uri'], $data['attachment_ID']);
        }

      } else {
        // Hacked?
      }
    }

  }


  /**
   * Fetch compressed image from given url and put it to attachment ID
   *
   * @param $uri
   * @param $attachment_ID
   */
  public static function fetch_compressed($uri, $attachment_ID) {
    global $wps_ic;

    // Get upload directory path
    $uploaddir = wp_upload_dir();

    if ( ! function_exists('download_url')) {
      require_once(ABSPATH . "wp-admin" . '/includes/image.php');
      require_once(ABSPATH . "wp-admin" . '/includes/file.php');
      require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    }

    if ( ! function_exists('update_option')) {
      require_once(ABSPATH . "wp-includes" . '/option.php');
    }

    // Find file with attachment_ID
    $file = wp_get_attachment_image_src($attachment_ID, 'full');

    if (empty($file) || ! $file) {
      wp_send_json_error('File not found.');
    }

    // Is allowed type or excluded?
    if (self::is_allowed_type($attachment_ID) || self::is_excluded($attachment_ID)) {
      wp_send_json_error('File not allowed type or excluded.');
    }

    // Get remote image and download it
    $remote_image = wp_remote_get($uri, array('timeout' => 120, 'sslverify' => false));

    if (wp_remote_retrieve_response_code($remote_image) == 200) {
      $body = wp_remote_retrieve_body($remote_image);

      $uploadfile = $uploaddir['path'] . '/' . basename($file[0]);

      // Download remote file to temp
      $temp_file = download_url($uri, 30);

      if ($temp_file) {
        clearstatcache();

        // Fetch old image details
        $compress_data                = array();
        $file_data                    = get_attached_file($attachment_ID);
        $compress_data['old']['size'] = filesize($file_data);
        $compress_data['old']['data'] = wp_get_attachment_metadata($attachment_ID);

        // First delete the current file
        if (is_writable($uploadfile)) {
          // Everything OK; delete the file
          unlink($uploadfile);
        }

        if (file_exists($uploadfile)) {
          unlink($uploadfile);
        }

        // Move new file to old location/name
        copy($temp_file, $uploadfile);

        // Chmod new file to original file permissions
        @chmod($uploadfile, 0644);

        // Make thumb and/or update metadata
        wp_update_attachment_metadata((int)$attachment_ID, wp_generate_attachment_metadata((int)$attachment_ID, $uploadfile));

        // Trigger possible updates on CDN and other plugins
        update_attached_file((int)$attachment_ID, $uploadfile);

        // Run cron for thumbnails
        #wp_schedule_single_event(time(), 'wps_ic_fetch_thumbnails');

        // Fetch new image details
        $file_data                    = get_attached_file($attachment_ID);
        $compress_data['new']['size'] = filesize($file_data);
        $compress_data['new']['data'] = wp_get_attachment_metadata($attachment_ID);

        // Update Stats
        $data = get_post_meta($attachment_ID, 'wps_ic_data', true);

        // Update compress data
        update_post_meta($attachment_ID, 'wps_ic_compressed', 'true');
        update_post_meta($attachment_ID, 'wps_ic_data', $compress_data);
        update_post_meta($attachment_ID, 'wps_ic_cdn', 'true');

        // Remove unnecessary data
        delete_post_meta($attachment_ID, 'wps_ic_in_bulk');
        delete_post_meta($attachment_ID, 'wps_ic_compressing');
        // End Timer

        $timer = microtime(true);
        $start = get_transient('wps_ic_' . $attachment_ID);
        $end   = round($timer - $start, 1);
        update_post_meta($attachment_ID, 'wps_ic_time', $end . ' s');

        $compressed_items              = get_option('wps_ic_compressed');
        $compressed_items['waiting'][] = $attachment_ID;
        update_option('wps_ic_compressed', $compressed_items);

        clearstatcache();
      }

    }

    // Update time
    $times                      = get_post_meta($attachment_ID, 'wps_ic_times', true);
    $times['api_request_ended'] = microtime(true);
    update_post_meta($attachment_ID, 'wps_ic_times', $times);

  }










}