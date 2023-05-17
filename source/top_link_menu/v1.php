<?php

$position = '1'; // top
if(isset($_position) and $_position != ''){
	if($_position == 'bottom'){
		$position = '2';
	}
}

// 手機版
// array("content"=>"<i class='fa fa-globe'></i><span>翻譯<div class='' id='google_translate_element'></div></span>", "link"=>"#_", "class"=>"google_translate_element", "target"=>""),

// 本層編號
// echo $ID;

// 本層檔案名稱
// echo $layoutv3_struct_map[$ID];

// 找上一層
if(isset($ID)){
	$tmp = explode('-', $ID);
	$last_id = $tmp[count($tmp)-1]; // 因為header4的第一個是四個，第二個是左邊兩個，第四個是右邊兩個
	unset($tmp[count($tmp)-1]);
	$prev_layout_name = $layoutv3_struct_map[implode('-', $tmp)];
}

$car_amount = 0;
$favorite_amount = 0;

// 如果是第三步驟，而且己經是最後的結帳頁，那就不顯示購物車和收藏的數量(特例)
if(isset($_SESSION['save']['step3']['go_to_finish!!']) and $_SESSION['save']['step3']['go_to_finish!!'] == '1'){
	// do nothing
} else {
	// 購物車
	if(!isset($_SESSION['save']['shop_car'])) $_SESSION['save']['shop_car'] = array();
	$car_amount = count($_SESSION['save']['shop_car']);
	if($car_amount < 0){
		$car_amount = 0;
	}

	// 收藏
	// 可用產品暫存 2021-04-14 by lota
	$_tmp = $this->cidb->where('ml_key',$this->data['ml_key'])->where('is_enable','1')->get('shop')->result_array(); 
	$_tmp_product = array();
	foreach($_tmp as $key => $value){
		$_tmp_product[$value['id']] = 1;
	}
	$favorite_amount = 0;
	if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
		$condition = array(
			'type' => 'favorite',
			'is_enable' => '1',
			'ml_key' => $this->data['ml_key'],
			'member_id' => $this->data['admin_id'],
		);
		$tmps = $this->cidb->where($condition)->get('html')->result_array(); 
		//判斷產品是否存在 2021-04-14 by lota
		foreach($tmps as $key => $value){
			if(!isset($_tmp_product[$value['other1']])){
				unset($tmps[$key]);
			}		
		}
		$favorite_amount = count($tmps);
	} else {
		if(!isset($_SESSION['save']['shop_favorite'])) $_SESSION['save']['shop_favorite'] = array();
		$favorite_amount = count($_SESSION['save']['shop_favorite']);
		if($favorite_amount < 0){
			$favorite_amount = 0;
		}
	}
}

$tops = array();

