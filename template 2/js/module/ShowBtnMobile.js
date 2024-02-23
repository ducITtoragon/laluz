export default function ShowBtnMobile(){
    const btn_mb = document.querySelector('.btn-list.btn-list-mb');
    const btn_default = document.querySelector('.btn-list');
    const footer = document.querySelector('.footer');
    if(btn_mb){
        window.onscroll = ()=>{
            if(window.scrollY >= btn_default.offsetTop && (window.scrollY + window.innerHeight) <= footer.offsetTop){
                btn_mb.classList.add('active-btn-mb');
            }
            else{
                btn_mb.classList.remove('active-btn-mb');
            }
        }
    }
}