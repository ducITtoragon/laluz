<?php
add_action('after_setup_theme', 'add_after_setup_theme');
function add_after_setup_theme()
{
    add_theme_support('woocommerce');
    // regsiter menu
    register_nav_menus(
        [
            'primary-menu' => __('Theme Main Menu', 'monamedia'),
            'about-menu'    => __('Theme About Menu', 'monamedia'),
            'mobile-menu'   => __('Theme Mobile Menu', 'monamedia'),
            'footer-menu'   => __('Theme Footer Menu', 'monamedia'),
        ]
    );
    // add size image
    // add_image_size( 'banner-desktop-image', 1920, 790, false );
    // add_image_size( 'banner-mobile-image', 400, 675, false );

}

add_action('wp_enqueue_scripts', 'mona_add_styles_scripts');
function mona_add_styles_scripts()
{
    // loading css
    wp_enqueue_style('mona-custom', get_template_directory_uri() . '/public/css/mona-custom.css', array(), rand());
    // load css / page 404
    (new MonaSettingNotFound())->__front_styles();
    // load css / page buttons
    (new MonaSettingButtons())->__front_styles();
    // loading js
    wp_enqueue_script('mona-frontend', get_template_directory_uri() . '/public/scripts/mona-frontend.js', array(), rand(), true);

    wp_localize_script(
        'mona-frontend',
        'mona_ajax_url',
        [
            'ajaxURL'   => admin_url('admin-ajax.php'),
            'siteURL'   => get_site_url(),
            'ajaxNonce' => wp_create_nonce('mona-ajax-security'),
        ]
    );
}

add_filter('script_loader_tag', 'mona_add_module_to_my_script', 10, 3);
function mona_add_module_to_my_script($tag, $handle, $src)
{
    if ('mona-frontend' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}

//add_action( 'wp_logout', 'mona_redirect_external_after_logout' );
function mona_redirect_external_after_logout()
{
    wp_redirect(get_the_permalink(MONA_PAGE_HOME));
    exit();
}

add_filter('pre_get_posts', 'mona_parse_request_post_type');
function mona_parse_request_post_type($query)
{
    if (!is_admin()) {
        $query->set('ignore_sticky_posts', true);
        $ptype = $query->get('post_type', true);
        $ptype = (array) $ptype;

        if (isset($_GET['s'])) {
            $ptype[] = 'product';
            $query->set('post_type', $ptype);
            $query->set('posts_per_page', 10);
        }

        // if ( $query->is_main_query() && $query->is_tax( 'category_library' ) ) {
        //     $ptype[] = 'mona_library';
        //     $query->set('post_type', $ptype);
        //     $query->set('posts_per_page', 12);
        // }

    }
    return $query;
}

add_action('widgets_init', 'mona_register_sidebars');
function mona_register_sidebars()
{
    register_sidebar(
        [
            'id'            => 'footer_column1',
            'name'          => __('Footer Column 1', 'mona-admin'),
            'description'   => __('Nội dung widget.', 'mona-admin'),
            'before_widget' => '<div id="%1$s" class="widget footer-menu-item footer-menu-item-first %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="head mona-widget-title">',
            'after_title'   => '</h3>',
        ]
    );
}

add_filter('display_post_states', 'mona_add_post_state', 10, 2);
function mona_add_post_state($post_states, $post)
{
    if ($post->ID == MONA_PAGE_HOME) {
        $post_states[] = __('PAGE - Trang chủ', 'mona-admin');
    }
    if ($post->ID == MONA_PAGE_BLOG) {
        $post_states[] = __('PAGE - Trang Tin tức', 'mona-admin');
    }
    return $post_states;
}

//add_filter( 'get_custom_logo', 'mona_change_logo_class' );
function mona_change_logo_class($html)
{
    $custom_logo_id = get_theme_mod('custom_logo');
    $html           = sprintf(
        '<a href="%1$s" class="header-icon" rel="home" itemprop="url"><div class="icon">%2$s</div></a>',
        esc_url(home_url()),
        wp_get_attachment_image(
            $custom_logo_id,
            'full',
            false,
            [
                'class'  => 'header-logo-image',
            ]
        )
    );
    return $html;
}

add_filter('admin_url', 'mona_filter_admin_url', 999, 3);
function mona_filter_admin_url($url, $path, $blog_id)
{
    if ($path === 'admin-ajax.php' && !is_admin()) {
        $url .= '?mona-ajax';
    }
    return $url;
}

add_filter('wp_get_attachment_image_attributes', 'mona_image_remove_attributes');
function mona_image_remove_attributes($attr)
{
    unset($attr['sizes']);
    return $attr;
}

add_action(' wp_footer', 'mona_filter_front_footer');
function mona_filter_front_footer()
{
    echo '<div id="mona-toast"></div>';
}

add_filter('post_thumbnail_html', 'mona_set_post_thumbnail_default', 20, 5);
function mona_set_post_thumbnail_default($html, $post_id, $post_thumbnail_id, $size, $attr)
{
    if (empty($html)) {
        return wp_get_attachment_image(MONA_CUSTOM_LOGO, 'full', "", ['class' => 'cg-image-default']);
    }
    return $html;
}

add_filter('woocommerce_product_variation_title_include_attributes', '__return_false');
add_filter('woocommerce_is_attribute_in_product_name', '__return_false');

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_single_product_summary', function () {
    get_template_part('partials/templates/single-product/single-title');
}, 5);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', function () {
    get_template_part('partials/templates/single-product/single-rating');
}, 5);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
add_action('woocommerce_template_single_price', 'woocommerce_variation_price_html', 20);

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_filter('woocommerce_reset_variations_link', '__return_empty_string');

