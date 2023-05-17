<div class="proList">
	<div class="boxTitle"><?php echo t('相關產品')?></div>
	<section class="itemList Bbox_in_4c">
		<div>

			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="item">
						<div>
							<a href="<?php echo $v['url1']?>">
								<div class="itemImg"> <img src="<?php echo $v['pic']?>"> </div>
							</a>
						</div>
						<div>										
							<a href="<?php echo $v['url2']?>" class="itemTitle">
								<span><?php echo $v['name']?></span>
							</a>											
						</div>
					</div>
				<?php endforeach?>
			<?php endif?>

		</div>
	</section>
</div>
