<?php // include 'view/system/form_start.php'// 2018-06-20 取代form開頭的標籤?>
<form class="form_start">

	<div class="blockTitle"><span>CONTACT US</span></div>

	<p class="blockInfoTxt">
		<?php echo t('請填寫在線表格與我們聯繫。')?>
		<label class="must"><?php echo t('為必填')?></label>
	</p>

	<?php if(0):?>
		<?php if($this->data['ml_key'] == 'tw'):?>
		<?php else:?>
			<p class="blockInfoTxt">
				Please fill out the online form to contact with us. 
				<label class="must">Fields marked with * are required</label>
			</p>
		<?php endif?>
	<?php endif?>

	<div class="Bbox_in_2c">
		<div>
			<div class="formItem">
				<label class="must" t="* tw ucfirst">姓名</label>
				<input type="text" id="name" name="name" value="<?php echo $save['name']?>">
			</div>
			<div class="formItem">
				<label t="* tw ucfirst">性別</label>
				<div class="radio">
					<label><input type="radio" name="gender" t="value tw ucfirst" value="男" />  <span t="* tw ucfirst">男</span> </label>
					<label><input type="radio" name="gender" t="value tw ucfirst" value="女" />  <span t="* tw ucfirst">女</span> </label>
				</div>
			</div>
			<div class="formItem">
				<label class="must" t="* tw ucfirst">電話</label>
				<input type="text" id="phone" name="phone" value="<?php echo $save['phone']?>">
			</div>

			<?php if(0)://#23713?>
				<div class="formItem">
					<label><?php echo t('生日')?></label>
					<input type="date" id="birthday" name="birthday">
				</div>
			<?php endif?>

			<div class="formItem">
				<label class="must"><?php echo t('E-Mail','en')?></label>
				<input type="email" id="email" name="email" value="<?php echo $save['email']?>">
			</div>
		</div>
	</div>
	<div class="Bbox_in_1c">
		<div>
			
			<div class="formItem oneLine">
				<label t="* tw ucfirst">地址</label>
				<?php if($this->data['ml_key'] == 'tw'):?>
					<span class="twzipcode"></span>
				<?php endif?>
			</div>
			<div class="formItem">
				<input type="text" name="addr" value="<?php // echo $save['addr'] // 2020-02-10 因為後台沒有addr欄位，所以這裡要註解?>">
			</div>

			<?php if(0):?>
				<div class="formItem">
					<label class="" t="* tw ucfirst">附加照片</label>
					<span class="upFileName"></span>
					<div class="upFileBtn">
						<span t="* tw ucfirst">上傳</span>
						<input type="file" id="fileToUpload" name="fileToUpload">
					</div>
				</div>
			<?php endif?>

			<div class="formItem">
				<label class="must" t="* tw ucfirst">意見</label>
				<textarea id="detail" name="detail"><?php echo $save['detail']?></textarea>
			</div>

			<div class="formItem oneLine">
				<label class="must" t="* tw ucfirst">認證碼</label>
				<input type="text" id="<?php echo t('認證碼')?>" name="captcha" /><img id="valImageId" src="captcha.php" gwidth="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* tw ucfirst">更新認證碼</span></a>
			</div>
		
		</div>
	</div>


	<div>
		<button><i class="fa fa-paper-plane"></i><?php echo t('SEND','en')?></button>
	</div>							
</form>

<?php if(0):?><!-- head_end -->
<link rel="Stylesheet" href="js_v3/jquery-ui/jquery-ui.min.css" />
	<?php if(0):?>
		<script src="js_common/confirm_form.js"></script>
	<?php endif?>
<?php endif?><!-- head_end -->

<?php if(0):?><!-- body_end -->
	<?php if(0 and $this->data['ml_key'] == 'tw'):?>
		<script src="js_v3/twzipcode/jquery.twzipcode-1.7.8.min.js"></script>
	<?php endif?>
	<script src="js_v3/jquery-ui/jquery-ui.min.js"></script>

	<?php if($this->data['ml_key'] == 'tw'):?>
		<script src="js_v3/jquery-ui/datepicker-zh-TW.js"></script>
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
