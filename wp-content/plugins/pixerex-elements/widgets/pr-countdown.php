<?php
namespace Elementor;
if( !defined( 'ABSPATH' ) ) exit; // No access of directly access

class PR_Counter_Down_Widget extends Widget_Base {
	public function get_name() {
		return 'pr-countdown-timer';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'pixerex' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}
    
    public function is_reload_preview_required() {
        return true;
    }	
    
    public function get_script_depends() {
		return [ 'pr-js','count-down-timer-js' ];
	}

	public function get_categories() {
		return [ 'pr-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'pr_countdown_global_settings',
			[
				'label'		=> esc_html__( 'Countdown', 'pixerex' )
			]
		);

		$this->add_control(
			'pr_countdown_style',
		  	[
		     	'label'			=> esc_html__( 'Style', 'pixerex' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'options' 		=> [
		     		'd-u-s' => esc_html__( 'Inline', 'pixerex' ),
		     		'd-u-u' => esc_html__( 'Block', 'pixerex' ),
		     	],
		     	'default'		=> 'd-u-u'
		  	]
		);

		$this->add_control(
			'pr_countdown_date_time',
		  	[
		     	'label'			=> esc_html__( 'Due Date', 'pixerex' ),
		     	'type' 			=> Controls_Manager::DATE_TIME,
		     	'picker_options'	=> [
		     		'format' => 'Ym/d H:m:s'
		     	],
		     	'default' => date( "Y/m/d H:m:s", strtotime("+ 1 Day") ),
				'description' => esc_html__( 'Date format is (yyyy/mm/dd). Time format is (hh:mm:ss). Example: 2020-01-01 09:30.', 'pixerex' )
		  	]
		);

		$this->add_control(
			'pr_countdown_s_u_time',
			[
				'label' 		=> esc_html__( 'Time Zone', 'pixerex' ),
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'wp-time'			=> esc_html__('WordPress Default', 'pixerex' ),
					'user-time'			=> esc_html__('User Local Time', 'pixerex' )
				],
				'default'		=> 'wp-time',
				'description'	=> esc_html__('This will set the current time of the option that you will choose.', 'pixerex')
			]
		);

		$this->add_control(
			'pr_countdown_units',
		  	[
		     	'label'			=> esc_html__( 'Time Units', 'pixerex' ),
		     	'type' 			=> Controls_Manager::SELECT2,
				'description' => esc_html__('Select the time units that you want to display in countdown timer.', 'pixerex' ),
				'options'		=> [
					'Y'     => esc_html__( 'Years', 'pixerex' ),
					'O'     => esc_html__( 'Month', 'pixerex' ),
					'W'     => esc_html__( 'Week', 'pixerex' ),
					'D'     => esc_html__( 'Day', 'pixerex' ),
					'H'     => esc_html__( 'Hours', 'pixerex' ),
					'M'     => esc_html__( 'Minutes', 'pixerex' ),
					'S' 	=> esc_html__( 'Second', 'pixerex' ),
				],
				'default' 		=> [
					'O',
                    'D',
					'H',
					'M',
					'S'
				],
				'multiple'		=> true,
				'separator'		=> 'after'
		  	]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_countdown_on_expire_settings',
			[
				'label' => esc_html__( 'Expire' , 'pixerex' )
			]
		);

		$this->add_control(
			'pr_countdown_expire_text_url',
			[
				'label'			=> esc_html__('Expire Type', 'pixerex'),
				'label_block'	=> false,
				'type'			=> Controls_Manager::SELECT,
                'description'   => esc_html__('Choose whether if you want to set a message or a redirect link', 'pixerex'),
				'options'		=> [
					'text'		=> esc_html__('Message', 'pixerex'),
					'url'		=> esc_html__('Redirection Link', 'pixerex')
				],
				'default'		=> 'text'
			]
		);

		$this->add_control(
			'pr_countdown_expiry_text_',
			[
				'label'			=> esc_html__('On expiry Text', 'pixerex'),
				'type'			=> Controls_Manager::WYSIWYG,
				'default'		=> esc_html__('Countdown is finished!','prmeium_elementor'),
				'condition'		=> [
					'pr_countdown_expire_text_url' => 'text'
				]
			]
		);

		$this->add_control(
			'pr_countdown_expiry_redirection_',
			[
				'label'			=> esc_html__('Redirect To', 'pixerex'),
				'type'			=> Controls_Manager::TEXT,
				'condition'		=> [
					'pr_countdown_expire_text_url' => 'url'
				],
				'default'		=> get_permalink( 1 )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_countdown_transaltion',
			[
				'label' => esc_html__( 'Strings Translation' , 'pixerex' )
			]
		);

		$this->add_control(
			'pr_countdown_day_singular',
		  	[
		     	'label'			=> esc_html__( 'Day (Singular)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Day'
		  	]
		);

		$this->add_control(
			'pr_countdown_day_plural',
		  	[
		     	'label'			=> esc_html__( 'Day (Plural)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Days'
		  	]
		);

		$this->add_control(
			'pr_countdown_week_singular',
		  	[
		     	'label'			=> esc_html__( 'Week (Singular)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Week'
		  	]
		);

		$this->add_control(
			'pr_countdown_week_plural',
		  	[
		     	'label'			=> esc_html__( 'Weeks (Plural)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Weeks'
		  	]
		);


		$this->add_control(
			'pr_countdown_month_singular',
		  	[
		     	'label'			=> esc_html__( 'Month (Singular)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Month'
		  	]
		);


		$this->add_control(
			'pr_countdown_month_plural',
		  	[
		     	'label'			=> esc_html__( 'Months (Plural)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Months'
		  	]
		);


		$this->add_control(
			'pr_countdown_year_singular',
		  	[
		     	'label'			=> esc_html__( 'Year (Singular)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Year'
		  	]
		);


		$this->add_control(
			'pr_countdown_year_plural',
		  	[
		     	'label'			=> esc_html__( 'Years (Plural)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Years'
		  	]
		);


		$this->add_control(
			'pr_countdown_hour_singular',
		  	[
		     	'label'			=> esc_html__( 'Hour (Singular)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Hour'
		  	]
		);


		$this->add_control(
			'pr_countdown_hour_plural',
		  	[
		     	'label'			=> esc_html__( 'Hours (Plural)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Hours'
		  	]
		);


		$this->add_control(
			'pr_countdown_minute_singular',
		  	[
		     	'label'			=> esc_html__( 'Minute (Singular)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Minute'
		  	]
		);

		$this->add_control(
			'pr_countdown_minute_plural',
		  	[
		     	'label'			=> esc_html__( 'Minutes (Plural)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Minutes'
		  	]
		);

        $this->add_control(
			'pr_countdown_second_singular',
		  	[
		     	'label'			=> esc_html__( 'Second (Singular)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Second',
		  	]
		);
        
		$this->add_control(
			'pr_countdown_second_plural',
		  	[
		     	'label'			=> esc_html__( 'Seconds (Plural)', 'pixerex' ),
		     	'type' 			=> Controls_Manager::TEXT,
		     	'default'		=> 'Seconds'
		  	]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pr_countdown_typhography',
			[
				'label' => esc_html__( 'Digits' , 'pixerex' ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'pr_countdown_digit_color',
			[
				'label' 		=> esc_html__( 'Color', 'pixerex' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-amount' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pr_countdown_digit_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-amount',
			]
		);
        
        
        $this->add_control(
			'pr_countdown_timer_digit_bg_color',
			[
				'label' 		=> esc_html__( 'Background Color', 'pixerex' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-amount' => 'background-color: {{VALUE}};'
				]
			]
		);
        

		$this->add_responsive_control(
			'pr_countdown_digit_bg_size',
		[
			'label'			=> esc_html__( 'Padding', 'pixerex' ),
			'type'          => Controls_Manager::DIMENSIONS,
			'size_units'    => ['px', 'em', '%'],
			'selectors'     => [
				'{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-amount' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
			]
		]);
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'          => 'pr_countdown_digits_border',
                    'selector'      => '{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-amount',
                ]);

        $this->add_control('pr_countdown_digit_border_radius',
                [
                    'label'         => esc_html__('Border Radius', 'pixerex'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-amount' => 'border-radius: {{SIZE}}{{UNIT}};'
                        ]
                    ]
                );
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_countdown_unit_style', 
            [
                'label'         => esc_html__('Units', 'pixerex'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
            );

        $this->add_control(
			'pr_countdown_unit_color',
			[
				'label' 		=> esc_html__( 'Color', 'pixerex' ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-period' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pr_countdown_unit_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .countdown .pr_countdown-section .pr_countdown-period',
			]
		);
        
            $this->add_responsive_control(
			'pr_countdown_separator_width',
			[
				'label'			=> esc_html__( 'Spacing in Between', 'pixerex' ),
				'type' 			=> Controls_Manager::SLIDER,
				'default' 		=> [
					'size' => 40,
				],
				'range' 		=> [
					'px' 	=> [
						'min' => 0,
						'max' => 200,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pr_countdown-section' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render( ) {
		
      	$settings = $this->get_settings();

      	$target_date = str_replace('-', '/', $settings['pr_countdown_date_time'] );
        
      	$formats = $settings['pr_countdown_units'];
      	$format = implode('', $formats );
      	$time = str_replace('-', '/', current_time('mysql') );
      	$serverSync = '';
      	if( $settings['pr_countdown_s_u_time'] == 'wp-time' ) : 
			$sent_time = $time;
        else:
            $sent_time = '';
        endif;

		$redirect = !empty( $settings['pr_countdown_expiry_redirection_'] ) ? esc_url($settings['pr_countdown_expiry_redirection_']) : '';
        
      	// Singular labels set up
      	$y = !empty( $settings['pr_countdown_year_singular'] ) ? $settings['pr_countdown_year_singular'] : 'Year';
      	$m = !empty( $settings['pr_countdown_month_singular'] ) ? $settings['pr_countdown_month_singular'] : 'Month';
      	$w = !empty( $settings['pr_countdown_week_singular'] ) ? $settings['pr_countdown_week_singular'] : 'Week';
      	$d = !empty( $settings['pr_countdown_day_singular'] ) ? $settings['pr_countdown_day_singular'] : 'Day';
      	$h = !empty( $settings['pr_countdown_hour_singular'] ) ? $settings['pr_countdown_hour_singular'] : 'Hour';
      	$mi = !empty( $settings['pr_countdown_minute_singular'] ) ? $settings['pr_countdown_minute_singular'] : 'Minute';
      	$s = !empty( $settings['pr_countdown_second_singular'] ) ? $settings['pr_countdown_second_singular'] : 'Second';
      	$label = $y."," . $m ."," . $w ."," . $d ."," . $h ."," . $mi ."," . $s;

      	// Plural labels set up
      	$ys = !empty( $settings['pr_countdown_year_plural'] ) ? $settings['pr_countdown_year_plural'] : 'Years';
      	$ms = !empty( $settings['pr_countdown_month_plural'] ) ? $settings['pr_countdown_month_plural'] : 'Months';
      	$ws = !empty( $settings['pr_countdown_week_plural'] ) ? $settings['pr_countdown_week_plural'] : 'Weeks';
      	$ds = !empty( $settings['pr_countdown_day_plural'] ) ? $settings['pr_countdown_day_plural'] : 'Days';
      	$hs = !empty( $settings['pr_countdown_hour_plural'] ) ? $settings['pr_countdown_hour_plural'] : 'Hours';
      	$mis = !empty( $settings['pr_countdown_minute_plural'] ) ? $settings['pr_countdown_minute_plural'] : 'Minutes';
      	$ss = !empty( $settings['pr_countdown_second_plural'] ) ? $settings['pr_countdown_second_plural'] : 'Seconds';
      	$labels1 = $ys."," . $ms ."," . $ws ."," . $ds ."," . $hs ."," . $mis ."," . $ss;
      	
        $expire_text = $settings['pr_countdown_expiry_text_'];
        
      	$pcdt_style = $settings['pr_countdown_style'] == 'd-u-s' ? ' side' : ' down';
        
        if( $settings['pr_countdown_expire_text_url'] == 'text' ){
            $event = 'onExpiry';
            $text = $expire_text;
        }
        
        if( $settings['pr_countdown_expire_text_url'] == 'url' ){
            $event = 'expiryUrl';
            $text = $redirect;
        }
        $countdown_settings = [
            'label1'    => $label,
            'label2'    => $labels1,
            'until'     => $target_date,
            'format'    => $format,
            'event'     => $event,
            'text'      => $text,
            'serverSync'=> $sent_time,
        ];
        
      	?>
        <div id="countDownContiner-<?php echo esc_attr($this->get_id()); ?>" class="pr-countdown" data-settings='<?php echo wp_json_encode($countdown_settings); ?>'>
            <div id="countdown-<?php echo esc_attr( $this->get_id() ); ?>" class="pr-countdown-init countdown<?php echo $pcdt_style; ?>"></div>
        </div>
      	<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new PR_Counter_Down_Widget() );
