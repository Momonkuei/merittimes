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

//刪除特定信箱結尾
//$query = "DELETE FROM contactus_web WHERE email LIKE '%.ru'";
$query = "DELETE FROM contact WHERE email LIKE '%.ru'";
$this->cidb->query($query);


//刪除公司名稱為 google 的資料
$query = "DELETE FROM contact WHERE company_name LIKE 'google'";
$this->cidb->query($query);

//刪除有關鍵字的留言
if(isset($tmp) && count($tmp) >0){
	foreach ($tmp as $key => $value) {
		//$query = "DELETE FROM contactus_web WHERE detail LIKE '%".$value."%'";
		$query = "DELETE FROM contact WHERE detail LIKE '%".$value."%' or company_name LIKE '%".$value."%' or addr LIKE '%".$value."%'";
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
	if(isset($_POST["company_name"]) && $_POST["company_name"]!=''){
		if(stristr($_POST["company_name"],'google')){ 
			die;
		}
		foreach ($tmp as $key => $value) {
			if(stristr($_POST["company_name"],$value)){
				die;
			}
		}
	}
	if(isset($_POST["addr"]) && $_POST["addr"]!=''){
		foreach ($tmp as $key => $value) {
			if(stristr($_POST["addr"],$value)){
				die;
			}
		}
	}
}

//阻擋特定信箱送出
if(isset($_POST["email"]) && $_POST["email"]!=''){
	if(preg_match("/.ru$/",$_POST["email"])){
		die;
	}
}