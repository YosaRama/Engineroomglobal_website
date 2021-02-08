<?php

namespace Elementor;

if( !defined( 'ABSPATH' ) ) exit;

class PR_Image_Gallery_Widget extends Widget_Base {
    
    public function get_name(){
        return 'pr-img-gallery';
    }
    
    public function get_title(){
        return esc_html__('Image Grid','pixerex');
    }
    
    public function get_icon(){
        return 'eicon-gallery-grid';
    }
    
    public function get_script_depends(){
        return ['pr-js','uikit','isotope-js'];
    }
    
    public function is_reload_preview_required(){
        return true;
    }
    
    public function get_categories(){
        return ['pr-elements'];
    }
    
    protected function _register_controls(){
        
        $this->start_controls_section('pr_portfolio_cats',
            [
                'label'     => esc_html__('Categories','pixerex'),
            ]);

            $repeater = new REPEATER();
        
            $repeater->add_control( 'pr_portfolio_img_cat', 
                [
                    'label'     => esc_html__( 'Category', 'pixerex' ),
                    'type'      => Controls_Manager::TEXT,
                ]
            );
            
            $this->add_control('pr_portfolio_cats_content',
               [
                   'label' => __( 'Categories', 'pixerex' ),
                   'type' => Controls_Manager::REPEATER,
                   'default' => [
                       [
                           'pr_portfolio_img_cat'   => 'Category 1',
                       ],
                       [
                           'pr_portfolio_img_cat'   => 'Category 2',
                       ],
                   ],
                   'fields' => array_values( $repeater->get_controls() ) ,
                   'title_field'   => '{{{ pr_portfolio_img_cat }}}',
               ]
           );    
        
    //     $this->add_control('pr_portfolio_cats_content',
    //        [
    //            'label' => __( 'Categories', 'pixerex' ),
    //            'type' => Controls_Manager::REPEATER,
    //            'default' => [
    //                [
    //                    'pr_portfolio_img_cat'   => 'Category 1',
    //                ],
    //                [
    //                    'pr_portfolio_img_cat'   => 'Category 2',
    //                ],
    //            ],
    //            'fields' => [
    //                [
    //                    'name' => 'pr_portfolio_img_cat',
    //                    'label' => esc_html__( 'Category', 'pixerex' ),
    //                    'type' => Controls_Manager::TEXT,
    //                ],
    //            ],
    //            'title_field'   => '{{{ pr_portfolio_img_cat }}}',
    //        ]
    //    );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_portfolio_content',
            [
                'label'     => esc_html__('Images','pixerex'),
            ]);
        
            $img_repeater = new REPEATER();
        
            $img_repeater->add_control('pr_portfolio_img', 
                [
                    'label' => esc_html__( 'Upload Image', 'pixerex' ),
                    'type' => Controls_Manager::MEDIA,
                    'default'       => [
                    'url'	=> Utils::get_placeholder_image_src(),
                    ],
                ]);
            
