<?php
/**
 * Custom functions used for theme mods
 *
 * @package Focus
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Focus 0.1
 */
function focus_body_classes( $classes ) {

	if ( ! is_singular() ) {
		$classes[] = 'grid-view';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_singular() && ( comments_open() || '0' != get_comments_number() ) ) {
		$classes[] = 'comments-active';
	}

	return $classes;
}
add_filter( 'body_class', 'focus_body_classes' );

/**
 * Returns classes to be used by #masthead
 *
 * @return string classes
 */
function focus_masthead_classes() {
	$classes[] = 'site-header';
	if ( get_bloginfo( 'description' ) != '' ) :
		$classes[] = 'site-description-active';
	endif;
	$classes[] = 'clearfix';
	return implode( ' ', $classes );
}