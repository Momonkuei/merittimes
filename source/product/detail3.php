<?php

// https://redmine.buyersline.com.tw/issues/18231#note-44
if(!isset($_GET['id']) or $_GET['id'] == '' or $_GET['id'] <= 0){
	echo '404';
	header('HTTP/1.1 404 Not Found');
	die;
}

$router_method = str_replace('detail','',$this->data['router_method']);

// 單筆
$tmp = $this->db->createCommand()->from($router_method)->where('is_enable=1 and id=:id',array(':id'=>$_GET['id']))->queryRow();

//如果該產品所屬的產品分類已關閉，則該產品顯示404
//如果分類單選改成複選的話，那這邊要記得關掉，不然可能會誤判 for 089house | by lota
$_tt = $this->db->createCommand()->from($router_method.'type')->where('is_enable=1 and id=:id',array(':id'=>$tmp['class_id']))->queryRow();
if(!isset($_tt['id'])){
	// header('Location: https://www.bulk.com.tw');
	header('HTTP/1.1 404 Not Found');	
	die;
}

//37483#note-2 改帶到sub_page_title 
$where = $where_category = array(
			'is_enable' => 1,
			'ml_key' => $this->data['ml_key'],
			'id' => $tmp['class_id'],			
		);
$_tmp = $this->cidb->where($where)->get($router_method.'type')->row_array();
$_tmp['sub_name'] = $_tmp['name'];

//2022-02-17 Ming說要修改的
$_count = count($this->data['_breadcrumb']);
if($_count > 3){
	$_tmp['name'] = $this->data['_breadcrumb'][$_count - 3]['name'];
}

// 2021-12-09 等不到有緣人處理，先註解 by lota
// if(isset($_tmp['pid']) && $_tmp['pid']==0){
// 	unset($_tmp['name']);
// }else{
// 	//目前只有抓兩層資料，之後還要等有緣人優化這邊的程式碼...
// 	if(isset($_tmp['pid'])){
// 		$where['id'] = $_tmp['pid'];
// 		$_tmp2 = $this->cidb->where($where)->get($router_method.'type')->row_array();
// 		if($_tmp2 and isset($_tmp2['id'])){
// 			if(!isset($_tmp2['topic']) and isset($_tmp2['name'])){
// 				$_tmp2['topic'] = $_tmp2['name'];
// 			}
// 			$_tmp2['name'] = $_tmp2['topic'];
// 		}
// 		$_tmp['name'] = $_tmp2['name'];
// 	}	
// }
//如果分類單選改成複選的話，那這邊要記得關掉，不然可能會誤判 for 089house | by lota
$page_source_data_param1 = 'share-page_title';
$page_source_data_param2 = $_tmp;
$page_source_data_other = array('assign_force'=>true);
include _BASEPATH.'/../source/system/page_source_data.php';



$tmp['name2'] = $tmp['detail']; // ckeditor_js 預設編輯器輸出
$tmp['content1'] = $tmp['field_data'];
$tmp['content2'] = $tmp['field_tmp'];

// inquiry
$tmp['inquiry']['id'] = $router_method.'inquiry';
$tmp['inquiry']['primary_key'] = $router_method.'___'.$tmp['id'].'___0'; // 預設型號為零，這是型號範本，請依需求去客制
$tmp['inquiry']['ml_key'] = $this->data['ml_key']; // 2019-10-25
$tmp['inquiry']['_append'] = ''; // 2019-10-25
$tmp['inquiry']['amount'] = 1; // 2019-11-11

// $tmp['inquiry']['url'] = 'save.php?id='.$tmp['inquiry']['id'].'&_append=&amount=1&primary_key='.$tmp['inquiry']['primary_key']; // 預留給A方案

// 預留給A方案 2019-10-25
$tmp2 = array();
if(isset($tmp['inquiry']) and !empty($tmp['inquiry'])){
	foreach($tmp['inquiry'] as $k => $v){
		$tmp2[] = $k.'='.$v;
	}
}
$tmp['inquiry']['url'] = 'save.php?'.implode('&', $tmp2);

