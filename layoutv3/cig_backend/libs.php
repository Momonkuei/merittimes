<?php

class Fieldsorter
{
	protected $cidb;
	protected $_msg;

	protected $_table_name;
	protected $_field_id;
	protected $_new_sort_id;

	// 
	protected $_conditions;
	protected $_condition_string = '';
	protected $_sort_field;

	function __construct($db)
	{
		$this->cidb = $db;
	}

	public function setTableName($table_name)
	{
		$this->_table_name = $table_name;
	}

	public function setFieldId($field_id)
	{
		$this->_field_id = $field_id;
	}

	public function setNewSortId($new_sort_id)
	{
		$this->_new_sort_id = $new_sort_id;
	}

	public function setCondition($conditions)
	{
		$this->_conditions = $conditions;
	}

	public function setConditionString($condition_string)
	{
		$this->_condition_string = $condition_string;
	}

	protected function _argument_check_all()
	{
		if($this->_table_name == '') return false;
		if($this->_field_id == '') return false;
		if($this->_new_sort_id == '') return false;
		return true;
	}

	/*
	 * 主函式2
	 * 文字切割轉陣列排序
	 *
	 * @field_id string 其實是裡面的陣列值，為了要取得舊位置
	 * @new_sort_id string 陣列值新的位置
	 * @data_string string id1,id2,id3,id4..
	 */
	public function go2($data_string = '', $field_data = '', $new_sort_id = '')
	{
		if($data_string == ''){
			$this->_msg = 'data string is empty';
			return;
		}

		if($field_data == ''){
			$this->_msg = 'field data is empty';
			return;
		}

		if($new_sort_id == ''){
			$this->_msg = 'new_sort_id is empty';
			return;
		}

		// 檢查一下裡面有沒有資料
		$items = array();
		$items = explode(',', $data_string);
		$count = count($items); // 取得總筆數
		if($count <= 0){
			$this->_msg = 'item row is empty';
			return;
		}

		if($new_sort_id > $count){
			$new_sort_id = $count;
		}

		$old_sort_id = '';
		foreach($items as $k => $v){
			if($v == $field_data){
				// 加1，是因為我的排序是從1開始
				$old_sort_id = $k+1;
				break;
			}
		}

		if($old_sort_id == ''){
			$this->_msg = 'old_sort_id is empty';
			return;
		}

		// 看一下舊的和新的排序編號，在資料裡面有沒有
		if(!isset($items[$old_sort_id-1]) or !isset($items[$old_sort_id-1])){
			$this->_msg = 'sort id is not exist in data';
			return;
		}

		//$old_sort_id = $source_row[$sort_field];
		//$new_sort_id = $dest_row[$sort_field];

		// sort_id_value，是計算兩者間的"間隔"
		// sort_id_value2，可以得知兩者的位置，到底是A在上面，還是B在上面、或是誰在下面
		if($old_sort_id > $new_sort_id){
			$sort_id_value = $old_sort_id - $new_sort_id;
		} else {
			$sort_id_value = $new_sort_id - $old_sort_id;
		}
		$sort_id_value2 = $old_sort_id - $new_sort_id;

		if($sort_id_value == 1){ // 如果是隔壁，就做交換排序編號
		} elseif($sort_id_value2 > 1){ // 如果距離大於1(舊的在下面，新的在上面，中間項目要加上1)
		} elseif($sort_id_value2 < -1){ // 如果距離大於-1(新的在下面)
		}

		// success
		$this->_msg = '';
		return;
	}

