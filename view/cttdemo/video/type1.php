<div class="video_box">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<div class="vid"><a href="<?php echo $v['url3']?>"><img src="<?php echo $v['pic']?>"/></a> 
			<div class="vid_name"><a href="<?php echo $v['url3']?>"><?php echo $v['topic']?></a></div></div>
		<?php endforeach?>
	<?php endif?>
</div>
