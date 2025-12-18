/**
 * Appetiser Custom JavaScript
 * Handles various UI interactions and customizations for the Appetiser website
 */

jQuery(document).ready(function ($) {
    
    // ==========================================
    // HEADING CONVERSION (H4 to H3)
    // ==========================================
    // Convert H4 elements to H3 for better SEO structure
    document.querySelectorAll('.js-convert-to-h3 h4').forEach(h4 => {
        const h3 = document.createElement('h3');
        Array.from(h4.attributes).forEach(attr => {
            h3.setAttribute(attr.name, attr.value);
        });
        h3.innerHTML = h4.innerHTML;
        h4.replaceWith(h3);
    });

    // ==========================================
    // ACCESSIBILITY IMPROVEMENTS
    // ==========================================
    // Add ARIA labels to navigation buttons
    $('.infinite-main-menu-right .infinite-top-menu-button, .infinite-mobile-menu .infinite-mobile-menu-button')
        .attr('aria-label', 'main-navigation');

    // ==========================================
    // MODAL FUNCTIONALITY
    // ==========================================
    // Handle modal toggle and close actions
    $('.modal-toggle, .modal-close').on('click', function (e) {
        e.preventDefault();
        $('.modal').toggleClass('is-visible');
    });

    // ==========================================
    // STICKY GLOSSARY NAVIGATION
    // ==========================================
    // Make glossary index sticky on scroll
    $(window).scroll(function () {
        const sticky = $('.glossary-index');
        const scroll = $(window).scrollTop();

        if (scroll >= 350) {
            sticky.addClass('fixed-glossary');
        } else {
            sticky.removeClass('fixed-glossary');
        }
    });

    // ==========================================
    // LOGO CUSTOMIZATION
    // ==========================================
    // Update logo links and add CSS classes
    $('.infinite-logo-inner a, .infinite-logo-inner > a')
        .attr('href', '/just-build-it/')
        .addClass('site-logo-href');
    
    $('.infinite-mobile-header .infinite-logo-inner a')
        .addClass('menu-link-class');

    // ==========================================
    // HUBSPOT REVENUE HERO INTEGRATION
    // ==========================================
    // Handle HubSpot form callbacks for Revenue Hero
    window.addEventListener('message', event => {
        if (event.data.type === 'hsFormCallback' && event.data.eventName === 'onFormReady') {
            window.hero = new RevenueHero({
                routerId: '217'
            });
            hero.schedule('hsForm_ef1b27b8-c62c-422c-ad03-88eeb5b034c1');
        }

        if (event.data.type === 'hsFormCallback' && event.data.eventName === 'onFormSubmitted') {
            const formData = event.data.data.submissionValues;
            // Handle form submission data if needed
        }
    });

    // ==========================================
    // IFRAME STYLING
    // ==========================================
    // Inject custom styles into contact form iframe
    const iframe = $('.contact-ct iframe');
    iframe.on('load', function () {
        const iframeContent = iframe.contents();
        const styleTag = '<style>.hsfc-FieldLabel{display:none!important}</style>';
        iframeContent.find('head').append(styleTag);
    });

});
