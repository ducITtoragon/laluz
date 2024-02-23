<?php 
/** COMMENT */
function mona_custom_comment_form(){

    $commenter = wp_get_current_commenter();
    $comment_form = array(
        'title_reply'          => '',
        'title_reply_to'       => '',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'fields'               => array(
            'author' => '<div class="form-control comment-form-author">
                <p class="comment-form-title">'.esc_html__( 'Tên của bạn*', 'monamedia' ).'</p>
                <input id="author" name="author" type="text" class="contact-form-input" 
                placeholder="'.esc_html__( 'Nhập tên của bạn', 'monamedia' ).'" aria-required="true">
            </div>',
            'email'  => '<div class="form-control comment-form-email">
                <p class="comment-form-title">'.esc_html__( 'Email của bạn*', 'monmaedia' ).'</p>
                <input id="email" name="email" type="email" class="contact-form-input" 
                placeholder="'.esc_html__( 'Nhập email của bạn', 'monamedia' ).'" aria-required="true">
            </div>',
            'cookies' => '',
        ),
        'label_submit'  => __( 'Gửi đánh giá của bạn', 'monamedia' ),
        'logged_in_as'  => '',
        'comment_field' => '',
    );
    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
        $comment_form['comment_field'] = '<div class="comment-form-rating">
            <p class="comment-form-title">'.esc_html__( 'Đánh giá của bạn*', 'monamedia' ).'</p>
            <select class="empty-stars" name="rating" id="rating">
                <option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
                <option value="'.esc_attr( '5' ).'">' . __( 'Perfect', 'woocommerce' ) . '</option>
                <option value="'.esc_attr( '4' ).'">' . __( 'Good', 'woocommerce' ) . '</option>
                <option value="'.esc_attr( '3' ).'">' . __( 'Average', 'woocommerce' ) . '</option>
                <option value="'.esc_attr( '2' ).'">' . __( 'Not that bad', 'woocommerce' ) . '</option>
                <option value="'.esc_attr( '1' ).'">' . __( 'Very Poor', 'woocommerce' ) . '</option>
            </select>
        </div>';
    }

    $comment_form['comment_field'] .= '<div class="comment-form-detail reviews-comment flex flex-column flex-ai-center">
            <textarea id="comment" name="comment" cols="5" rows="5" placeholder="'.__( 'Mời bạn để lại đánh giá về sản phẩm', 'monamedia' ).'" aria-required="true"></textarea>
    </div>';

    
    $comment_form['comment_field'] .= '
    <div class="reviews-post-upload">
        <div id="img_preview" class="mona-hidden" aria-live="polite"></div>
        <p class="comment-form-title">'.esc_html__( 'Hình ảnh đi kèm ', 'monamedia' ).'</p>
        <div class="comment-form-upload">
            <div class="comment-upload-heading">
                <label for="upload_imgs" class="upload-btn flex flex-ai-center add-image-rating-mona">
                <span class="icon">
                    <img src="'. get_site_url() .'/template/assets/images/photo-camera-interface-symbol-for-button.png" alt="">
                </span>'.__('Tải lên hình ảnh/video', 'monamedia').'
                </label>
                <input class="show-for-sr" type="file" id="upload_imgs" name="upload_imgs[]" multiple/>
            </div>
        </div>
    </div>';

    comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

}
function get_comment_image_ids( $post_id = '' ) {
    if ( empty( $post_id ) ) {
        $post_id = get_the_ID();
    }
    $args = [
        'post_type' => 'product',
        // 'post__in' => [$post_id],
        'post_id'       => $post_id,
        'status'        => 'approve',
        'meta_query' => [
            'relation' => 'AND',
        ]
    ];
    $comments = get_comments( $args );
    if ( ! empty( $comments ) && count( $comments ) > 0 ) {
        foreach ( $comments as $k => $comment ) {
            $meta_attach_ids = get_comment_meta( $comment->comment_ID, 'comment_images', false );
            foreach ( $meta_attach_ids as $k => $item ) {
                $mona_attachment = $item['mona_attachment'];
                if ( ! empty ( $mona_attachment ) ) {
                    foreach ( $mona_attachment as $att => $value ) {
                        $attachmen_ids[] = $value;
                    }
                }
            }
        }
    }

    if ( ! empty ( $attachmen_ids ) && is_array( $attachmen_ids ) ) {
        return $attachmen_ids;
    } else {
        return $attachmen_ids = [];
    }
}
function get_comment_count_args( $post_id = '' ) {
    if ( empty( $post_id ) ) {
        $post_id = get_the_ID();
    }
    $args = [
        'post_type' => 'product',
        // 'post__in' => [$post_id],
        'post_id'       => $post_id,
        'status'        => 'approve',
        'meta_query' => [
            'relation' => 'AND',
        ]
    ];
    $comments = get_comments( $args );
    if ( ! empty( $comments ) && count( $comments ) > 0 ) {
        $count5 = $count4 = $count3 = $count2 = $count1 = $countimages = 0;
        if ( ! empty( $comments ) && count( $comments ) > 0 ) {
            foreach ( $comments as $k => $comment ) {
                $meta_rating_count  = get_comment_meta( $comment->comment_ID, 'rating', true );
                $meta_attach_ids    = get_comment_meta( $comment->comment_ID, 'comment_images', false );
                if( !empty( $meta_attach_ids ) ){
                    $countimages++;
                }
                if ( $meta_rating_count == 5 ) {
                    $count5++;
                }
                if ( $meta_rating_count == 4 ) {
                    $count4++;
                }
                if ( $meta_rating_count == 3 ) {
                    $count3++;
                }
                if ( $meta_rating_count == 2 ) {
                    $count2++;
                }
                if ( $meta_rating_count == 1 ) {
                    $count1++;
                }
            }
        }
    }

    return $output = [
        'images' => $countimages,
        '5'      => $count5,
        '4'      => $count4,
        '3'      => $count3,
        '2'      => $count2,
        '1'      => $count1,
    ];
}
function mona_wp_comment_lists( $args = [] , $per_page = 3 , $paged = 1 ) {
    ob_start();
    $comments = get_comments( $args );
    if ( ! empty( $comments ) && count( $comments ) > 0 ) {
        $args_list = array(
            'style'             => 'li',
            'short_ping'        => true,
            'avatar_size'       => 40,
            'callback'          => 'mona_comments',
            'type'              => 'all',
            'reply_text'        => __('Comment', 'monamedia'),
            'page'              => $paged,
            'per_page'          => $per_page,
            'reverse_top_level' => null,
            'reverse_children'  => '',
            'max_depth'         => 2
        );
        wp_list_comments($args_list, $comments);
    } else {
        $comment_text = '<div class="mona-mess-empty commtent-empty">';
        $comment_text .= __( 'Hiện chưa có bài đánh giá nào', 'monamedia' );
        $comment_text .= '</div>';
        echo $comment_text;
    }
    return ob_get_clean();
}
function mona_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    $rating_point = get_comment_meta( $comment->comment_ID, 'rating', true );
    $class5 = $class4 = $class3 = $class2 = $class1 = 0;
    if( $rating_point == 5 ){
        $class5 = 'active';
        $class4 = 'active';
        $class3 = 'active';
        $class2 = 'active';
        $class1 = 'active';
    }else if ( $rating_point >= 4 ){
        $class4 = 'active';
        $class3 = 'active';
        $class2 = 'active';
        $class1 = 'active';
    }else if ( $rating_point >= 3 ){
        $class3 = 'active';
        $class2 = 'active';
        $class1 = 'active';
    }else if ( $rating_point >= 2 ){
        $class2 = 'active';
        $class1 = 'active';
    }else if ( $rating_point >= 1 ){
        $class1 = 'active';
    }
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('cf box-cmt'); ?>>
        <div class="hd-cmt">
            <div class="user"><?php echo $comment->comment_author; ?></div>
            <ul class="stars">
                <li class="star">
                    <i class="fa-solid fa-star <?php echo $class1 ? $class1 : ''; ?>"></i>
                </li>
                <li class="star">
                    <i class="fa-solid fa-star <?php echo $class2 ? $class2 : ''; ?>"></i>
                </li>
                <li class="star">
                    <i class="fa-solid fa-star <?php echo $class3 ? $class3 : ''; ?>"></i>
                </li>
                <li class="star">
                    <i class="fa-solid fa-star <?php echo $class4 ? $class4 : ''; ?>"></i>
                </li>
                <li class="star">
                    <i class="fa-solid fa-star <?php echo $class5 ? $class5 : ''; ?>"></i>
                </li>
            </ul>
        </div>
        <span class="bought">
            <img src="<?php echo get_site_url() ?>/template/assets/images/checked.svg" alt="" />
            <?php echo __('Đã mua hàng tại Laluz', 'monamedia'); ?>
        </span>
        <div class="box-desc">
            <p class="desc">
                <?php comment_text() ?>
            </p>
        </div>
        <?php 
        $flagHidden = true;
        if( !$flagHidden ){ ?>
        <div class="info-action"> 
            <button type="button" class="btn btn-send" 
            data-comment_reply_id="<?php echo $comment->comment_ID; ?>">
                <?php echo __('Gửi trả lời', 'monamedia'); ?>
            </button>
            <button type="button" class="btn btn-like dot">
                <img src="<?php echo get_site_url() ?>/template/assets/images/like.svg" alt="">
                Hữu ích
            </button>
            <button type="button" class="btn btn-report dot"> 
                <img src="<?php echo get_site_url() ?>/template/assets/images/like.svg" alt="">
                Báo cáo sai phạm
            </button>
            <span class="date dot">
                <time datetime="<?php echo comment_time('Y-m-j'); ?>">
                    <?php comment_time( __( 'g:h a d/m/Y', 'monamedia' ) ); ?>
                </time>
            </span>
        </div>
        <?php } ?>
   
   <?php 
   // </li> is added by WordPress automatically
}
function mona_comments_pagination( $total , $paged ) {
    ob_start();
    echo paginate_links(
        [
            'base'      => '#',
            'format'    => '#',
            'current'   => $paged,
            'total'     => $total,
            'prev_text' => '<i class="fa-solid fa-arrow-left-long"></i>',
            'next_text' => '<i class="fa-solid fa-arrow-right-long"></i>',
            'type'      => 'list',
            'end_size'  => 3,
            'mid_size'  => 3
        ]
    );
    return ob_get_clean();
}

