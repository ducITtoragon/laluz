<?php

/**
 * The template for displaying index.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// efine acf
if (get_current_user_id() == 1) {
    define('ACF_LITE', false);
} else {
    define('ACF_LITE', true);
}

define('APP_PATH', '/app');
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('AJAX_PATH', APP_PATH . '/ajax');
define('HELPER_PATH', APP_PATH . '/helpers');
define('MODULE_PATH', APP_PATH . '/modules');

define('CORE_PATH', '/core');
define('FILES_PATH', '/partials');
define('ADMIN_PATH', CORE_PATH . '/admin');
define('ADMIN_INCLUDES_PATH', ADMIN_PATH . '/includes');
define('ADMIN_AJAX_PATH', ADMIN_PATH . '/ajax');

define('THEME_VERSION', '4.0.1');
define('MENU_FILTER_ADMIN', 'mona-filter-admin');
define('FILTER_ADMIN_SETTING', 'MonaSetting');
define('MONA_HOME_URL', get_site_url());
// define theme page
define('MONA_PAGE_HOME', get_option('page_on_front', true));
define('MONA_PAGE_BLOG', get_option('page_for_posts', true));
define('MONA_CUSTOM_LOGO', get_theme_mod('custom_logo'));
define('MONA_URL', get_site_url() . '/template/assets/images/default-mona.png');

// Woocommerce
define('MONA_WC_PRODUCTS', get_option('woocommerce_shop_page_id'));
define('MONA_WC_CART', get_option('woocommerce_cart_page_id'));
define('MONA_WC_CHECKOUT', get_option('woocommerce_checkout_page_id'));
define('MONA_WC_MYACCOUNT', get_option('woocommerce_myaccount_page_id'));
define('MONA_WC_THANKYOU', get_option('woocommerce_thanks_page_id'));

require_once(get_template_directory() . '/__autoload.php');

function mona_type_percensale($price_sale, $price)
{
    $x = (intval($price_sale) / intval($price)) * 100;
    $percent = 100 - $x;
    return number_format($percent) . '%';
}

/**
* Optimize WooCommerce Scripts
* Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
*/
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
function child_manage_woocommerce_styles() {
//remove generator meta tag
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
    //first check that woo exists to prevent fatal errors
    if ( function_exists( 'is_woocommerce' ) )
    {
        //dequeue scripts and styles
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() )
        {
        wp_dequeue_style( 'woocommerce_frontend_styles' );
        wp_dequeue_style( 'woocommerce_fancybox_styles' );
        wp_dequeue_style( 'woocommerce_chosen_styles' );
        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
        wp_dequeue_script( 'wc_price_slider' );
        wp_dequeue_script( 'wc-single-product' );
        wp_dequeue_script( 'wc-add-to-cart' );
        wp_dequeue_script( 'wc-cart-fragments' );
        wp_dequeue_script( 'wc-checkout' );
        wp_dequeue_script( 'wc-add-to-cart-variation' );
        wp_dequeue_script( 'wc-single-product' );
        wp_dequeue_script( 'wc-cart' );
        wp_dequeue_script( 'wc-chosen' );
        wp_dequeue_script( 'woocommerce' );
        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_script( 'prettyPhoto-init' );
        wp_dequeue_script( 'jquery-blockui' );
        wp_dequeue_script( 'jquery-placeholder' );
        wp_dequeue_script( 'fancybox' );
        wp_dequeue_script( 'jqueryui' );
        }
    }
}

add_action('wp_enqueue_scripts', 'wptangtoc_tai_dieu_kien_tang_toc_woocommerce', 99);
function wptangtoc_tai_dieu_kien_tang_toc_woocommerce() {
	if(function_exists('is_woocommerce')) {
		if(!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() && !is_product() && !is_product_category() && !is_shop()) {
			//dieu kien xoa woocommerce css
			wp_dequeue_style('woocommerce-general');
			wp_dequeue_style('woocommerce-layout');
			wp_dequeue_style('woocommerce-smallscreen');
			wp_dequeue_style('woocommerce_frontend_styles');
			wp_dequeue_style('woocommerce_fancybox_styles');
			wp_dequeue_style('woocommerce_chosen_styles');
			wp_dequeue_style('woocommerce_prettyPhoto_css');
			wp_dequeue_style('woocommerce-inline');

			//dieu kien xoa WooCommerce Scripts javascript
			wp_dequeue_script('wc_price_slider');
			wp_dequeue_script('wc-single-product');
			wp_dequeue_script('wc-add-to-cart');
			wp_dequeue_script('wc-checkout');
			wp_dequeue_script('wc-add-to-cart-variation');
			wp_dequeue_script('wc-single-product');
			wp_dequeue_script('wc-cart');
			wp_dequeue_script('wc-chosen');
			wp_dequeue_script('woocommerce');
			wp_dequeue_script('prettyPhoto');
			wp_dequeue_script('prettyPhoto-init');
			wp_dequeue_script('jquery-blockui');
			wp_dequeue_script('jquery-placeholder');
			wp_dequeue_script('fancybox');
			wp_dequeue_script('jqueryui');

			//xoa no-js Script + Body Class
			add_filter('body_class', function($classes) {
				remove_action('wp_footer', 'wc_no_js');
				$classes = array_diff($classes, array('woocommerce-no-js'));
				return array_values($classes);
			},10, 1);
		}
	}
}

add_filter('use_block_editor_for_post_type', '__return_false', 10);
add_action( 'wp_enqueue_scripts', 'wptangtoc_woocommerce_remove_block_css', 100 );
function wptangtoc_woocommerce_remove_block_css() {
    wp_dequeue_style( 'wc-block-style' );
}

add_action('wp_enqueue_scripts', 'wptangtoc_clear_ajax_dieu_kien_gio_hang', 99);
function wptangtoc_clear_ajax_dieu_kien_gio_hang() {
	if(function_exists('is_woocommerce')) {
		wp_dequeue_script('wc-cart-fragments');
		wp_deregister_script('wc-cart-fragments');
	}
}
