export default function HandleScroll(){
    window.addEventListener('scroll', ()=>{
        hideHeader();
    })

    function hideHeader(){
        const hd = document.querySelector('.header');
        const main = document.querySelector('.main');
        if(window.scrollY > 10){
            hd.classList.add('active-hd')
            main.classList.add('spc-hd-2')
            main.classList.add('spc-hd-3')
            main.classList.add('spc-hd-4')
        }
        else{
            hd.classList.remove('active-hd');
            main.classList.remove('spc-hd-2')
            main.classList.remove('spc-hd-3')
            main.classList.remove('spc-hd-4')
        }
    }
}