<?php
add_action('wp_ajax_m_a_change_password', 'm_a_change_password');
function check_password($old_pass, $id_user)
{
    $hash = get_userdata($id_user)->user_pass;
    $check = wp_check_password($old_pass, $hash, $id_user);
    return $check;
}
function check_verify($pass1, $pass2)
{
    return $pass1 === $pass2;
}
function m_a_change_password()
{
    $form = array();
    parse_str($_POST['formData'], $form);
    $currentPass = $form['current-password'];
    $newPass = $form['new-pass'];
    $id_user = get_current_user_id();
    $newRepass = $form['new-repass'];
    if ($currentPass != '' && $newPass != '') {
        if (check_password($currentPass, $id_user)) {
            if (check_verify($newPass, $newRepass)) {
                $user_data = get_userdata($id_user);
                wp_set_password($newPass, $id_user);
                $args = array(
                    'user_login' => $user_data->user_login,
                    'user_password' => $newPass,
                );
                $on = wp_signon($args);
                if ($on) {
                    echo wp_send_json_success(
                        [
                            'mess' => 'Mật khẩu đã được thay đổi thành công.'
                        ]
                    );
                    wp_die();
                }
            } else {

                wp_send_json_error(
                    [
                        'mess'   => __('Mật khẩu không đúng. Vui lòng thử lại.', 'monamedia'),
                    ]
                );
                wp_die();
            }
        } else {

            wp_send_json_error(
                [
                    'mess'   => __('Mật khẩu cũ không chính xác.', 'monamedia'),
                ]
            );
            wp_die();
        };
    } else {
        wp_send_json_error(
            [
                'mess'   => __('Đừng để trống.', 'monamedia'),
            ]
        );
        wp_die();
    }
}


add_action('wp_ajax_mona_update_ajax_shipping', 'mona_update_ajax_shipping');
function mona_update_ajax_shipping()
{
    $form = array();
    $id_user = get_current_user_id();
    parse_str($_POST['formData'], $form);

    $shipping_first_name = $form['shipping_first_name'];
    $shipping_last_name = $form['shipping_last_name'];
    $shipping_address_1 = $form['shipping_address_1'];
    $shipping_city = $form['shipping_city'];
    $shipping_state = $form['shipping_state'];
    $shipping_phone = $form['shipping_phone'];


    $user_info = get_userdata($id_user);

    if ($user_info) {
        // Cập nhật thông tin địa chỉ giao hàng
        update_user_meta($id_user, 'shipping_first_name', $shipping_first_name);
        update_user_meta($id_user, 'shipping_last_name', $shipping_last_name);
        update_user_meta($id_user, 'shipping_address_1', $shipping_address_1);
        update_user_meta($id_user, 'shipping_city', $shipping_city);
        update_user_meta($id_user, 'shipping_state', $shipping_state);
        update_user_meta($id_user, 'shipping_phone', $shipping_phone);
        wp_send_json_success(
            [
                'mess' => __('Cập nhật thành công', 'monamedia')
            ]
        );
        wp_die();
    } else {
        wp_send_json_error(
            [
                'mess'   => __('Cập nhật thất bại', 'monamedia'),
            ]
        );
        wp_die();
    }
}


add_action('wp_ajax_m_a_edit_account', 'm_a_edit_account');
function m_a_edit_account()
{
    $form = array();
    $id_user = get_current_user_id();
    parse_str($_POST['formData'], $form);
    $DisplayName = $form['m-edit-name'];
    $UserPhone = $form['m-edit-phone'];
    $birthday = $form['birthday'];
    // $user_id = $form['m-edit-user'];
    $user_address = $form['m-edit-address'];
    $user_zipcode = $form['m-edit-zipcode'];

    $dateObj = DateTime::createFromFormat('d/m/Y', $birthday);

    unset($form['display_name']);
    unset($form['user-email']);

    $args = array(
        'ID' => $id_user,
        'display_name' => strip_tags($DisplayName),
    );

    $update = wp_update_user($args);
    if (is_wp_error($update)) {

        wp_send_json_error(
            [
                'mess'   => __('Cập nhật thất bại', 'monamedia'),
            ]
        );
        wp_die();
    }
    if ($dateObj && $dateObj->format('d/m/Y') === $birthday) {
        update_user_meta($id_user, '_address', strip_tags($user_address));
        update_user_meta($id_user, '_zipcode', strip_tags($user_zipcode));

        $date = $dateObj->format('d/m/Y');
        update_user_meta($id_user, 'birthday', $date);

        update_user_meta($id_user, '_phone', strip_tags($UserPhone));

        echo wp_send_json_success(
            [
                'mess' => 'Cập nhật thành công'
            ]
        );
        wp_die();
    } else {
        wp_send_json_error(
            [
                'mess'   => __('Please enter the correct date of birth format', 'monamedia'),
            ]
        );
        wp_die();
    }
}
