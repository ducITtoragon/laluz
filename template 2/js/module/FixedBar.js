export default function FixedBar(){
    try {
        const scrollTop = document.querySelector(".back-to-top");
    
        if (scrollTop) {
            scrollTop.addEventListener("click", () => {
            document.body.scrollIntoView({ behavior: "smooth", block: "start" });
        });
        }
    
        // const menuListLink = document.querySelector(".fixed-nav");
        // window.addEventListener("scroll", () => {
        //     if (menuListLink) {
        //     if (window.scrollY > 10) {
        //         menuListLink.classList.add("active");
        //     } else {
        //         menuListLink.classList.remove("active");
        //     }
        //     }
        // });
        } catch (error) {
        console.log(error);
        }
}