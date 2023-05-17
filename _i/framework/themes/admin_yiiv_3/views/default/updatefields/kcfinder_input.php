<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

<?php
		$vir_path_c = vir_path_c;

		// 除掉_ozman資料夾，先個案處理，之後在看看
		$vir_path_c2 = str_replace('/_i', '', $vir_path_c);
		// type，例如files
		// dir，例如files/public
		$tmp2 = <<<XXX
function openKCFinder(field, uploadurl_id, type, dir) {
    window.KCFinder = {
        callBack: function(url) {
			url = url.replace("{$vir_path_c2}", '');
            field.value = url;
            window.KCFinder = null;
        }
    };
	//alert('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&type='+type+'&dir='+dir);
    window.open('{$vir_path_c}kcfinder/browse.php?uploadurl_id='+uploadurl_id+'&lang=zh-tw&type='+type+'&dir='+dir, 'kcfinder_textboxg',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}
$('#{$vv['attr']['id']}_clear').click(function(){
	$('#{$vv['attr']['id']}').attr('value', '');
	$('#{$vv['attr']['id']}').parent().find('img').remove();
	return false;
});
XXX;
?>
<?php echo $tmp2?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php // 想要做可以換路徑的文字欄位點下去，觸發kcfinder新視窗 ?>
	<?php // uploadurl_id為0的時候，會吃預設值的路徑，是kcfinder裡面的upload資料夾 ?>
	<input type="text" <?php echo $formattr?> readonly="readonly" onclick="javascript:openKCFinder(this, <?php if(isset($vv['other']['uploadurl_id']) and $vv['other']['uploadurl_id'] != ''):?>'<?php echo $vv['other']['uploadurl_id']?>'<?php else:?>'0'<?php endif ?>, <?php if(isset($vv['other']['type']) and $vv['other']['type'] != ''):?>'<?php echo $vv['other']['type']?>'<?php else:?>''<?php endif?>, <?php if(isset($vv['other']['dir']) and $vv['other']['dir'] != ''):?>'<?php echo $vv['other']['dir']?>'<?php else:?>''<?php endif?>)" style="cursor:pointer" value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>" />
	<a href="javascript:;" id="<?php echo $vv['attr']['id']?>_clear">清除</a>
	<?php if(isset($updatecontent[$kk]) and $updatecontent[$kk] != '' and preg_match('/\.(png|gif|jpg|jpeg)/i', $updatecontent[$kk])):?>
		<br />
		<img
			<?php if(isset($vv['other']['width']) and $vv['other']['width'] != ''):?>width="<?php echo $vv['other']['width']?>"<?php endif?>
			<?php if(isset($vv['other']['height']) and $vv['other']['height'] != ''):?>height="<?php echo $vv['other']['height']?>"<?php endif?>
			src="<?php echo vir_path_c.str_replace('_i/', '', $updatecontent[$kk])?>"
		/>
	<?php endif?>
<?php endif?>
