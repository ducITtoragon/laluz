<?php
add_action('wp_ajax_mona_ajax_find_variation', 'mona_ajax_find_variation'); // login
add_action('wp_ajax_nopriv_mona_ajax_find_variation', 'mona_ajax_find_variation'); // no login
function mona_ajax_find_variation()
{
    global $woocommerce;
    $form = [];
    parse_str($_POST['formdata'], $form);
    $product_id     = intval($form['product_id']);
    $product        = wc_get_product($product_id);
    $request_addons = [];
    $cart_item_data = [];
    $attrbutes_data = [];

    if ( ! $product->is_type( 'variable' ) ) {
        wp_send_json_error(
            [
                'title'        => __('Thông báo!', 'monamedia'),
                'message'      => __('Hành động này không hợp lệ!!', 'monamedia'),
                'title_action' => __('Thử lại', 'monamedia'),
            ]
        );
    } else {
        if ( is_array( $product->get_attributes() ) ) {
            foreach ( $product->get_attributes() as $attribute_name => $attribute ) {
                if ( $attribute['variation'] || $attribute['visible'] ) {
                    $request_attributes = $form[$attribute_name];
                    if ( empty( $request_attributes ) ) {
                        wp_send_json_error(
                            [
                                'title' => __('Thông báo!', 'monamedia'),
                                'message' => __('Vui lòng chọn thuộc tính sản phẩm!', 'monamedia'),
                                'title_action' => __('Thử lại', 'monamedia'),
                            ]
                        );
                        wp_die();
                    }
                    $term = get_term_by( 'slug', $request_attributes, $attribute_name );
                    if ($term) {
                        $attrbutes_data['attribute_' . $attribute_name] = $term->slug;
                    } else {
                        $attrbutes_data['attribute_' . $attribute_name] = $request_attributes;
                    }
                }
            }
        }

        $data_store = new WC_Product_Data_Store_CPT();
        $varid      = $data_store->find_matching_product_variation( $product, $attrbutes_data );
        if ( $varid != 0 ) {
            $productClass = new MonaProductClass();
            wp_send_json_success(
                [
                    'current' => [
                        'product_id' => $product_id,
                        'varid'      => $varid,
                        'price'      => $productClass->PriceProduct($varid, 'detail'),
                        'gallery'    => $productClass->GalleryProduct($varid),
                        'mess'       => 'Tải các tuỳ chọn thành công',
                    ]
                ]
            );
            wp_die();
        } else {
            wp_send_json_error(
                [
                    'title'       => __('Thông báo!', 'monamedia'),
                    'message'     => __('Vui lòng chọn sản phẩm thuộc tính!', 'monamedia'),
                    'title_close' => __('Thử lại', 'monamedia'),
                ]
            );
            wp_die();
        }
    }
    wp_die();
}


// thêm compo vào giỏ hàng 
add_action('wp_ajax_mona_ajax_add_to_cart_combo', 'mona_ajax_add_to_cart_combo'); // login
add_action('wp_ajax_nopriv_mona_ajax_add_to_cart_combo', 'mona_ajax_add_to_cart_combo'); // no login

