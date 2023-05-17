<?php

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

if(!empty($_POST)){
	$post = $_POST;

	header('Content-Type: application/json');
	$result = false;
	$row = $this->db->createCommand()->select('id')->from('customer')->where('is_enable=1 and login_account=:account',array(':account'=>trim($post['login_account'])))->queryRow();
	if(isset($row) and isset($row['id'])){
		$result = false;
	} else {
		$result = true;
	}
	
	echo json_encode($result);
	die;
}
