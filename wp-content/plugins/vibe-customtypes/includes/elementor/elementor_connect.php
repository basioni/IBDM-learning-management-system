<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter('wplms_enqueue_images_loaded_isotopes_page_builder',function ($flag){
	global $post;
	if(Elementor\Plugin::instance()->db->is_built_with_elementor( $post->ID )){
		return 1;
	}
	return $flag;
});

function wplms_add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'wplms',
			[
				'title' => __( 'WPLMS', 'vibe-customtypes' ),
				'icon' => 'fa fa-plug',
			]
		);
		
}
add_action( 'elementor/elements/categories_registered', 'wplms_add_elementor_widget_categories' );


function init() {
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
	}

	 function widget_scripts() {
		wp_register_script( 'widget-carousel', 'elementor_support.js', [ 'jquery', 'shortcodes-js' ] );
	}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elementor_Test_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'vibe-customtypes' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'vibe-customtypes' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'vibe-customtypes' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'vibe-customtypes' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'vibe-customtypes' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'vibe-customtypes' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'vibe-customtypes' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'vibe-customtypes' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'vibe-customtypes' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'vibe-customtypes' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/vibe-carousel.php' );

		// Register widget vibe carousel
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Carousel() );
		require_once( __DIR__ . '/widgets/vibe-grid.php' );

		// Register widget vibe grid
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Grid() );

		require_once( __DIR__ . '/widgets/vibe-filterable.php' );

		// Register widget vibe filterable
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Filterable() );

		require_once( __DIR__ . '/widgets/vibe-courseCarousel.php' );

		// Register widget vibe course carousel
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_CourseCarousel() );

		// Register widget vibe pullquote
		require_once( __DIR__ . '/widgets/vibe-pullquote.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Pullquote() );

		// Register widget vibe button
		require_once( __DIR__ . '/widgets/vibe-button.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Button() );

		// Register widget vibe countdown
		require_once( __DIR__ . '/widgets/vibe-countdown.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Countdown() );

		// Register widget vibe show certificates
		require_once( __DIR__ . '/widgets/vibe-show-certificates.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Show_Certificates() );

		// Register widget vibe iframe
		require_once( __DIR__ . '/widgets/vibe-iframe.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Iframe() );

		// Register widget vibe note
		require_once( __DIR__ . '/widgets/vibe-note.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Note() );

		// Register widget vibe popup
		require_once( __DIR__ . '/widgets/vibe-popup.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Popup() );

		// Register widget vibe testimonial
		require_once( __DIR__ . '/widgets/vibe-testimonial.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Testimonial() );

		// Register widget vibe team
		require_once( __DIR__ . '/widgets/vibe-team.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Team() );

		// Register widget vibe progressbar
		require_once( __DIR__ . '/widgets/vibe-course.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Course() );

		// Register widget vibe form1
		require_once( __DIR__ . '/widgets/vibe-form.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Form() );

		// Register widget vibe form1
		require_once( __DIR__ . '/widgets/vibe-sell-content.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Wplms_Vibe_Sell_Content() );

		// Register widget vibe registration
		require_once( __DIR__ . '/widgets/vibe-registration-form.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \wplms_Vibe_registration_form() );

		// Register widget member grid
		require_once( __DIR__ . '/widgets/member-grid.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \wplms_member_grid() );

		// Register widget member carousel
		require_once( __DIR__ . '/widgets/member-carousel.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \wplms_member_carousel() );
	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_controls() {

		// Include Control files
		//require_once( __DIR__ . '/controls/test-control.php' );

		// Register control
		//\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

	}

}

Elementor_Test_Extension::instance();

    
       
