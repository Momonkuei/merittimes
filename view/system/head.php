<?php
// 2020-10-07
if(LAYOUTV3_THEME_NAME == 'v4'){
	$rows = $this->cidb->where('is_enable',1)->where('type','userblockv4'.$this->data['router_method'])->where('topic','v4/userblock/head_start')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
	if($rows){
		foreach($rows as $k => $v){
			echo $v['detail'];
		}
	}
}
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="msvalidate.01" content="4A2ADBB4708CBB0B1A6DCB9BEF60CF84" /><?php //mis2@buyersline.com.tw?>
<meta name="msvalidate.01" content="0F31E7EB8E35E18A51981D3438DA2A7D" /><?php //mis@buyersline.com.tw?>

<?php if(isset($layoutv3_parent_path) and $layoutv3_parent_path != ''):?>
	<base href="<?php echo FRONTEND_DOMAIN?>" />
<?php endif?>

<title><?php if(isset($data['head_title'])) echo $data['head_title']?></title>
<link rel="shortcut icon" href="images_v4/favicon.png">

<meta name="ROBOTS" content="INDEX, FOLLOW">
<meta name="GOOGLEBOT" content="index, follow">
<meta name="author" content="www.buyersline.com.tw">
<meta name="distribution" content="global"> 
<meta name="revisit-after" content="7days">  
<meta name="description" content="<?php if(isset($this->data['seo_description'])):?><?php echo $this->data['seo_description']?><?php endif?>">
<meta name="keywords" content="<?php if(isset($this->data['seo_keywords'])):?><?php echo $this->data['seo_keywords']?><?php endif?>">

