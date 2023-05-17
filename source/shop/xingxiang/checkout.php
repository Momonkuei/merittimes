<?php


// 一般區塊 - 資料指定 - 範本
$view_file = 'v3/sub_page_title';
if (isset($layoutv3_struct_map_keyname[$view_file][0])) {
	$data[$layoutv3_struct_map_keyname[$view_file][0]] = array('name' => '商品結帳', 'sub_name' => 'SHOPPING CART');
}

// var_dump($_SESSION);die;

$prefix = 'shop';
$error_logs = array();

//2017/6/27 將運費做資料庫連結處理(lota)
$lll = array('normal', 'free', 'price1', 'price2', 'low_temperature', 'islands');
foreach ($lll as $k => $v) {
	if (isset($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']])) {
		$shipment[$v] = (int)($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']]);
	}
}

foreach (array('payment_atm_bank_code', 'payment_atm_account') as $v) {
	if (isset($this->data['sys_configs'][$v . '_' . $this->data['ml_key']]) and $this->data['sys_configs'][$v . '_' . $this->data['ml_key']] != '') {
		$newname = str_replace('payment_', '', $v);
		$this->data['atm_config'][$newname] = $this->data['sys_configs'][$v . '_' . $this->data['ml_key']];
	}
}

// 物流
$physicals = array();
if (isset($physicals_tmp) and !empty($physicals_tmp)) {
	foreach ($physicals_tmp as $k => $v) {

		// 先處理物流原資料
		$physicals[$v['func']] = $v;

		// 再處理資料表運費 2017-06-27 lota
		foreach ($lll as $k1 => $v1) {
			if (!isset($physicals[$v['func']][$v1])) {
				$physicals[$v['func']][$v1] = $shipment[$v1];
			}
		}
	}
}

/*
 * 金流
 */
//var_dump($this->data['sys_configs']);
$payments = array();
if (isset($payments_tmp) and !empty($payments_tmp)) {
	foreach ($payments_tmp as $k => $v) {
		$payments[$v['func']] = $v;
	}
}

/*
 * 把後台 / 網站設定 / 一般設定 / 購物區塊內的設定帶進來
 */

// if(
// 	isset($this->data['sys_configs']['payment_atm_'.$this->data['ml_key']])
// 	and trim($this->data['sys_configs']['payment_atm_'.$this->data['ml_key']]) != ''
// 	and isset($payments['atm'])
// ){
// 	$payments['atm']['description'] = nl2br($this->data['sys_configs']['payment_atm_'.$this->data['ml_key']]);
// }
// 
// if(
// 	isset($this->data['sys_configs']['payment_cash_on_delivery_'.$this->data['ml_key']])
// 	and trim($this->data['sys_configs']['payment_cash_on_delivery_'.$this->data['ml_key']]) != ''
// 	and isset($payments['cash_on_delivery'])
// ){
// 	$payments['cash_on_delivery']['description'] = nl2br($this->data['sys_configs']['payment_cash_on_delivery_'.$this->data['ml_key']]);
// }

foreach (array('atm', 'cash_on_delivery', 'cash_on_delivery_2','ecpay_credit_card') as $v) {
	if (
		isset($this->data['sys_configs']['payment_' . $v . '_' . $this->data['ml_key']])
		and trim($this->data['sys_configs']['payment_' . $v . '_' . $this->data['ml_key']]) != ''
		and isset($payments[$v])
	) {
		$payments[$v]['description'] = nl2br($this->data['sys_configs']['payment_' . $v . '_' . $this->data['ml_key']]);
	}
}

// 覆寫物流的基本運費
foreach (array('ecpay_711_no_payment_for_pickup_normal', 'ecpay_fami_no_payment_for_pickup_normal') as $v) {
	if (
		isset($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']])
		and trim($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']]) != ''
		and isset($physicals[str_replace('_normal', '', $v)])
	) {
		$physicals[str_replace('_normal', '', $v)]['normal'] = nl2br($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']]);
	}
}

foreach (array('home_delivery', 'ecpay_711_no_payment_for_pickup', 'ecpay_fami_no_payment_for_pickup') as $v) {
	if (
		isset($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']])
		and trim($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']]) != ''
		and isset($physicals[$v])
	) {
		$physicals[$v]['description'] = nl2br($this->data['sys_configs']['shipment_' . $v . '_' . $this->data['ml_key']]);
	}
}

if (isset($_SESSION['save']['selecxt_payment']['func'])) {
	// 傳承
	if (isset($payments[$_SESSION['save']['selecxt_payment']['func']])) {
		$payment = $payments[$_SESSION['save']['selecxt_payment']['func']];
	}

	// 當金流選擇貨到付款的時候，就不會出現物流，而且還會取消之前使用者所點選的
	if ($_SESSION['save']['selecxt_payment']['func'] == 'cash_on_delivery') {
		$shipment['func'] = 'cash_on_delivery';

		$physicals = array();
		unset($_SESSION['save']['selecxt_physical']);
	} elseif ($_SESSION['save']['selecxt_payment']['func'] == 'cash_on_delivery_2') {
		$shipment['func'] = 'cash_on_delivery_2';

		// 2020-11-09 李哥下午說要給它出現物流選項
		//$physicals = array();
		//unset($_SESSION['save']['selecxt_physical']);
	} elseif ($_SESSION['save']['selecxt_payment']['func'] == 'atm') {
		$physicals = array();
		unset($_SESSION['save']['selecxt_physical']);
	}
} else {
	// 因為沒有選的關係，直接清空它
	$payment = array();

	$error_logs[] = array(
		'payment_no_select',
		'請先選擇付款方式',
		2, // 第幾步驟
	);
}

if (isset($_SESSION['save']['selecxt_physical']['func'])) {
	// 繼承
	if (isset($physicals[$_SESSION['save']['selecxt_physical']['func']])) {
		// 先針對物流
		foreach ($physicals[$_SESSION['save']['selecxt_physical']['func']] as $k => $v) {
			if (!in_array($k, $lll)) {
				$shipment[$k] = $v;
			}
		}

		// 針對資料表運費 2017-06-27 lota
		foreach ($lll as $k => $v) {
			if (isset($physicals[$_SESSION['save']['selecxt_physical']['func']][$v])) {
				$shipment[$v] = $physicals[$_SESSION['save']['selecxt_physical']['func']][$v];
			}
		}
	}
	// 檢查是不是自己的離島被勾
	if (isset($_SESSION['save']['selecxt_physical']['is_islands']) and $_SESSION['save']['selecxt_physical']['is_islands'] != $_SESSION['save']['selecxt_physical']['func']) {
		unset($_SESSION['save']['selecxt_physical']['is_islands']);
	}

	if (
		preg_match('/^ecpay_(711|fami)_no_payment_for_pickup$/', $_SESSION['save']['selecxt_physical']['func'])
		and (!isset($_SESSION['save']['selecxt_physical']['params']) or empty($_SESSION['save']['selecxt_physical']['params']))
	) {
		$error_logs[] = array(
			'shipment_no_select_store_name',
			'請選擇超商',
			2, // 第幾步驟
		);
	}
} else {
	// if(!empty($physicals_tmp)){
	if (!empty($physicals) and (!isset($_SESSION['save']['selecxt_physical']) and !isset($_SESSION['save']['selecxt_physical']['func']) or $_SESSION['save']['selecxt_physical']['func'] == '')) { // 有物流的情況，就要檢查下列的項目
		// 因為沒有選的關系，直接清空它
		// 這裡會引發問題，暫時先註解起來 by lota say
		//$shipment = array();

		$error_logs[] = array(
			'shipment_no_select',
			'請先選擇運送方式',
			2, // 第幾步驟
		);
	}
}

// 先把規格的session給清掉，這行是從產品內頁複製過來的
unset($_SESSION['save'][$prefix . '_spec']);

/*
 * #18231
 * 促銷活動 - 滿額折價
 *
 * 規則一、滿件折抵，不滿件則原價
 *   例：滿三件300 ， 將購物車相關活動的商品數量做總計，分成 滿三件的一組做計算，沒滿三件的一組做計算
 *   滿件則以300元計算，不滿件的則以原價計算
 *
 * 規則二、超件按%換算單價金額
 *   例：滿三件300 ，將購物車相關活動的商品數量做總計，如果超過三件，則將全部相關商品的單價變成100元 (300/3)
 *
 * ★　以上的規則只適用在主題活動，全站活動不套用規則，全站的主題活動只會有一個規則
 */
$buy_amount_condition = 1; // 規則1，滿件折抵，不滿件則原價

// include 'source/shop/admin_field_include.php';

$admin_field_router_class = $prefix . 'spec';
$admin_field_section_id = 0;
include 'source/system/admin_field_get.php';

$ajax = '';
if (isset($_GET['ajax'])) {
	$step = $ajax = intval($_GET['ajax']);
	$_SESSION[$this->data['router_method']]['step'] = $step;
}

if (isset($_GET['step'])) {
	$step = (int)$_GET['step'];
	if ($step <= 0 or $step > 3) {
		$step = 1;
	}
	$_SESSION[$this->data['router_method']]['step'] = $step;

	// 這裡會導致大問題哦！千萬不要打開
	//header('Location: '.$this->data['router_method'].'_'.$this->data['ml_key'].'.php');
}

// 預設是步驟一
if (!isset($_SESSION[$this->data['router_method']]['step']) or $_SESSION[$this->data['router_method']]['step'] == '') {
	$_SESSION[$this->data['router_method']]['step'] = '1';
}

// 目前有跟source/core/end.php共用
// include 'checkout_include_a_v1.php';
include 'checkout_include_a_v2.php';

$step2_javascript_evals = array(); // 步驟2專用的avascript_evals = array(); // 步驟2專用的

// 接下來處理活動
if ($match and !empty($match)) {
	// @k promotion_id
	foreach ($match as $k => $v) {
		if (isset($v['condition']) && $v['condition'] == '1' and $v['match'] === true) {
			
			$promotion = $v['promotion'];

			if ($promotion['action1'] == '1') { // 折扣(例88)(折)
				eval('$v[\'result\'] = round2($v[\'total\'] * 0.' . $promotion['action2'] . ',0);');

				$result2 = $v['total'] - $v['result'];

			} elseif ($promotion['action1'] == '2') { // 定額(元)
				$v['result'] = $promotion['action2'];

				$result2 = $v['total'] - $v['result'];

			} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota
				$v['result'] = $promotion['action2'];

				$result2 = $v['result'];
			}

			

			$calculate_logs[] = array(
				$promotion['name'], '-' . number_format($result2),
			);

			// 後台沒有 贈送 這個欄位了
			// if ($promotion['free_delivery'] != '') {
			// 	$calculate_logs[] = array(
			// 		'贈送', '└ ' . $promotion['free_delivery'],
			// 	);
			// }

			// 促銷方案中的運費計算
			$total += $v['total'] - $result2;
			if ($promotion['has_free_shipping'] == 1) {
				// 當然，符合條件的話，就不用累加金額到運費計算，但是其它有可能要
				$shipment['normal'] = 0;
			} else {
				// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
				$shipping_total_target += $v['result'];
			}
			$match[$k] = $v;
		} elseif (isset($v['condition']) && $v['condition'] == '2' and isset($v['handle_1']) and !empty($v['handle_1'])) {
			$promotion = $v['promotion'];
			
			// @kk 流水號，從1開始，沒意義
			// @vv 符合的多個產品，以1為單位，1筆就是數量1
			//var_dump($v['handle_1']);
			foreach ($v['handle_1'] as $kk => $vv) {
				$_count = count($vv);
				if ($_count == $promotion['condition2']) { // 符合的情況
					$xx = array();
					$xx['total'] = 0;
					
					// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)ㄅ
					foreach ($vv as $kkk => $vvv) {
						$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
					}

					if ($promotion['action1'] == '1') { // 折扣(例88)(折)
						eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.' . $promotion['action2'] . ',0);');
						$_cal = array($promotion['name'], '-' . number_format($xx['total'] - $xx['result']));
					} elseif ($promotion['action1'] == '2') { // 定額(元)
						$xx['result'] = $promotion['action2'];
						$_cal = array($promotion['name'], '-' . number_format($xx['total'] - $xx['result']));
					} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota
						$xx['result'] = $promotion['action2'];
						$_cal = array($promotion['name'], '-' . number_format($xx['result']));
					}
					$calculate_logs[] = $_cal;

					//if($promotion['action1'] == '1'){ // 折扣(例88)(折)
					//	eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.'.$promotion['action2'].',0);');
					//} elseif($promotion['action1'] == '2'){ // 定額(元)
					//	$xx['result'] = $promotion['action2'];
					//}

					//$calculate_logs[] = array(
					//	$promotion['name'], '-'.number_format($xx['total'] - $xx['result']),
					//);

					// 後台沒有 贈送 這個欄位了
					//if ($promotion['free_delivery'] != '') {
					//	$calculate_logs[] = array(
					//		'贈送', '└ ' . $promotion['free_delivery'],
					//	);
					//}

					// 促銷方案中的運費計算
					$total += $xx['result'];
					if ($promotion['has_free_shipping'] == 1) {
						// 當然，符合條件的話，就不用累加金額到運費計算，但是其它有可能要
					} else {
						// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
						$shipping_total_target += $xx['result'];
					}
					$match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果
				} else { // 不符合的情況
					
					//if(!isset($match[$k]['match_log'])){
					//	$match[$k]['match_log'] = '沒有完全符合';
					//}
					foreach ($car as $kkk => $vvv) {
						if (isset($vvv['item']['promotion']) and !isset($vvv['item']['promotion']['match_log'])) {
							$car[$kkk]['item']['promotion']['match_log'] = '(沒有完全符合)';
						}
					}

					// 不符合條件的話，就要看設定值了
					if ($buy_amount_condition == 1) { // 滿件折抵，不滿件則原價
						// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
						foreach ($vv as $kkk => $vvv) {
							$total += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
							$shipping_total_target += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
						}
					} elseif ($buy_amount_condition == 2) { // 超件按%換算單價金額
						if ($kk > 1) { // 代表不滿數量，一樣照原價
							// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
							foreach ($vv as $kkk => $vvv) {
								$total += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								$shipping_total_target += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
							}
						} else { // 代表超過數量
							if ($promotion['action1'] == '1') { // 折扣(例88)(折)

								// 超過的都是一樣的折扣，假設八折，就把超過但不滿數量的都八折 2017/02/06李哥早上8點45分說的
								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach ($vv as $kkk => $vvv) {
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}

								// 都用同樣的折數
								eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.' . $promotion['action2'] . ',0);');

								$calculate_logs[] = array(
									$promotion['name'], '-' . number_format($xx['total'] - $xx['result']),
								);

								// 促銷方案中的運費計算
								$total += $xx['result'];
								// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
								$shipping_total_target += $xx['result'];
								$match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果
							} elseif ($promotion['action1'] == '2') { // 定額(元)
								eval('$unit = round2($promotion[\'action2\'] / $promotion[\'condition2\']);');
								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach ($vv as $kkk => $vvv) {
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach ($vv as $kkk => $vvv) {
									$xx['result'] += $unit * 1; // 反正1筆就是1個
								}

								$calculate_logs[] = array(
									$promotion['name'], '-' . number_format($xx['total'] - $xx['result']),
								);

								// 促銷方案中的運費計算
								$total += $xx['result'];

								// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
								$shipping_total_target += $xx['result'];
								$match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果
							} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota

								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;


								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach ($vv as $kkk => $vvv) {
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}



								$calculate_logs[] = array(
									$promotion['name'], '-' . number_format($promotion['action2']),
								);

								// 促銷方案中的運費計算
								$total += $xx['result'];
								// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
								$shipping_total_target += $xx['result'];
								$match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果

							}
						}
					}
				}
			}
		}
	}
}
//var_dump($match);die;
//var_dump($total);die;

if ($car and !empty($car)) {
	foreach ($car as $k => $v) {

		// 應該剩下不在活動內的產品還沒有處理

		// if(!preg_match('/^(normal|ip|ap)_(\d+)_(\d+)$/', $k, $matches)) continue;

		$item_id = $v['item']['id'];
		$from = $v['item']['from'];

		//if(!isset($items_tmp[$item_id])) continue;

		// $from = $matches[1];
		// $specid = $matches[3];
		$specid = $v['specid'];
		$amount = $v['amount'];

		//$item = $items_tmp[$item_id];
		$item = $v['item'];

		// if(preg_match('/^(normal|ap)$/', $from)){
		// 	if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
		// 		$item['price'] = $item['price2'];
		// 	}
		// } elseif(preg_match('/^(ip)$/', $from)){
		// 	$item['price'] = $item['price3'];
		// }

		
		//if(!isset($v['promotion_id'])) { // 2020-11-05 這裡疑似有主題活動運費的問題
		if(!isset($v['promotion_id']) or (isset($match[$v['promotion_id']]) and isset($match[$v['promotion_id']]['match']) and $match[$v['promotion_id']]['match'] === false)) {
			$shipping_total_target += $item['price'] * $amount;
			$total += $item['price'] * $amount;
		}
		//$shipping_total_target += $item['price'] * $amount;
		//$total += $item['price'] * $amount;

		// $is_handle_shipping_in_promotion = false;
		// if($promotions){
		// 	foreach($promotions as $kk => $vv){
		// 		if(in_array($item_id, $vv['ids'])){
		// 			if(isset($vv['match']) and $vv['match']){
		// 				$is_handle_shipping_in_promotion = true;
		// 				// 總計，有累加過了，不要在加了哦
		// 				break;
		// 			}
		// 		}
		// 	}
		// }

		// //沒有符合促銷方案的情況
		// if(!$is_handle_shipping_in_promotion){
		// 	$shipping_total_target += $item['price'] * $amount;
		// 	$total += $item['price'] * $amount;
		// }

	}

	// 檢查優惠卷代碼，有填才會檢查
	// $_SESSION['save']['goodies_number']['gift_serial_number'] = '20170120162314jdpjQG';
	if (isset($_SESSION['save']['goodies_number']['gift_serial_number'])) {
		if ($_SESSION['save']['goodies_number']['gift_serial_number'] != '') {
			$gift = $_SESSION['save']['goodies_number']['gift_serial_number'];
			//$row = $this->db->createCommand()->from('shopgoodies')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$item['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();

			// 先看一下生效日期有沒有填
			$row = $this->db->createCommand()->from($prefix . 'goodies')->where('is_enable=1 and pid!=0 and func=1 and gift_only_use_count>0 and gift_serial_number=:gift', array(':gift' => $gift))->queryRow();
			if ($row and isset($row['id'])) {
				$check_member_field = true; // 因為有些優惠卷是綁定會員

				// if($row['member_id'] > 0 and (!isset($this->data['admin_id']) or $this->data['admin_id'] <= 0)){
				// 	$check_member_field = false;

				// 	unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

				// 	$error_logs[] = array(
				// 		'goodies_guest_use_member_gift',
				// 		'無效優惠卷代碼',
				// 		1, // 第幾步驟
				// 	);
				// }

				$check_use_count = true; // 能夠被使用的次數，通常都是一個序號只能用一次
				if ($row['gift_only_use_count2'] >= $row['gift_only_use_count']) {
					$check_use_count = false;

					unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

					$error_logs[] = array(
						'goodies_guest_gift_only_use_count2',
						'無效優惠卷代碼',
						1, // 第幾步驟
					);
				}

				$time = strtotime($row['start_date'] . ' 00:00:00');
				$time2 = strtotime($row['end_date'] . ' 23:59:59');
				if ($time < 0) $time = 0;
				if ($time2 < 0) $time2 = 0;

				//  先檢查時間
				$check_gift_date = true;
				if ($time > 0) {
					$now = strtotime(date('Y-m-d H:i:s'));
					//echo date('Y-m-d H:i:s');
					//echo $now;
					if ($now >= $time) {
						// OK
					} else {
						$check_gift_date = false;
					}
					if ($time2 > 0) {
						//echo $now.'<br />';
						//echo $row['end_date'].$time2.'<br />';
						if ($now <= $time2) {
							// OK
						} else {
							$check_gift_date = false;
						}
					}
				}

				// 檢查限定的商品有沒有符合條件
				$check_gift_limit = false;

				// 這裡是複製上面的
				// if($row['class_ids'] != ''){ // 把產品和分類，用產品的編號抓進來
				// 	// 一般分類
				// 	$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and class_id IN (:ids)',array(':ids'=>$row['class_ids'],':ml_key'=>$this->data['ml_key']))->queryAll();
				// 	if($rows){
				// 		foreach($rows as $kk => $vv){
				// 			$ids_tmp[$vv['id']] = '1';
				// 		}
				// 	}

				// 	// 複選分類
				// 	$tmps = explode(',', $row['class_ids']);
				// 	foreach($tmps as $kk => $vv){
				// 		if(isset($multi_item[$vv]) and !empty($multi_item[$vv])){
				// 			foreach($multi_item[$vv] as $kkk => $vvv){
				// 				$ids_tmp[$vvv] = '1';
				// 			}
				// 		}
				// 	}
				// }

				$ids_tmp = array();
				if ($row['related_ids'] != '') {
					$tmpgs = explode(',', $row['related_ids']);
					if (!empty($tmpgs)) {
						foreach ($tmpgs as $kk => $vv) {
							if ($vv == '') {
								unset($tmpgs[$kk]);
							}
						}
					}
					$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and id IN (' . implode(',', $tmpgs) . ')', array(':ml_key' => $this->data['ml_key']))->queryAll();
					if ($rows) {
						foreach ($rows as $kk => $vv) {
							$ids_tmp[$vv['id']] = '1';
						}
					}
				}

				$ids = array();
				if (!empty($ids_tmp)) {
					foreach ($ids_tmp as $kk => $vv) {
						$ids[] = $kk;
					}
				}

				foreach ($item_ids as $kk => $vv) {
					if (in_array($vv, $ids)) {
						$check_gift_limit = true;
						break;
					}
				}

				if($row['is_all']==1){
					$check_gift_limit = true;
				}

				// 檢查條件
				$check_gift_condition = false;
				if ($row['gift_condition1'] == '1') {
					// 不包含運費的訂單總金額
					if ($row['gift_condition2'] > 0 and $total >= $row['gift_condition2']) {
						$check_gift_condition = true;
					}
				} elseif ($row['gift_condition1'] == '0') {
					$check_gift_condition = true;
				}

				// var_dump($check_member_field);
				// var_dump($check_use_count);
				// var_dump($check_gift_date);
				// var_dump($check_gift_limit);
				// var_dump($check_gift_condition);

				if ($check_member_field === true and $check_use_count === true and $check_gift_date === true and $check_gift_limit === true and $check_gift_condition === true) {
					$total_tmp = $total;
					if ($row['gift_do_type'] == '1') { // 折扣(例88)(折)
						eval('$total = $total * 0.' . $row['gift_do_value'] . ';');
					} elseif ($row['gift_do_type'] == '2') { // 折抵(就是減多少錢)
						$total = $total - $row['gift_do_value'];
						//防呆處理 by lota
						if($total < 0){
							$total = 0;
						}
					}

					$_goodies_value = $total_tmp - $total;

					if(is_numeric($_goodies_value)){
						//運費計算參數處理
						$shipping_total_target = $shipping_total_target - $_goodies_value;
						$calculate_logs[] = array(
							$row['name'], '-' . number_format($_goodies_value),
						);
						$_SESSION['save']['goodies_number']['gift_serial_money']=number_format($_goodies_value);
					}

					
				} else {
					unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

					$goodies_check_error = '';
					foreach (array('check_member_field', 'check_use_count', 'check_gift_date', 'check_gift_limit', 'check_gift_condition') as $goodies_check) {
						eval('if(isset($' . $goodies_check . ') and $' . $goodies_check . '===false) $goodies_check_error.="' . $goodies_check . '|";');
					}

					$error_logs[] = array(
						$goodies_check_error,
						'無效優惠卷代碼',
						1, // 第幾步驟
					);
				}
			} else {
				unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

				$error_logs[] = array(
					'goodies_guest_not_found',
					'無效優惠卷代碼',
					1, // 第幾步驟
				);
			}
		} else {
			unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

			$error_logs[] = array(
				'goodies_guest_is_empty',
				'無效優惠卷代碼',
				1, // 第幾步驟
			);
		}
	} // 優惠卷的檢查和運作

	/*
	 * 基本運費(單一運費)
	 *   基本 $xx
	 *   滿$xx多少免運
	 *
	 * 級距運費
	 *   基本 $xx
	 *   一級 滿$xx；運費$xx元
	 *   二級 滿$xx；免運費
	 *
	 * 冷凍(產品要可以選)
	 *   再加$xx
	 *
	 * 冷藏(產品要可以選)
	 *   再加$xx
	 *
	 * 外島(離島)
	 *   再加$xx
	 */

	/*
	 * $prefix = 'shop';
	 * $shipment = array(
	 * 	'normal' => 100, // 共用
	 * 	'free' => 1000, // 免運費 (基本和級距共用)
	 * 	'price1' => 500, 'price2' => 50, // (級距) 滿一級的多少，運費就是多少
	 *  'low_temperature' => 60, // 低溫
	 * 	'islands' => 70, // 離島
	 * );
	 */

	//var_dump($shipment);die;


	// Kevin 留下足跡 從這邊開始接紅利
	if (!empty($_SESSION['use_bonus']) && $_SESSION['use_bonus'] == 1 && isset($this->data['admin_id']) and $this->data['admin_id'] > 0) { //2020-11-11 多加判斷有無登入會員 by lota
		$sql = $this->pdo->prepare("select SUM(bonus) as bonus from bonus where memberID=:memberID and status=2 group by memberID");
		$sql->execute(array(":memberID" => $this->data['admin_id']));
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		if ($sql->rowCount() == 0) {
			$total_bonus = 0;
			$canuse_bonus = 0;
		} else {
			$Kbonus = $row['bonus'];

			$sql_now = $this->pdo->prepare("select SUM(bonus) as bonus from bonus where memberID=:memberID and status=2 and end_time > :date group by memberID");
			$sql_now->execute(array(":memberID" => $this->data['admin_id'], ":date" => date("Y-m-d H:i:s")));
			$row_now = $sql_now->fetch(PDO::FETCH_ASSOC);
			$Kbonus_now = $row_now['bonus'];

			if ($Kbonus > $Kbonus_now) {
				$total_bonus = $Kbonus_now;
			} else {
				$total_bonus = $Kbonus;
			}
			$orderPrice=0;
		for($x=0;$x<count($calculate_logs);$x++){
			// Notice: Undefined offset: 3
			if(isset($calculate_logs[$x]) && $calculate_logs[$x][0]!='總計' && $calculate_logs[$x][0]!='運費' && $calculate_logs[$x][0]!='紅利' ){
				//Warning: A non-numeric value encountered in
				$orderPrice += intval(str_replace(array("$", ","), "", $calculate_logs[$x][1]));
			}
			
		}
			$order_bonus = floor($orderPrice / 2);
			if ($order_bonus > $total_bonus) {
				$canuse_bonus = $total_bonus;
			} else {
				$canuse_bonus = $order_bonus;
			}
			$want_bonus=isset($_SESSION['want_bonus'])?$_SESSION['want_bonus']:0;
			if($canuse_bonus < $want_bonus){
				$_SESSION['want_bonus']=$canuse_bonus;
				echo '<script>alert("本次訂單最多使用'.$canuse_bonus.'點")</script>';
			}else{
				$canuse_bonus=isset($_SESSION['want_bonus'])?$_SESSION['want_bonus']:0;
			}
		}

		if(is_numeric($canuse_bonus)){
			//運費計算參數處理
			$shipping_total_target = $shipping_total_target - $canuse_bonus;

			$calculate_logs[] = array(
				'紅利', '-' . number_format($canuse_bonus),
			);
		}
			
		

			
	}

	if (!empty($shipment)) { // 有選擇物流，才會做運費計算
		// echo $shipping_total_target;die;
		// $shipping_total_target = $total; //2020-09-17 這邊改用優惠碼折讓完後的金額去比對運費計算 by lota // 2020-11-10 邏輯弄錯方向..取消這段程式
		if ($shipping_total_target >= 0 and $shipping_total_target < $shipment['free']) { //2020-11-10 比較值要加上等於0 by lota
			if ($shipment['price1'] && $shipment['price2']) { // 如果有級距數值，才做相關的運算 by lota
				if ($shipment['price1'] <= 0) { // 單一運費
					$shipping_total += $shipment['normal']; // 單一運費的基本費
				} else { // 級距運費
					if ($shipping_total_target > $shipment['price1']) {
						$shipping_total += $shipment['price2']; // 符合條件的一級運費
					} else {
						$shipping_total += $shipment['normal']; // 級距的基本費
					}
				}
				
			} else {
				$shipping_total += $shipment['normal']; // 單一運費的基本費
			}
		}

		if($shipping_total >= 0){ //2020-11-10 比較值要加上等於0 by lota
			$calculate_logs[] = array(
				'運費', '+' . number_format($shipping_total),
			);
		}



		// 記得這裡要改寫該筆物流的運費
		if (isset($_SESSION['save']['selecxt_physical']['func'])) {
			if (isset($physicals[$_SESSION['save']['selecxt_physical']['func']])) {
				$physicals[$_SESSION['save']['selecxt_physical']['func']]['normal'] = $shipping_total;
			}
		}

		// 低溫運費(一次性的費用)
		if ($has_low_temperature) {
			$calculate_logs[] = array(
				'低溫運費', '$' . number_format($shipment['low_temperature']),
			);

			$shipping_total += $shipment['low_temperature'];
		}


		// 離島的運費，這裡記得要判斷SESSION
		if (isset($_SESSION['save']['selecxt_physical']['is_islands']) and $_SESSION['save']['selecxt_physical']['is_islands'] == $_SESSION['save']['selecxt_physical']['func']) {
			$calculate_logs[] = array(
				'離島運費', '$' . number_format($shipment['islands']),
			);

			$shipping_total += $shipment['islands'];
		}
	}


	// 檢查紅利 Jerry版 
	if (0 and isset($this->data['admin_id']) and $this->data['admin_id'] > 0) {
		// 取得和統計該會員有效的紅利點數
		// 有排序，目的是從舊的紅利開始使用

		// 	bonus_left 就是'紅利點數剩多少', 因為剩多少比較好寫吧
		$bonus_list = $this->db->createCommand()->from($prefix . 'goodies')->where('is_enable=1 and pid!=0 and func=2 and bonus_point>0 and bonus_left>0')->order('create_time')->queryAll();
		if ($bonus_list) {
			foreach ($bonus_list as $k => $v) {
				$v['time'] = strtotime($v['start_date'] . ' 00:00:00');
				$v['time2'] = strtotime($v['end_date'] . ' 00:00:00');
				if ($v['time'] < 0) $v['time'] = 0;
				if ($v['time2'] < 0) $v['time2'] = 0;

				//  先檢查時間
				if ($v['time'] > 0) {
					$now = strtotime(date('Y-m-d H:i:s'));
					//echo date('Y-m-d H:i:s');
					//echo $now;
					if ($now >= $v['time']) {
						// OK
					} else {
						unset($bonus_list[$k]);
						continue;
					}
					if ($v['time2'] > 0) {
						if ($now < $v['time2']) {
							// OK
						} else {
							unset($bonus_list[$k]);
							continue;
						}
					}
				}

				// 總共可用的紅利
				$bonus_total += $v['bonus_left'];

				$ids_tmp = array();
				$ids = array();

				// 把產品和分類，用產品的編號抓進來
				if ($v['class_ids'] != '') {
					// 一般分類
					$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and class_id IN (:ids)', array(':ids' => $v['class_ids'], ':ml_key' => $this->data['ml_key']))->queryAll();
					if ($rows) {
						foreach ($rows as $kk => $vv) {
							$ids_tmp[$vv['id']] = '1';
						}
					}

					// 複選分類
					$tmps = explode(',', $v['class_ids']);
					foreach ($tmps as $kk => $vv) {
						if (isset($multi_item[$vv]) and !empty($multi_item[$vv])) {
							foreach ($multi_item[$vv] as $kkk => $vvv) {
								$ids_tmp[$vvv] = '1';
							}
						}
					}
				}

				//  
				$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type' => $prefix . 'goodies' . 'relatedids', ':ml_key' => $this->data['ml_key'], ':id' => $v['id']))->queryAll();
				if ($rows) {
					foreach ($rows as $kk => $vv) {
						$ids_tmp[$vv['other1']] = '1';
					}
				}

				if (!empty($ids_tmp)) {
					foreach ($ids_tmp as $kk => $vv) {
						$ids[] = $kk;
					}
				}

				// 檢查這次購買的商品清單，能夠使用的紅利
				// 因為有些紅利是限制商品和分類的
				// 但是如果沒有指定商品，那這裡就不用檢查，表示都可以
				if (!empty($car) and !empty($ids)) {
					$check_in_list = true;
					foreach ($car as $k => $v) {
						if (!in_array($v['item_id'], $ids)) {
							$check_in_list = false;
							break;
						}
					}
					if (!$check_in_list) {
						unset($bonus_list[$k]);
						continue;
					}
				}

				// 看一下總額有沒有符合條件
				if ($total < $v['bonus_condition']) {
					unset($bonus_list[$k]);
					continue;
				}

				// 如果有東西，那購買的產品要在裡面，才能使用這個點數
				$v['ids'] = $ids;

				// 把會員每一筆的剩下的紅利總計起來
				$bonus_can_use += $v['bonus_left'];

				$bonus_list[$k] = $v;
			}
		}

		// 紅利預先的計算
		if (isset($_SESSION['save']['use_bonus']['use']) and $_SESSION['save']['use_bonus']['use'] == '1' and $bonus_can_use > 0) {
			$total = $total - $bonus_list[0]['bonus_left'];

			$calculate_logs[] = array(
				$bonus_list[0]['name'], '-' . number_format($bonus_list[0]['bonus_left']),
			);
		}
	} // 會員在本次消費中，可以使用的紅利total的統計和檢查

	// 李哥說註解 2017-02-07
	// if($total <= 0){
	// 	$error_logs[] = array(
	// 		'total_negative_number',
	// 		'訂單金額不能為零',
	// 	);
	// }

	// 最後，當然是加總，看要付多少錢
	$total += $shipping_total;
	if(isset($_SESSION['use_bonus'])&&$_SESSION['use_bonus']==1){
		$total=$total-$canuse_bonus;
	}

	$calculate_logs[] = array(
		'總計', '$' . number_format($total),
	);

	// 2020-11-09 滿件的合併處理
	$tmp1 = array(); // 累計
	$tmp2 = array(); // 暫存結果
	$tmp3 = array(); // 已處理
	foreach($calculate_logs as $k => $v){		
		// if(!preg_match('/(\$|\,)/',$v[1]) and $v[1] < 0){ // fix by lota
		if(!preg_match('/(\$)/',$v[1]) and $v[1] < 0){
			if(!isset($tmp1[$v[0]])){
				$tmp1[$v[0]] = 0;
			}
			$v[1] = str_replace(',','',$v[1]);
			$tmp1[$v[0]] += $v[1];
		}
	}	
	foreach($calculate_logs as $k => $v){
		// if(!preg_match('/(\$|\,)/',$v[1]) and $v[1] < 0){ // fix by lota
		if(!preg_match('/(\$)/',$v[1]) and $v[1] < 0){
			if(!isset($tmp3[$v[0]])){
				$tmp3[$v[0]] = '1';
				$tmp2[] = array(0=>$v[0],1=>$tmp1[$v[0]]);
			}
		} else {
			$tmp2[] = $v;
		}
	}
	$calculate_logs = $tmp2;


	// Debug
	// echo '<meta charset="utf-8">'."\n";
	// var_dump($car);
	// var_dump($promotions);
	// var_dump($shipping_total);
	// var_dump($how_much_difference);
	// var_dump($total);
	// var_dump($calculate_logs);
	// die;

} // car

/*
 * 第一步驟在做的事
 */

// 加購的產品
$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and is_additional_purchase=1 and ml_key=:ml_key', array(':ml_key' => $this->data['ml_key']))->order('RAND()')->queryAll();
if (isset($rows)) {
	foreach ($rows as $k => $v) {
		$v['has_additional_purchase'] = 1;
		include 'source/shop/shop_list_foreach_include.php';
		// 如果同產品(不用同規格)，己有加購過的產品，會做focus的動作，而且只有這裡有做，但是如果是在其它位置買同品項的產品，這裡是不會顯示的
		if ($car and !empty($car)) {
			foreach ($car as $kk => $vv) {
				if ($vv['from'] == 'ap' and $v['id'] == $vv['item']['id']) {
					$v['has_ap_in_car'] = true;
					break;
				}
			}
		}
		$rows[$k] = $v;
	}
}
$additional_purchases = $rows;
unset($rows);
// include 'source/shop/admin_field_include.php';

// 這個有需要嗎？上面己經有了
// $admin_field_router_class = 'shopspec';
// $admin_field_section_id = 0;
// include 'source/include/admin_field_get.php';

// 這裡是從source/favorite/list.php複製過來的
$items2 = $additional_purchases;

// 目前有跟source/favorite/list.php和產品列表頁的共用
include 'source/shop/spec_float_include.php';
//var_dump($items2);die;

/*
 * 處理修改購物車訂單的補助區塊所需要的資料
 */

// 將購物車的資料結構，轉換成產品的資料結構
$items2 = array();
if ($car and !empty($car)) {
	foreach ($car as $k => $v) {
		$tmps = $v['item'];
		$tmps['id_key_name'] = $k;
		unset($v['item']);
		foreach ($v as $kk => $vv) {
			if ($kk == 'specs') {
				$tmps[$kk . '_data'] = $vv;
			} else {
				$tmps[$kk] = $vv;
			}
		}
		$items2[] = $tmps;
	}
}
$spec_float_include_disable_assign = true;
include 'source/shop/spec_float_include.php';
//echo '<meta charset="utf-8">'."\n";
//var_dump($items2);die;
unset($spec_float_include_disable_assign);

/*
 * 第二步驟在做的事
 */

$member = array();
$member_address = false;

if (isset($this->data['admin_id']) and $this->data['admin_id'] > 0) {
} else {
	if (!isset($_SESSION['save']['member_form_1'])) {
		$_SESSION['save']['member_form_1'] = array(
			'login_account' => '',
			'login_password' => '',
			'login_password_confirm' => '',
			'name' => '',
			'gender' => '',
			'birthday' => '',
			'birthday_year' => '', // 記得寫入的時候要刪掉
			'birthday_month' => '', // 記得寫入的時候要刪掉
			'birthday_day' => '', // 記得寫入的時候要刪掉
			'phone' => '',
			'addr' => '',
			'addr_county' => '',
			'addr_district' => '',
			'addr_zipcode' => '',
			'need_dm' => 0,
			'accept_privacy' => 0,
		);
	}
}

if (!isset($_SESSION['save']['member_form_2'])) {
	$_SESSION['save']['member_form_2'] = array(
		'recipient_name' => '',
		'recipient_gender' => '',
		'recipient_phone' => '',
		'recipient_mobile' => '',
		'recipient_addr' => '',
		'recipient_addr_county' => '',
		'recipient_addr_district' => '',
	);
}

$recipient = array(
	'recipient_name' => '',
	'recipient_gender' => '',
	'recipient_phone' => '',
	'recipient_mobile' => '',
	'recipient_addr' => '',
);

// 如果是非會員且選擇同訂購人的情況，那資料優先權不是依照這裡
if (isset($_SESSION['save']['member_form_2']) and !empty($_SESSION['save']['member_form_2'])) {
	foreach ($_SESSION['save']['member_form_2'] as $k => $v) {
		$recipient[$k] = $v;
	}
}

/*
 * 發票
 */

if (!isset($_SESSION['save']['invoice_1'])) {
	$_SESSION['save']['invoice_1'] = array(
		'invoice_type' => '',
		'invoice_type_2' => '',
		'invoice_type_2_barcode' => '',
		'invoice_tax_id' => '',
		'invoice_name' => '',
		'detail' => '',
		'captcha' => '',
	);
}

$invoice = array();

if (isset($_SESSION['save']['invoice_1']) and !empty($_SESSION['save']['invoice_1'])) {
	foreach ($_SESSION['save']['invoice_1'] as $k => $v) {
		$invoice[$k] = $v;
	}
}

if (isset($this->data['admin_id']) and $this->data['admin_id'] > 0) {
	$member = $this->db->createCommand()->from('customer')->where('is_enable=1 and id=:id', array(':id' => $this->data['admin_id']))->queryRow();

	// 
	if ($member['addr_county'] != '') {
		$_SESSION['save']['member_form_1']['addr_county'] = $member['addr_county'];
	} else {
		$_SESSION['save']['member_form_1']['addr_county'] = '';
	}

	//
	if ($member['addr_district'] != '') {
		$_SESSION['save']['member_form_1']['addr_district'] = $member['addr_district'];
	} else {
		$_SESSION['save']['member_form_1']['addr_district'] = '';
	}

	$member_address = $this->db->createCommand()->from('customer_address')->where('is_enable=1 and customer_id=:id', array(':id' => $this->data['admin_id']))->order('create_time desc')->limit(3)->queryAll();
	$member_address_tmp = array();
	if ($member_address and !empty($member_address)) {
		foreach ($member_address as $k => $v) {
			$member_address_tmp[$v['id']] = $v;
		}
	}

	if (isset($_SESSION['save']['member_form_2']['select_recipient']) and $_SESSION['save']['member_form_2']['select_recipient'] != '') {
		if (preg_match('/^addr_(.*)$/', $_SESSION['save']['member_form_2']['select_recipient'], $matches)) {
			if (isset($member_address_tmp[$matches[1]])) {
				$tmp = $member_address_tmp[$matches[1]];
				$recipient = array(
					'select_recipient' => $_SESSION['save']['member_form_2']['select_recipient'],
					'recipient_name' => $tmp['name'],
					'recipient_gender' => $tmp['gender'],
					'recipient_phone' => $tmp['phone'],
					'recipient_mobile' => $tmp['mobile'],
					'recipient_addr' => $tmp['addr'],
					'recipient_addr_county' => $tmp['addr_county'],
					'recipient_addr_district' => $tmp['addr_district'],
				);

				// 2020-05-29 nemo發現的問題
				if ($recipient['recipient_gender'] === null) {
					unset($recipient['recipient_gender']);
				}

				// 覆寫
				$_SESSION['save']['member_form_2'] = $recipient;

				// 為了程式碼好寫
				$_SESSION['save']['member_form_2']['recipient_addr_county'] = $tmp['addr_county'];
				$_SESSION['save']['member_form_2']['recipient_addr_district'] = $tmp['addr_district'];
			}
		} elseif ($_SESSION['save']['member_form_2']['select_recipient'] == 'buyer') {
			// $recipient = array(
			// 	'recipient_name' => $_SESSION['save']['member_form_1']['name'],
			// 	'recipient_gender' => $_SESSION['save']['member_form_1']['gender'],
			// 	'recipient_phone' => $_SESSION['save']['member_form_1']['phone'],
			// 	'recipient_mobile' => $_SESSION['save']['member_form_2']['recipient_mobile'],
			// 	'recipient_addr' => $_SESSION['save']['member_form_1']['addr'],
			// );

			$recipient['recipient_name'] = $_SESSION['save']['member_form_2']['recipient_name'] = $member['name'];
			$recipient['recipient_gender'] = $_SESSION['save']['member_form_2']['recipient_gender'] = $member['gender'];
			$recipient['recipient_phone'] = $_SESSION['save']['member_form_2']['recipient_phone'] = $member['phone'];
			$recipient['recipient_mobile'] = $_SESSION['save']['member_form_2']['recipient_mobile'] = $member['mobile'];
			$recipient['recipient_addr'] = $_SESSION['save']['member_form_2']['recipient_addr'] = $member['addr'];
			$recipient['recipient_addr_county'] = $_SESSION['save']['member_form_2']['recipient_addr_county'] = $member['addr_county'];
			$recipient['recipient_addr_district'] = $_SESSION['save']['member_form_2']['recipient_addr_district'] = $member['addr_district'];

			$_SESSION['save']['member_form_2']['select_recipient'] = 'buyer_sel';// 拷貝後就把這個參數改為非buyer by lota 2020-11-10 改這個亮燈可能會有問題

			// 2020-05-29 nemo發現的問題
			if ($recipient['recipient_gender'] === null) {
				unset($recipient['recipient_gender']);
			}
		}
	}
} else {

	if (isset($_SESSION['save']['member_form_1']['login_account']) and $_SESSION['save']['member_form_1']['login_account'] != '') {
		// 檢查email帳號是否存在
		$row = $this->db->createCommand()->from('customer')->where('is_enable=1 and login_account=:account', array(':account' => $_SESSION['save']['member_form_1']['login_account']))->queryRow();
		if ($row and isset($row['id'])) {
			$_SESSION['save']['member_form_1']['login_account'] = '';
			$error_logs[] = array(
				'guest_email_exist',
				'訂購人| 請使用其它Email',
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=login_account]").addClass("error");';
		}

		// 檢查email格式
		if (!filter_var($_SESSION['save']['member_form_1']['login_account'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['save']['member_form_1']['login_account'] = '';
			$error_logs[] = array(
				'guest_email_no_match',
				'訂購人| Email信箱格式錯誤',
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=login_account]").addClass("error");';
		}
	} else {
		$error_logs[] = array(
			'guest_email_required',
			'訂購人| Email欄位沒有填',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=login_account]").addClass("error");';
	}

	/*
	 * 檢查未登入的基本欄位
	 */

	if ($_SESSION['save']['member_form_1']['name'] == '') {
		$error_logs[] = array(
			'guest_name_required',
			'訂購人| 姓名欄位沒有填',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=name]").addClass("error");';
	}

	if ($_SESSION['save']['member_form_1']['phone'] == '') {
		$error_logs[] = array(
			'guest_phone_required',
			'訂購人| 電話欄位沒有填',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=phone]").addClass("error");';
	}

	// 2020-05-29
	// 生日是非必填，只要有填一個欄位，才會檢查欄位是否有填
	if ($_SESSION['save']['member_form_1']['birthday_year'] != '' or $_SESSION['save']['member_form_1']['birthday_month'] != '' or $_SESSION['save']['member_form_1']['birthday_day'] != '') {
		if ($_SESSION['save']['member_form_1']['birthday_year'] == '' or $_SESSION['save']['member_form_1']['birthday_month'] == '' or $_SESSION['save']['member_form_1']['birthday_day'] == '') {
			$error_logs[] = array(
				'guest_addr_required',
				'訂購人| 生日欄位沒有填',
				2, // 第幾步驟
			);
			foreach (array('year', 'month', 'day') as $v) {
				if ($_SESSION['save']['member_form_1']['birthday_' . $v] == '') {
					$step2_javascript_evals[] = '$("select[name=birthday_' . $v . ']").addClass("error");';
				}
			}
			$_SESSION['save']['member_form_1']['birthday'] = '';
		} elseif ($_SESSION['save']['member_form_1']['birthday_year'] != '' and $_SESSION['save']['member_form_1']['birthday_month'] != '' and $_SESSION['save']['member_form_1']['birthday_day'] != '') {
			$_SESSION['save']['member_form_1']['birthday'] = $_SESSION['save']['member_form_1']['birthday_year'] . '-' . str_pad($_SESSION['save']['member_form_1']['birthday_month'], 2, '0', STR_PAD_LEFT) . '-' . $_SESSION['save']['member_form_1']['birthday_day'];
		}
	}

	if (
		$_SESSION['save']['member_form_1']['addr_county'] == ''
		or $_SESSION['save']['member_form_1']['addr_district'] == ''
		or $_SESSION['save']['member_form_1']['addr'] == ''
	) {
		$error_logs[] = array(
			'guest_addr_required',
			'訂購人| 地址欄位沒有填',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("select[name=addr_county]").addClass("error");';
		$step2_javascript_evals[] = '$("select[name=addr_district]").addClass("error");';
		$step2_javascript_evals[] = '$("input[name=addr]").addClass("error");';
	}

	if (
		$_SESSION['save']['member_form_1']['login_password'] == ''
		or $_SESSION['save']['member_form_1']['login_password_confirm'] == ''
		or ($_SESSION['save']['member_form_1']['login_password'] != $_SESSION['save']['member_form_1']['login_password_confirm'])
	) {
		$error_logs[] = array(
			'email_required',
			'訂購人| 密碼欄位沒有填、或是與再次輸入密碼不相符',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=login_password]").addClass("error");';
		$step2_javascript_evals[] = '$("input[name=login_password_confirm]").addClass("error");';
	}

	if ($_SESSION['save']['member_form_1']['accept_privacy'] <= 0) {
		$error_logs[] = array(
			'accept_privacy_required',
			'訂購人| 請同意隱私權政策',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=accept_privacy]").addClass("error");';
	}

	//var_dump($_SESSION['save']['member_form_1']);die;
	$member = $_SESSION['save']['member_form_1'];

	// 同訂購人 (非會員)
	if (isset($_SESSION['save']['member_form_2']['select_recipient']) and $_SESSION['save']['member_form_2']['select_recipient'] != '') {
		if ($_SESSION['save']['member_form_2']['select_recipient'] == 'buyer') {
			// $recipient = array(
			// 	'recipient_name' => $_SESSION['save']['member_form_1']['name'],
			// 	'recipient_gender' => $_SESSION['save']['member_form_1']['gender'],
			// 	'recipient_phone' => $_SESSION['save']['member_form_1']['phone'],
			// 	'recipient_mobile' => $_SESSION['save']['member_form_2']['recipient_mobile'],
			// 	'recipient_addr' => $_SESSION['save']['member_form_1']['addr'],
			// );

			$recipient['recipient_name'] = $_SESSION['save']['member_form_2']['recipient_name'] = $_SESSION['save']['member_form_1']['name'];
			$recipient['recipient_gender'] = $_SESSION['save']['member_form_2']['recipient_gender'] = $_SESSION['save']['member_form_1']['gender'];
			$recipient['recipient_mobile'] = $_SESSION['save']['member_form_2']['recipient_mobile'];
			$recipient['recipient_addr'] = $_SESSION['save']['member_form_2']['recipient_addr'] = $_SESSION['save']['member_form_1']['addr'];

			// #36112
			if (!isset($_SESSION['save']['member_form_2']['recipient_phone']) or $_SESSION['save']['member_form_2']['recipient_phone'] == '') {
				$recipient['recipient_phone'] = $_SESSION['save']['member_form_2']['recipient_phone'] = $_SESSION['save']['member_form_1']['phone'];
			}

			$_SESSION['save']['member_form_2']['recipient_addr_county'] = $recipient['recipient_addr_county'] = $_SESSION['save']['member_form_1']['addr_county'];
			$_SESSION['save']['member_form_2']['recipient_addr_district'] = $recipient['recipient_addr_district'] = $_SESSION['save']['member_form_1']['addr_district'];

			$_SESSION['save']['member_form_2']['select_recipient'] = 'buyer_sel';// 拷貝後就把這個參數改為非buyer by lota 2020-11-10 改這個亮燈可能會有問題

		}
	}
}


// 只是方便第三步驟套程式而以 2017/7/3 加入防呆 by lota
if (isset($recipient['recipient_addr_county']) && isset($recipient['recipient_addr_district'])) {
	$recipient['recipient_addr_merge'] = $recipient['recipient_addr_county'] . $recipient['recipient_addr_district'] . $recipient['recipient_addr'];
} else {
	$recipient['recipient_addr_merge'] = $recipient['recipient_addr'];
}


// 第二、三驟才會檢查的欄位：例如表單
if ($_SESSION[$this->data['router_method']]['step'] > 1) {

	// if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
	// } else {
	// 	if($_SESSION['save']['invoice_1']['captcha'] == '' or $_SESSION['save']['invoice_1']['captcha'] != Yii::app()->session['captcha']){
	// 		$error_logs[] = array(
	// 			'captcha_required',
	// 			'驗證碼沒有填，或是不符合',
	// 			2, // 第幾步驟
	// 		);
	// 		$step2_javascript_evals[] = '$("input[name=captcha]").addClass("error");';
	// 	}
	// 	Yii::app()->session['captcha'] = '';
	// }
	if (isset($data['shop_show_electronic_invoice']) && $data['shop_show_electronic_invoice'] == true) {
		if ($_SESSION['save']['invoice_1']['invoice_type'] == '') {
			$error_logs[] = array(
				'invoice_type_required',
				'發票資訊| 請選擇二聯或是三聯',
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=invoice_type]").parent().parent().addClass("error");';
		}

		if ($_SESSION['save']['invoice_1']['invoice_type'] == '1') {
			if ($_SESSION['save']['invoice_1']['invoice_type_2'] == '') {
				$error_logs[] = array(
					'invoice_type_2_required',
					'發票資訊| 請選擇手機條碼、或是自然人憑證條碼',
					2, // 第幾步驟
				);
				// 因為設計沒有做error，所以這一個沒有
			}
			if ($_SESSION['save']['invoice_1']['invoice_type_2_barcode'] == '') {
				$error_logs[] = array(
					'invoice_type_2_barcode_required',
					'發票資訊| 請輸入條碼',
					2, // 第幾步驟
				);
				$step2_javascript_evals[] = '$("input[name=invoice_type_2_barcode]").addClass("error");';
			}
		}

		if ($_SESSION['save']['invoice_1']['invoice_type'] == '3') {
			if ($_SESSION['save']['invoice_1']['invoice_tax_id'] == '') {
				$error_logs[] = array(
					'invoice_tax_id_required',
					'發票資訊| 請輸入統一編號',
					2, // 第幾步驟
				);
				$step2_javascript_evals[] = '$("input[name=invoice_tax_id]").addClass("error");';
			}
			if ($_SESSION['save']['invoice_1']['invoice_name'] == '') {
				$error_logs[] = array(
					'invoice_name_required',
					'發票資訊| 請輸入公司抬頭',
					2, // 第幾步驟
				);
				$step2_javascript_evals[] = '$("input[name=invoice_name]").addClass("error");';
			}
		}
	}
}

// 檢查收件人的欄位

if ($_SESSION['save']['member_form_2']['recipient_name'] == '') {
	$error_logs[] = array(
		'recipient_name_required',
		'收件人| 姓名欄位沒有填',
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_name]").addClass("error");';
} else {
	$check_name = $_SESSION['save']['member_form_2']['recipient_name'];
	$check_name = str_replace(' ', '', $check_name);
	$check_name = str_replace('.', '', $check_name);
	$check_name = str_replace(',', '', $check_name);

	if (preg_match('/(\^|\'|\`|\!|\@|\#|\%|\&|\*|\+|\\|\"|\<|\>|\||\_|\[|\])/', $check_name)) {
		$error_logs[] = array(
			'recipient_name_has_special_char',
			'收件人| 姓名欄位不能含有特殊字元',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=recipient_name]").addClass("error");';
	}

	if (!preg_match('/^([\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}]{2,5}|[a-zA-Z]{4,10})$/u', $check_name)) {
		$error_logs[] = array(
			'recipient_name_format_error',
			'收件人| 姓名欄位，中文限制2~5個字，英文限制4~10個字，不能中英混合輸入',
			2, // 第幾步驟
		);
		$step2_javascript_evals[] = '$("input[name=recipient_name]").addClass("error");';
	}
}

if ($_SESSION['save']['member_form_2']['recipient_phone'] == '') {
	$error_logs[] = array(
		'recipient_phone_required',
		'收件人| 電話欄位沒有填，請填入手機號碼',
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_phone]").addClass("error");';
} elseif (!preg_match('/^09........$/', $_SESSION['save']['member_form_2']['recipient_phone'])) {
	$error_logs[] = array(
		'recipient_phone_error',
		'收件人| 請填入正確手機號碼 (09xxxxxxxx)',
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_phone]").addClass("error");';
}

// 有填才檢查
if ($_SESSION['save']['member_form_2']['recipient_mobile'] != '' and !preg_match('/^09........$/', $_SESSION['save']['member_form_2']['recipient_mobile'])) {
	$error_logs[] = array(
		'recipient_phone_error',
		'收件人| 請填入正確備用電話號碼 (09xxxxxxxx)',
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("input[name=recipient_mobile]").addClass("error");';
}

if (
	($_SESSION['save']['member_form_2']['recipient_addr_county'] == ''
		or $_SESSION['save']['member_form_2']['recipient_addr_district'] == ''
		or $_SESSION['save']['member_form_2']['recipient_addr'] == '')
	and isset($shipment['addr'])
	and $shipment['addr'] == 'addr' // 當然，如果是選擇超商，就不用地址了
) {
	$error_logs[] = array(
		'recipient_addr_required',
		'收件人| 地址欄位沒有填',
		2, // 第幾步驟
	);
	$step2_javascript_evals[] = '$("select[name=recipient_addr_county]").addClass("error");';
	$step2_javascript_evals[] = '$("select[name=recipient_addr_district]").addClass("error");';
	$step2_javascript_evals[] = '$("input[name=recipient_addr]").addClass("error");';
}

if ($_SESSION[$this->data['router_method']]['step'] == 2) {
	if (isset($this->data['admin_id']) and $this->data['admin_id'] > 0) {
		// do nothing
	} else {
		if ($_SESSION['save']['invoice_1']['captcha'] == '' or $_SESSION['save']['invoice_1']['captcha'] != Yii::app()->session['captcha']) {
			$error_logs[] = array(
				'captcha_required',
				'驗證碼沒有填，或是不符合',
				2, // 第幾步驟
			);
			$step2_javascript_evals[] = '$("input[name=captcha]").addClass("error");RefreshImage(\'valImageId\');';
		}
		Yii::app()->session['captcha'] = '';
	}
}

// 第三驟，設立這裡的目的，就是除了render以外、和訂單完成後以外的，都是寫在這裡
if ($_SESSION[$this->data['router_method']]['step'] > 2) {

	if ($ajax == 1) {
		if (!empty($error_logs)) {
			foreach ($error_logs as $k => $v) {
				if ($v[2] < 3) {
					echo 'window.location.href="checkout_' . $this->data['ml_key'] . '.php?step=' . $v[2] . '";';
				}
			}
		}
	}
}
if ($_SESSION[$this->data['router_method']]['step'] == 1) {

	// 第一步驟，不需要顯示、以及處理第二步驟的問題
	if (!empty($error_logs)) {
		foreach ($error_logs as $k => $v) {
			if ($v[2] != 1) {
				unset($error_logs[$k]);
			}
		}
		sort($error_logs);
	}

	// 記得，切換步驟，有兩種方式，一種是checkout.php?step=1
	// 另外一種是ajax
	// 通常下一步：都是ajax
	// 上一步，都是url
	// 不管是url還是ajax，都是會檢查的哦
	if ($ajax == 1) {
		if (!empty($error_logs)) {
			if (defined('ENVIRONMENT') and ENVIRONMENT == 'development') {
				echo 'alert(\'' . $error_logs[0][1] . ' (' . $error_logs[0][0] . ')\');';
			} else {
				echo 'alert(\'' . $error_logs[0][1] . '\');';
			}
		} else {
			echo 'window.location.href="checkout_' . $this->data['ml_key'] . '.php?step=2";';
		}
		die;
	}

	include 'source/shop/log_save_include.php';

	$view_file = 'v3/widget/add_cart_panel';
	if (isset($layoutv3_struct_map_keyname[$view_file][1])) {
		$data[$layoutv3_struct_map_keyname[$view_file][1]] = $items2;
	}

	$view_file = 'v3/end/shop';
	if (isset($layoutv3_struct_map_keyname[$view_file][1])) {
		$data[$layoutv3_struct_map_keyname[$view_file][1]] = $items2;
	}

	$data2[$layoutv3_struct_map_keyname['v3/checkout/step1'][0]]['multi'] = array(
		//$physicals, // 物流(移到第二步驟)
		$car, // 購物車裡面的東西
		$calculate_logs, // 計算機
		$how_much_difference, // 你只差多少
		$error_logs, // 錯誤訊息
		$additional_purchases, // 加購(簡稱ap)
	);
	$data2[$layoutv3_struct_map_keyname['v3/checkout/step1'][0]]['single'] = array(
		// 會員的紅利，還有會員和非會員的優惠卷
		array(
			'bonus_can_use' => $bonus_can_use,
			'bonus_total' => $bonus_total,
		),
	);
	//處理要提供給fb或google轉換碼使用的資料 by lota
	foreach ($calculate_logs as $k => $v) {
		if ($v[0] == '總計') {
			$data['conversion_code']['calculate_logs']['total_money'] = str_replace(',', '', str_replace('$', '', $v[1]));
		}
	}
} elseif ($_SESSION[$this->data['router_method']]['step'] == 2) {

	// 如果有第一步驟的問題，那就要回到第一步驟(李哥建議)
	if (!empty($error_logs)) {
		foreach ($error_logs as $k => $v) {
			if ($v[2] == 1) {
				//echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step=1";';
				header('location: checkout_' . $this->data['ml_key'] . '.php?step=1');
			}
		}
	}

	if ($ajax == 2) {
		if (!empty($error_logs)) {
			if (defined('ENVIRONMENT') and ENVIRONMENT == 'development') {
				echo 'alert(\'' . $error_logs[0][1] . ' (' . $error_logs[0][0] . ')\');';
			} else {
				echo 'alert(\'' . $error_logs[0][1] . '\');';
			}

			echo '$("input[name=login_account]").removeClass("error");';
			echo '$("input[name=login_account]").removeClass("error");';
			echo '$("input[name=login_password]").removeClass("error");';
			echo '$("input[name=login_password_confirm]").removeClass("error");';
			echo '$("input[name=name]").removeClass("error");';
			echo '$("select[name=addr_county]").removeClass("error");';
			echo '$("select[name=addr_district]").removeClass("error");';
			echo '$("input[name=addr]").removeClass("error");';
			echo '$("input[name=recipient_name]").removeClass("error");';
			echo '$("input[name=recipient_phone]").removeClass("error");';
			echo '$("select[name=recipient_addr_county]").removeClass("error");';
			echo '$("select[name=recipient_addr_district]").removeClass("error");';
			echo '$("input[name=recipient_addr]").removeClass("error");';
			echo '$("input[name=invoice_type]").parent().parent().removeClass("error");';
			echo '$("input[name=invoice_type_2_barcode]").removeClass("error");';
			echo '$("input[name=invoice_tax_id]").removeClass("error");';
			echo '$("input[name=invoice_name]").removeClass("error");';
			echo '$("input[name=captcha]").removeClass("error");';
			if (isset($step2_javascript_evals) and !empty($step2_javascript_evals)) {
				foreach ($step2_javascript_evals as $k => $v) {
					echo $v;
				}
			}
		} else {
			// debug jerry ggggggaaaaa
			//die;
			echo 'window.location.href="checkout_' . $this->data['ml_key'] . '.php?step=3";';
		}
		die;
	}

	include 'source/shop/log_save_include.php';

	$data2[$layoutv3_struct_map_keyname['v3/checkout/step2'][0]]['multi'] = array(
		$error_logs, // 錯誤訊息
		$payments, // 金流
		$physicals, // 物流
		$member_address, // 地址簿
	);

	$data2[$layoutv3_struct_map_keyname['v3/checkout/step2'][0]]['single'] = array(
		$member, // 訂購人資料
		$shipment, // 運費與物流
		$recipient, // 收件人資料
		$invoice_config, // 發票設定
		$invoice, // 發票資訊和備註
	);
} elseif ($_SESSION[$this->data['router_method']]['step'] == 3) {
	//var_dump($error_logs);die;

	// 如果有第一步驟的問題，那就要回到第一步驟(李哥建議)
	if (!empty($error_logs)) {
		foreach ($error_logs as $k => $v) {
			if ($v[2] == 1) {
				//echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step=1";';
				header('location: checkout_' . $this->data['ml_key'] . '.php?step=1');
			}
		}
	}

	// 如果有第二步驟的問題，那就要回到第二步驟(李哥建議)
	if (!empty($error_logs)) {
		foreach ($error_logs as $k => $v) {
			if ($v[2] < 3) {
				//echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step=1";';
				header('location: checkout_' . $this->data['ml_key'] . '.php?step=2');
			}
		}
	}

	// 因為有些物流是會幫忙收錢的
	if (isset($_SESSION['save']['selecxt_physical']['func'])) {
		// ecpay_711_cash_on_delivery
		if (
			preg_match('/^ecpay_(711|fami)_cash_on_delivery/', $_SESSION['save']['selecxt_physical']['func'])
			or $_SESSION['save']['selecxt_physical']['func'] == 'cash_on_delivery'
		) {
			$payment = array(); // 清空它！避免任何金流的干擾
			$payment['has_postpay'] = true;
			$payment['func'] = '';
			$payment['name'] = $shipment['name'];
			$payment['payment_notice'] = false;
			$_SESSION['save']['step3']['go_to_finish!!'] = '1';
		}
	}

	// 付款方式的特例
	if (isset($_SESSION['save']['selecxt_payment']['func'])) {
		if ($_SESSION['save']['selecxt_payment']['func'] == 'cash_on_delivery') {
			$_SESSION['save']['step3']['go_to_finish!!'] = '1';
		} elseif ($_SESSION['save']['selecxt_payment']['func'] == 'cash_on_delivery_2') {
			$_SESSION['save']['step3']['go_to_finish!!'] = '1';
		} elseif ($_SESSION['save']['selecxt_payment']['func'] == 'atm') {
			$_SESSION['save']['step3']['go_to_finish!!'] = '1';
		}
	}

	// 有沒有付款的檢查
	if (isset($payment) and !empty($payment)) {
		if ($payment['has_postpay'] === true) { // 這個是純ATM在用的
			$payment['has_check_finish'] = true;
		}
	}

	// 這裡的程式欄位，記得，不要跟資料庫的欄位名稱相沖
	$order = array(
		'payment_func' => false, // by lota 不加在第三步會報錯 #以皇冠為例
		'order_status' => 0, //by lota 不加在第三步會報錯  #以皇冠為例
		'status' => false,
		'payment_status' => false, // 只有線上刷卡才能更改這裡的狀態，記到…！
	);

	if (isset($_SESSION['save']['selecxt_payment']['func'])) {
		if ($_SESSION['save']['selecxt_payment']['func'] == 'atm') {
			if (!empty($this->data['atm_config'])) {
				foreach ($this->data['atm_config'] as $k => $v) {
					if ($k == 'atm_expire_day' and $v > 0) { // 李哥說這個不需要
						$order['atm_expiredate'] = date('Y-m-d', strtotime('+' . $v . ' day'));
					}
					$order[$k] = $v;
				}
			}
		}
	}

	/*
	 * 金流註解
	 */

	/*
	 * 這裡會寫入訂單
	 */
	if (isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1') {
		$order['status'] = true;

		// Vencen 提供的範例
		// $gOrderStatus = Array("未付款", "已付款", "已出貨", "已通知付款", "付款失敗", "取消訂單");  //訂單狀態

		/*
		 * 我打算規劃的訂單狀態
		 * 0 未付款
		 * 1 己付款
		 * 2 己出貨
		 *
		 * 所有錯誤類的都從11開始
		 * 11 己通知付款
		 * 12 付款失敗
		 * 
		 * 99 取消訂單
		 */


		if (!isset($_SESSION['save']['step3']['order_created_id']) or $_SESSION['save']['step3']['order_created_id'] == '') {

			// 先假設失敗
			$_SESSION['save']['step3']['order_created_id'] = -1;

			// 基本欄位
			$save = array(
				'sum' => $total_sub, // 合計
				'shipment' => $shipping_total, // 運費
				'total' => $total, // 總計
				'payment_func' => $payment['func'],
				'order_status' => 0,
				'detail' => $invoice['detail'],
				//  'log_1' => var_export($log_1, true),
				//  'log_2' => var_export($log_2, true),
				//  'car' => var_export($car, true), // 可能只會用在後台訂單內頁的列表、和資料匯出
				//  'calculate' => var_export($calculate_logs, true),
				//  'search_raw' => var_export($search_raw, true),
				'is_enable' => 1,
				'create_time' => date('Y-m-d H:i:s'),
				'ml_key' => $this->data['ml_key'],
				//20200929 Kevin 寫入紅利紀錄
				'bonus'=>isset($canuse_bonus)?$canuse_bonus:0,
				//20200828
				'coupon_code' => isset($_SESSION['save']['goodies_number']['gift_serial_number'])?$_SESSION['save']['goodies_number']['gift_serial_number']:"",
				'coupon_money' => isset($_SESSION['save']['goodies_number']['gift_serial_money'])?$_SESSION['save']['goodies_number']['gift_serial_money']:"",
			);

			



			// 第三步驟，這一行，一定要放在log_result之前
			include 'source/shop/log_save_include.php';

			// 資料切割後，欄位的數量在前面己經檢查過沒有問題了，所以這裡可以放心的寫入
			foreach ($log_result as $k => $v) {
				$save['log_' . ($k + 1)] = $v;
			}

			if (isset($this->data['admin_id']) and $this->data['admin_id'] > 0) {
				$save['customer_id'] = $this->data['admin_id'];
				$bonus_arr['memberID']=$this->data['admin_id'];
			}

			// 發票
			$invoice_save = $invoice; // 因為等一下render還要用，所以這裡完全不要去覆寫它
			unset($invoice_save['captcha']);
			foreach ($invoice_save as $k => $v) {
				$save[$k] = $v;
			}

			// 購買人
			$member_save = $member; // 因為等一下render還要用，所以這裡完全不要去覆寫它
			$member_save['addr'] = $member_save['addr_county'] . $member_save['addr_district'] . $member_save['addr'];
			foreach ($member_save as $k => $v) {
				if (preg_match('/(pass|birthday|county|district|zip|need_dm|accept_privacy|company)/', $k)) continue; // 非會員
				if (preg_match('/(is_enable|time|email|mobile|fax|id|salt)/', $k)) continue; // 會員
				if (preg_match('/(other|is_send)/', $k)) continue; // unknow
				$save['buyer_' . $k] = $v;
			}

			// 收件人
			$recipient_save = $recipient; // 因為等一下render還要用，所以這裡完全不要去覆寫它
			$recipient_save['recipient_addr'] = $recipient_save['recipient_addr_merge'];
			unset($recipient_save['recipient_addr_merge']);
			foreach ($recipient_save as $k => $v) {
				if (preg_match('/(county|district|zipcode|merge|select_recipient)/', $k)) continue; // 非會員 //2017/7/6 移除add的關鍵字 by lota
				if (preg_match('/(recipient_address_add)/', $k)) continue;
				$save[$k] = $v;
			}

			// 看一下當月有幾筆了
			// 這個部分，放在寫入前的最後一個步驟
			// 2017-02-09 李哥說的訂單編號規則
			$rows = $this->db->createCommand()->select('id')->from($prefix . 'orderform')->where('create_time like "%' . date('Y-m-d') . '%"')->queryAll();
			$_order_number_bonus = $save['order_number'] = substr(date('Ymd'), 2, 6) . str_pad((count($rows) + 1), 6, '0', STR_PAD_LEFT);//2020-11-11 加一個 $_order_number_bonus 給 紅利寫入用 by lota 

			//這邊會多出func的欄位，要移除 by lota
			if (isset($save['func'])) {
				unset($save['func']);
			}

			// ServerZoo_4 為了這台主機而修正的問題
			foreach ($save as $k => $v) {
				if (preg_match('/(PHPSESSID|KCFINDER|_ga)/', $k)) {
					unset($save[$k]);
				}
			}

			// 2020-06-11 513發現的問題
			foreach (array('buyer_gender', 'recipient_mobile') as $v) {
				if ($save[$v] === null) {
					unset($save[$v]);
				}
			}

			//file_put_contents('123.txt', var_export($save,true),FILE_APPEND);

			// 2020-06-10 李哥說不要用這種寫法，所以後來就改用orm
			// $this->cidb->insert($prefix.'orderform', $save); 
			// $order_id = $this->cidb->insert_id();
			// if(!$order_id or $order_id <= 0){
			// 	unset($_SESSION['save']['step3']['order_created_id']);
			// 	unset($_SESSION['save']['step3']['go_to_finish!!']);
			// 	//G::alert_captcha(t('欄位資料驗證失敗'), $redirect_url, $this->data);
			// 	$redirect_url = 'checkout_'.$this->data['ml_key'].'.php?step=2';
			// 	G::alert_and_redirect(t('訂單寫入失敗'), $redirect_url, $this->data); // current sample
			// }

			// 2020-06-10 改用orm寫法
			$empty_orm_data = array(
				'table' => $prefix . 'orderform',
				//'created_field' => 'create_time', 
				//'updated_field' => 'update_time',
				'primary' => 'id',
				'rules' => array(
					//array('name, email', 'required'),
				),
			);

			$orm = new gorm($this->cidb, $empty_orm_data);
			$orm->data($save);
			$status = $orm->validate(); // 回傳true或false

			

			if ($status === false) {
				// var_dump($orm->message());
				unset($_SESSION['save']['step3']['order_created_id']);
				unset($_SESSION['save']['step3']['go_to_finish!!']);
				$redirect_url = 'checkout_' . $this->data['ml_key'] . '.php?step=2';
				G::alert_and_redirect(t('訂單欄位資料驗證失敗'), $redirect_url, $this->data); // current sample
			}

			$status = $orm->insert(); // 回傳寫入狀態
			$order_id = $this->cidb->insert_id();

			//Kevin 紅利寫入 2020-11-11 這邊的程式碼因為沒考慮到首購，所以搬移到下面去了 by lota
			


			if ($status === false) {
				unset($_SESSION['save']['step3']['order_created_id']);
				unset($_SESSION['save']['step3']['go_to_finish!!']);
				$redirect_url = 'checkout_' . $this->data['ml_key'] . '.php?step=1';
				G::alert_and_redirect(t('訂單寫入失敗'), $redirect_url, $this->data); // current sample
			}

			// 可以考慮把金流放到這裡來處理
			if (isset($_SESSION['save']['selecxt_payment']['func'])) {
				// 失敗的話，刪除訂單，並且取消選取的付款方式和取消finish，然後回到第二步
				// 成功的話，修改訂單為付款成功、order[payment_status]要改成true，還有新增order_created_id的session變數，最後也是回到第三步
				// https://www.ecpay.com.tw/Content/files/ecpay_011.pdf
				if (preg_match('/^ecpay_(credit_card|cvs|barcode|webatm|vatm)$/', $_SESSION['save']['selecxt_payment']['func'], $matches)) {

					$func_sub = $matches[1];

					require('ecpay/ECPay.Payment.Integration.php'); // 放在母體
					$aaa = new ECPay_AllInOne();
					$aaa->ServiceURL = $Config['Allpay']['URL'];
					$aaa->HashKey = $Config['AllPay']['HashKey'];
					$aaa->HashIV = $Config['AllPay']['HashIV'];
					$aaa->MerchantID = $Config['AllPay']['MerchantID'];

					//基本參數
					//$aaa->Send['ClientBackURL'] = FRONTEND_DOMAIN.'/checkout.php?step=3'; // 下面會設定
					$aaa->Send['MerchantTradeNo'] = $save['order_number'];
					$aaa->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
					$aaa->Send['TotalAmount'] = (int)$total;
					$aaa->Send['TradeDesc'] =  '您於本站本次的交易名細';

					array_push($aaa->Send['Items'], array('Name' => "網路購物商品", 'Price' => (int)$total, 'Currency' => "元", 'Quantity' => "1", 'URL' => ""));

					if ($func_sub == 'credit_card') { // 信用卡
						$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::Credit;
					} elseif ($func_sub == 'cvs') { // 超商代碼
						$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::CVS;
					} elseif ($func_sub == 'barcode') { // 超商條碼
						$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::BARCODE;
					} elseif ($func_sub == 'webatm') { // WebATM (插卡) 測試環境下僅有台新銀行提供測試，使用時須注意是否安裝讀卡機，並使用IE瀏覽器
						$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::WebATM;
					} elseif ($func_sub == 'vatm') { // 虛擬ATM (要自己去匯款)
						$aaa->Send['ChoosePayment'] = ECPay_PaymentMethod::ATM;
					}

					// 基本參數
					if ($is_site_production === true) {
						if (preg_match('/^(cvs|barcode|webatm|vatm|unionpay)$/', $func_sub)) {
							// CVS、ATM、Barcode、銀聯卡，不支援OrderResultUrl
							$aaa->Send['ClientBackURL'] = FRONTEND_DOMAIN . '/checkout_' . $this->data['ml_key'] . '.php?step=3';
						} else {
							// 當消費者付款完成後，綠界會將付款結果參數以幕前(Client  POST)回傳到該網址。
							//$aaa->Send['OrderResultURL'] = FRONTEND_DOMAIN.'/checkout_'.$this->data['ml_key'].'.php?step=3';
							$aaa->Send['OrderResultURL'] = FRONTEND_DOMAIN . '/reply.php';
						}

						// 幕後
						$id_number = substr(md5(rand(1, 1000000)), 0, 15);
						$save = array(
							'id_number' => $id_number,
							'session_id' => session_id(),
							'func' => $_SESSION['save']['selecxt_payment']['func'],
							'url1' => 'xxx',
							'url2' => FRONTEND_DOMAIN . '/reply.php',
							//'back' => 'checkout.php?step=2',
							'is_enable' => '1',
							'create_time' => date('Y-m-d H:i:s'),
						);

						if (preg_match('/^(cvs|barcode|webatm|vatm)$/', $func_sub)) $params['func'] .= '_server_reply';

						$this->cidb->insert('short', $save);
						$id = $this->cidb->insert_id();
						$aaa->Send['ReturnURL'] = FRONTEND_DOMAIN . '/short.php?id=' . $id_number;
					} else {
						$aaa->Send['ClientBackURL'] = FRONTEND_DOMAIN . '/checkout_' . $this->data['ml_key'] . '.php?step=3';

						$public_key = EIP_APIV1_PUBLICKEY;
						$private_key = EIP_APIV1_PRIVATEKEY;
						$server_ip = EIP_APIV1_DOMAIN;
						$url = 'index.php?r=api/short';

						$params = array(
							'url' => 'xxx',
							'url2' => FRONTEND_DOMAIN . '/reply.php',
							'func' => $_SESSION['save']['selecxt_payment']['func'],
							'_____session_id' => session_id(), // 因為會跟EIPAPI的衝到
							//'back' => 'checkout.php?step=2', // 子站的reply處理完後，要去的地方
						);

						if (preg_match('/^(cvs|barcode|webatm|vatm)$/', $func_sub)) $params['func'] .= '_server_reply';

						// 這支是客戶端

						$postdata = http_build_query(
							array(
								'get_client_code' => '',
							)
						);
						$opts = array('http' =>
						array(
							'method'  => 'POST',
							'header'  => 'Content-type: application/x-www-form-urlencoded',
							'content' => $postdata
						));
						$context  = stream_context_create($opts);
						$code = file_get_contents($server_ip . '/apiv1/code.php', false, $context);

						//$code = stripslashes($code);
						eval('?' . '>' . $code);

						// debug
						//var_dump($result);die;

						// 會回傳以下的元素
						// url
						// id_number
						// $row = $return;
						//var_dump($return);die;
						if (isset($return) and !empty($return)) {
							$aaa->Send['ReturnURL'] = EIP_APIV1_DOMAIN . '/short.php?id=' . $return['id_number'];
						}
					}

					// 額外的參數作用
					// CVS : 取碼
					// Barcode : 取碼
					// (web|v)ATM : 取得虛擬帳號
					if (preg_match('/^(cvs|barcode|webatm|vatm)$/', $func_sub)) {
						if ($is_site_production === true) {
							$id_number = substr(md5(rand(1, 1000000)), 0, 15);
							$save = array(
								'id_number' => $id_number,
								'session_id' => session_id(),
								'func' => $_SESSION['save']['selecxt_payment']['func'],
								'url' => 'xxx',
								'url2' => FRONTEND_DOMAIN . '/reply.php',
								//'back' => 'checkout.php?step=2',
								'is_enable' => '1',
								'create_time' => date('Y-m-d H:i:s'),
							);
							$this->cidb->insert('short', $save);
							$id = $this->cidb->insert_id();
							$aaa->SendExtend['PaymentInfoURL'] = FRONTEND_DOMAIN . '/short.php?id=' . $id_number;
						} else {
							$public_key = EIP_APIV1_PUBLICKEY;
							$private_key = EIP_APIV1_PRIVATEKEY;
							$server_ip = EIP_APIV1_DOMAIN;
							$url = 'index.php?r=api/short';

							$params = array(
								'url' => 'xxx',
								'url2' => FRONTEND_DOMAIN . '/reply.php',
								'func' => $_SESSION['save']['selecxt_payment']['func'],
								'_____session_id' => session_id(), // 因為會跟EIPAPI的衝到
								//'back' => 'checkout.php?step=2', // 子站的reply處理完後，要去的地方
							);

							// 這支是客戶端

							$postdata = http_build_query(
								array(
									'get_client_code' => '',
								)
							);
							$opts = array('http' =>
							array(
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => $postdata
							));
							$context  = stream_context_create($opts);
							$code = file_get_contents($server_ip . '/apiv1/code.php', false, $context);

							//$code = stripslashes($code);
							eval('?' . '>' . $code);

							// debug
							//var_dump($result);die;

							// 會回傳以下的元素
							// url
							// id_number
							// $row = $return;
							//var_dump($return);die;
							if (isset($return) and !empty($return)) {
								$aaa->SendExtend['PaymentInfoURL'] = EIP_APIV1_DOMAIN . '/short.php?id=' . $return['id_number'];
							}
						}
					}

					if (preg_match('/^(webatm|vatm)$/', $func_sub)) {
						// $aaa->SendExtend['ExpireDate'] = 3; // 若需設定最長60天，最短1天。未設定此參數則預設為3天
					}

					$aaa->CheckOut();
					die;
				}
			} // 金流 selecxt_payment

		} elseif (isset($_SESSION['save']['step3']['order_created_id']) and $_SESSION['save']['step3']['order_created_id'] < 0) {
			// 2020-05-22 這裡是網路異常，完全沒回傳的狀態
			unset($_SESSION['save']['step3']['order_created_id']);
			unset($_SESSION['save']['step3']['go_to_finish!!']);
			header('location: checkout_' . $this->data['ml_key'] . '.php?step=2');
		} else {
			$order_id = $_SESSION['save']['step3']['order_created_id'];
		} // order_created_id

		// 重建order變數，最後，跟剛建好的那筆訂單的資料合併
		// 我是說底下這個啦：
		// $order = array(
		//	   status => false
		//	   payment_status => false // 只有線上刷卡才能更改這裡的狀態，記到…！
		// )
		$row = $this->db->createCommand()->from($prefix . 'orderform')->where('id=:id', array(':id' => $order_id))->queryRow();
		if ($row and !empty($row)) {
			foreach ($row as $k => $v) {
				$order[$k] = $v; // 記得，原有的order元素，不要跟db的欄位相沖
			}
		}

		if (isset($_SESSION['save']['step3']['order_created_id']) and $_SESSION['save']['step3']['order_created_id'] != '') {
			// 金流付款成功的話，金流返回的時候，要讓消費者看到付款成功的字眼
			if ($order['order_status'] == 1) {
				$order['payment_status'] = true;
			}
		}

		// 扣庫存
		//判斷是否需要扣除庫存 by lota
		unset($_constant_1);
		eval('$_constant_1 = ' . strtoupper('shop_show_electronic_invoice') . ';');
		if ($_constant_1 == true) {
			if ($car and !empty($car)) {
				foreach ($car as $k => $v) {
					$row = $this->cidb->where('data_id', $v['item']['id'])->where('id', $v['specid'])->where('is_enable', 1)->get($prefix . 'spec')->row_array();
					$update = array(
						'inventory' => $row['inventory'] - $v['amount'],
					);
					$this->cidb->where('data_id', $v['item']['id']);
					$this->cidb->where('id', $v['specid']);
					$this->cidb->where('is_enable', 1);
					$this->cidb->update($prefix . 'spec', $update);
				}
			}
		}


		// 處理優惠卷
		// 上面都檢查完了
		// 本來這裡是放在finish的開頭
		if (isset($_SESSION['save']['goodies_number']['gift_serial_number']) and $_SESSION['save']['goodies_number']['gift_serial_number'] != '') {
			$row = $this->db->createCommand()->from($prefix . 'goodies')->where('pid!=0 and func=1 and is_enable=1 and gift_serial_number=:number', array(':number' => $_SESSION['save']['goodies_number']['gift_serial_number']))->queryRow();
			$update = $row;
			$update['update_time'] = date('Y-m-d H:i:s');

			unset($update['id']);
			unset($update['create_time']);

			$update['gift_only_use_count2']++;

			if ($update['gift_only_use_count2'] >= $update['gift_only_use_count']) {
				$update['is_enable'] = 0;
			}

			$this->cidb->where('id', $row['id']);
			$this->cidb->update($prefix . 'goodies', $update);
		} // 處理優惠卷

		// 處理紅利
		// if(
		// 	isset($this->data['admin_id']) and $this->data['admin_id'] > 0
		// 	and isset($_SESSION['save']['use_bonus']['use']) 
		// 	and $_SESSION['save']['use_bonus']['use'] == '1' 
		// 	and $bonus_can_use > 0
		// ){

		// 	// 扣掉所使用的紅利
		// 	$update = array(
		// 		'bonus_left' => $bonus_list[0]['bonus_point'],
		// 		'is_enable' => 0,
		// 	);
		// 	$this->cidb->where('id', $bonus_list[0]['id']);
		// 	$this->cidb->update($prefix.'goodies', $update); 

		// 	// 寫入紅利記錄
		// 	$save = array(
		// 		'member_id' => $v['id'],
		// 		'name' => $save['name'],
		// 		'order_number' => $order['order_number'],
		// 		'point' => $save['bonus_point'],
		// 		'start_date' => $save['start_date'],
		// 		'end_date' => $save['end_date'],
		// 		'create_time' => date('Y-m-d H:i:s'),
		// 	);
		// 	$this->cidb->insert($prefix.'goodies_log', $save); 
		// 	//$id = $this->cidb->insert_id();

		// } // 處理紅利

		/*
		 * 寫入訂單後，如果非會員的話，馬上加入會員
		 */
		if (isset($this->data['admin_id']) and $this->data['admin_id'] > 0) {

			// 如果是會員的話...就不需要做什麼事…吧
			// 2020-11-11 將會員ID帶入給寫入紅利的變數 by lota
			$member_id = $this->data['admin_id'];
			

		} else {

			// ！！這裡可以參考register，寫入後，在select出來
			$save = $member; //這種寫法可能會被主機環境加料，導致無法寫入會員...需要注意 by lota

			unset($save['login_password_confirm']);
			//unset($save['addr_zipcode']); // 有這個欄位，不用刪掉
			unset($save['captcha']);

			$save['email'] = $save['login_account'];
			$save['is_enable'] = 1;
			$save['create_time'] = date('Y-m-d H:i:s');

			$save['salt'] = G::GeraHash(10);
			$save['login_password'] = '{GGG3AAA}' . str_replace('a', 'ɢ', sha1(G::utf8_strrev($save['login_password'] . $save['salt'])));

			// ServerZoo_4 為了這台主機而修正的問題
			foreach ($save as $k => $v) {
				if (preg_match('/(PHPSESSID|KCFINDER|_ga|birthday_)/', $k)) {
					unset($save[$k]);
				}
			}

			// $this->cidb->insert('customer', $save); 
			// $member_id = $this->cidb->insert_id();

			// 2020-06-10 改用orm寫法
			$empty_orm_data = array(
				'table' => 'customer',
				//'created_field' => 'create_time', 
				//'updated_field' => 'update_time',
				'primary' => 'id',
				'rules' => array(
					//array('name, email', 'required'),
				),
			);

			$orm = new gorm($this->cidb, $empty_orm_data);
			$orm->data($save);
			$status = $orm->validate(); // 回傳true或false

			if ($status === false) {
				// var_dump($orm->message());
				unset($_SESSION['save']['step3']['order_created_id']);
				unset($_SESSION['save']['step3']['go_to_finish!!']);

				// 2020-06-10
				// 訂單標註為刪除，因為步驟要倒退(李哥建議)
				$this->cidb->where('id', $order_id);
				$this->cidb->update($prefix . 'orderform', array('is_enable' => 0));

				$redirect_url = 'checkout_' . $this->data['ml_key'] . '.php?step=1';
				G::alert_and_redirect(t('會員欄位資料驗證失敗'), $redirect_url, $this->data); // current sample
			}

			$status = $orm->insert(); // 回傳寫入狀態
			$member_id = $this->cidb->insert_id();

			if ($status === false) {
				unset($_SESSION['save']['step3']['order_created_id']);
				unset($_SESSION['save']['step3']['go_to_finish!!']);

				// 2020-06-10
				// 訂單標註為刪除，因為步驟要倒退(李哥建議)
				$this->cidb->where('id', $order_id);
				$this->cidb->update($prefix . 'orderform', array('is_enable' => 0));

				$redirect_url = 'checkout_' . $this->data['ml_key'] . '.php?step=1';
				G::alert_and_redirect(t('會員寫入失敗'), $redirect_url, $this->data); // current sample
			}

			// 2020-06-11
			// Rigo發現的，為了避免用到別人已經刪除的資料的問題
			$this->cidb->delete('html', array('type' => 'favorite', 'member_id' => $member_id));
			$this->cidb->delete('customer_address', array('customer_id' => $member_id));
			// echo $this->cidb->affected_rows();

			$row = $this->db->createCommand()->from('customer')->where('is_enable=1 and id=:id', array(':id' => $member_id))->queryRow();

			// 從母版的登入那邊複製過來的
			Yii::app()->session->add('authw_admin_id', $row['id']);
			Yii::app()->session->add('authw_admin_account', $row['login_account']);
			Yii::app()->session->add('authw_admin_name', $row['name']);

			// 從母體複製過來的
			//$all_session = Yii::app()->session;
			$all_session = $_SESSION;
			foreach ($all_session as $k => $v) {
				if (preg_match('/^authw_(.*)$/', $k, $matches)) {
					$this->data[$matches[1]] = $v;
				}
			}

			// 把剛才的訂單，加註會員編號
			$this->cidb->where('id', $order_id);
			$this->cidb->update($prefix . 'orderform', array('customer_id' => $row['id']));

			/*
			 * 檢查我的收藏
			 */
			if (isset($_SESSION['save'][$prefix . '_favorite']) and !empty($_SESSION['save'][$prefix . '_favorite'])) {
				foreach ($_SESSION['save'][$prefix . '_favorite'] as $k => $v) {
					// 先看有沒有(此時不管時間)
					$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=":id"', array(':id' => $k, ':member_id' => $row['id'], ':type' => 'favorite', ':ml_key' => $this->data['ml_key']))->queryRow();
					if ($row2 and isset($row2['id'])) {
						$update = array(
							'start_date' => $v['add_date'],
						);
						$this->cidb->where('id', $row2['id']);
						$this->cidb->update('html', $update);
					} else {
						$id_tmp = explode('_', $k);
						$save = array(
							'type' => 'favorite',
							'ml_key' => $this->data['ml_key'],
							'is_enable' => 1,
							'start_date' => $v['add_date'],
							'other1' => $id_tmp[0],
							'other2' => $id_tmp[1],
							'member_id' => $row['id'],
						);
						$this->cidb->insert('html', $save);
					}
				}
				unset($_SESSION['save'][$prefix . '_favorite']);
			}

			$savedata = $row;
			// 寄件人、網站管理者Mail
			$to = $this->data['sys_configs']['service_admin_mail'];

			// 主旨
			$subject2 = '加入會員成功通知函'; // 預設值
			$subject = $this->data['sys_configs']['admin_title'] . ' ' . $subject2;

			$aaa_url = aaa_url;
			$aaa_name = $this->data['sys_configs']['admin_title'];
			$no_reply = t('此信為系統發出，請勿回覆');

			$body = '';
			$body .= $no_reply . "\n\n";

			$form_fields = array(
				array(
					'name' => '註冊日期',
					'value' => date('Y-m-d'),
					'style' => '',
				),
				array(
					'name' => '使用者名稱',
					'value' => $savedata['login_account'],
					'style' => '',
				),
				array(
					'name' => '會員姓名',
					'value' => $savedata['name'],
					'style' => '',
				),
				array(
					'name' => 'E-Mail',
					'value' => $savedata['login_account'],
					'style' => '',
				),
			);

			$embeddedimages = array();
			$embeddedimages[] = array(
				//'path' => _BASEPATH.'/../images/sendmail_title.png',
				'path' => _BASEPATH . '/../images/logo_banner.jpg',
				'cid' => 'logo',
			);

			ob_start();
			include _BASEPATH . '/../view/mail_template/member_success.php';
			$body_html = ob_get_clean();

			// 找一下寄件人有沒有設定
			$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1', array(':type' => 'email', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryRow();

			// 找一下收件人有沒有設定
			$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1', array(':type' => 'email', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryAll();

			//設定cc收件者
			if (defined('CC_MAIL_OPEN') && CC_MAIL_OPEN == true) {
				$cc_mail = $savedata['email'];
			} else {
				$cc_mail = NULL;
			}

			// 2019-04-23 #31761 李哥說，需要做的
			$email_return = array();

			// 寄給管理者
			// 有需要在打開
			// if($from and !empty($from) and isset($from['id']) and isset($from['email'])
			// 	and $tos and !empty($tos) and isset($tos[0]['id'])
			// ){
			// 	if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			// 		$email_return = $this->email_send_to_by_sendmail($from, $tos, $subject, $body, $body_html, $cc_mail, $embeddedimages);
			// 	} else {
			// 		$email_return = $this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
			// 	}
			// } else {	
			// 	//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
			// }

			// 寄給註冊者
			$tos = array(
				array(
					'id' => '',
					'name' => $savedata['name'],
					'email' => $savedata['login_account'],
				),
			);

			if (
				$from and !empty($from) and isset($from['id']) and isset($from['email'])
				and $tos and !empty($tos) and isset($tos[0]['id'])
			) {
				if (isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail') {
					$email_return = $this->email_send_to_by_sendmail($from, $tos, $subject, $body, $body_html, $cc_mail, $embeddedimages);
				} else {
					$email_return = $this->email_send_to_v2($from, $tos, $subject, $body, $body_html, $cc_mail);
				}
			} else {
				//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
			}
		} // 如果非會員…就登入會員


		//Kevin 紅利寫入 2020-11-11 這邊的程式碼因為沒考慮到首購，所以搬移到這裡了 by lota
			$sql_order=$this->pdo->query("select * from shoporderform where id='$order_id'");
			$row_order=$sql_order->fetch(PDO::FETCH_ASSOC);
			
			if (isset($_SESSION['use_bonus']) && $_SESSION['use_bonus'] == 1) {
				$sql_del=array(
					"name"=>$row_order['buyer_name'],
					"memberID" => $member_id, //2020-11-11  $this->data['admin_id'] 改用 $member_id
					"orderID" => $_order_number_bonus,//2020-11-11 $save['order_number'] 改用 $_order_number_bonus (1899)
					"bonus" => '-'.$canuse_bonus,
					"ml_key" => 'tw',
					"status" => 2,
				);
				$this->cidb->insert('bonus', $sql_del);
			}
			$date = date("Y-m-d");
			$firstday = date("Y-m-01", strtotime($date));
			$lastday = date("Y-m-d", strtotime("$firstday  4 month -1 day"));
			$new_bonus = floor(($total - $shipping_total) * 0.03);
			$sql_add=array(
				"name"=>$row_order['buyer_name'],
				"memberID" => $member_id, //2020-11-11  $this->data['admin_id'] 改用 $member_id
				"orderID" => $_order_number_bonus,//2020-11-11 $save['order_number'] 改用 $_order_number_bonus (1899)
				"bonus" => $new_bonus,
				"end_time" => $lastday . ' 23:59:59',
				"ml_key" => 'tw',
				"status" => 1,
			);
			$this->cidb->insert('bonus', $sql_add);


		// 寫入地址簿，這裡就一定是會員了哦
		if (
			(isset($_SESSION['save']['member_form_2']['recipient_address_add'])
				and $_SESSION['save']['member_form_2']['recipient_address_add'] == '1')
			or
			($member_address === false)
		) {
			$save = array(
				'customer_id' => $this->data['admin_id'],
				'is_enable' => 1,
			);

			foreach (array('name', 'gender', 'phone', 'mobile', 'addr', 'addr_county', 'addr_district') as $v) {
				$save[$v] = $_SESSION['save']['member_form_2']['recipient_' . $v];
			}

			$this->cidb->insert('customer_address', $save);
		}
	} // 寫入訂單

	//var_dump($_SESSION);die;

	// render前的準備
	$data2[$layoutv3_struct_map_keyname['v3/checkout/step3'][0]]['multi'] = array(
		$payments,
	);

	$data2[$layoutv3_struct_map_keyname['v3/checkout/step3'][0]]['single'] = array(
		$shipment,
		$payment, // 所選取的那筆金流
		$order, // 訂單相關狀態
	);

	$data2[$layoutv3_struct_map_keyname['v3/checkout/orderdetail'][0]]['single'] = array(
		$shipment,
		$payment, // 所選取的那筆金流
		$order, // 訂單相關狀態

		// 從step2那邊copy來的
		$recipient, // 收件人資料
		$invoice_config, // 發票設定
		$invoice, // 發票資訊和備註
	);

	$data2[$layoutv3_struct_map_keyname['v3/checkout/orderdetail'][0]]['multi'] = array(
		$car, // 購物車裡面的東西
		$calculate_logs, // 計算機
	);

	if (isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1') {

		/*
	 * 寄信通知 - for 管理者	by lota
	 *
	 * admin_new_order_notice
	 */

		// 信件格式
		$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic', array(':topic' => '後台新訂單通知', ':type' => 'emailformat', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryRow();

		// 主旨
		$subject = $this->data['sys_configs']['admin_title'] . ' 新進訂單通知';

		if ($emailformat and isset($emailformat['id']) and $emailformat['topic'] != '') {
			$email_topic = $emailformat['topic'];
			$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
			// 記得最後要加上這一行，把多餘的額外欄位刪掉
			for ($x = 65; $x <= (65 + 26); $x++) $email_topic = str_replace('{' . chr($x) . '}', '', $email_topic);
			$subject = $email_topic;

			$aaa_url = aaa_url;
			$aaa_name = $member['name']; //購買者姓名
			$aaa_admin_title = $this->data['sys_configs']['admin_title'];

			//信件內容(TXT版)，由後台撈取
			if ($emailformat and isset($emailformat['id']) and $emailformat['detail'] != '') {
				$email_content = $emailformat['detail'];

				$email_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_content);
				$email_content = str_replace('{BB}', $aaa_name, $email_content);
				$email_content = str_replace('{CC}', $aaa_url, $email_content);

				// 記得最後要加上這一行，把多餘的額外欄位刪掉
				for ($x = 65; $x <= (65 + 26); $x++) $email_content = str_replace('{' . chr($x) . '}', '', $email_content);

				$body = $email_content;
			}

			//信件內容(HTML版)，由後台撈取
			if ($emailformat and isset($emailformat['id'])) {
				if ($emailformat['field_tmp'] != '') {
					$email_html_content = $emailformat['field_tmp'];

					$email_html_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_html_content);
					$email_html_content = str_replace('{BB}', $aaa_name, $email_html_content);
					$email_html_content = str_replace('{CC}', $aaa_url, $email_html_content);

					// 記得最後要加上這一行，把多餘的額外欄位刪掉
					for ($x = 65; $x <= (65 + 26); $x++) $email_html_content = str_replace('{' . chr($x) . '}', '', $email_html_content);

					$body_html = $email_html_content;
				} elseif ($emailformat['field_tmp'] == '' and $emailformat['detail'] != '') {
					$body_html = nl2br($email_content);
				}
			}
		} else {
			$embeddedimages = array();
			$embeddedimages[] = array(
				'path' => _BASEPATH . '/../images/sendmail_title.png',
				'cid' => 'logo',
			);

			$body_type = '1'; // body
			$mail_type = '1'; // admin

			ob_start();
			include _BASEPATH . '/../view/mail_template/new_order_notice.php';
			$body = ob_get_contents();
			ob_end_clean();

			$body_type = '2'; // body_html
			$mail_type = '1'; // admin

			ob_start();
			include _BASEPATH . '/../view/mail_template/new_order_notice.php';
			$body_html = ob_get_contents();
			ob_end_clean();
		} // emailformat

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1', array(':type' => 'email', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1', array(':type' => 'email', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryAll();

		if ($from and !empty($from) and isset($from['id']) and isset($from['email']) and $tos and !empty($tos) and isset($tos[0]['id'])) { //後台信箱有設定才會寄信

			if (isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail') {
				$this->email_send_to_by_sendmail($from, $tos, $subject, $body, $body_html, null);
			} else {
				$this->email_send_to_v2($from, $tos, $subject, $body, $body_html, null);
			}
		}

		/*
	 * 寄信通知 - for 消費者 by lota
	 *
	 * user_new_order_notice
	 */

		$to = (isset($_SESSION['authw_admin_account']) && $_SESSION['authw_admin_account'] != '') ? $_SESSION['authw_admin_account'] : $member['login_account']; //購買者信箱

		// 信件格式
		$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic', array(':topic' => '新進訂單通知', ':type' => 'emailformat', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryRow();

		// 主旨
		$subject = $this->data['sys_configs']['admin_title'] . ' 新進訂單通知';

		if ($emailformat and isset($emailformat['id']) and $emailformat['topic'] != '') {
			$email_topic = $emailformat['topic'];
			$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
			// 記得最後要加上這一行，把多餘的額外欄位刪掉
			for ($x = 65; $x <= (65 + 26); $x++) $email_topic = str_replace('{' . chr($x) . '}', '', $email_topic);
			$subject = $email_topic;

			$aaa_url = aaa_url;
			$aaa_name = $member['name']; //購買者姓名
			$aaa_admin_title = $this->data['sys_configs']['admin_title'];

			//信件內容(TXT版)，由後台撈取
			if ($emailformat and isset($emailformat['id']) and $emailformat['detail'] != '') {
				$email_content = $emailformat['detail'];

				$email_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_content);
				$email_content = str_replace('{BB}', $aaa_name, $email_content);
				$email_content = str_replace('{CC}', $aaa_url, $email_content);

				// 記得最後要加上這一行，把多餘的額外欄位刪掉
				for ($x = 65; $x <= (65 + 26); $x++) $email_content = str_replace('{' . chr($x) . '}', '', $email_content);

				$body = $email_content;
			}

			//信件內容(HTML版)，由後台撈取
			if ($emailformat and isset($emailformat['id'])) {
				if ($emailformat['field_tmp'] != '') {
					$email_html_content = $emailformat['field_tmp'];

					$email_html_content = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_html_content);
					$email_html_content = str_replace('{BB}', $aaa_name, $email_html_content);
					$email_html_content = str_replace('{CC}', $aaa_url, $email_html_content);

					// 記得最後要加上這一行，把多餘的額外欄位刪掉
					for ($x = 65; $x <= (65 + 26); $x++) $email_html_content = str_replace('{' . chr($x) . '}', '', $email_html_content);

					$body_html = $email_html_content;
				} elseif ($emailformat['field_tmp'] == '' and $emailformat['detail'] != '') {
					$body_html = nl2br($email_content);
				}
			}
		} else {
			$embeddedimages = array();
			$embeddedimages[] = array(
				'path' => _BASEPATH . '/../images/sendmail_title.png',
				'cid' => 'logo',
			);

			$body_type = '1'; // body
			$mail_type = '2'; // user

			ob_start();
			include _BASEPATH . '/../view/mail_template/new_order_notice.php';
			$body = ob_get_clean();

			$body_type = '2'; // body_html
			$mail_type = '2'; // user

			ob_start();
			include _BASEPATH . '/../view/mail_template/new_order_notice.php';
			$body_html = ob_get_clean();
		} // emailformat

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1', array(':type' => 'email', ':ml_key' => $this->data['ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		//$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

		if ($from and !empty($from) and isset($from['id']) and isset($from['email']) and $to != '') { //後台信箱有設定才會寄信

			if (isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail') {
				$this->email_send_to_by_sendmail($from, array(array('name' => '', 'email' => $to)), $subject, $body, $body_html, null);
			} else {
				$this->email_send_to_v2($from, array(array('name' => '', 'email' => $to)), $subject, $body, $body_html, null);
			}			
		}
	}



	/*
	 * 這裡會清除此次購物的相關資料，因為購物完成了
	 * 這個動作，移至view/step3去做
	 */
	// if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){
	// 	unset($_SESSION['save']);
	// 	unset($_SESSION[$this->data['router_method']]); // 這一行移到View裡面去做，不然會報錯
	// }

}
