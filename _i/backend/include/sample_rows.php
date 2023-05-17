<?php

/*
 * 2020-02-10
 */
// require_once('phpSpreadsheet/autoload.php');
// 
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// 這裡維持註解
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xls;
// use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
// use PhpOffice\PhpSpreadsheet\Cell\DataType;
// use PhpOffice\PhpSpreadsheet\Style\Fill;
// use PhpOffice\PhpSpreadsheet\Style\Color;
// use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Style\Border;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// 懶得改Controller的名稱之一
// $tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
// $filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

		// 在各功能的上面的新增的右邊(匯出功能之一)
		// 'index_buttons' => array(
		// 	array(
		// 		'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
		// 		'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
		// 		'id' => '', // button
		// 		'class' => 'btn btn-info', // button
		// 		// 'onclick' => 'javascript:location.href=\'XXX\'',
		//		'onclick' => 'javascript:location.href=\'backend.php?r=newsletter/excelexport2\'',
		// 	),
		// ),

		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				// array('topic', 'required'),
				// array('detail', 'system.backend.extensions.myvalidators.numericcodeutf8'),
				// array('start_date', 'date', 'format'=>'yyyy-M-d'),
				// array('phone','numerical','integerOnly'=>true),
			),
		),
		'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'XXX', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('XXX'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'XXX', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'XXX', // 要給sys_log記錄名稱欄位值的設定
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
		//'func_field' => array(
		//	'id' => 'id',
		//	'sort_id' => 'sort_id',
		//),
		// 建立前端要顯示的欄位
		// 'listfield_attr' => array(
		// 	'smarty_include_top' => '', // product/main_content_top.htm
		// 	'smarty_include_top_text' => '', // 請用eval能夠接受的內容，內容結尾記得echo
		// ),
		'listfield' => array(
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'xx_id' => array(
				'label' => 'Number ID',
				'translate_source' => 'en',
				'width' => '5%',
				'align' => 'center',
				//'ezdelete' => true,
			),
			'pic1' => array(
				'label' => 'Image',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Image', // label
				//	array(), // sprintf
				//	'代表圖', // default
				//),
				'width' => '6%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'topic' => array(
				'label' => 'Heading',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '45%',
				'sort' => true,
			),
			'name' => array(
				'label' => 'Caption',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				'sort' => true,
			),
			'xx2' => array(
				'label' => '分類',			
				'translate_source' => 'tw',
				'width' => '8%',
				'sort' => false,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面
				'width' => '',
			),
			
			//'other1' => array(
			//	'label' => '說明',
			//	'width' => '30%',
			//	'sort' => true,
			//),
			//'start_date' => array(
			//	'label' => '日期',
			//	'width' => '15%',
			//	'sort' => true,
			//),
			//'is_news' => array(
			//	//'label' => 'ml:Sort id',
			//	'mlabel' => array(
			//		null, // category
			//		'Show News', // label
			//		array(), // sprintf
			//		'顯示在快訊', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//	'ezfield' => 'is_news',
			//	'ezother'=> '&nbsp;',
			//),
			// 'is_home' => array(
			// 	'label' => '首頁',
			// 	'width' => '10%',
			// 	'align' => 'center',
			// 	'ezfield' => 'is_home',
			// 	'ezother'=> '&nbsp;',
			// 	'func_checkbox' => array(
			// 		'enable' => true,
			// 		'define' => array(
			// 			'id' => 'id',
			// 			'text' => '&nbsp;',
			// 			'limit' => '0',
			// 			'reload' => '0',
			// 			'alert' => '',
			// 		),
			// 	),
			// ),
			//'is_top' => array(
			//	'label' => '置頂',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'ezfield' => 'is_top',
			//	'ezother'=> '&nbsp;',
			//),	
			'reserve_date' => array(
				'label' => '預約發布日期',
				'translate_source' => 'tw',
				'width' => '5%',
				'sort' => true,
				'align' => 'center',
			),		
			'retirement_date' => array(
				'label' => '下架日期',
				'translate_source' => 'tw',
				'width' => '5%',
				'sort' => true,
				'align' => 'center',
			),		
			'xx02' => array(
				'label' => '預覽連結',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'url_id' => 'preview',
				'width' => '4%',
				'align' => 'center',
				'sort' => true,
			),
			'is_enable' => array(
				//'label' => 'ml:Status',
				'label' => '狀態',
				'translate_source' => 'tw',
				'width' => '5%',
				'align' => 'center',
				'ezshow' => true,
				// 'func_bootstrap-switch' => array(
				// 	'enable' => true,
				// 	'define' => array(
				// 		'id' => 'id',
				// 		'name' => 'name',
				// 	),
				// ),
				// 'func_dropdown' => array(
				// 	'enable' => true,
				// 	'values' => array(
				// 		array('id' => '1', 'name' => '顯示'),
				// 		array('id' => '0', 'name' => '停用'),
				// 	),
				// 	'define' => array(
				// 		'id' => 'id',
				// 		'name' => 'name',
				// 		'is_selected' => 'is_selected',
				// 	),
				// ),
			),
			'start_date' => array(
				'label' => '日期',
				'translate_source' => 'tw',
				'width' => '4%',
				'sort' => true,
			),
			'sort_id' => array(
				//'label' => 'ml:Sort id',
				'label' => '排序',
				'translate_source' => 'tw',
				'width' => '4%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		'searchfield' => array(
			// jquery-validate, jquery.datepicker
			'head' => array(
				'jquery-validate',
			),
			'smarty_javascript' => '', // product/update_javascript.htm
            'smarty_javascript_text' => "
// $.datepicker.regional['zh-TW'] = {
//     closeText: '關閉',
//     prevText: '&#x3c;上月',
//     nextText: '下月&#x3e;',
//     currentText: '今天',
//     monthNames: ['一月','二月','三月','四月','五月','六月',
//     '七月','八月','九月','十月','十一月','十二月'],
//     monthNamesShort: ['一','二','三','四','五','六',
//     '七','八','九','十','十一','十二'],
//     dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
//     dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
//     dayNamesMin: ['日','一','二','三','四','五','六'],
//     weekHeader: '周',
//     dateFormat: 'yy/mm/dd',
//     firstDay: 1,
//     isRTL: false,
//     showMonthAfterYear: true,
//     yearSuffix: '年'};
// $.datepicker.setDefaults($.datepicker.regional['zh-TW']);

// 日期搜尋
// $('#start_date').datepicker({dateFormat: 'yy-mm-dd'});
// $('#end_date').datepicker({dateFormat: 'yy-mm-dd'});
            ",
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
							'label' => '標題',
							'translate_source' => 'tw',
							'type' => 'input',
							'attr' => array(
								'id' => 'keyword',
								'name' => 'keyword',
								'size' => '40',
							),
						),
						'class_id' => array(
							'label' => '分類',
							'translate_source' => 'tw',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'-1' => '請選擇',
								),
								'default' => '',
							),
						),
                        // 'start_date' => array(
                        //     'label' => '日期',
                        //     'type' => 'input',
                        //     'merge' => '1',
                        //     'attr' => array(
                        //         'id' => 'start_date',
                        //         'name' => 'start_date',
                        //         'size' => '10',
                        //         'readonly' => 'readonly',
                        //     ),
                        // ),
                        // 'end_date' => array(
                        //     'label' => ' ∼ ',
                        //     'type' => 'input',
                        //     'merge' => '3',
                        //     'attr' => array(
                        //         'id' => 'end_date',
                        //         'name' => 'end_date',
                        //         'size' => '10',
                        //         'readonly' => 'readonly',
                        //     ),
                        // ),
					),
				),
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader','jquery.datepicker',
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
						'name' => array(
							'label' => '標題',
							'translate_source' => 'tw',
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
						'topic' => array(
							'label' => '標題',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'class_id' => array(
							'label' => '分類',
							'translate_source' => 'tw',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '',
							),
						),
						'class_ids' => array(
							'label' => '複選分類',
							'translate_source' => 'tw',
							'type' => 'treeselect',
							'attr' => array(
								'id' => 'class_ids',
								'name' => 'class_ids',
							),
							'other' => array(
								//'pid' => 'class_id',
							),
						),						
						'_contentbuilder' => array(
							'label' => '',
							'type' => 'inputn',
							'other' => array(
								'html'=>'<div class="control-box"><button type="button" id="htmlbtn" onclick="openif(\'detail\')">+ 加入範本</button><input type="hidden" id="ctidx" value=""><div id="ctarea" style="display: none;" ></div>',	
							),
						),						
						//'other1' => array(
						//	'label' => '說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'other1',
						//		'name' => 'other1',
						//		'size' => '40',
						//	),
						//),
						//'url1' => array(
						//	'label' => '網址',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'url1',
						//		'name' => 'url1',
						//		'size' => '40',
						//	),
						//),
						
						// 'pic1' => array(
						// 	'label' => '圖片上傳：',
						// 	'type' => 'fileuploader',
						// 	'other' => array(
						// 		'number' => '1',
						// 		'type' => 'photo',
						// 		'top_button' => '1',
						// 		'width' => '360',
						// 		'height' => '220',
						// 		'comment_size' => '360x220',
						// 		'no_ext' => '',
						// 		'no_need_delete_button' => '',
						// 	),
						// ),
						// 'sort_id' => array(
						// 	//'label' => 'ml:Sort',
						// 	'label' => '排序',
						// 	'translate_source' => 'tw',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Sort', // label
						// 	//	array(), // sprintf
						// 	//	'排序', // default
						// 	//),
						// 	'type' => 'sort',
						// 	'attr' => array(
						// 	),
						// ),
						'start_date' => array(
							'label' => '日期',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Date', // label
							//	array(), // sprintf
							//	'日期', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'start_date',
								'name' => 'start_date',
								'size' => '10',
								'readonly' => 'readonly',
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
						// 'reserve_date' => array(
						// 	'label' => '預約發布日期',
						// 	'translate_source' => 'tw',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Date', // label
						// 	//	array(), // sprintf
						// 	//	'日期', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'reserve_date',
						// 		'name' => 'reserve_date',
						// 		'size' => '10',
						// 		'readonly' => 'readonly',
						// 	),
						// ),
					),
				),
				// funcfieldv3的產出欄位，放在任何位置都可以
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
					),
				),
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '2',
				// 	'field' => array(
				// 		'field_tmp' => array(
				// 			'label' => '描述',
				// 			'type' => 'textarea',							
				// 			'attr' => array(
				// 				'class' => 'form-control', // 這…手動加上去好了
				// 				'id' => 'field_tmp',
				// 				'name' => 'field_tmp',
				// 				'rows' => '4',
				// 				'cols' => '100',
				// 			),
				// 		),
				// 		'detail' => array(
				// 			'label' => '內容',
				// 			//'type' => 'textarea',
				// 			'type' => 'ckeditor_js',
				// 			'attr' => array(
				// 				//'class' => 'form-control', // 這…手動加上去好了
				// 				'id' => 'detail',
				// 				'name' => 'detail',
				// 				//'rows' => '4',
				// 				//'cols' => '40',
				// 			),
				// 		),
				// 	),
				// ),
				// 商品複製，這個是固定的，排在第三個位置
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'name' => array(
							'label' => '名稱',
							'translate_source' => 'tw',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'name',
							//	'name' => 'name',
							//	'size' => '40',
							//),
						),
						'topic' => array(
							'label' => '名稱',
							'translate_source' => 'tw',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'name',
							//	'name' => 'name',
							//	'size' => '40',
							//),
						),
						'class_id' => array(
							'label' => '分類',
							'translate_source' => 'tw',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '',
							),
						),
						'is_copy' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'is_copy',
							),
						),
					),
				),
				// 這是SEO欄位的範本，如果你需要，就打開它 1/4
				// *第二版的放在任何位置都可以，只要記得加上一個元素_has_seov2 => true就可以了
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_seov2' => true,
					'field' => array(
					),
				),
				// funcfieldv3的自定欄位，放在任何位置都可以
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_custom' => true, // 要記得這個要加
					'field' => array(
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		
		parent::beforeAction($action);		
		// 2020-08-26 A方案的客制功能專用
		if(0){
			$this->data['rowg_custom'] = array(
				'topic' => '主選單名稱', // 標題
				'other1' => '', // 頁面pageTitle的旁邊

				'url1' => '', // 網址，例如news_tw.php

				'is_home' => 1, // 動態次選單

				'pic2' => 1, // 分類
					'is_news' => 1, // 通用分類
					'other22' => '', // 自訂分類名稱
					'other10' => 0, // 分類下有分項
				'class_ids' => 1, // 通用分項
				'is_top' => 0, // 單頁
				'pic3' => 0, // 日期排序
				'other24' => 0, // 下架時間

				/*
				 * 其它選項
				 */
				'other15' => 1, // 無限層的分類層數限制(1~15)

				// 列表頁
				// '0' => '無 (有分類: 轉頁到第一個分類, 無分類: 空白)',
				// '1' => '顯示所有物件 (總覽頁)',
				// '2' => '頂層分類列表',
				'other5' => 0,

				'other6' => 5, // 每頁幾筆(預設5筆)

				// http://redmine.buyersline.com.tw:4000/issues/18231#note-40
				// 關鍵字：enableurl_by_subclass_haschild
				// 有次分類的分類，連結有效 (如果 點擊分類的動作 不是 預設 的時候，就要打勾)
				'other12' => 0,

				// 點擊分類的動作
				// '0' => '顯示當層物件 (預設)',
				// '1' => '顯示當層分類，如果是最末層則顯示物件',
				// '2' => '遞迴顯示該層底下的物件 (含自己) *有參數',
				// '3' => '顯示當層的分類與物件 *還沒寫',
				'other13' => 0,

				'other14' => '', // 遞迴搜尋目標(預設 v3/default/sidemenu_empty_datasource)
				//'other21' => '', // 頂層分類升級(只適用於獨立分類 > 2) * 這個應該用不到

				/*
				 * 後台功能
				 */
				'other18' => 0, // 獨立功能的大分類可否被選(0=>不想回答，1=>可，2=>不可)
				'other25' => '', // [節點] 父節點 router class 名稱
				'other27' => 0, // [節點] 是否為通用

				/*
				 * 功能連結
				 */
				'other26' => 0, // 切換成"多分類排序" (預設單分類排序) 相依通用、或是獨立資料表

				// 內頁大圖
				// '0' => '不干涉 (規則A)',
				// '1' => '功能導向 (規則B)',
				// '2' => '鎖定編號 (規則B)',
				// '3' => '編號繼承 (規則B)',
				'other11' => 0,
			);
		}

		// 只有 設計/資訊 ，看得到拖拉範本
		if(!preg_match('/^(999994|999995)/', $this->data['admin_type'])){
			unset($this->def['updatefield']['sections'][0]['field']['_contentbuilder']);
		}else{
			//拖拉樣版的基本框架
			if(isset($this->data['BODY_END'])){
				$this->data['BODY_END'] .= '<iframe name="cbiframe" id="cbiframe" style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; border: 0px;display: none;"  src="" ></iframe><script type="text/javascript" src="/_i/assets/contenvuilder.js"></script>';
			}else{
				$this->data['BODY_END'] = '<iframe name="cbiframe" id="cbiframe" style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; border: 0px;display: none;"  src="" ></iframe><script type="text/javascript" src="/_i/assets/contenvuilder.js"></script>';
			}
		}
		// 2018-08-29 分項節點(1/3) 子
		// 先做第一次的檢查
		// param={value 索引值}__{parent router_class}__{child router_class}__{child field_name}
		$ss = $this->data['router_class'].'_node';
		$session_node = Yii::app()->session[$ss];
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('type =:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if($rowg and isset($rowg['other25']) and $rowg['other25'] != ''){
			if(isset($session_node['value']) and $session_node['value'] > 0){
				$is_html = true; // 通用資料表為預設
				if($rowg){ 
					// 上一層，是獨立資料表？還是通用資料表？
					if(isset($rowg['other27']) and $rowg['other27'] == 0){ // 獨立分項
						$is_html = false;
					}
				}

				// 找上一層的標題名稱
				if($is_html){
					$row = $this->cidb->select('*, topic as name')->where('is_enable',1)->where('type',$session_node['parent'])->where('id',$session_node['value'])->get('html')->row_array();
				} else {
					$row = $this->cidb->where('is_enable',1)->where('id', $session_node['value'])->get($session_node['parent'])->row_array();
				}

				// 如果上一層是獨立分類，記得要在後台的前台主選單裡面，建立XXXtype_{ml_key}.php
				$rowg_parent = $this->db->createCommand()->from('html')->where('type =:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$session_node['parent'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();

				if($row and isset($row['id'])){
					// $this->def['title'] = $row['topic'];
					$this->data['main_content_title'] = '<a href="backend.php?r='.$session_node['parent'].'">'.$rowg_parent['topic'].'</a> / <a href="backend.php?r='.$session_node['parent'].'/update&param=v'.$session_node['value'].'">'.$row['name'].'</a> / '.$rowg['topic'];
				}
			} else {
				// G::alert_and_redirect(G::t(null,'請先搜尋客戶資料'), '/_i/backend.php?r=personalcustomer/index', $this->data);
				header('Location: backend.php?r='.$rowg['other25']);
				die;
			}
		}
		
		$product_table = $this->data['router_class'];
		//$product_table = str_replace('homesort', '', $product_table); // 為了支援產品的首頁排序

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// (匯出功能之二)
		// $this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/excelexport').'\'';

		// 商品複製 copy
		if(isset($_GET['param'])){
			$parameter = new Parameter_handle;
			$params = $parameter->get($_GET['param']);
			if(isset($params['value'][1]) and $params['value'][1] and $params['value'][1] == 'copy'){
				$ggg = $this->def['updatefield']['sections'][2];
				$this->def['updatefield']['sections'] = array();
				$this->def['updatefield']['sections'][] = $ggg;
			} else {
				unset($this->def['updatefield']['sections'][2]);
			}
		}

		//2016/1/29 lota 如果是反向排序，則將箭頭對調
		if(isset($this->def['default_sort_direction']) && $this->def['default_sort_direction']=='desc'){
				$this->def['listfield_attr']['smarty_include_top_text'] = '
$aaa_xxx = <<<XXX
<script type="text/javascript">
$(document).ready(function() {
	$(".sortImg").each(function(){
		if($(this).attr(\'src\')==\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_down.gif\')
			$(this).attr(\'src\',\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_up.gif\');
		else if($(this).attr(\'src\')==\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_up.gif\')
			$(this).attr(\'src\',\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_down.gif\');
	});
});
</script>
XXX;
echo str_replace(\'BACKEND_ASSETSURL_DOMAIN\',BACKEND_ASSETSURL_DOMAIN,$aaa_xxx);
';
		}

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if($rowg){ 
			if(isset($rowg['pic3']) and $rowg['pic3'] == 1){ // 有日期排序的情況下
				// do nothing
				unset($this->def['listfield']['sort_id']);
				unset($this->def['updatefield']['sections'][0]['field']['sort_id']);
				$this->def['default_sort_field'] = 'start_date';
			}else if(isset($rowg['other24']) and $rowg['other24'] == 1){
				//2023/01/18  增加 用date1排序的功能 ps.最新消息單元等
				unset($this->def['listfield']['start_date']);
				if(isset($this->def['updatefield']['sections'][0]['field']['start_date'])){
					unset($this->def['updatefield']['sections'][0]['field']['start_date']);
				}
				unset($this->def['listfield']['sort_id']);
				unset($this->def['updatefield']['sections'][0]['field']['sort_id']);
				$this->def['default_sort_field'] = 'date1 desc,id ';	
			} else { // 2018-01-11
				unset($this->def['listfield']['start_date']);
				if(isset($this->def['updatefield']['sections'][0]['field']['start_date'])){
					unset($this->def['updatefield']['sections'][0]['field']['start_date']);
				}
				//2021-07-02 嘗試優化初次列表畫面的排序 by lota
				if(isset($rowg['pic2']) and $rowg['pic2'] == 0){ // 資料流沒分類 全部都用 sort_id
					$this->def['default_sort_field'] = 'sort_id';
					if(isset($this->def['default_sort_direction'])){
						unset($this->def['default_sort_direction']);
					}
				}else{					
					$ss = $this->data['router_class'].'_search';
					$session = Yii::app()->session[$ss];					
					if(isset($session) && count($session) > 0){ // 如果有搜尋狀況下
						$this->def['default_sort_field'] = 'sort_id';
						if(isset($this->def['default_sort_direction'])){
							unset($this->def['default_sort_direction']);
						}
					}else{						
						$this->def['default_sort_field'] = 'id';	
						unset($this->def['listfield']['sort_id']);					
					}
				}
			}

			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$this->def['table'] = 'html';
				$this->def['empty_orm_data']['table'] = 'html';
				$this->def['empty_orm_data']['rules'][] = array('topic','required');

				$this->def['search_keyword_field'] = array('topic');
				$this->def['search_keyword_assign_field'] = 'topic';
				$this->def['sys_log_name'] = 'topic';

				unset($this->def['listfield']['name']);
				unset($this->def['updatefield']['sections'][0]['field']['name']); // update, copy
			} else {
				$this->def['table'] = $product_table;
				$this->def['empty_orm_data']['table'] = $product_table;
				$this->def['empty_orm_data']['rules'][] = array('name','required');

				$this->def['search_keyword_field'] = array('name');
				$this->def['search_keyword_assign_field'] = 'name';
				$this->def['sys_log_name'] = 'name';

				unset($this->def['listfield']['topic']);
				unset($this->def['updatefield']['sections'][0]['field']['topic']); // update, copy
			}

			if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類

				if(isset($rowg['other26']) and $rowg['other26'] == 1){ // 是否為“多分類排序”
					unset($this->def['updatefield']['sections'][0]['field']['class_id']);
					unset($this->def['listfield']['xx2']);
				} else {
					$this->def['empty_orm_data']['rules'][] = array('class_id', 'required');
				}

				if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類

					$type_name = $this->data['router_class'].'type';
					if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
						$type_name = $rowg['other22'];
					}

					$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$type_name,':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
					if($rows and !empty($rows)){
						foreach($rows as $k => $v){
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
						}
					}

					if(isset($rowg['other26']) and $rowg['other26'] == 1){ // 是否為“多分類排序”
						$this->def['updatefield']['sections'][0]['field']['class_ids']['other']['name'] = 'topic';
					}
				} else { // 是獨立分類
					// 這裡是從產品那邊複製過來的
				
					// 分類
					$producttype_table = $this->data['router_class'];
					//$producttype_table = str_replace('homesort', '', $producttype_table); // 為了支援產品的首頁排序(這是homesort的另一支後台功能在用的，註解不要打開)
					$producttype_table .= 'type';

					if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
						$producttype_table = $rowg['other22'];
					}

					$rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
					if($rows and !empty($rows)){
						foreach($rows as $k => $v){
							if(isset($rowg['other18']) and $rowg['other18'] == 1){
								// 大分類可選
								$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
								$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
							} elseif(isset($rowg['other18']) and $rowg['other18'] == 2){
								// 大分類不可選
								$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
								$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
							}

							// 剩餘子層的處理程序
							$data_1 = $this->layout_show($v['id'],1,'　',$producttype_table);//'　└'	
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;
						}
					}
				}
			} else { // 無分類			
				// $this->def['enable_index_advanced_search'] = false;
				// unset($this->def['searchfield']);
				unset($this->def['searchfield']['sections'][0]['field']['class_id']);

				unset($this->def['updatefield']['sections'][0]['field']['class_id']);
				unset($this->def['listfield']['xx2']);
			}
		} else {
			// 沒有跟webmenu掛勾的，這個欄位就不用了，需要的話，自行在funcfieldv3使用
			unset($this->def['updatefield']['sections'][0]['field']['start_date']);
		} // if row

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 帶入今天日期
		// 這是最新消息功能在使用的
		if($this->data['router_method'] == 'create'){
			$date = date('Y-m-d');
			if(isset($this->def['updatefield']['sections'][0]['field']['start_date'])){
				$this->def['updatefield']['sections'][0]['field']['start_date']['attr']['value'] = $date;
			}
		}
		
		// 2017-04-28 乖哥說，不同的比例，圖片的最小預設值是不一樣的
		if(file_exists('backend/include/image_size_comment.php')){
			include 'backend/include/image_size_comment.php';
		}

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		// 2018-10-18
		// 如果有下關鍵字，那就取消分類的搜尋，並且取消托拉排序
		// http://redmine.buyersline.com.tw:4000/issues/29538?issue_count=81&issue_position=2&next_issue_id=29493&prev_issue_id=29561#note-1
		// if(isset($session['keyword']) and $session['keyword'] != ''){
		// 	unset($session['class_id']);
		// 	unset($this->def['listfield']['sort_id']);
		// 	$this->def['default_sort_field'] = 'id';
		// }

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';

		// 2018-08-29 分項節點(2/3) 子
		// 加入搜尋條件
		// param={value 索引值}__{parent router_class}__{child router_class}__{child field_name}
		$ss = $this->data['router_class'].'_node';
		$session_node = Yii::app()->session[$ss];
		unset($rowg2);
		if(isset($this->data['rowg_custom'])){
			$rowg2 = $this->data['rowg_custom'];
		} else {
			$rowg2 = $this->db->createCommand()->from('html')->where('type =:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if(isset($rowg2['other25']) and $rowg2['other25'] != ''){
			if(isset($session_node['value']) and $session_node['value'] > 0){
				$session[$session_node['field']] = $session_node['value'];
			}
		}

		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
				$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
			} else {
				$condition = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
				$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
			}
		} else {
			/*
			 * 2018-01-31
			 * 後台的前台選單的該功能裡面，沒有勾選動態次選單的情況下
			 * 預設是沒有分類的通用分項，並且沒有日期排序
			 */

			// 自定條件
			// $condition = ' 1 ';
			// $condition_sortable = ' 1 ';

			// 沒有日期排序
			unset($this->def['listfield']['start_date']);
			$this->def['default_sort_field'] = 'sort_id';
			if(isset($this->def['default_sort_direction'])){
				unset($this->def['default_sort_direction']);
			}

			// 通用分項
			$this->def['table'] = 'html';
			$this->def['empty_orm_data']['table'] = 'html';
			$this->def['empty_orm_data']['rules'][] = array('topic','required');
			$this->def['search_keyword_field'] = array('topic');
			$this->def['search_keyword_assign_field'] = 'topic';
			$this->def['sys_log_name'] = 'topic';
			unset($this->def['listfield']['name']);
			unset($this->def['updatefield']['sections'][0]['field']['name']); // update, copy

			// 沒有分類
			// $this->def['enable_index_advanced_search'] = false;
			// unset($this->def['searchfield']);
			unset($this->def['searchfield']['sections'][0]['field']['class_id']);

			unset($this->def['updatefield']['sections'][0]['field']['class_id']);
			unset($this->def['listfield']['xx2']);

			// 通用分項
			$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
			$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		}
		// #46369 社群分享--撈資料
		if($this->data['router_class']=='community'){
			//線上捐款未開啟 不出現
			$condition = ' type=\'webmenu\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' and is_enable=1 ';
			$condition_sortable = ' type="webmenu" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" and is_enable=1 ';
			unset($_constant);
			eval('$_constant = '.strtoupper('product_content').';');
			if(!$_constant){
				$condition .=' and id!=\'4921\' ';
				$condition_sortable.=' and id!=\'4921\' ';
			}
			
			foreach($this->def['listfield'] as $k => $v){
				if($v['label']=='狀態' || $v['label']=='排序' || $v['label']=='Number ID'){
					unset($this->def['listfield'][$k]);
				}
			}
			foreach($this->def['updatefield']['sections'][0]['field'] as $k => $v){
				if($v['label']=='狀態'){
					unset($this->def['updatefield']['sections'][0]['field'][$k]);
				}
			}
			$this->def['updatefield']['sections'][0]['field']['topic']['attr']=array('id' => 'keyword','name' => 'keyword','size' => '40','disabled'=>'disabled');
			$this->def['disable_create']=true;
			$this->def['disable_delete']=true;
			$this->def['enable_delete']=false;
		}
		if(isset($rowg['other26']) and $rowg['other26'] == 1){ // 是否為“多分類排序”
			// do nothing
		} else {
			unset($this->def['updatefield']['sections'][0]['field']['class_ids']);
		}

		// 2020-08-19
		// 供新增的時候使用，新增的資料要在第一筆
		$this->data['origin_condition'] = array();
		if(trim($condition) != ''){
			$this->data['origin_condition'][0] = array(
				'where',
				$condition,
			);
		}

		if(isset($session) and !empty($session)){
			//2016/4/29 如果有下搜尋條件，則設定排序為sort_id
			//$this->def['default_sort_field'] = 'sort_id';//2016/6/15 捨棄，改用index_first()內的方式

			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					if(isset($rowg['other26']) and $rowg['other26'] == 1){ // 是否為“多分類排序”
						// [多分類排序]
						$conditions[] = 'class_ids LIKE \'%,'.$v.',%\''; // 因為condition的部份要特別處理
						$conditions_sortable[] = 'class_ids LIKE "%,'.$v.',%"';
					} else {
						// 單分類排序
						$conditions[] = $k.'='.$v;
						$conditions_sortable[] = $k.'='.$v;
					}
				} elseif(preg_match('/^(id|sort_id|sort_id_browser|sort_id_home|is_news|is_top|is_home|is_enable)$/', $k)){ // 2020-01-22
					$conditions[] = $k.'='.$v;
					$conditions_sortable[] = $k.'='.$v;
				// 2018-10-18
				// http://redmine.buyersline.com.tw:4000/issues/29538?issue_count=81&issue_position=2&next_issue_id=29493&prev_issue_id=29561#note-1
				} elseif($k == 'keyword'){
					if($rowg){
						if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
							$k = 'topic';
						} else {
							$k = 'name';
						}
					} else {
						$k = 'topic';
					}
					$conditions[] = $k.' LIKE \"%'.$v.'%\"';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				} else {
					$conditions[] = $k.' LIKE \"%'.$v.'%\"';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				// print_r($conditions);
				// die;
			}
			if(!empty($conditions)){
				if(trim($condition) != ''){
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
			if(!empty($conditions_sortable)){
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
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			if(trim($condition_sortable) != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
		}
		// 這是SEO的欄位的範本，如果你需要，就打開它 2/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') && $_constant ){
			$seo_func = 'a';
			include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
		}

		// 2018-03-29 調整內頁的說明欄位寬度
		unset($ggg);
		if(isset($this->def['updatefield']['sections'][0]['field']) and !empty($this->def['updatefield']['sections'][0]['field'])){
			foreach($this->def['updatefield']['sections'][0]['field'] as $ggg => $aaa){
				break;
			}
			$this->def['updatefield']['sections'][0]['field'][$ggg]['attr_td1'] = array('width' => '160');
		}
		unset($ggg);
		if(isset($this->def['updatefield']['sections'][1]['field']) and !empty($this->def['updatefield']['sections'][1]['field'])){
			foreach($this->def['updatefield']['sections'][1]['field'] as $ggg => $aaa){
				break;
			}
			$this->def['updatefield']['sections'][1]['field'][$ggg]['attr_td1'] = array('width' => '160');
		}
		// print_r($this->def['listfield']);die;
		//2022/11/1 #45907 最新消息增加發布日期
		if(stristr($this->data['router_class'],'news') && !stristr($this->data['router_class'],'other')){
			$reserve_data = $this->db->createCommand()->from('sys_config')->where('keyname=:keyname', array(':keyname'=>'function_constant_news_reserve'))->queryRow();
			if($reserve_data['keyval']=='false'){
				unset($this->def['listfield']['reserve_date']);
				unset($this->def['listfield']['retirement_date']);
				unset($this->def['updatefield']['sections'][1]['field']['reserve_date']);
				unset($this->def['updatefield']['sections'][1]['field']['retirement_date']);
			}
		}else{
			unset($this->def['listfield']['reserve_date']);
			unset($this->def['listfield']['retirement_date']);
			unset($this->def['listfield']['xx02']);
			// unset($this->def['updatefield']['sections'][1]['field']['reserve_date']);
		}

		return true;
	}
	//2022/11/1 #45907 最新消息增加預覽連結
	public function actionPreview()
	{
		if(!isset($params['prev']) or $params['prev'] == ''){
			$params['prev'] = $this->data['current_base64_url'];
		}
		
		$id = $_GET['param']; // ID
		$num=explode('/',$_SERVER['QUERY_STRING']);
		$num=str_replace('r=news','',$num[0]);
		$rowg = $this->cidb->where('id',$id)->where('type','news'.$num)->where('ml_key',$this->data['admin_switch_data_ml_key'])->get('html')->result_array();
		$url=str_replace('_i','',$this->data['base_url']);
		$url=$url.'news'.$num.'detail_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$rowg[0]['id'];
		header("Location: $url", TRUE, 301);
		die;

	}
	protected function index_first($param='')
	{
		// 2020-09-09
		// 是否有點選欄位排序的情況，先準備好，供下面去做判斷
		$has_default_orderby_condition = true;
		if($this->data['sort_field_nobase64'] != $this->def['default_sort_field']){
			$has_default_orderby_condition = false;
		}
		
		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1 and isset($rowg['pic3']) and $rowg['pic3'] != 1){ // 有分類，而且不是日期排序
			
			$class_id = 0;

			//節點帶進來的分類ID(等待有緣人驗證) by lota fix 2021-10-28
			if(isset($_SESSION[$this->data['router_class'].'_node']['field']) and $_SESSION[$this->data['router_class'].'_node']['field'] == 'class_id' and isset($_SESSION[$this->data['router_class'].'_node']['value']) && $_SESSION[$this->data['router_class'].'_node']['value'] > 0){
				$class_id = $_SESSION[$this->data['router_class'].'_node']['value'];
			}

			// 取得商品分類的編號
			if(isset($_SESSION[$this->data['router_class'].'_search']['class_id']) and $_SESSION[$this->data['router_class'].'_search']['class_id'] > 0){
				$class_id = $_SESSION[$this->data['router_class'].'_search']['class_id'];
			}
			$this->data['class_id'] = $class_id;

			// if($class_id <= 0){
			// 	unset($this->data['def']['listfield'][$this->data['def']['func_field']['sort_id']]);
			// }

			// // 商品分類編號要有指定，還有其它必要的條件，才能夠即時自動切換
			// if($class_id > 0){
			// 	$this->data['def']['sortable']['enable'] = true;

			// 	// 疑似Bug 2017-03-24
			// 	// $this->data['def']['sortable']['condition'] = 'class_id = '.$this->data['class_id'].' ';
			// 	// $this->data['def']['condition']['where']['class_id'] = $class_id;
			// } else {
			// 	$this->data['def']['sortable']['enable'] = false;
			// }


			// 2020-09-09
			// 有分類的情況，而且還有其它的條件，把只有單獨選擇分類編號的情況，給抓出來
			// 2022-02-28 如果是子節點進入的，就預設可排序 by lota
			if(isset($_SESSION[$this->data['router_class'].'_node'])){
				$only_select_class_id = true;
			}else{
				$only_select_class_id = false;
			}

			if(isset($_SESSION[$this->data['router_class'].'_search']) and !empty($_SESSION[$this->data['router_class'].'_search'])){
				foreach($_SESSION[$this->data['router_class'].'_search'] as $k => $v){
					if($k == 'class_id'){
						if($v == -1){
							// 主角不能沒選
							$only_select_class_id = false;
							break;
						} else {
							$only_select_class_id = true;
						}
					} elseif($v == -1){
						// do nothing
					} elseif($v != ''){
						// 其它欄位，不能有輸入條件，當然的會略過checkbox和radio的欄位值
						$only_select_class_id = false;
						break;
					}
				}
			}

			// 2020-09-09
			// 很單純，很特定的情況下，才會啟用托拉排序
			if($only_select_class_id === true and $has_default_orderby_condition === true){
				$this->data['def']['sortable']['enable'] = true;
			} else {
				unset($this->data['def']['listfield'][$this->def['default_sort_field']]);
				$this->data['def']['sortable']['enable'] = false;
			}

			// [多分類排序]
			// 只有一個分類條件下，才能啟用多類別的排序
			if(isset($rowg['other26']) and $rowg['other26'] == '1'){ // 是否為“多分類排序”
				$ss = $this->data['router_class'].'_search';
				$session = Yii::app()->session[$ss];
				if(isset($session) and !empty($session)){
					$conditions = array();
					$conditions_sortable = array();
					foreach($session as $k => $v){
						if($v == '') unset($session[$k]);
						if($k == 'class_id' and $v == -1) unset($session[$k]);
						if($k == 'class_id' and $v == 0) unset($session[$k]);
						if($k == 'icon' and $v == '') unset($session[$k]);
					}
				}
				// 這邊只限定只有一個搜尋條件，而且是class_id 才能排序，如果有增加搜尋條件，記得在上面unset - 判斷3 (整隻程式有三個判斷) by lota
				if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
					// do nothing
				} else {
					$this->data['def']['sortable']['enable'] = false;
					if(isset($rowg['class_ids']) and $rowg['class_ids'] == '1'){ // 是否為通用分項
						$sort_field = 'topic';
					} else {
						$sort_field = 'name';
					}
					//$this->load->library('base64url');
					//$this->data['sort_field'] = $this->base64url->encode($sort_field);
					$this->data['sort_field'] = base64url::encode($sort_field);
					$this->data['sort_field_nobase64'] = $sort_field;
					unset($this->data['def']['listfield']['sort_id']);
				}
			}

			// 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱 2022-02-28 lota fix 加入$only_select_class_id反轉判斷
			if(!$only_select_class_id and $class_id <= 0 and $this->data['sort_field_nobase64'] == $this->data['def']['func_field']['sort_id']){
				$sort_field = 'id'; // $sort_field = 'topic';
				$this->data['params']['direction'] = 'desc';// 2016/6/23 初始化為反序，方便客戶馬上看到新增的資料

				$this->data['sort_field'] = base64url::encode($sort_field);
				$this->data['sort_field_nobase64'] = $sort_field;
			}
		} elseif($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 0 and isset($rowg['pic3']) and $rowg['pic3'] != 1){ // 無分類，而且不是日期排序

			// 如果有下任何的搜尋條件，都不能使用拖拉排序
			$no_other_search_condition = true;
			if(isset($_SESSION[$this->data['router_class'].'_search']) and !empty($_SESSION[$this->data['router_class'].'_search'])){
				foreach($_SESSION[$this->data['router_class'].'_search'] as $k => $v){
					if($v != '' or $v == 0 and $v == -1){
						$no_other_search_condition = false;
						break;
					}
				}
			}

			// 2020-09-09
			// 很單純，很特定的情況下，才會啟用托拉排序
			// 這裡的條件，跟分類的寫法，有一些不太一樣
			if($no_other_search_condition === true and $has_default_orderby_condition === true){
				$this->data['def']['sortable']['enable'] = true;
			} else {
				unset($this->data['def']['listfield'][$this->def['default_sort_field']]);
				$this->data['def']['sortable']['enable'] = false;
			}

		//} else { // 無分類
		//	parent::index_first($param); // 2020-09-09 CRUD母體那邊，index_first沒有寫東西，所以不需要繼承，這裡直接註解起來
		}
		//#46369 社群分享---關排序
		if($this->data['router_class']=='community'){
			$this->data['def']['sortable']['enable'] = false;
		}	
	}

	protected function index_last($param='')
	{
		// print_r($this->data['def']);die;
		//var_dump($this->data['listcontent']);
		// #46369 社群分享--撈資料-----------------------------------------------------------------
		if($this->data['router_class']=='community'){
			$listcontent_tmp=array();
			$index_data = $this->db->createCommand()->from('html')->where('topic=:topic and ml_key=:ml_key and type=:type', array(':topic'=>'首頁',':ml_key'=>$this->data['ml_key'],':type'=>'webmenu'))->queryRow();
			$listcontent_tmp[0]=$index_data;
			$a=1;
			foreach($this->data['listcontent'] as $k => $v){
				$listcontent_tmp[$a]=$v;
				$a++;
			}
			$this->data['listcontent']=$listcontent_tmp;
		}	
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
			if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類
				$show_type_mode = 1; //通用資料表
			}else{
				$show_type_mode = 2; //獨立資料表
			}
		}else{
			$show_type_mode = 0; //沒有分類
		}

		// 2018-08-29 分項節點(1/2) 父
		$node_fields = array();
		if(isset($this->data['def']['listfield']) and !empty($this->data['def']['listfield'])){
			foreach($this->data['def']['listfield'] as $k => $v){
				if(
					isset($v['url_id']) and $v['url_id'] == 'node'
					and isset($v['url_id_field']) and $v['url_id_field'] != '' // 一定要寫，不然會用到ID欄位
					and isset($v['url_id_node_child']) and $v['url_id_node_child'] != '' // (隱藏欄位)，未來要使用的時候，別忘了這個"子節點相依"的欄位
					and isset($v['url_id_node_child_field']) and $v['url_id_node_child_field'] != '' // (隱藏欄位)，可以指定相依到子節點的哪個欄位
				){
					$node_fields[] = $k;
				}
			}
		}
		//var_dump($node_fields);die;
			
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				//編號(非流水號)
				$_page_gg = ($this->data['params']['page'] - 1) * $this->data['record'];
				$v['xx_id'] = $k + 1 + $_page_gg;
				
				if(isset($v['pic1']) and $v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				//這邊先做通用的，獨立的以後再說 by lota
				if($show_type_mode > 0 and $v['class_id'] > 0){

					$type_name = $this->data['router_class'].'type';
					if(isset($rowg['other22']) and $rowg['other22'] != ''){
						$type_name = $rowg['other22'];
					}

					if($show_type_mode == 1){
						$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id='.$v['class_id'], array(':type'=>$type_name,':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
						$v['xx2'] = $row2['topic'];
					} elseif($show_type_mode == 2){
						$row2 = $this->db->createCommand()->from($type_name)->where('is_enable=1 and ml_key=:ml_key and id='.$v['class_id'], array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
						$v['xx2'] = $row2['name'];
					}
					
				}

				// 2018-08-29 分項節點(2/2) 父
				if($node_fields and !empty($node_fields)){
					foreach($node_fields as $kk => $vv){
						// param={value 索引值}__{parent router_class}__{child router_class}__{child field_name}
						$params = array();
						$params[] = $v['id'];
						$params[] = $this->data['router_class'];
						$params[] = $this->data['def']['listfield'][$vv]['url_id_node_child'];
						$params[] = $this->data['def']['listfield'][$vv]['url_id_node_child_field'];
						$v[$vv] = implode('__',$params);
					}
				}

				// 商品複製
				// 2017-07-20 李哥說，要加上授權，就是99999開頭的都要加
				if(0 and preg_match('/^99999/', $this->data['admin_id'])){
					$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> '.G::_('Copy', 'en').'</a>';
				}

				//Ming 2018-12-18 來信 指示 列表的標題文字，點擊後可另開視窗顯示前台畫面  ( 所有單元都是 ) 
				//if(preg_match('/^video|location|graphics|faq|download/', $this->data['router_class'])){
				//	if($show_type_mode > 0 and $v['class_id'] > 0){
				//		$_href = '/'.$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['class_id'];						
				//	}else{
				//		$_href = '/'.$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php';
				//	}
				//}else{					
				//	$_href = '/'.$this->data['router_class'].'detail_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['id'];					
				//}
				//$v['topic'] = '<a href="'.$_href.'" target="_BREAK">'.$v['topic'].'</a>';

				$this->data['listcontent'][$k] = $v;
			}
		}

		// $this->data['main_content'] = 'default/index';

		// 2021-01-20 #38699 匯入後，一次性的依照日期重排資料
		if(0 and $this->data['router_class'] == 'news'){
			$rows = $this->cidb->where('type','news')->where('ml_key',$this->data['admin_switch_data_ml_key'])->order_by('date1','desc')->get('html')->result_array();
			$ids_tmp = array();
			if($rows){
				foreach($rows as $k => $v){
					$ids_tmp[$v['id']] = ($k+1);
				}
			}
			if(!empty($ids_tmp)){
				foreach($ids_tmp as $k => $v){
					$this->cidb->where('id', $k);
					$this->cidb->update('html', array('sort_id' => $v));
				}
			}
		}
		
		// print_r($this->data['listcontent']);die;
		//----------------------------------------------------------------------------------------
	}

	protected function create_show_last($param='')
	{
		// unset($this->data['def']['updatefield']['sections'][1]['field']['kc01']);

		// 複選分類
		if(isset($this->data['def']['updatefield']['sections'][0]['field']['class_ids'])){
			// 前台主選單的資料表功能
			unset($rowg);
			if(isset($this->data['rowg_custom'])){
				$rowg = $this->data['rowg_custom'];
			} else {
				$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
			}

			// 取得所有分類
			if($rowg){ 
				if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 通用分類
					$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
				} else {
					$rows = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
				}
			} else {
				$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
			}

			$this->data['updatecontent']['class_ids'] = $rows;
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_show_last($param='')
	{
		// if(isset($this->data['def']['updatefield']['sections'][1]['field']['kc01'])){
		// 	$this->data['def']['updatefield']['sections'][1]['field']['kc01']['other']['school_id'] = $this->data['router_class'].$this->data['updatecontent']['id'];
		// }

		// 商品複製
		if(isset($this->data['params']['value'][1]) and $this->data['params']['value'][1] == 'copy'){
			$this->data['submit_buttons'] = array(
				array(
					'html' => '<i class="icon-copy"></i> Copy',
					'class' => 'btn blue',
				   	'type' => 'submit',
				),
			);
			$this->data['router_method_view'] = '1';
			$this->data['updatecontent']['is_copy'] = $this->data['updatecontent']['id'];
			$this->data['updatecontent']['id'] = 0; // 為了保護原本的資料不被動到
		}else{
			// 選擇相關產品 有需要就打開他	
			// $tmps = explode(',', $this->data['updatecontent']['related_ids']);
			// // $tmps = $this->data['updatecontent']['related_ids'];
			// $groups = array();
			// if($this->data['related_ids']){
			// 	foreach($this->data['related_ids'] as $k => $v){
			// 		if($k == $this->data['updatecontent']['id']) continue; // 排除掉自己，不然選到自己跟本就是很奇怪
			// 		$groups[$k]['value'] = $v;
			// 		if(in_array($k, $tmps)){
			// 			$groups[$k]['is_selected'] = 'selected'; // multiselect
			// 			//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
			// 		}
			// 	}
			// }
			// $this->data['updatecontent']['related_ids'] = $groups;
		}

		// 複選分類
		if(isset($this->data['def']['updatefield']['sections'][0]['field']['class_ids'])){
			// 前台主選單的資料表功能
			unset($rowg);
			if(isset($this->data['rowg_custom'])){
				$rowg = $this->data['rowg_custom'];
			} else {
				$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
			}

			// 取得所有分類
			if($rowg){ 
				if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 通用分類
					$rows = $this->db->createCommand()->select('*, topic as name')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
				} else {
					$rows = $this->db->createCommand()->from($this->data['router_class'].'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
				}
			} else {
				$rows = $this->db->createCommand()->select('*, topic as name')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
			}

			// ,1,2,3,
			$ggg = explode(',', $this->data['updatecontent']['class_ids']);
			unset($ggg[count($ggg) - 1]);
			unset($ggg[0]);

			if(!empty($rows)){
				foreach($rows as $k => $v){
					if(in_array($v['id'], $ggg)){
						$rows[$k]['is_selected'] = '1';
					}
				}
			}
			$this->data['updatecontent']['class_ids'] = $rows;
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 假設性的，最多處理四張代表圖
		for($x=1;$x<=4;$x++){
			if(
				isset($this->data['updatecontent']['pic'.$x]) and $this->data['updatecontent']['pic'.$x] != '' 
				and file_exists(_BASEPATH.'/assets/upload/'.$this->data['router_class'].'/'.$this->data['updatecontent']['pic'.$x])
			){
				// 製做其它縮圖，範圍預設：寬800px, 高800px
				// _i/assets/cache3/upload/{ROUTER_CLASS}/w800h800zc3_AAA.jpg
				if(file_exists('backend/include/timthumb_physical_file_cache3.php')){
					$_file = _BASEPATH.'/assets/upload/'.$this->data['router_class'].'/'.$this->data['updatecontent']['pic'.$x];
					include 'backend/include/timthumb_physical_file_cache3.php';
				}
			}
		}

		// 多檔上傳的編輯器的圖
		$path_tmp = _BASEPATH.'/assets/members/'.$this->data['router_class'].$this->data['updatecontent']['id'].'/member';
		if(file_exists($path_tmp)){
			$tmps = $this->_getFiles($path_tmp);
			foreach($tmps as $k => $v){
				// 製做其它縮圖，範圍預設：寬800px, 高800px
				// _i/assets/cache3/upload/{ROUTER_CLASS}/w800h800zc3_AAA.jpg
				if(file_exists('backend/include/timthumb_physical_file_cache3.php')){
					$_file = $v;
					include 'backend/include/timthumb_physical_file_cache3.php';
				}
			}
		}

		// 這是SEO的範本，如果你需要，就打開它 3/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';'); 
		if($_constant){
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php')){
				$seo_func = 'b';
				include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
			}
			
			$row = $this->db->createCommand()->from('seo')->where('seo_item_id=:id and seo_ml_key=:ml_key and seo_type=:type',array(':id'=>$this->data['updatecontent']['id'],'ml_key'=>$this->data['admin_switch_data_ml_key'],':type'=>$this->data['router_class']))->queryRow();
			if($row){
				$this->data['updatecontent'] = $this->data['updatecontent'] + $row;
			}
		}		

		// $this->data['main_content'] = 'default/update';
	}

	// 商品複製
	/*
	 * array(
	 *		class_id => 123,
	 *		is_copy => 1,
	 *		hidden_id => 0,
	 * ),
	 *
	 */
	protected function update_run_copy($update)
	{
		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$save = $this->db->createCommand()->from('html')->where('is_enable=1 and id=:id and ml_key=:ml_key',array(':id' => $update['is_copy'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
				$save['topic'] = $save['topic'].' (複製)';
			} else {
				$save = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and id=:id and ml_key=:ml_key',array(':id' => $update['is_copy'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
				$save['name'] = $save['name'].' (複製)';
			}

			unset($save['id']);
			unset($save['update_time']);

			if(isset($rowg['other26']) and $rowg['other26'] == '1'){ // 是否為“多分類排序”
				// [多分類排序]
				$class_ids_tmp = $save['class_ids'];
				$class_ids = explode(',', $class_ids_tmp);
				// 先準備好
				if($class_ids and !empty($class_ids)){
					foreach($class_ids as $k => $v){
						if($v == '') unset($class_ids[$k]);
					}
				}

				// 跟單選一樣新增相同的資料，但是不用處理排序編號
				$save['create_time'] = date('Y-m-d H:i:s');

				if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
					$save['type'] = $this->data['router_class'];
					$this->cidb->insert('html', $save);
				}else{					
					$this->cidb->insert($this->data['router_class'], $save);
				}

				$new_product_id = $this->cidb->insert_id();
				// 在每一個多選分類，都建立sort_id，在另一個資料表上
				if($class_ids and !empty($class_ids)){
					foreach($class_ids as $k => $class_id){
						$row2 = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id=:class_id',array(':class_id' => $class_id))->queryAll();
						$save = array(
							'class_id' => $class_id,
							'product_id' => $new_product_id,
							$this->def['func_field']['sort_id'] => count($row2) + 1,
						);
						$this->cidb->insert($this->data['router_class'].'multisort', $save);
					}
				}

				// 複製成功後，只會轉到列表頁，不會做像單分類複製那樣的轉到該分類的動作
				$url = $this->createUrl($this->data['router_class'].'/index');
			} else {
				// 單分類排序
				if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
					$save['class_id'] = $update['class_id'];

					$type_name = $this->data['router_class'].'type';
					if(isset($rowg['other22']) and $rowg['other22'] != ''){
						$type_name = $rowg['other22'];
					}

					if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類
						$row2 = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and type=:type and class_id=:id and ml_key=:ml_key',array(':type'=>$type_name,':id' => $update['class_id'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
					} else {
						$row2 = $this->db->createCommand()->select('id')->from($type_name)->where('is_enable=1 and pid=:id and ml_key=:ml_key',array(':id' => $update['class_id'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
					}
				}else{ //沒分類
					if($rowg['class_ids'] == 1){
						$row2 = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$this->data['router_class'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
					}else{
						$row2 = $this->db->createCommand()->select('id')->from($this->data['router_class'])->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
					}					
				}

				if(isset($row2)){
					$save[$this->def['func_field']['sort_id']] = count($row2) + 1;
				}else{
					$save[$this->def['func_field']['sort_id']] = 1;
				}
				
				$save['create_time'] = date('Y-m-d H:i:s');

				if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 是通用分項
					$this->cidb->insert('html', $save);
				} else {
					$this->cidb->insert($this->data['router_class'], $save);
				}

				// 複製成功後，轉到列表頁，並且搜尋該分類，而且排序欄位做反向，這樣子就可以看到複製出來的那一筆
				$ss = $this->data['router_class'].'_search';
				$session = Yii::app()->session[$ss];
				if($session === null){
					$session = array();
				}

				if(isset($update['class_id'])){
					$session['class_id'] = $update['class_id'];
					Yii::app()->session[$ss] = $session;
				}				

				$parameter = new Parameter_handle;
				$param_define = $parameter->getDefine();
				//$url = $this->createUrl($this->data['router_class'].'/index', array('param' => base64url::encode('sort_id').'-'.$param_define['direction'].'desc'));
				$url = $this->createUrl($this->data['router_class'].'/index', array('param' => base64url::encode($this->def['func_field']['sort_id']).'-'.$param_define['direction'].'desc'));
			}
		}

		G::alert_and_redirect('Copy Success !', $url, $this->data);

		die;
	}

	protected function update_run_last($param='')
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_run_other_element($array)
	{
		// 這是SEO的範本，如果你需要，就打開它 4/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';'); 
		if($_constant){
			$array['seo_type'] = $this->data['router_class'];
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php')){
				$seo_func = 'c';
				include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
			}
		}

		// 複選分類
		// 除非有使用物件繼承，不然下面的程式碼是必需要寫的
		// 不然就是要另外載入底下母體的這支檔案
		// framework/backend/components/modules/Core2crud/AAAAAAAAAA.php
		if(isset($array['class_ids']) and !empty($array['class_ids'])){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		//Ming 2018-12-18 來信 指示 資料更新後，點擊送出後需返回列表頁 ( 所有單元都是 ),設定非資訊部人員才會動作 by lota
		if(!preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
			$array['update_base64_url'] = '';
		} 

		// 2018-09-05 修改的時候，語系和通用資料表的型態，不需要另外指定
		// $array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		// $array['type'] = $this->data['router_class'];

		// $array['detail'] = $this->numeric_code_utf8($array['detail']); // system.backend.extensions.myvalidators.numbericcodeutf8
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		// 2018-09-03 只有是通用資料表的時候，才會加上型態
		// 不過就算獨立資料表也加了，那也沒差，因為ORM會看
		if($this->data['def']['table'] == 'html'){
			$array['type'] = $this->data['router_class'];
		}

		// 複選分類
		// 除非有使用物件繼承，不然下面的程式碼是必需要寫的
		// 不然就是要另外載入底下母體的這支檔案
		// framework/backend/components/modules/Core2crud/AAAAAAAAAA.php
		if(isset($array['class_ids']) and !empty($array['class_ids'])){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// 2018-08-29 分項節點(3/3) 子
		// param={value 索引值}__{parent router_class}__{child router_class}__{child field_name}
		$ss = $this->data['router_class'].'_node';
		$session_node = Yii::app()->session[$ss];

		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('type =:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if(isset($rowg['other25']) and $rowg['other25'] != ''){
			if(isset($session_node['value']) and $session_node['value'] > 0){
				$array[$session_node['field']] = $session_node['value'];
			}
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}

	protected function create_run_last() 
	{
		// 為了要支援sort_id改欄位名稱
		$sort_field = 'sort_id';
		if(isset($this->data['def']['func_field']['sort_id']) and $this->data['def']['func_field']['sort_id'] != ''){
			$sort_field = $this->data['def']['func_field']['sort_id'];
		}

		/*
		 * 2019-02-14
		 * 每筆新資料新增時，請排列到第一筆(原會最後一筆)(這裡是舊的)
		 * http://redmine.buyersline.com.tw:4000/issues/31012
		 */
		
		// $this->cidb->where('id', $this->data['_last_insert_id']);
		// $this->cidb->update($this->data['def']['table'], array($sort_field => 0));

		// // 重新排序
		// // 目前Fieldsorter不支援where以外的方法
		// if(isset($this->data['def']['listfield'][$sort_field])){
		// 	$fieldsorter = new Fieldsorter;
		// 	$fieldsorter->setTableName($this->data['def']['table']);
		// 	$fieldsorter->setIdName($this->data['def']['func_field']['id']);
		// 	if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
		// 		$fieldsorter->setCondition($this->data['def']['condition']);
		// 	}
		// 	//$fieldsorter->refresh();
		// 	$fieldsorter->refresh('', array(),'', $sort_field);
		// }

		/*
		 * 2020-08-19
		 * 試著寫寫看，新增的時候，會是第一筆
		 */
		if(isset($this->data['origin_condition'])){
			if(isset($this->data['datasave']['class_id']) and $this->data['datasave']['class_id'] > 0){ // 有單選的情況，先改零，在重排
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));
				
				// 單分類排序
				//$conditions[] = $k.'='.$v;

				$this->data['origin_condition'][0][1] .= ' AND class_id='.$this->data['datasave']['class_id'].' ';

				// 重新排序
				// 目前Fieldsorter不支援where以外的方法
				if(isset($this->data['def']['listfield'][$sort_field])){
					$fieldsorter = new Fieldsorter;
					$fieldsorter->setTableName($this->data['def']['table']);
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					$fieldsorter->setCondition($this->data['origin_condition']);
					$fieldsorter->refresh('', array(),'', $sort_field);
				}
			} elseif (isset($this->data['datasave']['class_ids']) and $this->data['datasave']['class_ids'] !='') { //複選類別 預設使用 class_ids
				//將勾選的分類解析出來
				$_class_ids = array_filter(explode(',',$this->data['datasave']['class_ids']));
				if(count($_class_ids) > 0){
					//將勾選的分類分別的寫入專屬資料表
					foreach ($_class_ids as $key => $value) {
						$_data = array(
							'product_id' => $this->data['_last_insert_id'],
							'class_id' => $value,
							$sort_field => 0,
						);
						// $this->cidb->insert($this->data['def']['table'].'multisort', $_data);	
						// 2022-02-11 lota fix 這裡應該是用 router_class	而不是用 table
						$this->cidb->insert($this->data['router_class'].'multisort', $_data);				

						$this->data['origin_condition'][0][1] = ' class_id='.$value.' ';

						$fieldsorter = new Fieldsorter;
						// $fieldsorter->setTableName($this->data['def']['table'].'multisort');
						// 2022-02-11 lota fix 這裡應該是用 router_class	而不是用 table
						$fieldsorter->setTableName($this->data['router_class'].'multisort');
						$fieldsorter->setIdName($this->data['def']['func_field']['id']);
						$fieldsorter->setCondition($this->data['origin_condition']);
						$fieldsorter->refresh('', array(),'', $sort_field);	
					}	

					//如果已經按下search，那就先處理一下 , 從 actionSearch 拷貝過來的
					$ss = $this->data['router_class'].'_search';
					$session = Yii::app()->session[$ss];
					if($session === null){
						$session = array();
					}
					if(isset($session) and !empty($session)){
						$conditions = array();
						$conditions_sortable = array();
						foreach($session as $k => $v){
							if($v == '') unset($session[$k]);
							if($k == 'class_id' and $v == -1) unset($session[$k]);
							if($k == 'class_id' and $v == 0) unset($session[$k]);
							if($k == 'icon' and $v == '') unset($session[$k]);
						}
					}
					// 這邊只限定只有一個搜尋條件，而且是class_id 才能排序，如果有增加搜尋條件，記得在上面unset - 判斷1 (整隻程式有三個判斷) by lota
					if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
						// 把該分類的sort_id洗掉，然後載入多分類排序資料表的資料，然後更新它
						$class_id = $session['class_id'];
						$rows = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id='.$class_id)->order('sort_id')->queryAll();
						if($rows){
							foreach($rows as $k => $v){
								$data = array(
									'sort_id' => $v['sort_id'],
								);
								//$this->cidb->where('id',$v['product_id'])->update($this->data['router_class'], $data);
								$this->cidb->query('update '.$this->data['router_class'].' set sort_id='.$v['sort_id'].' where id='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
							}
						}
					}

				}
			} elseif(!isset($this->data['datasave']['class_id']) and !isset($this->data['datasave']['class_id'])){ // 分項的情況
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));

				$fieldsorter = new Fieldsorter;
				$fieldsorter->setTableName($this->data['def']['table']);
				$fieldsorter->setIdName($this->data['def']['func_field']['id']);
				$fieldsorter->setCondition($this->data['origin_condition']);
				$fieldsorter->refresh('', array(),'', $sort_field);
			}
		}

	}

	public function actionSearch()
	{
		if(!empty($_POST)){
			$ss = $this->data['router_class'].'_search';
			$session = Yii::app()->session[$ss];
			if($session === null){
				$session = array();
			}
			// 處理一下checkbox的欄位
			if($session){
				foreach($session as $k => $v){
					if(preg_match('/^checkbox_/', $k)){
						unset($session[$k]);
					}
				}
			}
			foreach($_POST as $k => $v){
				$session[$k] = $v;
			}
			Yii::app()->session[$ss] = $session;

			// 前台主選單的資料表功能
			unset($rowg);
			if(isset($this->data['rowg_custom'])){
				$rowg = $this->data['rowg_custom'];
			} else {
				$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
			}

			if($rowg){
				if(isset($rowg['other26']) and $rowg['other26'] == '1'){ // 是否為“多分類排序”
					// [多分類排序]
					if(isset($session) and !empty($session)){
						$conditions = array();
						$conditions_sortable = array();
						foreach($session as $k => $v){
							if($v == '') unset($session[$k]);
							if($k == 'class_id' and $v == -1) unset($session[$k]);
							if($k == 'class_id' and $v == 0) unset($session[$k]);
							if($k == 'icon' and $v == '') unset($session[$k]);
						}
					}
					// 這邊只限定只有一個搜尋條件，而且是class_id 才能排序，如果有增加搜尋條件，記得在上面unset - 判斷2 (整隻程式有三個判斷) by lota
					if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
						// 把該分類的sort_id洗掉，然後載入多分類排序資料表的資料，然後更新它
						$class_id = $session['class_id'];
						$rows = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id='.$class_id)->order('sort_id')->queryAll();
						if($rows){
							foreach($rows as $k => $v){
								// $data = array(
								// 	$this->def['func_field']['sort_id'] => $v[$this->def['func_field']['sort_id']],
								// );
								// $this->cidb->where('id',$v['product_id'])->update($this->data['router_class'], $data);
								// $this->cidb->query('update '.$this->data['router_class'].' set sort_id='.$v['sort_id'].' where id='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');

								$this->cidb->query('update '.$this->def['table'].' set '.$this->def['func_field']['sort_id'].'='.$v[$this->def['func_field']['sort_id']].' where '.$this->def['func_field']['id'].'='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
							}
						}
					}
				}
			}

			$this->redirect($this->createUrl($this->data['router_class'].'/index'));
		}
	}

	// [多分類排序]
	// 把一般排序後的結果，轉移到另一個資料表寫入
	protected function sort_last()
	{
		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		if($rowg){
			if(isset($rowg['other26']) and $rowg['other26'] == '1'){ // 是否為“多分類排序”
				$ss = $this->data['router_class'].'_search';
				$session = Yii::app()->session[$ss];
				$class_id = $session['class_id'];

				// 搜尋產品的多分類欄位，將它們的排序編號，寫入另一個資料表
				// 記得寫入之前要先把另一個資料表的該分類的資料刪掉
				$this->cidb->where('class_id', $class_id)->delete($this->data['router_class'].'multisort'); 

				// 這裡的Query語法，應該要跟search()裡面的一樣
				if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
					$rows = $this->db->createCommand()->from('html')->where('ml_key=:ml_key and type=:type and class_ids like "%,'.$class_id.',%"',array(':ml_key'=>$this->data['ml_key'],':type'=>$this->data['router_class']))->queryAll();
				} else {
					$rows = $this->db->createCommand()->from($this->data['router_class'])->where('ml_key=:ml_key and class_ids like "%,'.$class_id.',%"',array(':ml_key'=>$this->data['ml_key']))->queryAll();
				}
				if($rows){
					foreach($rows as $k => $v){
						$data = array(
							'class_id' => $class_id,
							'product_id' => $v['id'],
							$this->def['func_field']['sort_id'] => $v[$this->def['func_field']['sort_id']],
						);
						$this->cidb->insert($this->data['router_class'].'multisort', $data); 
					}
				}
			}
		}
	}

	// 刪除後要做的事情
	protected function delete_last()
	{
		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		if($rowg){
			if(isset($rowg['other26']) and $rowg['other26'] == '1'){ // 是否為“多分類排序”
				$this->cidb->where('product_id', $this->data['id'])->delete($this->data['router_class'].'multisort'); 
			}
		}
	}

	// 解無限層分類(不含頂層)
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}

	/*
	 * 通用匯出Excel的功能(PHP7)
	 * 2020-02-10
	 */
	public function actionExcelexport2()
	{

		header("Content-Type:text/html; charset=utf-8");

		/*
		 * 載入後台的連絡我們，欄位的中文之接對應和取用
		 */
		$admin_field_tmp = array();
		foreach(array(0,1) as $admin_field_section_id){
			$admin_field_router_class = $this->data['router_class'];
			include _BASEPATH.'/../source/system/admin_field_get.php';

			if($admin_field and is_array($admin_field)){
				foreach($admin_field as $k => $v){
					$admin_field_tmp[$k] = $v;
				}
			}
		}
		$admin_field = $admin_field_tmp;

		if($admin_field and !empty($admin_field)){
			foreach($admin_field as $k => $v){
				if(preg_match('/^(addr_twzipcode_n|latest_login_time)$/', $k, $matches)){
					unset($admin_field[$k]);
				}
			}
			// 預設密碼相關欄位都不匯出
			foreach($admin_field as $k => $v){
				if(preg_match('/(password)/', $k, $matches)){
					unset($admin_field[$k]);
				}
			}
			// 使用多國語系名稱的欄位
			foreach($admin_field as $k => $v){
				if(!isset($v['label']) and isset($v['mlabel'])){
					$v['label'] = $v['mlabel'][3];
				}
				$admin_field[$k] = $v;
			}
		}

		//$query = 'SELECT * FROM '.$this->data['router_class'];
		$query = 'SELECT * FROM '.$this->def['table']; //2017/5/9 by lota fix 
		if(isset($this->def['condition'][0][1]) and trim($this->def['condition'][0][1]) != ''){
			$query .= ' WHERE '.$this->def['condition'][0][1];
		}
		$rows = $this->db->createCommand($query)->queryAll();

		// 試著把一些沒有資料表欄位的功能欄位給刪掉
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				if($admin_field and !empty($admin_field)){
					foreach($admin_field as $kk => $vv){
						if(!isset($v[$kk])){
							unset($admin_field[$kk]);
						}
					}
				}
			}
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$spreadsheet->getProperties()
			->setCreator("Buyersline")
			->setLastModifiedBy("Buyersline")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Product Document for Office 2007 XLSX");

		// 標題
		$spreadsheet->setActiveSheetIndex(0);
		$sheet = $spreadsheet->getActiveSheet();
		if($admin_field and !empty($admin_field)){
			$i = 1;
			foreach($admin_field as $k => $v){
				$sheet->setCellValue(Coordinate::stringFromColumnIndex($i).'1', $v['label']);
				$i++;
			}
		}

		// 資料
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				if($admin_field and !empty($admin_field)){
					$i = 1;
					foreach($admin_field as $kk => $vv){
						$value = $v[$kk];
						if($kk == 'is_enable'){
							if($value == '0'){
								$value = '停用';
							} else {
								$value = '啟用';
							}
						} elseif($kk == 'gender'){
							if($value == '1'){
								$value = '男';
							} elseif($value == '2'){
								$value = '女';
							}
						}
						$sheet->SetCellValueExplicit(Coordinate::stringFromColumnIndex($i).($k+2), (string)$value,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); // 2019-07-17 為了要能夠讀取開頭為零的純數字

						if(preg_match('/^pic/', $kk)){
							//$objDrawingPType = new PHPExcel_Worksheet_Drawing();
							//$objDrawingPType->setWorksheet($objPHPExcel->getActiveSheet());
							//$objDrawingPType->setPath($this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$value);
							//$objDrawingPType->setCoordinates(chr($i+65).($k+2));
							//$objDrawingPType->setHeight(100);

							$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
							$drawing->setWorksheet($spreadsheet->getActiveSheet());
							$drawing->setPath($this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$value);
							$drawing->setCoordinates(chr($i+64).($k+2));
							$drawing->setHeight(100);

							$sheet->getRowDimension($k+2)->setRowHeight(100);

							$sheet->SetCellValue(Coordinate::stringFromColumnIndex($i).($k+2), '');
							$sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setWidth(22);


							//$objDrawingPType->setOffsetX(1);
							//$objDrawingPType->setOffsetY(5);
						} else {
							// $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i+65))->setAutoSize(true);
							$sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
						}


						$i++;
					}
				}
			}
		}

		// 加上Filter
		$sheet->setAutoFilter($sheet->calculateWorksheetDimension());

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$file = trim(str_replace('　','',$this->data['main_content_title'])).'-'.date('Y-m-d-H-i-s').'.xlsx';
		if(preg_match('/(MSIE|Edge|Trident)/', $_SERVER['HTTP_USER_AGENT'])){
			if(preg_match('/Edge/', $_SERVER['HTTP_USER_AGENT'])){
				// https://www.itread01.com/content/1548273435.html
				$file = urlencode($file);
			} else {
				$file = iconv('utf-8','big5',$file);
			}
		}

		header('Content-Disposition: attachment;filename="'.$file.'"');

		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output'); // download file 

		die;

	}

}

// 懶得改Controller的名稱之三
// eval('class '.$filename.' extends NonameController {}');
