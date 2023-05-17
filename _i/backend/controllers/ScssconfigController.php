<?php

class ScssconfigController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'table' => 'scss_config',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'scss_config',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('newsDateStyle, topic, cis-color-1, headerStyle, fontFamilyType, text-color, radius-base, headerHoverBg, headerHoverBorderTop, headerHoverBorderRight, headerHoverBorderBottom, headerHoverBorderLeft, pageTitleStyle, blockTitleStyle', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'default_sort_field' => 'id', // 預設要排序的欄位
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
		'listfield' => array(
			'topic' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '60%',
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
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'jquery.colorpicker',
			),
			'smarty_javascript_text' => '',
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
					'section_title' => '必填區塊',
					'type' => '1',
					'field' => array(
						'topic' => array(
							'label' => '名稱',
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
						'cis-color-1' => array(
							'label' => '整站CI主要色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'cis-color-1',
								'name' => 'cis-color-1',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '(掛件單需標註)',
							),
						),
						'headerStyle' => array(
							'label' => 'Header配色',
							'type' => 'status2',
							'attr' => array(
								'id' => 'headerStyle',
								'name' => 'headerStyle',
							),
							'other' => array(
								'default'=> '0',
								'values' => array(
									// 1-白底 2-黑底 3-cis1色
									//'0' => '請選擇',
									'1' => '白底',
									'2' => '黑底',
									'3' => 'cis1色',
								),
								//'html_start' => '國語：',
								'html_end' => '(掛件單需標註)',
							),
						),
						'fontFamilyType' => array(
							'label' => '基本字型',
							'type' => 'status2',
							'attr' => array(
								'id' => 'fontFamilyType',
								'name' => 'fontFamilyType',
							),
							'other' => array(
								'default'=> '0',
								'values' => array(
									// 1-白底 2-黑底 3-cis1色
									//'0' => '請選擇',
									'1' => '黑體',
									'2' => '明體',
								),
							),
						),
						'radius-base' => array(
							'label' => '圓角',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'radius-base',
								'name' => 'radius-base',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '例如5px',
							),
						),
						'xxx01' => array(
							'label' => 'Header 滑過效果與亮燈：',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'headerHoverBg' => array(
							'label' => '　滑過背景色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'headerHoverBg',
								'name' => 'headerHoverBg',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '0沒有 1有',
							),
						),
						'headerHoverBorderTop' => array(
							'label' => '　滑過邊框-上',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'headerHoverBorderTop',
								'name' => 'headerHoverBorderTop',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '0沒有 ?px 粗細',
							),
						),
						'headerHoverBorderRight' => array(
							'label' => '　滑過邊框-右',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'headerHoverBorderRight',
								'name' => 'headerHoverBorderRight',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '0沒有 ?px 粗細',
							),
						),
						'headerHoverBorderBottom' => array(
							'label' => '　滑過邊框-下',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'headerHoverBorderBottom',
								'name' => 'headerHoverBorderBottom',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '0沒有 ?px 粗細',
							),
						),
						'headerHoverBorderLeft' => array(
							'label' => '　滑過邊框-左',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'headerHoverBorderLeft',
								'name' => 'headerHoverBorderLeft',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '0沒有 ?px 粗細',
							),
						),
						'pageTitleStyle' => array(
							'label' => '頁面標題樣式 *',
							'type' => 'select3',
							'attr' => array(
								'id' => 'pageTitleStyle',
								'name' => 'pageTitleStyle',
							),
							'other' => array(
								'values' => array(
									'0' => '請選擇',
									'1' => '符號(fontawesome)',
									'2' => '線條(左)',
									'3' => '色塊',
									'4' => '小圖',
								),
								'default' => '0',
							),
							// 'other' => array(
							// 	'html_end' => '<div id="pageTitleStyle_">',
							// ),
						),
						'pageTitleDecoContent' => array(
							'label' => '　fontawesome字元值 *',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'pageTitleDecoContent',
								'name' => 'pageTitleDecoContent',
								'size' => '8',
								'class' => 'pageTitleStyles pageTitleStyle__1',
							),
							'other' => array(
								'html_end' => '(ex：\f101)',
							),
						),
						'pageTitleDecoBorder' => array(
							'label' => '　線粗細',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'pageTitleDecoBorder',
								'name' => 'pageTitleDecoBorder',
								'size' => '8',
								'class' => 'pageTitleStyles pageTitleStyle__2',
							),
							'other' => array(
								'html_end' => '(1px ~ 3px)',
							),
						),
						'pageTitleDecoBg' => array(
							'label' => '　背景色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'pageTitleDecoBg',
								'name' => 'pageTitleDecoBg',
								'size' => '8',
								'class' => 'pageTitleStyles pageTitleStyle__3',
							),
							'other' => array(
								'html_end' => '1=有 0=無',
							),
						),
						'pageTitleDecoPath' => array(
							'label' => '　小圖',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'pageTitleDecoPath',
								'name' => 'pageTitleDecoPath',
								'size' => '30',
								'class' => 'pageTitleStyles pageTitleStyle__4',
							),
							'other' => array(
								'html_end' => 'ex: images/tw/pagetitle_icon.svg',
							),
						),
						'blockTitleStyle' => array(
							'label' => '區塊標題樣式 *',
							'type' => 'select3',
							'attr' => array(
								'id' => 'blockTitleStyle',
								'name' => 'blockTitleStyle',
							),
							'other' => array(
								'values' => array(
									'0' => '請選擇',
									'1' => '底線',
									'2' => '邊框',
									'3' => '點點',
								),
								'default' => '0',
							),
						),
						//    'aaa01' => array(
						//    	'label' => '　這個是選了第1項所出現的範例',
						//    	//'mlabel' => array(
						//    	//	null, // category
						//    	//	'Title', // label
						//    	//	array(), // sprintf
						//    	//	'標題', // default
						//    	//),
						//    	'type' => 'input',
						//    	'attr' => array(
						//    		'id' => 'aaa01',
						//    		'name' => 'aaa01',
						//    		'size' => '8',
						//    		'class' => 'blockTitleStyles blockTitleStyle__1',
						//    	),
						//    ),
						//    'aaa01a' => array(
						//    	'label' => '　這個是選了第1項跟著出現的範例',
						//    	//'mlabel' => array(
						//    	//	null, // category
						//    	//	'Title', // label
						//    	//	array(), // sprintf
						//    	//	'標題', // default
						//    	//),
						//    	'type' => 'input',
						//    	'attr' => array(
						//    		'id' => 'aaa01a',
						//    		'name' => 'aaa01a',
						//    		'size' => '8',
						//    		'class' => 'blockTitleStyles blockTitleStyle__1',
						//    	),
						//    ),
						//    'aaa02' => array(
						//    	'label' => '　這個是選了第2項所出現的',
						//    	//'mlabel' => array(
						//    	//	null, // category
						//    	//	'Title', // label
						//    	//	array(), // sprintf
						//    	//	'標題', // default
						//    	//),
						//    	'type' => 'input',
						//    	'attr' => array(
						//    		'id' => 'aaa02',
						//    		'name' => 'aaa02',
						//    		'size' => '8',
						//    		'class' => 'blockTitleStyles blockTitleStyle__2',
						//    	),
						//    ),
						'newsDateStyle' => array(
							'label' => '最新消息 日期樣式 *',
							'type' => 'select3',
							'attr' => array(
								'id' => 'newsDateStyle',
								'name' => 'newsDateStyle',
							),
							'other' => array(
								'values' => array(
									'0' => '請選擇',
									'1' => '直式',
									'2' => '橫式',
									'3' => '外框',
								),
								'default' => '0',
							),
							// 'other' => array(
							// 	'html_end' => '<div id="pageTitleStyle_">',
							// ),
						),
						'dateStyle1DecoBorder' => array(
							'label' => '　線條寬',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'dateStyle1DecoBorder',
								'name' => 'dateStyle1DecoBorder',
								'size' => '8',
								'class' => 'newsDateStyles newsDateStyle__1',
							),
							'other' => array(
								'html_end' => '(1px~3px)',
							),
						),
						'dateStyle2DecoBorder' => array(
							'label' => '　線條寬',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'dateStyle2DecoBorder',
								'name' => 'dateStyle2DecoBorder',
								'size' => '8',
								'class' => 'newsDateStyles newsDateStyle__2',
							),
							'other' => array(
								'html_end' => '?px',
							),
						),
						'dateStyle3DecoBorder' => array(
							'label' => '　線條寬',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'dateStyle3DecoBorder',
								'name' => 'dateStyle3DecoBorder',
								'size' => '8',
								'class' => 'newsDateStyles newsDateStyle__3',
							),
							'other' => array(
								'html_end' => '?px',
							),
						),
						'is_enable' => array(
							//'label' => '兵役狀況',
							'mlabel' => array(
								null, // category
								'Status', // label
								array(), // sprintf
								'狀態', // default
							),
							'type' => 'status2',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								'default'=>'1',
								'values' => array(
									'1' => '啟用',
									'0' => '停用',
								),
								//'other1' => '役畢',
								//'other2' => '',
								//'other3' => '',
							),
						),
						// 'is_enable' => array(
						// 	//'label' => 'ml:Status',
						// 	'mlabel' => array(
						// 		null, // category
						// 		'Status', // label
						// 		array(), // sprintf
						// 		'狀態', // default
						// 	),
						// 	'type' => 'status',
						// 	'attr' => array(
						// 		'id' => 'is_enable',
						// 		'name' => 'is_enable',
						// 	),
						// 	'other' => array(
						// 		'default'=>'1',
						// 	),
						// ),
						'iframe01' => array(
							'label' => '&nbsp;',
							'type' => 'iframe',
							'attr' => array(
								'id' => 'iframe01',
								'width' => '100%',
								'height' => '30px',
								// 'src' => '/cssv3.php', // scss.so(eip)
								// 'src' => '/cssv4.php', // scssphp 0.7
								// 'src' => '/cssv5.php', // js compiler
								//'src' => '/cssv6.php', // 2018-01-10 skin/theme拉出來(js compiler)
								'src' => '/cssv7.php', // 2019-10-04 PHP7
							),
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'section_title' => '非必填區塊(有預設值)',
					'type' => '1',
					'field' => array(
						'cis-color-2' => array(
							'label' => '整站CI次要色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'cis-color-2',
								'name' => 'cis-color-2',
								'size' => '40',
							),
						),
						'cis-color-3' => array(
							'label' => '整站CI輔助色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'cis-color-3',
								'name' => 'cis-color-3',
								'size' => '40',
							),
						),
						'body-bg' => array(
							'label' => '背景色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'body-bg',
								'name' => 'body-bg',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '(連續圖背景使用style01更換)',
							),
						),
						'text-color' => array(
							'label' => '基本字顏色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'text-color',
								'name' => 'text-color',
								'size' => '10',
							),
						),
						'googlefont' => array(
							'label' => 'GOOGLE字型',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'googlefont',
								'name' => 'googlefont',
								'size' => '10',
							),
							//'other' => array(
							//	'html_end' => '例：Lato，這個不用加雙引和分號',
							//),
						),
						'googlefont_import' => array(
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
								'id' => 'googlefont_import',
								'name' => 'googlefont_import',
								'size' => '50',
							),
						),
						'font-size-base' => array(
							'label' => '基本字體大小',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'font-size-base',
								'name' => 'font-size-base',
								'size' => '8',
							),
						),
						'border-base' => array(
							'label' => '線寬(按扭、表單元素線框)',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'border-base',
								'name' => 'border-base',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '1~3px',
							),
						),
						'proItemImgBg' => array(
							'label' => '產品詳細頁 產品圖背景色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'proItemImgBg',
								'name' => 'proItemImgBg',
								'size' => '10',
							),
						),
						'topLinkBgColor' => array(
							'label' => '上方小選單背景色',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'topLinkBgColor',
								'name' => 'topLinkBgColor',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '這個沒有預設值',
							),
						),
						'checkOutStepType' => array(
							'label' => '結帳步驟樣式',
							'type' => 'select3',
							'attr' => array(
								'id' => 'checkOutStepType',
								'name' => 'checkOutStepType',
							),
							'other' => array(
								'values' => array(
									'0' => '請選擇',
									'1' => '圓形',
									'2' => '箭頭',
									'3' => '線條',
								),
								'default' => '1',
							),
							// 'other' => array(
							// 	'html_end' => '<div id="checkOutStepType">',
							// ),
						),
						'checkOutStepType1BorderW' => array(
							'label' => '　結帳步驟樣式1',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'checkOutStepType1BorderW',
								'name' => 'checkOutStepType1BorderW',
								'size' => '8',
								'class' => 'checkOutStepTypes checkOutStepType__1',
							),
							'other' => array(
								'html_end' => '?px',
							),
						),
						'checkOutStepIconRadius' => array(
							'label' => '　結帳步驟樣式2',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'checkOutStepIconRadius',
								'name' => 'checkOutStepIconRadius',
								'size' => '8',
								'class' => 'checkOutStepTypes checkOutStepType__2',
							),
							'other' => array(
								'html_end' => '0=正方形、100%=圓形、1~99%(px) 圓角',
							),
						),
						'checkOutStepType3BorderW' => array(
							'label' => '　結帳步驟樣式3',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'checkOutStepType3BorderW',
								'name' => 'checkOutStepType3BorderW',
								'size' => '8',
								'class' => 'checkOutStepTypes checkOutStepType__3',
							),
							'other' => array(
								'html_end' => '?px',
							),
						),
						'proImgSizeType' => array(
							'label' => '產品列表圖比例',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'proImgSizeType',
								'name' => 'proImgSizeType',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '1=正方型 2、橫式(4:3) 3、直式(A4比例)',
							),
						),
						'albumImgSizeType' => array(
							'label' => '相簿列表圖比例',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'albumImgSizeType',
								'name' => 'albumImgSizeType',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '1=正方型 2、橫式(4:3) 3、直式(A4比例)',
							),
						),
						'videoImgSizeType' => array(
							'label' => '影片列表圖比例',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'videoImgSizeType',
								'name' => 'videoImgSizeType',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '1=正方型 2、橫式(4:3) 3、直式(A4比例)',
							),
						),
						'newsImgSizeType' => array(
							'label' => '最新消息列表圖比例',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'newsImgSizeType',
								'name' => 'newsImgSizeType',
								'size' => '8',
							),
							'other' => array(
								'html_end' => '1=正方型 2、橫式(4:3) 3、直式(A4比例)',
							),
						),
						'itemImgHoverEffect' => array(
							'label' => '圖片連結滑過效果',
							'type' => 'select3',
							'attr' => array(
								'id' => 'itemImgHoverEffect',
								'name' => 'itemImgHoverEffect',
							),
							'other' => array(
								'values' => array(
									'0' => '請選擇',
									'1' => '上下滑入',
									'2' => '淡入',
									'3' => '斜角',
								),
								'default' => '1',
							),
						),
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'section_title' => '隱藏 (有預設值)',
					'type' => '1',
					'field' => array(
						'line-height-base' => array(
							'label' => '基本行高',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'line-height-base',
								'name' => 'line-height-base',
								'size' => '8',
							),
						),
						'gray-base' => array(
							'label' => '灰階字',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'colorpicker',
							'attr' => array(
								'id' => 'gray-base',
								'name' => 'gray-base',
								'size' => '10',
							),
						),
						'link-hover-decoration' => array(
							'label' => '超連結底線',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'link-hover-decoration',
								'name' => 'link-hover-decoration',
								'size' => '10',
							),
						),
						'grid-gutter-width' => array(
							'label' => '盒子空間',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'grid-gutter-width',
								'name' => 'grid-gutter-width',
								'size' => '10',
							),
							'other' => array(
								'html_end' => 'grid space (padding-left 2em;padding-right 2em)',
							),
						),
						'space-base' => array(
							'label' => '基本空間',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'space-base',
								'name' => 'space-base',
								'size' => '10',
							),
							'other' => array(
								'html_end' => 'padding、margin',
							),
						),
						'xxx02' => array(
							'label' => 'Header設定：',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'headerHeight' => array(
							'label' => '　選單高度',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'headerHeight',
								'name' => 'headerHeight',
								'size' => '8',
							),
						),
						'headerScrollHeight' => array(
							'label' => '　捲動後選單高度',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'headerScrollHeight',
								'name' => 'headerScrollHeight',
								'size' => '8',
							),
						),
						// 'headerScrollBg' => array(
						// 	'label' => '　捲動後選單背景色',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'標題', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'headerScrollBg',
						// 		'name' => 'headerScrollBg',
						// 		'size' => '8',
						// 	),
						// ),
						'hamburgerPoint' => array(
							'label' => '　選單換漢堡',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'hamburgerPoint',
								'name' => 'hamburgerPoint',
								'size' => '8',
							),
						),
						'themeNum' => array(
							'label' => '樣版選擇',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'themeNum',
								'name' => 'themeNum',
								'size' => '8',
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

		$this->def['updatefield']['smarty_javascript_text'] = <<<XXX

$('#pageTitleStyle').change(function(){
	var thisobj = $(this);
	var id = $(this).val();
	$('.pageTitleStyles').each(function(){
		$(this).parent().parent().hide();
	});
	$('.pageTitleStyle__' + id).each(function(){
		$(this).parent().parent().show();
	});
});

$('#checkOutStepType').change(function(){
	var thisobj = $(this);
	var id = $(this).val();
	$('.checkOutStepTypes').each(function(){
		$(this).parent().parent().hide();
	});
	$('.checkOutStepType__' + id).each(function(){
		$(this).parent().parent().show();
	});
});

$('#blockTitleStyle').change(function(){
	var thisobj = $(this);
	var id = $(this).val();
	$('.blockTitleStyles').each(function(){
		$(this).parent().parent().hide();
	});
	$('.blockTitleStyle__' + id).each(function(){
		$(this).parent().parent().show();
	});
});

$('#newsDateStyle').change(function(){
	var thisobj = $(this);
	var id = $(this).val();
	$('.newsDateStyles').each(function(){
		$(this).parent().parent().hide();
	});
	$('.newsDateStyle__' + id).each(function(){
		$(this).parent().parent().show();
	});
});

XXX;

		return true;
	}

	/*
	protected function index_last($param='')
	{
		$this->data['listfield_start_html'] = <<<XXX
<br />
<div class="clearfix">
	<div class="btn-group">
		<button class="btn blue" onclick="javascript:location.href='../cssv2.php';"> 重新編譯 
		</button>
	</div>
</div>
XXX;
	}
	 */

	// protected function index_last($param='')
	// {
	// 	//var_dump($this->data['listcontent']);
	// 	if($this->data['listcontent']){
	// 		foreach($this->data['listcontent'] as $k => $v){
	// 			if($v['pic1'] != ''){
	// 				$v['pic1'] = $this->data['image_upload_path'].'/banner/'.$v['pic1'];
	// 			}
	// 			$this->data['listcontent'][$k] = $v;
	// 		}
	// 	}
	// }

	// protected function update_run_other_element($array)
	// {
	// 	$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
	// 	$array['type'] = 'banner';
	// 	return $array;
	// }

	// protected function create_run_other_element($array)
	// {
	// 	$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
	// 	$array['type'] = 'banner';
	// 	return $array;
	// }

	protected function update_run_last()
	{
		// 儲存後，轉到列表頁 #12645
		$_POST['prev_url'] = $this->createUrl($this->data['router_class'].'/update', array('param' => 'v'.$this->data['id']));
	}

	// protected function update_run_other_element($array)
	// {
	// 	// 儲存後，轉到列表頁 #12645
	// 	// 或是在update_show_last最末行，加上unset($this->data['update_base64_url'])
	// 	$array['update_base64_url'] = '';

	// 	return $array;
	// }

	protected function update_show_last($updatecontent)
	{
		// 留在此地，送出後 2016-10-11 winnie
		//unset($this->data['update_base64_url']);

		$id1 = $this->data['updatecontent']['pageTitleStyle'];
		$id2 = $this->data['updatecontent']['blockTitleStyle'];
		$id3 = $this->data['updatecontent']['newsDateStyle'];
		$id4 = $this->data['updatecontent']['checkOutStepType'];
		$this->data['def']['updatefield']['smarty_javascript_text'] .= <<<XXX

$('.pageTitleStyles').each(function(){
	$(this).parent().parent().hide();
});
$('.pageTitleStyle__$id1').each(function(){
	$(this).parent().parent().show();
});

$('.blockTitleStyles').each(function(){
	$(this).parent().parent().hide();
});
$('.blockTitleStyle__$id2').each(function(){
	$(this).parent().parent().show();
});
$('.newsDateStyles').each(function(){
	$(this).parent().parent().hide();
});
$('.newsDateStyle__$id3').each(function(){
	$(this).parent().parent().show();
});

$('.checkOutStepTypes').each(function(){
	$(this).parent().parent().hide();
});
$('.checkOutStepType__$id4').each(function(){
	$(this).parent().parent().show();
});


XXX;

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

	// protected function update_run_last($param='')
	// {
	// 	// 這是偷懶…的作法
	// 	$tmps = $this->_getFiles(_BASEPATH.'/assets/members/album'.$this->data['id'].'/member');
	// 	$this->cidb->where('type', 'albumtmp')->where('class_id', 'albumtmp')->delete('html'); 
	// 	foreach($tmps as $k => $v){
	// 		$data = array(
	// 			'type' => 'albumtmp',
	// 			'class_id' => $this->data['id'],
	// 			'pic1' => str_replace(_BASEPATH.'/', '', $v),
	// 		);
	// 		$this->cidb->insert('html', $data); 
	// 	}
	// }

	protected function create_show_last()
	{
		// 非必填(有預設值)
		$this->data['updatecontent']['cis-color-2'] = '#333333';
		$this->data['updatecontent']['cis-color-3'] = '#b3b3b3';
		$this->data['updatecontent']['googlefont'] = 'Lato';
		$this->data['updatecontent']['googlefont_import'] = '@import url(https://fonts.googleapis.com/css?family=Lato:400,300,100italic,300italic,100,400italic,700,700italic,900,900italic);';
		$this->data['updatecontent']['font-size-base'] = '16px';
		$this->data['updatecontent']['border-base'] = '1px';
		// $this->data['updatecontent']['proItemImgBg'] = '$cis-color-1';
		$this->data['updatecontent']['proItemImgBg'] = 'none'; // 2017.04.24 leo說經理交待產品detail圖不要背景色
		$this->data['updatecontent']['body-bg'] = '#F7F8F8';
		$this->data['updatecontent']['text-color'] = '#333333';
		$this->data['updatecontent']['topLinkBgColor'] = ''; // 這個沒有預設值，但是必需要設空值，這樣子colorpicker的模組欄位運作才會正常
		$this->data['updatecontent']['checkOutStepType1BorderW'] = '2px';
		$this->data['updatecontent']['checkOutStepIconRadius'] = '100%';
		$this->data['updatecontent']['checkOutStepType3BorderW'] = '1px';
		$this->data['updatecontent']['proImgSizeType'] = '1';
		$this->data['updatecontent']['albumImgSizeType'] = '1';
		$this->data['updatecontent']['videoImgSizeType'] = '2';
		$this->data['updatecontent']['newsImgSizeType'] = '2';



		// 隱藏(有預設值)
		$this->data['updatecontent']['line-height-base'] = '2';
		$this->data['updatecontent']['gray-base'] = '#333333';
		$this->data['updatecontent']['link-hover-decoration'] = 'none';
		$this->data['updatecontent']['grid-gutter-width'] = '$font-size-base*4';
		$this->data['updatecontent']['space-base'] = '$font-size-base*2';
		$this->data['updatecontent']['headerHeight'] = '90px';
		$this->data['updatecontent']['headerScrollHeight'] = '60px';
		//$this->data['updatecontent']['headerScrollBg'] = '$cis-color-1';
		$this->data['updatecontent']['hamburgerPoint'] = '1024px';
		$this->data['updatecontent']['themeNum'] = '1';

		$this->data['def']['updatefield']['smarty_javascript_text'] .= <<<XXX

$('.pageTitleStyles').each(function(){
	$(this).parent().parent().hide();
});
//$('.pageTitleStyle__$\id1').each(function(){
//	$(this).parent().parent().show();
//});

$('.blockTitleStyles').each(function(){
	$(this).parent().parent().hide();
});
//$('.blockTitleStyle__$\id2').each(function(){
//	$(this).parent().parent().show();
//});

$('.newsDateStyles').each(function(){
	$(this).parent().parent().hide();
});

$('.checkOutStepTypes').each(function(){
	$(this).parent().parent().hide();
});
$('.checkOutStepType__1').each(function(){ // 因為子選項要跟著預設值顯示
	$(this).parent().parent().show();
});


XXX;

		// 為了支援section_title
		$this->data['main_content'] = 'member/update';
	}

}

/* 2017-02-03
ALTER TABLE `scss_config` ADD `checkOutStepType` VARCHAR( 20 ) NOT NULL ,
ADD `checkOutStepType1BorderW` VARCHAR( 20 ) NOT NULL ,
ADD `checkOutStepIconRadius` VARCHAR( 20 ) NOT NULL ,
ADD `checkOutStepType3BorderW` VARCHAR( 20 ) NOT NULL ,
ADD `proImgSizeType` VARCHAR( 20 ) NOT NULL ,
ADD `albumImgSizeType` VARCHAR( 20 ) NOT NULL ,
ADD `videoImgSizeType` VARCHAR( 20 ) NOT NULL ,
ADD `newsImgSizeType` VARCHAR( 20 ) NOT NULL ;
 */
