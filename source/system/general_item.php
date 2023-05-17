<?php

// 2020-07-16 多層文章功能，跟預載的source/system/general_item.php會衝突
// if(!preg_match('/^(social|articlemulti)$/', $this->data['router_method'])){

// 2019-12-18
// 為了要加大這個通用列表的彈性
$router_method = $this->data['router_method']; // 一般的
$item_list_router_method = $this->data['router_method']; // 分項列表中的網址欄位所使用

//判斷是否讀取促銷活動的資料
$id = 0;
$is_promotion = false;
if (isset($_GET['id'])) {
	if (preg_match('/^s(\d+)$/', $_GET['id'], $matches)) {
		$id = $matches[1];
		$is_promotion = true;
		//判斷如果沒有這個活動，就跳到首頁
		$_howhow = $this->cidb->where('id', $id)->get($this->data['router_method'] . 'promotion')->row_array();
		if (!$_howhow) {
			header('Location: index_' . $this->data['ml_key'] . '.php');
			die;
		}
	} else {
		$id = intval($_GET['id']);

		//判斷如果沒有這個分類，就跳到首頁
		//$_howhow = $this->cidb->where('id',$id)->get($this->data['router_method'].'type')->row_array();
		//if(!$_howhow){
		//	header('Location: index_'.$this->data['ml_key'].'.php');
		//	die;
		//}
	}
}

if ($is_promotion and $router_method == 'shop') { //改為預設都要判斷是否有主題活動的參照，如果該站沒主題活動，這邊可以關閉 by lota
	// 複選分類參考用
	$rowsx = $this->db->createCommand()->from($router_method . 'promotion')->where('is_enable=1 and is_increase_purchase!=1 and is_promo!=1 and ml_key=:ml_key', array(':ml_key' => $this->data['ml_key']))->queryAll();
	$multi_item_tmp = array();
	$multi_item = array();
	if ($rowsx) {
		foreach ($rowsx as $k => $v) {
			if ($v['class_ids'] == '') continue;
			$ids = explode(',', $v['class_ids']);
			if ($ids) {
				foreach ($ids as $kk => $vv) {
					if ($vv == '') continue;
					$multi_item_tmp[$vv][$v['id']] = '1';
				}
			}
		}
		if ($multi_item_tmp) {
			foreach ($multi_item_tmp as $k => $v) {
				//找尋對應的產品並加入到要顯示的變數內
				$rowsxx = $this->cidb->where('is_enable', 1)->where('ml_key', $this->data['ml_key'])->like('class_ids', ',' . $k . ',')->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "' . date('Y-m-d') . '" OR date2 IS NULL OR date2 = "0000-00-00")')->get($this->data['router_method'])->result_array();
				foreach ($rowsxx as $kk => $vv) {
					$multi_item[$k][] = $vv['id'];
				}

				// 2021-06-06 這段怪怪的..註解掉改用上面的程式碼 by lota
				// foreach($v as $kk => $vv){
				// 	$multi_item[$k][] = $kk;
				// }
			}
		}
	}

	$_ids = array();
	// 2020-11-05 依照所勾選的分類，把產品給抓進來
	// $v = $this->db->createCommand()->from($this->data['router_method'].'promotion')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$id))->queryRow();
	//改為預設都要判斷是否有主題活動的參照
	$_iids = $this->db->createCommand()->from($this->data['router_method'] . 'promotion')->where('is_enable=1 and ml_key=:ml_key', array(':ml_key' => $this->data['ml_key']))->queryAll();
	if ($_iids) {
		foreach ($_iids as $key => $v) {

			$ids_tmp = array(); //重設暫存

			//2020-11-23 如果主題活動條件為"滿件"而且數量為"1" lota 這邊不需要了，判斷改為產品那邊比對到後再抓
			// if($v['condition1']=='2' && $v['condition2']=='1'){
			// 	// var_dump($v);die;
			// 	$_action1 = $v['action1'];
			// 	$_action2 = $v['action2'];
			// }
			$v['time'] = strtotime($v['start_time']);
			$v['time2'] = strtotime($v['end_time']);

			if ($v['time'] < 0) $v['time'] = 0;
			if ($v['time2'] < 0) $v['time2'] = 0;
			//  先檢查時間
			// if($v['time'] > 0){ //不需要判斷啟始時間 by lota fix 2020-11-16
			$now = strtotime(date('Y-m-d H:i:s'));
			//echo date('Y-m-d H:i:s');
			//echo $now;die;
			if ($now >= $v['time']) {
				// OK
			} else {
				unset($tmps2[$k]);
				continue;
			}
			if ($v['time2'] > 0) {
				if ($now < $v['time2']) {
					// OK
				} else {
					unset($tmps2[$k]);
					continue;
				}
			}
			// }
			if ($v['class_ids'] != ''  and $v['scope'] == '0') {
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
				foreach ($tmps as $kk => $vv) {
					if (isset($multi_item[$vv]) and !empty($multi_item[$vv])) {
						foreach ($multi_item[$vv] as $kkk => $vvv) {
							$ids_tmp[$vvv] = '1';
						}
					}
				}
			}
			// 2020-11-05 依照所選擇的產品抓進來，跟上面的東西併在一起
			if (isset($v['scope']) && ($v['scope'] == '1' or $v['scope'] == '0')) {
				$v2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and class_id=:id', array(':type' => $this->data['router_method'] . 'promotionrelatedids', ':ml_key' => $this->data['ml_key'], ':id' => $id))->queryAll();
				if ($v2) {
					foreach ($v2 as $kk => $vv) {
						if ($vv['other1'] != '') {
							$ids_tmp[$vv['other1']] = '1';
						}
					}
				}
			}
			// 套用全部
			if (isset($v['scope']) && $v['scope'] == '2') {
				$v2 = $this->db->createCommand()->from($prefix . 'type')->where('is_enable=1 and ml_key=:ml_key', array(':ml_key' => $this->data['ml_key']))->queryAll();
				if ($v2 and !empty($v2)) {
					foreach ($v2 as $kk => $vv) {
						if (isset($multi_item[$vv['id']]) and !empty($multi_item[$vv['id']])) {
							foreach ($multi_item[$vv['id']] as $kkk => $vvv) {
								$ids_tmp[$vvv] = '1';
							}
						}
					}
				}
			}
			// 把分類和商品merge好的東西放在另一個陣列元素
			if (!empty($ids_tmp)) {
				foreach ($ids_tmp as $kk => $vv) {
					// $ids[] = $kk;
					$_ids[$v['id']][] = $kk; //用 $_ids 是避免被下面規則洗掉...
				}
			}
		}
	}
	// 這裡註解，是因為最下面只會用到$ids陣列
	// $v['ids'] = $ids;
	// var_dump($_ids);die;
} // is_promotion

/* 
 * 2018-10-09
 *
 * 搜尋的使用說明
 *
 * 就在列表的那一個view的下面，增加view裡面的system/search
 * 然後把後台該page裡面，把share-search給打勾就可以了
 */

