<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Joy_9_Park
 */

$header_btn = get_field('header_button', 'option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<title>
		<?php if (is_front_page() && is_home()):
			bloginfo('name');
		else:
			wp_title('');
			echo ' | ';
			bloginfo('name');
		endif; ?>
	</title>
	<!-- Fav Icon -->
	<link rel="shortcut icon" href="<?php get_site_icon_url(); ?>" type="image/x-icon">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<!-- ============================= HEADER START ============================= -->
	<header class="site-header" id="siteHeader">
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container-fluid px-0">

					<!-- Logo -->
					<a class="navbar-brand header-logo" href="<?php echo esc_url(home_url('/')); ?>">
						<?php
						$custom_logo_id = get_theme_mod('custom_logo');
						$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
						$alt_text = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);

						if (has_custom_logo()) {
							echo '<img src="' . esc_url(get_site_icon_url()) . '" class="logo-primary" alt="' . $alt_text . '">';
							echo '<img src="' . esc_url($logo[0]) . '" class="logo-secondary" alt="' . $alt_text . '">';
						} else {
							echo '<h1>' . get_bloginfo('name') . '</h1>';
						}
						?>
					</a>

					<!-- Mobile toggler -->
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
						aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
						<span class="toggler-icon"><i class="fa-solid fa-bars"></i></span>
					</button>

					<!-- Navigation -->
					<div class="collapse navbar-collapse" id="mainNavbar">
						<?php

						$args = array(
							'menu' => 'head-menu',
							'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0 main-menu',
							'menu_id' => 'header-menu',
							'container' => 'li',
							'container_class' => 'nav-item',
							// 'container_id' => '',
							'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
							// 'before' => '',
							// 'after' => '',
							// 'link_before' => '',
							// 'link_after' => '',
							'depth' => 2,
							'walker' => new wp_bootstrap_navwalker(),
							'theme_location' => 'custom-header-menu',
							// 'items_wrap' => '',
							// 'item_spacing' => 'custom-header-menu', 'preserve' or 'discard'. Default 'preserve'
						);

						wp_nav_menu($args);

						?>

						<div class="header-btn-wrap">
							<?php if (!empty($header_btn)) : ?>
								<a href="<?php echo esc_url($header_btn['url']); ?>" target="<?php echo esc_attr($header_btn['target']); ?>" class="common-btn"><?php echo esc_html($header_btn['title']); ?></a>
							<?php endif; ?>
						</div>
					</div>

				</div>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->
	<!-- ============================= HEADER END ============================= -->