<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		//'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

		//'tools_name' => '(非會員) 實體優惠券發放',
		//'tools' => array(
		//	//array(
		//	//	'class' => '',
		//	//	'target' => '',
		//	//	'url' => '',
		//	//	'name' => '',
		//	//),
		//),

		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name,func', 'required'),
				//array('deny_promotion_ids', 'system.backend.extensions.myvalidators.arraycomma'),
				//array('only_promotion_ids', 'system.backend.extensions.myvalidators.arraycomma'),
				//array('class_ids', 'system.backend.extensions.myvalidators.arraycomma'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		// 'empty_orm_data_related' => array(
		// 	'table' => 'html',
		// 	'created_field' => 'create_time', 
		// 	'updated_field' => 'update_time',
		// 	'primary' => 'id',
		// 	'rules' => array(
		// 		//array('start_date', 'date', 'format'=>'yyyy-M-d'),
		// 	),
		// ),
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
			'name' => array(
				'label' => '優惠券名稱',
				'width' => '10%',
				'sort' => true,
			),
			'gift_serial_number' => array(
				'label' => '優惠碼',
				'width' => '10%',
				'sort' => true,
			),
			'start_date' => array(
				'label' => '開始日期',
				'width' => '10%',
				'sort' => true,
				'align' => 'center',
			),
			'end_date' => array(
				'label' => '結束日期',
				'width' => '10%',
				'sort' => true,
				'align' => 'center',
			),
			'gift_only_use_count' => array(
				'label' => '可使用次數',
				'width' => '10%',
				'sort' => true,
			),
			'gift_only_use_count2' => array(
				'label' => '已使用次數',
				'width' => '10%',
				'sort' => true,
			),
			//'xx01' => array(
			//	'label' => '代碼輸出',
			//	//'mlabel' => array(
			//	//	null, // category
			//	//	'Title', // label
			//	//	array(), // sprintf
			//	//	'標題', // default
			//	//),
			//	'url_id' => 'numberoutput',
			//	'width' => '12%',
			//	'sort' => true,
			//),
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
				// 'ezshow' => true,
			),
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
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
				// blha...
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
				'jquery.multi-select',
				'jquery.datepicker',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			'smarty_javascript' => '', // product/update_javascript.htm
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
			//'smarty_javascript' => 'product/update_javascript.htm',
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
					'section_title' => '一般欄位',
					'field' => array(
						'name' => array(
							'label' => '優惠券名稱',
							// 'mlabel' => array(
							// 	null, // category
							// 	'Title', // label
							// 	array(), // sprintf
							// 	'標題', // default
							// ),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
						),
						// 'func' => array(
						// 	'label' => '類型',
						// 	'type' => 'select3',
						// 	//'type' => 'select5',
						// 	//'merge' => '1', // 頭中尾的頭(1)
						// 	'attr' => array(
						// 		'id' => 'func',
						// 		'name' => 'func',
						// 	),
						// 	'other' => array(
						// 		'values' => array('1'=>'優惠券','2'=>'紅利'),
						// 		//'default' => 'center',
						// 		//'values' => array(
						// 		//	'0' => '請選擇',
						// 		//),
						// 		//'default' => '1',
						// 	),
						// ),
						'start_date' => array(
							'label' => '日期',
							'merge' => '1',
							'type' => 'datepicker',
							'attr' => array(
								'id' => 'start_date',
								'name' => 'start_date',
							),
							'other' => array(
								'html_start' => '生效日',
								'html_end' => '　∼　',
							),
						),
						'end_date' => array(
							'label' => '有效日',
							'merge' => '3',
							'type' => 'datepicker',
							'attr' => array(
								'id' => 'end_date',
								'name' => 'end_date',
							),
						),
						// 'deny_promotion_ids' => array(
						// 	'label' => '不能使用在…',
						// 	//'type' => 'multiselect',
						// 	'type' => 'multicheckbox',
						// 	'attr' => array(
						// 		'type' => 'checkbox',
						// 		'id' => 'deny_promotion_ids',
						// 		'name' => 'deny_promotion_ids[]',
						// 	),
						// 	'other' => array(
						// 		'values' => array(),
						// 		//'default' => 'center',
						// 		//'html_end' => '(優先權高)',
						// 	),
						// ),
						//'only_promotion_ids' => array(
						//	'label' => '只能使用在…',
						//	//'type' => 'multiselect',
						//	'type' => 'multicheckbox',
						//	'attr' => array(
						//		'type' => 'checkbox',
						//		'id' => 'only_promotion_ids',
						//		'name' => 'only_promotion_ids[]',
						//	),
						//	'other' => array(
						//		'values' => array(),
						//		//'default' => 'center',
						//	),
						//),
						//'class_ids' => array(
						//	'label' => '產品分類',
						//	//'type' => 'multiselect',
						//	'type' => 'multicheckbox',
						//	'attr' => array(
						//		'type' => 'checkbox',
						//		'id' => 'class_ids',
						//		'name' => 'class_ids[]',
						//	),
						//	'other' => array(
						//		'values' => array(),
						//		//'default' => 'center',
						//	),
						//),
						'related_ids' => array(
							'label' => '限定商品<br><p style="color:red">若沒有選擇則預設全站適用</p>',
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
						// 'emailformat_id' => array(
						// 	'label' => '用什麼信件格式寄',
						// 	'type' => 'select3',
						// 	//'type' => 'select5',
						// 	//'merge' => '1', // 頭中尾的頭(1)
						// 	'attr' => array(
						// 		'id' => 'emailformat_id',
						// 		'name' => 'emailformat_id',
						// 	),
						// 	'other' => array(
						// 		//'values' => array('1'=>'優惠券','2'=>'紅利'),
						// 		//'default' => 'center',
						// 		'values' => array(
						// 			'0' => '請選擇',
						// 		),
						// 		'default' => '0',
						// 		'html_end' => '　預設不寄，沒選就是不寄',
						// 	),
						// ),
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
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'section_title' => '優惠券',
					'field' => array(
						'gift_serial_number' => array(
							'label' => '優惠券代碼',
							'type' => 'input',
							'attr' => array(
								'id' => 'gift_serial_number',
								'name' => 'gift_serial_number',
							),
						),
						'gift_condition1' => array(
							'label' => '條件',
							'type' => 'select3',
							//'type' => 'select5',
							'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'gift_condition1',
								'name' => 'gift_condition1',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '無',
									'1' => '訂單最低金額(元)',
								),
								'default' => '',
							),
						),
						'gift_condition2' => array(
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
								'id' => 'gift_condition2',
								'name' => 'gift_condition2',
								'size' => '12',
							),
							'other' => array(
								'number_only' => true,
							),
						),
						'gift_do_type' => array(
							'label' => '動作<br>(選擇百分比時，折扣輸入10為-10%金額，<br>選擇固定金額時，折扣輸入600為-600元)',
							'type' => 'select3',
							//'type' => 'select5',
							'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'gift_do_type',
								'name' => 'gift_do_type',
							),
							'other' => array(
								'values' => array('1'=>'折扣(%)','2'=>'折抵'),
								//'default' => 'center',
								//'values' => array(
								//	'0' => '請選擇',
								//),
								'default' => '1',
							),
						),
						'gift_do_value' => array(
							'label' => '',
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'gift_do_value',
								'name' => 'gift_do_value',
								'size' => '10',
							),
							'other' => array(
								'number_only' => true,
							),
						),
						//'gift_has_no_change_given' => array(
						//	'label' => '不找零',
						//	'type' => 'checkbox',
						//	'attr' => array(
						//		'name' => 'gift_has_no_change_given',
						//		'type' => 'checkbox',
						//		'value' => '1',
						//	),
						//),
						'gift_only_use_count' => array(
							'label' => '能夠被使用的次數',
							'type' => 'input',
							'attr' => array(
								'id' => 'gift_only_use_count',
								'name' => 'gift_only_use_count',
								'size' => '2',
							),
							'other' => array(
								'html_end' => '這裡請填1，除非是可以被用很多次',
								'number_only' => true,
							),
						),
						// 這個只是參考用，實際上是有這個欄位的
						// 'gift_only_use_count2' => array(
						// 	'label' => '己被使用的次數',
						// 	'type' => 'inputn',
						// ),
						// 'gift_amount' => array(
						// 	'label' => '要發放幾張',
						// 	'type' => 'select3',
						// 	//'type' => 'select5',
						// 	//'merge' => '1', // 頭中尾的頭(1)
						// 	'attr' => array(
						// 		'id' => 'gift_amount',
						// 		'name' => 'gift_amount',
						// 	),
						// 	'other' => array(
						// 		'values' => array(
						// 			'1'=>'1',
						// 			'2'=>'2',
						// 			'3'=>'3',
						// 			'4'=>'4',
						// 			'5'=>'5',
						// 			'6'=>'6',
						// 			'7'=>'7',
						// 			'8'=>'8',
						// 			'9'=>'9',
						// 			'10'=>'10',
						// 			'11'=>'11',
						// 			'12'=>'12',
						// 			'13'=>'13',
						// 			'14'=>'14',
						// 			'15'=>'15',
						// 			'16'=>'16',
						// 			'17'=>'17',
						// 			'18'=>'18',
						// 			'19'=>'19',
						// 			'20'=>'20',
						// 		),
						// 		//'default' => 'center',
						// 		//'values' => array(
						// 		//	'0' => '請選擇',
						// 		//),
						// 		'default' => '1',
						// 		'html_end' => '張',
						// 	),
						// ),
					),
				),
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '1',
				// 	'section_title' => '紅利',
				// 	'field' => array(
				// 		'bonus_condition' => array(
				// 			'label' => '滿額條件',
				// 			'type' => 'input',
				// 			'merge' => '1',
				// 			'attr' => array(
				// 				'id' => 'bonus_condition',
				// 				'name' => 'bonus_condition',
				// 				'size' => '10',
				// 			),
				// 			'other' => array(
				// 				'html_start' => '滿 ',
				// 				'html_end' => '元，',
				// 				'number_only' => true,
				// 			),
				// 		),
				// 		'bonus_action' => array(
				// 			'label' => '能使用多少',
				// 			'type' => 'input',
				// 			'merge' => '3',
				// 			'attr' => array(
				// 				'id' => 'bonus_action',
				// 				'name' => 'bonus_action',
				// 				'size' => '10',
				// 			),
				// 			'other' => array(
				// 				'html_end' => '元 (如為零，代表全用掉)',
				// 				'number_only' => true,
				// 			),
				// 		),
				// 		// 寫程式參考用
				// 		// 'bonus_left' => array(
				// 		// 	'label' => '紅利點數剩多少', // 因為剩多少比較好寫吧
				// 		// 	'type' => 'inputn',
				// 		// 	'other' => array(
				// 		// 		'html' => '點',
				// 		// 	),
				// 		// ),
				// 		'bonus_point' => array(
				// 			'label' => '要發放多少紅利點數', // 
				// 			'type' => 'input',
				// 			'attr' => array(
				// 				'id' => 'bonus_point',
				// 				'name' => 'bonus_point',
				// 				'size' => '10',
				// 			),
				// 			'other' => array(
				// 				'html_end' => '點',
				// 				'number_only' => true,
				// 			),
				// 		),
				// 	),
				// ),
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

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'pid=0 ';
		$this->def['sortable']['condition'] = 'pid=0';

