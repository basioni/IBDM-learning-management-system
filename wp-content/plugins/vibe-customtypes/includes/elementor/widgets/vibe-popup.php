<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Popup extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_popup';
	}

	public function get_title() {
		return __( 'Vibe Popup', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-expand';
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
			'id',
			[
				'label' => __( 'popup id', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
			]
		);

		$this->add_control(
			'auto',
			[
				'label' => __( 'Show Popup on Page-load', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'0' => [
						'title' => __( 'No', 'vibe-customtypes' ),
						'icon' => 'fa fa-x',
					],
					'1' => [
						'title' => __( 'Yes', 'vibe-customtypes' ),
						'icon' => 'fa fa-check',
					],
				],
			]
		);

		$this->add_control(
			'classes',
			[
				'label' => __( 'Anchor Style', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
						'default' =>'Default',
						'btn'=> 'Button',
						'btn primary' => 'Primary'
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Popup/Modal Anchor', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'content', 'vibe-customtypes' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[popup id="'.($settings['id']).'" auto="'.($settings['auto']).'" classes="'.($settings['classes']).'"] '.($settings['content']).' [/popup]';

		echo do_shortcode($shortcode);
	}
}