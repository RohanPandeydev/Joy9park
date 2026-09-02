/* ==========================================================================
   Joy9 Park — Custom Scripts
   1. Sticky header on scroll
   2. Scroll reveal animations
   3. Date field placeholder handling
   4. Mobile menu auto-close
   5. Owl Carousel init (pricing + testimonials)
   6. Footer copyright year
   7. Scroll down arrow
   8. Why Choose Us card highlight
   ========================================================================== */

(function () {
    'use strict';

    /* ======================================================================
       1. STICKY HEADER ON SCROLL
       ====================================================================== */
    var header = document.getElementById('siteHeader');
    var stickyOffset = 120; // pixels scrolled before the header sticks
    var spacer = null;

    function createSpacer() {
        if (spacer) return spacer;
        spacer = document.createElement('div');
        spacer.className = 'header-spacer';
        header.parentNode.insertBefore(spacer, header.nextSibling);
        return spacer;
    }

    function handleStickyHeader() {
        if (!header) return;

        if (window.pageYOffset > stickyOffset) {
            if (!header.classList.contains('is-sticky')) {
                var el = createSpacer();
                header.classList.add('is-sticky');
                // measured after the class lands so the compact height is used
                el.style.height = header.offsetHeight + 'px';
            }
        } else if (header.classList.contains('is-sticky')) {
            header.classList.remove('is-sticky');
            if (spacer) spacer.style.height = '0px';
        }
    }

    /* ======================================================================
       2. SCROLL REVEAL ANIMATIONS
       ====================================================================== */
    function initScrollAnimations() {
        var items = document.querySelectorAll('[data-animate]');
        if (!items.length) return;

        // Graceful fallback for very old browsers
        if (!('IntersectionObserver' in window)) {
            items.forEach(function (el) {
                el.classList.add('is-animated');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;

                var el = entry.target;
                var delay = parseInt(el.getAttribute('data-delay'), 10) || 0;

                setTimeout(function () {
                    el.classList.add('is-animated');
                }, delay);

                obs.unobserve(el);
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -60px 0px'
        });

        items.forEach(function (el) {
            observer.observe(el);
        });
    }

    /* ======================================================================
       3. DATE FIELDS — keep the placeholder until the field is used
       ====================================================================== */
//     function initDateFields() {
//         var dateFields = document.querySelectorAll('.date-field');

//         dateFields.forEach(function (field) {
//             field.addEventListener('focus', function () {
//                 this.type = 'date';
//                 if (typeof this.showPicker === 'function') {
//                     try { this.showPicker(); } catch (e) { /* not supported */ }
//                 }
//             });

//             field.addEventListener('blur', function () {
//                 if (!this.value) {
//                     this.type = 'text';
//                 }
//             });
//         });
//     }

function initDateFields() {
    var fields = document.querySelectorAll('.date-field');

    fields.forEach(function (field) {
        field.addEventListener('focus', function () {
            var el = this;
            if (el.type === 'datetime-local') return;

            el.type = 'datetime-local';

            setTimeout(function () {
                el.focus();
                if (typeof el.showPicker === 'function') {
                    try { el.showPicker(); } catch (e) {}
                }
            }, 0);
        });

        field.addEventListener('blur', function () {
            if (!this.value) {
                this.type = 'text';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', initDateFields);

    /* ======================================================================
       4. MOBILE MENU — close after a link is tapped
       ====================================================================== */
    function initMenuAutoClose() {
        var navbar = document.getElementById('mainNavbar');
        if (!navbar) return;

        navbar.querySelectorAll('.nav-link, .header-btn-wrap a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 992 && navbar.classList.contains('show')) {
                    var collapse = bootstrap.Collapse.getInstance(navbar) || new bootstrap.Collapse(navbar, { toggle: false });
                    collapse.hide();
                }
            });
        });
    }

    /* ======================================================================
       5. OWL CAROUSEL INIT
       ====================================================================== */
    function initCarousels() {
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.owlCarousel === 'undefined') {
            console.warn('Joy9 Park: jQuery or Owl Carousel did not load — sliders are disabled.');
            return;
        }

        /* --- Testimonials --- */
        jQuery('.testimonial-slider').owlCarousel({
            loop: true,
            margin: 24,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 700,
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                1200: { items: 3 }
            }
        });

        /* --- Pricing slider --- */
        var $pricing = jQuery('.pricing-slider');

        if ($pricing.length) {
            $pricing.owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                smartSpeed: 700,
                navText: [
                    '<i class="fa-solid fa-arrow-left-long"></i>',
                    '<i class="fa-solid fa-arrow-right-long"></i>'
                ],
                // fractional item counts leave the next card partly visible
                responsive: {
                    0: { items: 1.2, margin: 14 },
                    480: { items: 1.6, margin: 16 },
                    768: { items: 2.4 },
                    992: { items: 3.3 },
                    1200: { items: 4.3 }
                }
            });
        }
    }



    /* ======================================================================
       INIT
       ====================================================================== */
    document.addEventListener('DOMContentLoaded', function () {
        handleStickyHeader();
        initScrollAnimations();
        initDateFields();
        initMenuAutoClose();
        initCarousels();
        initCurrentYear();
        initScrollDownArrow();
        initChooseCards();
    });

    var ticking = false;
    window.addEventListener('scroll', function () {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(function () {
            handleStickyHeader();
            ticking = false;
        });
    }, { passive: true });

    window.addEventListener('resize', function () {
        if (header && header.classList.contains('is-sticky') && spacer) {
            spacer.style.height = header.offsetHeight + 'px';
        }
    });

})();


/* --- Slider ads (continuous marquee) --- */
/* --- Slider ads (continuous marquee) --- */
var $marquee = jQuery('.slider-ads');

if ($marquee.length) {
    $marquee.owlCarousel({
        loop: true,
        autoWidth: true,
        margin: 30,
        nav: false,
        dots: false,
        mouseDrag: false,
        touchDrag: false,
        pullDrag: false,
        autoplay: true,
        autoplayTimeout: 5000,      // must match autoplaySpeed, never 0
        autoplaySpeed: 5000,        // one slide takes exactly one interval
        smartSpeed: 5000,
        slideTransition: 'linear',  // removes the ease in/out pulse
        autoplayHoverPause: false
    });
}

/* --- Testimonials --- */
jQuery('.testimonial-slider').owlCarousel({
    loop: true,
    margin: 20,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    smartSpeed: 700,
    responsive: {
        0: { items: 1.15, margin: 14 },
        576: { items: 1.6, margin: 16 },
        768: { items: 2.2 },
        992: { items: 2.6 },
        1200: { items: 2.6 }
    }
});