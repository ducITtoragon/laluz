// import MonaCreateModuleDefault from "./default.js";

// export default function filterForm() {
//   $(document).ready(function () {
//     function scrollToID(id, speed, number) {
//       const offSet = $("header").outerHeight();
//       const section = $(id).offset();
//       const targetOffset = section.top - offSet - number;
//       $("html,body").animate({ scrollTop: targetOffset }, speed);
//     }

//     function Filter(loading, formData) {
//       if (loading.hasClass("processing")) {
//         $.ajax({
//           url: mona_ajax_url.ajaxURL,
//           type: "POST",
//           data: {
//             action: "mona_filter_product",
//             formData: formData,
//           },
//           success: function (response) {
//             loading.removeClass("processing");
//             if (response.success == true) {
//               let postsList = response.data.data;
//               let postsHtml = "";
//               for (let i = 0; i < postsList.length; i++) {
//                 postsHtml += postsList[i].data;
//               }

//               $(".monaPostsList").html(postsHtml);
//             } else {
//               let postsListNone = response.data.data;

//               $(".monaPostsList").html(postsListNone);
//             }
//           },
//           error: function (e) {
//             loading.removeClass("processing");
//           },
//           beforeSend: function () {
//             loading.addClass("processing");
//           },
//         });
//       }
//     }

//     let timeout;
//     if ($(window).width() > 1070) {
//       $(document).on("input change", ".mona-input-fiter", function (e) {
//         let form = $(this).closest("#product-filter");
//         clearTimeout(timeout);
//         timeout = setTimeout(function () {
//           form.submit();
//         }, 2000);
//       });
//     }

//     $(document).on("submit", "#product-filter", function (e) {
//       e.preventDefault();
//       let loading = $(".monaPostsList").addClass("processing");
//       let formData = $(this).serialize();
//       scrollToID(".monaPostsList", 500, 200);
//       Filter(loading, formData);
//     });
//   });
// }

