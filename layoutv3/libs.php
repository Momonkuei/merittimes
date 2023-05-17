<?php

// https://paulund.co.uk/easily-create-a-table-in-php
function drawTable($rows, $cols, $title = '', $order = array(1,2,3,4,5,6,7,8,9)){
	$result = "<table border='1' cellpadding='4' title='".$title."'>\n"; 

	$num = -1;
	for($tr=1;$tr<=$rows;$tr++){ 

		$result .= "<tr>\n"; 
		for($td=1;$td<=$cols;$td++){ 
			// $result = "<td align='center'>".$tr*$td."</td>\n"; 
			if($order[$num+1] > 0){
				$result .= '<td align="center"><'.'?'.'php echo $'.chr(64 + $order[$num+1]).chr(64 + $order[$num+1]).'?'.'></td>'."\n"; 
			} else {
				$result .= '<td align="center">-</td>'."\n"; 
			}
			$num++;
		} 
		$result .= "</tr>\n"; 
	} 

	$result .= "</table>\n";

	return $result;
}

// 只處理最大9x9的格子
function drawTable2($html, $order = array(1,2,3,4,5,6,7,8,9)){

	$num = 0;
	for($tr=0;$tr<=9;$tr++){ 
		for($td=0;$td<=9;$td++){ 
			$value = $tr.'-'.$td;
			if(preg_match('/'.$value.'/', $html)){
				if($order[$num] > 0){
					$html = str_replace($value,'<'.'?'.'php echo $'.chr(64 + $order[$num]).chr(64 + $order[$num]).'?'.'>',$html);
				} else {
					$html = str_replace($value,'-',$html);
				}
				$num++;
			}
		} 
	} 

	return $html;
}

// https://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
/*
 * 用法
 * echo str_replace_first('abc', '123', 'abcdef abcdef abcdef'); 
 * outputs '123def abcdef abcdef'
 */
function str_replace_first($from, $to, $content)
{
	$from = '/'.preg_quote($from, '/').'/';
	return preg_replace($from, $to, $content, 1);
}

/*
 * 2020-01-14
 * 查詢群組有幾個洞，資料庫優先
 */
function group_has_hole($groupname, $cidb)
{
	$groupname = str_replace('$', '', $groupname);

	// 預設回應處理失敗
	$return = array(
		'count' => -1, // 洞的數量
		'hole' => -1, // 1:實體, 2:資料庫
	);

	$row2 = $cidb->where('is_enable',1)->where('pid',0)->where('name',$groupname)->get('layoutv3grouptype')->row_array();
	if($row2 and isset($row2['id'])){
		// 看一下虛擬的有幾個洞
		// $rowsgg = $this->db->createCommand()->select('id,name as file,pid')->from('layoutv3grouptype')->where('is_enable=1 ')->order('sort_id')->queryAll();
		$rowsgg = $cidb->select('id,name as file,pid')->where('is_enable',1)->order_by('sort_id')->get('layoutv3grouptype')->result_array();
		$indexedItems = array();

		// index elements by id
		foreach ($rowsgg as $item) {
			if($item['pid'] == 0 and $item['id'] != $row2['id']){
				$item['pid'] = 999888777666;
			}
			$item['hole'] = array();
			$indexedItems[$item['id']] = (object) $item;
		}

		// assign to parent
		$topLevel = array();
		foreach ($indexedItems as $item) {
			if ($item->pid == 0) {
				$topLevel[] = $item;
			} else {
				$indexedItems[$item->pid]->hole[] = $item;
			}
		}
		$treeg = std_class_object_to_array($topLevel);
		$tmp = var_export($treeg,true);
		$tmpsgg = explode("\n",$tmp);
		foreach($tmpsgg as $kgg => $vgg){
			if(preg_match('/\'(pid|id)\'/', $vgg)){
				unset($tmpsgg[$kgg]);
			}
			if(preg_match('/hole/', $vgg) and preg_match('/NULL/', $vgg)){
				unset($tmpsgg[$kgg]);
			}
		}
		$tmpggg = implode("\n",$tmpsgg);
		$countg = substr_count($tmpggg,'// HOLE');
		if($countg > 0){
			$return['count'] = $countg;
			$return['hole'] = 2;
		}
	} else {
		// 看一下實體的有幾個洞
		$file = _BASEPATH.'/../group/'.$groupname.'.php';
		if(file_exists($file)){
			$tmpggg = file_get_contents($file);
			$countg = substr_count($tmpggg,'// HOLE');
			if($countg > 0){
				$return['count'] = $countg;
				$return['hole'] = 1;
			}
		}
	}

	return $return;
}


/*
 * @key
 * 第一層 X => [0]
 * 第二層 X-X => [0][hole][0]
 *
 * 這裡只是先定義遞迴的函式
 * 真正執行是在pre_render的階段才會做
 */
