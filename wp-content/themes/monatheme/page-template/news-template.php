<?php

/**
 * Template name: News
 * @author : MONA.Media / Website
 */
get_header();
while (have_posts()) :
    the_post();

    $ob = get_queried_object();
    $mona_breadcrumbs_images = get_field('mona_breadcrumbs_images', 'category_' . $ob->term_id);
    $mona_footer_images = get_field('mona_footer_images', MONA_PAGE_HOME);
?>

    <main class="main spc-hd spc-hd-2">
        <section class="banner-section">
            <div class="bg">
                <?php if (isset($mona_breadcrumbs_images) || !empty($mona_breadcrumbs_images)) { ?>
                    <?php echo wp_get_attachment_image($mona_breadcrumbs_images, 'full') ?>
                <?php } else { ?>
                    <img src="<?php get_site_url(); ?>/template/assets/images/bn-sect-1.png" alt="" />
                <?php } ?>
                <h1 class="tt-bn">
                <?php _e('Tin tức', 'monamedia'); ?>
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

                $count = 9;
                $paged = max(1, get_query_var('paged'));
                $offset = ($paged - 1) * $count;
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $count,
                    'offset'         => $offset,
                    'paged'          => $paged,
                    // 'category_name'  => $ob->name
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

<?php
endwhile;
get_footer();
