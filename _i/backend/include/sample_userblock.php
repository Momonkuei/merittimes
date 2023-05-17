<?php

// 懶得改Controller的名稱之一
// $tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
// $filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		//'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

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
			// 'xx_01' => array(
			// 	'label' => '',
			// 	'width' => '7%',
			// 	'align' => 'center',
			// 	'ezdelete' => true,
			// ),
			// 'xx_id' => array(
			// 	'label' => 'Number ID',
			// 	'translate_source' => 'en',
			// 	'width' => '9%',
			// 	'align' => 'center',
			// 	//'ezdelete' => true,
			// ),
			'xx_01' => array(
				'label' => '區塊小圖',
				'width' => '15%',
				'align' => 'center',
			),
			//'pic1' => array(
			//	'label' => '圖片',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => false,
			//	'kcfinder_small_img' => true,
			//),
			'topic' => array(
				'label' => '區塊',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '25%',
				'sort' => true,
			),
			//'detail_top' => array(
			//	'label' => '資料流',
			//	'width' => '15%',
			//	//'sort' => true,
			//),
			'other20' => array(
				'label' => '多筆',
				'width' => '10%',
				'align' => 'center',
				'url_id' => 'node',
				'url_id_field' => 'other20',
				'url_id_node_child' => 'userblockv4indexcontent',
				'url_id_node_child_field' => 'class_id',
			),
			// translate_source:,
			'is_home' => array(
				'label' => '滿版',
				'width' =>  '10%',
				'align' => 'center',
				'ezfield' => 'is_home',
				'ezother' => '&nbsp;',
			),
			'is_enable' => array(
				//'label' => 'ml:Status',
				'label' => '狀態',
				'translate_source' => 'tw',
				'width' => '10%',
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
			'sort_id' => array(
				//'label' => 'ml:Sort id',
				'label' => '排序',
				'translate_source' => 'tw',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
		), // listfield
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader','jquery.datepicker',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			'smarty_javascript' => '', // product/update_javascript.htm
			'smarty_javascript_text' => "
//$('#topic').change(function(){
//	$('#preview').html('<img src=\"/images_v4/'+$(this).val()+'.png\" />');
//});
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
						// 'topic' => array(
						// 	'label' => '標題',
						// 	'translate_source' => 'tw',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'topic',
						// 		'name' => 'topic',
						// 		'size' => '40',
						// 	),
						// ),
						'topic' => array(
							'label' => '選擇區塊',
							'type' => 'select3',
							//'type' => 'select5',
							//'type' => 'multiselect',
							//'type' => 'multi-select-category-select', // 2020-04-30
							//'type' => 'multi-select',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
							),
							'other' => array(
								'values' => array(
									'' => '請選擇',

									// // 2021-09-07 lota
									// 'v4/userblock/01' => '一個區塊',
									// 'v4/userblock/02' => '兩個區塊',
									// 'v4/userblock/03' => '三個區塊',
									// 'v4/userblock/04' => '四個區塊',

									// // 2021-09-07 lota
									// 'v4/userblock/11' => '滿版區塊',
									// 'v4/userblock/12' => '兩個區塊-滿版',
									// 'v4/userblock/13' => '三個區塊-滿版',
									// 'v4/userblock/14' => '四個區塊-滿版',

									//'%模組編排-1-1' => '測試',

									// 'v4/userblock/nothing' => '自由',
									// 'v4/userblock/head_start' => '&lt;head&gt;標籤的下面',
									// 'v4/userblock/head_end' => '&lt;/head&gt;標籤的上面',
									// 'v4/userblock/body_start' => '&lt;body&gt;標籤的下面',
									// 'v4/userblock/body_end' => '&lt;/body&gt;標籤的上面',

									//'v4/userblock/1-1' => '1-1',
									//'v4/userblock/1-2' => '1-2',
									//'v4/userblock/1-3' => '1-3',
									//'v4/userblock/1-4' => '1-4',
									//'v4/userblock/1-5' => '1-5',
									//'v4/userblock/1-6' => '1-6 (滿版)',
									//'v4/userblock/1-7' => '1-7',
									//'v4/userblock/1-8' => '1-8',
									//'v4/userblock/1-9' => '1-9 (滿版)',
									//'v4/userblock/1-10' => '1-10 (滿版)',
									//'v4/userblock/1-11' => '1-11 (滿版)',
									//'v4/userblock/1-12' => '1-12 (滿版)',
									//'v4/userblock/1-13' => '1-13',
									//'v4/userblock/1-14' => '1-14 (滿版)',
									//'v4/userblock/1-15' => '1-15 (多筆)',
									//'v4/userblock/1-16' => '1-16',
									//'v4/userblock/1-17' => '1-17',
									//'v4/userblock/1-18' => '1-18 (滿版)',
									//'v4/userblock/1-19' => '1-19 (滿版)',
								),
								'default' => '',
							),
						),
						//'xx_01' => array(
						//	'label' => '區塊小圖',
						//	'type' => 'inputn',
						//	'other' => array(
						//		'html' => '<span id="preview"></span>',
						//	),
						//),
						'detail_top' => array(
							'label' => '資料',
							'type' => 'select3',
							//'type' => 'select5',
							//'type' => 'multiselect',
							//'type' => 'multi-select-category-select', // 2020-04-30
							//'type' => 'multi-select',
							'attr' => array(
								'id' => 'detail_top',
								'name' => 'detail_top',
							),
							'other' => array(
								'values' => array(
									'' => '單筆',
									'multi:1' => '多筆',
									//'cidb_0:,cidb_1:rows,cidb_2:html,cidb_3:news,cidb_4:0' => '最新消息(多筆) 範本',
								),
								'default' => '',
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
					),
				),
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						// 這裡保持空白
					),
				),
				// section
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '1',
				//	'field' => array(
				//		'iframe01' => array(
				//			'label' => '欄位',
				//			'type' => 'iframe',
				//			'attr' => array(
				//				'id' => 'iframe01',
				//				'width' => '100%',
				//				'height' => '400px',
				//				'src' => 'backend.php?r=layoutv3field&id=',
				//				//'src' => 'index_tw.php?__print_table__=1',
				//			),
				//			//'other' => array(
				//			//	'html_start' => '<a id="funcfieldv3_sort"></a>',
				//			//),
				//		),
				//	),
				//),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type','layoutv3view')->order_by('sort_id')->get('html')->result_array();
		if($rows){
			foreach($rows as $k => $v){
				$this->def['updatefield']['sections'][0]['field']['topic']['other']['values']['%'.$v['topic']] = $v['topic'];
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

		// 2017-04-28 乖哥說，不同的比例，圖片的最小預設值是不一樣的
		// if(file_exists('backend/include/image_size_comment.php')){
		// 	include 'backend/include/image_size_comment.php';
		// }

		// param={value 索引值}__{parent router_class}__{child router_class}__{child field_name}
		$ss = $this->data['router_class'].'_node';
		$session_node = Yii::app()->session[$ss];
		$rowg2 = $this->db->createCommand()->from('html')->where('type =:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if(isset($rowg2['other25']) and $rowg2['other25'] != ''){
			if(isset($session_node['value']) and $session_node['value'] > 0){
				$session[$session_node['field']] = $session_node['value'];
			}
		}

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

		// 2020-08-19
		// 供新增的時候使用，新增的資料要在第一筆
		$this->data['origin_condition'] = array();
		if(trim($condition) != ''){
			$this->data['origin_condition'][0] = array(
				'where',
				$condition,
			);
		}

		if(trim($condition) != ''){
			$this->def['condition'][0] = array(
				'where',
				$condition,
			);
		}
		if(trim($condition_sortable) != ''){
			$this->def['sortable']['condition'] = $condition_sortable;
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

		return true;
	}

	protected function index_last($param='')
	{

		$topic_tmp = $this->def['updatefield']['sections'][0]['field']['topic']['other']['values'];

		$detail_top_tmp = $this->def['updatefield']['sections'][0]['field']['detail_top']['other']['values'];

		$rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type','layoutv3view')->order_by('sort_id')->get('html')->result_array();
		$rows_tmp = array();
		if($rows){
			foreach($rows as $k => $v){
				$rows_tmp[$v['topic']] = $v;
			}
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
				
				if(isset($v['pic1']) and $v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}

				// 區塊小圖
				if(isset($rows_tmp[str_replace('%','',$v['topic'])])){
					$v['xx_01'] = '<img style="width:60px" src="/_i/assets/upload/layoutv3view/'.$rows_tmp[str_replace('%','',$v['topic'])]['pic1'].'" />';
				}

				if(isset($topic_tmp[$v['topic']])){
					$v['topic'] = $topic_tmp[$v['topic']];
				}


				// if(preg_match('/^cidb_0:,cidb_1:row,cidb_2:html,cidb_3:'.$this->data['router_class'].',cidb_4:(\d+),cidb_5:0,fieldhole_0:,fieldhole_1:2$/',$v['detail_top'])){
				// 	$v['detail_top'] = '本地(單筆)';
				// }

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

				if(isset($detail_top_tmp[$v['detail_top']]) and $detail_top_tmp[$v['detail_top']] == '多筆'){
					// do nothing
				} else {
					$v['other20_url_id_label_name'] = '';
				}

				$this->data['listcontent'][$k] = $v;
			}
		}

		// $this->data['main_content'] = 'default/index';
	}

	// 為了dbc的關係，所以才把程式碼寫在這裡
	protected function update_show_first($params)
	{
		//$this->data['def']['updatefield']['sections'][2]['field']['iframe01']['attr']['src'] .= 999999+$this->data['id'];
 
		$updatecontent = $this->db->createCommand()->from($this->data['def']['table'])->where($this->data['def']['func_field']['id'].'=:id', array(':id'=>$this->data['id']))->queryRow();
		if($updatecontent['topic'] != ''){
			if(preg_match('/^v4\/userblock\/(nothing|head_start|head_end|body_start|body_end)$/',$updatecontent['topic'])){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'detail' => array(
						'label' => 'HTML',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
				);
			} elseif(preg_match('/^\%(.*)$/',$updatecontent['topic'],$matches)){
				$aaa = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type','layoutv3view')->where('topic',$matches[1])->get('html')->row_array();
				if($aaa and trim($aaa['detail']) != '' and $updatecontent['detail_top'] != 'multi:1'){
					@eval($aaa['detail']);
				}
			} elseif(preg_match('/^v4\/userblock\/(1-1|1-2)$/',$updatecontent['topic'])){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖片：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '900',
							'height' => '680',
							'comment_size' => '900x680',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'detail' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
				);
			} elseif(preg_match('/^v4\/userblock\/(1-3|1-4)$/',$updatecontent['topic'])){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖片：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '690',
							'height' => '520',
							'comment_size' => '690x520',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'detail' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
				);
			} elseif($updatecontent['topic'] == 'v4/userblock/1-5'){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'other3' => array(
						'label' => '內文標題',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other3',
							'name' => 'other3',
							'size' => '40',
						),
					),
					'detail' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
				);
			} elseif($updatecontent['topic'] == 'v4/userblock/1-6'){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'other3' => array(
						'label' => '內文標題',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other3',
							'name' => 'other3',
							'size' => '40',
						),
					),
					'detail' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
					'pic1' => array(
						'label' => '背景圖',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '3891',
							'height' => '2553',
							'comment_size' => '3891x2553',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
				);
			} elseif(preg_match('/^v4\/userblock\/(1-7|1-8)$/',$updatecontent['topic'])){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖片：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '705',
							'height' => '420',
							'comment_size' => '705x420',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'detail' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
				);
			} elseif(preg_match('/^v4\/userblock\/(1-9|1-10|1-11|1-12)$/',$updatecontent['topic'])){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖片：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '960',
							'height' => '420',
							'comment_size' => '960x420',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'detail' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
				);
			} elseif($updatecontent['topic'] == 'v4/userblock/1-13'){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖1：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '690',
							'height' => '520',
							'comment_size' => '690x520',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'other3' => array(
						'label' => '標題1',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other3',
							'name' => 'other3',
							'size' => '40',
						),
					),
					'other4' => array(
						'label' => '內容1',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other4',
							'name' => 'other4',
							'size' => '40',
						),
					),
					'pic2' => array(
						'label' => '圖2：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '2',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '690',
							'height' => '520',
							'comment_size' => '690x520',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'other5' => array(
						'label' => '標題2',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other5',
							'name' => 'other5',
							'size' => '40',
						),
					),
					'other6' => array(
						'label' => '內容2',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other6',
							'name' => 'other6',
							'size' => '40',
						),
					),
				);
			} elseif($updatecontent['topic'] == 'v4/userblock/1-14'){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖1：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '956',
							'height' => '300',
							'comment_size' => '956x300',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'pic2' => array(
						'label' => '圖2：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '2',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '956',
							'height' => '300',
							'comment_size' => '956x300',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
				);
			} elseif($updatecontent['topic'] == 'v4/userblock/1-15'){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
				);
			} elseif(preg_match('/^v4\/userblock\/(1-16|1-17)$/',$updatecontent['topic'])){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖片：',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '600',
							'height' => '849',
							'comment_size' => '600x849',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'detail' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'textarea',
						//'type' => 'ckeditor_js',
						'attr' => array(
							'class' => 'form-control', // 這…手動加上去好了
							'id' => 'detail',
							'name' => 'detail',
							'rows' => '4',
							'cols' => '40',
						),
					),
				);
			} elseif($updatecontent['topic'] == 'v4/userblock/1-18'){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '左邊大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '左邊小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '左圖',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '690',
							'height' => '520',
							'comment_size' => '690x520',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'other3' => array(
						'label' => '小區塊標題',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other3',
							'name' => 'other3',
							'size' => '40',
						),
					),
					'other4' => array(
						'label' => '內容',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other4',
							'name' => 'other4',
							'size' => '40',
						),
					),
					'other5' => array(
						'label' => '右邊大標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other5',
							'name' => 'other5',
							'size' => '40',
						),
					),
					'other6' => array(
						'label' => '右邊小標',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other6',
							'name' => 'other6',
							'size' => '40',
						),
					),
					'pic2' => array(
						'label' => '右圖',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '2',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '690',
							'height' => '520',
							'comment_size' => '690x520',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
				);
			} elseif($updatecontent['topic'] == 'v4/userblock/1-19'){
				$this->data['def']['updatefield']['sections'][1]['field'] = array(
					'other1' => array(
						'label' => '大標1',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other1',
							'name' => 'other1',
							'size' => '40',
						),
					),
					'other2' => array(
						'label' => '小標1',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other2',
							'name' => 'other2',
							'size' => '40',
						),
					),
					'other3' => array(
						'label' => '內文標1',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other3',
							'name' => 'other3',
							'size' => '40',
						),
					),
					'other4' => array(
						'label' => '內容1',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other4',
							'name' => 'other4',
							'size' => '40',
						),
					),
					'pic1' => array(
						'label' => '圖1',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '1',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '960',
							'height' => '420',
							'comment_size' => '960x420',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
					'other5' => array(
						'label' => '大標2',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other5',
							'name' => 'other5',
							'size' => '40',
						),
					),
					'other6' => array(
						'label' => '小標2',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other6',
							'name' => 'other6',
							'size' => '40',
						),
					),
					'other7' => array(
						'label' => '內文題2',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other7',
							'name' => 'other7',
							'size' => '40',
						),
					),
					'other8' => array(
						'label' => '內容2',
						'translate_source' => 'tw',
						'type' => 'input',
						'attr' => array(
							'id' => 'other8',
							'name' => 'other8',
							'size' => '40',
						),
					),
					'pic2' => array(
						'label' => '圖2',
						'translate_source' => 'tw',
						'type' => 'fileuploader',
						'other' => array(
							'number' => '2',
							'type' => 'photo',
							'top_button' => '1',
							'width' => '960',
							'height' => '420',
							'comment_size' => '960x420',
							'no_ext' => '',
							'no_need_delete_button' => '',
							'html_end' => '',
						),
					),
				);
			}
		}
	}

	protected function create_show_last()
	{
		unset($this->data['def']['updatefield']['sections'][0]['field']['detail_top']);
		unset($this->data['def']['updatefield']['sections'][2]['field']['iframe01']);
	}

	protected function update_show_last($param='')
	{
		//if(!preg_match('/^v4\/userblock\/(nothing|head_start|head_end|body_start|body_end)$/',$this->data['updatecontent']['topic'])){
		//	$this->data['def']['updatefield']['sections'][0]['field']['xx_01']['other']['html'] = '<span id="preview"><img src="/images_v4/'.$this->data['updatecontent']['topic'].'" /></span>';
		//}
	}

	protected function update_run_other_element($array)
	{
		//if(!preg_match('/router_method/',$array['detail_top'])){
		//	if($array['detail_top'] != ''){
		//		$array['detail_top'] .= ',';
		//	}
		//	$array['detail_top'] .= 'router_method:'.$this->data['router_class'];
		//}

		if($array['detail_top'] == ''){ // 本地
			$array['detail_top'] = 'cidb_0:,cidb_1:row,cidb_2:html,cidb_3:'.$this->data['router_class'].',cidb_4:'.$this->data['id'].',cidb_5:0,fieldhole_0:,fieldhole_1:2';
		}

		// 區塊那邊，才可以找回得到原本的地方
		// 這裡已經改寫到layoutv3/page_variable.php裡面
		// if(!preg_match('/router_method/',$array['detail_top'])){
		// 	$array['detail_top'] .= ',id:'.$this->data['id'].',router_method:'.$this->data['router_class'];
		// }

		//Ming 2018-12-18 來信 指示 資料更新後，點擊送出後需返回列表頁 ( 所有單元都是 ),設定非資訊部人員才會動作 by lota
		if(!preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
			$array['update_base64_url'] = '';
		} 

		// 檢查是否有選其它的區塊，有的話，最後要把欄位清掉，這樣才會讓前台重新抓欄位進來
		$row = $this->cidb->where('type',$this->data['router_class'])->where('id',$this->data['id'])->get('html')->row_array();
		if($row and $array['topic'] != $row['topic']){
			$this->cidb->where('class_id',999999+$row['id'])->delete('layoutv3field');
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		//if(!preg_match('/router_method/',$array['detail_top'])){
		//	if($array['detail_top'] != ''){
		//		$array['detail_top'] .= ',';
		//	}
		//	$array['detail_top'] .= 'router_method:'.$this->data['router_class'];
		//}

		// 2018-09-03 只有是通用資料表的時候，才會加上型態
		// 不過就算獨立資料表也加了，那也沒差，因為ORM會看
		if($this->data['def']['table'] == 'html'){
			$array['type'] = $this->data['router_class'];
		}

		return $array;
	}

}

// 懶得改Controller的名稱之三
// eval('class '.$filename.' extends NonameController {}');
