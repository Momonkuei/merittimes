<?php
/*
 * Datatablealteditor 浮動編輯
 * 2021-12 起始於  中華佛學研究所 chibs.web2.buyersline.com.tw
 * 欄位產生器目前只支援 input 及 textarea
 */

// 懶得改Controller的名稱之一
// $tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
// $filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => false,
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
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				// array('topic', 'required'),
				// array('detail', 'system.backend.extensions.myvalidators.numericcodeutf8'),
				// array('start_date', 'date', 'format'=>'yyyy-M-d'),
				// array('phone','numerical','integerOnly'=>true),
			),
		),
		'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'id', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
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
		'listfield' => array(
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
$('#end_date').datepicker({dateFormat: 'yy-mm-dd'});
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
				// funcfieldv3的產出欄位，放在任何位置都可以
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
						'_contentbuilder' => array(
							'label' => '',
							'type' => 'inputn',
							'other' => array(
								'html'=>'<div class="control-box"><button type="button" id="htmlbtn" onclick="openif(\'detail\')">+ 加入範本</button><input type="hidden" id="ctidx" value=""><div id="ctarea" style="display: none;" ></div>',	
							),
						),
					),
				),
				// section
				// array(
				// 	'form' => array('enable' => false),
				// 	'type' => '2',
				// 	'field' => array(
				//  		'detail' => array(
				//  			'label' => '內容',
				//  			//'type' => 'textarea',
				//  			'type' => 'ckeditor_js',
				//  			'attr' => array(
				//  				//'class' => 'form-control', // 這…手動加上去好了
				//  				'id' => 'detail',
				//  				'name' => 'detail',
				//  				//'rows' => '4',
				//  				//'cols' => '40',
				//  			),
				//  		),
				// 	),
				// ),
				// funcfieldv3的自定欄位，放在任何位置都可以
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

		// var_dump($_SESSION);die;		

		// 2020-08-26 A方案的客制功能專用
		if(0){
			$this->data['rowg_custom'] = array(
				'topic' => '主選單名稱', // 標題
				'other1' => '', // 頁面pageTitle的旁邊

				'url1' => '', // 網址，例如news_tw.php

				'is_home' => 1, // 動態次選單

				'pic2' => 0, // 分類
					'is_news' => 1, // 通用分類 *目前只支援通用分類資資料格式*
					'other22' => '', // 自訂分類名稱
					'other10' => 0, // 分類下有分項
				'class_ids' => 0, // 通用分項
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

		// 只有 設計/資訊 ，看得到拖拉範本
		if(!preg_match('/^(999994|999995)/', $this->data['admin_type'])){
			unset($this->def['updatefield']['sections'][0]['field']['_contentbuilder']);
		}else{
			//拖拉樣版的基本框架
			if(isset($this->data['BODY_END'])){
				$this->data['BODY_END'] .= '<iframe name="cbiframe" id="cbiframe" style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; border: 0px;display: none;"  src="" ></iframe><script type="text/javascript" src="/_i/assets/contenvuilder.js"></script>';
			}else{
				$this->data['BODY_END'] = '<iframe name="cbiframe" id="cbiframe" style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; border: 0px;display: none;"  src="" ></iframe><script type="text/javascript" src="/_i/assets/contenvuilder.js"></script>';
			}
		}

		// 2018-08-29 分項節點(1/3) 子
		// 先做第一次的檢查
		// param={value 索引值}__{parent router_class}__{child router_class}__{child field_name}
		$ss = $this->data['router_class'].'_node';
		$session_node = Yii::app()->session[$ss];
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('type =:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if($rowg and isset($rowg['other25']) and $rowg['other25'] != ''){
			if(isset($session_node['value']) and $session_node['value'] > 0){
				$is_html = true; // 通用資料表為預設
				if($rowg){ 
					// 上一層，是獨立資料表？還是通用資料表？
					if(isset($rowg['other27']) and $rowg['other27'] == 0){ // 獨立分項
						$is_html = false;
					}
				}

				// 找上一層的標題名稱
				if($is_html){
					$row = $this->cidb->select('*, topic as name')->where('is_enable',1)->where('type',$session_node['parent'])->where('id',$session_node['value'])->get('html')->row_array();
				} else {
					$row = $this->cidb->where('is_enable',1)->where('id', $session_node['value'])->get($session_node['parent'])->row_array();
				}

				// 如果上一層是獨立分類，記得要在後台的前台主選單裡面，建立XXXtype_{ml_key}.php
				$rowg_parent = $this->db->createCommand()->from('html')->where('type =:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$session_node['parent'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();

				if($row and isset($row['id'])){
					// $this->def['title'] = $row['topic'];
					$this->data['main_content_title'] = '<a href="backend.php?r='.$session_node['parent'].'">'.$rowg_parent['topic'].'</a> / <a href="backend.php?r='.$session_node['parent'].'/update&param=v'.$session_node['value'].'">'.$row['name'].'</a> / '.$rowg['topic'];
				}
			} else {
				// G::alert_and_redirect(G::t(null,'請先搜尋客戶資料'), '/_i/backend.php?r=personalcustomer/index', $this->data);
				header('Location: backend.php?r='.$rowg['other25']);
				die;
			}
		}

		$product_table = $this->data['router_class'];


		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
		if($rowg){ 			

			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
				$this->def['table'] = 'html';
				$this->def['empty_orm_data']['table'] = 'html';
				// $this->def['empty_orm_data']['rules'][] = array('topic','required');

				$this->def['search_keyword_field'] = array('topic');
				$this->def['search_keyword_assign_field'] = 'topic';
				$this->def['sys_log_name'] = 'topic';

				// unset($this->def['listfield']['name']);
				// unset($this->def['updatefield']['sections'][0]['field']['name']); // update, copy
			} else {
				$this->def['table'] = $product_table;
				$this->def['empty_orm_data']['table'] = $product_table;
				// $this->def['empty_orm_data']['rules'][] = array('name','required');

				$this->def['search_keyword_field'] = array('name');
				$this->def['search_keyword_assign_field'] = 'name';
				$this->def['sys_log_name'] = 'name';

				// unset($this->def['listfield']['topic']);
				// unset($this->def['updatefield']['sections'][0]['field']['topic']); // update, copy
			}

			if(isset($rowg['pic2']) and $rowg['pic2'] == 1){ // 有分類

				// if(isset($rowg['other26']) and $rowg['other26'] == 1){ // 是否為“多分類排序”
				// 	// unset($this->def['updatefield']['sections'][0]['field']['class_id']);
				// 	// unset($this->def['listfield']['xx2']);
				// } else {
				// 	// $this->def['empty_orm_data']['rules'][] = array('class_id', 'required');
				// }

				if(isset($rowg['is_news']) and $rowg['is_news'] == 1){ // 是通用分類

					$type_name = $this->data['router_class'].'type';
					if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
						$type_name = $rowg['other22'];
					}

					// $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>$type_name,':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
					// if($rows and !empty($rows)){
					// 	foreach($rows as $k => $v){
					// 		$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
					// 		$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['topic'];
					// 	}
					// }

					// if(isset($rowg['other26']) and $rowg['other26'] == 1){ // 是否為“多分類排序”
					// 	$this->def['updatefield']['sections'][0]['field']['class_ids']['other']['name'] = 'topic';
					// }
				} else { // 是獨立分類
					// 這裡是從產品那邊複製過來的
				
					// 分類
					$producttype_table = $this->data['router_class'];
					//$producttype_table = str_replace('homesort', '', $producttype_table); // 為了支援產品的首頁排序(這是homesort的另一支後台功能在用的，註解不要打開)
					$producttype_table .= 'type';

					if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
						$producttype_table = $rowg['other22'];
					}

					// $rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
					// if($rows and !empty($rows)){
					// 	foreach($rows as $k => $v){
					// 		if(isset($rowg['other18']) and $rowg['other18'] == 1){
					// 			// 大分類可選
					// 			$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
					// 			$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
					// 		} elseif(isset($rowg['other18']) and $rowg['other18'] == 2){
					// 			// 大分類不可選
					// 			$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
					// 			$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
					// 		}

					// 		// 剩餘子層的處理程序
					// 		$data_1 = $this->layout_show($v['id'],1,'　',$producttype_table);//'　└'	
					// 		$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
					// 		$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;
					// 	}
					// }
				}
			} else { // 無分類			
				// $this->def['enable_index_advanced_search'] = false;
				// unset($this->def['searchfield']);
				// unset($this->def['searchfield']['sections'][0]['field']['class_id']);

				// unset($this->def['updatefield']['sections'][0]['field']['class_id']);
				// unset($this->def['listfield']['xx2']);
			}
		} else {
			// 沒有跟webmenu掛勾的，這個欄位就不用了，需要的話，自行在funcfieldv3使用
			// unset($this->def['updatefield']['sections'][0]['field']['start_date']);
		} // if row


		// funcfieldv3
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

	public function actionIndex($param='')
	{
	
		$this->data['def'] = $this->def;	
			

		$load = array();		

		$this->data['updatecontent'] = $load;
		//var_dump($this->data['updatecontent']);

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		//父節點
	  if($rowg['other25']!=''){
	  	$_type = $rowg['other25'];
	  }else{
	  	$_type = $this->data['router_class'].'type';
	  }

		//分類參數資料
	  $_class2_id_url = $_class_id_url = '';

	  if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1 ){ // 有分類	  	

	  	//預設分類ID
		  if(isset($_GET['class_id']) && $_GET['class_id']!=''){
		  	$_row_tmp = $this->cidb->where('id',$_GET['class_id'])->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();	  		  		
		  }else{
		  	$_row_tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->order_by('sort_id','asc')->get('html')->row_array();
		  }

		  if(isset($_row_tmp) && $_row_tmp){
		  	$_class_id_url = '&class_id='.$_row_tmp['id'];
		  	$_class2_id_url = $_class_id_url;
		  	//delete的要另外做參數(客製才需要)
		  	// $_class2_id_url = '&class2_id='.$_row_tmp['id'];
		  }
		}


		$this->data['url_ws_mock_get'] = FRONTEND_DOMAIN.'/_i/backend.php?r='.$this->data['router_class'].'/ajaxdata'.$_class_id_url;
		$this->data['columns_url'] = FRONTEND_DOMAIN.'/_i/backend.php?r='.$this->data['router_class'].'/ajaxcolumndefs'.$_class_id_url;
		$this->data['data_insert_url'] = FRONTEND_DOMAIN.'/_i/backend.php?r='.$this->data['router_class'].'/ajaxinsertdata'.$_class_id_url;
		$this->data['data_delete_url'] = FRONTEND_DOMAIN.'/_i/backend.php?r='.$this->data['router_class'].'/ajaxdeletedata'.$_class2_id_url;//delete的要另外做參數(客製才需要)
		$this->data['data_edit_url'] = FRONTEND_DOMAIN.'/_i/backend.php?r='.$this->data['router_class'].'/ajaxupdatedata'.$_class_id_url;
		$this->data['sort_url'] = FRONTEND_DOMAIN.'/_i/backend.php?r='.$this->data['router_class'].'/ajaxsortdata'.$_class_id_url;

		$this->data['_head_script'] = '
	<!-- CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" />  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />
  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
		<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js" ></script>
