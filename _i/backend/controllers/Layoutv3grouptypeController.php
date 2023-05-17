<?php

/*
 * 無限層(獨立資料表)
 */

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,

		'table' => 'XXX',
		'orm' => 'Empty_orm',
		// 'orm' => 'XXX_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				// array('pid', 'required'),
				array('name', 'required'),
				array('pid, sort_id', 'length', 'max'=>11),
				//array('page_source_tmp', 'system.backend.extensions.myvalidators.arraycomma'),
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
			// 'pic1' => array(
			// 	//'label' => '圖片',
			// 	'mlabel' => array(
			// 		null, // category
			// 		'Image', // label
			// 		array(), // sprintf
			// 		'代表圖', // default
			// 	),
			// 	'width' => '10%',
			// 	'align' => 'center',
			// 	'sort' => false,
			// 	'kcfinder_small_img' => true,
			// ),
			'name' => array(
				'label' => '名稱',
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
							'label' => '名稱',
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
							'other' => array(
								'html_end' => '',
							),
						),
						'xx01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '<b>頂層</b><br />
								　群組名稱<br />
								<br />
								<b>其它層</b><br />
								　// HOLE (洞)<br />
								　-group (容器)<br />
								　$XXX (群組，路徑是group/XXX.php)<br />
								　YYY (一般區塊，路徑是view/YYY.php)<br />
								　%ZZZ (DB區塊)<br />
							',
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
						//'pid' => array(
						//	'label' => '上一層',
						//	'type' => 'input',
						//	'attr' => array(
						//		'id' => 'pid',
						//		'name' => 'pid',
						//		//'size' => '30',
						//	),
						//	'other' => array(
						//		'html_end' => '* 頂層編號(0)要修改之前，確定上一層己經建立並且存在',
						//	),
						//),
						'pid' => array(
							'label' => '位置',
							// 'type' => 'select3',
							'type' => 'select5',
							'attr' => array(
								'id' => 'pid',
								'name' => 'pid',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '0',
							),
						),
						'params' => array(
							'label' => '參數',
							'type' => 'input',
							'attr' => array(
								'id' => 'params',
								'name' => 'params',
								'size' => '60',
							),
							'other' => array(
								'html_end' => '(json)',
							),
						),
						'xx02' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '參數範例：<br />
								table_range:3x3 (畫一個3x3的表格)<br />
								table_range_custom:4231 (自定洞的位置，預設是從1開始，順序是由上到下，由左至右)<br />
								table_horizontal:1 轉成橫向，預設是直的<br />
								hole_tag:4321 定義挖洞標記是屬於哪一個位置，而挖洞標記在View裡面的用法是：&lt;?php echo $__?&gt; 記得是兩個底線
							',
							),
						),
						'table_content' => array(
							'label' => '<a href="/_i/redips_table/" target="_blank">自製結構</a>',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'table_content',
								'name' => 'table_content',
								'rows' => '6',
								'cols' => '40',
							),
						),						
						'get_redips_table_save' => array(
							'label' => '&nbsp;',
							'type' => 'checkbox',
							'merge' => '1',
							'attr' => array(
								'name' => 'get_redips_table_save',
								'type' => 'checkbox',
								'value' => '1',
							),
							'other' => array(
								'html_end' => '吸收，請先點擊“自製結構”的連結',
							),
						),
						'table_content01' => array(
							'label' => '預覽結構',
							'type' => 'inputn',
							//'type' => 'ckeditor_js',
							'other' => array(
								'html' => '',
							),
						),						
						'sort_id' => array(
							//'label' => 'ml:Sort',
							'mlabel' => array(
								null, // category
								'Sort id', // label
								array(), // sprintf
								'排序編號', // default
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
								//'other1' => 'ml:Enable',
								//'other2' => 'ml:Disable',
								'default' => '1',
							),
						),
					),
				),
				array(
					'form' => array('enable' => false),
					'type' => '2',
					'field' => array(
						'description' => array(
							'label' => '說明欄位',
							'type' => 'textarea',
							//'type' => 'ckeditor_js',
							'attr' => array(
								'class' => 'form-control', // 這…手動加上去好了
								'id' => 'description',
								'name' => 'description',
								'rows' => '4',
								'cols' => '40',
							),
						),						
						'description_label' => array(
							'label' => '<b>上層的說明欄位</b>',
							'type' => 'label',
						),						
					),
				),
				// funcfieldv3的產出欄位，放在任何位置都可以，有需要就打開 1/5
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
				// funcfieldv3的自定欄位，放在任何位置都可以，有需要就打開 2/5
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

		// $groups = array();		
		// //$groups[1]['value'] = '1: PC頁首 (top)';
		// //$groups[2]['value'] = '2: PC頁尾 (bottom)';
		// //$groups[3]['value'] = '3: 手機選單 (mobile)';	
		// //$groups[4]['value'] = '4: 其它1 (other1)';	
		// //$groups[5]['value'] = '5: 其它2 (other2)';	
		// $path = _BASEPATH.'/../source/page_sources.php';
		// $page_sources = array();
		// if(file_exists($path)){
		// 	include $path;
		// }
		// if(count($page_sources) > 0){
		// 	foreach($page_sources as $k => $v){
		// 		foreach($v as $kk => $vv){
		// 			$tmp = $k.'-'.$kk;
		// 			$tmp2 = $tmp.' ';
		// 			if(isset($vv['alias']) and $vv['alias'] != ''){
		// 				$tmp2 .= $vv['alias'];
		// 			}
		// 			$groups[$tmp]['value'] = $tmp2;
		// 		}
		// 	}
		// }

		// $this->data['positions'] = $groups;

		// foreach($groups as $k => $v){
		// 	$this->def['searchfield']['sections'][0]['field']['field_tmp']['other']['values'][$k] = $v['value'];
		// }

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		// $this->def['condition'][0][1] = 'pid=0 and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		// $this->def['sortable']['condition'] = 'pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		$this->def['condition'][0][1] = 'pid=0  ';
		$this->def['sortable']['condition'] = 'pid=0  ';

		if(isset($_GET['phytree'])){
			$file = _BASEPATH.'/../group/'.$_GET['phytree'].'.php';
			if(file_exists($file)){
				unset($group_struct);
				include $file;
				if(isset($group_struct)){
					//echo '<pre>'.var_export([0]['hole'],true).'</pre>';
					new dBug($group_struct[0],'');
				}
			}
			die;
		}

		if(isset($_GET['treeonly'])){
			$rows = $this->db->createCommand()->select('id,name as file,pid')->from($this->def['table'])->where('is_enable=1 ')->order('sort_id')->queryAll();

			echo '<meta charset="utf-8" />';
			$indexedItems = array();

			// index elements by id
			foreach ($rows as $item) {
				if($item['pid'] == 0 and $item['id'] != $_GET['treeonly']){
					$item['pid'] = 999888777666;
				}
				$item['hole'] = array();
				$indexedItems[$item['id']] = (object) $item;
			}

			// assign to parent
			$topLevel = array();
			foreach ($indexedItems as $item) {
				if ($item->pid == 0) {
					$topLevel[] = $item;
				} else {
					$indexedItems[$item->pid]->hole[] = $item;
				}
			}
			$tree = $this->std_class_object_to_array($topLevel);
			//var_dump($tree);die;
			$tmp = var_export($tree,true);
			$tmps = explode("\n",$tmp);
			foreach($tmps as $k => $v){
				if(preg_match('/\'(pid|id)\'/', $v)){
					unset($tmps[$k]);
				}
				if(preg_match('/hole/', $v) and preg_match('/NULL/', $v)){
					unset($tmps[$k]);
				}
			}
			eval('$tmpg = '. implode("\n", $tmps).';');
			new dBug($tmpg[0]['hole'][0],'');

			die;
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

		// funcfieldv3 有需要就打開 3/5
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
			// $rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1')->order('sort_id')->queryAll();
			// $rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'"')->order('sort_id')->queryAll();
			// $rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1 ')->order('sort_id')->queryAll();
			$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->order('sort_id')->queryAll();

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

						// 2018-03-08 加上群組結構的預覽
						if(preg_match('/^\$(.*)$/', $v['name'], $matches)){
							$row2 = $this->cidb->where('is_enable',1)->where('pid',0)->where('name',$matches[1])->get('layoutv3grouptype')->row_array();
							if($row2 and isset($row2['id'])){
								//$v['add'] .= ' <a href="javascript:;" onclick="$(\'#group_relation\').attr(\'src\',\'backend.php?r=layoutv3grouptype/update&param=v'.$row2['id'].'&treeonly='.$row2['id'].'\')">(虛擬)</a>';

								$url = 'backend.php?r=layoutv3grouptype/update&param=v'.$row2['id'].'&treeonly='.$row2['id'];
								$v['add'] .= ' <a href="javascript:;">(虛擬)</a><div class="boxg"><iframe src="'.$url.'" width="100%" height="400" frameborder="0" scrolling="auto"></iframe></div>';

								$v['add'] .= ' <a href="backend.php?r=layoutv3grouptype/update&param=v'.$row2['id'].'" title="前往">➞</a>';
							} else {
								//$v['add'] .= ' <a href="javascript:;" onclick="$(\'#group_relation\').attr(\'src\',\'backend.php?r=layoutv3grouptype/index&phytree='.$matches[1].'\')">(實體)</a>';

								// http://jsbin.com/urarem/3/edit
								$url = 'backend.php?r=layoutv3grouptype/index&phytree='.$matches[1];
								$v['add'] .= ' <a href="javascript:;">(實體)</a><div class="boxg"><iframe src="'.$url.'" width="100%" height="400" frameborder="0" scrolling="auto"></iframe></div>';
							}
						} elseif(preg_match('/^\%(.*)$/', $v['name'], $matches)){
							// DB View 暫不寫
						} else {
							if($v['name'] == '-group'){
								$v['add'] .= ' <span>(容器)</span>';
							} elseif($v['name'] == '// HOLE'){
								$v['add'] .= ' <span>(挖洞)</span>';
							} else { // 實體View
								$file = _BASEPATH.'/../view/'.$v['name'].'.php';
								if(file_exists($file)){

									// http://jsbin.com/urarem/3/edit
									$v['add'] .= ' <a href="javascript:;">(實體)</a><div class="boxg"><pre>'.htmlentities(file_get_contents($file)).'</pre></div>';

									$tmpggg = file_get_contents($file);
									$countg = 0;

									// 實體洞
									for($x=1;$x<=26;$x++){
										if(substr_count($tmpggg,'<'.'?'.'php echo $'.chr(64+$x).chr(64+$x).'?'.'>')){
											$countg++;
										}
									}
									if($countg > 0){
										$v['add'] .= ' <span>(洞'.$countg.')</span>';
									}

									// 挖洞標記
									$countg = substr_count($tmpggg,'<'.'?'.'php echo $__?'.'>');
									if($countg > 0){
										$v['add'] .= ' <span>(標記'.$countg.')</span>';
									}
								}
							}
						}
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

			// aaa是當層，就算是關閉也會出現，會顯示在上面
			if(preg_match('/^(create|update)$/', $this->data['router_method'])){
				$zid = 0;
				if(isset($params['value'][0])){
					$zid = $params['value'][0];
				}

				// 用笨的方式來查最上層，為了避免寫太過於多的程式碼在這裡
				for($x=1;$x<=15;$x++){
					$row = $this->cidb->where('id',$zid)->get('layoutv3grouptype')->row_array();
					if($row and isset($row['id'])){
						if($row['pid'] == 0){
							$zid = $row['id'];
							break;
						} else {
							$zid = $row['pid'];
						}
					}
				}

				$aaa = $bbb;
				foreach($aaa as $k => $v){
					// 當層以外的unset掉
					if($v['parentid'] == 0 and $v['id'] != $zid){
						unset($aaa[$k]);
					}
					if($v['parentid'] != 0 and isset($v['is_enable']) and $v['is_enable'] == 0){
						$aaa[$k]['name'] = '<span style="color:red">'.$aaa[$k]['name'].'</span>';
					}
				}

				// 因為換回原本舊的Tree Class，所以特地加上這一段
				foreach($aaa as $k => $v){
					if(!isset($v['parentid'])){
						$v['parentid'] = 0;
					}
					$v['parent_id'] = $v['parentid']; // 轉換一下，因為Tree class的運算是用parent_id這個欄位名稱
					$aaa[$k] = $v;
				}

				$tree_current = new Tree();
				$tree_current->init($aaa);

				$str = "<div style='\$current2\$current_pid2'>\$spacer <a href='\$menu_url\$id'>\$name</a> \$add \$current \$current_pid \$more </div>";
				$this->data['render_tree_current'] = $tree_current->get_tree('0', $str);
			} // update

			// bbb把沒啟用的刪掉
			foreach($bbb as $k => $v){
				if(isset($v['is_enable']) and $v['is_enable'] == 0){
					unset($bbb[$k]);
				}
			}

			// 如果總筆數到達40筆的時候，顯示方式改成只顯示本層
			if(0 and count($bbb) > 39){
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

			// if(isset($_GET['treeonly'])){
			// 	echo '<meta charset="utf-8" />';
			// 	echo '<link href="'.$this->assetsUrl.$this->data['template_path'].'/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>';
			// 	echo $this->data['render_tree'];die;
			// }

			if(!isset($params['value'][0]) and $this->data['router_method'] == 'create'){
				$this->data['render_tree'] .= '<span style="color:red;">(新增中)</span><br />';
			}
		}

		// 這是SEO欄位的範本，如果你需要，就打開它 2/4 
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if(file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') && $_constant ){
			$seo_func = 'a';
			include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
		}

		// 先處理最頂層，然後裡面的程序，才處理其它層
		$rows = $this->db->createCommand()->from($this->def['table'])->where('pid =0')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				// 大分類可選
				$this->def['updatefield']['sections'][0]['field']['pid']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';

				// 剩餘子層的處理程序
				$data_1 = $this->layout_show($v['id'],1,'　',$this->def['table']);//'　└'	
				if($data_1 and count($data_1) > 0){
					foreach($data_1 as $kk => $vv){
						$this->def['updatefield']['sections'][0]['field']['pid']['other']['values'][$kk] = $vv;
					}
				}
				// $this->def['updatefield']['sections'][0]['field']['pid']['other']['values'] += $data_1;
				// var_dump($this->def['updatefield']['sections'][0]['field']['pid']['other']['values']);die;
			}
		}

		return true;
	}

	// 判斷目前ID的層數 lota 2016/5/8
	function judge_layer($pid = 0,$k = 0)
	{
		if ($pid != 0){
			//$rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" and id ='.$pid)->queryRow();
			$rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('is_enable=1  and id ='.$pid)->queryRow();
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
		// 分類圖的部份，有兩個地方哦
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					// ./assets/upload/producttype/018336b11773d2f10ddea2740a4d768c.jpg
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				$this->data['listcontent'][$k] = $v;
			}
		}

		//$this->data['main_content'] = $this->data['router_class'].'/index';
	}

	protected function getData()
	{
		if(0 and isset($this->data['def']['updatefield']['sections'][0]['field']['pid'])){
			//$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ')->order('sort_id')->queryAll();
			$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 ')->order('sort_id')->queryAll();
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
		// if($updatecontent['pid'] == 0){
		// 	$tmp = explode(',', $this->data['updatecontent']['page_source_tmp']);
		// 	$groups = $this->data['positions'];

		// 	foreach($groups as $k => $v){
		// 		if(in_array($k, $tmp)){
		// 			//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
		// 			$groups[$k]['is_checked'] = 'checked'; // multicheckbox
		// 		}
		// 	}

		// 	$this->data['updatecontent']['page_source_tmp'] = $groups;
		// }

		$this->getData();

		$this->index_param_handle();

		//$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'].'  ';

		$this->index_get_total();

		$this->index_get_data();
		$this->index_last_handle();

		// 分類圖的部份，有兩個地方哦
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					// ./assets/upload/producttype/018336b11773d2f10ddea2740a4d768c.jpg
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
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
			//unset($this->data['def']['updatefield']['sections'][0]['field']['pid']);
		}	

		// $this->data['def']['sortable']['condition'] = 'pid='.$pid.' and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		$this->data['def']['sortable']['condition'] = 'pid='.$pid.'  ';

		$this->data['sort_url'] .= '-'.$this->data['parameter']['value'].$this->data['updatecontent']['id'];

		$tmp = $this->data['updatecontent'];
		$tmp2 = $this->_get_product_classes($this->data);
		$this->data['breadcrumbs'] = array();
		if($this->data['updatecontent']['pid'] != 0){
			$tmp3 = $this->_search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$this->data['updatecontent']['pid']]['class_name'].'__'.$this->data['updatecontent']['pid'], $tmp['name']);
