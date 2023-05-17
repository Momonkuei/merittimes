<?php

header("Content-Type:text/html; charset=utf-8");
// include 'layoutv3/init.php';
include 'layoutv3/only_load_database.php';
$_POST=$_REQUEST;
if(!empty($_POST)){
    $str = "";
    foreach ($_POST as $key => $value) $str.= $key."=>".$value."||";
    $tAry=array("log"=>$str);
    $cidb->insert('log',$tAry);
}

$OrderID= $_POST['MerchantTradeNo'];
$query = $cidb->select('*')->where('order_number',$OrderID)->get('donationorder');
$result = $query->row_array();
$SqlArry = array();
if($result['total'] == $_POST['TradeAmt']){
	if($_POST["vAccount"]) {
		



		$SqlArry = array(
				"getcvscode" => $_POST["RtnCode"], //取號是否成功
				"getcvsmsg" => $_POST["RtnMsg"],
				"expiredate" => str_replace("/", "-", $_POST["ExpireDate"]),
				"tradeamt" => $_POST["TradeAmt"], //金額
				"tradedate" => str_replace("/", "-", $_POST["TradeDate"]), //訂單成立時間
				"tradeno" => $_POST["TradeNo"],//綠介編號
				"vbank_code"=> $_POST["BankCode"], 
				"vbank_account" =>$_POST["vAccount"] //繳費虛擬帳號
			);

		if(!empty($_POST["vAccount"])){
			$SqlArry['order_status'] = 0;
		}

	}
	
	if($SqlArry){
        $cidb->where('order_number', $OrderID);
        $res = $cidb->update("donationorder",$SqlArry);
        if($res == 1) {
        	echo '1|OK';  
        	
        }
    }

}



?>