// 這裡打算寫外部程式來操控它，用不到就把它註解掉或是刪掉
// if($this->data['ml_key'] == 'tw'){
// 	// 因為開環境的程式，會在上面Append陣列
// 	if(!isset($tops)){
// 		$tops = array(
// 			array('func' => 'productinquiry',   'name' => '詢問車', 'url' => 'productinquiry_tw.php', 'icon' => '<i class="fa fa-info-circle"></i>'),
// 			// array('func' => 'addr', 'name' => '公司地址', 'url' => 'https://goo.gl/maps/Evf2hX4QPm42', 'icon' => '<i class="fa fa-map-marker"></i>', 'anchor_open' => ' target="_blank" ' ),
// 			// array('func' => '', 'name' => '電話', 'url' => 'tel:04-0000000', 'icon' => '<i class="fa fa-phone"></i>', 'anchor_open' => '' ),
// 			// array('func' => 'medialogin', 'name' => 'change Password', 'url' => 'media.php', 'icon' => '<i class="fa fa-user"></i>'),
// 			// array('func' => 'share',    'name' => '分享', 'url' => 'share.php', 'icon' => '<i class="fa fa-share-alt"></i>'),
// 			array('func' => 'contact',  'name' => '聯絡我們', 'url' => 'contact_tw.php', 'icon' => '<i class="fa fa-envelope"></i>'),
// 			array('func' => 'search',   'name' => '搜尋', 'url' => 'product_tw.php', 'icon' => '<i class="fa fa-search"></i>', 'anchor_open' => ' class=\'openBtn\' data-target=\'#searchForm\' ',  'anchor_close' => ' class="closeBtn" data-target="#searchForm" '),
// 			// array('func' => 'googlesearch',   'name' => 'Google搜尋', 'url' => 'javascript:;', 'icon' => '<i class="fa fa-search"></i>', 'anchor_open' => ' class=\'openBtn\' data-target=\'#cse_searchForm\' ',  'anchor_close' => ' class="closeBtn" data-target="#cse_searchForm" '),
// 			// array('func' => 'language_google', 'name' => '翻譯<div class="googleTranslate" id="google_translate_element_g"></div>', 'url' => 'javascript:;', 'icon' => '<i class="fa fa-globe"></i>'),
// 			// array('func' => 'shop',   'name' => '購物車 (<span id="car_amount">'.$car_amount.'</span>)', 'url' => 'javascript:;', 'anchor_open' => ' class=\'openBtn\' data-target=\'.sideCart\' ', 'icon' => '<i class="fa fa-shopping-cart"></i>'),
// 			// array('func' => 'favorite', 'name' => '收藏 (<span id="favorite_amount">'.$favorite_amount.'</span>)', 'url' => 'favorite_tw.php', 'icon' => '<i class="fa fa-heart"></i>'),
// 			array('func' => 'language', 'name' => 'Language', 'url' => 'javascript:;', 'icon' => '<i class="fa fa-globe"></i>'),
// 			// array('func' => 'member', 'name' => '下麵會改變這裡的名稱', 'url' => 'javascript:;', 'icon' => '<i class="fa fa-user"></i>'),
// 		);
// 	}
// } else {
// 	// 因為開環境的程式，會在上面Append陣列
// 	if(!isset($tops)){
// 		$tops = array(
// 			array('func' => 'productinquiry',   'name' => 'Product Inquiry', 'url' => 'productinquiry_en.php', 'icon' => '<i class="fa fa-info-circle"></i>'),
// 			// array('func' => 'addr', 'name' => 'Company Address', 'url' => 'https://goo.gl/maps/Evf2hX4QPm42', 'icon' => '<i class="fa fa-map-marker"></i>', 'anchor_open' => ' target="_blank" ' ),
// 			// array('func' => '', 'name' => 'Phone', 'url' => 'tel:04-0000000', 'icon' => '<i class="fa fa-phone"></i>', 'anchor_open' => '' ),
// 			// array('func' => 'medialogin', 'name' => 'change Password', 'url' => 'media.php', 'icon' => '<i class="fa fa-user"></i>'),
// 			// array('func' => 'share',    'name' => 'Share', 'url' => 'share.php', 'icon' => '<i class="fa fa-share-alt"></i>'),
// 			array('func' => 'contact',  'name' => 'Contact us', 'url' => 'contact_en.php', 'icon' => '<i class="fa fa-envelope"></i>'),
// 			array('func' => 'search',   'name' => 'Search', 'url' => 'product_en.php', 'icon' => '<i class="fa fa-search"></i>', 'anchor_open' => ' class=\'openBtn\' data-target=\'.searchForm\' ',  'anchor_close' => ' class="closeBtn" data-target=".searchForm" '),
// 			// array('func' => 'googlesearch',   'name' => 'Google Search', 'url' => 'javascript:;', 'icon' => '<i class="fa fa-search"></i>', 'anchor_open' => ' class=\'openBtn\' data-target=\'#cse_searchForm\' ',  'anchor_close' => ' class="closeBtn" data-target="#cse_searchForm" '),
// 			// array('func' => 'language_google', 'name' => 'Translate<div class="googleTranslate" id="google_translate_element_g"></div>', 'url' => 'javascript:;', 'icon' => '<i class="fa fa-globe"></i>'),
// 			// array('func' => 'shop',   'name' => 'Shopping Car (<span id="car_amount">'.$car_amount.'</span>)', 'url' => 'javascript:;', 'anchor_open' => ' class=\'openBtn\' data-target=\'.sideCart\' ', 'icon' => '<i class="fa fa-shopping-cart"></i>'),
// 			// array('func' => 'favorite', 'name' => 'Favorite (<span id="favorite_amount">'.$favorite_amount.'</span>)', 'url' => 'favorite_en.php', 'icon' => '<i class="fa fa-heart"></i>'),
// 			array('func' => 'language', 'name' => 'Language', 'url' => 'javascript:;', 'icon' => '<i class="fa fa-globe"></i>'),
// 			// array('func' => 'member', 'name' => '下麵會改變這裡的名稱', 'url' => 'javascript:;', 'icon' => '夏面會改變這個圖示，登入前後都不一樣'),
// 		);
// 	}
// }

