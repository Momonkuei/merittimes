<div class="Bbox_1c newsList">
  <div>
      <div>
        <section class="itemList newsListType5 flex2c">

			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div>
					  <div class="item">
						<a href="<?php echo $v['url1']?>">
						  <div class="itemImg2">
							<div class="itemImg_line">
								<img src="<?php echo $v['pic']?>">
							</div>
						  </div>
						</a>
						<a href="<?php echo $v['url2']?>">
						  <div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
						  <div class="dateStyle">
						  <span class="date"><?php echo $v['year']?>-<?php echo $v['MONTH']?>-<?php echo $v['day']?><?php // More 看更多?></span>
						  </div>
						</a>
					  </div>
					</div>
				<?php endforeach?>
			<?php endif?>

			<?php if(0):?>
			  <?php for ($i=1;$i<=4;$i++) {?>
				<div>
				  <?php //newslist item start ------?>
				  <div class="item">
					<a href="pagedetail.php">
					  <div class="itemImg2">
						<div class="itemImg_line">
						  <img src="<?php echo $imgPath;?>demo/album_<?php echo $i%3+1?>.jpg">
						</div>
					  </div>
					</a>
					<a href="pagedetail.php">
					  <div class="dateStyle">
						<span class="date">2015-10-08</span>
					  </div>
					  <div class="itemTitle"> <span>舉辦「產學合作商機發表會」</span> </div>
					  <!-- <div class="itemContent" data-txtlen="150">公司總經理表示。在超薄顯示螢幕的生產領域，從日企領跑，再由韓企占據較大比重的市場。近年來，大陸的顯示產業規模扶搖直上，成為顯示屏行業發展速度最快的地區展覽同期所舉辦的「產學合作商機發表會」，獲得全球業者高度興趣，與各校互動熱絡。</div> -->
					</a>
				  </div>
				  <?php //newslist item end ------?>
				</div>
				<div>
				  <?php //newslist item start ------?>
				  <div class="item">
					<a href="pagedetail.php">
					  <div class="itemImg2">
						<div class="itemImg_line">
						  <img src="<?php echo $imgPath;?>demo/album_<?php echo $i%3+1?>.jpg">
						</div>
					  </div>
					</a>
					<a href="pagedetail.php">
					  <div class="dateStyle">
						<span class="date">2015-10-08</span>
					  </div>
					  <div class="itemTitle"> <span>舉辦「產學合作商機發表會」</span> </div>
					  <!-- <div class="itemContent" data-txtlen="150">公司總經理表示。在超薄顯示螢幕的生產領域，從日企領跑，再由韓企占據較大比重的市場。近年來，大陸的顯示產業規模扶搖直上，成為顯示屏行業發展速度最快的地區展覽同期所舉辦的「產學合作商機發表會」，獲得全球業者高度興趣，與各校互動熱絡。</div> -->
					</a>
				  </div>
				  <?php //newslist item end ------?>
				</div>
			  <?php }?>
			<?php endif?>

        </section>
      </div>
  </div>
</div>
