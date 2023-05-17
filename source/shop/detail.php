<?php

$prefix = str_replace('detail','',$this->data['router_method']);

// 先把規格的session給清掉
unset($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_spec'][$_GET['id']]);

// 檢查產品是否存在
$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id']);
$o = $o->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")');
$row = $o->get($prefix)->row_array();

if($row and !empty($row) and isset($row['id'])){
	// do nothing
} else {
	// 沒有詢問物件的話就轉跳到有詢問的地方 by lota 2018/6/13
	if(1){
		$redirect_url = $prefix.$url_suffix;		
		G::alert_and_redirect(t('產品不存在或是已下架'), $redirect_url, $this->data);
	} else { // A方案
?>
<script type="text/javascript" m="body_end">
	$(document).ready(function() {
		alert('<?php echo t('產品不存在或是已下架','tw')?>');
		window.location.href='<?php echo $prefix?>_<?php echo $this->data['ml_key']?>.php';
	});
</script>	
<?php
	}
}


// 預設會有1的數量
// $_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_spec'][$_GET['id']] = array(
// 	'amount' => 1,
// );

$data2[$ID] = array(
	'single' => array(),
	'multi' => array(),
);

/*
 * 產品
 */

$item = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and id=:id',array(':id'=>$_GET['id']))->queryRow();
// name2 型號
// detail 簡述
$item['content1'] = $item['detail2'];
$item['content2'] = $item['detail3'];

$admin_field_router_class = str_replace('detail', '', $this->data['router_method']);
$admin_field_section_id = 1;
include 'source/system/admin_field_get.php';

if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
	if($admin_field['detail']['type'] == 'textarea'){
		$item['detail'] = nl2br($item['detail']); // ckeditor_js 預設編輯器輸出
	}
}

// 預設價格
$item['price'] = 0;
$item['price2'] = 0;

// $item['price'] = '$'.number_format($item['price']);
// $item['price2'] = '$'.number_format($item['price2']);

// 檢查收藏
$item['has_favorite'] = 0;
if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
	$row_fav = $this->db->createCommand()->from('html')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$item['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
	if(isset($row_fav['id']) and $row_fav['id'] > 0){
		$item['has_favorite'] = 1;
	}
} else {
	if(isset($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite']) and !empty($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'])){
		foreach($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'] as $k => $v){
			if(preg_match('/^'.$item['id'].'_(\d+)$/', $k)){
				$item['has_favorite'] = 1;
				break;
			}
		}
	}
}

// 規格
// $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>str_replace('detail','',$this->data['router_method']).'spec',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// $rows_tmp = array();
// if($rows){
// 	foreach($rows as $k => $v){
// 		$rows_tmp[$v['id']] = $v;
// 	}
// }

/*
 * 加價購
 * 單一價格
 * 單一規格
 */
