<?php if(isset($data[$this->data['router_method'].'_describe']) && $data[$this->data['router_method'].'_describe']!='')://這塊給需要顯示簡述的地方?>
<div><?php echo $data[$this->data['router_method'].'_describe']?></div>
<?php endif?>

<div class="newsList newsListType3">
	<div class="row">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<?php //var_dump($v)?>
				<div class="col-lg-4">
					<div class="item">
						<a href="<?php echo $v['url1']?>">

							<?php if(0)://20201112開會決定日期不要了?>
							<div class="dateStyle">
								<div>
									<span class="dateLM"><?php echo $v['day']?></span>
								</div>
								<div>
									<span class="dateM"><?php echo $v['month']?>.</span>
									<span class="dateYD"><?php echo $v['start_date___MONTH']?>.<?php echo $v['year']?></span>
								</div>
							</div>
							<?php endif?>
							<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> ">
								<img src="<?php echo $v['pic']?>">
							</div>
							<div class="newsItem_block">
								<div class="itemTitle" data-txtlen="33"><?php echo $v['name']?></div>

								<?php /*20201112開會決定新聞分類不要了
								<?php if(isset($v['name2']) and $v['name2'] != ''):?>
									<div class="news_tag"><?php echo $v['name2']?></div>
								<?php endif?>
								*/ ?>

								<div class="itemContent" data-txtlen="49"><?php echo $v['content']?></div>
								<div class="news_readMore">
									<p class="newsReadMore_txt">READ MORE</p>
									<span class="addIcon">+</span>
								</div>
							</div>
						</a>
					</div><!-- .item -->
				</div>
			<?php endforeach?>
		<?php endif?>
	</div>
</div><!-- .newsList -->
