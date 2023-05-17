<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,
		'disable_create' => true,
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
		//$query = "select (SELECT count('*') FROM  `".$LANG_DB."customer` WHERE  `sex` = 'M') as men,(SELECT count('*') as weman FROM  `".$LANG_DB."customer` WHERE  `sex` = 'F') as women";
		//$SexData = $this->db->createCommand($query)->queryRow();
		//$SexData = $DB->queryFirstRow($query);

		$query = "select (SELECT count('*') FROM  `customer` WHERE  `gender` = '1') as men,(SELECT count('*') as weman FROM  `customer` WHERE  `gender` = '2') as women";
		$SexData = $this->cidb->query($query)->row_array();

		//file_put_contents('123.txt',var_export($SexData,true),FILE_APPEND);

		if($SexData["men"] >= $SexData["women"]) $MaxSexNum = $SexData["men"];
		else $MaxSexNum = $SexData["women"];
		
		//file_put_contents('123.txt',var_export($SexData,true),FILE_APPEND);

		/*php 7 飛船寫法
		switch ($SexData["men"] <=> $SexData['women']) {
			case 1:
				$MaxSexNum = $SexData["men"];
				break;
			case 0:
				$MaxSexNum = $SexData["men"];
			case -1;
				$MaxSexNum = $SexData["women"];
			default:
				# code...
				break;
		} */
		$MaxSexNum = ceil($MaxSexNum / 10) * 10;

		$query = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) < 21 ";
		$query_1 = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) between 21 and 30 ";
		$query_2 = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) between 31 and 40 ";
		$query_3 = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) > 41 ";

		// $age = $DB->queryFirstField($query);
		// $age_1 = $DB->queryFirstField($query_1);
		// $age_2 = $DB->queryFirstField($query_2);
		// $age_3 = $DB->queryFirstField($query_3);

		$age = $this->cidb->query($query)->row_array();
		$age_1 = $this->cidb->query($query_1)->row_array();
		$age_2 = $this->cidb->query($query_2)->row_array();
		$age_3 = $this->cidb->query($query_3)->row_array();

		$AgeData[]=array("data"=>$age['age'],"label"=>"20歲以下");
		$AgeData[]=array("data"=>$age_1['age'],"label"=>"21歲~30歲");
		$AgeData[]=array("data"=>$age_2['age'],"label"=>"31歲~40歲");
		$AgeData[]=array("data"=>$age_3['age'],"label"=>"40歲以以上");
		

		$query = "SELECT `addr_zipcode` as zip, count(`addr_zipcode`) as cnt FROM `customer` GROUP BY `zip`";
		//$row = $DB->query($query);
		$row = $this->cidb->query($query)->result_array();
		//print_r($row);

		$Taipei_city = 0;
		$Keelung = 0;
		$Taipei = 0;
		$Ilan = 0;
		$Hsinchu = 0;
		$Taoyuan = 0;
		$Miaoli = 0;
		$Taichung_city = 0;
		$Changhua = 0;
		$Nantou = 0;
		$Chiayi = 0;
		$Yunlin = 0;
		$Tainan = 0;
		$Kaohsiung = 0;
		$Kaohsiung = 0;
		$Penghu = 0;
		$Pingtung = 0;
		$Taitung = 0;
		$Hualien = 0;
		$Gammon = 0;
		$Lianjiang = 0;
		$South_Island = 0;
		$Diaoyu_Islands = 0;

		if($row) {
			foreach ($row as $key => $value) {
				if($value["zip"] >= 100 && $value["zip"] <= 116){
					$Taipei_city += $value["cnt"];
				}else if($value["zip"] >= 200 && $value["zip"] <= 206){
					$Keelung += $value["cnt"];
				}else if($value["zip"] >= 207 && $value["zip"] <= 208){
					$Taipei += $value["cnt"];
				}else if($value["zip"] >= 213 && $value["zip"] <= 253){
					$Taipei += $value["cnt"];
				}else if($value["zip"] >= 260 && $value["zip"] <= 272){
					$Ilan += $value["cnt"];
				}else if($value["zip"] >= 300 && $value["zip"] <= 315){
					$Hsinchu += $value["cnt"];
				}else if($value["zip"] >= 320 && $value["zip"] <= 338){
					$Taoyuan += $value["cnt"];
				}else if($value["zip"] >= 350 && $value["zip"] <= 369){
					$Miaoli += $value["cnt"];
				}else if($value["zip"] >= 400 && $value["zip"] <= 439){
					$Taichung_city += $value["cnt"];
				}else if($value["zip"] >= 500 && $value["zip"] <= 530){
					$Changhua += $value["cnt"];
				}else if($value["zip"] >= 540 && $value["zip"] <= 558){
					$Nantou += $value["cnt"];
				}else if($value["zip"] >= 600 && $value["zip"] <= 625){
					$Chiayi += $value["cnt"];
				}else if($value["zip"] >= 630 && $value["zip"] <= 655){
					$Yunlin += $value["cnt"];
				}else if($value["zip"] >= 700 && $value["zip"] <= 745){
					$Tainan += $value["cnt"];
				}else if($value["zip"] >= 800 && $value["zip"] <= 816){
					$Kaohsiung += $value["cnt"];
				}else if($value["zip"] >= 820 && $value["zip"] <= 852){
					$Kaohsiung += $value["cnt"];
				}else if($value["zip"] >= 880 && $value["zip"] <= 885){
					$Penghu += $value["cnt"];
				}else if($value["zip"] >= 900 && $value["zip"] <= 947){
					$Pingtung += $value["cnt"];
				}else if($value["zip"] >= 950 && $value["zip"] <= 966){
					$Taitung += $value["cnt"];
				}else if($value["zip"] >= 970 && $value["zip"] <= 983){
					$Hualien += $value["cnt"];
				}else if($value["zip"] >= 890 && $value["zip"] <= 896){
					$Gammon += $value["cnt"];
				}else if($value["zip"] >= 209 && $value["zip"] <= 212){
					$Lianjiang += $value["cnt"];
				}else if($value["zip"] >= 817 && $value["zip"] <= 819){
					$South_Island += $value["cnt"];
				}else if($value["zip"] == 290){
					$Diaoyu_Islands += $value["cnt"];
				}
			}
		}
										
										
		$Taiwan = array("台北市","基隆市","新北市","宜蘭縣","新竹縣市","桃園縣","苗栗縣","台中市","彰化縣","南投縣","嘉義縣市","雲林縣","台南市","高雄縣市","澎湖縣","屏東縣","台東縣","花蓮縣","金門縣","連江縣","南海諸島","釣魚台列嶼");
		$Taiwan_en = array($Taipei_city,$Keelung,$Taipei,$Ilan,$Hsinchu,$Taoyuan,$Miaoli,$Taichung_city,$Changhua,$Nantou,$Chiayi,$Yunlin,$Tainan,$Kaohsiung,$Penghu,$Pingtung,$Taitung,$Hualien,$Gammon,$Lianjiang,$South_Island,$Diaoyu_Islands);
		$count_array = array_combine($Taiwan,$Taiwan_en);

		$i=1;
		$MaxLoctionNum = 0;
		foreach ($count_array as $key => $value) 
		{
			if(!empty($value))
			{
				if($value > $MaxLoctionNum) $MaxLoctionNum = $value;
				$title[] = array($i,$key);
				$tmp = array($i,$value);
				
				$Location[] = $tmp;
				$i++;
			}
		}

		$MaxLoctionNum = ceil($MaxLoctionNum / 10) * 10;
		

		echo json_encode(array("Sex"=>array("data"=>$SexData,"Max"=>$MaxSexNum),"Age"=>$AgeData,"Location"=>array("Max"=>$MaxLoctionNum,"Title"=>$title,"Data"=>$Location)));

		die;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