// 2017-12-06 dom4 hack 為了支援無限層的條件
if(isset($tops) and !empty($tops)){
	foreach($tops as $k => $v){
		if(!isset($v['id'])){
			$v['id'] = $k;
		}
		if(!isset($v['pid'])){
			$v['pid'] = 0;
		}
		$tops[$k] = $v;
	}
}

if(isset($_position) and $_position != ''){
	// http://redmine.buyersline.com.tw:4000/issues/18231#note-35
	// 看看有沒有啟用手機版選單功能，並且選擇位置
	$tops2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and ( field_tmp like "%,4,%" and field_tmp like "%,'.$position.',%" )',array(':type'=>'webmenusub',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	// 沒有的話，就使用預設C方案規則，也就是第一筆是左上角，其它在下面
	// if(!$tops2 or count($tops2) <= 0){
	// 	$tops2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and field_tmp like "%,4,%"',array(':type'=>'webmenusub',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
	// }
} else {
	$tops2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and field_tmp like "%,3,%"',array(':type'=>'webmenusub',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
}

if($tops2 and !empty($tops2)){
	foreach($tops2 as $k => $v){
		$v['func'] = $v['other1'];

		$v['name'] = $v['topic'];
		$v['name'] = str_replace('$car_amount', $car_amount, $v['name']);
		$v['name'] = str_replace('$favorite_amount', $favorite_amount, $v['name']);

		if(preg_match('/^(http|\#|javascript\:\;)/', $v['url1'])){
			$v['url'] = $v['url1'];
		} else {
			$v['url'] = $url_prefix.$v['url1'];
			if($main_ml_key != '' and $this->data['ml_key'] != $main_ml_key){
				$v['url'] = str_replace('_'.$this->data['ml_key'].'.php',$url_suffix,$v['url']);
			}
		}

		// 2020-12-03 這個元素，到手機版那邊也會使用和判斷
		$v['anchor_open'] = $v['other2'];

		// 2020-12-03
		// v4手機版在使用的
		if(isset($v['anchor_open']) and $v['anchor_open'] != '' and LAYOUTV3_THEME_NAME == 'v4' and preg_match('/class=\'openBtn\'\ data-target=\'(.*)\'/', $v['anchor_open'], $matches)){
			$v['anchor_open'] = 'data-fancybox data-src=\''.$matches[1].'\'';

			// 手機版使用
			$v['other'] = $v['anchor_open'];
		}

		$v['icon'] = ''; // 2017-08-18 winnie發現的
		if($v['other3'] != ''){
			$v['icon'] = '<i class="'.$v['other3'].'"></i>';
		}

		// 2020-02-25
		$v['content2'] = $v['other4'];

		$tops2[$k] = $v;
	}
}
// 有資料的話，才會指定
if($tops2 and !empty($tops2)){
	$tops = $tops2;
}

