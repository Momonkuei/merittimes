<?php

/*
 * 無限層(獨立資料表)
 */

// 懶得改Controller的名稱之一
// $tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
// $filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,
		'table' => 'XXX',
		'orm' => 'Empty_orm',
		// 'orm' => 'XXX_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			// https://www.yiiframework.com/wiki/56/reference-model-rules-validation
			'rules' => array(
				array('pid, name', 'required'),
				array('pid, sort_id', 'length', 'max'=>11),
			),
		),
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
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'pic1' => array(
				//'label' => '圖片',
				'mlabel' => array(
					null, // category
					'Image', // label
					array(), // sprintf
					'代表圖', // default
				),
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
				'kcfinder_small_img' => true,
			),
			'name' => array(
				'label' => '名稱',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'選單名稱', // default
				//),
				'width' => '20%',
				'sort' => true,
			),
			//'link' => array(
			//	'label' => '連結',
			//	'width' => '20%',
			//	//'sort' => true,
			//),
			'funcfieldv3_split_1' => array(
				// 這個是程式處理欄位，底線1的部份，數字可以不固定，反正東西就會放在第一區塊的後面
				'width' => '',
			),
			'sort_id' => array(
				'label' => '排序',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Sort id', // label
				//	array(), // sprintf
				//	'排序編號', // default
				//),
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
			'is_enable' => array(
				//'label' => 'ml:Status',
				'label' => '狀態',
				'translate_source' => 'tw',
				//'mlabel' => array(
				//	null, // category
				//	'Status', // label
				//	array(), // sprintf
				//	'狀態', // default
				//),
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
			'smarty_javascript_text' => '',
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
						//'ml_key' => array(
						//	'label' => 'ml:Language',
						//	'type' => 'mls',
						//),
						'name' => array(
							'label' => '標題',
							'translate_source' => 'tw',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'選單名稱', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								//'size' => '30',
							),
						),
						'_contentbuilder' => array(
							'label' => '',
							'type' => 'inputn',
							'other' => array(
								'html'=>'<div class="control-box"><button type="button" id="htmlbtn" onclick="openif(\'detail\')">+ 加入範本</button><input type="hidden" id="ctidx" value=""><div id="ctarea" style="display: none;" ></div>',	
							),
						),
						// 'pic1' => array(
						// 	'label' => '代表圖：',
						// 	'type' => 'fileuploader',
						// 	'other' => array(
						// 		'number' => '1',
						// 		'type' => 'photo',
						// 		'top_button' => '1',
						// 		'width' => '1000',
						// 		'height' => '652',
						// 		'comment_size' => '1000x650',
						// 		'no_ext' => '',
						// 		'no_need_delete_button' => '',
						// 	),
						// ),
						'pid' => array(
							'type' => 'hidden',
							'attr' => array(
								'id' => 'pid',
								'name' => 'pid',
								//'size' => '30',
							),
						),
						//'pid' => array(
						//	'label' => '上層',
						//	//'type' => 'select3',
						//	'type' => 'select5',
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
							'label' => '排序',
							'translate_source' => 'tw',
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
							//'label' => 'ml:Status',
							'label' => '狀態',
							'translate_source' => 'tw',
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
								//'other1' => 'ml:Enable',
								//'other2' => 'ml:Disable',
								'default' => '1',
							),
						),
					),
				),
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'detail' => array(
				//			'label' => '文章內容',
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
				// funcfieldv3的產出欄位，放在任何位置都可以
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_funcfieldv3_result' => true, // 要記得這個要加
					'field' => array(
					),
				),
				// 這是SEO欄位的範本，如果你需要，就打開它，第二版的放在任何位置都可以，只要記得加上一個元素_has_seov2 => true就可以了
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_seov2' => true,
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

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		// $this->def['orm'] = $this->data['router_class'].'_orm';
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
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

		//上層功能下拉選單載入
		//$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable =1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		//if($rows and count($rows) > 0){
		//	foreach($rows as $k => $v){
		//		// 大分類可選
		//		//$this->def['searchfield']['sections'][0]['field']['pid']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
		//		$this->def['updatefield']['sections'][0]['field']['pid']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
		//		// 剩餘子層的處理程序 子層如果誤操作，會造成無限輪迴，還想不到要怎麼解決 by lota
		//		$data_1 = $this->layout_show($v['id'],1,'　',$this->data['router_class']);//'　└'	
		//		$this->def['updatefield']['sections'][0]['field']['pid']['other']['values'] += $data_1;
		//		//$this->def['searchfield']['sections'][0]['field']['pid']['other']['values'] += $data_1 ;
		//	}
		//}

		// 有SEO權限的，才能使用編輯器
		// 假設編輯器是在第二區塊的detail欄位
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if($_constant){
			$acl = new Admin_acl();
			$acl->start();
			if($acl->hasAcl($this->data['admin_id'], 'seo', 'update')){
				//查詢SEO資料表，看有沒有資料
				$parameter = new Parameter_handle;
				if(isset($_GET['param']) and $_GET['param'] != ''){
					$param = $_GET['param'];
					$params = $parameter->get($param);
					$param_define = $parameter->getDefine();
					$this->data['def'] = G::definit($this->def, $this->data);
					$this->data['params'] = $params;
					$this->data['parameter'] = $param_define;

					if(!isset($params['value'][0])){
						// do nothing
					} else {
						$id = $params['value'][0];

						$rows = $this->db->createCommand()->from('seo')->where('seo_item_id=:id and seo_ml_key=:ml_key and seo_type=:type',array(':id'=>$id,'ml_key'=>$this->data['admin_switch_data_ml_key'],':type'=>'producttype'))->queryRow();
						
						if($rows){
							unset($this->def['updatefield']['sections'][1]['detail']);
						}
					}
				}
			}
		}

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'pid=0 and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';

		// $condition = $this->def['sortable']['condition']; //這段應該不需要加 by lota 2021-07-08

		// 2020-08-19
		// 供新增的時候使用，新增的資料要在第一筆
		$this->data['origin_condition'] = array();
		if(isset($condition) && trim($condition) != ''){
			$this->data['origin_condition'][0] = array(
				'where',
				$condition,
			);
		}

		// 前台主選單的資料表功能
		$this->data['later_num'] = 20;
		$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>str_replace('type','',$this->data['router_class']).'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		if($row){
			// 無限層的分類層數限制
			$this->data['later_num'] = $row['other15'];
			if($this->data['later_num'] == '' or $this->data['later_num'] == 0){
				$this->data['later_num'] = 1;
			}
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'beforeaction.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

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
			$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'"')->order('sort_id')->queryAll();
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

			/*
			 * 2017-11-01 補上產品層級數判斷的程式碼 ggg
			 */
			// unset($_constant);
			// eval('$_constant = '.strtoupper(str_replace('type','',$this->data['router_class']).'_add_later').';');
			// $add_later = $_constant;

			// unset($_constant);
			// eval('$_constant = '.strtoupper(str_replace('type','',$this->data['router_class']).'_type_later_num').';');
			// $later_num = $_constant;

			$add_later = true;
			$later_num = $this->data['later_num'];

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
					
					//判斷目前ID的層數
					$ggg = $this->judge_layer($v['id']);
					$now_layer = $ggg['k'] + 1;
					
					// 無限層修改
					//判斷是否能夠新增子分類
					// unset($_constant);
					// eval('$_constant = '.strtoupper(str_replace('type','',$this->data['router_class'])).'_add_later;');
					// if($v['pid'] == 0 && $_constant == true){
					// 	$v['add'] = '<a href="'.$this->createUrl($this->data['router_class'].'/create')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'].$v['id'].'"><img class="imgalign" src="'.$this->assetsUrl.$this->data['template_path'].'/images/icons/add.png'.'" /></a>';
					// }

					// 2017-11-01 補上
					if($add_later === false or $now_layer >= $later_num){
						// do nothing
					} else {
						$v['add'] = '<a href="'.$this->createUrl($this->data['router_class'].'/create')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'].$v['id'].'"><img class="imgalign" src="'.$this->assetsUrl.$this->data['template_path'].'/images/icons/add.png'.'" /></a>';
					}

					//Debug
					//$v['name'] = '123';

					$bbb[$v['id']] = $v;

				}

				// 如果有編號，而且現在是在新增的狀態，那就加一項新增中
				if(isset($params['value'][0]) and $this->data['router_method'] == 'create'){ //and $current_row['pid'] == 0){
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

		// if(isset($params['value'][0])){
		// 	$ggg = $this->judge_layer($params['value'][0]);
		// 	$now_layer = $ggg['k'] + 1;

		// 	// 2020-02-27 amy建議
		// 	// 頂層分類提升的情況，上兩層不顯示圖片的話(1/2)
		// 	// 這裡是上二層的情況，但是因為邏輯，所以減一
		// 	// if($now_layer <= 1){
		// 	// 	unset($this->def['listfield']['pic1']);
		// 	// }

		// 	// 2020-06-05 Rigo建議，次類有圖，而大類沒圖的狀況下，要把大類的圖的欄位拿掉
		// 	// if($now_layer == 1){
		// 	// 	unset($this->def['updatefield']['sections'][1]['field']['pic1']);
		// 	// }
		// }

		// 這是SEO欄位的範本，如果你需要，就打開它 2/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') && $_constant ){
			$seo_func = 'a';
			include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
		}

		return true;
	}

	// 判斷目前ID的層數 lota 2016/5/8
	function judge_layer($pid = 0,$k = 0)
	{
		if ($pid != 0){
			$rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" and id ='.$pid)->queryRow();
			if($rows['pid'] != 0){
				$kk = $k + 1;				
				return $this->judge_layer($rows['pid'],$kk);			
			}else{
				$arr['pid'] = $pid;
				$arr['k'] = $k;
				return $arr;
			}
		}else{
			$arr['pid'] = $pid;
			$arr['k'] = $k;
			return $arr;
		}
	}

	protected function index_last()
	{
		// 2018-08-29 分項節點(1/2) 父
		$node_fields = array();
		if(isset($this->data['def']['listfield']) and count($this->data['def']['listfield']) > 0){
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
		// var_dump($node_fields);die;

		// 分類圖的部份，有兩個地方哦
		if($this->data['listcontent']){			
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					// ./assets/upload/producttype/018336b11773d2f10ddea2740a4d768c.jpg
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}

				// 2018-08-29 分項節點(2/2) 父
				if($node_fields and count($node_fields) > 0){
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

				//Ming 2018-12-18 來信 指示 列表的標題文字，點擊後可另開視窗顯示前台畫面  ( 所有單元都是 ) 
				//$_href = '/'.str_replace('type','',$this->data['router_class']).'_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['id'];
				//$v['name'] = '<a href="'.$_href.'" target="_BREAK">'.$v['name'].'</a>';



				$this->data['listcontent'][$k] = $v;
			}
		}

		// 試著把這行註解
		// $this->data['main_content'] = $this->data['router_class'].'/index';
	}

	protected function getData()
	{
		if(0 and isset($this->data['def']['updatefield']['sections'][0]['field']['pid'])){
			$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ')->order('sort_id')->queryAll();
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

		$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';

		$this->index_get_total();

		$this->index_get_data();
		$this->index_last_handle();

		// 2018-08-29 分項節點(1/2) 父
		$node_fields = array();
		if(isset($this->data['def']['listfield']) and count($this->data['def']['listfield']) > 0){
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
		// var_dump($node_fields);die;

		// 分類圖的部份，有兩個地方哦
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					// ./assets/upload/producttype/018336b11773d2f10ddea2740a4d768c.jpg
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}

				// 2018-08-29 分項節點(2/2) 父
				if($node_fields and count($node_fields) > 0){
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

				//Ming 2018-12-18 來信 指示 列表的標題文字，點擊後可另開視窗顯示前台畫面  ( 所有單元都是 ) 
				//$_href = '/'.str_replace('type','',$this->data['router_class']).'_'.$this->data['admin_switch_data_ml_key'].'.php?id='.$v['id'];
				//$v['name'] = '<a href="'.$_href.'" target="_BREAK">'.$v['name'].'</a>';

				$this->data['listcontent'][$k] = $v;
			}
		}

		// 取得數量，用在排序的編號產出
		$this->data['class_sort_count'] = G::dbc('update', $this->data['def']);

		// 當pid為零的時候，代表現在在修改大分類，此時pid就是大分類的編號
		// 反之
		//$pid = 0;
		$pid = $this->data['updatecontent']['id'];
		$this->data['updatecontent']['name_parent'] = '';
		if($this->data['updatecontent']['pid'] != 0){
			//$pid = $this->data['updatecontent']['pid'];

			$row = $this->db->createCommand()->from($this->data['def']['table'])->where('id = '.$this->data['updatecontent']['pid'])->queryRow();
			if($row){
				$this->data['updatecontent']['name_parent'] = $row['name'];
			}
		} else {
			$this->data['def']['disable_index_normal_search'] = true;
			//$pid = $this->data['updatecontent']['id'];
			unset($this->data['def']['updatefield']['sections'][0]['field']['pid']);
		}	

		$this->data['def']['sortable']['condition'] = 'pid='.$pid.' and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';

		$this->data['sort_url'] .= '-'.$this->data['parameter']['value'].$this->data['updatecontent']['id'];

		$tmp = $this->data['updatecontent'];
		$tmp2 = $this->_get_product_classes($this->data);
		$this->data['breadcrumbs'] = array();

		// 2018-04-26 這個是舊的，留存好了
		// if($this->data['updatecontent']['pid'] != 0){
		// 	$tmp3 = $this->_search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$this->data['updatecontent']['pid']]['class_name'], $tmp['name']);
		// 	$this->data['breadcrumbs'] = $tmp3['keyvalue'];
		// }

		// 2018-04-26 修正麵包屑沒有正常顯示的問題，以及次分類名稱相同導致異常的問題
		$tmp3 = $this->_search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$pid]['class_name'].'__'.$pid);
		$this->data['breadcrumbs'] = $tmp3['keyvalue'];

		// 2016/5/8 取得該編號的層級數 lota
		$ggg = $this->judge_layer($this->data['updatecontent']['id']);
		$now_layer = $ggg['k'] + 1;

		// 2020-02-27 amy建議
		// 頂層分類提升的情況，上兩層不顯示圖片的話(2/2)
		// if($now_layer <= 2){
		// 	unset($this->data['def']['updatefield']['sections'][1]['field']['pic1']);
		// }

		/*
		 * 2017-11-01 補上產品層級數判斷的程式碼 ggg
		 */
		// unset($_constant);
		// eval('$_constant = '.strtoupper(str_replace('type','',$this->data['router_class']).'_add_later').';');
		// $add_later = $_constant;

		// unset($_constant);
		// eval('$_constant = '.strtoupper(str_replace('type','',$this->data['router_class']).'_type_later_num').';');
		// $later_num = $_constant;

		$add_later = true;
		$later_num = $this->data['later_num'];

		$this->data['updatecontent']['allow_child'] = true;
		if($add_later === false or $now_layer >= $later_num){
			$this->data['updatecontent']['allow_child'] = false;
		}

		// 選擇預設的修改樣版，並依照程式變數產生
		// $this->data['main_content'] = $this->data['router_class'].'/update'; // 試著把這行註解 2018-08-31
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'/'.$this->data['updatecontent']['id'];

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// 這是SEO的範本，如果你需要，就打開它 3/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';'); 
		if($_constant){
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php')){
				$seo_func = 'b';
				include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
			}
			
			$row = $this->db->createCommand()->from('seo')->where('seo_item_id=:id and seo_ml_key=:ml_key and seo_type=:type',array(':id'=>$this->data['updatecontent']['id'],'ml_key'=>$this->data['admin_switch_data_ml_key'],':type'=>$this->data['router_class']))->queryRow();
			if($row){
				$this->data['updatecontent'] = $this->data['updatecontent'] + $row;
			}
		}		

	}

	protected function update_run_other_element($array)
	{
		// 這是SEO的範本，如果你需要，就打開它 4/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';'); 
		if($_constant){
			$array['seo_type'] = $this->data['router_class'];
			if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php')){
				$seo_func = 'c';
				include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
			}
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		//Ming 2018-12-18 來信 指示 資料更新後，點擊送出後需返回列表頁 ( 所有單元都是 ),設定非資訊部人員才會動作 by lota
		if(!preg_match('/\,(999995)\,/', ','.$this->data['admin_type'].',')){
			$array['update_base64_url'] = '';
		}
			
		return $array;
	}

	protected function update_run_last()
	{
		if(isset($this->data['def']['listfield']['sort_id']) and isset($this->data['def']['condition']) and !empty($this->data['def']['condition'])){
			// 取得數量，用在排序的編號產出
			//$this->data['def']['condition'][0][1] = $_POST['pid'];

			// #35403
			$this->data['def']['condition'][0][1] = 'pid='.$_POST['pid'];
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);
	}

	protected function create_show_first($params)
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

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_show_last.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// $this->data['jqueryvalidation'] = json_encode($validation);

		// 選擇預設的修改樣版，並依照程式變數產生
		// $this->data['main_content'] = $this->data['router_class'].'/update'; // 2018-08-31 試著把這行註解
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_run_last() 
	{
		// 為了要支援sort_id改欄位名稱
		$sort_field = 'sort_id';
		if(isset($this->data['def']['func_field']['sort_id']) and $this->data['def']['func_field']['sort_id'] != ''){
			$sort_field = $this->data['def']['func_field']['sort_id'];
		}

		/*
		 * 2019-02-14
		 * 每筆新資料新增時，請排列到第一筆(原會最後一筆)(這裡是舊的)
		 * http://redmine.buyersline.com.tw:4000/issues/31012
		 */
		
		// $this->cidb->where('id', $this->data['_last_insert_id']);
		// $this->cidb->update($this->data['def']['table'], array($sort_field => 0));

		// // 重新排序
		// // 目前Fieldsorter不支援where以外的方法
		// if(isset($this->data['def']['listfield'][$sort_field])){
		// 	$fieldsorter = new Fieldsorter;
		// 	$fieldsorter->setTableName($this->data['def']['table']);
		// 	$fieldsorter->setIdName($this->data['def']['func_field']['id']);
		// 	if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
		// 		$fieldsorter->setCondition($this->data['def']['condition']);
		// 	}
		// 	//$fieldsorter->refresh();
		// 	$fieldsorter->refresh('', array(),'', $sort_field);
		// }

		/*
		 * 2020-08-19
		 * 試著寫寫看，新增的時候，會是第一筆
		 */
		if(isset($this->data['origin_condition'])){
			if(isset($this->data['datasave']['class_id']) and $this->data['datasave']['class_id'] > 0){ // 有單選的情況，先改零，在重排
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));
				
				// 單分類排序
				//$conditions[] = $k.'='.$v;

				$this->data['origin_condition'][0][1] .= ' AND class_id='.$this->data['datasave']['class_id'].' ';

				// 重新排序
				// 目前Fieldsorter不支援where以外的方法
				if(isset($this->data['def']['listfield'][$sort_field])){
					$fieldsorter = new Fieldsorter;
					$fieldsorter->setTableName($this->data['def']['table']);
					$fieldsorter->setIdName($this->data['def']['func_field']['id']);
					$fieldsorter->setCondition($this->data['origin_condition']);
					$fieldsorter->refresh('', array(),'', $sort_field);
				}
			} elseif (isset($this->data['datasave']['class_ids']) and $this->data['datasave']['class_ids'] !='') { //複選類別 預設使用 class_ids
				//將勾選的分類解析出來
				$_class_ids = array_filter(explode(',',$this->data['datasave']['class_ids']));
				if(count($_class_ids) > 0){
					//將勾選的分類分別的寫入專屬資料表
					foreach ($_class_ids as $key => $value) {
						$_data = array(
							'product_id' => $this->data['_last_insert_id'],
							'class_id' => $value,
							$sort_field => 0,
						);
						$this->cidb->insert($this->data['def']['table'].'multisort', $_data);					

						$this->data['origin_condition'][0][1] = ' class_id='.$value.' ';

						$fieldsorter = new Fieldsorter;
						$fieldsorter->setTableName($this->data['def']['table'].'multisort');
						$fieldsorter->setIdName($this->data['def']['func_field']['id']);
						$fieldsorter->setCondition($this->data['origin_condition']);
						$fieldsorter->refresh('', array(),'', $sort_field);	
					}	

					//如果已經按下search，那就先處理一下 , 從 actionSearch 拷貝過來的
					$ss = $this->data['router_class'].'_search';
					$session = Yii::app()->session[$ss];
					if($session === null){
						$session = array();
					}
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
					if($session and count($session) == 1 and isset($session['class_id']) and $session['class_id'] > 0){
						// 把該分類的sort_id洗掉，然後載入多分類排序資料表的資料，然後更新它
						$class_id = $session['class_id'];
						$rows = $this->db->createCommand()->from($this->data['router_class'].'multisort')->where('class_id='.$class_id)->order('sort_id')->queryAll();
						if($rows){
							foreach($rows as $k => $v){
								$data = array(
									'sort_id' => $v['sort_id'],
								);
								//$this->cidb->where('id',$v['product_id'])->update($this->data['router_class'], $data);
								$this->cidb->query('update '.$this->data['router_class'].' set sort_id='.$v['sort_id'].' where id='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
							}
						}
					}

				}
			} elseif(!isset($this->data['datasave']['class_id']) and !isset($this->data['datasave']['class_id'])){ // 分項的情況
				$this->cidb->where('id', $this->data['_last_insert_id']);
				$this->cidb->update($this->data['def']['table'], array($sort_field => 0));

				$fieldsorter = new Fieldsorter;
				$fieldsorter->setTableName($this->data['def']['table']);
				$fieldsorter->setIdName($this->data['def']['func_field']['id']);
				$fieldsorter->setCondition($this->data['origin_condition']);
				$fieldsorter->refresh('', array(),'', $sort_field);
			}
		}

	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		
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
			$this->data['def']['condition'][0][1] = 'pid='.$array['pid'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		}

		// funcfieldv3
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'create_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		return $array;
	}

	public function _get_product_classes($data)
	{
		// 取得所有的分類，目標做到2層以上
		$conditions = array(
			'ml_key' => $data['ml_key'],
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
	public function _search_product_class_tree($tree, $classes, $class_name, $char = ' / ')
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

		// 2018-08-07 在逢甲國際的無限層文章所遇到的問題
		if(isset($return_tmp['_orphans_'])){
			$return_tmp = $return_tmp['_orphans_'];
		}

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
				if(isset($classes[$v])){ // 2017-12-25 試著加這一個，看後續會不會壞掉
					$return['keyvalue'][$v] = $classes[$v]['class_name'];
					$return['values'][] = $classes[$v]['class_name'];
				}
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

	// 解無限層分類(不含頂層)
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable =1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}

}

// 懶得改Controller的名稱之三
//eval('class '.$filename.' extends NonameController {}');