function layoutv3_section_recursive($key, $page, $params = array(), $db = null){
	//global $page;

	//if($key == '0'){
	//	return;
	//}

	// support third party Yii
	// if(defined('LAYOUTV3_IS_RUN_FIRST')){
	// 	eval('$page = '.LAYOUTV3_THIRD_PARTY_YII_PAGE.';');
	// }

	// 把處理好的內容，分別取代洞，最多九個洞
	$map = array(
		'<'.'?'.'php echo $AA?'.'>',
		'<'.'?'.'php echo $BB?'.'>',
		'<'.'?'.'php echo $CC?'.'>',
		'<'.'?'.'php echo $DD?'.'>',
		'<'.'?'.'php echo $EE?'.'>',
		'<'.'?'.'php echo $FF?'.'>',
		'<'.'?'.'php echo $GG?'.'>',
		'<'.'?'.'php echo $HH?'.'>',
		'<'.'?'.'php echo $II?'.'>',
		'<'.'?'.'php echo $JJ?'.'>',
		'<'.'?'.'php echo $KK?'.'>',
		'<'.'?'.'php echo $LL?'.'>',
		'<'.'?'.'php echo $MM?'.'>',
		'<'.'?'.'php echo $NN?'.'>',
		'<'.'?'.'php echo $OO?'.'>',
		'<'.'?'.'php echo $PP?'.'>',
		'<'.'?'.'php echo $QQ?'.'>',
		'<'.'?'.'php echo $RR?'.'>',
		'<'.'?'.'php echo $SS?'.'>',
		'<'.'?'.'php echo $TT?'.'>',
		'<'.'?'.'php echo $UU?'.'>',
		'<'.'?'.'php echo $VV?'.'>',
		'<'.'?'.'php echo $WW?'.'>',
		'<'.'?'.'php echo $XX?'.'>',
		'<'.'?'.'php echo $YY?'.'>',
		'<'.'?'.'php echo $ZZ?'.'>',
	);

	// 這裡要寫在view裡面的
	$map_killme = array(
		'<'.'?'.'php // AA?'.'>',
		'<'.'?'.'php // BB?'.'>',
		'<'.'?'.'php // CC?'.'>',
		'<'.'?'.'php // DD?'.'>',
		'<'.'?'.'php // EE?'.'>',
		'<'.'?'.'php // FF?'.'>',
		'<'.'?'.'php // GG?'.'>',
		'<'.'?'.'php // HH?'.'>',
		'<'.'?'.'php // II?'.'>',
		'<'.'?'.'php // JJ?'.'>',
		'<'.'?'.'php // KK?'.'>',
		'<'.'?'.'php // LL?'.'>',
		'<'.'?'.'php // MM?'.'>',
		'<'.'?'.'php // NN?'.'>',
		'<'.'?'.'php // OO?'.'>',
		'<'.'?'.'php // PP?'.'>',
		'<'.'?'.'php // QQ?'.'>',
		'<'.'?'.'php // RR?'.'>',
		'<'.'?'.'php // SS?'.'>',
		'<'.'?'.'php // TT?'.'>',
		'<'.'?'.'php // UU?'.'>',
		'<'.'?'.'php // VV?'.'>',
		'<'.'?'.'php // WW?'.'>',
		'<'.'?'.'php // XX?'.'>',
		'<'.'?'.'php // YY?'.'>',
		'<'.'?'.'php // ZZ?'.'>',
	);

	// CONNECT-A
	// 第一次遇到，會產生一個變數寫死進去程式碼
	// 第二次遇到，會寫死進去程式碼
	$map_connect = array(
		'GGGAAA', // 因為我後面的寫法是從1開始
		'${CONNECT_A}',
		'${CONNECT_B}',
		'${CONNECT_C}',
		'${CONNECT_D}',
		'${CONNECT_E}',
		'${CONNECT_F}',
		'${CONNECT_G}',
		'${CONNECT_H}',
		'${CONNECT_I}',
		'${CONNECT_J}',
		'${CONNECT_K}',
		'${CONNECT_L}',
		'${CONNECT_M}',
		'${CONNECT_N}',
		'${CONNECT_O}',
		'${CONNECT_P}',
		'${CONNECT_Q}',
		'${CONNECT_R}',
		'${CONNECT_S}',
		'${CONNECT_T}',
		'${CONNECT_U}',
		'${CONNECT_V}',
		'${CONNECT_W}',
		'${CONNECT_X}',
		'${CONNECT_Y}',
		'${CONNECT_Z}',
	);

	$tmp = explode('-', $key);
	$node_string = '[\''.implode("']['hole']['",$tmp).'\']';
	$run = '$node = $page'.$node_string.';';
	eval($run);

	if(!isset($node['type'])){
		$node['type'] = 'section';
	}

	// 例如：group
	if(!isset($node['file'])){
		$node['file'] = '';
		$node['type'] = 'group';
	}

	// 為了支援DEMO用的，後台輔助程式
	if($node['file'] == '-group'){
		$node['file'] = '';
		$node['type'] = 'group';
	}

	// 為了支援結構性的群組
	if(preg_match('/^\$(.*)$/', $node['file'])){
		return;
	}

		// 把編號填進去，讓HTML和程式資料脫勾的情況能夠順利結合
	$comment = $node['file'];
	if($comment == ''){
		$comment = '-'.$node['type'];
	}

	// 這行除了實際ID有在運作外，同時也讓pre_render去分析版型
	$current = "\n".'<'.'?'.'php $ID = \''.$key.'\' // '.$comment.'?'.'>'."\n";

	// 如果遇到一個區塊，上面有hole，而下面有內容，這時下面內容，會抓到hole裡面的ID，但這是不對的
	// 這裡面不能加註解，不然會被pre_render所解譯
	$fix_id_persistent = "\n".'<'.'?'.'php $ID = \''.$key.'\'?'.'>'."\n";

	// 2019-12-02
	// source/system/cidb.php
	if(preg_match('/___/', $node['file'])){
		$tmps1 = explode('___', $node['file']);
		$new_file = $tmps1[0];
		$node['file'] = 'system/'.$new_file;
		unset($tmps1[0]);
		if(!empty($tmps1)){
			foreach($tmps1 as $k => $v){
				$node['params'][$new_file.'_'.$k] = $v;
			}
		}

	}

	if(isset($node['params']) and !empty($node['params'])){
		$fix_id_persistent .= "\n".'<'.'?'.'php $_params_='.var_export($node['params'],true).';'.'?'.'>'."\n";
	}

	// 2020-08-17
	if(!isset($_SESSION['layoutv3_struct_files'])){
		$_SESSION['layoutv3_struct_files'] = array();
	}
	if(isset($node['file']) and $node['file'] != ''){
		$_SESSION['layoutv3_struct_files'][] = $node['file'];
	}

	// 這個是測試 2017-11-28
	// 應該有三種情況：區塊(有洞或沒有洞)、群組(有洞或沒有洞)、container
	// $point = '';
	// if($node['file'] != ''){
	// 	$point = '<a href="#">'.$node['file'].'</a>';
	// }

	// section本身有layout，所以必需要做ABCD的區塊取代
	$check = '';

	if($node['type'] == 'section'){

		// 2018-03-12 dynamic_的這個動態區塊，$this->data['layoutv3_dynamic']的部份，程式碼要放到post裡面，這裡才能正常的執行
		if(preg_match('/dynamic_/', $node['file']) and isset($params['layoutv3_dynamic'][$node['file']])){ // 試著撰寫動態區塊 2017-06-14
			$check = $params['layoutv3_dynamic'][$node['file']];
		} else {
			// 先準備好路徑
			if(isset($params['ml_key']) and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/'.$params['ml_key'].'/'.$node['file'].'.php')){
				$tmpg = _BASEPATH.'/../'.LAYOUTV3_PATH.'view/'.$params['ml_key'].'/'.$node['file'].'.php';
			} else {
				$tmpg = _BASEPATH.'/../'.LAYOUTV3_PATH.'view/'.$node['file'].'.php';
			}

			if(preg_match('/^\%(.*)$/', $node['file'], $matches)){
				if(isset($params['%view'][$matches[1].'_'.$params['ml_key']])){
					$check = $params['%view'][$matches[1].'_'.$params['ml_key']];
				}
			// } elseif(isset($node['params']['fieldhole_0']) and $db and isset($node['id']) and $node['id'] > 0){ // 2019-12-24
			// 	$tmpga = $tmpg1 = file_get_contents($tmpg);

			// 	// 先看一下有幾個欄位要處理
			// 	$y=0;
			// 	for($x=0;$x<=15;$x++){ // 2019-12-24 李哥說15
			// 		$tmpgb = str_replace_first('_____','xxggxx',$tmpga);
			// 		if($tmpgb != $tmpga){
			// 			$y++;
			// 			$tmpga = $tmpgb;
			// 		}
			// 	}

			// 	// if($node['id'] > (999999+1) and isset($node['params']) and isset($node['params']['cidb_3']) and preg_match('/^userblockv4(.*)$/',$node['params']['cidb_3']) ){
			// 	// 	var_dump($node);
			// 	// }

			// 	if($y > 0){
			// 		$rows = $db->where('is_enable','1')->where('class_id',$node['id'])->order_by('sort_id','asc')->get('layoutv3field')->result_array();

			// 		// 數量不一樣就刪，這個邏輯怪怪的，先刪掉
			// 		// $count = count($rows);
			// 		// if($y != $count){
			// 		// 	$rows = array();
			// 		// }

			// 		// 把相對應的欄位都勾掉，就可以觸發重載
			// 		if(empty($rows)){
			// 			$db->delete('layoutv3field', array('class_id' => $node['id']));
			// 			// echo $db->affected_rows();

			// 			// 把資料建回去，預設是對應該一個我預先建好的空欄位的名稱
			// 			$rows = array();
			// 			for($x=1;$x<=$y;$x++){
			// 				$save = array('name'=>'__','is_enable'=>1,'class_id'=>$node['id'],'sort_id'=>$x,'create_time'=>date('Y-m-d H:i:s'));
			// 				$db->insert('layoutv3field', $save); 
			// 				// $id = $db->insert_id();
			// 				// echo $db->affected_rows();
			// 				$rows[] = $save;
			// 			}
			// 		}

			// 		// 逐一處理和取代欄位
			// 		for($x=1;$x<=$y;$x++){
			// 			$newfield = '<'.'?'.'php echo $v[\''.$rows[$x-1]['name'].'\']?'.'>'; // 0: 預設是多筆 $v['XXX']
			// 			if(isset($node['params']['fieldhole_1']) and $node['params']['fieldhole_1'] == '1'){ // 1: V1第二版 {/XXX/}
			// 				$newfield = '{/'.$rows[$x-1]['name'].'/}';
			// 			} elseif(isset($node['params']['fieldhole_1']) and $node['params']['fieldhole_1'] == '2'){ // 2: 單筆 $data[$ID]['XXX']
			// 				$newfield = '<'.'?'.'php echo $data[$ID][\''.$rows[$x-1]['name'].'\']?'.'>';
			// 			}
			// 			$newfield = str_replace('ggg1_','',$newfield);
			// 			$newfield = str_replace('ggg2_','',$newfield);
			// 			$tmpg1 = str_replace_first('_____',$newfield,$tmpg1);
			// 		}
			// 	}
			// 	$check = $tmpg1;
			} else {
				// 試著撰寫分析區塊的資料程式，讓程式的部份預留變化的空間
				// if(isset($params['ml_key']) and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/'.$params['ml_key'].'/'.$node['file'].'.php')){
				// 	$check = file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/'.$params['ml_key'].'/'.$node['file'].'.php');
				// } else {
				// 	$check = file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/'.$node['file'].'.php');
				// }
				$check = file_get_contents($tmpg);
			}

			if(isset($node['params']['fieldhole_0']) and $db and isset($node['id']) and $node['id'] > 0){ // 2019-12-24
				//$tmpga = $tmpg1 = file_get_contents($tmpg);
				$tmpga = $tmpg1 = $check;

				// 先看一下有幾個欄位要處理
				$y=0;
				for($x=0;$x<=15;$x++){ // 2019-12-24 李哥說15
					$tmpgb = str_replace_first('_____','xxggxx',$tmpga);
					if($tmpgb != $tmpga){
						$y++;
						$tmpga = $tmpgb;
					}
				}

				if($y > 0){
					$rows = $db->where('is_enable','1')->where('class_id',$node['id'])->order_by('sort_id','asc')->get('layoutv3field')->result_array();

					// 數量不一樣就刪，這個邏輯怪怪的，先刪掉
					// $count = count($rows);
					// if($y != $count){
					// 	$rows = array();
					// }

					// 把相對應的欄位都勾掉，就可以觸發重載
					if(empty($rows)){
						$db->delete('layoutv3field', array('class_id' => $node['id']));
						// echo $db->affected_rows();

						$fields = array();
						if($node['id'] > (999999+1) and isset($node['params']) and isset($node['params']['cidb_3']) and preg_match('/^userblockv4(.*)$/',$node['params']['cidb_3']) and preg_match('/^\%(.*)$/', $node['file'], $matchesgg) ){
							$rowaa = $db->where('is_enable',1)->where('ml_key',$_SESSION['web_ml_key'])->where('type','layoutv3view')->where('topic',$matchesgg[1])->get('html')->row_array();
							if(trim($rowaa['detail']) != ''){
								unset($rowaa3);
								$rowaa2 = $rowaa['detail'];
								$rowaa2 = str_replace("\$this->data['def']['updatefield']['sections'][1]['field']",'$rowaa3',$rowaa2);
								@eval($rowaa2);
								if(isset($rowaa3) and is_array($rowaa3)){
									foreach($rowaa3 as $k => $v){
										$fields[] = $k;
									}
								}
							}
						}

						// 把資料建回去，預設是對應該一個我預先建好的空欄位的名稱
						$rows = array();
						if(!empty($fields)){
							foreach($fields as $ccx => $cc){
								$save = array('name'=>$cc,'is_enable'=>1,'class_id'=>$node['id'],'sort_id'=>$ccx+1,'create_time'=>date('Y-m-d H:i:s'));
								$db->insert('layoutv3field', $save); 
								// $id = $db->insert_id();
								// echo $db->affected_rows();
								$rows[] = $save;
							}
						} else {
							for($x=1;$x<=$y;$x++){
								$save = array('name'=>'__','is_enable'=>1,'class_id'=>$node['id'],'sort_id'=>$x,'create_time'=>date('Y-m-d H:i:s'));
								$db->insert('layoutv3field', $save); 
								// $id = $db->insert_id();
								// echo $db->affected_rows();
								$rows[] = $save;
							}
						}
					}

					// 逐一處理和取代欄位
					for($x=1;$x<=$y;$x++){
						$pic_path = '';
						if(preg_match('/^pic(\d+)$/', $rows[$x-1]['name'],$matchesxx) and isset($node['params']['router_method']) ){
							$pic_path = '_i/assets/upload/'.$node['params']['router_method'].'/';
						}

						$newfield = $pic_path.'<'.'?'.'php echo $v[\''.$rows[$x-1]['name'].'\']?'.'>'; // 0: 預設是多筆 $v['XXX']
						if(isset($node['params']['fieldhole_1']) and $node['params']['fieldhole_1'] == '1'){ // 1: V1第二版 {/XXX/}
							$newfield = $pic_path.'{/'.$rows[$x-1]['name'].'/}';
						} elseif(isset($node['params']['fieldhole_1']) and $node['params']['fieldhole_1'] == '2'){ // 2: 單筆 $data[$ID]['XXX']
							$newfield = $pic_path.'<'.'?'.'php echo $data[$ID][\''.$rows[$x-1]['name'].'\']?'.'>';
						}
						
						$newfield = str_replace('ggg1_','',$newfield);
						$newfield = str_replace('ggg2_','',$newfield);
						$tmpg1 = str_replace_first('_____',$newfield,$tmpg1);
					}
				}
				$check = $tmpg1;
			}

		} // dynamic

		// 2020-02-03
		// 動態產生洞的view，而這個view的本身是沒東西的
		if($node['file'] == 'system/holes'){
			if(isset($node['hole']) and !empty($node['hole'])){
				$check = '';
				$_count = count($node['hole']);
				for($x=1;$x<=$_count;$x++){
					// 2020-08-17
					// 動態載入的情況下，在加上條件去判斷
					$show = true;
					if(isset($node['params'][$x.'_exclude']) and $node['params'][$x.'_exclude'] != ''){ // 例如：v4/header/layout3,v4/header/layout7
						//$excludes = explode(',', $node['params'][$x.'_exclude']);
						$excludes = explode('，', $node['params'][$x.'_exclude']); // 2020-10-15 李哥發現的，因為json的半型逗點是有作用的
						foreach($excludes as $v){
							if(in_array($v,$_SESSION['layoutv3_struct_files'])){
								$show = false;
								break;
							}
						}
					} elseif(isset($node['params'][$x.'_constant']) and $node['params'][$x.'_constant'] != ''){ // 例如：shop_open
						unset($_constant);
						// 如果常數不存在的情況，這裡會報錯
						eval('$_constant = '.strtoupper($node['params'][$x.'_constant']).';');
						if($_constant == 0){
							$show = false;
						}
					}

					if($show === false){
						// 把那個洞改成什麼都沒有，並且把它底下的東西都拿掉，file屬性的專屬寫法
						$rung = $run;
						$rung = str_replace('$node = ','',$rung);
						$rung = str_replace(';','',$rung);
						$rung .= "['hole']['".($x-1)."']['file'] = 'system/empty'";
						$rung .= ';';
						eval($rung);

						// 把底下的東西拿掉，可以這樣子做，但是要加上file，就不能這樣做了
						unset($node['hole'][$x-1]['hole']);
					}

					$check .= '<'.'?'.'php echo $__'.'?'.'>'."\n";
				}
			}
		}

		// 2019-12-03
		// 如果有下這些參數，就會做程式碼合併的動作
		if(isset($node['params']['cidb_0']) and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/system/cidb.php')){ 
			$check = file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/system/cidb.php')."\n\n".$check;
		} elseif(isset($node['params']['datasource_0']) and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/system/datasource.php')){
			$check = file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/system/datasource.php')."\n\n".$check;
		} elseif(isset($node['params']['array_range_0']) and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/system/array_range.php')){
			$check = file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'view/system/array_range.php')."\n\n".$check;
		} elseif(isset($node['params']['include_0']) and $node['params']['include_0'] != ''){
			$tmps = explode('，', $node['params']['include_0']);
			foreach($tmps as $k => $v){
				if(trim($v) != '' and file_exists(_BASEPATH.'/../'.LAYOUTV3_PATH.$v)){
					$phpend = '';
					if(isset($node['params']['include_'.($k+1)]) and $node['params']['include_'.($k+1)] == '1'){
						$phpend = '?'.'>';
					}
					$check = file_get_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.$v).$phpend."\n\n".$check;
				}
			}
		}

		// 等一下要做的事，都會用到，先準備好
		$checks = explode("\n", $check);

		// 把php的include，變成標記 2018-05-14 10:45 李哥說可以做
		// 但是別忘了，如果跟實體洞混用，那標記就只是個標記，它是沒有任何作用的
		if($checks and !empty($checks)){
			$repeat = -1; // 如果有連續include，那實際上產出的標記只會有一個
			foreach($checks as $k => $v){
				if(trim($v) == ''){ // 為了要排除兩個include中間，夾著一個空白行
					continue;
				}
				// < ? php include('common/header.php'); ? >
				if(preg_match('/\?php\ include\(\'(.*)\'\);\?\>/', $v, $matches)){
					if($repeat >= 0){ // 有重覆
						$check = str_replace_first('<'.'?'.'php include(\''.$matches[1].'\');?'.'>','',$check);
					} else {
						$checks[$k] = '<'.'?'.'php echo $__?'.'>';
						$check = str_replace_first('<'.'?'.'php include(\''.$matches[1].'\');?'.'>','<'.'?'.'php echo $__?'.'>',$check);
					}
					$repeat = $k;
				} else {
					$repeat = -1;
				}
			}
		}

		// 檢查看看有沒有洞、或者是有沒有標記
		$has_hole = false;
		$has_hole_tag = false;
		if($checks and !empty($checks)){
			foreach($checks as $k => $v){
				if($has_hole === false){
					foreach($map as $kk => $vv){
						// 逐行比對，是否有洞的存在
						if(str_replace($vv,'',$v) != $v){
							$has_hole = true;
							break;
						}
					}
				}
				if($has_hole_tag === false){
					if(str_replace('<'.'?'.'php echo $__'.'?'.'>','',$v) != $v){
						$has_hole_tag = true;
						break;
					}
				}
			}
		}

		// 看有沒使用到"挖洞標記"
		if($has_hole_tag === true){
			if(isset($node['params']['hole_tag']) and trim($node['params']['hole_tag']) != ''){
				$tmp4 = str_split($node['params']['hole_tag']);
				foreach($tmp4 as $k => $v){
					if($v == 0){
						$check = str_replace_first('<'.'?'.'php echo $__?'.'>','',$check);
					} else {
						$check = str_replace_first('<'.'?'.'php echo $__?'.'>','<'.'?'.'php echo $'.chr(64 + $v).chr(64 + $v).'?'.'>',$check);
					}
				}
			}
			// 如果有標記，但是沒有實體洞，那就把標記變成實體洞(照先後順序)，李哥在2018-05-11下午，允許這個功能的開發
			if($has_hole === false){
				if($checks and !empty($checks)){
					$num = 0;
					foreach($checks as $k => $v){
						$check = str_replace_first('<'.'?'.'php echo $__?'.'>',$map[$num],$check);
						$num++;
						if($num >=10){
							break;
						}
					}
				}
			}
		}
		// 如果沒有去定義，那就清空它們
		$check = str_replace('<'.'?'.'php echo $__?'.'>','',$check);

		/*
		 * 2018-05-03 table
		 * 李哥今天下午有允許這個東西的開發
		 */
		if(isset($params['print_table']) and $params['print_table'] === true){
			$checks = explode("\n", $check);
			$holes = array();
			if($checks and !empty($checks)){
				foreach($checks as $k => $v){
					foreach($map as $kk => $vv){
						// 逐行比對，是否有洞的存在，如果有，就照順序放進來
						if(str_replace($vv,'',$v) != $v){
							$holes[] = $kk+1;
						}
					}
				}
			}

			// 檢查洞是否為按照正常順序的區塊，預設是正常順序
			$is_custom_table = false;
			// echo $node['file'].'<br />';
			// var_dump($holes);
			if($holes and !empty($holes)){
				foreach($holes as $k => $v){
					if($v != $k+1){
						$is_custom_table = true;
						break;
					}
				}
			}

			// 依照不同的方式來呈現

			if(!isset($node['hole'])){
				$check = '<span>'.$node['file'].', </span>';
			} else {
				// if($is_custom_table === false){ // 正常順序

					// if($holes and count($holes) > 0){
					// 	$check = drawTable($holes[count($holes)-1],1,$node['file']);
					// } else {
					// 	$check = '<table border="1"><tr><td align="center">'.$node['file'].'</td></tr></table>';
					// }

				// 	$check = drawTable($holes[count($holes)-1],1,$node['file']);
				// } else { // 沒有按照順序

				$holes_sort = $holes;
				if($is_custom_table === true){ // 不是正常順序
					sort($holes_sort);
				}

				$check = '<br />['.$node['file'].']';

				if(isset($node['params']['table_range']) and preg_match('/^(.*)x(.*)$/', $node['params']['table_range'], $matches)){
					if(isset($node['params']['table_range_custom']) and $node['params']['table_range_custom'] != ''){
						$check .= drawTable($matches[1],$matches[2],'',str_split($node['params']['table_range_custom']));
					} else {
						$check .= drawTable($matches[1],$matches[2],'',$holes);
					}
				} elseif(isset($node['table_content']) and trim($node['table_content']) != ''){
					if(isset($node['params']['table_range_custom']) and $node['params']['table_range_custom'] != ''){
						$check .= drawTable2($node['table_content'],str_split($node['params']['table_range_custom']));
					} else {
						$check .= drawTable2($node['table_content']);
					}
				} elseif(isset($node['params']['table_horizontal']) and $node['params']['table_horizontal'] == '1'){
					$check .= drawTable(1,$holes_sort[count($holes)-1],'',$holes); // 橫式
				} else {
					$check .= drawTable($holes_sort[count($holes)-1],1,'',$holes); // 直式(預設)
				}
				$check .= '<br />';

				// }
			}
		} // print_table

		// 為了支援V1的第二版 2017-11-14
		// $check = str_replace('d="ddd', 'd="id:'.$key, $check); // 單筆
		$check = str_replace('ms="mmm', 'ms="id:'.$key, $check); // 多筆
		$check = str_replace('ls="lll', 'ls="id:'.$key, $check); // 多層

		// CONNECT-X 處理程序
		str_replace('{CONNECT_', '', $check, $count);
		if($count > 0){
			if($count % 2 == 0){
				// 偶數，什麼都不用做
			} else {
				$count += 1;
			}
			$count = $count / 2;
			for($i = 1; $i <= $count; $i++){
				// 因為變數第一個字不能是數字
				$rand_variable_name = 'A'.str_replace('-','',str_replace('_','',$key)).time().layoutv3_hash(5);
				$check = str_replace($map_connect[$i], $rand_variable_name, $check);
			} // for
		}

		// 區塊有沒有單筆的程式碼
		if(preg_match('/echo\ \$data\[\$ID\]\[\'/', $check)){
			$current .= "\n".'<'.'?'.'php // '.$key.'|DATA_SINGLE|true?'.'>'."\n";
		}

		// 區塊有沒有多筆的程式碼
		if(preg_match('/foreach/', $check)){
			$current .= "\n".'<'.'?'.'php // '.$key.'|DATA_MULTI|true?'.'>'."\n";
		}

		// 分析區塊各單元的資料結構
		$tmp2 = explode("\n", $check);
		$tmp3 = array(); // 存放等一下要匯出的資料結構
		$i = 0;
		foreach($tmp2 as $k => $v){
			//<!-- // DATA_SINGLE -->
			if(preg_match('/^\<\!\-\-\ \/\/\ (DATA_SINGLE|DATA_MULTI)\ \-\-\>$/', trim($v), $matches)){
				$tmp2[$k] = '<'.'?'.'php $ID = \''.$key.'\'.\'_\'.\''.$i.'\'?'.'>';
				$tmp3[] = $matches[1];
				$i++;
			}
		}
		$check = implode("\n", $tmp2);

		if(!empty($tmp3)){
			$current .= "\n".'<'.'?'.'php // '.$key.'|DATA_SINGLE_MULTI|'.implode('|', $tmp3).'?'.'>'."\n";
		}

		if(isset($node['params']) and !empty($node['params'])){
			$current .= "\n".'<'.'?'.'php $_params_='.var_export($node['params'],true).';'.'?'.'>'."\n";
		}

		$current .= $check;

		// 2018-05-04 檢查總共有幾個洞
		// echo $current;

		$checks = explode("\n", $check);
		$holes = 0;
		if($checks and !empty($checks)){
			foreach($checks as $k => $v){
				foreach($map as $kk => $vv){
					// 逐行比對，是否有洞的存在，如果有，就累加
					if(str_replace($vv,'',$v) != $v){
						$holes++;
					}
				}
			}
		}

		if(isset($node['hole']) and !empty($node['hole'])){

			$ggg = array();
			foreach($node['hole'] as $k => $v){
				$ggg[] = layoutv3_section_recursive($key.'-'.$k, $page, $params, $db);
			}

			// 把編號填進去，讓HTML和程式資料脫勾的情況能夠順利結合
			foreach($ggg as $k => $v){

				$current = str_replace($map[$k],$v.$fix_id_persistent,$current);

				// 偵測空白的洞，然後把上層Tags刪掉
				$tmp = explode("\n", $v);

				foreach($tmp as $kk => $vv){
					if(trim($vv) == ''){
						unset($tmp[$kk]);
					}
				}

				// 這個只支援純一層的Tag
				if(count($tmp) == 3){
					$current = str_replace($map_killme[$k],' <'.'?'.'php // killme?'.'> '.$fix_id_persistent,$current);
				}
				$i++;
			}

		}

		// 2018-05-04 標示在View裡面有挖洞，但是沒放東西的異常情況
		// 2020-02-03 有洞沒內容的時候，其實也不會有$node['hole']的元素，所以補上判斷
		if(isset($node['hole']) and count($node['hole']) < $holes){
			for($x=($holes-count($node['hole']));$x<=$holes;$x++){
				$current = str_replace($map[$x-1],'<span style="display:none">'.$node['file'].' LOSS:'.($holes-count($node['hole'])).' SECTION(s)</span>'.$fix_id_persistent,$current);
			}
		} elseif(!isset($node['hole']) and $holes > 0){ // 2020-02-03
			$current = str_replace($map[0],'<span style="display:none">'.$node['file'].' LOSS:'.$holes.' SECTION(s)</span>'.$fix_id_persistent,$current);
		}


		return $current;

	// 本身Group沒有layout，只有存放一些依續排列的東西
	} elseif($node['type'] == 'group'){

		/*
		 * 2018-05-03 table
		 */
		// $current .= '<table border="1"><tr><td align="center">Container';

		if(isset($node['hole']) and !empty($node['hole'])){
			$ggg = array();
			foreach($node['hole'] as $k => $v){
				$ggg[$k] = layoutv3_section_recursive($key.'-'.$k, $page, $params, $db);
			}
			foreach($ggg as $k => $v){
				// 把編號填進去，讓HTML和程式資料脫勾的情況能夠順利結合
				//$current .= '<'.'?'.'php $ID = \''.$key.'-'.$k.'\'?g>'."\n";
				$current .= $v.$fix_id_persistent;
			}
		}

		/*
		 * 2018-05-03 table
		 */
		// $current .= $node['file'].'</td></tr></table>';

		return $current;
	}

} // layoutv3_section_recursive

