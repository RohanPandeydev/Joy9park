<?php

/**
 * The template for displaying front page
 *
 * @package WordPress
 * @subpackage SB_Infowaves
 * @since SB_Infowaves 1.0
 *
 */

get_header();

$phone_button   = jp_field('global_phone_button', array('title' => 'Call (516) 849 - 3413', 'url' => 'tel:+15168493413'), 'option');
$logo_white     = jp_img('global_logo_white', '/assets/logo-white.png', 'option');
$logo_secondary = jp_img('global_logo_secondary', '/assets/logo2.png', 'option');
$reserve_url    = jp_template_page_url('page-templates/reserver-spot.php');

?>
<!-- ============================= HERO BANNER START ============================= -->
<section class="hero-banner" style="background-image: url('<?php echo esc_url(jp_img('hero_bg_image', '/assets/bnr-bg.jpg')); ?>');">
    <div class="container">
        <div class="row align-items-center hero-row">

            <!-- Left content -->
            <div class="col-lg-6 col-xl-7 hero-left-col">
                <div class="hero-content">

                    <div class="hero-logo" data-animate="fade-up">
                        <img src="<?php echo esc_url(jp_img('banner_logo', '/assets/shuttle-glance-bg.jpg')); ?>" alt="Joy9 Park - Near JFK Long Term Parking">
                    </div>

                    <div class="hero-badge" data-animate="fade-up" data-delay="100">
                        <span class="badge-dot"></span>
                        <?php echo esc_html(jp_field('hero_badge_text', '24/7 Available &nbsp;•&nbsp; 3 Miles from JFK')); ?>
                    </div>

                    <h1 class="hero-title" data-animate="fade-up" data-delay="200">
                        <?php echo jp_field('hero_title', "24-Hour Operation\n5 to 7 Minutes to JFK Terminals\nFree JFK Shuttle Drop Off and Pickup"); ?>
                    </h1>

                    <p class="hero-text" data-animate="fade-up" data-delay="300">
                        <?php echo esc_html(jp_field('hero_text', 'Pay cash or zelle at your arrival in the parking lot.')); ?>
                    </p>

                    <div class="hero-btn-group" data-animate="fade-up" data-delay="400">
                        <a href="<?php echo esc_url($phone_button['url']); ?>" class="common-btn btn-call">
                            <i class="fa-solid fa-phone"></i> <?php echo esc_html($phone_button['title']); ?>
                        </a>
                        <?php $hero_secondary_btn = jp_field('hero_secondary_btn', array('title' => 'Get Direction', 'url' => '#directions')); ?>
                        <a href="<?php echo esc_url($hero_secondary_btn['url']); ?>" class="common-btn btn-white" <?php echo ! empty($hero_secondary_btn['target']) ? 'target="' . esc_attr($hero_secondary_btn['target']) . '"' : ''; ?>>
                            <?php echo esc_html($hero_secondary_btn['title']); ?>
                        </a>
                    </div>

                    <ul class="hero-feature-list" data-animate="fade-up" data-delay="500">
                        <?php
                        if (have_rows('hero_features')) :
                            while (have_rows('hero_features')) : the_row();
                        ?>
                                <li><i class="fa-solid fa-circle-check"></i> <?php echo esc_html(get_sub_field('text')); ?></li>
                            <?php
                            endwhile;
                        else :
                            foreach (array('Secure Facility', 'Free Shuttle', '24/7 Access') as $feature) :
                            ?>
                                <li><i class="fa-solid fa-circle-check"></i> <?php echo esc_html($feature); ?></li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>

                </div>
            </div>

            <!-- Right form -->
            <div class="col-lg-6 col-xl-5 hero-right-col">
                <div class="hero-form-wrapper" id="booking-form" data-animate="fade-left">
                    <div class="booking-form-box">
                        <h2 class="form-title"><?php echo esc_html(jp_field('hero_form_title', 'Book Your Parking Slot')); ?></h2>

                        <?php echo do_shortcode(jp_field('hero_form_shortcode_id', '[contact-form-7 id="7f8a62f" title="Book Your Parking"]')); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================= HERO BANNER END ============================= -->

