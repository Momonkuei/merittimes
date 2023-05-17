<?php if($this->data['router_method'] == 'index'):?>
<div class="bannerBlock">
  <div class="bannerStyle08">
    <div class="swiper-container slideshow">
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

					<div class="swiper-slide slide">
					  <div class="slide-image" style="background-image: url('<?php echo $v['pic1g']?>')"></div>
					  <span class="slide-title"><?php echo $v['topic']?></span>
					</div>
				<?php endforeach?>
			<?php endif?>

			<?php if(0):?>
          <div class="swiper-slide slide">
            <div class="slide-image" style="background-image: url('images_v4/banner/bannerStyle08-1.jpg')"></div>
            <span class="slide-title">Exotic places</span>
          </div>
          <div class="swiper-slide slide">
            <div class="slide-image" style="background-image: url('images_v4/banner/bannerStyle08-2.jpg')"></div>
            <span class="slide-title">Meet ocean</span>
          </div>
        <div class="swiper-slide slide">
            <div class="slide-image" style="background-image: url('images_v4/banner/bannerStyle08-3.jpg')"></div>
            <span class="slide-title">Around the world</span>
          </div>
		<?php endif?>
      </div>
      <div class="slideshow-pagination"></div>
      <div class="slideshow-navigation">
        <div class="slideshow-navigation-button prev"><span class="fa fa-angle-left"></span></div>
        <div class="slideshow-navigation-button next"><span class="fa fa-angle-right"></span></div>
      </div>

    </div>
  </div><!-- .bannerStyle08 -->
  <!--Scroll Down-->
  <div class="scrollDown">
    <a href="#scrollDown">
      <div class="iconBox"><i class="icon-scrollDown"></i></div>
      <div class="scrollDown_txt">scroll</div>
    </a>
  </div>
  <!--Scroll Down End-->
</div><!-- .bannerBlock -->
<?php endif?>

<?php if(0):?><!-- head_end -->
<?php // 正中間標題的下面，會有一個倒數計時條，就是這裡在弄的?>
<script>!function(e){"undefined"==typeof module?this.charming=e:module.exports=e}(function(e,n){"use strict";n=n||{};var t=n.tagName||"span",o=null!=n.classPrefix?n.classPrefix:"char",r=1,a=function(e){for(var n=e.parentNode,a=e.nodeValue,c=a.length,l=-1;++l<c;){var d=document.createElement(t);o&&(d.className=o+r,r++),d.appendChild(document.createTextNode(a[l])),n.insertBefore(d,e)}n.removeChild(e)};return function c(e){for(var n=[].slice.call(e.childNodes),t=n.length,o=-1;++o<t;)c(n[o]);e.nodeType===Node.TEXT_NODE&&a(e)}(e),e});
</script>
<?php endif?><!-- head_end -->