$admin_field_router_class = $router_method;
$admin_field_section_id = 1;
include _BASEPATH.'/../source/system/admin_field_get.php';

if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
	if($admin_field['detail']['type'] == 'textarea'){
		$tmp['name2'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
		// $tmp['name2'] = nl2p($tmp['detail']); // ckeditor_js 預設編輯器輸出
	}
}

// SEO
// $data['head_title'] = str_replace($this->data['func_name'].' | ', $tmp['name'].' | ', $data['head_title']); // 預設值(舊的)

// $rowg = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type and seo_item_id='.$_GET['id'],array(':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method'])))->queryRow();
// if($rowg and isset($rowg['id'])){
// 	if($rowg['seo_title'] != ''){
// 		$data['head_title'] = $rowg['seo_title'];
// 	} else {
// 		// 2018-12-19 Ming下午口頭說的
// 		$data['head_title'] = $rowg['name'];
// 	}
// 	if($rowg['seo_meta_keyword'] != ''){
// 		$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
// 	}
// 	if($rowg['seo_meta_description'] != ''){
// 		$this->data['seo_description'] = $rowg['seo_meta_description'];
// 	} else {
// 		// 2018-12-19 Ming下午口頭說的
// 		$this->data['seo_description'] = strip_tags($tmp['detail']);
// 	}
// } else {
// 	// 2018-12-19 Ming下午口頭說的，但是李哥說經理說，要有簽SEO，不然不要開(2018-08-06)
// 	unset($_constant);
// 	eval('$_constant = '.strtoupper('seo_open').';');
// 	if($_constant){
// 		$data['head_title'] = $tmp['name'];
// 		$this->data['seo_description'] = strip_tags($tmp['detail']);
// 	}
// }

//$data[$ID.'_2'] = $tmp;

if(isset($layoutv3_struct_map_keyname['v3/product/tabs_1'])){
	$data[$layoutv3_struct_map_keyname['v3/product/tabs_1'][0]] = $tmp;
}

// 因為多圖，是用第一張的代表圖，和多張上傳，所合併起來的
$rows_big = array();
$rows_small = array();

$rows_big[] = array(
	// #21242
	'name' => $tmp['name'],
	'pic' => cache3($tmp['pic1'],'_i/assets/upload/'.$router_method.'/'),
);

$rows_small[] = array(
	// #21242
	'name' => $tmp['name'],
	'pic' => cache3($tmp['pic1'],'_i/assets/upload/'.$router_method.'/'),
);

//$path = 'webroot._i.assets.members.'.$router_method.'_1_'.$tmp['id'].'.member';
//$tmp2 = array();
//if(is_dir(Yii::getPathOfAlias($path))){
//	$tmp2 = $this->_getFiles(Yii::getPathOfAlias($path));
//	sort($tmp2);//lota 加入排序
//}
//使用 Yii涵式如果遇到客戶主機的資料有 . 的話會解析錯誤，改用PHP原生涵式去抓取 by lota 2019/5/23
//$path = dirname(dirname(dirname(__FILE__))).'/_i/assets/members/'.$router_method.'_1_'.$tmp['id'].'/member/';

// // 多圖 kcfinder版本
// $path = _BASEPATH.'/assets/members/'.$router_method.'_1_'.$tmp['id'].'/member/';
// $tmp2 = array();//初始化
// if(is_dir($path)){	
// 	$_tmp2 = glob($path.'*.*');
// 	if($_tmp2 and !empty($_tmp2)){
// 		foreach ($_tmp2 as $k => $v) {
// 			$tmp2[$k] = str_replace($path,'',$v);//2020-08-28 修正 $key 改 $k; by lota
// 		}
// 		sort($tmp2);//lota 加入排序
// 	}
// }

