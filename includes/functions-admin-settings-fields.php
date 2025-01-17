<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Prints the HTML for a given settings field
 *
 * @param array $field
 *
 */
function crfo_output_settings_field( $field = array() ) {

	if( empty( $field['type'] ) )
		echo '';

	else
		/**
		 * Output the settings field by its type
		 *
		 * @param array $field
		 *
		 */
		do_action( 'crfo_output_settings_field_' . $field['type'], $field );

}


/**
 * Callback for outputting heading type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_heading( $field = array() ) {

	echo '<div class="crfo-settings-heading">' . ( isset( $field['default'] ) ? $field['default'] : '' ) . '</div>';

}
add_action( 'crfo_output_settings_field_heading', 'crfo_output_settings_field_heading' );


/**
 * Callback for outputting text type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_text( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field input
	$echo .= '<input type="text" id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $value ) . '" class="' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" ' . ( ! empty( $field['disabled'] ) ? 'disabled' : '' ) . ' />';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_text', 'crfo_output_settings_field_text' );


/**
 * Callback for outputting password type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_password( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field input
	$echo .= '<input type="password" id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $value ) . '" class="' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" ' . ( ! empty( $field['disabled'] ) ? 'disabled' : '' ) . ' />';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_password', 'crfo_output_settings_field_password' );


/**
 * Callback for outputting textarea type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_textarea( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field textarea
	$echo .= '<textarea id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '">' . esc_textarea( $value ) . '</textarea>';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_textarea', 'crfo_output_settings_field_textarea' );


/**
 * Callback for outputting colorpicker type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_colorpicker( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field input
	$echo .= '<input class="crfo-colorpicker ' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" type="text" id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $value ) . '" />';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_colorpicker', 'crfo_output_settings_field_colorpicker' );


/**
 * Callback for outputting datepicker type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_datepicker( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field input
	$echo .= '<input class="crfo-datepicker ' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" type="text" id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $value ) . '" />';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_datepicker', 'crfo_output_settings_field_datepicker' );


/**
 * Callback for outputting editor type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_editor( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value 			 = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );
	
	$editor_settings = array( 'textarea_name' => $field['name'] );
	$editor_settings = ( ! empty( $field['editor_settings'] ) ? array_merge( $editor_settings, $field['editor_settings'] ) : $editor_settings );

	ob_start();

	// Field wp_editor
	wp_editor( $value, str_replace( '[', '-', str_replace( ']', '', $field['name'] ) ), $editor_settings );

	$echo .= ob_get_contents();

	ob_end_clean();

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_editor', 'crfo_output_settings_field_editor' );


/**
 * Callback for outputting switch type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_switch( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	$echo .= '<div class="crfo-switch small">';

		$echo .= '<input id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="crfo-toggle crfo-toggle-round ' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" type="checkbox" value="1" ' . ( ! empty( $value ) ? 'checked' : '' ) . ' />';
		$echo .= '<label for="' . esc_attr( $field['name'] ) . '"></label>';

	$echo .= '</div>';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_switch', 'crfo_output_settings_field_switch' );


/**
 * Callback for outputting single checkbox type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_checkbox( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field input
	$echo .= '<input type="checkbox" id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" value="1" ' . ( ! empty( $value ) ? 'checked' : '' ) . ' class="' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" />';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_checkbox', 'crfo_output_settings_field_checkbox' );


/**
 * Callback for outputting multiple checkboxes type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_checkbox_multiple( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	// Field inputs
	if( ! empty( $field['options'] ) ) {
		foreach( $field['options'] as $checkbox_value => $checkbox_label ) {

			$value = ( isset( $field['value'][$checkbox_value] ) ? $field['value'][$checkbox_value] : ( isset( $field['default'][$checkbox_value] ) ? $field['default'][$checkbox_value] : '' ) );

			$echo .= '<label for="' . esc_attr( $field['name'] ) . '[' . esc_attr( $checkbox_value ) . ']">';
			$echo .= '<input type="checkbox" id="' . esc_attr( $field['name'] ) . '[' . esc_attr( $checkbox_value ) . ']" name="' . esc_attr( $field['name'] ) . '[' . esc_attr( $checkbox_value ) . ']" value="1" ' . ( ! empty( $value ) ? 'checked' : '' ) . ' class="' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '" />';
			$echo .= esc_attr( $checkbox_label ) . '</label>';
		}
	}

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_checkbox_multiple', 'crfo_output_settings_field_checkbox_multiple' );


/**
 * Callback for outputting select type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_select( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field inputs
	$echo .= '<select id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '">';

	if( ! empty( $field['options'] ) ) {
		foreach( $field['options'] as $option_value => $option_label ) {

			$echo .= '<option value="' . esc_attr( $option_value ) . '" ' . ( $value == $option_value ? 'selected' : '' ) . '>' . esc_attr( $option_label ) . '</option>';

		}
	}
	$echo .= '</select>';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_select', 'crfo_output_settings_field_select' );


/**
 * Callback for outputting select_multiple type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_select_multiple( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	// Enforce the default value to be an array
	if( empty( $field['default'] ) || ! is_array( $field['default'] ) )
		$field['default'] = array();

	// Enforce the value to be an array
	if( empty( $field['value'] ) || ! is_array( $field['value'] ) )
		$field['value'] = array();

	// Field inputs
	$echo .= '<select multiple id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '[]" class="crfo-chosen ' . ( ! empty( $field['input_class'] ) ? esc_attr( $field['input_class'] ) : '' ) . '">';

	if( ! empty( $field['options'] ) ) {

		foreach( $field['options'] as $option_value => $option_label ) {

			$value = ( in_array( $option_value, $field['value'] ) ? $option_value : ( in_array( $option_value, $field['default'] ) ) ? $option_value : '' );

			$echo .= '<option value="' . esc_attr( $option_value ) . '" ' . ( ! empty( $value ) ? 'selected' : '' ) . '>';
			$echo .= esc_attr( $option_label ) . '</option>';
		}
	}

	$echo .= '</select>';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_select_multiple', 'crfo_output_settings_field_select_multiple' );


/**
 * Callback for outputting image type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_image( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$echo  = '<div class="crfo-settings-field crfo-settings-field-' . esc_attr( $field['type'] ) . '" ' . ( ! empty( $field['conditional'] ) ? 'data-conditional="' . esc_attr( $field['conditional'] ) . '"' : '' ) . ' ' . ( ! empty( $field['conditional_value'] ) ? 'data-conditional-value="' . esc_attr( $field['conditional_value'] ) . '"' : '' ) . '>';

	// Label
	if( ! empty( $field['label'] ) ) {
		$echo .= '<label class="crfo-settings-field-label" for="' . esc_attr( $field['name'] ) . '">' . esc_attr( $field['label'] );

		if( ! empty( $field['desc'] ) )
			$echo .= crfo_output_settings_field_tooltip( $field['desc'], true );

		$echo .= '</label>';
	}

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Get image thumnail
	if( ! empty( $value ) )
		$image_url = wp_get_attachment_image_url( (int)$value, 'medium' );
	else
		$image_url = '';

	// Image
	$echo .= '<div ' . ( empty( $image_url ) ? 'style="display: none;"' : '' ) . '>';
		$echo .= '<img src="' . esc_attr( $image_url ) . '" />';
	
		// Replace image button
		$echo .= '<a class="button-secondary crfo-settings-field-image-button-replace" href="#" title="' . __( 'Replace Image', 'opt-in-hound' ) . '"><span class="dashicons dashicons-edit"></span></a>';
		$echo .= '<a class="button-secondary crfo-settings-field-image-button-remove" href="#" title="' . __( 'Remove Image', 'opt-in-hound' ) . '"><span class="dashicons dashicons-no"></span></a>';
	$echo .= '</div>';

	// Add select image button
	$echo .= '<a ' . ( ! empty( $image_url ) ? 'style="display: none;"' : '' ) . ' class="button-primary crfo-settings-field-image-button-select" href="#">' . __( 'Select Image', 'opt-in-hound' ) . '</a>';

	// Add hidden field where the value is saved
	$echo .= '<input type="hidden" id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $value ) . '" />';

	// Extra content after the input
	if( ! empty( $field['content_after'] ) )
		$echo .= $field['content_after'];

	$echo .= '</div>';

	echo $echo;

}
add_action( 'crfo_output_settings_field_image', 'crfo_output_settings_field_image' );


/**
 * Callback for outputting hidden type settings fields
 *
 * @param array $field
 *
 */
