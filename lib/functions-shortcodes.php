<?php 
#
# This files handles all shortcode functions.
#
error_log('functions-shortcodes.php loaded');

function register_custom_appetiser_shortcodes(){
    add_shortcode('html_sitemap', 'display_html_sitemap');
    add_shortcode('roamni_banner_cta', 'roamni_banner_cta'); 
    add_shortcode('legacy_banner_cta', 'legacy_banner_cta'); // for deprecation pending 86erd7p2q
    //add_shortcode('optin_jump', 'optin_jump_function');
    add_shortcode('hubspot_form', 'render_hubspot_tel_form_shortcode');

    add_shortcode( 'appcareer', 'appcareer' );
    add_shortcode('blog_taxonomy','blog_taxonomy');
    add_shortcode( 'appetiser_portfolio', 'appetiser_portfoliox' );
    add_shortcode('single_social', 'single_social');

    add_action('wp_enqueue_scripts', 'register_intl_tel_input_assets');
    //add_action('wp_enqueue_scripts', 'register_optin_jump_assets');

}
add_action('init','register_custom_appetiser_shortcodes');

# This is a shortcode function to display html sitemap through the [html_sitemap] shortcode.
function display_html_sitemap() {
    $menu = wp_nav_menu(array(
        'theme_location' => 'right_menu', 
        'echo'           => false,        
        'fallback_cb'    => false,        
    ));

    if (!$menu) {
        return '<p>No Secondary Menu assigned.</p>'; 
    }

    $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['right_menu']);

    if (!$menu_items) {
        return '<p>No items found in Secondary Menu.</p>'; 
    }

    $menu_tree = array();
    foreach ($menu_items as $item) {
        $menu_tree[$item->ID] = array(
            'title' => $item->title,
            'url'   => $item->url,
            'parent' => $item->menu_item_parent,
            'children' => array()
        );
    }

    $top_level_items = array();
    foreach ($menu_tree as $id => &$item) {
        if ($item['parent'] == 0) {
            $top_level_items[$id] = &$item;
        } else {
            $menu_tree[$item['parent']]['children'][$id] = &$item;
        }
    }
    unset($item);

    $output = '<ul class="sitemap-secondary">';
    $output .= build_menu_html($top_level_items);
    $output .= '</ul>';

    return $output; 
}

# This is a helper function for display_html_sitemap.
function build_menu_html($items) {
    $html = '';
    foreach ($items as $menu_id => $item) {
        $html .= '<li id="menu-id-' . $menu_id . '">';
        $html .= '<a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a>';

        if ($menu_id == 8704) {
            $html .= '<ul class="submenu">';
            $html .= get_blog_categories_with_posts();
            $html .= '</ul>';
        }
        
        if (!empty($item['children'])) {
            $html .= '<ul class="submenu">';
            $html .= build_menu_html($item['children']);
            $html .= '</ul>';
        }
        $html .= '</li>';
    }
    return $html;
}

