<?php

/**
 * Template Name: T & C
 *
 * @package WordPress
 * @subpackage Joy_9_Park
 * @since Joy_9_Park 1.0
 *
 */


get_header();

get_template_part('template-parts/common-section/common', 'banner');

$terms_icons = array(
    'calendar' => 'fa-solid fa-calendar-check',
    'payment'  => 'fa-solid fa-credit-card',
    'shuttle'  => 'fa-solid fa-van-shuttle',
    'car'      => 'fa-solid fa-car-side',
    'rotate'   => 'fa-solid fa-rotate-left',
    'shield'   => 'fa-solid fa-shield-halved',
    'info'     => 'fa-solid fa-circle-info',
);

$reserve_spot_url = jp_template_page_url( 'page-templates/reserver-spot.php' );

$terms_phone_display = jp_field( 'terms_sidebar_phone', '+1 (516) 849-3413' );
$terms_phone_href    = 'tel:+' . preg_replace( '/\D/', '', $terms_phone_display );
$terms_email         = jp_field( 'terms_sidebar_email', 'info@joy9park.com' );
?>

<!-- ============================= TERMS CONDITION START ============================= -->
<section class="terms-condition-section">
    <span class="terms-shape terms-shape-left"></span>
    <span class="terms-shape terms-shape-right"></span>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="section-heading text-center terms-heading" data-animate="fade-up">
                    <span class="section-eyebrow"><?php echo esc_html( jp_field( 'terms_eyebrow', 'Parking Made Clear' ) ); ?></span>
                    <h2 class="section-main-title"><?php echo esc_html( jp_field( 'terms_heading', 'Simple Terms For Your Joy9 Park Reservation' ) ); ?></h2>
                    <p class="section-desc">
                        <?php echo esc_html( jp_field( 'terms_description', 'Please review these short terms before booking or parking with us.' ) ); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="terms-highlight-card" data-animate="fade-up" data-delay="100">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <span class="terms-label"><?php echo esc_html( jp_field( 'terms_highlight_label', 'Joy9 Park Terms' ) ); ?></span>
                    <h3><?php echo esc_html( jp_field( 'terms_highlight_heading', 'Reserve, arrive, shuttle and travel with confidence.' ) ); ?></h3>
                    <p>
                        <?php echo esc_html( jp_field( 'terms_highlight_text', 'By using Joy9 Park, you agree to provide accurate booking details, follow lot instructions and contact us if your travel plans change.' ) ); ?>
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo esc_url( $reserve_spot_url ); ?>" class="common-btn"><?php echo esc_html( jp_field( 'terms_highlight_button_text', 'Reserve Your Spot' ) ); ?></a>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="terms-list-card" data-animate="fade-right">
                    <?php
                    $terms_items_default = array(
                        array( 'icon' => 'calendar', 'title' => 'Booking Details', 'text' => 'Customers are responsible for entering correct contact, vehicle and travel dates.' ),
                        array( 'icon' => 'payment', 'title' => 'Payments', 'text' => 'Parking fees are due as quoted. Accepted payment options may include cash or Zelle.' ),
                        array( 'icon' => 'shuttle', 'title' => 'Shuttle Service', 'text' => 'Free shuttle service is provided for parking customers and depends on traffic, demand and airport conditions.' ),
                        array( 'icon' => 'car', 'title' => 'Vehicle Responsibility', 'text' => 'Please remove valuables and lock your vehicle. Joy9 Park is not responsible for items left inside.' ),
                        array( 'icon' => 'rotate', 'title' => 'Changes Or Cancellations', 'text' => 'Contact us as soon as possible if your arrival, return time or reservation needs to change.' ),
                    );

                    $terms_items = array();
                    if ( have_rows( 'terms_items' ) ) :
                        while ( have_rows( 'terms_items' ) ) : the_row();
                            $terms_items[] = array(
                                'icon'  => get_sub_field( 'icon' ),
                                'title' => get_sub_field( 'title' ),
                                'text'  => get_sub_field( 'text' ),
                            );
                        endwhile;
                    else :
                        $terms_items = $terms_items_default;
                    endif;

                    foreach ( $terms_items as $item ) :
                        $icon_class = $terms_icons[ $item['icon'] ] ?? 'fa-solid fa-circle-info';
                        ?>
                        <article class="terms-item">
                            <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                            <div>
                                <h3><?php echo esc_html( $item['title'] ); ?></h3>
                                <p><?php echo esc_html( $item['text'] ); ?></p>
                            </div>
                        </article>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>

            <div class="col-lg-4">
                <aside class="terms-contact-card" data-animate="fade-left" data-delay="150">
                    <div class="terms-contact-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <h3><?php echo esc_html( jp_field( 'terms_sidebar_heading', 'Need Help?' ) ); ?></h3>
                    <p><?php echo esc_html( jp_field( 'terms_sidebar_text', 'Questions about parking terms, pickup or payment? Our team is ready to help.' ) ); ?></p>
                    <a href="<?php echo esc_attr( $terms_phone_href ); ?>" class="terms-phone"><?php echo esc_html( $terms_phone_display ); ?></a>
                    <a href="mailto:<?php echo esc_attr( $terms_email ); ?>" class="terms-email"><?php echo esc_html( $terms_email ); ?></a>
                </aside>
            </div>
        </div>
    </div>
</section>
<!-- ============================= TERMS CONDITION END ============================= -->


<?php get_footer(); ?>
