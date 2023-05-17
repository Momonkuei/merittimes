<link href="ctt/js/lib/ui/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
<script src="ctt/js/lib/ui/jquery-ui-1.10.3.custom.js"></script>
<script>
$(document).ready(function(e) {
    $( "#accordion" ).accordion({
      heightStyle: "content"
    });
});
</script>
<div id="accordion">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<h3 style="margin:10px 0 10px 0; font-family:Microsoft JhengHei;"> <em>Q<?php echo $k+1?></em> <?php echo $v['name']?></h3>
			<div>
				<p><?php echo $v['content']?></p>
			</div>
		<?php endforeach?>
	<?php endif?>
</div>
