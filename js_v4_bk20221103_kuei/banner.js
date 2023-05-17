$(function(){

  if($('.bannerStyle01').length){
    var swiper = new Swiper('.bnr_s1', {
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.bnr_s1 .swiper-button-next',
        prevEl: '.bnr_s1 .swiper-button-prev',
      },
    });
    var slideLength = $('.bnr_s1 .swiper-slide').length;
    if (slideLength == 1) {
      $('.bnr_s1 .swiper-button-next, .bnr_s1 .swiper-button-prev').hide();
    }
	}

  if($('.bannerStyle02').length){
    var swiper = new Swiper('.bnr_s2', {
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      effect: 'fade',
      navigation: {
        nextEl: '.bnr_s2 .swiper-button-next',
        prevEl: '.bnr_s2 .swiper-button-prev',
      },
    });
    var slideLength = $('.bnr_s2 .swiper-slide').length;
    if (slideLength == 1) {
      $('.bnr_s2 .swiper-button-next, .bnr_s2 .swiper-button-prev').hide();
    }
	}

  if($('.bannerStyle03').length){
    // Params
    var sliderSelector = '.bnr_s3',
    options = {
      init: false,
      loop: true,
      speed:800,
      slidesPerView: 2, // or 'auto'
      // spaceBetween: 10,
      centeredSlides : true,
      effect: 'coverflow', // 'cube', 'fade', 'coverflow',
      coverflowEffect: {
        rotate: 50, // Slide rotate in degrees
        stretch: 0, // Stretch space between slides (in px)
        depth: 100, // Depth offset in px (slides translate in Z axis)
        modifier: 1, // Effect multipler
        slideShadows : true, // Enables slides shadows
      },
      grabCursor: true,
      parallax: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.bnr_s3 .swiper-button-next',
        prevEl: '.bnr_s3 .swiper-button-prev',
      },
      breakpoints: {
        1023: {
          slidesPerView: 1,
          spaceBetween: 0
        }
      },
      // Events
      on: {
        imagesReady: function(){
          this.el.classList.remove('loading');
        }
      }
    };
    var mySwiper = new Swiper(sliderSelector, options);
    // Initialize slider
    mySwiper.init();
	}

  if($('.bannerStyle04').length){
    var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 10,
      slidesPerView: 4,
      loop: true,
      freeMode: true,
      loopedSlides: 5, //looped slides should be the same
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 10,
      loop:true,
      loopedSlides: 5, //looped slides should be the same
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      thumbs: {
        swiper: galleryThumbs,
      },
    });
	}

  if($('.bannerStyle05').length){
    var swiper = new Swiper('.bnr_s5', {
      speed: 600,
      parallax: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.bnr_s5 .swiper-button-next',
        prevEl: '.bnr_s5 .swiper-button-prev',
      },
    });
	}

  if($('.bannerStyle06').length){
    var sliderSelector = '.bnr_s6',
    isMove = false,
    options = {
      init: false,
      loop: true,
      speed:800,
      autoplay:{
        delay:5000
      },
      effect: 'cube', // 'cube', 'fade', 'coverflow',
      cubeEffect: {
        shadow: true,
        slideShadows: true,
        shadowOffset: 40,
        shadowScale: 0.94,
      },
      grabCursor: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      // Events
      on: {
        init: function(){
          this.autoplay.stop();
        },
        imagesReady: function(){
          this.el.classList.remove('loading');
          this.autoplay.start();
        },
        touchMove: function(event){
          if (!isMove) {
            this.el.classList.remove('scale-in');
            this.el.classList.add('scale-out');
            isMove = true;
          }
        },
        touchEnd: function(event){
          this.el.classList.remove('scale-out');
          this.el.classList.add('scale-in');
          setTimeout(function(){
            isMove = false;
          }, 300);
        },
        slideChangeTransitionStart: function(){
          console.log('slideChangeTransitionStart '+this.activeIndex);
          if (!isMove) {
            this.el.classList.remove('scale-in');
            this.el.classList.add('scale-out');
          }
        },
        slideChangeTransitionEnd: function(){
          console.log('slideChangeTransitionEnd '+this.activeIndex);
          if (!isMove) {
            this.el.classList.remove('scale-out');
            this.el.classList.add('scale-in');
          }
        },
        transitionStart: function(){
          console.log('transitionStart '+this.activeIndex);
        },
        transitionEnd: function(){
          console.log('transitionEnd '+this.activeIndex);
        },
        slideChange:function(){
          console.log('slideChange '+this.activeIndex);
          console.log(this);
        }
      }
    },
    mySwiper = new Swiper(sliderSelector, options);
    // Initialize slider
    mySwiper.init();
	}

  if($('.bannerStyle07').length){
    // Params
    let mainSliderSelector = '.main-slider',
        interleaveOffset = 0.5;
    // Main Slider
    let mainSliderOptions = {
      loop: true,
      speed:1000,
      autoplay:{
        delay:5000
      },
      loopAdditionalSlides: 10,
      grabCursor: true,
      watchSlidesProgress: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      on: {
        init: function(){
          this.autoplay.stop();
        },
        imagesReady: function(){
          this.el.classList.remove('loading');
          this.autoplay.start();
        },
        slideChangeTransitionEnd: function(){
          let swiper = this,
              captions = swiper.el.querySelectorAll('.caption');
          for (let i = 0; i < captions.length; ++i) {
            captions[i].classList.remove('show');
          }
          swiper.slides[swiper.activeIndex].querySelector('.caption').classList.add('show');
        },
        progress: function(){
          let swiper = this;
          for (let i = 0; i < swiper.slides.length; i++) {
            let slideProgress = swiper.slides[i].progress,
                innerOffset = swiper.width * interleaveOffset,
                innerTranslate = slideProgress * innerOffset;
            swiper.slides[i].querySelector(".slide-bgimg").style.transform =
              "translate3d(" + innerTranslate + "px, 0, 0)";
          }
        },
        touchStart: function() {
          let swiper = this;
          for (let i = 0; i < swiper.slides.length; i++) {
            swiper.slides[i].style.transition = "";
          }
        },
        setTransition: function(speed) {
          let swiper = this;
          for (let i = 0; i < swiper.slides.length; i++) {
            swiper.slides[i].style.transition = speed + "ms";
            swiper.slides[i].querySelector(".slide-bgimg").style.transition =
              speed + "ms";
          }
        }
      }
    };
    let mainSlider = new Swiper(mainSliderSelector, mainSliderOptions);
	}

  if($('.bannerStyle08').length){
    // The Slideshow class.
    class Slideshow {
      constructor(el) {
        this.DOM = {el: el};
        this.config = {
          slideshow: {
            delay: 5000,
            pagination: {
              duration: 3,
            }
          }
        };
        // Set the slideshow
        this.init();
      }
      init() {
        var self = this;
        // Charmed title
        this.DOM.slideTitle = this.DOM.el.querySelectorAll('.slide-title');
        this.DOM.slideTitle.forEach((slideTitle) => {
          charming(slideTitle);
        });
        // Set the slider
        this.slideshow = new Swiper (this.DOM.el, {
          loop: true,
          autoplay: {
            delay: this.config.slideshow.delay,
            disableOnInteraction: false,
          },
          speed: 500,
          preloadImages: true,
          updateOnImagesReady: true,
          // lazy: true,
          // preloadImages: false,
          pagination: {
            el: '.slideshow-pagination',
            clickable: true,
            bulletClass: 'slideshow-pagination-item',
            bulletActiveClass: 'active',
            clickableClass: 'slideshow-pagination-clickable',
            modifierClass: 'slideshow-pagination-',
            renderBullet: function (index, className) {
              var slideIndex = index,
              number = (index <= 8) ? '0' + (slideIndex + 1) : (slideIndex + 1);
              var paginationItem = '<span class="slideshow-pagination-item">';
              paginationItem += '<span class="pagination-number">' + number + '</span>';
              paginationItem = (index <= 8) ? paginationItem + '<span class="pagination-separator"><span class="pagination-separator-loader"></span></span>' : paginationItem;
              paginationItem += '</span>';
              return paginationItem;
            },
          },
          // Navigation arrows
          navigation: {
            nextEl: '.slideshow-navigation-button.next',
            prevEl: '.slideshow-navigation-button.prev',
          },
          // And if we need scrollbar
          scrollbar: {
            el: '.swiper-scrollbar',
          },
          on: {
            init: function() {
              self.animate('next');
            },
          }
        });
        // Init/Bind events.
        this.initEvents();
      }
      initEvents() {
          this.slideshow.on('paginationUpdate', (swiper, paginationEl) => this.animatePagination(swiper, paginationEl));
          //this.slideshow.on('paginationRender', (swiper, paginationEl) => this.animatePagination());
          this.slideshow.on('slideNextTransitionStart', () => this.animate('next'));
          this.slideshow.on('slidePrevTransitionStart', () => this.animate('prev'));
      }
      animate(direction = 'next') {
          // Get the active slide
          this.DOM.activeSlide = this.DOM.el.querySelector('.swiper-slide-active'),
          this.DOM.activeSlideImg = this.DOM.activeSlide.querySelector('.slide-image'),
          this.DOM.activeSlideTitle = this.DOM.activeSlide.querySelector('.slide-title'),
          this.DOM.activeSlideTitleLetters = this.DOM.activeSlideTitle.querySelectorAll('span');
          // Reverse if prev
          this.DOM.activeSlideTitleLetters = direction === "next" ? this.DOM.activeSlideTitleLetters : [].slice.call(this.DOM.activeSlideTitleLetters).reverse();
          // Get old slide
          this.DOM.oldSlide = direction === "next" ? this.DOM.el.querySelector('.swiper-slide-prev') : this.DOM.el.querySelector('.swiper-slide-next');
          if (this.DOM.oldSlide) {
            // Get parts
            this.DOM.oldSlideTitle = this.DOM.oldSlide.querySelector('.slide-title'),
            this.DOM.oldSlideTitleLetters = this.DOM.oldSlideTitle.querySelectorAll('span');
            // Animate
            this.DOM.oldSlideTitleLetters.forEach((letter,pos) => {
              TweenMax.to(letter, .3, {
                ease: Quart.easeIn,
                delay: (this.DOM.oldSlideTitleLetters.length-pos-1)*.04,
                y: '50%',
                opacity: 0
              });
            });
          }
          // Animate title
          this.DOM.activeSlideTitleLetters.forEach((letter,pos) => {
  					TweenMax.to(letter, .6, {
  						ease: Back.easeOut,
  						delay: pos*.05,
  						startAt: {y: '50%', opacity: 0},
  						y: '0%',
  						opacity: 1
  					});
  				});
          // Animate background
          TweenMax.to(this.DOM.activeSlideImg, 1.5, {
              ease: Expo.easeOut,
              startAt: {x: direction === 'next' ? 200 : -200},
              x: 0,
          });
          //this.animatePagination()
      }
      animatePagination(swiper, paginationEl) {
        // Animate pagination
        this.DOM.paginationItemsLoader = paginationEl.querySelectorAll('.pagination-separator-loader');
        this.DOM.activePaginationItem = paginationEl.querySelector('.slideshow-pagination-item.active');
        this.DOM.activePaginationItemLoader = this.DOM.activePaginationItem.querySelector('.pagination-separator-loader');
        console.log(swiper.pagination);
        // console.log(swiper.activeIndex);
        // Reset and animate
          TweenMax.set(this.DOM.paginationItemsLoader, {scaleX: 0});
          TweenMax.to(this.DOM.activePaginationItemLoader, this.config.slideshow.pagination.duration, {
            startAt: {scaleX: 0},
            scaleX: 1,
          });
      }
    }
    const slideshow = new Slideshow(document.querySelector('.slideshow'));
	}

  if($('.bannerStyle09').length){
    var windowWidth = $(window).width();
    //Swiper
    var mySwiper = new Swiper ('.bnr_s9', {
     centeredSlides: true,
     loop: true,
     slidesPerView: 3,
     loopedSlides: 5,
     breakpoints: {
      676: {
        slidesPerView: 1
      }
     },
     // Navigation arrows
     navigation: {
        nextEl: '.swiper__buttonblock__right',
        prevEl: '.swiper__buttonblock__left',
     },
   });

   if(windowWidth >676){
     //onhover add class prev-slide
     $('.swiper__buttonblock__left').hover(function(){
        $('.swiper-wrapper').addClass('swiper__hovered__prev');
        $(this).addClass('button__prev__hovered');
     }, function(){
        $('.swiper-wrapper').removeClass('swiper__hovered__prev');
        $(this).removeClass('button__prev__hovered');
     });
     //onhover add class next-slide
     $('.swiper__buttonblock__right').hover(function(){
      $('.swiper-wrapper').addClass('swiper__hovered__next');
      $(this).addClass('button__next__hovered');
     }, function(){
      $('.swiper-wrapper').removeClass('swiper__hovered__next');
      $(this).removeClass('button__next__hovered');
     });
    }
	}

  if($('.bannerStyle10').length){
    var swiper = new Swiper('.bnr_s10', {
      direction: 'vertical',
      slidesPerView: 1,
      spaceBetween: 0,
      mousewheel: {
        sensitivity: 0
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      speed: 900,
      //loop: true,
      on: {
        init: function(){
          $('.swiper-slide-active').addClass('transitioned')
        }
      }
    });

    var previous = swiper.activeIndex;

    swiper.on('slideNextTransitionStart', function() {
      $('.transitioned').addClass('animate-up')
      $('.swiper-slide').removeClass('transitioned');
    })

    swiper.on('slidePrevTransitionStart', function() {
      $('.transitioned').addClass('animate-down')
      $('.swiper-slide').removeClass('transitioned');
    })

    swiper.on('transitionEnd', function() {
      $('.swiper-slide').removeClass('animate-up animate-down')
      $('.swiper-slide-active').addClass('transitioned')
    })
	}

  if($('.bannerStyle11').length){
    var swiper = new Swiper('.bnr_s11', {
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      effect: 'fade',
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
	}

  if($('.headerStyle07').length){
    var swiper = new Swiper('.bnr_head', {
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      effect: 'fade',
      // speed: 500,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      // onSlideClick: video,
    });

    // $('.swiper-slide').each(function(){
  	// 	$(this).YTPlayer();
  	// 	// 判斷第一個是否為影片，是就等他播完再輪播
  	// 	if( $(this).parent().data('normalizeSlideIndex') == 0){
    //     $(".swiper-slide").slick('slickPause');
    //   } else {
    //     $(".swiper-slide").slick('slickPlay');
    //   }
  	// 	$(this).on('YTPEnd' ,function(){
  	// 		$(".swiper-slide").slick('slickNext');
  	// 		$(".swiper-slide").slick('slickPlay');
  	// 	});
  	// })
  	// $('.swiper-slide').on('slidesOffsetBefore', function(event, slick, currentSlide, nextSlide){
  	// 	$('.swiper-slide').each(function(){
  	// 		if($(this).YTPGetPlayer() != null && $(this).YTPGetPlayer() != undefined && $(this).YTPGetPlayer() != ''){
  	// 			$(this).YTPStop();
  	// 		}
  	// 		if( $(this).parent().data('normalizeSlideIndex') == nextSlide){
  	// 			$(".swiper-slide").slick('slickPause');
  	// 			playBannerVideo($(this));
  	// 		} else {
    //       $(".swiper-slide").slick('slickPlay');
    //     }
  	// 	})
  	// });

  }

});

  //banner12採用slick套件
  if($('.bannerStyle12').length){
		$(".bannerStyle12").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
			prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
	    autoplay: true,
      autoplaySpeed: 5000,
		});
	}


$("#bgVideo").YTPlayer({
  videoURL:'http://youtu.be/G1j4w-Nbq84',
  containment: "#bgVideo",
  autoplay: true,
  mute: true,
  startAt: 0,
  opacity: 1,
  showControls: false,
  onReady: function(){
      console.log("Player succesfully initialized");
  },
  onError: function(err){
      console.log("An error ocurred", err);
  }
});
