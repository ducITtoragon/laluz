<?php
if (is_user_logged_in()) {
    return wp_redirect(get_home_url());
}
get_header();
while (have_posts()) :
    the_post();
    $img_page_account = get_field('img_page_account');
?>
    <form action="" class="is-loading-group" method="post" id="mona-register-popup">

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
                                <p class="tt-sec"><?php _e('Đăng kí tài khoản', 'monamedia'); ?></p>
                            </div>
                            <form action="">
                                <div class="box-form">
                                    <div class="group-form">
                                        <label class="txt" for=""><?php _e('Email', 'monamedia'); ?></label>
                                        <input type="email" name="register_email" placeholder="Email" required>
                                    </div>
                                    <div class="group-form">
                                        <label class="txt" for=""><?php _e('Mật khẩu', 'monamedia'); ?></label>
                                        <input type="password" name="register_pass" placeholder="Mật khẩu" required>
                                    </div>
                                    <div class="group-form">
                                        <label class="txt" for=""><?php _e('Nhập lại mật khẩu', 'monamedia'); ?></label>
                                        <input type="password" name="register_repass" placeholder="Nhập lại mật khẩu" required>
                                    </div>
                                    <div class="group-sup"> <a class="txt sign-up" href="<?php echo site_url('dang-nhap/'); ?>">
                                            <?php _e('Bạn đã có tài khoản? Đăng nhập tại đây', 'monamedia'); ?>
                                        </a>
                                    </div>
                                    <button class="btn btn-pri"> <span class="txt"><?php _e('Đăng kí', 'monamedia'); ?></span></button>
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