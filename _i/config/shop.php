<?php

//美安 基本設定 2020-09-16
$this->data['MarketAn'] = array(
	'is_enable' => 0,
	'OFFER_ID' => 00000 , //5位數
	'Advertiser_ID' => 00000 , //5位數
	'commission' => 0.10 , //佣金 請輸入到小數點2位
);


/*
 * 基本運費(單一運費)
 *   基本 $xx
 *   滿$xx多少免運
 *
 * 級距運費
 *   基本 $xx
 *   一級 滿$xx；運費$xx元
 *   二級 滿$xx；免運費
 *
 * 冷凍(產品要可以選)
 *   再加$xx
 *
 * 冷藏(產品要可以選)
 *   再加$xx
 *
 * 外島(離島)
 *   再加$xx
 */
//2017/6/27 這邊如果後台有開啟客戶自訂基本運費的功能，那這邊就會被覆蓋 by lota
//*** 新增的運費選項目前無條件都會被覆蓋運費，要記得去source/checkout/core.php 45 去移除註解 by lota

$shipment = $this->data['shipment'] = array(
	'addr' => 'addr',
	//'func' => 'cash_on_delivery',

	'normal' => 100, // 共用
	'free' => 1000, // 免運費 (基本和級距共用)
	'price1' => 500, 'price2' => 50, // (級距) 滿一級的多少，運費就是多少，級距只有宅配支援，其它的只有一般運費而以，這是Jonathan說的
	'low_temperature' => 60, // 低溫
	'has_islands' => false, // 預設是沒有外島，如果是true，允許有離島運費，除非他把勾勾起來
	'islands' => 70, // 離島要外加的運費
);

//$shipment = $this->data['shipment'] = array();

// 物流
// 現代英文：Logistics，傳統英文：Physical Distribution
$physicals_tmp = $this->data['physicals_tmp'] = array(
	array(
	  	'name' => '一般宅配配送',
	  	'func' => 'home_delivery', // 程式名稱
	  	'addr' => 'addr', // 地址用什麼
	  	'description' => '我是設定檔內的一般宅配說明', // 就…說明

	  	// 這個跟金流有關系
	  	'has_postpay' => false, // 這個是預設值，先付還是後付，預設應該要先付款，如果是後付，那就不用跑金流了，後付通常是貨到付款
	  	'is_collection' => false, //是否代收款項 預設 不代收 by lota 2021-05-16
    	// 這裡會覆蓋原來的運費設定 //如果都註解的話，就不會蓋掉基本運費設定 by lota
	   	// 'normal' => 99,
	  	// 'free' => 1000,
	   	// 'price1' => 0, 'price2' => 0,
	   	'low_temperature' => 0,
	   	'low_temperature_free' => 0,
	   	'has_islands' => false,
	   	'no_islands' => false, // 這只是一個標示，有標示的話，就會出現離島不適用
	   	'islands' => 0,
	),
	// array(
	// 	'name' => '統一超商取貨',
	// 	'func' => 'ecpay_711_no_payment_for_pickup',
	// 	'addr' => 'ecpay_711',
	// 	'description' => '物流說明',
	// 	'has_postpay' => false,
	// 'is_collection' => false, //是否代收款項 預設 不代收 by lota 2021-05-16
		
	// 	// 這裡會覆蓋原來的運費設定 //如果都註解的話，就不會蓋掉基本運費設定 by lota
	// 	'normal' => 60,
	// 	//'free' => 1000, //打開這邊，可以設定多少錢免運 by lota
	// 	'price1' => 0, 'price2' => 0,
	// 	'low_temperature' => 0,
	// 	'has_islands' => false,
	// 	'no_islands' => false,
	// 	'islands' => 0,
	// ),
	// array(
	// 	'name' => '全家超商取貨',
	// 	'func' => 'ecpay_fami_no_payment_for_pickup',
	// 	'addr' => 'ecpay_fami',
	// 	'description' => '物流說明',
	// 	'has_postpay' => false,
	// 'is_collection' => false, //是否代收款項 預設 不代收 by lota 2021-05-16

	// 	// 這裡會覆蓋原來的運費設定 //如果都註解的話，就不會蓋掉基本運費設定 by lota
	// 	'normal' => 50,
	// 	// 'free' => 1000,  //打開這邊，可以設定多少錢免運 by lota
	// 	'price1' => 0, 'price2' => 0,
	// 	'low_temperature' => 0,
	// 	'has_islands' => false,
	// 	'no_islands' => false,
	// 	'islands' => 0,
	// ),
	//      array(
	//      	'name' => '宅配(串接綠界黑貓)',
	//      	'func' => 'home_delivery_XXX_XXX', // 程式名稱
	//      	'addr' => 'addr', // 地址用什麼
	//      	'description' => '單筆購物滿 xx 元，即享有免運費優惠', // 就…說明

	//      	// 這個跟金流有關系
	//      	'has_postpay' => false, // 這個是預設值，先付還是後付，預設應該要先付款，如果是後付，那就不用跑金流了，後付通常是貨到付款

	//      	// 這裡會覆蓋原來的運費設定 //如果都註解的話，就不會蓋掉基本運費設定 by lota
	//      	'normal' => 99,
	//      	'free' => 1000,
	//      	'price1' => 500, 'price2' => 50,
	//      	'low_temperature' => 60,
	//      	'has_islands' => true,
	//      	'no_islands' => false, // 這只是一個標示，有標示的話，就會出現離島不適用
	//      	'islands' => 70,
	//      ),
	//      array(
	//      	'name' => '宅配貨到付款',
	//      	'func' => 'cash_on_delivery',
	//      	'addr' => 'addr',
	//      	'description' => '物流說明',
	//      	'has_postpay' => true,

	//      	// 這裡會覆蓋原來的運費設定 //如果都註解的話，就不會蓋掉基本運費設定 by lota
	//      	'normal' => 100,
	//      	'free' => 1000,
	//      	'price1' => 500, 'price2' => 50,
	//      	'low_temperature' => 60,
	//      	'has_islands' => false,
	//      	'no_islands' => true,
	//      	'islands' => 0,
	//      ),
);

