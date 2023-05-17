<?php $theme_lang = 'adminlogin7'?>
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
  <title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'])?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
		<!-- BEGIN GLOBAL MANDATORY STYLES -->          
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL STYLES --> 
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/select2/select2_metro.css" />
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME STYLES --> 
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style-metronic.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style-responsive.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/plugins.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/pages/login.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/custom.css" rel="stylesheet" type="text/css"/>
  <link rel="shortcut icon" href="favicon.ico" />
<?php Yii::app()->clientScript->registerCoreScript('jquery.validate'); ?> 

<?php
$login = <<<XXX0
$(function() {
	//Cufon.replace('#site-title');
	$('.msg').click(function() {
		$(this).fadeTo('slow', 0);
		$(this).slideUp(341);
	});
	$('#login-form').validate();
	$('#login_account').focus();

	$('#lang_select').change(function(){
		if($(this).val() != ''){
			window.location.href='{$class_url}/switchloginml&ml_key=' + $(this).val();
		}
	});

	//$('#close').click(function(){
	//	return false;
	//});
});
XXX0;
Yii::app()->clientScript->registerScript('login_js', $login, CClientScript::POS_READY);
?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo white">
	<?php if(0):?><img src="<?php echo $this->assetsUrl?>/images/logo.png" alt="" /><?php endif?>
	<?php if(0):?><h1><strong><?php echo $this->data['sys_configs']['admin_title']?></strong></h1><?php endif?>

	<?php if(0):?>
		<?php if(file_exists(_BASEPATH.'/'.$this->data['public_path'].'logo.png')):?>
			<img src="<?php echo $this->data['public_path']?>/logo.png" alt="" />
		<?php else:?>
			<h1><strong><?php echo $this->data['sys_configs']['admin_title']?></strong></h1>
		<?php endif?>
	<?php endif?>

	<?php // 經理說要下面要圖，上面只顯示該公司的文字Logo 2015-08-28?>
	<h1><strong><?php echo $this->data['sys_configs']['admin_title']?></strong></h1>

  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
	<form class="form-vertical login-form" id="loginform" action="?r=auth/login" method="post" autocomplete="off" >

      <h3 class="form-title"><?php G::te($theme_lang, 'Login to your account', null, '登入')?></h3>
      <div class="alert alert-error <?php if($status <= 0):?>hide<?php endif?>">
        <button class="close" data-dismiss="alert"></button>
        <span>請輸入正確的帳號以及密碼或驗證碼</span>
      </div>

      <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Login Account', null, '使用者名稱')?></label>
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="form-control placeholder-no-fix" type="text" placeholder="<?php G::te($theme_lang, 'Login Account', null, '使用者名稱')?>" name="login_account" id="login_account" autocomplete="off" />
          </div>
      </div>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Login Password', null, '密碼')?></label>
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" placeholder="<?php G::te($theme_lang, 'Login Password', null, '密碼')?>" name="login_password"/>
          </div>
      </div>

	<?php if(isset($_SESSION['error_num']) and $_SESSION['error_num'] >= 3):?>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Captcha', null, '驗證碼')?></label>
          <div class="input-icon left">
            <i class="icon-lock"></i>
			<input class="form-control placeholder-no-fix" style="width:168px;display:inline;" type="text" placeholder="<?php G::te($theme_lang, 'Captcha', null, '驗證碼')?>" name="captcha"/>
			<img style="height:34px" onclick="var token = new Date();this.src='?r=auth/captcha2/'+ (token++);" src="?r=auth/captcha2" />
          </div>
      </div>
	<?php endif?>
	
	<?php if(0):?>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Select Language', null, '選擇語言')?></label>
          <div class="input-icon left">
			<select id="lang_select" name="lang_select" class="m-wrap form-control" style="width:289px">
				<option value=""><?php G::te($theme_lang, 'Default Language', null, '預設語系')?></option>

				<?php foreach($mls as $k => $v):?>
				<option value="<?php echo $k?>" <?php if(isset($admin_switch_interface_ml_key) and $admin_switch_interface_ml_key == $k):?>selected="selected"<?php endif;?> ><?php echo $v?></option>
				<?php endforeach; ?>
			</select>
          </div>
      </div>
	<?php endif?>

      <div class="form-actions">
        <label class="checkbox">
        <input type="checkbox" name="keep_login" value="1"/> <?php G::te($theme_lang, 'Keep Login', null, '保持登入狀態')?>
        </label>
        <button type="submit" class="btn green pull-right">
        <?php G::te($theme_lang, 'Login Button', null, '登入')?> <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>

	  <input type="hidden" name="current_base64_url" value="<?php echo str_replace('"','',$current_base64_url)?>" />

		<?php if(1):// 2019-06-03 寫死介面語系，台灣半導體在用的 (auth_) (admin_interface_ml_key) ?>
			  <input type="hidden" name="select_language" value="tw" />
		<?php endif?>

