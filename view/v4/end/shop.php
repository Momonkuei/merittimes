<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $a => $item):?>

		<?php // 為了要區分一般的產品和購物車的產品?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>

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
					var num = $('#amount_<?php echo $item_id?>').val();
					var color = $(this).val();
					if(color!=''){
						$.ajax({
							url: 'shop_<?php echo $this->data['ml_key']?>.php',
							type: "POST",
							data: {
								"num": num,
								"productno": '<?php echo $item_id?>',
								"color": color,
								'func': 'changSpec',
							}
						}).done(function(msg) {
							if (msg != 1) {
								var content='contact/<?=$_SESSION['save']['contact_dynamic_url']?>.html';
								$('.chanck').html('<p style="color:red;">庫存不足!</p><a style="cursor: pointer;" class="btn-cis1" onclick="javascript:location.href=\''+content+'\'">聯絡我們</a>');                 
							}else{
								$('.chanck').html('<button id="addcar_<?php echo $item_id?>" item_specid="" class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i>送出</button>'); 
							}
						}).fail(function (jqXHR, textStatus) {
							console.log(textStatus);
						});
					}	
				});
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
					'specid': specid
				},
				url: 'shop_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);	
				}
			}); // ajax
			e.preventDefault();
		});
		$('body').on('click','.number-spinner .minus_<?php echo $item_id?>',function(){
			var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
			if(nowVal <= 1){
				nowVal = 1;
			}
			$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		 	$('#amount_<?php echo $item_id?>').change();
			return false;
		});
		$('body').on('click','.number-spinner .add_<?php echo $item_id?>',function(){
			var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
			$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		 	$('#amount_<?php echo $item_id?>').change();
			return false;
		});
		</script>

	<?php endforeach?>
<?php endif?>


<?php //加購產品用start-----------------------------------------------------------------------------------------------------------------------------------	
unset($_constant);
eval('$_constant = '.strtoupper('shop_show_purchase').';');
if ($_constant) { 
	if (isset($increase_purchases) && !empty($increase_purchases) && !isset($is_repeat)) { 
		foreach($increase_purchases as $a => $item):?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>
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
					var num = $('#amount_<?php echo $item_id?>').val();
					var color = $(this).val();
					if(color!=''){
						$.ajax({
							url: 'shop_<?php echo $this->data['ml_key']?>.php',
							type: "POST",
							data: {
								"num": num,
								"productno": '<?php echo $item_id?>',
								"color": color,
								'func': 'changSpec',
							}
						}).done(function(msg) {
							if (msg != 1) {
								var content='contact/<?=$_SESSION['save']['contact_dynamic_url']?>.html';
								$('.chanck').html('<p style="color:red;">庫存不足!</p><a style="cursor: pointer;" class="btn-cis1" onclick="javascript:location.href=\''+content+'\'">聯絡我們</a>');                 
							}else{
								$('.chanck').html('<button id="addcar_<?php echo $item_id?>" item_specid="" class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i>送出</button>'); 
							}
						}).fail(function (jqXHR, textStatus) {
							console.log(textStatus);
						});
					}			
				});
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
					'specid': specid
				},
				url: 'shop_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);	
				}
			}); // ajax
			e.preventDefault();
		});
		$('body').on('click','.number-spinner .minus_<?php echo $item_id?>',function(){
			var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
			if(nowVal <= 1){
				nowVal = 1;
			}
			$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		 	$('#amount_<?php echo $item_id?>').change();
			return false;
		});
		$('body').on('click','.number-spinner .add_<?php echo $item_id?>',function(){
			var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
			$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		 	$('#amount_<?php echo $item_id?>').change();
			return false;
		});
		</script>

	<?php endforeach?>
	<?$is_repeat=true;?>
	<? }
} 
//加購產品用end-----------------------------------------------------------------------------------------------------------------------------------------	
//滿額加購產品用start------------------------------------------------------------------------------------------------------------------------------------	
unset($_constant);
eval('$_constant = '.strtoupper('shop_promo').';');
unset($_constant2);
eval('$_constant2 = '.strtoupper('shop_promo_price').';');
if ($_constant && ($_constant2 && $_constant2>0)) { 
	if (isset($ipromo_array) && !empty($ipromo_array) && !isset($is_promo)) { 
		foreach($ipromo_array as $a => $item):?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>
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
					var num = $('#amount_<?php echo $item_id?>').val();
					var color = $(this).val();
					if(color!=''){
						$.ajax({
							url: 'shop_<?php echo $this->data['ml_key']?>.php',
							type: "POST",
							data: {
								"num": num,
								"productno": '<?php echo $item_id?>',
								"color": color,
								'func': 'changSpec',
							}
						}).done(function(msg) {
							if (msg != 1) {
								var content='contact/<?=$_SESSION['save']['contact_dynamic_url']?>.html';
								$('.chanck').html('<p style="color:red;">庫存不足!</p><a style="cursor: pointer;" class="btn-cis1" onclick="javascript:location.href=\''+content+'\'">聯絡我們</a>');                 
							}else{
								$('.chanck').html('<button id="addcar_<?php echo $item_id?>" item_specid="" class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i>送出</button>'); 
							}
						}).fail(function (jqXHR, textStatus) {
							console.log(textStatus);
						});
					}			
				});
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
					'has_additional_promo': '<?php if(isset($item['has_additional_promo'])):?><?php echo $item['has_additional_promo']// 為了要標示加購?><?php endif?>',
					'specid': specid
				},
				url: 'shop_<?php echo $this->data['ml_key']?>.php',
				success: function(response){
					eval(response);	
				}
			}); // ajax
			e.preventDefault();
		});
		$('body').on('click','.number-spinner .minus_<?php echo $item_id?>',function(){
			var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
			if(nowVal <= 1){
				nowVal = 1;
			}
			$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		 	$('#amount_<?php echo $item_id?>').change();
			return false;
		});
		$('body').on('click','.number-spinner .add_<?php echo $item_id?>',function(){
			var nowVal=$(this).parent().parent().find(".pl-ns-value").val();
			$(this).parent().parent().find(".pl-ns-value").val(nowVal);
		 	$('#amount_<?php echo $item_id?>').change();
			return false;
		});
		</script>

	<?php endforeach?>
	<?$is_promo=true;?>
	<? }
} //滿額加購產品用end-----------------------------------------------------------------------------------------------------------------------------------
?>