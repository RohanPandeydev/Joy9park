<?php

/**
 * Template Name: Direction
 *
 * @package WordPress
 * @subpackage Joy_9_Park
 * @since Joy_9_Park 1.0
 *
 */


get_header();

get_template_part('template-parts/common-section/common', 'banner');
?>


<!-- ============================= DIRECTION CONTACT START ============================= -->
<section class="direction-contact-section">
    <div class="container">
        <div class="row gy-4">

            <!-- Left : Info card -->
            <div class="col-lg-6">
                <div class="direction-info-card" data-animate="fade-right">
                    <span class="section-eyebrow">
                        <?php echo esc_html(jp_field('direction_eyebrow', 'Easy to Find')); ?>
                    </span>
                    <h2 class="section-title">
                        <?php echo esc_html(jp_field('direction_title', 'Conveniently Located Near JFK')); ?>
                    </h2>
                    <p class="contact-text">
                        <?php echo esc_html(jp_field('direction_text', 'Our facility is just 3 miles from JFK Airport, making it the perfect choice for travelers seeking quick and easy parking.')); ?>
                    </p>
                    <div class="address-card">
                        <i class="fa-solid fa-location-dot"></i>
                        <div class="address-card-text">
                            <h3><?php echo esc_html(jp_field('direction_address_title', 'Address')); ?></h3>
                            <p><?php echo wp_kses_post(jp_field('global_address', "145-25 155TH STREET <br> JAMAICA NY &nbsp;11434", 'option')); ?></p>
                        </div>
                    </div>

                    <ul class="direction-list">
                        <?php
                        $direction_steps_default = array(
                            array('title' => 'From Belt Parkway', 'text' => 'Exit at Springfield Blvd, head north to 155th Street'),
                            array('title' => 'From Nassau Expressway', 'text' => "Turn onto 155th Street, we're on the left"),
                        );

                        if (have_rows('direction_steps')) :
                            while (have_rows('direction_steps')) : the_row();
                        ?>
                                <li>
                                    <i class="fa-solid fa-check"></i>
                                    <div class="direction-text">
                                        <h4><?php echo esc_html(get_sub_field('title')); ?></h4>
                                        <p><?php echo esc_html(get_sub_field('text')); ?></p>
                                    </div>
                                </li>
                            <?php
                            endwhile;
                        else :
                            foreach ($direction_steps_default as $step) :
                            ?>
                                <li>
                                    <i class="fa-solid fa-check"></i>
                                    <div class="direction-text">
                                        <h4><?php echo esc_html($step['title']); ?></h4>
                                        <p><?php echo esc_html($step['text']); ?></p>
                                    </div>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>

                </div>
            </div>

            <!-- Right : Contact form -->
            <div class="col-lg-6">
                <div class="contact-us-box" data-animate="fade-left">
                    <h2 class="form-title"><?php echo esc_html(jp_field('direction_form_title', 'Contact Us')); ?></h2>
                    <?php echo do_shortcode(jp_field('contact_form_shortcode', '[contact-form-7 id="7f8a62f" title="Book Your Parking"]')); ?>
                </div>
            </div>

        </div>
    </div>

    <!-- Full width map : sits outside the container on purpose -->
    <div class="direction-full-map" data-animate="fade-up">
        <iframe
            src="<?php echo esc_url(jp_field('direction_map_embed_url', 'https://maps.google.com/maps?q=145-25%20155th%20Street%2C%20Jamaica%2C%20NY%2011434&t=m&z=15&ie=UTF8&iwloc=B&output=embed')); ?>"
            title="Joy9 Park location map — 145-25 155th Street, Jamaica NY 11434" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>
<!-- ============================= DIRECTION CONTACT END ============================= -->


<?php get_footer(); ?>