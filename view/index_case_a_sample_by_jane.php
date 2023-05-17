##form_post##

<span mg="form_post"></span>

<!DOCTYPE html>
<html lang="zh-tw">
<head>

<?php
/*
 * 2021-01-11 家榛 A方案範本 南聯百威 abinbev
 */
?>

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

<span mg="body_end"></span>

</body>
</html>
