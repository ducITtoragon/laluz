export default function HandleQuantity(){
    // var amounts = document.querySelectorAll('.count-number');
    // amounts.forEach((amount)=>{
    //     var amountValue = parseInt(amount.textContent);
    //     var btnMinus = document.querySelectorAll('.minus');
    //     var btnPlus = document.querySelectorAll('.plus');


    //     function render(amountValue){
    //         amount.textContent = amountValue;
    //     }

    //     btnMinus.forEach((minus)=>{
    //         minus.addEventListener('click',()=>{
    //             if(amountValue > 1){
    //                 amountValue--;
    //                 render(amountValue);
    //             }
    //         })
    //     })

    //     btnPlus.forEach((plus)=>{
    //         plus.addEventListener('click',()=>{
    //             amountValue++;
    //             render(amountValue);
    //         })
    //     })

    //     amount.addEventListener('input', ()=>{
    //         var amountValue = amount.value;
    //         var amountValue = parseInt(amountValue);
    //         var amountValue = (isNaN(amountValue) || amountValue < 0) ? 1 : amountValue;
    //         render(amountValue);
    //     })
    // })
    var event = new Event("change");
    const count = document.querySelectorAll('.box-quantity')
    if (count) {
        count.forEach(item => {
            const input = item.querySelector('.ip-value');
            const number = item.querySelector('.number-change');
            number.innerHTML = `${input.value < 10 && input.value > 0 ? "0" : " "}` + input.value;
        })
    }
    document.addEventListener('click', (e) => {

        const count = e.target.closest('.box-quantity');
        const countBtnPlus = e.target.closest('.plus')
        const countBtnMinus = e.target.closest('.minus');
        if (count) {
            const countNumber = count.querySelector('.number-change');
            const countInput = count.querySelector('.ip-value');    
            if (countBtnPlus) {
                if (parseInt(countInput.value) < parseInt(countInput.max)) {
                    countInput.value++;
                    countNumber.innerHTML =
                        `${countInput.value < 10 && countInput.value > 0 ? "0" : " "}` + countInput.value;
                    $("[name='update_cart']").removeAttr('disabled');
                    $("[name='update_cart']").trigger("click");
                    countInput.dispatchEvent(event);
                }
            }
            if (countBtnMinus) {
                if (parseInt(countInput.value) > parseInt(countInput.min)) {
                    countInput.value--;
                    countNumber.innerHTML =
                        `${countInput.value < 10 && countInput.value > 0 ? "0" : " "}` + countInput.value;
                    $("[name='update_cart']").removeAttr('disabled');
                    $("[name='update_cart']").trigger("click");
                    countInput.dispatchEvent(event);
                }
            }
        }
    })

}