export default function filterForm() {
    const speed = 800;
    const hash = window.location.hash;
    if ($(hash).length) scrollToID(hash, speed);
    $(".btn-scroll").on("click", function(e) {
        e.preventDefault();
        const href = $(this).find("> a").attr("href") || $(this).attr("href");
        const id = href.slice(href.lastIndexOf("#"));
        if ($(id).length) {
            scrollToID(id, speed);
        } else {
            window.location.href = href;
        }
    });

    function scrollToID(id, speed, number) {
        const offSet = $("header").outerHeight();
        const section = $(id).offset();
        const targetOffset = section.top - offSet - number;
        $("html,body").animate({ scrollTop: targetOffset }, speed);
    }

    function getPostListPaged(
        flag,
        $this,
        formdata,
        processing,
        action,
        paged = 1
    ) {
        if (!processing.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "post",
                data: {
                    action: "mona_ajax_pagination_posts",
                    formdata: formdata,
                    paged: paged,
                    action_layout: action,
                    action_flag: flag,
                },
                error: function(request) {
                    processing.removeClass("processing");
                },
                beforeSend: function(response) {
                    processing.addClass("processing");
                },
                success: function(result) {
                    if (result.success) {
                        console.log("success");
                        if (
                            result.data.action_return == "reload" &&
                            result.data.posts_html != ""
                        ) {
                            $this.find(".monaPostsList").html(result.data.posts_html);
                            scrollToID("." + result.data.scroll, 500, 200);
                        } else if (
                            result.data.action_return == "loadmore" &&
                            result.data.posts_html != ""
                        ) {
                            $this.find(".monaLoadMoreJS").remove();
                            $this.find(".monaPostsList").append(result.data.posts_html);
                        }
                    }
                    processing.removeClass("processing");
                },
            });
        }
    }

    // js search category (thuong hieu)
    var delayTimer;
    var ajaxRequest;
    $(document).on("keyup", ".filter-search.monaFilterJS-input", function(e) {
        var val = $(this).val();
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function() {
            if (ajaxRequest) {
                ajaxRequest.abort();
            }
            var $searchProduct = $("#MonaThuongHieu");
            ajaxRequest = $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "post",
                data: {
                    action: "mona_ajax_search_category",
                    val: val,
                },
                beforeSend: function() {
                    $searchProduct.addClass("processing");
                },
                success: function(response) {
                    $searchProduct.removeClass("processing");
                    console.log(response);
                    $("#MonaThuongHieu").html(response.data.html);
                },
            });
        }, 300);
    });

    var delayTimer;
    var ajaxRequest;

    // $(document).on("keyup", ".monaFilterJS-input-product", function(e) {
    //     var val = $(this).val();
    //     clearTimeout(delayTimer);
    //     delayTimer = setTimeout(function() {
    //         if (ajaxRequest) {
    //             ajaxRequest.abort();
    //         }
    //         var $searchProduct = $("#search-product");
    //         ajaxRequest = $.ajax({
    //             url: mona_ajax_url.ajaxURL,
    //             type: "post",
    //             data: {
    //                 action: "mona_ajax_search_product",
    //                 val: val,
    //             },
    //             beforeSend: function() {
    //                 $searchProduct.addClass("processing");
    //             },
    //             success: function(response) {
    //                 $searchProduct.removeClass("processing");
    //                 console.log(response);
    //                 $("#search-product").html(response.data.html);
    //             },
    //         });
    //     }, 300);
    // });

    // mobile
    // $(document).on("keyup", ".monaFilterJS-input-product-mobile", function(e) {
    //     var val = $(this).val();
    //     clearTimeout(delayTimer);
    //     delayTimer = setTimeout(function() {
    //         if (ajaxRequest) {
    //             ajaxRequest.abort();
    //         }
    //         var $searchProduct = $("#search-product-mobile");
    //         ajaxRequest = $.ajax({
    //             url: mona_ajax_url.ajaxURL,
    //             type: "post",
    //             data: {
    //                 action: "mona_ajax_search_product_mobile",
    //                 val: val,
    //             },
    //             beforeSend: function() {
    //                 $searchProduct.addClass("processing");
    //             },
    //             success: function(response) {
    //                 $searchProduct.removeClass("processing");
    //                 console.log(response);
    //                 $("#search-product-mobile").html(response.data.html);
    //             },
    //         });
    //     }, 300);
    // });

    // js search product wishlist
    $(document).on("change", ".monaFilterJS-input-wishlist", function(e) {
        var val = $(this).val();
        // console.log(val);
        var formdata = $(this).closest("form").serialize();
        $.ajax({
            url: mona_ajax_url.ajaxURL,
            type: "post",
            data: {
                action: "mona_ajax_wishlist_product",
                val: val,
                formdata: formdata,
            },
            success: function(response) {
                console.log(response);
                $("#wishlist-container").html(response.data.html);
            },
        });
    });

    // js search category HEADER (thuong hieu)
    $(document).on("input", ".monaFilterJS-header", function(e) {
        e.preventDefault();
        var val = $(this).val();
        let boxLoading_1 = $(this).closest(".word-it").find(".is-loading-group");
        console.log(val);
        var formdata = $(this).closest("form").serialize();

        $.ajax({
            url: mona_ajax_url.ajaxURL,
            type: "post",
            data: {
                action: "mona_ajax_search_category_header",
                val: val,
                // formdata: formdata,
            },
            beforeSend: function() {
                boxLoading_1.addClass("processing");
                console.log("Hello");
            },
            success: function(response) {
                boxLoading_1.removeClass("processing");
                console.log(response);
                $("#header-cat").html(response.data.html);
            },
        });
    });

    $(document).ready(function() {
        $("#formPostAjax").keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
    $(document).on("submit", "#formPostAjax", function(e) {
        var $this = $(this);
        var formdata = $this.serialize();
        var processing = $this.find(".monaPostsList");
        var layout = $this.data("layout");
        getPostListPaged(true, $this, formdata, processing, layout);
    });

    $(document).on("change", ".monaFilterJS", function(e) {
        var $this = $(this).closest("form");
        var layout = $this.data("layout");
        var formdata = $(this).closest("form").serialize();
        var processing = $(this).closest("form").find(".monaPostsList");
        getPostListPaged(false, $this, formdata, processing, layout);
    });

    $(document).on("click", ".monaClickPostAjax", function(e) {
        var $this = $(this).closest("form");
        var layout = $this.data("layout");
        var formdata = $(this).closest("form").serialize();
        var processing = $(this).closest("form").find(".monaPostsList");
        getPostListPaged(false, $this, formdata, processing, layout);
    });
    $(document).on(
        "click",
        ".pagination-posts-ajax a.page-numbers",
        function(e) {
            e.preventDefault();
            var $this = $(this);
            var form = $this.closest("form");
            var pagination = $this.closest(".pagination-posts-ajax");
            var pagedText = $this.text();
            var paged = pagedText.match(/\d+/);
            if (!paged) {
                if (!$this.hasClass("next")) {
                    var pagedCurrentText = parseInt(
                        pagination.find(".page-numbers.current").text()
                    );
                    var paged = pagedCurrentText - 1;
                } else {
                    var pagedCurrentText = parseInt(
                        pagination.find(".page-numbers.current").text()
                    );
                    var paged = pagedCurrentText + 1;
                }
            } else {
                paged = paged[0];
            }
            var formdata = $this.closest("form").serialize();
            var processing = $this.closest(".monaPostsList");
            getPostListPaged(true, form, formdata, processing, "reload", paged);
        }
    );
    $(document).on("click", ".monaLoadMoreJS", function(e) {
        e.preventDefault();
        var $this = $(this);
        var paged = $this.data("paged");
        var form = $this.closest("form");
        var formdata = $this.closest("form").serialize();
        getPostListPaged(true, form, formdata, $this, "loadmore", paged);
    });
}