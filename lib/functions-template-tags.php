<?php
function disable_infinite_page_title_conditionally($title) {
    if (is_page(41173)) { 
        return ''; 
    }
    return $title;
}
add_filter('infinite_page_title', 'disable_infinite_page_title_conditionally');


function add_acf_body_class($class) {
    //$field = get_field_object('header_dark', get_queried_object_id());
    	//$value = $field['value'];
    //$label = str_replace( '_', '-', $value ); //Change _ to -
    
    if( get_field('header_dark') ) {
        $label="darkmode dark-header";
	}else{
    	$label = "lightmode default-header";
	}
    
    if( get_field('footer_dark') ) {
        $label2=" darkmode_footer dark-footer";
	}else{
    	$label2	 = " lightmode_footer default-footer";
	}

    $class[] = $label.$label2;

    return $class;
}
add_filter('body_class', 'add_acf_body_class');

/* Excluding category in blog page */
function exclude_category($query) {
    if ( $query->is_home() ) {
        $query->set('cat', '-398');
    }
    return $query;
}
add_filter('pre_get_posts', 'exclude_category');

/**
 * Filter nav menu items
 *
 * @param array $atts {
 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *     @type string $title        Title attribute.
 *     @type string $target       Target attribute.
 *     @type string $rel          The rel attribute.
 *     @type string $href         The href attribute.
 *     @type string $aria_current The aria-current attribute.
 * }
 * @param WP_Post  $item  The current menu item.
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param int      $depth Depth of menu item. Used for padding.
 *
 * @see Walker_Nav_Menu
 *
 * @return array
 */
function jcdesign_label_menu_items( $atts, $item, $args, $depth ) {
    
    $empty_href   = ( ! isset( $atts[ 'href' ] ) || $atts[ 'href' ] === '#' || $atts[ 'href' ] === '' );
    $has_children = ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) );
    
    // If href is essentially empty, and the item has children,
    // add an aria label noting that this is a menu
    if ( $empty_href && $has_children ) {
        $atts[ 'aria-label' ] = strip_tags( $item->title ) . ' Menu';
    }
    
    return $atts;
}