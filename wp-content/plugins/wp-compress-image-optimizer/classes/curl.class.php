<?php


/**
 * Class - Curl
 */
class wps_ic_curl {

  public $apiurl;
  public $apikey;
  public $siteurl;


  public function __construct() {

    $call_opts = get_option(WPS_IC_OPTIONS);

    $this->apiurl  = WPS_IC_APIURL;
    $this->apikey  = $call_opts['api_key'];
    $this->siteurl = site_url();

  }


  public function get_stats() {
    $api_stats_query = wp_remote_get($this->apiurl,
                                     array(
                                       'body'      =>
                                         array(
                                           'apikey' => $this->apikey,
                                           'action' => 'get_stats',
                                           'site'   => site_url()
                                         ),
                                       'sslverify' => false
                                     ));

    $api_stats_query = wp_remote_retrieve_body($api_stats_query);
    $api_stats_query = json_decode($api_stats_query);

    return $api_stats_query;
  }


  public function get_stats_live($type = '') {

    if ($type == '') {
      $query = array(
        'apikey' => $this->apikey,
        'action' => 'get_stats_live',
        'site'   => site_url()
      );
    } else if ($type == 'demo') {
      $query = array(
        'apikey' => 'demo',
        'action' => 'get_stats_live',
        'site'   => site_url()
      );
    }

    $api_stats_query = wp_remote_get($this->apiurl,
                                     array(
                                       'body'      =>
                                         $query,
                                       'sslverify' => false
                                     ));

    $api_stats_query = wp_remote_retrieve_body($api_stats_query);
    $api_stats_query = json_decode($api_stats_query);

    return $api_stats_query;
  }


  public function call_api($body = array()) {

    $apiurl = $this->apiurl;
    if ( ! empty($body['apiurl'])) {
      $apiurl = $body['apiurl'];
    }

    #$apiurl = 'http://206.189.251.204';

    $body['apikey'] = $this->apikey;
    $body['domain'] = site_url();
    $body['site']   = site_url();

    $api_call = wp_remote_get($apiurl,
                              array(
                                'body'      => $body,
                                'sslverify' => false,
                                'timeout'   => 30,
                              ));

    if (wp_remote_retrieve_response_code($api_call) == 200) {
      $api_body = wp_remote_retrieve_body($api_call);
      $api_body = json_decode($api_body);

      return $api_body;
    } else {
      return false;
    }

  }


}