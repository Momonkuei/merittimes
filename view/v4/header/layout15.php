<header class="headerStyle03">

  <div class="navBar">
    <div class="container_full">
      <div class="navBarContent">
        <div>
          <div class="logo"><a href="index.php"><img src="images_tomiworks/headerLogo.svg" alt=""></a></div>
        </div>
        <div>
          <?php //include('view/v4/header/nav_menu3.php'); ?>
<?php echo $__?>
        </div>
        <div>
          <ul class="subNavMenu">
            <li class="hide">
              <a href="contact_tw.php">
                <div class="inner">
                <i class="fa fa-envelope" aria-hidden="true"></i><span>聯絡我們</span>
                </div>
              </a>
            </li>
            <li>
              <a href="" data-fancybox data-src="#searchForm">
              <div class="inner">
                  <i class="fa fa-search" aria-hidden="true"></i><span>搜尋</span>
                </div>
              </a>
            </li>
            <li class="hide">
              <a href="#">
                <div class="inner">
                  <i class="fa fa-globe" aria-hidden="true"></i><span style="font-size: 14px;">Languages</span>
                </div>
              </a>
              <ul class="lanMenu">
                <li>
                  <a href="index_tw.php">繁體中文</a>
                </li>
                <li>
                  <a href="index_tw.php">ENGLISH</a>
                </li>
                 </ul>
            </li>
          </ul>
        </div>
      </div><!-- .navBarContent -->
    </div><!-- .container -->
  </div><!-- .navBar -->
  <div class="fullMenu">
    <div class="fullMenu_inner">
      <div class="fullMenu_title">MENU</div>
      <div class="fullMenu_nav container">
        <div class="row fullMenuNav_list">
          <div class="col-md-6">
            <ul l="layer" ls="webmenu:mobile">
			  <li l="list"><a attr2="">{/name/}</a></li>

              <li><a href="about.php">關於我們</a></li>
              <li><a href="products.php">商品介紹</a></li>
              <li><a href="album.php">活動花絮</a></li>
              <li><a href="download.php">下載專區</a></li>
              <li><a href="news.php">最新消息</a></li>
              <li><a href="faq.php">問與答</a></li>
            </ul>
          </div>
          <div class="col-md-6">
<?php if(0):?>
			<ul>
              <li><a href="about.php">關於我們</a></li>
              <li><a href="products.php">商品介紹</a></li>
              <li><a href="album.php">活動花絮</a></li>
              <li><a href="download.php">下載專區</a></li>
              <li><a href="news.php">最新消息</a></li>
              <li><a href="faq.php">問與答</a></li>
			</ul>
<?php endif?>
          </div>
        </div>
        <div class="fullMenu_social">
          <ul>
            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>

</header>
