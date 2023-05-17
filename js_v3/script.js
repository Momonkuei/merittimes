$(window).resize(function(){
  window.location.reload();
});

$(function(){

  // header
  if($('header').length){
    if($(window).width() > 1024){
      var hdTop = $('header').outerHeight();
      $("body").css("padding-top", hdTop+"px");
    }

    var NavTop = $('header').outerHeight();
    $(window).scroll(function(){
      if( $(window).scrollTop() > NavTop ) {
        $('header').addClass("scroll");
      } else {
        $('header').removeClass("scroll");
      }
    });

    // 內層超出寬換邊
    $("body").on('mouseover',".navMenu .moreMenu:not(.multiMenu)",function(){

      var $subMenu = $(this).children("ul");
      var subMenuWidth = $subMenu.width();

      var menuPosL = $subMenu.offset().left+subMenuWidth;
      var menuPosL2 = $subMenu.offset().left+(subMenuWidth*2);

      if(menuPosL>$(window).width()){
        $subMenu.css({"transition":"none","left":"auto","right":"0"});
      }
      if(menuPosL2>$(window).width()){
        $('.moreMenu > ul ul').css({"transition":"none","left":"auto","right":"100%"});
      }else{
        $('.moreMenu > ul ul').css({"left":"100%","right":"auto"});
      }

    });
	}


  // mobile_btn
  if($('.headerStyle02, .headerStyle03, .headerStyle07').length){
    $('.btn-list').on('click', function() {
      $('html').toggleClass('open_menu');
    	if($(this).find('.mobile-menu-btn').hasClass('active')) {
    		$('.mobile-menu-btn').removeClass('active');
    	} else {
    		$('.mobile-menu-btn').addClass('active');
    	}
    });
  }

  // banner
  if( $(".bgVideo").length ){
    $(".bgVideo").each(function(){
       $(this).find("#bgVideo").YTPlayer();
       $loading=$('.bannerBlock').find(".loading");
       $('.bannerBlock').find("#bgVideo").on("YTPStart",function(e){
          $loading.fadeOut();
       });
    });
  }


  // scrollDown
  if($('.scrollDown').length){
    $(".scrollDown").click(function() {
      $('html, body').animate({
          scrollTop: $("#scroll").offset().top
      }, 3000);
    });
  }


  // slidBlock
  if($(".slidBlock").length){
		$(".slidBlock").slick({
			prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
		    autoplay: true,
	        autoplaySpeed: 3000,

			  responsive: [
			    {
			      breakpoint: 1200,
			      settings: {
			        slidesToShow: 2,
			      }
			    },
			    {
			      breakpoint: 768,
			      settings: {
			        slidesToShow: 1,
			        dots:true,
			        focusOnSelect: false
			      }
			    }
			  ]
		});
	}


});
