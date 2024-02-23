export default function ShowBoxSearchMb(){
    const icSeach = document.querySelector('.hd-mid-right-it .ic-search img');
    const search_mb = document.querySelector('.searchFixed')
    
    if(icSeach){
        icSeach.onclick = ()=>{
            search_mb.classList.toggle('dropdown-search-fixed');
        }
    }
}