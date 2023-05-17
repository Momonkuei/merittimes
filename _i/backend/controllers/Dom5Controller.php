<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('topic,other1', 'required'),
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
			'detail' => array(
				'label' => '簡述',
				'width' => '30%',
				'sort' => true,
			),
			'other1' => array(
				'label' => '類型',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				'sort' => true,
			),
			'topic' => array(
				'label' => '規則',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
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
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
			'is_home' => array(
				'label' => 'Debug',
				// 'mlabel' => array(
				// 	null, // category
				// 	'Show Home', // label
				// 	array(), // sprintf
				// 	'顯示在首頁', // default
				// ),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_home',
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
				'jquery-validate', //'fileuploader',
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
					'section_title' => '基本欄位',
					'type' => '1',
					'field' => array(
						'other1' => array(
							'label' => '類型',
							'type' => 'select3',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other1',
								'name' => 'other1',
							),
							'other' => array(
								'values' => array(
									'' => '請選擇',
									'l' => '無限層 (L)',
									'd' => '單筆 (D)',
									't' => '多國語系 (T)',
									'n' => '什麼都沒有 (N)',
								),
								'default' => '',
							),
						),
						'topic' => array(
							'label' => '規則',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '一般範例：find(\'*[class=navMenu]\', 0)<br />
單層單行範例：find(\'*[class=mobileMenu]\', 0)->find(\'li\',1)
',
							),
						),
						'is_home' => array(
							'label' => 'Debug',
							'type' => 'status2',
							'attr' => array(
								'id' => 'is_home',
								'name' => 'is_home',
							),
							'other' => array(
								'default'=>'0',
								'values' => array(
									'0' => '無',
									'1' => '啟用Debug',
								),
								'html_start' => '<div class="radio-list">',
								'html_end' => '</div>',
							),
						),
						'detail' => array(
							'label' => '簡述',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								//'rows' => '4',
								//'cols' => '40',
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
								'html_start' => '<div class="radio-list">',
								'html_end' => '</div>',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'section_title' => '無限層',
					'type' => '1',
					'field' => array(
						'other2' => array(
							'label' => '單層單行',
							'type' => 'select3',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other2',
								'name' => 'other2',
							),
							'other' => array(
								'values' => array(
									'0' => '略過',
									'1' => '我是',
								),
								'default' => '',
							),
						),
						'other3' => array(
							'label' => '資料流',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other3',
								'name' => 'other3',
								'size' => '40',
							),
						),
						'other4' => array(
							'label' => '參數',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other4',
								'name' => 'other4',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '( json )',
							),
						),
						'other16' => array(
							'label' => '資料流編號',
							'type' => 'select3',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other16',
								'name' => 'other16',
							),
							'other' => array(
								'values' => array(
									'' => '請選擇',
								),
								'default' => '',
							),
						),
						'other5' => array(
							'label' => 'Debug First',
							'type' => 'status2',
							'attr' => array(
								'id' => 'other5',
								'name' => 'other5',
							),
							'other' => array(
								'default'=>'0',
								'values' => array(
									'0' => '無',
									'1' => '啟用Debug First',
								),
								'html_start' => '<div class="radio-list">',
								'html_end' => '</div>',
							),
						),
						// 'other6' => array(
						// 	'label' => 'struct_0',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'class' => 'form-control',
						// 		'id' => 'other6',
						// 		'name' => 'other6',
						// 		'size' => '40',
						// 	),
						// 	'other' => array(
						// 		'html_end' => '通常是&lt;li&gt;xxx&lt;/li&gt;',
						// 	),
						// ),
				 		'other6' => array(
							'label' => '項目(規則1)',
							'type' => 'textarea',
				 			'attr' => array(
				 				'class' => 'form-control', // 這…手動加上去好了
				 				'id' => 'other6',
				 				'name' => 'other6',
				 				'rows' => '4',
				 				'cols' => '100',
				 			),
							'other' => array(
								'html_end' => '規則特色：效能比dom3還快<br />
通常是&lt;li&gt;xxx&lt;/li&gt;<br />
',
							),
				 		),
				 		'other15' => array(
							'label' => '項目(規則2)',
							'type' => 'textarea',
				 			'attr' => array(
				 				'class' => 'form-control', // 這…手動加上去好了
				 				'id' => 'other15',
				 				'name' => 'other15',
				 				'rows' => '4',
				 				'cols' => '100',
				 			),
							'other' => array(
								'html_end' => '規則特色：不用接觸HTML<br />
規則說明：<br />
　第一行：第一筆的規則(如果不是單層單行的情況下，如果是，那就維持空白)<br />
　第1行的第3個位置，而資料流欄位名稱是name，填入方式為取代<br />
　　(1:左, 2:右，3:取代，4:插入在屬性值左，5:插入在屬性值右)<br />
　例 1-3|{/name/}|3<br />
　第3到5行的內容為{/child/}<br />
　例 3~5|{/child/}|<br />
',
							),
				 		),
						'other7' => array(
							'label' => '無限層結點的開頭',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other7',
								'name' => 'other7',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '通常是&lt;ul&gt;',
							),
						),
						'other8' => array(
							'label' => '無限層結點的結尾',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other8',
								'name' => 'other8',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '通常是&lt;/ul&gt;',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'section_title' => '單筆',
					'type' => '1',
					'field' => array(
						'other9' => array(
							'label' => '資料流',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other9',
								'name' => 'other9',
								'size' => '40',
							),
						),
						'other10' => array(
							'label' => 'struct tag',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other10',
								'name' => 'other10',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '例：h4',
							),
						),
						'other11' => array(
							'label' => 'struct',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other11',
								'name' => 'other11',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '例：&lt;h4&gt;{*topic*}&lt;/h4&gt;',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'section_title' => '多國語系',
					'type' => '1',
					'field' => array(
						'other12' => array(
							'label' => '哪些屬性要翻譯',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other12',
								'name' => 'other12',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '逗點分隔，例如innertext,title,alt',
							),
						),
						'other13' => array(
							'label' => '那個文字是什麼語系',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other13',
								'name' => 'other13',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '例：tw',
							),
						),
						'other14' => array(
							'label' => '輸出前要執行什麼函式',
							'type' => 'input',
							'attr' => array(
								'class' => 'form-control',
								'id' => 'other14',
								'name' => 'other14',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '逗點分隔，例如strtolower、strtoupper、ucfirst、trim',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'section_title' => '什麼都沒有',
					'type' => '1',
					'field' => array(
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

		$this->data['maps'] = array(
			'l' => 1,
			'd' => 2,
			't' => 3,
			'n' => 4,
		);

		if($this->data['router_method'] == 'create'){
			foreach($this->data['maps'] as $k => $v){
				unset($this->def['updatefield']['sections'][$v]);
			}
		}

		// funcfieldv3 有需要就打開 4/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\'  ';
		$this->def['sortable']['condition'] = 'type="'.$this->data['router_class'];
		// $this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		// $this->def['sortable']['condition'] = 'type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

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
		//var_dump($this->data['listcontent']);
		$tmps = $this->data['def']['updatefield']['sections'][0]['field']['other1']['other']['values'];
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				$v['other1'] = $tmps[$v['other1']];
				$this->data['listcontent'][$k] = $v;
			}
		}
	}

	protected function create_show_last()
	{
		// 為了支援section_title
		$this->data['main_content'] = 'metronic_154/update';

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_show_last($updatecontent)
	{
		foreach($this->data['maps'] as $k => $v){
			if($k != $updatecontent['other1']){
				unset($this->data['def']['updatefield']['sections'][$v]);
			}
		}

		// 為了支援section_title
		$this->data['main_content'] = 'metronic_154/update';

		// funcfieldv3 有需要就打開 6/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 因為funcfieldv3，我這邊只用到調整列表頁的欄位寬度，所以內頁的部份我把它取消掉
		unset($this->data['def']['updatefield']['sections'][6]);

		$rows = $this->cidb->where('is_enable',1)->where('type','datasource')->order_by('sort_id','asc')->get('html')->result_array();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$this->data['def']['updatefield']['sections'][1]['field']['other16']['other']['values'][$v['id']] = $v['topic'].' - '.$v['video_1'];
			}
		}
	}

	protected function update_run_other_element($array)
	{
		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// $array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		// $array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
