<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

<?php
		if(!isset($vv['other']['len']) or $vv['other']['len'] == ''){
			$len = '6';
		} else {
			$len = $vv['other']['len'];
		}

		if(!isset($vv['other']['no_value_trigger']) or $vv['other']['no_value_trigger'] == ''){
			$no_value_trigger = false;
		} else {
			$no_value_trigger = true;
		}

		$data = false;
		if(isset($updatecontent[$kk]) and $updatecontent[$kk] != ''){
			$data = $updatecontent[$kk];
		}

		$tmp2 = <<<XXX
$('#{$vv['attr']['id']}_regen').click(function(){
	$.ajax({
		type: "POST",
		url: '{$class_url}/regen&len={$len}',
		success: function(response){
			$('#{$vv['attr']['id']}').attr('value', response);
		}
	});
	return false;
});
XXX;

		if($no_value_trigger and !$data){
		$tmp2 .= <<<XXX

$('#{$vv['attr']['id']}_regen').click();

XXX;
		}
?>
		<?php echo $tmp2?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<input type="text" <?php echo $formattr?> <?php if(!isset($vv['other']['disable_value']) or (isset($vv['other']['disable_value']) and $vv['other']['disable_value'] == false)):?>value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>"<?php endif?> />
	<a href="javascript:;" id="<?php echo $vv['attr']['id']?>_regen">重新產生</a>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
