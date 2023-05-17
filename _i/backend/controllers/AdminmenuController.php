<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

// class AdminmenuController extends Controller {
class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,

		'table' => 'admin_menu',
		'orm' => 'admin_menu_orm',
		//'empty_orm_data' => array(
		//	'table' => 'area',
		//	'created_field' => 'create_time', 
		//	'updated_field' => 'update_time',
		//	'primary' => 'id',
		//	'rules' => array(
		//		array('pid, name', 'required'),
		//		array('pid, sort_id', 'length', 'max'=>11),
		//		//array('name, resource_key', 'length', 'max'=>50),
		//		array('name', 'length', 'max'=>50),
		//		//array('link', 'length', 'max'=>255),
		//	),
		//),
		'default_sort_field' => 'sort_id', // 預設要排序的欄位
		'search_keyword_field' => array('name'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'name', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'name', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'get_field_label' => array('name'), // 要變成多國語系的輸出欄位的欄位
		'condition' => array(
			array(
				'where',
				'pid=0',
			),
		),
		'sortable' => array(
			'enable' => 'true',
			//'condition' => 'pid = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=adminmenu/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'name' => array(
				'label' => '選單名稱',
				'width' => '20%',
				'sort' => true,
				'translate_source' => 'tw',
			),
			'link' => array(
				'label' => '連結',
				'width' => '20%',
				//'sort' => true,
			),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面
				'width' => '',
			),
			'sort_id' => array(
				//'label' => 'Sort id',
				'mlabel' => array(
					null, // category
					'Sort id', // label
					array(), // sprintf
					'排序編號', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
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
			//'create_time' => array(
			//	'label' => 'ml:Create time',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
			//'update_time' => array(
			//	'label' => 'ml:Update time',
			//	'width' => '10%',
			//	'align' => 'center',
			//	'sort' => true,
			//),
		), // listfield
		'updatefield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				//'jquery-validate', 'fileuploader', 'jyoutube', 'jquery-ui', 'javascript-sortable',
			),
			//'smarty_javascript' => '',
			'smarty_javascript_text' => '
