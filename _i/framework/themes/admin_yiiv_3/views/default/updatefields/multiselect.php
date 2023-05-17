<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<select multiple="multiple" <?php echo $formattr?>>
	<?php if(!empty($updatecontent[$kk])):?>
		<?php foreach($updatecontent[$kk] as $kkk => $vvv):?>
		<option value="<?php echo $kkk?>" <?php if(isset($vvv['is_selected'])) echo $vvv['is_selected']?> ><?php echo $vvv['value']?></option>
		<?php endforeach?>
	<?php endif?>
	</select>
<?php endif?>
