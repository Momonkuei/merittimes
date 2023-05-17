<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php $encoded = G::a($updatecontent, 'updatecontent.'.$kk)?>
	<?php // http://strongpasswordgenerator.com/?>
	<?php $key = 'b^[XFg[LW5*"P(x123456';?>
	<?php $result1 = ''?>
	<?php if($encoded != ''):?>
		<?php $result1 = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encoded), MCRYPT_MODE_CBC, md5(md5($key))), "\0")?>
	<?php endif?>
	<textarea <?php echo $formattr?> ><?php echo htmlspecialchars($result1)?></textarea>
<?php endif?>
