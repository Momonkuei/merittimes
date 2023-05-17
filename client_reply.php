<?php

use nguyenanhung\CodeIgniterDB as CI;

/*
 * Client Reply
 *
 * 後台的"物流訂單傳至綠界"按鈕，按下去以後，會告訴綠界幕前回傳的網址
 * 回傳後，會依據條件，連回原本的後台該訂單的網址
 * 等到客人取貨以後，綠界會用幕後的方式reply.php(xxx_no_payment_for_pickup_server_reply)傳回來
 */

if(isset($_POST) and !empty($_POST) and isset($_GET) and !empty($_GET)){

	$post = $_POST;
	$get = $_GET;

	// $get = array();
	//foreach($post as $k => $v){
	//	if(preg_match('/^_get_(.*)$/', $k, $matches)){
	//		unset($post[$k]);
	//		$get[$matches[1]] = $v;
	//	}
	//}

	// var_dump($get);
	// var_dump($post);die;

	$status = false;

	//$vendors_dir = _BASEPATH.'/vendors';
	$vendors_dir = 'layoutv3/vendors';
	ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

	// composer autoload 2018-12-18
	//include_once GGG_BASEPATH.'../vendor/autoload.php';
	include_once 'layoutv3/vendor/autoload.php';

	include '_i/config/db.php';

	$Db_Server = aaa_dbhost;
	$Db_User = aaa_dbuser;
	$Db_Pwd = aaa_dbpass;
	$Db_Name = aaa_dbname; 

	// CI2
	// $tmps = array(
	// 	'dbdriver' => 'mysql',
	// 	'username' => $Db_User,
	// 	'password' => $Db_Pwd,
	// 	'hostname' => $Db_Server,
	// 	'port' => 3306,
	// 	'database' => $Db_Name,
	// 	// 'db_debug' => true
	// );

	$tmps = array(
		'dsn'	=> '',
		'hostname' => $Db_Server,
		'username' => $Db_User,
		'password' => $Db_Pwd,
		'database' => $Db_Name,
		'dbdriver' => 'mysqli',
		'dbprefix' => '',
		'pconnect' => false,
		// 'db_debug' => true,
		'cache_on' => false,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => false,
		'compress' => false,
		'stricton' => false,
		'failover' => array(),
		'save_queries' => true
	);
	$rDb = mysqli_connect($tmps['hostname'], $tmps['username'], $tmps['password']);
	$db =& CI\DB($tmps, null, $rDb);

	// debug
	// $rows = $db->get('product')->result_array();
	//file_put_contents('123.txt',var_export($rows,true),FILE_APPEND);

	if(preg_match('/^ecpay_(711|fami)_no_payment_for_pickup$/', $get['_func'])){
		if(
			isset($post['AllPayLogisticsID']) and $post['AllPayLogisticsID'] != ''
			and isset($post['ReceiverPhone']) and $post['ReceiverPhone'] != ''
		){
			$row = $db->like('log2_1',$post['AllPayLogisticsID'])->where('recipient_phone',$post['ReceiverPhone'])->get('shoporderform')->row_array();
			if($row and isset($row['id']) and $row['id'] > 0){
				header('Location: /_i/backend.php?r=shoporderform/update&param='.$row['id']);
			}
		}
	}

	die;
}
