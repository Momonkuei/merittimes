<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

<?php
		$label_url = $this->createUrl('label/autocomplete');
		$tmp = <<<XXX
$("#{$vv['attr']['id']}").autocomplete("{$label_url}", {
	width: 320,
	max: 10,
	highlight: false,
	scroll: true,
	scrollHeight: 300,
	formatItem: function(data, i, n, value) {
		var returnvalue = '';
		var tmps1 = value.split('----')[0];
		var tmps2 = value.split('----')[1];
		returnvalue = '片語名稱 : ml:' + tmps1 + '<br />';
		var tmpsa = tmps2.split('*****');
		for(var keya in tmpsa){
			returnvalue += tmpsa[keya].split('===')[0]+' : '+tmpsa[keya].split('===')[1]+'<br />';
		}
		return returnvalue;
	},
	formatResult: function(data, value) {
		return 'ml:'+value.split('----')[0];
	}
});
XXX;
?>
<?php echo $tmp?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<?php // 含有多國語系片語搜尋功能的欄位 ?>
	<input type="text" <?php echo $formattr?> value="<?php echo G::ae($updatecontent, 'updatecontent.'.$kk)?>" />
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
