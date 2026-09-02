<?php

/**
 * Template Name: About
 *
 * @package WordPress
 * @subpackage Joy_9_Park
 * @since Joy_9_Park 1.0
 *
 */


get_header();

get_template_part('template-parts/common-section/common', 'banner');

$reserve_spot_url = jp_template_page_url('page-templates/reserver-spot.php');
$home_shuttle_anchor_url = home_url('/#about');
?>


<!-- ============================= ABOUT INTRO START ============================= -->
<section class="about-intro-section">
    <div class="container">
        <div class="row align-items-center gy-4">

            <div class="col-lg-6">
                <div class="about-intro-content" data-animate="fade-right">
                    <h2 class="about-heading">
                        <?php echo jp_field('about_intro_heading', "Parking Made Easy, Travel \nMade Better"); ?>
                    </h2>
                    <p>
                        <?php echo esc_html(jp_field('about_intro_text_1', "Travel is stressful enough without worrying about where to leave your car. That's why Joy9 Park exists — to give travellers a safe, affordable place to park just minutes from JFK.")); ?>
                    </p>
                    <p>
                        <?php echo esc_html(jp_field('about_intro_text_2', "Our secure parking lot in Jamaica, NY has been serving airport travellers for years with round-the-clock access, barrier-controlled entry and a free shuttle that runs to every terminal. Whether you're away for a weekend or a month, your vehicle stays protected until the moment you return.")); ?>
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="about-intro-img" data-animate="fade-left">
                    <img src="<?php echo esc_url(jp_img('about_intro_image', '/assets/about-intro.jpg')); ?>" alt="Aerial view of the Joy9 Park parking lot">
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================= ABOUT INTRO END ============================= -->


<!-- ============================= OUR FOUNDER START ============================= -->
<section class="founder-section">
    <div class="container">
        <div class="row align-items-center gy-4">

            <div class="col-lg-6">
                <div class="founder-img" data-animate="fade-right">
                    <img src="<?php echo esc_url(jp_img('founder_image', '/assets/founder-img.jpg')); ?>" alt="Joy9 Park founder">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="founder-content" data-animate="fade-left">
                    <h2 class="about-heading"><?php echo esc_html(jp_field('founder_heading', 'Our Founder')); ?></h2>
                    <h3 class="founder-name"><?php echo esc_html(jp_field('founder_name', 'Founder Name')); ?></h3>
                    <span class="founder-role"><?php echo esc_html(jp_field('founder_role', 'Founder &amp; CEO')); ?></span>
                    <p>
                        <?php echo esc_html(jp_field('founder_text', "Built on a simple idea: that airport parking should be easy, fair and genuinely secure. After years of watching travellers struggle with overpriced lots and unreliable shuttles, our founder set out to build something better — a facility where the price you are quoted is the price you pay, and where every customer is treated like a neighbour rather than a booking reference.")); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================= OUR FOUNDER END ============================= -->


