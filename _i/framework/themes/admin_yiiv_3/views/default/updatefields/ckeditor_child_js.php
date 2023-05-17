<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php Yii::app()->clientScript->registerCoreScript('ckeditorchild')?>
<?php
	$tmp = <<<XXX
var editor = CKEDITOR.replace("{$kk}");
CKFinder.setupCKEditor(editor, '../ckfinder/'); 
XXX;
?>
<?php 
//2021-05-23 為了自定義ckeditor擴充 by lota
if(isset($this->data['_CKEDITOR_setup'])){
	echo $this->data['_CKEDITOR_setup'];
}else{
	echo $tmp;
}
?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<textarea <?php echo $formattr?> ><?php echo G::a($this->data['updatecontent'], 'updatecontent.'.$kk)?></textarea>
	<p style="height:10px;">&nbsp;</p>
<?php endif?>

<?php if(0):?>
<?php endif?>
