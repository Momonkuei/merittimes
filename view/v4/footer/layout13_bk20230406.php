<?php 
	$_v4_theme_ver = str_replace('v4_k','w',$_v4_theme_ver);
?>
<?if($this->data['router_method'] != 'photocopyform_1' && !stristr($this->data['router_method'],'class_')  && !stristr($this->data['router_method'],'classout_')){?>
<footer class="footerStyle13">

	<div class="ftMenu_list_area">
		<div class="container">
<?php echo $__?>
		<?php if(0):?>
			<ul class="ftMenu_list">
				<li><a href="about_tw_1.php">公司簡介</a></li>
				<li><a href="news_tw.php?id=17">最新消息</a></li>
				<li><a href="product_tw.php?id=78">產品介紹</a></li>
				<li><a href="shop_tw.php">購物產品</a></li>
				<li><a href="photo_tw.php">活動花絮</a></li>
				<li><a href="video_tw.php">影音專區</a></li>
				<li><a href="download_tw.php?id=77">檔案下載</a></li>
				<li><a href="contact/gabfd8c53527ce51b.html">聯絡我們</a></li>
			</ul>
		<?php endif?>
		</div>
	</div>

	<div class="container">
		<div class="ft_info">
			<div>
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				<a href="https://goo.gl/maps/xZDWaJLywxXw768WA" target="_blank">11087 台北市信義區松隆路327號五樓</a>
			</div>


			<div>
				<i class="fa fa-phone" aria-hidden="true"></i>
				<a href="tel:+886-4-23178388">+886-4-2317-8388</a>
			</div>

			<div>
				<i class="fa fa-fax" aria-hidden="true"></i>
				<a>+886-4-2317-8388</a>
			</div>
		</div>

		<div class="ft_social">
			<ul>
			    <li>
					<a href="javascript:;" target="_blank">
						<i class="fa fa-facebook" aria-hidden="true"></i>
					</a>
				</li>
				<li>
					<a href="javascript:;" target="_blank">
						<span class="icon-icon_line"></span>
					</a>
				</li>

				<li>
					<a href="javascript:;" target="_blank">
						<span class="icon-icon_youtube"></span>
					</a>
				</li>
			    
			</ul>
		</div>

		<div class="ft_copyright">
			<span>Copyright © 2023 讀報教育  All Rights Reserved.網頁設計 by BLC</span>
			<span>Designed by BLC</span>
		</div>
	</div>

</footer>
<?}else if(stristr($this->data['router_method'],'class_') || stristr($this->data['router_method'],'classout_')){?>
	<footer class="footerStyle03">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="ftMenu_vList tfnav">
						<ul class="ftMenu_list">
							<li><a href="classout_tw_1.php">班級首頁</a></li>
							<li><a href="classout_tw_2.php">公布欄</a></li>
							<li><a href="classout_tw_3.php">相片成果</a></li>
							<li><a href="classout_tw_4.php">影音成果</a></li>
						</ul>
					</div>
					<div class="ftMenu_vList bfnav"></div>
					<div class="ft_social">
						<ul>
							<li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<li><a href=""><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
							<li><a href="images_v4/wechat_qrcode.jpg" data-fancybox=""><i class="fa fa-weixin" aria-hidden="true"></i></a></li>
						</ul>
						</div>
							</div>
							<div class="col-12 col-lg-4">
								<div id="ft_hide" class="ft_logo"><img src="images_v4/default.png" alt=""></div>
								<div class="ft_info">
						<ul>
							<li class="big_phone"><a href="tel:0423178388"><i class="fa fa-phone" aria-hidden="true"></i><span>04-2317-8388</span></a></li>
							<li><i class="fa fa-fax" aria-hidden="true"></i>04-2317-8388</li>
							<li><a href="mailto:service@buyersline.com.tw"><i class="fa fa-envelope-o" aria-hidden="true"></i>service@buyersline.com.tw</a></li>
							<li><a href="https://goo.gl/maps/V3AaPziYQ442" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i>40677 台中市文心路三段155-1號3F</a></li>
							<li class="ftInfo_addr"><span>40677 台中市文心路三段155-1號3F</span><a href="https://goo.gl/maps/V3AaPziYQ442" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i>MAP</a></li>
						</ul>
					</div><!-- .ft_info -->
				</div>
			</div>
			<div class="copyRight_content">
				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="copyRight">Copyright © <?=date('Y')?> BuyersLine All Rights Reserved.
							<span>
								<a href="https://www.buyersline.com.tw" class="copyrightTxt Designed" title="網頁設計" target="_blank">
									<img alt="網頁設計" title="網頁設計" src="images_v4/default.png">網頁設計
								</a>
								<span class="copyrightTxt byBLC">
									<img alt="BuyersLine Company" title="BuyersLine Company" src="images_v4/default.png">
									by BLC
								</span>
							</span>
						</div><!-- .copyRight -->
					</div>
					<div id="ft_hide" class="col-12 col-lg-6">
						<strong>百邇來網頁設計公司</strong>
					</div>
				</div>
			</div><!-- .copyRight_wrap -->
		</div><!-- .container -->
	</footer>
<?}?>	