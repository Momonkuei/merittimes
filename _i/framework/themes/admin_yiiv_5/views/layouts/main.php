<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0
Version: 1.5.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
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
		<?php if(0):?>
		<title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'], null, '後台管理')?></title>
		<?php endif?>

		<?php if(1):?>
		<title><?php echo $this->data['sys_configs']['admin_title']?> - 後台管理系統</title>
		<?php endif?>

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0" name="viewport" />

		<meta content="" name="description" />
		<meta content="" name="author" />
		<meta name="MobileOptimized" content="320">

		<!-- BEGIN GLOBAL MANDATORY STYLES -->          
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/daterangepicker.css" />
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL STYLES --> 
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/select2/select2_metro.css" />
		<link rel="stylesheet" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/data-tables/DT_bootstrap.css" /> 
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME STYLES --> 
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style-metronic.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style-responsive.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/plugins.css" rel="stylesheet" type="text/css"/>
		<?php if(0):?><?php // 這是原本平台網站的顏色?>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color" />
		<?php endif?>
		<?php // 這是Bryan建議使用的顏色，也就是預設的?>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/custom.css" rel="stylesheet" type="text/css"/>

		<!--2016/8/2 lota add tags-input-->
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-tags-input/jquery.tagsinput.css" />

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

<?php if(isset($this->data['_head_script']) && $this->data['_head_script']!=''):?>

<?php echo $this->data['_head_script']?>

<?php endif?>

	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body class="page-header-fixed <?php if(isset($this->data['def']['page_sidebar_closed']) and $this->data['def']['page_sidebar_closed'] === true):?> page-sidebar-closed <?php endif?>" style='font-family: "Helvetica Neue", Helvetica, Arial, "微軟正黑體", "微软雅黑", "メイリオ", "맑은 고딕", sans-serif;'>
	<div id="buyeditor"><?php //2021-05-03 by lota?>

<?php // 如果你要用後台隱藏式Google翻釋，請打開這裡?>
<?php if(0):?>
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
<?php endif?>

		<!-- BEGIN HEADER -->
		<?php if(isset($this->data['def']['header_closed']) and $this->data['def']['header_closed'] === true):?>
		<?php else:?>
		<div class="header navbar navbar-inverse navbar-fixed-top">
			<!-- BEGIN TOP NAVIGATION BAR -->
			<div class="navbar-inner">
				<div class="container-fluid">
					<!-- BEGIN LOGO -->
					<a class="navbar-brand" href="backend.php">
						<?php if(0):?>
							<img src="<?php echo $this->assetsUrl?>/images/logo.png" alt="" width="86" /> 
						<?php endif?>

						<?php if(file_exists(_BASEPATH.'/'.$this->data['public_path'].'logo.png')):?>
							<img class="img-responsive" src="<?php echo $this->data['public_path']?>logo.png" alt="" width="86" />
						<?php else:?>
							<img class="img-responsive" src="gg" alt="<?php echo $this->data['sys_configs']['admin_title']?>" />
						<?php endif?>

					</a>
					<!-- END LOGO -->
					<!-- BEGIN RESPONSIVE MENU TOGGLER -->
<?php if(1):?>
					<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/img/menu-toggler.png" alt="" />
					</a>          
<?php endif?>
					<!-- END RESPONSIVE MENU TOGGLER -->				
					<!-- BEGIN TOP NAVIGATION MENU -->					
					<ul class="nav navbar-nav pull-right">

<?php if(0):?>
						<li class="dropdown" xid="header_notification_bar" title="快速選單">
							<a href="javascript:;" class="dropdown-toggle" style="clear:both"><i class="icon-search"></i></a>
							<input type="text" /><button class="btn blue" type="submit" onclick="checkform($('#form_data').serialize());return false;">搜尋</button>
						</li>
<?php endif?>

<?php //2020-11-12 加入顯示目前版型編號 by lota ?>
<?php if(preg_match('/^99999/', $this->data['admin_id'])):?>
						<li class="dropdown" xid="header_notification_bar">
							<a href="javascript:;" class="dropdown-toggle" xdata-toggle="dropdown">　<?php // 這裡有一個全型空白?></a>
						</li>
	<?php if(defined('LAYOUTV3_THEME_NAME')):?>
						<li><a style="color: #F1E205;line-height:133%;"><i class="icon-map-marker"></i>目前為<?php echo LAYOUTV3_THEME_NAME?>
		<?php if(defined('LAYOUTV4_THEME_VER') && LAYOUTV3_THEME_NAME == 'v4'):?>
					<?php echo LAYOUTV4_THEME_VER?>版
		<?php endif?>
					</a></li>
	<?php endif?>
<?php endif?>
<?php if($this->data['mls'] and count($this->data['mls']) > 1):?>
						<li class="dropdown" xid="header_notification_bar">
							<a href="javascript:;" class="dropdown-toggle" xdata-toggle="dropdown">　<?php // 這裡有一個全型空白?></a>
						</li>
