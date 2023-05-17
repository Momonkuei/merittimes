<?php if($this->data['router_method'] != 'index'):?>
	<div class="innerBanner">
		<picture>
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<?php if($k!=0) continue;//2021-05-06 內頁banner只顯示1張 by lota?>		
			<source srcset="<?php echo $v['pic2g']?>" media="(max-width: 768px)"><!--手機版(768px以下)banner-->
	    <img src="<?php echo $v['pic1g']?>" alt=""><!--PC版banner-->
		<?php endforeach?>
	<?php endif?>
	</picture>
	</div>
<?php endif?>

	<?php if(0):?>
 	 <div class="innerBanner">
	   <picture>
	    <source srcset="https://via.placeholder.com/1200x900" media="(max-width: 768px)"><!--手機版(768px以下)banner-->
	    <img src="https://via.placeholder.com/1920x768" alt=""><!--PC版banner-->
	   </picture>
	  </div>
<?php endif?>
