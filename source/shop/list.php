<?php

// 這個是左側選單在使用的
// 產品顯示方式 0 不顯示產品，顯示分類 1 顯示該ID下的子分類產品,包含自己 2 只顯示該ID的產品
// define('PRODUCT_SHOW_TYPE',0);
//
// 這個是右側列表在使用的
// 1 預設顯示全部產品 0 不顯示 (如果設1則優先執行該常數，設0則執行PRODUCT_SHOW_TYPE
// define('PRODUCT_DEFAULT_SHOW_TYPE',0);
// 

// 這個地方有作用哦
// $data[$ID.'_0'] = array(
// 	'name' => 'Products LIST',
// 	'sub_name' => '',
// );

// $id = 0;
// if(isset($_GET['id']) and $_GET['id'] > 0){
// 	$id = intval($_GET['id']);
// }

if(isset($layoutv3_struct_map_keyname['v3/shop/block'])){
	$data[$layoutv3_struct_map_keyname['v3/shop/block'][0]] = array('name'=>'Categories','class_name'=>'eventMenu'); 
}

//判斷是否讀取促銷活動的資料
$id = 0;
$is_promotion = false;
if(isset($_GET['id'])){
	if(preg_match('/^s(\d+)$/', $_REQUEST['id'], $matches)){
		$id = $matches[1];
		$is_promotion = true;
		//判斷如果沒有這個活動，就跳到首頁
		$_howhow = $this->cidb->where('id',$id)->get($this->data['router_method'].'promotion')->row_array();
		if(!$_howhow){
			header('Location: index_'.$this->data['ml_key'].'.php');
			die;
		}
	} else {
		$id = intval($_GET['id']);
		//判斷如果沒有這個分類，就跳到首頁
		$_howhow = $this->cidb->where('id',$id)->get($this->data['router_method'].'type')->row_array();
		if(!$_howhow){
			header('Location: index_'.$this->data['ml_key'].'.php');
			die;
		}
	}
}

$data2[$ID] = array(
	'single' => array(),
	'multi' => array(),
);

$prefix = $this->data['router_method'];

// 先把所有規格的session給清掉
unset($_SESSION['save'][$prefix.'_spec']);

// include 'source/shop/admin_field_include.php';

$admin_field_router_class = str_replace('detail', '', $this->data['router_method']).'spec';
$admin_field_section_id = 0;
include 'source/system/admin_field_get.php';

/*
 * 搜尋條件
 */
