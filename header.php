<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Focus
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'focus' ); ?></a>

	<header id="masthead" class="<?php echo focus_masthead_classes(); ?>" role="banner">

		<div class="col-width">

			<div class="site-branding">

				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php if ( get_theme_mod( 'custom_logo', 0 ) ) {
							the_custom_logo();
						} else {
							echo get_bloginfo( 'name' );
						} ?>
					</a>
				</h1>

				<?php if ( get_bloginfo( 'description' ) != '' ) : ?>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				<?php endif; ?>

			</div>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav class="primary-navigation" role="navigation">
					<div class="navigation-col-width">
						<div class="menu-toggle"><?php _e( 'Menu', 'focus' ); ?></div>
						<?php wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_class' => 'nav-menu',
							'container_class' => 'menu-container',
							'link_before' => '<span>',
							'link_after' => '</span>'
						) ); ?>
					</div>
				</nav>
			<?php endif; ?>

		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content clear">