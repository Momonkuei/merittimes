<?php

/*
 * 2020-06-20
 * 這個檔案供以下程式使用：
 * source/shop/checkout.php
 * source/core/end.php
 */

$view_file = 'v3/breadcrumb';
if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	if($this->data['router_method'] == 'checkout' and isset($_GET['step'])){
		if($_GET['step'] == '1'){
			$data[$layoutv3_struct_map_keyname[$view_file][0]][1] = array('name' => '確認訂單');
		} elseif($_GET['step'] == '2'){
			$data[$layoutv3_struct_map_keyname[$view_file][0]][1] = array('name' => '填寫訂購資料');
		} elseif($_GET['step'] == '3'){
			$data[$layoutv3_struct_map_keyname[$view_file][0]][1] = array('name' => '完成訂購');
		}
	}
}


// include 'source/shop/admin_field_include.php';

$admin_field_router_class = 'shopspec';
$admin_field_section_id = 0;
include 'source/system/admin_field_get.php';

/*
 * 促銷活動 - 滿額折價
 * 
 * 規則一、滿件折抵，不滿件則原價
 * 
 * 例：滿三件300 ， 將購物車相關活動的商品數量做總計，分成 滿三件的一組做計算，沒滿三件的一組做計算
 * 滿件則以300元計算，不滿件的則以原價計算
 * 
 * 規則二、超件按%換算單價金額
 * 例：滿三件300 ，將購物車相關活動的商品數量做總計，如果超過三件，則將全部相關商品的單價變成100元 (300/3)
 *
 * ==========
 *
 * 以上的規則只適用在主題活動，全站活動不套用規則，全站的主題活動只會有一個規則
 *
 * 另外，李哥說，滿額只會檢查一次，但是滿件可能會有一次以上的符合條件
 */

// 計算式可以寫在這裡
if(!isset($_SESSION['save'])) $_SESSION['save'] = array();
if(!isset($_SESSION['save'][$prefix.'_car'])) $_SESSION['save'][$prefix.'_car'] = array();
$car = $_SESSION['save'][$prefix.'_car'];

/* 購物車
 * array(3) {
 *   ["normal_2_327"]=>
 *   array(2) {
 *     ["amount"]=>
 *     int(2)
 *     ["specid"]=>
 *     string(3) "327"
 *   }
 *   ["normal_1_326"]=>
 *   array(2) {
 *     ["amount"]=>
 *     int(1)
 *     ["specid"]=>
 *     string(3) "326"
 *   }
 *   ["ip_2_327"]=>
 *   array(3) {
 *     ["amount"]=>
 *     string(1) "1"
 *     ["specid"]=>
 *     string(3) "327"
 *     ["pid"]=>
 *     string(1) "1"
 *   }
 * }
 */

// 複選分類參考用
$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
$multi_item_tmp = array();
$multi_item = array();
if($rows){
	foreach($rows as $k => $v){
		if($v['class_ids'] == '') continue;
		$ids = explode(',', $v['class_ids']);
		if($ids){
			foreach($ids as $kk => $vv){
				if($vv == '') continue;
				$multi_item_tmp[$vv][$v['id']] = '1';
			}
		}
	}
	if($multi_item_tmp){
		foreach($multi_item_tmp as $k => $v){
			foreach($v as $kk => $vv){
				$multi_item[$k][] = $kk;
			}
		}
	}
}

/*
 * 開始準備整理促銷活動的資料
 */