# This is a helper function for display_html_sitemap.
function get_blog_categories_with_posts() {
    $categories = get_categories(array(
        'orderby' => 'name',
        'order'   => 'ASC'
    ));

    $html = '';
    foreach ($categories as $category) {
        // Fetch published posts under this category
        $posts = get_posts(array(
            'category'    => $category->term_id,
            'numberposts' => -1, // Adjust number of posts to display
            'post_status' => 'publish'
        ));

        if (!empty($posts)) {
            $html .= '<li id="category-' . esc_attr($category->term_id) . '">';
            $html .= '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                $html .= '<ul class="blog-sub-menu">';
                foreach ($posts as $post) {
                    $html .= '<li id="post-' . esc_attr($post->ID) . '">';
                    $html .= '<a href="' . esc_url(get_permalink($post->ID)) . '">' . esc_html($post->post_title) . '</a>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
            $html .= '</li>';
        }
       
    }

    return $html;
}

#helper function for [optin_jump] shortcode
function get_optin_blocks() {
    $blocks = [
        'stay-ahead' => '<div class="stay-ahead"><a href="#top-of-optin" target="_blank">Stay Ahead</a>—Get Essential Resources Delivered To Your Inbox!</div>',
        'stay-ahead-card'    => '<div class="stay-ahead-card"><div class="stay-ahead-card1"> <span class="card-title">Stay Ahead Of The Curve</span> <span class="card-text">Get the resources you need delivered straight to your inbox</span> <a class="card-button" href="#top-of-optin" target="_blank">Sign me Up!</a></div><div class="stay-ahead-card2"><img class="lazy loaded" decoding="async" src="https://appetiser.com.au/wp-content/themes/infinite-child/assets/img/stay-ahead-mail.png" data-src="https://appetiser.com.au/wp-content/themes/infinite-child/assets/img/stay-ahead-mail.png" alt="card-mail"></div></div>',
    ];

    return $blocks;
}

# This is the shortcode function to display cta banners through [optin_jump] shortcode.
function optin_jump_function($atts){
    $attribute = shortcode_atts(array(
		'type' => 'default',  # ['default','roamni']
		'format' => 'default', # ['default','card']
        'style' => 'default', # for backwards compatibility with roamni shortcode
        'layout' => '', # for backwards compatibility with roamni shortcode
	), $atts);

    #shortcode will not display anything if it is not a single post
    if (!is_singular('post')) {
        return ''; // Exit early if not inside a single post
    }

    $style = $attribute['style'];
    $type = $attribute['type'];
	$layout = $attribute['layout'];

    
    if (function_exists('get_field')) {
        $post_id = get_the_ID();
        $format_inline = get_field('format_inline', $post_id);
        $format_card    = get_field('format_card', $post_id);

        if ( ("default" === $type ) && ( ("none" === $format_inline) || ("none" === $format_card) ) ) {
            return ''; // Exit early if type is set to default and no html block is defined
        }
    }else{
        if("default" === $type ){
            return ''; // Exit early if type is set to default and ACF is not active
        }
    }
    
    wp_enqueue_style('shortcodes-css');
    $blocks = get_optin_blocks();
    if( "default" === $attribute['format'] ){
        $html_str = '';
        $html_str .= $blocks[$format_inline];      
        return $html_str;
    }
    if( "card" === $attribute['format'] ){
        $html_str = '';
        $html_str .= $blocks[$format_card];
        return $html_str;
    }
}

function register_optin_jump_assets() {
    $base_uri = get_stylesheet_directory_uri() . '/assets/optin-jump';

    wp_register_style(
        'shortcodes-css',
        $base_uri . '/optin-jump.css',
        array(),
        '1.0.0'
    );
}

# This is the shortcode function to display cta banners through [roamni_banner_cta] shortcode.
function roamni_banner_cta($atts) {
	$a = shortcode_atts(array(
		'style' => 'Default',
		'layout' => '',
	), $atts);

	$style = $a['style'];
	$layout = $a['layout'];

	// Default values
	$inline_title = "Learn What Makes a Profitable and Successful App.";
	$inline_button_text = "Download Case Study";
	$inline_button_link = "#blog-bottom-case-study";

	// ACF check
	if (function_exists('have_rows') && have_rows('inline_cta')) {
		while (have_rows('inline_cta')) {
			the_row();

			$title = get_sub_field('inline_cta_text');
			$button_text = get_sub_field('inline_cta_button_text');
			$button_link = get_sub_field('inline_button_link');

			if ($title) $inline_title = $title;
			if ($button_text) $inline_button_text = $button_text;
			if ($button_link) $inline_button_link = $button_link;
		}
	}

	// Button inline color (same as original)
	if ($style === "Purple") {
		$button_color = 'color:#5F53C0 !important;';
	} elseif ($style === "Black") {
		$button_color = 'color:#000 !important;';
	} else {
		$button_color = 'color:#fff !important;';
	}

	ob_start();
	?>

	<?php if ($layout === "oneline") : ?>
		<div class="banner-cta-inline-oneline <?php echo esc_attr($style); ?> <?php echo esc_attr($layout); ?>" rel="2.0update">
			<div class="banner-text-wrapper">
				<a href="<?php echo esc_url($inline_button_link); ?>" class="banner-button">
					<h3 class="banner-text"><?php echo esc_html($inline_title); ?></h3>
				</a>
			</div>
		</div>
	<?php else : ?>
		<div class="banner-cta-inline <?php echo esc_attr($style); ?> <?php echo esc_attr($layout); ?>" rel="2.0update">
			<div class="banner-text-wrapper">
				<h3 class="banner-text"><?php echo esc_html($inline_title); ?></h3>
			</div>
			<div class="banner-button-wrapper">
				<a href="<?php echo esc_url($inline_button_link); ?>" style="<?php echo esc_attr($button_color); ?>" class="banner-button">
					<?php echo esc_html($inline_button_text); ?>
				</a>
			</div>
		</div>
	<?php endif; ?>

	<?php
	return ob_get_clean();
}

function render_hubspot_tel_form_shortcode($atts) {
    $atts = shortcode_atts(array(
        'portal' => '5769657',
        'id'     => '',
    ), $atts);

    // Validate ID
    if (empty($atts['id'])) {
        return '<p><strong>Invalid Hubspot Form shortcode: Missing ID</strong></p>';
    }

    // Enqueue scripts/styles
    wp_enqueue_style('hbspt-form-style');
    wp_enqueue_style('intltel-inputcss');
    wp_enqueue_script('intltel-input');
    wp_enqueue_script('intltel-init');

    // Build shortcode
    $shortcode = sprintf(
        '[hubspot type="form" portal="%s" id="%s"]',
        esc_attr($atts['portal']),
        esc_attr($atts['id'])
    );

    ob_start();
    echo do_shortcode($shortcode);
    return ob_get_clean();
}


# helper function for hubspot_form render shortcode. this function enqueues the scripts and CSS file needed by the shortcode.
function register_intl_tel_input_assets() {
    $base_uri = get_stylesheet_directory_uri() . '/assets/inttelinput';

    wp_register_style(
        'hbspt-form-style',
        $base_uri . '/hbspt-form-style.css',
        array(),
        '1.0'
    );

    wp_register_style(
        'intltel-inputcss',
        $base_uri . '/intlTelInput.min.css',
        array(),
        '17.0.8'
    );

    wp_register_script(
        'intltel-input',
        $base_uri . '/intlTelInput.min.js',
        array('jquery'),
        '17.0.8',
        true
    );

    wp_register_script(
        'intltel-init',
        $base_uri . '/intl-tel-init.js',
        array('intltel-input'),
        '17.0.8',
        true
    );
}

function appcareer() {
    ob_start();
    ?>  

<div id="recruitee-careers"></div>
      <script type="text/javascript" src="https://d10zminp1cyta8.cloudfront.net/widget.js"></script>
      <script type="text/javascript">
        var widget = new RTWidget({ 
 "companies": [
   73284
 ],
 "detailsMode": "recruitee",
 "language": "en",          
 "departmentsFilter": [],
 "themeVars": { 
   "primary": "#000",
   "secondary": "#0070c9",
   "text": "#5c6f78",
   "textDark": "#37474f",
   "fontFamily": "\"Helvetica Neue\", Helvetica, Arial, \"Lucida Grande\", sans-serif;",
   "baseFontSize": "16px"
 },
 "flags": {
   "showLocation": true,
   "showCountry": true,
   "showCity": true,
   "groupByLocation": false,
   "groupByDepartment": true,
   "groupByCompany": false,
   "showState": false
 }
 });
      </script>
    
    <?php
    return ob_get_clean();
}

//blog taxonomy 
function blog_taxonomy(){
    ob_start();
    $categories = get_categories( array(
        'orderby' => 'name',
        'order'   => 'ASC'
    ) );
    ?>
    <div class="blog-cat">
        <ul>
    <?php 
    foreach( $categories as $category ) {
        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';   
       }       
       ?></ul>
       </div><?php 
    return ob_get_clean();
}

function appetiser_portfoliox(){
   
    $args = array( 
    'post_type' => 'portfolio',     
    'posts_per_page' => -1 ,    
    'post_status'  => 'publish',
    'order'=> 'DESC',
    'post__not_in' => array(3508,3504,3509 ,31256)
    );

    ob_start(); 
?>

    <style>
    #mixit-portfolio{text-align:center}.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-title{font-size:35px;letter-spacing:0}#mixit-portfolio .filter{display:inline-block;font-family:'Helvetica Neue',sans-serif;font-style:normal;font-weight:400;font-size:18px;color:#B0B0B0;padding:12px 20px}#mixit-portfolio .filter.active{background:#E6E6E6!important;color:#111!important;font-weight:500;border-radius:8px}.portfolio-mix .item{min-height:353px}</style>   
    <div class="portfolio-mix gdlr-core-portfolio-item gdlr-core-item-pdb clearfix  gdlr-core-portfolio-item-style-modern-no-space gdlr-core-item-pdlr" style="padding-bottom: 120px ;">

    <div class="filters" id="mixit-portfolio">
        <div class="filter" data-filter="all">All</div>
        <div class="filter" data-filter=".mobile-apps">Mobile </div>
        <div class="filter" data-filter=".webapps">Web</div>
        
    </div>

    <!-- <link href="https://fonts.cdnfonts.com/css/helvetica-neue-5" rel="stylesheet"> -->

    <div class="gdlr-core-portfolio-item-holder gdlr-core-js-2 clearfix" data-layout="fitrows">
    <?php 
    $the_query = new WP_Query( $args ); 
    if ( $the_query->have_posts() ) :
            while ( $the_query->have_posts() ) : $the_query->the_post();	
            // portfolio item
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
            $categories = get_the_terms( get_the_ID(), 'portfolio_category' );
        
            ?>
            <div class="gdlr-core-item-list  gdlr-core-column-20  item <?php 
            
                $terms = get_the_terms( $the_query->ID, 'portfolio_category' );

                foreach($terms as $term){
                echo $term->slug." ";
                }
            #echo get_the_term_list( $the_query->ID, 'portfolio_category', ); 
            ?>	">
                
                
                <div class="gdlr-core-portfolio-modern">
                    <div class="gdlr-core-portfolio-thumbnail gdlr-core-media-image  gdlr-core-style-title 	">
                        <div class="gdlr-core-portfolio-   thumbnail-image-wrap ">
                        <a href="<?php the_permalink() ?>">
                            
                            <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail(array(700, 600));
                            }	
                            else {
                            }
                            ?>
                            
                            
                            <span class="gdlr-core-image-overlay  gdlr-core-portfolio-overlay gdlr-core-image-overlay-center-icon gdlr-core-js" style="background: rgba(102, 161, 202, 0.55) ;"><span class="gdlr-core-image-overlay-content" style="margin-top: -28px;"><span class="gdlr-core-portfolio-title gdlr-core-title-font " style="text-transform: none ;"><?php echo the_title();?>
                            
                            
                            </span></span></span>
                        </a>	
                        </div>
                    </div>
                </div>	
            </div>
            
            <?php 
            // 
                
                endwhile;
                wp_reset_postdata();
        else:
    //
    endif;
    ?>
    </div>
    </div>

    
    <?php 
    return ob_get_clean();
}
    
