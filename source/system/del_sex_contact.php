<?php

//讀取黑名單清單
$url = 'https://image3.buyersline.com.tw/blacklist_message.txt';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$output = curl_exec($ch);
curl_close($ch);
eval($output);


//刪除有關鍵字的留言
if(isset($tmp) && count($tmp) >0){
	foreach ($tmp as $key => $value) {
		//$query = "DELETE FROM contactus_web WHERE detail LIKE '%".$value."%'";
		$query = "DELETE FROM contact WHERE detail LIKE '%".$value."%'";
		$this->cidb->query($query);	
	}

	//阻擋特定關鍵字送出
	if(isset($_POST["detail"]) && $_POST["detail"]!=''){
		foreach ($tmp as $key => $value) {
			if(stristr($_POST["detail"],$value)){
				die;
			}
		}
	}
}

//刪除特定信箱結尾
////$query = "DELETE FROM contactus_web WHERE email LIKE '%.ru'";
//$query = "DELETE FROM contact WHERE email LIKE '%.ru'";
//$this->cidb->query($query);
//
////阻擋特定信箱送出
//if(isset($_POST["email"]) && $_POST["email"]!=''){
//	if(preg_match("/.ru$/",$_POST["email"])){
//		die;
//	}
//}

