<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Focus
 */

if ( ! function_exists( 'focus_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function focus_paging_nav() {

	global $paged;

	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	if ( $paged == 0 ) {
		$paged = 1;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'focus' ); ?></h1>
		<p class="paging-meta"><?php printf( __( 'Page %s of %s', 'focus' ), $paged, $GLOBALS['wp_query']->max_num_pages ); ?></p>
		<div class="nav-links">

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav"></span>', 'focus' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"></span> ', 'focus' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'focus_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function focus_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'focus' ); ?></h1>
		<div class="nav-links">
			<?php
				next_post_link( '<div class="nav-next">%link</div>', _x( '<span class="meta-nav"></span>', 'Next post link', 'focus' ) );
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav"></span>', 'Previous post link', 'focus' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'focus_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function focus_posted_on() {

	// Check if post meta should be displayed
	if ( ! get_theme_mod( 'display-post-meta', 1 ) ) {
		return;
	}

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted %s', 'post date', 'focus' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'focus' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'focus_post_meta' ) ) :
/**
 * Prints post meta information for categories and tags.
 */
function focus_post_meta( $taxonomies = array( 'category', 'post_tag' ) ) {

	if ( ! post_password_required() && comments_open() ) :
		echo '<span class="comments-meta meta-group">';
		comments_popup_link( __( 'Comment', 'focus' ), __( '1 Comment', 'focus' ), __( '% Comments', 'focus' ) );
		echo '</span>';
	endif;

	$category_list = get_the_category_list( __( ', ', 'focus' ) );
	if ( $category_list ) {
		echo '<span class="category-meta meta-group">';
		echo '<span class="category-meta-list">' . $category_list . '</span>';
		echo '</span>';
	}

	$tag_list = get_the_tag_list( '', __( ', ', 'focus' ) );
	if ( $tag_list ) {
		echo '<span class="tag-meta meta-group">';
		echo '<span class="tag-meta-list">' . $tag_list . '</span>';
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'focus' ), '<span class="edit-meta meta-group"><span class="edit-link">', '</span></span></span>' );

}
endif;
