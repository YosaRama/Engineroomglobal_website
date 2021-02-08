<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class PR_Pricing_Table_Widget extends Widget_Base
{
	public function get_title(){
		return esc_html__('Pricing Table', 'pixerex');
	}
	
    public function get_name() {
        return 'pr-price-table';
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }


    protected function _register_controls() {
        /*Title Content Section*/
        $this->start_controls_section('pr_pricing_table_icon_section',
                [
                    'label'         => esc_html__('Icon', 'pixerex'),
                    'condition'     => [
                        'pr_pricing_table_icon_switcher'  => 'yes',
                        ]
                    ]
                );
        
        $this->add_control('pr_pricing_table_icon_selection', 
                [
                    'label'         => esc_html__('Select an Icon', 'pixerex'),
                    'type'          => Controls_Manager::ICON,
                    'default'       => 'fa fa-check'
                ]
                );
        
        $this->end_controls_section();
          
        /*Price Content Section*/
        $this->start_controls_section('pr_pricing_table_price_section',
                [
                    'label'         => esc_html__('Price', 'pixerex'),
                    'condition'     => [
                        'pr_pricing_table_price_switcher'  => 'yes',
                        ]
                    ]
                );
        
        /*Price Currency*/ 
        $this->add_control('pr_pricing_table_price_currency',
                [
                    'label'         => esc_html__('Currency', 'pixerex'),
                    'default'       => '$',
                    'type'          => Controls_Manager::TEXT,
                    'label_block'   => true,
                ]
                );
        
        /*Price Value*/ 
        $this->add_control('pr_pricing_table_price_value',
                [
                    'label'         => esc_html__('Price', 'pixerex'),
                    'default'       => '25',
                    'type'          => Controls_Manager::TEXT,
                    'label_block'   => true,
                ]
                );
        
        $this->end_controls_section();

                /*Title Content Section*/
                $this->start_controls_section('pr_pricing_table_title_section',
                [
                    'label'         => esc_html__('Title', 'pixerex'),
                    'condition'     => [
                        'pr_pricing_table_title_switcher'  => 'yes',
                        ]
                    ]
                );
        
        /*Header Text*/ 
        $this->add_control('pr_pricing_table_title_text',
                [
                    'label'         => esc_html__('Text', 'pixerex'),
                    'default'       => 'Pricing Table',
                    'type'          => Controls_Manager::TEXT,
		    'dynamic'       => [ 'active' => true ],
                    'label_block'   => true,
                ]
                );
        
        /*Header Tag*/
        $this->add_control('pr_pricing_table_title_size',
                [
                    'label'         => esc_html__('HTML Tag', 'pixerex'),
                    'description'   => esc_html__( 'Select HTML tag for the title', 'pixerex' ),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'h3',
                    'options'       => [
                        'h1'    => 'H1',
                        'h2'    => 'H2',
                        'h3'    => 'H3',
                        'h4'    => 'H4',
                        'h5'    => 'H5',
                        'h6'    => 'H6',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->end_controls_section();

                /*Description Content Section*/
                $this->start_controls_section('pr_pricing_table_description_section',
                [
                    'label'         => esc_html__('Description', 'pixerex'),
                    'condition'     => [
                        'pr_pricing_table_description_switcher'  => 'yes',
                        ]
                    ]
                );
        
        
        /*Description Text*/
        $this->add_control('pr_pricing_table_description_text',
                [
                    'label'         => esc_html__('Description', 'pixerex'),
                    'type'          => Controls_Manager::WYSIWYG,
                    'default'       => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'pixerex'),
                    ]
                );
        
        $this->end_controls_section();
        
        /*Icon List Content Section*/
        $this->start_controls_section('pr_pricing_table_list_section',
                [
                    'label'         => esc_html__('Features', 'pixerex'),
                    'condition'     => [
                        'pr_pricing_table_list_switcher'  => 'yes',
                        ]
                    ]
                );
        
         $this->add_control('stefancy_text_list_items',
                [
                    'label'         => esc_html__( 'Features', 'pixerex' ),
                    'type'          => Controls_Manager::REPEATER,
                    'default'       => [
                        [
                            'pr_pricing_list_item_icon'    => 'fa fa-check',
                            'pr_pricing_list_item_text' => esc_html__( 'List Item #1', 'pixerex' ),
                            ],
                        [
                            'pr_pricing_list_item_icon'    => 'fa fa-check',
                            'pr_pricing_list_item_text' => esc_html__( 'List Item #2', 'pixerex' ),
                            ],
                        [
                            'pr_pricing_list_item_icon'    => 'fa fa-check',
                            'pr_pricing_list_item_text' => esc_html__( 'List Item #3', 'pixerex' ),
                            ],
                        ],
                    'fields'        => [
                        [
                                'name'        => 'pr_pricing_list_item_text',
                                'label'       => esc_html__( 'Text', 'pixerex' ),
                                'type'        => Controls_Manager::TEXT,
		                'dynamic'       => [ 'active' => true ],
                                'label_block' => true,
                            ],
                            [
                                'name'        => 'pr_pricing_list_item_icon',
                                'label'       => esc_html__( 'Icon', 'pixerex' ),
                                'type'        => Controls_Manager::ICON,
                            ],
                        ],
                    ]
                );

         $this->add_responsive_control('pr_pricing_table_list_align',
            [
                'label'             => __( 'Alignment', 'pixerex' ),
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
                    '{{WRAPPER}} .pr-pricing-list' => 'text-align: {{VALUE}}',
                ],
                'default' => 'center',
            ]
        );
        
        $this->end_controls_section();
        
        /*Button Content Section*/
        $this->start_controls_section('pr_pricing_table_button_section',
                [
                    'label'         => esc_html__('Button', 'pixerex'),
                    'condition'     => [
                        'pr_pricing_table_button_switcher'  => 'yes',
                        ]
                    ]
                );
        
        
        /*Button Text*/ 
        $this->add_control('pr_pricing_table_button_text',
                [
                    'label'         => esc_html__('Text', 'pixerex'),
                    'default'       => esc_html__('Buy Now' , 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
		    'dynamic'       => [ 'active' => true ],
                    'label_block'   => true,
                ]
                );
        
        /*Button url*/ 
        $this->add_control('pr_pricing_table_button_link',
                [
                    'label'         => esc_html__('Link', 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'label_block'   => true,
                ]
                );
        
        
        /*Link Target*/ 
        $this->add_control('pr_pricing_table_button_link_target',
                [
                    'label'         => esc_html__('Link Target', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'description'   => esc_html__( ' Where would you like the link be opened?', 'pixerex' ),
                    'options'       => [
                        'blank'  => esc_html('Blank'),
                        'parent' => esc_html('Parent'),
                        'self'   => esc_html('Self'),
                        'top'    => esc_html('Top'),
                        ],
                    'default'       => esc_html__('blank','pixerex'),
                    'label_block'   => true,
                    ]
                );
        
        /*End Button Settings Section*/
        $this->end_controls_section();
                
        /* Start Title Settings Section */
        $this->start_controls_section('pr_pricing_table_title',
                [
                    'label'         => esc_html__('Display Options', 'pixerex'),
                    ]
                );
        
        $this->add_control('pr_pricing_table_icon_switcher',
                [
                    'label'         => esc_html__('Icon', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                ]
                );
        
        $this->add_control('pr_pricing_table_title_switcher',
                [
                    'label'         => esc_html__('Title', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                ]
                );
        
        $this->add_control('pr_pricing_table_price_switcher',
                [
                    'label'         => esc_html__('Price', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                ]
                );
        
        $this->add_control('pr_pricing_table_list_switcher',
                [
                    'label'         => esc_html__('Features', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                ]
                );
        
        $this->add_control('pr_pricing_table_description_switcher',
                [
                    'label'         => esc_html__('Description', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                ]
                );
        
        $this->add_control('pr_pricing_table_button_switcher',
                [
                    'label'         => esc_html__('Button', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                ]
                );
        
        $this->end_controls_section();
        
        /*Start Styling Section*/

        /*Start Box Style Settings*/
        $this->start_controls_section('pr_pricing_box_style_settings',
                [
                    'label'         => esc_html__('Table', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        $this->start_controls_tabs('pr_pricing_table_box_style_tabs');
        
        $this->start_controls_tab('pr_pricing_table_box_style_normal',
                [
                    'label'         => esc_html__('Normal', 'pixerex'),
                ]
                );
        
        /*Box Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_box_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-table-container',
                    ]
                );
        
        /*Box Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_pricing_table_box_border',
                    'placeholder'    => '1px',
                    'selector'      => '{{WRAPPER}} .pr-pricing-table-container',
                    'fields_options' => [
                        'border' => [
                            'default' => 'solid',
                        ],
                        'width' => [
                            'default' => [
                                'top'      => '1',
                                'right'    => '1',
                                'bottom'   => '1',
                                'left'     => '1',
                                'isLinked' => true,
                            ],
                        ],
				    ],
                ]
                );
        
        /*Box Border Radius*/
        $this->add_control('pr_pricing_table_box_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Box Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Shadow','pixerex'),
                    'name'          => 'pr_pricing_table_box_shadow',
                    'selector'      => '{{WRAPPER}} .pr-pricing-table-container',
                ]
                );
        
        /*Box Margin*/
        $this->add_responsive_control('pr_pricing_box_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Box Padding*/
        $this->add_responsive_control('pr_pricing_box_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 40,
                        'right' => 40,
                        'bottom'=> 40,
                        'left'  => 40,
                        'unit'  => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();

        $this->start_controls_tab('pr_pricing_table_box_style_hover',
        [
            'label'         => esc_html__('Hover', 'pixerex'),
	        ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_box_background_hover',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-table-container:hover',
                    ]
                );
        
        
        /*Box Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_pricing_table_box_border_hover',
                    'selector'      => '{{WRAPPER}} .pr-pricing-table-container:hover',
                ]
                );
        
        /*Box Border Radius*/
        $this->add_control('pr_pricing_table_box_border_radius_hover',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-container:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Box Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Shadow','pixerex'),
                    'name'          => 'pr_pricing_table_box_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pr-pricing-table-container:hover',
                ]
                );
        
        /*Box Margin*/
        $this->add_responsive_control('pr_pricing_box_margin_hover',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-container:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Box Padding*/
        $this->add_responsive_control('pr_pricing_box_padding_hover',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 40,
                        'right' => 40,
                        'bottom'=> 40,
                        'left'  => 40,
                        'unit'  => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-container:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        /*End Box Style Settings*/
        $this->end_controls_section();

        /*Start Icon Style Settings */
        $this->start_controls_section('pr_pricing_icon_style_settings',
                [
                    'label'         => esc_html__('Icon', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pr_pricing_table_icon_switcher'  => 'yes',
                        ]
                ]
                );
        
        /*Icon Color*/
        $this->add_control('pr_pricing_icon_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container i'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_control('pr_pricing_icon_size',
                [
                    'label'         => esc_html__('Size', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'default'       => [
                        'size'  => 25,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container' => 'font-size: {{SIZE}}px',
                    ]
                ]
                );
        
        $this->add_control('pr_pricing_icon_back_color',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container i'  => 'background-color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_responsive_control('pr_pricing_icon_inner_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px','em'],
                    'default'       => [
                        'size'  => 10,
                        'unit'  => 'px'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container i' => 'padding: {{SIZE}}{{UNIT}};',
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_pricing_icon_inner_border',
                    'selector'      => '{{WRAPPER}} .pr-pricing-icon-container i',
                ]
                );
        
        $this->add_control('pr_pricing_icon_inner_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' , 'em'],
                    'default'       => [
                        'size'  => 100,
                        'unit'  => 'px'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container i' => 'border-radius: {{SIZE}}{{UNIT}};',
                    ],
                    'separator'     => 'after'
                ]
                );
        
        $this->add_control('pr_pricing_icon_container_heading',
                [
                    'label'         => esc_html__('Container', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Icon Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_icon_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-icon-container',
                    ]
                );
        
        /*Icon Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_pricing_icon_border',
                    'selector'      => '{{WRAPPER}} .pr-pricing-icon-container',
                ]
                );
        
        /*Icon Border Radius*/
        $this->add_control('pr_pricing_icon_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Icon Margin*/
        $this->add_responsive_control('pr_pricing_icon_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 50,
                        'right' => 0,
                        'bottom'=> 20,
                        'left'  => 0,
                        'unit'	=> 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
        
        /*Icon Padding*/
        $this->add_responsive_control('pr_pricing_icon_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 0,
                        'right' => 0,
                        'bottom'=> 0,
                        'left'  => 0,
                        'unit'	=> 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-icon-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
          
        /*End Icon Style Settings */
        $this->end_controls_section();
        
        /*Start Title Style Settings */
        $this->start_controls_section('pr_pricing_title_style_settings',
                [
                    'label'         => esc_html__('Title', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pr_pricing_table_title_switcher'  => 'yes',
                        ]
                ]
                );
        
        /*Title Color*/
        $this->add_control('pr_pricing_title_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-title'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        /*Title Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'title_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-pricing-table-title',
                ]
                );
        
        /*Title Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_title_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-table-title',
                    ]
                );
        
        /*Title Margin*/
        $this->add_responsive_control('pr_pricing_title_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 0,
                        'right' => 0,
                        'bottom'=> 0,
                        'left'  => 0,
                        'unit'	=> 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
        
        /*Title Padding*/
        $this->add_responsive_control('pr_pricing_title_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'       => [
                        'top'   => 0,
                        'right' => 0,
                        'bottom'=> 20,
                        'left'  => 0,
                        'unit'	=> 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-table-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]      
        );
          
        /*End Title Style Settings */
        $this->end_controls_section();
        
        /*Start Price Style Settings */
        $this->start_controls_section('pr_pricing_price_style_settings',
                [
                    'label'         => esc_html__('Price', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pr_pricing_table_price_switcher'  => 'yes',
                        ]
                ]
                );
        
        $this->add_control('pr_pricing_currency_heading',
                [
                    'label'         => esc_html__('Currency', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
       
        /*Currency Color*/
        $this->add_control('pr_pricing_currency_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-currency'  => 'color: {{VALUE}};'
                        ],
                    ]
                );
        
        /*Currency Typo*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [   
                    'name'          => 'currency_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-pricing-price-currency',
                    ]
                );
        
        $this->add_responsive_control('pr_pricing_currency_align',
                [
                    'label'         => esc_html__( 'Vertical Align', 'pixerex' ),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'top'      => [
                            'title'=> esc_html__( 'Top', 'pixerex' ),
                            'icon' => 'fa fa-long-arrow-up',
                            ],
                        'unset'    => [
                            'title'=> esc_html__( 'Unset', 'pixerex' ),
                            'icon' => 'fa fa-align-justify',
                            ],
                        'bottom'     => [
                            'title'=> esc_html__( 'Bottom', 'pixerex' ),
                            'icon' => 'fa fa-long-arrow-down',
                            ],
                        ],
                    'default'       => 'unset',
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-currency' => 'vertical-align: {{VALUE}};',
                        ],
                    'label_block'   => false
                    ]
                );
        
        $this->add_responsive_control('pr_pricing_currency_margin',
                [
                    'label'             => esc_html__('Margin', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pr-pricing-price-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'separator'     => 'after'
                ]
            ]      
        );
        
        $this->add_control('pr_pricing_price_heading',
                [
                    'label'         => esc_html__('Price', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Price Color*/
        $this->add_control('pr_pricing_price_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-value'  => 'color: {{VALUE}};'
                        ],
                    'separator'     => 'before'
                    ]
                );
        
        /*Price Typo*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'price_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-pricing-price-value',
                    ]
                );
        
        $this->add_responsive_control('pr_pricing_price_margin',
                [
                    'label'             => esc_html__('Margin', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pr-pricing-price-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('pr_pricing_price_container_heading',
                [
                    'label'         => esc_html__('Container', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Price Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_price_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-price-container',
                    ]
                );
        
        /*Price Margin*/
        $this->add_responsive_control('pr_pricing_price_container_margin',
                [
                    'label'             => esc_html__('Margin', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'default'           => [
                        'top'       => 16,
                        'right'     => 0,
                        'bottom'    => 16,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'selectors'         => [
                    '{{WRAPPER}} .pr-pricing-price-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        /*Price Padding*/
        $this->add_responsive_control('pr_pricing_price_padding',
                [
                    'label'             => esc_html__('Padding', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pr-pricing-price-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        /*End Price Style Settings */
        $this->end_controls_section();
        
        /*Start List Style Settings*/
        $this->start_controls_section('pr_pricing_list_style_settings',
                [
                    'label'         => esc_html__('Features', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pr_pricing_table_list_switcher'  => 'yes',
                        ]
                ]
                );
        
        $this->add_control('pr_pricing_features_text_heading',
                [
                    'label'         => esc_html__('Text', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        $this->add_control('pr_pricing_list_text_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list .pr-pricing-list-span'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'list_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-pricing-list .pr-pricing-list-span',
                ]
                );
        
        $this->add_control('pr_pricing_features_icon_heading',
                [
                    'label'         => esc_html__('Icon', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Button Color*/
        $this->add_control('pr_pricing_list_icon_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list i'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_control('pr_pricing_list_icon_size',
                [
                    'label'         => esc_html__('Size', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list i' => 'font-size: {{SIZE}}px',
                    ]
                ]
                );
        
        $this->add_control('pr_pricing_list_icon_spacing',
                [
                    'label'         => esc_html__('Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'default'       => [
                        'size'  => 5
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list i' => 'margin-right: {{SIZE}}px',
                    ],
                ]
                );
        
        $this->add_control('pr_pricing_list_item_margin',
                [
                    'label'         => esc_html__('Vertical Spacing', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list li' => 'margin-bottom: {{SIZE}}px;'
                    ],
                    'separator'     => 'after'
                ]);
        
        $this->add_control('pr_pricing_features_container_heading',
                [
                    'label'         => esc_html__('Container', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_list_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-list-container',
                    ]
                );
        
        /*List Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_pricing_list_border',
                    'selector'      => '{{WRAPPER}} .pr-pricing-list-container',
                ]
                );
        
        /*List Border Radius*/
        $this->add_control('pr_pricing_list_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*List Margin*/
        $this->add_responsive_control('pr_pricing_list_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'default'           => [
                        'top'       => 30,
                        'right'     => 0,
                        'bottom'    => 30,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*List Padding*/
        $this->add_responsive_control('pr_pricing_list_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-list-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_section();
        
        /*Start Description Style Settings */
        $this->start_controls_section('pr_pricing_description_style_settings',
                [
                    'label'         => esc_html__('Description', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pr_pricing_table_description_switcher'  => 'yes',
                        ]
                ]
                );
        
        $this->add_control('pr_pricing_desc_text_heading',
                [
                    'label'         => esc_html__('Text', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Description Color*/
        $this->add_control('pr_pricing_desc_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-description-container'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        /*Description Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'description_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-pricing-description-container',
                ]
            );
        
        $this->add_control('pr_pricing_desc_container_heading',
                [
                    'label'         => esc_html__('Container', 'pixerex'),
                    'type'          => Controls_Manager::HEADING,
                ]
                );
        
        /*Description Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_desc_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-description-container',
                    ]
                );
        
        /*Description Margin*/
        $this->add_responsive_control('pr_pricing_desc_margin',
                [
                    'label'             => esc_html__('Margin', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'default'           => [
                        'top'       => 16,
                        'right'     => 0,
                        'bottom'    => 16,
                        'left'      => 0,
                        'unit'      => 'px',
                    ],
                    'selectors'         => [
                    '{{WRAPPER}} .pr-pricing-description-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        /*Description Padding*/
        $this->add_responsive_control('pr_pricing_desc_padding',
                [
                    'label'             => esc_html__('Padding', 'pixerex'),
                    'type'              => Controls_Manager::DIMENSIONS,
                    'size_units'        => ['px', 'em', '%'],
                    'selectors'         => [
                    '{{WRAPPER}} .pr-pricing-description-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        /*End Description Style Settings */
        $this->end_controls_section();
        
        /*Start Button Style Settings */
        $this->start_controls_section('pr_pricing_button_style_settings',
                [
                    'label'         => esc_html__('Button', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                    'condition'     => [
                        'pr_pricing_table_button_switcher'  => 'yes',
                        ]
                ]
                );
        
        /*Button Color*/
        $this->add_control('pr_pricing_button_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        $this->add_control('pr_pricing_button_hover_color',
                [
                    'label'         => esc_html__('Hover Text Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button:hover'  => 'color: {{VALUE}};'
                        ]
                    ]
                );
        
        /*Button Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'button_typo',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-pricing-price-button',
                ]
                );
        
        $this->start_controls_tabs('pr_pricing_table_button_style_tabs');
        
        $this->start_controls_tab('pr_pricing_table_button_style_normal',
                [
                    'label'         => esc_html__('Normal', 'pixerex'),
                ]
                );
        
        /*Button Background*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_button_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-price-button',
                    ]
                );
        
        /*Button Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_pricing_table_button_border',
                    'selector'      => '{{WRAPPER}} .pr-pricing-price-button',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pr_pricing_table_box_button_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Shadow','pixerex'),
                    'name'          => 'pr_pricing_table_button_box_shadow',
                    'selector'      => '{{WRAPPER}} .pr-pricing-price-button',
                ]
                );
        
        /*Button Margin*/
        $this->add_responsive_control('pr_pricing_button_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Button Padding*/
        $this->add_responsive_control('pr_pricing_button_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();

        $this->start_controls_tab('pr_pricing_table_button_style_hover',
        [
            'label'         => esc_html__('Hover', 'pixerex'),
        ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_pricing_table_button_background_hover',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-pricing-price-button:hover',
                    ]
                );
        
        
        /*Button Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'pr_pricing_table_button_border_hover',
                    'selector'      => '{{WRAPPER}} .pr-pricing-price-button:hover',
                ]
                );
        
        /*Button Border Radius*/
        $this->add_control('pr_pricing_table_button_border_radius_hover',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', 'em' , '%' ],                    
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Button Shadow*/
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => esc_html__('Shadow','pixerex'),
                    'name'          => 'pr_pricing_table_button_shadow_hover',
                    'selector'      => '{{WRAPPER}} .pr-pricing-price-button:hover',
                ]
                );
        
        /*Button Margin*/
        $this->add_responsive_control('pr_pricing_button_margin_hover',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        /*Button Padding*/
        $this->add_responsive_control('pr_pricing_button_padding_hover',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-pricing-price-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        /*End Button Style Section*/
        $this->end_controls_section();     
        
    }

    protected function render($instance = [])
    {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes('pr_pricing_table_title_text');
        $this->add_inline_editing_attributes('pr_pricing_table_description_text', 'advanced');
        $this->add_inline_editing_attributes('pr_pricing_table_button_text');
        $title_tag = $settings['pr_pricing_table_title_size'];
        $link_url = $settings['pr_pricing_table_button_link'];
?>
    
<div class="pr-pricing-table-container">
    <?php if($settings['pr_pricing_table_icon_switcher'] == 'yes') : ?>
    <div class="pr-pricing-icon-container"><i class="<?php echo esc_attr( $settings['pr_pricing_table_icon_selection'] ); ?>"></i></div>
        <?php endif; ?>
    <?php if($settings['pr_pricing_table_price_switcher'] == 'yes') : ?>
    <div class="pr-pricing-price-container">
        <span class="pr-pricing-price-currency">
            <?php echo $settings['pr_pricing_table_price_currency']; ?>
        </span>
        <span class="pr-pricing-price-value">
            <?php echo $settings['pr_pricing_table_price_value']; ?>
        </span>    
    </div>
    <?php endif; ?>
    <?php if($settings['pr_pricing_table_title_switcher'] == 'yes') : ?>
    <<?php echo $title_tag;?> class="pr-pricing-table-title"><span <?php echo $this->get_render_attribute_string('pr_pricing_table_title_text'); ?>><?php echo $settings['pr_pricing_table_title_text'];?></span></<?php echo $title_tag;?>><?php endif; ?>
    <?php if($settings['pr_pricing_table_description_switcher'] == 'yes') : ?>
    <div class="pr-pricing-description-container">
        <div <?php echo $this->get_render_attribute_string('pr_pricing_table_description_text'); ?>>
        <?php echo $settings['pr_pricing_table_description_text']; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if($settings['pr_pricing_table_list_switcher'] == 'yes') : ?>
    <div class="pr-pricing-list-container">
        <ul class="pr-pricing-list">
            <?php foreach($settings['stefancy_text_list_items'] as $item): echo '<li>' . '<i class="' . esc_attr($item['pr_pricing_list_item_icon']) . '">' . '</i>' . '<span class="pr-pricing-list-span">' . esc_attr($item['pr_pricing_list_item_text']) . '</span>' . '</li>';  ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <?php if($settings['pr_pricing_table_button_switcher'] == 'yes') : ?>
    <div class="pr-pricing-button-container">
        <a class="pr-pricing-price-button" target="_<?php echo esc_attr($settings['pr_pricing_table_button_link_target']); ?>" href="<?php echo esc_url($link_url); ?>">
            <span <?php echo $this->get_render_attribute_string('pr_pricing_table_button_text'); ?>><?php echo $settings['pr_pricing_table_button_text']; ?></span>
        </a>
    </div>
    <?php endif; ?>
</div>

    <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type(new PR_Pricing_Table_Widget());
