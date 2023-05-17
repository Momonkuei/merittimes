<!DOCTYPE html>
<html lang="zh-tw">
  <head>
    <?php include('common/meta.config.php');?>

    <?php include('head.php');?>
  </head>
  <?php include('word.php');?>
  <body>

    <div class="wrapper">

      <?php include('view/header/header01.php');?>
      <?php include('view/header/mbPanel.php'); ?>

      <?php include($index_content);?>
      <?php include($about_content);?>
      <?php include($product_content);?>
      <?php include($productsdetail_content);?>
      <?php include($productsInquiry_content);?>
      <?php include($favorite_content);?>
      <?php include($news_content);?>
      <?php include($newsdetail_content);?>
      <?php include($contact_content);?>
      <?php include($download_content);?>
      <?php include($faq_content);?>
      <?php include($album_content);?>
      <?php include($albumdetail_content);?>
      <?php include($video_content);?>
      <?php include($location_content);?>
      <?php include($member_content);?>
      <?php include($checkout_content);?>

      <?php include('view/footer/footer07.php');?>

    </div><!-- .wrapper -->

    <?php include('view/widget/pageLoading.php'); ?>
    <?php include('view/widget/modal.php'); ?>
    <?php include('view/widget/gdpr.php'); ?>
    <?php include('view/widget/gotop.php'); ?>

    <?php include('end.php');?>

  </body>
</html>
