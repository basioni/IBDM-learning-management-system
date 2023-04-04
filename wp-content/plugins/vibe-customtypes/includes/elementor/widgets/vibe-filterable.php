<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 class Wplms_Vibe_Filterable extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'filterable_post';
	}

	public function get_title() {
		return __( 'Filterable Post', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-exchange';
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
				'placeholder' => __( 'Title', 'vibe-customtypes' ),
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

		$v_post_types = array();
	    $post_types=get_post_types('','objects'); 

	    foreach ( $post_types as $post_type ){
	        if( !in_array($post_type->name, array('attachment','revision','nav_menu_item','sliders','modals','shop','shop_order','shop_coupon','forum','topic','reply')))
	           $v_post_types[$post_type->name]=$post_type->label;
	    }
	    
	    if(!array_key_exists('news',$v_post_types)){
	        $v_post_types['news'] = __('Course News','vibe-customtypes');
	    }

		$this->add_control(
			'post_type',
			[
				'label' => __('Enter Post Type', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $v_post_types,
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label' => __('Enter relevant Taxonomy name used for Filter buttons (example : course-cat,event-type..)', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'example : course-cat,event-type..', 'vibe-customtypes' ),
			]
		);

		$taxonomies = get_taxonomies();
		$taxarray = array();
		foreach($taxonomies as $taxonomy){
			$taxarray[$taxonomy->name]=$taxonomy->labels->name;
		}
		$this->add_control(
			'taxonomy',
			[
				'label' => __('Enter Taxonomy Slug (optional)<br /><span style="font-size:11px;">(A "Taxonomy" is a grouping mechanism for posts. Like Category for Posts, Tags for Posts, Portfolio Type for Portfolio etc.. <a href="http://codex.wordpress.org/Taxonomies">more</a>)</span> ', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $taxarray,
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
			'exclude_terms',
			[
				'label' => __('Enter Taxonomy Term Slug (optional, only if above is selected, comma saperated for multiple terms): ', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => '',
				'options' => $termarray,
			]
		);

		$this->add_control(
			'course_style',
			[
				'label' => __('Course Types', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'rated',
				'options' => array(
	                'recent' => 'Recently published',
	                'popular' => 'Most Students',
	                'featured' => 'Featured',
	                'rated'  => 'Highest Rated',
	                'reviews' => 'Most Reviews',
	                'start_date' => 'Upcoming Courses (Start Date)',
	                'expired_start_date'=>'Expired Courses (Past Start Date)',
	                'free'=> 'Free Courses',
	                'random' => 'Random'
                ),
			]
		);
				    /*plugins_url('../images/thumb_2.png',__FILE__) => 'course',
                    plugins_url('../images/thumb_8.png',__FILE__) => 'course2',
                    plugins_url('../images/thumb_8.jpg',__FILE__) => 'course3',
                    plugins_url('../images/thumb_9.jpg',__FILE__) => 'course4',
                    plugins_url('../images/thumb_10.jpg',__FILE__) => 'course5',
                    plugins_url('../images/thumb_11.jpg',__FILE__) => 'postblock',
                    plugins_url('../images/thumb_3.png',__FILE__)=> 'side',
                    plugins_url('../images/thumb_6.png',__FILE__) => 'blogpost' ,
                    plugins_url('../images/thumb_4.png',__FILE__)=> 'images_only',
                    plugins_url('../images/thumb_5.png',__FILE__)=> 'testimonial',
                    plugins_url('../images/testimonial2.jpg',__FILE__)=> 'testimonial2',
                    plugins_url('../images/thumb_7.png',__FILE__)=> 'event_card',
                    plugins_url('../images/thumb_12.png',__FILE__)=> 'general',
                    plugins_url('../images/generic.jpg',__FILE__)=> 'generic',
                    plugins_url('../images/simple.jpg',__FILE__)=> 'simple',*/
		$this->add_control(
			'featured_style',
			[
				'label' => __( 'Featured Style', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => plugins_url('../images/thumb_2.png',__FILE__),
				'options' => array(
	                'course' => 'course',
                    'course2' => 'course2',
                    'course3' => 'course3',
                    'course4' => 'course4',
                    'course5' => 'course5',
                    'course6' => 'course6',
                    'course7' => 'course7',
                    'course8' => 'course8',
                    'postblock' => 'postblock',
                    'side'=> 'side',
                    'blogpost' => 'blogpost' ,
                    'images_only'=> 'images_only',
                    'testimonial'=> 'testimonial',
                    'testimonial2'=> 'testimonial2',
                    'event_card'=> 'event_card',
                    'general'=> 'general',
                    'generic'=> 'generic',
                    'simple'=> 'simple',
                ),
			]
		);

		$this->add_control(
			'show_all',
			[
				'label' =>__('Show All', 'vibe-customtypes'),
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
				'label' => __('Width each filterable block', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1200,
				'step' => 5,
				'default' => 268,
			]
		);

		$this->add_control(
			'filterable_excerpt_length',
			[
				'label' =>__('Excerpt Length in Block (in characters)', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 5,
				'default' => 100,
			]
		);

		$this->add_control(
			'filterable_number',
			[
				'label' =>__('Total Number of Blocks in Grid', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label' =>__('Show Pagination', 'vibe-customtypes'),
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

		$shortcode = '[v_filterable 
		title="'.($settings['title']).'"
		show_title="'.($settings['show_title']).'"
		post_type="'.($settings['post_type']).'"
		taxonomy="'.($settings['taxonomy']).'"
		exclude_terms="'.($settings['exclude_terms']).'" 
		course_style="'.($settings['course_style']).'" 
		featured_style="'.($settings['featured_style']).'"
		show_all="'.($settings['show_all']).'" 
		column_width="'.($settings['column_width']).'" 
		filterable_excerpt_length="'.($settings['filterable_excerpt_length']).'" 
		filterable_number="'.($settings['filterable_number']).'" 
		show_pagination="'.($settings['show_pagination']).'" 
		filterable_link="1" 
		css_class="" 
		container_css="" 
		custom_css=""][/v_filterable]';

	    /*$shortcode = '[v_filterable 
		title="filterable post" 
		show_title="1" 
		post_type="course" 
		taxonomy="" 
		exclude_terms="" 
		course_style="recent" 
		featured_style="course3" 
		show_all="1" 
		column_width="200" 
		filterable_excerpt_length="100" 
		filterable_number="4" 
		show_pagination="1" 
		filterable_link="1" 
		css_class="" 
		container_css="" 
		custom_css=""][/v_filterable]';*/

		echo do_shortcode($shortcode);
	}

}
