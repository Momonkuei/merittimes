<?php
/*
 * https://fullcalendar.io/
 */
?>

<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php
// 模組相關設定
$tmp_module_config = array(
	'name' => '日曆',
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

	<?php Yii::app()->clientScript->registerCoreScript('jquery.fullcalendar')?>
<?php

$url = $vv['other']['url'];

/*
 * url裡面，要回傳下列的東西：
 *
 * $tmp = array(
 * 	"title" => $vv['name'],
 * 	"start" => substr($vv['start_time'],0,10),
 * 	"end" =>  substr($vv['end_time'],0,10),
 * 	'url' => '#',
 * 	'color' => '#333',
 * );
 * $tmps[] = $tmp;
 * echo json_encode($tmps);
 */

	$tmp = <<<XXX

$('#{$kk}').fullCalendar({
	header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
	},
	//defaultDate: '2015-02-12',
	defaultDate: '<?php echo date('Y-m-d')?>',
	editable: false,
	eventLimit: true, // allow "more" link when too many events
	events: {
		url: '{$url}',
		error: function() {
			$('#script-warning').show();
		}
	},
	loading: function(bool) {
		$('#loading').toggle(bool);
	}
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

	<div  id="<?php echo $kk?>" ></div>

	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
