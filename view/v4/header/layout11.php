<?php //此版型主要適用Logo為直式?>
<header class="headerStyle01 headerStyle11">
  <?php //如需滿版，移除.container類別?>
  <div class="container">
    <div class="headerBox">
      <div class="LBox">
        <div class="logo"><a href="index.php"><img src="images_v4/logo.png" alt=""></a></div>
      </div>
      <div class="RBox">
        <?php //.topLink需移除子元素的.container類別?>
        <?php //$headerWidget='topLink_type1'; include 'topLink.php'; ?>
        <?php echo $__?>
        <div class="navBar">
          <div class="navBarContent">
            <?php //include('nav_menu.php');?>
            <?php echo $__?>
          </div><!-- .navBarContent -->
        </div><!-- .navBar -->
      </div>
    </div>
  </div>
</header>
