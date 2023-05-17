<?php

// 懶得改Controller的名稱之一
$tmps = explode('/',str_replace('\\','/',__FILE__)); // lota 2017-11-27
$filename = str_replace('.php','',$tmps[count($tmps)-1]);

class NonameController extends Controller {

	protected $def = array(
		'enable_index_advanced_search' => true,
		'disable_index_normal_search' => true,
		'disable_create' => true,
		'disable_edit' => true,
		'disable_delete' => true,
		'table' => 'html',
		'orm' => 'Empty_orm',
		'empty_orm_data' => array(
			'table' => 'html',
			'created_field' => 'create_time', 
			'updated_field' => 'update_time',
			'primary' => 'id',
			'rules' => array(
			),
		),
		//'enable_delete' => true, // 多選刪除
		'default_sort_field' => 'XXX', // 預設要排序的欄位
		'default_sort_direction' => 'desc',
		'search_keyword_field' => array('XXX'), // 搜尋字串要搜尋的欄位
		'search_keyword_assign_field' => 'XXX', // 搜尋字串後，如果按了新增，要帶入到哪個新增欄位裡面
		'sys_log_name' => 'XXX', // 要給sys_log記錄名稱欄位值的設定
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
		//'func_field' => array(
		//	'id' => 'id',
		//	'sort_id' => 'sort_id',
		//),
		// 建立前端要顯示的欄位
		// 'listfield_attr' => array(
		// 	'smarty_include_top' => '', // product/main_content_top.htm
		// 	'smarty_include_top_text' => '', // 請用eval能夠接受的內容，內容結尾記得echo
		// ),
		'listfield' => array(
			//'topic' => array(
			//	'label' => '名稱',
			//	'width' => '45%',
			//	'sort' => false,
			//),
			'name' => array(
				'label' => '名稱',
				'width' => '45%',
				'width' => '45%',
				'sort' => false,
			),
			'sort_id' => array(
				//'label' => 'ml:Sort id',
				'label' => '排序',
				'translate_source' => 'tw',
				'width' => '10%',
				'align' => 'center',
				'sort' => false,
			),
		), // listfield
		'searchfield' => array(
			// jquery-validate, jquery.datepicker
			'head' => array(
				'jquery-validate',
			),
			'smarty_javascript' => '', // product/update_javascript.htm
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
							'translate_source' => 'tw',
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
									'-1' => '請選擇',
								),
								'default' => '',
							),
						),
					),
				),
			),
		),
		'updatefield' => array(
		),
	);

	protected function beforeAction($action)
	{
		parent::beforeAction($action);

		$this->data['multisort_field'] = 'class_ids'; // ex: class_ids
		$this->data['multisort_map_table'] = 'shopmultisort'; // ex: shopmultisort
		$this->data['multisort_data_table'] = 'shop'; // ex: shop
		$this->data['multisort_data_tabletype'] = 'shoptype'; // ex: shoptype

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

		$this->def['default_sort_field'] = 'sort_id';
		if(isset($this->def['default_sort_direction'])){
			unset($this->def['default_sort_direction']);
		}

		$this->def['table'] = $this->data['multisort_data_table'];
		$this->def['empty_orm_data']['table'] = $this->data['multisort_data_table'];
		$this->def['empty_orm_data']['rules'][] = array('name','required');

		$this->def['search_keyword_field'] = array('name');
		$this->def['search_keyword_assign_field'] = 'name';
		$this->def['sys_log_name'] = 'name';

		unset($this->def['listfield']['topic']);
		unset($this->def['updatefield']['sections'][0]['field']['topic']); // update, copy

		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$this->data['multisort_data_table'].'_'.$this->data['admin_switch_data_ml_key'].'.php', ':ml_key'=>$this->data['admin_switch_data_ml_key']))->queryRow();
		
		// 分類
		//$producttype_table = $this->data['router_class'];
		//$producttype_table = str_replace('multisort', '', $producttype_table);
		//$producttype_table .= 'type';

		//if(isset($rowg['other22']) and $rowg['other22'] != ''){ // 別人的
		//	$producttype_table = $rowg['other22'];
		//}

		$rows = $this->db->createCommand()->from($this->data['multisort_data_tabletype'])->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id asc')->queryAll();
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				if(isset($rowg['other18']) and $rowg['other18'] == 1){
					// 大分類可選
					$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
					//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'][$v['id']] = '[ '.$v['name'].' ]';
				} elseif(isset($rowg['other18']) and $rowg['other18'] == 2){
					// 大分類不可選
					$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
					//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values']['xx'.$k] = $v['name'];
				}

				// 剩餘子層的處理程序
				$data_1 = $this->layout_show($v['id'],1,'　',$this->data['multisort_data_tabletype']);//'　└'	
				//$this->def['updatefield']['sections'][0]['field']['class_id']['other']['values'] += $data_1;
				$this->def['searchfield']['sections'][0]['field']['class_id']['other']['values'] += $data_1 ;
			}
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

		$condition = ' ml_key=\''.$this->data['admin_switch_data_ml_key'].'\' ';
		$condition_sortable = ' ml_key="'.$this->data['admin_switch_data_ml_key'].'" ';

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
					// [多分類排序]
					$conditions[] = $this->data['multisort_field'].' LIKE \'%,'.$v.',%\''; // 因為condition的部份要特別處理
					$conditions_sortable[] = $this->data['multisort_field'].' LIKE "%,'.$v.',%"';
				}
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
			//var_dump($this->def['condition']);
			//die;
		} else {
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

		return true;
	}

	protected function index_first($param='')
	{
		// 2020-09-09
		// 是否有點選欄位排序的情況，先準備好，供下面去做判斷
		$has_default_orderby_condition = true;
		if($this->data['sort_field_nobase64'] != $this->def['default_sort_field']){
			$has_default_orderby_condition = false;
		}

		// 取得商品分類的編號
		$class_id = 0;
		if(isset($_SESSION[$this->data['router_class'].'_search']['class_id']) and $_SESSION[$this->data['router_class'].'_search']['class_id'] > 0){
			$class_id = $_SESSION[$this->data['router_class'].'_search']['class_id'];
		}
		$this->data['class_id'] = $class_id;

		// 2020-09-09
		// 有分類的情況，而且還有其它的條件，把只有單獨選擇分類編號的情況，給抓出來
		$only_select_class_id = false;
		if(isset($_SESSION[$this->data['router_class'].'_search']) and !empty($_SESSION[$this->data['router_class'].'_search'])){
			foreach($_SESSION[$this->data['router_class'].'_search'] as $k => $v){
				if($k == 'class_id'){
					if($v == -1){
						// 主角不能沒選
						$only_select_class_id = false;
						break;
					} else {
						$only_select_class_id = true;
					}
				} elseif($v == -1){
					// do nothing
				} elseif($v != ''){
					// 其它欄位，不能有輸入條件，當然的會略過checkbox和radio的欄位值
					$only_select_class_id = false;
					break;
				}
			}
		}

		// 2020-09-09
		// 很單純，很特定的情況下，才會啟用托拉排序
		if($only_select_class_id === true and $has_default_orderby_condition === true){
			$this->data['def']['sortable']['enable'] = true;
		} else {
			unset($this->data['def']['listfield'][$this->def['default_sort_field']]);
			$this->data['def']['sortable']['enable'] = false;
		}

		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
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
			// do nothing
		} else {
			$this->data['def']['sortable']['enable'] = false;
			$sort_field = 'name';
			//$this->load->library('base64url');
			//$this->data['sort_field'] = $this->base64url->encode($sort_field);
			$this->data['sort_field'] = base64url::encode($sort_field);
			$this->data['sort_field_nobase64'] = $sort_field;
			unset($this->data['def']['listfield']['sort_id']);
		}
			
	}

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

			// [多分類排序]
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
				$rows = $this->db->createCommand()->from($this->data['multisort_map_table'])->where('class_id='.$class_id)->order('sort_id')->queryAll();
				if($rows){
					foreach($rows as $k => $v){
						//$this->cidb->query('update '.$this->def['table'].' set '.$this->def['func_field']['sort_id'].'='.$v[$this->def['func_field']['sort_id']].' where '.$this->def['func_field']['id'].'='.$v['product_id'].' and class_ids like "%,'.$class_id.',%"');
						$this->cidb->query('update '.$this->data['multisort_data_table'].' set '.$this->def['func_field']['sort_id'].'='.$v[$this->def['func_field']['sort_id']].' where '.$this->def['func_field']['id'].'='.$v['product_id'].' and '.$this->data['multisort_field'].' like "%,'.$class_id.',%"');
					}
				}
			}

			$this->redirect($this->createUrl($this->data['router_class'].'/index'));
		}
	}

	// [多分類排序]
	// 把一般排序後的結果，轉移到另一個資料表寫入
	protected function sort_last()
	{
		$ss = $this->data['router_class'].'_search';
		$session = Yii::app()->session[$ss];
		$class_id = $session['class_id'];

		// 搜尋產品的多分類欄位，將它們的排序編號，寫入另一個資料表
		// 記得寫入之前要先把另一個資料表的該分類的資料刪掉
		$this->cidb->where('class_id', $class_id)->delete($this->data['multisort_map_table']); 

		$rows = $this->db->createCommand()->from($this->data['multisort_data_table'])->where('ml_key=:ml_key and '.$this->data['multisort_field'].' like "%,'.$class_id.',%"',array(':ml_key'=>$this->data['ml_key']))->queryAll();
		if($rows){
			foreach($rows as $k => $v){
				$data = array(
					'class_id' => $class_id,
					'product_id' => $v['id'],
					$this->def['func_field']['sort_id'] => $v[$this->def['func_field']['sort_id']],
				);
				$this->cidb->insert($this->data['multisort_map_table'], $data); 
			}
		}
	}

	// 刪除後要做的事情
	protected function delete_last()
	{
		$this->cidb->where('product_id', $this->data['id'])->delete($this->data['multisort_map_table']); 
	}

	// 解無限層分類(不含頂層)
	protected function layout_show($id = 0,$k = 0,$tt = '→',$table='producttype',$data = array())
	{		
		for($i=0;$i<$k;$i++)
			$tt = '　'.$tt;
		$rows = $this->db->createCommand()->from($table)->where('is_enable=1 and pid='.$id.' and ml_key=:ml_key',array(':ml_key'=>$this->data['admin_switch_data_ml_key']))->order('sort_id')->queryAll();
		if($rows and !empty($rows)){
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