function crfo_output_settings_field_hidden( $field = array() ) {

	if( empty( $field['name'] ) )
		return;

	if( empty( $field['type'] ) )
		return;

	$value = ( isset( $field['value'] ) ? $field['value'] : ( isset( $field['default'] ) ? $field['default'] : '' ) );

	// Field input
	$echo = '<input type="hidden" id="' . esc_attr( $field['name'] ) . '" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $value ) . '" />';

	echo $echo;

}
add_action( 'crfo_output_settings_field_hidden', 'crfo_output_settings_field_hidden' );


/**
 * Callback for outputting fields_collection type settings fields
 *
 * The "fields_collection" field is a special field that is made up of other fields,
 * including other fields collections and is saved as a multidimensional array of values
 *
 * @param array $collection
 *
 */
function crfo_output_settings_field_fields_collection( $collection = array() ) {

	if( empty( $collection['name'] ) )
		return;

	if( empty( $collection['fields'] ) )
		return;

	// Go through each field and modify it for the needs of the collection
	foreach( $collection['fields'] as $key => $field ) {

		if( empty( $field['name'] ) )
			continue;

		// Add the field name as an array element to the collection's name
		$field['name'] = $collection['name'] . '[' . $field['name'] . ']';

		// Set the value of each field accordingly
		if( ! empty( $collection['value'][ $key ] ) )
			$field['value'] = $collection['value'][ $key ];

		$collection['fields'][$key] = $field;

	}
	
	// Output each field
	foreach( $collection['fields'] as $field )
		crfo_output_settings_field( $field );
	

}
add_action( 'crfo_output_settings_field_fields_collection', 'crfo_output_settings_field_fields_collection' );


/**
 * Outputs the HTML of the tooltip
 *
 * @param string $tooltip - the text of the tooltip
 * @param bool   $return  - wether to return or to output the HTML
 *
 */
function crfo_output_settings_field_tooltip( $tooltip = '', $return = false ) {

	$output = '<div class="crfo-settings-field-tooltip-wrapper ' . ( ( strpos( $tooltip,  '</a>' ) !== false ) ? 'crfo-has-link' : '' ) . '">';
		$output .= '<span class="crfo-settings-field-tooltip-icon"></span>';
		$output .= '<div class="crfo-settings-field-tooltip">' . $tooltip . '</div>';
	$output .= '</div>';

	if( $return )
		return $output;
	else
		echo $output;

}