<?php

function hook_javascript() {
	if( get_field('schema') ){
		the_field('schema');
	}else{

		$schemamarkup = get_post_meta(get_the_ID(), 'schema', true);
		if(!empty($schemamarkup)) {
		  echo $schemamarkup;
		}
	}
}
add_action('wp_head', 'hook_javascript');

//Completely disables Yoast SEO’s JSON-LD schema output, by returning an empty array.
function disable_yoast_schema_data($data){
	$data = array();
	return $data;
}
add_filter('wpseo_json_ld_output', 'disable_yoast_schema_data', 10, 1);

function addYoastCanonical(){
    global $post;
    $meta = get_post_meta( $post->ID, '_yoast_wpseo_canonical', true );
    if($meta){
            echo '<link rel="canonical" href="' . $meta .  '" />';
    }
}
add_action( 'wp_head', 'addYoastCanonical');