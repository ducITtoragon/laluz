<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

use YoastSEO_Vendor\WordProof\SDK\Support\Template;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header('shop');

global $post;
$product_id     = $post->ID;
$product_obj  = wc_get_product($product_id);
$product_type = $product_obj->get_type();

$ratingScore = get_rating_score($product_id);
$percentages = ($ratingScore) * 20;
$percentage = max(0, min(100, $percentages));


while (have_posts()) :
    the_post();
    do_action('woocommerce_before_single_product');

    if (post_password_required()) {
        echo get_the_password_form(); // WPCS: XSS ok.
        return;
    }
    $percent_sale = get_field('sale_price_product', $product_id);
    $mona_product = new MonaProductClass();
    if ($product_obj->is_type('variable')) {
        $variation_ids = $product_obj->get_children();
        if (count($variation_ids) > 0) {
            $variation_id = reset($variation_ids);
            $_product = new WC_Product_Variation($variation_id);
            if ($product->get_price() == 0) {
                $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
            } else {
                $price_html = $mona_product->price_single_variation_html($product_obj);
            }
        }
    } else {
        if ($product->get_price() == 0) {
            $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
        } else {
            $price_html = $product->get_price_html();
        }
    }
    if ($product_type == 'variable') {
        $default_attributes = $product_obj->get_default_attributes();
        if (!empty($default_attributes)) {
            $default_attributes_offcial = [];
            foreach ($default_attributes as $key_default_attribute => $default_attribute) {
                $default_attributes_offcial['attribute_' . $key_default_attribute] = $default_attribute;
            }
            $default_variation_id = MonaProductVariations::findVariationId($product_id, $default_attributes_offcial);
        } else {
            $default_variation_id = $product_id;
        }
    }

    $sc_1_information = get_field('sc_1_information', $post);
    $thuong_hieu = $sc_1_information['thuong_hieu'];
    $link_thuong_hieu = $sc_1_information['link'];
    $nong_do = $sc_1_information['nong_do'];
    $do_luu_mui = $sc_1_information['do_luu_mui'];
    $do_toa_huong = $sc_1_information['do_toa_huong'];
    $gioi_tinh = $sc_1_information['gioi_tinh'];
    $icon_1 = $sc_1_information['icon_1'];
    $icon_2 = $sc_1_information['icon_2'];
    $icon_3 = $sc_1_information['icon_3'];
    $icon_4 = $sc_1_information['icon_4'];
    $icon_5 = $sc_1_information['icon_5'];
    $link_shoppe = $sc_1_information['link_shoppe'];

    $cls = m_get_active_wishlist($product_id);
    if ($cls == "") {
        $cls = "m_add_login";
    }
?>

