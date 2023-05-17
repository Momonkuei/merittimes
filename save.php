<?php

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

// var_dump($_SESSION['save']);die;

$prefix = 'save';

// 2021-01-21
// 在使用$_REQUEST要很小心，因為每個伺服器的設定不一樣
//
// 開發環境以為的設定(不包含COOKIE)
// request_order:GP
// variables_order:GPCS
//
// 有些線上環境的設定(包含COOKIE)
// * 例如bigcloud_2 big2 經銷主機60.248.112.142
// request_order:(empty) *空白就會依照variables_order的設定
// variables_order:EGPCS
//
// variables_order的其它說明
// 設定 EGPCS（Environment，GET，POST，Cookie，Server）變量解析的順序。默認設定為「EGPCS」。
// 舉例說，將其設為「GP」，會導致 PHP 完全忽略環境變量，cookies 和 server 變量，並用 GET 方法的變量覆蓋 POST 方法的同名變量。
// 
// $row = $_REQUEST;

// 2021-01-21
// 手動撰寫GP規則(GET優先，覆寫POST)
$row = $_GET;
if(!empty($_POST)){
	foreach($_POST as $k => $v){
		$row[$k] = $v;
	}
}
// 可能是購物車在使用的
if(isset($row['_prefix'])){
	$prefix = $row['_prefix'];
}

if(isset($row['id'])){

	if($row['id'] == 'clear'){
		unset($_SESSION[$prefix]);
		echo 'clear';
		die;
	}
	//2017/7/3  這邊是購物車第二步的"自訂"模式，清除收件人資料 by lota
	if($row['id'] == 'member_form_2_clear'){
		foreach($_SESSION[$prefix]['member_form_2'] as $k => $v){
			$_SESSION[$prefix]['member_form_2'][$k] = '';
		}
		//unset($_SESSION[$prefix]['member_form_2']);
		$_SESSION[$prefix]['member_form_2']['select_recipient'] = 'custom';
		//echo 'clear';
		die;
	} elseif($row['id'] == 'selecxt_physical'){ // 2020-05-25 李哥建議的，選其它物流時，會把參數都刪一刪
		unset($_SESSION[$prefix][$row['id']]);
	}

	$key = $row['id'];
	unset($row['id']);

	if(!isset($_SESSION[$prefix][$key])){
		$_SESSION[$prefix][$key] = array();
	}
	$primary_key = '';
	if(!empty($row)){
		// 先找primary_key
		foreach($row as $k => $v){
			if($k == 'primary_key'){
				$primary_key = $v;
				unset($row['primary_key']);
				break;
			}
		}

		if($primary_key == ''){
			
			if(isset($_SESSION[$prefix][$key]) and !empty($_SESSION[$prefix][$key])){
				//$row = array_merge($row, $_SESSION[$prefix][$key]);
				foreach($row as $k => $v){
					$_SESSION[$prefix][$key][$k] = $v;
				}
			} else {
				$_SESSION[$prefix][$key] = $row;
			}
		} else {
			// 有primary key的，還多了可以處理amount的部份
			if(isset($row['amount']) and $row['amount'] > 0){
				if(!isset($_SESSION[$prefix][$key][$primary_key]['amount'])){
					$_SESSION[$prefix][$key][$primary_key]['amount'] = 0;
				}
				if(isset($row['_append'])){ // 累加，適用一般
					$_SESSION[$prefix][$key][$primary_key]['amount'] += $row['amount'];
				} elseif(isset($row['_switch'])){ // 有、或沒有，適用checkbox
					if($_SESSION[$prefix][$key][$primary_key]['amount'] == 0){
						$_SESSION[$prefix][$key][$primary_key]['amount'] = $row['amount'];
					} else {
						$_SESSION[$prefix][$key][$primary_key]['amount'] = 0;
					}
				} else {
					$_SESSION[$prefix][$key][$primary_key]['amount'] = $row['amount'];
				}
				unset($row['amount']);
			} 
			// 其餘就replace囉
			if(!empty($row)){
				foreach($row as $k => $v){
					$_SESSION[$prefix][$key][$primary_key][$k] = $v;
					// Yii::app()->session[$prefix][$key][$primary_key][$k] = $v;
				}
			}
		}
	}
}
// print_r($_SESSION);die;
if(isset($_REQUEST['id']) and preg_match('/^(.*)inquiry$/', $_REQUEST['id'], $matches)){
	$router_method = $matches[1];
	if(isset($_REQUEST['_append'])){
		// 2019-03-27 詢問車 改為連到 聯絡我們 ( 點擊後，會帶產品名稱 到 聯絡我們表單 )
		// $redirect_url = 'contact_'.$this->data['ml_key'].'.php';
		// header('Location: '.$redirect_url);		

		$redirect_url = $router_method.'inquiry_'.$this->data['ml_key'].'.php';

		//點選詢問後回到列表頁 by lota 2019-10-22
		if(isset($_REQUEST['redirect_url']) && $_REQUEST['redirect_url']!=''){
			$redirect_url = urldecode($_REQUEST['redirect_url']);
		}

		G::alert_and_redirect(t('已加入詢問車'), $redirect_url, $this->data);
		die;
	} else {
		if($_REQUEST['amount'] == 0){
			$ggg = t('己刪除');
			//修正數量為0(刪除),SESSION內的資料沒處理 by lota 2018/12/7
			if(isset($_GET['primary_key'])){
				unset($_SESSION['save'][$_GET['id']][$_GET['primary_key']]);
			}			
			$return = <<<XXX
<meta charset="UTF-8">
<script type="text/javascript">
alert('$ggg');
window.location.href = '{$router_method}inquiry_{$this->data['ml_key']}.php';
</script>
XXX;
			echo $return;
			die;
		} else {
			// 好像也不用refresh頁面 ㄏ又 ~
			// echo 'location.reload(true);';
		}
		die;
	}
} elseif(isset($_REQUEST['id']) and $_REQUEST['id'] == 'shop_filter_price'){
	$key = $_REQUEST['id'];
	$data_id = $_REQUEST['data_id'];//2017/7/3 增加依照目前類別去顯示資料 by lota
	// 如果預設值不是這樣子，請自己依照需求去修改！！
	// if(
	// 	isset($_SESSION['save'][$key]['min']) and $_SESSION['save'][$key]['min'] == $row['min']
	// 	and 
	// 	isset($_SESSION['save'][$key]['max']) and $_SESSION['save'][$key]['max'] == $row['max']
	// ){
	// 	// do nothing
	// } else {
	// }
	if($data_id > 0){
		echo "window.location.href='shop_".$this->data['ml_key'].".php?id=$data_id';";
	} else {
		echo "window.location.href='shop_".$this->data['ml_key'].".php';";
	}
} elseif(isset($_REQUEST['id']) and $_REQUEST['id'] == 'selecxt_physical'){
	// 因為選擇超商取貨付款的時候，在第二步驟就完成了，所以才需要在這邊做防呆
	// 避免Bug產生
	unset($_SESSION['save']['step3']['go_to_finish!!']);
}
if($_POST['id']=='member_form_1'){
	foreach($row as $k => $v){
		$_SESSION['save']['member_form_1'][$k]=$v;
	}
 }
die;

