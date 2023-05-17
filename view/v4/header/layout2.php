<header class="headerStyle02">
  <div class="header_inner">
    <div class="logo"><a href="index.php"><img src="images_v4/logo.png" alt=""></a></div>
    <div class="menu_blk">
	  <?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
		<a class="btn_register" href="membercenter_<?php echo $this->data['ml_key']?>.php">會員中心</a>
	  <?php else:?>
		<a class="btn_singIn" href="guestlogin_<?php echo $this->data['ml_key']?>.php">登入</a>
		<a class="btn_register" href="guestregister_<?php echo $this->data['ml_key']?>.php">會員註冊</a>
	  <?php endif?>

      <div class="btn-list">
        <button class="mobile-menu-btn slide-menu-control" data-target="mb_slideMenu" data-action="toggle"><span></span></button>
      </div>
    </div><!-- .menu_blk -->
    <div class="fullMenu">
      <div class="fullMenu_inner">
        <div class="fullMenu_nav">
          <ul l="layer" ls="webmenu:top">
            <li l="list"><a attr2="">{/name/}</a></li>
            <li><a href="about.php">關於我們</a></li>
            <li><a href="products.php">商品介紹</a></li>
            <li><a href="album.php">活動花絮</a></li>
            <li><a href="download.php">下載專區</a></li>
            <li><a href="news.php">最新消息</a></li>
            <li><a href="faq.php">問與答</a></li>
          </ul>
        </div>
        <!-- .fullMenu_nav -->

        <!-- 若超過2行再用這邊的 -->
        <!-- <div class="fullMenu_nav fullMenu_nav_2c">
          <ul>
            <li><a href="about.php">關於我們</a></li>
            <li><a href="products.php">商品介紹</a></li>
            <li><a href="album.php">活動花絮</a></li>
            <li><a href="download.php">下載專區</a></li>
            <li><a href="news.php">最新消息</a></li>
            <li><a href="faq.php">問與答</a></li>
          </ul>
          <ul>
            <li><a href="about.php">關於我們</a></li>
            <li><a href="products.php">商品介紹</a></li>
            <li><a href="album.php">活動花絮</a></li>
            <li><a href="download.php">下載專區</a></li>
            <li><a href="news.php">最新消息</a></li>
            <li><a href="faq.php">問與答</a></li>
          </ul>
        </div> -->
        <!-- .fullMenu_nav_2c -->

      </div><!-- .fullMenu_inner -->
    </div><!-- .fullMenu -->
  </div><!-- .header_inner -->
</header>
