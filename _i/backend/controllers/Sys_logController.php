<?php

/*
 * 2020-02-10
 */
// require_once('phpSpreadsheet/autoload.php');
// 
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// 這裡維持註解
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xls;
// use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
// use PhpOffice\PhpSpreadsheet\Cell\DataType;
// use PhpOffice\PhpSpreadsheet\Style\Fill;
// use PhpOffice\PhpSpreadsheet\Style\Color;
// use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Style\Border;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


$tmps = explode('/',str_replace('\\','/',__FILE__));
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

// $tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
// $filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'disable_create' => true,
        'disable_delete' => true,

		// 在各功能的上面的新增的右邊(匯出功能之一)
		// 'index_buttons' => array(
		// 	array(
		// 		'name' => '匯出<i class="icon-external-link"></i>',  // 按鈕的名稱和圖示
		// 		'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
		// 		'id' => '', // button
		// 		'class' => 'btn btn-info', // button
		// 		// 'onclick' => 'javascript:location.href=\'XXX\'',
		//		'onclick' => 'javascript:location.href=\'backend.php?r=newsletter/excelexport2\'',
		// 	),
		// ),

		'table' => 'sys_log',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'sys_log',
			'created_field' => 'create_time', 
			// 'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				// array('topic', 'required'),
				// array('detail', 'system.backend.extensions.myvalidators.numericcodeutf8'),
				// array('start_date', 'date', 'format'=>'yyyy-M-d'),
				// array('phone','numerical','integerOnly'=>true),
			),
		),
		'enable_delete' => false, // 多選刪除
		'default_sort_field' => 'create_time', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('log_code','log_msg','ip_addr'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'log_code', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		// 'sys_log_name' => 'XXX', // 要給sys_log記錄名稱欄位值的設定
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
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
			// 'xx_id' => array(
			// 	'label' => 'Number ID',
			// 	'translate_source' => 'en',
			// 	'width' => '9%',
			// 	'align' => 'center',
			// 	//'ezdelete' => true,
			// ),
			// 'pic1' => array(
			// 	'label' => 'Image',
			// 	'translate_source' => 'en',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Image', // label
			// 	//	array(), // sprintf
			// 	//	'代表圖', // default
			// 	//),
			// 	'width' => '10%',
			// 	'align' => 'center',
			// 	'sort' => false,
			// 	'kcfinder_small_img' => true,
			// ),
			// 'topic' => array(
			// 	'label' => 'Heading',
			// 	'translate_source' => 'en',
			// 	//'mlabel' => array(
			// 	//	null, // category
			// 	//	'Title', // label
			// 	//	array(), // sprintf
			// 	//	'標題', // default
			// 	//),
			// 	'width' => '45%',
			// 	'sort' => true,
			// ),
			'user_id' => array(
				'label' => '使用者',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				// 'sort' => true,
			),
			'ip_addr' => array(
				'label' => 'IP',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '10%',
				// 'sort' => true,
			),
			'log_code' => array(
				'label' => '功能',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '20%',
				// 'sort' => true,
			),
			'log_msg' => array(
				'label' => '訊息',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '45%',
				// 'sort' => true,
			),
			
			'create_time' => array(
				'label' => '建立時間',
				'translate_source' => 'en',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '45%',
				// 'sort' => true,
			),
			
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
				// section
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'field' => array(
						'user_id' => array(
							'label' => '使用者',
							'translate_source' => 'en',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'sort' => true,
						),
						'ip_addr' => array(
							'label' => 'IP',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'attr' => array(
							// 	'id' => 'name',
							// 	'name' => 'name',
							// 	'size' => '40',
							// ),
						),
						'log_code' => array(
							'label' => '功能',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'attr' => array(
							// 	'id' => 'name',
							// 	'name' => 'name',
							// 	'size' => '40',
							// ),
						),
						'log_msg' => array(
							'label' => '訊息',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'attr' => array(
							// 	'id' => 'name',
							// 	'name' => 'name',
							// 	'size' => '40',
							// ),
						),
						
						'log_1' => array(
							'label' => '修改前備份(上半段)',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'attr' => array(
							// 	'id' => 'name',
							// 	'name' => 'name',
							// 	'size' => '40',
							// ),
						),
						'log_2' => array(
							'label' => '修改前備份(下半段)',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'attr' => array(
							// 	'id' => 'name',
							// 	'name' => 'name',
							// 	'size' => '40',
							// ),
						),
						'log2_1' => array(
							'label' => '修改後備份(上半段)',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'attr' => array(
							// 	'id' => 'name',
							// 	'name' => 'name',
							// 	'size' => '40',
							// ),
						),
						'log2_2' => array(
							'label' => '修改後備份(下半段)',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'label',
							// 'attr' => array(
							// 	'id' => 'name',
							// 	'name' => 'name',
							// 	'size' => '40',
							// ),
						),

												
						// '_contentbuilder' => array(
						// 	'label' => '',
						// 	'type' => 'inputn',
						// 	'other' => array(
						// 		'html'=>'<div class="control-box"><button type="button" id="htmlbtn" onclick="openif(\'detail\')">+ 加入範本</button><input type="hidden" id="ctidx" value=""><div id="ctarea" style="display: none;" ></div>',	
						// 	),
						// ),	
										
						
					),
				),
				// funcfieldv3的產出欄位，放在任何位置都可以
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
					),
				),
				
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		
		parent::beforeAction($action);		

		$this->def['updatefield']['smarty_javascript_text'] = <<<XXX
$('.indexgo03').find('button').eq(0).remove();
$('.indexgo03').find('button').eq(0).remove();
XXX;

		
		// funcfieldv3
		// $contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		// $contentx = str_replace('<'.'?'.'php', '', $contentx);
		// eval($contentx);

// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		// var_dump($session);die;

		$condition = ' 1 ';
		$condition_sortable = ' 1 ';
		//2021/1/8 by lota
		// $condition = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		// $condition_sortable = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';

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
					$conditions[] = ' ( log_code LIKE \'%'.$v.'%\' or log_msg LIKE \'%'.$v.'%\'or ip_addr LIKE \'%'.$v.'%\' ) ';
					// $conditions_sortable[] = ' ( name LIKE "%'.$v.'%" or name LIKE "%'.$v.'%" ) ';
				// } elseif($k == 'checkbox_is_dirty_ip'){
				// 	$conditions[] = 'is_dirty_ip=0';
				// 	$conditions_sortable[] = 'is_dirty_ip=0';
				// } elseif($k == 'checkbox_has_dirty_keyword'){
				// 	$conditions[] = 'has_dirty_keyword<1';
				// 	$conditions_sortable[] = 'has_dirty_keyword<1';
				// } else {
				// 	$conditions[] = $k.' LIKE \'%'.$v.'%\'';
				// 	$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
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
		
		// $user = $this->cidb->where('id' , )->get('member')->row_array();
		
		// if(isset($user)){
		// 	$this->def['listfield']['user_id'] = $user['name'];
		// }

		
		return true;
	}

	protected function index_last($param='')
	{
		// print_r($this->data['def']);die;
		//var_dump($this->data['listcontent']);
		// #46369 社群分享--撈資料-----------------------------------------------------------------
		if($this->data['router_class']=='community'){
			$listcontent_tmp=array();
			$index_data = $this->db->createCommand()->from('html')->where('topic=:topic and ml_key=:ml_key and type=:type', array(':topic'=>'首頁',':ml_key'=>$this->data['ml_key'],':type'=>'webmenu'))->queryRow();
			$listcontent_tmp[0]=$index_data;
			$a=1;
			foreach($this->data['listcontent'] as $k => $v){
				$listcontent_tmp[$a]=$v;
				$a++;
			}
			$this->data['listcontent']=$listcontent_tmp;
		}	
		unset($rowg);
		if(isset($this->data['rowg_custom'])){
			$rowg = $this->data['rowg_custom'];
		} else {
			$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		}
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
				// var_dump($v);
				//編號(非流水號)
				$_page_gg = ($this->data['params']['page'] - 1) * $this->data['record'];
				$v['xx_id'] = $k + 1 + $_page_gg;
				
				if(isset($v['pic1']) and $v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				//這邊先做通用的，獨立的以後再說 by lota
				if($show_type_mode > 0 and $v['class_id'] > 0){

					$type_name = $this->data['router_class'].'type';
					if(isset($rowg['other22']) and $rowg['other22'] != ''){
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

				// 商品複製
				// 2017-07-20 李哥說，要加上授權，就是99999開頭的都要加
				if(0 and preg_match('/^99999/', $this->data['admin_id'])){
					$v['_enable_custom_button_copy'] = '<a href="'.$this->createUrl($this->data['router_class'].'/update',array('param'=>'v'.$v['id'].'-vcopy')).'" class="btn default btn-xs blue"><i class="icon-copy"></i> '.G::_('Copy', 'en').'</a>';
				}

				$user = $this->cidb->where('id' ,$v['user_id'] )->get('member')->row_array();
				// var_dump($user);die;
				if(!empty($user)){
					$v['user_id'] = $user['name'];
				}

				$tmp = explode('/' , $v['log_code']);
				$admin_menu = $this->cidb->select('name')->like('link' ,  $tmp['0'])->get('admin_menu')->row_array();
				// print_r($admin_menu); die;
				
				if(!empty($admin_menu)){
					$v['log_code'] = $admin_menu['name'];
				}elseif($v['log_code'] == "auth/login"){
					$v['log_code'] = "登入";
				}
				
				//Ming 2018-12-18 來信 指示 列表的標題文字，點擊後可另開視窗顯示前台畫面  ( 所有單元都是 ) 
				//if(preg_match('/^video|location|graphics|faq|download/', $this->data['router_class'])){
				//	if($show_type_mode > 0 and $v['class_id'] > 0){
				//		$_href = '/'.$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['class_id'];						
				//	}else{
				//		$_href = '/'.$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php';
				//	}
				//}else{					
				//	$_href = '/'.$this->data['router_class'].'detail_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['id'];					
				//}
				//$v['topic'] = '<a href="'.$_href.'" target="_BREAK">'.$v['topic'].'</a>';

				$this->data['listcontent'][$k] = $v;
			}
		}
		// var_dump($this->data['listcontent']);die;
		// $this->data['main_content'] = 'default/index';

		// 2021-01-20 #38699 匯入後，一次性的依照日期重排資料
		if(0 and $this->data['router_class'] == 'news'){
			$rows = $this->cidb->where('type','news')->where('ml_key',$this->data['admin_switch_data_ml_key'])->order_by('date1','desc')->get('html')->result_array();
			$ids_tmp = array();
			if($rows){
				foreach($rows as $k => $v){
					$ids_tmp[$v['id']] = ($k+1);
				}
			}
			if(!empty($ids_tmp)){
				foreach($ids_tmp as $k => $v){
					$this->cidb->where('id', $k);
					$this->cidb->update('html', array('sort_id' => $v));
				}
			}
		}
		
		// print_r($this->data['listcontent']);die;
		//----------------------------------------------------------------------------------------
	}

	public function actionSearch()
	{
		// print_r($_POST);die;
		if(!empty($_POST)){
			$ss = $this->data['router_class'].'_search';
			$session = Yii::app()->session[$ss];
			if($session === null){
				$session = array();
			}
			// 處理一下checkbox的欄位
			if($session){
				foreach($session as $k => $v){
					if(preg_match('/^checkbox_/', $k)){
						unset($session[$k]);
					}
				}
			}
			foreach($_POST as $k => $v){
				$session[$k] = $v;
			}
			Yii::app()->session[$ss] = $session;

			// 前台主選單的資料表功能
			unset($rowg);
			if(isset($this->data['rowg_custom'])){
				$rowg = $this->data['rowg_custom'];
			} else {
				$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['router_class'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
			}

			if($rowg){
				if(isset($rowg['other26']) and $rowg['other26'] == '1'){ // 是否為“多分類排序”
					// [多分類排序]
					if(isset($session) and !empty($session)){
						$conditions = array();
						$conditions_sortable = array();
						foreach($session as $k => $v){
							if($v == '') unset($session[$k]);
							if($k == 'class_id' and $v == -1) unset($session[$k]);
							if($k == 'class_id' and $v == 0) unset($session[$k]);
							if($k == 'icon' and $v == '') unset($session[$k]);
						}
					}
					// 這邊只限定只有一個搜尋條件，而且是class_id 才能排序，如果有增加搜尋條件，記得在上面unset - 判斷2 (整隻程式有三個判斷) by lota
					if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
						// 把該分類的sort_id洗掉，然後載入多分類排序資料表的資料，然後更新它
						$class_id = $session['class_id'];
						$rows = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id='.$class_id)->order('sort_id')->queryAll();
						if($rows){
							foreach($rows as $k => $v){
								// $data = array(
								// 	$this->def['func_field']['sort_id'] => $v[$this->def['func_field']['sort_id']],
								// );
								// $this->cidb->where('id',$v['product_id'])->update($this->data['router_class'], $data);
								// $this->cidb->query('update '.$this->data['router_class'].' set sort_id='.$v['sort_id'].' where id='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');

								$this->cidb->query('update '.$this->def['table'].' set '.$this->def['func_field']['sort_id'].'='.$v[$this->def['func_field']['sort_id']].' where '.$this->def['func_field']['id'].'='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
							}
						}
					}
				}
			}

			$this->redirect($this->createUrl($this->data['router_class'].'/index'));
		}
	}


}


eval('class '.$filename.' extends NonameController {}');

// eval('class '.$filename.' extends NonameController {}');
