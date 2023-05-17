$(document).ready(function() {
	// layer popUp
	$("a[rel='login']").prettyPopin({width: 577});
	$("a[rel='letter']").prettyPopin({width: 597});
	$("a[rel='terms']").prettyPopin({width:720});

	$('#login').click(function(){
		$(".login-layer").show();
		$("body").append("<div class='overlay'></div>");
		$(".overlay").css({'opacity':'0.8', 'height': $(document).height() });
		$('html,body').animate({scrollTop: '0'},'slow');
	});
	$(window).resize(window_resize);
	$(window).scroll(window_resize);
	function window_resize() { $('.overlay').css({ 'opacity': '0.8', 'height': $(document).height() })}
	$('.join-box th img').wrap('<span></span>');
	$('.email-box th img').wrap('<span></span>');
/*
	$('#login-box').focus(function(){
		if( $.browser.msie){
			$(this).blur();
		}
		var docHeight = $(document).height();
		$(".login-layer").show();
		$(".login-layer").append("<div class='overlay'></div>");
		$(".overlay").height(docHeight);
		$(".overlay").css('opacity','0.8');
		$('html').scrollTop(0);
	});
*/
	$('#login-box').click(function(){
		var docHeight = $(document).height();
		$(".login-layer").show();
		$('html,body').animate({scrollTop: '0'},'slow');
		$(".login-layer").append("<div class='overlay'></div>");
		$(".overlay").height(docHeight);
		$(".overlay").css('opacity','0.8');
	});


	//navigation
	$('.gnb-btn a').click(function(){
		$('#gnb').slideToggle('fast');
		return false;
	});
	//main
	$('.element .numbers').hover(
		function(){
			$(this).children('.text').show();
			$(this).children('.number-img').hide();
		},
		function(){
			$(this).children('.text').hide();
			$(this).children('.number-img').show();
	});
	// magicnumber made
	$('.dream-btn').click(function(){
		if ($('.dream-view li').is('.active'))
			{
				$('.dream-view li.active').find('img').attr('src', $('.dream-view li.active').find('img').attr('src').replace('_on.jpg','p.jpg'));
				$('.dream-view li.active').removeClass('active');
			}
		$(this).parent().addClass('active');
		$(this).children().attr('src', $(this).children().attr('src').replace('p.jpg','_on.jpg'));
		return false;
	});

	// magicnumber letter
	$('#slider1').bxSlider({
		displaySlideQty: 4,
		infiniteLoop: false,
		moveSlideQty: 4,
		hideControlOnEnd: true
	});

// mypage
	$('.mypage-list .head-text:first').addClass('active').next().show();

	$('.slide-btn').click(function(){
		if( $(this).parent().next('div').is(':hidden')) { 
			if ($('.mypage-list .head-text').is('.active'))
			{
				$('.mypage-list .head-text.active').find('h2').find('img').attr('src', $('.mypage-list .head-text.active').find('h2').find('img').attr('src').replace('_on.gif','.gif'));
				$('.mypage-list .head-text.active').find('.slide-btn').find('img').attr('src', $('.mypage-list .head-text.active').find('.slide-btn').find('img').attr('src').replace('_on.gif','.gif'));
			}
			$('.mypage-list .head-text.active').removeClass('active').next().slideUp('fast');
			$(this).parent().toggleClass('active').next().slideDown('fast');
			$('.mypage-list .head-text.active').find('h2').find('img').attr('src', $('.mypage-list .head-text.active').find('h2').find('img').attr('src').replace('.gif','_on.gif'));
			$('.mypage-list .head-text.active').find('.slide-btn').find('img').attr('src', $('.mypage-list .head-text.active').find('.slide-btn').find('img').attr('src').replace('.gif','_on.gif'));
		} else {
			$(this).parent().toggleClass('active').next().slideUp('fast');
			$(this).siblings('h2').find('img').attr('src', $(this).siblings('h2').find('img').attr('src').replace('_on.gif','.gif'));
			$(this).find('img').attr('src', $(this).find('img').attr('src').replace('_on.gif','.gif'));
		}
		return false;
	});

// event view
	$('.event-view .event-head:first').addClass('active').next().show();

	$('.event-btn').click(function(){
		if( $(this).parent().next('div').is(':hidden')) { 
			if ($('.event-view .event-head').is('.active'))
			{
				$('.event-view .event-head.active').find('img').attr('src', $('.event-view .event-head.active').find('img').attr('src').replace('_on.gif','.gif'));
			}
			$('.event-view .event-head.active').removeClass('active').next().slideUp('fast');
			$(this).parent().toggleClass('active').next().slideDown('fast');
			$('.event-view .event-head.active').find('.event-btn').find('img').attr('src', $('.event-view .event-head.active').find('.event-btn').find('img').attr('src').replace('.gif','_on.gif'));
		} else {
			$(this).parent().toggleClass('active').next().slideUp('fast');
			$(this).find('img').attr('src', $(this).find('img').attr('src').replace('_on.gif','.gif'));
		}
		return false;
	});
// rollover
	var rollover = {
		selectimage: function(src) {
			return src.substring(0, src.search(/(\.[a-z]+)$/) ) + '_sel' + src.match(/(\.[a-z]+)$/)[0];
		},
		newimage: function(src) {
			return src.substring(0, src.search(/(\.[a-z]+)$/) ) + '_on' + src.match(/(\.[a-z]+)$/)[0];
		},
		oldimage: function(src) {
			return src.replace(/_on\./, '.');
		},
		init: function() {
			$(".roll").hover(
				function () { $(this).attr( 'src', rollover.newimage($(this).attr('src')) ); },
				function () { $(this).attr( 'src', rollover.oldimage($(this).attr('src')) ); }
			);
		}
	};
	rollover.init();
});