	/*
	 * 主函式
	 * 預計要做的動作
	 * - 做一些簡單的預檢查動作
	 * - 檢查排序編號是否有異常，有異常就全部洗掉重新編號
	 * - 取得來源的排序編號
	 * - 將來源和目地的排序編號交換
	 */
	public function go($table_name = '', $field_id = '', $new_sort_id = '', $conditions = array(), $condition_string = '', $sort_field = 'sort_id')
	{
		if($table_name != '') $this->_table_name = $table_name;
		if($field_id != '') $this->_field_id = $field_id;
		if($new_sort_id != '') $this->_new_sort_id = $new_sort_id;

		$this->_sort_field = $sort_field;

		if(count($conditions) > 0){
		   	$this->_conditions = $conditions;
		} else {
			$conditions = $this->_conditions;
		}

		if($condition_string != ''){
		   	$this->_condition_string = $condition_string;
		} else {
			$condition_string = $this->_condition_string;
		}

		if($this->_argument_check_all() === false){
			$this->_msg = 'argument(s) check error';
			return;
		}

		// 檢查一下資料表裡面的排序是否正常
		if($this->_field_check_all($sort_field) === false){
			$this->refresh();
		}

		// 取得總筆數
		$o = $this->cidb;
		if(isset($conditions) and count($conditions) > 0){
			foreach($conditions as $k => $v){
				if(count($v) <= 1) continue;
				$method_tmp = $v[0];
				unset($v[0]);
				$aaa = '$o->'.$method_tmp.'("'.implode(',',$v).'");';
				//echo $aaa;
				eval($aaa);
			}
		}

		if($condition_string != ''){
			$o->where($condition_string);
		}
		$count = $o->get($table_name)->num_rows();

		if($new_sort_id > $count){
			$new_sort_id = $count;
		}




		$source_conditions = array();

		// 找到目前這筆資料的排序編號
		$aa = $this->cidb->select('id, '.$sort_field);
		if(!empty($conditions)){
			$source_conditions = $conditions;
		}

		if(isset($source_conditions) and !empty($source_conditions)){
			foreach($source_conditions as $k => $v){
				if(count($v) <= 1) continue;
				$method_tmp = $v[0];
				unset($v[0]);
				$aaa = '$aa->'.$method_tmp.'("'.implode(',',$v).'");';
				//echo $aaa;
				eval($aaa);
			}
		}

		// [Source] 原本的下完了之後，在下額外的條件
		$source_other = array(
			array(
				'where',
				'id ='.$field_id,
			),
		);
		if(isset($source_other) and !empty($source_other)){
			foreach($source_other as $k => $v){
				if(count($v) <= 1) continue;
				$method_tmp = $v[0];
				unset($v[0]);
				$aaa = '$aa->'.$method_tmp.'("'.implode(',',$v).'");';
				//echo $aaa;
				eval($aaa);
			}
		}

		if($condition_string != ''){
			$aa->where($condition_string);
		}

		$source_row = $aa->get($table_name)->row_array();
		if($source_row === false){
			$this->_msg = 'fetch source row is empty';
			die;
			return;
		}





		// 找到新排序編號上的欄位編號
		$dest_conditions = array();

		// 找到目前這筆資料的排序編號
		$bb = $this->cidb->select('id, '.$sort_field);
		if(!empty($conditions)){
			$dest_conditions = $conditions;
		}

		if(isset($dest_conditions) and !empty($dest_conditions)){
			foreach($dest_conditions as $k => $v){
				if(count($v) <= 1) continue;
				$method_tmp = $v[0];
				unset($v[0]);
				$aaa = '$bb->'.$method_tmp.'("'.implode(',',$v).'");';
				//echo $aaa;
				eval($aaa);
			}
		}

		// [Dest] 原本的下完了之後，在下額外的條件
		$dest_other = array(
			array(
				'where',
				$sort_field.' ='.$new_sort_id,
			),
		);
		if(isset($dest_other) and !empty($dest_other)){
			foreach($dest_other as $k => $v){
				if(count($v) <= 1) continue;
				$method_tmp = $v[0];
				unset($v[0]);
				$aaa = '$bb->'.$method_tmp.'("'.implode(',',$v).'");';
				//echo $aaa;
				eval($aaa);
			}
		}

		if($condition_string != ''){
			$bb->where($condition_string);
		}

		$dest_row = $aa->get($table_name)->row_array();
		if($dest_row === false){
			$this->_msg = 'fetch dest row is empty';
			die;
			return;
		}




		// 交換雙方的排序編號(這是舊的方式)
		//$this->db->where('id', $source_row['id']);
		//$this->db->update($this->_table_name, array('sort_id' => $dest_row['sort_id']));
		//$this->db->where('id', $dest_row['id']);
		//$this->db->update($this->_table_name, array('sort_id' => $source_row['sort_id']));


		// 交換雙方的排序編號
		$old_sort_id = $source_row[$sort_field];
		$new_sort_id = $dest_row[$sort_field];

		//var_dump($source_row);
		//var_dump($dest_row);

		// debug
		//echo $old_sort_id.','.$new_sort_id;

		// sort_id_value，是計算兩者間的"間隔"
		// sort_id_value2，可以得知兩者的位置，到底是A在上面，還是B在上面、或是誰在下面
		if($old_sort_id > $new_sort_id){
			$sort_id_value = $old_sort_id - $new_sort_id;
		} else {
			$sort_id_value = $new_sort_id - $old_sort_id;
		}
		$sort_id_value2 = $old_sort_id - $new_sort_id;

		// debug
		//echo $sort_id_value.','.$sort_id_value2;
		//die;

		if($sort_id_value == 1){ // 如果是隔壁，就做交換排序編號
			/*
			 * 新舊交換
			 */
			// $c = $this->db->createCommand();
			// $c->select('id');
			// $c->from($table_name);

			// 先找到新位置的新資料編號
			$cc = $this->cidb->select('id');
			if(isset($conditions) and !empty($conditions)){
				foreach($conditions as $k => $v){
					if(count($v) <= 1) continue;
					$method_tmp = $v[0];
					unset($v[0]);
					$aaa = '$cc->'.$method_tmp.'("'.implode(',',$v).'");';
					//echo $aaa;
					eval($aaa);
				}
			}
			//if(count($conditions) > 0){
			//	foreach($conditions as $k => $v){
			//		//$bbb->{$k}($v);
			//		//$c->{$k}($v[0], $v[1]);
			//		if(isset($v[2])){
			//			$c->{$v[0]}($v[1], $v[2]);
			//		} else {
			//			$c->{$v[0]}($v[1]);
			//		}
			//	}
			//}

			// $r_condition = G::dbt($conditions, '$c');
			// if($r_condition != ''){
			// 	eval($r_condition);
			// }

			if($condition_string != ''){
				// $c->andWhere($condition_string);
				$cc->where($condition_string);
			}
			$update = array(
				$sort_field => $new_sort_id,
			);
			$row = $cc->where($update)->get($table_name)->row_array();

			// $c->andWhere($sort_field.'='.$new_sort_id);
			// $row = $c->queryRow();

			$new_id = '';
			if(isset($row['id']) and $row['id'] != ''){
				$new_id = $row['id'];
			} else {
				$this->_msg = '2 switch, cant find new_sort_id';
				return;
			}

			// 先把舊的換成新的
			$update = array(
				$sort_field => $new_sort_id,
			);
			$this->cidb->where('id', $field_id)->update($table_name, $update);
			// $this->db->createCommand()->update($table_name, $update, 'id=:id', array(':id'=>$field_id));

			// 把新的換成舊的
			$update = array(
				$sort_field => $old_sort_id,
			);
			$this->cidb->where('id', $new_id)->update($table_name, $update);
			// $this->db->createCommand()->update($table_name, $update, 'id=:id', array(':id'=>$new_id));

		} elseif($sort_id_value2 > 1){ // 如果距離大於1(舊的在下面，新的在上面，中間項目要加上1)

			$dd = $this->cidb->select('id, '.$sort_field);

			if(isset($conditions) and !empty($conditions)){
				foreach($conditions as $k => $v){
					if(count($v) <= 1) continue;
					$method_tmp = $v[0];
					unset($v[0]);
					$aaa = '$dd->'.$method_tmp.'("'.implode(',',$v).'");';
					//echo $aaa;
					eval($aaa);
				}
			}

			if($condition_string != ''){
				$dd->where($condition_string);
			}

			$query = $dd->order_by($sort_field)->get($this->_table_name);
			foreach($query->result_array() as $k => $row){
				// 排序區塊內的資料，才需要重新更新sort_id
				if(($row[$sort_field] >= $new_sort_id) and ($row[$sort_field] <= $old_sort_id)){
					/*
					 * 舊位置，先移到新位置，其它資料會做加1的動作
					 */ 
					if($row[$sort_field] == $old_sort_id){
						$update = array(
							$sort_field => $new_sort_id,
						);
						$this->cidb->where('id', $row['id']);
						$this->cidb->update($this->_table_name, $update);
						continue;
					}
					$update = array(
						$sort_field => $row[$sort_field] + 1,
					);
					$this->cidb->where('id', $row['id']);
					$this->cidb->update($table_name, $update);
				}
			}
		} elseif($sort_id_value2 < -1){ // 如果距離大於-1(新的在下面)
			$ee = $this->cidb->select('id, '.$sort_field);

			if(isset($conditions) and !empty($conditions)){
				foreach($conditions as $k => $v){
					if(count($v) <= 1) continue;
					$method_tmp = $v[0];
					unset($v[0]);
					$aaa = '$ee->'.$method_tmp.'("'.implode(',',$v).'");';
					//echo $aaa;
					eval($aaa);
				}
			}

			if($condition_string != ''){
				$ee->where($condition_string);
			}

			$query = $ee->order_by($sort_field)->get($this->_table_name);

			foreach($query->result_array() as $k => $row){
				// 排序區塊內的資料，才需要重新更新sort_id
				if(($row[$sort_field] >= $old_sort_id) and ($row[$sort_field] <= $new_sort_id)){
					/*
					 * 舊位置，先移到新位置，其它資料會做減1的動作
					 */ 
					if($row[$sort_field] == $old_sort_id){
						$update = array(
							$sort_field => $new_sort_id,
						);
						$this->cidb->where('id', $row['id']);
						$this->cidb->update($this->_table_name, $update);
						continue;
					}
					$update = array(
						$sort_field => $row[$sort_field] - 1,
					);
					$this->cidb->where('id', $row['id']);
					$this->cidb->update($table_name, $update);
				}
			}
		}

	} // function go

