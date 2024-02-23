<?php 
add_action( 'save_post_product', 'update_live_search_products', 10, 3 );
function update_live_search_products( $post_id, $post, $update ) {

    $json_path   = get_template_directory() . '/public/json/';
    $json_file   = 'data-search-products.json';
    $old_file    = $json_path . $json_file;
    $option_name = 'live-search-express-data';

    // delete file
    wp_delete_file( $old_file );

    // update new data json
    file_put_contents( $old_file, get_live_search_products_json() );

}

function get_live_search_products_json() {

    $json_path    = get_template_directory() . '/public/json/';
    $option_name  = 'live-search-express-data';

    $data_product = wp_cache_get( 'postslist_query' );
    
    if ( false === $data_product ) {
    
        $products = get_posts(
            [
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'ID',
                'order'          => 'ASC',
                'fields'         => 'ids',
            ]
        );

        if ( ! empty ( $products ) ) {
            foreach( $products as $product ) {
                $data_product[] = [
                    'title'     => get_the_title( $product ),
                    'url'       => get_permalink( $product ),
                    'thumbnail' => get_the_post_thumbnail_url( $product, 'thumbnail' ),
                    'price'     => wc_get_product( $product )->get_price_html(),
                ];
            }
        } 

        wp_cache_set( 'postslist_query', $data_product, '', HOUR_IN_SECONDS );
    }

    $data_all = [ $data_product ];

    return json_encode( $data_all, JSON_UNESCAPED_UNICODE );
}

add_action( 'wp_footer', 'live_search_product_client' );
function live_search_product_client() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            $(document).on( 'keyup', '.monaFilterJS-input-product', function(e) {

                var val = $(this).val().toLowerCase();
                var items = [];
                var json_url = $('#search-product').attr('json-file');
                var results = '';
                var box_search = $('#search-product');

                box_search.html('');
                $('.live-search-btn').hide();

                $.getJSON( json_url, {
                    tagmode: 'any',
                    format: 'json'
                }).done(function( products ) {

                    $.each(products, function (i) {
                        $.each(products[i], function (index, product) {
                            var stringTitle = product.title.toLowerCase();
                            if(stringTitle.indexOf(val) !== -1) {
                                results +=`<div class="cart-it"><div class="cart-img"><a class="img-link" href="`+product.url+`"><img width="80" height="80" src="`+product.thumbnail+`" class="attachment-full size-full wp-post-image" alt="" decoding="async"></a></div><div class="cart-content"><a class="cart-name" href="`+product.url+`">`+product.title+`</a><div class="cart-price">`+product.price+`</div></div></div>`;
                            }
                        });
                    });

                    if ( results == '' ) {
                        results = `<div class="mona-empty-message-large"><p>Vui lòng nhập từ khóa tìm kiếm.</p></div>`;
                        $('.live-search-btn').hide();
                    } else {
                        $('.live-search-btn').show();
                    }

                    box_search.append(results);

                });

            });

            $(document).on( 'keyup', '.monaFilterJS-input-product-mobile', function(e) {

                var val = $(this).val().toLowerCase();
                var items = [];
                var json_url = $('#search-product-mobile').attr('json-file');
                var results = '';
                var box_search = $('#search-product-mobile');

                box_search.html('');
                $('.live-search-btn').hide();

                $.getJSON( json_url, {
                    tagmode: 'any',
                    format: 'json'
                }).done(function( products ) {

                    $.each(products, function (i) {
                        $.each(products[i], function (index, product) {
                            var stringTitle = product.title.toLowerCase();
                            if(stringTitle.indexOf(val) !== -1) {
                                results +=`<div class="cart-it"><div class="cart-img"><a class="img-link" href="`+product.url+`"><img width="80" height="80" src="`+product.thumbnail+`" class="attachment-full size-full wp-post-image" alt="" decoding="async"></a></div><div class="cart-content"><a class="cart-name" href="`+product.url+`">`+product.title+`</a><div class="cart-price">`+product.price+`</div></div></div>`;
                            }
                        });
                    });

                    if ( results == '' ) {
                        results = `<div class="mona-empty-message-large"><p>Vui lòng nhập từ khóa tìm kiếm.</p></div>`;
                        $('.live-search-btn').hide();
                    } else {
                        $('.live-search-btn').show();
                    }

                    box_search.append(results);

                });

            });

        });
    </script>
    <?php 
}