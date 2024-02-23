import {filterVariation} from "./global.js";

export default function FilterVariationModule() {
    $(document).on(
        'change',
        '.productAttributeItem .attributeInput',
        function(e) {
            e.preventDefault();
            var $this = $(this);
            $(this).closest('.productAttributeItem').addClass('hasChecked');
            let flagAction = true;
            $(this)
                .closest('#monaFormProductData')
                .find('.productAttributeItem')
                .each(function(index, element) {
                    if (!$(element).hasClass("hasChecked")) {
                        flagAction = false;
                    }
                });
            if (flagAction) {
                var loadingBtn = $('');
                var formData = new FormData($('#monaFormProductData')[0]);
                formData.append('action', 'mona_ajax_filter_variation');
                formData.append('security', mona_ajax_url.ajaxNonce);
                if (!loadingBtn.hasClass('loading')) {
                    filterVariation({
                        formdata: formData,
                        loading: loadingBtn,
                    });
                }
            }
        }
    );
}
