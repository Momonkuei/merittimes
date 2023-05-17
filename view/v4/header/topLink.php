  <?php if($headerWidget=='topLink_type1'){?>
  <div class="topLink">
    <div class="container">
      <ul class="topLinkMenu">
        <li>
  				<a data-fancybox data-src="#language_modal" href="javascript:;">
  					<i class="fa fa-globe" aria-hidden="true"></i><span>語系</span>
  				</a>
        </li>
        <li>
  				<a href="productsInquiry.php">
  					<i class="fa fa-info-circle" aria-hidden="true"></i><span>詢問車</span>
  				</a>
        </li>
        <li>
          <a data-fancybox data-src="#sideCart_modal" href="javascript:;">
  					<i class="fa fa-shopping-cart" aria-hidden="true"></i><span>購物車</span>
  				</a>
        </li>
        <li>
  				<a href="member.php?type=login">
  					<i class="fa fa-info-circle" aria-hidden="true"></i><span>會員登入</span>
  				</a>
        </li>
        <li>
  				<a data-fancybox data-src="#fastLogin_modal" data-options='{"touch" : false}' href="javascript:;">
  					<i class="fa fa-info-circle" aria-hidden="true"></i><span>快速登入</span>
  				</a>
        </li>
        <li>
  				<a href="favorite.php">
  					<i class="fa fa-info-circle" aria-hidden="true"></i><span>我的收藏</span>
  				</a>
        </li>
        <li>
  				<a href="contact.php">
  					<i class="fa fa-envelope" aria-hidden="true"></i><span>聯絡我們</span>
  				</a>
        </li>
        <li>
          <a data-fancybox data-src="#searchForm_modal" href="javascript:;">
  					<i class="fa fa-search" aria-hidden="true"></i><span>搜尋</span>
  				</a>
        </li>
        <li class="moreMenu lanMoreMenu">
  				<a href="javascript:;">
  					<i class="fa fa-globe" aria-hidden="true"></i><span>Language<i class="fa fa-angle-down" aria-hidden="true"></i></span>
  				</a>
          <ul>
						<li><a href="index_tw.php"><span>繁體中文</span></a></li>
						<li><a href="index_en.php"><span>English</span></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- .container -->
  </div><!-- .topLink -->
  <?}?>

  <?php if($headerWidget=='topLink_type2'){?>
    <div class="topLink">
      <ul class="topLinkMenu">
        <li>
          <a href="#">
            <i class="fa fa-info-circle" aria-hidden="true"></i><span>詢問車</span>
          </a>
        </li>
        <li>
          <a href="javascript:;" class="openBtn" data-target="#searchForm">
            <i class="fa fa-search" aria-hidden="true"></i><span>搜尋</span>
          </a>
        </li>
        <li class="moreMenu lanMoreMenu">
  				<a href="javascript:;">
  					<i class="fa fa-globe"></i><span>Language<i class="fa fa-angle-down" aria-hidden="true"></i></span>
  				</a>
          <ul>
						<li><a href="index_tw.php"><span>繁體中文</span></a></li>
						<li><a href="index_en.php"><span>English</span></a></li>
          </ul>
        </li>
      </ul>
    </div>
  <?}?>

  <?php if($headerWidget=='topLink_type3'){//結構跟type2一樣，差在資料不一樣而以?>
    <div class="topLink">
      <ul class="topLinkMenu">
        <li>
          <a href="#">
            <i class="fa fa-facebook-square" aria-hidden="true"></i><span>粉絲團</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-envelope" aria-hidden="true"></i><span>聯絡我們</span>
          </a>
        </li>
        <!-- <li>
          <a href="#">
            <i class="fa fa-envelope" aria-hidden="true"></i><span>聯絡我們</span>
          </a>
        </li> -->
      </ul>
    </div>
  <?}?>
