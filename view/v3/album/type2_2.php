<section class="Bbox_1c albumList">
	<div>
		<div>
			<!-- <section class="itemList waterPhotos Bbox_in_3c"> -->
			<section class="itemList Bbox_in_3c">
				<div>
					<?php if(isset($data[$ID])):?>
						<?php foreach($data[$ID] as $k => $v):?>
							<div class="item">
								<a
									rel="gallery-<?php echo $ID?>"
									href="<?php echo $v['url']?>"
									class="swipebox"

									<?php if(isset($v['name']) and $v['name'] != ''):?>
										title="<?php echo $v['name']?>"
									<?php endif?>
								>
									<div class="itemImg">
										<img src="<?php echo $v['pic']?>">
									</div>
									<?php if(isset($v['name']) and $v['name'] != ''):?>
										<div class="itemTitle"> <span><?php echo $v['name']?></span></div>
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
