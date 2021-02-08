<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PR_Teams_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-team';
	}

	public function get_title() {
		return __( 'Team Member', 'pixerex' );
	}

	public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }

	protected function _register_controls() {

		$this->start_controls_section(
			'pr_section_team_member_content',
			[
				'label' => esc_html__( 'Content', 'pixerex' )
			]
		);

		$this->add_control(
			'pr_team_member_image',
			[
				'label' => __( 'Team Member Avatar', 'pixerex' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

	  $this->add_control(
		  'pr_team_member_name',
		  [
			  'label' => esc_html__( 'Name', 'pixerex' ),
			  'type' => Controls_Manager::TEXT,
			  'default' => esc_html__( 'John Doe', 'pixerex' ),
		  ]
	  );
	  
	  $this->add_control(
		  'pr_team_member_job_title',
		  [
			  'label' => esc_html__( 'Job Position', 'pixerex' ),
			  'type' => Controls_Manager::TEXT,
			  'default' => esc_html__( 'Software Engineer', 'pixerex' ),
		  ]
	  );
	  
	  $this->add_control(
		  'pr_team_member_description',
		  [
			  'label' => esc_html__( 'Description', 'pixerex' ),
			  'type' => Controls_Manager::TEXTAREA,
			  'default' => esc_html__( 'Add team member description here. Remove the text if not necessary.', 'pixerex' ),
		  ]
	  );
	  

	  $this->end_controls_section();


		$this->start_controls_section(
			'pr_section_team_member_social_profiles',
			[
				'label' => esc_html__( 'Social Icons', 'pixerex' )
			]
		);

	  $this->add_control(
		  'pr_team_member_enable_social_profiles',
		  [
			  'label' => esc_html__( 'Display Social Icons', 'pixerex' ),
			  'type' => Controls_Manager::SWITCHER,
			  'default' => 'yes',
		  ]
	  );
	  
	  
	  $this->add_control(
		  'pr_team_member_social_profile_links',
		  [
			  'type' => Controls_Manager::REPEATER,
			  'condition' => [
				  'pr_team_member_enable_social_profiles!' => '',
			  ],
			  'default' => [
				  [
					  'social' => 'fa fa-facebook',
				  ],
				  [
					  'social' => 'fa fa-twitter',
				  ],
				  [
					  'social' => 'fa fa-google-plus',
				  ],
				  [
					  'social' => 'fa fa-linkedin',
				  ],
			  ],
			  'fields' => [
				  [
					  'name' => 'social',
					  'label' => esc_html__( 'Icon', 'pixerex' ),
					  'type' => Controls_Manager::ICON,
					  'label_block' => true,
					  'default' => 'fa fa-wordpress',
					  'include' => [
						  'fa fa-apple',
						  'fa fa-behance',
						  'fa fa-bitbucket',
						  'fa fa-codepen',
						  'fa fa-delicious',
						  'fa fa-digg',
						  'fa fa-dribbble',
						  'fa fa-envelope',
						  'fa fa-facebook',
						  'fa fa-flickr',
						  'fa fa-foursquare',
						  'fa fa-github',
						  'fa fa-google-plus',
						  'fa fa-houzz',
						  'fa fa-instagram',
						  'fa fa-jsfiddle',
						  'fa fa-linkedin',
						  'fa fa-medium',
						  'fa fa-pinterest',
						  'fa fa-product-hunt',
						  'fa fa-reddit',
						  'fa fa-shopping-cart',
						  'fa fa-slideshare',
						  'fa fa-snapchat',
						  'fa fa-soundcloud',
						  'fa fa-spotify',
						  'fa fa-stack-overflow',
						  'fa fa-tripadvisor',
						  'fa fa-tumblr',
						  'fa fa-twitch',
						  'fa fa-twitter',
						  'fa fa-vimeo',
						  'fa fa-vk',
						  'fa fa-whatsapp',
						  'fa fa-wordpress',
						  'fa fa-xing',
						  'fa fa-yelp',
						  'fa fa-youtube',
					  ],
				  ],
				  [
					  'name' => 'link',
					  'label' => esc_html__( 'Link', 'pixerex' ),
					  'type' => Controls_Manager::URL,
					  'label_block' => true,
					  'default' => [
						  'url' => '',
						  'is_external' => 'true',
					  ],
					  'placeholder' => esc_html__( 'Place URL here', 'pixerex' ),
				  ],
			  ],
			  'title_field' => '<i class="{{ social }}"></i> {{{ social.replace( \'fa fa-\', \'\' ).replace( \'-\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}',
		  ]
	  );

	  $this->end_controls_section();
	  
	  $this->start_controls_section(
		  'pr_section_team_members_styles_general',
		  [
			  'label' => esc_html__( 'General', 'pixerex' ),
			  'tab' => Controls_Manager::TAB_STYLE
		  ]
	  );


	  $this->add_control(
		  'pr_team_members_preset',
		  [
			  'label' => esc_html__( 'Style Preset', 'pixerex' ),
			  'type' => Controls_Manager::SELECT,
			  'default' => 'pr-team-members-simple',
			  'options' => [
				  'pr-team-members-simple' 		=> esc_html__( 'Simple Style', 		'pixerex' ),
				  'pr-team-members-overlay' 	=> esc_html__( 'Overlay Style', 	'pixerex' ),
			  ],
		  ]
	  );

	  $this->add_control(
		  'pr_team_members_background',
		  [
			  'label' => esc_html__( 'Background Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default' => '',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item .pr-team-content' => 'background-color: {{VALUE}};',
			  ],
		  ]
	  );

	  $this->add_responsive_control(
		  'pr_team_members_alignment',
		  [
			  'label' => esc_html__( 'Set Alignment', 'pixerex' ),
			  'type' => Controls_Manager::CHOOSE,
			  'label_block' => true,
			  'options' => [
				  'left' => [
					  'title' => esc_html__( 'Left', 'pixerex' ),
					  'icon' => 'fa fa-align-left',
				  ],
				  'centered' => [
					  'title' => esc_html__( 'Center', 'pixerex' ),
					  'icon' => 'fa fa-align-center',
				  ],
				  'right' => [
					  'title' => esc_html__( 'Right', 'pixerex' ),
					  'icon' => 'fa fa-align-right',
				  ],
			  ],
			  'default' => 'pr-team-align-default',
			  'prefix_class' => 'pr-team-align-',
			  'condition' => [
				'pr_team_members_preset' => 'pr-team-members-simple',
			],
		  ]
	  );

	  $this->add_responsive_control(
		  'pr_team_members_padding',
		  [
			  'label' => esc_html__( 'Content Padding', 'pixerex' ),
			  'type' => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item .pr-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
		  ]
	  );

	  $this->add_group_control(
		  Group_Control_Border::get_type(),
		  [
			  'name' => 'pr_team_members_border',
			  'label' => esc_html__( 'Border', 'pixerex' ),
			  'selector' => '{{WRAPPER}} .pr-team-item',
		  ]
	  );

	  $this->add_control(
		  'pr_team_members_border_radius',
		  [
			  'label' => esc_html__( 'Border Radius', 'pixerex' ),
			  'type' => Controls_Manager::DIMENSIONS,
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
			  ],
		  ]
	  );
	  
	  $this->end_controls_section();
	  
	  
	  $this->start_controls_section(
		  'pr_section_team_members_image_styles',
		  [
			  'label' => esc_html__( 'Image', 'pixerex' ),
			  'tab' => Controls_Manager::TAB_STYLE
		  ]
	  );		

	  $this->add_responsive_control(
		  'pr_team_members_image_width',
		  [
			  'label' => esc_html__( 'Image Width', 'pixerex' ),
			  'type' => Controls_Manager::SLIDER,
			  'default' => [
				  'size' => 100,
				  'unit' => '%',
			  ],
			  'range' => [
				  '%' => [
					  'min' => 0,
					  'max' => 100,
				  ],
				  'px' => [
					  'min' => 0,
					  'max' => 1000,
				  ],
			  ],
			  'size_units' => [ '%', 'px' ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item figure img' => 'width:{{SIZE}}{{UNIT}};',
			  ],
		  ]
	  );


	  $this->add_responsive_control(
		  'pr_team_members_image_margin',
		  [
			  'label' => esc_html__( 'Margin', 'pixerex' ),
			  'type' => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%' ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item figure img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
		  ]
	  );

	  $this->add_responsive_control(
		  'pr_team_members_image_padding',
		  [
			  'label' => esc_html__( 'Padding', 'pixerex' ),
			  'type' => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
		  ]
	  );


	  $this->add_group_control(
		  Group_Control_Border::get_type(),
		  [
			  'name' => 'pr_team_members_image_border',
			  'label' => esc_html__( 'Border', 'pixerex' ),
			  'selector' => '{{WRAPPER}} .pr-team-item figure img',
		  ]
	  );

	  $this->add_control(
		  'pr_team_members_image_border_radius',
		  [
			  'label' => esc_html__( 'Border Radius', 'pixerex' ),
			  'type' => Controls_Manager::DIMENSIONS,
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-item figure img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
			  ],
		  ]
	  );

	  $this->end_controls_section();

	  $this->start_controls_section(
		'pr_team_name_style',
		[
			'label' => __( 'Name', 'pixerex' ),
			'tab' => Controls_Manager::TAB_STYLE
		]
	);

	$this->add_control(
		'pr_team_name_color',
		[
			'label' => __( 'Color', 'pixerex' ),
			'type' => Controls_Manager::COLOR,
			'default'=> '',
			'selectors' => [
				'{{WRAPPER}} .pr-team-item .pr-team-member-name' => 'color: {{VALUE}};',
			]
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'pr_team_name_typography',
			'label' => __( 'Typography', 'pixerex' ),
			'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			'selector' => '{{WRAPPER}} .pr-team-item .pr-team-member-name',
		]
	);

	$this->add_responsive_control(
		'pr_team_name_margin',
		array(
			'label'      => esc_html__( 'Margin', 'pixerex' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', '%', 'em' ),
			'selectors'  => array(
				'{{WRAPPER}} .pr-team-item .pr-team-member-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$this->end_controls_section();

	$this->start_controls_section(
		'pr_team_job_style',
		[
			'label' => __( 'Job Position', 'pixerex' ),
			'tab' => Controls_Manager::TAB_STYLE
		]
	);

	$this->add_control(
		'pr_team_job_color',
		[
			'label' => __( 'Color', 'pixerex' ),
			'type' => Controls_Manager::COLOR,
			'default'=> '',
			'selectors' => [
				'{{WRAPPER}} .pr-team-item .pr-team-member-position' => 'color: {{VALUE}};',
			]
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'pr_team_job_typography',
			'label' => __( 'Typography', 'pixerex' ),
			'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			'selector' => '{{WRAPPER}} .pr-team-item .pr-team-member-position',
		]
	);

	$this->add_responsive_control(
		'pr_team_job_margin',
		array(
			'label'      => esc_html__( 'Margin', 'pixerex' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', '%', 'em' ),
			'selectors'  => array(
				'{{WRAPPER}} .pr-team-item .pr-team-member-position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);


	$this->end_controls_section();

	$this->start_controls_section(
		'pr_team_desc_style',
		[
			'label' => __( 'Description', 'pixerex' ),
			'tab' => Controls_Manager::TAB_STYLE
		]
	);

	$this->add_control(
		'pr_team_desc_color',
		[
			'label' => __( 'Color', 'pixerex' ),
			'type' => Controls_Manager::COLOR,
			'default'=> '',
			'selectors' => [
				'{{WRAPPER}} .pr-team-item .pr-team-content .pr-team-text' => 'color: {{VALUE}};',
			]
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'pr_team_desc_typography',
			'label' => __( 'Typography', 'pixerex' ),
			'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			'selector' => '{{WRAPPER}} .pr-team-item .pr-team-content .pr-team-text',
		]
	);

	$this->add_responsive_control(
		'pr_team_desc_margin',
		array(
			'label'      => esc_html__( 'Margin', 'pixerex' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px', '%', 'em' ),
			'selectors'  => array(
				'{{WRAPPER}} .pr-team-item .pr-team-content .pr-team-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);


	$this->end_controls_section();

	  
	  $this->start_controls_section(
		  'pr_section_team_members_social_profiles_styles',
		  [
			  'label' => esc_html__( 'Social Icons', 'pixerex' ),
			  'tab' => Controls_Manager::TAB_STYLE
		  ]
	  );		


	  $this->add_control(
		  'pr_team_members_social_icon_size',
		  [
			  'label' => esc_html__( 'Icon Box Size', 'pixerex' ),
			  'type' => Controls_Manager::SLIDER,
			  'range' => [
				  'px' => [
					  'min' => 0,
					  'max' => 200,
				  ],
			  ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px;',
			  ],
		  ]
	  );

	  $this->add_responsive_control(
		  'pr_team_members_social_profiles_padding',
		  [
			  'label' => esc_html__( 'Marging', 'pixerex' ),
			  'type' => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
		  ]
	  );


	  $this->start_controls_tabs( 'pr_team_members_social_icons_style_tabs' );

	  $this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'pixerex' ) ] );

	  $this->add_control(
		  'pr_team_members_social_icon_color',
		  [
			  'label' => esc_html__( 'Icon Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a' => 'color: {{VALUE}};',
			  ],
		  ]
	  );
	  
	  
	  $this->add_control(
		  'pr_team_members_social_icon_background',
		  [
			  'label' => esc_html__( 'Background Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default' => '',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a' => 'background-color: {{VALUE}};',
			  ],
		  ]
	  );
	  
	  $this->add_group_control(
		  Group_Control_Border::get_type(),
		  [
			  'name' => 'pr_team_members_social_icon_border',
			  'selector' => '{{WRAPPER}} .pr-team-member-social-link > a',
		  ]
	  );
	  
	  $this->add_control(
		  'pr_team_members_social_icon_border_radius',
		  [
			  'label' => esc_html__( 'Border Radius', 'pixerex' ),
			  'type' => Controls_Manager::SLIDER,
			  'range' => [
				  'px' => [
					  'max' => 100,
				  ],
			  ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a' => 'border-radius: {{SIZE}}px;',
			  ],
		  ]
	  );

	  $this->add_responsive_control(
	  	'pr_team_members_social_icon_typography',
		  [
			'label' => esc_html__( 'Font Size', 'pixerex' ),
			'type' => Controls_Manager::SLIDER,
			  'range' => [
				  'px' => [
					  'max' => 100,
				  ],
			  ],
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a' => 'font-size: {{SIZE}}px;',
				],
		  ]
	  );

	  
	  $this->end_controls_tab();

	  $this->start_controls_tab( 'pr_team_members_social_icon_hover', [ 'label' => esc_html__( 'Hover', 'pixerex' ) ] );

	  $this->add_control(
		  'pr_team_members_social_icon_hover_color',
		  [
			  'label' => esc_html__( 'Icon Hover Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default' => '#ad8647',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a:hover' => 'color: {{VALUE}};',
			  ],
		  ]
	  );

	  $this->add_control(
		  'pr_team_members_social_icon_hover_background',
		  [
			  'label' => esc_html__( 'Hover Background Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default' => '',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a:hover' => 'background-color: {{VALUE}};',
			  ],
		  ]
	  );

	  $this->add_control(
		  'pr_team_members_social_icon_hover_border_color',
		  [
			  'label' => esc_html__( 'Hover Border Color', 'pixerex' ),
			  'type' => Controls_Manager::COLOR,
			  'default' => '',
			  'selectors' => [
				  '{{WRAPPER}} .pr-team-member-social-link > a:hover' => 'border-color: {{VALUE}};',
			  ],
		  ]
	  );
	  
	  $this->end_controls_tab();
	  
	  $this->end_controls_tabs();


	  $this->end_controls_section();


  }


	protected function render( ) {
			
		$settings = $this->get_settings();
		$team_member_classes = $this->get_settings('pr_team_members_preset');
	
	?>


		<div id="pr-team-member-<?php echo esc_attr($this->get_id()); ?>" class="pr-team-item <?php echo $team_member_classes; ?>">
			<div class="pr-team-item-inner">
				<div class="pr-team-image">
					<figure>
						<img src="<?php echo $settings['pr_team_member_image']['url']; ?>" alt="<?php echo $settings['pr_team_member_name'];?>">
					</figure>
				</div>

				<div class="pr-team-content">
					<h3 class="pr-team-member-name"><?php echo $settings['pr_team_member_name']; ?></h3>
					<h4 class="pr-team-member-position"><?php echo $settings['pr_team_member_job_title']; ?></h4>
					<?php if ( ! empty( $settings['pr_team_member_description'] ) ): ?>
						<p class="pr-team-text"><?php echo $settings['pr_team_member_description']; ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $settings['pr_team_member_enable_social_profiles'] ) ): ?>
					<ul class="pr-team-member-social-profiles">
						<?php foreach ( $settings['pr_team_member_social_profile_links'] as $item ) : ?>
							<?php if ( ! empty( $item['social'] ) ) : ?>
								<?php $target = $item['link']['is_external'] ? ' target="_blank"' : ''; ?>
								<li class="pr-team-member-social-link">
									<a href="<?php echo esc_attr( $item['link']['url'] ); ?>"<?php echo $target; ?>><i class="<?php echo esc_attr($item['social'] ); ?>"></i></a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>

	
	<?php
	
	}

	protected function content_template() {
		?>

		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new PR_Teams_Widget() );