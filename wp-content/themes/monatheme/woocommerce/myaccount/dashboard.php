<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$userid = get_current_user_id();
$new_user = get_userdata($userid);
$full_name = $new_user->display_name;
$birthday = get_user_meta($userid, 'birthday', true);

$user_address = get_user_meta($userid, '_address', true);
$user_zipcode = get_user_meta($userid, '_zipcode', true);

$phone = get_user_meta($userid, '_phone', true);
$thumb = get_field('avt', 'user_' . $userid);

if ($thumb) {
    $avatar = wp_get_attachment_image($thumb, 'thumbnail', false, ['class' => 'fileImg', 'id' => 'm_id_thumb']);
} else {
    $avatar = '<img src="' . MONA_URL . '" class="fileImg" id="m_id_thumb">';
}

?>

<div class="inner">
    <form action="" class="is-loading-group" id="m-edit-account">
        <div class="form-info-acount row">
            <div class="group-form col col-md-6">
                <label class="name-group" for=""><?php _e('Họ và Tên', 'monamedia') ?></label>
                <input type="text" name="m-edit-name" required value="<?php echo $new_user->display_name ?>"
                    placeholder="<?php _e('Full Name', 'monamedia') ?>">

            </div>
            <div class="group-form col col-md-6">
                <label class="name-group" for=""><?php _e('Email', 'monamedia') ?></label>
                <input placeholder="Your email" type="text" value="<?php echo $new_user->user_email; ?>" readonly>

            </div>
            <div class="group-form col col-md-6">
                <label class="name-group" for=""><?php _e('Ngày sinh', 'monamedia') ?></label>
                <input class="date" name="birthday" value="<?php echo $birthday ?>">
            </div>
            <div class="group-form col col-md-6">
                <label class="name-group" for=""><?php _e('Số Điện thoại', 'monamedia') ?></label>
                <input type="tel" name="m-edit-phone" pattern="[0-9]{10}" required value="<?php echo $phone; ?>"
                    placeholder="Số Điện thoại">
            </div>
        </div>
        <button class="btn btn-pri"> <span class="txt"><?php _e('Thay đổi', 'monamedia') ?></span></button>
    </form>
</div>