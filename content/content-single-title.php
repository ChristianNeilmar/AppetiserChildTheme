<?php

/**
 * The template part for displaying single post title
 */
$post_id = get_the_ID();
$taxonomy = array('category');

$reading_duration = get_field('post_reading_duration', $post_id);
$post_terms = array();

// Post Content Metadata
$peer_review = get_post_meta($post_id, 'peer_review', true);
$contributors = get_post_meta($post_id, 'contributors', true);
$last_updated = get_the_modified_date('F j, Y');


for ($i = 0; $i < count($taxonomy); $i++) {
	$term_list = wp_get_post_terms($post_id, $taxonomy[$i], array("fields" => "all"));
	foreach ($term_list as $temp_term) {
		$term_link = get_term_link($temp_term);
		$post_terms[] = '<a href="' . esc_url($term_link) . '" rel="' . $taxonomy[$i] . '">' . $temp_term->name . '</a>';
	}
}

echo '<header class="infinite-single-article-head clearfix" >';
$blog_date = infinite_get_option('general', 'blog-date-feature', '');

if (empty($blog_date) || $blog_date == 'enable') {
	echo '<div class="infinite-single-article-date-wrapper">';
	echo '<div class="infinite-single-article-date-day">' .  get_the_time('d') . '</div>';
	echo '<div class="infinite-single-article-date-month">' . get_the_time('M') . '</div>';

	$blog_date_year = infinite_get_option('general', 'blog-date-feature-year', '');
	if (!empty($blog_date_year) && $blog_date_year == 'enable') {
		echo '<div class="infinite-single-article-date-year">' . get_the_time('Y') . '</div>';
	}
	echo '</div>';
}

echo '<div class="infinite-single-article-head-right">';
if (is_single()) {

	echo '<h1 class="infinite-single-article-title">' . get_the_title() . '</h1>';
} else {
	echo '<h3 class="infinite-single-article-title"><a href="' . get_permalink() . '" >' . get_the_title() . '</a></h3>';
}

$single_blog_meta = infinite_get_option('general', 'meta-option', '');
if (empty($blog_date) && empty($single_blog_meta)) {
	$single_blog_meta = array('author', 'category', 'tag', 'comment-number');
}
/*echo infinite_get_blog_info(array(
		'display' => $single_blog_meta,
		'wrapper' => true
	));  */
?>


<div class="article-tax">
	<div class="article-tax-term">
		<?php if ($post_terms) echo implode($post_terms); ?>
	</div>

	<div class="article-tax-reading-duration">
		<span style="width: 18px; height: 18px;">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/icon/Clock-Circle.svg" alt="Clock Icon" width="18" height="18"></span>
		<?php if ($reading_duration) echo '<span>' . $reading_duration . ' read</span>'; ?>
	</div>
</div>

<div class="infinite-blog-info-wrapper infinite-single-author-top infinite-single-author">
	<div class="infinite-blog-info infinite-blog-info-font">
		<div class="avatar">
			<span class="infinite-head">
				<?php echo '<div class="infinite-single-author-avartar infinite-media-image">' . get_avatar(get_the_author_meta('ID'), 40) . '</div>'; ?>
			</span>
		</div>
		<div class="article-author-tax">
			<span class="infinite-blog-info-author  article-author"><?php the_author_posts_link(); ?></span>
			<span class="article-author-label">Author</span>
		</div>
	</div>
</div>
<div class="content-metadata">
	<?php if (!empty($peer_review)) : ?>
		<p class="peer-review">
			<span>Peer reviewed by: </span><?php echo esc_html($peer_review); ?>
		</p>
	<?php endif; ?>
	<?php if (!empty($contributors)) : ?>
		<p class="contributors">
			<span>Contributors: </span><?php echo esc_html($contributors); ?>
		</p>
	<?php endif; ?>
	<p class="last-updated">
		<span>Last Updated: </span><?php echo esc_html($last_updated); ?>
	</p>
</div>
<?php
echo '</div>';
echo '</header>';
