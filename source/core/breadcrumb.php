<?php

if(!function_exists('_get_product_classes')){
function _get_product_classes($rows = array())
{
	// 取得所有的分類，目標做到2層以上
	//$conditions = array(
	//	'ml_key' => $data['ml_key'],
	//	'is_enable' => '1',
	//);

	// $query = $this->cidb->select('id, class_id, class_name, class_name AS class_name_id')->where($conditions)->get('product_class');
	// $query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where($conditions)->get($data['table']);
	// $productclasses = array();
	// $productclasses_sample = array();
	// foreach($query->result_array() as $row){
	// 	$row['class_name_id'] = $row['class_name_id'].'__'.$row['id'];
	// 	$productclasses[] = $row;
	// 	$productclasses_sample[$row['id']] = $row;
	// }

	$productclasses = array();
	$productclasses_sample = array();
	foreach($rows as $k => $row){
	 	$row['class_name_id'] = $row['class_name_id'].'__'.$row['id'];
	 	$productclasses[] = $row;
	 	$productclasses_sample[$row['id']] = $row;
	}

	// 將分類轉成Tree
	// http://www.mombu.com/php/php/t-creating-tree-structure-from-associative-array-11767756.html
	// Set up indexing of the above list (in case it wasn't indexed).
	$lookup = array();
	foreach( $productclasses as $item ){
		$item['children'] = array();
		$lookup[$item['id']] = $item;
	}
	
	// Now build tree.
	$tree = array();
	foreach( $lookup as $id => $foo ){
		$item = &$lookup[$id];
		if( $item['class_id'] == 0 ){
			$tree[$id] = &$item;
		} else if( isset( $lookup[$item['class_id']] ) ){
			$lookup[$item['class_id']]['children'][$id] = &$item;
		} else {
			// 2018-08-06 這個可能是多餘的
			//$tree['_orphans_'][$id] = &$item;
		}
	}

	$return = array(
		'data' => $productclasses,
		'sample' => $productclasses_sample,
		'tree' => $tree,
	);

	return $return;
}
}

/*
 * 這裡會回應一個陣列
 * 其中斜線是$char變數
 * array(
 *   'ids' => array(IDA, IDB, IDC),
 *   'keyvalue' => array(
 *		'CLASSID - A' => 'classA',
 *		'CLASSID - B' => 'classB',
 *		'CLASSID - N' => 'classN',
 *   );
 *   'values' => array(
 *		'classA',
 *		'classB',
 *		'classN',
 *   );
 *   'value' => 'classA / classB / classN',
 * )
 *
 * @class_name string 是分類名稱__分類編號所組成
 */
// http://php.chinaunix.net/manual/tw/function.array-search.php 也可以參考這裡，搜尋關建字是getParentStack
// 請注意，如果分類名稱一樣的，會顯示第一個搜尋到的那個分類的編號哦哦哦！！2016-12-20
if(!function_exists('_search_product_class_tree')){
 function _search_product_class_tree($tree, $classes, $class_name, $char = ' / ')
{
	/* 搜尋結果是2層的狀況
	 * array(1) {
	 *   [1]=>
	 *   array(1) {
	 *     ["children"]=>
	 *     array(1) {
	 *       [25]=>
	 *       array(1) {
	 *         ["class_id_name"]=>
	 *         string(6) "RD3011__25"
	 *       }
	 *     }
	 *   }
	 * }
	 */
	// 搜尋陣列，把搜尋的"第1個"結果給找出來
	$return_tmp = _getParentStack($class_name, $tree);

	// 2018-08-07 在逢甲國際的無限層文章所遇到的問題(不需要了)
	//if(isset($return_tmp['_orphans_'])){
	//	$return_tmp = $return_tmp['_orphans_'];
	//}

	/*
	 * 來看一下$return_tmp裡面是什麼東東
array(1) {
  [23]=>
  array(1) {
    ["children"]=>
    array(1) {
      [24]=>
      array(1) {
        ["children"]=>
        array(1) {
          [31]=>
          array(1) {
            ["class_name"]=>
            string(7) "test1gg"
          }
        }
      }
    }
  }
}
*/
	//var_dump($return_tmp);

	$return = array();

	// 開始解無限層
	for($x=1;$x<=100;$x++){
		$tmp = '';
		$run = '';
		for($y=1;$y<=($x-1);$y++){
			$tmp .= '[$L'.$y.']["children"]';
		} // for y
		//echo $tmp."\n";
		//2019/3/21 加入us_array(\$return_tmp$tmp) 驗證 及 設定預設 \$L$y = 0; by lota
		$run = <<<XXX
if(!isset(\$return_tmp$tmp)){
	\$x = 100;
} else {
	if(is_array(\$return_tmp$tmp)){
		foreach(\$return_tmp$tmp as \$L$y => \$v){ break; }
	}else{
		\$L$y = 0; 
	}
}
XXX;
		eval($run);
	} // for x

	$return['ids'] = array();
	for($x=1;$x<=100;$x++){
		eval('if(isset($L'.$x.')) $return["ids"][] = $L'.$x.';');
	}
	//var_dump($return);
	//die;


	//if(isset($classes[$root_class_id]['class_name'])){
	$return['keyvalue'] = array();
	$return['values'] = array();
	//if(count($return['ids']) > 0){
	if(!empty($return['ids'])){
		foreach($return['ids'] as $v){
			if(isset($classes[$v])){ // 2017-12-25 試著加這一個，看後續會不會壞掉
				$return['keyvalue'][$v] = $classes[$v]['class_name'];
				$return['values'][] = $classes[$v]['class_name'];
			}
		}
	}
	$return['value'] = implode(' / ', $return['values']);

	return $return;
}
}

/**
 * Gets the parent stack of a string array element if it is found within the
 * parent array
 *
 * This will not search objects within an array, though I suspect you could
 * tweak it easily enough to do that
 *
 * @param string $child The string array element to search for
 * @param array $stack The stack to search within for the child
 * @return array An array containing the parent stack for the child if found,
 *               false otherwise
 */
if(!function_exists('_getParentStack')){
function _getParentStack($child, $stack) {
	foreach ($stack as $k => $v) {
		if (is_array($v)) {
			// If the current element of the array is an array, recurse it and capture the return
			$return = _getParentStack($child, $v);
		   
			// If the return is an array, stack it and return it
			if (is_array($return)) {
				return array($k => $return);
			}
		} else {
			// Since we are not on an array, compare directly
			if ($v == $child) {
				// And if we match, stack it and return it
				return array($k => $child);
			}
		}
	}
   
	// Return false since there was nothing found
	return false;
}
}

