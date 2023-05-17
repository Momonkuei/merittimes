<?php

/*
*
* 檢測連結是否是SSL連線
* @return bool
*/
session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
if(!function_exists('is_SSL')){
	function is_SSL(){
		if(!isset($_SERVER['HTTPS']))
			return FALSE;
		if($_SERVER['HTTPS'] === 1){  //Apache
			return TRUE;
		}elseif($_SERVER['HTTPS'] === 'on'){ //IIS
			return TRUE;
		}elseif($_SERVER['SERVER_PORT'] == 443){ //其他
			return TRUE;
		}
			return FALSE;
	}
}

if(is_SSL()){

	//設定cookie傳輸模式 by lota
	$maxlifetime = ini_get('session.gc_maxlifetime');
	$secure = true; // if you only want to receive the cookie over HTTPS
	$httponly = true; // prevent JavaScript access to session cookie
	$samesite = 'None';

    if(PHP_VERSION_ID < 70300) {
        session_set_cookie_params(0, '/; samesite='.$samesite, str_replace('www','',$_SERVER['HTTP_HOST']), $secure, $httponly);
    } else {
        session_set_cookie_params([
            //'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => str_replace('www','',$_SERVER['HTTP_HOST']),
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }
}


include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

include _BASEPATH.'/config/shop.php';
include _BASEPATH.'/config/google.php';

unset($_SESSION['save']['guestlogin']['login_account']);
unset($_SESSION['save']['guestlogin']['name']);
unset($_SESSION['save']['guestlogin']['_social_type']);
unset($_SESSION['save']['guestlogin']['_social_id']);

// if($is_site_production === true){
	$domain = FRONTEND_DOMAIN;
// } else {
// 	$domain = 'http://crm2.buyersline.com.tw';
// }

if(empty($_POST)){
	$post = array(
		'client_secret' => str_replace('"','87878787878787878787',$google_client_secret),
		'url' => FRONTEND_DOMAIN.'/google.php?id='.session_id(),
	);

	$szHtml =  '<!DOCTYPE html>';
	$szHtml .= '<html>';
	$szHtml .=     '<head>';
	$szHtml .=         '<meta charset="utf-8">';
	$szHtml .=     '</head>';
	$szHtml .=     '<body>';
	$szHtml .=         '<form id="ECPayForm" method="POST" action="'.$domain.'/google_s.php" target="_self">';

	if($post and count($post) > 0){ 
		foreach($post as $k => $v){
	$szHtml .= '            <input type="hidden" name="'.$k.'" value="'.$v.'" />';
		}   
	}

	$szHtml .=         '</form>';
	$szHtml .=         '<script type="text/javascript">document.getElementById("ECPayForm").submit();</script>';
	$szHtml .=     '</body>';
	$szHtml .= '</html>';
	echo $szHtml ;
	exit;
}

/*
 *  array(10) { 
 *      ["id"]=> string(21) "107807358519602249511" 
 *      ["email"]=> string(17) "gisanfu@gmail.com" 
 *      ["verified_email"]=> bool(true) 
 *      ["name"]=> string(10) "fu gisanfu" 
 *      ["given_name"]=> string(2) "fu" 
 *      ["family_name"]=> string(7) "gisanfu" 
 *      ["link"]=> string(45) "https://plus.google.com/107807358519602249511" 
 *      ["picture"]=> string(92) "https://lh5.googleusercontent.com/-3Trib9wXgbY/AAAAAAAAAAI/AAAAAAAAEGQ/faZp_sVsGRM/photo.jpg" 
 *      ["gender"]=> string(4) "male" 
 *      ["locale"]=> string(5) "zh-TW"
 *  } 
 */

$result = $_POST;

if($result == null or !isset($result['email'])){
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
		alert('系統異常，請重新操作');
		window.location.href='guestlogin_<?php echo FRONTEND_DEFAULT_LANG?>.php';
	</script>
<?php
	die;
}

$row = $this->cidb->where('is_enable',1)->where('googleplus_id',trim($result['id']))->get('customer')->row_array();
if(isset($row) and isset($row['id'])){
	// 底下這一段，是從source/member/login_post.php那邊複製過來的
	Yii::app()->session->add('authw_admin_id', $row['id']);  
	Yii::app()->session->add('authw_admin_account', $row['login_account']);  
	Yii::app()->session->add('authw_admin_name', $row['name']);  

	/*
	 * 檢查我的收藏
	 */
	if(isset($_SESSION['save']['shop_favorite']) and count($_SESSION['save']['shop_favorite']) > 0) {
		foreach($_SESSION['save']['shop_favorite'] as $k => $v){
			// 先看有沒有(此時不管時間)
			//$row2 = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and member_id=:member_id and other1=:id',array(':id'=>$k,':member_id'=>$row['id'],':type'=>'favorite',':ml_key'=>$this->data['ml_key']))->queryRow();
			$row2 = $this->cidb->where('is_enable',1)->where('type','favorite')->where('ml_key',$_SESSION['web_ml_key'])->get('html')->row_array();
			if($row2 and isset($row2['id'])){
				$update = array(
					'start_date' => $v['add_date'],
				);
				$this->cidb->where('id', $row2['id']);
				$this->cidb->update('html', $update); 
			} else {
				$id_tmp = explode('_', $k);
				$save = array(
					'type' => 'favorite',
					'ml_key' => $_SESSION['web_ml_key'],
					'is_enable' => 1,
					'start_date' => $v['add_date'],
					'other1' => $id_tmp[0],
					'other2' => $id_tmp[1],
					'member_id' => $row['id'],
				);
				$this->cidb->insert('html', $save); 
			}
		}
		unset($_SESSION['save']['shop_favorite']);
	}
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
		alert('己登入');
		window.location.href='index_<?php echo FRONTEND_DEFAULT_LANG?>.php';
	</script>
	<?php
	die;
}

// 最後，以及導向到註冊頁面，繼續填其它必需要的欄位
$_SESSION['save']['guestlogin']['login_account'] = trim($result['email']);
$_SESSION['save']['guestlogin']['name'] = trim($result['name']);
$_SESSION['save']['guestlogin']['_social_type'] = 'google';
$_SESSION['save']['guestlogin']['_social_id'] = trim($result['id']);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('請繼續填寫其它必要的欄位');
	window.location.href='guestregister_<?php echo FRONTEND_DEFAULT_LANG?>.php';
</script>
<?php
die;
