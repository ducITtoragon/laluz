export default function TabModule() {

    let tab = document.querySelectorAll('.tabJS');
    if (tab) {
        tab.forEach((t) => {
            let tBtn = t.querySelectorAll('.tabBtn');
            let tPanel = t.querySelectorAll('.tabPanel');

            // for tab
            if (tBtn.length !== 0 && tPanel.length === tBtn.length) {
                tBtn[0].classList.add('active');
                tBtn[0].classList.add('current-tab');
                // tPanel[0].classList.add('open');
                $(tPanel).slideUp();
                $(tPanel[0]).slideDown();

                for (let i = 0; i < tBtn.length; i++) {
                    tBtn[i].addEventListener('click', showPanel);

                    function showPanel(e) {
                        e.preventDefault();
                        for (let a = 0; a < tBtn.length; a++) {
                            tBtn[a].classList.remove('active');
                            tBtn[a].classList.remove('current-tab');
                            // tPanel[a].classList.remove('open');
                            $(tPanel[a]).slideUp(600);

                        }
                        tBtn[i].classList.add('active');
                        tBtn[i].classList.add('current-tab');
                        // tPanel[i].classList.add('open');
                        $(tPanel[i]).slideDown(600);

                    }
                }
            }
        });
    }


    $(document).ready(function(){
        // $('.brand-list:first-child').addClass('active');
        var tabID = $('.word-it:first-child').attr('data-tab');     
        $('#tab-'+tabID).addClass('active')
        $('.word-it').each(function(){
            $(this).click( function() {  
                var tabID = $(this).attr('data-tab');     
                console.log(tabID);
                $(this).addClass('active').siblings().removeClass('active'); 
                $('#tab-'+tabID).addClass('active').siblings().removeClass('active');
            });
        })
    })

}