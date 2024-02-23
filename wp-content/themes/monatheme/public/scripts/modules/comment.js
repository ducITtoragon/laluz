import { Noti } from "./global.js";

export default function MonaCreateModuleComment() {

    jQuery(document).ready(function($) {
        var imgUpload = document.getElementById('upload_imgs'),
            imgPreview = document.getElementById('img_preview'),
            totalFiles, previewTitle, previewTitleText, img;
        if( imgUpload ){
            imgUpload.addEventListener('change', previewImgs, false);
        }
        function previewImgs(event) {
    
            imgPreview.innerHTML = '';
            totalFiles = imgUpload.files.length;
    
            if (!!totalFiles) {
                imgPreview.classList.remove('mona-hidden');
                previewTitle = document.createElement('p');
                previewTitle.style.fontWeight = 'bold';
                previewTitleText = document.createTextNode(totalFiles + ' ảnh được chọn');
                previewTitle.appendChild(previewTitleText);
                imgPreview.appendChild(previewTitle);
                imgPreview.classList.add('mona-preview');
            }
    
            for (var i = 0; i < totalFiles; i++) {
                img = document.createElement('img');
                img.src = URL.createObjectURL(event.target.files[i]);
                img.classList.add('mona-preview-thumb');
                imgPreview.appendChild(img);
            }
        }
    });

    $(document).on('submit', '#commentform', function(e) {
        e.preventDefault();
        var form = $('#commentform')[0];
        var form_data = new FormData(form);
        form_data.append('action', 'mona_ajax_user_comments');
        var loading = $(this).closest('#formProductRating');
        if (!loading.hasClass('loading')) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: 'post',
                contentType: false,
                processData: false,
                data: form_data,
                error: function(request) {
                    loading.removeClass('loading');
                },
                beforeSend: function(response) {
                    loading.addClass('loading');
                },
                success: function(result) {
                    if (result.success) {
                        
                        $("#commentform")[0].reset();
                        $('#img_preview').html('');
                        $('#img_preview').addClass('mona-hidden');
                        $('.comment-form-rating .stars').removeClass('selected');
                        Noti({
                            text: result.data.message,
                            title: result.data.title,
                            icon: 'success',
                            timer: 5000
                        })

                    } else {

                        Noti({
                            text: result.data.message,
                            title: result.data.title,
                            icon: 'error',
                            timer: 5000
                        })

                    }
                    loading.removeClass('loading');
                }
            });
        }
    });

    $(document).on('click', '.mona-pagination-comments a.page-numbers', function (e) {
        e.preventDefault();
        var $this = $(this);
        var pagination = $this.closest('.mona-pagination-comments');
        var pagedText = $this.text();
        var paged = pagedText.match(/\d+/);
        if (!paged) {
            if (!$this.hasClass('next')) {
                var pagedCurrentText = parseInt(pagination.find('.page-numbers.current').text());
                var paged = pagedCurrentText - 1;
            } else {
                var pagedCurrentText = parseInt(pagination.find('.page-numbers.current').text());
                var paged = pagedCurrentText + 1;
            }
        } else {
            paged = paged[0];
        }
        var form = $this.closest('form')[0];
        var form_data = new FormData(form);
        form_data.append('action', 'mona_ajax_pagination_comments');
        form_data.append('paged', paged);
        var loading = $this.closest('form');
        if ( !loading.hasClass('loading') ) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: 'post',
                contentType: false,
                processData: false,
                data: form_data,
                error: function(request) {
                    loading.removeClass('loading');
                },
                beforeSend: function(response) {
                    loading.addClass('loading');
                },
                success: function(result) {
                    if (result.success) {
                        
                        if( result.data.comment_list != '' ){
                            $('.rvw-cmt-list').html( result.data.comment_list );
                        }
                        if( result.data.comment_pagination != '' ){
                            pagination.html( result.data.comment_pagination );
                        }
                        Noti({
                            text: result.data.message,
                            title: result.data.title,
                            icon: 'success',
                            timer: 5000
                        });

                    } else {

                        Noti({
                            text: result.data.message,
                            title: result.data.title,
                            icon: 'error',
                            timer: 5000
                        });

                    }
                    loading.removeClass('loading');
                }
            });
        }
    });

    $(document).on('change', '.mona-rating-filter input', function (e) {
        var $this = $(this);
        var paged = 1;
        var form = $this.closest('form')[0];
        var form_data = new FormData(form);
        form_data.append('action', 'mona_ajax_pagination_comments');
        form_data.append('paged', paged);
        var loading = $this.closest('form');
        if ( !loading.hasClass('loading') ) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: 'post',
                contentType: false,
                processData: false,
                data: form_data,
                error: function(request) {
                    loading.removeClass('loading');
                },
                beforeSend: function(response) {
                    loading.addClass('loading');
                },
                success: function(result) {
                    if (result.success) {
                        
                        if( result.data.comment_list != '' ){
                            $('.rvw-cmt-list').html( result.data.comment_list );
                        }
                        $('.mona-pagination-comments').html( result.data.comment_pagination );
                        Noti({
                            text: result.data.message,
                            title: result.data.title,
                            icon: 'success',
                            timer: 5000
                        });

                    } else {

                        Noti({
                            text: result.data.message,
                            title: result.data.title,
                            icon: 'error',
                            timer: 5000
                        });

                    }
                    loading.removeClass('loading');
                }
            });
        }
    });
}