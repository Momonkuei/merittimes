<div class="cowboy_mbPanel_2" style="display: block !important;">
	<div class="cmpTop">
		<div>
			<a href="javascript:;">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
			</a>
		</div>
		<div>
			<a href="/">
				<img src="images_v4/logo.png">
			</a>
		</div>
		<div>
			<a class="cmpBtn" href="javascript:void(0)">
				<div></div>
			</a>
		</div>
	</div>

	<div class="cmpContent">
		<div class="cmpLang">
			<a href="javascript:;">English</a>
			<a href="javascript:;">繁體中文</a>
			<a href="javascript:;">日本語</a>
		</div>

		<div class="cmpMenu">
			<p>MENU</p>

			<ul class="cmpNav">
				<li>
					<a href="javascript:;">第一層</a>
					<ul class="submenu">
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
					<ul class="submenu">
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
					<ul class="submenu">
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
					<ul class="submenu">
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
						<li>
							<a href="javascript:;">第二層</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
				</li>
				<li>
					<a href="javascript:;">第一層</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="cmpFooter">
		<p>Email：<a href="mailto:service@buyersline.com">service@buyersline.com</a></p>
		<p>Tel：<a href="tel:+886-4-23178388">+886-4-2317-8388</a></p>
		<p><a href="https://goo.gl/maps/FWYoWASiyfcQTXo68" target="_blank">台中市西屯區寧夏路121路</a></p>
		<p>Design by BLC</p>
	</div>

	<div class="cmpBottom">
		<div>
			<a href="javascript:;">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				<p>168146846</p>
			</a>
		</div>
		<div>
			<a href="javascript:;">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				<p>some text haha</p>
			</a>
		</div>
		<div>
			<a data-fancybox data-src="#searchForm" href="product_tw.php">
				<i class="fa fa-search" aria-hidden="true"></i>
				<p>搜尋</p>
			</a>
		</div>
	</div>
</div>



<script m="body_end">
	if($('.cowboy_mbPanel_2').length){
		$('.cmpBtn').click(function(){
			$(this).toggleClass('open');
			$('body').toggleClass('noscroll');
			$('.cmpContent, .cmpFooter, .cmpBottom').toggleClass('open');
		});

		$('.cmpBottom > div').css('width', 'calc(100% / ' + $('.cmpBottom > div').length + ')');

		$(window).on('load',function(){
			$('.cmpContent').css('bottom', $('.cmpFooter').outerHeight() + 50);
			
			$('.cmpNav .submenu').parent('li').addClass('moremenu');
			$('.cmpNav .submenu').siblings('a').removeAttr('href').attr('href', 'javascript:;');

			$('.cmpNav .submenu').hide();
			$('.cmpNav a.active').parents('.submenu').siblings('a').addClass('active');
			$('.cmpNav a.active').addClass('open');
			$('.cmpNav a.active').siblings('.submenu').addClass('open').show();
		});

		$('.cmpNav a').click(function(){
			$(this).toggleClass('open');
			$(this).siblings('.submenu').slideToggle(200);
			$(this).siblings('.submenu').toggleClass('open');
		});
	}
</script>