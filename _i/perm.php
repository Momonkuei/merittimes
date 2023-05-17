<?php

/*
 * 檔案下載的連結，經由會員機制的帳密驗證 2017-06-27
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);

$path1 = $_GET['path1'];
$path2 = $_GET['path2'];
$src = $_GET['src'];

if($path1 == '' or $path2 == '' or $src == ''){
	header("HTTP/1.0 404 Not Found");
	die;
}

include '../include/ci.php';

include GGG_BASEPATH.'../_i/config/db.php';

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

// $db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
$db = ggg_load_database($tmps, true);

session_start();

if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] > 0){
	$file = 'assets/'.$path1.'/'.$path2.'/'.$src;
} else {
	header('Location: /guestlogin.php?next=_i/assets/'.$path1.'/'.$path2.'/'.$src);
	die;
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');

if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){ // http://www.davidpai.tw/php/2012/codeigniter-ci-force-download-ie-chinese-file-name/
	header('Content-Disposition: attachment; filename='.iconv('utf-8', 'big5', basename($file)));
} else {
	header('Content-Disposition: attachment; filename='.basename($file));
}

header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);
die;
