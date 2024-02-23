<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
$accessory_by_item_cart = [];
// do_action('woocommerce_before_mini_cart');

?>
<?php if (!WC()->cart->is_empty()) : ?>
	<div class="bds is-loading-group-2">

		<?php
		do_action('woocommerce_before_mini_cart_contents');

		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
			if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
				$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

				$variation_id = $cart_item['variation_id'];
				$variation_data = wc_get_product_variation_attributes($variation_id);
				$variation_text = wc_get_formatted_variation($variation_data, true);
		?>

				<div class="cart-it">
					<div class="cart-img">
						<?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key); ?>
					</div>
					<div class="cart-content">
						<a class="cart-name" href="<?php echo $product_permalink; ?>">
							<?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
							<?php
							if (!empty($variation_text)) {
								echo ' - ' . $variation_text;
							}
							?>

						</a>

						<div class="box-quantity">
							<button class="minus m_price_minus is-loading-group" type="button">-</button>
							<div class="box-qc">
								<input type="number" max="9999" min="0" step="1" value="<?php echo $cart_item['quantity']; ?>" id="mona-cart-qty" class="ip-value sl-qty-input m-change-qty" hidden="">
								<p class="count-number number-change"> <?php if ($cart_item['quantity'] < 10) {
																			echo '0';
																		} ?><?php echo $cart_item['quantity']; ?></p>
							</div>
							<button class="plus m_price_plus is-loading-group" type="button">+</button>
						</div>

					</div>
					<div class="cart-price">
						<div class="del m-remove-cart-item" data-cart-key="<?php echo $cart_item_key; ?>">
							<i class="fa-solid fa-xmark"></i>
						</div>
						<span class="price">
							<?php echo WC()->cart->get_product_price($_product); ?>
						</span>
					</div>
				</div>

		<?php
			}
		}
		do_action('woocommerce_mini_cart_contents');
		?>

	</div>
<?php
// do_action('woocommerce_after_mini_cart'); 
else :
	get_template_part('woocommerce/cart/cart-empty');
endif;
?>