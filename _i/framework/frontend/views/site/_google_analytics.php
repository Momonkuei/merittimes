<?php if(
	//isset($this->data['sys_configs']['google_analytics_tracking_code']) 
	//and $this->data['sys_configs']['google_analytics_tracking_code'] != ''
	isset($this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]) 
	and $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']] != ''
):?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $this->data['sys_configs']['google_analytics_tracking_code_'.$this->data['ml_key']]?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php endif?>
