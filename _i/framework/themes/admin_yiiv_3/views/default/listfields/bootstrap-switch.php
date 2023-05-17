<?php

/*
'is_enable' => array(
	'label' => '狀態',
	'width' => '10%',
	'align' => 'center',
	'func_checkbox' => array(
		'enable' => true,
		'define' => array(
			'id' => 'id',
			'name' => 'name',
		),
	),
),

其它
$listcontent[$k]['id']

$this->data['vv_type_func'] 等於 checkbox
 */

$func = $this->data['vv_type_func']; // checkbox 
$field = $this->data['vv_type_kk']; // is_enable
$listv = $this->data['vv_type_listv'];

$define = array(
	'id' => 'id',
	'name' => 'name', // 這裡沒有用到
);
if(isset($this->data['vv_type_vv']['func_'.$func]['define']) and is_array($this->data['vv_type_vv']['func_'.$func]['define'])){
	$define = $this->data['vv_type_vv']['func_'.$func]['define'];
}

if(isset($this->data['vv_type_vv']['func_'.$func]['enable']) and $this->data['vv_type_vv']['func_'.$func]['enable'] === true){
	$mains = $this->data['vv_type_vv']['func_'.$func]; // 指的是模組化func_XXX裡面所有的元素
} else {
	return;
}


$ggg = <<<XXX0

	$('.index_{$field}').change(function(){

		var value = 0;
		if($(this).attr('checked')){
			value = 1;
		}

		$.ajax({
			type: "POST",
			data: {
				'uptime': 1,
				'value': value,
				'id': $(this).attr('myid'),
				'field': '{$field}'
			},
			url: '{$class_url}/dropdown_listcontent_trigger',
			success: function(response){
				if(response == '1'){
					//location.reload();
				}
			}
		}); // ajax
	});
XXX0;
Yii::app()->clientScript->registerScript('ggg', $ggg, CClientScript::POS_READY);
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.switch')?>

<div class="make-switch switch-mini" data-on-label="ON"  data-text-label="　　　&nbsp;" data-off-label="NO">
	<input type="checkbox" class="toggle index_<?php echo $field?>" myid="<?php echo $listv[$define['id']]?>" name="index_<?php echo $field?>" <?php if(isset($listcontent[$k][$field]) and $listcontent[$k][$field] == '1'):?> checked="checked" <?php endif?> value="1"/>
</div>
