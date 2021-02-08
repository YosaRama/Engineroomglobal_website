<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class PR_Dual_Heading_Widget extends Widget_Base
{
    public function get_name() {
        return 'pr-dual-heading';
    }

    public function get_title() {
        return __('Dual Heading', 'pixerex');
    }

    public function get_icon() {
        return 'eicon-heading';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }

    protected function _register_controls() {

        /*Start General Section*/
        $this->start_controls_section('pr_dual_header_general_settings',
                [
                    'label'        => esc_html__('Dual Heading', 'pixerex')
                    ]
                );
        
        /*First Header*/
        $this->add_control('pr_dual_header_first_header_text',
                [
                    'label'         => esc_html__('First Heading', 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__('First', 'pixerex'),
                    'label_block'   => true,
                    ]
                );
        
        /*Title Tag*/
        $this->add_control('pr_dual_header_first_header_tag',
                [
                    'label'         => esc_html__('HTML Tag', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'h2',
                    'options'       => [
                        'h1'    => 'H1',
                        'h2'    => 'H2',
                        'h3'    => 'H3',
                        'h4'    => 'H4',
                        'h5'    => 'H5',
                        'h6'    => 'H6',
                        ],
                    'label_block'   =>  true,
                    ]
                );
        
        /*Second Header*/
        $this->add_control('pr_dual_header_second_header_text',
                [
                    'label'         => esc_html__('Second Heading', 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__('Second', 'pixerex'),
                    'label_block'   => true,
                    ]
                );
        
        /*Title Tag*/
        $this->add_control('pr_dual_header_second_header_tag',
                [
                    'label'         => esc_html__('HTML Tag', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'h2',
                    'options'       => [
                        'h1'    => 'H1',
                        'h2'    => 'H2',
                        'h3'    => 'H3',
                        'h4'    => 'H4',
                        'h5'    => 'H5',
                        'h6'    => 'H6',
                        ],
                    'label_block'   =>  true,
                    ]
                );
        
        /*Text Align*/
        $this->add_control('pr_dual_header_position',
                [
                    'label'         => esc_html__( 'Display', 'pixerex' ),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => [
                        'inline'=> esc_html__('Inline', 'pixerex'),
                        'block' => esc_html__('Block', 'pixerex'),
                        ],
                    'default'       => 'inline',
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-first-container, {{WRAPPER}} .pr-dual-header-second-container' => 'display: {{VALUE}};',
                        ],
                    'label_block'   => true
                    ]
                );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link to', 'pixerex' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'http://your-link.com', 'pixerex' ),
                'separator' => 'before',
            ]
        );
        /*Text Align*/
        $this->add_responsive_control('pr_dual_header_text_align',
                [
                    'label'         => esc_html__( 'Alignment', 'pixerex' ),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'left'      => [
                            'title'=> esc_html__( 'Left', 'pixerex' ),
                            'icon' => 'fa fa-align-left',
                            ],
                        'center'    => [
                            'title'=> esc_html__( 'Center', 'pixerex' ),
                            'icon' => 'fa fa-align-center',
                            ],
                        'right'     => [
                            'title'=> esc_html__( 'Right', 'pixerex' ),
                            'icon' => 'fa fa-align-right',
                            ],
                        ],
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-container' => 'text-align: {{VALUE}};',
                        ],
                    ]
                );
        
        /*End General Settings Section*/
        $this->end_controls_section();
        
        /*Start First Header Styling Section*/
        $this->start_controls_section('pr_dual_header_first_style',
                [
                    'label'         => esc_html__('First Heading', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*First Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'first_header_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-dual-header-first-header',
                    ]
                );
        
        /*First Coloring Style*/
        $this->add_control('pr_dual_header_first_back_clip',
                [
                    'label'         => esc_html__('Background Style', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'color',
                    'description'   => esc_html__('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.','pixerex'),
                    'options'       => [
                        'color'         => esc_html__('Normal Background', 'pixerex'),
                        'clipped'       => esc_html__('Clipped Background', 'pixerex'),
                        ],
                    'label_block'   =>  true,
                    ]
                );
        
        /*First Color*/
        $this->add_control('pr_dual_header_first_color',
                [
                    'label'         => esc_html__('Text Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'condition'     => [
                      'pr_dual_header_first_back_clip' => 'color',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-first-header'   => 'color: {{VALUE}};',
                        ]
                    ]
                );
        
        /*First Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_dual_header_first_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'condition'         => [
                      'pr_dual_header_first_back_clip'  => 'color',
                    ],
                    'selector'          => '{{WRAPPER}} .pr-dual-header-first-header',
                    ]
                );
        
        /*First Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_dual_header_first_clipped_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'condition'         => [
                      'pr_dual_header_first_back_clip'  => 'clipped',
                    ],
                    'selector'          => '{{WRAPPER}} .pr-dual-header-first-header',
                    ]
                );
        
        /*First Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'              => 'first_header_border',
                    'selector'          => '{{WRAPPER}} .pr-dual-header-first-header',
                    ]
                );
        
        /*First Border Radius*/
        $this->add_control('pr_dual_header_first_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-first-header' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        /*First Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => esc_html__('Shadow','pixerex'),
                'name'              => 'pr_dual_header_first_text_shadow',
                'selector'          => '{{WRAPPER}} .pr-dual-header-first-header',
            ]
            );
        
        /*First Margin*/
        $this->add_responsive_control('pr_dual_header_first_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-first-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        /*First Padding*/
        $this->add_responsive_control('pr_dual_header_first_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-first-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        /*End First Header Styling Section*/
        $this->end_controls_section();
        
        /*Start First Header Styling Section*/
        $this->start_controls_section('pr_dual_header_second_style',
                [
                    'label'         => esc_html__('Second Heading', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*Second Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
                [
                    'name'          => 'second_header_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-dual-header-second-header',
                    ]
                );
        
        /*Second Coloring Style*/
        $this->add_control('pr_dual_header_second_back_clip',
                [
                    'label'         => esc_html__('Background Style', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'color',
                    'description'   => esc_html__('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.','pixerex'),
                    'options'       => [
                        'color'         => esc_html__('Normal Background', 'pixerex'),
                        'clipped'       => esc_html__('Clipped Background', 'pixerex'),
                        ],
                    'label_block'   =>  true,
                    ]
                );
        
        /*Second Color*/
        $this->add_control('pr_dual_header_second_color',
                [
                    'label'         => esc_html__('Text Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'condition'     => [
                      'pr_dual_header_second_back_clip' => 'color',
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-second-header'   => 'color: {{VALUE}};',
                        ]
                    ]
                );
        
        /*Second Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_dual_header_second_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'condition'         => [
                      'pr_dual_header_second_back_clip'  => 'color',
                    ],
                    'selector'          => '{{WRAPPER}} .pr-dual-header-second-header',
                    ]
                );
        
        /*Second Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_dual_header_second_clipped_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'condition'         => [
                      'pr_dual_header_second_back_clip'  => 'clipped',
                    ],
                    'selector'          => '{{WRAPPER}} .pr-dual-header-second-header',
                    ]
                );
        
        /*Second Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'              => 'second_header_border',
                    'selector'          => '{{WRAPPER}} .pr-dual-header-second-header',
                ]
                );
        
        /*Second Border Radius*/
        $this->add_control('pr_dual_header_second_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-second-header' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        /*Second Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => esc_html__('Shadow','pixerex'),
                'name'              => 'pr_dual_header_second_text_shadow',
                'selector'          => '{{WRAPPER}} .pr-dual-header-second-header',
            ]
            );
        
        /*Second Margin*/
        $this->add_responsive_control('pr_dual_header_second_margin',
                [
                    'label'         => esc_html__('Margin', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-second-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        /*Second Padding*/
        $this->add_responsive_control('pr_dual_header_second_padding',
                [
                    'label'         => esc_html__('Padding', 'pixerex'),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', 'em', '%' ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-dual-header-second-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        ]
                    ]
                );
        
        /*End Second Header Styling Section*/
        $this->end_controls_section();
       
    }

    protected function render($instance = [])
    {
        // get our input from the widget settings.
        $settings = $this->get_settings();
        $this->add_inline_editing_attributes('pr_dual_header_first_header_text');
        $this->add_inline_editing_attributes('pr_dual_header_second_header_text');
        $first_title_tag = $settings['pr_dual_header_first_header_tag'];
        $second_title_tag = $settings['pr_dual_header_second_header_tag'];
        $first_title_text = $settings['pr_dual_header_first_header_text'] . ' ';
        $second_title_text = $settings['pr_dual_header_second_header_text'];
        $first_clip = '';
        $second_clip = '';
        if( $settings['pr_dual_header_first_back_clip'] === 'clipped' ) : $first_clip = "pr-dual-header-first-clip"; endif; 
        if( $settings['pr_dual_header_second_back_clip'] === 'clipped' ) : $second_clip = "pr-dual-header-second-clip"; endif; 
        
        $full_first_title_tag = '<' . $first_title_tag . ' class="pr-dual-header-first-header ' . $first_clip . '"><span '. $this->get_render_attribute_string('pr_dual_header_first_header_text') . '>' . $first_title_text . '</span></' . $settings['pr_dual_header_first_header_tag'] . '> ';
        
        $full_second_title_tag = '<' . $second_title_tag . ' class="pr-dual-header-second-header ' . $second_clip . '"><span '. $this->get_render_attribute_string('pr_dual_header_second_header_text'). '>' . $second_title_text . '</span></' . $settings['pr_dual_header_second_header_tag'] . '>';
        
        if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'dual-header', 'href', $settings['link']['url'] );

			if ( ! empty( $settings['link']['is_external'] ) ) {
				$this->add_render_attribute( 'dual-header', 'target', '_blank' );
			}
		}
?>
    
<div class="pr-dual-header-container">
    <a <?php echo $this->get_render_attribute_string( 'dual-header' ); ?>>
        <div class="pr-dual-header-first-container"><?php if ( !empty ( $settings['pr_dual_header_first_header_text'] ) ) : echo $full_first_title_tag; endif; ?></div>
        <div class="pr-dual-header-second-container"><?php if ( !empty ( $settings['pr_dual_header_second_header_text'] ) ) : echo $full_second_title_tag; endif; ?></div>
    </a>
</div>

    <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type(new PR_Dual_Heading_Widget());
