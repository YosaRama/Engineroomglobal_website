<?php
/**
 * The CF7 Custom Spinner sizes class
 */

 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The sizes class
 */
if ( !class_exists( 'PP_CF7_Custom_Spinner_Sizes' ) ) { 

  class PP_CF7_Custom_Spinner_Sizes {
    
    
    /**
     * reference to core class
     *
     * @since  1
     * @access private
     */
    private $_core;
    
    
    /**
     * Array of sizes
     *
     * @since  1
     * @access private
     */
    private $sizes;
    
    
    /**
	   * Initialize the sizes class
     *
     * @since 1
     */
    public function __construct( $_core ) {
      
      $this->_core = $_core;
      $this->sizes = array();
      $this->load_default_sizes();
      $this->filter_sizes();
      $this->order_sizes();
      
    }
    
    
    /**
	   * Load all built in sizes
     *
     * @since 1
     */
    private function load_default_sizes() {
     
      $this->sizes = array(
      
        array( 'name' => 'Mini',   'size' => 16 ),
        array( 'name' => 'Medium', 'size' => 32 ),
        array( 'name' => 'Maxi',   'size' => 48 )
        
      );
      
    }
    
    
    /**
	   * filter default sizes
     *
     * @since 1
     */
    private function filter_sizes() {
      
      $this->sizes = apply_filters( 'pp_cf7cs_sizes', $this->sizes );

    }
    
    
    /**
	   * order the sizes
     *
     * @since 1
     */
    private function order_sizes() {
      
      usort( $this->sizes, function( $a, $b ) {
        return $a['size'] - $b['size'];;
      } );

    }
    
    
    /**
	   * get an array of size keys
     *
     * @since 1
     * @return array Array Keys of sizes array
     */
    public function get_keys() {
      
      return array_keys( $this->sizes );
      
    }
    
    
    /**
	   * get all sizes
     *
     * @since 1
     * @return array sizes array
     */
    public function get() {
      
      return $this->sizes;
      
    }
    
    
    /**
	   * get name for a size
     *
     * @since 1
     * @return string size name
     */
    public function get_name( $key ) {
      
      return $this->sizes[$key]['name'];
      
    }
    
    
    /**
	   * get admin CSS class for a size
     *
     * @since 1
     * @return string CSS id
     */
    public function get_admin_css_class( $key ) {
          
      return 'cf7cs-' . $key . 'z';
      
    }
    
    
    /**
	   * get admin css for a size
     *
     * @since 1
     * @return string CSS Code
     */
    public function get_admin_css( $key ) {
      
      $padding = ( 120 - $this->sizes[$key]['size'] ) / 2;
      return '.' . $this->get_admin_css_class( $key ) . ' li { box-sizing: border-box; padding: ' . $padding . 'px; }';
      
    }
    
    
    /**
	   * get color array key by size value
     *
     * @since 1
     * @param  int $size the size in pixels
     * @return int       array index
     */
    public function get_size_by_size( $size ) {
      
      if ( ! $size ) {
        
        // use the first if not set
        return 0;
        
      }
          
      foreach ( $this->sizes as $key => $value ) {
        
        if ( $value['size'] == $size ) {
          
          return $key;
          
        }
      }
      
      // use the first if no success
      return 0;
      
    }
    
    
    /**
	   * get size by key
     *
     * @since 1
     * @return string HTML Color Code
     */
    public function get_size( $key ) {
          
      return $this->sizes[$key]['size'];
      
    }
  
  }
}