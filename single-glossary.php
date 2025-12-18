<?php
$postid = get_the_ID(); 
$feat_imgsrc = get_the_post_thumbnail_url($postid,'full');
/**
 * The template for displaying all single posts and attachments
 */   
get_header(); ?>




  
  
  <?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		//

?>
<div class="infinite-page-wrapper" id="infinite-page-wrapper">
    <div class="gdlr-core-page-builder-body">
        <div class="gdlr-core-pbf-wrapper glossary-wrap">
            <div class="gdlr-core-pbf-background-wrap"></div>
            <div class="gdlr-core-pbf-wrapper-content gdlr-core-js">
                <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">
				
				
				<div class="gdlr-core-pbf-column gdlr-core-column-60x gdlr-core-column-first" id="gdlr-core-column-1">
                        <div class="gdlr-core-pbf-column-content-margin gdlr-core-js context">
                            <div class="gdlr-core-pbf-background-wrap"></div>
                            <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js"></div>
							
							 <ul class="glossary-index">
								<?php 
								foreach(range('A','Z') as $v){
									?>
									<li><a href="/glossary/#<?php echo "$v \n";?>" class="<?php echo "$v \n";?>-index"><?php echo "$v \n";?></a></li>
									<!-- echo "$v \n"; -->
									<?php 
								}
								?>

							</ul>
							
							
							<div class="back-btn" style="font-size: 13px;
font-style: normal;
font-weight: 400;
line-height: 27px;"><a href="/glossary/"> <img src="/wp-content/uploads/2023/12/Vector-1.png">Back</a></span>
							
							                        </div>
                    </div>
				
				
				
				
				
                    <div class="gdlr-core-pbf-column gdlr-core-column-60 gdlr-core-column-first" id="gdlr-core-column-2">
                        <div class="gdlr-core-pbf-column-content-margin gdlr-core-js context">
                            <div class="gdlr-core-pbf-background-wrap"></div>
                            <div class="gdlr-core-pbf-column-content clearfix gdlr-core-js"></div>
							
							
							
							
							<?php 
								if ( function_exists('yoast_breadcrumb') ) {
									#yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
								}
							?>
							<!--  -->
								<span class="glossary-title"><h1><?php the_title();?></h1></span>
								<?php the_content(); ?>
							<!--  -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>



.infinite-page-title-wrap{display:none;}
.back-btn img {
    margin-top: -5px;
    margin-right: 5px;
}


a u {
    text-decoration: none !important;
}

.glossary-index{padding:0;margin:0;list-style-type:none;display:table;margin:0;padding:0}.glossary-index li{display:inline-block;padding:14px;color:#fff}.glossary-index li a{color:#111;text-align:center;font-family:Helvetica;font-size:20px;font-style:normal;font-weight:700}


.glossary-index {
       margin-top: 50px !important;
    padding: 30px 0 5px;
    border-bottom: 1px solid #E4E4E4;
    margin-bottom: 20px;
}


@media only screen and (min-width:1200px){
	
div#gdlr-core-column-2 {
    width: 60%;
    margin: 0 auto;
}
	
}


@media only screen and (min-with:1000px){
	
	.gdlr-core-pbf-wrapper-container {
    margin-top: 80px;
}
	
}

</style>    
    
	<?php 
	
			// Post Content here
		//
	} // end while
} // end if
?>
<?php get_footer(); ?>