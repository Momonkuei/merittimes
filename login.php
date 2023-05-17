<?php
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
}

include 'include/ci.php';

include '_i/config/environment.php';


if(isset($_GET['id']) and intval($_GET['id']) > 0){
	// 預留
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

	// 登入開始
	if(defined('EIP_APIV1_DOMAIN') and defined('EIP_APIV1_PUBLICKEY') and defined('EIP_APIV1_PRIVATEKEY')){
		$public_key = EIP_APIV1_PUBLICKEY;
		$private_key = EIP_APIV1_PRIVATEKEY;
		$server_ip = EIP_APIV1_DOMAIN;
		$url = 'index.php?r=api/websiteauth';

		$params = array(
			'login_account' => $user,
			'login_password' => $pass,
		);

		// 這支是客戶端

		/*
		 * 這是file_get_contents的版本
		 */
		//$postdata = http_build_query(array('get_client_code'=>''));
		//$opts = array('http' =>
		//	array(
		//		'method'  => 'POST',
		//		'header'  => 'Content-type: application/x-www-form-urlencoded',
		//		'content' => $postdata
		//	)
		//);
		//$context = stream_context_create($opts);
		//$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

		/*
		 * 這是curl的版本
		 */
		$postdata = http_build_query(array('get_client_code_2'=>''));
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => $server_ip.'/apiv1/code.php',
			CURLOPT_HEADER => 0,
			CURLOPT_VERBOSE => 0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postdata,
		);
		curl_setopt_array($ch, $options);
		$code = curl_exec($ch); 
		curl_close($ch);

		//$code = stripslashes($code);
		eval('?'.'>'.$code);

		if(isset($return) and count($return) > 0){
			$row = $return;
		}
		if($row and isset($row['id']) and $row['id'] > 0 and preg_match('/999993/', $row['login_type'] === false)){
			unset($row);
		}
	}

	$redirect_url = 'index.php';

	//這邊是給客戶的帳號密碼，請自行設定
	$gg_pass = false;
	if($user=='merittimes' && $pass=='merittimes8388'){
		$gg_pass = true;
		$row['id'] = 1;
		$row['name'] = $user;
	}

	if(($row and isset($row['id']) and $row['id'] > 0) or $gg_pass){
		$_SESSION[$session_prefix.'_id'] = $row['id'];
		$_SESSION[$session_prefix.'_name'] = $row['name'];
		$_SESSION["enter"] = true;
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
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>Demo Shop</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel='stylesheet' id='ebor-style-css'  href='login/css/main.css' type='text/css' media='all' />
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="login/js/jquery.min.1.9.1.js"></script>
    <!-- 下拉 -->
    <script type="text/javascript" src="login/js/jquery.prettyPopin.js"></script>
    <script type="text/javascript" src="login/js/pca.js"></script>
    <!--[if lt IE 9]>
      <script src="http://tlnap38wsaf2tcqwj2unvg2uq0.wpengine.netdna-cdn.com/wp-content/themes/loom/style/js/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="login/layout.css">
</head>
<body id="main">
<div id="container">
  <div id="gnb"><div id="logo"><a href="index.html"><img src="login/images/logo.jpg" alt="百邇來網頁設計" title="百邇來網頁設計" width="250" height="58" border="0"></a></div>
</div>
<div class="gnb-btn"><a href="#"><img src="login/images/menu.png" border="0" /></a></div>
<!-- 下拉鍵 -->
<div id="content2">
<div class="portfolio full-portfolio">
    <ul class="items">				
        <li class="item"><form action="" method="post" name="memberForm" id="memberForm">
        <table  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="35">帳號： <label><input name='login_account' type='text' id='LoginID' tabindex="1" /></label></td>
            <td rowspan="2" align="center" valign="bottom"><input border="0"  src="login/images/temp_e/ico_login.png" type="image" name="Image21"  /></td>
          </tr>
          <tr>
            <td height="35">密碼： <label><input name='login_password' type='password' id='Password' tabindex="2" /><input name="fNextURL" type="hidden" value="<?=$_REQUEST["fNextURL"]?>" /></label></td>
            </tr>
      </table>
        <br>
		<!-- 2022-08-02 彥呈要求拿掉 -->
        <!-- ！請輸入您在業務開發管理系統的帳密！ -->
        </form></li>	
    </ul>
</div>
</div>
<div id="footer">CMS 選版畫面 &copy; 2014 Designed by Buyersline</div>
</div>
</body>
</html>
