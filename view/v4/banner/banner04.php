<div class="bannerBlock">
  <div class="bannerStyle04">
    <div class="swiper-container gallery-top">
      <div class="swiper-wrapper">

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
            <img class="pc" src="images_v4/banner/indexBanner1.jpg" alt="">
            <img class="mb" src="images_v4/banner/indexBanner1_mb.jpg" alt="">
          </a>
        </div>
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
      <!-- Add Arrows -->
      <div class="swiper-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
      <div class="swiper-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
    </div>
    <div class="swiper-container gallery-thumbs">
      <div class="swiper-wrapper">

		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="swiper-slide"><img src="<?php echo $v['pic1g']?>" alt=""></div>
			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
        <div class="swiper-slide"><img src="images_v4/banner/indexBanner1.jpg" alt=""></div>
        <div class="swiper-slide"><img src="images_v4/banner/indexBanner2.jpg" alt=""></div>
        <div class="swiper-slide"><img src="images_v4/banner/indexBanner3.jpg" alt=""></div>
        <div class="swiper-slide"><img src="images_v4/banner/indexBanner4.jpg" alt=""></div>
		<?php endif?>

      </div>
    </div>
  </div><!-- .bannerStyle04 -->
</div><!-- .bannerBlock -->
