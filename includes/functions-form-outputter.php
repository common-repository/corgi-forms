<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Output form
 *
 */
function crfo_output_form() {

	$form_settings = get_option( 'crfo_form_settings', array() );

	if( empty( $form_settings ) )
		return;

	if( empty( $form_settings['fields'] ) || ! is_array( $form_settings['fields'] ) )
		return;

	// Form wrapper
	echo '<div id="corgi-forms-form-wrapper-1" class="corgi-forms-form-wrapper">';

		// Form
		echo '<form method="post" id="corgi-forms-form-1" class="corgi-forms-form">';

		// General errors
		echo '<div class="corgi-forms-form-errors"></div>';

		// Output each field
		foreach( $form_settings['fields'] as $field ) {

			crfo_output_form_field( $field );

		}

		// Nonce field
		wp_nonce_field( 'corgi_form_submit', 'crfo_token' );

		echo '</form>';

	echo '</div>';

}


/**
 * Registers the form shortcode
 *
 */
function crfo_form_shortcode( $atts ) {

	$atts = shortcode_atts( array(), $atts );

	ob_start();

	crfo_output_form();

	$output = ob_get_contents();

	ob_end_clean();

	return $output;

}
add_shortcode( 'corgi_form', 'crfo_form_shortcode' );


/**
 * Output form field
 *
 */
function crfo_output_form_field( $field = array() ) {

	if( empty( $field['type'] ) )
		return;

	do_action( 'crfo_output_form_field_' . $field['type'], $field );

}


/**
 * Output field of type "first_name"
 *
 * @param array $field
 *
 */
function crfo_output_form_field_first_name( $field = array() ) {

	if( $field['type'] != 'first_name' )
		return;

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['display'] ) )
		return;

	// Field wrapper begin
	echo '<div class="corgi-forms-field ' . ( ! empty( $field['required'] ) ? 'corgi-forms-field-required' : '' ) . '" data-name="' . $field['name'] . '">';

	// Field label
	if( ! empty( $field['label'] ) ) {

		echo '<label for="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" class="corgi-forms-field-label">';
			echo wp_kses_post( $field['label'] );

			if( ! empty( $field['required'] ) )
				echo '<span class="corgi-forms-field-label-required">*</span>';
		echo '</label>';

	}

	// Field
	echo '<div class="corgi-forms-field-input-wrapper">';
		echo '<input type="text" id="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" name="' . esc_attr( $field['name'] ) . '" />';
	echo '</div>';

	// Field description
	if( ! empty( $field['description'] ) ) {

		echo '<div class="corgi-forms-field-description-wrapper">';
			echo '<p class="corgi-forms-field-description">' . wp_kses_post( $field['description'] ) . '</p>';
		echo '</div>';

	}

	// Field errors
	echo '<div class="corgi-forms-field-errors-wrapper"></div>';

	// Field wrapper end
	echo '</div>';

}
add_action( 'crfo_output_form_field_first_name', 'crfo_output_form_field_first_name' );


/**
 * Output field of type "last_name"
 *
 * @param array $field
 *
 */
function crfo_output_form_field_last_name( $field = array() ) {

	if( $field['type'] != 'last_name' )
		return;

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['display'] ) )
		return;

	// Field wrapper begin
	echo '<div class="corgi-forms-field ' . ( ! empty( $field['required'] ) ? 'corgi-forms-field-required' : '' ) . '" data-name="' . $field['name'] . '">';

	// Field label
	if( ! empty( $field['label'] ) ) {

		echo '<label for="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" class="corgi-forms-field-label">';
			echo wp_kses_post( $field['label'] );

			if( ! empty( $field['required'] ) )
				echo '<span class="corgi-forms-field-label-required">*</span>';
		echo '</label>';

	}

	// Field
	echo '<div class="corgi-forms-field-input-wrapper">';
		echo '<input type="text" id="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" name="' . esc_attr( $field['name'] ) . '" />';
	echo '</div>';

	// Field description
	if( ! empty( $field['description'] ) ) {

		echo '<div class="corgi-forms-field-description-wrapper">';
			echo '<p class="corgi-forms-field-description">' . wp_kses_post( $field['description'] ) . '</p>';
		echo '</div>';

	}

	// Field errors
	echo '<div class="corgi-forms-field-errors-wrapper"></div>';

	// Field wrapper end
	echo '</div>';

}
add_action( 'crfo_output_form_field_last_name', 'crfo_output_form_field_last_name' );


/**
 * Output field of type "email_address"
 *
 * @param array $field
 *
 */
