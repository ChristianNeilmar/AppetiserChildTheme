<?php
# preload_lcp_image is the hook function added to wp_head to preload the image for mobile LCP
function preload_lcp_image() {
    if ( is_front_page() || is_home() ) {

        // Desktop LCP
        echo '<link rel="preload" as="image" href="' . content_url('/uploads/2024/06/Banner-Image_Desktop.webp') . '" fetchpriority="high">' . "\n";

        // Mobile LCP
        echo '<link rel="preload" as="image" href="' . content_url('/uploads/2024/12/Banner-Image_Mobile_view.webp') . '" fetchpriority="high">' . "\n";
    }
}

add_action('wp_head', 'preload_lcp_image', 1);

function app_lcp_add_attributes() {
    if ( ! is_front_page() && ! is_home() ) {
        return;
    }

    ob_start(function($buffer) {

        // List of LCP images to modify
        $lcp_images = [
            content_url('/uploads/2024/06/Banner-Image_Desktop.webp'),
            content_url('/uploads/2024/12/Banner-Image_Mobile_view.webp')
        ];

        foreach ( $lcp_images as $lcp_src ) {

            $pattern = '/<img[^>]*src=["\']' . preg_quote($lcp_src, '/') . '["\'][^>]*>/i';

            $buffer = preg_replace_callback($pattern, function($match) {
                $img = $match[0];

                // Add decoding="async" if missing
                if (strpos($img, 'decoding=') === false) {
                    $img = str_replace('<img', '<img decoding="async"', $img);
                }

                // Add fetchpriority="high" if missing
                if (strpos($img, 'fetchpriority=') === false) {
                    $img = str_replace('<img', '<img fetchpriority="high"', $img);
                }

                return $img;
            }, $buffer);
        }

        return $buffer;
    });
}
add_action('template_redirect', 'app_lcp_add_attributes');


function stop_heartbeat() {
    wp_deregister_script('heartbeat');
}
add_action( 'init', 'stop_heartbeat', 1 );

// Function to remove version numbers
function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// Remove WP Version From Styles	
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

add_filter( 'generate_google_font_display', function() {
    return 'swap';
} );