<?php unset($_constant);eval('$_constant = '.strtoupper('seo_open').';');if($_constant):?>
<?php endif?>
<?php if(!stristr($this->data['router_method'],'detail') && $this->data['router_method']!='about')://#非內頁在此 2023-01-03?>
<?
/******#46369 增加社群分享設定********************************************************start */
unset($_constant);
eval('$_constant = '.strtoupper('shop_open').';');
if($this->data['router_method']=='shop' && $_constant==1){
	//購物單元判斷
	$og_data=$this->cidb->where('id',$_GET['id'])->where('is_enable','1')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get($this->data['router_method'].'type')->row_array();
	if(!empty($og_data)){
		if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/shoptype/'.$og_data['pic2'])){
			//社群圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/shoptype/'.$og_data['pic2'];
		}else if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/shoptype/'.$og_data['pic3'])){
			//社群圖未上 抓大圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/shoptype/'.$og_data['pic3'];
		}else if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/shoptype/'.$og_data['pic4'])){
			//社群圖+大圖未上 抓小圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/shoptype/'.$og_data['pic4'];
		}else{
			//三種皆未上 抓預設圖
			$pic=FRONTEND_DOMAIN.'/images/fb_share.jpg';
		}
	}else{
		$pic=FRONTEND_DOMAIN.'/images/fb_share.jpg';
	}

	if(!empty($og_data['detail_top'])){
		//抓標題
		if(!empty($this->data['_breadcrumb'])){
			$topic=end($this->data['_breadcrumb']);	
			$topic=$topic['topic'];
		}else{
			$topic=$this->data['func_name'].' | '.$data['head_title'];
		}
		$og_data['other30']=$og_data['detail_top'];
	}else{
		if(!empty($this->data['_breadcrumb'])){
			$topic=end($this->data['_breadcrumb']);	
			$topic=$topic['topic'];
		}else{
			if(isset($data['head_title'])){
				$topic=$data['head_title'];
			}else{
				$topic='';
			}
		}
		$og_data['other30']='';
	}
}else{
	$og_data='';
	$universal_data='';
	$og_data_array=$this->cidb->where('type','bannersub')->where('is_enable','1')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
	//抓當前單元名稱
	$page_type=explode('_',$this->data['router_method']);
	$page_type=$page_type[0];
	if(!empty($og_data_array)){
		foreach($og_data_array as $k => $v){
			if(stristr($v['other1'],$page_type)){
				$og_data=$v;
			}else if(empty($v['other1'] && empty($v['other2']) && empty($v['other3'])) && empty($universal_data)){
				//通用資料
				$universal_data=$v;
			}
		}
	}

	//後台未設定社群分享單元  皆用通用資料
	if(empty($og_data)){
		$og_data=$universal_data;
	}
	// print_r($og_data);die;
	if(!empty($og_data)){
		if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/bannersub/'.$og_data['pic3'])){
			//社群圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/bannersub/'.$og_data['pic3'];
		}else if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/bannersub/'.$og_data['pic1'])){
			//社群圖未上 抓大圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/bannersub/'.$og_data['pic1'];
		}else if(is_file(dirname(dirname(__FILE__)).'/_i/assets/upload/bannersub/'.$og_data['pic2'])){
			//社群圖+大圖未上 抓小圖
			$pic=FRONTEND_DOMAIN.'/_i/assets/upload/bannersub/'.$og_data['pic2'];
		}else{
			//三種皆未上 抓預設圖
			$pic=FRONTEND_DOMAIN.'/images/fb_share.jpg';
		}
	}else{
		$pic=FRONTEND_DOMAIN.'/images/fb_share.jpg';
	}

	if(!empty($og_data['other30'])){
		//抓標題
		if(!empty($this->data['_breadcrumb'])){
			$topic=end($this->data['_breadcrumb']);	
			$topic=$topic['topic'];
		}else{
			$topic=$this->data['func_name'].' | '.$data['head_title'];
		}
	}else{
		if(!empty($this->data['_breadcrumb'])){
			$topic=end($this->data['_breadcrumb']);	
			$topic=$topic['topic'];
		}else{
			if(isset($data['head_title'])){
				$topic=$data['head_title'];
			}else{
				$topic='';
			}
		}
	}
}	
/******#46369 增加社群分享設定********************************************************end */
?>
<?php endif?>
<?php if(!stristr($this->data['router_method'],'detail') && $this->data['router_method']!='about'):?>
    <?/*<meta property="og:url"           content="<?php echo FRONTEND_DOMAIN?>/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?php if(isset($data['head_title'])) echo $data['head_title']?>" />
    <meta property="og:description"   content="" />
	<meta property="og:image"         content="<?php echo FRONTEND_DOMAIN?>/images/fb_share.jpg" />*/?>
	<?if(empty($og_data)){?>
	<meta property="og:url"           content="<?=FRONTEND_DOMAIN?>" />
	<?}?>	
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?=$topic?>" />
    <meta property="og:description"   content="<?=(!empty($og_data['other30'])?$og_data['other30']:'')?>" />
	<meta property="og:image"         content="<?=$pic?>" />
	
<?php endif?>

<script type="text/javascript">
var ml_key = '<?php echo $this->data['ml_key']?>';
</script>
<?php if(0)://2019-12-05 已經直接問PHP，所以這個不用了?>
<script src="_i/assets/language.js"></script>
<?php endif?>
<script src="_i/assets/language2.js"></script>
<script src="js_common/t.js"></script>

<?php
unset($_constant);
eval('$_constant = SIMPLE_TRANSLATE;');
// 繁簡切換
// 這裡是上半部，下半部在view/system/end.php裡面 2018-05-09
// SESSION _lang變數，寫在layoutv3/cig_frontend/init.php 2019-12-31
?>
<?php if($_constant == 1): ?>
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

<?php if(isset($_SESSION['_lang']) and $_SESSION['_lang'] == 'cn')://2020-01-06?>
	var staticEncoding = 2;
<?php endif ?>
</script>
								<?php if(0)://放這裡，FF會有問題，所以改放end 2017-04-24?>
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
								</script>
								<?php endif?>
<?php endif?>

