export default function addFavo(){
    const heart = document.querySelector('.add-favo');
    const heart_txt = document.querySelector('.add-favo .txt');
    if(heart) {
        heart.addEventListener('click',()=>{
            heart.classList.toggle('active-cl')
            const activeCl = document.querySelector('.active-cl');
            if(activeCl){
                heart_txt.innerText = 'Đã yêu thích' ;
            }
            else{
                heart_txt.innerText = 'Thêm vào yêu thích'; 
            }
        })
    }
}