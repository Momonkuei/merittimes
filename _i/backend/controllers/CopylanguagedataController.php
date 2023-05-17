<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

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
		// 		'onclick' => 'javascript:location.href=\'XXX\'',
		// 	),
		// ),

		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				// array('topic', 'required'),
				// array('detail', 'system.backend.extensions.myvalidators.numericcodeutf8'),
				// array('start_date', 'date', 'format'=>'yyyy-M-d'),
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
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
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
			'topic' => array(
				'label' => '英文別名',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '35%',
				'sort' => true,
			),
			'name' => array(
				// 'label' => '名稱',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '60%',
				'sort' => true,
			),
			'xx2' => array(
				'label' => '分類',			
				'width' => '8%',
				'sort' => true,
			),
			//'funcfieldv3_split_1' => array(
			//	// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
			//	'width' => '',
			//),
			'sort_id_home' => array(
				// 'label' => '通用(0) / 獨立(1) / 單頁(2)',
				'label' => '結構',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '6',
				'align' => 'center',
				'sort' => false,
			),
			// 'sort_id_browser' => array(
			// 	//'label' => '略過(0) / 有分類(1)',
			// 	'label' => '分項',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'標題', // default
			// 	//),
			// 	'width' => '6%',
			// 	'align' => 'center',
			// 	'sort' => false,
			// ),
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
			'is_top' => array(
				'label' => '提升優先權',
				'width' => '10%',
				'align' => 'center',
				//'sort' => true,
				'ezfield' => 'is_top',
				'ezother'=> '&nbsp;',
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
			'start_date' => array(
				//'label' => '日期',
				'mlabel' => array(
					null, // category
					'Date', // label
					array(), // sprintf
					'日期', // default
				),
				'width' => '15%',
				'sort' => true,
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
						'source' => array(
							'label' => '來源語系',
							'type' => 'input',
							'attr' => array(
								'id' => 'source',
								'name' => 'source',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '例：tw',
							),
						),
						'dest' => array(
							'label' => '目標語系',
							'type' => 'input',
							'attr' => array(
								'id' => 'dest',
								'name' => 'dest',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '例：en',
							),
						),
						'xx01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '<font color="red"><b>* 按下搜尋按鈕，就會刪掉目標語系，並將來源資料複製過去，所以請記得先備份資料庫！！</b></font><br /><br />
<font color="red"><b>* 匯入SQL時，請記得要先備份這裡的規則，在本頁最下面的地方！！</b></font><br /><br />
優先權：webmenuchild(前台次選單-靜態), webmenu(前台主選單), webmenusub(前台副功能列), 分類(依排序編號), 分項(依排序編號)<br /><br />
依照優先權，後面的可以參照前面的，分項可以參照分類，分項可以參照分項<br />
如果要讓分類可以參照分項，要在該分項勾選"提升優先權"<br />
<br />
如果要參照自己，例如相關產品複選，那就複製product成另一個資料表，然後勾選"提升優先權"之後，就可以寫規則了(格式)<br />
',
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
							//'label' => '標題',
							'mlabel' => array(
								null, // category
								'Title', // label
								array(), // sprintf
								'標題', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'topic' => array(
							'label' => '英文別名',
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '例：webmenu(前台主選單), webmenuchild(前台次選單-靜態), webmenusub(前台副功能列), newstype, download',
							),
						),
						'class_id' => array(
							'label' => '分類',
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
						'sort_id_home' => array(
							'label' => '&nbsp;',
							'type' => 'status2',
							'attr' => array(
								'id' => 'sort_id_home',
								'name' => 'sort_id_home',
							),
							'other' => array(
								'default'=>'0',
								'values' => array(
									'0' => '通用',
									'1' => '獨立',
									'2' => '單頁',
								),
								'html_start' => '結構：',
							),
						),
						'detail' => array(
							'label' => '參照',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								'rows' => '4',
								'cols' => '40',
							),
							'other' => array(
								'html_end' => '格式：<br />
選項(1單選 | 2複選),Table欄位名稱,資料流(英文別名)可留空，預設規則為XXX<b>type</b><br /><br />

單選範例：<br />
1,class_id,newstype<br /><br />

複選範例：<br />
2,class_ids,producttype<br />
',
							),
						),						
						// 'xx01' => array(
						// 	'label' => '&nbsp;',
						// 	'type' => 'inputn',
						// 	'other' => array(
						// 		'html' => '分類： (無)',
						// 	),
						// ),
						// 'sort_id_browser' => array(
						// 	'label' => '&nbsp;',
						// 	'type' => 'status2',
						// 	'merge' => 1,
						// 	'attr' => array(
						// 		'id' => 'sort_id_browser',
						// 		'name' => 'sort_id_browser',
						// 	),
						// 	'other' => array(
						// 		'default'=>'0',
						// 		'values' => array(
						// 			'0' => '略過',
						// 			'1' => '有分類',
						// 		),
						// 		'html_start' => '分項：',
						// 	),
						// ),
						// 'other1' => array(
						// 	'label' => '&nbsp;',
						// 	'type' => 'input',
						// 	'merge' => 3,
						// 	'attr' => array(
						// 		'id' => 'other1',
						// 		'name' => 'other1',
						// 		'size' => '10',
						// 	),
						// 	'other' => array(
						// 		'default'=>'0',
						// 		'values' => array(
						// 			'0' => '略過',
						// 			'1' => '有分類',
						// 		),
						// 		'html_start' => '　分類是誰：',
						// 		'html_end' => ' ( 預設是XXX<b>type</b> )',
						// 	),
						// ),
						// 'sort_id' => array(
						// 	//'label' => 'ml:Sort',
						// 	'mlabel' => array(
						// 		null, // category
						// 		'Sort', // label
						// 		array(), // sprintf
						// 		'排序', // default
						// 	),
						// 	'type' => 'sort',
						// 	'attr' => array(
						// 	),
						// ),
						'start_date' => array(
							//'label' => '日期',
							'mlabel' => array(
								null, // category
								'Date', // label
								array(), // sprintf
								'日期', // default
							),
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
				// funcfieldv3的產出欄位，放在任何位置都可以，有需要就打開 2/7
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '1',
				//	'_has_funcfieldv3_result' => true, // 要記得這個要加
				//	'field' => array(
				//	),
				//),
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						// 'field_tmp' => array(
						// 	'label' => '描述',
						// 	'type' => 'textarea',							
						// 	'attr' => array(
						// 		'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'field_tmp',
						// 		'name' => 'field_tmp',
						// 		'rows' => '4',
						// 		'cols' => '100',
						// 	),
						// ),
						// 'detail' => array(
						// 	'label' => '內容',
						// 	//'type' => 'textarea',
						// 	'type' => 'ckeditor_js',
						// 	'attr' => array(
						// 		//'class' => 'form-control', // 這…手動加上去好了
						// 		'id' => 'detail',
						// 		'name' => 'detail',
						// 		//'rows' => '4',
						// 		//'cols' => '40',
						// 	),
						// ),
					),
				),
				// 商品複製，這個是固定的，排在第三個位置
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'name' => array(
							'label' => '名稱',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'name',
							//	'name' => 'name',
							//	'size' => '40',
							//),
						),
						'topic' => array(
							'label' => '名稱',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'name',
							//	'name' => 'name',
							//	'size' => '40',
							//),
						),
						'class_id' => array(
							'label' => '分類',
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
				// funcfieldv3的自定欄位，放在任何位置都可以，有需要就打開 3/7
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '1',
				// 	'_has_funcfieldv3_custom' => true, // 要記得這個要加
				// 	'field' => array(
				// 	),
				// ),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$product_table = $this->data['router_class'];
		//$product_table = str_replace('homesort', '', $product_table); // 為了支援產品的首頁排序

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 匯出功能之二
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
		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();

		// A方案的客制功能專用
		if(0){
			$rowg = array(
				'pic2' => 1, // 分類
				'is_news' => 1, // 通用分類
				'class_ids' => 1, // 通用分項
			);
		}

		if($rowg){ 
			if(isset($rowg['pic3']) and $rowg['pic3'] == 1){ // 有日期排序的情況下
				// do nothing
				unset($this->def['listfield']['sort_id']);
				unset($this->def['updatefield']['sections'][0]['field']['sort_id']);
				$this->def['default_sort_field'] = 'start_date';
			} else { // 2018-01-11
				unset($this->def['listfield']['start_date']);
				if(isset($this->def['updatefield']['sections'][0]['field']['start_date'])){
					unset($this->def['updatefield']['sections'][0]['field']['start_date']);
				}
				$this->def['default_sort_field'] = 'sort_id';
				if(isset($this->def['default_sort_direction'])){
					unset($this->def['default_sort_direction']);
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

				$this->def['empty_orm_data']['rules'][] = array('class_id', 'required');

				if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類
					$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
					if($rows and count($rows) > 0){
						foreach($rows as $k => $v){
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
						}
					}
				} else { // 是獨立分類
					// 這裡是從產品那邊複製過來的
				
					// 分類
					$producttype_table = $this->data['router_class'];
					//$producttype_table = str_replace('homesort', '', $producttype_table); // 為了支援產品的首頁排序(這是homesort的另一支後台功能在用的，註解不要打開)
					$producttype_table .= 'type';

					$rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
					if($rows and count($rows) > 0){
						foreach($rows as $k => $v){
							//大分類不可選
							/*
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
							$rows2 = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
							*/
							//大分類可選
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';

							//無限層
							$data_1 = $this->layout_show($v['id'],1,'　',$this->data['router_class'].'type');//'　└'	
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;

							/* //兩層
							$rows2 = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
							if($rows2 and count($rows2) > 0){
								foreach($rows2 as $kk => $vv){
									$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
									$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
								}
							}
							*/
						}
					}
				}
			} else { // 無分類			
				unset($this->def['searchfield']);
				unset($this->def['updatefield']['sections'][0]['field']['class_id']);
				unset($this->def['listfield']['xx2']);
			}
		} else {
			// 沒有跟webmenu掛勾的，這個欄位就不用了，需要的話，自行在funcfieldv3使用
			unset($this->def['updatefield']['sections'][0]['field']['start_date']);
		} // if row

		// funcfieldv3 有需要就打開 4/7
		// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		// $contentx = str_replace('<'.'?'.'php', '', $contentx);
		// eval($contentx);

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

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';


		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
				$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
			} else {
				$condition = '  ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
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
			//unset($this->def['searchfield']);
			unset($this->def['updatefield']['sections'][0]['field']['class_id']);
			unset($this->def['listfield']['xx2']);

			// 通用分項
			$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
			$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		}

		if(isset($session) and count($session) > 0 and $session['source'] != '' and $session['dest'] != '' and $session['source'] != $session['dest']){
			// 這樣子才不會一重整的時候就送
			unset($_SESSION[$ss]);

			/*
			 * array(4) {
			 *   ["source"]=>
			 *   string(2) "gg"
			 *   ["dest"]=>
			 *   string(2) "aa"
			 *   ["update_base64_url"]=>
			 *   string(0) ""
			 *   ["prev_url"]=>
			 *   string(0) ""
			 * }
			 */
			// var_dump($session);

			// en_name/old_id/new_id
			$map = array();
			$html_map = array(); // 2019-10-16 為了支援通用功能-多圖上傳

			// key是資料表
			$save_webmenuchild = array();
			$save_webmenu = array();
			$save_webmenusub = array();
			//$save_type = array();
			//$save = array();

			/*
			 * webmenuchild
			 */
			$row = $this->cidb->where('is_enable',1)->where('type','copylanguagedata')->where('topic','webmenuchild')->where('ml_key',$this->data['ml_key'])->get('html')->row_array();
			if($row and isset($row['id'])){
				$v = array();
				$v['topic'] = $row['topic'];
				$this->cidb->delete($v['topic'], array('ml_key'=>$session['dest'])); 

				// 獨立資料表，無限層
				// 這個是從下面複製上來的
				$rows2 = $this->cidb->select('*, id as old_id')->where('ml_key',$session['source'])->get($v['topic'])->result_array();
				if($rows2){
					foreach($rows2 as $kk => $vv){
						unset($vv['id']); // 因為己經另存到old_id
						$vv['ml_key'] = $session['dest'];

						// 客製
						$vv['url'] = str_replace('_'.$session['source'].'.','_'.$session['dest'].'.',$vv['url']);
						$vv['url'] = str_replace('_'.$session['source'].'_','_'.$session['dest'].'_',$vv['url']);

						$rows2[$kk] = $vv;
					}
					foreach($rows2 as $kk => $vv){
						if(!isset($save_webmenuchild[$v['topic']])){
							$save_webmenuchild[$v['topic']] = array();
						}
						$save_webmenuchild[$v['topic']][] = $vv;
					}
				}
			}

			// 寫入並更新$map -0
			if($save_webmenuchild){
				// @k {XXX}type
				foreach($save_webmenuchild as $k => $v){
					foreach($v as $kk => $vv){
						$old_id = $vv['old_id'];
						unset($vv['old_id']);
						// echo $k;
						$this->cidb->insert($k, $vv); 
						$id = $this->cidb->insert_id();
						$map[$k][$old_id] = $id;
					}
				}

				// 無限層的部份，要分兩次做，這裡是第二次
				foreach($save_webmenuchild as $k => $v){
					foreach($v as $kk => $vv){
						if($vv['pid'] > 0 and isset($map[$k][$vv['pid']])){ // 無限層
							// $this->cidb->where('id', $vv['id']);
							$this->cidb->where('id', $map[$k][$vv['old_id']]);
							$this->cidb->update($k, array('pid'=>$map[$k][$vv['pid']])); 
						}
					}
				}
			}

			/*
			 * webmenu
			 */
			$row = $this->cidb->where('is_enable',1)->where('type','copylanguagedata')->where('topic','webmenu')->where('ml_key',$this->data['ml_key'])->get('html')->row_array();
			if($row and isset($row['id'])){
				$v = array();
				$v['topic'] = $row['topic'];
				$this->cidb->delete('html', array('ml_key'=>$session['dest'],'type'=>$v['topic'])); 

				// 通用資料表
				// 一樣是從下面複製上來的
				$rows2 = $this->cidb->select('*, id as old_id')->where('type',$v['topic'])->where('ml_key',$session['source'])->get('html')->result_array();
				if($rows2){
					foreach($rows2 as $kk => $vv){
						unset($vv['id']); // 因為己經另存到old_id
						$vv['ml_key'] = $session['dest'];

						// 客製
						$vv['url1'] = str_replace('_'.$session['source'].'.','_'.$session['dest'].'.',$vv['url1']);
						$vv['url1'] = str_replace('_'.$session['source'].'_','_'.$session['dest'].'_',$vv['url1']);

						// 檢查有沒有靜態次選單
						if($vv['video_2'] > 0 and isset($map['webmenuchild'][$vv['video_2']])){
							$vv['video_2'] = $map['webmenuchild'][$vv['video_2']];
						}

						$rows2[$kk] = $vv;
					}
					foreach($rows2 as $kk => $vv){
						// if(!isset($save['html'])){
						// 	$save['html'] = array();
						// }
						// $save['html'][] = $vv;

						// 寫在這裡，為了支援other1的那個欄位
						$old_id = $vv['old_id'];
						unset($vv['old_id']);
						$this->cidb->insert('html', $vv); 
						$id = $this->cidb->insert_id();

						$map['html'][$old_id] = $id;
						$html_map[$old_id] = 'webmenu';
						$html_map[$id] = 'webmenu'; // 新編號是預留

					}
				}
			}

			/*
			 * webmenusub
			 */
			$row = $this->cidb->where('is_enable',1)->where('type','copylanguagedata')->where('topic','webmenusub')->where('ml_key',$this->data['ml_key'])->get('html')->row_array();
			if($row and isset($row['id'])){
				$v = array();
				$v['topic'] = $row['topic'];
				$this->cidb->delete('html', array('ml_key'=>$session['dest'],'type'=>$v['topic'])); 

				// 通用資料表
				// 一樣是從下面複製上來的
				$rows2 = $this->cidb->select('*, id as old_id')->where('type',$v['topic'])->where('ml_key',$session['source'])->get('html')->result_array();
				if($rows2){
					foreach($rows2 as $kk => $vv){
						unset($vv['id']); // 因為己經另存到old_id
						$vv['ml_key'] = $session['dest'];

						// 客製
						$vv['url1'] = str_replace('_'.$session['source'].'.','_'.$session['dest'].'.',$vv['url1']);
						$vv['url1'] = str_replace('_'.$session['source'].'_','_'.$session['dest'].'_',$vv['url1']);

						// 檢查有沒有靜態次選單
						// if($vv['video_2'] > 0 and isset($map['webmenuchild'][$vv['video_2']])){
						// 	$vv['video_2'] = $map['webmenuchild'][$vv['video_2']];
						// }

						$rows2[$kk] = $vv;
					}
					foreach($rows2 as $kk => $vv){
						// if(!isset($save['html'])){
						// 	$save['html'] = array();
						// }
						// $save['html'][] = $vv;

						// 寫在這裡，為了支援other1的那個欄位
						$old_id = $vv['old_id'];
						unset($vv['old_id']);
						$this->cidb->insert('html', $vv); 
						$id = $this->cidb->insert_id();

						$map['html'][$old_id] = $id;
						$html_map[$old_id] = 'webmenusub';
						$html_map[$id] = 'webmenusub'; // 新編號是預留

					}
				}
			}


			/*
			 * 高優先權的分項
			 */
			$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','copylanguagedata');
			$o = $o->not_like('topic','type','before');
			$o = $o->where('is_top',1); // 跟下面的分項差在這個條件
			$o = $o->where('topic !=','webmenu')->where('topic !=','webmenuchild')->where('topic !=','webmenusub');
			$copy_rows = $o->order_by('sort_id','asc')->get('html')->result_array();
			$copy_is_type = false;
			include 'backend/include/copylanguagedata.php';

			/*
			 * 先做分類(有type結尾)
			 */
			$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','copylanguagedata');
			$o = $o->like('topic','type','before');
			$o = $o->where('is_top',0);
			$copy_rows = $o->order_by('sort_id','asc')->get('html')->result_array();
			$copy_is_type = true;
			include 'backend/include/copylanguagedata.php';

			// var_dump($map);
			// die;

			/*
			 * 在做分項(沒type結尾)
			 */
			$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','copylanguagedata');
			$o = $o->not_like('topic','type','before');
			$o = $o->where('is_top',0);
			$o = $o->where('topic !=','webmenu')->where('topic !=','webmenuchild')->where('topic !=','webmenusub');
			$copy_rows = $o->order_by('sort_id','asc')->get('html')->result_array();
			$copy_is_type = false;
			include 'backend/include/copylanguagedata.php';

			// 2018-07-05 複製編輯器kcfinder的多張圖 #28135
			if(count($map) > 0){
				// @k 資料表
				foreach($map as $k => $v){
					$funcname = $k;

					// @kk 舊編號
					// @vv 新編號
					foreach($v as $kk => $vv){
						// 2019-10-16 為了支援通用
						if($k == 'html' and isset($html_map[$kk])){
							$funcname = $html_map[$kk];
						}

						$dirname_rules = array(
							_BASEPATH.'/assets/members/'.$funcname.'ID/',
							_BASEPATH.'/assets/members/'.$funcname.'_AAA_ID/', // 新規則的第一個kcfinder
							_BASEPATH.'/assets/members/'.$funcname.'_AAA_ID/', // 新規則的第二個kcfinder
							_BASEPATH.'/assets/members/'.$funcname.'_AAA_ID/', // 新規則的第三個kcfinder
							_BASEPATH.'/assets/members/'.$funcname.'_AAA_ID/', // 新規則的第四個kcfinder
							_BASEPATH.'/assets/members/'.$funcname.'_AAA_ID/', // 新規則的第五個kcfinder
						);
						// @kkk 流水號
						// @vvv 規則
						foreach($dirname_rules as $kkk => $vvv){

							$current_dirname = $vvv;
							$current_dirname = str_replace('AAA', $kkk, $current_dirname);
							$current_dirname = str_replace('ID', $kk, $current_dirname);

							if(file_exists($current_dirname)){
								$source = $current_dirname;

								$dest = $vvv;
								$dest = str_replace('AAA', $kkk, $dest);
								$dest = str_replace('ID', $vv, $dest);
								@mkdir($dest, 0777, true);

								// file_put_contents('123.php',$source.' '.$dest);
								$this->smartCopy($source, $dest);
							}
						}
					}
				}

				// 備份新舊的相依性，也就是舊的編號和新的編號之間的關係
				file_put_contents(_BASEPATH.'/assets/copylanguagedata_map_'.date('Y-m-d-H-i-s').'.php', var_export($map,true));
			}

		} // SEARCH END


		if(trim($condition) != ''){
			$this->def['condition'][] = array(
				'where',
				$condition,
			);
		}
		if(trim($condition_sortable) != ''){
			$this->def['sortable']['condition'] = $condition_sortable;
		}
		

		// 這是SEO的欄位的範本，如果你需要，就打開它 2/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') && $_constant ){
			$seo_func = 'a';
			include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
		}

		return true;
	}

	protected function index_first($param='')
	{
		// 前台主選單的資料表功能
		$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($row and isset($row['pic2']) and $row['pic2'] == 1 and $row['pic3'] != 1){ // 有分類，而且不是日期排序
			// 取得商品分類的編號
			$class_id = 0;
			if(isset($_SESSION[$this->data['router_class'].'_search']['class_id']) and $_SESSION[$this->data['router_class'].'_search']['class_id'] > 0){
				$class_id = $_SESSION[$this->data['router_class'].'_search']['class_id'];
			}
			$this->data['class_id'] = $class_id;

			if($class_id <= 0){
				unset($this->data['def']['listfield'][$this->data['def']['func_field']['sort_id']]);
			}

			// 商品分類編號要有指定，還有其它必要的條件，才能夠即時自動切換
			if($class_id > 0){
				$this->data['def']['sortable']['enable'] = true;

				// 疑似Bug 2017-03-24
				// $this->data['def']['sortable']['condition'] = 'class_id = '.$this->data['class_id'].' ';
				// $this->data['def']['condition']['where']['class_id'] = $class_id;
			} else {
				$this->data['def']['sortable']['enable'] = false;
			}

			// 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱
			if($class_id <= 0 and $this->data['sort_field_nobase64'] == $this->data['def']['func_field']['sort_id']){
				$sort_field = 'id'; // $sort_field = 'topic';
				$this->data['params']['direction'] = 'desc';// 2016/6/23 初始化為反序，方便客戶馬上看到新增的資料

				$this->data['sort_field'] = base64url::encode($sort_field);
				$this->data['sort_field_nobase64'] = $sort_field;
			}
		} else { // 無分類
			parent::index_first($param);
		}
	}

	protected function create_show_last($param='')
	{
		// unset($this->data['def']['updatefield']['sections'][1]['field']['kc01']);

		// funcfieldv3 有需要就打開 5/7
		//$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		//$contentx = str_replace('<'.'?'.'php', '', $contentx);
		//eval($contentx);
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
		}

		// funcfieldv3 有需要就打開 6/7
		// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		// $contentx = str_replace('<'.'?'.'php', '', $contentx);
		// eval($contentx);

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

	protected function index_last($param='')
	{
		//var_dump($this->data['listcontent']);

		$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
			if(isset($row['is_news']) and $row['is_news'] == 1){ // 是通用分類
				$show_type_mode = 1; //通用資料表
			}else{
				$show_type_mode = 2; //獨立資料表
			}
		}else{
			$show_type_mode = 0; //沒有分類
		}
		
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				//這邊先做通用的，獨立的以後再說 by lota
				if($v['class_id']!=0 && $show_type_mode==1){
					$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id='.$v['class_id'], array(':type'=>$this->data['router_class'].'type',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
					$v['xx2'] = $rows['topic'];
				}			

				// 商品複製
				// 2017-07-20 李哥說，要加上授權，就是99999開頭的都要加
				if(0 and preg_match('/^99999/', $this->data['admin_id'])){
					$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> Copy</a>';
				}

				// 'sort_id_home' => array(
				// 	// 'label' => '通用(0) / 獨立(1) / 單頁(2)',
				// 	'label' => '結構',
				// 'sort_id_browser' => array(
				// 	//'label' => '略過(0) / 有分類(1)',
				// 	'label' => '分項',
				if(isset($this->data['def']['updatefield']['sections'][0]['field']['sort_id_home']['other']['values'][$v['sort_id_home']])){
					$v['sort_id_home'] = $this->data['def']['updatefield']['sections'][0]['field']['sort_id_home']['other']['values'][$v['sort_id_home']];
				}

				if(isset($this->data['def']['updatefield']['sections'][0]['field']['sort_id_browser']['other']['values'][$v['sort_id_browser']])){
					if($v['sort_id_browser'] > 0){
						$v['sort_id_browser'] = $this->data['def']['updatefield']['sections'][0]['field']['sort_id_browser']['other']['values'][$v['sort_id_browser']];
					} else {
						$v['sort_id_browser'] = '';
					}
				}

				$this->data['listcontent'][$k] = $v;
			}
		}

		// 2019-01-17
		$this->data['listfield_end_html'] = '';

		$sql = '<pre>'."\n";
		$sql .= '--'."\n";
		$sql .= '-- <b>'.$this->data['sys_configs']['admin_title'].' / 語系資料複製 / 規則備份</b>'."\n";
		$sql .= '-- '.date('Y年m月d日 H點i分s秒')."\n";
		$sql .= '--'."\n";
		$sql .= "\n";
		$sql .= 'DELETE FROM `html` WHERE type=\'copylanguagedata\';'."\n";
		$rows = $this->cidb->where('type','copylanguagedata')->where('ml_key','tw')->order_by('sort_id','asc')->get('html')->result_array();
		$sql .= 'INSERT INTO `html` (`type`, `ml_key`, `topic`, `class_id`, `detail`, `sort_id_home`, `is_top`, `is_enable`, `sort_id`) VALUES'."\n";
		$sqls = array();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$sqls[] = '(\'copylanguagedata\',\'tw\',\''.$v['topic'].'\','.$v['class_id'].',\''.str_replace("\r\n",'\r\n',$v['detail']).'\','.$v['sort_id_home'].','.$v['is_top'].','.$v['is_enable'].','.$v['sort_id'].')';
			}
		}
		$sql .= implode(','."\n", $sqls).';'."\n";
		$sql .= '</pre>';

		$this->data['listfield_end_html'] = $sql;

		// $this->data['main_content'] = 'default/index';
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
		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();

		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$row = $this->db->createCommand()->from('html')->where('is_enable=1 and id=:id and ml_key=:ml_key',array(':id' => $update['is_copy'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
				$save = $row;
				unset($save['id']);
				unset($save['update_time']);
				$save['topic'] = $save['topic'].' (複製)';
			} else {
				$row = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and id=:id and ml_key=:ml_key',array(':id' => $update['is_copy'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
				$save = $row;
				unset($save['id']);
				unset($save['update_time']);
				$save['name'] = $save['name'].' (複製)';
			}

			// 單分類排序
			if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
				$save['class_id'] = $update['class_id'];
				if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類
					$row2 = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and type=:type and class_id=:id and ml_key=:ml_key',array(':type'=>$this->data['router_class'],':id' => $update['class_id'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
				} else {
					$row2 = $this->db->createCommand()->select('id')->from($this->data['router_class'])->where('is_enable=1 and class_id=:id and ml_key=:ml_key',array(':id' => $update['class_id'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
				}
			}
			$save[$this->def['func_field']['sort_id']] = count($row2) + 1;
			$save['create_time'] = date('Y-m-d H:i:s');
			$this->cidb->insert($this->data['router_class'], $save);
		}

		// [多分類排序]
		// 請去參考購物產品

		// 複製成功後，轉到列表頁，並且搜尋該分類，而且排序欄位做反向，這樣子就可以看到複製出來的那一筆
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		if($session === null){
			$session = array();
		}
		$session['class_id'] = $update['class_id'];
		Yii::app()->session[$ss] = $session;

		$parameter = new Parameter_handle;
		$param_define = $parameter->getDefine();
		//$url = $this->createUrl($this->data['router_class'].'/index', array('param' => base64url::encode('sort_id').'-'.$param_define['direction'].'desc'));
		$url = $this->createUrl($this->data['router_class'].'/index', array('param' => base64url::encode($this->def['func_field']['sort_id']).'-'.$param_define['direction'].'desc'));

		G::alert_and_redirect('Copy Success !', $url, $this->data);

		die;
	}

	protected function update_run_last($param='')
	{
		// 2018-02-21 自動模組處理(auto_module_handle)
		foreach($this->data['def']['updatefield']['sections'] as $k => $v){
			foreach($v['field'] as $kk => $vv){
				if(isset($vv['type'])){
					if($vv['type'] == 'kcfinder_school'){
						if(!isset($_auto_module_handle_kcfinder_school_counter2)){
							$_auto_module_handle_kcfinder_school_counter2 = 0;
						}
						$_auto_module_handle_kcfinder_school_counter2++;
						//$this->data['def']['updatefield']['sections'][$k]['field'][$kk]['other']['school_id'] = $this->data['router_class'].'_'.$_auto_module_handle_kcfinder_school_counter.'_'.$this->data['updatecontent']['id'];
						// 這是偷懶…的作法，只針對第一區塊來做，要記得…
						$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_class'].'_'.$_auto_module_handle_kcfinder_school_counter2.'_'.$this->data['id'].'/member');
						sort($tmps);//按照檔名排序後存到資料庫 by lota
						$this->cidb->where('type', $this->data['router_class'].'detailtmp'.$_auto_module_handle_kcfinder_school_counter2)->where('class_id', $this->data['id'])->delete('html'); 
						foreach($tmps as $k => $v){
							$data = array(
								'type' => $this->data['router_class'].'detailtmp'.$_auto_module_handle_kcfinder_school_counter2,
								'class_id' => $this->data['id'],
								'pic1' => str_replace(_BASEPATH.'/', '', $v),
							);
							$this->cidb->insert('html', $data); 
						}
					}
				}
			}
		}

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

		// funcfieldv3 有需要就打開 7/7
		// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		// $contentx = str_replace('<'.'?'.'php', '', $contentx);
		// eval($contentx);

		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		// $array['detail'] = $this->numeric_code_utf8($array['detail']); // system.backend.extensions.myvalidators.numbericcodeutf8
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	// 解無限層分類
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}

	/**
	 * Create a new directory, and the whole path.
	 *
	 * If  the  parent  directory  does  not exists, we will create it,
	 * etc.
	 * @todo
	 *     - PHP5 mkdir functoin supports recursive, it should be used
	 * @author baldurien at club-internet dot fr 
	 * @param string the directory to create
	 * @param int the mode to apply on the directory
	 * @return bool return true on success, false else
	 * @previousNames mkdirs
	 */

	protected function makeAll($dir, $mode = 0777, $recursive = true) {
		if( is_null($dir) || $dir === "" ){
			return FALSE;
		}

		if( is_dir($dir) || $dir === "/" ){
			return TRUE;
		}
		if( $this->makeAll(dirname($dir), $mode, $recursive) ){
			return mkdir($dir, $mode);
		}
		return FALSE;
	}

	/**
	 * 2018-07-06
	 * 目的資料夾，要先建立，不然不會動作
	 * $this->smartCopy('/var/zpanel/hostdata/zadmin/public_html/deesgroup_com_tw/_i/assets/members/product_1_63/', '/var/zpanel/hostdata/zadmin/public_html/deesgroup_com_tw/_i/assets/members/product_1_141/');
	 *
	 * Copies file or folder from source to destination, it can also do
	 * recursive copy by recursively creating the dest file or directory path if it wasn't exist
	 * Use cases:
	 * - Src:/home/test/file.txt ,Dst:/home/test/b ,Result:/home/test/b -> If source was file copy file.txt name with b as name to destination
	 * - Src:/home/test/file.txt ,Dst:/home/test/b/ ,Result:/home/test/b/file.txt -> If source was file Creates b directory if does not exsits and copy file.txt into it
	 * - Src:/home/test ,Dst:/home/ ,Result:/home/test/** -> If source was directory copy test directory and all of its content into dest      
	 * - Src:/home/test/ ,Dst:/home/ ,Result:/home/**-> if source was direcotry copy its content to dest
	 * - Src:/home/test ,Dst:/home/test2 ,Result:/home/test2/** -> if source was directoy copy it and its content to dest with test2 as name
	 * - Src:/home/test/ ,Dst:/home/test2 ,Result:->/home/test2/** if source was directoy copy it and its content to dest with test2 as name
	 *
	 * @author Sina Salek (<a href="http://sina.salek.ws/node/1289" title="http://sina.salek.ws/node/1289">http://sina.salek.ws/node/1289</a>)
	 * @todo
	 *  - Should have rollback so it can undo the copy when it wasn't completely successful
	 *  - It should be possible to turn off auto path creation feature f
	 *  - Supporting callback function
	 *  - May prevent some issues on shared enviroments : <a href="http://us3.php.net/umask" title="http://us3.php.net/umask">http://us3.php.net/umask</a>
	 * @param $source //file or folder
	 * @param $dest ///file or folder
	 * @param $options //folderPermission,filePermission
	 * @return boolean
	 */
	protected function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755))
	{
		$result=false;

		//For Cross Platform Compatibility
		if (!isset($options['noTheFirstRun'])) {
			$source=str_replace('\\','/',$source);
			$dest=str_replace('\\','/',$dest);
			$options['noTheFirstRun']=true;
		}

		if (is_file($source)) {
			if ($dest[strlen($dest)-1]=='/') {
				if (!file_exists($dest)) {
					$this->makeAll($dest,$options['folderPermission'],true);
				}
				$__dest=$dest."/".basename($source);
			} else {
				$__dest=$dest;
			}
			if (!file_exists($__dest)) {
				$result=copy($source, $__dest);
				chmod($__dest,$options['filePermission']);
			}
		} elseif(is_dir($source)) {
			if ($dest[strlen($dest)-1]=='/') {
				if ($source[strlen($source)-1]=='/') {
					//Copy only contents
				} else {
					//Change parent itself and its contents
					$dest=$dest.basename($source);
					@mkdir($dest);
					chmod($dest,$options['filePermission']);
				}
			} else {
				if ($source[strlen($source)-1]=='/') {
					//Copy parent directory with new name and all its content
					@mkdir($dest,$options['folderPermission']);
					chmod($dest,$options['filePermission']);
				} else {
					//Copy parent directory with new name and all its content
					@mkdir($dest,$options['folderPermission']);
					chmod($dest,$options['filePermission']);
				}
			}

			$dirHandle=opendir($source);
			while($file=readdir($dirHandle))
			{
				if($file!="." && $file!="..")
				{
					$__dest=$dest."/".$file;
					$__source=$source."/".$file;
					//echo "$__source ||| $__dest<br />";
					if ($__source!=$dest) {
						$result=$this->smartCopy($__source, $__dest, $options);
					}
				}
			}
			closedir($dirHandle);

		} else {
			$result=false;
		}
		return $result;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
