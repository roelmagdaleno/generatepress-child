<?php

add_filter( 'excerpt_length', 'rmr_excerpt_length', 999 );
add_action( 'rmr_generatepress_after_site_content', 'rmr_render_related_posts' );

function rmr_excerpt_length() : int {
	return 25;
}

/**
 * Render the related posts under the article and before the comments.
 *
 * @since 0.1.5
 *
 * @hook  rmr_generatepress_after_site_content
 */
function rmr_render_related_posts() {
	if ( ! is_single() ) {
		return;
	}

	$related_posts = rmr_get_related_posts();

	if ( empty( $related_posts ) ) {
		return;
	}

	include dirname( __DIR__ ) . '/public/templates/related-posts.php';
}

/**
 * Get the related posts according to the current single post.
 *
 * @since  0.1.5
 *
 * @return WP_Post[]   The posts or empty array if not found.
 */
function rmr_get_related_posts() : array {
	global $post;

	$tags = wp_get_post_tags( $post->ID );

	if ( empty( $tags ) || is_wp_error( $tags ) ) {
		return array();
	}

	$args = array(
		'tag__in'      => wp_list_pluck( $tags, 'term_id' ),
		'post__not_in' => array( $post->ID ),
		'numberposts'  => 3,
	);

	return get_posts( $args );
}
