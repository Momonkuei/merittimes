<?php
$_v4_theme_ver = str_replace('v4_k', 'w', $_v4_theme_ver);
?>
<? if ($this->data['router_method'] != 'photocopyform_1' && !stristr($this->data['router_method'], 'class_')  && !stristr($this->data['router_method'], 'classout_')) { ?>
	<footer class="footerStyle13 ">

		<div class="ftMenu_list_area">
			<div class="container">
				<?php echo $__?>
				<?php if (0) : ?>
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
				<?php endif ?>
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
					<a href="tel:+886-2-87877828">02-8787-7828</a>
				</div>

				<div>
					<i class="fa fa-fax" aria-hidden="true"></i>
					<a>02-8787-1820</a>
				</div>
			</div>

			<div class="ft_social">
				<ul>
					<li>
						<a href="https://www.facebook.com/merit.times.327" target="_blank">
							<i class="fa fa-facebook" aria-hidden="true"></i>
						</a>
					</li>
					<li>
						<a href="https://timeline.line.me/user/_dfPnGFGvkoV4sYv5efFZNtFZU06ZFKZVKbRIU1E" target="_blank">
							<span class="icon-icon_line"></span>
						</a>
					</li>

					<li>
						<a href="https://www.youtube.com/watch?v=Ha0LSe7zQN8&list=PL9y6-iHwS1nUK3CFCCJz99kD-UJlYGrSR&ab_channel=%E4%BA%BA%E9%96%93%E7%A6%8F%E5%A0%B1TheMeritTimes" target="_blank">
							<span class="icon-icon_youtube"></span>
						</a>
					</li>

				</ul>
			</div>

			<div class="ft_copyright">
				<span>Copyright © 2023 人間福報 All Rights Reserved.</span>
				<span><a class="ft_copyright-link" href="https://www.buyersline.com.tw/" target="_blank">網頁設計</a> by BLC</span>
			</div>
		</div>

	</footer>
<? } else if (stristr($this->data['router_method'], 'class_') || stristr($this->data['router_method'], 'classout_')) { ?>
	<div class="footer-top">
		<div class="footer-top-bg"></div>
		<div class="footerImg footerImg-01">
			<img src="images_v4/classWeb/footer/footerImg_01.png" alt="">
		</div>

		<div class="footerImg footerImg-02">
			<img src="images_v4/classWeb/footer/footerImg_02.png" alt="">
		</div>

		<div class="footerImg footerImg-03 waves-2">
			<img src="images_v4/classWeb/footer/footerImg_03.png" alt="">
		</div>

		<div class="footerImg footerImg-04 waves-2">
			<img src="images_v4/classWeb/footer/footerImg_04.png" alt="">
		</div>

		<div class="footerImg footerImg-05">
			<img src="images_v4/classWeb/footer/footerImg_05.png" alt="">
		</div>

		<div class="footerImg footerImg-06">
			<img src="images_v4/classWeb/footer/footerImg_06.png" alt="">
		</div>
	</div>
	<footer class="footerStyle03 footerStyle-classWeb">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="ftMenu_vList tfnav">
						<ul class="ftMenu_list">
							<li><a href="classout_tw_1.php">班級首頁</a></li>
							<li><a href="classout_tw_2.php">公佈欄</a></li>
							<li><a href="classout_tw_3.php">相片成果</a></li>
							<li><a href="classout_tw_4.php">影音成果</a></li>
						</ul>
					</div>
					<div class="ftMenu_vList bfnav"></div>
					<div class="ft_social">
						<!-- <ul>
							<li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<li><a href=""><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
							<li><a href="images_v4/wechat_qrcode.jpg" data-fancybox=""><i class="fa fa-weixin" aria-hidden="true"></i></a></li>
						</ul> -->
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div id="ft_hide" class="ft_logo">
						<a href="index.php">
							<img src="images_v4/classWeb/footer/footerLogo.png" alt="">
						</a>
					</div>
					<div class="ft_info">
						<?if(stristr($this->data['router_method'],'classout_')){?>
							<ul>
								<li>
									<a class='ft_info-label'>
										學校：<span class='ft_info-schoolName'><?=$class_data['school_name']?></span>
									</a>
								</li>
								<li>
									<a class='ft_info-label'>
										班級：<span><?=$class_data['class_name']?></span>
									</a>
								</li>

							</ul>
						<?}else{?>
							<ul>
								<li>
									<a class='ft_info-label'>
										學校：<span class='ft_info-schoolName'><?=$_SESSION['member_data']['school_name']?></span>
									</a>
								</li>
								<li>
									<a class='ft_info-label'>
										班級：<span><?=$_SESSION['member_data']['class_name']?></span>
									</a>
								</li>

							</ul>
						<?}?> 
					</div>
					<!-- .ft_info -->
				</div>
			</div>
			<div class="copyRight_content">
				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="copyRight">Copyright © <?= date('Y') ?> BuyersLine All Rights Reserved.
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
						<!-- <strong>百邇來網頁設計公司</strong> -->
					</div>
				</div>
			</div><!-- .copyRight_wrap -->
		</div><!-- .container -->
	</footer>
<? } ?>