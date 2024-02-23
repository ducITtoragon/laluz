<?php

/**
 * The template for displaying single.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
while (have_posts()) :
    the_post();
    mona_set_post_view();

    $mona_blog_detail_images = get_field('mona_blog_detail_images', MONA_PAGE_HOME)
?>
    <main class="main spc-hd spc-hd-2">
        <section class="nav-bread">
            <div class="container">
                <?php get_template_part('partials/breadcrumb') ?>
            </div>
        </section>
        <section class="blog-dt-sect tabJS">
            <div class="container">
                <div class="blog-inner">
                    <div class="row">
                        <div class="wr-left col col-lg-3">
                            <div class="box-info">
                                <div class="tt">Nội dung</div>
                                <div class="tocview">
                                    <?php echo do_shortcode('[ez-toc]') ?>
                                </div>
                                <button class="btn-bars"><i class="fa-solid fa-bars"></i></button>
                            </div>
                            <div class="box-mail blog">

                                <div class="tt">Đăng ký nhận tin </div>
                                <?php echo do_shortcode('[contact-form-7 id="d78bc8e" title="Fomr page chi tiết bài viết"]') ?>

                            </div>
                        </div>

                        <div class="wr-mid tabPanel col col-lg-6">
                            <div class="inner">
                                <h1 class="tt-blog-main">
                                    <?php echo get_the_title()   ?>
                                </h1>
                                <div class="date"> <img src="<?php echo MONA_HOME_URL ?>/template/assets/images/ic-clock.svg" alt="" />
                                    <?php the_date() ?>
                                </div>
                                <div class="desc-blog mona-content">
                                    <?php the_content() ?>
                                </div>
                            </div>
                        </div>
                        <div class="wr-right col col-lg-3">
                            <?php $category = get_terms(
                                array(
                                    'taxonomy' => 'category',
                                    'hide_empty' => false, // Lấy cả các danh mục không có bài viết

                                )
                            );
                            if (!empty($category)) { ?>
                                <div class="box-info">
                                    <div class="tt">Danh mục bài viết </div>
                                    <ul class="info-list">
                                        <?php

                                        foreach ($category as $key => $item) { ?>
                                            <a class="info-item " href="<?php echo get_term_link($item) ?>">
                                                <p class="txt"> <?php echo $item->name ?></p>
                                            </a>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="banner-side">
                                <?php if (!empty($mona_blog_detail_images)) { ?>
                                    <?php echo wp_get_attachment_image($mona_blog_detail_images, 'full') ?>
                                <?php } else { ?>
                                    <img src="<?php echo MONA_HOME_URL ?>/template/assets/images/banner-blog.png" alt="" />
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-social">
                    <?php get_template_part('partials/social-share'); ?>
                </div>
            </div>
        </section>
        <?php

        $args = array(
            'post_type' => ' post',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'orderby' => 'date',
            'order' => 'DESC',
            'post__not_in' => array($ob->ID)

        );

        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
        ?>
            <section class="related-posts">
                <div class="container">
                    <div class="inner">
                        <div class="tt-sec">Bài viết liên quan</div>
                        <div class="wr-posts">
                            <div class="posts-list row">
                                <?php

                                while ($the_query->have_posts()) {
                                    $the_query->the_post();
                                    global $post;

                                ?>
                                    <div class="posts-item col-6 col-sm-4 col-lg-3">

                                        <a class="img-posts" href="<?php echo get_the_permalink($post->ID); ?>">
                                            <?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
                                        </a>
                                        <h3 class="tt">
                                            <a class="tt-link" href="<?php echo get_the_permalink($post->ID); ?>">
                                                <?php echo $post->post_title ?>
                                            </a>
                                        </h3>
                                    </div>
                                <?php }
                                wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>
    </main>
<?php
endwhile;
get_footer();
