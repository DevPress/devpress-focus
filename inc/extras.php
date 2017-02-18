<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Focus
 */


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function focus_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'focus_setup_author' );

/**
 * Add HTML5 placeholders for each default comment field
 *
 * @param array $fields
 * @return array $fields
 */
function focus_comment_fields( $fields ) {

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields['author'] =
        '<p class="comment-form-author">
        	<label for="author">' . __( 'Name', 'summit' ) . '</label>
            <input required minlength="3" maxlength="30" placeholder="' . __( 'Name *', 'summit' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' />
        </p>';

    $fields['email'] =
        '<p class="comment-form-email">
        	<label for="email">' . __( 'Email', 'summit' ) . '</label>
            <input required placeholder="' . __( 'Email *', 'summit' ) . '" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' />
        </p>';

    $fields['url'] =
        '<p class="comment-form-url">
        	<label for="url">' . __( 'Website', 'summit' ) . '</label>
            <input placeholder="' . __( 'Website', 'summit' ) . '" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" />
        </p>';

    return $fields;
}
add_filter( 'comment_form_default_fields', 'focus_comment_fields' );

/**
 * Add HTML5 placeholder to the comment textarea.
 *
 * @param string $comment_field
 * @return string $comment_field
 */
 function focus_commtent_textarea( $comment_field ) {

    $comment_field =
        '<p class="comment-form-comment">
            <textarea required placeholder="' . __( 'Comment *', 'summit' ) . '" id="comment" name="comment" cols="45" rows="6" aria-required="true"></textarea>
        </p>';

    return $comment_field;
}
add_filter( 'comment_form_field_comment', 'focus_commtent_textarea' );

/**
 * Use a template for individual comment output
 *
 * @param object $comment Comment to display.
 * @param int    $depth   Depth of comment.
 * @param array  $args    An array of arguments.
 */
function focus_comment_callback( $comment, $args, $depth ) {
	include( locate_template( 'comment.php' ) );
}

/**
 * Get default footer text
 *
 * @return string $text
 */
function focus_get_default_footer_text() {
	$text = sprintf(
		__( 'Powered by %s', 'focus' ),
		'<a href="' . esc_url( __( 'http://wordpress.org/', 'focus' ) ) . '">WordPress</a>'
	);
	$text .= '<span class="sep"> | </span>';
	$text .= sprintf(
		__( '%1$s by %2$s.', 'focus' ),
			'Focus',
			'<a href="https://devpress.com/" rel="designer">DevPress</a>'
	);
	return $text;
}

/**
 * Append class "social" to specific off-site links
 *
 * @since Focus 0.2.0
 */
function focus_social_nav_class( $classes, $item ) {

    if ( 0 == $item->parent && 'custom' == $item->type) {

    	$url = parse_url( $item->url );

    	if ( !isset( $url['host'] ) ) {
	    	return $classes;
    	}

    	$base = str_replace( "www.", "", $url['host'] );

    	// @TODO Make this filterable
    	$social = array(
    		'behance.com',
    		'dribbble.com',
    		'facebook.com',
    		'flickr.com',
    		'github.com',
    		'linkedin.com',
    		'pinterest.com',
    		'plus.google.com',
    		'instagr.am',
    		'instagram.com',
    		'skype.com',
    		'spotify.com',
    		'twitter.com',
    		'vimeo.com'
    	);

    	// Tumblr needs special attention
    	if ( strpos( $base, 'tumblr' ) ) {
			$classes[] = 'social';
		}

    	if ( in_array( $base, $social ) ) {
	    	$classes[] = 'social';
    	}

    }

    return $classes;

}
add_filter( 'nav_menu_css_class', 'focus_social_nav_class', 10, 2 );

/**
 * Disable requests to wp.org repository for this theme.
 *
 * @since 1.1.0
 */
function focus_disable_wporg_request( $r, $url ) {

	// If it's not a theme update request, bail.
	if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
		return $r;
	}

	// Decode the JSON response
	$themes = json_decode( $r['body']['themes'] );

	// Remove the active parent and child themes from the check
	$parent = get_option( 'template' );
	$child = get_option( 'stylesheet' );
	unset( $themes->themes->$parent );
	unset( $themes->themes->$child );

	// Encode the updated JSON response
	$r['body']['themes'] = json_encode( $themes );

	return $r;
}
add_filter( 'http_request_args', 'focus_disable_wporg_request', 5, 2 );

/**
 * Adds a checkbox to the featured image metabox.
 *
 * @param string $content
 */

if ( get_theme_mod( 'post-featured-images', '1' ) ) {
	add_filter( 'admin_post_thumbnail_html', 'focus_featured_image_meta' );
}

function focus_featured_image_meta( $content ) {
	global $post;
	$text = __( 'Don\'t display image in post.', 'reunion' );
	$id = 'hide_featured_image';
	$value = esc_attr( get_post_meta( $post->ID, $id, true ) );
    $label = '<label for="' . $id . '" class="selectit"><input name="' . $id . '" type="checkbox" id="' . $id . '" value="' . $value . ' "'. checked( $value, 1, false) .'> ' . $text .'</label>';
    return $content .= $label;
}

/**
 * Save featured image meta data when saved
 *
 * @param int $post_id The ID of the post.
 * @param post $post the post.
 */
function focus_save_featured_image_meta( $post_id, $post, $update ) {

	$value = 0;
    if ( isset( $_REQUEST['hide_featured_image'] ) ) {
        $value = 1;
    }

	// Set meta value to either 1 or 0
    update_post_meta( $post_id, 'hide_featured_image', $value );

}
add_action( 'save_post', 'focus_save_featured_image_meta', 10, 3 );

/**
 * Logic for displaying featured image on single post
 */
function focus_display_image() {

	if ( ! has_post_thumbnail() ) {
		return false;
	}

	if ( ! get_theme_mod( 'post-featured-images', 1 ) ) {
		return false;
	}

	if ( 1 == get_post_meta( get_the_ID(), 'hide_featured_image', true ) ) {
		return false;
	}

	return true;

}