<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Handles the form submission through AJAX
 *
 * Echoes a JSON with errors in case of errors or with success details in case of success
 *
 */
function crfo_form_submission_handler() {

	// Handle error in case of improper action
	if( empty( $_POST['action'] ) || $_POST['action'] !== 'crfo_form_submission' ) {
		echo json_encode( array( 'errors' => array( 'form_error' => __( 'Something went wrong. Could not complete the action.', 'corgi-forms' ) ) ) );
		wp_die();
	}

	// Handle error in case of token
	if( empty( $_POST['crfo_token'] ) || ! wp_verify_nonce( $_POST['crfo_token'], 'corgi_form_submit' ) ) {
		echo json_encode( array( 'errors' => array( 'form_error' => __( 'Something went wrong. Could not complete the action.', 'corgi-forms' ) ) ) );
		wp_die();
	}

	$form_settings    = get_option( 'crfo_form_settings', array() );
	$post_fields      = $_POST;
	$post_fields 	  = crfo_sanitize_array( $post_fields );
	$post_fields_keys = array_keys( $post_fields );

	// Field error array
	$field_errors = array();

	// Handle errors for email field
	if( ! empty( $post_fields['email_address'] ) ) {

		if( ! is_email( $post_fields['email_address'] ) )
			$field_errors['email_address'] = __( 'This is not a valid email address.', 'corgi-forms' );

	}

	// Handle errors in case of missing field value
	foreach( $form_settings['fields'] as $field ) {

		if( empty( $field['display'] ) )
			continue;

		if( empty( $field['required'] ) )
			continue;

		if( ! in_array( $field['name'] , $post_fields_keys ) || empty( $post_fields[$field['name']] ) )
			$field_errors[$field['name']] = __( 'This field is required.', 'corgi-forms' );

	}

	// Return if there are errors
	if( ! empty( $field_errors ) ) {

		echo json_encode(
			array(
				'errors' => array(
					'form_error'   => __( 'Please fill in all required fields.', 'corgi-forms' ),
					'field_errors' => $field_errors
				)
			)
		);

		wp_die();

	}

	// Final form
	$form_fields = array();

	foreach( $form_settings['fields'] as $field ) {

		if( in_array( $field['name'] , $post_fields_keys ) )
			$form_fields[$field['name']] = $post_fields[$field['name']];

	}

	/**
	 * Form submission success action
	 *
	 * @param array $form_fields
	 *
	 */
	do_action( 'crfo_form_submission_success', $form_fields );

	// Return success
	echo json_encode(
		array(
			'success' 		  	   		 => true,
			'confirmation_type'    		 => ( ! empty( $form_settings['confirmation']['type'] ) ? $form_settings['confirmation']['type'] : 'message' ),
			'confirmation_message' 		 => ( ! empty( $form_settings['confirmation']['message'] ) ? wpautop( $form_settings['confirmation']['message'] ) : '' ),
			'confirmation_redirect_page' => ( ! empty( $form_settings['confirmation']['redirect_page'] ) ? get_permalink( (int)$form_settings['confirmation']['redirect_page'] ) : '' ),
			'confirmation_redirect_url'  => ( ! empty( $form_settings['confirmation']['redirect_url'] ) ? sanitize_text_field( $form_settings['confirmation']['redirect_url'] ) : '' )
		)
	);

	wp_die();

}
add_action( 'wp_ajax_no_priv_crfo_form_submission', 'crfo_form_submission_handler' );
add_action( 'wp_ajax_crfo_form_submission', 'crfo_form_submission_handler' );


/**
 * Sends the admin an email notification
 *
 * @param array $form_fields
 *
 */
