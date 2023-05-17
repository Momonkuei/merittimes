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

$id = 0;
if(isset($_GET['id']) and $_GET['id'] > 0){
	$id = intval($_GET['id']);
}

// 一般產品，沒有像購物的產品側邊有那麼多的東西，就只有一個
// class_name => eventMenu(第一個區塊在用的), proCatalog(第二個), sideFilter(第三個)
if(isset($layoutv3_struct_map_keyname['v3/shop/block'])){
	$data[$layoutv3_struct_map_keyname['v3/shop/block'][0]] = array('name'=>'Categories','class_name'=>'eventMenu'); 
}

// 跟隨前台主選單的配置
// $tmp = $this->db->createCommand()->from('html')->where('type=:type and ml_key=:ml_key and url1=:url',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key'],':url'=>$this->data['router_method'].'_'.$this->data['ml_key'].'.php'))->queryRow();
// if($tmp and isset($tmp['id']) and $tmp['id'] > 0 and $tmp['is_home'] == 1/*是否有啟用資料表功能*/){
// 	// 資料表功能
// 	$common_is_enable = $tmp['is_home'];
// 	$common_is_category = $tmp['pic2']; // 是或不是分類
// 	$common_category = $tmp['is_news']; // 是或不是通用分類
// 	$common_item = $tmp['class_ids'];   // 是或不是通用分項
// 	$common_date_sort = $tmp['pic3'];
// 
// 	// 跟隨後台的前台主選單的"第一個次選單覆寫網址的功能"
// 	$common_first_childurl_replace = $tmp['other3'];
// }

/*
 * 商品搜尋
 */
// if(isset($_GET['q']) and $_GET['q'] != ''){
// 
// 	// 2017-03-30 Ming早上說的
// 	// 預設語系，為了讓搜尋不會壞掉(怕壞掉)
// 	if(!isset($this->data['ml_key']) and $this->data['ml_key'] == ''){
// 		$this->data['ml_key'] = 'tw';
// 	}
// 	
// 	//$tmps = $this->db->createCommand()->from($this->data['router_method'])->where('is_enable=1 and name like :name',array(':name'=>'%'.$_GET['q'].'%'))->queryAll();
// 	$tmps = $this->db->createCommand()->from($this->data['router_method'])->where('is_enable=1 and ml_key =:ml_key and (name like :name or detail like :name or field_data like :name or field_tmp like :name)',array(':name'=>'%'.$_GET['q'].'%',':ml_key'=>$this->data['ml_key']))->queryAll();
// 
// 	if($tmps and count($tmps) > 0){
// 		foreach($tmps as $k => $v){
// 			$tmps[$k]['url1'] = $tmps[$k]['url2'] = $this->data['router_method'].'detail_'.$this->data['ml_key'].'.php?id='.$v['id'];
// 			$tmps[$k]['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];
// 		}
// 	}
// 	$data[$ID] = $tmps;
// 
// 	// SEO
// 	$data['head_title'] = str_replace($this->data['func_name'].' | ', $_GET['q'].' | ', $data['head_title']); // 預設值
// } else {


// 商品上面的分類要用的
$tmps = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable =1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
$tmps_tmp = array();
if($tmps){
	foreach($tmps as $k => $v){
		$tmps_tmp[$v['id']] = $v;
	}
}

//設定分頁基本參數 要記得在view那邊加入分頁的view
$pagew = 0;
if(isset($_GET['page']) and $_GET['page'] > 0){
	$pagew = $_GET['page'];
}
$limit_count = 12;//一頁顯示幾筆
$_GET['current_page'] = $pagew;

$DataList = array();
$pageRecordInfo = array();

