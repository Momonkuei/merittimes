<?php

/*
	include 'layoutv3/pre_render.php';
	//include 'layoutv3/print_struct.php';
	// 每一個會員功能，寫在這裡的…就是這裡，看這裡，都會寫在這個檔案的下面
	include 'layoutv3/render.php';
 */

// 2020-12-10 從定揚形象那裡併來的
if((!isset($this->data['admin_id']) or $this->data['admin_id'] <= 0) and !preg_match('/(forget)/',$this->data['router_method'])){
?>
<meta charset="utf-8" />
<script type="text/javascript">
	alert('<?php echo t('Please Login !')?>');
	window.location.href='guestlogin_<?php echo $this->data['ml_key']?>.php';
</script>
<?php
}

$member_page_title = array();
$member_breadcrumb = array();
if($this->data['router_method'] == 'memberforget'){
	$member_page_title = array('name' => t('查詢密碼'),'sub_name' => 'password assistance');
	$member_breadcrumb = array(array('name' => 'HOME', 'url' => '/index_'.$this->data['ml_key'].'.php'),	array('name' => t('密碼查詢'), 'url' => 'memberforget.php'));
} elseif($this->data['router_method'] == 'memberforgetconfirm'){
	$member_page_title = array('name' => t('重設密碼'),'sub_name' => 'password change');
	$member_breadcrumb = array(array('name' => 'HOME', 'url' => '/index_'.$this->data['ml_key'].'.php'),array('name' => t('重設密碼'), 'url' => 'javascript:;'));
} elseif($this->data['router_method'] == 'membercustomeraddress'){
	$member_page_title = array('name' => t('收件地址簿'),'sub_name' => 'customer address');
	$member_breadcrumb = array(array('name' => 'HOME', 'url' => '/index_'.$this->data['ml_key'].'.php'),array('name' => t('收件地址簿'), 'url' => 'javascript:;'));
} else {
	$member_page_title = array("name"=>t('會員中心'),"sub_name"=>'member center');
	$member_breadcrumb = array(array("name"=>"HOME","url"=>'/index_'.$this->data['ml_key'].'.php'),array("name"=>t('會員中心'),"url"=>'#'));
}

if(!empty($member_page_title)){
	if(LAYOUTV3_THEME_NAME == 'v3'){
		if(isset($layoutv3_struct_map_keyname['v3/sub_page_title'][0])){
			$data[$layoutv3_struct_map_keyname['v3/sub_page_title'][0]] = $member_page_title;
		}
	} elseif(LAYOUTV3_THEME_NAME == 'v4'){
		if(isset($layoutv3_struct_map_keyname['v4/sub_page_title'][0])){
			$data[$layoutv3_struct_map_keyname['v4/sub_page_title'][0]] = $member_page_title;
		}
	}
}

if(!empty($member_breadcrumb)){
	if(LAYOUTV3_THEME_NAME == 'v3'){
		if(isset($layoutv3_struct_map_keyname['v3/breadcrumb'][0])){
			$data[$layoutv3_struct_map_keyname['v3/breadcrumb'][0]] = $member_breadcrumb;
		}
	} elseif(LAYOUTV3_THEME_NAME == 'v4'){
		if(isset($layoutv3_struct_map_keyname['v4/widget/breadcrumb'][0])){
			$data[$layoutv3_struct_map_keyname['v4/widget/breadcrumb'][0]] = $member_breadcrumb;
		}
	}
}
