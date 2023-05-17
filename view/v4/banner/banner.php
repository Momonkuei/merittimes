<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('../../common/meta.config.php');?>
    <title>Banner樣式</title>
    <link rel="stylesheet" href="../../js/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="../../css/style.css">

    <!-- bannerStyle08專用 -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"> -->
    <script>!function(e){"undefined"==typeof module?this.charming=e:module.exports=e}(function(e,n){"use strict";n=n||{};var t=n.tagName||"span",o=null!=n.classPrefix?n.classPrefix:"char",r=1,a=function(e){for(var n=e.parentNode,a=e.nodeValue,c=a.length,l=-1;++l<c;){var d=document.createElement(t);o&&(d.className=o+r,r++),d.appendChild(document.createTextNode(a[l])),n.insertBefore(d,e)}n.removeChild(e)};return function c(e){for(var n=[].slice.call(e.childNodes),t=n.length,o=-1;++o<t;)c(n[o]);e.nodeType===Node.TEXT_NODE&&a(e)}(e),e});
    </script>

  </head>
  <body>


    <?php
     if($_GET["type"]=='1'){
       include 'banner01.php';
     }
     if($_GET["type"]=='2'){
       include 'banner02.php';
     }
     if($_GET["type"]=='3'){
       include 'banner03.php';
     }
     if($_GET["type"]=='4'){
       include 'banner04.php';
     }
     if($_GET["type"]=='5'){
       include 'banner05.php';
     }
     if($_GET["type"]=='6'){
       include 'banner06.php';
     }
     if($_GET["type"]=='7'){
       include 'banner07.php';
     }
     if($_GET["type"]=='8'){
       include 'banner08.php';
     }
     if($_GET["type"]=='9'){
       include 'banner09.php';
     }
     if($_GET["type"]=='10'){
       include 'banner10.php';
     }
     if($_GET["type"]=='11'){
       include 'banner11.php';
     }
   ?>


   <script type="text/javascript" src="../../js/jquery-3.2.1.min.js"></script>
   <script type="text/javascript" src="../../js/swiper/js/swiper.min.js"></script>
   <script type="text/javascript" src="../../js/TweenMax.min.js"></script>
   <script type="text/javascript" src="../../js/banner.js"></script>

  </body>
</html>