function mona_ajax_add_to_cart_combo()
{
    if (!class_exists('woocommerce') || !WC()->cart) {
        return;
    }

    global $woocommerce;
    $form = array();
    parse_str($_POST['formdata'], $form);
    $product_id = intval($form['product_id']);
    $quantity = $form['quantity'] ? intval($form['quantity']) : 1;

    $cart_item_data = [];
    $combo_items = $form['combo_items'];
    $product_item_key = '';

    if (empty($product_id)) {
        $label = __('Sản phẩm', 'monamedia');
        wp_send_json_error(
            [
                'title' => $label . ' ' . __('Không tồn tại hoặc đã xảy ra lỗi.', 'monamedia'),
                'cart-open' => false,
                'message'   => __('Đã xảy ra lỗi! Vui lòng thử lại sau.', 'monamedia'),
                'action'    => [
                    'title' => __('Thử lại', 'monamedia'),
                    'title_close' => __('Đóng', 'monamedia'),
                ],
            ]
        );
        wp_die();
    } else {

        //add to cart [product root];
        $product_root_id = $product_id;
        $_product = wc_get_product($product_id);
        if ($_product->is_type('variable')) {
            $mona_attr = [];
            if (is_array($_product->get_attributes())) {
                foreach ($_product->get_attributes() as $attribute_name => $attribute) {
                    if ($attribute['variation'] || $attribute['visible']) {
                        if (empty($form[$attribute_name])) {
                            $attribute_label_name = wc_attribute_label($attribute_name);
                            wp_send_json_error(
                                [
                                    'title' => __("Bạn chưa chọn thuộc tính.", 'monamedia') . $attribute_label_name,
                                    'cart-open' => false,
                                    'message'   => __('Vui lòng chọn thuộc tính.', 'monamedia'),
                                    'action'    => [
                                        'title' => __('Thử lại', 'monamedia'),
                                        'title_close' => __('Đóng', 'monamedia'),
                                    ],
                                ]
                            );
                            wp_die();
                        }
                        $term = get_term_by('slug', $form[$attribute_name], $attribute_name);
                        if (!empty($term)) {
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $term->slug;
                            $mona_attr['attribute_' . $attribute_name] = $term->slug;
                        } else {
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $form[$attribute_name];
                            $mona_attr['attribute_' . $attribute_name] = $form[$attribute_name];
                        }
                    }
                }
            }
            $variation = [];
            $data_store   = WC_Data_Store::load('product');
            $varid = $data_store->find_matching_product_variation(new \WC_Product($product_id), $mona_attr);
            $product_cart_id     = WC()->cart->generate_cart_id($product_root_id, $varid, $mona_attr, ['mona_data' => $cart_item_data]);
            $product_item_key    = WC()->cart->find_product_in_cart($product_cart_id);
            $cart_item_data['role'] = 'root';
            $cart_item_data['type'] = 'combo';
            $product_root_id = $varid;
            $product_item_key = WC()->cart->add_to_cart($product_id, $quantity, $varid, $mona_attr, ['mona_data' => $cart_item_data]);
        } else {

            $mona_attr = [];
            if (is_array($_product->get_attributes())) {
                foreach ($_product->get_attributes() as $attribute_name => $attribute) {
                    if ($attribute['visible']) {
                        if (empty($form[$attribute_name])) {
                            var_dump('sdcdsds');
                            $attribute_label_name = wc_attribute_label($attribute_name);
                            wp_send_json_error(
                                [
                                    'title' => __("Bạn chưa chọn thuộc tính.", 'monamedia') . $attribute_label_name,
                                    'cart-open' => false,
                                    'message'   => __('Vui lòng chọn thuộc tính.', 'monamedia'),
                                    'action'    => [
                                        'title' => __('Thử lại', 'monamedia'),
                                        'title_close' => __('Đóng', 'monamedia'),
                                    ],
                                ]
                            );
                            wp_die();
                        }
                        $term = get_term_by('slug', $form[$attribute_name], $attribute_name);
                        if (!empty($term)) {
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $term->slug;
                            $mona_attr['attribute_' . $attribute_name] = $term->slug;
                        } else {
                            $cart_item_data['attributes']['attribute_' . $attribute_name] = $form[$attribute_name];
                            $mona_attr['attribute_' . $attribute_name] = $form[$attribute_name];
                        }
                    }
                }
            }
            $product_cart_id     = WC()->cart->generate_cart_id($product_id, false, $mona_attr, ['mona_data' => $cart_item_data]);
            $product_item_key    = WC()->cart->find_product_in_cart($product_cart_id);
            $cart_item_data['role'] = 'root';
            $cart_item_data['type'] = 'combo';
            $product_item_key = WC()->cart->add_to_cart($product_id, $quantity, false, $mona_attr, ['mona_data' => $cart_item_data]);
        }

        //ADD COMBO;
        if (!empty($combo_items)) {

            // print_r( $combo_items );
            $combo_i = 0;
            foreach ($combo_items as $key => $combo_item) {

                if (!empty($combo_item['combo_id'])) {
                    $combo_id       = $combo_item['combo_id'];
                    $combo_quantity = $combo_item['combo_quantity'] ? $combo_item['combo_quantity'] : 1;
                    $combo_price    = $combo_item['combo_price'];

                    $combo_item_data   = array(
                        'role'                  => 'leaf',
                        'combo_id'              => $combo_id,
                        'combo_price'           => $combo_price,
                        'combo_parent_id'       => $product_root_id,
                        'combo_parent_key'      => $product_item_key,
                    );

                    $mona_combo_attr = [];
                    $combo_product_by_combo_id = wc_get_product($combo_id);

                    if ($combo_product_by_combo_id->is_type('variation')) {

                        $product_parent = $combo_product_by_combo_id->get_parent_id();
                        $product_parent_obj = wc_get_product($product_parent);

                        if (is_array($product_parent_obj->get_attributes())) {
                            foreach ($product_parent_obj->get_attributes() as $attribute_name => $attribute) {
                                if ($attribute['visible'] || $attribute['variation']) {
                                    if (empty($form['combo_items'][$key]['attributes'][$attribute_name])) {
                                        $attribute_label_name = wc_attribute_label($attribute_name);
                                        wp_send_json_error(
                                            [
                                                'title' => __("Bạn chưa chọn thuộc tính.", 'monamedia') . $attribute_label_name,
                                                'cart-open' => false,
                                                'message'   => __('Vui lòng chọn thuộc tính.', 'monamedia'),
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
                        }
                        if (is_array($combo_item['attributes'])) {
                            foreach ($combo_item['attributes'] as $attribute_name => $attribute) {

                                $term = get_term_by('slug', $attribute, $attribute_name);
                                if (!empty($term)) {
                                    $mona_combo_attr['attribute_' . $attribute_name] = $term->slug;
                                    $combo_item_data['attributes']['attribute_' . $attribute_name] = $term->slug;
                                } else {
                                    $mona_combo_attr['attribute_' . $attribute_name] = $attribute;
                                    $combo_item_data['attributes']['attribute_' . $attribute_name] = $attribute;
                                }
                            }
                        }
                        // $combo_cart_id     = WC()->cart->generate_cart_id( $product_parent, $combo_id, $mona_combo_attr, $combo_item_data );
                        // $combo_item_key    = WC()->cart->find_product_in_cart( $combo_cart_id );
                        $combo_item_key    = WC()->cart->add_to_cart($product_parent, $combo_quantity, $combo_id, $mona_combo_attr, ['mona_data' => $combo_item_data]);
                    } else {

                        // $combo_cart_id     = WC()->cart->generate_cart_id( $combo_id, false, $mona_combo_attr, $combo_item_data );
                        // $combo_item_key    = WC()->cart->find_product_in_cart( $combo_cart_id );
                        $combo_item_key    = WC()->cart->add_to_cart($combo_id, $combo_quantity, false, $mona_combo_attr, ['mona_data' => $combo_item_data]);
                    }

                    // // add keys
                    if (
                        !empty($combo_item_key) &&
                        !empty(WC()->cart->cart_contents[$product_item_key]['combo_item_keys']) &&
                        is_array(WC()->cart->cart_contents[$product_item_key]['combo_item_keys']) &&
                        !in_array($combo_item_key, WC()->cart->cart_contents[$product_item_key]['combo_item_keys'])
                    ) {

                        WC()->cart->cart_contents[$product_item_key]['combo_item_keys'][] = $combo_item_key;
                    } elseif (!empty($combo_item_key) && empty(WC()->cart->cart_contents[$product_item_key]['combo_item_keys'])) {

                        WC()->cart->cart_contents[$product_item_key]['combo_item_keys'][] = $combo_item_key;
                    }
                    $combo_i++;
                }
            }
        }

        WC()->cart->set_session();

        if (!empty($product_item_key)) {

            echo wp_send_json_success(
                [
                    'title'     => __('Thông báo!', 'monamedia'),
                    'message'   => __('Đã thêm thành công Compo vào giỏ hàng', 'monamedia'),
                    'title_btn' =>  __('Đã thêm vào giỏ hàng', 'monamedia'),
                    // 'action'    => [
                    //     'title' => get_the_title(MONA_WC_CART),
                    //     'url'   => get_the_permalink(MONA_WC_CART),
                    //     'title_close' => __('Đóng', 'monamedia'),
                    // ],
                    'cart_data' => [
                        'count' => $woocommerce->cart->cart_contents_count,
                        'total' => $woocommerce->cart->get_cart_total(),
                    ],
                ]
            );
            wp_die();
        } else {

            wp_send_json_error(
                [
                    'title'     => __('Thông báo!', 'monamedia'),
                    'message'   => __('Sản phẩm hiện đã hết hàng hoặc xảy ra lỗi! Hãy liên hệ trực tiếp với chúng tôi để được hỗ trợ.', 'monamedia'),
                    'action'    => [
                        'title' => __('Thử lại', 'monamedia'),
                        'title_close' => __('Đóng', 'monamedia'),
                    ],
                ]
            );
            wp_die();
        }
    }
    wp_die();
}
