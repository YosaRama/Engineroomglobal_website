<?php
/**
 * The Clean Blog Theme Customizer.
 *
 * @package Gentium
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pixe_customize_register($wp_customize)
{
    $wp_customize->get_section('background_image')->title = __( 'Background Image/Color', 'gentium' );
    $wp_customize->remove_section( 'colors' );
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_control( 'background_color'  )->section   = 'background_image';
}
add_action('customize_register', 'pixe_customize_register');
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function pixe_customize_preview_js()
{
    wp_enqueue_script('pixe_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'pixe_customize_preview_js');

if (class_exists('kirki')) {
    
    pixe_Kirki::add_config( 'gentium', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod',
    ) );

    /*--------------------------------------------------------------*/
    /*  the theme settings panel
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_panel( 'theme_settings', array(
        'priority'    => 10,
        'title'       => esc_html__( 'Gentium Theme Settings', 'gentium' ),
        'description' => esc_html__( 'Customize The gentium Theme', 'gentium' ),
    ));

    /*--------------------------------------------------------------*/
    /*  Section -- general settings
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'general_settings', array(
        'title'      => esc_html__( 'General Settings', 'gentium' ),
        'priority'   => 1,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ) );

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'radio',
        'settings'    => 'layout_type',
        'label'       => esc_html__( 'Select Layout of the site', 'gentium' ),
        'section'     => 'general_settings',
        'default'     => 'wide',
        'priority'    => 1,
        'multiple'    => 1,
        'choices'     => array(
            'wide' => esc_html__( 'Wide', 'gentium' ),
            'boxed' => esc_html__( 'Boxed', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'main_color',
        'label'       => esc_html__( 'Primary Color', 'gentium' ),
        'section'     => 'general_settings',
        'default'     => '#e9204f',
        'priority'    => 2,
        'transport' => 'auto',
        'output'   => apply_filters( 'pixe_color_primary', array(
            array(
                'element'  => array( 
                    '.custom-pagination .page-numbers.current','a.loadMore:hover' ,'.breadcrumbs a','.blog-entry-title.entry-title a:hover',
                    '.single-post .post-enty-meta .tags a:hover','.nav-links a:hover','.comment-list .reply a:hover',
                    '.single-post-content .post-enty-meta strong','a.loadMore:hover .text','.woocommerce li.product .price a:hover',
                    '.woocommerce .star-rating','.woocommerce div.product .woocommerce-tabs ul.tabs li.active a'
                    
                 ),
                'property' => 'color',
            ),
            array(
                'element' => array(
                    'a.loadMore:hover', '.custom-pagination .page-numbers.current','#respond input#submit:hover',
                    '.page-numbers:hover','h5','h5','a.loadMore',
                    '#respond #submit','input[type="reset"]', 'input[type="submit"]',
                ),
                'property' => 'border-color',
            ),
            array(
                'element' => array(
                  '#respond #submit:hover','input[type="reset"]:hover', 'input[type="submit"]:hover',
                  '.pixe-split-pages>span','body #loader .loading .progress .bar-loading','.woocommerce ul.products li.product .onsale',
                  '.woocommerce span.onsale','.woocommerce #respond input#submit', '.woocommerce a.button', '.woocommerce button.button', '.woocommerce input.button',
                  '.woocommerce #respond input#submit:hover', '.woocommerce a.button:hover', '.woocommerce button.button:hover', '.woocommerce input.button:hover','.woocommerce .added_to_cart',
                  '.woocommerce #respond input#submit.alt', '.woocommerce a.button.alt', '.woocommerce button.button.alt', '.woocommerce input.button.alt',
                  '.woocommerce a.button.alt:hover', '.woocommerce button.button.alt:hover', '.woocommerce input.button.alt:hover'
                ),
                'property' => 'background-color',
            ),

            array(
                'element' => array(
                  '.spinner:after'
                ),
                'property' => 'border-top-color',
            ),
        )),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'bg_body',
        'description' => esc_html__('Choose a color for the body.' , 'gentium'),
        'label'       => esc_html__( 'Body Background Color', 'gentium' ),
        'section'     => 'general_settings',
        'default'     => '#ffffff',
        'priority'    => 2,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'body',
                'property' => 'background-color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'text_color',
        'description' => esc_html__('Choose a color for the body Text.' , 'gentium'),
        'label'       => esc_html__( 'Body Text Color', 'gentium' ),
        'section'     => 'general_settings',
        'default'     => '#747474',
        'priority'    => 3,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    'body','.post-enty-meta .tags a','.woocommerce ul.products li.product .price','.woocommerce div.product p.price', '.woocommerce div.product span.price'
                ),
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'heading_color',
        'description' => esc_html__('Choose a color for the Heading.' , 'gentium'),
        'label'       => esc_html__( 'Heading Color', 'gentium' ),
        'section'     => 'general_settings',
        'default'     => '#101010',
        'priority'    => 4,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    'h1','h2','h3','h4','h5','h5','h3.entry-title','.blog-entry-title.entry-title a','.meta-share a','.site-title a',
                    '.comment-list .author a','.comment-list .reply a','.nav-links a','.custom-pagination .page-numbers','a.loadMore .text',
                    '#respond #submit','input[type="reset"]', 'input[type="submit"]','blockquote>p','strong','.woocommerce ul.products li.product .price ins',
                    '.woocommerce div.product p.price ins', '.woocommerce div.product span.price ins','.woocommerce div.product .woocommerce-tabs ul.tabs li a',
                    '.woocommerce .cart_item .product-name a','.form-row label','.woocommerce .woocommerce-MyAccount-navigation-link.is-active a'
                ),
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'link_color',
        'description' => esc_html__('Choose a color for the site Links.' , 'gentium'),
        'label'       => esc_html__( 'Links Color', 'gentium' ),
        'section'     => 'general_settings',
        'default'     => '#101010',
        'priority'    => 5,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    'a'
                ),
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'link_hover_color',
        'description' => esc_html__('Choose a color for the site Links Hover.' , 'gentium'),
        'label'       => esc_html__( 'Links Hover Color', 'gentium' ),
        'section'     => 'general_settings',
        'default'     => '#e9204f',
        'priority'    => 6,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' =>  'a:hover',
                'property' => 'color',
            ),
        ),
    ));


    /*--------------------------------------------------------------*/
    /*  Section -- Header
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'section_site_header', array(
        'title'      => esc_html__( 'Header', 'gentium' ),
        'priority'   => 3,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'custom',
        'settings'    => 'home_layout_collapsible_tiles',
        'section'     => 'section_site_header',
        'priority'    => 10,
    ) );

    /*--------------------------------------------------------------*/
    /*  Section -- Desktop Header
    /*--------------------------------------------------------------*/

    pixe_Kirki::add_section( 'desktop_header_options', array(
        'title'      => esc_html__( 'Header', 'gentium' ),
        'priority'   => 1,
        'panel' => 'theme_settings',
        'section'     => 'section_site_header',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'header_layout_type',
        'label'       => esc_html__( 'Header Layout', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => 'header-1',
        'priority'    => 10,
        'choices'     => array(
            'header-1'  => esc_html__( 'Header 1', 'gentium' ),
            'custom'    => esc_html__( 'custom', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'select_header_template',
        'label'	   	  => esc_html__( 'Select Template', 'gentium' ),
		'description' => esc_html__( 'Choose a template created in Theme Templates.', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => 'option-1',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => Kirki_Helper::get_posts( array( 'post_type' => 'pixe_templates' ) ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'custom',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'header_logo_img_max_width',
        'label'       		=> esc_html__( 'Logo Max Width Value', 'gentium' ),
        'section'           => 'desktop_header_options',
        'default'     		=> 120,
        'priority'          => 10,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '500',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.pixe_header_holder .pr-site-branding, .pixe_header_holder .header-wrap .branding',
                'property' 		=> 'max-width',
                'units'    		=> 'px',
            ),            
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'header_bg_color',
        'label'       => esc_html__( 'Header Background Color', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => '#ffffff',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'header.site-header',
                'property' => 'background-color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'header-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'header_nav_color',
        'label'       => esc_html__( 'Header Navigation Color', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => '#101010',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'header.site-header .primary-navigation a',
                'property' => 'color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'header-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'header_nav_color_hover',
        'label'       => esc_html__( 'Header Navigation Hover Color', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => '#e9204f',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'header.site-header .primary-navigation a:hover',
                'property' => 'color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'header-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'header_nav_font_size',
        'label'       		=> esc_html__( 'Navigation Font Size', 'gentium' ),
        'section'           => 'desktop_header_options',
        'default'     		=> 14,
        'priority'          => 10,
        'choices'     		=> array(
            'min'  => '10',
            'max'  => '30',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'header.site-header .primary-navigation a',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'header-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'header_subnav_bg_color',
        'label'       => esc_html__( 'Sub Menu Background Color', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => '#ffffff',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'header.site-header .primary-navigation .sub-menu',
                'property' => 'background-color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'header-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'header_subnav_color',
        'label'       => esc_html__( 'Sub Menu Color', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => '#818181',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'header.site-header .primary-navigation .sub-menu a',
                'property' => 'color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'header-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'header_subnav_color_hover',
        'label'       => esc_html__( 'Sub Menu Hover Color', 'gentium' ),
        'section'     => 'desktop_header_options',
        'default'     => '#e9204f',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'header.site-header .primary-navigation .sub-menu a:hover',
                'property' => 'color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_layout_type',
                'operator' => '==',
                'value'    => 'header-1',
                ),
        ),
    ));

    /*--------------------------------------------------------------*/
    /*  Section -- Sticky Header
    /*--------------------------------------------------------------*/

    pixe_Kirki::add_section( 'sticky_header_options', array(
        'title'      => esc_html__( 'Sticky Header', 'gentium' ),
        'priority'   => 1,
        'panel' => 'theme_settings',
        'section'     => 'section_site_header',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'show_sticky_header',
        'label'       => esc_html__( 'Show Sticky Header', 'gentium' ),
        'section'     => 'sticky_header_options',
        'default'     => '0',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_html__( 'Show', 'gentium' ),
            'off' => esc_html__( 'Hide', 'gentium' ),
        ),
    ));
    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'select_stheader_template',
        'label'	   	  => esc_html__( 'Select Template', 'gentium' ),
		'description' => esc_html__( 'Choose a template created in Theme Templates.', 'gentium' ),
        'section'     => 'sticky_header_options',
        'default'     => 'option-1',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => Kirki_Helper::get_posts( array( 'post_type' => 'pixe_templates' ) ),
        'active_callback' => array(
            array(
                'setting'  => 'show_sticky_header',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'number',
        'settings'    => 'stheader_offset',
        'label'       => esc_html__( 'Sticky Header Offset', 'gentium' ),
        'section'     => 'sticky_header_options',
        'default'     => '30',
        'priority'    => 10,
        'active_callback' => array(
            array(
                'setting'  => 'show_sticky_header',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ) );


    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'stheader_animation',
        'label'       => esc_html__( 'Sticky Header Animation', 'gentium' ),
        'section'     => 'sticky_header_options',
        'default'     => 'uk-animation-fade',
        'priority'    => 10,
        'choices'     => array(
            'uk-animation-fade'          => esc_html__( 'Fade', 'gentium' ),
            'uk-animation-slide-top'     => esc_html__( 'Slide Top', 'gentium' ),
            'uk-animation-slide-bottom'  => esc_html__( 'Slide Bottom', 'gentium' ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'show_sticky_header',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'stheader_on_scroll_up',
        'label'       => esc_html__( 'Show Sticky Header On Scroll up', 'gentium' ),
        'section'     => 'sticky_header_options',
        'default'     => '0',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_html__( 'Show', 'gentium' ),
            'off' => esc_html__( 'Hide', 'gentium' ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'show_sticky_header',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'stheader_logo_img_max_width',
        'label'       		=> esc_html__( 'Logo Max Width Value', 'gentium' ),
        'section'           => 'sticky_header_options',
        'default'     		=> 120,
        'priority'          => 10,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '500',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.pixe_sticky_header_holder .pr-site-branding',
                'property' 		=> 'max-width',
                'units'    		=> 'px',
            ),            
        ),
        'active_callback' => array(
            array(
                'setting'  => 'show_sticky_header',
                'operator' => '==',
                'value'    => '1',
            ),
        ),				
    ));


    /*--------------------------------------------------------------*/
    /*  Section -- Mobile Header
    /*--------------------------------------------------------------*/

    pixe_Kirki::add_section( 'mobile_header_options', array(
        'title'      => esc_html__( 'Mobile Header', 'gentium' ),
        'priority'   => 2,
        'panel' => 'theme_settings',
        'section'     => 'section_site_header',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'image',
        'settings'    => 'mobile_logo_img',
        'label'       => esc_html__( 'Mobile Logo Image', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => '',
        'priority'    => 1,
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'mobile_logo_img_max_width',
        'label'       		=> esc_html__( 'mobile Logo Max Width Value', 'gentium' ),
        'section'     		=> 'mobile_header_options',
        'default'     		=> 120,
        'priority'          => 4,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '500',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.mobile-logo, .page-mobile-menu-logo >a',
                'property' 		=> 'max-width',
                'units'    		=> 'px',
            ),            
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'mobile_logo_heading_tag',
        'label'       => esc_html__( 'Mobile Logo Heading Html Tag', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => 'h2',
        'priority'    => 5,
        'choices'     => array(
            'h1'  => esc_html__( 'H1', 'gentium' ),
            'h2'    => esc_html__( 'H2', 'gentium' ),
            'h3'    => esc_html__( 'H3', 'gentium' ),
            'h4'    => esc_html__( 'H4', 'gentium' ),
            'h5'    => esc_html__( 'H5', 'gentium' ),
            'div'    => esc_html__( 'div', 'gentium' ),
            'span'    => esc_html__( 'span', 'gentium' ),
            'p'    => esc_html__( 'P', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'mobile_logo_heading_font_size',
        'label'       		=> esc_html__( 'Mobile Logo Font Size', 'gentium' ),
        'section'           => 'mobile_header_options',
        'default'     		=> 22,
        'priority'          => 6,
        'choices'     		=> array(
            'min'  => '10',
            'max'  => '40',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.mobile-logo .site-title a',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'mobile_bg_color',
        'description' => esc_html__('Choose a Background color for the Mobile Header.' , 'gentium'),
        'label'       => esc_html__( 'Mobile Header Background Color', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => '#ffffff',
        'priority'    => 2,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => '#mobile-header',
                'property' => 'background-color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'mobile_icon_color',
        'label'       => esc_html__( 'Mobile Header Elements Color', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => '#101010',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element'  => array('#mobile-header .toggle-icon i','.mobile-logo .site-title a'),
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'mobile_nav_bg_color',
        'description' => esc_html__('Choose a Background color for the Mobile Navigation.' , 'gentium'),
        'label'       => esc_html__( 'Off Canvas Background Color', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => '#000000',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    '.uk-offcanvas-bar',
                ),
                'property' => 'background-color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'mobile_nav_link_color',
        'description' => esc_html__('Choose a color for the link text color.' , 'gentium'),
        'label'       => esc_html__( 'Mobile Navigation Primary Color', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => '#ffffff',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    '.pr__mobile__nav .menu ul li a', 
                    '.pr__mobile__nav .ul-menu li.menu-item-has-children>a:after',
                    'button.uk-offcanvas-close.uk-close.uk-icon'
                ),
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'mobile_nav_linkh_color',
        'description' => esc_html__('Choose a Menu hover link text color.' , 'gentium'),
        'section'     => 'mobile_header_options',
        'default'     => '#e9204f',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    '.pr__mobile__nav .menu ul li a:hover', 
                    '.pr__mobile__nav .menu ul li a:focus',
                ),
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'sticky_mobile_header_on',
        'label'       => esc_html__( 'Sticky Mobile Header', 'gentium' ),
        'description' => esc_html__('Enable Sticky Mobile Header' , 'gentium'),
        'section'     => 'mobile_header_options',
        'default'     => '0',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_html__( 'Enable', 'gentium' ),
            'off' => esc_html__( 'Disable', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'number',
        'settings'    => 'stm_header_offset',
        'label'       => esc_html__( 'Sticky Mobile Header Offset', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => '30',
        'priority'    => 10,
        'active_callback' => array(
            array(
                'setting'  => 'sticky_mobile_header_on',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ) );


    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'stm_header_animation',
        'label'       => esc_html__( 'Sticky Header Animation', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => 'uk-animation-fade',
        'priority'    => 10,
        'choices'     => array(
            'uk-animation-fade'          => esc_html__( 'Fade', 'gentium' ),
            'uk-animation-slide-top'     => esc_html__( 'Slide Top', 'gentium' ),
            'uk-animation-slide-bottom'  => esc_html__( 'Slide Bottom', 'gentium' ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'sticky_mobile_header_on',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'stm_header_on_scroll_up',
        'label'       => esc_html__( 'Show Sticky Mobile Header On Scroll up', 'gentium' ),
        'section'     => 'mobile_header_options',
        'default'     => '0',
        'priority'    => 10,
        'choices'     => array(
            'on'   => esc_html__( 'On', 'gentium' ),
            'off' => esc_html__( 'Off', 'gentium' ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'sticky_mobile_header_on',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    /*--------------------------------------------------------------*/
    /*  Section -- Section Preloader
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'section_preloader_options', array(
        'title'      => esc_html__( 'Preloader', 'gentium' ),
        'priority'   => 3,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'show_preloader',
        'label'       => esc_html__( 'Show / Hide The Preloader', 'gentium' ),
        'section'     => 'section_preloader_options',
        'default'     => '1',
        'priority'    => 1,
        'choices'     => array(
            'on'   => esc_html__( 'Show', 'gentium' ),
            'off' => esc_html__( 'Hide', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'text',
        'settings'    => 'preloader_loading_text',
        'label'       => esc_html__( 'Prealder Loading Text', 'gentium' ),
        'section'     => 'section_preloader_options',
        'default'     => esc_html__( 'Loading', 'gentium' ),
        'priority'    => 2,
        'sanitize_callback' => 'wp_kses_post',
        'active_callback'    => array(
            array(
                'setting'  => 'show_preloader',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'preloader_bg',
        'description' => esc_html__('Choose Preloader Overlay Background color.' , 'gentium'),
        'label'       => esc_html__( 'Preloader Overlay Background Color', 'gentium' ),
        'section'     => 'section_preloader_options',
        'default'     => '#101010',
        'priority'    => 3,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => 'body #loader.pr__dark',
                'property' => 'background',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_preloader',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'preloader_title_color',
        'description' => esc_html__('Choose a color for the Preloader Title Text.' , 'gentium'),
        'label'       => esc_html__( 'Preloader Title Text Color', 'gentium' ),
        'section'     => 'section_preloader_options',
        'default'     => '#ACACAC',
        'priority'    => 4,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    'body #loader .loading', 
                ),
                'property' => 'color',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_preloader',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
        
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'preloader_pb_color',
        'description' => esc_html__('Choose a Background color for the Progress Bar.' , 'gentium'),
        'label'       => esc_html__( 'Preloader Progress Bar Background Color', 'gentium' ),
        'section'     => 'section_preloader_options',
        'default'     => 'rgba(255, 255, 255, 0.2);',
        'priority'    => 4,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    'body #loader.pr__dark .progress', 
                ),
                'property' => 'background',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_preloader',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
        
    ));

    /*--------------------------------------------------------------*/
    /*  Section -- Section Title settings
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'section_title_options', array(
        'title'      => esc_html__( 'Page Title', 'gentium' ),
        'priority'   => 3,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'show_section_title',
        'label'       => esc_html__( 'Show / Hide Section Title', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '1',
        'priority'    => 1,
        'choices'     => array(
            'on'   => esc_html__( 'Show', 'gentium' ),
            'off' => esc_html__( 'Hide', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'radio',
        'settings'    => 'aling_titles',
        'label'       => esc_html__( 'Alignment', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => 'center',
        'priority'    => 2,
        'choices'     => array(
            'left'   => esc_html__( 'Left', 'gentium' ),
            'center'   => esc_html__( 'Center', 'gentium' ),
            'right' => esc_html__( 'Right', 'gentium' ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'heading_bg',
        'description' => esc_html__('Choose Heading Background color.' , 'gentium'),
        'label'       => esc_html__( 'Heading Background Color', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '#ffffff',
        'priority'    => 3,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => '.section-title.thumbnail-bg::before',
                'property' => 'background-color',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'image',
        'settings'    => 'heading_img',
        'description' => esc_html__('Default background image for heading title.' , 'gentium'),
        'label'       => esc_html__( 'Default Heading Background', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '',
        'priority'    => 4,
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'heading_padding_top_size',
        'label'       		=> esc_html__( 'Heading Title Padding Top', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     		=> 80,
        'priority'          => 5,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '200',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.section-title.thumbnail-bg',
                'property' 		=> 'padding-top',
                'units'    		=> 'px',
            ),            
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'heading_padding_bottom_size',
        'label'       		=> esc_html__( 'Heading Title Padding Bottom', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     		=> 80,
        'priority'          => 5,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '200',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.section-title.thumbnail-bg',
                'property' 		=> 'padding-bottom',
                'units'    		=> 'px',
            ),            
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'section_title_color',
        'description' => esc_html__('Choose a color for the Page Title Text.' , 'gentium'),
        'label'       => esc_html__( 'Page Title Text Color', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '#101010',
        'priority'    => 6,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    '.section-title .entry-title', 
                ),
                'property' => 'color',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
        
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'section_title_spacing',
        'label'       		=> esc_html__( 'Title Vertical Spacing', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     		=> 15,
        'priority'          => 6,
        'choices'     		=> array(
            'min'  => '1',
            'max'  => '200',
            'step' => '5',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.section-title .entry-title',
                'property' 		=> 'margin-bottom',
                'units'    		=> 'px',
            ),            
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'typography',
        'settings'    => 'heading_font',
        'label'       => esc_html__( 'Title', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     => array(
            'font-family'    => 'Poppins',
            'variant'        => '700',
            'font-size'      => '42px',
            'line-height'    => '1.5',
            'text-transform' => 'none',
            'letter-spacing' => '0',
        ),
        'transport'   => 'auto',
        'priority'    => 7,
        'output'      => array(
            array(
                'element' => '.section-title .entry-title',
                ),
            ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ) );

    // SHOW / HIDE HR DIVIDER

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'show_hr_divider',
        'label'       => esc_html__( 'Show Divider', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '0',
        'priority'    => 8,
        'choices'     => array(
            'on'   => esc_html__( 'Show', 'gentium' ),
            'off' => esc_html__( 'Hide', 'gentium' ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'page_title_hr_color',
        'label'       => esc_html__( 'Divider Color', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '#e9204f',
        'priority'    => 9,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    'hr.pr-page-title-hr'
                ),
                'property' => 'background-color',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_hr_divider',
                'operator' => '==',
                'value'    => '1',
            ),
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
        
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'page_title_hr_width',
        'label'       		=> esc_html__( 'Divider Width', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     		=> 80,
        'priority'          => 10,
        'choices'     		=> array(
            'min'  => '10',
            'max'  => '600',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'hr.pr-page-title-hr',
                'property' 		=> 'width',
                'units'    		=> 'px',
            ),            
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_hr_divider',
                'operator' => '==',
                'value'    => '1',
            ),
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'page_title_hr_height',
        'label'       		=> esc_html__( 'Divider Height', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     		=> 2,
        'priority'          => 11,
        'choices'     		=> array(
            'min'  => '1',
            'max'  => '20',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'hr.pr-page-title-hr',
                'property' 		=> 'height',
                'units'    		=> 'px',
            ),            
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_hr_divider',
                'operator' => '==',
                'value'    => '1',
            ),
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'page_title_hr_spacing',
        'label'       		=> esc_html__( 'Vertical Spacing', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     		=> 2,
        'priority'          => 11,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '200',
            'step' => '5',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'hr.pr-page-title-hr',
                'property' 		=> 'margin-bottom',
                'units'    		=> 'px',
            ),            
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_hr_divider',
                'operator' => '==',
                'value'    => '1',
            ),
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),				
    ));

    // SHOW / HIDE BREADCRUMBS

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'switch',
        'settings'    => 'show_breadcrumbs',
        'label'       => esc_html__( 'Show Breadcrumbs', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '0',
        'priority'    => 12,
        'choices'     => array(
            'on'   => esc_html__( 'Show', 'gentium' ),
            'off' => esc_html__( 'Hide', 'gentium' ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'breadcrumbs_link_color',
        'label'       => esc_html__( 'breadcrumbs Link Color', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '#e9204f',
        'priority'    => 13,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    '.breadcrumbs > span', '.breadcrumbs > span > a'
                ),
                'property' => 'color',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_breadcrumbs',
                'operator' => '==',
                'value'    => '1',
            ),
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
        
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'breadcrumbs_color',
        'label'       => esc_html__( 'breadcrumbs Text Color', 'gentium' ),
        'section'     => 'section_title_options',
        'default'     => '#e9204f',
        'priority'    => 14,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(
                    '.breadcrumbs > span', '.breadcrumbs > span',
                    'span.breadcrumbs__separator:before'
                ),
                'property' => 'color',
            ),
        ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_breadcrumbs',
                'operator' => '==',
                'value'    => '1',
            ),
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
        
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'typography',
        'settings'    => 'breadcrumbs_font',
        'label'       => esc_html__( 'Breadcrumbs Typography', 'gentium' ),
        'section'     		=> 'section_title_options',
        'default'     => array(
            'font-family'    => 'Poppins',
            'variant'        => '500',
            'font-size'      => '15px',
            'line-height'    => '1.5',
            'text-transform' => 'none',
            'letter-spacing' => '0',
        ),
        'transport'   => 'auto',
        'priority'    => 15,
        'output'      => array(
            array(
                'element' =>  array(
                    '.breadcrumbs ', '.breadcrumbs a'
            ),),
            ),
        'active_callback'    => array(
            array(
                'setting'  => 'show_breadcrumbs',
                'operator' => '==',
                'value'    => '1',
            ),
            array(
                'setting'  => 'show_section_title',
                'operator' => '==',
                'value'    => '1',
            ),
        ),
    ) );

    /*--------------------------------------------------------------*/
    /*  Section -- Typography settings
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'typography_options', array(
        'title'      => esc_html__( 'Typography', 'gentium' ),
        'priority'   => 4,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'typography',
        'settings'  => 'body_font',
        'label'     => esc_html__( 'Body Font', 'gentium' ),
        'section'   => 'typography_options',
        'default'     => array(
            'font-family'    => 'Poppins',
            'variant'        => 'regular',
            'font-size'      => '14px',
            'line-height'    => '1.5',
        ),
        'priority'    => 1,
        'output'      => array(
            array(
                'element' => array(
                    'body','input', 'select', 'textarea',
                ),
            ),
        ),
    ) );

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'typography',
        'settings'  => 'headings_font',
        'label'     => esc_html__( 'Heading Font', 'gentium' ),
        'section'   => 'typography_options',
        'default'     => array(
            'font-family'    => 'Poppins',
            'variant'        => '600',
            'letter-spacing' => '0',
        ),
        'priority'    => 2,
        'output'      => array(
            array(
                'element' => array(
                    'h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.read-more a',
                    '.single-post-heade-content .entry-title','blockquote>p'
                ),
            ),
        ),
    ) );

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'h1_font_size',
        'label'       		=> esc_html__( 'H1 Font Size', 'gentium' ),
        'section'     		=> 'typography_options',
        'default'     		=> 42,
        'choices'     		=> array(
            'min'  => '5',
            'max'  => '100',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'h1',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),			
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'h2_font_size',
        'label'       		=> esc_html__( 'H2 Font Size', 'gentium' ),
        'section'     		=> 'typography_options',
        'default'     		=> 28,
        'choices'     		=> array(
            'min'  => '5',
            'max'  => '100',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'h2',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),			
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'h3_font_size',
        'label'       		=> esc_html__( 'H3 Font Size', 'gentium' ),
        'section'     		=> 'typography_options',
        'default'     		=> 22,
        'choices'     		=> array(
            'min'  => '5',
            'max'  => '100',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'h3',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),			
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'h4_font_size',
        'label'       		=> esc_html__( 'H4 Font Size', 'gentium' ),
        'section'     		=> 'typography_options',
        'default'     		=> 18,
        'choices'     		=> array(
            'min'  => '5',
            'max'  => '100',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'h4',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),			
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'h5_font_size',
        'label'       		=> esc_html__( 'H5 Font Size', 'gentium' ),
        'section'     		=> 'typography_options',
        'default'     		=> 14,
        'choices'     		=> array(
            'min'  => '5',
            'max'  => '100',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'h5',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),			
    ));
    
    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'h6_font_size',
        'label'       		=> esc_html__( 'H6 Font Size', 'gentium' ),
        'section'     		=> 'typography_options',
        'default'     		=> 12,
        'choices'     		=> array(
            'min'  => '5',
            'max'  => '100',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> 'h6',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),			
    ));

    /*--------------------------------------------------------------*/
    /*  Section --  Blog settings
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'blog_section', array(
        'title'      => esc_html__( 'Blog', 'gentium' ),
        'priority'   => 5,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'custom',
        'settings'    => 'layout_collapsible_tiles',
        'section'     => 'blog_section',
        'priority'    => 10,
    ) );

    /*--------------------------------------------------------------*/
    /*  Section -- Blog Posts
    /*--------------------------------------------------------------*/

    pixe_Kirki::add_section( 'blog_posts_options', array(
        'title'      => esc_html__( 'Blog Posts', 'gentium' ),
        'priority'   => 1,
        'panel' => 'theme_settings',
        'section'     => 'blog_section',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'blog_listing_style',
        'label'       => esc_html__( 'Blog Style', 'gentium' ),
        'section'     => 'blog_posts_options',
        'default'     => 'grid',
        'priority'    => 1,
        'choices'     => array(
            'grid'  => esc_html__( 'Grid', 'gentium' ),
            'chess'    => esc_html__( 'Chess', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'blog_heading_tag',
        'label'       => esc_html__( 'Heading Html Tag', 'gentium' ),
        'section'     => 'blog_posts_options',
        'default'     => 'h2',
        'priority'    => 1,
        'choices'     => array(
            'h1'  => esc_html__( 'H1', 'gentium' ),
            'h2'    => esc_html__( 'H2', 'gentium' ),
            'h3'    => esc_html__( 'H3', 'gentium' ),
            'h4'    => esc_html__( 'H4', 'gentium' ),
            'h5'    => esc_html__( 'H5', 'gentium' ),
            'div'    => esc_html__( 'div', 'gentium' ),
            'span'    => esc_html__( 'span', 'gentium' ),
            'p'    => esc_html__( 'P', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'blog_heading_font_size',
        'label'       		=> esc_html__( 'Title Font Size', 'gentium' ),
        'section'           => 'blog_posts_options',
        'default'     		=> 22,
        'priority'          => 1,
        'choices'     		=> array(
            'min'  => '10',
            'max'  => '40',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.blog-entry-title.entry-title',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'blog_pagination_type',
        'label'       => esc_html__( 'Pagination Type', 'gentium' ),
        'section'     => 'blog_posts_options',
        'default'     => 'numric',
        'priority'    => 1,
        'choices'     => array(
            'numric'  => esc_html__( 'Numric', 'gentium' ),
            'load'    => esc_html__( 'Load More', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'number',
        'settings'    => 'post_excerpt_length',
        'label'       => esc_html__( 'Excerpt Length', 'gentium' ),
        'section'     => 'blog_posts_options',
        'default'     => '30',
        'priority'    => 3,
    ) );

    /*--------------------------------------------------------------*/
    /*  Section -- Single Post
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'single_post_options', array(
        'title'      => esc_html__( 'Single Post', 'gentium' ),
        'priority'   => 1,
        'panel' => 'theme_settings',
        'section'     => 'blog_section',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'single_heading_overlay_bg',
        'description' => esc_html__('Choose Overlay Background color.' , 'gentium'),
        'label'       => esc_html__( 'Overlay Color', 'gentium' ),
        'section'     => 'single_post_options',
        'default'     => 'rgba(0, 0, 0, 0.5)',
        'priority'    => 3,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => '.pixe-single-post-header-full:before',
                'property' => 'background',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'single_heading_padding_top',
        'label'       		=> esc_html__( 'Single Post Title Padding Top', 'gentium' ),
        'section'     		=> 'single_post_options',
        'default'     		=> 80,
        'priority'          => 5,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '300',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.pixe-single-post-header-full',
                'property' 		=> 'padding-top',
                'units'    		=> 'px',
            ),            
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'single_heading_padding_bot',
        'label'       		=> esc_html__( 'Single Post Title Padding Bottom', 'gentium' ),
        'section'     		=> 'single_post_options',
        'default'     		=> 80,
        'priority'          => 5,
        'choices'     		=> array(
            'min'  => '40',
            'max'  => '300',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.pixe-single-post-header-full',
                'property' 		=> 'padding-bottom',
                'units'    		=> 'px',
            ),            
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'single_heading_tag',
        'label'       => esc_html__( 'Single Heading Html Tag', 'gentium' ),
        'section'     => 'single_post_options',
        'default'     => 'h1',
        'priority'    => 5,
        'choices'     => array(
            'h1'  => esc_html__( 'H1', 'gentium' ),
            'h2'    => esc_html__( 'H2', 'gentium' ),
            'h3'    => esc_html__( 'H3', 'gentium' ),
            'h4'    => esc_html__( 'H4', 'gentium' ),
            'h5'    => esc_html__( 'H5', 'gentium' ),
            'div'    => esc_html__( 'div', 'gentium' ),
            'span'    => esc_html__( 'span', 'gentium' ),
            'p'    => esc_html__( 'P', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'single_heading_color',
        'label'       => esc_html__( 'Post Title Color', 'gentium' ),
        'section'     => 'single_post_options',
        'default'     => '#ffffff',
        'priority'    => 5,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => '.single-post-heade-content .entry-title',
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'single_heading_font_size',
        'label'       		=> esc_html__( 'Title Font Size', 'gentium' ),
        'section'     		=> 'single_post_options',
        'default'     		=> 50,
        'priority'          => 5,
        'choices'     		=> array(
            'min'  => '30',
            'max'  => '80',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.single-post-heade-content .entry-title',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),				
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'single_cat_color',
        'label'       => esc_html__( 'Category Color', 'gentium' ),
        'section'     => 'single_post_options',
        'default'     => '#ffffff',
        'priority'    => 5,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => array(  '.single-post-heade-content .category a','.single-post-heade-content .category'),
                'property' => 'color',
            ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'single_cat_font_size',
        'label'       		=> esc_html__( 'Category Font Size', 'gentium' ),
        'section'     		=> 'single_post_options',
        'default'     		=> 14,
        'priority'          => 5,
        'choices'     		=> array(
            'min'  => '10',
            'max'  => '30',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.single-post-heade-content .category a',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),            
        ),				
    ));
    

    /*--------------------------------------------------------------*/
    /*  Section -- Footer settings
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'footer_section', array(
        'title'      => esc_html__( 'Footer', 'gentium' ),
        'priority'   => 6,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'footer_layout_type',
        'label'       => esc_html__( 'Footer Layout', 'gentium' ),
        'section'     => 'footer_section',
        'default'     => 'footer-1',
        'priority'    => 10,
        'choices'     => array(
            'footer-1'  => esc_html__( 'Footer 1', 'gentium' ),
            'custom'    => esc_html__( 'custom', 'gentium' ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'select',
        'settings'    => 'select_footer_template',
        'label'	   	  => esc_html__( 'Select Template', 'gentium' ),
		'description' => esc_html__( 'Choose a template created in Theme Templates.', 'gentium' ),
        'section'     => 'footer_section',
        'default'     => 'option-1',
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => Kirki_Helper::get_posts( array( 'post_type' => 'pixe_templates' ) ),
        'active_callback' => array(
            array(
                'setting'  => 'footer_layout_type',
                'operator' => '==',
                'value'    => 'custom',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'footer_copy_bg_color',
        'label'       => esc_html__( 'Footer Copyright Background Color', 'gentium' ),
        'section'     => 'footer_section',
        'default'     => '#ffffff',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => '.footer-copyrights',
                'property' => 'background-color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'footer_layout_type',
                'operator' => '==',
                'value'    => 'footer-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'footer_copy_border_color',
        'label'       => esc_html__( 'Footer Copyright Border Color', 'gentium' ),
        'section'     => 'footer_section',
        'default'     => '#eee',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => '.footer-copyrights',
                'property' => 'border-top-color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'footer_layout_type',
                'operator' => '==',
                'value'    => 'footer-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'color-alpha',
        'settings'    => 'footer_copy_color',
        'label'       => esc_html__( 'Footer Copyright text Color', 'gentium' ),
        'section'     => 'footer_section',
        'default'     => '#818181',
        'priority'    => 10,
        'transport' => 'auto',
        'output' => array(
            array(
                'element' => '.footer-copyrights',
                'property' => 'color',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'footer_layout_type',
                'operator' => '==',
                'value'    => 'footer-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        		=> 'slider',
        'settings'    		=> 'copy_font_size',
        'label'       		=> esc_html__( 'Copyright text Font Size', 'gentium' ),
        'section'           => 'footer_section',
        'default'     		=> 12,
        'priority'          => 10,
        'choices'     		=> array(
            'min'  => '10',
            'max'  => '30',
            'step' => '1',
        ),
        'transport'   		=> 'auto',
        'output'      		=> array(
            array(
                'element'  		=> '.footer-copyrights',
                'property' 		=> 'font-size',
                'units'    		=> 'px',
            ),
        ),
        'active_callback' => array(
            array(
                'setting'  => 'footer_layout_type',
                'operator' => '==',
                'value'    => 'footer-1',
                ),
        ),
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'        => 'textarea',
        'settings'    => 'footer_copy_text',
        'label'       => esc_html__( 'Footer Copyright Text', 'gentium' ),
        'section'     => 'footer_section',
        'default'     => get_bloginfo( 'description' ),
        'priority'    => 10,
        'sanitize_callback' => 'wp_kses_post',
        'active_callback' => array(
            array(
                'setting'  => 'footer_layout_type',
                'operator' => '==',
                'value'    => 'footer-1',
                ),
        ),
    ));

    /*--------------------------------------------------------------*/
    /*  Section --  Aditonal Scripts
    /*--------------------------------------------------------------*/
    pixe_Kirki::add_section( 'additional_scripts', array(
        'title'      => esc_html__( 'Additional Scripts', 'gentium' ),
        'priority'   => 7,
        'panel' => 'theme_settings',
        'capability' => 'edit_theme_options',
    ));

    pixe_Kirki::add_field( 'gentium', array(
        'type'     => 'textarea',
        'settings' => 'custom_scripts',
        'label'    => esc_html__( 'Custom Scripts', 'gentium' ),
        'description' => esc_html__('Enter in any custom script to include in your sites. Be sure to use double quotes for strings.', 'gentium'),
        'section'  => 'additional_scripts',
        'priority' => 10,
    ) );
}
