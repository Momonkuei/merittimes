<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php
// 模組相關設定
$tmp_module_config = array(
	'name' => '日期',
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

	<?php //Yii::app()->clientScript->registerCoreScript('jquery.datepicker');//2021-12-10 這邊如果重複載入 widget.js 會報錯...先註解 by lota?>
<?php
	$tmp = <<<XXX
$.datepicker.regional['zh-TW'] = {
	closeText: '關閉',
	prevText: '&#x3c;上月',
	nextText: '下月&#x3e;',
	currentText: '今天',
	monthNames: ['一月','二月','三月','四月','五月','六月',
	'七月','八月','九月','十月','十一月','十二月'],
	monthNamesShort: ['一','二','三','四','五','六',
	'七','八','九','十','十一','十二'],
	dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
	dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
	dayNamesMin: ['日','一','二','三','四','五','六'],
	weekHeader: '周',
	dateFormat: 'yy/mm/dd',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: true,
	yearSuffix: '年'};
$.datepicker.setDefaults($.datepicker.regional['zh-TW']);
$('#{$kk}').datepicker({dateFormat: 'yy-mm-dd'});
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

<?php //var_dump($vv['other'])?>

	<input 
		<?php echo $formattr?>
		<?php if(!isset($vv['attr']['size'])):?>size="10"<?php endif?>
		<?php if(isset($vv['other']['readonly'])):// 2020-08-25 因為json的關係，所以是當做字串判斷?>
			<?php if($vv['other']['readonly'] == 'true'):?>
				readonly="readonly"
			<?php endif?>
		<?php else:?>
			readonly="readonly"
		<?php endif?>
		<?php if(!isset($vv['attr']['type'])):?>type="text"<?php endif?>
		<?php if(!isset($vv['attr']['value'])):?>value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>"<?php endif?>
	/>

	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
