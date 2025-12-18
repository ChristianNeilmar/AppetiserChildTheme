<?php
/**
* Shortcode for getting blog   
*/
//----------------------------------------------
function appetiser_blog( $atts ) {  
  $a = shortcode_atts( array(
    'post_type' => 'post',
    'cat'=> false,
    'tag'=> false,
    'limit' => 8,
    'base_url' => false        
  ), $atts ); 
  ob_start(); 
  ?> 
    
<?php   
 //---------------------------------------
$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;  
$args = array( 
    'post_type'  => $a['post_type'],
  'post_status'  => 'publish',
  'posts_per_page' => $a['limit'],
    'author__not_in' => array( 65 , 66 , 69 ),
    'paged' => $paged ,
	'post__not_in' => array(16921 , 17118 , 5272 , 17363 ,17875 , 17894, 18732 ,18692 ,18675 ,18798,18828 ,18845 ,18798 , 18828 , 18732 , 18692 , 19574 , 19537,19776 , 22637 , 22857 , 23323 , 23333  )
    
); 
$tax_query = array(); $number = 1;
$taxonomy = array('category');

//for category
if($a['cat']){
  $term_ids = explode(',', $a['cat']);    
  $tax_query[] = array(
        'taxonomy' => 'category',
        'field' => 'term_id',
        'operator' => 'IN',
        'terms' => $term_ids
    );
}

//for tag  
if($a['tag']){
  $term_ids = explode(',', $a['tag']);
  $tax_query[] = array(
        'taxonomy' => 'post_tag',   
        'field' => 'term_id',
        'operator' => 'IN',
        'terms' => $term_ids
    );
}


if($tax_query) $args['tax_query'] = $tax_query;
$the_query = new WP_Query($args);
$max_num_pages = $the_query->max_num_pages;
$base_url = ($a['base_url'])  ?  $a['base_url'] : get_bloginfo('url').'/blog/';          
?>



<div class="gdlr-core-blog-item gdlr-core-item-pdb clearfix  gdlr-core-style-blog-column-with-frame">
  <div id="appetiser-ajax-wrapper" class="gdlr-core-blog-item-holder gdlr-core-js-2 clearfix" data-layout="fitrows">


<?php 
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
     
      <div class="avatar">
     
      <img src="<?php echo get_avatar_url($author_id); ?>" alt="<?php echo $author_name; ?>" style="border-radius: 50%;-moz-border-radius: 50%;-webkit-border-radius: 50%;" /></div>
     
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
      <div class="gdlr-core-blog-content-mobile"><?php  echo wp_trim_words( get_the_excerpt($post_id), 27, '...' );  ?></div>
      <div class="gdlr-core-blog-content-desktop"><?php echo wp_trim_words( get_the_excerpt($post_id), 27, '...' );  ?></div>
    </div>             
  </div>
</div>

  
<?php if($number==4){ ?>
 <div class="clear" ></div>     
 <div class="gdlr-core-pbf-wrapper  optin_appetiser_dark  middle-case-study-wrapper" style="padding: 90px 0px 50px 0px; margin-bottom: 80px;">
  <div class="gdlr-core-pbf-wrapper-content gdlr-core-js ">
    <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">
      <div class="gdlr-core-pbf-column gdlr-core-column-30 gdlr-core-column-first left-side-section">
        <div class="gdlr-core-pbf-column-content-margin gdlr-core-js ">
          <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js ">
            <div class="gdlr-core-pbf-element">
              <div class="gdlr-core-text-box-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-left-align">
                <div class="gdlr-core-text-box-item-content">
                  <div style="color: white; font-size: 38px; line-height: 1.05; letter-spacing: -1px; font-weight: bold; padding-bottom: 10px;">Learn how Youfoodz created a 3 second purchase process.</div>
                  <div style="color: white; font-size: 22px;">Get access to our Youfoodz case study</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="gdlr-core-pbf-column gdlr-core-column-30  right-side-section">   
        <div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="padding: 0px 0px 0px 0px;">
          <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js " style="max-width: 360px ;">
            <div class="gdlr-core-pbf-element">
              <div class="gdlr-core-text-box-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-left-align contact-form-wrapper" id="app-case-study-form">
                <div class="gdlr-core-text-box-item-content" style="text-transform: none ;">
                     
                  <!-- [if lte IE 8]>
<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
<![endif]-->
<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
<script data-hubspot-rendered="true">
 hbspt.forms.create({
    portalId: "5769657",
    formId: "12afc831-37fc-4b2e-a16d-ef1f74a07279"
});
</script>
<div id="hbspt-form-1555766191236-5340685736" class="hbspt-form"></div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 
<?php } ?>


<?php $number++;  }} ?>



  </div>
