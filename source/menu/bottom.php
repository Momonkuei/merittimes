<?php

// 2018-03-05 A方案專用
// 一般區塊 - 資料指定 - 範本
// $view_file = 'v3/header/nav_menu2';
// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
// 	$data[$ID] = $data[$layoutv3_struct_map_keyname[$view_file][0]];
// }

// 2017-02-14 乖哥建議
// $_position = 'bottom';
// include _BASEPATH.'/../source/menu/v2.php';
// $nav_1 = $tmp;
// unset($tmp);
// unset($_position);

// Yii架構(cttdemo)的左側選單在使用的
//if(isset($layoutv3_struct_map_keyname['cttdemo/left/promenu'][0]) and count($nav_1) > 0){
// if(isset($layoutv3_struct_map_keyname['v3/default/promenu_layoutv2'][0]) and count($nav_1) > 0){
// 	$childs = array(); // 本功能的次選單
// 	$null_childs = array(); // 如果沒有次選單的話，要顯示的東西(通常是產品)
// 	foreach($nav_1 as $k => $v){
// 		if(isset($v['child']) and str_replace('detail', '', $this->data['router_method']).'_'.$this->data['ml_key'].'.php' == $v['url1']){
// 			$childs = $v['child'];
// 			// break;
// 		}
// 
// 		if('product_'.$this->data['ml_key'].'.php' == $v['url1']){
// 			$null_childs = $v['child'];
// 		}
// 	}
// 
// 	if(!$childs and $null_childs){
// 		$childs = $null_childs;
// 	}
// 
// 	if($childs){
// 		foreach($childs as $k => $v){
// 			if(!isset($v['pid']) or $v['pid'] > 0){
// 				$v['pid'] = 0;
// 			}
// 			$v['parent_id'] = $v['pid'];
// 			if(!isset($v['id']) and isset($v['url']) and preg_match('/^(.*)\?id\=(\d+)$/', $v['url'], $matches)){
// 				$v['id'] = $matches[2];
// 			}
// 			$childs[$k] = $v;
// 		}
// 		// $data[$layoutv3_struct_map_keyname['cttdemo/left/promenu'][0]] = $childs;
// 		$data[$layoutv3_struct_map_keyname['v3/default/promenu_layoutv2'][0]] = $childs;
// 	}
// }


// 多語版
//$tmp = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and field_tmp like "%,2,%"',array(':type'=>'webmenu',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();


//$conditions[] = ' (login_account LIKE \'%'.$v.'%\' OR name LIKE \'%'.$v.'%\') ';

//if($tmp){
//	foreach($tmp as $k => $v){
//
//		// 多語版
//		$v['name'] = $v['topic'];
//		$v['url'] = $v['url1'];
//
//		$tmp[$k] = $v;
//	}
//}

/*
$nav_2 = array(
	array('name'=>'購物流程','url'=>'javascript:;'),
	array('name'=>'隱私權保護','url'=>'javascript:;'),
	array('name'=>'售後服務','url'=>'javascript:;'),
	array('name'=>'會員需知','url'=>'javascript:;'),
	array('name'=>'常見問題','url'=>'javascript:;'),
	array('name'=>'免責聲明','url'=>'javascript:;'),
);

if(isset($layoutv3_struct_map_keyname['v3/footer/layout1'][0])){
	 $data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type2'][0]] = $nav_1;
}

if(
	isset($layoutv3_struct_map_keyname['v3/footer/layout2'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout7'][0])
){
	 $data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type1'][0]] = $nav_1;
	 $data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type1'][1]] = $nav_2;
}

if(
	isset($layoutv3_struct_map_keyname['v3/footer/layout3'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout4'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout5'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout6'][0])
){
	 $data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type1'][0]] = $nav_1;
	 $data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type2'][0]] = $nav_2;
}
    

// 這裡只是寫一個"sitemap_type3"的範本，實際情況請依照客戶需求做更改或撰寫
if(
	isset($layoutv3_struct_map_keyname['v3/footer/layout2'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout3'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout4'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout5'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout6'][0])
	or isset($layoutv3_struct_map_keyname['v3/footer/layout7'][0])
){
	$rows = $this->db->createCommand()->from('producttype')->where('is_enable=1 and pid=0 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
	if($rows){
	 	foreach($rows as $k => $v){
			if(!isset($layoutv3_struct_map_keyname['v3/footer/sitemap_type3'][$k])) continue;
			//var_dump($layoutv3_struct_map_keyname['v3/footer/sitemap_type3']);die;
			//var_dump($data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type3'][$k]]);die;
			if(!isset($data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type3'][$k]])) $data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type3'][$k]] = array();

	 		$v['url'] = 'product_'.$this->data['ml_key'].'.php?id='.$v['id'];
	 		$data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type3'][$k]][] = $v;
			$rows2 = $this->db->createCommand()->from('producttype')->where('is_enable=1 and ml_key=:ml_key and pid=:id',array(':id'=>$v['id'],':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
			if($rows2 and count($rows2) > 0){
				foreach($rows2 as $kk => $vv){
					$vv['url'] = 'product_'.$this->data['ml_key'].'.php?id='.$vv['id'];
					$data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type3'][$k]][] = $vv;
				}
			} else {
				$rows3 = $this->db->createCommand()->from('product')->where('is_enable=1 and ml_key=:ml_key and class_id=:id',array(':id'=>$v['id'],':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
				if($rows3 and count($rows3) > 0){
					foreach($rows3 as $kk => $vv){
						$vv['url'] = 'productdetail_'.$this->data['ml_key'].'.php?id='.$v['id'];
						$data[$layoutv3_struct_map_keyname['v3/footer/sitemap_type3'][$k]][] = $vv;
					}
				}
			}
		}
	}
}

 */
