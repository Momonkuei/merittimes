<div class="sideCart popBox">
	<div class="closeSpace closeBtn" data-target=".sideCart"></div>
	<div class="boxContent">
		<a href="#_" class="closeBtn" data-target=".sideCart"><i class="fa fa-times"></i></a>
		<div class="cartInfo">

<!-- // DATA2:SINGLE -->

			<div class="cartTitle">
				<h3>購物車 (<span><?php echo $data[$ID]['count']?></span>)</h3>
				<h5>TOTAL:<span class="cis1" style="color:yellow"><?php echo $data[$ID]['total']?></span></h5><?php //這邊先用style 強制變色，再等待有緣人來救它...by lota?>
			</div>

			<?php if(isset($this->data['admin_id'])):?>
				<a href="checkout_<?php echo $this->data['ml_key']?>.php?step=1" class="btn-cis1"><i class="fa fa-shopping-cart"></i>立即結帳</a>
			<?php else:?>
				<a href="javascript:;" class="btn-cis1 openBtn" data-target="#loginPanel"><i class="fa fa-shopping-cart"></i>立即結帳</a>
			<?php endif?>


		</div>

		<section class="proTableList">	

			<div class="itemList">

<!-- // DATA2:MULTI -->

				<?php if(isset($data[$ID])):?>
					<?php foreach($data[$ID] as $k => $v):?>
						<div class="tableItem" data-itemSNo="<?php echo $v['item']['id']?>">
							<div>
								<div class="gridBox nogap" data-grid="4">
									<div class="col_1 proImg" data-rwd="x1">
										<a href="<?php echo $v['item']['url1']?>"><div class="itemImg"><img src="<?php echo $v['item']['pic']?>"></div></a>
									</div>
									<div class="col_3" data-rwd="x3">
										<div><a href="<?php echo $v['item']['url2']?>" class="itemTitle"><?php echo $v['item']['name']?></a></div>
										<?php if(isset($v['item']['promotion'])):?>
											<div><a href="<?php echo $v['item']['url3']?>" class="itemSP"><?php echo $v['item']['promotion_name']?></a></div>
										<?php else:?>
											<div><a href="javascript:;" class="itemSP"></a></div>
										<?php endif?>
										<div>									
											<span class="itemPrice vip"><label>特價</label><?php echo $v['item']['price']?></span>
											<span class="itemQty"><label>數量</label><?php echo $v['amount']?></span>								
										</div>
										<div><a item_id="<?php echo $k?>" href="javascript:;" class="icon-link delcar"><i class="fa fa-trash"></i><span class="txt">刪除</span></a></div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach?>
				<?php endif?>

			</div>
		</section>

	</div>
</div>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.delcar',function(){
	var thisobj = $(this);
	var item_id = thisobj.attr('item_id');
	$.ajax({
		type: "POST",
		data: {
			'func': 'delcar',
			'id': item_id
		},
		url: 'shop_<?php echo $this->data['ml_key']?>.php',
		success: function(response){
			eval(response);	
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->