$promotions = $this->db->createCommand()->from($prefix.'promotion')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($promotions){
	foreach($promotions as $k => $v){
		$v['time'] = strtotime($v['start_time']);
		$v['time2'] = strtotime($v['end_time']);
		if($v['time'] < 0) $v['time'] = 0;
		if($v['time2'] < 0) $v['time2'] = 0;

		//  先檢查時間
		// if($v['time'] > 0){ //不需要判斷啟始時間 by lota fix 2020-11-16
			$now = strtotime(date('Y-m-d H:i:s'));
			//echo date('Y-m-d H:i:s');
			//echo $now;
			if($now >= $v['time']){
				// OK
			} else {
				unset($promotions[$k]);
				continue;
			}
			if($v['time2'] > 0){
				if($now < $v['time2']){
					// OK
				} else {
					unset($promotions[$k]);
					continue;
				}
			}
		// }

		$ids_tmp = array();
		$ids = array();

		// 2020-11-05 依照所勾選的分類，把產品給抓進來
		if($v['class_ids'] != '' and $v['scope'] == '0'){
			// 一般分類 (購物產品，己經在2017-03-24把單分類完全拿掉)
			// $rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and class_id IN (:ids)',array(':ids'=>$v['class_ids'],':ml_key'=>$this->data['ml_key']))->queryAll();
			// if($rows){
			// 	foreach($rows as $kk => $vv){
			// 		$ids_tmp[$vv['id']] = '1';
			// 	}
			// }

			// 複選分類
			$tmps = explode(',', $v['class_ids']);
			foreach($tmps as $kk => $vv){
				if(isset($multi_item[$vv]) and !empty($multi_item[$vv])){
					foreach($multi_item[$vv] as $kkk => $vvv){
						$ids_tmp[$vvv] = '1';
					}
				}
			}
		}

		// 2020-11-05 依照所選擇的產品抓進來，跟上面的東西併在一起
		if($v['scope'] == '1'){
			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$prefix.'promotionrelatedids',':ml_key'=>$this->data['ml_key'],':id'=>$v['id']))->queryAll();
			if($rows){
				foreach($rows as $kk => $vv){
					$ids_tmp[$vv['other1']] = '1';
				}
			}
		}

		// 套用全部
		if($v['scope'] == '2'){
			$rows = $this->db->createCommand()->from($prefix.'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
			if($rows and !empty($rows)){
				foreach($rows as $kk => $vv){
					if(isset($multi_item[$vv['id']]) and !empty($multi_item[$vv['id']])){
						foreach($multi_item[$vv['id']] as $kkk => $vvv){
							$ids_tmp[$vvv] = '1';
						}
					}
				}
			}
		}

		// 把分類和商品merge好的東西放在另一個陣列元素
		if(!empty($ids_tmp)){
			foreach($ids_tmp as $kk => $vv){
				$ids[] = $kk;
			}
		}

		// 如果促銷方案沒有選擇任何的產品和分類，代表所有產品都能夠使用
		// 所以這裡會把所有產品納進來
		//$_count = $ids;
		//if(!$ids or $_count <= 0){
		//	$ids = array();
		//	$rows = $this->db->createCommand()->select('id')->from($prefix)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
		//	if($rows){
		//		foreach($rows as $kk => $vv){
		//			$ids[] = $vv['id'];
		//		}
		//	}
		//}

		$v['ids'] = $ids; // 只有這些產品能夠符合條件

		$promotions[$k] = $v;
	}
}
//var_dump($promotions);die;

// 重新排序(小李2017-01-26早上9點33分說的，或者是#18231)
// 本來購物車裡面的東西的順序是使用者加入購物車的順序
// 為了計算促銷活動商家的利益

//var_dump($car);die;

