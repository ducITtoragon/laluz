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
                            <div class="date"> <img
                                    src="<?php echo MONA_HOME_URL ?>/template/assets/images/ic-clock.svg" alt="" />
                                <?php the_date() ?>
                            </div>
                            <div class="desc-blog mona-content">
                                <?php the_content() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
endwhile;
get_footer();