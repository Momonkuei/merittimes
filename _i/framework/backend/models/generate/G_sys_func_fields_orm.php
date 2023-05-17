<?php 
class G_sys_func_fields_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'sys_func_fields',
  'primary' => 'id',
  'rules' => 
  array (
    0 => 
    array (
      0 => 'name',
      1 => 'required',
    ),
    1 => 
    array (
      0 => 'name',
      1 => 'length',
      'max' => '100',
    ),
    2 => 
    array (
      0 => 'description',
      1 => 'length',
      'max' => '100',
    ),
  ),
);
public static function model($className=__CLASS__)
{
	return parent::model($className);
}}