	protected function _field_check_all($sort_field)
	{
		$aa = $this->cidb->select('id, '.$sort_field);

		if(isset($this->_conditions) and !empty($this->_conditions)){
			foreach($this->_conditions as $k => $v){
				if(count($v) <= 1) continue;
				$method_tmp = $v[0];
				unset($v[0]);
				$aaa = '$aa->'.$method_tmp.'("'.implode(',',$v).'");';
				// echo $aaa;
				eval($aaa);
			}
		}

		if($this->_condition_string != ''){
			$aa->where($this->_condition_string);
		}

		$query = $aa->order_by($sort_field)->get($this->_table_name);

		$all_data = array();
		foreach($query->result_array() as $row){
			$all_data[] = $row;
		}
		// $all_data = $aaa->queryAll();
		foreach($all_data as $k => $v){
			if($v[$sort_field] != ($k + 1)) return false;
		}
		return true;
	}

	/**
	 * 重新排序全部的欄位
	 */
	public function refresh($table_name = '', $conditions = array(), $condition_string = '', $sort_field = '')
	{
		if($table_name != '') $this->_table_name = $table_name;

		if(!empty($conditions)){
		   	$this->_conditions = $conditions;
		} else {
			$conditions = $this->_conditions;
		}

		if($condition_string != ''){
		   	$this->_condition_string = $condition_string;
		} else {
			$condition_string = $this->_condition_string;
		}

		if($sort_field != ''){
		   	$this->_sort_field = $sort_field;
		} else {
			if($this->_sort_field == ''){
				$sort_field = 'sort_id';
			} else {
				$sort_field = $this->_sort_field;
			}
		}

		if($this->_table_name == ''){
			$this->_msg = 'table name is empty';
			return;
		}

		$aa = $this->cidb->select('id, '.$sort_field);
		if(isset($conditions) and !empty($conditions)){
			foreach($conditions as $k => $v){
				if(count($v) <= 1) continue;
				$method_tmp = $v[0];
				unset($v[0]);
				$aaa = '$aa->'.$method_tmp.'("'.implode(',',$v).'");';
				//echo $aaa;
				eval($aaa);
			}
		}
		if($condition_string != ''){
			$aa->where($condition_string);
		}
		$query = $aa->order_by($sort_field)->get($this->_table_name);

		$all_data = array();
		foreach($query->result_array() as $row){
			$all_data[] = $row;
		}
		$_count = count($all_data);
		if($_count <= 0 or $all_data === false){
			$this->_msg = 'db is no data';
			return;
		}

		foreach($all_data as $k => $v){
			$new_conditions = $conditions;
			$new_conditions['where']['id'] = $v['id'];
			//$this->db->where($new_conditions);
			foreach($new_conditions as $kk => $vv){
				$this->cidb->{$kk}($vv);
			}
			if($condition_string != ''){
				$this->cidb->where($condition_string);
			}
			$this->cidb->update($this->_table_name, array($sort_field => ($k + 1)));
		}
		return;
	}

	public function getStatus()
	{
		if($this->_msg != ''){
			return false;
		}
		return true;
	}

	public function getMessage()
	{
		return $this->_msg;
	}
}

/**
 * 這個是處理controller引數的程序，把1個引數，透過切割(-)，抓出裡面的變數出來
 *
 * 以下是網址引數的格式，請把括號拿掉來看
 * http://adminurl.net/product/index/p(3)-r(1)-l(10)-f(sort_id)-s(fdsafdsafds)-v999-vaaa-vnnn
 *
 * 有些功能變數會寫入session，依照每個controller的英文名稱去存
 * 例如搜尋。
 *
 * 以下的引數模式定義，是可以替換的，主導寫在後端，改了後端，前端也會跟著改
 *
 * 當第一次用get或是post送搜尋的時候，會將分頁改成1，其它時候不會改
 *
 * @p 所要去的分頁，它的編號(CurrentPageNumber)
 * @r 每幾筆分成1頁(TotalRecord)
 * @l 每次顯示的分頁數量，例如1~10或是10~20(ListPage)這個可能暫時不會使用，因為可能是固定的
 * @f 要排序的欄位(FieldSort)
 * @s string SearchKeyword(思考一下要不要這樣子做，或是參考一下sjcoudweb v2)應該要先做encode的動作
 * @z 移除搜尋
 *
 * @v 除了上面以外，其它的就是parameter群，依照順序(Values)
 *
 * 底下是使用的範例：
 * public function index($param = '')
 * {
 *		$this->load->library('Parameter_handle', '', 'parameter');
 *		$params = $this->parameter->get($param);
 *		$param_define = $this->data['parameter'] = $this->parameter->getDefine();
 * 
 *		$this->load->library('base64url');
 * 
 *		// 排序的欄位
 *		if($params['sort'] == ''){
 *			// 這裡指定預設要排序的欄位
 *			$sort_field = $this->def['default_sort_field'];
 *		} else {
 *			$sort_field = $this->base64url->decode($params['sort']);
 *		}
 *		$this->data['sort_field'] = $this->base64url->encode($sort_field);
 *		$this->data['sort_field_nobase64'] = $sort_field;
 * 
 *		// 排序欄位的方向(asc, desc)
 *		if($params['direction'] == ''){
 *			$sort_direction = 'asc';
 *			$next_sort_direction = 'desc';
 *		} else {
 *			$sort_direction = $params['direction'];
 *			if($sort_direction == 'asc'){
 *				$next_sort_direction = 'desc';
 *			} else {
 *				$next_sort_direction = 'asc';
 *			}
 *		}
 *		$this->data['sort_direction'] = $sort_direction;
 *		$this->data['next_sort_direction'] = $next_sort_direction;
 *
 *		// 設定每頁顯示的筆數
 *		if($params['record'] != ''){
 *			$record = $params['record'];
 *			$this->session->set_userdata('record', (int)$record);
 *		} else {
 *			$record = $this->session->userdata('record');
 *			if($record === false or $record == ''){
 *				$record = '10';
 *				$this->session->set_userdata('record', (int)$record);
 *			}
 *		}
 *		$this->data['record'] = (int)$record;
 *
 *		// 分頁區塊
 *		$this->load->library('splitpage');
 *		$this->splitpage->set($params['page'], $total_rows, $record, $params['list']); //set($page, $total_records, $records_per_page, $listPage)
 *		$base_url = $this->config->item('base_url').'/'.$this->data['router_class'];
 *		if(isset($params['module_serial_id']) and $params['module_serial_id'] != ''){
 *			$base_url .= '_'.$params['module_serial_id'];
 *		}
 *		$base_url .= '/'.$this->data['router_method'];
 *		$base_url2 = $base_url;
 *		$base_url .= '/'.$this->parameter->getDefine('page');
 *		$this->data['pagination'] = $this->splitpage->setViewList_for_rewrite($base_url, $base_url2); // 取得分頁bar的變數
 *
 *		// 取得資料
 *        $u = new $this->def['orm']();
 *		if($search_keyword != '' and isset($this->def['search_keyword_field']) and count($this->def['search_keyword_field']) > 0){
 *			// 範例SQL語法，因為要括號起來，比較特別，所以在這裡寫個範例
 *			// select * from html where type='faq' and ml_key='en' and (topic like '%b%' or detail like '%b%')
 *			$search_sql_append = '(';
 *			$search_sql_appends = array();
 *			foreach($this->def['search_keyword_field'] as $k => $v){
 *				$search_sql_appends[] = ' `'.$v.'` LIKE \'%'.$search_keyword.'%\' ';
 *			}
 *			$search_sql_append .= implode(' OR ', $search_sql_appends);
 *			$search_sql_append .= ')';
 *			$u->where($search_sql_append);
 *		}
 *		$u->limit($record, ($params['page']-1)*$record);
 *		$u->order_by($sort_field, $params['direction']);
 *		if(isset($this->def['condition'])){
 *			// @k active record method
 *			// @v array, string
 *			foreach($this->def['condition'] as $k => $v){
 *				$u->{$k}($v);
 *			}
 *		}
 *		$u->get();
 *		$listcontent = array();
 *		if($u->result_count() > 0){
 *			 $listcontent = $u->all_to_array();
 *		}
 *		$this->data['listcontent'] = $listcontent;
 * } // end function index
 */