</div>

  
<div id="appetiser-loadmore" class="gdlr-core-load-more-wrap gdlr-core-js gdlr-core-center-align gdlr-core-item-pdlr" data-ajax="gdlr_core_post_ajax"  data-target="gdlr-core-blog-item-holder" data-target-action="append"><a href="<?php echo $base_url. 'page/'.($paged+1).'/'; ?>" class="gdlr-core-load-more gdlr-core-button-color" data-ajax-name="paged" data-ajax-value="2"  id="load-more-page"   >Load More</a></div>        

<script>
(function() {
  var container = '#appetiser-ajax-wrapper';
  var loadmore = '#appetiser-loadmore';
  var loadmorebtn_sel = 'load-more-page';
  var maxPages = <?php echo $max_num_pages; ?>; // Pass total number of pages from PHP to JS
  var args = <?php echo json_encode($args); ?>;

  // Initially hide the button if the current page is greater than or equal to max pages
  if (args.paged >= maxPages) {
    jQuery('#' + loadmorebtn_sel).hide();
  }

  document.getElementById(loadmorebtn_sel).addEventListener('click', function(evt) {
    evt.preventDefault();

    // Increase the page number
    args.paged += 1;

    // Check if we have reached the last page, if so, hide the button
    if (args.paged >= maxPages) {
      jQuery('#' + loadmorebtn_sel).hide();
    }

    // Make the AJAX request to load more posts
    jQuery.post(ajaxurl, { action: 'appetiser_more_posts', loadmore: loadmore, args: JSON.stringify(args) }, function(response) {
      jQuery(container).append(response);

      // Update URL in browser without reloading the page
      if (history && history.pushState) {
        history.pushState({}, null, '<?php echo $base_url; ?>' + 'page/' + args.paged + '/');
        jQuery('#' + loadmorebtn_sel).attr('href', '<?php echo $base_url; ?>' + 'page/' + (args.paged + 1) + '/');
      }
    });
  });
})();
</script> 



<?php wp_reset_postdata(); ?> 

    <?php   
  return ob_get_clean();
}

add_shortcode( 'appetiser_blog', 'appetiser_blog' );

//-------------------------


/**
* Shortcode for showing blog subscription form   
*/
//----------------------------------------------
function appetiser_post_only_shortcode( $atts, $content = null ) {
  $a = shortcode_atts( array( ), $atts ); 
  ob_start(); ?>
  
    <?php  if ( is_single() ) echo $content; ?>
    
      <?php   
  return ob_get_clean();
}
add_shortcode( 'appetiser_post_only', 'appetiser_post_only_shortcode' );



/**
* Shortcode for showing blog bottom CTA   
*/
//----------------------------------------------  
function appetiser_blog_bottom_cta( $atts ) {
  $a = shortcode_atts( array( ), $atts ); 
  ob_start(); 
  ?>  

      <div class="gdlr-core-pbf-column gdlr-core-column-30 gdlr-core-column-first">
        <div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="margin: px px 7px px;">
          <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js ">
            <div class="gdlr-core-pbf-element">
              <div class="gdlr-core-image-item gdlr-core-item-pdlr gdlr-core-item-pdb  gdlr-core-right-align roamni_footer_phone">
                <div class="gdlr-core-image-item-wrap gdlr-core-media-image  gdlr-core-image-item-style-rectangle" style="border-width: 0px;">
               <?php echo do_shortcode('[wpinsertshortcodead id="pygnm5ff2def18385b"]'); ?>
                </div>
              </div>
            </div>       
          </div>
        </div>
      </div>
      <div class="gdlr-core-pbf-column gdlr-core-column-30">
        <div class="gdlr-core-pbf-column-content-margin gdlr-core-js " style="margin: px px 7px px;padding-right: 30px;">
          <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js ">
           <?php echo do_shortcode('[wpinsertshortcodead id="rijae5ff2df3eab72d"]'); ?>          
          </div>
        </div>
      </div>
    <?php   
  return ob_get_clean();
}

