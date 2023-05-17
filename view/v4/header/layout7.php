<header class="headerStyle07">
  <div class="header_top">
    <div class="headerTopContent">
      <div>
        <a class="logo" href="index.php"><img src="images_v4/logo.png" alt=""></a>
      </div>
      <div>
        <?php //$headerWidget='topLink_type2'; include 'topLink.php'; ?>
<?php echo $__?>
      </div>
    </div>
  </div><!-- .header_top -->

  <div class="slogn"><img src="images_v4/slogn_mb.png" alt=""></div>

  <div class="scrollDown"><a href="#scroll"><img src="images_v4/icon/header_scrollDown.png" alt=""><span>Scroll down</span></a></div>

<?php echo $__?>
<?php if(0):?>
  <!-- 07banner -->
  <div class="swiper-container bnr_head">
    <div class="swiper-wrapper">
      <!-- <div class="swiper-slide"><iframe class="video" src="https://www.youtube.com/embed/YE7VzlLtp-4?ecver=2&enablejsapi=1"></iframe></div> -->
      <!-- <div class="swiper-slide">
        <div id="bgVideo" class="bgVideo"></div>
      </div> -->
      <div class="swiper-slide" style="background-image: url('images_v4/banner/headerBanner_01.jpg')"></div>
      <div class="swiper-slide" style="background-image: url('images_v4/banner/headerBanner_02.jpg')"></div>
      <div class="swiper-slide" style="background-image: url('images_v4/banner/headerBanner_03.jpg')"></div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
  </div><!-- .swiper-container .bnr_head -->
<?php endif?>

  <div class="navBar">
    <div class="navMenuContent">
      <?php //include('nav_menu4.php'); ?>
<?php echo $__?>
    </div>
  </div><!-- .navBar -->
  <div class="btn-list">
    <button class="mobile-menu-btn slide-menu-control" data-target="mb_slideMenu" data-action="toggle"><span></span></button>
  </div><!-- .btn-list -->
  <div class="fullMenu">
    <div class="fullMenu_inner">
<?php echo $__?>

<?php if(0):?>
      <div class="fullMenu_nav">
        <div class="fullMenuNav_list">
          <ul>
            <li class="moreMenu">
              <a href="about.php">關於我們</a>
              <ul>
              <li><a href=""><span>公司簡介</span></a></li>
            </ul>
            </li>
            <li><a href="products.php">商品介紹</a></li>
            <li class="moreMenu"><a href="album.php">活動花絮</a>
            <ul>
              <li><a href=""><span>相簿</span></a></li>
              <li><a href=""><span>影片</span></a></li>
            </ul></li>
            <li><a href="download.php">下載專區</a></li>
            <li><a href="news.php">最新消息</a></li>
            <li class="moreMenu">
            <a href=""><span>其他頁面</span></a>
            <ul>
              <li><a href=""><span>問與答</span></a></li>
              <li class="moreMenu">
                <a href=""><span>聯絡我們</span></a>
                <ul>
                  <li><a href=""><span>B to C</span></a></li>
                  <li><a href=""><span>B to B</span></a></li>
                  <li><a href=""><span>服務據點</span></a></li>
                </ul>
              </li>
              <li><a href=""><span>會員中心</span></a></li>
              <li><a href=""><span>空白頁</span></a></li>
              <li><a href=""><span>一般登入</span></a></li>
            </ul>
          </li>
            <li class="navMenu_icon"><a href=""><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>ONLINE STORE</span></a></li>
          </ul>
        </div><!-- .fullMenuNav_list -->
        <div class="fullMenu_social">
          <ul>
            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
          </ul>
        </div><!-- .fullMenu_social -->
      </div><!-- .fullMenu_nav -->
<?php endif?>
    </div><!-- .fullMenu_inner -->
  </div><!-- .fullMenu -->


    <!--捲動後的導覽列-->
  <section class="scrollNav">
    <div class="navBar">
      <div class="container navBarContent">

        <?php echo $__?>
        
        <?php if(0):?>
        <ul class="navMenu hoverEffect_01">
          <li class="moreMenu">
            <a href=""><span>關於我們</span></a>
            <ul>
              <li><a href=""><span>公司簡介</span></a></li>
            </ul>
          </li>
          <li><a href=""><span>商品介紹</span></a></li>
          <li class="moreMenu">
            <a href=""><span>活動花絮</span></a>
            <ul>
              <li><a href=""><span>相簿</span></a></li>
              <li><a href=""><span>影片</span></a></li>
            </ul>
          </li>
          <li><a href=""><span>下載專區</span></a></li>
          <li><a href=""><span>最新消息</span></a></li>
          <li><a href=""><span>測試測試</span></a></li>
          <li><a href=""><span>技術服務</span></a></li>
          <li class="moreMenu">
            <a href=""><span>其他頁面</span></a>
            <ul>
              <li><a href=""><span>問與答</span></a></li>
              <li class="moreMenu">
                <a href=""><span>聯絡我們</span></a>
                <ul>
                  <li><a href=""><span>B to C</span></a></li>
                  <li><a href=""><span>B to B</span></a></li>
                  <li><a href=""><span>服務據點</span></a></li>
                </ul>
              </li>
              <li><a href=""><span>會員中心</span></a></li>
              <li><a href=""><span>空白頁</span></a></li>
              <li><a href=""><span>一般登入</span></a></li>
            </ul>
          </li>
        </ul>
      <?php endif?>

      </div>
    </div>
  </section>
  <!--捲動後的導覽列 End-->

</header>
