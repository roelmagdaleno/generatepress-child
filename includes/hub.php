<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Construct the sidebars for Hub pages.
 *
 * @since 1.2.8
 */
function rmr_construct_hub_sidebar() {
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
