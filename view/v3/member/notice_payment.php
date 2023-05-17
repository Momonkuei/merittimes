<form action="" method="post" name="memberForm" id="memberForm" onsubmit="MM_validateForm('<?php echo t('匯款日期')?>','','R','<?php echo t('匯款銀行')?>','','R','<?php echo t('匯款金額')?>','', 'R', '<?php echo t('帳號末五碼')?>', '', 'R', '<?php echo t('意見')?>', '', 'R', '<?php echo t('認證碼')?>', '', 'R', this); return document.MM_returnValue;">

	<div class="blockTitle"><span><?php echo t('通知付款')?></span></div>
	<p class="blockInfoTxt">					
		<?php // XXX?>
		<label class="must"><?php echo t('為必填')?></label>
	</p>					

	<input type="hidden" name="order_number" value="<?php echo $data[$ID]['order_number']?>" />

	<div class="formItem">
		<label><?php echo t('訂購人')?>：<?php echo $data[$ID]['buyer_name']?></label>
	</div>	
	<div class="formItem">
		<label><?php echo t('訂單編號')?>：<?php echo $data[$ID]['order_number']?></label>
	</div>					
	<div class="formItem">
		<label><?php echo t('訂單金額')?>：$<?php echo number_format($data[$ID]['total'])?></label>
	</div>			
	<div class="hrTitle"><span><?php echo t('填寫表單')?></span></div>
	<div class="Bbox_in_2c">
		<div>

			<div class="formItem">
				<label class="must"><?php echo t('匯款日期')?></label>
				<input type="date" id="<?php echo t('匯款日期')?>" name="atm_date" value="<?php //echo $data[$ID]['atm_date']?>">
			</div>
								


			<div class="formItem">
				<label class="must"><?php echo t('匯款銀行')?></label>
				<input type="text" id="<?php echo t('匯款銀行')?>" name="atm_bank" value="<?php //echo $data[$ID]['atm_bank']?>">
			</div>
								



			<div class="formItem">
				<label class="must"><?php echo t('匯款金額')?></label>
				<input type="text" id="<?php echo t('匯款金額')?>" name="atm_price" value="<?php //echo $data[$ID]['atm_price']?>">
			</div>
								


			<div class="formItem">
				<label class="must"><?php echo t('帳號末五碼')?></label>
				<input type="text" id="<?php echo t('帳號末五碼')?>" name="atm_number" value="<?php // echo $data[$ID]['atm_number']?>">
			</div>
							
		</div>

	</div>

	<div class="formItem">
		<label class="big"><?php echo t('備註')?></label>
		<textarea name="atm_comment"></textarea>
	</div>

	<div class="Bbox_flexBetween">
		<div class="formItem oneLine">
			<label class="must"><?php echo t('認證碼')?></label>
			<input type="text" id="<?php echo t('認證碼')?>" name="captcha" /><img id="valImageId" src="captcha.php" width="100" gheight="40" /><a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo t('更新認證碼')?></a>
		</div>
								
		<div class="">
			<a class="btn-prev" href="<?php echo $_SERVER['HTTP_REFERER']?>"><i class="fa fa-reply"></i><?php echo t('返回')?></a>
			<button><i class="fa fa-paper-plane"></i><?php echo t('送出')?></button>
		</div>
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
$("input[name=atm_price],input[name=atm_number]").keydown(function (e) {
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
