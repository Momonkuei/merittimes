<?php

if(!empty($def['updatefield']['head'])){
	foreach($def['updatefield']['head'] as $v){
		Yii::app()->clientScript->registerCoreScript($v);
	}// foreach
} //if

$update_default_1 = $this->renderPartial('//includes/default_validate', $this->data)."\n";
if(isset($update_success) and $update_success == '1'){
	$update_default_1 .= "alert(l.get('Update success'));\n";
}

$update_default_1 .= $this->renderPartial('//default/update_javascript', $this->data)."\n";
// 自定的javascript區塊，存放在實體檔案
if(isset($def['updatefield']['smarty_javascript']) and $def['updatefield']['smarty_javascript'] != ''){
	$update_default_1 .= $this->renderPartial('//'.$def['updatefield']['smarty_javascript'], $this->data)."\n";
}

// 自定的javascript區塊，存放資料庫
if(isset($def['updatefield']['smarty_javascript_text']) and $def['updatefield']['smarty_javascript_text'] != ''){
	$update_default_1 .= $def['updatefield']['smarty_javascript_text']."\n";
}

$update_default_1 .= <<<XXX1
XXX1;

Yii::app()->clientScript->registerScript('update_default_1', $update_default_1, CClientScript::POS_END);
?>

<?php //*麵包或是功能標題*}} ?>
<div class="main_content">

	<?php $this->data['action'] = $def['updatefield']['method']?>
	<?php echo $this->renderPartial('//includes/function_title', $this->data)?>

	<?php if(!empty($def['updatefield'])):?>

		<?php if($def['updatefield']['form']['enable'] == true):?>
			<?php $formattr = ''?>
			<?php if(!empty($def['updatefield']['form']['attr'])):?>
				<?php foreach($def['updatefield']['form']['attr'] as $k => $v):?>
					<?php $formattr = $formattr.' '.$k.'="'.$v.'"'?>
				<?php endforeach?>
			<?php endif?>
			<?php // enctype="multipart/form-data" ?>
			<form <?php echo $formattr?>>
		<?php endif?>

		<?php // 合併簡易和進階授權表 ?>
		<?php if(preg_match('/^sub(.*)/', $this->data['router_class'], $matches)):?>
			<?php echo $this->renderPartial('//'.$matches[1].'/update_fields', $this->data)?>
		<?php else:?>
			<?php echo $this->renderPartial('//'.$this->data['router_class'].'/update_fields', $this->data)?>
		<?php endif?>

		<div class="buttons indexgo03" style2="clear:both;">
			<button class="button btn_send" type="submit"><?php G::te($this->data['theme_lang'], 'Submit', null, '送出')?></button>
			<button class="button white btn_send" type="submit"><?php G::te($this->data['theme_lang'], 'Reset', null, '清除')?></button>
			<button onclick="document.location.href='<?php echo $prev_url?>';" class="button white btn_send" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
		</div>

		<?php if($def['updatefield']['method'] == 'update'):?>
		<input type="hidden" name="hidden_id" value="<?php echo $updatecontent['id']?>" />
		<?php endif?>
		<input type="hidden" name="update_base64_url" value="<?php echo $update_base64_url?>" />
		<input type="hidden" name="prev_url" value="<?php echo $prev_url?>" />

		<?php if($def['updatefield']['form']['enable'] == true):?>
		</form>
		<?php endif?>

	<?php endif?><?php //empty($def.updatefield)?>

</div>