<?php // 為了A方案，才把C方案的css部份分離出來?>
<?php echo $AA?>

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

		<?php if(0):?>
			<?php 
				/*
				 * 首頁彈跳廣告 第一版
				 * iframe
				 */
			?>
			<a class="fancybox fancybox.iframe" href="alert_win2.php"></a>

			<script language="JavaScript" type="text/javascript" src="js/jquery.flexslider.js"></script>

			<?php if(0):?>
				<!-- Add mousewheel plugin (this is optional) -->
				<script type="text/javascript" src="js/fancybox_old/lib/jquery.mousewheel-3.0.6.pack.js"></script>
			<?php endif?>

			<!-- Add fancyBox -->
			<link rel="stylesheet" href="js/fancybox_old/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
			<?php if(0)://因為在view/end.php裡面己經有載入了?>
			<script type="text/javascript" src="js/fancybox_old/jquery.fancybox.pack.js?v=2.1.5"></script>
			<?php endif?>
			<script type="text/javascript" charset="utf-8">
				// http://stackoverflow.com/questions/37738732/jquery-3-0-url-indexof-error
				// $(window).on('load', function() { // jquery > 3.0 這個很重要
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
						// 'frameWidth': 300,
						// 'frameHeight': 100,
						// 'autoScale'		: false,
						// 'scrolling':'auto',
						// 'hideOnContentClick': false,
						// 'overlayOpacity': 0.65
					});
					<?php if(isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) and $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']] == 1):?>
					$('.fancybox').click();
					<?php endif?>
				});
			</script>
		<?php endif?>

		<?php 
		/*
		 * 首頁彈跳廣告 第二版
		 * 必需要fancybox 2.1.7版以上才可以使用
		 * iframe
		 */
		if(0 and isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) and $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']] != ''):?>
			<?php if(0)://fancy-2.1.7?>
				<script src="js/fancybox/jquery.fancybox.js"></script>
			<?php endif?>
			<script type="text/javascript">
				$(document).ready(function(){
					$.fancybox.open([
						{
							src  : '_i/assets/upload/indexad/<?php echo $this->data['sys_configs']['pic2_'.$this->data['ml_key']]?>',		
						},
					], {
						loop : false
					});
				});
			</script>
		<?php endif?>

		<?php 			
		/*
		 * 首頁彈跳廣告 Jane版
		 * 
		 * 
		 */
		if(isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) and $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']] == '1'):?>	
		<section class="pageWidget coverAd">
			<div class="adBg"></div>
			<div class="adBox">
				<div class="closeBtn"><i class="fa fa-times" aria-hidden="true"></i></div>
				<div class="imgBox">
					<?php if(isset($this->data['sys_configs']['indexad_text_'.$this->data['ml_key']]) && $this->data['sys_configs']['indexad_text_'.$this->data['ml_key']]!=''):?><a href="<?php echo $this->data['sys_configs']['indexad_text_'.$this->data['ml_key']]?>"><?php endif?>
						<img src="_i/assets/upload/indexad/<?php echo $this->data['sys_configs']['pic2_'.$this->data['ml_key']]?>" alt="">
					</a>
				</div>
			</div>
		</section>
		<?php endif?>


	<?php endif?>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<?php
