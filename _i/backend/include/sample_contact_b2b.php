<?php

// 懶得改Controller的名稱之一
//$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
//$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'disable_create' => true,

		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			//'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				array('name, phone, email', 'required'),
				array('email','email'),
				array('phone','numerical','integerOnly'=>true), // 預設值是允許小數點，加integerOnly=true，就變成整數
				//array('phone','numerical'),
			),
		),
		'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'create_time', // 預設要排序的欄位
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
		//	'url' => 'backend.php?r=abouteob/sort', // ajax post都會有個目標
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
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			'ml_key' => array(
				//'label' => 'ml:Language',
				'label' => '語系',
				'translate_source' => 'tw',
				'width' => '10%',
				'align' => 'center',
				//'sort' => true,
				'mls' => true,
			),
			'name' => array(
				'label' => '姓名',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Full name', // label
				//	array(), // sprintf
				//	'姓名', // default
				//),
				'width' => '20%',
				'sort' => true,
			),
			'company_name' => array(
				'label' => '公司名稱',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Company', // label
				//	array(), // sprintf
				//	'公司', // default
				//),
				'width' => '15%',
				'sort' => true,
			),
			'phone' => array(
				'label' => '電話',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Phone', // label
				//	array(), // sprintf
				//	'電話', // default
				//),
				'width' => '15%',
				'sort' => true,
			),
			//'fax' => array(
			//	//'label' => '傳真',
			//	'mlabel' => array(
			//		null, // category
			//		'Fax', // label
			//		array(), // sprintf
			//		'傳真', // default
			//	),
			//	'width' => '15%',
			//	'sort' => true,
			//),
			'email' => array(
				'label' => 'Email',
				'width' => '15%',
				'sort' => true,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
			'create_time' => array(
				'label' => '時間',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Create time', // label
				//	array(), // sprintf
				//	'日期時間', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
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
							'label' => '搜尋關鍵字',
							'translate_source' => 'tw',
							'type' => 'input',
							'attr' => array(
								'id' => 'keyword',
								'name' => 'keyword',
								'size' => '100',
							),
						),
						'checkbox_is_dirty_ip' => array(
							'label' => '濾掉疑似有問題的來源',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'checkbox_is_dirty_ip',
								'type' => 'checkbox',
								'value' => '1',
							),
						),
						'checkbox_has_dirty_keyword' => array(
							'label' => '濾掉疑似含有廣告或色情的垃圾訊息',
							'type' => 'checkbox',
							'attr' => array(
								'name' => 'checkbox_has_dirty_keyword',
								'type' => 'checkbox',
								'value' => '1',
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
						'ml_key' => array(
							'label' => '語系',
							'translate_source' => 'tw',
							'type' => 'mls',
						),
						'name' => array(
							'label' => '姓名',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Full name', // label
							//	array(), // sprintf
							//	'姓名', // default
							//),
							'type' => 'label',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								//'size' => '40',
							),
						),
						'company_name' => array(
							'label' => '公司名稱',
							'translate_source' => 'tw',
							'type' => 'label',
							'attr' => array(
								'id' => 'company_name',
								'name' => 'company_name',
								//'size' => '40',
							),
						),
						'phone' => array(
							'label' => '電話',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Phone', // label
							//	array(), // sprintf
							//	'電話', // default
							//),
							'type' => 'label',
							'attr' => array(
								'id' => 'phone',
								'name' => 'phone',
								//'size' => '40',
							),
						),
						'exten' => array(
							'label' => '分機',
							'translate_source' => 'tw',
							'type' => 'label',
							'attr' => array(
								'id' => 'exten',
								'name' => 'exten',
								//'size' => '40',
							),
						),
						'fax' => array(
							'label' => '傳真',
							'translate_source' => 'tw',
							'type' => 'label',
							'attr' => array(
								'id' => 'fax',
								'name' => 'fax',
								//'size' => '40',
							),
						),
						'addr_merge' => array(
							'label' => '縣市地區',
							'translate_source' => 'tw',
							'type' => 'label',
							'attr' => array(
								'id' => 'addr_merge',
								'name' => 'addr_merge',
								//'size' => '40',
							),
						),
						//'fax' => array(
						//	//'label' => '傳真',
						//	'mlabel' => array(
						//		null, // category
						//		'Fax', // label
						//		array(), // sprintf
						//		'傳真', // default
						//	),
						//	'type' => 'label',
						//	'attr' => array(
						//		'id' => 'fax',
						//		'name' => 'fax',
						//		//'size' => '40',
						//	),
						//),
						'email' => array(
							'label' => 'Email',
							'type' => 'label',
							'attr' => array(
								'id' => 'email',
								'name' => 'email',
								//'size' => '40',
							),
						),
				 		'detail' => array(
				 			'label' => '備註',//2021-11-29 ming說要改的
				 			'translate_source' => 'tw',
				 			//'mlabel' => array(
				 			//	null, // category
				 			//	'Description', // label
				 			//	array(), // sprintf
				 			//	'描述', // default
				 			//),
				 			'type' => 'label',
				 			'attr' => array(
				 				'id' => 'detail',
				 				'name' => 'detail',
				 			),
				 		),
						//'url' => array(
						//	'label' => '網址',
						//	'type' => 'label',
						//	'attr' => array(
						//		'id' => 'url',
						//		'name' => 'url',
						//		//'size' => '40',
						//	),
						//),
						// 2019-03-27 詢問車 改為連到 聯絡我們 ( 點擊後，會帶產品名稱 到 聯絡我們表單 )
						// 'other2' => array(
						// 	'label' => 'Product Name',
						// 	//'translate_source' => 'tw',
						// 	'type' => 'label',
						// 	'attr' => array(
						// 		'id' => 'other2',
						// 		'name' => 'other2',
						// 		//'size' => '40',
						// 	),
						// ),
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
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '2',
				// 	'field' => array(
				// 		//'newspic' => array(
				// 		//	'label' => '圖片',
				// 		//	'type' => 'fileuploader_multi',
				// 		//	'other' => array(
				// 		//		'type' => 'image',
				// 		//		'number' => '1',
				// 		//		'width' => '150',
				// 		//		'height' => '150',
				// 		//		'comment_size' => '400x400',
				// 		//		'no_ext' => '',
				// 		//	),
				// 		//	'other2' => array(
				// 		//		'topic' => array(
				// 		//			'type' => 'text',
				// 		//			'label' => '標題',
				// 		//		),
				// 		//		//'is_home' => array(
				// 		//		//	'type' => 'radio',
				// 		//		//	'label' => '首頁',
				// 		//		//	'other' => array(
				// 		//		//		array(
				// 		//		//			'label' => '顯示',
				// 		//		//			'value' => '1',
				// 		//		//		),
				// 		//		//		array(
				// 		//		//			'label' => '不顯示',
				// 		//		//			'value' => '0',
				// 		//		//		),
				// 		//		//	),
				// 		//		//),
				// 		//	),
				// 		//),
				// 		'detail' => array(
				// 			'label' => '訊息內容',
				// 			//'mlabel' => array(
				// 			//	null, // category
				// 			//	'Description', // label
				// 			//	array(), // sprintf
				// 			//	'描述', // default
				// 			//),
				// 			'type' => 'label',
				// 			'attr' => array(
				// 				'id' => 'detail',
				// 				'name' => 'detail',
				// 			),
				// 		),
				// 		//'file1' => array(
				// 		//	'label' => '附加照片',
				// 		//	'type' => 'inputn',
				// 		//	'attr' => array(
				// 		//		'id' => 'file1',
				// 		//		'name' => 'file1',
				// 		//	),
				// 		//),
				// 	),
				// ),
			),
		), // updatefield
	);

	public function actionCancel_search()
	{
		$ss = $this->data['router_class'].'_search';
		// $session = Yii::app()->session[$ss];
		// $session = array();
		// Yii::app()->session[$ss] = $session;
		unset(Yii::app()->session[$ss]);

		$this->redirect($this->createUrl($this->data['router_class'].'/index'));
	}

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';

		$this->def['listfield_attr']['smarty_include_top_text'] = '
