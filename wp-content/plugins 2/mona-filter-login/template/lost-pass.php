<?php
if (is_user_logged_in()) {
    return wp_redirect(get_home_url());
}
get_header();
while (have_posts()) :
    the_post();
    $img_page_account = get_field('img_page_account');
?>

<main class="main spc-hd spc-hd-2">

    <?php if (!isset($_GET['reset'])) { ?>

    <form action="" class="is-loading-group" method="post" id="mona-foget-submit-form">

        <section class="nav-bread">
            <div class="container">
                <?php get_template_part('/partials/breadcrumb', ''); ?>
            </div>
        </section>
        <section class="login forgot-password">
            <div class="container">
                <div class="inner">
                    <div class="login-form">
                        <div class="login-hd">
                            <p class="tt-sec"><?php _e('Đặt lại mật khẩu', 'monamedia') ?></p>
                        </div>
                        <div class="box-form">
                            <div class="group-form">
                                <label class="txt" for=""><?php _e('Nhập Email', 'monamedia') ?></label>
                                <input type="email" name="register_email" placeholder="Email" required>
                            </div>
                            <button class="btn btn-pri" type="submit">
                                <span class="txt">
                                    <?php _e('Gửi', 'monamedia') ?>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </form>

    <?php } else { ?>

    <form action="" class="is-loading-group" method="post" id="mona-foget-reset-form">
        <input type="hidden" name="key" value="<?php echo $_GET['key']; ?>" />
        <input type="hidden" name="login" value="<?php echo $_GET['login']; ?>" />

        <section class="nav-bread">
            <div class="container">
                <?php get_template_part('/partials/breadcrumb', ''); ?>
            </div>
        </section>
        <section class="login forgot-password">
            <div class="container">
                <div class="inner">
                    <div class="login-form">
                        <div class="login-hd">
                            <p class="tt-sec"><?php _e('Đặt lại mật khẩu', 'monamedia') ?></p>
                        </div>
                        <div class="box-form">
                            <div class="group-form">
                                <label class="txt" for=""><?php _e('Mật khẩu', 'monamedia'); ?></label>
                                <input type="password" name="new_password" placeholder="Mật khẩu" required>
                            </div>
                            <div class="group-form">
                                <label class="txt" for=""><?php _e('Nhập lại mật khẩu', 'monamedia'); ?></label>
                                <input type="password" name="usr_reset_pass" placeholder="Nhập lại mật khẩu" required>
                            </div>
                            <button class="btn btn-pri" type="submit">
                                <span class="txt"><?php _e('Cập nhật', 'monamedia') ?>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </form>

    <?php } ?>

</main>

<?php

endwhile;
get_footer();

?>