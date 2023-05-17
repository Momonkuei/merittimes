<?php

// 200

define('aaa_dbhost', 'localhost');
// define('aaa_dbhost', '192.168.0.200');

$tmp = explode('.', $_SERVER['HTTP_HOST']);


if(($tmp[1] == 'web' or $tmp[1] == 'web2' or $tmp[1] == 'web3' or $tmp[1] == 'show') and $tmp[2] == 'buyersline'){
	//內部
	define('aaa_dbname', $tmp[0]);
	define('aaa_dbuser', 'ordertrading_use');
	define('aaa_dbpass', '');

	// define('aaa_dbuser', 'environment_user');
	// define('aaa_dbpass', 'Ps6RRJmYDXXQYmuE');
} else {
	//線上 Server2
	define('aaa_dbname', 'zadmin_XXXX');
	define('aaa_dbuser', 'XXXXXX');
	define('aaa_dbpass', 'XXXXXX');
}

// 本地
//define('aaa_dbhost', 'localhost');
//define('aaa_dbname', 'simple');
//define('aaa_dbuser', 'root');
//define('aaa_dbpass', 'qwe123');

// 200
//define('aaa_dbhost', 'localhost');
//define('aaa_dbname', 'rwd');
//define('aaa_dbuser', 'root');
//define('aaa_dbpass', 'qwe123');

// 上線
/*
define('aaa_dbhost', 'localhost');
define('aaa_dbname', 'yungfeng');
define('aaa_dbuser', 'yungfeng');
define('aaa_dbpass', 'MHTGWtf2hsxMNV9e');
*/
