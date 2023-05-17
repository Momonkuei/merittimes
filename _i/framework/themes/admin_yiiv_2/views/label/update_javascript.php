<script type="text/javascript">
$(document).ready(function() {
	if($('#xxx01').length > 0){
		$.ajax({
			url: '<?php echo $class_url?>/get_use_where',
			type: "POST",
			data: ({label : '<?php if(isset($updatecontent['key']) and $updatecontent['key'] != ''):?><?php echo $updatecontent['key']?><?php endif?>'}),
			dataType: "html",
			404: function() {
				alert(l.get('Ajax page not found'));
			},
			success: function(msg){
				$('#xxx01').html(msg);
			}
		});
	}
});
</script>
