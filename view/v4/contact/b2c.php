<div class="pageTitleStyle-1"><span>Contact Form<?php // (B2C)?></span></div>
<p><?php echo t('請填寫在線表格與我們聯繫。')?><label class="must"><?php echo t('為必填')?></label></p>
<?php // include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
<form class="form_start">
  <div class="form_group col-lg-6">
	<label class="must" t="* tw ucfirst">姓名</label>
	<input type="text" id="name" name="name" placeholder="" value="<?php echo $save['name']?>">
  </div>
  <div class="form_group col-lg-6">
	<label t="* tw ucfirst">性別</label>
	<select name="gender">
	  <option value="" t="* tw ucfirst">選擇性別</option>
	  <option t="* tw ucfirst" value="男" >男</option>
	  <option t="* tw ucfirst" value="女" >女</option>
	</select>
  </div>
  <div class="form_group col-lg-6">
	<label class="must" t="* tw ucfirst">電話</label>
	<input type="text" id="phone" name="phone" value="<?php echo $save['phone']?>">
  </div>
  <div class="form_group col-lg-6">
	<label class="must"><?php echo t('E-Mail','en')?></label>
	<input type="email" id="email" name="email" value="<?php echo $save['email']?>">
  </div>
  <div class="form_group col-lg-12">
	<label t="* tw ucfirst">地址</label>
	<?php if($this->data['ml_key'] == 'tw'):?>
		<span class="twzipcode"></span>
	<?php endif?>
	<input type="text" name="addr" value="<?php // echo $save['addr'] // 2020-02-10 因為後台沒有addr欄位，所以這裡要註解?>">
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
  </div>
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
	</div> -->
	<!-- .even_controlBox -->
  </div>
</form>

<?php if(0):?><!-- head_end -->
<link rel="Stylesheet" href="js_v4/jquery-ui/jquery-ui.min.css" />
	<?php if(0):?>
		<script src="js_common/confirm_form.js"></script>
	<?php endif?>
<?php endif?><!-- head_end -->

<?php if(0):?><!-- body_end -->
	<?php if(0 and $this->data['ml_key'] == 'tw'):?>
		<script src="js_v4/twzipcode/jquery.twzipcode-1.7.8.min.js"></script>
	<?php endif?>
	<script src="js_v4/jquery-ui/jquery-ui.min.js"></script>

	<?php if($this->data['ml_key'] == 'tw'):?>
		<script src="js_v4/jquery-ui/datepicker-zh-TW.js"></script>
	<?php endif?>

	<script type="text/javascript">

		<?php if(0 and $this->data['ml_key'] == 'tw'):?>
			<?php if($this->data['ml_key'] == 'tw'):?>
				$('#twzipcode').twzipcode();
			<?php endif?>

			//設定中文語系
			$.datepicker.regional['zh-TW']={
			   dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
			   dayNamesMin:["日","一","二","三","四","五","六"],
			   monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
			   monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
			   prevText:"上月",
			   nextText:"次月",
			   weekHeader:"週"
			};
			//將預設語系設定為中文
			$.datepicker.setDefaults($.datepicker.regional["zh-TW"]);

			// 目前這個用不到囉
			$("#birthday").datepicker({ 
				dateFormat: 'yy-mm-dd',
				yearRange: "-80:+0",
				changeYear:true
			});
		<?php endif?>

	</script>	
<?php endif?><!-- body_end -->
