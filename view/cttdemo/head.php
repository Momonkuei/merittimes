<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="msvalidate.01" content="4A2ADBB4708CBB0B1A6DCB9BEF60CF84" />

<?php if($layoutv3_parent_path != ''):?>
	<base href="<?php echo FRONTEND_DOMAIN?>" />
<?php endif?>

<title><?php if(isset($data['head_title'])) echo $data['head_title']?></title>
<?php unset($_constant);eval('$_constant = '.strtoupper('seo_open').';');if($_constant):?>
	<meta name="ROBOTS" content="INDEX, FOLLOW">
	<meta name="GOOGLEBOT" content="index, follow">
	<meta name="author" content="www.buyersline.com.tw">
	<meta name="distribution" content="global"> 
	<meta name="revisit-after" content="5days">  
	<meta name="description" content="<?php if(isset($this->data['seo_description'])):?><?php echo $this->data['seo_description']?><?php endif?>">
	<meta name="keywords" content="<?php if(isset($this->data['seo_keywords'])):?><?php echo $this->data['seo_keywords']?><?php endif?>">
<?php endif?>

<script type="text/javascript">
var ml_key = '<?php echo $this->data['ml_key']?>';
</script>
<script src="_i/assets/language.js"></script>

<?php
unset($_constant);
eval('$_constant = SIMPLE_TRANSLATE;');
?>
<?php if($_constant == 1)://繁簡切換 ?>
<script type="text/javascript">
<?php if(isset($_GET['_lang']) and $_GET['_lang'] != '')://會用_lang是因為，lang會和v2的衝到?>
	<?php if($_GET['_lang'] == 'tw'):?>
		var staticEncoding = 1;
	<?php else:?>
		var staticEncoding = 2;
	<?php endif ?>
<?php else:?>
	//var staticEncoding = 1;
<?php endif ?>
</script>
<?php if(0)://放這裡，FF會有問題，所以改放end 2017-04-24?>
<script src="js/tw_cn.js"></script>
<script type="text/javascript">
	var defaultEncoding = 1;
	var translateDelay = 0;
	var cookieDomain = "<?php echo FRONTEND_DOMAIN?>";
	var msgToTraditionalChinese = "繁體";
	var msgToSimplifiedChinese = "简体";
	var translateButtonId = "translateLink";
	var translateButtonId_mb = "translateLink_mb";
	translateInitilization();
</script>
<?php endif?>
<?php endif?>

<link rel="shortcut icon" href="images/favicon.ico" />
<link href="images/favicon.ico" rel="shortcut icon" />

<link href="ctt/css/reset.css" rel="stylesheet" type="text/css" />
<link href="ctt/css/basic.css" rel="stylesheet" type="text/css" />

<?php if(preg_match('/^index/', basename($_SERVER['REQUEST_URI'],'.php')) or basename($_SERVER['REQUEST_URI'],'.php') == ''):?>
<link href="ctt/css/style.css" rel="stylesheet" type="text/css" />
<?php else:?>
<link href="ctt/css/main.css" rel="stylesheet" type="text/css" />
<?php endif?>

<script language="JavaScript" type="text/javascript" src="ctt/js/favorite.js"></script>
<script language="JavaScript" type="text/javascript" src="ctt/js/swap.js"></script>
<!-- flexslider -->
<script language="JavaScript" type="text/javascript" src="ctt/js/jquery-1.7.1.min.js"></script>

<link href="ctt/css/flexslider.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="ctt/js/jquery.flexslider.js"></script>
<script type="text/javascript" charset="utf-8">
  $(window).load(function() {
    $('.flexslider').flexslider();
  });
</script>

<?php
unset($_constant);
eval('$_constant = LOCK_RIGHT_CLICK;'); //全站鎖右鍵
?>
<?php if($_constant == 1):?>
<style type="text/css">body {-moz-user-select : none;-webkit-user-select: none;}</style>
<script type="text/javascript">
function iEsc(){ return false; }
function iRec(){ return true; }
function DisableKeys() {
if(event.ctrlKey || event.altKey) {
window.event.returnValue=false;
iEsc();}
}
document.ondragstart=iEsc;
document.onkeydown=DisableKeys;
document.oncontextmenu=iEsc;
if (typeof document.onselectstart !="undefined")
document.onselectstart=iEsc;
else{
document.onmousedown=iEsc;
document.onmouseup=iRec;
}
function DisableRightClick(qsyzDOTnet){
if (window.Event){
if (qsyzDOTnet.which == 2 || qsyzDOTnet.which == 3)
iEsc();}
else
if (event.button == 2 || event.button == 3){
event.cancelBubble = true
event.returnValue = false;
iEsc();}
}
</script>
<?php endif?>


<?php if(0):?><!-- body_end -->
<?php
unset($_constant);
eval('$_constant = INDEX_ALEST_AD;');
?>
<?php if($_constant == 1 and $this->data['router_method'] == 'index'):?>
	<a class="fancybox fancybox.iframe" href="alert_win.php"></a>

	<script language="JavaScript" type="text/javascript" src="js/jquery.flexslider.js"></script>

<?php if(0):?>
	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="js/fancybox_old/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<?php endif?>

	<!-- Add fancyBox -->
	<link rel="stylesheet" href="js/fancybox_old/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="js/fancybox_old/jquery.fancybox.pack.js?v=2.1.5"></script>

	<script type="text/javascript" charset="utf-8">
      // http://stackoverflow.com/questions/37738732/jquery-3-0-url-indexof-error
	  // $(window).on('load', function() { ... }); jquery > 3.0
	  $(window).load(function() {
		$('.flexslider').flexslider();
		$('.fancybox').fancybox({
			 maxWidth : 800,
			 maxHeight : 600,
			 fitToView : false,
			 width  : '70%',
			 height  : '70%',
			 autoSize : false,
			 closeClick : false,
			 openEffect : 'none',
			 closeEffect : 'none'
			//'frameWidth': 300,
			//'frameHeight': 100,
			//'autoScale'		: false,
			//'scrolling':'auto',
			//'hideOnContentClick': false,
			//'overlayOpacity': 0.65
		});
		<?php if(isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) and $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']] == 1):?>
			$('.fancybox').click();
		<?php endif?>
	  });
	</script>
<?php endif?>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<?php
unset($_constant);
eval('$_constant = GOOGLE_TRANSLATE;');
?>
<?php if($_constant == 1):?>
<script type="text/javascript">
<?php // 這幾行是winnie寫的 2017/6/13 移除 pageLanguage: 'en', 讓翻譯器自動判別來源字元?>
if($("#google_translate_element_g").length){
	function googleTranslateElementInit_g() {new google.translate.TranslateElement({includedLanguages: 'ja,zh-CN,zh-TW'}, 'google_translate_element_g');}
	$('body').append('<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit_g"></'+'script>');
}
</script>
<?php endif?>
<?php endif?><!-- body_end -->

<?php //include 'view/system/_google_analytics.php'?>
