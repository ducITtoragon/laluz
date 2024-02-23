export default function AlertCustom(type = "success", title = "", desc = "") {
  if (type == "error") {
    var icon_alert = `<i class="m-css-icon fa-solid fa-xmark"></i>`;
    var title = title != "" ? title : "Thông báo";
    var desc = desc != "" ? desc : "There has been a serious error";
  } else if (type == "warning") {
    var icon_alert = `<i class="m-css-icon  fas fa-exclamation-circle"></i>`;
    var title = title != "" ? title : "Warning";
    var desc = desc != "" ? desc : "Please check again";
  } else {
    var icon_alert = `<i class="m-css-icon fa-solid fa-check"></i>`;
    var title = title != "" ? title : "Success";
    var desc = desc != "" ? desc : "The action was successful";
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