$increase_purchases = array();
if($item['increase_purchase_ids'] != '' and preg_match('/^,(.*),$/', $item['increase_purchase_ids'], $matches)){
	$tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and id IN ('.$matches[1].')')->queryAll();
	$tmps_tmp = array();

	$tmps2 = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'spec')->where('is_enable=1 and data_id IN ('.$matches[1].')')->queryAll();
	$tmps_tmp2 = array();
	if($tmps2){
		foreach($tmps2 as $k => $v){

			// 第一種規格的情況，只有數量，沒有規格
			if(!isset($tmps_tmp2[$v['data_id']])){
				$tmps_tmp2[$v['data_id']] = $v;
			}

			// 第二種規格的情況，只有規格，只有數量
			// $tmps_tmp2[$v['data_id']][] = $v;
		}
	}

	if($tmps){
		foreach($tmps as $k => $v){
			if($v['price3'] <= 0) continue; 
			if(!isset($tmps_tmp2[$v['id']])) continue; 

			// 第一種規格的情況，只有數量，沒有規格
			$v['field1'] = 'specid';
			$v['field2'] = 'amount';
			$v['field1_value'] = $tmps_tmp2[$v['id']]['specid'];
			$v['list'] = array(
				array('name'=>'1','value'=>'1'),
				array('name'=>'2','value'=>'2'),
				array('name'=>'3','value'=>'3'),
				array('name'=>'4','value'=>'4'),
				array('name'=>'5','value'=>'5'),
			);
			if($tmps_tmp2[$v['id']]['inventory'] <= 0){
				$v['disabled'] = '';
			}

			// 第二種規格的情況，只有規格，只有數量
			// $v['field1'] = 'amount';
			// $v['field2'] = 'specid';
			// $v['field1_value'] = 1;
			// $v['list'] = array();
			// foreach($tmps_tmp2[$v['id']] as $kk => $vv){
			// 	 $tmp = array(
			// 		'name' => $rows_tmp[$vv['specid']]['topic'],
			// 		'value' => $vv['specid'],
			// 	);
			//  	if($vv['inventory'] <= 0){
			//  		$tmp['disabled'] = '';
			//  	}
			//  	$v['list'][] = $tmp;
			// }

			$v['price'] = '$'.number_format($v['price3']);
			$v['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$v['pic1'];
			$v['url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).'detail'.$url_suffix.'?id='.$v['id'];

			$tmps_tmp[$k] = $v;
		}
	}
	$increase_purchases = $tmps_tmp;
}


/*
 * 取得所屬的促銷方案(第一個符合的) 2020-11-23 移動到規格列表的上面,加價購的下面 讓參數可以給規格用 by lota
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
//var_dump($multi_item);die;
//var_dump($multi_item_tmp);die;

$item['promotion'] = array();
$tmps2 = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'promotion')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
if($tmps2){
	foreach($tmps2 as $k => $v){

		//2020-11-23 如果主題活動條件為"滿件"而且數量為"1" lota
		if($v['condition1']=='2' && $v['condition2']=='1'){
			// var_dump($v);die;
			$v['run_action1'] = $v['action1'];
			$v['run_action2'] = $v['action2'];
		}

		$v['url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix.'?id=s'.$v['id'];
		$v['parent_id'] = 0;

		$v['time'] = strtotime($v['start_time']);
		$v['time2'] = strtotime($v['end_time']);
		if($v['time'] < 0) $v['time'] = 0;
		if($v['time2'] < 0) $v['time2'] = 0;

		//  先檢查時間
		// if($v['time'] > 0){ //不需要判斷啟始時間 by lota fix 2020-11-16
			$now = strtotime(date('Y-m-d H:i:s'));
			//echo date('Y-m-d H:i:s');
			//echo $now;die;
			if($now >= $v['time']){
				// OK
			} else {
				unset($tmps2[$k]);
				continue;
			}
			if($v['time2'] > 0){
				if($now < $v['time2']){
					// OK
				} else {
					unset($tmps2[$k]);
					continue;
				}
			}
		// }

		if($v['class_ids'] != '' and $v['scope'] == '0'){
			$class_ids = explode(',', $v['class_ids']);
			if($class_ids and !empty($class_ids) and $class_ids[0] != ''){
				foreach($class_ids as $kk => $vv){
					if(isset($multi_item[$vv]) and in_array($item['id'], $multi_item[$vv])){
						$item['promotion'] = $v;
						break;
					}
				}
			}
		}

		// 2020-11-05 依照所選擇的產品抓進來
		if($v['scope'] == '1' or $v['scope'] == '0'){
			$v2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:id and class_id=:class_id', array(':type' => str_replace('detail','',$this->data['router_method']).'promotionrelatedids', ':ml_key' => $this->data['ml_key'], ':id' => $item['id'], ':class_id' => $v['id']))->queryRow();			
			if($v2){
				$item['promotion'] = $v;
				break;
			}
		}


		// 套用全部
		if($v['scope'] == '2'){
			$item['promotion'] = $v;
			break;
		}

		if(!empty($item['promotion'])){
			break;
		}


		$tmps2[$k] = $v;
	}
}


/*
 * 規格
 */

// 2020-05-14
// demo_shop2的寫法
if(1){
	$specs = array();//初始值
	$rows = $this->cidb->where('is_enable',1)->where('data_id',$item['id'])->get('shopspec')->result_array();
	if($rows){
		foreach($rows as $k => $v){
			$v['value'] = $v['id'];

			$v['name2'] = $v['name']; // 產品編號
			$v['name'] = $v['spec']; // 2020-05-14 李哥下午說，只顯示規格，不顯示價格欄位

			//抓第一個帶到外面當預設顯示金額
			if($k == 0){
				$item['price'] = $v['price'];
				$item['price2'] = $v['price2'];
			}

			//更改套用主題活動計算 by lota 2020-11-23 
			if(isset($item['promotion']['run_action1']) && isset($item['promotion']['run_action2'])){
				if($item['promotion']['run_action1']=='1'){ //打折
					eval('$v[\'price2\'] = round2($v[\'price2\'] * 0.' . $item['promotion']['run_action2'] . ',0);');		
				}
				if($item['promotion']['run_action1']=='2'){ //定額
					$v['price2'] = $item['promotion']['run_action2'];
				}
				if($item['promotion']['run_action1']=='3'){ //折抵
					$v['price2'] = $v['price2'] - $item['promotion']['run_action2'];
					if($v['price2'] < 0){
						$v['price2'] = 0;
					}
				}
			}

			foreach(array('price','price2') as $_price){
				$v[$_price.'_format'] = number_format($v[$_price]);
				$v[$_price.'_format_ds'] = '$'.$v[$_price.'_format'];
				$v[$_price.'_format_ds_nt'] = 'NT'.$v[$_price.'_format_ds'];
			}

			unset($v['disabled']);
			if($v['inventory'] <= 0){
				$v['disabled'] = '';
			}

			$rows[$k] = $v;
		}

		// 不是每一個規格表都是需要這樣子，應該只有下拉的才需要
		$rows2 = array();
		//$rows2[] = array(
		//	'value' => '',
		//	'name' => '請選擇',
		//	'pic' => '',
		//);
		foreach($rows as $k => $v){
			$rows2[] = $v;
		}
		$rows = $rows2;

		$specs = $rows; // A方案在使用的
	}

	// 合併就是只會挑一種規格的區塊來顯示，請修改底下的路徑，舉例：shop/spec2(就是顏色加標題的Radio，然後顏色是非必填)
	$view_file = 'v3/shop/spec1';
	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
		$data2[$layoutv3_struct_map_keyname[$view_file][0]]['multi'][] = $rows;
		$data2[$layoutv3_struct_map_keyname[$view_file][0]]['single'][] = array(
			'topic' => '規格',
			'name' => 'specid',
			'itemid' => $item['id'],
			//'itemid' => 999, // 應該不用帶$item['id']吧我猜
		);
	}
}

