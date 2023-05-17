<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
	<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) > 1):?>
<div class="slidcontrol wCenter_hCenter">
      <a class="floatleft r100 slick-prev " data-target="#slidblock07"><i class="fa fa-angle-left"></i></a>                
      <a class="floatright r100 slick-next" data-target="#slidblock07"><i class="fa fa-angle-right"></i></a>
</div>
	<?php endif?>
<div class="slidblock" id="slidblock07">
	<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
  <div class="imgtxt"><a <?php if(isset($v['url']) && $v['url']):?>href="<?php echo $v['url']?>"<?php endif?> class="img"><?php if(isset($v['pic']) && $v['pic']):?><img src="<?php echo $v['pic']?>" class="wFull_hCenter"><?php endif?></a></div>
  <?php endforeach?>        
</div>
<?php endif?>

<?php /* //備份用
<div class="slidcontrol wCenter_hCenter">
      <a class="floatleft r100 slick-prev " data-target="#slidblock07"><i class="fa fa-angle-left"></i></a>                
      <a class="floatright r100 slick-next" data-target="#slidblock07"><i class="fa fa-angle-right"></i></a>
</div>
<div class="slidblock" id="slidblock07">
  <div class="imgtxt"><a href="" class="img"><img src="images/index03/ad-4.jpg"></a></div>
  <div class="imgtxt"><a href="" class="img"><img src="images/index03/ad-5.jpg"></a></div>
  <div class="imgtxt"><a href="" class="img"><img src="images/index03/ad-6.jpg"></a></div>
  <div class="imgtxt"><a href="" class="img"><img src="images/index03/ad-4.jpg"></a></div>
  <div class="imgtxt"><a href="" class="img"><img src="images/index03/ad-5.jpg"></a></div>          
</div>
*/ ?> 

<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>

    <?php $this->data['BODY_END'] .= <<<'XXX'

    
    <script type="text/javascript">
        $(function(){

            $(".slick-next").click(function() {$($(this).data("target")).slick("slickNext");});
            $(".slick-prev").click(function() {$($(this).data("target")).slick("slickPrev");});

            $("#slidblock07").slick({
                dots: false,
                arrows:false,             
                infinite: false,                
                variableWidth:false,
                speed: 300,
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