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

		<!-- 這裡有幾種顏色可以選 -->
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style_light.css" rel="stylesheet" />
		<!--
		<link href="css/style_blue.css" rel="stylesheet" />
		<link href="css/style_brown.css" rel="stylesheet" />
		<link href="css/style_purple.css" rel="stylesheet" />
		-->

		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/gritter/css/jquery.gritter.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/uniform/css/uniform.default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/daterangepicker.css" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />

		<!--
		<script src="http://www.gmodules.com/ig/ifr?url=http://www.google.com/ig/modules/translatemypage.xml&up_source_language=zh-TW&w=160&h=60&title=&border=&output=js"></script> 
		-->
		<meta name="google-translate-customization" content="3e0427630c317b41-78a4b16a7e31a9c5-g5b47d94cbc9cc787-10" />

<?php if(0):?>
<style type="css/text">
.breadcrumb li {
margin-right: 1px;
}
</style>
<?php endif?>

<?php if(0):?>
<?php // 使網站變灰?>
<style>
html{
-webkit-filter: grayscale(100%);
-moz-filter: grayscale(100%);
-ms-filter: grayscale(100%);
-o-filter: grayscale(100%);
filter: grayscale(100%);
filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
filter: progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);
}
</style>
<?php endif?>

	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body class="fixed-top" style='font-family: "Helvetica Neue", Helvetica, Arial, "微軟正黑體", "微软雅黑", "メイリオ", "맑은 고딕", sans-serif;'>

<?php if($this->data['interface_ml_key'] == 'cn'):?>
	<div id="google_translate_element" style="display:none"></div><script type="text/javascript">
	function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'zh-TW', includedLanguages: 'zh-CN', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT, autoDisplay: false}, 'google_translate_element');
	}
	</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php elseif($this->data['interface_ml_key'] == 'jp'):?>
	<div id="google_translate_element" style="display:none"></div><script type="text/javascript">
	function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'zh-TW', includedLanguages: 'ja', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT, autoDisplay: false}, 'google_translate_element');
	}
	</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php endif?>

		<!-- BEGIN HEADER -->
		<div class="header navbar navbar-inverse navbar-fixed-top">
			<!-- BEGIN TOP NAVIGATION BAR -->
			<div class="navbar-inner">
				<div class="container-fluid">
					<!-- BEGIN LOGO -->
					<a class="brand" href="backend.php">
						<img src="<?php echo $this->assetsUrl?>/images/EOBinternational_86.png" alt="" width="86" /> 
					</a>
					<!-- END LOGO -->
					<!-- BEGIN RESPONSIVE MENU TOGGLER -->
					<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
						<img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/img/menu-toggler.png" alt="" />
					</a>          
					<!-- END RESPONSIVE MENU TOGGLER -->				
					<!-- BEGIN TOP NAVIGATION MENU -->					
					<ul class="nav pull-right">
