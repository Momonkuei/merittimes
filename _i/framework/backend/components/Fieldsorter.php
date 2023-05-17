<?php

class Fieldsorter
{
	protected $_msg;

	protected $_table_name;
	protected $_id_name; // 資料表的主索引欄位名稱，通常都是id
	protected $_field_id;
	protected $_new_sort_id;

	// 
	protected $_conditions;
	protected $_condition_string = '';
	protected $_sort_field;

	function __construct()
	{
		//$CI =& get_instance();
		//$this->db = $CI->db;
		$this->db = Yii::app()->db;
	}

	public function setTableName($table_name)
	{
		$this->_table_name = $table_name;
	}

	public function setIdName($id_name)
	{
		$this->_id_name = $id_name;
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

		//if(count($conditions) > 0){
		if(!empty($conditions)){
		   	$this->_conditions = $conditions;
		} else {
			$conditions = $this->_conditions;
		}

		// 2019-10-05 PHP7
		if($conditions === null){
			$conditions = array();
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

		$c = $this->db->createCommand();
		$c->select('count(*)');
		$c->from($table_name);

		// 取得總筆數
		//if(count($conditions) > 0){
		//	foreach($conditions as $k => $v){
		//		$this->db->{$k}($v);
		//	}
		//}

		//if(count($conditions) > 0){
		//	// @k active record method
		//	// @v array, string 屬性群
		//	foreach($conditions as $k => $v){
		//		$c->{$k}($v[0], $v[1]);
		//	}
		//}
		$r_condition = G::dbt($conditions, '$c');
		if($r_condition != ''){
			//echo $r_condition;
			eval($r_condition);
		}

		if($condition_string != ''){
			//$this->db->where($condition_string);
			$c->andWhere($condition_string);
		}
		//$query = $this->db->get($table_name);
		//$count = $query->num_rows();

		$count = $c->queryScalar();

		if($new_sort_id > $count){
			$new_sort_id = $count;
		}

		// 找到目前這筆資料的排序編號
		//$aaa = $this->db->select('id, '.$sort_field);
		$source_conditions = array();
		//if(count($conditions) > 0){
		//	$source_conditions = $conditions;
		//}
		//$source_conditions['where']['id'] = $field_id;
		//foreach($source_conditions as $k => $v){
		//	$aaa->{$k}($v);
		//}
		//if($condition_string != ''){
		//	$aaa->where($condition_string);
		//}
		//$query = $aaa->get($this->_table_name);
		//$source_row_tmp = $query->result_array();
		//if(count($source_row_tmp) <= 0){
		//	$this->_msg = 'fetch source row is empty';
		//	return;
		//}
		//$source_row = $source_row_tmp[0];

		// 找到目前這筆資料的排序編號
		$aaa = $this->db->createCommand();
		$aaa->select($this->_id_name.', '.$sort_field);
		$aaa->from($table_name);
		//if(count($conditions) > 0){
		if(!empty($conditions)){
			$source_conditions = $conditions;
		}
		//$source_conditions['where'][0] = 'id = '.$field_id;
		//foreach($source_conditions as $k => $v){
		//	//$aaa->{$k}($v);
		//	$aaa->{$k}($v[0]);
		//}

		// [Source] 先下原本就有的條件
		$r_condition = G::dbt($source_conditions, '$aaa');
		if($r_condition != ''){
			eval($r_condition);
		}

		// [Source] 原本的下完了之後，在下額外的條件
		$source_other = array(
			array(
				'where',
				$this->_id_name.'=:id',
				array(
					':id' => $field_id,
				),
			),
		);
		$r_condition = G::dbt($source_other, '$aaa');
		if($r_condition != ''){
			eval($r_condition);
		}

		if($condition_string != ''){
			$aaa->andWhere($condition_string);
		}
		$source_row = $aaa->queryRow();
		//$query = $aaa->get($this->_table_name);
		//$source_row_tmp = $query->result_array();
		if($source_row === false){
			$this->_msg = 'fetch source row is empty';
			// debug
			//echo '123'."\n";
			//var_dump($source_conditions);
			//echo '223'."\n";
			//var_dump( $condition_string);
			//echo '323'."\n";
			//var_dump($r_condition);
			//echo '423'."\n";
			//var_dump($source_other);
			die;
			return;
		}

		// debug
		//echo 'success';
		//echo '123'."\n";
		//var_dump($source_conditions);
		//echo '223'."\n";
		//var_dump( $condition_string);
		//echo '323'."\n";
		//var_dump($r_condition);
		//echo '423'."\n";
		//var_dump($source_other);
		//die;

		// 找到新排序編號上的欄位編號
		//$bbb = $this->db->select('id, '.$sort_field);
		//$dest_conditions = array();
		//if(count($conditions) > 0){
		//	$dest_conditions = $conditions;
		//}
		//$dest_conditions['where'][$sort_field] = $new_sort_id;
		//foreach($dest_conditions as $k => $v){
		//	$bbb->{$k}($v);
		//}
		//if($condition_string != ''){
		//	$bbb->where($condition_string);
		//}
		//$query = $bbb->get($this->_table_name);
		//$dest_row_tmp = $query->result_array();
		//if(count($dest_row_tmp) <= 0){
		//	$this->_msg = 'fetch dest row is empty';
		//	return;
		//}
		//$dest_row = $dest_row_tmp[0];

		// 找到新排序編號上的欄位編號
		$bbb = $this->db->createCommand();
		$bbb->select($this->_id_name.', '.$sort_field);
		$bbb->from($table_name);
		$dest_conditions = array();
		//if(count($conditions) > 0){
		if(!empty($conditions)){
			$dest_conditions = $conditions;
		}

		if($condition_string != ''){
			//$this->db->where($condition_string);
			$bbb->where($condition_string);
		}

		//$dest_conditions['where'][0] = $sort_field' = '.$new_sort_id;
		//foreach($dest_conditions as $k => $v){
		//	//$bbb->{$k}($v);
		//	$bbb->{$k}($v[0]);
		//}

		// [Dest] 先下原本就有的條件
		$r_condition = G::dbt($dest_conditions, '$bbb');
		if($r_condition != ''){
			eval($r_condition);
		}

		// [Dest] 原本的下完了之後，在下額外的條件
		$dest_other = array(
			array(
				'where',
				$sort_field.'=:id',
				array(
					':id'=>$new_sort_id,
				),
			),
		);
		$r_condition = G::dbt($dest_other, '$bbb');
		if($r_condition != ''){
			eval($r_condition);
		}

		//if($condition_string != ''){
		//	$dest_other = array(
		//		array(
		//			'where',
		//			$condition_string,
		//			array(
		//			),
		//		),
		//	);
		//	$r_condition = G::dbt($dest_other, '$bbb');
		//	if($r_condition != ''){
		//		eval($r_condition);
		//	}
		//}

		//if($condition_string != ''){
		//	$bbb->where($condition_string);
		//}

		$dest_row = $bbb->queryRow();
		if($dest_row === false){
			$this->_msg = 'fetch dest row is empty';
			return;
		}

		// 交換雙方的排序編號(這是舊的方式)
		//$this->db->where('id', $source_row['id']);
		//$this->db->update($this->_table_name, array('sort_id' => $dest_row['sort_id']));
		//$this->db->where('id', $dest_row['id']);
		//$this->db->update($this->_table_name, array('sort_id' => $source_row['sort_id']));

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
			$c = $this->db->createCommand();
			$c->select($this->_id_name.' AS id');
			$c->from($table_name);

			// 先找到新位置的新資料編號
			//$update = array(
			//	$sort_field => $new_sort_id,
			//);
			//if(count($conditions) > 0){
			//	foreach($conditions as $k => $v){
			//		$this->db->{$k}($v);
			//	}
			//}
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

			$r_condition = G::dbt($conditions, '$c');
			if($r_condition != ''){
				eval($r_condition);
			}

			if($condition_string != ''){
				$c->andWhere($condition_string);
			}
			//$query = $this->db->select('id')->where($update)->get($table_name);
			//$row = $query->row_array();
			//$c->where($update);
			$c->andWhere($sort_field.'='.$new_sort_id);
			$row = $c->queryRow();

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
			//$this->db->where('id', $field_id);
			//$this->db->update($table_name, $update);
			$this->db->createCommand()->update($table_name, $update, $this->_id_name.'=:id', array(':id'=>$field_id));

			// 把新的換成舊的
			$update = array(
				$sort_field => $old_sort_id,
			);
			//$this->db->where('id', $new_id);
			//$this->db->update($table_name, $update);
			$this->db->createCommand()->update($table_name, $update, $this->_id_name.'=:id', array(':id'=>$new_id));

		} elseif($sort_id_value2 > 1){ // 如果距離大於1(舊的在下面，新的在上面，中間項目要加上1)
			$c = $this->db->createCommand();
			$c->select($this->_id_name.' AS id, '.$sort_field);
			$c->from($this->_table_name);
			$c->order($sort_field);

			//if(count($conditions) > 0){
			//	foreach($conditions as $k => $v){
			//		$this->db->{$k}($v);
			//	}
			//}
			//if(count($conditions) > 0){
			//	foreach($conditions as $k => $v){
			//		//$bbb->{$k}($v);
			//		$c->{$k}($v[0], $v[1]);
			//	}
			//}

			$r_condition = G::dbt($conditions, '$c');
			if($r_condition != ''){
				eval($r_condition);
			}

			if($condition_string != ''){
				$c->andWhere($condition_string);
			}
			$rows = $c->queryAll();
			foreach($rows as $k => $row){
				// 排序區塊內的資料，才需要重新更新sort_id
				if(($row[$sort_field] >= $new_sort_id) and ($row[$sort_field] <= $old_sort_id)){
					/*
					 * 舊位置，先移到新位置，其它資料會做加1的動作
					 */ 
					if($row[$sort_field] == $old_sort_id){
						$update = array(
							$sort_field => $new_sort_id,
						);
						//$this->db->where('id', $row['id']);
						//$this->db->update($this->_table_name, $update);
						$this->db->createCommand()->update($this->_table_name, $update, $this->_id_name.'=:id', array(':id'=>$row['id']));
						continue;
					}
					$update = array(
						$sort_field => $row[$sort_field] + 1,
					);
					//$this->db->where('id', $row['id']);
					//$this->db->update($table_name, $update);
					$this->db->createCommand()->update($table_name, $update, $this->_id_name.'=:id', array(':id'=>$row['id']));
				}
			}
			//$query = $this->db->select('id, '.$sort_field)->order_by($sort_field)->get($this->_table_name);
			//foreach($query->result_array() as $k => $row){
			//	// 排序區塊內的資料，才需要重新更新sort_id
			//	if(($row[$sort_field] >= $new_sort_id) and ($row[$sort_field] <= $old_sort_id)){
			//		/*
			//		 * 舊位置，先移到新位置，其它資料會做加1的動作
			//		 */ 
			//		if($row[$sort_field] == $old_sort_id){
			//			$update = array(
			//				$sort_field => $new_sort_id,
			//			);
			//			//if($conditions != ''){
			//			//	$this->db->where($conditions);
			//			//}
			//			$this->db->where('id', $row['id']);
			//			$this->db->update($this->_table_name, $update);
			//			continue;
			//		}
			//		$update = array(
			//			$sort_field => $row[$sort_field] + 1,
			//		);
			//		$this->db->where('id', $row['id']);
			//		//$this->db->update($this->_table_name, $update);
			//		$this->db->update($table_name, $update);
			//	}
			//}
		} elseif($sort_id_value2 < -1){ // 如果距離大於-1(新的在下面)
			$c = $this->db->createCommand();
			$c->select($this->_id_name.', '.$sort_field);
			$c->from($this->_table_name);
			$c->order($sort_field);

			//if(count($conditions) > 0){
			//	foreach($conditions as $k => $v){
			//		//$bbb->{$k}($v);
			//		$c->{$k}($v[0], $v[1]);
			//	}
			//}
			//if(count($conditions) > 0){
			//	foreach($conditions as $k => $v){
			//		$this->db->{$k}($v);
			//	}
			//}

			$r_condition = G::dbt($conditions, '$c');
			if($r_condition != ''){
				eval($r_condition);
			}

			if($condition_string != ''){
				$c->andWhere($condition_string);
			}
			$rows = $c->queryAll();
			foreach($rows as $k => $row){
				// 排序區塊內的資料，才需要重新更新sort_id
				if(($row[$sort_field] >= $old_sort_id) and ($row[$sort_field] <= $new_sort_id)){
					/*
					 * 舊位置，先移到新位置，其它資料會做減1的動作
					 */ 
					if($row[$sort_field] == $old_sort_id){
						$update = array(
							$sort_field => $new_sort_id,
						);
						//if($addition_conditions != ''){
						//	$this->db->where($addition_conditions);
						//}
						//$this->db->where('id', $row['id']);
						//$this->db->update($this->_table_name, $update);
						$this->db->createCommand()->update($this->_table_name, $update, $this->_id_name.'=:id', array(':id'=>$row['id']));
						continue;
					}
					$update = array(
						$sort_field => $row[$sort_field] - 1,
					);
					//if($addition_conditions != ''){
					//	$this->db->where($addition_conditions);
					//}
					//$this->db->where('id', $row['id']);
					//$this->db->update($table_name, $update);
					$this->db->createCommand()->update($table_name, $update, $this->_id_name.'=:id', array(':id'=>$row['id']));
				}
			}

			//$query = $this->db->select('id, '.$sort_field)->order_by($sort_field)->get($this->_table_name);
			//foreach($query->result_array() as $k => $row){
			//	// 排序區塊內的資料，才需要重新更新sort_id
			//	if(($row[$sort_field] >= $old_sort_id) and ($row[$sort_field] <= $new_sort_id)){
			//		/*
			//		 * 舊位置，先移到新位置，其它資料會做減1的動作
			//		 */ 
			//		if($row[$sort_field] == $old_sort_id){
			//			$update = array(
			//				$sort_field => $new_sort_id,
			//			);
			//			//if($addition_conditions != ''){
			//			//	$this->db->where($addition_conditions);
			//			//}
			//			$this->db->where('id', $row['id']);
			//			$this->db->update($this->_table_name, $update);
			//			continue;
			//		}
			//		$update = array(
			//			$sort_field => $row[$sort_field] - 1,
			//		);
			//		//if($addition_conditions != ''){
			//		//	$this->db->where($addition_conditions);
			//		//}
			//		$this->db->where('id', $row['id']);
			//		//$this->db->update($this->_table_name, $update);
			//		$this->db->update($table_name, $update);
			//	}
			//}
		//} else {
		//	echo '-6';
		//	die;
		}

	} // function go

