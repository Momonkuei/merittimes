

	<?
		$mbPanelMode='default';
		// $mbPanelMode='autoData';
		// $mbPanelMode='auto';//指定mbPanel位置，自動產生panel 、 data
		// $mbPanelMode='born';//全自動產生
	?>

	<? if($mbPanelMode=='default'): /* 靜態 */ ?>
		<div id="mbPanel" data-mbPanel="mbPanel_effect01" data-mbPanelMode="default">

			<div class="mbPanel_funNav navTop">
				<div class="mbPanel_content">

					<!-- <a href="" class="showPanel" data-target="#mbPanel_userPanel"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>(10)</span></a> -->
					<a href=""><i class="fa fa-info-circle" aria-hidden="true"></i></a>
					<a href="index.php"><img src="images_v4/logo.png" alt=""></a>
					<a href="" class="showPanel" data-target="#mbPanel_navMenu">
						<!-- <i class="fa fa-bars" aria-hidden="true"></i> -->
						<div class="btn-list">
			        <button class="mobile-menu-btn slide-menu-control" data-target="mb_slideMenu" data-action="toggle"><span></span></button>
			      </div>
					</a>

				</div>
			</div>
			<div class="mbPanel_funNav navBottom">
				<div class="mbPanel_content">
					<a href=""><i class="fa fa-info-circle" aria-hidden="true"></i><span>詢問車</span></a>
					<a href=""><i class="fa fa-envelope" aria-hidden="true"></i><span>聯絡我們</span></a>
					<a href=""><i class="fa fa-search" aria-hidden="true"></i><span>搜尋</span></a>
					<a href="" class="showPanel" data-target="#mbPanel_NavSubMenu"><i class="fa fa-globe" aria-hidden="true"></i><span>Language</span></a>
				</div>
			</div>

			<div class="mbPanel_side mbPanel_left" id="mbPanel_navMenu">
				<div class="mbPanel_content">
					<ul class="panelMenu">
						<li class=""><a href="#_" class="closePanel mainCloseBtn" data-target="#mbPanel_navMenu">Menu</a></li>
						<li class="">
							<a href="#_" class="moreMenu">link item 1</a>
							<ul class="subMenu ">
								<li class=""><a href="#_">link item 1-1</a></li>
								<li class=""><a href="#_">link item 1-2</a>
									<ul class="subMenu">
										<li class=""><a href="#_">link item 1-2-1</a></li>
										<li class=""><a href="#_">link item 1-2-2</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li class=""><a href="">link item 2</a></li>
						<li class=""><a href="">link item 2</a></li>
						<li class=""><a href="">link item 2</a></li>
						<li class=""><a href="">link item 2</a></li>
						<li class=""><a href="">link item 2</a></li>
						<li class=""><a href="">link item 2</a></li>
						<li class=""><a href="">link item 2</a></li>
						<li class=""><a href="">link item 2</a></li>
					</ul>
				</div>
			</div>

			<div class="mbPanel_side mbPanel_left" id="mbPanel_NavSubMenu">
				<div class="mbPanel_content">
					<ul class="panelMenu">
						<li class=""><a href="#_" class="closePanel mainCloseBtn" data-target="#mbPanel_navMenu">Language</a></li>
						<li class=""><a href="change_language.php?lang=tw">繁體中文</a></li>
						<li class=""><a href="change_language.php?lang=en">English</a></li>
					</ul>
				</div>
			</div>

			<div class="mbPanel_side mbPanel_left" id="mbPanel_userPanel">
				<div class="mbPanel_content">
					<ul class="panelMenu styleGrid" data-stylegrid="2x3" id="panelMenu02">
              <li><a href="#link1" class="moreMenu">submenu2</a>
                  <ul class="subMenu">
                      <li><a href="#link1-1">link1-1</a></li>
                      <li><a href="#link1-2">link1-2</a></li>
                      <li><a href="#link1-3">link1-3</a></li>
                      <li><a href="#link1-4" class="closePanel">closePanel</a></li>
                  </ul>
              </li>
              <li><a href="#link2" class="showPanel" data-target="#mbPanel_navMenu">openPanel</a></li>
              <li><a href="#link3" class="closePanel" data-target="#mbPanel_userPanel">closePanel</a></li>
              <li><a href="#link4">link4</a></li>
              <li><a href="#link5">link5</a></li>
              <li><a href="#link6">link6</a></li>
          </ul>
				</div>
			</div>
		</div>

		<!-- <div>
			網頁內容
		</div> -->

	<? endif;?>


	<? if($mbPanelMode=='autoData'): /* 動態js資料生成 ， js需指定資料來源 */ ?>
		<div id="mbPanel" data-mbPanel='mbPanel_effect01' data-mbPanelMode='autoData'>

			<div class="mbPanel_funNav navTop">
				<div class="mbPanel_content"> </div>
			</div>

			<div class="mbPanel_funNav navBottom">
				<div class="mbPanel_content"> </div>
			</div>

			<div class="mbPanel_side mbPanel_left" id="mbPanel_navMenu">
				<div class="mbPanel_content">
					<ul class="panelMenu"></ul>
				</div>
			</div>

			<div class="mbPanel_side mbPanel_left" id="mbPanel_userPanel">
				<div class="mbPanel_content">
					<ul class="panelMenu styleGrid" data-styleGrid="2x3"></ul>
				</div>
			</div>

			<div class="mbPanel_page">
				<div class="mbPanel_content">

					<div>
						<?for ($i=1;$i<=100;$i++){ echo $i;?>動態js資料生成<br><?}?>
					</div>

				</div>
			</div>

		</div>
	<? endif;?>


	<? if($mbPanelMode=='auto'): /* 動態 創建 panle & 動態js資料生成 */ ?>
		<section>
			<heaer>header</heaer>
			<div id="mbPanel">
				<section>
					<?for ($i=1;$i<=100;$i++){ echo $i;?>自動建立panle&datas<br><?}?>
				</section>
			</div>
		</section>
	<? endif;?>




	<? if($mbPanelMode=='born'): /* 動態 創建 panle & 動態js資料生成 */ ?>

			<heaer>header</heaer>
			<section>
				<?for ($i=1;$i<=100;$i++){ echo $i;?>自動建立panle&datas<br><?}?>
			</section>

	<? endif;?>