$search_data = array( // 複制來的
	':type' => $prefix.'spec',
	':ml_key' => $this->data['ml_key']
);
// 取得規格列表
$row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',$search_data)->queryAll();
$attrs_tmp = array();
if($row_tmp){
	foreach($row_tmp as $k => $v){

		/*
		 * 電腦版(這個是範例，請依照實際情況調整)
		 */

		$v3_num = 0; // filter1區塊在struct_map_keyname的位置(從0開始)
		$db_num = 1; // 欄位存放在資料表的位置
		$pic = true;
		include 'source/shop/list_spec_repeated.php';

		$v3_num = 1; // filter1區塊在struct_map_keyname的位置(從0開始)
		$db_num = 2; // 欄位存放在資料表的位置
		$pic = false;
		include 'source/shop/list_spec_repeated.php';

		/*
		 * 手機版(這個是範例，請依照實際情況調整)
		 */

		$v3_num = 2; // filter1區塊在struct_map_keyname的位置(從0開始)
		$db_num = 1; // 欄位存放在資料表的位置
		$pic = true;
		include 'source/shop/list_spec_repeated.php';

		$v3_num = 3; // filter1區塊在struct_map_keyname的位置(從0開始)
		$db_num = 2; // 欄位存放在資料表的位置
		$pic = false;
		include 'source/shop/list_spec_repeated.php';

		// "這裡是舊的寫法，並沒有寫到手機版的部份，所以…就留著參考用" 2017-06-27
		// 每一個規則，裡面都有四個屬性可以用，但未必是有作用的，所以是會去檢查這四個欄位
		// for($x=0;$x<=3;$x++){
		// 	if($v['other'.($x+1)] != ''){
		// 		//$attrs_tmp[$x][$v['other'.($x+1)]] = $v['pic1'];
		// 		$pic = '_i/assets/upload/'.$prefix.'spec/'.$v['pic1'];

		// 		// 這行是做示範，故意讓第二個條件沒有圖片
		// 		if($x == 1){
		// 			$pic = '';
		// 		}

		// 		// 這裡的範例，是假設前兩個規格是用filter1的情況
		// 		if(isset($layoutv3_struct_map_keyname['shop/filter1'][$x])){
		// 			$data[$layoutv3_struct_map_keyname['shop/filter1'][$x]][$v['other'.($x+1)]] = array(
		// 				'pic' => $pic,
		// 				'id' => 'other'.($x+1), // 本來應該要放單筆，但為了簡化以及好寫，所以才這樣子做
		// 				'sectionid' => ($x+1),
		// 			);
		// 			if(isset($_SESSION['save'][$prefix.'_filter'][($x+1).'___'.$v['other'.($x+1)]]['data']) and $_SESSION['save'][$prefix.'_filter'][($x+1).'___'.$v['other'.($x+1)]]['data'] != ''){
		// 				$data[$layoutv3_struct_map_keyname['shop/filter1'][$x]][$v['other'.($x+1)]]['checked'] = '';
		// 			}
		// 		}

		// 		// 這裡的範例，是規則區塊，在下面的情況下而撰寫的
		// 		// filter1
		// 		// filter1
		// 		// filter2
		// 		// $x += 2; // 注意這一行！！這只是個範例哦
		// 		// if(isset($layoutv3_struct_map_keyname['shop/filter1'][$x])){
		// 		// 	$data[$layoutv3_struct_map_keyname['shop/filter1'][$x]][$v['other'.($x+1)]] = array(
		// 		// 		'pic' => $pic,
		// 		// 		'id' => 'other'.($x+1), // 本來應該要放單筆，但為了簡化以及好寫，所以才這樣子做
		// 		// 		'sectionid' => ($x+1),
		// 		// 	);
		// 		// 	if(isset($_SESSION['save'][$prefix.'_filter'][($x+1).'___'.$v['other'.($x+1)]]['data']) and $_SESSION['save'][$prefix.'_filter'][($x+1).'___'.$v['other'.($x+1)]]['data'] != ''){
		// 		// 		$data[$layoutv3_struct_map_keyname['shop/filter1'][$x]][$v['other'.($x+1)]]['checked'] = '';
		// 		// 	}
		// 		// }
		// 	}
		// }
	}
	//var_dump($attrs_tmp);die;
}