add_action( 'wp_ajax_mona_ajax_user_comments',  'mona_ajax_user_comments' ); // login
add_action( 'wp_ajax_nopriv_mona_ajax_user_comments',  'mona_ajax_user_comments' ); // login
function mona_ajax_user_comments() {
    $form = $_POST;
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    $files = $_FILES['upload_imgs'];
    $upload_overrides = array('test_form' => false);
    $update_attach_ids = [];
    foreach ( $files['name'] as $key => $value ) {
        if ( $files['name'][$key] ) {
            
            $file = [
                'name' => $files['name'][$key],
                'type' => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error' => $files['error'][$key],
                'size' => $files['size'][$key]
            ];
            
            $comment_images = wp_handle_upload( $file, $upload_overrides );
            if ( $comment_images && ! isset( $comment_images['error'] ) ) {

                $wp_upload_dir = wp_upload_dir();
                $attachment = array(
                    'guid' => $wp_upload_dir['url'] . '/' . basename($comment_images['file']),
                    'post_mime_type' => $comment_images['type'],
                    'post_title' => preg_replace( '/\.[^.]+$/', '', basename($comment_images['file']) ),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $image_attach_id = wp_insert_attachment( $attachment, $comment_images['file'] );
                $update_attach_ids[$key] = $image_attach_id;

            } else {

                wp_send_json_error(  
                    [
                        'title'     => __( 'Thông báo!', 'monamedia' ),
                        'message'   => __( 'Hình ảnh tải lên không phù hợp!', 'monamedia' ),
                        'action'    => [
                            'title' => __( 'Thử lại', 'monamedia' ),
                            'title_close' => __( 'Đóng', 'monamedia' ),
                        ],
                    ]
                );
                wp_die();

            }
        }
    }

    $current_id = get_current_user_id();
    $account = get_userdata( $current_id );
    if( 
        empty($form['comment'])     ||  
        empty($form['rating'])   
    )
    {
        wp_send_json_error(  
            [
                'title'     => __( 'Thông báo!', 'monamedia' ),
                'message'   => __( 'Vui lòng điền đầy đủ thông tin!', 'monamedia' ),
            ]
        );
        wp_die();
    }

    $time = current_time('mysql');
    $data = [
        'comment_post_ID' => $form['comment_post_ID'],
        'comment_author' => $form['author'] ? $form['author'] : $account->display_name,
        'comment_author_email' => $form['email'] ? $form['email'] : $account->user_email,
        'comment_content' => esc_attr( $form['comment'] ),
        'comment_parent' => $form['comment_parent'] ? $form['comment_parent'] : 0,
        'comment_type' => '',
        'comment_date' => $time,
        'comment_approved' => 0,
    ];

    $comment_id = wp_insert_comment( $data );
    update_comment_meta( $comment_id, 'rating', $form['rating'] );
    if( !empty( $update_attach_ids ) ){
        update_comment_meta( $comment_id, 'comment_images', ['mona_attachment' => $update_attach_ids], false );
    }

    $args = [
        'post_type' => 'product',
        'post__in' => [$form['comment_post_ID']]
    ];
    wp_send_json_success( 
        [
            'title'     => __( 'Thông báo!', 'monamedia' ),
            'message'   => __( 'Đánh giá được gửi thành công!', 'monamedia' ),
        ]
    );
    wp_die();

}

add_action( 'wp_ajax_mona_ajax_pagination_comments',  'mona_ajax_pagination_comments' ); // login
add_action( 'wp_ajax_nopriv_mona_ajax_pagination_comments',  'mona_ajax_pagination_comments' ); // no login
function mona_ajax_pagination_comments(){
    $form   = $_POST;
    $filter = $form['filter'];
    $paged  = $form['paged'];
    $product_id = $form['product_id'];

    $param_limit = [
        'post_type'  => 'product',
        'post__in'   => [ $product_id ],
        'meta_query' => [
            'relation' => 'AND'
        ]
    ]; 
    switch ($filter) {
        case '5':
            $param_limit['meta_query'][] = [
                [
                    'key'     => 'rating',
                    'value'   => 5,
                    'compare' => '='
                ]
            ];   
            break;
        case '4':
            $param_limit['meta_query'][] = [
                [
                    'key'     => 'rating',
                    'value'   => 4,
                    'compare' => '='
                ]
            ];   
            break;
        case '3':
            $param_limit['meta_query'][] = [
                [
                    'key'     => 'rating',
                    'value'   => 3,
                    'compare' => '='
                ]
            ];   
            break;
        case '2':
            $param_limit['meta_query'][] = [
                [
                    'key'     => 'rating',
                    'value'   => 2,
                    'compare' => '='
                ]
            ];   
            break;
        case '1':
            $param_limit['meta_query'][] = [
                [
                    'key'     => 'rating',
                    'value'   => 1,
                    'compare' => '='
                ]
            ];   
            break;

        case 'images':
            $param_limit['meta_query'][] = [
                [
                    'key'     => 'comment_images',
                    'value'   => '',
                    'compare' => '!='
                ]
            ];
            break;

        case 'comment':
            $param_limit['meta_query'][] = [
                [
                    'key'     => 'comment_images',
                    'compare' => 'NOT EXISTS'
                ]
            ];
            break;
            
        default:
            break;
    }
    
    $per_page  = 2;
    $comments  = get_comments( $param_limit );
    $total     = !empty( $comments ) ? count( $comments ) : 0;
    $totalPage = ceil( $total / $per_page );
    wp_send_json_success( 
        [
            'title'                 => __( 'Thông báo!', 'monamedia' ),
            'message'               => __( 'Tải thành công!', 'monamedia' ),
            'comment_list'          => mona_wp_comment_lists( $param_limit , $per_page , $paged ),
            'comment_pagination'    => mona_comments_pagination( $totalPage , $paged )
        ]
    );
    wp_die();
}