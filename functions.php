<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/constants.php';
require_once 'includes/related-posts.php';
require_once 'includes/post-types.php';
require_once 'includes/fonts.php';

/**
 * For some reason we cannot remove the "generate_meta_viewport" action hook
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
add_action( 'generate_menu_bar_items', 'rmr_add_dark_mode_button', 20 );
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
function rmr_get_estimated_reading_time( $content = '', $wpm = 250 ) {
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
 * Add the dark mode button into the header navigation.
 * @since 0.1.2
 */
function rmr_add_dark_mode_button() {
	$moon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>';

	$sun = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';

	echo '<button type="button" aria-label="Toggle Dark Mode" class="rmr__dark-mode__btn" onclick="window.rmr.darkMode.add()">';
	echo $moon;
	echo $sun;
	echo '</button>';
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
function rmr_disable_emojis_tinymce( $plugins ) {
	return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

/**
 * Load the "JetBrains Mono" font in single posts and only if the post contains
 * the "core/code" Gutenberg block.
 *
 * @since 0.1.1
 */
function rmr_load_custom_assets() {
	wp_deregister_script( 'wp-embed' );

	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'rmr-dark-mode-styles',
		$uri . '/assets/css/dark-mode.css',
		null,
		RMR_VERSION
	);

	wp_enqueue_script(
		'rmr-dark-mode',
		$uri . '/assets/js/dark-mode.js',
		null,
		RMR_VERSION,
		true
	);

	if ( ! is_single() ) {
		return;
	}

	wp_enqueue_style(
		'rmr-single.css',
		$uri . '/assets/css/single.css',
		null,
		RMR_VERSION
	);
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
