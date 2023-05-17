<?php

/*
 * 2020-08-07
 * 第一個運用這裡的地方：source/menu/sub.php
 *
 * 用來取代以下的寫法：
 * $data[$layoutv3_struct_map_keyname[$view_file][0]]
 *
 * 可以透過指定page_source的方式，來取得資料，或是傳遞資料
 * @page_source_data_param1 例share-general_item
 * @page_source_data_param2 要assign的資料
 * @page_source_data_other 其它參數
 *
 * 如果沒有設定參數2，就代表是要return
 * 有設定參數2，就是要assign
 *
 * 未來可能需要擴充，assign的時候，可以選擇強制、或是沒資料才assign(不強制)
 */

if(!isset($page_source_data_param2)){
	$page_source_data_param2 = null;
}
if(!isset($page_source_data_other)){
	$page_source_data_other = array();
}

$page_source_data_ids = array();
$page_source_data_files = array();
unset($page_source_data_return);//回傳

if(isset($page_source_data_param1) and $page_source_data_param1 != '' and preg_match('/\-/', $page_source_data_param1)){
	$ggg = explode('-', $page_source_data_param1);
	if(isset($page_sources[$ggg[0]]) and isset($page_sources[$ggg[0]][$ggg[1]]) and isset($page_sources[$ggg[0]][$ggg[1]]['file']) and !empty($page_sources[$ggg[0]][$ggg[1]]['file'])){
		//var_dump($page_sources[$ggg[0]][$ggg[1]]['file']);
		foreach($page_sources[$ggg[0]][$ggg[1]]['file'] as $kkk => $vvv8){
			$tmp3 = $vvv8;
			if(preg_match('/(\*|\/)/', $vvv8)){
				// 一個以上的星號或是斜線都會被取代
				$tmp3 = str_replace('/', '\/', $tmp3);
				$tmp3 = str_replace('*', '(.*)', $tmp3);
			}
			$page_source_data_files[] = $tmp3;
		}
		//var_dump($layoutv3_struct_tmp);die;
		//var_dump($files);die;
		// @kkk footer/logo_footer
		// @vvv array('0-1-4-1-0', ... )
		foreach($layoutv3_struct_tmp as $kkk8 => $vvv8){
			// @vvvv file(rule)
			foreach($page_source_data_files as $kkkk9 => $vvvv9){
				if(preg_match('/'.$vvvv9.'/', $kkk8, $matches)){
					//$tmp3 = $vv;
					//unset($tmp3['file']); // 這樣我以後才不會搞混
					foreach($vvv8 as $kkkkkx => $vvvvvx){
						$page_source_data_ids[] = $vvvvvx;
						//$page_source_result[$vvvvv] = $tmp3;
					}
				}
			}
		}
	}

	if(!empty($page_source_data_ids)){
		foreach($page_source_data_ids as $kkk4 => $vvv4){
			if($page_source_data_param2 === null){
				// return
				if(isset($data[$vvv4])){
					$page_source_data_return = $data[$vvv4];
					break;
				}
			} else {
				// assign
				if(isset($page_source_data_other) and !empty($page_source_data_other) and isset($page_source_data_other['assign_force']) and $page_source_data_other['assign_force'] === true){
					$data[$vvv4] = $page_source_data_param2;
				} else {
					//echo $vvv4.'<br />';
					if(!isset($data[$vvv4])){
						$data[$vvv4] = $page_source_data_param2;
					}
				}
			}
		}
	}

	// 結尾要清除的變數
	unset($page_source_data_param1);
	unset($page_source_data_param2);
	unset($page_source_data_other);
	unset($page_source_data_ids);
	unset($page_source_data_files);
}

/* 要跟進的地方
v3/member/customer_address.php
v3/default/promenu2.php
v4/member/member_addressBook.php

source/album/detail2.php
source/album/detail.php
source/album/detail3.php
source/album/type.php
source/album/general_item.php
source/core/pagination.php
source/core/breadcrumb.php
source/core/member.php
source/core/end.php
source/download/type.php
source/faq/type.php
source/favorite/list.php
source/graphics/general_item.php
source/location/type.php
source/member/change_password.php
source/member/order_detail.php
source/member/forget_confirm.php
source/member/login.php
source/member/register_post.php
source/member/center.php
source/member/order_list.php
source/member/forget_post.php
source/menu/bottom.php
source/menu/sub.php
source/news/type.php
source/photo/type.php
source/photo/detail.php
source/product/detail.php
source/product/detail2.php
source/product/general_item.php
source/product/detail3.php
source/product/type.php
source/shop/checkout_include_a_v2.php (V)
source/shop/list_spec_repeated.php
source/shop/list.php (V)
source/shop/detail.php
source/shop/submenu.php
source/shop/checkout.php
source/sitemap/v1.php (V)
source/system/general_item.php (V)
source/top_link_menu/v1.php (V)
source/video/type.php
 */
