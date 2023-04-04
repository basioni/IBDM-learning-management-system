<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 class Wplms_Vibe_Grid extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{
	function init(){
       add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
    }


    public function get_name() {
		return 'post grid';
	}

	public function get_title() {
		return __( 'Vibe Grid', 'vibe-customtypes' );
	}

	public function get_icon() {
		return 'fa fa-th';
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
			'grid_title',
			[
				'label' => __( 'Show Grid title', 'vibe-customtypes' ),
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
			'taxonomy',
			[
				'label' => __( 'Enter Taxonomy Slug', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter Taxonomy Slug', 'vibe-customtypes' ),
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
				'label' => __( 'Or Enter Specific Post Ids (comma saperated)', 'vibe-customtypes' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter post ids', 'vibe-customtypes' ),
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
			'masonry',
			[
				'label' =>__('Grid Masonry Layout', 'vibe-customtypes'),
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
			'grid_columns',
			[
				'label' => __('Grid Masonry Layout', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'clear4 col-md-3',
				'options' => array(
	                'clear1 col-md-12' => '1 Columns in FullWidth',
	                'clear2 col-md-6' => '2 Columns in FullWidth',
	                'clear3 col-md-4' => '3 Columns in FullWidth',
	                'clear4 col-md-3' => '4 Columns in FullWidth',
	                'clear6 col-md-2' => '6 Columns in FullWidth',
	               
                ),
			]
		);

		$this->add_control(
			'column_width',
			[
				'label' => __('Width each grid block', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1200,
				'step' => 5,
				'default' => 268,
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
		$this->add_control(
			'gutter',
			[
				'label' =>__('Spacing between Columns (in px)', 'vibe-customtypes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 30,
			]
		);
		$this->add_control(
			'infinite',
			[
				'label' =>__('Infinite Scroll', 'vibe-customtypes'),
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
			'pagination',
			[
				'label' =>__('Enable Pagination (If infinite scroll is off)', 'vibe-customtypes'),
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

		/*$shortcode = '[v_grid title="post grid1" show_title="1" post_type="course" taxonomy="" term="" post_ids="" course_style="rated" featured_style="" masonry="1" grid_columns="clear4 col-md-3" column_width="250" gutter="30" grid_number="" infinite="1" pagination="0" grid_excerpt_length="100" grid_link="1" css_class="" container_css="" custom_css=""][/v_grid]';*/

	    $shortcode = '[v_grid 
		title="'.($settings['title']).'"
		show_title="'.(empty($settings['grid_title'])?0:1).'"  
		post_type="'.($settings['post_type']).'" 
		taxonomy="'.(empty($settings['taxonomy'])?"":$settings['taxonomy']).'" 
		term="'.(empty($settings['term'])?0:$settings['term']).'" 
	    post_ids="'.($settings['post_ids']).'" 
	    course_style="'.($settings['course_style']).'" 
	    featured_style="'.($settings['featured_style']).'"
		masonry="'.($settings['masonry']).'"
		grid_columns="'.($settings['grid_columns']).'" 
		column_width="'.($settings['column_width']).'"
		gutter="'.($settings['gutter']).'"
		grid_number="'.($settings['grid_number']).'" 
		infinite="'.($settings['infinite']).'" 
		pagination="'.($settings['pagination']).'" 
		grid_excerpt_length="'.($settings['carousel_excerpt_length']).'"
		grid_link="1" 
		css_class="" 
		container_css="" 
		custom_css=""][/v_grid]';
		echo do_shortcode($shortcode);
	}

}