$tmps = array(
	array(
		'name' => 'HOME',
		// 'url' => '/index_'.$this->data['ml_key'].'.php'
		'url' => '/'.$url_prefix.'index'.$url_suffix,
	),

	// 因為沒有$_GET['id']的時候，記得要先把這個元素拿掉
	array(
		'name' => $this->data['func_name'], 
		'url' => str_replace('detail','',$this->data['func_name_href']), // 這個變數，是在source/menu/v2.php那邊的最下面處理的
	),
);

//2021-07-14 因為購物產品分類上提到主選單後，購物產品詳細頁的麵包屑及大標題會抓錯，這裡是超爛的寫法，等待有緣人來救他 by lota
if(isset($_GET['cid'])){
	$_gg = $this->cidb->where('id',intval($_GET['cid']))->where('ml_key',$this->data['ml_key'])->get('shoptype')->row_array();
	if($_gg['pid']!=0){
		$_ggg = $this->cidb->where('id',$_gg['pid'])->where('ml_key',$this->data['ml_key'])->get('shoptype')->row_array();
		if($_ggg['pid']!=0){
			$_gggg = $this->cidb->where('id',$_ggg['pid'])->where('ml_key',$this->data['ml_key'])->get('shoptype')->row_array();
			$tmps[1]['name'] = $_gggg['name'];
		}else{
			$tmps[1]['name'] = $_ggg['name'];
		}		
	}else{
		$tmps[1]['name'] = $_gg['name'];
	}
}

// SEO 2021-01-08
// if($this->data['ml_key'] == 'tw'){
// 	$tmps[0]['url'] = '/tw/';
// }

// 2018-05-29 建在資料庫的編排頁，在這個地方會異常，例如會變成company_2_tw.php
// 但是連絡我們那頁會報錯
//$tmp = $tmps[1]['url'];
//$tmpsg = explode('_',$tmp);
//if(preg_match('/^\d$/', $tmpsg[count($tmpsg)-2])){
//	$tmps[1]['url'] = '#';
//}

// SEO 主選單靜態頁的範例 2017-10-27
// if(preg_match('/album/', $this->data['router_method'])){
// 	$tmps[1]['url'] = '台中長期照顧中心.html';
// }

// 補上主選單的名稱，暫時先Mark起來，因為不是我現在要寫的程式的目的，雖然它可以使用 2017-08-01
$_router_method = str_replace('detail','',$this->data['router_method']);
// $tmp = $this->db->createCommand()->from('html')->where('type =:type and ml_key=:ml_key and url1=:url',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key'],':url'=>$_router_method.'_'.$this->data['ml_key'].'.php'))->queryRow();
$tmp = $this->db->createCommand()->from('html')->where('type =:type and ml_key=:ml_key and id=:id',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key'],':id'=>$this->data['func_name_id']))->queryRow();

// 2020-02-25 seo
if(!isset($_GET['id']) and $tmp and isset($tmp['id'])){
	// 2020-01-13 #34327
	if(isset($tmp['detail_top'])){
		$tmps[1]['content_top'] = $tmp['detail_top'];
	}
	if(isset($tmp['detail_bottom'])){
		$tmps[1]['content_bottom'] = $tmp['detail_bottom'];
	}
}

// 會員相關功能，例登入、註冊，是不需要跟後台的前台主選單連結的
if(!$tmp){
	$tmp = array(
		'other11' => 0,
		'video_2' => 0,
		'video_4' => 0,
	);
}

// 2019-12-04 有無內頁
$common_has_page_detail = false;
if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method.'detail.php')){
	$common_has_page_detail = true;
} else {
	$tmp2 = $this->cidb->query('select * from layoutv3pagetype where is_enable=1 and pid=0 and theme_name="'.LAYOUTV3_THEME_NAME.'" and ( name="'.$_router_method.'detail" or concat(",",other_func,",") LIKE "%,'.$_router_method.'detail,%" )')->row_array();
	if($tmp2 and isset($tmp2['id'])){
		$common_has_page_detail = true;
	}
}

// 內頁大圖
$bannersub_rule = $tmp['other11']; // 0:預設,1:功能導向,2:鎖定編號,3:編號繼承

if($tmp and isset($tmp['id']) and $tmps[count($tmps)-1]['name'] == ''){
	unset($tmps[count($tmps)-1]);
	$tmps[] = array(
		'name' => $tmp['topic'],
		'url' => '#',
	);
}

// 進階功能
// var_dump($tmp);
$static_child = $tmp['video_2'];
$static_child_position = $tmp['video_4'];

// 2017-12-25 查理王發現的缺的問題
// company_tw_1
// 次選單靜態，編排頁專用