// 金流
$payments_tmp = $this->data['payments_tmp'] = array(
	array(
		'name' => 'ATM轉帳',
		'func' => 'atm', // 程式名稱
		'description' => '付款方式說明文字', // 就…說明

		// 是否需要通知付款的按鈕
		'payment_notice' => true,

		// 先付還是後付，先付通常是要跑金流，也就是線上付款
		// 後付的話，通常是轉帳、劃撥
		'has_postpay' => true, // ATM是後付

		'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

		'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

		'auto_step3_click_run' => false, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	),
	array(
		'name' => '貨到付款',
		'func' => 'cash_on_delivery', // 程式名稱
		'description' => '付款方式說明文字', // 就…說明

		'addr' => 'addr',

		// 是否需要通知付款的按鈕
		'payment_notice' => false,

		// 先付還是後付，先付通常是要跑金流，也就是線上付款
		// 後付的話，通常是轉帳、劃撥
		'has_postpay' => true, // ATM是後付

		'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

		'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

		'auto_step3_click_run' => false, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	),
	// array(
	// 	'name' => '郵政劃撥',
	// 	'func' => 'fund_transfer_by_post_office', // 程式名稱
	// 	'description' => '付款方式說明文字', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => true, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

	// 'auto_step3_click_run' => false, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	// ),
	// array(
	// 	'name' => '線上刷卡',
	// 	'func' => 'ecpay_credit_card', // 程式名稱
	// 	'description' => '付款方式說明文字', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => false, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => true, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

	// 'auto_step3_click_run' => true, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	// ),
	// array(
	// 	'name' => '超商代碼繳費',
	// 	'func' => 'ecpay_cvs', // 程式名稱
	// 	'description' => '付款方式說明文字', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => true, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

	// 'auto_step3_click_run' => true, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	// ),
	// array(
	// 	'name' => '超商條碼繳費',
	// 	'func' => 'ecpay_barcode', // 程式名稱
	// 	'description' => '付款方式說明文字', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => true, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

	// 'auto_step3_click_run' => true, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	// ),
	// array(
	// 	'name' => 'WEB ATM',
	// 	'func' => 'ecpay_webatm', // 程式名稱
	// 	'description' => '付款方式說明文字', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => true, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

	// 'auto_step3_click_run' => true, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	// ),
	// array(
	// 	'name' => '虛擬ATM',
	// 	'func' => 'ecpay_vatm', // 程式名稱
	// 	'description' => '付款方式說明文字', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => true, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

	// 'auto_step3_click_run' => true, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	// ),

	// paypal
	// array(
	// 	'name' => 'PayPal',
	// 	'func' => 'paypal', // 程式名稱
	// 	'description' => '', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => false, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => true, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
	// ),

	// HNCB 華南銀行
	// array(
	// 	'name' => '信用卡(華南)',
	// 	'func' => 'hncb', // 程式名稱
	// 	'description' => '', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => false, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => true, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
	// ),
	// esun 玉山
	// array(
	// 	'name' => '線上刷卡(玉山)',
	// 	'func' => 'esun_credit_card', // 程式名稱
	// 	'description' => '付款方式說明文字', // 就…說明

	// 	// 是否需要通知付款的按鈕
	// 	'payment_notice' => false,

	// 	// 先付還是後付，先付通常是要跑金流，也就是線上付款
	// 	// 後付的話，通常是轉帳、劃撥
	// 	'has_postpay' => false, // ATM是後付

	// 	'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

	// 	'need_payment_step' => true, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的

	// 'auto_step3_click_run' => true, // 如果 has_check_finish==true 或是 need_payment_step==true ，這個可以決定是否自動還是手動按鈕 step3 2020-12-20 by lota
	// ),
);

