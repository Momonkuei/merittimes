//setPoint
//if has mbPanel.js then setPoint=mbPanel.js config, else set here
var setPoint = setPoint == undefined ? 786 : setPoint;

var mobileType = mobileViewPoint(setPoint);
function mobileViewPoint(viewPoint) {
	viewPoint = viewPoint > 0 ? viewPoint : 768;
	viewPoint = '(max-width: ' + viewPoint + 'px)';
	viewPoint = window.matchMedia(viewPoint).matches;
	return viewPoint;
}

$(function () {
	// cowboy 20220407 cowboyBlock_8 模組新增
	if ($('.cb8').length) {
		$('.cb8').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			centerMode: true,
			centerPadding: '400px',
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 1500,
					settings: {
						centerPadding: '350px',
					},
				},
				{
					breakpoint: 1200,
					settings: {
						centerPadding: '275px',
					},
				},
				{
					breakpoint: 992,
					settings: {
						centerPadding: '200px',
					},
				},
				{
					breakpoint: 769,
					settings: {
						centerPadding: '26.5%',
					},
				},
				{
					breakpoint: 681,
					settings: {
						centerMode: false,
					},
				},
			],
		});
	}
	// cowboy 20220407 cowboyBlock_8 模組新增 end

	// cowboy 20220324 fix 影音專區 #43894
	if ($('.video').length) {
		$('a[data-url]').click(function (event) {
			var url = $(this).attr('data-url');
			var id = url.split('?v=');
			url = decodeURIComponent(id[1]);

			$('.videoLightboxFix .videoIframe').prepend(
				'<iframe width="560" height="315" src="https://www.youtube.com/embed/' +
				url +
				'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
			);
			$('.videoLightboxFix').addClass('show');
		});

		$('.videoLightboxFix .videoClose').click(function (event) {
			$('.videoLightboxFix .videoIframe').empty();
			$('.videoLightboxFix').removeClass('show');
		});
	}
	// cowboy 20220324 fix 影音專區 #43894 end

	// cowboy 20220107 cowboyBlock_5 模組新增
	if ($('.cowboyBlock_5').length) {
		$('.cb5_slick').slick({
			slidesToShow: 4,
			slidesToScroll: 4,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: false,
			autoplaySpeed: 3000,
			arrows: false,
			dots: true,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
					},
				},
				{
					breakpoint: 576,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
					},
				},
				{
					breakpoint: 481,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
					},
				},
			],
		});
	}
	// cowboy 20220107 cowboyBlock_5 模組新增 end

	// cowboy 20211209 cowboyBlock_1 模組新增
	if ($('#flat').length) {
		var flat = $('#flat').flipster({
			style: 'flat',
			spacing: -0.25,
			loop: true,
		});

		$('.flip-prev').click(function (event) {
			var length = $('.flipster__item').length;
			var index = $('.flipster__item--current').index();

			if (index == 0) {
				$('.flipster__item:nth-child(' + length + ')').click();
			} else {
				$('.flipster__item:nth-child(' + index + ')').click();
			}
		});

		$('.flip-next').click(function (event) {
			var length = $('.flipster__item').length;
			var index = $('.flipster__item--current').index();

			if (index == length - 1) {
				$('.flipster__item:nth-child(1)').click();
			} else {
				index = index + 2;
				$('.flipster__item:nth-child(' + index + ')').click();
			}
		});
	}
	// cowboy 20211209 cowboyBlock_1 模組新增 end

	// cowboy 20211209 cowboyBlock_2 模組新增
	if ($('.year_select').length) {
		$('.year_result table:not(:first-child)').hide();

		$('.year_select select').change(function (event) {
			var year = $(this).val();

			$(this)
				.parent('.year_select')
				.siblings('.year_result')
				.children('table[data-year="' + year + '"]')
				.show();
			$(this)
				.parent('.year_select')
				.siblings('.year_result')
				.children('table:not([data-year="' + year + '"])')
				.hide();
		});
	}
	// cowboy 20211209 cowboyBlock_2 模組新增 end

	//cowboy 購物站產品列表切換
	if ($('.colChange').length) {
		$('.colChange a').click(function (event) {
			var changeto = $(this).data('grid');

			$(this).addClass('active');
			$(this).siblings('a').removeClass('active');

			if (changeto == '3') {
				$('.colChange').siblings('div').removeAttr('class');
				$('.colChange').siblings('div').attr('class', 'col-6 col-sm-4');
				$('.shop_detail').css('display', 'none');
			} else if (changeto == '4') {
				$('.colChange').siblings('div').removeAttr('class');
				$('.colChange')
					.siblings('div')
					.attr('class', 'col-6 col-sm-4 col-md-3');
				$('.shop_detail').css('display', 'none');
			} else {
				$('.colChange').siblings('div').removeAttr('class');
				$('.colChange').siblings('div').attr('class', 'horizontal col-12');
				$('.shop_detail').css('display', '-webkit-box');
			}
		});
	}
	//cowboy 購物站產品列表切換 end

	//cowboy 20210309 productdetail tabs 重製修復版 #38948
	if ($('.productdetail, .shopdetail').length) {
		$(window).on('load', function () {
			if ($('.cowboy_tabList > a').hasClass('active')) {
				var content = $('.cowboy_tabList > a.active').attr('data-content');

				$('.cowboy_theContent[data-content="' + content + '"]').show();
				$('.cowboy_theContent:not([data-content="' + content + '"])').hide();
			} else {
				$('.cowboy_theContent:not([data-content="1"])').hide();
			}
		});

		$('.cowboy_tabList > a').click(function (event) {
			var content = $(this).attr('data-content');

			$(this).addClass('active');
			$(this).siblings('a').removeClass('active');

			$('.cowboy_theContent[data-content="' + content + '"]').show();
			$('.cowboy_theContent:not([data-content="' + content + '"])').hide();
		});
	}
	//cowboy 20210309 productdetail tabs 重製修復版 #38948 end

	//cowboy 20210125 fix classification_menu
	if ($('.classification_menu').length) {
		var search = window.location.search;
		var pathname = window.location.pathname;

		if (pathname.indexOf('about_') > -1) {
			var str = pathname.split('/');
			pathname = decodeURIComponent(str[1]);
		}

		var targetpage = pathname + search;

		$('.classification_menu')
			.find('a[href*="' + targetpage + '"]')
			.parent('li')
			.addClass('active');
	}
	//cowboy 20210125 fix classification_menu end

	//cowboy 20210115 fix sidemenu
	if ($('.menuListStyle_1').length) {
		$('.menuListStyle_1 > li')
			.find('li.active')
			.parent('ul')
			.css('display', 'block');
	}
	//cowboy 20210115 fix sidemenu end

	//cowboy 20200805 new video plugin
	if ($('.video').length) {
		$('.html5-videos').each(function () {
			var galleryID = $(this).attr('id');
			var ary = galleryID.split('html5-videos');
			lightGallery(document.getElementById(galleryID), {
				galleryId: ary[1],
			});
		});

		$('.video-gallery').each(function () {
			var galleryID = $(this).attr('id');
			var ary = galleryID.split('video-gallery');
			lightGallery(document.getElementById(galleryID), {
				galleryId: ary[1],
			});
		});
	}
	//cowboy 20200805 new video plugin end

	// header
	if ($('header').length) {
		if ($(window).width() > 1024) {
			var hdTop = $('header').outerHeight();
			$('body').css('padding-top', hdTop + 'px');

			var NavTop = $('header').outerHeight();
			$(window).scroll(function () {
				if ($(window).scrollTop() > NavTop) {
					/*20210416開會說header4不要捲動了*/
					$('header:not(".headerStyle04")').addClass('scroll');
				} else {
					$('header').removeClass('scroll');
				}
			});
			if (
				$(
					'.headerStyle09,.headerStyle10,.headerStyle07,.headerStyle02_modify-01,.headerStyle02_modify-02'
				).length
			) {
				$('body').css('padding-top', 0);
			}
		}

		if ($('.headerStyle02_modify-02').length) {
			function nav_bg_active() {
				$('.js-nav-mouseover a').css({ color: 'inherit' });
				$('.js-nav-mouseHover a').css({ color: 'inherit' });
				const s_i = $(
					'.l-nav_main .js-nav-mouseover'
				)[0].getBoundingClientRect();
				const nav_main = $('.l-nav_main');

				const startWidthNewAnimHeight = $(
					'.l-nav_main .js-nav-mouseover'
				).innerHeight();

				const startWidthNewAnimWidth = $(
					'.l-nav_main .js-nav-mouseover'
				).innerWidth();
				const nav_main_padding = nav_main.innerWidth() - nav_main.width();
				const itemPosNewAnimTop = $('.l-nav_main .js-nav-mouseover').position();
				const itemPosNewAnimLeft = $(
					'.l-nav_main .js-nav-mouseover'
				).position();
				$('.l-nav_main-current').css({
					top: 50 + '%',
					left: itemPosNewAnimLeft.left + nav_main_padding / 2 + 'px',
					height: startWidthNewAnimHeight * 2 + 'px',
					width: startWidthNewAnimWidth + 'px',
					opacity: 1,
				});
				$('.js-nav-mouseover a').css({ color: '#fff' });
			}

			function nav_bg_aaply(e) {
				$('.js-nav-mouseover a').css({ color: 'inherit' });
				$('.js-nav-mouseHover a').css({ color: 'inherit' });
				$('.l-nav_main ul li').removeClass('js-nav-mouseHover');
				$(this).addClass('js-nav-mouseHover');
				// console.log($(this)[0]);
				const i = $(this)[0].getBoundingClientRect();
				const nav_main = $('.l-nav_main');

				console.log(nav_main[0]);
				const activeWidthNewAnimHeight = $(this).innerHeight();
				// console.log(activeWidthNewAnimHeight);
				const activeWidthNewAnimWidth = $(this).innerWidth();
				const nav_main_padding = nav_main.innerWidth() - nav_main.width();
				const itemPosNewAnimTop = $(this).position();
				const itemPosNewAnimLeft = $(this).position();
				$('.l-nav_main-current').css({
					top: 50 + '%',
					left: itemPosNewAnimLeft.left + nav_main_padding / 2 + 'px',
					height: activeWidthNewAnimHeight * 2 + 'px',
					width: activeWidthNewAnimWidth + 'px',
					opacity: 1,
				});
				$('.js-nav-mouseHover a').css({ color: '#fff' });
			}

			nav_bg_active();
			$('.l-nav_main').on(' click', 'li', function () {
				$('.l-nav_main li').removeClass('js-nav-mouseover');
				$(this).addClass('js-nav-mouseover');
				nav_bg_active();
			});

			$('.l-nav_main li').hover(nav_bg_aaply, nav_bg_active);

			if ($('.l-nav_full-list-inr').length) {
				// console.log('l-nav_full-list-tgl-wrap run');
				$('.l-nav_full-list-tgl-wrap').on('click', function () {
					const e = $(this).parents('.l-nav_full-list-tgl'),
						i = e.find('ul');
					if (e.hasClass('js-open'))
						e.removeClass('js-open'),
							i.css({
								height: '',
							});
					else {
						var s = 0;
						e.find('ul li').each(function (t, e) {
							s += Number($(e).outerHeight(!0));
						}),
							e.addClass('js-open'),
							i.css({
								height: s + 'px',
							});
					}
				});
			}

			// 不同方式增加不同的class
			$('.search-menu-control').on('click', function () {
				console.log('gogo');
				$('.fullMenu_nav2').removeClass('js-menu-open');
				$('.fullMenu_nav2').addClass('js-search-open');
			});

			$('.slide-menu-control').on('click', function () {
				$('.fullMenu_nav2').removeClass('js-search-open');
				$('.fullMenu_nav2').addClass('js-menu-open');
			});
		}

		// 內層超出寬換邊
		$('body').on(
			'mouseover',
			'.navMenu .moreMenu:not(.multiMenu)',
			function () {
				var $subMenu = $(this).children('ul');
				var subMenuWidth = $subMenu.width();

				var menuPosL = $subMenu.offset().left + subMenuWidth;
				var menuPosL2 = $subMenu.offset().left + subMenuWidth * 2;
				var menuPosL3 = $subMenu.offset().left + subMenuWidth * 3;

				if (menuPosL > $(window).width()) {
					$subMenu.css({ transition: 'none', left: 'auto', right: '0' });
				}
				if (menuPosL2 > $(window).width()) {
					$('.moreMenu > ul ul').css({
						transition: 'none',
						left: 'auto',
						right: '100%',
					});
				}
				if (menuPosL3 > $(window).width()) {
					$('.moreMenu > ul ul').css({
						transition: 'none',
						left: 'auto',
						right: '100%',
					});
				} else {
					$('.moreMenu > ul ul').css({ left: '100%', right: 'auto' });
				}
			}
		);
	}

	//headerStyle09捲動後的導覽列
	if ($('.headerStyle09').length) {
		//取得banner高度
		var bannerHeight = $('.headerStyle09 .banner_result').height();
		//捲動大於banner高度
		$(window).scroll(function () {
			if ($(window).scrollTop() >= bannerHeight) {
				$('.headerStyle09').addClass('sticky');
			} else {
				$('.headerStyle09').removeClass('sticky');
			}
		});
	}

	//headerStyle07捲動後的導覽列
	if ($('.headerStyle07').length) {
		//取得banner高度
		var bannerHeight = $('.headerStyle07 .banner_result').height();
		//捲動大於banner高度
		$(window).scroll(function () {
			if ($(window).scrollTop() >= bannerHeight) {
				$('.headerStyle07').addClass('sticky');
			} else {
				$('.headerStyle07').removeClass('sticky');
			}
		});
	}

	if ($('.headerStyle02, .headerStyle03').length) {
		if ($(window).width() < 1024) {
			var hdCTop = $('header').outerHeight();
			$('body').css('padding-top', hdCTop + 'px');
		}
	}

	//navMenu5第一層選單加入三角形icon(如果不需要，刪除此段)
	if ($('.navMenu5').length) {
		$('.navMenu5 > li.moreMenu > a > span').append(
			'<i class="fa fa-angle-down" aria-hidden="true"></i>'
		);
	}

	// mobile_btn
	if ($('.headerStyle02, .headerStyle03, .headerStyle07').length) {
		$('.btn-list').on('click', function () {
			$('html').toggleClass('open_menu');
			if ($(this).find('.mobile-menu-btn').hasClass('active')) {
				$('.mobile-menu-btn').removeClass('active');
			} else {
				$('.mobile-menu-btn').addClass('active');
			}
		});
	}

	// banner
	if ($('.bgVideo').length) {
		$('.bgVideo').each(function () {
			$(this).find('#bgVideo').YTPlayer();
			$loading = $('.bannerBlock').find('.loading');
			$('.bannerBlock')
				.find('#bgVideo')
				.on('YTPStart', function (e) {
					$loading.fadeOut();
				});
		});
	}

	// scrollDown
	if ($('.scrollDown').length) {
		$('.scrollDown').click(function () {
			$('html, body').animate(
				{
					scrollTop: $('#scroll').offset().top,
				},
				3000
			);
		});
	}

	//圖片浮動特效，在img上套用.scrollMove即可使圖片產生浮動
	if ($('.scrollMove').length) {
		if (!mobileType) {
			$('.scrollMove').each(function () {
				$(this).scrollAnimate({ animate: 'scrollMove' });
			});
		}
	}

	//首頁蓋版廣告
	if ($('.coverAd').length) {
		$('.coverAd .adBg').click(function () {
			$(this).parents('.coverAd').fadeOut(500);
		});
		$('.coverAd .closeBtn').click(function () {
			$(this).parents('.coverAd').fadeOut(500);
		});
	}

	// slidBlock
	if ($('.slidBlock').length) {
		$('.slidBlock').slick({
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,

			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 2,
					},
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						dots: true,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	if ($('.slidBlock2').length) {
		$('.slidBlock2').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
						arrows: false,
						dots: true,
					},
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	if ($('.slidBlock3').length) {
		$('.slidBlock3').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
						arrows: false,
					},
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	if ($('.slideBlock4').length) {
		$('.slideBlock4').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			dots: true,
		});
	}

	if ($('.slideBlock5').length) {
		var mySwiper = new Swiper('.slideBlock5', {
			loop: true,
			autoplay: {
				delay: 5000,
				disableOnInteraction: false,
			},
			// 如果需要分页器
			pagination: {
				el: '.slideBlock5 .swiper-pagination',
				type: 'fraction',
			},
			// 如果需要前进后退按钮
			navigation: {
				nextEl: '.slideBlock5 .swiper-button-next',
				prevEl: '.slideBlock5 .swiper-button-prev',
			},
		});
	}

	//相關產品
	if ($('#relateProSlid').length) {
		$('#relateProSlid').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 576,
					settings: {
						slidesToShow: 2,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	if ($('#relateProSlid02').length) {
		$('#relateProSlid02').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 576,
					settings: {
						slidesToShow: 2,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	if ($('.likeshopSlide1').length) {
		$('.likeshopSlide1').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
		});
	}

	if ($('.likeshopSlide2').length) {
		$('.likeshopSlide2').slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			arrows: false,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
		});
	}

	if ($('.likeshopSlide3').length) {
		$('.likeshopSlide3').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: false,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
		});
	}

	if ($('.likeshopSlide4').length) {
		$('.likeshopSlide4').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: false,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
		});
	}

	if ($('.overlapSlide').length) {
		$('.overlapSlide').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			dots: true,
			autoplay: true,
			autoplaySpeed: 5000,
		});
	}

	if ($('.newsListSlide').length) {
		$('.newsListSlide').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
					},
				},
				{
					breakpoint: 340,
					settings: {
						slidesToShow: 1,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	if ($('.historyType1').length) {
		$('.historyType1 .historySlick').slick({
			asNavFor: '.historyType1 .timeLineSlick',
			infinite: false,
			fade: true,
			arrows: false,
		});
		$('.historyType1 .timeLineSlick').slick({
			asNavFor: '.historyType1 .historySlick',
			slidesToShow: 3,
			focusOnSelect: true,
			centerMode: true,
			infinite: false,
			dots: false,
			swipeToSlide: true,
			vertical: true,
			verticalSwiping: true,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
			responsive: [
				{
					breakpoint: 992,
					settings: {
						vertical: false,
						verticalSwiping: false,
						variableWidth: true,
					},
				},
			],
		});
	}

	if ($('.historyType2').length) {
		$('.historySlick').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: false,
			fade: true,
			arrows: false,
			asNavFor: '.timeLineSlick',
		});
		$('.timeLineSlick').slick({
			asNavFor: '.historySlick',
			focusOnSelect: true,
			infinite: false,
			centerMode: true,
			dots: false,
			variableWidth: true,
			adaptiveHeight: true,
			swipeToSlide: true,
			touchThreshold: 3,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
		});
	}



	//計數器
	if ($('.countup').length) {
		$('.countup').countUp();
	}

	if ($('.prod_num').length) {
		var numberSpinner = (function () {
			$('.number-spinner>.ns-btn>a').click(function () {
				var btn = $(this),
					oldValue = btn.closest('.number-spinner').find('input').val().trim(),
					newVal = 0;

				if (btn.attr('data-dir') === 'up') {
					newVal = parseInt(oldValue) + 1;
				} else {
					if (oldValue > 1) {
						newVal = parseInt(oldValue) - 1;
					} else {
						newVal = 1;
					}
				}
				btn.closest('.number-spinner').find('input').val(newVal);
			});
			$('.number-spinner>input').keypress(function (evt) {
				evt = evt ? evt : window.event;
				var charCode = evt.which ? evt.which : evt.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57)) {
					return false;
				}
				return true;
			});
		})();
	}

	//產品比較for ProductListStyle14
	if ($('.productListStyle14').length) {
		var compareSum = 4; //最多只能比較4個項目
		//以checkbox進行比較
		$('.productListStyle14 .item .angleBox input').click(function () {
			//checkBox選取功能
			if (!$(this).parents('.item').hasClass('checked')) {
				var itemChecked = $('.productListStyle14 .item.checked').length; //已被選取的個數
				//目前尚未有任何項目被選取
				if (itemChecked == 0) {
					//隱藏其他系列產品
					$(this).parents('.rowList').siblings('.rowList').fadeOut(500);
					$(this).parents('.item').addClass('checked');
					//顯示比較工具列
					$('.compareBarBox').fadeIn(500);
				}
				//目前被選取的個數不超過4個
				else if (itemChecked > 0 && itemChecked < compareSum) {
					$(this).parents('.item').addClass('checked');
					//第4個被選取
					if (itemChecked == compareSum - 1) {
						//隱藏其他未被選取項目的比較按鈕和checkbox
						$(this).parents('.rowList').addClass('fullChecked');
					} else {
						$(this).parents('.rowList').removeClass('fullChecked');
					}
				}
				//更新比較工具列數字
				$('.compareBar')
					.find('.numerator')
					.text(itemChecked + 1);
			}
			//checkBox取消功能
			else {
				$(this).parents('.checked').removeClass('checked');
				$(this).parents('.rowList').removeClass('fullChecked');
				var itemChecked = $('.productListStyle14 .item.checked').length; //已被選取的個數
				if (itemChecked == 0) {
					//隱藏比較工具列
					$('.compareBarBox').fadeOut(500);
					//所有的項目都被取消，顯示其他系列產品
					$(this).parents('.rowList').siblings('.rowList').fadeIn(500);
				}
				//更新比較工具列數字
				$('.compareBar').find('.numerator').text(itemChecked);
			}
		});
		//以比較按鈕進行比較
		$('.productListStyle14 .item .compareBtn').click(function () {
			var itemChecked = $('.productListStyle14 .item.checked').length; //已被選取的個數
			//目前尚未有任何項目被選取
			if (itemChecked == 0) {
				//隱藏其他系列產品
				$(this).parents('.rowList').siblings('.rowList').fadeOut(500);
				$(this).parents('.item').addClass('checked');
				//將checkBox狀態改為被選取
				$(this)
					.parents('.item')
					.find('input[type=checkbox]')
					.prop('checked', true);
				//顯示比較工具列
				$('.compareBarBox').fadeIn(500);
			}
			//目前被選取的個數不超過4個
			else if (itemChecked > 0 && itemChecked < compareSum) {
				$(this).parents('.item').addClass('checked');
				//將checkbox狀態改為已選取
				$(this)
					.parents('.item')
					.find('input[type=checkbox]')
					.prop('checked', true);
				//第4個被選取
				if (itemChecked == compareSum - 1) {
					//隱藏其他未被選取項目的比較按鈕和checkbox
					$(this).parents('.rowList').addClass('fullChecked');
				} else {
					$(this).parents('.rowList').removeClass('fullChecked');
				}
			}
			//更新比較工具列數字
			$('.compareBar')
				.find('.numerator')
				.text(itemChecked + 1);
			return false;
		});
		//取消比較按鈕
		$('.productListStyle14 .item .cancelBtn').click(function () {
			//取消checkbox被選取狀態
			$(this)
				.parents('.item')
				.find('input[type=checkbox]')
				.prop('checked', false);
			$(this).parents('.checked').removeClass('checked');
			$(this).parents('.rowList').removeClass('fullChecked');
			var itemChecked = $('.productListStyle14 .item.checked').length; //已被選取的個數
			//所有的項目都被取消，顯示其他系列產品
			if (itemChecked == 0) {
				//隱藏比較工具列
				$('.compareBarBox').fadeOut(500);
				$(this).parents('.rowList').siblings('.rowList').fadeIn(500);
			}
			//更新比較工具列數字
			$('.compareBar').find('.numerator').text(itemChecked);
			return false;
		});
		//比較工具列
		$('.compareBar').find('.numerator').text('0');
		$('.compareBar').find('.denominator').text(compareSum);
		$('.compareBar .cancel').click(function () {
			$('.productListStyle14 .rowList').removeClass('fullChecked');
			$('.productListStyle14 .item').removeClass('checked');
			//取消所有checkbox被選取狀態
			$('.productListStyle14 .item')
				.find('input[type=checkbox]')
				.prop('checked', false);
			//顯示所有系列產品
			$('.productListStyle14 .rowList').fadeIn(500);
			//更新數字為0
			$('.compareBar').find('.numerator').text('0');
			//隱藏比較工具列
			$('.compareBarBox').fadeOut(500);
		});
	}

	//歷史沿革9
	if ($('.historyType9').length) {
		var headerH = $('header').height();
		var historyTitlePos = $('.historyType9 .titleBg').offset().top - headerH;
		var historyEndPos = $('.historyType9 .historyEnd').offset().top - headerH;
		var historyTitleH = $('.historyType9 .titleBg').outerHeight();
		var timeLineH = $('.historyType9 .timeLine').outerHeight();
		var stateChangePos = historyEndPos - historyTitleH - timeLineH;
		$(window).on('load scroll resize', function () {
			//特效僅限PC版
			if ($(window).width() > 1200) {
				var scroll = $(window).scrollTop();
				if (scroll >= historyTitlePos && scroll <= stateChangePos) {
					$('.historyType9 .titleBg').removeClass('ended');
					$('.historyType9 .timeLine').removeClass('ended');
					$('.historyType9 .titleBg').addClass('fixed');
					$('.historyType9 .timeLine').addClass('fixed');
				}
				if (scroll < historyTitlePos) {
					$('.historyType9 .titleBg').removeClass('ended');
					$('.historyType9 .timeLine').removeClass('ended');
					$('.historyType9 .titleBg').removeClass('fixed');
					$('.historyType9 .timeLine').removeClass('fixed');
				}
				if (scroll > stateChangePos) {
					$('.historyType9 .titleBg').removeClass('fixed');
					$('.historyType9 .timeLine').removeClass('fixed');
					$('.historyType9 .titleBg').addClass('ended');
					$('.historyType9 .timeLine').addClass('ended');
				}
			}
		});
		//時間軸
		$('.historyType9 .timeLine .point').click(function () {
			$(this).siblings('.point').removeClass('active');
			$(this).addClass('active');
			var year = $(this).text();
			var yearPos =
				$('.historyType9 .item[data-year="' + year + '"]').offset().top - 203;
			$('html, body').animate({ scrollTop: yearPos }, 'slow');
		});

		var yearItems = $('.historyType9 .item').length;
		var yearAry = Array();
		for (var x = 1, y = 0; x <= yearItems; x++, y++) {
			var yearDis =
				$('.historyType9 .item:nth-child(' + x + ')').offset().top - 349;
			yearAry[y] = yearDis;
		}
		$(window).on('scroll', function () {
			var scroll = $(window).scrollTop();
			for (var i = 1, z = 0; z < yearItems; i++, z++) {
				if (z == yearItems - 1) {
					if (scroll >= yearAry[z]) {
						$(
							'.historyType9 .timeLine .point[data-child="' + i + '"]'
						).addClass('active');
						$('.historyType9 .timeLine .point[data-child="' + i + '"]')
							.siblings()
							.removeClass('active');
					}
				} else {
					if (scroll >= yearAry[z] && scroll < yearAry[z + 1]) {
						$(
							'.historyType9 .timeLine .point[data-child="' + i + '"]'
						).addClass('active');
						$('.historyType9 .timeLine .point[data-child="' + i + '"]')
							.siblings()
							.removeClass('active');
					}
				}
			}
		});
	}

	/*Slide左右排列======================================*/
	if ($('.prod_blk').length) {
		$('.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.slider-nav',
			responsive: [
				{
					breakpoint: 992,
					settings: {
						prevArrow:
							'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
						nextArrow:
							'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
						arrows: true,
					},
				},
			],
		});
		$('.slider-nav').slick({
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-angle-up"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-angle-down"></i></button>',
			slidesToShow: 5,
			slidesToScroll: 1,
			focusOnSelect: true,
			vertical: true,
			asNavFor: '.slider-for',
		});
		//slickLightbox是以slick為基礎的lightbox插件
		$('.slider-for').slickLightbox({
			src: 'src',
			itemSelector: '.item-image img', //指向图片的锚链接选择器
			background: 'rgba(0, 0, 0, .9)', //lightbox背景色
			//設定slick的參數
			slick: {
				prevArrow:
					'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
				nextArrow:
					'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
				arrows: true,
			},
		});
	}

	if ($('.prod_blk2').length) {
		$('.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.slider-nav',
			responsive: [
				{
					breakpoint: 992,
					settings: {
						prevArrow:
							'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
						nextArrow:
							'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
						arrows: true,
					},
				},
			],
		});
		$('.slider-nav').slick({
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-angle-up"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-angle-down"></i></button>',
			slidesToShow: 5,
			slidesToScroll: 1,
			focusOnSelect: true,
			asNavFor: '.slider-for',
		});
	}

	/*slide上下排列===============================*/
	if ($('.prod_blk4').length) {
		$('.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.slider-nav',
			responsive: [
				{
					breakpoint: 992,
					settings: {
						prevArrow:
							'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
						nextArrow:
							'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
						arrows: true,
					},
				},
			],
		});
		$('.slider-nav').slick({
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-angle-up"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-angle-down"></i></button>',
			slidesToShow: 5,
			slidesToScroll: 1,
			focusOnSelect: true,
			asNavFor: '.slider-for',
		});
		//slickLightbox是以slick為基礎的lightbox插件
		$('.slider-for').slickLightbox({
			src: 'src',
			itemSelector: '.item-image img', //指向图片的锚链接选择器
			background: 'rgba(0, 0, 0, .9)', //lightbox背景色
			//設定slick的參數
			slick: {
				prevArrow:
					'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
				nextArrow:
					'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
				arrows: true,
			},
		});
	}

	if ($('.responsive_tbl').length) {
		$('.dataTable').DataTable({
			columnDefs: [
				{
					targets: [3],
					orderable: false,
				},
			],
			bPaginate: true, // 顯示換頁
			searching: false, // 顯示搜尋
			lengthMenu: [5, 10, 15],
			info: false, // 顯示資訊
			fixedHeader: true, // 標題置頂
			// scrollY: 250, //高度
			scrollX: '100%', //寬度
		});
	}

	if ($('.faqContent').length) {
		// $('.faqItem_main > .faqItem:eq(0)').addClass('faqItem_current');
		/*$(".faqItem_main").find('.faqItem:nth-child(1)').addClass('faqItem_current');
		$(".faqItem_head").click(function(){
			if($(this).parents('.faqItem').hasClass('faqItem_current')){
				$(this).parents('.faqItem').removeClass('faqItem_current');
			}else{
				$('.faqItem').removeClass('faqItem_current');
			$(this).parents('.faqItem').toggleClass('faqItem_current');
				$('html,body').animate({
			scrollTop: $(this).parents('.faqItem').offset().top
				},'slow');
		  }
		});*/
		$('.faqItem:nth-child(1) .faqItem_body').show();
		$('.faqItem:nth-child(1)').addClass('faqItem_current');
		$('.faqItem_head').click(function () {
			if ($(this).parents('.faqItem').hasClass('faqItem_current')) {
				$(this).parents('.faqItem').removeClass('faqItem_current');
				$(this).siblings('.faqItem_body').slideUp(800);
			} else {
				$(this)
					.parents('.faqItem')
					.siblings('.faqItem')
					.find('.faqItem_body')
					.slideUp(800);
				$(this)
					.parents('.faqItem')
					.siblings('.faqItem')
					.removeClass('faqItem_current');
				$(this).parents('.faqItem').addClass('faqItem_current');
				$(this).siblings('.faqItem_body').slideDown(800);
			}
		});
	}

	/*editTab區塊 Tab + lightBox*/
	if ($('.editTab').length) {
		$('.editTab .tabList a:first-child').addClass('active');
		$('.editTab div.tabBox:first-child').addClass('active');
		$('.editTab .tabList a').click(function () {
			$('.editTab .tabList a').removeClass('active');
			$(this).addClass('active');
			$('.editTab div.tabBox').removeClass('active');
			$($(this).attr('href')).addClass('active');
			$('html,body').animate(
				{ scrollTop: $('.editTab').offset().top - 100 },
				900
			);
		});
	}
	/*tab Slide*/
	if ($('.tabSlide').length) {
		$('.tabSlide').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 576,
					settings: {
						slidesToShow: 2,
					},
				},
				{
					breakpoint: 520,
					settings: {
						slidesToShow: 1,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	//===================================================================
	//預設圖
	//===================================================================
	$(window).on('load', function () {
		$('img').each(function () {
			if (
				!this.complete ||
				typeof this.naturalWidth == 'undefined' ||
				this.naturalWidth == 0
			) {
				this.src = 'images_v4/default.png';
			}
		});
	});

	//===================================================================
	//限字數
	//===================================================================
	$('[data-txtlen]:not([data-txtlen=""])').each(function () {
		$(this).text(txtlen($(this).text(), $(this).data('txtlen')));
	});
	function txtlen(txt, len) {
		if (txt.length > len) {
			return txt.substr(0, len) + '...';
		}
	}

	//===================================================================
	//GDPR
	//===================================================================
	if ($('.gdprBlock').length) {
		var gdprBlock = $('.gdprBlock');
		var gdprBtn = $('.gdpr__Btn');
		var gdprClosure = $('.gdpr__Closure');
		setTimeout(function () {
			gdprBlock.addClass('show');
		}, 1000);
		gdprClosure.on('click', function () {
			gdprBlock.removeClass('show');
			setTimeout(function () {
				gdprBlock.remove();
			}, 1000);
		});
		gdprBtn.on('click', function () {
			$.get('gdprcookie.php', function () {
				gdprBlock.removeClass('show');
				setTimeout(function () {
					gdprBlock.remove();
				}, 1000);
			});
		});
	}

	// pageLoading
	if ($('.pageLoading').length) {
		$(document).ready(function () {
			// $('.pageLoading').delay(3500).fadeOut(500);
			$('.pageLoading').delay(500).fadeOut(500);
		});
	}

	// show/hide password
	if ($('.memberContent').length) {
		$('.toggle-password').click(function () {
			$(this).children('i').toggleClass('fa-eye fa-eye-slash');
			var input = $('#password-field');
			if (input.attr('type') == 'password') {
				input.attr('type', 'text');
				$('.toggleText').text('隱藏密碼');
			} else {
				input.attr('type', 'password');
				$('.toggleText').text('顯示密碼');
			}
		});
	}

	//gotop
	if ($('#goTop').length) {
		$('#goTop').click(function () {
			jQuery('html,body').animate(
				{
					scrollTop: 0,
				},
				1000
			);
		});
		$(window).scroll(function () {
			if ($(this).scrollTop() > 300) {
				$('#goTop').fadeIn('fast');
			} else {
				$('#goTop').stop().fadeOut('fast');
			}
		});
	}

	// // 2022/10/27 家逵新增 for news/list31.php
	if ($('.newsListType26 ul').length) {
		$('.newsListType26 .row').slick({
			autoplay: false,
			arrows: false,
			infinite: true,
			speed: 300,
			autoplay: true,
			autoplaySpeed: 3000,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
						arrows: false,
					},
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	// // 2022/10/25 家逵新增 for index/.sectionBlock_71
	if ($('.sectionBlock_71 .pseriesList').length) {
		$('.pseriesList').slick({
			arrows: true,
			autoplay: true,
			autoplaySpeed: 3000,
			cssEase: 'ease-in-out',
			dots: false,
			fade: false,
			infinite: true,
			speed: 300,
			slidesToShow: 4,
			slidesToScroll: 1,
			nextArrow: $('.goodsnext'),
			prevArrow: $('.goodsprev'),
			responsive: [
				{
					breakpoint: 1580,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
						arrows: false,
					},
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	// // 2022/10/26 家逵新增 for home/index_content_ADinfo.php
	if ($('.container-fluid .info_ADbot .info_ADbot_list').length) {
		$('.container-fluid .info_ADbot .info_ADbot_list').slick({
			autoplay: true,
			arrows: false,
			infinite: true,
			speed: 800,
			slidesToShow: 4,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 992,
					settings: { slidesToShow: 2 },
				},
				{
					breakpoint: 768,
					settings: { slidesToShow: 1 },
				},
			],
		});
	}

	// 2022/10/26 家逵新增 for news/list33.php
	if ($('.container .info_ADbot .info_ADbot_list').length) {
		$('.container .info_ADbot .info_ADbot_list').slick({
			autoplay: true,
			mobileFirst: true, //add this one
			arrows: false,
			infinite: true,
			speed: 1200,
			slidesToShow: 1,
			slidesToScroll: 1,
			variableWidth: true,
			responsive: [
				{
					breakpoint: 992,
					settings: { slidesToShow: 4 },
				},
				{
					breakpoint: 768,
					settings: { slidesToShow: 2 },
				},
			],
		});
	}

	// 2022/10/31 家逵新增 for news/list35.php

	if ($('.subBox_sectionBlock_73_left .bList').length) {
		$('.subBox_sectionBlock_73_left .bList').slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			autoplay: true,
			arrows: false,
			speed: 1800,
			responsive: [
				{
					breakpoint: 641,
					settings: { slidesToShow: 1, slidesToScroll: 1 },
				},
			],
		});
	}

	// 2022/11/15 家逵新增 for about/sectionBlock_aboutUs23_container.php
	if ($('.sectionBlock_aboutUs23_container').length) {
		$('.box').waypoint(
			function () {
				this.element.classList.add('active');
				this.element.classList.add('hhh');
			},
			{ offset: '70%' }
		);
	}

	// 2022/11/01 家逵新增 for home/index_content_exqualityArea.php
	if ($('.exqualityArea .exqualityList').length) {
		$('.exqualityList')
			.on('init', function (event, slick, currentSlide, nextSlide) {
				$(".exqualityList li[data-slick-index='0']").addClass('view');
				$(".exqualityList_album li[data-slick-index='0']").addClass('view');
			})
			.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
				$(
					'.exqualityList li[data-slick-index=' + currentSlide + ']'
				).removeClass('view');
				$(
					'.exqualityList_album li[data-slick-index=' + currentSlide + ']'
				).removeClass('view');
			})
			.on('afterChange', function (event, slick, currentSlide) {
				$('.exqualityList li[data-slick-index=' + currentSlide + ']').addClass(
					'view'
				);
				$(
					'.exqualityList_album li[data-slick-index=' + currentSlide + ']'
				).addClass('view');
			})
			.slick({
				arrows: false,
				autoplay: true,
				autoplaySpeed: 5000,
				cssEase: 'ease-in-out',
				dots: false,
				fade: true,
				infinite: true,
				speed: 600,
				slidesToShow: 1,
				slidesToScroll: 1,
				asNavFor: '.exqualityList_album',
				responsive: [
					{
						breakpoint: 767,
						settings: 'unslick',
					},
				],
			});

		$('.exqualityList_album')
			.on('init', function (event, slick, currentSlide, nextSlide) {
				$(".exqualityList_album li[data-slick-index='0']").addClass('view');
			})
			.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
				$(
					'.exqualityList_album li[data-slick-index=' + currentSlide + ']'
				).removeClass('view');
			})
			.on('afterChange', function (event, slick, currentSlide) {
				$(
					'.exqualityList_album li[data-slick-index=' + currentSlide + ']'
				).addClass('view');
			})
			.slick({
				arrows: false,
				cssEase: 'ease-in-out',
				infinite: true,
				speed: 0,
				slidesToShow: 4,
				slidesToScroll: 1,
				asNavFor: '.exqualityList',
				focusOnSelect: true,
			});
	}

	// 2022/11/11 家逵新增 for home/index_content_sectionBlock_76.php
	if ($('.sectionBlock_76_productArea').length) {
		$('.sectionBlock_76_productArea').waypoint(
			function () {
				this.element.classList.add('active');
			},
			{
				offset: '70%',
			}
		);
		$('.productList').slick({
			infinite: true,
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: false,
			autoplay: true,
			autoplaySpeed: 3000,
			cssEase: 'ease-in-out',
			responsive: [
				{
					breakpoint: 9999,
					settings: 'unslick',
				},
				{
					breakpoint: 861,
					settings: {
						slidesToShow: 2,
					},
				},
				{
					breakpoint: 576,
					settings: {
						slidesToShow: 1,
					},
				},
			],
		});
	}

	//2022/12/16/ sectionBlock_77的 function
	if ($('.sectionBlock_77 ').length) {
		$('.sectionBlock_77').waypoint(
			function () {
				this.element.classList.add('show'); // 一次只能放一個 class 名稱
			},
			{
				offset: '60%', //距離視窗高度
			}
		);

		const len = $('.sectionBlock_77 .menu ul li').length;
		const slot = 0.3;
		let time = 0;
		for (var i = 0; i < len; i++) {
			$('.sectionBlock_77 .menu ul li')
				.eq(i)
				.css({ 'transition-delay': time + 's' });
			time += slot;
		}
	}

	//2022/12/16/ sectionBlock_77-5的 function
	if ($('.sectionBlock_77-5 ').length) {
		$('.sectionBlock_77-5').waypoint(
			function () {
				this.element.classList.add('show'); // 一次只能放一個 class 名稱
			},
			{
				offset: '60%', //距離視窗高度
			}
		);

		const len = $('.sectionBlock_77-5 .menu ul li').length;
		const slot = 0.3;
		let time = 0;
		for (var i = 0; i < len; i++) {
			$('.sectionBlock_77-5 .menu ul li')
				.eq(i)
				.css({ 'transition-delay': time + 's' });
			time += slot;
		}
	}

	// 2022/11/23 家逵新增 for home/index_content_sectionBlock_78
	if ($('.sectionBlock_78_swiper-container').length) {
		let mySwiper = new Swiper('.sectionBlock_78_swiper-container', {
			speed: 1e3,
			autoplay: {
				delay: 6e3,
				waitForTransition: false,
				disableOnInteraction: true,
			},
			loop: true,
			pagination: {
				el: '.page-application',
				type: 'bullets',
				clickable: true,
			},
			slidesPerView: 3,
			navigation: {
				nextEl: '.idx-a-next',
				prevEl: '.idx-a-prev',
			},
			breakpoints: {
				0: {
					slidesPerView: 1,
					initialSlide: 1,
				},
				576: {
					spaceBetween: 40,
					slidesPerView: 'auto',
					initialSlide: 4,
				},
				980: {
					slidesPerView: 'auto',
					spaceBetween: 40,
					initialSlide: 4,
					slidesOffsetBefore: 200,
				},
			},
		});
	}

	//2023/01/03/ sectionBlock_80-7的 function

	if ($('.sectionBlock_80-7').length) {
		if ($(window).width() <= 576) {
			$('.sectionBlock_80-7 .honeycomb')
				.find('.honeycomb__placeholder')
				.remove();

			$('.sectionBlock_80-7 .honeycomb').slick({
				infinite: true,
				slidesToShow: 2,
				slidesToScroll: 1,
				arrows: false,
				autoplay: false,
				autoplaySpeed: 3000,
				cssEase: 'ease-in-out',
				responsive: [
					{
						breakpoint: 9999,
						settings: 'unslick',
					},

					{
						breakpoint: 576,
						settings: {
							slidesToShow: 1,
						},
					},
				],
			});
		}
	}

	//2022/12/05/ sectionBlock_82的 function
	if ($('.sectionBlock_82').length) {
		$('.sectionBlock_82').waypoint(
			function () {
				this.element.classList.add('show'); // 一次只能放一個 class 名稱
			},
			{
				offset: '60%', //距離視窗高度
			}
		);

		const len = $('.sectionBlock_82 .processList li').length;
		const slot = 0.3;
		let time = 0;
		for (var i = 0; i < len; i++) {
			$('.sectionBlock_82 .processList li')
				.eq(i)
				.css({ 'transition-delay': time + 's' });
			time += slot;
		}
	}

	//2022/12/05/ sectionBlock_83的 function
	if ($('.sectionBlock_83').length) {
		$('.solutionTabContent.tabContent >div').eq(0).show();
		$('.solutionTab.tab a').eq(0).addClass('current');
		$('.solutionTab.tab')
			.find('a')
			.click(function () {
				let obj = $(this).attr('href');
				$(this).addClass('current').siblings().removeClass('current');
				$(obj).fadeIn().siblings().hide();
				if ($(obj).children('.soluiton_album li').length > 1) {
					$(obj).children('.soluiton_album').slick({
						infinite: true,
						fade: true,
						slidesToShow: 1,
						slidesToScroll: 1,
						dots: true,
						dotsClass: 'slick-dots-vertical',
						autoplay: true,
						autoplaySpeed: 3000,
						cssEase: 'linear',
					});
				}
				$('body,html').animate(
					{ scrollTop: $('.solutionArea').offset().top - 80 },
					300
				);

				return false;
			});
	}

	//2022/12/05/ sectionBlock_84的 function

	if ($('.sectionBlock_84').length) {
		$('.businessListBg').slick({
			infinite: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			dots: false,
			arrows: false,
			autoplay: false,
			// autoplaySpeed: 3000,
			speed: 200,
			swipe: false,
			cssEase: 'ease-in-out',
			responsive: [
				{
					breakpoint: 1025,
					settings: {
						infinite: true,
						asNavFor: '.businessListBtn, .businessListTxt',
					},
				},
			],
		});
		$('.businessListTxt').slick({
			infinite: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			dots: false,
			arrows: false,
			autoplay: false,
			// autoplaySpeed: 3000,
			speed: 200,
			swipe: false,
			cssEase: 'ease-in-out',
			responsive: [
				{
					breakpoint: 1025,
					settings: {
						infinite: true,
						asNavFor: '.businessListBtn, .businessListBg',
					},
				},
			],
		});
		$('.businessListBtn').slick({
			infinite: false,
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: false,
			autoplay: false,
			// autoplaySpeed: 3000,
			speed: 200,
			responsive: [
				{
					breakpoint: 1025,
					settings: {
						infinite: true,
						focusOnSelect: true,
						dots: true,
						dotsClass: 'slick-dots-bottom',
						autoplay: true,
						autoplaySpeed: 3000,
						asNavFor: '.businessListBg, .businessListTxt',
					},
				},
				{
					breakpoint: 441,
					settings: {
						focusOnSelect: true,
						infinite: true,
						slidesToShow: 2,
						dots: true,
						dotsClass: 'slick-dots-bottom',
						autoplay: false,
						autoplaySpeed: 3000,
						asNavFor: '.businessListBg, .businessListTxt',
					},
				},
			],
		});

		var hoverBusiness;
		if ($(window).innerWidth() > 1024) {
			$('.businessListBtn li').eq(0).addClass('current');
		}
		$('.businessListBtn li .item')
			.mouseenter(function () {
				let this_item = $(this).parents('li');
				if ($(window).innerWidth() > 1024) {
					hoverBusiness = setTimeout(function () {
						$('.businessListBtn li').removeClass('current');
						let item_index = this_item.data('index');
						this_item.addClass('current');

						$('.businessListBtn').slick('slickGoTo', item_index);
						$('.businessListBg').slick('slickGoTo', item_index);
						$('.businessListTxt').slick('slickGoTo', item_index);
					}, 300);
				}
			})
			.mouseleave(function () {
				if ($(window).innerWidth() > 1024) {
					clearTimeout(hoverBusiness);
					let org_item = $('.businessListBtn li.current');
					let org_index = $('.businessListBtn li.current').data('index');
					$('.businessListBtn').slick('slickGoTo', org_index);
					$('.businessListBg').slick('slickGoTo', org_index);
					$('.businessListTxt').slick('slickGoTo', org_index);
				}
			});
	}

	//2022/12/09/ sectionBlock_85的 function

	if ($('.sectionBlock_85').length) {
		$('.sectionBlock_85 .newsList').slick({
			infinite: true,
			slidesToShow: 2,
			slidesToScroll: 1,
			arrows: false,
			dots: true,
			dotsClass: 'slick-dots-bottom',
			// customPaging: function (slider, i) {
			// 	return
			// },
			autoplay: true,
			autoplaySpeed: 3000,
			vertical: true,
			verticalSwiping: true,
			cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1)',
			responsive: [
				{
					breakpoint: 1181,
					settings: {
						vertical: false,
						verticalSwiping: false,
					},
				},
				{
					breakpoint: 841,
					settings: {
						slidesToShow: 1,
						vertical: false,
						verticalSwiping: false,
					},
				},
			],
		});
	}

	//2022/12/05/ sectionBlock_89的 function
	if ($('.sectionBlock_89').length) {
		$('.sectionBlock_89').waypoint(
			function () {
				this.element.classList.add('show'); // 一次只能放一個 class 名稱
			},
			{
				offset: '60%', //距離視窗高度
			}
		);

		const len = $('.sectionBlock_89 .mainContent .processList li').length;
		const slot = 0.3;
		let time = 0;
		for (var i = 0; i < len; i++) {
			$('.sectionBlock_89 .processList li')
				.eq(i)
				.css({ 'transition-delay': time + 's' });
			time += slot;
		}
	}

	//2023/01/03/ sectionBlock_90的 function
	if ($('.sectionBlock_90 .marketList .marketList__item').length) {
		var runMarketNumber = false;
		function runNumber(ele, nowNumber, maxNumber) {
			if (nowNumber + 1 <= maxNumber) {
				ele.children('.number').text(nowNumber + 1 + '%');
				ele.find('.bar-active').css({
					width: nowNumber + 1 + '%',
				});
			}
			if (nowNumber + 2 <= maxNumber) {
				setTimeout(function () {
					runNumber(ele, nowNumber + 1, maxNumber);
				}, 30);
			}
		}
		if (
			$(window).scrollTop() + $(window).height() * 0.7 >
			$('.marketList').offset().top
		) {
			$('.sectionBlock_90 .marketList .marketList__item').each(function () {
				var percentNumber = $(this).data('number');
				var nowNumber = 0;
				runNumber($(this), nowNumber, percentNumber);
				runMarketNumber = true;
			});
		}

		$(window).scroll(function () {
			if (runMarketNumber == false) {
				if (
					$(window).scrollTop() + $(window).height() * 0.7 >
					$('.marketList').offset().top
				) {
					$('.marketList .marketList__item').each(function () {
						var percentNumber = $(this).data('number');
						var nowNumber = 0;
						runNumber($(this), nowNumber, percentNumber);
						runMarketNumber = true;
					});
				}
			}
		});
	}

	//2022/12/05/ sectionBlock_91的 function
	if ($('.sectionBlock_91').length) {
		$('.sectionBlock_91 .cb12_mb .items').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			dots: true,
			dotsClass: 'slick-dots-bottom',
			// customPaging: function (slider, i) {
			// 	return
			// },
			autoplay: true,
			autoplaySpeed: 3000,
			vertical: true,
			verticalSwiping: true,
			cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1)',
			responsive: [
				{
					breakpoint: 841,
					settings: {
						slidesToShow: 1,
						vertical: false,
						verticalSwiping: false,
					},
				},
			],
		});
	}

	// sectionBlock_92;
	/*editTab區塊 Tab + lightBox*/
	if ($('.editTab').length) {
		$('.editTab .tabList a:first-child').addClass('active');
		$('.editTab div.tabBox:first-child').addClass('active');
		$('.editTab .tabList a').click(function () {
			$('.editTab .tabList a').removeClass('active');
			$(this).addClass('active');
			$('.editTab div.tabBox').removeClass('active');
			$($(this).attr('href')).addClass('active');
			$('html,body').animate(
				{ scrollTop: $('.editTab').offset().top - 100 },
				900
			);
		});
	}

	// sectionBlock_92;
	/*輪播區域*/

	if ($('.sectionBlock_92 .slidBlock2').length) {
		$('.sectionBlock_92 .slidBlock2').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow:
				'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:
				'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			autoplay: false,
			autoplaySpeed: 3000,
			responsive: [
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
					},
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2,
						arrows: false,
						dots: false,
					},
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						focusOnSelect: false,
					},
				},
			],
		});
	}

	// 2022/11/18 location / list2

	$(function () {
		if ($('.locationContent_2 .dist-item').length) {
			$('.locationContent_2 .dist-item').on('click', function (e) {
				// e.stopPropagation();
				e.currentTarget.classList.toggle('active');
			});
		}
	});

	// 2022/11/16 家逵新增 for product/detail7.php
	if ($('.prd-detail-detail7 .swiper_container ').length) {
		let mySwiper = new Swiper('.prd-detail-detail7 .swiper_container ', {
			effect: 'fade',
			fadeEffect: {
				crossFade: true,
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
		});
	}

	// 2022/12/30 家逵新增 for contact/b2b-2.php
	$('.form_b2b_2 input, textarea').blur(function () {
		'' === $(this).val()
			? $(this).removeClass('valid')
			: $(this).addClass('valid');
	});


	// 兩個區域
	if ($('.area-photo').length) {
		$('.area-photo').slick({
			dots: true,
			infinite: true,
			speed: 500,
			fade: true,
			cssEase: 'linear',
		});
	}

});

