<?php

// 側邊選單會用到以外，內容物的展示圖片，也會從這裡取得
$webmenuchild = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get('webmenuchild')->result_array();

$demo_pic_tmp = array();
if(!empty($webmenuchild)){
	foreach($webmenuchild as $k => $v){
		if($v['pid'] == 0 and $v['name'] == '設計溝通'){
			foreach($webmenuchild as $kk => $vv){
				if($vv['pid'] != $v['id']){
					continue;
				}
				foreach($webmenuchild as $kkk => $vvv){
					if($vvv['pid'] != $vv['id']){
						continue;
					}
					$file = '$'.$v['name'].'-'.$vv['name'].'-'.$vvv['name'];
					if($vvv['url'] != ''){
						$file = $vvv['url'];
					}
					if($vvv['pic1'] != ''){
						$demo_pic_tmp[$file] = '_i/assets/upload/webmenuchild/'.$vvv['pic1'];
					}
				}
			}
		}
	}
}


$rows = $this->db->createCommand()->select('id, pid as parent_id, other_func, name as file, params')->from('layoutv3pagetype')->where('is_enable=1')->order('sort_id')->queryAll();
if($rows and count($rows) > 0){
	// 2018-03-26 打算支援的網址 $_SERVER['REQUEST_URI']
	// /faq_tw.php
	// /company_tw_1.php 
	// /news/news.php
	// /news_tw.php?id=17
	// /XXX.php
	$tmps = explode('/', $_SERVER['REQUEST_URI']);
	$request_uri = $_SERVER['REQUEST_URI'];

	// 動態網址(第2版)
	if(file_exists('_i/assets/_dynamic_url.php')){
		include '_i/assets/_dynamic_url.php';
	}

	if(count($tmps) == 3){
		if(isset($_dynamic_url) and in_array($tmps[1], $_dynamic_url)){
			$request_uri = '/'.$tmps[1].'.php';
		} else {
			$request_uri = '/'.$tmps[2];
		}
	}

	$tmp = str_replace('/', '', str_replace('.php','', $request_uri));
	$tmp2 = explode('?', $tmp);
	$tmp = $tmp2[0];

	// 為了要支援沒有語系(_tw)的網址
	if(!preg_match('/_'.$this->data['ml_key'].'$/', $tmp)){
		$tmp .= '_'.$this->data['ml_key'];
	}

	foreach($rows as $k => $v){
		$other_func = explode(',',$v['other_func']);
		if($v['parent_id'] == 0 and $v['file'].'_'.$this->data['ml_key'] != $tmp and !in_array(str_replace('_'.$this->data['ml_key'],'',$tmp),$other_func)){
			unset($rows[$k]);
		}
	}

	foreach($rows as $k => $v){
		unset($rows[$k]['other_func']);
	}
}
$result = buildTree($rows);
if(!isset($result[0])){
	echo '404';
	header("HTTP/1.0 404 Not Found");
	die;
}
$page_layoutit = $result[0]['hole'];
//var_dump($page_layoutit);die;

$_SESSION['layoutit_router_method'] = $this->data['router_method'];

//var_dump($page[0]['hole']['0_0']['hole']['0_0']['hole'][1]);die;

// var_dump($page_layoutit[0]);die;

// $aaa = var_export($page_layoutit,true);
// $aaas = explode("\n", $aaa);
//var_dump($aaas);

// $current = 0;
// 
// foreach($aaas as $k => $v){
// 	if(preg_match('/^(.*)\'file\'\ =>\ \'(.*)\'\,$/', $v, $matches)){
// 		$current = strlen($matches[1])/4;
// 		echo $current.',';
// 	}
// }