// pre_render.php會用到
function layoutv3_group_recursive($page, $db = null){

	/*
	 * 結構群組，預先處理的程式
	 */

	$map = array(
		'// AA',
		'// BB',
		'// CC',
		'// DD',
		'// EE',
		'// FF',
		'// GG',
		'// HH',
		'// II',
		'// JJ',
		'// KK',
		'// LL',
		'// MM',
		'// NN',
		'// OO',
		'// PP',
		'// QQ',
		'// RR',
		'// SS',
		'// TT',
		'// UU',
		'// VV',
		'// WW',
		'// XX',
		'// YY',
		'// ZZ',
	);

	$tmps = explode("\n", var_export($page,true));

	$groups = array();

	// 先逐行把群組結構的關建字找出來
	if($tmps and !empty($tmps)){
		foreach($tmps as $k => $v){
			if(preg_match('/\'\$(.*)\'/', $v, $matches)){
				$groups[] = $matches[1];
			}
		}
	}

	// 然後在把那個關鍵字的結構抓出來處理
	$group_tmp = array();
	$group_result = array();
	if($groups and !empty($groups)){
		foreach($groups as $k => $v){
			$tmp = layoutv3_struct_search($page, 'file', '$'.$v);
			$group_tmp[] = $tmp;
			// 有找到，可能會有一個以上的答案
			if(!empty($tmp)){
				// @vv file基本結構
				foreach($tmp as $kk => $vv){
					$file = _BASEPATH.'/../'.LAYOUTV3_PATH.'group/'.$v.'.php';
					// echo $file."\n";

					$group_struct = array();
					$tmp2 = '';

					unset($result);

					if(file_exists($file)){
						$tmp2 = file_get_contents($file);

						eval('?'.'>'.$tmp2);
						$result = $group_struct;

					} else {
						// 資料庫找找看
						// $rows = $this->db->createCommand()->select('id, name as file, pid as parent_id')->from('layoutv3grouptype')->where('is_enable=1 and ml_key="'.$this->data['ml_key'].'"')->order('sort_id')->queryAll();
						if($db){
							// $rows = $this->db->createCommand()->select('id, name as file, pid as parent_id')->from('layoutv3grouptype')->where('is_enable=1 and ml_key="tw"')->order('sort_id')->queryAll();
							$rows = $db->select('id, table_content, name as file, pid as parent_id, params')->where('is_enable ',1)->order_by('sort_id','asc')->get('layoutv3grouptype')->result_array();
							if($rows and !empty($rows)){
								foreach($rows as $kkk => $vvv){

									if($vvv['parent_id'] == 0 and $vvv['file'] != $v){
										unset($rows[$kkk]);
									} else {
										// 2018-03-12 下午，有跟李哥報告過這個東西(layoutv3 + params)
										$layer_params = $vvv['params'];

										$m_params2 = array();
										if($layer_params != ''){
											$m_params2 = explode(',', $layer_params);
										}
										if($m_params2){
											$m_params2_tmp = array(); // 檢查有沒有重覆的key值
											foreach($m_params2 as $kkkk => $vvvv){
												if(preg_match('/^(.*)\:(.*)$/', $vvvv, $matches)){
													if(!isset($m_params2_tmp[$matches[1]])){
														$m_params2_tmp[$matches[1]] = '';
														$m_params2[$kkkk] = '"'.$matches[1].'":"'.$matches[2].'"';
													} else {
														// 2018-01-30 下午發現的，因為andwhere條件只能下一次
														$m_params2[$kkkk] = '"'.$matches[1].$kkkk.'":"'.$matches[2].'"';
													}
												}
											}
										}

										$m_params = json_decode('{'.implode(',', $m_params2).'}', true);
										$rows[$kkk]['params'] = $m_params;
									}
								}
							}
							$result = buildTree($rows);
							$result = $result[0]['hole'];

						} // db
					}
					//var_dump($result);

					if(!isset($result)){
						continue;
					}

					/*
					 * 2018-03-02新款挖洞方式
					 */
					$ggg = var_export($result,true);
					// 找出要挖洞的地方，並取代成正規的註解
					$tmpsg = explode("\n",$ggg);
					//var_dump($tmpsg);die;
					$map_position = 1;
					foreach($tmpsg as $kkk => $vvv){
						/* 把符合條件的，上面幾行，和下面兩行，都變成註解，也就是挖洞
						 * 這個是資料表輸出的結構，請注意看，多了兩個欄位
						 1 => 
						 array (
						   'id' => '5',
						   'file' => '// AA',
						   'parent_id' => '3',
						   'params' => '',
						 ),
						*/
						if(preg_match('/\'file\' \=\>\ \'\/\/ HOLE\'\,/', $vvv)){
							if(preg_match('/parent_id/', $tmpsg[$kkk+1])){ // 先確認現在是標準layoutv3結構，還是資料表輸出的結構，因為資料表輸出的會多了三個欄位，那要處理掉
								$tmpsg[$kkk-3] = ''; // key
								$tmpsg[$kkk-2] = ''; // array( and start
								$tmpsg[$kkk-1] = ''; // ID
								$tmpsg[$kkk] = '// '.chr(64+$map_position).chr(64+$map_position);
								$tmpsg[$kkk+1] = ''; // PARENT_ID
								$tmpsg[$kkk+2] = ''; // PARAMS1 'params' => 
								$tmpsg[$kkk+3] = ''; // PARAMS2 array(
								$tmpsg[$kkk+4] = ''; // PARAMS3 ),
								$tmpsg[$kkk+5] = ''; // end
							} else {
								$tmpsg[$kkk-2] = ''; // key
								$tmpsg[$kkk-1] = ''; // array( and start
								$tmpsg[$kkk] = '// '.chr(64+$map_position).chr(64+$map_position);
								$tmpsg[$kkk+1] = ''; // end
							}
							$map_position++;
						}
					}

					// var_dump($tmpsg);
					//var_dump($tmpsg);die;
					$ggg = implode("\n",$tmpsg);
					$tmp2 = <<<XXX
<?php

\$group_struct = $ggg;
XXX;
					// echo $tmp2;

					if($tmp2 != ''){
						// 2018-03-14 這個程序疑似有問題，尤其是遇到群組的群組，這裡就會誤判
						// 是不是要檢查一下裡面有沒有群組
						// $has_group = false;
						// var_dump($tmp2);
						// $tmps3 = explode("\n", $tmp2);
						// if($tmps3 and count($tmps3) > 0){
						// 	foreach($tmps3 as $kkk => $vvv){
						// 		if(preg_match('/\'\$(.*)\'/', $vvv, $matches)){
						// 			$has_group = true;
						// 			break;
						// 			//$groups[] = $matches[1];
						// 		}
						// 	}
						// }

						if(isset($vv['hole']) and !empty($vv['hole'])){
							foreach($vv['hole'] as $kkk => $vvv){
								$tmp2 = str_replace($map[$kkk], var_export($vvv, true).',', $tmp2);
							}
						}

							// debug的好幫手
							// file_put_contents('123.txt',$tmp2);
							eval('?'.'>'.$tmp2);
							// var_dump($group_struct);
							$tmp4 = layoutv3_group_recursive($group_struct, $db);
							//var_dump($tmp4);
							$tmp2 = '<'.'?'.'php'."\n".'$group_struct = '.var_export($tmp4, true).';';
							// var_dump( $tmp2);
							// echo '123';die;

						// 2018-03-14 這個程序疑似有問題，尤其是遇到群組的群組，這裡就會誤判
						// if($has_group === true){
						// }

						eval('?'.'>'.$tmp2);
						//echo $v;
						//var_dump($group_struct);
						$group_result[$v] = $group_struct;
					} // tmp2 !empty
				}
			}
		}
	}
	/*
	 * array(1) {
	 *   [0]=>
	 *   array(2) {
	 *     ["file"]=>
	 *     string(8) "$header1"
	 *     ["position"]=>
	 *     string(16) "-0-hole-1-hole-0"
	 *   }
	 * }
	 */
	foreach($group_tmp as $k => $v){
		foreach($v as $kk => $vv){
			$vv['position'] = str_replace('hole', '"hole"', $vv['position']);
			$tmp = explode('-',$vv['position']);

			if($group_result){
				foreach($group_result[str_replace('$','',$vv['file'])] as $kkk => $vvv){
					$tmp2 = $tmp;
					$tmp2[count($tmp2)-1] .= '_'.$kkk;
					$tmp2[count($tmp2)-1] = '"'.$tmp2[count($tmp2)-1].'"';
					unset($tmp2[0]);
					$node_string = '['.implode("][",$tmp2).']';
					$run = '$page'.$node_string.'='.var_export($vvv, true).';';
					eval($run);
				}
			}

			unset($tmp[count($tmp)-1]);
			unset($tmp[0]);
			$node_string = '['.implode("][",$tmp).']';
			$run = '@ksort($page'.$node_string.');';
			eval($run);
		}
	}
	//var_dump($page);

	return $page;
} // layoutv3_group_recursive