<!-- ============================= WHAT WE OFFER START ============================= -->
<section class="offer-section">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-heading text-center">
                    <h2 class="section-main-title" data-animate="fade-up"><?php echo esc_html(jp_field('offer_heading', 'What We Offer')); ?></h2>
                    <p class="section-desc" data-animate="fade-up" data-delay="100">
                        <?php echo esc_html(jp_field('offer_subtext', 'Everything you need for a stress-free trip')); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="row gy-4">

            <?php
            $offer_cards_default = array(
                array('image' => '/assets/wwo-img1.jpg', 'title' => 'Secure Long Term Parking', 'text' => "Barrier-controlled entry, 24/7 monitoring and a fully fenced lot keep your vehicle safe for as long as you're away."),
                array('image' => '/assets/wwo-img2.jpg', 'title' => 'Free JFK Shuttle Service', 'text' => 'Complimentary shuttles run around the clock to and from all six JFK terminals in just 5 to 7 minutes.'),
                array('image' => '/assets/wwo-img3.jpg', 'title' => 'Affordable Daily Rates', 'text' => 'Transparent pricing from $15 a day with no hidden fees and no credit card needed to check availability.'),
                array('image' => '/assets/wwo-img4.jpg', 'title' => 'Easy Reservations', 'text' => 'Book your spot online in a few clicks, or simply call us and pay by cash or Zelle when you arrive.'),
            );

            if (have_rows('offer_cards')) :
                $i = 0;
                while (have_rows('offer_cards')) : the_row();
                    $i++;
                    $image = get_sub_field('image');
            ?>
                    <div class="col-lg-3 col-md-6" data-animate="fade-up" data-delay="<?php echo esc_attr($i * 100); ?>">
                        <div class="offer-card">
                            <div class="offer-card-img">
                                <img src="<?php echo esc_url($image ? $image : get_template_directory_uri() . '/assets/wwo-img' . $i . '.jpg'); ?>" alt="<?php echo esc_attr(get_sub_field('title')); ?>">
                            </div>
                            <div class="offer-card-body">
                                <h4><?php echo esc_html(get_sub_field('title')); ?></h4>
                                <p><?php echo esc_html(get_sub_field('text')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
            else :
                foreach ($offer_cards_default as $i => $card) :
                ?>
                    <div class="col-lg-3 col-md-6" data-animate="fade-up" data-delay="<?php echo esc_attr(($i + 1) * 100); ?>">
                        <div class="offer-card">
                            <div class="offer-card-img">
                                <img src="<?php echo esc_url(get_template_directory_uri() . $card['image']); ?>" alt="<?php echo esc_attr($card['title']); ?>">
                            </div>
                            <div class="offer-card-body">
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
<!-- ============================= WHAT WE OFFER END ============================= -->


<!-- ============================= FREE SHUTTLE SERVICE START ============================= -->
<section class="shuttle-service-section" style="background-image: url('<?php echo esc_url(jp_img('about_fss_bg_image', '/assets/free-shuttle-bg.jpg')); ?>');">
    <div class="container">
        <div class="row align-items-center gy-5">

            <!-- Left content -->
            <div class="col-lg-6">
                <div class="shuttle-service-content">

                    <span class="outline-badge" data-animate="fade-up"><?php echo esc_html(jp_field('about_fss_badge_text', 'Free Shuttle Service')); ?></span>

                    <h2 class="shuttle-service-title" data-animate="fade-up" data-delay="100">
                        <?php echo jp_field('about_fss_title', "Ride to the Terminal \nin Minutes"); ?>
                    </h2>

                    <p class="shuttle-service-text" data-animate="fade-up" data-delay="150">
                        <?php echo esc_html(jp_field('about_fss_text', "Our complimentary shuttle service runs 24/7 between our secure lot and all JFK terminals. No waiting, no hassle—just hop on and we'll have you at your terminal in minutes.")); ?>
                    </p>

                    <ul class="shuttle-service-list">
                        <?php
                        $fss_features_default = array(
                            array('title' => 'All JFK Terminals Covered', 'text' => 'We serve all 6 JFK terminals including T1, T2, T4, T5, T7 and T8'),
                            array('title' => '24/7 Availability', 'text' => "Early morning flight or late night arrival? We're always here"),
                            array('title' => 'Luggage Friendly', 'text' => 'Spacious vehicles accommodate all your luggage and travel gear'),
                        );

                        if (have_rows('about_fss_features')) :
                            $i = 0;
                            while (have_rows('about_fss_features')) : the_row();
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

                    <a href="<?php echo esc_url($home_shuttle_anchor_url); ?>" class="common-btn" data-animate="fade-up" data-delay="350">
                        <?php echo esc_html(jp_field('about_fss_learn_more_text', 'Learn More About Shuttle')); ?>
                    </a>

                </div>
            </div>

            <!-- Right content -->
            <div class="col-lg-6">
                <div class="shuttle-service-right text-center" data-animate="fade-left">

                    <a href="<?php echo esc_url(home_url('/')); ?>" class="shuttle-service-logo">
                        <img src="<?php echo esc_url(jp_img('about_fss_logo_primary', '/assets/free-shuttle-logo1.png')); ?>" alt="Joy9 Park" class="service-logo-primary">
                        <img src="<?php echo esc_url(jp_img('about_fss_logo_secondary', '/assets/free-shuttle-logo2.png')); ?>" alt="Joy9 Park - Near JFK Long Term Parking" class="service-logo-secondary">
                    </a>

                    <a href="<?php echo esc_url($reserve_spot_url); ?>" class="common-btn btn-white btn-book"><?php echo esc_html(jp_field('about_fss_book_now_text', 'Book Now')); ?></a>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================= FREE SHUTTLE SERVICE END ============================= -->


<!-- ============================= HOW IT WORKS START ============================= -->
<section class="how-works-section">
    <div class="container">
        <div class="row gy-4">

            <div class="col-lg-6">
                <div class="how-works-left">
                    <h2 class="about-heading" data-animate="fade-right"><?php echo esc_html(jp_field('how_heading', 'How It Works')); ?></h2>
                    <p data-animate="fade-right" data-delay="100">
                        <?php echo esc_html(jp_field('how_text', 'From the moment you book to the moment you drive away, the whole process takes just four simple steps. No paperwork queues, no shuttle waiting around and no surprises when you come back to collect your car.')); ?>
                    </p>
                    <div class="how-works-img" data-animate="fade-up" data-delay="200">
                        <img src="<?php echo esc_url(jp_img('how_image', '/assets/car-outline.png')); ?>" alt="">
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <ul class="how-steps">

                    <?php
                    $how_steps_default = array(
                        array('icon' => '/assets/hiw-icon1.png', 'title' => 'Step 01. Reserve', 'text' => 'Book online or call ahead to secure your parking spot for the dates you need.'),
                        array('icon' => '/assets/hiw-icon2.png', 'title' => 'Step 02. Arrive', 'text' => 'Drive straight to our lot, check in at the gate and hand over your keys.'),
                        array('icon' => '/assets/hiw-icon3.png', 'title' => 'Step 03. Shuttle', 'text' => "Hop on our free shuttle and we'll have you at your terminal in 5 to 7 minutes."),
                        array('icon' => '/assets/hiw-icon4.png', 'title' => 'Step 04. Return', 'text' => 'Call us once you land and the shuttle will collect you and bring you back to your car.'),
                    );

                    if (have_rows('how_steps')) :
                        $i = 0;
                        while (have_rows('how_steps')) : the_row();
                            $i++;
                            $icon = get_sub_field('icon');
                    ?>
                            <li class="step-item" data-animate="fade-left" data-delay="<?php echo esc_attr($i * 100); ?>">
                                <div class="step-icon">
                                    <img src="<?php echo esc_url($icon ? $icon : get_template_directory_uri() . '/assets/hiw-icon' . $i . '.png'); ?>" alt="Step <?php echo esc_attr($i); ?>">
                                </div>
                                <div class="step-text">
                                    <h4><?php echo esc_html(get_sub_field('title')); ?></h4>
                                    <p><?php echo esc_html(get_sub_field('text')); ?></p>
                                </div>
                            </li>
                        <?php
                        endwhile;
                    else :
                        foreach ($how_steps_default as $i => $step) :
                        ?>
                            <li class="step-item" data-animate="fade-left" data-delay="<?php echo esc_attr(($i + 1) * 100); ?>">
                                <div class="step-icon">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . $step['icon']); ?>" alt="Step <?php echo esc_attr($i + 1); ?>">
                                </div>
                                <div class="step-text">
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
</section>
<!-- ============================= HOW IT WORKS END ============================= -->


