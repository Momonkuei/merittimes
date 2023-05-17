<?if($this->data['router_method'] != 'photocopyform_1' && !stristr($this->data['router_method'],'class_') && !stristr($this->data['router_method'],'classout_')){?>
<header class="headerStyle04">
  
  <div class="navBar">
    <div class="container">
      <div class="navBarContent">
        <div>
          <?php //$headerWidget='topLink_type3'; include 'topLink.php'; ?>
<?php echo $__?>
        </div>
        <div class="logo">
          <a href="index.php"><img src="images_v4/indexLogo.jpg" alt=""></a>
        </div>
        <div>
          <?php //$headerWidget='topLink_type2'; include 'topLink.php'; ?>
<?php echo $__?>
        </div>
        
      </div><!-- .navBarContent -->

    </div><!-- .container -->
    <div class="nav-outside-bar">

      <div class="container">
        <div class="navMenuContent">
            <?php //include('nav_menu.php'); ?>
  <?php echo $__?>
          </div><!-- .navBarContent -->
      </div>
    </div>
  </div><!-- .navBar -->
  
</header>
<?}else if(stristr($this->data['router_method'],'class_') || stristr($this->data['router_method'],'classout_')){?>
  <header class="headerStyle01">
    <div class="container">
      <div class="topLink">
        <ul class="topLinkMenu">
          <li><a href="apply_tw_1.php"><span>申請專區</span></a></li>
          <li><a ><span>讀報劇院</span></a></li>
          <li><a ><span>讀報中心</span></a></li>
          <li><a ><span>推動讀報</span></a></li>
        </ul>
      </div>
    </div>
    

    <div class="navBar">
      <div class="container">
        <div class="navBarContent">
          <div>
            <div class="logo ">
              <a href="index.php" class="web-logo">
                <img src="images_v4/indexLogo.jpg" alt="">
                <h2 class="web-logo-school"> <?=(isset($_SESSION['member_data']['school_name']) && !empty($_SESSION['member_data']['school_name'])?$_SESSION['member_data']['school_name']:'')?> <span class="web-logo-class"><?=(isset($_SESSION['member_data']['class_name']) && !empty($_SESSION['member_data']['class_name'])?$_SESSION['member_data']['class_name']:'')?></span></h2>
              </a>
            </div>
          </div>
          <div>
            <ul class="navMenu  navIconLt">
              <li><a href="classout_tw_1.php"><span>班級首頁</span></a></li>
              <li><a href="classout_tw_2.php"><span>公佈欄</span></a></li>
              <li><a href="classout_tw_3.php"><span>相片成果</span></a></li>
              <li><a href="classout_tw_4.php"><span>影音成果</span></a></li>
            </ul>

          </div>
        </div><!-- .navBarContent -->
      </div><!-- .container -->
    </div><!-- .navBar -->

  </header>
<?}?>
<?/* php include('mbPanel.php'); */?>
