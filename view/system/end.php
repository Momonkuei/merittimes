<?php // 類似php的number_format的js函式?>
<script src="js_common/number_format.js"></script>

<?php if(0):?><!-- body_end -->
<?php
unset($_constant);
eval('$_constant = SIMPLE_TRANSLATE;');
// 繁簡切換
// 這裡的東西放在head，在FF會有問題，所以改放這裡 2017-04-24
// 這裡是下半部，上半部在view/system/head.php 2018-05-09
// SESSION _lang變數，寫在layoutv3/cig_frontend/init.php 2019-12-31
?>
<?php if($_constant == 1):?>
<script src="js_common/tw_cn.js"></script>
<script type="text/javascript">
	var defaultEncoding = 1;
	var translateDelay = 0;
	var cookieDomain = "<?php echo FRONTEND_DOMAIN?>";
	var msgToTraditionalChinese = "繁體";
	var msgToSimplifiedChinese = "简体";
	var translateButtonId = "translateLink";
	var translateButtonId_mb = "translateLink_mb";
	translateInitilization();
	//$(window).load(translateBody());
</script>
<?php endif?>

<?php if(0)://2020-03-23 Ming說，SEO次語系，如果是繁簡切換，/tw/和/tw/index.php?_lang=tw的部份，二選一就好了?>
<script type="text/javascript">
$(document).ready(function(){
	<?php if(isset($_GET['_lang']) and $_GET['_lang'] != '')://會用_lang是因為，lang會和v2的衝到?>
		window.location.href='/tw/';
	<?php endif ?>
});
</script>
<?php endif?>

<?php //2021/01/18 把 fb的js碼換到head載入 by lota ?>
<?php if(isset($this->data['sys_configs']['facebook_message_'.$this->data['ml_key']]) and $this->data['sys_configs']['facebook_message_'.$this->data['ml_key']] != ''):?>
<div id="fb-root"></div>

<!-- Your customer chat code -->
<div class="fb-customerchat"
 attribution=setup_tool
 page_id="<?php echo $this->data['sys_configs']['facebook_message_'.$this->data['ml_key']]?>"
 logged_in_greeting="您好！有任何需求跟問題都可以在這裡發問！我們會儘速回覆您"
 logged_out_greeting="您好！有任何需求跟問題都可以在這裡發問！我們會儘速回覆您">
</div>
<!--  theme_color="#ffc300" -->
<?php endif?>

<?php endif?><!-- body_end -->
