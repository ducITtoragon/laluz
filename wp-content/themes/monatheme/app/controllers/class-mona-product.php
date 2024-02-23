<?php
class MonaProductClass
{
    public function __construct()
    {
    }
    public function __init()
    {

        add_action('init', [$this, 'myStartSession'], 1);

        add_filter('woocommerce_get_price_html', [$this,  'price_html'], 100, 2);

        // add_action('wp_ajax_m_change_attr_pd', [$this,  'm_change_attr_pd']); // co dang nhap
        // add_action('wp_ajax_nopriv_m_change_attr_pd', [$this, 'm_change_attr_pd']); // meo dang nhap

        # create status order 
        add_action('init', [$this,  'register_shipment_arrival_order_status']);

        # Update custom field checkout
        add_action('woocommerce_checkout_create_order', [$this, 'custom_checkout_field_update_meta'], 10, 2);

        # bình luận
        add_action('wp_ajax_ic_wp_insert_comment', [$this, 'ic_wp_insert_comment']); // co dang nhap

        # Thay đổi giá theo
        add_action('wp_ajax_m_change_price', [$this, 'm_change_price']); // co dang nhap  
        add_action('wp_ajax_nopriv_m_change_price', [$this, 'm_change_price']); // co dang nhap

        add_action('wp_ajax_m_change_price_item', [$this, 'm_change_price_item']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_change_price_item', [$this, 'm_change_price_item']); // co dang nhap

        #mã giảm giá
        add_action('wp_ajax_m_append_coupon', [$this, 'm_append_coupon']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_append_coupon', [$this, 'm_append_coupon']); // co dang nhap

        # mua hàng ngay
        add_action('wp_ajax_sbw_wc_handle_buy_now', [$this, 'sbw_wc_handle_buy_now']); // co dang nhap 
        add_action('wp_ajax_nopriv_sbw_wc_handle_buy_now', [$this, 'sbw_wc_handle_buy_now']); // co dang nhap

        # Thêm giỏ hàng nhanh
        add_action('wp_ajax_m_add_cart_flash', [$this, 'm_add_cart_flash']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_add_cart_flash', [$this, 'm_add_cart_flash']); // co dang nhap

        # Thêm giỏ hàng 
        add_action('wp_ajax_m_add_cart', [$this, 'm_add_cart']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_add_cart', [$this, 'm_add_cart']); // co dang nhap

        #yeu thich
        add_action('wp_ajax_nopriv_m_popupopen_card', [$this, 'm_popupopen_card']); // co dang nhap

        # Cập nhật số lượng giỏ hàng
        add_action('wp_ajax_m_update_quantity_item', [$this, 'm_update_quantity_item']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_update_quantity_item', [$this, 'm_update_quantity_item']); // co dang nhap

        # Xoá giỏ hàng
        add_action('wp_ajax_m_remove_cart_item', [$this, 'm_remove_cart_item']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_remove_cart_item', [$this, 'm_remove_cart_item']); // co dang nhap

        # Thêm sản phẩm vào danh sách yêu thích
        add_action('wp_ajax_m_add_wishlist_item', [$this, 'm_add_wishlist_item']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_add_wishlist_item', [$this, 'm_add_wishlist_item']); // co dang nhap

        # Xoá sản phẩm vào danh sách yêu thích
        add_action('wp_ajax_m_remove_wishlist_item', [$this, 'm_remove_wishlist_item']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_remove_wishlist_item', [$this, 'm_remove_wishlist_item']); // co dang nhap

        // Field
        add_filter('woocommerce_checkout_fields', array($this, 'mona_overwrite_billing'), 9999);
        // add_filter( 'woocommerce_default_address_fields' , array($this, 'filter_default_address_fields'), 20, 1 );
        add_action('woocommerce_add_order_item_meta', array($this, 'add_product_custom_field_to_order_item_meta'), 20, 3);
        // add_action( 'woocommerce_new_order_item', array($this, 'action_woocommerce_new_order_item'), 10, 3 );
        // add_action('woocommerce_checkout_before_customer_details', [$this, 'custom_checkout_fields_before_billing_details'], 20);

        add_action('woocommerce_cart_calculate_fees', array($this, 'custom_fee_based_on_cart_total'), 10, 1);

        # Thêm field trong đơn hàng chi tiết (Admin Page)
        add_action('woocommerce_before_order_itemmeta', [$this, 'so_32457241_before_order_itemmeta'], 10, 3);

        // Cập nhật trạng thái đơn hàng thành hủy đơn 
        add_action('wp_ajax_m_update_status_product', [$this, 'm_update_status_product']); // co dang nhap 
        add_action('wp_ajax_nopriv_m_update_status_product', [$this, 'm_update_status_product']); // co dang nhap

    }

    public function m_count_wishlist()
    {
        $user_id = get_current_user_id();
        if ($user_id) {
            $wishlist_array = get_user_meta($user_id, '_wishlist', true) ? get_user_meta($user_id, '_wishlist', true) : [];
            $count = count($wishlist_array);
        } else {
            $count = 0;
        }
        return $count;
    }

    public function m_active_wishlist($product_id)
    {
        $user_id = get_current_user_id();
        if ($user_id) {
            $cls = 'm-add-wishlist';
            $wishlist_array = get_user_meta($user_id, '_wishlist', true) ? get_user_meta($user_id, '_wishlist', true) : [];
            if (in_array($product_id, $wishlist_array)) {
                $cls = 'active m-remove-wishlist';
            }
        } else {
            $cls = "popup-open";
        }
        return $cls;
    }

    public function m_wishlist_item($product_id, $variation_id = 0, $toppings = [])
    {
        $user_id = get_current_user_id();

        if (get_post_type($product_id) == 'product') {
            if (!empty($user_id)) {
                $wishlist_array = get_user_meta($user_id, '_wishlist', true) ? get_user_meta($user_id, '_wishlist', true) : [];
                $wishlist_array[] = $product_id;
                $number = count($wishlist_array);
                update_user_meta($user_id, '_wishlist', $wishlist_array);
                $dataNote = [
                    'mess' => 'Đã thêm thành công sản phẩm yêu thích',
                    'number' => $number,
                ];
                wp_send_json_success($dataNote);
                wp_die();
            } else {
                $dataNote = [
                    'mess' => 'Vui lòng đăng nhập để thêm sản phẩm yêu thích của bạn',
                ];
                wp_send_json_error($dataNote);
                wp_die();
            }
        }

        $dataNote = [
            'mess' => 'Đã xảy ra lỗi, liên hệ với quản trị viên',
        ];
        wp_send_json_error($dataNote);
        wp_die();
    }

    public function m_popupopen_card()
    {
        $dataNote = [
            'mess' => 'Vui lòng đăng nhập để thêm sản phẩm yêu thích của bạn',
        ];
        wp_send_json_success($dataNote);
        wp_die();
    }

    public function m_remove_wishlist_item()
    {
        $user_id = get_current_user_id();
        $keys = esc_attr($_POST['key']);
        if ($keys != "") {
            if ($user_id) {
                $wishlist_array = get_user_meta($user_id, '_wishlist', true) ? get_user_meta($user_id, '_wishlist', true) : [];
                if ($wishlist_array) {
                    foreach (array_keys($wishlist_array, $keys, true) as $key) {
                        unset($wishlist_array[$key]);
                    }
                }
                update_user_meta($user_id, '_wishlist', $wishlist_array);
                $number = count($wishlist_array);
                ob_start();
                get_template_part('page-template/wishlist-template', '', ['wishlist' => $wishlist_array]);
                $wish = ob_get_contents();
                ob_end_clean();

                $dataNote = [
                    'wishlist' => $wish,
                    'number' => $number,
                    'mess' => 'Đã xóa thành công sản phẩm yêu thích',
                ];
                wp_send_json_success($dataNote);
                wp_die();
            } else {
                $dataNote = [
                    'mess' => 'Vui lòng đăng nhập',
                ];
                wp_send_json_error($dataNote);
                wp_die();
            }
        }
        wp_die();
    }

    public function m_add_wishlist_item()
    {
        $data = $_POST;
        if ($data) {
            $this->m_wishlist_item($data['product_id']);
        }
        wp_die();
    }

    // Price
    public function m_total_item($product_id, $attr, $accessory)
    {
        if (!empty($attr) && isset($attr)) {
            $variation_id = $attr;
            $_product = new WC_Product_Variation($variation_id);
            $price = $_product->get_price() ? $_product->get_price() : 0;
        } else {
            $product = wc_get_product($product_id);
            $price = $product->get_price() ? $product->get_price() : 0;
        }
        $total = $price;
        if ($total > 0) {
            $toppings = $accessory;
            if (!empty($toppings) && isset($toppings)) {
                foreach ($toppings as $item) {
                    $product = wc_get_product($item);
                    $price_acc = 0;
                    if ($product != "") {
                        $price_acc = $product->get_price();
                        $total += $price_acc;
                    }
                }
            }
            return $total;
        }
        return false;
    }

    public function m_total_cart_item($product_id, $attr, $accessory)
    {
        $total = $this->m_total_item($product_id, $attr, $accessory);
        if ($total) {
            $html = wc_price($total);
            return $html;
        }
        return 0;
    }

    public function m_change_price()
    {
        $dataForm = [];
        parse_str($_POST['formdata'], $dataForm);
        $product_id = $dataForm['product_id'];

        $html = $this->m_total_cart_item($product_id, $dataForm['attributes'], $dataForm['toppings']);
        wp_send_json_success($html);
        wp_die();
    }

    public function m_change_price_item()
    {
        $dataForm = $_POST;
        $product_id = $dataForm['product_id'];
        $variation_id = $dataForm['variation_id'];
        $html = '<p class="info-price-current">';
        $html .= $this->m_total_cart_item($product_id, $variation_id, []);
        $html .= '</p>';
        wp_send_json_success($html);
        wp_die();
    }

    function price_html($price, $product)
    {
        if ($product->is_type('simple')) {
            $html = "";
            $html .= '<p class="price-new">' . wc_price($product->get_price()) . ' </p>';
            if ($product->is_on_sale()) {
                $html .= '<p class="price-odd">' . wc_price($product->get_regular_price()) . '</p>';
            }
            return $html;
        }
        return '<p class="info-price-current">' . $price . '</p>';
    }

    function price_variation_html($product)
    {
        $html = "";
        $html = '<span class="price-new">' . wc_price($product->get_price()) . ' </span>';
        if ($product->is_on_sale()) {
            $html .= '<span class="price-odd">' . wc_price($product->get_regular_price()) . '</span>';
        }
        return $html;
    }


    function price_single_variation_html($product)
    {
        $variations = $product->get_available_variations();
        $html = "";
        // Sắp xếp các biến thể theo giá từ cao đến thấp
        usort($variations, function ($a, $b) {
            return $b['display_price'] - $a['display_price'];
        });
        if (!empty($variations)) {
            $highest_price = $variations[0]['display_price'];
            $lowest_price = end($variations)['display_price'];
            $initial_price = $product->get_variation_regular_price();
            $html .= '<span class="price-new">' . wc_price($lowest_price) . ' - ' . wc_price($highest_price)  . ' </span>';
            $html .= '<span class ="price-odd">' . wc_price($initial_price) . '</span> ';
        }

        return $html;
    }



    // Commnet
    public function ic_wp_insert_comment()
    {
        $dataForm = [];
        parse_str($_POST['formData'], $dataForm);

        $comment = esc_attr($dataForm["comment-note"]);
        $comment_post_ID = esc_attr($dataForm["comment_post_ID"]);
        $comment_rating = esc_attr($dataForm["rating"]);
        $user = get_userdata(get_current_user_id());
        $comment_name = $user->display_name;
        $comment_email = $user->user_email;

        if (comments_open($comment_post_ID)) {
            $data = array(
                'comment_post_ID'      => $comment_post_ID,
                'comment_content'      => $comment,
                'user_id'              => '',
                'comment_author'       => $comment_name,
                'comment_author_email' => $comment_email,
                'comment_author_url'   => '',
                'comment_meta' => [
                    'rating' => $comment_rating,
                ]
            );
            $comment_id = wp_insert_comment($data);
            if (!is_wp_error($comment_id)) {
                ob_start();
                get_template_part('partials/product/list-comment');
                $element = ob_get_contents();
                ob_end_clean();
                $array = array(
                    'mess' => 'Successful comment',
                    'element' => $element,
                );
                wp_send_json_success($array);
                wp_die();
            }
        }
        $array = array(
            'mess' => 'Tồn tại lỗi liên hệ admin',
        );
        wp_send_json_error($array);
        wp_die();
    }


    // Field WC
    public function mona_overwrite_billing($fields)
    {

        $priority = 1;
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_company']);

        // Billing

        $fields['billing']['billing_first_name']['priority'] = $priority++;

        $fields['billing']['billing_last_name']['priority'] = $priority++;

        $fields['billing']['billing_country']['priority'] = $priority++;

        $fields['billing']['billing_address_1']['priority'] = $priority++;

        $fields['billing']['billing_city']['priority'] = $priority++;

        $fields['billing']['billing_state']['priority'] = $priority++;

        $fields['billing']['billing_postcode']['priority'] = $priority++;

        $fields['billing']['billing_phone']['priority'] = $priority++;

        $fields['billing']['billing_email']['priority'] = $priority++;


        // $fields['order']['order_comments']['priority'] = $priority++;

        $fields['billing']['billing_country']['label'] = __('Country/Region', 'monamedia');
        $fields['billing']['billing_first_name']['label'] = __('First name', 'monamedia');
        $fields['billing']['billing_last_name']['label'] = __('Last name', 'monamedia');
        $fields['billing']['billing_phone']['label'] = __('Phone', 'monamedia');
        $fields['billing']['billing_email']['label'] = 'Email address';
        $fields['billing']['billing_address_1']['label'] = __('Street address', 'monamedia');

        $fields['billing']['billing_city']['label'] = __('Town / City', 'monamedia');
        $fields['billing']['billing_state']['label'] = __('State', 'monamedia');
        $fields['billing']['billing_postcode']['label'] = __('ZIP Code', 'monamedia');


        $fields['billing']['billing_country']['class'] = ['form-ip col'];
        $fields['billing']['billing_first_name']['class'] = ['form-ip col per5'];
        $fields['billing']['billing_last_name']['class'] = ['form-ip col per5'];
        $fields['billing']['billing_email']['class'] = ['form-ip col per5'];
        $fields['billing']['billing_phone']['class'] = ['form-ip col per5'];
        $fields['billing']['billing_address_1']['class'] = ['form-ip col'];
        $fields['billing']['billing_city']['class'] = ['form-ip col'];
        $fields['billing']['billing_state']['class'] = ['form-ip col'];
        $fields['billing']['billing_postcode']['class'] = ['form-ip col'];
        $fields['order']['order_comments']['class'] = ['form-ip col'];


        $fields['billing']['billing_country']['placeholder'] = 'Enter country';
        $fields['billing']['billing_first_name']['placeholder'] = 'Enter your name';
        $fields['billing']['billing_last_name']['placeholder'] = 'Enter your last name';
        $fields['billing']['billing_email']['placeholder'] = 'Enter your email';
        $fields['billing']['billing_phone']['placeholder'] = 'Enter your phone number';
        $fields['billing']['billing_address_1']['placeholder'] = 'Enter your address';
        $fields['billing']['billing_city']['placeholder'] = 'Enter your city';
        $fields['billing']['billing_state']['placeholder'] = 'Enter your district';
        $fields['billing']['billing_postcode']['placeholder'] = 'Enter your Zipcode';
        // $fields['order']['order_comments']['placeholder'] = '';



        // $fields['billing']['billing_country']['type'] = 'text';
        $fields['shipping_first_name']['required'] = false;
        $fields['shipping_last_name']['required'] = false;
        $fields['shipping_company']['required'] = false;
        $fields['shipping_country']['required'] = false;
        $fields['shipping_address_1']['required'] = false;
        $fields['shipping_address_2']['required'] = false;
        $fields['shipping_city']['required'] = false;
        $fields['shipping_state']['required'] = false;
        $fields['shipping_postcode']['required'] = false;

        unset($fields['shipping']['shipping_first_name']);
        unset($fields['shipping']['shipping_last_name']);
        unset($fields['shipping']['shipping_company']);
        unset($fields['shipping']['shipping_country']);
        // unset($fields['shipping']['shipping_address_1']);
        unset($fields['shipping']['shipping_address_2']);
        unset($fields['shipping']['shipping_city']);
        unset($fields['shipping']['shipping_state']);
        unset($fields['shipping']['shipping_postcode']);

        return $fields;
    }

    public function filter_default_address_fields($address_fields)
    {
        $priority = 1;
        // unset($fields['billing']['billing_postcode']);
        unset($address_fields['address_2']);
        // unset($fields['billing']['billing_last_name']);
        unset($address_fields['company']);

        // Billing
        $address_fields['country']['priority'] = $priority++;
        $address_fields['address_1']['priority'] = $priority++;
        $address_fields['first_name']['priority'] = $priority++;
        $address_fields['last_name']['priority'] = $priority++;
        $address_fields['phone']['priority'] = $priority++;
        $address_fields['email']['priority'] = $priority++;

        $address_fields['city']['priority'] = $priority++;
        $address_fields['state']['priority'] = $priority++;
        $address_fields['postcode']['priority'] = $priority++;

        // $fields['order']['order_comments']['priority'] = $priority++;

        $address_fields['country']['label'] = __('Country/Region', 'monamedia');
        $address_fields['first_name']['label'] = __('First name', 'monamedia');
        $address_fields['last_name']['label'] = __('Last name', 'monamedia');
        $address_fields['phone']['label'] = __('Phone', 'monamedia');
        $address_fields['email']['label'] = 'Email';
        $address_fields['address_1']['label'] = __('Apartment, suite, etc.', 'monamedia');

        $address_fields['city']['label'] = __('City', 'monamedia');
        $address_fields['state']['label'] = __('State', 'monamedia');
        $address_fields['postcode']['label'] = __('ZIP code', 'monamedia');

        $address_fields['country']['class'] = ['form-ip col'];
        $address_fields['first_name']['class'] = ['form-ip col per5'];
        $address_fields['last_name']['class'] = ['form-ip col per5'];
        $address_fields['address_1']['class'] = ['form-ip col'];
        $address_fields['city']['class'] = ['form-ip col per3'];
        $address_fields['state']['class'] = ['form-ip col per3'];
        $address_fields['postcode']['class'] = ['form-ip col per3'];

        return $address_fields;
    }

    public function custom_fee_based_on_cart_total($cart)
    {
        // Set here your percentage
        // session_start();
        $fee = (isset($_SESSION['tips'])) ? $_SESSION['tips'] : -1;
        $tips = get_field('tips_option_global', 8);
        if ($fee >= 0) {
            WC()->cart->add_fee(__("Tips:", "monamedia"), $fee, false);
        } elseif ($tips) {
            $fee = $tips[0]['price_number'];
            if ($fee > 0) {
                WC()->cart->add_fee(__("Tips:", "monamedia"), $fee, false);
            }
        }
    }

    //ADD NEW FIELD CHECKOUT
    public function custom_checkout_fields_before_billing_details()
    {
        $domain = 'woocommerce';
        $checkout = WC()->checkout;
        woocommerce_form_field('_order_notes', array(
            'type'          => 'textarea',
            'label'         => __('', $domain),
            'placeholder'   => __('Order notes', $domain),
            'class'         => array('form-ip col'),
            'required'      => false, // or false
        ), $checkout->get_value('_order_notes'));
    }

    // ADD THE INFORMATION AS ORDER ITEM META DATA SO THAT IT CAN BE SEEN AS PART OF THE ORDER

    function add_product_custom_field_to_order_item_meta($item_id, $values, $cart_item_key)
    {
        // the meta-key is 'Date event' because it's going to be the label too
        foreach (WC()->cart->get_cart() as $key => $cart_item) {
            if ($cart_item['toppings']) {
                wc_add_order_item_meta($item_id, '_toppings', $cart_item['toppings']);
            }
        }
    }

    // Core
    function myStartSession()
    {
        if (!session_id()) {
            session_start();
        }
    }

    function register_shipment_arrival_order_status()
    {
        register_post_status('wc-arrival-shipment', array(
            'label'                     => 'Shipment Arrival',
            'public'                    => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => true,
            'exclude_from_search'       => false,
            'label_count'               => _n_noop('Shipment Arrival <span class="count">(%s)</span>', 'Shipment Arrival <span class="count">(%s)</span>')
        ));
    }

    public function m_update_user_checkout()
    {
        $data = [];
        parse_str($_POST['data'], $data);
        $_SESSION['m-save-checkout'] = $data;
        echo json_encode(['url' => wc_get_checkout_url()]);
        exit;
    }

    public function m_update_total_cart()
    {
        get_template_part('patch/render/cart-total');
        exit;
    }

    public function m_update_number_cart()
    {
        echo WC()->cart->get_cart_contents_count();
        exit;
    }

    public function m_remove_cart_coupon()
    {
        $key = @$_POST["key"];
        // foreach ( WC()->cart->get_coupons() as $code => $coupon ){
        WC()->cart->remove_coupon($key);
        // }
        exit;
    }

    public function m_append_coupon()
    {
        $coupon = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';

        if (WC()->cart->has_discount($coupon)) {
            wp_send_json_error(
                [
                    'mess' => 'Mã giảm đã sử dụng'
                ]
            );
            wp_die();
        }
        $response = WC()->cart->apply_coupon($coupon);
        if ($response) {
            wp_send_json_success(
                array(
                    'mess' => 'Thông báo',
                )
            );
            wp_die();
        }

        wp_send_json_error(
            [
                'mess' => 'Mã giảm không hợp lệ'
            ]
        );
        wp_die();
    }

    // Cart
    public function m_update_quantity_item()
    {
        $key = @$_POST['key'];
        $qty = @$_POST['qty'];

        $cart_item = WC()->cart->get_cart_item($key);
        if ($cart_item) {
            WC()->cart->set_quantity($key, $qty);
            wp_send_json_success(
                array(
                    'mess' => 'Thông báo',
                )
            );
            wp_die();
        }

        wp_send_json_error('Có lỗi xảy ra. Vui lòng thử lại');
        wp_die();
    }
    public function m_count_cart()
    {
        $number = 0;
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $number++;
        }
        return $number;
    }

    public function m_update_minicart()
    {
        get_template_part('patch/render/cart-reload');
        exit;
    }

    public function m_add_cart_item($product_id, $qty)
    {
        if (get_post_type($product_id) == 'product') {  # check các thứ 
            $productId = esc_attr($product_id);
            $qty = esc_attr($qty);
            $product = wc_get_product($product_id);

            if ($product) {
                // Kiểm tra nếu sản phẩm là biến thể (variation)
                if ($product->is_type('variable')) {
                    $output = array('status' => 'Thông báo', 'mess' => 'Không thể thêm sản phẩm, vui lòng chọn thuộc tính.', 'link' => get_permalink($product_id));
                    echo json_encode($output);
                    exit;
                } else {
                    $cart = WC()->cart->add_to_cart($productId, $qty, 0, '', '');
                    if ($cart) {
                        $output = array('status' => 'Thông báo', 'mess' => 'Đã thêm sản phẩm vào giỏ hàng thành công.');
                        echo json_encode($output);
                        exit;
                    }
                    $output = array('status' => 'Thông báo', 'mess' => 'Không thể thêm sản phẩm vào giỏ hàng.');
                    echo json_encode($output);
                    exit;
                }
            }
        } else {
            # méo phải sản phẩm 
            $output = array('status' => 'Thông báo', 'mess' => 'Sản phẩm không tồn tại, vui lòng chọn thuộc tính khác.');
            echo json_encode($output);
            exit;
        }
    }

    public function m_add_cart()
    {
        $data = [];
        parse_str($_POST['formData'], $data);
        if ($data) {
            $this->m_add_cart_item($data['product_id'], $data['attributes'], $data['quantity'], $data['toppings']);
        }
        wp_die();
    }

    public function m_remove_cart_item()
    {
        $key = @$_POST['key'];
        $qty = @$_POST['qty'];
        $cart_item = WC()->cart->get_cart_item($key);
        if ($cart_item) {
            WC()->cart->remove_cart_item($key);
            $accessory = $cart_item['accessory'];
            if (!empty($accessory) && isset($accessory)) {
                foreach ($accessory as $key => $value) {
                    $quantity = WC()->cart->get_cart_item($value)['quantity'];
                    $qty_update = $quantity - $qty;
                    if ($qty_update == 0) {
                        WC()->cart->remove_cart_item($value);
                    } else {
                        WC()->cart->set_quantity($value, $qty_update);
                    }
                }
            }

            $number_cart = m_get_count_cart();
            ob_start();
            woocommerce_mini_cart();
            $mini_cart = ob_get_contents();
            ob_end_clean();

            ob_start();
            echo do_shortcode('[woocommerce_cart]');
            $cart_content = ob_get_contents();
            ob_end_clean();
            $output = array('mess' => 'Thông báo', 'number_cart' => $number_cart, 'mini_cart' => $mini_cart, 'cart' => $cart_content);
            wp_send_json_success($output);
            wp_die();
        }
        wp_send_json_error('Có lỗi xảy ra. Vui lòng thử lại');
        wp_die();
    }


    public  function ComboProduct($product_id = '')
    {
        if (empty($product_id)) {
            $product_id = get_the_ID();
        }
        $product      = wc_get_product($product_id);

        $product_type = $product->get_type();
        ob_start();

        if ($product_type == 'variation') {
            $proID = $product->get_parent_id();
        } else {
            $proID = $product_id;
        }
        $combo_items = get_field('list_product', $proID);

        $totalPrice = $salePrice = 0;
        if (!empty($combo_items)) {
            $current_product_obj = wc_get_product($product_id);
            if ($current_product_obj->get_type() != 'variable') {
                if ($current_product_obj->is_on_sale()) {
                    $totalPrice += $current_product_obj->get_regular_price();
                    $salePrice  += $current_product_obj->get_sale_price();
                } else {
                    $totalPrice += $current_product_obj->get_price();
                    $salePrice  += $current_product_obj->get_price();
                }
            }

?>
<div class="prddt-cb-wrap">
    <p class="t24 fw-7 mb-20">
        <?php _e('Sản phẩm nên mua kèm', '') ?>
    </p>
    <div class="prddt-cb-gr combo-block">
        <div class="prddt-cb-box combo-list__item combo-block-item check current-checked monaCalcComboSave monaComboRootJS"
            data-price_item="<?php echo ($current_product_obj->get_type() != 'variable') ? $product->get_price() : 0; ?>"
            data-price_root_item="<?php echo ($current_product_obj->get_type() != 'variable') ? $product->get_regular_price() : 0; ?>">
            <div class="prddt-cb-inner ">
                <div class="prddt-cb-img">
                    <?php
                                if (!empty(get_the_post_thumbnail($product_id, '230x190'))) {
                                    echo get_the_post_thumbnail($product_id, '230x190');
                                } else { ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/public/helpers/images/default-mona.png">
                    <?php } ?>
                </div>
                <div class="prddt-cb-ctn">
                    <div class="recheck-blocks">
                        <div class="recheck-item combo-block-check">
                            <input checked type="checkbox" name="" value="1" id=""
                                class="recheck-input combo-block-check" hidden="">
                            <div class="recheck-checkbox"></div>
                            <p class="recheck-text fw-5">
                                <?php echo get_the_title($product_id); ?>
                            </p>
                        </div>
                        <?php if ($current_product_obj->get_type() != 'variable') {  ?>
                        <?php if ($current_product_obj->is_on_sale()) { ?>
                        <div class="tprice-gr">
                            <span class="t-new">
                                <?php echo wc_price($current_product_obj->get_price()); ?>
                            </span>
                            <span class="t-odd">
                                <?php echo wc_price($current_product_obj->get_regular_price()); ?>
                            </span>
                        </div>
                        <?php } else { ?>
                        <div class="tprice-gr">
                            <span class="t-new">
                                <?php echo wc_price($current_product_obj->get_price()); ?>
                            </span>
                            <span class="t-odd"> </span>
                        </div>
                        <?php }
                                    } else { ?>
                        <div class="tprice-gr">
                            <span class="t-new">
                                <?php echo $product->get_price_html(); ?>
                            </span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="prddt-cb-icon">
            <div class="icon-inner">
                <div class="icon">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
        </div>
        <?php
                    foreach ($combo_items as $key => $combo_item) {
                        $combo_id = $combo_item['combo_id'];
                        $combo_product_by_combo_id = wc_get_product($combo_id);

                        if ($combo_product_by_combo_id) {
                            if ($combo_product_by_combo_id->is_on_sale()) {
                                $combo_product_price_root = $combo_product_by_combo_id->get_regular_price();
                            } else {
                                $combo_product_price_root = $combo_product_by_combo_id->get_regular_price();
                            }
                    ?>
        <div class="prddt-cb-box combo-block-item" data-price_item="<?php echo $combo_item['price_product']; ?>"
            data-price_root_item="<?php echo $combo_product_price_root; ?>">
            <div class="prddt-cb-inner">
                <div class="prddt-cb-img">
                    <?php
                                        if (!empty(get_the_post_thumbnail($combo_id, '230x190'))) {
                                            echo get_the_post_thumbnail($combo_id, '230x190');
                                        } else { ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/public/helpers/images/default-mona.png">
                    <?php } ?>
                </div>
                <div class="prddt-cb-ctn combo-content-item ">
                    <div class="recheck-block">
                        <div class="recheck-item combo-block-check">
                            <input type="checkbox" name="combo_items[<?php echo $key; ?>][combo_id]"
                                value="<?php echo $combo_item['combo_id']; ?>" id=""
                                class="recheck-input combo-block-input" hidden="">
                            <div class="recheck-checkbox"></div>
                            <p class="recheck-text fw-5">
                                <?php echo get_the_title($combo_id); ?>
                            </p>
                        </div>
                        <div class="tprice-gr">
                            <span class="t-new">
                                <?php echo wc_price($combo_item['price_product']); ?>
                            </span>
                            <span class="t-odd">
                                <?php echo wc_price($combo_product_price_root); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="item-qty">
                    <div class="count">
                        <div class="count-btn count-minus btn-qty">
                            <i class="fas fa-minus icon"></i>
                        </div>
                        <input type="text" value="1" name="combo_items[<?php echo $key; ?>][combo_quantity]" max="12"
                            min="0" class="count-input number" hidden="">
                        <p class="count-number">01</p>
                        <div class="count-btn count-plus btn-qty">
                            <i class="fas fa-plus icon"></i>
                        </div>
                    </div>
                </div>
                <input name="combo_items[<?php echo $key; ?>][combo_price]"
                    value="<?php echo $combo_item['price_product']; ?>" hidden>
            </div>
        </div>
        <?php }
                    } ?>
        <div class="prddt-cb-total">
            <div class="prddt-cb-total-inner combo-price">
                <div class="t-total combo-price__item --amount prddt-prd-price-box ">
                    <span>
                        <?php _e('Tổng cộng:', '') ?>
                    </span>

                    <div class="tprice-gr">
                        <span class="t24 fw-7 c-third price-new">
                            <?php echo wc_price($salePrice); ?>
                        </span>
                        <span class="t-odd price-odd">
                            <?php echo wc_price($totalPrice); ?>
                        </span>
                    </div>

                </div>
                <?php if ($salePrice <= $totalPrice) { ?>
                <div class="t-total combo-price__item --save">
                    <span class="c-third">
                        <?php _e('Tiết kiệm:', '') ?>
                    </span>
                    <span class="c-third price-new">
                        <?php echo wc_price($totalPrice - $salePrice); ?>
                    </span>
                </div>
                <?php } ?>
                <div class="btn">
                    <button type="submit" class="btn-inner mona-add-to-cart-combo-detail">
                        <span class="icon">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </span>
                        <span class="text">
                            <?php _e('Mua ngay', '') ?>
                        </span>
                        <?php get_template_part('partials/global/loading'); ?>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
<?php }
        return ob_get_clean();
    }

    public function sbw_wc_handle_buy_now()
    {
        $data = [];
        parse_str($_POST['formData'], $data);
        WC()->cart->empty_cart();
        $product_id = esc_attr($data['product_id']);
        $variation_id = esc_attr($data['attributes']);
        $qty = esc_attr($data['quantity']);
        if ($variation_id) {
            $stock = get_post_meta($variation_id, '_stock_status', true);
        } else {
            $stock = get_post_meta($product_id, '_stock_status', true);
        }

        if (get_post_type($product_id) == 'product') {
            if ($stock == 'outofstock') {
                $output = array('status' => 'Thông báo', 'mess' => 'Sản phẩm là hết hàng');
                echo json_encode($output);
                exit;
            }
            $toppings = $data['toppings'];
            if (!empty($toppings) && isset($toppings)) {
                foreach ($toppings as $item) {
                    if (get_post_type($item) == 'product') {
                        $stock = get_post_meta($item, '_stock_status', true);
                        if ($stock == 'instock') {
                            $accessory = WC()->cart->add_to_cart($item, $qty);
                            $attrs['accessory'][] = $accessory;
                            $attrs['toppings'][] = $item;
                        }
                    }
                }
            }
            if (isset($variation_id)) {
                $cart = WC()->cart->add_to_cart($product_id, $qty, $variation_id, $attrs, $attrs);
            } else {
                $cart = WC()->cart->add_to_cart($product_id, $qty, 0, $attrs, $attrs);
            }

            if ($cart) {
                $output = array('status' => 'Thông báo', 'mess' => wc_get_checkout_url());
                echo json_encode($output);
                exit;
            } else {
                $output = array('status' => 'Thông báo', 'mess' => 'Mua bây giờ không thành công, vui lòng kiểm tra lại');
                echo json_encode($output);
                exit;
            }
        }
        $output = array('status' => 'Thông báo', 'mess' => 'Mua bây giờ không thành công, vui lòng kiểm tra lại');
        echo json_encode($output);
        exit;
    }

    public  function GalleryProduct($product_id = '')
    {
        if (empty($product_id)) {
            $product_id = get_the_ID();
        }
        $product_obj            = wc_get_product($product_id);
        $product_type           = $product_obj->get_type();
        $percent_sale       = get_field('sale_price_product', $product_id);
        ob_start();
        ?>
<?php
        $mona_gallery_product = get_field('mona_gallery_product', $product_id);

        if ($product_obj->get_type() == 'variation') {
            if (!empty($mona_gallery_product)) {

        ?>
<div class="prod-dt-left-top">
    <div class="prod-dt-left-top-wr gallery">
        <div class="swiper mySwiperTop">
            <div class="swiper-wrapper">

                <?php foreach ($mona_gallery_product as $key => $attachment_id) { ?>

                <div class="swiper-slide">
                    <div class="prod-dt-left-top-img gItem" data-src="<?php echo $attachment_id; ?>">
                        <img src="<?php echo $attachment_id; ?>" alt="" srcset="" class="zoom"
                            data-magnify-src="<?php echo $attachment_id; ?>">
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>

<div class="prod-dt-left-bottom">
    <div class="prod-dt-left-bottom-wr">
        <div class="swiper mySwiperBottom">
            <div class="swiper-wrapper">

                <?php foreach ($mona_gallery_product as $key => $attachment_id) { ?>

                <div class="swiper-slide">
                    <div class="prod-dt-left-bottom-img"> <img src="<?php echo $attachment_id; ?>" alt="">
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php } else { ?>
<?php $product_id_default = wp_get_post_parent_id($product_id);
                $product_obj_default            = wc_get_product($product_id_default);
                $product_id_default_pro = $product_obj_default->get_gallery_image_ids();

                $thumbnail = get_the_post_thumbnail_url($product_id_default, 'full');
                $image_info = wp_get_attachment_image_src(get_post_thumbnail_id($product_id_default), 'full');

                if (!empty($product_id_default_pro)) { ?>

<div class="prod-dt-left-top">
    <div class="prod-dt-left-top-wr gallery">
        <div class="swiper mySwiperTop">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-top-img gItem" data-src="<?php echo $image_url = $image_info[0]; ?>">
                        <img src="<?php echo $thumbnail; ?>" alt="" class="zoom"
                            data-magnify-src="<?php echo $thumbnail; ?>">
                    </div>
                </div>

                <?php foreach ($product_id_default_pro as $key => $attachment_id) {
                                        $attachment_data = wp_get_attachment_image_src($attachment_id, 'full');
                                        if ($attachment_data) {
                                            $image_url = $attachment_data[0];
                                        }
                                    ?>

                <div class="swiper-slide">
                    <div class="prod-dt-left-top-img gItem" data-src="<?php echo $image_url; ?>">
                        <img src="<?php echo $image_url; ?>" alt="" class="zoom"
                            data-magnify-src="<?php echo $image_url; ?>">
                    </div>
                </div>

                <?php }?>

            </div>
        </div>
    </div>
</div>

<div class="prod-dt-left-bottom">
    <div class="prod-dt-left-bottom-wr">
        <div class="swiper mySwiperBottom">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-bottom-img">
                    <img src="<?php echo $thumbnail; ?>" alt="">
                    </div>
                </div>

                <?php foreach ($product_id_default_pro as $key => $attachment_id) {
                                        $attachment_data = wp_get_attachment_image_src($attachment_id, 'full');
                                        if ($attachment_data) {
                                            $image_url = $attachment_data[0];
                                        } ?>

                <div class="swiper-slide">
                    <div class="prod-dt-left-bottom-img"> <img src="<?php echo $image_url; ?>" alt="">
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php } else { ?>

<div class="prod-dt-left-top">
    <div class="prod-dt-left-top-wr gallery">
        <div class="swiper mySwiperTop">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-top-img gItem"
                        data-src="<?php echo get_the_post_thumbnail_url($product_id_default, '300x300'); ?>">

                        <?php
                                            if (!empty(get_the_post_thumbnail_url($product_id_default, '300x300'))) { ?>
                        <img src="<?php echo get_the_post_thumbnail_url($product_id_default, '300x300'); ?>" alt=""
                            class="zoom"
                            data-magnify-src="<?php echo get_the_post_thumbnail_url($product_id_default, '300x300'); ?>">
                        <?php
                                            } else {
                                                echo ' <img src="' . get_template_directory_uri() . '/public/helpers/images/default-mona.png" alt="">';
                                            } ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="prod-dt-left-bottom">
    <div class="prod-dt-left-bottom-wr">
        <div class="swiper mySwiperBottom">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-bottom-img">

                        <?php
                                            if (!empty(get_the_post_thumbnail_url($product_id_default, '300x300'))) { ?>
                        <img src="<?php echo get_the_post_thumbnail_url($product_id_default, '300x300'); ?>" alt="">
                        <?php
                                            } else {
                                                echo ' <img src="' . get_template_directory_uri() . '/public/helpers/images/default-mona.png" alt="">';
                                            } ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
                }
            }
        } else {
            $attachment_ids = $product_obj->get_gallery_image_ids();
            if (!empty($attachment_ids)) {
                $thumbnail = get_the_post_thumbnail_url($product_id, 'full');
                $image_info = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full');
                ?>


<div class="prod-dt-left-top">
    <div class="prod-dt-left-top-wr gallery">
        <div class="swiper mySwiperTop">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-top-img gItem" data-src="<?php echo $image_url = $image_info[0]; ?>">
                        <img src="<?php echo $thumbnail; ?>" alt="" class="zoom"
                            data-magnify-src="<?php echo $thumbnail; ?>">
                    </div>
                </div>

                <?php foreach ($attachment_ids as $key => $attachment_id) {
                                    $attachment_data = wp_get_attachment_image_src($attachment_id, 'full');
                                    if ($attachment_data) {
                                        $image_url = $attachment_data[0];
                                    }
                                ?>

                <div class="swiper-slide">
                    <div class="prod-dt-left-top-img gItem" data-src="<?php echo $image_url; ?>">
                        <img src="<?php echo $image_url; ?>" alt="" class="zoom"
                            data-magnify-src="<?php echo $image_url; ?>">
                    </div>
                </div>

                <?php }
                                ?>

            </div>
        </div>
    </div>
</div>

<div class="prod-dt-left-bottom">
    <div class="prod-dt-left-bottom-wr">
        <div class="swiper mySwiperBottom">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-bottom-img">
                    <img src="<?php echo $thumbnail; ?>" alt="">
                    </div>
                </div>

                <?php foreach ($attachment_ids as $key => $attachment_id) {
                                    $attachment_data = wp_get_attachment_image_src($attachment_id, 'full');
                                    if ($attachment_data) {
                                        $image_url = $attachment_data[0];
                                    }
                                ?>

                <div class="swiper-slide">
                    <div class="prod-dt-left-bottom-img"> <img src="<?php echo $image_url; ?>" alt="">
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php
            } else { ?>

<div class="prod-dt-left-top">
    <div class="prod-dt-left-top-wr gallery">
        <div class="swiper mySwiperTop">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-top-img gItem"
                        data-src="<?php echo get_the_post_thumbnail_url($product_id, '300x300'); ?>">

                        <?php
                                        if (!empty(get_the_post_thumbnail_url($product_id, '300x300'))) { ?>
                        <img src="<?php echo get_the_post_thumbnail_url($product_id, '300x300'); ?>" alt="" class="zoom"
                            data-magnify-src="<?php echo get_the_post_thumbnail_url($product_id, '300x300'); ?>">
                        <?php
                                        } else {
                                            echo ' <img src="' . get_template_directory_uri() . '/public/helpers/images/default-mona.png" alt="">';
                                        } ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="prod-dt-left-bottom">
    <div class="prod-dt-left-bottom-wr">
        <div class="swiper mySwiperBottom">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="prod-dt-left-bottom-img">

                        <?php
                                        if (!empty(get_the_post_thumbnail_url($product_id, '300x300'))) { ?>
                        <img src="<?php echo get_the_post_thumbnail_url($product_id, '300x300'); ?>" alt="">
                        <?php
                                        } else {
                                            echo ' <img src="' . get_template_directory_uri() . '/public/helpers/images/default-mona.png" alt="">';
                                        } ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php  }
        } ?>
<?php
        return ob_get_clean();
    }

    public function Variations_html($productId = '',  $attribute_primary_taxonomy = '',  $attribute_primary_first_slug = '')
    {
        if (empty($productId)) {
            $productId = get_the_ID();
        }

        ob_start();

        $product    = wc_get_product($productId);
    }

    public function m_add_cart_flash()
    {
        $data = $_POST;
        $this->m_add_cart_item($data['product_id'], $data['qty']);
    }
    public function m_update_status_product()
    {

        $customer_order = esc_attr($_POST['oderId']);
        $order      = wc_get_order($customer_order);
        $order_status = $order->get_status();
        if ($order_status == 'cancelled') {
            $output = array('status' => 'Thông báo', 'mess' => 'Đơn hàng đã hủy không hủy được');
            wp_send_json_error($output);
            wp_die();
        }
        if ($order_status !== 'completed') {
            // Cập nhật trạng thái đơn hàng thành "Hủy đơn hàng"
            $order->update_status('cancelled');
            $output = array('status' => 'Thông báo', 'mess' => 'Cập nhật thành công');
            wp_send_json_success($output);
            wp_die();
        } else {
            $output = array('status' => 'Thông báo', 'mess' => 'Đơn hàng đã hoàn thành không hủy đơn được');
            wp_send_json_error($output);
            wp_die();
        }
    }
    function mona_type_percensale($price_sale, $price)
    {
        $x = (($price_sale) / ($price)) * 100;
        $percent = 100 - $x;
        return $percent;
    }

    public function PriceProduct($product_id = '', $position = 'list')
    {
        // echo $product_id;
        // echo $position;

        if (empty($product_id)) {

            $product_id = get_the_ID();
        }

        $product      = wc_get_product($product_id);
        $product_type = $product->get_type();

        if ($product->is_on_sale()) {
            $class_onsale = 'prddt-prd-price-box-sale';
        } else {
            $class_onsale = '';
        }
        if ( !$product->is_in_stock() ) {
            $product_type = 'out_stock';
        }
        ob_start();
    ?>

<?php switch ($product_type):

    case 'out_stock': ?>
        <div class="prddt-prd-price-box prd-stock">
        <?php echo __( 'Hết hàng', 'monamedia' ); ?>
        </div>
    <?php break; 

            case 'variable': ?>
<div class="prddt-prd-price-box variable <?php echo $position; ?>">

    <?php echo $product->get_price_html(); ?>

</div>
<?php break; ?>

<?php
            case 'simple': ?>
<div class="prddt-prd-price-box simple <?php echo $position; ?> <?php echo $class_onsale; ?>">
    <?php echo $product->get_price_html(); ?>
</div>
<?php break; ?>

<?php
            default: ?>

<?php if ($position == 'list') { ?>
<div class="prddt-prd-price-box simple <?php echo $position; ?> <?php echo $class_onsale; ?>">
    <?php echo $product->get_price_html(); ?>

</div>
<?php } elseif ($position == 'detail') { ?>

<div class="prddt-prd-price-box detail <?php echo $class_onsale; ?>">
    <span class="price-new">
        <?php echo $product->get_price_html(); ?>
    </span>
    <?php
                        if ($product->is_on_sale()) {

                            if ($product->is_type('variable')) {

                                $percent_array = [];
                                $available_variations = $product->get_available_variations();
                                if (!empty($available_variations)) {

                                    foreach ($available_variations as $key => $available_variation_item) {
                                        $available_variation_id = $available_variation_item['variation_id'];
                                        $product_with_variation_id = wc_get_product($available_variation_id);
                                        if (!empty($product_with_variation_id->get_sale_price())) {
                                            $percent =  mona_type_percensale($product_with_variation_id->get_sale_price(), $product_with_variation_id->get_regular_price());
                                            $percent_array[] = $percent;
                                        }
                                    }
                                }
                            } else {

                                $percent_array = 0;
                                $available_variation_id = $product_id;
                                $product_with_variation_id = wc_get_product($available_variation_id);
                                if (!empty($product_with_variation_id->get_sale_price())) {
                                    $percent_array = mona_type_percensale($product_with_variation_id->get_sale_price(), $product_with_variation_id->get_regular_price());
                                }
                            }

                            if (is_array($percent_array)) {
                                $value = number_format(max($percent_array));
                                $percentResult = __('-', 'monamedia') . $value . __('%',  'monamedia');
                            } else {
                                $value = number_format($percent_array);
                                $percentResult = __('-', 'monamedia') . $value . __('%',  'monamedia');
                            } ?>
    <!-- <div class="prddt-prd-price-sale">
                                <div class="prd-card-sale">
                                    <span class="text">
                                        <?php echo $percentResult; ?>
                                    </span>
                                </div>
                            </div> -->
    <?php } ?>
</div>
<?php } ?>
<?php break; ?>
<?php endswitch; ?>

<?php
        return ob_get_clean();
    }

    public function top_Order_Product()
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );

        $products = get_posts($args);

        if ($products) {

            usort($products, function ($a, $b) {
                $total_sales_a = get_post_meta($a->ID, '_total_sales', true);
                $total_sales_b = get_post_meta($b->ID, '_total_sales', true);
                return $total_sales_b - $total_sales_a;
            });

            $top_products = array_slice($products, 0, 20);
            $top_product_ids = array_map(function ($product) {
                return $product->ID;
            }, $top_products);


            return $top_product_ids;
        }
    }

    function mona_wp_comment_lists($args = [], $monaProduct, $page = 1)
    {
        $comments = get_comments($args);

        if (!empty($comments) && count($comments) > 0) {
            $args_list = array(
                'walker'            => null,
                'max_depth'         => '2',
                'style'             => 'li',
                'short_ping'        => true,
                'avatar_size'       => 40,
                'callback'          => array($monaProduct, 'mona_comments'),
                'type'              => 'all',
                'reply_text'        => __('Comment', 'monamedia'),
                'page'              => $page,
                'per_page'          => '4',
                'reverse_top_level' => null,
                'reverse_children'  => ''
            );

            wp_list_comments($args_list, $comments);
        } else {
            $comment_text = '<div class="cart-emp-wrapper" style="display:flex">
                                <div class="cart-emp-img">
                                    <img src="' . get_site_url() . '/template/assets/images/empty-evaluate.png" alt="">
                                </div>
                                <p class="cart-emp-text">
                                    ' . __('Chưa có đánh giá nào ', '') . '
                                </p>
                            </div>';
            echo $comment_text;
        }
    }
    function mona_wp_form_comments()
    {

        $commenter = wp_get_current_commenter();

        $comment_form = array(
            'title_reply'          => '',
            'title_reply_to'       => '',
            'comment_notes_before' => '',
            'comment_notes_after'  => '',
            'fields'               => array(
                // 'all_fields' => '<div class="f-list row">
                //                     <div class="f-item col col-6">
                //                         <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" class="re-input" placeholder="' . esc_html__('Nhập tên của bạn', 'monamedia') . '" aria-required="true">
                //                     </div>
                //                     <div class="f-item col col-6">
                //                         <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" class="re-input" placeholder="' . esc_html__('Nhập email của bạn', 'monamedia') . '" aria-required="true">
                //                     </div>
                //                 </div>',
                'author' => '<div class="f-item col col-6">
                                        <input id="author" name="author" type="text" class="re-input" placeholder="' . esc_html__('Nhập tên của bạn', 'monamedia') . '" aria-required="true">
                                    </div>',
                'email' => ' <div class="f-item col col-6">
                                        <input id="email" name="email" type="email" class="re-input" placeholder="' . esc_html__('Nhập email của bạn', 'monamedia') . '" aria-required="true">
                                    </div>',
                'cookies' => '',
            ),
            'label_submit'  => __('Gửi bình luận', 'monamedia'),
            'logged_in_as'  => '',
            'comment_field' => '',
        );

        $comment_form['comment_field'] .= '<div class="f-item col">
                                                <textarea class="re-input area" id="comment" name="comment" cols="5" rows="5" placeholder="' . esc_html__('Nhập nội dung', 'monamedia') . '" aria-required="true"></textarea>
                                            </div>';
        $comment_form['comment_field'] .= '<div class="f-item col upLoadFile">
                                                <div class="dt-form-fl">
                                                    <div class="right">
                                                    <input class="upload-file-input upLoadInput" type="file" name="" id="upload-img" multiple="" hidden="">
                                                        <label class="dt-form-upimg upLoadBtn">
                                                            <img src="' . MONA_HOME_URL . '/template/assets/images/icon-camera.svg" alt="">
                                                            <span class="text">' . __('Thêm hình ảnh', 'monamedia') . '</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="dt-images upLoadFileWrap"> </div>
                                            </div>';

        comment_form($comment_form);
    }
    function mona_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        $user_id = $comment->user_id;

        $acount = get_userdata($user_id);
        $meta_attach_ids = get_comment_meta($comment->comment_ID, 'comment_images', false);
        $meta_rating_count = get_comment_meta($comment->comment_ID, 'rating', true);
        $comment_author_email = $comment->comment_author_email;
        $usercomment = get_user_by('email', $comment_author_email);
        // $ava_evaluate = get_field('avt', 'user_' . $user_id + 1);
        $timestamp = strtotime($comment->comment_date);
        $date = date('d/m/Y', $timestamp);

    ?>
<li class="cmt-item" <?php comment_class('cf'); ?> id="item-review-<?php comment_ID() ?>">
    <div class="cmt-wrap">
        <div class="cmt-top">
            <div class="cmt-ava">
                <?php
                        // if ($ava_evaluate) {
                        //     echo wp_get_attachment_image($ava_evaluate, 'full');
                        // } else {
                        echo '<img src="' . MONA_URL . '" alt="acc-avatar.png">';
                        // }
                        ?>
            </div>
            <div class="cmt-content">
                <p class="cmt-name"><?php echo $comment->comment_author; ?></p>
                <p class="cmt-des">
                    <?php echo esc_attr($comment->comment_content); ?>
                </p>
            </div>
        </div>
        <?php if (!empty($meta_attach_ids)) {  ?>
        <div class="cmt-images gallery">
            <div class="cmt-images-list row">
                <?php
                            foreach ($meta_attach_ids as $k => $item) {
                                $mona_attachment = $item['mona_attachment'];
                                if (!empty($mona_attachment)) {
                                    foreach ($mona_attachment as $att => $value) { ?>
                <div class="cmt-images-item col col-3">
                    <div class="cmt-images-img gItem"
                        data-src="<?php echo   wp_get_attachment_image_url($value, 'full') ?>">
                        <?php echo   wp_get_attachment_image($value, '120x120') ?>
                    </div>
                </div>
                <?php }
                                }
                            }
                            if (count($meta_attach_ids) > 2) echo '<span class="numMore">' . count($meta_attach_ids) . '</span>';
                            ?>
            </div>
        </div>
        <?php } ?>
        <div class="cmt-ctr">
            <div class="cmt-ctr-list">
                <div class="cmt-ctr-item">
                    <div class="cmt-ctr-anw">
                        <img src="<?php echo MONA_HOME_URL; ?>/template/assets/images/icon-mess.svg" alt="">
                        <span class="text">Trả lời</span>
                    </div>
                </div>
                <div class="cmt-ctr-item">
                    <p class="cmt-timed">
                        <?php echo esc_attr($date); ?>
                    </p>
                </div>
            </div>
            <div class="cmt-anw-input">
                <textarea class="re-input area" name="" cols="30" rows="3" placeholder="Nội dung"> </textarea>
                <button class="cmt-anw-input-btn m-comment-reply" data-id-comment="<?php echo $comment->comment_ID ?>">
                    <img src="<?php echo MONA_HOME_URL; ?>/template/assets/images/icon-send.svg" alt="">
                </button>
            </div>
        </div>
    </div>

    <!-- </li> -->
    <?php }
}

(new MonaProductClass())->__init();


function m_get_filter($args, $filter)
{
    return (new MonaProductClass())->get_filter($args, $filter);
}

function m_get_total_cart_item($product_id, $attr, $accessory)
{
    return (new MonaProductClass())->m_total_cart_item($product_id, $attr, $accessory);
}

function m_get_count_wishlist()
{
    return (new MonaProductClass())->m_count_wishlist();
}

function m_get_active_wishlist($product_id)
{
    return (new MonaProductClass())->m_active_wishlist($product_id);
}

function m_get_count_cart()
{
    return (new MonaProductClass())->m_count_cart();
}