<?php
//購物產品類別資料
$tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($tmps){
	foreach($tmps as $k => $v){
		$v['url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id='.$v['id'];
		$v['parent_id'] = $v['pid'];
		$tmps[$k] = $v;
	}
}
//主題活動資料
$tmps2 = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'promotion')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($tmps2){
	foreach($tmps2 as $k => $v){
		$v['url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id=s'.$v['id'];

		// 2020-10-14
		$v['attr2'] = ' href="'.$v['url'].'" ';

		$v['parent_id'] = 0;

		$v['time'] = strtotime($v['start_time']);
		$v['time2'] = strtotime($v['end_time']);
		if($v['time'] < 0) $v['time'] = 0;
		if($v['time2'] < 0) $v['time2'] = 0;

		//  先檢查時間
		// if($v['time'] > 0){ //不需要判斷啟始時間 by lota fix 2020-11-16
			$now = strtotime(date('Y-m-d H:i:s'));
			//echo date('Y-m-d H:i:s');
			//echo $now;die;
			if($now >= $v['time']){
				// OK
			} else {
				unset($tmps2[$k]);
				continue;
			}
			if($v['time2'] > 0){
				if($now < $v['time2']){
					// OK
				} else {
					unset($tmps2[$k]);
					continue;
				}
			}
		// }

		$tmps2[$k] = $v;
	}
}

//$data[$ID] = $tmps;

eval('$_constant_1 = '.strtoupper('shop_show_promotions').';');
if($_constant_1){//有主題活動
	// Now on Sale 促銷方案
	// $data[$layoutv3_struct_map_keyname['v3/product/promenu'][0]] = $tmps2;
	$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]] = $tmps2; //洞要先準備好 下面的要改1

	// Categories 分類
	$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][1]] = $tmps;

}else{//沒主題活動
	// Categories 分類
	$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]] = $tmps;
}



//如果想變動左側選單區塊，則連parent/shop.php 內的洞要一起動 by lota
// 想指定資料，但想要用檔案名稱而不想要用編號的寫法
// eventMenu(促銷方案在用的), proCatalog(分類在用的), sideFilter(規格那些)
// eval('$_constant_1 = '.strtoupper('shop_show_promotions').';');
// if($_constant_1){
// 	if(isset($layoutv3_struct_map_keyname['v3/shop/block'][0])) $data[$layoutv3_struct_map_keyname['v3/shop/block'][0]] = array('name'=>'促銷方案','class_name'=>'eventMenu'); 
// }else{
// 	if(isset($layoutv3_struct_map_keyname['v3/shop/block'][0])) $data[$layoutv3_struct_map_keyname['v3/shop/block'][0]] = array();
// }

// if(isset($layoutv3_struct_map_keyname['v3/shop/block'][1])) $data[$layoutv3_struct_map_keyname['v3/shop/block'][1]] = array('name'=>'分類','class_name'=>'proCatalog');
// if(isset($layoutv3_struct_map_keyname['v3/shop/block'][2])) $data[$layoutv3_struct_map_keyname['v3/shop/block'][2]] = array('name'=>'尺寸','class_name'=>'sideFilter');
// if(isset($layoutv3_struct_map_keyname['v3/shop/block'][3])) $data[$layoutv3_struct_map_keyname['v3/shop/block'][3]] = array('name'=>'顏色','class_name'=>'sideFilter');
// if(isset($layoutv3_struct_map_keyname['v3/shop/block'][4])) $data[$layoutv3_struct_map_keyname['v3/shop/block'][4]] = array('name'=>'價格區間','class_name'=>'sideFilter');
