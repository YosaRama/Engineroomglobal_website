<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class PR_PersonCarousel_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-personcarousel';
	}

	public function get_title() {
		return esc_html__( 'Team Carousel', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_script_depends() {
		return ['pr-js','slick-carousel-js'];
	}

    public function get_categories() {
        return [ 'pr-elements' ];
    }
	
	
	protected function _register_controls() {


  		$this->start_controls_section(
  			'pr_section_team_slider_content',
  			[
  				'label' => esc_html__( 'Team Carousel Content', 'pixerex' )
  			]
  		);


		$this->add_control(
			'pr_team_member_slider_item',
			[
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'pr_team_slider_member_name' => 'Team Member #1',
					],
					[
						'pr_team_slider_member_name' => 'Team Member #2',
					],
					[
						'pr_team_slider_member_name' => 'Team Member #3',
					],
					[
						'pr_team_slider_member_name' => 'Team Member #4',
					],

				],
				'fields' => [
					[
						'name' => 'pr_team_slider_member_image',
						'label' => esc_html__( 'Team Member Avatar', 'pixerex' ),
						'type' => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'name' => 'pr_team_slider_member_name',
						'label' => esc_html__( 'Name', 'pixerex' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'John Doe', 'pixerex' ),
					],
					[
						'name' => 'pr_team_slider_member_job_title',
						'label' => esc_html__( 'Job Position', 'pixerex' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Software Engineer', 'pixerex' ),
					],
					[
						'name' => 'pr_team_slider_member_description',
						'label' => esc_html__( 'Description', 'pixerex' ),
						'type' => Controls_Manager::TEXTAREA,
						'rows' => '8',
						'default' => esc_html__( 'Add team member description here. Remove the text if not necessary.', 'pixerex' ),
					],
					[
						'name' => 'pr_team_slider_enable_social_links',
						'label' => esc_html__( 'Display Social Links?', 'pixerex' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => 'no',
					],
					[
						'name'        => 'facebook_url',
						'label'       => __( 'Facebook', 'pixerex' ),
						'type'        => Controls_Manager::TEXT,
                        'description' => __( 'Enter Facebook page or profile URL of team member', 'pixerex' ),
						'condition' => [
							'pr_team_slider_enable_social_links' => 'yes',
						],
					],
					[
						'name'        => 'twitter_url',
						'label'       => __( 'Twitter', 'pixerex' ),
						'type'        => Controls_Manager::TEXT,
						'description' => __( 'Enter Twitter profile URL of team member', 'pixerex' ),
						'condition' => [
							'pr_team_slider_enable_social_links' => 'yes',
						],
					],
					[
						'name'        => 'linkedin_url',
						'label'       => __( 'Linkedin', 'pixerex' ),
						'type'        => Controls_Manager::TEXT,
						'description' => __( 'Enter Linkedin profile URL of team member', 'pixerex' ),
						'condition' => [
							'pr_team_slider_enable_social_links' => 'yes',
						],
					],
					[
						'name'        => 'instagram_url',
						'label'       => __( 'Instagram', 'pixerex' ),
						'type'        => Controls_Manager::TEXT,
						'description' => __( 'Enter Instagram profile URL of team member', 'pixerex' ),
						'condition' => [
							'pr_team_slider_enable_social_links' => 'yes',
						],
					],
					[
						'name'        => 'youtube_url',
						'label'       => __( 'YouTube', 'pixerex' ),
						'type'        => Controls_Manager::TEXT,
						'description' => __( 'Enter YouTube profile URL of team member', 'pixerex' ),
						'condition' => [
							'pr_team_slider_enable_social_links' => 'yes',
						],
					],
					[
						'name'        => 'pinterest_url',
						'label'       => __( 'Pinterest', 'pixerex' ),
						'type'        => Controls_Manager::TEXT,
						'description' => __( 'Enter Pinterest profile URL of team member', 'pixerex' ),
						'condition' => [
							'pr_team_slider_enable_social_links' => 'yes',
						],
					],
					[
						'name'        => 'dribbble_url',
						'label'       => __( 'Dribbble', 'pixerex' ),
						'type'        => Controls_Manager::TEXT,
						'description' => __( 'Enter Dribbble profile URL of team member', 'pixerex' ),
						'condition' => [
							'pr_team_slider_enable_social_links' => 'yes',
						],
					],

				],
				'title_field' => 'Team Member',
			]
		);



		$this->end_controls_section();

		
		
		$this->start_controls_section(
			'pr_section_team_slider_settings',
			[
				'label' => esc_html__( 'Team Carousel Settings', 'pixerex' ),
			]
		);

		$this->add_responsive_control(
            'pr_team_slider_max_items',
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
		  'pr_team_slide_item',
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
		  'pr_team_slide_speed',
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
            'pr_team_slider_autoplay',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Autoplay?', 'pixerex'),
                'description' => __('Should the carousel autoplay as in a slideshow.', 'pixerex'),
            ]
        );

		$this->add_control(
			'pr_team_slider_pause_hover',
			[
				'label' => esc_html__( 'Pause on Hover?', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
            'pr_team_slide_draggable',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Draggable?', 'pixerex'),
            ]
		);

		$this->add_control(
            'pr_team_slide_infinite',
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
            'pr_team_slide_center_mode',
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
            'pr_team_arrows',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Arrows', 'pixerex'),
            ]
        );


        $this->add_control(
            'pr_team_dots',
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
			'pr_section_team_slider_members_styles_general',
			[
				'label' => esc_html__( 'General', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
  
  
		$this->add_control(
			'pr_team_slider_members_preset',
			[
				'label' => esc_html__( 'Style Preset', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'pr-team-members-simple',
				'options' => [
					'pr-team-members-simple' 		=> esc_html__( 'Simple Style', 		'pixerex' ),
					'pr-team-members-overlay' 	=> esc_html__( 'Overlay Style', 	'pixerex' ),
				],
			]
		);
  
		$this->add_control(
			'pr_team_slider_members_background',
			[
				'label' => esc_html__( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-team-item .pr-team-content' => 'background-color: {{VALUE}};',
				],
			]
		);
  
		$this->add_responsive_control(
			'pr_team_slider_members_alignment',
			[
				'label' => esc_html__( 'Set Alignment', 'pixerex' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon' => 'fa fa-align-left',
					],
					'centered' => [
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'pr-team-align-default',
				'prefix_class' => 'pr-team-align-',
				'condition' => [
				  'pr_team_slider_members_preset' => 'pr-team-members-simple',
			  ],
			]
		);

		$this->add_responsive_control(
			'pr_team_slider_members_margin',
			[
				'label' => esc_html__( 'Item Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'           => [
					'top'       => 0,
					'right'     => 10,
					'bottom'    => 0,
					'left'      => 10,
					'unit'      => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .pr-team-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
  
		$this->add_responsive_control(
			'pr_team_slider_members_cnt_padding',
			[
				'label' => esc_html__( 'Content Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-team-item .pr-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
  
		$this->start_controls_tabs( 'pr_team_slider_tabs_style' );

		$this->start_controls_tab(
			'pr_team_slider_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_team_slider_members_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-team-item',
			]
		);

		$this->add_control(
			'pr_team_slider_members_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .pr-team-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_team_slider_members_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .pr-team-item',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'pr_team_slider_members_style__hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_team_slider_members_border_hover',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-team-item:hover',
			]
		);

		$this->add_control(
			'pr_team_slider_members_border_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .pr-team-item:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_team_slider_members_box_shadow_hover',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .pr-team-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'pr_section_team_slider_members_image_styles',
			[
				'label' => esc_html__( 'Image', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);		
  
		$this->add_responsive_control(
			'pr_team_slider_members_image_width',
			[
				'label' => esc_html__( 'Image Width', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pr-team-item figure img' => 'width:{{SIZE}}{{UNIT}};',
				],
			]
		);
  
  
		$this->add_responsive_control(
			'pr_team_slider_members_image_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-team-item figure img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
  
		$this->add_responsive_control(
			'pr_team_slider_members_image_padding',
			[
				'label' => esc_html__( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-team-item figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
  
  
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_team_slider_members_image_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-team-item figure img',
			]
		);
  
		$this->add_control(
			'pr_team_slider_members_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .pr-team-item figure img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
  
		$this->end_controls_section();
  
		$this->start_controls_section(
		  'pr_team_name_style',
		  [
			  'label' => __( 'Name', 'pixerex' ),
			  'tab' => Controls_Manager::TAB_STYLE
		  ]
	  );
  
	  $this->add_control(
		  'pr_team_name_color',
		  [
			  'label' => __( 'Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default'=> '',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item .pr-team-member-name' => 'color: {{VALUE}};',
			  ]
		  ]
	  );
  
	  $this->add_group_control(
		  Group_Control_Typography::get_type(),
		  [
			  'name' => 'pr_team_name_typography',
			  'label' => __( 'Typography', 'pixerex' ),
			  'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			  'selector' => '{{WRAPPER}} .pr-team-item .pr-team-member-name',
		  ]
	  );
  
	  $this->add_responsive_control(
		  'pr_team_name_margin',
		  array(
			  'label'      => esc_html__( 'Margin', 'pixerex' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => array( 'px', '%', 'em' ),
			  'selectors'  => array(
				  '{{WRAPPER}} .pr-team-item .pr-team-member-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ),
		  )
	  );
  
	  $this->end_controls_section();
  
	  $this->start_controls_section(
		  'pr_team_job_style',
		  [
			  'label' => __( 'Job Position', 'pixerex' ),
			  'tab' => Controls_Manager::TAB_STYLE
		  ]
	  );
  
	  $this->add_control(
		  'pr_team_job_color',
		  [
			  'label' => __( 'Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default'=> '',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item .pr-team-member-position' => 'color: {{VALUE}};',
			  ]
		  ]
	  );
  
	  $this->add_group_control(
		  Group_Control_Typography::get_type(),
		  [
			  'name' => 'pr_team_job_typography',
			  'label' => __( 'Typography', 'pixerex' ),
			  'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			  'selector' => '{{WRAPPER}} .pr-team-item .pr-team-member-position',
		  ]
	  );
  
	  $this->add_responsive_control(
		  'pr_team_job_margin',
		  array(
			  'label'      => esc_html__( 'Margin', 'pixerex' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => array( 'px', '%', 'em' ),
			  'selectors'  => array(
				  '{{WRAPPER}} .pr-team-item .pr-team-member-position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ),
		  )
	  );
  
  
	  $this->end_controls_section();
  
	  $this->start_controls_section(
		  'pr_team_desc_style',
		  [
			  'label' => __( 'Description', 'pixerex' ),
			  'tab' => Controls_Manager::TAB_STYLE
		  ]
	  );
  
	  $this->add_control(
		  'pr_team_desc_color',
		  [
			  'label' => __( 'Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default'=> '',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item .pr-team-content .pr-team-text' => 'color: {{VALUE}};',
			  ]
		  ]
	  );
  
	  $this->add_group_control(
		  Group_Control_Typography::get_type(),
		  [
			  'name' => 'pr_team_desc_typography',
			  'label' => __( 'Typography', 'pixerex' ),
			  'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			  'selector' => '{{WRAPPER}} .pr-team-item .pr-team-content .pr-team-text',
		  ]
	  );
  
	  $this->add_responsive_control(
		  'pr_team_desc_margin',
		  array(
			  'label'      => esc_html__( 'Margin', 'pixerex' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => array( 'px', '%', 'em' ),
			  'selectors'  => array(
				  '{{WRAPPER}} .pr-team-item .pr-team-content .pr-team-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ),
		  )
	  );
  
  
	  $this->end_controls_section();
  
		
		$this->start_controls_section(
			'pr_section_team_slider_members_social_profiles_styles',
			[
				'label' => esc_html__( 'Social Icons', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);		
  
  
		$this->add_control(
			'pr_team_slider_members_social_icon_size',
			[
				'label' => esc_html__( 'Icon Box Size', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
				],
			]
		);
  
		$this->add_responsive_control(
			'pr_team_slider_members_social_profiles_padding',
			[
				'label' => esc_html__( 'Marging', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
  
  
		$this->start_controls_tabs( 'pr_team_slider_members_social_icons_style_tabs' );
  
		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'pixerex' ) ] );
  
		$this->add_control(
			'pr_team_slider_members_social_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_control(
			'pr_team_slider_members_social_icon_background',
			[
				'label' => esc_html__( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_team_slider_members_social_icon_border',
				'selector' => '{{WRAPPER}} .pr-team-member-social-link > a',
			]
		);
		
		$this->add_control(
			'pr_team_slider_members_social_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a' => 'border-radius: {{SIZE}}px;',
				],
			]
		);
  
		$this->add_responsive_control(
			'pr_team_slider_members_social_icon_typography',
			[
			  'label' => esc_html__( 'Font Size', 'pixerex' ),
			  'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a' => 'font-size: {{SIZE}}px;',
				  ],
			]
		);
  
		
		$this->end_controls_tab();
  
		$this->start_controls_tab( 'pr_team_slider_members_social_icon_hover', [ 'label' => esc_html__( 'Hover', 'pixerex' ) ] );
  
		$this->add_control(
			'pr_team_slider_members_social_icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ad8647',
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a:hover' => 'color: {{VALUE}};',
				],
			]
		);
  
		$this->add_control(
			'pr_team_slider_members_social_icon_hover_background',
			[
				'label' => esc_html__( 'Hover Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
  
		$this->add_control(
			'pr_team_slider_members_social_icon_hover_border_color',
			[
				'label' => esc_html__( 'Hover Border Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-team-member-social-link > a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();

	$this->start_controls_section(
			'pr_team_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_team_arrows' => 'yes',
				],
			]
		);

		$this->add_responsive_control('pr_team_arrows_font_size',
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
					'{{WRAPPER}} .pr-team-slider .slick-prev::before' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .pr-team-slider .slick-next::before' => 'font-size: {{SIZE}}px;',
				]
		  	]
		);

		$this->add_responsive_control('pr_team_arrows_bg_size',
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
					'{{WRAPPER}} .pr-team-slider .slick-prev' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
					'{{WRAPPER}} .pr-team-slider .slick-next' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				]
		  	]
		);
		
		$this->start_controls_tabs( 'pr_team_slider_arrows_style' );

		$this->start_controls_tab('pr_team_slider_arrows_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_control('pr_team_arrows_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-team-slider .slick-prev::before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .pr-team-slider .slick-next::before' => 'color: {{VALUE}};',
                        ]
                    ]
        );

		$this->add_control('pr_team_arrows_back_color',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-team-slider .slick-prev'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .pr-team-slider .slick-next'  => 'background-color: {{VALUE}};',
                        ]
                    ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_team_arrows_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-team-slider .slick-prev, .pr-team-slider .slick-next',
			]
		);
		
        
        $this->add_control('pr_team_arrows_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' , 'em'],
                    'selectors'     => [
						'{{WRAPPER}} .pr-team-slider .slick-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .pr-team-slider .slick-next' => 'border-radius: {{SIZE}}{{UNIT}};',
                    ],
                ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('pr_team_slider_arrows_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_control('pr_team_arrows_color_hover',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-team-slider .slick-prev:hover.slick-prev:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .pr-team-slider .slick-next:hover.slick-next:before' => 'color: {{VALUE}};',
                        ]
                    ]
        );

		$this->add_control('pr_team_arrows_back_color_hover',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-team-slider .slick-prev:hover'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .pr-team-slider .slick-next:hover'  => 'background-color: {{VALUE}};',
                        ]
                    ]
		);

		$this->add_control('pr_team_arrows_border_color_hover',
                [
                    'label'         => esc_html__('Border Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-team-slider .slick-prev:hover'  => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .pr-team-slider .slick-next:hover'  => 'border-color: {{VALUE}};',
                        ]
                    ]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();
        

	$this->end_controls_section();

		$this->start_controls_section(
			'pr_team_slider_navigation_style',
			[
				'label' => esc_html__( 'Dots', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_team_dots' => 'yes',
				],
			]
		);

		$this->add_control(
			'pr_team_navigation_bg',
			[
				'label' => esc_html__( 'Dots Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .pr-team-slider .slick-dots li button::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pr-team-slider .slick-dots li.slick-active button::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_team_slider_bullet_vspacing',
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
		
		$this->add_responsive_control(
			'pr_team_slider_bullet_size',
			[
				'label' => esc_html__( 'Bullet Size', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 12,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pr-team-slider .slick-dots li button::before' => 'font-size:{{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'pr_team_slider_active_bullet_size',
			[
				'label' => esc_html__( 'Active Bullet Size', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 18,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pr-team-slider .slick-dots li.slick-active button::before' => 'font-size:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	}


	protected function render( ) {
		
		$settings = $this->get_settings();
		$items = $settings['pr_team_member_slider_item'];
		$team_member_classes = $this->get_settings('pr_team_slider_members_preset');

		$pr_team_carousel_settings = [
			'pr_team_arrows' => ('yes' === $settings['pr_team_arrows']),
			'pr_team_dots' => ('yes' === $settings['pr_team_dots']),
			'pr_team_slider_autoplay' => ('yes' === $settings['pr_team_slider_autoplay']),
			'pr_team_slide_draggable' => ('yes' === $settings['pr_team_slide_draggable']),
			'pr_team_slide_speed' => absint($settings['pr_team_slide_speed']),
			'pr_team_slider_pause_hover' => ('yes' === $settings['pr_team_slider_pause_hover']),
			'pr_team_slider_max_items' => $settings['pr_team_slider_max_items']['size'],
			'pr_team_max_tab_item' => $settings['pr_team_slider_max_items_tablet']['size'],
			'pr_team_max_mobile_item' => $settings['pr_team_slider_max_items_mobile']['size'],
			'pr_team_slide_item' => $settings['pr_team_slide_item'],
			'pr_team_slide_center_mode' => ('yes' === $settings['pr_team_slide_center_mode']),
			'pr_team_slide_infinite' => ('yes' === $settings['pr_team_slide_infinite']),
		];
	?>
		<div id="pr-team-member-<?php echo esc_attr($this->get_id()); ?>" 
			class="pr-team-slider"
			data-settings='<?php echo wp_json_encode($pr_team_carousel_settings); ?>'>

			<?php foreach ( $items as $item ) : ?>
				<div class="pr-team-item <?php echo $team_member_classes; ?>">
					<div class="pr-team-item-inner">
						<div class="pr-team-image">
							<figure>
								<?php $image = $item['pr_team_slider_member_image']; ?>
								<img src="<?php echo $image['url'];?>" alt="<?php echo $settings['pr_team_slider_member_name'];?>">
							</figure>
						</div>

						<div class="pr-team-content">
							<h3 class="pr-team-member-name"><?php echo $item['pr_team_slider_member_name']; ?></h3>
							<h4 class="pr-team-member-position"><?php echo $item['pr_team_slider_member_job_title']; ?></h4>
							<?php if ( ! empty( $item['pr_team_slider_member_description'] ) ): ?>
								<p class="pr-team-text"><?php echo $item['pr_team_slider_member_description']; ?></p>
							<?php endif; ?>
							<?php if ( $item['pr_team_slider_enable_social_links'] == 'yes' ) : ?>
								<?php 
									$facebook_url       = $item['facebook_url'];
									$twitter_url        = $item['twitter_url'];
									$linkedin_url       = $item['linkedin_url'];
									$instagram_url      = $item['instagram_url'];
									$youtube_url        = $item['youtube_url'];
									$pinterest_url      = $item['pinterest_url'];
									$dribbble_url       = $item['dribbble_url'];
								?>
								<ul class="pr-team-member-social-profiles">
								<?php
									if ( $facebook_url ) {
										printf( '<li class="pr-team-member-social-link"><a href="%1$s"><i class="fa fa-facebook"></i></a></li>', esc_url( $facebook_url )  );
									}
									if ( $twitter_url ) {
										printf( '<li class="pr-team-member-social-link"><a href="%1$s"><i class="fa fa-twitter"></i></a></li>', esc_url( $twitter_url )  );
									}
									if ( $linkedin_url ) {
										printf( '<li class="pr-team-member-social-link"><a href="%1$s"><i class="fa fa-linkedin"></i></a></li>', esc_url( $linkedin_url )  );
									}
									if ( $instagram_url ) {
										printf( '<li class="pr-team-member-social-link"><a href="%1$s"><i class="fa fa-instagram"></i></a></li>', esc_url( $instagram_url )  );
									}
									if ( $youtube_url ) {
										printf( '<li class="pr-team-member-social-link"><a href="%1$s"><i class="fa fa-youtube"></i></a></li>', esc_url( $youtube_url )  );
									}
									if ( $pinterest_url ) {
										printf( '<li class="pr-team-member-social-link"><a href="%1$s"><i class="fa fa-pinterest"></i></a></li>', esc_url( $pinterest_url )  );
									}
									if ( $dribbble_url ) {
										printf( '<li class="pr-team-member-social-link"><a href="%1$s"><i class="fa fa-dribbble"></i></a></li>', esc_url( $dribbble_url )  );
									}
								?>
								</ul>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	<?php
	
	}

	protected function content_template() {
		
		?>
		
	
		<?php
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new PR_PersonCarousel_Widget() );