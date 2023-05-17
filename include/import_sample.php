<?php
set_time_limit(0);
ini_set("memory_limit", -1);

//$time_start = microtime(true);

//error_reporting(0);	
error_reporting(E_ALL);
ini_set("display_errors", 1);
header("Content-Type:text/html; charset=utf-8");

//資料連結宣告
use nguyenanhung\CodeIgniterDB as CI;

$php_version = (float)phpversion();

//引入函式庫
if($php_version >= 5.6){
	require_once('phpSpreadsheet.php');
}else{	
	include 'Classes/PHPExcel.php';
}

/*
 * 設定要被讀取的檔案，經過測試檔名不可使用中文
 */
$file = 'product-2019-09-20-09-30-28.xlsx';
if(isset($_FILES['file1']['tmp_name']) && $_FILES['file1']['tmp_name']!=''){
	$file = $_FILES['file1']['tmp_name'];
}

if($file != ''){
	if($php_version >= 5.6){
		$exceldata = importExecl($file);
	}else{
		//載入函式庫
		try {
		    $objPHPExcel = PHPExcel_IOFactory::load($file);
		} catch(Exception $e) {
		    die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		//$sheetData = $objPHPExcel->getSheet(1)->toArray(null,true,true,true);//手動選擇要讀取的分頁
		$exceldata = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);//自動選擇最後編輯的分頁
		//依照第一行的資料，來判斷哪些是有用欄位
		$_tmp = array();
		$_tmp_key = array();
		foreach ($exceldata as $key => $value) {
			if(is_array($value)){
				if($key==1){
					foreach ($value as $key1 => $value1) {
						if(!is_null($value1)){
							$_tmp_key[] = $key1;
							$_tmp[$key][$key1] = $value1;
						}						
					}					
				}else{
					foreach ($value as $key1 => $value1) {
						if(in_array($key1,$_tmp_key)){
							if(!is_null($value1)){
								$_tmp[$key][$key1] = $value1;
							}else{
								$_tmp[$key][$key1] = '';
							}
						}
					}
				}
			}
		}
		$exceldata = $_tmp;
	}
	
	// var_dump($exceldata);die;

	//資料連結 V3架構
	define('GGG_BASEPATH', realpath(dirname(__FILE__)).'/');

	$aaa = file_get_contents(GGG_BASEPATH.'../_i/config/db.php');
	$aaa = str_replace('aaa_','gggaaa_',$aaa);
	eval('?'.'>'.$aaa);
	$Db_Server = gggaaa_dbhost;
	$Db_User = gggaaa_dbuser;
	$Db_Pwd = gggaaa_dbpass;
	$Db_Name = gggaaa_dbname; 
	
	
	
	include_once GGG_BASEPATH.'../layoutv3/vendor/autoload.php';	

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
		'char_set' => 'utf8mb4',//2021-03-12 資料庫也要使用utf8mb4 才能存emoji符號 by lota
		'dbcollat' => 'utf8mb4_general_ci',//2021-03-12 資料庫也要使用utf8mb4 才能存emoji符號 by lota
		'swap_pre' => '',
		'encrypt' => false,
		'compress' => false,
		'stricton' => false,
		'failover' => array(),
		'save_queries' => true
	);

	$rDb = mysqli_connect($tmps['hostname'], $tmps['username'], $tmps['password']);
	$db =& CI\DB($tmps, null, $rDb);
	$cidb = $db;

	// 測試資料庫連線是否正常
	// $rows = $cidb->get('html')->result_array();
	// var_dump($rows);die;

	// 寫入範本
	// if(!empty($exceldata)){
	// 	foreach($exceldata as $k => $v){
	// 		if($k == 1){
	// 			continue;
	// 		}
	// 		$save = array(
	// 			'name' => $v['A'],
	// 			'ml_key' => 'en',
	// 			'is_enable' => 1,
	// 			'create_time' => date('Y-m-d H:i:s'),
	// 		);
	// 		
	// 		$cidb->insert('XXX', $save); 
	// 		$id = $cidb->insert_id();
	// 		// echo $cidb->affected_rows();
	// 	}
	// }
	// header('Location: /_i/backend.php?r=XXX');

}
