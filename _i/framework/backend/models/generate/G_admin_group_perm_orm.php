<?php 
class G_admin_group_perm_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'admin_group_perm',
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