function aaa($items, $demo_pic_tmp = array()){
	$render = '';
	// var_dump($items);
	if($items and count($items) > 0){
		foreach ($items as $k => $item){
			$file = '-group';
			if(isset($item['file']) and $file != ''){
				$file = $item['file'];
			}

			//$render .= '<div class="column column_'.$item['parent_id'].'">'."\n";
			$render .= '	<div class="lyrow">'."\n";
			$render .= '		<a href="#close" class="remove label label-danger">'."\n";
			$render .= '			<i class="glyphicon-remove glyphicon"></i>'."\n";
			$render .= '			删除'."\n";
			$render .= '		</a>'."\n";
			$render .= "\n";
			$render .= '		<span class="drag label label-default">'."\n";
			$render .= '			<i class="glyphicon glyphicon-move"></i>'."\n";
			$render .= '			拖拉('.$file.')'."\n";
			$render .= '		</span>'."\n";
			$render .= "\n";
			$render .= '		<div class="preview preview_'.$item['parent_id'].'_'.$item['id'].'" params="'.$item['params'].'">'.$file.'</div>'."\n";
			$render .= '		<div class="view">'."\n";

			$phy_file = _BASEPATH.'/../view/'.$file.'.php';
			$tmp = '';
			if(preg_match('/^(\$layout_main|\$側邊選單|-group|\$layoutit)$/', $file)){ // 只有一個洞，只能擺一個
				$tmp = '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
			} elseif(preg_match('/^\$(側邊|一般)結構$/', $file)){ // 二個洞
				$tmp .= '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
				$tmp .= '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
			} elseif(preg_match('/^\$/', $file)){ // 其它群組的情況下
				if($demo_pic_tmp and isset($demo_pic_tmp[$file])){
					$tmp .= '<img src="'.$demo_pic_tmp[$file].'" />'."\n";
				} elseif(preg_match('/資料/', $file)){ // 例如：內頁資料流-單頁
					$tmp .= '通用資料流：{ '.$file.' }'."\n";
				} else {
					$tmp .= '群組：{ '.$file.' }'."\n";
				}
			} elseif(!preg_match('/^\$/', $file)){
				if($demo_pic_tmp and isset($demo_pic_tmp[$file])){
					$tmp .= '<img src="'.$demo_pic_tmp[$file].'" />'."\n";
				} elseif(file_exists($phy_file)){
					$tmp = file_get_contents($phy_file);
					$tmp = str_replace('<'.'?'.'php echo $AA?'.'>','<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n",$tmp);
					$tmp = str_replace('<'.'?'.'php echo $BB?'.'>','<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n",$tmp);
					$tmp = str_replace('<'.'?'.'php echo $CC?'.'>','<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n",$tmp);
					$tmp = str_replace('<'.'?'.'php echo $DD?'.'>','<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n",$tmp);
					$tmp = str_replace('<'.'?'.'php echo $EE?'.'>','<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n",$tmp);
					$tmp = str_replace('<'.'?'.'php echo $__?'.'>','<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>'."\n",$tmp);

					// 2020-01-10 如果有php註解，也會被標註為程式
					if(preg_match('/\<\?php/', $tmp) and !preg_match('/column\ column/',$tmp)){
						if(!isset($_SESSION['layoutit_showphp'])){
							$tmp = '含程式：{ '.$file.' }'."\n";
						}
					}
				} elseif(preg_match('/___/', $file)){
					$tmp .= '動態模組：{ '.$file.' }'."\n";
				} else {
					$tmp .= '區塊：{ '.$file.' }'."\n";
				}
			}

			$count = 0;
			$tmps = explode("\n", $tmp);
			foreach($tmps as $kk => $vv){
				if(preg_match('/column_'.$item['parent_id'].'_'.$item['id'].'\"/', $vv)){
					$count++;
				}
			}

			//if($count <= 0 and $item['file'] != '-group'){
			//	//$render .= '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'">'."\n";
			//	$render .= $tmp;
			//	//$render .= '</div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
			//	//$render .= '<!-- cxlumn_'.$item['parent_id'].'_'.$item['id'].' -->'."\n";
			//}

			// if(0 and $count <= 0){
			// 	$render .= '<div class="lyrow">'."\n";
			// 	$render .= '	<a href="#close" class="remove label label-danger">'."\n";
			// 	$render .= '		<i class="glyphicon-remove glyphicon"></i>'."\n";
			// 	$render .= '		删除'."\n";
			// 	$render .= '	</a>'."\n";
			// 	$render .= "\n";
			// 	$render .= '	<span class="drag label label-default">'."\n";
			// 	$render .= '		<i class="glyphicon glyphicon-move"></i>'."\n";
			// 	$render .= '		拖拉('.$file.')'."\n";
			// 	$render .= '	</span>'."\n";
			// 	$render .= "\n";
			// 	$render .= '	<div class="preview preview_'.$item['parent_id'].'_'.$item['id'].'">'.$file.'</div>'."\n";
			// 	$render .= '	<div class="view">'."\n";

			// 	$render .= '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'">'."\n";
			// 	$render .= $tmp;
			// 	$render .= '</div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
			// 	$render .= '<!-- cxlumn_'.$item['parent_id'].'_'.$item['id'].' -->'."\n";

			// 	$render .= '	</div>'."\n"; // view
			// 	$render .= '</div>'."\n"; // lyrow
			// }

			// if(preg_match('/^(\$側邊選單)$/', $file)){ // 沒有hole的情況
			// 	$render .= '<div class="column"></div>'."\n";
			// 	$render .= '<!-- cxlumn -->'."\n";
			// } elseif(preg_match('/^(\$一般結構|\$側邊結構)$/', $file)){
			// 	$render .= '<div class="column"></div>'."\n";
			// 	$render .= '<!-- cxlumn -->'."\n";
			// 	$render .= '<div class="column"></div>'."\n";
			// 	$render .= '<!-- cxlumn -->'."\n";
			// }

			if(0 and $item['id'] == 952){
				var_dump($item['hole']);
				echo $item['file'];
				echo $count;
				echo $tmp;
			}

			if (!empty($item['hole'])) {

				//echo $item['id'].'-'.$tmp."\n";
				if($tmp != ''){
					//var_dump($item['hole']);
					if($item['file'] == '-group'){ // 可以擺多個

						if(0 and $item['id'] == 956){
							var_dump($item['hole']);
							echo $item['file'];
							echo $count;
							echo $tmp;
							//echo '/<div\ class=\"column\ column_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'\">(.*)<\/div_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'>/s'."\n";
							//echo $item['hole'][$x-1]['id'];
							//echo $tmp2;
						}

						//$render .= '<div class="lyrow">'."\n";
						//$render .= '	<a href="#close" class="remove label label-danger">'."\n";
						//$render .= '		<i class="glyphicon-remove glyphicon"></i>'."\n";
						//$render .= '		删除'."\n";
						//$render .= '	</a>'."\n";
						//$render .= "\n";
						//$render .= '	<span class="drag label label-default">'."\n";
						//$render .= '		<i class="glyphicon glyphicon-move"></i>'."\n";
						//$render .= '		拖拉('.$item['file'].')'."\n";
						//$render .= '	</span>'."\n";
						//$render .= "\n";
						//$render .= '	<div class="preview preview_'.$item['parent_id'].'_'.$item['id'].'">'.$item['file'].'</div>'."\n";
						//$render .= '	<div class="view">'."\n";

						$render .= '		<div class="column column_'.$item['parent_id'].'_'.$item['id'].'">'."\n";
						$render .= '		' .aaa($item['hole'], $demo_pic_tmp);
						$render .= '		</div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
						$render .= '		<span class="column_end column_'.$item['parent_id'].'_'.$item['id'].'" style="display:none"></span>'."\n";

						//if(0 and $item['id'] == 956){
						//	echo $render;
						//}

						//$render .= '		<!-- cxlumn_'.$item['parent_id'].'_'.$item['id'].' -->'."\n";

						//$render .= '	</div>'."\n";
						//$render .= '	<span class="preview_'.$item['parent_id'].'_'.$item['id'].'" style="display:none"></span>'."\n";
						//$render .= '</div>'."\n";
						//$render .= '<!-- preview_'.$item['parent_id'].'_'.$item['id'].' -->'."\n";
					} else {
						$tmp2 = aaa($item['hole'], $demo_pic_tmp);

						if(0 and $item['id'] == 952){
							var_dump($items);
						}

						for($x=1;$x<=$count;$x++){
							//if($item['id'] == 952){
							//echo $x.'xxxxxx';
							//}
							//$tmpa = $item['hole'][$x-1];
							////var_dump($tmpa);
							//$tmpb[] = $tmpa;
							//$tmp2 = aaa($tmpb);

							//$tmp2 = aaa($item['hole'][$x-1]);

							if($item['id'] == 952){
								//echo 'ggggggggg';
								//var_dump($tmpa);
								//if(0 and $x==2){
								//	echo 'gggggggg';
								//	echo $tmp2;
								//	//var_dump($item['hole'][$x-1]);
								//}
								//var_dump($item['hole'][$x-1]);
								//var_dump($item['hole']);
								//echo $tmp2;
								//echo $item['id'];
							}

							//echo $x.'-'.$item['file'];
							//var_dump($item['hole']);
							//echo "\n".'/<div\ class=\"column\ column_'.$item['id'].'\">(.*)<\/div_'.$item['id'].'>/';
							//echo $tmp2;
							//echo $item['hole'][$x-1]['id'].',';
							//echo $tmp2;
							//echo $item['id'];
							// if(isset($item['hole'][$x-1]['id']) 
							// 	and preg_match('/<div\ class=\"column\ column_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'\">(.*)<\/div_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'>/s', $tmp2, $matches)){
							// 	$tmp3  = '<div class="column column_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'">'."\n";
							// 	$tmp3 .= $matches[1];
							// 	$tmp3 .= '</div_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'>'."\n";
							// 	$tmp3 .= '<!-- cxlumn_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].' -->'."\n";
							// 	$tmp = str_replace_first('<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>',$tmp3,$tmp);
							// }
							// if(isset($item['hole'][$x-1]['id'])){
							// 	$tmp = str_replace_first('<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>',$tmp2,$tmp);
							// }
							if(isset($item['hole'][$x-1]['id'])){
								if($item['hole'][$x-1]['file'] == 'ggggg-group'){// 2019-10-18 疑似這裡有問題
									//$tmp2 = aaa($item['hole']);

									//if($item['id'] == 952){
									//	echo $tmp2;
									//}
									//echo 'gggggg';
									//$tmp .= $tmp2;
									$tmp3 = '';
									$tmp3 .= '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'">'."\n";
									$tmp3 .= $tmp2;
									$tmp3 .= '</div_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'>'."\n";
									$tmp3 .= '<span class="column_end column_'.$item['parent_id'].'_'.$item['id'].'" style="display:none"></span>'."\n";
									$tmp = str_replace_first('<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>',$tmp3,$tmp);
									//if($item['id'] == 952){
									//	echo $x.' '.$item['hole'][$x-1]['file']."\n";
									//	echo $tmp.'ggggggg';
									//}
								} else {
									$tmp3 = '';
									$tmp3 .= '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'">'."\n";
									$tmp3 .= '	<div class="lyrow">'."\n";
									$tmp3 .= '		<a href="#close" class="remove label label-danger">'."\n";
									$tmp3 .= '			<i class="glyphicon-remove glyphicon"></i>'."\n";
									$tmp3 .= '			删除'."\n";
									$tmp3 .= '		</a>'."\n";
									$tmp3 .= "\n";
									$tmp3 .= '		<span class="drag label label-default">'."\n";
									$tmp3 .= '			<i class="glyphicon glyphicon-move"></i>'."\n";
									$tmp3 .= '			拖拉('.$item['hole'][$x-1]['file'].')'."\n";
									$tmp3 .= '		</span>'."\n";
									$tmp3 .= "\n";
									$tmp3 .= '		<div class="preview preview_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'" params="'.$item['hole'][$x-1]['params'].'">'.$item['hole'][$x-1]['file'].'</div>'."\n";
									$tmp3 .= '		<div class="view">'."\n";

									if(preg_match('/<div\ class=\"column\ column_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'\">(.*)<\/div_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'>/s', $tmp2, $matches)){
										//$tmp3 = '';
										//$tmp3 .= '<div class="column column_'.$item['parent_id'].'_'.$item['id'].'">'."\n";
										$tmp3 .= '	<div class="column column_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'">'."\n";
										$tmp3 .= '		'.$matches[1];
										$tmp3 .= '	</div_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'>'."\n";
										$tmp3 .= '	<span class="column_end column_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'" style="display:none"></span>'."\n";
										//$tmp3 .= '</div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
										//$tmp3 .= '<span class="column_end column_'.$item['parent_id'].'_'.$item['id'].' style="display:none"></span>'."\n";
										//$tmp = str_replace_first('<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>',$tmp3,$tmp);
									// 最末層，沒有包column的情況
									} elseif(preg_match('/<!--\ last_start\:'.$item['hole'][$x-1]['id'].'\ -->(.*)<\!--\ last_end\:'.$item['hole'][$x-1]['id'].'\ -->/s', $tmp2, $matches)){
										//$tmp3 = '';

										//$tmp3 .= '	<div class="lyrow">'."\n";
										//$tmp3 .= '		<a href="#close" class="remove label label-danger">'."\n";
										//$tmp3 .= '			<i class="glyphicon-remove glyphicon"></i>'."\n";
										//$tmp3 .= '			删除'."\n";
										//$tmp3 .= '		</a>'."\n";
										//$tmp3 .= "\n";
										//$tmp3 .= '		<span class="drag label label-default">'."\n";
										//$tmp3 .= '			<i class="glyphicon glyphicon-move"></i>'."\n";
										//$tmp3 .= '			拖拉('.$item['file'].')'."\n";
										//$tmp3 .= '		</span>'."\n";
										//$tmp3 .= "\n";
										//$tmp3 .= '		<div class="preview preview_'.$item['parent_id'].'_'.$item['id'].'">'.$item['file'].'</div>'."\n";
										//$tmp3 .= '		<div class="view">'."\n";

										$tmp3 .= '			'.$matches[1];

										//$tmp3 .= '		</div>'."\n"; // view
										//$tmp3 .= '		<span class="preview_end preview_'.$item['parent_id'].'_'.$item['id'].'" style="display:none"></span>'."\n"; // view
										//$tmp3 .= '	</div>'."\n"; // lyrow

										//$tmp = str_replace_first('<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>',$tmp3,$tmp);
									}
									$tmp3 .= '		</div>'."\n";
									$tmp3 .= '		<span class="preview_end preview_'.$item['hole'][$x-1]['parent_id'].'_'.$item['hole'][$x-1]['id'].'" style="display:none"></span>'."\n";
									$tmp3 .= '	</div>'."\n";
									$tmp3 .= '</div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
									$tmp3 .= '<span class="column_end column_'.$item['parent_id'].'_'.$item['id'].'" style="display:none"></span>'."\n";
									$tmp = str_replace_first('<div class="column column_'.$item['parent_id'].'_'.$item['id'].'"> </div_'.$item['parent_id'].'_'.$item['id'].'>',$tmp3,$tmp);
								}
							}
						} // for
						$render .= $tmp;
					}
				// } else {
				// 	if(0 and $item['file'] == '-group'){ // 容器裡面可以放多個
				// 		$render .= '<div class="lyrow">'."\n";
				// 		$render .= '	<a href="#close" class="remove label label-danger">'."\n";
				// 		$render .= '		<i class="glyphicon-remove glyphicon"></i>'."\n";
				// 		$render .= '		删除'."\n";
				// 		$render .= '	</a>'."\n";
				// 		$render .= "\n";
				// 		$render .= '	<span class="drag label label-default">'."\n";
				// 		$render .= '		<i class="glyphicon glyphicon-move"></i>'."\n";
				// 		$render .= '		拖拉('.$item['file'].')'."\n";
				// 		$render .= '	</span>'."\n";
				// 		$render .= "\n";
				// 		$render .= '	<div class="preview preview_'.$item['parent_id'].'_'.$item['id'].'">'.$item['file'].'</div>'."\n";
				// 		$render .= '	<div class="view">'."\n";

				// 		$render .= '		<div class="column column_'.$item['parent_id'].'_'.$item['id'].'">'."\n";
				// 		$render .= '		' .aaa($item['hole']);
				// 		$render .= '		</div_'.$item['parent_id'].'_'.$item['id'].'>'."\n";
				// 		$render .= '		<!-- cxlumn_'.$item['parent_id'].'_'.$item['id'].' -->'."\n";

				// 		$render .= '	</div>'."\n";
				// 		$render .= '</div>'."\n";
				// 		$render .= '<!-- preview_'.$item['parent_id'].'_'.$item['id'].' -->'."\n";
				// 	}

				}

				//$tmp = str_replace_first('','',$tmp);
				//$render .= '<!-- cxlumn -->'."\n";
				//$render .= '</div>'."\n";
				//$render .= '</div>'."\n";
			} else {
				// $render .= '<div class="column_'.$item['id'].'">'."\n";
				//if($count > 0){

				// 因為是最末層，所以不用包column
				$render .= '<!-- last_start:'.$item['id'].' -->'."\n";
				//if(!preg_match('/<div\ class=\"column\ column_(.*)_(.*)\">\ <\/div_(.*)_(.*)>/', $tmp, $matches)){
					$render .= $tmp;
				//}
				$render .= '<!-- last_end:'.$item['id'].' -->'."\n<br />"; // 2020-01-07 加上br
					
				//}
				// $render .= '</div_'.$item['id'].'>'."\n";
				//$render .= '<!-- cxlumn_'.$item['id'].' -->'."\n";
			}

			$render .= '		</div>'."\n"; // view
			$render .= '		<span class="preview_end preview_'.$item['parent_id'].'_'.$item['id'].'" style="display:none"></span>'."\n"; // view
			$render .= '	</div>'."\n"; // lyrow
			//$render .= '</div>'."\n"; // column
			//$render .= '<!-- preview '.$file.' -->'."\n";
			//$render .= '<!-- preview_'.$item['parent_id'].'_'.$item['id'].' -->'."\n";
			//$render .= '</div_'.$item['parent_id'].'>'."\n";
		}
	}
	return $render."\n";
}
//var_dump($page_layoutit);
// echo aaa($page_layoutit);die;
// echo aaa($page[0]['hole']['0_0']['hole']['0_0']['hole'][1]);die;

$demo = aaa($page_layoutit, $demo_pic_tmp);
$demos = explode("\n", $demo);
foreach($demos as $k => $v){
	if(preg_match('/class="column_(\d+)_(\d+)"/', $v)){
		//unset($demos[$k]);
	} elseif(preg_match('/<\/div_(\d+)_(\d+)>/', $v, $matches)){
		//echo '</div_'.$matches[1].'_'.$matches[2].'>';
		$demos[$k] = str_replace('</div_'.$matches[1].'_'.$matches[2].'>','</div>', $v);
		// unset($demos[$k]);
	}
}
//var_dump($demos);die;
$demo = implode("\n", $demos);

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title><?php echo $this->data['router_method']?>頁面</title>

  <!-- Le styles -->
  <link href="layoutit/lib/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
  <link href="layoutit/css/layoutit.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <![endif]-->

  <script src="layoutit/lib/jquery/dist/jquery.min.js"></script>
  <script src="layoutit/js/jquery-ui.js"></script>
  <script src="layoutit/js/jquery.htmlClean.js"></script>
  <script src="layoutit/lib/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="layoutit/js/scripts.js"></script>

</head>

<body style="min-height: 824px;" class="edit">
<div class="navbar navbar-inverse navbar-fixed-top navbar-layoutit">
  <div class="navbar-header">
    <button data-target="navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
      <span class="glyphicon-bar"></span>
      <span class="glyphicon-bar"></span>
      <span class="glyphicon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">
      <img class="img-responsive" src="_i/assets/logo.png">
    </a>
  </div>
  <div class="collapse navbar-collapse">

    <ul class="nav pull-right">
      <li>

        <div class="btn-group btn-donate pull-right"></div>
<?php if(0):?>
        <div class="btn-group">
          <a class="btn btn-xs btn-primary active" href="./en"><i class="glyphicon-globe glyphicon"></i>
            English
          </a>
          <button role="button" data-toggle="modal" data-target="#feedbackModal" id="feedback"
                  class="btn btn-xs btn-primary active"><i class="glyphicon-comment glyphicon"></i>
            联系我们
          </button>
        </div>
<?php endif?>
      </li>
    </ul>
    <ul class="nav" id="menu-layoutit">
      <li>
<?php if(0):?>
        <div class="btn-group" data-toggle="buttons-radio">
          <button type="button" id="edit" class="btn btn-xs btn-primary active"><i
                  class="glyphicon glyphicon-edit "></i>
            編輯
          </button>
          <button type="button" class="btn btn-xs btn-primary" id="devpreview">
            <i class="glyphicon-eye-close glyphicon"></i>
            開發
          </button>
          <button type="button" class="btn btn-xs btn-primary" id="sourcepreview">
            <i class="glyphicon-eye-open glyphicon"></i>
            預覽
          </button>
        </div>
<?php endif?>
        <div class="btn-group">
          <button type="button" id="button-showphp-toggle" class="btn btn-primary"><i class="glyphicon glyphicon-edit "></i>
			<?php if(isset($_SESSION['layoutit_showphp'])):?>
				隱藏含PHP語法的區塊
			<?php else:?>
				顯示含PHP語法的區塊
			<?php endif?>
          </button>
          <button type="button" id="edit" class="btn btn-primary active"><i class="glyphicon glyphicon-edit "></i>
            編輯
          </button>
          <button type="button" id="sourcepreview" class="btn btn-primary"><i class="glyphicon-eye-open glyphicon"></i>
            預覽
          </button>
          <button type="button" id="button-download-modal" class="btn btn-primary" role="button" data-toggle="modal"><i class="glyphicon-save glyphicon"></i>
            存檔 
          </button>
          <button type="button" id="button-save-and-exit" class="btn btn-primary" role="button" data-toggle="modal"><i class="glyphicon-saved glyphicon"></i>
            離開與展示(含存檔)
          </button>
          <button type="button" id="button-nosave-and-exit" class="btn btn-danger" role="button" data-toggle="modal"><i class="glyphicon-home glyphicon"></i>
            直接離開
          </button>

          <!--  <button class="btn btn-xs btn-primary" id="button-share-modal" href="/share/indexV3" role="button" data-toggle="modal" data-target="#shareModal"> <i class="glyphicon-share glyphicon"></i>
          分享
      </button>
      -->
<?php if(0):?>
          <button class="btn btn-xs btn-primary" href="#clear" id="clear">
            <i class="glyphicon-trash glyphicon"></i>
            清空
          </button>
<?php endif?>
        </div>
      </li>
    </ul>
  </div>
  <!--/.navbar-collapse -->
</div>
<!--/.navbar-fixed-top -->

<div class="container">
  <div class="row">
    <div class="">
      <div class="sidebar-nav">

		<br />
		<?php if(!empty($webmenuchild)):?>
			<?php foreach($webmenuchild as $k => $v):?>
				<?php if($v['pid'] == 0 and $v['name'] == '設計溝通'):?>
					<?php foreach($webmenuchild as $kk => $vv):?>
						<?php if($vv['pid'] != $v['id']):?><?php continue?><?php endif?>
						<ul class="nav nav-list accordion-group">
							<li class="nav-header">
								<div class="pull-right popover-info">
									<i class="glyphicon glyphicon-question-sign"></i>

									<div class="popover fade right">
										<div class="arrow"></div>
										<h3 class="popover-title">帮助</h3>

										<div class="popover-content">
											none
										</div>
									</div>
								</div>
								<i class="glyphicon-plus glyphicon"></i>
								<?php echo $vv['name']?>	
							</li>

							<li class="rows" id="estRows">
								<?php foreach($webmenuchild as $kkk => $vvv):?>
									<?php if($vvv['pid'] != $vv['id']):?><?php continue?><?php endif?>
									<div class="lyrow ui-draggable">
										<a href="#close" class="remove label label-danger">
											<i class="glyphicon-remove glyphicon"></i>
											删除
										</a>
										<span class="drag label label-default">
											<i class="glyphicon glyphicon-move"></i>
											拖拉
										</span>

										<span><?php echo $vvv['name']?></span>
										<?php if($vvv['url'] == ''):?>
											<div style="display:none" newnum="<?php echo $kkk?>" class="preview" params="">$<?php echo $v['name']?>-<?php echo $vv['name']?>-<?php echo $vvv['name']?></div>
										<?php else:?>
											<div style="display:none" newnum="<?php echo $kkk?>" class="preview" params=""><?php echo $vvv['url']?></div>
										<?php endif?>

										<div class="view">
											<?php if($vvv['pic1'] != ''):?>
												<img src="_i/assets/upload/webmenuchild/<?php echo $vvv['pic1']?>" />
											<?php else:?>
												<?php if($vvv['url'] == ''):?>
													群組：{ $<?php echo $v['name']?>-<?php echo $vv['name']?>-<?php echo $vvv['name']?> }
												<?php else:?>
													實體區塊：{ <?php echo $vvv['url']?> }
												<?php endif?>
											<?php endif?>
										</div>
										<span newnum="-group" class="preview_end" style="display:none"></span>
									</div>
								<?php endforeach?>
							</li>
						</ul>
					<?php endforeach?>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>

<?php if(0):?>
        <ul class="nav nav-list accordion-group">
          <li class="nav-header">
            <div class="pull-right popover-info">
              <i class="glyphicon glyphicon-question-sign"></i>

              <div class="popover fade right">
                <div class="arrow"></div>
                <h3 class="popover-title">帮助</h3>

                <div class="popover-content">
                  在这里设置你的栅格布局, 栅格总数默认为12, 用空格分割每列的栅格值, 如果您需要了解更多信息，请访问
                  <a href="http://v3.bootcss.com/css/#grid">BOOTSTRAP栅格系统.</a>
                </div>
              </div>
            </div>
            <i class="glyphicon-plus glyphicon"></i>
            系統區塊
          </li>
          <li class="rows" id="estRows">

			<?php foreach(array('$layout_main','-group','$一般結構','$側邊結構','$側邊選單') as $v):?>
				<div class="lyrow ui-draggable">
					<a href="#close" class="remove label label-danger">
						<i class="glyphicon-remove glyphicon"></i>
						删除
					</a>
					<span class="drag label label-default">
						<i class="glyphicon glyphicon-move"></i>
						拖拉
					</span>

					<div newnum="-group" class="preview"><?php echo $v?></div>
					<div class="view">
						<div newnum="-group" class="column"></div>
						<span newnum="-group" class="column_end" style="display:none"></span>
						<?php if(preg_match('/^\$(一般|側邊)結構$/', $v)):?>
							<div newnum="-group" class="column"></div>
							<span newnum="-group" class="column_end" style="display:none"></span>
						<?php endif?>
					</div>
					<span newnum="-group" class="preview_end" style="display:none"></span>
				</div>
			<?php endforeach?>



<?php
	$ccc = array();
	$path = _BASEPATH.'/../view/v3/layoutit';
	//echo $path;
	if(is_dir($path)){
		$ccc = $this->_getFiles($path);
	}
	foreach($ccc as $k => $v){
		$ccc[$k] = str_replace($path.'/','',str_replace('.php','',$v));
	}
	//var_dump($ccc);

	foreach($ccc as $k => $v){
?>
		<div class="lyrow ui-draggable">
			<a href="#close" class="remove label label-danger">
			<i class="glyphicon-remove glyphicon"></i>
			删除
			</a>
			<span class="drag label label-default">
			<i class="glyphicon glyphicon-move"></i>
			拖拉
			</span>

			<div newnum="<?php echo $k?>" class="preview">v3/layoutit/<?php echo $v?></div>
			<div class="view">
			<?php //echo file_get_contents($path.'/'.$v.'.php')?>
			<?php
				$tmp = file_get_contents($path.'/'.$v.'.php');
				$tmp = str_replace('<'.'?'.'php echo $AA?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
				$tmp = str_replace('<'.'?'.'php echo $BB?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
				$tmp = str_replace('<'.'?'.'php echo $CC?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
				$tmp = str_replace('<'.'?'.'php echo $DD?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
				$tmp = str_replace('<'.'?'.'php echo $EE?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);
				$tmp = str_replace('<'.'?'.'php echo $__?'.'>','<div newnum="'.$k.'" class="column"></div><span newnum="'.$k.'" class="column_end" style="display:none"></span>'."\n",$tmp);

				echo $tmp;
			?>
			</div>
			<span newnum="<?php echo $k?>" class="preview_end" style="display:none"></span>
		</div>
<?php
	} // foreach ccc
?>


          </li>
        </ul>

        <ul class="nav nav-list accordion-group">
          <li class="nav-header">
            <i class="glyphicon glyphicon-plus"></i>
            基本CSS
            <div class="pull-right popover-info">
              <i class="glyphicon glyphicon-question-sign "></i>

              <div class="popover fade right">
                <div class="arrow"></div>
                <h3 class="popover-title">帮助</h3>

                <div class="popover-content">
                  将组件元素拖放入你需要放入的栅格列中。之后，你可以设置该元素的样式。如果你需要了解更多内容，请访问
                  <a target="_blank" href="http://v3.bootcss.com/css/">基本CSS.</a>
                </div>
              </div>
            </div>
          </li>
          <li class="boxes" id="elmBase">
            <div class="box box-element ui-draggable">
              <a href="#close" class="remove label label-danger">
                <i class="glyphicon glyphicon-remove"></i>
                删除
              </a>
							<span class="drag label label-default">
								<i class="glyphicon glyphicon-move"></i>
								拖动
							</span>
							<span class="configuration">
								<span class="btn-group btn-group-xs">
									<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                      对齐
                                      <span class="caret"></span>
                                    </a>
									<ul class="dropdown-menu">
                                      <li class="active">
                                        <a href="#" rel="">默认</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="text-left">靠左</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="text-center">居中</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="text-right">靠右</a>
                                      </li>
                                    </ul>
								</span>
								<span class="btn-group btn-group-xs">
									<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                      标记
                                      <span class="caret"></span>
                                    </a>
									<ul class="dropdown-menu">
                                      <li class="active">
                                        <a href="#" rel="">默认</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="muted">禁用</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="text-warning">警告</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="text-error">错误</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="text-info">提示</a>
                                      </li>
                                      <li class="">
                                        <a href="#" rel="text-success">成功</a>
                                      </li>
                                    </ul>
								</span>

								<a class="btn btn-xs btn-default" href="#" rel="lead">Lead</a>
							</span>

              <div class="preview">段落</div>
              <div class="view">
                <p><em>Git</em>
                  是一个分布式的版本控制系统，最初由 <strong>Linus Torvalds</strong>
                  编写，用作Linux内核代码的管理。在推出后，Git在其它项目中也取得了很大成功，尤其是在
                  <small>Ruby</small>
                  社区中。
                </p>
                <div class="row clearfix">
					<div class="column"></div>
				</div>
				<!-- cxlumn -->
				<!-- preview 段落 -->
              </div>
            </div>
            <div class="box box-element ui-draggable">
              <a href="#close" class="remove label label-danger">
                <i class="glyphicon glyphicon-remove"></i>
                删除
              </a>
							<span class="drag label label-default">
								<i class="glyphicon glyphicon-move"></i>
								拖动
							</span>

              <div class="preview">地址</div>
              <div class="view">
                <address contenteditable="true"><strong>Twitter, Inc.</strong>
                  <br>
                  795 Folsom Ave, Suite 600
                  <br>
                  San Francisco, CA 94107
                  <br> <abbr title="Phone">P:</abbr>
                  (123) 456-7890
                </address>
              </div>
            </div>
          </li>
        </ul>
<?php endif?>

      </div>
    </div>
    <!--/span-->
    <div style="min-height: 754px;" class="demo ui-sortable">
		<?php echo $demo?>
		<?php //echo aaa($page[0]['hole']['0_0']['hole']['0_0']['hole'][1]['hole'])?>
		<?php //echo aaa($page_layoutit)?>
    </div>
    <!--/span-->
  </div>
  <!--/row-->

  <script type="text/javascript">
    $(document).ready(function () {
		$('.nav-header').eq(1).click();
      // alert($('#download-layout').html());
    });
  </script>
</div>
<!--/.fluid-container-->

<script type="text/javascript">

  $(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
  });

  $('body').on('click', '#continue-share-non-logged', function () {
    $('#share-not-logged').hide();
    $('#share-logged').removeClass('hide');
    $('#share-logged').show();
  });

  $('body').on('click', '#continue-download-non-logged', function () {
    $('#download-not-logged').hide();
    $('#download').removeClass('hide');
    $('#download').show();
    $('#downloadhtml').removeClass('hide');
    $('#downloadhtml').show();
    $('#download-logged').removeClass('hide');
    $('#download-logged').show();
  });


</script>

<div style="display: none;" class="modal fade" id="downloadModal" tabindex="-1" role="dialog"
     aria-labelledby="downloadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">下载</h4>
      </div>
      <div class="modal-body">

        <div id="download-logged" class="">
          <div class="alert alert-info">已在下面生成干净的HTML, 可以复制粘贴代码到你的body内<br>
            请使用bootstrap3.0.1,可在这里下载 <a target="_blank" href="http://www.bootcdn.cn/bootstrap/">http://www.bootcdn.cn/bootstrap</a>
          </div>
          <p>
				<textarea></textarea>
          </p>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>

<script type="text/javascript">
  function saveLayout() {
    return;
    $.ajax({
      type: "POST",
      url: "/build_v3/saveLayout",
      data: {'layout-v3': $('.demo').html()},
      success: function (data) {
        //updateButtonsVisibility();
      }
    });
  }

  //下载代码
  function downloadLayout() {
    $.ajax({
      type: "POST",
      url: "/build_v3/downloadLayout",
      data: {'layout-v3': $('#download-layout').html()},
      success: function (data) {
        window.location.href = '/build_v3/download';
      }
    });
  }

  function downloadHtmlLayout() {
    $.ajax({
      type: "POST",
      url: "/build_v3/downloadLayout",
      data: {'layout-v3': $('#download-layout').html()},
      success: function (data) {
        window.location.href = '/build_v3/downloadHtml';
      }
    });
  }

  function undoLayout() {

    $.ajax({
      type: "POST",
      url: "/build_v3/getPreviousLayout",
      data: {},
      success: function (data) {
        undoOperation(data);
      }
    });
  }

  function redoLayout() {

    $.ajax({
      type: "POST",
      url: "/build_v3/getPreviousLayout",
      data: {},
      success: function (data) {
        redoOperation(data);
      }
    });
  }
</script>


</body>
</html>
