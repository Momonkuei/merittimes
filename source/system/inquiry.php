<?php

/*
 * 這一段是註解，這個檔案是被include的，然後那邊的上面要配合這一段
 */
if(0){
	$items = array(); // 洽詢的東西，裡面是存放session save的東西

	// 2018-07-19 如果A方案，要使用V1第二版的Datasource方式掛載，請用LayoutV3，將這個掛載放到head_start去運行
	if(isset($_SESSION['save'][str_replace('inquiry','',str_replace('detail','',$this->data['router_method'])).'inquiry'])){
		$items = $_SESSION['save'][str_replace('inquiry','',str_replace('detail','',$this->data['router_method'])).'inquiry'];
	}else{
		// 沒有詢問物件的話就轉跳到有詢問的地方 by lota 2018/6/13
		if(1){
			$redirect_url = str_replace('inquiry','',str_replace('detail','',$this->data['router_method'])).$url_suffix;		
			G::alert_and_redirect(t('無詢問物件，請先加入詢問'), $redirect_url, $this->data);
		} else { // A方案
?>
<script type="text/javascript" m="body_end">
	$(document).ready(function() {
		alert('<?php echo t('無詢問物件，請先加入詢問','tw')?>');
		window.location.href='index_<?php echo $this->data['ml_key']?>.php';
	});
</script>	
	<?php
		}
	}
}

if(!empty($items)){

	// 多個產品線，使用一個詢問車
	// table_ids[table][流水號][id]
	$table_ids = array();

	// 各自有型號
	$table_ids2 = array();

	$router_method2 = str_replace('inquiry','',str_replace('detail','',$this->data['router_method']));

	// 預設產品線的初使化
	if(!isset($table_ids[$router_method2])){
		$table_ids[$router_method2] = array();
	}

	// 先累計ID
	foreach($items as $k => $v){

		if(preg_match('/^(.*)___(.*)___(.*)$/', $k, $matches)){ // model
			if(!isset($table_ids[$matches[1]])){
				$table_ids[$matches[1]] = array();
			}
			$table_ids[$matches[1]][] = $matches[2].'___'.$matches[3];
		} elseif(preg_match('/^(.*)___(.*)$/', $k, $matches)){
			if(!isset($table_ids[$matches[1]])){
				$table_ids[$matches[1]] = array();
			}
			$table_ids[$matches[1]][] = $matches[2];
		} else {
			$table_ids[$router_method2][] = $k;
		}
		// $ids[] = $k;
	}

	foreach($table_ids as $table => $ids){

		if(empty($ids)){
			continue;
		}

		// 預設是通用分項
		$common_is_enable = 1;
		$common_item = 1;

		$rowg = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type'=>'webmenu', ':url'=>$table.'_'.$this->data['ml_key'].'.php', ':ml_key'=>$this->data['ml_key']))->queryRow();
		if($rowg){
			$common_is_enable = $rowg['is_home'];
			$common_item = $rowg['class_ids'];   // 是或不是通用分項
		}

		$ids1 = array(); // 物件編號
		$ids2 = array(); // 型號
		foreach($ids as $k => $v){
			if(preg_match('/^(.*)___(.*)$/', $v, $matches)){ // model
				$ids1[] = $matches[1];
				$ids2[] = $matches[2];
			}
		}

		$rows = array();
		if(!empty($ids1)){
			if($common_is_enable == 1 and $common_item == 1){
				$sql = 'select * from html where type="'.$table.'" and id IN('.implode(',', $ids1).')';
			} else {
				$sql = 'select * from '.$table.' where is_enable=1 and id IN('.implode(',', $ids1).')';
			}
			$rows = $this->cidb->query($sql)->result_array();
		}

		// 檢查機制
		if(empty($rows)){
			continue;
		}

		$rows_tmp = array();
		foreach($rows as $k => $v){
			$rows_tmp[$v['id']] = $v;
		}

		// 在以id所找到的資料在放進去
		foreach($ids1 as $k => $v){

			if(!isset($rows_tmp[$v])){
				continue;
			}
			$row = $rows_tmp[$v];

			$model = 0;
			if(isset($ids2[$k]) and $ids2[$k] > 0){
				$model = $ids2[$k];
			}

			$tmp = array(
				'id' => $row['id'],
				// 'name' => $row['name'],
				'name2' => strip_tags($row['detail']), // 簡述
				'pic' => '_i/assets/upload/'.$table.'/'.$row['pic1'],
				'url1' => $url_prefix.$table.'detail'.$url_suffix.'?id='.$row['id'],
				'url2' => 'save.php?id='.$this->data['router_method'].'&primary_key='.$table.'___'.$row['id'].'___'.$model.'&amount=0', // delete url
				'amount_inquiry_id' => $router_method2.'___'.$row['id'].'___'.$model,
				'amount' => $items[$table.'___'.$row['id'].'___'.$model]['amount'],
				'model' => $model,
			);

			if(isset($row['name'])){
				$tmp['name'] = $row['name'];
			} elseif(isset($row['topic'])){
				$tmp['name'] = $row['topic'];
			}

			$items[$table.'___'.$row['id'].'___'.$model] = $tmp;
		}

	} // table_ids

	// 刪掉數量是零的洽詢商品
	foreach($items as $k => $v){
		if(isset($v['amount']) and $v['amount'] <= 0){
			unset($items[$k]);
		}
	}

}

