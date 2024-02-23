<?php

/**
 * Template name: Wishlist
 * @author : MONA.Media / Website
 */
get_header();
while (have_posts()) :
    the_post();
?>
    <main class="main spc-hd spc-hd-2">
        <section class="nav-bread">
            <div class="container">
                <?php get_template_part('/partials/breadcrumb', ''); ?>
            </div>
        </section>
        <section class="wishlish">
            <div class="container">
                <p class="tt-sec"><?php _e('danh sách sản phẩm yêu thích', 'monamedia') ?></p>
                <div class="wish-list-heading">
                    <div class="search-wish-list">
                        <input class="monaFilterJS-input-wishlist" type="text" placeholder="Tìm kiếm sản phẩm..." />
                    </div>
                    <div class="nav-social-second">
                        <span class="txt-nm"><?php _e('Chia sẻ: ', 'monamedia'); ?></span>
                        <ul class="social-second-list">
                            <li class="social-second-item">
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(home_url()); ?>" class="social-second-link"><i class="fa-brands fa-square-facebook"></i></a>
                            </li>
                            <li class="social-second-item">
                                <a class="social-second-link" href="https://www.instagram.com/laluz_parfums/"><i class="fa-brands fa-square-instagram"></i></a>
                            </li>
                            <li class="social-second-item">
                                <a class="social-second-link" href="https://www.tiktok.com/tag/laluzparfums"><i class="fa-brands fa-tiktok"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="prod-wish-list row" id="wishlist-container">
                    <?php
                    if (is_user_logged_in()) {
                        $user_id = get_current_user_id();
                        $wishlist_array = get_user_meta($user_id, '_wishlist', true) ? get_user_meta($user_id, '_wishlist', true) : [];
                    } else {
                        $wishlist_array = [];
                    }

                    if ($wishlist_array) :
                        foreach ($wishlist_array as $key => $item) {
                            if (get_post_type($item) == 'product') {
                                global $post;
                                $url = get_the_permalink($item);
                                $thumb = get_the_post_thumbnail($item, 'thumbnail');
                                $title = get_the_title($item);
                                $product = wc_get_product($item);
                                $price_html = $product->get_price_html($item);

                                // $ratingScore = get_rating_score($item);
                                $args = array(
                                    'status'      => 'approve',
                                    'post_type'   => 'product',
                                    'post_id'     => $item,
                                );
                                $evaluates = get_comments($args);
                                $totalEvaluates = count($evaluates);
                    ?>
                                <div class="prod-it">
                                    <div class="inner">
                                        <div class="bg"></div>
                                        <a class="img-prod" href="<?php echo $url; ?>">
                                            <?php echo $thumb; ?>
                                        </a>
                                        <div class="wr-info">
                                            <h3 class="txt-prod tt">
                                                <a class="prod-name" href="<?php echo $url; ?>"></a>
                                            </h3>
                                            <a class="txt-prod stt" href="<?php echo $url; ?>"><?php echo $title; ?></a>
                                            <span class="txt-prod prc"> <?php echo $price_html; ?></span>
                                            <div class="button-action">
                                                <button class="btn cl-txt m-remove-wishlist-2" data-key="<?php echo $item; ?>">
                                                    <span class="txt"><?php _e('Xóa sản phẩm', 'monamedia') ?></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>

                    <?php else :
                    ?>
                        <div class="container">
                            <a href="<?php echo home_url(); ?>" class="empty-product">
                                <div class="image-empty-product">
                                    <img src="<?php get_site_url(); ?>/template/assets/images/wishlist_empty.png" alt="this is a image of empty product">
                                </div>
                                <p class="text">
                                    <?php _e('Hiện tại, bạn chưa có sản phẩm yêu thích.', 'monamedia'); ?>
                                </p>
                                <a class="btn noic product-empty-button" href="<?php echo home_url(); ?>">
                                    <span class="txt">
                                        <?php _e('Tiếp tục mua sắm', 'monamedia') ?>
                                    </span>
                                </a>
                            </a>
                        </div>
                    <?php
                    endif ?>
                </div>
            </div>
        </section>
    </main>
<?php
endwhile;
get_footer();
