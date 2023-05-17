<?php

$prefix = 'shop';

if($items2 and !empty($items2)){
	foreach($items2 as $a => $item){
		if(isset($item['specs']) and !empty($item['specs'])){
			unset($items2[$a]);
		} else {

			if(isset($admin_field_shop['detail']) and isset($admin_field_shop['detail']['type'])){
				if($admin_field_shop['detail']['type'] == 'textarea'){
					$item['detail'] = nl2br($item['detail']); // ckeditor_js 預設編輯器輸出
				}
			}

			// 2020-05-14
			// demo_shop2的寫法
			if(1){
				$rows = $this->cidb->where('is_enable',1)->where('data_id',$item['id'])->get('shopspec')->result_array();
				if($rows){
					foreach($rows as $k => $v){
						$v['value'] = $v['id'];

						$v['name2'] = $v['name'];
						$v['name'] = $v['spec']; // 2020-05-14 李哥下午說，只顯示規格，不顯示價格欄位

						unset($v['disabled']);

						if($v['inventory'] <= 0){
							$v['disabled'] = '';
						}

						//2020/08/19 如果金額為0，則不給加入購物車
						if($v['price2'] <= 0){
							$v['disabled'] = '';
						}

						if(isset($item['specid']) and $v['id'] == $item['specid']){
							$v['selected'] = '';
						}

						$rows[$k] = $v;
					}

					// 不是每一個規格表都是需要這樣子，應該只有下拉的才需要
					$rows2 = array();
					//$rows2[] = array(
					//	'value' => '',
					//	'name' => '請選擇',
					//	'pic' => '',
					//);
					foreach($rows as $k => $v){
						$rows2[] = $v;
					}
					$rows = $rows2;
				}

				// 合併就是只會挑一種規格的區塊來顯示，請修改底下的路徑，舉例：shop/spec2(就是顏色加標題的Radio，然後顏色是非必填)
				// $data2[$layoutv3_struct_map_keyname['v3/shop/spec1'][0]]['multi'][] = $rows;
				// $data2[$layoutv3_struct_map_keyname['v3/shop/spec1'][0]]['single'][] = array(
				// 	'topic' => '規格',
				// 	'name' => 'specid',
				// 	'itemid' => 999, // 應該不用帶$item['id']吧我猜
				// );

				$item['multi'][] = $rows;
				$item['single'][] = array(
					'topic' => '規格',
					//'name' => 'attr'.($k+1),
				 	'name' => 'specid',
					'itemid' => 999, // 應該不用帶$item['id']吧我猜
				);
				$items2[$a] = $item;
			}

			if(0){
				$search_data = array( // 複制來的
					':type' => $prefix.'spec',
					':ml_key' => $this->data['ml_key'],
				);
				$row_tmp = $this->db->createCommand()->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key',$search_data)->queryAll();
				$attrs_tmp = array();
				if($row_tmp){
					foreach($row_tmp as $k => $v){
						for($x=0;$x<=3;$x++){
							if($v['other'.($x+1)] != ''){
								$attrs_tmp[$x][$v['other'.($x+1)]] = $v['pic1'];
							}
						}
					}
					foreach($attrs_tmp as $k => $v){
						$tmps = array();
						foreach($v as $kk => $vv){
							$tmps[] = array(
								'value' => $kk,
								'name' => $kk,
								'pic' => '_i/assets/upload/'.$prefix.'spec/'.$vv,
							);
						}
						foreach($tmps as $kk => $vv){
							if($vv['value'] == '') continue;
							$has_inventory = false;
							$search_data = array(
								':type' => $prefix.'spec',
								':ml_key' => $this->data['ml_key'],
								':q' => $vv['value'],
							);
							$row_tmp = $this->db->createCommand()->from('html')->where('is_enable =1 and type=:type and ml_key=:ml_key and (other1=:q or other2=:q or other3=:q or other4=:q)',$search_data)->queryAll();
							if($row_tmp){
								foreach($row_tmp as $kkk => $vvv){
									$row = $this->db->createCommand()->from($prefix.'spec')->where('is_enable =1 and data_id=:id and id=:specid', array(':id'=>$item['id'],':specid'=>$vvv['id']))->queryRow();
									if(isset($row['inventory']) and $row['inventory'] > 0){
										$has_inventory = true;
										break;
									}
								}
							}
							if(!$has_inventory){
								$tmps[$kk]['disabled'] = '';
							}
						}

						// 請手動透過更換view/shop/spec*的檔案名稱來達成，因為1~3代表不同意義的區塊 2017-06-23
						// 請參照靜態頁面
						// http://192.168.0.200/winnie/RWDProject/ProjectC/Web/shop.php?type=3
						$item['multi'][] = $tmps;
						$item['single'][] = array(
							'topic' => $admin_field['other'.($k+1)]['other']['html_end'], // 材質
							'name' => 'attr'.($k+1),
							'itemid' => $item['id'], // 為了讓每一個規格屬性(1~4)都能夠直接取用到產品的編號
						);
						$items2[$a] = $item;
					}
				} // 複製來的
			}
		}
	}
}

// 會這樣子寫動態的判斷是否要assign，是因為同時有一般的和購物訂單修改的一起使用這一支的關係
$tmps = explode('/',__FILE__);
//因應window主機的處理 2020/07/29
if(!isset($tmps[1])){
	$tmps = explode("\\",__FILE__);
}
$tmp2 = str_replace('.php','',$tmps[count($tmps)-1]);
$assign = true;
eval('if(isset($'.$tmp2.'_disable_assign) and $'.$tmp2.'_disable_assign === true) $assign = false;');

if($assign and isset($layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/add_cart_panel'][0])){
	$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/widget/add_cart_panel'][0]] = $items2;
	$data[$layoutv3_struct_map_keyname[LAYOUTV3_THEME_NAME.'/end/shop'][0]] = $items2;
}
