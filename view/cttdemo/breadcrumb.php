<span>
	<?php if(isset($data[$ID])):?>
		<?php $tmps = array()?>
		<?php foreach($data[$ID] as $k => $v):?>
			<?php $tmps[] = '<a href="'.$v['url'].'">'.$v['name'].'</a>'?>
		<?php endforeach?>
		<?php echo implode(' &gt; ', $tmps)?>
	<?php endif?>
</span>
