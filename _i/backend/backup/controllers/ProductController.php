<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				array('name', 'required'),
				array('name,class_id', 'required'),
				// array('price','numerical','integerOnly'=>true), // 預設值是允許小數點，加integerOnly=true，就變成整數
				// array('class_id', 'required'),//或是用這種
				// array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'sort_id', // 預設要排序的欄位 2016/04/29 改為預設為id 如有搜尋分類,則動態改為sort_id 2016/6/15 因點選分類後會無法排序，再度改回sort_id
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
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
			'pic1' => array(
				'label' => '圖片',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Image', // label
				//	array(), // sprintf
				//	'代表圖', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'xx2' => array(
				'label' => '分類',			
				'translate_source' => 'tw',
				'width' => '8%',
				'sort' => true,
			),
			'name' => array(
				'label' => '名稱',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '50%',
				'sort' => true,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
			//'price' => array(
			//	'label' => '價格',
			//	//'mlabel' => array(
			//	//	null, // category
			//	//	'Title', // label
			//	//	array(), // sprintf
			//	//	'標題', // default
			//	//),
			//	'width' => '12%',
			//	'sort' => true,
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
				'width' => '10%',
				'align' => 'center',
				'ezshow' => true,
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
						'class_id' => array(
							'label' => '分類',
							'translate_source' => 'tw',
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
					'type' => '1',
					'field' => array(
						'name' => array(
							'label' => '名稱',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								'size' => '40',
							),
						),
						'class_id' => array(
							'label' => '分類',
							'translate_source' => 'tw',
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
						'pic1' => array(
							'label' => '代表圖：',
							'translate_source' => 'tw',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '1000',
								'height' => '652',
								'comment_size' => '',
								'no_ext' => '',
								'no_need_delete_button' => '',
								'html_end' => '', // 這裡會跟進scss產品列表圖比例(proImgSizeType)而變化
							),
						),
						// 'related_ids' => array(
						// 	'label' => '選擇相關產品',
						// 	//'type' => 'select3',
						// 	//'type' => 'select5',
						// 	//'type' => 'multiselect',
						// 	'type' => 'multi-select',
						// 	'attr' => array(
						// 		'id' => 'related_ids',
						// 		'name' => 'related_ids[]',

						// 		//'class' => 'form-control input-large select2me',
						// 		//'class' => 'multi-select',
						// 		//'data-placeholder' => "請選擇或搜尋",
						// 		//'multiple' => 'multiple',
						// 		//'size' => 10,
						// 	),
						// 	// 'other' => array(
						// 	// 	'values' => array(
						// 	// 		'' => '請選擇',
						// 	// 		'member' => '會員',
						// 	// 		'search' => '搜尋',
						// 	// 		'share' => '分享',
						// 	// 		'shop' => '購物',
						// 	// 		'language' => '語系',
						// 	// 	),
						// 	// 	'default' => '',
						// 	// ),
						// ),
						//'price' => array(
						//	'label' => '價格',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'price',
						//		'name' => 'price',
						//		'size' => '10',
						//	),
						//	'other' => array(
						//		'html_end' => '元',
						//		'number_only' => true,
						//	),
						//),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'label' => '排序',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Sort', // label
							//	array(), // sprintf
							//	'排序', // default
							//),
							'type' => 'sort',
							'attr' => array(
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'label' => '狀態',
							'translate_source' => 'tw',
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
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						// 2016-11-16 小李說要用textarea
						// 2017-11-13 這裡除了產品列表會顯示簡述以外，還有洽詢車
						'detail' => array(
							'label' => '簡述',
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
						'field_data' => array(
							'label' => '說明',
							'translate_source' => 'tw',
							'type' => 'ckeditor_js',
							'attr' => array(
								'id' => 'field_data',
								'name' => 'field_data',
							),
						),
						'field_tmp' => array(
							'label' => '規格',
							'translate_source' => 'tw',
							'type' => 'ckeditor_js',
							'attr' => array(
								'id' => 'field_tmp',
								'name' => 'field_tmp',
							),
						),
						'kc01' => array(
							'label' => '多張圖片<br />',
							//'translate_source' => 'tw',
							'type' => 'kcfinder_school',
							'attr' => array(
								'width' => '700',
								'height' => '400',
							),
							'other' => array(
								'html_start' => '<br />',
								'uploadurl_id' => 'assetsdir',
								'type' => 'member',
								//'width' => '400',
								'height' => '170',
								'school_id' => '',
								//'dir' => 'files/public',
							),
						),
						'kcgg' => array(
							'label' => '',
							'type' => 'kcfinder_resize',
							'other' => array(
								'big' => '800',
								'small' => '400',
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
							'label' => '產品名稱',
							'translate_source' => 'tw',
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'name',
							//	'name' => 'name',
							//	'size' => '40',
							//),
						),
						'class_id' => array(
							'label' => '分類',
							'translate_source' => 'tw',
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

		$product_table = $this->data['router_class'];
		//$product_table = str_replace('homesort', '', $product_table); // 為了支援產品的首頁排序

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $product_table;
		$this->def['empty_orm_data']['table'] = $product_table;
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$product_table.'/sort';
		}

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
		if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
			if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類，單層

				$type_name = $this->data['router_class'].'type';
				if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
					$type_name = $rowg['other22'];
				}

				$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$type_name,':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
						$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
					}
				}
			} else { // 是獨立分類
				// 分類
				$producttype_table = $this->data['router_class'];
				//$producttype_table = str_replace('homesort', '', $producttype_table); // 為了支援產品的首頁排序(這是homesort的另一支後台功能在用的，註解不要打開)
				$producttype_table .= 'type';

				if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
					$producttype_table = $rowg['other22'];
				}

				// 先處理最頂層，然後裡面的程序，才處理其它層
				$rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						if(isset($rowg['other18']) and $rowg['other18'] == 1){
							// 大分類可選
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
						} elseif(isset($rowg['other18']) and $rowg['other18'] == 2){
							// 大分類不可選
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
						}

						// 剩餘子層的處理程序
						$data_1 = $this->layout_show($v['id'],1,'　',$this->data['router_class'].'type');//'　└'	
						$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
						$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;
					}
				}
			}
		} else { // 無分類
			unset($this->def['searchfield']);
			unset($this->def['updatefield']['sections'][0]['field']['class_id']);
			unset($this->def['listfield']['xx2']);
			unset($this->def['empty_orm_data']['rules'][1]);//2018/1/24  無分類的話要移除class_id的檢查 by lota
		}

		// funcfieldv3 有需要就打開 4/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 2017-04-28 乖哥說，不同的比例，圖片的最小預設值是不一樣的
		if(file_exists('backend/include/image_size_comment.php')){
			include 'backend/include/image_size_comment.php';
		}

		//    // 類型1
		//    $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'item1class1',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		//    if($rows and count($rows) > 0){
		//    	foreach($rows as $k => $v){
		//    		$this->def['updatefield']['sections'][0]['field']['other1']['other']['values'][$v['id']] = $v['topic'];
		//    		//$this->def['searchfield']['sections'][0]['field']['other1']['other']['values'][$v['id']] = $v['topic'];
		//    	}
		//    }

		//    // 類型2
		//    $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'item1class2',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		//    if($rows and count($rows) > 0){
		//    	foreach($rows as $k => $v){
		//    		$this->def['updatefield']['sections'][0]['field']['other2']['other']['values'][$v['id']] = $v['topic'];
		//    		//$this->def['searchfield']['sections'][0]['field']['other2']['other']['values'][$v['id']] = $v['topic'];
		//    	}
		//    }

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = '  ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
			//2016/4/29 如果有下搜尋條件，則設定排序為sort_id
			//$this->def['default_sort_field'] = 'sort_id';//2016/6/15 捨棄，改用index_first()內的方式

			$conditions = array();
			$conditions_sortable = array();
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
					$conditions_sortable[] = $k.'='.$v;
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
		// $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type', array(':type'=>'case',':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		$rows = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				// $this->data['related_ids'][$v['id']] = $v['topic'];
				$this->data['related_ids'][$v['id']] = $v['name'];
			}
		}

		return true;
	}

	protected function index_first($param='')
	{
		// 前台主選單的資料表功能
		$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($row and isset($row['pic2']) and $row['pic2'] == 1){ // 有分類
			// 取得商品分類的編號
			$class_id = 0;
			//if(isset($this->data['params']['value'][0])){
			//	$class_id = $this->data['params']['value'][0];
			//}
			if(isset($_SESSION[$this->data['router_class'].'_search']['class_id']) and $_SESSION[$this->data['router_class'].'_search']['class_id'] > 0){
				$class_id = $_SESSION[$this->data['router_class'].'_search']['class_id'];
			}
			$this->data['class_id'] = $class_id;

			//if(PRODUCT_ADD_LATER == true){ //2016/6/15 取消，改天再來想看看要放在哪邊
				//2016/5/16 讓尚未選擇分類搜尋也可以調整順序 (以後可能會有問題，到時再解決 2016/6/15 重新讓它作用
				if($class_id <= 0){
					unset($this->data['def']['listfield'][$this->data['def']['func_field']['sort_id']]);
				}

				// 商品分類編號要有指定，還有其它必要的條件，才能夠即時自動切換
				if($class_id > 0){
					$this->data['def']['sortable']['enable'] = true;

					//$this->data['params']['direction'] = 'desc'; //拖拉排序預設是正序，如果要反序就把這裡取消註解 by lota

					// 疑似Bug 2017-03-24
					//$this->data['def']['sortable']['condition'] = 'class_id = '.$this->data['class_id'].' ';
					//$this->data['def']['condition']['where']['class_id'] = $class_id;
				} else {
					$this->data['def']['sortable']['enable'] = false;
				}

				// 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱 2016/6/15 預設值改為id
				if($class_id <= 0 and $this->data['sort_field_nobase64'] == $this->data['def']['func_field']['sort_id']){
					$sort_field = 'id'; // $sort_field = 'topic';
					$this->data['params']['direction'] = 'desc';//2016/6/23 初始化為反序，方便客戶馬上看到新增的資料

					$this->data['sort_field'] = base64url::encode($sort_field);
					$this->data['sort_field_nobase64'] = $sort_field;
				}
			//}
		} else { // 無分類
			parent::index_first($param);
		}
	}

	protected function create_show_last($param='')
	{
		unset($this->data['def']['updatefield']['sections'][1]['field']['kc01']);

		// 相關產品
		$groups = array();
		foreach($this->data['related_ids'] as $k => $v){
			$groups[$k]['value'] = $v;
		}
		$this->data['updatecontent']['related_ids'] = $groups;

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_show_last($param='')
	{
		if(isset($this->data['def']['updatefield']['sections'][1]['field']['kc01'])){
			$this->data['def']['updatefield']['sections'][1]['field']['kc01']['other']['school_id'] = $this->data['router_class'].$this->data['updatecontent']['id'];
		}

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
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 假設性的，最多處理四張代表圖
		for($x=1;$x<=4;$x++){
			if(
				isset($this->data['updatecontent']['pic'.$x]) and $this->data['updatecontent']['pic'.$x] != '' 
				and file_exists(_BASEPATH.'/assets/upload/'.$this->data['router_class'].'/'.$this->data['updatecontent']['pic'.$x])
				// and isset($this->data['def']['updatefield']['sections'][0]['field']['iframe01'])
			){
				// $this->data['def']['updatefield']['sections'][0]['field']['iframe01']['attr']['src'] .= 'assets/upload/'.$this->data['router_class'].'/'.$this->data['updatecontent']['pic1'];

				// 無損壓縮(代表圖)
				if(0){
					$tmp = array(
						'label' => '&nbsp;',
						'type' => 'iframe',
						'attr' => array(
							'id' => 'iframe_pic_optimizer_'.$x,
							'width' => '100%',
							'height' => '0px',
							'src' => '/_i/image_optimizer.php?src=assets/upload/'.$this->data['router_class'].'/'.$this->data['updatecontent']['pic'.$x],
						),
					);
					$this->data['def']['updatefield']['sections'][0]['field']['iframe_pic_optimizer_'.$x] = $tmp;
				}

				// 製做其它縮圖，範圍預設：寬800px, 高800px
				// _i/assets/cache3/upload/{ROUTER_CLASS}/w800h800zc3_AAA.jpg
				if(0 and file_exists('backend/include/timthumb_physical_file_cache3.php')){ // 2018-06-01 lota: 在Server2會有效能問題 要記得關閉
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

				// 原始圖片無損壓縮，並且覆寫
				if(0){
					$tmp = array(
						'label' => '&nbsp;',
						'type' => 'iframe',
						'attr' => array(
							'id' => 'iframe_members_optimizer_'.$k,
							'width' => '100%',
							'height' => '0px',
							'src' => '/_i/image_optimizer.php?src='.str_replace(_BASEPATH.'/', '', $v),
						),
					);
					$this->data['def']['updatefield']['sections'][0]['field']['iframe_members_optimizer_'.$k] = $tmp;
				}

				// 製做其它縮圖，範圍預設：寬800px, 高800px
				// _i/assets/cache3/upload/{ROUTER_CLASS}/w800h800zc3_AAA.jpg
				if(file_exists('backend/include/timthumb_physical_file_cache3.php')){
					$_file = $v;
					include 'backend/include/timthumb_physical_file_cache3.php';
				}
			}
		}

		// 選擇相關產品
		$tmps = explode(',', $this->data['updatecontent']['related_ids']);
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
		$this->data['updatecontent']['related_ids'] = $groups;

	}

	protected function index_last($param='')
	{
		//var_dump($this->data['listcontent']);

		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
			if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類
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
				if($show_type_mode > 0 and $v['class_id'] > 0){

					$type_name = $this->data['router_class'].'type';
					if(isset($rowg['other22']) and $rowg['other22'] != 1 and $rowg['other22'] != ''){
						$type_name = $rowg['other22'];
					}

					if($show_type_mode == 1){
						$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id='.$v['class_id'], array(':type'=>$type_name,':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
						$v['xx2'] = $row2['topic'];
					} elseif($show_type_mode == 2){
						$row2 = $this->db->createCommand()->from($type_name)->where('is_enable=1 and ml_key=:ml_key and id='.$v['class_id'], array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
						$v['xx2'] = $row2['name'];
					}
					
				}

				// 商品複製
				// 2017-07-20 李哥說，要加上授權，就是99999開頭的都要加
				if(preg_match('/^99999/', $this->data['admin_id'])){
					$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> Copy</a>';
				}

				$this->data['listcontent'][$k] = $v;
			}
		}
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
				// 有用到在寫
			} else {
				$row = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and id=:id and ml_key=:ml_key',array(':id' => $update['is_copy'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();

				$save = $row;
				unset($save['id']);
				unset($save['update_time']);

				// 單分類排序
				$row2 = $this->db->createCommand()->from($this->data['router_class'])->where('is_enable=1 and class_id=:id and ml_key=:ml_key',array(':id' => $update['class_id'],':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
				if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
					$save['class_id'] = $update['class_id'];
				}
				$save['name'] = $save['name'].' (複製)';
				//$save['sort_id'] = count($row2) + 1;
				$save[$this->def['func_field']['sort_id']] = count($row2) + 1;
				$save['create_time'] = date('Y-m-d H:i:s');
				$this->cidb->insert($this->data['router_class'], $save);
			}
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

	protected function update_run_other_element($array)
	{
		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		if(isset($array['class_ids']) and count($array['class_ids']) > 0){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// 相關產品
		if(isset($array['related_ids']) and count($array['related_ids']) > 0){
			$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		} else {
			$array['related_ids'] = '';
		}

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		if(isset($array['class_ids']) and count($array['class_ids']) > 0){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// 相關產品
		if(isset($array['related_ids']) and count($array['related_ids']) > 0){
			$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		} else {
			$array['related_ids'] = '';
		}

		return $array;
	}

	// 解無限層分類(不含頂層)
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