// 長新貿
// 功能需要登入驗證的情況，範例程式碼
if (0 and preg_match('/^(newproduct|download)$/', $router_method)) {
	if (isset($this->data['admin_id']) and $this->data['admin_id'] > 0) {
	} else {
		$ggg = t('Please Login', 'en');
		echo '<meta charset="utf-8">';
		echo '<script type="text/javascript">alert("' . $ggg . '");window.location.href="memberlogin_' . $this->data['ml_key'] . '.php?next=newproduct_' . $this->data['ml_key'] . '.php";</script>';
		die;
	}
}

// 2020-07-06 一個功能，只有一組密碼
// #36317
// 相關檔案
// source/menu/v2.php
// source/system/general_item.php
// $rowg = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','videologin')->get('html')->row_array();
// if($rowg and isset($rowg['id']) and isset($_SESSION['media_password']) and $_SESSION['media_password'] != '' and $_SESSION['media_password'] == $rowg['other1']){
// 	// do nothing
// } else {
// 	header('Location: index_'.$this->data['ml_key'].'.php');
// }

//  搜尋無限層結構裡面的某個編號底下的相關項目 
// https://stackoverflow.com/questions/8656682/getting-all-children-for-a-deep-multidimensional-array#8656748
if (!function_exists('getChildrenFor')) {
	function getChildrenFor($ary, $id, $pid_name = 'pid', $child_name = 'child')
	{
		$results = array();
		$ggg = array();

		foreach ($ary as $el) {
			if ($el[$pid_name] == $id) {
				$results[] = $el;
			}
			//if(isset($el[$child_name]) and count($el[$child_name]) > 0 and ($children = getChildrenFor($el[$child_name], $id, $pid_name, $child_name)) !== FALSE){
			if (isset($el[$child_name]) and !empty($el[$child_name]) and ($children = getChildrenFor($el[$child_name], $id, $pid_name, $child_name)) !== FALSE) {
				$results = array_merge($results, $children);
			}
		}

		return count($results) > 0 ? $results : FALSE;
	}
}

// SEO 分類
$seos = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type', array(':ml_key' => $this->data['ml_key'], ':type' => $router_method . 'type'))->queryAll();
$seos_type_tmp = array();
if ($seos) {
	foreach ($seos as $k => $v) {
		$seos_type_tmp[$v['seo_item_id']] = $v;
	}
}

// SEO 項目
// 通常SEO都是做在分類上面，不過這裡還是先撰寫，然後給該功能的source/XXX/general_item.php所使用
$seos = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type', array(':ml_key' => $this->data['ml_key'], ':type' => $router_method))->queryAll();
$seos_tmp = array();
if ($seos) {
	foreach ($seos as $k => $v) {
		$seos_tmp[$v['seo_item_id']] = $v;
	}
}

$pagew = 1; // Splitpage
if (isset($_GET['page']) and $_GET['page'] > 0) {
	$pagew = $_GET['page'];
}
$limit_count = 12; //一頁顯示幾筆
$pageRecordInfo = array();

