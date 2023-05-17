<?php

// 第一個測試用的獨立ORM
class Item1type_orm extends Empty_orm
{
	public $_orm_data = array(
		'table' => 'item1type',
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
	//public function __construct($scenario = 'insert', $orm_data = array())
	//{
	//	parent::__construct();
	//}
}
