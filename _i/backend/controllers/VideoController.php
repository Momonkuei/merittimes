<?php

use nguyenanhung\CodeIgniterDB as CI;
// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

// 前台主選單的資料表功能

/*
 * CI-DB-2
 */
// include _BASEPATH.'/ci/ci.php';
// $tmps = array(
// 	'dbdriver' => 'mysql',
// 	'username' => aaa_dbuser,
// 	'password' => aaa_dbpass,
// 	'hostname' => aaa_dbhost,
// 	'port' => 3306,
// 	'database' => aaa_dbname,
// 	//'db_debug' => true,
// );
// $cidb = ggg_load_database($tmps, true);

/*
 * CI-DB-3
 */
include_once _BASEPATH.'/../layoutv3/vendor/autoload.php';
$tmps = array(
	'dsn'	=> '',
	'hostname' => aaa_dbhost,
	'username' => aaa_dbuser,
	'password' => aaa_dbpass,
	'database' => aaa_dbname,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => false,
	//'db_debug' => true,
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
$cidb =& CI\DB($tmps, null, $rDb);

if(!isset($_SESSION)){
	session_start();
}

if(!isset($_SESSION['auth_admin_id']) or !isset($_SESSION['auth_admin_data_ml_key'])){
	header('Location: /_i/');
	die;
}

// 讓index以外的method，也能正常運作
$get_r_tmp = $_GET['r'];
$get_r_tmps = explode('/', $get_r_tmp);
$get_r = $get_r_tmps[0];

$contentx = '';

$condition = array(
	'is_home' => 1,
	'type' => 'webmenu',
	'ml_key' => $_SESSION['auth_admin_data_ml_key'],

	// 'url1' => str_replace('type','',$get_r).'_'.$_SESSION['auth_admin_data_ml_key'].'.php', // 這個是分類在用的
	// 'url1' => $get_r.'_'.$_SESSION['auth_admin_data_ml_key'].'.php', // 這個是分類以外在用的
);

if(preg_match('/type$/', $get_r)){
	$condition['url1'] = str_replace('type','',$get_r).'_'.$_SESSION['auth_admin_data_ml_key'].'.php'; // 這個是分類在用的
} else {
	$condition['url1'] = $get_r.'_'.$_SESSION['auth_admin_data_ml_key'].'.php'; // 這個是分類以外在使用的
}

$row = $cidb->where($condition)->get('html')->row_array();

// 前一個版本
// if($row and isset($row['id']) and $row['id'] > 0){
// 	if(isset($row['pic2']) and $row['pic2'] == 0 and isset($row['is_top']) and $row['is_top'] == 1){ // 沒有分類，而且有勾選單頁的情況
// 		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_single.php');
// 	} else {
// 		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_rows.php');
// 	}
// }

if($row and isset($row['pic2'])){
	if(preg_match('/type$/', $get_r)){
		if($row['pic2'] == 1){ // 有分類
			if(isset($row['is_news']) and $row['is_news'] == 1){ // 是通用分類
				$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_single_type.php');
			} else {
				$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_multi_type.php');
			}
		} else {
			$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_single_type.php');
		}
	} else {
		if(isset($row['is_top']) and $row['is_top'] == 1){ // 沒有分類，而且有勾選單頁的情況
			$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_single2.php');
		} else {
			$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_rows.php');
		}
	}

} else { // 後台的前台主選單，如果沒有能夠參考它的結構，那就試著從 是否有type的這件事來檢查看看
	if(preg_match('/type$/', $get_r)){
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_single_type.php');
	} else {
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_rows.php');
	}

}

// 預設
if($contentx == ''){
	/*
	 * 三選一
	 */
	$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_rows.php');
	// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_multi_type.php');
	// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_single2.php');
}

$contentx = str_replace('<'.'?'.'php', '', $contentx);
eval($contentx);

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
