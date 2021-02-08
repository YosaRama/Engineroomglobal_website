<?php
/**
 * The CF7 Custom Spinner spinners class
 */

 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The spinners class
 */
if ( !class_exists( 'PP_CF7_Custom_Spinner_Spinners' ) ) { 

  class PP_CF7_Custom_Spinner_Spinners {
    
    
    /**
     * reference to core class
     *
     * @since  1
     * @access private
     */
    private $_core;
    
    
    /**
     * Array of spinners
     *
     * @since  1
     * @access private
     */
    private $spinners;
    
    
    /**
	   * Initialize the spinners class
     *
     * @since 1
     */
    public function __construct( $_core ) {
      
      $this->_core = $_core;
      $this->spinners = array();
      $this->load_default_spinners();
      $this->filter_spinners();
      
    }
    
    
    /**
	   * Load all built in spinners
     *
     * @since 1
     */
    private function load_default_spinners() {
      
      $spinnerfiles = array(
        'spinner01',
        'spinner02',
        'spinner03',
        'spinner04',
        'spinner05',
        'spinner06',
        'spinner07',
        'spinner08',
        'spinner09',
        'spinner10',
        'spinner11',
        'spinner12'
      );
      
      foreach( $spinnerfiles as $spinnerfile ) {
        
        $this->add_spinner_from_file( $spinnerfile );
      
      }
      
    }
    
    
    /**
	   * add single spinner
     *
     * @since 1
     */
    private function add_spinner_from_file( $file ) {
      
      $this->spinners[] = array( 'id' => $file, 'css' => file_get_contents ( plugin_dir_path( $this->_core->get_plugin_file() ) . '/inc/spinners/' . $file . '.css' ) );

    }
    
    
    /**
	   * filter default spinners
     *
     * @since 1
     */
    private function filter_spinners() {
      
      $this->spinners = apply_filters( 'pp_cf7cs_spinners', $this->spinners );

    }
    
    
    /**
	   * get an array of spinner keys
     *
     * @since 1
     * @return array Array Keys of spinner array
     */
    public function get_keys() {
      
      return array_keys( $this->spinners );
      
    }
    
    
    /**
	   * get all spinners
     *
     * @since 1
     * @return array spinner array
     */
    public function get() {
      
      return $this->spinners;
      
    }
    
    
    /**
	   * get admin CSS id for a spinner
     *
     * @since 1
     * @param  int $key array index
     * @return string   CSS id
     */
    public function get_admin_css_id( $key ) {
          
      return 'cf7cs-' . $key . 's';
      
    }
    
    
    /**
	   * get admin css for a spinner
     *
     * @since 1
     * @param  int $key array index
     * @return string   CSS Code
     */
    public function get_admin_css( $key ) {
          
      return str_replace( '___SPINNER___', '#' . $this->get_admin_css_id( $key ), $this->spinners[$key]['css'] );
      
    }
    
    
    /**
	   * get frontend css for a spinner
     *
     * @since 1
     * @param  int $key array index
     * @return string   CSS Code
     */
    public function get_frontend_css( $key ) {

      return preg_replace('/\s+/', ' ', str_replace( '___SPINNER___', 'div.wpcf7 .ajax-loader', $this->spinners[$key]['css'] ) );
      
    }
    
    
    /**
	   * get spinner array key by spinner id
     *
     * @since 1
     * @param  string $id spinner id
     * @return int        array index
     */
    public function get_spinner_by_id( $id ) {
      
      if ( ! $id ) {
        
        // use the first if not set
        return 0;
        
      }
          
      foreach ( $this->spinners as $key => $value ) {
        
        if ( $value['id'] == $id ) {
          
          return $key;
          
        }
      }
      
      // use the first if no success
      return 0;
      
    }
    
    
    /**
	   * get spinner id by array key
     *
     * @since 1
     * @param  int $key array index
     * @return string   spinner id
     */
    public function get_spinner_id( $key ) {
      
      return $this->spinners[$key]['id'];
      
    }
  
  }
  
}