// 		$this->def['searchfield']['smarty_javascript_text'] = <<<XXX0
// 
// $('.row_details_open').attr('style','display:none');
// $('.row-details').click(function(){
// 	var click_id = $(this).attr('id');
// 	var tmps = click_id.split('_');
// 	if($(this).attr('class') == 'row-details row-details-open'){
// 		$(this).attr('class', 'row-details row-details-close');
// 	} else {
// 		$(this).attr('class', 'row-details row-details-open');
// 	}
// 	$('#row_details_open_'+tmps[2]).toggle();
// });
// 
// XXX0;


		// $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'emailformat',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		// if($rows and count($rows) > 0){
		// 	foreach($rows as $k => $v){
		// 		$this->def['updatefield']['sections'][0]['field']['emailformat_id']['other']['values'][$v['id']] = $v['other1'];
		// 	}
		// }

		//$rows = $this->db->createCommand()->from($this->data['router_class'].'promotion')->where('is_enable=1')->order('sort_id asc')->queryAll();
		//if($rows and count($rows) > 0){
		//	foreach($rows as $k => $v){
		//		// 不能使用在
		//		$this->def['updatefield']['sections'][0]['field']['deny_promotion_ids']['other']['values'][$v['id']] = $v['name'];

		//		// 只能使用在
		//		$this->def['updatefield']['sections'][0]['field']['only_promotion_ids']['other']['values'][$v['id']] = $v['name'];
		//	}
		//}

		$this->data['related_ids'] = array();
		//	'demo' => '測試',
		//	'production' => '上線',
		//	'shop' => '購物',
		//	'sem' => 'SEM',
		//	'platform' => '平台',
		//	'buyersline' => '百邇來公司用',
		//
		// $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type', array(':type'=>'case',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		$rows = $this->db->createCommand()->from('shop')->where('is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				// $this->data['related_ids'][$v['id']] = $v['topic'];
				$this->data['related_ids'][$v['id']] = $v['name'];
			}
		}

		return true;
	}

	protected function index_last()
	{
		/*
		'tools_name' => '優惠券/生日禮券/紅利發放',
		'tools' => array(
			//array(
			//	'class' => '',
			//	'target' => '',
			//	'url' => '',
			//	'name' => '',
			//),
		),
		 */

		// 注意，這裡只能發放非會員的優惠券哦！！！
		// $rows = $this->db->createCommand()->from('shopgoodies')->where('is_enable=1 and pid=0 and func=1')->order('sort_id asc')->queryAll();
		// if($rows){
		// 	foreach($rows as $k => $v){
		// 		$tmp = array(
		// 			'class' => '',
		// 			'target' => '',
		// 			'url' => $this->createUrl($this->data['router_class'].'/goodiessend',array('id'=>$v['id'])),
		// 			'name' => $v['name'],
		// 			'onclick' => 'if(!confirm(\'確認要發送\'+$(this).html().trim()+\'嗎?\')){ return false;}',
		// 		);
		// 		$this->data['def']['tools'][] = $tmp;
		// 	}
		// }

		if(!empty($this->data['listcontent'])){
			foreach($this->data['listcontent'] as $k => $v){
				$tmp1 = 0; // 發放給會員
				$tmp2 = 0; // 會員己使用
				$tmp3 = 0; // 發放給非會員
				$tmp4 = 0; // 非會員己使用
				$rows2 = $this->db->createCommand()->from('shopgoodies')->where('pid=:id', array(':id'=>$v['id']))->queryAll();
				if($rows2){
					foreach($rows2 as $kk => $vv){
						if($vv['member_id'] > 0){
							$tmp1+=1;
							if($vv['is_enable'] == 0){
								$tmp2+=1;
							}
						} else {
							$tmp3+=1;
							if($vv['is_enable'] == 0){
								$tmp2+=1;
							}
						}
					}
				}

				if(0){
					$this->data['listcontent'][$k]['name'] .= ' <span id="row_details_'.$v['id'].'" class="row-details row-details-close"></span>';

					if($tmp1 == 0 and $tmp2 == 0 and $tmp3 == 0 and $tmp4 == 0){
						$this->data['listcontent_row_details_open'][$v['id']] = '　未發放';
					} else {
						$this->data['listcontent_row_details_open'][$v['id']] = '
　發放給會員：'.$tmp1.'張 ，己使用'.$tmp2.'次 <br />
　發放給非會員：'.$tmp3.'張 ，己使用'.$tmp4.'次
';
					}
				}

				if($v['is_enable'] == '1'){
					$v['is_enable'] = '✔';
				} else {
					$v['is_enable'] = '';
				}
				$this->data['listcontent'][$k] = $v;

			}
		}

	}

	protected function update_show_last($updatecontent)
	{
		if(isset($this->data['updatecontent']['func']) and $this->data['updatecontent']['func'] == '1'){
			unset($this->data['def']['updatefield']['sections'][2]);
		} else {
			unset($this->data['def']['updatefield']['sections'][1]);
		}

		// $this->data['def']['updatefield']['sections'][0]['field']['func']['type'] = 'inputn';
		// $this->data['def']['updatefield']['sections'][0]['field']['func']['other']['html'] = $this->data['def']['updatefield']['sections'][0]['field']['func']['other']['values'][$this->data['updatecontent']['func']];

		// $tmp = explode(',', $this->data['updatecontent']['deny_promotion_ids']);
		// $rows = $this->db->createCommand()->from(str_replace('goodies','',$this->data['router_class']).'promotion')->where('is_enable=1')->order('sort_id asc')->queryAll();
		// $groups = array();
		// if($rows){
		// 	foreach($rows as $k => $v){
		// 		$groups[$v['id']]['value'] = $v['name'];
		// 		if(in_array($v['id'], $tmp)){
		// 			//$groups[$v['id']]['is_selected'] = 'selected';
		// 			$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
		// 		}
		// 	}
		// }
		// $this->data['updatecontent']['deny_promotion_ids'] = $groups;

		// $tmp = explode(',', $this->data['updatecontent']['only_promotion_ids']);
		// $rows = $this->db->createCommand()->from(str_replace('goodies','',$this->data['router_class']).'promotion')->where('is_enable=1')->order('sort_id asc')->queryAll();
		// $groups = array();
		// if($rows){
		// 	foreach($rows as $k => $v){
		// 		$groups[$v['id']]['value'] = $v['name'];
		// 		if(in_array($v['id'], $tmp)){
		// 			//$groups[$v['id']]['is_selected'] = 'selected';
		// 			$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
		// 		}
		// 	}
		// }
		// $this->data['updatecontent']['only_promotion_ids'] = $groups;

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

		// 選擇相關產品
		$tmps = explode(',', $this->data['updatecontent']['related_ids']);
		$groups = array();
		if($this->data['related_ids']){
			foreach($this->data['related_ids'] as $k => $v){
				if($k == $this->data['updatecontent']['id']) continue; // 排除掉自己，不然選到自己跟本就是很奇怪
				$groups[$k]['value'] = $v;
				if(in_array($k, $tmps)){
					$groups[$k]['is_selected'] = 'selected'; // multiselect
					//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['related_ids'] = $groups;

		// 相關物件
		//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id!=:id', array(':type'=>'item1',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['updatecontent']['id']))->order('sort_id asc')->queryAll();
		//$rows = $this->db->createCommand()->from(str_replace('goodies','',$this->data['router_class']))->where('is_enable=1')->order('sort_id asc')->queryAll();
		//if($rows and count($rows) > 0){
		//	foreach($rows as $k => $v){
		//		$this->data['def']['updatefield']['sections'][0]['field']['related_ids']['other']['values'][$v['id']] = $v['name'];
		//	}
		//}
		//$tmp2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$this->data['router_class'].'relatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['updatecontent']['id']))->order('sort_id asc')->queryAll();
		//$tmp = array();
		//if($tmp2){
		//	foreach($tmp2 as $k => $v){
		//		$tmp[] = $v['other1'];
		//	}
		//}
		//$groups = array();
		//if($rows){
		//	foreach($rows as $k => $v){
		//		$groups[$v['id']]['value'] = $v['name'];
		//		if(in_array($v['id'], $tmp)){
		//			$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
		//			//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
		//		}
		//	}
		//}
		//$this->data['updatecontent']['related_ids'] = $groups;

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	protected function create_show_last()
	{
		//unset($this->data['def']['updatefield']['sections'][1]); // 優惠券
		//unset($this->data['def']['updatefield']['sections'][2]); // 紅利

		// 相關產品
		$groups = array();
		foreach($this->data['related_ids'] as $k => $v){
			$groups[$k]['value'] = $v;
		}
		$this->data['updatecontent']['related_ids'] = $groups;

		// $rows = $this->db->createCommand()->from(str_replace('goodies','',$this->data['router_class']).'promotion')->where('is_enable=1')->order('sort_id asc')->queryAll();
		// $groups = array();
		// if($rows){
		// 	foreach($rows as $k => $v){
		// 		$groups[$v['id']]['value'] = $v['name'];
		// 	}
		// }
		// $this->data['updatecontent']['deny_promotion_ids'] = $groups;

		// $rows = $this->db->createCommand()->from(str_replace('goodies','',$this->data['router_class']).'promotion')->where('is_enable=1')->order('sort_id asc')->queryAll();
		// $groups = array();
		// if($rows){
		// 	foreach($rows as $k => $v){
		// 		$groups[$v['id']]['value'] = $v['name'];
		// 	}
		// }
		// $this->data['updatecontent']['only_promotion_ids'] = $groups;

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
		//$rows = $this->db->createCommand()->from(str_replace('goodies','',$this->data['router_class']))->where('is_enable=1')->order('sort_id asc')->queryAll();
		//if($rows and count($rows) > 0){
		//	foreach($rows as $k => $v){
		//		$this->data['def']['updatefield']['sections'][0]['field']['related_ids']['other']['values'][$v['id']] = $v['name'];
		//	}
		//}
		//$groups = array();
		//if($rows){
		//	foreach($rows as $k => $v){
		//		$groups[$v['id']]['value'] = $v['name'];
		//	}
		//}
		//$this->data['updatecontent']['related_ids'] = $groups;

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	/*
	 * 這會寫在這裡，是因為它要讀取customer功能當下的搜尋條件
	 */
	public function actionGoodiessend($id)
	{
		$shop_goodies_row = $this->db->createCommand()->from('shopgoodies')->where('is_enable=1 and id=:id',array(':id'=>$id))->queryRow();

		$save = $shop_goodies_row;
		unset($save['id']);
		unset($save['sort_id']);
		unset($save['from_user_id']);
		unset($save['create_time']);
		unset($save['update_time']);
		$save['pid'] = $id;
		$save['from_user_id'] = $this->data['admin_id']; // 誰發放的

		if($shop_goodies_row['func'] == 1){ // 優惠券

			// 沒有提供發放的張數，那就不發
			if($shop_goodies_row['gift_amount'] <= 0){
				$redirect_url = $this->createUrl($this->data['router_class'].'/index');
				G::alert_and_redirect('請先設定好優惠券發放的張數', $redirect_url, $this->data);
			}

			for($x=1;$x<=$shop_goodies_row['gift_amount'];$x++){

				// 要產生序號
				$serial_number = date('YmdHis').$this->randomPassword(6);

				$empty_orm_data = array(
					'table' => 'shopgoodies',
					'created_field' => 'create_time', 
					//'updated_field' => 'update_time',
					'primary' => 'id',
					'rules' => array(
						//array('name, phone, email', 'required'),
					),
				);

				$savedata = $save;
				$savedata['gift_serial_number'] = $serial_number;
				// $savedata['member_id'] = $v['id']; 非會員
				eval($this->data['empty_orm_eval']);
				$u = new $name('insert', $empty_orm_data);
				// 修改專用
				//$u = $c::model()->findByPk($row['id']);
				$u->setAttributes($savedata);
				if(!$u->save()){
					G::dbm($u->getErrors());
				}
				// $id = $this->db->getLastInsertID();
			}

		} elseif($shop_goodies_row['func'] == 2){ // 紅利
			// 紅利不會有非會員的發放哦哦哦
		}

		$redirect_url = $this->createUrl('customer/index');
		G::alert_and_redirect('發放成功', $redirect_url, $this->data);

	}

	protected function update_run_other_element($array)
	{
		$array['pid'] = 0;

		// 相關產品
		if(isset($array['related_ids']) and count($array['related_ids']) > 0){
			$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		} else {
			$array['related_ids'] = '';
		}

		//Ming 2018-12-18 來信 指示 資料更新後，點擊送出後需返回列表頁 ( 所有單元都是 ),設定非資訊部人員才會動作 by lota
		if(!preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
			$array['update_base64_url'] = '';
		}		

		//if(!isset($array['gift_has_no_change_given'])) $array['gift_has_no_change_given'] = 0;
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['pid'] = 0;
		//if(!isset($array['gift_has_no_change_given'])) $array['gift_has_no_change_given'] = 0;

		$array['func'] = 1; // 預設優惠券
		$array['gift_amount'] = 1; // 就只發放1張，別問很可怕

		// 相關產品
		if(isset($array['related_ids']) and count($array['related_ids']) > 0){
			$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		} else {
			$array['related_ids'] = '';
		}

		return $array;
	}

	protected function create_run_last()
	{
		// 相關物件
		//eval($this->data['empty_orm_eval']);
		//$c = new $name('insert', $this->data['def']['empty_orm_data_related']);
		//$c::model()->deleteAll('type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$this->data['router_class'].'relatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['_last_insert_id']));

		//if(isset($_POST['related_ids']) and !empty($_POST['related_ids'])){
		//	$save = array();
		//	foreach($_POST['related_ids'] as $k => $v){
		//		$tmp = array(
		//			'type' => $this->data['router_class'].'relatedids',
		//			'ml_key' => $this->data['admin_switch_data_ml_key'],
		//			'class_id' => $this->data['_last_insert_id'],
		//			'other1' => $v,
		//			'is_enable' => 1,
		//		);
		//		$save[] = $tmp;
		//	}
		//	$this->cidb->insert_batch('html', $save);
		//}

		$shop_goodies_row = $this->db->createCommand()->from('shopgoodies')->where('is_enable=1 and id=:id',array(':id'=>$this->data['_last_insert_id']))->queryRow();

		$save = $shop_goodies_row;
		unset($save['id']);
		unset($save['sort_id']);
		unset($save['from_user_id']);
		unset($save['create_time']);
		unset($save['update_time']);
		$save['pid'] = $this->data['_last_insert_id'];
		$save['from_user_id'] = $this->data['admin_id']; // 誰發放的

		$empty_orm_data = array(
			'table' => 'shopgoodies',
			'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('name, phone, email', 'required'),
			),
		);

		$savedata = $save;
		//$savedata['gift_serial_number'] = $serial_number;
		// $savedata['member_id'] = $v['id']; 非會員
		eval($this->data['empty_orm_eval']);
		$u = new $name('insert', $empty_orm_data);
		// 修改專用
		//$u = $c::model()->findByPk($row['id']);
		$u->setAttributes($savedata);
		if(!$u->save()){
			G::dbm($u->getErrors());
		}
		// $id = $this->db->getLastInsertID();
		
	}

	protected function update_run_last()
	{
		// 相關物件
		//eval($this->data['empty_orm_eval']);
		//$c = new $name('insert', $this->data['def']['empty_orm_data_related']);
		//$c::model()->deleteAll('type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$this->data['router_class'].'relatedids',':ml_key'=>$this->data['admin_switch_data_ml_key'],':id'=>$this->data['id']));

		//if(isset($_POST['related_ids']) and !empty($_POST['related_ids'])){
		//	$save = array();
		//	foreach($_POST['related_ids'] as $k => $v){
		//		$tmp = array(
		//			'type' => $this->data['router_class'].'relatedids',
		//			'ml_key' => $this->data['admin_switch_data_ml_key'],
		//			'class_id' => $this->data['id'],
		//			'other1' => $v,
		//			'is_enable' => 1,
		//		);
		//		$save[] = $tmp;
		//	}
		//	$this->cidb->insert_batch('html', $save);
		//}


			// 參考用的程式碼，從前台複製過來的
			// unset($update['id']);
			// unset($update['create_time']);

			// $update['gift_only_use_count2']++;

			// if($update['gift_only_use_count2'] >= $update['gift_only_use_count']){
			// 	$update['is_enable'] = 0;
			// }
		//2021-1-11 lota fix
		$update = $this->db->createCommand()->from('shopgoodies')->where('id=:id',array(':id'=>$this->data['id']))->queryRow();

		unset($update['id']);
		unset($update['pid']);
		unset($update['gift_only_use_count2']);

		$this->cidb->where('pid',$this->data['id']);
		$this->cidb->update('shopgoodies',$update);
	}

	public function delete_last()
	{
		//2021-01-11 連動刪除鏡像資料
		$this->cidb->where('pid',$this->data['id'])->delete('shopgoodies');
	}

	// 優惠券專用
	// public function actionNumberoutput($param)
	// {
	// 	$id = $param;
	// 	echo '<meta charset="utf-8">';
	// 	$rows = $this->db->createCommand()->from('shopgoodies')->where('pid=:id',array(':id'=>$id))->queryAll();
	// 	if($rows){
	// 		foreach($rows as $k => $v){
	// 			echo $v['gift_serial_number'].'　';

	// 			if($v['is_enable'] == 1){
	// 				echo '未使用';
	// 			} else {
	// 				echo '<span style="color:red"><b>己使用</b></span>';
	// 			}

	// 			if($v['member_id'] > 0){
	// 				echo '　會員 ';
	// 			} else {
	// 				echo '　非會員 ';
	// 			}

	// 			echo '<br />';
	// 		}
	// 	}
	// }

	public function _get_product_classes($data)
	{
		// 取得所有的分類，目標做到2層以上
		$conditions = array(
			'ml_key' => $data['ml_key'],
			'is_enable' => '1',
		);
		//$query = $this->cidb->select('id, class_id, class_name, class_name AS class_name_id')->where($conditions)->get('product_class');
		//$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->get('item1type');
		$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->get(str_replace('goodies','',$this->data['router_class']).'type');
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

	/*
	 * 產生優惠券，並檢查有沒有存在於資料表
	 */
	protected function randomPassword($len=8)
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $len; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		//return implode($pass); //turn the array into a string
		$result = implode($pass); //turn the array into a string

		$row = $this->db->createCommand()->from('shopgoodies')->where('gift_serial_number=:number',array(':number'=>$result))->queryRow();
		if($row or isset($row['id'])){
			// 換一個序號
			$result = $this->randomPassword($len);
		}
		return $result;
	}

	public function actionUpdatefields_multi_select_category_select_dropdown()
	{
        if(!empty($_POST)){
			$this->data['def'] = G::definit($this->def, $this->data);

			$random = $_POST['random']; // 為了可以多個視窗操作，操作SESSION不會出問題的寫法
			$class_id = $_POST['id'];

			// 已選的
			$select_ids = array();
			if(isset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random]) and !empty($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random])){
				foreach($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random] as $k => $v){
					$select_ids[] = $k;
				}
			}

			$in = '';
			if(!empty($select_ids)){
				$in = ' or id in ('.implode(',',$select_ids).') ';
			}

			//$sql = 'select * from '.str_replace('type','',$this->data['def']['table']).' where is_enable=1 and ml_key="'.$this->data['ml_key'].'" and (class_id='.$class_id.' or class_ids like "%,'.$class_id.',%" '.$in.') ';
			$sql = 'select * from shop where is_enable=1 and ml_key="'.$this->data['ml_key'].'" and (class_id='.$class_id.' or class_ids like "%,'.$class_id.',%" '.$in.') ';
			$rows = $this->cidb->query($sql)->result_array();

			$return = '';
			if($rows and !empty($rows)){
				foreach($rows as $k => $v){
					$selected = '';
					if(in_array($v['id'],$select_ids)){
						$selected = ' selected="selected" ';
					}
					$return .= '<option value="'.$v['id'].'" '.$selected.' >'.$v['name'].'</option>';
				}
			}

			echo $return;
			die;
		}
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