$("#_generate").change(function(){
	if($(this).val() == "userblock"){
		$("#link").attr("value","backend.php?r=userblockv4{功能名稱|例如about}_{編號|例如2}");
	}
});
',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data',
					'name' => 'form_data',
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
						'name' => array(
							'label' => '選單名稱',
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								//'size' => '30',
							),
						),
						'pid' => array(
							'type' => 'hidden',
							'attr' => array(
								'id' => 'pid',
								'name' => 'pid',
								//'size' => '30',
							),
						),
						'link' => array(
							'label' => '連結',
							'type' => 'input',
							'attr' => array(
								'id' => 'link',
								'name' => 'link',
								'size' => '50',
							),
						),
						'_generate' => array(
							'label' => '選擇功能範本',
							'type' => 'select3',
							'attr' => array(
								'id' => '_generate',
								'name' => '_generate',
							),
							'other' => array(
								'values' => array(
									''=>'忽略 (預設)',
									'delete'=>'刪除 ***要想清楚',
									'auto'=>'全自動 (建議)',
									'userblock' => '模組編排頁 (V4)',
									'contact_b2c' => '連絡我們 (B2C)',
									'contact_b2b' => '連絡我們 (B2B)',
									'rows' => '通用 (半自動) (A方案)',
									'multi_type' => '獨立分類 (半自動) (A方案)',
									'single2' => '單頁 (半自動) (A方案)',
									// 'multi_photo' => '多圖上傳介面(半自動)',//2022-01-10 by lota 擴充
									// 'datatablealteditor' => 'Datatable浮動編輯 (半自動) (A方案)',//2021-12-10 by lota 擴充
									'rows_custom' => '通用 (客製)',
									'multi_type_custom' => '獨立分類 (客製)',
									'datatablealteditor_custom' => 'Datatable浮動編輯 (客製)',//2021-12-10 by lota 擴充
									'multi_photo_custom' => '多圖上傳介面(客製)',//2022-01-10 by lota 擴充
								),
								'default' => '',
							),
						),
						'_webmenu_is_home' => array(
							'label' => '前台動態次選單',
							'type' => 'label',
							'attr' => array(
								'id' => '_webmenu_is_home',
								'name' => '_webmenu_is_home',
							),
						),
						'_file_status' => array(
							'label' => '後台檔案狀況',
							'type' => 'label',
							'attr' => array(
								'id' => '_file_status',
								'name' => '_file_status',
							),
						),
						'_file_preview' => array(
							'label' => '後台檔案預覽<br />(前10行)',
							'type' => 'label',
							'attr' => array(
								'id' => '_file_preview',
								'name' => '_file_preview',
							),
						),
						// 'class' => array(
						// 	'label' => '項目功能',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'class',
						// 		'name' => 'class',
						// 		//'title' => 'img01家、img02商品、img03影片、img04撰寫訊息、img05工具、img06下載、img07電腦訊息、img08公司、img09連絡我們與信件',
						// 		//'size' => '30',
						// 	),
						// ),
						// 'class2' => array(
						// 	'label' => '圖示簡稱',
						// 	'type' => 'input',
						// 	'attr' => array(
						// 		'id' => 'class2',
						// 		'name' => 'class2',
						// 		//'title' => 'img01家、img02商品、img03影片、img04撰寫訊息、img05工具、img06下載、img07電腦訊息、img08公司、img09連絡我們與信件',
						// 		//'size' => '30',
						// 	),
						// ),
						//'pid' => array(
						//	'label' => '上層',
						//	'type' => 'select3',
						//	'attr' => array(
						//		'id' => 'pid',
						//		'name' => 'pid',
						//	),
						//	'other' => array(
						//		//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
						//		//'default' => 'center',
						//		'values' => array(),
						//		'default' => '',
						//	),
						//),
						//'link' => array(
						//	//'label' => '連結',
						//	'mlabel' => array(
						//		null, // category
						//		'Url', // label
						//		array(), // sprintf
						//		'連結', // default
						//	),
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'link',
						//		'name' => 'link',
						//		'size' => '50',
						//	),
						//),
						//'class' => array(
						//	'label' => '項目功能',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'class',
						//		'name' => 'class',
						//		//'title' => 'img01家、img02商品、img03影片、img04撰寫訊息、img05工具、img06下載、img07電腦訊息、img08公司、img09連絡我們與信件',
						//		//'size' => '30',
						//	),
						//),
						//'class2' => array(
						//	'label' => '圖示簡稱',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'class2',
						//		'name' => 'class2',
						//		//'title' => 'img01家、img02商品、img03影片、img04撰寫訊息、img05工具、img06下載、img07電腦訊息、img08公司、img09連絡我們與信件',
						//		//'size' => '30',
						//	),
						//),
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'label' => '排序編號',
							//'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Sort id', // label
							//	array(), // sprintf
							//	'排序編號', // default
							//),
							'type' => 'sort',
							'attr' => array(
							),
						),
						'is_enable' => array(
							'label' => '狀態',
							'type' => 'status',
							'attr' => array(
								'id' => 'is_enable',
								'name' => 'is_enable',
							),
							'other' => array(
								//'other1' => 'ml:Enable',
								//'other2' => 'ml:Disable',
								'default' => '1',
							),
						),
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
		//var_dump($this->_get_admin_menu_classes($this->data));

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		// $this->def['condition'][0][1] = 'pid=0 ';
		// $this->def['sortable']['condition'] = 'pid=0 ';

		if(defined('BACKEND_MENU_MERGE')){
			if(BACKEND_MENU_MERGE == true){ // 2019-11-21
				$this->def['condition'][0][1] = 'pid=0 and ml_key=\'tw\' ';
				$this->def['sortable']['condition'] = 'pid=0 and ml_key="tw" ';
			} else {
				$this->def['condition'][0][1] = 'pid=0 and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
				$this->def['sortable']['condition'] = 'pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
			}
		}

		$this->data['render_tree'] = array();
		if(empty($_POST)){
			$parameter = new Parameter_handle;
			$params = $parameter->get($this->data['router_param']);
			$param_define = $parameter->getDefine();

			if(!isset($params['prev']) or $params['prev'] == ''){
				$params['prev'] = $this->data['current_base64_url'];
			}

			// 取得所有樹狀資料
			//$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1')->order('sort_id')->queryAll();
			//$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1')->order('sort_id')->queryAll();
			if(defined('BACKEND_MENU_MERGE')){
				if(BACKEND_MENU_MERGE == true){ // 2019-11-21
					$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>'tw'))->order('sort_id')->queryAll();
				} else {
					$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
				}
			} else {
				$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1')->order('sort_id')->queryAll();
			}

			//var_dump($rows);
			//die;
			$tree = new Tree();
			$bbb = array();
			$current_row = array();
			$rows_ids = array();
			$bigid = 99999;
			// 先找一下現在這筆的pid，等一下要判斷該層
			if(isset($params['value'][0]) and $rows){
				foreach($rows as $k => $v){
					$rows_ids[] = $v['id'];
					if($params['value'][0] == $v['id']){
						$current_row = $v;
					}
				}
				// 只是為了要知道最大的編號而以
				sort($rows_ids);

				$bigid = $rows_ids[count($rows_ids)-1] + 1;
			}

			if($rows){
				foreach($rows as $k => $v){
					// 等一下才會用得到
					$v['more'] = '';
					$v['add'] = '';

					$v['menu_url'] = $this->createUrl($this->data['router_class'].'/update')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'];

					// 要轉換一下
					$v['parentid'] = $v['pid'];

					// 指出現在修改的這筆
					$v['current'] = '';
					$v['current2'] = '';
					if(isset($params['value'][0]) and $v['id'] == $params['value'][0]){
						//$v['current'] = ' <span style="color:red;">&larr;目前</span>';
						$v['current2'] = 'background-color:#a1cc8a;';
					}

					// 指出現在修改的這層
					$v['current_pid'] = '';
					$v['current_pid2'] = '';
					if(isset($params['value'][0]) and isset($current_row['id']) and $v['id'] == $current_row['pid']){
						//$v['current_pid'] = ' <span style="color:red;">(*)</span>';
						$v['current_pid2'] = 'background-color:#ecebdb;';
					}

					// 無限層修改
					//if($v['pid'] == 0){
						$v['add'] = '<a href="'.$this->createUrl($this->data['router_class'].'/create')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'].$v['id'].'"><img class="imgalign" src="'.$this->assetsUrl.$this->data['template_path'].'/images/icons/add.png'.'" /></a>';
					//}

					//Debug
					//$v['name'] = '123';

					$bbb[$v['id']] = $v;

				}
				//-2020/11/01 #46127  增加線上捐款功能開關----------------------------------------------------------------------------------------start
				$donation_data = $this->db->createCommand()->from('sys_config')->where('keyname=:keyname', array(':keyname'=>'function_constant_donation'))->queryRow();
				if(!empty($donation_data) && $donation_data['keyval']=='false'){
					foreach($bbb as $k => $v){
						if(stristr($v['link'],'donationorder')){
							unset($bbb[$k]);
						}
					}
				}
				//--------------------------------------------------------------------------------------------------------------------------------end
				// 如果有編號，而且現在是在新增的狀態，那就加一項新增中
				if(isset($params['value'][0]) and $this->data['router_method'] == 'create' and isset($current_row['id'])){ //and $current_row['pid'] == 0){
					$bbb[$bigid] = array(
						'id' => $bigid,
						'parentid' => $current_row['id'],
						'name' => '<span style="color:red;">新增中</span>',
						'menu_url' => '#',
						'current' => '',
						'current2' => '',
						'current_pid' => '',
						'current_pid2' => '',
						'more' => '',
						'add' => '',
					);
					// 當在root底下新增child的時候，root會變成"在上層"，而不是"在當層"，以新增child的角度來看
					//$bbb[$current_row['id']]['current'] = '<span style="color:red;">(*)</span>';
					$bbb[$current_row['id']]['current2'] = 'background-color:#a1cc8a;';

					// 只是預留而以
					$bigid++;
				}
			}

			// 如果總筆數到達40筆的時候，顯示方式改成只顯示本層
			if(count($bbb) > 39){
				$xid = '';
				if(isset($current_row['pid']) and $current_row['pid'] == 0){
					$xid = $current_row['id'];
				} elseif(isset($current_row['pid'])){
					$xid = $current_row['pid'];
				}
				foreach($bbb as $k => $v){
					if(isset($v['pid']) and $v['pid'] != 0 and $v['pid'] != $xid and isset($bbb[$v['pid']])){
						// 刪掉前，先把最上層加上點點點，代表裡面有東西
						$bbb[$v['pid']]['more'] = '&nbsp;<span style="color:red;">...</span>';

						// 把不是那層的東西底下的都刪掉
						unset($bbb[$k]);
						continue;
					}
				}
				//if(isset($xid)){
				//}
			}

			// 因為換回原本舊的Tree Class，所以特地加上這一段
			foreach($bbb as $k => $v){
				if(!isset($v['parentid'])){
					$v['parentid'] = 0;
				}
				$v['parent_id'] = $v['parentid']; // 轉換一下，因為Tree class的運算是用parent_id這個欄位名稱
				$bbb[$k] = $v;
			}

			$tree->init($bbb);

			$str = "<div style='\$current2\$current_pid2'>\$spacer <a href='\$menu_url\$id'>\$name</a> \$add \$current \$current_pid \$more </div>";
			$this->data['render_tree'] = $tree->get_tree('0', $str);

			if(!isset($params['value'][0]) and $this->data['router_method'] == 'create'){
				$this->data['render_tree'] .= '<span style="color:red;">(新增中)</span><br />';
			}
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
		
		return true;
	}

	protected function index_last()
	{
		//$this->data['main_content'] = $this->data['router_class'].'/index';

		// 2018-09-05 這裡比較特別，因為母體的view是存在的，所以我這裡必需指定它，要使用預設
		$this->data['main_content'] = 'default/index';
		//-2020/11/01 #46127  增加線上捐款功能開關----------------------------------------------------------------------------------------start
		$donation_data = $this->db->createCommand()->from('sys_config')->where('keyname=:keyname', array(':keyname'=>'function_constant_donation'))->queryRow();
		if(!empty($donation_data) && $donation_data['keyval']=='false'){
			foreach($this->data['listcontent'] as $k => $v){
				if(stristr($v['link'],'donationorder')){
					unset($this->data['listcontent'][$k]);
				}
			}
		}
		//--------------------------------------------------------------------------------------------------------------------------------end
		// print_r($this->data['listcontent']);die;
	}

	protected function getData()
	{
		if(isset($this->data['def']['updatefield']['sections'][0]['field']['pid'])){
			if(defined('BACKEND_MENU_MERGE')){
				if(BACKEND_MENU_MERGE == true){ // 2019-11-21
					$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>'tw'))->order('sort_id')->queryAll();
				} else {
					$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
				}
			} else {
				$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 ')->order('sort_id')->queryAll();
			}

			if($rows){
				$aaa = array();
				foreach($rows as $k => $v){
					$aaa[$v['id']] = $v['name'];
				}
				$this->data['def']['updatefield']['sections'][0]['field']['pid']['other']['values'] = $aaa;
				//var_dump($this->data['def']['updatefield']['sections'][0]['field']['pid']);
			}
		}
	}

	//protected function update_show_last()
	protected function update_show_last($updatecontent)
	{
		$this->getData();

		$this->index_param_handle();
		
		//$this->data['def']['condition']['where']['pid'] = $this->data['updatecontent']['id'];
		$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'];
		//var_dump($this->data['def']['condition']);
		//die;
		$this->index_get_total();

		$this->index_get_data();
		$this->index_last_handle();

		// 取得數量，用在排序的編號產出
		//$this->data['def']['condition']['where']['pid'] = $this->data['updatecontent']['pid'];
		//Foreach($this->data['def']['condition'] as $k => $v){
		//	$this->db->{$k}($v);
		//}
		//$query = $this->db->get($this->def['table']);
		//$this->data['class_sort_count'] = $query->num_rows();
		$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['pid'].' ';
		//var_dump($this->data['def']['condition']);
		//die;
		$this->data['class_sort_count'] = G::dbc('update', $this->data['def']);

		// 當pid為零的時候，代表現在在修改大分類，此時pid就是大分類的編號
		// 反之
		$pid = 0;
		$this->data['updatecontent']['name_parent'] = '';
		if($this->data['updatecontent']['pid'] != 0){
			$pid = $this->data['updatecontent']['pid'];

			$row = $this->db->createCommand()->from($this->data['def']['table'])->where('id = '.$this->data['updatecontent']['pid'])->queryRow();
			if($row){
				$this->data['updatecontent']['name_parent'] = $row['name'];
			}
		} else {
			$this->data['def']['disable_index_normal_search'] = true;
			$pid = $this->data['updatecontent']['id'];
			unset($this->data['def']['updatefield']['sections'][0]['field']['pid']);
		}
		$this->data['def']['sortable']['condition'] = 'pid='.$pid.' ';

		$this->data['sort_url'] .= '-'.$this->data['parameter']['value'].$this->data['updatecontent']['id'];

		$tmp = $this->data['updatecontent'];
		$tmp2 = $this->_get_product_classes($this->data);
		$this->data['breadcrumbs'] = array();
		if($this->data['updatecontent']['pid'] != 0){
			$tmp3 = $this->_search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$this->data['updatecontent']['pid']]['class_name'], $tmp['name']);
			$this->data['breadcrumbs'] = $tmp3['keyvalue'];
			//var_dump($tmp3);
			//die;
		}

		// 2018-06-06 自動輸出檔案
		// var_dump($this->data['updatecontent']);
		// if($this->data['updatecontent']['link'] != '' and !preg_match('/\//', $this->data['updatecontent']['link']) and preg_match('/^backend\.php\?r=(.*)$/', $this->data['updatecontent']['link'], $matches)){
		// 	$file = _BASEPATH.ds('/').target_app_name.ds('/controllers/');//.ucfirst($matches[1]).'Controller.php';
		// 	if(!file_exists($file.ucfirst($matches[1]).'Controller.php') and ucfirst($matches[1]) != 'Home'){ // 後台 / 後台主選單 / 首頁 是例外，不需要自動建立
		// 		file_put_contents($file.ucfirst($matches[1]).'Controller.php', file_get_contents($file.'NewsController.php'));
		// 	}
		// }

		// 2020-09-30
		$this->data['updatecontent']['_generate'] = '';
		$this->data['updatecontent']['_file_status'] = '';

		$router_class = '';
		if($this->data['updatecontent']['link'] != '' and !preg_match('/\//', $this->data['updatecontent']['link']) and preg_match('/^backend\.php\?r=(.*)$/', $this->data['updatecontent']['link'], $matches)){
			$router_class = $matches[1];
		}

		$controller_exists = false;
		$path2 = _BASEPATH.ds('/').target_app_name.ds('/controllers/');//.ucfirst($matches[1]).'Controller.php';
		$file2 = $path2.ucfirst($router_class).'Controller.php';
		if($router_class != '' and file_exists($file2)){
			$controller_exists = true;
		}

		if($controller_exists === true){
			$this->data['updatecontent']['_file_status'] = '<span style="color:red"><b>存在</b></span>';
		} else {
			$this->data['updatecontent']['_file_status'] = '不存在 <span style="color:red">* 但是可能存在於其它地方</span>';
		}
		$this->data['updatecontent']['_file_status'] .= ' <a href="'.$this->data['updatecontent']['link'].'" target="_blank">(後台功能連結)</a>';

		$row = $this->cidb->where('url1',str_replace('type','',$router_class).'_'.$this->data['admin_switch_data_ml_key'].'.php')->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type','webmenu')->get('html')->row_array();
		if($row and isset($row['id'])){
			if($row['is_home'] == '1'){
				$this->data['updatecontent']['_webmenu_is_home'] = '有 <span style="color:red">* 功能範本建議選擇"全自動"</span>';
			} else {
				$this->data['updatecontent']['_webmenu_is_home'] = '有 <span style="color:red">* 但是沒啟用</span>';
			}
			$this->data['updatecontent']['_webmenu_is_home'] .= ' <a href="backend.php?r=webmenu/update&param=v'.$row['id'].'" target="_blank">(後台 / 前台主選單連結)</a>';
			$this->data['updatecontent']['_webmenu_is_home'] .= ' <a href="/'.$row['url1'].'" target="_blank">(前台功能連結)</a>';
		} else {
			$this->data['updatecontent']['_webmenu_is_home'] = '沒有對應的';
		}

		if(file_exists($file2)){
			$aaa = file_get_contents($file2);
			$aaas = explode("\n",$aaa);

			for($x=0;$x<=9;$x++){
				if(isset($aaas[$x])){
					$aaas2[] = $aaas[$x];
				}
			}
			$aaa2 = implode("\n",$aaas2);
			//var_dump($aaa2);die;
			$aaa2 = str_replace('<','&lt;',$aaa2);
			$aaa2 = nl2br($aaa2);
			$this->data['updatecontent']['_file_preview'] = '<code>'.$aaa2.'<br />...<br />(共'.number_format(count($aaas)).'行)</code>';
		}

		// 選擇預設的修改樣版，並依照程式變數產生
		// $this->data['main_content'] = $this->data['router_class'].'/update';

		// 2018-09-05 這裡比較特別，因為母體的view是存在的，所以我這裡必需指定它，要使用預設
		$this->data['main_content'] = 'default/update';

		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'/'.$this->data['updatecontent']['id'];
		
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function update_run_last()
	{
		if(isset($this->data['def']['listfield']['sort_id']) and isset($this->data['def']['condition']) and !empty($this->data['def']['condition'])){
			// 取得數量，用在排序的編號產出
			$this->data['def']['condition'][0][1] = $_POST['pid'];
		}

		// 2020-09-30
		// ''=>'忽略 (預設)',
		// 'delete'=>'刪除 ***要想清楚',
		// 'auto'=>'全自動 (建議)',
		// 'userblock' => '模組編排頁 (V4)',
		// 'contact_b2c' => '連絡我們 (B2C)',
		// 'contact_b2b' => '連絡我們 (B2B)',
		// 'rows' => '通用 (半自動) (A方案)',
		// 'multi_type' => '獨立分類 (半自動) (A方案)',
		// 'single2' => '單頁 (半自動) (A方案)',
		// 'multi_photo' => '多圖上傳介面(半自動)',
		// 'rows_custom' => '通用 (客製)',
		// 'multi_type_custom' => '獨立分類 (客製)',
		// 'datatablealteditor_custom' => 'Datatable浮動編輯 (客製)',
		$router_class = '';
		if($_POST['link'] != '' and !preg_match('/\//', $_POST['link']) and preg_match('/^backend\.php\?r=(.*)$/', $_POST['link'], $matches)){
			$router_class = $matches[1];
		}

		$controller_exists = false;
		$path2 = _BASEPATH.ds('/').target_app_name.ds('/controllers/');//.ucfirst($matches[1]).'Controller.php';
		$file2 = $path2.ucfirst($router_class).'Controller.php';
		if($router_class != '' and file_exists($file2)){
			$controller_exists = true;
		}

		if(isset($_POST['_generate']) and $_POST['_generate'] != '' and $router_class != ''){
			if(preg_match('/^(auto|userblock|contact_b2c|contact_b2b|rows|multi_type|single2|datatablealteditor)$/', $_POST['_generate']) and $controller_exists === false){
				$var1 = $_POST['_generate'];

				if($var1 == 'auto'){
					$var1 = '';
				}

				if($var1 != ''){
					$var1 = 'sample_'.$var1;
				}

				$content = <<<XXX
<?php
\$pathx = '$var1';
\$tmps = explode('/',str_replace('\\\','/',__FILE__));
\$filename = str_replace('.php','',\$tmps[count(\$tmps)-1]);
\$contentx2 = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_main.php');
\$contentx2 = str_replace('<'.'?'.'php', '', \$contentx2);
eval(\$contentx2);
eval('class '.\$filename.' extends NonameController {}');
XXX;
				file_put_contents($file2,$content);

				// 自動在page那裡，自動加上到其它頁面的欄位
				if($_POST['_generate'] == 'userblock' and preg_match('/^backend\.php\?r=userblockv4(.*)\_(\d+)$/',$_POST['link'],$matches)){
					$rowgg = $this->cidb->where('name','模組編排頁_新版')->where('pid',0)->where('theme_name',LAYOUTV3_THEME_NAME)->get('layoutv3pagetype')->row_array();
					if($rowgg){
						$this->cidb->where('id',$rowgg['id'])->update('layoutv3pagetype',array('other_func'=>$rowgg['other_func'].','.$matches[1].'_'.$matches[2]));
					}
				}
			} elseif(preg_match('/^(rows|multi_type|datatablealteditor|multi_photo)_custom$/', $_POST['_generate'], $matches) and $controller_exists === false){
				$contentg = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/').'sample_'.$matches[1].'.php');

				$contentg1 = <<<XXX

\$tmps = explode('/',str_replace('\\\\','/',__FILE__));
\$filename = str_replace('.php','',\$tmps[count(\$tmps)-1]);

XXX;

				$contentg2 = <<<XXX

eval('class '.\$filename.' extends NonameController {}');

XXX;

				$contentg = str_replace('// 懶得改Controller的名稱之一',$contentg1,$contentg);
				$contentg = str_replace('// 懶得改Controller的名稱之三',$contentg2,$contentg);

				file_put_contents($file2,$contentg);
			} elseif($_POST['_generate'] == 'delete' and $controller_exists === true){
				unlink($file2);
			} // sample_
		} // _generate

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function create_show_first($param = '')
	{
		// 因為預設的建立函式，我沒有取得編號這個動作
		$id = '';
		if(isset($this->data['params']['value'][0])){
			$id = $this->data['params']['value'][0];
		}
		unset($this->data['def']['updatefield']['sections'][0]['field']['pid']);

		$validation = array();
		if(isset($this->data['def']['empty_orm_data']['rules']) and !empty($this->data['def']['empty_orm_data']['rules'])){
			$validation = G::getJqueryValidation($this->data['def']['empty_orm_data']['rules']);
		}

        $this->data['jqueryvalidation'] = json_encode($validation);

		//$u = new $this->def['orm']();
		//$validation = $u->getJqueryValidation();

		// 如果id有指定，代表使用者想要建第二層的分類
		$parent_data = array();
		$this->data['updatecontent']['name_parent'] = '';
		if($id != ''){
			//$u->get_by_id($id);
			//$parent_data = $u->to_array();
			$parent_data = $this->db->createCommand()->from($this->data['def']['table'])->where('id='.$id)->queryRow();
		}
		$this->data['parent_data'] = $parent_data;
		if(isset($parent_data['name'])){
			$this->data['updatecontent']['name_parent'] = $parent_data['name'];
		}

		//$this->data['jqueryvalidation'] = json_encode($validation);

		// 選擇預設的修改樣版，並依照程式變數產生
		// $this->data['main_content'] = $this->data['router_class'].'/update';

		// 2018-09-05 這裡比較特別，因為母體的view是存在的，所以我這裡必需指定它，要使用預設
		$this->data['main_content'] = 'default/update';

		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_show_last($param='')
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function create_run_other_element($array)
	{
		if(defined('BACKEND_MENU_MERGE')){
			if(BACKEND_MENU_MERGE == true){ // 2019-11-21
				$array['ml_key'] = 'tw';
			} else {
				$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
			}
		}
		
		// 表示使用者想要建立第二層
		//if($array['hidden_id'] != ''){
		//	$array['pid'] = $array['hidden_id'];
		//} else {
		//	$array['pid'] = '0';
		//}
		//if($array['pid'] == ''){
		//	$array['pid'] = '0';
		//}

		// 取得數量，用在排序的編號產出
		if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
			$this->data['def']['condition'][0][1] = 'pid='.$array['pid'].' ';
		}

		return $array;
	}

	protected function update_run_other_element($array)
	{
		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}

	public function delete($param = '')
	{
		//$this->load->library('Parameter_handle', '', 'parameter');
		//$params = $this->parameter->get($param);
		$parameter = new Parameter_handle;
		$params = $parameter->get($param);

		if(!isset($params['value'][0])){
			$msg = $this->_getLabel('no id');
			show_error($msg);
		}
		$id = $params['value'][0];

		$u = new admin_menu_orm();
		$u->get_by_id($id);
		$pid = $u->pid;

		$c = new Empty_orm('insert', $this->def['empty_orm_data']);
		$s = $c::model()->findByPk($id);
		$pid = $s->pid;
		$u = $c::model()->exists('id=:id',array(':id'=>$id));
		//var_dump($u);
		//die;

		//if($u){

		if($u){
			// 為了要回去上一頁
			$prev_url = base64url::decode($params['prev']);

			$sys_log_msg = 'delete id:'.$id.', name:'.$u->{$this->def['sys_log_name']};

			$s->delete();

			sys_log::set($sys_log_msg);
		} else {
			$msg = $this->_getLabel('delete error');
			G::m($msg);
		}

		// 重新排序
		//$conditions = array('pid' => $pid);
		$fieldsorter = new Fieldsorter;
		$fieldsorter->setTableName($this->data['def']['table']);
		$fieldsorter->setCondition(array(array('where', 'pid='.$pid.'  ')));
		$fieldsorter->refresh();

		$parameter = $parameter->getDefine();

		if($pid == '0'){
			$redirect_url = $this->data['class_url'];
			if($prev_url != ''){
				$redirect_url = $prev_url;
			}

		} else {
			$redirect_url = $this->data['class_url'].'/update&param='.$parameter['value'].$pid;
		}

		$url = base64url::encode($redirect_url);
		redirect($this->data['base_url'].'/auth/redirect/'.$parameter['value'].$url.'-'.$parameter['value'].'delete');
	} // delete

	public function _get_product_classes($data)
	{
		// 取得所有的分類，目標做到2層以上
		$conditions = array(
			//'ml_key' => $data['ml_key'],
			//'is_enable' => '1',
		);
		//$query = $this->cidb->select('id, class_id, class_name, class_name AS class_name_id')->where($conditions)->get('product_class');
		$query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->get($this->def['table']);
		$productclasses = array();
		$productclasses_sample = array();
		foreach($query->result_array() as $row){
			$row['class_name_id'] = $row['class_name_id'].'__'.$row['id'];
			$productclasses[] = $row;
			$productclasses_sample[$row['id']] = $row;
		}

		// 將分類轉成Tree
		// http://www.mombu.com/php/php/t-creating-tree-structure-from-associative-array-11767756.html
		// Set up indexing of the above list (in case it wasn't indexed).
		$lookup = array();
		foreach( $productclasses as $item ){
			$item['children'] = array();
			$lookup[$item['id']] = $item;
		}
		
		// Now build tree.
		$tree = array();
		foreach( $lookup as $id => $foo ){
			$item = &$lookup[$id];
			if( $item['class_id'] == 0 ){
				$tree[$id] = &$item;
			} else if( isset( $lookup[$item['class_id']] ) ){
				$lookup[$item['class_id']]['children'][$id] = &$item;
			} else {
				$tree['_orphans_'][$id] = &$item;
			}
		}

		$return = array(
			'data' => $productclasses,
			'sample' => $productclasses_sample,
			'tree' => $tree,
		);

		return $return;
	}

	/*
	 * 這裡會回應一個陣列
	 * 其中斜線是$char變數
	 * array(
	 *   'ids' => array(IDA, IDB, IDC),
	 *   'keyvalue' => array(
	 *		'CLASSID - A' => 'classA',
	 *		'CLASSID - B' => 'classB',
	 *		'CLASSID - N' => 'classN',
	 *   );
	 *   'values' => array(
	 *		'classA',
	 *		'classB',
	 *		'classN',
	 *   );
	 *   'value' => 'classA / classB / classN',
	 * )
	 *
	 * @class_name string 是分類名稱__分類編號所組成
	 */
	// http://php.chinaunix.net/manual/tw/function.array-search.php 也可以參考這裡，搜尋關建字是getParentStack
	public function _search_product_class_tree($tree, $classes, $class_name, $product_name, $char = ' / ')
	{
		/* 搜尋結果是2層的狀況
		 * array(1) {
		 *   [1]=>
		 *   array(1) {
		 *     ["children"]=>
		 *     array(1) {
		 *       [25]=>
		 *       array(1) {
		 *         ["class_id_name"]=>
		 *         string(6) "RD3011__25"
		 *       }
		 *     }
		 *   }
		 * }
		 */
		// 搜尋陣列，把搜尋的"第1個"結果給找出來
		$return_tmp = $this->_getParentStack($class_name, $tree);

		/*
		 * 來看一下$return_tmp裡面是什麼東東
array(1) {
  [23]=>
  array(1) {
    ["children"]=>
    array(1) {
      [24]=>
      array(1) {
        ["children"]=>
        array(1) {
          [31]=>
          array(1) {
            ["class_name"]=>
            string(7) "test1gg"
          }
        }
      }
    }
  }
}
*/
		//var_dump($return_tmp);

		$return = array();

		// 開始解無限層
		for($x=1;$x<=100;$x++){
			$tmp = '';
			$run = '';
			for($y=1;$y<=($x-1);$y++){
				$tmp .= '[$L'.$y.']["children"]';
			} // for y
			//echo $tmp."\n";
			$run = <<<XXX
if(!isset(\$return_tmp$tmp)){
	\$x = 100;
} else {
	foreach(\$return_tmp$tmp as \$L$y => \$v) break;
}
XXX;
			eval($run);
		} // for x

		$return['ids'] = array();
		for($x=1;$x<=100;$x++){
			eval('if(isset($L'.$x.')) $return["ids"][] = $L'.$x.';');
		}
		//var_dump($return);
		//die;


		//if(isset($classes[$root_class_id]['class_name'])){
		$return['keyvalue'] = array();
		$return['values'] = array();
		if(count($return['ids']) > 0){
			foreach($return['ids'] as $v){
				$return['keyvalue'][$v] = $classes[$v]['class_name'];
				$return['values'][] = $classes[$v]['class_name'];
			}
		}
		$return['value'] = implode(' / ', $return['values']);

		return $return;
	}

	/**
	 * Gets the parent stack of a string array element if it is found within the
	 * parent array
	 *
	 * This will not search objects within an array, though I suspect you could
	 * tweak it easily enough to do that
	 *
	 * @param string $child The string array element to search for
	 * @param array $stack The stack to search within for the child
	 * @return array An array containing the parent stack for the child if found,
	 *               false otherwise
	 */
	public function _getParentStack($child, $stack) {
		foreach ($stack as $k => $v) {
			if (is_array($v)) {
				// If the current element of the array is an array, recurse it and capture the return
				$return = $this->_getParentStack($child, $v);
			   
				// If the return is an array, stack it and return it
				if (is_array($return)) {
					return array($k => $return);
				}
			} else {
				// Since we are not on an array, compare directly
				if ($v == $child) {
					// And if we match, stack it and return it
					return array($k => $child);
				}
			}
		}
	   
		// Return false since there was nothing found
		return false;
	}

}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
