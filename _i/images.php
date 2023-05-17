<?php

use nguyenanhung\CodeIgniterDB as CI;

if(1){
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
}

/*
 * 2020-09-29
 * 李哥說經理說，要弄一個可以讀原始圖片名稱的路徑
 * 是要給有簽SEO的客戶使用的
 */

if(isset($_GET['router_method']) and $_GET['router_method'] != '' and isset($_GET['file']) and $_GET['file'] != ''){
	$router_method = $_GET['router_method'];
	$file = $_GET['file'];

	// CI3
	// 2018-12-18 從ci.php裡面移出來的
	if(!defined('GGG_BASEPATH')){
		define('GGG_BASEPATH', realpath(dirname(__FILE__)).'/');
	}
	if(!defined('GGG_APPPATH')){
		define('GGG_APPPATH', realpath(dirname(__FILE__)).'');
	}

	// composer autoload 2018-12-18
	include_once GGG_BASEPATH.'../layoutv3/vendor/autoload.php';

	include GGG_BASEPATH.'../_i/config/db.php';

	$Db_Server = aaa_dbhost;
	$Db_User = aaa_dbuser;
	$Db_Pwd = aaa_dbpass;
	$Db_Name = aaa_dbname; 

	/*
	 * CI-DB-3
	 */
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

	// 2020-01-14
	if(defined('YII_DEBUG') and YII_DEBUG === true){
		$tmps['db_debug'] = true;
	}

	$rDb = mysqli_connect($tmps['hostname'], $tmps['username'], $tmps['password']);
	$db =& CI\DB($tmps, null, $rDb);

	// 最後的結果，就是要讓這個變數不為空
	$success = '';

	/*
	 * 先從獨立資料表找起
	 */
	if($success == '' and $db->table_exists($router_method)){
		$row = $db->get($router_method)->row_array();
		$count = 0;
		if($row and isset($row['id'])){
			foreach($row as $k => $v){
				if(preg_match('/^pic(\d+)___origin$/', $k)){
					$count += 1;
				}
			}
		}
		if($count > 0){
			$sql = 'select * from '.$router_method.' where 1 and (0 ';
			for($x=1;$x<=$count;$x++){
				$sql .= ' or pic'.$x.'___origin="'.$file.'" ';
			}
			$sql .= ')';
			$rows = $db->query($sql)->result_array();

			if($rows and !empty($rows)){
				foreach($rows as $k => $v){
					for($x=1;$x<=$count;$x++){
						if(isset($v['pic'.$x.'___origin']) and $v['pic'.$x.'___origin'] == $file){
							$success = $v['pic'.$x];
							break;
						}
					}
					if($success != ''){
						break;
					}
				}
			}
		}
	}

	/*
	 * 通用資料表
	 */
	if($success == '' and $db->table_exists('html')){
		$row = $db->get('html')->row_array();
		$count = 0;
		if($row and isset($row['id'])){
			foreach($row as $k => $v){
				if(preg_match('/^pic(\d+)___origin$/', $k)){
					$count += 1;
				}
			}
		}
		if($count > 0){
			$sql = 'select * from html where type="'.$router_method.'" and (0 ';
			for($x=1;$x<=$count;$x++){
				$sql .= ' or pic'.$x.'___origin="'.$file.'" ';
			}
			$sql .= ')';
			$rows = $db->query($sql)->result_array();

			if($rows and !empty($rows)){
				foreach($rows as $k => $v){
					for($x=1;$x<=$count;$x++){
						if(isset($v['pic'.$x.'___origin']) and $v['pic'.$x.'___origin'] == $file){
							$success = $v['pic'.$x];
							break;
						}
					}
					if($success != ''){
						break;
					}
				}
			}
		}
	}

	if($success != ''){
		//$_SERVER['REQUEST_URI'] = 'assets/upload/'.$router_method.'/'.$success;
		//$_GET['w'] = 9999;
		//$_GET['h'] = 9999;

		$_GET['nowatermark'] = 1;
		$_GET['src'] = 'assets/upload/'.$router_method.'/'.$success;
		$_GET['zc'] = 0;

		define ('MAX_WIDTH', 0);
		define ('MAX_HEIGHT', 0);

		//$_GET['nocache'] = '';
		//require('watermark.php');

		//RewriteRule ^upload/_demo/(.*)$ /_i/timthumb.php?src=assets/upload/_demo/$1&zc=3&w=500&h=500&nocache= [L]
		require('timthumb.php');
	} else {
		header('HTTP/1.1 404 Not Found');
	}

} else {
	header('HTTP/1.1 404 Not Found');
}
