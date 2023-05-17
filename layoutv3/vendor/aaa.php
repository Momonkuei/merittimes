<?php

include 'autoload.php';

use nguyenanhung\CodeIgniterDB as CI;

$db_data = array(
	'dsn'	=> '',
	'hostname' => '192.168.0.200',
	'username' => 'environment_user',
	'password' => 'Ps6RRJmYDXXQYmuE',
	'database' => 'rwd_v3',
	'dbdriver' => 'mysql',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$rDb = mysql_connect($db_data['hostname'], $db_data['username'], $db_data['password']);

$cidb =& CI\DB($db_data, null, $rDb);

$rows = $cidb->get('html')->result_array();
var_dump($rows);
