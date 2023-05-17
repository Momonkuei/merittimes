<?php

/* 
 * 2018-10-09
 *
 * 搜尋的使用說明
 *
 * 就在列表的那一個view的下面，增加view裡面的system/search
 * 然後把後台該page裡面，把share-search給打勾就可以了
 *
 * 2017-10-03
 *
 * 使用說明
 *
 * 第一：
 * $page_source = array(
 *	   'product-general',
 *	   'product-search', // 搜尋要在分項資料之下、分頁之上
 *	   'share-pagenav',
 * );
 * 
 * 第二：
 * $page = array(
 *	   array('file' => 'product/list1_1'),
 *	   array('file' => 'product/search'), // 搜尋要放在分項的正下方
 * );
 */

// 2018-10-19 因為有時候搜尋不止有一個，也不一定是q
$_search_field = 'q';

if(isset($_GET[$_search_field]) and $_GET[$_search_field] != ''){

	// 2017-03-30 Ming早上說的(針對產品的部份)
	// 預設語系，為了讓搜尋不會壞掉(怕壞掉)
	if(!isset($this->data['ml_key']) and $this->data['ml_key'] == ''){
		$this->data['ml_key'] = 'tw';
	}

	$pagew = 1; // Splitpage
	if(isset($_GET['page']) and $_GET['page'] > 0){
		$pagew = $_GET['page'];
	}
	$limit_count = 12;//一頁顯示幾筆
	$pageRecordInfo = array();

	$_router_method = $this->data['router_method'];

	// 2018-09-11 A方案專用
	// if($_router_method == 'download_2'){
	// 	$_router_method = 'brochure';
	// } elseif($_router_method == 'download_3'){
	// 	$_router_method = 'edm';
	// }

	// 跟隨前台主選單的配置
	$tmp = $this->db->createCommand()->from('html')->where('type =:type and ml_key=:ml_key and url1=:url',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key'],':url'=>$_router_method.'_'.$this->data['ml_key'].'.php'))->queryRow();
	if($tmp and isset($tmp['id']) and $tmp['id'] > 0 and $tmp['is_home'] == 1/*是否有啟用資料表功能*/){
		// 資料表功能
		$common_is_enable = $tmp['is_home'];
		$common_is_category = $tmp['pic2']; // 有沒有分類
		$common_category = $tmp['is_news']; // 是或不是通用分類
		if(isset($tmp['other22'])){
			$common_other_category = $tmp['other22']; //是否有自訂分類
		}else{
			$common_other_category = '';
		}		
		if(isset($tmp['other26'])){
			$common_plural_category = $tmp['other26']; //是否為複數分類
		}else{
			$common_plural_category = 0;
		}		
		$common_item = $tmp['class_ids'];   // 是或不是通用分項
		$common_date_sort = $tmp['pic3'];
		$common_articlesingle = $tmp['is_top']; // 單頁專用

		$common_limit_count = $tmp['other6']; // 每頁幾筆

		// $common_date_range = $row['other24']; // date1, date2 下架時間
		if(isset($row['other24'])){
			$common_date_range = $row['other24']; // date1, date2 下架時間
		}else{
			$common_date_range = 0;
		}

		if($common_limit_count != ''){
			$limit_count = $common_limit_count;
		}
	
		// 跟隨後台的前台主選單的"第一個次選單覆寫網址的功能"
		$common_first_childurl_replace = $tmp['other3'];

		//初始化關聯資料陣列
		$_category_data = array();

		// 處理筆數：通用
		if($common_item == 1){
			
			//2020-10-15 加入判斷有關連的資料是否開啟 ，這邊是計算資料筆數的地方，下面還有喔
			if($common_is_category == 1 && $common_category == 1){
				if($common_other_category == ''){
					$_tmp = $this->cidb->select('id')->where('type',$_router_method.'type')->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->get('html')->result_array();
				}else{
					$_tmp = $this->cidb->select('id')->where('type',$common_other_category)->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->get('html')->result_array();
				}				
				foreach ($_tmp as $key => $value) {
					$_category_data[] = $value['id'];
				}
			}


			$o = $this->cidb->select('id');			

			//這邊是計算資料筆數的地方，下面還有喔
			if(count($_category_data) > 0){
				if($common_plural_category == 0){ //2020-10-15 單選分類的情境 預設適用 class_id
					$o = $o->where_in('class_id',$_category_data);
				}else{ //複選的情境 ... 等有緣人來測試驗證	 預設適用 class_ids
					$o = $o->group_start();
					foreach ($_category_data as $key => $value) {
						if($key==0){
							$o = $o->like('class_ids', ','.$value.',');
						}else{
							$o = $o->or_like('class_ids', ','.$value.',');
						}						
					}					
					$o = $o->group_end();
				}				
			}

			// 通用
			// 以下條件三選一(1/4)

			// 1. 單純一個條件的時候
			$o = $o->like('topic', $_GET[$_search_field]);

			// 2. 多個條件的時候，請換成這個 for ci2.0
			// $o = $o->where("is_enable = 1 and type='".$_router_method."' and ml_key='".$this->data['ml_key']."' and (topic LIKE '%".$_GET[$_search_field]."%' or XXX LIKE '%".$_GET[$_search_field]."%')");

			// 3. ci3的寫法
			// $o = $o->group_start()->like('topic', $_GET[$_search_field])->or_like('XXX', $_GET[$_search_field])->group_end();

			if($common_date_range == '1'){
				$o = $o->where('(date1 <= NOW() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= NOW() OR date2 IS NULL OR date2 = "0000-00-00")');
			}

			$o = $o->where('is_enable',1)->where('type',$_router_method)->where('ml_key',$this->data['ml_key']);

			$o = $o->from('html');
		} else {

			//2020-10-15 加入判斷有關連的資料是否開啟 ，這邊是計算資料筆數的地方，下面還有喔
			if($common_is_category == 1 && $common_category == 0){
				if($common_other_category == ''){
					$_tmp = $this->cidb->select('id')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get($_router_method.'type')->result_array();
				}else{
					$_tmp = $this->cidb->select('id')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get($common_other_category)->result_array();
				}				
				foreach ($_tmp as $key => $value) {
					$_category_data[] = $value['id'];
				}
			}

			$o = $this->cidb->select('id');			

			//這邊是計算資料筆數的地方，下面還有喔
			if(count($_category_data) > 0){
				if($common_plural_category == 0){ //2020-10-15 單選分類的情境 預設適用 class_id
					$o = $o->where_in('class_id',$_category_data);
				}else{ //複選的情境 ... 等有緣人來測試驗證	 預設適用 class_ids
					$o = $o->group_start();
					foreach ($_category_data as $key => $value) {
						if($key==0){
							$o = $o->like('class_ids', ','.$value.',');
						}else{
							$o = $o->or_like('class_ids', ','.$value.',');
						}						
					}					
					$o = $o->group_end();
				}				
			}

			// 獨立
			// 以下條件四選一(2/4)

			// 1. 單純一個條件的時候
			// $o = $o->like('name', $_GET[$_search_field]);

			// 2. 多個條件的時候，請換成這個 for ci2.0
			// $o = $o->where("(name LIKE '%".$_GET[$_search_field]."%' or XXX LIKE '%".$_GET[$_search_field]."%')");

			// 3. 改成ci3.0的寫法，並加入經理要求的精準搜尋品號 by lota 2019-04-29
			//    如果沒有item_name的欄位，就會單純的使用一個條件來搜尋 2020-06-20
			$rowg = $this->cidb->get($_router_method)->row_array();
			if($rowg and isset($rowg['item_name'])){
				$o = $o->group_start()->like('name', $_GET[$_search_field])->or_like('item_name', $_GET[$_search_field])->group_end();
			} else {
				$o = $o->group_start();
				$o = $o->like('name', $_GET[$_search_field]); //要增加項目的話，請加在這行下面
				$o = $o->group_end();
				
			}

			if($common_date_range == '1'){
				$o = $o->where('(date1 <= NOW() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= NOW() OR date2 IS NULL OR date2 = "0000-00-00")');
			}

			$o = $o->where('is_enable',1)->where('ml_key',$this->data['ml_key']);

			$o = $o->from($_router_method);

			// 4. 同時搜尋一個以上的資料表(盟鑫) #38433
			// $sql = 'SELECT id,name,class_id,pic1,field_data,field_tmp,"product" FROM product WHERE name LIKE "%'.$_GET[$_search_field].'%" OR detail LIKE "%'.$_GET[$_search_field].'%" ';
			// $sql .= ' UNION SELECT id,name,class_id,pic1,field_data,field_tmp,"applications" FROM applications WHERE name LIKE "%'.$_GET[$_search_field].'%" OR detail LIKE "%'.$_GET[$_search_field].'%" ';
			// $sql .= ' ORDER BY name ';
			// $rows = $this->cidb->query($sql)->result_array();
		}
		$total_rows = $o->count_all_results();

		// 處理筆數：客製SQL語法範例
		// $sql = 'select id from html where topic like "%'.$_GET[$_search_field].'%" and is_enable=1 and ml_key="'.$this->data['ml_key'].'" and (type="protector" or type="prosthetics" or type="spine")';
		// $this->cidb->query($sql)->result_array();
		// $total_rows = $this->cidb->count_all_results();

		// 2018-09-11 為了支援編排頁
		// if(preg_match('/\_/', $this->data['router_method'])){
		// 	$tmps = explode('_', $this->data['router_method']);
		// 	$url = $url_prefix.$tmps[0].'_'.$this->data['ml_key'].'_'.$tmps[1].'.php?q='.$_GET[$_search_field].'&page=';
		// } else {
		// 	$url = $url_prefix.$this->data['router_method'].$url_suffix.'?q='.$_GET[$_search_field].'&page=';
		// }
		if(preg_match('/\_/', $_router_method)){
			$tmps = explode('_', $_router_method);
			$url = $url_prefix.$tmps[0].'_'.$this->data['ml_key'].'_'.$tmps[1].'.php?q='.$_GET[$_search_field].'&page=';
		} else {
			$url = $url_prefix.$_router_method.$url_suffix.'?q='.$_GET[$_search_field].'&page=';
		}

		include _BASEPATH.'/../source/core/pagination.php';

		// 處理資料：通用
		if($common_item == 1){

			//2020-10-15 加入判斷有關連的資料是否開啟
			if($common_is_category == 1 && $common_category == 1){
				if($common_other_category == ''){
					$_tmp = $this->cidb->select('id')->where('type',$_router_method.'type')->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->get('html')->result_array();
				}else{
					$_tmp = $this->cidb->select('id')->where('type',$common_other_category)->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->get('html')->result_array();
				}				
				foreach ($_tmp as $key => $value) {
					$_category_data[] = $value['id'];
				}
			}

			$o = $this->cidb;

			if(count($_category_data) > 0){
				if($common_plural_category == 0){ //2020-10-15 單選分類的情境 預設適用 class_id
					$o = $o->where_in('class_id',$_category_data);
				}else{ //複選的情境 ... 等有緣人來測試驗證	 預設適用 class_ids
					$o = $o->group_start();
					foreach ($_category_data as $key => $value) {
						if($key==0){
							$o = $o->like('class_ids', ','.$value.',');
						}else{
							$o = $o->or_like('class_ids', ','.$value.',');
						}						
					}					
					$o = $o->group_end();
				}				
			}

			// 通用
			// 以下條件三選一(3/4)

			// 1. 單純一個條件的時候
			$o = $o->like('topic', $_GET[$_search_field]);

			// 2. 多個條件的時候，請換成這個 for ci2.0
			// $o = $o->where("is_enable = 1 and type='".$_router_method."' and ml_key='".$this->data['ml_key']."' and (topic LIKE '%".$_GET[$_search_field]."%' or XXX LIKE '%".$_GET[$_search_field]."%')");

			// 3. ci3的寫法
			// $o = $o->group_start()->like('topic', $_GET[$_search_field])->or_like('XXX', $_GET[$_search_field])->group_end();

			if($common_date_range == '1'){
				$o = $o->where('(date1 <= NOW() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= NOW() OR date2 IS NULL OR date2 = "0000-00-00")');
			}

			$o = $o->where('is_enable',1)->where('type',$_router_method)->where('ml_key',$this->data['ml_key']);

			if($common_date_sort == 1){
				$o = $o->order_by('start_date','desc');
			} else {
				$o = $o->order_by('topic','asc');
			}

			$rows = $o->get('html', $limit_count, ($pagew-1) * $limit_count)->result_array();
		} else {

			//2020-10-15 加入判斷有關連的資料是否開啟 ，這邊是計算資料筆數的地方，下面還有喔
			if($common_is_category == 1 && $common_category == 0){
				if($common_other_category == ''){
					$_tmp = $this->cidb->select('id')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get($_router_method.'type')->result_array();
				}else{
					$_tmp = $this->cidb->select('id')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->get($common_other_category)->result_array();
				}				
				foreach ($_tmp as $key => $value) {
					$_category_data[] = $value['id'];
				}
			}
			
			$o = $this->cidb;			

			// 獨立
			// 以下條件四選一(4/4)

			// 1. 單純一個條件的時候
			// $o = $o->like('name', $_GET[$_search_field]);

			// 2. 多個條件的時候，請換成這個 for ci2.0
			// $o = $o->where("(name LIKE '%".$_GET[$_search_field]."%' or XXX LIKE '%".$_GET[$_search_field]."%')");

			// 3. 改成ci3.0的寫法，並加入經理要求的精準搜尋品號 by lota 2019-04-29
			//    如果沒有item_name的欄位，就會單純的使用一個條件來搜尋 2020-06-20
			$rowg = $this->cidb->get($_router_method)->row_array();
			if($rowg and isset($rowg['item_name'])){
				$o = $o->group_start()->like('name', $_GET[$_search_field])->or_like('item_name', $_GET[$_search_field])->group_end();
			} else {
				$o = $o->group_start();
				$o = $o->like('name', $_GET[$_search_field]);  //要增加項目的話，請加在這行下面
				$o = $o->group_end();
			}

			//這邊是計算資料筆數的地方，下面還有喔
			if(count($_category_data) > 0){
				if($common_plural_category == 0){ //2020-10-15 單選分類的情境 預設適用 class_id
					$o = $o->where_in('class_id',$_category_data);
				}else{ //複選的情境 ... 等有緣人來測試驗證	 預設適用 class_ids
					$o = $o->group_start();
					foreach ($_category_data as $key => $value) {
						if($key==0){
							$o = $o->like('class_ids', ','.$value.',');
						}else{
							$o = $o->or_like('class_ids', ','.$value.',');
						}						
					}					
					$o = $o->group_end();
				}				
			}

			if($common_date_range == '1'){
				$o = $o->where('(date1 <= NOW() OR date1 IS NULL OR date1 = "0000-00-00") AND (date2 >= NOW() OR date2 IS NULL OR date2 = "0000-00-00")');
			}

			$o = $o->where('is_enable',1)->where('ml_key',$this->data['ml_key']);

			if($common_date_sort == 1){
				$o = $o->order_by('start_date','desc');
			} else {
				$o = $o->order_by('name','asc');
			}

			$rows = $o->get($_router_method, $limit_count, ($pagew-1) * $limit_count)->result_array();

			// 4. 同時搜尋一個以上的資料表(盟鑫) #38433
			// $sql = 'SELECT id,name,class_id,pic1,field_data,field_tmp,"product" FROM product WHERE name LIKE "%'.$_GET[$_search_field].'%" OR detail LIKE "%'.$_GET[$_search_field].'%" ';
			// $sql .= ' UNION SELECT id,name,class_id,pic1,field_data,field_tmp,"applications" FROM applications WHERE name LIKE "%'.$_GET[$_search_field].'%" OR detail LIKE "%'.$_GET[$_search_field].'%" ';
			// $sql .= ' ORDER BY name ';
			// $sql .= ' LIMIT '.$limit_count.' OFFSET '.($pagew-1) * $limit_count.' ';
			// $rows = $this->cidb->query($sql)->result_array();
		}
		
		// 處理資料：客製SQL語法範例
		// $sql = 'select * from html where topic like "%'.$_GET[$_search_field].'%" and is_enable=1 and ml_key="'.$this->data['ml_key'].'" and (type="protector" or type="prosthetics" or type="spine") limit '.($pagew-1) * $limit_count.', '.$limit_count;
		// $rows = $this->cidb->query($sql)->result_array();

		/*
		 * 應該有很多功能都差不多，只有這裡不一樣而以
		 * 這裡放置在最下面，為了要給功能範本，能夠有更大的優先權能夠處理以及覆寫 2018-06-15
		 */
		if(file_exists(_BASEPATH.'/../source/'.$_router_method.'/search.php') or (isset($this) and isset($this->data['need_flattened']) and $this->data['need_flattened'] === true)){
			include _BASEPATH.'/../source/'.$_router_method.'/search.php';
		}

		// 作法1：把前一個區塊的內容，取代成這裡的內容
		$tmp2 = explode('-', $ID);
		if($tmp2[count($tmp2)-1] - 1 >= 0){ // 如果它前面有東西的話…
			$last = $tmp2[count($tmp2)-1] - 1;
			$tmp2[count($tmp2)-1] = $last;
			$prev_id = implode('-', $tmp2);
			$data[$prev_id] = $rows;
		}

		// 作法2：後台 / datasource / 手動複製貼上程式碼 ，取代data的資料流，通常是A方案使用，底下只是範例
		// if($this->data['router_method'] == 'download_2'){
		// 	$this->data['v3_source_system/general_item,brochure_2196'] = $rows;
		// 	$data['v3_source_system/general_item,brochure_2196'] = $rows;
		// }

		// 作法3：後台 / datasource / 好記的名子(打勾後啟用) ，如果A方案有啟用，有搜尋到的話，那就取代_general_item的資料流
		if(isset($this->data['_general_item'])){
			$this->data['_general_item'] = $rows;
		}

		// SEO
		$data['head_title'] = str_replace($this->data['func_name'].' | ', $_GET[$_search_field].' | ', $data['head_title']); // 預設值

	} // 是不是有啟用資料表功能
}
