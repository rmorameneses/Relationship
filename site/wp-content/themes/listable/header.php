<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Listable
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<script src="ajax.js"></script>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">





			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js">
			</script>





<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-mapbox-token="<?php echo listable_get_option('mapbox_token', ''); ?>" data-mapbox-style="<?php echo listable_get_option('mapbox_style', ''); ?>">

<<<<<<< HEAD
<?php
display_state();
?>
=======
			<?php
			display_state();
			?>

			<p>Presione actualizar para actualizar su estado a 1</p>
			<button style="color: #FF0000; background-color: #FFCC66;" type="button" id="calcularBtn">Actualizar</button>

			<script type="text/javascript">
			    jQuery("#calcularBtn").click(function(){
			    	//document.write(' <?php update_state(); ?> ');
			        var phpdivide= <?php echo update_state(1); display_state();?>
			    })
			</script>



>>>>>>> b9f97c5b4c9719317784d50d8489f9f8250f4291

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'listable' ); ?></a>

	<header id="masthead" class="site-header  <?php if( is_page_template( 'page-templates/front_page.php' ) && (listable_get_option( 'header_transparent', true ) == true) ) echo 'header--transparent'; ?>" role="banner">
		<?php
		if ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) { // display the Site Logo if present ?>
			<div class="site-branding  site-branding--image">
				<?php jetpack_the_site_logo(); ?>
			</div>
		<?php } else { ?>
			<div class="site-branding">
				<h1 class="site-title  site-title--text"><a class="site-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			</div><!-- .site-branding -->
		<?php } ?>

		<?php get_template_part( 'template-parts/header-fields' ); ?>

		<button class="menu-trigger  menu--open  js-menu-trigger">

			<?php get_template_part( 'assets/svg/menu-bars-svg' ); ?>

		</button>
		<nav id="site-navigation" class="menu-wrapper" role="navigation">
			<button class="menu-trigger  menu--close  js-menu-trigger">

				<?php get_template_part( 'assets/svg/close-icon-svg' ); ?>

			</button>

			<?php
			wp_nav_menu( array(
				'container' => false,
				'theme_location' => 'primary',
				'menu_class' => 'primary-menu',
				'walker' => new Listable_Walker_Nav_Menu(),
			) );
			wp_nav_menu( array(
				'container_class' => 'secondary-menu-wrapper',
				'theme_location' => 'secondary',
				'menu_class' => 'primary-menu secondary-menu',
				'fallback_cb' => false,
				'walker' => new Listable_Walker_Nav_Menu(),
			) ); ?>

		</nav>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
