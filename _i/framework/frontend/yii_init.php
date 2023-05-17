<?php

// 告訴某些程式區段，現在跑的是前台跑是後台(例如G::t方法[多國語系]在使用的)
// 上面的app_name，不代表target_app_name就是一樣的
define('target_app_name', 'web');

// "或許" 之後用得到，先做起來
define('_BASEPATH', $base_path);
define('tmp_path', _BASEPATH.ds('/').'assets');

$domain_config = $base_path.'/config/domain.php';
require_once($domain_config);

$host = array();
foreach($hosts_app as $k => $v){
	if($_SERVER['SERVER_NAME'] == $v['name'] and $_SERVER['SERVER_PORT'] == $v['port']){
		$host = $v;
		break;
	}
}

// 等一下要做路徑的裁切，為了支援目錄的作法
$document_root = ds($_SERVER['DOCUMENT_ROOT']);

//    // 做一些小Hack
//    $tmp = explode('.', $_SERVER['HTTP_HOST']);
//    if($tmp[1] == 'web' and $tmp[2] == 'buyersline'){
//    	$document_root = ds('/home/gisanfu/hg');
//    }
//    
//    // 請注意，如果在httpd.conf裡面使用了VirtualDocumentRoot，那這裡會不一樣
//    if($tmp[1] == 'web' and $tmp[2] == 'buyersline'){
//    	$document_root .= '/'.$tmp[0];
//    	$_SERVER['DOCUMENT_ROOT'] = $document_root;
//    	define('virtualdocumentroot_fix', $tmp[0]);
//    } else {
//    	define('virtualdocumentroot_fix', '');
//    }

// 為了要支援動物園的自定document_root的關係
if(isset($host['document_root']) and $host['document_root'] != ''){
	$document_root = $host['document_root'];
}

// 動物園專用ServerZoo
//$document_root = '/home/match/public_html';

// 在動物園的主機，會有以下的狀況
// $document_root = '/home2/movecom/public_html';
// __DIR__ = '/home/movecom/public_html';

// 如果有內容，如像下面一樣，那就是網站是置於目錄裡面
//    /emtechnik_12Y0441/trunk
// 如果是空白，就代表網站放在根目錄裡面
$vir_path = str_replace($document_root, '', $DIR);

$test_phy_file = ds($_SERVER['REQUEST_URI']);
if($vir_path != ''){
	$test_phy_file = str_replace($vir_path, '', $test_phy_file);
}

// 標準化一下
$vir_path_a = '/';
$vir_path_b = '';
$vir_path_c = '/';
if($vir_path != ''){
	// 為了要砍掉第一個斜線
	$vir_path = substr($vir_path, 1);
	$vir_path_a = '/'.$vir_path;
	$vir_path_b = $vir_path.'/';
	$vir_path_c = '/'.$vir_path.'/';
}
define('vir_path', $vir_path);
define('vir_path_a', $vir_path_a);
define('vir_path_b', $vir_path_b);
define('vir_path_c', $vir_path_c);

/*
 * 依特個案
 */
// 交給有些特殊處理的地方
define('test_phy_file', $DIR.$test_phy_file);

// 首頁特別處理
if($test_phy_file == '/'){
}

// 重新合併回正確的檔案路徑
if($test_phy_file != ''){
	// /home/gisanfu/svn/emtechnik_12Y0441/trunk/en/fda.html 
	$test_phy_file = $DIR.$test_phy_file;
}
//echo $test_phy_file;

/*
 * 檢查檔案在實體檔案內存不存在
 */
$file_names = explode('.', $test_phy_file);
if(strlen($test_phy_file) > 1 and file_exists($test_phy_file) and count($file_names) > 1){
	$ext = strtolower($file_names[count($file_names) -1]);

	$is_match = 0;
	if(preg_match('/^(png|jpg|jpeg)$/i', $ext)){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-type: image/png');
		$is_match = 1;
	} elseif(preg_match('/^(gif|gifg)$/i', $ext)){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-type: image/gif');
		$is_match = 1;
	} elseif(preg_match('/^(txt|htm|html)$/i', $ext)){
		$is_match = 1;
	} elseif(preg_match('/^(xsl|xml)$/i', $ext)){
		header('Content-type: application/xml');
		$is_match = 1;
	} elseif(preg_match('/^(js|jsg)$/i', $ext)){
		header('Content-type: application/javascript');
		$is_match = 1;
	} elseif(preg_match('/^(swf|swfg)$/i', $ext)){
		header('Content-type: application/x-shockwave-flash');
		$is_match = 1;
	} elseif(preg_match('/^(css|cssg)$/i', $ext)){
		header('Content-type: text/css');
		$is_match = 1;
	} elseif(preg_match('/^(ico|icog)$/i', $ext)){
		header('Content-type: image/x-icon');
		$is_match = 1;
	} else {
		// 沒有match的話就乖乖跑CI流程了
	}

	if($is_match == 1){
		echo file_get_contents($test_phy_file);
		die;
	}
}

// 原本舊的
//$yii = $base_path.'/../framework/yii.php';

//$yii = $base_path.'/framework/yii.php';
//if(file_exists('/var/www/html/889/_i/framework/yii.php')){
//	$yii = '/var/www/html/889/_i/framework/yii.php';
//}
$config = $app_path.'/config/main.php';