/*
 * $ID = layoutv3_next_data_id($layoutv3_struct, $ID);
 */
function layoutv3_next_data_id($struct, $current){
	$point = false;
	foreach($struct as $k => $v){
		if($point){
			$tmp = explode('|', $v);
			return trim($tmp[0]);
		}
		if(preg_match('/^'.$current.'\|/', $v)){
			$point = true;
		}
	}
}

function layoutv3_struct_search($array, $key, $value, $k = '')
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
			$array['position'] = $k; // 這個是我後來加的
            $results[] = $array;
        }

        foreach ($array as $ggg => $subarray) {
            $results = array_merge($results, layoutv3_struct_search($subarray, $key, $value, $k.'-'.$ggg));
        }
    }

    return $results;
}

// http://php.net/manual/en/function.rand.php
// @qtd 要產出的長度
function layoutv3_hash($qtd){
	//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
	$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
	$QuantidadeCaracteres = strlen($Caracteres);
	$QuantidadeCaracteres--;

	$Hash=NULL;
		for($x=1;$x<=$qtd;$x++){
			$Posicao = rand(0,$QuantidadeCaracteres);
			$Hash .= substr($Caracteres,$Posicao,1);
		}

	return $Hash; 
}

// https://blog.longwin.com.tw/2009/03/php-object-to-array-json-reader-cli-2009/
//
// 使用方式
// $rows = $this->db->createCommand()->from('producttype')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// $indexedItems = array();
// 
// foreach ($rows as $item) {
// 	$item['child'] = array();
// 	$indexedItems[$item['id']] = (object) $item;
// }
// 
// $topLevel = array();
// foreach ($indexedItems as $item) {
// 	if ($item->pid == 0) {
// 		$topLevel[] = $item;
// 	} else {
// 		$indexedItems[$item->pid]->child[] = $item;
// 	}
// }
// $tree = std_class_object_to_array($topLevel);
// var_dump($tree);
// 2019-12-31 移到layoutv3/cig_frontend/init.php
// function std_class_object_to_array($stdclassobject)
// {
// 	$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
// 
// 	foreach ($_array as $key => $value) {
// 		$value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
// 		$array[$key] = $value;
// 	}
// 
// 	if(isset($array)){
// 		return $array;
// 	}
// }

