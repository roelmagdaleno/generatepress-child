<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'post_thumbnail_html', 'rmr_featured_images_as_webp' );
add_filter( 'generate_single_featured_image_output', 'rmr_remove_featured_image_lazy_load' );
add_filter( 'the_content', 'rmr_images_as_webp' );

/**
 * Remove lazy load from post featued image.
 *
 * @since  0.3.0
 *
 * @param  string   $html   The post featured image.
 * @return string           The post featured image without lazy load.
 */
function rmr_remove_featured_image_lazy_load( string $html ) : string {
	return str_replace( 'loading="lazy"', '', $html );
}

/**
 * Use featured image as webp instead of png, jpg or jpeg.
 *
 * @since  0.1.8
 *
 * @param  string   $html   The post thumbnail HTML.
 * @return string           The post thumbnail HTML as webp.
 */
function rmr_featured_images_as_webp( string $html ) : string {
	$extensions = array(
		'.png',
		'.jpg',
		'.jpeg',
	);

	return str_replace( $extensions, '.webp', $html );
}

/**
 * Use images as webp instead of png, jpg or jpeg for post content.
 *
 * @since  0.1.8
 *
 * @param  string   $content   The post content.
 * @return string              The post content with images as webp.
 */
function rmr_images_as_webp( $content ) {
	$extensions = array(
		'.png',
		'.jpg',
		'.jpeg',
	);

	return str_replace( $extensions, '.webp', $content );
}
