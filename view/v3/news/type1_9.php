<div class="newsList">
	<div class="itemList newsListType2 ">
		<div>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="item">
						<a href="<?php echo $v['url1']?>">
							<div class="itemImg">
								<img src="<?php echo $v['pic']?>">
							</div>
						</a>
						<div>
							<div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
							<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
							<div class="text-right">
								<a href="<?php echo $v['url1']?>">查看更多</a>
							</div>
						</div>
					</div>
				<?php endforeach?>
			<?php endif?>

			<?php if(0):?>
				<?php for($i=1;$i<=10;$i++) {?>

					<?php // newslist item start ------ ?>
					<div class="item">
						<a href="pagedetail.php">
							<div class="itemImg">
								<img src="images/album_<?php echo $i%3+1?>.jpg">
							</div>
						</a>
						<div>
							<div class="itemTitle"> <span>舉辦「產學合作商機發表會」</span> </div>
							<div class="itemContent" data-txtlen="150">公司總經理表示。在超薄顯示螢幕的生產領域，從日企領跑，再由韓企占據較大比重的市場。近年來，大陸的顯示產業規模扶搖直上，成為顯示屏行業發展速度最快的地區展覽同期所舉辦的「產學合作商機發表會」，獲得全球業者高度興趣，與各校互動熱絡。</div>
							<div class="flex2c noLRspace">
							  <div>
									<a href="pagedetail.php">查看更多</a>
								</div>
							  <div class="text-right">
									<div class="dateStyle6">
										<span class="dateY">2015年</span>
										<span class="dateM">08月</span>
										<span class="dateD">20日</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php // newslist item end ------ ?>

				<?php }?>
			<?php endif?>
		</div>

	</div>
</div>
