<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'vnh-booking' ); ?></a>

	<header id="masthead" class="site-header">
		<nav class="navbar navbar-expand-lg fixed-top">
			<div class="container-fluid">
				<?php
					the_custom_logo();
				?>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" style="margin-left: 20px;" id="navbarSupportedContent">
					<?php
						require get_template_directory() . '/inc/custom-walker-class.php';
						wp_nav_menu(
							array(
								'container'      => false,
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'navbar-nav me-auto mb-2 mb-lg-0',
								'walker'         => new Custom_Walker_Nav_Menu()
							)
						);
					?>
				</div>
			</div>
		</nav>
</header>
