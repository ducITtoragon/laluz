import {AddToCart} from "./global.js";

export default function AddToCartModule() {

    $(document).on('submit', '#monaFormProductData', function(e) {
        e.preventDefault();
        var $this = $(this);
        var loadingBtn = $this.find('button[type="submit"]');
        var formData = new FormData($(this)[0]);
        formData.append('action', 'mona_ajax_add_to_cart');
        formData.append('security', mona_ajax_url.ajaxNonce);
        if (!loadingBtn.hasClass('loading')) {
            AddToCart({
                formdata: formData,
                loading: loadingBtn,
            });
        }
    });

}