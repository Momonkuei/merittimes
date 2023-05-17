<?php if($this->data['router_method'] == 'index'):?>
<div class="bannerBlock">
  <div class="bannerStyle01 bannerStyle01-revise">
    <div class="swiper-container bnr_s1">
      <div class="swiper-wrapper">
        <!-- <div class="swiper-slide" data-swiper-autoplay="27000">
          <div id="bgVideo" class="bgVideo"></div>
          <a class="loading"><img src="images_v4/icon/loading.png" class="animate"></a>
        </div> -->
		<?php if(isset($data[$ID])):?>
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

				<div class="swiper-slide">
				  <a href="<?php echo $v['url']?>">
					<img class="pc" src="<?php echo $v['pic1g']?>" alt="<?php echo $v['topic']?>">
					<img class="mb" src="<?php echo $v['pic2g']?>" alt="<?php echo $v['topic']?>">
				  </a>
				</div>
			<?php endforeach?>
		<?php endif?>

<?php if(0):?>
        <div class="swiper-slide">
          <a href="#">
            <img class="pc" src="images_v4/banner/indexBanner2.jpg" alt="">
            <img class="mb" src="images_v4/banner/indexBanner2_mb.jpg" alt="">
          </a>
        </div>
        <div class="swiper-slide">
          <a href="#">
            <img class="pc" src="images_v4/banner/indexBanner3.jpg" alt="">
            <img class="mb" src="images_v4/banner/indexBanner3_mb.jpg" alt="">
          </a>
        </div>
        <div class="swiper-slide">
          <a href="#">
            <img class="pc" src="images_v4/banner/indexBanner4.jpg" alt="">
            <img class="mb" src="images_v4/banner/indexBanner4_mb.jpg" alt="">
          </a>
        </div>
<?php endif?>

      </div>

      <!-- If we need pagination -->
			<div class="swiper-pagination"></div>

      <!-- Add Arrows -->
      <div class="swiper-button-next">
        <div class="banner-btn-circle"></div>
        <!-- <i class="fa fa-arrow-right" aria-hidden="true"></i> -->
        <img src="images_v4/banner/banner_01/arrowRight.svg" alt="arrowRight">
      </div>
      <div class="swiper-button-prev">
        <div class="banner-btn-circle"></div>
        <!-- <i class="fa fa-arrow-left" aria-hidden="true"></i> -->
        <img src="images_v4/banner/banner_01/arrowLeft.svg" alt="arrowLeft">
      </div>
    </div>
  </div><!-- .bannerStyle01 -->
  <?php //$scrollDownWidget='scrollDown_type1'; include 'scrollDown.php'; ?>
<?php echo $__?>
</div><!-- .bannerBlock -->
<?php endif?>


<?php //cowboy 20210511 #39951?>
<?php if($this->data['router_method'] == 'index' && 0):?>
<section class="cowboyBanner">

<?php 
$_youtube_url = '';
if(isset($data[$ID])){
   foreach($data[$ID] as $k => $v){
    if($v['other1']!=''){
      $_youtube_url = $v['other1'];
      break;
    }
  }
}
?>

    <div class="slickBanner">
  <?php if($_youtube_url!=''):?>
        <div class="slick-video">
            <div id="videoBanner">
                <div id="customVideo" class="player" data-property="{
                    videoURL: '<?php echo $_youtube_url?>',
                    containment: '#videoBanner',
                    autoplay: false,
                    optimizeDisplay: true,
                    stopMovieOnBlur: false,
                    showControls: false,
                    mute: true,
                    startAt: 0,
                    loop: false,
                    opacity: 1,
                    addRaster: true,
                    quality: 'default'
                }"></div>

                <img class="video_hover" src="images_v4/logo.svg">
            </div>
        </div>
  <?php endif?>
        <?php if(isset($data[$ID])):?>
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

                <div>
                    <a href="<?php echo $v['url']?>">
                        <picture>
                            <source media="(min-width: 769px)" srcset="<?php echo $v['pic1g']?>">
                            <img src="<?php echo $v['pic2g']?>" alt="<?php echo $v['topic']?>">
                        </picture>
                    </a>
                </div>
            <?php endforeach?>
        <?php endif?>
    </div>

</section>
<?php endif?>
<?php //cowboy 20210511 #39951 end?>