if($tops and !empty($tops)){
	foreach($tops as $k => $v){
		// 動態網址 2017-09-20有跟李哥討論過
		// if($v['func'] == 'contact'){
		//  	// if($this->data['router_method'] != 'contact' and isset($ID)){
		//  	// 	$_SESSION['save']['contact_dynamic_url'] = substr(md5(microtime()),rand(0,26),15);
		//  	// 	$_SESSION['save']['contact_dynamic_url_handled'] = true;
		//  	// } 
		//  	if(isset($_SESSION['save']['contact_dynamic_url'])){
		//  		$v['url'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
		//  	}
		// } elseif($v['func'] == 'search'){
		if($v['func'] == 'search'){
			// $view_file = 'v3/widget/search_form';
			// if(isset($layoutv3_struct_map_keyname[$view_file][0])){
			// 	$data[$layoutv3_struct_map_keyname[$view_file][0]] = $v;
			// }
			$page_source_data_param1 = 'widget-search_form';
			$page_source_data_param2 = $v;
			include _BASEPATH.'/../source/system/page_source_data.php';
		}

		// 動態網址 (第2版) 2018-03-26 李哥下午說OK，可以做
		if(isset($_dynamic_url)){
			foreach($_dynamic_url as $kk => $vv){
				if($v['func'] == $vv){
					// if($this->data['router_method'] != 'contact' and isset($ID)){
					// 	$_SESSION['save']['contact_dynamic_url'] = substr(md5(microtime()),rand(0,26),15);
					// 	$_SESSION['save']['contact_dynamic_url_handled'] = true;
					// } 
					if(isset($_SESSION['save'][$vv.'_dynamic_url'])){
						$v['url'] = $vv.'/'.$_SESSION['save'][$vv.'_dynamic_url'].'.html';
					}
				}
			}
		}

		$tops[$k] = $v;
	}
}

$result = array();

