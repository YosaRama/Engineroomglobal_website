<?php
/**
 * The CF7 Custom Spinner settings class
 */

 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The settings plugin class
 */
if ( !class_exists( 'PP_CF7_Custom_Spinner_Settings' ) ) { 

  class PP_CF7_Custom_Spinner_Settings {
    
    /**
     * reference to core class
     *
     * @since  1
     * @access private
     */
    private $_core;
    
    
    /**
     * Array of settings
     *
     * @since  1
     * @access private
     */
    private $settings;
    
    
    /**
	   * Initialize the settings class
     *
     * @since 1
     */
    public function __construct( $_core ) {
      
      $this->_core = $_core;
      $this->settings = false;
      
    }
    
    
    /**
	   * get current setting
     *
     * @since 1
     * @return array settings
     * @access private
     */
    private function get_current_settings() {
      
      $this->settings = get_option( $this->_core->get_option_name_settings(), array() );
      $this->settings = wp_parse_args( $this->settings, array( 'type' => false, 'color' => false, 'size' => false ) );
    }
    
    
    /**
	   * get a setting
     *
     * @since 1
     * @param  string $key the settings key
     * @return string      the current setting for the key
     * @access public
     */
    public function get_setting( $key ) {
      
      if ( ! $this->settings ) {
        
        $this->get_current_settings();
        
      }
      
      return $this->settings[$key];
    }
      
  }
  
}