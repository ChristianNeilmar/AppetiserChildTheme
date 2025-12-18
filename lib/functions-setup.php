<?php

function dev_setup(){
    $base = get_stylesheet_directory(); // child theme root

    include $base . '/assets/hooks.php';
    include $base . '/assets/controller.php';
    include $base . '/assets/shortcodes.php';
}
add_action( 'after_setup_theme', 'dev_setup' ); 

if ( function_exists('register_sidebar') ) {
    $sidebar1 = array(
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',        
        'name'=>__( 'Agritech Success Story', 'agritech' ),  'id'=> 'agritech'
    );  
    register_sidebar($sidebar1);


    $sidebar2 = array(
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',        
        'name'=>__( 'New York Success Story', 'new-york' ),  'id'=> 'new-york'
    );  
    register_sidebar($sidebar2);
        

    $sidebar3 = array(
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',        
        'name'=>__( 'London Success Story', 'london' ),  'id'=> 'london'
    );  
    register_sidebar($sidebar3);
    
     $baseplate = array(
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',        
        'name'=>__( 'Baseplate', 'baseplate' ),  'id'=> 'baseplate'
    );  
    register_sidebar($baseplate);
    
}
