<div class="album_box clearfix">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<div class="album">
				<div class="albumimgfix"><a href="<?php echo $v['url1']?>"><img src="<?php echo $v['pic']?>" border="0"/></a></div>
				<div class="albumlist_description">
					<div class="album_name"><a href="<?php echo $v['url2']?>"><?php echo $v['name']?></a></div>
				</div>
			</div>
		<?php endforeach?>
	<?php endif?>
</div>
