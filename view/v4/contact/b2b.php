<div class="pageTitleStyle-1"><span>Contact Form<?php //(B2B)?></span></div>
<p><?php echo t('請填寫在線表格與我們聯繫。')?><label class="must"><?php echo t('為必填')?></label></p>
<?php // include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
<form class="form_start">
  <div class="form_group col-lg-6">
	<label class="must" t="* tw ucfirst">姓名</label>
	<input type="text" id="name" name="name" placeholder="" value="<?php echo $save['name']?>">
  </div>
  <!-- <div class="form_group col-lg-6">
	<label>性別</label>
	<select>
	  <option>選擇性別</option>
	  <option>男</option>
	  <option>女</option>
	</select>
  </div> -->
  <div class="form_group col-lg-6">
	<label class="must" t="* tw ucfirst">公司名稱</label>
	<input type="text" id="company_name" name="company_name" placeholder="" value="<?php echo $save['company_name']?>">
  </div>
  <div class="form_group col-lg-6">
	<label class="must" t="* tw ucfirst">電話</label>
	<input type="text" id="phone" name="phone" placeholder="" value="<?php echo $save['phone']?>">
  </div>
  <div class="form_group col-lg-6">
	<label class="" t="* tw ucfirst">分機</label>
	<input type="text" id="exten" name="exten" placeholder="" value="<?php echo $save['exten']?>">
  </div>
  <?php //#38811?>
  <div class="form_group col-lg-6">
	<label t="* tw ucfirst">傳真</label>
	<input type="text" id="fax" name="fax" placeholder="" value="<?php echo $save['fax']?>">
  </div>
<?php if(0):?>
	<?php
	$rows = $this->cidb->where('is_enable',1)->order_by('name','asc')->get('country')->result_array();
	foreach($rows as $k => $v){
		$v['value'] = $v['name'];

		// $v['name'] = t($v['name'],'en');
		if($this->data['ml_key'] == 'tw'){
			$v['name'] = $v['tw'];
		}
		$rows[$k] = $v;
	}
	$this->data['country'] = $rows;
	?>
	<div style="display:none" k="aabbcccountry">
	    <option value="" l="list">Please Select</option>
	</div>
	<div class="form_group col-lg-6">
		<label class="must" t="* tw ucfirst">國家</label>
		<select name="other1" l="layer" ls="country" kg="aabbcccountry">
		    <option value="{/value/}" l="list">{/name/}</option>
		</select>
	</div>
<?php endif?>
  <div class="form_group col-lg-12">
	<label class="must">E-Mail</label>
	<input type="email" id="email" name="email" placeholder="" value="<?php echo $save['email']?>">
  </div>
  <div class="form_group col-lg-12">
	<label t="* tw ucfirst">地址</label>
	<span class="twzipcode"></span>
	<input type="text" id="addr" name="addr" placeholder="<?php echo t('地址')?>" value="<?php // echo $save['addr'] // 2020-02-10 因為後台沒有addr欄位，所以這裡要註解?>">
  </div>
  <div class="form_group col-lg-12">
	<label class="must" t="* tw ucfirst">備註</label><?php ////2021-11-29 ming說要改的?>
	<textarea rows="5" cols="80" id="detail" name="detail"><?php echo $save['detail']?></textarea>
  </div>
  <div class="form_group col-lg-12">
	<label class="must" t="* tw ucfirst">認證碼</label>
	<div class="authenticateCode">
		<input type="text" id="captcha" name="captcha" />
		<img id="valImageId" src="captcha.php" width="100" gheight="40" />
		<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
	</div><!-- .authenticateCode -->
	<div><button class="btn-cis1"><?php echo t('SEND','en')?></button></div>
	<?/*<div><button type="button" class="btn-cis1 submitto" onclick="onClick();"><?php echo t('SEND','en')?></button></div>
	<div class="google_text">
		This site is protected by reCAPTCHA and the Google
		<a class="google_text" target="_blank" href="https://policies.google.com/privacy">Privacy Policy</a>
		<a class="google_text" target="_blank" href="https://policies.google.com/terms">Terms of Service</a>
	</div>*/?>
  </div>
  <?php if(0):?>
  <!-- checkbox、raio範例
  <div class="form_group col-lg-12">
	<div class="checkBox_group">
	  <input type="checkbox" id="check_news" checked=""/>
	  <label for="check_news"><span class="signIcon"></span>願意收到產品相關訊息或活動資訊</label>
	</div>
  </div>
  <div class="form_group col-lg-12">
	<div class="even_controlBox">
	  <span class="radioBox_group">
		<input type="radio" id="buyer" name="select_recipient" checked="checked"/>
		<label for="buyer"><span class="signIcon"></span>同訂購人</label>
	  </span>
	  <span class="radioBox_group">
		<input type="radio" id="custom" name="select_recipient"/>
		<label for="custom"><span class="signIcon"></span>自訂</label>
	  </span>
	</div>
  </div> -->
<?php endif?>
</form>
<?/*<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render=6Le8Ag4iAAAAAOnWmL4DVTPJExOxHVSm5t7jNv5b" m="body_end"></script>
<script type="text/javascript" m="body_end">
      function onClick(e) {
        grecaptcha.ready(function() {
          grecaptcha.execute('6Le8Ag4iAAAAAOnWmL4DVTPJExOxHVSm5t7jNv5b', {action: 'submit'}).then(function(token) {
			$.ajax({
				url:'https://shop_v3.web2.buyersline.com.tw/reCAPTCHA.php',
				method:'POST',
				data:{
					token:token
				},
				success:function(res){
					if(res==1){
						// console.log();
						$('#form_data').submit();
					}
				},
				error:function(err){
					console.log(err)
				},
			});
          });
        });
      }
  </script>*/?>