/*
 * 2019-12-05
 * 李哥說，這個呼叫自己的，不會吃主機的流量
 * delete from html where type='labelgoogle'
 */
// function t($text = '', $source = 'tw', $target = '')
// {
// 	$db = $_SESSION['cidb'];
// 
// 	// 我打算給它預設值為當前語系
// 	if($target == ''){
// 		$target = $_SESSION['web_ml_key'];
// 	//} else {
// 		//$target = $target;
// 	}
// 
// 	// file_put_contents('123.txt', 'source='.$source, FILE_APPEND);
// 	// file_put_contents('123.txt', 'tar='.$target, FILE_APPEND);
// 	// file_put_contents('123.txt', .'/../', FILE_APPEND);
// 
// 	$file = _BASEPATH.'/assets/translate.php';
// 	$translates = array();
// 	if(file_exists($file)){
// 		include $file;
// 	}
// 
// 	$file2 = _BASEPATH.'/assets/labelgoogle.php';
// 	$labelgoogles = array();
// 	if(file_exists($file2)){
// 		include $file2;
// 	}
// 
// 	if($source == $target){ // 同語系的情況，就直接顯示
// 		return $text;
// 	} elseif(isset($translates[$target][$text]) and $translates[$target][$text] != ''){ // 都有的情況下
// 		if(isset($labelgoogles[$target][$text]) and $labelgoogles[$target][$text] != ''){
// 			return $labelgoogles[$target][$text];
// 		} else {
// 			return $translates[$target][$text];
// 		}
// 	} elseif(isset($labelgoogles[$target][$text])){ // 後台有的情況
// 		if($labelgoogles[$target][$text] != ''){
// 			return $labelgoogles[$target][$text];
// 		} else { // 如果是空白，代表是自動建議的新片語，還未有人去輸入
// 			return $text;
// 		}
// 	} else { // 這一定是新片語
// 
// 		$row = $db->where('is_enable',1)->where('type','labelgoogle')->where('ml_key',$_SESSION['web_ml_key'])->where('topic',$text)->get('html')->row_array();
// 
// 		// var_dump($row);
// 
// 		if($row and isset($row['id'])){
// 			// do nothing
// 		} else {
// 			$save = array(
// 				'type' => 'labelgoogle',
// 				// 'ml_key' => $this->data['ml_key'],
// 				'ml_key' => $_SESSION['web_ml_key'],
// 				'topic' => $text,
// 				'is_enable' => 1,
// 				'create_time' => date('Y-m-d H:i:s'),
// 			);
// 			$db->insert('html',$save);
// 		}
// 
// 		return $text;
// 	}
// }

