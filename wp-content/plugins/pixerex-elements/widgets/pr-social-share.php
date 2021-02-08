<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class PR_Social_Share_Widget extends Widget_Base
{

	protected $_has_template_content = false;
	
	private static $medias = [
		'facebook' => [
			'title' => 'Facebook',
			'has_counter' => true,
		],
		'googleplus' => [
			'title' => 'Google+',
		],
		'twitter' => [
			'title' => 'Twitter',
		],
		'pinterest' => [
			'title' => 'Pinterest',
			'has_counter' => true,
		],
		'linkedin' => [
			'title' => 'Linkedin',
			'has_counter' => true,
		],
		'vkontakte' => [
			'title' => 'Vkontakte',
			'has_counter' => true,
		],
		'odnoklassniki' => [
			'title' => 'OK',
			'has_counter' => true,
		],
		'moimir' => [
			'title' => 'Mail.Ru',
			'has_counter' => true,
		],
		'livejournal' => [
			'title' => 'LiveJournal',
		],
		'tumblr' => [
			'title' => 'Tumblr',
			'has_counter' => true,
		],
		'blogger' => [
			'title' => 'Blogger',
		],
		'digg' => [
			'title' => 'Digg',
		],
		'evernote' => [
			'title' => 'Evernote',
		],
		'reddit' => [
			'title' => 'Reddit',
			'has_counter' => true,
		],
		'delicious' => [
			'title' => 'Delicious',
			'has_counter' => true,
		],
		'stumbleupon' => [
			'title' => 'StumbleUpon',
			'has_counter' => true,
		],
		'pocket' => [
			'title' => 'Pocket',
			'has_counter' => true,
		],
		'surfingbird' => [
			'title' => 'Surfingbird',
			'has_counter' => true,
		],
		'liveinternet' => [
			'title' => 'LiveInternet',
		],
		'buffer' => [
			'title' => 'Buffer',
			'has_counter' => true,
		],
		'instapaper' => [
			'title' => 'Instapaper',
		],
		'xing' => [
			'title' => 'Xing',
			'has_counter' => true,
		],
		'wordpress' => [
			'title' => 'Wordpress',
		],
		'baidu' => [
			'title' => 'Baidu',
		],
		'renren' => [
			'title' => 'Renren',
		],
		'weibo' => [
			'title' => 'Weibo',
		],
		// Mobile Device Sharing
		'skype' => [
			'title' => 'Skype',
		],
		'telegram' => [
			'title' => 'Telegram',
		],
		'viber' => [
			'title' => 'Viber',
		],
		'whatsapp' => [
			'title' => 'WhatsApp',
		],
		'line' => [
			'title' => 'LINE',
		],
	];


	private static $medias_class = [
		'googleplus' => 'fa fa-google-plus',
		'pocket'     => 'fa fa-get-pocket',
		'email'      => 'fa fa-envelope',
		'vkontakte'  => 'fa fa-vk',
	];

	private static function get_social_media_class( $media_name ) {
		if ( isset( self::$medias_class[ $media_name ] ) ) {
			return self::$medias_class[ $media_name ];
		}

		return 'fa fa-' . $media_name;
	}
	
    
    public function get_name() {
        return 'pr-social-share';
    }

    public function get_title() {
        return __('Social Share', 'pixerex');
    }

    public function get_icon() {
        return 'eicon-share';
	}
	
	public function get_script_depends() {
		return ['goodshare-js'];
	}

    public function get_categories() {
        return [ 'pr-elements' ];
    }

    protected function _register_controls() {

        /*Start General Section*/
        $this->start_controls_section(
			'section_pr_share_btns_content',
			[
				'label' => esc_html__( 'Share Buttons', 'pixerex' ),
			]
        );
        
        $repeater = new Repeater();

		$medias = self::get_social_media();

		$medias_names = array_keys( $medias );

		$repeater->add_control(
			'button',
			[
				'label' => esc_html__( 'Social Media', 'pixerex' ),
				'type' => Controls_Manager::SELECT,
				'options' => array_reduce( $medias_names, function( $options, $media_name ) use ( $medias ) {
					$options[ $media_name ] = $medias[ $media_name ]['title'];

					return $options;
				}, [] ),
				'default' => 'facebook',
			]
		);

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Custom Label', 'pixerex' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'custom_icon',
			[
				'label' => esc_html__( 'Custom Icon', 'pixerex' ),
				'type' => Controls_Manager::ICON,
			]
		);

		$this->add_control(
			'share_buttons',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [
					[
						'button' => 'facebook',
					],
					[
						'button' => 'googleplus',
					],
					[
						'button' => 'twitter',
					],
					[
						'button' => 'pinterest',
					],
				],
				'title_field' => '{{{ button.replace(/(\b\w)/gi,function(m){return m.toUpperCase();}) }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label'       => esc_html__( 'View', 'pixerex' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'icon-text' => 'Icon & Text',
					'icon'      => 'Icon',
					'text'      => 'Text',
				],
				'default'      => 'icon-text',
				'separator'    => 'before',
				'prefix_class' => 'pixe-social-share-buttons-view-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'show_label',
			[
				'label'     => esc_html__( 'Label', 'pixerex' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'view' => 'icon-text',
				],
			]
		);

		$this->add_control(
			'show_counter',
			[
				'label'     => esc_html__( 'Count', 'pixerex' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'view!' => 'icon',
				],
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'flat'     => esc_html__( 'Flat', 'pixerex' ),
					'framed'   => esc_html__( 'Framed', 'pixerex' ),
					'gradient' => esc_html__( 'Gradient', 'pixerex' ),
					'minimal'  => esc_html__( 'Minimal', 'pixerex' ),
					'boxed'    => esc_html__( 'Boxed Icon', 'pixerex' ),
				],
				'default'      => 'flat',
				'prefix_class' => 'pixe-social-share-buttons-style-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label'   => esc_html__( 'Shape', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'square'  => esc_html__( 'Square', 'pixerex' ),
					'rounded' => esc_html__( 'Rounded', 'pixerex' ),
					'circle'  => esc_html__( 'Circle', 'pixerex' ),
				],
				'default'      => 'square',
				'prefix_class' => 'pixe-social-share-buttons-shape-',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [
					'0' => 'Auto',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'pixe-ep-grid%s-',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'pixerex' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'pixerex' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'pixe-social-share-buttons-align-',
				'condition'    => [
					'columns' => '0',
				],
			]
		);

		$this->add_control(
			'share_url_type',
			[
				'label'   => esc_html__( 'Target URL', 'pixerex' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'current_page' => esc_html__( 'Current Page', 'pixerex' ),
					'custom'       => esc_html__( 'Custom', 'pixerex' ),
				],
				'default'   => 'current_page',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'share_url',
			[
				'label'         => esc_html__( 'URL', 'pixerex' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'placeholder'   => 'http://your-link.com',
				'condition'     => [
					'share_url_type' => 'custom',
				],
				'show_label'         => false,
			]
		);
        
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_buttons_style',
			[
				'label' => esc_html__( 'Share Buttons', 'pixerex' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Columns Gap', 'pixerex' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .pixe-social-share-button' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
					'{{WRAPPER}} .pixe-ep-grid'             => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2);',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Rows Gap', 'pixerex' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .pixe-social-share-button' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_size',
			[
				'label' => esc_html__( 'Button Size', 'pixerex' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.5,
						'max'  => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixe-social-share-button' => 'font-size: calc({{SIZE}}{{UNIT}} * 10);',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'pixerex' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'em' => [
						'min'  => 0.5,
						'max'  => 4,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'em',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'size_units' => [ 'em', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .pixe-social-share-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'text',
				],
			]
		);

		$this->add_responsive_control(
			'button_height',
			[
				'label' => esc_html__( 'Button Height', 'pixerex' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'em' => [
						'min'  => 1,
						'max'  => 7,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'em',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'size_units' => [ 'em', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .pixe-social-share-button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_size',
			[
				'label'      => esc_html__( 'Border Size', 'pixerex' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
					'em' => [
						'max'  => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pixe-social-share-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => [ 'framed', 'boxed' ],
				],
			]
		);

		$this->add_control(
			'color_source',
			[
				'label'       => esc_html__( 'Color', 'pixerex' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'original' => 'Original Color',
					'custom'   => 'Custom Color',
				],
				'default'      => 'original',
				'prefix_class' => 'pixe-social-share-buttons-color-',
				'separator'    => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => esc_html__( 'Normal', 'pixerex' ),
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'     => esc_html__( 'Primary Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pixe-social-share-buttons-style-flat .pixe-social-share-button,
					 {{WRAPPER}}.pixe-social-share-buttons-style-gradient .pixe-social-share-button,
					 {{WRAPPER}}.pixe-social-share-buttons-style-boxed .pixe-social-share-button .pixe-social-share-icon,
					 {{WRAPPER}}.pixe-social-share-buttons-style-minimal .pixe-social-share-button .pixe-social-share-icon' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.pixe-social-share-buttons-style-framed .pixe-social-share-button,
					 {{WRAPPER}}.pixe-social-share-buttons-style-minimal .pixe-social-share-button,
					 {{WRAPPER}}.pixe-social-share-buttons-style-boxed .pixe-social-share-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label'     => esc_html__( 'Secondary Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pixe-social-share-buttons-style-flat .pixe-social-share-icon, 
					 {{WRAPPER}}.pixe-social-share-buttons-style-flat .pixe-social-share-text, 
					 {{WRAPPER}}.pixe-social-share-buttons-style-gradient .pixe-social-share-icon,
					 {{WRAPPER}}.pixe-social-share-buttons-style-gradient .pixe-social-share-text,
					 {{WRAPPER}}.pixe-social-share-buttons-style-boxed .pixe-social-share-icon,
					 {{WRAPPER}}.pixe-social-share-buttons-style-minimal .pixe-social-share-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
				'separator' => 'after',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => esc_html__( 'Hover', 'pixerex' ),
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'primary_color_hover',
			[
				'label'     => esc_html__( 'Primary Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pixe-social-share-buttons-style-flat .pixe-social-share-button:hover,
					 {{WRAPPER}}.pixe-social-share-buttons-style-gradient .pixe-social-share-button:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.pixe-social-share-buttons-style-framed .pixe-social-share-button:hover,
					 {{WRAPPER}}.pixe-social-share-buttons-style-minimal .pixe-social-share-button:hover,
					 {{WRAPPER}}.pixe-social-share-buttons-style-boxed .pixe-social-share-button:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
					'{{WRAPPER}}.pixe-social-share-buttons-style-boxed .pixe-social-share-button:hover .pixe-social-share-icon, 
					 {{WRAPPER}}.pixe-social-share-buttons-style-minimal .pixe-social-share-button:hover .pixe-social-share-icon' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'secondary_color_hover',
			[
				'label'     => esc_html__( 'Secondary Color', 'pixerex' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.pixe-social-share-buttons-style-flat .pixe-social-share-button:hover .pixe-social-share-icon, 
					 {{WRAPPER}}.pixe-social-share-buttons-style-flat .pixe-social-share-button:hover .pixe-social-share-text, 
					 {{WRAPPER}}.pixe-social-share-buttons-style-gradient .pixe-social-share-button:hover .pixe-social-share-icon,
					 {{WRAPPER}}.pixe-social-share-buttons-style-gradient .pixe-social-share-button:hover .pixe-social-share-text,
					 {{WRAPPER}}.pixe-social-share-buttons-style-boxed .pixe-social-share-button:hover .pixe-social-share-icon,
					 {{WRAPPER}}.pixe-social-share-buttons-style-minimal .pixe-social-share-button:hover .pixe-social-share-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_source' => 'custom',
				],
				'separator' => 'after',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'pixerex' ),
				'selector' => '{{WRAPPER}} .pixe-social-share-title, {{WRAPPER}} .pixe-social-share-button-counter',
				'exclude'  => [ 'line_height' ],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Text Padding', 'pixerex' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'view' => 'text',
				],
			]
		);

		$this->end_controls_section();
       
	}
	
	private static function get_social_media( $media_name = null ) {
		if ( $media_name ) {
			return isset( self::$medias[ $media_name ] ) ? self::$medias[ $media_name ] : null;
		}

		return self::$medias;
	}
	
	private function has_counter( $media_name ) {
		$settings = $this->get_active_settings();

		return 'icon' !== $settings['view'] && 'yes' === $settings['show_counter'] && ! empty( self::get_social_media( $media_name )['has_counter'] );
	}
	
	public function render() {

		$settings  = $this->get_active_settings();

		if ( empty( $settings['share_buttons'] ) ) {
			return;
		}

		$show_text = 'text' === $settings['view'] ||  $settings['show_label'];
		?>
		<div class="pixe-social-share pixe-ep-grid">
			<?php
			foreach ( $settings['share_buttons'] as $button ) {
				$social_name = $button['button'];
				$has_counter = $this->has_counter( $social_name );

				if ( 'custom' === $settings['share_url_type'] ) {
					$this->add_render_attribute( 'social-attrs', 'data-url', esc_url( $settings['share_url']['url'] ), true );
				}

				$this->add_render_attribute(
					[
						'social-attrs' => [
							'class' => [
								'pixe-social-share-button',
								'pixe-social-share-button-' . $social_name
							],
							'data-social' => $social_name,
						]
					], '', '', true
				);

				?>
				<div class="pixe-social-share-item pixe-ep-grid-item">
					<div <?php echo $this->get_render_attribute_string( 'social-attrs' ); ?>>
						<?php if ( 'icon' === $settings['view'] || 'icon-text' === $settings['view'] ) : ?>
							<span class="pixe-social-share-icon">
								<i class="<?php echo $button['custom_icon'] ? $button['custom_icon'] : self::get_social_media_class( $social_name ); ?>"></i>
							</span>
						<?php endif; ?>
						<?php if ( $show_text || $has_counter ) : ?>
							<div class="pixe-social-share-text pixe-inline">
								<?php if ( 'yes' === $settings['show_label'] || 'text' === $settings['view'] ) : ?>
									<span class="pixe-social-share-title">
										<?php echo $button['text'] ? $button['text'] : self::get_social_media( $social_name )['title']; ?>
									</span>
								<?php endif; ?>
								<?php if ( $has_counter ) : ?>
									<span class="pixe-social-share-counter" data-counter="<?php echo $social_name; ?>"></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		
		<?php

		
	}
}
Plugin::instance()->widgets_manager->register_widget_type(new PR_Social_Share_Widget());
