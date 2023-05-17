<?php

// 記錄所有的變數到訂單資料表
// 為了要讓各個地方呈現同樣的運算結果
// 所有的話變合併成一個陣列以後，在依據Mysql Text(65535)的欄位長度的七折，切割以及存放
// 如果是後台搜尋訂單，就把那些欄位concat以後，就like%%那個欄位就好了

$log = array(
	'physicals' => $physicals,
    'payments' => $payments,
    'payment' => $payment,
    'how_much_difference' => $how_much_difference,
    'error_logs' => $error_logs,
    //'additional_purchases' => $additional_purchases,
    'promotions' => $promotions,
    'match' => $match,
    //'member_address' => $member_address,
    //'member' => $member,
    'shipment' => $shipment,
    //'recipient' => $recipient,
	'invoice_config' => $invoice_config,
    //'invoice' => $invoice,
	'car' => $car, // 可能只會用在後台訂單內頁的列表、和資料匯出
	'session' => $_SESSION, // 為了金流的rollback而記錄的
	'calculate_logs' => $calculate_logs,
);

if(isset($additional_purchases)){
	$log['additional_purchases'] = $additional_purchases;
}

if(isset($member_address)){
	$log['member_address'] = $member_address;
}

if(isset($member)){
	$log['member'] = $member;
}

if(isset($invoice)){
	$log['invoice'] = $invoice;
}

if(isset($recipient)){
	$log['recipient'] = $recipient;
}

// 2020-05-13
unset($log['session']['cidb']);

// 第三步驟才會有的變數
if(isset($order)){
	$log['order'] = $order;
}

// 開發階段，其實也才用到5000而以(TEXT欄位是65535)，所以可以放心使用
// $log_result = G::utf8_str_split('$log='.var_export($log,true).';', intval(65535*0.7));
//上線後 有發現部份log會有切割問題 把資料表的資料表的log_1 改為 longtext 全部放到這裡去 by lota 2021-07-08
$log_result[0] = '$log='.var_export($log,true).';';

$rows = $this->db->createCommand('SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`=\''.aaa_dbname.'\' AND `TABLE_NAME`=\'shoporderform\';')->queryAll();
$log_max = 0; // 為了找出最大的log_X

if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		if(preg_match('/^log_(.*)$/', $v['COLUMN_NAME'], $matches)){
			if($matches[1] > $log_max){
				$log_max = $matches[1];
			}
		}
	}
}

//已經不切割了，所以不需檢查 by lota 2021-07-08
// $_count = count($log_result);
// if($log_max < $_count){
// 	// 系統錯誤訊息：訂單資料表的記錄欄位數量不足，請依照流水號在建立log_X的欄位
// 	$error_logs[] = array(
// 		'system_error_1',
// 		'系統錯誤1',
// 		1, // 第幾步驟
// 	);
// }

if($log_max <= 0){
	// 系統錯誤訊息：沒有權限存取資料表的欄位列表(結構哦)
	$error_logs[] = array(
		'system_error_2',
		'系統錯誤2',
		1, // 第幾步驟
	);
}


