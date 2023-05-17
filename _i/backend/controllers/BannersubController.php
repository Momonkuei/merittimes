<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

		// 通常是A方案複製出來後在使用的
		'disable_create' => true,
		'disable_delete' => true,

		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('topic', 'required'),
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
			'pic1' => array(
				//'label' => '圖片',
				'mlabel' => array(
					null, // category
					'Image', // label
					array(), // sprintf
					'代表圖', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'other1' => array(
				'label' => '功能英文名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '15%',
				'sort' => true,
			),
			'other2' => array(
				'label' => '編號',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				'sort' => true,
				'align' => 'center',
			),
			'topic' => array(
				'label' => '描述',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '30%',
				'sort' => true,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面 1/7
				'width' => '',
			),
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
						'other1' => array(
							'label' => '功能英文名稱',						
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '20',
							),
						),
						'other2' => array(
							'label' => '編號',						
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '20',
							),
						),
						'other3' => array(
							'label' => '編排頁編號',						
							'type' => 'input',
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
								'size' => '20',
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
			'smarty_javascript_text' => '',
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
							'label' => '描述',
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
						//2017/9/1 加入可在後台自訂各主選單頁面的banner by Lota 
						'other1' => array(
							'label' => '功能英文名稱',						
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '20',
							),
							'other' => array(
								'html_end' => '如果是company_tw.php，那功能英文名稱就是company',
							),
						),
						'other2' => array(
							'label' => '編號',						
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '20',
							),
							'other' => array(
								'html_end' => '如果是XXX_tw.php?id=YYY，那編號就是YYY',
							),
						),
						'other3' => array(
							'label' => '編排頁編號',						
							'type' => 'input',
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
								'size' => '20',
							),
							'other' => array(
								'html_end' => '如果是XXX_tw_YYY.php，那編排頁編號就是YYY',
							),
						),
						'xx01' => array(
							'label' => '&nbsp;',						
							'type' => 'inputn',
							'other' => array(
								'html' => 
'<b>規則A (依據優先權排列)：</b><br />
<br />
1: 有指定功能英文名稱和編號<br />
2: 只有指定功能名稱<br />
3: 通用 (都沒有指定)<br />
<br />
<b>規則B： (後台的前台主選單，在內頁大圖那邊，必需要有選擇指定的規則B的情況下)</b> <a href="/_i/backend.php?r=webmenu" target="_blank">連結</a><br />
<br />
功能導向: 記得功能英文名稱的欄位要填，不然就算選了這項，也不會有作用<br />
鎖定編號: 功能英文名稱、和編號欄位要記得填<br />
編號繼承: 同上，除此之外，運作原理是，在內頁的話，是從麵包屑的倒數第二層往頭找。不是內頁的話，從麵包屑的自己開始往頭找<br />
',
							),
						),
						'pic1' => array(
							'label' => '大圖上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '1920',
								'height' => '300',
								'comment_size' => '1920x300',
								'no_ext' => '',
								'no_need_delete_button' => '',
								'width' => '600',
							),
						),
						'pic2' => array(
							'label' => '小圖上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' =>'2',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '1200',
								'height' => '350',
								'comment_size' => '1200x350',
								'no_ext' => '',
								'no_need_delete_button' => '',
								//'width' => '600',
							),
						),
						//2022-03-21 #43829
						'field_data' => array(
							'label' => 'V4-Banner上方文字及變化區塊<br>內頁view要使用pageBanner02',
							'translate_source' => 'tw',
							'type' => 'textarea',
							// 'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'field_data',
								'name' => 'field_data',
								'rows' => '15',
								'cols' => '100',
							),
						),
						'pic3' => array(
							'label' => '社群圖上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' =>'2',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '600',
								'height' => '600',
								'comment_size' => '600x600',
								'no_ext' => '',
								'no_need_delete_button' => '',
								//'width' => '600',
							),
						),
						'other30' => array(
							'label' => '社群描述',
							'translate_source' => 'tw',
							'type' => 'textarea',
							'attr' => array(
								'id' => 'other30',
								'name' => 'other30',
								'rows' => '15',
								'cols' => '100',
							),
						),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'mlabel' => array(
								null, // category
								'Sort', // label
								array(), // sprintf
								'排序', // default
							),
							'type' => 'sort',
							'attr' => array(
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
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
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
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'detail' => array(
				//			'label' => '描述',
				//			'type' => 'ckeditor_js',
				//			'attr' => array(
				//				'id' => 'detail',
				//				'name' => 'detail',
				//			),
				//		),
				//	),
				//),
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

		// 2020-08-26 A方案的客制功能專用
		if(1){
			$this->data['rowg_custom'] = array(
				'topic' => '主選單名稱', // 標題
				'other1' => '', // 頁面pageTitle的旁邊

				'url1' => '', // 網址，例如news_tw.php

				'is_home' => 1, // 動態次選單

				'pic2' => 0, // 分類
					'is_news' => 0, // 通用分類 *目前只支援通用分類資資料格式*
					'other22' => '', // 自訂分類名稱
					'other10' => 0, // 分類下有分項
				'class_ids' => 1, // 通用分項
				'is_top' => 0, // 單頁
				'pic3' => 0, // 日期排序
				'other24' => 0, // 下架時間

				/*
				 * 其它選項
				 */
				'other15' => 1, // 無限層的分類層數限制(1~15)

				// 列表頁
				// '0' => '無 (有分類: 轉頁到第一個分類, 無分類: 空白)',
				// '1' => '顯示所有物件 (總覽頁)',
				// '2' => '頂層分類列表',
				'other5' => 0,

				'other6' => 5, // 每頁幾筆(預設5筆)

				// http://redmine.buyersline.com.tw:4000/issues/18231#note-40
				// 關鍵字：enableurl_by_subclass_haschild
				// 有次分類的分類，連結有效 (如果 點擊分類的動作 不是 預設 的時候，就要打勾)
				'other12' => 0,

				// 點擊分類的動作
				// '0' => '顯示當層物件 (預設)',
				// '1' => '顯示當層分類，如果是最末層則顯示物件',
				// '2' => '遞迴顯示該層底下的物件 (含自己) *有參數',
				// '3' => '顯示當層的分類與物件 *還沒寫',
				'other13' => 0,

				'other14' => '', // 遞迴搜尋目標(預設 v3/default/sidemenu_empty_datasource)
				//'other21' => '', // 頂層分類升級(只適用於獨立分類 > 2) * 這個應該用不到

				/*
				 * 後台功能
				 */
				'other18' => 0, // 獨立功能的大分類可否被選(0=>不想回答，1=>可，2=>不可)
				'other25' => '', // [節點] 父節點 router class 名稱 *目前只支援通用分類*
				'other27' => 0, // [節點] 是否為通用

				/*
				 * 功能連結
				 */
				'other26' => 0, // 切換成"多分類排序" (預設單分類排序) 相依通用、或是獨立資料表

				// 內頁大圖
				// '0' => '不干涉 (規則A)',
				// '1' => '功能導向 (規則B)',
				// '2' => '鎖定編號 (規則B)',
				// '3' => '編號繼承 (規則B)',
				'other11' => 0,
			);
		}

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';

		// 2018-10-01
		// if(preg_match('/^buyersline_(.*)$/', $this->data['admin_account']) and preg_match('/^99999/', $this->data['admin_id']) and $this->data['admin_name'] != '' and defined('EIP_APIV1_DOMAIN') and defined('EIP_APIV1_PUBLICKEY') and defined('EIP_APIV1_PRIVATEKEY')){
		if(preg_match('/\,(999995|999994)\,/', ','.$this->data['admin_type'].',')){
			unset($this->def['disable_create']);
			unset($this->def['disable_delete']);
		} else {
			$this->def['enable_index_advanced_search'] = false;
			unset($this->def['listfield']['other1']);
			unset($this->def['listfield']['other2']);
			unset($this->def['listfield']['is_enable']);
			unset($this->def['listfield']['sort_id']);
			unset($this->def['updatefield']['sections'][0]['field']['other1']);
			unset($this->def['updatefield']['sections'][0]['field']['other2']);
			unset($this->def['updatefield']['sections'][0]['field']['other3']);
			unset($this->def['updatefield']['sections'][0]['field']['xx01']);
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
		$this->data['updatecontent']['class_id'] = -1;

		/*
		 * 舊寫法，請注意哦！！
		 */
		
		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = ' type=\''.$this->data['router_class'].'\' and  ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
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

			// 只是為了要讓管理者更快的了解這個功能而做的，也為了要表達，這個功能跟產品的排序是不一樣的 2018-01-02
			$this->def['listfield']['sort_id']['sort'] = false;
			$this->def['default_sort_field'] = 'id';

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

		return true;
	}

	protected function index_last($param='')
	{
		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}

				// 商品複製
				// 2017-07-20 李哥說，要加上授權，就是99999開頭的都要加
				if(preg_match('/^99999/', $this->data['admin_id'])){
					$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> '.G::_('Copy', 'en').'</a>';
				}

				$this->data['listcontent'][$k] = $v;
			}
		}
	}

	protected function create_show_last($param='')
	{
		// unset($this->data['def']['updatefield']['sections'][1]['field']['kc01']);

		// funcfieldv3 有需要就打開 5/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
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
		}else{
			// funcfieldv3 有需要就打開 6/7
			$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
			$contentx = str_replace('<'.'?'.'php', '', $contentx);
			eval($contentx);
		}

			

		// $this->data['main_content'] = 'default/update';
	}

	protected function update_run_other_element($array)
	{
		// funcfieldv3 有需要就打開 7/7
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];
		return $array;
	}

	protected function update_run_copy($update)
	{
		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

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
				$session['class_id'] = $update['class_id'];
				Yii::app()->session[$ss] = $session;

				$parameter = new Parameter_handle;
				$param_define = $parameter->getDefine();
				//$url = $this->createUrl($this->data['router_class'].'/index', array('param' => base64url::encode('sort_id').'-'.$param_define['direction'].'desc'));
				$url = $this->createUrl($this->data['router_class'].'/index', array('param' => base64url::encode($this->def['func_field']['sort_id']).'-'.$param_define['direction'].'desc'));
			}
		}

		G::alert_and_redirect('Copy Success !', $url, $this->data);

		die;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
