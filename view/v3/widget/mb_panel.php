<?php if(0):?><!-- body_end -->
<script type="text/javascript">
if($(window).width() < 1025){

	//ajax to get data
	var mbPanelDatas = "";
	$.ajax({
		url: "ajax2.php?func=mb_panel",
		type: "POST",
		async: false,
		dataType: "json",
		success: function(data) {
			mbPanelDatas=data['mbPanel'];
		},
		error: function() {
			console.log("mbPanel get Data ERROR!!!");
		}
	});
	var mbPanelSet=mbPanelDatas['mbPanelSet'];
	var mbPanelDataSet=mbPanelDatas['mbPanelDataSet'];
	
}
</script>

<script type="text/javascript">
	//define #mbPanel wrap
	var mbPanelWrap="body>*:not(script):not(.pageWidget)";
	//define mb hide block (selector)
	var hideBlock=".header";
</script>

<script src="js/mbPanel.js"></script>
<?php endif?><!-- body_end -->