// function t($text = '', $source = 'zh-TW', $target = '')
// {
//  	$map = array(
//  		'tw' => 'zh-TW',
//  		'cn' => 'zh-CN',
//  		'jp' => 'ja',
//  	);
//  
//  	// 這個一定有值
//  	if(isset($map[$source])){
//  		$source = $map[$source];
//  	}
//  
//  	// 我打算給它預設值為當前語系
//  	if($target == ''){
//  		if(!isset($map[$_SESSION['web_ml_key']])){
//  			$target = $_SESSION['web_ml_key'];
//  		} else {
//  			$target = $map[$_SESSION['web_ml_key']];
//  		}
//  	} else {
//  		if(isset($map[$target])){
//  			$target = $map[$target];
//  		}
//  	}
// 
// 	$url = FRONTEND_DOMAIN;
// 	if(defined('FRONTEND_FOLDER')){
// 		$url = str_replace(FRONTEND_FOLDER,'',$url);//防呆偵錯 by lota
// 		$url .= FRONTEND_FOLDER;
// 	}
// 	$url .= '/translate.php';
// 	$post = array(
// 		'text' => $text,
// 		'source' => $source,
// 		'target' => $target,
// 	);
// 
// 	$postdata = http_build_query($post);
// 	$ch = curl_init();
// 
// 	// 2019-03-08 鑫永銓遇到的
// 	// https://dotblogs.com.tw/jses88001/2014/08/10/146222
// 	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
// 	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// 
// 	$options = array(
// 		CURLOPT_URL => $url,
// 		CURLOPT_HEADER => 0,
// 		CURLOPT_VERBOSE => 0,
// 		CURLOPT_RETURNTRANSFER => true,
// 		CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
// 		CURLOPT_POST => true,
// 		CURLOPT_POSTFIELDS => $postdata,
// 	);
// 	curl_setopt_array($ch, $options);
// 	$code = curl_exec($ch); 
// 	curl_close($ch);
// 
// 	return $code;
// 	
// }

