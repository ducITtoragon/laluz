export default function FilterHandle(){
    const filterLabelOp = $(".box-op-it").find('label');
    const boxCheckOp = $(".box-op-it").find('input[type=radio]');
    filterLabelOp.each(function(){
        filterLabelOp.click(function(){
            const wasChecked = $(this).find('input[type=radio]').prop('checked');
            boxCheckOp.prop( "checked", false );
            $(this).find('input[type=radio]').prop("checked", (!wasChecked) ? true : false );
        })
    })    

    const filterLabelPoint = $(".point-item").find('label');
    const boxCheckPoint = $(".point-item").find('input[type=radio]');
    filterLabelPoint.each(function(){
        filterLabelPoint.click(function(){
            const wasChecked = $(this).find('input[type=radio]').prop('checked');
            boxCheckPoint.prop( "checked", false );
            $(this).find('input[type=radio]').prop("checked", (!wasChecked) ? true : false );
        })
    })   

    const filterLabelWord = $(".word-it").find('label');
    const boxCheckWord = $(".word-it").find('input[type=radio]');
    filterLabelWord.each(function(){
        filterLabelWord.click(function(){
            const wasChecked = $(this).find('input[type=radio]').prop('checked');
            boxCheckWord.prop( "checked", false );
            $(this).find('input[type=radio]').prop("checked", (!wasChecked) ? true : false );
        })
    })    
}