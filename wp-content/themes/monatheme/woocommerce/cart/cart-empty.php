<?php

/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */

do_action('woocommerce_cart_is_empty');
if (wc_get_page_id('shop') > 0) : ?>
	<div class="container">
		<a href="<?php echo site_url('product/') ?>" class="empty-cart">
			<div class="image-empty-cart">
				<img src="<?php get_site_url(); ?>/template/assets/images/empty-product-1.png" alt="this is a image of empty cart">
			</div>
			<p class="text">
				<?php _e('Giỏ hàng của bạn hiện đang trống. Vui lòng bấm vào dòng chữ này hoặc hình ảnh trên để tiếp tục mua sắm.', 'monamedia'); ?>
			</p>
		</a>
	</div>



	<!-- <div class="fts">
    <a class="btn noic cart-chechout" href="<?php echo site_url('product/') ?>">
        <span class="txt">
            <?php _e('Go to shopping', 'monamedia'); ?>
        </span>
    </a>
</div> -->

<?php endif; ?>