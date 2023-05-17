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

//撈取資料

	//$rows = $cidb->get('html')->result_array();

//匯出資料

	/** PHPExcel_Writer_Excel2007 */
	include 'Classes/PHPExcel/Writer/Excel2007.php';

	//https://www.cnblogs.com/myx/archive/2013/05/20/phpExcel-setCache.html 壓縮PHPexcel的記憶體暫存
       $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip; 
       PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
	// Create new PHPExcel object

	$objPHPExcel = new PHPExcel();
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Buyersline");
	$objPHPExcel->getProperties()->setLastModifiedBy("Buyersline");
	$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Product Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Product Document");
	$objPHPExcel->getProperties()->setDescription("Product Document for Office 2007 XLSX");

	// 標題
	$admin_field = array('資料欄位1'=>'標題1','資料欄位2'=>'標題2','資料欄位3'=>'標題3','資料欄位4'=>'標題4');
	$objPHPExcel->setActiveSheetIndex(0);
	if($admin_field and !empty($admin_field)){
		$i = 0;
		foreach($admin_field as $k => $v){
			// $objPHPExcel->getActiveSheet()->SetCellValue(chr($i+65).'1', $v['label']); // 2019-05-08 發現超過26個欄位，就會失敗
			$objPHPExcel->getActiveSheet()->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($i).'1', $v);
			$i++;
		}
	}

	// 資料
	if(isset($rows) && !empty($rows)){
		foreach($rows as $k => $v){
			$i = 0;
			foreach($admin_field as $kk => $vv){
				$value = $v[$kk];

				$objPHPExcel->getActiveSheet()->SetCellValueExplicit(PHPExcel_Cell::stringFromColumnIndex($i).($k+2), (string)$value,PHPExcel_Cell_DataType::TYPE_STRING); // 2019-07-17 為了要能夠讀取開頭為零的純數字

				//調整excel排版
				$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);

				$i++;
			}
		}
	}



//準備檔案匯出

// 加上Filter
	$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
	// Save Excel 2007 file
	//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	$file = '檔案名稱'.'-'.date('Y-m-d-H-i-s').'.xlsx';
	if(preg_match('/(MSIE|Edge|Trident)/', $_SERVER['HTTP_USER_AGENT'])){
		if(preg_match('/Edge/', $_SERVER['HTTP_USER_AGENT'])){
			// https://www.itread01.com/content/1548273435.html
			$file = urlencode($file);
		} else {
			$file = iconv('utf-8','big5',$file);
		}
	}
	header('Content-Disposition: attachment;filename="'.$file.'"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
