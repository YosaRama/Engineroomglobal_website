<?php


/**
 * Class - Multisite
 */
class wps_ic_mu extends wps_ic {

  public $templates;
  public static $slug;


  public function __construct() {

    add_action('wpmu_new_blog', array($this, 'new_mu_site'), 10, 6);

  }


  function new_mu_site( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    // Setup Database
    #$database = new wps_ic_database();
    #$database->create_tables_per_site($blog_id);
  }


}