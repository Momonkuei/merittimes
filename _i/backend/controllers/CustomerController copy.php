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
		'index_buttons' => array(
			array(
				'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
				'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
				'id' => '', // button
				'class' => 'btn btn-info', // button
				'onclick' => 'javascript:location.href=\'XXX\'',
			),
		),

		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('login_account','required'),
				array('login_account', 'unique'), // 唯一 2020-04-21 這個在會員中心的ajax修改時，會發生問題，所以前台在用orm存檔前，記得把這條規則刪掉
				array('name','required'),
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
			'name' => array(
				'label' => '姓名',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '15%',
				'sort' => true,
			),
			'login_account' => array(
				'label' => '帳號',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '15%',
				'sort' => true,
			),
			'email' => array(
				'label' => 'E-Mail',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'公司名稱', // default
				//),
				'width' => '15%',
				'sort' => true,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
			'create_time' => array(
				'label' => '註冊日期',
				'width' => '12%',
				'align' => 'center',
				'sort' => true,
			),
			'is_enable' => array(
				//'label' => 'ml:Sort id',
				'mlabel' => array(
					null, // category
					'Status', // label
					array(), // sprintf
					'啟用狀態', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_enable',
				'ezother'=> '&nbsp;',
			),
			'is_sms' => array(
				'label' => '簡訊驗證狀態',
				// 'mlabel' => array(
				// 	null, // category
				// 	'Status', // label
				// 	array(), // sprintf
				// 	'簡訊驗證狀態', // default
				// ),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_sms',
				'ezother'=> '&nbsp;',
			),
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
						'name' => array(
							'label' => '姓名',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
						),
						'gender' => array(
							'label' => '性別',
							'type' => 'status2',
							'attr' => array(
								'id' => 'gender',
								'name' => 'gender',
							),
							'other' => array(
								'default'=>'-1',
								'values' => array(
									'-1' => '忽略',
									'1' => '男性',
									'2' => '女性',
								),
							),
						),
						'email' => array(
							'label' => 'E-Mail',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'email',
								'name' => 'email',
								'size' => '40',
							),
						),
						'phone' => array(
							'label' => '電話',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'phone',
								'name' => 'phone',
								'size' => '40',
							),
						),
						'addr' => array(
							'label' => '地址',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'公司名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'addr',
								'name' => 'addr',
								'size' => '40',
							),
						),
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
						'name' => array(
							'label' => '姓名',
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '20',
							),
						),
						'login_account' => array(
							'label' => '登入帳號',
							'type' => 'input',
							'attr' => array(
								'id' => 'login_account',
								'name' => 'login_account',
								'size' => '30',
							),
						),
						'login_password' => array(
							'label' => '密碼',
							// 'type' => 'input', // 明碼專用
							'type' => 'pass', // SHA1、加密方式1
							'attr' => array(
								'id' => 'login_password',
								'name' => 'login_password',
								'size' => '30',
							),
						),
						//'login_password_confirm' => array(
						//	'label' => '密碼確認',
						//	'type' => 'pass',
						//	'attr' => array(
						//		'id' => 'login_password_confirm',
						//		'name' => 'login_password_confirm',
						//		'size' => '30',
						//	),
						//),

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
						// 'other3' => array(
						// 	'label' => '會員預留欄位3(會跟收件人other3連動)',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'other3',
						// 		'name' => 'other3',
						// 		'size' => '20',
						// 	),
						// ),

						'birthday' => array(
							'label' => '生日',
							'type' => 'input',
							'attr' => array(
								'id' => 'birthday',
								'name' => 'birthday',
								'size' => '10',
								//'readonly' => 'readonly',
							),
						),
						'gender' => array(
							'label' => '性別',
							'type' => 'status2',
							'attr' => array(
								'id' => 'gender',
								'name' => 'gender',
							),
							'other' => array(
								'default'=>'1',
								'values' => array(
									//'-1' => '忽略',
									'1' => '男性',
									'2' => '女性',
								),
							),
						),
						'email' => array(
							'label' => '電子信箱',
							'type' => 'input',
							'attr' => array(
								'id' => 'email',
								'name' => 'email',
								'size' => '30',
							),
						),
						//'zip' => array(
						//	'label' => '地址',
						//	//'label' => '郵遞區號',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'公司名稱', // default
						//	//),
						//	'merge' => '1',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'zip',
						//		'name' => 'zip',
						//		'size' => '9',
						//	),
						//	'other' => array(
						//		'html_start' => '郵遞區號',
						//	),
						//),
						'addr_twzipcode_n' => array(
							'label' => '地址',
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'addr_twzipcode_n',
								'name' => 'addr_twzipcode_n',
								'size' => '50',
							),
						), 
						'addr' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'addr',
								'name' => 'addr',
								'size' => '50',
							),
						), 
						'phone' => array(
							'label' => '電話',
							'type' => 'input',
							'attr' => array(
								'id' => 'phone',
								'name' => 'phone',
								'size' => '50',
							),
						), 
						// 'mobile' => array(
						// 	'label' => '手機',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'mobile',
						// 		'name' => 'mobile',
						// 		'size' => '50',
						// 	),
						// ), 
						// 'fax' => array(
						// 	'label' => '傳真',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'fax',
						// 		'name' => 'fax',
						// 		'size' => '50',
						// 	),
						// ), 
						'need_dm' => array(
							'label' => '願意收到產品<br />相關訊息或活動資訊',
							'type' => 'status2',
							'attr' => array(
								'id' => 'need_dm',
								'name' => 'need_dm',
							),
							'other' => array(
								'default'=>'0',
								'values' => array(
									'1' => '願意',
									'0' => '不需要',
								),
							),
						),
						
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
		$company_member_result = $this->cidb->where('keyname','function_constant_company_member')->get('sys_config')->row_array();
		$company_member_style=$company_member_result["keyval"];

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}
	

		$this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/excelexport2').'\'';

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		//$this->data['updatecontent']['login_type'] = -1;
		$this->data['updatecontent']['gender'] = -1;
		$this->data['updatecontent']['is_enable'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		//$condition = ' is_hidden=0 ';
		$condition = ' 1 ';
		if(isset($session) and count($session) > 0){
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
			//var_dump($this->def['condition']);
			//die;
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

		unset($_constant);
		eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
		if($_constant == '0'){
			// do nothing
		} elseif($_constant == '1'){
		 	$this->def['empty_orm_data']['rules'][] = array('login_password', 'system.backend.extensions.myvalidators.sha1passchange');
		} elseif($_constant == '2'){
			// do nothing
		}

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
		if($array['login_password'] == ''){
			unset($array['login_password']);
		} else {
			unset($_constant);
			eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
			if($_constant == '0'){
		 		$array['salt'] = '';
			} elseif($_constant == '1'){
		 		$array['salt'] = '';
			} elseif($_constant == '2'){
		 		$array['salt'] = G::GeraHash(10);
		 		$array['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
			}
		}

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
		if(0 and $row and isset($row['id']) and $row['id'] > 0){
			if(filter_var($row['login_account'], FILTER_VALIDATE_EMAIL)) {
				// 寄信程式請寫在這裡
				// blha...

				$aaa_url = aaa_url;
				$aaa_name = $this->data['sys_configs']['admin_title'];

				$f1 = $row['create_time'];
				$f2 = $row['name'];
				$f3 = $row['login_account'];
				$f4 = $row['login_password'];

				// 加密的密碼，不會提供給客戶
				unset($_constant);
				eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
				if($_constant == '0'){
					// do nothing
				} elseif($_constant == '1'){
					$f4 = '';
				} elseif($_constant == '2'){
					$f4 = '';
				}

				$subject = 'Member activation notification'; // 李哥說的  2018-05-30
				//$body = '此信為系統發出，請勿回覆'."\n\n";
				$body = <<<XXX
This is an automatically generated email – please do not reply to it.
-------------------------------------------------------------------------------------------------------

Hello $f2 ，

Your registration had be approved. Thanks for registration and welcome.
Please use your submitted details and below login link.

Registration details:
-------------------------------------------------------------------------------------------------------
Registration Day： $f1
User Name︰ $f2
Account ID︰ $f3
Password : $f4

------------------------------------------------------------------------------------------------------------------------
When approved, please login to the member area at the following URL:
http://$aaa_url/guestlogin_en.php

XXX;
				$body .= "\n";

				$body_html_content = <<<XXX
This is an automatically generated email – please do not reply to it.<br />
-------------------------------------------------------------------------------------------------------<br />
<br />
Hello $f2 ，<br />
<br />
Your registration had be approved. Thanks for registration and welcome.<br />
Please use your submitted details and below login link.<br />
<br />
Registration details:<br />
-------------------------------------------------------------------------------------------------------<br />
Registration Day： $f1<br />
User Name︰ $f2 <br />
Account ID︰ $f3<br />
Password : $f4<br />
<br />
------------------------------------------------------------------------------------------------------------------------<br />
When approved, please login to the member area at the following URL:<br />
http://$aaa_url/guestlogin_en.php<br />
<br />

XXX;
				$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
$body_html_content
<p style="font-size:13px;color:#999">$aaa_name $aaa_url</p>
XXX;

				// 找一下寄件人有沒有設定
				$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryRow();

				// 找一下收件人有沒有設定
				//$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();

				$tos = array(
					array(
						'id' => '',
						'name' => $f2,
						'email' => $f3,
					),
				);

				//設定cc收件者
				if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true)
					$cc_mail = $savedata['email'];
				else
					$cc_mail = NULL;

				if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
					and $tos and count($tos) > 0 and isset($tos[0]['id'])){
					if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
						$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,$cc_mail);
					} else {
						$this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
					}
				} else {	
					//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
				}

				//$this->cidb->where('id', $this->data['id']);
				//$this->cidb->update('customer', array('is_send'=>1)); 
			}
		}
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
			unset($_constant);
			eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
			if($_constant == '0'){
				$array['salt'] = '';
			} elseif($_constant == '1'){
				$array['salt'] = '';
			} elseif($_constant == '2'){
				$array['salt'] = G::GeraHash(10);
				$array['login_password'] = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($array['login_password'].$array['salt'])));
			}
		//}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
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

		// 看一下搜尋了哪些會員，那些會員都是要收取發放的
		
		$members = $this->db->createCommand()->from('customer')->where($this->def['condition'][0][1])->where('email!=""')->queryAll();

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 設定一下多筆寄件人
		$tos = array();

		// 信件格式
		if($shop_goodies_row['emailformat_id'] > 0){
			$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',array(':id'=>$shop_goodies_row['emailformat_id'],':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();
		}

		if($shop_goodies_row['func'] == 1){ // 優惠卷

			// 沒有提供發放的張數，那就不發
			if($shop_goodies_row['gift_amount'] <= 0){
				$redirect_url = $this->createUrl($this->data['router_class'].'/index');
				G::alert_and_redirect('請先設定好優惠卷發放的張數', $redirect_url, $this->data);
			}


			// 優惠卷，就是要發幾張，每張的序號是多少
			if($members and count($members) > 0){
				foreach($members as $k => $v){

					$to = $v['email'];

					$content = '';

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
						$savedata['member_id'] = $v['id'];
						eval($this->data['empty_orm_eval']);
						$u = new $name('insert', $empty_orm_data);
						// 修改專用
						//$u = $c::model()->findByPk($row['id']);
						$u->setAttributes($savedata);
						if(!$u->save()){
							G::dbm($u->getErrors());
						}
						$id = $this->db->getLastInsertID();

						$content .= $serial_number."\n";
					}

					if($shop_goodies_row['emailformat_id'] > 0){
						$email_topic = $emailformat['topic'];

						$email_topic = str_replace('{AA}', $v['name'], $email_topic);
						$email_topic = str_replace('{BB}', $v['email'], $email_topic);

						// 記得最後要加上這一行，把多餘的額外欄位刪掉
						for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);

						$email_content = $emailformat['detail'];

						$email_content = str_replace('{AA}', $v['name'], $email_content);
						$email_content = str_replace('{BB}', $v['email'], $email_content);
						$email_content = str_replace('{CC}', $content, $email_content);

						// 記得最後要加上這一行，把多餘的額外欄位刪掉
						for($x=65;$x<=(65+26);$x++) $email_content = str_replace('{'.chr($x).'}', '', $email_content);

						$subject = $email_topic;
						$body = $email_content;

						if($emailformat['field_tmp'] != ''){
							$email_html_content = $emailformat['field_tmp'];

							$email_html_content = str_replace('{AA}', $v['name'], $email_html_content);
							$email_html_content = str_replace('{BB}', $v['email'], $email_html_content);
							$email_html_content = str_replace('{CC}', $content, $email_html_content);

							// 記得最後要加上這一行，把多餘的額外欄位刪掉
							for($x=65;$x<=(65+26);$x++) $email_html_content = str_replace('{'.chr($x).'}', '', $email_html_content);
							$body_html = $email_html_content;
						} else {
							$body_html = nl2br($email_content);
						}

						if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
							and $tos and count($tos) > 0 and isset($tos[0]['id'])){
							if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
								$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html);
							} else {
								$this->email_send_to_v2($from,$tos, $subject, $body, $body_html);
							}
						} else {
							$this->email_send_to($to, $subject, $body, $body_html);
						}
					}

				}
			}
		} elseif($shop_goodies_row['func'] == 2){ // 紅利
			// 紅利，就是每個會員，每次發多少金額的紅利
			if($members and count($members) > 0){
				foreach($members as $k => $v){

					$to = $v['email'];

					$content = $shop_goodies_row['bonus_point'].'點';

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
					$savedata['member_id'] = $v['id'];


					eval($this->data['empty_orm_eval']);
					$u = new $name('insert', $empty_orm_data);
					// 修改專用
					//$u = $c::model()->findByPk($row['id']);
					$u->setAttributes($savedata);
					if(!$u->save()){
						G::dbm($u->getErrors());
					}
					$id = $this->db->getLastInsertID();

					// 寫入紅利記錄
					$savedata = array(
						'member_id' => $v['id'],
						'name' => $save['name'],
						'point' => $save['bonus_point'],
						'start_date' => $save['start_date'],
						'end_date' => $save['end_date'],
						'create_time' => date('Y-m-d H:i:s'),
					);
					$this->cidb->insert('shopgoodies_log', $savedata); 
					//$id = $this->cidb->insert_id();

					if($shop_goodies_row['emailformat_id'] > 0){
						$email_topic = $emailformat['topic'];

						$email_topic = str_replace('{AA}', $v['name'], $email_topic);
						$email_topic = str_replace('{BB}', $v['email'], $email_topic);

						// 記得最後要加上這一行，把多餘的額外欄位刪掉
						for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);

						$email_content = $emailformat['detail'];

						$email_content = str_replace('{AA}', $v['name'], $email_content);
						$email_content = str_replace('{BB}', $v['email'], $email_content);
						$email_content = str_replace('{CC}', $content, $email_content);

						// 記得最後要加上這一行，把多餘的額外欄位刪掉
						for($x=65;$x<=(65+26);$x++) $email_content = str_replace('{'.chr($x).'}', '', $email_content);

						$subject = $email_topic;
						$body = $email_content;

						if($emailformat['field_tmp'] != ''){
							$email_html_content = $emailformat['field_tmp'];

							$email_html_content = str_replace('{AA}', $v['name'], $email_html_content);
							$email_html_content = str_replace('{BB}', $v['email'], $email_html_content);
							$email_html_content = str_replace('{CC}', $content, $email_html_content);

							// 記得最後要加上這一行，把多餘的額外欄位刪掉
							for($x=65;$x<=(65+26);$x++) $email_html_content = str_replace('{'.chr($x).'}', '', $email_html_content);
							$body_html = $email_html_content;
						} else {
							$body_html = nl2br($email_content);
						}

						if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
							and $tos and count($tos) > 0 and isset($tos[0]['id'])){
							if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
								$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html);
							} else {
								$this->email_send_to_v2($from,$tos, $subject, $body, $body_html);
							}
						} else {
							$this->email_send_to($to, $subject, $body, $body_html);
						}
					}

				}
			}
		}

		$redirect_url = $this->createUrl('customer/index');
		G::alert_and_redirect('發放成功', $redirect_url, $this->data);

	}

	/*
	 * 產生優惠卷，並檢查有沒有存在於資料表
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
		// echo  _BASEPATH;die;
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


		// var_dump($admin_field);die;

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
						} elseif($kk == 'class_id'){
							$_row = $this->cidb->where('id',$value)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->get('lightuporderform')->row_array();		
							$value = $_row['order_number'].' - '.$_row['buyer_name'];
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
eval('class '.$filename.' extends NonameController {}');
