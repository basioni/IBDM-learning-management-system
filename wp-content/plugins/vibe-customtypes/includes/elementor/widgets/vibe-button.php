<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Button extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_button';
	}

	public function get_title() {
		return __( 'Vibe Button', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'eicon-button';
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
			'title',
			[
				'label' => __( 'Button Anchor', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter button title', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'button_url',
			[
				'label' => __( 'Button Url', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::URL,
				'input_type' => 'text',
				'placeholder' => __( 'Enter button url', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'class',
			[
				'label' => __( 'Button Style', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'base' => '',
					'primary' => 'Primary',
					'blue' => 'Blue',
					'green' => 'Green',
					'other' => 'Custom'
					],
			]
		);

		$this->add_control(
			'button_target',
			[
				'label' => __( 'Button Target', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'_self' => '_self',
					'_blank' => '_blank'
					
					],
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'font size', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 50,
				'step' => 1,
				'default' => 10
			]
		);

		$this->add_control(
			'height',
			[
				'label' => __( 'height', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 1,
				'default' => 10
			]
		);

		$this->add_control(
			'width',
			[
				'label' => __( 'width', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1200,
				'step' => 1,
				'default' => 100
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[button url ="'.(empty($settings['button_url'])?'':$settings['button_url']['url']).'" 
		class="'.($settings['class']).'"
		bg="" hover_bg="" 
		size="'.($settings['size']).'px" 
		color="" 
		radius=""
		width="'.($settings['width']).'px" 
		height="'.($settings['height']).'px"
		target="'.($settings['button_target']).'"] '.($settings['title']).' [/button]';

		echo do_shortcode($shortcode);
	}
}