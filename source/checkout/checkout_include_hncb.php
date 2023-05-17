<?php

// 測試卡號
// 01/25
// VISA   4595802380004202040 
// master 5242565409999108572
// jcb    3567541689991109137
// 銀聯   6223164991230014123
//
//  1 VISA  4595-8023-8000-4202 123456 040 01/2025
//  2 Mast  5242-5654-0999-9108 123456 572 01/2025
//  3 JCB   3567-5416-8999-1109 123456 137 01/2025
//  4 銀聯  6223-1649-9123-0014 123456 123 12/2033

$debug = false;

//$server = 'https://eposnt.hncb.com.tw/transaction/api-auth/';
//$AuthResURL = 'https://gisanfu.show.buyersline.com.tw/hncb/index.php';

// 如果要改測試環境，記得這兩支檔案也要跟著切換
// reply2.php
// reply.php
if(0){ // 測試環境
	$server = 'https://eposnt.hncb.com.tw/transaction/api-auth/';
	$checkID = '31a6d40f537341a5'; // 特店識別碼(這是用特店通行碼去華南的後台所帶出來的)
	$merID = '21252'; // 特店編號
	$MerchantID = '887334775405933'; // 特店代號(MerchantID)
	$TerminalID = '40765764'; // 端末代號(TerminalID)
} else { // 正式環境
	$server = 'https://eposn.hncb.com.tw/transaction/api-auth/';
	$checkID = 'yCSx73edfx259i4R'; // 特店識別碼(這是用特店通行碼去華南的後台所帶出來的)
	$merID = '6743'; // 特店編號
	$MerchantID = '008422219339101'; // 特店代號(MerchantID)
	$TerminalID = '91010001'; // 端末代號(TerminalID)
}

if(!isset($AuthResURL)){
	$AuthResURL = 'https://www.xswt.org.tw/reply.php';
}
if(!isset($lidm)){
	$lidm = $save['order_number']; // 訂單編號
}
if(!isset($purchAmt)){
	$purchAmt = (int)$total; // 交易金額
}

$checkValue = substr(md5(md5($checkID.'|'.$lidm).'|'.$MerchantID.'|'.$TerminalID.'|'.$purchAmt),-16);

$send = array(
	'merID' => $merID, // 特店編號
	'MerchantID' => $MerchantID, // 特店代號(MerchantID)
	'TerminalID' => $TerminalID, // 端末代號(TerminalID)
	'AuthResURL' => $AuthResURL,
	'lidm' => $lidm, // 訂單編號
	'txType' => 0, // 0:一般付款交易, 1:分期付款交易
	// 'encode' => 'UTF-8', // 預設UTF-8, 其它還有BIG5
	'AutoCap' => 1, // 表示刷卡授權成功後,是否由系統立即執行轉入請款檔作業(0:不轉入請款檔(預設),1:自動轉入)
	'purchAmt' => $purchAmt, // 交易金額
	'checkValue' => $checkValue, // 消費訂單驗證安全資訊
);

$szHtml = '';
if(!preg_match('/^(lightup_3)$/',$this->data['router_method'])){
$szHtml .=  '<!DOCTYPE html>';
$szHtml .= '<html>';
$szHtml .=     '<head>';
$szHtml .=         '<meta charset="utf-8">';
$szHtml .=     '</head>';
$szHtml .=     '<body>';
}

$szHtml .=         '<form id="ECPayForm" method="POST" action="'.$server.'" target="_self">';

if($send and !empty($send)){
	foreach($send as $k => $v){
$szHtml .= '            <input type="hidden" name="'.$k.'" value="'.$v.'" />';
	}
}

$szHtml .=         '</form>';
$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
if(!preg_match('/^(lightup_3)$/',$this->data['router_method'])){
$szHtml .=     '</body>';
$szHtml .= '</html>';
}
echo $szHtml ;