$aaa_xxx = <<<XXX
<script type="text/javascript">
$(document).ready(function() {
	$(".t_add").remove();
	//$(".del_button").each(function(){
	//	$(this).remove();
	//});
});
</script>
XXX;
echo $aaa_xxx;
';

		$this->def['updatefield']['smarty_javascript_text'] = <<<XXX
$('.indexgo03').find('button').eq(0).remove();
$('.indexgo03').find('button').eq(0).remove();
XXX;

		// funcfieldv3 有需要就打開 4/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);


		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		//var_dump($session);die;

		// $condition = ' 1 ';
		// $condition_sortable = ' 1 ';
		//2021/1/8 by lota
		$condition = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';

		if(!isset($session)){
			$session['checkbox_is_dirty_ip'] = 1;
			$session['checkbox_has_dirty_keyword'] = 1;
		}

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		// $this->data['updatecontent']['class_id'] = -1;

		if(isset($session) and count($session) > 0){
			//2016/4/29 如果有下搜尋條件，則設定排序為sort_id
			//$this->def['default_sort_field'] = 'sort_id';//2016/6/15 捨棄，改用index_first()內的方式

			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				//if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if(preg_match('/^(id|sort_id|sort_id_browser|sort_id_home|is_news|is_top|is_home|is_enable)$/', $k)){ // 2020-01-22
					$conditions[] = $k.'='.$v;
					$conditions_sortable[] = $k.'='.$v;
				// 2018-10-18
				// http://redmine.buyersline.com.tw:4000/issues/29538?issue_count=81&issue_position=2&next_issue_id=29493&prev_issue_id=29561#note-1
				} elseif($k == 'keyword'){
					$conditions[] = ' ( name LIKE \'%'.$v.'%\' or detail LIKE \'%'.$v.'%\' ) ';
					$conditions_sortable[] = ' ( name LIKE "%'.$v.'%" or name LIKE "%'.$v.'%" ) ';
				} elseif($k == 'checkbox_is_dirty_ip'){
					$conditions[] = 'is_dirty_ip=0';
					$conditions_sortable[] = 'is_dirty_ip=0';
				} elseif($k == 'checkbox_has_dirty_keyword'){
					$conditions[] = 'has_dirty_keyword<1';
					$conditions_sortable[] = 'has_dirty_keyword<1';
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(count($conditions) > 0){
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
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			if(trim($condition_sortable) != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
		}

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

	protected function update_show_last($param='')
	{
		if($this->data['updatecontent']['gender'] == '1'){
			$this->data['updatecontent']['gender'] = '男';
		} elseif($this->data['updatecontent']['gender'] == '2'){
			$this->data['updatecontent']['gender'] = '女';
		}

		//$this->data['updatecontent']['addr'] = $this->data['updatecontent']['zipcode'].$this->data['updatecontent']['county'].$this->data['updatecontent']['district'].$this->data['updatecontent']['addr'];

		// 附加相片
		// $this->data['def']['updatefield']['sections'][1]['field']['file1']['other']['html'] = '<img width="300" src="/'.$this->data['updatecontent']['file1'].'" />';

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

		return $array;
	}

	public function actionEmailtest()
    {
		$aaa_url = aaa_url;
		$aaa_name = $this->data['sys_configs']['admin_title'];

		$subject = 'EMAIL TEST';
		$body = '此信為系統發出，請勿回覆'."\n\n";
		$body .= "\n";
		$body .= "EMAIL TEST\n";

		$body_html_content = 'EMAIL TEST';
		$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
$body_html_content
<p style="font-size:13px;color:#999">$aaa_name $aaa_url</p>
XXX;

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();

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
	}

}

// 懶得改Controller的名稱之三
// eval('class '.$filename.' extends NonameController {}');
