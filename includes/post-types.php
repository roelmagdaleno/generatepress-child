<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'rmr_create_post_types' );

/**
 * Create custom post types for custom content
 * that needs to exist in its own url or category.
 *
 * @since 0.1.7
 */
function rmr_create_post_types() {
	$post_types = array(
		'hub'      => array(
			'labels'       => array(
				'name'          => 'Hubs',
				'singular_name' => 'Hub',
			),
			'public'       => true,
			'hierarchical' => true,
			'menu_icon'    => 'dashicons-book',
			'rewrite'      => array( 'slug' => 'hub' ),
			'supports'     => array(
				'title',
				'editor',
				'revisions',
				'thumbnail',
				'page-attributes',
			),
		),
		'snippets' => array(
			'labels'       => array(
				'name'          => 'Snippets',
				'singular_name' => 'Snippet',
			),
			'public'       => true,
			'hierarchical' => true,
			'menu_icon'    => 'dashicons-editor-code',
			'rewrite'      => array( 'slug' => 'snippet' ),
			'supports'     => array(
				'title',
				'editor',
				'revisions',
				'thumbnail',
				'page-attributes',
			),
		),
	);

	foreach ( $post_types as $post_type => $data ) {
		register_post_type( $post_type, $data );
	}
}
