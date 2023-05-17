<?php if(isset($data[$this->data['router_method'].'_describe']) && $data[$this->data['router_method'].'_describe']!='')://這塊給需要顯示簡述的地方?>
<div><?php echo $data[$this->data['router_method'].'_describe']?></div>
<?php endif?>

<div class="newsList newsListType6">
	<div class="row">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="col-lg-4 col-sm-6">
					<div class="item">
						<a href="<?php echo $v['url1']?>">
				  			<div class="<?php echo $data['image_ratio'];//變數在source/core.php?>  itemImgHover hoverEffect3">
										<img src="<?php echo $v['pic']?>">
				  			</div>
									<div class="itemNumber"><span><?php echo $v['__serial_number2']?></span></div>
									<div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
									<div class="dateStyle"><?php echo $v['start_date']?></div>
				  			<div class="itemContent" data-txtlen="40"><?php echo $v['content']?></div>
				  		</a>
				  	</div>
					<!-- .item -->
				</div>
			<?php endforeach?>
		<?php endif?>
	</div>
</div><!-- .newsList -->