// if($static_child > 0 and ($static_child_position == 1 or $static_child_position == 2) and preg_match('/_'.$this->data['ml_key'].'_/', $this->data['router_method'])){ // 編排頁(第二版)
// if($static_child > 0 and ($static_child_position == 1 or $static_child_position == 2) and preg_match('/_/', $this->data['router_method'])){ //  編排頁(第三版)
if($static_child > 0 and ($static_child_position == 1 or $static_child_position == 2)){ // 2019-07-11

	//    // 搜尋class_id (弱搜尋)
	//    $class_id = 0;
	//    // $class_id_search = $this->db->createCommand()->from('webmenuchild')->where('is_enable =1 and ml_key =:ml_key and url=:url',array(':ml_key'=>$this->data['ml_key'],':url'=>$this->data['router_method'].'.php'))->queryRow(); // (第二版)
	//    $class_id_search = $this->db->createCommand()->from('webmenuchild')->where('is_enable =1 and ml_key =:ml_key and url=:url',array(':ml_key'=>$this->data['ml_key'],':url'=>str_replace('_','_'.$this->data['ml_key'].'_',$this->data['router_method']).'.php'))->queryRow(); // (第三版)
	//    if($class_id_search and isset($class_id_search['id']) and $class_id_search['id'] > 0){
	//    	$class_id = $class_id_search['id'];
	//    }

	// 2019-07-11 為了支援，前台次選單(靜態)，裡面除了可以擺放編排頁的連結，也可以擺放一些其它實體功能的連結
	$class_id = 0;
	if(preg_match('/_/', $this->data['router_method'])){
		$url_condition = str_replace('_','_'.$this->data['ml_key'].'_',$this->data['router_method']).'.php';
	} else {
		$url_condition = $this->data['router_method'].'_'.$this->data['ml_key'].'.php';
	}

	// 搜尋class_id (弱搜尋2)
	// $class_id_search = $this->db->createCommand()->from('webmenuchild')->where('is_enable =1 and ml_key =:ml_key and url=:url',array(':ml_key'=>$this->data['ml_key'],':url'=>$url_condition))->queryRow(); // (第三版)
	// if($class_id_search and isset($class_id_search['id']) and $class_id_search['id'] > 0){
	// 	$class_id = $class_id_search['id'];
	// }

	// 2020-01-10
	// 修正class_id_search的錯誤
	// 網址有可能會找到多筆
	$class_id_searchs = $this->cidb->select('id')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('url',$url_condition)->get('webmenuchild')->result_array();

	// 製作參照
	// 這裡是從source/core.php裡面，分類上提的那個地方複製過來改的
	$class_id_tmps = array();
	$rowsg = $this->cidb->select('id,pid')->where('pid !=',0)->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get('webmenuchild')->result_array();
	if($rowsg and count($rowsg) > 0){

		$rowsg[] = array(
			'id' => $static_child,
			'pid' => 0,
		);

		$indexedItems = array();

		// index elements by id
		foreach ($rowsg as $item) {
			$item['child'] = array();
			$indexedItems[$item['id']] = (object) $item;
		}

		// assign to parent
		$topLevel = array();
		foreach ($indexedItems as $item) {
			if ($item->pid == 0) {
				$topLevel[] = $item;
			} else {
				if(isset($indexedItems[$item->pid])){ // 2019-12-19 by lota
					$indexedItems[$item->pid]->child[] = $item;
				}
			}
		}
		$tree = std_class_object_to_array($topLevel);
		//var_dump($tree);die;

		// 把分類的編號抓進來
		$tree_tmps = explode("\n", var_export($tree, true));
		if($tree_tmps){
			foreach($tree_tmps as $kk => $vv){
				if(preg_match('/^(.*)\'id\'\ =>\ \'(.*)\',/', $vv, $matches)){
					$class_id_tmps[] = $matches[2];
				}
			}
		}
	}

	if(!empty($class_id_searchs)){
		foreach($class_id_searchs as $v){
			if(in_array($v['id'], $class_id_tmps)){
				$class_id = $v['id'];
				break;
			}
		}
	}

	// $rows = $this->cidb->select('id, is_enable, pid AS class_id, name AS class_name, name AS class_name_id')->where(array('ml_key'=>$this->data['ml_key']))->order_by('sort_id','asc')->get($_router_method.'type')->result_array();
	$rows = $this->db->createCommand()->select('id, url, is_enable, other1, other2, other3, other4, pid AS class_id, name AS class_name, name AS class_name_id')->from('webmenuchild')->where('is_enable =1 and ml_key =:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
	if($rows){
		foreach($rows as $k => $v){
			if($v['class_id'] == 0){
				unset($rows[$k]);
			}
		}
		foreach($rows as $k => $v){
			if($v['class_id'] == $static_child){
				$rows[$k]['class_id'] = '0'; // 2018-08-07 這裡一定要用字串，不能用數字

				// dirty hack 2017-12-27
				// 2018-10-18 註解掉，應該…沒錯吧
				// if($v['id'] != $class_id){
				// 	unset($rows[$k]);
				// }
			}
		}

		// 2019-07-11 如果符合條件，代表實體功能，是放在前台次選單(靜態)的裡面
		if(!preg_match('/_/', $this->data['router_method'])){
			$tmpxxx = $this->db->createCommand()->from('html')->where('type =:type and ml_key=:ml_key and is_enable=0 and url1=:url',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key'],':url'=>str_replace('detail','',$this->data['router_method']).'_'.$this->data['ml_key'].'.php'))->queryRow();
			if($tmpxxx){
				$tmp = $tmpxxx;
			}
		}
	}

	if($class_id > 0){
		$tmp2 = _get_product_classes($rows);

		$tmp3 = array();
		if(isset($tmp2['sample'][$class_id])){
			$tmp3 = _search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$class_id]['class_name'].'__'.$class_id);

			//    2018-06-19 不知道這裡在寫什麼，先註解起來
			//    $this->data['func_name'] = $tmp2['sample'][$class_id]['class_name'];

			//    if($this->data['ml_key'] == 'tw'){
			//    	$this->data['func_en_name'] = $tmp2['sample'][$class_id]['other1'];
			//    }

			//    // dirty hack 
			//    // 為了要覆寫上層資料
			//    $view_file = 'v3/sub_page_title';
			//    if(isset($layoutv3_struct_map_keyname[$view_file][0])){
			//    	$data[$layoutv3_struct_map_keyname[$view_file][0]] = array(
			//    		'name' => $this->data['func_name'],
			//    		'sub_name' => $this->data['func_en_name'],
			//    	);
			//    }
		}

		//if($tmp3 and isset($tmp3['keyvalue']) and count($tmp3) > 0){
		if($tmp3 and isset($tmp3['keyvalue']) and !empty($tmp3)){
			foreach($tmp3['keyvalue'] as $k => $v){
				$ggg = array(
					'name' => $v,
					'url' => $tmp2['sample'][$k]['url'],
					'id' => $tmp2['sample'][$k]['id'], // 2018-04-26 後台的前台次選單(靜態)，那邊也有它自己的編號，雖然不是像分類那樣子的編號，不過也可以做為很好的依據
				);

				//靜態次選單所用的擴充欄位 2022-03-14 by lota
				if($tmp2['sample'][$k]['other1']!=''){
					$ggg['url'] = $tmp2['sample'][$k]['other1'];
				}

				// 2020-01-13 解決layoutv3/v3/category_title資料流寫死的問題
				if(isset($tmp2['sample'][$k]['detail'])){
					$ggg['content'] = $tmp2['sample'][$k]['detail'];
				}
				$tmps[] = $ggg;
			}
		}
	}
}

// 安全性 2019-11-04 已經移到source/core.php的最上面
// if(isset($_GET['id'])){
// 	$_GET['id'] = intval($_GET['id']);
// }

