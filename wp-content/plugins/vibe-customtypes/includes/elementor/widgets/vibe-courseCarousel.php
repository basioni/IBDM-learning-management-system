<?php
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 class Wplms_Vibe_CourseCarousel extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe_courseCarousel';
	}

	public function get_title() {
		return __( 'Course Category Carousel', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-columns';
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


		$terms = get_terms( 'post_tag', array(
		    'hide_empty' => false,
		) );
		$termarray = array();
		foreach($terms as $term){
			$termarray[$term->slug]=$term->name;
		}
		$this->add_control(
			'term_slugs',
			[
				'label' => __('Include Term Slugs (optional, comma saperated)', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'terms_slug', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'orderBy',
			[
				'label' => __('OrderBy', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'rated',
				'options' => array(
	                'DESC' => 'Decending',
	                'Asc' => 'Ascending'
                ),
			]
		);

		$this->add_control(
			'show_controls',
			[
				'label' =>__('Slider Controls : Direction Arrows', 'vibe-customtypes'),
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
			'show_controlnav',
			[
				'label' =>__('Slider Controls : Control Dots', 'vibe-customtypes'),
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
			'auto_slide',
			[
				'label' =>__('Auto Slide', 'vibe-customtypes'),
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
				'label' => __('Crousel block width', 'vibe-customtypes'),
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
				'label' =>__('Number of blocks in one slide', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 1,
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
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$shortcode = '[v_taxonomy_carousel 
		title="'.($settings['title']).'"
		show_title="'.($settings['show_title']).'"
		term_slugs="'.(empty($settings['term_slugs'])?0:$settings['term_slugs']).'" 
	    orderby="'.($settings['orderby']).'" 
	    order="'.($settings['order']).'" 
	    show_controls="'.($settings['show_controls']).'"
		show_controlnav="'.($settings['show_controlnav']).'"
		auto_slide="'.($settings['auto_slide']).'" 
		column_width="'.($settings['column_width']).'"
		carousel_max="'.($settings['carousel_max']).'"
		carousel_min="'.($settings['carousel_min']).'" 
		carousel_move="'.($settings['carousel_move']).'" 
		carousel_number="'.($settings['carousel_number']).'" 
		carousel_rows="'.($settings['carousel_rows']).'" 
		css_class="" 
		container_css="" 
		custom_css=""][/v_taxonomy_carousel]';

	   /* $shortcode = '[v_taxonomy_carousel 
		title="Course Category" 
		term_slugs="" 
		orderby="name" 
		order="DESC" 
		show_controls="1" 
		show_controlnav="0" 
		auto_slide="1" 
		column_width="268" 
		carousel_max="4" 
		carousel_min="2" 
		carousel_move="1" 
		carousel_number="6" 
		css_class="" 
		container_css="" 
		custom_css=""][/v_taxonomy_carousel]';*/
		echo do_shortcode($shortcode);
	}

}