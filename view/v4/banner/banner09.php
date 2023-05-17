<div class="bannerBlock">
  <div class="bannerStyle09">
    <div class="swiper-container bnr_s9">
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
				  <div style="background-image:url('<?php echo $v['pic1g']?>');" class="carousel__container">
					<p class="carousel-onhover"><?php echo $v['topic']?></p>
				  </div>
				  <div class="carousel__container__inner">
					<h1><?php echo $v['topic']?></h1>
					<p><?php echo $v['detail'] //2020-08-17 記得後台要補欄位?></p><a href="<?php echo $v['url1']?>" class="button__bg__red">learn more</a>
				  </div>
				</div>
			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
        <div class="swiper-slide">
          <div style="background-image:url('images_v4/banner/bannerStyle09-1.jpg');" class="carousel__container">
            <p class="carousel-onhover">all new</p>
          </div>
          <div class="carousel__container__inner">
            <h1>all new</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p><a href="#" class="button__bg__red">learn more</a>
          </div>
        </div>
        <div class="swiper-slide">
          <div style="background-image:url('images_v4/banner/bannerStyle09-2.jpg');" class="carousel__container">
            <p class="carousel-onhover">all new</p>
          </div>
          <div class="carousel__container__inner">
            <h1>all new</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p><a href="#" class="button__bg__red">learn more</a>
          </div>
        </div>
        <div class="swiper-slide">
          <div style="background-image:url('images_v4/banner/bannerStyle09-3.jpg');" class="carousel__container">
            <p class="carousel-onhover">all new</p>
          </div>
          <div class="carousel__container__inner">
            <h1>all new</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p><a href="#" class="button__bg__red">learn more</a>
          </div>
        </div>
        <div class="swiper-slide">
          <div style="background-image:url('images_v4/banner/bannerStyle09-4.jpg');" class="carousel__container">
            <p class="carousel-onhover">all new</p>
          </div>
          <div class="carousel__container__inner">
            <h1>all new</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p><a href="#" class="button__bg__red">learn more</a>
          </div>
        </div>
		<?php endif?>

      </div>
      <div class="swiper__arrows">
        <div class="swiper__buttonblock__left">
          <div class="swiper-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
        </div>
        <div class="swiper__buttonblock__right">
          <div class="swiper-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
        </div>
      </div>
    </div>
  </div><!-- .bannerStyle09 -->

  <?php //$scrollDownWidget='scrollDown_type4'; include '../banner/scrollDown.php'; ?>
<?php echo $__?>
</div><!-- .bannerBlock -->
