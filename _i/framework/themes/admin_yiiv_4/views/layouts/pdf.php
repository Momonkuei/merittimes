<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 2.3.1
Version: 1.1.2
Author: KeenThemes
Website: http://www.keenthemes.com/preview/?theme=metronic
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469
-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
	<head>
<?php if(0):?>
		<meta charset="utf-8" />
<?php endif?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="shortcut icon" href="<?php echo vir_path_c?>favicon.ico" />

		<script type="text/javascript">var IMAGE_URL = '<?php echo $this->assetsUrl?>/images/';</script>
		<script type="text/javascript">
			var vir_path_c = '<?php echo vir_path_c?>';
			var base_url = '<?php echo $this->data['base_url']?>';
			var ml_key = '<?php echo $this->data['ml_key']?>';
			var assets_url = '<?php echo $this->assetsUrl?>';
			var template_path = '<?php echo $this->data['template_path']?>';
		</script>

		<script src="<?php echo $this->data['base_url']?>/assets/language.js"></script>
		<?php
			Yii::app()->clientScript->registerCoreScript('jquery.validate');
			Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/js/custom.js');
			Yii::app()->clientScript->registerCssFile($this->assetsUrl.$this->data['template_path'].'/css/custom.css');
		?>
		<title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'], null, '後台管理')?></title>

		<meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/css/bootstrap.css" rel="stylesheet" />
<?php if(0):?>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<?php endif?>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/metro.css" rel="stylesheet" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style.css" rel="stylesheet" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style_responsive.css" rel="stylesheet" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style_default.css" rel="stylesheet" id="style_color" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/gritter/css/jquery.gritter.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/uniform/css/uniform.default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/daterangepicker.css" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />

<?php if(0):?>
<style type="css/text">
.breadcrumb li {
margin-right: 1px;
}
</style>
<?php endif?>

	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body class="fixed-top" style='font-family: "Helvetica Neue", Helvetica, Arial, "微軟正黑體", "微软雅黑", "メイリオ", "맑은 고딕", sans-serif;background-color:transparent !important;'>
	<h1><?php echo $this->data['main_content_title']?></h1>
		<?php echo $this->data['admin_name']?>
		<br />
		<?php echo $content; ?>
	</body>
</html>
