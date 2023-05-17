<?php

// 2020-05-26 單選轉複選
// if($_SERVER['REMOTE_ADDR'] == '192.168.0.128'){
// 	$rows = $this->cidb->where('class_id >',0)->get('product')->result_array();
// 
// 	if($rows and !empty($rows)){
// 		foreach($rows as $k => $v){
// 			$this->cidb->where('id', $v['id']);
// 			$this->cidb->update('product', array('class_ids'=>','.$v['class_id'].',')); 
// 		}
// 	}
// 	die;
// }

// var_dump($_SESSION['save']['redips_table']);

// http://justcoding.iteye.com/blog/2049127 禁止該網站被內嵌到其他網站內 by lota
// header("X-Frame-Options: deny");
// header("X-XSS-Protection: 0");


// 簡易安全機制，正式上線後再移除
// @session_start();
// $tmp = explode('.', $_SERVER['HTTP_HOST']);
// if(($tmp[1] == 'web' or $tmp[1] == 'web2') and $tmp[2] == 'buyersline'){	
// }else{
// 	if(!isset($_SESSION['_lang_demo'])){
// 		header('Location: lang_demo.php');
// 		die;
// 	}	
// }

//修正index_XX.php 轉 index.php 的判斷錯誤 2018-11-29 by lota
//if($this->data['router_method']=='parent' or $this->data['router_method']=='parentindex'){
//	$this->data['router_method'] = 'index';
//}
//進入非班級頁面刪除班級session
if(!stristr($this->data['router_method'],'class_')){
	for($i=1;$i<=11;$i++){
		if(!empty($_SESSION['class_'.$i])){
			unset($_SESSION['class_'.$i]);
		}
	}
	
}
//即時Demo保護機制
@session_start();
$tmp = explode('.', $_SERVER['HTTP_HOST']);
if($tmp[1] == 'show' and $tmp[2] == 'buyersline'){	
	if(!isset($_SESSION['login_id']) or $_SESSION['login_id'] <= 0){
		header('Location: login.php');
		die;
	}
}

//上線後，如果部分語系還沒上線，記得從這邊打開語系鎖密碼頁面
if(0 and $this->data['ml_key']=='en'){
	@session_start();
	if ($_SESSION['enter'] !== true){
		?>
		 <script language="javascript">
        location.href='login_demo.php';
        </script>           
        <?php
		exit;
	}
}

// 安全性
// 2019-11-04 李哥建議，原本是寫在source/core/breadcrumbs.php，為了整體架構，所以改寫在這裡
if(isset($_GET['id']) && !preg_match('/^s(\d+)$/', $_GET['id'])){ //2021-06-04 排除主題活動特定的ID型態
	$_GET['id'] = intval($_GET['id']);
}

// 為了後續程式碼撰寫的簡潔
$pageRecordInfo = array();

// Dirty Hack winnie template
$imgPath = 'images/w01/'.$this->data['ml_key'].'/';

include _BASEPATH.'/../source/core_seo.php';

// 2019-12-23 移到cig_frontend/init.php的object裡面的最上面，因為這個檔案會被移動位置執行
// 後來決定不移動了，不過變數的部份，我還是想移到更上層
// $data = array();

if(isset($this->data['sys_configs']['admin_title_'.$this->data['ml_key']]) and $this->data['sys_configs']['admin_title_'.$this->data['ml_key']] != ''){
	$data['head_title'] = $this->data['sys_configs']['admin_title_'.$this->data['ml_key']];
} else {
	if(isset($this->data['sys_configs']['admin_title']) and $this->data['sys_configs']['admin_title'] != ''){
		$data['head_title'] = $this->data['sys_configs']['admin_title'];
	}
}

//通用常數判斷 by lota
//FB G+  外部oauth是否開放
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('member_open').';');
$data['external_member'] = $_constant_1;
//判斷是否有優惠券
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_coupon').';');
$data['shop_show_coupon'] = $_constant_1;
//判斷是否有紅利
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_dividend').';');
$data['shop_show_dividend'] = $_constant_1;
//判斷是否顯示購物車加購商品
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_purchase').';');
$data['shop_show_purchase'] = $_constant_1;
//判斷是否有電子發票
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_show_electronic_invoice').';');
$data['shop_show_electronic_invoice'] = $_constant_1;
//判斷是否產品內頁顯示相關產品
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('shop_related_products').';');
$data['shop_related_products'] = $_constant_1;

//2022-01-10 V4 圖片預設比例 by lota
unset($_constant_1);
eval('$_constant_1 = '.strtoupper('image_ratio').';');
$data['image_ratio'] = $_constant_1;



//儲存美安訂單的RID及Click_ID
if( isset($this->data['MarketAn']) && $this->data['MarketAn']['is_enable'] == 1 ){
	if( !empty($_GET["RID"]) && !empty($_GET["Click_ID"]) ){
		$_SESSION["RID"] = $_GET["RID"];
		$_SESSION["Click_ID"] = $_GET["Click_ID"];
	}
}

