<?php if($this->data['router_method'] != 'index'):?>
	<div class="pageBanner">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<?php if($k!=0) continue;//2021-05-06 內頁banner只顯示1張 by lota?>
				<img src="<?php echo $v['pic1g']?>" class="pc">
				<img src="<?php echo $v['pic2g']?>" class="mb">
			<?php endforeach?>
		<?php endif?>
	</div>

	<?php if(0):?>
	<div class="pageBanner">
		<img class="pc" src="images_v4/banner/indexBanner2.jpg" alt="">
		<img class="mb" src="images_v4/banner/indexBanner2_mb.jpg" alt="">  
	</div><!-- .pageBanner -->
	<?php endif?>
<?php endif?>
