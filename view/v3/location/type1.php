<section class="Bbox_in_3c ">
	<div>
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="item">
					<div class="itemTitle">
						<?php /* // 國旗->圖片尺寸40x30 
						<img src="http://fakeimg.pl/40x30/?text=4:3" class="iconImg" width="40">
						*/?>
						
						<?php /* // 店家圖->圖片尺寸800x600
						<img src="http://fakeimg.pl/800x600/?text=4:3" class="iconImg" width="800">
						*/?>

						<?php if(isset($v['pic_small']) and $v['pic_small'] != ''):?>
							<img src="<?php echo $v['pic_small']?>" class="iconImg" width="40">
						<?php endif?>

						<?php if(isset($v['pic_big']) and $v['pic_big'] != ''):?>
							<img src="<?php echo $v['pic_big']?>" class="iconImg" width="800">
						<?php endif?>

						<span><?php echo $v['name']?></span>
					</div>
					<p class="itemContent">								
						Address : <a href="<?php echo $v['address_url']?>" target="_blank" class="icon-link"><?php echo $v['address']?></a><br> 
						<?php if(isset($v['phone']) and $v['phone'] != ''):?>TEL : <?php echo $v['phone']?><br /><?php endif?>
						<?php if(isset($v['fax']) and $v['fax'] != ''):?>FAX : <?php echo $v['fax']?><br /><?php endif?>
						<?php if(isset($v['email']) and $v['email'] != ''):?>E-MAIL : <a href="<?php echo $v['email_url']?>"><?php echo $v['email']?></a><br><?php endif?>
						<?php if(isset($v['website_url']) and $v['website_url'] != ''):?>Website : <a target="_blank" href="<?php echo $v['website_url']?>"><?php echo $v['website_url']?></a><?php endif?>
					</p>
				</div>
			<?php endforeach?>
		<?php endif?>
	</div>
</section>