// 合併的寫法
if(0){
	$rows = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'spec')->where('is_enable=1 and data_id=:id', array(':id'=>$item['id']))->queryAll();
	if($rows){
		foreach($rows as $k => $v){
			$v['value'] = $v['specid'];
			$v['name'] = $rows_tmp[$v['specid']]['topic'];

			if($rows_tmp[$v['specid']]['pic1'] != ''){
				$v['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'spec/'.$rows_tmp[$v['specid']]['pic1'];
			}

			unset($v['disabled']);
			if($v['inventory'] <= 0){
				$v['disabled'] = '';
			}

			$rows[$k] = $v;
		}

		// 不是每一個規格表都是需要這樣子，應該只有下拉的才需要
		$rows2 = array();
		//$rows2[] = array(
		//	'value' => '',
		//	'name' => '請選擇',
		//	'pic' => '',
		//);
		foreach($rows as $k => $v){
			$rows2[] = $v;
		}
		$rows = $rows2;
	}

	// 合併就是只會挑一種規格的區塊來顯示，請修改底下的路徑，舉例：shop/spec2(就是顏色加標題的Radio，然後顏色是非必填)
	$view_file = 'v3/shop/spec1';
	if(isset($layoutv3_struct_map_keyname[$view_file][0])){
		$data2[$layoutv3_struct_map_keyname[$view_file][0]]['multi'][] = $rows;
		$data2[$layoutv3_struct_map_keyname[$view_file][0]]['single'][] = array(
			'topic' => 'gggaaa',
			'name' => 'specid',
			'itemid' => 999, // 應該不用帶$item['id']吧我猜
		);
	}
} // 合併的寫法

// 分散的寫法(參考用，這個算發想而以)
// 把規格屬性分散開來，就像靜態頁一樣
// 這裡應該要"保持註解"，下下一段才是真正套了程式的分散寫法
/*
array(2) {
  [0]=>
  array(2) {
    ["L"]=>
    string(36) "92d2a3e334f35581164f352d3cbd63c9.jpg"
    ["M"]=>
    string(36) "5411135774ce723d3006076f35b99d0a.jpg"
  }
  [1]=>
  array(2) {
    ["紅"]=>
    string(36) "92d2a3e334f35581164f352d3cbd63c9.jpg"
    ["藍"]=>
    string(36) "5411135774ce723d3006076f35b99d0a.jpg"
  }
}
 */