<?php foreach($this->data['mls'] as $k => $v):?>
						<?php $name = $v?>
						<?php $active_style=''?>
						<?php if(isset($this->data['admin_switch_data_ml_key']) and $this->data['admin_switch_data_ml_key'] == $k):?>
							<?php $name = '[ '.$v.' ]'?>
							<?php $active_style = ' style="color: #F1E205;line-height:133%;';//2016/2/22 lota Bryan建議，目前語系改高亮?>
						<?php endif?>
						<li class="dropdown" xid="header_notification_bar" title="切換語系">
							<a href="<?php echo $this->createUrl('auth/switchdataml',array('ml_key'=>$k,'current_base64_url'=>$this->data['current_base64_url']))?>" class="dropdown-toggle" xdata-toggle="dropdown" <?php echo $active_style?>><i class="icon-map-marker"></i><?php echo $name?></a>
						</li>
<?php endforeach?>
						<li class="dropdown" xid="header_notification_bar">
							<a href="javascript:;" class="dropdown-toggle" xdata-toggle="dropdown">　<?php // 這裡有一個全型空白?></a>
						</li>
<?php else:?>
<?php //var_dump($this->data['mls'])?>
	<?php if(isset($this->data['mls'][$this->data['admin_switch_data_ml_key']])):?>
		<li><a style="color: #F1E205;line-height:133%;"><i class="icon-map-marker"></i>目前為<?php echo $this->data['mls'][$this->data['admin_switch_data_ml_key']]?>語系</a></li>
	<?php endif?>

	<?php if(0)://lota?>
		<?php if(isset($this->data['admin_switch_data_ml_key']) and $this->data['admin_switch_data_ml_key'] == 'tw'):?>
			<li><a  style="color: #F1E205;line-height:133%;"><i class="icon-map-marker"></i>目前為繁體中文語系</a></li>
		<?php elseif(isset($this->data['admin_switch_data_ml_key']) and $this->data['admin_switch_data_ml_key'] == 'en'):?>
			<li><a  style="color: #F1E205;line-height:133%;"><i class="icon-map-marker"></i>目前為English語系</a></li>
		<?php endif?>
	<?php endif?>
<?php endif?>

						<?php // TCO上方選單 ?>
						<?php if(count($this->data['tcotopmenus']) > 0):?>
							<?php foreach($this->data['tcotopmenus'] as $k => $v):?>
								<li class="dropdown" xid="header_notification_bar" title="快速選單">
									<a href="<?php echo vir_path_c.$v['url1']?>" class="dropdown-toggle" xdata-toggle="dropdown"><i class="<?php if(isset($v['other1']) and $v['other1'] != ''):?><?php echo $v['other1']?><?php else:?>icon-map-marker<?php endif?>"></i><?php echo $v['topic']?></a>
								</li>
							<?php endforeach?>
						<?php endif?>

						<!-- BEGIN USER LOGIN DROPDOWN -->
						<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<?php if(0):?>
							<img alt="" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/img/avatar1_small.jpg" />
<?php endif?>
							<span class="username">您好，<?php if(isset($this->data['admin_name'])):?><?php echo $this->data['admin_name'] ?><?php else:?>名子未設定<?php endif?></span>
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
		<?php endif?><!-- header_closed -->
		<!-- END HEADER -->

		<div class="clearfix"></div>
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
			<?php if(file_exists(Yii::getPathOfAlias('application.views.includes.menu').'.php')):?>
				<?php echo $this->renderPartial('application.views.includes.menu', $this->data)?>
			<?php else:?>
				<?php echo $this->renderPartial('includes/menu', $this->data)?>
			<?php endif?>
			<!-- END SIDEBAR -->
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

<?php if(0):?>
					<!-- 廣告 -->
					<div class="row" style="display:none">
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
<?php endif?>

					<?php echo $content; ?>
				</div>

				<?php // gisanfu test?>
				<?php if(0):?>
					<div class="container-fluid">
						<div class="row">
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
	</div>

		<!-- END FOOTER -->
		<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
		<!-- BEGIN CORE PLUGINS -->   
		<!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script> 
		<![endif]-->   
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
		<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery.cookie.min.js" type="text/javascript"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
		<!--2016/8/2 lota add tags-input-->
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript" ></script>

		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/date.js"></script>
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap-daterangepicker/daterangepicker.js"></script> 
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/select2/select2.min.js"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/scripts/app.js"></script>
		<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/scripts/form-samples.js"></script>   
		<!-- END PAGE LEVEL SCRIPTS -->
		<script>
		   jQuery(document).ready(function() {    
			  // initiate layout and plugins
			  App.init();
			  FormSamples.init();
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

<?php

if(isset($this->data['main_layout_script_end']) and $this->data['main_layout_script_end'] != ''){
	Yii::app()->clientScript->registerScript('main_layout_script_end', $this->data['main_layout_script_end'], CClientScript::POS_READY);
}
?>

	<?php if(isset($this->data['BODY_END']) and $this->data['BODY_END'] != ''):?>
		<?php echo $this->data['BODY_END']?>
	<?php endif?>

	</body>
	<!-- END BODY -->	
</html>

