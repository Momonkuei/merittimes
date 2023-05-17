<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php
// 模組相關設定
$tmp_module_config = array(
	'name' => '顏色',
	'fields' => array(
		'html__id' => 'ID|',
		'html__name' => 'NAME|',
		//'other__merge' => '合併左右欄位|',
		//'other__html_start' => '左邊HTML|',
		//'other__html_end' => '右邊HTML|',
		//'emptyorm_rules__required' => '是否必填|0,1,true,false',
		//'other__table_type' => '欄位類型|varchar,int,tinyint',
		//'other__table_length' => '欄位長度|例：10',
	),
);

?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php Yii::app()->clientScript->registerCoreScript('jquery.colorpicker')?>
<?php
	$tmp = <<<XXX
	$('.colorpicker-default').colorpicker({
		format: 'hex'
	});
XXX;
?>
<?php echo $tmp?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>

	<?php if($def['updatefield']['method'] == 'update'):?>
	<?php else:?>
	<?php endif?>

	<div class="col-xs-5 input-group color colorpicker-default" data-color="<?php if(isset($updatecontent[$kk])):?><?php echo $updatecontent[$kk]?><?php else:?>#3865a8<?php endif?>" data-color-format="rgba">                                       
	   <span class="input-group-btn">
	   <button class="btn default" type="button"><i style="background-color: #3865a8;"></i>&nbsp;</button>
	   </span>
	   <input type="text" class="form-control" <?php echo $formattr?> <?php if(isset($updatecontent[$kk])):?>value="<?php echo $updatecontent[$kk]?>"<?php else:?>value="#3865a8"<?php endif?> <?php //readonly?>>
	</div>

	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
