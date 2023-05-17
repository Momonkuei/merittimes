<?php

/*
 * 2020-02-10
 */
require_once('phpSpreadsheet/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

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
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

		// 在各功能的上面的新增的右邊
		
		'index_buttons' => array(
			array(
				'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
				'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
				'id' => '', // button
				'class' => 'btn btn-info', // button
				'onclick' => 'javascript:location.href=\'XXX\'',
			),
		),
		

		'disable_create' => true,
		'disable_action' => true,
		'table' => 'orderform',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'orderform',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				//array('topic', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'create_time', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('id'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'id', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'id', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'is_enable=1',
			),
		),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=orderstatus/sort', // ajax post都會有個目標
		//),
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
			'order_number' => array(
				'label' => '訂單編號',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'create_time' => array(
				'label' => '訂購日期',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'buyer_name' => array(
				'label' => '會員姓名',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'total' => array(
				'label' => '訂單金額',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'payment_func_name' => array(
				'label' => '付款方式',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => false,
			),
			'physical_func_name' => array(
				'label' => '運送方式',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				'sort' => false,
			),
			'order_status_name' => array(
				'label' => '訂單狀態',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => false,
			),
			'xx01' => array(
				'label' => '揀貨單',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'url_id' => 'orderprint',
				'width' => '12%',
				'sort' => false,
			),
			'xx02' => array(
				'label' => '訂單明細',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'url_id' => 'update',
				'width' => '12%',
				'sort' => false,
			),
			//'start_date' => array(
			//	//'label' => '日期',
			//	'mlabel' => array(
			//		null, // category
			//		'Date', // label
			//		array(), // sprintf
			//		'日期', // default
			//	),
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
			//'is_home' => array(
			//	//'label' => 'ml:Sort id',
			//	'mlabel' => array(
			//		null, // category
			//		'Show Home', // label
			//		array(), // sprintf
			//		'顯示在首頁', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//	'ezfield' => 'is_home',
			//	'ezother'=> '&nbsp;',
			//),
			//'is_enable' => array(
			//	//'label' => 'ml:Status',
			//	'mlabel' => array(
			//		null, // category
			//		'Status', // label
			//		array(), // sprintf
			//		'狀態', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'ezshow' => true,
			//),
			//'sort_id' => array(
			//	'label' => 'ml:Sort id',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
		), // listfield
		'searchfield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'jquery.datepicker',
			),
			//'smarty_javascript' => '',
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

// 純日期欄位
// $('#start_date').datepicker({dateFormat: 'yy-mm-dd'});
// $('#end_date').datepicker({dateFormat: 'yy-mm-dd'});

// 有連動的日期欄位 by lota 2018-01-15
// http://stackoverflow.com/questions/330737/jquery-datepicker-2-inputs-textboxes-and-restricting-range
$('#start_date,#end_date').datepicker({dateFormat: 'yy-mm-dd',beforeShow: customRange});
function customRange(input) 
{ 
	return {
         minDate: (input.id == 'end_date' ? $('#start_date').datepicker('getDate') : null), 
         maxDate: (input.id == 'start_date' ? $('#end_date').datepicker('getDate') : null)
       }; 
}",
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
						'buyer_login_account' => array(
							'label' => '會員帳號',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'buyer_login_account',
								'name' => 'buyer_login_account',
								'size' => '20',
							),
						),
						'buyer_name' => array(
							'label' => '會員姓名',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'buyer_name',
								'name' => 'buyer_name',
								'size' => '20',
							),
						),
						'order_number' => array(
							'label' => '訂單編號',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'order_number',
								'name' => 'order_number',
								'size' => '20',
							),
						),
						'recipient_addr' => array(
							'label' => '送貨地址',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'recipient_addr',
								'name' => 'recipient_addr',
								'size' => '40',
							),
						),
						'checkbox_order_status' => array(
							'label' => '訂單狀態',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'multicheckbox',
							'attr' => array(
								'name' => 'checkbox_order_status[]',
								'type' => 'checkbox',
							),
						),
						'start_date' => array(
							'label' => '訂單日期',
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
						),
						'end_date' => array(
							'label' => ' ∼ ',
							//'mlabel' => array(
							//	null, // category
							//	'Date', // label
							//	array(), // sprintf
							//	'日期', // default
							//),
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'end_date',
								'name' => 'end_date',
								'size' => '10',
								'readonly' => 'readonly',
							),
						),
						//'order_status' => array(
						//	'label' => '訂單狀態',
						//	'type' => 'select3',
						//	//'type' => 'select5',
						//	//'merge' => '1', // 頭中尾的頭(1)
						//	'attr' => array(
						//		'id' => 'order_status',
						//		'name' => 'order_status',
						//	),
						//	'other' => array(
						//		//'values' => array(
						//		//	'1' => '左上',
						//		//	'2' => '中上',
						//		//	'3' => '右上',
						//		//	'4' => '正左',
						//		//	'5' => '正中',
						//		//	'6' => '正右',
						//		//	'7' => '左下',
						//		//	'8' => '正下',
						//		//	'9' => '右下',
						//		//),
						//		//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						//		//'default' => 'center',
						//		'values' => array(
						//			'-1' => '請選擇',
						//		),
						//		'default' => '-1',
						//	),
						//),
					),
				),
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
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
					'field' => array(
						'order_number' => array(
							'label' => '訂單編號',
							'merge' => '1',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1" id="orderno">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'create_time' => array(
							'label' => '訂購日期　',
							'merge' => '3',
							'type' => 'nothing',
						),
						'buyer_name' => array(
							'label' => '訂購者',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'buyer_phone' => array(
							'label' => '訂購者電話',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'buyer_addr' => array(
							'label' => '訂購者地址',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'recipient_name' => array(
							'label' => '收件者',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						// 'recipient_other1' => array(
						// 	'label' => '收件者預留欄位1(跟會員other1欄位連動)',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other2' => array(
						// 	'label' => '收件者預留欄位2(跟會員other2欄位連動)',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other3' => array(
						// 	'label' => '收件者預留欄位3(跟會員other3欄位連動)',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other4' => array(
						// 	'label' => '收件者預留欄位4',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other5' => array(
						// 	'label' => '收件者預留欄位5',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other6' => array(
						// 	'label' => '收件者預留欄位6',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other7' => array(
						// 	'label' => '收件者預留欄位7',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other8' => array(
						// 	'label' => '收件者預留欄位8',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other9' => array(
						// 	'label' => '收件者預留欄位9',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						// 'recipient_other10' => array(
						// 	'label' => '收件者預留欄位10',
						// 	'type' => 'nothing',
						// 	'other' => array(
						// 		'html_start' => '<span class="col-md-1">',
						// 		'html_end' => '</span><span class="col-md-1"></span>',
						// 	),
						// ),
						'recipient_phone' => array(
							'label' => '收件者電話　',
							'merge' => '1',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'recipient_mobile' => array(
							'label' => '收件者備用電話　',
							'merge' => '3',
							'type' => 'nothing',
						),
						'payment_func_name' => array(
							'label' => '付款方式',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'physical_func_name' => array(
							'label' => '運送方式',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-3">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'recipient_addr' => array(
							'label' => '收件地址',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-4">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						//'invoice_number' => array(
						//	'label' => '發票號碼',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'invoice_number',
						//		'name' => 'invoice_number',
						//		'size' => '20',
						//	),
						//),
						'invoice_type_name' => array(
							'label' => '發票',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'invoice_addr' => array(
							'label' => '發票寄送地址',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-4">',
								'html_end' => '</span><span class="col-md-1"></span>',
							),
						),
						'order_status' => array(
							'label' => '訂單狀態',
							'type' => 'select3',
							'attr' => array(
								'id' => 'order_status',
								'name' => 'order_status',
							),
							'other' => array(
								'values' => array(
								),
								'default' => '0',
							),
						),
						'detail' => array(
							'label' => '備註事項',
							'type' => 'label',
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'physical_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'CVSStoreName' => array(
							'label' => '物流 | 取貨門市',
							'type' => 'nothing',
						),
						'CVSStoreID' => array(
							'label' => '物流 | 門市編號',
							'type' => 'nothing',
						),
						'CVSAddress' => array(
							'label' => '物流 | 門市地址',
							'type' => 'nothing',
						),
						'CVSTelephone' => array(
							'label' => '物流 | 門市電話',
							'type' => 'nothing',
						),
						'CVSPaymentNo' => array(
							'label' => '物流 | 寄貨編號/托運單號',
							'type' => 'nothing',
						),
						'LogisticsMsg' => array(
							'label' => '物流 | 物流狀態',
							'type' => 'nothing',
						),
						'UpdateStatusDate' => array(
							'label' => '物流 | 資料更新時間',
							'type' => 'nothing',
						),
						'AllPayLogisticsID' => array(
							'label' => '物流 | 交易編號',
							'type' => 'nothing',
						),
						'CVSPrint' => array(
							'label' => '物流 | 列印繳費單',
							'type' => 'nothing',
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'atm_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'atm_bank' => array(
							'label' => 'ATM | 匯款銀行',
							'type' => 'nothing',
						),
						'atm_number' => array(
							'label' => 'ATM | 末五碼',
							'type' => 'nothing',
						),
						'atm_price' => array(
							'label' => 'ATM | 匯款金額',
							'type' => 'nothing',
						),
						'atm_date' => array(
							'label' => 'ATM | 匯款日期',
							'type' => 'nothing',
						),
						'atm_comment' => array(
							'label' => 'ATM | 備註',
							'type' => 'nothing',
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'ecpay_711_no_payment_for_pickup_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'ecpay_711_no_payment_for_pickup_rtncode_name' => array(
							'label' => '統一超商取貨的狀態',
							'type' => 'nothing',
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'ecpay_fami_no_payment_for_pickup_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'ecpay_fami_no_payment_for_pickup_rtncode_name' => array(
							'label' => '全家超商取貨的狀態',
							'type' => 'nothing',
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'ecpay_cvs_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'ecpay_cvs_paymentno' => array(
							'label' => '超商代碼',
							'type' => 'nothing',
						),
						'ecpay_cvs_expiredate' => array(
							'label' => '繳費期限',
							'type' => 'nothing',
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'ecpay_webatm_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'ecpay_webatm_bank_code' => array(
							'label' => '銀行代碼',
							'type' => 'nothing',
						),
						'ecpay_webatm_vaccount' => array(
							'label' => '銀行帳號',
							'type' => 'nothing',
						),
						'ecpay_webatm_expiredate' => array(
							'label' => '繳費期限',
							'type' => 'nothing',
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'ecpay_vatm_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'ecpay_vatm_bank_code' => array(
							'label' => '銀行代碼',
							'type' => 'nothing',
						),
						'ecpay_vatm_vaccount' => array(
							'label' => '銀行帳號',
							'type' => 'nothing',
						),
						'ecpay_vatm_expiredate' => array(
							'label' => '繳費期限',
							'type' => 'nothing',
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'fund_transfer_by_post_office_atm_ggg' => array(
							'label' => '&nbsp;',
							'type' => 'nothing',
						),
						'fund_transfer_by_post_office_atm_bank' => array(
							'label' => '郵政劃撥 | 匯款郵局',
							'type' => 'nothing',
							'attr_td1' => array('width' => '200'),
						),
						'fund_transfer_by_post_office_atm_number' => array(
							'label' => '郵政劃撥 | 末五碼',
							'type' => 'nothing',
						),
						'fund_transfer_by_post_office_atm_price' => array(
							'label' => '郵政劃撥 | 匯款金額',
							'type' => 'nothing',
						),
						'fund_transfer_by_post_office_atm_date' => array(
							'label' => '郵政劃撥 | 匯款日期',
							'type' => 'nothing',
						),
						'fund_transfer_by_post_office_atm_comment' => array(
							'label' => '郵政劃撥 | 備註',
							'type' => 'nothing',
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'RID' => array(
							'label' => '美安 RID',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-4">',
								'html_end' => '</span><span class="col-md-4"></span>',
							),
						),
						'Click_ID' => array(
							'label' => '美安 Click_ID',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-4">',
								'html_end' => '</span><span class="col-md-4"></span>',
							),
						),
						'cancelAn' => array(
							'label' => '取消美安訂單',
							'type' => 'nothing',
							'other' => array(
								'html_start' => '<span class="col-md-1"><input type="button" id="cancelAn" value="取消訂單" class="btn red" />',
								'html_end' => '</span><span class="col-md-1"></span><iframe name="hidFrame1" id="hidFrame1" width="0" height="0" style="display:none;"></iframe>',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						'detail_admin' => array(
							'label' => '訂單備註(內部使用)',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail_admin',
								'name' => 'detail_admin',
								'rows' => '8',
								'cols' => '90',
							),
						),
						'detail_cancel' => array(
							'label' => '訂單取消原因',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail_cancel',
								'name' => 'detail_cancel',
								'rows' => '8',
								'cols' => '90',
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


		// $row = $this->cidb->query('select id, FROM_UNIXTIME(`create_time`) as date1 from shoporderform')->result_array();
		// var_dump($row);


		$file = _BASEPATH.'/config/shop.php';
		if(file_exists($file)){
			include $file;
		}

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		//if(isset($this->def['sortable'])){
		//	$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		//}

		$this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/excelexport2').'\'';

		// 這裡只標示付款方式的區塊哦！
		$this->data['section_map'] = array(
			'general' => 0,
			'physical' => 1, // 物流
			'atm' => 2,
			'ecpay_711_no_payment_for_pickup' => 3,
			'ecpay_fami_no_payment_for_pickup' => 4,
			'ecpay_cvs' => 5,
			'ecpay_webatm' => 6,
			'ecpay_vatm' => 7,
			'fund_transfer_by_post_office' => 8,
			'marketan' => 9,
			//'comment' => X,
		);

		// 2020-12-30 這裡是可以連動付款方式和後台欄位區塊
		// 其它sections就自行處理
		$this->data['section_control_auto'] = array(2,3,4,5,6,7,8);//物流 1 不要被處理 2021-05-16 by lota

		// 從前台複製過來的，等確認後，這個要存在資料庫哦！
		// $this->data['payments_tmp'] = array(
		// 	array(
		// 		'name' => 'ATM轉帳',
		// 		'func' => 'atm', // 程式名稱
		// 		'description' => 'xxx', // 就…說明

		// 		// 是否需要通知付款的按鈕
		// 		'payment_notice' => true,

		// 		// 先付還是後付，先付通常是要跑金流，也就是線上付款
		// 		// 後付的話，通常是轉帳、劃撥
		// 		'has_postpay' => true, // ATM是後付

		// 		'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

		// 		'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
		// 	),
		// );

		// $this->data['payments_tmp2'] = array();
		// foreach($this->data['payments_tmp'] as $k => $v){
		// 	$this->data['payments_tmp2'][$v['func']] = $v;
		// }

		// 展開右上角工具列
		// $this->data['tools'] = array(
		// 	array(
		// 		'class' => '',
		// 		'target' => '',
		// 		'url' => $this->createUrl($this->data['router_class'].'/export'),
		// 		'name' => '匯出訂單',
		// 	),
		// );

		$this->def['searchfield']['sections'][$this->data['section_map']['general']]['field']['checkbox_order_status']['attr_td1'] = array('width' => '160');

		// 訂單狀態
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>str_replace('orderform','',$this->data['router_class']).'orderstatus'))->order('sort_id asc')->queryAll();
		$this->data['orderstatus_tmp'] = array();
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				$this->data['orderstatus_tmp'][$v['other1']] = $v['topic'];
				//$this->def['searchfield']['sections'][$this->data['section_map']['general']]['field']['order_status']['other']['values'][$v['other1']] = $v['topic'];
				$this->def['updatefield']['sections'][$this->data['section_map']['general']]['field']['order_status']['other']['values'][$v['other1']] = $v['topic'];
			}
		}

		/*
		 * 我打算規劃的訂單狀態
		 * 0 未付款
		 * 1 己付款
		 * 2 己出貨
		 *
		 * 所有錯誤類的都從11開始
		 * 11 己通知付款
		 * 12 付款失敗
		 * 
		 * 99 取消訂單
		 */
		// $this->data['orderstatus_tmp'] = array(
		// 	0 => '未付款',
		// 	1 => '己付款',
		// 	2 => '己出貨',
		// 	11 => '己通知付款',
		// 	12 => '付款失敗',
		// 	99 => '取消訂單',
		// );

		// $rows = $this->db->createCommand()->from(str_replace('orderform','',$this->data['router_class']).'paymenttype')->where('is_enable=1')->order('sort_id asc')->queryAll();
		// $this->data['paymenttype_tmp'] = array();
		// if($rows and count($rows) > 0){
		// 	foreach($rows as $k => $v){
		// 		$this->data['paymenttype_tmp'][$v['func']] = $v['name'];
		// 	}
		// }

				//if(isset($this->data['paymenttype_tmp'][$v['payment_type']])){
				//	$v['payment_type_name'] = $this->data['paymenttype_tmp'][$v['payment_type']];
				//}

		// 金流，這個寫法或許是暫時的，等欄位和功能都大致確認了以後在考慮寫到資料表裡面
		// $payments_tmp = array(
		// 	array(
		// 		'name' => 'ATM轉帳',
		// 		'func' => 'atm', // 程式名稱
		// 		'description' => 'xxx', // 就…說明

		// 		// 是否需要通知付款的按鈕
		// 		'payment_notice' => true,

		// 		// 先付還是後付，先付通常是要跑金流，也就是線上付款
		// 		// 後付的話，通常是轉帳、劃撥
		// 		'has_postpay' => true, // ATM是後付

		// 		'has_check_finish' => false, // 最後付款的檢查，會幫這裡標示金流成功或是失敗，但這裡代表的不完全是付款成功，而且金流的檢查是否成功，線上刷卡成功，這裡也請標示為成功

		// 		'need_payment_step' => false, // 開始進行任何金流或是付款的動作，這是後續的程式碼在使用的
		// 	),
		// );

		// $this->data['paymenttype_tmp'] = array();
		// foreach($payments_tmp as $k => $v){
		// 	$this->data['paymenttype_tmp'][$v['func']] = $v;
		// }

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		//$this->data['updatecontent']['order_status'] = -1;

		//$condition = 'is_checkout = 0 ';
		$condition = 'is_enable = 1 ';
		//$condition = ' type=\'layoutv2class2\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$condition_sortable = ' type="layoutv2class2" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and !empty($session)){
			$conditions = array();
			//$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					$conditions[] = $k.'='.$v;
					//$conditions_sortable[] = $k.'='.$v;
				} elseif($k == 'checkbox_order_status'){ // 應該要這樣寫才對
					//$conditions[] = 'concat(\',\','.str_replace('checkbox_', '', $k).',\',\') LIKE \'%,'.implode(',', $v).',%\'';
					$tmp = array();
					foreach($v as $vv){
						$tmp[] = 'order_status=\''.$vv.'\' ';
					}
					$conditions[] = '('.implode(' OR ',$tmp).')';
				} elseif($k == 'start_date'){
					if($session['start_date'] != '' and $session['end_date'] != ''){
						//var_dump($session);die;
						//$conditions[] = ' ( create_time >= '.$session['start_date'].' and create_time <= '.$session['end_date'].') ';
						//$conditions[] = ' ( UNIX_TIMESTAMP(create_time) >= '.strtotime($session['start_date'].' 00:00:00').' and UNIX_TIMESTAMP(create_time) <= '.strtotime($session['end_date'].' 23:59:59').') ';
						//$conditions[] = ' ( UNIX_TIMESTAMP(create_time) >= '.strtotime($session['start_date'].' 00:00:00').' and UNIX_TIMESTAMP(create_time) <= '.(strtotime($session['end_date'])+86399).') ';
						//$conditions[] = ' ( DATE(create_time) BETWEEN "'.$session['start_date'].'" AND "'.$session['end_date'].'" ) ';
						$conditions[] = ' `create_time` BETWEEN \"'.$session['start_date'].' 00:00:00\" AND \"'.$session['end_date'].' 23:59:59\" ';
					}
				} elseif($k == 'end_date'){
					// ignore
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					//$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(!empty($conditions)){
				if($condition != ''){
					$condition .= ' AND ';
				}
				$condition .= implode(' AND ', $conditions);
			}
			//var_dump($conditions);
			if($condition != ''){
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			//if(count($conditions_sortable) > 0){
			//	if($condition_sortable != ''){
			//		$condition_sortable .= ' AND ';
			//	}
			//	$condition .= implode(' AND ', $conditions_sortable);
			//}
			//if($condition_sortable != ''){
			//	$this->def['sortable']['condition'] = $condition_sortable;
			//}
			//var_dump($this->def['condition']);
			//die;
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
			//if(trim($condition_sortable) != ''){
			//	$this->def['sortable']['condition'] = $condition_sortable;
			//}
		}

		// 無法帶入的變數中的變數，在這裡帶入
		foreach($this->def['updatefield']['sections'][$this->data['section_map']['general']]['field'] as $k => $v){
			//$v['attr']['size'] = '50';
			$v['attr_td1']['width'] = '130';
			$this->def['updatefield']['sections'][$this->data['section_map']['general']]['field'][$k] = $v;
		}

		foreach($this->def['updatefield']['sections'][$this->data['section_map']['physical']]['field'] as $k => $v){
			//$v['attr']['size'] = '50';
			$v['attr_td1']['width'] = '130';
			$this->def['updatefield']['sections'][$this->data['section_map']['physical']]['field'][$k] = $v;
		}

		//美安訂單的td欄位
		foreach($this->def['updatefield']['sections'][$this->data['section_map']['marketan']]['field'] as $k => $v){
			//$v['attr']['size'] = '50';
			$v['attr_td1']['width'] = '130';
			$this->def['updatefield']['sections'][$this->data['section_map']['marketan']]['field'][$k] = $v;
		}

		return true;
	}

	public function actionOrderprint()
	{
		$id = $_GET['param']; // 訂單在資料庫的主索引編號

		$updatecontent = $this->db->createCommand()->from('shoporderform')->where('id=:id',array(':id'=>$id))->queryRow();

		$log = array();
		$log_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log_'.$x])){
				$log_txt .= $updatecontent['log_'.$x];
			}
		}
		eval($log_txt);
		$updatecontent['details'] = $log;

		$log2 = array();
		$log2_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log2_'.$x])){
				$log2_txt .= $updatecontent['log2_'.$x];
			}
		}
		eval($log2_txt);
		$updatecontent['details2'] = $log2;

		$this->data['updatecontent'] = $updatecontent;

		$this->render('//'.$this->data['router_class'].'/orderprint', $this->data);
	}

	protected function index_last()
	{
		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				$updatecontent = $v;
				$log = array();
				$log_txt = '';
				for($x=1;$x<=20;$x++){
					if(isset($updatecontent['log_'.$x])){
						$log_txt .= $updatecontent['log_'.$x];
					}
				}
				eval($log_txt);

				$_order_number = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-a'.$this->data['current_base64_url'])).'">'.$v['order_number'].'</a>';				
				
				//ATM小鈴鐺
				if($v['is_see']!=1){
					$_order_number = '<i class="icon-bell" style="color:orange"></i>'.$_order_number;
    			}				

				$v['order_number'] = $_order_number;

				

				if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){
					$v['payment_func'] = $log['shipment']['func'];
				}

				// 如果是物流代收款項，那付款方式的型態就會被改成物流的名稱
				if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){
					$v['payment_func'] = $log['shipment']['func'];
				}

				if(isset($this->data['payments_tmp2'][$v['payment_func']]['name'])){
					$v['payment_func_name'] = $this->data['payments_tmp2'][$v['payment_func']]['name'];
				}

				// 如果是物流代收款項，那付款方式就會被改成物流的名稱
				if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){
					$v['payment_func_name'] = $log['shipment']['name'];
				}

				//物流名稱
				if(isset($log['session']['save']['selecxt_physical']['func'])){
					$v['physical_func_name'] = $log['physicals'][$log['session']['save']['selecxt_physical']['func']]['name'];
				}

				if(isset($this->data['orderstatus_tmp'][$v['order_status']])){
					$v['order_status_name'] = $this->data['orderstatus_tmp'][$v['order_status']];
				}

				$this->data['listcontent'][$k] = $v;
			}
		}

		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		$tmp = array();
		if(isset($session['checkbox_order_status']) and !empty($session['checkbox_order_status'])){
			$tmp = $session['checkbox_order_status'];
		}
		//var_dump($tmp);
		//$tmp = explode(',', $this->data['updatecontent']['industry_ids']);
		// 取得所有的群組
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type',array(':type'=>str_replace('orderform','',$this->data['router_class']).'orderstatus'))->order('sort_id')->queryAll();
		//var_dump($rows);
		$groups = array();
		if($rows){
			foreach($rows as $k => $v){
				$groups[$v['other1']]['value'] = $v['topic'];
				if(in_array($v['other1'], $tmp)){
					//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
					$groups[$v['other1']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		//var_dump($groups);
		$this->data['updatecontent']['checkbox_order_status'] = $groups;
	}

	protected function update_show_last($updatecontent)
	{
		//var_dump($updatecontent);die;
		if($updatecontent['is_see']!=1){
			$data = array('is_see' => '1');
			$sql="UPDATE ".$this->data['router_class']." SET is_see='1' WHERE id='".$updatecontent['id']."'";
			$this->cidb->query($sql);
        }
		$log = array();
		$log_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log_'.$x])){
				$log_txt .= $updatecontent['log_'.$x];
			}
		}
		eval($log_txt);
		$updatecontent['details'] = $log;

		$log2 = array();
		$log2_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log2_'.$x])){
				$log2_txt .= $updatecontent['log2_'.$x];
			}
		}
		eval($log2_txt);
		$updatecontent['details2'] = $log2;

		$updatecontent['invoice_addr'] = $updatecontent['recipient_addr'].'　(同收件者地址)';

		$invoice = '';
		if($updatecontent['invoice_type'] == 1){
			$invoice .= '二聯式電子發票 ';
			if($updatecontent['invoice_type_2'] == 1){
				$invoice .= '手機條碼 ';
			} elseif($updatecontent['invoice_type_2'] == 2){
				$invoice .= '自然人憑證條碼 ';
			}
			$invoice .= $updatecontent['invoice_type_2_barcode'];
		} elseif($updatecontent['invoice_type'] == 2){
			$invoice .= '捐贈發票 ';
			$invoice .= ' '.$updatecontent['invoice_donate_name'];
			$invoice .= ' '.$updatecontent['invoice_donate_code'];
		} elseif($updatecontent['invoice_type'] == 4){
			$invoice .= '二聯式紙本發票隨商品寄出 ';
			$invoice .= ' '.$updatecontent['invoice_name'];
			$invoice .= ' '.$updatecontent['invoice_tax_id'];
		} elseif($updatecontent['invoice_type'] == 3){
			$invoice .= '三聯式紙本發票 ';
			$invoice .= ' '.$updatecontent['invoice_name'];
			$invoice .= ' '.$updatecontent['invoice_tax_id'];
		}

		// 串電子發票
		if(isset($updatecontent['invoice_number']) and $updatecontent['invoice_number'] != ''){
			$invoice .= ' '.$updatecontent['invoice_number'];
			$invoice .= ' 開立日期：'.$updatecontent['invoice_date'];
			$invoice .= ' '.$updatecontent['invoice_time'];
		}

		$updatecontent['invoice_type_name'] = $invoice;

		// 如果是物流代收款項，那付款方式的型態就會被改成物流的名稱
		// if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){ //2021-05-16 這行在 艾可眼鏡 測試怪怪的...改成下面的判斷 by lota
		if(isset($log['session']['save']['selecxt_payment']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_payment']['func'])){
			$updatecontent['payment_func'] = $log['shipment']['func'];
		}

		// 付款方式
		// 為所有的付款方式，都留了一塊，如果是用那個付款方式，才會出現
		// 2020-12-29 這個地方的邏輯有點問題，要先從這邊先修
		//if(isset($this->data['section_map']) and !empty($this->data['section_map'])){ 
		//	foreach($this->data['section_map'] as $k => $v){
		//		if($updatecontent['payment_func'] != $k){
		//			if($v > 1){ // 不要把物流給刪掉
		//				unset($this->data['def']['updatefield']['sections'][$v]);
		//			}
		//		}
		//	}
		//}

		// 2020-12-30
		if(isset($this->data['section_map']) and !empty($this->data['section_map'])){ 
			foreach($this->data['section_map'] as $k => $v){
				if(in_array($v,$this->data['section_control_auto'])){
					if($updatecontent['payment_func'] != $k){
						$this->data['def']['updatefield']['sections'][$v]['type'] = 999; // 不顯示，但是陣列元素還存在
					}
				}
			}
		}

		//如果有美安訂單的RID及Click_ID，就顯示區塊及新增取消訂單函式
		if( isset($this->data['MarketAn']) && $this->data['MarketAn']['is_enable'] == 1 && (isset($updatecontent['RID']) && $updatecontent['RID']!='') && (isset($updatecontent['Click_ID']) && $updatecontent['Click_ID']!='') ){
			//do nothing
			$this->data['def']['updatefield']['smarty_javascript_text'] = "
			$('#cancelAn').on('click',function(){
				var orderno = $('#orderno').html();
				//console.log(orderno);
				$.ajax({
					url: \"/_i/backend.php?r=".$this->data['router_class']."/cancelan\",
					//dataType:\"json\",
					type:\"POST\",
					data:{
			    		\"orderno\":orderno,			    
					}
				}).done(function(msg){
					$(\"#hidFrame1\").attr('src',msg);
					alert('成功取消美安訂單!');
					$('#cancelAn').parent().html('已取消');
				});
			});
			";
			if(isset($updatecontent['marketan_cancel']) && $updatecontent['marketan_cancel']==1){
				$this->data['def']['updatefield']['sections'][$this->data['section_map']['marketan']]['field']['cancelAn']['other']['html_start'] = '<span class="col-md-1">已取消</span>';
				$this->data['def']['updatefield']['sections'][$this->data['section_map']['marketan']]['field']['cancelAn']['other']['html_end'] = '';
			}
		} else {
			//unset($this->data['def']['updatefield']['sections'][$this->data['section_map']['marketan']]); // 舊寫法
			$this->data['def']['updatefield']['sections'][$this->data['section_map']['marketan']]['type'] = 999; // 不顯示，但是陣列元素還存在
		}

		//$log['session']['save']['selecxt_physical']['func']

		if(isset($this->data['payments_tmp2'][$updatecontent['payment_func']]['name'])){
			$updatecontent['payment_func_name'] = $this->data['payments_tmp2'][$updatecontent['payment_func']]['name'];
		}

		// 如果是物流代收款項，那付款方式就會被改成物流的名稱
		if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/cash_on_delivery/', $log['session']['save']['selecxt_physical']['func'])){
			$updatecontent['payment_func_name'] = $log['shipment']['name'];
		}

		if(isset($updatecontent['ecpay_webatm_bank_code']) and $updatecontent['ecpay_webatm_bank_code'] != ''){
			if(isset($this->data['bankcodeatm_tmp'][$updatecontent['ecpay_webatm_bank_code']])){
				$updatecontent['ecpay_webatm_bank_code'] = $this->data['bankcodeatm_tmp'][$updatecontent['ecpay_webatm_bank_code']]['name'].' ('.$updatecontent['ecpay_webatm_bank_code'].')';
			}
		}

		if(isset($updatecontent['ecpay_vatm_bank_code']) and $updatecontent['ecpay_vatm_bank_code'] != ''){
			if(isset($this->data['bankcodeatm_tmp'][$updatecontent['ecpay_vatm_bank_code']])){
				$updatecontent['ecpay_vatm_bank_code'] = $this->data['bankcodeatm_tmp'][$updatecontent['ecpay_vatm_bank_code']]['name'].' ('.$updatecontent['ecpay_vatm_bank_code'].')';
			}
		}

		// 補上連結，如果需要的話
		if(isset($log['session']['save']['selecxt_physical']['func']) and preg_match('/^ecpay_(711|fami)_no_payment_for_pickup$/', $log['session']['save']['selecxt_physical']['func'])){
			$updatecontent['payment_func_name'] .= '　<a href="'.$this->createUrl($this->data['router_class'].'/ecpay_no_payment_for_pickup',array('id'=>$this->data['id'])).'">&gt;&gt; 物流訂單傳至綠界</a>'; 
			if(isset($log2['RtnMsg']) and $log2['RtnMsg'] != ''){
				$updatecontent['payment_func_name'] .= '　<br />'.$log2['RtnMsg'];
			}
		}

		//var_dump($log['session']['save']['selecxt_physical']['params']);die;
		if(isset($log['session']['save']['selecxt_physical']['params']['CVSStoreID']) and $log['session']['save']['selecxt_physical']['params']['CVSStoreID'] != ''){
			$updatecontent['CVSStoreName'] = $log['session']['save']['selecxt_physical']['params']['CVSStoreName'];
			$updatecontent['CVSStoreID'] = $log['session']['save']['selecxt_physical']['params']['CVSStoreID'];
			$updatecontent['CVSAddress'] = $log['session']['save']['selecxt_physical']['params']['CVSAddress'];
			$updatecontent['CVSTelephone'] = $log['session']['save']['selecxt_physical']['params']['CVSTelephone'];

			if($log['session']['save']['selecxt_physical']['params']['LogisticsSubType'] == 'UNIMART'){
				$updatecontent['CVSStoreName'] = '統一'.$updatecontent['CVSStoreName'];
			} elseif($log['session']['save']['selecxt_physical']['params']['LogisticsSubType'] == 'FAMI'){
				$updatecontent['CVSStoreName'] = '全家'.$updatecontent['CVSStoreName'];
			}

			// var_dump($log2);die;
			if(isset($log2['AllPayLogisticsID']) and $log2['AllPayLogisticsID'] != ''){
				$updatecontent['CVSPrint'] = '<a href="backend.php?r=shoporderform/order_print_logistics&id='.$updatecontent['id'].'&AID='.$log2["AllPayLogisticsID"].'&type='.$log2["LogisticsSubType"].'&CPNo='.$log2["CVSPaymentNo"].'&CVNo='.$log2['CVSValidationNo'].'" target="_blank" class="btn default"><i class="icon-print"></i>繳費單</a>';

				$updatecontent['LogisticsMsg'] = $log2['RtnMsg'];
				foreach(array('CVSPaymentNo','UpdateStatusDate','AllPayLogisticsID') as $v){
					$updatecontent[$v] = $log2[$v];
				}

						//'CVSPaymentNo' => array(
						//	'label' => '物流 | 寄貨編號/托運單號',
						//	'type' => 'nothing',
						//),
						//'LogisticsMsg' => array(
						//	'label' => '物流 | 物流狀態',
						//	'type' => 'nothing',
						//),
						//'UpdateStatusDate' => array(
						//	'label' => '物流 | 資料更新時間',
						//	'type' => 'nothing',
						//),
						//'AllPayLogisticsID' => array(
						//	'label' => '物流 | 交易編號',
						//	'type' => 'nothing',
						//),
			}
		} else {
			unset($this->data['def']['updatefield']['sections'][$this->data['section_map']['physical']]);
		}

		$this->data['updatecontent'] = $updatecontent;
		
	}

	public function actionOrder_print_logistics()
	{
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
		/**
		* B2C  
		**/
		//include "config.inc.php";

		require('ecpay/ECPay.Logistics.Integration.php'); // 放在母體


		$AID = $_GET["AID"];
		$id = $_GET['id'];

		$updatecontent = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and id=:id',array(':id'=>$id))->queryRow();

		try {
			$AL = new ECPayLogistics();
			//$AL->HashKey = $Config['AllPay']['Logistics_HashKey'];
			//$AL->HashIV = $Config['AllPay']['Logistics_HashIV'];
			$AL->HashKey = $this->data['Config']['AllPay']['HashKey'];
			$AL->HashIV = $this->data['Config']['AllPay']['HashIV'];
			$AL->Send = array(
				'MerchantID' => $this->data['Config']['AllPay']['MerchantID'],
				//'MerchantTradeNo' => $updatecontent['order_number'],
				'AllPayLogisticsID' => $AID,
				'CVSPaymentNo' => $_GET['CPNo'],
				'CVSValidationNo' => $_GET['CVNo'],
				'PlatformID' => ''
			);
			// PrintTradeDoc(Button名稱, Form target)
			//$html = $AL->PrintTradeDoc('產生托運單/一段標','_target');
			//https://shop.gohomer.com.tw/_i/backend.php?r=shoporderform/order_print_logistics&id=33&AID=13187683&type=UNIMARTC2C&CPNo=H0393165&CVNo=8917
			if($_GET['type'] == 'UNIMARTC2C'){
				$html = $AL->PrintUnimartC2CBill('產生托運單/一段標','_target');
			} elseif($_GET['type'] == 'FAMIC2C') {
				$html = $AL->PrintFamilyC2CBill('產生托運單/一段標','_target');
			}
			echo $html;
		} catch(Exception $e) {
			echo $e->getMessage();
		}
    
	}

	public function actionEcpay_no_payment_for_pickup($id)
	{
		$Config = $this->data['Config'];
		$is_site_production = $this->data['is_site_production'];

		$updatecontent = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and id=:id',array(':id'=>$id))->queryRow();
		$log_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log_'.$x])){
				$log_txt .= $updatecontent['log_'.$x];
			}
		}
		eval($log_txt);
		//var_dump($log['shipment']);die;

		// $integration_one=$DB->queryRaw("SELECT * FROM  ".$LANG_DB."`integration` WHERE  `integration`.`OrderNo` =%i",$row['OrderNo']);
		// $row_integration = $integration_one->fetch_assoc();

		//$query_good = "SELECT product_name FROM order_detail WHERE OrderNo =%i";
		//$row_good=$DB->query($query_good,$row['OrderNo']);

		// if($row_integration['S_chk']){
		// 	echo $row_integration['S_chk'];
		// } else {
		// 	echo "未傳送";
		// }

		// $shop_array = array('全家' =>'FAMI','統一' =>'UNIMART','萊爾富' =>'HILIFE');

		// 超商取貨物流訂單幕前建立
		require('ecpay/integration.php'); // 放在母體

		$send = array(
			'MerchantID' => $Config['AllPay']['MerchantID'],
			'MerchantTradeNo' => $updatecontent['order_number'],
			'MerchantTradeDate' => date('Y/m/d H:i:s'),
			'LogisticsType' => LogisticsType::CVS,
			'LogisticsSubType' => $log['session']['save']['selecxt_physical']['params']['LogisticsSubType'],
			'GoodsName' => '訂單編號'.$updatecontent['order_number'].'的商品',
			'GoodsAmount' => (int)$updatecontent['total'], // 商品遺失賠償依據
			'CollectionAmount' => (int)$updatecontent['total'], // 代收金額
			//'IsCollection' => IsCollection::YES,
			'IsCollection' => IsCollection::NO,

			'SenderName' => $Config['AllPay']['SenderName'],
			'SenderPhone' => $Config['AllPay']['SenderPhone'],
			'SenderCellPhone' => $Config['AllPay']['SenderCellPhone'],
			'ReceiverName' => $updatecontent['recipient_name'],
			'ReceiverPhone' => $updatecontent['recipient_phone'],
			//'ReceiverCellPhone' => $updatecontent['recipient_mobile'],
			'ReceiverEmail' => $updatecontent['buyer_login_account'],
			'TradeDesc' => '',
			//'ServerReplyURL' => HOME_URL . '/ServerReplyURL.php',
			//'ClientReplyURL' => BACKEND_DOMAIN.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$id)),
			//'ClientReplyURL' => BACKEND_DOMAIN.$this->createUrl($this->data['router_class'].'/index'),
			'ClientReplyURL' => FRONTEND_DOMAIN.'/client_reply.php?_func='.$log['shipment']['func'],
			'LogisticsC2CReplyURL' => FRONTEND_DOMAIN.'/client_reply.php?_func='.$log['shipment']['func'], // 物流子類型為UNIMARTC2C統一超商交貨便時，此欄位不可為空
			'Remark' => '',
			'PlatformID' => '',
		);

		//設定值如果有代收，就改為要代收金額 by lota 2021-05-16
		if(isset($log['physicals'][$log['session']['save']['selecxt_physical']['func']]['is_collection']) && $log['physicals'][$log['session']['save']['selecxt_physical']['func']]['is_collection'] == true){
			$send['IsCollection'] = IsCollection::YES;
		}

		// 商品遺失賠償依據
		// 文件上是寫1~2萬，但是賠償的上限一樣是1000元
		if($send['GoodsAmount'] > 20000){
			$send['GoodsAmount'] = 20000;
		}

		// 不用代收的情況，代收金額給它零就好了，文件上寫的
		if($send['IsCollection'] == IsCollection::NO){
			$send['CollectionAmount'] = 0;
		}

		// lota
		if(isset($updatecontent['recipient_mobile'])){
			if($updatecontent['recipient_mobile'] == ''){
				$send['ReceiverCellPhone'] = $updatecontent['recipient_phone'];
			} else {
				$send['ReceiverCellPhone'] = $updatecontent['recipient_mobile'];
			}
		}

		// var_dump($send);die;

		if($is_site_production === true){
			$id_number = substr(md5(rand(1, 1000000)),0,15);
			$save = array(
				'id_number' => $id_number,
				'session_id' => 'xxx',
				'func' => $log['shipment']['func'].'_server_reply',
				'url1' => 'xxx',
				'url2' => FRONTEND_DOMAIN.'/reply.php',
				'back' => 'xxx',
				'is_enable' => '1',
				'create_time' => date('Y-m-d H:i:s'),
			);
			$this->cidb->insert('short', $save); 
			$id = $this->cidb->insert_id();
			$send['ServerReplyURL'] = FRONTEND_DOMAIN.'/short.php?id='.$id_number;
		} else {
			$public_key = EIP_APIV1_PUBLICKEY;
			$private_key = EIP_APIV1_PRIVATEKEY;
			$server_ip = EIP_APIV1_DOMAIN;
			$url = 'index.php?r=api/short';

			$params = array(
				'url' => 'xxx',
				'url2' => FRONTEND_DOMAIN.'/reply.php',
				'func' => $log['shipment']['func'].'_server_reply',
				'_____session_id' => 'xxx', // 因為會跟EIPAPI的衝到，而且這裡用不到
				'back' => 'xxx', // 子站的reply處理完後，要去的地方，但這裡用不到
			);

			// 這支是客戶端

			$postdata = http_build_query(
				array(
					'get_client_code' => '',
				)
			);
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);
			$context  = stream_context_create($opts);
			$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

			//$code = stripslashes($code);
			eval('?'.'>'.$code);

			// debug
			//var_dump($result);die;

			// 會回傳以下的元素
			// url
			// id_number
			// $row = $return;
			//var_dump($return);die;
			if(isset($return) and !empty($return)){
				$send['ServerReplyURL'] = EIP_APIV1_DOMAIN . '/short.php?id='.$return['id_number'];
			}
		}

		try {
			$AL = new ECPayLogistics();
			$AL->HashKey = $Config['AllPay']['HashKey'];
			$AL->HashIV = $Config['AllPay']['HashIV'];
			$AL->Send = $send;
			$AL->SendExtend = array(
				'ReceiverStoreID' => $log['session']['save']['selecxt_physical']['params']['CVSStoreID'],
				'ReturnStoreID' => $log['session']['save']['selecxt_physical']['params']['CVSStoreID'],
			);
			// CreateShippingOrder(Button名稱, Form target)
			$html = $AL->CreateShippingOrder('物流訂單傳至綠界');
			$szHtml =  '<!DOCTYPE html>';
			$szHtml .= '<html>';
			$szHtml .=     '<head>';
			$szHtml .=         '<meta charset="utf-8">';
			$szHtml .=     '</head>';
			$szHtml .=     '<body>';
			$szHtml .=         $html;
			$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
			$szHtml .=     '</body>';
			$szHtml .= '</html>';
			echo $szHtml;
			die;
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	} // function actionEcpay_no_payment_for_pickup

	// 這個地方，剛開始是為了要寫電子發票的程式要寫在這裡，才打開的
	// 如果訂單狀態更改成己出貨的時候，那就會經過電子發票的程式碼
	// 如果這個網站有申請電子發票的時候
	protected function update_run_other_element($array)
	{

		// 儲存後，轉到列表頁 #12645
		// 或是在update_show_last最末行，加上unset($this->data['update_base64_url'])
		// $array['update_base64_url'] = '';

		// $this->redirect($this->createUrl($this->data['router_class'].'/index'));

		if(
			isset($this->data['id'])
			and $this->data['id'] > 0
		){
			$row = $this->cidb->where('id',$this->data['id'])->get('shoporderform')->row_array();
		} else {
			return $array; // 略過這個步驟，為了減少程式碼的層次，所以才這樣子寫
		}

		if(!$row or !isset($row['id'])){
			return $array; // 略過這個步驟，為了減少程式碼的層次，所以才這樣子寫
		}

		// 訂單狀態
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>str_replace('orderform','',$this->data['router_class']).'orderstatus'))->order('sort_id asc')->queryAll();	
		$gOrderStatus = array();	
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				$gOrderStatus[$v['other1']] = $v['topic'];				
			}
		}

		$cc_mail = $row['buyer_login_account'];
		$cus_name = $row['buyer_name'];
		$cus_order = $row['order_number'];
		$url_list = aaa_url;

		$aaa_admin_title = $this->data['sys_configs']['admin_title'];

		$subject = '訂單狀態更變';

		$body_html_content = '';
		$body_html_content .= '訂單編號 '.$cus_order.'<br>';
		$body_html_content .= '＊此郵件是系統自動發送，請勿直接回覆此郵件！<br>';
		$body_html_content .= $cus_name.'您好，<br>';
		$body_html_content .= '變更狀態：'.$gOrderStatus[$array['order_status']].'<br>';
		if(!empty($_POST['detail_cancel']) && $array['order_status']== 99){
		$body_html_content .= '取消原因：'.$_POST['detail_cancel'].'<br>';
		}	
		$body_html_content .= '為了保護您的個人資料安全，本通知信將不顯示訂單明細。<br>';
		$body_html_content .= '請至以下網頁，登入查詢您的訂單明細：'.$url_list.'<br>';
		$body_html_content .= '感謝您對'.$aaa_admin_title.'的支持與信賴，如有任何需要服務的地方，<br>';
		$body_html_content .= '歡迎與我們聯繫，再次感謝您的訂購。<br>';

		$body_html_content .= ob_get_clean();
		$body = '';

		$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="0" cellpadding="4" cellspacing="1" bordercolorlight="#ffffff" bordercolordark="#666666" bgcolor="#CCCCCC" >
