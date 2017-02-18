<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Focus
 */
?>
	</div><!-- #content -->

</div><!-- #page -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="col-width">
		<?php if ( get_theme_mod( 'footer-text', customizer_library_get_default( 'footer-text' ) ) != '' ) : ?>
		<div class="site-info">
			<?php echo get_theme_mod( 'footer-text', customizer_library_get_default( 'footer-text' ) ); ?>
		</div><!-- .site-info -->
		<?php endif; ?>
	</div><!-- .col-width -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
