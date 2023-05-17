<?php

/*
 * 因為遇到有人在利用contactus、inquiry的表單，亂發垃圾信，所以寫了這個機制
 * 但是這個機制會把adsl動態IP的用戶也擋掉，所以還需要修改，或許是搭配其它的條件，來組合判斷
 * 或者是把連線的IP寫到資料庫，然後到多少的底限就無限期擋掉之類的
 */

if(0){
	/*
	 * 保護機制
	 */

	function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']) and $_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) and $_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']) and $_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']) and $_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']) and $_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']) and $_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	function get_client_ip2() {
		$ip = '';
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else
			$ip = "";
		return $ip;
	} 

	// 先檢查IP
	function hasblacklist($ip){
		//$dnsbl_lookup=array("dnsbl-1.uceprotect.net","dnsbl-2.uceprotect.net","dnsbl-3.uceprotect.net","dnsbl.dronebl.org","dnsbl.sorbs.net","zen.spamhaus.org"); // Add your preferred list of DNSBL's
		$dnsbl_lookup=array("zen.spamhaus.org"); // Add your preferred list of DNSBL's
		if($ip){
			$reverse_ip=implode(".",array_reverse(explode(".",$ip)));
			foreach($dnsbl_lookup as $host){
				if(checkdnsrr($reverse_ip.".".$host.".","A")){
					return true;
					//$listed.=$reverse_ip.'.'.$host.' <font color="red">Listed('.$host.')</font><br />';
				}
			}
		}
		return false;
		//if($listed){
		//	echo $listed;
		//}else{
		//	echo '"A" record was not found';
		//}
	}

	$clientip = get_client_ip2();

	if($clientip == ''){
		header("HTTP/1.0 404 Not Found");
		die;
	}

	if(hasblacklist($clientip) and !preg_match('/^(118.170.211.236)$/', $clientip)){
		header("HTTP/1.0 404 Not Found");
		die;
	}
}
