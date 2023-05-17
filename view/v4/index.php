##form_post##

<span mg="form_post"></span>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
##head_start##
<?php echo $AA?>
##head_end##

<span mg="head_end"></span>

<?php if(0)://如果要清除客戶端的快取就打開它?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<?php endif?>

</head>

<?php 
	//2020/10/16 加入Jane說要用一class來判斷css變換
	if(defined('LAYOUTV4_THEME_VER')){
		$_v4_theme_ver = LAYOUTV3_THEME_NAME.LAYOUTV4_THEME_VER;
	}else{
		$_v4_theme_ver = LAYOUTV3_THEME_NAME.'_k01';
	}
?>

<body class="<?php echo $this->data['router_method']?> <?php echo $_v4_theme_ver?>">

<?php
unset($_constant);
eval('$_constant = GOOGLE_TRANSLATE;');
?>
<?php if($_constant == 2):?>
	<div id="google_translate_element_cow"></div> <?php //cowboy 20201026 #37593 留給前端移位置?>
<?php endif?>

##body_start##
<?php echo $BB?>
<div class="wrapper">
<?php echo $CC?>
</div>
<?php echo $DD?>
##body_end##

<span mg="body_end"></span>
<?php if(0):// https://ibooked.cn/widgets/weather?_ga=2.178601447.2112194902.1624937013-1505727424.1624937013&_ga=2.178601447.2112194902.1624937013-1505727424.1624937013 ?>
<!-- weather widget start --><div id="m-booked-small-t1-37865"> <div class="booked-weather-120x100 w100-bg" style="background-color:#FFFFFF; color:#333333; border-radius:4px; -moz-border-radius:4px; width:118px !important;"> <div style="background-color:#2373CA; color:#FFFFFF;" class="booked-bl-simple-city">台中</div> <div class="booked-weather-120x100-degree w18"><span class="plus">+</span>31&deg;<sub class="booked-weather-120x100-type">C</sub></div> <div class="booked-weather-120x100-high-low"> <p>高: <span class="plus">+</span>26&deg;</p> <p>低: <span class="plus">+</span>24&deg;</p> </div> <div style="background-color:#FFFFFF; color:#333333;" class="booked-weather-120x100-date">周二, 29.06.2021</div> </div> </div><script type="text/javascript"> var css_file=document.createElement("link"); var widgetUrl = location.href; css_file.setAttribute("rel","stylesheet"); css_file.setAttribute("type","text/css"); css_file.setAttribute("href",'https://s.bookcdn.com/css/w/bw-120-100.css?v=0.0.1'); document.getElementsByTagName("head")[0].appendChild(css_file); function setWidgetData_37865(data) { if(typeof(data) != 'undefined' && data.results.length > 0) { for(var i = 0; i < data.results.length; ++i) { var objMainBlock = document.getElementById('m-booked-small-t1-37865'); if(objMainBlock !== null) { var copyBlock = document.getElementById('m-bookew-weather-copy-'+data.results[i].widget_type); objMainBlock.innerHTML = data.results[i].html_code; if(copyBlock !== null) objMainBlock.appendChild(copyBlock); } } } else { alert('data=undefined||data.results is empty'); } } var widgetSrc = "https://widgets.booked.net/weather/info?action=get_weather_info;ver=6;cityID=26958;type=11;scode=2;domid=588;anc_id=33433;cmetric=1;wlangID=17;color=ffffff;wwidth=118;header_color=2373ca;text_color=333333;link_color=ffffff;border_form=0;footer_color=ffffff;footer_text_color=333333;transparent=0";widgetSrc += ';ref=' + widgetUrl;widgetSrc += ';rand_id=37865';var weatherBookedScript = document.createElement("script"); weatherBookedScript.setAttribute("type", "text/javascript"); weatherBookedScript.src = widgetSrc; document.body.appendChild(weatherBookedScript) </script><!-- weather widget end -->
<?php endif?>

<?php if(0):// https://weatherwidget.io?>
<a class="weatherwidget-io" href="https://forecast7.com/zh-tw/24d15120d67/taichung-city/" data-label_1="台中市"
            data-label_2="天氣預報" data-font="微軟正黑體 (Microsoft JhengHei)" data-icons="Climacons Animated" data-days="3"
            data-theme="pure">台中市 天氣預報</a>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
</script>
<?php endif?>

</body>
</html>
