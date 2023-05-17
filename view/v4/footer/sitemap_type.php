
            <?php if($sitemapWidget=='sitemap_type1'){//1?>
              <ul class="ftMenu_list">
                <li><a href="about.php">關於我們</a></li>
                <li><a href="products.php">商品介紹</a></li>
                <li><a href="album.php">活動花絮</a></li>
                <li><a href="download.php">下載專區</a></li>
                <li><a href="news.php">最新消息</a></li>
                <li><a href="video.php">影音專區</a></li>
                <li><a href="faq.php">問與答</a></li>
                <li><a href="location.php">服務據點</a></li>
                <li><a href="member.php?type=privacy">隱私權政策</a></li>
              </ul>
            <?}?>

            <?php if($sitemapWidget=='sitemap_type1-2'){//2 XXX?>
              <ul class="ftMenu_list">
                <li><a href="faq.php">問與答</a></li>
                <li><a href="video.php">影音專區</a></li>
                <li><a href="contact.php">聯絡我們</a></li>
                <li><a href="member.php?type=privacy">隱私權政策</a></li>
              </ul>
            <?}?>

            <?php if($sitemapWidget=='sitemap_type2'){//3?>
              <ul class="ftMenu_list">
                <li><a href="about.php">關於我們</a></li>
                <li><a href="products.php">商品介紹</a></li>
                <li><a href="album.php">活動花絮</a></li>
                <li><a href="download.php">下載專區</a></li>
                <li><a href="news.php">最新消息</a></li>
                <li><a href="video.php">影音專區</a></li>
                <li><a href="faq.php">問與答</a></li>
                <li><a href="location.php">服務據點</a></li>
                <li><a href="member.php?type=privacy">隱私權政策</a></li>
                <li>
                  <?php $socialWidget='social_type1'; include 'social_list.php'; ?>
                </li>
              </ul>
            <?}?>

            <?php if($sitemapWidget=='sitemap_type3'){//4?>
              <div class="ftMenu_title">標題</div>
              <ul class="ftMenu_list">
                <li><a href="about.php">關於我們</a></li>
                <li><a href="products.php">商品介紹</a></li>
                <li><a href="album.php">活動花絮</a></li>
                <li><a href="download.php">下載專區</a></li>
                <li><a href="news.php">最新消息</a></li>
                <li><a href="video.php">影音專區</a></li>
                <li><a href="faq.php">問與答</a></li>
                <li><a href="location.php">服務據點</a></li>
                <li><a href="member.php?type=privacy">隱私權政策</a></li>
              </ul>
            <?}?>

            <?php if($sitemapWidget=='sitemap_type3-1'){//5 XXX?>
              <div class="ftMenu_title">標題</div>
              <ul class="ftMenu_list">
                <li><a href="about.php">關於我們</a></li>
                <li><a href="products.php">商品介紹</a></li>
                <li><a href="album.php">活動花絮</a></li>
                <li><a href="member.php?type=privacy">隱私權政策</a></li>
              </ul>
            <?}?>

            <?php if($sitemapWidget=='sitemap_type3-2'){//6?>
              <div class="ftMenu_title">標題</div>
              <ul class="ftMenu_list ftMenuList_arrow">
                <li><a href="about.php">關於我們</a></li>
                <li><a href="products.php">商品介紹</a></li>
                <li><a href="album.php">活動花絮</a></li>
                <li><a href="member.php?type=privacy">隱私權政策</a></li>
              </ul>
            <?}?>
