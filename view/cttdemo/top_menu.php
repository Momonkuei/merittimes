<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
		<a href="<?php echo $v['url']?>"><?php echo $v['topic']?></a> 
	<?php endforeach?>
<?php endif?>
