<?php

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class PR_admin_settings {
    
     protected $page_slug = 'pr-settings-page';


     public $pr_elements_keys = ['pr-navbar','pr-logo','pr-button','pr-search-box','pr-blog','pr-posts-carousel','pr-portfolio-grid','pr-countdown','pr-modal','pr-dual-header','pr-maps','pr-person','pr-services','pr-infobox','pr-progressbar','pr-testimonials','pr-person-carousel','pr-social-share','pr-image-carousel','pr-pricing-table','pr-contactform','pr-map-api', 'pr-map-disable-api','pr-grid'];
    
    private $pr_default_settings;
    
    private $pr_settings;
    
    private $pr_get_settings;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'pr_admin_menu' ), 200 );
        add_action( 'admin_enqueue_scripts', array( $this, 'pr_admin_page_scripts' ) );
        add_action( 'wp_ajax_pr_save_admin_addons_settings', array( $this, 'pr_save_settings_with_ajax' ) );
    }
    

    public function pr_admin_page_scripts () {
        $current_screen = get_current_screen();
        if( strpos($current_screen->id , $this->page_slug) !== false ){
            
            wp_register_style( 'pr-admin-style', PR_ADDONS_URL.'admin/assets/admin.css' );
            wp_enqueue_style('pr-admin-style');
            
            wp_register_style( 'pr-sweetalert-style', PR_ADDONS_URL.'admin/assets/js/sweetalert2/css/sweetalert2.min.css' );
            wp_enqueue_style('pr-sweetalert-style');
            
            wp_register_script('pr-admin-js', PR_ADDONS_URL .'admin/assets/admin.js' , array('jquery','jquery-ui-tabs'), PR_ADDONS_VERSION , true );
            wp_enqueue_script('pr-admin-js');
            
            wp_register_script('pr-admin-dialog', PR_ADDONS_URL . 'admin/assets/js/dialog/dialog.js',array('jquery-ui-position'),PR_ADDONS_VERSION,true);
            wp_enqueue_script('pr-admin-dialog');
            
            wp_register_script( 'pr-sweetalert-core', PR_ADDONS_URL.'admin/assets/js/sweetalert2/js/core.js', array( 'jquery' ), PR_ADDONS_VERSION, true );
            wp_enqueue_script('pr-sweetalert-core');
            
			wp_register_script( 'pr-sweetalert', PR_ADDONS_URL.'admin/assets/js/sweetalert2/js/sweetalert2.min.js', array( 'jquery', 'pr-sweetalert-core' ), PR_ADDONS_VERSION, true );
            wp_enqueue_script('pr-sweetalert');
            
        }
    }

    public function pr_admin_menu() {

		add_submenu_page(
			'elementor',
			'Pixerex Elements',
			'Pixerex Elements',
			'manage_options',
			'pr-settings-page',
			array( $this, 'pr_admin_page' )
		);

	}

    public function pr_admin_page(){
        $js_info = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'pr-admin-js', 'settings', $js_info );
       
        $this->pr_default_settings = array_fill_keys( $this->pr_elements_keys, true );
       
        $this->pr_get_settings = get_option( 'pr_save_settings', $this->pr_default_settings );
       
        $pr_new_settings = array_diff_key( $this->pr_default_settings, $this->pr_get_settings );
       
        if( ! empty( $pr_new_settings ) ) {
            $pr_updated_settings = array_merge( $this->pr_get_settings, $pr_new_settings );
            update_option( 'pr_save_settings', $pr_updated_settings );
        }
        $this->pr_get_settings = get_option( 'pr_save_settings', $this->pr_default_settings );
       
	?>
	<div class="wrap">
        <div class="response-wrap"></div>
        <form action="" method="POST" id="pr-settings" name="pr-settings">
            <div class="header-wrapper">
                    <h1 class="main-title"><?php echo esc_html__('Pixerex Elements', 'pixerex'); ?></h1>
            </div>
            <div class="settings-tabs">
                <ul class="settings-tabs-list">
                    <li><a class="tab-list-item" href="#modules">Elements</a></li>
                    <li><a class="tab-list-item" href="#maps-api">Google Maps API</a></li>
                </ul>
                <div id="modules" class="pr-settings-tab">
                    <div>
                        <br>
                        <input type="checkbox" class="pr-checkbox" checked="checked">
                        <label>Enable/Disable All</label>
                    </div>
                    <table class="elements-table">
                        <tbody>
                            <tr>
                                    <th><?php echo esc_html__('Navbar', 'pixerex'); ?></th>
                                    <td>
                                        <label class="switch">
                                                <input type="checkbox" id="pr-navbar" name="pr-navbar" <?php checked(1, $this->pr_get_settings['pr-navbar'], true) ?>>
                                                <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <th><?php echo esc_html__('Site Logo', 'pixerex'); ?></th>
                                    <td>
                                        <label class="switch">
                                                <input type="checkbox" id="pr-logo" name="pr-logo" <?php checked(1, $this->pr_get_settings['pr-logo'], true) ?>>
                                                <span class="slider round"></span>
                                        </label>
                                    </td>
                            </tr>
                            <tr>
                                    <th><?php echo esc_html__('Search Box', 'pixerex'); ?></th>
                                    <td>
                                        <label class="switch">
                                                <input type="checkbox" id="pr-search-box" name="pr-search-box" <?php checked(1, $this->pr_get_settings['pr-search-box'], true) ?>>
                                                <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <th><?php echo esc_html__('Button', 'pixerex'); ?></th>
                                    <td>
                                        <label class="switch">
                                                <input type="checkbox" id="pr-button" name="pr-button" <?php checked(1, $this->pr_get_settings['pr-button'], true) ?>>
                                                <span class="slider round"></span>
                                        </label>
                                    </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Posts', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-blog" name="pr-blog" <?php checked(1, $this->pr_get_settings['pr-blog'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo esc_html__('Countdown', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-countdown" name="pr-countdown" <?php checked(1, $this->pr_get_settings['pr-countdown'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo esc_html__('Dual Heading', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-dual-header" name="pr-dual-header" <?php checked(1, $this->pr_get_settings['pr-dual-header'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>

                                <th><?php echo esc_html__('Google Maps', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-maps" name="pr-maps" <?php checked(1, $this->pr_get_settings['pr-maps'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>    
                                <th><?php echo esc_html__('Team Member', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-person" name="pr-person" <?php checked(1, $this->pr_get_settings['pr-person'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo esc_html__('Progress Bar', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-progressbar" name="pr-progressbar" <?php checked(1, $this->pr_get_settings['pr-progressbar'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            </tr>
                            
                            <tr>
                                <th><?php echo esc_html__('Testimonials', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-testimonials" name="pr-testimonials" <?php checked(1, $this->pr_get_settings['pr-testimonials'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>

                                <th><?php echo esc_html__('Pricing Table', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-pricing-table" name="pr-pricing-table" <?php checked(1, $this->pr_get_settings['pr-pricing-table'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            
                            <tr>
                                <th><?php echo esc_html__('Contact Form7', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-contactform" name="pr-contactform" <?php checked(1, $this->pr_get_settings['pr-contactform'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                </td>

                                <th><?php echo esc_html__('Portfolio Grid', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-portfolio-grid" name="pr-portfolio-grid" <?php checked(1, $this->pr_get_settings['pr-portfolio-grid'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <th><?php echo esc_html__('Services', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-services" name="pr-services" <?php checked(1, $this->pr_get_settings['pr-services'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                </td>

                                <th><?php echo esc_html__('Infobox', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-infobox" name="pr-infobox" <?php checked(1, $this->pr_get_settings['pr-infobox'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <th><?php echo esc_html__('Team Carousel', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-person-carousel" name="pr-person-carousel" <?php checked(1, $this->pr_get_settings['pr-person-carousel'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                </td>

                                <th><?php echo esc_html__('Image Carousel', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-image-carousel" name="pr-image-carousel" <?php checked(1, $this->pr_get_settings['pr-image-carousel'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Modal', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-modal" name="pr-modal" <?php checked(1, $this->pr_get_settings['pr-modal'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo esc_html__('Posts Carousel', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-posts-carousel" name="pr-posts-carousel" <?php checked(1, $this->pr_get_settings['pr-posts-carousel'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__('Social Share', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-social-share" name="pr-social-share" <?php checked(1, $this->pr_get_settings['pr-social-share'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                                <th><?php echo esc_html__('Image Grid', 'pixerex'); ?></th>
                                <td>
                                    <label class="switch">
                                            <input type="checkbox" id="pr-grid" name="pr-grid" <?php checked(1, $this->pr_get_settings['pr-grid'], true) ?>>
                                            <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" value="Save Settings" class="button btn save-button">
                    
                </div>
                <div id="maps-api" class="maps-tab">
                    <div class="maps-row">
                        <table class="maps-table">
                            <tr>
                                <p class="maps-api-notice">
                                    The Maps Element requires Google API key to be entered below. If you don’t have one, Click <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"> Here</a> to get your  key.
                                </p>
                            </tr>
                            <tr>
                                <th><h4 class="api-title"><label>Google Maps API Key:</label><input name="pr-map-api" id="pr-map-api" type="text" placeholder="API Key" value="<?php echo $this->pr_get_settings['pr-map-api']; ?>"></h4></th>
                            </tr>
                            <tr>
                                <th><h4 class="api-disable-title"><label><?php echo esc_html__('Enable Maps API JS File:','pixerex'); ?></label><input name="pr-map-disable-api" id="pr-map-disable-api" type="checkbox" <?php checked(1, $this->pr_get_settings['pr-map-disable-api'], true) ?>><span>This will Enable the API JS file if it's not included by another theme or plugin</span></h4></th>
                            </tr>
                        </table>
                        <input type="submit" value="Save Settings" class="button btn save-button">
                    </div>
                </div>

            </div>
            </form>
        </div>
	<?php
}

    public function pr_save_settings_with_ajax() {

            if( isset( $_POST['fields'] ) ) {
                parse_str( $_POST['fields'], $settings );
            }else {
                return;
            }

            $this->pr_settings = array(
                'pr-navbar'             => intval( $settings['pr-navbar'] ? 1 : 0 ),
                'pr-logo'               => intval( $settings['pr-logo'] ? 1 : 0 ),
                'pr-button'             => intval( $settings['pr-button'] ? 1 : 0 ),
                'pr-search-box'         => intval( $settings['pr-search-box'] ? 1 : 0 ),
                'pr-blog'               => intval( $settings['pr-blog'] ? 1 : 0 ),
                'pr-posts-carousel'     => intval( $settings['pr-posts-carousel'] ? 1 : 0 ),
                'pr-portfolio-grid'     => intval( $settings['pr-portfolio-grid'] ? 1 : 0 ),
                'pr-countdown'          => intval( $settings['pr-countdown'] ? 1 : 0 ),
                'pr-dual-header'        => intval( $settings['pr-dual-header'] ? 1 : 0 ),
                'pr-modal'              => intval( $settings['pr-modal'] ? 1 : 0 ),
                'pr-social-share'       => intval( $settings['pr-social-share'] ? 1 : 0 ),
                'pr-maps'               => intval( $settings['pr-maps'] ? 1 : 0 ),
                'pr-person' 			=> intval( $settings['pr-person'] ? 1 : 0 ),
                'pr-services' 			=> intval( $settings['pr-services'] ? 1 : 0 ),
                'pr-infobox' 			=> intval( $settings['pr-infobox'] ? 1 : 0 ),
                'pr-progressbar' 		=> intval( $settings['pr-progressbar'] ? 1 : 0 ),
                'pr-testimonials' 		=> intval( $settings['pr-testimonials'] ? 1 : 0 ),
                'pr-person-carousel' 	=> intval( $settings['pr-person-carousel'] ? 1 : 0 ),
                'pr-image-carousel' 	=> intval( $settings['pr-image-carousel'] ? 1 : 0 ),
                'pr-pricing-table'      => intval( $settings['pr-pricing-table'] ? 1 : 0),
                'pr-contactform'        => intval( $settings['pr-contactform'] ? 1 : 0),
                'pr-grid'               => intval( $settings['pr-grid'] ? 1 : 0),
                'pr-map-api'            => $settings['pr-map-api'],
                'pr-map-disable-api'    => intval( $settings['pr-map-disable-api'] ? 1 : 0),
            );
            update_option( 'pr_save_settings', $this->pr_settings );
            
            return true;
            die();


        }
}


new PR_admin_settings();
