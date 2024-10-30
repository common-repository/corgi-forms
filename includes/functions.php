<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function crfo_add_first_activation_settings() {

	$form_settings = get_option( 'crfo_form_settings', array() );

	if( ! empty( $form_settings ) )
		return;

	$form_settings = array(

		// Form fields
		'fields' => array(
			'first_name' => array(
				'name'     => 'first_name',
				'display'  => '1',
				'label'    => __( 'First Name', 'corgi-forms' ),
				'required' => '1'
			),
			'last_name' => array(
				'name'     => 'last_name',
				'display'  => '1',
				'label'    => __( 'Last Name', 'corgi-forms' )
			),
			'email_address' => array(
				'name'     => 'email_address',
				'display'  => '1',
				'label'    => __( 'Email Address', 'corgi-forms' ),
				'required' => '1'
			),
			'subject' => array(
				'name'     => 'subject',
				'display'  => '1',
				'label'    => __( 'Message Subject', 'corgi-forms' )
			),
			'message' => array(
				'name'	   => 'message',
				'display'  => '1',
				'label'    => __( 'Message', 'corgi-forms' ),
				'required' => '1'
			),
			'submit' => array(
				'button_text' 		  => __( 'Send Message', 'corgi-forms' ),
				'button_loading_text' => __( 'Sending Message...', 'corgi-forms' )
			)
		),

		// Form submit confirmation
		'confirmation' => array(
			'type'    => 'message',
			'message' => __( 'Thank you for contacting us. We will get back to you shortly.', 'corgi-forms' )
		),

		// Admin email notification
		'notification_admin' => array(
			'send_to' => get_option( 'admin_email', '' ),
			'subject' => __( 'You have a new message.', 'corgi-forms' ),
			'content' => __( '{{all_fields}}', 'corgi-forms' )
		)

	);

	update_option( 'crfo_form_settings', $form_settings );

}
add_action( 'crfo_update_check', 'crfo_add_first_activation_settings' );