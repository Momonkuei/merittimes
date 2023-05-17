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
				'sort' => false,
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
				'width' => '20%',
				'sort' => true,
			),
			'xx3' => array(
				'label' => '多圖',				
				'width' => '5%',
				'url_id' => 'productphoto',
				//'url_router_class' => 'fireproof',
			),
			
			//食材步驟註解start
			// 'xx4' => array(
			// 	'label' => '食材分組',				
			// 	'width' => '5%',
			// 	'url_id' => 'productingredientsgroup',
			// 	//'url_router_class' => 'fireproof',
			// ),
			// 'xx5' => array(
			// 	'label' => '步驟',				
			// 	'width' => '5%',
			// 	'url_id' => 'productstep',
			// 	//'url_router_class' => 'fireproof',
			// ),
			//食材步驟註解end

			// 'funcfieldv3_split_1' => array(
			// 	// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
			// 	'width' => '',
			// ),
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
									'-1' => '請選擇',
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
					'id' => 'form_data',//2021-09-07 ID 由 form_data 改用 fileupload_gg 配合多檔上傳的表單ID
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
						// 'item_name' => array(
						// 	'label' => '品號',
						// 	'translate_source' => 'tw',
						// 	//'mlabel' => array(
						// 	//	null, // category
						// 	//	'Title', // label
						// 	//	array(), // sprintf
						// 	//	'標題', // default
						// 	//),
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'item_name',
						// 		'name' => 'item_name',
						// 		'size' => '40',
						// 	),
						// ),
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
						// 五綸
						// 'class_id2' => array(
						// 	'label' => '分類',
						// 	'translate_source' => 'tw',
						// 	//'type' => 'select3',
						// 	'type' => 'select5',
						// 	//'merge' => '1', // 頭中尾的頭(1)
						// 	'attr' => array(
						// 		'id' => 'class_id2',
						// 		'name' => 'class_id2',
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
						// 	//'type' => 'multi-select-category-select', // 2020-04-30
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
						//食材步驟註解start
						// 'other6' => array(
						// 	'label' => 'Tag標籤',
						// 	'type' => 'multi-select',
						// 	'attr' => array(
						// 		'id' => 'other6',
						// 		'name' => 'other6[]',

								
						// 	),
						// ),
						//食材步驟註解end
						'field_tmp' => array(
							'label' => '規格',
							'translate_source' => 'tw',
							'type' => 'ckeditor_js',
							'attr' => array(
								'id' => 'field_tmp',
								'name' => 'field_tmp',
							),
						),
						// 'kc01' => array(
						// 	'label' => '多張圖片<br />',
						// 	//'translate_source' => 'tw',
						// 	'type' => 'jquery_file_upload',
						// 	// 'attr' => array(
						// 	// 	'width' => '700',
						// 	// 	'height' => '400',
						// 	// ),							
						// ),
						// 'kc01' => array(
						// 	'label' => '多張圖片<br />',
						// 	//'translate_source' => 'tw',
						// 	'type' => 'kcfinder_school',
						// 	'attr' => array(
						// 		'width' => '700',
						// 		'height' => '400',
						// 	),
						// 	'other' => array(
						// 		'html_start' => '<br />',
						// 		'uploadurl_id' => 'assetsdir',
						// 		'type' => 'member',
						// 		//'width' => '400',
						// 		'height' => '170',
						// 		'school_id' => '',
						// 		//'dir' => 'files/public',
						// 	),
						// ),
						// 'kcgg' => array(
						// 	'label' => '',
						// 	'type' => 'kcfinder_resize',
						// 	'other' => array(
						// 		'big' => '800',
						// 		'small' => '400',
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

		//2021-09-07 jquery_file_upload by lota
// 		$this->data['_head_script'] = '

//   <!--<link rel="stylesheet" href="backend/views/jquery-file-upload/css/components.min.css">-->
//    <link href="backend/views/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" type="text/css" />
//   <link rel="stylesheet" href="backend/views/jquery-file-upload/css/jquery.fileupload.css">
//   <link rel="stylesheet" href="backend/views/jquery-file-upload/css/jquery.fileupload-ui.css"> 


