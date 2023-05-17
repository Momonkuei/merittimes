<?php if(isset($data[$ID])):?>
	<?php $_count=count($data[$ID])?>
	<?php if(isset($data[$ID][$_count-1]['content_bottom']) and $data[$ID][$_count-1]['content_bottom'] != ''):?>
		<div class="editorBlock">
			<?php echo $data[$ID][$_count-1]['content_bottom']?>
		</div>
	<?php endif?>				
<?php endif?>				
