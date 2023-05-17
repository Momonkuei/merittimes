<!-- // DATA2:SINGLE -->
<?php $other = $data[$ID]?>
<?php $${CONNECT_A} = $ID?>

<!-- // DATA2:MULTI -->
<?php $_specs_body_end = $specs = $data[$ID];//增加一個 _specs_body_end 給放到body_end的JS用 #38099?>

<?php
/*
 * 2020-06-20
 * 這裡有浮起來的視窗，像是首頁和產品列表頁，以及產品內頁在使用
 * 如果要用在A方案，只要把CONNECT_A那邊
 * 把html的部份，和JS的部份，都寫死成一個固定的字串，就可以了
 * 例如：aaa
 * 至於$other的部份，就直接寫死就好了
 */
?>
<?php if($this->data['router_method'] == 'shopdetail'):?>
<div class="form-group ">
<?php else:?>
<div class="formItem">
<?php endif?>
	<?php define('_SPEC_DATA_ARRAY_NUM', count($_specs_body_end));// 下面的數量判斷也會被相關產品影響，所以這邊做個常數給下面判斷用  by lota 2020/02/23?>
	<?php if(isset($_specs_body_end) && count($_specs_body_end) > 1)://#38099?>
	<label><?php echo $other['topic']?></label>
	<?php endif?>
	<select class="" id="<?php echo $${CONNECT_A}?>" name="<?php echo $other['name']?>" <?php if(isset($_specs_body_end) && count($_specs_body_end) < 2)://#38099?> style="display:none" <?php endif?>>
		<?php if(isset($_specs_body_end) && count($_specs_body_end) > 1)://#38099?>
		<option value=""><?php echo t('請選擇')?></option>
		<?php endif?>
		<?php if(isset($specs)):?>
			<?php foreach($specs as $k => $v):?>
				<?php if($k==0){
					define('_FIRST_SPEC_DATA_', $v['value']);//2021/1/7 by lota 使用常數來帶入下面JS的判斷
				}
				?>
				<option value="<?php echo $v['value']?>" name2="<?php echo $v['name2']?>" price="<?php echo $v['price_format_ds']?>" price2="<?php echo $v['price2_format_ds']?>" <?php if(isset($v['disabled'])):?> disabled="disabled" <?php endif?> <?php if(isset($v['selected'])):?> selected="selected" <?php endif?> ><?php if($v['name']==''){echo $v['name2'];} else { echo $v['name'];}?></option>
			<?php endforeach?>
		<?php endif?>
	</select>
</div>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
var pr_gggid = '<?php echo $${CONNECT_A}?>';//2021/03/02 這邊的ID要獨立，不能跟相關產品重複 by lota
$('body').on('change','#' + pr_gggid,function(){
	$('.itemSN').html($('#'+pr_gggid+' :selected').attr('name2'));

	// 2020-06-20 這段是舊的，留著參考
	// $('.price').html('原價：$'+number_format($('#'+pr_gggid+' :selected').attr('price')));
	// $('.price2').html('$'+number_format($('#'+pr_gggid+' :selected').attr('price2')));
	if($('#'+pr_gggid+' :selected').val()!='' && $('#'+pr_gggid+' :selected').val()!=null){
		$('.price').html('<?php echo t('原價')?>：'+$('#'+pr_gggid+' :selected').attr('price'));
		$('.price2').html($('#'+pr_gggid+' :selected').attr('price2'));
	}

	<?php //2020/08/19 加入如果價格為0，則不顯示購物車按鈕 ?>
	$("#addcar").show();
	$("#addcar2").show();
	if($('#'+pr_gggid+' :selected').attr('price2') == '$0'){
		$("#addcar").hide();
		$("#addcar2").hide();
	}

	$.ajax({
		type: "POST",
		data: {
			'id': '<?php echo str_replace('detail','',$this->data['router_method'])?>_spec',
			'primary_key': '<?php echo $data2[$${CONNECT_A}]['single'][0]['itemid']?>',
			'<?php echo $data2[$${CONNECT_A}]['single'][0]['name']?>': $(this).val()
		},
		url: 'save.php',
		success: function(response){
			//location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

<?php //如果規格只有一個，那就直接自動選擇規格 #38099 ?>



<?php if(0):?><!-- body_end -->
<?php if(defined('_SPEC_DATA_ARRAY_NUM') && _SPEC_DATA_ARRAY_NUM == 1)://這邊要注意layoutv3的文本判斷順序... 這邊改用常數來判斷 by lota 2020/02/23?>
<script type="text/javascript">
var gggid = '<?php echo $${CONNECT_A}?>';
var _saveValue = '<?php echo _FIRST_SPEC_DATA_?>';//2021/1/7 by lota 改用常數來帶入判斷
	$('#' + gggid).val(_saveValue).trigger('change');
	<?php //2020/12/10 加入如果自動選擇的項目有問題，則不顯示購物車按鈕 ?>
	if($('#' + gggid).val() ==null){
		$("#addcar").hide();
		$("#addcar2").hide();
		$("._Quantity").hide();
		$(".justlikebtn_R").show();
	}
</script>
<?php endif?>
<?php endif?><!-- body_end -->


