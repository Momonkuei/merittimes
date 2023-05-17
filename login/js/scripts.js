/*-----------------------------------------------------------------------------------*/
/*	WORDPRESS FIXES
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function ($) {
	$('p:empty').remove();
	
	/**
	 * Newsletter widget Fixes
	 */
	$('.widget_ns_mailchimp form label').each(function(){
		var text = $(this).text();
		$(this).next().attr('placeholder', text);
	});
	
});
/*-----------------------------------------------------------------------------------*/
/*	STICKY NAVIGATION
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
"use strict";

    var menu = jQuery('.navbar'),
        pos = menu.offset();

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > pos.top + menu.height() && menu.hasClass('default') && jQuery(this).scrollTop() > 150) {
            menu.fadeOut('fast', function () {
                jQuery(this).removeClass('default').addClass('fixed').fadeIn('fast');
            });
        } else if (jQuery(this).scrollTop() <= pos.top + 150 && menu.hasClass('fixed')) {
            menu.fadeOut(0, function () {
                jQuery(this).removeClass('fixed').addClass('default').fadeIn(0);
            });
        }
    });

});
jQuery(document).ready(function() {
"use strict";
	var $offset = jQuery('.offset'),
		$navbar = jQuery('.navbar'),
		$navbarHeight = jQuery('.navbar').height();
	
	if( $navbarHeight < 103 )
		$navbarHeight = 103;
		
	$offset.css('padding-top', $navbarHeight + 'px'); 
	
	jQuery(window).resize(function() {
		$offset.css('padding-top', $navbarHeight + 'px');        
	}); 
}); 
/*-----------------------------------------------------------------------------------*/
/*	OWL CAROUSEL
/*-----------------------------------------------------------------------------------*/
/*
jQuery(document).ready(function () {
"use strict";    
     
	 jQuery(".owlcarousel").owlCarousel({
        navigation: true,
        navigationText : ['<i class="icon-left-open"></i>','<i class="icon-right-open"></i>'],
        pagination: false,
        rewindNav: false,
        items: 3,
        mouseDrag: true,
        itemsDesktop: [1200, 3],
        itemsDesktopSmall: [1024, 3],
        itemsTablet: [970, 2],
        itemsMobile: [767, 1]
    });
	
    jQuery(".owl-clients").owlCarousel({

        autoPlay: 9000,
        rewindNav: false,
        items: 6,
        itemsDesktop: [1200, 6],
        itemsDesktopSmall: [1024, 5],
        itemsTablet: [768, 3],
        itemsMobile: [480, 2],
        navigation: false,
        pagination: false

    });
	
	
    
    var owl = jQuery(".owl-portfolio-slider");

    owl.owlCarousel({
        navigation: false,
        autoHeight: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true
    });
	
    // Custom Navigation Events
    jQuery(".slider-next").click(function () {
        owl.trigger('owl.next');
    })
    jQuery(".slider-prev").click(function () {
        owl.trigger('owl.prev');
    })
    

});
*/
/*-----------------------------------------------------------------------------------*/
/*	FANCYBOX
/*-----------------------------------------------------------------------------------*/
/*
jQuery(document).ready(function () {
"use strict";
    jQuery(".fancybox-media").fancybox({
        arrows: true,
        padding: 0,
        closeBtn: true,
        openEffect: 'fade',
        closeEffect: 'fade',
        prevEffect: 'fade',
        nextEffect: 'fade',
        helpers: {
            media: {},
            overlay: {
                locked: false
            },
            buttons: false,
            thumbs: {
                width: 50,
                height: 50
            },
            title: {
                type: 'inside'
            }
        },
        beforeLoad: function () {
            var el, id = jQuery(this.element).data('title-id');
            if (id) {
                el = jQuery('#' + id);
                if (el.length) {
                    this.title = el.html();
                }
            }
        }
    });

});
*/
/*-----------------------------------------------------------------------------------*/
/*	PRELOADER
/*-----------------------------------------------------------------------------------*/
jQuery(window).load(function(){
"use strict";
	jQuery('#status').fadeOut();
	jQuery('#preloader').delay(350).fadeOut('slow');
	jQuery('body').delay(350).css({'overflow':'visible'});
});
/*-----------------------------------------------------------------------------------*/
/*	TESTIMONIALS
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
"use strict";

	if( jQuery('#testimonials li').length > 0 ){
	    jQuery('#testimonials').easytabs({
	        animationSpeed: 500,
	        updateHash: false,
	        cycle: 5000
	    });
	}

});
/*-----------------------------------------------------------------------------------*/
/*	ISOTOPE FULLSCREEN PORTFOLIO
/*-----------------------------------------------------------------------------------*/

var isotopeBreakpoints = [
    { min_width: 1680, columns: 5 },
    { min_width: 1440, max_width: 1680, columns: 5 },
    { min_width: 1024, max_width: 1440, columns: 4 },
    { min_width: 768, max_width: 1024, columns: 3 },
    { max_width: 768, columns: 1 }
];

