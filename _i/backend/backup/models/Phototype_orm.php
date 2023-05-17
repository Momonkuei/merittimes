<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

$table = strtolower(str_replace('_orm','',$filename));

$tmp = <<<XXX
class $filename extends Empty_orm
{
	public \$_orm_data = array(
		'table' => '$table',
		'created_field' => 'create_time', 
		'updated_field' => 'update_time',
		'primary' => 'id',
		'rules' => array(
			array('pid, name', 'required'),
			array('pid, sort_id', 'length', 'max'=>11),
			//array('name, resource_key', 'length', 'max'=>50),
			array('name', 'length', 'max'=>50),
		),
	);
	//public function __construct(\$scenario = 'insert', \$orm_data = array())
	//{
	//	parent::__construct();
	//}
}

XXX;

eval($tmp);
