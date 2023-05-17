<?php
// 這裡的JS，寫在v4/end/shop.php裡面
?>
<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $a => $item):?>

		<?php // 為了要區分一般的產品和購物車的產品?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>

		<div id="addCartPanel_<?php echo $item_id?>" class="modal addCartPanel">
		 <div class="addCart_content">
		  <form class="cont_form">
		   <div class="row">
			 <div class="col-md-3">
			  <img src="<?php echo $item['pic']?>" alt="">
			 </div>
			 <div class="col-md-9">
			  <div class="subBlockTitle"><?php echo $item['name']?></div>
			  <div class="subBlockInfo"><?php echo $item['detail']?></div>
			  <a class="subBlockTxt" href="<?php echo $item['url']?>"><i class="fa fa-external-link" aria-hidden="true"></i>看商品詳細</a>
			 </div>
			</div>
			<div class="addCart_control">
			<?php $x=1?>
			 <div class="prod_specification">
				<label><?php echo $item['single'][$x-1]['topic']?></label>
				<select class="" id="panel_<?php echo $item_id.'_'.$x?>" name="<?php echo $item['single'][$x-1]['name']?>">
					<option value="">請選擇</option>
					<?php if(isset($item['multi'][$x-1])):?>
						<?php foreach($item['multi'][$x-1] as $k => $v):?>
							<option 
								value="<?php echo $v['value']?>" 
								<?/*<?php if(isset($v['disabled'])):?> disabled="disabled" <?php endif?>*/?>
								<?php if(isset($v['selected'])):?> selected="selected" <?php endif?>

								<?php if(0 and isset($item['specs_data'][$x-1]['value']) and $v['value'] == $item['specs_data'][$x-1]['value']):?>
									<?php $_SESSION['save']['shop_spec'][$item['id']][$item['single'][$x-1]['name']] = $item['specs_data'][$x-1]['value']?>
									selected="selected" 
								<?php endif?>
							>
							<?php echo $v['name']?></option>
						<?php endforeach?>
					<?php endif?>
				</select>
			 </div><!-- .prod_specification -->
			 <div class="prod_num">
			   <label>數量</label>
			   <div>
<?php if(0):?>
				<div class="number-spinner">
				  <span class="ns-btn">
					<a data-dir="dwn"><span class="icon-minus"></span></a>
				  </span>
				  <input type="text" class="pl-ns-value" value="1" maxlength="2">
				  <span class="ns-btn">
					<a data-dir="up"><span class="icon-plus"></span></a>
				  </span>
				</div>
<?php endif?>
				<div class="number-spinner">
				  <span class="ns-btn">
				  	  <a class="minus minus_<?php echo $item_id?>" data-dir="dwn"><span class="icon-minus"></span></a>
				  </span>
				  <input type="text" class="pl-ns-value" id="amount_<?php echo $item_id?>" name="amount" maxlength=2 
					<?php if(isset($item['amount'])):?>
						value="<?php echo $item['amount']?>" 
						<?php $_SESSION['save']['shop_spec'][$item['id']]['amount'] = $item['amount']?>
					<?php else:?> 
						value="1" 
					<?php endif?>
				  ><span class="ns-btn">
				  	  <a class="add add_<?php echo $item_id?>" data-dir="up"><span class="icon-plus"></span></a>
				  </span>
				</div>
			   </div>
			 </div><!-- .prod_num -->
			 <div class="chanck"><button id="addcar_<?php echo $item_id?>" item_specid="<?php if(isset($item['specid'])):?><?php echo $item['specid']?><?php endif?>" class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i>送出</button></div>
			</div><!-- .addCart_control -->
		  </form>
		 </div><!-- .addCart_content -->
		</div><!-- #addCart_modal -->
	<?php endforeach?>
<?php endif?>

