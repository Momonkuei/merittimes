<?php

/*
 * 這個檔案是V1，給內部繼承的範本，不是實體功能
 */

// 懶得改Controller的名稱之一
// $tmps = explode('/',__FILE__);
// $filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('topic'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'topic', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'topic', // 要給sys_log記錄名稱欄位值的設定
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
			'pic1' => array(
				'label' => 'pic1',
				// 'mlabel' => array(
				// 	null, // category
				// 	'Image', // label
				// 	array(), // sprintf
				// 	'代表圖', // default
				// ),
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'topic' => array(
				'label' => 'topic',
				// 'mlabel' => array(
				// 	null, // category
				// 	'Title', // label
				// 	array(), // sprintf
				// 	'標題', // default
				// ),
				'width' => '40%',
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
				'ezshow' => true,

				// 範例
				//'func_dropdown' => array(
				//	'enable' => true,
				//	'url_id' => 'id',
				//	'values' => array(
				//		array('id' => '1', 'name' => '顯示'),
				//		array('id' => '0', 'name' => '停用'),
				//	),
				//	'define' => array(
				//		'id' => 'id',
				//		'name' => 'name',
				//		'is_selected' => 'is_selected',
				//	),
				//),
			),
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader','jquery.datepicker',
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
					'field' => array(
						'topic' => array(
							'label' => 'topic',
							// 'mlabel' => array(
							// 	null, // category
							// 	'Title', // label
							// 	array(), // sprintf
							// 	'標題', // default
							// ),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'url1' => array(
							'label' => 'url1',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'url1',
								'name' => 'url1',
								'size' => '40',
							),
						),
						'pic1' => array(
							'label' => 'pic1：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'pic2' => array(
							'label' => 'pic2：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '2',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'pic3' => array(
							'label' => 'pic3：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '3',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'file1' => array(
							'label' => 'file1：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '4',
								'type' => 'document',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'other1' => array(
							'label' => 'other1',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '40',
							),
						),
						'other2' => array(
							'label' => 'other2',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '40',
							),
						),
						'other3' => array(
							'label' => 'other3',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
								'size' => '40',
							),
						),
						'other4' => array(
							'label' => 'other4',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other4',
								'name' => 'other4',
								'size' => '40',
							),
						),
						'other5' => array(
							'label' => 'other5',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other5',
								'name' => 'other5',
								'size' => '40',
							),
						),
						'other6' => array(
							'label' => 'other6',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other6',
								'name' => 'other6',
								'size' => '40',
							),
						),
						'other7' => array(
							'label' => 'other7',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other7',
								'name' => 'other7',
								'size' => '40',
							),
						),
						'other8' => array(
							'label' => 'other8',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other8',
								'name' => 'other8',
								'size' => '40',
							),
						),
						'other9' => array(
							'label' => 'other9',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other9',
								'name' => 'other9',
								'size' => '40',
							),
						),
						'other10' => array(
							'label' => 'other10',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other10',
								'name' => 'other10',
								'size' => '40',
							),
						),
						'video_1' => array(
							'label' => 'video_1',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'video_1',
								'name' => 'video_1',
								'size' => '40',
							),
						),
						'video_2' => array(
							'label' => 'video_2',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'video_2',
								'name' => 'video_2',
								'size' => '40',
							),
						),
						'video_3' => array(
							'label' => 'video_3',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'video_3',
								'name' => 'video_3',
								'size' => '40',
							),
						),
						'video_4' => array(
							'label' => 'video_4',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'video_4',
								'name' => 'video_4',
								'size' => '40',
							),
						),
						'start_date' => array(
							'label' => 'start_date',
							// 'mlabel' => array(
							// 	null, // category
							// 	'Date', // label
							// 	array(), // sprintf
							// 	'日期', // default
							// ),
							'type' => 'input',
							'attr' => array(
								'id' => 'start_date',
								'name' => 'start_date',
								'size' => '10',
								'readonly' => 'readonly',
							),
						),
						'end_date' => array(
							'label' => 'end_date',
							// 'mlabel' => array(
							// 	null, // category
							// 	'Date', // label
							// 	array(), // sprintf
							// 	'日期', // default
							// ),
							'type' => 'input',
							'attr' => array(
								'id' => 'end_date',
								'name' => 'end_date',
								'size' => '10',
								'readonly' => 'readonly',
							),
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
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						'detail' => array(
							'label' => 'detail',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
						'field_data' => array(
							'label' => 'field_data',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'field_data',
								'name' => 'field_data',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
						'field_tmp' => array(
							'label' => 'field_tmp',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'field_tmp',
								'name' => 'field_tmp',
								//'rows' => '4',
								//'cols' => '40',
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
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// if(isset($GLOBALS['lay_out_select']) && $GLOBALS['lay_out_select']!=1){
		// 	unset($this->def['listfield']['is_home']);
		// 	unset($this->def['updatefield']['sections'][0]['field']['pic2']);
		// 	unset($this->def['updatefield']['sections'][1]['field']['field_tmp']);
		// }

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		return true;
	}

	protected function index_last($param='')
	{
		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				$this->data['listcontent'][$k] = $v;
			}
		}
	}

	protected function update_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	// 擴展的測試
	// protected function update_show_first($params)
	// {
	// 	parent::update_show_first($params);
	// }

}

// 懶得改Controller的名稱之三
// eval('class '.$filename.' extends NonameController {}');
