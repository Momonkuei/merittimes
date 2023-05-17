<div class="formItem">
<!-- // DATA2:SINGLE -->
<?php $${CONNECT_A} = $ID?>
	<label><?php echo $data[$ID]['topic']?></label>
	<?php $item = $data[$ID]//我不是產品哦?>
	<div class="cube img">
<!-- // DATA2:MULTI -->
		<?php if(isset($data[$ID])):?>
			<?php foreach($data[$ID] as $k => $v):?>
				<label><input type="radio" class="<?php echo $ID?>" name="<?php echo $item['name']?>" value="<?php echo $v['value']?>"  <?php if(isset($v['disabled'])):?> disabled="disabled" <?php endif?> >  <span><?php if(isset($v['pic'])):?><img src="<?php echo $v['pic']?>" /><?php endif?></span> </label>
			<?php endforeach?>
		<?php endif?>
	</div>
</div>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
var gggid = '<?php echo $${CONNECT_A}?>';
$('body').on('click','.' + gggid,function(){
	$.ajax({
		type: "POST",
		data: {
			'id': '<?php echo str_replace('detail','',$this->data['router_method'])?>_spec',
			'primary_key': '<?php echo $data2[$${CONNECT_A}]['single'][0]['itemid']?>',
			'<?php echo $data2[$${CONNECT_A}]['single'][0]['name']?>': $('.' + gggid + ':checked').val()
		},
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->