<?php if(0):?>
						<!-- BEGIN NOTIFICATION DROPDOWN -->	
						<li class="dropdown" id="header_notification_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-warning-sign"></i>
							<span class="badge">6</span>
						</a>
						<ul class="dropdown-menu extended notification">
							<li>
							<p>You have 14 new notifications</p>
							</li>
							<li>
							<a href="javascript:;" onclick="App.onNotificationClick(1)">
								<span class="label label-success"><i class="icon-plus"></i></span>
								New user registered. 
								<span class="time">Just now</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="label label-important"><i class="icon-bolt"></i></span>
								Server #12 overloaded. 
								<span class="time">15 mins</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="label label-warning"><i class="icon-bell"></i></span>
								Server #2 not respoding.
								<span class="time">22 mins</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="label label-info"><i class="icon-bullhorn"></i></span>
								Application error.
								<span class="time">40 mins</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="label label-important"><i class="icon-bolt"></i></span>
								Database overloaded 68%. 
								<span class="time">2 hrs</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="label label-important"><i class="icon-bolt"></i></span>
								2 user IP blocked.
								<span class="time">5 hrs</span>
							</a>
							</li>
							<li class="external">
							<a href="#">See all notifications <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
						</li>
						<!-- END NOTIFICATION DROPDOWN -->
						<!-- BEGIN INBOX DROPDOWN -->
						<li class="dropdown" id="header_inbox_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-envelope-alt"></i>
							<span class="badge">5</span>
						</a>
						<ul class="dropdown-menu extended inbox">
							<li>
							<p>You have 12 new messages</p>
							</li>
							<li>
							<a href="#">
								<span class="photo"><img src="./assets/img/avatar2.jpg" alt="" /></span>
								<span class="subject">
									<span class="from">Lisa Wong</span>
									<span class="time">Just Now</span>
								</span>
								<span class="message">
									Vivamus sed auctor nibh congue nibh. auctor nibh
									auctor nibh...
								</span>  
							</a>
							</li>
							<li>
							<a href="#">
								<span class="photo"><img src="./assets/img/avatar3.jpg" alt="" /></span>
								<span class="subject">
									<span class="from">Richard Doe</span>
									<span class="time">16 mins</span>
								</span>
								<span class="message">
									Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh
									auctor nibh...
								</span>  
							</a>
							</li>
							<li>
							<a href="#">
								<span class="photo"><img src="./assets/img/avatar1.jpg" alt="" /></span>
								<span class="subject">
									<span class="from">Bob Nilson</span>
									<span class="time">2 hrs</span>
								</span>
								<span class="message">
									Vivamus sed nibh auctor nibh congue nibh. auctor nibh
									auctor nibh...
								</span>  
							</a>
							</li>
							<li class="external">
							<a href="#">See all messages <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
						</li>
						<!-- END INBOX DROPDOWN -->
						<!-- BEGIN TODO DROPDOWN -->
						<li class="dropdown" id="header_task_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-tasks"></i>
							<span class="badge">5</span>
						</a>
						<ul class="dropdown-menu extended tasks">
							<li>
							<p>You have 12 pending tasks</p>
							</li>
							<li>
							<a href="#">
								<span class="task">
									<span class="desc">New release v1.2</span>
									<span class="percent">30%</span>
								</span>
								<span class="progress progress-success ">
									<span style="width: 30%;" class="bar"></span>
								</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="task">
									<span class="desc">Application deployment</span>
									<span class="percent">65%</span>
								</span>
								<span class="progress progress-danger progress-striped active">
									<span style="width: 65%;" class="bar"></span>
								</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="task">
									<span class="desc">Mobile app release</span>
									<span class="percent">98%</span>
								</span>
								<span class="progress progress-success">
									<span style="width: 98%;" class="bar"></span>
								</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="task">
									<span class="desc">Database migration</span>
									<span class="percent">10%</span>
								</span>
								<span class="progress progress-warning progress-striped">
									<span style="width: 10%;" class="bar"></span>
								</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="task">
									<span class="desc">Web server upgrade</span>
									<span class="percent">58%</span>
								</span>
								<span class="progress progress-info">
									<span style="width: 58%;" class="bar"></span>
								</span>
							</a>
							</li>
							<li>
							<a href="#">
								<span class="task">
									<span class="desc">Mobile development</span>
									<span class="percent">85%</span>
								</span>
								<span class="progress progress-success">
									<span style="width: 85%;" class="bar"></span>
								</span>
							</a>
							</li>
							<li class="external">
							<a href="#">See all tasks <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
						</li>
						<!-- END TODO DROPDOWN -->
<?php endif?>

						<?php // TCO上方選單 ?>
						<?php if(count($this->data['tcotopmenus']) > 0):?>
							<?php foreach($this->data['tcotopmenus'] as $k => $v):?>
								<li class="dropdownx" xid="header_notification_bar" title="快速選單">
									<a href="<?php echo vir_path_c.$v['url1']?>" class="dropdown-toggle" xdata-toggle="dropdown"><i class="icon-map-marker"></i><?php echo $v['topic']?></a>
								</li>
							<?php endforeach?>
						<?php endif?>

						<?php if(count($this->data['tcofastmenus']) > 0 and 0):?>
						<!-- BEGIN TODO DROPDOWN -->
						<li class="dropdown" id="header_notification_bar" title="快速選單">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-chevron-down"></i>
							<?php if(0):?>
							<span class="badge">5</span>
							<?php endif?>
						</a>
						<ul class="dropdown-menu extended tasks">
						</ul>
						<ul class="dropdown-menu extended notification">
							<li>
								<p>快速選單</p>
							</li>
							<?php foreach($this->data['tcofastmenus'] as $k => $v):?>
							<li>
								<a href="<?php echo vir_path_c.$v['url1']?>">
									<span class="label label-success" style="background-color:#<?php echo $v['other1']?>"><i class="icon-pencil"></i></span>
									<?php echo $v['topic']?>
									<?php if(0):?>
									<span class="time">Just now</span>
									<?php endif?>
								</a>
							</li>
							<?php endforeach?>
						</ul>
						</li>
						<?php endif?>

						<!-- BEGIN USER LOGIN DROPDOWN -->
						<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<?php if(0):?>
							<img alt="" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/img/avatar1_small.jpg" />
