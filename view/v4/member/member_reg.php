<?
	$company_member_result = $this->cidb->where('keyname','function_constant_company_member')->get('sys_config')->row_array();
	$company_member_style=$company_member_result["keyval"];
?>
<div class="member_reg">

  <section class="sectionBlock">
    <div class="container">

      <div class="pageTitleStyle-1">
        <span>JOIN US</span>
      </div>
		<?php if(0):?>
			<p>此段文字非正式文字，他青法從神響、代大手北，樂的信下真登老學甚有球又學不看路。是資兒家是現，遊識夠成到調合不王同原明著輕外這起坐心集集沒以在的有臺，了位青間年口能樹人汽修研不條家密度連喜早元出力原居。</p>
		<?php endif?>
      <!-- <div class="formLine"></div> (註冊會員頁面，JOIN US標題下方兩條線怪怪的20220727註解掉)-->
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

      <div class="blockTitle">
        <span>註冊會員</span>
      </div>
		<?php if(0):?>
      <p>xxxxxxxxxEnter your message in the box provided and include as many details as possible to help us assist you with your inquiry. Fields marked with <label class="must">為必填</label></p>
		<?php endif?>

<?php //include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
<form class="form_start">
        <div class="form_group col-lg-4">
			<label  class="must">E-Mail</label>
			<input type="email" id="login_account" name="login_account" value="<?php if(isset($_SESSION['save']['guestlogin']['login_account']) && $save['login_account']==''):?><?php echo $_SESSION['save']['guestlogin']['login_account']?><?php else:?><?php echo $save['login_account']?><?php endif?>">
        </div>
        <div class="form_group col-lg-4">
			<label class="must" t="* tw ucfirst">姓名</label>
			<input type="text" id="name" name="name" value="<?php if(isset($_SESSION['save']['guestlogin']['name']) && $save['name']==''):?><?php echo $_SESSION['save']['guestlogin']['name']?><?php else:?><?php echo $save['name']?><?php endif?>" />
        </div>
        <div class="form_group col-lg-4">
		  <label><?php echo t('性別')?></label>
		  <select name="gender">
		    <option value="1" ><?php echo t('男')?></option>
		    <option value="2" ><?php echo t('女')?></option>
		  </select>
        </div>
		<?if($company_member_style=="true"){?>
			<div class="form_group col-lg-4">
				<label><?php echo t('身分') ?></label>
				<select id="other1" name="other1" onchange="other1change()">
					<option value="1"><?php echo t('一般會員') ?></option>
					<option value="2"><?php echo t('企業會員') ?></option>
				</select>
			</div>
		<?}?>
        <div class="form_group col-lg-4">
			<label class="must" t="* tw ucfirst">密碼</label>
			<input type="password" id="login_password" name="login_password">
        </div>
        <div class="form_group col-lg-4">
			<label class="must" t="* tw ucfirst">再次輸入密碼</label>
			<input type="password" id="login_password_confirm" name="login_password_confirm">
        </div>
        <div class="form_group col-lg-4">
			<label t="* tw ucfirst">生日</label>
			<input type="date" name="birthday" value="<?php echo $save['birthday']?>">
        </div>

        <div class="form_group col-lg-4">
			<label t="* tw ucfirst">電話</label>
			<input type="text" id="phone" name="phone" value="<?php echo $save['phone']?>">
        </div>

		<?php if(0):?>
			<div class="form_group col-lg-12">
			  <label class="must">生日</label>
			  <div class="form_date">
				<div class="row">
				  <div class="col-lg-4">
					<select>
					  <option value="">請選擇年份</option>
					  <?php
						for($i=1900;$i<=2020;$i++) {
						  echo "<option value='$i'>$i</option>";
						}
					  ?>
					</select>
				  </div>
				  <div class="col-lg-4">
					<select>
					  <option value="">請選擇月份</option>
					  <?php
						for($i=1;$i<=12;$i++) {
						  echo "<option value='$i'>$i</option>";
						}
					  ?>
					</select>
				  </div>
				  <div class="col-lg-4">
					<select>
					  <option value="">請選擇日期</option>
					  <?php
						for($i=1;$i<=31;$i++) {
						  echo "<option value='$i'>$i</option>";
						}
					  ?>
					</select>
				  </div>
				</div>
			  </div><!-- .form_date -->
			</div>
		<?php endif?>
        <div class="form_group col-lg-12">
			<label t="* tw ucfirst">地址</label>
			<span class="twzipcode_form_1"></span>
			<input type="text" t="placeholder tw ucfirst" id="addr" name="addr" placeholder="地址">
        </div>
		<?if($company_member_style=="true"){?>
			<div class="form_group col-lg-12" id="company_only" style="display:none">
				<div class="row">
					<div class="form_group col-lg-6">
						<label class="must" t="* tw ucfirst">統一編號</label>
						<input type="text" id="other2" name="other2" value="<?php echo $save['other2']?$save['other2']:"0" ?>"  >
					</div>
					<div class="form_group col-lg-6">
						<label class="must" t="* tw ucfirst">官網連結</label>
						<input type="text" id="other4" name="other4" value="<?php echo $save['other4']?$save['other4']:"0" ?>" >
					</div>

					<div class="form_group col-lg-12">
						<div class=""><label class="must" t="* tw ucfirst">企業介紹</label></div>
						<div class=""><textarea style="height: 300px;" id="other3" name="other3" >0</textarea></div>
					</div>

					<div class="form_group col-lg-4">
						<label class="must" t="* tw ucfirst">LOGO上傳</label>
						<input type="file" id="file1" name="file1" class="btnUpload">
					</div>
				</div>
			</div>
		<?}?>
		<input type="hidden" name="_social_type" value="<?php if(isset($_SESSION['save']['guestlogin']['_social_type']) and $_SESSION['save']['guestlogin']['_social_type'] != ''):?><?php echo $_SESSION['save']['guestlogin']['_social_type']?><?php endif?>" />
		<input type="hidden" name="_social_id" value="<?php if(isset($_SESSION['save']['guestlogin']['_social_id']) and $_SESSION['save']['guestlogin']['_social_id'] != ''):?><?php echo $_SESSION['save']['guestlogin']['_social_id']?><?php endif?>" />
        <div class="form_group col-lg-12">
          <div class="checkBox_group">
			<input type="checkbox" name="need_dm" id="check_news" value="1" checked="checked"/>  
            <label for="check_news"><span class="signIcon"></span><span t="* tw ucfirst">願意收到產品相關訊息或活動資訊</span></label>
          </div>
          <div class="checkBox_group">
			<input type="checkbox" name="accept_privacy" value="1" id="check_privacy" checked="checked"/>
            <label for="check_privacy"><span class="signIcon"></span><a data-fancybox data-src="#memberPrivacy_modal" data-options='{"touch" : false}' href="javascript:;"><?php echo t('同意隱私權政策','tw')?></a></label>
          </div>
          <div class="common_gy_txt"><?php echo t('如有任何問題歡迎來電聯絡。若想知道會員詳請，請參考','tw')?> <a data-fancybox data-src="#memberTerm_modal" data-options='{"touch" : false}' href="javascript:;" t="* tw ucfirst">會員需知</a></div>
        </div>
		  <div class="form_group col-lg-12">
			<label class="must" t="* tw ucfirst">認證碼</label>
			<div class="authenticateCode">
				<input type="text" id="captcha" name="captcha" />
				<img id="valImageId" src="captcha.php" width="100" gheight="40" />
				<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
			</div><!-- .authenticateCode -->
		  </div>
        <div class="form_group col-lg-12">
          <button class="btn-cis1"><i class="fa fa-user" aria-hidden="true"></i><?php echo t('加入會員','tw')?></button>
        </div>
      </form><!-- .cont_form -->

    </div><!-- .container -->
  </section><!-- .sectionBlock -->

