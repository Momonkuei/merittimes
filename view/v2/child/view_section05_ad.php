[POS1]
<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
<div class="rwd-padding">
	<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
    <div class="imgtxt _sm2c"><a href="<?php echo $v['url1']?>" class="img shadow"><img src="<?php echo $v['pic1']?>" class="wCenter_hCenter"></a></div> 
    <?php endforeach?>
</div>
<?php endif?>
<?php /* //備份用
<div class="rwd-padding">
    <div class="imgtxt _sm2c"><a href="" class="img shadow"><img src="images/index02/ad-1.jpg"></a></div> 
    <div class="imgtxt _sm2c"><a href="" class="img shadow"><img src="images/index02/ad-2.jpg"></a></div> 
    <div class="imgtxt _sm2c"><a href="" class="img shadow"><img src="images/index02/ad-3.jpg"></a></div> 
    <div class="imgtxt _sm2c"><a href="" class="img shadow"><img src="images/index02/ad-4.jpg"></a></div> 
</div>
*/ ?>