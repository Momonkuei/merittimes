<section class="Bbox_1c albumList">
	<div>
		<div>
			<section class="itemList photos Bbox_in_3c">
				<div>
					<?php if(isset($data[$ID])):?>
						<?php foreach($data[$ID] as $k => $v):?>
							<div class="item">
								<?php // 同一個區塊同一個值，才能看圖片的時候下一頁?>
								<a 
									rel="gallery-<?php echo $ID?>" 
									href="<?php echo $v['url']?>" 
									class="swipebox"

									<?php if(isset($v['name']) and $v['name'] != ''):?>
										title="<?php echo $v['name']?>"
									<?php endif?>
								>
									<div class="itemImg"><img src="<?php echo $v['pic']?>"></div>
									<?php if(isset($v['name']) and $v['name'] != ''):?>
										<div class="itemTitle"><span><?php echo $v['name']?></span></div>
									<?php endif?>
								</a>
							</div>
						<?php endforeach?>
					<?php endif?>
				</div>
			</section>
		</div>
	</div>
</section>			
