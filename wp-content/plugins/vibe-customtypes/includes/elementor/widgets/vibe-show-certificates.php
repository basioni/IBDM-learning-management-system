<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Show_Certificates extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe-show-certificates';
	}

	public function get_title() {
		return __( 'Vibe Show Certificates', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-certificate';
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
			'size',
			[
				'label' => __( 'size', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Enter size', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'column',
			[
				'label' => __('Enter column', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'user',
			[
				'label' => __('Enter user', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'course',
			[
				'label' => __('Enter course', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'number',
			[
				'label' =>__('Total Number', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 6,
			]
		);


		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[show_certificates 
	    number="'.($settings['number']).'" 
        size="'.($settings['size']).'" ,
        columns="'.($settings['columns']).'"
        course ="'.($settings['course']).'"
        user ="'.($settings['user']).'" ]';
		
		//echo $shortcode;

		echo do_shortcode($shortcode);
	}

	/*widget_scripts(){
		wp_register_script( 'some-library', plugins_url( 'js/libs/some-library.js', __FILE__ ) );
	}*/

}