/*
 * 從layoutv2的share.php複製過來的
 */

// 中間 麵包屑，
// $path1 = substr($this->createUrl('site/'.str_replace('detail','',$this->data['router_method'])),1);
//$path1 = 'index.php?r='.$this->data['router_class'].'/'.str_replace('detail','',$this->data['router_method']);

$path1 = $this->data['router_method'];
$path1 = str_replace('detail','',$path1);
$path1 = str_replace('show','',$path1); // Lota 2017-10-31

// 編排頁網址(第三版)
$paths = explode('_',$path1);
$path1 = $paths[0];

$path1 .= '_'.$this->data['ml_key']; // Ming 2017-05-17

// 編排頁(第一版)
// $path1 = str_replace('_1','',$path1);
// $path1 = str_replace('_2','',$path1);
// $path1 = str_replace('_3','',$path1);
// $path1 = str_replace('_4','',$path1);

// 編排頁網址(第二版)
// $path1 = str_replace('_'.$this->data['ml_key'].'_'.$this->data['ml_key'],'_'.$this->data['ml_key'],$path1); //2017/9/1 lota add 
// $path1 = str_replace('_'.$this->data['ml_key'].'_1','',$path1);
// $path1 = str_replace('_'.$this->data['ml_key'].'_2','',$path1);
// $path1 = str_replace('_'.$this->data['ml_key'].'_3','',$path1);
// $path1 = str_replace('_'.$this->data['ml_key'].'_4','',$path1);

$path1 = $path1.'.php';

//if(($this->data['router_method']=='product' || $this->data['router_method']=='productdetail') && !isset($_GET['RCL']) && PRODUCT_SEARCH) $path1 .='&RCL=1';
//if(isset($_GET['RCL']) && PRODUCT_SEARCH) $path1 .='&RCL='.$_GET['RCL'];

// lota版
// $bread_path = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and url1=:url',array(':type'=>'webmenu',':url'=>$path1))->order('sort_id')->queryRow();

// 2018-05-15
// 檢查有沒有重覆的網址
// 為了不要產出異常的func_name_id
// (啟用)
$checks = $this->cidb->select('id')->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$path1)->get('html')->result_array();
$has_url_repeat_enable = false;
if(count($checks) > 1){
	$has_url_repeat_enable = true;
}
// (停用)
$checks = $this->cidb->select('id')->where('is_enable',0)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$path1)->get('html')->result_array();
$has_url_repeat_disable = false;
if(count($checks) > 1){
	$has_url_repeat_disable = true;
}

// 多語版
// 主選單 / 第一種的參照方式：功能
$bread_path = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and url1=:url and ml_key=:ml_key',array(':type'=>'webmenu',':url'=>$path1,':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

// [頂層分類升級]
// 第二種的參照方式：含參數的網址
// 這裡的條件，就只會找獨立分類來處理
$this->data['webmenu_layer_up'] = array();
$rows = $this->cidb->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1 !=','')->where('is_home',1)->where('pic2','1')->where('is_news !=','1')->where('other21 !=','0')->where('other21 !=','')->order_by('sort_id','asc')->get('html')->result_array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		if($this->cidb->table_exists(str_replace('_'.$this->data['ml_key'].'.php','type',$v['url1']))){
			$table = str_replace('_'.$this->data['ml_key'].'.php','type',$v['url1']);
			$rowsg = $this->cidb->select('id,pid')->where('pid !=',0)->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id','asc')->get($table)->result_array();
			if($rowsg and count($rowsg) > 0){

				$rowsg[] = array(
					'id' => $v['other21'],
					'pid' => 0,
				);

				$indexedItems = array();

				// index elements by id
				foreach ($rowsg as $item) {
					$item['child'] = array();
					$indexedItems[$item['id']] = (object) $item;
				}

				// assign to parent
				$topLevel = array();
				foreach ($indexedItems as $item) {
					if ($item->pid == 0) {
						$topLevel[] = $item;
					} else {
						if(isset($indexedItems[$item->pid])){ // 2019-12-19 by lota
							$indexedItems[$item->pid]->child[] = $item;
						}
					}
				}
				$tree = std_class_object_to_array($topLevel);
				//var_dump($tree);die;

				// 把分類的編號抓進來
				$tree_tmps = explode("\n", var_export($tree, true));
				$ids = array();
				if($tree_tmps){
					foreach($tree_tmps as $kk => $vv){
						if(preg_match('/^(.*)\'id\'\ =>\ \'(.*)\',/', $vv, $matches)){
							$ids[] = $matches[2];
							$this->data['webmenu_layer_up'][str_replace('type','',$table)][$matches[2]] = $v['id'];
						}
					}
				}

				if($v['class_ids'] == '1'){ // 通用分項(未測試)
					$table2 = str_replace('type','',$table);
					$sql = 'select id,class_id from html where is_enable=1 and type="'.$table2.'" and class_id>0 and ml_key="'.$this->data['ml_key'].'" and class_id in ('.implode(',',$ids).');';
					$rowsg2 = $this->cidb->query($sql)->result_array();
					
					if($rowsg2 and count($rowsg2) > 0){
						foreach($rowsg2 as $kk => $vv){
							$this->data['webmenu_layer_up'][$table2.'detail'][$vv['id']] = $v['id'];
						}
					}
				} else { // 獨立分項
					$table2 = str_replace('type','',$table);
					if($this->cidb->table_exists(str_replace('type','',$table))){
						$sql = 'select id,class_id from '.$table2.' where is_enable=1 and class_id>0 and ml_key="'.$this->data['ml_key'].'" and class_id in ('.implode(',',$ids).');';
						$rowsg2 = $this->cidb->query($sql)->result_array();
						
						if($rowsg2 and count($rowsg2) > 0){
							foreach($rowsg2 as $kk => $vv){
								$this->data['webmenu_layer_up'][$table2.'detail'][$vv['id']] = $v['id'];
							}
						}
					}
				}
			}
		}
	}
} // webmenu_layer_up

