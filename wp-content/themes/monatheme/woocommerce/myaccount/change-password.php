<div class="inner">
    <form action="" id="f-change-password" class="is-loading-group">
        <div class="form-info-acount row">
            <div class="group-form col">
                <label class="name-group" for=""><?php _e('Mật khẩu cũ', 'monamedia'); ?></label>
                <input type="password" placeholder="Mật khẩu" name="current-password" required>
            </div>
            <div class="group-form col">
                <label class="name-group" for=""><?php _e('Mật khẩu mới', 'monamedia'); ?></label>
                <input type="password" placeholder="Mật khẩu" name="new-pass" required>
            </div>
            <div class="group-form col">
                <label class="name-group" for=""><?php _e('Nhập mật khẩu mới', 'monamedia'); ?></label>
                <input type="password" placeholder="Mật khẩu" name="new-repass" required>
            </div>
        </div>
        <button class="btn btn-pri" type="submit"> <span class="txt"><?php _e('Thay đổi', 'monamedia'); ?></span></button>
    </form>
</div>