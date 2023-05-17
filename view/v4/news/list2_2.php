<?php if(isset($data[$this->data['router_method'].'_describe']) && $data[$this->data['router_method'].'_describe']!='')://這塊給需要顯示簡述的地方?>
<div><?php echo $data[$this->data['router_method'].'_describe']?></div>
<?php endif?>

<div class="newsList newsListType2">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<div class="item">
				<a href="<?php echo $v['url1']?>">
					<div class="<?php echo $data['image_ratio'];//變數在source/core.php?> ">
						<img src="<?php echo $v['pic']?>">
					</div>
				</a>
				<a href="<?php echo $v['url2']?>">
					<div class="dateStyle_2">
						<span class="dateD"><?php echo $v['day']?></span>
						<span class="dateM"><?php echo $v['month']?></span>
						<span class="dateY"><?php echo $v['year']?></span>
					</div>
					<div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
					<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
				</a>
			</div><!-- .item -->
		<?php endforeach?>
	<?php endif?>
</div><!-- .newsList -->