if($is_promotion or 1){ //改為預設都要判斷是否有主題活動的參照，如果該站沒主題活動，這邊可以關閉 by lota
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
	$ids_tmp = array();
	$_ids = array();
	// 2020-11-05 依照所勾選的分類，把產品給抓進來
	// $v = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$id))->queryRow();
	//改為預設都要判斷是否有主題活動的參照
	$_iids = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
	if($_iids){
		foreach ($_iids as $key => $v) {
		
			//2020-11-23 如果主題活動條件為"滿件"而且數量為"1" lota 這邊不需要了，判斷改為產品那邊比對到後再抓
			// if($v['condition1']=='2' && $v['condition2']=='1'){
			// 	// var_dump($v);die;
			// 	$_action1 = $v['action1'];
			// 	$_action2 = $v['action2'];
			// }
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
			if($v['class_ids'] != ''  and $v['scope'] == '0'){
				// 一般分類 (購物產品，己經在2017-03-24把單分類完全拿掉)
				// $rows = $this->db->createCommand()->from($this->data['router_method'])->where('is_enable=1 and ml_key=:ml_key and class_id IN (:ids)',array(':ids'=>$v['class_ids'],':ml_key'=>$this->data['ml_key']))->queryAll();
				// if($rows){
				// 	foreach($rows as $kk => $vv){
				// 		$ids_tmp[$vv['id']] = '1';
				// 	}
				// }
				// 複選分類
				// 2020-11-05 把主題活動內，已選擇的分類底下的產品，放到主題活動的產品條件內
				$tmps = explode(',', $v['class_ids']);
				foreach($tmps as $kk => $vv){
					if(isset($multi_item[$vv]) and !empty($multi_item[$vv])){
						foreach($multi_item[$vv] as $kkk => $vvv){
							$ids_tmp[$v['id']][$vvv] = '1'; //#39907 lota fix
						}
					}
				}
			}
			// 2020-11-05 依照所選擇的產品抓進來，跟上面的東西併在一起
			if(isset($v['scope']) && ($v['scope'] == '1' or $v['scope'] == '0')){
				$v2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type' => $this->data['router_method'].'promotionrelatedids', ':ml_key' => $this->data['ml_key'], ':id' => $v['id']))->queryAll(); //#39907 lota fix
				if($v2){
					foreach($v2 as $kk => $vv){
						if($vv['other1'] != ''){
							$ids_tmp[$v['id']][$vv['other1']] = '1'; //#39907 lota fix
						}
					}
				}
			}
			// 套用全部
			if(isset($v['scope']) && $v['scope'] == '2'){
				$v2 = $this->db->createCommand()->from($prefix.'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
				if($v2 and !empty($v2)){
					foreach($v2 as $kk => $vv){
						if(isset($multi_item[$vv['id']]) and !empty($multi_item[$vv['id']])){
							foreach($multi_item[$vv['id']] as $kkk => $vvv){
								$ids_tmp[$v['id']][$vvv] = '1'; //#39907 lota fix
							}
						}
					}
				}
			}
			// 把分類和商品merge好的東西放在另一個陣列元素
			if(!empty($ids_tmp)){
				foreach($ids_tmp as $kk => $vv){
					// $ids[] = $kk;
					// $_ids[$kk][] = $vvv; //用 $_ids 是避免被下面規則洗掉...
					foreach ($vv as $kkk => $vvv) { //#39907 lota fix
						$_ids[$v['id']][] = $kkk;
						
					}
				}
			}
		}
	}
	// 這裡註解，是因為最下面只會用到$ids陣列
	// $v['ids'] = $ids;
	// var_dump($_ids);die;
} // is_promotion

/*
 * 商品搜尋
 */
if(isset($_GET['q']) and $_GET['q'] != ''){
	//$tmps = $this->db->createCommand()->from($this->data['router_method'])->where('is_enable=1 and name like :name',array(':name'=>'%'.$_GET['q'].'%'))->queryAll();
	$tmps = $this->db->createCommand()->from($this->data['router_method'])->where('is_enable=1 and (name like :name or detail like :name or field_data like :name or field_tmp like :name) AND (date1 <= NOW() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= NOW() OR date2 IS NULL OR date2 = "0000-00-00")',array(':name'=>'%'.$_GET['q'].'%'))->queryAll();

	if($tmps and !empty($tmps)){
		foreach($tmps as $k => $v){
			$v['img_alt'] = $v['name'];
			$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
			$v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
			$v['url']=$v['url1'];
			$v['price'] = 0;
			$v['price2'] = 0;
			$rowg = $this->cidb->where('is_enable',1)->where('data_id',$v['id'])->get('shopspec')->row_array();
			if($rowg and isset($rowg['id'])){
				$v['price'] = $rowg['price'];
				$v['price2'] = $rowg['price2'];

				//先查詢該產品是否有主題活動, 使用$_ids參照，符合的話就撈主題活動資料
				$_action2 = $_action1 = 0;
				if(isset($_ids) && count($_ids) > 0){
					foreach ($_ids as $key => $value) {
						if(in_array($v['id'], $value)){
							$vp = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$key))->queryRow();
							if($vp['condition1']=='2' && $vp['condition2']=='1'){
								// var_dump($vp);die;
								$_action1 = $vp['action1'];
								$_action2 = $vp['action2'];
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

			$tmps[$k] = $v;
		}
	}
	//$data[$ID] = $tmps;

	// 這裡是從source/favorite/list.php複製過來的
	$items2 = $tmps;

	// 目前有跟source/favorite/list.php和首頁的共用
	include 'source/shop/spec_float_include.php';

	$tmps = $items2;

	$data2[$ID]['multi'][] = $tmps;
	$data2[$ID]['single'][] = array(
		'count' => count($tmps),
	);
} else { //不是關鍵字搜尋要做的事


	//設定分頁基本參數 要記得在view那邊加入分頁的view
	$pagew = 0;
	if(isset($_GET['page']) and $_GET['page'] > 0){
		$pagew = $_GET['page'];
	}
	$limit_count = 12;//一頁顯示幾筆
	$_GET['current_page'] = $pagew;

	$DataList = array();
	$pageRecordInfo = array();

	// 是否顯示全部產品
	// 1 預設顯示全部產品 0 不顯示
	//
	// 這個是預設的product列表頁顯示產品
	// 有符合條件的話，處理完就會跳出了，不會在執行以下的程式碼
	unset($_constant);
	eval('$_constant = '.strtoupper($this->data['router_method'].'_DEFAULT_SHOW_TYPE').';');

	// 如果有使用右下方的搜尋條件，那自動會切換到顯示所有產品的區塊來顯示
	// 如果有連到分類，就會自動清掉(ㄟ？)
	//var_dump($_SESSION['save'][$prefix.'_filter']);die;
	if(isset($_SESSION['save'][$prefix.'_filter'])){
		$filters = array();
		$ids = array();
		foreach($_SESSION['save'][$prefix.'_filter'] as $k => $v){
			$ids = explode('___', $k);
			$sectionid = $ids[0];
			$sample_value = $ids[1]; // 這個應該用不到
			$field = $v['field'];
			$value = $v['data'];
			if($value != ''){
				$filters[] = ' '.$field.'="'.$value.'" ';
			}
		}

		// 預先把搜尋的東西準備好
		$sql = '';
		if(!empty($filters)){
			$sql .= ' and ( '.implode(' or ', $filters).' ) ';
		}

		$ids = array();
		if($sql != ''){
			$spec_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key '.$sql, array(':type'=>$prefix.'spec',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
			if($spec_tmp and !empty($spec_tmp)){
				foreach($spec_tmp as $k => $v){
					$ids[] = $v['id'];
				}
			}
		}

		$relation_tmp = array();
		if($ids and !empty($ids)){
			$relation_tmp = $this->db->createCommand()->from($prefix.'spec')->where('is_enable=1 and id IN ('.implode(',',$ids).')')->queryAll();
		}

		$item_ids_tmp = array();
		if($relation_tmp and !empty($relation_tmp)){
			foreach($relation_tmp as $k => $v){
				$item_ids_tmp[$v['data_id']] = '';
			}
		}

		$shop_filter_ids = array();
		if($item_ids_tmp and !empty($item_ids_tmp)){
			foreach($item_ids_tmp as $k => $v){
				$shop_filter_ids[] = $k;
			}
		}

	}

	if($id == 0 and ($_constant == 1 or (isset($shop_filter_ids) and !empty($shop_filter_ids) ))){

		// 商品全部列表
		$db = new Mysqleric(array('table'=>$this->data['router_method']));

		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?&page=';
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and ml_key=\''.$this->data['ml_key'].'\' AND (date1 <= NOW() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= NOW() OR date2 IS NULL OR date2 = "0000-00-00")';	

		// 側邊條件搜尋、以及右上的下拉條件搜尋
		// 如果要改，下面還有要記得一起改
		if(isset($shop_filter_ids) and !empty($shop_filter_ids)){
			$qryWhere .= ' and id IN ('.implode(',',$shop_filter_ids).') ';
		} else {
			//$qryWhere .= ' and 0 ';
		}
		if(isset($_SESSION['save'][$this->data['router_method'].'_filter_price']['min']) and $_SESSION['save'][$this->data['router_method'].'_filter_price']['min'] >= 0){
			$qryWhere .= 'and price_search >= '.$_SESSION['save'][$this->data['router_method'].'_filter_price']['min'].' ';
		}
		if(isset($_SESSION['save'][$this->data['router_method'].'_filter_price']['max']) and $_SESSION['save'][$this->data['router_method'].'_filter_price']['max'] >= 0){
			$qryWhere .= 'and price_search <= '.$_SESSION['save'][$this->data['router_method'].'_filter_price']['max'].' ';
		}
		if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'])){
			if($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '2'){
				$qryWhere .=' order by price_search';
			} elseif($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '1'){ 
				$qryWhere .=' order by price_search desc';
			} elseif($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '4'){ 
				$qryWhere .=' order by id desc';
			} elseif($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '3'){ 
				$qryWhere .=' order by id asc';
			}
		} else {
			// 因為這裡是全產品列表，所以不需要另外排序
			//$qryWhere .=' order by b.sort';
			//$qryWhere .=' order by rand()';
		}


		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				$db->row['url1'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
				$db->row['url2'] = 'save.php?id='.$this->data['router_method'].'inquiry&_append=&amount=1&primary_key='.$db->row['id'];
				// $db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
				//2021/1/8 改為顯示thumb縮圖 #38363
				$db->row['pic'] = L::show_thumb_pic($db->row['pic1'],$this->data['router_method'],'300x300');

				// 選規格的浮出來的選單在用的(看產品詳細)
				$db->row['url'] = $db->row['url1'];

				// 其實這裡應該是，後台要在新增另外一個欄位，只是懶的新增，所以先註解起來
				//$db->row['name2'] = $db->row['detail'];

				//$db->row['name2'] = $db->row['name'];
				//$db->row['name'] = $tmp['name'];

				$db->row['img_alt'] = $db->row['name']; // SEO

				$db->row['price'] = 0;
				$db->row['price2'] = 0;
				$rowg = $this->cidb->where('is_enable',1)->where('data_id',$db->row['id'])->get('shopspec')->row_array();
				if($rowg and isset($rowg['id'])){
					$db->row['price'] = $rowg['price'];
					$db->row['price2'] = $rowg['price2'];

					//先查詢該產品是否有主題活動, 使用$_ids參照，符合的話就撈主題活動資料
					$_action2 = $_action1 = 0;
					if(isset($_ids) && count($_ids) > 0){
						foreach ($_ids as $key => $value) {
							if(in_array($db->row['id'], $value)){
								$v = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$key))->queryRow();
								if($v['condition1']=='2' && $v['condition2']=='1'){
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
							eval('$db->row[\'price2\'] = round2($db->row[\'price2\'] * 0.' . $_action2 . ',0);');		
						}
						if($_action1=='2'){ //定額
							$db->row['price2'] = $_action2;
						}
						if($_action1=='3'){ //折抵
							$db->row['price2'] = $rowg['price2'] - $_action2;
							if($db->row['price2'] < 0){
								$db->row['price2'] = 0;
							}
						}
					}

				}

				foreach(array('price','price2') as $_price){
					$db->row[$_price.'_format'] = number_format($db->row[$_price]);
					$db->row[$_price.'_format_ds'] = '$'.$db->row[$_price.'_format'];
					$db->row[$_price.'_format_ds_nt'] = 'NT'.$db->row[$_price.'_format_ds'];
				}

				// 檢查收藏
				$db->row['has_favorite'] = 0;
				if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
					$row = $this->db->createCommand()->from('html')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$db->row['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
					if(isset($row['id']) and $row['id'] > 0){
						$db->row['has_favorite'] = 1;
					}
				} else {
					if(isset($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite']) and !empty($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'])){
						foreach($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'] as $k => $v){
							if(preg_match('/^'.$db->row['id'].'_(\d+)$/', $k)){
								$db->row['has_favorite'] = 1;
								break;
							}
						}
					}
				}

				//$db->row['content1'] = $db->row['field_data'];
				//$db->row['content2'] = $db->row['field_tmp'];

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}

		// 這裡是從source/favorite/list.php複製過來的
		$items2 = $DataList;

		// 目前有跟source/favorite/list.php和首頁的共用
		include 'source/shop/spec_float_include.php';

		$DataList = $items2;

		//$data[$ID] = $DataList;
		$data2[$ID]['multi'][] = $DataList;
		$data2[$ID]['single'][] = array(
			'count' => count($DataList),
		);

		// 記得每一個輸出都要加上這個，手機版的產品排序
		$view_file = LAYOUTV3_THEME_NAME.'/widget/sticky_filter';
		if(isset($layoutv3_struct_map_keyname[$view_file][0])){
			$data[$layoutv3_struct_map_keyname[$view_file][0]] = $DataList;
		}

		//原本這邊有指定左側選單名稱，改道shop/submenu.php by lota

		return;
	} // PRODUCT_DEFAULT_SHOW_TYPE


	/*
	 * 顯示分類哦，顯示產品的在上面
	 */


	if($is_promotion){
		$DataList = array();
		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id=s'.$id.'&page=';
	} else {
		/*
		 * 這裡是商品分類
		 */

		$db = new Mysqleric(array('table'=>$this->data['router_method'].'type'));

		//使用分頁列表
		if($id == 0){
			$url = $url_prefix.$this->data['router_method'].$url_suffix.'?&page=';
		} else {
			$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$id.'&page=';
		}
		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 and pid='.$id.' and ml_key=\''.$this->data['ml_key'].'\'';	

		$qryWhere .=' order by sort_id';

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{

				//$db->row['name2'] = $db->row['name'];
				//$db->row['name'] = '';

				$db->row['img_alt'] = $db->row['name']; // SEO

				$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$db->row['id'];
				// $db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$db->row['pic1'];
				//2021/1/8 改為顯示thumb縮圖 #38363
				$db->row['pic'] = L::show_thumb_pic($db->row['pic1'],$this->data['router_method'],'300x300');

				//$db->row['price'] = 0;
				//$db->row['price2'] = 0;

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}

	}

	// 想指定資料，但想要用檔案名稱而不想要用編號的寫法
	// if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>'Now on Sale','class_name'=>'eventMenu'); // eventMenu(促銷方案在用的), proCatalog(分類在用的), sideFilter(規格那些)
eval('$_constant_1 = '.strtoupper('shop_show_promotions').';');
if($_constant_1){//有主題活動

	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>t('主題活動'),'class_name'=>'proCatalog'); // eventMenu, proCatalog, sideFilter
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1]] = array('name'=>t('分類'),'class_name'=>'proCatalog'); // eventMenu, proCatalog, sideFilter
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][2])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][2]] = array('name'=>t('價格區間'),'class_name'=>'sideFilter');

	//判斷如果沒有主題活動，就減少區塊
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'])){
		if(isset($data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]]) and empty($data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/default/promenu'][0]])){
			if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>'','class_name'=>'');
		}
	}

}else{//沒主題活動
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][0]] = array('name'=>t('產品分類'),'class_name'=>'proCatalog'); // eventMenu, proCatalog, sideFilter
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/block'][1]] = array('name'=>t('價格區間'),'class_name'=>'sideFilter');
}
		

	if(!empty($DataList)){
		/*
		 * 這裡是分類
		 */

		//$data[$ID.'_1'] = $DataList;
		//$data[$ID] = $DataList;

		$data2[$ID]['multi'][] = $DataList;
		$data2[$ID]['single'][] = array(
			'count' => count($DataList),
		);

		if($DataList[0]['pid'] > 0){
			$tmp = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and id=:id',array(':id'=>$DataList[0]['pid']))->queryRow();

			// 想指定資料，但想要用檔案名稱而不想要用編號的寫法
			// $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/category_title'][0]] = array(
			// 	'name' => $tmp['name'],
			// 	'sub_name' => $tmp['detail'],
			// );

			$page_source_data_param1 = 'share-category_title';
			$page_source_data_param2 = array(
			 	'name' => $tmp['name'],
			 	'sub_name' => $tmp['detail'],
			);
			include _BASEPATH.'/../source/system/page_source_data.php';

			/*
			 * 如果有第二張分類圖的時候，就底下的這幾行在複製一次就好了，記得修改圖片名稱
			 */
			if($tmp['pic2'] != ''){
				$tmp2 = array(
					'url' => $tmp['url1'],
					'pic1' => '_i/assets/upload/'.$this->data['router_method'].'type/'.$tmp['pic2'], // Banner的大圖，你一定會問，$tmp['pic1']是什麼，它是代表圖啦
				);
				// Banner的小圖
				if(isset($tmp['pic3']) and $tmp['pic3'] != ''){
					$tmp2['pic2'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$tmp['pic3'];
				} else {
					$tmp2['pic2'] = $tmp2['pic1'];
				}
				if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/banner'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/banner'][0]][] = $tmp2;
			}

		}
	} else {

		if(!$is_promotion){
			/*
			 * 這裡是產品
			 */

			// 分類
			$tmp = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and id=:id',array(':id'=>$id))->queryRow();

			// 想指定資料，但想要用檔案名稱而不想要用編號的寫法
			// $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/category_title'][0]] = array(
			// 	'name' => $tmp['name'],
			// 	'sub_name' => $tmp['detail'],
			// );

			$page_source_data_param1 = 'share-category_title';
			$tmp['name'] = '';//#39664 分類名稱不需顯示 2021-04-20
			$page_source_data_param2 = array(
			 	'name' => $tmp['name'],
			 	'sub_name' => $tmp['detail'],
			);
			include _BASEPATH.'/../source/system/page_source_data.php';

			/*
			 * 如果有第二張分類圖的時候，就底下的這幾行在複製一次就好了，記得修改圖片名稱
			 */
			if($tmp['pic2'] != ''){
				$tmp2 = array(
					'url' => $tmp['url1'],
					'pic1' => '_i/assets/upload/'.$this->data['router_method'].'type/'.$tmp['pic2'], // Banner的大圖，你一定會問，$tmp['pic1']是什麼，它是代表圖啦
				);
				// Banner的小圖
				if(isset($tmp['pic3']) and $tmp['pic3'] != ''){
					$tmp2['pic2'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$tmp['pic3'];
				} else {
					$tmp2['pic2'] = $tmp2['pic1'];
				}
				if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/banner'][0])) $data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/banner'][0]][] = $tmp2;
			}
		}

		// 商品
		$db = new Mysqleric(array('table'=>$this->data['router_method'].' AS a'));

		$qryField = ' a.*, b.sort_id AS sort_id_multisort ';

		$qryWhere = '';

		$qryWhere .= ' LEFT JOIN '.$this->data['router_method'].'multisort AS b ';
		//$qryWhere .= '   ON b.product_id=a.id AND a.class_ids LIKE CONCAT("%,",b.class_id,",%") ';
		$qryWhere .= ' ON b.product_id=a.id AND b.class_id='.$id;

		if($is_promotion){ 

			if(isset($_ids[$id])){
				$_count = count($_ids[$id]); //配合上面的程式 改用 $_ids
			}else{
				$_count = 0;
			}

			if($_count <= 0){
				//$qryWhere .= ' WHERE a.is_enable=1 AND a.ml_key=\''.$this->data['ml_key'].'\' ';	
				$qryWhere .= ' WHERE 0 AND a.ml_key=\''.$this->data['ml_key'].'\' ';	
			} else {
				$qryWhere .= ' WHERE a.is_enable=1 AND a.id IN ( '.implode(',', $_ids[$id]).' ) AND a.ml_key=\''.$this->data['ml_key'].'\' ';	
			}
		} else {
			$qryWhere .= ' WHERE a.is_enable=1 AND a.class_ids LIKE "%,'.$id.',%" AND a.ml_key=\''.$this->data['ml_key'].'\'';	
		}

		// 上架時間
		$qryWhere .= ' AND (a.date1 <= NOW() OR a.date1 IS NULL OR a.date1 = "0000-00-00") AND (a.date2 >= NOW() OR a.date2 IS NULL OR a.date2 = "0000-00-00") ';

		//echo $qryWhere;die;

		// 側邊條件搜尋、以及右上的下拉條件搜尋
		// 如果要改，下面還有要記得一起改
		if(isset($shop_filter_ids) and !empty($shop_filter_ids)){
			$qryWhere .= ' and id IN ('.implode(',',$shop_filter_ids).') ';
		} else {
			//$qryWhere .= ' and 0 ';
		}
		if(isset($_SESSION['save'][$this->data['router_method'].'_filter_price']['min']) and $_SESSION['save'][$this->data['router_method'].'_filter_price']['min'] >= 0){
			$qryWhere .= ' and price_search >= '.$_SESSION['save'][$this->data['router_method'].'_filter_price']['min'].' ';
		}
		if(isset($_SESSION['save'][$this->data['router_method'].'_filter_price']['max']) and $_SESSION['save'][$this->data['router_method'].'_filter_price']['max'] >= 0){
			$qryWhere .= ' and price_search <= '.$_SESSION['save'][$this->data['router_method'].'_filter_price']['max'].' ';
		}
		if(isset($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'])){
			if($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '2'){
				$qryWhere .=' order by price_search ';
			} elseif($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '1'){ 
				$qryWhere .=' order by price_search desc';
			} elseif($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '4'){ 
				$qryWhere .=' order by id desc';
			} elseif($_SESSION['save'][$this->data['router_method'].'_ajax']['dropdown_filter'] == '3'){ 
				$qryWhere .=' order by id asc';
			}
		} else {
			$qryWhere .=' order by sort_id_multisort';
		}

		//echo $qryWhere;

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
				$db->row['url3'] = 'save.php?id='.$this->data['router_method'].'inquiry&_append=&amount=1&primary_key='.$db->row['id'];
				// $db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];
				//2021/1/8 改為顯示thumb縮圖 #38363
				$db->row['pic'] = L::show_thumb_pic($db->row['pic1'],$this->data['router_method'],'300x300');

				// 選規格的浮出來的選單在用的(看產品詳細)
				$db->row['url'] = $db->row['url1'];

				// 其實這裡應該是，後台要在新增另外一個欄位，只是懶的新增，所以先註解起來
				//$db->row['name2'] = $db->row['detail'];

				//$db->row['name2'] = $db->row['name'];

				//$db->row['name'] = $tmp['name'];

				// $db->row['price'] = 'NT$'.number_format($db->row['price']);
				// $db->row['price2'] = 'NT$'.number_format($db->row['price2']);

				$db->row['price'] = 0;
				$db->row['price2'] = 0;
				$rowg = $this->cidb->where('is_enable',1)->where('data_id',$db->row['id'])->get('shopspec')->row_array();
				if($rowg and isset($rowg['id'])){
					$db->row['price'] = $rowg['price'];
					$db->row['price2'] = $rowg['price2'];

					//先查詢該產品是否有主題活動, 使用$_ids參照，符合的話就撈主題活動資料
					$_action2 = $_action1 = 0;
					if(isset($_ids) && count($_ids) > 0){
						foreach ($_ids as $key => $value) {
							if(in_array($db->row['id'], $value)){
								$v = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$key))->queryRow();
								if($v['condition1']=='2' && $v['condition2']=='1'){
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
							eval('$db->row[\'price2\'] = round2($db->row[\'price2\'] * 0.' . $_action2 . ',0);');		
						}
						if($_action1=='2'){ //定額
							$db->row['price2'] = $_action2;
						}
						if($_action1=='3'){ //折抵
							$db->row['price2'] = $rowg['price2'] - $_action2;
							if($db->row['price2'] < 0){
								$db->row['price2'] = 0;
							}
						}
					}
				}

				foreach(array('price','price2') as $_price){
					$db->row[$_price.'_format'] = number_format($db->row[$_price]);
					$db->row[$_price.'_format_ds'] = '$'.$db->row[$_price.'_format'];
					$db->row[$_price.'_format_ds_nt'] = 'NT'.$db->row[$_price.'_format_ds'];
				}

				$db->row['img_alt'] = $db->row['name']; // SEO

				//$db->row['content1'] = $db->row['field_data'];
				//$db->row['content2'] = $db->row['field_tmp'];

				// 檢查收藏
				$db->row['has_favorite'] = 0;
				if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
					$row = $this->db->createCommand()->from('html')->where('(start_date BETWEEN NOW() - INTERVAL 20 DAY AND NOW() ) and is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id'/*other2是規格編號*/,array(':id'=>$db->row['id'],':member_id'=>$this->data['admin_id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
					if(isset($row['id']) and $row['id'] > 0){
						$db->row['has_favorite'] = 1;
					}
				} else {
					if(isset($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite']) and !empty($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'])){
						foreach($_SESSION['save'][str_replace('detail','',$this->data['router_method']).'_favorite'] as $k => $v){
							if(preg_match('/^'.$db->row['id'].'_(\d+)$/', $k)){
								$db->row['has_favorite'] = 1;
								break;
							}
						}
					}
				}

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}

		// 這裡是從source/favorite/list.php複製過來的
		$items2 = $DataList;

		// 目前有跟source/favorite/list.php和首頁的共用
		include 'source/shop/spec_float_include.php';

		$DataList = $items2;

		$data2[$ID]['multi'][] = $DataList;
		$data2[$ID]['single'][] = array(
			'count' => count($DataList),
		);

	}
} // 是或不是產品搜尋
