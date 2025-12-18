<?php

//This prevents ACF from removing the default WordPress custom fields meta box when ACF is active.
acf_update_setting('remove_wp_meta_box', false);

//Adds the GDLR Core Page Builder support to a custom post type named location, but only in the admin area.
if( !function_exists('gdlr_core_custom_add_page_builder') ){
    function gdlr_core_custom_add_page_builder( $post_type ){
        $post_type[] = 'location';
        return $post_type;
    }
}
if( is_admin() ){ add_filter('gdlr_core_page_builder_post_type', 'gdlr_core_custom_add_page_builder'); }

// add page builder to products

if( !function_exists('gdlr_core_product_add_page_builder') ){
    function gdlr_core_product_add_page_builder( $post_type ){
        $post_type[] = 'career';
        return $post_type;
    }
}
if( is_admin() ){ add_filter('gdlr_core_page_builder_post_type', 'gdlr_core_product_add_page_builder'); }