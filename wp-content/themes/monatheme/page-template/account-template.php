<?php

/**
 * Template name: Account Page
 * @author : Hy Hý
 */

if (is_user_logged_in()) {

    get_header();
    while (have_posts()) :
        the_post();
        $itemMenu = wc_get_account_menu_items();
        $account = new Account();
        $class = '';
        $clas_main = '';

        foreach ($itemMenu as $key => $value) {
            if ($key == 'orders' && array_key_exists($key, (array) $wp->query_vars)) {
                $clas_main = 'pfcus-his-fix';
            }
            if ($key == 'view-order' && array_key_exists($key, (array) $wp->query_vars)) {
                $clas_main = 'pfcus-his-fix-view-oder';
            }
        }

        $user_id = get_current_user_id();
        $user_data = get_userdata(get_current_user_id());
        $thumb = get_user_meta($user_id, '_thumb', true);
        if ($thumb) {
            $avatar = wp_get_attachment_image($thumb, 'thumbnail', false, ['class' => 'fileImg img-src', 'id' => 'm_id_thumb']);
        } else {
            $avatar = '<img src="' . MONA_URL . '" class="fileImg img-src " id="m_id_thumb">';
        }
?>

        <main class="main spc-hd spc-hd-2">
            <section class="nav-bread">
                <div class="container">
                    <?php get_template_part('/partials/breadcrumb', ''); ?>
                </div>
            </section>
            <section class="info-acount">
                <div class="container">
                    <div class="info-acount-flex row">
                        <div class="info-acount-col-left col col-md-3">
                            <div class="inner">
                                <div class="info-acount-col-left-hd">

                                    <label class="ava-label" for="fileUpLoad">
                                        <div class="loading-img">
                                            <?php
                                            if (!empty($avatar)) {
                                                echo $avatar;
                                            } else {
                                            ?>
                                                <img src="<?php get_site_url(); ?>/template/assets/images/default-mona.png" class="fileImg img-src" id="m_id_thumb">
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="preview-img">
                                            <span class="button-upload">
                                                <?php
                                                if (!empty($avatar)) {
                                                    echo $avatar;
                                                } else {
                                                ?>
                                                    <img src="<?php get_site_url(); ?>/template/assets/images/ic-user-2.svg" alt="" id="m_id_thumb" />
                                                <?php
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <input class="upload-image" type="file" accept=".png" hidden id="fileUpLoad">
                                    </label>

                                    <p class="name">
                                        <?php echo $user_data->display_name ?>
                                    </p>
                                </div>
                                <div class="info-acount-col-left-bd">

                                    <?php foreach ($itemMenu as $key => $value) {
                                        $current = "";
                                        $url = esc_url(wc_get_account_endpoint_url($key));
                                        $name = $value;
                                        $icon = $account->icon_item_menu($key);
                                        if ('dashboard' === $key && (isset($wp->query_vars['page']) or empty($wp->query_vars)) or array_key_exists($key, (array) $wp->query_vars)) {
                                            $current = 'active';
                                        }
                                        if ($key == 'thay-doi-mat-khau' && array_key_exists($key, (array) $wp->query_vars)) {
                                            $current = 'active';
                                            $class = 'changepass';
                                        }
                                        if ($key == 'don-hang' && array_key_exists($key, (array) $wp->query_vars)) {
                                            $current = 'active';
                                            $class = 'm-orders';
                                            $clas_main = 'pfcus-his-fix';
                                        }
                                    ?>

                                        <a class="link <?php echo $current; ?>" href="<?php echo $url; ?>">
                                            <img src="<?php echo $icon; ?>" alt="" />
                                            <span class="txt">
                                                <?php echo $name; ?>
                                            </span>
                                        </a>

                                    <?php } ?>

                                </div>
                                <a class="btn btn-pri" href="<?php echo wp_logout_url(home_url()); ?>"><span class="txt"><?php _e('Đăng xuất', 'monamedia'); ?></span></a>
                            </div>
                        </div>
                        <div class="info-acount-col-right col col-md-9">

                            <?php the_content() ?>

                        </div>
                    </div>
                </div>
            </section>
        </main>

<?php
    endwhile;
    get_footer();
} else {
    wp_redirect(site_url(''));
}