//===================================================================
// tabList (頁籤切換)
//===================================================================
$('.tabLabel').click(function () {
	$(this).siblings('.tabLabel.active').removeClass('active');
	$(this).addClass('active');
	// jQuery("html,body").animate({
	//     scrollTop: $(this).offset().top-$(this).height()*2
	// }, 300);
});
//end tabList

//===================================================================
//收合選單
// 1.可無限階層，如有子選單則收合，若無則link(轉頁)
// 2.active複選：凡是href=url的項目皆會active，並展開
// 3.如html無設定active，預設展開第一筆
//class=togglearea
//data-item  每筆資料
//data-title 標題(點擊展開內容)
//data-content 收合的內容 (預設隱藏，第一筆展開,或在html加active展開)
//data-nodefault="true" 取消預設展開第一筆
//SAMPLE CODE <div class="faqlist togglearea" data-item=".faq_item" data-title=".faq_title" data-content=".faq_content">
//用在收合選單(有子選單)：
//data-item="li" data-title="li>a" data-content="ul" data-nodefault="true"
//----同層選單縮合data-content="ul"
//----同層選單不縮合 data-content="li>ul"
//===================================================================

togglearea('.togglearea');

function togglearea(target) {
	items = $(target).data('item');
	title = $(target).data('title');
	content = $(target).data('content');
	nodefault = $(target).data('nodefault');
	//$(target).addClass("no_css_transition");               //移除css animation
	$(target + ' ' + content).hide(); //隱藏所有選單內容
	if ($(target).find(items).hasClass('active')) {
		$(target + ' ' + items + '.active')
			.siblings()
			.find(content)
			.hide(); //隱藏同層的其他內容
		$(target + ' ' + items + '.active')
			.children(content)
			.show(); //如有active則展開該項
	} else if (!nodefault) {
		$(target + ' ' + items + ':first-child')
			.children(content)
			.show(); //若無active展開第一項內容
		$(target + ' ' + items + ':first-child')
			.children(content)
			.parent()
			.addClass('active');
	} //並加active
	$(target + ' ' + title).click(function () {
		if ($(this).closest(items).hasClass('active')) {
			$(items).removeClass('active');
		} else {
			$(items).removeClass('active');
			$(this).closest(items).addClass('active');
		}

		if ($(this).next(content).length > 0) {
			$(this).parent().siblings().find(content).slideUp(300); //同層的收合
			$(this).next(content).stop().slideToggle(300);

			return false;
		}
	});
} //END function togglearea

