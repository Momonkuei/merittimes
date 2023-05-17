<?php


$layout_v2_name = $this->data['router_class'].'-'.$this->data['router_method'];
$this->data['layout_v2_name'] = $layout_v2_name; // 另一個地方在使用的

// 看有沒有Controller Layoutv2之前的處理程序
if(file_exists(Yii::getPathOfAlias('application.controllers.layoutv2').'/first_'.$layout_v2_name.'.php')){
	$first_layout_v2_file = Yii::getPathOfAlias('application').'/controllers/layoutv2/first_'.$layout_v2_name.'.php';
} else {
	$first_layout_v2_file = Yii::getPathOfAlias('system.frontend.controllers.layoutv2').'/first_'.$layout_v2_name.'.php';
}

if(file_exists($first_layout_v2_file)){
	include $first_layout_v2_file;
}

// 看有沒有Layoutv2 結構檔
if(file_exists(Yii::getPathOfAlias('application.controllers.layoutv2').'/layout_'.$layout_v2_name.'.php')){
	$layout_v2_file = Yii::getPathOfAlias('application').'/controllers/layoutv2/layout_'.$layout_v2_name.'.php';
} else {
	$layout_v2_file = Yii::getPathOfAlias('system.frontend.controllers.layoutv2').'/layout_'.$layout_v2_name.'.php';
}

