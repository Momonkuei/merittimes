<div class="bannerBlock">
  <div class="bannerStyle05">
    <div class="swiper-container bnr_s5">
      <div class="parallax-bg" style="background-image:url('images_v4/banner/indexBanner1.jpg')" data-swiper-parallax="-23%"></div>
      <div class="swiper-wrapper">

		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="swiper-slide">
				  <div class="title" data-swiper-parallax="-300"><?php echo $v['topic']?></div>
				  <!-- <div class="subtitle" data-swiper-parallax="-200">Subtitle</div> -->
				  <div class="text" data-swiper-parallax="-100">
					<p><?php echo $v['detail'] //2020-08-17 記得後台要補欄位?></p>
				  </div>
				</div>
			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
        <div class="swiper-slide">
          <div class="title" data-swiper-parallax="-300">Slide 1</div>
          <!-- <div class="subtitle" data-swiper-parallax="-200">Subtitle</div> -->
          <div class="text" data-swiper-parallax="-100">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dictum mattis velit, sit amet faucibus felis iaculis nec. Nulla laoreet justo vitae porttitor porttitor. Suspendisse in sem justo. Integer laoreet magna nec elit suscipit, ac laoreet nibh euismod. Aliquam hendrerit lorem at elit facilisis rutrum. Ut at ullamcorper velit. Nulla ligula nisi, imperdiet ut lacinia nec, tincidunt ut libero. Aenean feugiat non eros quis feugiat.</p>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="title" data-swiper-parallax="-300" data-swiper-parallax-opacity="0">Slide 2</div>
          <!-- <div class="subtitle" data-swiper-parallax="-200">Subtitle</div> -->
          <div class="text" data-swiper-parallax="-100">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dictum mattis velit, sit amet faucibus felis iaculis nec. Nulla laoreet justo vitae porttitor porttitor. Suspendisse in sem justo. Integer laoreet magna nec elit suscipit, ac laoreet nibh euismod. Aliquam hendrerit lorem at elit facilisis rutrum. Ut at ullamcorper velit. Nulla ligula nisi, imperdiet ut lacinia nec, tincidunt ut libero. Aenean feugiat non eros quis feugiat.</p>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="title" data-swiper-parallax="-300">Slide 3</div>
          <!-- <div class="subtitle" data-swiper-parallax="-200">Subtitle</div> -->
          <div class="text" data-swiper-parallax="-100">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dictum mattis velit, sit amet faucibus felis iaculis nec. Nulla laoreet justo vitae porttitor porttitor. Suspendisse in sem justo. Integer laoreet magna nec elit suscipit, ac laoreet nibh euismod. Aliquam hendrerit lorem at elit facilisis rutrum. Ut at ullamcorper velit. Nulla ligula nisi, imperdiet ut lacinia nec, tincidunt ut libero. Aenean feugiat non eros quis feugiat.</p>
          </div>
        </div>
		<?php endif?>

      </div>
      <!-- Add Pagination -->
      <div class="swiper-pagination swiper-pagination-white"></div>
      <!-- Add Navigation -->
      <div class="swiper-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
      <div class="swiper-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
    </div>
  </div><!-- .bannerStyle05 -->
</div><!-- .bannerBlock -->
