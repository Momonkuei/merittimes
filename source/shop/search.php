<?php

//var_dump($rows);die;
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		//$v['url1'] = $v['url2'] = $v['url'];
		$v['url'] = $v['url1'] = $v['url2'] = 'shopdetail_'.$this->data['ml_key'].'.php?id='.$v['id'];

		$v['pic'] = '_i/assets/upload/shop/'.$v['pic1'];

		// 其實這裡應該是，後台要在新增另外一個欄位，只是懶的新增，所以先註解起來
		//$db->row['name2'] = $db->row['detail'];

		//$db->row['name2'] = $db->row['name'];
		//$db->row['name'] = $tmp['name'];

		$v['img_alt'] = $v['name']; // SEO

		$v['price'] = 0;
		$v['price2'] = 0;
		$rowg = $this->cidb->where('is_enable',1)->where('data_id',$v['id'])->get('shopspec')->row_array();
		if($rowg and isset($rowg['id'])){
			$v['price'] = $rowg['price'];
			$v['price2'] = $rowg['price2'];

			//先查詢該產品是否有主題活動, 使用$_ids參照，符合的話就撈主題活動資料
			$_action2 = $_action1 = 0;
			if(isset($_ids) and !empty($_ids)){
				foreach ($_ids as $key => $value) {
					if(in_array($v['id'], $value)){
						$vg = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$key))->queryRow();
						if($vg['condition1']=='2' && $vg['condition2']=='1'){
							// var_dump($v);die;
							$_action1 = $v['action1'];
							$_action2 = $v['action2'];
						}
						break;//有找到就跳出去
					}
				}
			}

			//列表顯示特定主題活動的折扣 
			if(isset($_action1) && isset($_action2)){ 
				if($_action1=='1'){ //打折
					eval('$v[\'price2\'] = round2($v[\'price2\'] * 0.' . $_action2 . ',0);');		
				}
				if($_action1=='2'){ //定額
					$v['price2'] = $_action2;
				}
				if($_action1=='3'){ //折抵
					$v['price2'] = $rowg['price2'] - $_action2;
					if($v['price2'] < 0){
						$v['price2'] = 0;
					}
				}
			}

		}

		foreach(array('price','price2') as $_price){
			$v[$_price.'_format'] = number_format($v[$_price]);
			$v[$_price.'_format_ds'] = '$'.$v[$_price.'_format'];
			$v[$_price.'_format_ds_nt'] = 'NT'.$v[$_price.'_format_ds'];
		}

		// 檢查收藏
		$v['has_favorite'] = 0;
		if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
			$row = $this->db->createCommand()->from('html')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$v['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
			if(isset($row['id']) and $row['id'] > 0){
				$v['has_favorite'] = 1;
			}
		} else {
			// if(isset($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite']) and !empty($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'])){
			// 	foreach($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'] as $k => $v){
			// 		if(preg_match('/^'.$v['id'].'_(\d+)$/', $k)){
			// 			$vrow['has_favorite'] = 1;
			// 			break;
			// 		}
			// 	}
			// }
			if(isset($_SESSION['save']['shop_favorite']) and !empty($_SESSION['save']['shop_favorite'])){
				foreach($_SESSION['save']['shop_favorite'] as $kkg => $vvg){
					if(preg_match('/^'.$v['id'].'_(\d+)$/', $kkg)){
						$v['has_favorite'] = 1;
						break;
					}
				}
			}
		}

		$rows[$k] = $v;
	}
}

// 這裡是從source/favorite/list.php複製過來的
$items2 = $rows;

// 目前有跟source/favorite/list.php和首頁的共用
include 'source/shop/spec_float_include.php';

$rows = $items2;
unset($items2);
