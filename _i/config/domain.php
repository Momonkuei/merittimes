<?php
//lota備註 document_root = 放置網站的路徑，如果是放在子資料夾內，只需要最上層路徑即可 , name = $_SERVER['host_name']
$hosts_app = array(
	// 測試站
	array(
		'description' => '200測試站',
		'name' => 'XXX.web.buyersline.com.tw', 'port' => '80', 'ml_key' => '', //'aaa_dbname' => 'XXX', // 'customer_public_path' => 'XXX',
	),
	array(
		'description' => '200測試站',
		'name' => 'XXX.web.buyersline.com.tw', 'port' => '443', 'ml_key' => '', //'aaa_dbname' => 'XXX', // 'customer_public_path' => 'XXX',
	),
	array(
		'description' => '200測試站',
		'name' => '192.168.0.200', 'port' => '80', 'ml_key' => '', //'aaa_dbname' => 'XXX', // 'customer_public_path' => 'XXX',
	),
	array(
		'description' => 'PHP7.0測試站',
		'name' => 'XXX.web2.buyersline.com.tw', 'port' => '80', 'ml_key' => '', //'aaa_dbname' => 'XXX', // 'customer_public_path' => 'XXX',
	),
	array(
		'description' => '即時線上Demo',
		'name' => 'XXX.show.buyersline.com.tw', 'port' => '80', 'ml_key' => '', //'aaa_dbname' => 'XXX', // 'customer_public_path' => 'XXX',
	),
	array(
		'description' => '即時線上Demo',
		'name' => 'XXX.show.buyersline.com.tw', 'port' => '80', 'ml_key' => '', //'aaa_dbname' => 'XXX', // 'customer_public_path' => 'XXX',
	),
	array(
		'description' => 'PHP8.0測試站',
		'name' => 'XXX.web3.buyersline.com.tw', 'port' => '80', 'ml_key' => '', //'aaa_dbname' => 'XXX', // 'customer_public_path' => 'XXX',
	),
	// array(
	// 	'description' => 'Window環境',
	// 	'name' => 'www.horngenplastic.com', 'port' => '80', 'ml_key' => 'tw', 'document_root' => 'D:\xampp\www\\', //磁碟機符號要大寫 , 要用 \ 區隔 ,  最後要帶入\\
	//http://blog.fhps.tp.edu.tw/fhpsmis/?p=1023 網站資料夾最好不要放C槽 避免資料夾寫入權限無法設定 
	// ),
	// ml_key 會影響前台語系，有填代表會綁定語系
	// array(
	// 	'description' => '線上-Server3',
	// 	'name' => 'www.yourdomain.com', 'port' => '80', 'ml_key' => '', 'document_root' => '/www/web/yourdomain/public_html',
	// ),		
	// array(
	// 	'description' => '線上-Server2',
	// 	'name' => 'www.yourdomain.com', 'port' => '80', 'ml_key' => '', 'document_root' => '/var/zpanel/hostdata/zadmin/public_html/yourdomain_com',
	// ),
	// array(
	// 	'description' => '線上-Server1',
	// 	'name' => 'www.yourdomain.com', 'port' => '80', 'ml_key' => '', 'document_root' => '/home2/yourdomain/public_html',
	// ),
	
	
);

// 把XXX，替換成當下200資料夾的名稱
$tmp = explode('.', $_SERVER['HTTP_HOST']);

// 2019-11-18 李哥說可以轉到web2
if($tmp[1] == 'web'){
	$tmp[1] = 'web2';
	header('Location: http://'.implode('.', $tmp));
	die;
}

// 2018-11-08
// 要使用show的話，就把以下幾行註解掉
// 李哥下午有看過
// if($tmp[1] == 'show' and $tmp[2] == 'buyersline'){
// 	echo '404';
// 	header("HTTP/1.0 404 Not Found");
// 	die;
// }


if(($tmp[1] == 'web' or $tmp[1] == 'web2' or $tmp[1] == 'show') and $tmp[2] == 'buyersline'){
	$hosts_app[0]['name'] = $tmp[0];
	unset($tmp[0]);
	$hosts_app[0]['name'] .= '.'.implode('.', $tmp);
	//--
	$hosts_app[1]['name'] = $hosts_app[0]['name'];	

	if($tmp[1] == 'show'){
		//===
		if(stristr($hosts_app[0]['name'],':200')){
			$hosts_app[0]['port'] = '200';
		}	
		$hosts_app[0]['name'] = str_replace(':200','',$hosts_app[0]['name']);
		$hosts_app[1]['name'] = $hosts_app[0]['name'];			
	}
	
} else {
	//define('aaa_dbname', 'xxx111xxx000');
}
// var_dump($hosts_app);die;

$redirects = array(
	// 這是測試
	//'http://gisanfu.no-ip.biz/eobx/admin/' => 'http://gisanfu.no-ip.biz/eobx/_butterfly/',

	//'http://178.web.buyersline.gisanfu.idv.tw/' => 'http://178.devel.gisanfu.idv.tw/',
	//'http://192.168.0.200/chun_yao/index.php' => 'http://178.devel.gisanfu.idv.tw/',
);
