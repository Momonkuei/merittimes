<?php //var_dump($data[$ID])?>
<?php if(0)://#38046?>
<div class="blockTitle">
	<span><?php echo $data[$ID]['name']?></span>
</div>
<?php endif?>


<?php if(isset($data[$ID]['detail'])):?>
	<?php echo $data[$ID]['detail']?>
<?php endif?>

