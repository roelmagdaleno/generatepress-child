<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'post_thumbnail_html', 'rmr_featured_images_as_webp' );
add_filter( 'the_content', 'rmr_images_as_webp' );
add_action( 'admin_init', 'rmr_disable_s3_path_on_admin' );

/**
 * Disable the S3 bucket link for uploads directory only in admin side.
 *
 * Roel do this because the upload.php dashboard loads very slow when
 * loading the images from the CDN. Instead, load the local links for every image.
 *
 * @since 0.1.9
 */
function rmr_disable_s3_path_on_admin() {
	define( 'S3_UPLOADS_DISABLE_REPLACE_UPLOAD_URL', true );
}

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
