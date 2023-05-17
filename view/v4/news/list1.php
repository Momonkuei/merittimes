<div class="newsList newsListType1">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<div class="item">
				<a href="<?php echo $v['url1']?>">
					<div class="dateStyle_2">
						<span class="dateD"><?php echo $v['day']?></span>
						<span class="dateM"><?php echo $v['month']?></span>
						<span class="dateY"><?php echo $v['year']?></span>
					</div>
				</a>
				<a href="<?php echo $v['url2']?>">
					<div class="itemTitle"> <span><?php echo $v['name']?></span> </div>
					<div class="itemContent" data-txtlen="150"><?php echo $v['content']?></div>
				</a>
			</div><!-- .item -->
		<?php endforeach?>
	<?php endif?>
</div><!-- .newsList -->
