<?php

/**
 * The template for displaying search.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
$search_query = isset($_GET['s']) ? $_GET['s'] : '';
$category_slug = isset($_GET['category']) ? $_GET['category'] : '';

$count = 10;
$paged = max(1, get_query_var('paged'));
$offset = ($paged - 1) * $count;
$taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : '';

$args = array(
    's' => $search_query,
    'post_type' => array('product'),
    'posts_per_page' => $count,
    'offset'         => $offset,
    'paged'          => $paged,
);

if (!empty($category_slug)) {
    $category = get_term_by('slug', $category_slug, 'product_cat');
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $category_slug,
        ),
    );
}

$search_query = new WP_Query($args);
$count = $search_query->found_posts;
?>
<main class="main spc-hd spc-hd-2">
    <section class="nav-bread">
        <div class="container">
            <?php get_template_part('/partials/breadcrumb', ''); ?>
        </div>
    </section>

    <section class="prods-sect">
        <div class="container-laluz">
            <div class="prods-sect-inner row">
                <div class="wr-prods col col-md-12">

                    <!-- list product  -->
                    <?php if ($search_query->have_posts()) { ?>

                    <div class="prod-list row monaPostsList is-loading-group">

                        <?php while ($search_query->have_posts()) :
                                $search_query->the_post(); ?>

                        <div class="prod-it">
                            <?php get_template_part('partials/product/item');  ?>
                        </div>

                        <?php endwhile;
                            wp_reset_postdata(); ?>


                        <div class="pagi-num pagination">
                            <?php mona_pagination_links($search_query); ?>
                        </div>

                        <?php } else { ?>
                        <div class="container">
                            <a href="<?php echo home_url(); ?>" class="empty-product">
                                <div class="image-empty-product">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/findnotfound.png"
                                        alt="this is a image of empty product">
                                </div>
                                <p class="text">
                                    <?php _e('Hiện tại không có sản phẩm phù hợp với từ khóa của bạn, vui lòng quay lại sau hoặc tiếp tục mua sắm.', 'monamedia'); ?>
                                </p>
                                <a class="btn-sreach noic product-empty-button" href="<?php echo home_url(); ?>">
                                    <span class="txt">
                                        <?php _e('Trang chủ', 'monamedia') ?>
                                    </span>
                                </a>
                            </a>
                        </div>
                        <?php } ?>

                    </div>
                </div>

            </div>
        </div>
        <div class="bn-sect">
            <?php
            $mona_footer_images = get_field('mona_footer_images', MONA_PAGE_HOME);
            echo wp_get_attachment_image($mona_footer_images, 'full') ?>
        </div>
    </section>

</main>
<?php get_footer();