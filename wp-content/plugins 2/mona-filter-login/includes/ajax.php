<?php

function mona_ajax_logout()
{
    wp_logout();
    wp_die();
}

add_action('wp_ajax_mona_ajax_logout', 'mona_ajax_logout');

function mona_ajax_login()
{
    $form = array();

    parse_str($_POST['form'], $form);
    $args = array(
        'user_login' => $form['user_name'],
        'user_password' => @$form['user_pass'],
        'remember' => (@$form['user_remember'] == 'yes' ? true : false)
    );
    $on = wp_signon($args);
    if (is_wp_error($on)) {
        // echo json_encode(array('status' => 'error', 'mess' => $on->get_error_message()));
        echo json_encode(array('status' => 'error', 'mess' => 'Please check your email or password again.'));
        wp_die();
    }
    $_SESSION['has_destroy'] = 'no';
    echo json_encode(array('status' => 'success', 'mess' => 'Login successful', 'redirect' => site_url('account/')));
    wp_die();
}

add_action('wp_ajax_nopriv_mona_ajax_login', 'mona_ajax_login');

function mona_ajax_register()
{

    $form = array();
    parse_str($_POST['form'], $form);
    $user_login_input = $form['register_email'];

    if (is_email($user_login_input)) {
        $user = get_user_by('email', $form['register_email']);
        if ($user) {
            echo json_encode(array('status' => 'error', 'mess' => __('Email đã tồn tại.', 'monamedia')));
            wp_die();
        }
    }
    if ($form['register_email'] == '') {
        echo json_encode(array('status' => 'error', 'mess' => __('Vui lòng nhập mật khẩu.', 'monamedia')));
        wp_die();
    }
    if ($form['register_pass'] == '' || $form['register_pass'] != $form['register_repass']) {
        echo json_encode(array('status' => 'error', 'mess' => __('Vui lòng nhập mật khẩu hoặc đảm bảo mật khẩu trùng khớp.', 'monamedia')));
        wp_die();
    }
    if (strlen($form['register_pass']) < 6) {
        echo json_encode(array('status' => 'error', 'mess' => __('Vui lòng nhập mật khẩu dài hơn 6 ký tự.', 'monamedia')));
        wp_die();
    }
    $email_parts = explode('@', $form['register_email']);

    if (count($email_parts) === 2) {
        // $username_part = $form['register_name'];
        $username_part = $email_parts[0];
    }
    $args = array(
        'user_login'        => $username_part,
        'user_email'        => $form['register_email'],
        'user_pass'         => $form['register_pass'],
        'user_nicename'     => $username_part,
        // 'display_name'      => $form['register_display'],
        'display_name'      => $form['register_name'],
        // 'nickname' => $form['register_name'],
        //    'role' => 'author'
    );
    $ins = wp_insert_user($args);
    if (is_wp_error($ins)) {
        echo json_encode(array('status' => 'error', 'mess' => $ins->get_error_message()));
        wp_die();
    }
    $args = array(
        'user_login' => $username_part,
        'user_password' => @$form['register_pass'],
        'remember' => true
    );

    $user_signin = wp_signon($args);
    if (is_wp_error($user_signin)) {
        echo json_encode(array('status' => 'error', 'mess' => $user_signin->get_error_message()));
    } else {
        echo json_encode(array('status' => 'success', 'mess' => 'Đăng ký thành công', 'redirect' =>  site_url('account/')));
    }
    // $on = wp_signon($args);
    // update_user_meta($ins, '_phone', $form['register_phone']);
    // update_user_meta($ins, '_first', true);
    // update_user_meta($ins, '_birthday', $form['register_birthday']);
    // update_user_meta($ins, '_sex', $form['register_sex']);
    // echo json_encode(array('status' => 'success', 'mess' => '', 'redirect' =>  site_url('/sign-in')));
    wp_die();
}

add_action('wp_ajax_nopriv_mona_ajax_register', 'mona_ajax_register');

