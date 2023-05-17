<?php

/*
'is_enable' => array(
	'label' => '狀態',
	'width' => '10%',
	'align' => 'center',
	'func_dropdown' => array(
		'enable' => true,
		'values' => array(
			array('id' => '1', 'name' => '顯示', 'is_selected' => '1'),
			array('id' => '1', 'name' => '停用'),
		),
		'define' => array(
			'id' => 'id',
			'name' => 'name',
			'is_selected' => 'is_selected',
		),
	),
),

其它
$listcontent[$k]['id']

$vv['ezuptime'] 等於 ($this->data['vv_type_vv']['ezuptime'])

$this->data['vv_type_func'] 等於 dropdown
 */

$func = $this->data['vv_type_func']; // dropdown
$field = $this->data['vv_type_kk']; // is_enable
$listv = $this->data['vv_type_listv'];

$define = array(
	'id' => 'id',
	'name' => 'name',
	'is_selected' => 'is_selected',
);
if(isset($this->data['vv_type_vv']['func_'.$func]['define']) and is_array($this->data['vv_type_vv']['func_'.$func]['define'])){
	$define = $this->data['vv_type_vv']['func_'.$func]['define'];
}

if(isset($this->data['vv_type_vv']['func_'.$func]['enable']) and $this->data['vv_type_vv']['func_'.$func]['enable'] === true){
	$mains = $this->data['vv_type_vv']['func_'.$func];
	$values = array();
	if(isset($mains['values']) and is_array($mains['values'])){
		$values = $mains['values'];
	}

	if(isset($listv[$field]) and is_array($listv[$field])){
		$values = $mains['values'];
	} else {
		if(count($values) > 0){
			foreach($values as $kkkk => $vvvv){
				if($vvvv[$define['id']] == $listv[$field]){
					$values[$kkkk][$define['is_selected']] = '1';
				}
			}
		}
	}
} else {
	return;
}

$ggg = <<<XXX0

	$('.index_{$field}').change(function(){
		$.ajax({
			type: "POST",
			data: {
				'uptime': 1,
				'value': $(this).val(),
				'id': $(this).attr('myid'),
				'field': '{$field}'
			},
			url: '{$class_url}/dropdown_listcontent_trigger',
			success: function(response){
				if(response == '1'){
					location.reload();
				}
			}
		}); // ajax
	});
XXX0;
Yii::app()->clientScript->registerScript('ggg', $ggg, CClientScript::POS_READY);
?>

<select class="form-control index_<?php echo $field?>" myid="<?php echo $listv[$define['id']]?>" name="index_<?php echo $field?>" >
	<?php if(isset($values) and count($values) > 0):?>
		<?php foreach($values as $kkkk => $vvvv):?>
			<option value="<?php echo $vvvv[$define['id']]?>" <?php if(isset($vvvv[$define['is_selected']]) and $vvvv[$define['is_selected']] == '1'):?> selected="selected" <?php endif?> ><?php echo $vvvv[$define['name']]?></option>
		<?php endforeach?>
	<?php endif?>
</select>