<!-- ============================= SLIDER ADS START ============================= -->
<section class="slider-ads-section" data-animate="fade-up">
    <div class="owl-carousel owl-theme slider-ads">

        <?php
        $slider_ads_default = array(
            array('text' => 'Our Services 100% Satisfation Guarantee', 'is_hollow' => false),
            array('text' => 'Our Services 100% Satisfation Guarantee', 'is_hollow' => true),
            array('text' => 'Joy9 Park Free Shuttle Service', 'is_hollow' => false),
            array('text' => 'Our Services 100% Satisfation Guarantee', 'is_hollow' => true),
        );

        if (have_rows('slider_ads_items')) :
            while (have_rows('slider_ads_items')) : the_row();
                $hollow_class = get_sub_field('is_hollow') ? ' text-hollow' : '';
        ?>
                <div class="item">
                    <span class="marquee-text<?php echo esc_attr($hollow_class); ?>"><?php echo esc_html(get_sub_field('text')); ?></span>
                </div>
            <?php
            endwhile;
        else :
            foreach ($slider_ads_default as $ad) :
                $hollow_class = $ad['is_hollow'] ? ' text-hollow' : '';
            ?>
                <div class="item">
                    <span class="marquee-text<?php echo esc_attr($hollow_class); ?>"><?php echo esc_html($ad['text']); ?></span>
                </div>
        <?php
            endforeach;
        endif;
        ?>

    </div>
</section>
<!-- ============================= SLIDER ADS END ============================= -->