// 這個是預設的product列表頁顯示產品
// 有符合條件的話，處理完就會跳出了，不會在執行以下的程式碼
unset($_constant);
eval('$_constant = '.strtoupper($this->data['router_method'].'_DEFAULT_SHOW_TYPE').';');
if($id == 0 and $_constant == 1){

 	// 2017-09-30 在鉅基上發現的問題，就是把大類關掉，但產品在總覽頁上面還是會顯示的問題
 	$rows = $this->cidb->where(array('ml_key'=>$this->data['ml_key']))->order_by('sort_id','asc')->get($this->data['router_method'].'type')->result_array();
 	$closes = array();
 	// 檢查第一次：檢查上層是否有被關閉，如果有的話，就底下也跟著關閉
 	foreach($rows as $k => $v){ 
 		if($v['pid'] > 0 and isset($closes[$v['pid']])){
 			$closes[$v['id']] = '1';
 		}
 		if($v['is_enable'] == 0){
 			$closes[$v['id']] = '1';
 		}
 	}

 	// 檢查第二次
 	foreach($rows as $k => $v){ 
 		if($v['pid'] > 0 and isset($closes[$v['pid']])){
 			$closes[$v['id']] = '1';
 		}
 		if($v['is_enable'] == 0){
 			$closes[$v['id']] = '1';
 		}
 	}

 	$close = '';
 	if(count($closes) > 0){
 		$closes_tmp = array();
 		foreach($closes as $k => $v){
 			$closes_tmp[] = $k;
 		}
 		$close = implode(',', $closes_tmp);
 	}

	// 商品全部列表 (總覽頁)
	$db = new Mysqleric(array('table'=>$this->data['router_method'].' as a'));

	//分頁SEO  by lota 2017/8/9
	if(isset($_GET['type'])){
		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	}else{
		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	}

	$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	$qryField = 'a.*';
	$qryWhere = ' left join '.$this->data['router_method'].'type as b on b.id=a.class_id';
	$qryWhere .= ' WHERE a.is_enable=1 and b.id > 0 and a.ml_key=\''.$this->data['ml_key'].'\'';	
	//如果要使用沒有分類也可以顯示產品總纜，就把註解打開；總經理建議的 to 雅貿 by lota 2017/10/20
	//$close ='';$show_all_no_type = '';	
	//$qryWhere = ' WHERE a.is_enable=1 and a.ml_key=\''.$this->data['ml_key'].'\'';	

 	// 2017-09-30 在鉅基上發現的問題，就是把大類關掉，但產品在總覽頁上面還是會顯示的問題
	if($close != ''){
		$qryWhere .= ' AND NOT b.id IN('.$close.') ';
	}

	//$qryWhere .=' order by rand()';
	$qryWhere .=' order by a.sort_id_browser'; // 2017-03-29 李哥早上建議的，因為經理要在晨寬的影片加這個，還有多分類排序
	//echo $qryWhere;

	$db->getData($qryField, $qryWhere, (int)$limit_count);
	if($db->total_row > 0) {
		$DataCount = $db->total_row;
		do{
			// 如果顯示所有產品的時候，該產品沒有選分類的話，那就不顯示這個產品
			if(!isset($tmps_tmp[$db->row['class_id']]) && !isset($show_all_no_type)){
				continue;
			}

			$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
			// $db->row['url3'] = 'save.php?id='.$this->data['router_method'].'inquiry&_append=&amount=1&primary_key='.$db->row['id'];
			$db->row['url3'] = 'save.php?id=productinquiry&_append=&amount=1&primary_key='.$this->data['router_method'].'___'.$db->row['id'];
			$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];

			// 其實這裡應該是，後台要在新增另外一個欄位，只是懶的新增，所以先註解起來
			//$db->row['name2'] = $db->row['detail'];

			$db->row['name2'] = $db->row['name'];
			$db->row['img_alt'] = $db->row['name']; // SEO
			if(isset($tmps_tmp[$db->row['class_id']])){
				$db->row['name'] = $tmps_tmp[$db->row['class_id']]['name'];
			}else{
				$db->row['name'] ='';
			}

			// 沒有分類的情況 2017-10-13
			// $db->row['name'] = '';

			$db->row['content1'] = $db->row['field_data'];
			$db->row['content2'] = $db->row['field_tmp'];

			// 簡述
			if(isset($layoutv3_struct_map_keyname['v3/product/layout_sub_pic_left_txt_right'])){
				$db->row['describe'] = nl2br($db->row['detail']);
			}

			$DataList[] = $db->row;
		}while($db->row = $db->result->fetch_assoc());
		$pageRecordInfo = $db->get_page_bar($url);
		$pageBar = $db->record_info();
	}
	$data[$ID] = $DataList;
	// return; // 平面化一定會出問題
} else {

	//使用分頁列表
	if($id == 0){
		// 分頁SEO  by lota 2017/8/9
		// if(isset($_GET['type'])){
		// 	// 2017-12-20 李哥早上說弄錯了
		// 	$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.html?page=';
		// }else{
		// 	$url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?page=';
		// }		

		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?page=';
	} else {
		$url = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$id.'&page=';
	}

	/*
	 * 這裡是商品分類
	 */
	// 如果product_show_type == 2 ，則不顯示分類 by lota	
	eval('$_constant_1 = '.strtoupper($this->data['router_method'].'_SHOW_TYPE').';');
	if($_constant_1 == 0){

		// SEO
		$rows = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type',array(':ml_key'=>$this->data['ml_key'],':type'=>$this->data['router_method'].'type'))->queryAll();
		$rows_tmp = array();
		if($rows){
			foreach($rows as $k => $v){
				$rows_tmp[$v['seo_item_id']] = $v;
			}
		}
		//分頁SEO 替換 by lota 2017/8/9
		if(isset($rows_tmp[$id])){
			$url = $url_prefix.$rows_tmp[$id]['seo_script_name'].'.html?page=';
		}
		//舊站SEO轉換新站方式 - 有問題
		//$rows_tmp1 = $this->db->createCommand()->from('producttype2'.$this->data['ml_key'])->where('id=:id',array(':id'=>$id))->queryRow();
		//$url = $rows_tmp1['script_name'].'.html?page=';

		$db = new Mysqleric(array('table'=>$this->data['router_method'].'type'));
		
		$qryField = '*';
		$qryWhere = ' WHERE is_enable =1 and pid='.$id.' and ml_key=\''.$this->data['ml_key'].'\'';	

		$qryWhere .=' order by sort_id';

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{

				$db->row['name2'] = $db->row['name'];
				$db->row['img_alt'] = $db->row['name']; // SEO
				$db->row['name'] = '';

				// SEO
				if(isset($rows_tmp[$db->row['id']]) and $rows_tmp[$db->row['id']]['seo_script_name'] != ''){
					$db->row['url1'] = $db->row['url2'] = $url_prefix.$rows_tmp[$db->row['id']]['seo_script_name'].'.html';
				}else{
					$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$db->row['id'];
				}
				//舊站SEO轉換新站方法 視情況使用 - by lota
				//$other_url = '';
				//if($this->data['ml_key'] == 'tw'){
				//	$other_url = 'tw/';
				//}
				//$db->row['url1'] = $db->row['url2'] = $other_url.$db->row['script_name'].'.html';


				//$db->row['url1'] = $db->row['url2'] = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?id='.$db->row['id'];
				
				$db->row['url3'] = ''; // 分類沒有詢問車
				$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$db->row['pic1'];

				// 簡述
				if(isset($layoutv3_struct_map_keyname['v3/product/layout_sub_pic_left_txt_right'])){
					$db->row['describe'] = nl2br($db->row['detail']);
				}

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}
	}


	if(count($DataList) > 0){
		// 這裡是分類列表
		$data[$ID] = $DataList;

		if($DataList[0]['pid'] > 0){
			$tmp = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable =1 and id=:id',array(':id'=>$DataList[0]['pid']))->queryRow();

			//預防沒資料時會報錯 by lota
			if(!$tmp){
				$tmp = array('name'=>'','detail'=>'');
			}

			unset($_constant); //by lota 
			eval('$_constant = '.strtoupper(str_replace('type','',$this->data['router_method'])).'_TYPE_DETAIL;');
			if(!$_constant){
				$tmp['detail'] = '';
			}

			if(isset($layoutv3_struct_map_keyname['v3/category_title'])){
				$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = array(
					'name' => $tmp['name'],
					'sub_name' => $tmp['detail'],
				);
			}

			// SEO
			$data['head_title'] = str_replace($this->data['func_name'].' | ', $tmp['name'].' | ', $data['head_title']); // 預設值

			$row = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type and seo_item_id='.$id,array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method.'type'))->queryRow();
			if($row and isset($row['id'])){
				if($row['seo_title'] != ''){
					$data['head_title'] = $row['seo_title'];
				}
				if($row['seo_meta_keyword'] != ''){
					$this->data['seo_keywords'] = $row['seo_meta_keyword'];
				}
				if($row['seo_meta_description'] != ''){
					$this->data['seo_description'] = $row['seo_meta_description'];
				}
			}
			//舊站SEO轉換新站方法 視情況使用 - by lota
			//if($tmp['title']!=''){
			//	$data['head_title'] = $tmp['title'];
			//}
			//if($tmp['meta_keyword']!=''){
			//	$this->data['seo_keywords'] = $tmp['meta_keyword'];
			//}
			//if($tmp['meta_desc']!=''){
			//	$this->data['seo_description'] = $tmp['meta_desc'];
			//}

			$tmps = array();
			foreach($tmp as $k => $v){
				if(preg_match('/^pic/', $v)){
				}
			}
		}
	} else {

		/*
		 * 這裡是產品
		 */

		// 分類
		$tmp = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable =1 and id=:id',array(':id'=>$id))->queryRow();

		unset($_constant);//by lota
		eval('$_constant = '.strtoupper(str_replace('type','',$this->data['router_method'])).'_TYPE_DETAIL;');
		if(!$_constant){
			$tmp['detail'] = '';
		}

		if(isset($layoutv3_struct_map_keyname['v3/category_title'])){
			$data[$layoutv3_struct_map_keyname['v3/category_title'][0]] = array(
				'name' => $tmp['name'],
				'sub_name' => $tmp['detail'],
			);
		}

		// SEO
		$data['head_title'] = str_replace($this->data['func_name'].' | ', $tmp['name'].' | ', $data['head_title']); // 預設值

		//2017/7/14 這邊type使用$_router_method會找不到數值，改用 $_router_method.'type' by lota
		$row = $this->db->createCommand()->from('seo')->where('seo_ml_key =:ml_key and seo_type=:type and seo_item_id='.$id,array(':ml_key'=>$this->data['ml_key'],':type'=>$_router_method.'type'))->queryRow();
		if($row and isset($row['id'])){
			if($row['seo_title'] != ''){
				$data['head_title'] = $row['seo_title'];
			}
			if($row['seo_meta_keyword'] != ''){
				$this->data['seo_keywords'] = $row['seo_meta_keyword'];
			}
			if($row['seo_meta_description'] != ''){
				$this->data['seo_description'] = $row['seo_meta_description'];
			}
		}
		//舊站SEO轉換新站方法 視情況使用 by lota
		//if($tmp['title']!=''){
		//	$data['head_title'] = $tmp['title'];
		//}
		//if($tmp['meta_keyword']!=''){
		//	$this->data['seo_keywords'] = $tmp['meta_keyword'];
		//}
		//if($tmp['meta_desc']!=''){
		//	$this->data['seo_description'] = $tmp['meta_desc'];
		//}

		//分頁SEO 替換 by lota 2017/8/9
		if(isset($rows_tmp[$id])){
			$url = $url_prefix.$rows_tmp[$id]['seo_script_name'].'.html?page=';
		}
		//舊站SEO轉換新站方法 視情況使用 by lota
		//$url = $tmp['script_name'].'.html?page=';

		// 商品
		$db = new Mysqleric(array('table'=>$this->data['router_method']));

		$qryWhere_1 = '';
		if($_constant_1 == 0){ // 試著修修看 類別最後一層會顯示最後一層類別的產品 by lota
			$qryWhere_1 .= 'and class_id='.$id;
		} elseif($_constant_1 == 1){
			//向下搜尋子類別的所有產品 by lota
			$se_sql = '';$key_id = $id;
			if($key_id){
				$tmp1 = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable =1 and pid =:pid',array(':pid'=>$key_id))->order('sort_id')->queryAll();
				if(is_array($tmp1)){
					foreach($tmp1 as $k => $v){
						$se_sql .=' OR class_id='.$v['id'];
					}
				}
				$se_sql .=' OR class_id='.$key_id;
				$se_sql .=')';
				$qryWhere_1 .=' and (0'.$se_sql;
			}
		}elseif($_constant_1 == 2)//PRODUCT_SHOW_TYPE == 2
			$qryWhere_1 .= 'and class_id='.$id;
		

		$qryField = '*';
		$qryWhere = ' WHERE is_enable=1 '.$qryWhere_1.' and ml_key=\''.$this->data['ml_key'].'\'';	

		$qryWhere .=' order by sort_id';
		//echo $qryWhere;die;

		$db->getData($qryField, $qryWhere, (int)$limit_count);
		if($db->total_row > 0) {
			$DataCount = $db->total_row;
			do{
				$db->row['url1'] = $db->row['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$db->row['id'];
				// $db->row['url3'] = 'save.php?id='.$this->data['router_method'].'inquiry&_append=&amount=1&primary_key='.$db->row['id'];
				$db->row['url3'] = 'save.php?id=productinquiry&_append=&amount=1&primary_key='.$this->data['router_method'].'___'.$db->row['id'];
				$db->row['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$db->row['pic1'];

				//舊站SEO轉換新站方法 視情況使用 by lota
				//$other_url = '';
				//if($this->data['ml_key'] == 'tw'){
				//	$other_url = 'tw/';
				//}
				//$db->row['url1'] = $db->row['url2'] = $other_url.$db->row['script_name'].'.html';

				// 其實這裡應該是，後台要在新增另外一個欄位，只是懶的新增，所以先註解起來
				//$db->row['name2'] = $db->row['detail'];

				$db->row['name2'] = $db->row['name'];
				$db->row['img_alt'] = $db->row['name']; // SEO
				$db->row['name'] = $tmp['name'];

				// 沒有分類的情況 2017-10-13
				// $db->row['name'] = '';

				// Debug
				// $db->row['price'] = 9487;
				// $db->row['unit'] = 'NT$';

				$db->row['content1'] = $db->row['field_data'];
				$db->row['content2'] = $db->row['field_tmp'];

				// 簡述
				if(isset($layoutv3_struct_map_keyname['v3/product/layout_sub_pic_left_txt_right'])){
					$db->row['describe'] = nl2br($db->row['detail']);
				}

				$DataList[] = $db->row;
			}while($db->row = $db->result->fetch_assoc());
			$pageRecordInfo = $db->get_page_bar($url);
			$pageBar = $db->record_info();
		}
		$data[$ID] = $DataList;

	}
} // PRODUCT_DEFAULT_SHOW_TYPE

// } // 是不是產品搜尋
