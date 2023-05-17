<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php $uploadurl_id = '0'?>
	<?php if(isset($vv['other']['uploadurl_id']) and $vv['other']['uploadurl_id'] != ''):?>
		<?php $uploadurl_id = $vv['other']['uploadurl_id']?>
	<?php endif ?>

	<?php $type = ''?>
	<?php if(isset($vv['other']['type']) and $vv['other']['type'] != ''):?>
		<?php $type = $vv['other']['type']?>
	<?php endif ?>

	<?php $dir = ''?>
	<?php if(isset($vv['other']['dir']) and $vv['other']['dir'] != ''):?>
		<?php $dir = $vv['other']['dir']?>
	<?php endif ?>

	<?php $school_id = ''?>
	<?php if(isset($vv['other']['school_id']) and $vv['other']['school_id'] != ''):?>
		<?php $school_id = $vv['other']['school_id']?>
	<?php endif ?>

	<?php $kcfinder_url = vir_path_c.'kcfinder/browse.php?uploadurl_id='.$uploadurl_id.'&type='.$type.'&dir='.$dir.'&school_id='.$school_id?>
	<iframe <?php echo $formattr?> frameborder="0" src="<?php echo $kcfinder_url?>"/></iframe>
<?php endif?>
