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
	$('#login_account').focus()

	$('#lang_select').change(function(){
		if($(this).val() != ''){
			window.location.href='{$class_url}/switchloginml&ml_key=' + $(this).val();
		}
	});
});
XXX0;
Yii::app()->clientScript->registerScript('login_js', $login, CClientScript::POS_READY);
?>

<?php
$login_css = <<<XXX1
#login_account,#login_password {
	width:230px;
}
XXX1;
Yii::app()->clientScript->registerCss('login_css', $login_css);
?>

<div id="login" class="box">
	<h2>Login</h2>
	<section>
		<?php if($status > 0){ ?>
		<div class="error msg"><?php G::te($theme_lang, 'Login Failed', null, '帳號或密碼錯誤！')?></div>
		<?php } ?>
		<form id="login-form" action="?r=auth/login" method="post">
			<dl>
				<dt>
					<label for="login_account" class="required"><?php G::te($theme_lang, 'Login Account', null, '使用者名稱')?><span class="required">*</span></label>
				</dt>
				<dd>
					<input name="login_account" id="login_account" type="text" required="required" />
				</dd>
				<dt>
					<label for="login_password" class="required"><?php G::te($theme_lang, 'Login Password', null, '密碼')?><span class="required">*</span></label>
				</dt>
				<dd>
					<input name="login_password" id="login_password" type="password" required="required" />
				</dd>
				<dt style="display:none">
					<label for="lang_select" class="required"><?php G::te($theme_lang, 'Select Language', null, '選擇語言')?></label>
				</dt>
				<dd style="display:none">
					<select id="lang_select" name="lang_select">
						<option value=""><?php G::te($theme_lang, 'Default Language', null, '預設語系')?></option>

						<?php foreach($mls as $k => $v):?>
						<option value="<?php echo $k?>" <?php if(isset($admin_switch_interface_ml_key) and $admin_switch_interface_ml_key == $k):?>selected="selected"<?php endif;?> ><?php echo $v?></option>
						<?php endforeach; ?>
					</select>
				</dd>
<?php if(!isset($have_auto_login) or $have_auto_login == ''):?>
				<dt>
					<label for="captcha" class="required"><?php G::te($theme_lang, 'Captcha', null, '驗證碼')?><span class="required">*</span></label>
				</dt>
				<dd>
					<img onclick="var token = new Date();this.src='?r=auth/captcha'+ (token++);" src="?r=auth/captcha" />
					<input type="text" id="captcha" name="captcha" size="6" required="required" />
				</dd>
<?php endif?>
			</dl>
<?php if(0):?>
			<label><input type="checkbox" name="keep_login" value="1"><?php G::te($theme_lang, 'Keep Login', null, '保持登入狀態')?></label>
<?php endif?>
			<p>
				<button id="loginbtn" class="button gray" type="submit"><?php G::te($theme_lang, 'Login Button', null, '登入')?></button>
<?php if(0):?>
				<!-- <a href="#" id="forgot">忘記密碼？</a> -->
<?php endif;?>
			</p>
				<input type="hidden" name="current_base64_url" value="<?php echo $current_base64_url?>" />
		</form>
	</section>
</div>
