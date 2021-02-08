<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_Site_Logo_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-site-logo';
	}

	public function get_title() {
		return __( 'Site Logo', 'pixerex' );
	}

	public function get_icon() {
		return 'eicon-site-logo';
	}

	public function get_categories() {
        return [ 'pr-elements' ];
    }

	protected function _register_controls() {
		// $menus = $this->get_menus();

		$this->start_controls_section(
			'pr_section_content',
			[
				'label' => __( 'Site Logo', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_site_logo',
			[
				'label' => __( 'Logo Type', 'pixerex' ),
				'description' => __( 'you must set youre logo using the theme customizer', 'pixerex' ),
				'type' => Controls_Manager::SELECT, 'options' => [
					'title' => __( 'Title', 'pixerex' ),
					'logo' => __( 'Logo', 'pixerex' ),
				],
				'default' => 'title',
			]
		);

		$this->add_responsive_control(
			'pr_logo_alignment',
			[
				'label' => __( 'Alignment', 'pixerex' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->end_controls_section();

		//image style
		$this->start_controls_section(
			'pr_section_image_style',
			[
				'label' => __( 'Logo Image', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_site_logo' => 'logo',
				],
			]
		);

		$this->add_responsive_control(
			'pr_logo_img_width',
			[
				'label' => __( 'Width', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_logo_img_max_width',
			[
				'label' => __( 'Max Width', 'pixerex' ) . ' (%)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_section_title_style',
			[
				'label' => __( 'Logo', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pr_branding_title_color',
			[
				'label' => __( 'Title Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'pr_site_logo' => 'title',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding .site-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_branding_title_hover',
			[
				'label' => __( 'Hover', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'pr_site_logo' => 'title',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding .site-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_title_padding',
			[
				'label' => __( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'pr_site_logo' => 'title',
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding .site-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'pixerex' ),
				'condition' => [
					'pr_site_logo' => 'title',
				],
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pr-site-branding .site-title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-site-branding',
			]
		);

		$this->add_control(
			'pr_logo_border_radius',
			[
				'label' => __( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_section_desc_style',
			[
				'label' => __( 'Description', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_site_logo' => 'title',
				],
			]
		);

		$this->add_control(
			'pr_branding_description_color',
			[
				'label' => __( 'Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'pr_site_logo' => 'title',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding .site-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_logo_desc_padding',
			[
				'label' => __( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'pr_site_logo' => 'title',
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-site-branding .site-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Typography', 'pixerex' ),
				'condition' => [
					'pr_site_logo' => 'title',
				],
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pr-site-branding .site-description',
			]
		);

		$this->end_controls_section();

	}

	protected function branding_output() {
		$settings = $this->get_settings();

		if ( $settings['pr_site_logo'] == 'title' ) {
			$this->render_title();
		} elseif ( $settings['pr_site_logo'] == 'logo' ) {
			$this->render_logo();
		}
	}

	protected function elementor_the_site_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}

	protected function render_title() {
	?>
		<span class="site-title">
		<?php
			$title = get_bloginfo( 'name' );
		?>
						
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $title ); /* WPCS: xss ok. */ ?>" alt="<?php echo esc_attr( $title ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>		
		</span>
		<?php
			$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) :
		?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
		<?php
		endif;
	}

	protected function render_logo() {
		$this->elementor_the_site_logo();
	}

	protected function render() {

		$settings = $this->get_settings();
		?>
		
		<div id="pr-site-branding" class="pr-site-branding">
			<div class="header-title">
			<?php
				$this->branding_output();
			?>
			
			</div>
		</div>
		<?php
	}

}
Plugin::instance()->widgets_manager->register_widget_type( new PR_Site_Logo_Widget() );