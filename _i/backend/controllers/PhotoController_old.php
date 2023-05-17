<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
				array('topic', 'required'),
				array('pic1', 'required'),
				//array('start_date', 'date', 'format'=>'yyyy-M-d'),
			),
		),
		//'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'sort_id', // 預設要排序的欄位 2016/04/29 改為預設為id 如有搜尋分類,則動態改為sort_id 2016/6/15 因點選分類後會無法排序，再度改回sort_id
		'search_keyword_field' => array('topic'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'topic', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'topic', // 要給sys_log記錄名稱欄位值的設定
		'data_multilanguage' => false, // 是否有多國語系的資料
		'condition' => array(
			array(
				'where',
				'',
			),
		),
		'sortable' => array(
			'enable' => 'true',
			'condition' => '', // 有其它條件的時候，例如有商品分類
			'url' => 'backend.php?r=XXX/sort', // ajax post都會有個目標
		),
		// 建立前端要顯示的欄位
		//'listfield_attr' => array(
		//	'smarty_include_top' => 'product/main_content_top.htm',
		//),
		'listfield' => array(
			'xx_01' => array(
				'label' => '',
				'width' => '7%',
				'align' => 'center',
				'ezdelete' => true,
			),
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
			'topic' => array(
				'label' => '名稱',
				//'mlabel' => array(
				//	null, // category
				//	'Title', // label
				//	array(), // sprintf
				//	'標題', // default
				//),
				'width' => '50%',
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
			'sort_id' => array(
				'label' => 'ml:Sort id',
				'width' => '10%',
				'align' => 'center',
				'sort' => true,
			),
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
						'class_id' => array(
							'label' => '分類',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '',
							),
						),
						// 2017-08-14 多檔上傳插件
						 'kc01' => array(
						 	'label' => '多檔上傳',
						 	'type' => 'kcfinder_school',
						 	'attr' => array(
						 		'width' => '700',
						 		'height' => '400',
						 	),
						 	'other' => array(
						 		'uploadurl_id' => 'assetsdir',
						 		'type' => 'member',
						 		'width' => '200',
						 		'school_id' => '',
						 	),
						 ),
						 'kcgg' => array(
						 	'label' => '',
						 	'type' => 'kcfinder_resize',
						 	'other' => array(
						 		'big' => '800',
						 		'small' => '400',
						 	),
						 ),
					),
				),
			),
		),
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
							'label' => '名稱',
							//'mlabel' => array(
							//	null, // category
							//	'Title', // label
							//	array(), // sprintf
							//	'標題', // default
							//),
							'type' => 'input',
							'attr' => array(
								'id' => 'topic',
								'name' => 'topic',
								'size' => '40',
							),
						),
						'class_id' => array(
							'label' => '分類',
							//'type' => 'select3',
							'type' => 'select5',
							//'merge' => '1', // 頭中尾的頭(1)
							'attr' => array(
								'id' => 'class_id',
								'name' => 'class_id',
							),
							'other' => array(
								//'values' => array('center'=>'置中','left'=>'靠左','right'=>'靠右'),
								//'default' => 'center',
								'values' => array(
									'0' => '請選擇',
								),
								'default' => '',
							),
						),
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
		if(isset($this->def['sortable'])){
			$this->def['sortable']['url'] = 'backend.php?r='.$this->data['router_class'].'/sort';
		}

		//2016/1/29 lota 如果是反向排序，則將箭頭對調
		if(isset($this->def['default_sort_direction']) && $this->def['default_sort_direction']=='desc'){
				$this->def['listfield_attr']['smarty_include_top_text'] = '
$aaa_xxx = <<<XXX
<script type="text/javascript">
$(document).ready(function() {
	$(".sortImg").each(function(){
		if($(this).attr(\'src\')==\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_down.gif\')
			$(this).attr(\'src\',\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_up.gif\');
		else if($(this).attr(\'src\')==\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_up.gif\')
			$(this).attr(\'src\',\'BACKEND_ASSETSURL_DOMAIN/_i/framework/backend/assetsg/template/admin_yiiv_5/images/arrow_down.gif\');
	});
});
</script>
XXX;
echo str_replace(\'BACKEND_ASSETSURL_DOMAIN\',BACKEND_ASSETSURL_DOMAIN,$aaa_xxx);
';
		}

		// 分類
		$producttype_table = $this->data['router_class'];
		//$producttype_table = str_replace('homesort', '', $producttype_table); // 為了支援產品的首頁排序
		$producttype_table .= 'type';

		//活動花絮分類層次數量 0 分類是相簿 1 頂層是分類，第二層是相簿 2 只有相片
		unset($_constant);
		eval('$_constant = '.strtoupper($this->data['router_class'].'_type_later').';'); // 相簿分類
		if($_constant == 1){ // 頂層是分類，第二層是相簿
			$rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					//大分類不可選
					$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
					$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
					$rows2 = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();

					//大分類可選
					//$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
					//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';

					//無限層
					//$data_1 = $this->layout_show($v['id'],1,'　',$producttype_table);//'　└'	
					//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
					//$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;

					// 兩層
					$rows2 = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid='.$v['id'].' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
					if($rows2 and count($rows2) > 0){
						foreach($rows2 as $kk => $vv){
							$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
							$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$vv['id']] = $vv['name'];
						}
					}
				}
			}
		} elseif($_constant == 0){ // 後台分類變相簿，記得要去改名稱，然後後台的分類欄位，記得改成相簿
			$rows = $this->db->createCommand()->from($producttype_table)->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['name'];
					$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = $v['name'];
				}
			}
		} else { // 只有相片，記得要把index_first給註解掉
			unset($this->def['searchfield']);
			unset($this->def['updatefield']['sections'][0]['field']['class_id']);
		}

		// 2017-04-28 乖哥說，不同的比例，圖片的最小預設值是不一樣的
		if(file_exists('backend/include/image_size_comment.php')){
			include 'backend/include/image_size_comment.php';
		}

		// 如果有帶搜尋條件存在session裡面的話
		//$ss = strtolower($this->data['router_class']);
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];

		$this->data['updatecontent'] = array();

		// select3的欄位需要這樣子的設定
		$this->data['updatecontent']['class_id'] = -1;

		//$condition = 'is_checkout = 0 ';
		//$condition = 'is_enable = 1 ';
		$condition = ' type=\''.$this->data['router_class'].'\' and ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' type="'.$this->data['router_class'].'" and ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';
		if(isset($session) and count($session) > 0){
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
					$conditions[] = $k.'='.$v;
					$conditions_sortable[] = $k.'='.$v;
				} else {
					$conditions[] = $k.' LIKE \'%'.$v.'%\'';
					$conditions_sortable[] = $k.' LIKE "%'.$v.'%"';
				}
				//var_dump($conditions);
				//die;
			}
			if(count($conditions) > 0){
				if($condition != ''){
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
			if(count($conditions_sortable) > 0){
				if($condition_sortable != ''){
					$condition_sortable .= ' AND ';
				}
				// 疑似Bug 2017-03-24 己經修好了
				$condition_sortable .= implode(' AND ', $conditions_sortable);
			}
			if($condition_sortable != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
			//var_dump($this->def['condition']);
			//die;
		} else {
			if(trim($condition) != ''){
				$this->def['condition'][] = array(
					'where',
					$condition,
				);
			}
			if(trim($condition_sortable) != ''){
				$this->def['sortable']['condition'] = $condition_sortable;
			}
		}

		// 多檔上傳插件 2017-08-14
		$this->def['searchfield']['sections'][0]['field']['kc01']['other']['school_id'] = $this->data['router_class'].'__index';

		return true;
	}

	protected function index_first($param='')
	{
		//活動花絮分類層次數量 0 分類是相簿 1 頂層是分類，第二層是相簿 2 只有相片
		unset($_constant);
		eval('$_constant = '.strtoupper($this->data['router_class'].'_type_later').';'); // 相簿分類
		if($_constant == 2){ // 只有相片
			parent::index_first($param);
		} else {
			// 取得商品分類的編號
			$class_id = 0;
			//if(isset($this->data['params']['value'][0])){
			//	$class_id = $this->data['params']['value'][0];
			//}
			if(isset($_SESSION[$this->data['router_class'].'_search']['class_id']) and $_SESSION[$this->data['router_class'].'_search']['class_id'] > 0){
				$class_id = $_SESSION[$this->data['router_class'].'_search']['class_id'];
			}
			$this->data['class_id'] = $class_id;

			//2016/5/16 讓尚未選擇分類搜尋也可以調整順序 (以後可能會有問題，到時再解決 2016/6/15 重新讓它作用
			if($class_id <= 0){
				unset($this->data['def']['listfield']['sort_id']);
			}
			

			// 商品分類編號要有指定，還有其它必要的條件，才能夠即時自動切換
			if($class_id > 0){
				$this->data['def']['sortable']['enable'] = true;

				// 疑似Bug 2017-03-24
				//$this->data['def']['sortable']['condition'] = 'class_id = '.$this->data['class_id'].' ';
				//$this->data['def']['condition']['where']['class_id'] = $class_id;
			} else {
				$this->data['def']['sortable']['enable'] = false;
			}

			// 如果沒有選擇商品分類，而且又沒有指定排序的方式，這時預設排序欄位會改成商品名稱 2016/6/15 預設值改為id
			if($class_id <= 0 and $this->data['sort_field_nobase64'] == 'sort_id'){
				$sort_field = 'id';//$sort_field = 'topic';
				$this->data['params']['direction'] = 'desc';//2016/6/23 初始化為反序，方便客戶馬上看到新增的資料
				//$this->load->library('base64url');
				//$this->data['sort_field'] = $this->base64url->encode($sort_field);
				$this->data['sort_field'] = base64url::encode($sort_field);
				$this->data['sort_field_nobase64'] = $sort_field;
			}
		}
	}

	protected function index_last($param='')
	{
		//var_dump($this->data['listcontent']);
		if($this->data['listcontent']){
			foreach($this->data['listcontent'] as $k => $v){
				if($v['pic1'] != ''){
					$v['pic1'] = $this->data['image_upload_path'].'/'.$this->data['router_class'].'/'.$v['pic1'];
				}

				$this->data['listcontent'][$k] = $v;
			}
		}
		// 多檔上傳插件 2017-08-14
		$this->data['def']['searchfield']['sections'][1]['field']['kc01']['other']['school_id'] = $this->data['router_class'].'__index';
	}

	// 多檔上傳插件 2017-08-14
	public function actionSearch()
	{
		if(!empty($_POST)){

			$ss = $this->data['router_class'].'_search';
			$session = Yii::app()->session[$ss];
			if($session === null){
				$session = array();
			}
			// 處理一下checkbox的欄位
			if($session){
				foreach($session as $k => $v){
					if(preg_match('/^checkbox_/', $k)){
						unset($session[$k]);
					}
				}
			}
			foreach($_POST as $k => $v){
				$session[$k] = $v;
			}
			Yii::app()->session[$ss] = $session;

			// 2017-08-14 李哥說這個是一個很好的解決方案，但目前暫時先關閉
			if(isset($session['class_id']) and $session['class_id'] > 0){
				// 重覆的檔名規則 $filename = md5(uniqid()).rand(10, 99);

				$rows = $this->db->createCommand()->select('id')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:class_id',array(':ml_key'=>$this->data['admin_switch_data_ml_key'],':type'=>$this->data['router_class'],':class_id'=>$session['class_id']))->queryAll();
				$count = count($rows) + 1;

				if(!is_dir(_BASEPATH.'/assets/members/'.$this->data['router_class'].'__index/member')){
					mkdir(_BASEPATH.'/assets/members/'.$this->data['router_class'].'__index/member',0755,true);
				}

				$tmps = $this->_getFiles(_BASEPATH.'/assets/members/'.$this->data['router_class'].'__index/member');
				foreach($tmps as $k => $v){
					if(!preg_match('/(png|jpg|jpeg|gif)$/', strtolower($v))){
						continue;
					}
					$copy_source = str_replace(_BASEPATH.'/', '', $v);
					$copy_dest_dir = $this->data['image_upload_path'].'/'.$this->data['router_class'];

					// 取得副檔名
					$tmps = explode('/', $copy_source);
					$topic = $tmps[count($tmps)-1];
					$tmps2 = explode('.', $tmps[count($tmps)-1]);
					$ext = $tmps2[count($tmps2)-1];

					$topic = str_replace('.'.$ext,'',$topic);

					$filename = md5(uniqid()).rand(10, 99);
					$fullfilename = $filename.'.'.$ext;
					$copy_dest = $copy_dest_dir.'/'.$fullfilename;
					copy($v, $copy_dest);
					unlink($v);

					$save = array(
						'ml_key' => $this->data['ml_key'],
						'type' => $this->data['router_class'],
						'pic1' => $fullfilename,
						'topic' => $topic,
						'class_id' => $session['class_id'],
						'sort_id' => $count,
						'is_enable' => 1,
					);
					$this->cidb->insert('html', $save); 

					$count += 1;
				}
			}

			$this->redirect($this->createUrl($this->data['router_class'].'/index'));
		}
	}

	protected function update_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];

		return $array;
	}

	protected function create_run_other_element($array)
	{
		$array['ml_key'] = $this->data['admin_switch_data_ml_key'];
		$array['type'] = $this->data['router_class'];

		return $array;
	}

	//解無限層分類
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryAll();
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
eval('class '.$filename.' extends NonameController {}');
