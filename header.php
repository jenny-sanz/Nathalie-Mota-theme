<?php


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index, follow">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<!-- coder mon header -->
	<header>
		<nav id="site-navigation" class="site__navigation " role="navigation">
			<div class="logo">
				<a href="<?php echo home_url('/'); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo/logo.png" alt="Logo">
				</a>
			</div>

			<!-- menu mobile -->
			<div class="menu-burger">
				<span class="bar"></span>
				<span class="bar"></span>
				<span class="bar"></span>
			</div>

			<div class="navigation">
				<?php
				/* affichage du menu récupéré dans wordpress */
				wp_nav_menu(
					array(
						'theme_location' => 'main',
						'container' => '', // afin d'éviter d'avoir une div autour 
						'menu_class' => 'navigation--menu', // ma classe personnalisée 
					)
				);
				?>
			</div>
		</nav>
	</header>

	