$body_html_content
</table>
<p style="font-size:13px;color:#999">網址: $url_list</p>
XXX;


		//變更狀態就寄信
		//寄信通知 - for 管理者	by lota

		//// 信件格式
		//$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>'後台新訂單通知',':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
//
		//// 主旨
		//$subject = $this->data['sys_configs']['admin_title'].' 新進訂單通知';
//
		//if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
		//	$email_topic = $emailformat['topic'];
		//	$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
		//	// 記得最後要加上這一行，把多餘的額外欄位刪掉
		//	for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
		//	$subject = $email_topic;
		//}
//
		//$aaa_url = aaa_url;
		//$aaa_name = $member['name']; //購買者姓名
		//$aaa_admin_title = $this->data['sys_configs']['admin_title'];
//
		////信件內容(TXT版)，由後台撈取
		//if($emailformat and isset($emailformat['id']) and $emailformat['detail'] != ''){
		//	$email_content = $emailformat['detail'];
//
		//	$email_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_content);
		//	$email_content = str_replace('{BB}', $aaa_name, $email_content);
		//	$email_content = str_replace('{CC}', $aaa_url, $email_content);		
//
		//	// 記得最後要加上這一行，把多餘的額外欄位刪掉
		//	for($x=65;$x<=(65+26);$x++) $email_content = str_replace('{'.chr($x).'}', '', $email_content);
