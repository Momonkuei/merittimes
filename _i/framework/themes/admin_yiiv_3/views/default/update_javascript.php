<?php if(!empty($def['updatefield']['sections'])):?>
	<?php foreach($def['updatefield']['sections'] as $k => $v):?>
		<?php //不同類型的區塊*?>
		<?php if(!empty($v['field'])):?>
			<?php $this->data['k'] = $k?>
			<?php $this->data['v'] = $v?>
			<?php echo $this->renderPartial('//default/update_fields_javascript', $this->data)?>
		<?php endif?>
	<?php endforeach?>
<?php endif?>
