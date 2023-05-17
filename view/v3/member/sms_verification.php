<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo ('驗證碼')?>','','R', this); return document.MM_returnValue;">

	<div class="blockTitle"><?php echo t('驗證手機簡訊')?></div>
	<p class="blockInfoTxt">
		<label class="must"><?php echo t('為必填')?></label>
	</p>					
	<div class="Bbox_in_3c">
		<div>
			<div class="formItem">
				<label class="must"><?php echo t('驗證碼')?></label>
				<input type="password" id="<?php echo t('驗證碼')?>" name="sms_verification" placeholder="" inputmode="numeric" autocomplete="one-time-code">
			</div>
		</div>
	</div>


<?php if(0):?>
	<div class="formItem oneLine">
		<label class="must"><?php echo t('認證碼')?></label>
		<input type="text"><img src="<?=$imgPath?>demo/checkcode.jpg" width="100" height="40"><a href="" class="icon-link"><i class="fa fa-refresh" aria-hidden="true"></i>更新驗證碼</a>
	</div>
<?php endif?>
							
	<div class="Bbox_flexBetween">
		<button><i class="fa fa-check"></i><?php echo t('完成')?></button>
	</div>
</form>

<a href="memberverification_<?php echo $this->data['ml_key']?>.php?resend=1" class="btn-cis1" id="memberverification" data-status='edit'><i class="fa fa-pencil"></i><?php echo t('重新寄發簡訊驗證')?></a>

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
<?php endif?><!-- body_end -->