// 2019-12-13 [頂層分類升級] 增加後台/前台主選單/網址做變化/其它，對於編排頁的支援
$rows = $this->cidb->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('other3','9')->where('other16 !=','')->order_by('sort_id','asc')->get('html')->result_array();
if($rows and !empty($rows)){
	foreach($rows as $k => $v){
		if(preg_match('/^(.*)\_(.*)\_(.*)\.php$/', $v['other16'], $matches)){
			$this->data['webmenu_layer_up'][$matches[1].'_'.$matches[3]] = $v['id'];
		}
	}
}

// 2019-12-13 [頂層分類升級] 增加後台/前台主選單/靜態次選單，對於裡面編排頁的支援(未測試)
$rows = $this->cidb->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('video_2 >',0)->order_by('sort_id','asc')->get('html')->result_array();
if($rows and !empty($rows)){
	$ids = array();
	$ids2 = array();
	foreach($rows as $k => $v){
		$ids[$v['video_2']] = $v['id'];
		$ids2[] = $v['video_2'];
	}

	if(!empty($ids2)){
		$rows = $this->cidb->where_in('pid',$ids2)->where('url !=','')->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->order_by('sort_id','asc')->get('webmenuchild')->result_array();
		if($rows and !empty($rows)){
			foreach($rows as $k => $v){
				if(preg_match('/^(.*)\_(.*)\_(.*)\.php$/', $v['url'], $matches) and isset($ids[$v['pid']])){
					$this->data['webmenu_layer_up'][$matches[1].'_'.$matches[3]] = $ids[$v['pid']];
				}
			}
		}
	}
}

// 正式用 
$this->data['func_name'] = '';
$this->data['func_name_id'] = 0; // 主選單亮燈用，在view/header/nav_menu那邊才會處理
$this->data['func_name_sub_id'] = 0; // 側邊選單亮燈用，在view/default/sidemenu，以及在程式source/system/general_item.php，還有編排頁用的source/core/breadcrumb，也就是有用到的那邊才會處理 2018-01-22
if(isset($bread_path['topic']) and $bread_path['topic'] != ''){
	// #32387
	// $this->data['func_name'] = L::top(null, $bread_path['topic']);//主要標題名稱
	$this->data['func_name'] = $bread_path['topic'];//主要標題名稱

	if($has_url_repeat_enable === false){
		$this->data['func_name_id'] = $bread_path['id'];
	}
	//2022-01-10 帶入圖片比例
	if($bread_path['other29']!=''){
		$data['image_ratio'] = $bread_path['other29'];
	}
}

// 這樣子編排頁的網址才會是正確的 (舊的)
// if(!preg_match('/'.$this->data['ml_key'].'/', $this->data['router_method'])){
// 	$this->data['func_name_href'] = $url_prefix.$this->data['router_method'].$url_suffix;
// } else {
// 	$this->data['func_name_href'] = $url_prefix.$this->data['router_method'].'.php';
// }

// 2018-07-02 這樣子編排頁的網址才會是正確的 (07-18 ruby發現有錯誤)
// if(preg_match('/^(.*)_(.*)$/', $this->data['router_method'], $matches)){
// 	$this->data['func_name_href'] = $url_prefix.$matches[1].'_'.$this->data['ml_key'].'_'.$matches[2].'.php';
// } else {
// 	$this->data['func_name_href'] = $url_prefix.$this->data['router_method'].$url_suffix;
// }

