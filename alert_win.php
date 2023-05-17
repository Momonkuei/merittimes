<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*
* 檢測連結是否是SSL連線
* @return bool
*/
session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
if(!function_exists('is_SSL')){
	function is_SSL(){
		if(!isset($_SERVER['HTTPS']))
			return FALSE;
		if($_SERVER['HTTPS'] === 1){  //Apache
			return TRUE;
		}elseif($_SERVER['HTTPS'] === 'on'){ //IIS
			return TRUE;
		}elseif($_SERVER['SERVER_PORT'] == 443){ //其他
			return TRUE;
		}
			return FALSE;
	}
}

if(is_SSL()){

	//設定cookie傳輸模式 by lota
	// $maxlifetime = ini_get('session.gc_maxlifetime');
	$secure = true; // if you only want to receive the cookie over HTTPS
	$httponly = true; // prevent JavaScript access to session cookie
	$samesite = 'None';

    if(PHP_VERSION_ID < 70300) {
        session_set_cookie_params(0, '/; samesite='.$samesite, str_replace('www','',$_SERVER['HTTP_HOST']), $secure, $httponly);
    } else {
        session_set_cookie_params([
            // 'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => str_replace('www','',$_SERVER['HTTP_HOST']),
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }
}


//ini_set("display_errors", "On");
session_start();

// define('BASEPATH', realpath(dirname(__FILE__)).'/include/');
// define('APPPATH', realpath(dirname(__FILE__)).'');
// include_once('include/core/Common.php');
// include_once('include/database/DB.php');
// function get_config(){}
// 
// include '_i/config/db.php';

include 'include/ci.php';
include GGG_BASEPATH.'../_i/config/db.php';

// my
$Db_Server = aaa_dbhost;
$Db_User = aaa_dbuser;
$Db_Pwd = aaa_dbpass;
$Db_Name = aaa_dbname;

$tmps = array(
	'dbdriver' => 'mysql',
	'username' => $Db_User,
	'password' => $Db_Pwd,
	'hostname' => $Db_Server,
	'port' => 3306,
	'database' => $Db_Name,
);

/* Load database via Database source name, eg. "mysql://root:password@localhost/mydatabase" */
$db = ggg_load_database('mysql://'.$Db_User.':'.$Db_Pwd.'@'.$Db_Server.'/'.$Db_Name, true);
$db = ggg_load_database($tmps, true);


//---
include '_i/web/config/main.php';

$lang = (isset($_SESSION['web_ml_key']))?$_SESSION['web_ml_key']:$returnx['language'];

$query = $db->get('sys_config');

foreach($query->result_array() as $k => $v)
	$row[$v['keyname']] = $v['keyval'];

if(isset($row['pic2_'.$lang]))
	$pic = (is_file('_i/assets/upload/indexad/'.$row['pic2_'.$lang]))?'_i/assets/upload/indexad/'.$row['pic2_'.$lang]:'';
else 
	$pic = '';

if(isset($row['indexad_text_'.$lang]))
	$href = $row['indexad_text_'.$lang];
else
	$href='javascript:void(0)';

if(isset($row['indexad_title_'.$lang]))
	$title = $row['indexad_title_'.$lang];
else
	$title = $row['admin_title'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<!--TW - Meta Data-->
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body>
<div id="bg_main">
	<div class="main clearfix">
		<a href="<?php echo $href?>" target="_parent"><img src="<?php echo $pic?>" style="max-width: 100%;" /></a>
	</div>
</div>
</body>
</html>
