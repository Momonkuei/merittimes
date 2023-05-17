<?php if(isset($data[$ID])):?>
	<?php $_count=count($data[$ID])?>
	<?php if(isset($data[$ID]) and isset($data[$ID][$_count-1]['content_top']) and $data[$ID][$_count-1]['content_top'] != ''):?>
		<div class="blockInfoTxt">
			<?php echo $data[$ID][$_count-1]['content_top']?>
		</div>
	<?php endif?>				
<?php endif?>
