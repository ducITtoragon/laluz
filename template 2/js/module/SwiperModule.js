export default function SwiperModule() {
    const productCt = document.querySelector(".prod-dt");
    if (productCt) {
        var swiperBottom = new Swiper(productCt.querySelector(".mySwiperBottom"), {
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
    });
    var swiperTop = new Swiper(productCt.querySelector(".mySwiperTop"), {
        slidesPerView: 1,
        spaceBetween: 12,
        speed: 1200,
        navigation: {
            nextEl: productCt.querySelector(".next"),
            prevEl: productCt.querySelector(".prev"),
        },
        thumbs: {
            swiper: swiperBottom,
        },
    });
}



    const itemProd = document.querySelector(".swiper-prod");
    if(itemProd){
        var swiper = new Swiper(itemProd,{
            slidesPerView: 5,
            centeredSlides: false,
            spaceBetween: 12,
            loop: false,
            speed: 600,
            navigation: {
                nextEl: itemProd.querySelector(".next"),
                prevEl: itemProd.querySelector(".prev"),
            },
            breakpoints: {
                280: {
                    slidesPerView: 1,
                },
                375: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 5,
                }
            }
        });
    }



    const prodHomeMale = document.querySelector(".swiper-prod-home.male ");
    if(prodHomeMale){
        var swiper = new Swiper(prodHomeMale, {
            centeredSlides: false,
            spaceBetween: 24,
            loop: false,
            speed: 800,
            autoplay : true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                280: {
                    slidesPerView: 1,
                },
                375: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 5,
                }
            }
        });
    }

    const prodHomeFemale = document.querySelector(".swiper-prod-home.female ");
    if(prodHomeFemale){
        var swiper = new Swiper(prodHomeFemale, {
            centeredSlides: false,
            spaceBetween: 24,
            loop: false,
            speed: 800,
            autoplay : true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                280: {
                    slidesPerView: 1,
                },
                375: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 5,
                }
            }
        });
    }

    const prodHomeUnisex = document.querySelector(".swiper-prod-home.unisex ");
    if(prodHomeUnisex){
        var swiper = new Swiper(prodHomeUnisex, {
            centeredSlides: false,
            spaceBetween: 24,
            loop: false,
            speed: 800,
            autoplay : true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                280: {
                    slidesPerView: 1,
                },
                375: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 5,
                }
            }
        });
    }

    const studio = document.querySelector(".swiper-studio");
    if(studio){
        var swiper = new Swiper(studio, {
            centeredSlides: false,
            spaceBetween: 12,
            loop: false,
            speed: 800,
            autoplay : true,
            breakpoints: {
                280: {
                    slidesPerView: 1,
                },
                375: {
                    slidesPerView: 2,
                },
                575: {
                    slidesPerView: 2,
                },   
                768: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 5,
                }
            }
        });
    }
}