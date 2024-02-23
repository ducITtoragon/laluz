export default function ClickToggleModule(){
    $(document).ready(function(){
        const btn_ham = $('.btn-ham');
        const menu_mb = $('.menu-mb');
        const overlay = $('.overlay');
        const body = $('body');
        const btn_filter = $('.btn-flt')
        const modal_filter = $('.wr-filter')
        const overlay_filter = $('.overlay-filter');
        const tt_filter = $('.form-filter').find('.tt-filter');
        const op_filter = $('.form-filter').find('.filter-list')
        const ic_close_filter = $('.wr-filter .inner').find('.tt-filter .ic-close')
        const menu_mega = $('.menu-mega-mb');
        const tt_menu_mega = $('.menu-mega-mb .menu-mega-item').find('.tt-mg');
        // const menu_it_mb = $('.menu-mb .nav-menu > .menu-list .menu-item .menu-link.dropdown-mb')
        const ic_arrow = $('.menu-mb .nav-menu > .menu-list .menu-item .menu-link').find('.ic-angle');
        const menu_mega_child = $('.menu-mega-item').find('.menu-list');
        const box_info = $('.wr-left .box-info');
        const btn_bars = $('.btn-bars');
        const cart = $('.cart-fixed');
        const btn_cart = $('.hd-cart')
        const close_cart = $('.cart-fixed').find('.ic-close');
        // handle button hambuger
        btn_ham.click(function(){
            $(this).toggleClass('active-btn-ham');
            menu_mb.toggleClass('active-mn-mb');
            overlay.toggleClass('active-overlay');
            body.toggleClass('no-scroll');
        })
        overlay.click(function(){
            $(this).removeClass('active-overlay')
            menu_mb.removeClass('active-mn-mb');
            btn_ham.removeClass('active-btn-ham');
            body.removeClass('no-scroll');
        })
        // end handle button hambuger

        // handle button filter
        btn_filter.click(function(){
            modal_filter.toggleClass('active-filter');
            overlay_filter.toggleClass('active-overlay');
            body.toggleClass('no-scroll');
        })

        overlay_filter.click(function(){
            modal_filter.removeClass('active-filter');
            $(this).removeClass('active-overlay');
            body.removeClass('no-scroll');
        })

        ic_close_filter.click(function(){
            modal_filter.removeClass('active-filter');
            body.removeClass('no-scroll');
            overlay_filter.removeClass('active-overlay');
        })
        // end handle button filter


        // handle filter mobile
        if(window.innerWidth <= 768){
            op_filter.hide();
            tt_filter.each(function(){
                $(this).click(function(){
                    $(this).next().slideToggle();
                    $(this).find('.ic-angle').toggleClass('ic-active')
                })
            })
        }
        // end handle filter mobile

        // handle menu mega mobile
        ic_arrow.each(function(){
            $(this).click(function(e){
                e.preventDefault()
                $(this).toggleClass('ic-active');
                $(this).parent('.menu-link').stop().next().slideToggle();
                $(this).parents('.menu-item').toggleClass('current-menu-mb');
            })
        })
        tt_menu_mega.each(function(){
            $(this).click(function(){
                $(this).next().slideToggle();
                // $(this).next().find('.menu-list').slideToggle();
                $(this).find('.ic-angle').toggleClass('ic-active');
                $(this).toggleClass('current-menu-mb');
            })
        })

        btn_bars.click(function(){
            box_info.toggleClass('show-box-info');
        })

        // show cart
        btn_cart.click(function(e){
            e.preventDefault()
            cart.toggleClass('open');
            overlay.addClass('active-overlay')
            body.addClass('no-scroll');
        })
        close_cart.click(function(){
            cart.removeClass('open')
            overlay.removeClass('active-overlay')
            body.removeClass('no-scroll');
        })
        overlay.click(function(){
            $(this).removeClass('active-overlay')
            cart.removeClass('open');
            body.removeClass('no-scroll');
        })
    })
}