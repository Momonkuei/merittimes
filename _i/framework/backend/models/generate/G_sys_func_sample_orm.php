<?php 
class G_sys_func_sample_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'sys_func_sample',
  'rules' => 
  array (
    0 => 
    array (
      0 => 'description',
      1 => 'length',
      'max' => '255',
    ),
    1 => 
    array (
      0 => 'name',
      1 => 'required',
    ),
    2 => 
    array (
      0 => 'name',
      1 => 'length',
      'max' => '100',
    ),
  ),
  'primary' => 'id',
);
public static function model($className=__CLASS__)
{
	return parent::model($className);
}}
