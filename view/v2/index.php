<!DOCTYPE html>
<html lang="zh-tw">
<head>
##head_start##
<?php echo $AA?>
##head_end##
</head>

<body class="<?php echo $this->data['router_method']?>" >
##body_start##
<?php echo $BB?>

<div id="gotop"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></div>

<script src="layoutv2/js/jquery-2.1.4.min.js"></script>
<script src="layoutv2/js/bootstrap.js"></script>
<script src="layoutv2/js/custome.js"></script>

 <a class="fancybox fancybox.iframe" href="alert_win.php"></a>

<script language="JavaScript" type="text/javascript" src="layoutv2/js/jquery.flexslider.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="layoutv2/common/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="layoutv2/common/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="layoutv2/common/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

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
    	<? if (0 and isset($this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]) && $this->data['sys_configs']['indexad_enable_'.$this->data['ml_key']]==1):?>
    	$('.fancybox').click();
    	<? endif ?>
  });
</script>	

<script src="layoutv2/common/slick/slick.min.js"></script>
<script src="layoutv2/common/swipebox/js/jquery.swipebox.js"></script>

##body_end##
</body>
</html>
