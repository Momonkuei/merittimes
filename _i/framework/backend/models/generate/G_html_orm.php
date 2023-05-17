<?php 
class G_html_orm extends Empty_orm {
public $_orm_data = 
array (
  'table' => 'html',
  'primary' => 'id',
  'rules' => 
  array (
    0 => 
    array (
      0 => 'id',
      1 => 'length',
      'max' => '11',
    ),
    array('field_tmp', 'system.backend.extensions.myvalidators.arraycomma'),
  ),
);
public static function model($className=__CLASS__)
{
	return parent::model($className);
}}