<!-- ============================= WHY CHOOSE US START ============================= -->
<section class="why-choose-section" id="about">
    <div class="container">

        <!-- Section heading -->
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-7">
                <div class="section-heading text-center">
                    <span class="section-eyebrow" data-animate="fade-up"><?php echo esc_html(jp_field('wcu_eyebrow', 'Why Choose Us')); ?></span>
                    <h2 class="section-main-title" data-animate="fade-up" data-delay="100">
                        <?php echo esc_html(jp_field('wcu_title', 'Your Trusted JFK Parking Partner')); ?>
                    </h2>
                    <h3 class="section-sub-title" data-animate="fade-up" data-delay="150"><?php echo esc_html(jp_field('wcu_subtitle', 'JOY9 PARK')); ?></h3>
                    <p class="section-desc" data-animate="fade-up" data-delay="200">
                        <?php echo esc_html(jp_field('wcu_description', "Experience hassle-free airport parking with our comprehensive services designed for travelers who value convenience, security, and affordability.")); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div class="row gy-4">

            <?php
            $wcu_cards_default = array(
                array('icon' => '/assets/wcu-icon1.png', 'title' => 'Easy Online Booking', 'text' => 'Reserve your parking space in just a few clicks with instant confirmation and a hassle-free booking process.'),
                array('icon' => '/assets/wcu-icon2.png', 'title' => 'Free Shuttle', 'text' => 'Complimentary shuttle service to and from all JFK terminals 24/7.'),
                array('icon' => '/assets/wcu-icon3.png', 'title' => 'Secure Parking', 'text' => 'Barrier-controlled entry with 24/7 security monitoring for your peace of mind.'),
                array('icon' => '/assets/wcu-icon4.png', 'title' => '3 Miles from JFK', 'text' => 'Conveniently located just minutes from the airport for quick transfers.'),
            );

            if (have_rows('wcu_cards')) :
                $i = 0;
                while (have_rows('wcu_cards')) : the_row();
                    $i++;
                    $icon = get_sub_field('icon');
            ?>
                    <div class="col-lg-3 col-md-6" data-animate="fade-up" data-delay="<?php echo esc_attr($i * 100); ?>">
                        <div class="choose-card">
                            <div class="choose-card-icon">
                                <img src="<?php echo esc_url($icon ? $icon : get_template_directory_uri() . '/assets/wcu-icon' . $i . '.png'); ?>" alt="<?php echo esc_attr(get_sub_field('title')); ?>">
                            </div>
                            <div class="choose-card-body">
                                <h4><?php echo esc_html(get_sub_field('title')); ?></h4>
                                <p><?php echo esc_html(get_sub_field('text')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
            else :
                foreach ($wcu_cards_default as $i => $card) :
                ?>
                    <div class="col-lg-3 col-md-6" data-animate="fade-up" data-delay="<?php echo esc_attr(($i + 1) * 100); ?>">
                        <div class="choose-card">
                            <div class="choose-card-icon">
                                <img src="<?php echo esc_url(get_template_directory_uri() . $card['icon']); ?>" alt="<?php echo esc_attr($card['title']); ?>">
                            </div>
                            <div class="choose-card-body">
                                <h4><?php echo esc_html($card['title']); ?></h4>
                                <p><?php echo esc_html($card['text']); ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>

        </div>
    </div>
</section>
<!-- ============================= WHY CHOOSE US END ============================= -->


<!-- ============================= SHUTTLE AT A GLANCE START ============================= -->
<section class="shuttle-section" style="background-image: url('<?php echo esc_url(jp_img('shuttle_bg_image', '/assets/shuttle-glance-bg.jpg')); ?>');">
    <div class="container">
        <div class="row align-items-center gy-5">

            <!-- Left content -->
            <div class="col-lg-6">
                <div class="shuttle-content">

                    <!--                     <div class="shuttle-logo" data-animate="fade-up">
                        <img src="<?php echo esc_url($logo_white); ?>" alt="Joy9 Park - Near JFK Long Term Parking">
                    </div> -->
                    <div class="shuttle-logo" data-animate="fade-up">
                        <img src="<?php echo esc_url(site_url('/wp-content/uploads/2026/08/shuttle-logo.png')); ?>" alt="Joy9 Park - Near JFK Long Term Parking">
                    </div>

                    <h2 class="shuttle-title" data-animate="fade-up" data-delay="100">
                        <?php echo esc_html(jp_field('shuttle_title', 'Free  JFK Shuttle Drop Off and Pickup')); ?>
                    </h2>

                    <p class="shuttle-subtitle" data-animate="fade-up" data-delay="200">
                        <?php echo esc_html(jp_field('shuttle_subtitle', '7 Minutes  to JFK Terminals')); ?>
                    </p>

                    <a href="<?php echo esc_url($phone_button['url']); ?>" class="common-btn btn-glass" data-animate="fade-up" data-delay="300">
                        <i class="fa-solid fa-phone"></i> <?php echo esc_html($phone_button['title']); ?>
                    </a>

                </div>
            </div>

            <!-- Right glance card -->
            <div class="col-lg-6">
                <div class="glance-card" data-animate="fade-left">

                    <h3 class="glance-title"><?php echo esc_html(jp_field('shuttle_glance_title', 'Shuttle at a Glance')); ?></h3>

                    <div class="row g-3">
                        <?php
                        $shuttle_stats_default = array(
                            array('number' => '24/7', 'label' => 'Operating Hours'),
                            array('number' => '5&ndash;10', 'label' => 'Min Wait Time'),
                            array('number' => '6', 'label' => 'Terminals Served'),
                            array('number' => '3', 'label' => 'Miles to JFK'),
                        );

                        if (have_rows('shuttle_stats')) :
                            while (have_rows('shuttle_stats')) : the_row();
                        ?>
                                <div class="col-6">
                                    <div class="glance-box">
                                        <span class="glance-number"><?php echo wp_kses_post(get_sub_field('number')); ?></span>
                                        <span class="glance-label"><?php echo esc_html(get_sub_field('label')); ?></span>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                        else :
                            foreach ($shuttle_stats_default as $stat) :
                            ?>
                                <div class="col-6">
                                    <div class="glance-box">
                                        <span class="glance-number"><?php echo wp_kses_post($stat['number']); ?></span>
                                        <span class="glance-label"><?php echo esc_html($stat['label']); ?></span>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <p class="glance-note">
                        <i class="fa-solid fa-circle-check"></i> <?php echo esc_html(jp_field('shuttle_note_text', 'Complimentary for all customers')); ?>
                    </p>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================= SHUTTLE AT A GLANCE END ============================= -->

<!-- ============================= PRICING START ============================= -->
<section id="pricing" class="pricing-section" style="background-image: url('<?php echo esc_url(jp_img('pricing_bg_image', '/assets/pricing-bg.png')); ?>');">
    <div class="container">
        <div class="row align-items-center gy-3">

            <div class="col-lg-12">
                <div class="section-heading pricing-heading text-center mb-0">
                    <span class="section-eyebrow" data-animate="fade-up"><?php echo esc_html(jp_field('pricing_eyebrow', 'Transparent Pricing')); ?></span>
                    <h2 class="section-main-title" data-animate="fade-up" data-delay="100">
                        <?php echo esc_html(jp_field('pricing_title', 'Affordable Rates, No Surprises')); ?>
                    </h2>
                    <p class="section-desc" data-animate="fade-up" data-delay="150">
                        <?php echo esc_html(jp_field('pricing_description', "Park smarter with secure airport parking at unbeatable daily rates. Our straightforward pricing means you know exactly what you'll pay.")); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Slider sits outside the container so the last card peeks at the edge -->
    <div class="pricing-slider-wrap" data-animate="fade-up" data-delay="200">
        <div class="owl-carousel owl-theme pricing-slider">

            <?php
            $pricing_cards_default = array(
                array('image' => '/assets/pricing-img1.jpg', 'vehicle_type' => 'Sedan', 'rate' => '$15 / Day'),
                array('image' => '/assets/pricing-img2.jpg', 'vehicle_type' => 'Regular SUV', 'rate' => '$17 / Day'),
                array('image' => '/assets/pricing-img3.jpg', 'vehicle_type' => 'Large SUV', 'rate' => '$21 / Day'),
                array('image' => '/assets/pricing-img4.jpg', 'vehicle_type' => 'Minivan', 'rate' => '$21 / Day'),
                array('image' => '/assets/pricing-img2.jpg', 'vehicle_type' => 'Pickup Truck', 'rate' => '$23 / Day'),
                array('image' => '/assets/pricing-img4.jpg', 'vehicle_type' => 'Minivan', 'rate' => '$21 / Day'),
            );

            if (have_rows('pricing_cards')) :
                while (have_rows('pricing_cards')) : the_row();
                    $image  = get_sub_field('image');
                    $button = get_sub_field('button');
            ?>
                    <div class="item">
                        <div class="pricing-card">
                            <div class="pricing-card-img">
                                <img src="<?php echo esc_url($image ? $image : get_template_directory_uri() . '/assets/pricing-img1.jpg'); ?>" alt="<?php echo esc_attr(get_sub_field('vehicle_type')); ?> parking rate">
                            </div>
                            <div class="pricing-card-info">
                                <h4><?php echo esc_html(get_sub_field('vehicle_type')); ?></h4>
                                <span class="pricing-rate"><?php echo esc_html(get_sub_field('rate')); ?></span>
                            </div>
                            <a href="<?php echo esc_url($button ? $button['url'] : $reserve_url); ?>" class="common-btn btn-small"><?php echo esc_html($button ? $button['title'] : 'Reserve Now'); ?></a>
                        </div>
                    </div>
                <?php
                endwhile;
            else :
                foreach ($pricing_cards_default as $card) :
                ?>
                    <div class="item">
                        <div class="pricing-card">
                            <div class="pricing-card-img">
                                <img src="<?php echo esc_url(get_template_directory_uri() . $card['image']); ?>" alt="<?php echo esc_attr($card['vehicle_type']); ?> parking rate">
                            </div>
                            <div class="pricing-card-info">
                                <h4><?php echo esc_html($card['vehicle_type']); ?></h4>
                                <span class="pricing-rate"><?php echo esc_html($card['rate']); ?></span>
                            </div>
                            <a href="<?php echo esc_url($reserve_url); ?>" class="common-btn btn-small">Reserve Now</a>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
<!-- ============================= PRICING END ============================= -->


<!-- ============================= FREE SHUTTLE SERVICE START ============================= -->
<section class="shuttle-service-section" style="background-image: url('<?php echo esc_url(jp_img('fss_bg_image', '/assets/free-shuttle-bg.jpg')); ?>');">
    <div class="container">
        <div class="row align-items-center gy-5">

            <!-- Left content -->
            <div class="col-lg-6">
                <div class="shuttle-service-content">

                    <span class="outline-badge" data-animate="fade-up"><?php echo esc_html(jp_field('fss_badge_text', 'Free Shuttle Service')); ?></span>

                    <h2 class="shuttle-service-title" data-animate="fade-up" data-delay="100">
                        <?php echo jp_field('fss_title', "Ride to the Terminal \nin Minutes"); ?>
                    </h2>

                    <p class="shuttle-service-text" data-animate="fade-up" data-delay="150">
                        <?php echo esc_html(jp_field('fss_text', "Our complimentary shuttle service runs 24/7 between our secure lot and all JFK terminals. No waiting, no hassle—just hop on and we'll have you at your terminal in minutes.")); ?>
                    </p>

                    <ul class="shuttle-service-list">
                        <?php
                        $fss_features_default = array(
                            array('title' => 'All JFK Terminals Covered', 'text' => 'We serve all 6 JFK terminals including T1, T2, T4, T5, T7 and T8'),
                            array('title' => '24/7 Availability', 'text' => "Early morning flight or late night arrival? We're always here"),
                            array('title' => 'Luggage Friendly', 'text' => 'Spacious vehicles accommodate all your luggage and travel gear'),
                        );

                        if (have_rows('fss_features')) :
                            $i = 0;
                            while (have_rows('fss_features')) : the_row();
                                $i++;
                        ?>
                                <li data-animate="fade-up" data-delay="<?php echo esc_attr(150 + $i * 50); ?>">
                                    <i class="fa-solid fa-check"></i>
                                    <div class="list-text">
                                        <h4><?php echo esc_html(get_sub_field('title')); ?></h4>
                                        <p><?php echo esc_html(get_sub_field('text')); ?></p>
                                    </div>
                                </li>
                            <?php
                            endwhile;
                        else :
                            foreach ($fss_features_default as $i => $feature) :
                            ?>
                                <li data-animate="fade-up" data-delay="<?php echo esc_attr(200 + $i * 50); ?>">
                                    <i class="fa-solid fa-check"></i>
                                    <div class="list-text">
                                        <h4><?php echo esc_html($feature['title']); ?></h4>
                                        <p><?php echo esc_html($feature['text']); ?></p>
                                    </div>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>

                    <?php $fss_learn_more_btn = jp_field('fss_learn_more_btn', array('title' => 'Learn More About Shuttle', 'url' => 'about.html')); ?>
                    <a href="<?php echo esc_url($fss_learn_more_btn['url']); ?>" class="common-btn" data-animate="fade-up" data-delay="350">
                        <?php echo esc_html($fss_learn_more_btn['title']); ?>
                    </a>

                </div>
            </div>

            <!-- Right content -->
            <div class="col-lg-6">
                <div class="shuttle-service-right text-center" data-animate="fade-left">

                    <a href="<?php echo esc_url(jp_field('fss_logo_link', 'index.html')); ?>" class="shuttle-service-logo">
                        <img src="<?php echo esc_url(jp_img('fss_logo_primary', '/assets/free-shuttle-logo1.png')); ?>" alt="Joy9 Park" class="service-logo-primary">
                        <img src="<?php echo esc_url(jp_img('fss_logo_secondary', '/assets/free-shuttle-logo2.png')); ?>" alt="Joy9 Park - Near JFK Long Term Parking" class="service-logo-secondary">
                    </a>

                    <?php $fss_book_now_btn = jp_field('fss_book_now_btn', array('title' => 'Book Now', 'url' => $reserve_url)); ?>
                    <a href="<?php echo esc_url($fss_book_now_btn['url']); ?>" class="common-btn btn-white btn-book"><?php echo esc_html($fss_book_now_btn['title']); ?></a>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================= FREE SHUTTLE SERVICE END ============================= -->

<!-- ============================= READY TO PARK START ============================= -->
<section class="ready-park-section">

    <!-- Decorative shapes -->
    <span class="shape shape-top-left"></span>
    <span class="shape shape-bottom-right"></span>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="ready-park-content text-center">

                    <h2 class="ready-park-title" data-animate="fade-up"><?php echo esc_html(jp_field('rtp_title', 'Ready to Park Stress-Free?')); ?></h2>

                    <p class="ready-park-text" data-animate="fade-up" data-delay="100">
                        <?php echo esc_html(jp_field('rtp_text', "Reserve your spot today and enjoy peace of mind knowing your car is secure while you're away. No credit card required to check availability.")); ?>
                    </p>

                    <div class="ready-park-btns" data-animate="fade-up" data-delay="200">
                        <?php $rtp_primary_btn = jp_field('rtp_primary_btn', array('title' => 'Reserve Your Spot Now', 'url' => '#booking-form')); ?>
                        <a href="<?php echo esc_url($rtp_primary_btn['url']); ?>" class="common-btn"><?php echo esc_html($rtp_primary_btn['title']); ?></a>
                        <a href="<?php echo esc_url($phone_button['url']); ?>" class="common-btn btn-outline">
                            <i class="fa-solid fa-phone"></i> <?php echo esc_html($phone_button['title']); ?>
                        </a>
                    </div>

                    <ul class="trust-list" data-animate="fade-up" data-delay="300">
                        <?php
                        $trust_icons  = array('fa-solid fa-shield-halved', 'fa-regular fa-clock', 'fa-solid fa-rotate-left');
                        $trust_default = array('Secure Booking', '24/7 Support', 'Free Cancellation');

                        if (have_rows('rtp_trust_list')) :
                            $i = 0;
                            while (have_rows('rtp_trust_list')) : the_row();
                                $icon = isset($trust_icons[$i]) ? $trust_icons[$i] : 'fa-solid fa-circle-check';
                        ?>
                                <li><i class="<?php echo esc_attr($icon); ?>"></i> <?php echo esc_html(get_sub_field('text')); ?></li>
                            <?php
                                $i++;
                            endwhile;
                        else :
                            foreach ($trust_default as $i => $text) :
                            ?>
                                <li><i class="<?php echo esc_attr($trust_icons[$i]); ?>"></i> <?php echo esc_html($text); ?></li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ============================= READY TO PARK END ============================= -->


<!-- ============================= ADS BANNER START ============================= -->
<section class="ads-bnr-section" style="background-image: url('<?php echo esc_url(jp_img('ads_bnr_bg_image', '/assets/Banner-img.jpg')); ?>');" id="ads-banners">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="ads-bnr-content text-center">

                    <!--                     <div class="ads-bnr-logo" data-animate="zoom-in">
                        <img src="<?php echo esc_url($logo_white); ?>" alt="Joy9 Park - Near JFK Long Term Parking">
                    </div> -->
                    <div class="ads-bnr-logo" data-animate="zoom-in">
                        <img src="<?php echo esc_url(site_url('/wp-content/uploads/2026/08/shuttle-logo.png')); ?>" alt="Joy9 Park - Near JFK Long Term Parking">
                    </div>

                    <h2 class="ads-bnr-title" data-animate="fade-up" data-delay="150">
                        <?php echo jp_field('ads_bnr_title', "Your Satisfaction Proves Our Credibility"); ?>
                    </h2>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ============================= ADS BANNER END ============================= -->

<!-- ============================= CONTACT SECTION START ============================= -->
<section class="contact-section" id="directions">
    <div class="container">
        <div class="row align-items-center gy-4">

            <!-- Left : Map -->
            <div class="col-lg-7">
                <div class="contact-map" data-animate="fade-right">
                    <iframe
                        src="<?php echo esc_url(jp_field('global_map_embed_url', 'https://maps.google.com/maps?q=145-25%20155th%20Street%2C%20Jamaica%2C%20NY%2011434&t=m&z=14&ie=UTF8&iwloc=B&output=embed', 'option')); ?>"
                        title="Joy9 Park location map — 145-25 155th Street, Jamaica NY 11434" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Right : Info content -->
            <div class="col-lg-5">
                <div class="contact-info">

                    <span class="section-eyebrow" data-animate="fade-up"><?php echo esc_html(jp_field('contact_eyebrow', 'Easy to Find')); ?></span>

                    <h2 class="section-title" data-animate="fade-up" data-delay="100">
                        <?php echo esc_html(jp_field('contact_title', 'Conveniently Located Near JFK')); ?>
                    </h2>

                    <p class="contact-text" data-animate="fade-up" data-delay="150">
                        <?php echo esc_html(jp_field('contact_text', 'Our facility is just 3 miles from JFK Airport, making it the perfect choice for travelers seeking quick and easy parking.')); ?>
                    </p>

                    <div class="address-card" data-animate="fade-up" data-delay="200">
                        <i class="fa-solid fa-location-dot"></i>
                        <div class="address-card-text">
                            <h3><?php echo esc_html(jp_field('contact_address_title', 'Address')); ?></h3>
                            <p><?php echo wp_kses_post(jp_field('global_address', "145-25 155TH STREET <br> JAMAICA NY &nbsp;11434", 'option')); ?></p>
                        </div>
                    </div>

                    <ul class="direction-list">
                        <?php
                        $direction_steps_default = array(
                            array('title' => 'From Belt Parkway', 'text' => 'Exit at Springfield Blvd, head north to 155th Street'),
                            array('title' => 'From Nassau Expressway', 'text' => "Turn onto 155th Street, we're on the left"),
                        );

                        if (have_rows('contact_direction_steps')) :
                            $i = 0;
                            while (have_rows('contact_direction_steps')) : the_row();
                                $i++;
                        ?>
                                <li data-animate="fade-up" data-delay="<?php echo esc_attr(200 + $i * 50); ?>">
                                    <i class="fa-solid fa-check"></i>
                                    <div class="direction-text">
                                        <h4><?php echo esc_html(get_sub_field('title')); ?></h4>
                                        <p><?php echo esc_html(get_sub_field('text')); ?></p>
                                    </div>
                                </li>
                            <?php
                            endwhile;
                        else :
                            foreach ($direction_steps_default as $i => $step) :
                            ?>
                                <li data-animate="fade-up" data-delay="<?php echo esc_attr(250 + $i * 50); ?>">
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

        </div>
    </div>

    <!-- Absolute logo -->
    <!--     <div class="contact-abs-logo">
        <img src="<?php echo esc_url($logo_secondary); ?>" alt="Joy9 Park - Near JFK Long Term Parking">
    </div> -->
    <div class="contact-abs-logo">
        <img src="<?php echo esc_url(site_url('/wp-content/uploads/2026/08/contact-logo.png')); ?>" alt="Joy9 Park - Near JFK Long Term Parking">
    </div>
</section>
<!-- ============================= CONTACT SECTION END ============================= -->


<?php get_footer(); ?>