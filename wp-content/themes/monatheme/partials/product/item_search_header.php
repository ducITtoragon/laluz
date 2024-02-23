<?php
global $post;
$product_id = $post->ID;
$product = wc_get_product($product_id);
$price_html = '';
$check_stock = true;
$mona_product = new MonaProductClass();

if ($product->is_type('variable')) {
    $variation_ids = $product->get_children();
    if (count($variation_ids) > 0) {
        $variation_id = reset($variation_ids);
        $_product = new WC_Product_Variation($variation_id);
        if ($product->get_price() == 0) {
            $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
        } else {
            // $price_html = $mona_product->get_pice($_product);
            $price_html = $product->get_price_html();
            // echo $price_html;
        }
    }
} else {
    if ($product->get_price() == 0) {
        $price_html = '<p class="price-new">' . __('Liên hệ', 'monamedia') . '</p>';
    } else {
        $price_html = $product->get_price_html();
    }
}

$status = $product->is_in_stock();
$link = get_the_permalink($product_id);
$title = get_the_title($product_id);
$thumbnail = get_the_post_thumbnail($product_id, 'full');
// $product_top_order = $mona_product->top_Order_Product();

// $cls = m_get_active_wishlist($product_id);
// if ($cls == "") {
//     $cls = "m_add_login";
// }

// $ratingScore = get_rating_score($product_id);

$args = array(
    'status'      => 'approve',
    'post_type'   => 'product',
    'post_id'     => $product_id,
);
$evaluates = get_comments($args);
$totalEvaluates = count($evaluates);
?>

<!-- item product  -->
<div class="cart-it">
    <div class="cart-img"><a class="img-link" href="<?php echo esc_url($link); ?>"><?php echo $thumbnail; ?>
        </a></div>
    <div class="cart-content"> <a class="cart-name" href="<?php echo esc_url($link); ?>"><?php echo $title; ?></a>
        <div class="cart-price"> <?php echo $price_html; ?></div>
    </div>
</div>