<?php if(0):?>
      <div class="forget-password">
        <h4>Forgot your password ?</h4>
        <p>
          no worries, click <a href="javascript:;" class="" id="forget-password">here</a>
          to reset your password.
        </p>
      </div>
      <div class="create-account">
        <p>
          Don't have an account yet ?&nbsp; 
          <a href="javascript:;" id="register-btn" class="">Create an account</a>
        </p>
      </div>
<?php endif?>
    </form>
    <!-- END LOGIN FORM -->        

<?php if(0):?>
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="form-vertical forget-form" action="index.html">
      <h3 class="">Forget Password ?</h3>
      <p>Enter your e-mail address below to reset your password.</p>
      <div class="form-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
          </div>
        </div>
      </div>
      <div class="form-actions">
        <button type="button" id="back-btn" class="btn">
        <i class="m-icon-swapleft"></i> Back
        </button>
        <button type="submit" class="btn green pull-right">
        Submit <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="form-vertical register-form" action="index.html">
      <h3 class="">Sign Up</h3>
      <p>Enter your account details below:</p>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
          <div class="input-icon left">
            <i class="icon-ok"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="rpassword"/>
          </div>
      </div>
      <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email"/>
          </div>
      </div>
      <div class="form-group">
          <label class="checkbox">
          <input type="checkbox" name="tnc"/> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>  
          <div id="register_tnc_error"></div>
      </div>
      <div class="form-actions">
        <button id="register-back-btn" type="button" class="btn">
        <i class="m-icon-swapleft"></i>  Back
        </button>
        <button type="submit" id="register-submit-btn" class="btn green pull-right">
        Sign Up <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>

    </form>
    <!-- END REGISTRATION FORM -->
<?php endif?>

  </div>
  <!-- END LOGIN -->

  <!-- BEGIN COPYRIGHT -->
  <div class="copyright" style="width:320px">
	<?php if(isset($this->data['sys_configs']['backend_copyright'])):?>
		<?php echo $this->data['sys_configs']['backend_copyright']?>
	<?php else:?>
		<?php if(0):?>
			&copy; BuyersLine百邇來<a href="http://www.buyersline.com.tw/index.php" title="網頁設計">網頁設計</a>公司
		<?php endif?>
		<?php // 經理說要下面要圖，上面只顯示該公司的文字Logo 2015-08-28?>
		<img src="<?php echo $this->assetsUrl.$this->data['template_path']?>/images/logo2.png"><br>© <?php echo date('Y')?> Buyersline Taiwan All Rights Reserved
	<?php endif?>
  </div>
  <!-- END COPYRIGHT -->

	<style type="text/css">
	.alert-error {
	    background-color: #F2DEDE;
	    border-color: #EED3D7;
	    color: #B94A48;
	}
	</style>

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="assets/plugins/respond.min.js"></script>
	<script src="assets/plugins/excanvas.min.js"></script> 
	<![endif]-->   
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>	
	<script type="text/javascript" src="<?php echo $this->assetsUrl.$this->data['template_path']?>/plugins/select2/select2.min.js"></script>     
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/scripts/app.js" type="text/javascript"></script>
	<script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/scripts/login.js" type="text/javascript"></script> 
	<!-- END PAGE LEVEL SCRIPTS --> 
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
