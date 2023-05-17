<?php

use nguyenanhung\CodeIgniterDB as CI;

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
 * 2019-10-15
 * 使用方式
 * agent_tw.php?id=XX
 */

/*
 * --
 * -- Table structure for table `agent`
 * --
 * 
 * CREATE TABLE IF NOT EXISTS `agent` (
 *   `id` int(11) NOT NULL AUTO_INCREMENT,
 *   `login_account` varchar(100) NOT NULL,
 *   `login_password` varchar(100) NOT NULL,
 *   `salt` varchar(50) NOT NULL,
 *   `name` varchar(30) NOT NULL,
 *   `is_enable` tinyint(1) NOT NULL,
 *   `create_time` datetime NOT NULL,
 *   `update_time` datetime NOT NULL,
 *   PRIMARY KEY (`id`)
 * ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
 * 
 * --
 * -- Table structure for table `agent_log`
 * --
 * 
 * CREATE TABLE IF NOT EXISTS `agent_log` (
 *   `id` int(11) NOT NULL AUTO_INCREMENT,
 *   `agent_id` int(11) NOT NULL,
 *   `item_id` int(11) NOT NULL,
 *   `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 *   `create_time` datetime NOT NULL,
 *   PRIMARY KEY (`id`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
 * 
*/

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

function utf8_strrev($str){
	preg_match_all('/./us', $str, $ar);
	return implode('', array_reverse($ar[0]));                                                   
}

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

$tmps = explode('/',__FILE__);
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

@session_start();

$session_prefix = $filename;

if(isset($_GET['logout']) and intval($_GET['logout']) == 1){
	unset($_SESSION[$session_prefix.'_id']);
	unset($_SESSION[$session_prefix.'_name']);
	unset($_SESSION[$session_prefix.'_captcha']);
	$message = <<<XXX
<script type="text/javascript">
alert('Logout Success!');
window.location.href='/';
</script>
XXX;
	echo $message;
	die;
} elseif(isset($_GET['showcaptcha'])){
	$im = @ImageCreate (96, 25) or die ('Cannot Initialize new GD image stream'); 
	$background_color = ImageColorAllocate ($im, 221, 221, 221);
	$text_color = ImageColorAllocate ($im, 0, 0, 0);
	$num_color = array(
		ImageColorAllocate ($im, 128, 0, 0),
		ImageColorAllocate ($im, 0, 128, 0),
		ImageColorAllocate ($im, 0, 0, 128),
		ImageColorAllocate ($im, 255, 80, 0),
		ImageColorAllocate ($im, 0, 128, 80),
		ImageColorAllocate ($im, 0, 80, 255),
		ImageColorAllocate ($im, 255, 0, 80),
		ImageColorAllocate ($im, 80, 0, 255),
		ImageColorAllocate ($im, 128, 128, 0),
		ImageColorAllocate ($im, 0, 128, 128));

	// 將背景色(白色)
	// 改成透明(拿掉就變灰色了)
	$white = imagecolorallocate($im, 255, 255, 255);
	imagefill($im, 0, 0, $white);
	imagecolortransparent($im, $white);

	$line_color = ImageColorAllocate ($im, 128, 128, 128);
	$CheckStr = '0123456789';
	$font_file = array (
		//_BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'haldanor.ttf',
		'_i/fonts/haldanor.ttf',
	);
	// 旋轉角度
	$angel_set = array(0,2,4,6,8,10,12,14,16,18,20,-2,-4,-6,-8,-10,-12,-14,-16,-18,-20);
	$SCode = '';
	for($i=0; $i<4; $i++) {
		srand((double)microtime()*1000000); 
		$rndFont = (rand() % count($font_file));
		srand((double)microtime()*1000000); 
		$dd = (rand() % strlen($CheckStr));
		srand((double)microtime()*1000000); 
		$aa = (rand() % count($angel_set));
		$ckChar = substr($CheckStr, $dd, 1);
		$SCode .= $ckChar;
		$N_color = (rand() % count($num_color));
		// 字型
		//ImageTTFText ($im, 18, $angel_set[$aa], 2+($i*rand(16, 18)), 20, $num_color[$N_color], $font_file[$rndFont], $ckChar); 
		ImageTTFText ($im, 20, $angel_set[$aa], 8+($i*rand(20, 23)), 22, $num_color[$N_color], $font_file[$rndFont], $ckChar);
	}

	$_SESSION[$session_prefix.'_captcha'] = $SCode;

    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
	header('Content-type: image/png');
	imagepng ($im);
	imagedestroy ($im);
	exit();
}

