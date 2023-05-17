<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('../../common/meta.config.php');?>
    <title>Footer樣式</title>
    <link rel="stylesheet" href="../../fonts/fontawesome.line/css/font-awesome.css">
    <link rel="stylesheet" href="../../css/style.css">

  </head>
  <body>


    <?php
     if($_GET["type"]=='1'){
       include 'footer01.php';
     }
     if($_GET["type"]=='2'){
       include 'footer02.php';
     }
     if($_GET["type"]=='3'){
       include 'footer03.php';
     }
     if($_GET["type"]=='4'){
       include 'footer04.php';
     }
     if($_GET["type"]=='5'){
       include 'footer05.php';
     }
     if($_GET["type"]=='6'){
       include 'footer06.php';
     }
     if($_GET["type"]=='7'){
       include 'footer07.php';
     }
     if($_GET["type"]=='8'){
       include 'footer08.php';
     }
     if($_GET["type"]=='9'){
       include 'footer09.php';
     }
   ?>


  </body>
</html>
