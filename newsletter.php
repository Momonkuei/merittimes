<?php

use nguyenanhung\CodeIgniterDB as CI;

/*
 * 2018-03-30 從醫揚複製過來
 */

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

@session_start();

// CI3
// 2018-12-18 從ci.php裡面移出來的
if(!defined('GGG_BASEPATH')){
	define('GGG_BASEPATH', realpath(dirname(__FILE__)).'/');
}
if(!defined('GGG_APPPATH')){
	define('GGG_APPPATH', realpath(dirname(__FILE__)).'');
}

// composer autoload 2018-12-18
include_once GGG_BASEPATH.'layoutv3/vendor/autoload.php';

include GGG_BASEPATH.'_i/config/db.php';

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

$email = $_POST['email'];
$email = trim($email);
$email = strtolower($email);

if(!empty($_POST) and isset($_POST['email']) and $_POST['email'] != ''){
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// do nothing
	} else {
		$redirect_url = 'index.php';
		$message = <<<XXX
<script type="text/javascript">
alert('Email format incorrent!');
window.location.href='$redirect_url';
</script>
XXX;
		echo $message;
		die;
	}

	$rDb = mysqli_connect($tmps['hostname'], $tmps['username'], $tmps['password']);
	$db =& CI\DB($tmps, null, $rDb);

	$row = $db->where('name',$email)->get('newsletter')->row_array();

	if(!$row){
		$row = $db->where('name',$email)->get('newsletter')->row_array();
		if(!$row or !isset($row['id'])){
			$save = array(
				'name' => $email,
				'ml_key' => 'en',
				'is_enable' => 1,
				'create_time' => date('Y-m-d H:i:s'),
			);
			$db->insert('newsletter', $save); 
		}
	}

	$redirect_url = 'index.php';
	$message = <<<XXX
<script type="text/javascript">
alert('Subscribe Success!');
window.location.href='$redirect_url';
</script>
XXX;
	echo $message;
	die;
} else {
	$redirect_url = 'index.php';
	$message = <<<XXX
<script type="text/javascript">
alert('Email is empty!');
window.location.href='$redirect_url';
</script>
XXX;
		echo $message;
		die;
}
