import AlertCustom from "./alert.js";

import SwiperModule from "../../../../../../../template/js/module/SwiperModule.js";
import SideModule from "../../../../../../../template/js/module/SideModule.js";
import gallery from "../../../../../../../template/js/module/GalleryModule.js";

export default function MonaCreateModuleProduct() {
    function deleteCookie(cookieName) {
        document.cookie =
            cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }

    // Hàm để tạo cookie mới với tên "cart_name" và giá trị là product_id
    function createCartCookie(product_id) {
        document.cookie = "cart_name=" + product_id + "; path=/";
    }

    function mona_cart_fragments(boxLoading) {
        $.ajax({
            url: mona_ajax_url.ajaxURL,
            type: "post",
            data: {
                action: "mona_cart_fragments",
            },
            error: function(request) {
                boxLoading.removeClass("loading");
            },
            beforeSend: function(response) {
                boxLoading.addClass("loading");
            },
            success: function(result) {
                if (result && result.fragments) {
                    // console.log("vào ròi");
                    $.each(result.fragments, function(key, value) {
                        $(key).replaceWith(value);
                        cart_open();
                    });
                }
                boxLoading.removeClass("loading");
            },
        });
    }

    function m_change_qty(key, qty, boxLoading) {
        let boxLoading = $(".info-bot").find(".is-loading-group");
        console.log(qty);
        if (!boxLoading.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "POST",
                data: {
                    action: "m_update_quantity_item",
                    qty: qty,
                    key: key,
                },
                success: function(response) {
                    boxLoading.removeClass("processing");
                    mona_cart_fragments(boxLoading);
                },
                error: function(e) {
                    boxLoading.removeClass("processing");
                },
                beforeSend: function() {
                    boxLoading.addClass("processing");
                },
            });
        }
    }

    $(document).on("click", ".m-add-wishlist", function(e) {
        e.preventDefault();
        let boxLoading = $(this).find(".is-loading-group"),
            $class = $(this),
            product_id = $(this).data("key");

        if (!boxLoading.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "POST",
                data: {
                    action: "m_add_wishlist_item",
                    product_id: product_id,
                },
                success: function(response) {
                    boxLoading.removeClass("processing");
                    if (response.success == true) {
                        $(".m-wishlist .num").html(response.data.number);

                        $class.addClass("active");
                        $class.removeClass("m-add-wishlist").addClass("m-remove-wishlist");
                        // window.location.href = "san-pham-yeu-thich";
                        AlertCustom("success", "Thành công", response.data.mess);
                        window.location.reload();
                    } else {
                        AlertCustom("error", "Thông báo", response.data.mess);
                    }
                },
                error: function() {
                    boxLoading.removeClass("processing");
                },
                beforeSend: function() {
                    boxLoading.addClass("processing");
                },
            });
        }
    });

    function cart_open() {
        const sideOpen = document.querySelector(".side-open");
        const sideClose = document.querySelector(".side-close");
        const sideFixed = document.querySelector(".side-fixed");
        const sideOverlay = document.querySelector(".side-overlay");
        const body = document.getElementsByTagName("body")[0];

        function Open() {
            sideFixed.classList.add("open");
            sideOverlay.classList.add("open");
            sideOpen.classList.add("close");
            body.style.overflowY = "hidden";
        }

        function Close() {
            sideFixed.classList.remove("open");
            sideOverlay.classList.remove("open");
            sideOpen.classList.remove("close");
            body.style.overflowY = "auto";
        }
        if (sideOpen) {
            sideOpen.addEventListener("click", () => {
                Open();
            });
        }
        if (sideClose) {
            sideClose.addEventListener("click", () => {
                Close();
            });
        }
        if (sideOverlay) {
            sideOverlay.addEventListener("click", () => {
                Close();
            });
        }
    }

    $(document).on("click", ".m-remove-wishlist", function(e) {
        e.preventDefault();
        let boxLoading = $(this).closest(".sec-wishlist").find(".box-loading"),
            boxLoading_1 = $(this).find(".is-loading-group"),
            $class = $(this),
            key = $(this).data("key");

        if (!boxLoading.hasClass("loading")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "POST",
                data: {
                    action: "m_remove_wishlist_item",
                    key: key,
                },
                success: function(response) {
                    boxLoading.removeClass("loading");
                    boxLoading_1.removeClass("processing");
                    if (response.success == true) {
                        AlertCustom("success", "Thông báo", response.data.mess);
                        $(".m-wishlist .num").html(response.data.number);
                        $(".wishlist").html(response.data.wishlist);
                        $class.removeClass("active");
                        $class.removeClass("m-remove-wishlist").addClass("m-add-wishlist");
                    } else {
                        AlertCustom("error", "Thông báo", response.data.mess);
                    }
                },
                error: function() {
                    boxLoading.removeClass("loading");
                    boxLoading_1.removeClass("processing");
                },
                beforeSend: function() {
                    boxLoading.addClass("loading");
                    boxLoading_1.addClass("processing");
                },
            });
        }
    });

    $(document).on("click", ".act-it.popup-open", function(e) {
        e.preventDefault();
        let boxLoading = $(this).find(".is-loading-group");
        if (!boxLoading.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "POST",
                data: {
                    action: "m_popupopen_card",
                },
                success: function(response) {
                    boxLoading.removeClass("processing");

                    if (response.success == true) {
                        AlertCustom("error", "Thông báo", response.data.mess);
                    } else {
                        AlertCustom("error", "Thông báo", response.data.mess);
                    }
                },
                error: function() {
                    boxLoading.removeClass("processing");
                },
                beforeSend: function() {
                    boxLoading.addClass("processing");
                },
            });
        }
    });

    $(document).on("click", ".m-add-to-cart-flash", function(e) {
        e.preventDefault();
        let isloadingGroup = $(this).find(".is-loading-group");
        let product_id = $(this).data("product-id");

        let quantity = $(this).siblings(".count").find(".count-input").val() || 1;
        // console.log("hello");
        // console.log(product_id);

        if (!isloadingGroup.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "POST",
                data: {
                    action: "m_add_cart_flash",
                    product_id: product_id,
                    qty: quantity,
                },
                success: function(response) {
                    isloadingGroup.removeClass("processing");
                    var object = JSON.parse(response);
                    if (object.status == "success") {
                        mona_cart_fragments(isloadingGroup);
                        // AlertCustom(object.status, "Thông báo", object.mess);
                        $(".header-cart").addClass("active");
                        setTimeout(() => {
                            $(".header-cart").removeClass("active");
                        }, 4000);
                        deleteCookie("cart_name");
                        createCartCookie(product_id);
                        $(".cartClick").trigger("click");
                    } else {
                        AlertCustom(object.status, "Thông báo", object.mess);
                        if (object.link) {
                            window.location.href = object.link;
                        }
                    }
                },
                error: function() {
                    isloadingGroup.removeClass("processing");
                },
                beforeSend: function() {
                    isloadingGroup.addClass("processing");
                },
            });
        }
    });

    $(document).on("click", ".m-remove-cart-item", function(e) {
        e.preventDefault();
        let boxLoading = $(this)
            .closest(".widget_shopping_cart_content")
            .find(".is-loading-group-2"),
            qty = $(this).closest("tr").find(".m-change-qty").val(),
            key = $(this).data("cart-key");

        if (!boxLoading.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "POST",
                data: {
                    action: "m_remove_cart_item",
                    key: key,
                    qty: qty,
                },
                success: function(response) {
                    boxLoading.removeClass("processing");
                    mona_cart_fragments(boxLoading);
                },
                error: function() {
                    boxLoading.removeClass("processing");
                },
                beforeSend: function() {
                    boxLoading.addClass("processing");
                },
            });
        }
    });

    $(document).on("click", ".m_price_minus", function(e) {
        e.preventDefault();

        var $this = $(this);

        var row = $this.closest(".hd-cart-item");

        let parent = $(this).closest(".sl-qty");

        var numberMain = parent.find(".count-number");

        if (numberMain) {
            let input_number = parent.find(".sl-qty-input"),
                number = input_number.val();
            if (parseInt(number) > 0) {
                let qty = parseInt(number) - 1;

                let key = row.find(".m-remove-cart-item").data("cart-key");
                // console.log(key);
                // m_change_qty(key, qty);
                m_change_qty(key, qty, $this);
            }
        }
    });

    $(document).on("click", ".m_price_plus", function(e) {
        e.preventDefault();

        var $this = $(this);

        var row = $this.closest(".hd-cart-item");

        let parent = $(this).closest(".sl-qty");

        var numberMain = parent.find(".count-number");

        if (numberMain) {
            let input_number = parent.find(".sl-qty-input"),
                number = input_number.val();

            let qty = parseInt(number) + 1;
            let key = row.find(".m-remove-cart-item").data("cart-key");

            m_change_qty(key, qty, $this);
        }
    });

    $(document).on("click", "#m_oder_cancel", function(e) {
        let boxLoading = $("#m_oder_cancel").find(".box-loading");
        let oder_id = $(this).data("id-order");
        if (!boxLoading.hasClass("loading")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "POST",
                data: {
                    action: "m_update_can_product",
                    oderId: oder_id,
                },
                success: function(response) {
                    boxLoading.removeClass("loading");
                    if (response.success == true) {
                        AlertCustom("success", "Thông báo", response.data.mess);
                        window.location.reload();
                    } else {
                        AlertCustom("error", "Thông báo", response.data.mess);
                        window.location.reload();
                    }
                },
                error: function() {
                    boxLoading.removeClass("loading");
                },
                beforeSend: function() {
                    boxLoading.addClass("loading");
                },
            });
        }
    });

    // $(document).on("click", "#monaAttriColor .mona-variation-item", function(e) {
    //     e.preventDefault();
    //     var $this = $(this);
    //     var taxonomy = $(this).data("taxonomy");
    //     var slug = $(this).data("slug");
    //     var product_id = $(this).data("product_id");

    //     $(this)
    //         .closest(".taxonomy-" + taxonomy)
    //         .find("input")
    //         .prop("checked", false);
    //     $this.find("input").prop("checked", true);
    //     if (!$this.closest(".recheck-block").hasClass("hasChecked")) {
    //         $this.closest(".recheck-block").addClass("hasChecked");
    //     }
    //     let flagAction = true;
    //     $this
    //         .closest("#monaAttriColor")
    //         .find(".recheck-block")
    //         .each(function(index, element) {
    //             if (!$(element).hasClass("hasChecked")) {
    //                 flagAction = false;
    //             }
    //         });

    //     if (flagAction) {
    //         var formdata = $this.closest("#frmAddProduct").serialize();
    //         let loading = $(this);
    //         // var loading = $this.closest("#monaAttriColor").find(".is-loading-group");
    //         if (!loading.hasClass("processing")) {
    //             $.ajax({
    //                 url: mona_ajax_url.ajaxURL,
    //                 type: "post",
    //                 data: {
    //                     action: "mona_ajax_find_variation",
    //                     formdata: formdata,
    //                 },
    //                 error: function(request) {
    //                     loading.removeClass("processing");
    //                     AlertCustom("error", "Error", result.data.message);
    //                 },
    //                 beforeSend: function(response) {
    //                     loading.addClass("processing");
    //                 },
    //                 success: function(result) {
    //                     loading.removeClass("processing");

    //                     if (result.success == true) {
    //                         $("#monaAttriColor").addClass("used");

    //                         if (result.data.current.price) {
    //                             $("#monaPriceProduct").html(result.data.current.price);
    //                         }

    //                         if (result.data.current.add_cart) {
    //                             $("#monaButtons").html(result.data.current.add_cart);
    //                         }

    //                         if (result.data.current.gallery) {
    //                             $("#monaGalleryProduct").html(result.data.current.gallery);
    //                             SwiperModule();
    //                             SideModule();
    //                             gallery();
    //                         }

    //                         if (result.data.current.combo) {
    //                             $("#monaComboProduct").html(result.data.current.combo);

    //                             // CheckledCombo();
    //                             // SelectQty();
    //                             // AosModule();
    //                         }

    //                         // if (result.data.current.coupon) {
    //                         //   $("#monaCouponProduct").html(result.data.current.coupon);
    //                         // }
    //                         AlertCustom("success", "Thông báo", result.data.current.mess);

    //                         // calcComboSave();
    //                     } else {
    //                         AlertCustom("error", "Error", result.data.message);
    //                         // $("#monaAttriColor").addClass("used");
    //                         // $("#monaButtons button").prop("disabled", true);
    //                         // $("#monaButtons button").addClass("mona-disabled");
    //                     }
    //                 },
    //             });
    //         }
    //     }
    // });

    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf("?") !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, "$1" + key + "=" + value + "$2");
        } else {
            if (value !== "") {
                return uri + separator + key + "=" + value;
            } else {
                return uri;
            }
        }
    }
}