// headerStyle02_modify-01;
/*hover 時增添 class*/

$('.globalnav_main .globalnav_col').hover(
	function () {
		if ($(this).children('.dropdown-menu').length) {
			$('.popup-bg-cover').addClass('open');
			$('.headerStyle02_modify-01 nav').addClass('open');
		}
	},

	function () {
		$('.popup-bg-cover').removeClass('open');
		$('.headerStyle02_modify-01 nav').removeClass('open');
	}
);

//===================================================================
//文字垂直輪播 ( class=.marquee)  (需搭配css)
//===================================================================

var marqueeTarget = '.marquee';

if ($(marqueeTarget).length) {
	if (!mobileType) {
		var $marqueeBlock = $(marqueeTarget + ' ul'),
			$marqueeItem = $marqueeBlock.append($marqueeBlock.html()).children(),
			marqueeHeight = $('.marquee').height() * -1,
			scrollSpeed = 600,
			timer,
			speed = 3000 + scrollSpeed;

		$marqueeItem.hover(
			function () {
				clearTimeout(timer);
			},
			function () {
				timer = setTimeout(marqueeAD, speed);
			}
		);

		$('a').focus(function () {
			this.blur();
		});

		function marqueeAD() {
			var nowPos = $marqueeBlock.position().top / marqueeHeight;
			nowPos = (nowPos + 1) % $marqueeItem.length;
			$marqueeBlock.animate(
				{
					top: nowPos * marqueeHeight,
				},
				scrollSpeed,
				function () {
					if (nowPos == $marqueeItem.length / 2) {
						$marqueeBlock.css('top', 0);
					}
				}
			);
			timer = setTimeout(marqueeAD, speed);
		}
		timer = setTimeout(marqueeAD, speed);
	}
} //end marquee

