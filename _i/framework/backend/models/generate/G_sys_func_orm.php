<?php 
class G_sys_func_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'sys_func',
  'rules' => 
  array (
    0 => 
    array (
      0 => 'name',
      1 => 'required',
    ),
    1 => 
    array (
      0 => 'func',
      1 => 'required',
    ),
  ),
  'primary' => 'id',
);
public static function model($className=__CLASS__)
{
	return parent::model($className);
}}
