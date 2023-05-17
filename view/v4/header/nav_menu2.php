<?php //.navMenuStyle_line選單左右線條，.navMenuStyle_circle 圓角選單，.navIconLt選單icon在左方，.navIconTop選單icon在上方，.navIconHover選單icon Hover效果?>
<?php //.hoverEffect_01選單特效-底線由下至上浮出，.hoverEffect_02選單特效-底線由中間展開，.hoverEffect_03選單特效-底線由左邊展開?>
<ul class="navMenu navMenu2 navMenuStyle_line navIconLt hoverEffect_01">

	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<li id="navlight_webmenu_<?php echo $v['id']?>" class=" <?php if(isset($v['child']) and !empty($v['child']) and $v['has_child'] === true):?>moreMenu<?php endif?> <?php if(isset($v['class'])):?><?php echo $v['class'] //留給商品用的，可以加上multiMenu?><?php endif?>" >
				<a href="<?php echo $v['url']?>"
					<?php if(isset($v['target']) and $v['target'] != ''):?> target="<?php echo $v['target']?>" <?php endif?> 
					<?php if(isset($v['anchor_class']) and $v['anchor_class'] != ''):?> class="<?php echo $v['anchor_class']?>" <?php endif?> 
					<?php if(isset($v['anchor_data_target']) and $v['anchor_data_target'] != ''):?> data-target="<?php echo $v['anchor_data_target']?>" <?php endif?> 
				>
					<span class="subWord"><?php echo strtoupper($v['other1'])?></span>
					<span><?php echo $v['name']?></span>
				</a>

				<?php if(isset($v['child']) and !empty($v['child']) and $v['has_child'] === true):?>
					<ul>
					<?php foreach($v['child'] as $kk => $vv):?>
						<li class=" <?php if(isset($vv['child']) and !empty($vv['child'])):?>moreMenu<?php endif?>  <?php if(isset($vv['class'])):?><?php echo $vv['class'] //留給商品用的，可以加上moreMenu?><?php endif?> ">
							<a href="<?php echo $vv['url']?>" 
								<?php if(isset($vv['target']) and $vv['target'] != ''):?> target="<?php echo $vv['target']?>" <?php endif?>
								<?php if(isset($vv['anchor_class']) and $vv['anchor_class'] != ''):?> class="<?php echo $vv['anchor_class']?>" <?php endif?> 
								<?php if(isset($vv['anchor_data_target']) and $vv['anchor_data_target'] != ''):?> data-target="<?php echo $vv['anchor_data_target']?>" <?php endif?> 
							>
								<span
								>
									<?php echo $vv['name']?>
								</span>
							</a>
							<?php if(isset($vv['child']) and !empty($vv['child'])):?>
								<ul>
								<?php foreach($vv['child'] as $kkk => $vvv):?>
									<li>
										<a href="<?php echo $vvv['url']?>" 
											<?php if(isset($vvv['target']) and $vvv['target'] != ''):?> target="<?php echo $vvv['target']?>" <?php endif?> 
											<?php if(isset($vvv['anchor_class']) and $vvv['anchor_class'] != ''):?> class="<?php echo $vvv['anchor_class']?>" <?php endif?> 
											<?php if(isset($vvv['anchor_data_target']) and $vvv['anchor_data_target'] != ''):?> data-target="<?php echo $vvv['anchor_data_target']?>" <?php endif?> 
										>
											<span
											>
												<?php echo $vvv['name']?>
											</span>
										</a>
									</li>
								<?php endforeach?>
								</ul>
							<?php endif?>
						</li>
					<?php endforeach?>
					</ul>
				<?php endif?>
			</li>
		<?php endforeach?>
	<?php endif?>

