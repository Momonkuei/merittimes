<div class="newsList newsListType10">
	<div class="row">
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<div class="col-12 item">
					<a href="<?php echo $v['url2']?>">
						<div class="itemTitle"><span class="newsNumber">1</span> <p><?php echo $v['name']?></p> <i class="fa fa-plus" aria-hidden="true"></i></div>
					</a>
				</div><!-- .item -->
			<?php endforeach?>
		<?php endif?>
	</div>
</div><!-- .newsList -->
