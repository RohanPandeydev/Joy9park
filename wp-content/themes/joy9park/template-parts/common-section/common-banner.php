<?php

/**
 * Template part for displaying common banner section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Sellyourteststrips
 */

$thumbnail_id = get_post_thumbnail_id();
$size = 'full';
$banner_img = wp_get_attachment_image_url($thumbnail_id, $size);
$banner_img_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
$title = get_the_title();
?>

<!-- ============================= INNER BANNER START ============================= -->
<section class="inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="inner-banner-title text-center" data-animate="fade-up"><?php echo esc_html($title); ?></h1>
            </div>
        </div>
    </div>
</section>
<!-- ============================= INNER BANNER END ============================= -->