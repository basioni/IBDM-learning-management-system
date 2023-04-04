<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Tooltip extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_tooltip';
	}

	public function get_title() {
		return __( 'Vibe Tooltip', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-lightbulb';
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
			'tip',
			[
				'label' => __( 'tip', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('tip', 'vibe-customtypes')
			]
		);

		$this->add_control(
			'anchor',
			[
				'label' => __( 'anchor', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('anchor', 'vibe-customtypes')
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[tooltip tip="'.($settings['tip']).'"] '.($settings['anchor']).' [/tooltip]';
		echo do_shortcode($shortcode);
	}
}