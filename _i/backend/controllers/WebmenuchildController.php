<?php

/*
 * 無限層
 */

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'disable_index_normal_search' => true,
		'table' => 'XXX',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('pid, name', 'required'),
				array('pid, sort_id', 'length', 'max'=>11),
				// array('name, resource_key', 'length', 'max'=>50),
				// array('name', 'length', 'max'=>50),
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
			'name' => array(
				'label' => '索引 / 名稱',
				'width' => '20%',
				'sort' => true,
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
							'label' => '***這個名子會變換***',
							// 'mlabel' => array(
							// 	null, // category
							// 	'Title', // label
							// 	array(), // sprintf
							// 	'選單名稱', // default
							// ),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								//'size' => '30',
							),
						),
						'gg01' => array(
							'label' => '程式碼取用<br /><a href="javascript:;" id="gg01_open">(打開 / 關閉)</a><br />',
							'type' => 'label',
							'other' => array(
								'html_start' => '<span id="gg01_area">',
								'html_end' => '</span>',
							),
						),
						//'pic1' => array(
						//	'label' => '代表圖：',
						//	'type' => 'fileuploader',
						//	'other' => array(
						//		'number' => '1',
						//		'type' => 'photo',
						//		'top_button' => '1',
						//		'width' => '1000',
						//		'height' => '652',
						//		'comment_size' => '1000x650',
						//		'no_ext' => '',
						//		'no_need_delete_button' => '',
						//	),
						//),
						'pid' => array(
							'type' => 'hidden',
							'attr' => array(
								'id' => 'pid',
								'name' => 'pid',
								//'size' => '30',
							),
						),
						'func_name' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'merge' => 1,
							'attr' => array(
								'id' => 'func_name',
								'name' => 'func_name',
								//'size' => '30',
							),
							'other' => array(
								'html_start' => '大標',
								'html_end' => '，',
							),
						),
						'func_en_name' => array(
							'label' => '&nbsp;',
							'type' => 'input',
							'merge' => 3,
							'attr' => array(
								'id' => 'func_en_name',
								'name' => 'func_en_name',
								//'size' => '30',
							),
							'other' => array(
								'html_start' => '小標',
								//'html_end' => '，',
							),
						),
						'url' => array(
							'label' => 'url 連結',
							// 'mlabel' => array(
							// 	null, // category
							// 	'Url', // label
							// 	array(), // sprintf
							// 	'連結', // default
							// ),
							'type' => 'input',
							'merge' => '1',
							'attr' => array(
								'id' => 'url',
								'name' => 'url',
								'size' => '50',
							),
						),
						'target' => array(
							'label' => '，開啟網址對象ID',
							'type' => 'input',
							'merge' => '3',
							'attr' => array(
								'id' => 'target',
								'name' => 'target',
								'size' => '12',
							),
							'other' => array(
								'html_end' => '例：_blank ',
							),
						),
						'pic1' => array(
							'label' => 'pic1：',
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
						'pic2' => array(
							'label' => 'pic2：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '2',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'pic3' => array(
							'label' => 'pic3：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '3',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '360x220',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'file1' => array(
							'label' => 'file1：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '4',
								'type' => 'document',
								'top_button' => '1',
								'width' => '360',
								'height' => '220',
								'comment_size' => '',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						'other1' => array(
							'label' => 'other1',
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
						'other2' => array(
							'label' => 'other2',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other2',
								'name' => 'other2',
								'size' => '40',
							),
						),
						'other3' => array(
							'label' => 'other3',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other3',
								'name' => 'other3',
								'size' => '40',
							),
						),
						'other4' => array(
							'label' => 'other4',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'other4',
								'name' => 'other4',
								'size' => '40',
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
						'detail' => array(
							'label' => 'detail',
							//'type' => 'textarea',
							'type' => 'ckeditor_js',
							'attr' => array(
								//'class' => 'form-control', // 這…手動加上去好了
								'id' => 'detail',
								'name' => 'detail',
								//'rows' => '4',
								//'cols' => '40',
							),
						),
					),
				),
				//array(
				//	'form' => array('enable' => false),
				//	'type' => '2',
				//	'field' => array(
				//		'detail' => array(
				//			'label' => '描述1',
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
				// 這是SEO欄位的範本，如果你需要，就打開它 1/4
				// *第二版的放在任何位置都可以，只要記得加上一個元素_has_seov2 => true就可以了
				array(
					'form' => array('enable' => false),
					'type' => '1',
					'_has_seov2' => true,
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

		$this->def['updatefield']['smarty_javascript_text'] = <<<XXX
$('#gg01_area').hide();
$('#gg01_open').click(function(){
	$('#gg01_area').toggle();
});
XXX;

		// 無法帶入的變數中的變數，在這裡帶入
		$this->def['condition'][0][0] = 'where';
		$this->def['condition'][0][1] = 'pid=0 and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$this->def['sortable']['condition'] = 'pid=0 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';

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
					// $ggg =  $this->judge_layer($v['id']);
					
					// 無限層修改
					//if($v['pid'] == 0 && PRODUCT_ADD_LATER == true){
					//if($ggg['k'] < PRODUCT_TYPE_LATER_NUM - 1 && PRODUCT_ADD_LATER == true){
						$v['add'] = '<a href="'.$this->createUrl($this->data['router_class'].'/create')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'].$v['id'].'"><img class="imgalign" src="'.$this->assetsUrl.$this->data['template_path'].'/images/icons/add.png'.'" /></a>';
					//}

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

			// 這是SEO的欄位的範本，如果你需要，就打開它 2/4 
			unset($_constant);
			eval('$_constant = '.strtoupper('seo_open').';');
			if(isset($params['value'][0]) and file_exists(Yii::getPathOfAlias('system.backend.controllers.seov2').'.php') and $_constant){
				$row = $this->cidb->where('is_enable',1)->where('id',$params['value'][0])->get('webmenuchild')->row_array();

				if($row and isset($row['pid']) and $row['pid'] != 0 ){
					$seo_func = 'a';
					include Yii::getPathOfAlias('system.backend.controllers.seov2').'.php';
				}
			}
		} // empty POST

		return true;
	}

	//判斷目前ID的層數 lota 2016/5/8
	function judge_layer($pid = 0,$k = 0)
	{
		if ($pid != 0){
			// $rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" and id ='.$pid)->queryRow();
			$rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('ml_key ="'.$this->data['admin_switch_data_ml_key'].'" and id ='.$pid)->queryRow();
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

	//protected function index_last()
	//{
	//	// 分類圖的部份，有兩個地方哦
	//	if($this->data['listcontent']){
	//		foreach($this->data['listcontent'] as $k => $v){
	//			if($v['pic1'] != ''){
	//				// ./assets/upload/producttype/018336b11773d2f10ddea2740a4d768c.jpg
	//				$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
	//			}
	//			$this->data['listcontent'][$k] = $v;
	//		}
	//	}

	//	$this->data['main_content'] = $this->data['router_class'].'/index';
	//}

	protected function getData()
	{
		if(isset($this->data['def']['updatefield']['sections'][0]['field']['pid'])){
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

		$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';;

		$this->index_get_total();

		$this->index_get_data();
		$this->index_last_handle();

		$this->data['class_sort_count'] = G::dbc('update', $this->data['def']);

		// 當pid為零的時候，代表現在在修改大分類，此時pid就是大分類的編號
		// 反之
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
			unset($this->data['def']['updatefield']['sections'][0]['field']['pid']);
		}	

		$this->data['def']['sortable']['condition'] = 'pid='.$pid.' and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';

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

		//2016/5/8 取得該編號的層級數
		// $ggg = $this->judge_layer($this->data['updatecontent']['id']);
		// $this->data['updatecontent']['now_layer'] = $ggg['k'];

		$ggg = $this->judge_layer($this->data['updatecontent']['id']);
		$now_layer = $ggg['k'];
		$now_layer++;

		if($now_layer == 1){
			foreach($this->data['def']['updatefield']['sections'][0]['field'] as $k => $v){
				if(!preg_match('/^(name|gg01|sort_id|is_enable)/', $k)){
					unset($this->data['def']['updatefield']['sections'][0]['field'][$k]);
				}
			}
			$this->data['def']['updatefield']['sections'][0]['field']['name']['label'] = '索引';

			$rule_value_1 = 'name---'.$this->data['updatecontent']['name'].'---child';

			// $topic = '';
			// $datasource = '';
			// $layer_params = '';

			$id = 1697;
			$data_name = 'webmenuchild__'.$id;
			$good_name = '';

			$this->data['updatecontent']['gg01'] = <<<XXX
<pre>
&lt;?php
// http://網站的網址/_i/backend.php?r=datasource/update&amp;param=v$id
// 通用-前台次選單-靜態-XXX - webmenuchild:
// search_and_get_element:$rule_value_1
\$layoutv3_datasource_id = $id;
\$layoutv3_rule_value[1] = '$rule_value_1';
include 'layoutv3/dom5/datasource.php';
// var_dump(\$content);
// \$row = \$content;
\$this-&gt;data['$data_name'] = \$content;$good_name
if(isset(\$this-&gt;data['$data_name']) and count(\$this-&gt;data['$data_name']) > 0){
&nbsp;&nbsp;&nbsp;&nbsp;foreach(\$this-&gt;data['$data_name'] as \$k => \$v){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// 客製欄位使用
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// blha blha 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$this-&gt;data['$data_name'][\$k] = \$v;
&nbsp;&nbsp;&nbsp;&nbsp;}
}
// var_dump(\$this-&gt;data['$data_name']);
// \$data[\$ID] = \$this-&gt;data['$data_name'];
?&gt;
&lt;?php if(0)://V1第二版的無限層資料輸出範例，如果想要看看，?&gt;
&lt;ul l="layer" ls="$data_name"&gt;
	&lt;li l="list" &gt;&lt;a href="#"&gt;{/name/}{/topic/}&lt;/a&gt;
		{/child/}
	&lt;/li&gt;
	&lt;ul l="box"&gt;{split}&lt;/ul&gt;
&lt;/ul&gt;
&lt;?php endif?&gt;
&lt;?php if(isset(\$this-&gt;data['$data_name']) and count(\$this-&gt;data['$data_name']) > 0):?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php foreach(\$this-&gt;data['$data_name'] as \$k => \$v):?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php // echo \$v['id']?&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php endforeach?&gt;
&lt;?php endif?&gt;
</pre>
XXX;
		} else {
			$this->data['def']['updatefield']['sections'][0]['field']['name']['label'] = 'name 名稱';
			unset($this->data['def']['updatefield']['sections'][0]['field']['gg01']);
		}

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

		// 選擇預設的修改樣版，並依照程式變數產生
		//$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'/'.$this->data['updatecontent']['id'];

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

		return $array;
	}

	protected function update_run_last()
	{
		if(isset($this->data['def']['listfield']['sort_id']) and isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
			// 取得數量，用在排序的編號產出
			$this->data['def']['condition'][0][1] = $_POST['pid'];
		}
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

		// 如果id有指定，代表使用者想要建第二層的分類
		$parent_data = array();
		$this->data['updatecontent']['name_parent'] = '';

		if($id != ''){
			$parent_data = $this->db->createCommand()->from($this->data['def']['table'])->where('id='.$id)->queryRow();

			$ggg = $this->judge_layer($id);
			$now_layer = $ggg['k'];
			$now_layer++;

			if($now_layer >= 1){
				// foreach($this->data['def']['updatefield']['sections'][0]['field'] as $k => $v){
				// 	if(!preg_match('/^(name|sort_id|is_enable)/', $k)){
				// 		unset($this->data['def']['updatefield']['sections'][0]['field'][$k]);
				// 	}
				// }
				$this->data['def']['updatefield']['sections'][0]['field']['name']['label'] = 'name 名稱';
			}
		} else {
			foreach($this->data['def']['updatefield']['sections'][0]['field'] as $k => $v){
				if(!preg_match('/^(name|sort_id|is_enable)/', $k)){
					unset($this->data['def']['updatefield']['sections'][0]['field'][$k]);
				}
			}
			$this->data['def']['updatefield']['sections'][0]['field']['name']['label'] = '索引';
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

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		
		// 取得數量，用在排序的編號產出
		if(isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
			$this->data['def']['condition'][0][1] = 'pid='.$array['pid'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		}

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
