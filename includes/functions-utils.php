<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Recursively sanitizes an array
 *
 * @param array $array
 *
 * @return array
 *
 */
function crfo_sanitize_array( $array = array() ) {

	if( ! is_array( $array ) )
		return wp_kses_post( $array );

	foreach( $array as $key => $value ) {
		$array[$key] = crfo_sanitize_array( $value );
	}

	return $array;
	
}