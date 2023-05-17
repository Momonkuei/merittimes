<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
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
		//'enable_delete' => true, // 多選刪除
		'sortable' => array(
			'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
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
			'topic' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'標題', // default
				),
				'width' => '10%',
				'sort' => true,
			),
			'other1' => array(
				'label' => '程式名稱',
				'width' => '10%',
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
				'width' => '10%',
				'sort' => true,
			),
			'position' => array(
				'label' => '顯示位置',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				'sort' => true,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
			/*
			'other3' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title3', // label
					array(), // sprintf
					'標題3', // default
				),
				'width' => '20%',
				'sort' => true,
			),
			
			'other4' => array(
				//'label' => '標題',
				'mlabel' => array(
					null, // category
					'Title3', // label
					array(), // sprintf
					'日文', // default
				),
				'width' => '20%',
				'sort' => true,
			),
			*/
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
						'topic' => array(
							'label' => '標題',
							'type' => 'input',
							'merge' => 1,
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '10',
							),
							'other' => array(
								'html_end' => '　',
							),
						),
						'other3' => array(
							'label' => '圖示',
							'type' => 'input',
							'merge' => 3,
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
								'size' => '15',
							),
							'other' => array(
								'html_end' => '&lt;i class="圖示"&gt;&lt;/i&gt;&lt;span&gt;標題&lt;/span&gt;',
							),
						),
						'other4' => array(
							'label' => 'HTML',
							'type' => 'input',
							'attr' => array(
								'id' => 'other4',
								'name' => 'other4',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '這個欄位，與上面的標題圖示欄位，二選一 (手機專用)',
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
							'attr' => array(
								'id' => 'url1',
								'name' => 'url1',
								'size' => '50',
							),
						),						
						'other1' => array(
							'label' => '程式名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '請不要隨意修改',
							),
						),
						'field_tmp' => array(
							'label' => '哪些區域顯示 (手機)',
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
								'count' => 5,
								'values' => array(),
								//'default' => 'center',
								//'html_end' => '<a href="http://redmine.buyersline.com.tw:4000/issues/18231#note-35" target="_blank">使用方式</a>',
							),							
							/*
							'other2' => array(
								'1' => '頁首',
								'2' => '頁尾',
								'3' => '手機選單',
							),
							*/
						),
						'other2' => array(
							'label' => '其它連結參數',
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '60',
							),
							// 'other' => array(
							// 	'html_end' => ' 例如 target=\'_blank\' ',
							// ),
						),
						'xx01' => array(
							'label' => '&nbsp;',						
							'type' => 'inputn',
							'other' => array(
								'html' => 
'目前支援：<br />
class=\'XX\' data-target=\'XX\' href=\'XX\'<br />
class=\'XX\' data-target=\'XX\'<br />
class=\'XX\'<br />
target=\'_blank\'<br />
',
							),
						),
						'hr01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
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
						//'is_enable' => array(
						//	//'label' => 'ml:Status',
						//	'mlabel' => array(
						//		null, // category
						//		'Status', // label
						//		array(), // sprintf
						//		'狀態', // default
						//	),
						//	'type' => 'status',
						//	'attr' => array(
						//		'id' => 'is_enable',
						//		'name' => 'is_enable',
						//	),
						//	'other' => array(
						//		'default'=>'1',
						//	),
						//),
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

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';

		// lota版
		// $this->def['condition'][0][1] = 'type=\'webmenu\'  ';
		// $this->def['sortable']['condition'] = 'type="webmenu" ';

		// 多語版
		$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

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

		return true;
	}

	protected function index_last($param='')
	{
		$groups = array(
			3 => '桌機',
			4 => '手機',
			1 => '上方',
			2 => '下方',
		);		

		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){

				$v['position'] = '';
				if($v['field_tmp'] != ''){
					$positions = array();
					$tmps = explode(',', $v['field_tmp']);
					foreach($tmps as $kk => $vv){
						if($vv != '' and isset($groups[$vv])){
							$positions[] = $groups[$vv];
						}
					}
					$v['position'] = implode(',', $positions);
				}
				$this->data['listcontent'][$k] = $v;
			}
		}
	}

	protected function getdata()
	{
		$groups = array(
			3 => array('value' => '桌機'),
			4 => array('value' => '手機 （'),
			1 => array('value' => '上方'),
			2 => array('value' => '下方 ）'),
		);		
		if($this->data['router_method'] == 'update'){
			$tmp = explode(',', $this->data['updatecontent']['field_tmp']);
			foreach($groups as $k => $v){
				if(in_array($k, $tmp)){
					//$groups[$k]['is_selected'] = 'selected'; // multiselect
					$groups[$k]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['field_tmp'] = $groups;
	}

	protected function create_show_last()
	{
		$this->getdata();

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_show_last($updatecontent)
	{
		$this->getdata();

		// funcfieldv3 有需要就打開 6/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_run_other_element($array)
	{
		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];

		if(isset($array['field_tmp']) and count($array['field_tmp']) > 0){
			$array['field_tmp'] = ','.implode(',', $array['field_tmp']).',';
		} else {
			$array['field_tmp'] = '';
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];

		if(isset($array['field_tmp']) and count($array['field_tmp']) > 0){
			$array['field_tmp'] = ','.implode(',', $array['field_tmp']).',';
		} else {
			$array['field_tmp'] = '';
		}

		return $array;
	}


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
