<?php //.hoverEffect_01選單特效-底線由下至上浮出，.hoverEffect_02選單特效-底線由中間展開，.hoverEffect_03選單特效-底線由左邊展開?>
<?php //2021-12-01 移除了other7的顯示 //2022-01-04 other7 改 other9，要放icon ?>
<ul class="navMenu hoverEffect_01" l="layer" ls="lll">
	<li l="list" attr1="" ><a attr2="" ><span>{/other9/}{/name/}</span></a>
		{/child/}
	</li>
	<ul l="box">{split}</ul>
</ul>

<div class="btn-list">
  <button class="mobile-menu-btn slide-menu-control" data-target="mb_slideMenu" data-action="toggle"><span></span></button>
</div>

<?php if(0):?>
<ul class="navMenu hoverEffect_01">
  <li class="moreMenu">
    <a href="about.php?type=1">
      <span>關於我們</span>
    </a>
    <ul>
      <!-- <li class="moreMenu"><a href="#"><span>分類1</span></a>
        <ul>
          <li><a href="#"><span>分類1-1</span></a></li>
          <li><a href="#"><span>分類1-2</span></a></li>
          <li><a href="#"><span>分類1-3</span></a></li>
        </ul>
      </li> -->
      <li><a href="about.php?type=1"><span>編排頁1</span></a></li>
      <li><a href="about.php?type=2"><span>編排頁2</span></a></li>
      <li><a href="about.php?type=3"><span>編排頁3</span></a></li>
    </ul>
  </li>
  <li class="moreMenu multiMenu">
    <a href="products.php?type=1">
      <span>商品介紹</span>
    </a>
    <div class="inner">
      <div class="navTitle">
        <span>商品介紹</span>
        <small>PRODUCTS</small>
      </div>
      <div class="inner_menu">
        <div class="row">
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-1</p>
            </a>
          </div>
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-2</p>
            </a>
          </div>
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-3</p>
            </a>
          </div>
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-4</p>
            </a>
          </div>
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-5</p>
            </a>
          </div>
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-6</p>
            </a>
          </div>
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-7</p>
            </a>
          </div>
          <div class="col-lg-3">
            <a href="products.php?type=1">
              <div class="itemImg"><img src="images_v4/header/navImg.jpg" alt=""></div>
              <p>商品分類1-8</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </li>
  <li class="moreMenu">
    <a href="album.php">
      <span>活動花絮</span>
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
      <span>最新消息</span>
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
  <!-- <li><a href="download.php"><span>下載專區</span></a></li> -->
  <li class="moreMenu">
    <a href="download.php?type=1">
      <span>下載專區</span>
    </a>
    <ul>
      <li><a href="download.php?type=1"><span>樣式一</span></a></li>
      <li><a href="download.php?type=2"><span>樣式二</span></a></li>
    </ul>
  </li>
  <li><a href="video.php"><span>影音專區</span></a></li>
  <li><a href="faq.php"><span>問與答</span></a></li>
  <li class="moreMenu">
    <a href="location.php">
      <span>服務據點</span>
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
      <span>聯絡我們</span>
    </a>
  </li>
  <!-- <li class="moreMenu">
    <a href="contact.php">
      <span>聯絡我們</span>
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
  <li class="navMenu_icon"><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
</ul>

<div class="btn-list">
  <button class="mobile-menu-btn slide-menu-control" data-target="mb_slideMenu" data-action="toggle"><span></span></button>
</div>
<?php endif?>
