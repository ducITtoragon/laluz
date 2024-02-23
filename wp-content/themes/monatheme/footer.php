<footer class="footer">
    <div class="container">
        <div class="ft-inner">
            <div class="ft-left">
                <div class="tt-mn-ft">
                    <?php $footer_title_1 = mona_get_option('footer_title_1');
                    if (isset($footer_title_1) || !empty($footer_title_1)) {
                        echo $footer_title_1;
                    } ?>

                </div>
                <?php $footer_shortcode_1 = mona_get_option('footer_shortcode_1');
                if (isset($footer_shortcode_1) || !empty($footer_shortcode_1)) {
                    echo do_shortcode($footer_shortcode_1);
                } ?>
                <p class="txt-mn-ft">
                    <?php $footer_des_1 = mona_get_option('footer_des_1');
                    if (isset($footer_des_1) || !empty($footer_des_1)) {
                        echo $footer_des_1;
                    } ?>
                </p>
                <?php
                $contact_social_items = mona_get_option('contact_social_items');
                if (is_array($contact_social_items)) {
                ?>
                    <div class="nav-social">
                        <ul class="social-list">
                            <?php foreach ($contact_social_items as $item) { ?>
                                <li class="social-item">
                                    <a class="social-link" href="<?php echo esc_url($item['link']); ?>">
                                        <?php
                                        if (!empty($item['icon']) || isset($item['icon'])) {
                                            echo '<img src="' . esc_url($item['icon']) . '">';
                                        }
                                        ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="ft-right">
                <div class="ft-list">
                    <div class="ft-it">
                        <div class="tt-mn-ft">
                            <?php $footer_title_2 = mona_get_option('footer_title_2');
                            if (isset($footer_title_2) || !empty($footer_title_2)) {
                                echo $footer_title_2;
                            } ?>
                        </div>
                        <!-- footer menu -->
                        <?php
                        wp_nav_menu(array(
                            'container' => false,
                            'container_class' => '',
                            'menu_class' => 'menu-list menu-ft-list',
                            'theme_location' => 'footer-menu',
                            'walker' => new Mona_Walker_Nav_Menu_Footer,
                        ));
                        ?>
                    </div>
                    <div class="ft-it">
                        <div class="tt-mn-ft">
                            <?php $footer_title_3 = mona_get_option('footer_title_3');
                            if (isset($footer_title_3) || !empty($footer_title_3)) {
                                echo $footer_title_3;
                            } ?>
                        </div>
                        <ul class="menu-list menu-ft-list">
                            <?php dynamic_sidebar('footer_column1'); ?>
                        </ul>
                    </div>
                    <div class="ft-it">
                        <div class="tt-mn-ft">
                            <?php $footer_title_4 = mona_get_option('footer_title_4');
                            if (isset($footer_title_4) || !empty($footer_title_4)) {
                                echo $footer_title_4;
                            } ?>
                        </div>
                        <?php $contact_dia_chi_items = mona_get_option('contact_dia_chi_items');
                        if (is_array($contact_dia_chi_items)) { ?>

                            <ul class="menu-list menu-ft-list">
                                <?php foreach ($contact_dia_chi_items as $item) { ?>
                                    <li class="menu-item">
                                        <?php
                                        if (!empty($item['icon']) || isset($item['icon'])) {
                                            echo '<img src="' . esc_url($item['icon']) . '">';
                                        }
                                        ?>
                                        <a class="menu-link txt-mn-ft" href="<?php echo esc_url($item['link']); ?>">
                                            <?php
                                            if (!empty($item['text'])) {
                                                echo $item['text'];
                                            }
                                            ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="overlay-filter"></div>
<div class="menu-mb">
    <div class="nav-menu">
        <div class="menu-mb-action">
            <?php
            get_template_part('searchform-mobile-footer')
            ?>
            <ul class="action-list">
                <!-- cart  -->
                <li class="action-item">
                    <div class="cart"><a class="cart-inner" href="">
                            <img src="<?php get_site_url(); ?>/template/assets/images/ic-cart.svg" alt="" />
                            <div class="quantity" id="mona-cart-qty">
                                <?php echo WC()->cart->get_cart_contents_count(); ?>
                            </div>
                        </a></div><a class="txt-mn" href="<?php echo site_url('cart/'); ?>"><?php _e('Giỏ hàng', 'monamedia'); ?></a>
                </li>
                <!-- đăng nhập đăng ký  -->
                <?php if (is_user_logged_in()) { ?>
                    <li class="action-item">
                        <img src="<?php get_site_url(); ?>/template/assets/images/ic-user.svg" alt="" />
                        <a class="account-link txt-mn" href="<?php echo site_url('account/') ?>"><?php _e('Tài khoản', 'monamedia'); ?></a>
                    </li>
                <?php } else { ?>
                    <li class="action-item">
                        <img src="<?php get_site_url(); ?>/template/assets/images/ic-user.svg" alt="" />
                        <div class="account-op">
                            <a class="account-link txt-mn" href="<?php echo site_url('login/') ?>"><?php _e('Đăng nhập', 'monamedia'); ?></a>
                            <a class="account-link txt-mn" href="<?php echo site_url('dang-ky/') ?>"><?php _e('Đăng kí', 'monamedia'); ?></a>
                        </div>
                    </li>
                <?php } ?>
                <!-- wishlist  -->
                <?php if (is_user_logged_in()) { ?>
                    <li class="action-item">
                        <img src="<?php get_site_url(); ?>/template/assets/images/ic-heart-2.svg">
                        <a class="txt-mn" href="<?php echo site_url('wishlist/') ?>">
                            <?php _e('Sản phẩm yêu thích', 'monamedia') ?>
                        </a>
                    </li>
                <?php } else { ?>
                    <div class="action-item">
                        <img src="<?php get_site_url(); ?>/template/assets/images/ic-heart-2.svg">
                        <a class="txt-mn" href="<?php echo site_url('login/') ?>">
                            <?php _e('Sản phẩm yêu thích', 'monamedia') ?>
                        </a>

                    </div>
                <?php } ?>
            </ul>
        </div>
        <!-- footer menu -->
        <?php
        wp_nav_menu(array(
            'container' => false,
            'container_class' => '',
            'menu_class' => 'menu-list flex-col-mn',
            'theme_location' => 'mobile-menu',
            'walker' => new Mona_Walker_Nav_Menu_Mobile,
        ));
        ?>
    </div>
</div>
<div class="overlay"></div>
<?php
$contact_back_to_top_items = mona_get_option('contact_back_to_top_items');
if (is_array($contact_back_to_top_items)) {
?>
<div class="fixed-nav">
    <ul class="fixed-nav-list">
        <?php foreach ($contact_back_to_top_items as $item) { ?>
            <li class="fixed-nav-item"> <a class="link-items" href="<?php echo esc_url($item['link']); ?>"><i class="<?php echo $item['text-icon']; ?>"></i></a></li>
        <?php } ?>
        <li class="fixed-nav-item">
            <div class="back-to-top"> <i class="fa-solid fa-arrow-up"></i></div>
        </li>
    </ul>
</div>
<?php } ?>
<div class="cart-fixed">
    <div class="inner">
        <p class="tt tt-sec"><?php _e('Giỏ hàng', 'monamedia') ?></p>
        <div class="cart-list">
            <div class="widget_shopping_cart_content" id="m_mini_cart">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>
        <div class="cart-bottom">
            <div class="cart-total">
                <p class="txt"><?php _e('Thành tiền: ', 'monamedia'); ?></p><span class="total" id="total-cart"><?php echo wc_price(WC()->cart->get_cart_contents_total()); ?></span>
            </div>

            <div class="box-btn">
                <a class="btn btn-pri" href="<?php echo site_url('cart/') ?>">
                    <span class="txt">
                        <?php _e('Xem giỏ hàng', 'monamedia'); ?>
                    </span>
                </a>
                <a class="btn btn-four" href="<?php echo site_url('thanh-toan/');?> <?php  ?>">
                    <span class="txt">
                        <?php _e('Thanh Toán', 'monamedia'); ?>
                    </span>
                </a>
            </div>
        </div><span class="ic-close"> <i class="fa-solid fa-xmark"></i></span>
    </div>
</div>
<script src="<?php get_site_url(); ?>/template/assets/library/jquery/jquery.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/swiper/swiper-bundle.min.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/aos/aos.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/select2/select2.min.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/gallery/lightgallery-all.min.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/jquery/jquery-migrate.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/fancybox/fancybox.umd.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/smoothscroll/SmoothScroll.min.js"> </script>
<script src="<?php get_site_url(); ?>/template/assets/library/datetime/moment.min.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/datetime/daterangepicker.min.js"></script>
<script src="<?php get_site_url(); ?>/template/assets/library/magnify/magnify.min.js"></script>
<script src="<?php get_site_url(); ?>/template/js/main.js" type="module"></script>
<!-- footer -->
<?php wp_footer(); ?>
</body>

</html>