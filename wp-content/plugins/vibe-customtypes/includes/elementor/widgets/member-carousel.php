<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 class wplms_member_carousel extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'member_carousel';
	}

	public function get_title() {
		return __( 'Member Carousel', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-arrows';
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
				'label' => __( 'Title', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter Title', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show title', 'vibe-customtypes' ),
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
			'show_more',
			[
				'label' =>__('Show more', 'vibe-customtypes'),
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
			'show_controls',
			[
				'label' =>__('Show Direction arrows', 'vibe-customtypes'),
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
			'more_link',
			[
				'label' => __('More Link (User redirected to this page on click)', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'more_link', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'show_controlnav',
			[
				'label' =>__('Show Control dots', 'vibe-customtypes'),
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



		$types = bp_get_member_types( array(), 'objects' );
		$typearray = array();
		foreach($types as $type){
			$typearray[$type->name]=$type->name;
		}
		$this->add_control(
			'member_type',
			[
				'label' => __('Member Type', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => $typearray,
			]
		);

		$this->add_control(
			'profile_fields',
			[
				'label' => __('Enter Profile fields (comma saperated field "names")', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Profile Fields', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'member_ids',
			[
				'label' => __('Or Enter Specific Member Ids', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Member Ids', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __('Display Style', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
	                '' => 'member1',
	                'member2' => 'member2',
	                'member3' => 'member3',             
                ),
			]
		);
		
		$this->add_control(
			'auto_slide',
			[
				'label' =>__('Auto slide/rotate', 'vibe-customtypes'),
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
			'column_width',
			[
				'label' => __('Width each crousel block', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1200,
				'step' => 5,
				'default' => 268,
			]
		);

		$this->add_control(
			'carousel_max',
			[
				'label' =>__('Maximum Number of blocks in One screen', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'carousel_min',
			[
				'label' =>__('Minimum Number of blocks in one Screen', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 2,
			]
		);

		$this->add_control(
			'carousel_move',
			[
				'label' =>__('Move blocks in one slide', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'carousel_number',
			[
				'label' =>__('Total Number of Blocks', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 6,
			]
		);
		
		$this->add_control(
			'carousel_rows',
			[
				'label' =>__('Carousel Rows', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'carousel_link',
			[
				'label' =>__('Show Link button on image hover', 'vibe-customtypes'),
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
		

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

	    $shortcode = '[v_member_carousel 
	    first_class="1" 
	    title="'.($settings['title']).'" 
	    show_title="'.($settings['show_title']).'" 
	    show_more="'.($settings['show_more']).'" 
	    more_link="'.($settings['more_link']).'" 
	    show_controls="'.($settings['title']).'" 
	    show_controlnav="'.($settings['show_controlnav']).'" 
	    member_type="'.($settings['member_type']).'"  
	    member_ids="'.($settings['member_ids']).'" 
	    profile_fields="'.($settings['profile_fields']).'" 
	    style="'.($settings['style']).'" 
	    auto_slide="'.($settings['auto_slide']).'"  
	    column_width="'.($settings['column_width']).'"  
	    carousel_max="'.($settings['carousel_max']).'"  
	    carousel_min="'.($settings['carousel_min']).'" 
	    carousel_move="'.($settings['carousel_move']).'" 
	    carousel_number="'.($settings['carousel_number']).'" 
	    carousel_rows="'.($settings['carousel_rows']).'" 
	    carousel_link="'.($settings['carousel_link']).'" 
	    css_class="" 
	    container_css="" 
	    custom_css=""][/v_member_carousel]';

		echo do_shortcode($shortcode);
	}

}