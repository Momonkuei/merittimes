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
		//'disable_action' => true,
		//'title' => 'ml:Product',
		'disable_create' => true, 
		//'tools_name' => '(會員) 優惠卷/生日禮卷/紅利發放',
		//'tools' => array(
		//	//array(
		//	//	'class' => '',
		//	//	'target' => '',
		//	//	'url' => '',
		//	//	'name' => '',
		//	//),
		//),

		// 在各功能的上面的新增的右邊
		// 'index_buttons' => array(
		// 	array(
		// 		'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
		// 		'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
		// 		'id' => '', // button
		// 		'class' => 'btn btn-info', // button
		// 		'onclick' => 'javascript:location.href=\'XXX\'',
		// 	),
		// ),

		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				// array('login_account','required'),
				// array('login_account', 'unique'), // 唯一 2020-04-21 這個在會員中心的ajax修改時，會發生問題，所以前台在用orm存檔前，記得把這條規則刪掉
				// array('name','required'),
				//下面的規則如果要新增，記得會員中心的ajax修改 center_post.php 做移除處理
				//array('email','email'),
				//array('name', 'required'),
				//array('login_type', 'system.backend.extensions.myvalidators.arraycomma'),
				//array('service_ids', 'ext.myvalidators.arraycomma'),
				//array('login_password', 'system.backend.extensions.myvalidators.sha1passchange'),
			),
		),
		'default_sort_field' => 'create_time', // 預設要排序的欄位 //2020-11-26 新建立的在最前面 by lota
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		//'condition' => array(
		//	array(
		//		'where',
		//		'type="exhibition"',
		//	),
		//),
		//'sortable' => array(
		//	'enable' => 'true',
		//	//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=area/sort', // ajax post都會有個目標
		//),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		//'multifile_upload' => array(
		//	'newspic' => array(
		//		'table' => 'news_image',
		//		'relation_field_name' => 'news_id',
		//		'pic_field_name' => 'pic',
		//		'store_dir_name' => 'news_image',
		//		'section_id' => 1,
		//	),
		//),
		'listfield' => array(
			'id' => array(
				'label' => '系統編號',				
				'width' => '7%',
				'sort' => true,
			),
			'class_name' => array(
				'label' => '名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '10%',
				'sort' => true,
			),
			'teacher_name' => array(
				'label' => '教師名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '7%',
				'sort' => true,
			),
			'student_num' => array(
				'label' => '學生數量',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '8%',
				'sort' => true,
			),
			'email' => array(
				'label' => 'E-mail',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '8%',
				'sort' => true,
			),
			// 'funcfieldv3_split_1' => array(
			// 	// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
			// 	'width' => '',
			// ),
			// 'xx01' => array(
			// 	'label' => '成員名單',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'標題', // default
			// 	'url_id' => 'memberlist',
			// 	'width' => '7%',
			// 	'align' => 'center',
			// 	'sort' => true,
				
			// ),
			// 'xx02' => array(
			// 	'label' => '班級名單',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'標題', // default
			// 	'url_id' => 'classlist',
			// 	'width' => '7%',
			// 	'align' => 'center',
			// 	'sort' => true,
				
			// ),
			'create_time' => array(
				'label' => '註冊日期',
				'width' => '12%',
				'align' => 'center',
				'sort' => true,
			),
			
			'is_enable' => array(
				'label' => '啟用狀態',
				// 'mlabel' => array(
				// 	null, // category
				// 	'Status', // label
				// 	array(), // sprintf
				// 	'啟用狀態', // default
				// ),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_enable',
				// 'ezlabel' => array('停用','啟用'),
				'ezother'=> '&nbsp;',
			),
			// 'is_sms' => array(
			// 	'label' => '簡訊驗證狀態',
			// 	// 'mlabel' => array(
			// 	// 	null, // category
			// 	// 	'Status', // label
			// 	// 	array(), // sprintf
			// 	// 	'簡訊驗證狀態', // default
			// 	// ),
			// 	'width' => '10%',
			// 	'align' => 'center',
			// 	'sort' => true,
			// 	'ezfield' => 'is_sms',
			// 	'ezother'=> '&nbsp;',
			// ),
			/*
			'is_enable' => array(
				//'label' => 'ml:Status',
				'mlabel' => array(
					null, // category
					'Status', // label
					array(), // sprintf
					'狀態', // default
				),
				'width' => '8%',
				'align' => 'center',
				//'ezshow' => true,
				'ezlabel' => array('停用','啟用','Email'),
			),
			*/
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
						// 'school_name' => array(
						// 	'label' => '學校名稱',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'公司名稱', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'school_name',
						// 		'name' => 'school_name',
						// 		'size' => '40',
						// 	),
						// ),
						'class_name' => array(
							'label' => '班級名稱',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'class_name',
								'name' => 'class_name',
								'size' => '40',
							),
						),		
						'teacher_name' => array(
							'label' => '教師名稱',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'teacher_name',
								'name' => 'teacher_name',
								'size' => '40',
							),
						),					
						// 'email' => array(
						// 	'label' => 'E-Mail',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'公司名稱', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'email',
						// 		'name' => 'email',
						// 		'size' => '40',
						// 	),
						// ),
						// 'phone' => array(
						// 	'label' => '電話',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'公司名稱', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'phone',
						// 		'name' => 'phone',
						// 		'size' => '40',
						// 	),
						// ),
						// 'addr' => array(
						// 	'label' => '地址',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'公司名稱', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'addr',
						// 		'name' => 'addr',
						// 		'size' => '40',
						// 	),
						// ),
						// 'other1' => array(
						// 	'label' => '身分',
						// 	'translate_source' => 'tw',
						// 	//'type' => 'select3',
						// 	'type' => 'select5',
						// 	//'merge' => '1', // 頭中尾的頭(1)
						// 	'attr' => array(
						// 		'id' => 'other1',
						// 		'name' => 'other1',
						// 	),
						// 	'other' => array(
						// 		//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						// 		//'default' => 'center',
						// 		'values' => array(
						// 			'' => '請選擇',	
						// 			'1' => '總召',
                        //             '2' => '教師',
                        //             '3' => '學生',
						// 		),
						// 		'default' => '',
						// 	),
						// ),
						'is_enable' => array(
							'label' => '啟用狀態',
							'type' => 'status2',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								//'default'=>'-1',
								'values' => array(
									'-1' => '忽略',
									'0' => '不啟用',
									'1' => '啟用',
								),
							),
						),
						/*
						'checkbox_birthday' => array(
							'label' => '本月壽星',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'checkbox_birthday',
								'type' => 'checkbox',
								'value' => '1',
							),
						),
						*/
					),
				),
			),
		),
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'jquery.datepicker', 'jquery.twzipcode',// 簡體專用'jquery.cityselect',
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
				$('#birthday').datepicker({dateFormat: 'yy-mm-dd'});
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
					'section_title' => '',
					'field' => array(
						'class_name' => array(
							'label' => '班級',
							'type' => 'input',
							'attr' => array(
								'id' => 'class_name',
								'name' => 'class_name',
								'size' => '20',
							),
						),
						'teacher_name' => array(
							'label' => '教師名稱',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'label',
							'attr' => array(
								'id' => 'teacher_name',
								'name' => 'teacher_name',
								'size' => '40',
							),
						),
						'student_num' => array(
							'label' => '學生數量',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'label',
							'attr' => array(
								'id' => 'student_num',
								'name' => 'student_num',
								'size' => '40',
							),
						),
						// 2020-12-30
						// 'other1' => array(
						// 	'label' => '會員預留欄位1(會跟收件人other1連動)',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'other1',
						// 		'name' => 'other1',
						// 		'size' => '20',
						// 	),
						// ),
						// 'other2' => array(
						// 	'label' => '會員預留欄位2(會跟收件人other2連動)',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'other2',
						// 		'name' => 'other2',
						// 		'size' => '20',
						// 	),
						// ),
						'email' => array(
							'label' => 'E-mail',
							'type' => 'input',
							'attr' => array(
								'id' => 'email',
								'name' => 'email',
								'size' => '20',
							),
						),

						// 'birthday' => array(
						// 	'label' => '生日',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'birthday',
						// 		'name' => 'birthday',
						// 		'size' => '10',
						// 		//'readonly' => 'readonly',
						// 	),
						// ),
						// 'gender' => array(
						// 	'label' => '性別',
						// 	'type' => 'status2',
						// 	'attr' => array(
						// 		'id' => 'gender',
						// 		'name' => 'gender',
						// 	),
						// 	'other' => array(
						// 		'default'=>'1',
						// 		'values' => array(
						// 			//'-1' => '忽略',
						// 			'1' => '男性',
						// 			'2' => '女性',
						// 		),
						// 	),
						// ),
						// 'other2' => array(
						// 	'label' => '統編',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'other2',
						// 		'name' => 'other2',
						// 		'size' => '40',
						// 	),
						// ),
						// 'other3' => array(
                        //     'label' => '類別',
                        //     'type' => 'status2',
                        //     'attr' => array(
                        //         'id' => 'other3',
                        //         'name' => 'other3',
                        //     ),
                        //     'other' => array(
                        //         'default'=>'-1',
                        //         'values' => array(
                        //             '1' => '國小組',
                        //             '2' => '國中組',
						// 			'3' => '高中職組',
						// 			'4' => '大專院校組',
                        //         ),
                        //     ),
                        // ),
						// 'other1' => array(
                        //     'label' => '身分',
                        //     'type' => 'status2',
                        //     'attr' => array(
                        //         'id' => 'other1',
                        //         'name' => 'other1',
                        //     ),
                        //     'other' => array(
                        //         'default'=>'-1',
                        //         'values' => array(
                        //             '1' => '總召',
                        //             '2' => '教師',
						// 			'3' => '學生',
                        //         ),
                        //     ),
                        // ),
						// 'other4' => array(
						// 	'label' => '行政區',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'other4',
						// 		'name' => 'other4',
						// 		'size' => '40',
						// 	),
						// ),
						
						// 'file1' => array(
						// 	'label' => 'Logo：',
						// 	'translate_source' => 'tw',
						// 	'type' => 'fileuploader',
						// 	'other' => array(
						// 		'number' => '1',
						// 		'type' => 'photo',
						// 		'top_button' => '1',
						// 		'width' => '300',
						// 		'height' => '300',
						// 		'comment_size' => '',
						// 		'no_ext' => '',
						// 		'no_need_delete_button' => '',
						// 		'html_end' => '', // 這裡會跟進scss產品列表圖比例(proImgSizeType)而變化
						// 	),
						// ),
					
						// 'need_dm' => array(
						// 	'label' => '願意收到產品<br />相關訊息或活動資訊',
						// 	'type' => 'status2',
						// 	'attr' => array(
						// 		'id' => 'need_dm',
						// 		'name' => 'need_dm',
						// 	),
						// 	'other' => array(
						// 		'default'=>'0',
						// 		'values' => array(
						// 			'1' => '願意',
						// 			'0' => '不需要',
						// 		),
						// 	),
						// ),
						// 'accept_privacy' => array(
						// 	'label' => '同意隱私權政策',
						// 	'type' => 'status2',
						// 	'attr' => array(
						// 		'id' => 'accept_privacy',
						// 		'name' => 'accept_privacy',
						// 	),
						// 	'other' => array(
						// 		'default'=>'0',
						// 		'values' => array(
						// 			'1' => '願意',
						// 			'0' => '不需要',
						// 		),
						// 	),
						// ),
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
						'latest_login_time' => array(
							'label' => '最後登入時間',
							'type' => 'time',
						),
						'create_time' => array(
							'label' => '建立時間',
							'type' => 'time',
						),
						'update_time' => array(
							'label' => '更新時間',
							'type' => 'time',
						),
						'pic1' => array(
							'label' => '代表圖：',
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
					),
				),
				// funcfieldv3的產出欄位，放在任何位置都可以，有需要就打開 2/7
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
					),
				),
				// funcfieldv3的自定欄位，放在任何位置都可以，有需要就打開 3/7
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
		if(empty($_GET['d']) && !isset($_SESSION['member_class'])){
			$url='backend.php?r=customer';
			G::alert_and_redirect('請先選擇學校!', $url, $this->data);
		}
		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		

		$this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/excelexport2').'\'';

		$company_member_result = $this->cidb->where('keyname','function_constant_company_member')->get('sys_config')->row_array();
		$company_member_style=$company_member_result["keyval"];
		// if($company_member_style=="false"){

		// 	$this->def['updatefield']['sections'][0]["field"]["other1"]=array();
		// 	$this->def['updatefield']['sections'][0]["field"]["other2"]=array();
		// 	$this->def['updatefield']['sections'][0]["field"]["other3"]=array();
		// 	$this->def['updatefield']['sections'][0]["field"]["other4"]=array();
		// }
		// else{
		// 	$this->def["listfield"]["other1"] = array(
		// 		'label' => '身分',
		// 		'width' => '15%',
		// 		'sort' => true,
		// 	);

		// 	$this->def["listfield"]["is_enable"] = array(
		// 		'label' => '啟用狀態',		
		// 		'width' => '10%',
		// 		'align' => 'center',
		// 		'sort' => true,
		// 		'ezlabel' => array('停用','啟用'),
		// 	);		
			
			
			
		// }
		
		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		//$this->data['updatecontent']['login_type'] = -1;
		$this->data['updatecontent']['gender'] = -1;
		$this->data['updatecontent']['is_enable'] = -1;


		if(!empty($_GET['d']) || !empty($_SESSION['member_class'])){
			if(!empty($_GET['d'])){
				$id=$_GET['d'];
				$_SESSION['member_class']=$id;
			}else if(!empty($_SESSION['member_class'])){
				$id=$_SESSION['member_class'];
			}
			$writeplan_list=$this->cidb->where('member_id',$id)->where('is_enable',1)->order_by('id')->get('writeplan')->result_array();
			if(!empty($writeplan_list)){
				$id_list=array();
				foreach($writeplan_list as $k => $v){
					$id_list[$k]=$v['id'];
				}		
				$class_toid=$id_list;			
			}
		}else{
			$redirect_url='backend.php?r=customer';
			G::alert_and_redirect('查無班級!', $redirect_url, $this->data);
		}
		
		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		//$condition = ' is_hidden=0 ';
		$condition = ' 1 ';
		if($this->data['router_class']=='customer'){
			$condition = ' other1!=1 ';
		}
		if(!empty($class_toid)){
			$condition .=' and ( ';
			foreach($class_toid as $k => $v){
				if($k!='0'){
					$condition .=' || ';
				}
				$condition .=' writeplan_id like \'%,'.$v.',%\' ';
			}
			$condition .=' ) ';
			
		}
		if(isset($session) and count($session) > 0 ){
			$conditions = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'login_type' and $v == -1) continue;
				if($k == 'login_type' and $v == 0) continue;
				if($k == 'gender' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'login_type'){
					$conditions[] = 'concat(\',\','.$k.',\',\') LIKE \'%,'.$v.',%\'';
				} elseif($k == 'gender'){
					$conditions[] = $k.'='.$v;
				} elseif($k == 'checkbox_birthday'){
					$conditions[] = 'birthday LIKE \'%'.date('Y-m').'%\'';
				} elseif($k == 'is_enable' && $v!='-1'){
					$conditions[] = $k.'='.$v;					
				//} elseif($k == 'name'){
				//	//'search_keyword_field' => array('company_name','personal_name','login_account'), // 搜尋字串要搜尋的欄位
				//	$conditions[] = '(company_name LIKE \'%'.$v.'%\' OR personal_name LIKE \'%'.$v.'%\' OR login_account LIKE \'%'.$v.'%\')';
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
				}
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
			
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
		}
		// funcfieldv3 有需要就打開 4/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

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
		
		// (為了能夠擴展加密方式)
		// 沒有define：sha1
		// 1：從缺
		// 2：sha1 + salt
		//$this->data['gggaaa_crypt_type'] = 3;

		//$sha1 = false;

		// if(!$sha1 and isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
		// 	$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
		// 	$sha1 = true;
		// }

		//if(!$sha1 and !isset($this->data['gggaaa_crypt_type'])){
		//	$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
		//	$sha1 = true;
		//}

		// unset($_constant);
		// eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
		// if($_constant == '0'){
		// 	// do nothing
		// } elseif($_constant == '1'){
		//  	$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
		// } elseif($_constant == '2'){
		// 	// do nothing
		// }

		//會員登入型態
		unset($_constant);
		eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');

		if($_constant!='phone'){
			unset($this->def['listfield']['is_sms']);
		}

		return true;
	}

	protected function index_last()
	{	
	
		/*
		'tools_name' => '優惠卷/生日禮卷/紅利發放',
		'tools' => array(
			//array(
			//	'class' => '',
			//	'target' => '',
			//	'url' => '',
			//	'name' => '',
			//),
		),
		 */
		// $rows = $this->db->createCommand()->from('shopgoodies')->where('is_enable=1 and pid=0')->order('sort_id asc')->queryAll();
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
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['file1'] != ''){
					$v['file1'] = 'assets/upload/'.$this->data['router_class'].'/'.$v['file1'];
				}	
				// if($v['class_id']!=0 && $show_type_mode==1){
				// 	$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id='.$v['class_id'], array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
				// 	$v['xx2'] = $rows['topic'];
				// }
				$this->data['listcontent'][$k] = $v;
			}
		}
		// if($this->data['listcontent']){
		// 	foreach($this->data['listcontent'] as $k => $v){
		// 		if($v['other1']=='1'){
		// 			$this->data['listcontent'][$k]['other1']='一般會員';
		// 		}else if($v['other1']=='2'){
		// 			$this->data['listcontent'][$k]['other1']='企業會員';
		// 		}
		// 	}
		// }
	}


	protected function getData()
	{
	
		
		/*
		 * personal_address*
		 */
		$this->data['def']['updatefield']['smarty_javascript_text'] .= <<<XXX

		var twzipcode_html = '';
		twzipcode_html += '<span id="addr_twzipcode">';
		twzipcode_html += '<span data-role="county" data-style="county"></span>';
		twzipcode_html += '<span data-role="district" data-style="district"></span>';
		twzipcode_html += '<span data-role="zipcode" data-style="zipcode"></span>';
		twzipcode_html += '</span> ';
		$('#addr_twzipcode_n').after(twzipcode_html);
		$('#addr_twzipcode_n').remove();
		$('#addr_twzipcode').twzipcode({
			countyName: 'addr_county',
			districtName: 'addr_district',
			zipcodeName: 'addr_zipcode'

		XXX;
			if(isset($this->data['updatecontent']['addr_county']) and $this->data['updatecontent']['addr_county'] != ''){
				$this->data['def']['updatefield']['smarty_javascript_text'] .= ',countySel: \''.$this->data['updatecontent']['addr_county'].'\',districtSel: \''.$this->data['updatecontent']['addr_district'].'\'';
			}
			$this->data['def']['updatefield']['smarty_javascript_text'] .= <<<XXX

		});
		$('#personal_address_zipcode').attr('size', '4');
		$('#personal_address').parent().attr('id', 'personal_address_x');
		var personal_address_html = $('#personal_address').parent().html();
		$('#personal_address_zipcode').after(personal_address_html);
		$('#personal_address_x').parent().remove();

		XXX;
	}

	protected function create_show_last()
	{
		$this->getData();

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	protected function update_show_last($updatecontent)
	{
		$this->getData();
		
		
		// funcfieldv3 有需要就打開 6/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	protected function update_run_other_element($array)
	{
		// 如果是空白，就代表使用者並沒有想要改密碼
		// if($array['login_password'] == ''){
		// 	unset($array['login_password']);
		// } else {
		// 	if(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
		// 		$array['salt'] = G::GeraHash(20);
		// 		$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.sha1($array['login_password'].$array['salt']);
		// 	} elseif(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 3){
		// 		$array['salt'] = G::GeraHash(10);
		// 		$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
		// 	} else {
		// 		// do nothing
		// 		// $array['login_password'] = sha1($array['login_password'].$array['salt']);
		// 	}
		// }

		// 如果是空白，就代表使用者並沒有想要改密碼
		// if($array['login_password'] == ''){
		// 	unset($array['login_password']);
		// } else {
		// 	unset($_constant);
		// 	eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
		// 	if($_constant == '0'){
		//  		$array['salt'] = '';
		// 	} elseif($_constant == '1'){
		//  		$array['salt'] = '';
		// 	} elseif($_constant == '2'){
		//  		$array['salt'] = G::GeraHash(10);
		//  		$array['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
		// 	}
		// }
		// if($array['other1']==2 && $array['is_enable']==1){//20221019 lin 增加廠商通過會員申請寄信程式 start
        //     $row_issend = $this->cidb->where('is_send',0)->where('email !=','')->where('id',$array['hidden_id'])->get('customer')->row_array();
        //     if(!empty($row_issend)){

        //         if($row_issend["is_send"]==0){
        //             // 寄件人、網站管理者Mail
        //             $to = $this->data['sys_configs']['service_admin_mail'];
        //             $savedata=$row_issend;
        //             // 主旨
        //             $subject2 = '加入會員成功通知函'; // 預設值
        //             $subject = $this->data['sys_configs']['admin_title'] . ' ' . $subject2;
        //             $aaa_url = aaa_url;
        //             $aaa_name = $this->data['sys_configs']['admin_title'];
        //             $no_reply = '此信為系統發出，請勿回覆';
        //             $body = '';
        //             $body .= $no_reply . "\n\n";
        //             $form_fields = array(
        //                 array(
        //                     'name' => '註冊日期',
        //                     'value' => date('Y-m-d'),
        //                     'style' => '',
        //                 ),
        //                 // array(
        //                 //  'name' => '使用者名稱',
        //                 //  'value' => $savedata['login_account'],
        //                 //  'style' => '',
        //                 // ),
        //                 array(
        //                     'name' => '會員姓名',
        //                     'value' => $savedata['name'],
        //                     'style' => '',
        //                 ),
        //                 array(
        //                     'name' => 'E-Mail',
        //                     'value' => $savedata['login_account'],
        //                     'style' => '',
        //                 ),
        //             );
        //             $embeddedimages = array();
        //             $embeddedimages[] = array(
        //                 //'path' => _BASEPATH.'/../images/sendmail_title.png',
        //                 'path' => _BASEPATH . '/../images/logo_banner.jpg',
        //                 'cid' => 'logo',
        //             );
        //             // $edit = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type' => 'membermailedit', ':ml_key' => $this->data['ml_key']))->queryRow();
        //             // if (empty($edit)) {
        //                 $edit = array();
        //                 $edit['detail'] = '<p style="margin:0">歡迎您的加入，我們誠摯的歡迎您！<br>以下是您的填寫的註冊的會員資訊，我們將遵守每個會員個人資料隱私權之重要性。</p>';
        //             // }
        //             ob_start();
        //             $body_html = <<<XXX
        //             <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        //             XXX;
        //             include _BASEPATH . '/../view/mail_template/member_success_Manufacturer.php';
        //             $body_html .= ob_get_clean();
        //             // 找一下寄件人有沒有設定
        //             $from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1', array(':type' => 'email', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryRow();
        //             // 找一下收件人有沒有設定
        //             $tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1', array(':type' => 'email', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryAll();
        //             //設定cc收件者
        //             if (defined('CC_MAIL_OPEN') && CC_MAIL_OPEN == true) {
        //                 $cc_mail = $savedata['email'];
        //             } else {
        //                 $cc_mail = NULL;
        //             }
        //             // 2019-04-23 #31761 李哥說，需要做的
        //             $email_return = array();
        //             // 寄給註冊者
        //             $tos = array(
        //                 array(
        //                     'id' => '',
        //                     'name' => $savedata['name'],
        //                     // 'email' => $savedata['login_account'],
        //                     'email' => $savedata['email'],
        //                 ),
        //             );
        //             if (
        //                 $from and !empty($from) and isset($from['id']) and isset($from['email'])
        //                 and $tos and !empty($tos) and isset($tos[0]['id'])
        //             ) {
        //                 if (isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail') {
        //                     $email_return = $this->email_send_to_by_sendmail($from, $tos, $subject, $body, $body_html, $cc_mail, $embeddedimages);
        //                 } else {
        //                     $email_return = $this->email_send_to_v2($from, $tos, $subject, $body, $body_html, $cc_mail);
        //                 }
        //             } else {
        //                 //$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
        //             }
		// 			if($email_return["status1"][0]["status"]==1){
		// 				$update_tmp = array(
		// 					'is_send' => "1",
		// 				);
		// 				$this->cidb->where('id', $savedata['id']);
		// 				$this->cidb->update('customer', $update_tmp); 
		// 			}
        //        }
        //     }
        // }//20221019 lin 增加廠商通過會員申請寄信程式 end
		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}

	// 2018-08-20 這個是從亨福safeway複製過來的，有需要用才打開，有跟李哥說過
	protected function update_run_last()
	{

		// $this->data['dataupdate']
		// $this->data['id']
		$row = $this->cidb->where('is_enable',1)->where('is_send',0)->where('email !=','')->where('id',$this->data['id'])->get('customer')->row_array();
		//var_dump($row);die;
		// if(0 and $row and isset($row['id']) and $row['id'] > 0){
		// 	if(filter_var($row['login_account'], FILTER_VALIDATE_EMAIL)) {
		// 		// 寄信程式請寫在這裡
		// 		// blha...

		// 		$aaa_url = aaa_url;
		// 		$aaa_name = $this->data['sys_configs']['admin_title'];

		// 		$f1 = $row['create_time'];
		// 		$f2 = $row['name'];
		// 		$f3 = $row['login_account'];
		// 		$f4 = $row['login_password'];

		// 		// 加密的密碼，不會提供給客戶
		// 		unset($_constant);
		// 		eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
		// 		if($_constant == '0'){
		// 			// do nothing
		// 		} elseif($_constant == '1'){
		// 			$f4 = '';
		// 		} elseif($_constant == '2'){
		// 			$f4 = '';
		// 		}

		// 		$subject = 'Member activation notification'; // 李哥說的  2018-05-30
		// 		//$body = '此信為系統發出，請勿回覆'."\n\n";
		// 		$body = <<<XXX
		// 			This is an automatically generated email – please do not reply to it.
		// 			-------------------------------------------------------------------------------------------------------

		// 			Hello $f2 ，

		// 			Your registration had be approved. Thanks for registration and welcome.
		// 			Please use your submitted details and below login link.

		// 			Registration details:
		// 			-------------------------------------------------------------------------------------------------------
		// 			Registration Day： $f1
		// 			User Name︰ $f2
		// 			Account ID︰ $f3
		// 			Password : $f4

		// 			------------------------------------------------------------------------------------------------------------------------
		// 			When approved, please login to the member area at the following URL:
		// 			http://$aaa_url/guestlogin_en.php

		// 			XXX;
		// 							$body .= "\n";

		// 							$body_html_content = <<<XXX
		// 			This is an automatically generated email – please do not reply to it.<br />
		// 			-------------------------------------------------------------------------------------------------------<br />
		// 			<br />
		// 			Hello $f2 ，<br />
		// 			<br />
		// 			Your registration had be approved. Thanks for registration and welcome.<br />
		// 			Please use your submitted details and below login link.<br />
		// 			<br />
		// 			Registration details:<br />
		// 			-------------------------------------------------------------------------------------------------------<br />
		// 			Registration Day： $f1<br />
		// 			User Name︰ $f2 <br />
		// 			Account ID︰ $f3<br />
		// 			Password : $f4<br />
		// 			<br />
		// 			------------------------------------------------------------------------------------------------------------------------<br />
		// 			When approved, please login to the member area at the following URL:<br />
		// 			http://$aaa_url/guestlogin_en.php<br />
		// 			<br />

		// 			XXX;
		// 							$body_html = <<<XXX
		// 			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		// 			$body_html_content
		// 			<p style="font-size:13px;color:#999">$aaa_name $aaa_url</p>
		// 			XXX;

		// 		// 找一下寄件人有沒有設定
		// 		// $from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryRow();

		// 		// 找一下收件人有沒有設定
		// 		//$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();

		// 		$tos = array(
		// 			array(
		// 				'id' => '',
		// 				'name' => $f2,
		// 				'email' => $f3,
		// 			),
		// 		);

		// 		//設定cc收件者
		// 		if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true)
		// 			$cc_mail = $savedata['email'];
		// 		else
		// 			$cc_mail = NULL;

		// 		if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
		// 			and $tos and count($tos) > 0 and isset($tos[0]['id'])){
		// 			if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
		// 				$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,$cc_mail);
		// 			} else {
		// 				$this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
		// 			}
		// 		} else {	
		// 			//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
		// 		}

		// 		//$this->cidb->where('id', $this->data['id']);
		// 		//$this->cidb->update('customer', array('is_send'=>1)); 
		// 	}
		// }
	}

	protected function create_run_other_element($array)
	{
		// 如果是空白，就代表使用者並沒有想要改密碼
		//if($array['login_password'] == ''){
		//	unset($array['login_password']);
		//} else {
		//	if(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 2){
		//		if(!isset($array['salt'])){
		//			echo '[error] loss salt field';
		//			die;
		//		}
		//		$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.sha1($array['login_password'].$array['salt']);
		//	} elseif(isset($this->data['gggaaa_crypt_type']) and $this->data['gggaaa_crypt_type'] == 3){
		//		$array['salt'] = G::GeraHash(10);
		//		$array['login_password'] = '{GGG'.$this->data['gggaaa_crypt_type'].'AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
		//	} else {
		//		//$array['login_password'] = sha1($array['login_password'].$array['salt']);
		//	}
		//}

		// 如果是空白，就代表使用者並沒有想要改密碼
		//if($array['login_password'] == ''){
		//	unset($array['login_password']);
		//} else {
			// unset($_constant);
			// eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
			// if($_constant == '0'){
			// 	$array['salt'] = '';
			// } elseif($_constant == '1'){
			// 	$array['salt'] = '';
			// } elseif($_constant == '2'){
			// 	$array['salt'] = G::GeraHash(10);
			// 	$array['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
			// }
		//}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
