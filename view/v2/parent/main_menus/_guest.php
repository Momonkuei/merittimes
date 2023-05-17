<?php // 會員登入前?>
<?php if(isset($_SESSION['authw_admin_id']) and $_SESSION['authw_admin_id'] != ''):?>
<?php else:?>
	<?php if(!isset($this->data['BODY_START'])):?><?php $this->data['BODY_START']=''?><?php endif?>
	<?php $this->data['BODY_START'] .= <<<XXX
<script type="text/javascript">
var msgErrorTip2 = '請輸入「%s」';
var msgErrorTip1 = '請輸入要搜尋的關鍵字。';
var msgProcess = '處理中...';
</script><script src="Scripts/confirm_form.js"></script>
XXX;
?>

	<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
	<?php $this->data['BODY_END'] .= <<<XXX
<script type="text/javascript">
$(document).ready(function() {
	$("#帳號,#密碼").keypress(function(e){
		code = (e.keyCode ? e.keyCode : e.which);
		if (code == 13)
		{
			//targetForm是表單的ID
			$("#memberForm").submit();
		}
	});
});
</script>
XXX;
?>

	<li>
		<form class="form-inline" id="memberForm" action="<?php echo $this->createUrl('guest/login')?>" method="post" name="main_form" onsubmit="MM_validateForm('帳號', '', 'R', '密碼', '', 'R', this); return document.MM_returnValue;">
			<div class="input-group input-group-sm">
				<input type="text" class="form-control" id="帳號" name="login_account" placeholder="帳號">
			</div>
			<div class="input-group input-group-sm">
				<input type="password" class="form-control" id="密碼" name="login_password" placeholder="密碼">
			</div>
			<button type="submit" class="btn-sm">登入</button>
			<a class="btn btn-default btn-sm" href="<?php echo $this->createUrl('guest/register')?>">註冊</a>
			<a class="btn-link" href="<?php echo $this->createUrl('guest/forget')?>">忘記密碼</a>
		</form>
	</li>
<?php endif?>
