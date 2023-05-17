<?php
// session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
session_start();
// get parent directory name
$ggg = __DIR__;
if(stristr('/',$ggg))
	$gggs = explode('/', $ggg);$gggb = 1;	
else
	$gggs = explode('\\', $ggg);$gggb = 2;

$parent_dir = $gggs[count($gggs)-1];

/*
 * gd
 * curl
 * mysqli_connect, mysql_connect
 * htaccess(rewrite)
 * apache
 *
 * 上傳和cache資料夾的權限
 * php版本>=7.0, php版本>=5.6
 *
 * 這是李哥2017-07-20早上叫我做的
 */

if(isset($_GET['type'])){
	if($_GET['type']='phpinfo'){
		phpinfo();die;
	}
	if($_GET['type']=='mailtest_api'){
		define('EIP_APIV1_PUBLICKEY', '341619986985');
		define('EIP_APIV1_PRIVATEKEY', '949032002328');
		define('EIP_APIV1_DOMAIN', 'http://crm2.buyersline.com.tw');

		$public_key = EIP_APIV1_PUBLICKEY;
		$private_key = EIP_APIV1_PRIVATEKEY;

		$server_ip = EIP_APIV1_DOMAIN;
		$url = 'index.php?r=api/emailsendto';
		
		//echo $body_html;die;

		/*
		 * $tmps = array(
		 * 	'ssl',
		 * 	'server',
		 * 	'port',
		 * 	'account',
		 * 	'login_password',
		 * 	'from',
		 * 	'from_name',
		 * 	'to',
		 * 	'cc',
		 * 	'subject',
		 * 	'body',
		 * 	'body_html',
		 * );
		 */
		$params = array(
			'ssl' => 'ssl',
			'server' => 'smtp.gmail.com',
			'port' => '465',
			'account' => '178move@gmail.com',
			'login_password' => 'buyersline', 
			'from' => '178move@gmail.com',
			'from_name' => '178 搬家網',
			'to' => 'jonathan@buyersline.com.tw',
			'cc' => '',
			'subject' => 'test_mail',
			'body' => 'test mail',
			//'body_html' => addslashes($body_html), 這個不需要
			'body_html' => 'test mail',
		);

		// include 'eip_client.php';

		$postdata = http_build_query(
			array(
				'get_client_code' => '',
			)
		);
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		$context  = stream_context_create($opts);
		$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

		$code = stripslashes($code);
		eval('?'.'>'.$code);

		echo 'send ok';die;

		//var_dump($return);die;

		// 這裡Debug才有需要打開…吧
		// if(isset($return)){
		// 	var_dump($return);
		// }
	}
	if($_GET['type']=='mailtest'){
		include_once("class.phpmailer.php");
		include_once("class.smtp.php");

		$mail = new PHPMailer();
		$mail->IsSMTP();                                      // set mailer to use SMTP		
		$mail->SMTPDebug = 3;
		$php_version = (float)phpversion();
		if($php_version >= 5.6 && isset($_GET['sendssl'])){
			$mail->SMTPOptions = array(
			'ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false,
			    'allow_self_signed' => true
			    )
			);
		}
		if(isset($_GET['user']) && isset($_GET['pass'])){
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = $_GET['user'];
			$mail->Password = $_GET['pass'];
		}else{
			$mail->SMTPAuth = false;     // turn on SMTP authentication
		}
		if(isset($_GET['host'])){
			$mail->Host = $_GET['host']; 
		}else{
			$mail->Host = 'localhost';  // specify main and backup server
		}
		if(isset($_GET['AuthType']) && $_GET['AuthType']!=''){
			//$mail->AuthType = 'LOGIN';
			$mail->AuthType = $_GET['AuthType'];
		}		
		if(isset($_GET['sendssl'])){
			$mail->Port = 465;
			$mail->SMTPSecure = "ssl";
		}else{
			$mail->Port = 24;
			$mail->SMTPSecure = "";
		}
		$mail->IsHTML(true);                                  // set email format to HTML
		$mail->CharSet = "utf-8";
		$mail->Encoding = "base64";
		if(isset($_GET['user'])){
			$mail->From = $_GET['user'];
		}else{
			$mail->From = 'mis2@buyersline.com.tw';
		}
		
		$mail->FromName = 'mis2';
		$mail->AddAddress('mis2@buyersline.com.tw');
		$mail->Subject = 'test mail';
		$mail->Body = 'test mail';
		if(!$mail->send()){
			echo 'Message could not be sent.';
  			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		die;
	}
	if($_GET['type']=='ping'){
		$target = (isset($_GET['target']))?$_GET['target']:'crm2.buyersline.com.tw';
		echo shell_exec("echo `ping -c 1 ".$target." | grep icmp_seq | awk '{print $8}' |cut -c 6-`");die;
	}
	if($_GET['type']=='filetest'){

		error_reporting(E_ALL);
		ini_set("display_errors", 1);

		unlink('test1.jpg');
		unlink('test2.jpg');
		unlink('test3.jpg');
		unlink('test4.jpg');
		unlink('test5.jpg');

		$url = 'http://crm2.buyersline.com.tw/_i/assets/upload/salesqa/34bbbdae88320e4714ee2b13f2065d28.jpg';

		if(count($url) > 0){		
			include "Snoopy.class.php";
		}

		$test1 = new Snoopy;
		$test1->fetch($url);
		file_put_contents('test1.jpg', $test1->results);

		$test2 = file_get_contents($url);
		@file_put_contents('test2.jpg', $test2);

		function get_data($url) {
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}

		$test3 = get_data($url);
		file_put_contents('test3.jpg', $test3);

		$test4 = '';
		if ($fp = fopen($url, 'r')) {
			// keep reading until there's nothing left
			while ($line = fgets($fp, 1024)) {
				$test4 .= $line;
			}
		}
		if($test4 != ''){
			file_put_contents('test4.jpg', $test4);
		}

		echo '
		test1(Snoopy)<br />
		<img src="test1.jpg" /><br />

		test2(file_get_contents)<br />
		<img src="test2.jpg" /><br />

		test3(curl)<br />
		<img src="test3.jpg" /><br />

		test4(fopen)<br />
		<img src="test4.jpg" /><br />
		';die;
	}
	if($_GET['type']=='uploadfile'){
		echo '<form action="?type=uploadfiletest" method="post" enctype="multipart/form-data" name="form1" >';
		echo '<input name="ggg" type="file" />';
		echo '<input type="submit" name="Submit2" value="go" />';
		echo '</form>';
		die;
	}
	if($_GET['type']=='uploadfiletest'){
		var_dump($_FILES);die;
	}
	if($_GET['type']=='show_session'){
		if(isset($_GET['value'])){
			var_dump($_SESSION[$_GET['value']]);
			die;
		}
		var_dump($_SESSION);
		die;
	}
}