// 2019-12-04 最上面已經有一行一模一樣的了
// $_router_method = str_replace('detail','',$this->data['router_method']);

if(isset($_GET['id']) and $_GET['id'] > 0){

	// 跟隨後台的前台主選單的"第一個次選單覆寫網址的功能"
	//2019-4-1 修正如果分類上提後抓不到other3，則直接指定 javascript:;by lota
	if(isset($tmp['other3'])){
		$common_first_childurl_replace = $tmp['other3'];
	}else{
		$common_first_childurl_replace = 2;
	}
	

	$view_file = 'v3/header/nav_menu2';
	if(isset($tmp['other23']) and $tmp['other23'] != ''){
		$view_file = $tmp['other23'];
	}

	if($common_first_childurl_replace == 1){ // 第一個網址
		if(isset($layoutv3_struct_map_keyname[$view_file][0]) and isset($data[$layoutv3_struct_map_keyname[$view_file][0]])){
			$aaa = $data[$layoutv3_struct_map_keyname[$view_file][0]];
			foreach($aaa as $k => $v){
				//if($v['id'] == $tmp['id'] and isset($v['child']) and count($v['child']) > 0){
				if($v['id'] == $tmp['id'] and isset($v['child']) and !empty($v['child'])){
					$tmps[1]['url'] = $v['child'][0]['url'];
					break;
				}
			}
		}
	} elseif($common_first_childurl_replace == 4){ // 2018-07-24 第一個有效網址
		if(isset($layoutv3_struct_map_keyname[$view_file][0]) and isset($data[$layoutv3_struct_map_keyname[$view_file][0]])){
			$aaa = $data[$layoutv3_struct_map_keyname[$view_file][0]];
			foreach($aaa as $k => $v){
				//if($v['id'] == $tmp['id'] and isset($v['child']) and count($v['child']) > 0){
				if(isset($v['id']) and $v['id'] == $tmp['id'] and isset($v['child']) and !empty($v['child'])){
					$aaas = explode("\n", var_export($v['child'], true));
					//if($aaas and count($aaas) > 0){
					if($aaas and !empty($aaas)){
						foreach($aaas as $kk => $vv){
							if(preg_match('/\'url\'\ \=\>\ \'(.*)\'\,/', $vv, $matches)){
								if($matches[1] != '' and $matches[1] != '#' and $matches[1] != 'javascript:;'){
									$tmps[1]['url'] = $matches[1];
									break;
								}
							}
						}
					}
				}
			}
		}
	} elseif($common_first_childurl_replace == 2){
		$tmps[1]['url'] = 'javascript:;';
	} elseif($common_first_childurl_replace == 3){
		$tmps[1]['url'] = '#';
	} elseif($common_first_childurl_replace == 9){
		$tmps[1]['url'] = $tmp['other16'];
	}

	// 資料表功能 2017-08-02
	if($tmp and isset($tmp['id']) and $tmp['id'] > 0 and $tmp['is_home'] == 1/*是否有啟用資料表功能*/){
		// 資料表功能
		$common_is_enable = $tmp['is_home'];
		$common_is_category = $tmp['pic2']; // 是或不是分類
		$common_category = $tmp['is_news']; // 是或不是通用分類
		$common_category_type_name = $tmp['other22']; // 別人的
		$common_category_multiple = $tmp['other26']; // 切換成"多分類排序"
		$common_item = $tmp['class_ids'];   // 是或不是通用分項
		$common_sort = $tmp['pic3'];

		// 其它
		$common_enableurl_by_subclass_haschild = $tmp['other12']; // 有次分類的分類，連結有效
		$common_layer_up = $tmp['other21']; // 頂層分類升級

		// 2018-06-20 other3舊的位置，是李哥說要換位置

		// $common_is_html_table = $tmp['class_ids'];
		// $common_list_page = $v['is_top'];
		// $common_detail_page = $tmp['is_news']; // 這個是主選單在用的，這裡只是轉譯成好懂的變數而以

		$common_sort_condition = 'sort_id asc';
		if($common_sort == 1){
			$common_sort_condition = 'start_date desc';
		}

		// 2019-08-19 #32987
		// dirty hack 群翊 產品功能
		// 第二個左側選單，是分項的情況
		// if($_router_method == 'product_1'){
		// 	$_router_method = 'application';
		// 	$common_is_category = 0;
		// 	$common_item = 1;
		// }

		if($common_is_category == 1){

			$type_name = $_router_method.'type';
			if($common_category_type_name != ''){
				$type_name = $common_category_type_name;
			}

			if($common_category == 1){ // 單分類(通用資料表)

				if(preg_match('/detail$/', $this->data['router_method'])){
					// 2017-10-19 雖然最末層會找一次，不過這裡我還是先抓一次它的資料，主要是找它的上一層ID
					if($common_item == 1){ // 分項通用
						//$row2 = $this->db->createCommand()->select('class_id')->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$_router_method,':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
						$row2 = $this->cidb->where('is_enable', 1)->where('type',$_router_method)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get('html')->row_array();
					} else {
						$row2 = $this->cidb->where('is_enable', 1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($_router_method)->row_array();
					}
					$row = $this->db->createCommand()->select('*,topic as name')->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$type_name,':ml_key'=>$this->data['ml_key'],':id'=>$row2['class_id']))->queryRow();
				} else {
					$row = $this->db->createCommand()->select('*,topic as name')->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$type_name,':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
				}

		 		if($row and isset($row['id'])){
		 			// $tmps[] = array(
		 			// 	'name' => $row['name'],
		 			// 	'url' => $url_prefix.$_router_method.$url_suffix.'?id='.$row['id'],
		 			// );

					$ggg = array(
						'name' => $row['name'],

						// 2019-12-04 預留，李哥說不用
		 				// 'url' => $url_prefix.$_router_method.$url_suffix.'?id='.$row['id'],
		 				'url' => '#',
					);

					// 2020-01-13 #34327
					if(isset($row['detail_top'])){
						$ggg['content_top'] = $row['detail_top'];
					}
					if(isset($row['detail_bottom'])){
						$ggg['content_bottom'] = $row['detail_bottom'];
					}

					if(!preg_match('/detail$/', $this->data['router_method'])){
						// 2019-11-08 李哥說經理說，要支援主選單，和編排頁(XXX_tw_1.php) - 前台次選單(靜態)
						$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$type_name)->where('seo_item_id',$row['id'])->get('seo')->row_array();
						if($rowg and isset($rowg['id'])){
							// if($rowg['seo_title'] != ''){
							// 	$data['head_title'] = $rowg['seo_title'];
							// } else {
							// 	// 2018-12-19 Ming下午口頭說的
							// 	$data['head_title'] = $rowg['name'];
							// }
							// if($rowg['seo_meta_keyword'] != ''){
							// 	$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
							// }
							// if($rowg['seo_meta_description'] != ''){
							// 	$this->data['seo_description'] = $rowg['seo_meta_description'];
							// } else {
							// 	// 2018-12-19 Ming下午口頭說的
							// 	// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
							// }

							if($rowg['seo_script_name'] != ''){
								$ggg['url'] = $url_prefix.$rowg['seo_script_name'].'.html';
								$ggg['id'] = $row['id'];
							} else {
								$ggg['url'] = $url_prefix.$_router_method.$url_suffix.'?id='.$row['id'];
							}
						} else {
							// 李哥說，為了區分，低階和高階專案，所以這裡不會做任何事情
							// $data['head_title'] = $tmp['name'];
							// $this->data['seo_description'] = strip_tags($tmp['detail']);
						}
					} else {
		 				$ggg['url'] = $url_prefix.$_router_method.$url_suffix.'?id='.$row['id'];
					}

					$tmps[] = $ggg;
		 		}

				// 內頁的處理部份
				$detail_url = $url_suffix.'?id='.$_GET['id'];
				if($common_item == 1){ // 分項通用
					// $row = $this->db->createCommand()->select('*,topic as name')->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$_router_method,':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
					$product_row = $this->cidb->select('*,topic as name')->where('is_enable', 1)->where('type',$_router_method)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get('html')->row_array();
				} else {
					$product_row = $this->cidb->where('is_enable', 1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($_router_method)->row_array();
				}

				if($product_row and preg_match('/^(.*)type$/', $product_row['type'])){ // 是分類
					// 略過
					$product_row = array();
				} else { // 還有一層
					// if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method.'detail.php')){
					if($common_has_page_detail === true){
						$detail_url = 'detail'.$detail_url;
					}
				}
			
				if($product_row and isset($product_row['name'])){ // 2017/5/22 因為$row會變成空陣列，所以這邊要防呆一下 by lota
					// $tmps[] = array(
					// 	'name' => $row['name'],
					// 	'url' => $url_prefix.$_router_method.$detail_url,
					// );

					$ggg = array(
						'name' => $product_row['name'],
						// 'url' => $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'],

						// 2019-12-04 預留，李哥說不用
						// 'url' => $url_prefix.$_router_method.$detail_url, 
						'url' => '#',
					);

					// 2020-01-13 #34327
					// 內頁不需要處理上下區塊

					// 2019-11-08 李哥說經理說，要支援主選單，和編排頁(XXX_tw_1.php) - 前台次選單(靜態)
					$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$_router_method)->where('seo_item_id',$product_row['id'])->get('seo')->row_array();
					if($rowg and isset($rowg['id'])){
						// if($rowg['seo_title'] != ''){
						// 	$data['head_title'] = $rowg['seo_title'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	$data['head_title'] = $rowg['name'];
						// }
						// if($rowg['seo_meta_keyword'] != ''){
						// 	$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
						// }
						// if($rowg['seo_meta_description'] != ''){
						// 	$this->data['seo_description'] = $rowg['seo_meta_description'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
						// }

						if($rowg['seo_script_name'] != ''){
							$ggg['url'] = $url_prefix.$rowg['seo_script_name'].'.html';
							$ggg['id'] = $product_row['id'];
						} else {
							$ggg['url'] = $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'];
						}
					} else {
						// 李哥說，為了區分，低階和高階專案，所以這裡不會做任何事情
						// $data['head_title'] = $tmp['name'];
						// $this->data['seo_description'] = strip_tags($tmp['detail']);
					}

					$tmps[] = $ggg;
				}

			} else { // 多層分類(獨立資料表)

				$class_id = $_GET['id'];

				$row = false;
				if(preg_match('/detail$/', $this->data['router_method'])){
					if($common_item == 1){ // 分項通用
						$product_row = $this->db->createCommand()->select('*, topic as name')->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type and id=:id',array(':type'=>$_router_method,':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
					} else {
						$product_row = $this->db->createCommand()->from($_router_method)->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
					}
					$class_id = $product_row['class_id'];
				} else {
					$row = $this->db->createCommand()->from($_router_method.'type')->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
				}

				// $query = $this->cidb->select('id, pid AS class_id, name AS class_name, name AS class_name_id')->where(array('ml_key'=>$this->data['ml_key'],'is_enable'=>'1'))->get($_router_method.'type');

				// 2017-09-29 abbie回報的問題
				$rows = $this->cidb->select('id, is_enable, pid AS class_id, name AS class_name, name AS class_name_id')->where(array('ml_key'=>$this->data['ml_key']))->order_by('sort_id','asc')->get($type_name)->result_array();
				$closes = array();

				// 如果有不顯示的資料，不管是哪一層，都標示出來，並且刪掉自己
				foreach($rows as $k => $v){ 
					if($v['is_enable'] == 0){
						$closes[$v['id']] = '1';
						unset($rows[$k]);
					}
				}

				// 如果上一層有被標示，那就刪掉自己，並且標示自己
				// 這個動作會檢查四次 2017-10-11 李哥說的
				for($x=0;$x<=4;$x++){
					foreach($rows as $k => $v){ 
						if(isset($closes[$v['class_id']])){
							$closes[$v['id']] = '1';
							unset($rows[$k]);
						}
					}
				}

				if(preg_match('/detail$/', $this->data['router_method']) and isset($closes[$product_row['class_id']])){
					$product_row['class_id'] = 0;
					$class_id = 0;
				}

				$tmp2 = _get_product_classes($rows);

				if($common_category_multiple == '1'){
					// do nothing
				} else {
					// #25767
					// 2019-02-20 複選分類的時候，不需要處理單選的部份，也就是這一段的程式碼
					if(!isset($tmp2['sample']) or !isset($tmp2['sample'][$class_id])){
						header('Location: index_'.$this->data['ml_key'].'.php');
						die;
					}
				}

				$tmp3 = array();
				if($class_id > 0 and isset($tmp2['sample'][$class_id])){
					// 2018-04-26 修正如果次分類名稱一樣的時候，會造成的異常
					$tmp3 = _search_product_class_tree($tmp2['tree'], $tmp2['sample'], $tmp2['sample'][$class_id]['class_name'].'__'.$class_id);
				}

				// SEO
				$rows = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$type_name))->queryAll();
				$rows_tmp = array();
				if($rows){
					foreach($rows as $k => $v){
						$rows_tmp[$v['seo_item_id']] = $v;
					}
				}

				// SEO內頁
				// $rows2 = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method))->queryAll();
				// $rows2_tmp = array();
				// if($rows2){
				// 	foreach($rows2 as $k => $v){
				// 		$rows2_tmp[$v['seo_item_id']] = $v;
				// 	}
				// }

				//if($tmp3 and isset($tmp3['keyvalue']) and count($tmp3) > 0){
				if($tmp3 and isset($tmp3['keyvalue']) and !empty($tmp3)){
					//$i = 0; //設定麵包屑層數初始值 by lota
					foreach($tmp3['keyvalue'] as $k => $v){
						// $tmps[] = array(
						// 	'name' => $v,
						// 	'url' => $_router_method.'.php?id='.$k,
						// );

						$ggg = array(
							'id' => $k, // 2018-10-02 為了當網址為seo的時候，左側選單沒有辦法focus的問題
							'name' => $v,
							//'url' => $_router_method.'.php?id='.$k,
						);

						// 2020-01-13 #34327
						if($k == $class_id and $row and isset($row['id'])){
							if(isset($row['detail_top'])){
								$ggg['content_top'] = $row['detail_top'];
							}
							if(isset($row['detail_bottom'])){
								$ggg['content_bottom'] = $row['detail_bottom'];
							}
						}

						//$i++; //麵包屑層數
						$i = count($tmps)-1; // jerry 改

						if(isset($rows_tmp[$k]) and $rows_tmp[$k]['seo_script_name'] != ''){
							// SEO
							$ggg['url'] = $url_prefix.$rows_tmp[$k]['seo_script_name'].'.html';
							$ggg['id'] = $k;
						} else {
							// 讓麵包屑跟上方選單和左側選單連動 by lota
							// if($i == count($tmp3['keyvalue'])){
							// 	$ggg['url'] = $url_prefix.$_router_method.$url_suffix.'?id='.$k;
							// }else{
							// 	if($common_enableurl_by_subclass_haschild == '0'){
							// 		$ggg['url_old'] = $url_prefix.$_router_method.$url_suffix.'?id='.$k;
							// 		$ggg['url'] = 'javascript:;';
							// 	} else {
							// 		$ggg['url'] = $url_prefix.$_router_method.$url_suffix.'?id='.$k;
							// 	}
							// }					

							$ggg['url'] = $ggg['url_old'] = $url_prefix.$_router_method.$url_suffix.'?id='.$k;
							if($i != count($tmp3['keyvalue'])){
								if($common_enableurl_by_subclass_haschild == '0'){
									$ggg['url'] = 'javascript:;';
								}
							}					
						}
						$tmps[] = $ggg;
					}
				}

				// 如果到了產品內頁，那麵包屑要多加一個，也就是產品本身
				if(preg_match('/detail$/', $this->data['router_method'])){
					// if(isset($rows2_tmp[$product_row['id']]) and $rows2_tmp[$product_row['id']]['seo_script_name'] != ''){
					// 	// SEO
					// 	$ggg['url'] = $url_prefix.$rows2_tmp[$product_row['id']]['seo_script_name'].'.html';
					// 	$ggg['id'] = $product_row['id'];
					// } else {
					// 	$ggg['url'] = $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'];
					// }

					// 內頁的處理部份
					$detail_url = $url_suffix.'?id='.$_GET['id'];
					if($common_has_page_detail === true){
						$detail_url = 'detail'.$detail_url;
					}

					// 2019-11-08 李哥說經理說，要支援主選單，和編排頁(XXX_tw_1.php) - 前台次選單(靜態)
					$ggg = array(
						'name' => $product_row['name'],
						// 'url' => $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'],

						// 2019-12-04 預留，李哥說先不用
						// 'url' => $url_prefix.$_router_method.$detail_url, 
						'url' => '#',
					);


					$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$_router_method)->where('seo_item_id',$product_row['id'])->get('seo')->row_array();
					if($rowg and isset($rowg['id'])){
						// if($rowg['seo_title'] != ''){
						// 	$data['head_title'] = $rowg['seo_title'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	$data['head_title'] = $rowg['name'];
						// }
						// if($rowg['seo_meta_keyword'] != ''){
						// 	$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
						// }
						// if($rowg['seo_meta_description'] != ''){
						// 	$this->data['seo_description'] = $rowg['seo_meta_description'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
						// }

						if($rowg['seo_script_name'] != ''){
							$ggg['url'] = $url_prefix.$rowg['seo_script_name'].'.html';
							$ggg['id'] = $product_row['id'];
						} else {
							$ggg['url'] = $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'];
						}
					} else {
						// 李哥說，為了區分，低階和高階專案，所以這裡不會做任何事情
						// $data['head_title'] = $tmp['name'];
						// $this->data['seo_description'] = strip_tags($tmp['detail']);
					}

					$tmps[] = $ggg;
				}
			}

			// 2018-05-30 李哥允許這個新功能的開發，也就是上提一層的功能
			if($common_layer_up > 0){ // #34433
				unset($tmps[2]); // 2019-12-13 by lota
				//sort($tmps); // 上提選單後，沒排序的話，會導致content_top那邊的判斷錯誤，所以這一行要加 // 2020-09-26 這行打開，會導致麵包屑異常，會跑到home的左邊
				//var_dump($tmps);
			}


		} else {
			// 沒有分類的才會到這個地方哦，不過分項跟分類一樣有細分通用和獨立
			if($common_item == 1){ // 分項通用
				// 內頁的處理部份
				$detail_url = $url_suffix.'?id='.$_GET['id'];
				$product_row = $this->db->createCommand()->select('*,topic as name')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and id=:id',array(':type'=>$_router_method,':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
				// if(preg_match('/^(.*)type$/', $row['type'])){ // 是分類
				if(isset($product_row['type']) and preg_match('/^(.*)type$/', $product_row['type'])){ // 是分類 2018-10-11
					// 略過，在這個地方不是分辦，而是一個檢查機制
					$product_row = array();
				} else { // 還有一層
					if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method.'detail.php')){
						$detail_url = 'detail'.$detail_url;
					}
				}
			
				if($product_row and isset($product_row['name'])){ // 2017/5/22 因為$row會變成空陣列，所以這邊要防呆一下 by lota
					// $tmps[] = array(
					// 	'name' => $row['name'],
					// 	'url' => $url_prefix.$_router_method.$detail_url,
					// );

					// 2019-11-08 李哥說經理說，要支援主選單，和編排頁(XXX_tw_1.php) - 前台次選單(靜態)
					$ggg = array(
						'name' => $product_row['name'],
						// 'url' => $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'],
					);

					$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$_router_method)->where('seo_item_id',$product_row['id'])->get('seo')->row_array();
					if($rowg and isset($rowg['id'])){
						// if($rowg['seo_title'] != ''){
						// 	$data['head_title'] = $rowg['seo_title'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	$data['head_title'] = $rowg['name'];
						// }
						// if($rowg['seo_meta_keyword'] != ''){
						// 	$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
						// }
						// if($rowg['seo_meta_description'] != ''){
						// 	$this->data['seo_description'] = $rowg['seo_meta_description'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
						// }

						if($rowg['seo_script_name'] != ''){
							$ggg['url'] = $url_prefix.$rowg['seo_script_name'].'.html';
							$ggg['id'] = $product_row['id'];
						} else {
							$ggg['url'] = $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'];
						}
					} else {
						// 李哥說，為了區分，低階和高階專案，所以這裡不會做任何事情
						// $data['head_title'] = $tmp['name'];
						// $this->data['seo_description'] = strip_tags($tmp['detail']);
					}

					$tmps[] = $ggg;
				}
			} else { // 分項獨立
				$detail_url = $url_suffix.'?id='.$_GET['id'];
				$product_row = $this->db->createCommand()->from($_router_method)->where('is_enable=1 and ml_key=:ml_key and id=:id',array(':ml_key'=>$this->data['ml_key'],':id'=>$_GET['id']))->queryRow();
				if(file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'parent/'.$_router_method.'detail.php')){
					$detail_url = 'detail'.$detail_url;
				}
			
				if($product_row and isset($product_row['name']) > 0){ // 2017/5/22 因為$row會變成空陣列，所以這邊要防呆一下 by lota
					$tmps[] = array(
						'name' => $product_row['name'],
						'url' => $url_prefix.$_router_method.$detail_url,
					);

					// 2019-11-08 李哥說經理說，要支援主選單，和編排頁(XXX_tw_1.php) - 前台次選單(靜態)
					$ggg = array(
						'name' => $product_row['name'],
						// 'url' => $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'],
					);

					$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$_router_method)->where('seo_item_id',$product_row['id'])->get('seo')->row_array();
					if($rowg and isset($rowg['id'])){
						// if($rowg['seo_title'] != ''){
						// 	$data['head_title'] = $rowg['seo_title'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	$data['head_title'] = $rowg['name'];
						// }
						// if($rowg['seo_meta_keyword'] != ''){
						// 	$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
						// }
						// if($rowg['seo_meta_description'] != ''){
						// 	$this->data['seo_description'] = $rowg['seo_meta_description'];
						// } else {
						// 	// 2018-12-19 Ming下午口頭說的
						// 	// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
						// }

						if($rowg['seo_script_name'] != ''){
							$ggg['url'] = $url_prefix.$rowg['seo_script_name'].'.html';
							$ggg['id'] = $product_row['id'];
						} else {
							$ggg['url'] = $url_prefix.$_router_method.'detail'.$url_suffix.'?id='.$product_row['id'];
						}
					} else {
						// 李哥說，為了區分，低階和高階專案，所以這裡不會做任何事情
						// $data['head_title'] = $tmp['name'];
						// $this->data['seo_description'] = strip_tags($tmp['detail']);
					}

					$tmps[] = $ggg;
				}
			}
		}

	} // 資料表功能

} else { // 沒有編號的情況
	// do nothing
}

