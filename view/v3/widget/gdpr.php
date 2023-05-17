<?php if( empty($_COOKIE['gdprview']) ):?>
<div class="GDPR">
	<div class="w1200px block">
		<div class="gridBox" data-grid="4">
			<div class="col_3" data-rwd="l3m3s4x4" >
				<p class="GDPR__text">We use cookies to provide the services and features offered on our website, and to improve our user experience. By using this website, you consent to the use of cookies.</p>
			</div>
			<div class="col_1" data-rwd="l1m1s4x4" >
				<div class="GDPR__btnArea">
				<a href="javascript:void(0);" class="GDPR__btn btn-cis1">OK</a>
				<a href="gdpr_<?php echo $this->data['ml_key']?>_1.php" class="GDPR__infoLink" >more information</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif?>