$result = array();


$tmp = array();
$tmp = array(
	'name' => 'PHP版本 檢查',
	'value' => phpversion(),
	'status' => false,
	'description' => '如PHP版本低於5.3則網站可能會出現不可預期的錯誤，請協助將PHP版本安裝 5.4，5.5，5.6，7.0，7.1，7.2，7.3 版本',
);
$php_version = (float)phpversion();
//if($php_version >= 5.3 and $php_version <= 7.0){
if($php_version >= 5.4 and $php_version <= 7.3){
	$tmp['status'] = true;
}
$result[] = $tmp;


// http://php.net/manual/en/function.session-status.php#113468
// http://php.net/manual/en/function.session-status.php#120013
$tmp = array();
$tmp = array(
	'name' => 'PHP Session檢查',
	'value' => '&nbsp;',
	'status' => false,
	'description' => '請檢查'.session_save_path().'的權限是否有寫入的權限,或是該伺服器有啟用open_basedir保護而無法判斷',
);
if(extension_loaded('session')){
	function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}

	if(is_session_started() === FALSE) session_start();
	$tmp['status'] = file_exists(session_save_path().'/sess_'.session_id());
}
$result[] = $tmp;

if(function_exists('apache_get_modules')){ //伺服器上用Apache 才檢查

	$tmp = array();
	$tmp = array(
		'name' => 'Apache Rewrite 模組檢查',
		'value' => '&nbsp;',
		'status' => false,
		'description' => '網頁伺服器尚未載入Rewrite模組，請至http.conf或相關conf檔案做啟用動作;或是該伺服器無法偵測',
	);
	if(in_array('mod_rewrite', apache_get_modules())){
		$tmp['status'] = true;
	}
	$result[] = $tmp;


	$tmp = array();
	$tmp = array(
		'name' => 'Apache Rewrite 功能檢查',
		'value' => '&nbsp;',
		'status' => false,
		'description' => '該網站未啟用設定Rewrite功能，請將該網站設定加入 AllowOverride All  ',
	);
	if(in_array('mod_rewrite', apache_get_modules())){
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$parent_dir.'/rewrite/a.html';
		// $url = 'http://'.$_SERVER['HTTP_HOST'].'/ftp_connect_v2/install/rewrite/a.html'; // 測試中的測試環境
		$aaa = file_get_contents($url);
		if($aaa === false or $aaa == ''){
			$aaa = false;
		}
		$tmp['status'] = trim($aaa);
	}
	$result[] = $tmp;

}


