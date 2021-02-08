<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_PortfolioGrid_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-portfoliogrid';
	}

	public function get_title() {
		return __( 'Portfolio Grid', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-gallery-masonry';
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
			'pr_portfolio_grid_query_section',
			[
				'label' => __( 'Query Settings', 'pixerex' )
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
			'pr_portfolio_grid_layout_section',
			[
				'label' => __( 'Layout Settings', 'pixerex' )
			]
		);

		$this->add_responsive_control(
			'pr_portfolio_grid_columns',
			[
				'label'          => esc_html__( 'Columns', 'pixerex' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'frontend_available' => true,
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
			'pr_portfolio_grid_masonry',
			[
				'label'       => esc_html__( 'Masonry', 'pixerex' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'pr_portfolio_grid_show_filter_bar',
			[
				'label'       => esc_html__( 'Filter Bar', 'pixerex' ),
				'description' => esc_html__( 'Show The Filter Bar.', 'pixerex' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition' => [
					'prposts_post_type!' => 'page',
				],
			]
		);

		$this->add_control(
			'pr_portfolio_grid_item_ratio',
			[
				'label'   => esc_html__( 'Item Height', 'pixerex' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 250,
				],
				'range' => [
					'px' => [
						'min'  => 50,
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .image.pr_work_image img' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'pr_portfolio_grid_masonry!' => 'yes',

				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'pr_portfolio_grid_box_style_section',
			array(
				'label'      => esc_html__( 'Post Item', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'pr_portfolio_grid_item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'pixerex' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-portfolio-grid.uk-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .pr-portfolio-grid.uk-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'pr_portfolio_grid_row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'pixerex' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-portfolio-grid.uk-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .pr-portfolio-grid.uk-grid> *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'pr_portfolio_grid_bg_overlay',
			array(
				'label' => esc_html__( 'Overlay Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box:hover>.outer>.inner' => 'background-color: {{VALUE}}',
				]
			)
		);
		
		$this->add_control(
			'pr_portfolio_grid_grayscale',
			[
				'label'       => esc_html__( 'Grayscale', 'pixerex' ),
				'description' => esc_html__( 'Apply grayscale filtre to images.', 'pixerex' ),
				'type'        => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pr_portfolio_grid_grayscale_pr',
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
					'pr_portfolio_grid_grayscale' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pr_portfolio_grid_padding',
			[
				'label' => esc_html__( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_portfolio_grid_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer',
			]
		);

		$this->add_control(
			'pr_portfolio_grid_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors' => [
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					// '{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					// '{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.image.pr_work_image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_portfolio_grid_box_shadow',
				'selector' => '{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer',
			]
		);
		$this->add_control(
			'pr_portfolio_grid_shadow_hover_title',
			[
				'label' => __( 'Hover Box Shadow', 'pixerex' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_portfolio_grid_box_shadow_hover',
				'label' => esc_html__( 'Hover Box Shadow', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-portfolio-grid .item.work-box:hover>.outer',
			]
		);

		$this->end_controls_section();

		//Filter Bar Style Tab

		$this->start_controls_section(
			'pr_portfolio_grid_filter_bar_style',
			array(
				'label'      => esc_html__( 'Filter Bar', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => [
					'pr_portfolio_grid_show_filter_bar' => 'yes',
				],
			)
		);

		$this->add_control(
			'pr_portfolio_grid_filter_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'pixerex' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .works-filter-list-container' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pr_portfolio_grid_typography_filter',
				'label'    => esc_html__( 'Typography', 'pixerex' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .works-filter-list li a',
			]
		);

		$this->add_control(
			'pr_portfolio_grid_filter_spacing',
			[
				'label'     => esc_html__( 'Bottom Space', 'pixerex' ),
				'type'      => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .works-filter-list-container' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// normal and hover tabs
		$this->start_controls_tabs( 'pr_portfolio_grid_filter_style_tabs' );

		$this->start_controls_tab(
			'tab_filter_normal',
			[
				'label' => esc_html__( 'Normal', 'pixerex' ),
			]
		);

		$this->add_control(
			'portfolio_filter_color',
			[
				'label'     => esc_html__( 'Text Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333',
				'selectors' => [
					'{{WRAPPER}} .works-filter-list li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'portfolio_filter_bg',
			[
				'label'     => esc_html__( 'Background', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .works-filter-list li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'portfolio_filter_padding',
			[
				'label'      => __('Padding', 'pixerex'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .works-filter-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'portfolio_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .works-filter-list li',
				'condition' => [
					'portfolio_active_filter_animated_border!' => 'yes',
				],
			]
		);

		$this->add_control(
			'portfolio_filter_radius',
			[
				'label'      => __('Radius', 'pixerex'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .works-filter-list li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				],
				'condition' => [
					'portfolio_active_filter_animated_border!' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'portfolio_filter_shadow',
				'selector' => '{{WRAPPER}} .works-filter-list li'
			]
		);

		$this->add_control(
			'portfolio_filter_item_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'pixerex' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .works-filter-list > li:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .works-filter-list > li:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'portfolio_filter_active',
			[
				'label' => esc_html__( 'Active', 'pixerex' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'portfolio_filter_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .works-filter-list li.uk-active > a' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'portfolio_active_filter_bg',
			[
				'label'     => esc_html__( 'Background', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .works-filter-list li.uk-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'portfolio_active_filter_animated_border',
			[
				'label'       => esc_html__( 'Animated Border', 'pixerex' ),
				'description' => esc_html__( 'Enable Animated Border For Active Filter.', 'pixerex' ),
				'type'        => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'portfolio_active_filter_animated_border_color',
			[
				'label'     => esc_html__( 'Animated Border Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .works-filter-list>li>a:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'portfolio_active_filter_animated_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'portfolio_active_filter_animated_border_height',
			[
				'label'     => esc_html__( 'Animated Border Height', 'pixerex' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .works-filter-list>li>a:before' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'portfolio_active_filter_animated_border' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'portfolio_active_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .works-filter-list li.uk-active',
				'condition' => [
					'portfolio_active_filter_animated_border!' => 'yes',
				],
			]
		);

		$this->add_control(
			'portfolio_active_filter_radius',
			[
				'label'      => __('Radius', 'pixerex'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .works-filter-list li.uk-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				],
				'condition' => [
					'portfolio_active_filter_animated_border!' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'portfolio_active_filter_shadow',
				'selector' => '{{WRAPPER}} .works-filter-list li.uk-active'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_filter_hover',
			[
				'label' => esc_html__( 'Hover', 'pixerex' ),
			]
		);

		$this->add_control(
			'portfolio_filter_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .works-filter-list li:hover >a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'portfolio_filter_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .works-filter-list li:hover' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'portfolio_filter_hover_border_color',
			[
				'label'      => __('Border Color', 'pixerex'),
				'type'      => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .works-filter-list li:hover' => 'border-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'portfolio_filter_hover_shadow',
				'selector' => '{{WRAPPER}} .works-filter-list li:hover'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pr_portfolio_grid_title_style',
			array(
				'label'      => esc_html__( 'Title', 'pixerex' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'pr_blog_carousel_title_color',
			array(
				'label'     => esc_html__( 'Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'default'  => '#fff',
				'selectors' => [
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner .title a' => 'color: {{VALUE}};',
				]
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner .title',
			)
		);

		$this->add_responsive_control(
			'pr_blog_carousel_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label' => esc_html__( 'Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default'  => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner .category a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner .category' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner .category',
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pr-portfolio-grid .item.work-box>.outer>.inner .category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
			$control_id = 'prposts';
			$id       = 'pr-post-gallery' . $this->get_id();
			$pr_show_filter = $settings['pr_portfolio_grid_show_filter_bar'];

			$this->add_render_attribute('post-gallery-wrapper', 'class', 'pr-post-gallery-wrapper');
			$this->add_render_attribute('post-gallery', 'id', esc_attr($id) );
			$this->add_render_attribute('post-gallery', 'class', ['pr-portfolio-grid', 'uk-grid', 'uk-grid-medium']);
			$this->add_render_attribute('post-gallery', 'uk-grid', '');
			
			if ( $settings['pr_portfolio_grid_masonry'] ) {
				$this->add_render_attribute('post-gallery', 'uk-grid', 'masonry: true');
			}
			if ( $settings['pr_portfolio_grid_show_filter_bar'] ) {
				$this->add_render_attribute('post-gallery-wrapper', 'uk-filter', 'target: #pr-post-gallery' . $this->get_id());
			}
			$this->add_render_attribute('post-gallery', 'class', 'uk-child-width-1-'. $settings['pr_portfolio_grid_columns_mobile']);
			$this->add_render_attribute('post-gallery', 'class', 'uk-child-width-1-'. $settings['pr_portfolio_grid_columns_tablet'] .'@s');
			$this->add_render_attribute('post-gallery', 'class', 'uk-child-width-1-'. $settings['pr_portfolio_grid_columns'] .'@m');
			$this->add_render_attribute('post-gallery-item', 'class', ['item', 'work-box']);

		?>

			<div <?php echo $this->get_render_attribute_string( 'post-gallery-wrapper' ); ?>>
				<?php
					if ( $pr_show_filter && 'page' !== $settings[ $control_id . '_post_type' ]) {
						$this->render_filter_menu();
					}
				?>
				<div <?php echo $this->get_render_attribute_string( 'post-gallery' ); ?>>
					<?php
						while ( $pr_posts->have_posts() ) : $pr_posts->the_post();

							$post_type = get_post_type();

							$taxonomy = 'category';
					
							if ( 'portfolio' === $post_type ) {
								$taxonomy = 'portfolio_category';
							} 
							$categories_list = get_the_term_list( get_the_ID(), $taxonomy, '', ' / ', '' );
							if ( 'page' !== $post_type ) {
								$term_obj_list = get_the_terms( $pr_posts->ID, $taxonomy );
								$terms_string = join(' ', wp_list_pluck($term_obj_list, 'slug'));
							} 
					?>
						
						<div <?php echo $this->get_render_attribute_string( 'post-gallery-item' ); 
							if ( $pr_show_filter && 'page' !== $post_type ){echo 'data-tag="'.esc_attr($terms_string).'"';}?>>
							<div class="outer">
								<div class="image pr__image__cover pr_work_image">
									<img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])?>" alt="<?php the_title() ?>">
								</div>
								<div class="inner">
									<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<div class="category"><?php echo $categories_list; ?></div>
									<a href="<?php the_permalink(); ?>" class="link uk-position-cover"></a>
								</div>
							</div>
						</div>
					<?php endwhile;
						wp_reset_postdata();
					?>
				</div>
			</div>
			<?php
	}

	public function render_filter_menu(){
		$settings = $this->get_settings();
		$control_id = 'prposts';

		$this->add_render_attribute('post-gallery-filter-container', 'class', ['works-filter-list-container', 'uk-flex']);
		$this->add_render_attribute('post-gallery-filter', 'class', 'works-filter-list');
		if ( $settings['portfolio_active_filter_animated_border'] ) {
			$this->add_render_attribute('post-gallery-filter', 'class', 'pr_anime_br');
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'post-gallery-filter-container' ); ?>>
			<ul <?php echo $this->get_render_attribute_string( 'post-gallery-filter' ); ?>>
				<?php  

					$post_type = $settings[ $control_id . '_post_type' ];

					$taxonomy = 'category';

					if ( 'portfolio' === $post_type ) {
						$taxonomy = 'portfolio_category';
					} 
					$terms = get_terms($taxonomy);

				?>
				<li class="uk-active" uk-filter-control><a href="#">All</a></li>
				<?php foreach ( $terms as $term ) { ?>
					<li uk-filter-control="[data-tag*='<?php echo $term->slug; ?>']"><a href="#"><?php echo $term->name; ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<?php
	}
	

	protected function content_template() {
		?>

		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new PR_PortfolioGrid_Widget() );