<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

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
		'disable_create' => true,
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('topic'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'topic', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'topic', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		//'condition' => array(
		//	array(
		//		'where',
		//		'',
		//	),
		//),
		//'sortable' => array(
		//	'enable' => 'true',
		//	'condition' => '', // 有其它條件的時候，例如有商品分類
		//	'url' => 'backend.php?r=banner/sort', // ajax post都會有個目標
		//),
		'listfield' => array(
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
							//'label' => '標題',
							'mlabel' => array(
								null, // category
								'Title', // label
								array(), // sprintf
								'標題', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						//'other1' => array(
						//	'label' => '說明',
						//	//'mlabel' => array(
						//	//	null, // category
						//	//	'Title', // label
						//	//	array(), // sprintf
						//	//	'標題', // default
						//	//),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'other1',
						//		'name' => 'other1',
						//		'size' => '40',
						//	),
						//),
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
						'pic1' => array(
							'label' => '圖片上傳：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
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

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		//$this->def['table'] = $this->data['router_class'];
		//$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		//if(isset($this->def['sortable'])){
		//	$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		//}

		// 無法帶入的變數中的變數，在這裡帶入
		//$this->def['condition'][0][0] = 'where';
		//$this->def['condition'][0][1] = 'type=\'banner\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$this->def['sortable']['condition'] = 'type="banner" and ml_key="'.$this->data['admin_switch_data_ml_key'].'"';

		return true;
	}

	public function actionIndex($param = '')
	{
		$parameter = new Parameter_handle;
		$params = $parameter->get($param);
		$param_define = $parameter->getDefine();

		$this->data['def'] = G::definit($this->def, $this->data);
		$this->data['params'] = $params;
		$this->data['parameter'] = $param_define;
		//$this->data['router_method_view'] = '1';


		//$rows = $this->db->createCommand()->from('member')->where('is_enable=1 and id='.$_SESSION['authw_admin_id'])->queryAll();

		$updatecontent = array();

		//if($rows and count($rows) > 0){
		//	$updatecontent = $rows[0];
		//}

		//$updatecontent['plan_id'] = $this->def['updatefield']['sections'][$this->data['section_map']['company']]['field']['plan_id']['other']['default'];
		//$updatecontent['payment_type'] = $this->def['updatefield']['sections'][$this->data['section_map']['company']]['field']['payment_type']['other']['default'];

		$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules']);

		$this->data['updatecontent'] = $updatecontent;
		$this->data['jqueryvalidation'] = json_encode($validation);

		//var_dump($updatecontent);

		// 給rander前台的field，呈現必填的星號部份
        $this->data['updatecontent_jqueryvalidation'] = $validation;
		if($this->main_content_exists($this->data['main_content'], $this->data) === false){
			$this->data['main_content'] = 'default/update';
			//$this->data['main_content'] = 'member/update';
		}

		// debug
		//$this->data['main_content'] = 'default/update';

		//$this->data['main_content_title'] = $this->data['def']['title'];
		//$this->display('index.htm', $this->data);
		$this->render('//'.$this->data['router_class'].'2/index', $this->data);

	} // update

	public function actionAjax()
	{
		$Years = explode("|", $_POST["Years"]);
		$YearsTotal = array();
		$tMax = 0;
		$ceilMaxTotal = 0;
		foreach ($Years as $key => $value) 
		{
			for($ii=1;$ii<=12;$ii++)
			{
				$sql = "SELECT SUM(total) as mTotal FROM `shoporderform` WHERE is_enable=1 and Year(create_time)='".$value."' and Month(create_time)='".$ii."'";
				//$mTotal = $DB->queryFirstField($sql,1,$value,$ii);
				$mTotal_tmp = $this->cidb->query($sql)->row_array();
				$mTotal = $mTotal_tmp['mTotal'];
				if($mTotal) if($tMax < $mTotal) $tMax = $mTotal;
				$YearsTotal[$value][$ii]=$mTotal;
			}
		}
		if($YearsTotal) {
			foreach ($YearsTotal as $key => $value) {

				$tmp=array();
				foreach ($value as $k => $v) {
					$tmp1 = array();
					$tmp1[]=$k;
					$tmp1[]=$v?$v:0;
					$tmp[]=$tmp1;
				}
				$Data[$key] = $tmp;
				$LabelAry[]=$key." 年";
				$iData[]=array("data"=>$tmp,"label"=>$key." 年");
			}
		}
		 
		$ceilMaxTotal = ceil($tMax / 10000) * 10000;
		echo json_encode(array("Max"=>$ceilMaxTotal,"Data"=>$iData));

		die;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
