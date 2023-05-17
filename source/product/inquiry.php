<?php

//var_dump($DATA_SINGLE);
//var_dump($DATA_MULTI);
//var_dump($DATA_SINGLE_MULTI);

if($DATA_SINGLE == true and $DATA_MULTI == false){
	
	// 目前沒有

} elseif($DATA_SINGLE == false and $DATA_MULTI == true){
	
	// 目前沒有

} elseif($DATA_SINGLE == true and $DATA_MULTI == true){

	// 多筆、單筆
	// if(count($DATA_SINGLE_MULTI) == 2 and $DATA_SINGLE_MULTI[0] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[1] == 'DATA_SINGLE'){

	$layoutv3_condition = 'multi|single';
	include _BASEPATH.'/../layoutv3/multi_source_check.php';
	if($layoutv3_condition === true){

		// $session = Yii::app()->session['save'][$this->data['router_method']];

		//$_SESSION[$prefix][$key][$primary_key]['amount'] = $row['amount'];

		if(isset($_SESSION['save'][$this->data['router_method']])){
			$data[$ID.'_0'] = $_SESSION['save'][$this->data['router_method']];
		} else {
			$data[$ID.'_0'] = array();
		}

		if(count($data[$ID.'_0']) > 0){

			// 多個產品線，使用一個詢問車
			// table_ids[table][流水號][id]
			$table_ids = array();

			$router_method = str_replace('inquiry','',$this->data['router_method']);

			// 預設產品線的初使化
			if(!isset($table_ids[$router_method])){
				$table_ids[$router_method] = array();
			}

			// var_dump($data[$ID.'_0']);die;

			// 先累計ID
			foreach($data[$ID.'_0'] as $k => $v){

				if(preg_match('/^(.*)___(.*)$/', $k, $matches)){
					if(!isset($table_ids[$matches[1]])){
						$table_ids[$matches[1]] = array();
					}
					$table_ids[$matches[1]][] = $matches[2];
				} else {
					$table_ids[$router_method][] = $k;
				}
				// $ids[] = $k;
			}

			// var_dump($data[$ID.'_0']);die;
			// var_dump($table_ids);die;

			foreach($table_ids as $table => $ids){

				if(count($ids) <= 0){
					continue;
				}
				$rows = $this->db->createCommand('select * from '.$table.' where id IN('.implode(',', $ids).')')->queryAll();

				// 在以id所找到的資料在放進去
				foreach($rows as $k => $v){
					$tmp = array(
						'id' => $v['id'],
						'name' => $v['name'],
						'name2' => strip_tags($v['detail']), // 簡述
						'pic' => '_i/assets/upload/'.$table.'/'.$v['pic1'],
						'url1' => $url_prefix.$table.'detail'.$url_suffix.'?id='.$v['id'],
						'url2' => 'save.php?id='.$this->data['router_method'].'&primary_key='.$table.'___'.$v['id'].'&amount=0',
						'amount' => $data[$ID.'_0'][$table.'___'.$v['id']]['amount'],
					);
					$data[$ID.'_0'][$table.'___'.$v['id']] = $tmp;
				}

			} // table_ids

			// 刪掉數量是零的洽詢商品
			foreach($data[$ID.'_0'] as $k => $v){
				if(isset($v['amount']) and $v['amount'] <= 0){
					unset($data[$ID.'_0'][$k]);
				}
			}

		}

		// var_dump($data[$ID.'_0']);die;

		if(isset($_SESSION['save'][$ID.'_1'])){
			$data[$ID.'_1'] = $_SESSION['save'][$ID.'_1'];
		} else {
			$data[$ID.'_1'] = array();
		}

	}

}
