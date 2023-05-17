<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0;">

	<?php // 為了SEM而增加的?>
	<?php if(1):?>
		<base href="<?php echo FRONTEND_DOMAIN?>" />
	<?php endif?>


	<?php if(isset($this->data['sys_configs']['has_seo_'.$this->data['ml_key']]) and $this->data['sys_configs']['has_seo_'.$this->data['ml_key']] == '1'):?>
		<meta name="ROBOTS" content="INDEX, FOLLOW">
		<meta name="GOOGLEBOT" content="index, follow">
		<meta name="author" content="www.buyersline.com.tw">
		<meta name="distribution" content="global"> 
		<meta name="revisit-after" content="5days">  
		<meta name="description" content="<?php if(isset($this->data['seo_description'])):?><?php echo $this->data['seo_description']?><?php endif?>">
		<meta name="keywords" content="<?php if(isset($this->data['seo_keywords'])):?><?php echo $this->data['seo_keywords']?><?php endif?>">
	<?php endif?>

	<?php if(isset($this->data['HEAD_START']) and $this->data['HEAD_START'] != ''):?>
		<?php echo $this->data['HEAD_START']?>
	<?php endif?>

	<?php if(0):?>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style01.css" />
		<link rel="stylesheet" href="html/a/css/style01.css" />
		<link rel="stylesheet" href="html/rwd152_shop/css/style01.css" />
		<link rel="shortcut icon" href="images/favor.png" />
		<link href="images/favor.png" rel="shortcut icon" />
	<?php endif?>

	<link rel="stylesheet" href="<?php echo FRONTEND_LAYOUTV2?>/html/a/css/style.css" />

	<?php if(isset($this->data['CSS']) and $this->data['CSS'] != ''):?>
		<?php echo $this->data['CSS']?>
	<?php endif?>

    <link rel="stylesheet" href="css/style01.css" />

    <link rel="shortcut icon" href="images/favicon.ico" />
    <link href="images/favicon.ico" rel="shortcut icon" />

	<title><?php echo $this->data['sys_configs']['admin_title']?></title>

	<script type="text/javascript">
	var ml_key = '<?php echo $this->data['ml_key']?>';
	</script>
	<script src="_i/assets/language.js"></script>

	<?php if(isset($this->data['HEAD']) and $this->data['HEAD'] != ''):?>
		<?php echo $this->data['HEAD']?>
	<?php endif?>


</head>
<body>

	<?php if(isset($this->data['BODY_START']) and $this->data['BODY_START'] != ''):?>
		<?php echo $this->data['BODY_START']?>
	<?php endif?>

	<?php echo $_content?>

	<div id="gotop"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></div>

	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.js"></script>

	<?php if(isset($this->data['JAVASCRIPT']) and $this->data['JAVASCRIPT'] != ''):?>
		<?php echo $this->data['JAVASCRIPT']?>
	<?php endif?>

	<script src="js/custome.js"></script>

	<?php
	if(!isset($this->data['BODY_END'])){
		$this->data['BODY_END'] = '';
	}
	$this->data['BODY_END'] .= $this->renderPartial('system.frontend.views.site._google_analytics', $this->data, true);
	?>

	<?php if(isset($this->data['BODY_END']) and $this->data['BODY_END'] != ''):?>
		<?php echo $this->data['BODY_END']?>
	<?php endif?>

</body>
</html>
