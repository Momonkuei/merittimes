<?php

// 這支檔案名稱要改，因為ajax.php要給app使用

include 'layoutv3/init.php';
include 'layoutv3/libs.php';

$row = $_REQUEST;
if(!isset($row['func'])) die;

// 修正非主語系的手機選單，變成主語系選單的問題
// 還有view/widget/mb_panel.php也要記得修
// http://redmine.buyersline.com.tw:4000/issues/22769
//if(isset($row['langu']) and $row['langu'] != ''){
//	$this->data['ml_key'] = $row['langu'];
//}

if($row['func'] == 'mb_panel'){

	// 手機選單
	$panel = array(
		'mbPanelDataSet'=> array(
			// data - navTop
			'navTop'=>array(
				'type'=>'listLink', 
				'content'=> array(

					// 這個是要放在LOGO左邊的按鈕，通常都是購物車
					// 0 => array('content'=>'<i class="fa fa-shopping-cart"></i><span>(等一下這裡會被覆寫)</span>', 'link'=>'#_', 'class'=>'openBtn', 'target'=>'.sideCart'),
					0 => array('content'=>'<i class="ICON"></i><span>(SAMPLE)</span>', 'link'=>'', 'class'=>'', 'target'=>''),

					// 這兩個是固定的
					1 => array('content'=>'<img src="images/'.$this->data['ml_key'].'/logo.png">', 'link'=>'index_'.$this->data['ml_key'].'.php', 'class'=>'logo', 'target'=>''),                        
					2 => array('content'=>'<i class="fa fa-bars"></i>', 'link'=>'#_', 'class'=>'showPanel', 'target'=>'#mbPanel_navMenu'),                        
				)
			),

			// data - navBottom
			'navBottom'=>array( 
				'type'=>'listLink',  
				'content'=> array(
					//    array('content'=>'<i class="fa fa-search"></i><span>搜尋</span>', 'link'=>'#link', 'class'=>'openBtn', 'target'=>'#searchForm'),
					//    array('content'=>'<i class="fa fa-heart"></i><span>收藏 (12)</span>', 'link'=>'favorite.php', 'class'=>'', 'target'=>''),
					//    array('content'=>'<i class="fa fa-sign-in"></i><span>登入/註冊</span>', 'link'=>'member.php?type=login', 'class'=>'', 'target'=>''),
					//    // array('content'=>'<i class="fa fa-search"></i><span>搜尋</span>', 'link'=>'#link', 'class'=>'openBtn', 'target'=>'#searchForm'),
					//    array('content'=>'<i class="fa fa-globe"></i><span>Language</span>', 'link'=>'#_', 'class'=>'showPanel', 'target'=>'#mbPanel_NavSubMenu'),
				)
			),

			// data - navBottomSubMenu
			// 語系
			'navSubMenu'=>array( 
				'type'=>'multiMenu',  
				'content'=> array(
					array('content'=>'Language','link'=>'#_','class'=>'closePanel mainCloseBtn','target'=>'#mbPanel_navMenu','submenu'=>''),
					//array('content'=>'1', 'link'=>'', 'class'=>'', 'target'=>'','submenu'=>''),
					//array('content'=>'2', 'link'=>'', 'class'=>'', 'target'=>'','submenu'=>''),
					//array('content'=>'3', 'link'=>'', 'class'=>'', 'target'=>'','submenu'=>''),
				)
			),


			// 主選單
			'navMenuData'=>array(
				'type'=>'multiMenu',
				'content'=> array(
					array('content'=>'Menu','link'=>'#_','class'=>'closePanel mainCloseBtn','target'=>'#mbPanel_navMenu','submenu'=>''),
					//$mbPanelnavMenu[0],
					//$mbPanelnavMenu[1],
					//$mbPanelnavMenu[2],
					//$mbPanelnavMenu[3],
					//$mbPanelnavMenu[4],
					//$mbPanelnavMenu[5],
				),


			),

		),

		// create panel
		'mbPanelSet'=>array(
			'effect' => 'mbPanel_effect01',
			'panels' => array(
				array(
					'type'=>'funNav',
					'pos'=>'navTop',
					'id'=>'',
					'content'=>array(
						'data'=>'navTop'
					)
				),
				array(
					'type'=>'funNav',
					'pos'=>'navBottom',
					'id'=>'',
					'content'=>array(
						'data'=>'navBottom'
					)
				),
				array(
					'type'=>'side',
					'pos'=>'mbPanel_left',
					'id'=>'mbPanel_navMenu',
					'content'=>array(
						'id'=>'panelMenu01',
						'type'=>'panelMenu',
						'style'=>array(),
						'data'=>'navMenuData',
					)
				),

				array(
					'type'=>'side',
					'pos'=>'mbPanel_left NavSubMenu',
					'id'=>'mbPanel_NavSubMenu',
					'content'=>array(
						'type'=>'panelMenu',
						'style'=>array(),
						'data'=>'navSubMenu',
					)
				),
			),

		),
	);

	foreach($this->data['mls'] as $k => $v){
		$panel['mbPanelDataSet']['navSubMenu']['content'][] = array(
			'content'=>$v, 
			'link'=>'change_language.php?lang='.$k, 
			'class'=>'', 
			'target'=>'',
			'submenu'=>''
		);

		unset($_constant);
		eval('$_constant = SIMPLE_TRANSLATE;');
		if($_constant == 1 and $k == 'tw'){ //繁簡切換
			$panel['mbPanelDataSet']['navSubMenu']['content'][count($panel['mbPanelDataSet']['navSubMenu']['content'])-1]['link'] = 'change_language.php?tw_cn=1&lang=tw';
			$panel['mbPanelDataSet']['navSubMenu']['content'][] = array(
				'content'=>'简体中文', 
				'link'=>'change_language.php?tw_cn=1&lang=cn', 
				'class'=>'', 
				'target'=>'',
				'submenu'=>''
			);
		}
	}

	if(!isset($_SESSION['save']['shop_car'])) $_SESSION['save']['shop_car'] = array();
	$car_amount = count($_SESSION['save']['shop_car']);
	if($car_amount < 0){
		$car_amount = 0;
	}

	foreach(array('top','bottom') as $kkkg => $kkka){
		unset($result);
		unset($_position);
		$_position = $kkka;
		include 'source/top_link_menu/v1.php';
		if($result and count($result) > 0){
			foreach($result as $k => $v){
				$v['content'] = $v['icon'].'<span>'.$v['name'].' </span>'; // 2017-10-31 name後面那個空白，如果不加的話，有些情況會讓圖示出不來
				$v['link'] = $v['url'];

				// 為了支援top選單裡面的浮起來的選單，以及class樣式
				if(isset($v['anchor_open']) and trim($v['anchor_open']) != ''){
					$tmp2 = explode(' ', trim($v['anchor_open']));
					if($tmp2 and count($tmp2) > 0){
						foreach($tmp2 as $kk => $vv){
							if(preg_match('/^class\=\'(.*)\'$/', $vv, $matches)){
								$v['class'] = $matches[1];
							} elseif(preg_match('/^data\-target\=\'(.*)\'$/', $vv, $matches)){
								$v['target'] = $matches[1];
							}
						}
					}
				}

				if($v['func'] == 'search'){
					$v['class'] = 'openBtn';
					$v['target'] = '#searchForm';
					$v['link'] = '#link';
				} elseif($v['func'] == 'language'){
					$v['class'] = 'showPanel';
					$v['target'] = '#mbPanel_NavSubMenu';
					$v['link'] = '#_';
				}

				if($kkka == 'top'){
					if($v['func'] == 'shop'){
						$v['class'] = 'openBtn';
						$v['target'] = '.sideCart';

						// 要記得，上面己經有重改content的元素內容了，所以這裡不用在加上圖示icon
						//$v['content'] = str_replace('購物車 ','',$v['content']);
						//$v['content'] = str_replace('Shopping Car ','',$v['content']);
					}
					// if(preg_match('/\<span\>(.*)\<\/span\>/', $v['content'],$matches)){
					// 		$v['content'] = str_replace($matches[1],'',$v['content']);
					// 	}
					// }
					if(preg_match('/^(shop)$/', $v['func'])){ // 有括號和數字的放這裡面，目前只有購物車
						// <i class="fa fa-shopping-cart"></i><span>購物車 (<span id="car_amount">0</span>)</span>
						if(preg_match('/\<span\>(.*)\ \(/', $v['content'], $matches)){ // shop在用的
							$v['content'] = str_replace($matches[1],'',$v['content']);
						}
					} else {
						if(preg_match('/\<span\>(.*)\<\/span\>/', $v['content'], $matches)){
							$v['content'] = str_replace($matches[1],'',$v['content']);
						}
					}
					$panel['mbPanelDataSet']['navTop']['content'][0] = $v;
					break; // 因為上方只會需要一筆，所以處理完直接跳出
				} else {
					$panel['mbPanelDataSet']['navBottom']['content'][] = $v;
				}
			}
		} else {
			if($kkka == 'top'){
				$panel['mbPanelDataSet']['navTop']['content'][0]['content'] = '';
			}
		}
	}

	$_position = 'mobile';
	include 'source/menu/v1.php';
	// array('content'=>'Menu','link'=>'#_','class'=>'closePanel mainCloseBtn','target'=>'#mbPanel_navMenu','submenu'=>''),
	foreach($tmp as $k => $v){
		$v['content'] = $v['topic'];
		$v['link'] = $v['url'];
		$v['target'] = '';
		$v['class'] = '';
		if(isset($v['anchor_class'])) $v['class'] = $v['anchor_class'];
		if(isset($v['anchor_data_target'])) $v['target'] = $v['anchor_data_target'];
		$v['submenu'] = array();
		if(isset($v['child']) and count($v['child']) > 0){
			$v['link'] = '#_';
			foreach($v['child'] as $kk => $vv){
				$gg = array();
				$gg['content'] = $vv['name'];
				//2017/6/6 有些子站會出現 找不到$vv['url']變數的提示，會影響json的格式，這邊做簡易的判斷 by lota
				if(isset($vv['url'])) {
					$gg['link'] = $vv['url'];
				}else{
					$gg['link'] = '';
				}
				$gg['target'] = '';
				$gg['class'] = '';
				if(isset($vv['anchor_class'])) $gg['class'] = $vv['anchor_class'];
				if(isset($vv['anchor_data_target'])) $gg['target'] = $vv['anchor_data_target'];
				$gg['submenu'] = array();
				if(isset($vv['child']) and count($vv['child']) > 0){ // 第三層，通常是寬版的最後一層
					$vv['link'] = '#_';
					foreach($vv['child'] as $kkk => $vvv){
						$aa = array();
						$aa['content'] = $vvv['name'];
						$aa['link'] = $vvv['url'];
						$aa['target'] = '';
						$aa['class'] = '';
						if(isset($vvv['anchor_class'])) $aa['class'] = $vvv['anchor_class'];
						if(isset($vvv['anchor_data_target'])) $aa['target'] = $vvv['anchor_data_target'];
						$aa['submenu'] = array();
						$gg['submenu'][] = $aa;
					}
				}
				$v['submenu'][] = $gg;
			}
		}
		$panel['mbPanelDataSet']['navMenuData']['content'][] = $v;
	}
	unset($tmp);

	// var_dump($panel);die;

	header("Content-type: text/javascript");
	echo json_encode(array('mbPanel'=>$panel));
} // $row['func']

die;
