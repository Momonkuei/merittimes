<?php

// include 'layoutv3/init.php';

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

session_start();

/*
	Check For A Spam IP Address With PHP
	http://www.beliefmedia.com/spam-ip-address
	2017-09-15 中午12點，李哥說放這個東西進來
*/
// if(!function_exists('beliefmedia_blacklist')){
// function beliefmedia_blacklist($ip, $p = '10', $array = true) {
// 
// 	$listed = true; 
// 	$dnsbl_servers = array(
// 		"dnsbl-1.uceprotect.net",
// 		"dnsbl-2.uceprotect.net",
// 		"dnsbl-3.uceprotect.net", 
// 		"dnsbl.dronebl.org",
// 		"dnsbl.sorbs.net", 
// 		"zen.spamhaus.org",
// 		'cbl.abuseat.org',
// 	);
// 	$lookups = count($dnsbl_servers); 
// 	$total = 0; 
// 
// 	if($ip) {
// 		$reverse_ip = implode(".", array_reverse(explode(".", $ip)));
// 		foreach($dnsbl_servers as $host) {
// 			if(checkdnsrr($reverse_ip.".".$host.".", "A")) {
// 				$result["$host"] = 1; 
// 				$total++;
// 			} else {
// 				$result["$host"] = 0; 
// 			}
// 		}
// 	}
// 
// 	if ($array) { 
// 		return $result;
// 	} else {
// 		$percent = round(($total / $lookups) * 100);
// 		return ($percent >= $p) ? true : false;
// 	}
// }
// }
// 
// // $ip = '46.161.9.3';
// // $ip = '74.98.53.123';
// // $ip = '125.227.85.150';
// if(beliefmedia_blacklist($ip, 10, false)){
// 	Yii::app()->session['captcha'] = '';
// 	header("HTTP/1.0 404 Not Found");
// 	die;
// }

require_once '_i/securimage/securimage.php';
$img = new Securimage();
$img->image_width = 96;
$img->image_height = 45;
$img->charset = '0123456789';
$img->code_length = 4;
// $img->captcha_type = Securimage::SI_CAPTCHA_MATHEMATIC;
// $img->perturbation = 0.75; // default
// $img->num_lines   = 2;
$img->noise_level = 0;
if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);
$img->show();
die;

/*
 * 底下的己被破解 2017-09-15
 */

$im = @ImageCreate (96, 45) or die ('Cannot Initialize new GD image stream'); 
//$bgCol = array(
//	array('R'=>250, 'G'=>250, 'B'=>250),
//	array('R'=>251, 'G'=>251, 'B'=>251),
//	array('R'=>252, 'G'=>252, 'B'=>252),
//	array('R'=>253, 'G'=>253, 'B'=>253),
//	array('R'=>254, 'G'=>254, 'B'=>254)
//);
//$n = round(rand(0, (count($bgCol)-1)));
//$background_color = ImageColorAllocate ($im, $bgCol[$n]['R'], $bgCol[$n]['G'], $bgCol[$n]['B']);
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
	//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'oneway.ttf',
	//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'arcade_r.ttf',
	//BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'colourmepurple.ttf',
	_BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'haldanor.ttf',
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

Yii::app()->session['captcha'] = $SCode;

// Yii::app()->session->open();
// echo $_SESSION['captcha'];
// die;

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: image/png');
imagepng ($im);
imagedestroy ($im);
exit();