            $img_repeater->add_control('pr_portfolio_img_name', 
                [
                    'label' => esc_html__( 'Name', 'pixerex' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'label_block'   => true,
                ]);
            
            $img_repeater->add_control('pr_portfolio_img_desc', 
                [
                    'label' => esc_html__( 'Description', 'pixerex' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]);
            
            $img_repeater->add_control('pr_portfolio_img_category', 
                [
                    'label' => esc_html__( 'Category', 'pixerex' ),
                    'type' => Controls_Manager::TEXT,
                ]);
            
            $img_repeater->add_control('pr_portfolio_img_link', 
                [
            
                'label'         => esc_html__('Link', 'pixerex'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
            
                ]);
            
            
            $this->add_control('pr_portfolio_img_content',
               [
                   'label' => __( 'Images', 'pixerex' ),
                   'type' => Controls_Manager::REPEATER,
                   'default' => [
                       [
                           'pr_portfolio_img_name'   => 'Image #1',
                           'pr_portfolio_img_category'   => 'Category 1',
                       ],
                       [
                        'pr_portfolio_img_name'   => 'Image #2',
                        'pr_portfolio_img_category'   => 'Category 2',
                       ],
                   ],
                   'fields' => array_values( $img_repeater->get_controls() ),
                   'title_field'   => '{{{ pr_portfolio_img_name }}}',
               ]
            );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_portfolio_grid_settings',
            [
                'label'     => esc_html__('Grid Settings','pixerex'),
                
            ]);
        
        $this->add_responsive_control('pr_portfolio_column_number',
			[
  				'label'                 => esc_html__( 'Columns', 'pixerex' ),
				'label_block'           => true,
				'type'                  => Controls_Manager::SELECT,				
				'desktop_default'       => '50%',
				'tablet_default'        => '100%',
				'mobile_default'        => '100%',
				'options'               => [
					'100%'      => esc_html__( '1', 'pixerex' ),
					'50%'       => esc_html__( '2', 'pixerex' ),
					'33.330%'   => esc_html__( '3', 'pixerex' ),
					'25%'       => esc_html__( '4', 'pixerex' ),
					'20%'       => esc_html__( '5', 'pixerex' ),
					'16.66%'    => esc_html__( '6', 'pixerex' ),
				],
				'selectors' => [
					'{{WRAPPER}} .pr-portfolio-container .pr-portfolio-item' => 'width: {{VALUE}};',
				],
				'render_type' => 'template'
			]
		);
        
        $this->add_control('pr_portfolio_img_size_select',
                [
                    'label'             => esc_html__('Grid Layout', 'pixerex'),
                    'type'              => Controls_Manager::SELECT,
                    'options'           => [
                        'one_size'  => esc_html__('Even', 'pixerex'),
                        'original'  => esc_html__('Masonry', 'pixerex'),
                    ],
                    'default'           => 'one_size',
                    ]
                );
        
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'thumbnail', // Actually its `image_size`.
				'default'               => 'full',
                'condition'             => [
                    'pr_portfolio_img_size_select'   => 'one_size'
                ]
			]
		);
        
