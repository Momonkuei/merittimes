<?php

// 想指定資料，但想要用檔案名稱而不想要用編號的寫法
// if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>'Now on Sale','class_name'=>'eventMenu'); // eventMenu(促銷方案在用的), proCatalog(分類在用的), sideFilter(規格那些)
eval('$_constant_1 = '.strtoupper('shop_show_promotions').';');
if($_constant_1){ //有主題活動

	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>t('主題活動'),'class_name'=>'proCatalog'); // eventMenu, proCatalog, sideFilter
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1]] = array('name'=>t('分類'),'class_name'=>'proCatalog'); // eventMenu, proCatalog, sideFilter
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][2])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][2]] = array('name'=>t('價格區間'),'class_name'=>'sideFilter');

	// 判斷如果沒有主題活動，就減少區塊
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'])){
		if(isset($data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]]) and empty($data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]])){
			if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>'','class_name'=>'');
		}
	}

} else { //沒主題活動
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>t('產品分類'),'class_name'=>'proCatalog'); // eventMenu, proCatalog, sideFilter
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1]] = array('name'=>t('價格區間'),'class_name'=>'sideFilter');
}

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
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0])){
		$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]] = $tmps2; //洞要先準備好 下面的要改1
	}	

	// Categories 分類
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][1])){
		$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][1]] = $tmps;
	}	

}else{//沒主題活動
	// Categories 分類
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0])){
		$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]] = $tmps;
	}	
}


$is_item = false;

//var_dump($rows);
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		$v['url1'] = $v['url2'] = $v['url'];

		if($common_is_category == 1){ // 有分類的情況 #25898 George發現的bug
			if($common_has_listpage == '1' and $id == 0){ // 總覽頁(beta) 群翊

				$is_item = true;

//			} elseif(isset($v[$class_id_name]) and isset($tmps_tmp[$v[$class_id_name]])){ // 分項列表
//
//				$is_item = true;
//
			} elseif(isset($v['pid'])){ // 分類列表

				$is_item = false;

			} else { // 分類列表

				$is_item = true;

			}

		} else { // common_is_category == 1

			$is_item = true;

		}

		if($is_item === true){
			// 其實這裡應該是，後台要在新增另外一個欄位，只是懶的新增，所以先註解起來
			//$db->row['name2'] = $db->row['detail'];

			//$db->row['name2'] = $db->row['name'];
			//$db->row['name'] = $tmp['name'];

			$v['img_alt'] = $v['name']; // SEO

			$v['price'] = 0;
			$v['price2'] = 0;
			$rowg = $this->cidb->where('is_enable',1)->where('data_id',$v['id'])->get('shopspec')->row_array();
			if($rowg and isset($rowg['id'])){
				$v['price'] = $rowg['price'];
				$v['price2'] = $rowg['price2'];

				//先查詢該產品是否有主題活動, 使用$_ids參照，符合的話就撈主題活動資料
				$_action2 = $_action1 = 0;
				if(isset($_ids) and !empty($_ids)){
					foreach ($_ids as $key => $value) {
						if(in_array($v['id'], $value)){
							$vg = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$key))->queryRow();
							if($vg['condition1']=='2' && $vg['condition2']=='1'){
								// var_dump($v);die;
								$_action1 = $vg['action1'];
								$_action2 = $vg['action2'];
							}
							break;//有找到就跳出去
						}
					}
				}

				//列表顯示特定主題活動的折扣 
				if(isset($_action1) && isset($_action2)){ 
					if($_action1=='1'){ //打折
						eval('$v[\'price2\'] = round2($v[\'price2\'] * 0.' . $_action2 . ',0);');		
					}
					if($_action1=='2'){ //定額
						$v['price2'] = $_action2;
					}
					if($_action1=='3'){ //折抵
						$v['price2'] = $rowg['price2'] - $_action2;
						if($v['price2'] < 0){
							$v['price2'] = 0;
						}
					}
				}

			}

			foreach(array('price','price2') as $_price){
				$v[$_price.'_format'] = number_format($v[$_price]);
				$v[$_price.'_format_ds'] = '$'.$v[$_price.'_format'];
				$v[$_price.'_format_ds_nt'] = 'NT'.$v[$_price.'_format_ds'];
			}

			// 檢查收藏
			$v['has_favorite'] = 0;
			if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
				$row = $this->db->createCommand()->from('html')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$v['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
				if(isset($row['id']) and $row['id'] > 0){
					$v['has_favorite'] = 1;
				}
			} else {
				if(isset($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite']) and !empty($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'])){
					foreach($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'] as $kk => $vv){
						if(preg_match('/^'.$v['id'].'_(\d+)$/', $kk)){
							$v['has_favorite'] = 1;
							break;
						}
					}
				}
			}
		} // is_item

		$rows[$k] = $v;
	}
}

if($is_item === true){
	// 這裡是從source/favorite/list.php複製過來的
	$items2 = $rows;

	// 目前有跟source/favorite/list.php和首頁的共用
	include 'source/shop/spec_float_include.php';

	$rows = $items2;
	unset($items2);
}
