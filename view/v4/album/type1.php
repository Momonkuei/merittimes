<section class="Bbox_1c albumList">
	<div>
		<div>
			<section class="itemList Bbox_in_3c <?php // waterPhotos 加上這個，列表就變瀑布流了?> ">
				<div>
					<?php if(isset($data[$ID])):?>
						<?php foreach($data[$ID] as $k => $v):?>
							<div class="item">
								<a href="<?php echo $v['url1']?>" <?php if(isset($v['anchor_attr1']) and $v['anchor_attr1'] != ''):?><?php echo $v['anchor_attr1']?><?php endif?> >
									<div class="itemImg">
										<img src="<?php echo $v['pic']?>">
									</div>
								</a>
								<a href="<?php echo $v['url2']?>" <?php if(isset($v['anchor_attr2']) and $v['anchor_attr2'] != ''):?><?php echo $v['anchor_attr2']?><?php endif?> >									
									<div class="itemTitle"> <span><?php echo $v['name']?></span></div>
									<?php if($v['count'] != ''):?>
										<div class="Bbox_flexBetween">
											<div class="dateStyle">
												<i class="fa fa-calendar-o"></i>
												<span class="dateD"><?php echo $v['day']?></span>
												<span class="dateM"><?php echo $v['month']?></span>
												<span class="dateY"><?php echo $v['year']?></span>
											</div>
											<div class="itemTotal"><i class="fa fa-camera"></i><span><?php echo $v['count']?></span></div>
										</div>
									<?php endif?>
								</a>
							</div>
						<?php endforeach?>
					<?php endif?>

					<?php if(0):?>
						<?php for ($i=1;$i<=10;$i++) {?>

							<?php //newslist item start ------?>
							<div class="item">
								<a href="album.php?type=2">
									<div class="itemImg">
										<img src="images/album_<?php echo $i%4+1;?>.jpg">
									</div>
								</a>
								<a href="album.php?type=2">									
										<div class="itemTitle"> <span>相簿標題</span></div>
										<div class="Bbox_flexBetween">
											<div class="dateStyle">
												<i class="fa fa-calendar-o"></i>
												<span class="dateD">08</span>
												<span class="dateM">October</span>
												<span class="dateY">2015</span>
											</div>
											<div class="itemTotal"><i class="fa fa-camera"></i><span>30</span></div>
										</div>
								</a>
							</div>
							<?php //newslist item end ------?>

						<?php }?>
					<?php endif?>
				</div>
			</section>
		</div>
	</div>
</section>			
