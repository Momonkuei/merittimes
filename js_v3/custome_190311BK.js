

//setPoint
//if has mbPanel.js then setPoint=mbPanel.js config, else set here
var setPoint=(setPoint==undefined)?786:setPoint;

var mobileType=mobileViewPoint(setPoint);
function mobileViewPoint(viewPoint){
    viewPoint=(viewPoint>0)?viewPoint:768;
    viewPoint='(max-width: '+viewPoint+'px)';
    viewPoint=window.matchMedia(viewPoint).matches;
    return viewPoint;
}





$(function() {



    //===================================================================
    // header
    //===================================================================

        $(window).on('load resize',function(){
            if(!$(".header.disabled").length){
                if($(".header").length){
                    var headPos=$(".header").offset().top+$(".header").outerHeight();
                    var headH=$(".header").outerHeight();
                    var headOver=$(".header").data("overlay");
                    $("body").css("padding-top",0);
                    if(headOver!=true || $(".banner").length<1){
                        $("body").css("padding-top",headH);
                    }
                }
            }
        });





        //捲動視窗toggleClass
        var headerHeight =!$(".header").length?0:$(".header").height();
        var bannerPosT   =!$(".banner").length?0:$(".banner").offset().top;
        $(window).scroll(function(){
            var bannerHeight =($(".slideBanner").length>0)?($(".slideBanner .slideItem").first().height()):($(".banner").height());
            if($(".headerType4").length>0){bannerHeight+=$(".navMenuBlock").height();}
            var showScrollHead=(bannerPosT+bannerHeight);
            if($(window).scrollTop()>showScrollHead){
                $(".header").addClass("scroll");
            }else{
                $(".header").removeClass("scroll");
            }
            return false;
        });


        //!!!fix Header navMenu subMenu pos (項目過多 or 超過螢幕時次選單位置)

        if($(".hamburger").css("display")=="none"){

            $("body").on('mouseenter',".navMenu .moreMenu:not(.multiMenu)",function(){


                // console.log("hoverin");

                var menuViewSpace=40; //不貼邊

                var $subMenu=$(this).children("ul");
                var subMenuHeight=$subMenu.height();
                var subMenuWidth=$subMenu.width();
                var headerHeight =!$(".header").length?0:$(".header").height();
                var menuView=$(window).height()-headerHeight-menuViewSpace;
                var subMenuPosT=$(this).position().top;
                var subMenuPosL=$(this).parent().offset().left+$(this).parent().width();



                //選單顯示超過螢幕換左邊 （normal)
                var menuPosL=$subMenu.offset().left+(subMenuWidth*2);
                if(menuPosL>$(window).width()){
                    $subMenu.css({"transition":"none","left":"-100%","right":"auto"});
                }




                //超過螢幕高
                if(subMenuHeight>menuView){
                    $subMenu.addClass("overEdge");
                    $subMenu.css({
                        "max-height":menuView,
                    });
                }


                //上層超過螢幕高
                if($(this).parent(".overEdge").length){

                    // subMenuPosT=$(this).position().top+$(this).parents(".navMenu").height();
                    subMenuPosT=$(this).position().top+$('header').height();
                    subMenuPosL-=20;
                    subMenuPosB='auto';

                    //次層選單顯示超過螢幕換左邊
                    if(subMenuPosL+(subMenuWidth*2)>$(window).width()){subMenuPosL=$(this).parent().offset().left-subMenuWidth;}

                    //次層選單顯示超過燭幕高
                    if((subMenuPosT+subMenuHeight)>$(window).height()){
                        subMenuPosT='auto';
                        subMenuPosB=menuViewSpace;
                    }

                    $subMenu.css({
                        "position":"fixed",
                        "top":subMenuPosT,
                        "bottom":subMenuPosB,
                        "left":subMenuPosL,
                        "right":"auto",
                        "width":subMenuWidth,
                        "transition":"none",
                        "z-index":"20",

                    });


                }

                //次選單位置超過螢幕高 (上層沒有超過螢幕高)
                if($(this).parents(".moreMenu").length && $(this).parent().hasClass('overEdge') == false ){

                    if((subMenuPosT+subMenuHeight)>menuView){
                        //次層選單顯示超過螢幕換左邊
                        if(subMenuPosL+(subMenuWidth*2)>$(window).width()){subMenuPosL=$(this).parent().offset().left-subMenuWidth;}

                        $subMenu.css({
                            "position":"fixed",
                            "top":"auto",
                            "bottom":menuViewSpace,
                            "left":subMenuPosL,
                            "right":"auto",
                            "transition":"none",
                            "z-index":"20",
                        });
                    }
                }



              });
            $("body").on('mouseleave',".navMenu .moreMenu:not(.multiMenu)",function(){
                // console.log("hoverout");
                var $subMenu=$(this).children("ul");
                 $subMenu.removeClass("overEdge");
                 $subMenu.attr("style","");
             });

            // multimenu

                //load or resize fix menu
                $(window).on('load resize',function(){$(".navMenu .moreMenu.multiMenu").each(function(){fixMultiMenuPos($(this)); $(this).css({'position':'','overflow':''}); }); });
                //hover to fixmenu
                $("body").on('mouseenter',".navMenu .moreMenu.multiMenu",function(){fixMultiMenuPos($(this));});
                $("body").on('mouseleave',".navMenu .moreMenu.multiMenu",function(){$(this).css({'position':'','overflow':''});});

                function fixMultiMenuPos($target){

                    var $tmp_targert=($target.length) ? $target.children("ul") : $(".navMenu .moreMenu.multiMenu>ul");
                        $tmp_targert.css({'max-width':'none','padding':'1em 0'});
                        $tmp_targert.children("li").css({'max-width':'none'});

                    var tmp_length=$tmp_targert.children("li").length;
                    var tmp_width=$tmp_targert.children("li").first().outerWidth();

                    var $tmp_screen = $('.header .navBar');

                    //ul寬 = li項目數量 x li寬
                    tmp_widthSet=(tmp_width*tmp_length);
                    $tmp_targert.css('width',tmp_widthSet);


                    //設定位置對齊在母層左邊
                    $tmp_targert.closest('.multiMenu').css({'position':'relative','overflow':'visible'});
                    $tmp_targert.css({'left':'0','right':'0','transform':'none'});


                    //超過靠右
                    if(tmp_widthSet+$tmp_targert.offset().left > $tmp_screen.innerWidth()+$tmp_screen.offset().left){

                        $tmp_targert.closest('.multiMenu').css({'position':'','overflow':''});
                        $tmp_targert.css({'right':'0','left':'auto'});
                    }

                    //置中
                    if(tmp_widthSet>$tmp_screen.innerWidth()){

                        //如果 > screen width ， ul寬 = 最大橫排個數
                        tmp_maxitem=Math.floor($tmp_screen.innerWidth() / tmp_width);
                        tmp_widthSet= (tmp_maxitem*tmp_width);
                        $tmp_targert.css('width',tmp_widthSet);

                        $tmp_targert.parent('.multiMenu').css({'position':'','overflow':''});
                        $tmp_targert.css({'right':'','left':'','transform':''});

                        //將子項寬改設為% (避免win捲軸產生斷行)
                        $tmp_targert.children("li").css('max-width',Math.floor((100/tmp_maxitem)+'%'));
                    }


                    //如果 h > window h70% ， 寬+32 (有捲軸)
                    if( ( $tmp_targert.height() > $(window).height()*.8) ){
                        tmp_widthSet = (tmp_widthSet+32);
                        $tmp_targert.css('width',tmp_widthSet);
                    }






                }




            //only for safrai or have slick block
                function dofixMenuAction() {
                    var fixMenuAction=false;
                    if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1){ fixMenuAction=true; }
                    if($(".slick-slider").length){ fixMenuAction=true;}
                    return fixMenuAction;
                }


                var fixMenu=dofixMenuAction();
                if(fixMenu) {
                    $("body").on('mouseenter',".navMenu .moreMenu:not(.multiMenu)",function(){
                           if($(this).parent(".overEdge").length){
                               var $subMenu=$(this).children("ul");
                               $subMenu.clone().appendTo($(this).parent(".overEdge").parent()).addClass("NavMenuCloneItem");
                               $subMenu.hide();
                               return false;
                           }
                    });
                    $("body").on('mouseleave',".navMenu .moreMenu:not(.multiMenu)",function(){
                           var $subMenu=$(this).children("ul");
                           if($(this).parent(".overEdge").length){
                                $subMenu.show();
                               return false;
                            }
                    });
                    $("body").on('mouseenter',".NavMenuCloneItem",function(){
                        $(this).addClass('over');
                           $(".NavMenuCloneItem:not(.over)").remove();
                    });
                    $("body").on('mouseleave',".NavMenuCloneItem.over",function(){
                        $(this).remove();
                    });
                    $("body").on('mouseenter',".navMenu>li",function(){
                           $(".NavMenuCloneItem").remove();
                    });
                }
            // end  safrai or have slick block


        }//end fix header navMenu subMenu pos








        //hamburger click open menu
        $(".hamburger").click(function(){$(".hamburger,.navMenu").toggleClass("open");});


        //rwd hamburger & navmenu  (縮放視窗判斷漢堡及選單隱藏)
        $(window).on('load resize',function(){
            if($(".hamburger").css("display")=="none"){
                $(".hamburger,.navMenu").removeClass("open");
            }
        });


        //子選單手機版時點擊展開(不直接轉頁)
        $(".navMenu .moreMenu a,.topLinkMenu .moreMenu a").click(function(){
            if($(".hamburger").css("display")!="none"){
                if($(this).siblings("ul").length<1){
                    window.location.href=$(this).attr("href");
                }else{
                    $(this).parent().siblings().find(".open").removeClass("open"); //先關閉其他子選單
                    $(this).siblings("ul").toggleClass("open");
                   return false;

                }
            }
        });
        //手機版，點下方選單，上方選單隱藏
        $(".topLinkMenu .moreMenu a").click(function(){
             $(".hamburger,.navMenu").removeClass("open");
        });
        //手機版，點上方選單，下方選單隱藏
        $(".hamburger").click(function(){
             $(".topLinkMenu .moreMenu ul").removeClass("open");
        });


        //手機版，向下捲隱藏選單，向上捲顯示選單
        var nowPos=0;
        var tmpPos=0;
        $(window).on('load resize scroll',function(){

            $(".moreMenu ul").removeClass("open");
            if(!($(".hamburger").css("display")=="none")){
                nowPos=$(this).scrollTop();
                if(!$(".navMenu").hasClass("open") && nowPos>$(".header").height()){ //上、下選單皆未打開子選單且滾動超過header時才作用

                    if(nowPos>tmpPos){
                        // console.log("scrolldown");
                        $(".header").stop().attr("data-scroll","down");
                        // $(".header").stop().css("top","-100%");
                        $(".topLink").css("bottom","-100%");
                    }else{
                        // console.log("srollup");
                        $(".header").stop().attr("data-scroll","up");
                        // $(".header").stop().css("top","");
                        $(".topLink").css("bottom","");
                    }
                    tmpPos=nowPos;

                }
            }else{

                $(".header").attr("data-scroll","");
                // $(".header").css("top","");
                $(".topLink").css("bottom","");

            }

            return false;

        });


        //end Header



    //===================================================================
    // banner
    //===================================================================


        if($(".banner.bgFix").length>0){
            var bgFixH=$(".banner").height();

            $(".banner.bgFix").css({
                "transition":"none"
            });
            $(".banner.bgFix img").css({
                "min-height":bgFixH,
                "min-width":"100%",
            });

            function bannerH(nowPos){

                new_bannerH=(nowPos<=0)?bgFixH:bgFixH-nowPos;
                return new_bannerH;
            }
            $(window).scroll(function(){
                nowPos=$(window).scrollTop();
                isScrollBottom = ( ( $(document).innerHeight()-$(window).height() ) - nowPos <= 5);
                if(!isScrollBottom){
                    // $(".banner.bgFix").css("height",bannerH(nowPos));
                }
                return false;
            });
        }



    //===================================================================
    // 設定預設圖 class='itemImg noneImg'
    //===================================================================
        $(window).load(function() {

            $('img').each(function() {
               imgPath=(typeof imgPath === 'undefined' || !imgPath)?'images/':imgPath;
               var error = false;
               var imgType=$(this).attr('src').split('.');
                   imgType=imgType[imgType.length-1];

               if (!this.complete) {error = true;console.log('complete error');}
               if (imgType!='svg' && typeof this.naturalWidth != "undefined" && this.naturalWidth == 0) {error = true;console.log('naturalwidth error');}
               if (imgType=='svg') {
                        var imgSrc=$(this)[0].src;
                        // $.get(imgSrc, function(svgxml){

                        //         // console.log( 'svgxml: '+ typeof svgxml );
                        //         var attrs = svgxml.documentElement.attributes;

                        //         // console.log( 'attrs: '+ typeof attrs );
                        //         // console.log( 'img: '+ attrs.width.value + 'x' + attrs.height.value );
                        //         thisStatus = attrs.width.value;




                        //     }).fail(function(){
                        //         console.log('false'+imgSrc);
                        //         console.log('---'+thisStatus);
                        //         thisStatus = 'wwww';
                        //     });

               }

               if(error){
                    if($(this).parents('.itemImg').length>0){
                        $(this).parents('.itemImg').addClass('noneImg');
                    }else{
                        // $(this).parent().addClass('noneImg');
                        // $(this).parent().css('height',$(this).parent().outerWidth());
                        $(this).addClass('noneImg');
                        $(this).css({'width':'auto','height':'auto'});
                    }
                    imgPath=(typeof ml_key === 'undefined' || !ml_key)? imgPath :('images/'+ml_key+'/');
                    this.src=imgPath+'default-img.svg';
                    $(this).fadeIn();
                }
             });

         });


    //===================================================================
    // 判斷圖大小 顯示 寬或高100% (被裁切的圖)
    //===================================================================
        $('.itemList:not(.waterPhotos) .itemImg img').hide();
        $(window).load(function() {
            $('.itemList:not(.waterPhotos) .itemImg img').each(function() {

                if(this.complete){

                    // 判斷外盒大小
                    var boxW=$(this).parent(".itemImg").innerWidth();
                    var boxH=$(this).parent(".itemImg").innerHeight();

                    var imgW=$(this).outerWidth();
                    var imgH=$(this).outerHeight();

                    // 判斷圖本身短邊的100%
                    if(imgW<imgH)      {setW="100%";setH="auto";}
                    else if(imgW>imgH) {setW="auto";setH="100%";}
                    else if(imgW==imgH){
                        //外盒橫式或正方
                        if   (boxW>=boxH){setW="100%";setH="auto";}
                        //外盒真式
                        else {setW="auto";setH="100%";}
                    }

                    $(this).css({"width":setW,"height":setH,"max-width":"none","max-height":"none" }).fadeIn();

                }
             });
         });



    //==================================================================
    //打開或關閉目標  data-target
    // .openBtn
    // .closeBtn
    // .toggleBtn
    //===================================================================

        //open target
        $(".openBtn").on('click touchend',function(){
            $(".open").removeClass("open");
            $($(this).data("target")).addClass("open");
            $("body").css("overflow","hidden");
            return false;
        });

        //close target
        $(".closeBtn").on('click touchend',function(){
            $($(this).data("target")).removeClass("open");
            $("body").css("overflow","auto");
            return false;
        });

        //toggle target
        $(".toggleBtn").on('click touchend',function(){
            $($(this).data("target")).toggleClass("open");
            $("body").css("overflow","auto");
            return false;
        });



    //===================================================================
    //讓盒子高=視窗高(扣除置頂及置底高度)
    //NoOverTop、NoOverBottom 浮動置頂(底)不壓到其他DIV
    //===================================================================


        $(window).on('load resize',function(){
            $(".winH").each(function(){
                var topH    = $($(this).attr('data-top')).height();
                var bottomH = $($(this).attr('data-bottom')).height();
                $(this).css('height',setWinH(topH,bottomH));
            });
        });



        function setWinH(topH,bottomH) {
            topH=(topH != null )?topH:0;
            bottomH=(bottomH != null)?bottomH:0;
            var winH=$(window).height();
            var setH=winH-topH-bottomH;
            return setH;
        };





    //==================================================================
    // sideAD 側邊廣告
    //===================================================================
    if( $('.sideAD').length ){
        if(!mobileType){
            scrollToggle('.sideAD',300,'active',false);
        }
    }



    //==================================================================
    // #gotop 移動到最上面
    //===================================================================

        if($('#gotop').length){
            $("#gotop").click(function() {
                jQuery("html,body").animate({
                    scrollTop: 0
                }, 1000);
            }); //end #gotop

            if(!mobileType){scrollToggle('#gotop',300,'active',true); }
            if(mobileType){scrollUpDownToggle('#gotop','active',true); }
        }



    //==================================================================
    // scrollTo 移動到target
    //===================================================================

        if($('[data-scrollTo]').length){
            $('[data-scrollTo]').on('click',function(e) {
                var $target= $($(this).attr('data-scrollTo'));
                if ($target.length){
                    var targetTop=$target.offset().top-100;
                    jQuery("html,body").animate({
                        scrollTop: targetTop
                    }, 500);
                    return false;
                }
            }); //end scrollTo
        }


    //==================================================================
    // #showCart 側邊結帳icon
    //===================================================================

        if($('#showCart').length){

            if(!mobileType){scrollToggle('#showCart',500,'active',true); }
            if(mobileType){scrollUpDownToggle('#showCart','active',true); }
        }


    //===================================================================
    //文字垂直輪播 ( class=.marquee)  (需搭配css)
    //===================================================================

        var marqueeTarget = ".marquee";

        if($(marqueeTarget).length){

            if(!mobileType){
                var $marqueeBlock = $(marqueeTarget+" ul"),
                    $marqueeItem = $marqueeBlock.append($marqueeBlock.html()).children(),
                    marqueeHeight = $('.marquee').height() * -1,
                    scrollSpeed = 600,
                    timer,
                    speed = 3000 + scrollSpeed;


                $marqueeItem.hover(function(){
                    clearTimeout(timer);
                }, function(){
                    timer = setTimeout(marqueeAD, speed);
                });

                $('a').focus(function(){
                    this.blur();
                });

                function marqueeAD(){
                    var nowPos = $marqueeBlock.position().top / marqueeHeight;
                    nowPos = (nowPos + 1) % $marqueeItem.length;
                    $marqueeBlock.animate({
                        top: nowPos * marqueeHeight
                    }, scrollSpeed, function(){
                        if(nowPos == $marqueeItem.length / 2){
                            $marqueeBlock.css('top', 0);
                        }
                    });
                    timer = setTimeout(marqueeAD, speed);
                }
                timer = setTimeout(marqueeAD, speed);
            }

        } //end marquee




    //===================================================================
    // tabList (頁籤切換)
    //===================================================================

        $(".tabLabel").click(function(){
            $(this).siblings(".tabLabel.active").removeClass("active");
            $(this).addClass("active");
            jQuery("html,body").animate({
                scrollTop: $(this).offset().top-$(this).height()*2
            }, 300);
        });
        //end tabList




    //===================================================================
    //限字數
    //===================================================================
        $('[data-txtlen]:not([data-txtlen=""])').each(function(){
            $(this).text(txtlen($(this).text(),$(this).data("txtlen")));
        });
        function txtlen(txt,len){
            if(txt.length>len){
                return txt.substr(0,len)+'...';
            }
        }






    //===================================================================
    //form
    //===================================================================

        function numCal(calType,nowVal){

            if(calType=="-"){
                var newVal=parseInt(nowVal)-1;
                newVal=(newVal<=0)?1:newVal;
            }
            if(calType=="+"){
                var newVal=parseInt(nowVal)+1;
            }

            return newVal;
        }

        //if not at v3 environment work
        if (typeof ml_key === 'undefined' || !ml_key){

            $(".numSet .minus").click(function(){
                var nowVal=$(this).siblings("input").val();
                $(this).siblings("input").val(numCal("-",nowVal));
                $(this).siblings("input").trigger("change");
                return false;

            });

            $(".numSet .add").click(function(){
                var nowVal=$(this).siblings("input").val();
                $(this).siblings("input").val(numCal("+",nowVal));
                $(this).siblings("input").trigger("change");
                return false;

            });
        }


        //fix input date (with jquery-ui-datepicker)
        var datefield=document.createElement("input")
            datefield.setAttribute("type", "date")
        if (datefield.type!="date"){
            jQuery(function($){
                $('input[type="date"]').datepicker();
            })
        }


        // if($(".stickyFilter").length){
        //     $(window).on('load scroll resize',function(){
        //         $('body').css('padding-top',$('.header').height()+$('.stickyFilter').height());
        //         $('.stickyFilter').css('top',$(".header").height());
        //     });

        // }






    //===================================================================
    //google map
    //===================================================================
        if($(".googleMap iframe").length){
            $(".googleMap iframe").css("pointer-events","none");
            $(".googleMap").click(function(){
                $(this).find("iframe").css("pointer-events","");
            });
            $(".googleMap").mouseleave(function(){
                $(this).find("iframe").css("pointer-events","none");
            });
        }



    //===================================================================
    // google translate
    //===================================================================

        if($(".googleTranslate").length){

            $("body").bind("DOMSubtreeModified", function() {
              $target=$("body>*").first();
              $modifyTarget=(mobileType) ? $(".mbPanel_funNav.navTop,.mbPanel_side") : $(".header");
              if($target.attr('class')=="skiptranslate" && $target.attr('style') !='display: none;'){
                  $modifyTarget.css("top","40px");
              }else{
                  $modifyTarget.css("top","");
              }
            });

            //for firefox at toplink
            if(navigator.userAgent.indexOf('Firefox') != -1){
                if($(".googleTranslate").parents(".moreMenu").length){
                    $(".googleTranslate").parents(".moreMenu").css("overflow","visible");
                }
            }
        }







    //===================================================================
    //footer site map
    // fotter type3 , mobile size => title link return false
    //===================================================================
       var footerSiteMapType3="footer .siteMap.type3";
       if($(footerSiteMapType3).length){
            if(mobileType){
                $(footerSiteMapType3).children("li").children("a").attr("href","javascript:void(0)");
            }
       }
    //===================================================================
    //GDPR
    //===================================================================
        if ( $('.GDPR').length ){
            var gdprBlock = $('.GDPR');
            var gdprBtn  = $('.GDPR__btn');
            setTimeout(function(){
                gdprBlock.addClass('active');
            },1000);
            gdprBtn.on('click',function(){
                $.get('gdprcookie.php',function(){
                    gdprBlock.removeClass('active');
                    setTimeout(function(){
                        gdprBlock.remove();
                    },1000);
                });
            });
        }





});//end $(function)





    //==================================================================
    // 判斷瀏覽器
    // if(Sys.ie)
    // if(Sys.firefox)
    // if(Sys.chrome)
    // if(Sys.opera)
    // if(Sys.safari)
    //==================================================================
        var Sys = {};
        var ua = navigator.userAgent.toLowerCase();
        var s;
        (s = ua.match(/rv:([\d.]+)\) like gecko/)) ? Sys.ie = s[1] :
        (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
        (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
        (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
        (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
        (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;



    //==================================================================
    //fix input number (ie)
    //==================================================================

        IEInputFix();
        function IEInputFix(){
            if(Sys.ie){
               $('input[type="number"]')
               .attr('disabled',true)
               .css({
                    'line-height':'100%',
                    'border':'1px solid #999',
                    'color':'#333',
                })
               .wrap('<span class="numSet"></span>')
               .after('<button type="button" class="add">+</button>')
               .before('<button type="button" class="minus">-</button>');
            }
        }


    //==================================================================
    // 讀ajax
    // file，檔案
    // method，模式
    // val,值
    // block 重讀的區塊
    // callback
    //==================================================================

      function ajaxload(file,method,val,block,callback){
        var method=(method==null)?"":"method="+method;
        var val=(val==null)?"":"val="+val;
        var dataurl=file+"?"+method+'&'+val;
        $.ajax({
          url: dataurl,
          cache: false,
          success: function(data){
            // console.log(data);
            $(block).html(data);
            if(callback){
                callback();
            };
          }
        });
      }




    //==================================================================
    // 判斷目前向上或向下滾動
    // winScrollStatus = set scorll status ( down / up / unscroll)
    //==================================================================
        var winScrollStatus='unScroll';
        var win_now_pos = 0;
        var win_tmp_pos = 0;
        $(window).on('scroll load resize',function() {
            win_now_pos=$(this).scrollTop();
            if ( win_now_pos > win_tmp_pos ) {
                winScrollStatus = 'scrollDown';
            }else if( win_now_pos < win_tmp_pos ){
                winScrollStatus = 'scrollUp';
            }else if( win_now_pos = win_tmp_pos = 0){
                winScrollStatus = 'unScroll';
            }
            win_tmp_pos = win_now_pos;
        });






    //==================================================================
    // 視窗捲動超過設定值，目標顯示或隱藏
    // scrollToggle (scroll after scrollTop then show or hide)
    // target = show/hide target
    // actPos = show/hide scrollTop
    // activeClass = when show/hide add/remove Class
    // jsShowHide = use js show() / hide()
    //==================================================================

        function scrollToggle(target,actPos,activeClass,jsShowHide){

            $(window).on('scroll load resize',function() {

                if ( ($(window).scrollTop() > actPos) && (!$(target).hasClass(activeClass)) ) {
                    $(target).addClass(activeClass);
                    if(jsShowHide){$(target).stop().fadeIn(1000);}
                    return false;
                } else if( ($(window).scrollTop() <= actPos) ){
                    $(target).removeClass(activeClass);
                    if(jsShowHide){$(target).stop().fadeOut(100);}
                    return false;
                }

            });

        }// end function scrollToggle






    //==================================================================
    // 視窗捲動向上／向下，目標　顯示／隱藏
    // scrollUpDownToggle ( scroll down/up -> add/remove class or show()/hide()  )
    // target = toggle target
    // activeClass = scroll up/down -> add/remove class
    // jsShowHid = use js toggle
    //==================================================================
        function scrollUpDownToggle(target,activeClass,jsShowHide){
            $(window).on('scroll load resize',function() {
                var isActed=$(target).hasClass(activeClass);
                // console.log(winScrollStatus);

                switch(winScrollStatus){

                    default:
                    case 'unScroll':
                        $(target).stop().removeClass(activeClass);
                        if(jsShowHide){$(target).stop().hide();}
                        break;

                    case 'scrollDown':
                        if(isActed){
                            $(target).stop().removeClass(activeClass);
                            if(jsShowHide){$(target).stop().fadeOut();}
                        }
                        break;

                    case 'scrollUp':
                        if(!isActed){
                            $(target).stop().addClass(activeClass);
                            if(jsShowHide){$(target).stop().fadeIn();}
                        }
                        break;

                } // end switch
                return false;
            });
        }// end function scrollUpDownToggle











    //!!!!!!!!!如有亮燈+收合選單，先call亮燈，再call收合，ex：產品側邊收合選單


    //===================================================================
    //選單亮燈
    //data-active="" 指定加active的tag
    //data-novalue="" 亮燈時是否判斷url後方的參數，設true，不判斷參數
    //data-multimenu="" 多層選單，設true，子選單active，父選單也會active
    //data-defactive="active" 在html已有預設active的項目
    //SAMPLE CODE <div class="navlight" data-active="li" data-multimenu="true" data-novalue="true">
    //===================================================================
        navlight(".navlight");

        function navlight(navtarget){

            $(navtarget).each(function(){
                var novalue=$(this).data("novalue");
                var multimenu=$(this).data("multimenu");
                var activetarget=$(this).data("active");
                var defactive=$(this).data("defactive");
                var defactiveid=$(this).data("defactiveid");
                var navtargets=$(this).find(activetarget);
                var nowpage = window.location.pathname.split('/');
                var nowpage_novalue=window.location.href.split('/');
                var nowpage_values =window.location.href.split('?');
                var actived=(defactive=='active')?true:false;

                nowpage=(novalue)?nowpage_novalue[nowpage_novalue.length-1]:nowpage[nowpage.length-1]+"?"+nowpage_values[1];

                $(navtargets).each(function(i){

                    navurl=$(this).find("a").attr("href");
                    //沒有預設active
                    if(actived==false){
                        $(navtargets).removeClass("active");
                        if(navurl==nowpage){
                            $(this).addClass("active");
                            if(multimenu){$(this).parentsUntil($(navtarget),activetarget).addClass("active"); }
                            actived=true;
                        }
                    }else if(defactive=='active'){

                        if( $(this).attr('id') == defactiveid ){
                            $(this).addClass('active');
                        }

                        if($(this).hasClass('active')){
                            $(this).parentsUntil($(navtarget),activetarget).addClass("active");
                        }
                    }

                });

            });

        }//END function navlight









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

        $(".togglearea").each(function(){
            togglearea($(this));
        });
        function togglearea($target){
            var items=$target.data("item");
            var title=$target.data("title");
            var content=$target.data("content");
            var nodefault=$target.data("nodefault");
            var prevent=$target.data("prevent");
            //$target.addClass("no_css_transition");               //移除css animation
            $target.find(content).hide();                          //隱藏所有選單內容
            if ($target.find(items).hasClass("active")){
                 $target.find(items+".active").siblings().find(content).hide();         //隱藏同層的其他內容
                 $target.find(items+".active").children(content).show();                //如有active則展開該項
            }
            else if (!nodefault){
                 $target.find(items+":first-child").children(content).show();                           //若無active展開第一項內容
                 $target.find(items+":first-child").children(content).parent().addClass("active");}     //並加active

            if(prevent === false || prevent==undefined){
                $target.find(title).click(function(){

                    if($(this).closest(items).hasClass("active")){
                        $target.find(items).removeClass("active");
                    }else{
                        $target.find(items).removeClass("active");
                        $(this).closest(items).addClass("active");
                    }


                    if($(this).next(content).length>0){
                        $(this).parent().siblings().find(content).slideUp(200); //同層的收合
                        $(this).next(content).stop().slideToggle(300);

                        return false;
                    }
                });
            }

        }//END function togglearea



    //===================================================================
    // 用js產生影格動畫 (keyframe)
    // <div class="playFrame" data-playFrame="js" data-playFrameData='{"frames":6,"playtime":"1s","animateName":""}'>
    //     <img src="images/default/scrolldown_frame.svg">
    // </div>
    // playFrame(物仲,設定JSON,index);
    //===================================================================

        $(function(){
            $('[data-playFrame="js"]').each(function(index){
                var playFrameData = $(this).attr('data-playFrameData') || '{"frames":"","playtime":""}';
                    playFrameData = JSON.parse(playFrameData);
                playFrame($(this),playFrameData,index);
            });
        });
        function playFrame($obj,playFrameData,index){

            var frames      = playFrameData['frames'] || 30; //影格數
            var playtime    = playFrameData['playtime'] || '1s'; //動畫時間
            var animateName = playFrameData['animateName'] || index; //動畫名稱

            var $img=$obj.children('img');  // 原圖
            var imgSrc=$img.attr('src');    // 圖路徑
            var imgFullW=playFrameData['w']*playFrameData['frames'] || $obj.width();      // 所有影格圖寬

            var imgW=playFrameData['w'] || imgFullW / frames;     // 單張影格寬
            var imgH=playFrameData['h'] || $obj.height();         // 單張影格高

            $img.css({'opacity':0});
            $obj.css({
                'display':'block',
                'width':imgW + 'px',
                'height':imgH + 'px',
                'background':'url('+imgSrc+')',
                'background-position':(-imgFullW)+'px',
                        'animation':'playFrame_animation_'+animateName+' '+playtime+' steps('+(frames)+') infinite',
                '-webkit-animation':'playFrame_animation_'+animateName+' '+playtime+' steps('+(frames)+') infinite',
            });
            $obj.after('<style>@keyframes playFrame_animation_'+animateName+' {to{ background-position: '+(-imgFullW)+'px;} from { background-position: 0;} } </style>');
        }