// for deprecation pending 86erd7p2q
function legacy_banner_cta($atts){
	$a = shortcode_atts( array(
		'style' => 'Default',
		'layout' => '',
	), $atts );
	
	if(!empty($a['style'])){
		$style=$a['style'];
	}else {
		$style="";
	}
	
	ob_start();
	$inline_title = "Learn What Makes a Profitable and Successful App.";
	$inline_button_text = "Download Case Study";
	$inline_button_link="#blog-bottom-case-study";
	//$colors="";
	
	if( have_rows('inline_cta') ){
		while( have_rows('inline_cta') ){
                the_row();
                $inline_title = get_sub_field('inline_cta_text');
                $inline_button_text = get_sub_field('inline_cta_button_text');
                $inline_button_link=get_sub_field('inline_button_link');
                
                if (get_sub_field('inline_cta_text')){
                    $inline_title = get_sub_field('inline_cta_text');
                }
                else {
                    $inline_title = "Learn What Makes a Profitable and Successful App.";
                }
                
                
                if (get_sub_field('inline_cta_button_text')){
                    $inline_button_text = get_sub_field('inline_cta_button_text');
                }
                else {
                    $inline_button_text = "Download Case Study";
                }
                
                if (get_sub_field('inline_button_link')){
                    $inline_button_link=get_sub_field('inline_button_link');
                }
                else {
                    $inline_button_link="#blog-bottom-case-study";
                }	
            }
        	}else {
	        }			
            if ($style=="Purple"){
                $button_color = 'color:#5F53C0 !important;';
            }elseif ($style=="Black"){
                $button_color = 'color:#000 !important;';
            }else {
                $button_color="color:#fff !important;";
            }
            
            
            ?>
			<?php 
			if($a['layout']=="oneline"){
				?>
				<div class="banner-cta-inline-oneline <?php echo $style;?> <?php echo $a['layout'];?> ">
					<div class="banner-text-wrapper"> 
						<a href="<?php echo $inline_button_link;?>" style="" class="banner-button">
							<h3 class="banner-text"> <?php echo $inline_title;?></h3>
						</a>
					</div> 
				</div>
				<?php 
			}else {			
				?>
				<div class="banner-cta-inline <?php echo $style;?> <?php echo $a['layout'];?> ">
					<div class="banner-text-wrapper"> 
						<h3 class="banner-text"> <?php echo $inline_title;?></h3>
					</div> 					
					<div class="banner-button-wrapper">
					<a href="<?php echo $inline_button_link;?>" style="<?php echo $button_color;?>"  class="banner-button"> <?php echo $inline_button_text;?> </a> 
					</div>
				</div>
				<?php 
			}		
			?>
	<?php 
	$outputx = ob_get_clean();
	//ob_flush();
	
	return $outputx;
}

