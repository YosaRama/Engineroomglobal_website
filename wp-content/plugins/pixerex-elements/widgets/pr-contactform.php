<?php 
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class PR_ContactForm7_Widget extends Widget_Base {

	public function get_name() {
		return 'pr-contact-form';
	}

	public function get_title() {
		return esc_html__( 'Contact Form7', 'pixerex' );
	}

	public function get_icon() {
		return 'eicon-mail';
   }
        public function get_categories() {
		return array( 'pr-elements' );
	}
    

        protected function _register_controls() {

		
  		$this->start_controls_section(
  			'pr_section_wpcf7_form',
  			[
  				'label' => esc_html__( 'Contact Form', 'pixerex' )
  			]
  		);

        
		$this->add_control(
			'pr_wpcf7_form',
			[
				'label' => esc_html__( 'Select Your Contact Form', 'pixerex' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'options' => $this->pr_contact_form(),
			]
		);

		
		$this->end_controls_section();
        
        $this->start_controls_section('pr_wpcf7_fields', 
            [
                'label'     => esc_html__('Fields', 'pixerex'),
            ]);
        
        $this->add_control('pr_wpcf7_fields_heading',
            [
                'label'     => esc_html__('Width', 'pixerex'),
                'type'      => Controls_Manager::HEADING
            ]);
        
        $this->add_responsive_control(
  			'pr_elements_input_width',
  			[
  				'label' => esc_html__( 'Input Field', 'pixerex' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
                'default'   => [
                    'size'  => 100,
                    'unit'  => '%'
                ],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text' => 'width: {{SIZE}}{{UNIT}};',
				],
  			]
  		);
        
         $this->add_responsive_control(
  			'pr_elements_textarea_width',
  			[
  				'label' => esc_html__( 'Text Area', 'pixerex' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
                'default'   => [
                    'size'  => 100,
                    'unit'  => '%'
                ],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}};',
				],
  			]
  		);  
         
         $this->add_control('pr_wpcf7_fields_height_heading',
            [
                'label'     => esc_html__('Height', 'pixerex'),
                'type'      => Controls_Manager::HEADING
            ]);
         
         $this->add_responsive_control(
  			'pr_elements_input_height',
  			[
  				'label' => esc_html__( 'Input Field', 'pixerex' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
					'em' => [
						'min' => 1,
						'max' => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, 
					{{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select' => 'height: {{SIZE}}{{UNIT}};',
				],
  			]
  		);
        
         $this->add_responsive_control(
  			'pr_elements_textarea_height',
  			[
  				'label' => esc_html__( 'Text Area', 'pixerex' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}};',
				],
  			]
  		); 
        
        $this->end_controls_section();
        
        $this->start_controls_section('pr_wpcf7_button', 
            [
                'label'     => esc_html__('Button', 'pixerex'),
            ]);
        
        /*Button Width*/
        $this->add_responsive_control(
  			'pr_elements_button_width',
  			[
  				'label' => esc_html__( 'Width', 'pixerex' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit' => 'width: {{SIZE}}{{UNIT}};',
				],
  			]
  		);  
        
        /*Button Height*/
        $this->add_responsive_control(
  			'pr_elements_button_height',
  			[
  				'label' => esc_html__( 'Height', 'pixerex' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
					'em' => [
						'min' => 1,
						'max' => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit' => 'height: {{SIZE}}{{UNIT}};',
				],
  			]
  		);
        
        $this->end_controls_section();
                
                $this->start_controls_section(
			'section_contact_form_styles',
			[
				'label' => esc_html__( 'Form', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
                $this->add_control(
			'pr_elements_input_background',
			[
				'label' => esc_html__( 'Input Field Background', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea, 
					{{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select' => 'background: {{VALUE}};',
				],
			]
		);
                
                                
		$this->add_responsive_control(
			'pr_elements_input_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea,
					{{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);                
                      
                
        $this->add_responsive_control(
			'pr_elements_input_padding',
			[
				'label' => esc_html__( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea,
					{{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);            
                
                $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_elements_input_border',
				'selector' => '{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea, {{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select',
			]
		);
                
                                $this->add_control(
			'pr_elements_input_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea, 
					{{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'pr_elements_input_focus',
			[
				'label' => esc_html__( 'Focus Border Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text:focus, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea:focus, 
					{{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select:focus' => 'border-color: {{VALUE}};',
				],
			]
		);
                
                $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_button_shadow',
				'selector' => '{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea, {{WRAPPER}} .pr-contact-form-container select.wpcf7-form-control.wpcf7-select',
			]
		);
                
                
                $this->end_controls_section();
		  
		
		$this->start_controls_section(
			'section_contact_form_typography',
			[
				'label' => esc_html__( 'Labels', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
                
        		$this->add_control(
			'pr_elements_heading_default',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Default Typography', 'pixerex' ),
			]
		);
		
		$this->add_control(
			'pr_elements_contact_form_color',
			[
				'label' => esc_html__( 'Default Font Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
            'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container, {{WRAPPER}} .pr-contact-form-container label' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pr_elements_contact_form_default_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pr-contact-form-container',
			]
		);
        
      $this->add_control(
			'pr_elements_heading_input',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Input Typography', 'pixerex' ),
            'separator' => 'before',
			]
		);
		
		$this->add_control(
			'pr_elements_contact_form_field_color',
			[
				'label' => esc_html__( 'Input Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
            'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea' => 'color: {{VALUE}};',
				],
			]
		);
        
        		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pr_elements_contact_form_field_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pr-contact-form-container input.wpcf7-text, {{WRAPPER}} .pr-contact-form-container textarea.wpcf7-textarea',
			]
		);
        
		
		$this->add_control(
			'pr_elements_contact_form_placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container ::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pr-contact-form-container ::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pr-contact-form-container ::-ms-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);
	
		
		$this->end_controls_section();
                         
                $this->start_controls_section(
			'section_contact_form_submit_button_styles',
			[
				'label' => esc_html__( 'Button', 'pixerex' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'section_title_pr_btn_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit',
			]
		);
		
		$this->add_responsive_control(
			'section_title_pr_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'pr_contact_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'pixerex' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		
		$this->start_controls_tabs( 'pr_elements_button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'pixerex' ) ] );

		$this->add_control(
			'pr_elements_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit' => 'color: {{VALUE}};',
				],
			]
		);
		

		
		$this->add_control(
			'pr_elements_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
            'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pr_elements_btn_border',
				'selector' => '{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit',
			]
		);
		
		$this->add_control(
			'pr_elements_btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'pixerex' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit' => 'border-radius: {{SIZE}}px;',
				],
			]
		);
		

		
		$this->end_controls_tab();

		$this->start_controls_tab( 'pr_elements_hover', [ 'label' => esc_html__( 'Hover', 'pixerex' ) ] );

		$this->add_control(
			'pr_elements_button_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_elements_button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pr_elements_button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'pixerex' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pr-contact-form-container input.wpcf7-submit',
			]
		);

		$this->add_responsive_control(
			'pr_button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'pixerex' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'Left',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'pixerex' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'pixerex' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'pixerex' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pr-contact-form-container .wpcf7-form p:nth-last-of-type(1)'   => 'text-align: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);
		
		
		$this->end_controls_section();
        
                
        }
        
        protected function pr_contact_form( ) {

		if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
			return array();
		}

		$forms = \WPCF7_ContactForm::find( array(
			'orderby' => 'title',
			'order'   => 'ASC',
		) );

		if ( empty( $forms ) ) {
			return array();
		}

		$result = array();

		foreach ( $forms as $item ) {
			$key            = sprintf( '%1$s::%2$s', $item->id(), $item->title() );
			$result[ $key ] = $item->title();
		}

		return $result;
	}
        protected function render()  {

		$settings = $this->get_settings();


		if ( ! empty( $settings['pr_wpcf7_form'] ) ) {?>

        <div class="pr-contact-form-container">

			<?php echo do_shortcode( '[contact-form-7 id="' . $settings['pr_wpcf7_form'] . '" ]' );?>
        </div><!-- close .pr-contact-form-container -->
<?php
		}

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new PR_ContactForm7_Widget() );