//unset($_constant);
//eval('$_constant = '.strtoupper('seo_open').';');
//if($_constant == 1){ // 有分類
//	if($this->data['ml_key'] == 'en'){ // 假設繁體是預設語系
//		$this->data['func_name_href'] = 'en/'.$this->data['router_method'].'.php';
//	}
//}

// 2017-08-18 早上 查理王建議的
// 如果找不到功能名稱，那就找看看那個己停用的試試
if($this->data['func_name'] == ''){
	$bread_path2 = $this->db->createCommand()->from('html')->where('is_enable=0 and type=:type and url1=:url and ml_key=:ml_key',array(':type'=>'webmenu',':url'=>$path1,':ml_key'=>$this->data['ml_key']))->queryRow();
	if(isset($bread_path2['topic']) and $bread_path2['topic'] != ''){
		// #32387
		//$this->data['func_name'] = L::top(null, $bread_path2['topic']);//主要標題名稱

		$this->data['func_name'] = $bread_path2['topic'];//主要標題名稱

		if($has_url_repeat_disable === false){
			$this->data['func_name_id'] = $bread_path2['id'];
		}
		//2022-01-10 帶入圖片比例
		if($bread_path2['other29']!=''){
			$data['image_ratio'] = $bread_path2['other29'];
		}
	}
}

// 如果還是找不到功能名稱，那就找找前台副功能列
if($this->data['func_name'] == ''){
	$bread_path3 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and url1=:url and ml_key=:ml_key',array(':type'=>'webmenusub',':url'=>$path1,':ml_key'=>$this->data['ml_key']))->queryRow();
	if(isset($bread_path3['topic']) and $bread_path3['topic'] != ''){
		// $this->data['func_name'] = L::top(null, $bread_path3['topic']);//主要標題名稱
		$this->data['func_name'] = $bread_path3['topic'];//主要標題名稱
	}
}

// 英文固定會做的事
if($this->data['ml_key'] == 'en'){
	$this->data['func_en_name'] = '';
} else {
	$this->data['func_en_name'] = '';
	if(isset($bread_path['other1']) and $bread_path['other1'] != ''){
		$this->data['func_en_name'] = $bread_path['other1']; // L::top(null, $bread_path['topic']);//第二標題名稱
	}

	// 2017-08-18 早上 查理王建議的
	if($this->data['func_en_name'] == '' and isset($bread_path2['other1']) and $bread_path2['other1'] != ''){
		$this->data['func_en_name'] = $bread_path2['other1']; // L::top(null, $bread_path['topic']);//第二標題名稱
	}
}

// 2018-05-30 李哥允許這個新功能的開發，也就是上提一層的功能
// 2019-12-13 增加網址做變化裡面的其它網址，編排頁的支援
if($this->data['func_name_id'] == 0 and isset($this->data['webmenu_layer_up'][$this->data['router_method']])){
	if(is_array($this->data['webmenu_layer_up'][$this->data['router_method']]) and isset($_GET['id']) and isset($this->data['webmenu_layer_up'][$this->data['router_method']][$_GET['id']])){
		$this->data['func_name_id'] = $this->data['webmenu_layer_up'][$this->data['router_method']][$_GET['id']];
	} elseif(isset($this->data['webmenu_layer_up'][$this->data['router_method']]) and !is_array($this->data['webmenu_layer_up'][$this->data['router_method']])) { // 2020-02-07 強將網站，在上提後，點詢問車的時候，會報錯
		$this->data['func_name_id'] = $this->data['webmenu_layer_up'][$this->data['router_method']];
	}

	$row = $this->cidb->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('id',$this->data['func_name_id'])->get('html')->row_array();
	if($row and isset($row['id'])){
		$this->data['func_name'] = $row['topic'];
	}
	$this->data['func_en_name'] = ' ';
}

// 2019-03-12
// 當上提和沒上提同時存在的時候，編號要寫改成，沒上提的那一個後台的前台主選單的編號
// if($this->data['func_name_id'] == 0 and preg_match('/^product/', $this->data['router_method'])){
// 	$this->data['func_name_id'] = 289;
// }

