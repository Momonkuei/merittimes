<?php

class ContactuswebController extends Controller {

	protected $def = array(
		//'title' => 'ml:Product',
		'disable_create' => true,
		'enable_edit_button_changeto_view_button' => true,
		//'disable_edit' => true,
		//'enable_view' => true, // 預設View按鈕是不出現的，剛好跟edit和delete是相反的，除非你打開它
		'table' => 'contactus_web',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'contactus_web',
			'created_field' => 'create_time', 
			// 'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('name, phone, email', 'required'),
			),
		),
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
			//'ml_key' => array(
			//	//'label' => 'ml:Language',
			//	'label' => '語　　系',
			//	'width' => '10%',
			//	'align' => 'center',
			//	//'sort' => true,
			//	'mls' => true,
			//),
			'name' => array(
				//'label' => '姓名',
				'mlabel' => array(
					null, // category
					'Full name', // label
					array(), // sprintf
					'姓名', // default
				),
				'width' => '20%',
				'sort' => true,
			),
			'know' => array(
				'label' => '連絡時間',
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
				//'label' => '電話',
				'mlabel' => array(
					null, // category
					'Phone', // label
					array(), // sprintf
					'電話', // default
				),
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
			'create_time' => array(
				//'label' => '日期時間',
				'mlabel' => array(
					null, // category
					'Create time', // label
					array(), // sprintf
					'日期時間', // default
				),
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
						//'ml_key' => array(
						//	'label' => '語系',
						//	'type' => 'mls',
						//),
						//'company_name' => array(
						//	//'label' => '公司',
						//	'mlabel' => array(
						//		null, // category
						//		'Company', // label
						//		array(), // sprintf
						//		'公司', // default
						//	),
						//	'type' => 'label',
						//	'attr' => array(
						//		'id' => 'company_name',
						//		'name' => 'company_name',
						//		//'size' => '40',
						//	),
						//),
						'question' => array(
							'label' => '問題分類',
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
						'name' => array(
							//'label' => '姓名',
							'mlabel' => array(
								null, // category
								'Full name', // label
								array(), // sprintf
								'姓名', // default
							),
							'type' => 'label',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								//'size' => '40',
							),
						),
						//'sex' => array(
						//	'label' => '性別',
						//	'type' => 'label',
						//	'attr' => array(
						//		'id' => 'sex',
						//		'name' => 'sex',
						//		//'size' => '40',
						//	),
						//),
						'phone' => array(
							//'label' => '電話',
							'mlabel' => array(
								null, // category
								'Phone', // label
								array(), // sprintf
								'電話', // default
							),
							'type' => 'label',
							'attr' => array(
								'id' => 'phone',
								'name' => 'phone',
								//'size' => '40',
							),
						),
						//'addr' => array(
						//	'label' => '縣市地區',
						//	'type' => 'label',
						//	'attr' => array(
						//		'id' => 'addr',
						//		'name' => 'addr',
						//		//'size' => '40',
						//	),
						//),
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
						//'url' => array(
						//	'label' => '網址',
						//	'type' => 'label',
						//	'attr' => array(
						//		'id' => 'url',
						//		'name' => 'url',
						//		//'size' => '40',
						//	),
						//),
						'know' => array(
							'label' => '連絡時間',
							'type' => 'label',
							'attr' => array(
								'id' => 'know',
								'name' => 'know',
								//'size' => '40',
							),
						),
						//'sort_id' => array(
						//	//'label' => 'ml:Sort',
						//	'mlabel' => array(
						//		null, // category
						//		'Sort', // label
						//		array(), // sprintf
						//		'排序', // default
						//	),
						//	'type' => 'sort',
						//	'attr' => array(
						//	),
						//),
						//'file1' => array(
						//	'label' => '顯示在首頁',
						//	'type' => 'status',
						//	'attr' => array(
						//		'id' => 'file1',
						//		'name' => 'file1',
						//	),
						//	'other' => array(
						//		'other1' => '顯示',
						//		'other2' => '否',
						//		'default' => '0',
						//	),
						//),
						//'is_enable' => array(
						//	//'label' => 'ml:Status',
						//	'mlabel' => array(
						//		null, // category
						//		'Status', // label
						//		array(), // sprintf
						//		'狀態', // default
						//	),
						//	'type' => 'status',
						//	'attr' => array(
						//		'id' => 'is_enable',
						//		'name' => 'is_enable',
						//	),
						//	'other' => array(
						//		'default'=>'1',
						//	),
						//),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						//'newspic' => array(
						//	'label' => '圖片',
						//	'type' => 'fileuploader_multi',
						//	'other' => array(
						//		'type' => 'image',
						//		'number' => '1',
						//		'width' => '150',
						//		'height' => '150',
						//		'comment_size' => '400x400',
						//		'no_ext' => '',
						//	),
						//	'other2' => array(
						//		'topic' => array(
						//			'type' => 'text',
						//			'label' => '標題',
						//		),
						//		//'is_home' => array(
						//		//	'type' => 'radio',
						//		//	'label' => '首頁',
						//		//	'other' => array(
						//		//		array(
						//		//			'label' => '顯示',
						//		//			'value' => '1',
						//		//		),
						//		//		array(
						//		//			'label' => '不顯示',
						//		//			'value' => '0',
						//		//		),
						//		//	),
						//		//),
						//	),
						//),
						'detail' => array(
							'label' => '訊息內容',
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
						'reply_ok_datetime' => array(
							'label' => '<br />回覆時間',
							//'mlabel' => array(
							//	null, // category
							//	'Description', // label
							//	array(), // sprintf
							//	'描述', // default
							//),
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'detail',
							//	'name' => 'detail',
							//),
						),
						'reply_ok' => array(
							'label' => '回覆',
							//'mlabel' => array(
							//	null, // category
							//	'Description', // label
							//	array(), // sprintf
							//	'描述', // default
							//),
							'type' => 'label',
							//'attr' => array(
							//	'id' => 'detail',
							//	'name' => 'detail',
							//),
						),
						'reply' => array(
							'label' => '<br />回覆',
							'type' => 'textarea',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'reply',
								'name' => 'reply',
								//'style' => 'resize: none;',
								'rows' => '4',
								'cols' => '40',
							),
							//'type' => 'ckeditor_js',
							//'attr' => array(
							//	'id' => 'traffic',
							//	'name' => 'traffic',
							//),
						),
					),
				),
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$this->def['listfield_attr']['smarty_include_top_text'] = '
$aaa_xxx = <<<XXX
<script type="text/javascript">
$(document).ready(function() {
	$(".t_add").remove();
	$(".del_button").each(function(){
		$(this).remove();
	});
});
</script>
XXX;
echo $aaa_xxx;
';

		//$this->def['updatefield']['smarty_javascript_text'] = <<<XXX
		// $('.indexgo03').find('button').eq(0).remove();
		// $('.indexgo03').find('button').eq(0).remove();
		// XXX;


		return true;
	}

	protected function update_show_last()
	{
		if($this->data['updatecontent']['reply'] == ''){
			unset($this->data['def']['updatefield']['sections'][1]['field']['reply_ok']);
			unset($this->data['def']['updatefield']['sections'][1]['field']['reply_ok_datetime']);
		} else {
			unset($this->data['def']['updatefield']['sections'][1]['field']['reply']);
			$this->data['updatecontent']['reply_ok'] = '<br />'.nl2br($this->data['updatecontent']['reply']);
			$this->data['updatecontent']['reply_ok_datetime'] = $this->data['updatecontent']['update_time'];
			$this->data['def']['updatefield']['smarty_javascript_text'] = <<<XXX
$('.indexgo03').find('button').eq(0).remove();
$('.indexgo03').find('button').eq(0).remove();
XXX;
		}
	}

	protected function update_run_last()
	{
		//if(isset($this->data['def']['listfield']['sort_id']) and isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
		//	// 取得數量，用在排序的編號產出
		//	$this->data['def']['condition'][0][1] = $_POST['pid'];
		//}

		$old_u = $this->db->createCommand()->from($this->data['def']['table'])->where('id=:id',array(':id'=>$this->data['id']))->queryRow();

		if(isset($_POST['reply']) and $_POST['reply'] != '' and isset($old_u['email']) and $old_u['email'] != ''){

			//$old_u[$sort_field];

			$body = $_POST['reply'];
			$body_html_content = nl2br($_POST['reply']);

			// 寄件人、網站管理者Mail
			//$to = $this->data['sys_configs']['service_admin_mail'];
			$to = $old_u['email'];

			// 主旨
			$subject = $this->data['sys_configs']['admin_title'].' Contact Us 客戶聯絡信件回覆';

			$aaa_url = aaa_url;
			$aaa_name = $this->data['sys_configs']['admin_title'];

			$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
$body_html_content
<p style="font-size:13px;color:#999"">$aaa_name $aaa_url</p>
XXX;

			// 找一下寄件人有沒有設定
			$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

			// 找一下收件人有沒有設定
			//$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

			//設定cc收件者
			if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true)
				$cc_mail = $savedata['email'];
			else
				$cc_mail = NULL;

			if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
				and $tos and count($tos) > 0 and isset($tos[0]['id'])){
				die;
				// if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
				// 	$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html);
				// } else {
				// 	$tos[] = array(
				// 		'name' => $old_u['name'],
				// 		'email' => $old_u['email'],
				// 	);
				// 	$this->email_send_to_v2($from,$tos, $subject, $body, $body_html);
				// }
			} else {	
				// $this->email_send_to($to, $subject, $body, $body_html);
				$this->email_send_to_by_sendmail($from,$tos=array(array('name'=>'','email'=>$to)), $subject, $body, $body_html,$cc_mail);
			}

		}
	} // update_run_last


	//protected function update_run_other_element($array)
	//{
	//	$array['ml_key'] = $this->data['ml_key'];
	//	$array['type'] = 'abouteob';
	//	return $array;
	//}

	//protected function create_run_other_element($array)
	//{
	//	$array['ml_key'] = $this->data['ml_key'];
	//	$array['type'] = 'abouteob';
	//	return $array;
	//}

}
