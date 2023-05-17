<?php

//設定分頁基本參數 要記得在view那邊加入分頁的view
$pagew = 0;
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}
$limit_count = 12;//一頁顯示幾筆
$_GET['current_page'] = $pagew;
$DataList = array();
$pageRecordInfo = array();
$db = new Mysqleric(array('table'=>'html'));

//使用分頁列表，這個是使用偷懶的寫法，請看後台
$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$_GET['id'].'&page=';
$qryField = '*';
$qryWhere = ' WHERE type=\''.$this->data['router_method'].'tmp\' and class_id='.$_GET['id'].' order by id asc  ';//按照id排序列出 by lota	

//$qryWhere .=' order by start_date desc';

$db->getData($qryField, $qryWhere, (int)$limit_count);
if($db->total_row > 0) {
	$DataCount = $db->total_row;
	do{
		if($db->row['update_time'] == '0000-00-00 00:00:00'){
			$db->row['update_time'] = '';
		} else {
			$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
		}

		// url是大圖，pic是列表圖
		$db->row['pic'] = $db->row['url'] = '_i/'.$db->row['pic1'];

		// 大圖 如果需要原始圖顯示，就把下面這行註解 by lota
		$ggg = str_replace(
			'assets/members/'.str_replace('detail','',$this->data['router_method']).$db->row['class_id'].'/member/',
			// 抽換掉一層資料夾名稱，改成使用的尺寸別名
			'assets/members2/'.str_replace('detail','',$this->data['router_method']).$db->row['class_id'].'/big/',
			$db->row['pic1']
		);
		$ggg = '_i/'.$ggg;
		if(file_exists($ggg)){
			$db->row['url'] = $ggg;
		}

		// 列表圖(小圖)
		$ggg = str_replace(
			'assets/members/'.str_replace('detail','',$this->data['router_method']).$db->row['class_id'].'/member/',
			// 抽換掉一層資料夾名稱，改成使用的尺寸別名
			'assets/members2/'.str_replace('detail','',$this->data['router_method']).$db->row['class_id'].'/small/',
			$db->row['pic1']
		);
		$ggg = '_i/'.$ggg;
		if(file_exists($ggg)){
			$db->row['pic'] = $ggg;
		}

		// #21242 需要用就把它打開吧
		$tmp2 = explode('/', $db->row['pic1']);
		$tmp3 = $tmp2[count($tmp2)-1];
		$tmp4s = explode('.', $tmp3);
		$tmp5 = $tmp3; // 沒有副檔名，當做圖片名稱
		if($tmp4s and count($tmp4s) > 0){
			unset($tmp4s[count($tmp4s)-1]); // 只刪掉逗點最右邊，因為怕有1個以上的小數點
			$tmp5 = implode('.', $tmp4s);
		}
		$db->row['name'] = $tmp5;

		$DataList[] = $db->row;
	}while($db->row = $db->result->fetch_assoc());
	$pageRecordInfo = $db->get_page_bar($url);
	$pageBar = $db->record_info();
}
$data[$ID] = $DataList;

/*
 * 側邊選單展開 (如果有的話)
 */
$view_file = 'v3/breadcrumb';
$tmps = array();
if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	$tmps = $data[$layoutv3_struct_map_keyname[$view_file][0]];
}
// 刪掉尾巴
if(isset($tmps[count($tmps)-1])){
	unset($tmps[count($tmps)-1]);
}
// 刪掉頭
if(isset($tmps[0])){
	unset($tmps[0]);
}
$actives = array();
if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		if(isset($v['id'])){
			$actives[] = $v['id'];
		}
	}
}
$view_file = 'v3/default/active';
$tmps = array();
if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	$data[$layoutv3_struct_map_keyname[$view_file][0]] = $actives;
}

// 相簿名稱(上一層的名稱)
if(isset($layoutv3_struct_map_keyname['v3/category_title'][0])){
	$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>str_replace('detail','',$this->data['router_method']),':id'=>$_GET['id']))->queryRow();
	$ggg = array(
		'name' => $tmp['topic'],
		'sub_name' => $tmp['detail'],
		'year' => date('Y', strtotime($tmp['create_time'])),
		'month' => date('F', strtotime($tmp['create_time'])),
		'day' => date('d', strtotime($tmp['create_time'])),
	);

	$admin_field_router_class = str_replace('detail', '', $this->data['router_method']);
	$admin_field_section_id = 1;
	include _BASEPATH.'/../source/system/admin_field_get.php';

	if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
		if($admin_field['detail']['type'] == 'textarea'){
			$ggg['sub_name'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
		}
	}

	$aaa = array();
	$path = _BASEPATH.'/assets/members/'.str_replace('detail','',$this->data['router_method']).$_GET['id'].'/member';
	if(is_dir($path)){
		$aaa = $this->_getFiles($path);
	}
	$ggg['count'] = count($aaa);

	$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = $ggg;
}
