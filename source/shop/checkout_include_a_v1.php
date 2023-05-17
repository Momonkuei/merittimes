<?php

/*
 * 這個是舊版本的，供參考而以
 */

$view_file = LAYOUTV3_THEME_NAME.'/breadcrumb';
if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	$data[$layoutv3_struct_map_keyname[$view_file][0]][1] = array('name' => '確認訂單');
}


// 計算式可以寫在這裡
if(!isset($_SESSION['save'])) $_SESSION['save'] = array();
if(!isset($_SESSION['save'][$prefix.'_car'])) $_SESSION['save'][$prefix.'_car'] = array();
$car = $_SESSION['save'][$prefix.'_car'];

// var_dump($car);
// die;

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

// 加購產品
// $rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and is_additional_purchase=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
// if($rows){
// 	foreach($rows as $k => $v){
// 	}
// }

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
		if($v['time'] > 0){
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
		}

		$ids_tmp = array();
		$ids = array();

		// 把產品和分類，用產品的編號抓進來
		if($v['class_ids'] != ''){
			// 一般分類
			$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and class_id IN (:ids)',array(':ids'=>$v['class_ids'],':ml_key'=>$this->data['ml_key']))->queryAll();
			if($rows){
				foreach($rows as $kk => $vv){
					$ids_tmp[$vv['id']] = '1';
				}
			}

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

		// 
		$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$prefix.'promotion'.'relatedids',':ml_key'=>$this->data['ml_key'],':id'=>$v['id']))->queryAll();
		if($rows){
			foreach($rows as $kk => $vv){
				$ids_tmp[$vv['other1']] = '1';
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
		$_count = count($ids);
		if(!$ids or $_count <= 0){
			$ids = array();
			$rows = $this->db->createCommand()->select('id')->from($prefix)->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
			if($rows){
				foreach($rows as $kk => $vv){
					$ids[] = $vv['id'];
				}
			}
		}

		$v['ids'] = $ids; // 只有這些產品能夠符合條件

		$promotions[$k] = $v;
	}
}
//var_dump($promotions);die;

// 重新排序(小李2017-01-26早上9點33分說的，或者是#18231)
// 本來購物車裡面的東西的順序是使用者加入購物車的順序
// 為了計算促銷活動商家的利益

//var_dump($car);die;
//if($car and count($car) > 0){
//	$car_tmp = array();
//	foreach($car as $k => $v){
//		$car_tmp[$k] = 
//	}
//}

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

	// 先依照價格排序
	$car_tmp = array();
	foreach($car as $k => $v){
		if(!preg_match('/^(normal|ip|ap||promo)_(\d+)_(\d+)$/', $k, $matches)) continue;

		$item_id = $matches[2];

		// 先確定購物車裡面的東西，是產品有的東西
		if(!isset($items_tmp[$item_id])){
			unset($car[$k]);
			continue;
		}

		$from = $matches[1];
		$item = $items_tmp[$item_id];

		// 記得這裡的價格，要和下面運算的價格同步，因為這一段是從下面複製上來的
		if(preg_match('/^(normal|ap||promo)$/', $from)){
			if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
				$item['price'] = $item['price2'];
			}
		} elseif(preg_match('/^(ip)$/', $from)){
			$item['price'] = $item['price3'];
		}

		$car_tmp[$k] = $item['price'];
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
	}

	// 要拿來用在計算運費的總金額，例如我買了2000元的東西，那這裡就是2仟
	$shipping_total_target = 0;
	$shipping_total = 0; // 最後要給的運費，例如200元
	$has_freezer = false; // 是否有冷凍運費
	$has_refrigerate = false; // 是否有冷藏運費
	$total = 0;
	$bonus_total = 0;
	$calculate_logs = array(); // 運算表
	$error_logs = array();

	// 還差多少的文字描述，這裡是多筆哦
	$how_much_difference = array();

	// 開始第一次處理
	$total_sub = 0; // 暫時存放，不是重要的變數
	if($car and !empty($car)){
		foreach($car as $k => $v){
			if(!preg_match('/^(normal|ip|ap||promo)_(\d+)_(\d+)$/', $k, $matches)) continue;

			$item_id = $matches[2];

			// 先確定購物車裡面的東西，是產品有的東西
			// if(!isset($items_tmp[$item_id])){
			// 	unset($car[$k]);
			// 	continue;
			// }

			$v['item_id'] = $item_id; // 紅利的運算會用到

			$from = $matches[1];
			$specid = $v['specid'];
			$amount = $v['amount'];

			$v['from'] = $from; // 下面還不會用到，但有可能在客製的時候會用到

			$item = $items_tmp[$item_id];

			// 這裡是source/core/end.php在使用的
			$item['url1'] = $item['url2'] = $url_prefix.'shopdetail'.$url_suffix.'?id='.$item_id;
			$item['pic'] = '_i/assets/upload/shop/'.$item['pic1'];

			// 冷凍運費，只有其中一個商品需要冷凍運費，那就會加收一次性的冷凍運費
			if($item['is_freezer'] == '1'){
				$has_freezer = true;
			} elseif($item['is_freezer'] == '1'){
				$has_refrigerate = true;
			}

			if(preg_match('/^(normal|ap||promo)$/', $from)){
				if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
					$item['price'] = $item['price2'];
				}
			} elseif(preg_match('/^(ip)$/', $from)){
				$item['price'] = $item['price3'];
			}

			$total_sub += $item['price'] * $amount;

			if($promotions and !empty($promotions)){
				foreach($promotions as $kk => $vv){
					$_count = $vv['ids'];
					if($_count <= 0) continue;
					if(preg_match('/(ip)/', $from)) continue;
					if(!in_array($item_id, $vv['ids'])) continue; // 如果促銷活動沒有指定任何商品或分類，那就代表都可以
					if(isset($v['promotion_id'])) continue;

					// 先標示，但是接下來會看它符不符合條件，不符合的話，這個標示也沒有作用
					$v['promotion_id'] = $vv['id'];

					// 這裡是source/core/end.php在使用的
					$item['promotion_id'] = $vv['id'];
					$item['promotion'] = $vv;

					$item['url3'] = $url_prefix.'shop'.$url_suffix.'?id=s'.$vv['id'];
					$item['promotion_name'] = $vv['name'];

					// 然後累計

					// 舊寫法
					if(!isset($vv['cal_amount'])) $vv['cal_amount'] = 0;
					$vv['cal_amount'] += $amount;

					if(!isset($vv['cal_total'])) $vv['cal_total'] = 0;
					$vv['cal_total'] += $item['price'] * $amount;

					$promotions[$kk] = $vv;
				}
			}

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
			$v['item'] = $item;

			$car[$k] = $v;
		} // car foreach
	} // count


	$calculate_logs[] = array(
		'合計', '$'.number_format($total_sub),
	);
} // car
