<div class="newsList">
	<div class="itemList newsListType2 newsStyle1 Bbox_in_1c">
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
							<div class="dateStyle5">
								<span class="dateD"><?php echo $v['day']?></span>
								<span class="dateM"><?php echo $v['month']?></span>
								<span class="dateY"><?php echo $v['year']?></span>
								<a href="<?php echo $v['url2']?>">相關連結<i class="fa fa-share-square-o" aria-hidden="true"></i></a>
							</div>
							<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
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
							<div class="dateStyle5">
								<span class="dateY">2015</span>
								<span class="dateM">10</span>
								<span class="dateD">08</span>
								<a href="#">相關連結<i class="fa fa-share-square-o" aria-hidden="true"></i></a>
							</div>
							<div class="itemContent" data-txtlen="150">公司總經理表示。在超薄顯示螢幕的生產領域，從日企領跑，再由韓企占據較大比重的市場。近年來，大陸的顯示產業規模扶搖直上
							</div>
						</div>
					</div>
					<?php // newslist item end ------ ?>

				<?php }?>
			<?php endif?>
		</div>

	</div>
</div>