/*
 * 2019-12-04 這個已經不用了
 */
// function t($text = '', $source = 'zh-TW', $target = '')
// {
// 	$map = array(
// 		'tw' => 'zh-TW',
// 		'cn' => 'zh-CN',
// 		'jp' => 'ja',
// 	);
// 
// 	// 這個一定有值
// 	if(isset($map[$source])){
// 		$source = $map[$source];
// 	}
// 
// 	// 我打算給它預設值為當前語系
// 	if($target == ''){
// 		if(!isset($map[$_SESSION['web_ml_key']])){
// 			$target = $_SESSION['web_ml_key'];
// 		} else {
// 			$target = $map[$_SESSION['web_ml_key']];
// 		}
// 	} else {
// 		if(isset($map[$target])){
// 			$target = $map[$target];
// 		}
// 	}
// 
// 	$file = '_i/assets/translate.php';
// 
// 	$translates = array();
// 	if(file_exists($file)){
// 		include $file;
// 	}
// 
// 	$file2 = '_i/assets/labelgoogle.php';
// 	$labelgoogles = array();
// 	if(file_exists($file2)){
// 		include $file2;
// 	}
// 
// 	if($source == $target){ // 同語系的情況
// 		return $text;
// 	} elseif(isset($translates[$target][$text]) and $translates[$target][$text] != ''){
// 		if(isset($labelgoogles[$target][$text]) and $labelgoogles[$target][$text] != ''){
// 			return $labelgoogles[$target][$text];
// 		} else {
// 			return $translates[$target][$text];
// 		}
// 	} else {
// 		$url = FRONTEND_DOMAIN;
// 		if(defined('FRONTEND_FOLDER')){
// 			$url = str_replace(FRONTEND_FOLDER,'',$url);//防呆偵錯 by lota
// 			$url .= FRONTEND_FOLDER;
// 		}
// 		$url .= '/translate.php';
// 		$post = array(
// 			'text' => $text,
// 			'source' => $source,
// 			'target' => $target,
// 		);
// 
// 		$postdata = http_build_query($post);
// 		$ch = curl_init();
// 
// 		// 2019-03-08 鑫永銓遇到的
// 		// https://dotblogs.com.tw/jses88001/2014/08/10/146222
// 		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
// 		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
// 
// 		$options = array(
// 			CURLOPT_URL => $url,
// 			CURLOPT_HEADER => 0,
// 			CURLOPT_VERBOSE => 0,
// 			CURLOPT_RETURNTRANSFER => true,
// 			CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
// 			CURLOPT_POST => true,
// 			CURLOPT_POSTFIELDS => $postdata,
// 		);
// 		curl_setopt_array($ch, $options);
// 		$code = curl_exec($ch); 
// 		curl_close($ch);
// 
// 		return $code;
// 	}
// }

// https://gist.github.com/xonge/0dfb37045f2bd308205e
function nl2p($text) {
  return "<p>" . str_replace("\n", "</p><p>", $text) . "</p>";
}
