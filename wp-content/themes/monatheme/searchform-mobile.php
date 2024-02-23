<div class="ic-search"> <img src="<?php get_site_url(); ?>/template/assets/images/ic-search.svg" alt="" />
    <div class="search-mb searchFixed">
        <form method="get" id="searchform" class="search-fixed" action="<?php echo esc_url(home_url('/')); ?>" autocomplete="off">
            <button class="btn-search"> <img src="<?php get_site_url(); ?>/template/assets/images/ic-search.svg" alt="" />
            </button>
            <input type="search" data-placeholder="Tìm sản phẩm của bạn" class="search-field monaFilterJS-input-product-mobile" name="s" value="<?php echo get_search_query(); ?>" id="s" placeholder="<?php echo esc_attr_x('Tìm sản phẩm của bạn', 'placeholder', 'monamedia'); ?>" />
            <div class="box-result boxResult">
                <div class="inner">
                    <div id="search-product-mobile" class="is-loading-group" json-file="<?php echo get_template_directory_uri() ?>/public/json/data-search-products.json">
                        <div class="mona-empty-message-large">
                            <p><?php echo __('Vui lòng nhập từ khóa tìm kiếm.', 'monamedia') ?>
                            </p>
                        </div>
                    </div>
                    <a class="btn live-search-btn" href="<?php echo site_url('collections/') ?>"><?php _e('Xem tất cả', 'monamedia') ?></a>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- <div class="box-search-mb-form">
    <form method="get" id="searchform" class="search-fixed" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" data-placeholder="Tìm sản phẩm của bạn" class="search-field" name="s" value="<?php echo get_search_query(); ?>" id="s" placeholder="<?php echo esc_attr_x('Tìm sản phẩm của bạn', 'placeholder', 'monamedia'); ?>" />
        <button class="btn-search"><img src="./assets/images/ic-search.svg" alt="" />
        </button>
    </form>
</div> -->