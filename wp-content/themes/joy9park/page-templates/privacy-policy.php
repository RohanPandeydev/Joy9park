<?php

/**
 * Template Name: Privacy Policy
 *
 * @package WordPress
 * @subpackage Joy_9_Park
 * @since Joy_9_Park 1.0
 *
 */


get_header();

get_template_part('template-parts/common-section/common', 'banner');

$privacy_icons = array(
    'shield'   => 'fa-solid fa-shield-halved',
    'phone'    => 'fa-solid fa-phone-volume',
    'envelope' => 'fa-solid fa-envelope-open-text',
    'clock'    => 'fa-regular fa-clock',
    'lock'     => 'fa-solid fa-lock',
    'location' => 'fa-solid fa-location-dot',
);

$reserve_spot_url = jp_template_page_url( 'page-templates/reserver-spot.php' );

$privacy_phone_display = jp_field( 'privacy_contact_phone', '+1 (516) 849-3413' );
$privacy_phone_href    = 'tel:+' . preg_replace( '/\D/', '', $privacy_phone_display );
?>


<!-- ============================= PRIVACY POLICY START ============================= -->
<section class="privacy-policy-section">
    <span class="privacy-shape privacy-shape-left"></span>
    <span class="privacy-shape privacy-shape-right"></span>

    <div class="container">

        <div class="privacy-overview-card" data-animate="fade-up" data-delay="100">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7">
                    <div class="privacy-overview-content">
                        <span class="privacy-label"><?php echo esc_html( jp_field( 'privacy_label', 'Joy9 Park Privacy Policy' ) ); ?></span>
                        <h3><?php echo esc_html( jp_field( 'privacy_heading', 'Clear, simple and built around your trip.' ) ); ?></h3>
                        <p>
                            <?php echo esc_html( jp_field( 'privacy_intro_text', 'We only ask for details that help us manage your parking reservation, communicate with you about shuttle service and improve your customer experience.' ) ); ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="privacy-overview-meta">
                        <?php
                        $privacy_meta_default = array(
                            array( 'icon' => 'shield', 'title' => 'Protected Booking Details', 'text' => 'Used to confirm and support your reservation.' ),
                            array( 'icon' => 'phone', 'title' => 'Easy Contact', 'text' => 'Reach us anytime at info@joy9park.com.' ),
                        );

                        if ( have_rows( 'privacy_meta_items' ) ) :
                            while ( have_rows( 'privacy_meta_items' ) ) : the_row();
                                $icon_class = $privacy_icons[ get_sub_field( 'icon' ) ] ?? 'fa-solid fa-shield-halved';
                                ?>
                                <div class="privacy-meta-item">
                                    <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                                    <div>
                                        <span><?php echo esc_html( get_sub_field( 'title' ) ); ?></span>
                                        <p><?php echo esc_html( get_sub_field( 'text' ) ); ?></p>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                        else :
                            foreach ( $privacy_meta_default as $item ) :
                                ?>
                                <div class="privacy-meta-item">
                                    <i class="<?php echo esc_attr( $privacy_icons[ $item['icon'] ] ); ?>"></i>
                                    <div>
                                        <span><?php echo esc_html( $item['title'] ); ?></span>
                                        <p><?php echo esc_html( $item['text'] ); ?></p>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="privacy-content-card" data-animate="fade-right">
                    <?php
                    $privacy_sections_default = array(
                        array( 'heading' => '1. Information We Collect', 'text' => 'When you reserve a parking spot, call us, email us or submit a form, we may collect your name, phone number, email address, vehicle make or model, plate number, parking dates, flight details and any message you choose to provide.' ),
                        array( 'heading' => '2. How We Use Your Information', 'text' => 'We use your information to confirm reservations, support check-in and pickup, provide shuttle coordination, answer customer service requests, improve our website and keep accurate business records.' ),
                        array( 'heading' => '3. Sharing Your Information', 'text' => 'We do not sell your personal information. We may share limited information with trusted service providers when needed to operate the website, process communications or comply with legal obligations.' ),
                        array( 'heading' => '4. Cookies And Website Data', 'text' => 'Our website may use cookies or similar tools to understand basic site activity, improve performance and make your browsing experience smoother. You can control cookies through your browser settings.' ),
                        array( 'heading' => '5. Data Security', 'text' => 'We use reasonable administrative and technical measures to help protect your information. No online system is completely secure, but we work to keep customer data handled carefully and responsibly.' ),
                        array( 'heading' => '6. Your Choices', 'text' => 'You may contact us to request an update, correction or deletion of your personal information, subject to any records we are required to keep for business or legal reasons.' ),
                        array( 'heading' => '7. Policy Updates', 'text' => 'We may update this privacy policy from time to time. Any changes will be posted on this page so you can review how we handle your information.' ),
                    );

                    $privacy_sections = array();
                    if ( have_rows( 'privacy_sections' ) ) :
                        while ( have_rows( 'privacy_sections' ) ) : the_row();
                            $privacy_sections[] = array(
                                'heading' => get_sub_field( 'heading' ),
                                'text'    => get_sub_field( 'text' ),
                            );
                        endwhile;
                    else :
                        $privacy_sections = $privacy_sections_default;
                    endif;

                    foreach ( $privacy_sections as $section ) :
                        ?>
                        <article class="privacy-policy-block">
                            <h3><?php echo esc_html( $section['heading'] ); ?></h3>
                            <p>
                                <?php echo esc_html( $section['text'] ); ?>
                            </p>
                        </article>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>

            <div class="col-lg-4">
                <aside class="privacy-contact-card" data-animate="fade-left" data-delay="150">
                    <div class="privacy-contact-icon">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <h3><?php echo esc_html( jp_field( 'privacy_sidebar_heading', 'Questions About Privacy?' ) ); ?></h3>
                    <p>
                        <?php echo esc_html( jp_field( 'privacy_sidebar_text', 'Our team can help with privacy questions, reservation details or account information requests.' ) ); ?>
                    </p>
                    <ul>
                        <li>
                            <span>Email</span>
                            <?php $privacy_email = jp_field( 'privacy_contact_email', 'info@joy9park.com' ); ?>
                            <a href="mailto:<?php echo esc_attr( $privacy_email ); ?>"><?php echo esc_html( $privacy_email ); ?></a>
                        </li>
                        <li>
                            <span>Phone</span>
                            <a href="<?php echo esc_attr( $privacy_phone_href ); ?>"><?php echo esc_html( $privacy_phone_display ); ?></a>
                        </li>
                        <li>
                            <span>Address</span>
                            <p><?php echo wp_kses_post( jp_field( 'global_address', '145-25 155TH STREET JAMAICA NY 11434', 'option' ) ); ?></p>
                        </li>
                    </ul>
                    <a href="<?php echo esc_url( $reserve_spot_url ); ?>" class="common-btn btn-white"><?php echo esc_html( jp_field( 'privacy_sidebar_button_text', 'Reserve Your Spot' ) ); ?></a>
                </aside>
            </div>
        </div>
    </div>
</section>
<!-- ============================= PRIVACY POLICY END ============================= -->


<?php get_footer(); ?>
