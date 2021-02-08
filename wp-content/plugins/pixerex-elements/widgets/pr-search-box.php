<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_Search_Box_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-search-box';
	}

	public function get_title() {
		return __( 'Search Box', 'pixerex' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
        return [ 'pr-elements' ];
    }

	protected function _register_controls() {
		// $menus = $this->get_menus();

		$this->start_controls_section(
			'pr_section_content',
			[
				'label' => __( 'Search', 'pixerex' ),
			]
		);

		$this->add_responsive_control(
			'pr_search_align',
			[
				'label' => __( 'Alignment', 'pixerex' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'pixerex' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'pixerex' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'pixerex' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .pr-search-icon-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		// $this->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'pr_search_typography',
		// 		'label' => __( 'Typography', 'pixerex' ),
		// 		'scheme' => Scheme_Typography::TYPOGRAPHY_1,
		// 		'selector' => '{{WRAPPER}} .search-icon',
		// 	]
		// );

		$this->add_responsive_control(
			'pr_search_typography',
			[
				'label' => esc_html__( 'Icon Font Size', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .search-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_section_search_style',
			[
				'label' => __( 'Icon', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pr_search_icon_color',
			[
				'label' => __( 'Primary Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .search-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_search_icon_padding',
			[
				'label' => __( 'Search Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'pixerex' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .search-icon',
			]
		);

		$this->add_control(
			'pr_search_icon_border_radius',
			[
				'label' => __( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .search-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_section_search_borders',
			[
				'label' => __( 'Overlay', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pr_overlay_bg_color',
			[
				'label' => __( 'Overlay Background', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => 'rgba(0, 0, 0, .94)',
				'selectors' => [
					'{{WRAPPER}} .search-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_input_text_color',
			[
				'label' => __( 'Primary Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#eee',
				'selectors' => [
					'{{WRAPPER}} .search-box' => 'color: {{VALUE}};',
					'{{WRAPPER}} .fullscreen-search-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .search-close' => 'color: {{VALUE}};',
					
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'input_border',
				'label' => __( 'Border', 'pixerex' ),
				'default' => '3px',
				'selector' => '{{WRAPPER}} .search-box',
			]
		);

		$this->add_control(
			'pr_search_input_border_radius',
			[
				'label' => __( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .search-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pr_input_fcbr_color',
			[
				'label' => __( 'Input Focus Border Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => 'rgba(0, 0, 0, .94)',
				'selectors' => [
					'{{WRAPPER}} .search-box:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings(); 
		$id       = $this->get_id(); 
		$this->add_render_attribute( 'search-icon', 'id', 'search-icon-'.$id);
		$this->add_render_attribute( 'search-icon', 'class', 'search-icon');
		$this->add_render_attribute( 'search-overlay', 'id', 'search-overlay-'.$id);
		$this->add_render_attribute( 'search-overlay', 'class', 'search-overlay');
		// $this->add_render_attribute( 'modal', 'uk-modal', '' );
		?>
		<div class="pr-search-icon-wrapper">
		<div <?php echo $this->get_render_attribute_string( 'search-icon' ); ?>>
				<i class="fa fa-search"></i>
			</div>
		</div>
		<div <?php echo $this->get_render_attribute_string( 'search-overlay' ); ?>>
			<span class="search-close"></span>
			<form method="get" class="fullscreen-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input class="search-box" name="s" placeholder="Search...">
				<i class="fa fa-search fullscreen-search-icon"></i>
			</form>
		</div>

<script type="text/javascript">

  jQuery(document).ready(function($) {

	$(document).ready(function() {
		var search_icon = $("#search-icon-<?php echo esc_attr($this->get_id()); ?>");
		search_icon.on('click', function() {
		   $('#search-overlay-<?php echo esc_attr($this->get_id()); ?>').addClass('open');
		});
	   
		$('.search-close').on('click', function() {
		  $('#search-overlay-<?php echo esc_attr($this->get_id()); ?>').removeClass('open');
		});
	  });

  });
</script> 
		<?php
	}

	protected function _content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new PR_Search_Box_Widget() );