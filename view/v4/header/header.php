<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('../../common/meta.config.php');?>
    <title>header樣式</title>
    <link rel="stylesheet" href="../../fonts/fontawesome.line/css/font-awesome.css">
    <link rel="stylesheet" href="../../js/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="../../css/style.css">

  </head>
  <body>

    <?php
     if($_GET["type"]=='1'){
       include 'header01.php';
     }
     if($_GET["type"]=='2'){
       include 'header02.php';
     }
     if($_GET["type"]=='3'){
       include 'header03.php';
     }
     if($_GET["type"]=='4'){
       include 'header04.php';
     }
     if($_GET["type"]=='5'){
       include 'header05.php';
     }
     if($_GET["type"]=='6'){
       include 'header06.php';
     }
     if($_GET["type"]=='7'){
       include 'header07.php';
     }
     if($_GET["type"]=='8'){
       include 'header08.php';
     }
   ?>


   <script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
   <script type="text/javascript" src="../../js/mbPanel/mbPanel.data.js"></script>
   <script type="text/javascript" src="../../js/mbPanel/mbPanel.js"></script>
   <script type="text/javascript" src="../../js/swiper/js/swiper.min.js"></script>
   <script type="text/javascript" src='../../js/YTPlayer/jquery.mb.YTPlayer.min.js'></script>
   <script type="text/javascript" src="../../js/banner.js"></script>
   <script type="text/javascript" src="../../js/script.js"></script>

  </body>
</html>