function crfo_form_submission_success_admin_notification( $form_fields = array() ) {

	if( empty( $form_fields ) )
		return;

	$form_settings = get_option( 'crfo_form_settings', array() );

	if( empty( $form_settings['notification_admin']['send_to'] ) )
		return;

	if( empty( $form_settings['notification_admin']['content'] ) )
		return;

	// Set email send to
	$email_to = array_map( 'trim', explode( ',', $form_settings['notification_admin']['send_to'] ) );

	foreach( $email_to as $key => $admin_email ) {

		if( ! is_email( $admin_email ) )
			unset( $email_to[$key] );

	}


	// Set email subject and content
	$email_subject = ( ! empty( $form_settings['notification_admin']['subject'] ) ? $form_settings['notification_admin']['subject'] : '' );
	$email_content = $form_settings['notification_admin']['content'];

	// Replace the fields with the needed tags
	$email_content = crfo_replace_field_tags( $email_content, $form_fields );


	// Temporary change the from name and from email
    add_filter( 'wp_mail_from_name', 'crfo_email_notification_modify_from_name', 999 );
    add_filter( 'wp_mail_from', 'crfo_email_notification_modify_from_email', 999 );
    add_filter( 'wp_mail_content_type', 'crfo_email_notification_modify_email_content_type', 999 );

    // Send email
    wp_mail( $email_to, $email_subject, wpautop( $email_content ) );

    // Reset the from name and email
    remove_filter( 'wp_mail_from_name', 'crfo_email_notification_modify_from_name', 999 );
    remove_filter( 'wp_mail_from', 'crfo_email_notification_modify_from_email', 999 );
    remove_filter( 'wp_mail_content_type', 'crfo_email_notification_modify_email_content_type', 999 );

}
add_action( 'crfo_form_submission_success', 'crfo_form_submission_success_admin_notification' );


/**
 * Modifies the from_name from the wp_mail_from_name filter before sending an email
 *
 * @param string $from_name
 *
 */
function crfo_email_notification_modify_from_name( $from_name ) {

	$form_settings = get_option( 'crfo_form_settings', array() );

	if( empty( $form_settings['notification_admin']['from_name'] ) )
		return $from_name;

	// Set from name
	$from_name = sanitize_text_field( $form_settings['notification_admin']['from_name'] );

	return $from_name;

}


/**
 * Modifies the from_email from the wp_mail_from filter before sending an email
 *
 * @param string $from_email
 *
 */
function crfo_email_notification_modify_from_email( $from_email ) {

	$form_settings = get_option( 'crfo_form_settings', array() );

	if( empty( $form_settings['notification_admin']['from_email'] ) )
		return $from_email;

	if( ! is_email( $form_settings['notification_admin']['from_email'] ) )
		return $from_email;

	// Set from name
	$from_email = sanitize_text_field( $form_settings['notification_admin']['from_email'] );

	return $from_email;

}


/**
 * Modifies the email content type from the wp_mail_content_type filter before sending an email
 *
 */
function crfo_email_notification_modify_email_content_type() {

	return apply_filters( 'crfo_email_content_type', 'text/html' );

}


/**
 * Replaces the content tags with the appropiate value
 *
 * @param string $content
 * @param array  $tags_data
 *
 * @return string
 *
 */
function crfo_replace_field_tags( $content = '', $tags_data = array() ) {

	if( empty( $content ) )
		return $content;

	if( empty( $tags_data ) )
		return $content;

	foreach( $tags_data as $tag_name => $tag_value ) {

		$content = str_replace( '{{' . $tag_name . '}}' , $tag_value, $content );

	}

	/**
	 * Filter to handle other tags
	 *
	 * @param string $content
	 * @param array  $tags_data
	 *
	 */
	$content = apply_filters( 'crfo_replace_field_tags', $content, $tags_data );

	return $content;

}


/**
 * Replaces the "all_fields" content tag with a table template
 *
 * @param string $content
 * @param array  $tags_data
 *
 * @return string
 *
 */
function crfo_replace_field_tags_all_fields( $content = '', $tags_data = array() ) {

	$form_settings = get_option( 'crfo_form_settings', array() );

	if( false === strpos( $content, '{{all_fields}}' ) )
		return $content;

	$template  = '<table style="min-width: 500px;">';

	foreach( $tags_data as $tag_name => $tag_value ) {

		// Tag name
		$template .= '<tr>';
			$template .= '<td style="font-weight: bold; padding: 10px; background-color: #e1f0fa;">';

			foreach( $form_settings['fields'] as $field ) {

				if( $field['name'] == $tag_name )
					$template .= ( ! empty( $field['label'] ) ? sanitize_text_field( $field['label'] ) : '' );

			}
			
			$template .= '</td>';
		$template .= '</tr>';

		// Tag value
		$template .= '<tr>';
			$template .= '<td style="padding: 10px;">' . $tag_value . '</td>';
		$template .= '</tr>';

	}

	$template .= '</table>';

	$content = str_replace( '{{all_fields}}', $template, $content );

	return $content;

}
add_filter( 'crfo_replace_field_tags', 'crfo_replace_field_tags_all_fields', 10, 2 );