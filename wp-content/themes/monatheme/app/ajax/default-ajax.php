<?php
add_action('wp_ajax_mona_ajax_pagination_posts',  'mona_ajax_pagination_posts'); // login
add_action('wp_ajax_nopriv_mona_ajax_pagination_posts',  'mona_ajax_pagination_posts'); // no login
function mona_ajax_pagination_posts()
{
    $form = array();
    parse_str($_POST['formdata'], $form);
    $paged              = $_POST['paged'] ? $_POST['paged'] : 1;
    $action             = $_POST['action_layout'] ? $_POST['action_layout'] : 'reload';
    $flagAction         = $_POST['action_flag'];

    $action_return      = $action;
    $post_type          = $form['post_type'] ? $form['post_type'] : 'post';
    $posts_per_page     = $form['posts_per_page'] ? $form['posts_per_page'] : 9;
    $offset             = ($paged - 1) * $posts_per_page;
    $order              = 'DESC';
    $argsPost = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset,
        'meta_query' => [
            'relation' => 'AND',
        ],
        'tax_query' => [
            'relation' => 'AND',
        ]
    );
    // search
    if (isset($form['findProduct']) && !empty($form['findProduct'])) {
        $findProductValue = sanitize_text_field($form['findProduct']);

        $argsPost['s'] = $findProductValue;
    }

    if (isset($form['s']) && !empty($form['s'])) {
        $argsPost['s'] = esc_attr($form['s']);
    }
    // search
    if (isset($form['findProduct']) && !empty($form['findProduct'])) {
        $findProductValue = sanitize_text_field($form['findProduct']);

        $argsPost['s'] = $findProductValue;
    }

    /** Không được gỡ **/
    if ($flagAction == 'false' && $action == 'loadmore' && (isset($form['s']) || isset($form['sort']))) {
        $action_return = 'reload';
    }

    // product_cat
    if (is_array($form['taxonomies']) && !empty($form['taxonomies'])) {
        foreach ($form['taxonomies'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // taxonomy
    if (is_array($form['taxonomy']) && !empty($form['taxonomy'])) {
        foreach ($form['taxonomy'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }
    // taxonomy_mua
    if (is_array($form['taxonomy_mua']) && !empty($form['taxonomy_mua'])) {
        foreach ($form['taxonomy_mua'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }
    // taxonomy_nhom_huong
    if (is_array($form['taxonomy_nhom_huong']) && !empty($form['taxonomy_nhom_huong'])) {
        foreach ($form['taxonomy_nhom_huong'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // taxonomy_dung_tich
    if (is_array($form['taxonomy_dung_tich']) && !empty($form['taxonomy_dung_tich'])) {
        foreach ($form['taxonomy_dung_tich'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // taxonomy_nong_do
    if (is_array($form['taxonomy_nong_do']) && !empty($form['taxonomy_nong_do'])) {
        foreach ($form['taxonomy_nong_do'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // taxonomy_theo_gia
    if (is_array($form['taxonomy_theo_gia']) && !empty($form['taxonomy_theo_gia'])) {
        foreach ($form['taxonomy_theo_gia'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }
    // taxonomy_thuong_hieu
    if (is_array($form['taxonomy_thuong_hieu']) && !empty($form['taxonomy_thuong_hieu'])) {
        foreach ($form['taxonomy_thuong_hieu'] as $taxonomy => $slug) {
            if ($slug != '') {
                $argsPost['tax_query'][] =  array(
                    'taxonomy'  => $taxonomy,
                    'field'     => 'slug',
                    'terms'     => $slug,
                    'operator'  => 'IN'
                );
            }
        }
    }

    // price_min,price_max 
    if (isset($form['price_min']) && is_numeric($form['price_min']) && isset($form['price_max']) && is_numeric($form['price_max'])) {
        $argsPost['meta_query'][] = array(
            'relation' => 'OR',

            array(
                'key' => '_sale_price',
                'value' => array($form['price_min'], $form['price_max']),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            ),

            array(
                'key' => '_price',
                'value' => array($form['price_min'], $form['price_max']),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            )
        );
    }

    // rating
    if (isset($form['rating']) && is_array($form['rating'])) {
        $argsPost['meta_query'][] = array(
            'key' => '_wc_average_rating',
            'value' => $form['rating'],
            'compare' => '=',
            'type' => 'NUMERIC',
        );
    }

    if ($post_type == 'product') {

        if (isset($form['prices']) && is_array($form['prices']) && !empty($form['prices'])) {

            $priceArray = $form['prices'];
            $postIDs_byPrice = [];

            global $wpdb;
            $sql = "SELECT DISTINCT p.ID
                FROM {$wpdb->prefix}posts AS p
                INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
                WHERE p.post_type = 'product'
                AND p.post_status = 'publish'
                AND pm.meta_key = '_price'";

            $conditions = [];
            foreach ($priceArray as $index => $price) {
                $active = isset($price['active']) ? $price['active'] : '';
                if (!empty($active)) {
                    $option = isset($price['option']) ? $price['option'] : '';
                    if ($option === 'less') {
                        $single = isset($price['single']) ? floatval($price['single']) : 0;
                        $conditions[] = "(pm.meta_value < {$single})";
                    } elseif ($option === 'range') {
                        $from = isset($price['from']) ? floatval($price['from']) : 0;
                        $to = isset($price['to']) ? floatval($price['to']) : 0;
                        $conditions[] = "(pm.meta_value >= {$from} AND pm.meta_value <= {$to})";
                    } elseif ($option === 'more') {
                        $single = isset($price['single']) ? floatval($price['single']) : 0;
                        $conditions[] = "(pm.meta_value > {$single})";
                    }
                }
            }

            if (!empty($conditions)) {
                $sql .= ' AND (' . implode(' OR ', $conditions) . ')';
            }

            $results = $wpdb->get_results($sql);
            if ($results) {
                foreach ($results as $result) {
                    $postIDs_byPrice[] = $result->ID;
                }

                if (is_array($postIDs_byPrice) && !empty($postIDs_byPrice)) {
                    $argsPost['post__in'] = $postIDs_byPrice;
                }
            }
        }

        if (isset($form['sort']) && !empty($form['sort'])) {
            $sort = $form['sort'];
            switch ($sort) {
                case 'az':
                    $argsPost['orderby'] = 'title';
                    $argsPost['order']   = 'ASC';
                    break;

                case 'za':
                    $argsPost['orderby'] = 'title';
                    $argsPost['order']   = 'DESC';
                    break;

                case 'lowtohigh':
                    $argsPost['orderby']['meta_price'] = 'ASC';
                    $argsPost['meta_query']['meta_price'] = [
                        'key'               => '_price',
                        'compare'           => 'EXISTS',
                    ];
                    break;

                case 'hightolow':
                    $argsPost['orderby']['meta_price'] = 'DESC';
                    $argsPost['meta_query']['meta_price'] = [
                        'key'               => '_price',
                        'compare'           => 'EXISTS',
                    ];
                    break;

                case 'featured':
                    $argsPost['tax_query'][] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN',
                    );
                    break;

                default:
                    $argsPost['orderby']['meta_total_sales'] = 'DESC';
                    $argsPost['meta_query']['meta_total_sales'] = [
                        'key'               => 'total_sales',
                        'value'             => intval(0),
                        'compare'           => '>=',
                        'type'               => 'NUMERIC'
                    ];
                    break;
            }
        }
    } else {

        if (isset($form['sort']) && !empty($form['sort'])) {
            $sort = esc_attr($form['sort']);
            switch ($sort) {
                case 'view':
                    $argsPost['meta_query']['meta_view'] = [
                        'key' => '_mona_post_view',
                        'value' => 0,
                        'compare' => '>=',
                        'type' => 'numeric',
                    ];
                    $argsPost['orderby']['meta_view'] = 'desc';
                    break;

                case 'asc':
                    $argsPost['order'] = 'asc';
                    break;

                default:
                    $argsPost['order'] = 'desc';
                    break;
            }
        } else {
            $argsPost['order'] = 'desc';
        }
    }


    ob_start();
    $postsMONA = new WP_Query($argsPost);
    if ($postsMONA->have_posts()) { ?>

        <?php
        while ($postsMONA->have_posts()) {
            $postsMONA->the_post();
            if ($post_type == 'product') {
                $class_item = 'prod-it';
            }
        ?>

            <div class="<?php echo $class_item; ?>">
                <?php
                switch ($post_type) {

                    case 'product':

                        /**
                         * GET TEMPLATE PART
                         * product-inner
                         */
                        // $slug = '/partials/loop/product';
                        // $name = 'inner';
                        // echo get_template_part($slug, $name);

                        get_template_part('partials/product/item');
                        break;
                }
                ?>
            </div>

        <?php }
        wp_reset_query(); ?>



        <?php if ($action == 'reload') { ?>

            
                <?php
                mona_pagination_links_ajax($postsMONA, $paged);
                ?>
            

        <?php } else if ($action == 'loadmore') { ?>

            <?php if ($paged < $postsMONA->max_num_pages) { ?>
                <div class="btn-more monaLoadMoreJS is-loading-btn" data-paged="<?php echo ++$paged; ?>">
                    <span class="text">
                        <?php _e('Xem thêm', 'monamedia'); ?>
                    </span>
                </div>
            <?php } ?>

        <?php } ?>

    <?php } else { ?>

        <div class="container">
            <a href="<?php echo site_url('cua-hang/') ?>" class="empty-product">
                <div class="image-empty-product">
                    <img src="<?php get_site_url(); ?>/template/assets/images/empty-product-1.png" alt="this is a image of empty product">
                </div>
                <p class="text">
                    <?php _e('Hiện tại, sản phẩm bạn đang tìm kiếm không tồn tại. Vui lòng quay lại sau hoặc liên hệ với chúng tôi', 'monamedia'); ?>
                </p>
                <a class="btn noic product-empty-button" href="<?php echo site_url('cua-hang/') ?>">
                    <span class="txt">
                        <?php _e('Cửa hàng', 'monamedia') ?>
                    </span>
                </a>
            </a>
        </div>

    <?php } ?>

    <?php
    switch ($post_type) {
        default:
            $class_scroll = 'monaPostsList';
            break;
    }
    wp_send_json_success(
        [
            'title'         => __('Thông báo!', 'monamedia'),
            'message'       =>  __('Load thêm thành công!', 'monamedia'),
            'title_close'   =>  __('Đóng', 'monamedia'),
            'posts_html'    => ob_get_clean(),
            'argsPosts'     => $argsPost,
            'scroll'        => $class_scroll,
            'action_return' => $action_return
        ]
    );
    wp_die();
}

add_action('wp_ajax_mona_ajax_pagination_products',  'mona_ajax_pagination_products'); // login
add_action('wp_ajax_nopriv_mona_ajax_pagination_products',  'mona_ajax_pagination_products'); // no login
function mona_ajax_pagination_products()
{
    $paged              = $_POST['paged'] ? $_POST['paged'] : 1;
    $form = array();
    parse_str($_POST['formdata'], $form);
    $post_type          = $form['post_type'] ? $form['post_type'] : 'post';
    $posts_per_page     = $form['posts_per_page'] ? $form['posts_per_page'] : 12;
    $offset             = ($paged - 1) * $posts_per_page;
    $order              = 'DESC';
    $argsPost = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset,
        'meta_query' => [
            'relation' => 'AND',
        ],
        'tax_query' => [
            'relation' => 'AND',
        ]
    );

    if (!empty($form['s'])) {
        $argsPost['s'] = esc_attr($form['s']);
    }

    if (!empty($form['taxonomies'])) {
        if (is_array($form['taxonomies'])) {
            foreach ($form['taxonomies'] as $taxonomy => $slug) {
                if ($slug != '') {
                    $argsPost['tax_query'][] =  array(
                        'taxonomy'  => $taxonomy,
                        'field'     => 'slug',
                        'terms'     => $slug,
                        'operator'  => 'IN'
                    );
                }
            }
        }
    }

    if (isset($form['prices']) && is_array($form['prices']) && !empty($form['prices'])) {
        $priceArray = $form['prices'];
        $postIDs_byPrice = [];
        global $wpdb;
        $sql = "SELECT DISTINCT p.ID
            FROM {$wpdb->prefix}posts AS p
            INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
            WHERE p.post_type = 'product'
            AND p.post_status = 'publish'
            AND pm.meta_key = '_price'";

        $conditions = [];
        foreach ($priceArray as $index => $price) {
            $active = isset($price['active']) ? $price['active'] : '';
            if (!empty($active)) {
                $option = isset($price['option']) ? $price['option'] : '';
                if ($option === 'less') {
                    $single = isset($price['single']) ? floatval($price['single']) : 0;
                    $conditions[] = "(pm.meta_value < {$single})";
                } elseif ($option === 'range') {
                    $from = isset($price['from']) ? floatval($price['from']) : 0;
                    $to = isset($price['to']) ? floatval($price['to']) : 0;
                    $conditions[] = "(pm.meta_value >= {$from} AND pm.meta_value <= {$to})";
                } elseif ($option === 'more') {
                    $single = isset($price['single']) ? floatval($price['single']) : 0;
                    $conditions[] = "(pm.meta_value > {$single})";
                }
            }
        }

        if (!empty($conditions)) {
            $sql .= ' AND (' . implode(' OR ', $conditions) . ')';
        }

        $results = $wpdb->get_results($sql);
        if ($results) {
            foreach ($results as $result) {
                $postIDs_byPrice[] = $result->ID;
            }

            if (is_array($postIDs_byPrice) && !empty($postIDs_byPrice)) {
                $argsPost['post__in'] = $postIDs_byPrice;
            }
        }
    }

    if (isset($form['sort']) && !empty($form['sort'])) {
        $sort = $form['sort'];
        switch ($sort) {
            case 'az':
                $argsPost['orderby'] = 'title';
                $argsPost['order']   = 'ASC';
                break;

            case 'za':
                $argsPost['orderby'] = 'title';
                $argsPost['order']   = 'DESC';
                break;

            case 'lowtohigh':
                $argsPost['orderby']['meta_price'] = 'ASC';
                $argsPost['meta_query']['meta_price'] = [
                    'key'               => '_price',
                    'compare'           => 'EXISTS',
                ];
                break;

            case 'hightolow':
                $argsPost['orderby']['meta_price'] = 'DESC';
                $argsPost['meta_query']['meta_price'] = [
                    'key'               => '_price',
                    'compare'           => 'EXISTS',
                ];
                break;

            case 'featured':
                $argsPost['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
                break;

            default:
                $argsPost['orderby']['meta_total_sales'] = 'DESC';
                $argsPost['meta_query']['meta_total_sales'] = [
                    'key'               => 'total_sales',
                    'value'             => intval(0),
                    'compare'           => '>=',
                    'type'               => 'NUMERIC'
                ];
                break;
        }
    }

    ob_start();
    $postsMONA = new WP_Query($argsPost);
    if ($postsMONA->have_posts()) { ?>

        <?php
        while ($postsMONA->have_posts()) {
            $postsMONA->the_post();
            $class_item = 'dsmall-item pro-item pro-item-3 product-mona';
        ?>
            <div class="<?php echo $class_item; ?>">
                <?php
                /**
                 * GET TEMPLATE PART
                 * product
                 */
                $slug = '/partials/loop/box';
                $name = 'product';
                echo get_template_part($slug, $name, ['keyword' => esc_attr($form['s'])]);
                ?>
            </div>
        <?php }
        wp_reset_query(); ?>

        
            <?php mona_pagination_links_ajax($postsMONA, $paged); ?>
       

    <?php } else { ?>

        <div class="mona-empty-message-large">
            <p><?php echo __('No posts were found matching your search filter!', 'monamedia') ?></p>
        </div>

    <?php } ?>

    <?php
    $class_scroll = 'pro-list';
    wp_send_json_success(
        [
            'title'             => __('Alert!', 'monamedia'),
            'message'           =>  __('Successful!', 'monamedia'),
            'title_close'       =>  __('Close', 'monamedia'),
            'products_html'     => ob_get_clean(),
            'products_count'    => $postsMONA->have_posts() ? $postsMONA->found_posts : 0,
            'argsPosts'         => $argsPost,
            'scroll'            => $class_scroll,
            'keyword'           => esc_attr($form['s'])
        ]
    );
    wp_die();
}


add_action('wp_ajax_mona_ajax_search_category',  'mona_ajax_search_category'); // login
add_action('wp_ajax_nopriv_mona_ajax_search_category',  'mona_ajax_search_category'); // no login
function mona_ajax_search_category()
{
    $form = array();
    parse_str($_POST['formdata'], $form);
    $taxonomy_thuong_hieu = $form['taxonomy_thuong_hieu'];
    $product_cat_values = $taxonomy_thuong_hieu['product_cat'];
    $britney_spears_value = $product_cat_values[0];

    $val = sanitize_text_field($_POST['val']);

    $parent_cat_thuong_hieu = get_terms(array(
        'taxonomy' => 'category_thuong_hieu',
        'parent' => 0,
        'hide_empty' => false,
    ));

    $args = array(
        'taxonomy'   => 'category_thuong_hieu',
        'hide_empty' => false,
        'parent'     => $parent_cat_thuong_hieu->term_id,
        'search'     => $val,
    );

    $child_cats_thuong_hieu = get_terms($args);

    // Lọc danh sách các danh mục
    $filtered_cats = array_filter($child_cats_thuong_hieu, function ($cat) use ($val) {
        return strpos(strtolower($cat->name), strtolower($val[0])) === 0;
    });

    ob_start();
    if (!empty($child_cats_thuong_hieu)) { ?>

        <div class="filter-list row">
            <?php foreach ($child_cats_thuong_hieu as $child_cat) { ?>

                <?php echo $britney_spears_value; ?>

                <div class="filter-item col">
                    <label for="<?php echo $child_cat->slug; ?>">
                        <input type="radio" name="taxonomy_thuong_hieu[<?php echo $child_cat->taxonomy ?>][]" id="<?php echo $child_cat->slug; ?>" class="input-check monaFilterJS" value="<?php echo $child_cat->slug ?>" hidden <?php if ($britney_spears_value === $child_cat->slug) {
                                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                                    } ?>>
                        <div class="box-check"></div><span class="txt"><?php echo $child_cat->name; ?></span>
                    </label>
                </div>

            <?php } ?>

        </div>

    <?php  } else { ?>

        <span class="brand-item">
            <label class="brand-link txt-brand">
                <?php echo "Không tìm thấy hương hiệu phù hợp." ?>
            </label>
        </span>

    <?php }
    $html = ob_get_clean();

    wp_send_json_success(array('html' => $html));
    wp_die();
}

add_action('wp_ajax_mona_ajax_search_category_header',  'mona_ajax_search_category_header'); // login
add_action('wp_ajax_nopriv_mona_ajax_search_category_header',  'mona_ajax_search_category_header'); // no login
function mona_ajax_search_category_header()
{
    $val = isset($_POST['val']) ? sanitize_text_field($_POST['val']) : '';

    $parent_cat_thuong_hieu = get_terms(array(
        'taxonomy' => 'category_thuong_hieu',
        'parent' => 0,
        'hide_empty' => false,
    ));

    if (empty($val)) {
        $child_cats_thuong_hieu = get_terms('category_thuong_hieu', array(
            'hide_empty' => false,
        ));
    } else {
        $args = array(
            'taxonomy'   => 'category_thuong_hieu',
            'hide_empty' => false,
            'parent'     => $parent_cat_thuong_hieu->term_id,
        );

        $child_cats_thuong_hieu = get_terms($args);
    }

    $filtered_cats = array_filter($child_cats_thuong_hieu, function ($cat) use ($val) {
        return empty($val) || strpos(strtolower($cat->name), strtolower($val[0])) === 0;
    });

    ob_start();
    if (!empty($filtered_cats)) { ?>
        <ul class="brand-list row">
            <?php foreach ($filtered_cats as $child_cat) {
                $category_link_parent_category = get_term_link($child_cat); ?>
                <li class="brand-it col-4">
                    <a class="brand-link" href="<?php echo esc_url($category_link_parent_category); ?>"><?php echo $child_cat->name; ?></a>
                </li>
            <?php } ?>
        </ul>
    <?php  } else { ?>
        <span class="brand-item">
            <label class="brand-link txt-brand">
                <?php echo "Thương hiệu đang được cập nhật" ?>
            </label>
        </span>
    <?php }
    $html = ob_get_clean();

    wp_send_json_success(array('html' => $html));
    wp_die();
}

//ajaxx search product
add_action('wp_ajax_mona_ajax_search_product',  'mona_ajax_search_product'); // login
add_action('wp_ajax_nopriv_mona_ajax_search_product',  'mona_ajax_search_product'); // no login
function mona_ajax_search_product()
{
    $argsPost = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 10,
    );

    // search
    if (isset($_POST['val']) && !empty($_POST['val'])) {
        $val = sanitize_text_field($_POST['val']);
        $argsPost['s'] = $val;
    }

    $postsMONA = new WP_Query($argsPost);
    $html = '';

    ob_start();

    if ($postsMONA->have_posts()) {
        while ($postsMONA->have_posts()) {
            $postsMONA->the_post();
            get_template_part('partials/product/item_search_header');
        }
        wp_reset_query();
    } else {
        echo '<div class="mona-empty-message-large">';
        echo '<p>' . __('Không có sản phẩm cho từ khóa của bạn. Vui lòng quay tại sau', 'monamedia') . '</p>';
        echo '</div>';
    }

    $html = ob_get_clean();
    wp_send_json_success(array('html' => $html));
    wp_die();
}

//ajaxx search product
add_action('wp_ajax_mona_ajax_search_product_mobile',  'mona_ajax_search_product_mobile'); // login
add_action('wp_ajax_nopriv_mona_ajax_search_product_mobile',  'mona_ajax_search_product_mobile'); // no login
function mona_ajax_search_product_mobile()
{
    $argsPost = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 10,
    );

    // search
    if (isset($_POST['val']) && !empty($_POST['val'])) {
        $val = sanitize_text_field($_POST['val']);
        $argsPost['s'] = $val;
    }

    $postsMONA = new WP_Query($argsPost);
    $html = '';

    ob_start();

    if ($postsMONA->have_posts()) {
        while ($postsMONA->have_posts()) {
            $postsMONA->the_post();
            get_template_part('partials/product/item_search_header');
        }
        wp_reset_query();
    } else {
        echo '<div class="mona-empty-message-large">';
        echo '<p>' . __('Không có sản phẩm cho từ khóa của bạn. Vui lòng quay tại sau', 'monamedia') . '</p>';
        echo '</div>';
    }

    $html = ob_get_clean();
    wp_send_json_success(array('html' => $html));
    wp_die();
}

//ajaxx search wishlist
add_action('wp_ajax_mona_ajax_wishlist_product',  'mona_ajax_wishlist_product'); // login
add_action('wp_ajax_nopriv_mona_ajax_wishlist_product',  'mona_ajax_wishlist_product'); // no login
function mona_ajax_wishlist_product()
{
    $form = array();
    // search
    if (isset($_POST['val']) && !empty($_POST['val'])) {
        $val = sanitize_text_field($_POST['val']);

        $argsPost['s'] = $val;
    }

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $wishlist_array = get_user_meta($user_id, '_wishlist', true) ? get_user_meta($user_id, '_wishlist', true) : [];
    } else {
        $wishlist_array = [];
    }

    ob_start(); ?>

    <?php
    if ($wishlist_array) {
        foreach ($wishlist_array as $key => $item) {
            if (get_post_type($item) == 'product') {
                global $post;
                $url = get_the_permalink($item);
                $thumb = get_the_post_thumbnail($item, 'thumbnail');
                $title = get_the_title($item);
                $product = wc_get_product($item);
                $price_html = $product->get_price_html($item);

                // Check if the product title contains the search term
                if (isset($argsPost['s']) && !empty($argsPost['s']) && stripos($title, $argsPost['s']) === false) {
                    continue; // Skip this product if it doesn't match the search term
                }

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

    <?php } else { ?>

        <div class="mona-empty-message-large">
            <p><?php echo __('Không có sản phẩm cho từ khóa của bạn. Vui lòng quay tại sau', 'monamedia') ?></p>
        </div>

<?php }
    $html = ob_get_clean();

    wp_send_json_success(array('html' => $html));
    wp_die();
}
