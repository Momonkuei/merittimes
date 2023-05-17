<?php if(isset($data[$this->data['router_method'].'_describe']) && $data[$this->data['router_method'].'_describe']!='')://這塊給需要顯示簡述的地方?>
<div><?php echo $data[$this->data['router_method'].'_describe']?></div>
<?php endif?>

<?php if(0)://20201112開會決定原V3版型不要了?>
<div class="newsList newsListType5">
	<div class="row">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="col-xl-6">
					<div class="item">
						<a href="<?php echo $v['url1']?>">
							<div class="itemImg2">
								<div class="itemImg_line">
									<img src="<?php echo $v['pic']?>">
								</div>
							</div>
						</a>
						<a href="<?php echo $v['url2']?>">
							
							<div class="dateStyle">
								<span class="date"><?php echo $v['start_date']?></span>
							</div>
							<div class="itemTitle"><?php echo $v['name']?></div>
							<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
						</a>
					</div><!-- .item -->
				</div>
			<?php endforeach?>
		<?php endif?>
	</div>
</div><!-- .newsList -->
<?php endif?>

<?php //20201112開會決定版型依照https://www.plt.org.tw/goodlaw_tw.php淨土寺?>
<?php //新版型?>
<div class="newsList newsListType5">
	<div class="row">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="col-xl-6">
					<div class="item">
						<a href="<?php echo $v['url1']?>">
							<div class="itemImg2">
								<div class="itemImg_line">
									<img src="<?php echo $v['pic']?>">
								</div>
							</div>
						</a>
						<a href="<?php echo $v['url2']?>">
							<div class="itemTitle"><?php echo $v['name']?></div>
							<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
							<div class="moreStyleBlock"><span class="borderLine"></span><span>More 看更多</span></div>
						</a>
						
					</div><!-- .item -->
				</div>
			<?php endforeach?>
		<?php endif?>
	</div>
</div><!-- .newsList -->