// 2018-12-05 沒有主選單可以亮燈的項目，可以透過這個功能，讓現有的項目亮燈
if($this->data['func_name_id'] > 0){
	$row = $this->cidb->select('id,topic')->where('is_enable',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->like('other28',','.$this->data['func_name_id'].',')->get('html')->row_array();
	if($row and isset($row['id']) and $row['id'] > 0){
		$this->data['func_name_id'] = $row['id'];
		$this->data['func_name'] = $row['topic'];
	}
}

// 動態網址 2017-09-20有跟李哥討論過
// 2017-09-21 李哥說，預設功能是開著的，底下是舊站要跟進的話，需要更新的檔案：
// 2017-09-25 Ming說，對SEO沒有影響
// 2017-10-31 李哥說，這個功能有存在的必要性
// 2017-12-01 增加rewrite規則，讓根目錄那些SEO的東西不見，同時也排除連絡我們功能的使用，這個部份都有給李哥說明過
//
// 變形驗證碼已過時，最新AI系統破解成功率高達6成 2017-10-31
// https://www.bnext.com.tw/article/46760/vicarious-ai-research-captchas?utm_source=dailyedm_bn&utm_medium=content&utm_campaign=dailyedm
//
// parent/core.php
// index.php
// source/core.php
// source/menu/v1.php
// ajax2.php
// source/contact/post.php
// source/top_link_menu/v1.php
// contact/
// if(isset($_SESSION['contact_dynamic_ignore']) and $_SESSION['contact_dynamic_ignore'] === true){ // 2017-10-23 測試中
// 	unset($_SESSION['contact_dynamic_ignore']);
// } else {
// 	if($this->data['router_method'] != 'contact'){
// 		$_SESSION['save']['contact_dynamic_url'] = substr(md5(microtime()),rand(0,26),15);
// 	}
// }
// if($this->data['router_method'] == 'contact'){
// 	if(!isset($_SESSION['save'])){
// 		$_SESSION['save'] = array();
// 	}
// 
// 	// 如果網頁停留太久，session timeout了以後，可能就會造成func_name_href那邊的出錯 2017-12-07
// 	if(!isset($_SESSION['save']['contact_dynamic_url']) ){
// 		header('Location: /');
// 		die;
// 	}
// 
// 	$this->data['func_name_href'] = 'contact/'.$_SESSION['save']['contact_dynamic_url'].'.html';
// }

// 動態網址 (第2版) 2018-03-26 李哥下午說OK，可以做
if(file_exists(_BASEPATH.'/assets/_dynamic_url.php')){
	include _BASEPATH.'/assets/_dynamic_url.php';
	if(isset($_dynamic_url) and count($_dynamic_url) > 0){
		foreach($_dynamic_url as $k => $v){
			if(isset($_SESSION[$v.'_dynamic_ignore']) and $_SESSION[$v.'_dynamic_ignore'] === true){ // 2017-10-23 測試中
				unset($_SESSION[$v.'_dynamic_ignore']);
			} else {
				// if($this->data['router_method'] != $v){ // 2018-04-30 這個在手機版選單會出問題
				if($this->data['router_method'] != $v and !isset($_SESSION['save'][$v.'_dynamic_url'])){
					$_SESSION['save'][$v.'_dynamic_url'] = 'gab'.substr(md5(microtime()),rand(0,26),15); // 2018-08-21 修正李哥所說的數字問題
				}
			}
			if($this->data['router_method'] == $v){
				if(!isset($_SESSION['save'])){
					$_SESSION['save'] = array();
				}

				// 如果網頁停留太久，session timeout了以後，可能就會造成func_name_href那邊的出錯 2017-12-07
				if(!isset($_SESSION['save'][$v.'_dynamic_url']) ){
					header('Location: /');
					die;
				}

				$this->data['func_name_href'] = $v.'/'.$_SESSION['save'][$v.'_dynamic_url'].'.html';
			}
		}
	}
}

// http://www.cnblogs.com/imxiu/p/3962386.html
if(!function_exists('round2')){
	function round2($num,$precision){
		$pow = pow(10,$precision);
		if(  (floor($num * $pow * 10) % 5 == 0) && (floor( $num * $pow * 10) == $num * $pow * 10) && (floor($num * $pow) % 2 ==0) ){//舍去位为5 && 舍去位后无数字 && 舍去位前一位是偶数    =》 不进一
			return floor($num * $pow)/$pow;
		}else{//四舍五入
			return round($num,$precision);
		}
	}
}
//echo round2(3.504501,3);

// 靜態縮圖
// http://redmine.buyersline.com.tw:4000/issues/18231?issue_count=39&issue_position=38&next_issue_id=17463&prev_issue_id=18525#note-38
// _i/cache3/members/product{ID}/member/w800h800zc3_AAA.jpg
// @path string _i/assets/GGG/AAA/BBB.jpg
// @not_null_append_path string 如果檔名不是空白，那就附加在它前面
if(!function_exists('cache3')){
	function cache3($filename,$not_null_append_path='',$width=800,$height=800){

		if($filename != '' and $not_null_append_path != ''){
			$filename = $not_null_append_path.$filename;
		}

		// 把檔名和路徑切開來
		$tmps = explode('/', $filename);
		$file = $tmps[count($tmps)-1];
		unset($tmps[count($tmps)-1]);
		$path = implode('/', $tmps);

		$filename_cache3_has_size = str_replace('/assets/', '/cache3/', $path).'/w'.$width.'h'.$height.'zc3_'.$file;
		$filename_cache3_no_size = str_replace('/assets/', '/cache3/', $path).'/'.$file;

		// cache2 2018-02-02 李哥說要加的，要向下支援
		$filename_original = $path.'/'.$file;
		return $filename;

		// cache3
		if(file_exists($filename_cache3_has_size)){
			$filename = $filename_cache3_has_size;
		} elseif(file_exists($filename_cache3_no_size)){
			$filename = $filename_cache3_no_size;
		}

		return $filename;
	}
}

/*
 * 全站SEO
 */

//設定全站關鍵字及description 通用SEO
$this->data['seo_description'] = (isset($this->data['sys_configs']['seo_description_'.$this->data['ml_key']]) && $this->data['sys_configs']['seo_description_'.$this->data['ml_key']]!='')?$this->data['sys_configs']['seo_description_'.$this->data['ml_key']]:'';
$this->data['seo_keywords'] = (isset($this->data['sys_configs']['seo_keyword_'.$this->data['ml_key']]) && $this->data['sys_configs']['seo_keyword_'.$this->data['ml_key']]!='')?$this->data['sys_configs']['seo_keyword_'.$this->data['ml_key']]:'';
$data['head_title'] = $data['head_title_origin'] = (isset($this->data['sys_configs']['seo_title_'.$this->data['ml_key']]) && $this->data['sys_configs']['seo_title_'.$this->data['ml_key']]!='')?$this->data['sys_configs']['seo_title_'.$this->data['ml_key']]:$data['head_title'];

unset($_constant);
eval('$_constant = '.strtoupper('seo_open').';');
if($_constant){
	// 預設每一個功能，它的名子都會被Append在網頁標題的左邊(seo)，不過功能裡還是可以調整和覆寫它
	// 經理來信說 有開SEO功能才需要
	if(isset($this->data['func_name']) and $this->data['func_name'] != ''){
		//2020-11-24 將靜態子選單的標題附加到title by lota
		$webmenuchild_search = $this->db->createCommand()->from('webmenuchild')->where('is_enable =1 and ml_key =:ml_key and url=:url',array(':ml_key'=>$this->data['ml_key'],':url'=>str_replace('_','_'.$this->data['ml_key'].'_',$this->data['router_method']).'.php'))->queryRow(); 
		if($webmenuchild_search and isset($webmenuchild_search['id']) and $webmenuchild_search['id'] > 0){	
			$data['head_title'] = $webmenuchild_search['name'].' | '.$data['head_title'];
		}else{
			$data['head_title'] = $this->data['func_name'].' | '.$data['head_title'];
		}

	}
}

// 2019-11-08 李哥說經理說，要支援主選單，和編排頁(XXX_tw_1.php) - 前台次選單(靜態)
// 李哥說不會繼承
$rowg = array();

if(!isset($_GET['id'])){ // 例如：首頁、或是連絡我們、編排頁，或是沒有分類的列表頁，像是產品總覽
	$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$this->data['router_method'])->where('seo_item_id',0)->get('seo')->row_array();

	// 這裡是有簽SEO合約的
	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');
	if($_constant){
		if(preg_match('/^(.*)_(\d+)$/', $this->data['router_method'], $matches)){
			$url = $matches[1].'_'.$this->data['ml_key'].'_'.$matches[2].'.php';
			$tmp = $this->cidb->where('is_enable',1)->where('url',$url)->where('pid !=',0)->get('webmenuchild')->row_array();
			if($tmp and isset($tmp['id'])){
				$data['head_title'] = $tmp['name'].' | '.$data['head_title_origin']; // #34425
			}
		}
	}
} elseif(isset($_GET['id'])){
	if(preg_match('/^(.*)detail$/', $this->data['router_method'], $matches)){ // 各功能內頁
		$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$matches[1])->where('seo_item_id',$_GET['id'])->get('seo')->row_array();

		// 這裡是有簽SEO合約的
		unset($_constant);
		eval('$_constant = '.strtoupper('seo_open').';');
		if($_constant){
			//這邊處理 url_suffix 沒有 _ml_key的情況
			$_url_suffix = $url_suffix;
			if($url_suffix != '_'.$this->data['ml_key'].'.php'){
				$_url_suffix = '_'.$this->data['ml_key'].$url_suffix;
			}
			$row = $this->cidb->where('is_home',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$matches[1].$_url_suffix)->get('html')->row_array();
			if($row){
				$common_item = $row['class_ids'];   // 是或不是通用分項
				$tmp = array();
				if($common_item == 1){ // 是通用分項
					$tmp = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type',$matches[1])->where('id',$_GET['id'])->get('html')->row_array();
				} else {
					$tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($matches[1])->row_array();
				}
				if($tmp and isset($tmp['id'])){
					$data['head_title'] = $tmp['name'].' | '.$data['head_title_origin']; // #34425
					// 2021-01-08
					foreach(array('detail','field_tmp','field_data') as $v){
						if(isset($tmp[$v]) and trim(strip_tags($tmp[$v])) != ''){
							$detail = trim($tmp[$v]);
							$detail = str_replace("\t",'',$detail);
							$detail = str_replace("\r\n",'',$detail);
							$detail = str_replace("\n",'',$detail);
							$detail = strip_tags($detail);
							$detail = mb_substr($detail, 0, 80, 'UTF-8');
							$detail = trim($detail);
							$this->data['seo_description'] = $detail;
							break;
						}
					}
				}
			}
		}
	} else { // 例如：公司簡介、多層文章、有分類的產品或最新消息
		$rowg = $this->cidb->where('seo_ml_key',$this->data['ml_key'])->where('seo_type',$this->data['router_method'].'type')->where('seo_item_id',$_GET['id'])->get('seo')->row_array();
	} // preg_match *detail

}