add_filter('woocommerce_product_tabs', 'mona_remove_reviews_tab', 98);
function mona_remove_reviews_tab($tabs)
{
    unset($tabs['description']);
    unset($tabs['additional_information']);
    return $tabs;
}

add_filter('woocommerce_get_price_html', 'mona_change_style_price', 10, 2);
function mona_change_style_price($price, $product)
{
    $product_id            = $product->get_id();
    $default_price_regular = get_post_meta($product_id, '_regular_price', true);
    $default_price_sale    = get_post_meta($product_id, '_sale_price', true);
    // change price
    // check price
    if (!$product->is_in_stock()) {
        if (!is_singular('product')) {
            $price = '<span class="info-prc-new">' . __('Hết hàng', 'monamedia') . '</span>';
        }
    } elseif ($default_price_sale != '') {
        $sale_price = mona_type_percensale($default_price_sale, $default_price_regular);
        $price = '<span class="info-prc-new">' . wc_price($default_price_sale) . '</span>';
        $price .= '<span class="info-prc-old" data-dis="' . $sale_price . '">' . wc_price($default_price_regular) . '</span>';
    } elseif ($product->is_type('variable')) {
        /// Searching for the default variation
        $default_attributes = $product->get_default_attributes();
        // Loop through available variations
        foreach ($product->get_available_variations() as $variation) {
            $found = true; // Initializing
            // Loop through variation attributes
            foreach ($variation['attributes'] as $key => $value) {
                $taxonomy = str_replace('attribute_', '', $key);
                // Searching for a matching variation as default
                if (isset($default_attributes[$taxonomy]) && $default_attributes[$taxonomy] != $value) {
                    $found = false;
                    break;
                }
            }
            // When it's found we set it and we stop the main loop
            if ($found) {
                $default_variaton = $variation;
                break;
            } // If not we continue
            else {
                continue;
            }
        }
        // Get the default variation prices or if not set the variable product min prices
        $regular_price = isset($default_variaton) ? $default_variaton['display_price'] : $product->get_variation_regular_price('min', true);
        $sale_price    = isset($default_variaton) ? $default_variaton['display_regular_price'] : $product->get_variation_sale_price('min', true);
        if ($product->is_on_sale()) {
            $price = '<span class="price-prod">
                <span class="price sales">' . wc_price($sale_price) . '</span>
                <span class="price normal">' . wc_price($sale_price) . '</span>
            </span>';
        } else {
            //     <span class="pri-flex">
            //     <span class="price normal">' . wc_price($product->get_variation_sale_price('min', true)) . '</span>
            //     -
            //     <span class="price normal">' . wc_price($product->get_variation_sale_price('max', true)) . '</span>
            // </span>
            $price = '<span class="price-prod pri-flex">
                <span class="pri-flex">
                    <span class="price normal">' . wc_price($product->get_variation_sale_price('max', true)) . '</span>
                </span>
            </span>';
        }
    } elseif (empty($default_price_regular)) {
        $price = '<span class="price-prod">' . __('Giá liên hệ', 'monamedia') . '</span>';
    } else {
        $price = '<span class="price-prod">
            <span class="price normal">' . wc_price($default_price_regular) . '</span>
        </span>';
    }
    return $price;
}

