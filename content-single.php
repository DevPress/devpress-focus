<?php
/**
 * @package Focus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( ); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php focus_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( focus_display_image() ) { ?>
	<figure class="entry-image">
		<?php the_post_thumbnail(); ?>
	</figure>
	<?php } ?>

	<div class="entry-content clearfix">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'focus' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer clearfix">
		<div class="entry-meta">
		<?php focus_post_meta(); ?>
		</div>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->