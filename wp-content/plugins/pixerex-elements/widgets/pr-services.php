<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_Services_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-services';
	}

	public function get_title() {
		return __( 'Services', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-featured-image';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }

	protected function _register_controls() {

		$this->start_controls_section(
			'pr_services_content',
			[
				'label' => esc_html__( 'Content', 'pixerex' )
			]
		);

		$this->add_control(
			'pr_services_icon',
			[
				'label' => esc_html__( 'Icon', 'pixerex' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-building-o',
			]
		);

	  $this->add_control(
		  'pr_services_title',
		  [
			  'label' => esc_html__( 'Title', 'pixerex' ),
			  'label_block' => true,
			  'type' => Controls_Manager::TEXT,
			  'default' => esc_html__( 'Service Title', 'pixerex' ),
		  ]
		);
		
		$this->add_control(
			'pr_services_title_tag',
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
				'default' => 'h5',
			]
		);

		$this->add_control(
			'pr_services_clickable',
			[
				'label' => __( 'Service Box Clickable', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __( 'Yes', 'pixerex' ),
				'label_off' => __( 'No', 'pixerex' ),
				'return_value' => 'yes',
			]
		);

	$this->add_control(
		'pr_services_button_url',
		[
			'label'       => esc_html__( 'Link', 'pixerex' ),
			'type'        => Controls_Manager::URL,
			'placeholder' => 'http://your-link.com',
			'default' => [
				'url' => '',
			],
			'condition'	=> [
				'pr_services_clickable'	=> 'yes'
			]
		]
	);
	  
	$this->end_controls_section();

	$this->start_controls_section(
		  'pr_services_generale_styles',
		  [
			  'label' => esc_html__( 'Generale', 'pixerex' ),
			  'tab' => Controls_Manager::TAB_STYLE
		  ]
	);		


	  $this->start_controls_tabs( 'tabs_generale_style' );

	  $this->start_controls_tab(
		  'tab_normal',
		  [
			  'label' => esc_html__( 'Normal', 'pixerex' ),
		  ]
	  );

	  $this->add_control(
		  'pr_services_bg_color',
		  [
			  'label' => esc_html__( 'Background Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default' => '#f3f3f3',
			  'selectors' => [
				  '{{WRAPPER}} .pr-service-box-item' => 'background-color: {{VALUE}}',
				],
				]
	  );

	  $this->add_control(
		  'pr_services_title_color',
		  [
			  'label'     => esc_html__( 'Title Color', 'pixerex' ),
			  'type'      => Controls_Manager::COLOR,
			  'default' => '#101010',
			  'selectors' => [
				'{{WRAPPER}} .pr-service-box-item > .pr-service-box-inner > .title' => 'color: {{VALUE}}',
			],
			]
	  );

	  $this->add_group_control(
		  Group_Control_Typography::get_type(),
		  	[
			  'name'     => 'pr_services_title_typography',
			  'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			  'selector' => '{{WRAPPER}} .pr-service-box-item > .pr-service-box-inner > .title',
			]
	  );

	  $this->add_responsive_control(
		  'pr_services_padding',
		[
			  'label'      => esc_html__( 'Padding', 'pixerex' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .pr-service-box-item > .pr-service-box-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	  );

	  $this->add_responsive_control(
		  'pr_services_border_radius',
		  [
			  'label'      => esc_html__( 'Border Radius', 'pixerex' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%' ],
			  'selectors'  => [
				'{{WRAPPER}} .pr-service-box-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	  );

	  $this->add_group_control(
		  Group_Control_Border::get_type(),
		  [
			  'name'        => 'pr_services_border',
			  'label'       => esc_html__( 'Border', 'pixerex' ),
			  'placeholder' => '1px',
			  'default'     => '1px',
			  'selector'    => '{{WRAPPER}} .pr-service-box-item',
		]
	  );

	  $this->add_group_control(
		  Group_Control_Box_Shadow::get_type(),
		  [
			  'name'     => 'pr_services_box_shadow',
			  'selector' => '{{WRAPPER}} .pr-service-box-item',
		]
	  );

	  $this->end_controls_tab();

	  $this->start_controls_tab(
		  'tab_hover',
		  [
			  'label' => esc_html__( 'Hover', 'pixerex' ),
		  ]
	  );

	  $this->add_control(
		  'pr_services_hover_bg_color',
		  [
			  'label'     => esc_html__( 'Background Color', 'pixerex' ),
			  'type'      => Controls_Manager::COLOR,
			  'selectors' => [
				'{{WRAPPER}} .pr-service-box-item:hover' => 'background-color: {{VALUE}}',
			 ],
		]
	  );

	  $this->add_control(
		  'pr_services_title_hover_color',
		[
			  'label'     => esc_html__( 'Title Color', 'pixerex' ),
			  'type'      => Controls_Manager::COLOR,
			  'selectors' => [
				'{{WRAPPER}} .pr-service-box-item:hover > .pr-service-box-inner > .title' => 'color: {{VALUE}}',
			],
		]
	  );

	  $this->add_responsive_control(
		  'pr_services_hover_padding',
		[
			  'label'      => esc_html__( 'Padding', 'pixerex' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .pr-service-box-item:hover > .pr-service-box-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	  );

	  $this->add_responsive_control(
		  'pr_services_hover_border_radius',
		  [
			  'label'      => esc_html__( 'Border Radius', 'pixerex' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%' ],
			  'selectors'  => [
				'{{WRAPPER}} .pr-service-box-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			]
	  );

	  $this->add_group_control(
		  Group_Control_Border::get_type(),
		  [
			  'name'        => 'pr_services_hover_border',
			  'label'       => esc_html__( 'Border', 'pixerex' ),
			  'placeholder' => '1px',
			  'default'     => '1px',
			  'selector'    => '{{WRAPPER}} .pr-service-box-item:hover',
		  ]
	  );

	  $this->add_group_control(
		  Group_Control_Box_Shadow::get_type(),
		  [
			  'name'     => 'pr_services_hover_box_shadow',
			  'selector' => '{{WRAPPER}} .pr-service-box-item:hover',
		]
	  );

	  $this->end_controls_tab();

	  $this->end_controls_tabs();

	  $this->end_controls_section();

	  $this->start_controls_section(
		'pr_services_icon_style',
		[
			'label' => esc_html__( 'Icons', 'pixerex' ),
			'tab' => Controls_Manager::TAB_STYLE
		]
  );		


	$this->start_controls_tabs( 'tabs_icon_style' );

	$this->start_controls_tab(
		'tab_icon_normal',
		[
			'label' => esc_html__( 'Normal', 'pixerex' ),
		]
	);

	$this->add_responsive_control(
		'pr_services_icon_size',
		[
			'label' => __( 'Overlay Icon Size', 'pixerex' ),
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
			'{{WRAPPER}} .pr-service-box-item > .pr-service-box-inner > .pr-service-box-icon-wrap i' => 'font-size: {{SIZE}}px;',
			],
		]
	);

	$this->add_responsive_control(
		'pr_services_icon_position',
		[
			'label' => __( 'Overlay Icon position', 'pixerex' ),
		   'type' => Controls_Manager::SLIDER,
			'range' => [
			'px' => [
				'min' => 0,
				'max' => 100,
				'step' => 1,
			]
			],
			'selectors' => [
			'{{WRAPPER}} .pr-service-box-item > .pr-service-box-inner > .pr-service-box-icon-wrap' => 'left: -{{SIZE}}px;',
			],
		]
	);

	$this->add_control(
		'pr_services_more_icon_color',
	  [
			'label'     => esc_html__( 'Arrow Icon Color', 'pixerex' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
			  '{{WRAPPER}} .pr-service-box-item > .pr-service-box-inner > i' => 'color: {{VALUE}}',
		  ],
	  ]
	);

	$this->add_responsive_control(
		'pr_services_more_icon_size',
		[
			'label' => __( 'Arrow Icon Size', 'pixerex' ),
		   'type' => Controls_Manager::SLIDER,
			'default' => [
			'size' => 24,
			],
			'range' => [
			'px' => [
				'min' => 10,
				'max' => 100,
				'step' => 1,
			]
			],
			'selectors' => [
			'{{WRAPPER}} .pr-service-box-item > .pr-service-box-inner > i' => 'font-size: {{SIZE}}px;',
			],
		]
	);

	$this->end_controls_tab();

	$this->start_controls_tab(
		'tab_icon_hover',
		[
			'label' => esc_html__( 'Hover', 'pixerex' ),
		]
	);

	$this->add_control(
		'pr_services_icon_hover_color',
	  [
			'label'     => esc_html__( 'Overlay Icon Color', 'pixerex' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
			  '{{WRAPPER}} .pr-service-box-item:hover > .pr-service-box-inner > .pr-service-box-icon-wrap i' => 'color: {{VALUE}}',
		  ],
	  ]
	);

	$this->add_control(
		'pr_services_more_icon_hover_color',
	  [
			'label'     => esc_html__( 'Arrow Icon Color', 'pixerex' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
			  '{{WRAPPER}} .pr-service-box-item:hover > .pr-service-box-inner > i' => 'color: {{VALUE}}',
		  ],
	  ]
	);

	$this->end_controls_tab();

 	$this->end_controls_section();

  }


	protected function render( ) {
			
		$settings = $this->get_settings();
		$service_btn_link = $settings['pr_services_button_url']['url'];
		if ( ! empty( $settings['pr_services_button_url']['url'] ) ) {
			$this->add_render_attribute( 'button_url', 'href', $settings['pr_services_button_url']['url'] );

			if ( $settings['pr_services_button_url']['is_external'] ) {
				$this->add_render_attribute( 'button_url', 'target', '_blank' );
			}

			if ( ! empty( $settings['pr_services_button_url']['nofollow'] ) ) {
				$this->add_render_attribute( 'button_url', 'rel', 'nofollow' );
			}
		}
	?>
		<div id="pr-service-box-<?php echo esc_attr($this->get_id()); ?>" class="pr-service-box-item">
			<div class="pr-service-box-inner">
				<div class="pr-service-box-icon-wrap">
					<i class="<?php echo esc_attr( $settings['pr_services_icon'] ); ?>"></i>
				</div>
				<<?php echo $settings['pr_services_title_tag']; ?> class="title"><?php echo $settings['pr_services_title']; ?></<?php echo $settings['pr_services_title_tag']; ?>>
				<i class="icon icon-right-arrow"></i>
				<?php if( 'yes' == $settings['pr_services_clickable'] ) : ?>
					<a <?php echo $this->get_render_attribute_string( 'button_url' ); ?> class="link uk-position-cover"></a>
				<?php endif;?>
			</div>
		</div>

	
	<?php
	
	}

	protected function content_template() {
		?>

		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new PR_Services_Widget() );