##form_post##

<span mg="form_post"></span>

<!DOCTYPE html>
<html lang="zh-tw">
<head>

<?php
/*
 * 2020-09-10 政佳 A方案範本 永續材質圖書館 sml
 */
?>

##head_start##

<?php echo $AA?>

##head_end##

<span mg="head_end"></span>

</head>

<?php 
$page = $this->data['router_method'];
if($page == 'XXX'){
	$page = 'XXXfix';
}

//include('viewConfig.php');
?>

<body class="<?php echo $this->data['router_method']?>" data-page="<?php echo $page?>">

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

<span mg="body_end"></span>

</body>
</html>
