<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class pr_infobox_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-infobox';
	}

	public function get_title() {
		return __( 'Infobox', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }
	protected function _register_controls() {

  		/**
  		 * Infobox Image Settings
  		 */
  		$this->start_controls_section(
  			'pr_section_infobox_content_settings',
  			[
  				'label' => esc_html__( 'Icon', 'pixerex' )
  			]
  		);

		$this->add_responsive_control(
			'pr_infobox_img_or_icon',
			[
				'label' => esc_html__( 'Icon Type', 'pixerex' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'pixerex' ),
						'icon' => 'fa fa-info-circle',
					],
					'img' => [
						'title' => esc_html__( 'Image', 'pixerex' ),
						'icon' => 'fa fa-picture-o',
					],
					'number' => [
						'title' => esc_html__( 'Number', 'pixerex' ),
						'icon' => 'fa fa-sort-numeric-desc',
					],
					'none' => [
						'title' => esc_html__( 'None', 'pixerex' ),
						'icon' => 'fa fa-ban',
					]
				],
				'default' => 'icon',
			]
		);

		/**
		 * Condition: 'pr_infobox_img_or_icon' => 'img'
		 */
		$this->add_control(
			'pr_infobox_image',
			[
				'label' => esc_html__( 'Infobox Image', 'pixerex' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'pr_infobox_img_or_icon' => 'img'
				]
			]
		);


		/**
		 * Condition: 'pr_infobox_img_or_icon' => 'icon'
		 */
		$this->add_control(
			'pr_infobox_icon',
			[
				'label' => esc_html__( 'Icon', 'pixerex' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-building-o',
				'condition' => [
					'pr_infobox_img_or_icon' => 'icon'
				]
			]
		);

		/**
		 * Condition: 'pr_infobox_img_or_icon' => 'number'
		 */
		$this->add_control(
			'pr_infobox_number',
			[
				'label' => esc_html__( 'Number', 'pixerex' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'pr_infobox_img_or_icon' => 'number'
				]
			]
		);

		$this->add_control(
			'pr_infobox_img_type',
				[
				 'label'       	=> esc_html__( 'Icon Position', 'pixerex' ),
				   'type' 			=> Controls_Manager::SELECT,
				   'default' 		=> 'img-on-top',
				   'label_block' 	=> false,
				   'options' 		=> [
					   'img-on-top'  	=> esc_html__( 'On Top', 'pixerex' ),
					   'img-on-left' 	=> esc_html__( 'On Left', 'pixerex' ),
					   'img-on-right' 	=> esc_html__( 'On Right', 'pixerex' ),
				   ],
				]
		  );

		$this->end_controls_section();

		/**
		 * Infobox Content
		 */
		$this->start_controls_section(
			'pr_infobox_content',
			[
				'label' => esc_html__( 'Content', 'pixerex' ),
			]
		);
		$this->add_control(
			'pr_infobox_title',
			[
				'label' => esc_html__( 'Infobox Title', 'pixerex' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true
				],
				'default' => esc_html__( 'This is an icon box', 'pixerex' )
			]
		);
		$this->add_control(
			'pr_infobox_hr',
			[
				'label' => __( 'Show Title Divider', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __( 'Show', 'pixerex' ),
				'label_off' => __( 'Hide', 'pixerex' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'pr_infobox_text',
			[
			  'label' => esc_html__( 'Description', 'pixerex' ),
			  'type' => Controls_Manager::TEXTAREA,
			  'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'pixerex' ),
			]
		);
		$this->add_control(
			'pr_show_infobox_content',
			[
				'label' => __( 'Show Content', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Show', 'pixerex' ),
				'label_off' => __( 'Hide', 'pixerex' ),
				'return_value' => 'yes',
			]
		);
		$this->add_responsive_control(
			'pr_infobox_content_alignment',
			[
				'label' => esc_html__( 'Content Alignment', 'pixerex' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'pr-infobox-content-align-',
				'condition' => [
					'pr_infobox_img_type' => 'img-on-top'
				]
			]
		);

		$this->add_control(
			'pr_infobox_title_tag',
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


/**
 * -----------------------------------------------------------------------------------------------------
 * Infobox Button
 * -----------------------------------------------------------------------------------------------------
 */
		$this->start_controls_section(
			'pr_infobox_button',
			[
				'label' => esc_html__( 'Button', 'pixerex' )
			]
		);

		$this->add_control(
			'pr_show_infobox_button',
			[
				'label' => __( 'Show Infobox Button', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'pixerex' ),
				'label_off' => __( 'No', 'pixerex' ),
				'condition'	=> [
					'pr_show_infobox_clickable!'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'pr_show_infobox_clickable',
			[
				'label' => __( 'Infobox Clickable', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __( 'Yes', 'pixerex' ),
				'label_off' => __( 'No', 'pixerex' ),
				'return_value' => 'yes',
				'condition'	=> [
					'pr_show_infobox_button!'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'pr_show_infobox_clickable_link',
			[
				'label' => esc_html__( 'Infobox Link', 'pixerex' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
        			'url' => 'http://',
        			'is_external' => '',
     			],
     			'show_external' => true,
     			'condition' => [
     				'pr_show_infobox_clickable' => 'yes'
     			]
			]
		);

		$this->add_control(
			'pr_show_infobox_icon_onhover',
			[
				'label' => __( 'Show icon on Hover', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __( 'Yes', 'pixerex' ),
				'label_off' => __( 'No', 'pixerex' ),
				'return_value' => 'yes',
				'condition' => [
					'pr_show_infobox_clickable' => 'yes'
				]
			]
		);

		$this->add_control(
			'infobox_button_text',
			[
				'label' => __( 'Button Text', 'pixerex' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Learn more',
				'separator'	=> 'before',
				'placeholder' => __( 'Enter button text', 'pixerex' ),
				'title' => __( 'Enter button text here', 'pixerex' ),
				'condition'	=> [
					'pr_show_infobox_button'	=> 'yes',
				]
			]
		);

		$this->add_control(
			'infobox_button_link_url',
			[
				'label' => __( 'Link URL', 'pixerex' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => __( 'Enter link URL for the button', 'pixerex' ),
				'show_external'	=> true,
				'default'		=> [
					'url'	=> '#'
				],
				'title' => __( 'Enter heading for the button', 'pixerex' ),
				'condition'	=> [
					'pr_show_infobox_button'	=> 'yes'
				]
			]
		);
		
		$this->add_control(
			'pr_infobox_button_icon',
			[
				'label' => esc_html__( 'Icon', 'pixerex' ),
				'type' => Controls_Manager::ICON,
				'condition'	=> [
					'pr_show_infobox_button'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'pr_infobox_button_icon_alignment',
			[
				'label' => esc_html__( 'Icon Position', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'pixerex' ),
					'right' => esc_html__( 'After', 'pixerex' ),
				],
				'condition' => [
					'pr_infobox_button_icon!' => '',
					'pr_show_infobox_button'	=> 'yes'
				],
			]
		);

		$this->add_control(
			'pr_infobox_button_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 60,
					],
				],
				'condition' => [
					'pr_infobox_button_icon!' => '',
					'pr_show_infobox_button'	=> 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .pr_infobox_button_icon_right' => 'margin-left: {{SIZE}}px;',
					'{{WRAPPER}} .pr_infobox_button_icon_left' => 'margin-right: {{SIZE}}px;',
				],
			]
		);

		// infobox on hover icon

		$this->add_control(
			'pr_infobox_on_hover_icon',
			[
				'label' => esc_html__( 'Icon', 'pixerex' ),
				'type' => Controls_Manager::ICON,
				'condition'	=> [
					'pr_show_infobox_icon_onhover'	=> 'yes'
				]
			]
		);
		$this->end_controls_section();

/**
 * -----------------------------------------------------------------------------------------------------
 * Tab Style (Info Box Image)
 * -----------------------------------------------------------------------------------------------------
 */

		$this->start_controls_section(
			'pr_section_infobox_imgae_style_settings',
			[
				'label' => esc_html__( 'Icon', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
		     		'pr_infobox_img_or_icon' => 'img'
		     	]
			]
		);

		$this->start_controls_tabs('pr_infobox_image_style');
			
			$this->start_controls_tab(
				'pr_infobox_image_icon_normal',
				[
					'label'		=> __( 'Normal', 'pixerex' )
				]
			);

				$this->add_control(
					'pr_infobox_image_icon_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .pr-infobox .infobox-icon img' => 'background-color: {{VALUE}};',
						]
					]
				);

				$this->add_responsive_control(
					'pr_infobox_image_icon_padding',
					[
						'label' => esc_html__( 'Padding', 'pixerex' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
							'{{WRAPPER}} .pr-infobox .infobox-icon img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						 ],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
						[
							'name' => 'pr_infobox_image_border',
							'label' => esc_html__( 'Border', 'pixerex' ),
							'selector' => '{{WRAPPER}} .pr-infobox .infobox-icon img'
						]
				);
		
				$this->add_control(
				'pr_infobox_img_shape',
					[
					'label'     	=> esc_html__( 'Image Shape', 'pixerex' ),
						'type' 			=> Controls_Manager::SELECT,
						'default' 		=> 'square',
						'label_block' 	=> false,
						'options' 		=> [
							'square'  	=> esc_html__( 'Square', 'pixerex' ),
							'circle' 	=> esc_html__( 'Circle', 'pixerex' ),
							'radius' 	=> esc_html__( 'Radius', 'pixerex' ),
						],
						'prefix_class' => 'pr-infobox-shape-',
						'condition' => [
							'pr_infobox_img_or_icon' => 'img'
						]
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'pr_infobox_image_icon_hover',
				[
					'label'		=> __( 'Hover', 'pixerex' )
				]
			);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'pr_infobox_image_icon_hover_shadow',
						'selectors' => [
							'{{WRAPPER}} .pr-infobox .infobox-icon:hover img' => 'background-color: {{VALUE}};',
						]
					]
				);

				$this->add_control(
					'pr_infobox_image_icon_hover_animation',
					[
						'label' => esc_html__( 'Animation', 'pixerex' ),
						'type' => Controls_Manager::HOVER_ANIMATION
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
						[
							'name' => 'pr_infobox_hover_image_border',
							'label' => esc_html__( 'Border', 'pixerex' ),
							'selector' => '{{WRAPPER}} .pr-infobox:hover .infobox-icon img'
						]
				);
		
				$this->add_control(
				'pr_infobox_hover_img_shape',
					[
					'label'     	=> esc_html__( 'Image Shape', 'pixerex' ),
						'type' 			=> Controls_Manager::SELECT,
						'default' 		=> 'square',
						'label_block' 	=> false,
						'options' 		=> [
							'square'  	=> esc_html__( 'Square', 'pixerex' ),
							'circle' 	=> esc_html__( 'Circle', 'pixerex' ),
							'radius' 	=> esc_html__( 'Radius', 'pixerex' ),
						],
						'prefix_class' => 'pr-infobox-hover-img-shape-',
						'condition' => [
							'pr_infobox_img_or_icon' => 'img'
						]
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'pr_infobox_image_resizer',
			[
				'label' => esc_html__( 'Image Resizer', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100
				],
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-infobox .infobox-icon img' => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .pr-infobox.icon-on-left .infobox-icon' => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .pr-infobox.icon-on-right .infobox-icon' => 'width: {{SIZE}}px;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'condition' => [
					'pr_infobox_image[url]!' => '',
				],
				'condition' => [
					'pr_infobox_img_or_icon' => 'img',
				]
			]
		);

		$this->add_responsive_control(
			'pr_infobox_img_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .pr-infobox .infobox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->end_controls_section();
/**
 * -----------------------------------------------------------------------------------------------------
 * Tab Style (Info Box Number Icon Style)
 * -----------------------------------------------------------------------------------------------------
 */
		$this->start_controls_section(
			'pr_section_infobox_number_icon_style_settings',
			[
				'label' => esc_html__( 'Icon', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
		     		'pr_infobox_img_or_icon' => 'number'
		     	]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
			'name' => 'pr_infobox_number_icon_typography',
				'selector' => '{{WRAPPER}} .pr-infobox .infobox-icon .infobox-icon-number',
			]
		);

		$this->add_responsive_control(
    		'pr_infobox_number_icon_bg_size',
    		[
        		'label' => __( 'Icon Background Size', 'pixerex' ),
       			'type' => Controls_Manager::SLIDER,
        		'default' => [
            		'size' => 90,
        		],
        		'range' => [
            		'px' => [
                		'min' => 0,
                		'max' => 300,
                		'step' => 1,
            		]
        		],
        		'selectors' => [
            		'{{WRAPPER}} .pr-infobox .infobox-icon .infobox-icon-wrap' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
        		],
        		'condition' => [
					'pr_infobox_icon_bg_shape!' => 'none'
				]
    		]
		);

		$this->add_responsive_control(
			'pr_infobox_number_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .pr-infobox .infobox-icon-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->start_controls_tabs( 'pr_infobox_numbericon_style_controls' );

			$this->start_controls_tab(
				'pr_infobox_number_icon_normal',
				[
					'label'		=> esc_html__( 'Normal', 'pixerex' ),
				]
			);

				$this->add_control(
					'pr_infobox_number_icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#4d4d4d',
						'selectors' => [
							'{{WRAPPER}} .pr-infobox .infobox-icon .infobox-icon-number' => 'color: {{VALUE}};',
							'{{WRAPPER}} .pr-infobox.icon-beside-title .infobox-content .title figure .infobox-icon-number' => 'color: {{VALUE}};',
						],
					]
				);
		
				$this->add_control(
					'pr_infobox_number_icon_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .pr-infobox .infobox-icon .infobox-icon-wrap' => 'background: {{VALUE}};',
						],
						'condition' => [
							'pr_infobox_icon_bg_shape!' => 'none',
						]
					]
				);
		
				$this->add_control(
				'pr_infobox_number_icon_bg_shape',
					[
					'label'     	=> esc_html__( 'Background Shape', 'pixerex' ),
						'type' 			=> Controls_Manager::SELECT,
						'default' 		=> 'none',
						'label_block' 	=> false,
						'options' 		=> [
							'none'  	=> esc_html__( 'None', 'pixerex' ),
							'circle' 	=> esc_html__( 'Circle', 'pixerex' ),
							'radius' 	=> esc_html__( 'Radius', 'pixerex' ),
							'square' 	=> esc_html__( 'Square', 'pixerex' ),
						],
						'prefix_class' => 'pr-infobox-icon-bg-shape-'
					]
				);
		
				$this->add_group_control(
					Group_Control_Border::get_type(),
						[
							'name' => 'pr_infobox_number_icon_border',
							'label' => esc_html__( 'Border', 'pixerex' ),
							'selector' => '{{WRAPPER}} .pr-infobox .infobox-icon-wrap'
						]
				);
		
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'pr_infobox_number_icon_shadow',
						'selector' => '{{WRAPPER}} .pr-infobox .infobox-icon-wrap',
					]
				);

			$this->end_controls_tab();


			$this->start_controls_tab(
				'pr_infobox_number_icon_hover',
				[
					'label'		=> esc_html__( 'Hover', 'pixerex' ),
				]
			);

			$this->add_control(
				'pr_infobox_number_icon_hover_animation',
				[
					'label' => esc_html__( 'Animation', 'pixerex' ),
					'type' => Controls_Manager::HOVER_ANIMATION
				]
			);

			$this->add_control(
				'pr_infobox_number_icon_hover_color',
				[
					'label' => esc_html__( 'Icon Color', 'pixerex' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#4d4d4d',
					'selectors' => [
						'{{WRAPPER}} .pr-infobox:hover .infobox-icon .infobox-icon-number' => 'color: {{VALUE}};',
						'{{WRAPPER}} .pr-infobox.icon-beside-title:hover .infobox-content .title figure .infobox-icon-number' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'pr_infobox_number_icon_hover_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'pixerex' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .pr-infobox:hover .infobox-icon .infobox-icon-wrap' => 'background: {{VALUE}};',
					],
					'condition' => [
						'pr_infobox_img_type!' => ['img-on-left', 'img-on-right'],
						'pr_infobox_icon_bg_shape!' => 'none',
					]
				]
			);

			$this->add_control(
			'pr_infobox_number_icon_hover_bg_shape',
				[
				'label'     	=> esc_html__( 'Background Shape', 'pixerex' ),
					'type' 			=> Controls_Manager::SELECT,
					'default' 		=> 'none',
					'label_block' 	=> false,
					'options' 		=> [
						'none'  	=> esc_html__( 'None', 'pixerex' ),
						'circle' 	=> esc_html__( 'Circle', 'pixerex' ),
						'radius' 	=> esc_html__( 'Radius', 'pixerex' ),
						'square' 	=> esc_html__( 'Square', 'pixerex' ),
					],
					'prefix_class' => 'pr-infobox-icon-hover-bg-shape-',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
					[
						'name' => 'pr_infobox_hover_number_icon_border',
						'label' => esc_html__( 'Border', 'pixerex' ),
						'selector' => '{{WRAPPER}} .pr-infobox:hover .infobox-icon-wrap'
					]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'pr_infobox_number_icon_hover_shadow',
					'selector' => '{{WRAPPER}} .pr-infobox:hover .infobox-icon-wrap',
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

/**
 * -----------------------------------------------------------------------------------------------------
 * Tab Style (Info Box Style)
 * -----------------------------------------------------------------------------------------------------
 */

		$this->start_controls_section(
			'pr_section_infobox_style_settings',
			[
				'label' => esc_html__( 'Infobox', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// start controls tabs

		$this->start_controls_tabs('info_box_style_tabs');

			// start normal state tab
			$this->start_controls_tab('info_box_style_tabs_normal', [
				'label' => esc_html__( 'Normal', 'pixerex' )
			]);

			$this->add_responsive_control(
				'pr_infobox_container_padding',
				[
					'label' => esc_html__( 'Padding', 'pixerex' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
							'{{WRAPPER}} .pr-infobox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'pr_info_box_translate_y',
				[
					'label'		=> esc_html__( 'Content Vertical Position', 'pixerex' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
					'size' => 40,
					],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 1,
						]
					],
					'condition'	=> [
						'pr_show_infobox_icon_onhover'	=> 'yes'
					],
					'selectors'	=> [
						'{{WRAPPER}} .pr-infobox .infobox-content' => 'transform: translateY({{SIZE}}px);',
					]
				]
			);

			$this->end_controls_tab();

			// start hover state tab
			$this->start_controls_tab('info_box_style_tabs_hover', [
				'label' => esc_html__( 'Hover', 'pixerex' )
			]);

			$this->add_responsive_control(
				'pr_infobox_container_padding_hover',
				[
					'label' => esc_html__( 'Padding', 'pixerex' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
							'{{WRAPPER}} .pr-infobox:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'pr_info_box_translate_y_hover',
				[
					'label'		   => esc_html__( 'Vertical Position', 'pixerex' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
					'size' => 40,
					],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 1,
						]
					],
					'condition'	=> [
						'pr_show_infobox_icon_onhover'	=> 'yes'
					],
					'selectors'	=> [
						'{{WRAPPER}} .pr-infobox:hover .infobox-content' => 'transform: translateY({{SIZE}}px);',
					]
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

/**
 * -----------------------------------------------------------------------------------------------------
 * Tab Style (Info Box Icon Style)
 * -----------------------------------------------------------------------------------------------------
 */
			
		$this->start_controls_section(
			'pr_section_infobox_icon_style_settings',
			[
				'label' => esc_html__( 'Icon', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
		     		'pr_infobox_img_or_icon' => 'icon'
		     	]
			]
		);

		$this->add_responsive_control(
    		'pr_infobox_icon_size',
    		[
        		'label' => __( 'Icon Size', 'pixerex' ),
       			'type' => Controls_Manager::SLIDER,
        		'default' => [
            	'size' => 40,
        		],
        		'range' => [
            	'px' => [
                	'min' => 20,
                	'max' => 100,
                	'step' => 1,
            	]
        		],
        		'selectors' => [
            	'{{WRAPPER}} .pr-infobox .infobox-icon i' => 'font-size: {{SIZE}}px;',
        		],
    		]
		);

		$this->add_responsive_control(
    		'pr_infobox_icon_bg_size',
    		[
        		'label' => __( 'Icon Background Size', 'pixerex' ),
       			'type' => Controls_Manager::SLIDER,
        		'default' => [
            		'size' => 90,
        		],
        		'range' => [
            		'px' => [
                		'min' => 0,
                		'max' => 300,
                		'step' => 1,
            		]
        		],
        		'selectors' => [
            		'{{WRAPPER}} .pr-infobox .infobox-icon .infobox-icon-wrap' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
        		],
        		'condition' => [
					'pr_infobox_icon_bg_shape!' => 'none'
				]
    		]
		);

		$this->add_responsive_control(
			'pr_infobox_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .pr-infobox .infobox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

			$this->start_controls_tabs( 'pr_infobox_icon_style_controls' );

				$this->start_controls_tab(
					'pr_infobox_icon_normal',
					[
						'label'		=> esc_html__( 'Normal', 'pixerex' ),
					]
				);


					$this->add_control(
						'pr_infobox_icon_translate_y',
						[
							'label'		=> esc_html__( 'icon Vertical Position', 'pixerex' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => array( 'px' ),
							'default' => [
							'size' => 10,
							],
							'range' => [
								'px' => [
									'min' => -200,
									'max' => 200,
									'step' => 1,
								]
							],
							'condition'	=> [
								'pr_show_infobox_icon_onhover'	=> 'yes'
							],
							'selectors'	=> [
								'{{WRAPPER}} .pr-infobox .infobox-icon' => 'transform: translateY({{SIZE}}px);',
							]
						]
					);

					$this->add_control(
						'pr_infobox_icon_color',
						[
							'label' => esc_html__( 'Icon Color', 'pixerex' ),
							'type' => Controls_Manager::COLOR,
							'default' => '#4d4d4d',
							'selectors' => [
								'{{WRAPPER}} .pr-infobox .infobox-icon i' => 'color: {{VALUE}};',
								'{{WRAPPER}} .pr-infobox.icon-beside-title .infobox-content .title figure i' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'pr_infobox_icon_bg_shape',
						[
						'label'     	=> esc_html__( 'Background Shape', 'pixerex' ),
							'type' 			=> Controls_Manager::SELECT,
							'default' 		=> 'none',
							'label_block' 	=> false,
							'options' 		=> [
								'none'  	=> esc_html__( 'None', 'pixerex' ),
								'circle' 	=> esc_html__( 'Circle', 'pixerex' ),
								'radius' 	=> esc_html__( 'Radius', 'pixerex' ),
								'square' 	=> esc_html__( 'Square', 'pixerex' ),
							],
							'prefix_class' => 'pr-infobox-icon-bg-shape-'
						]
					);
			
					$this->add_control(
						'pr_infobox_icon_bg_color',
						[
							'label' => esc_html__( 'Background Color', 'pixerex' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .pr-infobox .infobox-icon .infobox-icon-wrap' => 'background: {{VALUE}};',
							],
							'condition' => [
								'pr_infobox_icon_bg_shape!' => 'none',
							]
						]
					);
			
					$this->add_group_control(
						Group_Control_Border::get_type(),
							[
								'name' => 'pr_infobox_icon_border',
								'label' => esc_html__( 'Border', 'pixerex' ),
								'selector' => '{{WRAPPER}} .pr-infobox .infobox-icon-wrap'
							]
					);
			
					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'pr_infobox_icon_shadow',
							'selector' => '{{WRAPPER}} .pr-infobox .infobox-icon-wrap',
						]
					);

				$this->end_controls_tab();


				$this->start_controls_tab(
					'pr_infobox_icon_hover',
					[
						'label'		=> esc_html__( 'Hover', 'pixerex' ),
					]
				);

				$this->add_control(
					'pr_infobox_icon_translate_y_hover',
					[
						'label'		=> esc_html__( 'icon Vertical Position', 'pixerex' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => array( 'px' ),
						'default' => [
						'size' => 10,
						],
						'range' => [
							'px' => [
								'min' => -200,
								'max' => 200,
								'step' => 1,
							]
						],
						'condition'	=> [
							'pr_show_infobox_icon_onhover'	=> 'yes'
						],
						'selectors'	=> [
							'{{WRAPPER}} .pr-infobox:hover .infobox-icon' => 'transform: translateY({{SIZE}}px);',
						]
					]
				);


				$this->add_control(
					'pr_infobox_icon_hover_animation',
					[
						'label' => esc_html__( 'Animation', 'pixerex' ),
						'type' => Controls_Manager::HOVER_ANIMATION
					]
				);

				$this->add_control(
					'pr_infobox_icon_hover_color',
					[
						'label' => esc_html__( 'Icon Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#4d4d4d',
						'selectors' => [
							'{{WRAPPER}} .pr-infobox:hover .infobox-icon i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .pr-infobox.icon-beside-title:hover .infobox-content .title figure i' => 'color: {{VALUE}};',
						],
					]
				);
		
				$this->add_control(
					'pr_infobox_icon_hover_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .pr-infobox:hover .infobox-icon .infobox-icon-wrap' => 'background: {{VALUE}};',
						],
						'condition' => [
							'pr_infobox_img_type!' => ['img-on-left', 'img-on-right'],
							'pr_infobox_icon_bg_shape!' => 'none',
						]
					]
				);
		
				$this->add_control(
				  'pr_infobox_icon_hover_bg_shape',
					  [
					   'label'     	=> esc_html__( 'Background Shape', 'pixerex' ),
						 'type' 			=> Controls_Manager::SELECT,
						 'default' 		=> 'none',
						 'label_block' 	=> false,
						 'options' 		=> [
							 'none'  	=> esc_html__( 'None', 'pixerex' ),
							 'circle' 	=> esc_html__( 'Circle', 'pixerex' ),
							 'radius' 	=> esc_html__( 'Radius', 'pixerex' ),
							 'square' 	=> esc_html__( 'Square', 'pixerex' ),
						 ],
						 'prefix_class' => 'pr-infobox-icon-hover-bg-shape-',
					  ]
				);
		
				$this->add_group_control(
					Group_Control_Border::get_type(),
						[
							'name' => 'pr_infobox_hover_icon_border',
							'label' => esc_html__( 'Border', 'pixerex' ),
							'selector' => '{{WRAPPER}} .pr-infobox:hover .infobox-icon-wrap'
						]
				);
		
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'pr_infobox_icon_hover_shadow',
						'selector' => '{{WRAPPER}} .pr-infobox:hover .infobox-icon-wrap',
					]
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
/**
 * -----------------------------------------------------------------------------------------------------
 * Tab Style (Info Box Title Style)
 * -----------------------------------------------------------------------------------------------------
 */

		$this->start_controls_section(
			'pr_section_infobox_title_style',
			[
				'label' => esc_html__( 'Title', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs('infobox_title_style_tabs');

			$this->start_controls_tab('infobox_title_normal_style', [
				'label'	=> esc_html__( 'Normal', 'pixerex' )
			]);
	
			$this->add_control(
				'pr_infobox_title_color',
				[
					'label' => esc_html__( 'Color', 'pixerex' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#4d4d4d',
					'selectors' => [
						'{{WRAPPER}} .pr-infobox .infobox-content .title' => 'color: {{VALUE}};',
					],
				]
			);
	
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
				'name' => 'pr_infobox_title_typography',
					'selector' => '{{WRAPPER}} .pr-infobox .infobox-content .title',
				]
			);
	
			$this->add_responsive_control(
				'pr_infobox_title_margin',
				[
					'label' => esc_html__( 'Margin', 'pixerex' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
							'{{WRAPPER}} .pr-infobox .infobox-content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

			// Hover Style Tab For Infobox Title

			$this->start_controls_tab('infobox_title_hover_style', [
				'label'	=> esc_html__( 'Hover', 'pixerex' )
			]);

			$this->add_control(
				'pr_infobox_title_hover_color',
				[
					'label' => esc_html__( 'Title Color', 'pixerex' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .pr-infobox:hover .infobox-content .title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'pr_infobox_title_transition',
				[
					'label'		=> esc_html__( 'Transition', 'pixerex' ),
					'description'		=> esc_html__( 'Transition will applied to ms (ex: 300ms).', 'pixerex' ),
					'type'		=> Controls_Manager::NUMBER,
					'separator'	=> 'before',
					'min'		=> 100,
					'max'		=> 1000,
					'default'	=> 100,
					'selectors'	=> [
						'{{WRAPPER}} .pr-infobox:hover .infobox-content .title' => 'transition: {{SIZE}}ms;',
						'{{WRAPPER}} .pr-infobox:hover .infobox-content hr.pr-infobox-hr' => 'transition: {{SIZE}}ms;',
					]
				]
			);
			
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Divider Style Settings

		$this->start_controls_section(
			'pr_section_infobox_divider_style_settings',
			[
				'label' => esc_html__( 'Divider', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_infobox_hr'  => 'yes',
				],
			]
		);

		$this->start_controls_tabs('infobox_divider_style_tabs');
			$this->start_controls_tab('infobox_divider_normal_style', [
				'label'	=> esc_html__( 'Normal', 'pixerex' )
			]);

			$this->add_control(
				'pr_infobox_title_hr_color',
				[
					'label' => esc_html__( 'Color', 'pixerex' ),
					'type' => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					),
					'selectors' => [
						'{{WRAPPER}} .pr-infobox .infobox-content hr.pr-infobox-hr' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control('pr_infobox_title_hr_height',
                [
                    'label'         => esc_html__('Height', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-infobox .infobox-content hr.pr-infobox-hr' => 'height: {{SIZE}}{{UNIT}};'
                    ]
                ]
			);

			$this->add_control('pr_infobox_title_hr_width',
                [
                    'label'         => esc_html__('Width', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
					'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-infobox .infobox-content hr.pr-infobox-hr' => 'width: {{SIZE}}{{UNIT}};'
                    ]
                ]
			);

			$this->add_responsive_control('pr_infobox_title_hr_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-infobox .infobox-content hr.pr-infobox-hr' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab('infobox_divider_hover_style', [
				'label'	=> esc_html__( 'Hover', 'pixerex' )
			]);

			$this->add_control(
				'pr_infobox_title_hr_hover_color',
				[
					'label' => esc_html__( 'Color', 'pixerex' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pr-infobox:hover .infobox-content hr.pr-infobox-hr' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control('pr_infobox_title_hr_hover_height',
                [
                    'label'         => esc_html__('Height', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-infobox:hover .infobox-content hr.pr-infobox-hr' => 'height: {{SIZE}}{{UNIT}};'
                    ]
                ]
			);

			$this->add_control('pr_infobox_title_hr_hover_width',
                [
                    'label'         => esc_html__('Divider Width', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-infobox:hover .infobox-content hr.pr-infobox-hr' => 'width: {{SIZE}}{{UNIT}};'
                    ]
                ]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Description Style Settings
 
 		$this->start_controls_section(
			'pr_section_infobox_title_style_settings',
			[
				'label' => esc_html__( 'Description', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			$this->start_controls_tabs('infobox_content_style_tabs');

					$this->start_controls_tab('infobox_content_normal_style', [
						'label'	=> esc_html__( 'Normal', 'pixerex' )
					]);

					$this->add_responsive_control(
						'pr_infobox_content_margin',
						[
							'label' => esc_html__( 'Margin', 'pixerex' ),
							'type' => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
									'{{WRAPPER}} .pr-infobox .infobox-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'pr_infobox_content_background',
						[
							'label' => esc_html__( 'Background', 'pixerex' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .pr-infobox .infobox-content' => 'background: {{VALUE}};',
							],
						]
					);

					$this->add_responsive_control(
						'pr_infobox_content_only_padding',
						[
							'label' => esc_html__( 'Content Padding', 'pixerex' ),
							'type' => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .pr-infobox .infobox-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'pr_infobox_content_color',
						[
							'label' => esc_html__( 'Color', 'pixerex' ),
							'type' => Controls_Manager::COLOR,
							'default' => '#4d4d4d',
							'selectors' => [
								'{{WRAPPER}} .pr-infobox .infobox-content p' => 'color: {{VALUE}};',
							],
						]
					);
			
					$this->add_group_control(
						Group_Control_Typography::get_type(),
						[
						'name' => 'pr_infobox_content_typography',
							'selector' => '{{WRAPPER}} .pr-infobox .infobox-content p',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab('infobox_content_hover_style', [
					'label'	=> esc_html__( 'Hover', 'pixerex' )
				]);

					$this->add_control(
						'pr_infobox_content_hover_color',
						[
							'label' => esc_html__( 'Color', 'pixerex' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .pr-infobox:hover .infobox-content p' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'pr_infobox_content_transition',
						[
							'label'		=> esc_html__( 'Transition', 'pixerex' ),
							'description'		=> esc_html__( 'Transition will applied to ms (ex: 300ms).', 'pixerex' ),
							'type'		=> Controls_Manager::NUMBER,
							'separator'	=> 'before',
							'min'		=> 100,
							'max'		=> 1000,
							'default'	=> 100,
							'selectors'	=> [
								'{{WRAPPER}} .pr-infobox:hover .infobox-content p' => 'transition: {{SIZE}}ms;',
							]
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

/**
 * -----------------------------------------------------------------------------------------------------
 * Tab Style ( Info Box Button Style )
 * -----------------------------------------------------------------------------------------------------
 */
		$this->start_controls_section(
			'pr_section_infobox_button_settings',
			[
				'label' => esc_html__( 'Button', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'pr_show_infobox_button'	=> 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
			'name' => 'pr_infobox_button_typography',
				'selector' => '{{WRAPPER}} .pr-infobox .infobox-button a.pr-infobox-button',
			]
		);

		$this->add_responsive_control(
			'pr_creative_button_padding',
			[
				'label' => esc_html__( 'Button Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-infobox .infobox-button a.pr-infobox-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pr_infobox_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-infobox .infobox-button a.pr-infobox-button' => 'border-radius: {{SIZE}}px;'
				],
			]
		);

		$this->start_controls_tabs('infobox_button_styles_controls_tabs');

			$this->start_controls_tab('infobox_button_normal', [
				'label' => esc_html__( 'Normal', 'pixerex' )
			]);

				$this->add_control(
					'pr_infobox_button_text_color',
					[
						'label' => esc_html__( 'Text Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors'	=> [
							'{{WRAPPER}} .pr-infobox .pr-infobox-button' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'pr_infobox_button_background_color',
					[
						'label' => esc_html__( 'Background Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#333333',
						'selectors'	=> [
							'{{WRAPPER}} .pr-infobox .pr-infobox-button' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'pr_infobox_button_border',
						'selector' => '{{WRAPPER}} .pr-infobox .pr-infobox-button',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'button_box_shadow',
						'selector' => '{{WRAPPER}} .pr-infobox .pr-infobox-button',
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab('infobox_button_hover', [
				'label' => esc_html__( 'Hover', 'pixerex' )
			]);

				$this->add_control(
					'pr_infobox_button_hover_text_color',
					[
						'label' => esc_html__( 'Text Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors'	=> [
							'{{WRAPPER}} .pr-infobox .pr-infobox-button:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'pr_infobox_button_hover_background_color',
					[
						'label' => esc_html__( 'Background Color', 'pixerex' ),
						'type' => Controls_Manager::COLOR,
						'default' => '#333333',
						'selectors'	=> [
							'{{WRAPPER}} .pr-infobox .pr-infobox-button:hover' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'pr_infobox_button_hover_border',
						'selector' => '{{WRAPPER}} .pr-infobox .pr-infobox-button:hover',
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'button_hover_box_shadow',
						'selector' => '{{WRAPPER}} .pr-infobox .pr-infobox-button:hover',
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

/**
 * -----------------------------------------------------------------------------------------------------
 * Tab Style ( On Hover Icon Style )
 * -----------------------------------------------------------------------------------------------------
*/

		$this->start_controls_section(
			'pr_section_infobox_on_hover_icon_syle',
			[
				'label' => esc_html__( 'On Hover Icon ', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'pr_show_infobox_icon_onhover'	=> 'yes'
				]
			]
		);

		// start controls tabs

		$this->start_controls_tabs('infobox_onhover_icon_controls_tabs');

			// start normal state tab
			$this->start_controls_tab('infobox_onhover_icon_normal', [
				'label' => esc_html__( 'Normal', 'pixerex' )
			]);

			$this->add_responsive_control(
				'pr_infobox_onhover_icon_size',
				[
					'label' => __( 'Icon Size', 'pixerex' ),
				   'type' => Controls_Manager::SLIDER,
					'default' => [
					'size' => 25,
					],
					'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					]
					],
					'selectors' => [
					'{{WRAPPER}} .pr-infobox .infobox-on-hover-icon i' => 'font-size: {{SIZE}}px;',
					],
				]
			);

			$this->add_control(
				'pr_infobox_onhover_icon_color',
				array(
					'label' => esc_html__( 'Color', 'pixerex' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .pr-infobox .infobox-on-hover-icon i' => 'color: {{VALUE}}',
					]
				)
			);

			$this->end_controls_tab();

			// start hover state tab
			$this->start_controls_tab('infobox_onhover_icon_hover', [
				'label' => esc_html__( 'Hover', 'pixerex' )
			]);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * This function is responsible for rendering divs and contents
	 * for infobox before partial.
	 * 
	 * @param	$settings
	 */
	protected function pr_infobox_before( $settings ) {

		$this->add_render_attribute('pr_infobox_inner', 'class', 'pr-infobox');

		if( 'img-on-left' == $settings['pr_infobox_img_type'] )
			$this->add_render_attribute('pr_infobox_inner', 'class', 'icon-on-left');

		if( 'img-on-right' == $settings['pr_infobox_img_type'] )
			$this->add_render_attribute('pr_infobox_inner', 'class', 'icon-on-right');

		$target = $settings['pr_show_infobox_clickable_link']['is_external'] ? 'target="_blank"' : '';
		$nofollow = $settings['pr_show_infobox_clickable_link']['nofollow'] ? 'rel="nofollow"' : '';

		ob_start();
		?>
		<?php if( 'yes' == $settings['pr_show_infobox_clickable'] ) : ?><a href="<?php echo esc_url( $settings['pr_show_infobox_clickable_link']['url'] ) ?>" <?php echo $target; ?> <?php echo $nofollow; ?>><?php endif;?>
		<div <?php echo $this->get_render_attribute_string('pr_infobox_inner'); ?>>
		<?php
		echo ob_get_clean();
	}

	/**
	 * This function is rendering closing divs and tags
	 * of before partial for infobox.
	 * 
	 * @param	$settings
	 */
	protected function pr_infobox_after($settings) {
		ob_start();?></div><?php
		if( 'yes' == $settings['pr_show_infobox_clickable'] ) : ?></a><?php endif;
		echo ob_get_clean();
	}

	/**
	 * This function is rendering appropriate icon for infobox.
	 * 
	 * @param $settings
	 */
	protected function render_infobox_icon($settings) {

		if( 'none' == $settings['pr_infobox_img_or_icon'] ) return;

		$infobox_image = $this->get_settings( 'pr_infobox_image' );
		$infobox_image_url = Group_Control_Image_Size::get_attachment_image_src( $infobox_image['id'], 'thumbnail', $settings );
		if( empty( $infobox_image_url ) ) : $infobox_image_url = $infobox_image['url']; else: $infobox_image_url = $infobox_image_url; endif;

		$this->add_render_attribute(
			'infobox_icon',
			[
				'class' => ['infobox-icon']
			]
		);

		if( $settings['pr_infobox_icon_hover_animation'] ) {
			$this->add_render_attribute('infobox_icon', 'class', 'elementor-animation-' . $settings['pr_infobox_icon_hover_animation']);
		}

		if( $settings['pr_infobox_image_icon_hover_animation'] ) {
			$this->add_render_attribute('infobox_icon', 'class', 'elementor-animation-' . $settings['pr_infobox_image_icon_hover_animation']);
		}
		
		if( $settings['pr_infobox_number_icon_hover_animation'] ) {
			$this->add_render_attribute('infobox_icon', 'class', 'elementor-animation-' . $settings['pr_infobox_number_icon_hover_animation']);
		}
		
		if( 'icon' == $settings['pr_infobox_img_or_icon'] ) {
			$this->add_render_attribute('infobox_icon', 'class', 'pr-icon-only');
		}

		ob_start();
		?>
			<div <?php echo $this->get_render_attribute_string('infobox_icon'); ?>>

				<?php if( 'img' == $settings['pr_infobox_img_or_icon'] ) : ?>
					<img src="<?php echo esc_url( $infobox_image_url ); ?>" alt="Icon Image">
				<?php endif; ?>

				<?php if( 'icon' == $settings['pr_infobox_img_or_icon'] ) : ?>
				<div class="infobox-icon-wrap">
					<i class="<?php echo esc_attr( $settings['pr_infobox_icon'] ); ?>"></i>
				</div>
				<?php endif; ?>

				<?php if( 'number' == $settings['pr_infobox_img_or_icon'] ) : ?>
				<div class="infobox-icon-wrap">
					<span class="infobox-icon-number"><?php echo esc_attr( $settings['pr_infobox_number'] ); ?></span>
				</div>
				<?php endif; ?>

			</div>
		<?php
		echo ob_get_clean();
	}


	protected function render_infobox_content( $settings ) {

		$this->add_render_attribute( 'infobox_content', 'class', 'infobox-content' );
		if( 'icon' == $settings['pr_infobox_img_or_icon'] )
			$this->add_render_attribute( 'infobox_content', 'class', 'pr-icon-only' );

		ob_start();
		?>
			<div <?php echo $this->get_render_attribute_string('infobox_content'); ?>>
				<<?php echo $settings['pr_infobox_title_tag']; ?> class="title"><?php echo $settings['pr_infobox_title']; ?></<?php echo $settings['pr_infobox_title_tag']; ?>>
				<?php if( 'yes' == $settings['pr_infobox_hr'] ) : ?>
					<div class="pr-infobox-hr-holder">
						<hr class="pr-infobox-hr">
					</div>
				<?php endif; ?>
				<?php if( 'yes' == $settings['pr_show_infobox_content'] ) : ?>
						<?php if ( ! empty( $settings['pr_infobox_text'] ) ) : ?>
							<p><?php echo $settings['pr_infobox_text']; ?></p>
						<?php endif; ?>
						<?php $this->render_infobox_button($this->get_settings_for_display()); ?>
				<?php endif; ?>

				<?php if( 'yes' == $settings['pr_show_infobox_icon_onhover'] ) : ?>
					<?php $this->render_infobox_onhover_icon($this->get_settings_for_display()); ?>
				<?php endif; ?>
			</div>
		<?php

		echo ob_get_clean();
	}

	/**
	 * This function rendering infobox button
	 * 
	 * @param $settings
	 */
	protected function render_infobox_button( $settings ) {
		if('yes' == $settings['pr_show_infobox_clickable'] || 'yes' != $settings['pr_show_infobox_button']) return;

		$this->add_render_attribute('infobox_button', 'class', 'pr-infobox-button' );

		if($settings['infobox_button_link_url']['url'])
			$this->add_render_attribute('infobox_button', 'href', esc_url($settings['infobox_button_link_url']['url']) );

		if('on' == $settings['infobox_button_link_url']['is_external'])
			$this->add_render_attribute('infobox_button', 'target', '_blank');

		if('on' == $settings['infobox_button_link_url']['nofollow'])
			$this->add_render_attribute('infobox_button', 'rel', 'nofollow');

		$this->add_render_attribute('button_icon', [
			'class'	=> esc_attr($settings['pr_infobox_button_icon']),
			'aria-hidden'	=> 'true'
		]);

		if( 'left' == $settings['pr_infobox_button_icon_alignment'])
			$this->add_render_attribute('button_icon', 'class', 'pr_infobox_button_icon_left');

		if( 'right' == $settings['pr_infobox_button_icon_alignment'])
			$this->add_render_attribute('button_icon', 'class', 'pr_infobox_button_icon_right');

		ob_start();
		?>
		<div class="infobox-button">
			<a <?php echo $this->get_render_attribute_string('infobox_button'); ?>>
				<?php if( 'left' == $settings['pr_infobox_button_icon_alignment']) : ?><i <?php echo $this->get_render_attribute_string('button_icon'); ?>></i><?php endif; ?>
				<?php echo esc_attr($settings['infobox_button_text']); ?>
				<?php if( 'right' == $settings['pr_infobox_button_icon_alignment']) : ?><i <?php echo $this->get_render_attribute_string('button_icon'); ?>></i><?php endif; ?>
			</a>
		</div>
		<?php
		echo ob_get_clean();
	}

	/**
	 * This function rendering infobox onhover icon
	 * 
	 * @param $settings
	 */
	protected function render_infobox_onhover_icon( $settings ) {
		if('yes' == $settings['pr_show_infobox_button'] || 'yes' != $settings['pr_show_infobox_icon_onhover']) return;

		$this->add_render_attribute('pr_onhover_icon', [
			'class'	=> esc_attr($settings['pr_infobox_on_hover_icon']),
			'aria-hidden'	=> 'true'
		]);

		ob_start();
		?>
		<div class="infobox-on-hover-icon">
				<i <?php echo $this->get_render_attribute_string('pr_onhover_icon'); ?>></i>
		</div>
		<?php
		echo ob_get_clean();
	}

	protected function render() {
		// dump( $this->get_settings_for_display() );

		$settings = $this->get_settings_for_display();

		$this->pr_infobox_before( $settings );
		$this->render_infobox_icon( $settings );
		$this->render_infobox_content( $settings );
		$this->pr_infobox_after( $settings );
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new pr_infobox_Widget() );