//    if(0){
//    	$data2[$layoutv3_struct_map_keyname['shop/spec1'][0]]['single'][] = array(
//    		'topic' => '尺寸',
//    		'name' => 'attr1',
//    	);
//    	$tmps = array(
//    		array(
//    			'value' => '',
//    			'name' => '請選擇',
//    			'pic' => '',
//    		),
//    		array(
//    			'value' => 'L',
//    			'name' => 'L',
//    			'pic' => '',
//    		),
//    		array(
//    			'value' => 'M',
//    			'name' => 'M',
//    			'pic' => '',
//    		),
//    		array(
//    			'value' => 'S',
//    			'name' => 'S',
//    			'pic' => '',
//    		),
//    	);
//    	foreach($tmps as $k => $v){
//    		if($v['value'] == '') continue;
//    		$has_inventory = false;
//    		$search_data = array(':type'=>str_replace('detail','',$this->data['router_method']).'spec',':ml_key'=>$this->data['ml_key'],':q'=>$v['value']);
//    		$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and (other1=:q or other2=:q or other3=:q or other4=:q)',$search_data)->queryAll();
//    		if($row_tmp){
//    			foreach($row_tmp as $kk => $vv){
//    				$row_spec = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'spec')->where('is_enable=1 and specid=:specid', array(':specid'=>$vv['id']))->queryRow();
//    				if($row_spec['inventory'] > 0){
//    					$has_inventory = true;
//    					break;
//    				}
//    			}
//    		}
//    		if(!$has_inventory){
//    			$tmps[$k]['disabled'] = '';
//    		}
//    	}
//    	$data2[$layoutv3_struct_map_keyname['shop/spec1'][0]]['multi'][] = $tmps;
//    
//    	$data2[$layoutv3_struct_map_keyname['shop/spec2'][0]]['single'][] = array(
//    		'topic' => '材質',
//    		'name' => 'attr2',
//    		// 'itemid' => $item['id'],
//    	);
//    	$tmps = array(
//    		array(
//    			'value' => '紅',
//    			'name' => '紅',
//    			'pic' => '_i/assets/upload/shopspec/92d2a3e334f35581164f352d3cbd63c9.jpg',
//    		),
//    		array(
//    			'value' => '藍',
//    			'name' => '藍',
//    			'pic' => '_i/assets/upload/shopspec/5411135774ce723d3006076f35b99d0a.jpg',
//    		),
//    	);
//    	// 複製上面的
//    	foreach($tmps as $k => $v){
//    		if($v['value'] == '') continue;
//    		$has_inventory = false;
//    		$search_data = array(':type'=>str_replace('detail','',$this->data['router_method']).'spec',':ml_key'=>$this->data['ml_key'],':q'=>$v['value']);
//    		$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and (other1=:q or other2=:q or other3=:q or other4=:q)',$search_data)->queryAll();
//    		if($row_tmp){
//    			foreach($row_tmp as $kk => $vv){
//    				$row_spec = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'spec')->where('is_enable=1 and specid=:specid', array(':specid'=>$vv['id']))->queryRow();
//    				if($row_spec['inventory'] > 0){
//    					$has_inventory = true;
//    					break;
//    				}
//    			}
//    		}
//    		if(!$has_inventory){
//    			$tmps[$k]['disabled'] = '';
//    		}
//    	}
//    	$data2[$layoutv3_struct_map_keyname['shop/spec2'][0]]['multi'][] = $tmps;
//    }

// 分散的寫法(會merge各屬性的值，然後分別assign到各個變化區塊)
// 這是真的有套程式的

