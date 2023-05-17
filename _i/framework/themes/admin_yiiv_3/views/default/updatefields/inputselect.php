<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

<?php
	$tmp = <<<XXX
$('#{$kk}_{$vv['type']}').change(function(){
	var val = $(this).val();
	$('#{$kk}').attr('value', val);
});
XXX;
?>
<?php echo $tmp?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<input type="text" <?php echo $formattr?> <?php if(!isset($vv['attr']['type'])){?>type="text"<?php }?> value="<?php echo G::ae($updatecontent, 'updatecontent.'.$kk)?>" />
	<?php // 給純狀態型的資料使用，例如是、否、開啟、停用等?>
	<select id="<?php echo $vv['attr']['id']?>_inputselect">
		<option value=""><?php G::te(null, 'Please Select', array(), '請選擇')?></option>
		<?php if(isset($updatecontent[$kk.'_inputselect']) and count($updatecontent[$kk.'_inputselect'])):?>
			<?php foreach($updatecontent[$kk.'_inputselect'] as $kkk => $vvv):?>
				<option value="<?php echo $kkk?>"><?php echo $vvv?></option>
			<?php endforeach?>
		<?php endif?>
	</select>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
