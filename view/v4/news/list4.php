<?php if(isset($data[$this->data['router_method'].'_describe']) && $data[$this->data['router_method'].'_describe']!='')://這塊給需要顯示簡述的地方?>
<div><?php echo $data[$this->data['router_method'].'_describe']?></div>
<?php endif?>

<div class="newsList newsListType4">
	<div class="row">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="col-lg-4 col-sm-6">
					<div class="item">
						<a href="<?php echo $v['url1']?>">
							<div class="time_date">
								<div class="dateStyle">
									<span class="dateD"><?php echo $v['day']?></span>
									<span class="dateY"><?php echo $v['month']?></span>
								</div>
								<div class="<?php echo $data['image_ratio'];//變數在source/core.php?>  img-rectangle ">
									<img src="<?php echo $v['pic']?>">
								</div>
							</div>
							<div class="itemTitle" data-txtlen="33"><?php echo $v['name']?></div>
							<div class="itemContent" data-txtlen="49"><?php echo $v['content']?></div>
						</a>
					</div><!-- .item -->
				</div>
			<?php endforeach?>
		<?php endif?>
	</div>
</div><!-- .newsList -->
