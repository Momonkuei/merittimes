<div class="contact_form"><h1><?php echo G::t(null,'請填寫在線表格與我們聯繫。')?></h1>
<div class="contact_add"><?php //=GetSiteContent("聯絡我們表單上方資訊")?></div>
<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm(l.get('姓名'),'','R',l.get('E-Mail'),'','RisEmail',l.get('電話'),'', 'R', l.get('公司名稱'), '', 'R', l.get('意見'), '', 'R', l.get('驗證碼'), '', 'R', this); return document.MM_returnValue;" <?php // enctype="multipart/form-data" ?> target="hidFrame" >
<table border="0" cellspacing="0" cellpadding="3">
	<tr>
		<th><div align="right"><span class="c_orang">*</span> <?php echo G::t(null,'姓名')?>：</div></th>
		<td><input name="name" type="text" id="<?php echo G::t(null,'姓名')?>" class="label" /></td>
	</tr>
	<tr>
		<th><div align="right"><span class="c_orang">*</span> <?php echo G::t(null,'公司名稱')?>：</div></th>
		<td><input name="company_name" type="text" id="<?php echo G::t(null,'公司名稱')?>" class="label" /></td>
	</tr>
	<tr>
		<th><div align="right"> <?php echo G::t(null,'傳真')?>：</div></th>
		<td><input name="fax" type="text" id="<?php echo G::t(null,'傳真')?>" class="label" /></td>
	</tr>
	<tr>
		<th><div align="right"><span class="c_orang">*</span> <?php echo G::t(null,'電話')?>：</div></th>
		<td><input name="phone" type="text" id="<?php echo G::t(null,'電話')?>" class="label" /></td>
	</tr>
	<tr>
		<th><div align="right"> <?php echo G::t(null,'分機')?>：</div></th>
		<td><input name="exten" type="text" id="<?php echo G::t(null,'分機')?>" class="label" /></td>
	</tr>
	<tr>
		<th><div align="right"><span class="c_orang">*</span> <?php echo G::t(null,'E-Mail')?>：</div></th>
		<td><input name="email" type="text" id="<?php echo G::t(null,'E-Mail')?>" class="label" /></td>
	</tr>
	<tr>
		<th><div align="right"><?php echo G::t(null,'地址')?>：</div></th>
		<td><input name="addr" type="text" id="<?php echo G::t(null,'地址')?>" class="label" /></td>
	</tr>
	<tr>
		<th><div align="right"><span class="c_orang">*</span> <?php echo G::t(null,'意見')?>：</div></th>
		<td><textarea name="detail" id="<?php echo G::t(null,'意見')?>" rows="5"></textarea></td>
	</tr>
	<tr>
		<th><div align="right"><span class="c_orang">*</span> <?php echo G::t(null,'認證碼')?>：</div></th>
		<td><input type="text" id="<?php echo G::t(null,'驗證碼')?>" name="captcha" /><img id="valImageId" src="captcha.php" width="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo G::t(null,'更新驗證碼')?></a></td>
	</tr>
	<tr>
		<th></th>
		<td><!--<img border="0" src="ctt/images/temp_a/ico_cancel.png" name="Image20" class="but_cancel" onclick="this.form.reset(); return false;" />-->
        <input border="0" src="ctt/images/temp_a/ico_send.png" type="image" name="Image21" class="but_send" /></td>
	</tr>
</table>
</form>
<iframe name="hidFrame" style="display:none"></iframe>
<?php //=GetSiteContent("聯絡我們表單下方資訊")?>
</div>

<?php if(0):?><!-- head_end -->
<script type="text/javascript">
var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
var msgErrorTip2 = '<?php echo G::t(null,'請輸入')?>「%s」';
var msgErrorTip3 = '<?php echo G::t(null,'E-Mail')?>，請輸入正確的Email格式';
var msgProcess = '處理中...';
</script>
<script src="js/confirm_form.js"></script>
<?php endif?><!-- head_end -->

<?php if(0):?><!-- body_end -->
<script src="js/reload.js"></script>
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
