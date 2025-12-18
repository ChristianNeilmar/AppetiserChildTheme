<?php
$filename = basename(__FILE__);

function app_enqueue_style(){
    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );

    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();

    if ( is_page() ) {
        // Enqueue global for all pages
        $global_pages = '/assets/css/global-pages.css';
        if (file_exists($theme_dir . $global_pages)) {
            wp_enqueue_style('global-pages-css', $theme_uri . $global_pages, [], null);
        }

        // Enqueue specific page ID CSS
        $page_id = get_queried_object_id();
        $page_specific = "/assets/css/pages/{$page_id}.css";
        if (file_exists($theme_dir . $page_specific)) {
            wp_enqueue_style("page-{$page_id}-css", $theme_uri . $page_specific, [], null);
        }
    }

    if ( is_single() ) {
        $post_id = get_queried_object_id();
        $post_type = get_post_type($post_id);
        
        if ( $post_type === 'post' ) {
            $global_posts = '/assets/css/global-posts.css';
            if (file_exists($theme_dir . $global_posts)) {
                wp_enqueue_style('global-posts-css', $theme_uri . $global_posts, [], null);
            }

            $post_specific = "/assets/css/post/{$post_id}.css";
            if (file_exists($theme_dir . $post_specific)) {
                wp_enqueue_style("post-{$post_id}-css", $theme_uri . $post_specific, [], null);
            }
        }

        if ( $post_type === 'portfolio' ) {
            // Load portfolio-specific CSS
            $portfolio_specific = "/assets/css/portfolio/{$post_id}.css";
            if (file_exists($theme_dir . $portfolio_specific)) {
                wp_enqueue_style("portfolio-{$post_id}-css", $theme_uri . $portfolio_specific, [], null);
            }
        }
    }    
    
    // Enqueue global CSS files
    $global_css_files = [
        'child-theme-style-css' => '/assets/css/style.css',
        'mqls-css' => '/assets/css/mqls.css',
        'contact-css' => '/assets/css/contact.css',
        'customise-css' => '/assets/css/customise.css',
        'goodlayers-miscellaneous-css' => '/assets/css/goodlayers-miscellaneous.css'
    ];

    foreach ($global_css_files as $handle => $file_path) {
        if (file_exists($theme_dir . $file_path)) {
            wp_enqueue_style($handle, $theme_uri . $file_path, [], filemtime($theme_dir . $file_path));
        }
    }
}
add_action('wp_enqueue_scripts', 'app_enqueue_style');

function app_head_snippets() {
    if (is_admin()) return;

    $snippets_base_dir = get_stylesheet_directory() . '/assets/js/';

    $global_snippet = $snippets_base_dir . 'global-snippets.html';
    if (file_exists($global_snippet)) {
        echo file_get_contents($global_snippet);
    }

    if ( is_page() ) {
        $post_id = get_queried_object_id();
        $specific_snippet = $snippets_base_dir . "pages/snippets/" . "{$post_id}.html";
        if (file_exists($specific_snippet)) {
            echo file_get_contents($specific_snippet);
        }
    }
}
add_action('wp_head', 'app_head_snippets');