// include 'include/ci.php';

$vendors_dir = _BASEPATH.'/vendors';
ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

// composer autoload 2018-12-18
include_once GGG_BASEPATH.'../vendor/autoload.php';

// include GGG_BASEPATH.'../_i/config/db.php';

$Db_Server = aaa_dbhost;
$Db_User = aaa_dbuser;
$Db_Pwd = aaa_dbpass;
$Db_Name = aaa_dbname; 

// CI2
// $tmps = array(
// 	'dbdriver' => 'mysql',
// 	'username' => $Db_User,
// 	'password' => $Db_Pwd,
// 	'hostname' => $Db_Server,
// 	'port' => 3306,
// 	'database' => $Db_Name,
// 	// 'db_debug' => true
// );

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

if(isset($_GET['id']) and intval($_GET['id']) > 0){
	if(!isset($_SESSION[$session_prefix.'_id'])
		or $_SESSION[$session_prefix.'_id'] <= 0
		or !isset($_SESSION[$session_prefix.'_name'])
		or $_SESSION[$session_prefix.'_name'] == ''
	){
		$message = <<<XXX
<script type="text/javascript">
alert('Please Login!');
window.location.href='$filename.php';
</script>
XXX;
		echo $message;
		die;
	}

	$id = intval($_GET['id']);
	//$row = $this->db->createCommand()->from('html')->where('is_enable=1 and id=:id',array(':id'=>$id))->queryRow();
	// $db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
	// $db = ggg_load_database($tmps, true);

	$save = array(
		'agent_id' => $_SESSION[$session_prefix.'_id'],
		'item_id' => $id,
		'ip' => get_client_ip(),
		'create_time' => date('Y-m-d H:i:s'),
	);
	$db->insert($filename.'_log', $save); 

	$query = $db->where('type','download')->where('is_enable',1)->where('id',$_GET['id'])->where('ml_key',$_SESSION['web_ml_key'])->get('html');
	$row = $query->row_array();
	$file = '_i/assets/file/download/'.$row['file1'];

	// 2017-07-26 支援Big5中文作業系統
	// 這裡是參考後台母體的excelexport
	// 雖然檔名是英文，不過以備不時之需
	$tmps = explode('.', basename($file));
	$file_name = $row['topic'].'.'.$tmps[1];

	// 2019-03-13 依照管理者所設定的，有需要在打開
	// if(isset($row['other30']) and $row['other30'] != ''){
	// 	$file_name = $row['other30'].'.'.$tmps[1];
	// }

	if(preg_match('/(MSIE|Edge|Trident)/', $_SERVER['HTTP_USER_AGENT'])){
		if(preg_match('/Edge/', $_SERVER['HTTP_USER_AGENT'])){
			// https://www.itread01.com/content/1548273435.html
			$file_name = urlencode($file_name);
		} else {
			$file_name = iconv('utf-8','big5//IGNORE',$file_name);
		}
	}

	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	// header('Content-Disposition: attachment; filename='.basename($file));
	header('Content-Disposition: attachment; filename="'.$file_name.'"');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	die;
}

