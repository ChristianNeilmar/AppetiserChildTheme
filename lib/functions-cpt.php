<?php

function wpd_change_post_type_args( $args, $post_type ){
    if( 'post' != $post_type ){       
        $args['rewrite']['with_front'] = false;      
    }	
    return $args;         
}
add_filter( 'register_post_type_args', 'wpd_change_post_type_args', 10, 2 );

