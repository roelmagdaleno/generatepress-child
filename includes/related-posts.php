<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'rmr_generatepress_after_site_content', 'rmr_render_related_posts' );

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

	?>

	<div class="rmr-related-posts__wrap">
		<p class="rmr-related-post__main-title">SIGUIENTE LECTURA</p>
		<div class="rmr-related-posts">

	<?php
	foreach ( $related_posts as $related_post ) {
		$permalink = get_permalink( $related_post );
	?>

	<div class="rmr-related-post">
		<div class="rmr-related-post__featured-image">
			<a href="<?php echo $permalink; ?>" title="<?php echo $related_post->post_title; ?>">
				<?php echo get_the_post_thumbnail( $related_post, 'large' ); ?>
			</a>
		</div>
		<div class="rmr-related-post__title">
			<p>
				<a href="<?php echo $permalink; ?>" title="<?php echo $related_post->post_title; ?>">
				<?php echo $related_post->post_title; ?>
				</a>
			</p>
		</div>
	</div>

	<?php
	}
	?>
		</div>
	</div>
	<?php
}

/**
 * Get the related posts according to the current single post.
 *
 * @since  0.1.5
 *
 * @return WP_Post[]   The posts or empty array if not found.
 */
function rmr_get_related_posts() {
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