</div><!-- .member_reg -->

<?php if(0):?><!-- body_end -->
	<script type="text/javascript">
	var setPoint=1024;
	var mbViewPoint=mbViewPointSet(setPoint);
	function mbViewPointSet(viewPoint){
		viewPoint=(viewPoint>0)?viewPoint:768;
		viewPoint='(max-width: '+viewPoint+'px)';
		viewPoint=window.matchMedia(viewPoint).matches;
		return viewPoint;
	}
	if(!mbViewPoint){
		if($('.twzipcode_form_1').length){
			if(typeof ml_key == 'undefined' || ml_key == 'tw'){
				//$('.twzipcode_form_1').twzipcode();
				$('.twzipcode_form_1').twzipcode({
					countyName: 'addr_county',
					districtName: 'addr_district',
					zipcodeName: 'addr_zipcode',
				});
			}
		}
	}	
</script>
<?php endif?><!-- body_end -->
<script type="text/javascript">
if($('.twzipcode_form_1').length){
	if(typeof ml_key == 'undefined' || ml_key == 'tw'){
		//$('.twzipcode_form_1').twzipcode();
		$('.twzipcode_form_1').twzipcode({
			countyName: 'addr_county',
			districtName: 'addr_district',
			zipcodeName: 'addr_zipcode'
		});
	}
}
</script>
<script type="text/javascript">
		function other1change() {
		var other1 = $('#other1').val();

		if (other1 == '1') {
			$('#other2').val("0");
			$('#other4').val("0");
			$('#other3').text("0");
			$('#company_only').hide();
		} else if (other1 == '2') {
			$('#other2').val("");
			$('#other4').val("");
			$('#other3').text("");
			$('#company_only').show();
		}
	}
</script>