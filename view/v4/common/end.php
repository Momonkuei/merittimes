<script type="text/javascript" src="js_v4/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js_v4/swiper/js/swiper.min.js"></script>
<script type="text/javascript" src="js_v4/slick/slick.min.js"></script>
<script type="text/javascript" src="js_v4/TweenMax.min.js"></script>
<script type="text/javascript" src="js_v4/YTPlayer/jquery.mb.YTPlayer.min.js"></script>
<script src="js_v4/fancybox/jquery.fancybox.min.js"></script>
<script src="js_v4/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js_v4/banner.js"></script>
<script type="text/javascript" src="js_v4/twzipcode.min.js"></script>
<script type="text/javascript" src="js_v4/clipboard/clipboard.min.js"></script>
<script src="js_v4/toast/toast.min.js"></script>
<script type="text/javascript" src="js_v4/scrollanimate/animate.js"></script>
<script src="js_v4/slicklightbox/slick-lightbox.min.js"></script>

<!-- 2022/10/31 kuei引用套件 paroller.js -->
<!-- <script src="jquery.paroller.min.js"></script> -->

<!-- 2022/10/31 kuei引用套件 aos -->
<script src="js_v4/aos/js/aos.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<!-- Select2  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- Select2 i18 中文翻譯 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/i18n/zh-TW.js"></script>

<script type="text/javascript" src="js_v4/script.js"></script>



<script src="js_v4/lightgallery/js/lightgallery.min.js"></script>
<script src="js_v4/lightgallery/js/lg-hash.min.js"></script>
<script src="js_v4/lightgallery/js/lg-pager.min.js"></script>
<script src="js_v4/lightgallery/js/lg-autoplay.min.js"></script>
<script src="js_v4/lightgallery/js/lg-fullscreen.min.js"></script>
<script src="js_v4/lightgallery/js/lg-zoom.min.js"></script>
<script src="js_v4/lightgallery/js/lg-share.min.js"></script>
<script src="js_v4/lightgallery/js/lg-video.min.js"></script>
<script src="js_v4/lightgallery/js/lg-thumbnail.min.js"></script>

<script src="js_v4/countup/jquery.countup.min.js"></script>
<script src="js_v4/countup/waypoint.min.js"></script>

<script src="js_v4/flipster/jquery.flipster.min.js"></script>

<?php if (0) : ?>
  <script>
    $("#twzipcode").twzipcode();
  </script>
<?php endif ?>
<?if($this->data['router_method']=='apply_9'){?>
<script type="text/javascript">
    $("input[type='file']").change(function() {
        var filelist = $("input[type='file']");
        var size = 0;
        for (var i = 0; i < filelist.length; i++) {
            if (filelist.get(i).files[0] != undefined) {
                size = size + filelist.get(i).files[0].size;
            }
        }
        var upload_max_filesize = "<?= ini_get('upload_max_filesize') ?>";
        var num_mb = parseInt(upload_max_filesize, 10);
        if (size > 1024 * 1024 * num_mb) {
            alert('您選擇上傳的檔案大小總和超過' + '<?= ini_get('upload_max_filesize') ?>' + '，請重新選擇！');
            $('.subbut').hide();
        } else {
            $('.subbut').show();
        }
    });
</script>
<?}?>  

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Load Twitter SDK for JavaScript -->
<script>
  ! function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0],
      p = /^http:/.test(d.location) ? 'http' : 'https';
    if (!d.getElementById(id)) {
      js = d.createElement(s);
      js.id = id;
      js.src = p + '://platform.twitter.com/widgets.js';
      fjs.parentNode.insertBefore(js, fjs);
    }
  }(document, 'script', 'twitter-wjs');
</script>

<script>
  //share_social
  $(document).ready(function() {
    var url = document.location.href;
    new Clipboard('.btn_clipboard', {
      text: function() {
        return url;
      }
    });
    new Clipboard(".copyCoupon");
    $('.btn_clipboard, .copyCoupon').click(function() {
      alert("Copied");
    });
    <?if($this->data['router_method'] == 'apply_3' && isset($_GET['writeplan_id']) && !empty($_GET['writeplan_id'])){?>
      $('.act_'+<?=$_GET['writeplan_id']?>).click();
    <?}?>
  });
</script>