<div class="faqItem_main faqItemStyle-1">
  	<?php if(isset($data[$ID])):?>
  		<?php foreach($data[$ID] as $k => $v):?>
			<div class="faqItem">
				<div class="faqItem_head"><i class="fa fa-caret-right" aria-hidden="true"></i><?php echo $v['name']?></div>
				<div class="faqItem_body"><?php echo $v['detail']?></div>
			</div><!-- .faqItem -->
		<?php endforeach?>
	<?php endif?>
</div><!-- .faqItem_main -->

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$(document).ready(function(){
	$('.faqItem:nth-child(1) .faqItem_body').show();
	$('.faqItem:nth-child(1)').addClass('faqItem_current');
	$('.faqItem_head').click(function(){
		if($(this).parents('.faqItem').hasClass('faqItem_current')){
			$(this).parents('.faqItem').removeClass('faqItem_current');
			$(this).siblings('.faqItem_body').slideUp(800);
		}
		else{
			$(this).parents('.faqItem').siblings('.faqItem').find('.faqItem_body').slideUp(800);
			$(this).parents('.faqItem').siblings('.faqItem').removeClass('faqItem_current');
			$(this).parents('.faqItem').addClass('faqItem_current');
			$(this).siblings('.faqItem_body').slideDown(800);
		}
	});

});
</script>
<?php endif?><!-- body_end -->
