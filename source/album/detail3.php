<?php

// https://redmine.buyersline.com.tw/issues/18231#note-44
if(!isset($_GET['id']) or $_GET['id'] == '' or $_GET['id'] <= 0){
	echo '404';
	header('HTTP/1.1 404 Not Found');
	die;
}

$router_method = str_replace('detail','',$this->data['router_method']);

// 2019-06-27
// https://redmine.buyersline.com.tw/issues/18231?issue_count=107&issue_position=106&next_issue_id=17463&prev_issue_id=18525#note-43
// 內頁資料不存在的時候，直接顯示空白404
$row = $this->cidb->where('is_enable',1)->where('type',$router_method)->where('id',$_GET['id'])->get('html')->row_array();
if($row and isset($row['id']) and $row['id'] > 0){
	// do nothing
} else {
	echo '404';
	header('HTTP/1.1 404 Not Found');
	die;
}

$pagew = 1; // Splitpage
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}
$limit_count = 12;//一頁顯示幾筆
$pageRecordInfo = array();

$where = array(
	'ml_key' => $this->data['ml_key'],
	'type' => $this->data['router_method'].'tmp1',
	'class_id' => $_GET['id'],
);
//$rows = $this->cidb->where($where)->order_by('sort_id','asc')->get('html')->result_array();
	//使用圖片名稱排序 by lota
$rows = $this->cidb->where($where)->order_by('pic1','asc')->get('html')->result_array();
$total_rows = count($rows);

// 2019-10-16 如果數量和實際不一樣，就洗掉資料表重寫
$path = _BASEPATH.'/assets/members/'.$router_method.'_1_'.$row['id'].'/member/';
$path2 = _BASEPATH.'/';
$tmp2 = array();//初始化
if(is_dir($path)){	
	$_tmp2 = glob($path.'*.*');
	if($_tmp2 and count($_tmp2) > 0){
		foreach ($_tmp2 as $k => $v) {
			$tmp2[$k] = str_replace($path2,'',$v);
		}
		sort($tmp2);//lota 加入排序
	}
}

$_count = count($tmp2);
if($total_rows != $_count){
	$this->cidb->where('type', $this->data['router_method'].'tmp1')->where('ml_key',$this->data['ml_key'])->where('class_id', $row['id'])->delete('html'); 
	if($_count > 0){
		foreach($tmp2 as $k => $v){
			$save = array(
				'ml_key' => $this->data['ml_key'],
				'type' => $this->data['router_method'].'tmp1',
				'class_id' => $row['id'],
				'pic1' => $v,
			);
			$this->cidb->insert('html', $save); 
		}
		$total_rows = $_count;
	}
}

$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$_GET['id'].'&page=';

include _BASEPATH.'/../source/core/pagination.php';

//$rows = $this->cidb->where($where)->order_by('sort_id','asc')->get('html', $limit_count, ($pagew-1) * $limit_count)->result_array();
//使用圖片名稱排序 by lota
$rows = $this->cidb->where($where)->order_by('pic1','asc')->get('html', $limit_count, ($pagew-1) * $limit_count)->result_array();

if($rows and count($rows) > 0){
	foreach($rows as $k => $v){
		if($v['update_time'] == '0000-00-00 00:00:00'){
			$v['update_time'] = '';
		} else {
			$v['update_time'] = date('Y/m/d', strtotime($v['update_time']));
		}

		// 列表圖
		$v['pic'] = cache3('_i/'.$v['pic1']);

		// 大圖
		$v['url'] = cache3('_i/'.$v['pic1']);

		// #21242 需要用就把它打開吧
		$tmp2 = explode('/', $v['pic1']);
		$tmp3 = $tmp2[count($tmp2)-1];
		$tmp4s = explode('.', $tmp3);
		$tmp5 = $tmp3; // 沒有副檔名，當做圖片名稱
		if($tmp4s and count($tmp4s) > 0){
			unset($tmp4s[count($tmp4s)-1]); // 只刪掉逗點最右邊，因為怕有1個以上的小數點
			$tmp5 = implode('.', $tmp4s);
		}
		$v['name'] = $tmp5;

		$rows[$k] = $v;
	}
}

$data[$ID] = $rows;

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
	$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>$router_method,':id'=>$_GET['id']))->queryRow();
	$ggg = array(
		'name' => $tmp['topic'],
		'sub_name' => $tmp['detail'],
		//'year' => date('Y', strtotime($tmp['create_time'])),
		//'month' => date('F', strtotime($tmp['create_time'])),
		//'day' => date('d', strtotime($tmp['create_time'])),

		//2019-10-3 改用 start_date by lota
		'year' => date('Y', strtotime($tmp['start_date'])),
		'month' => date('F', strtotime($tmp['start_date'])),
		'day' => date('d', strtotime($tmp['start_date'])),
	);

	$admin_field_router_class = $router_method;
	$admin_field_section_id = 1;
	include _BASEPATH.'/../source/system/admin_field_get.php';

	$ggg['sub_name'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
	if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
		if($admin_field['detail']['type'] == 'textarea'){
			$ggg['sub_name'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
		}
	}

	$aaa = array();
	$path = _BASEPATH.'/assets/members/'.$router_method.'_1_'.$_GET['id'].'/member';
	if(is_dir($path)){
		$aaa = $this->_getFiles($path);
	}
	$ggg['count'] = count($aaa);

	$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = $ggg;
}
