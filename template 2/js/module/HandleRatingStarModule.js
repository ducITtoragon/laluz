export default function HandleRatingStarModule(){
    var stars = document.querySelectorAll(".rvw-stars .stars li i");
    var num_star = document.querySelector('.total-stars .num');
    stars.forEach((item, index1) =>{
        item.addEventListener("click", ()=>{
            num_star.innerText = index1 + 1;
            stars.forEach((star, index2) =>{
                index1 >= index2 ? star.classList.add("active") :
                star.classList.remove("active");
            })
        })
    })
}