function single_social($atts) {
    if(is_single()){
    ob_start(); // Start output buffering
      
    ?>
	<div class="infinite-sidebar-centerx infinite-column-5x infinite-line-heightx"  id="single-social-sharex" >

	<h3 class="share-title"> Share this post</h3>
    <?php
    // social share
        if( infinite_get_option('general', 'blog-social-share', 'enable') == 'enable' ){
            if( class_exists('gdlr_core_pb_element_social_share') ){
                $share_count = (infinite_get_option('general', 'blog-social-share-count', 'enable') == 'enable')? 'counter': 'none';

                echo '<div class="infinite-single-social-share infinite-item-rvpdlr share-social-icons" >';
                echo gdlr_core_pb_element_social_share::get_content(array(
                    'social-head' => $share_count,
                    'layout'=>'left-text', 
                    'text-align'=>'center',
                    'facebook'=>infinite_get_option('general', 'blog-social-facebook', 'enable'),
                    'linkedin'=>infinite_get_option('general', 'blog-social-linkedin', 'enable'),
                    'google-plus'=>infinite_get_option('general', 'blog-social-google-plus', 'enable'),
                    'pinterest'=>infinite_get_option('general', 'blog-social-pinterest', 'enable'),
                    'stumbleupon'=>infinite_get_option('general', 'blog-social-stumbleupon', 'enable'),
                    'twitter'=>infinite_get_option('general', 'blog-social-twitter', 'enable'), //elon musk
                    'email'=>infinite_get_option('general', 'blog-social-email', 'enable'),
                    'padding-bottom'=>'0px'
                ));
                echo '</div>';
            }
        }
        ?></div>	
	    <?php 
        echo do_shortcode('[simple-author-box]');
        $outputx = ob_get_clean(); // Get the buffered content and clean the buffer
   
    return $outputx;
    }
}