if(!empty($_POST) 
	and isset($_POST['login_account'])
	and isset($_POST['login_password'])
	and $_POST['login_account'] != ''
	and $_POST['login_password'] != ''
	// and isset($_POST['captcha'])
	// and $_POST['captcha'] != ''
){
	// $captcha = $_POST['captcha'];

	if(0 and $captcha != $_SESSION[$session_prefix.'_captcha']){
		$_SESSION[$session_prefix.'_captcha'] = '';
		$message = <<<XXX
<script type="text/javascript">
alert('Login fail!');
window.location.href='$filename.php';
</script>
XXX;
		echo $message;
		die;
	}

	// 安全性
	// $_SESSION[$session_prefix.'_captcha'] = '';

	$user = $_POST['login_account'];
	$pass = $_POST['login_password'];

	//$db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
	$query = $db->where('login_account',$user)->where('is_enable',1)->get($filename);
	$row = $query->row_array();
	//$query = $db->where('login_account',$user)->where('login_password','{GGG3AAA}'.str_replace('a','ɢ', sha1(utf8_strrev($pass.$row['salt']))))->where('is_enable',1)->get($filename);
	$query = $db->where('login_account',$user)->where('login_password',$pass)->where('is_enable',1)->get($filename); // 2018-06-26 資料表改成customer
	$row = $query->row_array();

	$redirect_url = 'download.php';

	if(isset($_POST['redirect_url']) and $_POST['redirect_url'] != ''){
		$redirect_url = $_POST['redirect_url'];
	}

	if($row and isset($row['id']) and $row['id'] > 0){
		$_SESSION[$session_prefix.'_id'] = $row['id'];
		$_SESSION[$session_prefix.'_name'] = $row['name'];

		// 2018-06-26 資料表是customer的情況
		// $_SESSION['authw_admin_id'] = $row['id'];

		$message = <<<XXX
<script type="text/javascript">
alert('Login Success!');
window.location.href='$redirect_url';
</script>
XXX;
		echo $message;
		die;
	} else {
		$message = <<<XXX
<script type="text/javascript">
alert('Login fail!');
window.location.href='$redirect_url';
</script>
XXX;
		echo $message;
		die;
	}
} // POST



if(
	isset($_SESSION[$session_prefix.'_id']) 
	and $_SESSION[$session_prefix.'_id'] > 0
	and isset($_SESSION[$session_prefix.'_name']) 
	and $_SESSION[$session_prefix.'_name'] != ''
){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Lang</title>
</head>
<body>
<h2><?php echo $_SESSION[$session_prefix.'_name']?>您好：</h2>
<a href="/">回首頁</a><br />
<a href="<?php echo $filename?>.php?logout=1">登出</a><br />
</body>
</html>
<?php
	die;
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<style type="text/css">
.form-style-8{
	font-family: 'Open Sans Condensed', arial, sans;
	width: 500px;
	padding: 30px;
	background: #FFFFFF;
	margin: 50px auto;
	box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.22);
	-moz-box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.22);
	-webkit-box-shadow:  0px 0px 15px rgba(0, 0, 0, 0.22);

}
.form-style-8 h2{
	background: #4D4D4D;
	text-transform: uppercase;
	font-family: 'Open Sans Condensed', sans-serif;
	color: #797979;
	font-size: 18px;
	font-weight: 100;
	padding: 20px;
	margin: -30px -30px 30px -30px;
}
.form-style-8 input[type="text"],
.form-style-8 input[type="date"],
.form-style-8 input[type="datetime"],
.form-style-8 input[type="email"],
.form-style-8 input[type="number"],
.form-style-8 input[type="search"],
.form-style-8 input[type="time"],
.form-style-8 input[type="url"],
.form-style-8 input[type="password"],
.form-style-8 textarea,
.form-style-8 select
{
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	outline: none;
	display: block;
	width: 100%;
	padding: 7px;
	border: none;
	border-bottom: 1px solid #ddd;
	background: transparent;
	margin-bottom: 10px;
	font: 16px Arial, Helvetica, sans-serif;
	height: 45px;
}
.form-style-8 textarea{
	resize:none;
	overflow: hidden;
}
.form-style-8 input[type="button"],
.form-style-8 input[type="submit"]{
	-moz-box-shadow: inset 0px 1px 0px 0px #45D6D6;
	-webkit-box-shadow: inset 0px 1px 0px 0px #45D6D6;
	box-shadow: inset 0px 1px 0px 0px #45D6D6;
	background-color: #2CBBBB;
	border: 1px solid #27A0A0;
	display: inline-block;
	cursor: pointer;
	color: #FFFFFF;
	font-family: 'Open Sans Condensed', sans-serif;
	font-size: 14px;
	padding: 8px 18px;
	text-decoration: none;
	text-transform: uppercase;
}
.form-style-8 input[type="button"]:hover,
.form-style-8 input[type="submit"]:hover {
	background:linear-gradient(to bottom, #34CACA 5%, #30C9C9 100%);
	background-color:#34CACA;
}
</style>
<script type="text/javascript">
//auto expand textarea
function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}
</script>
<script type="text/javascript">
var msgErrorTip2 = '請輸入「%s」';
var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
var msgProcess = '處理中...';

