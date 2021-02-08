<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_PostGrid_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-postgrid';
	}

	public function get_title() {
		return __( 'Posts', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }
    
    public function get_script_depends()
    {
        return ['pr-js','imagesloaded-js','masonry-js'];
    }

	protected function _register_controls() {
		$this->start_controls_section(
			'pr_section_post_grid_filters',
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

        $this->end_controls_section();

        $this->start_controls_section(
			'pr_section_post_grid_layout',
			[
				'label' => __( 'Layout Settings', 'pixerex' )
			]
		);

		$this->add_control(
			'pr_post_grid_columns',
			[
				'label' => esc_html__( 'Columns', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'pr-col-3',
				'options' => [
					'pr-col-1' => esc_html__( '1', 'pixerex' ),
					'pr-col-2' => esc_html__( '2',   'pixerex' ),
					'pr-col-3' => esc_html__( '3', 'pixerex' ),
					'pr-col-4' => esc_html__( '4',  'pixerex' ),
					'pr-col-5' => esc_html__( '5',  'pixerex' ),
				],
			]
		);
		
		$this->add_control(
            'pr_show_image',
            [
                'label' => esc_html__( 'Show Posts Featured Image', 'pixerex' ),
                'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
            ]
		);
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'exclude' => [ 'custom' ],
				'default' => 'medium',
				'condition' => [
                    'pr_show_image' => 'yes',
                ]
			]
		);


		$this->add_control(
            'pr_show_title',
            [
                'label' => __( 'Show Title', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
            ]
        );
				
        $this->add_control(
			'pr_show_excerpt',
                [
                    'label'         => esc_html__('Excerpt', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                    ]
                );

        $this->add_control(
			'pr_excerpt_length',
                [
                    'label'         => esc_html__('Excerpt Length', 'pixerex'),
                    'type'          => Controls_Manager::NUMBER,
                    'default'       => 20,
                    'label_block'   => true,
                    'condition'     => [
                        'pr_show_excerpt'  => 'yes',
                        ]
                    ]
				);
		$this->add_control(
			'pr_posts_meta',
			[
				'label'         => esc_html__('Posts Meta', 'pixerex'),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => 'yes',
			]
		);
        
        $this->add_control(
			'pr_posts_author_meta',
        [
            'label'         => esc_html__('Author Meta', 'pixerex'),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => 'yes',
            'condition'     => [
                'pr_posts_meta'  => 'yes',
                ]
            ]
        );

        $this->add_control('pr_posts_date_meta',
                [
                    'label'         => esc_html__('Date Meta', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                    'condition'     => [
                        'pr_posts_meta'  => 'yes',
                        ]
                    ]
                );

        $this->add_control('pr_posts_categories_meta',
                [
                    'label'         => esc_html__('Categories Meta', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'yes',
                    'condition'     => [
                        'pr_posts_meta'  => 'yes',
                        ]
                    ]
                );

		
		$this->add_control(
			'pr_show_read_more',
			[
				'label'             => esc_html__( 'Show Read More Button', 'pixerex' ),
				'type'              => Controls_Manager::SWITCHER,
				'default'           => 'yes',
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
						]
				]
		);


		$this->end_controls_section();

		$this->start_controls_section(
            'pr_section_post_grid_style',
            [
                'label' => __( 'Column', 'pixerex' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_responsive_control(
			'pr_post_grid_spacing',
			[
				'label' => esc_html__( 'Spacing Between Items', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-grid-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
			'pr_post_grid_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .pr-grid-post-holder' => 'background-color: {{VALUE}}',
				]
			)
		);

		$this->add_responsive_control(
			'pr_post_grid_padding',
			[
				'label' => esc_html__( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-entry-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_post_grid_border',
				'label' => esc_html__( 'Border for post', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-grid-post-holder',
			]
		);

		$this->add_control(
			'pr_post_grid_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .pr-grid-post-holder' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_post_grid_box_shadow',
				'selector' => '{{WRAPPER}} .pr-grid-post-holder',
			]
		);
		$this->add_control(
			'pr_post_grid_box_shadow_hover_title',
			[
				'label' => __( 'Hover Box Shadow', 'pixerex' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_post_grid_box_shadow_hover',
				'label' => esc_html__( 'Hover Box Shadow', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-grid-post-holder:hover',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pr_post_grid_title_style',
			array(
				'label'      => esc_html__( 'Title', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_title_color' );

		$this->start_controls_tab(
			'tab_pr_post_grid_title_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_control(
			'pr_post_grid_title_color',
			array(
				'label'     => esc_html__( 'Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => [
					'{{WRAPPER}} .pr-entry-title, {{WRAPPER}} .pr-entry-title a' => 'color: {{VALUE}};',
				]
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pr_post_grid_title_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_control(
			'pr_post_grid_title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => [
					'{{WRAPPER}} .pr-entry-title:hover, {{WRAPPER}} .pr-entry-title a:hover' => 'color: {{VALUE}};',
				]
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pr-entry-title',
			)
		);

		$this->add_responsive_control(
			'pr_post_grid_title_alignment',
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
					'{{WRAPPER}} .pr-entry-title' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'pr_post_grid_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'pr_meta_layout',
            [
                'label' => __( 'Mete Layout', 'pixerex' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'above' => 'Above Title',
					'below' => 'Below Title',
					'after_cnt' => 'After Content'
                ],
                'default' => 'below',

            ]
        );

		$this->add_control(
			'meta_color',
			array(
				'label'  => esc_html__( 'Text Color', 'pixerex' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} .pr-entry-meta' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_link_color',
			array(
				'label' => esc_html__( 'Links Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-entry-meta a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_link_color_hover',
			array(
				'label' => esc_html__( 'Links Hover Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pr-entry-meta a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pr-entry-meta',
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-entry-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .pr-entry-meta' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();


        $this->start_controls_section(
            'pr_section_content_style',
            [
                'label' => __( 'excerpt', 'pixerex' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'pr_post_grid_excerpt_color',
			[
				'label' => __( 'Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '',
				'selectors' => [
					'{{WRAPPER}} .pr-grid-post-excerpt p' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pr_post_grid_excerpt_typography',
				'label' => __( 'Typography', 'pixerex' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pr-grid-post-excerpt p',
			]
		);

		$this->add_responsive_control(
			'pr_post_grid_excerpt_alignment',
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
					'{{WRAPPER}} .pr-grid-post-excerpt' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'pr_post_grid_excerpt_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-grid-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'condition'     => [
					'pr_show_read_more'  => 'yes',
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

        ?>

		<div id="pr-post-grid-<?php echo esc_attr($this->get_id()); ?>" class="pr-post-grid-container <?php echo esc_attr($settings['pr_post_grid_columns'] ); ?>">
		    <div class="pr-post-grid pr-post-appender-<?php echo esc_attr( $this->get_id() ); ?>">
				<?php
					while ( $pr_posts->have_posts() ) : $pr_posts->the_post();
		
						$post_type = get_post_type();

						$taxonomy = 'category';
				
						if ( 'portfolio' === $post_type ) {
							$taxonomy = 'portfolio_category';
						} 
						$categories_list = get_the_term_list( get_the_ID(), $taxonomy, '', ', ', '' );
						?>
							<article class="pr-grid-post pr-post-grid-column">
								<div class="pr-grid-post-holder">
									<div class="pr-grid-post-holder-inner">

										<?php if ($thumbnail_exists = has_post_thumbnail()): ?>
                                            <div class="pr-entry-media">
                                                <div class="pr-entry-thumbnail">
													<a href="<?php echo get_permalink(); ?>">
														<?php if($settings['pr_show_image'] == 'yes'){ ?>
														<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>" alt="<?php the_title() ?>">
														<?php } ?>
													</a>
                                                </div>
                                            </div>
										<?php endif; ?>

										<div class="pr-entry-wrapper">
											<?php if($settings['pr_posts_meta'] == 'yes' && $settings['pr_meta_layout'] == 'above'){ ?>
												<div class="pr-entry-meta">
													<?php if($settings['pr_posts_author_meta'] == 'yes'){ ?>
													<span class="pr-author"><?php esc_html_e( 'by ', 'pixerex' ); ?><?php the_author_posts_link(); ?></span>
													<?php } ?>
													<?php if($settings['pr_posts_date_meta'] == 'yes'){ ?>
													<span class="pr-date"><span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span></span>
													<?php } ?>
													<?php if($settings['pr_posts_categories_meta'] == 'yes'){ ?>
													<span class="pr-cat"><?php echo $categories_list; ?></span>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if($settings['pr_show_title'] == 'yes'){ ?>
											<h2 class="pr-entry-title"><a class="pr-grid-post-link" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
											<?php } ?>
											<?php if($settings['pr_posts_meta'] == 'yes' && $settings['pr_meta_layout'] == 'below'){ ?>
												<div class="pr-entry-meta">
													<?php if($settings['pr_posts_author_meta'] == 'yes'){ ?>
													<span class="pr-author"><?php esc_html_e( 'by ', 'pixerex' ); ?><?php the_author_posts_link(); ?></span>
													<?php } ?>
													<?php if($settings['pr_posts_date_meta'] == 'yes'){ ?>
													<span class="pr-date"><span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span></span>
													<?php } ?>
													<?php if($settings['pr_posts_categories_meta'] == 'yes'){ ?>
													<span class="pr-cat"><?php echo $categories_list; ?></span>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if($settings['pr_show_excerpt']== 'yes'){ ?>
											<div class="pr-grid-post-excerpt">
												<p><?php echo  pr_get_excerpt_by_id(get_the_ID(),$settings['pr_excerpt_length']);?></p>
											</div>
											<?php } ?>
											<?php if($settings['pr_posts_meta'] == 'yes' && $settings['pr_meta_layout'] == 'after_cnt'){ ?>
												<div class="pr-entry-meta">
													<?php if($settings['pr_posts_author_meta'] == 'yes'){ ?>
													<span class="pr-author"><?php esc_html_e( 'by ', 'pixerex' ); ?><?php the_author_posts_link(); ?></span>
													<?php } ?>
													<?php if($settings['pr_posts_date_meta'] == 'yes'){ ?>
													<span class="pr-date"><span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span></span>
													<?php } ?>
													<?php if($settings['pr_posts_categories_meta'] == 'yes'){ ?>
													<span class="pr-cat"><?php echo $categories_list; ?></span>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if($settings['pr_show_read_more'] == 'yes'){ ?>
											<div class="pr-readmore-warp">
												<a href="<?php echo get_permalink(); ?>" class="btn btn-primary elementor-button elementor-size-md pr-readmore-btn" title="<?php the_title(); ?>"><?php echo $settings['pr_posts_read_more_text']; ?></a>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</article>
					<?php endwhile;
					wp_reset_postdata();
				?>
			</div>
		    <div class="clearfix"></div>
		</div>
        <?php
	}

	protected function content_template() {
		?>

		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new PR_PostGrid_Widget() );