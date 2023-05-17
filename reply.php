<?php

use nguyenanhung\CodeIgniterDB as CI;

/*
 * Reply
 * 
 * 幕前、和幕後，大部分的處理，都會送來這裡
 * 除了店到店C2C的前台按鈕觸發(action.php)
 * 和後台訂單管理裡面的"物流訂單傳至綠界"的按鈕觸發後，回到後台的流程(client_reply.php)(可能因為參數和回到後台的動作跟reply不一樣，所以才另外寫)
 * 其於都是在這裡處理
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

// 這裡不要載入 layoutv3/init.php 因為底下會需要切換session_id

// file_put_contents('123.txt', var_export($_POST,true), FILE_APPEND);

// 信用卡幕前
//   'CheckMacValue' => '885D62B24703AC6C47EF3BD15B86AD25',
//   'MerchantID' => '3198358',
//   'MerchantTradeNo' => '200611000016',
//   'PaymentDate' => '2020/06/11 15:09:03',
//   'PaymentType' => 'Credit_CreditCard',
//   'PaymentTypeChargeFee' => '5',
//   'RtnCode' => '1',
//   'RtnMsg' => 'paid',
//   'SimulatePaid' => '0',
//   'TradeAmt' => '39',
//   'TradeDate' => '2020/06/11 15:08:15',
//   'TradeNo' => '2006111508153604',


/*
array (
  'AllPayLogisticsID' => '30830',
  'BookingNote' => '',
  'CheckMacValue' => '877F4A96DCD47C4B5CE5018945568093',
  'CVSPaymentNo' => '',
  'CVSValidationNo' => '',
  'GoodsAmount' => '650',
  'LogisticsSubType' => 'UNIMART',
  'LogisticsType' => 'CVS',
  'MerchantID' => '2000132',
  'MerchantTradeNo' => '170303000007',
  'ReceiverAddress' => '',
  'ReceiverCellPhone' => '0912345678',
  'ReceiverEmail' => 'gisanfu@gmail.com',
  'ReceiverName' => 'ggg',
  'ReceiverPhone' => '0912345678',
  'RtnCode' => '300',
  'RtnMsg' => '訂單處理中(已收到訂單資料)',
  'UpdateStatusDate' => '2017/03/03 23:16:03',
  '_from_short' => '1',
  '_session_id' => 'xxx',
  '_func' => 'ecpay_711_cash_on_delivery_server_reply',
)
 */

// 假資料測試
if(0){
	$_POST = array (
	  'MerchantID' => '3198358',
	  'MerchantTradeNo' => '200611000018',
	  'PaymentDate' => '2020/06/11 17:34:37',
	  'PaymentType' => 'Credit_CreditCard',
	  'PaymentTypeChargeFee' => '5',
	  'RtnCode' => '1',
	  'RtnMsg' => 'Succeeded',
	  'SimulatePaid' => '0',
	  'TradeAmt' => '39',
	  'TradeDate' => '2020/06/11 17:33:42',
	  'TradeNo' => '2006111733425463',
	  'CheckMacValue' => '9BD8217610424D485CEA6B427BACE0FD',
	);
}

$tmp = explode('.', $_SERVER['HTTP_HOST']);
if(($tmp[1] == 'web' or $tmp[1] == 'web2' or $tmp[1] == 'show') and $tmp[2] == 'buyersline'){
	$is_site_production = false;
} else {
	$is_site_production = true;
}

/*
 * 接收回傳值
 */

