<form target="hideframe" action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('姓名')?>','','R','<?php echo t('E-Mail','en')?>','','RisEmail','<?php echo t('電話')?>','', 'R', '<?php echo t('公司名稱')?>', '', 'R', '<?php echo t('意見')?>', '', 'R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;" <?php // enctype="multipart/form-data" ?> > <input type="hidden" name="gtoken" class="gtoken" />

	<?php // https://stackoverflow.com/questions/7083325/firefox-form-targeting-an-iframe-is-opening-new-tab?noredirect=1&lq=1?>
	<iframe id="hideframe" name="hideframe" style="display:none" src=""></iframe>

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
				<label class="must" t="* * ucfirst">姓名</label>
				<input type="text" id="<?php echo t('姓名')?>" name="name" placeholder="">
			</div>
			<div class="formItem">
				<label t="* * ucfirst">性別</label>
				<div class="radio">
					<label><input type="radio" name="sex" value="1"> <span t="* * ucfirst">男</span> </label>
					<label><input type="radio" name="sex" value="2"> <span t="* * ucfirst">女</span> </label>
				</div>
			</div>
			<div class="formItem">
				<label class="must" t="* * ucfirst">公司名稱</label>
				<input type="text" id="<?php echo t('公司名稱')?>" name="company_name" placeholder="">
			</div>
			<div class="formItem">
				<label t="* * ucfirst">傳真</label>
				<input type="text" name="fax" placeholder="">
			</div>
			<div class="formItem">
				<label class="must" t="* * ucfirst">電話</label>
				<input type="text" id="<?php echo t('電話')?>" name="phone" placeholder="">
			</div>
			<div class="formItem">
				<label t="* * ucfirst">分機</label>
				<input type="text" name="exten" placeholder="">
			</div>
		</div>
	</div>
	<div class="Bbox_in_1c">
		<div>
			<div class="formItem">
				<label class="must"><?php echo t('E-Mail','en')?></label>
				<input type="email" id="<?php echo t('E-Mail','en')?>" name="email" placeholder="">
			</div>
			<div class="formItem oneLine">
				<label t="* * ucfirst">地址</label>
				<span class="twzipcode"></span>
			</div>
			<div class="formItem">
				<input type="text" name="addr" placeholder="<?php echo t('地址')?>">
			</div>

<?php if(0):?>
			<div class="formItem">
				<label class="" t="* * ucfirst">附加照片</label>
				<span class="upFileName"></span>
				<div class="upFileBtn">
					<span t="* * ucfirst">上傳</span>
					<input type="file" id="fileToUpload" name="fileToUpload">
				</div>
			</div>
<?php endif?>

			<div class="formItem">
				<label class="must" t="* * ucfirst">意見</label>
				<textarea id="<?php echo t('意見')?>" name="detail"></textarea>
			</div>

			<div class="formItem oneLine">
				<label class="must" t="* * ucfirst">認證碼</label>
				<input type="text" id="<?php echo t('認證碼')?>" name="captcha" /><img id="valImageId" src="captcha.php" width="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><span t="* * ucfirst"><?php echo t('更新認證碼')?></span></a>
			</div>
		
		</div>
	</div>


	<div>
		<button><i class="fa fa-paper-plane"></i><?php echo t('SEND','en')?></button>	
	</div>							
</form>

<?php if(0):?><!-- head_end -->
<script type="text/javascript">
var msgErrorTip1 = '<?php echo t('請輸入要搜尋的關鍵字。')?>';
var msgErrorTip2 = '<?php echo t('請輸入')?>「%s」';
var msgErrorTip3 = '<?php echo t('E-Mail','en')?>，<?php echo t('請輸入正確的Email格式')?>';
var msgProcess = '<?php echo t('處理中')?>...';
</script>
<script src="js_common/confirm_form.js"></script>
<?php endif?><!-- head_end -->

<?php if(0):?><!-- body_end -->
<script src="js_common/reload.js"></script>
<script type="text/javascript">
$("input[name=phone],input[name=fax],input[name=exten]").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>
<?php endif?><!-- body_end -->