if($tops and !empty($tops)){
	foreach($tops as $k => $v){
		$result[$k] = $v;
		if($v['func'] == 'member'){
			// var_dump($v);die;
			if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0){
				$result[$k]['url'] = 'membercenter_'.$this->data['ml_key'].'.php';
				if($this->data['ml_key'] == 'tw'){
					$result[$k]['name'] = '會員中心';
				} else {
					$result[$k]['name'] = 'Member';
				}
				$result[$k]['icon'] = '<i class="'.$v['other3'].'"></i>';
			} else {
				$result[$k]['url'] = 'guestlogin_'.$this->data['ml_key'].'.php';
				if($this->data['ml_key'] == 'tw'){
					$result[$k]['name'] = '登入/註冊';
				} else {
					$result[$k]['name'] = 'Login/Register';
				}
				// $result[$k]['icon'] = '<i class="fa fa-sign-in"></i>';
				$result[$k]['icon'] = '<i class="'.$v['other3'].'"></i>';
			}
		} elseif($v['func'] == 'language'){
			$tmp = array();
			include _BASEPATH.'/../source/core/mls.php';
			$result[$k]['child'] = $tmp;

			// if(isset($this->data['mls']) and count($this->data['mls']) > 0){
			// 	$tmp = array();			
			// 	foreach($this->data['mls'] as $kk => $vv){

			// 		// SEO
			// 		// unset($_constant);
			// 		// eval('$_constant = '.strtoupper('seo_open').';');
			// 		// if($_constant == 1 and $kk == 'en'){ // 這個值是非預設語系
			// 		// 	$tmp[] = array(
			// 		// 		'name' => 'English',
			// 		// 		'url' => 'en/',
			// 		// 	);
			// 		// 	continue;
			// 		// }

			// 		$tmp2 = array(
			// 			'name' => $vv['name'],
			// 			//'url' => 'change_language.php?lang='.$kk,
			// 			'url' => $url_prefix.'index_'.$kk.'.php',
			// 		);

			// 		if($url_suffix == ''){
			// 			$tmp2['url'] = str_replace('_'.$kk,'',$tmp2['url']);
			// 		}

			// 		// SEO
			// 		// if($kk == 'en'){
			// 		// 	$tmp2['url'] = '/';
			// 		// } else {
			// 		// 	$tmp2['url'] = '/tw/';
			// 		// }

			// 		unset($_constant);
			// 		eval('$_constant = SIMPLE_TRANSLATE;');
			// 		if($_constant == 1 and $kk == 'tw'){ //繁簡切換
			// 			$tmp2['url'] = 'change_language.php?tw_cn=1&lang=tw';
			// 		}

			// 		//2018-07-05 加入後台更改特定網址 by lota
			// 		if(isset($vv['change_url']) && $vv['change_url']!=''){
			// 			$tmp2['url'] = $vv['change_url'];
			// 		}

			// 		$tmp[] = $tmp2;

			// 		unset($_constant);
			// 		eval('$_constant = SIMPLE_TRANSLATE;');
			// 		if($_constant == 1 and $kk == 'tw'){ //繁簡切換
			// 			$tmp[] = array(
			// 				'name' => '简体中文',
			// 				'url' => 'change_language.php?tw_cn=1&lang=cn',
			// 			);
			// 		}

			// 	}

			// 	$result[$k]['child'] = $tmp;

			// 	//    // 這個可以撰寫當下語系的協助判斷，這個範例是有自己的ICON，所以才這樣子做
			// 	//    // 另一個地方是在change_language.php裡面
			// 	//    $result[$k]['name'] = '<img src=images/en/icon-earth.png>'.strtoupper($this->data['ml_key']);
			// 	//    if(isset($_COOKIE['targetEncoding']) and $_COOKIE['targetEncoding'] == 2){
			// 	//    	$result[$k]['name'] = '<img src=images/en/icon-earth.png>CN';
			// 	//    	$result[$k]['icon'] = '';
			// 	//    }
			// 	//    if(preg_match('/_lang=(.*)$/', $_SERVER['REQUEST_URI'], $matches)){
			// 	//    	if($matches[1] == 'tw'){
			// 	//    		$result[$k]['name'] = '<img src=images/en/icon-earth.png>TW';
			// 	//    		$result[$k]['icon'] = '';
			// 	//    	} elseif($matches[1] == 'cn'){
			// 	//    		$result[$k]['name'] = '<img src=images/en/icon-earth.png>CN';
			// 	//    		$result[$k]['icon'] = '';
			// 	//    	}
			// 	//    }
			// }
		} elseif($v['func'] == 'language_google'){ // 2020-03-27 Ruby建議
			$result[$k]['class'] = 'language_google';
		}

		// 反正就是最多五個，乖哥說的
		// if($k == 4) break;
	}
}