add_shortcode( 'appetiser_blog_bottom_cta', 'appetiser_blog_bottom_cta' );

/**
* Shortcode for showing blog subscription form   
*/
//----------------------------------------------
function appetiser_sharecount( $atts ) {
  $a = shortcode_atts( array( ), $atts ); 
  ob_start(); 
  ?> 
 
 <script>
 jQuery.sharedCount = function(url, fn) {
    url = encodeURIComponent(url || location.href);
    var domain = "//api.sharedcount.com/v1.0/"; /* SET DOMAIN */
    var apikey = "6534ef4c4801603c7c60c5b98cf0a9e13fd74e7a" /*API KEY HERE*/    
    var arg = {
      data: {
        url : url,
        apikey : apikey
      },
        url: domain,
        cache: true,
        dataType: "json"
    };
    if ('withCredentials' in new XMLHttpRequest) {
        arg.success = fn;
    }
    else {
        var cb = "sc_" + url.replace(/\W/g, '');
        window[cb] = fn;
        arg.jsonpCallback = cb;
        arg.dataType += "p";
    }
    return jQuery.ajax(arg);
};

</script>


<script>
jQuery(document).ready(function($){
    $.sharedCount(location.href, function(data){
        $("#facebook").text(data.Facebook.total_count);
        $("#linkedin").text(data.LinkedIn);
        $("#pinterest").text(data.Pinterest);
        $("#stumbles").text(data.StumbleUpon);
        $("#comments").text(data.Facebook.comment_count);
        $("#plusones").text(data.GooglePlusOne);
        $("#sharedcount").fadeIn();

   });
 });
 </script>


    <?php   
  return ob_get_clean();
}

add_shortcode( 'appetiser_sharecount', 'appetiser_sharecount' );
////////////////////////////
function appetiser_glossary( $atts ) {
    
    
   
    
    
  $atts = shortcode_atts( array(
    'class' => 'glossary'
  ), $atts );
  ob_start(); 
  ?> 
 
 
 <ul class="glossary-index">
<?php 
foreach(range('A','Z') as $v){
    ?>
    <li><a href="#<?php echo "$v";?>" class="<?php echo "$v \n";?>-index"><?php echo "$v \n";?></a></li>
    <!-- echo "$v \n"; -->
    <?php 
}
?>

</ul>
<div style="border-bottom: 1px solid #E4E4E4;"></div> 
 <div class="glossary-wrapper">
 
 <?php 
 
 $all_posts = new WP_Query( array(
    'post_type' => 'glossary',
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1
  ) );
 
 if ( $all_posts->have_posts() ) {
    echo '<div class=" ' . $atts['class'] . '">';
    foreach( range( 'A', 'Z' ) as $letter ) {
      echo '<div class="group_letter '. $letter .'-wrapper">';
        echo '<div class="letter">';
          echo '<h2 id="' . $letter . '">' . $letter . '</h2>';
        echo '</div>';
        echo '<div class="posts-wrapper">';
        while( $all_posts->have_posts() ){
          $all_posts->the_post();
          $title = get_the_title(); 
          $initial = strtoupper( substr( $title, 0, 1 ) );
          if( $initial == $letter ){ ?> 
            <div class="glossary-content">                 
              <div class="glossary-content-wrapper" class="glossary-permalink">
				<a href="<?php the_permalink();?>">
					<h3 class="glossary-title"><?php echo get_the_title(); ?></h3>
						<div class="glossary-content">
						  <?php 
						  $excerpt = get_the_excerpt(); 
						  $excerpt = substr( $excerpt, 0, 150 ); 
						  $excerpt_description = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );
						  echo $excerpt_description;
						  ?>
						</div>
				</a>
              </div>                
            </div>
          <?php 
          }
		  
		 
        }

        echo '</div>';

        $all_posts->rewind_posts();
      echo '</div>';
    }
    echo '</div>';
  }
 
 
 ?>
                           
