<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_PostCarousel_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-postcarousel';
	}

	public function get_title() {
		return __( 'Posts Carousel', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-post-slider';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }
    
    public function get_script_depends()
    {
        return ['pr-js','uikit'];
    }

	protected function _register_controls() {
		$this->start_controls_section(
			'pr_section_post_carousel_filters',
			[
				'label' => __( 'Post Settings', 'pixerex' )
			]
		);
		

		$this->add_group_control(
			PR_Posts_Group_Control::get_type(),
			[
				'name' => 'prposts'
			]
		);


        $this->add_control(
            'pr_posts_count',
            [
                'label' => __( 'Number of Posts', 'pixerex' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '3'
            ]
        );


        $this->add_control(
            'pr_post_offset',
            [
                'label' => __( 'Post Offset', 'pixerex' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '0'
            ]
				);
				
				$this->add_control(
					'pr_post_except',
					[
							'label' => __( 'Except Post IDs<br />(separated by comma)', 'pixerex' ),
							'type'          => Controls_Manager::TEXT
					]
			);

        $this->add_control(
            'pr_post_orderby',
            [
                'label' => __( 'Order By', 'pixerex' ),
                'type' => Controls_Manager::SELECT,
                'options' => pr_get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'pr_post_order',
            [
                'label' => __( 'Order', 'pixerex' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',

            ]
		);
		
		$this->add_control(
			'pr_post_title_tag',
			[
				'label' => __( 'Title HTML Tag', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'pr_section_post_carousel_layout',
			[
				'label' => __( 'Layout Settings', 'pixerex' )
			]
		);
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'exclude' => [ 'custom' ],
				'default' => 'full',
			]
		);
				
        $this->add_control(
			'pr_show_excerpt',
                [
                    'label'         => esc_html__('Excerpt', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
					'default'       => 'yes',
					'condition' => [
						'pr_blog_carousel_skins' => 'style-three',
					],
                ]
                );

        $this->add_control(
			'pr_excerpt_length',
                [
                    'label'         => esc_html__('Excerpt Length', 'pixerex'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 20,
                    'label_block'   => true,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name' => 'pr_blog_carousel_skins',
								'value' => 'style-three',
							],
							[
								'name' => 'pr_blog_carousel_skins',
								'value' => 'style-two',
							],
						],
					],
                    ]
				);
		
		$this->add_control(
			'pr_show_read_more',
			[
				'label'             => esc_html__( 'Show Read More Button', 'pixerex' ),
				'type'              => Controls_Manager::SWITCHER,
				'default'           => 'yes',
				'condition' => [
					'pr_blog_carousel_skins' => 'style-three',
                ]
			]
		);
		
		$this->add_control(
			'pr_posts_read_more_text',
				[
					'label'         => esc_html__('Read More Text', 'pixerex'),
					'type'          => Controls_Manager::TEXT,
					'default'       => esc_html__('Read More','pixerex'),
					'condition'     => [
						'pr_show_read_more'  => 'yes',
						'pr_blog_carousel_skins' => 'style-three',
						]
				]
		);


		$this->end_controls_section();

		// Blog Carousel Settings
		$this->start_controls_section(
			'pr_blog_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'pixerex' ),
			]
		);

		$this->add_responsive_control(
            'pr_blog_carousel_max_items',
            [
                'label'                 => __( 'Visible Items', 'pixerex' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 3 ],
                'tablet_default'        => [ 'size' => 2 ],
                'mobile_default'        => [ 'size' => 1 ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 10,
                        'step'  => 1,
                    ],
                ],
                'size_units'   => '',
            ]
		);
		
		$this->add_responsive_control(
            'pr_blog_carousel_gap',
            [
                'label'                 => __( 'Item gap', 'pixerex' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 30 ],
                'tablet_default'        => [ 'size' => 15 ],
                'mobile_default'        => [ 'size' => 0 ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'   => '',
            ]
        );

		$this->add_control(
		  'pr_blog_carousel_speed',
		  [
		     'label'   => __( 'Animation Speed', 'pixerex' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 600,
		     'min'     => 100,
		     'max'     => 3000,
		     'step'    => 100,
		  ]
		);

		$this->add_control(
            'pr_blog_carousel_autoplay',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Autoplay', 'pixerex'),
            ]
		);
		
		$this->add_control(
			'pr_blog_carousel_autoplay_speed',
			[
			   'label'     => __( 'Autoplay Speed', 'pixerex' ),
			   'type'      => Controls_Manager::NUMBER,
			   'default'   => 600,
			   'min'       => 100,
			   'max'       => 3000,
			   'step'      => 100,
			   'condition' => [
					'pr_blog_carousel_autoplay'      => 'yes',
				],
			]
		  );

		$this->add_control(
			'pr_blog_carousel_pause_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
            'pr_blog_carousel_grab',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Grab Cursor', 'pixerex'),
            ]
		);

		$this->add_control(
            'pr_blog_carousel_infinite',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Infinite Loop', 'pixerex'),
            ]
        );
		
		$this->add_control(
            'pr_blog_carousel_center_mode',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Center Mode', 'pixerex'),
            ]
        );

        $this->add_control(
            'pr_blog_carousel_dots',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'yes',
                'label' => __('Dots navigation', 'pixerex'),
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			array(
				'label'      => esc_html__( 'Post Item', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'pr_blog_carousel_skins',
			[
				'label' => esc_html__( 'Skin', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-one',
				'options' => [
					'style-three' 	=> esc_html__( 'Classic', 'pixerex' ),
					'style-one' 	=> esc_html__( 'Overlay', 'pixerex' ),
					'style-two' 	=> esc_html__( 'Overlay Modern', 'pixerex' ),
					'style-four' 	=> esc_html__( 'Works Overlay', 'pixerex' ),
				],
			]
		);
		
		$this->add_control(
			'pr_blog_carousel_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel .post.type-post>.outer>.inner' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'pr_blog_carousel_skins!' => 'style-four',
				],
			)
		);

		$this->add_control(
			'pr_blog_carousel_bg_overlay',
			array(
				'label' => esc_html__( 'Overlay Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel article:hover>.outer>.inner' => 'background-color: {{VALUE}}!important',
				]
			)
		);

		$this->add_control(
			'pr_blog_carousel_grayscale',
			[
				'label'       => esc_html__( 'Grayscale', 'pixerex' ),
				'description' => esc_html__( 'Apply grayscale filtre to images.', 'pixerex' ),
				'type'        => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pr_blog_carousel_grayscale_pr',
			[
				'label'     => esc_html__( 'Grayscale Filter', 'pixerex' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .pr__image__cover' => 'filter: grayscale({{SIZE}}%); -webkit-filter: grayscale({{SIZE}}%);',
				],
				'condition' => [
					'pr_blog_carousel_grayscale' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pr_blog_carousel_padding',
			[
				'label' => esc_html__( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_blog_carousel_border',
				'label' => esc_html__( 'Border for post', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-post-carousel article',
			]
		);

		$this->add_control(
			'pr_blog_carousel_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel article' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pr-post-carousel article>.outer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .pr-post-carousel article>.outer>.featured-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'pr_blog_carousel_skins!' => 'style-three',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_blog_carousel_box_shadow',
				'selector' => '{{WRAPPER}} .pr-post-carousel article',
				'condition' => [
					'pr_blog_carousel_skins!' => 'style-four',
				],
			]
		);
		$this->add_control(
			'pr_blog_carousel_shadow_hover_title',
			[
				'label' => __( 'Hover Box Shadow', 'pixerex' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'pr_blog_carousel_skins!' => 'style-four',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_blog_carousel_box_shadow_hover',
				'label' => esc_html__( 'Hover Box Shadow', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-post-carousel article:hover',
				'condition' => [
					'pr_blog_carousel_skins!' => 'style-four',
				],
			]
		);

		// Work carousel box-shadow

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_blog_carousel_box_shadow_4',
				'selector' => '{{WRAPPER}} .pr-post-carousel article > .outer',
				'condition' => [
					'pr_blog_carousel_skins' => 'style-four',
				],
			]
		);
		$this->add_control(
			'pr_blog_carousel_shadow_hover_title_4',
			[
				'label' => __( 'Hover Box Shadow', 'pixerex' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'pr_blog_carousel_skins' => 'style-four',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_blog_carousel_box_shadow_hover_4',
				'label' => esc_html__( 'Hover Box Shadow', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-post-carousel article > .outer:hover',
				'condition' => [
					'pr_blog_carousel_skins' => 'style-four',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pr_post_carousel_title_style',
			array(
				'label'      => esc_html__( 'Title', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_title_color' );

		$this->start_controls_tab(
			'tab_pr_post_carousel_title_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_control(
			'pr_blog_carousel_title_color',
			array(
				'label'     => esc_html__( 'Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner .title a' => 'color: {{VALUE}};',
				]
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pr_post_carousel_title_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_control(
			'pr_blog_carousel_title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel article:hover>.outer>.inner .title a' => 'color: {{VALUE}};',
				]
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'st_one_arrow_icon_color',
			array(
				'label' => esc_html__( 'Arrow Icon Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-post-carousel .post.type-post>.outer>.inner .more.icon' => 'color: {{VALUE}}',
				),
				'condition' => [
					'pr_blog_carousel_skins' => 'style-one',
                ]

			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pr-post-carousel article>.outer>.inner .title',
			)
		);

		$this->add_responsive_control(
			'pr_blog_carousel_title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'pixerex' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pr-post-carousel .post.type-post>.outer>.inner .title' => 'text-align: {{VALUE}};',
				),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name' => 'pr_blog_carousel_skins',
							'value' => 'style-three',
						],
						[
							'name' => 'pr_blog_carousel_skins',
							'value' => 'style-two',
						],
					],
				],
			)
		);

		$this->add_responsive_control(
			'pr_blog_carousel_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_meta_style',
			array(
				'label'      => esc_html__( 'Meta', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'meta_link_color',
			array(
				'label' => esc_html__( 'Links Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				),
				'selectors' => array(
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner .category a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner .category' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_link_color_hover',
			array(
				'label' => esc_html__( 'Links Hover Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-post-carousel article:hover>.outer>.inner .category a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pr-post-carousel article:hover>.outer>.inner .category' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pr-post-carousel article:hover>.outer>.inner .meta>li' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .pr-post-carousel article>.outer>.inner .category',
			)
		);

		$this->add_control(
			'pr_bottom_meta_heading',
			[
				'label' => esc_html__( 'Bottom Meta Style', 'pixerex' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
                    'pr_blog_carousel_skins' => 'style-two',
                ]
			]
		);

		$this->add_control(
			'pr_meta_color',
			array(
				'label'  => esc_html__( 'Text Color', 'pixerex' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} .pr-post-carousel .post.type-post>.outer>.inner .meta>li' => 'color: {{VALUE}}',
				),
				'condition' => [
					'pr_blog_carousel_skins' => 'style-two',
                ]
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_style2_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pr-post-carousel .post.type-post>.outer>.inner .meta>li',
				'condition' => [
                    'pr_blog_carousel_skins' => 'style-two',
                ]
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner .category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'pixerex' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner .category' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pr-post-carousel article>.outer>.inner .meta' => 'text-align: {{VALUE}};',
				),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name' => 'pr_blog_carousel_skins',
							'value' => 'style-three',
						],
						[
							'name' => 'pr_blog_carousel_skins',
							'value' => 'style-two',
						],
					],
				],
			)
		);

		$this->end_controls_section();


        $this->start_controls_section(
            'pr_section_content_style',
            [
                'label' => __( 'Excerpt', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name' => 'pr_blog_carousel_skins',
							'value' => 'style-three',
						],
						[
							'name' => 'pr_blog_carousel_skins',
							'value' => 'style-two',
						],
					],
				],
            ]
        );

        $this->add_control(
			'pr_blog_carousel_excerpt_color',
			[
				'label' => __( 'Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel .post.type-post > .outer > .inner .description' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'pr_blog_carousel_excerpt_hover',
			[
				'label' => __( 'Hover Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pr-post-carousel .post.type-post:hover > .outer > .inner .description' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pr_blog_carousel_excerpt_typography',
				'label' => __( 'Typography', 'pixerex' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pr-post-carousel .post.type-post > .outer > .inner .description',
			]
		);

		$this->add_responsive_control(
			'pr_blog_carousel_excerpt_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'pixerex' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pr-post-carousel .post.type-post > .outer > .inner .description' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'pr_blog_carousel_excerpt_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-post-carousel .post.type-post > .outer > .inner .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => [
					'pr_blog_carousel_skins' => 'style-three',
                ]
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_control(
			'button_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'pixerex' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => _x( 'Classic', 'Background Control', 'pixerex' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'pixerex' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'pixerex' ),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_bg_color_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition' => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'pixerex' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_type',
			array(
				'label'   => _x( 'Type', 'Background Control', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'linear' => _x( 'Linear', 'Background Control', 'pixerex' ),
					'radial' => _x( 'Radial', 'Background Control', 'pixerex' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'pixerex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range' => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'linear',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_position',
			array(
				'label'   => _x( 'Position', 'Background Control', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'center center' => _x( 'Center Center', 'Background Control', 'pixerex' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'pixerex' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'pixerex' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'pixerex' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'pixerex' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'pixerex' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'pixerex' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'pixerex' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'pixerex' ),
				),
				'default' => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'radial',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label' => esc_html__( 'Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pr-readmore-btn',
			)
		);

		$this->add_control(
			'button_text_decor',
			array(
				'label'   => esc_html__( 'Text Decoration', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'      => esc_html__( 'None', 'pixerex' ),
					'underline' => esc_html__( 'Underline', 'pixerex' ),
				),
				'default' => 'none',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'pixerex' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pr-readmore-btn',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pr-readmore-btn',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_control(
			'button_hover_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'pixerex' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color' => array(
						'title' => _x( 'Classic', 'Background Control', 'pixerex' ),
						'icon'  => 'fa fa-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'pixerex' ),
						'icon'  => 'fa fa-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'pixerex' ),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition' => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'pixerex' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b_stop',
			array(
				'label'      => _x( 'Location', 'Background Control', 'pixerex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_type',
			array(
				'label'   => _x( 'Type', 'Background Control', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'linear' => _x( 'Linear', 'Background Control', 'pixerex' ),
					'radial' => _x( 'Radial', 'Background Control', 'pixerex' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'pixerex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range' => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'linear',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_position',
			array(
				'label'   => _x( 'Position', 'Background Control', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'center center' => _x( 'Center Center', 'Background Control', 'pixerex' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'pixerex' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'pixerex' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'pixerex' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'pixerex' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'pixerex' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'pixerex' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'pixerex' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'pixerex' ),
				),
				'default' => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'radial',
				),
				'of_type' => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label' => esc_html__( 'Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'button_hover_typography',
				'label' => esc_html__( 'Typography', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-readmore-btn:hover',
			)
		);

		$this->add_control(
			'button_hover_text_decor',
			array(
				'label'   => esc_html__( 'Text Decoration', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'      => esc_html__( 'None', 'pixerex' ),
					'underline' => esc_html__( 'Underline', 'pixerex' ),
				),
				'default' => 'none',
				'selectors' => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'pixerex' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pr-readmore-btn:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .pr-readmore-btn:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'pixerex' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					),
					'none' => array(
						'title' => esc_html__( 'Fullwidth', 'pixerex' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pr-readmore-btn' => 'align-self: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		# Dots Navigation Style
		/*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'section_pr_blog_carousel_dots_style',
            [
                'label'      => __( 'Dots', 'pixerex' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'pr_blog_carousel_dots'      => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'pr_blog_carousel_dots_size',
            [
                'label'  => __( 'Dots Size', 'pixerex' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'min'   => 2,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'  => '',
                'selectors'   => [
                    '{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
		);

		$this->add_responsive_control(
            'pr_blog_carousel_active_dot_size',
            [
                'label'  => __( 'Active Dot Size', 'pixerex' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'min'   => 2,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'  => '',
                'selectors'   => [
                    '{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'pr_blog_carousel_dots_spacing',
            [
                'label'  => __( 'Spacing', 'pixerex' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'  => '',
                'selectors'   => [
                    '{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
		);
		
		$this->add_responsive_control(
			'dots_padding',
			[
				'label'                => __( 'Padding', 'pixerex' ),
				'type'                => Controls_Manager::DIMENSIONS,
				'size_units'          => [ 'px', 'em', '%' ],
                'allowed_dimensions'  => 'vertical',
				'placeholder'         => [
					'top'      => '',
					'right'    => 'auto',
					'bottom'   => '',
					'left'     => 'auto',
				],
				'selectors'             => [
					'{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullets' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( 'tabs_pr_blog_carousel_dots_style' );

        $this->start_controls_tab(
            'tab_pr_blog_carousel_dots_normal',
            [
                'label' => __( 'Normal', 'pixerex' ),
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label'      => __( 'Color', 'pixerex' ),
				'type'       => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
                'selectors'  => [
                    '{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label'      => __( 'Active Color', 'pixerex' ),
                'type'       => Controls_Manager::COLOR,
                'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				),
                'selectors'  => [
					'{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet-active' => 'background: {{VALUE}}; border-color:{{VALUE}};',
					'{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet-active:hover' => 'background: {{VALUE}}!important; border-color:{{VALUE}}!important;',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'         => 'dots_border_normal',
				'label'        => __( 'Border', 'pixerex' ),
				'placeholder'  => '1px',
				'default'      => '1px',
				'selector'     => '{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet',
			]
		);

		$this->add_control(
			'dots_border_radius_normal',
			[
				'label'      => __( 'Border Radius', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_pr_blog_carousel_dots_hover',
            [
                'label'  => __( 'Hover', 'pixerex' ),
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label'      => __( 'Color', 'pixerex' ),
                'type'       => Controls_Manager::COLOR,
                'default'    => '',
                'selectors'  => [
                    '{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label'      => __( 'Border Color', 'pixerex' ),
                'type'       => Controls_Manager::COLOR,
                'default'    => '',
                'selectors'  => [
                    '{{WRAPPER}} .pr-post-carousel .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

	}


	protected function render( ) {
		$settings = $this->get_settings();
		$post_args    = pr_get_post_settings_arr( $settings );
		$query_args   = PR_Helper::get_query_args( 'prposts', $this->get_settings() );
		$query_args   = array_merge( $query_args, $post_args );

		if( isset( $query_args['tax_query'] ) ) {
			$tax_query = $query_args['tax_query'];
		}
		$pr_posts = new \WP_Query($query_args);

		$blog_carousel_style = $this->get_settings('pr_blog_carousel_skins');
		
		$pr_blog_carousel_settings = [
			'pr_blog_carousel_max_items' => $settings['pr_blog_carousel_max_items']['size'],
			'pr_blog_carousel_tab_items' => $settings['pr_blog_carousel_max_items_tablet']['size'],
			'pr_blog_carousel_mobile_items' => $settings['pr_blog_carousel_max_items_mobile']['size'],
			'pr_blog_carousel_gap' => $settings['pr_blog_carousel_gap']['size'],
			'pr_blog_carousel_tab_gap' => $settings['pr_blog_carousel_gap_tablet']['size'],
			'pr_blog_carousel_mobile_gap' => $settings['pr_blog_carousel_gap_mobile']['size'],
			'pr_blog_carousel_speed' => $settings['pr_blog_carousel_speed'],
			'pr_blog_carousel_autoplay'  => $settings['pr_blog_carousel_autoplay'],
			'pr_blog_carousel_autoplay_speed' => $settings['pr_blog_carousel_autoplay_speed'],
			'pr_blog_carousel_pause_hover'  => $settings['pr_blog_carousel_pause_hover'],
			'pr_blog_carousel_center_mode'  => $settings['pr_blog_carousel_center_mode'],
			'pr_blog_carousel_infinite'  => $settings['pr_blog_carousel_infinite'],
			'pr_blog_carousel_grab'  => $settings['pr_blog_carousel_grab'],
			
			
		];
	?>

		<div id="pr-post-carousel-<?php echo esc_attr($this->get_id()); ?>" class="pr-post-carousel">
			<div class="swiper-container blog-listing <?php echo $blog_carousel_style; ?> blog-slider"
				data-settings='<?php echo wp_json_encode($pr_blog_carousel_settings); ?>'>
				<div class="swiper-wrapper">
					<?php
					while ( $pr_posts->have_posts() ) : $pr_posts->the_post();
		
						$post_type = get_post_type();

						$taxonomy = 'category';
				
						if ( 'portfolio' === $post_type ) {
							$taxonomy = 'portfolio_category';
						} 
						$categories_list = get_the_term_list( get_the_ID(), $taxonomy, '', ' / ', '' );
						?>
						<div class="swiper-slide">
							<?php if($blog_carousel_style == 'style-one'){ ?>
								<article class="post type-post">
									<div class="outer">
										<div class="featured-image">
											<div class="image pr__image__cover" data-src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>" data-uk-img></div>
										</div>
										<div class="inner">
											<div class="category"><?php echo $categories_list; ?></div>
											<<?php echo $settings['pr_post_title_tag']; ?> class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $settings['pr_post_title_tag']; ?>>
											<a href="<?php the_permalink(); ?>" class="more icon icon-arrow-right"></a>
											<a href="<?php the_permalink(); ?>" class="link"></a>
										</div>
									</div>
								</article>
							<?php } elseif($blog_carousel_style == 'style-two'){ ?>
								<article class="post type-post">
									<div class="outer">
										<div class="featured-image">
											<div class="image pr__image__cover" data-src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>" data-uk-img></div>
										</div>
										<div class="inner">
											<div class="top">
												<div class="category"><?php echo $categories_list; ?></div>
												<<?php echo $settings['pr_post_title_tag']; ?> class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $settings['pr_post_title_tag']; ?>>
												<p class="description"><?php echo  pr_get_excerpt_by_id(get_the_ID(),$settings['pr_excerpt_length']);?></p>
												<a href="<?php the_permalink(); ?>" class="link"></a>
											</div>
											<div class="bottom">
												<ul class="meta">
													<li class="meta-date"><?php echo get_the_date(); ?></li>
												</ul>
											</div>
										</div>
									</div>
								</article>
							<?php } elseif($blog_carousel_style == 'style-three') { ?>
								<article class="post type-post">
									<div class="outer">
										<div class="featured-image">
											<div class="image pr__image__cover" data-src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>" data-uk-img></div>
										</div>
										<div class="inner">
											<div class="category"><?php echo $categories_list; ?></div>
											<<?php echo $settings['pr_post_title_tag']; ?> class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $settings['pr_post_title_tag']; ?>>
											<?php if($settings['pr_show_excerpt'] == 'yes'){ ?>
												<p class="description"><?php echo  pr_get_excerpt_by_id(get_the_ID(),$settings['pr_excerpt_length']);?></p>
											<?php } ?>
											<?php if($settings['pr_show_read_more'] == 'yes'){ ?>
												<div class="pr-readmore-warp">
													<a href="<?php echo get_permalink(); ?>" class="btn btn-primary elementor-button elementor-size-md pr-readmore-btn" title="<?php the_title(); ?>"><?php echo $settings['pr_posts_read_more_text']; ?></a>
												</div>
											<?php } ?>
											<a href="<?php the_permalink(); ?>" class="link"></a>
										</div>
									</div>
								</article>
							<?php } else { ?>
								<article class="item work-box">
									<div class="outer">
										<div class="image pr__image__cover pr__ratio__square" data-src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>" data-uk-img></div>
										<div class="inner">
											<<?php echo $settings['pr_post_title_tag']; ?> class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $settings['pr_post_title_tag']; ?>>
											<div class="category"><?php echo $categories_list; ?></div>
											<a href="<?php the_permalink(); ?>" class="link uk-position-cover"></a>
										</div>
									</div>
								</article>
							<?php } ?>
						</div>
					<?php endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php if($settings['pr_blog_carousel_dots'] == 'yes'){ ?>
					<div class="swiper-pagination"></div>
				<?php } ?>
			</div>
		</div>
        <?php
	}

	protected function content_template() {
		?>

		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new PR_PostCarousel_Widget() );