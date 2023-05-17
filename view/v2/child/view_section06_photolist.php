
<div class="rwd-padding">
<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
	<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
      <div class="imgtxt tworow"><a <?php if(isset($v['url']) && $v['url']):?>href="<?php echo $v['url']?>"<?php endif?> class="img mask-circle"><div><?php if(isset($v['pic']) && $v['pic']):?><img src="<?php echo $v['pic']?>"  class="wCenter_hCenter"><?php endif?></div></a><a <?php if(isset($v['url']) && $v['url']):?>href="<?php echo $v['url']?>"<?php endif?> class="txt"><p><?php /*<span class="oneline"><img src="images/index03/txt-1.png" height="35"></span>*/?><span class="oneline"><?php echo $v['name']?></span></p></a></div>
	  <?php endforeach?>
<?php endif?>          
</div>


<?php /*
<div class="rwd-padding">
      <div class="imgtxt tworow"><a href="" class="img mask-circle"><div><img src="images/index03/ad-1.jpg" class="hFull_wCenter"></div></a><a href="" class="txt"><p><span class="oneline"><img src="images/index03/txt-1.png" height="35"></span><span class="oneline">台灣豬梅花</span></p></a></div>
      <div class="imgtxt tworow"><a href="" class="img mask-circle"><div><img src="images/index03/ad-2.jpg" class="hFull_wCenter"></div></a><a href="" class="txt"><p><span class="oneline"><img src="images/index03/txt-2.png" height="35"></span><span class="oneline">香嫩雞腿</span></p></a></div>
      <div class="imgtxt tworow"><a href="" class="img mask-circle"><div><img src="images/index03/ad-3.jpg" class="hFull_wCenter"></div></a><a href="" class="txt"><p><span class="oneline"><img src="images/index03/txt-3.png" height="35"></span><span class="oneline">美國牛梅花</span></p></a></div>              
</div>
*/?>