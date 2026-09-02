<?php

/**
 * Template Name: Testimonial List
 *
 * @package WordPress
 * @subpackage Joy_9_Park
 * @since Joy_9_Park 1.0
 *
 */


get_header();
?>

<!-- ============================= TESTIMONIAL START ============================= -->
<section class="testimonial-list-section">
    <div class="container">
        <div class="row g-3">

            <?php
            $testimonial_list_default = array(
                array( 'name' => 'Sarah Johnson', 'location' => 'Brooklyn, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Michael Davis', 'location' => 'Queens, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Emily Wilson', 'location' => 'Long Island, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'David Martinez', 'location' => 'Bronx, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Jessica Brown', 'location' => 'Manhattan, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Robert Kim', 'location' => 'Staten Island, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Amanda Lee', 'location' => 'Jamaica, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
                array( 'name' => 'Chris Thompson', 'location' => 'Astoria, NY', 'rating' => 5, 'text' => "The team delivered an excellent website with a modern design and smooth user experience. Communication was clear and the results exceeded our expectations." ),
            );

            if ( have_rows( 'testimonial_list_items' ) ) :
                while ( have_rows( 'testimonial_list_items' ) ) : the_row();
                    $photo  = get_sub_field( 'photo' );
                    $rating = (int) get_sub_field( 'rating' );
                    $name   = get_sub_field( 'name' );
                    ?>
                    <div class="col-lg-6">
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
                foreach ( $testimonial_list_default as $t ) :
                    ?>
                    <div class="col-lg-6">
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
</section>
<!-- ============================= TESTIMONIAL END ============================= -->


<?php get_footer(); ?>
