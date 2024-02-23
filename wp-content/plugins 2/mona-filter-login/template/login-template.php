<?php


if (is_user_logged_in()) {
    wp_redirect(get_home_url());
}
get_header();
while (have_posts()) :
    the_post();

    $img_page_account = get_field('img_page_account');
?>
    <form action="" class="is-loading-group" id="mona-login-form">

        <main class="main spc-hd spc-hd-2">
            <section class="nav-bread">
                <div class="container">
                    <?php get_template_part('/partials/breadcrumb', ''); ?>
                </div>
            </section>
            <section class="login">
                <div class="container">
                    <div class="inner">
                        <div class="login-form">
                            <div class="login-hd">
                                <p class="tt-sec"><?php _e('Đăng nhập', 'monamedia'); ?></p>
                            </div>
                            <form action="">
                                <div class="box-form">
                                    <div class="group-form">
                                        <label class="txt" for=""><?php _e('Email', 'monamedia'); ?></label>
                                        <input name="user_name" type="text" placeholder="Email" required>
                                    </div>
                                    <div class="group-form">
                                        <label class="txt" for=""><?php _e('Mật khẩu', 'monamedia'); ?></label>
                                        <input class="re-input" name="user_pass" type="password" placeholder="Mật khẩu" required>
                                    </div>
                                    <div class="group-sup">
                                        <a class="txt forgot-password" href="<?php echo site_url('quen-mat-khau/') ?>">
                                            <?php _e('Quên mật khẩu', 'monamedia'); ?>
                                        </a>
                                        <a class="txt sign-up" href="<?php echo site_url('dang-ky/') ?>">
                                            <?php _e('Bạn là thành viên mới? ', 'monamedia'); ?><?php _e('Đăng ký tại đây', 'monamedia'); ?>
                                        </a>
                                    </div>
                                    <button class="btn btn-pri" type="submit">
                                        <span class="txt">
                                            <?php _e('Đăng nhập', 'monamedia'); ?>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="form-img">
                            <div class="img"> <img src="<?php get_site_url(); ?>/template/assets/images/banner-blog.png" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

    </form>
<?php
endwhile;
get_footer();
?>