$this->data['payments_tmp2'] = array();
foreach($this->data['payments_tmp'] as $k => $v){
	$this->data['payments_tmp2'][$v['func']] = $v;
}
$payments_tmp2 = $this->data['payments_tmp2'];

// 目前還沒不會用到Ricky的這個變數，所以暫時帶空陣列進去就好了
$WebSet = $this->data['WebSet'] = array();

// 發票設定
$invoice_config = $this->data['invoice_config'] = array(
	'donate_name' => '', // 二聯式發票捐贈的單位
	'donate_code' => '', // 愛心碼
	'approval_number' => '', // 核准文號
);

$atm_config = $this->data['atm_config'] = array(
	'atm_bank_code' => '822',
	'atm_account' => '12345678',
	//'atm_expire_day' => 5,
	//'atm_expiredate' => '2020-05-21', // 會從上面的天數算出來
);

// 銀行代碼
// 為了測平面化，暫時註解起來 2018-01-31
// https://github.com/wsmwason/taiwan-bank-code
require_once _BASEPATH.'/../_i/taiwan-bank-code/TaiwanBankCode.php';
$taiwanBankCode = new TaiwanBankCode();
$bankcodeatm = $this->data['bankcodeatm'] = $taiwanBankCode->listBankCodeATM();
$bankcodeatm_tmp = array();
if($bankcodeatm){
	foreach($bankcodeatm as $k => $v){
		$bankcodeatm_tmp[$v['code']] = $v;
	}
}
$this->data['bankcodeatm_tmp'] = $bankcodeatm_tmp;

//var_dump($bankcodeatm_tmp);die;

$tmp = explode('.', $_SERVER['HTTP_HOST']);

