<?php

// 這幾行是原本的
// change the following paths if necessary
//$yiic=dirname(__FILE__).'/../../framework/yiic.php';
//$config=dirname(__FILE__).'/config/console.php';
//
//require_once($yiic);

date_default_timezone_set("Asia/Taipei");

// debug
//ini_set('memory_limit', '512M');

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

// 做不同環境的切換
$yiipath = '';
$yiipath_a = '';
$yiipath_b = '';
$yiipath_c = '';

if($yiipath != ''){
	$yiipath_a = '/'.$yiipath;
	$yiipath_b = $yiipath.'/';
	$yiipath_c = '/'.$yiipath.'/';
}

$base_path = __DIR__.$yiipath_a.'/..';
$app_name = 'backend';
$app_path = $base_path.ds('/').$app_name;

// 告訴某些程式區段，現在跑的是前台跑是後台(例如G::t方法[多國語系]在使用的)
// 上面的app_name，不代表target_app_name就是一樣的
define('target_app_name', 'backend');

// "或許" 之後用得到，先做起來
// BASEPATH加底線，為了不要跟CI沖到
define('_BASEPATH', $base_path);
define('tmp_path', _BASEPATH.ds('/').$yiipath_b.'assets');

// 等一下要做路徑的裁切，為了支援目錄的作法
// windows: C:\wamp\www\
// linux: /home/gisanfu/svn
$document_root = ds($_SERVER['DOCUMENT_ROOT']);

// 如果有內容，如像下面一樣，那就是網站是置於目錄裡面
//    /emtechnik_12Y0441/trunk
// 如果是空白，就代表網站放在根目錄裡面
$vir_path = str_replace(DIRECTORY_SEPARATOR, '/', str_replace($document_root, '', __DIR__));

$test_phy_file = '';
// 有修改的部份，針對command
//$test_phy_file = ds($_SERVER['REQUEST_URI']);
if($vir_path != ''){
	$test_phy_file = str_replace($vir_path, '', $test_phy_file);
}

// 標準化一下
$vir_path_a = '/';
$vir_path_b = '';
$vir_path_c = '/';
if($vir_path != ''){
	// 為了要砍掉第一個斜線(Linux)
	if(substr($vir_path,0, 1) == '/'){
		$vir_path = substr($vir_path, 1);
	}
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
define('test_phy_file', __DIR__.$test_phy_file);

// 如果遇到assets的東西，就拿來檢查一下，看是否是要取前台的東西
if(preg_match('/^\/images\//', $test_phy_file, $matches)){
	//$frontend_images_dir = array('category-images', 'i', 'page-image', 'page-image2', 'pdf', 'product-images', 'series-images', 'thumbXX', 'video', 'web-images');
	//$tmp = explode('/', $test_phy_file);
	//if(in_array($tmp[2], $frontend_images_dir)){
		if(file_exists('..'.$test_phy_file)){
			$test_phy_file = '..'.$test_phy_file;
		}
	//}
}


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

//$yii = $base_path.'/../framework/yii.php';
$yii = $base_path.'/framework/yii.php';
$config = $app_path.'/config/main.php';

// 自訂的共用資料庫設定檔
// 有修改的部份，針對command
$db_config = $base_path.'/config/db.php';
$environment_config = $base_path.'/config/environment.php';

if(!file_exists($app_path.'/runtime')){
	mkdir($app_path.'/runtime', 0777, true);
}

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
define('customer_public_path', 'assets/');

require_once($environment_config);
require_once($db_config);
require_once($yii);
//$app = Yii::createWebApplication($config);

/*
 * Zend init
 * 在createWebApp那行的中間，插入EZend這幾行進來，最後才執行run()
 * 最主要是使用ZendAcl的功能
 * http://www.yiiframework.com/extension/zendautoloader/
 */

//EZendAutoloader::$prefixes = array('Zend', 'Custom');

// 現在變成CI的Loader了
require_once '/home/gisanfu/hg/eob/_butterfly/framework/components/EZendAutoloader.php';
EZendAutoloader::$prefixes = array();

 // XXX Yii::import("ext.yiiext.components.zendAutoloader.EZendAutoloader", true);
Yii::import("system.components.EZendAutoloader", true);
Yii::registerAutoloader(array("EZendAutoloader", "loadClass"), true); 

/*
 * Zend autoloader version2 (失敗)
 * http://www.yiiframework.com/wiki/37/integrating-with-other-frameworks/
 */

//require_once Yii::getPathOfAlias("system.vendors").'/Zend/Loader/Autoloader.php';
//spl_autoload_unregister(array('YiiBase','autoload'));
//spl_autoload_register(array('Zend_Loader_Autoloader','autoload'));
//spl_autoload_register(array('YiiBase','autoload'));

/*
 * CI DB
 */

//   define('DB_DEBUG', false);
//   define('DB_LOAD_FORGE', true);
//   
//   // This should be the base path to the database folder
//   if ( ! defined('BASEPATH')) {
//   	//define(BASEPATH, pathinfo(__FILE__, PATHINFO_DIRNAME).'/');
//   	define('BASEPATH', _BASEPATH.'/ci/');
//   }
//   
//   function get_instance() {
//       global $db;
//       if (isset($db)) {
//           $item->db = $db;
//           return ($item);
//       } else {
//           return (null);
//       }
//   }
//   
//   function log_message($level = 'error', $message, $php_error = FALSE) {
//       if (DB_DEBUG) echo $message . "\n";
//   }
//   
//   function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered') {
//       if (DB_DEBUG) echo $message . "\n";
//   }
//   
//   require_once (BASEPATH . 'database/DB.php');
//   
//   $dbc['default']['hostname'] = aaa_dbhost;
//   $dbc['default']['username'] = aaa_dbuser;
//   $dbc['default']['password'] = aaa_dbpass;
//   $dbc['default']['database'] = aaa_dbname;
//   $dbc['default']['db_debug'] = true; 
//   $dbc['default']['dbdriver'] = "mysqli";
//   $dbc['default']['dbprefix'] = '';
//   $dbc['default']['pconnect'] = FALSE;
//   $dbc['default']['cache_on'] = FALSE;
//   $dbc['default']['cachedir'] = "";
//   $dbc['default']['char_set'] = "utf8";
//   $dbc['default']['dbcollat'] = "utf8_general_ci";
//   $dbc['default']['swap_pre'] = '';
//   $dbc['default']['autoinit'] = TRUE;
//   $dbc['default']['stricton'] = FALSE;
//   $dbc['default']['save_queries'] = FALSE;
//   
//   // Create The DB var
//   $db = DB($dbc['default']);
//   
//   if (DB_LOAD_FORGE) {
//       require_once (BASEPATH . 'database/DB_forge.php');
//       require_once (BASEPATH . 'database/DB_utility.php');
//       require_once (BASEPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_utility.php');
//       require_once (BASEPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_forge.php');
//       $class = 'CI_DB_' . $db->dbdriver . '_forge';
//       $dbforge = new $class();
//   }
//   
//   // 類似Zend的Registry
//   Yii::app()->params['cidb'] = $db;
/*
 */

//$app->run();
