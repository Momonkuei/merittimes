<?php

class Rulev1assignController extends Controller
{
	protected $def = array(
		//'title' => 'ml:Product',
		'table' => 'product',
		'orm' => 'G_product_orm',
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name_en'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name_en', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name_en', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'data_multilanguage_update' => 'model', // 在資料內頁中，切換多國語系，依照某一個欄位
		'sortable' => array(
			//'enable' => 'true',
			//'condition' => 'class_id = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=product/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield_attr' => array(
			//'smarty_include_top' => 'product/main_content_top.htm',
		),
		'listfield' => array(
			'name_en' => array(
				'label' => '商品名稱',
				'width' => '30%',
				'sort' => true,
			),
			'class_name' => array(
				'label' => '商品分類',
				'width' => '20%',
			),
			//'article' => array(
			//	'label' => 'Article',
			//	//'label_comment' => '會將通知信寄給使用者',
			//	'width' => '7%',
			//	'url_id' => 'article',
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
		// 定義修改要顯示的欄位
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate', 'fileuploader', 'jquery-ui', 
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
						'description' => array(
							'label' => '描述',
							'type' => 'label',
						),
						'param2' => array(
							'label' => '規則',
							'type' => 'label',
						),
						'param3' => array(
							'label' => '內容',
							'type' => 'input',
							'attr' => array(
								'id' => 'param3',
								'name' => 'param3',
								'size' => '70',
							),
						),
						'a' => array(
							'type' => 'hidden',
							'attr' => array(
								'name' => 'a',
							),
						),
					),
				),
			),
		), // updatefield
	);

	public function actionIndex($a,$id,$prev)
	{
		if(empty($_POST)){
			$this->data['def'] = $this->def;


			$row = $this->db->createCommand()->from($a.'_list')->where('is_enable=1 AND id=:id', array(':id'=>$id))->queryRow();

			$this->data['updatecontent'] = $row;
			$this->data['updatecontent']['a'] = $a;
			$this->data['prev_url'] = base64url::decode($prev);
			//var_dump($this->data['updatecontent']);
			$this->data['main_content'] = 'default/update';
			//$this->data['main_content'] = 'member/update';
			$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'&a='.$a.'&id='.$id.'&prev='.$prev;
			$this->display('index.htm', $this->data);
		} else {
			$update = $_POST;

			$empty_orm_data = array(
				'table' => $update['a'].'_list',
				//'created_field' => 'create_time', 
				//'updated_field' => 'update_time',
				'primary' => 'id',
				'rules' => array(
				),
			);

			eval($this->data['empty_orm_eval']);
			$c = new $name('insert', $empty_orm_data);
			$u = $c::model()->findByPk($update['hidden_id']);
			$u->setAttributes($update);

			// 做了這個動作，才會處理預設值等validator(像是處理create_time和update_time的動作)
			//if(!$u->validate()){
			//	G::dbm($u->getErrors());
			//}

			// save自己會做validate
			if(!$u->update()){
				G::dbm($u->getErrors());
			}

			// 為了要回去上一頁
			$prev_url = base64url::decode($prev);

			$redirect_url = $this->data['class_url'];
			if($prev_url != ''){
				$redirect_url = $prev_url;
			}

			$end_string = '';
			// 這行沒有加，在IE就會看到亂碼
			$end_string .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			$end_string .= '<script type="text/javascript">var base_url = "'.$this->data['base_url'].'";var ml_key = "'.$this->data['interface_ml_key'].'";</script>';
			$end_string .= '<script type="text/javascript" src="'.$this->data['base_url'].'/assets/language.js"></script>';
			$end_string .= '<script type="text/javascript">';
			$end_string .= 'alert("己修改");';
			$end_string .= 'window.location.href="'.$redirect_url.'";';
			$end_string .= '</script>';

			// 為了大陸的pinky而做的暫時性改變
			//$this->redirect($redirect_url);

			echo $end_string;
		}
	}

}
