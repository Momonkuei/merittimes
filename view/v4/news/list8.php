<?php if(isset($data[$this->data['router_method'].'_describe']) && $data[$this->data['router_method'].'_describe']!='')://這塊給需要顯示簡述的地方?>
<div><?php echo $data[$this->data['router_method'].'_describe']?></div>
<?php endif?>


<?php //newsListType8為newsListType2變形(原V3日期排列樣式三)需與.newsListType2搭配使用?>
<div class="newsList">
	<div class="itemList newsListType2 Bbox_in_1c newsListType8">
		<div>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="item">
						<a href="<?php echo $v['url1']?>">
							<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> ">
								<img src="<?php echo $v['pic']?>">
							</div>
						</a>
						<a href="<?php echo $v['url2']?>">
							<div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
							<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
							<div class="dateStyle4">
								<span class="dateY"><?php echo $v['year']?>年</span>
								<span class="dateM"><?php echo $v['month']?>月</span>
								<span class="dateD"><?php echo $v['day']?>日</span>
							</div>
						</a>
					</div>
				<?php endforeach?>
			<?php endif?>


		</div>

	</div>
</div>
