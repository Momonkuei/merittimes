<?php

//設定分頁基本參數 要記得在view那邊加入分頁的view
$page = 0;
if(isset($_GET['page']) and $_GET['page'] > 0){
	$page = $_GET['page'];
}
$limit_count = 12;//一頁顯示幾筆
$_GET['current_page'] = $page;
$DataList = array();
$pageRecordInfo = array();
$db = new Mysqleric(array('table'=>'html'));

unset($_constant);
eval('$_constant = '.strtoupper(str_replace('detail','',$this->data['router_method']).'_type_later').';');
if(!isset($GET['id']) and $_constant == 2){ // 只有相片

	$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	$qryField = '*';
	$qryWhere = ' WHERE type=\''.str_replace('detail','',$this->data['router_method']).'\' and ml_key=\''.$this->data['ml_key'].'\' ';	
	$qryWhere .=' order by sort_id';
} else {

	//使用分頁列表，這個是使用偷懶的寫法，請看後台
	$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$_GET['id'].'&page=';
	$qryField = '*';
	$qryWhere = ' WHERE type=\''.str_replace('detail','',$this->data['router_method']).'\' and class_id='.$_GET['id'].' ';	

	//$qryWhere .=' order by start_date desc';
}

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
		$db->row['pic'] = $db->row['url'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$db->row['pic1'];

		$db->row['name'] = $db->row['topic'];

		$DataList[] = $db->row;
	}while($db->row = $db->result->fetch_assoc());
	$pageRecordInfo = $db->get_page_bar($url);
	$pageBar = $db->record_info();
}
$data[$ID] = $DataList;

// 相簿名稱(上一層的名稱)
if(isset($layoutv3_struct_map_keyname['v3/category_title'][0])){

	unset($_constant);
	eval('$_constant = '.strtoupper(str_replace('detail','',$this->data['router_method']).'_type_later').';');
	if($_constant == 1 or $_constant == 0){
		$tmp = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'type')->where('is_enable=1 and id=:id',array(':id'=>$_GET['id']))->queryRow();
		$ggg = array(
			'name' => $tmp['name'],
			'sub_name' => $tmp['detail'],
			'year' => date('Y', strtotime($tmp['create_time'])),
			'month' => date('F', strtotime($tmp['create_time'])),
			'day' => date('d', strtotime($tmp['create_time'])), //如果不想要顯示時間，註解這行 by lota
		);

		$admin_field_router_class = str_replace('detail', '', $this->data['router_method']).'type';
		$admin_field_section_id = 1;
		include _BASEPATH.'/../source/system/admin_field_get.php';

		if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
			if($admin_field['detail']['type'] == 'textarea'){
				$ggg['sub_name'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
			}
		}

		$aaa = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and class_id='.$_GET['id'].' and ml_key=:ml_key',array(':type'=>'photo',':ml_key'=>$this->data['ml_key']))->queryAll();
		$ggg['count'] = count($aaa);

		$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = $ggg;
	} else {
		// 多層的暫時不寫
	}
}