<?php endif?>
							<span class="username"><?php if(isset($this->data['admin_name'])):?><?php echo $this->data['admin_name'] ?><?php endif?></span>
							<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->createUrl('home/personalhome')?>"><i class="icon-home"></i> <?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></a></li>
							<li><a href="<?php echo $this->createUrl('profile/index')?>"><i class="icon-user"></i> <?php G::te($this->data['theme_lang'], 'Change Password', null, '更改密碼')?></a></li>
<?php if(0):?>
							<li><a href="calendar.html"><i class="icon-calendar"></i> My Calendar</a></li>
							<li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
							<li class="divider"></li>
<?php endif?>
							<li><a href="<?php echo $this->createUrl('auth/logout', array('current_base64_url'=> $this->data['current_base64_url']))?>"><i class="icon-key"></i> <?php G::te($this->data['theme_lang'], 'Logout', null, '登出')?></a></li>
						</ul>
						</li>
						<!-- END USER LOGIN DROPDOWN -->
					</ul>
					<!-- END TOP NAVIGATION MENU -->	
				</div>
			</div>
			<!-- END TOP NAVIGATION BAR -->
		</div>
		<!-- END HEADER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container row-fluid">
			<!-- BEGIN SIDEBAR -->
			<?php echo $this->renderPartial('//includes/menu', $this->data)?>
			<!-- BEGIN PAGE -->
			<div class="page-content">
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

					<!-- 廣告 -->
					<div class="row-fluid" style="display:none">
						<div class="span12">
							<div class="alert alert-info adv_center">
								<button data-dismiss="alert" class="close"></button>
								<strong><a href="#">三寶生化科技股份有限公司 (6220-4909-0000-1096)</a></strong>
								<div class="detail hide">
									408台中市南屯區大墩十街300號7樓      Tel：04-22551743      Fax：04-22551743
									<br />
									www.tripletreasures.co.nz      E-mail： ted@bbx.tw
									<br />
									在紐西蘭基督城已有二十年歷史的「Triple Treasures 三寶集團」橫跨乳品、保健品、保養品、不動產等多項領域，公司行銷規模橫跨全世界，是當地一間相當有實力的公司！ 
									<br />
									<strong>分類：</strong>食 / 泡麵
									<strong>區域：</strong>台中市 / 南屯區
									<strong>需求：</strong>桌椅 清潔用品 裝飾品 住宿
								</div>
							</div>
						</div>
					</div>

					<?php echo $content; ?>
				</div>

<?php // gisanfu test?>
<?php if(0):?>
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="span1">123</div>
					</div>
				</div>
<?php endif?>

				<!-- END PAGE CONTAINER-->		
			</div>
			<!-- END PAGE -->
		</div>
		<!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<div class="footer">
			<span class="hide"> 2013 &copy; Metronic by keenthemes.</span>
			<div class="span pull-right">
				<span class="go-top"><i class="icon-angle-up"></i></span>
			</div>
		</div>
		<!-- END FOOTER -->
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
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/jquery.blockui.js"></script>	
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/jquery.cookie.js"></script>
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/uniform/jquery.uniform.js"></script>	

		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/date.js"></script>
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/daterangepicker.js"></script> 

		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/app.js"></script>				
		<script type="text/javascript">
			$(document).ready(function() {		
			//App.setPage("index");  // set current page
			App.init(); // init the rest of plugins and elements
			});
		</script>
		<!-- END JAVASCRIPTS -->

<?php

$tmp_script = <<<XXX0
$('.adv_center').hover(
	function(){
		$(this).find('.detail').removeClass('hide');
	},
	function(){
		$(this).find('.detail').addClass('hide');
	}
);
XXX0;
Yii::app()->clientScript->registerScript('main_layout_script', $tmp_script, CClientScript::POS_READY);
?>

<!-- http://mang-iwan.blogspot.tw/2012/04/hide-top-bar-google-translate.html -->
<style type="text/css">
.goog-te-banner-frame.skiptranslate {display: none !important;} 
body { top: 0px !important; }
</style>

	</body>
	<!-- END BODY -->
</html>

