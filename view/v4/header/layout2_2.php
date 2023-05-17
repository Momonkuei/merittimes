<header class="headerStyle02 headerStyle02_modify-02 ">
  <div class="header_inner">
    <div class="logo"><a href="index.php"><img src="images_v4/logo.png" alt=""></a></div>
    <div class="menu_blk">
	  <!-- <?php if(isset($this->data['admin_id']) and $this->data['admin_id'] > 0):?>
		<a class="btn_register" href="membercenter_<?php echo $this->data['ml_key']?>.php">會員中心</a>
	  <?php else:?>
		<a class="btn_singIn" href="guestlogin_<?php echo $this->data['ml_key']?>.php">登入</a>
		<a class="btn_register" href="guestregister_<?php echo $this->data['ml_key']?>.php">會員註冊</a>
	  <?php endif?> -->

      <nav class="l-nav_main c_font-b">
        <div class="l-nav_main-current active" ></div>
          
          <ul>
            <!-- <div class="l-nav_main-current" ></div> -->
            <li class="js-nav-mouseover"><a href="javascript:void(0)">ホーム</a></li>
            <li class=""><a href="javascript:void(0)">商品を探す</a></li>
            <li class=""><a href="javascript:void(0)">マガジン</a></li>
            <li><a href="javascript:void(0)">サポート</a></li>
            <li><a href="javascript:void(0)">企業情報</a></li>
            <li><a href="javascript:void(0)">お問い合わせ</a></li>
          </ul>
        </nav>

      <div class="btn-list">
        <button class="mobile-menu-btn search-menu-control"  data-action="toggle">
          <i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </div>

      <div class="btn-list">
        <button class="mobile-menu-btn slide-menu-control" data-target="mb_slideMenu" data-action="toggle"><span></span></button>
      </div>
    </div><!-- .menu_blk -->
    <div class="fullMenu">
      <div class="fullMenu_inner">
        <div class="fullMenu_nav2 ">
          <!-- 搜尋介面 -->
          <div class="l-nav_full-search-inr">
            <div class="l-nav_full-search-box c_form">
              <form method="get" id="search1" action="https://www.pentel.co.jp/">
                <input type="text" name="s" id="search-input" value="" placeholder="検索キーワードを入力">
                <button type="submit" accesskey="f" class="search-btn" aria-label="検索"></button>
              </form>

            </div>
            <div class="l-nav_full-search-keywords">
              <div class="l-nav_full-search-keywords-ttl c_ttl-mid">
                <span class="en c_font-en-h">Keywords</span>
                人気のキーワード
              </div>
              <ul>
              <li><a href="https://www.pentel.co.jp/search/%E3%82%A8%E3%83%8A%E3%83%BC%E3%82%B8%E3%82%A7%E3%83%AB">エナージェル</a></li>
              <li><a href="https://www.pentel.co.jp/search/%E3%82%B5%E3%82%A4%E3%83%B3%E3%83%9A%E3%83%B3">サインペン</a></li>
              <li><a href="https://www.pentel.co.jp/search/%E3%82%AA%E3%83%AC%E3%83%B3%E3%82%BA">オレンズ</a></li>
              </ul>
            </div>
          </div>

          <!-- 內容表單 -->
          <div class="l-nav_full-list-inr">
              <div class="l-nav_full-list-wrap">
                  <div class="l-nav_full-list-01 c_font-b">
                  <ul>
                  <li><a href="https://www.pentel.co.jp/">ホーム</a></li>
                  </ul>
                  <ul>
                  <li class="l-nav_full-list-tgl">
                    <span class="l-nav_full-list-tgl-wrap"><a href="https://www.pentel.co.jp/products/">商品を探す</a>
                  </span>
                      <ul class="c_font-n">
                      <li class="sponly"><a href="https://www.pentel.co.jp/products/">商品を探すトップ</a></li>
                      <li><a href="https://www.pentel.co.jp/products/ballpointpen/">ボールペン</a></li>
                      <li><a href="https://www.pentel.co.jp/products/pen/">ペン</a></li>
                      <li><a href="https://www.pentel.co.jp/products/marker/">マーカー</a></li>
                      <li><a href="https://www.pentel.co.jp/products/mechanicalpencil/">シャープペン</a></li>
                      <li><a href="https://www.pentel.co.jp/products/correctionproducts/">消し具</a></li>
                      <li><a href="https://www.pentel.co.jp/products/brush/">ブラッシュ（筆）</a></li>
                      <li><a href="https://www.pentel.co.jp/products/artmaterials/">画材</a></li>
                      <li><a href="https://www.pentel.co.jp/products/others/">その他</a></li>
                      </ul>
                  </li>
                  </ul>
                  <ul>
                  <li><a href="https://www.pentel.co.jp/magazine/">マガジン</a></li>
                  <li><a href="https://www.pentel.co.jp/support/">サポート</a></li>
                  <li class="l-nav_full-list-tgl"><span class="l-nav_full-list-tgl-wrap"><a href="https://www.pentel.co.jp/corporate/">企業情報</a></span>
                      <ul class="c_font-n">
                      <li class="sponly"><a href="https://www.pentel.co.jp/corporate/">企業情報トップ</a></li>
                      <li><a href="https://www.pentel.co.jp/corporate/corporate-message/">メッセージ</a></li>
                      <li><a href="https://www.pentel.co.jp/corporate/about/">会社概要</a></li>
                      <li><a href="https://www.pentel.co.jp/corporate/about/#info_access">アクセス</a></li>
                      <li><a href="https://www.pentel.co.jp/recruit/" target="_blank" rel="noopener noreferrer">採用情報</a></li>
                      </ul>
                  </li>
                  </ul>
                  <ul>
                      <li><a href="https://www.pentel.co.jp/news/">お知らせ</a></li>
                      <li><a href="https://www.pentel.co.jp/support/inquiry/">お問い合わせ</a></li>
                      <li class="global c_font-en">
                          <a href="http://www.pentelworld.com/" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        Global</a>
                        <div class="sns">
                          <a href="https://www.instagram.com/pentel_official/" class="instagram" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                      <svg width="20" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <mask id="mask0_502_5098" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="17" height="18">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0H17V17.2727H0V0Z" fill="#212121"></path>
                      </mask>
                      <g mask="url(#mask0_502_5098)">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49999 0C6.19155 0 5.90205 0.00994182 4.99547 0.0519717C4.09071 0.0938988 3.47284 0.239906 2.93215 0.453416C2.37323 0.67409 1.89917 0.969396 1.42663 1.44952C0.954056 1.92967 0.663446 2.4113 0.446223 2.97919C0.236085 3.52856 0.0924162 4.15633 0.0511174 5.07561C0.0097511 5.99677 0 6.29084 0 8.63636C0 10.9819 0.0097511 11.276 0.0511174 12.1971C0.0924162 13.1164 0.236085 13.7442 0.446223 14.2935C0.663446 14.8614 0.954056 15.3431 1.42663 15.8232C1.89917 16.3033 2.37323 16.5986 2.93215 16.8194C3.47284 17.0328 4.09071 17.1788 4.99547 17.2208C5.90205 17.2628 6.19155 17.2727 8.49999 17.2727C10.8085 17.2727 11.0979 17.2628 12.0045 17.2208C12.9093 17.1788 13.5271 17.0328 14.0678 16.8194C14.6268 16.5986 15.1008 16.3033 15.5734 15.8232C16.0459 15.3431 16.3365 14.8614 16.5538 14.2935C16.7639 13.7442 16.9076 13.1164 16.9489 12.1971C16.9902 11.276 17 10.9819 17 8.63636C17 6.29087 16.9902 5.99677 16.9489 5.07561C16.9076 4.15633 16.7639 3.52856 16.5538 2.97919C16.3365 2.4113 16.0459 1.92967 15.5734 1.44952C15.1008 0.969396 14.6268 0.67409 14.0678 0.453416C13.5271 0.239906 12.9093 0.0938988 12.0045 0.0519717C11.0979 0.00994182 10.8085 0 8.49999 0M8.49996 1.55615C10.7696 1.55615 11.0384 1.56493 11.9347 1.60648C12.7634 1.64491 13.2135 1.7856 13.513 1.90388C13.9098 2.06055 14.1929 2.24769 14.4904 2.54989C14.7878 2.85212 14.972 3.13982 15.1262 3.54294C15.2426 3.84726 15.3811 4.30455 15.4189 5.14659C15.4597 6.05726 15.4684 6.33042 15.4684 8.63641C15.4684 10.9424 15.4597 11.2156 15.4189 12.1262C15.3811 12.9683 15.2426 13.4256 15.1262 13.7299C14.972 14.133 14.7878 14.4207 14.4904 14.7229C14.1929 15.0252 13.9098 15.2123 13.513 15.369C13.2135 15.4872 12.7634 15.6279 11.9347 15.6663C11.0385 15.7079 10.7697 15.7167 8.49996 15.7167C6.23018 15.7167 5.9614 15.7079 5.06524 15.6663C4.2365 15.6279 3.78639 15.4872 3.48688 15.369C3.09015 15.2123 2.80697 15.0252 2.50954 14.7229C2.21211 14.4207 2.02789 14.133 1.87369 13.7299C1.75732 13.4256 1.61885 12.9683 1.58103 12.1263C1.54013 11.2156 1.53149 10.9424 1.53149 8.63641C1.53149 6.33042 1.54013 6.05726 1.58103 5.14659C1.61885 4.30455 1.75732 3.84726 1.87369 3.54294C2.02789 3.13982 2.21211 2.85212 2.50954 2.54992C2.80697 2.24769 3.09015 2.06055 3.48688 1.90388C3.78639 1.7856 4.2365 1.64491 5.06521 1.60648C5.96153 1.56493 6.23034 1.55615 8.49996 1.55615" fill="#212121"></path>
                      </g>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49949 11.5149C6.93469 11.5149 5.66614 10.226 5.66614 8.6361C5.66614 7.0462 6.93469 5.75732 8.49949 5.75732C10.0643 5.75732 11.3328 7.0462 11.3328 8.6361C11.3328 10.226 10.0643 11.5149 8.49949 11.5149M8.49965 4.20117C6.089 4.20117 4.13477 6.18672 4.13477 8.63605C4.13477 11.0854 6.089 13.071 8.49965 13.071C10.9103 13.071 12.8645 11.0854 12.8645 8.63605C12.8645 6.18672 10.9103 4.20117 8.49965 4.20117" fill="#212121"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.0576 4.02548C14.0576 4.59786 13.6009 5.06183 13.0376 5.06183C12.4743 5.06183 12.0176 4.59786 12.0176 4.02548C12.0176 3.45311 12.4743 2.98914 13.0376 2.98914C13.6009 2.98914 14.0576 3.45311 14.0576 4.02548" fill="#212121"></path>
                      </svg>
                      </a> <a href="https://twitter.com/pentel_pepe/lists/1545344974723887104?ref_src=twsrc%5Etfw" class="twitter" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                      <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5.34616 14C11.7613 14 15.2701 8.61339 15.2701 3.94212C15.2701 3.78913 15.2701 3.63682 15.2599 3.4852C15.9425 2.98479 16.5317 2.36519 17 1.65542C16.3634 1.9413 15.6882 2.12877 14.9967 2.21159C15.7248 1.76981 16.2698 1.07497 16.5301 0.256384C15.8455 0.668139 15.0964 0.958323 14.3154 1.11441C13.2342 -0.0507185 11.5163 -0.335889 10.1249 0.418811C8.7335 1.17351 8.01467 2.78039 8.37148 4.3384C5.56709 4.19591 2.95424 2.85344 1.1832 0.645083C0.257463 2.26028 0.730312 4.32659 2.26304 5.3639C1.70798 5.34723 1.16503 5.19548 0.68 4.92145C0.68 4.93592 0.68 4.95109 0.68 4.96625C0.680454 6.64895 1.85079 8.09825 3.4782 8.43145C2.96471 8.57338 2.42595 8.59413 1.90332 8.4921C2.36024 9.93209 3.66967 10.9186 5.16188 10.947C3.92682 11.9307 2.40112 12.4648 0.83028 12.4632C0.552774 12.4626 0.275539 12.4456 0 12.4122C1.59503 13.4496 3.45094 13.9998 5.34616 13.9973" fill="#212121"></path>
                      </svg>
                      </a> <a href="https://www.youtube.com/channel/UC3xEFn-oZtgUSXc-rd24PGA" class="youtube" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                      <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M19.5836 2.18547C19.4687 1.76098 19.2442 1.37419 18.9325 1.06395C18.6208 0.753705 18.233 0.530934 17.8079 0.418004C16.2478 0 9.99589 0 9.99589 0C9.99589 0 3.74229 0 2.18547 0.418004C1.76181 0.53189 1.37553 0.75512 1.06532 1.06532C0.75512 1.37553 0.53189 1.76181 0.418004 2.18547C0 3.74393 0 6.99745 0 6.99745C0 6.99745 0 10.251 0.418004 11.8094C0.53189 12.2331 0.75512 12.6194 1.06532 12.9296C1.37553 13.2398 1.76181 13.463 2.18547 13.5769C3.74393 13.9883 9.99589 13.9883 9.99589 13.9883C9.99589 13.9883 16.2495 13.9883 17.8079 13.5703C18.2322 13.458 18.6195 13.2362 18.9311 12.9272C19.2427 12.6181 19.4677 12.2327 19.5836 11.8094C20 10.251 20 6.99745 20 6.99745C20 6.99745 19.9918 3.74393 19.5836 2.18547ZM7.99638 9.99589V3.99901L13.1918 6.99745L7.99638 9.99589Z" fill="#212121"></path>
                      </svg>
                      </a>
                        </div>
                      </li>
                      <!-- <li class="sns"></li> -->
                  </ul>
                  </div>
                  <div class="l-nav_full-list-02">
                    <div class="l-nav_full-list-02-ttl c_ttl-mid"><span class="en c_font-en-h">New<br>
              Products</span>ぺんてるの新商品</div>
                    <div class="l-nav_full-list-02-lists c_font-b ">
                      <ul>
                        <li><a href="https://www.pentel.co.jp/products/mechanicalpencil/orenz_at/"><span class="fig"><img src="https://www.pentel.co.jp/images/products/thumb_orenz_at.png" alt=""></span><span class="text">オレンズ AT デュアルグリップタイプ</span></a></li>
                        <li><a href="https://www.pentel.co.jp/products/mechanicalpencil/lead_pentel_ain/"><span class="fig"><img src="https://www.pentel.co.jp/images/products/thumb_lead_pentel_ain.png" alt=""></span><span class="text">Pentel Ain</span></a></li>
                        <li><a href="https://www.pentel.co.jp/products/ballpointpen/calme/"><span class="fig"><img src="https://www.pentel.co.jp/images/products/thumb_calme.png" alt=""></span><span class="text">カルム</span></a></li>
                        <li><a href="https://www.pentel.co.jp/products/ballpointpen/calme_3c/"><span class="fig"><img src="https://www.pentel.co.jp/images/products/thumb_calme_3c.png" alt=""></span><span class="text">カルム 3色ボールペン</span></a></li>
                        <li><a href="https://www.pentel.co.jp/products/brush/milkybrush/"><span class="fig"><img src="https://www.pentel.co.jp/images/products/thumb_milkybrush.png" alt=""></span><span class="text">ミルキーブラッシュ</span></a></li>
                      </ul>
                    </div>
                  </div>
                  
                </div>
          </div>

          <!-- <ul l="layer" ls="webmenu:top">
            <li l="list"><a attr2="">{/name/}</a></li>
            <li><a href="about.php">關於我們</a></li>
            <li><a href="products.php">商品介紹</a></li>
            <li><a href="album.php">活動花絮</a></li>
            <li><a href="download.php">下載專區</a></li>
            <li><a href="news.php">最新消息</a></li>
            <li><a href="faq.php">問與答</a></li>
          </ul> -->
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
