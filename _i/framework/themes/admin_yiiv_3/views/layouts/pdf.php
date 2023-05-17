<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>PDF</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/eob.css" />
<!--
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style.css"  />
-->
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/custom.css"  />
	</head>

	<body style="background-color:transparent;background-image:none;">
	<h1><?php echo $this->data['main_content_title']?></h1>
		<?php echo $this->data['admin_name']?>
		<br />
		<?php echo $content; ?>
	</body>
</html>
