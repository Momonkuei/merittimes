<a id="showCart" class="showCart openBtn" data-target=".sideCart"> 	
	<i class="fa fa-shopping-cart"></i>	
	<img src="images/<?php echo $this->data['ml_key']?>/icon-cart.svg">
	<?php
		// 購物車 //#38099
		if(!isset($_SESSION['save']['shop_car'])) $_SESSION['save']['shop_car'] = array();
		$car_amount = count($_SESSION['save']['shop_car']);
		if($car_amount < 0){
			$car_amount = 0;
		}
	?>
	<?php if(1 or $car_amount)://購物數量 需要前端寫CSS配合，目前先暫時隱藏?>
		<p><?php echo $car_amount?></p>
	<?php endif?>
</a>