// JavaScript Document
var formIsSubmit = false;

function MM_findObj(n, d) { //v4.01
	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
	d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
	if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
	/* //2016/7/14 lota 改用新的方式，不使用二次送出阻止方法
	if(formIsSubmit){
		show_alert(msgProcess);
		document.MM_returnValue = false;
		return false;
	}
	*/
	var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
	for (i=0; i<(args.length-2); i+=3){
		test=args[i+2]; val=MM_findObj(args[i]);
		if (val){
			nm=val.name;
			nm_id=val.id;
			if ((val=val.value)!="") {
				if (test.indexOf('isEmail')!=-1){
					p=val.indexOf('@');
					if (p<1 || p==(val.length-1)) errors+=msgErrorTip3 + '\n';
				}else if(test!='R'){
					num = parseFloat(val);
					if (isNaN(val)) errors+='「'+nm_id+'」' + msgErrorTip4 + '\n';
					if (test.indexOf('inRange') != -1){
						p=test.indexOf(':');
						min=test.substring(8,p); max=test.substring(p+1);
						if (num<min || max<num){
							var ssss = strprintf(msgErrorTip5, min, max);
							errors+='- '+nm+' ' + ssss;
						}
					}
				}
			}else if (test.charAt(0) == 'R'){
				if(nm_id == 'SearchKeyword'){
					errors += msgErrorTip1 + '\n';
				}else{
					var s_err = strprintf(msgErrorTip2, nm_id);
					errors += s_err + '\n';
				}
			}
		}
	}

	// 12/16 add
    //var text = $(".check_mobile").val();
    //  re  = /^[09]{2}[0-9]{8}$/;
    //  re1 = /^[09]{2}[0-9]{2}-[0-9]{6}$/;
    //  re2 = /^[09]{2}[0-9]{2}-[0-9]{3}-[0-9]{3}$/;
    //  re3 = /^[09]{2}[0-9]{2} [0-9]{6}$/;
    //  re4 = /^[09]{2}[0-9]{2} [0-9]{3} [0-9]{3}$/;

    //if (text.search(re)=="-1" && text.search(re1)=="-1" && text.search(re2)=="-1" && text.search(re3)=="-1"&& text.search(re4)=="-1"){
	//  errors += '你的手機格式不對！' + '\n';
    //}
	
	var frm = args[args.length-1];
	
	if(frm.new_pswd && frm.cfm_pswd){
		if(frm.new_pswd.value != frm.cfm_pswd.value) {
			var s_err = msgErrorTip6;
			errors += s_err + '\n';
		}
	}
	
	
	if (errors){
		show_alert(errors);
	}
	
	document.MM_returnValue = (errors == '');
	formIsSubmit = document.MM_returnValue;
}

function show_alert(msg) {
	alert(msg);
}


//檢查核取方塊的必填欄位是否有值
function confirm_checkboxes(obj,val){
	var	chk_skin=0;	
	
	for(x=0;x<obj.length;x++){
		if(obj[x].checked == true) chk_skin++;
	} 
	if(chk_skin==0)
		return val;
	else
		return '';
}

function strprintf(){
	var args = strprintf.arguments;
	var str = '';
	if(args[0]){
		str = args[0];
	}
	if(args.length > 1){
		str1 = ''
		for(var i=0, j=1; i<str.length; i++){
			if((str.substring(i, i+2) == '%s') && args[j]){
				str1 += args[j];
				i++;
				j++;
			}else{
				str1 += str.substring(i, i+1);
			}
		}
		str = str1;
	}
	return str;
}
</script>
</head>

<body>
<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('帳號','','R', '密碼','','R', this); return document.MM_returnValue;">
<?php if(0):?>
<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('帳號','','R', '密碼','','R', '驗證碼', '', 'R', this); return document.MM_returnValue;">
<?php endif?>
	<div class="form-style-8">
		<h2>經銷商登入</h2>
		<input type="text" name="login_account" id="帳號" placeholder="Account" />
		<input type="password" name="login_password" id="密碼" placeholder="Password" />
<?php if(0):?>
		<img src="<?php echo $filename?>.php?showcaptcha=" />
		<input type="text" name="captcha" id="驗證碼" placeholder="驗證碼" />
<?php endif?>
		<input type="submit" value="Submit" />
	</div>
</form>
</body>
</html>
