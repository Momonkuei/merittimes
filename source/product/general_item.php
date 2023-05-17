<?php

// 2019-12-27 查理說要加上去的，他說不用多國語系，中英文都是Categories
//
// 一般產品，沒有像購物的產品側邊有那麼多的東西，就只有一個
// class_name => eventMenu(第一個區塊在用的), proCatalog(第二個), sideFilter(第三個)
//
// 五綸要把這裡註解掉，相關檔案：
// source/system/general_item.php
// source/menu/sub.php
// source/product/general_item.php
if(isset($layoutv3_struct_map_keyname['v3/shop/block'])){
	$data[$layoutv3_struct_map_keyname['v3/shop/block'][0]] = array('name'=>'Categories','class_name'=>'eventMenu'); 
}

// 2019-08-06
// 因為這個檔案可能被當做第二個分類的功能使用，例如：Application(應用)、五綸
// 其它的部份，就有遇到在改
$class_id_name = 'class_id';

$tmps = $this->db->createCommand()->from($this->data['router_method'].'type')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->queryAll();
// $tmps = $this->db->createCommand()->from('html')->where('is_enable=1 and ml_key=:ml_key and type=:type',array(':type'=>$this->data['router_method'].'type',':ml_key'=>$this->data['ml_key']))->queryAll();
$tmps_tmp = array();
if($tmps){
	foreach($tmps as $k => $v){
		$tmps_tmp[$v['id']]['name'] = $v['name'];
		$tmps_tmp[$v['id']]['detail'] = $v['detail'];
		// $tmps_tmp[$v['id']] = $v['topic'];
	}
}

// 分類簡述 v4版 by lota
if(isset($layoutv3_struct_map_keyname['v4/layout/row']) && isset($_GET['id'])){	
	$data[$layoutv3_struct_map_keyname['v4/layout/row'][0]]['describe'] = nl2br($tmps_tmp[$_GET['id']]['detail']);
}

