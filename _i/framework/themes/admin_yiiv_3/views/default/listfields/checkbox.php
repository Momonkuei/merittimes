<?php

/*
'is_home' => array(
	'label' => '首頁',
	'width' => '10%',
	'align' => 'center',
	'func_checkbox' => array(
		'enable' => true,
		'define' => array(
			'id' => 'id',
			'text' => '&nbsp;',
			'limit' => '0',
			'reload' => '0',
			'alert' => '',
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
	// 'name' => 'name', // 這裡沒有用到
	'text' => '&nbsp;', // checkbox右邊的文字，預設空白
	'limit' => '0', // 預設不限制勾選數量
	'reload' => '0', // 預設不需要重整頁面
	'alert' => '', // 預設不需要出現提示訊息
);
if(isset($this->data['vv_type_vv']['func_'.$func]['define']) and is_array($this->data['vv_type_vv']['func_'.$func]['define'])){
	$define = $this->data['vv_type_vv']['func_'.$func]['define'];
}

if(isset($this->data['vv_type_vv']['func_'.$func]['enable']) and $this->data['vv_type_vv']['func_'.$func]['enable'] === true){
	$mains = $this->data['vv_type_vv']['func_'.$func]; // 指的是模組化func_XXX裡面所有的元素
	$id_limit = $define['limit'];
	$id_reload = $define['reload'];
	$id_alert = $define['alert'];
} else {
	return;
}

$ggg = <<<XXX0

	//即時點選，即時更改
	$('.index_{$field}').change(function(){
		var value = 0;
		if($(this).attr('checked')){
			value = 1;
		}

		// 其它的控制變數
		var id_reload = '{$id_reload}';
		var id_alert = '{$id_alert}';

		$.ajax({
			type: "POST",
			data: {
				'uptime': 1,
				'value': value,
				'id': $(this).attr('myid'),
				'field': '{$field}'
			},
			url: '{$class_url}/checkbox_listcontent_trigger',
			success: function(response){
				if(response == 1){
					if(id_alert != ''){
						alert(id_alert);
					}
					if(id_reload == '1'){
						location.reload();
					}
				}
			}
		}); // ajax
	});

XXX0;

if($id_limit > 0){
	$search_def = $this->data['def'];
	if(isset($search_def['condition'][0][1])){
		if(trim($search_def['condition'][0][1]) != ''){
			$search_def['condition'][0][1] .= ' AND '.$field.' = 1';
		} else {
			$search_def['condition'][0][1] = ' '.$field.' = 1';
		}
	}
	$total_rows = G::dbc($this->data['router_method'], $search_def);

	if($total_rows >= $id_limit){
		$id_limit = 0;
	} elseif($total_rows < $id_limit){
		$id_limit = $id_limit - $total_rows;
	}

	$current_rows = 0;
	foreach($this->data['listcontent'] as $gggaaa1 => $gggaaa2){
		if(isset($gggaaa2[$field]) and $gggaaa2[$field] == 1){
			$current_rows++;
		}
	}

	if($current_rows > 0){
		$id_limit = $id_limit + $current_rows;
	}

}


if($id_limit > 0){
	
	$ggg .= <<<XXX0

	//這個是複數(跨頁要去調整max_lenn變數)
	var min_lenn = 0 , max_lenn = {$id_limit};

	$('.index_{$field}').on('click',function(){

		if($(this).prop('checked')){	
			min_lenn = min_lenn +1;										
		}else{
			min_lenn = min_lenn -1;						
		}

		if(min_lenn == max_lenn){
			$('.index_{$field}').each(function(){
				if(!$(this).prop('checked')){
					$(this).attr('disabled',true);
					$(this).parent().parent().addClass('disabled');		
				}
			});
		}else{
			$('.index_{$field}').each(function(){
				$(this).attr('disabled',false);
				$(this).parent().parent().removeClass('disabled');			
			});
		}
	});

	$('.index_{$field}').each(function(){
		if($(this).prop('checked')){
			min_lenn = min_lenn +1;
		}

		if(min_lenn >= max_lenn){
			$('.index_{$field}').each(function(){
				if(!$(this).prop('checked')){
					$(this).attr('disabled',true);
					$(this).parent().parent().addClass('disabled');
				}
			});
		}
	});	

XXX0;
} // limit

Yii::app()->clientScript->registerScript('ggg', $ggg, CClientScript::POS_READY);
?>

<input type="checkbox" class="index_<?php echo $field?>" myid="<?php echo $listv[$define['id']]?>" name="index_<?php echo $field?>"  value="" <?php if(isset($listcontent[$k][$field]) and $listcontent[$k][$field] == '1'):?> checked="checked" <?php endif?> />&nbsp;<?php echo $define['text']?>