</div>
<?php wp_reset_query(); ?>
<style>
ul li {list-style:none !important;}.glossary-index li {
    display: inline-block;
}
    
    .sticky {
  position: fixed;
  top: 0;
  width: 100%
}
    
    
.glossary-index{
	    padding: 0;
    margin: 0;
    list-style-type: none;
    display: table;
    margin: 0;
    padding: 0;
}
.glossary-index li {
    display: inline-block;
    padding: 14px;
    /* display: table-cell; */
    /* background: #000; */
    color: #fff;
}
.glossary-index li a {
	color: #111;

text-align: center;
font-family: Helvetica;
font-size: 20px;
font-style: normal;
font-weight: 700;
}
/*typo*/
	
h3.glossary-title {
    font-size: 30px;
    font-style: normal;
    font-weight: 700;
}	

.glossary-content	
span {
    font-family: Open Sans;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 27px;
}
	
.group_letter {
    padding: 50px 0 25px;
    border-bottom: 1px solid #ccc;
}
/**grid**/
    	.letter {
    padding-left: 30px;
}
	.posts-wrapper {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 50px;
}
	
    .glossary-wrapper {

}
    
.glossary-content {
   /** width: 50%;
    padding-right: 50px;
    float: left; **/
}
.glossary-divider-top {
    clear:both;
}
.glossary-divider-top {
    border-bottom: 1px solid #E4E4E4;
    margin: 50px 0;
}
.glossary-divider-top.A {
    border: none;
    margin: 0;
}
.glossary-content {
    /*min-height: 285px;*/
}

.glossary-content-wrapper {
    padding: 30px;
}
.glossary-sort {
    padding-left: 30px;
}

.glossary-content-wrapper:hover {
    border-radius: 20px;
    background: #F5F5F5;
}


/*media query */
@media only screen and (max-width:820px){
.glossary-index li {
padding: 7px;}
}

@media only screen and (max-width:768px){
.glossary-index li {
padding: 5px;}
.letter {
    padding-left: 0;
}
.glossary-sort,.glossary-content-wrapper{padding:0;}
.posts-wrapper {
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 50px;

}

@media only screen and (max-width:767px){
.glossary-content {
    width: 100%;padding-right:0;}
}
</style>
 <!-- -->
    
<button class="scrollToTopBtn"><img src="http://appetiser.com.au/wp-content/uploads/2023/12/back_to_top_icon.webp"></button>
    
    <style>
    .scrollToTopBtn {
      background-color: inherit;
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    font-size: 30px;
    line-height: 48px;
    width: 48px;
    position: fixed;
    bottom: 0px;
    right: 95px;
    z-index: 100;
    opacity: 0;
    transform: translateY(100px);
    transition: all .5s ease;
}.showBtn {
  opacity: 1;
  transform: translateY(0)
}
    </style>
<script>
<!-- ====== SCROLL TO TOP SCRIPT ====== -->
var scrollToTopBtn = document.querySelector(".scrollToTopBtn")
var rootElement = document.documentElement

function handleScroll() {
  // Do something on scroll - 0.15 is the percentage the page has to scroll before the button appears
  // This can be changed - experiment
  var scrollTotal = rootElement.scrollHeight - rootElement.clientHeight
  if ((rootElement.scrollTop / scrollTotal ) > 0.15) {
    // Show button
    scrollToTopBtn.classList.add("showBtn")
  } else {
    // Hide button
    scrollToTopBtn.classList.remove("showBtn")
  }
}

function scrollToTop() {
  // Scroll to top logic
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}
scrollToTopBtn.addEventListener("click", scrollToTop)
document.addEventListener("scroll", handleScroll)
</script>
    <!-- -->
<?php   
return ob_get_clean();
    

    
    
}

function new_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');


add_shortcode( 'appetiser_glossary', 'appetiser_glossary' );