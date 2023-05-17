<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
<div class="title-group text-center text-vcenter">
		<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) > 1):?>
                <a class="slick-prev" data-target="#slidblock04"><i class="fa fa-angle-left"></i></a>
		<?php endif?>
                <span><?php echo $this->data['layoutv2']['banner2_title']?></span>
		<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) > 1):?>
                <a class="slick-next" data-target="#slidblock04"><i class="fa fa-angle-right"></i></a>
		<?php endif?>
</div>
<?php // 如果是要放影片 則要將swipebox-video 加入?>
<div class="slidblock" id="slidblock04">
	<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
	 <div class="imgtxt tworow"><a class="img " href="<?php echo $v['url1']?>" title="影片名稱"><img src="<?php echo $v['pic1']?>" class="wCenter_hCenter"></a><a href="<?php echo $v['url1']?>" class="txt"><p><span class="oneline"><?php echo $v['topic']?></span><span class="oneline"><?php echo $v['detail']?></span></p></a></div>
	<?php endforeach?>

</div>
<?php endif?>
<?php /* //備份用
<div class="title-group text-center text-vcenter">
                <a class="slick-prev" data-target="#slidblock04"><i class="fa fa-angle-left"></i></a>
                <span>廣告區</span>
                <a class="slick-next" data-target="#slidblock04"><i class="fa fa-angle-right"></i></a>
</div>

<div class="slidblock" id="slidblock04">
  <div class="imgtxt tworow"><a class="img swipebox-video" href="https://www.youtube.com/watch?v=48GI9GB0VEk" title="影片名稱"><img src="images/index02/video-2.jpg"></a><a href="" class="txt"><p><span class="oneline">影片名稱標題</span><span class="oneline">文字敘述</span></p></a></div>
  <div class="imgtxt tworow"><a class="img swipebox-video" href="https://www.youtube.com/watch?v=48GI9GB0VEk" title="影片名稱"><img src="images/index02/video-1.jpg"></a><a href="" class="txt"><p><span class="oneline">影片名稱標題</span><span class="oneline">文字敘述</span></p></a></div>
  <div class="imgtxt tworow"><a class="img swipebox-video" href="https://www.youtube.com/watch?v=48GI9GB0VEk" title="影片名稱"><img src="images/index02/video-2.jpg"></a><a href="" class="txt"><p><span class="oneline">影片名稱標題</span><span class="oneline">文字敘述</span></p></a></div>
  <div class="imgtxt tworow"><a class="img swipebox-video" href="https://www.youtube.com/watch?v=48GI9GB0VEk" title="影片名稱"><img src="images/index02/video-1.jpg"></a><a href="" class="txt"><p><span class="oneline">影片名稱標題</span><span class="oneline">文字敘述</span></p></a></div>
  <div class="imgtxt tworow"><a class="img swipebox-video" href="https://www.youtube.com/watch?v=48GI9GB0VEk" title="影片名稱"><img src="images/index02/video-2.jpg"></a><a href="" class="txt"><p><span class="oneline">影片名稱標題</span><span class="oneline">文字敘述</span></p></a></div>
</div>
*/ ?>


<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>

    <?php $this->data['BODY_END'] .= <<<'XXX'

    
    <script type="text/javascript">
        $(function(){
            $(".swipebox-video").swipebox();              

            $(".slick-next").click(function() {$($(this).data("target")).slick("slickNext");});
            $(".slick-prev").click(function() {$($(this).data("target")).slick("slickPrev");});
            
            $("#slidblock04").slick({
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