function crfo_output_form_field_email_address( $field = array() ) {

	if( $field['type'] != 'email_address' )
		return;

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['display'] ) )
		return;

	// Field wrapper begin
	echo '<div class="corgi-forms-field ' . ( ! empty( $field['required'] ) ? 'corgi-forms-field-required' : '' ) . '" data-name="' . $field['name'] . '">';

	// Field label
	if( ! empty( $field['label'] ) ) {

		echo '<label for="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" class="corgi-forms-field-label">';
			echo wp_kses_post( $field['label'] );

			if( ! empty( $field['required'] ) )
				echo '<span class="corgi-forms-field-label-required">*</span>';
		echo '</label>';

	}

	// Field
	echo '<div class="corgi-forms-field-input-wrapper">';
		echo '<input type="email" id="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" name="' . esc_attr( $field['name'] ) . '" />';
	echo '</div>';

	// Field description
	if( ! empty( $field['description'] ) ) {

		echo '<div class="corgi-forms-field-description-wrapper">';
			echo '<p class="corgi-forms-field-description">' . wp_kses_post( $field['description'] ) . '</p>';
		echo '</div>';

	}

	// Field errors
	echo '<div class="corgi-forms-field-errors-wrapper"></div>';

	// Field wrapper end
	echo '</div>';

}
add_action( 'crfo_output_form_field_email_address', 'crfo_output_form_field_email_address' );


/**
 * Output field of type "text"
 *
 * @param array $field
 *
 */
function crfo_output_form_field_text( $field = array() ) {

	if( $field['type'] != 'text' )
		return;

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['display'] ) )
		return;

	// Field wrapper begin
	echo '<div class="corgi-forms-field ' . ( ! empty( $field['required'] ) ? 'corgi-forms-field-required' : '' ) . '" data-name="' . $field['name'] . '">';

	// Field label
	if( ! empty( $field['label'] ) ) {

		echo '<label for="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" class="corgi-forms-field-label">';
			echo wp_kses_post( $field['label'] );

			if( ! empty( $field['required'] ) )
				echo '<span class="corgi-forms-field-label-required">*</span>';
		echo '</label>';

	}

	// Field
	echo '<div class="corgi-forms-field-input-wrapper">';
		echo '<input type="email" id="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" name="' . esc_attr( $field['name'] ) . '" />';
	echo '</div>';

	// Field description
	if( ! empty( $field['description'] ) ) {

		echo '<div class="corgi-forms-field-description-wrapper">';
			echo '<p class="corgi-forms-field-description">' . wp_kses_post( $field['description'] ) . '</p>';
		echo '</div>';

	}

	// Field errors
	echo '<div class="corgi-forms-field-errors-wrapper"></div>';

	// Field wrapper end
	echo '</div>';

}
add_action( 'crfo_output_form_field_text', 'crfo_output_form_field_text' );


/**
 * Output field of type "textarea"
 *
 * @param array $field
 *
 */
function crfo_output_form_field_textarea( $field = array() ) {

	if( $field['type'] != 'textarea' )
		return;

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['display'] ) )
		return;

	// Field wrapper begin
	echo '<div class="corgi-forms-field ' . ( ! empty( $field['required'] ) ? 'corgi-forms-field-required' : '' ) . '" data-name="' . $field['name'] . '">';

	// Field label
	if( ! empty( $field['label'] ) ) {

		echo '<label for="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" class="corgi-forms-field-label">';
			echo wp_kses_post( $field['label'] );

			if( ! empty( $field['required'] ) )
				echo '<span class="corgi-forms-field-label-required">*</span>';
		echo '</label>';

	}

	// Field
	echo '<div class="corgi-forms-field-input-wrapper">';
		echo '<textarea id="corgi-forms-field-' . esc_attr( $field['name'] ) . '-1" name="' . esc_attr( $field['name'] ) . '"></textarea>';
	echo '</div>';

	// Field description
	if( ! empty( $field['description'] ) ) {

		echo '<div class="corgi-forms-field-description-wrapper">';
			echo '<p class="corgi-forms-field-description">' . wp_kses_post( $field['description'] ) . '</p>';
		echo '</div>';

	}

	// Field errors
	echo '<div class="corgi-forms-field-errors-wrapper"></div>';

	// Field wrapper end
	echo '</div>';

}
add_action( 'crfo_output_form_field_textarea', 'crfo_output_form_field_textarea' );


/**
 * Output field of type "button"
 *
 * @param array $field
 *
 */
function crfo_output_form_field_button( $field = array() ) {

	if( $field['type'] != 'button' )
		return;

	// Field wrapper begin
	echo '<div class="corgi-forms-field ' . ( ! empty( $field['required'] ) ? 'corgi-forms-field-required' : '' ) . '">';

	// Field
	echo '<div class="corgi-forms-field-input-wrapper">';

		echo '<button>' . esc_attr( $field['button_text'] ) . '</button>';

		// Button texts
		echo '<span style="display: none;" class="corgi-forms-field-button-text">' . esc_attr( $field['button_text'] ) . '</span>';
		echo '<span style="display: none;" class="corgi-forms-field-button-loading-text">' . esc_attr( $field['button_loading_text'] ) . '</span>';

	echo '</div>';

	// Field wrapper end
	echo '</div>';

}
add_action( 'crfo_output_form_field_button', 'crfo_output_form_field_button' );