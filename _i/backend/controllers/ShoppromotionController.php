<?php

// 促銷方案

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		//'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name', 'required'),
				array('class_ids', 'system.backend.extensions.myvalidators.arraycomma'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'empty_orm_data_related' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'',
			),
		),
		'sortable' => array(
			'enable' => 'true',
			'condition' => '', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			//'pic1' => array(
			//	//'label' => '圖片',
			//	'mlabel' => array(
			//		null, // category
			//		'Image', // label
			//		array(), // sprintf
			//		'代表圖', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => false,
			//	'kcfinder_small_img' => true,
			//),
			'name' => array(
				'label' => '促銷方案名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '45%',
				'sort' => true,
			),
			'is_enable' => array(
				//'label' => 'ml:Status',
				'mlabel' => array(
					null, // category
					'Status', // label
					array(), // sprintf
					'狀態', // default
				),
				'width' => '10%',
				'align' => 'center',
				//'ezshow' => true,
			),
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		//'searchfield' => array(
		//	// jquery-validate, jquery-datepicker
		//	'head' => array(
		//		'jquery-validate',
		//	),
		//	//'smarty_javascript' => '',
		//	'smarty_javascript_text' => '',
		//	'method' => 'update',
		//	'form' => array(
		//		'enable' => true,
		//		'attr' => array(
		//			'id' => 'form_data_search',
		//			'name' => 'form_data_search',
		//			'method' => 'post',
		//			'action' => '',
		//		),
		//	),
		//	'sections' => array(
		//		// section
		//		array(
		//			'form' => array('enable' => false),
		//			'type' => '1',
		//			'field' => array(
		//				'class_ids' => array(
		//					'label' => '多分類',
		//					//'type' => 'select3',
		//					'type' => 'select5',
		//					//'merge' => '1', // 頭中尾的頭(1)
		//					'attr' => array(
		//						'id' => 'class_ids',
		//						'name' => 'class_ids',
		//					),
		//					'other' => array(
		//						//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
		//						//'default' => 'center',
		//						'values' => array(
		//							'0' => '請選擇',
		//						),
		//						'default' => '',
		//					),
		//				),
		//			),
		//		),
		//	),
		//),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'jquery.multi-select','jquery.datepicker',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			//'smarty_javascript' => 'product/update_javascript.htm',
			'smarty_javascript_text' => "
$.datepicker.regional['zh-TW'] = {
	closeText: '關閉',
	prevText: '&#x3c;上月',
	nextText: '下月&#x3e;',
	currentText: '今天',
	monthNames: ['一月','二月','三月','四月','五月','六月',
	'七月','八月','九月','十月','十一月','十二月'],
	monthNamesShort: ['一','二','三','四','五','六',
	'七','八','九','十','十一','十二'],
	dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
	dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
	dayNamesMin: ['日','一','二','三','四','五','六'],
	weekHeader: '周',
	dateFormat: 'yy/mm/dd',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: true,
	yearSuffix: '年'};
$.datepicker.setDefaults($.datepicker.regional['zh-TW']);
$('#start_date').datepicker({dateFormat: 'yy-mm-dd'});
$('#end_date').datepicker({dateFormat: 'yy-mm-dd'});
			",
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
					'method' => 'post',
					'action' => '',
				),
				'button_style' => '2',
			),
			'sections' => array(
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					//'section_title' => '',
					'field' => array(
						'xxx01' => array(
							'label' => '<b>基本資料：</b>',
							'type' => 'label',
						),
						'name' => array(
							'label' => '促銷方案名稱',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
						),
						'xxx01br' => array(
							'label' => '&nbsp;',
							'type' => 'label',
						),
						'scope' => array(
							'label' => '範圍',
							'type' => 'select3',
							//'type' => 'select5',
							'attr' => array(
								'id' => 'scope',
								'name' => 'scope',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '自行選擇分類和商品，有選才會符合(預設)',
									'1' => '略過分類',
									'2' => '套用全部',
								),
								'default' => '',
							),
						),
						'class_ids' => array(
							'label' => '什麼分類',
							//'type' => 'multiselect',
							'type' => 'multicheckbox',
							'attr' => array(
								'type' => 'checkbox',
								'id' => 'class_ids',
								'name' => 'class_ids[]',
							),
							'other' => array(
								'values' => array(),
								//'default' => 'center',
							),
						),
						// 這不用建欄位
						'related_ids' => array(
							'label' => '什麼商品',
							//'type' => 'select3',
							//'type' => 'select5',
							//'type' => 'multiselect',
							//'type' => 'multi-select',
							'type' => 'multi-select-category-select', // 2020-04-30
							'attr' => array(
								'id' => 'related_ids',
								'name' => 'related_ids[]',
								//'class' => 'form-control input-large select2me',
								//'class' => 'multi-select',
								//'data-placeholder' => "請選擇或搜尋",
								//'multiple' => 'multiple',
								//'size' => 10,
							),
							'other' => array(
								'table_type' => 'shoptype',
								//'values' => array(),
								//'default' => 'center',
							),
						),
						'xxx02br' => array(
							'label' => '&nbsp;',
							'type' => 'label',
						),
						'start_date' => array(
							'label' => '開始日期 / 時間',
							//'mlabel' => array(
							//	null, // category
							//	'Date', // label
							//	array(), // sprintf
							//	'日期', // default
							//),
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'start_date',
								'name' => 'start_date',
								'size' => '10',
								'readonly' => 'readonly',
							),
							'other' => array(
								'html_start' => '<div class="col-md-1">',
								'html_end' => '</div><div class="col-md-1"></div>',
							),
						),
						'start_time2' => array(
							'label' => '&nbsp;',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'clockface',
							'merge' => '3',
							'attr' => array(
								'id' => 'start_time2',
								'name' => 'start_time2',
								'size' => '10',
							),
						),
						'end_date' => array(
							'label' => '結束日期 / 時間',
							//'mlabel' => array(
							//	null, // category
							//	'Date', // label
							//	array(), // sprintf
							//	'日期', // default
							//),
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'end_date',
								'name' => 'end_date',
								'size' => '10',
								'readonly' => 'readonly',
							),
							'other' => array(
								'html_start' => '<div class="col-md-1">',
								'html_end' => '</div><div class="col-md-1"></div>',
							),
						),
						'end_time2' => array(
							'label' => '&nbsp;',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'clockface',
							'merge' => '3',
							'attr' => array(
								'id' => 'end_time2',
								'name' => 'end_time2',
								'size' => '10',
							),
						),
						'xxx03br' => array(
							'label' => '&nbsp;',
							'type' => 'label',
						),
						'condition1' => array(
							'label' => '條件',
							'type' => 'select3',
							//'type' => 'select5',
							'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'condition1',
								'name' => 'condition1',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'1' => '小計(滿額)(元)',
									'2' => '數量(滿件)',
									//'3' => '限時(秒)',
								),
								'default' => '',
							),
						),
						'condition2' => array(
							'label' => '&nbsp;',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'condition2',
								'name' => 'condition2',
								'size' => '12',
							),
							'other' => array(
								'number_only' => true,
							),
						),
						'xxx04br' => array(
							'label' => '&nbsp;',
							'type' => 'label',
						),
						'action1' => array(
							'label' => '動作',
							'type' => 'select3',
							//'type' => 'select5',
							'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'action1',
								'name' => 'action1',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'1' => '折扣(例88)(折)',
									'3' => '折抵(例100)(元)',
									'2' => '定額(元)',
									//'4' => '限時(秒)',
								),
								'default' => '',
							),
						),
						'action2' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'action2',
								'name' => 'action2',
								'size' => '12',
							),
							'other' => array(
								'number_only' => true,
							),
						),
						'xxx05br' => array(
							'label' => '&nbsp;',
							'type' => 'label',
						),
						//'free_delivery' => array(
						//	'label' => '送什麼',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'free_delivery',
						//		'name' => 'free_delivery',
						//		'size' => '48',
						//	),
						//),
						'xxx06br' => array(
							'label' => '&nbsp;',
							'type' => 'label',
						),
						'has_free_shipping' => array(
							'label' => '運費',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'has_free_shipping',
								'value' => '1',
							),
							'other' => array(
								'label' => '免',
							),
						),
						'xxx07br' => array(
							'label' => '&nbsp;',
							'type' => 'label',
						),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'mlabel' => array(
								null, // category
								'Sort', // label
								array(), // sprintf
								'排序', // default
							),
							'type' => 'sort',
							'attr' => array(
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'mlabel' => array(
								null, // category
								'Status', // label
								array(), // sprintf
								'狀態', // default
							),
							'type' => 'status',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'default'=>'1',
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

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無限層
		//$tmp2 = $this->_get_product_classes($this->data);
		//if(isset($tmp2['layer_one']) and count($tmp2['layer_one']) > 0){
		//	foreach($tmp2['layer_one'] as $k => $v){
		//		// 這兩行是有作用的哦
		//		//$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = str_repeat('　',($v['layer']-1)).$v['name'];
		//		//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = str_repeat('　',($v['layer']-1)).$v['name'];
		//		$this->def['searchfield']['sections'][0]['field']['class_ids']['other']['values'][$v['id']] = str_repeat('　',($v['layer']-1)).$v['name'];
		//	}
		//}

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_ids'] = -1;

		// $condition = 'is_checkout = 0 ';
		// $condition = 'is_enable = 1 ';
		// $condition = '  ';
		// $condition_sortable = '  ';
		$condition = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'class_ids' and $v == -1) continue;
				if($k == 'class_ids' and $v == 0) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_ids'){
					$conditions[] = 'concat(\',\','.$k.',\',\') LIKE \'%,'.$v.',%\'';
					$conditions_sortable[] = 'concat(",",'.$k.',",") LIKE "%,'.$v.',%"';
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
				$condition .= implode(' AND ', $conditions_sortable);
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

	// 2020-11-10 李哥說要加防呆的機制，時間條件不用加(1/2)
	protected function check()
	{
		$has_scope_all = false;
		$class_ids = array();
		$promotion_ids = array();
		$product_ids = array();

		$o = $this->cidb->where('is_enable',1);
		if(isset($this->data['updatecontent']['id'])){
			$o = $o->where('id !=',$this->data['updatecontent']['id']);
		}
		$rows = $o->get('shoppromotion')->result_array();
		if($rows){
			foreach($rows as $k => $v){
				$ids = array();
				if($v['class_ids'] != ''){
					$ids = explode(',',$v['class_ids']);
				}
				if($ids){
					foreach($ids as $vv){
						$class_ids[] = $vv;
					}
				}
				$promotion_ids[] = $v['id'];

				if(isset($v['scope']) && $v['scope'] == '2'){
					$has_scope_all = true;
				}
			}
		}

		if($has_scope_all === true){
			$this->data['def']['updatefield']['sections'][0]['field']['scope']['other']['values'][2] = $this->data['def']['updatefield']['sections'][0]['field']['scope']['other']['values'][2].' *** 其它活動已被選過 ***';
		}

		//var_dump($promotion_ids);
		if(!empty($promotion_ids)){
			$rows = $this->cidb->where('is_enable',1)->where('type','shoppromotionrelatedids')->where('ml_key',$this->data['admin_switch_data_ml_key'])->where_in('class_id',$promotion_ids)->get('html')->result_array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $k => $v){
					if($v['other1'] != ''){
						$product_ids[] = $v['other1'];
					}
				}
			}
		}

		if(!empty($this->data['updatecontent']['class_ids'])){
			foreach($this->data['updatecontent']['class_ids'] as $k => $v){
				if(in_array($k,$class_ids)){
					$this->data['updatecontent']['class_ids'][$k]['value'] = '<s>'.$this->data['updatecontent']['class_ids'][$k]['value'].'</s>';
				}
			}
		}

		//var_dump($product_ids);
		if(!empty($this->data['updatecontent']['related_ids'])){
			foreach($this->data['updatecontent']['related_ids'] as $k => $v){
				if(in_array($k,$product_ids)){
					$this->data['updatecontent']['related_ids'][$k]['value'] = $this->data['updatecontent']['related_ids'][$k]['value'].' *** 其它活動已被選過 ***';
				}
			}
		}
		//var_dump($this->data['updatecontent']['related_ids']);
	}

	// 2020-11-10 李哥說要加防呆的機制，時間條件不用加(2/2)
	protected function check2($array)
	{
		$return = array();
		$id = 0;

		if(isset($this->data['id']) and $this->data['id'] > 0){
			$id = $this->data['id'];
		}

		$has_scope_all = false;
		$class_ids = array();
		$promotion_ids = array();
		$product_ids = array();
		$producttype_tmp = array();
		$product_tmp = array();

		$o = $this->cidb->where('is_enable',1);
		if($id > 0){
			$o = $o->where('id !=',$id);
		}
		$rows = $o->get('shoppromotion')->result_array();
		if($rows){
			foreach($rows as $k => $v){
				$ids = array();
				if($v['class_ids'] != ''){
					$ids = explode(',',$v['class_ids']);
				}
				if($ids){
					foreach($ids as $vv){
						$class_ids[] = $vv;
					}
				}
				$promotion_ids[] = $v['id'];

				if($v['scope'] == '2'){
					$has_scope_all = true;
				}
			}
		}

		if($array['scope'] == '2' and $has_scope_all === true){
			$return[] = '已有其它主題活動選擇分類或產品，請重新確認';
		}

		if(!empty($promotion_ids)){
			$rows = $this->cidb->where('is_enable',1)->where('type','shoppromotionrelatedids')->where('ml_key',$this->data['admin_switch_data_ml_key'])->where_in('class_id',$promotion_ids)->get('html')->result_array();
			//var_dump($rows);
			if($rows){
				foreach($rows as $k => $v){
					if($v['other1'] != ''){
						$product_ids[] = $v['other1'];
					}
				}
			}
		}

		$producttype = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->get('shoptype')->result_array();
		if($producttype){
			foreach($producttype as $k => $v){
				$producttype_tmp[$v['id']] = $v;
			}
		}

		$product = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->get('shop')->result_array();
		if($product){
			foreach($product as $k => $v){
				$product_tmp[$v['id']] = $v;
			}
		}

		$has_producttype = false;
		if(!empty($class_ids) and isset($array['class_ids']) and is_array($array['class_ids'])){
			foreach($class_ids as $v){
				if(in_array($v,$array['class_ids'])){
					$has_producttype = true;
					if(isset($producttype_tmp[$v])){
						$return[] = $producttype_tmp[$v]['name'].' (分類已重覆選擇)';
					} else {
						$return[] = '編號：'.$v.'的分類已重覆選擇';
					}
				}
			}
		}

		$has_product = false;
		if(!empty($product_ids) and isset($array['related_ids'])){
			foreach($product_ids as $v){
				if(in_array($v,$array['related_ids'])){
					$has_product = true;
					if(isset($product_tmp[$v])){
						$return[] = $product_tmp[$v]['name'].' (產品已重覆選擇)';
					} else {
						$return[] = '編號：'.$v.'的產品已重覆選擇';
					}
				}
			}
		}

		if($has_scope_all === true and ($has_producttype === true or $has_product === true)){
			$return[] = '己有其它主題活動選擇套用全部產品';
		}

		return $return;
	}

	protected function create_show_last()
	{

		//$this->getdata();

		unset($this->data['def']['updatefield']['sections'][1]['field']['kc01']);

		// 取得所有的分類
		//$rows = $this->db->createCommand()
		//->select('*')
		//->from('admin_group')
		//->where('is_enable=1')
		//->queryAll();
		$tmp2 = $this->_get_product_classes($this->data);
		$rows = $tmp2['layer_one'];

		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = str_repeat('　',($v['layer']-1)).$v['name'];
			}
		}
		$this->data['updatecontent']['class_ids'] = $groups;

		// 相關物件
		//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'item1',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		$rows = $this->db->createCommand()->from(str_replace('promotion','',$this->data['router_class']))->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->data['def']['updatefield']['sections'][0]['field']['related_ids']['other']['values'][$v['id']] = $v['name'];
			}
		}
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = $v['name'];
			}
		}
		$this->data['updatecontent']['related_ids'] = $groups;

		$this->check();

		// 為了支援section_title
		//$this->data['main_content'] = 'member/update';
	}

	protected function update_show_last($updatecontent)
	{

		//$this->getdata();

		//$this->data['def']['updatefield']['sections'][1]['field']['kc01']['other']['school_id'] = 'item1'.$this->data['updatecontent']['id'];

		// 取得所有的分類
		$tmp = explode(',', $this->data['updatecontent']['class_ids']);
		$tmp2 = $this->_get_product_classes($this->data);
		$rows = $tmp2['layer_one'];
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = str_repeat('　',($v['layer']-1)).$v['name'];
				if(in_array($v['id'], $tmp)){
					//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
					$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['class_ids'] = $groups;

		// 相關物件
		//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id!=:id', array(':type'=>'item1',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['updatecontent']['id']))->order('sort_id asc')->queryAll();
		$rows = $this->db->createCommand()->from(str_replace('promotion','',$this->data['router_class']))->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->data['def']['updatefield']['sections'][0]['field']['related_ids']['other']['values'][$v['id']] = $v['name'];
			}
		}
		$tmp2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$this->data['router_class'].'relatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['updatecontent']['id']))->order('sort_id asc')->queryAll();
		$tmp = array();
		if($tmp2){
			foreach($tmp2 as $k => $v){
				$tmp[] = $v['other1'];
			}
		}
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['id']]['value'] = $v['name'];
				if(in_array($v['id'], $tmp)){
					$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
					//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['related_ids'] = $groups;

		$starts = explode(' ', $this->data['updatecontent']['start_time']);
		$this->data['updatecontent']['start_date'] = $starts[0];
		$this->data['updatecontent']['start_time2'] = substr($starts[1],0,-3);

		$ends = explode(' ', $this->data['updatecontent']['end_time']);
		$this->data['updatecontent']['end_date'] = $ends[0];
		$this->data['updatecontent']['end_time2'] = substr($ends[1],0,-3);
	
		if(isset($this->data['updatecontent']['scope']) && $this->data['updatecontent']['scope'] == '1'){
			unset($this->data['def']['updatefield']['sections'][0]['field']['class_ids']);
		} elseif(isset($this->data['updatecontent']['scope']) && $this->data['updatecontent']['scope'] == '2'){
			unset($this->data['def']['updatefield']['sections'][0]['field']['class_ids']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['related_ids']);
		}

		$this->check();

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	protected function index_last()
	{
		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				//if($v['pic1'] != ''){
				//	$v['pic1'] = $this->data['image_upload_path'].'/item1/'.$v['pic1'];
				//}

				if($v['is_enable'] == '1'){
					$v['is_enable'] = '✔';
				} else {
					$v['is_enable'] = '';
				}

				$this->data['listcontent'][$k] = $v;
			}
		}
	}

	protected function update_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		if($array['start_date'] == ''){
			$start = '0000-00-00';
		} else {
			$start = $array['start_date'];
		}
		$start .= ' ';

		if($array['start_time2'] == ''){
			$start .= '00:00';
		} else {
			$start .= $array['start_time2'];
		}

		// 秒
		$start .= ':00';


		if($array['end_date'] == ''){
			$end = '0000-00-00';
		} else {
			$end = $array['end_date'];
		}
		$end .= ' ';

		if($array['end_time2'] == ''){
			$end .= '00:00';
		} else {
			$end .= $array['end_time2'];
		}

		// 秒
		$end .= ':00';

		$array['start_time'] = $start;
		$array['end_time'] = $end;

		if(!isset($array['class_ids'])){
			$array['class_ids'] = '';
		}

		if(!isset($array['has_free_shipping'])){
			$array['has_free_shipping'] = 0;
		}

		if($array['is_enable'] == 1){
			$return = $this->check2($array);

			if(!empty($return)){
				$redirect_url = $this->data['class_url'];
				if(isset($_POST['prev_url']) && $_POST['prev_url'] != ''){
					$redirect_url = $_POST['prev_url'];
				}

				//$this->load->library('Parameter_handle', '', 'parameter');
				//$parameter = $this->parameter->getDefine();
				$url = base64url::encode($redirect_url);
				//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');

				$end_string = '';
				// 這行沒有加，在IE就會看到亂碼
				$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
				$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
				$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
				$end_string .= '<script type="text/javascript">';
				//if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0' or 1){ //2016/5/12 經理建議 要直接跳出修改提醒
				//	//$end_string .= 'alert(l.get("Update success"));';
				//	$end_string .= 'alert("Update success");';
				//}
				$end_string .= 'alert("'.$return_message = implode('\n',$return).'");';

				//$this->load->library('base64url');
				if(isset($array['update_base64_url']) and $array['update_base64_url'] != ''){
					$url = base64url::decode($array['update_base64_url']);

					// 原有的方式，會導致一重整，就alert一次
					//$url = str_replace('-vsuccess', '', $url);
					//redirect($url.'-vsuccess');

					if($url==''){
						$url = BACKEND_DOMAIN.'/_i/';
					}

					// 新的方式己修正掉這個問題
					$end_string .= 'window.location.href="'.$url.'";';

					// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
					//$this->redirect($url);
				} else {
					// 原有方式
					//$url = $this->base64url->encode($redirect_url);
					//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');

					if($redirect_url==''){
						$redirect_url = BACKEND_DOMAIN.'/_i/';
					}

					$end_string .= 'window.location.href="'.$redirect_url.'";';

					// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
					//$this->redirect($redirect_url);
				}


				$end_string .= '</script>';
				echo $end_string;
				die;
			}
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		if($array['start_date'] == ''){
			$start = '0000-00-00';
		} else {
			$start = $array['start_date'];
		}

		if($array['start_time2'] == ''){
			$start .= '00:00';
		} else {
			$start .= $array['start_time2'];
		}

		// 秒
		$start .= ':00';

		if($array['end_date'] == ''){
			$end = '0000-00-00';
		} else {
			$end = $array['end_date'];
		}

		if($array['end_time2'] == ''){
			$end .= '00:00';
		} else {
			$end .= $array['end_time2'];
		}

		// 秒
		$end .= ':00';

		$array['start_time'] = $start;
		$array['end_time'] = $end;

		if(!isset($array['class_ids'])){
			$array['class_ids'] = '';
		}

		if(!isset($array['has_free_shipping'])){
			$array['has_free_shipping'] = 0;
		}

		if($array['is_enable'] == 1){
			$return = $this->check2($array);

			if(!empty($return)){
				$redirect_url = $this->data['class_url'];
				if(isset($_POST['prev_url']) && $_POST['prev_url'] != ''){
					$redirect_url = $_POST['prev_url'];
				}

				//$this->load->library('Parameter_handle', '', 'parameter');
				//$parameter = $this->parameter->getDefine();
				$url = base64url::encode($redirect_url);
				//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');

				$end_string = '';
				// 這行沒有加，在IE就會看到亂碼
				$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
				$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
				$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
				$end_string .= '<script type="text/javascript">';
				//if(isset($this->data['sys_configs']['submit_alert']) and $this->data['sys_configs']['submit_alert'] != '0' or 1){ //2016/5/12 經理建議 要直接跳出修改提醒
				//	//$end_string .= 'alert(l.get("Update success"));';
				//	$end_string .= 'alert("Update success");';
				//}
				$end_string .= 'alert("'.$return_message = implode('\n',$return).'");';

				//$this->load->library('base64url');
				if(isset($array['update_base64_url']) and $array['update_base64_url'] != ''){
					$url = base64url::decode($array['update_base64_url']);

					// 原有的方式，會導致一重整，就alert一次
					//$url = str_replace('-vsuccess', '', $url);
					//redirect($url.'-vsuccess');

					if($url==''){
						$url = BACKEND_DOMAIN.'/_i/';
					}

					// 新的方式己修正掉這個問題
					$end_string .= 'window.location.href="'.$url.'";';

					// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
					//$this->redirect($url);
				} else {
					// 原有方式
					//$url = $this->base64url->encode($redirect_url);
					//redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'update');

					if($redirect_url==''){
						$redirect_url = BACKEND_DOMAIN.'/_i/';
					}

					$end_string .= 'window.location.href="'.$redirect_url.'";';

					// 為了大陸的pinky而做的暫時性改變 2016/5/12 經理建議 要跳出提醒 , 關閉直接跳頁
					//$this->redirect($redirect_url);
				}


				$end_string .= '</script>';
				echo $end_string;
				die;
			}
		}

		return $array;
	}


	protected function create_run_last()
	{
		$_POST['inventorys']['data_id'] = $this->data['_last_insert_id'];
		$_POST['inventorys']['from_user_id'] = $_SESSION['auth_admin_id'];
		// Jerry 發現這邊有報錯，先註解等待有緣人來解救 2020-12-28
		// $this->multi_field_v1('inventorys', str_replace('promotion','',$this->data['router_class']).'inventory', 'spec1|spec2|inventory|price', 'spec1', 0);

		// 相關物件
		eval($this->data['empty_orm_eval']);
		$c = new $name('insert', $this->data['def']['empty_orm_data_related']);
		$c::model()->deleteAll('type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$this->data['router_class'].'relatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['_last_insert_id']));

		if(isset($_POST['related_ids']) and count($_POST['related_ids']) > 0){
			$save = array();
			foreach($_POST['related_ids'] as $k => $v){
				$tmp = array(
					'type' => $this->data['router_class'].'relatedids',
					'ml_key' => $this->data['admin_switch_data_ml_key'],
					'class_id' => $this->data['_last_insert_id'],
					'other1' => $v,
					'is_enable' => 1,
				);
				$save[] = $tmp;
			}
			$this->cidb->insert_batch('html', $save);
		}
	}

	protected function update_run_last()
	{
		$_POST['inventorys']['data_id'] = $this->data['id'];
		$_POST['inventorys']['from_user_id'] = $_SESSION['auth_admin_id'];
		// Jerry 發現這邊有報錯，先註解等待有緣人來解救 2020-12-28
		// $this->multi_field_v1('inventorys', str_replace('promotion','',$this->data['router_class']).'inventory', 'spec1|spec2|inventory|price', 'spec1', 0);

		// 相關物件
		eval($this->data['empty_orm_eval']);
		$c = new $name('insert', $this->data['def']['empty_orm_data_related']);
		$c::model()->deleteAll('type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$this->data['router_class'].'relatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['id']));

		if(isset($_POST['related_ids']) and count($_POST['related_ids']) > 0){
			$save = array();
			foreach($_POST['related_ids'] as $k => $v){
				$tmp = array(
					'type' => $this->data['router_class'].'relatedids',
					'ml_key' => $this->data['admin_switch_data_ml_key'],
					'class_id' => $this->data['id'],
					'other1' => $v,
					'is_enable' => 1,
				);
				$save[] = $tmp;
			}
			$this->cidb->insert_batch('html', $save);
		}
	}

	public function _get_product_classes($data)
	{
		// 取得所有的分類，目標做到2層以上
		$conditions = array(
			'ml_key' => $data['ml_key'],
			'is_enable' => '1',
		);
		//$query = $this->cidb->select('id, class_id, class_name, class_name AS class_name_id')->where($conditions)->get('product_class');
		//$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->get('item1type');
		$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->get(str_replace('promotion','',$this->data['router_class']).'type');
		$productclasses = array();
		$productclasses_sample = array();
		foreach($query->result_array() as $row){
			$row['class_name_id'] = $row['class_name_id'].'__'.$row['id'];
			$productclasses[] = $row;
			$productclasses_sample[$row['id']] = $row;
		}

		// 將分類轉成Tree
		// http://www.mombu.com/php/php/t-creating-tree-structure-from-associative-array-11767756.html
		// Set up indexing of the above list (in case it wasn't indexed).
		$lookup = array();
		foreach( $productclasses as $item ){
			$item['children'] = array();
			$lookup[$item['id']] = $item;
		}
		
		// Now build tree.
		$tree = array();
		foreach( $lookup as $id => $foo ){
			$item = &$lookup[$id];
			if( $item['class_id'] == 0 ){
				$tree[$id] = &$item;
			} else if( isset( $lookup[$item['class_id']] ) ){
				$lookup[$item['class_id']]['children'][$id] = &$item;
			} else {
				$tree['_orphans_'][$id] = &$item;
			}
		}

		// 想要做無限層轉一層(例如用在下拉選單)
		$tmp = var_export($tree,true);
		$tmps = explode("\n",$tmp);
		$tmp1 = array();
		foreach($tmps as $k => $v){
			if(preg_match('/^(.*)\'class_name_id\'\ =\>\ \'(.*)__(\d+)\'\,$/', $v, $matches)){
				//echo strlen($matches[1]).' '.$matches[3].$matches[2].'<br />'."\n";
				$tmp1[] = array(
					'layer' => strlen($matches[1])/4,
					'name' => $matches[2],
					'id' => $matches[3],
				);
			}
		}

		$return = array(
			'data' => $productclasses,
			'sample' => $productclasses_sample,
			'tree' => $tree,
			'layer_one' => $tmp1,
		);

		return $return;
	}

	public function actionUpdatefields_multi_select_category_select_dropdown()
	{
		if (!empty($_POST)) {
			$this->data['def'] = G::definit($this->def, $this->data);

			$random = $_POST['random']; // 為了可以多個視窗操作，操作SESSION不會出問題的寫法
			$class_id = $_POST['id'];

			// 已選的
			$select_ids = array();
			if (isset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random]) and !empty($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random])) {
				foreach ($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random] as $k => $v) {
					$select_ids[] = $k;
				}
			}

			$in = '';
			if (!empty($select_ids)) {
				$in = ' or id in (' . implode(',', $select_ids) . ') ';
			}

			//$sql = 'select * from '.str_replace('type','',$this->data['def']['table']).' where is_enable=1 and ml_key="'.$this->data['ml_key'].'" and (class_id='.$class_id.' or class_ids like "%,'.$class_id.',%" '.$in.') ';
			$sql = 'select * from shop where is_enable=1 and ml_key="' . $this->data['ml_key'] . '" and (class_id=' . $class_id . ' or class_ids like "%,' . $class_id . ',%" ' . $in . ') ';
			$rows = $this->cidb->query($sql)->result_array();

			$return = '';
			if ($rows and !empty($rows)) {
				foreach ($rows as $k => $v) {
					$selected = '';
					if (in_array($v['id'], $select_ids)) {
						$selected = ' selected="selected" ';
					}
					$return .= '<option value="' . $v['id'] . '" ' . $selected . ' >' . $v['name'] . '</option>';
				}
			}

			echo $return;
			die;
		}
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
