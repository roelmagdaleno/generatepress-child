<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'post_thumbnail_html', 'rmr_featured_images_as_webp' );

/**
 * Use featured image as webp instead of png, jpg or jpeg.
 *
 * @since  0.1.8
 *
 * @param  string   $html   The post thumbnail HTML.
 * @return string           The post thumbnail HTML as webp.
 */
function rmr_featured_images_as_webp( $html ) {
	$extensions = array(
		'.png',
		'.jpg',
		'.jpeg',
	);

	return str_replace( $extensions, '.webp', $html );
}
