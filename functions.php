<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'includes/constants.php';

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
add_action( 'wp_head', 'rmr_preload_fonts', 8 );
add_action( 'wp_enqueue_scripts', 'rmr_load_custom_assets' );
add_action( 'enqueue_block_editor_assets', 'rmr_load_fonts_in_gutenberg_editor' );
add_filter( 'generate_logo_attributes', 'rmr_lazy_logo', 10, 1 );
add_filter( 'generate_typography_default_fonts', 'rmr_load_local_fonts', 10, 1 );
add_action( 'generate_menu_bar_items', 'rmr_add_dark_mode_button', 20 );
add_action( 'init', 'rmr_disable_emojis' );

/**
 * Add the dark mode button into the header navigation.
 *
 * @since 0.1.2
 */
function rmr_add_dark_mode_button() {
	$moon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>';

	$sun = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>';

	echo '<button type="button" class="rmr__dark-mode__btn" onclick="window.rmr.darkMode.add()">';
	echo $moon;
	echo $sun;
	echo '</button>';
}

/**
 * Disable emojis from the entire site.
 *
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

	if ( ! is_single() || ! has_block( 'core/code' ) ) {
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
 * Add "preload" links in <head> HTML tag. These lines will help to reduce GPSI scores.
 *
 * @since 0.1.0
 * @since 0.1.1   Preload JetBrains Mono font.
 */
function rmr_preload_fonts() {
	echo '<link rel="preload" href="' . RMR_THEME_URI . '/assets/fonts/inter/Inter-Regular.woff2" as="font" type="font/woff2" crossorigin>';

	echo '<link rel="preload" href="' . RMR_THEME_URI . '/assets/fonts/inter/Inter-Bold.woff2" as="font" type="font/woff2" crossorigin>';

	if ( is_single() && has_block( 'core/code' ) ) {
		echo '<link rel="preload" href="' . RMR_THEME_URI . '/assets/fonts/jetbrains-mono/JetBrainsMono-Regular.woff2" as="font" type="font/woff2" crossorigin>';
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
 * Load local fonts and use them in theme instead of using Google Fonts CDN.
 * We're using these fonts locally:
 *
 * - Asap (blog and pages)
 * - JetBrains Mono (for code editor)
 *
 * @since  0.1.0
 *
 * @param  array   $fonts   The current default fonts.
 * @return array            The fonts with our custom ones.
 */
function rmr_load_local_fonts( $fonts ) {
	$fonts[] = 'Inter';
	$fonts[] = 'JetBrains Mono';

	return $fonts;
}

/**
 * Lazy Load Header Logo.
 * We're lazy loading the logo by using "WP Bullet Lazy Load".
 *
 * We have to add the "wp-bullet-lazy-load" class, add the "data-src"
 * attribute and remove "src".
 *
 * It's recommended to add "width" and "height" attributes to keep dimensions.
 *
 * @since  0.1.0
 *
 * @param  array   $attr   The logo attributes.
 * @return array           The logo with lazy load attributes.
 */
function rmr_lazy_logo( $attr ) {
	$attr['data-src'] = $attr['src'];
	$attr['class']    = $attr['class'] . ' ' . 'wp-bullet-lazy-load';
	$attr['width']    = '40';
	$attr['height']   = '60';

	unset( $attr['src'] );

	return $attr;
}
