<?php if(isset($this->data['langs'])):?>
<table style="margin-left:10px">
	<?php foreach($this->data['langs'] as $kk => $vv):?>
		<tr>
			<td>
				<?php echo ($kk+1)?>. <?php echo $vv['ml_key']?>：<?php echo strip_tags($vv['value'])?> 
			</td>
		</tr>
	<?php endforeach?>
</table>
<?php endif?>
