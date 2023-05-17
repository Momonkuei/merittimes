<?php

use nguyenanhung\CodeIgniterDB as CI;

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

/*
 * 記錄誰下載了什麼
 *
 * 這個功能是針對html資料表所做的，
 */

/*
--
-- Table structure for table `record_log`
--

CREATE TABLE IF NOT EXISTS `record_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
 */

// 開放的型態(安全性)
$types = array(
	'download',
);

// 開放的欄位(安全性)
$fields = array(
	'file1', // 第一個欄位是預設值
);

function get_client_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

if(!isset($_GET['id'])){
	header('Location: /');
	die;
}

$id = intval($_GET['id']);

$field = $fields[0];
if(isset($_GET['field']) and $_GET['field'] != ''){
	if(in_array($_GET['field'],$fields)){
		$field = $_GET['field'];
	}
}

$tmps = explode('/',__FILE__);
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

@session_start();

// 如果需要用的時候在用
$session_prefix = $filename;

/*
 * 只需要session，而不需要資料庫的存取的動作，可以寫在這裡
 */

// 是否登入的驗證，如果不需要的話就註解掉
if(0){
	if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] > 0){
		// do nothing
	} else {
		$message = <<<XXX
<script type="text/javascript">
alert('Please Login First!');
window.location.href='/';
</script>
XXX;
		echo $message;
		die;
	}
}

//include 'include/ci.php';
//include GGG_BASEPATH.'../_i/config/db.php';

//引入我之前，請先引入include/MysqlConn.php(它是我大哥)
define('GGG_BASEPATH', realpath(dirname(__FILE__)).'/');
include_once GGG_BASEPATH.'layoutv3/vendor/autoload.php';

include GGG_BASEPATH.'_i/config/db.php';

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
	// 'db_debug' => true
);

// $db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
//$db = ggg_load_database($tmps, true);

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
$rDb = mysqli_connect($tmps['hostname'], $tmps['username'], $tmps['password']);
$db =& CI\DB($tmps, null, $rDb);


/*
 * 需要資料庫的動作，可以寫在這裡
 */
// $query = $db->where('is_enable',1)->where('ml_key',$_SESSION['web_ml_key'])->where('type','download')->where('id',$_GET['id'])->get('html');
$query = $db->where('is_enable',1)->where('ml_key',$_SESSION['web_ml_key'])->where_in('type',$types)->where('id',$_GET['id'])->get('html');
$row = $query->row_array();

if($row and isset($row['id']) and in_array($row['type'], $types)){
	$save = array(
		'item_id' => $id,
		'ip' => get_client_ip(),
		'create_time' => date('Y-m-d H:i:s'),
	);
	if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] > 0){
		$save['from_user_id'] = $_SESSION['authw_admin_id'];
	}
	$db->insert($filename.'_log', $save); 

	if(isset($row['url1']) and $row['url1'] != ''){
		header('Location: '.$row['url1']);
		die;
	} else {
		// $file = '_i/assets/file/download/'.$row['file1'];
		$file = '_i/assets/file/'.$row['type'].'/'.$row['file1'];

		// 2017-07-26 支援Big5中文作業系統
		// 這裡是參考後台母體的excelexport
		// 雖然檔名是英文，不過以備不時之需
		$tmps = explode('.', basename($file));

		// 預設規則：也就是標題當做檔名。這裡是唯一可能被客制的地方
		$file_name = $row['topic'].'.'.$tmps[1];

		if(preg_match('/(MSIE|Trident)/', $_SERVER['HTTP_USER_AGENT'])){
			$file_name = iconv('utf-8','big5',$file_name);
		}

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$file_name.'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		die;
	}
} else {
	$message = <<<XXX
<script type="text/javascript">
alert('File not Exists!');
window.location.href='/';
</script>
XXX;
	echo $message;
	die;
}

?>
<?php // HTML寫在最下面，如果需要的話?>
