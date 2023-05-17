<div>
	<form>
		<div class="sideForm">
<?php $${CONNECT_A} = $ID?>
			<?php if(isset($data[$ID])):?>
				<?php foreach($data[$ID] as $k => $v):?>
					<div class="checkbox"><label><input type="checkbox" <?php if(isset($v['checked'])):?> checked="checked" <?php endif?> class="<?php echo $ID?>" field1="<?php echo $v['sectionid']?>" field2="<?php echo $v['id']?>" value="<?php echo $k?>"><span><?php if(isset($v['pic']) and $v['pic'] != ''):?><img src="<?php echo $v['pic']?>"><?php endif?><?php echo $k?></span></label></div>
				<?php endforeach?>
			<?php endif?>
		</div>
		<!--<div class="text-right"><input type="reset" class="btn-link" value="重設"></div>-->
	</form>
</div>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
var gggid = '<?php echo $${CONNECT_A}?>';
$('.'+gggid).change(function(){
	var thisobj = $(this);
	var field1 = thisobj.attr('field1');
	var field2 = thisobj.attr('field2');

	var data = '';
	if($(this).is(":checked")){
		data = thisobj.val();
	} else {
		data = '';
	}
	$.ajax({
		type: "POST",
		data: {
			'id': '<?php echo str_replace('detail','',$this->data['router_method'])?>_filter',
			'primary_key': field1+'___'+thisobj.attr('value'),
			'data': data,
			'field': field2
		},
		url: 'save.php',
		success: function(response){
			//location.reload();
			window.location.href='shop_<?php echo $this->data['ml_key']?>.php';
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->
