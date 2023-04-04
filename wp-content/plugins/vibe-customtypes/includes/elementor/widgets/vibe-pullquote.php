<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Pullquote extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe-pullquote';
	}

	public function get_title() {
		return __( 'Vibe Pullquote', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-quote-right';
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
			'content',
			[
				'label' => __( 'Contents', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter Content', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left' => 'Left',
					'right' => 'Right'
				],
			]
		);
		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[pullquote  
	    style="'.($settings['style']).'"] "'.$settings['content'].'"[/pullquote]';

		echo do_shortcode($shortcode);
	}
}


