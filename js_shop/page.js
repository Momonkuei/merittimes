$(function(){


	if($('.twzipcode').length){
		if(typeof ml_key == 'undefined' || ml_key == 'tw'){

			$('.twzipcode:not(.onlyLocal)').twzipcode();

			$('.twzipcode.onlyLocal').twzipcode({
			    'hideCounty': ['金門縣', '連江縣','澎湖縣'],
			    'hideDistrict': ['951','952']
			});
		}
	}




	if($('.swipebox').length){
		$('.swipebox').swipebox();
	}


	if($('.swipebox-video').length){
		$('.swipebox-video').swipebox({
			autoplayVideos:false
		});
	}


	if($(".fancybox").length){
		$('.fancybox').fancybox({
			helpers : {
				title : {
					type : 'inside'
				}
			}
		});
	}

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
			        slidesToShow: 1 ,
			        dots:true,
			        focusOnSelect: false
			      }
			    }
			  ]
		});
	}


	if($("#relateProSlid").length){
		$("#relateProSlid").slick({
			prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			slidesToShow: 5,
			slidesToScroll: 1,
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
			        slidesToShow: 1
			      }
			    },
			    {
			      breakpoint: 440,
			      settings:'unslick'
			    }
			  ]

		});
	}

	if($(".itemSlickNav").length){
		$('.itemSlickNav').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			dots: false,
			centerMode: false,
			focusOnSelect: true,
			asNavFor: '.itemSlick',
			prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',

			  responsive: [
			    {
			      breakpoint: 1200,
			      settings: {
			        slidesToShow: 3,
			      }
			    },
			    {
			      breakpoint: 768,
			      settings: {
			        slidesToShow: 1
			      }
			    }
			  ]

		});
	}

	if($(".itemSlick").length){
		$('.itemSlick').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.itemSlickNav',
			prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>',
			responsive: [
			  {
			    breakpoint: 1024,
			    settings: {
			      dots:true,
			    }
			  }
			]
		});
	}

	if($(".slideBanner").length){
		$('.slideBanner').slick({
		    slidesToShow: 1,
		    slidesToScroll: 1,
		    arrows: true,
		    fade: true,
		    autoplay: true,
	        autoplaySpeed: 3000,
		    prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-arrow-left"></i></button>',
			nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-arrow-right"></i></button>'
		});
	}

	if($(".waterPhotos").length){
		var $grid = $('.waterPhotos').masonry({
		  itemSelector: '.item',
		});

		$grid.imagesLoaded().progress( function() {
		  $grid.masonry();
		});
	}

	if($(".sliderFilter").length){
		// range slider  (use noUiSlider)
		var sliderTarget   = ".sliderFilter";
		var minValueTarget = ".minPrice";
		var maxValueTarget = ".maxPrice";

	    var thousandComma = function(number){
	         var num = number.toString();
	         var pattern = /(-?\d+)(\d{3})/;
	         while(pattern.test(num)){
	          num = num.replace(pattern, "$1,$2");
	         }
	         return num;
	    }

		$(sliderTarget).each(function(){
		    var priceSlider    = this;
		    var minPrice       = $(this).siblings().find(minValueTarget);
		    var maxPrice       = $(this).siblings().find(maxValueTarget);
		    var startValue     = $(this).data("start");
		    var minValue       = $(this).data("min");
		    var maxValue       = $(this).data("max");
		    var stepValue      = $(this).data("step");
		    var pretxt         = $(this).data("pretxt");

		    noUiSlider.create(priceSlider, {
		        start:startValue,
		        connect: true,
		        step:stepValue ,
		        range: {
		            'min': minValue,
		            'max': maxValue
		        }
		    });

		    priceSlider.noUiSlider.on('update', function( values, handle ) {
		        var value = values[handle];
		        value=Math.round(value);
		        formatValue=pretxt+thousandComma(value);

		        if ( handle ) {
		            maxPrice.value = value ;
		            maxPrice.html( formatValue );
		            // $("#showPrice .maxPrice").html(formatValue);

		        } else {
		            minPrice.value =  value;
		            minPrice.html( formatValue );
		            // $("#showPrice .minPrice").html(formatValue);
		        }
		     });

		     priceSlider.noUiSlider.on('end', function( values, handle ) {
	            proFilterAjax($(priceSlider),minPrice.value,maxPrice.value);
		    });


		});
	}



	if($(".timeLineSlid").length){

		$(".timeLineSlid.simple").slick({
			arrows:false,
			dots:true,
			infinite:false,
			responsive: [
			  {
			    breakpoint: 1200,
			    settings: {
			    	slidesToShow: 3,
			    	slidesToScroll: 3,
			    }
			  },
			  {
			    breakpoint: 992,
			    settings: {
			    	slidesToShow: 2,
			    	slidesToScroll: 2,
			    }
			  },
			  {
			    breakpoint: 768,
			    settings: {
			    	slidesToShow: 1,
			    	slidesToScroll: 1,
			    	fade:true,
			    	// variableWidth: true,
			    	// dots:false,

			    }
			  }
			]

		});

		$(".timeLineSlid.slidNav:not(.vType)").slick({
			asNavFor:'.timeLineSlid.slidContent:not(.vType)',
			focusOnSelect: true,
			infinite:false,
			centerMode: true,
			dots:false,
			variableWidth: true,
		    adaptiveHeight: true,
		    swipeToSlide:true,
		    touchThreshold:3,
	        prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
	    	nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>'

		});
		$(".timeLineSlid.slidContent:not(.vType)").slick({
			asNavFor:'.timeLineSlid.slidNav:not(.vType)',
			infinite:false,
			fade:true,
			arrows:false,

		});


		//vType
		$(".timeLineSlid.slidNav.vType").slick({
			asNavFor:'.timeLineSlid.slidContent.vType',
			slidesToShow: 3,
			focusOnSelect: true,
			centerMode: true,
			infinite:false,
			dots:false,
		    swipeToSlide:true,
		    vertical:true,
		    verticalSwiping:true,

		    prevArrow:'<button class="slick-prev slick-arrow"><i class="fa fa-angle-left"></i></button>',
			nextArrow:'<button class="slick-next slick-arrow"><i class="fa fa-angle-right"></i></button>',
			responsive: [
			  {
			    breakpoint: 992,
			    settings: {
			      vertical:false,
			      verticalSwiping:false,
			      variableWidth: true,
			    }
			  }
			]


		});
		$(".timeLineSlid.slidContent.vType").slick({
			asNavFor:'.timeLineSlid.slidNav.vType',
			infinite:false,
			fade:true,
			arrows:false,
		});



	}


	if($(".scrollAnimate").length){
		$(".scrollAnimate").each(function(){
			//default=fadeInUp
			animateClass=$(this).attr('data-animateClass');
			animateClass=(animateClass==undefined || animateClass=="") ? 'fadeInUp':animateClass;
			console.log(animateClass);
			$(this).scrollAnimate({animate:animateClass});
		});
	}


	if($(".scrollMove").length){
		if(!mobileType){
			$(".scrollMove").each(function(){
				$(this).scrollAnimate({animate:'scrollMove'});
			});
		}
	}


	if($('.pageLoading').length){
		$(window).load(function(){
        	setTimeout(function(){$('.pageLoading').fadeOut(300)},100);
        });
	}

});


if($("#googleTranslate").length){
	function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'ja,zh-CN,zh-TW'}, 'googleTranslate');}
	$('body').append('<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>');
}


$(".proList .itemList .item .itemTitle").each(function(i){
    var divH = $(this).height();
    var $p = $("span", $(this)).eq(0);
    while ($p.outerHeight() > divH) {
        $p.text($p.text().replace(/(\s)*([a-zA-Z0-9]+|\W)(\.\.\.)?$/, "..."));
    };
});
