document.addEventListener('DOMContentLoaded', function () {

  const burgerMenu = () => {
    const burger = document.querySelector(`.js-burger`);
    if (!burger) return;
    const close = document.querySelector(`.js-close`);
    if (!close) return;
    const menu = document.querySelector(`.js-nav`);
    const header = document.querySelector(`.header`);

    burger.addEventListener(`click`, () => {
      menu.classList.add(`header__nav--open`);
      header.classList.add(`header--open`);
    });

    close.addEventListener(`click`, (evt) => {
      evt.preventDefault();
      menu.classList.remove(`header__nav--open`);
      header.classList.remove(`header--open`);
    });

  }
  burgerMenu();

  const reviewsSlider = new Swiper('.js-reviews__slider', {
    slidesPerView: 2,
    // centeredSlides: true,
    wrapperClass: 'js-wrapper',
    slideClass: 'slide-review',

    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {

        return `<span>${current}</span><span>/</span><span>${total}</span>`;

      }
    },
    breakpoints: {
      0: {
        spaceBetween: 27,
        navigation: {
          prevEl: '.pagination__prew',
          nextEl: '.pagination__next',
        },
      },
      768: {
        spaceBetween: 45,
        navigation: {
          prevEl: '.slider-reviews__prew',
          nextEl: '.slider-reviews__next',
        },
      }
    },


  });

  const sliderReviewsBig = new Swiper('.js-slider-reviews-big', {
    slidesPerView: 1,
    centeredSlides: true,
    wrapperClass: 'page-review__block',
    slideClass: 'slide-review',
    slideActiveClass: 'active',

    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {

        return `<span>${current}</span><span>/</span><span>${total}</span>`;

      }
    },
    navigation: {
      prevEl: '.pagination__prew',
      nextEl: '.pagination__next',
    },


  });

  const sliderBoolets = new Swiper('.js-slider-boolets', {
    watchSlidesProgress: true,
    slidesPerView: 5,
    direction: "vertical",
    wrapperClass: 'js-slider-wrapper',
    slideClass: 'js-slide',

  });

  const sliderHistory = new Swiper('.js-slider-history', {
    wrapperClass: 'js-wrapper',
    slideClass: 'js-slide',
    navigation: {
      prevEl: '.js-prev',
      nextEl: '.js-next',
    },
    thumbs: {
      swiper: sliderBoolets,
    },

  });

  const sliderPortfolio = new Swiper('.js-slider-portfolio', {
    grid: {
      rows: 2,
    },

    slidesPerView: 1,
    wrapperClass: 'js-wrapper',
    slideClass: 'js-slide',
    navigation: {
      prevEl: '.pagination__prew',
      nextEl: '.pagination__next',
    },
    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {

        return `<span>${current}</span><span>/</span><span>${total}</span>`;

      }
    },
    breakpoints: {
      0: {
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 1,
        spaceBetween: 131,
        grid: {
          rows: 1,
        },
        navigation: {
          prevEl: '.js-prev',
          nextEl: '.js-next',
        },
      }
    },
  });

  const sliderCommand = new Swiper('.js-slider-command', {
    loop: true,
    wrapperClass: 'js-wrapper',
    slideClass: 'js-slide',
    centeredSlides: true,
    slideActiveClass: 'active',
    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {

        return `<span>${current}</span><span>/</span><span>${total}</span>`;

      }
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
        initialSlide: 1,
        navigation: {
          prevEl: '.pagination__prew',
          nextEl: '.pagination__next',
        },
      },

      768: {
        initialSlide: 2,
        slidesPerView: 3,
        navigation: {
          prevEl: '.js-prev',
          nextEl: '.js-next',
        },
      }
    },
  });

  const openFilter = () => {
    const openFilters = document.querySelectorAll(`.js-filter-open`);
    openFilters.forEach(el => {
      el.addEventListener(`click`, (evt) => {
        evt.preventDefault();
        const btn = evt.target.closest(`.js-filter-open`);
        const list = btn.nextSibling.nextSibling;

        list.classList.toggle(`disable`)

      })
    })
  }

  openFilter();

  const articleSlider = new Swiper('.js-article-slider', {
    slidesPerView: "auto",

    wrapperClass: 'js-wrapper',
    slideClass: 'js-slide',
    slideActiveClass: 'active',

    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {
        return `<span>${current}</span><span>/</span><span>${total}</span>`;
      }
    },
    breakpoints: {
      0: {
        centeredSlides: true,
        loop: true,
        spaceBetween: 30,
        navigation: {
          prevEl: '.pagination__prew',
          nextEl: '.pagination__next',
        },
      },
      768: {
        spaceBetween: 63,
        slidesPerView: 4,
        centeredSlides: false,
        navigation: {
          prevEl: '.article-slider__prev',
          nextEl: '.article-slider__next',
        },
      }
    },
  });
  const articleOtherSlider = new Swiper('.js-article-other-slider', {
    slidesPerView: "auto",
    loop: true,
    wrapperClass: 'js-wrapper',
    slideClass: 'banquet',
    slideActiveClass: 'active',

    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {
        return `<span>${current}</span><span>/</span><span>${total}</span>`;
      }
    },
    breakpoints: {
      0: {
        slidesPerView: 2,
        loop: true,
        spaceBetween: 30,
        // grid: {
        //   rows: 2,
        // },
        navigation: {
          prevEl: '.pagination__prew',
          nextEl: '.pagination__next',
        },
      },
      768: {
        spaceBetween: 5,
        slidesPerView: 4,
        centeredSlides: false,
        navigation: {
          prevEl: '.article-other__prev',
          nextEl: '.article-other__next',
        },
      }
    },
  });


  const jsOurPhotos = new Swiper('.js-our-photos', {

    loop: true,

    wrapperClass: 'js-wrapper',
    slideClass: 'js-slide',
    slideActiveClass: 'active',

    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {
        return `<span>${current}</span><span>/</span><span>${total}</span>`;
      }
    },

    breakpoints: {
      0: {
        centeredSlides: true,
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
          prevEl: '.pagination__prew',
          nextEl: '.pagination__next',
        },
      },
      768: {
        spaceBetween: 0,
        slidesPerView: 2,

        navigation: {
          prevEl: '.our-photos__prev',
          nextEl: '.our-photos__next',
        },
      }
    },
  });


  const filtersPortgolioOpenDots = () => {
    const btns = document.querySelectorAll(`.js-filters-btns`);

    if (!btns[0]) return;
    btns.forEach(btn => {
      btn.addEventListener(`click`, () => {
        const fieldset = btn.closest(`fieldset`).classList.toggle(`active`);
      })
    })
  }

  filtersPortgolioOpenDots();


  const sliderVideo = new Swiper('.js-slider-video', {

    loop: true,
    slidesPerView: 3,

    wrapperClass: 'js-wrapper',
    slideClass: 'video__slide',
    centeredSlides: true,
    navigation: {
      prevEl: '.pagination__prew',
      nextEl: '.pagination__next',
    },
    pagination: {
      el: ".pagination__fraction",
      type: "fraction",
      renderCustom: function (swiper, current, total) {

        return `<span>${current}</span><span>/</span><span>${total}</span>`;

      }
    },
    breakpoints: {
      0: {
        slidesPerView: 2,
        spaceBetween: 21,
        centeredSlides: false,
      },
      768: {
        centeredSlides: true,
        slidesPerView: 3,
        spaceBetween: 28,
        navigation: {
          prevEl: '.js-prev',
          nextEl: '.js-next',
        },
      }
    },
  });

  const mobileMenuList = () => {
    const buttons = document.querySelectorAll(`.js-btn-list`);
    const nav = document.querySelector(`.js-nav`);
    buttons.forEach(btn => {
      btn.addEventListener(`click`, (evt) => {
        evt.preventDefault();
        if (!evt.target.closest(`li`)) return;

        evt.target.closest(`li`).classList.toggle(`active`);

      })
    })
  }
  mobileMenuList();



  const personalDataSlider = () => {
    const dataSlider = document.querySelector(`.js-personal-data-slider`);
    if (!dataSlider) return;
    const dataSlide = document.querySelector(`.js-personal-data-slide`);
    if (!dataSlide) return;


    const items = dataSlider.querySelectorAll(`li`);
    const slides = dataSlide.querySelectorAll(`.js-personal-data-blocks`);
    const title = document.querySelector(`.js-personal-data-title`);

    items.forEach((item, i) => {
      item.addEventListener(`click`, (evt) => {
        evt.preventDefault();

        title.textContent = item.querySelector(`a`).textContent;

        items.forEach(el => {
          el.classList.remove(`active`);
        })
        slides.forEach(el => {
          el.classList.remove(`active`);
        })

        item.classList.add(`active`);
        slides[i].classList.add(`active`);
        
        
      })
    })    
  }
  personalDataSlider();


  const personalDataMonileBurger = () => {
    const btn = document.querySelector(`.js-personal-data-monile`);
    if (!btn) return;
    const wrapper = document.querySelector(`.js-open-menu`);

    btn.addEventListener(`click`, (evt) => {
      evt.preventDefault();
      wrapper.classList.toggle(`active`);
    });

  }
  personalDataMonileBurger();

  const commonEdit = () => {
    const commonCansel = document.querySelectorAll(`.js-common-cansel`);
    const commonEdit = document.querySelectorAll(`.js-common-edit`);

    if (!commonCansel[0]) return;
    if (!commonEdit[0]) return;

    const linkClick = (links) => {
      links.forEach(link => {
        link.addEventListener(`click`, (evt) => {
          evt.preventDefault();
          evt.target.closest(`.common__block`).classList.toggle(`edit`);
        })
      })
    }
    linkClick(commonCansel);
    linkClick(commonEdit);

  }

  commonEdit();



  const html = document.querySelector(`html`);
  const popup_close = document.querySelectorAll(`.popup__close`);
  const popups = document.querySelectorAll(`.popup`);
  const open_review_gallery = document.querySelectorAll(`.open_review_gallery`);
  const popup_review_gallery = document.querySelector(`.popup_review_gallery`);

  const popupClose = (links) => {
    links.forEach(link => {
      link.addEventListener(`click`, (evt) => {
        evt.preventDefault();
        popups.forEach((popup) => {
          popup.classList.remove(`active`);
        })
        html.classList.remove(`ofh`);
      })
    })
  }
  popupClose(popup_close);

  const linkClick = (links) => {
    links.forEach(link => {
      link.addEventListener(`click`, (evt) => {
        evt.preventDefault();
        popup_review_gallery.classList.add(`active`);
        html.classList.add(`ofh`);
      })
    })
  }
  linkClick(open_review_gallery);



  const review_gallery_min = new Swiper('.review_gallery_min', {
    watchSlidesProgress: true,
    slidesPerView: 3,
    breakpoints: {
      768: {
        direction: "vertical",
        slidesPerView: 5,
      }
    },
  });

  const review_gallery = new Swiper('.review_gallery', {
    navigation: {
      prevEl: '.pagination__prew',
      nextEl: '.pagination__next',
    },
    thumbs: {
      swiper: review_gallery_min,
    },

  });

});