if(0){
	$admin_field_router_class = str_replace('detail', '', $this->data['router_method']).'spec';
	$admin_field_section_id = 0;
	include 'source/system/admin_field_get.php';

	$search_data = array(
		':type' => str_replace('detail','',$this->data['router_method']).'spec',
		':ml_key' => $this->data['ml_key']
	);
	$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',$search_data)->queryAll();
	$attrs_tmp = array();
	if($row_tmp){
		foreach($row_tmp as $k => $v){
			for($x=0;$x<=3;$x++){
				if($v['other'.($x+1)] != ''){
					$attrs_tmp[$x][$v['other'.($x+1)]] = $v['pic1'];
				}
			}
		}
		foreach($attrs_tmp as $k => $v){
			$tmps = array();
			foreach($v as $kk => $vv){
				$tmps[] = array(
					'value' => $kk,
					'name' => $kk,
					'pic' => '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'spec/'.$vv,
				);
			}
			foreach($tmps as $kk => $vv){
				if($vv['value'] == '') continue;
				$has_inventory = false;
				$search_data = array(':type'=>str_replace('detail','',$this->data['router_method']).'spec',':ml_key'=>$this->data['ml_key'],':q'=>$vv['value']);
				$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and (other1=:q or other2=:q or other3=:q or other4=:q)',$search_data)->queryAll();
				if($row_tmp){
					foreach($row_tmp as $kkk => $vvv){
						$row_spec = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']).'spec')->where('is_enable=1 and data_id=:id and specid=:specid', array(':id'=>$item['id'],':specid'=>$vvv['id']))->queryRow();
						if(isset($row_spec['inventory']) and $row_spec['inventory'] > 0){
							$has_inventory = true;
							break;
						}
					}
				}
				if(!$has_inventory){
					$tmps[$kk]['disabled'] = '';
				}
			}
			// 請手動透過更換spec檔案名稱來達成
			$view_file = 'v3/shop/spec'.($k+1);
			if(isset($layoutv3_struct_map_keyname[$view_file][0])){
				$data2[$layoutv3_struct_map_keyname[$view_file][0]]['multi'][] = $tmps;
				$data2[$layoutv3_struct_map_keyname[$view_file][0]]['single'][] = array(
					'topic' => $admin_field['other'.($k+1)]['other']['html_end'], // 材質
					'name' => 'attr'.($k+1),
					'itemid' => $item['id'], // 為了讓每一個規格屬性(1~4)都能夠直接取用到產品的編號
				);
			}
		}
	}
}
//var_dump($data2[$layoutv3_struct_map_keyname['shop/spec1'][0]]);die;



/*
 * 產品多張圖片 Kcfinder版本
 */
// //使用 Yii涵式如果遇到客戶主機的資料有 . 的話會解析錯誤，改用PHP原生涵式去抓取 by lota 2019/5/23
// // $path = 'webroot._i.assets.members.'.str_replace('detail','',$this->data['router_method']).$item['id'].'.member';
// $path = _BASEPATH.'/assets/members/'.str_replace('detail','',$this->data['router_method']).$item['id'].'/member/';
// // $tmp2 = array();
// // if(is_dir(Yii::getPathOfAlias($path))){
// // 	$tmp2 = $this->_getFiles(Yii::getPathOfAlias($path));
// // }
// $tmp2 = array();//初始化
// if(is_dir($path)){	
// 	$_tmp2 = glob($path.'*.*');
// 	if($_tmp2 and !empty($_tmp2)){
// 		foreach ($_tmp2 as $k => $v) {
// 			$tmp2[$k] = str_replace($path,'',$v);
// 		}
// 		sort($tmp2);//lota 加入排序
// 	}
// }




$rows = array();
$rows[] = array(
	'pic' => '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$item['pic1'],
	// #21242
	'name' => $item['name'],
);

// 多圖 Kcfinder版本
// if($tmp2){
// 	foreach($tmp2 as $k => $v){
// 		$tmp2 = explode('/', $v);
// 		$tmp3 = $tmp2[count($tmp2)-1];
// 		$tmp4s = explode('.', $tmp3);
// 		$tmp5 = $tmp3; // 沒有副檔名，當做圖片名稱
// 		if($tmp4s and !empty($tmp4s)){
// 			unset($tmp4s[count($tmp4s)-1]); // 只刪掉逗點最右邊，因為怕有1個以上的小數點
// 			$tmp5 = implode('.', $tmp4s);
// 		}
// 		// 為了要符合前台版型的規範
// 		$rows[] = array(
// 			'pic' => '_i/assets/members/'.str_replace('detail','',$this->data['router_method']).$item['id'].'/member/'.$tmp3,
// 			// #21242
// 			'name' => $tmp5,
// 		);
// 	}
// }

