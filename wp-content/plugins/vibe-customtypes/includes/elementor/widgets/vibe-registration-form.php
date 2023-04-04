<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class wplms_Vibe_registration_form extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe registration form';
	}

	public function get_title() {
		return __( 'Vibe registration form', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-user-plus';
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
			'name',
			[
				'label' => __( 'Enter name', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('enter name', 'vibe-customtypes')
			]
		);

		$this->add_control(
			'field_meta',
			[
				'label' => __( 'Enter field_meta', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('enter field_meta', 'vibe-customtypes')
			]
		);		

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[wplms_registration_form name="'.($settings['name']).'" field_meta="'.($settings['field_meta']).'"]';
		echo do_shortcode($shortcode);
	}
}