//2022/12/02/ sectionBlock_aboutUs25 的 function

function changeStep(event) {
	$(event.target)
		.parents('.item')
		.addClass('active')
		.siblings()
		.removeClass('active');
}

//v4_animate cowboy 20220125
if ($('.v4_animate').length) {
	$(window).on('load scroll resize', function () {
		$('.v4_animate').each(function () {
			var targetPos = $(this).offset().top - $(window).innerHeight() * 0.85;
			var scroll = $(window).scrollTop();
			if (scroll >= targetPos) {
				$(this).addClass('in');
			}
		});
	});
}
//v4_animate cowboy 20220125 end

function openList(event) {
	$(event.target).parents('.mediaCard_share').toggleClass('openSocial');
}

// 觸發AOS動畫

AOS.init();



// 專案


// 申請選擇下拉表單

$(function () {
	$(
		'.selection-radio .select, .class-selection .select,classes-webs-search .select'
	)
		.on('click', '.placeholder', function () {
			var parent = $(this).closest('.select');
			if (!parent.hasClass('is-open')) {
				parent.addClass('is-open');
				$('.select.is-open').not(parent).removeClass('is-open');
			} else {
				parent.removeClass('is-open');
			}
		})
		.on('click', 'ul>li', function () {
			var parent = $(this).closest('.select');
			parent.removeClass('is-open').find('.placeholder').text($(this).text());
		});

	$(document).ready($(fileLoad));
});

//自訂上傳按鈕使其上傳檔案 會跟著改檔名的function
const fileLoad = function () {
	var inputs = document.querySelectorAll('.file-input');

	for (var i = 0, len = inputs.length; i < len; i++) {
		customInput(inputs[i]);
	}

	function customInput(el) {
		const fileInput = el.querySelector('[type="file"]');
		const label = el.querySelector('[data-js-label]');

		fileInput.onchange = fileInput.onmouseout = function () {
			if (!fileInput.value) return;

			var value = fileInput.value.replace(/^.*[\\\/]/, '');
			el.className = 'file-input -chosen';
			// el.className('-chosen');
			label.innerText = value;
			label.style.display = 'block';
		};
	}
};