function app_enqueue_scripts() {
    if (is_admin()) return;

    $theme_uri = get_stylesheet_directory_uri();
    $theme_dir = get_stylesheet_directory();

    // Always enqueue global JS
    $global_js = '/assets/js/global-js.js';
    if (file_exists($theme_dir . $global_js)) {
        wp_enqueue_script(
            'global-js',
            $theme_uri . $global_js,
            ['jquery'], 
            null,
            true 
        );
    }    

    // appetiser.js
    $appetiser_js = '/assets/js/appetiser.js';
    if ( file_exists( $theme_dir . $appetiser_js ) ) {
        wp_enqueue_script(
            'appetiser-js',
            $theme_uri . $appetiser_js,
            array('jquery'),
            filemtime( $theme_dir . $appetiser_js ),
            true
        );
    }

    // success-stories.js
    $success_stories_js = '/assets/js/success-stories.js';
    if ( file_exists( $theme_dir . $success_stories_js ) ) {
        wp_enqueue_script(
            'success-stories-js',
            $theme_uri . $success_stories_js,
            array('jquery'),
            filemtime( $theme_dir . $success_stories_js ),
            true
        );
    }

    // Enqueue per-page JS
    if (is_page()) {
        $page_id = get_queried_object_id();
        $page_js = "/assets/js/pages/{$page_id}.js";
        if (file_exists($theme_dir . $page_js)) {
            wp_enqueue_script(
                "page-{$page_id}-js",
                $theme_uri . $page_js,
                [],
                null,
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'app_enqueue_scripts');


// FROM OLD FUNCTIONS.PHP 
function my_enqueue_assets() { 
    $parent_style = 'parent-style';
    // Deployment 16/07/2025 START
    // Included Files: infinite-child/assets/css/reading-progress.css
    // Included Files: infinite-child/assets/js/reading-progress.js
    if ( is_single() && get_post_type() == 'post' ) {
        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/assets/css/reading-progress.css' );
        wp_enqueue_style( 'reading-progress',
            get_stylesheet_directory_uri() . '/assets/css/reading-progress.css',
            array( $parent_style )
        );

        wp_enqueue_script(
            'reading-progress',
            get_stylesheet_directory_uri() . '/assets/js/reading-progress.js',
            array('jquery'),
            filemtime(get_stylesheet_directory() . '/assets/js/reading-progress.js'),
            true
        );
    }

    // Included Files: infinite-child/assets/css/project-page.css
    if ( is_page(24624) ) {
        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/assets/css/project-page.css' );
        wp_enqueue_style( 'project-page',
            get_stylesheet_directory_uri() . '/assets/css/project-page.css',
            array( $parent_style )
        );
    }
    // Deployment 16/07/2025 END
    
    wp_register_script( 'mixitup-js', 'https://cdnjs.cloudflare.com/ajax/libs/mixitup/3.3.1/mixitup.min.js', array(), null, true ); 
    wp_register_script( 'isotope', '//npmcdn.com/isotope-layout@2/dist/isotope.pkgd.js', array(), null, true ); 

    wp_enqueue_script( 'mixitup-js' );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' );

// For Just Build it page
if(is_page( 18221)){
    wp_register_script( 'ScrollMagic', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js', array(), null, true ); 
    wp_enqueue_script( 'ScrollMagic' );

    wp_register_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js', array(), null, true ); 
    wp_enqueue_script( 'gsap' );

    wp_register_script( 'ScrollTrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/ScrollTrigger.min.js', array(), null, true ); 
    wp_enqueue_script( 'ScrollTrigger' );

    wp_register_script( 'TweenMax', 'https://scrollmagic.io/assets/js/lib/greensock/TweenMax.min.js', array(), null, true ); 
    wp_enqueue_script( 'TweenMax' );

    wp_register_script( 'jquery.ScrollMagic.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/jquery.ScrollMagic.min.js', array(), null, true ); 
    wp_enqueue_script( 'jquery.ScrollMagic.min.js' );
}


function page_header_script(){	
		if( get_field('page_css') ) {
			$page_css = get_field('page_css');
				echo '<style>'.$page_css.'</style>';
		}
		if( get_field('page_header_js') ) {
			$page_header_js = get_field('page_header_js');
				echo $page_header_js;
		}
		
}
add_action('wp_head', 'page_header_script');

function page_footer_script(){
	if( get_field('page_footer_js') ) {
			$page_footer_js = get_field('page_footer_js');
				echo $page_footer_js;
		}
}
add_action('wp_footer', 'page_footer_script');

// czar-flexmasonry-testimonial-fix.html into wp_footer when present.
function app_print_czar_flexmasonry_snippet() {
    if (is_admin()) return;
    $theme_dir = get_stylesheet_directory();
    $czarFlexmasonryTestimonial = $theme_dir . '/assets/js/czar-flexmasonry-testimonial-fix.html';
    if ( file_exists( $czarFlexmasonryTestimonial ) ) {
        echo file_get_contents( $czarFlexmasonryTestimonial );
    }
}
add_action( 'wp_footer', 'app_print_czar_flexmasonry_snippet', 20 );
// czar-flexmasonry-testimonial-fix.html into wp_footer when present.

function remove_block_css() {
    wp_dequeue_style( 'wp-block-library' ); // Wordpress core
    wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
    wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
}
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );

function unusedmobileremove() { 
   // Load if mobile 
   if (  wp_is_mobile() ) { 
     wp_dequeue_style( 'infinite-custom-style' );
   } 
}
#add_action( 'wp_enqueue_scripts', 'unusedmobileremove' );

function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

// enqueue google tag manager
function enqueue_gtm_script() {
    wp_enqueue_script('gtm-loader', get_stylesheet_directory_uri() . '/assets/js/gtm-loader.js', array(), null, false);
}
add_action('wp_enqueue_scripts', 'enqueue_gtm_script');

function app_add_verification_meta_tags() {
    // Google site verification
    echo '<meta name="google-site-verification" content="_ZvBrTf2PLXSzXcDFg8ANYlhzXa7-4ma5aH0oKc_nrc" />' . "\n";
    // Facebook domain verification
    echo '<meta name="facebook-domain-verification" content="js7pwh1x6ij16imqfo5bi2mvq1fsva" />' . "\n";

}

add_action('wp_head', 'app_add_verification_meta_tags');

function app_ga4_immediate_pageview() {
    ?>
    <!-- Immediate GA4 Pageview (fires before GTM) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B2QRKDJRS8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }

        gtag('js', new Date());
        gtag('config', 'G-B2QRKDJRS8', { 'send_page_view': true });
    </script>
    <?php
    }
add_action('wp_head', 'app_ga4_immediate_pageview', 0);

function app_add_wphead_scripts() {
    wp_enqueue_script('vwo-smartcode','https://dev.visualwebsiteoptimizer.com/lib/711923.js',[],null,true);
    wp_enqueue_script('hubspot-tracking','https://js.hs-scripts.com/5769657.js',[],null,true);
    ?>
    <!-- Google Tag Manager -->
    <script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
    'gtm.start': new Date().getTime(),
    event: 'gtm.js'
    });
    </script>

    <script async src="https://www.googletagmanager.com/gtm.js?id=GTM-T7V4L9L"></script>
    <!-- End Google Tag Manager -->
    <?php
}
add_action('wp_head', 'app_add_wphead_scripts', 1);


function app_add_after_body_scripts() {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T7V4L9L"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action('gdlr_core_after_body', 'app_add_after_body_scripts', 1);