        $this->add_responsive_control('pr_portfolio_gap',
                [
                    'label'         => esc_html__('Image Gap', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', "em"],
                    'range'         => [
                        'px'    => [
                            'min'   => 1, 
                            'max'   => 200,
                            ],
                        ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-item' => 'padding: {{SIZE}}{{UNIT}};'
                      ]
                    ]
                );
        
        $this->add_control('pr_portfolio_img_effect',
                [
                    'label'         => esc_html__('Hover Effect', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'description'   => esc_html__('Choose a hover effect for the image','pixerex'),
                    'options'       => [
                        'none'          => esc_html__('None', 'pixerex'),
                        'zoomin'        => esc_html__('Zoom In', 'pixerex'),
                        'zoomout'       => esc_html__('Zoom Out', 'pixerex'),
                        'scale'         => esc_html__('Scale', 'pixerex'),
                        'gray'          => esc_html__('Grayscale', 'pixerex'),
                        'blur'          => esc_html__('Blur', 'pixerex'),
                    ],
                    'default'       => 'zoomin',
                    'label_block'   => true
                ]
                );
        
        $this->add_control('pr_portfolio_filter',
                [
                    'label'         => esc_html__( 'Filter', 'pixerex' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes'
                ]
                );
        
        $this->add_control('pr_portfolio_light_box',
                [
                    'label'         => esc_html__( 'Lightbox', 'pixerex' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes'
                ]
                );
        
        $this->add_responsive_control('pr_portfolio_content_align',
                [
                    'label'         => esc_html__( 'Content Alignment', 'pixerex' ),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'left'      => [
                            'title'=> esc_html__( 'Left', 'pixerex' ),
                            'icon' => 'fa fa-align-left',
                            ],
                        'center'    => [
                            'title'=> esc_html__( 'Center', 'pixerex' ),
                            'icon' => 'fa fa-align-center',
                            ],
                        'right'     => [
                            'title'=> esc_html__( 'Right', 'pixerex' ),
                            'icon' => 'fa fa-align-right',
                            ],
                        ],
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-caption' => 'text-align: {{VALUE}};',
                        ],
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_portfolio_responsive_section',
            [
                'label'         => esc_html__('Responsive', 'pixerex'),
            ]);
        
        $this->add_control('pr_portfolio_responsive_switcher',
            [
                'label'         => esc_html__('Responsive Controls', 'pixerex'),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => esc_html__('If the content text is not suiting well on specific screen sizes, you may enable this option which will hide the description text.', 'pixerex')
            ]);
        
        $this->add_control('pr_portfolio_min_range', 
            [
                'label'     => esc_html__('Minimum Size', 'pixerex'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> esc_html__('Note: minimum size for extra small screens is 1px.','pixerex'),
                'default'   => 1,
                'condition' => [
                    'pr_portfolio_responsive_switcher'    => 'yes'
                ],
            ]);

        $this->add_control('pr_portfolio_max_range', 
            [
                'label'     => esc_html__('Maximum Size', 'pixerex'),
                'type'      => Controls_Manager::NUMBER,
                'description'=> esc_html__('Note: maximum size for extra small screens is 767px.','pixerex'),
                'default'   => 767,
                'condition' => [
                    'pr_portfolio_responsive_switcher'    => 'yes'
                ],
            ]);

		$this->end_controls_section();
        
        $this->start_controls_section('pr_portfolio_img_style_section',
            [
                'label'     => esc_html__('Image','pixerex'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]);

        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_portfolio_general_background',
                    'types'             => [ 'classic', 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-portfolio-image.style2 .pr-portfolio-icons-caption-container',
                ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'              => 'pr_portfolio_img_border',
                    'selector'          => '{{WRAPPER}} .pr-portfolio-image-container',
                    ]
                );
        
        /*First Border Radius*/
        $this->add_control('pr_portfolio_img_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-image-container, .pr-portfolio-icons-caption-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'             => esc_html__('Shadow','pixerex'),
                'name'              => 'pr_portfolio_img_box_shadow',
                'selector'          => '{{WRAPPER}} .pr-portfolio-image-container',
            ]
            );
        
        /*First Margin*/
        $this->add_responsive_control('pr_portfolio_img_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-image-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        /*First Padding*/
        $this->add_responsive_control('pr_portfolio_img_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-image-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_portfolio_content_style',
            [
                'label'     => esc_html__('Content','pixerex'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]);
        
        $this->add_control('pr_portfolio_title_heading',
                [
                    'label'         => esc_html__('Title', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        $this->add_control('pr_portfolio_title_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-img-name' => 'color: {{VALUE}};',
                    ]
                ]
                );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'pr_portfolio_title_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-portfolio-img-name',
                    ]
                );

        $this->add_responsive_control('pr_portfolio_title_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-img-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->add_responsive_control('pr_portfolio_title_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-img-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->add_control('pr_portfolio_description_heading',
                [
                    'label'         => esc_html__('Description', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                    'separator'     => 'before',
                ]
                );
        
        $this->add_control('pr_portfolio_description_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_3,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-img-desc' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'pr_portfolio_description_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-portfolio-img-desc',
                    ]
                );
        $this->add_responsive_control('pr_portfolio_description_margin',
        [
            'label'         => esc_html__('Margin', 'pixerex'),
            'type'          => Controls_Manager::DIMENSIONS,
            'size_units'    => [ 'px', 'em', '%' ],
            'selectors'     => [
                '{{WRAPPER}} .pr-portfolio-img-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );
        
        $this->add_responsive_control('pr_portfolio_description_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-img-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_portfolio_icons_style',
            [
                'label'     => esc_html__('Icons','pixerex'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]);
        
        $this->start_controls_tabs('pr_portfolio_icons_style_tabs');
        
        $this->start_controls_tab('pr_portfolio_icons_style_normal',
                [
                    'label'         => esc_html__('Normal', 'pixerex'),
                ]
                );
        
        $this->add_control('pr_portfolio_icons_style_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item i, {{WRAPPER}} .pr-portfolio-image-link i' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_control('pr_portfolio_icons_style_background',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item span, {{WRAPPER}} .pr-portfolio-image-link span' => 'background-color: {{VALUE}};',
                    ]
                ]
                );
        
        /*Icon Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_portfolio_icons_style_border',
                    'selector'      => '{{WRAPPER}} .pr-uk-img-lightbox-item span, {{WRAPPER}} .pr-portfolio-image-link span',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pr_portfolio_icons_style_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item span, {{WRAPPER}} .pr-portfolio-image-link span' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Shadow','pixerex'),
                    'name'          => 'pr_portfolio_icons_style_shadow',
                    'selector'      => '{{WRAPPER}} .pr-uk-img-lightbox-item span, {{WRAPPER}} .pr-portfolio-image-link span',
                ]
                );
        
        /*Button Margin*/
        $this->add_responsive_control('pr_portfolio_icons_style_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item span, {{WRAPPER}} .pr-portfolio-image-link span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Button Padding*/
        $this->add_responsive_control('pr_portfolio_icons_style_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item span, {{WRAPPER}} .pr-portfolio-image-link span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();

        $this->start_controls_tab('pr_portfolio_icons_style_hover',
        [
            'label'         => esc_html__('Hover', 'pixerex'),
        ]
        );
        
        $this->add_control('pr_portfolio_icons_style_overlay',
                [
                    'label'         => esc_html__('Overlay Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-image.default:hover .pr-portfolio-icons-wrapper, {{WRAPPER}} .pr-portfolio-image:hover .pr-portfolio-icons-caption-container,{{WRAPPER}} .pr-portfolio-image.style1:hover .pr-portfolio-icons-wrapper' => 'background-color: {{VALUE}};',
                    ],
                ]
                );
        
        $this->add_control('pr_portfolio_icons_style_color_hover',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item:hover i, {{WRAPPER}} .pr-portfolio-image-link:hover i' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_control('pr_portfolio_icons_style_background_hover',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item:hover span, {{WRAPPER}} .pr-portfolio-image-link:hover span' => 'background-color: {{VALUE}};',
                    ]
                ]
                );
        
        /*Button Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_portfolio_icons_style_border_hover',
                    'selector'      => '{{WRAPPER}} .pr-uk-img-lightbox-item:hover span, {{WRAPPER}} .pr-portfolio-image-link:hover span',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pr_portfolio_icons_style_border_radius_hover',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%' ],                    
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item:hover span, {{WRAPPER}} .pr-portfolio-image-link:hover span' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Shadow','pixerex'),
                    'name'          => 'pr_portfolio_icons_style_shadow_hover',
                    'selector'      => '{{WRAPPER}} {{WRAPPER}} .pr-uk-img-lightbox-item:hover span, {{WRAPPER}} .pr-portfolio-image-link:hover span',
                ]
                );
        
        /*Button Margin*/
        $this->add_responsive_control('pr_portfolio_icons_style_margin_hover',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item:hover span, {{WRAPPER}} .pr-portfolio-image-link:hover span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Button Padding*/
        $this->add_responsive_control('pr_portfolio_icons_style_padding_hover',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-uk-img-lightbox-item:hover span, {{WRAPPER}} .pr-portfolio-image-link:hover span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_portfolio_filter_style',
            [
                'label'     => esc_html__('Filter','pixerex'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pr_portfolio_filter'    => 'yes'
                ]
            ]);
        
        $this->add_control('pr_portfolio_filter_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-cats-container li a.category span' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_control('pr_portfolio_filter_active_color',
                [
                    'label'         => esc_html__('Active Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-portfolio-cats-container li a.active span' => 'color: {{VALUE}};',
                    ]
                ]
                );
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'pr_portfolio_filter_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-portfolio-cats-container li a.category',
                    ]
                );
        
        $this->add_control('pr_portfolio_background',
                [
                    'label'         => esc_html__( 'Background', 'pixerex' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes'
                ]
                );
        
        $this->add_control('pr_portfolio_background_color',
           [
               'label'         => esc_html__('Background Color', 'pixerex'),
               'type'          => Controls_Manager::COLOR,
               'default'       => '#6ec1e4',
               'selectors'     => [
                   '{{WRAPPER}} .pr-portfolio-cats-container li a.category' => 'background-color: {{VALUE}};',
               ],
               'condition' => [
                    'pr_portfolio_background'    => 'yes'
                ]
           ]
       );
        
        $this->add_control('pr_portfolio_background_active_color',
           [
               'label'         => esc_html__('Background Active Color', 'pixerex'),
               'type'          => Controls_Manager::COLOR,
               'default'       => '#54595f',
               'selectors'     => [
                   '{{WRAPPER}} .pr-portfolio-cats-container li a.active' => 'background-color: {{VALUE}};',
               ],
               'condition' => [
                    'pr_portfolio_background'    => 'yes'
                ]
           ]
       );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'              => 'pr_portfolio_filter_border',
                    'selector'          => '{{WRAPPER}} .pr-portfolio-cats-container li a.category',
                ]
                );

        /*Border Radius*/
        $this->add_control('pr_portfolio_filter_border_radius',
                [
                    'label'             => esc_html__('Border Radius', 'pixerex'),
                    'type'              => Controls_Manager::SLIDER,
                    'size_units'        => ['px','em','%'],
                    'selectors'         => [
                        '{{WRAPPER}} .pr-portfolio-cats-container li a.category'  => 'border-radius: {{SIZE}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'name'          => 'pr_portfolio_filter_shadow',
                    'selector'      => '{{WRAPPER}} .pr-portfolio-cats-container li a.category',
                ]
                );
        
        $this->add_responsive_control('pr_portfolio_filter_margin',
                [
                    'label'             => esc_html__('Margin', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'             => [
                        '{{WRAPPER}} .pr-portfolio-cats-container li a.category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        /*Front Icon Padding*/
        $this->add_responsive_control('pr_portfolio_filter_padding',
                [
                    'label'             => esc_html__('Padding', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                'selectors'             => [
                    '{{WRAPPER}} .pr-portfolio-cats-container li a.category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
        
    }
    
    public function filter_cats( $string ) {
		$cat_filtered = strtolower( $string );
		$cat_filtered = preg_replace("/[\s_]/", "-", $cat_filtered);
        $cat_filtered = str_replace(',', ' ', $cat_filtered);
		return $cat_filtered;
	}
    
    protected function render(){
        $settings = $this->get_settings();
        $filter = $settings['pr_portfolio_filter'];
        
        $number_columns = str_replace(array('%','.'),'', 'pr-portfolio-'.$settings['pr_portfolio_column_number'] );
        
        $min_size = $settings['pr_portfolio_min_range'].'px';
        $max_size = $settings['pr_portfolio_max_range'].'px';
        
        $grid_settings = [
            'img_size'  => $settings['pr_portfolio_img_size_select'],
            'filter'    => $settings['pr_portfolio_filter'],
            'light_box' => $settings['pr_portfolio_light_box']
        ];
        
        ?>
<div id="pr-img-portfolio-<?php echo esc_attr($this->get_id()); ?>" class="pr-img-portfolio">
    <?php if($filter == 'yes') : ?>
    <div class="pr-img-portfolio-filter">
        <ul class="pr-portfolio-cats-container">
            <li><a href="javascript:;" class="category active" data-filter="*"><span>All</span></a></li>
            <?php foreach( $settings['pr_portfolio_cats_content'] as $category ) : ?>
            <?php if(!empty($category['pr_portfolio_img_cat'] ) ) : 
                $cat_filtered = $this->filter_cats($category['pr_portfolio_img_cat']);
                ?>
            <li><a href="javascript:;" class="category" data-filter=".<?php echo esc_attr( $cat_filtered ); ?>"><span><?php echo esc_attr( $category['pr_portfolio_img_cat'] ); ?></span></a></li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="pr-portfolio-container js-isotope <?php echo esc_attr($number_columns); ?>" data-settings='<?php echo wp_json_encode($grid_settings); ?>'  uk-lightbox="toggle: .pr-uk-img-lightbox-item; animation: slide">
        <?php foreach( $settings['pr_portfolio_img_content'] as $image ) : ?>
        <div class="pr-portfolio-item <?php echo esc_attr( $this->filter_cats( $image['pr_portfolio_img_category'] ) ); ?>">           
            <div class="pr-portfolio-image style2">
                <div class="pr-portfolio-image-container <?php echo esc_attr($settings['pr_portfolio_img_effect']); ?>">
                    <?php if($settings['pr_portfolio_img_size_select'] == 'one_size'):
                        $image_src = $image['pr_portfolio_img'];
                        $image_src_size = Group_Control_Image_Size::get_attachment_image_src( $image_src['id'], 'thumbnail', $settings );
                        if( empty( $image_src_size ) ) : $image_src_size = $image_src['url']; else: $image_src_size = $image_src_size; endif;
                        ?>
                    <img src="<?php echo $image_src_size; ?>" class="pr-gallery-image">
                    <?php else : ?>
                    <img src="<?php echo esc_url($image['pr_portfolio_img']['url']); ?>" class="pr-gallery-image">
                    <?php endif; ?>
                </div>
                <div class="pr-portfolio-icons-caption-container">
                    <?php if( !empty($image['pr_portfolio_img_link']['url']) ) :
                            $icon_link = $image['pr_portfolio_img_link']['url'];
                            $external = $image['pr_portfolio_img_link']['is_external'] ? 'target="_blank"' : '';
                            $no_follow = $image['pr_portfolio_img_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>
                        <a href="<?php echo esc_attr( $icon_link ); ?>" <?php echo $external; ?><?php echo $no_follow; ?>  class="pr-item-link"></a>
                    <?php endif; ?> 
                    <div class="pr-portfolio-icons-caption-cell">                           
                        <div class="pr-portfolio-caption">    
                        <?php if(!empty($image['pr_portfolio_img_name'])):?>
                            <h4 class="pr-portfolio-img-name"><?php echo esc_html__($image['pr_portfolio_img_name']); ?></h4>
                        <?php endif; ?>
                        <?php if(!empty($image['pr_portfolio_img_desc'])):?>
                            <p class="pr-portfolio-img-desc"><?php echo esc_html__($image['pr_portfolio_img_desc']); ?></p>
                        <?php endif; ?>
                        <?php if( 'yes' == $settings['pr_portfolio_light_box'] ) : ?> 
                            <a href="<?php echo esc_attr( $image['pr_portfolio_img']['url'] ); ?>" class="pr-uk-img-lightbox-item"><span><i class="fa fa-search"></i></span></a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
        <?php if($settings['pr_portfolio_responsive_switcher'] == 'yes') : ?>
        <style>
            @media(min-width: <?php echo $min_size; ?> ) and (max-width:<?php echo $max_size; ?>){
                #pr-img-portfolio-<?php echo esc_attr($this->get_id()); ?> .pr-portfolio-caption {
                    display: none;
                    }  
            }
        </style>
        <?php endif; ?>
    <?php }
}
Plugin::instance()->widgets_manager->register_widget_type(new PR_Image_Gallery_Widget());
