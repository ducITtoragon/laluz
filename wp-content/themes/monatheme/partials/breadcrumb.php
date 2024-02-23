<?php
global $post;

$array = [
    [
        'url'   => get_the_permalink(MONA_PAGE_HOME),
        'title' => __('Home', 'monamedia')
    ],
];

if (wp_get_post_parent_id(get_the_ID())) {
    $parentId = wp_get_post_parent_id(get_the_ID());
    $array[] = [
        'url' => get_permalink($parentId),
        'title' => get_the_title($parentId),
    ];
}

if (is_home()) {


    $array[] = [
        'url' => '',
        'title' => get_the_title(MONA_PAGE_BLOG),
    ];
} elseif (is_singular('post')) {


    global $post;
    $primary_taxonomy_term = get_primary_taxonomy_term($post->ID, 'category');
    if (!empty($primary_taxonomy_term)) {
        $root = [];
        $root[$primary_taxonomy_term['slug']] = $primary_taxonomy_term['id'];
        $root = get_path_taxonomy_term_root($primary_taxonomy_term['parent'], $root, 'category');
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {

                $array[] = [
                    'url' => get_term_link($term_id, 'category'),
                    'title' => get_term_by('id', $term_id, 'category')->name,
                ];
            }
        } else {
            $array[] = [
                'url' => $primary_taxonomy_term['url'],
                'title' => $primary_taxonomy_term['title'],
            ];
        }
    }

    $array[] = [
        'url' => '',
        'title' => get_the_title(),
    ];
} elseif (is_singular('product')) {

    // $array[] = [
    //     'url' => get_permalink(MONA_WC_PRODUCTS),
    //     'title' => get_the_title(MONA_WC_PRODUCTS),
    // ];

    global $post;
    $primary_taxonomy_term = get_primary_taxonomy_term($post->ID, 'category_thuong_hieu');
    if (!empty($primary_taxonomy_term)) {
        $root = [];
        $root[$primary_taxonomy_term['slug']] = $primary_taxonomy_term['id'];
        $root = get_path_taxonomy_term_root($primary_taxonomy_term['parent'], $root, 'category_thuong_hieu');
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {

                $array[] = [
                    'url' => get_term_link($term_id, 'category_thuong_hieu'),
                    'title' => get_term_by('id', $term_id, 'category_thuong_hieu')->name,
                ];
            }
        } else {
            $array[] = [
                'url' => $primary_taxonomy_term['url'],
                'title' => $primary_taxonomy_term['title'],
            ];
        }
    }

    $array[] = [
        'url' => '',
        'title' => get_the_title(),
    ];
} elseif (is_category() || is_tag()) {


    $array[] = [
        'url' => '',
        'title' => get_queried_object()->name,
    ];
} elseif (is_tax('product_cat')) {

    $array[] = [
        'url' => get_permalink(MONA_WC_PRODUCTS),
        'title' => get_the_title(MONA_WC_PRODUCTS),
    ];

    $current = get_queried_object();
    $root = [];
    if ($current->parent != 0) {

        $root[$current->slug] = $current->term_id;
        $root = get_path_taxonomy_term_root($current->parent, $root, $current->taxonomy);
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {
                $array[] = [
                    'url' => get_term_link($term_id, $current->taxonomy),
                    'title' => get_term_by('id', $term_id, $current->taxonomy)->name,
                ];
            }
        }
    } else {

        $array[] = [
            'url' => '',
            'title' => $current->name,
        ];
    }
} elseif (is_tax('category_thuong_hieu') || is_tax('category_nuoc_hoa') || is_tax('category_nhom_huong') || is_tax('category_nong_do') || is_tax('category_dung_tich')) {

    // $array[] = [
    //     'url' => get_permalink(MONA_WC_PRODUCTS),
    //     'title' => get_the_title(MONA_WC_PRODUCTS),
    // ];

    $current = get_queried_object();
    $root = [];
    if ($current->parent != 0) {

        $root[$current->slug] = $current->term_id;
        $root = get_path_taxonomy_term_root($current->parent, $root, $current->taxonomy);
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {
                $array[] = [
                    'url' => get_term_link($term_id, $current->taxonomy),
                    'title' => get_term_by('id', $term_id, $current->taxonomy)->name,
                ];
            }
        }
    } else {

        $array[] = [
            'url' => '',
            'title' => $current->name,
        ];
    }
} elseif (is_tax('recruitment_location')) {

    // $array[] = [
    //     'url'   => get_permalink(MONA_PAGE_ABOUT),
    //     'title' => get_the_title(MONA_PAGE_ABOUT),
    // ];

    $current = get_queried_object();
    $root = [];
    if ($current->parent != 0) {

        $root[$current->slug] = $current->term_id;
        $root = get_path_taxonomy_term_root($current->parent, $root, $current->taxonomy);
        if (!empty($root)) {
            foreach ($root as $slug => $term_id) {
                $array[] = [
                    'url' => get_term_link($term_id, $current->taxonomy),
                    'title' => get_term_by('id', $term_id, $current->taxonomy)->name,
                ];
            }
        }
    } else {

        $array[] = [
            'url' => '',
            'title' => $current->name,
        ];
    }
} elseif (is_search()) {

    $array[] = [
        'url' => '',
        'title' => __('Kết quả tìm kiếm của từ khóa: ', 'monamedia') . '"<span class="keyword">' . get_search_query('s') . '</span>"',
    ];
} elseif (is_account_page()) {

    $array[] = [
        'url' => get_the_permalink(MONA_WC_MYACCOUNT),
        'title' => __('Tài khoản', 'monamedia'),
    ];
} elseif (is_shop()) {

    $array[] = [
        'url' => '',
        'title' => get_the_title(MONA_WC_PRODUCTS),
    ];
} else {

    $array[] = [
        'url' => '',
        'title' => get_the_title(),
    ];
}

// if ( is_page( MONA_WC_MYACCOUNT ) ) {
//     $result = WC()->query->get_current_endpoint();
//     if ( !empty( $result ) ) {

//         switch ($result) {

//             case 'dashboard':
//                 $array[] = [
//                     'url' => '',
//                     'title' => __('Personal Details', 'monamedia'),
//                 ];
//                 break;

//             case 'edit-account':
//                 $array[] = [
//                     'url' => '',
//                     'title' => __('Edit Password', 'monamedia'),
//                 ];
//                 break;

//             case 'orders':
//                 $array[] = [
//                     'url' => '',
//                     'title' => __('History', 'monamedia'),
//                 ];
//                 break;

//             case 'view-order':

//                 $array[] = [
//                     'url' => wc_get_account_endpoint_url( 'orders' ),
//                     'title' => __('Orders', 'monamedia'),
//                 ];

//                 $array[] = [
//                     'url' => '',
//                     'title' => get_the_title()
//                 ];
//                 break;

//             case 'promotion':

//                 $array[] = [
//                     'url' => '',
//                     'title' => __('Promotion', 'monamedia')
//                 ];
//                 break;

//             default:
//                 break;
//         }

//     }
// }

$title_primary = $array[count($array) - 1]['title'];
?>
<ul class="breadcrumbs-list">
    <?php
    if (is_array($array)) {
        $countArray = count($array);
        foreach ($array as $key => $item) {
            $title = $item['title'];
            $url = $item['url'];
    ?>
            <li class="breadcrumbs-item <?php echo (empty($url) && $key == ($countArray - 1)) ? 'current-item' : ''; ?>">
                <a href="<?php echo $url ? $url : 'javascript:;'; ?>" class="breadcrumbs-link">
                    <?php echo $title; ?>
                </a>
            </li>
    <?php }
    } ?>
</ul>