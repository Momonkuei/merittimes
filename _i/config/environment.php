<?php

$tmp = explode('.', $_SERVER['HTTP_HOST']);

if(($tmp[1] == 'web' or $tmp[1] == 'web2') and $tmp[2] == 'buyersline'){
	// 開發
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	define('ENVIRONMENT', 'development');
	$is_site_production = false; // 給跟目錄的其它分離程式所使用的，目前還沒有人用，所以這裡的做會依照_i/config/shop.php裡面的is_site_product來決定
} else {
	// 線上
	defined('YII_DEBUG') or define('YII_DEBUG',false);
	define('ENVIRONMENT', 'production');
	error_reporting(0);
	$is_site_production = true;
}

// lota
if(!isset($web_folder)){
    $web_folder = '';
}

// LayoutV3平面化，記得shop.php的設定檔那裡也要加
$need_flattened = false;

if(($tmp[1] == 'web' or $tmp[1] == 'web2' or $tmp[1] == 'show') and $tmp[2] == 'buyersline'){
	
	$folder = $tmp[0];

	define('BACKEND_DOMAIN', 'https://'.$folder.'.'.$tmp[1].'.buyersline.com.tw');   // 後台網址會判斷vir_path_c (O)
	define('FRONTEND_DOMAIN','https://'.$folder.'.'.$tmp[1].'.buyersline.com.tw');   // 前台不支援vir_path_c     (X)

	// if($tmp[1] != 'show'){
	// 	define('BACKEND_ASSETSURL_DOMAIN', 'https://889.'.$tmp[1].'.buyersline.com.tw'); // 通常是889的內部網址
	// }else{
	// 	define('BACKEND_ASSETSURL_DOMAIN', 'https://image3.buyersline.com.tw'); // 線上母體連結路徑
	// }
	define('BACKEND_ASSETSURL_DOMAIN', ''); // 線上母體連結路徑


	define('FRONTEND_FOLDER',$web_folder);//載入網站資料夾路徑 by lota

	// 200的外部IP
	define('EIP_APIV1_PUBLICKEY', '224990017745');
	define('EIP_APIV1_PRIVATEKEY', '021317730886');
	define('EIP_APIV1_DOMAIN', 'http://crm2.buyersline.com.tw');
} else {
	define('BACKEND_DOMAIN', 'http://demo.merit-times.com.tw');  // 後台網址會判斷vir_path_c (O)
	define('FRONTEND_DOMAIN', 'http://demo.merit-times.com.tw'); // 線上母體連結路徑
	define('BACKEND_ASSETSURL_DOMAIN', ''); // 線上母體連結路徑

	define('FRONTEND_FOLDER',$web_folder);//載入網站資料夾路徑 by lota

	// Server1的外部IP
	// define('EIP_APIV1_PUBLICKEY', '590471056262');
	// define('EIP_APIV1_PRIVATEKEY', '723701386439');

	// Server2的外部IP
	define('EIP_APIV1_PUBLICKEY', '002143659700');
	define('EIP_APIV1_PRIVATEKEY', '392447415084');

	define('EIP_APIV1_DOMAIN', 'http://crm2.buyersline.com.tw');
}

/*
 * 共用
 */

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

define('FRONTEND_DEFAULT_LANG', 'tw'); // 設定預設語系，當作createURL指標參考值 (*layoutv3的cig_frontend模式所使用)
define('LAYOUTV3_THEME_NAME', 'v4');//預設用V4
define('LAYOUTV4_THEME_VER', '_k01');//V4用的，Jane說要拿來當css參數用


//https://serverfault.com/questions/153092/how-do-i-enable-php-apache-request-headers-or-change-php-into-an-apache-module
//避免主機無法使用 getallheaders 的替代方案 by lota
if (!is_callable('getallheaders')) {
    # Convert a string to mixed-case on word boundaries.
    function uc_all($string) {
        $temp = preg_split('/(\W)/', str_replace("_", "-", $string), -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($temp as $key=>$word) {
            $temp[$key] = ucfirst(strtolower($word));
        }
        return join ('', $temp);
    }

    function getallheaders() {
        $headers = array();
        foreach ($_SERVER as $h => $v)
            if (preg_match('/HTTP_(.+)/', $h, $hp))
                $headers[str_replace("_", "-", uc_all($hp[1]))] = $v;
        return $headers;
    }

    function apache_request_headers() { return getallheaders(); }
}