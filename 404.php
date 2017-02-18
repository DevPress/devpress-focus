<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Focus
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Page can&rsquo;t be found.', 'focus' ); ?></h1>
				</header><!-- .page-header -->

				<div class="col-width">
					<div class="page-content">

						<div class="entry-content">

							<p><?php _e( 'Nothing was found at this location. Visit the home page or try a search?', 'focus' ); ?></p>

							<?php get_search_form(); ?>

						</div>

					</div><!-- .page-content -->
				</div>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
