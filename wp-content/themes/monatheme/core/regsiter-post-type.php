<?php
function mona_regsiter_custom_post_types()
{

    //policy
    $posttype_policy = [
        'labels' => [
            'name'          => __('Chính sách', 'mona-admin'),
            'singular_name' => __('Chính sách', 'mona-admin'),
            'all_items'     => __('Tất cả bài viết', 'mona-admin'),
            'add_new'       => __('Thêm mới', 'mona-admin'),
            'add_new_item'  => __('Thêm mới', 'mona-admin'),
            'edit_item'     => __('Chỉnh sửa', 'mona-admin'),
            'new_item'      => __('Thêm mới ', 'mona-admin'),
            'view_item'     => __('Xem bài viết', 'mona-admin'),
            'view_items'    => __('Xem bài viết ', 'mona-admin'),
        ],
        'description' => __('Thêm mới', 'mona-admin'),
        'supports'    => [
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt',
        ],
        'taxonomies'   => array('danh_muc_chinh_sach'),
        'hierarchical' => false,
        'show_in_rest' => true,
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [
            'slug' => 'chinh-sach',
            'with_front' => true
        ],
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-book-alt',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post'
    ];
    register_post_type('mona_policy', $posttype_policy);
    $taxonomy_policy = array(
        'labels' => array(
            'name'              => __('Danh mục - Chính sách', 'monamedia'),
            'singular_name'     => __('Danh mục - Chính sách', 'monamedia'),
            'search_items'      => __('Tìm kiếm', 'mona-admin'),
            'all_items'         => __('Tất cả', 'mona-admin'),
            'parent_item'       => __('Danh mục Chính sách', 'mona-admin'),
            'parent_item_colon' => __('Danh mục Chính sách', 'mona-admin'),
            'edit_item'         => __('Chỉnh sửa', 'mona-admin'),
            'add_new'           => __('Thêm mới', 'mona-admin'),
            'update_item'       => __('Cập nhật', 'mona-admin'),
            'add_new_item'      => __('Thêm mới', 'mona-admin'),
            'new_item_name'     => __('Thêm mới', 'mona-admin'),
            'menu_name'         => __('Danh mục Chính sách', 'mona-admin'),
        ),
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'has_archive'       => true,
        'public'            => true,
        'rewrite'           => array(
            'slug'       => 'chinh-sach',
            'with_front' => true
        ),
        'capabilities' => array(
            'manage_terms' => 'publish_posts',
            'edit_terms'   => 'publish_posts',
            'delete_terms' => 'publish_posts',
            'assign_terms' => 'publish_posts',
        ),
    );
    register_taxonomy('danh_muc_chinh_sach', 'mona_policy', $taxonomy_policy);

    // Theo Thương Hiệu
    $labels_thuong_hieu = array(

        'name'              => __('Thương hiệu', 'monamedia'),
        'singular_name'     => __('Sản Phẩm Theo Thương hiệu', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Sản Phẩm Theo Thương hiệu', 'mona-admin'),
        'parent_item_colon' => __('Sản Phẩm Theo Thương hiệu', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục thương hiệu', 'mona-admin'),
    );

    $taxonomy_san_pham_thuong_hieu = array(
        'hierarchical'      => true,
        'labels'            => $labels_thuong_hieu,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category-thuong-hieu'),
    );

    register_taxonomy('category_thuong_hieu', 'product', $taxonomy_san_pham_thuong_hieu);

    // Theo Nước hoa
    $labels_nuoc_hoa = array(

        'name'              => __('Nước hoa', 'monamedia'),
        'singular_name'     => __('Nước hoa', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Nước hoa', 'mona-admin'),
        'parent_item_colon' => __('Nước hoa', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục nước hoa', 'mona-admin'),
    );

    $taxonomy_san_pham_nuoc_hoa = array(
        'hierarchical'      => true,
        'labels'            => $labels_nuoc_hoa,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category-nuoc-hoa'),
    );

    register_taxonomy('category_nuoc_hoa', 'product', $taxonomy_san_pham_nuoc_hoa);

    // Theo nồng độ
    $labels_nong_do = array(

        'name'              => __('Nồng độ', 'monamedia'),
        'singular_name'     => __('Nồng độ', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Nồng độ', 'mona-admin'),
        'parent_item_colon' => __('Nồng độ', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục nồng độ', 'mona-admin'),
    );

    $taxonomy_san_pham_nong_do = array(
        'hierarchical'      => true,
        'labels'            => $labels_nong_do,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category-nong-do'),
    );

    register_taxonomy('category_nong_do', 'product', $taxonomy_san_pham_nong_do);

    // Theo nhóm hương
    $labels_nhom_huong = array(
        'name'              => __('Nhóm hương', 'monamedia'),
        'singular_name'     => __('Nhóm hương', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Nhóm hương', 'mona-admin'),
        'parent_item_colon' => __('Nhóm hương', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục nhóm hương', 'mona-admin'),
    );

    $taxonomy_san_pham_nhom_huong = array(
        'hierarchical'      => true,
        'labels'            => $labels_nhom_huong,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category-nhom-huong'),
    );

    register_taxonomy('category_nhom_huong', 'product', $taxonomy_san_pham_nhom_huong);

    // Theo dung tích
    $labels_dung_tich = array(
        'name'              => __('Dung tích', 'monamedia'),
        'singular_name'     => __('Dung tích', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Dung tích', 'mona-admin'),
        'parent_item_colon' => __('Dung tích', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục dung tích', 'mona-admin'),
    );

    $taxonomy_san_pham_dung_tich = array(
        'hierarchical'      => true,
        'labels'            => $labels_dung_tich,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category-dung-tich'),
    );
    register_taxonomy('category_dung_tich', 'product', $taxonomy_san_pham_dung_tich);

    // Theo Giới tính
    $labels_gioi_tinh = array(
        'name'              => __('Giới tính', 'monamedia'),
        'singular_name'     => __('Giới tính', 'monamedia'),
        'search_items'      => __('Tìm Kiếm', 'mona-admin'),
        'all_items'         => __('Tất Cả', 'mona-admin'),
        'parent_item'       => __('Giới tính', 'mona-admin'),
        'parent_item_colon' => __('Giới tính', 'mona-admin'),
        'edit_item'         => __('Chỉnh Sửa', 'mona-admin'),
        'add_new'           => __('Thêm Mới', 'mona-admin'),
        'update_item'       => __('Cập Nhật', 'mona-admin'),
        'add_new_item'      => __('Thêm Mới', 'mona-admin'),
        'new_item_name'     => __('Thêm Mới', 'mona-admin'),
        'menu_name'         => __('Danh mục giới tính', 'mona-admin'),
    );

    $taxonomy_san_pham_gioi_tinh = array(
        'hierarchical'      => true,
        'labels'            => $labels_gioi_tinh,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category-gioi-tinh'),
    );

    register_taxonomy('category_gioi_tinh', 'product', $taxonomy_san_pham_gioi_tinh);

    flush_rewrite_rules();
}
add_action('init', 'mona_regsiter_custom_post_types');
