<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Note extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_note';
	}

	public function get_title() {
		return __( 'Vibe Note', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-sticky-note';
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
			'bg',
			[
				'label' => __( 'Background color', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'bordercolor',
			[
				'label' => __( 'Border Color', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Text Color', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'content', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'content', 'vibe-customtypes' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[note style="other" bg="'.($settings['bg']).'" border="" bordercolor="'.($settings['bordercolor']).'" color="'.($settings['color']).'"]'.($settings['content']).'[/note]';

		echo do_shortcode($shortcode);
	}
}