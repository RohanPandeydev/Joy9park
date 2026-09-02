<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Joy_9_Park
 */

$footer_logo1 = get_field('footer_logo_1', 'option');
$footer_logo2 = get_field('footer_logo_2', 'option');
$footer_info = get_field('footer_info', 'option');
?>

<!-- ============================= FOOTER START ============================= -->
<footer class="site-footer">
	<div class="container">
		<div class="row gy-5">

			<!-- Column 1 : Logo + about -->
			<div class="col-lg-4 col-md-6">
				<div class="footer-widget" data-animate="fade-up">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
						<?php if (!empty($footer_logo1 || $footer_logo2)) : ?>
							<img src="<?php echo esc_url($footer_logo1['url']); ?>" alt="<?php echo esc_url($footer_logo1['alt']); ?>" class="footer-logo-primary">
							<img src="<?php echo esc_url($footer_logo2['url']); ?>" alt="<?php echo esc_url($footer_logo2['alt']); ?>" class="footer-logo-secondary">
						<?php else : ?>
							<h1><?php bloginfo('name'); ?></h1>
						<?php endif; ?>
					</a>

					<p class="footer-about">
						<?php echo wp_kses_post($footer_info); ?>
					</p>

					<ul class="footer-social">
						<?php
						// Check rows exists.
						if (have_rows('social_list', 'option')):
							$i = 0;
							// Loop through rows.
							while (have_rows('social_list', 'option')):
								the_row();
								$i++;

								$social_platform = get_sub_field('social_platform');
								// print_r($social_platform);
								$social_url = get_sub_field('social_url');

								$icons = [
									'instagram' => ['label' => 'Instagram', 'icon' => 'fa-brands fa-instagram'],
									'twitter' => ['label' => 'Twitter', 'icon' => 'fa-brands fa-x-twitter'],
									'facebook' => ['label' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f'],
									'linkedin' => ['label' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in'],
									'youtube' => ['label' => 'YouTube', 'icon' => 'fa-brands fa-youtube'],
									'tiktok' => ['label' => 'TikTok', 'icon' => 'fa-brands fa-tiktok'],
									'google' => ['label' => 'Google', 'icon' => 'fa-brands fa-google'],
									'whatsapp' => ['label' => 'Whatsapp', 'icon' => 'fa-brands fa-whatsapp'],
								];

								$icon_class = $icons[$social_platform]['icon'] ?? '';
								// print_r($icon_class);
								$label = $icons[$social_platform]['label'] ?? ucfirst($social_platform);
						?>
								<li>
									<a href="<?php echo esc_url($social_url); ?>" target="_blank" aria-label="<?php echo esc_attr($label); ?>" rel="noopener noreferrer">
										<i class="<?php echo esc_attr($icon_class); ?>"></i>
									</a>
								</li>
						<?php
							// End loop.
							endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>

			<!-- Column 2 : Quick links -->
			<div class="col-lg-2 col-md-6 col-6">
				<div class="footer-widget" data-animate="fade-up" data-delay="100">
					<h3 class="footer-title">Quick Links</h3>
					<?php

					$args = array(
						'menu' => 'footer-menuOne',
						'menu_class' => 'footer-links',
						'menu_id' => 'footer-menu-one',
						'container' => 'li',
						// 'container_class' => 'nav-item',
						// 'container_id' => '',
						'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
						// 'before' => '',
						// 'after' => '',
						// 'link_before' => '',
						// 'link_after' => '',
						'depth' => 2,
						'walker' => new wp_bootstrap_navwalker(),
						'theme_location' => 'my-custom-menu',
						// 'items_wrap' => '',
						// 'item_spacing' => 'custom-header-menu', 'preserve' or 'discard'. Default 'preserve'
					);

					wp_nav_menu($args);

					?>
				</div>
			</div>

			<!-- Column 3 : Legal -->
			<div class="col-lg-3 col-md-6 col-6">
				<div class="footer-widget" data-animate="fade-up" data-delay="200">
					<h3 class="footer-title">Legal</h3>
					<?php

					$args = array(
						'menu' => 'footer-menuTwo',
						'menu_class' => 'footer-links',
						'menu_id' => 'footer-menu-two',
						'container' => 'li',
						// 'container_class' => 'nav-item',
						// 'container_id' => '',
						'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
						// 'before' => '',
						// 'after' => '',
						// 'link_before' => '',
						// 'link_after' => '',
						'depth' => 2,
						'walker' => new wp_bootstrap_navwalker(),
						'theme_location' => 'primary-custom-menu',
						// 'items_wrap' => '',
						// 'item_spacing' => 'custom-header-menu', 'preserve' or 'discard'. Default 'preserve'
					);

					wp_nav_menu($args);

					?>
				</div>
			</div>

			<!-- Column 4 : Contact -->
			<div class="col-lg-3 col-md-6">
				<div class="footer-widget" data-animate="fade-up" data-delay="300">
					<h3 class="footer-title">Contact</h3>
					<ul class="footer-contact">
						<?php
						// Check rows exists.
						if (have_rows('contact_list', 'option')):
							$i = 0;
							// Loop through rows.
							while (have_rows('contact_list', 'option')):
								the_row();
								$i++;

								// print_r($i);
								$contact_icons = get_sub_field('contact_icons');
								$contact_info = get_sub_field('contact_info');
								$trim = str_replace(' ', '', $contact_info);
								$strip = strtolower($contact_info);

								$icons = [
									'phone' => ['label' => 'Phone', 'icon' => 'fa-solid fa-phone'],
									'email' => ['label' => 'Email', 'icon' => 'fa-regular fa-envelope-open'],
									'location' => ['label' => 'Location', 'icon' => 'fa-solid fa-location-dot'],
									'worktime' => ['label' => 'Work-Time', 'icon' => 'fa-regular fa-clock']
								];

								$icon_class = $icons[$contact_icons]['icon'] ?? '';

								if (1 === $i) {
									$link = 'https://maps.app.goo.gl/ULqX3SVNY9vmEWZ67';
									$target = '_blank';
								} elseif (2 === $i) {
									$link = 'mailto:' . esc_html($strip);
									$target = '';
								} elseif (3 === $i) {
									$link = 'tel:' . esc_html($trim);
									$target = '';
								} else {
									// Do Nothing
								}

								if (str_contains($link, 'mailto')) {
									$s = 'E - ';
									$z = 'Email';
								} elseif (str_contains($link, 'tel')) {
									$s = 'P - ';
									$z = 'Phone Number';
								} elseif (str_contains($link, 'maps')) {
									$s = 'L - ';
									$z = 'Address';
								} elseif (str_contains($link, '#')) {
									$s = 'H - ';
									$z = 'Operating Hours';
								} else {
									// Do Nothing
								}
						?>
								<li>
									<span class="contact-label"><?php echo esc_html($z); ?>
										<a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
											<?php echo esc_html($contact_info); ?>
										</a>
									</span>
								</li>
						<?php
							// End loop.
							endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>

		</div>
	</div>

	<!-- Footer bottom -->
	<div class="footer-bottom">
		<div class="container">
			<div class="row align-items-center gy-2">
				<div class="col-md-6">
					<p class="copyright-text">Copyright &copy;
						<?php echo date('Y'); ?> &nbsp;
						Powered JOY9 PARK
					</p>
				</div>
				<div class="col-md-6">
					<p class="developer-text">Design &amp; Developed by AS Designs.</p>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- ============================= FOOTER END ============================= -->

<?php wp_footer(); ?>
</body>

</html>