// 			$tmp3 = _search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$class_id]['class_name'].'__'.$class_id);
			$this->data['breadcrumbs'] = $tmp3['keyvalue'];
		}

		// 2016/5/8 取得該編號的層級數 lota
		$ggg = $this->judge_layer($this->data['updatecontent']['id']);
		$now_layer = $ggg['k'] + 1;

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
		//$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'/'.$this->data['updatecontent']['id'];

		// 說明欄位，只有最頂層才有
		if($this->data['updatecontent']['pid'] != 0){
			$rowgg = $this->db->createCommand()->from($this->data['def']['table'])->where('id = '.$tmp3['ids'][0])->queryRow();
			$this->data['updatecontent']['description_label'] = nl2br($rowgg['description']);
			unset($this->data['def']['updatefield']['sections'][1]['field']['description']);
		} else {
			unset($this->data['def']['updatefield']['sections'][1]['field']['description_label']);
		}

		// funcfieldv3 有需要就打開 4/5
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

		$this->data['def']['updatefield']['sections'][0]['field']['table_content01']['other']['html'] = $this->data['updatecontent']['table_content'];

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

		// funcfieldv3 有需要就打開 5/5
		$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/include/funcfieldv3/').'update_run_other_element.php');
		$contentx = str_replace('<'.'?'.'php', '', $contentx);
		eval($contentx);

		// if(isset($array['page_source_tmp']) and count($array['page_source_tmp']) > 0){
		// 	// $array['page_source_tmp'] = implode(',', $array['page_source_tmp']);
		// } else {
		// 	$array['page_source_tmp'] = '';
		// }

		if(isset($array['get_redips_table_save']) and isset($_SESSION['save']['redips_table']['ggg']) and trim($_SESSION['save']['redips_table']['ggg']) != ''){
			$tmp = $_SESSION['save']['redips_table']['ggg'];
			$tmp = str_replace('&lt;','<',$tmp);
			$tmp = str_replace('&gt;','>',$tmp);

			// 因為防火牆的關係
			// layoutv3/cig_frontend/attack_check.php
			$tmp = str_replace('gggggggggggg',"'",$tmp);
			$tmp = str_replace('aaaaaaaaaaaa','"',$tmp);
			$array['table_content'] = '<table border="1">'."\n".$tmp."\n".'</table>'."\n";
		}
			
		return $array;
	}

	protected function create_run_last()
	{
		$datas = $this->data['datasave'];
		include 'backend/include/layoutv3_hole_auto.php';
	}


	protected function update_run_last()
	{
		if(isset($this->data['def']['listfield']['sort_id']) and isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
			// 取得數量，用在排序的編號產出
			$this->data['def']['condition'][0][1] = $_POST['pid'];
		}

		$datas = $this->data['dataupdate'];
		include 'backend/include/layoutv3_hole_auto.php';
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

		$this->data['jqueryvalidation'] = json_encode($validation);

		// 選擇預設的修改樣版，並依照程式變數產生
		//$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	// protected function create_show_last()
	// {
	// 	$this->data['updatecontent']['page_source_tmp'] = $this->data['positions'];
	// }

	protected function create_run_other_element($array)
	{
		//$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		
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
			//$this->data['def']['condition'][0][1] = 'pid='.$array['pid'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
			$this->data['def']['condition'][0][1] = 'pid='.$array['pid'].' ';
		}

		// if(isset($array['page_source_tmp']) and count($array['page_source_tmp']) > 0){
		// 	// $array['page_source_tmp'] = implode(',', $array['page_source_tmp']);
		// } else {
		// 	$array['page_source_tmp'] = '';
		// }

		return $array;
	}

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

	// 解無限層分類(不含頂層)
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		//$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ')->order('sort_id')->queryAll();
		$rows = $this->db->createCommand()->from($table)->where('pid ='.$id)->order('sort_id')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}

// https://blog.longwin.com.tw/2009/03/php-object-to-array-json-reader-cli-2009/
//
// 使用方式
// $rows = $this->db->createCommand()->from('producttype')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// $indexedItems = array();
// 
// foreach ($rows as $item) {
// 	$item['child'] = array();
// 	$indexedItems[$item['id']] = (object) $item;
// }
// 
// $topLevel = array();
// foreach ($indexedItems as $item) {
// 	if ($item->pid == 0) {
// 		$topLevel[] = $item;
// 	} else {
// 		$indexedItems[$item->pid]->child[] = $item;
// 	}
// }
// $tree = std_class_object_to_array($topLevel);
// var_dump($tree);
public function std_class_object_to_array($stdclassobject)
{
	$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

	foreach ($_array as $key => $value) {
		$value = (is_array($value) || is_object($value)) ? $this->std_class_object_to_array($value) : $value;
		$array[$key] = $value;
	}

	if(isset($array)){
		return $array;
	}
}


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
