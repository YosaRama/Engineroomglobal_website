<?php


/**
 * Class - Upgrade
 */
class wps_ic_upgrade extends wps_ic {


  public function __construct() {
    #$this->upgrade_table();
  }


  /**
   * Update cron schedule
   * @since 1.1.66
   */
  public function upgrade_table() {
    global $wpdb;

    $latest        = '4.1.0';
    $update_option = get_option('wps_ic_updated');

    if ( ! empty($_GET['force_db']) || empty($update_option) || $update_option != $latest) {
      update_option('wps_ic_updated', $latest);
    }

  }

}