if(($tmp[1] == 'web' or $tmp[1] == 'web2' or $tmp[1] == 'show') and $tmp[2] == 'buyersline'){
	// 開發
	$is_site_production = false; // 方便其它地方寫程式，但是environment那邊也有一個，不過那是根目錄的social在使用的

	// 開發

	// case '1':
	$Config['AllPay']['SenderName'] = '百邇來';
	$Config['AllPay']['SenderPhone'] = '0423178388';

	// C2C的逆物流在使用
	$Config['AllPay']['SenderCellPhone'] = '0910758729'; //目前用rigo的 by lota

	$Config['AllPay']['MerchantID'] = '2000132';

	// 金流和物流是一樣的
	$Config['AllPay']['HashKey'] = '5294y06JbISpM5x9';
	$Config['AllPay']['HashIV'] = 'v77hoKGq4kWxNNIS';

	// 物流 C2C
	// $Config['AllPay']['HashKey'] = 'XBERn1YOvpM9nfZc';
	// $Config['AllPay']['HashIV'] = 'h1ONHk4P4yqbl5LK';
	
	

	// 電子發票在用的
	$Config['AllPay']['InvoiceHashKey'] = 'ejCk326UnaZWKisg';
	$Config['AllPay']['InvoiceHashIV'] = 'q9jcZX8Ib9LM8wYk';

	$Config['Allpay']['URL'] = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V2'; // 金流
	$Config['Allpay']['MapURL'] = 'https://logistics-stage.ecpay.com.tw/Express/map'; // 電子地圖在用的(物流)
	$Config['Allpay']['InvoiceURL'] = 'https://einvoice-stage.ecpay.com.tw/Invoice/Issue'; // 直接開發票
	$Config['Allpay']['InvoiceDelayURL'] = 'https://einvoice-stage.ecpay.com.tw/Invoice/DelayIssue'; // 待開立發票(通常是這個)

	// case '3':
	$Config['ESun']['ESUN_URL'] = 'https://acqtest.esunbank.com.tw/acq_online/online/sale42.htm';

	// case '4':
	$Config['ESafe']['URL'] = 'https://test.esafe.com.tw/Service/Etopm.aspx';
	//紅陽測試帳號沒有 超商代收，因為串法跟24Payment相同
	$Config['ESafe']['Credit_web'] = 'S1407149044';  //測試商店代號 - 信用卡
	$Config['ESafe']['WebATM_web'] = 'S1407149051';  //測試商店代號 - WEBatm
	$Config['ESafe']['24Payment_web'] = 'S1407149069';  //測試商店代號 - 虛擬ATM
	$Config['ESafe']['24Pay_web'] = '';  //測試商店代號 - 超商代收
	$Config['ESafe']['pw'] = 'TEST54775477';  //測試交易密碼，在紅陽後台修改密碼內設定

	// case '5':
	$Config['Paypal']['URL'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

	// case '6':
	$Config['facas']['URL'] = 'https://www.focas.fisc.com.tw/FOCAS_WEBPOS/online/';
} else {
	// 線上
	$is_site_production = true; // 方便其它地方寫程式
	
	// case '1':
	// $Config['Allpay']['return_url'] = $Setting_gHostURL."include/cashflow/allpayreturn.php";
	// $Config['Allpay']['client_back_url'] = $Setting_gHostURL."order_complete.php";
	// $Config['Allpay']['CVS_back_url'] = $Setting_gHostURL."include/cashflow/allpayCVS_ret.php";
	// $CashflowType["CVS"]["GetCodeSuccessCode"]="10100073";
	// $CashflowType["CVS"]["PaySuccessCode"]="1";

	$Config['AllPay']['SenderName'] = '網站名稱？';			// 上線後，記得這裡要改
	$Config['AllPay']['SenderPhone'] = '0212345678？';		// 上線後，記得這裡要改

	// C2C的逆物流在使用
	$Config['AllPay']['SenderCellPhone'] = '0910758729';	// 上線後，記得這裡要改 目前用rigo的 by lota

	$Config['AllPay']['MerchantID'] = '3000146？';			// 上線後，記得這裡要改

	// 金流和物流是一樣的
	$Config['AllPay']['HashKey'] = 'SwaPSNh7R2bOPrEP？';	// 上線後，記得這裡要改
	$Config['AllPay']['HashIV'] = 'Cg5oKLTBe4mAguS1？';		// 上線後，記得這裡要改

	// 電子發票在用的
	$Config['AllPay']['InvoiceHashKey'] = 'ejCk326UnaZWKisg？'; // 上線後，記得這裡要改
	$Config['AllPay']['InvoiceHashIV'] = 'q9jcZX8Ib9LM8wYk？';  // 上線後，記得這裡要改

	$Config['Allpay']['URL'] = 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V2'; // 金流
	$Config['Allpay']['MapURL'] = 'https://logistics.ecpay.com.tw/Express/map'; // 電子地圖在用的(物流)
	$Config['Allpay']['InvoiceURL'] = 'https://einvoice.ecpay.com.tw/Invoice/Issue'; // 直接開發票
	$Config['Allpay']['InvoiceDelayURL'] = 'https://einvoice.ecpay.com.tw/Invoice/DelayIssue'; // 待開立發票(通常是這個)

	// case '2':
	$Config['Cat']['CreditURL'] = 'https://4128888card.com.tw/cocs/client_order_append.php';
	$Config['Cat']['CVSURL'] = 'https://www.ccat.com.tw/cvs/ap_interface.php';

	// case '3':
	$Config['ESun']['ESUN_URL'] = 'https://acq.esunbank.com.tw/acq_online/online/sale42.htm';
	// $Config['ESun']['ESUN_BACKURL']=$Setting_gHomeURL."order_complete.php";
			
	// case '4':
	// $CashflowType["CVS"]["TrandeSuccessCode"] = "00";
	$Config['ESafe']['URL'] = 'https://www.esafe.com.tw/Service/Etopm.aspx';
	$Config['ESafe']['Credit_web'] = 'S1407149044？';  //正式商店代號 - 信用卡
	$Config['ESafe']['WebATM_web'] = 'S1407149051？';  //正式商店代號 - WEBatm
	$Config['ESafe']['24Pay_web'] = '';  //正式商店代號 - 超商代收
	$Config['ESafe']['24Payment_web'] = 'S1407149069？';  //正式商店代號 - 虛擬ATM
	$Config['ESafe']['pw'] = '24286315？';  //正式交易密碼，在紅陽後台修改密碼內設定
	$Config['ESafe']['DueDate'] = 7; // 超商繳費期限，最高為180天
			
	// case '5':
	$Config['Paypal']['URL'] = 'https://www.paypal.com/cgi-bin/webscr';
	// $Config['Paypal']['RETURN']=$Setting_gHomeURL."order_complete.php";
	// $Config['Paypal']['CANCEL']=$Setting_gHomeURL."shopping_car_data.php";

	// case '6':
	$Config['facas']['URL'] = 'https://www.focas.fisc.com.tw/FOCAS_WEBPOS/online/';
	$Config['facas']['MerchantID'] = '007378952069001';	//特店代碼
	$Config['facas']['merID'] = '37895206';	//特店編號
	$Config['facas']['TerminalID'] = '90010001';	//端末機代號
	$Config['facas']['MerchantName'] = 'koreanchic';//公司名稱
	// $Config['facas']['RETURN']=$Setting_gHomeURL."order_complete.php";
}

// LayoutV3平面化，記得environment.php的設定檔那裡也要加
$need_flattened = false;

$this->data['Config'] = $Config;
$this->data['is_site_production'] = $is_site_production;
$this->data['need_flattened'] = $need_flattened;
