<section class="Bbox_1c section03 no_css_transition">
    <div>
        <div class="title-group text-center text-vcenter">
                <a class="slick-prev" data-target="#slidblock03"><i class="fa fa-angle-left"></i></a>
                <span>TITLE</span>
                <a class="slick-next" data-target="#slidblock03"><i class="fa fa-angle-right"></i></a>
        </div>
        <div class="slidblock" id="slidblock03">
          <div class="imgtxt"><a href="" class="img"><img src="" class="wFull_hFull"></a><a href="" class="txt"><p><span>文字文字文字文字文文字文字文字文字文文字文字文字文字文</span><span>$15000</span></p></a></div>
          <div class="imgtxt"><a href="" class="img"><img src="" class="wFull_hFull"></a><a href="" class="txt"><p><span>文字文字文字文字文</span><span>$15000</span></p></a></div>
          <div class="imgtxt"><a href="" class="img"><img src="" class="wFull_hFull"></a><a href="" class="txt"><p><span>文字文字文字文字文</span><span>$15000</span></p></a></div>
          <div class="imgtxt"><a href="" class="img"><img src="" class="wFull_hFull"></a><a href="" class="txt"><p><span>文字文字文字文字文</span><span>$15000</span></p></a></div>
          <div class="imgtxt"><a href="" class="img"><img src="" class="wFull_hFull"></a><a href="" class="txt"><p><span>文字文字文字文字文</span><span>$15000</span></p></a></div>
        </div>
    </div>
</section>




<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>

    <?php $this->data['BODY_END'] .= <<<'XXX'

    
    <script type="text/javascript">
        $(function(){          

            $(".slick-next").click(function() {$($(this).data("target")).slick("slickNext");});
            $(".slick-prev").click(function() {$($(this).data("target")).slick("slickPrev");});
            
            $("#slidblock03").slick({
                dots: false,
                arrows:false,             
                infinite: true,                
                autoplay: true,
                autoplaySpeed: 2000,
                
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                                {
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 3,
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 2
                                    }
                                },
                                {
                                    breakpoint: 480,
                                        settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                    }
                                }
                            
                            ]            
            });

           


        });
    </script>

XXX;

?>