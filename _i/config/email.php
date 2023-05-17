<?php
$tmp = explode('.', $_SERVER['HTTP_HOST']);

if(($tmp[1] == 'web' or $tmp[1] == 'web2' or $tmp[1] == 'show') and $tmp[2] == 'buyersline'){
	//如果伺服器開放localhost open relay , 那可以使用這邊設定 內部200跟server1可使用 (使用phpmailer寄信)
	define('aaa_smtp_from', '');
	define('aaa_smtp_from_name', '測試');
	define('aaa_smtp_port', '25');
	define('aaa_smtp_ssl', 'sendmail'); //這邊都是固定用 sendmail,如果要用外部寄信，則直接改server, account , password, port by lota
	define('aaa_smtp_account', '');
	define('aaa_smtp_password', '');
	define('aaa_smtp_server', '');
}else{
	//這段是給外部主機有開465port使用，如果沒有開465，請改為25
	define('aaa_smtp_from', '');
	define('aaa_smtp_from_name', '測試');
	define('aaa_smtp_port', '25'); //Serverzoo的主機 relay信件 25 port如果被封印了，就改 465 port
	define('aaa_smtp_ssl', 'sendmail'); //這邊都是固定用 sendmail,如果要用外部寄信，則直接改server, account , password, port by lota
	define('aaa_smtp_account', '');
	define('aaa_smtp_password', '');
	define('aaa_smtp_server', '');
}


//這邊是自架Server2的設定
// 沒有辦法使用open relay的話 , 就用這邊的設定 , 要記得設上有效的使用者 , server2 專用 (使用Zend mail寄信)
// define('aaa_smtp_ssl', '');
// define('aaa_smtp_from', '');//這邊已經沒作用了
// define('aaa_smtp_from_name', '');//這邊已經沒作用了
// define('aaa_smtp_port', '25');
// define('aaa_smtp_account', 'send@image3.buyersline.com.tw');
// define('aaa_smtp_password', 'buyersline888');
// define('aaa_smtp_server', 'localhost');
