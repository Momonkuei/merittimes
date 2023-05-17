<?php if($this->data['router_method'] == 'index'):?>
<div class="bannerBlock">
  <div class="bannerStyle10">
    <div class="swiper-container bnr_s10">
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

				<div class="swiper-slide" style="background-image: url('<?php echo $v['pic1g']?>')">
				  <div class="content">
					<h2><?php echo $v['topic']?></h2>
					<p><?php echo $v['detail'] //2020-08-17 記得後台要補欄位?></p>
					<?php if($v['url'] != ''):?>
						<button class="button" onclick="javascript:window.location.href='<?php echo $v['url']?>';return false;">Button</button>
					<?php endif?>
				  </div>
				</div>

			<?php endforeach?>
		<?php endif?>

		<?php if(0):?>
        <div class="swiper-slide" style="background-image: url('images_v4/banner/bannerStyle10-1.jpg')">
          <div class="content">
            <h2>Slide Title</h2>
            <p>This can be the description</p>
            <button class="button">Button</button>
          </div>
        </div>
        <div class="swiper-slide" style="background-image: url('images_v4/banner/bannerStyle10-2.jpg')">
          <div class="content">
            <h2>Slide Title</h2>
            <p>This can be the description</p>
            <button class="button">Button</button>
          </div>
        </div>
        <div class="swiper-slide" style="background-image: url('images_v4/banner/bannerStyle10-3.jpg')">
          <div class="content">
            <h2>Slide Title</h2>
            <p>This can be the description</p>
            <button class="button">Button</button>
          </div>
        </div>
        <div class="swiper-slide" style="background-image: url('images_v4/banner/bannerStyle10-4.jpg')">
          <div class="content">
            <h2>Slide Title</h2>
            <p>This can be the description</p>
            <button class="button">Button</button>
          </div>
        </div>
		<?php endif?>

      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div><!-- .bannerStyle10 -->
</div><!-- .bannerBlock -->
<?php endif?>