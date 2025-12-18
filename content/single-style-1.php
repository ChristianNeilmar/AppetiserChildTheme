<?php
	/**
	 * The template part for displaying single posts style 1
	 */


	$post_option = infinite_get_post_option(get_the_ID());
	$post_option = empty($post_option)? array(): $post_option;
	$post_option['show-content'] = empty($post_option['show-content'])? 'enable': $post_option['show-content']; 

	if( empty($post_option['sidebar']) || $post_option['sidebar'] == 'default' ){
		$sidebar_type = infinite_get_option('general', 'blog-sidebar', 'none');
		$sidebar_left = infinite_get_option('general', 'blog-sidebar-left');
		$sidebar_right = infinite_get_option('general', 'blog-sidebar-right');
	}else{
		$sidebar_type = empty($post_option['sidebar'])? 'none': $post_option['sidebar'];
		$sidebar_left = empty($post_option['sidebar-left'])? '': $post_option['sidebar-left'];
		$sidebar_right = empty($post_option['sidebar-right'])? '': $post_option['sidebar-right'];
	}

	if( $sidebar_type != 'none' || $post_option['show-content'] == 'enable' ){
		echo '<div class="infinite-content-container infinite-container">';
        ?>
<div id="breadcrumbs"><?php echo do_shortcode('[wpseo_breadcrumb]');?></div>
		<?php 
		echo '<div class="' . infinite_get_sidebar_wrap_class($sidebar_type) . '" >'; ?>


<?php

		// sidebar content
		echo '<div class="infinite-sidebar-center infinite-column-45 infinite-line-height" id="single-article-content"  >';
		echo '<div class="infinite-content-wrap infinite-item-pdlr clearfix" >';

 		
	  // print header title
	  if( get_post_type() == 'post' ){
		get_template_part('header/header', 'title-blog');
	  }

		// single content
		if( $post_option['show-content'] == 'enable' ){
			echo '<div class="infinite-content-area" >';
			if( in_array(get_post_format(), array('aside', 'quote', 'link')) ){
				get_template_part('content/content', get_post_format());
			}else{
				get_template_part('content/content', 'single');
			}
			
			
			echo '</div>';
		}
	}

	if( !post_password_required() ){
		if( $sidebar_type != 'none' ){
			echo '<div class="infinite-page-builder-wrap infinite-item-rvpdlr" >';
			do_action('gdlr_core_print_page_builder');
			echo '</div>';

		// sidebar == 'none'
		}else{
			ob_start();
			do_action('gdlr_core_print_page_builder');
			$pb_content = ob_get_contents();
			ob_end_clean();

			if( !empty($pb_content) ){
				if( $post_option['show-content'] == 'enable' ){
					echo '</div>'; // infinite-content-area
					echo '</div>'; // infinite_get_sidebar_class
					echo '</div>'; // infinite_get_sidebar_wrap_class
					echo '</div>'; // infinite_content_container
				}
				echo gdlr_core_escape_content($pb_content);
				echo '<div class="infinite-bottom-page-builder-container infinite-container" >'; // infinite-content-area
				echo '<div class="infinite-bottom-page-builder-sidebar-wrap infinite-sidebar-style-none" >'; // infinite_get_sidebar_class
				echo '<div class="infinite-bottom-page-builder-sidebar-class" >'; // infinite_get_sidebar_wrap_class
				echo '<div class="infinite-bottom-page-builder-content infinite-item-pdlr" >'; // infinite_content_container
			}
		}
	}
    
	
?>
<!-- <div class="navigation">
  <div class="next-article-nav"><?php next_post_link( '%link &raquo;', __( 'Next', 'textdomain' ), true); ?></div>
  <div class="prev-article-nav"><?php previous_post_link( '&laquo; %link', __( 'Previous', 'textdomain' ), true); ?> </div>
</div> -->   
	<?php  
	echo '</div>'; // infinite-content-area
	echo '</div>'; // infinite-get-sidebar-class


?>
<div class=" infinite-sidebar-right infinite-column-15 infinite-line-height infinite-line-height sticky-sidebar"  id="single-article-sidebar"  >
  <div class="infinite-sidebar-area infinite-item-pdlr">
    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Custom Blog Sidebar')) ?>
  </div>
</div>
   


 
 


<?php

	echo '</div>'; // infinite-get-sidebar-wrap-class
 	echo '</div>'; // infinite-content-container

