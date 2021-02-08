<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class PR_Button_Widget extends Widget_Base {
    public function get_name() {
		return 'pr-button';
	}
    
    public function check_rtl(){
        return is_rtl();
    }

    public function get_title() {
		return __( 'Button', 'pixerex' );
	}

    public function get_icon() {
        return ' eicon-dual-button';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
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
        
        $this->add_control('pr_button_link',
                [
                    'label'         => esc_html__('Link', 'pixerex'),
                    'type'          => Controls_Manager::URL,
                    'default'       => [
                        'url'   => '#',
                        ],
                    'label_block'   => true,
                    'separator'     => 'after',
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
        
        $this->add_control('pr_button_event_switcher', 
                [
                    'label'         => esc_html__('onclick Event', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'separator'     => 'before',
                    ]
                );

        $this->add_control('pr_button_event_function', 
                [
                    'label'         => esc_html__('Example: myFunction();', 'pixerex'),
                    'type'          => Controls_Manager::TEXTAREA,
                    'condition'     => [
                        'pr_button_event_switcher' => 'yes',
                        ],
                    ]
                );
        
        /*End Button General Section*/
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
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes( 'pr_button_text');
        
        $button_text = $settings['pr_button_text'];
        
        $button_url = $settings['pr_button_link']['url'];
        
        $button_size = 'pr-button-' . $settings['pr_button_size'];
        
        $button_event = $settings['pr_button_event_function'];
        
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
        <a class="pr-button  <?php echo esc_attr($button_size); ?> <?php echo esc_attr($style_dir);?>" <?php if(!empty($button_url)) : ?>href="<?php echo esc_url($button_url); ?>"<?php endif;?><?php if(!empty($settings['pr_button_link']['is_external'])) : ?>target="_blank"<?php endif; ?><?php if(!empty($settings['pr_button_link']['nofollow'])) : ?>rel="nofollow"<?php endif; ?><?php if(!empty($settings['pr_button_event_function']) && $settings['pr_button_event_switcher']) : ?> onclick="<?php echo $button_event; ?>"<?php endif ?>><div class="pr-button-text-icon-wrapper"><?php if($settings['pr_button_icon_switcher'] && $settings['pr_button_icon_position'] == 'before'&& $settings['pr_button_hover_effect'] != 'style4' &&!empty($settings['pr_button_icon_selection'])) : ?><i class="fa <?php echo esc_attr($button_icon); ?>"></i><?php endif; ?><span <?php echo $this->get_render_attribute_string( 'pr_button_text' ); ?>><?php echo $button_text; ?></span><?php if($settings['pr_button_icon_switcher'] && $settings['pr_button_icon_position'] == 'after' && $settings['pr_button_hover_effect'] != 'style4' &&!empty($settings['pr_button_icon_selection'])) : ?><i class="fa <?php echo esc_attr($button_icon); ?>"></i><?php endif; ?></div>
        <?php if($settings['pr_button_hover_effect'] == 'style4') : ?><div class="pr-button-style4-icon-wrapper <?php echo esc_attr($settings['pr_button_style4_dir']); ?>"><i class="fa <?php echo esc_attr($slide_icon); ?>"></i></div><?php endif; ?></a>
    </div>

    <?php
    }
    
    protected function _content_template() {
        ?>
        <#
        
        view.addInlineEditingAttributes( 'pr_button_text' );
        
        var buttonText = settings.pr_button_text,
            buttonUrl,
            styleDir,
            slideIcon,
            buttonSize = 'pr-button-' + settings.pr_button_size,
            buttonEvent = settings.pr_button_event_function,
            buttonIcon = settings.pr_button_icon_selection;
            buttonUrl = settings.pr_button_link.url;
        
        if ( 'none' == settings.pr_button_hover_effect ) {
            styleDir = 'pr-button-none';
        } else if( 'style1' == settings.pr_button_hover_effect ) {
            styleDir = 'pr-button-style1-' + settings.pr_button_style1_dir;
        } else if ( 'style2' == settings.pr_button_hover_effect ){
            styleDir = 'pr-button-style2-' + settings.pr_button_style2_dir;
        } else if ( 'style3' == settings.pr_button_hover_effect ) {
            styleDir = 'pr-button-style3-' + settings.pr_button_icon_position;
        } else if ( 'style4' == settings.pr_button_hover_effect ) {
            styleDir = 'pr-button-style4-' + settings.pr_button_style4_dir;
            slideIcon = settings.pr_button_style4_icon_selection;
        } else if ( 'style5' == settings.pr_button_hover_effect ){
            styleDir = 'pr-button-style5-' + settings.pr_button_style5_dir;
        }
        
        #>
        
        <div class="pr-button-container">
            <a class="pr-button  {{ buttonSize }} {{ styleDir }}" href="{{ buttonUrl }}" onclick="{{ buttonEvent }}">
                <div class="pr-button-text-icon-wrapper">
                    <# if( settings.pr_button_icon_switcher && 'before' == settings.pr_button_icon_position &&  'style4' != settings.pr_button_hover_effect && '' != settings.pr_button_icon_selection ) { #>
                        <i class="fa {{ buttonIcon }}"></i>
                    <# } #>
                    <span {{{ view.getRenderAttributeString('pr_button_text') }}}>{{{ buttonText }}}</span>
                    <# if( settings.pr_button_icon_switcher && 'after' == settings.pr_button_icon_position && 'style4' != settings.pr_button_hover_effect && '' != settings.pr_button_icon_selection ) { #>
                        <i class="fa {{ buttonIcon }}"></i>
                    <# } #>
                </div>
                <# if( 'style4' == settings.pr_button_hover_effect ) { #>
                    <div class="pr-button-style4-icon-wrapper {{ settings.pr_button_style4_dir }}">
                        <i class="fa {{ slideIcon }}"></i>
                    </div>
                <# } #>
            </a>
        </div>
        
        <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new PR_Button_Widget() );