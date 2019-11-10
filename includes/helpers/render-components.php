<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Construct the render function to echo out
 * the current field and its value.
 *
 * @since 0.1.0
 *
 * @param WP_Post   $post      The current post data.
 * @param array     $metabox   The metabox data.
 */
function rmr_render_field( WP_Post $post, $metabox ) {
	$args     = $metabox['args'];
	$value    = get_post_meta( $post->ID, $metabox['id'], true );
	$function = 'rmr_render_' . $args['type'] . '_field';

	$function( $metabox, $value );
}

/**
 * Render a text field.
 *
 * @since 0.1.0
 *
 * @param array    $metabox   The metabox data.
 * @param string   $value     The metabox current value.
 */
function rmr_render_text_field( $metabox, $value ) {
	$field  = '<input type="text" value="' . esc_attr( $value ) . '" ';
	$field .= 'name="' . $metabox['id'] . '" class="large-text widefat" />';

	echo $field;
}

/**
 * Render a number field.
 *
 * @since 0.1.0
 *
 * @param array           $metabox   The metabox data.
 * @param string|number   $value     The metabox current value.
 */
function rmr_render_number_field( $metabox, $value ) {
	$field  = '<input type="number" value="' . esc_attr( $value ) . '" ';
	$field .= 'name="' . $metabox['id'] . '" class="large-text widefat" />';

	echo $field;
}
