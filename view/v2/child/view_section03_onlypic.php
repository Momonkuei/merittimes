  

[POS1]                




 <?php /*
            
<section class="Bbox_1c section03 no_css_transition">
    <div>
        
        <div class="slidblock" id="slidblock03">
          <div class="imgtxt"><a href="" class="img"><img src=""></a></div>
          <div class="imgtxt"><a href="" class="img"><img src=""></a></div>
          <div class="imgtxt"><a href="" class="img"><img src=""></a></div>
          <div class="imgtxt"><a href="" class="img"><img src=""></a></div>
          <div class="imgtxt"><a href="" class="img"><img src=""></a></div>
        </div>
    </div>
</section>

*/?>

<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>			
<section class="Bbox_1c section03 no_css_transition">
  <div>        
    <div class="slidblock" id="slidblock03">
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
				<?php if($v['pic'] == ''):?><?php continue?><?php endif?>				 
         <div class="imgtxt"><a href="<?php echo $v['url1']?>" class="img"><img src="<?php echo $v['pic']?>" class="wCenter_hCenter"></a></div>
				<?php endforeach?>
    </div>
  </div>
</section>
<?php endif?>





<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>

    <?php $this->data['BODY_END'] .= <<<'XXX'

    <style>
     .section03 .imgtxt a.img {padding-bottom:70%;background:none;}
    </style>

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
                slidesToScroll: 2,
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