//
		//	$body = $email_content;
		//}
//
		////信件內容(HTML版)，由後台撈取
		//if($emailformat and isset($emailformat['id'])){
		//	if($emailformat['field_tmp'] != ''){
		//		$email_html_content = $emailformat['field_tmp'];
//
		//		$email_html_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_html_content);
		//		$email_html_content = str_replace('{BB}', $aaa_name, $email_html_content);
		//		$email_html_content = str_replace('{CC}', $aaa_url, $email_html_content);		
//
		//		// 記得最後要加上這一行，把多餘的額外欄位刪掉
		//		for($x=65;$x<=(65+26);$x++) $email_html_content = str_replace('{'.chr($x).'}', '', $email_html_content);
//
		//		$body_html = $email_html_content;
		//	} elseif($emailformat['field_tmp'] == '' and $emailformat['detail'] != ''){
		//		$body_html = nl2br($email_content);
		//	}
		//}

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

		if($from and !empty($from) and isset($from['id']) and isset($from['email']) and $tos and !empty($tos) and isset($tos[0]['id'])){ //後台信箱有設定才會寄信

			if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
				$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,$cc_mail);
			} else {
				$this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
			}
		}


		// 只有其它狀態，切換到己出貨的情況，才會繼續跑下面的電子發票
		if($row['order_status'] != 2 and $array['order_status'] == 2){
			// do nothing
		} else {
			return $array; // 略過這個步驟，為了減少程式碼的層次，所以才這樣子寫
		}

		$updatecontent = $row;
		$is_site_production = $this->data['is_site_production'];

		// 從上面複製下來的
		$log = array();
		$log_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log_'.$x])){
				$log_txt .= $updatecontent['log_'.$x];
			}
		}
		eval($log_txt);
		$updatecontent['details'] = $log;

		$log2 = array();
		$log2_txt = '';
		for($x=1;$x<=20;$x++){
			if(isset($updatecontent['log2_'.$x])){
				$log2_txt .= $updatecontent['log2_'.$x];
			}
		}
		eval($log2_txt);
		$updatecontent['details2'] = $log2;

		
		// 是否需啟用電子發票 invoice
		unset($_constant_1);
		eval('$_constant_1 = '.strtoupper('shop_show_electronic_invoice').';');
	if(0){		

		try
		{

			$sMsg = '' ;
			require('ecpay/Ecpay_Invoice.php'); // 放在母體

			// 1.載入SDK

			$ecpay_invoice = new EcpayInvoice;
 

//try{
//$ecpay_invoice->Invoice_Method   = 'INVOICE_DELAY' ;
//$ecpay_invoice->Invoice_Url   = 'https://einvoice-stage.ecpay.com.tw/Invoice/DelayIssue';
//$ecpay_invoice->MerchantID   = '2000132';
//$ecpay_invoice->HashKey   = 'ejCk326UnaZWKisg';
//$ecpay_invoice->HashIV    = 'q9jcZX8Ib9LM8wYk';
//$aItems = array();
//array_push($ecpay_invoice->Send['Items'], array('ItemName' => '商品名稱一', 'ItemCount' => 1, 'ItemWord' => '批', 'ItemPrice' => 100, 'ItemTaxType' => 1, 'ItemAmount' => 100 ));
//array_push($ecpay_invoice->Send['Items'], array('ItemName' => '商品名稱二', 'ItemCount' => 2, 'ItemWord' => '件', 'ItemPrice' => 200, 'ItemTaxType' => 1, 'ItemAmount' => 400 ));
//$RelateNumber = 'ECPAY'. date('YmdHis') . rand(1000000000,2147483647);
//$ecpay_invoice->Send['RelateNumber']   = $RelateNumber;
//$ecpay_invoice->Send['CustomerID']   = '';
//$ecpay_invoice->Send['CustomerIdentifier']  = '';
//$ecpay_invoice->Send['CustomerName']   = '';
//$ecpay_invoice->Send['CustomerAddr']   = '';
//$ecpay_invoice->Send['CustomerPhone']   = '';
//$ecpay_invoice->Send['CustomerEmail']   = 'test@localhost.com';
//$ecpay_invoice->Send['ClearanceMark']   = '';
//$ecpay_invoice->Send['Print']    = '0';
//$ecpay_invoice->Send['Donation']   = '2';
//$ecpay_invoice->Send['LoveCode']   = '';
//$ecpay_invoice->Send['CarruerType']   = '';
//$ecpay_invoice->Send['CarruerNum']   = '';
//$ecpay_invoice->Send['TaxType']   = '1';
//$ecpay_invoice->Send['SalesAmount']   = '500';
//$ecpay_invoice->Send['InvoiceRemark']   = 'SDK TEST'; 
//$ecpay_invoice->Send['InvType']   = '07';
//$ecpay_invoice->Send['DelayFlag']   = '1';
//$ecpay_invoice->Send['DelayDay']   = '1';
//$ecpay_invoice->Send['ECBankID']   = '';
//$ecpay_invoice->Send['Tsr']    = $RelateNumber;
//$ecpay_invoice->Send['PayType']   = '2';
//$ecpay_invoice->Send['PayAct']   = 'ALLPAY';
//$ecpay_invoice->Send['NotifyURL']   = '';
//$aReturn_Info = $ecpay_invoice->Check_Out();
//foreach($aReturn_Info as $key => $value)
//{
// $sMsg .=   $key . ' => ' . $value . '<br>' ; 
//}
//}
//catch (Exception $e)
//{
//$sMsg = $e->getMessage();
//}
//echo 'RelateNumber=>' . $RelateNumber.'<br>'.$sMsg ;
//die;

			// 2.寫入基本介接參數
			// https://vendor-stage.ecpay.com.tw/
			// StageTest / test1234
			$ecpay_invoice->Invoice_Method 	= 'INVOICE_DELAY';
			$ecpay_invoice->Invoice_Url 	= $this->data['Config']['Allpay']['InvoiceDelayURL'];
			$ecpay_invoice->MerchantID 		= $this->data['Config']['AllPay']['MerchantID'];
			$ecpay_invoice->HashKey 		= $this->data['Config']['AllPay']['InvoiceHashKey'];
			$ecpay_invoice->HashIV 			= $this->data['Config']['AllPay']['InvoiceHashIV'];

			// 3.寫入發票相關資訊
			//$aItems	= array();
			$send = array(
				'Items' => array(),
			);

			// 商品資訊

			/*
			 * ["calculate_logs"]=>
			 *	array(3) {
			 *		[0]=>
			 *			array(2) {
			 *				[0]=>
			 *					string(6) "合計"
			 *					[1]=>
			 *					string(4) "$290"
			 *			}
			 *		[1]=>
			 *			array(2) {
			 *				[0]=>
			 *					string(6) "運費"
			 *					[1]=>
			 *					string(3) "$50"
			 *			}
			 *		[2]=>
			 *			array(2) {
			 *				[0]=>
			 *					string(6) "總計"     字數限制100個字元！！！
			 *					[1]=>
			 *					string(4) "$340"
			 *			}
			 *	}
			 */

			//var_dump($log);die;

			//SELECT * FROM  ".$LANG_DB."`order_detail` WHERE  `OrderNo` =%s

			//$query_or = "SELECT * FROM  ".$LANG_DB."`order_detail` WHERE  `OrderNo` =%s";
			//$order_detail = $DB->query($query_or,$_POST['OrderNo']);

			//$discountMode = Array('', '', '全館折扣', '館滿額折扣', '滿件折扣');
			//print_r($order_detail);


			if(isset($log['car']) and !empty($log['car'])){
				foreach($log['car'] as $k => $v){
					array_push($send['Items'], array('ItemName' => $v['item']['name'], 'ItemCount' => $v['amount'], 'ItemWord' => '單位', 'ItemPrice' => (int)$v['item']['price'], 'ItemTaxType' => 1, 'ItemAmount' => $v['item']['price'] * $v['amount'], 'ItemRemark' => '商品備註' ));
				}
			}

			if(isset($updatecontent['details']['calculate_logs']) and !empty($updatecontent['details']['calculate_logs'])){
				foreach($updatecontent['details']['calculate_logs'] as $k => $v){
					$name = $v[0];
					$price = $v[1];
					$price = str_replace('$','',$price);
					$price = str_replace(',','',$price);
					$price = intval($price);

					if(preg_match('/^(合計|總計|運費)$/',$name)) continue;
					if($price >= 0){
						array_push($send['Items'], array('ItemName' => $name, 'ItemCount' => 1, 'ItemWord' => '單位', 'ItemPrice' => $price, 'ItemTaxType' => 3, 'ItemAmount' => $price, 'ItemRemark' => '備註'  )) ;
					}					
				}
			}

			// 產生測試用自訂訂單編號
			//$RelateNumber='ECPAY'.date('YmdHis').str_pad($row['OrderNo'], 10, "0", STR_PAD_LEFT);

			$RelateNumber = $updatecontent['order_number'];

			// lota說vencen說，三聯就會寄，二聯都不會寄 2017/03/13
			//if($log['invoice']['invoice_type'] == 3){
			//	$Print = 1;
			//} else {
			//	$Print = 0;
			//}
			// jonathan說 發票要可以列印
			$Print = 1;

			$CarruerType = '';
			$CarruerNum = '';
			$CustomerName = $updatecontent['recipient_name'];

			if($log['invoice']['invoice_type'] == '1'){
				$CarruerNum = $log['invoice']['invoice_type_2_barcode'];
				if($log['invoice']['invoice_type_2'] == '1'){
					$CarruerType = '3';
				} elseif($log['invoice']['invoice_type_2'] == '2'){
					$CarruerType = '2';
				}
			} elseif($log['invoice']['invoice_type'] == '3'){
				$CustomerName = $updatecontent['invoice_name'];
			}

			$Donation = 2; // 預設不捐
			$LoveCode = '';

			if($log['invoice']['invoice_type'] == '2'){
				$Donation = 1;
				$LoveCode = $log['invoice_config']['donate_code'];
			}

			// 請填寫半型數字勿用-或空格(例:0912345789)
			$CustomerPhone = $updatecontent['recipient_phone'];
			$CustomerPhone = str_replace('-','',$CustomerPhone);
			$CustomerPhone = str_replace(' ','',$CustomerPhone);

			$send['RelateNumber'] 		= $RelateNumber ;
			$send['CustomerID'] 		= $updatecontent['customer_id'];
			$send['CustomerIdentifier']	= $updatecontent['invoice_tax_id'];
			$send['CustomerName'] 		= $CustomerName;
			$send['CustomerAddr'] 		= $updatecontent['recipient_addr'];
			$send['CustomerPhone'] 		= $CustomerPhone;
			$send['CustomerEmail'] 		= $updatecontent['buyer_login_account'];
			$send['ClearanceMark'] 		= '' ;//當課稅類別[TaxType]為2(零稅率)時，則該參數請帶1(經海關出口)或2(非經海關出口)

			$send['Print'] 				= $Print; //捐贈的話帶0
			$send['Donation'] 			= $Donation; //1:捐贈2:不捐
			$send['LoveCode'] 			= $LoveCode; //捐贈時要有值

			$send['CarruerType'] 		= $CarruerType; //載具類別
			$send['CarruerNum']			= $CarruerNum; //載具編號

			$send['TaxType'] 			= 1;//課稅類別
			$send['SalesAmount'] 		= $updatecontent['total'];
			$send['InvoiceRemark'] 		= '' ;	
			$send['InvType'] 			= '07' ;

			$send['DelayFlag']			= '1'; //1:延遲開立2:觸發開立
			$send['DelayDay']			= '15';//delay 天數
			$send['ECBankID']			= '';
			$send['Tsr']				= $updatecontent['order_number'];
			$send['PayType']			= '2';
			$send['PayAct']				= 'ALLPAY';

			if($is_site_production === true){
				$id_number = substr(md5(rand(1, 1000000)),0,15);
				$save = array(
					'id_number' => $id_number,
					'session_id' => 'xxx',
					'func' => 'ecpay_invoice_delay',
					'url1' => 'xxx',
					'url2' => FRONTEND_DOMAIN.'/reply.php',
					'back' => 'xxx',
					'is_enable' => '1',
					'create_time' => date('Y-m-d H:i:s'),
				);
				$this->cidb->insert('short', $save); 
				$id = $this->cidb->insert_id();
				$send['NotifyURL'] = FRONTEND_DOMAIN.'/short.php?id='.$id_number;
			} else {
				$public_key = EIP_APIV1_PUBLICKEY;
				$private_key = EIP_APIV1_PRIVATEKEY;
				$server_ip = EIP_APIV1_DOMAIN;
				$url = 'index.php?r=api/short';

				$params = array(
					'url' => 'xxx',
					'url2' => FRONTEND_DOMAIN.'/reply.php',
					'func' => 'ecpay_invoice_delay',
					'_____session_id' => 'xxx', // 因為會跟EIPAPI的衝到，而且這裡用不到
					'back' => 'xxx', // 子站的reply處理完後，要去的地方，但這裡用不到
				);

				// 這支是客戶端

				$postdata = http_build_query(
					array(
						'get_client_code' => '',
					)
				);
				$opts = array('http' =>
					array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						'content' => $postdata
					)
				);
				$context  = stream_context_create($opts);
				$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

				//$code = stripslashes($code);
				eval('?'.'>'.$code);

				// debug
				//var_dump($result);die;

				// 會回傳以下的元素
				// url
				// id_number
				// $row = $return;
				//var_dump($return);die;
				if(isset($return) and !empty($return)){
					$send['NotifyURL'] = EIP_APIV1_DOMAIN . '/short.php?id='.$return['id_number'];
				}
			}

			//echo '<meta charset="utf-8">';
			//var_dump($send);die;

			// 3.送出
			$ecpay_invoice->Send = $send;
			$aReturn_Info = $ecpay_invoice->Check_Out();

			// 4.返回1
			foreach($aReturn_Info as $key => $value)
			{
				$sMsg .= $key.' => '.$value.'<br/>';	
			}

			//echo '<meta charset="utf-8">';
			//var_dump($aReturn_Info);die;
			if(isset($aReturn_Info['RtnCode']) and $aReturn_Info['RtnCode'] == 1){ //成功的話
				// do nothing
			} else {
				G::alert_and_redirect('電子發票上傳失敗!', $this->createUrl($this->data['router_class'].'/index'),$this->data);
			}

		}
		catch (Exception $e)
		{
			// 例外錯誤處理。
			//$sMsg = $e->getMessage();
			G::alert_and_redirect($e->getMessage(), $this->createUrl($this->data['router_class'].'/index'),$this->data);
		}
	}

		return $array;
	}

	/*
	 * 通用匯出Excel的功能
	 *
	 * 這裡是複製母體那邊過來改的
	 */
	// Merge cells 合併、與分離單元格
	// $objPHPExcel->getActiveSheet()->mergeCells('A18:E22');
	// $objPHPExcel->getActiveSheet()->unmergeCells('A18:E22');
	public function actionExcelexport()
	{
		//引入函式庫
		include 'Classes/PHPExcel.php';	
		header("Content-Type:text/html; charset=utf-8");

		$admin_field = $this->def['updatefield']['sections'][$this->data['section_map']['general']]['field'];

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

		// 增加欄位，例如訂單內容，要加在訂單狀態的下面
		$admin_field_tmp = $admin_field;
		$admin_field = array();		
		

		$query = 'SELECT * FROM '.$this->data['router_class'];
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
		// 增加欄位，例如訂單內容，要加在訂單狀態的下面
		if($admin_field and !empty($admin_field)){
			foreach($admin_field as $k => $v){
				$admin_field[$k] = $v;
				if($k == 'order_status'){
					$admin_field['order_content__k'] = array(
						'label' => '產品流水號',
					);
					$admin_field['order_content__name'] = array(
						'label' => '產品名稱',
					);
					$admin_field['order_content__spec'] = array(
						'label' => '產品規格',
					);
					$admin_field['order_content__price'] = array(
						'label' => '產品價格',
					);
					$admin_field['order_content__amount'] = array(
						'label' => '產品金額',
					);
					$admin_field['order_content__total'] = array(
						'label' => '產品小計',
					);
					$admin_field['sum'] = array(
						'label' => '合計',
					);
					$admin_field['shipment'] = array(
						'label' => '運費',
					);
					$admin_field['total'] = array(
						'label' => '總計',
					);
				}
			}
		}

		// 把特定欄位拿掉
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){

				// 將log解開
				$log_txt = '';
				for($x=1;$x<=20;$x++){
					if(isset($v['log_'.$x])){
						$log_txt .= $v['log_'.$x];
					}
				}
				eval($log_txt);
				$v['details'] = $log;

				// 合併部份的欄位
				// blha... blha...

				$rows[$k] = $v;

				if($admin_field and !empty($admin_field)){
					foreach($admin_field as $kk => $vv){
						if(preg_match('/^(invoice_addr)$/', $kk)){
							unset($admin_field[$kk]);
						}
					}
				}
			}
		}

		/** PHPExcel_Writer_Excel2007 */
		include 'Classes/PHPExcel/Writer/Excel2007.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set properties
		$objPHPExcel->getProperties()->setCreator("Buyersline");
		$objPHPExcel->getProperties()->setLastModifiedBy("Buyersline");
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Product Document");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Product Document");
		$objPHPExcel->getProperties()->setDescription("Product Document for Office 2007 XLSX");

		$row_current = 1; // row就是一筆一筆，而column是一個欄位一個欄位

		$column_merge_end_admin_title = 64; // 幾個欄位，就是要合併幾個
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row_current, $this->data['sys_configs']['admin_title'].' - 訂單匯出');
		$row_current += 1;

		$column_merge_end_export_date = 64;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row_current, '匯出日期');
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row_current, date('Y-m-d H:i:s'));
		$row_current += 1;

		// 先跳過標題
		$row_current += 1;

		// 資料
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				$order_content_handle = false; // 只會處理一次
				if($admin_field and !empty($admin_field)){
					$i = 0;
					foreach($admin_field as $kk => $vv){
						if($kk == 'is_enable'){
							$value = $v[$kk];
							if($value == '0'){
								$value = '停用';
							} else {
								$value = '啟用';
							}
						} elseif($kk == 'gender'){
							$value = $v[$kk];
							if($value == '1'){
								$value = '男';
							} else {
								$value = '女';
							}
						} elseif($kk == 'order_status'){
							$value = $this->data['orderstatus_tmp'][$v[$kk]];
						} elseif($kk == 'payment_func_name'){
							if(isset($this->data['payments_tmp2'][$v['payment_func']])){
								$value = $this->data['payments_tmp2'][$v['payment_func']]['name'];
							}else{
								$value = '';
							}
						} elseif($kk == 'invoice_type_name'){
							if($v['invoice_type'] == 1){
								$value = '二聯式電子發票 ';
								if($v['invoice_type_2'] == 1){
									$value .= '手機條碼 ';
								} elseif($v['invoice_type_2'] == 2){
									$value .= '自然人憑證條碼 ';
								}
								$value .= $v['invoice_type_2_barcode'];
							} elseif($v['invoice_type'] == 2){
								$value = '捐贈發票 ';
								$value .= ' '.$v['invoice_donate_name'];
								$value .= ' '.$v['invoice_donate_code'];
							} elseif($v['invoice_type'] == 3){
								$value = '三聯式紙本發票 ';
								$value .= ' '.$v['invoice_name'];
								$value .= ' '.$v['invoice_tax_id'];
							}
						} elseif(preg_match('/^order_content__(.*)$/', $kk, $matches)){
							if($order_content_handle === false){
								$row_current_tmp = $row_current; // 不想要覆寫，不然後面會有問題
								if(isset($v['details']['car']) and !empty($v['details']['car'])){
									$ggg = 0;
									foreach($v['details']['car'] as $kkk => $vvv){
										$sss = 0;
										$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $ggg+1);
										$sss++;
										$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['item']['name']);
										$sss++;
										$spec = '';
										if(isset($vvv['specs']) and !empty($vvv['specs'])){
											foreach($vvv['specs'] as $kkkk => $vvvv){
												$spec .= $vvvv['value'];
											}
										}elseif(isset($vvv['spec']) and !empty($vvv['spec']) ){
											$spec .= $vvv['spec'];
										}
										$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $spec);
										$sss++;
										$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['item']['price']);
										$sss++;
										$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['amount']);
										$sss++;
										$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['item']['price']*$vvv['amount']);

										$row_current_tmp++;
										$ggg++;
									}
								}
								$order_content_handle = true;
							}
						} else {
							$value = $v[$kk];
						}

					// $admin_field['order_content__k'] = array(
					// $admin_field['order_content__name'] = array(
					// $admin_field['order_content__spec'] = array(
					// $admin_field['order_content__price'] = array(
					// $admin_field['order_content__amount'] = array(
					// $admin_field['order_content__total'] = array(

						if(!preg_match('/^order_content__(.*)$/', $kk)){
							$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+65).$row_current, $value);

							$objPHPExcel->getActiveSheet()->getColumnDimension(chr($i+65))->setAutoSize(true);
						}

						if(count($v['details']['car']) > 1 and !preg_match('/^order_content__(.*)$/', $kk)){
							$objPHPExcel->getActiveSheet()->mergeCells(chr($i+65).$row_current.':'.chr($i+65).($row_current + (count($v['details']['car']) - 1)));
							$objPHPExcel->getActiveSheet()->getStyle(chr($i+65).$row_current)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						}

						if($kk == 'order_content'){
						} else {
							$i++;
						}
					}
				}
				$row_current += count($v['details']['car']);
			}
		}

		// 標題
		$row_current = 3;
		$objPHPExcel->setActiveSheetIndex(0);
		if($admin_field and !empty($admin_field)){
			$i = 0;
			foreach($admin_field as $k => $v){
				$objPHPExcel->getActiveSheet()->SetCellValue(chr($i+65).$row_current, $v['label']);

				// 標題背景色
				$objPHPExcel->getActiveSheet()->getStyle(chr($i+65).$row_current)->applyFromArray(
					array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'FF99CC')
						)
					)
				);

				$column_merge_end_admin_title += 1;
				$column_merge_end_export_date += 1;

				$i++;
			}
		}

		$objPHPExcel->getActiveSheet()->mergeCells('A1:'.chr($column_merge_end_admin_title).'1');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:'.chr($column_merge_end_export_date).'2');

		// 合併訂單標題內容(寫死的哦，有異動自己去改)
		// $objPHPExcel->getActiveSheet()->mergeCells('K3:P3');
		// $objPHPExcel->getActiveSheet()->SetCellValue('K3', '產品名稱 / 規格 / 金額 / 數量 / 小計 / 合計');
		$spreadsheet->getActiveSheet()->SetCellValue('M3','產品名稱');
		$spreadsheet->getActiveSheet()->SetCellValue('N3','規格');
		$spreadsheet->getActiveSheet()->SetCellValue('O3','金額');
		$spreadsheet->getActiveSheet()->SetCellValue('P3','數量');
		$spreadsheet->getActiveSheet()->SetCellValue('Q3','小計');
		$spreadsheet->getActiveSheet()->SetCellValue('R3','應付金額');

		// 加上Filter
		// 這個地方還沒有測過，但是通用匯出的函式己經測過了
		$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());

		// Save Excel 2007 file
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$file = trim(str_replace('　','',$this->data['main_content_title'])).'-'.date('Y-m-d-H-i-s').'.xlsx';
		if(preg_match('/(MSIE|Trident)/', $_SERVER['HTTP_USER_AGENT'])){
			$file = iconv('utf-8','big5',$file);
		}
		header('Content-Disposition: attachment;filename="'.$file.'"');
		//header('Content-Disposition: attachment;filename="'.trim(str_replace('　','',$this->data['main_content_title'])).'-'.date('Y-m-d-H-i-s').'.xlsx"');

		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		die;
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
			$query .= ' WHERE '.stripslashes($this->def['condition'][0][1]);
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

		//詳細產品資料區塊 
		// 增加欄位，例如訂單內容，要加在訂單狀態的下面
		if($admin_field and !empty($admin_field)){
			foreach($admin_field as $k => $v){
				$admin_field[$k] = $v;
				if($k == 'order_status'){
					$admin_field['order_content__k'] = array(
						'label' => '產品流水號',
					);
					$admin_field['order_content__name'] = array(
						'label' => '產品名稱',
					);
					$admin_field['order_content__spec'] = array(
						'label' => '產品規格',
					);
					$admin_field['order_content__price'] = array(
						'label' => '產品價格',
					);
					$admin_field['order_content__amount'] = array(
						'label' => '產品金額',
					);
					$admin_field['order_content__total'] = array(
						'label' => '產品小計',
					);
					$admin_field['sum'] = array(
						'label' => '合計',
					);
					$admin_field['shipment'] = array(
						'label' => '運費',
					);
					$admin_field['total'] = array(
						'label' => '總計',
					);
					$admin_field['payment_func_name'] = array(
						'label' => '付款方式',
					);
					// $admin_field['invoice_type_name'] = array(
					// 	'label' => '發票',
					// );
				}
			}
		}

		// var_dump($admin_field);die;

		// 把特定欄位拿掉
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){

				// 將log解開
				$log_txt = '';
				for($x=1;$x<=20;$x++){
					if(isset($v['log_'.$x])){
						$log_txt .= $v['log_'.$x];
					}
				}
				eval($log_txt);
				$v['details'] = $log;
				
				// 合併部份的欄位
				// blha... blha...

				$rows[$k] = $v;

				if($admin_field and !empty($admin_field)){
					foreach($admin_field as $kk => $vv){
						if(preg_match('/^(invoice_addr)$/', $kk)){
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


		$row_current = 1; // row就是一筆一筆，而column是一個欄位一個欄位

		$column_merge_end_admin_title = 64; // 幾個欄位，就是要合併幾個
		$spreadsheet->getActiveSheet()->SetCellValue('A'.$row_current, $this->data['sys_configs']['admin_title'].' - 訂單匯出');
		$row_current += 1;

		$column_merge_end_export_date = 64;
		$spreadsheet->getActiveSheet()->SetCellValue('A'.$row_current, '匯出日期');
		$spreadsheet->getActiveSheet()->SetCellValue('B'.$row_current, date('Y-m-d H:i:s'));
		$row_current += 1;

		// 先跳過標題
		$row_current += 1;

		// 標題
		// $spreadsheet->setActiveSheetIndex(0);
		// $sheet = $spreadsheet->getActiveSheet();
		// if($admin_field and !empty($admin_field)){
		// 	$i = 1;
		// 	foreach($admin_field as $k => $v){
		// 		$sheet->setCellValue(Coordinate::stringFromColumnIndex($i).'1', $v['label']);
		// 		$i++;
		// 	}
		// }


		// 資料
		// if($rows and !empty($rows)){
		// 	foreach($rows as $k => $v){
		// 		if($admin_field and !empty($admin_field)){
		// 			$i = 1;
		// 			foreach($admin_field as $kk => $vv){
		// 				$value = $v[$kk];
		// 				if($kk == 'is_enable'){
		// 					if($value == '0'){
		// 						$value = '停用';
		// 					} else {
		// 						$value = '啟用';
		// 					}
		// 				} elseif($kk == 'gender'){
		// 					if($value == '1'){
		// 						$value = '男';
		// 					} elseif($value == '2'){
		// 						$value = '女';
		// 					}
		// 				}
		// 				$sheet->SetCellValueExplicit(Coordinate::stringFromColumnIndex($i).($k+2), (string)$value,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); // 2019-07-17 為了要能夠讀取開頭為零的純數字

		// 				if(preg_match('/^pic/', $kk)){
		// 					//$objDrawingPType = new PHPExcel_Worksheet_Drawing();
		// 					//$objDrawingPType->setWorksheet($objPHPExcel->getActiveSheet());
		// 					//$objDrawingPType->setPath($this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$value);
		// 					//$objDrawingPType->setCoordinates(chr($i+65).($k+2));
		// 					//$objDrawingPType->setHeight(100);

		// 					$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		// 					$drawing->setWorksheet($spreadsheet->getActiveSheet());
		// 					$drawing->setPath($this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$value);
		// 					$drawing->setCoordinates(chr($i+64).($k+2));
		// 					$drawing->setHeight(100);

		// 					$sheet->getRowDimension($k+2)->setRowHeight(100);

		// 					$sheet->SetCellValue(Coordinate::stringFromColumnIndex($i).($k+2), '');
		// 					$sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setWidth(22);


		// 					//$objDrawingPType->setOffsetX(1);
		// 					//$objDrawingPType->setOffsetY(5);
		// 				} else {
		// 					// $objPHPExcel->getActiveSheet()->getColumnDimension(chr($i+65))->setAutoSize(true);
		// 					$sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
		// 				}


		// 				$i++;
		// 			}
		// 		}
		// 	}
		// }
		// var_dump($admin_field);die;
		// 資料
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				$order_content_handle = false; // 只會處理一次
				if($admin_field and !empty($admin_field)){
					$i = 0;
					foreach($admin_field as $kk => $vv){
						if($kk == 'is_enable'){
							$value = $v[$kk];
							if($value == '0'){
								$value = '停用';
							} else {
								$value = '啟用';
							}
						} elseif($kk == 'gender'){
							$value = $v[$kk];
							if($value == '1'){
								$value = '男';
							} else {
								$value = '女';
							}
						} elseif($kk == 'order_status'){
							$value = $this->data['orderstatus_tmp'][$v[$kk]];
						} elseif($kk == 'payment_func_name'){
							if(isset($this->data['payments_tmp2'][$v['payment_func']])){
								$value = $this->data['payments_tmp2'][$v['payment_func']]['name'];
							}else{
								$value = '';
							}
						} elseif($kk == 'invoice_type_name'){
							if($v['invoice_type'] == 1){
								$value = '二聯式電子發票 ';
								if($v['invoice_type_2'] == 1){
									$value .= '手機條碼 ';
								} elseif($v['invoice_type_2'] == 2){
									$value .= '自然人憑證條碼 ';
								}
								$value .= $v['invoice_type_2_barcode'];
							} elseif($v['invoice_type'] == 2){
								$value = '捐贈發票 ';
								$value .= ' '.$v['invoice_donate_name'];
								$value .= ' '.$v['invoice_donate_code'];
							} elseif($v['invoice_type'] == 3){
								$value = '三聯式紙本發票 ';
								$value .= ' '.$v['invoice_name'];
								$value .= ' '.$v['invoice_tax_id'];
							}
						} elseif(preg_match('/^order_content__(.*)$/', $kk, $matches)){
							if($order_content_handle === false){
								$row_current_tmp = $row_current; // 不想要覆寫，不然後面會有問題
								if(isset($v['details']['car']) and !empty($v['details']['car'])){
									$ggg = 0;
									//小標題
									// $sss = 0;
									// $spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, '產品流水號');
									// $sss++;
									// $spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, '產品名稱');
									// $sss++;
									// $spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, '規格');
									// $sss++;
									// $spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, '金額');
									// $sss++;
									// $spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, '數量');
									// $sss++;
									// $spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, '小計');
									// $row_current_tmp++;
									foreach($v['details']['car'] as $kkk => $vvv){
										$sss = 0;
										$spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $ggg+1);
										$sss++;
										$spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['item']['name']);
										$sss++;
										$spec = '';
										if(isset($vvv['specs']) and !empty($vvv['specs'])){
											foreach($vvv['specs'] as $kkkk => $vvvv){
												$spec .= $vvvv['value'];
											}
										}elseif(isset($vvv['spec']) and !empty($vvv['spec']) ){
											$spec .= $vvv['spec'];
										}
										$spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $spec);
										$sss++;
										$spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['item']['price']);
										$sss++;
										$spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['amount']);
										$sss++;
										$spreadsheet->getActiveSheet()->SetCellValue(chr($i+$sss+65).$row_current_tmp, $vvv['item']['price']*$vvv['amount']);

										$row_current_tmp++;
										$ggg++;
									}
								}
								$order_content_handle = true;
							}
						} else {
							if(isset($v[$kk])){
								$value = $v[$kk];
							} else {
								$value = '';
							}

							// $value = $v[$kk];
						}

					// $admin_field['order_content__k'] = array(
					// $admin_field['order_content__name'] = array(
					// $admin_field['order_content__spec'] = array(
					// $admin_field['order_content__price'] = array(
					// $admin_field['order_content__amount'] = array(
					// $admin_field['order_content__total'] = array(

						if(!preg_match('/^order_content__(.*)$/', $kk)){
							$spreadsheet->getActiveSheet()->SetCellValueExplicit(chr($i+65).$row_current, $value,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);//#38638

							$spreadsheet->getActiveSheet()->getColumnDimension(chr($i+65))->setAutoSize(true);
						}

						if(count($v['details']['car']) > 1 and !preg_match('/^order_content__(.*)$/', $kk)){
							$spreadsheet->getActiveSheet()->mergeCells(chr($i+65).$row_current.':'.chr($i+65).($row_current + (count($v['details']['car']) - 1)));
							$spreadsheet->getActiveSheet()->getStyle(chr($i+65).$row_current)->getAlignment()->setVertical(PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
						}

						if($kk == 'order_content'){
						} else {
							$i++;
						}
					}
				}
				$row_current += count($v['details']['car']);
			}
		}

		// 標題
		$row_current = 3;
		$spreadsheet->setActiveSheetIndex(0);
		if($admin_field and !empty($admin_field)){
			$i = 0;
			foreach($admin_field as $k => $v){
				$spreadsheet->getActiveSheet()->SetCellValue(chr($i+65).$row_current, $v['label']);

				// 標題背景色
				$spreadsheet->getActiveSheet()->getStyle(chr($i+65).$row_current)->applyFromArray(
					array(
						'fill' => array(
							'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'color' => array('rgb' => 'FF99CC')
						)
					)
				);

				$column_merge_end_admin_title += 1;
				$column_merge_end_export_date += 1;

				$i++;
			}
		}

		$spreadsheet->getActiveSheet()->mergeCells('A1:'.chr($column_merge_end_admin_title).'1');
		$spreadsheet->getActiveSheet()->mergeCells('B2:'.chr($column_merge_end_export_date).'2');

		// 合併訂單標題內容(寫死的哦，有異動自己去改)
		// $spreadsheet->getActiveSheet()->mergeCells('K3:P3');
		// $spreadsheet->getActiveSheet()->SetCellValue('K3', '訂單內容');
		$spreadsheet->getActiveSheet()->SetCellValue('M3','產品名稱');
		$spreadsheet->getActiveSheet()->SetCellValue('N3','規格');
		$spreadsheet->getActiveSheet()->SetCellValue('O3','金額');
		$spreadsheet->getActiveSheet()->SetCellValue('P3','數量');
		$spreadsheet->getActiveSheet()->SetCellValue('Q3','小計');
		$spreadsheet->getActiveSheet()->SetCellValue('R3','應付金額');
	

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

	//取消美安訂單
	public function actionCancelan()
	{
		if(isset($_POST["orderno"]) && $_POST["orderno"]!=''){
			$OrderNo = trim($_POST["orderno"]);

			$row = $this->cidb->where('order_number',$OrderNo)->get('shoporderform')->row_array();

			$_mn_OFFER_ID = $this->data['MarketAn']['OFFER_ID'];

			$_mn_Advertiser_ID = $this->data['MarketAn']['Advertiser_ID'];

			$_mn_commission = $this->data['MarketAn']['commission'];

			$amount = 0 - $row['sum'];
			$Cancel_orderNo = $OrderNo;
			$R_id = $row['RID'];
			$click_id = $row['Click_ID'];
			$session_datetime = date("Y-m-d",strtotime($row['create_time']));
			$Commission_Amount = $amount*$_mn_commission;
			$Commission_Amount_total = round($Commission_Amount,2);

			echo "https://api.hasoffers.com/Api?Format=json&Target=Conversion&Method=create&Service=HasOffers&Version=2&NetworkId=marktamerica&NetworkToken=NETPYKNAYOswzsboApxaL6GPQRiY2s&data[offer_id]=".$_mn_OFFER_ID."&data[advertiser_id]=".$_mn_Advertiser_ID."&data[sale_amount]=".$amount."&data[affiliate_id]=12&data[payout]=".$Commission_Amount_total."&data[revenue]=".$Commission_Amount_total."&data[advertiser_info]=".$Cancel_orderNo."&data[affiliate_info1]=".$R_id."&data[ad_id]=".$click_id."&data[is_adjustment]=1&data[session_datetime]=".$session_datetime;

			$this->cidb->where('order_number',$OrderNo)->update('shoporderform',array('marketan_cancel'=>1,'marketan_cancel_log'=>$marketan_cancel_log));
		} else {
			echo 'false';
		}
		
		exit;

	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