<?php if(0):?>
  <li class="moreMenu">
    <a href="about.php?type=1">
      <span class="subWord"><i class="fa fa-user-circle-o" aria-hidden="true"></i>ABOUT US</span>
      <span><i class="fa fa-user-circle-o" aria-hidden="true"></i>關於我們</span>
    </a>
    <ul>
      <li class="moreMenu"><a href="#"><span>分類1</span></a>
        <ul>
          <li><a href="#"><span>分類1-1</span></a></li>
          <li><a href="#"><span>分類1-2</span></a></li>
          <li><a href="#"><span>分類1-3</span></a></li>
        </ul>
      </li>
      <li><a href="about.php?type=1"><span>編排頁1</span></a></li>
      <li><a href="about.php?type=2"><span>編排頁2</span></a></li>
      <li><a href="about.php?type=3"><span>編排頁3</span></a></li>
    </ul>
  </li>
  <li class="moreMenu multiMenu">
    <a href="products.php?type=1">
      <span class="subWord"><i class="fa fa-cubes" aria-hidden="true"></i>PRODUCTS</span>
      <span><i class="fa fa-cubes" aria-hidden="true"></i>商品介紹</span>
    </a>
    <div class="inner">
      <div class="navTitle">
        <span>商品介紹</span>
        <small>PRODUCTS</small>
      </div>
      <div class="inner_menu">
        <div class="row">
          <div class="col-lg-4">
            <a href="#">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-1</p>
            </a>
          </div>
          <div class="col-lg-4">
            <a href="#">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-2</p>
            </a>
          </div>
          <div class="col-lg-4">
            <a href="#">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-3</p>
            </a>
          </div>
          <div class="col-lg-4">
            <a href="#">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-4</p>
            </a>
          </div>
          <div class="col-lg-4">
            <a href="#">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-5</p>
            </a>
          </div>
          <div class="col-lg-4">
            <a href="#">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-6</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </li>
  <li class="moreMenu">
    <a href="album.php">
      <span class="subWord"><i class="fa fa-clone" aria-hidden="true"></i>ACTIVITY</span>
      <span><i class="fa fa-clone" aria-hidden="true"></i>活動花絮</span>
    </a>
    <ul>
      <li class="moreMenu"><a href="album.php"><span>分類1</span></a>
        <ul>
          <li><a href="#"><span>分類1-1</span></a></li>
          <li><a href="#"><span>分類1-2</span></a></li>
          <li><a href="#"><span>分類1-3</span></a></li>
        </ul>
      </li>
      <li><a href="album.php"><span>分類2</span></a></li>
    </ul>
  </li>
  <li class="moreMenu">
    <a href="news.php?type=1">
      <span class="subWord"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>NEWS</span>
      <span><i class="fa fa-pencil-square-o" aria-hidden="true"></i>最新消息</span>
    </a>
    <ul>
      <li><a href="news.php?type=1"><span>文字列表</span></a></li>
      <li><a href="news.php?type=2"><span>圖文列表</span></a></li>
      <li><a href="news.php?type=3"><span>名片式</span></a></li>
      <li><a href="news.php?type=4"><span>日期在圖上</span></a></li>
      <li><a href="news.php?type=5"><span>圖片線框</span></a></li>
      <li><a href="news.php?type=6"><span>多標題內容</span></a></li>
    </ul>
  </li>
  <!-- <li><a href="download.php"><span><i class="fa fa-download" aria-hidden="true"></i>下載專區</span></a></li> -->
  <li class="moreMenu">
    <a href="download.php?type=1">
      <span class="subWord"><i class="fa fa-download" aria-hidden="true"></i>DOWNLOAD</span>
      <span><i class="fa fa-download" aria-hidden="true"></i>下載專區</span>
    </a>
    <ul>
      <li><a href="download.php?type=1"><span>樣式一</span></a></li>
      <li><a href="download.php?type=2"><span>樣式二</span></a></li>
    </ul>
  </li>
  <li>
    <a href="video.php">
      <span class="subWord"><i class="fa fa-video-camera" aria-hidden="true"></i>VIDEO</span>
      <span><i class="fa fa-video-camera" aria-hidden="true"></i>影音專區</span>
    </a>
  </li>
  <li>
    <a href="faq.php">
      <span class="subWord"><i class="fa fa-question-circle-o" aria-hidden="true"></i>Q&A</span>
      <span><i class="fa fa-question-circle-o" aria-hidden="true"></i>問與答</span>
    </a>
  </li>
  <li class="moreMenu">
    <a href="location.php">
      <span class="subWord"><i class="fa fa-map-marker" aria-hidden="true"></i>LOCATION</span>
      <span><i class="fa fa-map-marker" aria-hidden="true"></i>服務據點</span>
    </a>
    <ul>
      <li class="moreMenu"><a href="location.php"><span>分類1</span></a>
        <ul>
          <li><a href="location.php"><span>分類1-1</span></a></li>
          <li><a href="location.php"><span>分類1-2</span></a></li>
          <li><a href="location.php"><span>分類1-3</span></a></li>
        </ul>
      </li>
      <li><a href="location.php"><span>分類2</span></a></li>
    </ul>
  </li>
  <li>
    <a href="contact.php">
      <span class="subWord"><i class="fa fa-comments" aria-hidden="true"></i>CONTACT</span>
      <span><i class="fa fa-comments" aria-hidden="true"></i>聯絡我們</span>
    </a>
  </li>
  <!-- <li class="moreMenu">
    <a href="contact.php">
      <span class="subWord"><i class="fa fa-comments" aria-hidden="true"></i>CONTACT</span>
      <span><i class="fa fa-comments" aria-hidden="true"></i>聯絡我們</span>
    </a>
    <ul>
      <li><a href="contact.php"><span>分類1</span></a></li>
      <li class="moreMenu"><a href="contact.php"><span>分類1</span></a>
        <ul>
          <li><a href="#"><span>分類1-1</span></a></li>
          <li><a href="#"><span>分類1-2</span></a></li>
          <li><a href="#"><span>分類1-3</span></a></li>
        </ul>
      </li>
      <li class="moreMenu"><a href="contact.php"><span>分類2</span></a>
        <ul>
          <li><a href="#"><span>分類2-1</span></a></li>
          <li><a href="#"><span>分類2-2</span></a></li>
          <li><a href="#"><span>分類2-3</span></a></li>
        </ul>
      </li>
    </ul>
  </li> -->
	<?php endif?>

</ul>
