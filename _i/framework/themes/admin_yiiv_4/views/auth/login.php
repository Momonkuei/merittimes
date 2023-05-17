<?php $theme_lang = 'adminlogin7'?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'])?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/metro.css" rel="stylesheet" />
  <link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style.css" rel="stylesheet" />
  <link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style_responsive.css" rel="stylesheet" />
  <link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl.$this->data['template_path']?>/uniform/css/uniform.default.css" />
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
	$('#employee_account').focus();

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
  <div class="logo">
    <img src="<?php echo $this->assetsUrl?>/images/EOBinternational.png" alt="" /> 
<?php if(0):?>
<?php endif?>
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
	<form class="form-vertical login-form" id="loginform" action="?r=auth/login" method="post">
      <h3 class="form-title"><?php G::te($theme_lang, 'Login to your account', null, '登入')?></h3>
      <div class="alert alert-error <?php if($status <= 0):?>hide<?php endif?>">
        <button class="close" data-dismiss="alert"></button>
        <span>請輸入正確的帳號以及密碼或驗證碼</span>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Login Account', null, '使用者名稱')?></label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="<?php G::te($theme_lang, 'Login Account', null, '使用者名稱')?>" name="employee_account" id="employee_account"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Login Password', null, '密碼')?></label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="<?php G::te($theme_lang, 'Login Password', null, '密碼')?>" name="employee_password"/>
          </div>
        </div>
      </div>

	<?php if(!isset($have_auto_login) or $have_auto_login == ''):?>
	<?php //if((!isset($have_auto_login) or $have_auto_login == '') and 0):?>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Captcha', null, '驗證碼')?></label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
				<input class="m-wrap placeholder-no-fix" style="width:168px" type="text" placeholder="<?php G::te($theme_lang, 'Captcha', null, '驗證碼')?>" name="captcha"/>
			<img style="height:34px" onclick="var token = new Date();this.src='?r=auth/captcha2/'+ (token++);" src="?r=auth/captcha2" />
          </div>
        </div>
      </div>
	<?php endif?>
	
	<?php if(0):?>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9"><?php G::te($theme_lang, 'Select Language', null, '選擇語言')?></label>
        <div class="controls">
          <div class="input-icon left">
			<select id="lang_select" name="lang_select" class="m-wrap" style="width:289px">
				<option value=""><?php G::te($theme_lang, 'Default Language', null, '預設語系')?></option>

				<?php foreach($mls as $k => $v):?>
				<option value="<?php echo $k?>" <?php if(isset($admin_switch_interface_ml_key) and $admin_switch_interface_ml_key == $k):?>selected="selected"<?php endif;?> ><?php echo $v?></option>
				<?php endforeach; ?>
			</select>
          </div>
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

	  <input type="hidden" name="current_base64_url" value="<?php echo $current_base64_url?>" />

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
      <div class="control-group">
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
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="username"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-ok"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="rpassword"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
          <input type="checkbox" name="tnc"/> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>  
          <div id="register_tnc_error"></div>
        </div>
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
	Copyright &copy; 2013 Triple Treasures Co., Ltd. All Rights Reserved.
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/bootstrap/js/bootstrap.min.js"></script>  
  <script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/uniform/jquery.uniform.min.js"></script> 
  <script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/jquery.blockui.js"></script>
  <script src="<?php echo $this->assetsUrl.$this->data['template_path']?>/js/app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      App.initLogin();
    });
  </script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
