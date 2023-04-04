<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * Admin Settings
 *
 * @package    Email_Subscribers
 * @subpackage Email_Subscribers/admin
 * @author     Your Name <email@example.com>
 */

class ES_Tools {
	// class instance
	static $instance;

	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		add_action( 'admin_init', array( $this, 'setup_sections' ) );
		add_action( 'admin_init', array( $this, 'email_tools_settings_fields' ) );
	}

	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function plugin_menu() {

		$hook = add_submenu_page(
			'es_dashboard', 'Tools', 'Tools', get_option( 'es_roles_sendmail', true ), 'es_tools', [ $this, 'es_tools_settings_callback' ]
		);

		//add_action( "load-$hook", [ $this, 'screen_option' ] );

	}

	public function es_tools_settings_callback() {

		$submitted = Email_Subscribers::get_request( 'submitted' );


		if ( 'submitted' === $submitted ) {

			$es_test_email = Email_Subscribers::get_request( 'es_test_email' );

			if ( empty( $es_test_email ) ) {
				$message = __( 'Please add email', 'email-subscribers' );
				$status = 'error';
			} else {
                $data = array(
                    'es_test_email' => $es_test_email,
                );
                //Todo:: handle errors;
                $email_response = self::es_send_test_email_callback( $data );
                $message        = __( 'Email has been sent. Please check your inbox' );
				$status = 'succss';
            }

			$this->show_message( $message, $status );
		}

		$this->prepare_tools_settings_form();


	}

	public function prepare_tools_settings_form() {

		?>

        <div class="wrap">
            <form method="post" action="#">
				<?php settings_fields( 'es_tools_settings' ); ?>
				<?php do_settings_sections( 'tools_settings' ); ?>
                <div class="email-tools">
                    <input type="submit" id="" name="es_send_email" value="Send Email" class="button button-primary">
                    <input type="hidden" name="submitted" value="submitted">
                </div>
            </form>
        </div>

		<?php

	}

	public function setup_sections() {
		add_settings_section( 'tools_settings', 'Tools', array( $this, 'email_tools_settings_callback' ), 'tools_settings' );
	}

	public function email_tools_settings_callback( $arguments ) {

		?>
        <!--<div class="email-tools">
            <input type="button" id="es_send_email" name="es_send_email" value="Send Email" class="button button-primary">
        </div>-->
		<?php

	}

	public function email_tools_settings_fields() {

		$fields = array(
			array(
				'uid'          => 'es_test_email',
				'label'        => 'Send a Test Email',
				'section'      => 'tools_settings',
				'type'         => 'email',
				'options'      => '',
				'placeholder'  => '',
				'helper'       => '',
				'supplemental' => '',
				'default'      => ''
			),
		);
		$fields = apply_filters( 'email_tools_fields', $fields );
		foreach ( $fields as $field ) {
			add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), $field['section'], $field['section'], $field );
			register_setting( 'es_tools_settings', $field['uid'] );
		}

	}

	public function field_callback( $arguments ) {
		$value = get_option( $arguments['uid'] ); // Get the current value, if there is one
		if ( ! $value ) { // If no value exists
			$value = $arguments['default']; // Set to our default
		}

		// Check which type of field we want
		switch ( $arguments['type'] ) {
			case 'text': // If it is a text field
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
				break;
			case 'email':
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
				break;
		}

		// If there is help text
		if ( $helper = $arguments['helper'] ) {
			printf( '<span class="helper"> %s</span>', $helper ); // Show it
		}

		// If there is supplemental text
		if ( $supplimental = $arguments['supplemental'] ) {
			printf( '<p class="description">%s</p>', $supplimental ); // Show it
		}
	}

	public static function es_send_test_email_callback( $data ) {

		$email = ! empty( $data['es_test_email'] ) ? $data['es_test_email'] : '';
		if ( ! empty( $email ) ) {
			$subject        = 'Email Subscribers: ' . sprintf( esc_html__( 'Test email to %s', 'email-subscribers' ), $email );
			$content        = "This email was generated by the Email Subscribers WordPress plugin.";
			$email_response = ES_Mailer::send( $email, $subject, $content );
		}

		return $email_response;

	}

	public function show_message( $message = '', $status = 'success' ) {

		$class = 'notice notice-success is-dismissible';
		if ( 'error' === $status ) {
			$class = 'notice notice-error is-dismissible';
		}
		echo "<div class='{$class}'><p>{$message}</p></div>";
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

add_action( 'admin_menu', function () {
	ES_Tools::get_instance();
} );

?>