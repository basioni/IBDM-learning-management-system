<?php
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 class wplms_member_grid extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'member_grid';
	}

	public function get_title() {
		return __( 'Member Grid', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-user-o';
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
				'placeholder' => __( 'Title/Heading', 'vibe-customtypes' ),
			]
		);
		
		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Filterable title', 'vibe-customtypes' ),
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

		global $wp_roles;
	    $v_member_types = array();
	    foreach($wp_roles->roles as $role=>$name){
	      $v_member_types[$role] = $name['name'];
	    }
		$this->add_control(
			'member_type',
			[
				'label' => __('Member Type', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'nothing_selected',
				'options' => $v_member_types,
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
			'exclude_member_ids',
			[
				'label' => __('Enter Member Ids (comma saperated field "ids")', 'vibe-customtypes'),
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
	                'member4' => 'member4',              
                ),
			]
		);

		$this->add_control(
			'grid_layout',
			[
				'label' => __('Grid Layout', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
	                '' => 'grid1',
	                'grid2' => 'grid2',
	                'grid3' => 'grid3',
	                'grid4' => 'grid4',
	                'grid5' => 'grid5',
	                'grid6' => 'grid6',
	                'grid7' => 'grid7',	               
                ),
			]
		);


		$this->add_control(
			'block_size',
			[
				'label' => __('Block Size (in px) Or number of blocks in 1 row based on smallest block size', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1200,
				'step' => 1,
				'default' =>3,
			]
		);

		$this->add_control(
			'gutter',
			[
				'label' =>__('Spacing between Columns (in px)', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 0,
			]
		);

		$this->add_control(
			'grid_number',
			[
				'label' =>__('Total Number of Blocks in Grid', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 4,
			]
		);
	}

	protected function render() {

	   $settings = $this->get_settings_for_display();

	   $shortcode = '[v_member_grid 
	   first_class="1" 
	   title="'.($settings['title']).'" 
	   show_title="'.($settings['show_title']).'" 
	   member_type="'.($settings['member_type']).'" 
	   profile_fields="'.($settings['profile_fields']).'" 
	   exclude_member_ids="'.($settings['exclude_member_ids']).'" 
	   style="'.($settings['style']).'"
	   grid_layout="'.($settings['grid_layout']).'"
	   block_size="'.($settings['block_size']).'"
	   grid_number="'.($settings['grid_number']).'"
	   grid_number="'.($settings['grid_number']).'"
	   css_class="" 
	   container_css="" 
	   custom_css=""][/v_member_grid]';

	   echo do_shortcode($shortcode);
	}

}