<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Testimonial extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_testimonial';
	}

	public function get_title() {
		return __( 'Vibe Testimonial', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-quote-left';
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
// Please before changing id variable make sure it should not be id, use any prefix like widgit name.
		$this->add_control(
			't_id',
			[
				'label' => __( 'Testimonial id', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'length',
			[
				'label' => __( 'Length', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 5,
				'default' => 100,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[testimonial  id="'.($settings['t_id']).'" length="'.($settings['length']).'" ]';
		echo do_shortcode($shortcode);
	}
}