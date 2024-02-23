export default function seeMoreModule(){
    const prodSect = document.querySelector(".nav-bread");
    if(window.innerWidth <= 768){
        const prodSect = document.querySelector(".prods-sect");
        if(prodSect){
            const parentWrapper = document.querySelector(".prod-intro");
            if (parentWrapper) {
                let heightParent = parentWrapper.clientHeight  ;
            
                parentWrapper.style.height = heightParent / 3 + "px";
            
                const btnSeeMore = document.querySelector(".see-more");
                
                if (btnSeeMore) {
                    const btnExitMore = document.querySelector(".less-more");
                    btnSeeMore.addEventListener("click", () => {
                        btnSeeMore.style.display = "none";
                        btnExitMore.style.display = "flex";
                        parentWrapper.style.height = heightParent + "px";
                        parentWrapper.classList.add("hiddenPost");
                    });
                }
            
                const btnExitMore = document.querySelector(".less-more");
                btnExitMore.style.display = "none";   
                if (btnExitMore) {
                    const btnSeeMore = document.querySelector(".see-more");
                    
                    btnExitMore.addEventListener("click", () => {
                        btnSeeMore.style.display = "flex";
                        btnExitMore.style.display = "none";
                        parentWrapper.style.height = heightParent / 3 + "px";
                        parentWrapper.classList.remove("hiddenPost");
                    });
                }
            } 
        }
    }
    else{
        const prodSect = document.querySelector(".prods-sect");
        if(prodSect){
            const parentWrapper = document.querySelector(".prod-intro");
            if (parentWrapper) {
                let heightParent = parentWrapper.clientHeight  ;
            
                parentWrapper.style.height = heightParent / 2 + "px";
            
                const btnSeeMore = document.querySelector(".see-more");
                
                if (btnSeeMore) {
                    const btnExitMore = document.querySelector(".less-more");
                    btnSeeMore.addEventListener("click", () => {
                        btnSeeMore.style.display = "none";
                        btnExitMore.style.display = "flex";
                        parentWrapper.style.height = heightParent + "px";
                        parentWrapper.classList.add("hiddenPost");
                    });
                }
            
                const btnExitMore = document.querySelector(".less-more");
                btnExitMore.style.display = "none";   
                if (btnExitMore) {
                    const btnSeeMore = document.querySelector(".see-more");
                    
                    btnExitMore.addEventListener("click", () => {
                        btnSeeMore.style.display = "flex";
                        btnExitMore.style.display = "none";
                        parentWrapper.style.height = heightParent / 2 + "px";
                        parentWrapper.classList.remove("hiddenPost");
                    });
                }
            } 
        }
    }
}