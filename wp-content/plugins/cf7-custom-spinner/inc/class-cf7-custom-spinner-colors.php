<?php
/**
 * The CF7 Custom Spinner colors class
 */

 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The colors class
 */
if ( !class_exists( 'PP_CF7_Custom_Spinner_Colors' ) ) { 

  class PP_CF7_Custom_Spinner_Colors {
    
    
    /**
     * reference to core class
     *
     * @since  1
     * @access private
     */
    private $_core;
    
    
    /**
     * Array of colors
     *
     * @since  1
     * @access private
     */
    private $colors;
    
    
    /**
	   * Initialize the colors class
     *
     * @since 1
     */
    public function __construct( $_core ) {
      
      $this->_core = $_core;
      $this->colors = array();
      $this->load_default_colors();
      $this->filter_colors();
      $this->order_colors();
      
    }
    
    
    /**
	   * Load all built in colors
     *
     * @since 1
     */
    private function load_default_colors() {
     
      $this->colors = array(
      
        array( 'color' => '#000000', 'bg' => '#FFFFFF' ),
        array( 'color' => '#001F3F', 'bg' => '#FFFFFF' ),
        array( 'color' => '#0074D9', 'bg' => '#EEEEEE' ),
        array( 'color' => '#39CCCC', 'bg' => '#888888' ),
        array( 'color' => '#3D9970', 'bg' => '#888888' ),
        array( 'color' => '#2ECC40', 'bg' => '#FFFFFF' ),
        array( 'color' => '#01FF70', 'bg' => '#888888' ),
        array( 'color' => '#FFDC00', 'bg' => '#888888' ),
        array( 'color' => '#FF851B', 'bg' => '#FFFFFF' ),
        array( 'color' => '#FF4136', 'bg' => '#FFFFFF' ),
        array( 'color' => '#85144B', 'bg' => '#FFFFFF' ),
        array( 'color' => '#F012BE', 'bg' => '#333333' ),
        array( 'color' => '#B10DC9', 'bg' => '#FFFFFF' ),
        array( 'color' => '#AAAAAA', 'bg' => '#FFFFFF' ),
        array( 'color' => '#DDDDDD', 'bg' => '#333333' ),
        array( 'color' => '#FFFFFF', 'bg' => '#333333' )
        
      );
      
    }
    
    
    /**
	   * filter default colors
     *
     * @since 1
     */
    private function filter_colors() {
      
      $this->colors = apply_filters( 'pp_cf7cs_colors', $this->colors );

    }
    
    
    /**
	   * order the colors
     *
     * @since 1
     */
    private function order_colors() {
      
      usort( $this->colors, function( $a, $b ) {
        return strcmp ( $a['color'], $b['color'] );
      } );

    }
    
    
    /**
	   * get an array of color keys
     *
     * @since 1
     * @return array Array Keys of color array
     */
    public function get_keys() {
      
      return array_keys( $this->colors );
      
    }
    
    
    /**
	   * get all spinners
     *
     * @since 1
     * @return array colors array
     */
    public function get() {
      
      return $this->colors;
      
    }
    
    
    /**
	   * get admin CSS id for a color
     *
     * @since 1
     * @return string CSS id
     */
    public function get_admin_css_id( $key ) {
          
      return 'cf7cs-' . $key . 'c';
      
    }
    
    
    /**
	   * get admin css for a color
     *
     * @since 1
     * @return string CSS Code
     */
    public function get_admin_css( $key ) {
          
      return '#' . $this->get_admin_css_id( $key ) . '{ background-color: ' . $this->colors[$key]['color'] . '}';
      
    }
    
    
    /**
	   * get color by key
     *
     * @since 1
     * @return string HTML Color Code
     */
    public function get_color( $key ) {
          
      return $this->colors[$key]['color'];
      
    }
    
    
    /**
	   * get background-color for admin display by key
     *
     * @since 1
     * @return string HTML Color Code
     */
    public function get_bg_color( $key ) {
          
      return $this->colors[$key]['bg'];
      
    }
    
    
    /**
	   * get color array key by color value
     *
     * @since 1
     * @param  string $color the CSS color
     * @return int           array index
     */
    public function get_color_by_color( $color ) {
      
      if ( ! $color ) {
        
        // use the first if not set
        return 0;
        
      }
          
      foreach ( $this->colors as $key => $value ) {
        
        if ( $value['color'] == $color ) {
          
          return $key;
          
        }
      }
      
      // use the first if no success
      return 0;
      
    }
  
  }
}