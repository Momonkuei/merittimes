<?php if(isset($_SESSION['auth_admin_id']) and preg_match('/\,(999995|999994)\,/', ','.$_SESSION['auth_admin_type'].',') and isset($_layoutv3pagetype_id) and $_layoutv3pagetype_id > 0)://2018-08-23李哥早上有看過?>
	<?php include('view/system/layoutit.php'); ?>
<?php else:?>

##form_post##

<span mg="form_post"></span>

<!DOCTYPE html>
<?php if(0)://這邊加上lang有助於瀏覽器解析html及搜尋引擎加分，但需要額外寫程式去判斷所屬語系的簡碼帶入，有空再處理....?>
<html lang="zh-tw">
<?php else:?>
<html>
<?php endif?>

<head>
##head_start##
<?php echo $AA?>
##head_end##

<span mg="head_end"></span>

</head>

<body class="<?php echo $this->data['router_method']?>">

<?php
unset($_constant);
eval('$_constant = GOOGLE_TRANSLATE;');
?>
<?php if($_constant == 2):?>
	<div id="google_translate_element_cow"></div> <?php //cowboy 20201026 #37593 留給前端移位置?>
<?php endif?>

##body_start##
<?php echo $BB?>
##body_end##

<?php if(0 and isset($_SESSION['auth_admin_id']) and preg_match('/\,(999995)\,/', ','.$_SESSION['auth_admin_type'].',') and isset($_layoutv3pagetype_id) and $_layoutv3pagetype_id > 0)://2018-08-23李哥早上有看過?>
	<iframe src="_i/backend.php?r=layoutv3pagetype/update&param=v<?php echo $_layoutv3pagetype_id?>" width="100%" height="500" frameborder="0" scrolling="auto"></iframe>
<?php endif?>

<span mg="body_end"></span>

</body>
</html>

<?php endif//layoutit?>
