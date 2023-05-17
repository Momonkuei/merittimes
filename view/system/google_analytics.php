
<?php if(isset($this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]) and $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']] != ''):?>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]?>');
</script>


<?php /*

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]?>', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

  <?php if(0):?>
  ga('create', '第二組', 'auto','clientTracker');
  ga('clientTracker.send', 'pageview');
  <?php endif?>

</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $this->data['sys_configs']['google_analytics_tracking_code']?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
*/?>
<?php endif?>
