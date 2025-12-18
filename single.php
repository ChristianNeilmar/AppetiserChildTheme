<?php
$postid = get_the_ID(); 
$feat_imgsrc = get_the_post_thumbnail_url($postid,'full');
/**
 * The template for displaying all single posts and attachments
 */   
get_header(); ?>
<style>
.infinite-bottom-page-builder-content > #comments{display:none !important; visibility:hidden !important;}
.infinite-blog-title-wrap .infinite-blog-title-overlay { background-color: #fff; }
.infinite-blog-title-wrap { background-image: none; }
.infinite-body .infinite-blog-title-wrap .infinite-single-article-title { color: #000; }
.infinite-blog-title-wrap .infinite-single-article-date-day { color: #000; }
.infinite-single-author-top .infinite-blog-info > a,
.infinite-single-author-top .infinite-blog-info > a:hover{ color: #000; }
.infinite-single-author-top .infinite-blog-info > a:hover{ }
.infinite-blog-title-wrap.infinite-style-custom .infinite-blog-title-content { padding-bottom: 0; }
.infinite-single-author{ margin-bottom: 0; }
#blog-bottom-case-study{ min-height:700px !important; }  
.alignnone {  margin: 0 !important; }

.infinite-body .infinite-blog-title-wrap .infinite-single-article-title{
   font-size: 48px;
   font-weight: 700;
   margin-bottom: 11px;
   letter-spacing: -1px;
   line-height: 1.3;
}

@media only screen and  (max-width: 999px) {
  .single-blog-contact-form  > .gdlr-core-pbf-wrapper-content  > .gdlr-core-pbf-wrapper-container{      padding: 30px !important;  }
}

@media only screen and  (max-width: 952px) {
  .single-blog-contact-form  > .gdlr-core-pbf-wrapper-content{   
     padding-top: 0 !important;   background-image: none !important; 
   }
}

</style>

<?php
  while( have_posts() ){ the_post();
    $blog_style = infinite_get_option('general', 'blog-style', 'style-1');
    get_template_part('content/single', $blog_style);
  } // while
?>


<div class="gdlr-core-pbf-wrapper  gdlr-core-wrapper-full-height gdlr-core-js  blog-bottom-case-study  white_gradient" data-skin="Blue Divider"  id="blog-bottom-case-study" >   
  <div class="gdlr-core-pbf-background-wrap" style="background-color: #f8f8f8 ;">
    <div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" style="background-repeat: no-repeat; background-position: right top; height: 1773px; transform: translate(0px, -361px);" data-parallax-speed="-1"></div>
  </div>
  <div class="gdlr-core-pbf-wrapper-content gdlr-core-js" data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.8" style="">
    <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-pbf-wrapper-full-no-space">
<?php echo do_shortcode('[appetiser_blog_bottom_cta]'); ?>    
    </div>
  </div>
</div>

<script>
jQuery(window).scroll(function(){       
  //var x = jQuery("article  .infinite-single-article-thumbnail").position();	 
  var x = jQuery(".recommended-posts, #author-bio").position();  	
       
  var threshold = jQuery(window).scrollTop(); // number of pixels before bottom of page that you want to start fading
  var hiding_sel = '#single-social-share  > .infinite-single-social-share, #single-article-sidebar > .theiaStickySidebar';   
	
  if(threshold >= (x.top-500)){  jQuery(hiding_sel).fadeOut();                                          
  }else{ jQuery(hiding_sel).fadeIn(); } 

});
</script>
<script> 
    jQuery(document).ready(function() { 
        jQuery("#author-bio").insertBefore("#post-grid-wrapper.recommended-posts");
    }); 
</script>
<?php get_footer(); ?>