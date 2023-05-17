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
		<meta charset="utf-8" />
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
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
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
	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body class="fixed-top">
		<!-- BEGIN CONTAINER -->
		<div class="page-container row-fluid">
			<!-- BEGIN PAGE -->
			<div class="page-content" style="margin-left:0;margin-top:-42px">
				<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<div id="portlet-config" class="modal hide">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button"></button>
						<h3>Widget Settings</h3>
					</div>
					<div class="modal-body">
						<p>Here will be a configuration form</p>
					</div>
				</div>
				<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<!-- BEGIN PAGE CONTAINER-->
				<div class="container-fluid">
					<?php echo $content; ?>
				</div>
				<!-- END PAGE CONTAINER-->		
			</div>
			<!-- END PAGE -->
		</div>
		<!-- END CONTAINER -->
		<!-- BEGIN JAVASCRIPTS -->
		<!-- Load javascripts at bottom, this will reduce page load time -->
<?php if(0):?>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/jquery-1.8.3.min.js"></script>	
<?php endif?>
		<!--[if lt IE 9]>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/excanvas.js"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/respond.js"></script>	
		<![endif]-->	
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/breakpoints/breakpoints.js"></script>		
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>	
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/jquery.blockui.js"></script>	
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/jquery.cookie.js"></script>
<?php if(0):?>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/flot/jquery.flot.js"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/flot/jquery.flot.resize.js"></script>
<?php endif?>
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/gritter/js/jquery.gritter.js"></script>
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/uniform/jquery.uniform.min.js"></script>	
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/jquery.pulsate.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/date.js"></script>
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/daterangepicker.js"></script>	
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/app.js"></script>				
		<script>
			jQuery(document).ready(function() {		
			App.setPage("index");  // set current page
			App.init(); // init the rest of plugins and elements
			});
		</script>
		<!-- END JAVASCRIPTS -->
	</body>
	<!-- END BODY -->
</html>
