jQuery(document).ready(function ($) {
  function AlertCustom(type = "success", title = "", desc = "") {
    if (type == "error") {
      var icon_alert = `<i class="m-css-icon fa-solid fa-xmark"></i>`;
      var title = title != "" ? title : "Lỗi";
      var desc = desc != "" ? desc : "Đã xảy ra lỗi nghiệm trọng";
    } else if (type == "warning") {
      var icon_alert = `<i class="m-css-icon  fas fa-exclamation-circle"></i>`;
      var title = title != "" ? title : "Cảnh báo";
      var desc = desc != "" ? desc : "Vui lòng kiểm tra lại";
    } else {
      var icon_alert = `<i class="m-css-icon fa-solid fa-check"></i>`;
      var title = title != "" ? title : "Thành công";
      var desc = desc != "" ? desc : "Hành động đã thành công";
    }
    var html_default = `
            <div class="alert showAlert show ${type}">
                ${icon_alert}
                <span class="msg">
                  <span class="m-bold-text">${title}</span> 
                  ${desc}
                </span>
                <div class="close-btn">
                <span class="fas fa-times"></span>
                </div>
            </div>
        `;
    let check_empty = jQuery(".alert").hasClass("show");
    if (!check_empty) {
      $("body").append(html_default);
      setTimeout(function () {
        jQuery(".alert").removeClass("show");
        jQuery(".alert").addClass("hide");
        setTimeout(() => {
          jQuery(".alert").remove();
        }, 1000);
      }, 3000);
    }

    jQuery(".close-btn").click(function () {
      jQuery(".alert").removeClass("show");
      jQuery(".alert").addClass("hide");
      setTimeout(() => {
        jQuery(".alert").remove();
      }, 1000);
    });
  }
  $(document).on("click", ".mona-close-popup", function (e) {
    e.preventDefault();
    jQuery.magnificPopup.close();
  });
  $(document).on("click", ".mona-popup-message .login-tab", function (e) {
    var $this = $(this);
    var $id = $this.attr("data-tab");

    $($id).stop().show().siblings(".tab-content").stop().hide();
    $this
      .stop()
      .addClass("current")
      .siblings(".login-tab")
      .stop()
      .removeClass("current");
  });

  $(".mona-logout-action").on("click", function (e) {
    e.preventDefault();
    var $this = $(this);
    if (!$this.hasClass("processing")) {
      $.ajax({
        url: mona_filter_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_ajax_logout",
        },
        error: function (request) {
          $this.removeClass("processing");
        },
        beforeSend: function () {
          $this.addClass("processing");
        },
        success: function (result) {
          window.location.reload();
        },
      });
    }
  });
  $(document).on("click", ".mona-action-login", function (e) {
    e.preventDefault();
    var $this = $(this);

    if ($("#mona-longin-form-wrap").length) {
      jQuery.magnificPopup.close();
      jQuery.magnificPopup.open({
        preloader: false,
        mainClass: "mfp-zoom-in",
        modal: true,
        items: {
          src:
            '<div class="mona-popup-message mfp-with-anim">' +
            $("#mona-longin-form-wrap").html() +
            "</div>",
          type: "inline",
          midClick: true,
        },
        callbacks: {
          open: function () {
            if ($this.hasClass("register")) {
              $(".mona-popup-message")
                .find("#tab-register")
                .addClass("current")
                .siblings()
                .removeClass("current");
              $(".login-signup-tab-container #sign-up")
                .show()
                .siblings()
                .hide();
            } else {
              $(".mona-popup-message")
                .find("#tab-login")
                .addClass("current")
                .siblings()
                .removeClass("current");
              $(".login-signup-tab-container #login").show().siblings().hide();
            }
          },
        },
      });
    }
  });
  $(document).on("submit", "#mona-login-form", function (e) {
    e.preventDefault();
    var $this = $(this);
    var box_loading = $this;
    var $form = $this.serialize();
    if (!$this.hasClass("processing")) {
      $.ajax({
        url: mona_filter_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_ajax_login",
          form: $form,
        },
        error: function (request) {
          box_loading.removeClass("processing");
        },
        beforeSend: function () {
          box_loading.addClass("processing");
        },
        success: function (result) {
          box_loading.removeClass("processing");
          var $data = $.parseJSON(result);
          if ($data.status == "success") {
            // AlertCustom("success", "Thành công", $data.mess);
            // setTimeout(function () {
            window.location.href = $data.redirect;
            // }, 2000);
          } else {
            AlertCustom("error", "Warning", $data.mess);
          }
        },
      });
    }
  });
  $(document).on("submit", "#mona-register-popup", function (e) {
    e.preventDefault();
    var $this = $(this);
    var box_loading = $this;
    var $form = $this.serialize();
    if (!$this.hasClass("processing")) {
      $.ajax({
        url: mona_filter_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_ajax_register",
          form: $form,
        },
        error: function (request) {
          box_loading.removeClass("processing");
        },
        beforeSend: function () {
          box_loading.addClass("processing");
          $this.find("#response-register").fadeOut().html("");
        },
        success: function (result) {
          box_loading.removeClass("processing");
          var $data = $.parseJSON(result);
          if ($data.status == "success") {
            AlertCustom("success", "Thành công ", $data.mess);
            setTimeout(function () {
              window.location.href = $data.redirect;
            }, 2000);
          } else {
            AlertCustom("error", "Lỗi", $data.mess);
          }
        },
      });
    }
  });
  $("#mona-foget-submit-form").on("submit", function (e) {
    e.preventDefault();
    var $this = $(this);
    var box_loading = $this;
    var $form = $this.serialize();
    if (!$this.hasClass("processing")) {
      $.ajax({
        url: mona_filter_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_ajax_send_foget_pass",
          form: $form,
        },
        error: function (request) {
          box_loading.removeClass("processing");
        },
        beforeSend: function () {
          box_loading.addClass("processing");
          $this.find("#response-foget").fadeOut().html("");
        },
        success: function (result) {
          box_loading.removeClass("processing");
          var $data = $.parseJSON(result);
          if ($data.status == "success") {
            AlertCustom("success", "Thành công", $data.mess);
          } else {
            AlertCustom("warning", "Cảnh báo", $data.mess);
          }
        },
      });
    }
  });

  $("#mona-foget-reset-form").on("submit", function (e) {
    e.preventDefault();
    var $this = $(this);
    var box_loading = $this;
    var $form = $this.serialize();
    if (!$this.hasClass("processing")) {
      $.ajax({
        url: mona_filter_ajax_url.ajaxURL,
        type: "post",
        data: {
          action: "mona_ajax_reset_pass",
          form: $form,
        },
        error: function (request) {
          box_loading.removeClass("processing");
        },
        beforeSend: function () {
          box_loading.addClass("processing");
          // $this.find("#response-foget").fadeOut().html("");
        },
        success: function (result) {
          box_loading.removeClass("processing");
          var $data = $.parseJSON(result);
          if ($data.status == "success") {
            AlertCustom("success", "Thành công", $data.mess);
            setTimeout(function () {
              window.location.href = $data.redirect;
            }, 2000);
          } else {
            AlertCustom("warning", "Cảnh báo", $data.mess);
          }
        },
      });
    }
  });
});
