<?php 
class G_admin_resource_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'admin_resource',
  'primary' => 'id',
  'rules' => 
  array (
    0 => 
    array (
      0 => 'id',
      1 => 'length',
      'max' => '11',
    ),
  ),
);
public static function model($className=__CLASS__)
{
	return parent::model($className);
}}
