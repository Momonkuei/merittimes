
 <div class="wrapper">
  <!--header-->
  <header class="headerStyle01">
  <?php echo $AA?>
  </header>
  <!--header End-->

  <!--內頁Banner-->
  <?php echo $BB?>
  <!--內頁Banner-->

  <div class="XXXContent">
   <!--浮起來的內容區塊-->
   <section class="floatMainBlock">
    <div class="floatMainBox">
     <!--麵包屑-->
     <div class="container">
      <?php echo $CC?>
     </div>
     <!--麵包屑 End-->
     <!--大標題-->         
     <div class="container">
      <?php echo $DD?>
     </div>
     <!--大標題 End-->
     <!--內容區塊-->
     <div class="mainContent">
      <div class="container">
       <?php echo $EE?>
      </div><!--container-->
     </div><!--mainContent-->
     <!--內容區塊 End-->
    </div>
   </section>
   <!--浮起來的內容區塊 End-->

   <!--下方滿版區塊-->
   <?php if(1): //預留第二區塊，可滿版或不滿版，日後如有需求可使用?>
   <section class="secondContentBlock">
      <?php echo $FF?>
   </section>
   <?php endif?>
   <!--下方滿版區塊 End-->

   <?php echo $GG?> <?php //預留給分頁區塊?>

  </div><!--XXXContent End-->  

 </div><!--wrapper End-->
