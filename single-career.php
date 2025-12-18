<?php 
$postid = get_the_ID(); 
$feat_imgsrc = get_the_post_thumbnail_url($postid,'full');
get_header(); ?>


<style>
.career-template-default .infinite-page-title-wrap {
	display: none;
}
</style>

<?php


	if ( function_exists('yoast_breadcrumb') ) {
		echo '<div class="infinite-content-container infinite-container">';
		echo '<div class="infinite-sidebar-style-none" >'; // for max width
			  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
              
              
		echo '</div>';
		echo '</div>';
	}

	if( !post_password_required() ){
		
		if( $sidebar_type != 'none' ){
			echo '<div class="infinite-page-builder-wrap" >';
			do_action('gdlr_core_print_page_builder');
			echo '</div>';		
		}
	}


	
get_footer(); ?>