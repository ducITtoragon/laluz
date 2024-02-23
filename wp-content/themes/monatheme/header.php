<?php

/**
 * The template for displaying header.
 *
 * @package MONA.Media / Website
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
    <!-- Meta ================================================== -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <?php wp_site_icon(); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="stylesheet" href="<?php echo MONA_HOME_URL; ?>/template/css/style.css">
    <link rel="stylesheet" href="<?php echo MONA_HOME_URL; ?>/template/css/backdoor.css">
    <?php wp_head(); ?>
</head>
<?php
if (wp_is_mobile()) {
    $body = 'mobile-detect';
} else {
    $body = 'desktop-detect';
}
$user_id = get_current_user_id();
?>
<body <?php body_class($body); ?>>
    <header class="header hd-repon">
        <div class="header-inner">
            <div class="hd-up">
                <div class="container">
                    <div class="hd-up-inner">
                        <div class="txt-sales"> 
                            <?php $header_title_1 = mona_get_option('header_title_1');
                            if (isset($header_title_1) || !empty($header_title_1)) {
                                echo $header_title_1;
                            } ?>
                        </div>
                        <!-- sign-in  -->
                        <?php if (!is_user_logged_in()) { ?>
                            <div class="hd-login">
                                <a class="hd-login-inner" href="<?php echo site_url('login/') ?>">
                                    <div class="ic-login">
                                        <img src="<?php get_site_url(); ?>/template/assets/images/ic-user.svg" alt="" />
                                    </div>
                                    <span class="txt"><?php _e('Đăng nhập', 'monamedia'); ?></span>
                                </a>
                            </div>
                        <?php } else {
                            $user_data = get_userdata($user_id);
                            $thumb     = get_user_meta($user_id, '_thumb', true);
                            if ($thumb) {
                                $avatar = wp_get_attachment_image($thumb, 'thumbnail', false, ['class' => 'fileImg img-src', 'id' => 'm_id_thumb']);
                            } else {
                                $avatar = '<img src="' . MONA_URL . '" class="fileImg img-src " id="m_id_thumb">';
                            } ?>
                            <div class="hd-login">
                                <a class="hd-login-inner" href="<?php echo site_url('account/') ?>">
                                    <div class="ic-login">
                                        <?php echo $avatar; ?>
                                    </div>
                                    <span class="txt"> <?php echo $user_data->display_name; ?></span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="hd-mid">
                <div class="container">
                    <div class="hd-mid-inner">
                        <div class="btn-ham-wr">
                            <div class="btn-ham">
                                <span class="line-ham"></span>
                                <span class="line-ham"></span>
                                <span class="line-ham"></span>
                            </div>
                        </div>
                        <div class="logo">
                            <?php if (is_page(MONA_PAGE_HOME)) { ?>
                                    <div class="logo-link">
                                        <?php echo get_custom_logo() ?>
                                    </div>
                            <?php } else {
                            ?>
                                <div class="logo-link">
                                    <?php echo get_custom_logo() ?>
                                </div>
                            <?php
                            } ?>
                        </div>
                        <div class="hd-mid-right">
                            <!-- search desktop  -->
                            <?php
                            get_template_part('searchform')
                            ?>
                            <div class="hd-mid-right-it">
                                <!-- wishlist  -->
                                <?php if (is_user_logged_in()) { ?>
                                    <div class="ic-heart">
                                        <a class="ic-heart-inner" href="<?php echo site_url('wishlist/') ?>">
                                            <img src="<?php get_site_url(); ?>/template/assets/images/ic-heart-2.svg" alt="" />
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="ic-heart">
                                        <a class="ic-heart-inner" href="<?php echo site_url('login/') ?>">
                                            <img src="<?php get_site_url(); ?>/template/assets/images/ic-heart-2.svg" alt="" />
                                        </a>
                                    </div>
                                <?php } ?>
                                <?php
                                if (is_cart() || is_checkout()) {
                                ?>
                                    <div class="hd-cart">
                                        <a class="hd-cart-inner" href="">
                                            <img src="<?php get_site_url(); ?>/template/assets/images/ic-cart.svg" alt="" />
                                            <div class="quantity" id="mona-cart-qty">
                                                <?php echo WC()->cart->get_cart_contents_count(); ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                } else {
                                ?>
                                <div class="hd-cart">
                                    <a class="hd-cart-inner" href="">
                                        <img src="<?php get_site_url(); ?>/template/assets/images/ic-cart.svg" alt="" />
                                        <div class="quantity" id="mona-cart-qty">
                                            <?php echo WC()->cart->get_cart_contents_count(); ?>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                }
                                ?>
                                <!-- search mobile  -->
                                <?php get_template_part('searchform-mobile'); ?>
                                <!-- sign-in  -->
                                <?php if (!is_user_logged_in()) { ?>
                                    <div class="hd-login">
                                        <a class="hd-login-inner" href="<?php echo site_url('login/') ?>">
                                            <div class="ic-login">
                                                <img src="<?php get_site_url(); ?>/template/assets/images/ic-user.svg" alt="" />
                                            </div>
                                        </a>
                                    </div>

                                <?php } else {
                                    $user_data = get_userdata($user_id);
                                    $thumb     = get_user_meta($user_id, '_thumb', true);
                                    if ($thumb) {
                                        $avatar = wp_get_attachment_image($thumb, 'thumbnail', false, ['class' => 'fileImg img-src', 'id' => 'm_id_thumb']);
                                    } else {
                                        $avatar = '<img src="' . MONA_URL . '" class="fileImg img-src " id="m_id_thumb">';
                                    } ?>
                                    <div class="hd-login">
                                        <a class="hd-login-inner" href="<?php echo site_url('account/') ?>">
                                            <div class="ic-login">
                                                <?php echo $avatar; ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hd-down">
                <div class="container">
                    <div class="hd-down-inner">
                        <div class="nav-menu">
                            <!-- mobile menu -->
                            <?php
                            wp_nav_menu(array(
                                'container' => false,
                                'container_class' => '',
                                'menu_class' => 'menu-list',
                                'theme_location' => 'primary-menu',
                                'walker' => new Mona_Walker_Nav_Menu,
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>