// 內頁大圖
if($bannersub_rule > 0){
	$bannersub_router_method = 'bannersub';

	$rows = array();
	if($bannersub_rule == 1){ // 功能導向
		$rows = $this->cidb->where(array('ml_key'=>$this->data['ml_key'],'type'=>$bannersub_router_method,'is_enable'=>1,'other1'=>$_router_method))->order_by('sort_id','asc')->get('html')->result_array();
	} elseif($bannersub_rule == 2 and isset($_GET['id']) and $_GET['id'] > 0){ // 鎖定編號
		$rows = $this->cidb->where(array('ml_key'=>$this->data['ml_key'],'type'=>$bannersub_router_method,'is_enable'=>1,'other1'=>$_router_method,'other2'=>$_GET['id']))->order_by('sort_id','asc')->get('html')->result_array();
	} elseif($bannersub_rule == 3 and isset($_GET['id']) and $_GET['id'] > 0){ // 編號繼承
		$rows2 = $this->cidb->where(array('ml_key'=>$this->data['ml_key'],'type'=>$bannersub_router_method,'is_enable'=>1,'other1'=>$_router_method,'other2 >'=>0))->order_by('sort_id','asc')->get('html')->result_array();
		$rows_tmp = array();
		$ids = array();
		if($rows2){
			foreach($rows2 as $k => $v){
				$ids[] = $v['other2'];
				$rows_tmp[$v['other2']][] = $v;
			}
		}
		$num = 1; // 是功能內頁的情況，從倒數第二層麵包屑開始找，如果是不是功能內頁，從最後一層開始找
		if(preg_match('/detail/', $this->data['router_method'])){
			$num = 2;
		}
		for($x=(count($tmps)-$num);$x>=0;$x--){ // 從倒數第二層開始檢查
			// 為了要判別網址欄位被覆寫前的內容(如果有被覆寫的話)
			$field = 'url'; 
			if(isset($tmps[$x]) and isset($tmps[$x]['url_old'])){
				$field = 'url_old';
			}
			if(isset($tmps[$x]) and preg_match('/php\?id\=(.*)$/',$tmps[$x][$field],$matches) and in_array($matches[1],$ids)){
				$rows = $rows_tmp[$matches[1]];
				break;
			}
		}
	}

	//if($rows and count($rows) > 0){
	if($rows and !empty($rows)){
		// foreach($rows as $k => $v){
		// 	$v['topic'] = $v['topic'];
		// 	$v['describe'] = $v['detail'];
		// 	$v['url'] = $v['url1'];

		// 	// 套程式
		// 	if(preg_match('/^images\//', $v['pic1'])){
		// 		// 這是為了開環境的程式所寫的
		// 		$v['pic'] = $v['pic1'];
		// 	} else {
		// 		$v['pic'] = '_i/assets/upload/bannersub/'.$v['pic1'];
		// 	}

		// 	if(!isset($v['pic2']) or $v['pic2'] == ''){
		// 		$v['pic2'] = $v['pic'];
		// 	} else {
		// 		if(preg_match('/^images\//', $v['pic2'])){
		// 			// 這是為了開環境的程式所寫的，因為欄位名稱剛好相同，所以這行註解掉
		// 			// \$tmps[\$k]['pic2'] = \$v['pic2'];
		// 		} else {
		// 			$v['pic2'] = '_i/assets/upload/bannersub/'.$v['pic2'];
		// 		}
		// 	}
		// 	$rows[$k] = $v;
		// }

		// if($this->data['router_method'] == 'index'){
		// 	$tmp = 'banner';
		// } else {
		// 	$tmp = 'bannersub';
		// }

		// 2018-05-29 李哥發現的問題，以下的程式碼是從source/home/banner3.php複製過來改的
		foreach($rows as $k => $v){
			$v['describe'] = $v['detail'];
			$v['url'] = $v['url1'];

			// 套程式
			if(preg_match('/^images\//', $v['pic1'])){
				// 這是為了開環境的程式所寫的
				$v['pic1g'] = $v['pic1'];
			} else {
				// $v['pic1g'] = '_i/assets/upload/'.$tmp.'/'.$v['pic1'];
				$v['pic1g'] = '_i/assets/upload/'.$bannersub_router_method.'/'.$v['pic1'];
			}

			if(!isset($v['pic2']) or $v['pic2'] == ''){
				$v['pic2g'] = $v['pic1g'];
			} else {
				if(preg_match('/^images\//', $v['pic2'])){
					$v['pic2g'] = $v['pic2'];
				} else {
					// $v['pic2g'] = '_i/assets/upload/'.$tmp.'/'.$v['pic2'];
					$v['pic2g'] = '_i/assets/upload/'.$bannersub_router_method.'/'.$v['pic2'];
				}
			}
			$rows[$k] = $v;
			//#43829 
			if($v['field_data']!=''){
				$data['pagebanner_field_data'] = $v['field_data'];
			}
		}

		$view_file = 'v3/home/banner1';
		if(isset($layoutv3_struct_map_keyname[$view_file][0])){
			$data[$layoutv3_struct_map_keyname[$view_file][0]] = $rows;
		}
	}
}

