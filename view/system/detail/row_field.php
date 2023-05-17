<?php
// 2019-12-09
if($row){
	foreach(array(0,1) as $admin_field_section_id){
		// $admin_field_section_id = 1;
		$admin_field_router_class = $router_method; // 因為admin_field_get的最下面會把admin_field_router_class的變數清掉
		include _BASEPATH.'/../source/system/admin_field_get.php';

		if(!empty($admin_field)){
			foreach($admin_field as $k => $v){
				// 如果後台有，但是前台沒有欄位的話，就跳過這個欄位
				if(!isset($row[$k])){
					continue;
				}
				if(preg_match('/^(ckeditor_js|textarea)$/', $v['type'])){
					$newfieldname = $k.'___nochange';
					if(!isset($row[$newfieldname])){
						$row[$newfieldname] = $row[$k];
					}

					$newfieldname = $k.'___nl2br';
					if(!isset($row[$newfieldname])){
						$row[$newfieldname] = nl2br($row[$k]);
					}

					if($v['type'] == 'textarea'){
						$row[$k] = nl2br($row[$k]);
					}
				} elseif($v['type'] == 'fileuploader'){
					if(isset($v['other']['type']) and $v['other']['type'] != ''){
						//$newfieldname = $k.'___origin'; // 不能取origin的名子，因為會衝到，資料表已經有這個欄位名稱
						$newfieldname = $k.'___nochange';
						if(!isset($row[$newfieldname])){
							$row[$newfieldname] = $row[$k];
						}

						$newfieldname = $k.'___has_path';
						$dir1 = 'upload';
						if($v['other']['type'] == 'document'){
							$dir1 = 'file';
						}

						if(!isset($row[$newfieldname])){
							$row[$newfieldname] = ''; // 不管如何，至少弄個空的出來
							if($row[$k] != ''){
								$row[$newfieldname] = '_i/assets/'.$dir1.'/'.$router_method.'/'.$row[$k];
							}
						}

						/*
						 * 後續的程序，好像會針對picX, fileX的欄位處理，所以這裡不去碰觸，只做一個新的欄位
						 */
					}
				} elseif($v['type'] == 'datepicker'){
					if($row[$k] == '0000-00-00'){
						$row[$k] = '';
					} else {
						$row[$k] = date('Y/m/d', strtotime($row[$k]));
					}

					foreach(array('year'=>'Y','month'=>'M','month2'=>'F','MONTH'=>'m','day'=>'d') as $kk => $vv){
						$newfieldname = $k.'___'.$kk;
						if(!isset($row[$newfieldname])){
							$row[$newfieldname] = ''; // 不管如何，至少弄個空的出來
							if($row[$k] != ''){
								$row[$newfieldname] = date($vv, strtotime($row[$k]));
							}
						}
					}
				}
			}
		}
	}

	// 上面是依照後台欄位，這裡是依照欄位名稱，可能會重覆，反正上面有做過，這裡自然就會略過
	foreach($row as $k => $v){
		if(preg_match('/^(detail|field_data|field_tmp)$/', $k)){
			$newfieldname = $k.'___nochange';
			if(!isset($row[$newfieldname])){
				$row[$newfieldname] = $row[$k];
			}

			$newfieldname = $k.'___nl2br';
			if(!isset($row[$newfieldname])){
				$row[$newfieldname] = nl2br($row[$k]);
			}
		} elseif(preg_match('/^(create_time|update_time|date1|date2|start_date|end_date)$/', $k)){
			// if($row[$k] == '0000-00-00 00:00:00'){
			// 	$row[$k] = '';
			// } else {
			// 	$row[$k] = date('Y/m/d', strtotime($row[$k]));
			// }

			foreach(array('year'=>'Y','month'=>'M','month2'=>'F','MONTH'=>'m','day'=>'d') as $kk => $vv){
				$newfieldname = $k.'___'.$kk;
				if(!isset($row[$newfieldname])){
					$row[$newfieldname] = ''; // 不管如何，至少弄個空的出來
					if($row[$k] != ''){
						$row[$newfieldname] = date($vv, strtotime($row[$k]));
					}
				}
			}
		}
	}
} // if row

// var_dump($row);
?>
