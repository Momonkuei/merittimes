<?php

// 使用方式，只有insert和update的功能，如果可以，還要寫validate的功能
// 這裡的東西，請不要修改，要改的話，請去layoutV3的母版去改
// rwd_v3/layoutv3/cig/libs.php

/* 
新增
$orm = new gorm($db, $rules);
$orm->data($data);
$orm->name = 'abc';
$status = $orm->validate(); // 回傳true或false
$logs = $orm->message();
$status = $orm->insert(); // 回傳寫入狀態
$id = $db->insert_id();

修改
$orm->data($data);
$orm->find_by_XX($VALUE);
$status = $orm->validate(); // 回傳true或false
$logs = $orm->message();
$status = $orm->update(); // 回傳更新狀態
$count = $db->affected_rows();

$rules = array(
	'table' => 'html',
	'created_field' => 'create_time', 
	'updated_field' => 'update_time',
	'rules' => array(
		array('topic', 'required'),
		//array('start_date', 'date', 'format'=>'yyyy-M-d'),
	),
);
 */
class gorm {

	public $cidb;
	public $table;
	public $rules;
	public $created_field;
	public $updated_field;

	public $data;

	public $message;

	public $update_key;
	public $update_value;

	function __construct($db, $rules)
	{
		$this->cidb = $db;
		$this->rules = $rules['rules'];

		if(isset($rules['created_field']) and $rules['created_field'] != ''){
			$this->created_field = $rules['created_field'];
		}

		if(isset($rules['updated_field']) and $rules['updated_field'] != ''){
			$this->updated_field = $rules['updated_field'];
		}

		$this->table = $rules['table'];

		$this->message = array();
	}

	public function data($data)
	{
		$this->data = $data;

		return $this;
	}

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		return null;
	}

	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

	public function __unset($name)
	{
		unset($this->data[$name]);
	}

	public function __call($name, $arguments)
	{
		if(preg_match('/^find_by_(.*)$/', $name, $matches) and count($arguments) == 1){
			$this->update_key = $matches[1];
			$this->update_value = $arguments[0];
			return $this;
		}

		return false;
	}

	public function message()
	{
		return $this->message;
	}

	public function validate()
	{
		$status = true;

		if($this->rules and count($this->rules) > 0){
			foreach($this->rules as $k => $v){ // 每一個欄位，可以有一個以上的規則
				if(isset($v[0]) and $v[1]){
					$name_tmp = trim($v[0]);
					$type = $v[1];

					// 額外參數，目前還沒有用到
					$param = array(); 
					if(isset($v[2])){
						$param = $v[2];
					}

					// 可能是逗點分隔，例如name, phone, addr
					$names = array();
					if(preg_match('/\,/', $name_tmp)){
						$names = explode(',', $name_tmp);
						if(count($names) > 0){
							foreach($names as $kk => $vv){
								$names[$kk] = trim($vv);
							}
						}
					} else {
						$names[] = $name_tmp;
					}

					if(count($names) > 0){
						foreach($names as $name){
							if(!isset($this->data[$name])){
								$this->message[] = 'validate|'.$name.'|not exists';
								$status = false; break;
							}

							$value = $this->data[$name];
							if($type == 'required'){
								if($value == null){
									$this->message[] = 'validate|'.$name.'|'.$type.'|check fail';
									$status = false; break;
								} elseif($value == ''){
									$this->message[] = 'validate|'.$name.'|'.$type.'|check fail';
									$status = false; break;
								}
							}
						}
					} // count $names > 0

				}
			}
		}

		return $status;
	}

	public function insert()
	{
		$status = false;

		// 檢查欄位是否存在
		$fields = $this->cidb->list_fields($this->table);
		$save = $this->data;
		if($save and count($save) > 0){
			foreach($save as $k => $v){
				if(!in_array($k, $fields)){
					unset($save[$k]);
				}
			}
		}

		if($this->created_field != '' and in_array($this->created_field, $fields) and !isset($save[$this->created_field])){
			$save[$this->created_field] = date('Y-m-d H:i:s');
		}

		$this->cidb->insert($this->table, $save); 
		$id = $this->cidb->insert_id();

		if($id > 0){
			$status = true;
		}
		return $status;
	}

	public function update()
	{
		$status = false;

		// 檢查欄位是否存在
		$fields = $this->cidb->list_fields($this->table);
		$update = $this->data;
		if($update and count($update) > 0){
			foreach($update as $k => $v){
				if(!in_array($k, $fields)){
					unset($update[$k]);
				}
			}
		}

		if($this->updated_field != '' and in_array($this->updated_field, $fields) and !isset($update[$this->updated_field])){
			$update[$this->updated_field] = date('Y-m-d H:i:s');
		}

		$this->cidb->where($this->update_key,$this->update_value)->update($this->table, $update); 
		$count = $this->cidb->affected_rows();

		if($count > 0){
			$status = true;
		}
		return $status;
	}
}