jQuery(window).load(function () {
"use strict";

    var $container = jQuery('.full-portfolio .items');

    $container.isotope({
        itemSelector: '.item',
        layoutMode: 'fitRows'
    });

    // hook to window resize to resize the portfolio items for fluidity / responsiveness
    jQuery(window).smartresize(function() {
        var windowWidth = jQuery(window).width();
        var windowHeight = jQuery(window).height();

        for ( var i = 0; i < isotopeBreakpoints.length; i++ ) {
            if (windowWidth >= isotopeBreakpoints[i].min_width || !isotopeBreakpoints[i].min_width) {
                if (windowWidth < isotopeBreakpoints[i].max_width || !isotopeBreakpoints[i].max_width) {
                    $container.find('.item').each(function() {
                        jQuery(this).width( Math.floor( $container.width() / isotopeBreakpoints[i].columns ) );
                    });

                    break;
                }
            }
        }
    });

    jQuery(window).trigger('resize').trigger( 'smartresize' );
	//會取代原本的連結的事件，故先關閉
   /* jQuery('.filter li a').click(function () {

        jQuery('.filter li a').removeClass('active');
        jQuery(this).addClass('active');

        var selector = jQuery(this).attr('data-filter');
        $container.isotope({
            filter: selector
        });

        return false;
    });*/
    
    setTimeout(function(){
    	$container.isotope('layout');
		$container.isotope({
			filter: selector
		});
    }, 10);
 	var selector = "notexist";

    setTimeout(function(){
		$container.isotope({
			filter: "*"
		});   

    }, 600);
   
});
/*-----------------------------------------------------------------------------------*/
/*	ISOTOPE CLASSIC PORTFOLIO
/*-----------------------------------------------------------------------------------*/
jQuery(window).load(function () {
"use strict";
    var $container = jQuery('.fix-portfolio .items');
    
    $container.isotope({
        itemSelector: '.fix-portfolio .item',
        layoutMode: 'fitRows'
    });

    /*jQuery('.fix-portfolio .filter li a').click(function () {

        jQuery('.fix-portfolio .filter li a').removeClass('active');
        jQuery(this).addClass('active');

        var selector = jQuery(this).attr('data-filter');
        $container.isotope({
            filter: selector
        });

        return false;
    });*/

});
/*-----------------------------------------------------------------------------------*/
/*	MENU
/*-----------------------------------------------------------------------------------*/
/* jQuery(document).ready(function () {
"use strict";
   jQuery('.js-activated').dropdownHover({
        instantlyCloseOthers: false,
        delay: 0
    }).dropdown();
	alert("enter scripts.js5-6");


    jQuery('.dropdown-menu a, .social .dropdown-menu, .social .dropdown-menu input').click(function (e) {
        e.stopPropagation();
    });

});
*/
/*-----------------------------------------------------------------------------------*/
/*	FORM
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
"use strict";
    jQuery('.comment-form input[title], .comment-form textarea').each(function () {
        if (jQuery(this).val() === '') {
            jQuery(this).val(jQuery(this).attr('title'));
        }

        jQuery(this).focus(function () {
            if (jQuery(this).val() == jQuery(this).attr('title')) {
                jQuery(this).val('').addClass('focused');
            }
        });
        jQuery(this).blur(function () {
            if (jQuery(this).val() === '') {
                jQuery(this).val(jQuery(this).attr('title')).removeClass('focused');
            }
        });
    });
});
/*-----------------------------------------------------------------------------------*/
/*	IMAGE ICON HOVER
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
"use strict";
    jQuery('.icon-overlay a').prepend('<span class="icn-more"></span>');
});
/*-----------------------------------------------------------------------------------*/
/*	PARALLAX MOBILE
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
"use strict";
    if (navigator.userAgent.match(/Android/i) ||
        navigator.userAgent.match(/webOS/i) ||
        navigator.userAgent.match(/iPhone/i) ||
        navigator.userAgent.match(/iPad/i) ||
        navigator.userAgent.match(/iPod/i) ||
        navigator.userAgent.match(/BlackBerry/i)) {
        jQuery('.parallax').addClass('mobile');
    }

});
/*-----------------------------------------------------------------------------------*/
/*	TABS
/*-----------------------------------------------------------------------------------*/
/* 
jQuery(document).ready(function () {
"use strict";
   jQuery('.tabs.services').easytabs({
        animationSpeed: 300,
        updateHash: false,
        cycle: 5000
    });
});
jQuery(document).ready(function () {
"use strict";
	
    jQuery('.tabs.tabs-top, .tabs.tabs-side').easytabs({
        animationSpeed: 300,
        updateHash: false
    });
});
*/
/*-----------------------------------------------------------------------------------*/
/*	DATA REL
/*-----------------------------------------------------------------------------------*/
/*jQuery('a[data-rel]').each(function () {
"use strict";
    jQuery(this).attr('rel', jQuery(this).data('rel'));	
});*/
/*-----------------------------------------------------------------------------------*/
/*	TOOLTIP
/*-----------------------------------------------------------------------------------*/
/*jQuery(document).ready(function () {
"use strict";
    if (jQuery("[rel=tooltip]").length) {
        jQuery("[rel=tooltip]").tooltip();
    }
});
*//*-----------------------------------------------------------------------------------*/
/*	VIDEO
/*-----------------------------------------------------------------------------------*/
/*jQuery(document).ready(function () {
"use strict";
    jQuery('.player').fitVids();
		
});*/
/*-----------------------------------------------------------------------------------*/
/*	PRETTIFY
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
"use strict";
    window.prettyPrint && prettyPrint();
});
/*-----------------------------------------------------------------------------------*/
/*	NAV BASE LINK
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function($) {
	jQuery('a.js-activated').not('a.js-activated[href^="#"]').click(function(){
		var url = $(this).attr('href');
		window.location.href = url;
		return true;
	});
});