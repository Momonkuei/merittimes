<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['class']) and $vv['other']['class'] != ''):?>
		<?php $class = $vv['other']['class']?>
	<?php else:?>
		<?php $class = $router_class?>
	<?php endif?>

	<?php $this->data['action'] = $def['updatefield']['method']?>
	<?php $this->data['field'] = $kk?>
	<?php $this->data['number'] = $vv['other']['number']?>
	<?php $this->data['value'] = G::a($updatecontent, 'updatecontent.'.$kk)?>
	<?php $this->data['class'] = $class?>
	<?php $this->data['width'] = $vv['other']['width']?>
	<?php $this->data['height'] = $vv['other']['height']?>
	<?php $this->data['type'] = G::a($vv, 'vv.other.type')?>
	<?php $this->data['comment_size'] = $vv['other']['comment_size']?>
	<?php $this->data['no_ext'] = $vv['other']['no_ext']?>
	<?php $this->data['subfield'] = $vv['other2']?>

	<?php echo $this->renderPartial('//includes/fileuploader_multi', $this->data)?>
<?php endif?>