if($rows and !empty($rows)){
	foreach($rows as $k => $v){

		$v['name2'] = $v['name'];
		$v['img_alt'] = $v['name']; // SEO

		$v['url1'] = $v['url2'] = $v['url'];

		// 移到上層
		// inquiry 2019-10-25
		// $inquiry = array();
		// $inquiry['id'] = $this->data['router_method'].'inquiry';
		// $inquiry['primary_key'] = $this->data['router_method'].'___'.$v['id'].'___0'; // 預設型號為零，這是型號範本，請依需求去客制
		// $inquiry['ml_key'] = $this->data['ml_key'];
		// $inquiry['amount'] = 1;
		// $inquiry['_append'] = '';

		// $tmp2 = array();
		// foreach($inquiry as $kk => $vv){
		// 	$tmp2[] = $kk.'='.$vv;
		// }
		// $inquiry['url'] = 'save.php?'.implode('&', $tmp2);

		if($common_is_category == 1){ // 有分類的情況 #25898 George發現的bug
			if($common_has_listpage == '1' and !isset($_GET['id'])){ // 總覽頁(beta) 群翊
				$v['name'] = '';
				if(isset($tmps_tmp[$v[$class_id_name]])){
					$v['name'] = $tmps_tmp[$v[$class_id_name]]['name'];
				}

				// $v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];

				// 靜態縮圖
				// $v['pic'] = cache3('_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1']);

				// 舊寫法
				// $v['url3'] = 'save.php?id=productinquiry&_append=&amount=1&primary_key='.$this->data['router_method'].'___'.$v['id'].'___0';

				// 新寫法 2019-10-25
				// $v['url3'] = $inquiry['url'];
				// $v['url3'] .=  '&redirect_url='.urlencode($url_prefix.$this->data['router_method'].$url_suffix.'?id='.$_GET['id']); // 點選詢問後回到列表頁 by lota
				// $v['url3'] = ''; // 不需詢問車

				$v['content1'] = $v['field_data'];
				$v['content2'] = $v['field_tmp'];

				// 移到上層
				// SEO
				// unset($_constant);
				// eval('$_constant = '.strtoupper('seo_open').';');
				// if(isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true){
				// 	$v['url1'] = $v['url2'] = $url_prefix.$seos_tmp[$v['id']]['seo_script_name'].'.html';
				// } else {
				// 	$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
				// }
			} elseif(isset($v[$class_id_name]) and isset($tmps_tmp[$v[$class_id_name]])){ // 分項列表
				$v['name'] = $tmps_tmp[$v[$class_id_name]]['name'];

				// $v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];

				// 靜態縮圖
				// $v['pic'] = cache3('_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1']);
				//2021/1/8 改為顯示thumb縮圖 #38363
				$v['pic'] = L::show_thumb_pic($v['pic1'],$this->data['router_method'],'1000x652');

				// 舊寫法
				// $v['url3'] = 'save.php?id=productinquiry&_append=&amount=1&primary_key='.$this->data['router_method'].'___'.$v['id'].'___0';

				// 新寫法 2019-10-25
				// $v['url3'] = $inquiry['url'];
				// $v['url3'] .=  '&redirect_url='.urlencode($url_prefix.$this->data['router_method'].$url_suffix.'?id='.$_GET['id']); // 點選詢問後回到列表頁 by lota
				// $v['url3'] = ''; // 不需詢問車

				$v['content1'] = $v['field_data'];
				$v['content2'] = $v['field_tmp'];

				// 移到上層
				// SEO
				// unset($_constant);
				// eval('$_constant = '.strtoupper('seo_open').';');
				// if(isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true){
				// 	$v['url1'] = $v['url2'] = $url_prefix.$seos_tmp[$v['id']]['seo_script_name'].'.html';
				// } else {
				// 	$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
				// }

			} else { // 分類列表
				/*
				 * 單選的分類列表專用
				 */
				$v['name'] = '';
				// $v['url3'] = '';

				// $v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'type/'.$v['pic1'];

				// 靜態縮圖
				// $v['pic'] = cache3('_i/assets/upload/'.$this->data['router_method'].'type'.'/'.$v['pic1']);

				// 移到上層
				// SEO
				// unset($_constant);
				// eval('$_constant = '.strtoupper('seo_open').';');
				// if(isset($seos_type_tmp[$v['id']]) and $seos_type_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true){
				// 	$v['url1'] = $v['url2'] = $url_prefix.$seos_type_tmp[$v['id']]['seo_script_name'].'.html';
				// } else {
				// 	$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].$url_suffix.'?id='.$v['id'];
				// }

				/*
				 * 2019-04-01
				 * 複選分類的分項專用
				 */
				// $v['name'] = ''; // 複選分類的沒有分類名稱，因為是複選的

				// // 靜態縮圖
				// $v['pic'] = cache3('_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1']);

				// $v['url3'] = 'save.php?id=productinquiry&_append=&amount=1&primary_key='.$this->data['router_method'].'___'.$v['id'].'___0';
				// // $v['url3'] = ''; // 不需詢問車

				// $v['content1'] = $v['field_data'];
				// $v['content2'] = $v['field_tmp'];

				// if(isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != ''){
				// 	$v['url1'] = $v['url2'] = $url_prefix.$seos_tmp[$v['id']]['seo_script_name'].'.html';
				// } else {
				// 	$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
				// }
			}

		} else { // common_is_category == 1

			//2018/1/24 修正如果沒分類的資料直接跳脫 by lota
			if(isset($tmps_tmp[$v[$class_id_name]])){
				$v['name'] = $tmps_tmp[$v[$class_id_name]]['name'];
			}else{
				$v['name'] = '';
			}

			// $v['pic'] = '_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1'];

			// 靜態縮圖
			// $v['pic'] = cache3('_i/assets/upload/'.$this->data['router_method'].'/'.$v['pic1']);

			// 舊寫法
			// $v['url3'] = 'save.php?id=productinquiry&_append=&amount=1&primary_key='.$this->data['router_method'].'___'.$v['id'].'___0';

			// 新寫法 2019-10-25
			// $v['url3'] = $inquiry['url'];
			// $v['url3'] .=  '&redirect_url='.urlencode($url_prefix.$this->data['router_method'].$url_suffix.'?id='.$_GET['id']); // 點選詢問後回到列表頁 by lota
			// $v['url3'] = ''; // 不需詢問車

			$v['content1'] = $v['field_data'];
			$v['content2'] = $v['field_tmp'];

			// 移到上層
			// SEO
			// unset($_constant);
			// eval('$_constant = '.strtoupper('seo_open').';');
			// if(isset($seos_tmp[$v['id']]) and $seos_tmp[$v['id']]['seo_script_name'] != '' and $_constant === true){
			// 	$v['url1'] = $v['url2'] = $url_prefix.$seos_tmp[$v['id']]['seo_script_name'].'.html';
			// } else {
			// 	$v['url1'] = $v['url2'] = $url_prefix.$this->data['router_method'].'detail'.$url_suffix.'?id='.$v['id'];
			// }
		}

		// Debug
		// $db->row['price'] = 9487;
		// $db->row['unit'] = 'NT$';

		// 簡述 v3版
		if(isset($layoutv3_struct_map_keyname['v3/product/layout_sub_pic_left_txt_right'])){
			$v['describe'] = nl2br($v['detail']);
		}		

		$rows[$k] = $v;
	}
}
