<?php

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Carousel extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'vibe-carousel';
	}

	public function get_title() {
		return __( 'Vibe Carousel', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-sliders';
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
				'label' => __( 'Carousel Title', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter Carousel Title', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'more_link',
			[
				'label' => __( 'Show More link', 'vibe-customtypes' ),
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
				'label' => __('Enter Post Type<br /><span style="font-size:11px;">(Select Post Type from Posts/Courses/Clients/Products ...)</span>', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'course',
				'options' => $v_post_types,
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
				'label' => __('Enter relevant Taxonomy name used for Filter buttons (example : course-cat,event-type..)', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'example : course-cat,event-type..', 'vibe-customtypes' ),
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
			'term',
			[
				'label' => __('Enter Taxonomy Term Slug (optional, only if above is selected, comma saperated for multiple terms): ', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => '',
				'options' => $termarray,
			]
		);

		$this->add_control(
			'post_ids',
			[
				'label' => __('Enter Post Ids', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'Enter comma saparated', 'vibe-customtypes' ),
			]
		);

		$this->add_control(
			'course_style',
			[
				'label' => __('Course Types [Only for Post type = Course]', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'recent',
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
			'carousel_excerpt_length',
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
			'carousel_link',
			[
				'label' => __('Show Link button on image hover', 'vibe-customtypes'),
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

		$shortcode = '[v_carousel 
	    title="'.($settings['title']).'" 
	    show_title="'.(empty($settings['title'])?0:1).'" 
	    show_more="'.(empty($settings['more_link'])?0:1).'" 
	    more_link="'.($settings['more_link']).'" 
	    show_controls="'.($settings['show_controls']).'" 
	    show_controlnav="'.($settings['title']).'" 
	    post_type="'.($settings['post_type']).'" 	
	    taxonomy="'.(empty($settings['taxonomy'])?0:$settings['taxonomy']).'" 
	    term="'.(empty($settings['term'])?0:$settings['term']).'" 
	    post_ids="'.($settings['post_ids']).'" 
	    course_style="'.($settings['course_style']).'" 
	    featured_style="'.($settings['featured_style']).'" 
	    auto_slide="'.($settings['auto_slide']).'" 
	    column_width="'.($settings['column_width']).'" 
	    carousel_max="'.($settings['carousel_max']).'" 
	    carousel_min="'.($settings['carousel_min']).'" 
	    carousel_move="'.($settings['carousel_move']).'" 
	    carousel_number="'.($settings['carousel_number']).'" 
	    carousel_rows="'.($settings['carousel_rows']).'" 
	    carousel_excerpt_length="'.($settings['carousel_excerpt_length']).'" 
	    carousel_link="'.($settings['carousel_link']).'"] [/v_carousel]';
		
		//echo $shortcode;

		echo do_shortcode($shortcode);
	}

	/*widget_scripts(){
		wp_register_script( 'some-library', plugins_url( 'js/libs/some-library.js', __FILE__ ) );
	}*/

}


