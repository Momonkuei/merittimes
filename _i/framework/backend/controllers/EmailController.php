<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('log_errors','1');


// 收件和寄件人信箱設定
class EmailController extends Controller {

	protected $def = array(
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
			'url' => 'backend.php?r=email/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			//'pic1' => array(
			//	//'label' => '圖片',
			//	'mlabel' => array(
			//		null, // category
			//		'Image', // label
			//		array(), // sprintf
			//		'代表圖', // default
			//	),
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => false,
			//	'kcfinder_small_img' => true,
			//),
			'topic' => array(
				'label' => '姓名',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '12%',
				'sort' => true,
			),
			'other1' => array(
				'label' => '信箱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '20%',
				'sort' => true,
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
			'is_news' => array(
				'label' => '收件人',
				//'mlabel' => array(
				//	null, // category
				//	'Show News', // label
				//	array(), // sprintf
				//	'顯示在快訊', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'is_news',
				'ezother'=> '&nbsp;',
			),
			'is_home' => array(
				'label' => '寄件人',
				//'mlabel' => array(
				//	null, // category
				//	'Show Home', // label
				//	array(), // sprintf
				//	'顯示在首頁', // default
				//),
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
				'jquery-validate', 'fileuploader',
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
							'label' => '姓名',
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
								'size' => '12',
							),
						),
						'other1' => array(
							'label' => '信箱',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '40',
							),
						),
						//'url1' => array(
						//	'label' => '網址',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'url1',
						//		'name' => 'url1',
						//		'size' => '40',
						//	),
						//),
						//'pic1' => array(
						//	'label' => '圖片上傳：',
						//	'type' => 'fileuploader',
						//	'other' => array(
						//		'number' => '1',
						//		'type' => 'photo',
						//		'top_button' => '1',
						//		'width' => '360',
						//		'height' => '220',
						//		'comment_size' => '360x220',
						//		'no_ext' => '',
						//		'no_need_delete_button' => '',
						//	),
						//),
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
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'detail' => array(
				//			'label' => '內容',
				//			//'type' => 'textarea',
				//			'type' => 'ckeditor_js',
				//			'attr' => array(
				//				//'class' => 'form-control', // 這…手動加上去好了
				//				'id' => 'detail',
				//				'name' => 'detail',
				//				//'rows' => '4',
				//				//'cols' => '40',
				//			),
				//		),
				//	),
				//),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'type=\'email\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'type="email" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		$this->def['listfield_attr']['smarty_include_top_text'] = '
$aaa_xxx = <<<XXX
<script type="text/javascript">
$(document).ready(function() {

	//這個是複數(跨頁要去調整max_lenn變數)
	var min_lenn = 0 , max_lenn = 1;

	$("input[id$=\'is_home\']").on(\'click\',function(){

		if($(this).prop(\'checked\')){	
			min_lenn = min_lenn +1;										
		}else{
			min_lenn = min_lenn -1;						
		}

		if(min_lenn == max_lenn){
			$("input[id$=\'is_home\']").each(function(){
				if(!$(this).prop(\'checked\')){
					$(this).attr(\'disabled\',true);
					$(this).parent().parent().addClass(\'disabled\');		
				}
			});
		}else{
			$("input[id$=\'is_home\']").each(function(){				
				$(this).attr(\'disabled\',false);
				$(this).parent().parent().removeClass(\'disabled\');			
			});
		}
	});

	$("input[id$=\'is_home\']").each(function(){
		if($(this).prop(\'checked\')){
			min_lenn = min_lenn +1;
		}

		if(min_lenn >= max_lenn){
			$("input[id$=\'is_home\']").each(function(){
				if(!$(this).prop(\'checked\')){
					$(this).attr(\'disabled\',true);
					$(this).parent().parent().addClass(\'disabled\');
				}
			});
		}
	});	

	//這個是單一(不能跨頁)
	//$("input[id$=\'is_home\']").on(\'click\',function(){
	//	if($(this).prop(\'checked\')){
	//		$("input[id$=\'is_home\']").each(function(){
	//			if(!$(this).prop(\'checked\')){
	//				$(this).attr(\'disabled\',true);
	//				$(this).parent().parent().addClass(\'disabled\');
	//			}
	//		});
	//	}else{
	//		$("input[id$=\'is_home\']").each(function(){				
	//			$(this).attr(\'disabled\',false);
	//			$(this).parent().parent().removeClass(\'disabled\');			
	//		});
	//	}		
	//});
	
	//$("input[id$=\'is_home\']").each(function(){
	//	if($(this).prop(\'checked\')){
	//		$("input[id$=\'is_home\']").each(function(){
	//			if(!$(this).prop(\'checked\')){
	//				$(this).attr(\'disabled\',true);
	//				$(this).parent().parent().addClass(\'disabled\');
	//			}
	//		});
	//	}
	//});				

});
</script>
XXX;
echo $aaa_xxx;
';

		return true;
	}

	//protected function index_last()
	//{
	//	//var_dump($this->data['listcontent']);
	//	if($this->data['listcontent']){
	//		foreach($this->data['listcontent'] as $k => $v){
	//			if($v['pic1'] != ''){
	//				$v['pic1'] = $this->data['image_upload_path'].'/email/'.$v['pic1'];
	//			}
	//			$this->data['listcontent'][$k] = $v;
	//		}
	//	}
	//}

	protected function update_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = 'email';
		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = 'email';
		return $array;
	}

}
