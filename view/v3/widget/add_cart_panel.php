<?php
// 這裡的JS，寫在v3/end/shop.php裡面
?>
<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $a => $item):?>

		<?php // 為了要區分一般的產品和購物車的產品?>
		<?php $item_id = $item['id']?>
		<?php if(isset($item['id_key_name'])):?>
			<?php $item_id = $item['id_key_name']?>
		<?php endif?>

		<?php $_specs_body_end_add_cart = $item['multi'][0];//增加一個 _specs_body_end 給放到body_end的JS用 #38099?>

		<div class="addCartPanel addCartPanel_<?php echo $item_id?> popBox">
			<div class="closeSpace closeBtn" data-target=".addCartPanel"></div>
			<div class="boxContent">
				<a href="#_" class="closeBtn" data-target=".addCartPanel"><i class="fa fa-times"></i></a>
				
				<section class="proDetail mainContent">
					<div>
						<div class="gridBox closest" data-grid="12">
							<div class="col_3" data-rwd="s5">
								<div><div class="itemImg"><img src="<?php echo $item['pic']?>"></div></div>
							</div>
							<div class="col_9">
								<div class="itemTitle"><?php echo $item['name']?></div>
								<div class="itemInfo" data-txtlen="40"><?php echo $item['detail']?></div>
								<a href="<?php if(isset($item['url'])){ echo $item['url'];}?>" class="icon-link"><i class="fa fa-external-link" aria-hidden="true"></i><?php echo t('看商品詳細')?></a>
							</div>
							<div class="col_full">
								<div class="shopForm">
									<form>

										<?php // 2017-06-23 這裡只有分散的寫法，還缺合併的寫法?>

										<?php // 這三個變化區塊，在產品內頁中，是寫在一起的，但在浮起來的視窗中，它是分別放在這裡，和view/end/shop.php裡面?>
										<?php for($x=1;$x<=4;$x++):?>
											<?php if(!isset($item['single'][$x-1])):?><?php break?><?php endif?>
											<?php if($x == '1'):// dropdown?>
												<div class="formItem">
													<?php if(isset($_specs_body_end_add_cart) && count($_specs_body_end_add_cart) > 1)://#38099?>
													<label><?php echo t($item['single'][$x-1]['topic'])?></label>
													<?php endif?>
													<select class="" id="panel_<?php echo $item_id.'_'.$x?>" name="<?php echo $item['single'][$x-1]['name']?>" <?php if(isset($_specs_body_end_add_cart) && count($_specs_body_end_add_cart) < 2)://#38099?> style="display:none" <?php endif?>>
														<?php if(isset($_specs_body_end_add_cart) && count($_specs_body_end_add_cart) > 1)://#38099?>
														<option value=""><?php echo t('請選擇')?></option>
														<?php endif?>
														<?php if(isset($item['multi'][$x-1])):?>
															<?php foreach($item['multi'][$x-1] as $k => $v):?>
																<option 
																	value="<?php echo $v['value']?>" 
																	<?php if(isset($v['disabled'])):?> disabled="disabled" <?php endif?>
																	<?php if(isset($v['selected'])):?> selected="selected" <?php endif?>

																	<?php if(0 and isset($item['specs_data'][$x-1]['value']) and $v['value'] == $item['specs_data'][$x-1]['value']):?>
																		<?php $_SESSION['save']['shop_spec'][$item['id']][$item['single'][$x-1]['name']] = $item['specs_data'][$x-1]['value']?>
																		selected="selected" 
																	<?php endif?>
																>
																<?php if($v['name']==''){echo $v['name2'];} else { echo $v['name'];}?></option>
															<?php endforeach?>
														<?php endif?>
													</select>
												</div>
											<?php elseif($x == '2'):// 顏色和標題(radio)，其中顏色是非必填?>
												<div class="formItem">
													<label><?php echo $item['single'][$x-1]['topic']?></label>
													<div class="cube">
														<?php if(isset($item['multi'][$x-1])):?>
															<?php foreach($item['multi'][$x-1] as $k => $v):?>
																<label><input type="radio" class="panel_<?php echo $item_id.'_'.$x?>" 
																	name="<?php echo $item['single'][$x-1]['name']?>" 
																	value="<?php echo $v['value']?>" 
																	<?php if(isset($v['disabled'])):?> disabled="disabled" <?php endif?> 
																	<?php if(isset($item['specs_data'][$x-1]['value']) and $v['value'] == $item['specs_data'][$x-1]['value']):?>
																		<?php $_SESSION['save']['shop_spec'][$item['id']][$item['single'][$x-1]['name']] = $item['specs_data'][$x-1]['value']?>
																		checked="checked" 
																	<?php endif?>
																> 
																<span><?php if(isset($v['pic'])):?><img src="<?php echo $v['pic']?>" /><?php endif?> <?php echo $v['name']?></span> </label>
															<?php endforeach?>
														<?php endif?>
													</div>
												</div>
											<?php elseif($x == '3'):// 色塊(radio)?>
												<div class="formItem">
													<label><?php echo $item['single'][$x-1]['topic']?></label>
													<div class="cube img">
														<?php if(isset($item['multi'][$x-1])):?>
															<?php foreach($item['multi'][$x-1] as $k => $v):?>
																<label><input type="radio" class="panel_<?php echo $item_id.'_'.$x?>" 
																	name="<?php echo $item['single'][$x-1]['name']?>" 
																	value="<?php echo $v['value']?>"  
																	<?php if(isset($v['disabled'])):?> disabled="disabled" <?php endif?> 
																	<?php if(isset($item['specs_data'][$x-1]['value']) and $v['value'] == $item['specs_data'][$x-1]['value']):?>
																		<?php $_SESSION['save']['shop_spec'][$item['id']][$item['single'][$x-1]['name']] = $item['specs_data'][$x-1]['value']?>
																		checked="checked" 
																	<?php endif?>
																>  
																<span><?php if(isset($v['pic'])):?><img src="<?php echo $v['pic']?>" /><?php endif?></span> </label>
															<?php endforeach?>
														<?php endif?>
													</div>
												</div>
											<?php endif?>
										<?php endfor?>
										<?php if(isset($_specs_body_end_add_cart) && count($_specs_body_end_add_cart) !=0 )://下拉數量如果不為0，就顯示數量?>
										<div class="Bbox_flexBetween Quantity_<?php echo $item_id?>">
											<div class="formItem">
												<label><?php echo t('數量')?></label>
												<div class="numSet">
													<button class="minus minus_<?php echo $item_id?>">-</button><input type="text" id="amount_<?php echo $item_id?>" name="amount" 
														<?php if(isset($item['amount'])):?>
															value="<?php echo $item['amount']?>" 
															<?php $_SESSION['save']['shop_spec'][$item['id']]['amount'] = $item['amount']?>
														<?php else:?> 
															value="1" 
														<?php endif?>
													><button class="add add_<?php echo $item_id?>">+</button>
												</div>
												<span class="stockTips" data-stockStatus="3" id="amount_status_<?php echo $item_id?>"></span><?php // 庫存狀態文字?>
											</div>
											
										</div>						
										<?php endif?>

										<div class="hrTitle"></div>
										<div>
										<?php if(isset($_specs_body_end_add_cart) && count($_specs_body_end_add_cart) !=0 )://下拉數量如果不為0，就顯示送出，不然就是顯示聯絡我們?>
										<button id="addcar_<?php echo $item_id?>" item_specid="<?php if(isset($item['specid'])):?><?php echo $item['specid']?><?php endif?>" class=""><i class="fa fa-check"></i><?php echo t('確認送出')?></button>
										<?php else:?>
											<a class="justlikebtn_C" href="contact_<?php echo $this->data['ml_key']?>.php" target="_blank"><?php echo t('聯絡我們')?></a>
										<?php endif?>
										<?php //這個是JS設定了下拉，如果數值有問題就會顯示這個?>
										<a class="justlikebtn_C" id="_justlikebtn_<?php echo $item_id?>"  style="display:none" href="contact_<?php echo $this->data['ml_key']?>.php" target="_blank"><?php echo t('聯絡我們')?></a>
										</div>
											
									</form>

								</div>
							</div>
						</div>
					</div>
					
				</section>

			</div>
		</div>
	<?php endforeach?>
<?php endif?>
