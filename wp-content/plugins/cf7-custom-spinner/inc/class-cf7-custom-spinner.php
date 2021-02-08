<?php

/**
 * The CF7 Custom Spinner core plugin class
 */

 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The core plugin class
 */
if ( !class_exists( 'PP_CF7_Custom_Spinner' ) ) { 

  class PP_CF7_Custom_Spinner {
    
    
    /**
     * Instance
     *
     * @since  1
     * @var    singleton
     * @access protected
     */
    protected static $_instance = null;
 
 
    /**
     * Plugin Main File Path and Name
     *
     * @since  1
     * @var    string
     * @access private
     */
    private $plugin_file;
    
    
    /**
     * Plugin Name
     *
     * @since  1
     * @var    string
     * @access private
     */
    private $plugin_name;
    
    
    /**
     * Plugin Slug
     *
     * @since  1
     * @var    string
     * @access private
     */
    private $plugin_slug;
    
    
    /**
     * Plugin Version
     *
     * @since  1
     * @var    int
     * @access private
     */
    private $plugin_version;
    
    
    /**
     * Settings Class
     *
     * @see    class-cf7-custom-spinner-settings.php
     * @since  1
     * @var    object
     * @access private
     */
    private $settings;
    
    
    /**
     * Admin Class
     *
     * @see    class-cf7-custom-spinner-admin.php
     * @since  1
     * @var    object
     * @access private
     */
    private $admin;
    
    
    /**
     * Frontend Class
     *
     * @see    class-cf7-custom-spinner-frontend.php
     * @since  1
     * @var    object
     * @access private
     */
    private $frontend;
    
    
    /**
     * Uninstall Class
     *
     * @see    class-cf7-custom-spinner-uninstall.php
     * @since  1
     * @var    object
     * @access private
     */
    private $uninstall;
    
    
    /**
     * Init the Class 
     *
     * @since 1
     * @see getInstance
     */
    protected function __construct( $settings ) {
      
      // if we are in front end and the CF7 plugin is not active we do absolutely nothing
      
      if ( true ) {
      
        $this->plugin_file    = $settings['file'];
        $this->plugin_slug    = $settings['slug'];
        $this->plugin_name    = $settings['name'];
        $this->plugin_version = $settings['version'];
      
        $this->settings       = new PP_CF7_Custom_Spinner_Settings( $this );
        $this->frontend       = new PP_CF7_Custom_Spinner_Frontend( $this );
        
        if ( is_admin() ) {
  
          // add classes for admin only if we are in admin
          // @since 2
          $this->admin          = new PP_CF7_Custom_Spinner_Admin( $this );
          $this->uninstall      = new PP_CF7_Custom_Spinner_Uninstall( $this );
          
        }
        
      }
      
    }

    
    /**
     * Prevent Cloning
     *
     * @since 1
     */
    protected function __clone() {}
    
    
    /**
	   * Get the Instance
     *
     * @since 1
     * @param array $settings {
     *   @type string $file    Plugin Main File Path and Name
     *   @type string $slug    Plugin Slug
     *   @type string $name    Plugin Name
     *   @type int    $version Plugin Verion
     * }
     * @return singleton
     */
    public static function getInstance( $settings ) {
     
      if ( null === self::$_instance ) {

        self::$_instance = new self( $settings );
        
      }
      
      return self::$_instance;
      
    }
   

    /**
	   * get plugin file
     *
     * @since 1
     * @access public
     */
    public function get_plugin_file() {
      
      return $this->plugin_file;
      
    }
    
    
    /**
	   * get plugin slug
     *
     * @since 1
     * @access public
     */
    public function get_plugin_slug() {
      
      return $this->plugin_slug;
      
    }
    
    
    /**
	   * get plugin name
     *
     * @since 1
     * @access public
     */
    public function get_plugin_name() {
      
      return $this->plugin_name;
      
    }
    
    
    /**
	   * get plugin version
     *
     * @since 1
     * @access public
     */
    public function get_plugin_version() {
      
      return $this->plugin_version;
      
    }
    

    /**
		 * check if contact form 7 plugin is active
		 *
     * @since  1
     * @access public
     */
		public function is_cf7_active() {
      
      return defined( 'WPCF7_PLUGIN' );
    
    }
    
    
    /**
     * get path for asset file
     *
     * @since  1
     * @access public
     */
    public function get_asset_file( $dir, $file ) {
     
      return plugins_url( 'assets/' . $dir . '/' . $file, $this->plugin_file );
     
    }
    
    
    /**
	   * get current setting for spinner type
     *
     * @since 1
     * @access public
     * @return string spinner id
     *         false if not set
     */
    public function get_current_spinner() {
      
      return $this->settings->get_setting( 'type' );
      
    }
    
    
    /**
	   * get current setting for spinner color
     *
     * @since 1
     * @access public
     * @return string color
     *         false if not set
     */
    public function get_current_color() {
      
      return $this->settings->get_setting( 'color' );
      
    }
    
    
    /**
	   * get current setting for spinner size
     *
     * @since 1
     * @access public
     * @return int size
     *         false if not set
     */
    public function get_current_size() {
      
      return $this->settings->get_setting( 'size' );
      
    }
    
    
    /**
	   * get option name for the current settings
     *
     * @since 1
     * @access public
     * @return string option name
     */
    public function get_option_name_settings() {
      
      return str_replace( '-', '_', $this->plugin_slug ) . '_settings';
      
    }
  
  
    /**
	   * get option name for the frontend css code
     *
     * @since 1
     * @access public
     * @return string option name
     */
    public function get_option_name_frontend_css() {
      
      return str_replace( '-', '_', $this->plugin_slug ) . '_frontend_css';
      
    }
    
    
    /**
	   * get option name for next admin notice number to be displayed
     *
     * @since 1
     * @access public
     * @return string option name
     */
    public function get_option_name_admin_notice_next() {
      
      return str_replace( '-', '_', $this->plugin_slug ) . '_admin_notice_next';
      
    }
    
    
    /**
	   * get option name for next admin notice start time
     *
     * @since  1
     * @access public
     * @return string option name
     */
    public function get_option_name_admin_notice_start() {
      
      return str_replace( '-', '_', $this->plugin_slug ) . '_admin_notice_start';
      
    }
    
    
    /**
	   * uninstall plugin
     *
     * @since  1
     * @access public
     */
    public function do_uninstall() {
      
      $this->uninstall->uninstall();
      
    }
    
  }
  
}
 
?>