$tmp = array();
$tmp = array(
	'name' => 'PHP GD函式 模組檢查',
	'value' => '&nbsp;',
	'status' => false,
	'description' =>'網頁伺服器尚未載入GD模組，請至http.conf或相關conf檔案做啟用動作',
);
if (extension_loaded('gd') && function_exists('gd_info')) {
	$tmp['status'] = true;
}
$result[] = $tmp;


$tmp = array();
$tmp = array(
	'name' => 'PHP CURL函式 模組檢查',
	'value' => '&nbsp;',
	'status' => false,
	'description' =>'網頁伺服器尚未載入CURL模組，請至http.conf或相關conf檔案做啟用動作',
);
if (function_exists('curl_version')) {
	$tmp['status'] = true;
	$versions = curl_version();
	if($versions and isset($versions['version'])){
		$tmp['value'] = $versions['version'];
	}
}
$result[] = $tmp;

if($php_version <=5.6){
	$tmp = array();
	$tmp = array(
		'name' => 'PHP mysql 函式 模組檢查',
		'value' => '&nbsp;',
		'status' => false,
		'description' =>'網頁伺服器尚未載入mysql模組，請至http.conf或相關conf檔案做啟用動作',
	);
	if (function_exists('mysql_connect')) {
		$tmp['status'] = true;
	}
	$result[] = $tmp;
}


$tmp = array();
$tmp = array(
	'name' => 'PHP mysqli 函式 模組檢查',
	'value' => '&nbsp;',
	'status' => false,
	'description' =>'網頁伺服器尚未載入mysqli模組，請至http.conf或相關conf檔案做啟用動作',
);
if(function_exists('mysqli_connect')){
	$tmp['status'] = true;
}
$result[] = $tmp;


function is_writable_r($dir) {
	if (is_dir($dir)) {
		if(is_writable($dir)){
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (!is_writable_r($dir."/".$object)) return false;
					else continue;
				}
			}   
			return true;   
		}else{
			return false;
		}

	}else if(file_exists($dir)){
		return (is_writable($dir));

	}
}
$dirs = array(
	'../_i/web/runtime',
	'../_i/backend/runtime',
	'../_i/cache',
	'../_i/cache2',
	'../_i/assets',
	'../_i/kcfinder/upload',
	'../upload',
);
foreach($dirs as $dir){
	if(!file_exists($dir)){
		continue;
	}
	$tmp = array();
	$tmp = array(
		'name' => '資料夾寫入權限檢查： '.$dir,
		'value' => '&nbsp;',
		'status' => false,
		'description' =>'該資料夾未有寫入權限，請將該資料夾設定有寫入權限',
	);
	if(is_writable_r($dir)){
		$tmp['status'] = true;
	}
	$result[] = $tmp;
}


