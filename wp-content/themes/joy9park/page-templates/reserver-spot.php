<?php

/**
 * Template Name: Reserve a Spot
 *
 * @package WordPress
 * @subpackage Joy_9_Park
 * @since Joy_9_Park 1.0
 *
 */


get_header();

get_template_part('template-parts/common-section/common', 'banner');
?>


<!-- ============================= RESERVE FORM START ============================= -->
<section class="reserve-form-section" style="background-image: url('<?php echo esc_url(jp_img('reserve_bg_image', '/assets/reserve-bg.jpg')); ?>');">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-6 m-auto">

                <div class="booking-form-box" id="booking-form" data-animate="fade-up">
                    <h2 class="form-title"><?php echo esc_html(jp_field('reserve_form_title', 'Book Your Parking Slot')); ?></h2>
                    <?php echo do_shortcode(jp_field('booking_form_shortcode', '[contact-form-7 id="7f8a62f" title="Book Your Parking"]')); ?>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- ============================= RESERVE FORM END ============================= -->


<?php get_footer(); ?>