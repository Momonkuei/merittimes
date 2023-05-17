<?php // 2018-08-09 A方案專用?>
<?php // 根據後台／LayoutV3／資料 的元素(好記的名子)格式命名?>
<?php if(0):?>
	<?php $data[$ID] = $this->data['_category_title']?>
<?php endif?>

<?php if(isset($data[$ID]) and isset($data[$ID]['name']) and $data[$ID]['name'] != ''):?>
	<div class="blockTitle">
		<span><?php echo $data[$ID]['name']?></span>
	</div>
	<?php if(isset($data[$ID]['sub_name']) and $data[$ID]['sub_name'] != ''):?><p><?php echo $data[$ID]['sub_name']?></p><?php endif?>
<?php endif?>