if(file_exists('../_i/config/domain.php')){
	include '../_i/config/domain.php';
	if(isset($hosts_app) and count($hosts_app) > 0){
		$tmp = array();
		$tmp = array(
			'name' => '路徑的檢查',
			'value' => '&nbsp;',
			'status' => false,
			'description' =>'網站絕對路徑設定錯誤，請至 _i/config/domain.php 修改',
		);

		$current = str_replace('/'.$parent_dir, '', __DIR__);
		$current = str_replace('\\'.$parent_dir, '', __DIR__);
		$current = str_replace('/install','',$current);
		foreach($hosts_app as $k => $v){
			if(isset($v['document_root']) and $v['document_root'] == $current){
				$tmp['status'] = true;				
				break;
			}else{
				$tmp['description'] .= ' <br/> 目前$hosts_app['.$k.']路徑為'.$v['document_root'].' , 應為'. $current;
			}
		}

		$result[] = $tmp;
	}
}


if(file_exists('../include/public_setting.php')){
	include '../include/public_setting.php';
	// $Setting_Upload_BasePath
	if(isset($Setting_Upload_BasePath) and $Setting_Upload_BasePath != ''){
		$tmp = array();
		$tmp = array(
			'name' => '路徑的檢查',
			'value' => '&nbsp;',
			'status' => false,
			'description' =>'網站絕對路徑設定錯誤，請至 include/public_setting.php 修改',
		);

		$current = str_replace('/'.$parent_dir, '', __DIR__);
		$current = str_replace('\\'.$parent_dir, '', __DIR__);
		$document_root = str_replace('/upload/', '', $Setting_Upload_BasePath);
		if($document_root == $current){
			$tmp['status'] = true;
		}else{
			$tmp['description'] .= ' <br/> 目前路徑為'.$document_root.' , 應為'. $current;
		}

		$result[] = $tmp;
	}
}

// var_dump($result);

