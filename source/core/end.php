<?php

$prefix = 'shop';

/*
 * 購物車和收藏的數量
 */

// $rows = $data[$layoutv3_struct_map_keyname['v3/header/top_link_menu'][0]];
// 
// if($rows and count($rows) > 0){
// 	foreach($rows as $k => $v){
// 		if($v['func'] == 'shop' and preg_match('/^(.*) \((.*)>(\d+)<(.*)\)$/', $v['name'], $matches)){
// 			if(!isset($_SESSION['save'][$prefix.'_car'])) $_SESSION['save'][$prefix.'_car'] = array();
// 			$result = count($_SESSION['save'][$prefix.'_car']);
// 			if($result < 0){
// 				$result = 0;
// 			}
// 			$v['name'] = $matches[1].' (<span id="car_amount">'.$result.'</span>)';
// 		} elseif($v['func'] == 'favorite' and preg_match('/^(.*) \((.*)>(\d+)<(.*)\)$/', $v['name'], $matches)){
// 			if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
// 				$condition = array(
// 					'type' => 'favorite',
// 					'is_enable' => '1',
// 					'ml_key' => $this->data['ml_key'],
// 					'member_id' => $this->data['admin_id'],
// 				);
// 				$tmps = $this->db->where($del)->get('html')->result_array(); 
// 				$result = count($tmps);
// 				$v['name'] = $matches[1].' (<span id="favorite_amount">'.$result.'</span>)';
// 			} else {
// 				if(!isset($_SESSION['save'][$prefix.'_favorite'])) $_SESSION['save'][$prefix.'_favorite'] = array();
// 				$result = count($_SESSION['save'][$prefix.'_favorite']);
// 				if($result < 0){
// 					$result = 0;
// 				}
// 				$v['name'] = $matches[1].' (<span id="favorite_amount">'.$result.'</span>)';
// 			}
// 		}
// 		$rows[$k] = $v;
// 	}
// }
// 
// $data[$layoutv3_struct_map_keyname['v3/header/top_link_menu'][0]] = $rows;

/*
 * 購物車浮起來的視窗
 */

// 部份從source/checkout.php那邊複製過來的

if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/side_cart'])){
	if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){
		$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/side_cart'][0]]['multi'][] = array();
		$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/side_cart'][0]]['single'][] = array(
			'count' => 0,
			'total' => '$0',
		);
	} else {
		//include 'source/shop/checkout_include_a_v1.php';
		include 'source/shop/checkout_include_a_v2.php';
		if($car and !empty($car)){
			$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/side_cart'][0]]['multi'][] = $car;
			$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/side_cart'][0]]['single'][] = array(
				'count' => count($car),
				'total' => '$'.number_format($total_sub),
			);
		} else {
			$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/side_cart'][0]]['multi'][] = array();
			$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/side_cart'][0]]['single'][] = array(
				'count' => 0,
				'total' => '$0',
			);
		}
	}
}
