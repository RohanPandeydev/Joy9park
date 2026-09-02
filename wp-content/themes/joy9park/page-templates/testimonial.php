<?php

/**
 * Template Name: Testimonials
 *
 * @package WordPress
 * @subpackage Joy_9_Park
 * @since Joy_9_Park 1.0
 *
 */


get_header();

get_template_part('template-parts/common-section/common', 'banner');

$testimonial_list_url = jp_template_page_url( 'page-templates/testimonial-list.php' );
?>


<!-- ============================= TESTIMONIAL START ============================= -->
<section class="testimonial-section">
    <div class="container-fluid" data-animate="fade-up">
        <div class="owl-carousel owl-theme testimonial-slider">

            <?php
            $testimonials_default = array(
                array( 'name' => 'Sarah Johnson', 'location' => 'Brooklyn, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Michael Davis', 'location' => 'Queens, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Emily Wilson', 'location' => 'Long Island, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'David Martinez', 'location' => 'Bronx, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Jessica Brown', 'location' => 'Manhattan, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
            );

            if ( have_rows( 'testimonials' ) ) :
                while ( have_rows( 'testimonials' ) ) : the_row();
                    $photo  = get_sub_field( 'photo' );
                    $rating = (int) get_sub_field( 'rating' );
                    $name   = get_sub_field( 'name' );
                    ?>
                    <div class="item">
                        <div class="testimonial-card">
                            <div class="testimonial-rating">
                                <?php for ( $s = 0; $s < max( 1, $rating ); $s++ ) : ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="testimonial-text">
                                <?php echo esc_html( get_sub_field( 'text' ) ); ?>
                            </p>
                            <div class="testimonial-author">
                                <div class="author-info">
                                    <h4><?php echo esc_html( $name ); ?></h4>
                                    <span><?php echo esc_html( get_sub_field( 'location' ) ); ?></span>
                                </div>
                                <div class="author-img">
                                    <img src="<?php echo esc_url( $photo ? $photo : get_template_directory_uri() . '/assets/testi-img.png' ); ?>" alt="<?php echo esc_attr( $name ); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
            else :
                foreach ( $testimonials_default as $t ) :
                    ?>
                    <div class="item">
                        <div class="testimonial-card">
                            <div class="testimonial-rating">
                                <?php for ( $s = 0; $s < $t['rating']; $s++ ) : ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="testimonial-text">
                                <?php echo esc_html( $t['text'] ); ?>
                            </p>
                            <div class="testimonial-author">
                                <div class="author-info">
                                    <h4><?php echo esc_html( $t['name'] ); ?></h4>
                                    <span><?php echo esc_html( $t['location'] ); ?></span>
                                </div>
                                <div class="author-img">
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/testi-img.png' ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <a href="<?php echo esc_url( $testimonial_list_url ); ?>" class="common-btn btn-outline btn-show-more" data-animate="fade-up"><?php echo esc_html( jp_field( 'testimonials_show_more_text', 'Show More' ) ); ?></a>
            </div>
        </div>
    </div>
</section>
<!-- ============================= TESTIMONIAL END ============================= -->


<!-- ============================= FAQ START ============================= -->
<section class="faq-section" id="faq">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="faq-main-title text-center" data-animate="fade-up"><?php echo esc_html( jp_field( 'faq_heading', 'Frequently Asked Questions' ) ); ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 col-xl-8 m-auto">
                <div class="faq-wrapper" data-animate="fade-up" data-delay="100">

                    <div class="accordion" id="faqAccordion">

                        <?php
                        $faq_items_default = array(
                            array( 'question' => 'How do I book a parking spot?', 'answer' => 'You can reserve your parking space online by selecting your parking dates, entering your details, and completing the booking process.' ),
                            array( 'question' => 'Is the shuttle service to JFK Airport free?', 'answer' => 'Yes. Our shuttle service is completely complimentary for all customers and runs 24/7 between our lot and every JFK terminal.' ),
                            array( 'question' => 'How early should I arrive at the parking facility?', 'answer' => 'We recommend arriving at least 30 minutes before you need to be at the terminal. The shuttle ride takes only 5 to 7 minutes.' ),
                            array( 'question' => "Is my car safe while I'm traveling?", 'answer' => 'Absolutely. Our lot is barrier-controlled with 24/7 security monitoring, so your vehicle stays secure for the whole trip.' ),
                            array( 'question' => 'How do I get picked up after returning from JFK?', 'answer' => 'Simply call us once you have collected your luggage and our shuttle will meet you at the terminal pickup area within minutes.' ),
                        );

                        $faq_rows = array();
                        if ( have_rows( 'faq_items' ) ) :
                            while ( have_rows( 'faq_items' ) ) : the_row();
                                $faq_rows[] = array(
                                    'question' => get_sub_field( 'question' ),
                                    'answer'   => get_sub_field( 'answer' ),
                                );
                            endwhile;
                        else :
                            $faq_rows = $faq_items_default;
                        endif;

                        $i = 0;
                        foreach ( $faq_rows as $faq ) :
                            $i++;
                            $is_first    = 1 === $i;
                            $heading_id  = 'faqHeading' . $i;
                            $collapse_id = 'faqCollapse' . $i;
                            ?>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
                                    <button class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
                                        aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
                                        <?php echo esc_html( $faq['question'] ); ?>
                                    </button>
                                </h3>
                                <div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>"
                                    aria-labelledby="<?php echo esc_attr( $heading_id ); ?>" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <?php echo esc_html( $faq['answer'] ); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ============================= FAQ END ============================= -->


<?php get_footer(); ?>
