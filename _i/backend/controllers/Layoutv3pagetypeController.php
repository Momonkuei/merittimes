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

		// 在各功能的上面的新增的右邊(匯出功能之一)
		'index_buttons' => array(
			array(
				'name' => '預覽(XXX)',  // 按鈕的名稱和圖示
				'name2' => 'export', // 假設create，那權限也是用create，那該功能也要開create(admin_resource)，雖然create早就有了，這裡只是範例而以
				'id' => '', // button
				'class' => 'btn btn-info', // button
		 		'onclick' => 'javascript:location.href=\'XXX\'',
			),
		),

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
				array('page_source_tmp', 'system.backend.extensions.myvalidators.arraycomma'),
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
				'',
				//'pid=0',
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
				'label' => '選單名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'選單名稱', // default
				//),
				'width' => '10%',
				'sort' => true,
			),
			'theme_name' => array(
				'label' => 'Theme',
				'width' => '10%',
				//'sort' => true,
			),
			'other_func' => array(
				'label' => '其它頁面',
				'width' => '30%',
				//'sort' => true,
			),
			'description' => array(
				'label' => '說明欄位',
				'width' => '20%',
				//'sort' => true,
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
			'debug' => array(
				'label' => '前台開發',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
				'ezfield' => 'debug',
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
		'searchfield' => array(
			// jquery-validate, jquery-datepicker
			'head' => array(
				'jquery-validate',
			),
			//'smarty_javascript' => '',
			'smarty_javascript_text' => '',
			'method' => 'update',
			'form' => array(
				'enable' => true,
				'attr' => array(
					'id' => 'form_data_search',
					'name' => 'form_data_search',
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
						'theme_name' => array(
							'label' => 'Theme',
							'translate_source' => 'tw',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'theme_name',
								'name' => 'theme_name',
							),
							'other' => array(
								'values' => array(
									'' => '請選擇',
									'view' => '政佳',
									'jane' => '家榛',
									'v3' => '設計V3',
									'v4' => '設計V4',
								),
								'default' => '',
							),
						),
					),
				),
			),
		),
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
						),
						'other_func' => array(
							'label' => '　└ 其它頁面',
							'type' => 'input',
							'attr' => array(
								'id' => 'other_func',
								'name' => 'other_func',
								'size' => '80',
							),
							'other' => array(
								'html_end' => '半型逗分隔',
							),
						),
						'xx01' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '<b>一般區塊</b><br />
								　v3/about/html2_1 (這是範例，含相對路徑，不含點PHP)<br />
								　system/hole1 (只有一個洞，其它什麼都沒有)<br />
								　system/empty (真的是空白，真的什麼都沒有)<br />
								<br />
								<b>其它</b><br />
								　-group (容器，如果只有一個洞，但要放很多的情況，就要先放這個容器)<br />
								　system/holes (它本身什麼都沒有，但是會跟隨它底下的內容，而動態產生標記，用處跟容器一樣，但運作原理跟容器完全不一樣)<br />
								　$XXX (群組，實體路徑是group/XXX.php，後台功能是在：<a href="/_i/backend.php?r=layoutv3grouptype" target="_blank">這裡</a>)<br />
								　%ZZZ (DB區塊，後台功能是在：<a href="/_i/backend.php?r=layoutv3view">這裡</a>)<br />
								<br />
								<b>內頁資料流 (會餵資料給下一個view)</b><br />
								　$內頁資料流-分項單筆 (例：最新消息)<br />
								　$內頁資料流-單頁<br />
								　$內頁資料流-分類單筆 (例：多層文章、公司簡介)<br />
								　$內頁資料流-累加圖 (例：產品)<br />
								　$內頁資料流-相簿多圖<br />
								　detailvalue___topic (輸出PHP單筆的欄位資料)<br />
								<br />
								<b>簡易資料多筆 (會餵資料給下一個view)</b><br />
								　cidb___rows___(資料表名稱)___(通用的型態|獨立的隨便打)___(1是輸出陣列內容)<br />
								　例如：cidb___rows___html___news___0 (通用)<br />
								　例如：cidb___rows___product___xxx___0 (獨立)<br />
								<br />
								<b>簡易資料單筆 (會餵資料給下一個view)</b><br />
								　cidb___row___(資料表名稱)___(通用的型態|獨立的隨便打)___(帶編號|如果是輸入"id"，就是帶GET的id)___(1是輸出陣列內容)<br />
								　例如：cidb___row___html___news___id___0 (通用單筆)<br />
								　例如：cidb___row___product___xxx___666___0 (獨立單筆)<br />
								<br />
								<b>複雜條件 (會餵資料給下一個view，請先在這裡下條件：<a href="/_i/backend.php?r=datasource" target="_blank">這裡</a>)</b><br />
								　datasource___(編號)<br />
								　例如：datasource___1689<br />
								<br />
								<b>HTML (支援V1第二版的多筆規則)</b><br />
								　htmltags___div (有頭尾的標籤，例如div, p, span, h1)<br />
								　htmltag___img (一般的標籤，例如img, br)<br />
								　htmlvalue___topic (輸出V1第二版的欄位資料)<br />
								<br />
								<b>載入檔案 (第二個參數是選擇性的，如果是1，就會加上php結尾後才載入執行)</b><br />
								　include___source/core.php___1<br />
								<br />
								<b>抓取多筆指定範圍內的陣列元素(從0開始)</b><br />
								　array_range___0___2 (從頭開始，抓3個)<br />
								　array_range___4___1 (反向抓取，抓4個)<br />
								　array_range___2___? (從第3筆到尾)<br />
								　array_range___1___4___ID (只處理layoutv3的變數，可以這樣下：rows|ID|general_item)<br />
								<br />
								<b>節點抓取外部結構system/other_page，參數如下：</b><br />
								　other_page_1：table<br />
								　other_page_2：type<br />
								　other_page_3：file對應哪一個欄位<br />
								　other_page_4：parent_id對應哪一個欄位<br />
								　other_page_5：params對應哪一個欄位<br />
								<br />
							',
							),
						),
						'theme_name' => array(
							'label' => 'Theme',
							'type' => 'select3',
							'attr' => array(
								'id' => 'theme_name',
								'name' => 'theme_name',
							),
							'other' => array(
								'values' => array(
									'view' => '政佳',
									'jane' => '家榛',
									'v3' => '設計V3',
									'v4' => '設計V4',
								),
								'default' => 'v4',
							),
						),
						// 把它的說明欄位帶過來
						'xx02' => array(
							'label' => '&nbsp;',
							'type' => 'inputn',
							'other' => array(
								'html' => '',
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
						// 'pid' => array(
						// 	'type' => 'hidden',
						// 	'attr' => array(
						// 		'id' => 'pid',
						// 		'name' => 'pid',
						// 		//'size' => '30',
						// 	),
						// ),
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
						'page_source_tmp' => array(
							'label' => '資料來源',
							//'type' => 'multiselect',
							'type' => 'multicheckbox',
							'attr' => array(
								'type'=>'checkbox',
								//'id' => 'field_tmp',
								'name' => 'page_source_tmp[]',
								//'size' => '3',
							),
							'other' => array(
								'split' => '',
								'split2' => '<br />',
								'count' => 1, // 這裡本來是5
								'values' => array(),
								//'default' => 'center',
							),							
							/*
							'other2' => array(
								'1' => '頁首',
								'2' => '頁尾',
								'3' => '手機選單',
							),
							*/
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
							'other' => array(
								'html_end' => '<br />
								<p style="color:red">*格式為json</p>
								<b>調整挖洞標記的位置</b><br />
								hole_tag:4321 定義挖洞標記的順序，而挖洞標記在View裡面的用法是：&lt;?php echo $__?&gt; 記得是兩個底線 <br />
								<br />
								<b>載入程式範例 (相對路徑)，參數1：如果是1，就會加php結尾，參數2的部份，是相對路徑逗號第二個的是否要加php結尾，依此類推</b><br />
								<b>如果要載入source/core.php，請不要跟LayoutV3規則混用(page_source)，因為一定會衝突，只能用在A方案，要沒有使用V3規則、而且是用預載程式碼的方式才可以正常</b><br />
								include_0:source/XXX.php,include_1:1 (單支程式範例)<br />
								include_0:source/system/form_post.php，source/XXX.php,include_1:1,include_2:1 (多支程式範例)<br />
								<br />
								<b>簡易資料多筆範例</b><br />
								cidb_0:,cidb_1:rows,cidb_2:html,cidb_3:news,cidb_4:0<br />
								<br />
								<b>簡易資料單筆範例</b><br />
								cidb_0:,cidb_1:row,cidb_2:html,cidb_3:news,cidb_4:539,cidb_5:0<br />
								<br />
								<b>複雜條件範例 (請先在這裡下條件：<a href="/_i/backend.php?r=datasource" target="_blank">這裡</a>)</b><br />
								datasource_0:,datasource_1:1689<br />
								<br />
								<b>抓取多筆指定範圍內的陣列元素(其它參數請參照上面)</b><br />
								array_range_0:,array_range_1:0,array_range_2:2<br />
								<br />
								<b>動態欄位替換 (<a href="/_i/backend.php?r=layoutv3field" target="_blank">欄位對應在這</a>)</b><br />
								<b>fieldhole_1是0的情況，是PHP多筆 (預設)</b><br />
								<b>fieldhole_1是1的情況，是V1第二版</b><br />
								<b>fieldhole_1是2的情況，就是用php單筆</b><br />
								<b>view那邊，是用五個底線來代表一個欄位</b><br />
								fieldhole_0:,fieldhole_1:1<br />
							',
							),
						), 
						'fieldhole01' => array(
							'label' => '動態欄位',
							'type' => 'inputn',
							'attr' => array(
								'id' => 'params',
								'name' => 'params',
								'size' => '60',
							),
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

		// (匯出功能之二)
		$this->def['index_buttons'][0]['onclick'] = 'javascript:location.href=\''.$this->createUrl($this->data['router_class'].'/preview').'\'';

		$ss = $this->data['router_class'].'_preview';
		$session = Yii::app()->session[$ss];

		$need_preview = false;
		if(isset($session['status'])){
			if($session['status'] === true){
				$need_preview = true;
				$this->def['index_buttons'][0]['name'] = '預覽(開)';
			} else {
				$need_preview = false;
				$this->def['index_buttons'][0]['name'] = '預覽(關)';
			}
		} else {
			$need_preview = false;
			$this->def['index_buttons'][0]['name'] = '預覽(關)';
		}

		if(isset($_GET['phytree'])){
			$file = _BASEPATH.'/../parent/'.$_GET['phytree'].'.php';
			if(file_exists($file)){
				unset($page);
				$aaa = file_get_contents($file);
				$aaas = explode("\n",$aaa);
				$bbbs = array();
				$start = false;
				foreach($aaas as $k => $v){
					if(preg_match('/page_source/', $v)){
						break;
					}
					if($start === true){
						$bbbs[] = $v;
					}
					if(preg_match('/\$page\ /', $v)){
						$start = true;
						$bbbs[] = $v;
					}
				}
				eval(implode("\n",$bbbs));
				if(isset($page)){
					//echo '<pre>'.var_export([0]['hole'],true).'</pre>';
					new dBug($page[0],'');
				}
			}
			die;
		}

		if(isset($_GET['treeonly'])){
			$rows = $this->db->createCommand()->select('id,name as file,pid')->from($this->def['table'])->where('is_enable =1')->order('sort_id')->queryAll();

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

		$groups = array();		
		//$groups[1]['value'] = '1: PC頁首 (top)';
		//$groups[2]['value'] = '2: PC頁尾 (bottom)';
		//$groups[3]['value'] = '3: 手機選單 (mobile)';	
		//$groups[4]['value'] = '4: 其它1 (other1)';	
		//$groups[5]['value'] = '5: 其它2 (other2)';	
		$path = _BASEPATH.'/../source/page_sources.php';
		$page_sources = array();
		if(file_exists($path)){
			include $path;
		}
		if(count($page_sources) > 0){
			foreach($page_sources as $k => $v){
				foreach($v as $kk => $vv){
					$tmp = $k.'-'.$kk;
					$tmp2 = $tmp.' ';
					if(isset($vv['alias']) and $vv['alias'] != ''){
						$tmp2 .= $vv['alias'];
					}
					$groups[$tmp]['value'] = $tmp2;
				}
			}
		}

		$this->data['positions'] = $groups;

		// foreach($groups as $k => $v){
		// 	$this->def['searchfield']['sections'][0]['field']['field_tmp']['other']['values'][$k] = $v['value'];
		// }
		
		// 無法帶入的變數中的變數，在這裡帶入
		// $this->def['condition'][0][0] = 'where';
		// $this->def['condition'][0][1] = 'pid=0  ';
		// $this->def['sortable']['condition'] = 'pid=0  ';

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['theme_name'] = -1;

		$condition = ' pid=0 ';
		$condition_sortable = ' pid=0 ';
		// $condition = ' ';
		// $condition_sortable = ' ';

		// if(isset($session) and count($session) > 0){
		// 	//2016/4/29 如果有下搜尋條件，則設定排序為sort_id
		// 	//$this->def['default_sort_field'] = 'sort_id';//2016/6/15 捨棄，改用index_first()內的方式

		// 	$conditions = array();
		// 	$conditions_sortable = array();
		// 	foreach($session as $k => $v){
		// 		if($v == '') continue;
		// 		if($k == 'theme_name' and $v == -1) continue;

		// 		$this->data['updatecontent'][$k] = $v;

		// 		if($k == 'ggg_xxx'){
		// 			$conditions[] = $k.'='.$v;
		// 			$conditions_sortable[] = $k.'='.$v;
		// 		} elseif($k == 'theme_name'){
		// 			$conditions[] = $k.'=\''.$v.'\'';
		// 			$conditions_sortable[] = $k.'="'.$v.'"';
		// 		} else {
		// 			$conditions[] = $k.' LIKE \'%'.$v.'%\'';
		// 			$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
		// 		}
		// 		//var_dump($conditions);
		// 		//die;
		// 	}
		// 	if(count($conditions) > 0){
		// 		if($condition != ''){
		// 			$condition .= ' AND ';
		// 		}
		// 		$condition .= implode(' AND ', $conditions);
		// 	}
		// 	if($condition != ''){ 
		// 		$this->def['condition'][0] = array(
		// 			'where',
		// 			// 不一樣的地方在這裡
		// 			//' pid=0 '.$condition,
		// 			$condition,
		// 		);
		// 	}
		// 	if(count($conditions_sortable) > 0){
		// 		if($condition_sortable != ''){
		// 			$condition_sortable .= ' AND ';
		// 		}
		// 		// 疑似Bug 2017-03-24 己經修好了 有分類的排序會用到 by lota
		// 		$condition_sortable .= implode(' AND ', $conditions_sortable);
		// 	}
		// 	if($condition_sortable != ''){
		// 		$this->def['sortable']['condition'] = ' pid=0 '.$condition_sortable;
		// 	}
		// 	//var_dump($this->def['condition']);
		// 	//die;
		// } else {
		// 	if(trim($condition) != ''){
		// 		$this->def['condition'][] = array(
		// 			'where',
		// 			//$condition,
		// 			' pid=0 ',
		// 		);
		// 	}
		// 	if(trim($condition_sortable) != ''){
		// 		//$this->def['sortable']['condition'] = $condition_sortable;
		// 		$this->def['sortable']['condition'] = ' pid=0 ';
		// 	}
		// }
		// var_dump($this->def['sortable']);die;

		if(isset($session) and !empty($session)){
			//2016/4/29 如果有下搜尋條件，則設定排序為sort_id
			//$this->def['default_sort_field'] = 'sort_id';//2016/6/15 捨棄，改用index_first()內的方式

			$conditions = array();
			$conditions_sortable = array();
			foreach($session as $k => $v){
				if($v == '') continue;
				if($k == 'class_id' and $v == -1) continue;
				//if($k == 'addr_area_2' and $v == -1) continue;
				//if($k == 'member_level' and $v == -1) continue;
				//if($k == 'service_ids' and $v == -1) continue;
				//if($k == 'is_enable' and $v == -1) continue;

				$this->data['updatecontent'][$k] = $v;

				if($k == 'class_id'){
					if(isset($rowg['other26']) and $rowg['other26'] == 1){ // 是否為“多分類排序”
						// [多分類排序]
						$conditions[] = 'class_ids LIKE \'%,'.$v.',%\''; // 因為condition的部份要特別處理
						$conditions_sortable[] = 'class_ids LIKE "%,'.$v.',%"';
					} else {
						// 單分類排序
						$conditions[] = $k.'='.$v;
						$conditions_sortable[] = $k.'='.$v;
					}
				} elseif(preg_match('/^(id|sort_id|sort_id_browser|sort_id_home|is_news|is_top|is_home|is_enable)$/', $k)){ // 2020-01-22
					$conditions[] = $k.'='.$v;
					$conditions_sortable[] = $k.'='.$v;
				// 2018-10-18
				// http://redmine.buyersline.com.tw:4000/issues/29538?issue_count=81&issue_position=2&next_issue_id=29493&prev_issue_id=29561#note-1
				} elseif($k == 'keyword'){
					if($rowg){
						if(isset($rowg['class_ids']) and $rowg['class_ids'] == 1){ // 通用分項
							$k = 'topic';
						} else {
							$k = 'name';
						}
					} else {
						$k = 'topic';
					}
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(!empty($conditions)){
				if(trim($condition) != ''){
					$condition .= ' AND ';
				}
				$condition .= implode(' AND ', $conditions);
			}
			if($condition != ''){
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			if(!empty($conditions_sortable)){
				if($condition_sortable != ''){
					$condition_sortable .= ' AND ';
				}
				// 疑似Bug 2017-03-24 己經修好了 有分類的排序會用到 by lota
				$condition_sortable .= implode(' AND ', $conditions_sortable);
			}
			if($condition_sortable != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}

			// 2020-07-28 有搜尋，就不顯示theme_name
			unset($this->def['listfield']['theme_name']);

			//var_dump($this->def['condition']);
			//die;
		} else {
			// 2020-07-28 沒按搜尋，不能排序
			unset($this->def['listfield']['sort_id']);
			unset($this->def['listfield']['is_enable']);
			$this->def['disable_action'] = true;

			if(trim($condition) != ''){
				$this->def['condition'][0] = array(
					'where',
					$condition,
				);
			}
			if(trim($condition_sortable) != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
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
			$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->order('sort_id')->queryAll(); // 取得全部，包含關閉的


			if(isset($session) and count($session) > 0){
				if($rows and count($rows) > 0){
					foreach($rows as $k => $v){
						if($v['pid'] == 0){
							if(isset($session['theme_name']) and $session['theme_name'] != -1 and $session['theme_name'] != '' and $session['theme_name'] == $v['theme_name']){
								// do nothing
							} else {
								unset($rows[$k]);
							}
						}
					}
				}
			} else {
				// do nothing
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

						if($v['pid'] == 0 and $need_preview === true){
							$url = '/'.$v['name'].'_'.$this->data['ml_key'].'.php?__print_table__=1';
							$v['add'] .= ' <a href="javascript:;">(示意)</a><div class="boxg"><iframe src="'.$url.'" width="100%" height="500" frameborder="0" scrolling="auto"></iframe></div>';
						}

						// 2018-03-08 加上群組結構的預覽
						if(preg_match('/^\$(.*)$/', $v['name'], $matches)){
							$row2 = $this->cidb->where('is_enable',1)->where('pid',0)->where('name',$matches[1])->get('layoutv3grouptype')->row_array();
							if($row2 and isset($row2['id'])){
								// $v['add'] .= ' <a href="javascript:;" onclick="$(\'#group_relation\').attr(\'src\',\'backend.php?r=layoutv3grouptype/update&param=v'.$row2['id'].'&treeonly='.$row2['id'].'\')">(虛擬)</a>';

								if($need_preview === true){
									$url = 'backend.php?r=layoutv3grouptype/update&param=v'.$row2['id'].'&treeonly='.$row2['id'];
									$v['add'] .= ' <a href="javascript:;">(虛擬)</a><div class="boxg"><iframe src="'.$url.'" width="100%" height="400" frameborder="0" scrolling="auto"></iframe></div>';
								}

								// 看一下虛擬的有幾個洞
								$rowsgg = $this->db->createCommand()->select('id,name as file,pid')->from('layoutv3grouptype')->where('is_enable=1 ')->order('sort_id')->queryAll();
								$indexedItems = array();

								// index elements by id
								foreach ($rowsgg as $item) {
									if($item['pid'] == 0 and $item['id'] != $row2['id']){
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
								$treeg = $this->std_class_object_to_array($topLevel);
								$tmp = var_export($treeg,true);
								$tmpsgg = explode("\n",$tmp);
								foreach($tmpsgg as $kgg => $vgg){
									if(preg_match('/\'(pid|id)\'/', $vgg)){
										unset($tmpsgg[$kgg]);
									}
									if(preg_match('/hole/', $vgg) and preg_match('/NULL/', $vgg)){
										unset($tmpsgg[$kgg]);
									}
								}
								$tmpggg = implode("\n",$tmpsgg);
								$countg = substr_count($tmpggg,'// HOLE');
								if($countg > 0){
									$v['add'] .= ' <span>(洞'.$countg.')</span>';
								}

								$v['add'] .= ' <a href="backend.php?r=layoutv3grouptype/update&param=v'.$row2['id'].'" title="前往">➞</a>';
							} else {
								// $v['add'] .= ' <a href="javascript:;" onclick="$(\'#group_relation\').attr(\'src\',\'backend.php?r=layoutv3grouptype/index&phytree='.$matches[1].'\')">(實體)</a>';
								// 實體的沒有連結，是因為就實體檔案，要看自己開檔案來看

								if($need_preview === true){
									// http://jsbin.com/urarem/3/edit
									$url = 'backend.php?r=layoutv3grouptype/index&phytree='.$matches[1];
									$v['add'] .= ' <a href="javascript:;">(實體)</a><div class="boxg"><iframe src="'.$url.'" width="100%" height="400" frameborder="0" scrolling="auto"></iframe></div>';
								}

								// 看一下實體的有幾個洞
								$file = _BASEPATH.'/../group/'.$matches[1].'.php';
								if(file_exists($file)){
									$tmpggg = file_get_contents($file);
									$countg = substr_count($tmpggg,'// HOLE');
									if($countg > 0){
										$v['add'] .= ' <span>(洞'.$countg.')</span>';
									}
								}
							}
						} elseif(preg_match('/^\%(.*)$/', $v['name'], $matches)){
							// DB View 暫不寫
						} else {
							if($v['name'] == '-group'){
								$v['add'] .= ' <span>(容器)</span>';
							} elseif($v['name'] == '// HOLE'){
								$v['add'] .= ' <span>(挖洞)</span>';
							} elseif($v['name'] == 'system/holes'){
								$v['add'] .= ' <span>(動態標記)</span>';
							} else { // 實體View
								$file = _BASEPATH.'/../view/'.$v['name'].'.php';
								if(file_exists($file)){

									if($need_preview === true){
										// http://jsbin.com/urarem/3/edit
										$v['add'] .= ' <a href="javascript:;">(實體)</a><div class="boxg"><pre>'.htmlentities(file_get_contents($file)).'</pre></div>';
									}

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
					$row = $this->cidb->where('id',$zid)->get('layoutv3pagetype')->row_array();
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
					//unset($bbb[$k]);
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

			/*
			 * 此時的bbb變數，是還沒有結合的
			 */

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

		// var_dump($this->def['updatefield']['sections'][0]['field']['pid']);

		return true;
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

				$v['other_func'] = '<span title="'.$v['other_func'].'">'.$this->short_name($v['other_func'],70).'</span>';

				$this->data['listcontent'][$k] = $v;
			}
		}

		//$this->data['main_content'] = $this->data['router_class'].'/index';
	}

	// http://php.net/manual/en/function.substr.php#78019
	protected function short_name($str, $limit)
	{
		// Make sure a small or negative limit doesn't cause a negative length for substr().
		if ($limit < 3)
		{
			$limit = 3;
		}

		// Now truncate the string if it is over the limit.
		if (strlen($str) > $limit)
		{
			return substr($str, 0, $limit - 3) . '...';
		}
		else
		{
			return $str;
		}
	}

	protected function getData()
	{
		if(0 and isset($this->data['def']['updatefield']['sections'][0]['field']['pid'])){
			//$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ')->order('sort_id')->queryAll();
			$rows = $this->db->createCommand()->from($this->def['table'])->where('is_enable=1 and pid=0  ')->order('sort_id')->queryAll();
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
		if($updatecontent['pid'] == 0){
			$tmp = explode(',', $this->data['updatecontent']['page_source_tmp']);
			$groups = $this->data['positions'];

			foreach($groups as $k => $v){
				if(in_array($k, $tmp)){
					//$groups[$v['id']]['is_selected'] = 'selected'; // multiselect
					$groups[$k]['is_checked'] = 'checked'; // multicheckbox
				}
			}

			$this->data['updatecontent']['page_source_tmp'] = $groups;
		}


		$this->getData();

		$this->index_param_handle();

		//$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		//$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'].'  ';

		// 2018-10-02
		$this->data['def']['condition'] = array(
			array('where', ' pid='.$this->data['updatecontent']['id'].' ')
		);
		$this->data['def']['sortable']['condition'] = ' pid='.$this->data['updatecontent']['id'].' ';

		$this->index_get_total();

		$this->index_get_data();

		// 因為只有method index才會有那個欄位，放在這裡是因為，才有辦法刪掉這個欄位
		unset($this->data['def']['listfield']['other_func']);

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
			unset($this->data['def']['updatefield']['sections'][0]['field']['other_func']);
			unset($this->data['def']['updatefield']['sections'][0]['field']['theme_name']);
		} else {
			$this->data['def']['disable_index_normal_search'] = true;
			//$pid = $this->data['updatecontent']['id'];
			// unset($this->data['def']['updatefield']['sections'][0]['field']['pid']);
		}	

		//$this->data['def']['sortable']['condition'] = 'pid='.$pid.' and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		$this->data['def']['sortable']['condition'] = 'pid='.$pid.'  ';
		// echo $this->data['def']['sortable']['condition'];die;

		$this->data['sort_url'] .= '-'.$this->data['parameter']['value'].$this->data['updatecontent']['id'];

		$tmp = $this->data['updatecontent'];
		$tmp2 = $this->_get_product_classes($this->data);
		$this->data['breadcrumbs'] = array();
		if($this->data['updatecontent']['pid'] != 0){
			$tmp3 = $this->_search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$this->data['updatecontent']['pid']]['class_name'], $tmp['name']);
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

		// 把它的說明帶過來
		if(preg_match('/^\$(.*)$/', $this->data['updatecontent']['name'], $matches)){ // 群組
			$row = $this->cidb->where('is_enable',1)->where('pid',0)->where('name',$matches[1])->get('layoutv3grouptype')->row_array();
			if($row and isset($row['id'])){
				$this->data['def']['updatefield']['sections'][0]['field']['xx02']['other']['html'] = nl2br($row['description']);
			}
		} elseif(preg_match('/^\%(.*)$/', $this->data['updatecontent']['name'], $matches)){ // 區塊
			$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['admin_switch_data_ml_key'])->where('type','layoutv3view')->where('topic',$matches[1])->get('html')->row_array();
			if($row and isset($row['id'])){
				$this->data['def']['updatefield']['sections'][0]['field']['xx02']['other']['html'] = nl2br($row['field_data']);
			}
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

		$rows = $this->cidb->where('is_enable',1)->where('class_id',$updatecontent['id'])->order_by('sort_id','asc')->get('layoutv3field')->result_array();
		$result = '';
		if($rows){
			foreach($rows as $k => $v){
				$tmp = $v['name'];
				$tmp = str_replace('ggg1_','',$tmp);
				$tmp = str_replace('ggg2_','',$tmp);
				$result .= ((int)$k+1).'. '.$tmp.'<br />';
			}
			$result .= '<br />(<a href="/_i/backend.php?r=layoutv3field&id='.$updatecontent['id'].'" target="_blank">欄位對應在這</a>)';
		}
		$this->data['def']['updatefield']['sections'][0]['field']['fieldhole01']['other']['html'] = $result;

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

		if(isset($array['page_source_tmp']) and count($array['page_source_tmp']) > 0){
			// $array['page_source_tmp'] = implode(',', $array['page_source_tmp']);
		} else {
			$array['page_source_tmp'] = '';
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
		// $this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
	}

	protected function create_show_last()
	{
		if(isset($this->data['params']['value'][0])){
			$this->data['updatecontent']['page_source_tmp'] = $this->data['positions'];
		} else {
			// do nothing
		}

		// 2020-08-03
		$this->data['def']['updatefield']['sections'][0]['field']['theme_name']['other']['default'] = LAYOUTV3_THEME_NAME;
	}

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
		if(isset($this->data['def']['condition']) and !empty($this->data['def']['condition'])){
			//$this->data['def']['condition'][0][1] = 'pid='.$array['pid'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
			$this->data['def']['condition'][0][1] = 'pid='.$array['pid'].' ';
		}

		if(isset($array['page_source_tmp']) and !empty($array['page_source_tmp'])){
			// $array['page_source_tmp'] = implode(',', $array['page_source_tmp']);
		} else {
			$array['page_source_tmp'] = '';
		}

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
				if(isset($classes[$v])){ // unknow bug 2018-03-19
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

	// 判斷目前ID的層數 lota 2016/5/8
	function judge_layer($pid = 0,$k = 0)
	{
		if ($pid != 0){
			//$rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" and id ='.$pid)->queryRow();
			// $rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('is_enable =1 and id ='.$pid)->queryRow();
			$rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('id ='.$pid)->queryRow();
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

	// 解無限層分類(不含頂層)
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('pid ='.$id)->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){						
				$data[$v['id']] = $tt.$v['name'];
				$data = $this->layout_show($v['id'],$k+1,$tt,$table,$data);
			}
			return $data;
		}else
			return $data;		
	}

	public function actionPreview()
	{
		$ss = $this->data['router_class'].'_preview';
		$session = Yii::app()->session[$ss];

		$status = false; // 預設是關閉的
		if(isset($session['status'])){
			$status = $session['status'];
		}

		if($status === true){
			$session['status'] = false;
		} else {
			$session['status'] = true;
		}
		Yii::app()->session[$ss] = $session;
		header('Location: '.$this->createUrl($this->data['router_class'].'/index'));
	}

	// http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result
	protected function buildTree(array $elements, $parentId = 0) {
		$branch = array();

		foreach ($elements as $element) {
			if ($element['parent_id'] == $parentId) {
				$children = $this->buildTree($elements, $element['id']);
				if ($children) {
					$element['hole'] = $children;
				}
				$branch[] = $element;
			}
		}

		return $branch;
	}

	public function actionLayoutit()
	{
		$debug = false;

		if(!isset($_SESSION['layoutit_router_method']) or $_SESSION['layoutit_router_method'] == ''){
			header('HTTP/1.1 500 Internal Server Error'); 
			return;
		}
		$router_method = $_SESSION['layoutit_router_method'];

		if(isset($_POST['exit']) and $_POST['exit'] == '1' and !isset($_POST['aaa'])){
			$this->cidb->where('name', $router_method);
			$this->cidb->update('layoutv3pagetype', array('debug'=>0)); 
			// echo \$this->cidb->affected_rows();

			die;
		} elseif(isset($_POST['showphp']) and $_POST['showphp'] == '1' and !isset($_POST['aaa'])){
			if(isset($_SESSION['layoutit_showphp'])){
				unset($_SESSION['layoutit_showphp']);
			} else {
				$_SESSION['layoutit_showphp'] = '';
			}

			die;
		}

		$row = $this->cidb->where('name', $router_method)->get('layoutv3pagetype')->row_array();

		if(!isset($row)){
			header('HTTP/1.1 500 Internal Server Error'); 
			return;
		}

		$rows = $this->db->createCommand()->select('id, pid as parent_id, other_func, name as file')->from('layoutv3pagetype')->where('is_enable=1')->order('sort_id')->queryAll();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$other_func = explode(',',$v['other_func']);
				if($v['parent_id'] == 0 and $v['file'] != $router_method and !in_array($router_method,$other_func)){
					unset($rows[$k]);
				}
			}

			foreach($rows as $k => $v){
				unset($rows[$k]['other_func']);
			}
		}
		$result = $this->buildTree($rows);
		if(!isset($result[0])){
			echo '404';
			header("HTTP/1.0 404 Not Found");
			return;
		}
		// file_put_contents('aaa.txt', var_export($result,true));

		$aaas = explode("\n", var_export($result,true));
		$ids = array();
		foreach($aaas as $k => $v){
			if(preg_match('/\'id\'\ =>\ \'(.*)\'\,/',  $v, $matches)){
				$ids[] = $matches[1];
			}
		}
		unset($ids[0]); // 頂層留著，其它在寫入前，會刪掉

		// 把所有區塊載入，並記錄它們有幾個洞
		$ccc = array();
		$view_tmp = array(
			'$layoutit' => 1,
			'$layout_main' => 1,
			'-group' => 1,
		);
		//$path = _BASEPATH.'/../view/v3/layoutit';
		$path = _BASEPATH.'/../view/system';
		//echo $path;
		if(is_dir($path)){
			$ccc = $this->_getFiles($path);
		}
		foreach($ccc as $k => $v){
			$ccc[$k] = str_replace($path.'/','',str_replace('.php','',$v));
		}
		foreach($ccc as $k => $v){
			$tmp = file_get_contents($path.'/'.$v.'.php');
			//$tmp = str_replace('<'.'?'.'php echo $AA?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
			//$tmp = str_replace('<'.'?'.'php echo $BB?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
			//$tmp = str_replace('<'.'?'.'php echo $CC?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
			//$tmp = str_replace('<'.'?'.'php echo $DD?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
			//$tmp = str_replace('<'.'?'.'php echo $EE?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
			//$tmp = str_replace('<'.'?'.'php echo $__?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
			$tmps = explode("\n", $tmp);
			$count = 0;
			foreach($tmps as $kk => $vv){
				if(preg_match('/<\?'.'php\ echo\ \$(AA|BB|CC|DD|EE|\_\_)\?'.'>/', $vv)){
					$count++;
				}
			}
			//$view_tmp['v3/layoutit/'.$v] = $count;
			$view_tmp['system/'.$v] = $count;
		}

		$aaas = explode("\n", str_replace(' ui-sortable','',$_POST['aaa']));

		// debug
		if($debug){
			file_put_contents('aaa.txt',var_export($aaas,true));
			file_put_contents('aaa.txt',var_export($view_tmp,true),FILE_APPEND);
		}

		$status_tmp = array();
		$history = array();
		$inserts = array();

		foreach($aaas as $k => $v){

			$v = str_replace(' style="display:none"','', $v);
			$v = str_replace(' style="display: none;"','', $v);
			$v = str_replace(' style=""','', $v);
			$v = str_replace(' style=','', $v);

			//echo $v."\n";

			if(preg_match('/class=\"preview preview_(.*)_(.*)\" params="(.*|)">(.*)<\/div>/',$v, $matches)){
				// matches[1]是pid，但是因為使用者有托拉，所以這裡不要管它多少
				$item_id = $matches[2];
				$item_params = $matches[3];
				$item_file = $matches[4];

				$tmp = array(
					'id' => $item_id,
					'file' => $item_file,
					'params' => $item_params,
				);

				if(!isset($status_tmp[$item_id])){
					$status_tmp[$item_id] = array();
				}
				$status_tmp[$item_id]['file'] = $item_file;
				$status_tmp[$item_id]['preview'] = 1;

				$_count = count($history);
				if($_count <= 0){ // 如果是第一個找到的，那就是最頂層
					$tmp['pid'] = 0;
					$status_tmp[$item_id]['pid'] = 0;
				} else {
					if(preg_match('/^(.*)_(.*)_(.*)_1$/', end($history), $matches)){ // 如果上一個沒收鍊，那它就是我的頂層
						//echo end($history);
						$tmp['pid'] = $matches[1];
						$status_tmp[$item_id]['pid'] = 0;
					} else {
						//echo $item_id;
						//echo $item_file;
						//echo $_count;
						//var_dump($history);
						for($x=2;$x<=$_count;$x++){
							// if(preg_match('/^(.*)_(.*)_(.*)_1$/', $history[$_count-$x], $matches)){
							// 	$tmp['pid'] = $matches[1];
							// 	$status_tmp[$item_id]['pid'] = 0;
							// 	break;
							// }
							if(preg_match('/^(.*)_(.*)_(.*)_(.*)$/', $history[$_count-$x], $matches)){
								if($status_tmp[$matches[1]]['preview'] == 1){
								 	$tmp['pid'] = $matches[1];
								 	$status_tmp[$item_id]['pid'] = 0;
								 	break;
								}
							}
						}
					}
				}

				$history[] = $item_id.'_preview_x_1';

				$inserts[] = $tmp;
			} elseif(preg_match('/class=\"preview_end preview_(.*)_(.*)\"/',$v, $matches)){
				$status_tmp[$matches[2]]['preview'] = 2;
				$history[] = $matches[2].'_preview_x_2';
			} elseif(preg_match('/class=\"column column_(.*)_(.*)\">/',$v, $matches)){
				if(!isset($status_tmp[$matches[2]])){
					if($debug){
						file_put_contents('aaa.txt','xxx-'.$v."\n",FILE_APPEND);
						file_put_contents('aaa.txt',$matches[2]."\n",FILE_APPEND);
					}

					$gggs = explode('">', $matches[2]);
					$matches[2] = $gggs[0];
				}
				for($x=1;$x<=$view_tmp[$status_tmp[$matches[2]]['file']];$x++){
					if(!isset($status_tmp[$matches[2]]['column'][$x])){
						$status_tmp[$matches[2]]['column'][$x] = 1;
						break;
					}
				}
				$history[] = $matches[2].'_column_'.$x.'_1';
			} elseif(preg_match('/class=\"column_end column_(.*)_(.*)\"/',$v, $matches)){
				for($x=1;$x<=$view_tmp[$status_tmp[$matches[2]]['file']];$x++){
					if(isset($status_tmp[$matches[2]]['column'][$x]) and $status_tmp[$matches[2]]['column'][$x] == 1){
						$status_tmp[$matches[2]]['column'][$x] = 2;
						$history[] = $matches[2].'_column_'.$x.'_2';
						break;
					}
				}
			} else {
				if($debug){
					file_put_contents('aaa.txt',$v."\n",FILE_APPEND);
				}
			}
		}

		if($inserts){
			foreach($inserts as $k => $v){
				$inserts[$k]['pid'] = 0;
				break;
			}
		}

		if($debug){
			file_put_contents('aaa.txt',var_export($status_tmp,true),FILE_APPEND);
			file_put_contents('aaa.txt',var_export($history,true),FILE_APPEND);
			file_put_contents('aaa.txt',var_export($inserts,true),FILE_APPEND);
		}

		$_count = $inserts;
		if($_count > 0){
			// 清空頁面結構，除了頁面最頂層的不用刪掉
			if(1){
				foreach($ids as $k => $v){
					$this->cidb->delete('layoutv3pagetype', array('id' => $v)); 
					// echo $this->cidb->affected_rows();
				}
			}

			$map = array(0=>$row['id']);
			foreach($inserts as $k => $v){
				$v['name'] = $v['file'];
				unset($v['file']);

				$v['pid'] = $map[$v['pid']];
				$v['is_enable'] = 1;
				$v['sort_id'] = $k;
				$old_id = $v['id'];
				unset($v['id']);
				$this->cidb->insert('layoutv3pagetype', $v); 
				$map[$old_id] = $this->cidb->insert_id();
			}

			if($debug){
				file_put_contents('aaa.txt',var_export($map,true),FILE_APPEND);
			}

			if(isset($_POST['exit']) and $_POST['exit'] == '1'){
				$this->cidb->where('name', $router_method);
				$this->cidb->update('layoutv3pagetype', array('debug'=>0)); 
				// echo \$this->cidb->affected_rows();
			}
		}
	} // function layoutit

	//      public function actionLayoutit()
	//      {
	//      	if(!isset($_SESSION['layoutit_router_method']) or $_SESSION['layoutit_router_method'] == ''){
	//      		header('HTTP/1.1 500 Internal Server Error'); 
	//      		return;
	//      	}
	//      	$router_method = $_SESSION['layoutit_router_method'];

	//      	$row = $this->cidb->where('name', $router_method)->get('layoutv3pagetype')->row_array();

	//      	if(!isset($row)){
	//      		header('HTTP/1.1 500 Internal Server Error'); 
	//      		return;
	//      	}

	//      	$rows = $this->db->createCommand()->select('id, pid as parent_id, other_func, name as file')->from('layoutv3pagetype')->where('is_enable=1')->order('sort_id')->queryAll();
	//      	if($rows and count($rows) > 0){
	//      		foreach($rows as $k => $v){
	//      			$other_func = explode(',',$v['other_func']);
	//      			if($v['parent_id'] == 0 and $v['file'] != $router_method and !in_array($router_method,$other_func)){
	//      				unset($rows[$k]);
	//      			}
	//      		}

	//      		foreach($rows as $k => $v){
	//      			unset($rows[$k]['other_func']);
	//      		}
	//      	}
	//      	$result = $this->buildTree($rows);
	//      	if(!isset($result[0])){
	//      		echo '404';
	//      		header("HTTP/1.0 404 Not Found");
	//      		return;
	//      	}
	//      	// file_put_contents('aaa.txt', var_export($result,true));

	//      	$aaas = explode("\n", var_export($result,true));
	//      	$ids = array();
	//      	foreach($aaas as $k => $v){
	//      		if(preg_match('/\'id\'\ =>\ \'(.*)\'\,/',  $v, $matches)){
	//      			$ids[] = $matches[1];
	//      		}
	//      	}
	//      	unset($ids[0]); // 頂層留著，其它在寫入前，會刪掉

	//      	// 如果可以了，可能還要寫一個陣列轉成可以寫入資料庫的

	//      	//var_dump($_POST['aaa']);
	//      	//file_put_contents('aaa.txt',$_POST['aaa']);

	//      	/* Bootstrip Layout範例 {xx}代表的是，工具列裡面的情況下，才要加上去，demo框裡面的地方不用
	//      	<div class="lyrow {ui-draggable}">

	//      	  <a href="#close" class="remove label label-danger">
	//      		<i class="glyphicon-remove glyphicon"></i>
	//      		删除
	//      	  </a>

	//      	  <span class="drag label label-default">
	//      		<i class="glyphicon glyphicon-move"></i>
	//      		拖动
	//      	  </span>

	//      	  <div class="preview">
	//      		<input value="12" class="form-control" type="text">
	//      	  </div>

	//      	  <div class="view">
	//      		<div class="row clearfix">
	//      		  <div class="col-md-12 column"></div>
	//      		</div>
	//      		<!-- cxlumn -->
	//      		<!-- preview 12 -->
	//      	  </div>

	//      	</div>
	//      	 */

	//      	/* 手刻Layout範例 {xx}代表的同上
	//      	<div class="lyrow {ui-draggable}">
	//      	  <a href="#close" class="remove label label-danger">
	//      		<i class="glyphicon-remove glyphicon"></i>
	//      		删除
	//      	  </a>

	//      	  <span class="drag label label-default">
	//      		<i class="glyphicon glyphicon-move"></i>
	//      		拖动
	//      	  </span>

	//      	  <div class="preview">XXX</div>
	//      	  <div class="view">
	//      		<div class="column"></div>
	//      		<!-- cxlumn -->
	//      		<!-- preview XXX -->
	//      	  </div>
	//      	</div>
	//      	 */

	//      	/* 區塊範例 {xx}代表意義同上
	//      	 * 區塊一定要放在column裡面，無法直接放在Container裡面
	//      	 * 區塊裡面，不能有column，如果會有，要放在Layout那邊
	//      	<div class="box box-element {ui-draggable}">

	//      	  <a href="#close" class="remove label label-danger">
	//      		<i class="glyphicon glyphicon-remove"></i>
	//      		删除
	//      	  </a>

	//      	  <span class="drag label label-default">
	//      		<i class="glyphicon glyphicon-move"></i>
	//      		拖动
	//      	  </span>

	//      	  <div class="preview">地址</div>
	//      	  <div class="view">
	//      		XXX
	//      	  </div>

	//      	</div>
	//      	 */

	//      	$aaas = explode("\n", $_POST['aaa']);

	//      	// debug
	//      	file_put_contents('aaa.txt',var_export($aaas,true));

	//      	$result = '$page = array('."\n";
	//      	$layers = array();// 第幾層的pid是多少
	//      	$layers2 = array();// 上一筆的parent_id
	//      	$layer = 1;
	//      	$pid = 0;
	//      	//$prev_pid = 0;
	//      	//$current_layer = 0;
	//      	$inserts = array();

	//      	foreach($aaas as $k => $v){
	//      		//<div class="preview">9 3</div>
	//      		// if(preg_match('/class=\"preview\">$/',$v, $matches)){
	//      		// 	if(preg_match('/<input\ value=\"(.*)\"\ class=\"form-control\"/',$aaas[$k+1], $matches)){
	//      		// 		$result .= 'array('."\n";
	//      		// 		$result .= "'file' => '".$matches[1]."',"."\n";
	//      		// 		$result .= "'hole' => array("."\n";

	//      		// 		$tmp = array(
	//      		// 			'pid' => $layers[$layer],
	//      		// 			'file' => $matches[1],
	//      		// 		);

	//      		// 		$layer += 1;
	//      		// 		$tmp['id'] = $id;
	//      		// 		$layers[$layer] = $id;
	//      		// 		$id += 1;


	//      		// 		$inserts[] = $tmp;
	//      		// 	}
	//      		if(preg_match('/class=\"preview preview_(\d+)_(\d+)\">(.*)<\/div>/',$v, $matches)){
	//      			// if(!isset($layers[$layer])){
	//      			// 	$layers[$layer] = $pid;
	//      			// }

	//      			$item_pid = $matches[1];
	//      			$item_id = $matches[2];
	//      			$item_name = $matches[3];

	//      			$result .= 'array('."\n";
	//      			if($item_name == '容器'){
	//      				//$result .= "'file' => '-group',"."\n";
	//      			} else {
	//      				$result .= "'file' => '".$item_name."',"."\n";
	//      			}
	//      			$result .= "'hole' => array("."\n";

	//      			$tmp = array(
	//      				'pid' => $item_pid,
	//      				'id' => $item_id,
	//      				'file' => $item_name,
	//      			);

	//      			if($item_name == '容器'){
	//      				$tmp['file'] = '-group';
	//      			}

	//      			// if($prev_pid == $layers[$layer]){
	//      			// if($item_pid == end($layers)){ // 如果是同層的
	//      			// 	// do nothing
	//      			// } else { // 不是同層，那就是加一
	//      			// 	//$prev_pid = $layers[$layer];
	//      			// 	$layer += 1;
	//      			// }

	//      			// $tmp['id'] = $item_id;
	//      			// $layers[$layer] = $item_id;
	//      			//$id += 1;

	//      			$inserts[$item_id] = $tmp;

	//      		// <!-- preview 段落 -->
	//      		} elseif(preg_match('/<!--\ preview_(\d+)_(\d+)\ -->/', $v, $matches)){
	//      			$result .= "),"."\n";
	//      			//$result .= "),"."\n";
	//      			//$layer -= 1;

	//      			//if($current_layer > 0){
	//      			//} elseif($current_layer == 0){
	//      			//	// do nothing
	//      			//} else {
	//      			//	$current_layer = $matches[1];
	//      			//}

	//      		// } elseif(preg_match('/column/',$v, $matches)){
	//      		// 	$result .= 'array('."\n";
	//      		// 	$result .= "'hole' => array("."\n";

	//      		// 	$tmp = array(
	//      		// 		'pid' => $layers[$layer],
	//      		// 		'file' => '-group',
	//      		// 	);

	//      		// 	$layer += 1;

	//      		// 	$tmp['id'] = $id;
	//      		// 	$layers[$layer] = $id;
	//      		// 	$id += 1;

	//      		// 	$inserts[] = $tmp;

	//      		} elseif(preg_match('/<\!--\ cxlumn_(\d+)_(\d+)\ -->/', $v, $matches)){
	//      			$result .= "),"."\n";
	//      			//$result .= "), // -group"."\n";
	//      			//$layer -= 1;
	//      		}
	//      	}

	//      	if($inserts){
	//      		foreach($inserts as $k => $v){
	//      			$inserts[$k]['pid'] = 0;
	//      			break;
	//      		}
	//      	}

	//      	$result .= ');'."\n";
	//      	// eval($result);
	//      	file_put_contents('aaa.txt',$result,FILE_APPEND);
	//      	file_put_contents('aaa.txt',var_export($inserts,true),FILE_APPEND);
	//      	file_put_contents('aaa.txt',var_export($layers,true),FILE_APPEND);

	//      	$_count = $inserts;
	//      	if($_count > 0){
	//      		// 清空頁面結構，除了頁面最頂層的不用刪掉
	//      		if(1){
	//      			foreach($ids as $k => $v){
	//      				$this->cidb->delete('layoutv3pagetype', array('id' => $v)); 
	//      				// echo $this->cidb->affected_rows();
	//      			}
	//      		}

	//      		$map = array(0=>$row['id']);
	//      		foreach($inserts as $k => $v){
	//      			$v['name'] = $v['file'];
	//      			unset($v['file']);

	//      			$v['pid'] = $map[$v['pid']];
	//      			$v['is_enable'] = 1;
	//      			$v['sort_id'] = $v['id'];
	//      			$old_id = $v['id'];
	//      			unset($v['id']);
	//      			$this->cidb->insert('layoutv3pagetype', $v); 
	//      			$map[$old_id] = $this->cidb->insert_id();
	//      		}
	//      		file_put_contents('aaa.txt',var_export($map,true),FILE_APPEND);
	//      	}
	//      }


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
