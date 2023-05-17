<div class="downloadList">
	<div class="itemList downloadListType2 Bbox_in_4c">
		<div>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="item">
						<a 
							<?php if(isset($v['href1']) and $v['href1'] != ''):?> href="<?php echo $v['href1']?>" target="_blank" <?php endif?>
							<?php if(isset($v['anchor1_class']) and $v['anchor1_class'] != ''):?> class="<?php echo $v['anchor1_class']?>" <?php endif?> 
							<?php if(isset($v['anchor1_data_target']) and $v['anchor1_data_target'] != ''):?> data-target="<?php echo $v['anchor1_data_target']?>" <?php endif?> 
						>
							<div class="itemImg eye">
								<img src="<?php echo $v['pic']?>">
							</div>
						</a>
						<a 
							<?php if(isset($v['href2']) and $v['href2']!=''):?> href="<?php echo $v['href2']?>" target="_blank" <?php endif?>
							<?php if(isset($v['anchor2_class']) and $v['anchor2_class'] != ''):?> class="<?php echo $v['anchor2_class']?>" <?php endif?> 
							<?php if(isset($v['anchor2_data_target']) and $v['anchor2_data_target'] != ''):?> data-target="<?php echo $v['anchor2_data_target']?>" <?php endif?> 
						>
							<div class="itemTitle"> <span><?php echo $v['name']?></span></div>
							<div class="itemLink"><i class="fa fa-download" aria-hidden="true"></i> <?php echo t('DOWNLOAD','en')?></div>
						</a>
					</div>
				<?php endforeach?>
			<?php endif?>

			<?php if(0):?>
				<?php for($i=1;$i<=5;$i++) {?>

					<?php // downloadList item start ------ ?>
					<div class="item">
						<a href="" target="_blank">
							<div class="itemImg eye">
								<img src="images/dm_<?=$i%3+1?>.jpg">
							</div>
						</a>
						<a href="" target="_blank">									
								<div class="itemTitle"> <span>2015 YOUR光電型錄</span></div>
								<div class="itemLink"><i class="fa fa-download" aria-hidden="true"></i> DOWNLOAD</div>
								
						</a>
					</div>
					<?php // downloadList item end ------ ?>

				<?php }?>
			<?php endif?>
		</div>
	</div>
</div>