//多張圖 資料庫版本 2021-09-10
$_tmp3 = $this->cidb->where('is_enable',1)->where('class_id',$_GET['id'])->order_by('sort_id')->get('shopphoto')->result_array();
if($_tmp3){
	foreach ($_tmp3 as $k => $v) {		
		// 為了要符合前台版型的規範
		$rows[] = array(
			'pic' => '_i/assets/upload/shopphoto/'.$v['pic1'],
			// #21242
			'name' => $v['name'],
		);	
	}
}

$small_images = $rows;

/*
 * 相關商品 //2017/7/4 lota 補完
 */

// $rows = $this->db->createCommand()->from($prefix)->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$item['id']))->queryRow();
// $sql_LIKE = '';
// if($rows['class_ids'] != ''){
// 	$sql_LIKE = '(0 ';
// 	$ids = explode(',', $rows['class_ids']);
// 	if($ids){
// 		foreach($ids as $kk => $vv){
// 			if($vv == '') continue;
// 			$sql_LIKE .= ' or class_ids LIKE \'%,'.$vv.',%\'';
// 		}
// 	}
// 	$sql_LIKE .= ' ) ';
// }
// $tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and '.$sql_LIKE.' and id!=:myid',array(':myid'=>$item['id']))->order('sort_id')->queryAll();

$tmps = array();
if(isset($_GET['id'])){
	// 先找該產品的資料
	$tmp = $this->db->createCommand()->from($prefix)->where('is_enable=1 and id=:id',array(':id'=>$_GET['id']))->queryRow();

	// 規則1：顯示所處分類底下的產品，排除自己
	// $tmps = $this->db->createCommand()->from($prefix)->where('is_enable=1 and id!='.$_GET['id'].' and class_id=:id',array(':id'=>$tmp['class_id']))->order('sort_id')->queryAll();
	// if($tmps){
	// 	foreach($tmps as $k => $v){
	// 		// 為了要符合前台版型的規範
	// 		$tmps[$k]['url1'] = $tmps[$k]['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id'];
	// 		$tmps[$k]['pic'] = '_i/assets/upload/'.$prefix.'/'.$v['pic1'];
	// 	}
	// }

	// 規則2：勾選 2017-12-26
	$tmps2 = explode(',', $tmp['related_ids']);
	if($tmps2 and count($tmps2) > 0){
		foreach($tmps2 as $k => $v){
			if($v == ''){
				unset($tmps2[$k]);
			}
		}
	}
	if(count($tmps2) > 0){
		//$tmps = $this->db->createCommand()->from($prefix)->where('is_enable=1 and id IN('.implode(',', $tmps2).') ')->queryAll();
		// (a.date1 <= NOW() OR a.date1 IS NULL OR a.date1 = "0000-00-00") AND (a.date2 >= NOW() OR a.date2 IS NULL OR a.date2 = "0000-00-00")

		$o = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key']);
		$o = $o->where('id IN('.implode(',', $tmps2).')');
		$o = $o->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "'.date('Y-m-d').'" OR date2 IS NULL OR date2 = "0000-00-00")');
		$tmps = $o->get($prefix)->result_array();

		if($tmps){
			foreach($tmps as $k => $v){
				// 為了要符合前台版型的規範
				$tmps[$k]['url1'] = $tmps[$k]['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id'];
				$tmps[$k]['pic'] = '_i/assets/upload/'.$prefix.'/'.$v['pic1'];

				$tmps[$k]['price'] = 0;
				$tmps[$k]['price2'] = 0;
				$rowg = $this->cidb->where('is_enable',1)->where('data_id',$v['id'])->get('shopspec')->row_array();
				if($rowg and isset($rowg['id'])){
					$tmps[$k]['price'] = $rowg['price'];
					$tmps[$k]['price2'] = $rowg['price2'];
				}

				foreach(array('price','price2') as $_price){
					$tmps[$k][$_price.'_format'] = number_format($tmps[$k][$_price]);
					$tmps[$k][$_price.'_format_ds'] = '$'.$tmps[$k][$_price.'_format'];
					$tmps[$k][$_price.'_format_ds_nt'] = 'NT'.$tmps[$k][$_price.'_format_ds'];
				}
			}
		}
	}
}

