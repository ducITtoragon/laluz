import AlertCustom from "./alert.js";

export default function cart() {
  function deleteCookie(cookieName) {
    document.cookie =
      cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }

  // Hàm để tạo cookie mới với tên "cart_name" và giá trị là product_id
  function createCartCookie(product_id) {
    document.cookie = "cart_name=" + product_id + "; path=/";
  }

  function mona_cart_fragments(processing) {
    $.ajax({
      url: mona_ajax_url.ajaxURL,
      type: "post",
      data: {
        action: "mona_cart_fragments",
      },
      error: function (request) {
        processing.removeClass("processing");
      },
      beforeSend: function (response) {
        processing.addClass("processing");
      },
      success: function (result) {
        if (result && result.fragments) {
          $.each(result.fragments, function (key, value) {
            console.log(value);
            $(key).replaceWith(value);
          });
        }
        processing.removeClass("processing");
      },
    });
  }

  function AddToCart(formdata, act, loading, cookie) {
    if (!loading.hasClass("loading")) {
      if (window.location.hash === "#none") {
        history.pushState(
          "",
          document.title,
          window.location.pathname + window.location.search
        );
      }

      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_ajax_add_to_cart",
          formdata: formdata,
          type: act,
        },
        error: function (request) {
          loading.removeClass("processing");
          AlertCustom("error", "Thông báo", request.data.message);
        },
        beforeSend: function (response) {
          loading.addClass("processing");
        },
        success: function (result) {
          loading.removeClass("processing");
          if (result.success == true) {
            // AlertCustom("success", "Thông báo", result.data.message);
            // mona_cart_fragments(loading);

            mona_cart_fragments(loading);

            deleteCookie("cart_name");
            createCartCookie(cookie);
            $(".hd-cart").trigger("click");
          } else {
            AlertCustom("error", "Thông báo", result.data.message);
            if (window.location.href.indexOf("#none") === -1) {
              window.location.href += "#none";
            }
          }
        },
      });
    }
  }

  function BuyNow(formdata, act, loading, cookie) {
    if (!loading.hasClass("processing")) {
      if (window.location.hash === "#none") {
        history.pushState(
          "",
          document.title,
          window.location.pathname + window.location.search
        );
      }

      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_ajax_add_to_cart",
          formdata: formdata,
          type: act,
        },
        error: function (request) {
          loading.removeClass("processing");
          AlertCustom("error", "Thông báo", request.data.message);
        },
        beforeSend: function (response) {
          loading.addClass("processing");
        },
        success: function (result) {
          loading.removeClass("processing");
          if (result.success == true) {
            AlertCustom("success", "Thành công", result.data.message);
            mona_cart_fragments(loading);
            deleteCookie("cart_name");
            createCartCookie(cookie);
            window.location.href = result.data.redirect;
          } else {
            AlertCustom("error", "Thông báo", result.data.message);
            if (window.location.href.indexOf("#none") === -1) {
              window.location.href += "#none";
            }
          }
        },
      });
    }
  }

  $(document).on("click", ".mona-add-to-cart-detail", function (e) {
    e.preventDefault();

    var $this = $(this);

    if ($this.closest("#frmAddProduct").length) {
      var formdata = $this.closest("#frmAddProduct").serialize();
    } else if ($("#frmAddProduct").length) {
      var formdata = $("#frmAddProduct").serialize();
    } else {
      var formdata = $this.closest("form").serialize();
    }

    var act = $this.data("act");

    let loading = $(this).find(".is-loading-group");

    let cookie = $(this).data("cookie");

    AddToCart(formdata, act, loading, cookie);
  });

  $(document).on("click", ".m-buy-now", function (e) {
    e.preventDefault();
    var $this = $(this);
    if ($this.closest("#frmAddProduct").length) {
      var formdata = $this.closest("#frmAddProduct").serialize();
    } else if ($("#frmAddProduct").length) {
      var formdata = $("#frmAddProduct").serialize();
    } else {
      var formdata = $this.closest("form").serialize();
    }
    var act = "now";
    let loading = $(this).find(".is-loading-group");
    let cookie = $(this).data("cookie");
    BuyNow(formdata, act, loading, cookie);
  });

  // submit update cart
  $(document).on("click", ".mona-submit-cart", function (e) {
    e.preventDefault();
    $('[name="update_cart"]').trigger("click");
  });

  //change content in text (cart)
  function updateCouponLink() {
    const text_1 = document.querySelector(
      ".wc-block-components-totals-coupon-link"
    );

    if (text_1) {
      text_1.textContent = "Nhập mã ưu đãi";
    }

    const removeLinks = document.querySelectorAll(
      ".wc-block-cart-item__remove-link"
    );
    if (removeLinks) {
      removeLinks.forEach((link) => {
        link.textContent = "Xóa sản phẩm";
      });
    }

    const returnToCartLink = document.querySelector(
      ".wc-block-components-checkout-return-to-cart-button"
    );
    if (returnToCartLink) {
      returnToCartLink.textContent = "Quay lại giỏ hàng";
    }

    const orderSummaryButton = document.querySelector(
      ".wc-block-components-order-summary__button-text"
    );
    if (orderSummaryButton) {
      orderSummaryButton.textContent = "Sản phẩm";
    }
  }
  window.addEventListener("load", updateCouponLink);
}
