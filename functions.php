<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/constants.php';
require_once 'includes/related-posts.php';
require_once 'includes/post-types.php';
require_once 'includes/fonts.php';
require_once 'includes/images.php';
require_once 'includes/hub.php';
require_once 'includes/custom-widgets.php';

/**
 * For some reason we cannot remove the "generate_meta_viewport" action hook,
 * so we have to return null in the filter and put the meta viewport in our header.php.
 *
 * @since 0.1.2
 */
add_filter( 'generate_meta_viewport', '__return_null' );

remove_action( 'wp_head', '_wp_render_title_tag', 1 );
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'feed_links', 2 );

add_action( 'wp_head', 'feed_links' );
add_action( 'wp_enqueue_scripts', 'rmr_load_custom_assets' );
add_action( 'enqueue_block_editor_assets', 'rmr_load_fonts_in_gutenberg_editor' );
add_action( 'rmr_generatepress_after_site_content', 'generate_do_comments_template', 15 );
add_action( 'init', 'rmr_disable_emojis' );
add_action( 'wp_loaded', 'rmr_wp_loaded' );
add_filter( 'run_wptexturize', '__return_false', 9999 );

/**
 * Get the estimated reading time in minutes.
 *
 * @since  0.1.7
 *
 * @param  string   $content   The post content.
 * @param  int      $wpm       Words per minute. Default to 250.
 * @return false|float         Reading time in minutes.
 */
function rmr_get_estimated_reading_time( string $content = '', int $wpm = 250 ) {
	$content    = strip_shortcodes( $content );
	$content    = strip_tags( $content );
	$word_count = str_word_count( $content );

	return ceil( $word_count / $wpm );
}

/**
 * Set functions after WordPress is loaded.
 * @since 0.1.5
 */
function rmr_wp_loaded() {
	remove_action( 'generate_after_do_template_part', 'generate_do_comments_template', 15 );
}

/**
 * Disable emojis from the entire site.
 * @since 0.1.2
 */
function rmr_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'rmr_disable_emojis_tinymce' );
}

/**
 * Disable emojis for tinyMCE editors.
 *
 * @since  0.1.2
 *
 * @param  array   $plugins   The tinyMCE plugins.
 * @return array              The tinyMCE without the "wpemoji" script.
 */
function rmr_disable_emojis_tinymce( array $plugins ) : array {
	return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

/**
 * Load the "JetBrains Mono" font in single posts and only if the post contains
 * the "core/code" Gutenberg block.
 *
 * @since 0.1.1
 * @since 0.2.3 Deregister jQuery for non logged-in users.
 */
function rmr_load_custom_assets() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_script( 'jquery' );
	}

	wp_deregister_script( 'wp-embed' );

	$uri = get_stylesheet_directory_uri();

	if ( 'hub' === get_post_type() ) {
		wp_enqueue_style(
			'rmr-hub.css',
			$uri . '/assets/css/hub.css',
			null,
			RMR_VERSION
		);
	}

	if ( is_single() ) {
		wp_enqueue_style(
			'rmr-single.css',
			$uri . '/assets/css/single.css',
			null,
			RMR_VERSION
		);
	}
}

/**
 * Load ASAP fonts in Gutenberg editor.
 *
 * Why we have to do this?
 * Gutenberg won't load the local fonts we just added. Previously was
 * adding the fonts from Google Fonts.
 *
 * @since 0.1.0
 */
function rmr_load_fonts_in_gutenberg_editor() {
	wp_enqueue_style( 'rmr-styles', get_stylesheet_uri() );
}

/**
 * Render the share buttons widgets.
 *
 * We have two ways to render the share buttons, using the custom widget
 * and this function.
 *
 * Use this function to render the buttons wherever you want.
 *
 * @since 0.3.0
 */
function rmr_render_share_buttons() {
	include_once 'admin/views/share.php';
}