?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>百邇來 環境檢查系統</title>
		<?php // include('common/head.php');?>
		<style>
		/*nomalize*/
		html {line-height: 1.15; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; } body {margin: 0; } article, aside, footer, header, nav, section {display: block; } h1 {font-size: 2em; margin: 0.67em 0; } figcaption, figure, main {display: block; } figure {margin: 1em 40px; } hr {box-sizing: content-box; height: 0; overflow: visible; } pre {font-family: monospace, monospace; font-size: 1em; } a {background-color: transparent; -webkit-text-decoration-skip: objects; } abbr[title] {border-bottom: none; text-decoration: underline; text-decoration: underline dotted; } b, strong {font-weight: inherit; } b, strong {font-weight: bolder; } code, kbd, samp {font-family: monospace, monospace; font-size: 1em; } dfn {font-style: italic; } mark {background-color: #ff0; color: #000; } small {font-size: 80%; } sub, sup {font-size: 75%; line-height: 0; position: relative; vertical-align: baseline; } sub {bottom: -0.25em; } sup {top: -0.5em; } audio, video {display: inline-block; } audio:not([controls]) {display: none; height: 0; } img {border-style: none; } svg:not(:root) {overflow: hidden; } button, input, optgroup, select, textarea {font-family: sans-serif; font-size: 100%; line-height: 1.15; margin: 0; } button, input {overflow: visible; } button, select {text-transform: none; } button, html [type="button"], [type="reset"], [type="submit"] {-webkit-appearance: button; } button::-moz-focus-inner, [type="button"]::-moz-focus-inner, [type="reset"]::-moz-focus-inner, [type="submit"]::-moz-focus-inner {border-style: none; padding: 0; } button:-moz-focusring, [type="button"]:-moz-focusring, [type="reset"]:-moz-focusring, [type="submit"]:-moz-focusring {outline: 1px dotted ButtonText; } fieldset {padding: 0.35em 0.75em 0.625em; } legend {box-sizing: border-box; color: inherit; display: table; max-width: 100%; padding: 0; white-space: normal; } progress {display: inline-block; vertical-align: baseline; } textarea {overflow: auto; } [type="checkbox"], [type="radio"] {box-sizing: border-box; padding: 0; } [type="number"]::-webkit-inner-spin-button, [type="number"]::-webkit-outer-spin-button {height: auto; } [type="search"] {-webkit-appearance: textfield; outline-offset: -2px; } [type="search"]::-webkit-search-cancel-button, [type="search"]::-webkit-search-decoration {-webkit-appearance: none; } ::-webkit-file-upload-button {-webkit-appearance: button; font: inherit; } details, menu {display: block; } summary {display: list-item; } canvas {display: inline-block; } template {display: none; } [hidden] {display: none; } *{box-sizing: border-box; }
		/*style*/
		.container{width:100%;margin:0 auto;padding-left:15px;padding-right:15px}@media screen and (min-width:768px){.container{width:750px}}@media screen and (min-width:992px){.container{width:970px}}@media screen and (min-width:1200px){.container{width:1170px}}body{font-family:'Microsoft JhengHei', '微軟正黑體' , 'Arial' ,'Helvetica', sans-serif , serif;overflow-x:hidden;min-height:100vh}.main{padding-bottom:50px}.wrapper{background-image:-webkit-gradient(linear, left bottom, left top, from(#f08d1d), to(#f6bc2f));background-image:-webkit-linear-gradient(bottom, #f08d1d 0%, #f6bc2f 100%);background-image:-o-linear-gradient(bottom, #f08d1d 0%, #f6bc2f 100%);background-image:linear-gradient(0deg, #f08d1d 0%, #f6bc2f 100%);background-size:cover;background-repeat:no-repeat;width:100%}.text-center{text-align:center}.footerInfo{padding-top:30px;padding-bottom:30px;padding-left:15px;padding-right:15px;text-align:center;font-size:18px;color:#FFF;line-height:1.5em;background-color:rgba(0, 0, 0, 0.3)}.copyright{padding-left:15px;padding-right:15px;padding-top:10px;padding-bottom:10px;text-align:center;color:#FFF;background-color:#333}.pageTitle{font-size:32px;color:#333;font-weight:900;position:relative;padding-bottom:20px;margin-bottom:40px;margin-top:0;padding-top:0.67em}.pageTitle:before{content:'';width:150px;height:3px;display:block;background-color:#F08D1D;position:absolute;bottom:0;left:50%;-webkit-transform:translate(-50%, 0);-ms-transform:translate(-50%, 0);transform:translate(-50%, 0);-webkit-box-shadow:2px 2px 2px 0px rgba(0, 0, 0, 0.3);box-shadow:2px 2px 2px 0px rgba(0, 0, 0, 0.3)}.pageTitle.white{color:#FFF}.pageTitle.white:before{background-color:#FFF}.pageTitle span{display:inline-block;padding:0 15px;position:relative;text-shadow:2px 2px 4px rgba(0, 0, 0, 0.5)}.checkList{list-style:none;padding-left:0}.checkList__Item{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-bottom:60px;position:relative}.checkList__Title{padding:10px 15px;margin:0}@media screen and (min-width:768px){.checkList__Title{text-align:right}}.checkList__Item-L,.checkList__Item-R{display:block;position:relative;-webkit-box-shadow:4px 0 4px rgba(0, 0, 0, 0.5);box-shadow:4px 0 4px rgba(0, 0, 0, 0.5)}.checkList__Item-L{width:100%;z-index:4}@media screen and (min-width:768px){.checkList__Item-L{width:50%}}@media screen and (min-width:992px){.checkList__Item-L{width:40%}}@media screen and (min-width:1200px){.checkList__Item-L{width:30%}}.checkList__Item-R{width:100%;z-index:3}@media screen and (min-width:768px){.checkList__Item-R{width:50%}}@media screen and (min-width:992px){.checkList__Item-R{width:60%}}@media screen and (min-width:1200px){.checkList__Item-R{width:70%}}.checkList__Item-L{background-color:#0ac5ff;border-radius:10px 10px 0 0}@media screen and (min-width:768px){.checkList__Item-L{border-radius:10px 0 0 10px}}.checkList__Item-R{border-radius:0 0px 10px 10px}@media screen and (min-width:768px){.checkList__Item-R{border-radius:0 10px 10px 0}}.checkList__Item-R__Area{position:relative;height:100%}.checkList__Desc{margin:0;display:block;padding:10px 45px 10px 15px;background-color:#FFF;height:100%;font-size:1.5em;border-radius:0 0 10px 10px}@media screen and (min-width:768px){.checkList__Desc{border-radius:0 10px 10px 0}}.checkList__status{position:absolute;right:15px;bottom:15px}.checkList__status .icon{width:20px;height:20px;display:block}.checkList__status .icon:before{content:'';width:100%;height:100%;border-radius:50%;display:block;background-color:#49db42;font-size:24px;-webkit-box-shadow:1px 1px 2px 0 rgba(0, 0, 0, 0.5), -2px -2px 5px 0 rgba(0, 0, 0, 0.5) inset, 2px 2px 5px 0 rgba(255, 255, 255, 0.5) inset;box-shadow:1px 1px 2px 0 rgba(0, 0, 0, 0.5), -2px -2px 5px 0 rgba(0, 0, 0, 0.5) inset, 2px 2px 5px 0 rgba(255, 255, 255, 0.5) inset}.checkList__status.wrong .icon:before{background-color:#e92314}.checkList__solution{width:100%;position:relative;padding:0 10px}.checkList__solutionArea{z-index:2;overflow:hidden;position:relative;background-color:#FFF;display:block;margin:0 auto;width:100%;padding:15px;border-radius:0 0 10px 10px;-webkit-box-shadow:2px 2px 2px 0px rgba(0, 0, 0, 0.5);box-shadow:2px 2px 2px 0px rgba(0, 0, 0, 0.5);-webkit-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}.checkList__solutionBtn{display:inline-block;cursor:pointer;z-index:1;position:absolute;top:100%;right:15px;background-color:#F08D1D;padding:10px 20px;border-radius:0 0 10px 10px;color:#FFF;-webkit-box-shadow:1px 2px 4px 0px rgba(0, 0, 0, 0.8);box-shadow:1px 2px 4px 0px rgba(0, 0, 0, 0.8)}.checkList__solutionBtn:hover{background-color:#f79d36}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<div class="container">
					<h1 class="pageTitle text-center white">
						<span>百邇來 環境檢查系統</span>
					</h1>
					<ul class="checkList">
						<?php if($result):?>
							<?php foreach($result as $k => $v):?>
								<li class="checkList__Item">
									<div class="checkList__Item-L">
										<h2 class="checkList__Title"><?php echo $v['name']?></h2>
									</div>
									<div class="checkList__Item-R">
										<div class="checkList__Item-R__Area">
											<p class="checkList__Desc"><?php echo $v['value']?></p>
											<span class="checkList__status <?php if($v['status'] == false):?>wrong<?php endif?> "><span class="icon"></span></span>
										</div>
									</div>
									<?php if(isset($v['description']) and $v['description'] != '' && $v['status']==false):?>
										<div class="checkList__solution">
											<div class="checkList__solutionArea">
												<div class="editorBlock">
													<?php echo nl2br($v['description'])?>
												</div>
											</div>
											<a class="checkList__solutionBtn">Solution</a>
										</div>
									<?php endif?>
								</li>
							<?php endforeach?>
						<?php endif?>

<?php if(0):?>
						<li class="checkList__Item">
							<div class="checkList__Item-L">
								<h2 class="checkList__Title">檢查名稱項目</h2>
							</div>
							<div class="checkList__Item-R">
								<div class="checkList__Item-R__Area">
									<p class="checkList__Desc">檢測結果</p>
									<span class="checkList__status wrong"><span class="icon"></span></span>
								</div>
							</div>
							<div class="checkList__solution">
								<div class="checkList__solutionArea">
									<div class="editorBlock">
										<p>1231323</p>
									</div>
								</div>
								<a class="checkList__solutionBtn">Solution</a>
							</div>
						</li>
						<li class="checkList__Item">
							<div class="checkList__Item-L">
								<h2 class="checkList__Title">檢查名稱項目</h2>
							</div>
							<div class="checkList__Item-R">
								<div class="checkList__Item-R__Area">
									<p class="checkList__Desc">檢測結果</p>
									<span class="checkList__status wrong"><span class="icon"></span></span>
								</div>
							</div>
							<div class="checkList__solution">
								<div class="checkList__solutionArea">
									<div class="editorBlock">
										<p>1231323</p>
									</div>
								</div>
								<a class="checkList__solutionBtn">Solution</a>
							</div>
						</li>
						<li class="checkList__Item">
							<div class="checkList__Item-L">
								<h2 class="checkList__Title">檢查名稱項目</h2>
							</div>
							<div class="checkList__Item-R">
								<div class="checkList__Item-R__Area">
									<p class="checkList__Desc">檢測結果</p>
									<span class="checkList__status wrong"><span class="icon"></span></span>
								</div>
							</div>
							<div class="checkList__solution">
								<div class="checkList__solutionArea">
									<div class="editorBlock">
										<p>1231323<br>2131112<br> 151</p>
									</div>
								</div>
								<a class="checkList__solutionBtn">Solution</a>
							</div>
						</li>
<?php endif?>
					</ul>
				</div>
			</div>
			<div class="footer">
				<div class="footerInfo">
						如果有任何疑問，請來電洽詢<br>
						台中總公司：04-2317-8388 
				</div>
				<div class="copyright">版權所有 © BuyersLine百邇來網頁設計公司、網路行銷公司 All Rights Reserved</div>
			</div>
		</div>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
			    var elements = document.getElementsByClassName('checkList__solutionArea');
			    var elementsArray = new Array();

			    var elementsLength = elements.length;
			    for (var i = 0 ;i < elementsLength ; i++) {
			    	elementsArray[i] = {
						index       : i,
						target      : elements[i],
						button      : elements[i].nextElementSibling,
						targetHeight: elements[i].offsetHeight,
						active      : false,
			    	};
			    	solutionUp(elementsArray[i]);
			    }
			    for (var i = 0 ;i < elementsArray.length ; i++) {
			    	toggleBtn( elementsArray[i], elementsArray);	
			    }
			});

			function toggleBtn (obj,objAll){
				obj.button.addEventListener('click',function(){
					var nowIndex = obj.index;
					if ( obj.active == false ) {
						for (var i = 0; i < objAll.length ; i++) {
							if (i != nowIndex){
								objAll[i].active = false;
								solutionUp(objAll[i]);
							} else {
								obj.active = true;
								objAll[i].active = true;
							}
						}
						solutionDown(obj);
					} else {
						obj.active = false;
						objAll[nowIndex].active = false; 
						solutionUp(obj);
					}
				})
			}
			function solutionUp(obj){
				obj.target.style.height = '0px';
				obj.target.style.opacity = 0;
				obj.target.style.paddingTop = 0;
				obj.target.style.paddingBottom = 0;
				obj.target.style.visibility = 'hidden';
			}
			function solutionDown(obj){	
				obj.target.style.visibility = 'visible';
				obj.target.style.height = obj.targetHeight+'px';
				obj.target.style.opacity = 1;
				obj.target.style.paddingTop = '';
				obj.target.style.paddingBottom = '';
			}
		</script>
	</body>
</html>