<?php //加購產品用start-----------------------------------------------------------------------------------------------------------------------------------	
unset($_constant);
eval('$_constant = '.strtoupper('shop_show_purchase').';');
if ($_constant) {
	if (isset($increase_purchases) && !empty($increase_purchases)) { 
	 foreach($increase_purchases as $a => $item):?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>

		<div id="addCartPanel_<?php echo $item_id?>" class="modal addCartPanel">
		 <div class="addCart_content">
		  <form class="cont_form">
		   <div class="row">
			<div class="col-md-3">
				<img src="<?php echo $item['pic']?>" alt="">
			</div>
			<div class="col-md-9">
				<div class="subBlockTitle"><?php echo $item['name']?></div>
				<div class="subBlockInfo"><?php echo $item['detail']?></div>
			    <a class="subBlockTxt" href="<?php echo $item['url']?>"><i class="fa fa-external-link" aria-hidden="true"></i>看商品詳細</a>
			</div>
			</div>
			<div class="addCart_control">
			<?php $x=1?>
			<div class="prod_specification">
				<label><?php echo $item['single'][$x-1]['topic']?></label>
				<select class="" id="panel_<?php echo $item_id.'_'.$x?>" name="<?php echo $item['single'][$x-1]['name']?>">
					<option value="">請選擇</option>
					<?php if(isset($item['multi'][$x-1])):?>
						<?php foreach($item['multi'][$x-1] as $k => $v):?>
							<option 
								value="<?php echo $v['value']?>" 
								<?/*php if(isset($v['disabled'])):?> disabled="disabled" <?php endif*/?>
								<?php if(isset($v['selected'])):?> selected="selected" <?php endif?>

								<?php if(0 and isset($item['specs_data'][$x-1]['value']) and $v['value'] == $item['specs_data'][$x-1]['value']):?>
									<?php $_SESSION['save']['shop_spec'][$item['id']][$item['single'][$x-1]['name']] = $item['specs_data'][$x-1]['value']?>
									selected="selected" 
								<?php endif?>
							>
							<?php echo $v['name']?></option>
						<?php endforeach?>
					<?php endif?>
				</select>
			</div><!-- .prod_specification -->
			<div class="prod_num">
			   <label>數量</label>
			   <div>

				<div class="number-spinner">
				  <span class="ns-btn">
				  	  <a class="minus minus_<?php echo $item_id?>" data-dir="dwn"><span class="icon-minus"></span></a>
				  </span>
				  <input type="text" class="pl-ns-value" id="amount_<?php echo $item_id?>" name="amount" maxlength=2 
					<?php if(isset($item['amount'])):?>
						value="<?php echo $item['amount']?>" 
						<?php $_SESSION['save']['shop_spec'][$item['id']]['amount'] = $item['amount']?>
					<?php else:?> 
						value="1" 
					<?php endif?>
				  ><span class="ns-btn">
				  	  <a class="add add_<?php echo $item_id?>" data-dir="up"><span class="icon-plus"></span></a>
				  </span>
				</div>
			   </div>
			 </div>
			 <div class="chanck"><button id="addcar_<?php echo $item_id?>" item_specid="<?php if(isset($item['specid'])):?><?php echo $item['specid']?><?php endif?>" class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i>送出</button></div>
			</div><!-- .addCart_control -->
		  </form>
		 </div>
		</div>
	<?php endforeach?>
	<? }
} 
//加購產品用end----------------------------------------------------------------------------------------------------------------------------------------
//滿額加購產品用start-----------------------------------------------------------------------------------------------------------------------------------	
unset($_constant);
eval('$_constant = '.strtoupper('shop_promo').';');
unset($_constant2);
eval('$_constant2 = '.strtoupper('shop_promo_price').';');
if ($_constant && ($_constant2 && $_constant2>0)) { 
	if (isset($ipromo_array) && !empty($ipromo_array)) { 
	 foreach($ipromo_array as $a => $item):?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>

		<div id="addCartPanel_<?php echo $item_id?>" class="modal addCartPanel">
		 <div class="addCart_content">
		  <form class="cont_form">
		   <div class="row">
			<div class="col-md-3">
				<img src="<?php echo $item['pic']?>" alt="">
			</div>
			<div class="col-md-9">
				<div class="subBlockTitle"><?php echo $item['name']?></div>
				<div class="subBlockInfo"><?php echo $item['detail']?></div>
			    <a class="subBlockTxt" href="<?php echo $item['url']?>"><i class="fa fa-external-link" aria-hidden="true"></i>看商品詳細</a>
			</div>
			</div>
			<div class="addCart_control">
			<?php $x=1?>
			<div class="prod_specification">
				<label><?php echo $item['single'][$x-1]['topic']?></label>
				<select class="" id="panel_<?php echo $item_id.'_'.$x?>" name="<?php echo $item['single'][$x-1]['name']?>">
					<option value="">請選擇</option>
					<?php if(isset($item['multi'][$x-1])):?>
						<?php foreach($item['multi'][$x-1] as $k => $v):?>
							<option 
								value="<?php echo $v['value']?>" 
								<?/*php if(isset($v['disabled'])):?> disabled="disabled" <?php endif*/?>
								<?php if(isset($v['selected'])):?> selected="selected" <?php endif?>

								<?php if(0 and isset($item['specs_data'][$x-1]['value']) and $v['value'] == $item['specs_data'][$x-1]['value']):?>
									<?php $_SESSION['save']['shop_spec'][$item['id']][$item['single'][$x-1]['name']] = $item['specs_data'][$x-1]['value']?>
									selected="selected" 
								<?php endif?>
							>
							<?php echo $v['name']?></option>
						<?php endforeach?>
					<?php endif?>
				</select>
			</div><!-- .prod_specification -->
			<div class="prod_num">
			   <label>數量</label>
			   <div>

				<div class="number-spinner">
				  <span class="ns-btn">
				  	  <a class="minus minus_<?php echo $item_id?>" data-dir="dwn"><span class="icon-minus"></span></a>
				  </span>
				  <input type="text" class="pl-ns-value" id="amount_<?php echo $item_id?>" name="amount" maxlength=2 
					<?php if(isset($item['amount'])):?>
						value="<?php echo $item['amount']?>" 
						<?php $_SESSION['save']['shop_spec'][$item['id']]['amount'] = $item['amount']?>
					<?php else:?> 
						value="1" 
					<?php endif?>
				  ><span class="ns-btn">
				  	  <a class="add add_<?php echo $item_id?>" data-dir="up"><span class="icon-plus"></span></a>
				  </span>
				</div>
			   </div>
			 </div>
			 <div class="chanck"><button id="addcar_<?php echo $item_id?>" item_specid="<?php if(isset($item['specid'])):?><?php echo $item['specid']?><?php endif?>" class="btn-cis1"><i class="fa fa-check" aria-hidden="true"></i>送出</button></div>
			</div><!-- .addCart_control -->
		  </form>
		 </div>
		</div>
	<?php endforeach?>
	<? }
} 
//滿額加購產品用end-----------------------------------------------------------------------------------------------------------------------------------	
?>