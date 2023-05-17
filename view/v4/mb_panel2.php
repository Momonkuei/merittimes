<script type="text/javascript" m="body_end">
	if ($(window).width() < 1025) {

		//ajax to get data
		var mbPanelDatas = "";
		$.ajax({
			url: "mbpanel_" + ml_key + ".php",
			//url: "old_mbpanel2.php",
			type: "POST",
			async: false,
			dataType: "json",
			success: function(data) {
				mbPanelDatas = data['mbPanel'];
			},
			error: function() {
				console.log("mbPanel get Data ERROR!!!");
			}
		});
		var mbPanelSet = mbPanelDatas['mbPanelSet'];
		var mbPanelDataSet = mbPanelDatas['mbPanelDataSet'];

	}
</script>

<script type="text/javascript" m="body_end">
	//define #mbPanel wrap
	var mbPanelWrap = "body>*:not(script):not(.pageWidget):not(.gotop):not(.gdprBlock):not(.fixedIcons)";
	//define mb hide block (selector)
	var hideBlock = ".header";
</script>

<?php if (0) : ?>
	<script src="js_v4/mbPanel/mbPanel.js"></script>
<?php endif ?>

<script src="js_common/mbPanel.js" m="body_end"></script>

<?php if (0) : ?>
	<!-- body_end -->
<?php endif ?>
<!-- body_end -->