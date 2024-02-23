export default function MonaReadMore() {
    $(".js-show-hide").click(function () {
        $(this).toggleClass("is-active");
        if ($(this).hasClass("is-active")) {
          $(this).find("span").html("Thu gọn");
        } else {
          $(this).find("span").html("Xem thêm");
        }
    
        $(this).closest(".show-hide-content").toggleClass("is-active");
      });
}