<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__));
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array (
		'disable_index_normal_search' => true,

		'enable_delete' => true,
		//'orm' => 'G_admin_resource_orm',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'admin_resource',
			//'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name', 'required'),
			),
		),
		'default_sort_field' => 'id',
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name',
		'sys_log_name' => 'name',
		'data_multilanguage' => 0,
		'listfield' => 
			array (
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
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
			'is_enable' => array(
				//'label' => 'ml:Status',
				'label' => '狀態',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Status', // label
				//	array(), // sprintf
				//	'狀態', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
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
								'other1' => '隱藏',
								'other2' => '不動作',
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'label' => '狀態',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Status', // label
							//	array(), // sprintf
							//	'狀態', // default
							//),
							'type' => 'status',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'default'=>'1',
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
					),
				),
			),
		),
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 2018-03-29 調整內頁的說明欄位寬度
		unset($ggg);
		if(isset($this->def['updatefield']['sections'][0]['field']) and count($this->def['updatefield']['sections'][0]['field']) > 0){
			foreach($this->def['updatefield']['sections'][0]['field'] as $ggg => $aaa){
				break;
			}
			$this->def['updatefield']['sections'][0]['field'][$ggg]['attr_td1'] = array('width' => '160');
		}
		unset($ggg);
		if(isset($this->def['updatefield']['sections'][1]['field']) and count($this->def['updatefield']['sections'][1]['field']) > 0){
			foreach($this->def['updatefield']['sections'][1]['field'] as $ggg => $aaa){
				break;
			}
			$this->def['updatefield']['sections'][1]['field'][$ggg]['attr_td1'] = array('width' => '160');
		}

		return true;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
