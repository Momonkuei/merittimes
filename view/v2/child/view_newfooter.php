<footer>

	<div class="footerContent">
		<section class="footerType2">
			<div>
				<section>
					<div class="footerLogo"><img src="<?php echo L::imgt('images/logo.png','.png')?>"></div>					
				</section>
			</div>
		</section>
		<section class="footerType1">
			<div>
				<section>
					<ul class="siteMap type2">
						<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
							<?foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
								<li><a href="<?php echo $v['url1']?>"><?php echo L::top(null,$v['topic'])?></a></li>
							<?php endforeach?>
						<?php endif?>
					</ul>
				</section>
			</div>
			<div>
				<section>
					<ul class="companyInfo">
					<?php if($this->data['ml_key']=='tw')://這是中文?>
						<li><i class="fa fa-map-marker"></i><a href="https://goo.gl/maps/V3AaPziYQ442" target="_blank">台中市文心路三段155-1號3F</a></li>
						<li><i class="fa fa-phone"></i> 04-2317-8388</li>
						<li><i class="fa fa-envelope"></i><a href="mailto:service@buyersline.com.tw">service@buyersline.com.tw</a></li>
					<?php else://這是英文?>
						<li><i class="fa fa-map-marker"></i><a href="https://goo.gl/maps/V3AaPziYQ442" target="_blank">台中市文心路三段155-1號3F</a></li>
						<li><i class="fa fa-phone"></i> 04-2317-8388</li>
						<li><i class="fa fa-envelope"></i><a href="mailto:service@buyersline.com.tw">service@buyersline.com.tw</a></li>
					<?php endif?>
					</ul>
				</section>
			</div>
		</section>
	</div>


	<div class="footerContent copyright">
		<section class="footerType1">
			<div>
				<section class="copyRightTxt">
						<?php if(isset($this->data['sys_configs']['footer_'.$this->data['ml_key']]) and trim($this->data['sys_configs']['footer_'.$this->data['ml_key']]) != ''):?>
						<?php echo $this->data['sys_configs']['footer_'.$this->data['ml_key']]?>
					<?php else:?>
						Copyright © 2016 <?php echo  G::t(null,$this->data['sys_configs']['admin_title'])?>  All Rights Reserved. <a href="http://www.buyersline.com.tw">網頁設計</a> by BLC 
					<?php endif?>
				</section>
			</div>
			<div>
				<section class="social">
						<a href="https://www.instagram.com/buyersline/" target="_blank">
							<i class="fa fa-instagram" aria-hidden="true"></i>
						</a>
						<a href="https://www.facebook.com/buyersline/" target="_blank">
							<i class="fa fa-facebook-official" aria-hidden="true"></i>
						</a>
						<a href="https://www.youtube.com/user/buyerslinevideo" target="_blank">
							<i class="fa fa-youtube" aria-hidden="true"></i>
						</a>
				</section>
			</div>
		</section>
	</div>


<?php /* //舊的
	<div class="footerContent copyright">

		<section class="copyRightTxt">
			<?php if(isset($this->data['sys_configs']['footer_'.$this->data['ml_key']]) and trim($this->data['sys_configs']['footer_'.$this->data['ml_key']]) != ''):?>
				<?php echo $this->data['sys_configs']['footer_'.$this->data['ml_key']]?>
			<?php else:?>
				Copyright © 2016 <?php echo  G::t(null,$this->data['sys_configs']['admin_title'])?>  All Rights Reserved. <a href="http://www.buyersline.com.tw">網頁設計</a> by BLC 
		<?php endif?>			
		</section>		
	</div>
*/?>
</footer>