<script src="https://code.jquery.com/jquery-migrate-3.3.0.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.js" ></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.js" ></script>

<script src="./backend/views/datatablealteditor/src/dataTables.altEditor.free.js" ></script>
<!-- <script src="./backend/views/datatablealteditor/example12.js" ></script>-->
  ';

  //客製篩選
  $_option_text = '';
  // if(isset($_row_tmp) && $_row_tmp){
	//  	if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
	//  		for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
	//  			$_option_text .= '<option value="'.$i.'">'.$i.'</option>';
	//  		}	  		
	//  	}
	// }

  //分類下拉跳頁 - 選項
  if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1 ){ // 有分類

  	//父節點
	  if($rowg['other25']!=''){
	  	$_type = $rowg['other25'];
	  }else{
	  	$_type = $this->data['router_class'].'type';
	  }

		$_option2_text = '';
		$_row2_tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->order_by('sort_id','asc')->get('html')->result_array();
		foreach ($_row2_tmp as $key => $value) {
			$_option2_text .= '<option value="backend.php?r='.$this->data['router_class'].'&class_id='.$value['id'].'"';
			if(isset($_GET['class_id']) && $_GET['class_id']!='' && $_GET['class_id']==$value['id']){
				$_option2_text .= ' selected ';
			}
			$_option2_text .= ' >'.$value['topic'].'</option>';
		}

		$this->data['select_class_html'] = '';

	  //分類下拉跳頁 - html
	  $this->data['select_class_html'] .= '
	  	選擇分類<select name="select2" id="select2" onChange="location = this.options[this.selectedIndex].value;">                
	                '.$_option2_text.'            
	  </select>';
	}

 	// 下拉 table.draw()
  // $this->data['select_class_html'] .=' | 
  // 	篩選年份<select name="select1" id="select1" class="monthlist">
  //               <option value="">請選擇</option>
  //               '.$_option_text.'              
  // </select>';

  	// $this->data['select_class_js'] = "
  	// $('body').on('change','.monthlist',function(){
   //    var selectedValue=$(this).val();
   //    var myTable = $('#example').DataTable();
      
   //    myTable.columns(1).search( selectedValue ).draw();
   //  });
  	// ";


		//節點 顯示父類別
		if($rowg['other25']!=''){
			if(isset($_SESSION[$this->data['router_class'].'_node']['value'])  && $_SESSION[$this->data['router_class'].'_node']['value']!=''){
				$_class_id = $_SESSION[$this->data['router_class'].'_node']['value'];
				$_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();	
				$this->data['main_content_title'] .= ' - '.$_row_tmp['topic'];		
			}	  	
	  }

		

		$this->data['main_content'] = 'datatablealteditor/main';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
		$this->display('index.htm', $this->data);		
	}

	protected function columndata($param='')
	{

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		$_data = array();

		$_data['id'] = array(  //必備
				'title'=>'ID',
				'type'=>'readonly',
				'other'=>'',
				'update_data_rename_id'=>'sort_id',
				);

		if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1 ){ // 有分類
		
			$_data['class_id'] = array(
					'title'=>'分類',
					'type'=>'select',
					'other'=>'
					options : employeeOptions,
	        select2 : { width: "100%"},
	        render: function (data, type, row, meta) {
	            if (data == null || !(data in employeeOptions)) return null;
	            return employeeOptions[data];
	        }'
	      );

		}

		//欄位產生器 目前只支援 input 及 textarea
		$_column_data = $this->cidb->where('type','funcfieldv3__'.$this->data['router_class'].'__'.$this->def['table'])->where('is_enable',1)->order_by('sort_id')->get('html')->result_array();

		foreach ($_column_data as $key => $value) {
				
				if($value['other6']=='input' && $value['other1']!='' && $value['topic']!=''){
							$_data[$value['other1']] = array(
								'title'=>$value['topic'],
								'type'=>'',
								'other'=>''
							);
				}

				if($value['other6']=='textarea' && $value['other1']!='' && $value['topic']!=''){
						$_data[$value['other1']] = array(
									'title'=>$value['topic'],
									'type'=>'textarea',
									'other'=>'
									render:function( data, type, row, meta ){
						      return data.replaceAll(\'\n\',\'<br/>\');
						    }'
						  );
				}
		}

		//客製 由節點帶入資料
		if(isset($_SESSION[$this->data['router_class'].'_node']['other1']) && $_SESSION[$this->data['router_class'].'_node']['other1']!='' && $_SESSION[$this->data['router_class'].'_node']['other1']!='0'){
			for ($i=1; $i <= $_SESSION[$this->data['router_class'].'_node']['other1'] ; $i++) { 
				$_data['other'.$i] = array(
					'title'=>'欄位'.$i,
					'type'=>'textarea',
					'other'=>'render:function( data, type, row, meta ){
						      return data.replaceAll(\'\n\',\'<br/>\');
						    }'
				);
			}
		}


		// $_data = array(
		// 	'id'=>array(  //必備
		// 		'title'=>'ID',
		// 		'type'=>'readonly',
		// 		'other'=>'',
		// 		'update_data_rename_id'=>'sort_id',
		// 		),

		// 	'class_id'=>array(
		// 		'title'=>'分類',
		// 		'type'=>'select',
		// 		'other'=>'
		// 		options : employeeOptions,
  //       select2 : { width: "100%"},
  //       render: function (data, type, row, meta) {
  //           if (data == null || !(data in employeeOptions)) return null;
  //           return employeeOptions[data];
  //       }'
  //     ),

		// 	'topic'=>array(
		// 		'title'=>'專案名稱',
		// 		'type'=>'',
		// 		'other'=>''
		// 	),

		// 	'detail'=>array(
		// 		'title'=>'內容簡述',
		// 		'type'=>'textarea',
		// 		'other'=>'
		// 		render:function( data, type, row, meta ){
	 //      return data.replaceAll(\'\n\',\'<br/>\');
	 //    }'
	 //  ),

		// 	'field_tmp'=>array(
		// 		'title'=>'專案網址',
		// 		'type'=>'textarea',
		// 		'other'=>'
		// 		render:function( data, type, row, meta ){
	 //      return data.replaceAll(\'\n\',\'<br/>\');
	 //    }'
	 //  ),

	 //    // 'data_id'=>array(
	 //    // 	'title'=>'資料ID',
	 //    // 	'type'=>'hidden',
	 //    // 	'other'=>'',
	 //    // 	'no_data'=> true,
		// //	'update_data_rename_id'=>'data_id',
	 //    // ),	

		// );

		

		return $_data;
	}

	public function actionAjaxdata($param='')
	{

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		$_select = '';
		$_tmp = array();

		$_type = $this->data['router_class'].'type';

		//節點ID
		if($rowg['other25']!=''){			
			if(isset($_SESSION[$this->data['router_class'].'_node']['value'])  && $_SESSION[$this->data['router_class'].'_node']['value']!=''){
				$_class_id = $_SESSION[$this->data['router_class'].'_node']['value'];				
			}
			$_type = $rowg['other25'];
		}

		if(isset($_GET['class_id']) && $_GET['class_id']!=''){
			$_class_id = $_GET['class_id'];
		}

		foreach ($this->columndata() as $key => $value) {
			
			if(isset($value['update_data_rename_id']) && $value['update_data_rename_id']!=''){
				$_tmp[] = $value['update_data_rename_id'].' as '.$key;
			}else{
				$_tmp[] = $key;
			}
		}
		$_select = implode(',', $_tmp);

		//選取所屬的分類
		$_ddd = array();
		if(isset($_class_id) && $_class_id!=''){			

			$_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();

			//分類選取		  			  	
		  if(isset($_row_tmp) && $_row_tmp){
		  	$_ddd[] = $_class_id;

		  	//客製
			 	// if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
			 	// 	for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
			 	// 		$_ddd[] = $i;
			 	// 	}	  		
			 	// }

			}		
		}

		//資料讀取
		$this->cidb->select($_select.',id as gggid');

		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
				$this->cidb->where('type',$this->data['router_class']);
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('class_id',$_ddd);
				}
			}else{
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('pid',$_ddd);
				}
			}
		}else{
			$this->cidb->where('type',$this->data['router_class']);
		}

		$this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key']);

		
		$_data = $this->cidb->order_by('sort_id')->get($this->def['table'])->result_array();	

		//排序ID檢查更新
		foreach ($_data as $key => $value) {
			$_k = ($key+1);
			if($value['id']!=$_k){

				if($rowg){
					if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
						$this->cidb->where('type',$this->data['router_class']);
						//分類資料
						if(count($_ddd) > 0){
							$this->cidb->where_in('class_id',$_ddd);
						}
					}else{
						//分類資料
						if(count($_ddd) > 0){
							$this->cidb->where_in('pid',$_ddd);
						}
					}
				}else{
					$this->cidb->where('type',$this->data['router_class']);
				}

				$this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('id',$value['gggid']);
				$this->cidb->update('html',array('sort_id'=>$_k));
				$_data[$key]['id'] = $_k;
			}
			unset($_data[$key]['gggid']);
			//將id改為數字型態(排序用)
			$_data[$key]['id'] = (int)$value['id'];
		}	

		if($_data){
  			echo json_encode($_data);
		}
	}

	public function actionAjaxcolumndefs($param='')
	{		

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		$_data = '';

		$_type = $this->data['router_class'].'type';

		//節點ID
		if($rowg['other25']!=''){			
			if(isset($_SESSION[$this->data['router_class'].'_node']['value'])  && $_SESSION[$this->data['router_class'].'_node']['value']!=''){
				$_class_id = $_SESSION[$this->data['router_class'].'_node']['value'];				
			}
			$_type = $rowg['other25'];
		}

		if(isset($_GET['class_id']) && $_GET['class_id']!=''){
			$_class_id = $_GET['class_id'];
		}

		if($rowg and isset($rowg['pic2']) and $rowg['pic2'] == 1 ){ // 有分類

			//分類資料
			$_employeeOptions = '';

				//單層
				$_row_tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->result_array();

				//兩層
		  	// if(isset($_class_id) && $_class_id!=''){
		  	// 	$_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();
		  	// }else{
		  	// 	$_row_tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->order_by('sort_id','desc')->get('html')->row_array();
		  	// }

				$_employeeOptions = 'var employeeOptions = {';
		  	if(isset($_row_tmp) && $_row_tmp){		  		

		  		//分類選項
		  		foreach ($_row_tmp as $key => $value) {
		  			$_employeeOptions .= '"'.$value['id'].'" : "'.$value['topic'].'",';
		  		}

		  		//客製
			  	// if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
			  	// 	for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
			  	// 		$_employeeOptions .= '"'.$i.'" : "'.$i.'",';
			  	// 	}	  		
			  	// }
			  	
				}
				$_employeeOptions .= '};';

			//下拉選項
			$_data .= $_employeeOptions;

		}


		//資料
		$_data .= 'url_columns_get = [';

		foreach ($this->columndata() as $key => $value) {
			$_data .= '
		 		{
			    data: "'.$key.'",
			    title: "'.$value['title'].'",
			    type: "'.$value['type'].'",
			    '.$value['other'].'
		  	},';			
		}

	  	//功能
	  	$_data .= '
	  	{
		    data: null,
		    title: "動作",
		    name: "Actions",
		    render: function (data, type, row, meta) {
		      return \'<a class="editbutton btn btn-success" href="#">編輯</a><a class="delbutton btn btn-danger" href="#">刪除</a>\';
		    },
		    disabled: true
		  }, ';

		  $_data .= ']';
			echo $_data;	

	}

	public function actionAjaxsortdata($param='')
	{
		var_dump($_POST);

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		$_type = $this->data['router_class'].'type';

		//節點ID
		if($rowg['other25']!=''){			
			if(isset($_SESSION[$this->data['router_class'].'_node']['value'])  && $_SESSION[$this->data['router_class'].'_node']['value']!=''){
				$_class_id = $_SESSION[$this->data['router_class'].'_node']['value'];				
			}
			$_type = $rowg['other25'];
		}

		if(isset($_GET['class_id']) && $_GET['class_id']!=''){
			$_class_id = $_GET['class_id'];
		}

		//分類資料
		$_where_in_text = '';
		$_ddd = array();
		if(isset($_class_id) && $_class_id!=''){
			$_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();

			
		  	if(isset($_row_tmp) && $_row_tmp){
		  		//單選
		  		$_ddd[] = $_class_id;

		  		//客製
			  	// if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
			  	// 	for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
			  	// 		$_ddd[] = $i;
			  	// 	}	  		
			  	// }
		  		if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
			  		$_where_in_text .= ' and class_id in ('.implode(',', $_ddd).')'; 
			  	}else{
			  		$_where_in_text .= ' and pid in ('.implode(',', $_ddd).')'; 
			  	}
			}
		}

		foreach ($_POST as $key => $value) {
			$old_id = str_replace('old_','',$key);

			if($rowg){
				if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
					$this->cidb->where('type',$this->data['router_class']);
					//分類資料
					if(count($_ddd) > 0){
						$this->cidb->where_in('class_id',$_ddd);
					}
					$_updata = array('sort_id_browser'=>$value);
				}else{
					//分類資料
					if(count($_ddd) > 0){
						$this->cidb->where_in('pid',$_ddd);
					}
					$_updata = array('is_home'=>$value);
				}
			}else{
				$this->cidb->where('type',$this->data['router_class']);
				$_updata = array('sort_id_browser'=>$value);
			}

			$this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('sort_id',$old_id);


			$this->cidb->update($this->def['table'],$_updata);
		}

		//批次同步
		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
				$this->cidb->query('update '.$this->def['table'].' set sort_id = sort_id_browser,sort_id_browser = 0 where ml_key="'.$this->data['admin_switch_data_ml_key'].'" and type="'.$this->data['router_class'].'" and sort_id_browser > 0 '.$_where_in_text);
			}else{
				$this->cidb->query('update '.$this->def['table'].' set sort_id = is_home,is_home = 0 where ml_key="'.$this->data['admin_switch_data_ml_key'].'" and is_home > 0 '.$_where_in_text);
			}
		}else{
			$this->cidb->query('update '.$this->def['table'].' set sort_id = sort_id_browser,sort_id_browser = 0 where ml_key="'.$this->data['admin_switch_data_ml_key'].'" and type="'.$this->data['router_class'].'" and sort_id_browser > 0 ');
		}
	}

	public function actionAjaxinsertdata($param='')
	{

		// var_dump($_POST);

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		$savedata1 = $_POST;

		foreach ($this->columndata() as $key => $value) {
			if(isset($savedata1[$key])){
				$savedata[$key] = $savedata1[$key];
				if(isset($value['no_data']) && $value['no_data']==true){
					unset($savedata[$key]);
				}
				if(isset($value['insert_data_rename_id']) && $value['insert_data_rename_id']!=''){
					$savedata[$value['insert_data_rename_id']] = $savedata[$key];					
					unset($savedata[$key]);
				}
			}			
		}
		unset($savedata['id']);

		$_type = $this->data['router_class'].'type';

		//節點ID
		if($rowg['other25']!=''){			
			if(isset($_SESSION[$this->data['router_class'].'_node']['value'])  && $_SESSION[$this->data['router_class'].'_node']['value']!=''){
				$_class_id = $_SESSION[$this->data['router_class'].'_node']['value'];
				//替換分類id
				$savedata['class_id'] = $_class_id;				
			}
			$_type = $rowg['other25'];
		}

		if(isset($_GET['class_id']) && $_GET['class_id']!=''){
			$_class_id = $_GET['class_id'];
		}
		

		//讀取目前最後的sort_id	
		$_ddd = array();
		if(isset($_class_id) && $_class_id!=''){

			//單選
			$_ddd[] = $_class_id;

			//客製複選
			// $_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();
					  			  	
		  // if(isset($_row_tmp) && $_row_tmp){
			//  	if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
			//  		for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
			//  			$_ddd[] = $i;
			//  		}	  		
			//  	}			  	
			// }		
		}		
	

		$this->cidb->select('sort_id');

		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
				$this->cidb->where('type',$this->data['router_class']);
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('class_id',$_ddd);
				}
				
			}else{
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('pid',$_ddd);
				}
				
			}
		}else{
			$this->cidb->where('type',$this->data['router_class']);
		}

		$this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key']);


		$_tmp_dd = $this->cidb->order_by('sort_id','desc')->get($this->def['table'])->row_array();	
		
		if(isset($_tmp_dd['sort_id'])){
			$_now_sort_id = $_tmp_dd['sort_id'];
		}else{
			$_now_sort_id = 0;
		}
		
	
		// $savedata['sort_id'] = 0; 
		$savedata['sort_id'] = $_now_sort_id + 1;
		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
				$savedata['type'] = $this->data['router_class'];
			}
		}else{
			$savedata['type'] = $this->data['router_class'];
		}
		$savedata['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$savedata['is_enable'] = 1;		

		$this->cidb->insert($this->def['table'],$savedata);

		//全部資料的sort_id+1

		//客製 選取所屬的年份
		// $_where_in_text = '';
		// $_ddd = array();
		// if(isset($_class_id) && $_class_id!=''){
		// 	$_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();

		// 	//分類資料  			  	
		//   	if(isset($_row_tmp) && $_row_tmp){
		// 	  	$_ddd[] = $_class_id;
		//			// 客製
		// 	  	// if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
		// 	  	// 	for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
		// 	  	// 		$_ddd[] = $i;
		// 	  	// 	}	  		
		// 	  	// }
		// 	  	$_where_in_text .= ' and class_id in ('.implode(',', $_ddd).')'; 
		// 	}					
		// }

		// $this->cidb->query('update html set sort_id = sort_id + 1 where ml_key="'.$this->data['admin_switch_data_ml_key'].'" and type="'.$this->data['router_class'].'" '.$_where_in_text);
	}

	public function actionAjaxdeletedata($param='')
	{
		// var_dump($_GET);die;

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		$_type = $this->data['router_class'].'type';

		//節點ID
		if($rowg['other25']!=''){			
			if(isset($_SESSION[$this->data['router_class'].'_node']['value'])  && $_SESSION[$this->data['router_class'].'_node']['value']!=''){
				$_class_id = $_SESSION[$this->data['router_class'].'_node']['value'];				
			}
			$_type = $rowg['other25'];
		}

		if(isset($_GET['class2_id']) && $_GET['class2_id']!=''){
			$_class_id = $_GET['class2_id'];
		}

		//分類資料
		$_where_in_text = '';
		$_ddd = array();
		if(isset($_class_id) && $_class_id!=''){
			$_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();

			//分類資料	  			  	
		  	if(isset($_row_tmp) && $_row_tmp){
			  	$_ddd[] = $_class_id;
			  	//客製
			  	// if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
			  	// 	for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
			  	// 		$_ddd[] = $i;
			  	// 	}	  		
			  	// }		  

			  	if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
			  		$_where_in_text .= ' and class_id in ('.implode(',', $_ddd).')'; 
			  	}else{
			  		$_where_in_text .= ' and pid in ('.implode(',', $_ddd).')'; 
			  	}

			}					
		}

		//處理資料
		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
				$this->cidb->where('type',$this->data['router_class']);
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('class_id',$_ddd);
				}			
			}else{
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('pid',$_ddd);
				}		
			}
		}else{
			$this->cidb->where('type',$this->data['router_class']);
		}

		$this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('sort_id',$_GET['id']);


		$this->cidb->delete($this->def['table']);		

		// 資料重新排序
		if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
			$this->cidb->query('update '.$this->def['table'].' set sort_id = sort_id - 1 where ml_key="'.$this->data['admin_switch_data_ml_key'].'" and type="'.$this->data['router_class'].'" '.$_where_in_text.' and sort_id > '.$_GET['id']);
		}else{
			$this->cidb->query('update '.$this->def['table'].' set sort_id = sort_id - 1 where ml_key="'.$this->data['admin_switch_data_ml_key'].'" '.$_where_in_text.' and sort_id > '.$_GET['id']);
		}
	}

	public function actionAjaxupdatedata($param='')
	{
		var_dump($_POST);

		// 前台主選單的資料表功能
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}

		$savedata1 = $_POST;

		foreach ($this->columndata() as $key => $value) {
			if(isset($savedata1[$key])){
				$savedata[$key] = $savedata1[$key];
				if(isset($value['no_data']) && $value['no_data']==true){
					unset($savedata[$key]);
				}
				if(isset($value['update_data_rename_id']) && $value['update_data_rename_id']!=''){
					$savedata[$value['update_data_rename_id']] = $savedata[$key];					
					unset($savedata[$key]);
				}				
			}			
		}

		$_type = $this->data['router_class'].'type';

		//節點ID
		if($rowg['other25']!=''){			
			if(isset($_SESSION[$this->data['router_class'].'_node']['value'])  && $_SESSION[$this->data['router_class'].'_node']['value']!=''){
				$_class_id = $_SESSION[$this->data['router_class'].'_node']['value'];
				//替換分類id
				$savedata['class_id'] = $_class_id;				
			}
			$_type = $rowg['other25'];
		}

		if(isset($_GET['class_id']) && $_GET['class_id']!=''){
			$_class_id = $_GET['class_id'];
		}

		//分類資料
		$_where_in_text = '';
		$_ddd = array();
		if(isset($_class_id) && $_class_id!=''){
			$_row_tmp = $this->cidb->where('id',$_class_id)->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type',$_type)->get('html')->row_array();

				  			  	
		  	if(isset($_row_tmp) && $_row_tmp){
			  	$_ddd[] = $_class_id;
			  	//客製
			  	// if($_row_tmp['other1']!='' && $_row_tmp['other2']!=''){
			  	// 	for ($i=$_row_tmp['other1']; $i <= $_row_tmp['other2'] ; $i++) { 
			  	// 		$_ddd[] = $i;
			  	// 	}	  		
			  	// }
			  
			  	if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
			  		$_where_in_text .= ' and class_id in ('.implode(',', $_ddd).')'; 
			  	}else{
			  		$_where_in_text .= ' and pid in ('.implode(',', $_ddd).')'; 
			  	}
			}					
		}		
		
		//處理資料
		if($rowg){
			if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){
				$this->cidb->where('type',$this->data['router_class']);
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('class_id',$_ddd);
				}			
			}else{
				//分類資料
				if(count($_ddd) > 0){
					$this->cidb->where_in('pid',$_ddd);
				}		
			}
		}else{
			$this->cidb->where('type',$this->data['router_class']);
		}
		$this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('sort_id',$savedata['sort_id']);

		$this->cidb->update($this->def['table'],$savedata);
	}



	protected function update_run_last($param='')
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_run_other_element($array)
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}


	protected function update_show_last($param='')
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

	}


	protected function getData()
	{
		$parameter = new Parameter_handle;
		$params = $parameter->get($this->data['router_param']);
		$param_define = $parameter->getDefine();

		// var_dump($params);

		// 先檢查編號對不對
		$id = 0;
		$row = $this->cidb->where('ml_key',$this->data['ml_key'])->where('type', $this->data['router_class'])->order_by('id','asc')->limit(1)->get('html')->row_array();

		if($row and isset($row['id'])){
			$id = $row['id'];
		} else {
			$save = array(
				'ml_key' => $this->data['ml_key'],
				'type' => $this->data['router_class'],
				'is_enable' => 0, //不當資料用
				'create_time' => date('Y-m-d'),
			);
			$this->cidb->insert('html', $save);
			$id = $this->cidb->insert_id();
		}

		if((isset($params['value'][0]) and $params['value'][0] != $id) or $this->data['router_class'] == 'index'){
			$url = $this->data['class_url'].'/update&param='.$param_define['value'].$id;
			$this->redirect($url);
		}
	}

	protected function update_show_first($params)
	{
		$this->getData();
	}


}

// 懶得改Controller的名稱之三
// eval('class '.$filename.' extends NonameController {}');