class Parameter_handle {

	protected $_splitchar = '-';

	protected $_define_a = array(
		'module_serial_id' => 'm', // 模組
		'page' => 'p', // 第幾頁，或是從第幾筆開始
		'record' => 'r', // 幾筆一頁
		'list' => 'l', // 一次顯示幾個分頁
		'sort' => 'f', // 要排序的欄位
		'direction' => 'e',  // 排序的方向
		'search' => 's', // 要搜尋的字串(base64)
		'nosearch' => 'z', // 移除搜尋
		'prev' => 'a', // 記錄上一頁的完整網址(base64)
		'value' => 'v', // 真正程式的引數
	);

	// 值不能為value
	protected $_define_b = array(
		'm' => 'module_serial_id',
		'p' => 'page', // 第幾頁
		'r' => 'record', // 幾筆一頁
		'l' => 'list', // 一次顯示幾個分頁
		'f' => 'sort', // 要排序的欄位
		'e' => 'direction', // 排序的方向desc, asc
		's' => 'search', // 要搜尋的字串
		'z' => 'nosearch', // 移除搜尋
		'a' => 'prev', // 記錄上一頁的完整網址
		'v' => 'value', // 真正程式的引數
	);

	// 預設值
	protected $_define_c = array(
		'module_serial_id' => '',
		'page' => 1, // 適合從1開始的分頁函式(splitpage)，入賢版的分頁是從0零開
		'record' => '',
		'list' => 10,
		'sort' => '',
		// 想要改成空白，我為我有另外為它準備程式碼填預設值
		//'direction' => 'asc', // desc, asc
		'direction' => '', // desc, asc
		'search' => '',
		'nosearch' => '',
		'prev' => '',
		'value' => array(),
		//'value' => '',
	);

	public function getDefine($aaa = '')
	{
		if($aaa != ''){
			return $this->_define_a[$aaa];
		}

		return $this->_define_a;
	}

	/**
	 * @default_params	array	會重新覆蓋欄位預設值(_define_c)
	 */
	function __construct($default_params = array())
	{
		$this->_define_c = array_merge($this->_define_c, $default_params);
	}

	public function splitchar($splitchar)
	{
		$this->_splitchar = $splitchar;
	}

	/*
	 * 設定網址變數，每個參數開頭的英文字母
	 */
	public function seta($data)
	{
		$this->_define_a = array_merge($this->_define_a, $data);
	}
	public function setb($data)
	{
		$this->_define_b = array_merge($this->_define_b, $data);
	}

	public function setc($data)
	{
		$this->_define_c = array_merge($this->_define_c, $data);
	}

	public function get($param)
	{
		$return = $this->_define_c;

		// 設定空的
		//if(isset($this->_define_b) and count($this->_define_b) > 0){
		//	foreach($this->_define_b as $k => $v){
		//		$return[$v] = '';
		//	}
		//	$return['value'] = array();
		//}

		// 檢查有沒有切割字元
		//if(!preg_match('/'.$this->_splitchar.'/', $param)){
		//   	return $return;
		//}

		$params_split = explode($this->_splitchar, $param);

		// 切割後，做match配對
		if(!empty($params_split)){
			foreach($params_split as $k => $v){
				$tmp1 = '';
				if(strlen($v) > 1){
					$tmp1 = substr($v, 1);
				}
				if(strlen($v) >= 1){
					$tmp = substr($v, 0, 1);
					if(isset($this->_define_b[$tmp]) and $this->_define_b[$tmp] != ''){
						$tmp3 = $this->_define_b[$tmp];
						if($tmp1 == ''){
							// 取得預設值
							$tmp1 = $this->_define_c[$tmp3];
						}
						if($tmp3 == 'value'){
							$return['value'][] = $tmp1;
						} else {
							$return[$tmp3] = $tmp1;
						}
						unset($params_split[$k]);
					}	
				}
			} // foreach
		}

		if(!empty($params_split)){
			foreach($params_split as $k => $v){
				$return['value'][] = $v;
			}
		}

		return $return;
	}
}

class sys_log {

