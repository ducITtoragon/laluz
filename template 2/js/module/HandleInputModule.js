export default function HandleInputModule(){
    // $(document).ready(function(){
    //     const box_search = $('.box-search').find('input');
    //     const plc_search = $('.box-search').find('.plc-input');

    //     box_search.on('input', function(){
    //         if($(this).val() != ''){
    //             plc_search.hide();
    //         }
    //         else{
    //             plc_search.show();
    //         }
    //     })
    // })

    const box_searchs = document.querySelectorAll('.boxSearch input');
    const box_results = document.querySelectorAll('.boxResult');
    box_searchs.forEach((box_search)=>{
        box_results.forEach(( box_result)=>{
            box_search.addEventListener('focus', ()=>{
                box_result.classList.add('active-box-result');
            })
            box_search.addEventListener('blur', ()=>{
                box_result.classList.remove('active-box-result');
            })
        })
    })

    const box_searchs_mb = document.querySelector('.search-mb input')
    const box_results_mb = document.querySelector('.search-mb .boxResult')
    box_searchs_mb.addEventListener('focus', ()=>{
        box_results_mb.classList.add('active-box-result');
    })
    box_searchs_mb.addEventListener('blur', ()=>{
        box_results_mb.classList.remove('active-box-result');
    })



}