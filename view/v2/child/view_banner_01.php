<?php if(0):?><!-- body_end -->
<style>
    #banner01.slidblock div     {min-height:0;height:auto;}
    #banner01.slidblock div img {margin:auto;}
</style>
<?php endif?><!-- body_end -->

<?php if(0 and isset($this->data['layoutv2'][$this->data['section']['key']])):?>
	<?php if(count($this->data['layoutv2'][$this->data['section']['key']]) > 1):?>
<div class="slidcontrol">
                <a class="slick-prev" data-target="#banner01"><i class="fa fa-angle-left"></i></a>               
                <a class="slick-next" data-target="#banner01"><i class="fa fa-angle-right"></i></a>
</div>
	<?php endif?>
<div class="slidblock" id="banner01">
	<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
		<div>
            <a href="<?php if($v['url1']!='') echo $v['url1']; else echo '/'?>" <?php if($this->data['router_method']=='index' || stristr($this->data['router_method'],'layout')):?>onclick="return false;"<?php endif?>>
                <img data-lazy="<?php if(isset($v['pic1'])) echo $v['pic1']?>" class="banner_lg">
                <img data-lazy="<?php if(isset($v['pic2'])) echo (isset($v['pic2']) && $v['pic2'])?$v['pic2']:$v['pic1']?>" class="banner_sm">
            </a>
        </div>
	<?php endforeach?> 
</div>
<?php endif?>

<?php if(isset($data[$ID])):?>
	<?php if(count($data[$ID]) > 0):?>
		<div class="slidcontrol">
			<a class="slick-prev" data-target="#banner01"><i class="fa fa-angle-left"></i></a>               
			<a class="slick-next" data-target="#banner01"><i class="fa fa-angle-right"></i></a>
		</div>
	<?php endif?>

	<div class="slidblock" id="banner01">
		<?php foreach($data[$ID] as $k => $v):?>
			<?php if(0)://SEO?>
				<?php $alt = ''?>
				<?php if($k == 0):?>
					<?php $alt = '台北防水工程'?>
				<?php elseif($k == 1):?>
					<?php $alt = '台北防水抓漏'?>
				<?php endif?>
				<?php $v['topic'] = $alt?>
			<?php endif?>
			<div><a href="<?php echo $v['url']?>"><img src="<?php echo $v['pic']?>" class="banner_lg"><img src="<?php echo $v['pic']?>" class="banner_sm"></a></div>
		<?php endforeach?>
	</div>
<?php endif?>


<?php /* //備份用
<div class="slidcontrol">
                <a class="slick-prev" data-target="#banner01"><i class="fa fa-angle-left"></i></a>               
                <a class="slick-next" data-target="#banner01"><i class="fa fa-angle-right"></i></a>
</div>

<div class="slidblock" id="banner01">
  <div><a href=""><img src="images/index02/banner-1.jpg" class="banner_lg"><img src="images/index02/banner-1-s.jpg" class="banner_sm"></a></div>
  <div><a href=""><img src="images/index02/banner-2.jpg" class="banner_lg"><img src="images/index02/banner-2-s.jpg" class="banner_sm"></a></div>
  <div><a href=""><img src="images/index02/banner-3.jpg" class="banner_lg"><img src="images/index02/banner-3-s.jpg" class="banner_sm"></a></div>
</div>
*/?>


<?php if(0):?><!-- body_end -->
<script type="text/javascript">
    $(function(){

        $(".slick-next").on('click',function() {$($(this).data("target")).slick("slickNext");});
        $(".slick-prev").on('click',function() {$($(this).data("target")).slick("slickPrev");});

        $("#banner01").slick({                
            arrows:false, 
            dots: true,            
            infinite: true,    
            speed: 300,
            autoplay: true,
            fade: true,            
        });          


    });
</script>
<?php endif?><!-- body_end -->
