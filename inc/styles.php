<?php
/**
 * Implements styles set in the theme customizer
 *
 * @package Focus
 */

if ( ! function_exists( 'focus_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function focus_styles() {

	// Highlight Color
	$setting = 'highlight-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array( 'a' ),
			'declarations' => array(
				'color' => sanitize_hex_color( $mod )
			)
		) );

		Customizer_Library_Styles()->add( array(
			'selectors' => array( 'button', '.button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]' ),
			'declarations' => array(
				'background' => sanitize_hex_color( $mod )
			)
		) );

	}

	// Highlight Hover
	$setting = 'highlight-hover';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array( 'a:hover', 'a:focus', 'a:active' ),
			'declarations' => array(
				'color' => sanitize_hex_color( $mod )
			)
		) );

		Customizer_Library_Styles()->add( array(
			'selectors' => array( 'button:hover', '.button:hover', 'input[type="button"]:hover', 'input[type="reset"]:hover', 'input[type="submit"]:hover' ),
			'declarations' => array(
				'background' => sanitize_hex_color( $mod )
			)
		) );

	}

	// Primary Font
	$setting = 'primary-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body'
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );

	}

	// Secondary Font
	$setting = 'secondary-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h1, h2, h3, h4, h5, h6',
				'#masthead',
				'.entry-meta',
				'.taxonomy-description',
				'.paging-navigation .paging-meta',
				'.comments-title',
				'.comment-author',
				'.comment-metadata',
				'#reply-title, .no-comments'
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );

	}

}
endif;

add_action( 'customizer_library_styles', 'focus_styles' );

if ( ! function_exists( 'focus_display_customizations' ) ) :
/**
 * Generates the style tag and CSS needed for the theme options.
 *
 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
 * It is organized this way to ensure there is only one "style" tag.
 *
 * @since  0.2.0
 *
 * @return void
 */
function focus_display_customizations() {

	do_action( 'customizer_library_styles' );

	// Echo the rules
	$css = Customizer_Library_Styles()->build();

	if ( ! empty( $css ) ) {
		echo "\n<!-- Focus CSS -->\n<style type=\"text/css\" id=\"focus-css\">\n";
		echo $css;
		echo "\n</style>\n<!-- End Focus CSS -->\n";
	}
}
endif;

add_action( 'wp_head', 'focus_display_customizations', 11 );