<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__));
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'title' => 'ml:Language',
		'table' => 'ml_google',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'ml_google',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('key, name', 'required'),
			),
		),
		'default_sort_field' => 'is_enable', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('key', 'name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'get_field_label' => array('name'), // 要變成多國語系的輸出欄位的欄位
		// 'sortable' => array(
		// 	'enable' => 'true',
		// 	//'condition' => 'type = "aboutus"', // 有其它條件的時候，例如有商品分類
		// 	'url' => 'backend.php?r=language/sort', // ajax post都會有個目標
		// ),
		// 建立前端要顯示的欄位
		'listfield' => array(
			//'xxx' => array(
			//	'label' => '&nbsp;',
			//	'width' => '2%',
			//),
			'name' => array(
				'label' => 'ml:Name',
				'width' => '10%',
				'sort' => true,
			),
			'key' => array(
				'label' => '關鍵字索引',
				'width' => '10%',
				'sort' => true,
			),
			//'date_format' => array(
			//	'label' => '日期格式',
			//	'width' => '10%',
			//	'sort' => true,
			//),
			//'sort_id' => array(
			//	'label' => 'ml:Sort id',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
			'is_enable' => array(
				'label' => 'ml:Enable status',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ez' => true,
			),
			//'create_time' => array(
			//	'label' => 'ml:Create time',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
			//'update_time' => array(
			//	'label' => 'ml:Update time',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
		), // listfield
		'searchfield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
			),
			//'smarty_javascript' => '',
			'smarty_javascript_text' => '',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data_search',
					'name' => 'form_data_search',
					'method' => 'post',
					'action' => '',
				),
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'keyword' => array(
							'label' => '關鍵字',
							'type' => 'input',
							'attr' => array(
								'id' => 'keyword',
								'name' => 'keyword',
								'size' => '40',
							),
						),
					),
				),
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
			),
			'smarty_javascript' => '',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
					'method' => 'post',
					'action' => '',
				),
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'name' => array(
							'label' => 'ml:Name',
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
							),
							'other' => array(
								'html_end' => 'ex: 繁體中文',
							),
						),
						'key' => array(
							'label' => '關鍵字索引',
							'type' => 'input',
							'attr' => array(
								'id' => 'key',
								'name' => 'key',
							),
							'other' => array(
								'html_end' => 'ex: zh-TW',
							),
						),
						'is_enable' => array(
							'label' => '是否啟用',
							'type' => 'status',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'other1' => '是',
								'other2' => '否',
								'default' => '1',
							),
						),
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		// $this->data['updatecontent']['class_id'] = -1;

		$condition = ' 1 ';
		$condition_sortable = ' 1 ';
		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		//$condition = '  ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			//2016/4/29 如果有下搜尋條件，則設定排序為sort_id
			//$this->def['default_sort_field'] = 'sort_id';//2016/6/15 捨棄，改用index_first()內的方式

			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				//if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'keyword'){
					$conditions[] = ' ( `key` LIKE \'%'.$v.'%\' or name LIKE \'%'.$v.'%\' ) ';
					$conditions_sortable[] = ' ( `key` LIKE "%'.$v.'%" or name LIKE "%'.$v.'%" )';
				} elseif($k == 'class_id'){
					$conditions[] = $k.'='.$v;
					$conditions_sortable[] = $k.'='.$v;
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(count($conditions) > 0){
				if($condition != ''){
					$condition .= ' AND ';
				}
				$condition .= implode(' AND ', $conditions);
			}
			if($condition != ''){
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			if(count($conditions_sortable) > 0){
				if($condition_sortable != ''){
					$condition_sortable .= ' AND ';
				}
				// 疑似Bug 2017-03-24 己經修好了 有分類的排序會用到 by lota
				$condition_sortable .= implode(' AND ', $conditions_sortable);
			}
			if($condition_sortable != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
			//var_dump($this->def['condition']);
			//die;
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
			if(trim($condition_sortable) != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
		}

		return true;
	}


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
