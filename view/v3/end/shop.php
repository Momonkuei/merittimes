<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $a => $item):?>

		<?php // 為了要區分一般的產品和購物車的產品?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>

		<?php $_specs_body_end_shop = $item['multi'][0];//增加一個 _specs_body_end_shop 給放到body_end的JS用 #38099?>

		<?php for($x=1;$x<=4;$x++):?><?php // 1,2,3,4是後台4個規格的欄位，目前做的範例母版，只有用到兩個，而下面撰寫只有寫三個變化區塊，請自由使用?>
			<?php if(!isset($item['single'][$x-1])):?><?php break?><?php endif?>
			<?php if($x == '1'):?>
				<script type="text/javascript" m="body_end">
				var gggid='panel_<?php echo $item_id.'_'.$x?>';
				$('body').on('change','#' + gggid,function(){
					<?php if($this->data['router_method'] == 'checkout'):?>
						$(this).parent().parent().find('button').attr('item_specid',$(this).val());
					<?php endif?>
					$.ajax({
						type: "POST",
						data: {
							'id': 'shop_spec',
							'primary_key': '<?php echo $item['id']?>',
							'<?php echo $item['single'][$x-1]['name']?>': $(this).val()
						},
						url: 'save.php',
						success: function(response){
							//location.reload();
						}
					}); // ajax
				});

				<?php //如果規格只有一個，那就直接自動選擇規格 #38076 ?>
				<?php if(isset($_specs_body_end_shop) && count($_specs_body_end_shop) == 1):?>
					var _saveValue = '<?php echo $_specs_body_end_shop[0]['value']?>';
					var _item_id = '<?php echo $item_id;?>';
					$('#' + gggid).val(_saveValue).trigger('change');
					<?php //2020/12/10 加入如果自動選擇的項目有問題，則不顯示購物車按鈕跟數量 ?>
					if($('#' + gggid).val() ==null){
						$("#addcar_" + _item_id).hide();
						$(".Quantity_" + _item_id).hide();	
						$("#_justlikebtn_" + _item_id).show();				
					}
				<?php endif?>

				</script>
			<?php elseif($x == '2'):?>
				<script type="text/javascript">
				var gggid='panel_<?php echo $item_id.'_'.$x?>';
				$('body').on('click','.' + gggid,function(){
					$.ajax({
						type: "POST",
						data: {
							'id': 'shop_spec',
							'primary_key': '<?php echo $item['id']?>',
							'<?php echo $item['single'][$x-1]['name']?>': $('.addCartPanel_<?php echo $item_id?> input[name=<?php echo $item['single'][$x-1]['name']?>]:checked').val()
						},
						url: 'save.php',
						success: function(response){
							//location.reload();
						}
					}); // ajax
				});
				</script>
			<?php elseif($x == '3'):?>
				<script type="text/javascript">
				var gggid='panel_<?php echo $item_id.'_'.$x?>';
				$('body').on('click','.' + gggid,function(){
					$.ajax({
						type: "POST",
						data: {
							'id': 'shop_spec',
							'primary_key': '<?php echo $item['id']?>',
							'<?php echo $item['single'][$x-1]['name']?>': $('.addCartPanel_<?php echo $item_id?> input[name=<?php echo $item['single'][$x-1]['name']?>]:checked').val()
						},
						url: 'save.php',
						success: function(response){
							//location.reload();
						}
					}); // ajax
				});
				</script>
			<?php endif?>
		<?php endfor?>

		<script type="text/javascript" m="body_end">
		$('body').on('change','#amount_<?php echo $item_id?>',function(){
			$.ajax({
				type: "POST",
				data: {
					'id': 'shop_spec',
					'primary_key': '<?php echo $item['id']?>',
					'amount': $('#amount_<?php echo $item_id?>').val()
					//'_append': ''
				},
				url: 'save.php',
				success: function(response){
					//location.reload();
				}
			}); // ajax
		});
		$('body').on('click','#addcar_<?php echo $item_id?>',function(e){
			var specid = $(this).attr('item_specid');
			$.ajax({
				type: "POST",
				data: {
					'func': 'addcar',
					'id': '<?php echo $item['id']?>',
					'tid': '_<?php echo $item_id?>',
					'id_key_name': '<?php if(isset($item['id_key_name'])):?><?php echo $item['id_key_name']//這個是step1的訂單產品修改規格用?><?php endif?>',
					'has_additional_purchase': '<?php if(isset($item['has_additional_purchase'])):?><?php echo $item['has_additional_purchase']// 為了要標示加購?><?php endif?>',
					'has_additional_promo': '<?php if(isset($item['has_additional_promo'])):?><?php echo $item['has_additional_promo']// 為了要標示滿額加購?><?php endif?>',
					'specid': specid
				},
				url: 'shop_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);	
				}
			}); // ajax
			e.preventDefault();
		});
		function numCal(calType,nowVal){          

			if(calType=="-"){
				var newVal=parseInt(nowVal)-1;
				newVal=(newVal<=0)?1:newVal;
			}
			if(calType=="+"){
				var newVal=parseInt(nowVal)+1;
			}

			return newVal;
		}
		$('body').on('click','.numSet .minus_<?php echo $item_id?>',function(){
			var nowVal=$(this).siblings("input").val();
			$(this).siblings("input").val(numCal("-",nowVal));
			$('#amount_<?php echo $item_id?>').change();
			return false;

		});
		$('body').on('click','.numSet .add_<?php echo $item_id?>',function(){
			var nowVal=$(this).siblings("input").val();
			$(this).siblings("input").val(numCal("+",nowVal));
			$('#amount_<?php echo $item_id?>').change();
			return false;

		});
		</script>

	<?php endforeach?>
<?php endif?>
