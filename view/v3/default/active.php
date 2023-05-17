<?php if(isset($data[$ID]) and count($data[$ID]) > 0):?>
<script type="text/javascript" m="body_end">
	<?php foreach($data[$ID] as $k => $v):?>
		$('#navlight_<?php echo $v?>').addClass('active');
	<?php endforeach?>
</script>
<?php endif?>