add_action('woocommerce_after_add_to_cart_button', 'mona__additional_button');
function mona__additional_button()
{
}
// fragment 
add_action('wp_ajax_mona_cart_fragments',  'mona_cart_fragments'); // login
add_action('wp_ajax_nopriv_mona_cart_fragments',  'mona_cart_fragments'); // no login
function mona_cart_fragments()
{
    wp_send_json_success(
        WC_AJAX::get_refreshed_fragments()
    );
}

add_filter('woocommerce_add_to_cart_fragments', 'mona_cart_count_fragments', 10, 1);

function mona_cart_count_fragments($fragments)
{
    ob_start();
    woocommerce_mini_cart();
    $mini_cart_content = ob_get_clean();

    $fragments['#mona-cart-qty'] = '<div class="quantity" id="mona-cart-qty">' . WC()->cart->get_cart_contents_count() . '</div>';

    $fragments['#m_mini_cart'] = '<div class="bds widget_shopping_cart_content" id="m_mini_cart">' . $mini_cart_content . '</div>';

    $fragments['#update-qty'] = ' <p class="hds-text" id="update-qty">(' . WC()->cart->get_cart_contents_count() . ')</div>';

    $fragments['#total-cart'] = '<p class="val" id="total-cart">' . wc_price(WC()->cart->get_cart_contents_total()) . '</div>';

    return $fragments;
}
/*
* Remove product-category in URL
* Thay product-category bằng slug hiện tại của bạn. Mặc định là product-category
*/
add_filter('term_link', 'devvn_product_cat_permalink', 10, 3);
function devvn_product_cat_permalink($url, $term, $taxonomy)
{
    switch ($taxonomy):
        case 'product_cat':
            $taxonomy_slug = 'danh-muc-san-pham'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_thuong_hieu':
            $taxonomy_slug = 'category-thuong-hieu'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_nuoc_hoa':
            $taxonomy_slug = 'category-nuoc-hoa'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_nong_do':
            $taxonomy_slug = 'category-nong-do'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_nhom_huong':
            $taxonomy_slug = 'category-nhom-huong'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
        case 'category_dung_tich':
            $taxonomy_slug = 'category-dung-tich'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if (strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
    endswitch;
    return $url;
}
// Add our custom product cat rewrite rules
function devvn_product_category_rewrite_rules($flash = false)
{
    $taxonomies = array('product_cat', 'category_thuong_hieu', 'category_nuoc_hoa', 'category_nong_do', 'category_nhom_huong', 'category_dung_tich'); // Thêm taxonomy mới vào đây nếu có
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'post_type' => 'product', // Thay đổi nếu có post type khác
            'hide_empty' => false,
        ));
        if ($terms && !is_wp_error($terms)) {
            $siteurl = esc_url(home_url('/'));
            foreach ($terms as $term) {
                $term_slug = $term->slug;
                $baseterm = str_replace($siteurl, '', get_term_link($term->term_id, $taxonomy));
                add_rewrite_rule($baseterm . '?$', 'index.php?' . $taxonomy . '=' . $term_slug, 'top');
                add_rewrite_rule($baseterm . 'page/([0-9]{1,})/?$', 'index.php?' . $taxonomy . '=' . $term_slug . '&paged=$matches[1]', 'top');
                add_rewrite_rule($baseterm . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?' . $taxonomy . '=' . $term_slug . '&feed=$matches[1]', 'top');
            }
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'devvn_product_category_rewrite_rules');

/*Sửa lỗi khi tạo mới taxomony bị 404*/
add_action('create_term', 'devvn_new_product_cat_edit_success', 10, 2);
function devvn_new_product_cat_edit_success($term_id, $taxonomy)
{
    devvn_product_category_rewrite_rules(true);
}

/*
* Code Bỏ /product/ hoặc /cua-hang/ hoặc /shop/ ... có hỗ trợ dạng %product_cat%
* Thay /cua-hang/ bằng slug hiện tại của bạn
*/
function devvn_remove_slug($post_link, $post)
{
    if (!in_array(get_post_type($post), array('product')) || 'publish' != $post->post_status) {
        return $post_link;
    }
    if ('product' == $post->post_type) {
        $post_link = str_replace('/san-pham/', '/', $post_link); //Thay cua-hang bằng slug hiện tại của bạn
    } else {
        $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
    }
    return $post_link;
}


add_filter('post_type_link', 'devvn_remove_slug', 10, 2);
/*Sửa lỗi 404 sau khi đã remove slug product hoặc cua-hang*/
function devvn_woo_product_rewrite_rules($flash = false)
{
    global $wp_post_types, $wpdb;
    $siteLink = esc_url(home_url('/'));
    foreach ($wp_post_types as $type => $custom_post) {
        if ($type == 'product') {
            if ($custom_post->_builtin == false) {
                $querystr = "SELECT {$wpdb->posts}.post_name, {$wpdb->posts}.ID
                            FROM {$wpdb->posts} 
                            WHERE {$wpdb->posts}.post_status = 'publish' 
                            AND {$wpdb->posts}.post_type = '{$type}'";
                $posts = $wpdb->get_results($querystr, OBJECT);
                foreach ($posts as $post) {
                    $current_slug = get_permalink($post->ID);
                    $base_product = str_replace($siteLink, '', $current_slug);
                    add_rewrite_rule($base_product . '?$', "index.php?{$custom_post->query_var}={$post->post_name}", 'top');
                    add_rewrite_rule($base_product . 'comment-page-([0-9]{1,})/?$', 'index.php?' . $custom_post->query_var . '=' . $post->post_name . '&cpage=$matches[1]', 'top');
                    add_rewrite_rule($base_product . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?' . $custom_post->query_var . '=' . $post->post_name . '&feed=$matches[1]', 'top');
                }
            }
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'devvn_woo_product_rewrite_rules');


/*Fix lỗi khi tạo sản phẩm mới bị 404*/
function devvn_woo_new_product_post_save($post_id)
{
    global $wp_post_types;
    $post_type = get_post_type($post_id);
    foreach ($wp_post_types as $type => $custom_post) {
        if ($custom_post->_builtin == false && $type == $post_type) {
            devvn_woo_product_rewrite_rules(true);
        }
    }
}
add_action('wp_insert_post', 'devvn_woo_new_product_post_save');

// Modify category base to /blog/
// function devvn_modify_category_base()
// {
//     global $wp_rewrite;
//     $wp_rewrite->extra_permastructs['category']['struct'] = '/%category%';
// }
// add_action('init', 'devvn_modify_category_base');

// function devvn_redirect_old_category_urls()
// {
//     if (is_category() && strpos($_SERVER['REQUEST_URI'], '') !== false) {
//         $redirect_url = str_replace('', '', 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//         wp_redirect($redirect_url, 301);
//         exit();
//     }
// }

// function remove_category($string, $type)
// {
//     if ($type != 'single' && $type == 'category' && (strpos($string, 'category') !== false)) {
//         $url_without_category = str_replace("/category/", "/", $string);
//         return trailingslashit($url_without_category);
//     }
//     return $string;
// }
// add_filter('user_trailingslashit', 'remove_category', 100, 2);

// xóa khoảng trắng giữa giá và đơn vị tiền tệ 
add_filter('woocommerce_get_price_html', 'remove_bdi_and_space', 10, 2);

function remove_bdi_and_space($price, $product)
{
    // Loại bỏ thẻ bdi
    $price = preg_replace('/<bdi>(.*?)<\/bdi>/', '$1', $price);

    // Loại bỏ khoảng trắng &nbsp;
    $price = str_replace('&nbsp;', '', $price);

    return $price;
}
