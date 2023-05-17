<?php

if(isset($this->data['mls']) and !empty($this->data['mls'])){
	$tmp = array();			
	foreach($this->data['mls'] as $kk => $vv){

		// SEO
		// unset($_constant);
		// eval('$_constant = '.strtoupper('seo_open').';');
		// if($_constant == 1 and $kk == 'en'){ // 這個值是非預設語系
		// 	$tmp[] = array(
		// 		'name' => 'English',
		// 		'url' => 'en/',
		// 	);
		// 	continue;
		// }

		$tmp2 = array(
			'name' => $vv['name'],
			//'url' => 'change_language.php?lang='.$kk,
			'url' => $url_prefix.'index_'.$kk.'.php',
		);

		if($url_suffix == ''){
			$tmp2['url'] = str_replace('_'.$kk,'',$tmp2['url']);
		}

		// SEO
		// if($kk == 'en'){
		// 	$tmp2['url'] = '/';
		// } else {
		// 	$tmp2['url'] = '/tw/';
		// }

		unset($_constant);
		eval('$_constant = SIMPLE_TRANSLATE;');
		if($_constant == 1 and $kk == 'tw'){ //繁簡切換
			$tmp2['url'] = 'change_language.php?tw_cn=1&lang=tw';
		}

		// 2018-07-05 加入後台更改特定網址 by lota
		if(isset($vv['change_url']) && $vv['change_url']!=''){
			$tmp2['url'] = $vv['change_url'];
		}

		// 2019-10-23 加入後台設定另開視窗 by lota
		if(isset($vv['target']) && $vv['target']!=''){
			$tmp2['anchor_open'] = 'target=\''.$vv['target'].'\'';
		}

		$tmp[] = $tmp2;

		unset($_constant);
		eval('$_constant = SIMPLE_TRANSLATE;');
		if($_constant == 1 and $kk == 'tw'){ //繁簡切換
			$tmp[] = array(
				'name' => '简体中文',
				'url' => 'change_language.php?tw_cn=1&lang=cn',
			);
		}

	}

	// $result[$k]['child'] = $tmp;

	// 2019-10-14
	// if(isset($ID)){
	// 	$data[$ID] = $tmp;
	// }

	//    // 這個可以撰寫當下語系的協助判斷，這個範例是有自己的ICON，所以才這樣子做
	//    // 另一個地方是在change_language.php裡面
	//    $result[$k]['name'] = '<img src=images/en/icon-earth.png>'.strtoupper($this->data['ml_key']);
	//    if(isset($_COOKIE['targetEncoding']) and $_COOKIE['targetEncoding'] == 2){
	//    	$result[$k]['name'] = '<img src=images/en/icon-earth.png>CN';
	//    	$result[$k]['icon'] = '';
	//    }
	//    if(preg_match('/_lang=(.*)$/', $_SERVER['REQUEST_URI'], $matches)){
	//    	if($matches[1] == 'tw'){
	//    		$result[$k]['name'] = '<img src=images/en/icon-earth.png>TW';
	//    		$result[$k]['icon'] = '';
	//    	} elseif($matches[1] == 'cn'){
	//    		$result[$k]['name'] = '<img src=images/en/icon-earth.png>CN';
	//    		$result[$k]['icon'] = '';
	//    	}
	//    }
}
