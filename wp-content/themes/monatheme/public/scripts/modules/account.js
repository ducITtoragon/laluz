import AlertCustom from "./alert.js";
export default function MonaCreateModuleAccount() {
  //   if (input_image) {
  //     input_image.addEventListener("change", (event) => {
  //       const target = event.target;
  //       let type = target.files[0].type;
  //       if (type == "image/png" || type == "image/jpeg" || type == "image/jpg") {
  //         if (target.files && target.files[0]) {
  //           const maxAllowedSize = 2 * 1024 * 1024;
  //           console.log(target.files[0].size, maxAllowedSize);
  //           if (target.files[0].size > maxAllowedSize) {
  //             text_alert.classList.add("warning");

  //             console.log("anh bu qua ban oi");
  //             target.value = "";
  //           }
  //           let file = target.files[0];
  //           if (file) {
  //             let reader = new FileReader();
  //             reader.onload = function (event) {
  //               $("#m_id_thumb").attr("srcset", "");
  //               $("#m_id_thumb").attr("src", event.target.result);
  //             };
  //             reader.readAsDataURL(file);
  //           }
  //         }
  //       } else {
  //         text_alert.classList.add("warning");
  //         text_alert.innerHTML = "Format error!";
  //       }
  //     });
  //   }

  $(document).on("submit", "#m-edit-account", function (e) {
    e.preventDefault();
    let formData = $(this).serialize();
    let $this = $(this);
    if (!$this.hasClass("processing")) {
      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "POST",
        data: {
          action: "m_a_edit_account",
          formData: formData,
        },
        success: function (response) {
          $this.removeClass("processing");
          if (response.success == true) {
            AlertCustom("success", "Successful ", response.data.mess);
            window.location.reload();
          } else {
            AlertCustom("error", "Thông báo", response.data.mess);
          }
        },
        error: function () {
          $this.removeClass("processing");
        },
        beforeSend: function () {
          $this.addClass("processing");
        },
      });
    }
  });

  $("#f-change-password").on("submit", function (e) {
    e.preventDefault();
    let formData = $(this).serialize();
    let $this = $(this);
    if (!$this.hasClass("processing")) {
      $.ajax({
        url: mona_ajax_url.ajaxURL,
        type: "POST",
        data: {
          action: "m_a_change_password",
          formData: formData,
        },
        success: function (response) {
          $this.removeClass("processing");
          console.log(response);
          if (response.success == true) {
            AlertCustom("success", "Thành công", response.data.mess);
            window.location.reload();
          } else {
            AlertCustom("error", "Thông báo", response.data.mess);
          }
        },
        error: function () {
          $this.removeClass("processing");
        },
        beforeSend: function () {
          $this.addClass("processing");
        },
      });
    }
  });

  function copyToClipboard(text) {
    var $tempInput = $("<input>");
    $("body").append($tempInput);
    $tempInput.val(text).select();
    document.execCommand("copy");
    $tempInput.remove();
    setTimeout(function () {
      $tempInput.val("");
    }, 5000); // 3600000 mili giây = 1 giờ
  }
  $(document).on("click", ".mona-copy-text", function (e) {
    e.preventDefault();
    var $this = $(this);
    var text = $this.data("text");
    copyToClipboard(text);
    AlertCustom("success", "Thông báo", "Đã sao chép thành công");
  });

  //up avatar
  const sendAjaxPromise = (url, type, data) =>
    new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        type: type,
        data: data,
        success: function (result) {
          resolve(result);
        },
        error: function (error) {
          reject(error);
        },
      });
    });

  $("#m_id_thumb").on("load", function (e) {
    let $base64 = $(this).attr("src");
    if ($base64.startsWith("data")) {
      ajax_upload_img($base64);
    }
  });

  async function ajax_upload_img($file) {
    let $loading = $(".preview-img").find(".is-loading-group");

    try {
      $loading.addClass("processing");
      const result = await sendAjaxPromise(mona_ajax_url.ajaxURL, "post", {
        action: "mona_ajax_upload_post_img",
        data: $file,
      });
      $loading.removeClass("processing");
      let $result = JSON.parse(result);
      // $('#acc__ava__txt').text($result.messenger);
      AlertCustom("success", "Update Successful", $result.messenger);
      // $("#acc__ava__txt").css("color", "green");
    } catch (e) {
      console.log(e);
      $loading.removeClass("processing");
      // $('#acc__ava__txt').text(mona_ajax_url.text.error)
      // AlertCustom("success", "Success", mona_ajax_url.text.error);
      AlertCustom("error", "Thông báo", mona_ajax_url.text.error);
      $("#acc__ava__txt").css("color", "red");
    }
  }
  var input_image = document.getElementById("fileUpLoad");
  // const text_alert = document.getElementById('acc__ava__txt');
  if (input_image) {
    input_image.addEventListener("change", (event) => {
      // if (text_alert.classList.contains('warning')) {
      //     text_alert.classList.remove("warning");
      // }
      const target = event.target;
      let type = target.files[0].type;
      if (type == "image/png" || type == "image/jpeg" || type == "image/jpg") {
        if (target.files && target.files[0]) {
          const maxAllowedSize = 2 * 1024 * 1024;
          console.log(target.files[0].size, maxAllowedSize);
          if (target.files[0].size > maxAllowedSize) {
            // text_alert.classList.add("warning");
            // AlertCustom("warning", "Báo lỗi", mona_ajax_url.text.error);
            target.value = "";
            AlertCustom(
              "warning",
              "Warning",
              "Image Too Large, Please Choose an Image Smaller Than 2MB"
            );
            target.value = "";
          }
          let file = target.files[0];
          if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
              $("#m_id_thumb").attr("srcset", "");
              $("#m_id_thumb").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
          }
        }
      } else {
        text_alert.classList.add("warning");
        text_alert.innerHTML = "Format error!";
      }
    });
  }
}
