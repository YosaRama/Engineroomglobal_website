<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_Nav_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-nav';
	}

	public function get_title() {
		return __( 'Navbar', 'pixerex' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
        return [ 'pr-elements' ];
    }

	protected function _register_controls() {
		// $menus = $this->get_menus();

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Navigation', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_menu_location',
			[
				'label' => __( 'Layout', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default_menu',
				'options' => [
					'default_menu' => __( 'Default Menu', 'pixerex' ),
					'custom_menu' => __( 'Custom Menu', 'pixerex' ),
				],
			]
		);

		$this->add_control(
			'pr_menu_select',
			[
				'label' => __( 'Select Menu', 'pixerex' ),
				'type' => Controls_Manager::SELECT, 'options' => pr_navbar_menu_choices(),
				'default' => '',
				'condition' => [
					'pr_menu_location' => 'custom_menu',
				],
			]
		);

		$this->add_control(
			'pr_menu_layout',
			[
				'label' => __( 'Layout', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Horizontal', 'pixerex' ),
					'vertical' => __( 'Vertical', 'pixerex' ),
				],
			]
		);

		$this->add_responsive_control(
			'pr_menu_align',
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

		$this->add_control(
			'pr_menu_text_padding',
			[
				'label' => __( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu > .menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'submenu_content',
			[
				'label' => __( 'Submenu', 'pixerex' ),
			]
		);

		$this->add_responsive_control(
			'pr_submenu_align',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .sub-menu a' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_sub_padding',
			[
				'label' => __( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .sub-menu a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_style',
			[
				'label' => __( 'Navbar', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_menu_style' );
		
		$this->start_controls_tab(
			'menu_style_normal',
			[
				'label' => __( 'Normal', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_menu_link_color',
			[
				'label' => __( 'Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#777777',
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu > .menu-item > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_menu_link_bg',
			[
				'label' => __( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu > .menu-item > a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'pr_menu_spacing',
			[
				'label' => esc_html__( 'Gap', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu > .menu-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_border',
				'label' => __( 'Border', 'pixerex' ),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .pr-main-menu > .menu-item > a',
				'condition' => [
					'pr_menu_animated_border!' => 'yes',
				],
			]
		);

		$this->add_control(
			'pr_menu_radius',
			[
				'label' => __( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu > .menu-item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'pr_menu_animated_border!' => 'yes',
				],
			]
		);

		$this->add_control(
			'pr_menu_animated_border',
			[
				'label'       => esc_html__( 'Animated Border', 'pixerex' ),
				'description' => esc_html__( 'Enable Animated Border For Menu Links.', 'pixerex' ),
				'type'        => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pr_menu_animated_border_color',
			[
				'label'     => esc_html__( 'Animated Border Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .pr_nav_anime_br .pr-main-menu > .menu-item:hover > a:before ,
					 {{WRAPPER}} .pr_nav_anime_br .pr-main-menu > .menu-item.uk-active > a:before, 
					 {{WRAPPER}} .pr_nav_anime_br .pr-main-menu > .menu-item.current-menu-item > a:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'pr_menu_animated_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'pr_menu_animated_border_height',
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
					'{{WRAPPER}} .pr_nav_anime_br .pr-main-menu > .menu-item > a:before' => 'height: {{SIZE}}px',
				],
				'condition' => [
					'pr_menu_animated_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'pr_menu_animated_border_width',
			[
				'label'     => esc_html__( 'Animated Border Width', 'pixerex' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .pr_nav_anime_br .pr-main-menu > .menu-item:hover > a:before , 
					 {{WRAPPER}} .pr_nav_anime_br .pr-main-menu > .menu-item.current-menu-item > a:before' => 'width: {{SIZE}}px',
				],
				'condition' => [
					'pr_menu_animated_border' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_style_hover',
			[
				'label' => __( 'Hover', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_menu_link_hover_color',
			[
				'label' => __( 'Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu > .menu-item > a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_menu_link_hover_bg_color',
			[
				'label' => __( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu > .menu-item > a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_style_active',
			[
				'label' => __( 'active', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_menu_link_active_color',
			[
				'label' => __( 'Active Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .current-menu-item > a, .pr-main-menu .current_page_item > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_menu_link_active_bg_color',
			[
				'label' => __( 'Active Background', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .current-menu-item > a, .pr-main-menu .current_page_item > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'active_border',
				'label' => __( 'Border', 'pixerex' ),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .pr-main-menu .current-menu-item > a, .pr-main-menu .current_page_item > a',
			]
		);

		$this->add_control(
			'pr_menu_active_radius',
			[
				'label' => __( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .current-menu-item > a, .pr-main-menu .current_page_item > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'navmenu_typography',
				'label' => __( 'Typography', 'pixerex' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pr-nav-primary .pr-main-menu',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_submenu_color',
			[
				'label' => __( 'Submenu', 'pixerex' ),
				'type' => Controls_Manager::SECTION,
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pr_submenu_bg',
			[
				'label' => __( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .sub-menu' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_submenu_spacing',
			[
				'label' => esc_html__( 'Gap Before 1st Level Sub', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => ['px'],
				'default' => ['size' => 20],
				'selectors' => [
					'{{WRAPPER}} .sub-menu' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_submenu_left_spacing',
			[
				'label' => esc_html__( 'Gap Before 2nd Level Sub', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'size_units' => ['px'],
				'default' => ['size' => 220],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .sub-menu .sub-menu' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'submenu_border',
				'label' => __( 'Border', 'pixerex' ),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .pr-main-menu .sub-menu',
			]
		);

		$this->add_control(
			'pr_submenu_radius',
			[
				'label' => __( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_submenu_style' );
		
		$this->start_controls_tab(
			'pr_submenu_style_normal',
			[
				'label' => __( 'Normal', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_submenu_link_color',
			[
				'label' => __( 'Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#777777',
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .sub-menu .menu-item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pr_submenu_style_hover',
			[
				'label' => __( 'Hover', 'pixerex' ),
			]
		);

		$this->add_control(
			'pr_submenu_link_hover',
			[
				'label' => __( 'Text color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#e9204F',
				'selectors' => [
					'{{WRAPPER}} .pr-main-menu .sub-menu .menu-item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'dropdownmenu_typography',
				'label' => __( 'Typography', 'pixerex' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pr-main-menu .sub-menu .menu-item a',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'submenu_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .pr-main-menu .sub-menu',
			]
		);

		$this->end_controls_section();
	}


	protected function render() {

		$settings = $this->get_settings();
		$this->add_render_attribute('primary-navigation', 'class', 'pr-primary-navigation');
		if ( $settings['pr_menu_animated_border'] ) {
			$this->add_render_attribute('primary-navigation', 'class', 'pr_nav_anime_br');
		}

		if($settings['pr_menu_location'] == 'custom_menu'){
			// Get Custom Menu menu
			$nav_menu = ! empty( $settings['pr_menu_select'] ) ? wp_get_nav_menu_object( $settings['pr_menu_select'] ) : false;
			if ( ! $nav_menu ) {
				return;
			}
			$nav_menu_args = array(
				'fallback_cb'       => false,
				'container'         => 'ul',
				'menu_class'        => 'pr-main-menu',
				'theme_location'    => 'default_navmenu', // creating a fake location for better functional control
				'menu'              => $nav_menu,
				'echo'              => true,
				'depth'             => 0,
				'items_wrap'        => '<ul data-uk-scrollspy-nav="closest: li; scroll: false" class="%2$s" id="%1$s">%3$s</ul>',
			);
		}else{

			if ( is_page_template('template-one-page-builder.php') ){
				$menu_location = 'menu-one-page';
			}else{
				$menu_location = 'menu-1';
			}
			// Default Theme Menu
			$nav_menu_args = array(
				'fallback_cb'       => false,
				'container'       => 'ul',
				'menu_class'        => 'pr-main-menu',
				'theme_location'    => $menu_location,
				'echo'              => true,
				'depth'             => 0,
				'items_wrap'      => '<ul data-uk-scrollspy-nav="closest: li; scroll: false" class="%2$s" id="%1$s">%3$s</ul>',
			);
		}

		if ( 'vertical' === $settings['pr_menu_layout'] ) {
			$nav_menu_args['menu_class'] .= ' pr_vertical';
		}

		// echo '<div class="pr-primary-navigation">';
		?>
		<div <?php echo $this->get_render_attribute_string( 'primary-navigation' ); ?>>
			<nav itemtype="http://schema.org/SiteNavigationElement" itemscope="itemscope" class="pr-nav-primary" aria-label="<?php esc_attr_e( 'Elementor Menu', 'pixerex' ); ?>">				
				<?php
					wp_nav_menu(
						apply_filters(
							'widget_nav_menu_args',
							$nav_menu_args,
							$settings
						)
					);
				?>
			</nav>
		</div>
	<?php
	}

}
Plugin::instance()->widgets_manager->register_widget_type( new PR_Nav_Widget() );