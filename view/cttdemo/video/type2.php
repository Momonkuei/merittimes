<!-- <div id="news_d_tit"><h1><?php echo $data[$ID]['name']?></h1><address>日期: <?php echo $data[$ID]['start_date']?></address></div>
<div id="news_d_info">
	<iframe width="100%" height="400" src="http://www.youtube.com/embed/<?php echo $data[$ID]['youtube_code']?>" frameborder="0" allowfullscreen="allowfullscreen"></iframe><br><br> -->

	<?php echo $data[$ID]['content']?>
</div>

<div class="text-center">
	<a href="<?php echo $data[$ID]['return_url']?>" class="btn-cis1"><i class="fa fa-reply"></i>回列表</a>
</div>
