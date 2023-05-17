<?php

if(!isset($this->data['admin_id']) or $this->data['admin_id'] <= 0){
	$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('請先登入！'), $redirect_url, $this->data);
	die;
}

// $row = $this->db->createCommand()->select('name,login_account,gender,need_dm,phone,birthday')->from('customer')
// ->where('is_enable=1 and id=:id', array(':id' => $this->data['admin_id']))
// ->queryRow();
// 
// $data[$ID] = $row;

//if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
//	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = array(
//		'name' => '會員中心',
//		'sub_name' => 'member center',
//	);
//}
//
//if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
//	$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = array(
//		array('name' => 'HOME', 'url' => '/'),
//		array('name' => '會員中心', 'url' => 'membercenter.php')
//	);
//}
