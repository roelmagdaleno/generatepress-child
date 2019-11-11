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
 * Render a table with inputs and textareas to convert
 * them in a collapsible fields in the frontend.
 *
 * @since 0.1.0
 *
 * @param array   $metabox   The metabox data.
 * @param array   $value     The metabox current value.
 */
function rmr_render_collapse_field( $metabox, $value ) {
	echo '<table class="wp-list-table widefat fixed striped users">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Título</th>';
	echo '<th>Contenido</th>';
	echo '</tr> </thead>';
	echo '<tbody id="rmr-results-for-' . $metabox['id'] . '" data-metabox-id="' . $metabox['id'] . '">';

	if ( isset( $value['title'] ) ) {
		foreach ( $value['title'] as $index => $result ) {
			echo '<tr>';
			echo '<td> <input type="text" value="' . $result . '" name="' . $metabox['id'] . '[title][]" class="large-text widefat"> </td>';
			echo '<td> <textarea name="' . $metabox['id'] . '[content][]" class="large-text widefat">' . $value['content'][ $index ] . '</textarea> </td>';
			echo '</tr>';
		}
	}

	echo '</tbody> </table>';
	echo '<br>';
	echo '<button type="button" class="button button-primary" onclick="RMR_addResult(\'' . $metabox['id'] . '\')">Add Result</button>';
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