if(file_exists($layout_v2_file)){


	if(!file_exists(tmp_path.'/layoutv2_category1.php')){
		$tmp = file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category1');
		file_put_contents(tmp_path.'/layoutv2_category1.php', '<'.'?'.'php '."\n".$tmp);
	}
	include tmp_path.'/layoutv2_category1.php';

	if(isset($_GET['classtype']) and $_GET['classtype'] != ''){
	} else {
		$_GET['classtype'] = $layoutv2classtype_first['id'];
	}

	//eval(file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category2&classtype='.$_GET['classtype']));

	if(!file_exists(tmp_path.'/layoutv2_category2_'.$_GET['classtype'].'.php')){
		$tmp = file_get_contents(FRONTEND_LAYOUTV2.'/index.php?r=layoutv2/category2&classtype='.$_GET['classtype']);
		file_put_contents(tmp_path.'/layoutv2_category2_'.$_GET['classtype'].'.php', '<'.'?'.'php '."\n".$tmp);
	}
	include tmp_path.'/layoutv2_category2_'.$_GET['classtype'].'.php';

	$this->data['session_name'] = $layout_v2_name.'_winnie_layout_v2';
	$this->data[$layout_v2_name.'_editmode'] = false;

	/*
		$this->data[$this->data['layout_v2_name'].'_editmode'] = false;
		$_SESSION[$this->data['session_name'].'_edit'] = false;
		//$params = $_SESSION[$this->data['session_name'].'_params'];
		unset($_SESSION[$this->data['session_name'].'_params']);
	 */
	// 可以刪了我
	//if(!isset($_SESSION[$this->data['session_name'].'_params'])){
	//	$_SESSION[$this->data['session_name'].'_params'] = array();
	//}

	// 為了向下(舊的)支援
	$this->data['editmode'] = false;

	//$_SESSION[$this->data['session_name']] = array();

	// 當現在正在修改模式的時候，如果換網址，就會關掉修改模式
	//if(!isset($_SESSION['layoutv2_current_editmode'])){
	//	$_SESSION['layoutv2_current_editmode'] = $layout_v2_name;
	//}

	//if($_SESSION['layoutv2_current_editmode'] != '' and $_SESSION['layoutv2_current_editmode'] != $layout_v2_name){
	//	$this->data['editmode'] = false;
	//	$_SESSION[$this->data['session_name'].'_edit'] = false;
	//	unset($_SESSION[$this->data['session_name']]);
	//	unset($_SESSION['layoutv2_current_editmode']);
	//}

	if(isset($_GET['clearscss']) and $_GET['clearscss'] == '1' and isset($this->data['admin_id']) and $this->data['admin_id'] != ''){ // 清除類別暫存
		// 會做兩件事，清除區塊的scss暫存，以及會通知母版清除css的暫存，因為重編譯要3秒多
		@unlink(tmp_path.'/scss_config.php');
		$opts = array('http'=>array('header'=>array('Referer: '.FRONTEND_DOMAIN."\r\n")));
		$context = stream_context_create($opts);
		file_get_contents(FRONTEND_LAYOUTV2.'/html/a/css/style.css?clearonly=',false,$context);
		$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
		die;
		//$this->data[$this->data['layout_v2_name'].'_editmode'] = true;
	} elseif(isset($_GET['clearcategoryx']) and $_GET['clearcategoryx'] == '1'  and isset($_SESSION[$this->data['session_name'].'_edit']) and $_SESSION[$this->data['session_name'].'_edit']){ // 清除類別暫存
		array_map('unlink', glob(tmp_path.'/layoutv2_category*'));
		$this->data[$this->data['layout_v2_name'].'_editmode'] = true;
	//} elseif(isset($_GET['savecore']) and $_GET['savecore'] == '1' and isset($this->data['admin_id']) and $this->data['admin_id'] != ''){ // 存檔於母體
	} elseif(isset($_GET['savecore']) and $_GET['savecore'] == '1' and isset($_SESSION[$this->data['session_name'].'_edit']) and $_SESSION[$this->data['session_name'].'_edit']){ // 存檔於母體
		file_put_contents($layout_v2_file, '<'.'?'.'php $layouts = '.var_export($_SESSION[$this->data['session_name']], true).';');
		$this->data[$this->data['layout_v2_name'].'_editmode'] = true;
	//} elseif(isset($_GET['save']) and $_GET['save'] == '1' and isset($this->data['admin_id']) and $this->data['admin_id'] != ''){ // 存檔於本地
	} elseif(isset($_GET['save']) and $_GET['save'] == '1' and isset($_SESSION[$this->data['session_name'].'_edit']) and $_SESSION[$this->data['session_name'].'_edit']){ // 存檔於本地
		$layout_v2_file = Yii::getPathOfAlias('application').'/controllers/layoutv2/layout_'.$layout_v2_name.'.php';
		file_put_contents($layout_v2_file, '<'.'?'.'php $layouts = '.var_export($_SESSION[$this->data['session_name']], true).';');
		$this->data[$this->data['layout_v2_name'].'_editmode'] = true;
	} elseif(isset($_GET['edit']) and $_GET['edit'] == '1' and isset($this->data['admin_id']) and $this->data['admin_id'] != ''){
		/*
		 * 這裡的功能由後台的layoutv2pagelist所取代
		 */
		$this->data[$this->data['layout_v2_name'].'_editmode'] = true;
		$_SESSION[$this->data['session_name'].'_edit'] = true;

		// 為了要讓帶引數的內頁也能夠被編輯
		$tmp = $_GET;
		if($tmp){
			unset($tmp['edit']); // 編輯模式
			unset($tmp['classtype']); // 編輯模式
			unset($tmp['r']); // yii
		}
		$_SESSION[$this->data['session_name'].'_params'] = $tmp;
	} elseif(isset($_GET['edit']) and $_GET['edit'] == '0') {
		$this->data[$this->data['layout_v2_name'].'_editmode'] = false;
		$_SESSION[$this->data['session_name'].'_edit'] = false;
		$params = $_SESSION[$this->data['session_name'].'_params'];
		unset($_SESSION[$this->data['session_name'].'_params']);
		$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$params));
		die;
	} elseif(isset($_SESSION[$this->data['session_name'].'_edit']) and $_SESSION[$this->data['session_name'].'_edit']){
		/*
		 * 就是這裡，會記錄該頁面是否是編輯模式
		 * 當後台點了修改模式，這裡將會是第一現場
		 */
		$this->data[$this->data['layout_v2_name'].'_editmode'] = true;
		//$this->data['layoutv2_current_editmode'] = $layout_v2_name;
	} else {
		$_SESSION[$this->data['session_name'].'_edit'] = false;
	}

	//var_dump($_SESSION[$this->data['session_name']]);
	//die;
	
	// 為了讓後台可以觸發前台開啟修改模式
	/*
	 * 當後台點了修改模式，這裡將會是第二現場
	 */
	if(isset($this->data[$layout_v2_name.'_editmode']) 
		and $this->data[$layout_v2_name.'_editmode'] 
		and !isset($_SESSION[$this->data['session_name'].'_params'])
	){
		// 為了要讓帶引數的內頁也能夠被編輯
		$tmp = $_GET;
		if($tmp){
			unset($tmp['edit']); // 編輯模式
			unset($tmp['classtype']); // 編輯模式
			unset($tmp['r']); // yii
		}
		$_SESSION[$this->data['session_name'].'_params'] = $tmp;
	}

	$this->data['has_top'] = false;
	if(isset($_SESSION[$this->data['session_name']]) and count($_SESSION[$this->data['session_name']]) > 0){
		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			if(preg_match('/^Bbox_full_top/', $v['type'])){
				$this->data['has_top'] = true;
			}
		}
	}

	// 載入view進來，讓工具列顯示它
	//$this->data['views'] = array();
	//if($this->data[$this->data['layout_v2_name'].'_editmode'] == true){
	//	$allfiles = $this->_getFiles(Yii::getPathOfAlias('application').'/views/layoutv2');
	//	if($allfiles){
	//		foreach($allfiles as $k => $v){
	//			$tmp = str_replace(Yii::getPathOfAlias('application').'/views/layoutv2/', '', $v);
	//			if(preg_match('/^view_/', $tmp)){
	//				$this->data['views'][] = $tmp;
	//			}
	//		}
	//	}
	//}

	if(0){
		var_dump($_SESSION[$this->data['session_name']]);
	}

	//if(isset($_SESSION[$this->data['session_name']]) and count($_SESSION[$this->data['session_name']]) > 0){
	//} else {
	//	include $layout_v2_file;
	//	if(isset($layouts) and $this->data['editmode'] == true){
	//		$_SESSION[$this->data['session_name']] = $layouts;
	//	}
	//}

	// 測試 2015-11-19
	// 第一次不是Render頁面，而是直接進修改模式，會造成沒載入的情況，這裡試著測試以及修正
	if($this->data[$this->data['layout_v2_name'].'_editmode'] == true and !isset($_SESSION[$this->data['session_name']])){
		include $layout_v2_file;
		if(isset($layouts)){
			$_SESSION[$this->data['session_name']] = $layouts;
		}
	}

	// 無論如何，都會載入實體檔案
	// 只有編輯模式被打開的時候才不會載入
	if($this->data[$this->data['layout_v2_name'].'_editmode'] == false){
		include $layout_v2_file;
		if(isset($layouts)){
			$_SESSION[$this->data['session_name']] = $layouts;
		}
	} else {
		// 載入樹狀tree，從後台copy來的
		$this->data['render_tree'] = array();

		$rows = array();

		if(isset($_SESSION[$this->data['session_name']])){
			$rows = $_SESSION[$this->data['session_name']];
		}

		$tree = new Tree();
		$bbb = array();
		$current_row = array();
		$rows_ids = array();
		$bigid = 99999;
		// 先找一下現在這筆的pid，等一下要判斷該層
		//if(isset($params['value'][0]) and $rows){
		//	foreach($rows as $k => $v){
		//		$rows_ids[] = $v['id'];
		//		if($params['value'][0] == $v['id']){
		//			$current_row = $v;
		//		}
		//	}
		//	// 只是為了要知道最大的編號而以
		//	sort($rows_ids);

		//	$bigid = $rows_ids[count($rows_ids)-1] + 1;
		//}

		//var_dump($rows);
		//die;

		//$rows[-1] = array(
		//	'type' => 'Bbox',
		//	'pid' => '0',
		//	'pos' => '1',
		//	'other' => '',
		//	'other2' => '',
		//);

		if($rows){
			foreach($rows as $k => $v){
				// 等一下才會用得到
				$v['more'] = '';
				$v['add'] = '';

				// 即時預覽在使用的
				$v['id'] = $k;

				$tmp = $_SESSION[$this->data['session_name'].'_params'];
				unset($tmp['key']);

				//$v['menu_url'] = $this->createUrl($this->data['router_class'].'/update')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'];
				$v['menu_url'] = $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$tmp+array('pos'=>$v['pos'],'key'=>''));

				// 沒有頂層的，就規類在某個地方
				//if(!isset($rows[$v['pid']]) and $v['pid'] != 0){
				//	$v['pid'] == -1;
				//}

				// 要轉換一下
				$v['parentid'] = $v['pid'];

				// 指出現在修改的這筆
				$v['current'] = '';
				$v['current2'] = '';
				if(isset($_GET['key']) and $k == $_GET['key']){
					//$v['current'] = ' <span style="color:red;">&larr;目前</span>';
					$v['current2'] = 'background-color:#a1cc8a;';
				}

				// 指出現在修改的這層
				$v['current_pid'] = '';
				$v['current_pid2'] = '';
				//if(isset($params['value'][0]) and isset($current_row['id']) and $v['id'] == $current_row['pid']){
				//	//$v['current_pid'] = ' <span style="color:red;">(*)</span>';
				//	$v['current_pid2'] = 'background-color:#ecebdb;';
				//}

				if($v['pid'] == 0){
					//$v['add'] = '<a href="'.$this->createUrl($this->data['router_class'].'/create')."&param=".$param_define['prev'].$params['prev'].'-'.$param_define['value'].$v['id'].'"><img class="imgalign" src="'.$this->assetsUrl.$this->data['template_path'].'/images/icons/add.png'.'" /></a>';
					$v['add'] = '';
				}

				//Debug
				//$v['name'] = '123';

				//$bbb[$v['id']] = $v;

				//$v['name'] = $v['type'].' ('.$k.')';
				//$v['name'] = '[ '.$layoutv2classtype_tmp[$layoutv2class_all_tmp[$v['type']]['class_id']]['topic'].' ]　'.$layoutv2class_all_tmp[$v['type']]['topic'].' ('.$k.')';

				// 沒有這樣子改的話，Bbox_in_3c的分類欄位會出問題，不要問我為什麼
				$v['name'] = '';
				if(isset($layoutv2class_all_tmp[$v['type']]['class_id']) and isset($layoutv2classtype_tmp[$layoutv2class_all_tmp[$v['type']]['class_id']]['topic'])){
					$v['name'] .= '[ '.$layoutv2classtype_tmp[$layoutv2class_all_tmp[$v['type']]['class_id']]['topic'].' ]　';
				}

				if(isset($layoutv2class_all_tmp[$v['type']]['topic'])){
					$v['name'] .= $layoutv2class_all_tmp[$v['type']]['topic'];
				}

				/*
				 * 模組的個案，先暫時這樣子寫
				 */

				if($v['type'] == 'view_1_layer_div'){
					if($v['tag'] != 'div'){
						$v['name'] .= ' ('.$v['tag'].')';
					}
				} elseif($v['type'] == 'view_bbox'){
					$tmp01 = $v;
					$type = '';
					if(isset($tmp01['data_type']) and $tmp01['data_type'] == 1){
						if(isset($tmp01['data_1']) and $tmp01['data_1'] == '1'){
							$type = 'Bbox';
						} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '2'){
							$type = 'Bbox_1c';
						} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '3'){
							$type = 'Bbox_full';
						} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '4'){
							$type = 'Bbox_full_1c';
						} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '5'){
							$type = 'Bbox_full_top';
						} elseif(isset($tmp01['data_1']) and $tmp01['data_1'] == '6'){
							$type = 'Bbox_full_bottom';
						}
					} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 2){
						if(isset($tmp01['data_2']) and $tmp01['data_2'] > 0){
							$type = 'Bbox_in_'.$tmp01['data_2'].'c';
						}
					} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 3){
						if(isset($tmp01['data_3']) and $tmp01['data_3'] > 0){
							$type = 'Bbox_in_2c_L'.$tmp01['data_3'];
						}
					} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 4){
						if(isset($tmp01['data_4']) and $tmp01['data_4'] > 0
							and isset($tmp01['data_4_2']) and $tmp01['data_4_2'] > 0
						){
							$type = 'Bbox_sin_'.$tmp01['data_4'].'_'.$tmp01['data_4_2'];
							if($tmp01['data_4_2'] <= 11){
								$type .= (string)(12 - $tmp01['data_4_2']);
							}
						}
					} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 5){
						if(isset($tmp01['data_5']) and $tmp01['data_5'] > 0){
							$type = 'Bbox_sin_'.$tmp01['data_5'].'c_1c';
						}
					} elseif(isset($tmp01['data_type']) and $tmp01['data_type'] == 6){
						if(isset($tmp01['data_6']) and $tmp01['data_6'] > 0
							and isset($tmp01['data_6_2']) and $tmp01['data_6_2'] > 0
						){
							$type = 'Bbox_sin_'.$tmp01['data_6'].'c_2cL'.$tmp01['data_6_2'];

							if(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 2){
								$type .= '_xs1c';
							} elseif(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 3){
								$type .= '_xs2c';
							} elseif(isset($tmp01['data_6_3']) and $tmp01['data_6_3'] == 4){
								$type .= '_xs3c';
							}

							if(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 2){
								$type .= '_sm1c';
							} elseif(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 3){
								$type .= '_sm2c';
							} elseif(isset($tmp01['data_6_4']) and $tmp01['data_6_4'] == 4){
								$type .= '_sm3c';
							}

							if(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 2){
								$type .= '_md1c';
							} elseif(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 3){
								$type .= '_md2c';
							} elseif(isset($tmp01['data_6_5']) and $tmp01['data_6_5'] == 4){
								$type .= '_md3c';
							}

						}
					}
					if($type != ''){
						$v['name'] .= ' '.$type;
					}
				} // view_bbox

				if(isset($layoutv2class_all_tmp[$v['type']]['topic'])){
					$v['name'] .= ' ('.$k.')';
				}

				$bbb[$k] = $v;

			}

			// 如果有編號，而且現在是在新增的狀態，那就加一項新增中
			//if(isset($params['value'][0]) and $this->data['router_method'] == 'create' and $current_row['pid'] == 0){
			//	$bbb[$bigid] = array(
			//		'id' => $bigid,
			//		'parentid' => $current_row['id'],
			//		'name' => '<span style="color:red;">新增中</span>',
			//		'menu_url' => '#',
			//		'current' => '',
			//		'current2' => '',
			//		'current_pid' => '',
			//		'current_pid2' => '',
			//		'more' => '',
			//		'add' => '',
			//	);
			//	// 當在root底下新增child的時候，root會變成"在上層"，而不是"在當層"，以新增child的角度來看
			//	//$bbb[$current_row['id']]['current'] = '<span style="color:red;">(*)</span>';
			//	$bbb[$current_row['id']]['current2'] = 'background-color:#a1cc8a;';

			//	// 只是預留而以
			//	$bigid++;
			//}
		}

		// 如果總筆數到達40筆的時候，顯示方式改成只顯示本層
		if(count($bbb) > 39 and 0){
			$xid = '';
			if(isset($current_row['pid']) and $current_row['pid'] == 0){
				$xid = $current_row['id'];
			} elseif(isset($current_row['pid'])){
				$xid = $current_row['pid'];
			}
			foreach($bbb as $k => $v){
				if(isset($v['pid']) and $v['pid'] != 0 and $v['pid'] != $xid and isset($bbb[$v['pid']])){
					// 刪掉前，先把最上層加上點點點，代表裡面有東西
					$bbb[$v['pid']]['more'] = '&nbsp;<span style="color:red;">...</span>';

					// 把不是那層的東西底下的都刪掉
					unset($bbb[$k]);
					continue;
				}
			}
			//if(isset($xid)){
			//}
		}

		// 因為換回原本舊的Tree Class，所以特地加上這一段
		foreach($bbb as $k => $v){
			if(!isset($v['parentid'])){
				$v['parentid'] = 0;
			}
			$v['parent_id'] = $v['parentid']; // 轉換一下，因為Tree class的運算是用parent_id這個欄位名稱
			$bbb[$k] = $v;
		}

		//if(isset($_GET['key']) and $_GET['key'] != ''){
		//	$tree->init($bbb, $_GET['key'], $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']+array('pos'=>'1','key'=>'')));
		//} else {
		//	$tree->init($bbb,'', $this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']+array('pos'=>'1','key'=>'')));
		//}

		$tree->init($bbb);

		$str = "<div style='\$current2\$current_pid2'>\$spacer <a class='layoutv2demosection' key2='\$id' href='\$menu_url\$id'>\$name</a> \$add \$current \$current_pid \$more </div>";
		$this->data['render_tree'] = $tree->get_tree('0', $str);

		//$str = "<a class='layoutv2demosection' key2='\$id' href='\$menu_url\$id'>\$name</a>";
		//$this->data['render_tree'] = $tree->get_treeview_layoutv2('0', '', $str);

		//if(!isset($params['value'][0]) and $this->data['router_method'] == 'create'){
		//	$this->data['render_tree'] .= '<span style="color:red;">(新增中)</span><br />';
		//}

		// 樹狀結束

	} // editmode false

	if($this->data[$this->data['layout_v2_name'].'_editmode'] and isset($_SESSION[$this->data['session_name'].'_only_tree']) and $_SESSION[$this->data['session_name'].'_only_tree'] == '1'){
		// do nothing
	} else {
		$layout_v2_data = Yii::getPathOfAlias('application').'/controllers/layoutv2/data_'.$layout_v2_name.'.php';

		if(file_exists(Yii::getPathOfAlias('application.controllers.layoutv2').'/data_'.$layout_v2_name.'.php')){
			$layout_v2_data = Yii::getPathOfAlias('application').'/controllers/layoutv2/data_'.$layout_v2_name.'.php';
		} else {
			$layout_v2_data = Yii::getPathOfAlias('system.frontend.controllers.layoutv2').'/data_'.$layout_v2_name.'.php';
		}

		if(file_exists($layout_v2_data)){
			include $layout_v2_data;
		}
	}

	/*
	資料結構定義：

	// 這是一個Section
	array(
		type => x, 什麼Section
		pid => x, 上層是誰
		pos => x, 上層的哪一個坑 
		attr1~6 => x, 什麼屬性，可能先建，後設定
	),
	 */

	//include Yii::getPathOfAlias('application').'/controllers/layout_v2/sections.php';

	/*
	 * 測試結構如下
	 * Bbox
	 *  └ Bbox
	 *     └ Bbox_in_2c_L3
	 *        * Bbox 
	 *        * Bbox
	 * Bbox_in_2c_L3
	 *  * Bbox
	 *  * Bbox
	 */
	// $_SESSION[$this->data['session_name']] = array(
	// 	1 => array(
	// 		'type' => 'Bbox',
	// 		'pid' => 0,
	// 		'pos' => 0,
	// 	),
	// 	2 => array(
	// 		'type' => 'Bbox',
	// 		'pid' => 1,
	// 		'pos' => 1,
	// 	),
	// 	3 => array(
	// 		'type' => 'Bbox_in_2c_L3',
	// 		'pid' => 2,
	// 		'pos' => 1,
	// 	),
	// 	4 => array(
	// 		'type' => 'Bbox',
	// 		'pid' => 3,
	// 		'pos' => 1,
	// 	),
	// 	5 => array(
	// 		'type' => 'Bbox',
	// 		'pid' => 3,
	// 		'pos' => 2,
	// 	),
	// 	6 => array(
	// 		'type' => 'Bbox_in_2c_L3',
	// 		'pid' => 0,
	// 		'pos' => 0,
	// 	),
	// 	7 => array(
	// 		'type' => 'Bbox',
	// 		'pid' => 6,
	// 		'pos' => 1,
	// 	),
	// 	8 => array(
	// 		'type' => 'Bbox',
	// 		'pid' => 6,
	// 		'pos' => 2,
	// 	),
	// 
	// );

	if(!empty($_GET)){
		if(isset($_GET['clear']) and $_GET['clear'] == '1'){
			unset($_SESSION[$this->data['session_name']]);
			$_SESSION[$this->data['session_name'].'_params'] = array();
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
			//header('Location: index.php');
			die;
		} elseif(isset($_GET['delme']) and $_GET['delme'] != ''){
			unset($_SESSION[$this->data['session_name']][$_GET['delme']]);
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
			//header('Location: index.php');
			die;
		} elseif(isset($_GET['only_tree']) and $_GET['only_tree'] != ''){
			$_SESSION[$this->data['session_name'].'_only_tree'] = $_GET['only_tree'];
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
			die;
		} elseif(isset($_GET['need_point']) and $_GET['need_point'] != ''){
			$_SESSION[$this->data['session_name'].'_need_point'] = $_GET['need_point'];
			$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
			die;
		} else {
			// do nothing 因為後面的section，有可能會接收GET參數
		}
	}

	// 如果沒有root，那就把整個清空
	$has_root = false;
	if(isset($_SESSION[$this->data['session_name']]) and count($_SESSION[$this->data['session_name']]) > 0){
		foreach($_SESSION[$this->data['session_name']] as $k => $v){
			if($v['pid'] == 0){
				$has_root = true;
				break;
			}
		}
	}
	if(!$has_root){
		$_SESSION[$this->data['session_name']] = array();
	}


	if(!empty($_POST) and isset($this->data[$this->data['layout_v2_name'].'_editmode']) and $this->data[$this->data['layout_v2_name'].'_editmode'] == true){
		$post = $_POST;
		//var_dump($post);
		//die;

		$other = '';
		if(isset($post['other']) and count($post['other']) > 0){
			$other = implode(',', $post['other']);
		}

		// 因為有些後續的動作，例如建立一個以上的div
		$has_end = true;

		// 當整個是清空、是新的情況下，這個動作只會執行一次，因為也是新增，當然也會繼續執行下面的動作
		if(count($_SESSION[$this->data['session_name']]) == 0){
			$_SESSION[$this->data['session_name']][1] = array(
				'tag' => $post['tag'],
				'type' => $post['class'],
				'pid' => $post['key'],
				'pos' => $post['pos'],
				'other' => $other,
				'other2' => $post['other2'],
			);
		} else {
			if(isset($post['switch']) and $post['switch'] != ''){
				$this->switch_key($post['key'], $post['switch']);
				$has_end = false;
			} elseif(isset($post['move']) and $post['move'] != ''){
				$this->move_key($post['key'], $post['move']);
				$has_end = false;
			// 修改的時候
			} elseif(isset($post['is_update']) and $post['is_update'] == '1'){
				$_SESSION[$this->data['session_name']][$post['key']]['pos'] = $post['pos'];

				if(isset($post['pid']) and $post['pid'] != ''){
					$_SESSION[$this->data['session_name']][$post['key']]['pid'] = $post['pid'];
				}

				$_SESSION[$this->data['session_name']][$post['key']]['tag'] = $post['tag'];
				$_SESSION[$this->data['session_name']][$post['key']]['type'] = $post['class'];
				$_SESSION[$this->data['session_name']][$post['key']]['other'] = $other;
				$_SESSION[$this->data['session_name']][$post['key']]['other2'] = $post['other2'];
				$has_end = false;
			// 新增的時候
			} else {
				if($post['direction'] == 'inner'){
					$_SESSION[$this->data['session_name']][] = array(
						'tag' => $post['tag'],
						'type' => $post['class'],
						'pid' => $post['key'],
						'pos' => $post['pos'],
						'other' => $other,
						'other2' => $post['other2'],
					);
				} else {
					$_SESSION[$this->data['session_name']][] = array(
						'tag' => $post['tag'],
						'type' => $post['class'],
						// 跟上層的一樣
						'pid' => $_SESSION[$this->data['session_name']][$post['key']]['pid'],
						'pos' => $_SESSION[$this->data['session_name']][$post['key']]['pos'],
						'other' => $other,
						'other2' => $_SESSION[$this->data['session_name']][$post['key']]['other2'],
					);
				}
			} // switch
		}

		// 目前是新增的情況才會來到這裡
		if($has_end){

			// 取得剛才新增的元素key值
			end($_SESSION[$this->data['session_name']]);
			$new_key = key($_SESSION[$this->data['session_name']]);
			reset($_SESSION[$this->data['session_name']]);

			// 如果是，要順便建兩個DIV(固定)
			if(preg_match('/^Bbox_in_(\d)c_L(\d+)$/', $post['class']) OR preg_match('/sin/', $post['class'])){ // 例：Bbox_in_2c_L3
				$_SESSION[$this->data['session_name']][] = array(
					'tag' => 'div',
					'type' => 'view_1_layer_div',
					'pid' => $new_key,
					'pos' => '1',
					'other' => '',
					'other2' => '',
				);
				$_SESSION[$this->data['session_name']][] = array(
					'tag' => 'div',
					'type' => 'view_1_layer_div',
					'pid' => $new_key,
					'pos' => '1',
					'other' => '',
					'other2' => '',
				);
			
			// 至少一個DIV
			} elseif(preg_match('/1c/', $post['class']) OR preg_match('/^Bbox_in_(\d)c(_xs3|)$/', $post['class'])){
				$_SESSION[$this->data['session_name']][] = array(
					'tag' => 'div',
					'type' => 'view_1_layer_div',
					'pid' => $new_key,
					'pos' => '1',
					'other' => '',
					'other2' => '',
				);
			// 要建10個土
			} elseif(preg_match('/^layout___(.*)$/', $post['class'], $matches)){

				// 為了要讓hole和connect雙向做參考值
				//$_SESSION[$this->data['session_name']][$new_key]['other2'] = 'p1_'.$this->data['router_class'].'/'.$this->data['router_method'];

				for($x=1;$x<=10;$x++){
					$_SESSION[$this->data['session_name']][] = array(
						// tag忽略
						'type' => 'layout_connect_'.$x,
						'pid' => $new_key,
						'pos' => '1',
						'other' => '',
						'other2' => '',
						//'other2' => 'p1_'.$matches[1],
					);
				}

			//} elseif(preg_match('/^layout_hole_(.*)$/', $post['class'], $matches)){
			//	// 為了要讓hole和connect雙向做參考值
			//	$_SESSION[$this->data['session_name']][$new_key]['other2'] = 'p1_'.$this->data['router_class'].'/'.$this->data['router_method'];

			} elseif(preg_match('/^group___(.*)___(.*)$/', $post['class'], $matches)){

				// 為了要讓hole和connect雙向做參考值
				//$_SESSION[$this->data['session_name']][$new_key]['other2'] = 'p1_'.$this->data['router_class'].'/'.$this->data['router_method'];

				for($x=1;$x<=5;$x++){
					$_SESSION[$this->data['session_name']][] = array(
						// tag忽略
						'type' => 'group_connect_'.$x,
						'pid' => $new_key,
						'pos' => '1',
						'other' => '',
						'other2' => 'p1_'.$matches[1].'|'.$matches[2],
					);
				}

			} elseif(preg_match('/^group_hole_(.*)$/', $post['class'], $matches)){
				// 為了要讓hole和connect雙向做參考值
				$_SESSION[$this->data['session_name']][$new_key]['other2'] = 'p1_'.$this->data['router_class'].'/'.$this->data['router_method'].'|';

			} // preg_match
		} // has_end

		/* POST擴充
		 *
		 * 為了可以轉移更多的程式碼過去區塊
		 * 為了讓區塊的功能性更強大
		 *
		 * 可用的變數
		 *  $post['key'],
		 *  $post['switch'],
		 *  $post['is_update'],
		 *  $post['direction'],
		 *  $post['tag'],
		 *  $post['class'],
		 *  $post['key'],
		 *  $post['pos'],
		 *  $post['other_handle'],
		 *  $post['other2'],
		 */
		if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/'.$post['class'].'.php')){
			$file = Yii::getPathOfAlias('application.views.layoutv2').'/'.$post['class'].'.php';
		} else {
			$file = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/'.$post['class'].'.php';
		}
		if(file_exists($file)){
			$tmp = file_get_contents($file);
			if(preg_match('/tag_editmode_post_end/', $tmp)){
				$post['other_handle'] = $other; // 把先前處理的欄位回存，讓後續的程式也可能使用

				// 這一段是複製過來的
				$post['other2'] = trim($post['other2']);
				if($post['other2'] != ''){
					$other2_tmp = explode(' ', $post['other2']);
					foreach($other2_tmp as $k => $v){
						if(preg_match('/^p(\d+)_(.*)$/', $v, $matches)){
							$this->data['layoutv2_param'][$post['key']][$matches[1]] = $matches[2];
							unset($other2_tmp[$k]);
						}
					}
					$post['layoutv2_param'] = implode(' ', $other2_tmp);
				}


				$this->data['tag_editmode_post_end'] = $post;
				include $file;
			}
		}

		$this->redirect($this->createUrl($this->data['router_class'].'/'.$this->data['router_method'],$_SESSION[$this->data['session_name'].'_params']));
		//header('Location: index.php');
		die;
	} // POST

	if(0){
		var_dump($_SESSION[$this->data['session_name']]);
	}

	ob_start();
	//$this->renderPartial('//layoutv2/toolbar', $this->data);

	// 固定存放在這裡，這裡也是遞迴跑的位置
	$this->renderPartial('system.frontend.views.layoutv2.toolbar', $this->data);
	$_content = ob_get_contents();
	ob_end_clean();

	if(file_exists(Yii::getPathOfAlias('application.views.layoutv2').'/main.php')){
		$layout_v2_main = Yii::getPathOfAlias('application').'/views/layoutv2/main.php';
	} else {
		$layout_v2_main = Yii::getPathOfAlias('system.frontend.views.layoutv2').'/main.php';
	}
	if(empty($_POST)){
		include $layout_v2_main;
	}

	// SCSS
	if(isset($this->data[$this->data['layout_v2_name'].'_editmode']) and $this->data[$this->data['layout_v2_name'].'_editmode'] == true
		and isset($this->data['scss_configs']) and count($this->data['scss_configs']) > 0
	){
		$tmp01 = array();
		if(file_exists(tmp_path.'/scss_config.php')){
			$tmp = file_get_contents(tmp_path.'/scss_config.php');
			$tmps = explode("\n", $tmp);
			unset($tmps[count($tmps)-1]); // 移除最後一行
			eval('?'.'>'.$tmp); // $tmp01
		}
		foreach($this->data['scss_configs'] as $k => $v){
			$tmp01[$k] = $v;
		}
		file_put_contents(tmp_path.'/scss_config.php', '<'.'?'.'php '."\n".'$tmp01 = '.var_export($tmp01,true).';'."\n"."echo '\$tmp01 = '.var_export(\$tmp01, true).';';");
	}

	//$layout_v2_main = Yii::getPathOfAlias('application').'/views/layoutv2/main.php';
	//include $layout_v2_main;

	//die;
}
