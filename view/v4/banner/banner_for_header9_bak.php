<div class="swiper-container bnr_head">
  <div class="swiper-wrapper">
    <!-- <div class="swiper-slide"><iframe class="video" src="https://www.youtube.com/embed/YE7VzlLtp-4?ecver=2&enablejsapi=1"></iframe></div> -->
    <!-- <div class="swiper-slide">
      <div id="bgVideo" class="bgVideo"></div>
    </div> -->
	<?php if(0):?>
    <div class="swiper-slide" style="background-image: url('images_v4/banner/headerBanner_01.jpg')"></div>
    <div class="swiper-slide" style="background-image: url('images_v4/banner/headerBanner_02.jpg')"></div>
    <div class="swiper-slide" style="background-image: url('images_v4/banner/headerBanner_03.jpg')"></div>
	<?php endif?>

	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<div class="swiper-slide" style="background-image: url('<?php echo $v['pic1g']?>')"></div>
		<?php endforeach?>
	<?php endif?>

  </div>
  <!-- Add Pagination -->
  <div class="swiper-pagination"></div>
</div><!-- .swiper-container .bnr_head -->
