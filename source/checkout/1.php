<?php

// 第一步驟，不需要顯示、以及處理第二步驟的問題
if(!empty($error_logs)){
	foreach($error_logs as $k => $v){
		if($v[2] != 1){
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
if($ajax == 1){
	if(!empty($error_logs)){
		if(defined('ENVIRONMENT') and ENVIRONMENT == 'development'){
			echo 'alert(\''.$error_logs[0][1].'\');';
			// echo 'alert(\''.$error_logs[0][1].' ('.$error_logs[0][0].')\');';
		} else {
			echo 'alert(\''.$error_logs[0][1].'\');';
		}
	} else {
		echo 'window.location.href="checkout_'.$this->data['ml_key'].'.php?step=2";';
	}
	die;
}

include 'source/shop/log_save_include.php';

//加購產品用stary-----------------------------------------------------------------------------------------------------------------------------------	
$increase_array=array();
$a=0;
$items2 = array();
$rows = $this->db->createCommand()->from($prefix)->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00") and is_enable=1 and is_increase_purchase=1 and ml_key=:ml_key ',array(':ml_key'=>$this->data['ml_key']))->order('RAND()')->queryAll();
if(isset($rows)){
	foreach($rows as $k => $v){
		$v['has_additional_purchase'] = 1;
		include 'source/shop/shop_list_foreach_include.php';
		// 如果同產品(不用同規格)，己有加購過的產品，會做focus的動作，而且只有這裡有做，但是如果是在其它位置買同品項的產品，這裡是不會顯示的
		if($car and !empty($car)){
			foreach($car as $kk => $vv){
				if($vv['from'] == 'ap' and $v['id'] == $vv['item']['id']){
					$v['has_ap_in_car'] = true;
					break;
				}
			}
		}
		$rows[$k] = $v;
	}
}
$items2= $rows;
include 'source/shop/spec_float_include.php'; 
$increase_purchases = $items2;
unset($items2);
//加購產品用end---------------------------------------------------------------------------------------------------------------------------------------	
//滿額加購產品用stary-----------------------------------------------------------------------------------------------------------------------------------	
$ipromo_array=array();
$a=0;
$items2 = array();
$rows = $this->db->createCommand()->from($prefix)->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00") and is_enable=1 and is_promo=1 and ml_key=:ml_key ',array(':ml_key'=>$this->data['ml_key']))->order('RAND()')->queryAll();
if(isset($rows)){
	foreach($rows as $k => $v){
		$v['has_additional_promo'] = 1;
		include 'source/shop/shop_list_foreach_include.php';
		// 如果同產品(不用同規格)，己有滿額加購過的產品，會做focus的動作，而且只有這裡有做，但是如果是在其它位置買同品項的產品，這裡是不會顯示的
		if($car and !empty($car)){
			foreach($car as $kk => $vv){
				if($vv['from'] == 'ap' and $v['id'] == $vv['item']['id']){
					$v['has_ap_in_car'] = true;
					break;
				}
			}
		}
		$rows[$k] = $v;
	}
}
$items2= $rows;
include 'source/shop/spec_float_include.php'; 
$ipromo_array = $items2;
unset($items2);
//滿額加購產品用end---------------------------------------------------------------------------------------------------------------------------------------	

/*
 * 第一步驟在做的事
 */

// 加購的產品
$rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and is_additional_purchase=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('RAND()')->queryAll();
if(isset($rows)){
	foreach($rows as $k => $v){
		$v['has_additional_purchase'] = 1;
		include 'source/shop/shop_list_foreach_include.php';
		// 如果同產品(不用同規格)，己有加購過的產品，會做focus的動作，而且只有這裡有做，但是如果是在其它位置買同品項的產品，這裡是不會顯示的
		if($car and !empty($car)){
			foreach($car as $kk => $vv){
				if($vv['from'] == 'ap' and $v['id'] == $vv['item']['id']){
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
if($car and !empty($car)){
	foreach($car as $k => $v){
		$tmps = $v['item'];
		$tmps['id_key_name'] = $k;
		unset($v['item']);
		foreach($v as $kk => $vv){
			if($kk == 'specs'){
				$tmps[$kk.'_data'] = $vv;
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

$view_file = LAYOUTV3_THEME_NAME.'/widget/add_cart_panel';
if(isset($layoutv3_struct_map_keyname[$view_file][1])){
	$data[$layoutv3_struct_map_keyname[$view_file][1]] = $items2; 
}

$view_file = LAYOUTV3_THEME_NAME.'/end/shop';
if(isset($layoutv3_struct_map_keyname[$view_file][1])){
	$data[$layoutv3_struct_map_keyname[$view_file][1]] = $items2;
}

$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/step1'][0]]['multi'] = array(
	//$physicals, // 物流(移到第二步驟)
	$car, // 購物車裡面的東西
	$calculate_logs, // 計算機
	$how_much_difference, // 你只差多少
	$error_logs, // 錯誤訊息
	$additional_purchases, // 加購(簡稱ap)
);
$data2[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/checkout/step1'][0]]['single'] = array(
	// 會員的紅利，還有會員和非會員的優惠卷
	array(
		'bonus_can_use' => $bonus_can_use,
		'bonus_total' => $bonus_total,
	), 
);
//處理要提供給fb或google轉換碼使用的資料 by lota
foreach($calculate_logs as $k => $v){
	if($v[0] == t('總計')){
		$data['conversion_code']['calculate_logs']['total_money'] = str_replace(',','',str_replace('$','',$v[1]));
	}
	if($v[0] == t('運費')){
		$data['conversion_code']['calculate_logs']['freight'] = str_replace(',','',str_replace('$','',$v[1]));
	}
}

//預設金流選項及物流選項 2021-01-28 by lota
if(!isset($_SESSION['save']['selecxt_payment']['func'])){
 	$_SESSION['save']['selecxt_payment']['func'] = 'atm';
}

if(isset($_SESSION['save']['selecxt_payment']['func']) && $_SESSION['save']['selecxt_payment']['func'] == 'atm' && !isset($_SESSION['save']['selecxt_physical']['func'])){
	$_SESSION['save']['selecxt_physical']['func'] = 'home_delivery';
}
//滿額加購價檢測  價格是否達到門檻
$promotext='';
$all_total=0;
$to_fullcount=false;
$data['conversion_code']['calculate_logs']['no_promo_total']=0;//不包含滿額加價購的產品價格最終(已折價)
//活動產品的折價(不包含滿額加價購產品)
if(isset($no_promo_match_total) && !empty($no_promo_match_total)){
	$data['conversion_code']['calculate_logs']['no_promo_total']+=$no_promo_match_total;
}
//不滿足活動條件的產品價格 && 價算優惠券後的價格
if(isset($no_promo_total) && !empty($no_promo_total)){
	$data['conversion_code']['calculate_logs']['no_promo_total']=$no_promo_total;
}
if(!isset($data['conversion_code']['calculate_logs']['no_promo_total']) || $data['conversion_code']['calculate_logs']['no_promo_total']==0){
	if(isset($data['conversion_code']['calculate_logs']['freight'])){
		$all_total=$data['conversion_code']['calculate_logs']['total_money']-$data['conversion_code']['calculate_logs']['freight'];
	}else{
		if(isset($data['conversion_code']['calculate_logs']['total_money'])){
			$all_total=$data['conversion_code']['calculate_logs']['total_money'];
		}
		
	}
}else{
	if(isset($data['conversion_code']['calculate_logs']['no_promo_total'])){
		$all_total=$data['conversion_code']['calculate_logs']['no_promo_total'];
	}
}
$data['conversion_code']['calculate_logs']['promo_total']=$all_total;
// echo $all_total;
// print_r($_SESSION['save']['shop_car']);die;
if(isset($_SESSION['save']['shop_car']) && !empty($_SESSION['save']['shop_car'])){
	foreach($_SESSION['save']['shop_car'] as $k => $v){
		//是否有滿額加價購商品
		if(stristr($k,'promo')!==false){
			$to_fullcount=true;
		};
	}
	if($to_fullcount==true){
		unset($_constant2);
		eval('$_constant2 = '.strtoupper('shop_promo_price').';');
		if($all_total<$_constant2){
			foreach($_SESSION['save']['shop_car'] as $k => $v){
				if(stristr($k,'promo')!==false){
					unset($_SESSION['save']['shop_car'][$k]);
					$promotext=t('已刪除滿額加購產品，因餘額未達到滿額加購門檻(須達到$'.$_constant2.'元)');
				};
			}
			if(isset($promotext)){				
				echo '<script type="text/javascript">alert("'.$promotext.'");window.location.reload()</script>';
				;
			}
		}
	}
}