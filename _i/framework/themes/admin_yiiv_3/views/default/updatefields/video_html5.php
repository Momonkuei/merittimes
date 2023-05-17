<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php $tmp01 = explode('.', $updatecontent[$kk])?>
	<video width="320" height="240" autoplay="autoplay">
	<source src="<?php echo $this->data['file_upload_path'].'/'.$this->data['router_class'].'/'.$updatecontent[$kk]?>" type="video/<?php echo $tmp01[count($tmp01)-1]?>">
		Your browser does not support the video tag.
	</video> 
<?php endif?>
