<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

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
			'url' => 'backend.php?r=emailformat2/sort', // ajax post都會有個目標
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
			'topic' => array(
				'label' => '信件種類',
				'width' => '45%',
				'sort' => true,
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
				'jquery-validate',
				//'jquery-validate', 'jquery-ui', 'fileuploader', 'javascript-sortable', 'jyoutube', //'jstree',
			),
			'smarty_javascript' => '', // product/update_javascript.htm
			'smarty_javascript_text' => "
function showParams(strValue) {
　
  var temp_line = $('#detail').val();
  var strValue_temp = '{'+strValue+'}';
  //$('#mailtextarea').val(temp_line+strValue_temp) ;
  InsertContent('detail',strValue_temp);
}


function InsertContent(AreaID,Content)
{
    var myArea = document.getElementById(AreaID);
 
    //IE
    if (document.selection) 
   {
      myArea.focus();
      var mySelection =document.selection.createRange();
      mySelection.text = Content;
   }
   //FireFox
   else  
  {
     var myPrefix = myArea.value.substring(0, myArea.selectionStart);
     var mySuffix = myArea.value.substring(myArea.selectionEnd);
     myArea.value = myPrefix + Content + mySuffix;
   }
}
$('#other2').change(function(){
	showParams($(this).val());
	$('option:selected').removeAttr('selected');
});
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
						'topic' => array(
							'label' => '信件種類',
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'other1' => array(
							'label' => '欄位設定',
							'type' => 'input',
							'attr' => array(
								'id' => 'other1',
								'name' => 'other1',
								'size' => '40',
							),
							'other' => array(
								'html_end' => '*這個欄位只有百邇來公司員工看得到 (json格式 AAA:欄位 逗點分隔)',
							),
						),
						'other2' => array(
							'label' => '可用欄位',
							'type' => 'select3',
							'attr' => array(
								'id' => 'other2',
								//'name' => 'other2',
							),
							'other' => array(
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '0',
							),
						),
						'is_enable' => array(
							//'label' => 'ml:Status',
							'label' => '狀態',
							//'translate_source' => 'tw',
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
								'html_end' => '　　　　*這個欄位只有百邇來公司員工看得到',
							),
						),
						'XXX' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '
1. 純支援html排版，不支援css與class運用及javascript、JQuery 語法。<br />
2. 編輯好後，請先儲存後加以寄出測試信件。<br />
3. 預覽為參考畫面，實際信件請以實際寄出測試信件為主。<br />
',
							),
						),
				 		'detail' => array(
				 			'label' => 'HTML',
				 			'type' => 'textarea',
				 			//'type' => 'ckeditor_js',
				 			'attr' => array(
				 				'class' => 'form-control', // 這…手動加上去好了
				 				'id' => 'detail',
				 				'name' => 'detail',
				 				'rows' => '20',
				 				'cols' => '40',
				 			),
				 		),
						'other3' => array(
							'label' => '預覽',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
							),
						),
						'other4' => array(
							'label' => '測試信箱',
							'type' => 'input',
							'attr' => array(
								'id' => 'other4',
								'name' => 'other4',
								'size' => '30',
							),
						),
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$condition = ' type=\'emailformat2\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' type="emailformat2" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(trim($condition) != ''){
			$this->def['condition'][] = array(
				'where',
				$condition,
			);
		}
		if(trim($condition_sortable) != ''){
			$this->def['sortable']['condition'] = $condition_sortable;
		}

		if(isset($_GET['param'])){
			$parameter = new Parameter_handle;
			$params = $parameter->get($_GET['param']);
			if(isset($params['value'][0]) and $params['value'][0] > 0){
				$row = $this->cidb->where('id',$params['value'][0])->where('type','emailformat2')->get('html')->row_array();
				if($row and isset($row['other1']) and $row['other1'] != ''){
					$m_params2 = explode(',', $row['other1']);
					if($m_params2){
						$m_params2_tmp = array(); // 檢查有沒有重覆的key值
						foreach($m_params2 as $kkkk => $vvvv){
							if(preg_match('/^(.*)\:(.*)$/', $vvvv, $matches)){
								if(!isset($m_params2_tmp[$matches[1]])){
									$m_params2_tmp[$matches[1]] = '';
									$m_params2[$kkkk] = '"'.$matches[1].'":"'.$matches[2].'"';
								} else {
									// 2018-01-30 下午發現的，因為andwhere條件只能下一次
									$m_params2[$kkkk] = '"'.$matches[1].$kkkk.'":"'.$matches[2].'"';
								}
							}
						}
					}

					$aaa = json_decode('{'.implode(',',$m_params2).'}',true);
					foreach($aaa as $k => $v){
						$this->def['updatefield']['sections'][0]['field']['other2']['other']['values'][$k] = $v.' {'.$k.'}';
					}
				}
			}
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

	// 客製
	// protected function index_last($param='')
	// {
	// 	$row = $this->cidb->where('is_enable',1)->where('type','emailformat2')->where('ml_key',$this->data['admin_switch_data_ml_key'])->get('html')->row_array();

	// 	if($row){
	// 		header('Location: /_i/backend.php?r=emailformat2/update&param=v'.$row['id']);
	// 		die;
	// 	}
	// }

	protected function update_show_last($param='')
	{
		// 預覽
		$this->data['def']['updatefield']['sections'][0]['field']['other3']['other']['html'] = $this->data['updatecontent']['detail'];

		if(!preg_match('/^99999/', $this->data['admin_id'])){
			unset($this->data['def']['updatefield']['sections'][0]['field']['is_enable']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['other1']);
		}
	}

	protected function update_run_other_element($array)
	{

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		//$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();

		$subject = '測試：'.$array['topic'];
		$body_html = $array['detail'];
		$body = strip_tags($body_html);

		$tos = array(
			array(
				'id' => '',
				'name' => '測試：'.$array['topic'],
				'email' => $array['other4'],
			),
		);

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

		// 這個欄位不用存檔
		unset($array['other4']);

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];

		return $array;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
