<footer>

	<div class="footerContent">
		<section class="footerType2">
			<div>
				<section>
					<div class="footerLogo"><img src="images/logo.png"></div>
				</section>
			</div>
		</section>
		<section class="footerType1">
			<div>
				<section>
					<ul class="siteMap type2">
						<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
							<?foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
								<li><a href="<?php echo $v['url1']?>"><?php echo G::t(null,$v['topic'])?></a></li>
							<?php endforeach?>
						<?php endif?>
					</ul>
				</section>
			</div>
			<div>
				<section>
					<ul class="companyInfo">
						<li><i class="fa fa-map-marker"></i><a href="https://goo.gl/maps/V3AaPziYQ442" target="_blank">台中市文心路三段155-1號3F</a></li>
						<li><i class="fa fa-phone"></i> 04-2317-8388</li>
						<li><i class="fa fa-envelope"></i><a href="mailto:service@buyersline.com.tw">service@buyersline.com.tw</a></li>
					</ul>
				</section>
			</div>
		</section>
	</div>

	<div class="footerContent copyright">
		<section class="copyRightTxt">Copyright © 2016 BuyersLine All Rights Reserved. <a href="http://www.buyersline.com.tw">網頁設計</a> by BLC </section>
		
	</div>
</footer>