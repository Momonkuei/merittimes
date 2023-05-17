<?php if($this->data['router_method'] == 'index'):?>
<div class="bannerBlock">
  <div class="bannerStyle07 clearfix">
    <div class="swiper-container main-slider loading">
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
        <figure class="slide-bgimg pc" style="background-image:url('<?php echo $v['pic1g']?>')">
					<img src="<?php echo $v['pic1g']?>" class="entity-img" />
				  </figure>
          <figure class="slide-bgimg mb" style="background-image:url('<?php echo $v['pic2g']?>')">
					<img src="<?php echo $v['pic2g']?>" class="entity-img" />
				  </figure>
				  <div class="content">
					<p class="title"><?php echo $v['topic']?></p>
					<span class="caption"><?php echo $v['detail'] //2020-08-17 記得後台要補欄位?></span>
				  </div>
				</div>
			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
        <div class="swiper-slide">
          <figure class="slide-bgimg" style="background-image:url('images_v4/banner/bannerStyle03-1.jpg')">
            <img src="images_v4/banner/bannerStyle03-1.jpg" class="entity-img" />
          </figure>
          <div class="content">
            <p class="title">Shaun Matthews</p>
            <span class="caption">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span>
          </div>
        </div>
        <div class="swiper-slide">
          <figure class="slide-bgimg" style="background-image:url('images_v4/banner/bannerStyle03-2.jpg')">
            <img src="images_v4/banner/bannerStyle03-2.jpg" class="entity-img" />
          </figure>
          <div class="content">
            <p class="title">Alexis Berry</p>
            <span class="caption">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span>
          </div>
        </div>
        <div class="swiper-slide">
          <figure class="slide-bgimg" style="background-image:url('images_v4/banner/bannerStyle03-3.jpg')">
            <img src="images_v4/banner/bannerStyle03-3.jpg" class="entity-img" />
          </figure>
          <div class="content">
            <p class="title">Billie	Pierce</p>
            <span class="caption">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span>
          </div>
        </div>
        <div class="swiper-slide">
          <figure class="slide-bgimg" style="background-image:url('images_v4/banner/bannerStyle03-4.jpg')">
            <img src="images_v4/banner/bannerStyle03-4.jpg" class="entity-img" />
          </figure>
          <div class="content">
            <p class="title">Trevor	Copeland</p>
            <span class="caption">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span>
          </div>
        </div>
        <div class="swiper-slide">
          <figure class="slide-bgimg" style="background-image:url('images_v4/banner/bannerStyle03-5.jpg')">
            <img src="images_v4/banner/bannerStyle03-5.jpg" class="entity-img" />
          </figure>
          <div class="content">
            <p class="title">Bernadette	Newman</p>
            <span class="caption">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span>
          </div>
        </div>
		<?php endif?>

      </div>
      <!-- If we need navigation buttons -->
      <div class="swiper-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
      <div class="swiper-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
    </div>
  </div><!-- .bannerStyle07 -->

  <?php //$scrollDownWidget='scrollDown_type3'; include '../banner/scrollDown.php'; ?>
<?php echo $__?>
</div><!-- .bannerBlock -->

<?php endif?>