<?php

add_action('wp_ajax_mona_ajax_add_to_cart',  'mona_ajax_add_to_cart'); // login
add_action('wp_ajax_nopriv_mona_ajax_add_to_cart',  'mona_ajax_add_to_cart'); // no login
function mona_ajax_add_to_cart()
{

    if (!class_exists('woocommerce') || !WC()->cart) {
        return;
    }
    global $woocommerce;
    $type = $_POST['type'];
    $form = array();
    parse_str($_POST['formdata'], $form);
    $product_id     = intval($form['product_id']);
    $quantity       = $form['quantity'] ? intval($form['quantity']) : 1;
    $cart_item_data = [
        'role' => 'root'
    ];
    $label = __('Sản phẩm', 'monamedia');
    if (empty($product_id)) {
        wp_send_json_error(
            [
                'title' => $label . ' ' . __('Không tồn tại hoặc đã xảy ra lỗi', 'monamedia'),
                'cart-open' => false,
                'message'   => __('Đã xảy ra lỗi! Vui lòng thử lại sau.', 'monamedia'),
                'action'    => [
                    'title' => __('Thử lại.', 'monamedia'),
                    'title_close' => __('Đóng', 'monamedia'),
                ],
            ]
        );
        wp_die();
    } else {
        $_product = wc_get_product( $product_id );
        if ( $_product->is_type( 'variable' ) ) {
            $mona_attr = [];
            if ( is_array( $_product->get_attributes() ) ) {
                foreach ( $_product->get_attributes() as $attribute_name => $attribute ) {
                    if ( $attribute['variation'] || $attribute['visible'] ) {
                        if ( empty($form[$attribute_name] ) ) {
                            wp_send_json_error(
                                [
                                    'title' => __( "Bạn chưa chọn các tuỳ chọn.", 'monamedia' ),
                                    'cart-open' => false,
                                    'message'   => __( 'Vui lòng chọn các tuỳ chọn', 'monamedia' ),
                                    'action'    => [
                                        'title' => __('Thử lại.', 'monamedia'),
                                        'title_close' => __('Đóng', 'monamedia'),
                                    ],
                                ]
                            );
                            wp_die();
                        }
                        $term = get_term_by( 'slug', $form[$attribute_name], $attribute_name );
                        if ( ! empty ( $term ) ) {
                            $mona_attr['attribute_' . $attribute_name] = $term->slug;
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $term->slug;
                        } else {
                            $mona_attr['attribute_' . $attribute_name] = $form[$attribute_name];
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $form[$attribute_name];
                        }
                    }
                }
            }
            $variation  = [];
            $data_store = new WC_Product_Data_Store_CPT();
            $varid      = $data_store->find_matching_product_variation( $_product, $mona_attr );
            $cart_data  = $woocommerce->cart->add_to_cart( $product_id, $quantity, $varid, $mona_attr, [ 'mona_data' => $cart_item_data ] );
            if ( $cart_data ) {
                echo wp_send_json_success(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm đã được thêm vào giỏ hàng.', 'monamedia'),
                        'title_btn' =>  __('Đã thêm vào giỏ hàng.', 'monamedia'),
                        'action'    => [
                            'title' => get_the_title(MONA_WC_CART),
                            'url'   => get_the_permalink(MONA_WC_CART),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                        'cart_data' => [
                            'count' => $woocommerce->cart->cart_contents_count,
                            'total' => $woocommerce->cart->get_cart_total(),
                        ],
                        'redirect'  => $type == 'now' ? get_the_permalink(MONA_WC_CHECKOUT) : ''
                    ]
                );
                wp_die();
            } else {
                wp_send_json_error(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm hiện đã hết hàng hoặc đã xảy ra lỗi! Quý khách hàng vui lòng liên hệ trực tiếp để được hỗ trợ.', 'monamedia'),
                        'action'    => [
                            'title' => __('Thử lại', 'monamedia'),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                    ]
                );
                wp_die();
            }
        } else {
            $cart_data = $woocommerce->cart->add_to_cart( $product_id, $quantity );
            if ( $cart_data ) {
                echo wp_send_json_success(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm đã được thêm vào giỏ hàng.', 'monamedia'),
                        'title_btn' =>  __('Đã thêm vào giỏ hàng.', 'monamedia'),
                        'action'    => [
                            'title' => get_the_title(MONA_WC_CART),
                            'url'   => get_the_permalink(MONA_WC_CART),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                        'cart_data' => [
                            'count' => $woocommerce->cart->cart_contents_count,
                            'total' => $woocommerce->cart->get_cart_total(),
                        ],
                        'redirect'  => $type == 'now' ? get_the_permalink(MONA_WC_CHECKOUT) : ''
                    ]
                );
                wp_die();
            } else {
                wp_send_json_error(
                    [
                        'title'     => __('Thông báo!', 'monamedia'),
                        'message'   => __('Sản phẩm hiện đã hết hàng hoặc đã xảy ra lỗi! Quý khách hàng vui lòng liên hệ trực tiếp để được hỗ trợ.', 'monamedia'),
                        'action'    => [
                            'title' => __('Thử lại', 'monamedia'),
                            'title_close' => __('Đóng', 'monamedia'),
                        ],
                    ]
                );
                wp_die();
            }
        }
    }
    wp_die();
}
