<?php
/**
 * @package Focus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	if ( has_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'focus-archive', true );
		$image = $image[0];
		$class = "image-thumbnail";
	} else {
		$format = get_post_format();
		$image = get_template_directory_uri() . '/images/svg/post.svg';
		$formats = array( 'audio', 'gallery', 'image', 'link', 'video' );
		if ( in_array( $format, $formats ) ) {
			$image = get_template_directory_uri() . '/images/svg/' . $format . '.svg';
		}
		$class = 'fallback-thumbnail';
	}
	if ( post_password_required() ) {
		$image = get_template_directory_uri() . '/images/svg/lock.svg';
		$class = 'password-thumbnail';
	}
	?>

	<a href="<?php the_permalink(); ?>">
		<figure class="entry-image <?php echo $class; ?>">
			<img src="<?php echo $image; ?>" style="width:560px;">
		</figure>
		<?php the_title( '<div class="entry-title">', '</div>' ); ?>
	</a>

</article><!-- #post-## -->