	/*
	 * @code string 打算存放"$class/$action"
	 * @msg string 詳細的訊息
	 */
	public static function set($db, $msg = '')
	{
		$ip = 'UNKNOWN';
		$list = array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP', // http://devco.re/blog/2014/06/19/client-ip-detection/
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
			'HTTP_VIA', // http://devco.re/blog/2014/06/19/client-ip-detection/
		);  

		foreach($list as $v){
			if(isset($_SERVER[$v])){
				$ip = $_SERVER[$v];
				break;
			}
		}   

		$save = array(
			'log_code' => $_SESSION['sys_log_code'],
			'log_msg' => $msg,
			'user_id' => 0, 
			'ip_addr' => $ip,
			'create_time' => date("Y-m-d H:i:s"),
		);
		if(isset($_SESSION['auth_admin_id']) and $_SESSION['auth_admin_id'] != null){
			$save['user_id'] = $_SESSION['auth_admin_id'];
		}
		$db->insert('sys_log', $save);
	}

}

function get_client_ip() {
    $ip = 'UNKNOWN';
    $list = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP', // http://devco.re/blog/2014/06/19/client-ip-detection/
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
        'HTTP_VIA', // http://devco.re/blog/2014/06/19/client-ip-detection/
    );  

    foreach($list as $v){
        if(isset($_SERVER[$v])){
            $ip = $_SERVER[$v];
            break;
        }
    }   

    return $ip;
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

// 在新增或修改的時候，都會有需要取得資料庫的筆數，如果是新增，筆數還要加1，這裡就專做這件事
function dbc($db, $class_method = '', $def = array(), $rules = array())
{
	$count = 0;
	if($class_method == ''){
		return $count;
	}

	//    $db = Yii::app()->db;
	//    $c = $db->createCommand();
	//    $c->select('count(*)');
	//    $c->from($def['table']);
	//    // @k active record method
	//    // @v array, string 屬性群
	//    //foreach($def['condition'] as $k => $v){
	//    //	$c->{$k}($v[0], $v[1]);
	//    //}
	//    if(isset($def['condition'])){
	//    	$r_condition = self::dbt($def['condition'], '$c');
	//    	if($r_condition != ''){
	//    		eval($r_condition);
	//    	}
	//    }
	//    // 因為是新增，所以增加一筆
	//    //$class_sort_count = count($c->queryAll());
	//    $count = $c->queryScalar();
	//    if($class_method == 'create'){
	//    	$count++;
	//    }

	$o = $db;
	if(isset($def['condition']) and !empty($def['condition'])){
		foreach($def['condition'] as $k => $v){
			if(count($v) <= 1) continue;
			$method_tmp = $v[0];
			unset($v[0]);
			$aaa = '$o->'.$method_tmp.'("'.implode(',',$v).'");';
			//echo $aaa;
			eval($aaa);
		}
	}
	$query = $o->get($rules['table']);
	$count = $query->num_rows();

	//if(isset($def['listfield']['sort_id'])){
	//}

	return $count;
}

/**
 * 預設是deny，如果你有建立resource，而沒有去設定permission的話
 */
class Admin_acl {

	protected $cidb;

	// protected $db;
	protected $acl;

	protected $_resources;
	protected $_users;
	protected $_users_tmp; // 以user_id為key的資料陣列

	protected $_urls;
	protected $_urls_tmp;

	protected $_groups;

	// 只有is_hidden的使用者們，可以看得到的東西
	protected $_hidden_permission;

	// 寫死的，不管資料表admin_resource怎麼寫，如果這裡有，那就還是會列為隱藏權限
	//protected $_hidden_permission2 = 'admin_resource|module|module_register|website_config|admin_menu|language|seo|test|route_list|short_url|list_css|demotemplate|demotemplatelist';
	protected $_hidden_permission2 = '';

	// 給zend acl用的前綴
	protected $_zend_acl_prefix = 'adminacl_';

	// 網址授權
	protected $_user_url_perms;
	protected $_group_url_perms;
	protected $_user_url_action_perms;
	protected $_group_url_action_perms;

	// 反向授權
	protected $_user_revert_perms;

	function __construct($db)
	{
		$this->cidb = $db;

		// 這幾行是一定要做的
		//$CI = &get_instance ();
		//$CI->load->helper('zend_framework');
		//Zend_Loader::loadClass('Zend_Acl');
		$this->acl = new Zend_Acl();

		// $this->db = Yii::app()->db;
		$this->session = $_SESSION;
	}

	public function start()
	{
		$this->_getData();
		$this->_setAcl();
	}

	public function getResources($admin_id)
	{
		$resources = array();

		// 取得Resource
		$auth_admin_is_hidden = $this->session['auth_admin_is_hidden'];
		// $r = $this->db->createCommand();
		$condition = '';
		if($auth_admin_is_hidden != '1'){
			$this->cidb->where('is_hidden', '0');
			// $r->where('is_hidden = 0');
			// $condition = 'is_hidden = 0 and ';
		}
		$this->cidb->where('is_enable', '1');
		$rows = $this->cidb->get('admin_resource')->result_array();
		// $r->where($condition.'is_enable = 1');
		// $rows = $r->select('*')->from('admin_resource')->queryAll();

		$hidden_permission = array();
		foreach($rows as $row){
			$resources[] = $row['name'];
			if($row['is_hidden'] == '1'){
				$hidden_permission[] = $row['name'];
			}
		}
		$this->_hidden_permission = $hidden_permission;

		//$resources2 = $this->getModuleResources();

		// $urls = $this->db->createCommand()->from('admin_url')->where('is_enable = 1 and param_condition != ""')->queryAll();
		$urls = $this->cidb->where('is_enable = 1 and param_condition != ""')->get('admin_url')->result_array();

		if(isset($this->_users_tmp[$admin_id]['is_hidden']) and $this->_users_tmp[$admin_id]['is_hidden'] == '0'){
			// 把不該出現給客戶用的給弄掉
			if(!empty($resources)){
				foreach($resources as $k => $v){
					if(in_array($v, $this->_hidden_permission)){
						unset($resources[$k]);
					}
					if(preg_match('/^('.$this->_hidden_permission2.')$/', $v)){
						unset($resources[$k]);
					}
				}
			}

			if(!empty($urls)){
				foreach($urls as $k => $v){
					if(in_array($v['name'], $this->_hidden_permission)){
						unset($urls[$k]);
					}
					if(preg_match('/^('.$this->_hidden_permission2.')$/', $v['name'])){
						unset($urls[$k]);
					}
				}
			}
		}

		$urls_tmp = array();
		if(!empty($urls)){
			foreach($urls as $k => $v){
				$urls_tmp[$v['id']] = $v;
			}
		}

		$this->_urls = $urls;
		$this->_urls_tmp = $urls_tmp;
		//var_dump($urls_tmp);
		//die;

		return $resources;
	}

