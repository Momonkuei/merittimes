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
?>

<div class="member_login">

  <section class="sectionBlock">
	<div class="container">

		<?php if(0):?>
	  <div class="pageTitleStyle-1">
		<span>USER LOGIN</span>
	  </div>
	  <p>此段文字非正式文字，他青法從神響、代大手北，樂的信下真登老學甚有球又學不看路。是資兒家是現，遊識夠成到調合不王同原明著輕外這起坐心集集沒以在的有臺，了位青間年口能樹人汽修研不條家密度連喜早元出力原居。</p>
	  <div class="formLine"></div>

	  <div class="blockTitle">
		<span>帳號登入</span>
	  </div>
		<?php endif?>

<?php // include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
<form class="form_start">
		<div class="form_group col-lg-5">
			<label class="must" t="* tw ucfirst">帳號</label>
			<input type="text" id="login_account" name="login_account" placeholder="<?php echo t('Enter your E-mail','en')?>">
		</div>
		<div class="form_group col-lg-5">
			<label class="must" t="* tw ucfirst">密碼</label>
			<input type="password" id="login_password" name="login_password" placeholder="<?php echo t('Password','en')?>">
		</div>
		<?php if(0):?>
			<div class="form_group col-lg-2 switch_password">
			  <span class="icon-link toggle-password"><i class="fa fa-eye" aria-hidden="true"></i><span class="toggleText">顯示密碼</span></span>
			</div>
		<?php endif?>
		  <div class="form_group col-lg-12">
			<label class="must" t="* tw ucfirst">認證碼</label>
			<div class="authenticateCode">
				<input type="text" id="captcha" name="captcha" />
				<img id="valImageId" src="captcha.php" width="100" gheight="40" />
				<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
			</div><!-- .authenticateCode -->
		  </div>
		<div class="form_group col-lg-12">
		  <button class="btn-cis1"><i class="fa fa-sign-out" aria-hidden="true"></i><?php echo t('登入')?></button>
		  <a class="icon-link" href="memberforget_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-expeditedssl" aria-hidden="true"></i> <?php echo t('忘記密碼?')?></a>
		</div>
	  </form><!-- .cont_form -->

	  <div class="innerBlock_small fast_loginBtn">
		<?php if(0):?>
			<div class="blockTitle">
			  <span>快速登入</span>
			</div>
		<?php endif?>
		<div>
			<?php if(preg_match('/fb/',$data['external_member'])):?>
				<a href="facebook.php" class="btn-white"><span class="icon_mbm icon_fb"></span>FACEBOOK</a>
			<?php endif?>
			<?php if(preg_match('/g+/',$data['external_member'])):?>
				<a href="google.php" class="btn-white"><span class="icon_mbm icon_google"></span>GOOGLE</a>	
			<?php endif?>
			<?php if(preg_match('/line/',$data['external_member'])):?>
				<a href="linelogin.php" class="btn-white"><span class="icon_mbm icon_line"></span></a>	
			<?php endif?>	
		</div>
	  </div><!-- .innerBlock_small -->

	  <div class="innerBlock_small SignUp_now">
		<div class="blockTitle">
		  <span><?php echo t('尚未成為會員嗎？')?></span>
		</div>
		<div><a class="btn-cis1" href="guestregister_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-user" aria-hidden="true"></i><?php echo t('加入會員')?></a></div>
	  </div><!-- .innerBlock_small -->

	</div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_login -->