?>
<?php 
$taxonomy = array('category');   
global $post;
$categories = get_the_category($post->ID);
if($categories){
$category_ids = array();
foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

   $args=array(
	 'category__in' => $category_ids,
	 'post__not_in' => array($post->ID,16921),
	 'posts_per_page'=> 3, // Number of related posts that will be shown.
	 'caller_get_posts'=>1 
    );
	
	$my_query = new wp_query( $args );   
    if($my_query->have_posts()) { ?>
<div class="gdlr-core-pbf-wrapper  project_portfolio  recommended-posts" style="padding: 110px 0px 50px 0px;" id="post-grid-wrapper" >
  <div class="gdlr-core-pbf-wrapper-content gdlr-core-js ">
    <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">
      <div class="gdlr-core-pbf-element">
        <div class="gdlr-core-title-item gdlr-core-item-pdb clearfix  gdlr-core-left-align gdlr-core-title-item-caption-top gdlr-core-item-pdlr" style="padding-bottom: 50px ;">
          <div class="gdlr-core-title-item-title-wrap ">
            <div class="gdlr-core-title-item-title gdlr-core-skin-title " style="font-size: 35px; font-weight: 700 ;letter-spacing: -2px ;text-transform: none ;color: #111111 ;">Recommended For You<span class="gdlr-core-title-item-title-divider gdlr-core-skin-divider"></span></div>
          </div>
        </div>
      </div>
      <div class="gdlr-core-pbf-element">
        <div class="gdlr-core-personnel-item gdlr-core-item-pdb clearfix  gdlr-core-left-align gdlr-core-personnel-item-style-grid gdlr-core-personnel-style-grid">
          <?php while( $my_query->have_posts() ) {  $my_query->the_post(); 
		  $post_id = get_the_ID();
	      $feat_imgsrc = get_the_post_thumbnail_url($post_id,'full');
	     if(!$feat_imgsrc) $feat_imgsrc = get_bloginfo('url').'/wp-content/uploads/2017/10/rodion-kutsaev-184298.jpg';
		  $author_name = get_the_author();
	$author_id = get_the_author_meta('ID');
	$reading_duration = get_field('post_reading_duration', $post_id);
	$post_terms = array();

	for($i=0;$i<count($taxonomy);$i++){
	  $term_list = wp_get_post_terms($post_id, $taxonomy[$i], array("fields" => "all"));
	  foreach($term_list as $temp_term){ 
	    $style = 'color:'.get_field('cat_color', 'category_'.$temp_term->term_id).' !important;';
	    $term_link = get_term_link( $temp_term );
	    $post_terms[] = '<a href="'.esc_url( $term_link ).'"  rel="'.$taxonomy[$i].'"  style="'. $style.'" >'.$temp_term->name.'</a>';
	  }
	}
	 ?>
          <div class="gdlr-core-personnel-list-column  gdlr-core-column-20  app-custom-post-wrapper">
            <div class="gdlr-core-blog-grid gdlr-core-js  gdlr-core-blog-grid-with-frame gdlr-core-item-mgb gdlr-core-skin-e-background " data-sync-height="blog-item-1" >
              <div class="gdlr-core-blog-thumbnail gdlr-core-media-image  gdlr-core-opacity-on-hover gdlr-core-zoom-on-hover"><a href="<?php echo get_permalink($post_id); ?>" style="background-image:url(<?php echo $feat_imgsrc; ?>); background-size:cover;     background-position: center; ">&nbsp;</a></div>
              <div class="gdlr-core-blog-grid-frame blog-grid-details">
                <div class="gdlr-core-blog-info-wrapper gdlr-core-skin-divider" style="border-top-width: 0; float:left; width:100%;" >
					<div class="avatar">
					    <?php echo get_avatar( $author_id, 40, '', esc_attr($author_name) ); ?>
					</div>					
					<div class="article-author-tax" > <span class="article-author" > <a title="Posts by <?php echo $author_name; ?>" rel="author" ><?php echo $author_name; ?></a> </span>
						<div class="article-tax">
						<?php if($post_terms) echo implode(', ',$post_terms);?>
						<?php if($reading_duration) echo '<span class="reading-duration"> | '.$reading_duration.' Read</span>'; ?>
						</div>
					</div>
                </div>
                <h6 class="gdlr-core-blog-title gdlr-core-skin-title" ><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title(); ?></a></h6>
              </div>
            </div>
          </div>
          <?php } //end  while( $my_query->have_posts() )  ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php  }
}
wp_reset_query();