	//public function getModuleResources()
	//{
	//	$query = $this->db->get('module_register');
	//	$rows = array();
	//	foreach($query->result_array() as $row){
	//		$rows[] = $row;
	//	}
	//	return $rows;
	//}

	protected function _getData()
	{
		// 取得所有User
		// $rows = $this->db->createCommand()
		// ->select('*')
		// ->from('member')
		// ->where('is_enable=1')
		// ->queryAll();
		$rows = $this->cidb->where('is_enable',1)->get('member')->result_array();
		$rows_tmp = array();
		foreach($rows as $row){
			$rows_tmp[$row['id']] = $row;
		}
		$this->_users = $rows;
		$this->_users_tmp = $rows_tmp;

		// 取得所有的群組
		// $rows = $this->db->createCommand()
		// ->select('*')
		// ->from('admin_group')
		// ->where('is_enable=1')
		// ->queryAll();
		$rows = $this->cidb->where('is_enable',1)->get('admin_group')->result_array();
		$this->_groups = $rows;

		$this->_resources = $resources = $this->getResources($this->session['auth_admin_id']);

	}

	protected function _setAcl()
	{
		$admin_id = $this->session['auth_admin_id'];
		$admin_type = $this->session['auth_admin_type'];

		// 不好意思，你一定要有使用者編號，不然不給你進來
		if($admin_id == ''){
			return;
		}

		// 設定resource
		//var_dump($this->_resources);
		if(!empty($this->_resources)){
			foreach($this->_resources as $resource) {
				if($resource == '') continue;
				$zend_resource = new Zend_Acl_Resource($resource);

				try {
					$this->acl->add($zend_resource);
				} catch(Exception $e){
				}
			}
		}

		// debug
		//$zend_resource = new Zend_Acl_Resource('productclass');
		//$this->acl->add($zend_resource);

		// 取得所有網址的權限(簡易)，使用者的部份
		// $user_url_perms = $this->db->createCommand()
		// ->from('admin_user_url_perm')
		// ->where('value=1 and user_id='.$admin_id)
		// ->queryAll();
		$user_url_perms = $this->cidb->where('value =1 and user_id='.$admin_id)->get('admin_user_url_perm')->result_array();

		if($user_url_perms){
			foreach($user_url_perms as $k => $v){
				if(isset($this->_urls_tmp[$v['url_id']])){
					$v['url'] = $this->_urls_tmp[$v['url_id']]['param_condition'];
					$user_url_perms[$k] = $v;
				}
			}
		} else {
			$user_url_perms = array();
		}

		$this->_user_url_perms = $user_url_perms;

		// 取得所有網址的權限(進階)，使用者的部份
		// $user_url_action_perms = $this->db->createCommand()
		// ->from('admin_user_url_action_perm')
		// ->where('value = 1 and action != "" and user_id = '.$admin_id)
		// ->queryAll();
		$user_url_action_perms = $this->cidb->where('value = 1 and action != "" and user_id = '.$admin_id)->get('admin_user_url_action_perm')->result_array();

		if($user_url_action_perms){
			foreach($user_url_action_perms as $k => $v){
				if(isset($this->_urls_tmp[$v['url_id']])){
					$v['url'] = $this->_urls_tmp[$v['url_id']]['param_condition'];
					$user_url_action_perms[$k] = $v;
				}
			}
		} else {
			$user_url_action_perms = array();
		}
		//var_dump($user_url_action_perms);
		//die;
		$this->_user_url_action_perms = $user_url_action_perms;

		/*
		 * 使用者簡易授權
		 */

		// 取得現在這個使用者的權限，然後整理起來
		// $normals_tmp = $this->db->createCommand()
		// ->from('admin_user_perm')
		// ->where('user_id='.$admin_id)
		// ->queryAll();
		$normals_tmp = $this->cidb->where('user_id ='.$admin_id)->get('admin_user_perm')->result_array();

		$normals = array();
		if(!empty($normals_tmp)){
			foreach($normals_tmp as $k => $v){
				$normals[$v['resource']] = $v['value'];
			}
		}

		$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_u1_'.$admin_id);
		$this->acl->addRole($zend_role);

		if(!empty($normals)){
			foreach($normals as $k => $v) {
				if($v == '1'){
					try {
						$this->acl->allow($this->_zend_acl_prefix.'_u1_'.$admin_id, $k);
					} catch(Exception $e){
					}
				} else {
					try {
						$this->acl->deny($this->_zend_acl_prefix.'_u1_'.$admin_id, $k);
					} catch(Exception $e){
					}
				}
			}
		}

		// 使用者反向授權(要有資料才會啟用這個功能) - 振聲
		// $user_revert_perm_rows = $this->db->createCommand()
		// ->from('admin_user_revert_perm')
		// ->where('value = 1 and user_id = '.$admin_id)
		// ->queryAll();
		$user_revert_perm_rows = $this->cidb->where('value = 1 and user_id = '.$admin_id)->get('admin_user_revert_perm')->result_array();

		$user_revert_perms = array();
		if($user_revert_perm_rows){
			foreach($user_revert_perm_rows as $k => $v){
				$user_revert_perms[] = $v['resource'];
			}
		}
		$this->_user_revert_perms = $user_revert_perms;

		// debug
		//$this->acl->allow($this->_zend_acl_prefix.'_u1_'.'12', 'productclass');

		/*
		 * 使用者進階授權
		 */

		// 取得現在這個使用者的權限，然後整理起來
		// $normals_tmp = $this->db->createCommand()
		// ->from('admin_user_action_perm')
		// ->where('user_id='.$admin_id)
		// ->queryAll();
		$normals_tmp = $this->cidb->where('user_id ='.$admin_id)->get('admin_user_action_perm')->result_array();

		$normals = array();
		if(!empty($normals_tmp)){
			foreach($normals_tmp as $k => $v){
				$normals[$v['resource']][$v['action']] = $v['value'];
			}
		}

		$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_u2_'.$admin_id);
		$this->acl->addRole($zend_role);

		if(!empty($normals)){
			foreach($normals as $k => $v) {
				if(count($v) == 1 and isset($v['all'])){
					if($v['all'] == '1'){
						try {
							$this->acl->allow($this->_zend_acl_prefix.'_u2_'.$admin_id, $k);
						} catch(Exception $e){
						}
					} elseif($v['all'] == '0'){
						try {
							$this->acl->deny($this->_zend_acl_prefix.'_u2_'.$admin_id, $k);
						} catch(Exception $e){
						}
					}
					continue;
				}

				foreach($v as $kk => $vv) {
					if($vv == '1'){
						try {
							$this->acl->allow($this->_zend_acl_prefix.'_u2_'.$admin_id, $k, $kk);
						} catch(Exception $e){
						}
					} else {
						try {
							$this->acl->deny($this->_zend_acl_prefix.'_u2_'.$admin_id, $k, $kk);
						} catch(Exception $e){
						}
					}
				}
			}
		}

		/*
		 * 群組簡易授權
		 */

		// 準備並重組群組的搜尋條件

		// 如果沒有指定，那接下來的事情就不用做了
		if($admin_type == ''){
			return;
		}
		$groups = explode(',', $admin_type);

		$tmp = array();
		foreach($groups as $k => $v){
			$tmp[] = 'group_id ='.$v;
		}

		$group_condition = implode(' OR ', $tmp);

		// $normals_tmp = $this->db->createCommand()
		// ->from('admin_group_perm')
		// ->where($group_condition)
		// ->queryAll();
		$normals_tmp = $this->cidb->where($group_condition)->get('admin_group_perm')->result_array();

		$normals = array();
		if(!empty($normals_tmp)){
			foreach($normals_tmp as $k => $v){
				// 試試能否解決generate/funcsample的授權失敗的問題
				$v['resource'] = str_replace('/', '', $v['resource']);

				$normals[$v['group_id']][$v['resource']] = $v['value'];
			}
		}


		if(!empty($normals)){
			// 先讓群組的role先跑一次迴圈
			foreach($normals as $k => $v) {
				$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_g1_'.$k);
				$this->acl->addRole($zend_role);
			}

			foreach($normals as $k => $v) {
				foreach($v as $kk => $vv) {
					if($vv == '1'){
						//echo $k;
						//echo $kk;
						//die;
						try {
							$this->acl->allow($this->_zend_acl_prefix.'_g1_'.$k, $kk);
						} catch(Exception $e){
						}
					} else {
						try {
							$this->acl->deny($this->_zend_acl_prefix.'_g1_'.$k, $kk);
						} catch(Exception $e){
						}
					}
				}
			}
		}
		//die;

		/*
		 * 群組進階授權
		 */

		// $normals_tmp = $this->db->createCommand()
		// ->from('admin_group_action_perm')
		// ->where($group_condition)
		// ->queryAll();
		$normals_tmp = $this->cidb->where($group_condition)->get('admin_group_action_perm')->result_array();

		$normals = array();
		if(!empty($normals_tmp)){
			foreach($normals_tmp as $k => $v){
				// 試試能否解決generate/funcsample的授權失敗的問題
				$v['resource'] = str_replace('/', '', $v['resource']);

				$normals[$v['group_id']][$v['resource']][$v['action']] = $v['value'];
			}
		}

		//$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_g2_'.$admin_id);
		//$this->acl->addRole($zend_role);

		if(!empty($normals)){

			// 先讓群組的role先跑一次迴圈
			foreach($normals as $k => $v) {
				$zend_role = new Zend_Acl_Role($this->_zend_acl_prefix.'_g2_'.$k);
				$this->acl->addRole($zend_role);
			}

			// @k group_id
			foreach($normals as $k => $v) {
				// @kk resource
				foreach($v as $kk => $vv) {
					if(count($vv) == 1 and isset($vv['all'])){
						if($vv['all'] == '1'){
							try {
								$this->acl->allow($this->_zend_acl_prefix.'_g2_'.$k, $kk);
							} catch(Exception $e){
							}
						} elseif($vv['all'] == '0'){
							try {
								$this->acl->deny($this->_zend_acl_prefix.'_g2_'.$k, $kk);
							} catch(Exception $e){
							}
						}
						continue;
					}

					foreach($vv as $kkk => $vvv) {
						if($vvv == '1'){
							try {
								$this->acl->allow($this->_zend_acl_prefix.'_g2_'.$k, $kk, $kkk);
							} catch(Exception $e){
							}
						} else {
							try {
								$this->acl->deny($this->_zend_acl_prefix.'_g2_'.$k, $kk, $kkk);
							} catch(Exception $e){
							}
						}
					}
				}
			}
		}

		// 取得所有網址的權限(簡易)，群組的部份
		// $group_url_perms = $this->db->createCommand()
		// ->from('admin_group_url_perm')
		// ->where('('.$group_condition.') and value=1')
		// ->queryAll();
		$group_url_perms = $this->cidb->where('('.$group_condition.') and value=1')->get('admin_group_url_perm')->result_array();

		if($group_url_perms){
			foreach($group_url_perms as $k => $v){
				if(isset($this->_urls_tmp[$v['id']])){
					$v['url'] = $this->_urls_tmp[$v['id']]['param_condition'];
					$group_url_perms[$k] = $v;
				}
			}
		} else {
			$group_url_perms = array();
		}
		$this->_group_url_perms = $group_url_perms;


	} // setAcl

