<?php

/*
 * 這個是Yii架構在使用的
 */

// error_reporting(E_ALL);
// ini_set("display_errors", 0);

$yiipath = '_i'; // 移到最上面

include_once($yiipath.'/attack/spam.php');

header('Content-Type: text/html; charset=UTF-8');

// 用jphpmailer寄信時會報錯
date_default_timezone_set("Asia/Taipei");

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

function ds($path)
{
	if(DIRECTORY_SEPARATOR == '/') return $path;
	return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

if (!defined('__DIR__')) {
	define('__DIR__', ds(dirname(__FILE__)));
}

// 因為不同資料夾的__DIR__是不一樣的，如果要做共用，要先做好這個變數
$DIR = __DIR__;

// 做不同環境的切換
//$yiipath = '_i'; // 移到最上面
$yiipath_a = '';
$yiipath_b = '';
$yiipath_c = '';

if($yiipath != ''){
	$yiipath_a = '/'.$yiipath;
	$yiipath_b = $yiipath.'/';
	$yiipath_c = '/'.$yiipath.'/';
}

// 目前是前台要轉到後台的時候，會用到的prefix
define('yiipath', $yiipath);

include_once($yiipath.'/config/basic_yii_path.php'); //2016/6/19 改統一引入yii路徑

$app_name = 'web';
$app_path = $base_path.ds('/').$app_name;

//require_once(str_replace('yii.php', '', $yii).$app_name.ds('/yii_init.php'));
require_once(str_replace('yii.php', '', $yii).'frontend'.ds('/yii_init.php'));

$app->run();
