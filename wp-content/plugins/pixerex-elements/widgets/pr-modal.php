<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class PR_Modal_Widget extends Widget_Base {
    public function get_name() {
		return 'pr-modal';
    }
    
    public function check_rtl(){
        return is_rtl();
    }

    public function get_title() {
        return esc_html__('Modal', 'pixerex');
    }

    public function get_icon() {
        return 'eicon-editor-close';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }

    public function get_script_depends()
    {
        return ['pr-js','uikit'];
    }


    protected function _register_controls() {

        /*Start Button Content Section */
        $this->start_controls_section('pr_button_general_section',
                [
                    'label'         => esc_html__('Button', 'pixerex'),
                    ]
                );
        
        /*Button Text*/ 
        $this->add_control('pr_button_text',
                [
                    'label'         => esc_html__('Text', 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__('Click here','pixerex'),
                    'label_block'   => true,
                ]
                );

        /*Button Hover Effect*/
        $this->add_control('pr_button_hover_effect', 
                [
                    'label'         => esc_html__('Hover Effect', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'none',
                    'options'       => [
                        'none'          => esc_html__('None'),
                        'style1'        => esc_html__('Slide'),
                        'style2'        => esc_html__('Shutter'),
                        'style3'        => esc_html__('Icon Fade'),
                        'style4'        => esc_html__('Icon Slide'),
                        'style5'        => esc_html__('In & Out'),
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pr_button_style1_dir', 
                [
                    'label'         => esc_html__('Slide Direction', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'bottom',
                    'options'       => [
                        'bottom'       => esc_html__('Top to Bottom'),
                        'top'          => esc_html__('Bottom to Top'),
                        'left'         => esc_html__('Right to Left'),
                        'right'        => esc_html__('Left to Right'),
                        ],
                    'condition'     => [
                        'pr_button_hover_effect' => 'style1',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pr_button_style2_dir', 
                [
                    'label'         => esc_html__('Shutter Direction', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'shutouthor',
                    'options'       => [
                        'shutinhor'     => esc_html__('Shutter in Horizontal'),
                        'shutinver'     => esc_html__('Shutter in Vertical'),
                        'shutoutver'    => esc_html__('Shutter out Horizontal'),
                        'shutouthor'    => esc_html__('Shutter out Vertical'),
                        'scshutoutver'  => esc_html__('Scaled Shutter Vertical'),
                        'scshutouthor'  => esc_html__('Scaled Shutter Horizontal'),
                        'dshutinver'   => esc_html__('Tilted Left'),
                        'dshutinhor'   => esc_html__('Tilted Right'),
                        
                        
                        ],
                    'condition'     => [
                        'pr_button_hover_effect' => 'style2',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pr_button_style4_dir', 
                [
                    'label'         => esc_html__('Slide Direction', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'bottom',
                    'options'       => [
                        'top'          => esc_html__('Top'),
                        'bottom'       => esc_html__('Bottom'),
                        'left'         => esc_html__('Left'),
                        'right'        => esc_html__('Right'),
                        ],
                    'condition'     => [
                        'pr_button_hover_effect' => 'style4',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pr_button_style5_dir', 
                [
                    'label'         => esc_html__('Style', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'radialin',
                    'options'       => [
                        'radialin'          => esc_html__('Radial In'),
                        'radialout'         => esc_html__('Radial Out'),
                        'rectin'            => esc_html__('Rectangle In'),
                        'rectout'           => esc_html__('Rectangle Out'),
                        ],
                    'condition'     => [
                        'pr_button_hover_effect' => 'style5',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        /*Button Icon Switcher*/
        $this->add_control('pr_button_icon_switcher',
                [
                    'label'         => esc_html__('Icon', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'condition'     => [
                        'pr_button_hover_effect!'  => 'style4'
                    ],
                    'description'   => esc_html__('Enable or disable button icon','pixerex'),
                ]
                );

        /*Button Icon Selection*/ 
        $this->add_control('pr_button_icon_selection',
                [
                    'label'         => esc_html__('Icon', 'pixerex'),
                    'type'          => Controls_Manager::ICON,
                    'default'       => 'fa fa-bars',
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_hover_effect!'  => 'style4'
                    ],
                    'label_block'   => true,
                ]
                );
        
        /*Style 4 Icon Selection*/ 
        $this->add_control('pr_button_style4_icon_selection',
                [
                    'label'         => esc_html__('Icon', 'pixerex'),
                    'type'          => Controls_Manager::ICON,
                    'default'       => 'fa fa-bars',
                    'condition'     => [
                        'pr_button_hover_effect'  => 'style4'
                    ],
                    'label_block'   => true,
                ]
                );
        
        $this->add_control('pr_button_icon_position', 
                [
                    'label'         => esc_html__('Icon Position', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'before',
                    'options'       => [
                        'before'        => esc_html__('Before', 'pixerex'),
                        'after'         => esc_html__('After', 'pixerex'),
                        ],
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_hover_effect!' => 'style4',
                    ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('pr_button_icon_before_size',
                [
                    'label'         => esc_html__('Icon Size', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_hover_effect!'  => 'style4'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-text-icon-wrapper i' => 'font-size: {{SIZE}}px',
                    ]
                ]
                );
        
        $this->add_control('pr_button_icon_style4_size',
                [
                    'label'         => esc_html__('Icon Size', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_hover_effect'  => 'style4'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-style4-icon-wrapper i' => 'font-size: {{SIZE}}px',
                    ]
                ]
                );
        
        if(!$this->check_rtl()){
            $this->add_control('pr_button_icon_before_spacing',
                [
                    'label'         => esc_html__('Icon Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_icon_position' => 'before',
                        'pr_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-text-icon-wrapper i' => 'margin-right: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        if(!$this->check_rtl()){
        $this->add_control('pr_button_icon_after_spacing',
                [
                    'label'         => esc_html__('Icon Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_icon_position' => 'after',
                        'pr_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-text-icon-wrapper i' => 'margin-left: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        if($this->check_rtl()){
            $this->add_control('pr_button_icon_rtl_before_spacing',
                [
                    'label'         => esc_html__('Icon Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_icon_position' => 'before',
                        'pr_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-text-icon-wrapper i' => 'margin-left: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        if($this->check_rtl()){
        $this->add_control('pr_button_icon_rtl_after_spacing',
                [
                    'label'         => esc_html__('Icon Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_icon_position' => 'after',
                        'pr_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-text-icon-wrapper i' => 'margin-right: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        $this->add_control('pr_button_icon_style3_before_transition',
                [
                    'label'         => esc_html__('Icon Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_icon_position' => 'before',
                        'pr_button_hover_effect'  => 'style3'
                    ],
                    'range'         => [
                        'px'    => [
                            'min'   => -50,
                            'max'   => 50,
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-style3-before:hover i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
                    ],
                ]
                );
        
        $this->add_control('pr_button_icon_style3_after_transition',
                [
                    'label'         => esc_html__('Icon Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'pr_button_icon_switcher' => 'yes',
                        'pr_button_icon_position!'=> 'before',
                        'pr_button_hover_effect'  => 'style3'
                    ],
                    'range'         => [
                        'px'    => [
                            'min'   => -50,
                            'max'   => 50,
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button-style3-after:hover i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
                    ],
                ]
                );

        /*Button Size*/
        $this->add_control('pr_button_size', 
                [
                    'label'         => esc_html__('Size', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'lg',
                    'options'       => [
                            'sm'          => esc_html__('Small'),
                            'md'            => esc_html__('Medium'),
                            'lg'            => esc_html__('Large'),
                            'block'         => esc_html__('Block'),
                        ],
                    'label_block'   => true,
                    'separator'     => 'before',
                    ]
                );
        
        /*Button Align*/
        $this->add_responsive_control('pr_button_align',
			[
				'label'             => esc_html__( 'Alignment', 'pixerex' ),
				'type'              => Controls_Manager::CHOOSE,
				'options'           => [
					'left'    => [
						'title' => __( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					],
				],
                'selectors'         => [
                    '{{WRAPPER}} .pr-button-container' => 'text-align: {{VALUE}}',
                ],
				'default' => 'center',
			]
        );
        
        /*End Button General Section*/
        $this->end_controls_section();

        $this->start_controls_section('pr_modal_box_selector_content_section', 
                [
                    'label'         => __('Content', 'pixerex'),
                ]
                );
        
        $this->add_control('pr_modal_box_header_switcher',
                [
                    'label'         => __('Header', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => 'show',
                    'label_off'     => 'hide',
                    'default'       => 'yes',
                    'description'   => __('Enable or disable modal header','pixerex'),
                ]
                );
        /*Modal Box Title*/ 
        $this->add_control('pr_modal_box_title',
                [
                    'label'         => __('Title', 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'description'   => __('Provide the modal box with a title', 'pixerex'),
                    'default'       => 'Modal Box Title',
                    'condition'     => [
                        'pr_modal_box_header_switcher' => 'yes'
                    ],
                    'label_block'   => true,
                ]
                );
        
        /*Modal Box Content Heading*/
        $this->add_control('pr_modal_box_content_heading',
                [
                    'label'         => __('Content', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Modal Box Content Type*/
        $this->add_control('pr_modal_box_content_type',
                [
                    'label'         => __('Content to Show', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => [
                        'editor'        => __('Text Editor', 'pixerex'),
                        'template'      => __('Elementor Template', 'pixerex'),
                    ],
                    'default'       => 'editor',
                    'label_block'   => true
                ]
                );
        
        /*Modal Box Elementor Template*/
        $this->add_control('pr_modal_box_content_temp',
                [
                    'label'			=> __( 'Content', 'pixerex' ),
                    'description'	=> __( 'Modal content is a template which you can choose from Elementor library', 'pixerex' ),
                    'type' => Controls_Manager::SELECT2,
                    'options'   => pr_get_page_templates(),
                    'condition'     => [
                        'pr_modal_box_content_type'    => 'template',
                    ],
                ]
            );
        
        /*Modal Box Content*/
        $this->add_control('pr_modal_box_content',
                [
                    'type'          => Controls_Manager::WYSIWYG,
                    'default'       => 'Modal Box Content',
                    'dynamic'       => [ 'active' => true ],
                    'condition'     => [
                        'pr_modal_box_content_type'    => 'editor',
                    ],
                    'show_label'    => false,
                ]
                );
        
        /*Lower Close Button*/
        $this->add_control('pr_modal_footer',
                [
                    'label'         => __('Footer', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                ]
                );
        
        $this->add_control('pr_modal_close_text',
                [
                    'label'         => __('Footer Text', 'pixerex'),
                    'default'       => __('Close','pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'label_block'   => true,
                    'condition'     => [
                      'pr_modal_footer'  => 'yes'
                    ],
                ]
                );
        
        $this->end_controls_section();

        $this->start_controls_section(
			'pr_section_modal_additional',
			[
				'label' => esc_html__( 'Additional', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_content_overflow',
			[
				'label'       => __( 'Overflow Scroll', 'pixerex' ),
				'description' => __( 'Show scroll bar when you add Huge content in modal.', 'pixerex' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'pr_close_button',
			[
				'label'       => esc_html__( 'Close Button', 'pixerex' ),
				'description' => esc_html__('When you set modal full screen make sure you don\'t set colse button outside', 'pixerex'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default', 'pixerex' ),
					'outside' => esc_html__( 'Outside', 'pixerex' ),
					'none'    => esc_html__( 'No Close Button', 'pixerex' ),
				],
			]
		);

		$this->add_control(
			'pr_modal_size',
			[
				'label'        => esc_html__( 'Full screen', 'pixerex' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'full',
				'condition'    => [
					'pr_close_button!' => 'outside',
				],
			]
		);

		$this->add_control(
			'pr_modal_center',
			[
				'label'        => esc_html__( 'Center Position', 'pixerex' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => [
					'pr_modal_size!' => 'full',
				],
			]
		);

		$this->end_controls_section();
        
        /*Start Styling Section*/
        $this->start_controls_section('pr_button_style_section',
            [
                'label'             => esc_html__('Button', 'pixerex'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'pr_button_typo',
                'scheme'            => Scheme_Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .pr-button',
            ]
            );
        
        $this->start_controls_tabs('pr_button_style_tabs');
        
        $this->start_controls_tab('pr_button_style_normal',
            [
                'label'             => esc_html__('Normal', 'pixerex'),
            ]
            );
        
        $this->add_control('pr_button_text_color_normal',
            [
                'label'             => esc_html__('Text Color', 'pixerex'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
				],
				'default' => '#ffffff',
                'selectors'         => [
                    '{{WRAPPER}} .pr-button, {{WRAPPER}} .pr-button .pr-button-text-icon-wrapper span' => 'color: {{VALUE}};',
                ]
            ]);
        
        $this->add_control('pr_button_icon_color_normal',
            [
                'label'             => esc_html__('Icon Color', 'pixerex'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pr-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pr_button_icon_switcher'  => 'yes',
                    'pr_button_hover_effect!'  => ['style3','style4']
                ]
            ]);
        
        $this->add_control('pr_button_background_normal',
                [
                    'label'             => esc_html__('Background Color', 'pixerex'),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
					],
					'default' => '#333333',
                    'selectors'      => [
                        '{{WRAPPER}} .pr-button, {{WRAPPER}} .pr-button.pr-button-style2-shutinhor:before , {{WRAPPER}} .pr-button.pr-button-style2-shutinver:before , {{WRAPPER}} .pr-button-style5-radialin:before , {{WRAPPER}} .pr-button-style5-rectin:before'  => 'background-color: {{VALUE}};',
                        ]
                    ]
                );
        
        /*Button Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_button_border_normal',
                    'selector'      => '{{WRAPPER}} .pr-button',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pr_button_border_radius_normal',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Icon Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => esc_html__('Icon Shadow','pixerex'),
                    'name'          => 'pr_button_icon_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pr-button-text-icon-wrapper i',
                    'condition'         => [
                            'pr_button_icon_switcher'  => 'yes',
                            'pr_button_hover_effect!'  => ['style3', 'style4']
                        ]
                    ]
                );
        
        /*Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => esc_html__('Text Shadow','pixerex'),
                    'name'          => 'pr_button_text_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pr-button-text-icon-wrapper span',
                    ]
                );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Button Shadow','pixerex'),
                    'name'          => 'pr_button_box_shadow_normal',
                    'selector'      => '{{WRAPPER}} .pr-button',
                ]
                );
        
        /*Button Margin*/
        $this->add_responsive_control('pr_button_margin_normal',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Button Padding*/
        $this->add_responsive_control('pr_button_padding_normal',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('pr_button_style_hover',
            [
                'label'             => esc_html__('Hover', 'pixerex'),
            ]
            );
        
        $this->add_control('pr_button_text_color_hover',
            [
                'label'             => esc_html__('Text Color', 'pixerex'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
				],
                'selectors'         => [
                    '{{WRAPPER}} .pr-button:hover, {{WRAPPER}} .pr-button:hover .pr-button-text-icon-wrapper span' => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pr_button_hover_effect!'   => 'style4'
                ]
            ]);
        
        $this->add_control('pr_button_icon_color_hover',
            [
                'label'             => esc_html__('Icon Color', 'pixerex'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pr-button:hover .pr-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pr_button_icon_switcher'  => 'yes',
                    'pr_button_hover_effect!'  => 'style4',
                ]
            ]);
        
        $this->add_control('pr_button_style4_icon_color',
            [
                'label'             => esc_html__('Icon Color', 'pixerex'),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .pr-button:hover .pr-button-style4-icon-wrapper'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'pr_button_hover_effect'  => 'style4'
                ]
            ]);
        
        $this->add_control('pr_button_background_hover',
                [
                    'label'             => esc_html__('Background Color', 'pixerex'),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_3
                    ],
                    'selectors'          => [
                        ''
                    . '{{WRAPPER}} .pr-button-none:hover ,{{WRAPPER}} .pr-button-style1-bottom:before, {{WRAPPER}} .pr-button-style1-top:before, {{WRAPPER}} .pr-button-style1-right:before, {{WRAPPER}} .pr-button-style1-left:before, {{WRAPPER}} .pr-button-style2-shutouthor:before, {{WRAPPER}} .pr-button-style2-shutoutver:before, {{WRAPPER}} .pr-button-style2-shutinhor, {{WRAPPER}} .pr-button-style2-shutinver , {{WRAPPER}} .pr-button-style2-dshutinhor:before , {{WRAPPER}} .pr-button-style2-dshutinver:before , {{WRAPPER}} .pr-button-style2-scshutouthor:before , {{WRAPPER}} .pr-button-style2-scshutoutver:before, {{WRAPPER}} .pr-button-style3-after:hover , {{WRAPPER}} .pr-button-style3-before:hover,{{WRAPPER}} .pr-button-style4-icon-wrapper , {{WRAPPER}} .pr-button-style5-radialin , {{WRAPPER}} .pr-button-style5-radialout:before, {{WRAPPER}} .pr-button-style5-rectin , {{WRAPPER}} .pr-button-style5-rectout:before' => 'background-color: {{VALUE}};',
                    ],
                    ]
                );
        
        /*Button Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_button_border_hover',
                    'selector'      => '{{WRAPPER}} .pr-button:hover',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pr_button_border_radius_hover',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Icon Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => esc_html__('Icon Shadow','pixerex'),
                    'name'          => 'pr_button_icon_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pr-button:hover .pr-button-text-icon-wrapper i',
                    'condition'         => [
                            'pr_button_icon_switcher'  => 'yes',
                            'pr_button_hover_effect!'   => 'style4',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => esc_html__('Icon Shadow','pixerex'),
                    'name'          => 'pr_button_style4_icon_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pr-button:hover .pr-button-style4-icon-wrapper',
                    'condition'         => [
                        'pr_button_hover_effect'   => 'style4',
                        ]
                    ]
                );
        
        /*Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => esc_html__('Text Shadow','pixerex'),
                    'name'          => 'pr_button_text_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pr-button:hover .pr-button-text-icon-wrapper span',
                    'condition'         => [
                       'pr_button_hover_effect!'   => 'style4'
                        ]
                    ]
                );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Button Shadow','pixerex'),
                    'name'          => 'pr_button_box_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pr-button:hover',
                ]
                );
        
        /*Button Margin*/
        $this->add_responsive_control('pr_button_margin_hover',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Button Padding*/
        $this->add_responsive_control('pr_button_padding_hover',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        /*End Button Style Section*/
        $this->end_controls_section();

        $this->start_controls_section(
			'pr_tab_content_header',
			[
				'label'     => esc_html__( 'Header', 'pixerex' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_modal_box_header_switcher' => 'yes',
				],
			]
		);

		$this->add_control(
			'pr_title_color',
			[
				'label'     => esc_html__( 'Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_header_background',
			[
				'label'     => esc_html__( 'Background', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_header_padding',
			[
				'label'      => esc_html__( 'Padding', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pr_header_align',
			[
				'label'       => esc_html__( 'Titlt Align', 'pixerex' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left' => [
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'pr_header_border',
				'label'       => esc_html__( 'Border', 'pixerex' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#pr-modal-section-{{ID}}.uk-modal .uk-modal-header',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pr_header_box_shadow',
				'selector' => '#pr-modal-section-{{ID}}.uk-modal .uk-modal-header',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pr_title_typography',
				'selector' => '#pr-modal-section-{{ID}}.uk-modal .uk-modal-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_section_style_modal',
			[
				'label' => esc_html__( 'Modal Content', 'pixerex' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_control(
			'pr_modal_width',
			[
				'label' => esc_html__( 'Modal Width', 'pixerex' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 320,
						'max' => 1200,
					],
				],
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-dialog' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pr_content_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-body' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_content_background',
			[
				'label'     => esc_html__( 'Background', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-body' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pr_content_typography',
				'label'    => esc_html__( 'Typography', 'pixerex' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '#pr-modal-section-{{ID}}.uk-modal .uk-modal-body',
			]
		);

		$this->add_control(
			'pr_close_button_color',
			[
				'label'     => esc_html__( 'Close Button Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-dialog button.uk-close' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
        );
        
        $this->add_control(
            'pr_modal_btn_size',
            [
                'label'    => esc_html__( 'Close Button Size', 'pixerex' ),
                'type'     => Controls_Manager::SLIDER,
                'selectors'     => [
                    '#pr-modal-section-{{ID}}.uk-modal .uk-modal-dialog button.uk-close svg' => 'width: {{SIZE}}px',
                ]
            ]
        );

        $this->add_responsive_control(
            'pr_modal_close_ver_pos',
            [
                'label'    => esc_html__( 'Close Button Vertical Position', 'pixerex' ),
                'type'     => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ]
                ],
                'selectors'     => [
                    '#pr-modal-section-{{ID}}.uk-modal .uk-modal-dialog button.uk-close' => 'top: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'pr_modal_close_hor_pos',
            [
                'label'    => esc_html__( 'Close Button Horizontal Position', 'pixerex' ),
                'type'     => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ]
                ],
                'selectors'     => [
                    '#pr-modal-section-{{ID}}.uk-modal .uk-modal-dialog button.uk-close' => 'right: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

		$this->end_controls_section();


		$this->start_controls_section(
			'pr_tab_content_footer',
			[
				'label'     => esc_html__( 'Footer', 'pixerex' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_modal_footer' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-footer .pr-modal-footer-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_footer_background',
			[
				'label'     => esc_html__( 'Background', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-footer' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_footer_padding',
			[
				'label'      => esc_html__( 'Padding', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'#pr-modal-section-{{ID}}.uk-modal .uk-modal-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pr_footer_align',
			[
				'label'       => esc_html__( 'Text Align', 'pixerex' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left' => [
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'        => 'pr_footer_border',
				'label'       => esc_html__( 'Border', 'pixerex' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#pr-modal-section-{{ID}}.uk-modal .uk-modal-footer',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pr_footer_box_shadow',
				'selector' => '#pr-modal-section-{{ID}}.uk-modal .uk-modal-footer',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pr_text_typography',
				'selector' => '#pr-modal-section-{{ID}}.uk-modal .uk-modal-footer .pr-modal-footer-text',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();

        $this->add_render_attribute( 'modal', 'id', 'pr-modal-section-'.$id);
        $this->add_render_attribute( 'modal', 'data-uk-modal', '' );

        if ( $settings['pr_modal_size'] !== 'full' ) {
        	$this->add_render_attribute( 'modal', 'class', 'uk-modal' );
        } else {
        	$this->add_render_attribute( 'modal', 'class', 'uk-modal uk-modal-full' );
            $this->add_render_attribute( 'modal-body', 'data-uk-height-viewport', 'offset-top: .uk-modal-header; offset-bottom: .uk-modal-footer' );
        }

        if ( $settings['pr_modal_center'] === 'yes' ) {
        	$this->add_render_attribute( 'modal', 'class', 'uk-flex-top' );
        }

        $this->add_render_attribute( 'modal-dialog', 'class', 'uk-modal-dialog' );

        if ($settings['pr_modal_center'] === 'yes' ) {
        	$this->add_render_attribute( 'modal-dialog', 'class', 'uk-margin-auto-vertical' );
        }

        $this->add_render_attribute( 'modal-body', 'class', 'uk-modal-body' );

        if ( 'yes' === $settings['pr_content_overflow'] ) {
        	$this->add_render_attribute( 'modal-body', 'uk-overflow-auto', '' );
        }

        ?>

        
        <?php $this->render_modale_button(); ?> 

        <div class="pr-modal-wrapper">
            
            <div <?php echo $this->get_render_attribute_string( 'modal' ); ?>>

                <div <?php echo $this->get_render_attribute_string( 'modal-dialog' ); ?>>
                
                    <?php if ( $settings['pr_close_button'] != 'none' ) : ?>
                        <button class="uk-modal-close-<?php echo esc_attr($settings['pr_close_button']); ?>" type="button" data-uk-close></button>
                    <?php endif; ?>
                    <?php if ( $settings['pr_modal_box_header_switcher'] == 'yes' ) : ?>
                        <div class="uk-modal-header uk-text-<?php echo esc_attr($settings['pr_header_align']); ?>">
                            <h3 class="uk-modal-title"><?php echo wp_kses_post($settings['pr_modal_box_title']); ?></h3>
                        </div>
                    <?php endif ?>
                    <div <?php echo $this->get_render_attribute_string( 'modal-body' ); ?>>
                        <?php 
                        if ( 'editor' == ($settings['pr_modal_box_content_type']) ) {
                            echo do_shortcode($settings['pr_modal_box_content']);
                        }else{
                                $pr_template_id = $settings['pr_modal_box_content_temp'];
                                $pr_frontend    = new Frontend;
                                echo $pr_frontend->get_builder_content( $pr_template_id, true );
                        }    
                        ?>
                    </div>
                    <?php if ( $settings['pr_modal_footer'] == 'yes' ) : ?>
                        <div class="uk-modal-footer uk-text-<?php echo esc_attr($settings['pr_footer_align']); ?>">
                            <h5 class="pr-modal-footer-text"><?php echo wp_kses_post($settings['pr_modal_close_text']); ?></h3>
                        </div>
                    <?php endif  ?>
                </div>
            </div>

        </div>

    <?php
    }

    protected function render_modale_button(){

          // get our input from the widget settings.
          $settings = $this->get_settings_for_display();
        
          $button_text = $settings['pr_button_text'];
          
          $button_size = 'pr-button-' . $settings['pr_button_size'];
          
          $button_icon = $settings['pr_button_icon_selection'];
          
          if ($settings['pr_button_hover_effect'] == 'none'){
              $style_dir = 'pr-button-none';
          }    elseif($settings['pr_button_hover_effect'] == 'style1'){
              $style_dir = 'pr-button-style1-' . $settings['pr_button_style1_dir'];
          } elseif ($settings['pr_button_hover_effect'] == 'style2'){
              $style_dir = 'pr-button-style2-' . $settings['pr_button_style2_dir'];
          } elseif ($settings['pr_button_hover_effect'] == 'style3') {
              $style_dir = 'pr-button-style3-' . $settings['pr_button_icon_position'];
          } elseif ($settings['pr_button_hover_effect'] == 'style4') {
              $style_dir = 'pr-button-style4-' . $settings['pr_button_style4_dir'];
              $slide_icon = $settings['pr_button_style4_icon_selection'];
          } elseif ($settings['pr_button_hover_effect'] == 'style5'){
              $style_dir = 'pr-button-style5-' . $settings['pr_button_style5_dir'];
          }
        ?>
        <div class="pr-button-container">
            <a class="pr-button  <?php echo esc_attr($button_size); ?> <?php echo esc_attr($style_dir);?>" data-uk-toggle="target: #pr-modal-section-<?php echo esc_attr($this->get_id()); ?>"><div class="pr-button-text-icon-wrapper"><?php if($settings['pr_button_icon_switcher'] && $settings['pr_button_icon_position'] == 'before'&& $settings['pr_button_hover_effect'] != 'style4' &&!empty($settings['pr_button_icon_selection'])) : ?><i class="fa <?php echo esc_attr($button_icon); ?>"></i><?php endif; ?><span <?php echo $this->get_render_attribute_string( 'pr_button_text' ); ?>><?php echo $button_text; ?></span><?php if($settings['pr_button_icon_switcher'] && $settings['pr_button_icon_position'] == 'after' && $settings['pr_button_hover_effect'] != 'style4' &&!empty($settings['pr_button_icon_selection'])) : ?><i class="fa <?php echo esc_attr($button_icon); ?>"></i><?php endif; ?></div>
            <?php if($settings['pr_button_hover_effect'] == 'style4') : ?><div class="pr-button-style4-icon-wrapper <?php echo esc_attr($settings['pr_button_style4_dir']); ?>"><i class="fa <?php echo esc_attr($slide_icon); ?>"></i></div><?php endif; ?></a>
        </div>

    <?php

    }
}
Plugin::instance()->widgets_manager->register_widget_type( new PR_Modal_Widget() );