if($rowg and isset($rowg['id'])){
	if($rowg['seo_title'] != ''){
		$data['head_title'] = $rowg['seo_title'];
	} else {
		// 2018-12-19 Ming下午口頭說的
		// $data['head_title'] = $rowg['name']; // 沒這個欄位
	}
	if($rowg['seo_meta_keyword'] != ''){
		$this->data['seo_keywords'] = $rowg['seo_meta_keyword'];
	}
	if($rowg['seo_meta_description'] != ''){
		$this->data['seo_description'] = $rowg['seo_meta_description'];
	} else {
		// 2018-12-19 Ming下午口頭說的
		// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description
	}

	// 這裡是有簽SEO合約的
	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');
	if($_constant){
		// 2019-11-25 反解
		if($rowg['seo_script_name'] != '' and isset($_SERVER['REQUEST_URI_OLD']) and preg_match('/.php/', $_SERVER['REQUEST_URI_OLD'])){
			// https://blog.longwin.com.tw/2009/10/http-status-redirect-301-302-diff-2009/
			header('HTTP/1.1 301 Moved Permanently'); // 2019-12-26 李哥說要加的
			header('Location: '.$rowg['seo_script_name'].'.html');
			die;
		}
	} // _constant

} else {
	// 李哥說，為了區分，低階和高階專案，所以這裡不會做任何事情
	// $data['head_title'] = $tmp['name'];
	// $this->data['seo_description'] = strip_tags($tmp['detail']); // 編排頁是靜態的，所以沒有可以抓description

	// 這裡是有簽SEO合約的
	// #34425
	unset($_constant);
	eval('$_constant = '.strtoupper('seo_open').';');
	if($_constant and isset($_GET['id'])){
		//這邊處理 url_suffix 沒有 _ml_key的情況
		$_url_suffix = $url_suffix;
		if($url_suffix != '_'.$this->data['ml_key'].'.php'){
			$_url_suffix = '_'.$this->data['ml_key'].$url_suffix;
		}
		$row = $this->cidb->where('is_home',1)->where('type','webmenu')->where('ml_key',$this->data['ml_key'])->where('url1',$this->data['router_method'].$_url_suffix)->get('html')->row_array();
		if($row){
			$common_category = $row['is_news'];   // 是或不是通用分類
			$tmp = array();
			if($common_category == 1){ // 是通用分類
				$tmp = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type',$this->data['router_method'].'type')->where('id',$_GET['id'])->get('html')->row_array();
			} else {
				$tmp = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get($this->data['router_method'].'type')->row_array();
			}
			if($tmp and isset($tmp['id'])){
				$data['head_title'] = $tmp['name'].' | '.$data['head_title_origin']; // #34425
			}
		}
	}
}