//玉山回傳值
if(isset($_GET['DATA']) && $_GET['DATA']!='' && isset($_GET['MACD']) && $_GET['MACD']!=''){

	session_start();

	//處理玉山回傳資料
	$_tmp = explode(',', $_GET['DATA']);
	$_data = array();
	foreach ($_tmp as $key => $value) {
		$_tmp1 = explode('=', $value);
		$_data[$_tmp1[0]] = $_tmp1[1];
	}

	//處理旗標
	$status = false;

	//資料庫連結	

	//$vendors_dir = _BASEPATH.'/vendors';
	$vendors_dir = 'layoutv3/vendors';
	ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

	// composer autoload 2018-12-18
	//include_once GGG_BASEPATH.'../vendor/autoload.php';
	include_once 'layoutv3/vendor/autoload.php';

	include '_i/config/db.php';

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

	if(isset($_data['RC']) && $_data['ONO']!=''){
		$row = $db->where('is_enable',1)->where('order_number',$_data['ONO'])->get('shoporderform')->row_array();

		//有訂單資料的處理
		if($row){

			if(isset($_data['RC']) && $_data['RC']=='00'){ //代表有正確回傳並刷卡成功
				$status = true;

				if($status){
					$_SESSION['save']['step3']['order_created_id'] = $row['id'];
					session_write_close();

					// 付款成功
					$update = array(
						'order_status' => 1,
					);

					$db->where('id', $row['id']);
					$db->update('shoporderform', $update); 
				}
			}
		}

		//沒訂單資料的處理
		if(!$status){
			unset($_SESSION['save']['selecxt_payment']['func']);
			unset($_SESSION['save']['step3']['go_to_finish!!']);

			$_SESSION['save']['step3']['payment_reply_alert_log'] = '刷卡失敗，請確認卡片資料，或是重新選擇付款方式';

			session_write_close();

			if($row){
				$db->where('id', $row['id']);
				$db->update('shoporderform', array('is_enable'=>0)); 
			}
		}

		header('Location: checkout_tw.php?step=3');

		die;
	}	
}

