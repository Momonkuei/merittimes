<?php
set_time_limit(0);
ini_set("memory_limit", -1);

//$time_start = microtime(true);
ob_start();
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
// var_dump($_FILES);die;
// $file = '20220323.xlsx';
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
	$import_cnt=0;
	/*匯入的會員帶入代碼，需要會員+學校皆有資料才有用*******************************************************************************/
	// $school_list=$cidb->where('is_enable',1)->get('customer')->result_array();
	// foreach($school_list as $k =>$v){
	// 	$conform_data=$cidb->like('name',$v['school_name'])->like('serial',$v['other2'])->get('school')->row_array();
	// 	if(!empty($conform_data)){
	// 		$cidb->where('id',$v['id']);
	// 		$cidb->update('customer',array('code'=>$conform_data['code']));
	// 	}
	// }
	/**************************************************************************************************************************/ 
	if(!empty($exceldata)){
		foreach($exceldata as $k => $v){
			if($k == 1){
				continue;
			}
			$code=strtoupper($v['A']);
			//學校匯入------------------------------------------------------------------------------------------------------------------------------------------------start
			$dir_path = GGG_BASEPATH.'../_i/assets/file/school/'.$code;

			if(!file_exists($dir_path)){
				@mkdir($dir_path, 0777, true);
			}
			$save = array(
				'topic' => $v['B'],
				'ml_key'=>'tw',
				'code' => $code,
				'serial' => $v['C'],
				'administrative' => $v['D'],
				'postal' => $v['E'],
				'address' => $v['F'],
				'is_enable	'=>1,
				'create_time' => date('Y-m-d H:i:s'),
				'update_time' => date('Y-m-d H:i:s'),
			);
			$cidb->insert('school', $save); 
			$id = $cidb->insert_id();
			if(!empty($id)){
				$cidb->where('id',$id);
				$cidb->update('school',array('sort_id'=>$id));
			}
			
			//-----------------------------------------------------------------------------------------------------------------------------------------------------------end
			//會員資料--------------------------------------------------------------------------------------------------------------------------------------------------start
			//日期處理-更新
			// // $other3_array=array(
			// // 	'國小組'=>1,
			// // 	'國中組'=>2,
			// // 	'高中職組'=>3,
			// // 	'大專校院組'=>4,
			// // );
			// if(!empty($v['U'])){
			// 	$APPM=explode(' ',$v['U']);
			// 	if($APPM[1]=='上午'){
			// 		$time=explode(":",$APPM[2]);
			// 		$time=$time[0].':'.$time[1].':'.$time[2];
			// 	}else{
			// 		$time=explode(":",$APPM[2]);
			// 		$time=($time[0]+12).':'.$time[1].':'.$time[2];
			// 	}
			// 	$v['U']=$APPM[0].' '.$time;
			// 	$upload_date=$v['U'];
			// 	echo date('Y-m-d H:i:s',strtotime($v['U'])).'<br>';
			// }else{
			// 	$upload_date=date('Y-m-d H:i:s');
			// }
			// //日期處理-申請
			// if(!empty($v['S'])){
			// 	$APPM=explode(' ',$v['S']);
			// 	if($APPM[1]=='上午'){
			// 		$time=explode(":",$APPM[2]);
			// 		$time=$time[0].':'.$time[1].':'.$time[2];
			// 	}else{
			// 		$time=explode(":",$APPM[2]);
			// 		$time=($time[0]+12).':'.$time[1].':'.$time[2];
			// 	}
			// 	$v['S']=$APPM[0].' '.$time;
			// 	$create_date=$v['S'];
			// 	// echo date('Y-m-d H:i:s',strtotime($v['U'])).'<br>';
			// }else{
			// 	$create_date=date('Y-m-d H:i:s');
			// }
			// //座機+區碼組合
			// if(!empty($v['K']) || !empty($v['L'])){
			// 	if(!empty($v['K']) && !empty($v['L'])){
			// 		$landline='0'.$v['K'].$v['L'];
			// 	}else if(!empty($v['L']) && empty($v['K'])){
			// 		$landline=$v['L'];
			// 	}else{
			// 		$landline='';
			// 	}
			// }
			// //手機號碼+0
			// if(!empty($v['N'])){
			// 	$phone='0'.$v['N'];
			// }
			// //傳真+區碼組合
			// if(!empty($v['Q']) || !empty($v['R'])){
			// 	if(!empty($v['Q']) && !empty($v['R'])){
			// 		$fax='0'.$v['Q'].$v['R'];
			// 	}else if(!empty($v['R']) && empty($v['Q'])){
			// 		$fax=$v['R'];
			// 	}else{
			// 		$fax='';
			// 	}
			// }
			// //密碼加密
			// $Caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
			// $QuantidadeCaracteres = strlen($Caracteres);
			// $QuantidadeCaracteres--;
			// $Hash=NULL;
			// for($x=1;$x<=10;$x++){
			// 	$Posicao = rand(0,$QuantidadeCaracteres);
			// 	$Hash .= substr($Caracteres,$Posicao,1);
			// }
			// $salt = $Hash;
			// preg_match_all('/./us', $v['X'].$salt, $ar);
			// $password=implode('', array_reverse($ar[0]));

			// $login_password = '{GGG3AAA}'.str_replace('a','ɢ', sha1($password));

			// $save = array(
			// 	'login_account'=>$v['W'],
			// 	'member_grade'=>1,
			// 	'salt'=>$salt,
			// 	'login_password'=>$login_password,
			// 	'school_name' => $v['C'],
			// 	'other1' => 1,
			// 	'other2' => $v['D'],
			// 	'other4' => $v['E'],
			// 	'other3' => $v['F'],
			// 	'addr_district' => $v['G'],
			// 	'addr' => $v['H'],
			// 	'name' => $v['I'],
			// 	'jobtitle' => $v['J'],
			// 	'email' => $v['P'],
			// 	'phone' => $phone,
			// 	'p_extension'=>$v['M'],
			// 	'fax' => $fax,
			// 	'mobile' => $landline,
			// 	'line_id' => $v['O'],
			// 	'applications_num' => $v['T'],
			// 	'is_enable'=>1,
			// 	'create_time' => $create_date,
			// 	'update_time' => $upload_date,
			// );
			// $cidb->insert('customer', $save);
			// $id = $cidb->insert_id();
			//-----------------------------------------------------------------------------------------------------------------------------------------------------------end
			//計劃書匯入------------------------------------------------------------------------------------------------------------------------------------------------start
			//先處理學校+學期 兩者缺一皆略過
			// if(empty($v['C']) || empty($v['G'])){
			// 	continue;
			// }
			// //學校資料
			// $school_data=$cidb->where('school_name',$v['C'])->get('customer')->row_array();
			// //學期資料
			// $semester_data=$cidb->where('topic',$v['G'])->where('type','semester')->get('html')->row_array();
			// if(empty($semester_data)){
			// 	$sort_id=$cidb->where('type','semester')->order_by('sort_id desc')->get('html')->row_array();
			// 	$semester_save=array(
			// 		'topic'=>$v['G'],
			// 		'type'=>'semester',
			// 		'ml_key'=>'tw',
			// 		'is_enable'=>1,
			// 		'sort_id'=>(!empty($sort_id['sort_id'])?($sort_id['sort_id']+1):1),
			// 		'create_time'=>date('Y-m-d H:i:s'),
			// 		'update_time'=>date('Y-m-d H:i:s'),
			// 	);
			// 	$cidb->insert('html', $semester_save); 
			// 	$semester_id = $cidb->insert_id();
			// }else{
			// 	$semester_id=$semester_data['id'];
			// }
			// //送審日期-處理
			// if(!empty($v['M'])){
			// 	$APPM=explode(' ',$v['M']);
			// 	if($APPM[1]=='上午'){
			// 		$time=explode(":",$APPM[2]);
			// 		$time=$time[0].':'.$time[1].':'.$time[2];
			// 	}else{
			// 		$time=explode(":",$APPM[2]);
			// 		$time=($time[0]+12).':'.$time[1].':'.$time[2];
			// 	}
			// 	$v['M']=$APPM[0].' '.$time;
			// 	$submission_date=$v['M'];
			// }else{
			// 	$submission_date=date('Y-m-d H:i:s');
			// }
			// //審查日期-處理
			// if(!empty($v['N'])){
			// 	$APPM=explode(' ',$v['N']);
			// 	if($APPM[1]=='上午'){
			// 		$time=explode(":",$APPM[2]);
			// 		$time=$time[0].':'.$time[1].':'.$time[2];
			// 	}else{
			// 		$time=explode(":",$APPM[2]);
			// 		$time=($time[0]+12).':'.$time[1].':'.$time[2];
			// 	}
			// 	$v['N']=$APPM[0].' '.$time;
			// 	$review_date=$v['N'];
			// }else{
			// 	$review_date=date('Y-m-d H:i:s');
			// }
			// $save = array(
			// 	'schoo_id' => $school_data['id'],
			// 	'semester_id' => $semester_id,
			// 	'plan_book' => $v['L'],
			// 	'submission_date' => $submission_date,
			// 	'review_date' => $review_date,
			// 	'reviewopinion' => $v['O'],
			// 	'reviewresults' => $v['P'],
			// 	'application_report' => $v['R'],
			// 	'approval_report' => $v['S'],
			// 	'classes_num' => $v['T'],
			// 	'students_num' => $v['U'],
			// 	'create_time' => date('Y-m-d H:i:s'),
			// 	'update_time' => date('Y-m-d H:i:s'),
			// );
			// $cidb->insert('ruse', $save); 
			// $id = $cidb->insert_id();
			//----------------------------------------------------------------------------------------------------------------------------------------------------------end
			print_r($save);
			echo "<hr>";
		}
	}
	die;
	// header("Location: ../_i/backend.php?r=itemimport");
	ob_end_flush();

}