if($tmps){
	foreach($tmps as $k => $v){
		// 為了要符合前台版型的規範
		$tmps[$k]['url1'] = $tmps[$k]['url2'] = $url_prefix.$prefix.'detail'.$url_suffix.'?id='.$v['id'];
		$tmps[$k]['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$v['pic1'];
		//$tmps[$k]['price'] = 'NT$'.number_format($v['price']);
		//$tmps[$k]['price2'] = 'NT$'.number_format($v['price2']);
	}
}

$relations = $tmps;

//更改套用主題活動計算 by lota 2020-11-23 這段是處理預設顯示金額
if(isset($item['promotion']['run_action1']) && isset($item['promotion']['run_action2'])){
	if($item['promotion']['run_action1']=='1'){ //打折
		eval('$item[\'price2\'] = round2($item[\'price2\'] * 0.' . $item['promotion']['run_action2'] . ',0);');		
	}
	if($item['promotion']['run_action1']=='2'){ //定額
		$item['price2'] = $item['promotion']['run_action2'];
	}
	if($item['promotion']['run_action1']=='3'){ //折抵
		$item['price2'] = $item['price2'] - $item['promotion']['run_action2'];
		if($item['price2'] < 0){
			$item['price2'] = 0;
		}
	}
}

foreach(array('price','price2') as $_price){
	$item[$_price.'_format'] = number_format($item[$_price]);
	$item[$_price.'_format_ds'] = '$'.$item[$_price.'_format'];
	$item[$_price.'_format_ds_nt'] = 'NT'.$item[$_price.'_format_ds'];
}

// 這裡是從source/favorite/list.php複製過來的
$items2 = $relations;
$item_backup = $item;

// 目前有跟source/favorite/list.php和首頁的共用
include 'source/shop/spec_float_include.php';

$relations = $items2;
$item = $item_backup;

/*
 * DATA2資料結構
 */

$data2[$ID]['single'][] = $item;

$data2[$ID]['multi'] = array(
	$small_images,
	$increase_purchases, // 加價購
	$relations,
	$specs, // A方案在使用的
);


// 點閱數
$_res = $this->cidb->where('id',$_GET['id'])->get(str_replace('detail','',$this->data['router_method']))->row_array();
$_counter = $_res['click'] + 1 ;
$this->cidb->where('id',$_GET['id']);
$this->cidb->update(str_replace('detail','',$this->data['router_method']),array('click' => $_counter));


// 回列表的連結
$data[$this->data['router_method'].'_return_url'] = $url_prefix.str_replace('detail','',$this->data['router_method']).$url_suffix;

//單選
// if(isset($item['class_id']) && $item['class_id'] > 0){
// 	$data[$router_method.'_return_url'] .= '?id='.$item['class_id'];
// }

//複選分類的麵包屑及大標處理 for 定揚購物

//麵包屑的處理

// $view_file = 'v3/breadcrumb';
// $_first_class_id = '';
// $_class_name = array();
// $tmps = array();
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$_tmps = $data[$layoutv3_struct_map_keyname[$view_file][0]];

	//重新排序
	// foreach ($_tmps as $value) {
	// 	$tmps[] = $value;
	// }

// 	// 刪掉尾巴
// 	if(isset($tmps[count($tmps)-1])){
// 		unset($tmps[count($tmps)-1]);
// 	}

// 	foreach ($multi_item_tmp as $key => $value) {
// 		if(isset($value[$row['id']])){
// 			$_first_class_id = $key;

// 			$_row = $this->cidb->where('id',$_first_class_id)->get(str_replace('detail','',$this->data['router_method']).'type')->row_array();

// 			$_class_name['name'] = $_row['name'];
// 			$_class_name['url'] = $prefix.'_'.$this->data['ml_key'].'.php?id='.$_row['id'];
// 			$_class_name['id'] = 'x1';
// 			$_class_name['pid'] = '0';
// 			$tmps[] = $_class_name;
//  			//break;
// 		}
// 	}

	//複寫回列表的連結
	// $_end_tmps = end($tmps);
	// $data[$this->data['router_method'].'_return_url'] = $_end_tmps['url'];

// 	$data[$layoutv3_struct_map_keyname[$view_file][0]] = $tmps;
// }

//大標的顯示

// $view_file = 'v3/sub_page_title';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$layoutv3_struct_map_keyname[$view_file][0]] = array('name' => $tmps[2]['name'],'sub_name' => '');
// }