/*
 * V1第二版
 */

// 2017-12-15 V1第二版的靜態規則測試
// 第一個測試網站：nakay 耐嘉
$v1 = array(
	// array(
	// 	'type' => 't', // 翻譯
	// 	'parent' => 'find("h4", 0)', // selector
	// 	'function_list' => array(
	// 		array(
	// 			'innertext',
	// 		),
	// 		'tw',
	// 		// 從這裡開始之後，都是函式
	// 		'trim',
	// 	),
	// ),

	// array(
	// 	'type' => 'd',
 	// 	'parent' => 'find("h4", 0)',
	// 	'data_source' => 'table.html.46',
	// 	'struct_tag' => 'h4',
	// 	'struct' => '<h4>{*topic*}</h4>',
	// 	'debug' => false,
	// ),

	// array(
	// 	'type' => 'n',
 	// 	'parent' => 'find("*[class=navMenu]", 0)',
	// ),

	/*
	array(
		'type' => 'l',
		'parent' => 'find("*[class=navMenu]", 0)', // 一般的規則範例
		// 'parent' => 'find("*[class=navMenu]", 0)->find("li",0)', // 單層單行的規則範例
		'single' => false, // 是否為單層單行模式
		'data_source' => 'webmenu:', // data source
		'params' => '', // parameters
		'ignore_top' => '', // 忽略的區塊(上方額外要加上的區塊)
		'debug_first' => false,
		'debug' => false,
	
		'struct_0' => <<<XXX
<li attr1=""><a attr2=""><span>{/name/}</span></a>
	{/child/}
</li>
XXX
,
	 	'struct_1' => '<ul>',
	 	'struct_2' => '</ul>',
	 ),
	 */

); 

