<?php
$product_id = $args['data'];
$product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));

if (!empty($product_categories)) {
    $count = 10;
    $argsRelatedPost = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $count,
        'post__not_in' => array($product_id),
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $product_categories,
                'include_children' => false,
            ),
        ),
    );

    $the_query = new WP_Query($argsRelatedPost);

    if ($the_query->have_posts()) {
?>

        <section class="prod-slide">
            <div class="container">
                <h3 class="tt"><?php _e('Sản phẩm liên quan', 'monamedia'); ?></h3>
                <div class="prod-slide-wr">
                    <div class="swiper swiper-prod">
                        <div class="swiper-wrapper">

                            <?php
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                            ?>

                                <div class="swiper-slide">
                                    <div class="prod-it">
                                        <?php get_template_part('partials/product/item');  ?>
                                    </div>
                                </div>

                            <?php }
                            wp_reset_postdata(); ?>

                        </div>
                        <div class="box-navi">
                            <div class="btn-navi prev"><i class="fa-solid fa-angle-left"></i></div>
                            <div class="btn-navi next"><i class="fa-solid fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php }
}
?>