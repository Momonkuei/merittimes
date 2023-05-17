<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php G::tf($this->data['theme_lang'], $this->data['sys_configs']['admin_title'], null, '後台管理')?></title>
		<link href="<?php echo $this->assetsUrl.$this->data['template_path']?>/css/eob.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			body {
				-webkit-text-size-adjust: none;
				font-size: 12px;
				line-height: 20px;
				background-color: #cecece;
				background-image: url(<?php echo $this->assetsUrl.$this->data['template_path'];?>/images/sales_71.jpg);
				background-repeat: repeat;
				background-position: center;
			}
			.login_text {
				color:#fff;
				font-size: 15px;
			}
			.login_error {
				color:red;
			}
		</style>
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
	$('#employee_account').focus()

	$('#lang_select').change(function(){
		if($(this).val() != ''){
			window.location.href='{$class_url}/switchloginml&ml_key=' + $(this).val();
		}
	});
});
XXX0;
Yii::app()->clientScript->registerScript('login_js', $login, CClientScript::POS_READY);
?>
	</head>

	<body>
		<form id="loginform" action="?r=auth/login" method="post">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td height="247" align="center" valign="top" class="login2">
						<table width="268" border="0" cellpadding="0" cellspacing="0" class="login3">
							<?php if($status > 0): ?>
								<tr>
									<td height="48" align="left" valign="top">
										<span class="login_text login_error"><?php G::te($theme_lang, 'Login Failed', null, '帳號或密碼錯誤！')?></span>
									</td>
								</tr>
							<?php endif?>
							<tr>
								<td height="44" align="left" valign="top">
									<label class="login_text"><?php G::te($theme_lang, 'Login Account', null, '使用者名稱')?>：</label><input name="employee_account" id="employee_account" class="login01x" type="text" required="required" />
								</td>
							</tr>
							<tr><td height="4"></td></tr>
							<tr>
								<td height="44" align="left" valign="top">
									<label class="login_text"><?php G::te($theme_lang, 'Login Password', null, '密碼')?>：</label>
									<input name="employee_password" id="employee_password" type="password" required="required" />
								</td>
							</tr>
							<tr><td height="4"></td></tr>
<?php if(0):?>
							<tr>
								<td height="20" align="left" valign="top">
									<label for="lang_select" class="login_text"><?php G::te($theme_lang, 'Select Language', null, '選擇語言')?></label>
									<select id="lang_select" name="lang_select">
										<option value=""><?php G::te($theme_lang, 'Default Language', null, '預設語系')?></option>

										<?php foreach($mls as $k => $v):?>
										<option value="<?php echo $k?>" <?php if(isset($admin_switch_interface_ml_key) and $admin_switch_interface_ml_key == $k):?>selected="selected"<?php endif;?> ><?php echo $v?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
<?php endif?>
							<tr><td height="4"></td></tr>
							<tr>
								<td height="20" align="left" valign="top">
								<label class="login_text"><?php G::te($theme_lang, 'Keep Login', null, '保持登入狀態')?>：<input type="checkbox" name="keep_login" value="1"></label>
							</tr>
							<?php if(!isset($have_auto_login) or $have_auto_login == ''):?>
							<tr><td height="8"></td></tr>
							<tr>
								<td height="20" align="left" valign="top">
									<table width="100%">
										<tr>
											<td>
												<label class="login_text"><?php G::te($theme_lang, 'Captcha', null, '驗證碼')?>：</label>
											</td>
										<td>
											<img onclick="var token = new Date();this.src='?r=auth/captcha2/'+ (token++);" src="?r=auth/captcha2" />
										</td>
										<td>
											<input type="text" id="captcha" name="captcha" size="4" required="required" />
										</td>
										</tr>
									</table>
								</td>
							</tr>
							<?php endif?>
							<tr><td height="4"></td></tr>
							<tr>
								<td align="left" valign="top">
									<button id="loginbtn" class="button gray" type="submit"><?php G::te($theme_lang, 'Login Button', null, '登入')?></button>
<?php if(0):?>
									<a href="#" title="確定登入" onclick="$('#loginform').submit()">
										<img src="<?php echo $this->assetsUrl.$this->data['template_path'];?>/images/login_03.jpg" width="260" height="30" border="0" onmouseover="this.src='<?php echo $this->assetsUrl.$this->data['template_path'];?>/images/loginb_03.jpg'" onmouseout="this.src='<?php echo $this->assetsUrl.$this->data['template_path'];?>/images/login_03.jpg'"/>
									</a>
<?php endif?>
								</td>
							</tr>
							<?php // 底下只是補高度而以，為了能夠顯示圖片的尾巴?>
							<?php if(!isset($status)): ?>
							<tr><td height="4"></td></tr>
							<tr>
								<td height="48" align="left" valign="top">&nbsp;
								</td>
							</tr>
							<?php else:?>
							<tr>
								<td height="65" align="left" valign="top">&nbsp;
								</td>
							</tr>
							<?php endif?>
							<?php if(!isset($have_auto_login) or $have_auto_login == ''):?>
							<?php else:?>
							<tr>
								<td height="65" align="left" valign="top">&nbsp;
								</td>
							</tr>
							<?php endif?>
						</table>
					</td>
				</tr>
			</table>
			<input type="hidden" name="current_base64_url" value="<?php echo $current_base64_url?>" />
		</form>
	</body>
</html>
