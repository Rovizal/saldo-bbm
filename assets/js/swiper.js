const swiperHome = new Swiper(".swiperHome", {
  // Optional parameters
  loop: false,
  slidesPerView: 1.1,
  spaceBetween: 10,
  grabCursor: true,
  // centeredSlides: true,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
    dynamicBullets: true,
  },

  // Navigation arrows
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },

  // if your need responsive
  breakpoints: {
    575: {
      slidesPerView: 2.5,
    },
    992: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
  },
});

// swiper for section testi
const swiperTesti = new Swiper(".swiperTesti", {
  // Optional parameters
  loop: false,
  speed: 1000,
  spaceBetween: 10,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
  },

  // if we need effect
  grabCursor: true,
  effect: "creative",
  creativeEffect: {
    prev: {
      shadow: true,
      translate: [0, 0, -400],
    },
    next: {
      translate: ["100%", 0, 0],
    },
  },

  // Navigation arrows
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },
});

// swiper for section partnership
const swiperPartner = new Swiper(".swiperPartner", {
  // Optional parameters
  loop: true,
  spaceBetween: 10,
  slidesPerView: 4,
  speed: 1000,
  grabCursor: true,
  slidesPerGroup: 4,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
    dynamicBullets: true,
  },

  // if need autoplay
  autoplay: {
    delay: 3000,
  },

  // Navigation arrows
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },

  // if your need responsive
  breakpoints: {
    767: {
      slidesPerView: 4,
      spaceBetween: 50,
    },
  },

  // show curent condition
  on: {
    slideChange: function () {
      var currentSlide = this.realIndex + 1;
      // console.log("currentSlide is:" + currentSlide);

      if (currentSlide >= 6 && currentSlide <= 5) {
        $(".text-partner").html($(".text-thankyou").html());
      } else if (currentSlide == 21 || currentSlide == 25) {
        $(".text-partner").html($(".text-thankyou").html());
      } else {
        $(".text-partner").html($(".text-happy").html());
      }
    },
    beforeInit: function () {
      let numOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide").length;
      // document.querySelector('.total-slides').innerHTML = numOfSlides;
    },
  },
});

// swiper for investor
const swiperForInvestor = new Swiper(".swiperForInvestor", {
  // Optional parameters
  loop: true,
  speed: 1000,
  slidesPerView: 1.5,
  spaceBetween: 20,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
  },

  // if we need effect
  grabCursor: true,

  // if your need responsive
  breakpoints: {
    767: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
  },

  // if you need autoplay
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },

  // Navigation arrows
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },
});
// /swiper for investor

// swiper for Esdg
const swiperForEsdg = new Swiper(".swiperForEsdg", {
  // Optional parameters
  loop: true,
  speed: 800,
  slidesPerView: 1,
  spaceBetween: 20,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
    dynamicBullets: true,
    clickable: true,
  },

  // if we need effect
  grabCursor: true,

  effect: "fade",

  // if you need autoplay
  autoplay: {
    delay: 6000,
    disableOnInteraction: false,
  },

  // if your need responsive
  breakpoints: {
    767: {
      slidesPerView: 1,
      spaceBetween: 30,
    },
  },

  // Navigation arrows
  navigation: {
    // nextEl: '.swiper-button-next',
    // prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },
});
// swiper for Esdg

// swiper for Esdg
const swiperForChildEsdg = new Swiper(".swiperForChildEsdg", {
  // Optional parameters
  loop: false,
  speed: 500,
  slidesPerView: 1,
  // centeredSlides: true,

  // If we need pagination
  pagination: {
    el: ".swiper-pagination",
  },

  // if we need effect
  // grabCursor: false,

  // if you need autoplay
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },

  // if your need responsive
  breakpoints: {
    767: {
      slidesPerView: 4,
      spaceBetween: 0,
    },
  },

  // Navigation arrows
  navigation: {
    // nextEl: '.swiper-button-next',
    // prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: ".swiper-scrollbar",
  },
});
// swiper for Esdg

// swiper for join team invvestor
const swiperForJoin1 = new Swiper(".swiperForJoin1", {
  speed: 24000,
  loop: true,
  spaceBetween: 0,
  grabCursor: false,
  slidesPerView: 1.2,
  spaceBetween: 15,
  slidesPerGroup: 3,
  // freeMode: true,
  // freeModeMomentum: false,

  autoplay: {
    delay: 0,
    disableOnInteraction: false,
  },

  // if your need responsive
  breakpoints: {
    992: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    768: {
      slidesPerView: 2.2,
    },
  },
});
// /swiper for join team invvestor

const swiperForJoin2 = new Swiper(".swiperForJoin2", {
  speed: 24000,
  slidesPerGroup: 3,
  loop: true,
  // loopedSlides: 1,
  // allowTouchMove: true,
  // freeMode: false,
  // freeModeMomentum: false,
  grabCursor: false,
  slidesPerView: 1.2,
  spaceBetween: 15,

  autoplay: {
    delay: 0,
    reverseDirection: true,
    disableOnInteraction: false,
  },

  // if your need responsive
  breakpoints: {
    992: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    768: {
      slidesPerView: 2.2,
    },
  },
});
