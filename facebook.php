<?php

include 'layoutv3/init.php';

// 2018-04-16 非實體頁面，可能需要載入的項目
include 'layoutv3/libs.php'; // pre_render
include 'source/core_seo.php';

include _BASEPATH.'/config/shop.php';
include _BASEPATH.'/config/facebook.php';

unset($_SESSION['save']['guestlogin']['login_account']);
unset($_SESSION['save']['guestlogin']['name']);
unset($_SESSION['save']['guestlogin']['_social_type']);
unset($_SESSION['save']['guestlogin']['_social_id']);

// if($this->data['is_site_production'] === true){
	$domain = FRONTEND_DOMAIN;
// } else {
// 	$domain = 'http://crm2.buyersline.com.tw';
// }

if(empty($_POST)){
	$post = array(
		'client_id' => $client_id,
		'client_secret' => $client_secret,
		'url' => FRONTEND_DOMAIN.'/facebook.php?id='.session_id(),
	);

	$szHtml =  '<!DOCTYPE html>';
	$szHtml .= '<html>';
	$szHtml .=     '<head>';
	$szHtml .=         '<meta charset="utf-8">';
	$szHtml .=     '</head>';
	$szHtml .=     '<body>';
	$szHtml .=         '<form id="ECPayForm" method="POST" action="'.$domain.'/facebook_s.php" target="_self">';

	if($post and !empty($post)){ 
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

$result = $_POST;

if($result == null or !isset($result['id'])){
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
		alert('請允許API取得資料，才能進行接下來的程序');
	window.location.href='guestregister_<?php echo $this->data['ml_key']?>.php';
	</script>
<?php
	die;
}

// 因為不是每一個Facebook帳號都會有Email欄位
if(!isset($result['email'])){
	$result['email'] = '';
}

$row = $this->cidb->where('is_enable',1)->where('facebook_id',trim($result['id']))->get('customer')->row_array();
if(isset($row) and isset($row['id'])){
	// 底下這一段，是從source/member/login_post.php那邊複製過來的
	Yii::app()->session->add('authw_admin_id', $row['id']);  
	Yii::app()->session->add('authw_admin_account', $row['login_account']);  
	Yii::app()->session->add('authw_admin_name', $row['name']);  

	/*
	 * 檢查我的收藏
	 */
	if(isset($_SESSION['save']['shop_favorite']) and !empty($_SESSION['save']['shop_favorite'])) {
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
		window.location.href='index.php';
	</script>
	<?php
	die;
}

// 最後，以及導向到註冊頁面，繼續填其它必需要的欄位
$_SESSION['save']['guestlogin']['login_account'] = trim($result['email']);
$_SESSION['save']['guestlogin']['name'] = trim($result['name']);
$_SESSION['save']['guestlogin']['_social_type'] = 'facebook';
$_SESSION['save']['guestlogin']['_social_id'] = trim($result['id']);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('請繼續填寫其它必要的欄位');
	window.location.href='guestregister_<?php echo $this->data['ml_key']?>.php';
</script>
<?php
die;
