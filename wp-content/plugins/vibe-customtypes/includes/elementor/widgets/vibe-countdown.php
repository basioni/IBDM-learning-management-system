<?php
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Countdown extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_countdown';
	}

	public function get_title() {
		return __( 'Vibe Countdown', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-clock-o';
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
			'date',
			[
				'label' => __( 'Date', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
			]
		);

		$this->add_control(
			'days',
			[
				'label' => __( 'Days', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0
			]
		);

		$this->add_control(
			'hours',
			[
				'label' => __( 'hours', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 23,
				'step' => 1,
				'default' => 0
			]
		);

		$this->add_control(
			'minutes',
			[
				'label' => __( 'minutes', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 59,
				'step' => 1,
				'default' => 0
			]
		);

		$this->add_control(
			'seconds',
			[
				'label' => __( 'seconds', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 59,
				'step' => 1,
				'default' => 0
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'size', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 60,
				'step' => 1,
				'default' => 0
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[countdown_timer 
		date="'.($settings['date']).'" 
		days="'.($settings['days']).'" 
		hours="'.($settings['hours']).'" 
		minutes="'.($settings['minutes']).'" 
		seconds="'.($settings['seconds']).'" 
		size="'.($settings['size']).'"]';

		//echo $shortcode;

		echo do_shortcode($shortcode);
	}
}