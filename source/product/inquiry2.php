<?php

$items = array(); // 洽詢的東西，裡面是存放session save的東西

// 2018-07-19 如果A方案，要使用V1第二版的Datasource方式掛載，請用LayoutV3，將這個掛載放到head_start去運行
if(isset($_SESSION['save'][$this->data['router_method']])){
	$items = $_SESSION['save'][$this->data['router_method']];
}else{
	// 沒有詢問物件的話就轉跳到有詢問的地方 by lota 2018/6/13
	if(1){
		$redirect_url = str_replace('inquiry','',$this->data['router_method']).$url_suffix;		
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

if(count($items) > 0){

	// 多個產品線，使用一個詢問車
	// table_ids[table][流水號][id]
	$table_ids = array();

	$router_method2 = str_replace('inquiry','',$this->data['router_method']);

	// 預設產品線的初使化
	if(!isset($table_ids[$router_method2])){
		$table_ids[$router_method2] = array();
	}

	// 先累計ID
	foreach($items as $k => $v){

		if(preg_match('/^(.*)___(.*)$/', $k, $matches)){
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

		if(count($ids) <= 0){
			continue;
		}

		$sql = 'select * from '.$table.' where id IN('.implode(',', $ids).')';
		$rows = $this->cidb->query($sql)->result_array();
		// $rows = $this->cidb->query('select * from html where type="'.$table.'" and id IN('.implode(',', $ids).')')->result_array();

		// 在以id所找到的資料在放進去
		foreach($rows as $k => $v){
			$tmp = array(
				'id' => $v['id'],
				// 'name' => $v['name'],
				'name2' => strip_tags($v['detail']), // 簡述
				'pic' => '_i/assets/upload/'.$table.'/'.$v['pic1'],
				'url1' => $url_prefix.$table.'detail'.$url_suffix.'?id='.$v['id'],
				'url2' => 'save.php?id='.$this->data['router_method'].'&primary_key='.$table.'___'.$v['id'].'&amount=0',
				'amount_inquiry_id' => $router_method2.'___'.$v['id'],
				'amount' => $items[$table.'___'.$v['id']]['amount'],
			);

			if(isset($v['name'])){
				$tmp['name'] = $v['name'];
			} elseif(isset($v['topic'])){
				$tmp['name'] = $v['topic'];
			}

			$items[$table.'___'.$v['id']] = $tmp;
		}

	} // table_ids

	// 刪掉數量是零的洽詢商品
	foreach($items as $k => $v){
		if(isset($v['amount']) and $v['amount'] <= 0){
			unset($items[$k]);
		}
	}

}

$data[$ID] = $items;