$row = $this->db->createCommand()->from('html')->where('is_home =1 and type=:type and url1=:url and ml_key=:ml_key', array(':type' => 'webmenu', ':url' => $router_method . '_' . $this->data['ml_key'] . '.php', ':ml_key' => $this->data['ml_key']))->queryRow();
if ($row and !isset($_GET['q'])) { // #33338
	$common_is_enable = $row['is_home'];
	$common_is_category = $row['pic2']; // 有沒有分類
	$common_category = $row['is_news']; // 是或不是通用分類
	$common_category_type_name = $row['other22']; // 用別人的
	$common_category_multiple = $row['other26']; // 切換成"多分類排序"
	/* └ */
	$category_multiple_other_sql = ''; // 2020-12-28 多分類排序的SQL語法專用
	$common_item = $row['class_ids'];   // 是或不是通用分項
	$common_date_sort = $row['pic3'];
	// $common_articlesingle = $row['is_top']; // 單頁專用
	$common_has_listpage = $row['other5']; // 列表頁，如果要外掛搜尋功能，請記得開啟列表頁
	$common_limit_count = $row['other6']; // 每頁幾筆
	$common_action_by_categoryurl = $row['other13']; // 點擊分類的動作
	$common_action_by_categoryurl_param1 = $row['other14']; // 點擊分類的動作(引數1)
	$common_date_range = $row['other24']; // date1, date2 下架時間

	// 現在列表區，顯示的是什麼東西(1:category, 2:object, 3:mix)
	$common_content_type = 0;

	if ($common_limit_count != '') {
		$limit_count = $common_limit_count;
	}

	// 2019-12-18 實際上運作的變數
	$table_category = '';
	$table = '';

	$where = $where_category = array(
		'is_enable' => 1,
		'ml_key' => $this->data['ml_key'],
		// 'type' => $router_method,
		// 'class_id' => $class_id,
	);

	$where_in = null;

	// 2019-12-18 先將分類和分項的資料表名稱先準備好，實際上不是運作這個變數
	$type_name = $router_method . 'type';
	if ($common_category_type_name != '') {
		$type_name = $common_category_type_name;
	}
	$alias_name = $router_method;

	// 2019-12-19 先把分項裡面的單複選分類索引欄位名稱，先準備好，以便提供其它需求的客製
	$class_id_name = 'class_id';
	$class_ids_name = 'class_ids';

	// 2019-12-18
	// 益麟 || 勾選最新產品，顯示在另一個功能
	//
	// 要複製source/product資料夾
	// 後台的前台主選單，要選擇通用分類、和通用分項，這樣麵包屑那邊才不會壞掉
	// 要建這個最新產品的page內頁(但是它結構裡面不用建)，這樣網址才會正常出現
	//
	// if($router_method == 'hot'){
	// 	$common_is_category = 1;
	// 	$common_category = 0;
	// 	$common_item = 0;
	//
	// 	$type_name = 'producttype';
	// 	$alias_name = 'product';
	// 	$item_list_router_method = 'product';
	//
	// 	// 加條件
	// 	$where['is_home'] = 1;
	// }

	// 五綸 || 捷弘 || 兩個分類，一個分項 (未測試)
	// 現在可以用分類提升的方式，來解決兩個分類的情況，所以這邊應該是用不到 ; 除非是兩個分類不同的view
	//
	// 相關檔案：
	// source/system/general_item.php
	// source/menu/sub.php
	// source/product/general_item.php
	//
	// if($router_method == 'product2'){
	// 	$alias_name = 'product';
	// 	$class_id_name = 'class_id2';
	// 	$item_list_router_method = 'product';
	// }

	if ($common_is_category == 1) { // 分類列表

		if ($common_category == 1) { // 是通用分類
			$where_category['type'] = $type_name;
			$table_category = 'html';
		} else { // 是獨立分類
			$table_category = $type_name;
			// 有用到，在去產品那邊複製就好了
		}

		// 如果是分類，但沒有帶分類編號，那自動會轉去第一個
		if ($id == 0) {
			if ($common_has_listpage >= '1') { // 列表頁
				$url = $url_prefix . $router_method . $url_suffix . '?page=';
			} else {
				if (isset($_GET['q']) and $_GET['q'] != '') {
					$url = $url_prefix . $router_method . $url_suffix . '?q=' . $_GET['q'] . '&page=';
				} else {
					// $tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>$router_method.'type',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

					if ($common_category == 1) { // 是通用分類
						// do nothing
					} else {
						$where_category['pid'] = 0; // 分類，如果網址有效的話適用
					}
					$tmp = $this->cidb->where($where_category)->order_by('sort_id')->get($table_category)->row_array();

					if ($tmp and isset($tmp['id'])) {

						// 預設是找第一個網址
						// 這裡不用加 $url_prefix，因為有資料夾的網址，在加的話，就變成tw/tw/xxx.php，所以先拿掉觀察看看 2019-05-22
						if (isset($seos_type_tmp[$tmp['id']]) and $seos_type_tmp[$tmp['id']]['seo_script_name'] != '') {
							//$redirect_url = $seos_type_tmp[$tmp['id']]['seo_script_name'].'.html?page=';
							$redirect_url = $seos_type_tmp[$tmp['id']]['seo_script_name'] . '.html'; // 因為下面接的是轉跳，所以不會經過分頁的程序
						} else {
							$redirect_url = $router_method . $url_suffix . '?id=' . $tmp['id'];
						}

						// 2018-12-10
						// http://redmine.buyersline.com.tw:4000/issues/30329
						// 從得億國際的這個網站發現的問題，還裡還算是Beta
						$ary = array();

						$view_file = 'system/empty_datasource/sidemenu';
						if ($common_action_by_categoryurl_param1 != '') {
							$view_file = $common_action_by_categoryurl_param1;
						}

						// 2018-04-25 這裡抓不到資料流，因為source/menu/sub.php的優先順序異常，低於system/general_item.php
						if (isset($layoutv3_struct_map_keyname[$view_file][0]) and isset($data[$layoutv3_struct_map_keyname[$view_file][0]])) {
							$ary = $data[$layoutv3_struct_map_keyname[$view_file][0]];
						}

						// 這裡會接著找第一個有效網址
						$aaas = explode("\n", var_export($ary, true));
						//if($aaas and count($aaas) > 0){
						if ($aaas and !empty($aaas)) {
							foreach ($aaas as $kk => $vv) {
								if (preg_match('/\'url\'\ \=\>\ \'(.*)\'\,/', $vv, $matches)) {
									if ($matches[1] != '' and $matches[1] != '#' and $matches[1] != 'javascript:;') {
										$redirect_url = $matches[1];
										break;
									}
								}
							}
						}

						if (1) {
							header('Location: ' . $redirect_url);
							die;
						} else {
							// A方案，含左側選單專用
?>
<script type="text/javascript">
window.location.href = '<?php echo $redirect_url ?>';
</script>
<?php
						}
					} else {
						// 如果有分項，而且完全沒分類，這時就會變成列表頁，是總經理建議這樣處理 by lota 2017/10/20
						$url = $url_prefix . $router_method . $url_suffix . '?page=';
					}
				}
			} // common has listpage
		} else {
			$class_id = $id;

			// $table 要下面的時候，才會指定
			// $where['class_id'] = $class_id;

			if (isset($seos_type_tmp[$class_id]) and $seos_type_tmp[$class_id]['seo_script_name'] != '') {
				$url = $url_prefix . $seos_type_tmp[$class_id]['seo_script_name'] . '.html?page=';
			} else {
				if ($is_promotion === true) { //如果是購物活動要記得加上s by lota 2021/11/12
					$url = $url_prefix . $router_method . $url_suffix . '?id=s' . $class_id . '&page=';
				} else {
					$url = $url_prefix . $router_method . $url_suffix . '?id=' . $class_id . '&page=';
				}
			}
		} // isset _GET id

	} else { // 分項列表
		$url = $url_prefix . $router_method . $url_suffix . '?page=';
	}


	// if(isset($_GET['id'])){
	if ($id > 0 and $common_is_category == 1) { // 2018-11-06 試著修修看，不然A方案一打開，像公司簡介那種功能，就會報錯了
		if ($common_action_by_categoryurl == '' or $common_action_by_categoryurl == '0') { // 當層"分類以外"的項目 (預設)
			$common_content_type = 2;
			$where[$class_id_name] = $class_id;
			if ($common_item == 1) { // 是通用分項
				$where['type'] = $alias_name;
				$table = 'html';
			} else { // 獨立分項
				$table = $alias_name;
			}
		} elseif ($common_action_by_categoryurl == '1') { // 當層分類，最末層顯示產品
			$common_content_type = 1;
			if ($common_category == 1) { // 是通用分類
				$where['type'] = $type_name;
				$where[$class_id_name] = $id;
				$table = 'html';
			} else { // 獨立分類
				$where['pid'] = $id;
				$table = $type_name;
			}
			$o = $this->cidb->where($where);
			$rows = $o->get($table)->result_array();
			$total_rows = count($rows);
			if ($total_rows <= 0) {
				$common_content_type = 2;
				unset($where['pid']); // 先刪在說
				$where[$class_id_name] = $id; // 因為不管是通用還是獨立，分項的部份都是用class_id

				// 第二點，走到最末層以後，就跑跟第一點一樣的內容
				if ($common_item == 1) { // 是通用分項
					$where['type'] = $alias_name;
					$table = 'html';
				} else { // 獨立分項
					$table = $alias_name;
				}
			}
		} elseif ($common_action_by_categoryurl == '2') { // 該層"分類以外"的項目 (遞迴，含自己)
			$common_content_type = 2;
			$ary = array();

			// 2018-04-27 因為預設的layout_sidemenu的洞，sidemenu的所在位置，比這支(source/system/general_item.php)還低，所以這個地方是抓不到資料流的
			// $view_file = 'default/promenu';
			// $view_file = 'default/sidemenu';
			// if($common_action_by_categoryurl_param1 != ''){
			// 	$view_file = $common_action_by_categoryurl_param1;
			// }

			$view_file = 'system/empty_datasource/sidemenu';
			if ($common_action_by_categoryurl_param1 != '') {
				$view_file = $common_action_by_categoryurl_param1;
			}
			//var_dump($data);die;
			// 2018-04-25 這裡抓不到資料流，因為source/menu/sub.php的優先順序異常，低於system/general_item.php
			if (isset($layoutv3_struct_map_keyname[$view_file][0]) and isset($data[$layoutv3_struct_map_keyname[$view_file][0]])) {
				$ary = $data[$layoutv3_struct_map_keyname[$view_file][0]];
			}

			// 當使用元素(好記的名稱)來init的時候，這裡就要打開，因為好記的名稱，它的執行層級是在source/core.php
			if (0) {
				$ary = $this->data['_sub'];
			}

			// 2020-10-14 A方案可能會用到
			// 次選單不顯示，而且產品要遞迴顯示的狀況
			// $ary = $this->data['_webmenu_top'][3]['child'];

			// 2018-04-25 暫時的硬修
			// $view_fileg = 'v3/header/nav_menu2';
			// if(isset($layoutv3_struct_map_keyname[$view_fileg][0]) and isset($this->data['func_name_id']) and $this->data['func_name_id'] > 0){
			// 	$tmps = $data[$layoutv3_struct_map_keyname[$view_fileg][0]];
			// 	if($tmps and count($tmps) > 0){
			// 		foreach($tmps as $k => $v){
			// 			if($v['id'] == $this->data['func_name_id'] and isset($v['child']) and count($v['child']) > 0){
			// 				$ary = $v['child'];
			// 				break;
			// 			}
			// 		}
			// 		// $data[$ID] = $row;
			// 	}
			// }

			$ids = array(); // 修過未測試 2018-08-20
			//if(count($ary) > 0){
			if (!empty($ary)) {
				$find_array = getChildrenFor($ary, $id, 'pid', 'child');
				$ary_text = var_export($find_array, true);
				$arys = explode("\n", $ary_text);
				//var_dump($arys);die;

				$ids[] = $id;
				foreach ($arys as $k => $v) {
					//         'id' => '9',
					if (preg_match('/^(.*)\'id\'\ =>\ \'(.*)\'\,$/', $v, $matches)) {
						$ids[] = (int)$matches[2];
					}
				}
				// var_dump($ids);die;
			}

			// 修過未測試 2018-08-20
			//if(count($ids) > 0){
			if (!empty($ids)) {
				$where_in[0] = $class_id_name;
				$where_in[1] = $ids;
			}

			if ($common_item == 1) { // 是通用分項
				$where['type'] = $alias_name;
				$table = 'html';
			} else { // 獨立分項
				$table = $alias_name;
				// 五綸的模式下，不要選擇遞迴這一項
			}
		} elseif ($common_action_by_categoryurl == '3') { // 當層的所有東西 (分類與非分類)
			$common_content_type = 3;
			// 先規劃，下次在寫
		}
	}

	// 當在列表頁，而且沒參數的時候，就看情況覆寫
	if ($id == 0) {
		if ($common_is_category == 1 and $common_has_listpage == 2) { // 頂層分類列表
			$common_content_type = 1;
			if ($common_category == 1) { // 是通用分類
				$where['type'] = $type_name;
				$where[$class_id_name] = 0;
				$table = 'html';
			} else { // 獨立分類
				$where['pid'] = 0;
				$table = $type_name;
			}
		} elseif ($common_is_category == 1 and $common_has_listpage == 3) { // 2020-10-16 頂層以外的分類列表(祖師禪林) 
			$common_content_type = 1;
			if ($common_category == 1) { // 通用分類，因為只有單層，所以維持跟頂層分類一樣的狀況
				$where['type'] = $type_name;
				$where[$class_id_name] = 0;
				$table = 'html';
			} else { // 獨立分類
				$where['pid !='] = 0;
				$table = $type_name;
			}
		} elseif ($common_has_listpage == 1) { // 顯示所有物件
			$common_content_type = 2;
			if ($common_item == 1) { // 是通用分類
				$where['type'] = $alias_name;
				$table = 'html';
			} else { // 獨立分類
				$table = $alias_name;

				if ($common_is_category == 1 and $common_category_multiple == '0') { // 2020-12-24 other26 單選分類，才會執行裡面的東西，複選是不會的
					// 2020-04-17 李哥下午口頭說的
					// 修正在總覽頁，沒選分類的項目，或是分類關掉的項目，點下去到內頁，會出現麵包屑導向到首頁的問題
					$rowscc = $this->cidb->where('is_enable', 1)->where('ml_key', $this->data['ml_key'])->get($type_name)->result_array();
					$rowscc_ids = array();
					if (!empty($rowscc)) {
						foreach ($rowscc as $k => $v) {
							$rowscc_ids[] = $v['id'];
						}
						$where_in[0] = $class_id_name;
						$where_in[1] = $rowscc_ids;
					}
				}
			}
		}
	}

	// 2018-10-30 分類選單加密碼功能
	if (0 and preg_match('/^(download)$/', $router_method)) {
		if ($common_is_category == 1 and $common_category == 1 and isset($_SESSION['media_password']) and $_SESSION['media_password'] != '') {
			//$rowgg = $this->cidb->where('is_enable',1)->where('other1', $_SESSION['media_password'])->where('type','downloadtype')->where('id', $_GET['id'])->get('html')->row_array();
			//改為如果有輸入密碼才做判斷 by lota 2018-12-14
			$rowgg = $this->cidb->where('is_enable', 1)->where('type', 'downloadtype')->where('id', $id)->get('html')->row_array();
			if ($rowgg and isset($rowgg['id'])) {
				if ($rowgg['other1'] != '') {
					if ($rowgg['other1'] == $_SESSION['media_password']) {
						// do nothing
					} else {
						$where['sort_id'] = 9999999999;
					}
				}
			} else {
				$where['sort_id'] = 9999999999;
			}
		} else {
			$where['sort_id'] = 9999999999;
		}
	}

	// 五綸 || 捷弘 || 兩個分類，一個分項 (舊的)
	// 現在可以用分類提升的方式，來解決兩個分類的情況，所以這邊應該是用不到
	//
	// 相關檔案：
	// source/system/general_item.php
	// source/menu/sub.php
	// source/product/general_item.php
	//
	// if($router_method == 'product2'){
	// 	$table = 'product';
	// 	unset($where['type']);
	// 	unset($where['class_id']);
	// }

	if (isset($_SESSION['save'][$router_method . '_filter_price']['min']) and $_SESSION['save'][$router_method . '_filter_price']['min'] >= 0) {
		$where['price_search >='] = $_SESSION['save'][$router_method . '_filter_price']['min'];
		$category_multiple_other_sql .= ' and a.price_search >= ' . $_SESSION['save'][$router_method . '_filter_price']['min'] . ' ';
	}
	if (isset($_SESSION['save'][$router_method . '_filter_price']['max']) and $_SESSION['save'][$router_method . '_filter_price']['max'] >= 0) {
		$where['price_search <='] = $_SESSION['save'][$router_method . '_filter_price']['max'];
		$category_multiple_other_sql .= ' and a.price_search <= ' . $_SESSION['save'][$router_method . '_filter_price']['max'] . ' ';
	}

	//查詢ID的類別資料 for product by lota
	//if($router_method=='product' && isset($_GET['id'])){
	//	$_tmp_row = $this->db->createCommand()->from($router_method.'type')->where('is_enable =1 and ml_key=:ml_key and id='.intval($_GET['id']),array(':ml_key'=>$this->data['ml_key']))->queryRow();	
	//}

	// 在沒有列表頁的情況，如果沒有分類或是分項，那這裡要做判斷，不然會報錯
	//20221101 #45907 增加判斷發佈日期----------------------------------------------------------------------------------start	
	$reserve_data = $this->cidb->where('keyname','function_constant_news_reserve')->get('sys_config')->row_array();		
	//-------------------------------------------------------------------------------------------------------------------end
	$total_rows = 0;
	$rows = array();
	if ($table != '') {
		if ($common_category_multiple == '1' and ($common_has_listpage == 0 or $id > 0)) { // other26 多分類排序 2018-10-22
			// $sql = 'SELECT a.* FROM '.str_replace('type','',$table).' AS a LEFT JOIN '.$router_method.'type AS b ON b.id=a.class_id ';
			// $sql .= 'WHERE a.is_enable=1 AND b.id > 0 AND a.ml_key=\''.$this->data['ml_key'].'\' and a.class_ids like \'%,'.$_GET['id'].',%\' ';	

			$sql = 'SELECT a.*, b.sort_id AS sort_id_multisort FROM ' . str_replace('type', '', $table) . ' AS a ';
			$sql .= 'LEFT JOIN ' . $router_method . 'multisort AS b ON b.product_id=a.id AND b.class_id=' . $id . ' '; // 2019-12-19 這個class_id欄位不會變，千萬不要把變數套到這裡
			// $sql .= 'WHERE a.is_enable=1 AND a.ml_key=\''.$this->data['ml_key'].'\' AND a.'.$class_ids_name.' LIKE \'%,'.$id.',%\' '.$category_multiple_other_sql; //這段跟下面的	718行沒有對稱..先註解 by lota 2021/11/12
			$sql .= 'WHERE a.is_enable=1 AND a.ml_key=\'' . $this->data['ml_key'] . '\' ' . $category_multiple_other_sql;

			if ($is_promotion === true and $id > 0) {
				if (isset($_ids[$id])) {
					$_count = count($_ids[$id]); //配合上面的程式 改用 $_ids
				} else {
					$_count = 0;
				}

				if ($_count <= 0) {
					$sql .= ' AND 0 ';
				} else {
					$sql .= ' AND a.id IN ( ' . implode(',', $_ids[$id]) . ' ) ';
				}
			} else {
				$sql .= ' AND a.' . $class_ids_name . ' LIKE \'%,' . $id . ',%\' ';
			}

			if ($common_date_range == '1') {
				$sql .= ' and (a.date1 <= now() OR a.date1 IS NULL OR a.date1 = "0000-00-00") AND (a.date2 >= "' . date('Y-m-d') . '" OR a.date2 IS NULL OR a.date2 = "0000-00-00")';
			}

			$rows = $this->cidb->query($sql)->result_array();
		} else {
			$o = $this->cidb->where($where);
			if ($common_date_range == '1') {
				$o->where('(date1 <= now() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= "' . date('Y-m-d') . '" OR date2 IS NULL OR date2 = "0000-00-00")');
			}
			//20221101 #45907 增加判斷發佈日期----------------------------------------------------------------------------------start
			if(stristr($router_method,'news')){
				$o->where('(reserve_date <= now() OR reserve_date IS NULL OR reserve_date = "0000-00-00")');
				$o->where('(retirement_date > now() OR retirement_date IS NULL OR retirement_date = "0000-00-00")');
				
			}
			//-------------------------------------------------------------------------------------------------------------------end
			if (!is_null($where_in)) {
				$o->where_in($where_in[0], $where_in[1]);
			}
			//2021-05-05 擴充where_like by lota
			if (!empty($where_like)) {
				$o->like($where_like);
			}
			$rows = $o->get($table)->result_array();
		}
		$total_rows = count($rows);
		
		// 2018-09-10 當編排頁想要使用通用分項，且有分頁的情況
		if (isset($old_router_method) and preg_match('/_/', $old_router_method)) {
			$tmps = explode('_', $old_router_method); // download_1
			if ($id > 0) {
				$url = $tmps[0] . '_' . $this->data['ml_key'] . '_' . $tmps[1] . '.php?id=' . $id . '&page=';
			} else {
				$url = $tmps[0] . '_' . $this->data['ml_key'] . '_' . $tmps[1] . '.php?page=';
			}
		}

		include _BASEPATH . '/../source/core/pagination.php';

		if ($common_category_multiple == '1' and ($common_has_listpage == 0 or $id > 0)) { // other26 多分類排序 2018-10-22
			// $sql = 'SELECT a.* FROM '.str_replace('type','',$table).' AS a LEFT JOIN '.$this->data['router_method'].'type AS b ON b.id=a.class_id ';
			// $sql .= 'WHERE a.is_enable=1 AND b.id > 0 AND a.ml_key=\''.$this->data['ml_key'].'\' and a.class_ids like \'%,'.$_GET['id'].',%\' ';	
			// $sql .= 'ORDER BY a.sort_id_browser '; // 2017-03-29 李哥早上建議的，因為經理要在晨寬的影片加這個，還有多分類排序

			$sql = 'SELECT a.*, b.sort_id AS sort_id_multisort FROM ' . str_replace('type', '', $table) . ' AS a ';
			$sql .= 'LEFT JOIN ' . $router_method . 'multisort AS b ON b.product_id=a.id AND b.class_id=' . $id . ' ';
			$sql .= 'WHERE a.is_enable=1 AND a.ml_key=\'' . $this->data['ml_key'] . '\' ' . $category_multiple_other_sql;
			if ($is_promotion === true and $id > 0) {
				if (isset($_ids[$id])) {
					$_count = count($_ids[$id]); //配合上面的程式 改用 $_ids
				} else {
					$_count = 0;
				}

				if ($_count <= 0) {
					$sql .= ' AND 0 ';
				} else {
					$sql .= ' AND a.id IN ( ' . implode(',', $_ids[$id]) . ' ) ';
				}
			} else {
				$sql .= ' AND a.' . $class_ids_name . ' LIKE \'%,' . $id . ',%\' ';
			}
			if ($this->data['router_method'] == 'shop') {
				$sql .= " and a.is_increase_purchase!=1 and is_promo!=1 ";
			}
			if ($common_date_range == '1') {
				$sql .= ' and (a.date1 <= now() OR a.date1 IS NULL OR a.date1 = "0000-00-00") AND (a.date2 >= "' . date('Y-m-d') . '" OR a.date2 IS NULL OR a.date2 = "0000-00-00")';
			}

			//複選加入金額排序 2021-06-06 by lota
			if (isset($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter']) && $_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'] != '') {
				if ($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'] == '2') {
					$sql .= ' ORDER BY a.price_search asc ';
				} elseif ($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'] == '1') {
					$sql .= ' ORDER BY a.price_search desc ';
				}
			} else {
				$sql .= ' ORDER BY sort_id_multisort ';
			}
			$sql .= 'LIMIT ' . $limit_count . ' OFFSET ' . ($pagew - 1) * $limit_count . ' ';
			$rows = $this->cidb->query($sql)->result_array();
		} else {
			$o = $this->cidb->where($where);
			if ($this->data['router_method'] == 'shop') {
				$o = $o->where('is_increase_purchase!=1');
				$o = $o->where('is_promo!=1');
			}
			if ($common_date_range == '1') {
				$o = $o->where('(date1 <= NOW() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= NOW() OR date2 IS NULL OR date2 = "0000-00-00")');
			}
			if (!is_null($where_in)) {
				$o = $o->where_in($where_in[0], $where_in[1]);
			}
			//20221101 #45907 增加判斷發佈日期----------------------------------------------------------------------------------start
			if(stristr($router_method,'news') && $reserve_data['keyval']=='true'){
				$o->where('(reserve_date <= now() OR reserve_date IS NULL OR reserve_date = "0000-00-00")');
				$o->where('(retirement_date > now() OR retirement_date IS NULL OR retirement_date = "0000-00-00")');
			}
			//-------------------------------------------------------------------------------------------------------------------end
			//2021-05-05 擴充where_like by lota
			if (!empty($where_like)) {
				$o->like($where_like);
			}

			if (isset($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'])) {
				if ($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'] == '2') {
					$o = $o->order_by('price_search', 'asc');
				} elseif ($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'] == '1') {
					$o = $o->order_by('price_search', 'desc');
				} elseif ($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'] == '4') { // 最新上架 新->舊 (目前沒在用)
					$o = $o->order_by('id', 'desc');
				} elseif ($_SESSION['save'][$this->data['router_method'] . '_ajax']['dropdown_filter'] == '3') { // 最新上架 舊->新 (目前沒在用)
					$o = $o->order_by('id', 'asc');
				}
			} else {
				if ($common_has_listpage == 1 and $common_is_category == 1 and $id == 0) {
					// 2019-11-21 李哥說要加的，總覽頁排序
					// 2021-05-12 最新消息用時間來排序，其他的用總覽頁
					if ($this->data['router_method'] == 'news') {
						$o = $o->order_by('date1', 'desc');
					} else {
						//2021-07-02 後台已經都改為預設最新到最舊，如果需要總覽排序那就換註解的程式 by lota
						// $o = $o->order_by('sort_id_browser','asc');
						$o = $o->order_by('id', 'desc');
					}
				} else {
					if ($common_date_sort == 1) {
						$o = $o->order_by('start_date', 'desc');
					}else if (stristr($router_method,'news')) {
						$o = $o->order_by('date1', 'desc');
					}else if($common_date_range==1){
						//2023/01/18  增加 後台用date1排序的功能 ps.最新消息單元等
						$o = $o->order_by('date1 desc ,id desc');
					} else {
						// 2020-02-20 遞迴的情況，排序依據產品名稱
						$sort_id_option = true;
						if ($id > 0 and $common_is_category == 1) {
							if ($common_action_by_categoryurl == '2') {
								//2020/07/02 加入由資料層級判斷是否使用名稱排序
								if ($table == 'html') { //如果是通用分類
									$_tt = $this->cidb->query("SELECT class_id as pid FROM " . $table . " where is_enable = 1 and type ='" . $where['type'] . "' and class_id=" . $id)->row_array();
								} else { //獨立分類，預定資料表名稱後面一定有 "type"
									$_tt = $this->cidb->query("SELECT pid FROM " . str_replace('type', '', $table) . "type where is_enable = 1 and pid=" . $id)->row_array();
								}

								if (isset($_tt['pid']) && $_tt['pid'] != 0) {
									$sort_id_option = false;
								}
							}
						}
						if ($sort_id_option === true) {
							$o = $o->order_by('sort_id', 'asc');
						} else {
							$o = $o->order_by('name', 'asc');
						}
					}
					
				}
			}
			$rows = $o->get($table, $limit_count, ($pagew - 1) * $limit_count)->result_array();
		}
	} // table
	
	// 換個地方
	// if($rows and count($rows) > 0){
	// 	foreach($rows as $k => $v){
	// 		if($v['update_time'] == '0000-00-00 00:00:00'){
	// 			$v['update_time'] = '';
	// 		} else {
	// 			$v['update_time'] = date('Y/m/d', strtotime($v['update_time']));
	// 		}

	// 		// 2018-08-09 這個應該是多餘的
	// 		// $v['pic'] = '_i/assets/upload/'.$router_method.'/'.$v['pic1'];

	// 		$rows[$k] = $v;
	// 	}
	// 	$data[$ID] = $rows;
	// }

	// 分類名稱
	if ($is_promotion === true and $id > 0) {
		// 測試看看而以 2020-12-28
		// 先略過
	} elseif ($common_is_category == 1 and $id > 0) {

		// 條件重置
		$table_category = '';
		$table = '';
		$where = $where_category = array(
			'is_enable' => 1,
			'ml_key' => $this->data['ml_key'],
			'id' => $id,
			// 'type' => $router_method,
			// 'class_id' => $class_id,
		);

		if ($common_category == 1) { // 是通用分類
			$where['type'] = $type_name;
			$table = 'html';
		} else {
			$table = $type_name;
		}

		// $tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and id=:id',array(':type'=>$router_method.'type',':id'=>$class_id))->queryRow();
		$tmp = $this->cidb->where($where)->get($table)->row_array();
		if ($tmp and isset($tmp['id'])) {
			if (!isset($tmp['topic']) and isset($tmp['name'])) {
				$tmp['topic'] = $tmp['name'];
			}

			$tmp['name'] = $tmp['topic'];

			if (!isset($tmp['detail'])) {
				$tmp['sub_name'] = '';
			} else {
				$tmp['sub_name'] = $tmp['detail'];
			}

			// 有圖片資料的話，就套入圖片路徑 2018-08-09 這個應該是多餘的
			// if(isset($tmp['pic1']) && $tmp['pic1']!=''){
			// 	$tmp['pic1'] = '_i/assets/upload/'.$table.'/'.$tmp['pic1'];
			// }
		} else {
			// $tmp = array(
			// 	'name' => '',
			// 	'sub_name' => '',
			// );

			// 2019-11-15 李哥說要加的，如果通用分類底下有分項，但是分類停用，那頁面還是會正常出現(異常)
			echo '404';
			header('HTTP/1.1 404 Not Found');
			die;
		}

		// C方案專用
		// if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/category_title'][0])){
		// 	$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/category_title'][0]] = $tmp;
		// }

		//#37483 公司決議不要選單上面的名稱
		// $page_source_data_param1 = 'share-category_title';
		// $page_source_data_param2 = $tmp;
		// include _BASEPATH.'/../source/system/page_source_data.php';

		// #37483 改帶到sub_page_title 
		// 2020-11-27 全客製A方案，請把這裡關掉 //2021-03-31 這段會依照目前分類名稱去取代 sub_title.. 有需要再開啟 by lota
		if (0) {
			$_tmp = $tmp;
			$_tmp['sub_name'] = $_tmp['name'];
			if ((isset($_tmp['pid']) && $_tmp['pid'] == 0) or (isset($_tmp['class_id']) && $_tmp['class_id'] == 0)) {
				unset($_tmp['name']);
			} else {
				//目前只有抓兩層資料，之後還要等有緣人優化這邊的程式碼...
				if ($common_category == 1) { // 是通用分類
					$where['id'] = $_tmp['class_id'];
				} else {
					$where['id'] = $_tmp['pid'];
				}
				$_tmp2 = $this->cidb->where($where)->get($table)->row_array();
				if ($_tmp2 and isset($_tmp2['id'])) {
					if (!isset($_tmp2['topic']) and isset($_tmp2['name'])) {
						$_tmp2['topic'] = $_tmp2['name'];
					}
					$_tmp2['name'] = $_tmp2['topic'];
				}
				$_tmp['name'] = $_tmp2['name'];
			}

			$page_source_data_param1 = 'share-page_title';
			$page_source_data_param2 = $_tmp;
			$page_source_data_other = array('assign_force' => true);
		}

		include _BASEPATH . '/../source/system/page_source_data.php';

		// 2018-08-09 A方案專用
		// 根據後台／LayoutV3／資料 的元素(好記的名子)格式命名
		$data['_category_title'] = $tmp;
		$this->data['_category_title'] = $tmp;

		// SEO
		// 2019-12-04 已移到source/core裡面
		// unset($_constant);
		// eval('$_constant = '.strtoupper('seo_open').';');
		// if($_constant){
		// 	// 這個是獨立分類，目前大概只有產品會用到，而這個就是Ming最新的SEO規則 2017-11-29
		// 	$data['head_title'] = str_replace($this->data['func_name'].' | ', $tmp['name'].' | ', $data['head_title']); // 預設值
		// } else {
		// 	// 2018/8/6 經理來信 統一將產品title不需每頁帶產品分類抬頭 by lota
		// 	$data['head_title'] = str_replace($this->data['func_name'].' | ', '', $data['head_title']);
		// }

		// $rowg = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key AND seo_type=:type AND seo_item_id='.$_GET['id'],array(':ml_key'=>$this->data['ml_key'],':type'=>$router_method.'type'))->queryRow();
		// if($rowg and isset($rowg['id'])){
		// 	if($rowg['seo_title'] != ''){
		// 		$data['head_title'] = $rowg['seo_title'];
		// 	} else {
		// 		// SEO
		// 		unset($_constant);
		// 		eval('$_constant = '.strtoupper('seo_open').';');
		// 		if($_constant){
		// 			// 2018-12-19 Ming下午口頭說的
		// 			$data['head_title'] = $tmp['name'];
		// 		}
		// 	}
		// 	if($rowg['seo_meta_keyword'] != ''){
		// 		$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
		// 	}
		// 	if($rowg['seo_meta_description'] != ''){
		// 		$this->data['seo_description'] = $rowg['seo_meta_description'];
		// 	} else {
		// 		// 2018-12-19 Ming下午口頭說的
		// 		$this->data['seo_description'] = strip_tags($tmp['detail']);
		// 	}

		// 	// 這裡是有簽SEO合約的
		// 	unset($_constant);
		// 	eval('$_constant = '.strtoupper('seo_open').';');
		// 	if($_constant){
		// 		// 2019-11-25 反解
		// 		if($rowg['seo_script_name'] != '' and isset($_SERVER['REQUEST_URI_OLD']) and preg_match('/.php/', $_SERVER['REQUEST_URI_OLD'])){
		// 			header('Location: '.$rowg['seo_script_name'].'.html');
		// 			die;
		// 		}
		// 	} // _constant
		// } else {
		// 	// SEO
		// 	unset($_constant);
		// 	eval('$_constant = '.strtoupper('seo_open').';');
		// 	if($_constant){
		// 		// 2018-12-19 Ming下午口頭說的，但是李哥說經理說，要有簽SEO，不然不要開(2018-08-06)
		// 		//$data['head_title'] = $tmp['name']; //2019-7-17 lota 感覺怪怪的 先註解
		// 		//$this->data['seo_description'] = strip_tags($tmp['detail']);

		// 		if(isset($tmp['detail']) and trim(strip_tags($tmp['detail'])) != ''){
		// 			$detail = trim($tmp['detail']);
		// 			$detail = str_replace("\t",'',$detail);
		// 			$detail = str_replace("\r\n",'',$detail);
		// 			$detail = str_replace("\n",'',$detail);
		// 			$detail = strip_tags($detail);
		// 			$detail = mb_substr($detail, 0, 80, 'UTF-8');
		// 			$detail = trim($detail);
		// 			$this->data['seo_description'] = $detail;
		// 		}
		// 	}
		// }

	}

	unset($_constant);
	eval('$_constant = ' . strtoupper('seo_open') . ';');

	// 2019-12-04 預先寫好通用的部份，減少各功能要客製的份量
	//if($rows and count($rows) > 0){
	if ($rows and !empty($rows)) {
		foreach ($rows as $k => $v) {
			$v['__serial_number1'] = $k + 1; // 1,2,3,4...
			$v['__serial_number2'] = str_pad(($k + 1), 2, '0', STR_PAD_LEFT); // 01,02,03,04...

			// 2019-12-24 fieldhole
			$v['__'] = '';

			// 適用於分類列表、分項列表的網址
			$list_item = true; // 預設是分項列表，如果是false，那就是分項列表
			if ($common_is_category == 1) { // 有分類的情況 #25898 George發現的bug
				if ($common_has_listpage == '1' and $id == 0) { // 總覽頁一定是分項列表
					// $list_item = true;
				} elseif (isset($v['class_id'])) { // 分項列表，因為李哥說，分項資料表，不會有pid，而分類資料表，不會有class_id
					// $list_item = true;
				} else {
					$list_item = false;
				}
			} else {
				// $list_item = true;
			}

			if ($list_item === true) {
				if ($common_has_page_detail === true) {
					if (isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true) {
						$v['url'] = $url_prefix . $seos_tmp[$v['id']]['seo_script_name'] . '.html';
					} else {
						$v['url'] = $url_prefix . $item_list_router_method . 'detail' . $url_suffix . '?id=' . $v['id'];
					}
				} else { // 例如：faq
					$v['url'] = '#';
				}
			} else {
				if (isset($seos_type_tmp[$v['id']]) and $seos_type_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true) {
					$v['url'] = $url_prefix . $seos_type_tmp[$v['id']]['seo_script_name'] . '.html';
				} else {
					$v['url'] = $url_prefix . $item_list_router_method . $url_suffix . '?id=' . $v['id'];
				}
			}

			// 反正topic和name都是標題，不用煩惱要用哪一個
			if (isset($v['topic']) and !isset($v['name'])) {
				$v['name'] = $v['topic'];
			} elseif (isset($v['name']) and !isset($v['topic'])) {
				$v['topic'] = $v['name'];
			}

			// 代表圖
			// 為了A方案而修正的
			// $v['pic'] = '';
			// if($v['pic1'] != ''){
			// 	if($list_item === true){
			// 		$v['pic'] = '_i/assets/upload/'.$item_list_router_method.'/'.$v['pic1'];
			// 	} else {
			// 		$v['pic'] = '_i/assets/upload/'.$item_list_router_method.'type/'.$v['pic1'];
			// 	}
			// }

			// 從layoutv3/dom5/datasource.php那邊複製過來的
			$v['pic'] = '';
			foreach ($v as $kk => $vv) {
				//if($v['pic1'] != ''){
				if (preg_match('/^pic(\d+)$/', $kk, $matches) and $vv != '') {
					if ($list_item === true) {
						$v[$kk . '_'] = '_i/assets/upload/' . $item_list_router_method . '/' . $vv;
					} else {
						$v[$kk . '_'] = '_i/assets/upload/' . $item_list_router_method . 'type/' . $vv;
					}
					if ($matches[1] == '1') { // 代表圖，為了A方案而修正的
						$v['pic'] = $v[$kk . '_'];
					}
				} elseif (preg_match('/^file(\d+)$/', $kk, $matches) and $vv != '') {
					if ($list_item === true) {
						$v[$kk . '_'] = '_i/assets/file/' . $item_list_router_method . '/' . $vv;
					} else {
						$v[$kk . '_'] = '_i/assets/file/' . $item_list_router_method . 'type/' . $vv;
					}
				}
			}

			// inquiry 2019-10-25
			// 讓所有的功能都可以掛inquiry
			$inquiry = array();
			$inquiry['id'] = $item_list_router_method . 'inquiry';
			$inquiry['primary_key'] = $item_list_router_method . '___' . $v['id'] . '___0'; // 預設型號為零，這是型號範本，請依需求去客制
			$inquiry['ml_key'] = $this->data['ml_key'];
			$inquiry['amount'] = 1;
			$inquiry['_append'] = '';

			$tmp2 = array();
			foreach ($inquiry as $kk => $vv) {
				$tmp2[] = $kk . '=' . $vv;
			}
			$inquiry['url'] = 'save.php?' . implode('&', $tmp2);

			if (!isset($v['url_inquiry'])) {
				if ($list_item === true) {
					$v['url_inquiry'] = $inquiry['url'];
				} else {
					$v['url_inquiry'] = '';
				}
			}

			// if(isset($v['start_date'])){
			// 	if($v['start_date'] == '0000-00-00'){
			// 		$v['start_date'] = '';
			// 	} else {
			// 		$v['start_date'] = date('Y/m/d', strtotime($v['start_date']));
			// 	}

			// 	if(!isset($v['year'])){
			// 		$v['year'] = date('Y', strtotime($v['start_date']));
			// 	}

			// 	if(!isset($v['month'])){
			// 		$v['month'] = date('M', strtotime($v['start_date'])); // 縮寫 Jan through Dec 2019-03-07 查理說要依照縮寫為預設
			// 	}

			// 	if(!isset($v['month2'])){
			// 		$v['month2'] = date('F', strtotime($v['start_date'])); // January through December
			// 	}

			// 	if(!isset($v['MONTH'])){
			// 		$v['MONTH'] = date('m', strtotime($v['start_date'])); // 01 ~ 12 (月)
			// 	}

			// 	if(!isset($v['day'])){
			// 		$v['day'] = date('d', strtotime($v['start_date']));
			// 	}
			// }

			// 多圖上傳
			if (!isset($v['count'])) {
				$tmps = array();
				if (is_dir(_BASEPATH . '/assets/members/' . $item_list_router_method . '_1_' . $v['id'] . '/member')) {
					$tmps = $this->_getFiles(_BASEPATH . '/assets/members/' . $item_list_router_method . '_1_' . $v['id'] . '/member');
				}
				$v['count'] = count($tmps);
			}

			foreach (array('date1', 'date2', 'start_date', 'end_date') as $vv) {
				if (isset($v[$vv])) {
					if ($v[$vv] == '0000-00-00') {
						$v[$vv] = '';
					}
				}
			}

			foreach (array('create_time', 'update_time') as $vv) {
				if (isset($v[$vv])) {
					if ($v[$vv] == '0000-00-00 00:00:00') {
						$v[$vv] = '';
					} else {
						$v[$vv] = date('Y/m/d', strtotime($v[$vv]));
					}
				}
			}

			// 舊的
			// if(isset($v['update_time'])){
			// 	if($v['update_time'] == '0000-00-00 00:00:00'){
			// 		$v['update_time'] = '';
			// 	} else {
			// 		$v['update_time'] = date('Y/m/d', strtotime($v['update_time']));
			// 	}
			// }

			// 2019-12-23
			// view/system/detail/row_field.php那邊copy來的
			foreach ($v as $kk => $vv) {
				if (preg_match('/^(detail|field_data|field_tmp)$/', $kk)) {
					$newfieldname = $kk . '___nochange';
					if (!isset($v[$newfieldname])) {
						$v[$newfieldname] = $v[$kk];
					}

					$newfieldname = $kk . '___nl2br';
					if (!isset($v[$newfieldname])) {
						$v[$newfieldname] = nl2br($v[$kk]);
					}
				} elseif (preg_match('/^(create_time|update_time|date1|date2|start_date|end_date)$/', $kk)) {
					// if($v[$k] == '0000-00-00 00:00:00'){
					// 	$v[$k] = '';
					// } else {
					// 	$v[$k] = date('Y/m/d', strtotime($v[$k]));
					// }

					foreach (array('year' => 'Y', 'month' => 'M', 'month2' => 'F', 'MONTH' => 'm', 'day' => 'd') as $kkk => $vvv) {
						$newfieldname = $kk . '___' . $kkk;
						if (!isset($v[$newfieldname])) {
							$v[$newfieldname] = ''; // 不管如何，至少弄個空的出來
							if ($v[$kk] != '') {
								$v[$newfieldname] = date($vvv, strtotime($v[$kk]));
							}
						}
					}
				}
			}

			$rows[$k] = $v;
		}

		$data[$ID] = $rows;
	}

	/*
	 * 應該有很多功能都差不多，只有這裡不一樣而以
	 * 這裡放置在最下面，為了要給功能範本，能夠有更大的優先權能夠處理以及覆寫 2018-01-08
	 */
	if (file_exists(_BASEPATH . '/../source/' . $router_method . '/general_item.php') or (isset($this) and isset($this->data['need_flattened']) and $this->data['need_flattened'] === true)) {
		include _BASEPATH . '/../source/' . $router_method . '/general_item.php';
	}
	// print_r($rows);die;
	if ($rows and !empty($rows)) {
		$data[$ID] = $rows;
	} else {
		$data[$ID] = array();
	}

	/*
	 * 側邊選單展開 (如果有的話)
	 * 李哥在#26083的這張單裡面，發現有分頁、有側邊選單的情況，側邊選單沒有展開的問題，這裡預防性的修正，但是側邊選單必需要是promenu2才可以
	 */
	// $view_file = LAYOUTV3_THEME_NAME.'/breadcrumb';
	// $tmps = array();
	// if(isset($layoutv3_struct_map_keyname[$view_file][0]) and isset($data[$layoutv3_struct_map_keyname[$view_file][0]])){
	// 	$tmps = $data[$layoutv3_struct_map_keyname[$view_file][0]];
	// }
	$tmps = array();
	$page_source_data_param1 = 'share-breadcrumb';
	include _BASEPATH . '/../source/system/page_source_data.php';
	if (isset($page_source_data_return) and !empty($page_source_data_return)) {
		$tmps = $page_source_data_return;
	}

	// A方案 2018-08-20
	if (isset($this->data['_breadcrumb']) and !empty($this->data['_breadcrumb'])) {
		$tmps = $this->data['_breadcrumb'];
	}

	// 刪掉尾巴
	if (preg_match('/detail/', $router_method) and isset($tmps[count($tmps) - 1])) {
		unset($tmps[count($tmps) - 1]);
	}
	// 刪掉頭
	if (isset($tmps[0])) {
		unset($tmps[0]);
	}
	// 如果第一個次選單，沒有要覆寫網址，那就把麵包屑的功能的那一層也刪掉
	if ($row['other3'] == 0) {
		if (isset($tmps[1])) {
			unset($tmps[1]);
		}
	}

	// promenuX
	// $actives = array();
	// if($tmps and count($tmps) > 0){
	// 	foreach($tmps as $k => $v){
	// 		if(isset($v['id'])){
	// 			$actives[] = $v['id'];
	// 		}
	// 	}
	// }
	// $view_file = 'v3/default/active';
	// $tmps = array();
	// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
	// 	$data[$layoutv3_struct_map_keyname[$view_file][0]] = $actives;
	// }

	// sidemenu 2018-01-22
	//if($tmps and count($tmps) > 0){
	if ($tmps and !empty($tmps)) {
		foreach ($tmps as $k => $v) {
			// do nothing
		}
		$this->data['func_name_sub_id'] = 'navlight_' . $v['id'];
	}
} else {
	$data[$ID] = array();
}

// 2020-07-16 多層文章功能，跟預載的source/system/general_item.php會衝突
// }