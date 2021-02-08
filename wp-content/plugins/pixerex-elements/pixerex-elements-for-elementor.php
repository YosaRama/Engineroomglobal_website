<?php 
/*
Plugin Name: Pixerex Elements
Description:  Addons Plugin Includes 14 widgets for Elementor Page Builder.
Plugin URI: https://themeforest.net/user/style-themes/portfolio
Author: Pixerex
Version: 1.0.0
Author URI: https://themeforest.net/user/style-themes/portfolio
*/


/**
* Checking the set ups and the environment
*/

if( !function_exists('add_action') ) {
	die('WordPress not Installed'); // if WordPress not installed kill the page.
}

if( !defined( 'ABSPATH' ) ) exit; // No access of directly access

define( 'PR_ADDONS_VERSION', '1.0.0' );
define( 'PR_ADDONS_URL', plugins_url('/', __FILE__ ) );
define( 'PR_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'PR_ADDONS_FILE', __FILE__ );
define( 'PR_ADDONS_BASENAME', plugin_basename(__FILE__));


	/**
	* Translating the plugin and load some 
	* assets
	*/
	add_action( 'plugins_loaded', 'pr_elementor_setup');
	function pr_elementor_setup() {
		// Loading .mo and.po file from the lang folder
            load_plugin_textdomain( 'pixerex', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
            
        
        if( file_exists( PR_ADDONS_PATH.'admin/settings-page.php' ) ) {
            require_once( PR_ADDONS_PATH.'admin/settings-page.php' );
		}
		
        new PR_Elements_Elementor();
    }
    

    /**
    * Registering a Group Control for All Posts Element
    */
    function pr_posts_register_control( $controls_manager ){
        include_once PR_ADDONS_PATH. 'controls/pr-posts-group-control.php';
        $controls_manager->add_group_control( 'prposts', new Elementor\PR_Posts_Group_Control() );
    }

    add_action( 'elementor/controls/controls_registered', 'pr_posts_register_control' );
    
	class PR_Elements_Elementor {

        protected $pr_elements_keys = ['pr-navbar','pr-logo','pr-button','pr-search-box','pr-blog','pr-posts-carousel','pr-portfolio-grid','pr-countdown','pr-modal','pr-dual-header','pr-maps','pr-person','pr-services','pr-infobox','pr-progressbar','pr-testimonials','pr-person-carousel','pr-social-share','pr-image-carousel','pr-pricing-table', 'pr-contactform','pr-grid'];

		/**
		* Load all the hooks here
		* @since 1.0
		*/
		public function __construct() {
            add_action('elementor/init', array( $this, 'initiate_elementor_addons' ) );
            add_action('elementor/controls/controls_registered', array( $this, 'pr_icon_pack' ), 11 );
			add_action('elementor/widgets/widgets_registered', array( $this, 'pr_widget_register') );
			add_action('wp_enqueue_scripts', array( $this, 'pr_maps_required_script') );
            add_action('elementor/frontend/after_register_scripts', array($this, 'pr_register_scripts'));
            add_action('elementor/frontend/after_register_styles', array($this, 'pr_register_styles'));
            add_action('elementor/frontend/after_enqueue_styles', array($this, 'pr_enqueue_styles'));
            add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'pr_editor_enqueue_styles' ) );
		}

        /**
        * Register all frontend stylesheets
        */
        public function pr_register_styles(){
            wp_register_style('uikit', PR_ADDONS_URL . 'assets/css/uikit.min.css', array(), PR_ADDONS_VERSION, 'all');
            wp_register_style('pr-icons', PR_ADDONS_URL . 'assets/css/iconfont.css', array(), PR_ADDONS_VERSION, 'all');
            wp_register_style('pr-style', PR_ADDONS_URL . 'assets/css/pr-style.css', array(), PR_ADDONS_VERSION, 'all');
            $check_grid_active = isset(get_option('pr_save_settings')['pr-grid']) ? get_option('pr_save_settings')['pr-grid']: true;
            $check_testimonials_active = isset(get_option('pr_save_settings')['pr-testimonials']) ? get_option('pr_save_settings')['pr-testimonials']: true;
            $check_team_carousel_active = isset(get_option('pr_save_settings')['pr-person-carousel']) ? get_option('pr_save_settings')['pr-person-carousel']: true;
            $check_image_carousel_active = isset(get_option('pr_save_settings')['pr-image-carousel']) ? get_option('pr_save_settings')['pr-image-carousel']: true;
            $check_social_share_active = isset(get_option('pr_save_settings')['pr-social-share']) ? get_option('pr_save_settings')['pr-social-share']: true;
            if($check_testimonials_active || $check_team_carousel_active || $check_image_carousel_active){
                wp_register_style('slick', PR_ADDONS_URL . 'assets/css/slick.css', array(), PR_ADDONS_VERSION, 'all');
            }
            if($check_social_share_active){
                wp_register_style('social-share-style', PR_ADDONS_URL . 'assets/css/social-share.css', array(), PR_ADDONS_VERSION, 'all');
            }
        }
    
        /*
         * Enqueue all frontend stylesheets
         */
        public function pr_enqueue_styles(){
            wp_enqueue_style('uikit');
            wp_enqueue_style('pr-icons');
            wp_enqueue_style('pr-style');
            $check_grid_active = isset(get_option('pr_save_settings')['pr-grid']) ? get_option('pr_save_settings')['pr-grid']: true;
            $check_testimonials_active = isset(get_option('pr_save_settings')['pr-testimonials']) ? get_option('pr_save_settings')['pr-testimonials']: true;
            $check_team_carousel_active = isset(get_option('pr_save_settings')['pr-person-carousel']) ? get_option('pr_save_settings')['pr-person-carousel']: true;
            $check_image_carousel_active = isset(get_option('pr_save_settings')['pr-image-carousel']) ? get_option('pr_save_settings')['pr-image-carousel']: true;
            $check_social_share_active = isset(get_option('pr_save_settings')['pr-social-share']) ? get_option('pr_save_settings')['pr-social-share']: true;
            if($check_testimonials_active || $check_team_carousel_active || $check_image_carousel_active){
                wp_enqueue_style('slick');
            }
            if($check_social_share_active){
                wp_enqueue_style('social-share-style');
            }
        }

        public function pr_editor_enqueue_styles() {
            wp_enqueue_style( 'pr-icons', PR_ADDONS_URL . 'assets/css/iconfont.css', array(), PR_ADDONS_VERSION, 'all');
    
        }

        /*
         * Enqueue Maps API script
         */
        public function pr_maps_required_script() {
            $pr_maps_api = get_option( 'pr_save_settings' )['pr-map-api'];
            $pr_maps_disable_api = get_option( 'pr_save_settings' )['pr-map-disable-api'];
            $pr_maps_enabled = get_option( 'pr_save_settings' )['pr-maps'];
            if ( $pr_maps_enabled == 1 && $pr_maps_disable_api == 1 ) {
                wp_enqueue_script('google-maps-script','https://maps.googleapis.com/maps/api/js?key='.$pr_maps_api , array(), PR_ADDONS_VERSION, false);
            }
        }
            
        public function pr_register_scripts(){
            $pr_default_settings = array_fill_keys($this->pr_elements_keys, true);
        
            $check_component_active = get_option('pr_save_settings', $pr_default_settings);

            if( $check_component_active['pr-progressbar'] ) {
                wp_register_script( 'pr-js', PR_ADDONS_URL . 'assets/js/pr-main.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
                wp_register_script('waypoints', PR_ADDONS_URL . 'assets/js/lib/jquery.waypoints.js' , array('jquery'), PR_ADDONS_VERSION , true);
            }

            if( $check_component_active['pr-testimonials'] || $check_component_active['pr-person-carousel'] || $check_component_active['pr-image-carousel']) {
                wp_register_script( 'pr-js', PR_ADDONS_URL . 'assets/js/pr-main.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
                wp_register_script( 'slick-carousel-js', PR_ADDONS_URL . 'assets/js/lib/slickmin.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
            }

            if( $check_component_active['pr-social-share']) {
                wp_register_script( 'goodshare-js', PR_ADDONS_URL . 'assets/js/lib/goodshare.js', array(), PR_ADDONS_VERSION, true );
            }
            
            if( $check_component_active['pr-grid'] ) {
                wp_register_script( 'pr-js', PR_ADDONS_URL . 'assets/js/pr-main.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
                wp_register_script('isotope-js', PR_ADDONS_URL . 'assets/js/lib/isotope.js',  array( 'jquery' ), PR_ADDONS_VERSION, true);
                wp_register_script('uikit', PR_ADDONS_URL . 'assets/js/uikit.min.js',  array( 'jquery' ), PR_ADDONS_VERSION, true);
            }

            if( $check_component_active['pr-blog'] ) {
                wp_register_script('imagesloaded-js', PR_ADDONS_URL . 'assets/js/lib/imagesloaded.pkgd.min.js',  array( 'jquery' ), PR_ADDONS_VERSION, true);
                wp_register_script('masonry-js', PR_ADDONS_URL . 'assets/js/lib/masonry.min.js',  array( 'jquery' ), PR_ADDONS_VERSION, true);
            }

            if( $check_component_active['pr-posts-carousel'] || $check_component_active['pr-portfolio-grid'] ) {
                wp_register_script( 'pr-js', PR_ADDONS_URL . 'assets/js/pr-main.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
                wp_register_script('uikit', PR_ADDONS_URL . 'assets/js/uikit.min.js',  array( 'jquery' ), PR_ADDONS_VERSION, true);
            }

            if( $check_component_active['pr-countdown'] ) {
                wp_register_script( 'count-down-timer-js', PR_ADDONS_URL .'assets/js/lib/jquerycountdown.js', array( 'jquery' ), PR_ADDONS_VERSION, 
                    true );
                wp_register_script( 'pr-js', PR_ADDONS_URL . 'assets/js/pr-main.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
            }
            
            if ($check_component_active['pr-modal']) {
                wp_register_script( 'pr-js', PR_ADDONS_URL . 'assets/js/pr-main.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
                wp_register_script('uikit', PR_ADDONS_URL . 'assets/js/uikit.min.js',  array( 'jquery' ), PR_ADDONS_VERSION, true);
            }

            if ($check_component_active['pr-maps']) {
                wp_register_script('pr-maps-js', PR_ADDONS_URL . 'assets/js/pr-maps.js', array('jquery'), PR_ADDONS_VERSION, true);
            }
        }

    /**
     * Extend Icon pack core controls.
     *
     * @param  object $controls_manager Controls manager instance.
     * @return void
     */

    public function pr_icon_pack( $controls_manager ) {

        require_once PR_ADDONS_PATH. 'controls/pr-icon.php';

        $controls = array(
            $controls_manager::ICON => 'PR_Icon_Controler',
        );

        foreach ( $controls as $control_id => $class_name ) {
            $controls_manager->unregister_control( $control_id );
            $controls_manager->register_control( $control_id, new $class_name() );
        }

    }

		public function pr_widget_register() {
			$this->initiate_elementor_addons();
			$this->pr_widgets_area();
		}

		private function pr_widgets_area() {
            $pr_default_settings = array_fill_keys( $this->pr_elements_keys, true );
            $check_component_active = get_option( 'pr_save_settings', $pr_default_settings );
            
            foreach($check_component_active as $element_name  => $element_active){
                if($element_active && $element_name != 'pr-contactform' && $element_name != 'pr-map-api' && $element_name != 'pr-map-disable-api'){
                    if($element_name == 'pr-blog' || $element_name == 'pr-posts-carousel'|| $element_name == 'pr-navbar' || $element_name == 'pr-portfolio-grid'){
                        require_once (PR_ADDONS_PATH . 'includes/queries.php');
                    }
                    require_once (PR_ADDONS_PATH . 'widgets/' . $element_name . '.php');
                } elseif ($element_active && $element_name == 'pr-contactform' && function_exists('wpcf7')){
                    require_once (PR_ADDONS_PATH . 'widgets/' . $element_name . '.php');
                }
            }
		}

		public function initiate_elementor_addons() {
			Elementor\Plugin::instance()->elements_manager->add_category(
				'pr-elements',
				array(
					'title' => __( 'Pixerex Elements', 'pixerex' )
				),
				1
			);
		}	
	}
