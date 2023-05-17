<?php
class AdminurlController extends Controller {
protected $def = array (
  'orm' => 'G_admin_url_orm',
  'default_sort_field' => 'id',
  'search_keyword_field' => array('name', 'param_condition'), // 搜尋字串要搜尋的欄位
  'search_keyword_assign_field' => 'name',
  'sys_log_name' => 'name',
  'data_multilanguage' => 0,
  'listfield' => 
  array (
    'name' => 
    array (
      'label' => '功能英文名稱',
      'width' => '20%',
      'align' => 'left',
      'sort' => 1,
    ),
    'actions' => 
    array (
      'label' => '動作列表',
      'width' => '25%',
      'align' => 'left',
      'sort' => 0,
    ),
    'description' => 
    array (
      'label' => '描述',
      'width' => '20%',
      'align' => 'left',
      'sort' => 0,
    ),
    'is_hidden' => 
    array (
      'label' => '隱藏此功能',
      'width' => '10%',
      'align' => 'center',
      'ezfield' => 'is_hidden',
      'ezother' => ' ',
      'sort' => 0,
      'ezshow' => 0,
    ),
    'is_enable' => 
    array (
      'label' => '是否啟用',
      'width' => '10%',
      'align' => 'center',
      'sort' => 0,
      'ezshow' => 1,
    ),
  ),
  'updatefield' => 
  array (
    'head' => 
    array (
      0 => 'jquery.validate',
    ),
    'method' => 'update',
    'form' => 
    array (
      'enable' => true,
      'attr' => 
      array (
        'id' => 'form_data',
        'name' => 'form_data',
        'method' => 'post',
        'action' => '',
      ),
    ),
    'sections' => 
    array (
      0 => 
      array (
        'type' => '1',
        'form' => 
        array (
          'enable' => false,
        ),
        'field' => 
        array (
          'name' => 
          array (
            'label' => '功能英文名稱',
            'type' => 'input',
            'attr' => 
            array (
              'id' => 'name',
              'name' => 'name',
            ),
          ),
          'actions' => 
          array (
            'label' => '動作列表',
            'type' => 'input',
            'attr' => 
            array (
              'id' => 'actions',
              'name' => 'actions',
            ),
          ),
          'description' => 
          array (
            'label' => '描述',
            'type' => 'input',
            'attr' => 
            array (
              'id' => 'description',
              'name' => 'description',
            ),
          ),
          'is_hidden' => 
          array (
            'label' => '隱藏此功能',
            'type' => 'status',
            'attr' => 
            array (
              'id' => 'is_hidden',
              'name' => 'is_hidden',
            ),
            'other' => 
            array (
              'default' => '0',
            ),
          ),
          'is_enable' => 
          array (
            'label' => '是否啟用',
            'type' => 'status',
            'attr' => 
            array (
              'id' => 'is_enable',
              'name' => 'is_enable',
            ),
            'other' => 
            array (
              'default' => '1',
            ),
          ),
          //'param_condition' => 
          //array (
          //  'label' => '條件',
          //  'type' => 'input',
          //  'attr' => 
          //  array (
          //    'id' => 'param_condition',
          //    'name' => 'param_condition',
          //  ),
          //),
						'param_condition' => array(
							'label' => '條件',
							'type' => 'textarea',
							'attr' => array(
								'id' => 'param_condition',
								'name' => 'param_condition',
								'style' => 'resize: none;',
								'rows' => '6',
								'cols' => '50',
								//'title' => '請使用PHP Array來表達',
							),
						),
        ),
      ),
    ),
  ),
);


}
