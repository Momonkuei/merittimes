<script src="js_v3/jquery-2.1.4.min.js"></script>

<script src="js_v3/slick/slick.min.js"></script>
<script src="js_v3/swipebox/js/jquery.swipebox.js"></script>
<script src="js_v3/masonry/masonry.pkgd.min.js"></script>
<script src="js_v3/masonry/imagesloaded.pkgd.js"></script>
<script src="js_v3/fancybox/jquery.fancybox.pack.js"></script>

<script src="js_v3/lightgallery/js/lightgallery.min.js"></script>
<script src="js_v3/lightgallery/js/lg-hash.min.js"></script>
<script src="js_v3/lightgallery/js/lg-pager.min.js"></script>
<script src="js_v3/lightgallery/js/lg-autoplay.min.js"></script>
<script src="js_v3/lightgallery/js/lg-fullscreen.min.js"></script>
<script src="js_v3/lightgallery/js/lg-zoom.min.js"></script>
<script src="js_v3/lightgallery/js/lg-share.min.js"></script>
<script src="js_v3/lightgallery/js/lg-video.min.js"></script>
<script src="js_v3/lightgallery/js/lg-thumbnail.min.js"></script>

<?php if(0):?>
<script src="js_v3/twzipcode/jquery.twzipcode-1.7.8.min.js"></script>
<script src="js_v3/nouislider/nouislider.min.js"></script>
<?php endif?>
<script src="js_v3/twzipcode/jquery.twzipcode.min.js"></script>
<script src="js_v3/jquery-ui/jquery-ui.min.js"></script>
<script src="js_v3/jquery-ui/datepicker-zh-TW.js"></script>
<script src="js_v3/scrollanimate/animate.js"></script>
<script src="js_v3/clipboard/clipboard.min.js"></script>
<script src="js_v3/toast/toast.min.js"></script>

<script>
  //share_social
  $(document).ready(function(){
    var url = document.location.href;
    new Clipboard('.btn_clipboard', {
      text: function() {
        return url;
      }
    });
    $('.btn_clipboard').click(function(){
      alert("Copied");
    });
  });
</script>


<?php if(0):?><!-- body_end -->
<?php if(preg_match('/^(shop|shopdetail)$/', $this->data['router_method'])):?>
<script src="js_shop/custome.js"></script>
<script src="js_shop/page.js"></script>
<?php else:?>
<script src="js_v3/custome.js"></script>
<script src="js_v3/page.js"></script>
<?php endif?>
<?php endif?><!-- body_end -->


<?php if(0):?><!-- 這裡己經移到view/system/end.php，因為A方案也可能會用到 -->
<?php
unset($_constant);
eval('$_constant = SIMPLE_TRANSLATE;');
?>
<?php if($_constant == 1)://繁簡切換，放在head，在FF會有問題，所以改放這裡 2017-04-24?>
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

<?php
// 2020-05-26 購物分類在主選單
// 相關檔案：source/menu/v2.php
?>
<?php if(0 and $this->data['router_method'] == 'shop' and isset($_GET['id'])):?>
<script type="text/javascript">
	$('#navlight_webmenu_shop<?php echo $_GET['id']?>').addClass('active');
</script>
<?php endif?>
