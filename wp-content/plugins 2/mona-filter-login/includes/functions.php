<?php

function mona_filter_footer() {
    if (!is_user_logged_in()) {
        ?>
        <div id="mona-longin-form-wrap">
            <div class="login-signup-popup">
                <div class="tabs-main login-signup-tabs  ">
                    <div class="tab-nav login-signup-tab-nav">
                        <ul class="ul-nav">
                            <li id="tab-login" data-tab="#login" class="current login-tab"><?php _e('Đăng nhập', 'monamedia'); ?></li>
                            <span class="or"><?php _e('/', 'monamedia'); ?></span>
                            <li id="tab-register" data-tab="#sign-up" class="login-tab"><?php _e('Đăng ký', 'monamedia'); ?></li>
                        </ul>
                    </div>
                    <div class="login-signup-tab-container">
                        <div id="login" class="tab-content" style="display: block;">
                            <form id="mona-login-form" action="" method="post">
                                <div class="login-signup-form">
                                    <div class="f-group">
                                        <label class="label" for="your-name"><?php _e('Tên đăng nhâp', 'monamedia'); ?></label>
                                        <input required id="your-name" name="user_name" type="text" class="f-control">
                                    </div>
                                    <div class="f-group password-f-group">
                                        <label class="label" for="your-pass"><?php _e('Mật khẩu', 'monamedia'); ?></label>
                                        <input required id="your-pass" name="user_pass" type="password" class="f-control">
                                    </div>
                                </div>
                                <div class="remember-box flex-justify-between">
                                    <label for="remember-input-2" class="remember-label custom-checkbox">
                                        <input class="checkbox" id="remember-input-2" name="user_remember" value="yes" type="checkbox">
                                        <span class="checkmark"></span>
                                        <span class="ltp"><?php _e('Nhớ đăng nhập', 'monamedia'); ?></span>
                                    </label>
                                    <a href="<?php echo get_the_permalink(MONA_FORGOT_PASS); ?>" class="main-btn-3"><?php _e('Bạn quên mật khẩu ?', 'monamedia'); ?></a>
                                </div>

                                <div class="login-signup-btn-box" style="margin-bottom: 15px;">
                                    <button type="submit" class="submit-btn mona-has-ajax"><?php _e('Đăng nhập', 'monamedia'); ?></button>

                                </div>
                                <p id="response-login" class="response red"></p>
                            </form>
                        </div>
                        <div id="sign-up" class="tab-content" style="display: none;">
                            <form id="mona-register-popup" action="" method="post">
                                <div class="login-signup-form">
                                    <div class="f-group">
                                        <label class="label" for="your-name"><?php _e('Họ & tên', 'monamedia'); ?></label>
                                        <input required id="your-name" name="register_name" type="text" class="f-control">
                                    </div>
                                    <div class="f-group">
                                        <label class="label" for="your-phone"><?php _e('Điện thoại', 'monamedia'); ?></label>
                                        <input required id="your-phone" name="register_phone" type="text" class="f-control">
                                    </div>
                                    <div class="f-group">
                                        <label class="label" for="your-email"> <?php _e('Email', 'monamedia'); ?></label>
                                        <input required id="your-email" name="register_email"  type="email" class="f-control">
                                    </div>
<!--                                    <div class="f-group">
                                        <label class="label" for="your-birth"> <?php //_e('Ngày sinh', 'monamedia'); ?></label>
                                        <input required id="your-birth" name="register_birthday"  type="text" class="f-control">
                                    </div>
                                    <div class="f-group">
                                        <label class="label" for="your-cndd"> <?php //_e('Số CMND', 'monamedia'); ?></label>
                                        <input required id="your-birth" name="register_cmnd"  type="text" class="f-control">
                                    </div>-->
<!--                                    <div class="f-group">
                                        <label class="label" for="your-addr"> <?php //_e('Địa chỉ', 'monamedia'); ?></label>
                                        <textarea required id="your-addr" name="register_address"  type="text" class="f-control"></textarea>
                                    </div>-->

                                    <div class="f-group">
                                        <label class="label" for="your-loginname"><?php _e('Tên đăng nhập', 'monamedia'); ?></label>
                                        <input required id="your-loginname" name="register_loginname"  type="text" class="f-control">
                                    </div>
                                    <div class="f-group password-f-group">
                                        <label class="label" for="your-pass"> <?php _e('Mật khẩu', 'monamedia'); ?></label>
                                        <input required id="your-pass" name="register_pass"  type="password" class="f-control">
                                    </div>
                                    <div class="f-group password-f-group">
                                        <label class="label" for="verify-pass"> <?php _e('Xác nhận mật khẩu', 'monamedia'); ?></label>
                                        <input required id="verify-pass" name="register_repass"  type="password" class="f-control">
                                    </div>
                                </div>

                                <div class="remember-box">
                                    <a href="<?php echo get_the_permalink(MONA_FORGOT_PASS); ?>" class="main-btn-3"><?php _e('Bạn quên mật khẩu ?', 'monamedia'); ?></a>

                                </div>
                                <div class="login-signup-btn-box">
                                    <button type="submit" class="submit-btn mona-has-ajax"><?php _e('Đăng ký', 'monamedia'); ?></button>
                                </div>
                                <p id="response-register" class="response red"></p>
                            </form>
                        </div>
                    </div>
                </div>
                <span class="mona-close-popup"> <i class="fa fa-times" aria-hidden="true"></i> </span>
            </div>
        </div>    
        <?php
    }
}

add_action('wp_footer', 'mona_filter_footer');