// 為了zend mail
//$zend_dir =  str_replace('yii.php', 'vendors', $yii);
//ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$zend_dir);

// 自訂的共用資料庫設定檔
$db_config = $base_path.'/config/db.php';
$email_config = $base_path.'/config/email.php';
$environment_config = $base_path.'/config/environment.php';
//$domain_config = $base_path.'/config/domain.php';
//$general_config = $base_path.'/config/general.php';

if(!file_exists($app_path.'/runtime')){
	mkdir($app_path.'/runtime', 0777, true);
}

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// 針對這個架構，有不一樣的呈現方式
//define('customer_public_path', $yiipath_b.'assets/');

require_once($environment_config);
//require_once($domain_config);

//$host = array();
//foreach($hosts_app as $k => $v){
//	if($_SERVER['SERVER_NAME'] == $v['name'] and $_SERVER['SERVER_PORT'] == $v['port']){
//		$host = $v;
//		break;
//	}
//}
//var_dump($host);
if(count($host) <= 0){
	header('HTTP/1.0 404 Not Found');
	die;
}


// 設定資料庫，資料來源從domain的php檔案
foreach($host as $k => $v){
	if(preg_match('/^aaa_/', $k)){
		define($k, $v);
	} elseif($k == 'customer_public_path'){
		define($k, $yiipath_b.'assets/'.$v.'/');
	}
}

if(!defined('customer_public_path')) define('customer_public_path', $yiipath_b.'assets/');

require_once($db_config);
require_once($email_config);
require_once($yii);

//2016/6/19 如果GET有帶入lang參數，則直接改變語系 因有帶入GET , 所以移動到$yii底下
if(isset($_GET['lang']) && $_GET['lang']!='')
	define('domain_ml_key',$_GET['lang']);
else
	define('domain_ml_key', $host['ml_key']);//設定網站單一語系

// 讓google嵌入的翻譯自動選擇語系
//if($host['ml_key'] == 'cn'){
//	setcookie('googtrans', '/zh-CN/zh-CN', time()+3600);
//} elseif($host['ml_key'] == 'jp'){
//	setcookie('googtrans', '/ja/ja', time()+3600);
//}

define('aaa_url', $host['name']);

$app = Yii::createWebApplication($config);

/*
 * Zend init
 * 在createWebApp那行的中間，插入EZend這幾行進來，最後才執行run()
 * 最主要是使用ZendAcl的功能
 */

//EZendAutoloader::$prefixes = array('Zend', 'Custom');

// 現在變成CI的Loader了
EZendAutoloader::$prefixes = array();

//Yii::import("ext.yiiext.components.zendAutoloader.EZendAutoloader", true);
Yii::import("system.components.EZendAutoloader", true);
Yii::registerAutoloader(array("EZendAutoloader", "loadClass"), true);

/*
 * CI DB
 */

define('DB_DEBUG', false);
define('DB_LOAD_FORGE', true);

// This should be the base path to the database folder
if ( ! defined('BASEPATH')) {
	//define(BASEPATH, pathinfo(__FILE__, PATHINFO_DIRNAME).'/');
	//define('BASEPATH', _BASEPATH.'/ci/');
	define('BASEPATH', str_replace('yii.php', 'ci', $yii).'/'); // 因為想把ci的資料夾放進framework裡面
}

function get_instance() {
    global $db;
    if (isset($db)) {
		$item = new stdClass;
        $item->db = $db;
        return ($item);
    } else {
        return (null);
    }
}

function log_message($level = 'error', $message, $php_error = FALSE) {
    if (DB_DEBUG) echo $message . "\n";
}

function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered') {
    if (DB_DEBUG) echo $message . "\n";
}

require_once (BASEPATH . 'database/DB.php');

$dbc['default']['hostname'] = aaa_dbhost;
$dbc['default']['hostname'] = aaa_dbhost;
$dbc['default']['username'] = aaa_dbuser;
$dbc['default']['password'] = aaa_dbpass;
$dbc['default']['database'] = aaa_dbname;
$dbc['default']['db_debug'] = true; 
$dbc['default']['dbdriver'] = "mysqli";
$dbc['default']['dbprefix'] = '';
$dbc['default']['pconnect'] = FALSE;
$dbc['default']['cache_on'] = FALSE;
$dbc['default']['cachedir'] = "";
$dbc['default']['char_set'] = "utf8";
$dbc['default']['dbcollat'] = "utf8_general_ci";
$dbc['default']['swap_pre'] = '';
$dbc['default']['autoinit'] = TRUE;
$dbc['default']['stricton'] = FALSE;
$dbc['default']['save_queries'] = FALSE;

// Create The DB var
$db = DB($dbc['default']);

if (DB_LOAD_FORGE) {
    require_once (BASEPATH . 'database/DB_forge.php');
    require_once (BASEPATH . 'database/DB_utility.php');
    require_once (BASEPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_utility.php');
    require_once (BASEPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_forge.php');
    $class = 'CI_DB_' . $db->dbdriver . '_forge';
    $dbforge = new $class();
}

// 類似Zend的Registry
Yii::app()->params['cidb'] = $db;
/*
 */

// 2020-08-12 for Kevin
$pdo= new PDO('mysql:host='.aaa_dbhost.';dbname=' . aaa_dbname . ';charset=utf8', aaa_dbuser, aaa_dbpass);

Yii::app()->params['pdo'] = $pdo;


