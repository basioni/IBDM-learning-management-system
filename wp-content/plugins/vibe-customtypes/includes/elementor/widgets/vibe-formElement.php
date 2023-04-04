<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_FormElement extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_formElement';
	}

	public function get_title() {
		return __( 'Vibe Form Element', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-exchange';
	}

	public function get_categories() {
		return [ 'wplms' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Controls', 'vibe-customtypes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label' => __( 'name', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'name', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'type',
			[
				'label' => __( 'type', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
						'text' => 'Single Line Text Box (Text)',
						'textarea' => 'Multi Line Text Box (TextArea)',
						'select' => 'Select from Options (Select)',
						'checkbox' =>'Checkbox',
						'captcha' => 'Captcha field',
						'upload' => 'Upload File',
						'submit' =>'Submit Button',
					]

			]
		);

		$this->add_control(
			'upload_options',
			[
				'label' => __( 'upload formate', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
						'PDF' => 'PDF',
						'TEXT' => 'TEXT',
						'DOC' => 'DOC',
						'DOCx' =>'DOCx',
						'PPT' => 'PPT',
						'PPTX' => 'PPTX',
						'ZIP' =>'ZIP',
						'PNG' =>'PNG',
						'JPG' => 'JPG',
						'JPEG' => 'JPEG',
					]

			]
		);

		$this->add_control(
			'validate',
			[
				'label' => __( 'validate', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
						'none' => 'None',
						'required' => 'Required',
						'email' => 'Email',
						'numeric' =>'Numeric',
						'phone' => 'Phone number'

					]
				
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[form_element type="'.($settings['type']).'" 
		validate="'.($settings['validate']).'" 
		options="'.($settings['options']).'" 
		placeholder="'.($settings['placeholder']).'" 
		upload_options="'.($settings['upload_options']).'"]';

		echo do_shortcode($shortcode);
	}
}