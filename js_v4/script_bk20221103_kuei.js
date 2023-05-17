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
			if ($('.headerStyle09,.headerStyle10,.headerStyle07').length) {
				$('body').css('padding-top', 0);
			}
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
			autoplay: false,
			autoplaySpeed: 3000,
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
			info: false, // 顯示資訊
			fixedHeader: true, // 標題置頂
			scrollY: 450,
			scrollX: '100%',
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