<!-- ============================= OUR MISSION START ============================= -->
<section class="mission-section">
    <div class="container">
        <div class="row align-items-center gy-4">

            <div class="col-lg-6">
                <div class="mission-img" data-animate="fade-right">
                    <img src="<?php echo esc_url(jp_img('mission_image', '/assets/mission-img.jpg')); ?>" alt="Joy9 Park secure parking facility">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mission-content" data-animate="fade-left">
                    <h2 class="about-heading"><?php echo esc_html(jp_field('mission_heading', 'Our Mission')); ?></h2>
                    <p>
                        <?php echo esc_html(jp_field('mission_text_1', 'To make airport parking near JFK genuinely simple — built on three things: convenience, security and honest pricing.')); ?>
                    </p>
                    <p>
                        <?php echo esc_html(jp_field('mission_text_2', "We believe travellers shouldn't have to worry about their car while they're away. That's why we invest in a secure, well-lit facility, keep our shuttle running 24/7 and quote every rate up front. No hidden charges, no long walks with luggage, and no wondering whether your vehicle will be there when you get back.")); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================= OUR MISSION END ============================= -->


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

                    <span class="section-eyebrow" data-animate="fade-up"><?php echo esc_html(jp_field('about_contact_eyebrow', 'Easy to Find')); ?></span>

                    <h2 class="section-title" data-animate="fade-up" data-delay="100">
                        <?php echo esc_html(jp_field('about_contact_title', 'Conveniently Located Near JFK')); ?>
                    </h2>

                    <p class="contact-text" data-animate="fade-up" data-delay="150">
                        <?php echo esc_html(jp_field('about_contact_text', 'Our facility is just 3 miles from JFK Airport, making it the perfect choice for travelers seeking quick and easy parking.')); ?>
                    </p>

                    <div class="address-card" data-animate="fade-up" data-delay="200">
                        <i class="fa-solid fa-location-dot"></i>
                        <div class="address-card-text">
                            <h3><?php echo esc_html(jp_field('about_contact_address_title', 'Address')); ?></h3>
                            <p><?php echo wp_kses_post(jp_field('global_address', "145-25 155TH STREET <br> JAMAICA NY &nbsp;11434", 'option')); ?></p>
                        </div>
                    </div>

                    <ul class="direction-list">
                        <?php
                        $direction_steps_default = array(
                            array('title' => 'From Belt Parkway', 'text' => 'Exit at Springfield Blvd, head north to 155th Street'),
                            array('title' => 'From Nassau Expressway', 'text' => "Turn onto 155th Street, we're on the left"),
                        );

                        if (have_rows('about_direction_steps')) :
                            $i = 0;
                            while (have_rows('about_direction_steps')) : the_row();
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
    
</section>
<!-- ============================= CONTACT SECTION END ============================= -->


<?php get_footer(); ?>