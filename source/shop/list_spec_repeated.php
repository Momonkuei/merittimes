<?php

// 使用方式
// $search_data = array( // 複制來的
// 	':type' => $prefix.'spec',
// 	':ml_key' => $this->data['ml_key']
// );
// // 取得規格列表
// $row_tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',$search_data)->queryAll();
// $attrs_tmp = array();
// if($row_tmp){
//		foreach($row_tmp as $k => $v){
//		   $v3_num = 0; // filter1區塊在struct_map_keyname的位置(從0開始)
//		   $db_num = 1; // 欄位存放在資料表的位置
//		   $pic = true; // 代表要顯示圖片，反之
//		   include 'source/shop/list_spec_repeated.php';
//	    }
// }

if($v['other'.$db_num] != ''){
	if($pic === true and $v['pic1'] != ''){
		$pic = '_i/assets/upload/'.$prefix.'spec/'.$v['pic1'];
	}
	if(isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/filter1'][$v3_num])){
		$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/filter1'][$v3_num]][$v['other'.$db_num]] = array(
			'pic' => $pic,
			'id' => 'other'.$db_num, // 本來應該要放單筆，但為了簡化以及好寫，所以才這樣子做
			'sectionid' => $db_num,
		);
		if(isset($_SESSION['save'][$prefix.'_filter'][$db_num.'___'.$v['other'.$db_num]]['data']) and $_SESSION['save'][$prefix.'_filter'][$db_num.'___'.$v['other'.$db_num]]['data'] != ''){
			$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/shop/filter1'][$v3_num]][$v['other'.$db_num]]['checked'] = '';
		}
	}
}