if($car and !empty($car)){
	// 先抓出所有產品
	$item_ids_tmp = array();
	foreach($car as $k => $v){
		if(!preg_match('/^(normal|ip|ap||promo)_(\d+)_(\d+)$/', $k, $matches)) continue;
		$item_id = $matches[2];
		$item_ids_tmp[$item_id] = '1';
	}
	$item_ids = array();
	if($item_ids_tmp and !empty($item_ids_tmp)){
		foreach($item_ids_tmp as $k => $v){
			$item_ids[] = $k;
		}
	}

	//$items = $this->db->createCommand()->from($prefix)->where('id IN (:ids) and is_enable=1 and ml_key=:ml_key', array(':ids'=>implode(',', $item_ids),':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
	$sql = 'SELECT * FROM '.$prefix.' WHERE id IN ('.implode(',', $item_ids).') AND is_enable=1 AND ml_key="'.$this->data['ml_key'].'"';
	$items = $this->db->createCommand($sql)->queryAll();
	$items_tmp = array();
	if($items and !empty($items)){
		foreach($items as $k => $v){
			$items_tmp[$v['id']] = $v;
		}
	}

	// 為了要把規格的價格帶入
	$sql = 'SELECT * FROM shopspec WHERE data_id IN ('.implode(',', $item_ids).') AND is_enable=1';
	$specs = $this->cidb->query($sql)->result_array();
	$specs_tmp = array();
	if($specs and !empty($specs)){
		foreach($specs as $k => $v){
			$specs_tmp[$v['id']] = $v;
		}
	}
	//var_dump($specs_tmp);die;

	// 先依照價格排序
	$car_tmp = array();
	foreach($car as $k => $v){
		if(!preg_match('/^(normal|ip|ap||promo)_(\d+)_(\d+)$/', $k, $matches)) continue;

		$item_id = $matches[2];
		$specid = $v['specid'];

		// 先確定購物車裡面的東西，是產品有的東西
		if(!isset($items_tmp[$item_id])){
			unset($car[$k]);
			continue;
		}

		$from = $matches[1];
		$item = $items_tmp[$item_id];

		// 為了要把規格的價格帶入
		if(isset($specs_tmp[$specid]['price'])){
			$item['price'] = $specs_tmp[$specid]['price'];
		}else{
			$item['price'] = '0';
		}
		if(isset($specs_tmp[$specid]['price2'])){
			$item['price2'] = $specs_tmp[$specid]['price2'];
		}else{
			$item['price2'] = '0';
		}
		

		// 暫存，下一個處理區塊會把這些暫存變數往上提升一個層級
		$item['from'] = $from;

		// 記得這裡的價格，要和下面運算的價格同步，因為這一段是從下面複製上來的
		if(preg_match('/^(normal|ap||promo)$/', $from)){
			// if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
			// }

			$item['price'] = $item['price2'];
		} elseif(preg_match('/^(ip)$/', $from)){
			$item['price'] = $item['price3'];
		}

		foreach(array('price','price2') as $_price){
			$item[$_price.'_format'] = number_format($item[$_price]);
			$item[$_price.'_format_ds'] = '$'.$item[$_price.'_format'];
			$item[$_price.'_format_ds_nt'] = 'NT'.$item[$_price.'_format_ds'];
		}

		// 這裡是source/core/end.php在使用的
		$item['url1'] = $item['url2'] = $url_prefix.'shopdetail'.$url_suffix.'?id='.$item_id;
		$item['pic'] = '_i/assets/upload/shop/'.$item['pic1'];

		$car_tmp[$k] = $item['price'];

		$items_tmp[$item_id] = $item;
	}

	if($car_tmp and !empty($car_tmp)){
		// 依照價格排序
		asort($car_tmp);
		$car2 = $car;
		$car = array();
		foreach($car_tmp as $k => $v){
			$car[$k] = $car2[$k];
		}
		unset($car2);
		//var_dump($car_tmp);die;

		foreach($car as $k => $v){
			if(!preg_match('/^(normal|ip|ap||promo)_(\d+)_(\d+)$/', $k, $matches)) continue;

			$v['item'] = $items_tmp[$matches[2]];

			// 2020-05-27 事後在把價格補進來
			$v['item']['price'] = $car_tmp[$k];

			// dirty hack 為了讓改動的範圍小，所以事後在把價格補進來
			//$v['item']['price'] = $v['price'];
			//$v['item']['price2'] = $v['price2'];

			$v['item_id'] = $v['item']['id'];
			$v['from'] = $v['item']['from'];
			$car[$k] = $v;
		}
		//var_dump($car);die;
	}

} // 重新排序購物車裡面的價格 

// 整理一下，做一些促銷活動的捷徑，為了後續好寫
$match = array();
if($promotions and !empty($promotions)){
	foreach($promotions as $k => $v){
		$match[$v['id']] = array();
		if($car and !empty($car)){
			foreach($car as $kk => $vv){
				if(in_array($vv['item_id'], $v['ids'])){
					// 為產品標示所屬的活動(source/core/end.php在使用的)
					$vv['promotion_id'] = $v['id']; 
					$vv['item']['promotion'] = $v;
					$vv['item']['url3'] = $url_prefix.'shop'.$url_suffix.'?id=s'.$v['id'];
					$vv['item']['promotion_name'] = $v['name'];

					// 所屬的條件(結帳頁在使用的)
					$vv['promotion_condition_1'] = $v['condition1']; // 1是滿額、2是滿件
					$vv['promotion_condition_2'] = $v['condition2'];

					$car[$kk] = $vv;
				}
			}
		}
	}
}
//var_dump($car);die;

