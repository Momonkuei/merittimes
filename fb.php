<?php

include 'layoutv3/init.php';

include _BASEPATH.'/config/facebook.php';

if($is_site_production === true){
	$domain = FRONTEND_DOMAIN;
} else {
	$domain = 'http://crm2.buyersline.com.tw';
}

if(empty($_POST)){
	$post = array(
		'client_id' => $client_id,
		'client_secret' => $client_secret,
		'url' => FRONTEND_DOMAIN.'/fb.php?id='.session_id(), // 就是這裡，和前端登入的facebook.php最大的不一樣
	);

	$szHtml =  '<!DOCTYPE html>';
	$szHtml .= '<html>';
	$szHtml .=     '<head>';
	$szHtml .=         '<meta charset="utf-8">';
	$szHtml .=     '</head>';
	$szHtml .=     '<body>';
	$szHtml .=         '<form id="ECPayForm" method="POST" action="'.$domain.'/facebook_s.php" target="_self">'; // facebook_s.php

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

$result = $_POST;

if($result == null or !isset($result['id'])){
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
		alert('請允許API取得資料，才能進行接下來的程序');
		window.location.href='index.php';
	</script>
<?php
	die;
}

$_SESSION['_buyersline_fb_user_facebook_id'] = $result['id'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	window.location.href='admin/';
</script>
<?php
die;
