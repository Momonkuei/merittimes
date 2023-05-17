<?php

/*
 * 單頁文章(多國語系)
 */

/*
使用方式
//$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/').'Funcfieldv2update1Controller.php');
$contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/').target_app_name.ds('/controllers/').'ArticlesingleController.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
$contentx = str_replace('Articlesingle', 'Articlexxxsingle', $contentx); // class extents
$contentx = str_replace('articlesingle', 'company', $contentx); // 欄位
eval($contentx);
class CompanyController extends ArticlexxxsingleController
{
}
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

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

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
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

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
		/*
		$this->data['BODY_END'] = '<iframe name="cbiframe" id="cbiframe" style="width: 100%; height: 100%; position: absolute; top: 0px; left: 0px; border: 0px;display: none;"  src="" ></iframe>
		<script type="text/javascript" src="/_i/assets/contenvuilder.js"></script>';
		*/
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

	protected function getData()
	{
		$parameter = new Parameter_handle;
		$params = $parameter->get($this->data['router_param']);
		$param_define = $parameter->getDefine();

		// var_dump($params);

		// 先檢查編號對不對
		$id = 0;
		$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type', $this->data['router_class'])->order_by('id','asc')->limit(1)->get('html')->row_array();

		if($row and isset($row['id'])){
			$id = $row['id'];
		} else {
			$save = array(
				'ml_key' => $this->data['ml_key'],
				'type' => $this->data['router_class'],
				'is_enable' => 1,
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

	public function actionIndex($param='')
	{
		$this->getData();
	}

	protected function update_show_first($params)
	{
		$this->getData();
	}

}

// 懶得改Controller的名稱之三
// eval('class '.$filename.' extends NonameController {}');
