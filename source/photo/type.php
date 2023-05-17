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
$db = new Mysqleric(array('table'=>$this->data['router_method'].'type'));

// ■  密碼鎖：可針對個別相簿執行密碼上鎖
// 預設這個功能是關閉的，這是加價購的功能
if(0){
	$media_password = '';
	if(isset($_SESSION['media_password']) and $_SESSION['media_password'] != ''){
		$media_password = $_SESSION['media_password'];
	}
	// 在啟用這個功能的時候，在還沒有登入前，預設會搜尋亂數密碼，也就是永遠都搜尋不到
	if($media_password == ''){
		$media_password = G::GeraHash(10);
	}
}

unset($_constant);
eval('$_constant = '.strtoupper($this->data['router_method'].'_type_later').';');
if($_constant == 1){ // 有分類

	// 如果是分類，但沒有帶分類編號，那自動會轉去第一個
	if(!isset($_GET['id'])){
		$tmp = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
		header('Location: '.$this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$tmp['id']);
	}

	if(isset($_GET['id'])){

		$class_id = intval($_GET['id']);
		//使用分頁列表
		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$class_id.'&page=';
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and ml_key=\''.$this->data['ml_key'].'\' ';

		// 這裡還沒有跟進哦
		if(isset($media_password)){
			// 用多個密碼欄位的方式撰寫，但實際只有一個
			$qryWhere .= ' and ( other2="'.$media_password.'" or other2="'.$media_password.'" ) ';
		}

		//搜尋哪個分類
		$qryWhere .=' and pid='.$class_id;

		$qryWhere .=' order by sort_id';

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				if($db->row['update_time'] == '0000-00-00 00:00:00'){
					$db->row['update_time'] = '';
				} else {
					$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
				}
				$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
				$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$db->row['pic1'];

				$db->row['year'] = date('Y', strtotime($db->row['create_time']));
				$db->row['month'] = date('F', strtotime($db->row['create_time']));
				$db->row['day'] = date('d', strtotime($db->row['create_time']));

				$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and class_id='.$db->row['id'].' and ml_key=:ml_key',array(':type'=>'photo',':ml_key'=>$this->data['ml_key']))->queryAll();
				$db->row['count'] = count($tmps);

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}
		$data[$ID] = $DataList;

		// 分類名稱
		if(isset($layoutv3_struct_map_keyname['v3/category_title'][0])){
			$tmp = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and id=:id',array(':id'=>$class_id))->queryRow();
			$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = array(
				'name' => $tmp['name'],
				'sub_name' => $tmp['detail'],
			);

			$admin_field_router_class = $this->data['router_method'].'type';
			$admin_field_section_id = 1;
			include _BASEPATH.'/../source/system/admin_field_get.php';

			if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
				if($admin_field['detail']['type'] == 'textarea'){
					$data[$layoutv3_struct_map_keyname['v3/category_title'][0]]['sub_name'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
				}
			}
		}
	}
} elseif($_constant == 0){ // 無分類，但是有相簿 (相簿分項)

	//使用分頁列表
	$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	$qryField = '*';
	$qryWhere = ' WHERE is_enable=1 and ml_key=\''.$this->data['ml_key'].'\' and pid=0 ';	

	if(isset($media_password)){
		// 用多個密碼欄位的方式撰寫，但實際只有一個
		$qryWhere .= ' and ( other2="'.$media_password.'" or other2="'.$media_password.'" ) ';
	}

	$qryWhere .=' order by sort_id';

	$db->getData($qryField, $qryWhere, (int)$limit_count);
	if($db->total_row > 0) {
		$DataCount = $db->total_row;
		do{
			if($db->row['update_time'] == '0000-00-00 00:00:00'){
				$db->row['update_time'] = '';
			} else {
				$db->row['update_time'] = date('Y/m/d', strtotime($db->row['update_time']));
			}
			$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
			$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$db->row['pic1'];

			//$db->row['content'] = $db->row['detail'];
			$db->row['year'] = date('Y', strtotime($db->row['create_time']));
			$db->row['month'] = date('F', strtotime($db->row['create_time']));
			$db->row['day'] = date('d', strtotime($db->row['create_time']));
			
			$tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and class_id='.$db->row['id'].' and ml_key=:ml_key',array(':type'=>'photo',':ml_key'=>$this->data['ml_key']))->queryAll();
			$db->row['count'] = count($tmps);

			$DataList[] = $db->row;
		}while($db->row = $db->result->fetch_assoc());
		$pageRecordInfo = $db->get_page_bar($url);
		$pageBar = $db->record_info();
	}
	$data[$ID] = $DataList;

} elseif($_constant == 2){ // 只有相片，但是程式不會經過這裡，所以也不用寫
	// 不會經過這裡
}
