<?php
/**
 * Theme Customizer
 *
 * @package Focus
 */

/**
 * Focus Options
 *
 * @since  0.2.0
 *
 * @return array $options
 */
function focus_options() {

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Color Settings
	$section = 'colors';

	$options['highlight-color'] = array(
		'id' => 'highlight-color',
		'label'   => __( 'Highlight Color', 'focus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#4cc99c',
	);

	$options['highlight-hover'] = array(
		'id' => 'highlight-hover',
		'label'   => __( 'Highlight Hover Color', 'focus' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '#34AE82',
	);

	// Typography
	$section = 'typography';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Typography', 'focus' ),
		'priority' => '75'
	);

	$options['primary-font'] = array(
		'id' => 'primary-font',
		'label'   => __( 'Primary Font', 'focus' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => customizer_library_get_font_choices(),
		'default' => 'roboto'
	);

	$options['secondary-font'] = array(
		'id' => 'secondary-font',
		'label'   => __( 'Secondary Font', 'focus' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => customizer_library_get_font_choices(),
		'default' => 'roboto'
	);

	$options['font-subset'] = array(
		'id' => 'font-subset',
		'label'   => __( 'Google Font Subset', 'focus' ),
		'description'   => __( 'Not all fonts provide each of these subsets.', 'focus' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => customizer_library_get_google_font_subsets(),
		'default' => 'latin'
	);

	// Post Settings
	$section = 'post';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Post', 'focus' ),
		'priority' => '80'
	);

	$options['display-post-meta'] = array(
		'id' => 'display-post-meta',
		'label'   => __( 'Display Post Meta', 'focus' ),
		'description'   => __( 'Displays post date and author under title.', 'focus' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 1,
	);

	// Footer Settings
	$section = 'footer';

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Footer', 'focus' ),
		'priority' => '100'
	);

	$options['footer-text'] = array(
		'id' => 'footer-text',
		'label'   => __( 'Footer Text', 'focus' ),
		'section' => $section,
		'type'    => 'textarea',
		'default' => focus_get_default_footer_text(),
	);

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

}
add_action( 'init', 'focus_options', 100 );

/**
 * Alters some of the defaults for the theme customizer
 *
 * @since  1.0.0.
 *
 * @param  object $wp_customize The global customizer object.
 * @return void
 */
function focus_customizer_defaults( $wp_customize ) {

	$wp_customize->get_section( 'title_tagline' )->title = 'Header';

}
add_action( 'customize_register', 'focus_customizer_defaults', 100 );

/**
 * Narrowing down the choice of Google fonts to a few editorial selections
 *
 * @since  1.0.0.
 *
 * @param  array
 * @return array
 */
function focus_get_google_fonts( $fonts ) {

	$selections = array(
		'Abel',
		'Amatic SC',
		'Cabin',
		'Codystar',
		'Corben',
		'Courgette',
		'Dancing Script',
		'Goudy Bookletter 1911',
		'Josefin Sans',
		'Moulpali',
		'Nixie One',
		'Pontano Sans',
		'Quicksand',
		'Raleway',
		'Roboto',
		'Rokkitt',
		'Sanchez',
		'Tenor Sans',
		'Unna'
	);

	$return = array();

	foreach( $selections as $key ) :
		$select_fonts[$key] = $fonts[$key];
	endforeach;

	return $select_fonts;

}
add_filter( 'customizer_library_get_google_fonts', 'focus_get_google_fonts', 100 );