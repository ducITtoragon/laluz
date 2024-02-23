<?php

/**
 * The template for displaying page template.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
while (have_posts()) :
    the_post();
?>
    <main class="main spc-hd spc-hd-2">
        <?php if (is_cart() || is_checkout()) { ?>
            <section class="main-default-page">
                <div class="container mona-content">
                    <?php the_content(); ?>
                </div>
            </section>
        <?php } else { ?>
            <section class="nav-bread">
                <div class="container">
                    <?php get_template_part('partials/breadcrumb') ?>
                </div>
            </section>
            <section class="blog-dt-sect">
                <div class="container">
                    <div class="blog-inner">
                        <div class="wr-mid">
                            <div class="inner">
                                <div class="tt-blog-main">
                                    <?php the_title(); ?>
                                </div>
                                <div class="desc-blog mona-content">
                                    <?php the_content(); ?>
                                </div>
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
