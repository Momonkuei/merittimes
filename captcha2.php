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
	// BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'oneway.ttf',
	// BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'arcade_r.ttf',
	// BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'colourmepurple.ttf',
	// _BASEPATH.DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.'haldanor.ttf',
	__DIR__.'/_i/fonts/haldanor.ttf',
);
// 旋轉角度
$angel_set = array(0,2,4,6,8,10,12,14,16,18,20,-2,-4,-6,-8,-10,-12,-14,-16,-18,-20);
$SCode = '';
for($i=0; $i<4; $i++) {
	//srand((double)microtime()*1000000); //PHP 4.2以上就不需要
	$rndFont = (rand() % count($font_file));
	//srand((double)microtime()*1000000); //PHP 4.2以上就不需要
	$dd = (rand() % strlen($CheckStr));
	//srand((double)microtime()*1000000); //PHP 4.2以上就不需要
	$aa = (rand() % count($angel_set));
	$ckChar = substr($CheckStr, $dd, 1);
	$SCode .= $ckChar;
	$N_color = (rand() % count($num_color));
	// 字型
	//ImageTTFText ($im, 18, $angel_set[$aa], 2+($i*rand(16, 18)), 20, $num_color[$N_color], $font_file[$rndFont], $ckChar); 
	ImageTTFText ($im, 20, $angel_set[$aa], 8+($i*rand(20, 23)), 22, $num_color[$N_color], $font_file[$rndFont], $ckChar);
}

// Yii::app()->session['captcha2'] = $SCode;
$_SESSION['captcha2'] = $SCode;

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: image/png');
imagepng ($im);
imagedestroy ($im);
exit();

//    $page = array(
//    	array(
//    		'file' => '$layout_main',
//    		'hole' => array(
//    			array(
//    				'hole' => array(
//    					array(
//    						'file' => 'sub_page_title',
//    						'hole' => array(
//    							array('file' => 'breadcrumb'),
//    						),
//    					),
//    					array('file' => 'about/type1_1'),
//    				),
//    			),
//    		),
//    	),
//    );
//    
//    // 挑選所需要的資料
//    $page_source = array(
//    	'webmenu-v1',
//    	'company-page_title',
//    	'company-breadcrumb',
//    	'company-general',
//    );
//    
//    // 共用的程式，記得這類的東西要放在pre_render的上面，由其是有指定page_source的情況
//    include 'source/start.php';
//    
//    include 'layoutv3/pre_render.php';
//    //include 'layoutv3/print_struct.php';
//    
//    
//    include 'layoutv3/render.php';
