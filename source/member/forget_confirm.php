<?php

$e = $_GET['e'];

// 先檢查驗證碼
$row = $this->db->createCommand()->from('customer')
->where('passforgetcheck =:code', array(':code' => $e))
->queryRow();

if($row and isset($row['id'])){
} else {
	$redirect_url = 'index_'.$this->data['ml_key'].'.php';
	G::alert_and_redirect(t('忘記密碼驗證碼錯誤','tw'), $redirect_url, $this->data);
	die;
}

$this->data['passforgetcheck'] = $e;

if(!empty($_POST)){
	if(!isset($_POST['login_password']) or $_POST['login_password'] == ''
		or !isset($_POST['login_password_confirm']) or $_POST['login_password_confirm'] == ''
		or $_POST['login_password'] != $_POST['login_password_confirm']){
		$redirect_url = 'memberforgetconfirm_'.$this->data['ml_key'].'.php?e='.$e;
		G::alert_and_redirect(t('請重新輸入您的密碼'), $redirect_url, $this->data);
		die;
	}

	$update = array();
	$update = array(
		'passforgetcheck' => '',
		'login_password' => $_POST['login_password'],
	);

	unset($_constant);
	eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
	if($_constant == '0'){
		$update['salt'] = '';
	} elseif($_constant == '1'){
		$update['salt'] = '';
		$update['login_password'] = sha1($update['login_password']);
	} elseif($_constant == '2'){
		$update['salt'] = G::GeraHash(10);
		$update['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($update['login_password'].$update['salt'])));
	}

	$empty_orm_data = array(
		'table' => 'customer',
		//'created_field' => 'create_time', 
		'updated_field' => 'update_time',
		'primary' => 'id',
		'rules' => array(
			array('email', 'required'),
		),
	);

	$orm = new gorm($this->cidb, $empty_orm_data);
	$orm->data($update);
	$orm->find_by_id($row['id']);
	$status = $orm->validate(); // 回傳true或false
	$logs = $orm->message();
	$status = $orm->update(); // 回傳更新狀態
	$count = $db->affected_rows();

	$end_string = '';
	$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	$end_string .= '<script type="text/javascript">';
	$end_string .= 'alert("'.t('修改密碼成功，請重新登入您的帳號密碼','tw').'");';
	$end_string .= 'window.location.href="guestlogin_'.$this->data['ml_key'].'.php";';
	$end_string .= '</script>';
	echo $end_string;
	die;
}

// if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
// 	$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = array(
// 		'name' => '重設密碼',
// 		'sub_name' => 'password change',
// 	);
// }
// 
// if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
// 	$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = array(
// 		array('name' => 'HOME', 'url' => '/'),
// 		array('name' => '重設密碼', 'url' => 'javascript:;')
// 	);
// }
