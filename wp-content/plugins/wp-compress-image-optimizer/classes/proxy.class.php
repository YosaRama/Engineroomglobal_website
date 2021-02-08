<?php


/**
 * Class - Proxy
 */
class wps_ic_proxy {

  public $apiurl;
  public $apikey;
  public $siteurl;


  public function __construct() {

    $call_opts = get_option(WPS_IC_OPTIONS);

    $this->apiurl  = WPS_IC_APIURL;
    $this->apikey  = $call_opts['api_key'];
    $this->siteurl = site_url();

    if ( ! is_admin()) {
      add_action('send_headers', array($this, 'proxy_original_image'));
    }

  }


  public function proxy_original_image() {
    if (!empty($_GET['ic_proxy'])) {

      $url      = str_replace('.php', '', $_SERVER['SCRIPT_URI']);
      $id       = $this->attachment_url_to_id($url);
      $filedata = get_attached_file($id);

      $exif = exif_imagetype($filedata);
      $mime = image_type_to_mime_type($exif);

      http_response_code(302);
      header('Cache-Control: no-cache');
      header('Content-Type:' . $mime);
      header('Content-Length: ' . filesize($filedata));
      readfile($filedata);
      die();
    }
  }


  public function attachment_url_to_id($attachment_url) {
    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ($attachment_url == '') {
      return;
    }

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {

      // If this is the URL of an auto-generated thumbnail, get the URL of the original image
      $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);

      // Remove the upload path base directory from the attachment URL
      $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

      // Finally, run a custom database query to get the attachment ID from the modified attachment URL
      $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'",
                                                     $attachment_url));
    }

    return $attachment_id;
  }


}