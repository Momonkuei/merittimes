<?php
// 2020-03-19
$validation = array();

$validation['login_account']['required'] = true;
$validation['login_account']['email'] = true;
$validation['login_password']['required'] = true;
$validation['captcha']['required'] = true;

// 其它範本
// $validation['old_time_3']['selectcheck'] = true;
// $validation['old_time_4']['selectcheck'] = true;
// $validation['old_time_5']['selectcheck'] = true;
// $validation['old_time_1']['selectcheck'] = true;
// $validation['old_addr_1']['selectcheck'] = true;
// $validation['old_addr_1_2']['selectcheck'] = true;
// $validation['new_addr_1']['selectcheck'] = true;
// $validation['new_addr_1_2']['selectcheck'] = true;
// $validation['GGGAAA']['selects'] = true;
//
// 其它範本
// $validation['ggg[]']['roles'] = true; // 多個checkbox範例，可以選多個，記得html上，要加上class="roles"
// $validation['ggg']['required'] = true; // 多個radio範例，只能選一個

//會員登入型態
unset($_constant);
eval('$_constant = CUSTOMER_LOGIN_TYPE'.';');
if($_constant=='email'){
	$_login_account_text = t('Enter your E-mail','en');
}elseif($_constant=='phone'){
	$_login_account_text = t('Enter your Phone','en');
}elseif($_constant=='account'){
	$_login_account_text = t('Enter your Account','en');
}else{
	$_login_account_text = t('Enter your E-mail','en');
}
?>

<div class="memberBlockLogin">
	
	<section class="block">
		<div class="blockTitle"><?php echo t('會員登入')?></div>
		<div class="blockInfo">
			<?php if(0):?>
				xxxxx
			<?php endif?>
		</div>
	</section>

	<section class="block">
		<h4><?php echo t('帳號登入')?></h4>
<?php // include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
<form class="form_start">
			<div class="Bbox_in_2c">
				<div>
					<div class="formItem">
						<label class="must" t="* tw ucfirst">帳號</label>
						<input type="text" id="login_account" name="login_account" placeholder="<?php echo $_login_account_text?>" autocomplete="off">
					</div>
					<div class="formItem">
						<label class="must" t="* tw ucfirst">密碼</label>
						<input type="password" id="login_password" name="login_password" placeholder="<?php echo t('Password','en')?>" autocomplete="off">
					</div>	
				</div>
			</div>
			<div class="formItem oneLine">
				<label class="must" t="* tw ucfirst">認證碼</label>
				<input type="text" id="captcha" name="captcha" autocomplete="off"/><img id="valImageId" src="captcha.php" gwidth="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo t('更新認證碼')?></a>
			</div>						
			<div>
				<button><i class="fa fa-sign-in"></i><?php echo t('登入')?></button> 
				<a class="icon-link" href="memberforget_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-lock"></i> <?php echo t('忘記密碼?')?></a>
			</div>
		</form>
	</section>

<?php if(isset($data['external_member']) && $data['external_member']!=false)://by lota?>

	<div class="hrTitle"><span>OR<?php //echo t('OR','en')?></span></div>

	<section class="block">
		<h4><?php echo t('快速登入')?></h4>
		<form>
		<?php if(preg_match('/fb/',$data['external_member'])):?>
			<a href="facebook.php" class="btn-fb">FACEBOOK</a>
		<?php endif?>
		<?php if(preg_match('/g+/',$data['external_member'])):?>
			<a href="google.php" class="btn-google">GOOGLE</a>	
		<?php endif?>
		<?php if(preg_match('/line/',$data['external_member'])):?>
			<a href="linelogin.php" class=""><img src="https://image.buyersline.com.tw/btn_login_base.png"></a>	
		<?php endif?>	
		</form>
	</section>

<?php endif?>	

<section class="block">
	<h4><?php echo t('尚未成為會員嗎？')?></h4>
	<a href="guestregister_<?php echo $this->data['ml_key']?>.php" class="btn-cis1"><i class="fa fa-user-plus"></i><?php echo t('加入會員')?></a>	
</section>


</div>
