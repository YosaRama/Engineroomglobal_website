<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class PR_ImageCarousel_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-imagecarousel';
	}

	public function get_title() {
		return esc_html__( 'Image Carousel', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_script_depends() {
		return ['pr-js','slick-carousel-js'];
	}

    public function get_categories() {
        return [ 'pr-elements' ];
    }
	
	
	protected function _register_controls() {


  		$this->start_controls_section(
  			'pr_carousel_image_content',
  			[
  				'label' => esc_html__( 'Slides', 'pixerex' )
  			]
  		);


		$this->add_control(
			'pr_carousel_image_items',
			[
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'pr_carousel_image_slider_member_name' => 'Image #1',
					],
					[
						'pr_carousel_image_slider_member_name' => 'Image #2',
					],
					[
						'pr_carousel_image_slider_member_name' => 'Image #3',
					],
					[
						'pr_carousel_image_slider_member_name' => 'Image #4',
					],

				],
				'fields' => [
					[
						'name' => 'pr_carousel_image',
						'label' => esc_html__( 'Upload Image', 'pixerex' ),
						'type' => Controls_Manager::MEDIA,
						'default'       => [
						'url'	=> Utils::get_placeholder_image_src(),
						],
					],
					[
						'name'        => 'pr_carousel_image_url',
						'label'         => esc_html__('Link', 'pixerex'),
						'type'          => Controls_Manager::URL,
						'label_block'   => true,
					],

				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'pr_carousel_image_size',
				'default' => 'full',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'pr_carousel_image_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => __( 'Height', 'pixerex' ),
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr_advance_carousel_img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_carousel_image_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => __( 'Width', 'pixerex' ),
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1140,
					],
					'%' => [
						'min' => 50,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .pr_advance_carousel_img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		
		
		$this->start_controls_section(
			'pr_carousel_image_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'pixerex' ),
			]
		);

		$this->add_responsive_control(
            'pr_carousel_image_max_items',
            [
                'label'                 => __( 'Visible Items', 'pixerex' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 3 ],
                'tablet_default'        => [ 'size' => 2 ],
                'mobile_default'        => [ 'size' => 1 ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 10,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
            ]
        );

		$this->add_control(
		  'pr_carousel_image_slide_item',
		  [
		     'label'   => __( 'Slide to Scroll', 'pixerex' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 1,
		     'min'     => 1,
		     'max'     => 100,
		     'step'    => 1,
		  ]
		);

		$this->add_control(
		  'pr_carousel_image_speed',
		  [
		     'label'   => __( 'Slide Speed', 'pixerex' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 300,
		     'min'     => 100,
		     'max'     => 3000,
		     'step'    => 100,
		  ]
		);

		$this->add_control(
            'pr_carousel_image_autoplay',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Autoplay?', 'pixerex'),
                'description' => __('Should the carousel autoplay as in a slideshow.', 'pixerex'),
            ]
        );

		$this->add_control(
			'pr_carousel_image_pause_hover',
			[
				'label' => esc_html__( 'Pause on Hover?', 'pixerex' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
            'pr_carousel_image_draggable',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Draggable?', 'pixerex'),
            ]
		);

		$this->add_control(
            'pr_carousel_image_infinite',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Infinite Loop', 'pixerex'),
            ]
        );
		
		$this->add_control(
            'pr_carousel_image_center_mode',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Center Mode', 'pixerex'),
            ]
        );

		$this->add_control(
            'pr_carousel_image_arrows',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'no',
                'label' => __('Arrows', 'pixerex'),
            ]
        );


        $this->add_control(
            'pr_carousel_image_dots',
            [
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('No', 'pixerex'),
                'label_on' => __('Yes', 'pixerex'),
                'return_value' => 'yes',
                'default' => 'yes',
                'label' => __('Dots navigation', 'pixerex'),
            ]
        );

		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'pr_carousel_image_image_style',
			[
				'label' => esc_html__( 'Image', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);	

		$this->add_responsive_control(
			'pr_carousel_image_item_spacing',
			[
				'label' => esc_html__( 'Item Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'           => [
					'top'       => 15,
					'right'     => 15,
					'bottom'    => 15,
					'left'      => 15,
					'unit'      => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .pr-adv-carousel-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
  
  
		$this->start_controls_tabs( 'pr_carousel_image_tabs_style' );

		$this->start_controls_tab(
			'pr_carousel_image_item_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_carousel_image_item_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-adv-carousel-item',
			]
		);

		$this->add_control(
			'pr_carousel_image_item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .pr-adv-carousel-item' => 'border-radius: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_carousel_image_item_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .pr-adv-carousel-item',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'pr_carousel_image_item_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_control('pr_carousel_image_item_border_hover',
                [
                    'label'         => esc_html__('Border Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-adv-carousel-item:hover'  => 'border-color: {{VALUE}};',
                        ]
                    ]
		);

		

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pr_carousel_image_item_box_shadow_hover',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .pr-adv-carousel-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
  
	$this->end_controls_section();

	$this->start_controls_section(
			'pr_carousel_image_arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_carousel_image_arrows' => 'yes',
				],
			]
		);

		$this->add_responsive_control('pr_carousel_image_arrows_font_size',
		  	[
		     	'label'			=> esc_html__( 'Font Size', 'pixerex' ),
		     	'type' 			=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .pr-adv-carousel-item .slick-prev::before' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .pr-adv-carousel-item .slick-next::before' => 'font-size: {{SIZE}}px;',
				]
		  	]
		);

		$this->add_responsive_control('pr_carousel_image_arrows_bg_size',
		  	[
		     	'label'			=> esc_html__( 'Box Size', 'pixerex' ),
		     	'type' 			=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 400,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .pr-adv-carousel-item .slick-prev' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
					'{{WRAPPER}} .pr-adv-carousel-item .slick-next' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
				]
		  	]
		);
		
		$this->start_controls_tabs( 'pr_carousel_image_arrows_tab_style' );

		$this->start_controls_tab('pr_carousel_image_arrows_normal',
			array(
				'label' => esc_html__( 'Normal', 'pixerex' ),
			)
		);

		$this->add_control('pr_carousel_image_arrows_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-main-adv-carousel .slick-prev::before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .pr-main-adv-carousel .slick-next::before' => 'color: {{VALUE}};',
                        ]
                    ]
        );

		$this->add_control('pr_carousel_image_arrows_back_color',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-main-adv-carousel .slick-prev'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .pr-main-adv-carousel .slick-next'  => 'background-color: {{VALUE}};',
                        ]
                    ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_carousel_image_arrows_border',
				'label' => esc_html__( 'Border', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pr-main-adv-carousel .slick-prev, .pr-main-adv-carousel .slick-next',
			]
		);
		
        
        $this->add_control('pr_carousel_image_arrows_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' , 'em'],
                    'selectors'     => [
						'{{WRAPPER}} .pr-main-adv-carousel .slick-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .pr-main-adv-carousel .slick-next' => 'border-radius: {{SIZE}}{{UNIT}};',
                    ],
                ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('pr_carousel_image_slider_arrows_hover',
			array(
				'label' => esc_html__( 'Hover', 'pixerex' ),
			)
		);

		$this->add_control('pr_carousel_image_arrows_color_hover',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-main-adv-carousel .slick-prev:hover.slick-prev:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .pr-main-adv-carousel .slick-next:hover.slick-next:before' => 'color: {{VALUE}};',
                        ]
                    ]
        );

		$this->add_control('pr_carousel_image_arrows_back_color_hover',
                [
                    'label'         => esc_html__('Background Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-main-adv-carousel .slick-prev:hover'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .pr-main-adv-carousel .slick-next:hover'  => 'background-color: {{VALUE}};',
                        ]
                    ]
		);

		$this->add_control('pr_carousel_image_arrows_border_color_hover',
                [
                    'label'         => esc_html__('Border Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
						'{{WRAPPER}} .pr-main-adv-carousel .slick-prev:hover'  => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .pr-main-adv-carousel .slick-next:hover'  => 'border-color: {{VALUE}};',
                        ]
                    ]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();
        

	$this->end_controls_section();

		$this->start_controls_section(
			'pr_carousel_image_slider_dots_style',
			[
				'label' => esc_html__( 'Dots', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pr_carousel_image_dots' => 'yes',
				],
			]
		);

		$this->add_control(
			'pr_carousel_image_navigation_bg',
			[
				'label' => esc_html__( 'Dots Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .pr-main-adv-carousel .slick-dots li button::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pr-main-adv-carousel .slick-dots li.slick-active button::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pr_carousel_image_bullet_vspacing',
			[
				'label' => esc_html__( 'Vertical Spacing', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .slick-dots' => 'bottom:-{{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'pr_carousel_image_slider_bullet_size',
			[
				'label' => esc_html__( 'Bullet Size', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pr-main-adv-carousel .slick-dots li button::before' => 'font-size:{{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'pr_carousel_image_slider_active_bullet_size',
			[
				'label' => esc_html__( 'Active Bullet Size', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 12,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pr-main-adv-carousel .slick-dots li.slick-active button::before' => 'font-size:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	}


	protected function render( ) {
		
		$settings = $this->get_settings();
		$items = $settings['pr_carousel_image_items'];

		$pr_img_carousel_settings = [
			'pr_carousel_image_arrows' => ('yes' === $settings['pr_carousel_image_arrows']),
			'pr_carousel_image_dots' => ('yes' === $settings['pr_carousel_image_dots']),
			'pr_carousel_image_autoplay' => ('yes' === $settings['pr_carousel_image_autoplay']),
			'pr_carousel_image_draggable' => ('yes' === $settings['pr_carousel_image_draggable']),
			'pr_carousel_image_speed' => absint($settings['pr_carousel_image_speed']),
			'pr_carousel_image_pause_hover' => ('yes' === $settings['pr_carousel_image_pause_hover']),
			'pr_carousel_image_max_items' => $settings['pr_carousel_image_max_items']['size'],
			'pr_carousel_image_max_tab_item' => $settings['pr_carousel_image_max_items_tablet']['size'],
			'pr_carousel_image_max_mobile_item' => $settings['pr_carousel_image_max_items_mobile']['size'],
			'pr_carousel_image_slide_item' => $settings['pr_carousel_image_slide_item'],
			'pr_carousel_image_center_mode' => ('yes' === $settings['pr_carousel_image_center_mode']),
			'pr_carousel_image_infinite' => ('yes' === $settings['pr_carousel_image_infinite']),
		];
	?>
		<div id="pr-img-carousel-<?php echo esc_attr($this->get_id()); ?>" 
			class="pr-main-adv-carousel"
			data-settings='<?php echo wp_json_encode($pr_img_carousel_settings); ?>'>

			<?php foreach ( $items as $item ) : ?>
			<div class="pr-adv-carousel-item">
				<figure class="pr-adv-carousel-fig">
					<?php 
						if( !empty($item['pr_carousel_image_url']['url']) ):
							$item_img_link = $item['pr_carousel_image_url']['url'];
							$external = $item['pr_carousel_image_url']['is_external'] ? 'target="_blank"' : '';
							$no_follow = $item['pr_carousel_image_url']['nofollow'] ? 'rel="nofollow"' : '';?>
							<a href="<?php echo esc_attr( $item_img_link ); ?>" <?php echo $external; ?><?php echo $no_follow; ?>>
						<?php endif; ?>
					<?php
					$image_src = $item['pr_carousel_image'];
					$image_src_size = Group_Control_Image_Size::get_attachment_image_src( $image_src['id'], 'pr_carousel_image_size', $settings );
					if( empty( $image_src_size ) ) : $image_src_size = $image_src['url']; else: $image_src_size = $image_src_size; endif;
					?>
					<div class="pr_advance_carousel_img" style="background-image: url(<?php echo $image_src_size; ?>)"></div>
					<?php if(! empty($item_img_link)):?>
						</a>
					<?php endif; ?>
				</figure>
			</div>
			<?php endforeach; ?>
		</div>

	<?php
	
	}

	protected function content_template() {
		
		?>
		
	
		<?php
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new PR_ImageCarousel_Widget() );