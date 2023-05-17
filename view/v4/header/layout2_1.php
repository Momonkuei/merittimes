<header class="headerStyle02 headerStyle02_modify-01">
  <div class="header_inner">
    <div class="logo">
      <a href="index.php">
        <img src="images_v4/logo.png" alt="">
      </a>
    </div>
    <div class="menu_blk">
      <!-- <?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
      <a class="btn_register" href="membercenter_<?php echo $this->data['ml_key']?>.php">會員中心</a>
      <?php else:?>
      <a class="btn_singIn" href="guestlogin_<?php echo $this->data['ml_key']?>.php">登入</a>
      <a class="btn_register" href="guestregister_<?php echo $this->data['ml_key']?>.php">會員註冊</a>
      <?php endif?> -->


      <!-- 新增menu -->
      <!-- 新增連結 -->
      <nav>
        <ul class="globalnav_main ">
          <li class="globalnav_col"><a href="">私たちについて</a></li>
          <li class="globalnav_col">
            <a href="">レンタル衣装</a>
            <ul class='dropdown-menu'>
              <li><a href="">成人式 振袖</a></li>
              <li><a href="">成人式 洋装</a></li>
              <li><a href="">こども着物</a></li>
              <li><a href="">お母様お父様 着物</a></li>
            </ul>   
          </li>
          <li class="globalnav_col">
            <a href="">料金</a>
            <ul class='dropdown-menu'>
              <li><a href="">料金 - 振袖</a></li>
              <li><a href="">料金 - 七五三着物</a></li>
              <li><a href="">撮影オプション</a></li>
            </ul>   
          </li>
          <li class="globalnav_col">
            <a href="">店舗</a>  
          </li>
          <li class="globalnav_col">
            <a href="">GALLERY</a>  
          </li>
          <li class="globalnav_col">
            <a href="">ご利用ガイド</a> 
            <ul class='dropdown-menu'>
              <li><a href="">よくあるご質問</a></li>
              <li><a href="">お申込みからご返却までの流れ</a></li>
              <li><a href="">ご利用上のお約束</a></li>
            </ul> 
          </li>
          
        </ul>
      </nav>

      <div class="popup-bg-cover "></div>

      <div class="btn-list">
        <button class="mobile-menu-btn slide-menu-control" data-target="mb_slideMenu" data-action="toggle">
          <span></span>
        </button>
      </div>
    </div><!-- .menu_blk -->
    <div class="fullMenu">
      <div class="fullMenu_inner">
        <!-- <div class="fullMenu_nav ">
          <ul l="layer" ls="webmenu:top">
            <li l="list"><a attr2="">{/name/}</a></li>
            <li><a href="about.php">關於我們</a></li>
            <li><a href="products.php">商品介紹</a></li>
            <li><a href="album.php">活動花絮</a></li>
            <li><a href="download.php">下載專區</a></li>
            <li><a href="news.php">最新消息</a></li>
            <li><a href="faq.php">問與答</a></li>
          </ul>
        </div> -->

        <div class="fullMenu_nav_inner">
          <!-- 選單 -->
          <div class="row">
            <ul class="globalnav_col col-12 col-md-4 col-lg-2">
              <li class="nav_number">
                <div class="num">01</div>
                <p>私たちについて</p>
              </li>
              <li class="menu_child_box">
                <ul class="dropdown menu_child">
                  <li><a href="https://kimono.studio-theday.com/about/">コンセプト</a></li>
                  <li><a href="https://kimono.studio-theday.com/about/">フォトグラファー</a></li>
                  <li><a href="https://kimono.studio-theday.com/about/">会社概要</a></li>
                </ul>
              </li>
            </ul>
            <ul class="globalnav_col col-12 col-md-4 col-lg-2">
              <li class="nav_number">
                <div class="num">02</div>
                <p>レンタル衣装</p>
              </li>
              <li class="menu_child_box">
                <ul class="menu_child">
                  <li><a href="https://kimono.studio-theday.com/furisode/">成人式 振袖</a></li>
                  <li><a href="https://kimono.studio-theday.com/yoso/">成人式 洋装</a></li>
                  <li><a href="https://kimono.studio-theday.com/kimono-child/">こども着物</a></li>
                  <li><a href="https://kimono.studio-theday.com/kimono-parent/">お母様お父様 着物</a></li>
                </ul>
              </li>
            </ul>
            <ul class="globalnav_col col-12 col-md-4 col-lg-2">
              <li class="nav_number">
                <div class="num">03</div>
                <p>料金</p>
              </li>
              <li class="menu_child_box">
                <ul class=" menu_child">
                  <li><a href="https://kimono.studio-theday.com/price/">料金 - 振袖</a></li>
                  <li><a href="https://kimono.studio-theday.com/price-753/">料金 - 七五三着物</a></li>
                  <li><a href="https://kimono.studio-theday.com/option-photo/">撮影オプション</a></li>
                </ul>
              </li>
            </ul>

            <ul class="globalnav_col col-12 col-md-4 col-lg-2">
              <li class="nav_number">
                <div class="num">04</div>
                <p>店舗</p>
              </li>
              <li class="menu_child_box">
                <ul class="dropdown menu_child">
                  <li><a href="https://kimono.studio-theday.com/shop/">店舗</a></li>
                </ul>
              </li>
            </ul>

            <ul class="globalnav_col col-12 col-md-4 col-lg-2">
              <li class="nav_number">
                <div class="num">05</div>
                <p>GALLERY</p>
              </li>
              <li class="menu_child_box">
                <ul class="dropdown menu_child">
                  <li><a href="https://kimono.studio-theday.com/gallery/">撮影ギャラリー</a></li>
                </ul>
              </li>
            </ul>

            <ul class="globalnav_col col-12 col-md-4 col-lg-2">
              <li class="nav_number">
                <div class="num">06</div>
                <p>ご利用ガイド</p>
              </li>
              <li class="menu_child_box">
                <ul class="menu_child">
                  <li><a href="https://kimono.studio-theday.com/faq/">よくあるご質問</a></li>
                  <li><a href="https://kimono.studio-theday.com/flow/">お申込みからご返却までの流れ</a></li>
                  <li><a href="https://kimono.studio-theday.com/terms/">ご利用上のお約束</a></li>
                </ul>
                <ul class="nav_contact">
                    <li><a href="https://kimono.studio-theday.com/contact/">ご予約・お問合せ</a></li>
                </ul>
              </li>
            </ul>
          </div>

          <!-- 連結 -->
          <ul class="nav_sns">
            <li>
              <a href="https://www.instagram.com/studiotheday/" target="_blank">
                <img src="https://kimono.studio-theday.com/wp-content/themes/tao/img/common/icon_instagram.svg" alt="instagram">
                <span>studiotheday</span>
              </a>
            </li>
            <li>
              <a href="https://www.instagram.com/tao_kimono/" target="_blank">
                <img src="https://kimono.studio-theday.com/wp-content/themes/tao/img/common/icon_instagram.svg" alt="instagram">
                <span>tao_kimono</span>
              </a>
            </li>
            <li>
              <a href="https://www.instagram.com/setouchiwedding/" target="_blank">
                <img src="https://kimono.studio-theday.com/wp-content/themes/tao/img/common/icon_instagram.svg" alt="instagram">
                <span>setouchiwedding</span>
              </a>
            </li>
            <li class="nav_sns-logo">
              <a href="https://setouchiwedding.com/" target="_blank">
                <img src="https://kimono.studio-theday.com/wp-content/themes/tao/img/common/logo_setouchi.svg" alt="setouchi wedding">
              </a>
            </li>
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