// 2020-01-15 
// 把副功能列的部份，改成用V1第二版去套
if($result and !empty($result)){
	foreach($result as $k => $item){
		// 這裡是從source/menu/v2.php那邊複製過來的
		// 把屬性都處理好了，在顯示在頁面上
		// LI的屬性，輸出前準備
		$attr1 = '';
		$classes = array();
		if(isset($item['child']) and !empty($item['child'])){
			$classes[] = 'moreMenu';
		}
		if(isset($item['class']) and $item['class'] != ''){
			$classes[] = $item['class'];
		}
		if(!empty($classes)){
			$attr1 .= ' class="'.implode(' ', $classes).'" ';
		}
		if(isset($item['id'])){
			$attr1 .= ' id="navlight_toplinkmenu_'.$item['id'].'" ';
		}
		$item['attr1'] = $attr1;

		// 把屬性都處理好了，在顯示在頁面上
		// Anchor的屬性，輸出前準備
		$attr2 = '';
		if(isset($item['target']) and $item['target'] != ''){
			$attr2 .= ' target="'.$item['target'].'" ';
		}
		if(isset($item['anchor_class']) and $item['anchor_class'] != ''){
			$attr2 .= ' class="'.$item['anchor_class'].'" ';
		}
		if(isset($item['anchor_data_target']) and $item['anchor_data_target'] != ''){
			$attr2 .= ' data-target="'.$item['anchor_data_target'].'" ';
		}
		if(isset($item['anchor_open']) and $item['anchor_open'] != ''){ // 2020-02-05
			$attr2 .= ' '.$item['anchor_open'].' ';
		}
		if(isset($item['url'])){
			$attr2 .= ' href="'.$item['url'].'" ';
		}
		$item['attr2'] = $attr2;

		if(isset($item['child']) and !empty($item['child'])){
			foreach($item['child'] as $kk => $item2){
				$attr1 = '';
				$classes = array();
				if(isset($item2['class']) and $item2['class'] != ''){
					$classes[] = $item2['class'];
				}
				if(!empty($classes)){
					$attr1 .= ' class="'.implode(' ', $classes).'" ';
				}
				$item2['attr1'] = $attr1;

				// 把屬性都處理好了，在顯示在頁面上
				// Anchor的屬性，輸出前準備
				$attr2 = '';
				if(isset($item2['target']) and $item2['target'] != ''){
					$attr2 .= ' target="'.$item2['target'].'" ';
				}
				if(isset($item2['anchor_class']) and $item2['anchor_class'] != ''){
					$attr2 .= ' class="'.$item2['anchor_class'].'" ';
				}
				if(isset($item2['anchor_data_target']) and $item2['anchor_data_target'] != ''){
					$attr2 .= ' data-target="'.$item2['anchor_data_target'].'" ';
				}
				if(isset($item2['url'])){
					$attr2 .= ' href="'.$item2['url'].'" ';
				}
				$item2['attr2'] = $attr2;

				$item['child'][$kk] = $item2;
			}
		}

		$result[$k] = $item;
	}
}

$rows = $result; // 2020-01-15 為了讓新功能可以接續使用
if(isset($ID)){
	$data[$ID] = $result;
}

// if(isset($ID)){
// 	if(preg_match('/(header1|header2|header3|header6)/', $prev_layout_name)){
// 		$data[$ID] = $result;
// 	} elseif(preg_match('/(header4|header5)/', $prev_layout_name)){
// 		/*
// 		 * @last_id int 位置編號
// 		 *
// 		 * group/header4 
// 		 *	　└ 位置  0  header/top_link_menu' // 縮小 (顯示4個)
// 		 *	　└ 位置 (1) header/top_link_menu' // 左邊 (顯示2個)
// 		 *	　└ 位置  2  header/brand_logo'
// 		 *	　└ 位置 (3) header/top_link_menu' // 右邊 (顯示另外2個)
// 		 *	　└ 位置  4  header/hamburger'
// 		 *	　└ 位置  5  header/nav_menu2'
// 		 *	　└ 位置  6  home/banner1'
// 		 *	　└ 位置  7  header/nav_menu2'
// 		 *
// 		 * 因為header4和header5的第一個是四個，第二個是左邊兩個，第四個是右邊兩個
// 		 */
// 		if($last_id == 0){
// 			$data[$ID] = $result;
// 		} elseif($last_id == 1){ // 如果是左手邊
// 			if(isset($result[0])) $data[$ID][0] = $result[0];
// 			if(isset($result[1])) $data[$ID][1] = $result[1];
// 		} elseif($last_id == 3){ // 如果是右手邊
// 			if(isset($result[2])) $data[$ID][2] = $result[2];
// 			if(isset($result[3])) $data[$ID][3] = $result[3];
// 		}
// 	}
// }
