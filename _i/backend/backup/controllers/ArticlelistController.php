<?php

/* 請寫入這個到_i/backend/models/XXX_orm.php
 *
class XXX_orm extends Empty_orm
{
	public $_orm_data = array(
		'table' => 'articlelist',
		'created_field' => 'create_time', 
		'updated_field' => 'update_time',
		'primary' => 'id',
		'rules' => array(
			array('pid, name', 'required'),
			array('pid, sort_id', 'length', 'max'=>11),
			//array('name, resource_key', 'length', 'max'=>50),
			array('name', 'length', 'max'=>50),
		),
	);
}
 */

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		//'title' => 'ml:Admin menu',
		//'type' => 'XXX',//lota 帶入資料庫type的變數 修改它就可改變讀取寫入資料的type
		'table' => 'XXX',//lota 文章列表儲存表格，不要動它
		'orm' => 'XXX_orm',//lota 文章列表儲存ORM，不要動它
		'empty_orm_data' => array(
			'table' => 'XXX',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('pid, name', 'required'),
				array('pid, sort_id', 'length', 'max'=>11),
				//array('name, resource_key', 'length', 'max'=>50),
				array('name', 'length', 'max'=>50),
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
				'pid=0 ',
			),
		),
		'sortable' => array(
			'enable' => 'true',
			//'condition' => 'pid = 0', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		'listfield' => array(
			'name' => array(
				//'label' => '選單名稱',
				'mlabel' => array(
					null, // category
					'Title', // label
					array(), // sprintf
					'選單名稱', // default
				),
				'width' => '20%',
				'sort' => true,
			),
			/*
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
			*/
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
						//'type' => array(
						//	'type' => 'hidden',
						//	'attr' => array(
						//		'id' => 'articlelist_type',
						//		'name' => 'type',								
						//	),
						//	'value' => array(
						//		'default' => '1',								
						//	),
						//),
						'name' => array(
							//'label' => '選單名稱',
							'mlabel' => array(
								null, // category
								'Title', // label
								array(), // sprintf
								'選單名稱', // default
							),
							'type' => 'input',
							'attr' => array(
								'id' => 'name',
								'name' => 'name',
								//'size' => '30',
							),
						),
						/*
						'pic1' => array(
							'label' => '代表圖：',
							'type' => 'fileuploader',
							'other' => array(
								'number' => '1',
								'type' => 'photo',
								'top_button' => '1',
								'width' => '1000',
								'height' => '652',
								'comment_size' => '1000x650',
								'no_ext' => '',
								'no_need_delete_button' => '',
							),
						),
						*/
						'pid' => array(
							'label' => '上層',
							'type' => 'select3',
							'attr' => array(
								'id' => 'pid',
								'name' => 'pid',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(),
								'default' => '',
							),
						),
						'detail' => array(
							'label' => '內容',
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
			),
		), // updatefield
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		// 懶得改Controller的名稱之二
		// 為了簡化複製後，所要做的動作
		$this->def['table'] = $this->data['router_class'];
		$this->def['orm'] = $this->data['router_class'].'_orm';
		$this->def['empty_orm_data']['table'] = $this->data['router_class'];
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		$table_type = $this->data['router_class'];

		//    //隱藏的type值，直接由這裡帶入
		//    $this->def['updatefield']['smarty_javascript_text'] = <<<XXX
		//    $('#articlelist_type').val('$table_type');
		//    XXX;

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

					if($v['pid'] == 0){
						$v['add'] = '<a href="'.$this->createUrl($this->data['router_class'].'/create')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'].$v['id'].'"><img class="imgalign" src="'.$this->assetsUrl.$this->data['template_path'].'/images/icons/add.png'.'" /></a>';
					}

					//Debug
					//$v['name'] = '123';

					$bbb[$v['id']] = $v;

				}

				// 如果有編號，而且現在是在新增的狀態，那就加一項新增中
				if(isset($params['value'][0]) and $this->data['router_method'] == 'create' and $current_row['pid'] == 0){
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

		return true;
	}

	protected function index_last($param='')
	{
		// 分類圖的部份，有兩個地方哦
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					// ./assets/upload/articlelist/018336b11773d2f10ddea2740a4d768c.jpg
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				$this->data['listcontent'][$k] = $v;
			}
		}

		$this->data['main_content'] = $this->data['router_class'].'/index';
	}

	protected function getData($param='')
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

		//$this->data['def']['condition']['where']['pid'] = $this->data['updatecontent']['id'];
		$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['id'];
		//var_dump($this->data['def']['condition']);
		//die;
		$this->index_get_total();

		$this->index_get_data();
		$this->index_last_handle();

		// 分類圖的部份，有兩個地方哦
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					// ./assets/upload/articlelist/018336b11773d2f10ddea2740a4d768c.jpg
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}
				$this->data['listcontent'][$k] = $v;
			}
		}

		// 取得數量，用在排序的編號產出
		//$this->data['def']['condition']['where']['pid'] = $this->data['updatecontent']['pid'];
		//Foreach($this->data['def']['condition'] as $k => $v){
		//	$this->db->{$k}($v);
		//}
		//$query = $this->db->get($this->def['table']);
		//$this->data['class_sort_count'] = $query->num_rows();
		$this->data['def']['condition'][0][1] = 'pid='.$this->data['updatecontent']['pid'].' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
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
		$this->data['def']['sortable']['condition'] = 'pid='.$pid.' and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';

		$this->data['sort_url'] .= '-'.$this->data['parameter']['value'].$this->data['updatecontent']['id'];

		// 選擇預設的修改樣版，並依照程式變數產生
		$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'].'/'.$this->data['updatecontent']['id'];
	}

	protected function update_run_last($param='')
	{
		if(isset($this->data['def']['listfield']['sort_id']) and isset($this->data['def']['condition']) and count($this->data['def']['condition']) > 0){
			// 取得數量，用在排序的編號產出
			$this->data['def']['condition'][0][1] = $_POST['pid'];
		}
	}

	protected function create_show_first($param='')
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
		$this->data['main_content'] = $this->data['router_class'].'/update';
		$this->data['def']['updatefield']['method'] = 'create';
		$this->data['def']['updatefield']['form']['attr']['action'] = $this->data['current_url'];
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

		//$u = new XXX_orm();
		eval('$u = new '.ucfirst($this->data['router_class']).'_orm();');
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
		$fieldsorter->setCondition(array(array('where', 'pid='.$pid.' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ')));
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


}

// 懶得改Controller的名稱之三
eval('class '.$filename.' extends NonameController {}');
