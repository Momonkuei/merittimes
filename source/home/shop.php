<?php

$sql = 'select * from shop ';
$sql .= ' WHERE is_enable=1 and is_home=1 and ml_key=\''.$this->data['ml_key'].'\'';	
$sql .= ' and (date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")';
$rows = $this->cidb->query($sql)->result_array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		$v['pic'] = '_i/assets/upload/shop/'.$v['pic1'];

		$v['price'] = 0;
		$v['price2'] = 0;
		$rowg = $this->cidb->where('is_enable',1)->where('data_id',$v['id'])->get('shopspec')->row_array();
		if($rowg and isset($rowg['id'])){
			$v['price'] = $rowg['price'];
			$v['price2'] = $rowg['price2'];
		}
		$rows[$k] = $v;
	}
}
$items2 = $rows;

// 目前有跟source/shop/list.php和首頁的共用
include _BASEPATH.'/../source/shop/spec_float_include.php';

$rows = $items2;

//$data[$ID] = $rows;

//echo $ID;
//var_dump($layoutv3_struct_map_keyname['v3/widget/add_cart_panel']);
//$data[$layoutv3_struct_map_keyname['v3/widget/add_cart_panel'][0]] = $rows; 
//var_dump($rows);

$page_source_data_param1 = 'home-shop';
$page_source_data_param2 = $rows;
$page_source_data_other = array('assign_force' => true);
include _BASEPATH.'/../source/system/page_source_data.php';
