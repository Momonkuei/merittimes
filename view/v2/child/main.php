<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <?php if($this->data['ml_key']=='en'):?>
		<meta charset="en-US">
	<?php else:?>
   		<meta charset="utf-8">
   	<?php endif?>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="msvalidate.01" content="4A2ADBB4708CBB0B1A6DCB9BEF60CF84" />

	<?php // 為了SEM而增加的?>
	<?php if(isset($this->data['sys_configs']['has_seo_'.$this->data['ml_key']]) and $this->data['sys_configs']['has_seo_'.$this->data['ml_key']] == '1'):?>
		<base href="<?php echo FRONTEND_DOMAIN?>" />
	<?php endif?>

	<title><?php echo $this->data['sys_configs']['admin_title']?></title>
	<?php if(defined('SEO_OPEN') && SEO_OPEN==true):?>
		<meta name="ROBOTS" content="INDEX, FOLLOW">
		<meta name="GOOGLEBOT" content="index, follow">
		<meta name="author" content="www.buyersline.com.tw">
		<meta name="distribution" content="global">
		<meta name="revisit-after" content="5days">
		<meta name="description" content="<?php if(isset($this->data['seo_description'])):?><?php echo $this->data['seo_description']?><?php endif?>">
		<meta name="keywords" content="<?php if(isset($this->data['seo_keywords'])):?><?php echo $this->data['seo_keywords']?><?php endif?>">
	<?php endif?>

	<link rel="shortcut icon" href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>images/favicon.ico" />
    <link href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>images/favicon.ico" rel="shortcut icon" />

<?php if((isset($_SESSION['enter_site']) && $_SESSION['enter_site']==true) || FIRST_SITE_BANNER==false):?>

	<?php if(isset($this->data['HEAD_START']) and $this->data['HEAD_START'] != ''):?>
		<?php echo $this->data['HEAD_START']?>
	<?php endif?>

	<?php if(0):?>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style01.css" />
		<link rel="stylesheet" href="html/a/css/style01.css" />
		<link rel="stylesheet" href="html/rwd152_shop/css/style01.css" />
		<link rel="shortcut icon" href="images/favor.png" />
		<link href="images/favor.png" rel="shortcut icon" />
	<?php endif?>

	<link rel="stylesheet" href="<?php echo FRONTEND_LAYOUTV2?>/html/a/css/style.css" />
	

	<link rel="stylesheet" href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>common/slick/slick.css"> 
    <link rel="stylesheet" href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>common/swipebox/css/swipebox.css">
    <link rel="stylesheet" href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>css/section/navbar.css">    
    <link rel="stylesheet" href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>css/section/indexsection.css">   
    <?/*<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">*/?>
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">

	<?php if(isset($this->data['CSS']) and $this->data['CSS'] != ''):?>
		<?php echo $this->data['CSS']?>
	<?php endif?>	

	<?php
	if(!isset($this->data['HEAD'])){
		$this->data['HEAD'] = '';
	}
	$this->data['HEAD'] .= $this->renderPartial('//site/_google_analytics', $this->data, true);
	?>

	<?php if(isset($this->data['HEAD']) and $this->data['HEAD'] != ''):?>
		<?php echo $this->data['HEAD']?>
	<?php endif?>	

	<?php $style000 = (isset($GLOBALS['lay_out_select']))?$GLOBALS['lay_out_select']:1;?>
    
  
	<link rel="stylesheet" href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>css/style<?php echo str_pad($style000, 2,'0',STR_PAD_LEFT)?>.css" />	    
    

	<script type="text/javascript">
	var ml_key = '<?php echo $this->data['ml_key']?>';
	</script>
	<script src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>_i/assets/language.js"></script>

	<?php if(SIMPLE_TRANSLATE)://繁簡切換 ?>
	<script src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>js/tw_cn.js"></script>
	<script type="text/javascript">
					var defaultEncoding = 1;
					var translateDelay = 0;
					var cookieDomain = "<?php echo FRONTEND_DOMAIN?>";
					var msgToTraditionalChinese = "繁體";
					var msgToSimplifiedChinese = "简体";
					var translateButtonId = "translateLink";
					var translateButtonId_mb = "translateLink_mb";
					translateInitilization();
	</Script>
	<?php endif?>
	
<?php else:?>

