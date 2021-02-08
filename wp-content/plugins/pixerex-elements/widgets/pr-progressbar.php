<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class PR_Progressbar_Widget extends Widget_Base
{
    public function get_name() {
        return 'pr-progressbar';
    }

    public function get_title() {
        return esc_html__('Progress Bar', 'pixerex');
    }
    
    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_categories() {
        return [ 'pr-elements' ];
    }
    
    public function get_script_depends()
    {
        return ['pr-js', 'waypoints'];
    }

    
protected function _register_controls() {

        /* Start Progress Content Section */
        $this->start_controls_section('pr_progressbar_labels',
                [
                    'label'         => esc_html__('Progress Bar Settings', 'pixerex'),
                    ]
                );
        
        /*Left Label*/ 
        $this->add_control('pr_progressbar_left_label',
                [
                    'label'         => esc_html__('Title', 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__('My Skill','pixerex'),
                    'label_block'   => true,
                ]
                );

        /*Right Label*/ 
        $this->add_control('pr_progressbar_right_label',
                [
                    'label'         => esc_html__('Percentage', 'pixerex'),
                    'type'          => Controls_Manager::TEXT,
                    'default'       => esc_html__('50%','pixerex'),
                    'label_block'   => true,
                ]
                );
    
        /*Progressbar Width*/
        $this->add_control('pr_progressbar_progress_percentage',
            [
                'label'             => esc_html__('Value', 'pixerex'),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'size' => 50,
                    'unit' =>  '%',
                ],
            ]
        );
        
        /*Progress Bar Style*/
        $this->add_control('pr_progressbar_progress_style', 
                [
                    'label'         => esc_html__('Type', 'pixerex'),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'solid',
                    'options'       => [
                        'solid'    => esc_html__('Solid', 'pixerex'),
                        'stripped' => esc_html__('Stripped', 'pixerex'),
                        ],
                    ]
                );
        
        /*Progress Bar Animated*/
        $this->add_control('pr_progressbar_progress_animation', 
                [
                    'label'         => esc_html__('Animated', 'pixerex'),
                    'type'          => Controls_Manager::SWITCHER,
                    'condition'     => [
                        'pr_progressbar_progress_style'    => 'stripped'
                        ]
                    ]
                );
        
        /*End Progress General Section*/
    $this->end_controls_section();

        /*Start Styling Section*/
        /*Start progressbar Settings*/
        $this->start_controls_section('pr_progressbar_progress_bar_settings',
            [
                'label'             => esc_html__('Progress Bar', 'pixerex'),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        /*Progressbar Height*/ 
        $this->add_control('pr_progressbar_progress_bar_height',
                [
                    'label'         => esc_html__('Height', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'default'       => [
                        'size'  => 25,
                        ],
                    'label_block'   => true,
                    'selectors'     => [
                        '{{WRAPPER}} .pr-progressbar-progress, {{WRAPPER}} .pr-progressbar-progress-bar' => 'height: {{SIZE}}px;',   
                    ]
                ]
                );

        /*Border Radius*/
        $this->add_control('pr_progressbar_progress_bar_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'default'       => [
                        'unit'  => 'px',
                        'size'  => 0,
                        ],
                    'range'         => [
                        'px'  => [
                            'min' => 0,
                            'max' => 60,
                            ],
                        ],
                    'selectors'     => [
                        '{{WRAPPER}} .pr-progressbar-progress-bar, {{WRAPPER}} .pr-progressbar-progress' => 'border-radius: {{SIZE}}{{UNIT}};',
                        ]
                    ]
                );
        
        $this->add_control('pr_progressbar_ind_background_hint',
                [
                    'label'             =>  esc_html__('Indicator Background', 'pixerex'),
                    'type'              => Controls_Manager::HEADING,
                ]
                );
        
        /*Progress Bar Color Type*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_progressbar_progress_color',
                    'types'             => [ 'classic' , 'gradient' ],
                    'default'           => [
                        'color' => '#26beca',
                    ],
                    'selector'          => '{{WRAPPER}} .pr-progressbar-progress-bar',
                    ]
                );
        
        $this->add_control('pr_progressbar_main_background_hint',
                [
                    'label'             =>  esc_html__('Main Background', 'pixerex'),
                    'type'              => Controls_Manager::HEADING,
                ]
                );
        
        /*Progress Bar Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'pr_progressbar_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .pr-progressbar-progress',
                    ]
                );
        $this->add_responsive_control('pr_progressbar_container_margin',
            [
                'label'             => esc_html__('Margin', 'pixerex'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pr-progressbar-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        /*End Progress Bar Section*/
        $this->end_controls_section();

        /*Start Labels Settings Section*/
        $this->start_controls_section('pr_progressbar_labels_section',
                [
                    'label'         => esc_html__('Labels', 'pixerex'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        $this->add_control('pr_progressbar_left_label_hint',
                [
                    'label'             =>  esc_html__('Title', 'pixerex'),
                    'type'              => Controls_Manager::HEADING,
                ]
                );
        
        /*Left Label Color*/
        $this->add_control('pr_progressbar_left_label_color',
                [
                    'label'         => esc_html__('Color', 'pixerex'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                    '{{WRAPPER}} .pr-progressbar-left-label' => 'color: {{VALUE}};',
                ]
            ]
         );
        
        /*Left Label Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'left_label_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-progressbar-left-label',
                    ]
                );
        
        
        /*Left Label Margin*/
        $this->add_responsive_control('pr_progressbar_left_label_margin',
            [
                'label'             => esc_html__('Margin', 'pixerex'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pr-progressbar-left-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('pr_progressbar_right_label_hint',
                [
                    'label'             =>  esc_html__('Percentage', 'pixerex'),
                    'type'              => Controls_Manager::HEADING,
                    'separator'         => 'before'
                ]
                );
        
        /*Right Label Color*/
        $this->add_control('pr_progressbar_right_label_color',
             [
                'label'             => esc_html__('Color', 'pixerex'),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                'selectors'        => [
                    '{{WRAPPER}} .pr-progressbar-right-label' => 'color: {{VALUE}};',
                ]
            ]
         );
        
        /*Right Label Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'right_label_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .pr-progressbar-right-label',
                    ]
                );
        
        /*Right Label Margin*/
        $this->add_responsive_control('pr_progressbar_right_label_margin',
            [
                'label'             => esc_html__('Margin', 'pixerex'),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .pr-progressbar-right-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        

        /*End Labels Settings Section*/
        $this->end_controls_section();
    }

    protected function render($instance = [])
    {
        // get our input from the widget settings.
        $settings = $this->get_settings();
        $this->add_inline_editing_attributes('pr_progressbar_left_label');
        $this->add_inline_editing_attributes('pr_progressbar_right_label');
        
        $progressbar_settings = [
            'progress_length'    => $settings['pr_progressbar_progress_percentage']['size']
        ];
?>

   <div class="pr-progressbar-container">
        <p class="pr-progressbar-left-label"><span <?php echo $this->get_render_attribute_string('pr_progressbar_left_label'); ?>><?php echo $settings['pr_progressbar_left_label'];?></span></p>
        <p class="pr-progressbar-right-label"><span <?php echo $this->get_render_attribute_string('pr_progressbar_right_label'); ?>><?php echo $settings['pr_progressbar_right_label'];?></span></p>
            <div class="clearfix"></div>
            <div class="pr-progress pr-progressbar-progress">
                <div class=" pr-progressbar-progress-bar progress-bar <?php if( $settings['pr_progressbar_progress_style'] === 'solid' ){ echo "";} elseif( $settings['pr_progressbar_progress_style'] === 'stripped' ){ echo "progress-bar-striped";}?> <?php if( $settings['pr_progressbar_progress_animation'] === 'yes' ){ echo "active";}?>" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-settings='<?php echo wp_json_encode($progressbar_settings); ?>'>
                </div>
            </div>
        </div>
    <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type(new PR_Progressbar_Widget());