<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
		<?php if(0):?>
			<label <?php echo $formattr?> <?php if(isset($vv['attr']['id']) and 0):?>id="<?php echo $vv['attr']['id']?>"<?php endif?> ><?php if(isset($updatecontent[$kk])):?><?php echo $updatecontent[$kk]?><?php endif?></label>
		<?php endif?>

		<p class="form-control-static"><?php if(isset($updatecontent[$kk])):?><?php echo $updatecontent[$kk]?><?php endif?></p>

	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
