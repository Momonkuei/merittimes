<?php
/*
M _i/backend/controllers/ProductController.php
M _i/backend/controllers/WebmenuController.php
M parent/product.php
M source/menu/v2.php
M source/page_sources.php
M source/system/general_item.php
 */

class WebmenuController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		//'title' => 'ml:Product',
		'table' => 'html',
		//'orm' => 'G_html_orm',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('topic', 'required'),
				array('field_tmp', 'system.backend.extensions.myvalidators.arraycomma'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('topic'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'topic', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'topic', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		//'condition' => array(
		//	array(
		//		'where',
		//		'type="exhibition"',
		//	),
		//),
		'enable_delete' => true, // 多選刪除
		'sortable' => array(
			'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=webmenu/sort', // ajax post都會有個目標
		),
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
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'topic' => array(
				'label' => '標題',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '20%',
				'sort' => true,
			),
			'url1' => array(
				'label' => '網址',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			'video_2' => array(
				'label' => '靜態次選單功能',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '8%',
				'sort' => true,
			),
			//'other1' => array(
			//	//'label' => '標題',
			//	'mlabel' => array(
			//		null, // category
			//		'Title2', // label
			//		array(), // sprintf
			//		'次標題', // default
			//	),
			//	'width' => '20%',
			//	'sort' => true,
			//),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
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
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'field_tmp' => array(
							'label' => '區域',
							'type' => 'select3',
							'attr' => array(
								'id' => 'field_tmp',
								'name' => 'field_tmp',
							),
							'other' => array(
								'values' => array(
									'' => '無',
									// '1' => '有(預設)',
									// '2' => '沒有',
								),
								'default' => '',
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
						'xx01' => array(
							'label' => '<b>一般功能</b>',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'topic' => array(
							'label' => '標題',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'merge' => 1,
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '　，',
							),
						),
						'other1' => array(
							//'label' => '標題',
							'mlabel' => array(
								null, // category
								'Title2', // label
								array(), // sprintf
								'次標題', // default
							),
							'type' => 'input',
							'merge' => 3,
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '會出現在麵包屑左手邊，也就是頁面pageTitle的旁邊',
							),
						),
						'url1' => array(
							'label' => '網址',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'url1',
								'name' => 'url1',
								'size' => '30',
							),
						),						
						'other17' => array(
							'label' => '　動態',
							'type' => 'checkbox',
							'merge' => '3',
							'attr' => array(
								'name' => 'other17',
								'type' => 'checkbox',
								'value' => '1',
							),
							// 'other' => array(
							// 	'html_end' => '使用：　',
							// ),
						),
						'other2' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '12',
							),
							'other' => array(
								'html_start' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;target：',
								'html_end' => '例：_blank ',
							),
						),
						'other19' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'attr' => array(
								'id' => 'other19',
								'name' => 'other19',
								'size' => '12',
							),
							'other' => array(
								'html_start' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;anchor_class：',
								'html_end' => '例：openBtn ',
							),
						),
						'other20' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'attr' => array(
								'id' => 'other20',
								'name' => 'other20',
								'size' => '12',
							),
							'other' => array(
								'html_start' => 'anchor_data_target：',
								'html_end' => '例：#loginPanel_pwd, 或是#searchForm ',
							),
						),
						// 'pic1' => array(
						// 	'label' => '圖片上傳：',
						// 	'type' => 'fileuploader',
						// 	'other' => array(
						// 		'number' => '1',
						// 		'type' => 'photo',
						// 		'top_button' => '1',
						// 		'width' => '120',
						// 		'height' => '120',
						// 		'comment_size' => '120x120',
						// 		'no_ext' => '',
						// 		'no_need_delete_button' => '',
						// 	),
						// ),
						'field_tmp' => array(
							'label' => '哪些區域顯示',
							//'type' => 'multiselect',
							'type' => 'multicheckbox',
							'attr' => array(
								'type'=>'checkbox',
								//'id' => 'field_tmp',
								'name' => 'field_tmp[]',
								//'size' => '3',
							),
							'other' => array(
								'split' => '',
								'split2' => '<br />',
								'count' => 1, // 這裡本來是5
								'values' => array(),
								//'default' => 'center',
							),							
							/*
							'other2' => array(
								'1' => '頁首',
								'2' => '頁尾',
								'3' => '手機選單',
							),
							*/
						),
						//'sort_id' => array(
						//	//'label' => 'ml:Sort',
						//	'mlabel' => array(
						//		null, // category
						//		'Sort', // label
						//		array(), // sprintf
						//		'排序', // default
						//	),
						//	'type' => 'sort',
						//	'attr' => array(
						//	),
						//),
						'is_enable' => array(
							'label' => '狀態',
							'type' => 'status2',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'default' => 1,
								'values' => array(
									'1' => '啟用',
									'0' => '停用',
								),
							),
						),
						'submityy' => array(
							'label' => '&nbsp;',
							'type' => 'button',
							'attr' => array(
								'type' => 'submit',
								'class' => 'btn green',
								'label' => '送出',
								//'i' => 'icon-ok',
							),
						),
						'iframe03' => array(
							'label' => '列表示意<br /><a href="javascript:;" id="iframe03_open">(打開 / 關閉)</a><br />',
							'type' => 'iframe',
							'attr' => array(
								'id' => 'iframe03',
								'width' => '100%',
								'height' => '400px',
								'src' => '',
								//'src' => 'index_tw.php?__print_table__=1',
							),
							'other' => array(
								'html_start' => '<span id="iframe03_area">',
								'html_end' => '</span>',
							),
						),
						'iframe04' => array(
							'label' => '內頁示意<br /><a href="javascript:;" id="iframe04_open">(打開 / 關閉)</a><br />',
							'type' => 'iframe',
							'attr' => array(
								'id' => 'iframe04',
								'width' => '100%',
								'height' => '400px',
								'src' => '',
								//'src' => 'index_tw.php?__print_table__=1',
							),
							'other' => array(
								'html_start' => '<span id="iframe04_area">',
								'html_end' => '</span>',
							),
						),
						//<iframe id="group_relation" width="100%" height="400" frameborder="0" scrolling="auto" src="" ></iframe>
						'iframe01' => array(
							'label' => '列表結構<br /><a href="javascript:;" id="iframe01_open">(打開 / 關閉)</a><br />',
							'type' => 'iframe',
							'attr' => array(
								'id' => 'iframe01',
								'width' => '100%',
								'height' => '400px',
								'src' => '',
								//'src' => 'backend.php?r=layoutv3pagetype&phytree=index',
							),
							'other' => array(
								'html_start' => '<span id="iframe01_area">',
								'html_end' => '</span>',
							),
						),
						'iframe02' => array(
							'label' => '內頁結構<br /><a href="javascript:;" id="iframe02_open">(打開 / 關閉)</a><br />',
							'type' => 'iframe',
							'attr' => array(
								'id' => 'iframe02',
								'width' => '100%',
								'height' => '400px',
								'src' => '',
								//'src' => 'backend.php?r=layoutv3pagetype&phytree=index',
							),
							'other' => array(
								'html_start' => '<span id="iframe02_area">',
								'html_end' => '</span>',
							),
						),
						'submitxx' => array(
							'label' => '&nbsp;',
							'type' => 'button',
							'attr' => array(
								'type' => 'submit',
								'class' => 'btn green',
								'label' => '送出',
								//'i' => 'icon-ok',
							),
						),
						'hr01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'xx02' => array(
							'label' => '<b>進階功能</b>',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'video_1' => array(
							'label' => '是否有次選單',
							'type' => 'select3',
							'attr' => array(
								'id' => 'video_1',
								'name' => 'video_1',
							),
							'other' => array(
								'values' => array(
									// '' => '有',
									'1' => '有(預設)',
									'2' => '沒有',
								),
								'default' => '1',
							),
						),
						'video_2' => array(
							'label' => '　└ 靜態次選單',
							'type' => 'select3',
							'merge' => '1',
							'attr' => array(
								'id' => 'video_2',
								'name' => 'video_2',
							),
							'other' => array(
								'values' => array('0'=>'沒有'),
								'default' => '1',
							),
						),
						'video_4' => array(
							'label' => '<a href="/_i/backend.php?r=webmenuchild" target="_blank">連結</a>，在動態分項的 ',
							'type' => 'select3',
							'merge' => '3',
							'attr' => array(
								'id' => 'video_4',
								'name' => 'video_4',
							),
							'other' => array(
								'values' => array(
									'0' => '沒有',
									'1' => '上',
									'2' => '下',
									'3' => '末 (程式)',
								),
								'default' => '0',
							),
						),
						'video_2_readme' => array(
							'label' => '&nbsp;',						
							'type' => 'inputn',
							'other' => array(
								'html' => 
'<b>custom:language</b> - 語系取代次選單<br />
動態分項的位置：不限定，但一定要選<br />
參數：無<br />
<br />
<b>custom:webmenu_style2</b> - 改變主選單顯示的樣式變成寬版<br />
動態分項的位置：末(程式)<br />
參數：無<br />
<br />
<b>custom:layer_up</b> - 把次選單上提一層，到主選單層級 (請不要使用)<br />
動態分項的位置：末(程式)<br />
必要參數1：隨興使用的欄位other7<br />
必要參數2：隨興使用的欄位other8<br />
參數範例1：child.2，最後一層不能為child，從0開始<br />
參數範例2：888888<br />
<br />
<b>custom:move</b> - 把別人的根，和次選單，移來我這裡<br />
動態分項的位置：下 <br />
必要參數1：隨興使用的欄位other7<br />
參數範例：0,1,2 就是把主選單前三個，放到這裡的次選單裡面<br />
',
							),
						),
						'video_3' => array(
							'label' => '綁定網域',
							'type' => 'input',
							'attr' => array(
								'id' => 'video_3',
								'name' => 'video_3',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '例： demo.xxx.com.tw ',
							),
						),
						'other3' => array(
							'label' => '網址做變化',
							'type' => 'status2',
							'merge' => 1,
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
							),
							'other' => array(
								'default'=>'0',
								'values' => array(
									'0' => '略過',
									'1' => '第一個網址',
									'4' => '第一個有效網址(beta)',
									'2' => 'javascript:;',
									'3' => '#',
									// 4 ~ 8是預留
									'9' => '其它',
								),
							),
						),
						'other16' => array(
							'label' => '', // 網址做變化 / 其它
							'type' => 'input',
							'merge' => 3,
							'attr' => array(
								'id' => 'other16',
								'name' => 'other16',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '(例如: 測試.html)',
							),
						),
						'other23' => array(
							'label' => '麵包屑',
							'type' => 'input',
							'attr' => array(
								'id' => 'other23',
								'name' => 'other23',
								'size' => '20',
							),
							'other' => array(
							 	'html_start' => '　　　　　　　　└　參數1：',
								'html_end' => '第一個(有效)網址的view資料流目標，預設 v3/header/nav_menu2',
							),
						),
						'other28' => array(
							'label' => '相關主選單<br /> └ 亮燈用<br /> └ 有選的都改亮這項<br /> └ 停用的可選<br /> └ 前台次選單(靜態)<br />　放在實體功能的',
							//'type' => 'select3',
							//'type' => 'select5',
							//'type' => 'multiselect',
							'type' => 'multi-select',
							'attr' => array(
								'id' => 'other28',
								'name' => 'other28[]',

								//'class' => 'form-control input-large select2me',
								//'class' => 'multi-select',
								//'data-placeholder' => "請選擇或搜尋",
								//'multiple' => 'multiple',
								//'size' => 10,
							),
							'other' => array(
								'html_start' => '123',
							),
						),
						'hr02' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'xx03' => array(
							'label' => '<b>資料表功能</b>',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'is_home' => array(
							'label' => '動態次選單',
							'type' => 'checkbox',
							'merge' => '1',
							'attr' => array(
								'name' => 'is_home',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '使用：　',
							),
						),
						'pic2' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'merge' => '3',
							'attr' => array(
								'name' => 'pic2',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '分類',
							),
						),
						'is_news' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'is_news',
								'type' => 'checkbox',
								'value' => '1',
								'title' => '沒有勾選的話，就是獨立的分類資料表',
							),
							'other' => array(
								'html_start' => '　　　　　　　　　└　',
								'html_end' => '通用分類',
							),
						),
						'other22' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'attr' => array(
								'id' => 'other22',
								'name' => 'other22',
								'size' => '12',
								'placeholder' => '自定分類名稱',
							),
							'other' => array(
								'html_start' => '　　　　　　　　　└　',
							),
						),
						'other10' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'other10',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_start' => '　　　　　　　　　└　',
								'html_end' => '分類下有分項',
							),
						),
						'class_ids' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'merge' => '1',
							'attr' => array(
								'name' => 'class_ids',
								'type' => 'checkbox',
								'value' => '1',
								'title' => '沒有勾選的話，就是獨立的分項資料表',
							),
							'other' => array(
								'html_start' => '　　　　　　　',
								'html_end' => '通用分項',
							),
						),
						'is_top' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'merge' => '3',
							'attr' => array(
								'name' => 'is_top',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '單頁',
							),
						),
						'pic3' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'merge' => '1',
							'attr' => array(
								'name' => 'pic3',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_start' => '　　　　　　　',
								'html_end' => '日期排序 (start_date)',
							),
						),
						'other24' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'merge' => '2',
							'attr' => array(
								'name' => 'other24',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '下架時間 (date1, date2)',
							),
						),
						'xx04' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '
		* 如果是內頁的次選單要顯示，請先建立前台parent/XXXdetail.php，網址才會自動切換成內頁網址<br />
		* 如果是獨立分類，後台該功能記得要複製view<br />
		* 分類的預設規則是<b>XXX</b>type，如果要自行決定，請在通用分類旁的input去做設定',
							),
						),
						'other15' => array(
							'label' => '其它選項',
							// 'type' => 'checkbox',
							'type' => 'select3',
							'attr' => array(
								'id' => 'other15',
								'name' => 'other15',
								// 'type' => 'checkbox',
								// 'value' => '1',
							),
							// 'other' => array(
							// 	'html_start' => '　　　　　　　',
							// 	'html_end' => '列表頁',
							// ),
							'other' => array(
								'values' => array(
									'1' => '1',
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
									'7' => '7',
									'8' => '8',
									'9' => '9',
									'10' => '10',
									'11' => '11',
									'12' => '12',
									'13' => '13',
									'14' => '14',
									'15' => '15',
								),
								'default' => '1',
							 	'html_start' => '無限層的分類層數限制：',
							),
						),
						'other5' => array(
							'label' => '&nbsp;',
							// 'type' => 'checkbox',
							'type' => 'select3',
							'attr' => array(
								'id' => 'other5',
								'name' => 'other5',
								// 'type' => 'checkbox',
								// 'value' => '1',
							),
							// 'other' => array(
							// 	'html_start' => '　　　　　　　',
							// 	'html_end' => '列表頁',
							// ),
							'other' => array(
								'values' => array(
									'0' => '無 (有分類: 轉頁到第一個分類, 無分類: 空白)',
									'1' => '顯示所有物件 (總覽頁)',
									'2' => '頂層分類列表',
									'3' => '頂層以外的分類列表',
								),
								'default' => '0',
							 	'html_start' => '列表頁：',
							),
						),
						'other6' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'attr' => array(
								'id' => 'other6',
								'name' => 'other6',
								'size' => 5,
							),
							'other' => array(
								'html_start' => '每頁幾筆：',
								'html_end' => '(預設12筆)',
							),
						),
						// http://redmine.buyersline.com.tw:4000/issues/18231#note-40
						// 關鍵字：enableurl_by_subclass_haschild
						'other12' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'other12',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '有次分類的分類，連結有效 (如果 點擊分類的動作 不是 預設 的時候，就要打勾)',
							),
						),
						// http://redmine.buyersline.com.tw:4000/issues/18231#note-39
						// 關鍵字：action_by_categoryurl
						'other13' => array(
							'label' => '&nbsp;',
							// 'type' => 'checkbox',
							'type' => 'select3',
							'attr' => array(
								'id' => 'other13',
								'name' => 'other13',
								// 'type' => 'checkbox',
								// 'value' => '1',
							),
							// 'other' => array(
							// 	'html_start' => '　　　　　　　',
							// 	'html_end' => '列表頁',
							// ),
							'other' => array(
								'values' => array(
									'0' => '顯示當層物件 (預設)',
									'1' => '顯示當層分類，如果是最末層則顯示物件',
									'2' => '遞迴顯示該層底下的物件 (含自己) *有參數',
									'3' => '顯示當層的分類與物件 *還沒寫',
								),
								'default' => '0',
							 	'html_start' => '點擊分類的動作：',
							),
						),
						'other14' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'attr' => array(
								'id' => 'other14',
								'name' => 'other14',
								'size' => '20',
							),
							'other' => array(
							 	'html_start' => '　　└　參數1：',
								'html_end' => '遞迴搜尋目標：(預設 system/empty_datasource/sidemenu)，',
							),
						),
						'other21' => array(
							'label' => '&nbsp;',
							'type' => 'select3',
							'merge' => '1',
							'attr' => array(
								'id' => 'other21',
								'name' => 'other21',
							),
							'other' => array(
								'values' => array('0'=>'沒有'),
								'default' => '0',
							 	'html_start' => '頂層分類升級：',
								'html_end' => ' * 只適用於獨立分類 &gt;= 2層',
							),
						),
						'other18' => array(
							'label' => '後台功能',
							// 'type' => 'checkbox',
							'type' => 'select3',
							'attr' => array(
								'id' => 'other18',
								'name' => 'other18',
								// 'type' => 'checkbox',
								// 'value' => '1',
							),
							// 'other' => array(
							// 	'html_start' => '　　　　　　　',
							// 	'html_end' => '列表頁',
							// ),
							'other' => array(
								'values' => array(
									'0' => '不想回答',
									'1' => '可',
									'2' => '不可',
								),
								'default' => '0',
							 	'html_start' => '獨立功能的大分類可否被選：',
							),
						),
						'other25' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'merge' => 1,
							'attr' => array(
								'id' => 'other25',
								'name' => 'other25',
								'size' => '20',
							),
							'other' => array(
							 	'html_start' => '父節點 router class 名稱：',
							),
						),
						'other27' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'merge' => 3,
							'attr' => array(
								'name' => 'other27',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '通用',
							),
						),
						'hr05' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '　　　　　└ 功能連結，用在一對多的情況，像是產品的規格、產品分類的檔案下載',
							),
						),
						'other26' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'other26',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '切換成"多分類排序" (預設單分類排序) 相依通用、或是獨立資料表',
							),
						),
						'hr03' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						// http://redmine.buyersline.com.tw:4000/issues/18231?issue_count=39&issue_position=38&next_issue_id=17463&prev_issue_id=18525#note-37
						'other11' => array(
							'label' => '<b>內頁大圖</b>',
							// 'type' => 'checkbox',
							'type' => 'select3',
							'attr' => array(
								'id' => 'other11',
								'name' => 'other11',
								// 'type' => 'checkbox',
								// 'value' => '1',
							),
							// 'other' => array(
							// 	'html_start' => '　　　　　　　',
							// 	'html_end' => '列表頁',
							// ),
							'other' => array(
								'values' => array(
									'0' => '不干涉 (規則A)',
									'1' => '功能導向 (規則B)',
									'2' => '鎖定編號 (規則B)',
									'3' => '編號繼承 (規則B)',
								),
								'default' => '0',
							 	'html_start' => '規則：',
							),
						),
						'xx05' => array(
							'label' => '&nbsp;',						
							'type' => 'inputn',
							'other' => array(
								'html' => 
'<b>規則A： (依據優先權排列) -程式碼寫在banner</b> <a href="/_i/backend.php?r=bannersub" target="_blank">連結</a><br />
<br />
1: 有指定功能英文名稱和編號<br />
2: 只有指定功能名稱<br />
3: 通用 (都沒有指定)<br />
<br />
<b>規則B： (後台的前台主選單，在內頁大圖那邊，必需要有選擇指定的規則B的情況下) -程式碼寫在麵包屑</b><br />
<br />
功能導向: 記得功能英文名稱的欄位要填，不然就算選了這項，也不會有作用<br />
鎖定編號: 功能英文名稱、和編號欄位要記得填<br />
編號繼承: 同上，除此之外，運作原理是，在內頁的話，是從麵包屑的倒數第二層往頭找。不是內頁的話，從麵包屑的自己開始往頭找<br />
',
							),
						),
						'hr04' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),						
						'other29' => array(
							'label' => '該功能view的圖片比例(V4專用)',
							'type' => 'select3',
							'attr' => array(
								'id' => 'other29',
								'name' => 'other29',								
							),
							'other' => array(
								'values' => array(
									'' => '使用全站統一比例(常數)',
									'itemImg' => '矩形(預設：橫式4:3)',
									'itemImg square' => '正方形',
									'itemImg traight' => '矩形(直式3:4)',
									'itemImg a4' => '矩形(A4)',
								),
								'default' => '',
							 	// 'html_start' => '',
							),
						),
						'hr05' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'xx06' => array(
							'label' => '<b>隨興使用的欄位</b>',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'other7' => array(
							'label' => 'other7',
							'type' => 'input',
							'attr' => array(
								'id' => 'other7',
								'name' => 'other7',
								'size' => 30,
							),
							'other' => array(
								'html_end' => '這邊可以填 靜態次選單的custom:move參數'
							),
						),
						'other8' => array(
							'label' => 'other8',
							'type' => 'input',
							'attr' => array(
								'id' => 'other8',
								'name' => 'other8',
								'size' => 30,
							),
						),
						'other9' => array(
							'label' => 'other9',
							'type' => 'input',
							'attr' => array(
								'id' => 'other9',
								'name' => 'other9',
								'size' => 30,
							),
							'other' => array(
								'html_end' => '這邊可以填Icon的html'
							),
						),
					),
				),
				// section 2020-02-25
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						'xx01' => array(
							'label' => '<b>功能列表頁，上方和下方的編輯器內容(SEO專用、無分類的情況)-(V3區塊使用)</b>',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'detail_top' => array(
							'label' => '上方',
							'translate_source' => 'tw',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail_top',
								'name' => 'detail_top',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
						'detail_bottom' => array(
							'label' => '下方',
							'translate_source' => 'tw',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail_bottom',
								'name' => 'detail_bottom',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
						'hr01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
					),
				),
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
						// 'class_id' => array(
						// 	'label' => '分類',
						// 	'translate_source' => 'tw',
						// 	//'type' => 'select3',
						// 	'type' => 'select5',
						// 	//'merge' => '1', // 頭中尾的頭(1)
						// 	'attr' => array(
						// 		'id' => 'class_id',
						// 		'name' => 'class_id',
						// 	),
						// 	'other' => array(
						// 		//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						// 		//'default' => 'center',
						// 		'values' => array(
						// 			'0' => '請選擇',
						// 		),
						// 		'default' => '',
						// 	),
						// ),
						'is_copy' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'is_copy',
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

		$this->def['updatefield']['smarty_javascript_text'] = <<<XXX
$('#iframe01_area').hide();
$('#iframe01_open').click(function(){
	$('#iframe01_area').toggle();
});

$('#iframe02_area').hide();
$('#iframe02_open').click(function(){
	$('#iframe02_area').toggle();
});

$('#iframe03_area').hide();
$('#iframe03_open').click(function(){
	$('#iframe03_area').toggle();
});

$('#iframe04_area').hide();
$('#iframe04_open').click(function(){
	$('#iframe04_area').toggle();
});
XXX;

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';

		// lota版
		// $this->def['condition'][0][1] = 'type=\'webmenu\'  ';
		// $this->def['sortable']['condition'] = 'type="webmenu" ';

		// 多語版
		$this->def['condition'][0][1] = 'type=\'webmenu\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'type="webmenu" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		// 綁定靜態次選單
		$rows = $this->db->createCommand()->from('webmenuchild')->where('is_enable=1 and pid=0 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->def['updatefield']['sections'][0]['field']['video_2']['other']['values'][$v['id']] = $v['name'];
			}
		}

		$groups = array();		
		$groups[1]['value'] = '1: PC頁首 (top)';
		$groups[2]['value'] = '2: PC頁尾 (bottom)';
		$groups[3]['value'] = '3: 手機選單 (mobile)';	
		$groups[4]['value'] = '4: 次選單 (other1) - 有分類的功能，被放在前台次選單(靜態的裡面)，而且要使用懷舊次選單的情況';	
		$groups[5]['value'] = '5: 其它2 (other2)';	
		$this->data['positions'] = $groups;

		foreach($groups as $k => $v){
			$this->def['searchfield']['sections'][0]['field']['field_tmp']['other']['values'][$k] = $v['value'];
		}

		// funcfieldv3 有需要就打開 4/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

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

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['field_tmp'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = ' type=\'webmenu\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' type="webmenu" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			//2016/4/29 如果有下搜尋條件，則設定排序為sort_id
			//$this->def['default_sort_field'] = 'sort_id';//2016/6/15 捨棄，改用index_first()內的方式

			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'field_tmp' and $v == -1) continue;
				if($k == 'field_tmp' and $v == 0) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					$conditions[] = $k.'='.$v;
					$conditions_sortable[] = $k.'='.$v;
				} elseif($k == 'field_tmp'){
					unset($this->def['listfield']['sort_id']);
					$conditions[] = $k.' LIKE \'%,'.$v.',%\'';
					$conditions_sortable[] = $k.' LIKE "%,'.$v.',%"';
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

		$this->data['related_ids'] = array();
		//	'demo' => '測試',
		//	'production' => '上線',
		//	'shop' => '購物',
		//	'sem' => 'SEM',
		//	'platform' => '平台',
		//	'buyersline' => '百邇來公司用',
		//
		$rows = $this->db->createCommand()->from('html')->where('ml_key=:ml_key and type=:type', array(':type'=>'webmenu',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		//$rows = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$this->data['related_ids'][$v['id']] = $v['topic'];
				// $this->data['related_ids'][$v['id']] = $v['name'];
			}
		}
		return true;
	}

	protected function getdata()
	{
		$tmp = array();
		/*
		if(isset($this->data['updatecontent']['field_tmp']) and $this->data['updatecontent']['field_tmp'] != ''){
			$tmp = explode(',', $this->data['updatecontent']['field_tmp']);
			if(count($tmp) >= 3){
				unset($tmp[count($tmp)-1]);
				unset($tmp[0]);
			}
		}

		$rows = $this->data['def']['updatefield']['sections'][0]['field']['field_tmp']['other2'];
		$heads = array();
		foreach($rows as $k => $v){
			$heads[$k]['value'] = $v;
			if(in_array($k, $tmp)){
				$heads[$k]['is_selected'] = 'selected';
			}
		}
		$this->data['updatecontent']['field_tmp'] = $heads;
		*/

	}

	protected function create_show_last()
	{
		//$this->getdata();

		// $groups = array();		
		// $groups[1]['value'] = '頁首';
		// $groups[2]['value'] = '頁尾';
		// $groups[3]['value'] = '手機選單';	

		$this->data['updatecontent']['field_tmp'] = $this->data['positions'];

		// 相關主選單
		$groups = array();
		foreach($this->data['related_ids'] as $k => $v){
			$groups[$k]['value'] = $v;
		}
		$this->data['updatecontent']['other28'] = $groups;

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		unset($this->data['def']['updatefield']['sections'][0]['field']['iframe01']);
		unset($this->data['def']['updatefield']['sections'][0]['field']['iframe02']);
		unset($this->data['def']['updatefield']['sections'][0]['field']['iframe03']);
		unset($this->data['def']['updatefield']['sections'][0]['field']['iframe04']);
	}

	protected function update_show_last($updatecontent)
	{
		//$this->getdata();
		$tmp = explode(',', $this->data['updatecontent']['field_tmp']);

		// $groups = array();
		// $groups[1]['value'] = '頁首';
		// $groups[2]['value'] = '頁尾';
		// $groups[3]['value'] = '手機選單';

		// if(in_array('1', $tmp)){
		// 	//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
		// 	$groups[1]['is_checked'] = 'checked'; // multicheckbox
		// }
		// if(in_array('2', $tmp)){
		// 	//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
		// 	$groups[2]['is_checked'] = 'checked'; // multicheckbox
		// }
		// if(in_array('3', $tmp)){
		// 	//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
		// 	$groups[3]['is_checked'] = 'checked'; // multicheckbox
		// }

		$groups = $this->data['positions'];

		foreach($groups as $k => $v){
			if(in_array($k, $tmp)){
				//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
				$groups[$k]['is_checked'] = 'checked'; // multicheckbox
			}
		}

		$this->data['updatecontent']['field_tmp'] = $groups;

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
			// funcfieldv3 有需要就打開 6/7
			$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
			$contentx = str_replace('<'.'?'.'php', '', $contentx);
			eval($contentx);
		

			// 2018-03-08 加上群組結構的預覽
			if($this->data['updatecontent']['url1'] != ''){
				
				$this->data['def']['updatefield']['sections'][0]['field']['iframe03']['attr']['src'] = '/'.$this->data['updatecontent']['url1'].'?__print_table__=1';
				$this->data['def']['updatefield']['sections'][0]['field']['iframe04']['attr']['src'] = '/'.str_replace('_'.$this->data['ml_key'].'.php','detail_'.$this->data['ml_key'].'.php',$this->data['updatecontent']['url1']).'?id=&__print_table__=1';

				// 列表
				$aaa = str_replace('_'.$this->data['admin_switch_data_ml_key'].'.php','',$this->data['updatecontent']['url1']);
				$row2 = $this->cidb->where('is_enable',1)->where('pid',0)->where('name',$aaa)->get('layoutv3pagetype')->row_array();
				if($row2 and isset($row2['id'])){
					$this->data['def']['updatefield']['sections'][0]['field']['iframe01']['attr']['src'] = 'backend.php?r=layoutv3pagetype&treeonly='.$row2['id']; 
					$this->data['def']['updatefield']['sections'][0]['field']['iframe01']['label'] .= ' <a target="_blank" href="backend.php?r=layoutv3pagetype/update&param=v'.$row2['id'].'">(虛擬)</a><br />';
				} else {
					$file = _BASEPATH.'/../parent/'.$aaa.'.php';
					if(file_exists($file)){
						$this->data['def']['updatefield']['sections'][0]['field']['iframe01']['attr']['src'] = 'backend.php?r=layoutv3pagetype&phytree='.$aaa; 
						$this->data['def']['updatefield']['sections'][0]['field']['iframe01']['label'] .= ' (實體)<br />';
					} else {
						unset($this->data['def']['updatefield']['sections'][0]['field']['iframe01']);
						unset($this->data['def']['updatefield']['sections'][0]['field']['iframe03']);
					}
				}

				// 內頁
				$aaa = str_replace('_'.$this->data['admin_switch_data_ml_key'].'.php','',$this->data['updatecontent']['url1']).'detail';
				$row2 = $this->cidb->where('is_enable',1)->where('pid',0)->where('name',$aaa)->get('layoutv3pagetype')->row_array();
				if($row2 and isset($row2['id'])){
					$this->data['def']['updatefield']['sections'][0]['field']['iframe02']['attr']['src'] = 'backend.php?r=layoutv3pagetype&treeonly='.$row2['id']; 
					$this->data['def']['updatefield']['sections'][0]['field']['iframe02']['label'] .= ' <a target="_blank" href="backend.php?r=layoutv3pagetype/update&param=v'.$row2['id'].'">(虛擬)</a><br />';
				} else {
					$file = _BASEPATH.'/../parent/'.$aaa.'.php';
					if(file_exists($file)){
						$this->data['def']['updatefield']['sections'][0]['field']['iframe02']['attr']['src'] = 'backend.php?r=layoutv3pagetype&phytree='.$aaa; 
						$this->data['def']['updatefield']['sections'][0]['field']['iframe02']['label'] .= ' (實體)<br />';
					} else {
						unset($this->data['def']['updatefield']['sections'][0]['field']['iframe02']);
						unset($this->data['def']['updatefield']['sections'][0]['field']['iframe04']);
					}
				}
			} else {
				unset($this->data['def']['updatefield']['sections'][0]['field']['iframe01']);
				unset($this->data['def']['updatefield']['sections'][0]['field']['iframe02']);
				unset($this->data['def']['updatefield']['sections'][0]['field']['iframe03']);
				unset($this->data['def']['updatefield']['sections'][0]['field']['iframe04']);
			}

			// 動態連結，這個要匯出給/index.php裡面的default所使用
			$rows = $this->cidb->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('other17','1')->order_by('sort_id','asc')->get('html')->result_array();
			$_dynamic_url = array();
			$save_file = _BASEPATH.ds('/assets/').'_dynamic_url.php';
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					$aaa = str_replace('_'.$this->data['admin_switch_data_ml_key'].'.php','',$v['url1']);
					$_dynamic_url[] = $aaa;
				}
				file_put_contents($save_file, '<'.'?'.'php $_dynamic_url = '.var_export($_dynamic_url,true).';');
				@chmod($save_file,0777);
			} else {
				@unlink($save_file);
			}

			// 頂層分類升級
			if($this->data['updatecontent']['url1'] != ''
				and $this->data['updatecontent']['is_home'] == 1 
				and $this->data['updatecontent']['pic2'] == '1' 
				and $this->data['updatecontent']['is_news'] != '1'
				and $this->cidb->table_exists(str_replace('_'.$this->data['ml_key'].'.php','type',$this->data['updatecontent']['url1']))
			){
				$table = str_replace('_'.$this->data['ml_key'].'.php','type',$this->data['updatecontent']['url1']);
				$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid=0 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						$this->data['def']['updatefield']['sections'][0]['field']['other21']['other']['values'][$v['id']] = $v['name'];
					}
				}
			}

			// 選擇相關主選單
			$tmps = explode(',', $this->data['updatecontent']['other28']);
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
			$this->data['updatecontent']['other28'] = $groups;
		}

	}

	protected function update_run_other_element($array)
	{
		// lota版
		// $array['ml_key'] = 'tw';

		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 多語版
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		$array['type'] = 'webmenu';

		// if(!isset($array['field_tmp'])){
        //     $array['field_tmp'] = array();
        // }

		// if(isset($_POST['field_tmp']) and count($_POST['field_tmp']) > 0){
		// 	$array['field_tmp'] = implode(',', $_POST['field_tmp']);
		// }

		if(isset($array['field_tmp']) and count($array['field_tmp']) > 0){
			$array['field_tmp'] = ','.implode(',', $array['field_tmp']).',';
		} else {
			$array['field_tmp'] = '';
		}

		foreach(array('other17','is_home','class_ids','pic2','pic3','is_news','other10','is_top','other5','other12','other26') as $v){
			if(!isset($array[$v])){
				$array[$v] = 0;
			}
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		// lota版
		// $array['ml_key'] = 'tw';

		// 多語版
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		$array['type'] = 'webmenu';

		//if(isset($_POST['field_tmp']) and count($_POST['field_tmp']) > 0){
		//	$array['field_tmp'] = implode(',', $_POST['field_tmp']);
		//}

		if(isset($array['field_tmp']) and count($array['field_tmp']) > 0){
			$array['field_tmp'] = ','.implode(',', $array['field_tmp']).',';
		} else {
			$array['field_tmp'] = '';
		}

		return $array;
	}

	protected function update_run_copy($update)
	{
		// 前台主選單的資料表功能
		
		$rowg = array(
			'pic2' => 0, // 分類
			'is_news' => 0, // 通用分類
			'class_ids' => 1, // 通用分項
			'pic3' => 0, // 日期排序
		);
		

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

				$this->cidb->insert($this->data['router_class'], $save);
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

	protected function index_last($param='')
	{

		$webmenuchild = array();
		$webmenuchild[0] = '沒有';
		$_tmp = $this->db->createCommand()->from('webmenuchild')->where('is_enable=1 and pid=0 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
		foreach ($_tmp as $key => $value) {
			$webmenuchild[$value['id']] = $value['name'];
		}


		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){

				if($v['video_1']==1 && $v['video_2']!=0 && $v['video_4']!=0){
					$v['video_2'] = $webmenuchild[$v['video_2']];
				}else{
					$v['video_2'] = '';
				}

				// 商品複製
				// 2017-07-20 李哥說，要加上授權，就是99999開頭的都要加
				if(preg_match('/^99999/', $this->data['admin_id'])){
					$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> Copy</a>';
				}

				$this->data['listcontent'][$k] = $v;

			}
		}
		//-2020/11/01 #46127  增加線上捐款功能開關----------------------------------------------------------------------------------------start
		$donation_data = $this->db->createCommand()->from('sys_config')->where('keyname=:keyname', array(':keyname'=>'function_constant_donation'))->queryRow();
		if(!empty($donation_data) && $donation_data['keyval']=='false'){
			foreach($this->data['listcontent'] as $k => $v){
				if(stristr($v['url1'],'donation')){
					unset($this->data['listcontent'][$k]);
				}
			}
		}
		//--------------------------------------------------------------------------------------------------------------------------------end
		
	}


}
