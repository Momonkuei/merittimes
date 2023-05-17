<div class="downloadList">
	<div class="itemList downloadListType1">
		<div>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="item">				
						<div>
							<span class="itemIcon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
							<div>
								<a href="<?php echo $v['href1']?>" target="_blank" class="itemTitle"> <span><?php echo $v['name']?></span></a>
								<div class="itemInfo"><?php echo $v['content']?></div>
							</div>
						</div>							
						<a href="<?php echo $v['href2']?>" target="_blank" class="itemLink"><i class="fa fa-download" aria-hidden="true"></i> DOWNLOAD</a>						
					</div>
				<?php endforeach?>
			<?php endif?>

			<?php if(0):?>
				<?php for($i=1;$i<=5;$i++) {?>

					<?php // downloadList item start ------ ?>
					<div class="item">				
						<div>
							<span class="itemIcon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
							<div>
								<a href="" target="_blank" class="itemTitle"> <span>TD00002PG 系列規格表</span></a>
								<div class="itemInfo">包括各種電源IC、智慧功率元件、電晶體陣列和單片式微波積體電路（MMIC）</div>
							</div>
						</div>							
						<a href="" target="_blank" class="itemLink"><i class="fa fa-download" aria-hidden="true"></i> DOWNLOAD</a>						
					</div>
					<?php // downloadList item end ------ ?>

				<?php }?>
			<?php endif?>
		</div>
	</div>
</div>
