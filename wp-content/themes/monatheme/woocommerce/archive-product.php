<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header();
$image_product = mona_get_option('image_product');
$sc_product_page = get_field('sc_product_page', MONA_PAGE_HOME);

$product_count = wp_count_posts('product');
$total_products = $product_count->publish;

if (is_tax()) {
    $ob = get_queried_object();
    $product_count = $ob->count;
} else {
    $product_query = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    ));

    $product_count = $product_query->post_count;
}

$action_layout      = 'reload'; // loadmore / reload
$count = 15;
$paged = max(1, get_query_var('paged'));
$offset = ($paged - 1) * $count;
$post_type          = 'product';

$args = array(
    'post_type'      => $post_type,
    'post_status' => 'publish',
    // 'orderby' => 'title',
    'posts_per_page' => $count,
    'offset'         => $offset,
    'paged'          => $paged,
    'meta_query'     => [
        'relation' => 'AND',
    ],
    'tax_query'      => [
        'relation' => 'AND',
    ],
);


if (is_tax()) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => $ob->taxonomy,
            'field' => 'slug',
            'terms' => $ob->slug,
            'include_children' => false,
        ),
    );
}

$wp_query = new WP_Query($args);
?>

<main class="main spc-hd spc-hd-2">
    <section class="nav-bread">
        <div class="container">
            <?php get_template_part('/partials/breadcrumb', ''); ?>
        </div>
    </section>

    <form id="formPostAjax" data-layout="<?php echo $action_layout; ?>">
        <input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
        <input type="hidden" name="posts_per_page" value="<?php echo $count; ?>" />
        <?php if (is_tax()) {
            $current_cat = get_queried_object(); ?>
            <input type="hidden" name="taxonomies[<?php echo $current_cat->taxonomy; ?>][]" value="<?php echo $current_cat->slug ?>" />
        <?php } ?>

        <section class="prods-sect">
            <div class="container-laluz">
                <div class="prods-sect-inner row">

                    <!-- thương hiệu  -->
                    <?php
                    $parent_cat_thuong_hieu = get_terms(array(
                        'taxonomy' => 'category_thuong_hieu',
                        'parent' => 0,
                        'hide_empty' => false,
                    ));

                    if (!empty($parent_cat_thuong_hieu) || isset($parent_cat_thuong_hieu)) {
                        $child_cats_thuong_hieu = get_terms([
                            'taxonomy'   => 'category_thuong_hieu',
                            'parent'     => $parent_cat_thuong_hieu->term_id,
                            'hide_empty' => false,
                        ]);

                        if (!empty($child_cats_thuong_hieu) || isset($child_cats_thuong_hieu)) { ?>

                            <div class="wr-filter col col-md-3">
                                <div class="inner">
                                    <div class="tt-filter">
                                        <?php echo $child_cat->name; ?>
                                        <span class="ic-close"> <i class="fa-solid fa-xmark"></i></span>
                                    </div>
                                    <div class="nav-brand">

                                        <input class="b-rds filter-search monaFilterJS-input" type="text" placeholder="Tìm theo thương hiệu">

                                        <div id="MonaThuongHieu">

                                            <div class="filter-list row">
                                                <?php foreach ($child_cats_thuong_hieu as $child_cat) { ?>

                                                    <div class="filter-item col">
                                                        <label for="<?php echo $child_cat->slug; ?>">
                                                            <input type="radio" name="taxonomy_thuong_hieu[<?php echo $child_cat->taxonomy ?>][]" id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS" value="<?php echo $child_cat->slug ?>" hidden>
                                                            <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                                                        </label>
                                                    </div>


                                                <?php } ?>

                                            </div>

                                        </div>
                                    </div>

                            <?php }
                    } ?>

                            <!-- fillter product -->
                            <?php get_template_part('partials/product/filter'); ?>
                                </div>

                                <div class="btn btn-flt b-rds"><i class="fa-solid fa-angle-left"></i></div>

                            </div>

                            <div class="wr-prods col col-md-9">
                                <div class="prod-heading">
                                    <h1 class="tt-sec">
                                        <?php
                                        if (is_tax('category_thuong_hieu')) {
                                            $current = get_queried_object();
                                            echo $current->name;
                                        } elseif (is_tax('category_nuoc_hoa')) {
                                            $current = get_queried_object();
                                            echo $current->name;
                                        } elseif (is_tax('category_nhom_huong')) {
                                            $current = get_queried_object();
                                            echo $current->name;
                                        } elseif (is_tax('category_nong_do')) {
                                            $current = get_queried_object();
                                            echo $current->name;
                                        } elseif (is_tax('category_dung_tich')) {
                                            $current = get_queried_object();
                                            echo $current->name;
                                        } elseif (is_archive('product')) {
                                            echo 'Sản phẩm';
                                        }
                                        ?>
                                    </h1>

                                    <div class="prod-heading-right">
                                        <div class="box-op b-rds">
                                            <select class="prod-all-filter-js prod-op monaFilterJS" name="sort" id="sort">
                                                <option value="az" id="az">
                                                    <?php _e('Mới nhất', 'monamedia') ?>
                                                </option>

                                                <option value="za" id="za">
                                                    <?php _e('Cũ nhất', 'monamedia') ?>
                                                </option>

                                                <option value="hightolow" id="hightolow">
                                                    <?php _e('Giá cao - thấp', 'monamedia') ?>
                                                </option>

                                                <option value="lowtohigh" id="lowtohigh">
                                                    <?php _e('Giá thấp - cao', 'monamedia') ?>
                                                </option>
                                            </select>
                                        </div>
                                        <div class="btn btn-flt b-rds">
                                            <img src="<?php get_site_url(); ?>/template/assets/images/ic-filter.svg" alt="" />
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if (is_tax()) {
                                    $top_contents = get_field('mona_tax_top_contents', get_queried_object());
                                    if (!empty($top_contents)) {
                                ?>
                                        <div class="mona-content top-content show-hide-content">
                                            <?php echo $top_contents; ?>
                                            <div class="ico-show-hide js-show-hide">
                                                <span><?php _e('Xem thêm', 'monamedia') ?></span>
                                            </div>
                                        </div>
                                <?php }
                                } ?>

                                <!-- list product  -->
                                <?php if ($wp_query->have_posts()) { ?>

                                    <div class="prod-list row monaPostsList is-loading-group">

                                        <?php while ($wp_query->have_posts()) :
                                            $wp_query->the_post(); ?>

                                            <div class="prod-it">
                                                <?php get_template_part('partials/product/item');  ?>
                                            </div>

                                        <?php endwhile;
                                        wp_reset_postdata(); ?>

                                        <?php if ($action_layout == 'reload') { ?>

                                            <?php mona_pagination_links_ajax($wp_query, $paged); ?>



                                        <?php } ?>

                                    <?php } else { ?>
                                        <div class="prod-list row monaPostsList is-loading-group">

                                            <div class="container">
                                                <a href="<?php echo site_url('product/') ?>" class="empty-product">
                                                    <div class="image-empty-product">
                                                        <img src="<?php get_site_url(); ?>/template/assets/images/empty-product-1.png" alt="this is a image of empty product">
                                                    </div>
                                                    <p class="text">
                                                        <?php _e('Hiện tại, sản phẩm bạn đang tìm kiếm không tồn tại. Vui lòng quay lại sau hoặc liên hệ với chúng tôi', 'monamedia'); ?>
                                                    </p>
                                                    <a class="btn noic product-empty-button" href="<?php echo site_url('product/') ?>">
                                                        <span class="txt">
                                                            <?php _e('Cửa hàng', 'monamedia') ?>
                                                        </span>
                                                    </a>
                                                </a>
                                            </div>
                                        <?php } ?>

                                        </div>

                                        <?php
                                        if (!empty($ob->description)) { ?>

                                            <div class="prod-intro mona-content bottom-content">
                                                <?php echo $ob->description; ?>
                                            </div>

                                            <div class="btn btn-load-more b-rds see-more"><?php _e('Xem thêm', 'monamedia') ?></div>
                                            <div class="btn btn-load-more b-rds less-more"><?php _e('Rút gọn', 'monamedia') ?></div>
                                        <?php
                                        }
                                        ?>

                                    </div>

                            </div>
                </div>
                <div class="bn-sect">
                    <?php
                    $mona_footer_images = get_field('mona_footer_images', MONA_PAGE_HOME);
                    echo wp_get_attachment_image($mona_footer_images, 'full') ?>
                </div>
        </section>

    </form>
</main>

<?php
get_footer();