	/*
	 * Methods to query the ACL.
	 * @param string vaaa-vbbb-vccc...
	 */
	public function hasAcl($user_id = null, $resource_key, $action_key = 'index', $param = '')
	{

		// 試試能否解決generate/funcsample的授權失敗的問題
		$resource_key = str_replace('/', '', $resource_key);

		if($user_id == null){
			$user_id = $this->session['auth_admin_id'];
		}

		$group_ids_tmp = $this->session['auth_admin_type'];
		// debug
		//$group_ids_tmp = '6,9,11';

		$group_ids = explode(',', $group_ids_tmp);
		//var_dump($group_ids);

		if($user_id == '1') return true;

		// debug 分別是手動開啟某一個測試tco和業務的編號
		//if(preg_match('/^(26)$/', $user_id)) return true;

		// 這是BUG，要注意
		//if($resource_key == 'home') return true;

		if($resource_key == 'site') return true;

		$other_param = array();
		// resource_key => generate/funcsample
		if(preg_match('/^r=/', $resource_key)){
			$tmp = explode('&', $resource_key);
			foreach($tmp as $k => $v){
				$tmp1 = explode('=', $v);
				$key1 = $tmp1[0];
				$value1 = str_replace($key1.'=', '', $v);
				$other_param[$key1] = $value1;
			}
			if(isset($other_param['param']) and $param == ''){
				$param = $other_param['param'];
			}
			if(isset($other_param['r'])){
				$tmp3 = explode('/', $other_param['r']);
				/*
				 * generate是我之前寫的功能，controller的網址多了generate的字眼，也就是多了一層
				 */
				if(count($tmp3) == 3){
					if($tmp3[0] == 'generate'){
						$resource_key = $tmp3[1];
						$action_key = $tmp3[2];
					}
				} elseif(count($tmp3) == 2){
					if($tmp3[0] == 'generate'){
						$resource_key = $tmp3[1];
					} else {
						// 只有兩個的時候要特別處理一下，例如payment/create，就要分配了
						$resource_key = $tmp3[0];
						$action_key = $tmp3[1];
					}
				} elseif(count($tmp3) == 1){
					if($tmp3[0] != 'generate'){
						$resource_key = $tmp3[0];
					}
				}
			}
		}

		if(isset($this->_users_tmp[$user_id]['is_hidden']) and $this->_users_tmp[$user_id]['is_hidden'] == 0){
			if(in_array($resource_key, $this->_hidden_permission)){
				return false;
			}
		}

		$return = false;

		// 從EIP過來的使用者
		if(preg_match('/^99999(.*)$/', $user_id) and preg_match('/^buyersline_(.*)$/', $this->session['auth_admin_account']) ){
			
			// 設計部、資訊部
			if(in_array(999994, $group_ids) or in_array(999995, $group_ids)){
				$this->_user_revert_perms = array(
					'none',
				);
			} elseif(in_array(999999, $group_ids)){ // SEO部
				$this->_user_revert_perms = array(
					// 這裡是layoutv2在使用的
					'funcv2','layoutv2configscss','layoutv2pagelist','layoutv2cssjs','homeother',

					// 系統最大管理
					'adminmenu','webmenu','webmenuchild','webmenusub',
					'language','label','funclist','adminresource','functionconstant','emailformat',

					// LayoutV3(內勤用
					'scssconfig', 'layoutv3page',

					// 首頁管理(公司用
					'banner','bannersub','companyother','banner1','banner2','sidead','indexad',
				);
			} elseif(in_array(999997, $group_ids) or in_array(999993, $group_ids)){ // 企劃部、業務部
				$this->_user_revert_perms = array(
					'seo',

					// 這裡是layoutv2在使用的
					'funcv2','layoutv2configscss','layoutv2pagelist','layoutv2cssjs','homeother',

					// 系統最大管理
					'adminmenu','webmenu','webmenuchild','webmenusub',
					'language','label','funclist','adminresource','functionconstant','emailformat',

					// LayoutV3(內勤用
					'scssconfig', 'layoutv3page',

					// 首頁管理(公司用
					'banner','bannersub','companyother','banner1','banner2','sidead','indexad',
				);
			}

		}

		// 反向授權
		if(isset($this->_user_revert_perms) and !empty($this->_user_revert_perms)){
			if(!in_array($resource_key, $this->_user_revert_perms)){
				$return = true;
			}
		}

		// 如果其中一個符合，就符合了
		if($return === true){
			return true;
		}

		// 使用者簡易授權
		try {
			$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_u1_'.$user_id, $resource_key, $action_key)?TRUE:FALSE;
			if($tmp === true){
				$return = true;
			}
		} catch(Exception $e){
			//echo $e;
			//return false;
		}

		// 如果其中一個符合，就符合了
		if($return === true){
			return true;
		}

		// 使用者進階授權
		try {
			$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_u2_'.$user_id, $resource_key, $action_key)?TRUE:FALSE;
			// debug
			//echo $user_id;
			//echo $resource_key;
			//echo $action_key;
			//var_dump($tmp);
			//die;
			if($tmp === true){
				$return = true;
			}
		} catch(Exception $e){
			//return false;
		}

		// 如果其中一個符合，就符合了
		if($return === true){
			return true;
		}

		// 群組統一授權
		if(!empty($group_ids)){
			foreach($group_ids as $v){
				// 群組簡易授權
				try {
					//echo $v;
					//echo $resource_key;
					$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_g1_'.$v, $resource_key)?TRUE:FALSE;
					if($tmp === true){
						$return = true;
					}
				} catch(Exception $e){
				}
				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}

				// 群組進階授權
				try {
					$tmp = $this->acl->isAllowed($this->_zend_acl_prefix.'_g2_'.$v, $resource_key, $action_key)?TRUE:FALSE;
					if($tmp === true){
						$return = true;
					}
				} catch(Exception $e){
				}

				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}
			}
		}


		// 網址授權
		if($this->_urls and !empty($this->_urls)){
			$parameter = new Parameter_handle;
			$params = $parameter->get($param);

			// 使用者簡易網址檢查
			foreach($this->_user_url_perms as $kk => $vv){
				$run = 'if('.$vv['url'].'){'."\n";
				$run .= '  $return = true;';
				$run .= '}'."\n";
				eval($run);

				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}
			}

			// 如果其中一個符合，就符合了
			if($return === true){
				return true;
			}

			// 使用者進階網址檢查
			foreach($this->_user_url_action_perms as $kk => $vv){
				if(!isset($vv['url']) or $vv['url'] == '') continue;
				$run = '';
				if($vv['action'] == 'all'){
					$run = 'if('.$vv['url'].'){'."\n";
				} else {
					$run = 'if(('.$vv['url'].') and "'.$action_key.'" == "'.$vv['action'].'"){'."\n";
				}
				$run .= '  $return = true;';
				$run .= '}'."\n";
				eval($run);

				// 如果其中一個符合，就符合了
				if($return === true){
					return true;
				}
			}

			// 如果其中一個符合，就符合了
			if($return === true){
				return true;
			}

			// 群組簡易網址檢查
			if(!empty($group_ids)){
				foreach($group_ids as $v){
					foreach($this->_group_url_perms as $kk => $vv){
						if(!isset($vv['url']) or $vv['url'] == '') continue;
						$run = 'if('.$vv['url'].'){'."\n";
						$run .= '  $return = true;';
						$run .= '}'."\n";
						eval($run);

						// 如果其中一個符合，就符合了
						if($return === true){
							return true;
						}
					}
				}
			}
		}

		return $return;
	}

	protected function _getFilesFromDir($dir) {

	  $files = array();
	  if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != '.svn') {
				if(is_dir($dir.'/'.$file)){
					$dir2 = $dir.'/'.$file;
					$files[] = $this->_getFilesFromDir($dir2);
				}
				else {
				  // 當controller是m_開頭的時候，代表它是模組，不會納入acl resource裡面
				  if(!preg_match('/^m_(.*)/', $file)){
					$files[] = $dir.'/'.$file;
				  }
				}
			}
		}   
		closedir($handle);
	  }

	  return $this->_array_flat($files);
	}

	protected function _array_flat($array) {

	  $tmp = array();
	  foreach($array as $a) {
		if(is_array($a)) {
		  $tmp = array_merge($tmp, $this->_array_flat($a));
		}   
		else {
		  $tmp[] = $a; 
		}   
	  }

	  return $tmp;
	}

}