// 要拿來用在計算運費的總金額，例如我買了2000元的東西，那這裡就是2仟
$shipping_total_target = 0;
$shipping_total = 0; // 最後要給的運費，例如200元
$has_low_temperature = false; // 是否有低溫運費
$total = 0;
$bonus_can_use = 0;
$bonus_total = 0;
$calculate_logs = array(); // 運算表

// 還差多少的文字描述，這裡是多筆哦
$how_much_difference = array();

// 簡易的總計，這個是source/core/end.php在使用的
$total_sub = 0;

// 先把一些雜事先處理好
if($car and !empty($car)){
	foreach($car as $k => $v){

		$item = $v['item'];

		// 這裡是source/core/end.php在使用的
		if(!isset($item['promotion'])){
			$item['promotion'] = array();
		}
		if(!isset($item['url3'])){
			$item['url3'] = 'javascript:;';
		}
		if(!isset($item['promotion_name'])){
			$item['promotion_name'] = '';
		}

		// checkout/step1裡面的訂單修改規格的那邊在使用的
		$item['url'] = $url_prefix.$prefix.'detail'.$url_suffix.'?id='.$item['id'];

		// 低溫運費
		if($item['is_low_temperature'] == '1'){
			$has_low_temperature = true;
		}

		// 先把滿額的東西先整理一下
		if(isset($v['promotion_id'])){
			if($v['promotion_condition_1'] == '1'){ // 滿額
				$match[$v['promotion_id']]['condition'] = '1';
				if(!isset($match[$v['promotion_id']]['total'])) $match[$v['promotion_id']]['total'] = 0;
				$match[$v['promotion_id']]['total'] += $item['price'] * $v['amount'];
			}
		}

		$total_sub += $item['price'] * $v['amount'];

		$specid = $v['specid'];
		// 這一段是從收藏那邊複製來的(source/favorite/list.php)
		// 然後有小改一下，但不是改邏輯，而是改多筆(foreach kk vv)
		// $item['specs'] = array();
		if($specid > 0){

			// 檢查庫存
			//$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and specid=:specid', array(':id'=>$item['id'],':specid'=>$specid))->queryRow();
			$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and data_id=:id and id=:specid', array(':id'=>$item['id'],':specid'=>$specid))->queryRow();
			$v['inventory'] = $row['inventory'];
			$v['spec'] = $row['spec'];
			if($row['inventory'] <= 0){
				$v['inventory'] = 0;
			}

			$search_data = array(
				':type' => $prefix.'spec',
				':ml_key' => $this->data['ml_key'],
				':id' => $specid,
			);
			$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',$search_data)->queryRow();
			// $attrs_tmp = array();
			//var_dump($row_tmp);die;
			if($row_tmp and isset($row_tmp['id'])){
				$tmps = array();
				$vv = $row_tmp;
				for($x=0;$x<=3;$x++){
					if($vv['other'.($x+1)] != ''){
						$tmp = array(
							'name' => $admin_field['other'.($x+1)]['other']['html_end'],
							'value' => $vv['other'.($x+1)],
							//'pic' => '_i/assets/upload/'.$prefix.'spec/'.$vv['pic1'],
						);

						// 這邊就看需求，這裡預設第一個規格屬性才有圖片
						// 也可以改成只有圖片沒有規格屬性
						if($x == 0){
							$tmp['pic'] = '_i/assets/upload/'.$prefix.'spec/'.$vv['pic1'];
						}
						$tmps[] = $tmp;
					}
				}


				// 請手動透過更換spec檔案名稱來達成
				if($tmps and !empty($tmps)){
					foreach($tmps as $kk => $vv){
						$v['specs'][$kk] = $vv;
						//$data[$layoutv3_struct_map_keyname['v3/shop/spec'.($k+1)][0]] = $vv;
					}
				}
			} // atrs_tmp
		}

		$v['item'] = $item;
		$car[$k] = $v;
	}
} else {
	if(isset($error_logs)){
		$error_logs[] = array(
			'car_is_empty',
			'購物車是空的，請先購買東西',
			1, // 第幾步驟
		);
	}
}