//   <script src="backend/views/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
//         <script src="backend/views/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
//         <script src="backend/views/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
//         <script src="backend/views/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
//         <script src="backend/views/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
//         <script src="backend/views/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>

//  <script src="backend/views/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
//     <script src="backend/views/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>

//     <script src="backend/views/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
//     <script src="backend/views/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
//     <script src="backend/views/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
//     <script src="backend/views/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
//     <script src="backend/views/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>

//     <script src="backend/views/jquery-file-upload/js/form-fileupload.js" type="text/javascript"></script>
//     <script>
    
//     </script>
// ';

		// 五綸
		// $rows = $this->db->createCommand()->from('product2type')->where('is_enable=1 and pid=0 and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		// if($rows and count($rows) > 0){
		// 	foreach($rows as $k => $v){
		// 		// 大分類可選
		// 		$this->def['updatefield']['sections'][0]['field']['class_id2']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
		// 		// 大分類不可選
		// 		// $this->def['updatefield']['sections'][0]['field']['class_id2']['other']['values']['xx'.$k] = $v['name'];

		// 		// 剩餘子層的處理程序
		// 		$data_1 = $this->layout_show($v['id'],1,'　',$this->data['router_class'].'2type');//'　└'	
		// 		$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;						
		// 	}
		// }

		// 前台主選單的資料表功能
		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類
			if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類，單層

				$type_name = $this->data['router_class'].'type';
				if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
					$type_name = $rowg['other22'];
				}

				$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$type_name,':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
				if($rows and !empty($rows)){
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
				if($rows and !empty($rows)){
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
		//圖文列表是否顯示 #46799 2023/01/03  
		unset($_constant);
		eval('$_constant = '.strtoupper('product_content').';'); 
		if(!$_constant){
			unset($this->def['listfield']['other1']);
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
		$condition = '  ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';


		// 2020-08-19
		// 供新增的時候使用，新增的資料要在第一筆
		$this->data['origin_condition'] = array();
		if(trim($condition) != ''){
			$this->data['origin_condition'][0] = array(
				'where',
				$condition,
			);
		}

		if(isset($session) and !empty($session)){
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
			if(!empty($conditions)){
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
			if(!empty($conditions_sortable)){
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

		// 這是SEO的欄位的範本，如果你需要，就打開它 2/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') && $_constant ){
			$seo_func = 'a';
			include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
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

		$this->data['other6'] = array();
		$rows = $this->db->createCommand()->from("html")->where('is_enable=1 and type=:type  and ml_key=:ml_key', array(':ml_key'=>$this->data['admin_switch_data_ml_key'],':type'=>'tagpage'))->order("sort_id asc")->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$this->data['other6'][$v['id']] = $v['topic'];
			}
		}
		

		return true;
	}

	protected function goUpload($id){
		if(empty($id)) return false;
		$temp = $_FILES;
		unset($_FILES);

		foreach ($temp as $key => $value) {
			$_FILES[$key]['name'] = $value['name'][0];
			$_FILES[$key]['type'] = $value['type'][0];
			$_FILES[$key]['tmp_name'] = $value['tmp_name'][0];
			$_FILES[$key]['error'] = $value['error'][0];
			$_FILES[$key]['size'] = $value['size'][0];
		}


		if( !empty($_FILES) ){
			$thumbnailUrl = "";
			foreach ($_FILES as $key => $value) {
				if( !empty($value['name']) && $value['error']=="0"  ){//檢查檔案 START

					$temp_a = $this->upload_up('',strtolower(IsNowController()),$key,1,array(),$this->html_array['contArea'][0]['form_features']['more_file']['encrypt_name']);

					if( $value['type'] == 'image/png' || $value['type'] == 'image/jpeg' ){
						$thumbnailUrl = base_url().'/assets/uploads/'.strtolower(IsNowController()).'/'.$temp_a['success_msg'];
					}else{
						$thumbnailUrl = base_url()."backend/views/jquery-file-upload/img/file.png";
					}

					if($temp_a['status'] == 'success'){
						$t = explode(".",$temp_a['success_msg']);
						$array = array(
							"pid"=>$id,
							"type"=>strtolower(IsNowController()),
							"ml_key"=>'en',
							"title"=>pathinfo($temp_a['success_msg'], PATHINFO_FILENAME),
							"file"=>$temp_a['success_msg'],
							"create_time"=>date("Y-m-d H:i:s"),
						);
						
						$s = $this->crud_model->db_insert('more_files',$array);
						if(!empty($s)){
							$quick = ' id = '.$s;
							$this->crud_model->db_update( 'more_files',array('sort_id'=>$s),$quick );
						}

						
						echo json_encode(
							array(
								"files"=>array(
									array(
										"id"=>$s,
										"thumbnailUrl"=>$thumbnailUrl,
										"size"=>$value['size'],
										"url"=>'/assets/uploads/'.strtolower(IsNowController()).'/'.$temp_a['success_msg'],
										"type"=>$value['type'],
										"name"=>$temp_a['success_msg'],
										"title"=>$t[0],
										"deleteUrl"=>base_url()."_v/NewsfileController/goDelete/".$s
									)
								)
							)
						);
	    				exit;
					}
					
				}
			}
		}
	
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

			// 2020-09-09
			// 有分類的情況，而且還有其它的條件，把只有單獨選擇分類編號的情況，給抓出來
			$only_select_class_id = false;
			if(isset($_SESSION[$this->data['router_class'].'_search']) and !empty($_SESSION[$this->data['router_class'].'_search'])){
				foreach($_SESSION[$this->data['router_class'].'_search'] as $k => $v){
					if($k == 'class_id'){
						if($v == -1){
							// 主角不能沒選
							$only_select_class_id = false;
							break;
						} else {
							$only_select_class_id = true;
						}
					} elseif($v == -1){
						// do nothing
					} elseif($v != ''){
						// 其它欄位，不能有輸入條件，當然的會略過checkbox和radio的欄位值
						$only_select_class_id = false;
						break;
					}
				}
			}

			// 2020-09-09
			// 有點選欄位排序的話…
			$has_default_orderby_condition = true;
			if($this->data['sort_field_nobase64'] != $this->def['default_sort_field']){
				$has_default_orderby_condition = false;
			}

			if($only_select_class_id === true and $has_default_orderby_condition === true){
				$this->data['def']['sortable']['enable'] = true;
			} else {
				unset($this->data['def']['listfield'][$this->def['default_sort_field']]);
				$this->data['def']['sortable']['enable'] = false;

				$this->data['params']['direction'] = 'desc';//2016/6/23 初始化為反序，方便客戶馬上看到新增的資料
				$this->data['sort_field'] = base64url::encode($this->data['def']['func_field']['id']);
				$this->data['sort_field_nobase64'] = $this->data['def']['func_field']['id'];
			}

			//if(PRODUCT_ADD_LATER == true){ //2016/6/15 取消，改天再來想看看要放在哪邊
				//2016/5/16 讓尚未選擇分類搜尋也可以調整順序 (以後可能會有問題，到時再解決 2016/6/15 重新讓它作用
				// if($class_id <= 0){
				// 	unset($this->data['def']['listfield'][$this->data['def']['func_field']['sort_id']]);
				// }

				// // 商品分類編號要有指定，還有其它必要的條件，才能夠即時自動切換
				// if($class_id > 0){
				// 	$this->data['def']['sortable']['enable'] = true;

				// 	//$this->data['params']['direction'] = 'desc'; //拖拉排序預設是正序，如果要反序就把這裡取消註解 by lota

				// 	// 疑似Bug 2017-03-24
				// 	//$this->data['def']['sortable']['condition'] = 'class_id = '.$this->data['class_id'].' ';
				// 	//$this->data['def']['condition']['where']['class_id'] = $class_id;
				// } else {
				// 	$this->data['def']['sortable']['enable'] = false;
				// }

				// // 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱 2016/6/15 預設值改為id
				// if($class_id <= 0 and $this->data['sort_field_nobase64'] == $this->data['def']['func_field']['sort_id']){
				// 	$sort_field = 'id'; // $sort_field = 'topic';
				// 	$this->data['params']['direction'] = 'desc';//2016/6/23 初始化為反序，方便客戶馬上看到新增的資料

				// 	$this->data['sort_field'] = base64url::encode($sort_field);
				// 	$this->data['sort_field_nobase64'] = $sort_field;
				// }
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

		$groups = array();
		foreach($this->data['other6'] as $k => $v){
			$groups[$k]['value'] = $v;
		}
		$this->data['updatecontent']['other6'] = $groups;

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_show_last($param='')
	{
		//讓名稱的雙引號可以正常顯示 2021-11-22 by lota
		$this->data['updatecontent']['name'] = str_replace('"','&quot;',$this->data['updatecontent']['name']);

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
		}else{
			// 20220523 發現無法儲存內容--->修改
			// 選擇相關產品
			// if(isset($this->data['updatecontent']['related_ids']) && is_array($this->data['updatecontent']['related_ids'])){
			// 	$tmps = explode(',', $this->data['updatecontent']['related_ids']);
			// 	$groups = array();
			// 	if($this->data['related_ids']){
			// 		foreach($this->data['related_ids'] as $k => $v){
			// 			if($k == $this->data['updatecontent']['id']) continue; // 排除掉自己，不然選到自己跟本就是很奇怪
			// 			$groups[$k]['value'] = $v;
			// 			if(in_array($k, $tmps)){
			// 				$groups[$k]['is_selected'] = 'selected'; // multiselect
			// 				//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
			// 			}
			// 		}
			// 	}
			// 	$this->data['updatecontent']['related_ids'] = $groups;
			// }		
			$tmps = explode(',', $this->data['updatecontent']['related_ids']);
			// $tmps = $this->data['updatecontent']['related_ids'];
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
		}

		// funcfieldv3 有需要就打開 6/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		$tmps = explode(',', $this->data['updatecontent']['other6']);
		$groups = array();
		if($this->data['other6']){
			foreach($this->data['other6'] as $k => $v){
				if($k == $this->data['updatecontent']['id']) continue; // 排除掉自己，不然選到自己跟本就是很奇怪
				$groups[$k]['value'] = $v;
				if(in_array($k, $tmps)){
					$groups[$k]['is_selected'] = 'selected'; // multiselect
					//$groups[$v['id']]['is_checked'] = 'checked'; // multicheckbox
				}
			}
		}
		$this->data['updatecontent']['other6'] = $groups;

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
		$path_tmp = _BASEPATH.'/assets/members/'.$this->data['router_class'].'_1_'.$this->data['updatecontent']['id'].'/member';
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
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				// if($v['pic1'] != ''){
				if(!empty($v['pic1'])){
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

				// 商品複製
				// 2017-07-20 李哥說，要加上授權，就是99999開頭的都要加
				if(preg_match('/^99999/', $this->data['admin_id'])){
					$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> '.G::_('Copy', 'en').'</a>';
				}

				//Ming 2018-12-18 來信 指示 列表的標題文字，點擊後可另開視窗顯示前台畫面  ( 所有單元都是 ) 
				$_href = '/'.$this->data['router_class'].'detail_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['id'];	
				$v['name'] = '<a href="'.$_href.'" target="_BREAK">'.$v['name'].'</a>';

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
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		if(isset($array['class_ids']) and !empty($array['class_ids'])){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// 相關產品 下面這段在上面1308就處理過了，所以註解
		// if(isset($array['related_ids']) and !empty($array['related_ids'])){
		// 	$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		// } else {
		// 	$array['related_ids'] = '';
		// }

		//Ming 2018-12-18 來信 指示 資料更新後，點擊送出後需返回列表頁 ( 所有單元都是 ),設定非資訊部人員才會動作 by lota
		if(!preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
			$array['update_base64_url'] = '';
		} 

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		if(isset($array['class_ids']) and !empty($array['class_ids'])){
			$array['class_ids'] = ','.implode(',', $array['class_ids']).',';
		} else {
			$array['class_ids'] = '';
		}

		// 相關產品
		if(isset($array['related_ids']) and !empty($array['related_ids'])){
			$array['related_ids'] = ','.implode(',', $array['related_ids']).',';
		} else {
			$array['related_ids'] = '';
		}

		if(isset($array['other6']) and !empty($array['other6'])){
			$array['other6'] = ','.implode(',', $array['other6']).',';
		} else {
			$array['other6'] = '';
		}

		return $array;
	}

	protected function create_run_last() 
	{
		// 為了要支援sort_id改欄位名稱
		$sort_field = 'sort_id';
		if(isset($this->data['def']['func_field']['sort_id']) and $this->data['def']['func_field']['sort_id'] != ''){
			$sort_field = $this->data['def']['func_field']['sort_id'];
		}

		/*
		 * 2019-02-14
		 * 每筆新資料新增時，請排列到第一筆(原會最後一筆)(這裡是舊的)
		 * http://redmine.buyersline.com.tw:4000/issues/31012
		 */
		
		// $this->cidb->where('id', $this->data['_last_insert_id']);
		// $this->cidb->update($this->data['def']['table'], array($sort_field => 0));

		// // 重新排序
		// // 目前Fieldsorter不支援where以外的方法
		// if(isset($this->data['def']['listfield'][$sort_field])){
		// 	$fieldsorter = new Fieldsorter;
		// 	$fieldsorter->setTableName($this->data['def']['table']);
		// 	$fieldsorter->setIdName($this->data['def']['func_field']['id']);
		// 	if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
		// 		$fieldsorter->setCondition($this->data['def']['condition']);
		// 	}
		// 	//$fieldsorter->refresh();
		// 	$fieldsorter->refresh('', array(),'', $sort_field);
		// }

		/*
		 * 2020-08-19
		 * 試著寫寫看，新增的時候，會是第一筆
		 */
		if(isset($this->data['origin_condition'])){
			if(isset($this->data['datasave']['class_id']) and $this->data['datasave']['class_id'] > 0){ // 有單選的情況，先改零，在重排
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));
				
				// 單分類排序
				//$conditions[] = $k.'='.$v;

				$this->data['origin_condition'][0][1] .= ' AND class_id='.$this->data['datasave']['class_id'].' ';

				// 重新排序
				// 目前Fieldsorter不支援where以外的方法
				if(isset($this->data['def']['listfield'][$sort_field])){
					$fieldsorter = new Fieldsorter;
					$fieldsorter->setTableName($this->data['def']['table']);
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					$fieldsorter->setCondition($this->data['origin_condition']);
					$fieldsorter->refresh('', array(),'', $sort_field);
				}
			} elseif(!isset($this->data['datasave']['class_id']) and !isset($this->data['datasave']['class_id'])){ // 分項的情況
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));

				$fieldsorter = new Fieldsorter;
				$fieldsorter->setTableName($this->data['def']['table']);
				$fieldsorter->setIdName($this->data['def']['func_field']['id']);
				$fieldsorter->setCondition($this->data['origin_condition']);
				$fieldsorter->refresh('', array(),'', $sort_field);
			}
		}

	}

	// 解無限層分類(不含頂層)
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		if($rows and !empty($rows)){
			foreach($rows as $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}

	//多圖 - 子節點
	public function actionProductphoto($param)
     {
        $ss = 'productphoto_node';
        $session = Yii::app()->session[$ss];
        $session['parent'] = 'product';
        $session['value'] = $param;
        $session['field'] = 'class_id';
        Yii::app()->session[$ss] = $session;

        $this->redirect($this->createUrl('productphoto/index'));
    }
	public function actionproductIngredientsgroup($param)
     {
        $ss = 'productingredientsgroup_node';
        $session = Yii::app()->session[$ss];
        $session['parent'] = 'product';
        $session['value'] = $param;
        $session['field'] = 'class_id';
        Yii::app()->session[$ss] = $session;

        $this->redirect($this->createUrl('productingredientsgroup/index'));
    }
	public function actionproductstep($param)
     {
        $ss = 'productstep_node';
        $session = Yii::app()->session[$ss];
        $session['parent'] = 'product';
        $session['value'] = $param;
        $session['field'] = 'class_id';
        Yii::app()->session[$ss] = $session;

        $this->redirect($this->createUrl('productstep/index'));
    }


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
