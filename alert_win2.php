<?php

include 'layoutv3/init.php';

$ml_key = $this->data['ml_key'];
$row = $this->data['sys_configs'];

if(isset($row['pic2_'.$ml_key])){
	$pic = (is_file('_i/assets/upload/indexad/'.$row['pic2_'.$ml_key]))?'_i/assets/upload/indexad/'.$row['pic2_'.$ml_key]:'';
} else {
	$pic = '';
}

if(isset($row['indexad_text_'.$ml_key])){
	$href = $row['indexad_text_'.$ml_key];
} else {
	$href='javascript:void(0)';
}

if(isset($row['indexad_title_'.$ml_key])){
	$title = $row['indexad_title_'.$ml_key];
} else {
	$title = $row['admin_title'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title?></title>
<!--TW - Meta Data-->
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body>
<div id="bg_main">
	<div class="main clearfix">
		<a href="<?php echo $href?>" target="_parent"><img src="<?php echo $pic?>" style="max-width: 100%;" /></a>
	</div>
</div>
</body>
</html>
