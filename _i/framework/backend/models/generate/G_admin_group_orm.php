<?php 
class G_admin_group_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'admin_group',
  'primary' => 'id',
  'rules' => 
  array (
    0 => 
    array (
      0 => 'id',
      1 => 'length',
      'max' => '11',
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
);
public static function model($className=__CLASS__)
{
	return parent::model($className);
}}
