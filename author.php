<?php
/**
 * The main template file
 */

	get_header();

?>

	<style>
	.infinite-page-title-container.infinite-container {
	    display: none;
	}
	.infinite-page-title-wrap {
	    background: none;
	}
	.infinite-page-title-wrap .infinite-page-title-overlay {
	    display: none;
	}
	.author-blog-page .author-profile-card {
	    margin-bottom: 20px;
	    display: inline-block;
	    width: 100%;
	}
	.author-blog-page .author-photo {
	    float: left;
	    text-align: left;
	    margin-right: 25px;
	}
	.author-blog-posts-wrap {
	    display: inline-block;
	    width: 100%;
	    margin-top: 20px;
	    padding-top: 20px;
	    border-top: 1px solid rgba(215, 215, 215,0.7);
	}
	.author-blog-posts-wrap h5 {
	    color: #959595;
	    font-size: 12px;
	    font-weight: 400;
	    text-transform: uppercase;
	    margin: 0;
	    padding: 0;
	}
	.author-blog-posts-wrap .infinite-content-container.infinite-container {
	    padding: 0px !important;
	}
	.author-blog-posts-wrap .infinite-content-area {
	    padding-top: 25px;
	}
	.author-blog-posts-wrap .gdlr-core-item-pdlr {
	    padding: 0px;
	}
	</style>

	<div class="author-blog-page">
		<div class="infinite-content-container infinite-container">
			<div class="infinite-content-area infinite-item-pdlr infinite-sidebar-style-none clearfix" >
				<?php
				// Set the Current Author Variable $curauth
				$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
				?>
				     
				<div class="author-profile-card">
				    <div class="author-photo">
				    	<?php echo get_avatar( $curauth->user_email , '250 '); ?>
				    </div>
				    <div class="author-details">
				    	<h3><?php echo get_the_author(); ?></h3>
				    	<p><?php echo $curauth->user_description; ?></p>
				    </div>
				</div>
				   
				<div class="author-blog-posts-wrap"> 
					<h5>Posts by <?php echo get_the_author(); ?></h5>
					<?php

							$post_type = 'portfolio';

							$sidebar_type = infinite_get_option('general', 'archive-portfolio-sidebar', 'none');
							$sidebar_left = infinite_get_option('general', 'archive-portfolio-sidebar-left');
							$sidebar_right = infinite_get_option('general', 'archive-portfolio-sidebar-right');

						echo '<div class="infinite-content-container infinite-container">';
						echo '<div class="' . infinite_get_sidebar_wrap_class($sidebar_type) . '" >';

						// sidebar content
						echo '<div class="' . infinite_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
							
							get_template_part('content/archive', 'portfolio');
							


						echo '</div>'; // infinite-get-sidebar-class

						// sidebar left
						if( $sidebar_type == 'left' || $sidebar_type == 'both' ){
							echo infinite_get_sidebar($sidebar_type, 'left', $sidebar_left);
						}

						// sidebar right
						if( $sidebar_type == 'right' || $sidebar_type == 'both' ){
							echo infinite_get_sidebar($sidebar_type, 'right', $sidebar_right);
						}

						echo '</div>'; // infinite-get-sidebar-wrap-class
					 	echo '</div>'; // infinite-content-container
					?>
				</div>
			</div>
		</div>
	</div>


<?php
	get_footer(); 
?>