<?php
/**
 * The template for displaying pages
 */
get_header(); 
$category = get_queried_object();
?>

<style>
.infinite-body-wrapper  > .infinite-page-title-wrap{ display:none !important; }
</style>

<div class="gdlr-core-page-builder-body">
   
  
  <div class="gdlr-core-pbf-wrapper " style="padding: 200px 0px 30px 0px;" data-skin="Dark">
  <div class="gdlr-core-pbf-wrapper-content gdlr-core-js" data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.7" style="">
    <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">
      <div class="gdlr-core-pbf-element">
        <div class="gdlr-core-title-item gdlr-core-item-pdb clearfix  gdlr-core-center-align gdlr-core-title-item-caption-top gdlr-core-item-pdlr" style="padding-bottom: 20px ;">
          <div class="gdlr-core-title-item-title-wrap ">
            <h1 class="gdlr-core-title-item-title gdlr-core-skin-title " style="font-size: 90px ;font-weight: 700 ;letter-spacing: -2px ;text-transform: none ;color: #111111 ;"><?php echo $category->name; ?><span class="gdlr-core-title-item-title-divider gdlr-core-skin-divider"></span></h1>
          </div>
        </div>
      </div>
      <div class="gdlr-core-pbf-element">
        <div class="gdlr-core-space-item gdlr-core-item-pdlr " style="padding-top: 30px ;"></div>
      </div>
    </div>
  </div>
</div>

    
    
    <div class="gdlr-core-pbf-wrapper  down-arrow-wrapper" style="margin: 60px 0px 60px 0px;padding: 0px 0px 0px 0px;" id="hero-down-arrow-wrapper">
      <div class="gdlr-core-pbf-background-wrap"></div>
      <div class="gdlr-core-pbf-wrapper-content gdlr-core-js" data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.8" style="">
        <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">
          <div class="gdlr-core-pbf-column gdlr-core-column-60 gdlr-core-column-first" id="gdlr-core-column-1">
            <div class="gdlr-core-pbf-column-content-margin gdlr-core-js ">
              <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js ">
                <div class="gdlr-core-pbf-element">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="gdlr-core-pbf-wrapper " style="margin: 50px 0px 0px 0px;padding: 0px 15px 0px 15px;" id="post-grid-wrapper">
      <div class="gdlr-core-pbf-background-wrap">
        <div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" style="background-size: cover; background-position: center center; height: 802px; transform: translate(0px, -32px);" data-parallax-speed="-1"></div>
      </div>
      <div class="gdlr-core-pbf-wrapper-content gdlr-core-js ">
        <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-pbf-wrapper-full">  
          <div class="gdlr-core-pbf-element">
            <div class="gdlr-core-text-box-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-center-align">
              <div class="gdlr-core-text-box-item-content" style="text-transform: none ;">
                <?php echo do_shortcode('[appetiser_blog  cat="'.$category->term_id.'"  base_url="'.get_term_link($category->term_id,'category').'"  ]'); ?>           
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="gdlr-core-pbf-wrapper  gdlr-core-wrapper-full-height gdlr-core-js blog-bottom-case-study  main-blog-bottom-case-study" style="margin-top: 120px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px; min-height: 368px;" data-skin="Blue Divider" id="bottom-case-study-wrapper">
      <div class="gdlr-core-pbf-background-wrap" style="background-color: #f8f8f8 ;">
        <div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" style="background-repeat: no-repeat; background-position: right top; height: 602px; transform: translate(0px, -12px);" data-parallax-speed="-1"></div>
      </div>
      <div class="gdlr-core-pbf-wrapper-content gdlr-core-js" data-gdlr-animation-duration="600ms" data-gdlr-animation-offset="0.8" style="">
        <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-pbf-wrapper-full-no-space">
          <div class="gdlr-core-pbf-element">
            <div class="gdlr-core-text-box-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-center-align gdlr-core-no-p-space">
              <div class="gdlr-core-text-box-item-content" style="text-transform: none ;">
                <?php echo do_shortcode('[appetiser_blog_bottom_cta]'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<?php	get_footer();  ?>