function mona_ajax_send_foget_pass()
{
    $form = array();
    parse_str($_POST['form'], $form);
    $user_data = get_user_by('email', $form['register_email']);
    if (!$user_data) {
        echo json_encode(array('status' => 'warning', 'mess' => __('Không tồn tại ' . $form['register_email'], 'monamedia')));
        wp_die();
    }

    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    $key = get_password_reset_key($user_data);

    // $message = __('Xin chào ' . $user_data->user_email . ', ') . "\r\n\r\n";
    // $message .= __('Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản trên ') . get_bloginfo('name') . "\r\n\r";
    // $message .= __('TĐể lấy lại mật khẩu. Vui lòng nhấp vào liên kết bên dưới:') . "\r\n";
    // $message .= '<' . site_url('/lost-password') . "?reset&key=$key&login=" . rawurlencode($user_login) . "&reset=lost-password>\r\n";
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Your Name <your@email.com>',
    );

    $message = '<html>';
    $message .= '<body>';
    $message .= '<div class="logo-header" style="width: 100%; text-align: center;"> <img src="' . get_site_url() . '/template/assets/images/LOGO-PNG.png" class="logo_mail" alt="Logo"></div>';
    $message .= '<p style=" color: #4D5761;padding-left: 30%; font-size: 1rem; padding-right: 30%; text-align: center;">Email này để đặt lại mật khẩu của bạn.</br>Để đặt lại mật khẩu của bạn, hãy nhấp vào nút bên dưới.</p>';
    $message .= '<div class="email" style="width: 100%; text-align: center; padding: 0.5rem;">';
    $message .= '<a style="font-size: 1rem; background-color: #9C8679; margin: 0 auto; color: #FCFCFD; text-decoration: none; padding: 1rem 3rem; border-radius: 5px;" href="' . site_url('/quen-mat-khau') . "?reset&key=$key&login=" . rawurlencode($user_login) . '&reset=lost-password">Cập nhật mật khẩu</a>';
    $message .= '</div>';
    $message .= '<p style="text-align: center; font-size: 1rem; color: #4D5761;"> Cảm ơn! </p>';
    $message .= '<p style="text-align: center; font-size: 1rem; color: #4D5761;"> LALUZ </p>';
    $message .= `<p style="text-align: center; font-size: 1rem; color: #4D5761;"> *Nếu bạn không muốn thay đổi mật khẩu hoặc không yêu cầu đặt lại mật khẩu, bạn có thể bỏ qua email này.</p>`;
    $message .= '</body>';
    $message .= '</html>';


    if ($message && !wp_mail($user_email, wp_specialchars_decode(get_bloginfo('name') . ' Re-Password '), $message, $headers)) {
        $error = 'Không thể gửi email. Vui lòng liên hệ quản trị viên để tìm hiểu thêm';
        echo json_encode(array('status' => 'error', 'mess' => $error));
        wp_die();
    } else {
        $success = '<h3 class="success">Email đặt lại mật khẩu đã được gửi đến email của bạn! Hãy kiểm tra hộp thư đến của bạn.</h3>';
        echo json_encode(array('status' => 'success', 'mess' => $success));
        wp_die();
    }
    wp_die();
}

add_action('wp_ajax_nopriv_mona_ajax_send_foget_pass', 'mona_ajax_send_foget_pass');

function mona_ajax_reset_pass()
{
    $form = array();
    parse_str($_POST['form'], $form);
    $check = check_password_reset_key(@$form['key'], @$form['login']);
    if (is_wp_error($check)) {
        echo json_encode(array('status' => 'error', 'mess' => 'Liên kết truy cập đã hết hạn.'));
        wp_die();
    }
    if (strlen($form['new_password']) < 6) {
        echo json_encode(array('status' => 'error', 'mess' => __('Vui lòng nhập nhiều hơn 6 ký tự.', 'monamedia')));
        wp_die();
    }
    if (@$form['new_password'] !== @$form['usr_reset_pass']) {
        echo json_encode(array('status' => 'error', 'mess' => __('Mật khẩu không hợp lệ.', 'monamedia')));
        wp_die();
    }
    $user_data = get_user_by('login', $form['login']);
    reset_password($user_data, @$form['new_password']);
    if ($user_data) {
        wp_clear_auth_cookie();
        wp_set_auth_cookie($user_data->ID, true);
        do_action('wp_login', $user_data->user_login, $user_data);
    }
    echo json_encode(array('status' => 'success', 'mess' => 'Đã cập nhật mật khẩu thành công.', 'redirect' => site_url('account/')));

    wp_die();
}

add_action('wp_ajax_nopriv_mona_ajax_reset_pass', 'mona_ajax_reset_pass');
