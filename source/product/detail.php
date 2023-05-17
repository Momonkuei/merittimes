<?php


if($DATA_SINGLE == true and $DATA_MULTI == false){
	
	// 目前沒有

} elseif($DATA_SINGLE == false and $DATA_MULTI == true){
	
	// 目前沒有

} elseif($DATA_SINGLE == true and $DATA_MULTI == true){

	// 多筆、多筆、單筆、多筆
	//if(count($DATA_SINGLE_MULTI) == 4 and $DATA_SINGLE_MULTI[0] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[1] == 'DATA_MULTI' and $DATA_SINGLE_MULTI[2] == 'DATA_SINGLE' and $DATA_SINGLE_MULTI[3] == 'DATA_MULTI'){

	$layoutv3_condition = 'single|multi|multi|single';
	include _BASEPATH.'/../layoutv3/multi_source_check.php';
	if($layoutv3_condition === true){

		$router_method = str_replace('detail','',$this->data['router_method']);

		// 單筆
		$tmp = $this->db->createCommand()->from($router_method)->where('is_enable=1 and id=:id',array(':id'=>$_GET['id']))->queryRow();
		$tmp['name2'] = $tmp['detail']; // ckeditor_js 預設編輯器輸出
		$tmp['content1'] = $tmp['field_data'];
		$tmp['content2'] = $tmp['field_tmp'];

		//讀取上一層的banner #26966 by lota (這邊要給jerry看的)
		// $contentx = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/source/home/banner.php');		
		// $contentx = str_replace('<'.'?'.'php', '', $contentx);
		// $router_method_tmp = $this->data['router_method'];
		// $id_tmp = $_GET['id'];
		// $this->data['router_method'] = str_replace('detail','',$this->data['router_method']);
		// $_GET['id'] = $tmp['class_id'];
		// eval($contentx);
		// $data['0-0_0-0_0-1-0_0-4'] = $data['0-0_0-0_0-1-1-1-0-0'];
		// $this->data['router_method'] = $router_method_tmp;
		// $_GET['id'] = $id_tmp;
		// $tmp = $date_tmp;

		// inquiry
		$tmp['inquiry']['primary_key'] = $router_method.'___'.$tmp['id'];
		$tmp['inquiry']['id'] = 'productinquiry';

		$admin_field_router_class = $router_method;
		$admin_field_section_id = 1;
		include _BASEPATH.'/../source/system/admin_field_get.php';

		if(isset($admin_field['detail']) and isset($admin_field['detail']['type'])){
			if($admin_field['detail']['type'] == 'textarea'){
				$tmp['name2'] = nl2br($tmp['detail']); // ckeditor_js 預設編輯器輸出
			}
		}

		// SEO
		$data['head_title'] = str_replace($this->data['func_name'].' | ', $tmp['name'].' | ', $data['head_title']); // 預設值

		//$row = $this->db->createCommand()->from('seo')->where('seo_ml_key=:ml_key and seo_type=:type and seo_item_id='.$id,array('ml_key'=>$this->data['ml_key'],':type'=>$_router_method))->queryRow();
		//if($row and isset($row['id'])){
		//	if($row['seo_title'] != ''){
		//		$data['head_title'] = $row['seo_title'];
		//	}
		//	if($row['seo_meta_keyword'] != ''){
		//		$this->data['seo_keywords'] = $row['seo_meta_keyword'];
		//	}
		//	if($row['seo_meta_description'] != ''){
		//		$this->data['seo_description'] = $row['seo_meta_description'];
		//	}
		//}

		//$data[$ID.'_2'] = $tmp;

		if(isset($layoutv3_struct_map_keyname['v3/product/tabs_1'])){
			$data[$layoutv3_struct_map_keyname['v3/product/tabs_1'][0]] = $tmp;
		}

		$path = 'webroot._i.assets.members.'.$router_method.$tmp['id'].'.member';
		$tmp2 = array();
		if(is_dir(Yii::getPathOfAlias($path))){
			$tmp2 = $this->_getFiles(Yii::getPathOfAlias($path));
			sort($tmp2);//lota 加入排序
		}

		// 因為多圖，是用第一張的代表圖，和多張上傳，所合併起來的
		$rows = array();
		$rows[] = array(
			'pic' => '_i/assets/upload/'.$router_method.'/'.$tmp['pic1'],
			// #21242
			'name' => $tmp['name'],
		);

		// 使用代表圖的縮圖，目前的先寫好的規則，是使用第一種抓到的尺寸
		// 1000x652_d8657d5f7def6aadee8a71664f9084b2.jpg
		$path = 'webroot._i.assets.thumb.'.$router_method;
		$ggg2 = array();
		if(is_dir(Yii::getPathOfAlias($path))){
			$ggg2 = $this->_getFiles(Yii::getPathOfAlias($path));
		}
		if($ggg2){
			foreach($ggg2 as $k => $v){
				$ggg3 = explode('_',$v);
				if($tmp['pic1'] == $ggg3[count($ggg3)-1]){
					$rows[0]['pic'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$v);
					break;
				}
			}
		}

		// 多張圖
		if($tmp2){
			foreach($tmp2 as $k => $v){
				$tmp2 = explode('/', $v);
				$tmp3 = $tmp2[count($tmp2)-1];
				$tmp4s = explode('.', $tmp3);
				$tmp5 = $tmp3; // 沒有副檔名，當做圖片名稱
				if($tmp4s and count($tmp4s) > 0){
					unset($tmp4s[count($tmp4s)-1]); // 只刪掉逗點最右邊，因為怕有1個以上的小數點
					$tmp5 = implode('.', $tmp4s);
				}
				// 為了要符合前台版型的規範
				$rows[] = array(
					'pic' => '_i/assets/members/'.$router_method.$tmp['id'].'/member/'.$tmp3,
					// #21242
					'name' => $tmp5,
				);
			}
		}

		// #21461
		$rows_big = array();
		$rows_small = array();
		if($rows and count($rows) > 0){
			foreach($rows as $k => $v){
				$v_source = $v;

				// 大圖
				$v = $v_source;
				$ggg = str_replace(
					'assets/members/'.$router_method.$tmp['id'].'/member/',
					// 抽換掉一層資料夾名稱，改成使用的尺寸別名
					'assets/members2/'.$router_method.$tmp['id'].'/big/',
					$v['pic']
				);
				if(file_exists($ggg)){
					$v['pic'] = $ggg;
				}
				$rows_big[] = $v;

				// 小圖
				$v = $v_source;
				$ggg = str_replace(
					'assets/members/'.$router_method.$tmp['id'].'/member/',
					// 抽換掉一層資料夾名稱，改成使用的尺寸別名
					'assets/members2/'.$router_method.$tmp['id'].'/small/',
					$v['pic']
				);
				if(file_exists($ggg)){
					$v['pic'] = $ggg;
				}
				$rows_small[] = $v;
			}
		}

		$data[$ID.'_0'] = $tmp;
		$data[$ID.'_1'] = $rows_big;
		$data[$ID.'_2'] = $rows_small;
		$data[$ID.'_3'] = $tmp;

		// // 相關商品
		// $tmps = $this->db->createCommand()->from(str_replace('detail','',$this->data['router_method']))->where('is_enable=1 and class_id=:id',array(':id'=>$tmp['class_id']))->order('sort_id')->limit(4)->queryAll();
		// if($tmps){
		// 	foreach($tmps as $k => $v){
		// 		// 為了要符合前台版型的規範
		// 		$tmps[$k]['url1'] = $tmps[$k]['url2'] = $this->data['router_method'].'.php?id='.$v['id'];
		// 		$tmps[$k]['pic'] = '_i/assets/upload/'.str_replace('detail','',$this->data['router_method']).'/'.$v['pic1'];
		// 	}
		// }
		// $data[$ID.'_3'] = $tmps;

	} // layoutv3_condition


}
