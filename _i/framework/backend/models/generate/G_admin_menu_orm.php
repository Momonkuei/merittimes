<?php 
class G_admin_menu_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'admin_menu',
  'primary' => 'id',
  'created_field' => 'create_time',
  'updated_field' => 'update_time',
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
      'max' => '50',
    ),
  ),
);
public static function model($className=__CLASS__)
{
	return parent::model($className);
}}
