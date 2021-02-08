<?php
/**
 * The CF7 Custom Spinner uninstall class
 */

 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The uninstall class
 */
if ( !class_exists( 'PP_CF7_Custom_Spinner_Uninstall' ) ) { 

  class PP_CF7_Custom_Spinner_Uninstall {
    
    /**
     * reference to core class
     *
     * @since  1
     * @access private
     */
    private $_core;
    
    
    /**
	   * Initialize the uninstall class
     *
     * @since 1
     */
    public function __construct( $_core ) {
      
      $this->_core = $_core;
      
    }
    
    /**
	   * plugin uninstall
     *
     * @since 1
     * @access public
     */
    public function uninstall() {
      
      // delete the user meta from all users
      
      delete_metadata( 'user', 0, $this->_core->get_option_name_admin_notice_next() , '', true );
      delete_metadata( 'user', 0, $this->_core->get_option_name_admin_notice_start() , '', true );

      // delete options
      
      if ( ! is_multisite() ) {
        
        // single site
        
        delete_option( $this->_core->get_option_name_settings() );
        delete_option( $this->_core->get_option_name_frontend_css() );
        
      } else {
        
        // multi site
        
        if ( function_exists( 'get_sites' ) ) {
        
          // WP 4.6 and above
          
          $site_ids = get_sites( array( 'number' => 0, 'fields' => 'ids' ) );
          
        } else {
          
          // WP prior to 4.6
          
          $site_ids = array();
          
          foreach( wp_get_sites( array( 'limit' => 0 ) ) as $site ) {
            
            $site_ids[] = $site['blog_id'];
            
          }
          
        }
        
        foreach ( $site_ids as $site_id ) {
          
          delete_blog_option( $site_id, $this->_core->get_option_name_settings() );
          delete_blog_option( $site_id, $this->_core->get_option_name_frontend_css() );
           
        }
        
      }
      
    }

  }
  
}