<?php
//處理形象進入圖路徑
if(isset($this->data['sys_configs']['firstbanner_'.$this->data['ml_key']])){
	$filename = $this->data['sys_configs']['firstbanner_'.$this->data['ml_key']];
	$path = '_i/assets/upload/firstbanner/';
	$firstbanner = $path.$filename;
}
?>

	<style>
	body {overflow:hidden;}
	.welcome {display:inline-block;width: 100%;position: relative;overflow: hidden}
	</style>

<?php endif?>
</head>

<body>
	
<?php if(defined('SHOW_BLACK') && SHOW_BLACK==true)://這裡是對全站做黑幕遮屏?> 
	<style> .overlay{position: fixed;z-index: 10000;background: rgba(0,0,0,.92);width:100vw;height:100vh;top:0;left:0;} </style>
	<div class="overlay"> </div>
<?php endif?>

<?php if((isset($_SESSION['enter_site']) && $_SESSION['enter_site']==true) || FIRST_SITE_BANNER==false):?>

	<?php if(MEMBER_OPEN==true)://會員功能?>
	<?php echo $this->renderPartial('//include/loginbox', $this->data, true);?>
	<?php endif?>

	<?php if(isset($this->data['BODY_START']) and $this->data['BODY_START'] != ''):?>
		<?php echo $this->data['BODY_START']?>
	<?php endif?>

	<?php echo $_content?>


	<div id="gotop"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></div>

	<script src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>js/jquery-2.1.4.min.js"></script>
	<script src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>js/bootstrap.js"></script>
	<script src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>js/custome.js"></script>

	<?php if(defined('INDEX_ALEST_AD') && INDEX_ALEST_AD==true && $this->data['router_method']=='index'):?>

	 <a class="fancybox fancybox.iframe" href="alert_win.php"></a>

	<script language="JavaScript" type="text/javascript" src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>js/jquery.flexslider.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>common/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox -->
	<link rel="stylesheet" href="<?php if(defined('LANG_PATH')) echo LANG_PATH?>common/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>common/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

	<script type="text/javascript" charset="utf-8">
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
	    	<? if (isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) && $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]==1):?>
	    	$('.fancybox').click();
	    	<? endif ?>
	  });
	</script>	

	<?php endif?>


	<?php if(GOOGLE_TRANSLATE == true):?>
	<script type="text/javascript">	
		var viewPoint       =   768;
		var pageL           =   'tw';
		var pageT           =   'en,ja,ko';		
		var nowTranslate,nowTarget;
		$(function(){$(window).on('load resize',setGoogleTrans); });
		function setGoogleTrans(){
			var headID          =   $(".googleTranslate");
			var newJs           =   document.createElement('script');
			newJs .type         =   'text/javascript';
			newJs .src          =   "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";			
			nowTranslate        =   ($(window).width()<viewPoint)?"google_translate_element_mb":"google_translate_element_pc";		
			nowTarget           =   ($(window).width()<viewPoint)?".googleTranslate.mb":".googleTranslate.pc";		
			headID.hide().html("");		
			$(nowTarget).html("").append(newJs).append("<div id='"+nowTranslate+"'></div>").show();			
		}	
		function googleTranslateElementInit() {	

		  $(".skiptranslate").remove();
		  new google.translate.TranslateElement({pageLanguage:pageL ,includedLanguages:pageT , layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, nowTranslate);  
		}
	</script>
	<?php endif?>

	<?php if(SIMPLE_TRANSLATE)://繁簡切換 ?>
	<script type="text/javascript">
	<!--
		$(window).load(translateInitilization());
	//-->
	</script>
	<?php endif?>

	<?php if(isset($this->data['JAVASCRIPT']) and $this->data['JAVASCRIPT'] != ''):?>
	<?php echo $this->data['JAVASCRIPT']?>
	<?php endif?>
    
    <script src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>common/slick/slick.min.js"></script>
    <script src="<?php if(defined('LANG_PATH')) echo LANG_PATH?>common/swipebox/js/jquery.swipebox.js"></script>
	

	<?php if(isset($this->data['BODY_END']) and $this->data['BODY_END'] != ''):?>
		<?php echo $this->data['BODY_END']?>
	<?php endif?>
<?php else:?>
	<?php if(isset($firstbanner)):?>
	 <a href="index.php" class="welcome winH" style="background:url(<?php echo $firstbanner?>) no-repeat center center;background-size:cover"></a>

	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/custome.js"></script>
	

	<?php echo $this->renderPartial('//site/_google_analytics', $this->data, true);?>
	<?php else:?>
	<script type="text/javascript">
	<!--
		location.replace('index.php');
	//-->
	</script>
	<?php endif?>

<?php endif?>
</body>
</html>