if(isset($_POST) and !empty($_POST)){

	$post = $_POST;

	$get = array();
	foreach($post as $k => $v){
		if(preg_match('/^_get_(.*)$/', $k, $matches)){
			unset($post[$k]);
			$get[$matches[1]] = $v;
		}
	}

	$status = false;

	//$vendors_dir = _BASEPATH.'/vendors';
	$vendors_dir = 'layoutv3/vendors';
	ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

	// composer autoload 2018-12-18
	//include_once GGG_BASEPATH.'../vendor/autoload.php';
	include_once 'layoutv3/vendor/autoload.php';

	include '_i/config/db.php';

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

	// debug
	// $rows = $db->get('product')->result_array();
	//file_put_contents('123.txt',var_export($rows,true),FILE_APPEND);

	// 綠界信用卡幕前
	if(!isset($post['_from_short']) and isset($post['PaymentType']) and $post['PaymentType'] == 'Credit_CreditCard'){
		session_start();

		$post['_from_short'] = '1';
		$post['_session_id'] = 'XXX';
		$post['_func'] = 'ecpay_credit_card';
		$post['_client_url'] = 'checkout_'.$_SESSION['web_ml_key'].'.php?step=3';
	}

	// 從EIP的短網址那邊過來的
	// 這個是用在200的環境
	if(
		isset($post['_from_short']) and $post['_from_short'] == '1'
		and isset($post['_session_id']) and $post['_session_id'] != ''
		and isset($post['_func'])
		//and isset($post['_params']) and count($post['_params']) > 0
	){
		if($post['_func'] == 'ecpay_invoice_delay'){

			// https://www.allpay.com.tw/Content/files/allpay_053.pdf
			/*
			 * nv_mer_id 廠商編號
			 * od_sob 商家自訂訂單編號
			 * tsr 交易單號
			 * inv_error 錯誤代碼
			 * invoicedate 發票日期
			 * invoicetime 發票時間
			 * invoicenumber 發票號碼
			 * invoicecode 發票檢查碼
			 */

			$order_number = $post['od_sob'];

			$row = $db->where('is_enable',1)->where('order_number',$order_number)->get('shoporderform')->row_array();

			if($row and $post['inv_error'] == 0){
				$update = array(
					'invoice_number' => $post["invoicenumber"],
					'invoice_date' => $post["invoicedate"],
					'invoice_time' => $post["invoicetime"],
				);
				$db->where('id', $row['id']);
				$db->update('shoporderform', $update); 
			}
			die;
		} elseif(preg_match('/^ecpay_(cvs|barcode|webatm|vatm)_server_reply$/', $post['_func'], $matches)){

			$row = $db->where('is_enable',1)->where('order_number',$post['MerchantTradeNo'])->get('shoporderform')->row_array();

			if($row){
				if($post["RtnCode"] == 1){
					// 付款成功
					$db->where('id', $row['id']);
					$db->update('shoporderform', array('order_status' => 1)); 
				}
			}
			die;
		} elseif(preg_match('/^ecpay_(credit_card|cvs|barcode|webatm|vatm)$/', $post['_func'], $matches)){
			// credit_card : 給綠界寫入刷卡是否成功
			// cvs, barcode: 取碼
			// (web|v)atm  : 取得虛擬帳號

			$func_sub = $matches[1];

			// 2021-02-09
			// 這裡本來沒有加，後來發現是漏掉的
			// 會導致線上的情況，上一次結帳後，沒有把short裡面的那筆給is_enable=0掉
			// 讓同一個session的下一次消費，會造成錯誤
			$id_number = '';
			if(isset($post['_id_number'])){
				$id_number = $post['_id_number'];
				unset($post['_id_number']);
			}

			// 幕後的，才會需要做這個動作
			if($post['_session_id'] != 'XXX'){
				session_id($post['_session_id']);
				session_start();
			}

			$row = $db->where('is_enable',1)->where('order_number',$post['MerchantTradeNo'])->get('shoporderform')->row_array();

			/* credit_card回傳內容
			array (
			  'MerchantID' => '2000132',
			  'MerchantTradeNo' => '170307000013',
			  'PaymentDate' => '2017/03/08 00:05:23',
			  'PaymentType' => 'Credit_CreditCard',
			  'PaymentTypeChargeFee' => '33',
			  'RtnCode' => '1',
			  'RtnMsg' => '交易成功',
			  'SimulatePaid' => '0',
			  'TradeAmt' => '650',
			  'TradeDate' => '2017/03/08 00:04:44',
			  'TradeNo' => '1703080004446553',
			  'CheckMacValue' => '6A29AF60144F237B0AACAA20042FD5A4',
			  '_from_short' => '1',
			  '_session_id' => 'l6g6vj2bjv2u1f0irpedso4262',
			  '_func' => 'ecpay_credit_card',
			  '_id_number' => '4c4608639364622',
			)
			 */
			if($row){
				if(
					// 這些都算成功
					($func_sub == 'credit_card' and $post["RtnCode"] == 1)
					or ($func_sub == 'cvs' and $post["RtnCode"] == 10100073)
					or ($func_sub == 'barcode' and $post["RtnCode"] == 10100073)
					or ($func_sub == 'webatm' and $post["RtnCode"] == 2)
					or ($func_sub == 'vatm' and $post["RtnCode"] == 2)
				){
					$status = true;
				}
				if($status){
					$_SESSION['save']['step3']['order_created_id'] = $row['id'];
					session_write_close();

					if($func_sub == 'credit_card'){
						// 付款成功
						$update = array(
							'order_status' => 1,
						);
					} elseif($func_sub == 'cvs'){
						$update = array(
							'ecpay_cvs_paymentno' => $post['PaymentNo'],
							'ecpay_cvs_expiredate' => $post['ExpireDate'], // yyyy/MM/dd HH:mm:ss 不用特別處理斜線，可以寫得進去
						);
					} elseif($func_sub == 'barcode'){
						$update = array(
							'ecpay_barcode_expiredate' => $post['ExpireDate'], // yyyy/MM/dd HH:mm:ss 不用特別處理斜線，可以寫得進去
							'ecpay_barcode_barcode1' => $post['Barcode1'],
							'ecpay_barcode_barcode2' => $post['Barcode2'],
							'ecpay_barcode_barcode3' => $post['Barcode3'],
						);
					} elseif($func_sub == 'webatm'){
						$update = array(
							'ecpay_webatm_bank_code' => $post['BankCode'],
							'ecpay_webatm_vaccount' => $post['vAccount'],
							'ecpay_webatm_expiredate' => $post['ExpireDate'], // yyyy/mm/dd 不用特別處理斜線，可以寫得進去
						);
					} elseif($func_sub == 'vatm'){
						$update = array(
							'ecpay_vatm_bank_code' => $post['BankCode'],
							'ecpay_vatm_vaccount' => $post['vAccount'],
							'ecpay_vatm_expiredate' => $post['ExpireDate'], // yyyy/mm/dd 不用特別處理斜線，可以寫得進去
						);
					}
					if(preg_match('/^(credit_card|cvs|barcode|webatm|vatm)$/', $func_sub)){
						$db->where('id', $row['id']);
						$db->update('shoporderform', $update); 
					}
				}
			}

			if(!$status){
				unset($_SESSION['save']['selecxt_payment']['func']);
				unset($_SESSION['save']['step3']['go_to_finish!!']);

				if($func_sub == 'credit_card'){
					$_SESSION['save']['step3']['payment_reply_alert_log'] = '刷卡失敗，請確認卡片資料，或是重新選擇付款方式';
				} elseif($func_sub == 'cvs' or $func_sub == 'barcode'){
					$_SESSION['save']['step3']['payment_reply_alert_log'] = '取號失敗';
				} elseif($func_sub == 'webatm' or $func_sub == 'vatm'){
					$_SESSION['save']['step3']['payment_reply_alert_log'] = '取得虛擬帳號失敗';
				}

				session_write_close();

				// 不能刪除訂單，要記得！，刪除會造成重刷的訂單編號重覆
				// $db->delete('shoporderform',array('id'=>$row['id'])); 

				if($row){
					$db->where('id', $row['id']);
					$db->update('shoporderform', array('is_enable'=>0)); 
				}
			}

			if($is_site_production === true){
				if($id_number != ''){
					$db->where('id_number', $id_number);
					$db->update('short', array('is_enable'=>0)); 
				}
			} else {
				// EIP的不用刪，因為它的機制是限定時間的，為了安全性，所以過了時間自動無效
			}
			// 幕前的在使用的
			if(isset($post['_client_url']) and $post['_client_url'] != ''){
				header('Location: '.$post['_client_url']);
			}
			die;
		} elseif(preg_match('/^ecpay_(711|fami)_no_payment_for_pickup$/', $post['_func'])){ // 回傳店家
			session_id($post['_session_id']);
			session_start();

			unset($post['_from_short']);
			unset($post['_session_id']);
			unset($post['_func']);

			$id_number = '';
			if(isset($post['_id_number'])){
				$id_number = $post['_id_number'];
				unset($post['_id_number']);
			}

			$_SESSION['save']['selecxt_physical']['params'] = $post;
			//$_SESSION['save']['step3']['go_to_finish!!'] = '1';

			session_write_close();

			if($is_site_production === true){
				if($id_number != ''){
					$db->where('id_number', $id_number);
					$db->update('short', array('is_enable'=>0)); 
				}
			} else {
				// EIP的不用刪，因為它的機制是限定時間的，為了安全性，所以過了時間自動無效
			}

			$status = true;
		} elseif(preg_match('/^ecpay_(711|fami)_no_payment_for_pickup_server_reply$/', $post['_func'])){ // 回傳是否有取貨了
			$post_func = $post['_func']; // 物流狀態會用到

			unset($post['_from_short']);
			unset($post['_session_id']);
			unset($post['_func']);

			$id_number = '';
			if(isset($post['_id_number'])){
				$id_number = $post['_id_number'];
				unset($post['_id_number']);
			}

			// 留存
			$update = array();
			$post_result = utf8_str_split('$log2='.var_export($post,true).';', intval(65535*0.7));
			foreach($post_result as $k => $v){
				$update['log2_'.($k+1)] = $v;
			}
			$db->where('order_number', $post['MerchantTradeNo']);
			$db->update('shoporderform', $update); 

			$row = $db->where('is_enable',1)->where('order_number',$post['MerchantTradeNo'])->get('shoporderform')->row_array();

			if($row){//更新訂單狀態
				if($post["RtnCode"] == "3022" or $post["RtnCode"] == "2067"){ //已到店取貨 付款
					$update = array(
						'order_status' => 1, // 己付款
					);
					$db->where('order_number', $post['MerchantTradeNo']);
					$db->update('shoporderform', $update); 

					// 這裡不需要判斷上線與否，因為一定是上線了，才會收到這個訊息
					if($id_number != ''){
						$db->where('id_number', $id_number);
						$db->update('short', array('is_enable'=>0)); 
					}

				}

				$rtncode_tmp = array(
					2030 => '商品已送至物流中心', 3024 => '商品已送至物流中心',
					2063 => '商品已送達門市', 2073 => '商品已送達門市', 3018 => '商品已送達門市',
					2067 => '消費者成功取件', 3022 => '商品已送達門市',
					2074 => '消費者七天未取件',  3020 => '商品已送達門市',
				);

				// 不管物流狀態如何，都會去更新資料庫的實體欄位，供後台觀看
				$update = array(
					str_replace('_server_reply', '_rtncode', $post_func) => $post['RtnCode'], // 請看pdf的34頁，常用物流狀態
					str_replace('_server_reply', '_rtncode_name', $post_func) => $rtncode_tmp[$post['RtnCode']], // 請看pdf的34頁，常用物流狀態
				);
				$db->where('order_number', $post['MerchantTradeNo']);
				$db->update('shoporderform', $update); 
			}
			die; // 不需要轉頁
		} else {
			// 其它需要透過Proxy轉傳的金流或是物流可以寫在這裡
		} // _func
	}

	// Paypal 這邊寫得很爛，等待有緣人幫忙整理 XDD ，網站一定要上SSL跟cookie samesite 設定
	// 2021-03-29 要用在打開哦
	// var_dump($post);
	//
	// if(isset($post['custom']) && $post['custom']!=''){
	// 	session_start();
	// 	$row = $db->where('is_enable',1)->where('order_number',$post['custom'])->get('shoporderform')->row_array();

	// 	if(isset($post['payer_status']) && $post['payer_status']=='VERIFIED'){

	// 		// 付款成功
	// 		$db->where('id', $row['id']);
	// 		$db->update('shoporderform', array('order_status' => 1,'pay_log'=>json_encode($post))); 

	// 		$status = true;
	// 		$_SESSION['save']['step3']['order_created_id'] = $row['id'];
	// 		$_SESSION['save']['step3']['go_to_finish!!'] = '1';
	// 		session_write_close();
	// 		$post['_back'] = '/checkout_'.$_SESSION['web_ml_key'].'.php?step=3';
	// 	}
	// }

	// Hncb 這邊寫得很爛，等待有緣人幫忙整理 XDD ，網站一定要上SSL跟cookie samesite 設定
	// 2021-03-29 要用在打開哦
	// var_dump($post);
	//
	// if(isset($post['lidm']) && $post['lidm']!=''){
	// 	@session_start();
	// 	$row = $db->where('is_enable',1)->where('order_number',$post['lidm'])->get('shoporderform')->row_array();

	// 	// 用訂單編號去把交易金額找出來
	// 	$Amt = $row['total'];

	// 	/*
	// 	 * 特店識別碼(這是用特店通行碼去華南的後台所帶出來的)
	// 	 */
	// 	if(0){ // 測試環境
	// 		$checkID = '31a6d40f537341a5'; 
	// 	} else {
	// 		$checkID = 'yCSx73edfx259i4R'; // 特店識別碼(這是用特店通行碼去華南的後台所帶出來的) for 香山
	// 	}

	// 	$result1 = md5($checkID.'|'.$post['lidm']);
	// 	$result2 = md5($result1.'|'.$post['status'].'|'.$post['errcode'].'|'.$post['authCode'].'|'.$Amt.'|'.$post['xid']);
	// 	$checkValue = substr($result2,-16);

	// 	// if($debug){
	// 	// 	file_put_contents('123.txt','result1 = MD5('.$checkID.'|'.$post['lidm'].')'."\n",FILE_APPEND);
	// 	// 	file_put_contents('123.txt','result1 = '.$result1."\n",FILE_APPEND);
	// 	// 	file_put_contents('123.txt','result2 = MD5('.$result1.'|'.$post['status'].'|'.$post['errcode'].'|'.$post['authCode'].'|'.$Amt.'|'.$post['xid'].")\n",FILE_APPEND);
	// 	// 	file_put_contents('123.txt','result2 = '.$result2."\n",FILE_APPEND);
	// 	// 	file_put_contents('123.txt','checkValue = '.$checkValue."\n",FILE_APPEND);
	// 	// }

	// 	if($post['checkValue'] == $checkValue and isset($post['status']) && $post['status'] == '0'){

	// 		// 付款成功
	// 		$db->where('id', $row['id']);
	// 		$db->update('shoporderform', array('order_status' => 1,'pay_log'=>json_encode($post))); 

	// 		$status = true;
	// 		$_SESSION['save']['step3']['order_created_id'] = $row['id'];
	// 		$_SESSION['save']['step3']['go_to_finish!!'] = '1';
	// 		session_write_close();
	// 		$post['_back'] = '/checkout_'.$_SESSION['web_ml_key'].'.php?step=3';
	// 	}
	// }

	// CTB 這邊寫得很爛，等待有緣人幫忙整理 XDD ，網站一定要上SSL跟cookie samesite 設定
	// 2021-03-29 要用在打開哦
	// var_dump($post);	
	
	// if(isset($post['URLResEnc']) && $post['URLResEnc']!='' && isset($post['merID']) && $post['merID']!=''){
	// 	include 'source/checkout/auth_mpi_mac.php';

	// 	$Key="mO6RA1mG7ROkO0VWBPUosTld";  //此為貴特店在URL 帳務管理後台登錄的壓碼字串。
	// 	$EncRes = $post['URLResEnc'];
	// 	$debug="0";
	// 	$EncArray=gendecrypt($EncRes,$Key,$debug);
	// 	//檢查用
	// 	$MACString='';		
	// 	$status = isset($EncArray['status']) ? $EncArray['status'] : "";
	// 	$errCode = isset($EncArray['errcode']) ? $EncArray['errcode'] : "";
	// 	$authCode = isset($EncArray['authcode']) ? $EncArray['authcode'] : "";
	// 	$authAmt = isset($EncArray['authamt']) ? $EncArray['authamt'] : "";
	// 	$lidm = isset($EncArray['lidm']) ? $EncArray['lidm'] : "";
	// 	$OffsetAmt = isset($EncArray['offsetamt']) ? $EncArray['offsetamt'] : "";
	// 	$OriginalAmt = isset($EncArray['originalamt']) ? $EncArray['originalamt'] : "";
	// 	$UtilizedPoint = isset($EncArray['utilizedpoint']) ? $EncArray['utilizedpoint'] : "";
	// 	$Option = isset($EncArray['numberofpay']) ? $EncArray['numberofpay'] : "";
	// 	//紅利交易時請帶入prodcode
	// 	//$Option = isset($EncArray['prodcode']) ? $EncArray['prodcode'] : "";
	// 	$Last4digitPAN = isset($EncArray['last4digitpan']) ? $EncArray['last4digitpan'] : "";
	// 	$MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$lidm,$OffsetAmt,$OriginalAmt,$UtilizedPoint,$Option,$Last4digitPAN,$Key,$debug);
	// 	// if ($MACString == $EncArray['outmac']) //then the result is right!

		
	// 	status=>10
	// 	errcode=>88
	// 	errdesc=>使用者取消交易
	// 	outmac=>24547D3A31070B254D582EE6469EE58C749A3C4DF72FBD9D
	// 	merid=>64775
	// 	authcode=>
	// 	authamt=>0
	// 	lidm=>210607000002
	// 	xid=>null
	// 	termseq=>-1
	// 	last4digitpan=>0000
	// 	cardnumber=>000000******0000
	// 	authresurl=>https://yh_food.show.buyersline.com.tw/reply.php
	// 	numberofpay=>1
				

	// 	if(isset($EncArray['lidm']) && $EncArray['lidm']!='' && isset($EncArray['merid']) && $EncArray['merid'] == $post['merID'] && isset($EncArray['outmac']) && $MACString == $EncArray['outmac']){
	// 		@session_start();
	// 		$row = $db->where('is_enable',1)->where('order_number',$post['lidm'])->get('shoporderform')->row_array();

	// 		// 用訂單編號去把交易金額找出來
	// 		$Amt = $row['total'];
	

	// 		if(isset($EncArray['status']) && $EncArray['status'] == '0'){

	// 			// 付款成功
	// 			$db->where('id', $row['id']);
	// 			$db->update('shoporderform', array('order_status' => 1,'pay_log'=>json_encode($EncArray))); 

	// 			$status = true;
	// 			$_SESSION['save']['step3']['order_created_id'] = $row['id'];
	// 			$_SESSION['save']['step3']['go_to_finish!!'] = '1';
	// 			session_write_close();
	// 			$post['_back'] = '/checkout_'.$_SESSION['web_ml_key'].'.php?step=3';
	// 		}else{
	// 			// 付款失敗
	// 			$db->where('id', $row['id']);
	// 			$db->update('shoporderform', array('order_status' => 13,'pay_log'=>json_encode($EncArray)));

	// 			$status = true;				
	// 			$post['_back'] = '/checkout_'.$_SESSION['web_ml_key'].'.php?step=1';
	// 		}
	// 	}
	// }

	if($status === true){
		// 2021-01-27 這個是綠界超商取貨C2C在使用的(幕前)
		if(isset($post['_back']) and $post['_back'] != ''){
			header('Location: '.$post['_back']);
		// } else {
		// 	header('Location: checkout.php');
		}
	}

	die;
} // POST 200環境接收回傳值

/**
* 這個檔案是從母體的G.php那邊複製過來的
*
* https://blog.longwin.com.tw/2010/01/php-utf8-str-split-word-2010/
*
* 購物站的結帳頁在使用的
*
* @version $Id: str_split.php 10381 2008-06-01 03:35:53Z pasamio $
* @package utf8
* @subpackage strings
*/
function utf8_str_split($str, $split_len = 1){
	if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
		return false;
 
	$len = mb_strlen($str, 'UTF-8');
	if ($len <= $split_len)
		return array($str);
 
	preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
 
	return $ar[0];
}