/*
 * 把滿額和滿件分開算
 * 因為滿額只會符合一次，但滿件可能會符合很多次
 */

/*
 * 滿額的計算
 */

if($promotions and !empty($promotions)){
	foreach($promotions as $k => $v){
		if($v['condition1'] != '1' and $v['condition2'] >= 1) continue; // 這裡只計算滿額，不是滿額的走開

		$match[$v['id']]['promotion'] = $v;

		if(isset($match[$v['id']]['total']) and $match[$v['id']]['total'] >= $v['condition2']){
			$match[$v['id']]['match'] = true;
		} else {
			$match[$v['id']]['match'] = false;
		}
	}
}

// 把沒有符合任何促銷活動的給刪掉
if($promotions and !empty($promotions)){
	foreach($promotions as $k => $v){
		$_count = count($match[$v['id']]);
		if(isset($match[$v['id']]) and $_count == 0){
			unset($match[$v['id']]);
		}
	}
}

//var_dump($match);die;

// 直接在未計算的頁面顯示符合條件或是未符合(如果是滿件，還要儲存是多少數量符合條件、多少數量不符合，可能是因為不夠)
if($promotions and !empty($promotions)){
	foreach($promotions as $k => $v){
		if($v['condition1'] != '1' and $v['condition2'] >= 1) continue; // 這裡只計算滿額，不是滿額的走開

		if($match[$v['id']]['match'] === false){
			if($car and !empty($car) > 0){
				foreach($car as $kk => $vv){
					if(isset($vv['promotion_id']) && $vv['promotion_id'] == $v['id']){
						$car[$kk]['item']['promotion_name'] .= ' (未符合)'; // 浮起來的右側選單，和結帳頁第一步驟，都會用到
					}
				}
			}
		}
	}
}

/*
 * 滿件的計算
 */
//var_dump($match);die;
$tmp = array(); // 第一個存promotion_id，數值為流水號，從0開始
if($car and !empty($car)){
	foreach($car as $k => $v){
		if(isset($v['promotion_condition_1']) and $v['promotion_condition_1'] != '2' and $v['promotion_condition_2'] >= 1) continue; // 這裡只處理有效的滿件哦

		if(!isset($v['promotion_id'])) continue;
		$match[$v['promotion_id']]['condition'] = '2';
		$match[$v['promotion_id']]['promotion'] = $v['item']['promotion'];
		//var_dump($match);

		if(!isset($match[$v['promotion_id']]['handle_1'])) $match[$v['promotion_id']]['handle_1'] = array();
		if(!isset($tmp[$v['promotion_id']])) $tmp[$v['promotion_id']] = 0;

		for($x=1;$x<=$v['amount'];$x++){
			$_count = 0;
			if(isset($match[$v['promotion_id']]['handle_1'][$tmp[$v['promotion_id']]])){
				$_count = count($match[$v['promotion_id']]['handle_1'][$tmp[$v['promotion_id']]]);
			}
			if(isset($match[$v['promotion_id']]['handle_1'][$tmp[$v['promotion_id']]]) and $_count < $v['promotion_condition_2']){
				// do nothing
			} else {
				$tmp[$v['promotion_id']]++;
			}
			$match[$v['promotion_id']]['handle_1'][$tmp[$v['promotion_id']]][] = $k;
		}
	}
}

// 把沒有符合任何促銷活動給在次刪掉
if($promotions and !empty($promotions)){
	foreach($promotions as $k => $v){		
		//if(isset($match[$v['id']]) and $_count == 0){ // 2020/11/09 lota fix
		if(isset($match[$v['id']])){
			$_count = count($match[$v['id']]);
			if($_count == 0){
				unset($match[$v['id']]);
			}
		}
	}
}

// var_dump($match);die;

// 這個是source/core/end.php在使用的
$calculate_logs[] = array(
	'合計', '$'.number_format($total_sub),
);

//var_dump($car);die;