unset($_constant);
eval('$_constant = GOOGLE_TRANSLATE;');
?>
<?php if($_constant > 0):?>
<?php
$rows_tmp = $this->cidb->where('is_enable',1)->get('ml_google')->result_array();
$rows = array();
foreach($rows_tmp as $k => $v){
	$rows[] = $v['key'];
}
$google_language = implode(',', $rows);
?>
<?php if($_constant == 1):?>
<script type="text/javascript">
<?php // 這幾行是winnie寫的 2017/6/13 移除 pageLanguage: 'en', 讓翻譯器自動判別來源字元?>
if($("#google_translate_element_g").length){
	function googleTranslateElementInit_g() {new google.translate.TranslateElement({includedLanguages: '<?php echo $google_language?>'}, 'google_translate_element_g');}
	//$('body').append('<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit_g"></'+'script>');
	$('body').append('<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit_g"></'+'script>');
}
</script>
<?php elseif($_constant == 2)://#37593?>
<script type="text/javascript">
function googleTranslateElementInit_cow() {
	new google.translate.TranslateElement({includedLanguages: '<?php echo $google_language?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element_cow');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit_cow"></script>
<?php endif?>
<?php endif//constant?>
<?php endif?><!-- body_end -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$(document).ready(function(){
	$.ajax({
		type: "POST",
		data: {
			'id': 'get_token',
		},
		url: 'gtoken.php',
		success: function(response){
			//alert(response);
			eval(response);
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

<?php // include _BASEPATH.'/../view/system/_google_analytics.php'?>

<?php // 2020-11-25 麵包屑結構化(幸康、醫揚、羅布森);
unset($_constant);
eval('$_constant = '.strtoupper('seo_open').';');
?>
<?php if($_constant and $this->data['router_method'] != 'index' and !empty($this->data['_breadcrumb'])):?>
<script type="application/ld+json">
<?php /*
{
  "@context": "https://schema.org/", 
  "@type": "BreadcrumbList", 
  "itemListElement": [{
    "@type": "ListItem", 
    "position": 1, 
    "name": "HOME",
    "item": "https://www.cincon.com/"  
  },{
    "@type": "ListItem", 
    "position": 2, 
    "name": "Pro",
    "item": "https://www.cincon.com/product_en_2.php"  
  }]
}
 */?>
<?php
$ggg = array(
	'@content' => 'https://schema.org/',
	'@type' => 'BreadcrumbList',
	'itemListElement' => array(
		//array(
		//	'@type' => 'ListItem',
		//	'position' => 1, 
		//	'name' => 'HOME',
		//	'item' => 'https://www.cincon.com/',
		//),
	),
);
//echo json_encode($ggg);
foreach($this->data['_breadcrumb'] as $k => $v){
	$aaa = array(
		'@type' => 'ListItem',
		'position' => $k+1, 
		'name' => $v['name'],		
	);
	if(isset($v['url'])){
		$aaa['item'] = $v['url'];
	}

	if(isset($aaa['item']) and $aaa['item'] == '' and isset($this->data['_breadcrumb'][$k+1]) and isset($this->data['_breadcrumb'][$k+1]['url']) and $this->data['_breadcrumb'][$k+1]['url'] != ''){
		$aaa['item'] = $this->data['_breadcrumb'][$k+1]['url'];
	}
	$ggg['itemListElement'][] = $aaa;
}
$bbb = json_encode($ggg);
$bbb = str_replace('\/','/',$bbb);
echo $bbb;
?>
</script>
<?php endif?>

<?php // 2020-12-15 產品結構化(醫揚、誠仲)?>
<?php if($_constant and $this->data['router_method'] == 'productdetail' and isset($_GET['id']) and $_GET['id'] > 0):?>
<?php
//$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('type','product')->where('id',$_GET['id'])->get('html')->row_array();
$row = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->where('id',$_GET['id'])->get('product')->row_array();
if($row){
?>
<script type="application/ld+json"> {
"@context": "https://schema.org/",
"@type": "Product",
"name": "<?php echo $row['name']?>",
"image": "<?php echo FRONTEND_DOMAIN.'/_i/assets/upload/product/'.$row['pic1']?>",
"gtin13": "",
"offers": {
"@type": "Offer",
"url": "<?php echo FRONTEND_DOMAIN.$_SERVER['REQUEST_URI']?>",
"priceCurrency": "TWD",
"price": "30000",
"availability": "https://schema.org/InStock",
"itemCondition": "https://schema.org/NewCondition"
}
}

</script>
<?php
}?>
<?php endif?>

<?php
// 2020-10-07
if(LAYOUTV3_THEME_NAME == 'v4'){
	$rows = $this->cidb->where('is_enable',1)->where('type','userblockv4'.$this->data['router_method'])->where('topic','v4/userblock/head_end')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
	if($rows){
		foreach($rows as $k => $v){
			echo $v['detail'];
		}
	}
}
?>

<?php //2021-01-18 有時候 fb的js會無法在body載入，所以直接換到head載入 by lota ?>
<?php if(isset($this->data['sys_configs']['facebook_message_'.$this->data['ml_key']]) and $this->data['sys_configs']['facebook_message_'.$this->data['ml_key']] != ''):?>
<script>
window.fbAsyncInit = function() {
	FB.init({
		xfbml : true,
			version : 'v7.0'
	});
};

(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<?php endif?>