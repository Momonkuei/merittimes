<?php

$_total_money = (int)$total; //帶入要付多少錢

if(defined('FRONTEND_DOMAIN')){
	$_return_url = FRONTEND_DOMAIN . '/reply.php';
}else{
	$_return_url = 'https://ags.show.buyersline.com.tw/reply.php'; //內部測試用
}

// $MID = '8089016163'; //測試特店代碼

// $MD5M = '9HGUF00PUP5OEFT05DNYSF5AZPBADRDE'; //測試macKey

$MID = '8080389976'; //正式特店代碼

$MD5M = 'O7QXEG9QSBWPP0KMWY5ND3M650XMNJH1'; //正式macKey

// $MD5M = 'WEGSC0Q7BAJGTQYL8BV8KRQRZXH6VK0B';

if(isset($save['order_number'])){
	$_custom_id = strtoupper($save['order_number']); //英數限用大寫，不可包含 _ 
}else{
	// $_custom_id = '2021021900001';
	$_custom_id = 'ags'.time();
}


$ESUN_URL = 'https://acq.esunbank.com.tw/ACQTrans/esuncard/txnf014s';//正式環境 for PC

// $ESUN_URL = 'https://acqtest.esunbank.com.tw/ACQTrans/esuncard/txnf014s';//測試環境 for PC

$_data = '{"ONO":"'.$_custom_id.'","U":"'.$_return_url.'","MID":"'.$MID.'","TA":"'.$_total_money.'","TID":"EC000001"}';

// $_data = '{"ONO":"20160518100237","U":"https://220.128.166.170/ACQTrans/test/print.jsp","MID":"8089000016","TA":"879","TID":"EC000001"}';

// echo $_data.$MD5M;die;

// echo $_mac = sha1($_data.$MD5M);die;

// print_r(hash_algos());die;

$_mac = hash('sha256',$_data.$MD5M);


$server = $ESUN_URL;

$send = array(
 'data' => $_data,
 'mac' => $_mac,
 'ksn' => 1,
);

$szHtml =  '<!DOCTYPE html>'."\r\n";
$szHtml .= '<html>'."\r\n";
$szHtml .=     '<head>'."\r\n";
$szHtml .=         '<meta charset="utf-8">'."\r\n";
$szHtml .=     '</head>'."\r\n";
$szHtml .=     '<body>'."\r\n";
$szHtml .=         '<form id="ECPayForm" method="POST" action="'.$server.'" target="_self">'."\r\n";

if($send and !empty($send)){
  foreach($send as $k => $v){
    if($k=='data'){
        $szHtml .= ' <textarea name="'.$k.'"  style="display:none"/>'.$v.'</textarea>'."\r\n";
    }else{
      $szHtml .= ' <input type="hidden" name="'.$k.'" value="'.$v.'" />'."\r\n";
    }
  }
}
// $szHtml .=         '<input type="submit" value="ok">'."\r\n";
$szHtml .=         '</form>'."\r\n";
$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
$szHtml .=     '</body>'."\r\n";
$szHtml .= '</html>'."\r\n";
echo $szHtml ;
die;

?>