<main class="main spc-hd spc-hd-2">
    <section class="nav-bread">
        <div class="container">
            <?php get_template_part('/partials/breadcrumb', ''); ?>
        </div>
    </section>
    <section class="prod-dt">
        <div class="container">
            <div class="prod-dt-inner">

                <form id="frmAddProduct">
                    <input type="hidden" name="product_id" value="<?php echo $product_id ?>">

                    <div class="row">
                        <?php
                            if (!empty($sc_1_information)) {
                                $classMain = '';
                            } else {
                                $classMain = '';
                            }
                            ?>
                        <div id="product-<?php the_ID(); ?>"
                            <?php wc_product_class('prod-dt-left col col-lg-8' . $classMain, $product); ?>>
                            <div class="prod-dt-left-it col-6" id="monaGalleryProduct">
                                <?php
                                    $productId = $product_type == 'variable' ? $default_variation_id : $product_id;
                                    echo (new MonaProductClass())->GalleryProduct($productId);
                                    ?>
                            </div>


                            <div class="prod-dt-left-it col-6">
                                <h1 class="tt-prod-dt"><?php echo $product_obj->get_title(); ?></h1>
                                <div class="rating-info">
                                    <div class="star">
                                        <div class="star-list">
                                            <div class="star-flex star-empty"><i class="fa-regular fa-star icon"></i><i
                                                    class="fa-regular fa-star icon"></i><i
                                                    class="fa-regular fa-star icon"></i><i
                                                    class="fa-regular fa-star icon"></i><i
                                                    class="fa-regular fa-star icon"></i></div>
                                            <div class="star-flex star-filter"
                                                style="width: <?php echo $percentage; ?>%;"><i
                                                    class="fa-solid fa-star icon"></i><i
                                                    class="fa-solid fa-star icon"></i><i
                                                    class="fa-solid fa-star icon"></i><i
                                                    class="fa-solid fa-star icon"></i><i
                                                    class="fa-solid fa-star icon"></i></div>
                                        </div>
                                    </div>

                                    <span class="txt-rvw">
                                        <?php echo get_comments_number();
                                            _e(' đánh giá', 'monamedia'); ?> </span>

                                    <?php
                                        $product_categories = wp_get_post_terms($product_id, 'category_gioi_tinh', array('fields' => 'ids'));
                                        $gender_term = get_term($product_categories[0]);
                                        ?>

                                    <span class="gender-prod <?php if ($gender_term->name === 'Nam') {
                                                                        echo 'men';
                                                                    } elseif ($gender_term->name === 'Nữ') {
                                                                        echo 'girl';
                                                                    } else {
                                                                        echo 'unisex';
                                                                    } ?>">
                                        <?php echo $gender_term->name; ?>
                                    </span>

                                </div>

                                <!-- wish list  -->
                                <?php
                                    if (is_user_logged_in()) { ?>
                                <a class="add-favo <?php echo $cls; ?> is-loading-group"
                                    data-key="<?php echo get_the_ID(); ?>">

                                    <img src="<?php get_site_url(); ?>/template/assets/images/ic-heart.svg" alt="" />

                                    <span class="txt">
                                        <?php _e('Thêm vào yêu thích', 'monamedia') ?>
                                    </span>
                                </a>
                                <?php } else { ?>
                                <a class="add-favo" href="<?php echo site_url('login/'); ?>">

                                    <img src="<?php get_site_url(); ?>/template/assets/images/ic-heart.svg" alt="" />

                                    <span class="txt">
                                        <?php _e('Thêm vào yêu thích', 'monamedia') ?>
                                    </span>
                                </a>
                                <?php }
                                    ?>


                                <!-- price  -->
                                <div class="price-prod" id="monaPriceProduct">
                                    <?php
                                        $productId = $product_type == 'variable' ? $default_variation_id : $product_id;
                                        echo (new MonaProductClass())->PriceProduct($productId);
                                        ?>
                                </div>

                                <?php if ($product_obj->get_type() == 'variable') { ?>
                                <div class="box-options" id="monaAttriColor">
                                    <?php
                                            echo (new MonaProductVariations())::setProId(get_the_ID())->Variations_html();
                                            ?>
                                </div>
                                <?php } ?>

                                <div class="quantity-prod">
                                    <span class="txt"><?php _e('Số lượng: ', 'moanmedia') ?></span>
                                    <div class="box-quantity">
                                        <button class="minus" type="button"><?php _e('-', 'moanmedia') ?></button>
                                        <input class="ip-value" type="text" value="1" min="1" max="1000"
                                            name="quantity">

                                        <p class="count-number number-change">1</p>
                                        <button class="plus" type="button"><?php _e('+', 'moanmedia') ?></button>
                                    </div>
                                </div>


                                <div class="btn-list">

                                    <div class="btn-item">

                                        <button class="btn btn-pri mona-add-to-cart-detail"
                                            data-cookie="<?php echo $product_id ?>">
                                            <div class="is-loading-group">
                                                <span class="txt">
                                                    <?php _e('Thêm vào giỏ hàng', 'monamedia'); ?>
                                                </span>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="btn-item m-buy-now">
                                        <button class="btn btn-second is-loading-group">
                                            <span class="txt"><?php _e('Mua ngay', 'monamedia'); ?>
                                            </span>
                                        </button>
                                    </div>

                                    <?php if (!empty($link_shoppe)) : ?>
                                    <div class="btn-item">
                                        <a href="<?php echo esc_url($link_shoppe) ?>" class="btn btn-third">
                                            <img src="<?php get_site_url(); ?>/template/assets/images/shoppe.png"
                                                alt="" />
                                        </a>
                                    </div>
                                    <?php endif; ?>


                                </div>
                                <div class="btn-list btn-list-mb">

                                    <?php if ($product_obj->get_type() == 'variable') { ?>
                                    <button class="btn add-cart mona-add-to-cart-detail"
                                        data-cookie="<?php echo $product_id ?>">
                                        <?php } else { ?>
                                        <button class="btn add-cart m-add-to-cart-flash"
                                            data-product-id="<?php echo $product_id; ?>">
                                            <?php
                                            } ?>
                                            <div class="is-loading-group">
                                                <img src="<?php get_site_url(); ?>/template/assets/images/ic-cart.svg"
                                                    alt="" />
                                            </div>
                                        </button>

                                        <button
                                            class="btn buy-now m-buy-now"><?php _e('Mua ngay', 'monamedia'); ?></button>

                                </div>

                                <?php
                                    $mona_sc_1_group_global_product = get_field('mona_sc_1_group_global_product', MONA_PAGE_HOME);
                                    if (isset($mona_sc_1_group_global_product) || !empty($mona_sc_1_group_global_product)) {
                                        $tieu_de_mona_sc_1_group_global_product = $mona_sc_1_group_global_product['tieu_de'];
                                        $so_hotline_mona_sc_1_group_global_product = $mona_sc_1_group_global_product['so_hotline'];
                                        $link_phone_mona_sc_1_group_global_product = $mona_sc_1_group_global_product['link_phone'];
                                        $time = $mona_sc_1_group_global_product['time'];
                                    }
                                    ?>
                                <div class="hotline">

                                    <?php echo $tieu_de_mona_sc_1_group_global_product; ?>
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <a href="<?php echo $link_phone_mona_sc_1_group_global_product; ?>"> <span
                                            class="sdt"><?php echo $so_hotline_mona_sc_1_group_global_product; ?></span></a>
                                    <?php echo $time; ?>
                                </div>
                            </div>

                        </div>

                        <div class="prod-dt-right col col-lg-4">
                            <div class="prod-dt-right-it">

                                <div class="box-info">
                                    <div class="tt"><?php _e('Thông tin sản phẩm', 'monamedia') ?> </div>
                                    <ul class="info-list">

                                        <li class="info-item">
                                            <div class="ic-info">
                                                <?php if (!empty($icon_1)) { ?>
                                                <?php echo wp_get_attachment_image($icon_1, 'full'); ?>
                                                <?php } else {  ?>
                                                <img src="<?php get_site_url(); ?>/template/assets/images/ic-info-1.svg"
                                                    alt="">
                                                <?php } ?>

                                            </div>
                                            <?php if ($thuong_hieu) { ?>
                                            <p class="txt"><?php _e('Thương hiệu: ', 'monamedia') ?><a
                                                    class="brand-link"
                                                    href="<?php echo esc_url(get_term_link($thuong_hieu)); ?>">
                                                    <?php
                                                            $term = get_term_by('id', $thuong_hieu, 'category_thuong_hieu');
                                                            echo $term->name;
                                                            ?>
                                                </a>
                                            </p>
                                            <?php } ?>
                                        </li>

                                        <li class="info-item">
                                            <div class="ic-info">

                                                <?php if (!empty($icon_2)) { ?>
                                                <?php echo wp_get_attachment_image($icon_2, 'full'); ?>
                                                <?php } else {  ?>
                                                <img src="<?php get_site_url(); ?>/template/assets/images/ic-info-2.svg"
                                                    alt="">
                                                <?php } ?>

                                            </div>
                                            <?php if (!empty($nong_do)) { ?>
                                            <p class="txt"><?php _e('Nồng độ: ', 'monamedia') ?>

                                                <?php
                                                        $term = get_term_by('id', $nong_do, 'category_nong_do');
                                                        echo $term->name;
                                                        ?>
                                            </p>
                                            <?php } ?>
                                        </li>

                                        <li class="info-item">
                                            <div class="ic-info">
                                                <?php if (!empty($icon_3)) { ?>
                                                <?php echo wp_get_attachment_image($icon_3, 'full'); ?>
                                                <?php } else {  ?>
                                                <img src="<?php get_site_url(); ?>/template/assets/images/ic-info-3.svg"
                                                    alt="">
                                                <?php } ?>

                                            </div>
                                            <?php if (!empty($do_luu_mui)) { ?>
                                            <p class="txt">
                                                <?php _e('Độ lưu mùi: ', 'monamedia') ?><?php echo $do_luu_mui; ?></p>
                                            <?php } ?>
                                        </li>

                                        <li class="info-item">
                                            <div class="ic-info">
                                                <?php if (!empty($icon_4)) { ?>
                                                <?php echo wp_get_attachment_image($icon_4, 'full'); ?>
                                                <?php } else {  ?>
                                                <img src="<?php get_site_url(); ?>/template/assets/images/ic-info-4.svg"
                                                    alt="">
                                                <?php } ?>
                                            </div>
                                            <?php if (!empty($do_toa_huong)) { ?>
                                            <p class="txt">
                                                <?php _e('Độ tỏa hương: ', 'monamedia') ?><?php echo $do_toa_huong; ?>
                                            </p>
                                            <?php } ?>
                                        </li>

                                        <li class="info-item">
                                            <div class="ic-info">
                                                <?php if (!empty($icon_5)) { ?>
                                                <?php echo wp_get_attachment_image($icon_5, 'full'); ?>
                                                <?php } else {  ?>
                                                <img src="<?php get_site_url(); ?>/template/assets/images/ic-info-5.svg"
                                                    alt="">
                                                <?php } ?>
                                            </div>
                                            <?php if (!empty($gioi_tinh)) { ?>
                                            <p class="txt"><?php _e('Giới tính: ', 'monamedia') ?>
                                                <?php echo $gioi_tinh; ?></p>
                                            <?php } ?>
                                        </li>

                                    </ul>
                                </div>

                            </div>

                        </div>


                    </div>

                </form>

            </div>
        </div>
    </section>
    <section class="info-prod tabJS">
        <div class="container">
            <div class="row">
                <div class="info-prod-it col col-lg-8">
                    <div class="tab-heading">
                        <ul class="tab-heading-list">
                            <li class="tab-heading-item tabBtn">
                                <h3><?php echo __('Mô tả sản phẩm', 'monamedia'); ?></h3>
                            </li>
                            <li class="tab-heading-item tabBtn">
                                <h3><?php echo __('Sử dụng và bảo quản', 'monamedia'); ?></h3>
                            </li>
                            <li class="tab-heading-item tabBtn">
                                <h3><?php echo __('Vận chuyển và đổi trả ', 'monamedia'); ?></h3>
                            </li>
                        </ul>
                    </div>
                    <div class="info-dt tabPanel">
                        <div class="inner">
                            <div class="desc-dt mona-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="info-dt tabPanel">
                        <div class="inner">
                            <div class="desc-dt mona-content">
                                <?php echo get_field('mona_su_dung_va_bao_quan_global', MONA_PAGE_HOME); ?>
                                <button class="btn">
                                    <?php echo __('Xem thêm ', 'monamedia'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="info-dt tabPanel">
                        <div class="inner">
                            <div class="desc-dt mona-content">
                                <?php echo get_field('mona_van_chuyen_va_doi_tra_global', MONA_PAGE_HOME); ?>
                                <button class="btn">
                                    <?php echo __('Xem thêm ', 'monamedia'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $mona_rp_danh_danh_quyen_loi_global = get_field('mona_rp_danh_danh_quyen_loi_global', MONA_PAGE_HOME) ?>
                <?php if (isset($mona_rp_danh_danh_quyen_loi_global) || empty($mona_rp_danh_danh_quyen_loi_global)) : ?>

                <div class="info-prod-it col col-lg-4">
                    <div class="box-info">
                        <div class="tt"><?php echo __('Quyền lợi khách hàng tại LALUZ', 'monamedia'); ?></div>
                        <ul class="info-list">

                            <?php foreach ($mona_rp_danh_danh_quyen_loi_global as $key => $item) : ?>

                            <li class="info-item">
                                <div class="ic-info">
                                    <?php echo wp_get_attachment_image($item['icon_mona_rp_danh_danh_quyen_loi_global'], 'full') ?>
                                </div>
                                <p class="txt">
                                    <?php echo $item['noi_dung_mona_rp_danh_danh_quyen_loi_global']; ?>
                                </p>
                            </li>

                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>

                <?php endif; ?>

            </div>
        </div>
    </section>
    <section class="reviews-dt">
        <div class="container">
            <h3 class="tt"><?php echo sprintf(__('Đánh giá sản phẩm %s', 'monamedia'), $product->get_name()); ?></h3>
            <div class="rvw-form-area">
                <div id="formProductRating" class="is-loading-group rvw-form">
                    <?php mona_custom_comment_form(); ?>
                </div>
            </div>
            <form id="formProductList" class="is-loading-group">
                <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>" />
                <div class="box-point">
                    <div class="inner">
                        <div class="row">
                            <div class="rvw-stars col col-lg-3">
                                <?php
                                    $args = [
                                        'post_type'     => 'product',
                                        'post_id'       => $product->get_id(),
                                        'status'        => 'approve',
                                    ];
                                    $comments = get_comments($args);

                                    if (!empty($comments) && count($comments) > 0) {
                                        $totalcomment = count($comments);
                                        $totalcommentByGroup = get_comment_count_args($product->get_id());
                                        $rating = 0;

                                        foreach ($totalcommentByGroup as $key => $count) {
                                            $rating += intval($key) * $count;
                                        }

                                        $class5 = $class4 = $class3 = $class2 = $class1 = 0;
                                        $rating_point = round($rating / $totalcomment, 2);
                                        if ($rating_point == 5) {
                                            $class5 = 'active';
                                            $class4 = 'active';
                                            $class3 = 'active';
                                            $class2 = 'active';
                                            $class1 = 'active';
                                        } else if ($rating_point >= 4) {
                                            $class4 = 'active';
                                            $class3 = 'active';
                                            $class2 = 'active';
                                            $class1 = 'active';
                                        } else if ($rating_point >= 3) {
                                            $class3 = 'active';
                                            $class2 = 'active';
                                            $class1 = 'active';
                                        } else if ($rating_point >= 2) {
                                            $class2 = 'active';
                                            $class1 = 'active';
                                        } else if ($rating_point >= 1) {
                                            $class1 = 'active';
                                        }
                                    ?>
                                <div class="total-stars">
                                    <span class="num"><?php echo $rating_point; ?></span>/5
                                </div>
                                <ul class="stars">
                                    <li class="star">
                                        <i class="fa-solid fa-star <?php echo $class1 ? $class1 : ''; ?>"></i>
                                    </li>
                                    <li class="star">
                                        <i class="fa-solid fa-star <?php echo $class2 ? $class2 : ''; ?>"></i>
                                    </li>
                                    <li class="star">
                                        <i class="fa-solid fa-star <?php echo $class3 ? $class3 : ''; ?>"></i>
                                    </li>
                                    <li class="star">
                                        <i class="fa-solid fa-star <?php echo $class4 ? $class4 : ''; ?>"></i>
                                    </li>
                                    <li class="star">
                                        <i class="fa-solid fa-star <?php echo $class5 ? $class5 : ''; ?>"></i>
                                    </li>
                                </ul>

                                <span
                                    class="total-rvw">(<?php echo $totalcomment . __('  đánh giá', 'monamedia'); ?>)</span>
                                <?php } else { ?>
                                <span
                                    class="total-rvw"><?php echo __('Hiện tại chưa có đánh giá nào cho sản phẩm này!', 'monamedia'); ?></span>
                                <?php } ?>
                            </div>
                            <div class="all-point col col-lg-8">
                                <ul class="point-list">
                                    <li class="point-item mona-rating-filter" data-slug="all"
                                        data-product_id="<?php echo $product->get_id(); ?>">
                                        <input class="box-point" type="radio" id="all" name="filter" value="" checked>
                                        <label class="txt b-rds"
                                            for="all"><?php echo __('Tất cả', 'monamedia'); ?></label>
                                    </li>
                                    <li class="point-item mona-rating-filter" data-slug="5"
                                        data-product_id="<?php echo $product->get_id(); ?>">
                                        <input class="box-point" type="radio" id="point_1" name="filter" value="5">
                                        <label class="txt b-rds"
                                            for="point_1"><?php echo __('5 Điểm ', 'monamedia'); ?>(<?php if (!empty($totalcommentByGroup['5'])) {
                                                                                                                                    echo $totalcommentByGroup['5'];
                                                                                                                                } else {
                                                                                                                                    echo '0';
                                                                                                                                }  ?>)</label>
                                    </li>
                                    <li class="point-item mona-rating-filter" data-slug="4"
                                        data-product_id="<?php echo $product->get_id(); ?>">
                                        <input class="box-point" type="radio" id="id3" name="filter" value="4">
                                        <label class="txt b-rds"
                                            for="id3"><?php echo __('4 Điểm ', 'monamedia'); ?>(<?php if (!empty($totalcommentByGroup['4'])) {
                                                                                                                                echo $totalcommentByGroup['5'];
                                                                                                                            } else {
                                                                                                                                echo '0';
                                                                                                                            }  ?>)</label>
                                    </li>
                                    <li class="point-item mona-rating-filter" data-slug="3"
                                        data-product_id="<?php echo $product->get_id(); ?>">
                                        <input class="box-point" type="radio" id="id4" name="filter" value="3">
                                        <label class="txt b-rds"
                                            for="id4"><?php echo __('3 Điểm ', 'monamedia'); ?>(<?php if (!empty($totalcommentByGroup['3'])) {
                                                                                                                                echo $totalcommentByGroup['5'];
                                                                                                                            } else {
                                                                                                                                echo '0';
                                                                                                                            }  ?>)</label>
                                    </li>
                                    <li class="point-item mona-rating-filter" data-slug="2"
                                        data-product_id="<?php echo $product->get_id(); ?>">
                                        <input class="box-point" type="radio" id="id5" name="filter" value="2">
                                        <label class="txt b-rds"
                                            for="id5"><?php echo __('2 Điểm ', 'monamedia'); ?>(<?php if (!empty($totalcommentByGroup['2'])) {
                                                                                                                                echo $totalcommentByGroup['5'];
                                                                                                                            } else {
                                                                                                                                echo '0';
                                                                                                                            }  ?>)</label>
                                    </li>
                                    <li class="point-item mona-rating-filter" data-slug="1"
                                        data-product_id="<?php echo $product->get_id(); ?>">
                                        <input class="box-point" type="radio" id="id6" name="filter" value="1">
                                        <label class="txt b-rds"
                                            for="id6"><?php echo __('1 Điểm ', 'monamedia'); ?>(<?php if (!empty($totalcommentByGroup['1'])) {
                                                                                                                                echo $totalcommentByGroup['5'];
                                                                                                                            } else {
                                                                                                                                echo '0';
                                                                                                                            }  ?>)</label>
                                    </li>
                                    <!-- <li class="point-item mona-rating-filter" data-slug="images" data-product_id="<?php echo $product->get_id(); ?>">
                                            <input class="box-point" type="radio" id="id7" name="filter" value="images">
                                            <label class="txt b-rds" for="id7"><?php echo __('Có hình ảnh ', 'monamedia'); ?>(<?php echo $totalcommentByGroup['images']; ?>)</label>
                                        </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rvw-cmt">
                    <div class="inner">
                        <?php
                            $args = [
                                'post_type' => 'product',
                                'post__in' => [$product->get_id()],
                                'status' => 'approve',
                            ];

                            $comments  = get_comments($args);
                            $total     = !empty($comments) ? count($comments) : 0;
                            $per_page  = 2;
                            $paged     = 1;
                            $totalPage = ceil($total / $per_page);
                            ?>
                        <ul class="rvw-cmt-list">
                            <?php echo mona_wp_comment_lists($args, $per_page, $paged); ?>
                        </ul>
                        <div class="pagi-num mona-pagination-comments">
                            <?php echo mona_comments_pagination($totalPage, $paged); ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- related product  -->
    <?php
        get_template_part('partials/product/RelatedItem', '', array('data' => $product_id));
        ?>

</main>

<?php
    do_action('woocommerce_after_single_product');
endwhile;
get_footer('shop');