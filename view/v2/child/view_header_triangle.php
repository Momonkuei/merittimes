<?php if(!isset($this->data['HEAD'])):?><?php $this->data['HEAD']=''?><?php endif?>
<?php $this->data['HEAD'] .= <<<XXX


XXX;
?>

<?php if(!isset($this->data['BODY_END'])):?><?php $this->data['BODY_END']=''?><?php endif?>
<?php $this->data['BODY_END'] .= <<<XXX
<script>
	$(document).ready(function(){
		$('.Triangle__Big').css({"border-right":+$(window).width()+"px solid rgba(0, 0, 0, 0)"}).animate({
			transition: "none"},
			300, function() {
			$('.Triangle__Big').css({"transition":"none"});/* stuff to do after animation is complete */
		});
		$('.Triangle__Small').css({"border-right":+$(window).width()+"px solid rgba(0, 0, 0, 0)"}).animate({
			transition: "none"},
			300, function() {
			$('.Triangle__Small').css({"transition":"none"});/* stuff to do after animation is complete */
		});
		$(window).resize(function(){
			$('.Triangle__Big').css({"border-right":+$(window).width()+"px solid rgba(0, 0, 0, 0)"});
			$('.Triangle__Small').css({"border-right":+$(window).width()+"px solid rgba(0, 0, 0, 0)"});
			console.log($('.headerTriangle').css("border-right"));
		});
	});
</script>
XXX;
?>
<div class="Triangle">
	<div class="Triangle__rect">
		<div class="Triangle__Big"></div>
		<div class="Triangle__Small"></div>
	</div>
</div>
