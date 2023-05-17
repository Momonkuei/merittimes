<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php
// 模組相關設定
$tmp_module_config = array(
	'name' => '純文字欄位',
	'fields' => array(
		'html__id' => 'ID|',
		'other__html_start' => '左邊HTML|',
		'emptyorm_rules__required' => '是否必填|0,1,true,false',
	),
);

?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'update_show_first'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

<?php
	if(isset($vv['other']['number_only']) and $vv['other']['number_only']){
		$tmp = <<<XXX
$('#{$vv['attr']['id']}').keydown(function (e) {
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		 // Allow: Ctrl+A, Command+A
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		 // Allow: home, end, left, right, down, up
		(e.keyCode >= 35 && e.keyCode <= 40)) {
			 // let it happen, don't do anything
			 return;
	}
	// Ensure that it is a number and stop the keypress
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});
XXX;
		echo $tmp;
	}
?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>
<?php //var_dump($updatecontent)?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
		<input <?php echo $formattr?> <?php if(!isset($vv['attr']['type'])):?>type="text"<?php endif?> <?php if(!isset($vv['attr']['value'])):?>value="<?php echo htmlspecialchars(G::a($updatecontent, 'updatecontent.'.$kk))?>"<?php endif?> />
		<?php if(isset($vv['other']['has_copy']) and $vv['other']['has_copy'])://2020-11-17?>
		<script type="text/javascript">
		function myfunction_<?php echo $vv['attr']['id']?>() {
		  /* Get the text field */
		  var copyText = document.getElementById("<?php echo $vv['attr']['id']?>");

		  /* Select the text field */
		  copyText.select();
		  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		  /* Copy the text inside the text field */
		  document.execCommand("copy");

		  /* Alert the copied text */
		  alert("複製文字: " + copyText.value);
		} 
		</script>
			<button class="btn btn-info" onclick="javascript:myfunction_<?php echo $vv['attr']['id']?>();return false;">複製</button> 
		<?php endif?>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
