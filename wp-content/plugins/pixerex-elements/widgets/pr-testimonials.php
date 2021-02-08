<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class PR_TestimonialSlider_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-testimonialslider';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Slider', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_script_depends() {
		return ['pr-js','slick-carousel-js'];
	}

    public function get_categories() {
        return [ 'pr-elements' ];
    }
	
	
	protected function _register_controls() {


  		$this->start_controls_section(
  			'pr_section_testimonial_content',
  			[
  				'label' => esc_html__( 'Testimonial Content', 'pixerex' )
  			]
  		);


		$this->add_control(
			'pr_testimonial_slider_item',
			[
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'pr_testimonial_name' => 'John Doe',
					],
					[
						'pr_testimonial_name' => 'Jane Doe',
					],

				],
				'fields' => [

					[
						'name' => 'pr_testimonial_description',
						'label' => esc_html__( 'Testimonial Content', 'pixerex' ),
						'type' => Controls_Manager::TEXTAREA,
						'rows' => '8',
						'default' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'pixerex' ),
					],
					[
						'name' => 'pr_testimonial_enable_avatar',
						'label' => esc_html__( 'Display Avatar?', 'pixerex' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => 'yes',
					],
					[
						'name' => 'pr_testimonial_image',
						'label' => esc_html__( 'Testimonial Avatar', 'pixerex' ),
						'type' => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'condition' => [
							'pr_testimonial_enable_avatar' => 'yes',
						],
					],
					[
						'name' => 'pr_testimonial_name',
						'label' => esc_html__( 'User Name', 'pixerex' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'John Doe', 'pixerex' ),
					],
					[
						'name' => 'pr_testimonial_company_title',
						'label' => esc_html__( 'Company Name', 'pixerex' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Company', 'pixerex' ),
					],

				],
				'title_field' => 'Testimonial Item',
			]
		);



		$this->end_controls_section();

		
		
		$this->start_controls_section(
			'pr_section_testimonial_slider_settings',
			[
				'label' => esc_html__( 'Testimonial Slider Settings', 'pixerex' ),
			]
		);

		$this->add_responsive_control(
            'pr_testimonial_max_items',
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
                'size_units'            => '',
            ]
        );

		$this->add_control(
		  'pr_testimonial_slide_item',
		  [
		     'label'   => __( 'Slide to Scroll', 'pixerex' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 1,
		     'min'     => 1,
		     'max'     => 100,
		     'step'    => 1,
		  ]
		);

		$this->add_control(
		  'pr_testimonial_slide_speed',
		  [
		     'label'   => __( 'Slide Speed', 'pixerex' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 300,
		     'min'     => 100,
		     'max'     => 3000,
		     'step'    => 100,
		  ]
		);

		$this->add_control(
            'pr_testimonial_slider_autoplay',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'no',
                'label' => __('Autoplay', 'pixerex'),
                'description' => __('Should the carousel autoplay as in a slideshow.', 'pixerex'),
            ]
        );

		$this->add_control(
			'pr_testimonial_slider_pause_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
            'pr_testimonial_slide_draggable',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'no',
                'label' => __('Draggable', 'pixerex'),
            ]
		);
		
		$this->add_control(
            'pr_testimonial_slide_infinite',
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
            'pr_arrows',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'yes',
                'label' => __('Arrows', 'pixerex'),
            ]
        );


        $this->add_control(
            'pr_dots',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'no',
                'label' => __('Dots Navigation', 'pixerex'),
            ]
        );

		$this->end_controls_section();


		$this->start_controls_section(
			'pr_section_testimonial_styles_general',
			[
				'label' => esc_html__( 'General Styles', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
            'pr_testimonial_layout',
            [
                'label' => __( 'Layout', 'pixerex' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'above' => 'Image Above',
                    'below' => 'Image Below'
                ],
                'default' => 'above',

            ]
        );

		$this->add_control(
			'pr_testimonial_background',
			[
				'label' => esc_html__( 'Testimonial Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_testimonial_alignment',
			[
				'label' => esc_html__( 'Set Alignment', 'pixerex' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'pr-testimonial-align-left' => [
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon' => 'fa fa-align-left',
					],
					'pr-testimonial-align-center' => [
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon' => 'fa fa-align-center',
					],
					'pr-testimonial-align-right' => [
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'pr-testimonial-align-center',
			]
		);


		$this->add_responsive_control(
			'pr_testimonial_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'description' => 'Need to refresh the page to see the change properly',
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_testimonial_padding',
			[
				'label' => esc_html__( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'testimonials_style' );

		$this->start_controls_tab(
			'tab_testimonials_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_testimonial_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-testimonial-wrapper',
			]
		);

		$this->add_control(
			'pr_testimonial_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_testimonial_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .pr-testimonial-wrapper',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_testimonials_style__hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_testimonial_border_hover',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-testimonial-wrapper:hover',
			]
		);

		$this->add_control(
			'pr_testimonial_border_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-wrapper:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_testimonial_box_shadow_hover',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .pr-testimonial-wrapper:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();

		// Content.
		$this->start_controls_section(
			'section_style_testimonial_content',
			[
				'label' => __( 'Content', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_content_color',
			[
				'label' => __( 'Content Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'pr_content_typography',
				'selector' => '{{WRAPPER}} .pr-testimonial-text',
			]
		);

		$this->add_responsive_control(
			'pr_testimonial_content_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'pr_section_testimonial_image_styles',
			[
				'label' => esc_html__( 'Image', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
            'pr_testimonial_img_position',
            [
                'label' => __( 'Image Position', 'pixerex' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'pr-testimonial-img-top' => esc_html__( 'Top', 'pixerex' ),
                    'pr-testimonial-img-aside' => esc_html__( 'Aside', 'pixerex' ),
                ],
                'default' => 'pr-testimonial-img-top',

            ]
        );

		$this->add_responsive_control(
			'pr_testimonial_image_width',
			[
				'label' => esc_html__( 'Image Width', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 80,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 300,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'pr_testimonial_image_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_testimonial_image_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-testimonial-image img',
			]
		);


		$this->add_control(
			'pr_testimonial_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-image img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->end_controls_section();

		// Name.
		$this->start_controls_section(
			'section_style_testimonial_name',
			[
				'label' => __( 'Name', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pr_name_color',
			[
				'label' => __( 'Name Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'pr_name_typography',
				'selector' => '{{WRAPPER}} .pr-testimonial-name',
			]
		);

		$this->add_responsive_control(
			'pr_testimonial_name_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Job.
		$this->start_controls_section(
			'section_style_testimonial_job',
			[
				'label' => __( 'Job', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pr_job_color',
			[
				'label' => __( 'Job Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-job' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'pr_job_typography',
				'selector' => '{{WRAPPER}} .pr-testimonial-job',
			]
		);

		$this->add_responsive_control(
			'pr_testimonial_job_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_testimonial_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_arrows' => 'yes',
				],
			]
		);
		$this->add_responsive_control('pr_testimonials_arrows_position',
			[
				'label' => esc_html__( 'Position', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'allowed_dimensions' => [ 'bottom', 'right' ],
				'selectors' => [
					'{{WRAPPER}} .pr-testimonial-nav-container' => 'bottom: {{BOTTOM}}{{UNIT}}; right: {{RIGHT}}{{UNIT}};',
					
				],
			]
		);	

		$this->add_responsive_control('pr_testimonial_arrows_font_size',
		  	[
		     	'label'			=> esc_html__( 'Font Size', 'pixerex' ),
		     	'type' 			=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .pr-testimonial-nav-container i'  => 'font-size: {{SIZE}}px;'
				]
		  	]
		);

		$this->add_responsive_control('pr_testimonial_arrows_bg_size',
		  	[
		     	'label'			=> esc_html__( 'Box Size', 'pixerex' ),
		     	'type' 			=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 400,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .pr-testimonial-nav-container i' => 'padding: {{SIZE}}px; height: {{SIZE}}px;'
				]
		  	]
		);
		
		$this->start_controls_tabs( 'pr_testimonial_arrows_style_tabs' );

		$this->start_controls_tab('pr_testimonial_arrows_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_control('pr_testimonial_arrows_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-testimonial-nav-container i' => 'color: {{VALUE}};',
                        ]
                    ]
		);

		$this->add_control('pr_testimonial_arrows_back_color',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-testimonial-nav-container i'  => 'background-color: {{VALUE}};'
                        ]
                    ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_testimonial_arrows_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-testimonial-nav-container i',
			]
		);
		
        
        $this->add_control('pr_testimonial_arrows_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' , 'em'],
                    'selectors'     => [
						'{{WRAPPER}} .pr-testimonial-nav-container i' => 'border-radius: {{SIZE}}{{UNIT}};',
                    ],
                ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('pr_testimonial_arrows_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_control('pr_testimonial_arrows_hover_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-testimonial-nav-container i:hover' => 'color: {{VALUE}};',
                        ]
                    ]
        );

		$this->add_control('pr_testimonial_arrows_back_color_hover',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-testimonial-nav-container i:hover'  => 'background-color: {{VALUE}};'
                        ]
                    ]
		);

		$this->add_control('pr_testimonial_arrows_border_color_hover',
                [
                    'label'         => esc_html__('BorderColor', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-testimonial-nav-container i:hover'  => 'border-color: {{VALUE}};'
                        ]
                    ]
		);

		$this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		# Dots Navigation Style
		/*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'pr_section_testimonial_navigation_style',
            [
                'label'      => __( 'Dots', 'pixerex' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition' => [
					'pr_dots' => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
            'pr_testimonial_slider_dots_size',
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
                'selectors' => [
					'{{WRAPPER}} .pr-testimonial-slider .slick-dots li button::before' => 'font-size:{{SIZE}}{{UNIT}};',
				],
            ]
		);

		$this->add_responsive_control(
            'pr_testimonial_slider_active_dot_size',
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
                'selectors' => [
					'{{WRAPPER}} .pr-testimonial-slider .slick-dots li.slick-active button::before' => 'font-size:{{SIZE}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
            'pr_testimonial_slider_dots_spacing',
            [
                'label'  => __( 'Dots Spacing', 'pixerex' ),
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
                    '{{WRAPPER}} .pr-testimonial-slider .slick-dots li' => 'margin-left: {{SIZE}}{{UNIT}}!important; margin-right: {{SIZE}}{{UNIT}}!important',
                ],
            ]
		);
		
		$this->add_responsive_control(
			'pr_testimonial_slider_bullet_vspacing',
			[
				'label' => esc_html__( 'Vertical Spacing', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .slick-dots' => 'bottom:-{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
            'pr_testimonial_slider_dots_color_normal',
            [
                'label'      => __( 'Color', 'pixerex' ),
				'type'       => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
                'selectors' => [
					'{{WRAPPER}} .pr-testimonial-slider .slick-dots li button::before' => 'color: {{VALUE}};',
				],
            ]
        );

        $this->add_control(
            'pr_testimonial_slider_active_dot_color_normal',
            [
                'label'      => __( 'Active Color', 'pixerex' ),
                'type'       => Controls_Manager::COLOR,
                'default'   => '',
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				),
                'selectors'  => [
					'{{WRAPPER}} .pr-testimonial-slider .slick-dots li.slick-active button::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pr-testimonial-slider .slick-dots li.slick-:hover button::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


	}


	protected function render( ) {
		
		$settings = $this->get_settings();
		$items = $settings['pr_testimonial_slider_item'];
		$testimonial_classes = $this->get_settings('pr_testimonial_alignment');
		$testimonial_img_position_class = $this->get_settings('pr_testimonial_img_position');

		$pr_testimonials_settings = [
			'pr_arrows' => ('yes' === $settings['pr_arrows']),
			'pr_dots' => ('yes' === $settings['pr_dots']),
			'pr_testimonial_slider_autoplay' => ('yes' === $settings['pr_testimonial_slider_autoplay']),
			'pr_testimonial_slide_draggable' => ('yes' === $settings['pr_testimonial_slide_draggable']),
			'pr_testimonial_slide_infinite' => ('yes' === $settings['pr_testimonial_slide_infinite']),
			'pr_testimonial_slide_speed' => absint($settings['pr_testimonial_slide_speed']),
			'pr_testimonial_slider_pause_hover' => ('yes' === $settings['pr_testimonial_slider_pause_hover']),
			'pr_testimonial_max_items' => $settings['pr_testimonial_max_items']['size'],
			'pr_testimonial_max_tab_item' => $settings['pr_testimonial_max_items_tablet']['size'],
			'pr_testimonial_max_mobile_item' => $settings['pr_testimonial_max_items_mobile']['size'],
			'pr_testimonial_slide_item' => $settings['pr_testimonial_slide_item'],
			'pr-nav-id'  => esc_attr($this->get_id()),
			];
	?>
		<div id="pr-testimonial">
			<div class="pr-testimonial-slider"
			data-settings='<?php echo wp_json_encode($pr_testimonials_settings); ?>'>

				<?php foreach ( $items as $item ) : ?>
					<div class="pr-testimonial-wrapper <?php echo $testimonial_classes; ?>">
							<?php if($settings['pr_testimonial_layout'] == 'above') : ?>
								<div class="pr-testimonial-author <?php echo $testimonial_img_position_class; ?>">
									<?php if ( $item['pr_testimonial_enable_avatar'] == 'yes' ) : ?>
										<div class="pr-testimonial-image">
											<?php $image = $item['pr_testimonial_image']; ?>
											<img src="<?php echo $image['url'];?>" alt="<?php echo esc_attr( $item['pr_testimonial_name'] ); ?>">	
										</div>
									<?php endif; ?>
									<div class="pr-testimonial-name"><?php echo esc_attr( $item['pr_testimonial_name'] ); ?></div>
									<div class="pr-testimonial-job"><?php echo esc_attr( $item['pr_testimonial_company_title'] ); ?></div>			
								</div>
							<?php endif; ?>
							<div class="pr-testimonial-text">
							<?php echo $item['pr_testimonial_description']; ?>
							</div>
							<?php if($settings['pr_testimonial_layout'] == 'below') : ?>
								<div class="pr-testimonial-author <?php echo $testimonial_img_position_class; ?>">
									<?php if ( $item['pr_testimonial_enable_avatar'] == 'yes' ) : ?>
										<div class="pr-testimonial-image">
											<?php $image = $item['pr_testimonial_image']; ?>
											<img src="<?php echo $image['url'];?>" alt="<?php echo esc_attr( $item['pr_testimonial_name'] ); ?>">	
										</div>
									<?php endif; ?>
									<div class="pr-testimonial-author-info">
										<div class="pr-testimonial-name"><?php echo esc_attr( $item['pr_testimonial_name'] ); ?></div>
										<div class="pr-testimonial-job"><?php echo esc_attr( $item['pr_testimonial_company_title'] ); ?></div>			
									</div>
								</div>
							<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
				<div class="pr-testimonial-nav-container pr-nav-id-<?php echo esc_attr($this->get_id()); ?>">
				</div>
		</div>

	<?php
	
	}

	protected function content_template() {
		
		?>
		
	
		<?php
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new PR_TestimonialSlider_Widget() );