// 2018-02-27 V1第二版，在後台的功能，李哥下午己經有看過這個東西 
$rows = $this->cidb->where('is_enable',1)->where('type','dom5')->where('other1 !=','')->where('topic !=','')->order_by('sort_id','asc')->get('html')->result_array();
if(0 and $rows and !empty($rows)){
	foreach($rows as $k => $v){
		$rule = array(
			'type' => $v['other1'],
			'parent' => $v['topic'],
			'debug' => false,
		);

		if($v['is_home'] == '1'){
			$rule['debug'] = true;
		}

		if($v['other1'] == 'l'){
			$rule['single'] = false; // 是否為單層單行模式
			$rule['data_source'] = $v['other3']; // data source
			$rule['data_source_id'] = $v['other16'];
			$rule['params'] = $v['other4']; // parameters
			$rule['ignore_top'] = ''; // 忽略的區塊(上方額外要加上的區塊)
			$rule['debug_first'] = false;
			$rule['struct_0'] = str_replace('\'','"',$v['other6']);
			$rule['struct_1'] = $v['other7'];
			$rule['struct_2'] = $v['other8'];
			$rule['struct_a'] = $v['other15'];

			if($v['other2'] == '1'){
				$rule['single'] = true;
			}

			if($v['other5'] == '1'){
				$rule['debug_first'] = true;
			}
		} elseif($v['other1'] == 'd'){
			$rule['data_source'] = $v['other9'];
			$rule['struct_tag'] = $v['other10'];
			$rule['struct'] = $v['other11'];
		} elseif($v['other1'] == 't'){
			$rule['function_list'] = array(
				explode(',', $v['other12']),
				$v['other13'],
			);

			$tmps = explode(',', $v['other14']);
			if($tmps and count($tmps) > 0){
				foreach($tmps as $v){
					$rule['function_list'][] = $v;
				}
			}
		}

		$v1[] = $rule;
	}
}
//var_dump($v1);die;

// 2018-07-13
// 2021-01-27 這裡用愈多，效能愈慢
$rows = $this->cidb->where('is_enable',1)->where('type','datasource')->where('is_news',1)->order_by('sort_id','asc')->get('html')->result_array();
if($rows and count($rows) > 0){
	foreach($rows as $k => $vggg_aaa_ggg){
		$layoutv3_datasource_id = $vggg_aaa_ggg['id'];
		include GGG_BASEPATH.'../../layoutv3/dom5/datasource.php';
		$this->data[str_replace(':','_',$vggg_aaa_ggg['video_1']).'_'.$vggg_aaa_ggg['id']] = $content;

		// 元素 (好記的名稱)
		if(isset($vggg_aaa_ggg['video_2']) and $vggg_aaa_ggg['video_2'] != ''){
			$this->data[$vggg_aaa_ggg['video_2']] = $content;
		}
	}
}
// var_dump($this->data['_sub']);

// 2019-07-01
// 登入才可以使用的功能(depo)
// 在source/menu/v2.php最下面那邊還有
// if(preg_match('/product/', $this->data['router_method'])){
// 	if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] > 0){
// 		// do nothing
// 	} else {
// ?g>
// <meta charset="utf-8" />
// <script type="text/javascript">
// 	alert('Please Login !');
// 	window.location.href='index.php';
// </script>
// <?gphp
// 		die;
// 		// 2019-05-27 沒登入，而是直接從網址進來的，要去哪裡？李哥說，這種情況先回首頁
// 		//header('Location: index.php');
// 	}
// }
//班級成果 頁面用
if(stristr($this->data['router_method'],'class_') || stristr($this->data['router_method'],'classout_')){
	if(stristr($this->data['router_method'],'classout_')){
		if(isset($_GET['class_id'])){
			$_SESSION['class_id']=$_GET['class_id'];
		}
		if(empty($_SESSION['class_id'])){
			echo "<script>alert('請先選擇班級');window.location.href='/classachievement_".$this->data['ml_key'].".php';</script>";
		}
		//班級資料
		$class_data=$this->cidb->select('a.*,b.school_name,b.code')->from('writeplan_class as a')->where('a.id',$_SESSION['class_id'])->join('customer as b', 'a.represent_id = b.id', 'left')->get()->row_array();
		if($class_data['is_enable']!=1 && stristr($this->data['router_method'],'classout_')){
			echo "<script>alert('該班級已被關閉');window.location.href='/index_".$this->data['ml_key'].".php';</script>";
		}
		//圖片路徑
		if(!empty($class_data['code'])){
			$school=$class_data['code'];
		}else{
			$school='all_school';
		}
	}
	
}