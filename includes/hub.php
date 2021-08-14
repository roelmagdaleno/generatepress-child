<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'wpseo_breadcrumb_output', 'rmr_save_breadcrumbs', 10, 2 );

/**
 * Set the hub menu from "wpseo_breadcrumb_output" filter.
 *
 * It will create a $breadcrumbs global variable because this
 * filter is created before calling the "rmr_get_hub_menu()" function.
 *
 * Then return the breadcrumbs HTML output normally.
 *
 * @since 1.2.8
 *
 * @return array
 */
function rmr_save_breadcrumbs( $output, $presentation ) {
	global $breadcrumbs;
	$breadcrumbs = $presentation->breadcrumbs;

	return $output;
}

/**
 * Construct the sidebars for Hub pages.
 *
 * @since 1.2.8
 */
function rmr_render_hub_sidebar() {
	$layout = generate_get_layout();

	// When to show the right sidebar.
	$rs = array( 'right-sidebar', 'both-sidebars', 'both-right', 'both-left' );

	// When to show the left sidebar.
	$ls = array( 'left-sidebar', 'both-sidebars', 'both-right', 'both-left' );

	// If left sidebar, show it.
	if ( in_array( $layout, $ls ) ) {
		get_sidebar( 'left' );
	}

	// If right sidebar, show it.
	if ( in_array( $layout, $rs ) ) {
		get_sidebar( 'hub' );
	}
}

/**
 * Get the hub sidebar menu.
 *
 * The array contains the main, section and the current children
 * for the current section.
 *
 * @since  1.2.8
 *
 * @return array   The hub sidebar menu.
 */
function rmr_get_hub_menu() {
	global $breadcrumbs;

	if ( ! isset( $breadcrumbs[2] ) ) {
		return array();
	}

	$hub      = $breadcrumbs[1]; // 1 index contains the hub.
	$section  = $breadcrumbs[2]; // 2 index contains the section.
	$children = get_children( $section['id'] );

	return compact( 'hub', 'section', 'children' );
}
