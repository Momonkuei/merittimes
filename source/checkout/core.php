<?php


// 一般區塊 - 資料指定 - 範本
$view_file = LAYOUTV3_THEME_NAME.'/sub_page_title';
if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	$data[$layoutv3_struct_map_keyname[$view_file][0]] = array('name' => t('商品結帳'),'sub_name' => '');
}

// var_dump($_SESSION);die;

$prefix = 'shop';
$error_logs = array();

//2017/6/27 將運費做資料庫連結處理(lota)
$lll = array('normal','free','price1','price2','low_temperature','low_temperature_free','islands');//2021-06-30 加入低溫免運
foreach ($lll as $k => $v) {
	if(isset($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']])){
		$shipment[$v] = (int)($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']]);
	}
}

//因為單頁資料改為新版，要重新套用資料 2020-12-11
//隱私權
$_shoparticle2 = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','shoparticle5')->get('html')->row_array();
$this->data['sys_configs']['shoparticle2_'.$this->data['ml_key']] = $_shoparticle2['detail'];

foreach(array('payment_atm_bank_code','payment_atm_account') as $v){
	if(isset($this->data['sys_configs'][$v.'_'.$this->data['ml_key']]) and $this->data['sys_configs'][$v.'_'.$this->data['ml_key']] != ''){
		$newname = str_replace('payment_','',$v);
		$this->data['atm_config'][$newname] = $this->data['sys_configs'][$v.'_'.$this->data['ml_key']];
	}
}

// 物流
$physicals = array();
if(isset($physicals_tmp) and !empty($physicals_tmp)){
	foreach($physicals_tmp as $k => $v){

		// 先處理物流原資料
		$physicals[$v['func']] = $v;

		// 再處理資料表運費 2017-06-27 lota 
		foreach ($lll as $k1 => $v1) {
			//if(!isset($physicals[$v['func']][$v1])){ //2021-06-30 改為有無key值全部複寫，如果有需要獨立使用設定檔要記得取消註解 by lota
				$physicals[$v['func']][$v1] = $shipment[$v1];
			//}
		}
	}	
}

/*
 * 金流
 */
//var_dump($this->data['sys_configs']);
$payments = array();
if(isset($payments_tmp) and !empty($payments_tmp)){
	foreach($payments_tmp as $k => $v){
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

//將後台的金流描述帶入資料流
foreach(array('atm','cash_on_delivery','ecpay_credit_card','ecpay_cvs','ecpay_barcode','ecpay_webatm','ecpay_vatm','paypal') as $v){
	if(
		isset($this->data['sys_configs']['payment_'.$v.'_'.$this->data['ml_key']])
		and trim($this->data['sys_configs']['payment_'.$v.'_'.$this->data['ml_key']]) != ''
		and isset($payments[$v])
	){
		$payments[$v]['description'] = nl2br($this->data['sys_configs']['payment_'.$v.'_'.$this->data['ml_key']]);
	}
}

// 覆寫物流的基本運費 for 超商
foreach(array('ecpay_711_no_payment_for_pickup_normal','ecpay_fami_no_payment_for_pickup_normal') as $v){
	if(
		isset($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']])
		and trim($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']]) != ''
		and isset($physicals[str_replace('_normal','',$v)])
	){
		$physicals[str_replace('_normal','',$v)]['normal'] = nl2br($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']]);
	}
}

//將後台的物流描述帶入資料流
foreach(array('home_delivery','ecpay_711_no_payment_for_pickup','ecpay_fami_no_payment_for_pickup') as $v){
	if(
		isset($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']])
		and trim($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']]) != ''
		and isset($physicals[$v])
	){
		$physicals[$v]['description'] = nl2br($this->data['sys_configs']['shipment_'.$v.'_'.$this->data['ml_key']]);
	}
}

if(isset($_SESSION['save']['selecxt_payment']['func'])){
	// 傳承
	if(isset($payments[$_SESSION['save']['selecxt_payment']['func']])){
		$payment = $payments[$_SESSION['save']['selecxt_payment']['func']];
	}

	// 當金流選擇貨到付款的時候，就不會出現物流，而且還會取消之前使用者所點選的
	if($_SESSION['save']['selecxt_payment']['func'] == 'cash_on_delivery'){
		$shipment['func'] = 'cash_on_delivery';

		//2021-05-16 加入是否代收款項的判斷，有代收的話在貨到付款才會出現 by lota
		foreach($physicals as $key => $value){
		    if(isset($value['is_collection']) && $value['is_collection']==true){
		        //nothing
		    }else{
		        unset($physicals[$key]);
		        if(isset($_SESSION['save']['selecxt_physical']['func']) && $_SESSION['save']['selecxt_physical']['func']==$key){
		            unset($_SESSION['save']['selecxt_physical']['func']);
		        }
		        
		    }
		}

		// $physicals = array();
		// unset($_SESSION['save']['selecxt_physical']);
	}else{ //判斷不是貨到付款的情況下，預設要不要出現超商選項 用是否代收款項決定，沒有代收就可以出現
	    foreach($physicals as $key => $value){
		    if((isset($value['is_collection']) && $value['is_collection']==false) or !isset($value['is_collection']) ){
		       //nothing
		    }else{
		         unset($physicals[$key]);
		    }
	    }
	}
} else {
	// 因為沒有選的關係，直接清空它
	$payment = array();

	$error_logs[] = array(
		'payment_no_select',
		t('請先選擇付款方式'),
		2, // 第幾步驟
	);
}

if(isset($_SESSION['save']['selecxt_physical']['func'])){
	// 繼承
	if(isset($physicals[$_SESSION['save']['selecxt_physical']['func']])){		
		// 先針對物流
		foreach($physicals[$_SESSION['save']['selecxt_physical']['func']] as $k => $v){
			if(!in_array($k, $lll)){
				$shipment[$k] = $v;
			}
		}

		// 針對資料表運費 2017-06-27 lota
		foreach ($lll as $k => $v) {
			if(isset($physicals[$_SESSION['save']['selecxt_physical']['func']][$v])){
				$shipment[$v] = $physicals[$_SESSION['save']['selecxt_physical']['func']][$v];
			}
		}
	}
	// 檢查是不是自己的離島被勾
	if(isset($_SESSION['save']['selecxt_physical']['is_islands']) and $_SESSION['save']['selecxt_physical']['is_islands'] != $_SESSION['save']['selecxt_physical']['func']){
		unset($_SESSION['save']['selecxt_physical']['is_islands']);
	}

	if(preg_match('/^ecpay_(711|fami)_no_payment_for_pickup$/', $_SESSION['save']['selecxt_physical']['func'])
		and (!isset($_SESSION['save']['selecxt_physical']['params']) or empty($_SESSION['save']['selecxt_physical']['params']))
	){
		$error_logs[] = array(
			'shipment_no_select_store_name',
			t('請選擇超商'),
			2, // 第幾步驟
		);
	}
} else {
	// if(!empty($physicals_tmp)){
	if(!empty($physicals) and (!isset($_SESSION['save']['selecxt_physical']) and !isset($_SESSION['save']['selecxt_physical']['func']) or (isset($_SESSION['save']['selecxt_physical']['func']) && $_SESSION['save']['selecxt_physical']['func'] == '') )){// 有物流的情況，就要檢查下列的項目
		// 因為沒有選的關系，直接清空它
		// 這裡會引發問題，暫時先註解起來 by lota say
		//$shipment = array();

		$error_logs[] = array(
			'shipment_no_select',
			t('請先選擇運送方式'),
			2, // 第幾步驟
		);
		
	}
}

// 先把規格的session給清掉，這行是從產品內頁複製過來的
unset($_SESSION['save'][$prefix.'_spec']);

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

$admin_field_router_class = $prefix.'spec';
$admin_field_section_id = 0;
include 'source/system/admin_field_get.php';

$ajax = '';
if(isset($_GET['ajax'])){
	$step = $ajax = intval($_GET['ajax']);
	$_SESSION[$this->data['router_method']]['step'] = $step;
	if(isset($_GET['go_to_step2'])){
		$_SESSION['save']['step2']['go_to_step2'] = $_GET['go_to_step2'];
	}
	

}

if(isset($_GET['step'])){
	$step = (int)$_GET['step'];
	if($step <= 0 or $step > 3){
		$step = 1;
	}
	$_SESSION[$this->data['router_method']]['step'] = $step;

	// 這裡會導致大問題哦！千萬不要打開
	//header('Location: '.$this->data['router_method'].'_'.$this->data['ml_key'].'.php');
}

// 預設是步驟一
if(!isset($_SESSION[$this->data['router_method']]['step']) or $_SESSION[$this->data['router_method']]['step'] == ''){
	$_SESSION[$this->data['router_method']]['step'] = '1';
}

// 目前有跟source/core/end.php共用
// include 'checkout_include_a_v1.php';
include 'source/shop/checkout_include_a_v2.php';

$step2_javascript_evals = array(); // 步驟2專用的javascript_evals = array(); // 步驟2專用的
// no_promo_match
// 接下來處理活動
if($match and !empty($match)){
	// @k promotion_id
	foreach($match as $k => $v){
		if(isset($v['condition']) && $v['condition'] == '1' and $v['match'] === true){

			$promotion = $v['promotion'];

			if($promotion['action1'] == '1'){ // 折扣(例88)(折)
				eval('$v[\'result\'] = round2($v[\'total\'] * 0.'.$promotion['action2'].',0);');
				$_cal = array($promotion['name'], '-' . number_format($v['total'] - $v['result']));
			} elseif($promotion['action1'] == '2'){ // 定額(元)
				$v['result'] = $promotion['action2'];
				$_cal = array($promotion['name'], '-' . number_format($v['total'] - $v['result']));
			} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota
				$v['result'] = $v['total'] - $promotion['action2'];
				$_cal = array($promotion['name'], '-' . number_format($promotion['action2']));

				$result2 = $v['result'];
			}

			$calculate_logs[] = $_cal;

			// $calculate_logs[] = array(
			// 	$promotion['name'], '-'.number_format($v['total'] - $v['result']),
			// );

			if($promotion['free_delivery'] != ''){
				$calculate_logs[] = array(
					t('贈送'), '└ '.$promotion['free_delivery'],
				);
			}

			// 促銷方案中的運費計算
			$total += $v['result'];
			if($promotion['has_free_shipping'] == 1){
				// 當然，符合條件的話，就不用累加金額到運費計算，但是其它有可能要
				// do nothing
			} else {
				// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
				$shipping_total_target += $v['result'];
			}
			$match[$k] = $v;
		} elseif(isset($v['condition']) && $v['condition'] == '2' and isset($v['handle_1']) and !empty($v['handle_1'])){
			$promotion = $v['promotion'];

			// @kk 流水號，從1開始，沒意義
			// @vv 符合的多個產品，以1為單位，1筆就是數量1
			foreach($v['handle_1'] as $kk => $vv){
				$_count = count($vv);
				if($_count == $promotion['condition2']){ // 符合的情況
					$xx = array();
					$xx['total'] = 0;

					// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
					foreach($vv as $kkk => $vvv){
						$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
					}

					if ($promotion['action1'] == '1') { // 折扣(例88)(折)
						eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.' . $promotion['action2'] . ',0);');
						$_cal = array($promotion['name'], '-' . number_format($xx['total'] - $xx['result']));
					} elseif ($promotion['action1'] == '2') { // 定額(元)
						$xx['result'] = $promotion['action2'];
						$_cal = array($promotion['name'], '-' . number_format($xx['total'] - $xx['result']));
					} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota
						$xx['result'] = $xx['total'] - $promotion['action2'];
						$_cal = array($promotion['name'], '-' . number_format($promotion['action2']));
					}
					$calculate_logs[] = $_cal;

					// if($promotion['action1'] == '1'){ // 折扣(例88)(折)
					// 	eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.'.$promotion['action2'].',0);');
					// } elseif($promotion['action1'] == '2'){ // 定額(元)
					// 	$xx['result'] = $promotion['action2'];
					// }

					// $calculate_logs[] = array(
					// 	$promotion['name'], '-'.number_format($xx['total'] - $xx['result']),
					// );

					if($promotion['free_delivery'] != ''){
						$calculate_logs[] = array(
							t('贈送'), '└ '.$promotion['free_delivery'],
						);
					}

					// 促銷方案中的運費計算
					$total += $xx['result'];
					if($promotion['has_free_shipping'] == 1){
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
					foreach($car as $kkk => $vvv){
						if(isset($vvv['item']['promotion']) and !isset($vvv['item']['promotion']['match_log'])){
							$car[$kkk]['item']['promotion']['match_log'] = t('(沒有完全符合)');
						}
					}

					// 不符合條件的話，就要看設定值了
					if($buy_amount_condition == 1){ // 滿件折抵，不滿件則原價
						// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
						foreach($vv as $kkk => $vvv){
							$total += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
							$shipping_total_target += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
						}
					} elseif($buy_amount_condition == 2){ // 超件按%換算單價金額
						if($kk > 1){ // 代表不滿數量，一樣照原價
							// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
							foreach($vv as $kkk => $vvv){
								$total += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								$shipping_total_target += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
							}
						} else { // 代表超過數量
							if($promotion['action1'] == '1'){ // 折扣(例88)(折)

								// 超過的都是一樣的折扣，假設八折，就把超過但不滿數量的都八折 2017/02/06李哥早上8點45分說的
								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach($vv as $kkk => $vvv){
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}

								// 都用同樣的折數
								eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.'.$promotion['action2'].',0);');

								$calculate_logs[] = array(
									$promotion['name'], '-'.number_format($xx['total'] - $xx['result']),
								);

								// 促銷方案中的運費計算
								$total += $xx['result'];
								// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
								$shipping_total_target += $xx['result'];
								$match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果
							} elseif($promotion['action1'] == '2'){ // 定額(元)
								eval('$unit = round2($promotion[\'action2\'] / $promotion[\'condition2\']);');
								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach($vv as $kkk => $vvv){
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach($vv as $kkk => $vvv){
									$xx['result'] += $unit * 1; // 反正1筆就是1個
								}

								$calculate_logs[] = array(
									$promotion['name'], '-'.number_format($xx['total'] - $xx['result']),
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
$no_promo_match_total=0;//活動折價後的產品價格(不包含滿額加價購)
$match_id_array=array();//活動產品的ID
//計算不包含滿額加價購的活動折價
if($no_promo_match and !empty($no_promo_match)){
	// @k promotion_id
	foreach($no_promo_match as $k => $v){
		if(isset($v['handle_1']) and !empty($v['handle_1'])){
			foreach($v['handle_1'] as $kk => $vv){
				if(is_array($vv)){
					foreach($vv as $kkk => $vvv){
						if(!in_array($vvv,$match_id_array)){
							$match_id_array[]=$vvv;
						}
					}
				}else{
					if(!in_array($vv,$match_id_array)){
						$match_id_array[]=$vv;
					}
				}
			}
		}
		if(isset($v['condition']) && $v['condition'] == '1' and $v['no_promo_match'] === true){

			$promotion = $v['promotion'];
			
			if($promotion['action1'] == '1'){ // 折扣(例88)(折)
				eval('$v[\'result\'] = round2($v[\'total\'] * 0.'.$promotion['action2'].',0);');
				$_cal = array($promotion['name'], '-' . number_format($v['total'] - $v['result']));
			} elseif($promotion['action1'] == '2'){ // 定額(元)
				$v['result'] = $promotion['action2'];
				$_cal = array($promotion['name'], '-' . number_format($v['total'] - $v['result']));
			} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota
				$v['result'] = $v['total'] - $promotion['action2'];
				$_cal = array($promotion['name'], '-' . number_format($promotion['action2']));

				$result2 = $v['result'];
			}

			$calculate_logs[] = $_cal;

			// $calculate_logs[] = array(
			// 	$promotion['name'], '-'.number_format($v['total'] - $v['result']),
			// );

			// if($promotion['free_delivery'] != ''){
			// 	// $calculate_logs[] = array(
			// 	// 	t('贈送'), '└ '.$promotion['free_delivery'],
			// 	// );
			// }

			// 促銷方案中的運費計算
			$no_promo_match_total += $v['result'];
			if($promotion['has_free_shipping'] == 1){
				// 當然，符合條件的話，就不用累加金額到運費計算，但是其它有可能要
				// do nothing
			} else {
				// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
				$shipping_total_target += $v['result'];
			}
			$no_promo_match[$k] = $v;
		} elseif(isset($v['condition']) && $v['condition'] == '2' and isset($v['handle_1']) and !empty($v['handle_1'])){
			$promotion = $v['promotion'];

			// @kk 流水號，從1開始，沒意義
			// @vv 符合的多個產品，以1為單位，1筆就是數量1
			foreach($v['handle_1'] as $kk => $vv){
				$_count = count($vv);
				if($_count == $promotion['condition2']){ // 符合的情況
					$xx = array();
					$xx['total'] = 0;

					// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
					foreach($vv as $kkk => $vvv){
						$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
					}

					if ($promotion['action1'] == '1') { // 折扣(例88)(折)
						eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.' . $promotion['action2'] . ',0);');
						$_cal = array($promotion['name'], '-' . number_format($xx['total'] - $xx['result']));
					} elseif ($promotion['action1'] == '2') { // 定額(元)
						$xx['result'] = $promotion['action2'];
						$_cal = array($promotion['name'], '-' . number_format($xx['total'] - $xx['result']));
					} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota
						$xx['result'] = $xx['total'] - $promotion['action2'];
						$_cal = array($promotion['name'], '-' . number_format($promotion['action2']));
					}

					// 促銷方案中的運費計算
					$no_promo_match_total += $xx['result'];
					if($promotion['has_free_shipping'] == 1){
						// 當然，符合條件的話，就不用累加金額到運費計算，但是其它有可能要
					} else {
						// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
						$shipping_total_target += $xx['result'];
					}
					$no_promo_match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果
				} else { // 不符合的情況
					foreach($car as $kkk => $vvv){
						if(isset($vvv['item']['promotion']) and !isset($vvv['item']['promotion']['match_log'])){
							$car[$kkk]['item']['promotion']['match_log'] = t('(沒有完全符合)');
						}
					}

					// 不符合條件的話，就要看設定值了
					if($buy_amount_condition == 1){ // 滿件折抵，不滿件則原價
						// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
						foreach($vv as $kkk => $vvv){
							$no_promo_match_total += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
							$shipping_total_target += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
						}
					} elseif($buy_amount_condition == 2){ // 超件按%換算單價金額
						if($kk > 1){ // 代表不滿數量，一樣照原價
							// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
							foreach($vv as $kkk => $vvv){
								$no_promo_match_total += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								$shipping_total_target += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
							}
						} else { // 代表超過數量
							if($promotion['action1'] == '1'){ // 折扣(例88)(折)

								// 超過的都是一樣的折扣，假設八折，就把超過但不滿數量的都八折 2017/02/06李哥早上8點45分說的
								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach($vv as $kkk => $vvv){
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}

								// 都用同樣的折數
								eval('$xx[\'result\'] = round2($xx[\'total\'] * 0.'.$promotion['action2'].',0);');


								// 促銷方案中的運費計算
								$no_promo_match_total += $xx['result'];
								// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
								$shipping_total_target += $xx['result'];
								$no_promo_match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果
							} elseif($promotion['action1'] == '2'){ // 定額(元)
								eval('$unit = round2($promotion[\'action2\'] / $promotion[\'condition2\']);');
								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach($vv as $kkk => $vvv){
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}

								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach($vv as $kkk => $vvv){
									$xx['result'] += $unit * 1; // 反正1筆就是1個
								}

								// 促銷方案中的運費計算
								$no_promo_match_total += $xx['result'];

								// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
								$shipping_total_target += $xx['result'];
								$no_promo_match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果
							} elseif ($promotion['action1'] == '3') { // 折抵(例100)(元) by lota

								$xx = array();
								$xx['total'] = 0;
								$xx['result'] = 0;


								// @vvv 產品的絕對key值(例：normal_PRODUCTID_SPECID)
								foreach ($vv as $kkk => $vvv) {
									$xx['total'] += $car[$vvv]['item']['price'] * 1; // 反正1筆就是1個
								}
								// 促銷方案中的運費計算
								$no_promo_match_total += $xx['result'];
								// 累加計算後的金額，到運費那裡去計算(2017/1/20 am6:55 lota小李哥說的)
								$shipping_total_target += $xx['result'];
								$no_promo_match[$k]['handle_2'][$kk] = $xx; // 記錄計算後的結果

							}
						}
					}
				}
			}
		}
	}
}
// print_r($match_id_array);
$no_promo_total=0;//不在活動的產品價格(不包含滿額加價購)
if($car and !empty($car)){
	foreach($car as $k => $v){
		// print_r($v);die;
		// 應該剩下不在活動內的產品還沒有處理
		if($v['item']['is_increase_purchase']==1){
			$text='ap';
		}else if($v['item']['is_promo']==1){
			$text='promo';
		}else{
			$text='normal';
		}
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

		if(!isset($v['promotion_id'])){
			$shipping_total_target += $item['price'] * $amount;
		 	$total += $item['price'] * $amount;
		}
		
		//活動產品不再計算
		if(isset($match_id_array) && !empty($match_id_array)){
			if(!in_array($text.'_'.$v['item']['id'].'_'.$v['specid'],$match_id_array) && $item['is_promo']=='0'){
				$no_promo_total+=$item['price'] * $amount;
			}
		}else{
			//未加入滿額加價購產品的價格
			if($item['is_promo']=='0'){
				$no_promo_total+=$item['price'] * $amount;
			}
		}
		
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

		// 沒有符合促銷方案的情況
		// if(!$is_handle_shipping_in_promotion){
		// 	$shipping_total_target += $item['price'] * $amount;
		// 	$total += $item['price'] * $amount;
		// }

	}
	if(isset($no_promo_match_total) && !empty($no_promo_match_total)){
		$no_promo_total+=$no_promo_match_total;
	}


	// 檢查優惠卷代碼，有填才會檢查 
	// 2020-09-17 優惠碼原本在運費之下，改到運費之上，方便作折讓完後的金額去運算運費 by lota
	// $_SESSION['save']['goodies_number']['gift_serial_number'] = '20170120162314jdpjQG';
	if(isset($_SESSION['save']['goodies_number']['gift_serial_number'])){
	   	if($_SESSION['save']['goodies_number']['gift_serial_number'] != ''){
			$gift = $_SESSION['save']['goodies_number']['gift_serial_number'];
			//$row = $this->db->createCommand()->from('shopgoodies')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$item['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();

			// 先看一下生效日期有沒有填
			$row = $this->db->createCommand()->from($prefix.'goodies')->where('is_enable=1 and pid!=0 and func=1 and gift_only_use_count>0 and gift_serial_number=:gift',array(':gift'=>$gift))->queryRow();
			if($row and isset($row['id'])){
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
				if($row['gift_only_use_count2'] >= $row['gift_only_use_count']){
					$check_use_count = false;

					unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

					$error_logs[] = array(
						'goodies_guest_gift_only_use_count2',
						t('無效優惠卷代碼:優惠券已使用!'),
						1, // 第幾步驟
					);
				}

				$time = strtotime($row['start_date'].' 00:00:00');
				$time2 = strtotime($row['end_date'].' 23:59:59');
				if($time < 0) $time = 0;
				if($time2 < 0) $time2 = 0;

				//  先檢查時間
				$check_gift_date = true;
				// if($time > 0){ // 起始時間不需要檢查
					$now = strtotime(date('Y-m-d H:i:s'));
					//echo date('Y-m-d H:i:s');
					//echo $now;
					if($now >= $time){
						// OK
					} else {
						$check_gift_date = false;
					}
					if($time2 > 0){
						//echo $now.'<br />';
						//echo $row['end_date'].$time2.'<br />';
						if($now <= $time2){
							// OK
						} else {
							$check_gift_date = false;
						}
					}
				// }

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
				$_total_gift_goal = 0; //設定目標產品的金額總計初始值					
				$ids_tmp = array();
				if($row['related_ids'] != ''){
					$tmpgs = explode(',', $row['related_ids']);
					if(!empty($tmpgs)){
						foreach($tmpgs as $kk => $vv){
							if($vv == ''){
								unset($tmpgs[$kk]);
							}
						}
					}
					$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and id IN ('.implode(',',$tmpgs).')',array(':ml_key'=>$this->data['ml_key']))->queryAll();
					if($rows){
						foreach($rows as $kk => $vv){
							$ids_tmp[$vv['id']] = '1';
						}
					}

					$ids = array();
					if(!empty($ids_tmp)){
						foreach($ids_tmp as $kk => $vv){
							$ids[] = $kk;
						}
					}

					// 2021-06-06 新寫法 by lota									
					foreach($item_ids as $kk => $vv){
						if(in_array($vv, $ids)){							
							//這邊處理目標產品的金額總計計算，給後面的程式去處理 $car 是延續checkout_include_a_v2過來的 2021-06-06 lota fix 
							if($car and !empty($car)){
								foreach ($car as $key => $value) {
									if($value['item']['id'] == $vv){
										$_total_gift_goal += ($value['item']['price'] * $value['amount']);
									}
								}
							}
							$check_gift_limit = true;// 這個標記只能代表目前購物車有目標產品，但不能針對目標產品去計算折扣
							// break; //不要跳出，要檢查全部的購物車產品
						}
					}

					// 2021-06-06 舊的寫法，沒辦法把購物車內的部分產品做優惠券折價
					// foreach($item_ids as $kk => $vv){
					// 	if(in_array($vv, $ids)){
					// 		$check_gift_limit = true;
					// 		break;
					// 	}
					// }
				}else{
					//2020-12-20 改為沒有選擇限定商品則為全站適用 by lota #38303
					$check_gift_limit = true;
				}

				

				// 檢查條件
				$check_gift_condition = false;
				if($row['gift_condition1'] == '1'){
					// 不包含運費的訂單總金額
					if($row['gift_condition2'] > 0 and $total >= $row['gift_condition2']){
						$check_gift_condition = true;
					}
				} elseif($row['gift_condition1'] == '0'){
					$check_gift_condition = true;
				}

				// var_dump($check_member_field);
				// var_dump($check_use_count);
				// var_dump($check_gift_date);
				// var_dump($check_gift_limit);
				// var_dump($check_gift_condition);
				if($check_member_field === true and $check_use_count === true and $check_gift_date === true and $check_gift_limit === true and $check_gift_condition === true){

					// 2021-06-06 by lota
					if($_total_gift_goal!=0){ //目標產品獨立處理
						//先將購物車總金額備份
						$_tmp_total = $total;
						//然後把獨立金額傳到$total讓後面程式去計算
						$total = $total_tmp = $_total_gift_goal;
					}else{
						$total_tmp = $total;
					}			

					if($row['gift_do_type'] == '1'){ // 折扣(例88)(折)
						eval('$total = $total * 0.'.$row['gift_do_value'].';');
						$total = $total_tmp - $total;//2021-06-06 lota fix
					} elseif($row['gift_do_type'] == '2'){ // 折抵(就是減多少錢)
						$total = $total - $row['gift_do_value'];
					}

					$calculate_logs[] = array(
						$row['name'], '-'.number_format($total_tmp - $total),
					);

					if($_total_gift_goal!=0){ //目標產品獨立處理，這邊是計算完後要把$total貼回原來的變數，不然整個購物車金額會錯亂
						$total = $_tmp_total - ($total_tmp - $total);
						unset($_tmp_total);
					}

					//未加入滿額加價購價格------------------------------------------------------------------------------------------------------
					if($_total_gift_goal!=0){ //目標產品獨立處理
						//先將購物車總金額備份
						$_tmp_no_promo_total = $no_promo_total;
						//然後把獨立金額傳到$total讓後面程式去計算
						$no_promo_total = $no_promo_total_tmp = $_total_gift_goal;
					}else{
						$no_promo_total_tmp = $no_promo_total;
					}			

					if($row['gift_do_type'] == '1'){ // 折扣(例88)(折)
						eval('$no_promo_total = $no_promo_total * 0.'.$row['gift_do_value'].';');
						$no_promo_total = $no_promo_total_tmp - $no_promo_total;//2021-06-06 lota fix
					} elseif($row['gift_do_type'] == '2'){ // 折抵(就是減多少錢)
						$no_promo_total = $no_promo_total - $row['gift_do_value'];
					}

					if($_total_gift_goal!=0){ //目標產品獨立處理，這邊是計算完後要把$total貼回原來的變數，不然整個購物車金額會錯亂
						$no_promo_total = $_tmp_no_promo_total - ($no_promo_total_tmp - $no_promo_total);
						unset($_tmp_no_promo_total);
					}
					//-----------------------------------------------------------------------------------------------------------------------------
					
				} else {
					unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

					$goodies_check_error = '';
					foreach(array('check_member_field','check_use_count','check_gift_date','check_gift_limit','check_gift_condition') as $goodies_check){
						eval('if(isset($'.$goodies_check.') and $'.$goodies_check.'===false) $goodies_check_error.="'.$goodies_check.'|";');
					}
					if($check_use_count==false){
						$error_logs[] = array(
							$goodies_check_error,
							t('無效優惠卷代碼:已使用!'),
							1, // 第幾步驟
						);
					}else if($check_member_field==false){
						$error_logs[] = array(
							$goodies_check_error,
							t('無效優惠卷代碼:非限定會員!'),
							1, // 第幾步驟
						);
					}else if($check_gift_date==false){
						$error_logs[] = array(
							$goodies_check_error,
							t('無效優惠卷代碼:尚未開始 or 已過期'),
							1, // 第幾步驟
						);
					}else if($check_gift_condition==false){
						$error_logs[] = array(
							$goodies_check_error,
							t('無效優惠卷代碼:金額不足!'),
							1, // 第幾步驟
						);		
					}else{
						$error_logs[] = array(
							$goodies_check_error,
							t('無效優惠卷代碼!'),
							1, // 第幾步驟
						);
					}
					
				}
			} else {
				unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

				$error_logs[] = array(
					'goodies_guest_not_found',
					t('無效優惠卷代碼:已使用!'),
					1, // 第幾步驟
				);
			}
		} else {
			unset($_SESSION['save']['goodies_number']['gift_serial_number']); // 清空它

			$error_logs[] = array(
				'goodies_guest_is_empty',
				t('無效優惠卷代碼::查無優惠券!'),
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

	if(!empty($shipment)){ // 有選擇物流，才會做運費計算
		$shipping_total_target = $total; //2020-09-17 這邊改用優惠碼折讓完後的金額去比對運費計算 by lota
		if($shipping_total_target > 0 and $shipping_total_target < $shipment['free']){
			if($shipment['price1'] && $shipment['price2']){ // 如果有級距數值，才做相關的運算 by lota
				if($shipment['price1'] <= 0){ // 單一運費
					$shipping_total += $shipment['normal']; // 單一運費的基本費
				} else { // 級距運費
					if($shipping_total_target > $shipment['price1']){
						$shipping_total += $shipment['price2']; // 符合條件的一級運費
					} else {
						$shipping_total += $shipment['normal']; // 級距的基本費
					}
				}
			}else{
				$shipping_total += $shipment['normal']; // 單一運費的基本費
			}				
		}

		$calculate_logs[] = array(
			t('運費'), '$'.number_format($shipping_total),
		);

		// 記得這裡要改寫該筆物流的運費
		if(isset($_SESSION['save']['selecxt_physical']['func'])){
			if(isset($physicals[$_SESSION['save']['selecxt_physical']['func']])){
				$physicals[$_SESSION['save']['selecxt_physical']['func']]['normal'] = $shipping_total;
			}
		}

		// 低溫運費(一次性的費用)
		if($has_low_temperature){
			$calculate_logs[] = array(
				t('低溫運費'), '$'.number_format($shipment['low_temperature']),
			);

			$shipping_total += $shipment['low_temperature'];
		}


		// 離島的運費，這裡記得要判斷SESSION
		if(isset($_SESSION['save']['selecxt_physical']['is_islands']) and $_SESSION['save']['selecxt_physical']['is_islands'] == $_SESSION['save']['selecxt_physical']['func']){
			$calculate_logs[] = array(
				t('離島運費'), '$'.number_format($shipment['islands']),
			);

			$shipping_total += $shipment['islands'];
		}
	}

	

	// 檢查紅利
	if(0 and isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
		// 取得和統計該會員有效的紅利點數
		// 有排序，目的是從舊的紅利開始使用

		// 	bonus_left 就是'紅利點數剩多少', 因為剩多少比較好寫吧
		$bonus_list = $this->db->createCommand()->from($prefix.'goodies')->where('is_enable=1 and pid!=0 and func=2 and bonus_point>0 and bonus_left>0')->order('create_time')->queryAll();
		if($bonus_list){
			foreach($bonus_list as $k => $v){
				$v['time'] = strtotime($v['start_date'].' 00:00:00');
				$v['time2'] = strtotime($v['end_date'].' 00:00:00');
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
						unset($bonus_list[$k]);
						continue;
					}
					if($v['time2'] > 0){
						if($now < $v['time2']){
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
				$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type'=>$prefix.'goodies'.'relatedids',':ml_key'=>$this->data['ml_key'],':id'=>$v['id']))->queryAll();
				if($rows){
					foreach($rows as $kk => $vv){
						$ids_tmp[$vv['other1']] = '1';
					}
				}

				if(!empty($ids_tmp)){
					foreach($ids_tmp as $kk => $vv){
						$ids[] = $kk;
					}
				}

				// 檢查這次購買的商品清單，能夠使用的紅利
				// 因為有些紅利是限制商品和分類的
				// 但是如果沒有指定商品，那這裡就不用檢查，表示都可以
				if(!empty($car) and !empty($ids)){
					$check_in_list = true;
					foreach($car as $k => $v){
						if(!in_array($v['item_id'],$ids)){
							$check_in_list = false;
							break;
						}
					}
					if(!$check_in_list){
						unset($bonus_list[$k]);
						continue;
					}
				}

				// 看一下總額有沒有符合條件
				if($total < $v['bonus_condition']){
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
		if(isset($_SESSION['save']['use_bonus']['use']) and $_SESSION['save']['use_bonus']['use'] == '1' and $bonus_can_use > 0){
			$total = $total - $bonus_list[0]['bonus_left'];

			$calculate_logs[] = array(
				$bonus_list[0]['name'], '-'.number_format($bonus_list[0]['bonus_left']),
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

	$calculate_logs[] = array(
		t('總計'), '$'.number_format($total),
	);
	// if(!empty($no_promo_total)){
	// 	$calculate_logs[] = array(
	// 		t('未計算滿額加價購價格'), '$'.number_format($no_promo_total),
	// 	);
	// }
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

if($_SESSION[$this->data['router_method']]['step'] == 1){
	include 'source/checkout/1.php';
}

if($_SESSION[$this->data['router_method']]['step'] > 1){
	include 'source/checkout/23.php';
}

if($_SESSION[$this->data['router_method']]['step'] == 2){
	include 'source/checkout/2.php';
}

if($_SESSION[$this->data['router_method']]['step'] == 3){
	include 'source/checkout/3.php';
}
