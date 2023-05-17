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

<?php $this->data['action'] = $def['updatefield']['method']?>
<?php echo $this->renderPartial('//includes/function_title', $this->data)?>

<?php //*麵包或是功能標題*}} ?>
<div class="row-fluid">

	<?php if(count($this->data['tcofastmenus']) > 0):?>
	<div class="span10">
	<?php else:?>
	<div class="span12">
	<?php endif?>

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

		<?php echo $this->renderPartial('//member/update_fields', $this->data)?>

		<div class="buttons indexgo03" style2="clear:both;">
			<?php if(!isset($this->data['router_method_view']) or $this->data['router_method_view'] != '1'):?>
				<button class="btn blue" type="submit"><i class="icon-ok"></i><?php G::te($this->data['theme_lang'], 'Submit', null, '送出')?></button>
				<button class="btn red" type="reset"><?php G::te($this->data['theme_lang'], 'Reset', null, '清除')?></button>
<?php if(isset($prev_url) and $prev_url != ''):?>
			<button onclick="document.location.href='<?php echo $prev_url?>';" class="btn green" type="button"><?php G::te($this->data['theme_lang'], 'Previous', null, '上一頁')?></button>
<?php endif?>
			<?php endif?>

			<?php if(isset($this->data['submit_buttons'])):?>
				<?php foreach($this->data['submit_buttons'] as $k => $v):?>
					<?php if(!isset($v['html'])):?><?php break?><?php endif?>
					<?php $v1 = $v?>
					<?php unset($v1['html'])?>
					<button <?php foreach($v1 as $kk => $vv):?><?php echo ' '.$kk.'="'.$vv.'" ' ?><?php endforeach?>><?php echo $v['html']?></button>
				<?php endforeach?>
			<?php endif?>

		</div>

		<?php if($def['updatefield']['method'] == 'update'):?>
		<input type="hidden" name="hidden_id" value="<?php G::ae($updatecontent, 'updatecontent.id')?>" />
		<?php elseif($def['updatefield']['method'] == 'create'):?>
		<input type="hidden" name="hidden_id" value="<?php G::ae($updatecontent, 'updatecontent.random_id')?>" />
		<?php endif?>
		<input type="hidden" name="update_base64_url" value="<?php if(isset($update_base64_url)){ echo $update_base64_url; }?>" />
		<input type="hidden" name="prev_url" value="<?php if(isset($update_base64_url)){ echo $prev_url; }?>" />

		<?php if($def['updatefield']['form']['enable'] == true):?>
		</form>
		<?php endif?>

	<?php endif?><?php //empty($def.updatefield)?>

	</div> <!-- span12 -->

	<?php echo $this->renderPartial('//includes/tcofastmenu', $this->data)?>

</div> <!-- row-fluid -->