	protected function _field_check_all($sort_field)
	{
		$aaa = $this->db->createCommand();
		$aaa->select($this->_id_name.', '.$sort_field);
		$aaa->from($this->_table_name);
		$aaa->order($sort_field);

		//$aaa = $this->db->select('id, '.$sort_field)->order_by($sort_field);
		//if(count($this->_conditions) > 0){
		//	foreach($this->_conditions as $k => $v){
		//		$aaa->{$k}($v);
		//	}
		//}

		$r_condition = G::dbt($this->_conditions, '$aaa');
		if($r_condition != ''){
			eval($r_condition);
		}
		if($this->_condition_string != ''){
			$aaa->andWhere($this->_condition_string);
		}
		//$query = $aaa->get($this->_table_name);
		//$all_data = array();
		//foreach($query->result_array() as $row){
		//	$all_data[] = $row;
		//}
		$all_data = $aaa->queryAll();
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

		//if(count($conditions) > 0){
		if(!empty($conditions)){
		   	$this->_conditions = $conditions;
		} else {
			$conditions = $this->_conditions;
		}

		// 2019-10-05 PHP7
		if($conditions === null){
			$conditions = array();
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
		//$aaa = $this->db->select('id, '.$sort_field)->order_by($sort_field);
		//if(count($conditions) > 0){
		//	foreach($conditions as $k => $v){
		//		$aaa->{$k}($v);
		//	}
		//}
		$aaa = $this->db->createCommand();
		$aaa->select($this->_id_name.', '.$sort_field);
		$aaa->from($this->_table_name);
		$aaa->order($sort_field);

		$r_condition = G::dbt($conditions, '$aaa');
		if($r_condition != ''){
			eval($r_condition);
		}

		if($condition_string != ''){
			$aaa->andWhere($condition_string);
		}
		$all_data = $aaa->queryAll();
		//$query = $aaa->get($this->_table_name);

		//$all_data = array();
		//foreach($query->result_array() as $row){
		//	$all_data[] = $row;
		//}
		//if(count($all_data) <= 0 or $all_data === false){
		if(empty($all_data) or $all_data === false){
			$this->_msg = 'db is no data';
			return;
		}

		foreach($all_data as $k => $v){
			$bbb = $this->db->createCommand();

			$param1 = ''; // ex: array('id=:id')
			$param2 = array(); // ex: array(:id => 123)

			// 挑最上面的那一個where來當條件，這是我目前能夠想得到的方式
			// 因為update的where條件，沒有像CI那樣子，可以分行執行的方式
			// 我有想過用 Yii::app()->db->commandBuilder->createUpdateCommand
			// 不過太麻煩了，而且未必能夠執行
			// 這個問題要很小心，請注意★
			//if(count($conditions) > 0){ 
			if(!empty($conditions)){ 
				foreach($conditions as $kk => $vv){
					if(isset($vv[0]) and $vv[0] == 'where' and isset($vv[1])){
						$param1 = $vv[1];
						if(isset($vv[2])){
							$param2 = $vv[2];
						}
						break;
					}
				}
			}

			if($param1 != ''){
				$param1 .= ' and ';
			}
			$param1 .= ' '.$this->_id_name.'='.$v[$this->_id_name].' ';

			//$bbb->update($table_name, array($sort_field => ($k + 1)), 'id=:id', array(':id'=>$field_id));
			$bbb->update($this->_table_name, array($sort_field => ($k + 1)), $param1, $param2);

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
