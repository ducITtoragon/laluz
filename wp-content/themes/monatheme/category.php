<?php

/**
 * The template for displaying category.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();
$ob = get_queried_object();
$mona_breadcrumbs_images = get_field('mona_breadcrumbs_images', 'category_' . $ob->term_id);
$mona_footer_images = get_field('mona_footer_images', MONA_PAGE_HOME);
?>

<main class="main spc-hd spc-hd-2">
	<section class="banner-section">
		<div class="bg">
			<?php echo wp_get_attachment_image($mona_breadcrumbs_images, 'full') ?>
			<h1 class="tt-bn">
			<?php if (empty($ob)) { ?>
                        <?php _e('Tin tức', 'monamedia'); ?>
                    <?php } else { ?>
                        <?php echo $ob->name;  ?>
                    <?php } ?>		
		</h1>
		</div>
	</section>
	<section class="nav-bread">
		<div class="container">
			<?php get_template_part('partials/breadcrumb') ?>
		</div>
	</section>
	<section class="blogs-sect ">
		<div class="container">
			<div class="blogs-hd">
				<div class="topic-list">
					<?php
					$category = get_terms(
						array(
							'taxonomy' => 'category',
							'hide_empty' => false, // Lấy cả các danh mục không có bài viết

						)
					);
					if (!empty($category)) {
						foreach ($category as $key => $item) { ?>

							<a class="topic-it  b-rds  <?php echo $item->slug == $ob->slug ? 'active-btn-topic' : ''  ?>" href="<?php echo get_term_link($item) ?>"><?php echo $item->name ?></a>
					<?php }
					} ?>

				</div>
			</div>
			<?php

			$count = 12;
			$paged = max(1, get_query_var('paged'));
			$offset = ($paged - 1) * $count;
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $count,
				'offset'         => $offset,
				'paged'          => $paged,
				'category_name'  => $ob->name
			);

			$query = new WP_Query($args);
			if ($query->have_posts()) {   ?>
				<div class="wr-blogs">
					<div class="blog-list  row">

						<?php
						while ($query->have_posts()) {
							$query->the_post();
							global $post;
						?>

							<div class="blog-it col-6 col-md-4">
								<?php get_template_part('partials/loop/box-blog') ?>
							</div>
						<?php }
						wp_reset_query($query); ?>
					</div>

					<div class="pagi-num">
						<?php echo  mona_pagination_links($query) ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
	<div class="bn-sect">
		<?php echo wp_get_attachment_image($mona_footer_images, 'full') ?>
	</div>
	
</main>

<?php get_footer();
