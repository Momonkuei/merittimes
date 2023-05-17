<div class="album_box clearfix">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<div class="album">
				<div class="albumimgfix"><a href="<?php echo $v['pic']?>" class="fancybox-button" rel="fancybox-button" title="<?php echo $v['name']?>"><img src="<?php echo $v['pic']?>" border="0" ></a></div>
				<div class="albumlist_description">
					<div class="album_name"><?php echo $v['name']?></div>
				</div>
			</div>
		<?php endforeach?>
	<?php endif?>
</div>

<?php if(0):?><!-- head_end -->
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="ctt/js/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="ctt/js/fancybox/jquery.fancybox.js?v=2.0.6"></script>
<link rel="stylesheet" type="text/css" href="ctt/js/fancybox/jquery.fancybox.css?v=2.0.6" media="screen" />
<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="ctt/js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
<script type="text/javascript" src="ctt/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="ctt/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.2" />
<script type="text/javascript" src="ctt/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.2"></script>
<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="ctt/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.0"></script>

<script type="text/javascript">
	$(document).ready(function() {
	$(".fancybox-button").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: false,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});
});
</script>
<style type="text/css">
.fancybox-custom .fancybox-skin { box-shadow: 0 0 50px #222;}
</style>
<?php endif?><!-- head_end -->
