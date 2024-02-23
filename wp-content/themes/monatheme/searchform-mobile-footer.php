<div class="box-search-mb-form">
    <form method="get" id="searchform" class="search-fixed box-search-mb" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" data-placeholder="Tìm sản phẩm của bạn" class="search-field" name="s" value="<?php echo get_search_query(); ?>" id="s" placeholder="<?php echo esc_attr_x('Tìm sản phẩm của bạn', 'placeholder', 'monamedia'); ?>" />
        <button class="btn-search"><img src="<?php get_site_url(); ?>/template/assets/images/ic-search.svg" alt="" />
        </button>
    </form>
</div>