<?php
/*
 * 2018-06-04 這是一個表單的範本
 */
?>
<form target="hideframe" action="" method="post" name="memberForm" id="form_data" <?php // enctype="multipart/form-data" ?> > <input type="hidden" name="gtoken" class="gtoken" />

	<?php // https://stackoverflow.com/questions/7083325/firefox-form-targeting-an-iframe-is-opening-new-tab?noredirect=1&lq=1?>
	<iframe id="hideframe" name="hideframe" style="display:none" src=""></iframe>
	<input id="force_save" type="hidden" name="123" />

	<input type="text" id="name" name="name" placeholder="">

	<input type="radio" name="gender" value="1"> <span t="* tw ucfirst">男</span>
	<input type="radio" name="gender" value="2"> <span t="* tw ucfirst">女</span>

	<input type="text" id="company_name" name="company_name" placeholder="">

	<input type="text" id="fax" name="fax" placeholder="">
	<input type="text" id="phone" name="phone" placeholder="">
	<input type="text" id="exten" name="exten" placeholder="">

	<input type="email" id="email" name="email" placeholder="">

	<?php if($this->data['ml_key'] == 'tw'):?>
		<span class="twzipcode"></span>
	<?php endif?>
	<input type="text" name="addr">

	<input type="file" id="fileToUpload" name="fileToUpload">

	<textarea id="detail" name="detail"></textarea>

	<input type="text" id="captcha" name="captcha" />
	<img id="valImageId" src="captcha.php" width="100" gheight="40" />
	<a href="javascript:void(0)" class="icon-link" onclick="RefreshImage('valImageId')"><span t="* tw ucfirst">更新認證碼</span></a>

	<button t="* en ucfirst">SEND</button>	

</form>

<?php // 這裡要放view/system/default_validate.php?>
<?php echo $AA?>

<?php if(0):?><!-- body_end -->
	<script src="js_common/reload.js"></script>
<?php endif?><!-- body_end -->