// 2017-12-07 dom4 hack 為了支援無限層的條件
// if(isset($tmps) and count($tmps) > 0){
if(isset($tmps) and !empty($tmps)){
	// $tmps_check = array(); // 2018-03-05 因為編號重覆，會造成後續程式的困擾，所以這裡必需要修正
	foreach($tmps as $k => $v){
		if(!isset($v['id'])){ // 先隨便給一個編號
			// $tmps_check[] = $k;
			// $v['id'] = $k;
			$v['id'] = 'x'.$k;
		}
		if(isset($v['url']) and preg_match('/\?id\=(.*)/', $v['url'], $matches)){ // 如果是真實網址的編號，那就覆寫上面那個隨便的編號
			// if(!in_array($matches[1],$tmps_check)){
			// 	$tmps_check[] = $matches[1];
			// 	$v['id'] = $matches[1];
			// }
			$v['id'] = $matches[1];
		}
		if(isset($v['url_old']) and preg_match('/\?id\=(.*)/', $v['url_old'], $matches)){ // 如果網址被改成javascript:;尤於有子類的關係，那就換判斷這個欄位
			// if(!in_array($matches[1],$tmps_check)){
			// 	$tmps_check[] = $matches[1];
			// 	$v['id'] = $matches[1];
			// }
			$v['id'] = $matches[1];
		}

		if(!isset($v['pid'])){
			$v['pid'] = 0;
		}
		$tmps[$k] = $v;
	}

	// 2018-04-26 給編排頁用的，挑最後一個當做func_name_sub_id，非編排頁的，寫在source/system/general_item
	$this->data['func_name_sub_id'] = 'navlight_'.$v['id'];
}
//隱私權政策麵包削
if($this->data['router_method']=='privacy_1'){
	$tmps[1]=array('name'=>'隱私權聲明','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
	// print_r($tmps);die;
}
//線上捐款麵包削
if($this->data['router_method']=='donation_1'){
	$tmps[1]=array('name'=>'填寫表單','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='donation_2'){
	$tmps[1]=array('name'=>'捐款確認','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='donation_3'){
	$tmps[1]=array('name'=>'付款頁面','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}

// if($this->data['router_method']=='apply_1'){
// 	$tmps[1]=array('name'=>'填寫計畫','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
// }
// if($this->data['router_method']=='apply_2'){
// 	$tmps[1]=array('name'=>'班級申請','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
// }
// if($this->data['router_method']=='apply_3'){
// 	$tmps[1]=array('name'=>'上船申請','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
// }
// if($this->data['router_method']=='apply_4'){
// 	$tmps[1]=array('name'=>'審查進度','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
// }
// if($this->data['router_method']=='apply_5'){
// 	$tmps[1]=array('name'=>'期末成果','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
// }
if($this->data['router_method']=='photocopyform_1'){
	$tmps[1]=array('name'=>'影印頁面','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='apply_9'){
	$tmps[1]=array('name'=>'填寫計畫','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='classout_1'){
	$tmps[1]=array('name'=>'班級首頁','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='classout_2' || $this->data['router_method']=='classout_5'){
	$tmps[1]=array('name'=>'公佈欄','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='classout_3'){
	$tmps[1]=array('name'=>'相片成果','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='classout_4'){
	$tmps[1]=array('name'=>'影音成果','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='apply_2'){
	$tmps[1]=array('name'=>'班級申請','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if($this->data['router_method']=='apply_5'){
	$tmps[1]=array('name'=>'期末成果','url'=>$_SERVER['REQUEST_URI'],'id' => 'x1','pid'=>'0');
}
if(isset($ID)){ // 試試看這裡是不是也能這樣子寫
	$data[$ID] = $tmps;
}