// // 多張圖 kcfinder版本
// if($tmp2){
// 	foreach($tmp2 as $k => $v){
// 		$tmp2 = explode('/', $v);
// 		$tmp3 = $tmp2[count($tmp2)-1];
// 		$tmp4s = explode('.', $tmp3);
// 		$tmp5 = $tmp3; // 沒有副檔名，當做圖片名稱
// 		if($tmp4s and count($tmp4s) > 0){
// 			unset($tmp4s[count($tmp4s)-1]); // 只刪掉逗點最右邊，因為怕有1個以上的小數點
// 			$tmp5 = implode('.', $tmp4s);
// 		}
// 		// 為了要符合前台版型的規範
// 		$rows_big[] = array(
// 			'pic' => cache3('_i/assets/members/'.$router_method.'_1_'.$tmp['id'].'/member/'.$tmp3),
// 			// #21242
// 			'name' => $tmp5,
// 		);

// 		$rows_small[] = array(
// 			'pic' => cache3('_i/assets/members/'.$router_method.'_1_'.$tmp['id'].'/member/'.$tmp3),
// 			// #21242
// 			'name' => $tmp5,
// 		);
// 	}
// }


//多張圖 資料庫版本 2021-09-10
$_tmp3 = $this->cidb->where('is_enable',1)->where('class_id',$_GET['id'])->order_by('sort_id')->get('productphoto')->result_array();
if($_tmp3){
	foreach ($_tmp3 as $k => $v) {		
		// 為了要符合前台版型的規範
		$rows_big[] = array(
			'pic' => '_i/assets/upload/productphoto/'.$v['pic1'],
			// #21242
			'name' => $v['name'],
		);

		$rows_small[] = array(
			'pic' => cache3('_i/assets/upload/productphoto/'.$v['pic1']),
			// #21242
			'name' => $v['name'],
		);
		
	}
}

// 回列表的連結
$data[$router_method.'_return_url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix;
if($tmp['class_id'] > 0){
	$data[$router_method.'_return_url'] .= '?id='.$tmp['class_id'];
}

$rowg = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type and seo_item_id='.$tmp['class_id'],array(':ml_key'=>$this->data['ml_key'],':type'=>str_replace('detail','',$this->data['router_method']).'type'))->queryRow();
if($rowg and isset($rowg['id']) and $rowg['seo_script_name'] != ''){
	$data[$router_method.'_return_url'] = $url_prefix.$rowg['seo_script_name'].'.html';
}

$data[$ID]['items'] = $tmp;
$data[$ID]['big'] = $rows_big;
$data[$ID]['small'] = $rows_small;

// 相關商品
// $tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and class_id=:id',array(':id'=>$tmp['class_id']))->order('sort_id')->limit(4)->queryAll();
// if($tmps){
// 	foreach($tmps as $k => $v){
// 		// 為了要符合前台版型的規範
// 		$tmps[$k]['url1'] = $tmps[$k]['url2'] = $this->data['router_method'].'.php?id='.$v['id'];
// 		$tmps[$k]['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$v['pic1'];
// 	}
// }
// $data[$ID.'_3'] = $tmps;

/*
 * 側邊選單展開 (如果有的話)
 */
$view_file = 'v3/breadcrumb';
$tmps = array();
if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	$tmps = $data[$layoutv3_struct_map_keyname[$view_file][0]];
}

// 因為主選單有可能會上提，造成key不一致，所以這裡先排序一下
sort($tmps);

// 刪掉尾巴
if(isset($tmps[count($tmps)-1])){
	unset($tmps[count($tmps)-1]);
}
// 刪掉頭
if(isset($tmps[0])){
	unset($tmps[0]);
}

// promenuX
// $actives = array();
// if($tmps and count($tmps) > 0){
// 	foreach($tmps as $k => $v){
// 		if(isset($v['id'])){
// 			$actives[] = $v['id'];
// 		}
// 	}
// }
// $view_file = 'default/active';
// $tmps = array();
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]] = $actives;
// }

// sidemenu 2018-01-22
if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		// do nothing
	}
	$view_file = 'default/sidemenu';
	$this->data['func_name_sub_id'] = 'navlight_'.$v['id'];
}
