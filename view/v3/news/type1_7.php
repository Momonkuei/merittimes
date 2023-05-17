<div class="newsList">
	<div class="itemList newsListType2 Bbox_in_1c">
		<div>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="item">
						<a href="<?php echo $v['url1']?>">
							<div class="itemImg">
								<img src="<?php echo $v['pic']?>">
							</div>
						</a>
						<a href="<?php echo $v['url2']?>">
							<div class="dateStyle4">
								<span class="dateD"><?php echo $v['day']?></span>
								<span class="dateM"><?php echo $v['month']?></span>
								<span class="dateY"><?php echo $v['year']?></span>
							</div>
							<div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
							<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
						</a>
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
						<a href="pagedetail.php">
								<div class="dateStyle">
									<span class="dateD">08</span>
									<span class="dateM">October</span>
									<span class="dateY">2015</span>
								</div>
								<div class="itemTitle"> <span>舉辦的「產學合作商機發表會」</span> </div>
								<div class="itemContent">公司總經理表示。在超薄顯示螢幕的生產領域，從日企領跑，再由韓企占據較大比重的市場。近年來，大陸的顯示產業規模扶搖直上，成為顯示屏行業發展速度最快的地區展覽同期所舉辦的「產學合作商機發表會」，獲得全球業者高度興趣，與各校互動熱絡。</div>
						</a>
					</div>
					<?php // newslist item end ------ ?>

				<?php }?>
			<?php endif?>
		</div>

	</div>
</div>
