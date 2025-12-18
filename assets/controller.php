<?php
//----------------------------
//ajax for loading more posts
add_action('wp_ajax_appetiser_more_posts', 'appetiser_more_posts');
add_action('wp_ajax_nopriv_appetiser_more_posts', 'appetiser_more_posts');   
function appetiser_more_posts() {  
   global $wpdb; 
   $loadmore = (isset($_POST['loadmore'])) ? $_POST['loadmore'] : ''; 
   $args = (isset($_POST['args'])) ? stripslashes($_POST['args']) : array();
   $args = ($args) ?  json_decode($args,true) :  array();
   $args['cat'] = '-398';   
   
  
$the_query = new WP_Query($args); 
$number = 1;
$taxonomy = array('category');
   
// The Loop
if ( $the_query->have_posts() ) { 
  while ( $the_query->have_posts() ) {  $the_query->the_post();
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
     
 <div class="gdlr-core-item-list  gdlr-core-item-pdlr gdlr-core-column-30  <?php if($number % 2 != 0)  echo 'gdlr-core-column-first'; ?> app-custom-post-wrapper" >   
  <div class="gdlr-core-blog-grid gdlr-core-js  gdlr-core-blog-grid-with-frame gdlr-core-item-mgb gdlr-core-skin-e-background"  >
    <div class="gdlr-core-blog-thumbnail gdlr-core-media-image  gdlr-core-opacity-on-hover gdlr-core-zoom-on-hover"><a href="<?php echo get_permalink($post_id); ?>" style="background-image:url(<?php echo $feat_imgsrc; ?>); background-size:cover;     background-position: center; ">&nbsp;</a></div>
    <div class="gdlr-core-blog-grid-frame blog-grid-details">
      <div class="gdlr-core-blog-info-wrapper gdlr-core-skin-divider" style="border-top-width: 0; float:left; width:100%;" >
     
      <div class="avatar"><img src="<?php echo get_avatar_url($author_id); ?>" alt="<?php echo $author_name; ?>" style="border-radius: 50%;-moz-border-radius: 50%;-webkit-border-radius: 50%;" /></div>
     
     <div class="article-author-tax" >
      <span class="article-author" > <a title="Posts by <?php echo $author_name; ?>" rel="author" ><?php echo $author_name; ?></a>
      </span>
      <div class="article-tax">
        <?php if($post_terms) echo implode(', ',$post_terms);?>
        <?php if($reading_duration) echo '<span class="reading-duration"> | '.$reading_duration.' Read</span>'; ?>
      </div>   
     </div>
      
      </div>
           
       <h3 class="gdlr-core-blog-title gdlr-core-skin-title" ><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title(); ?></a></h3>     
      <div class="gdlr-core-blog-content-mobile"><a href="<?php echo get_permalink($post_id); ?>"><?php  echo wp_trim_words( get_the_excerpt($post_id), 27, '...' );  ?></a></div>
      <div class="gdlr-core-blog-content-desktop"><a href="<?php echo get_permalink($post_id); ?>"><?php echo wp_trim_words( get_the_excerpt($post_id), 54, '...' );  ?></a></div>
      
    </div>
  </div>
</div>

<?php 
  $number++;  }} //end if ( $the_query->have_posts() ) 
  ?>
  
  
<?php if($the_query->max_num_pages == $args['paged']): ?>      
<style>
 <?php echo $loadmore; ?>{ display:none !important; visibility: hidden !important; }
</style>
<?php endif; ?>
 
  <?php 
wp_reset_postdata(); 
 die(); 
}
   