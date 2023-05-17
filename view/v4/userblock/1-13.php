<section class="sectionBlock" id="userblock_<?php echo $_params_['id']?>">
  <div class="container">
    <div class="blockTitle text-center">
      <span><?php echo $row['other1']?></span>
      <small><?php echo $row['other2']?></small>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <img src="_i/assets/upload/<?php echo $row['type']?>/<?php echo $row['pic1']//690x520?>" alt="">
        <div class="subBlockTitle"><?php echo $row['other3']?></div>
        <p><?php echo $row['other4']?></p>
      </div>
      <div class="col-lg-6">
        <img src="_i/assets/upload/<?php echo $row['type']?>/<?php echo $row['pic2']//690x520?>" alt="">
        <div class="subBlockTitle"><?php echo $row['other5']?></div>
        <p><?php echo $row['other6']?></p>
      </div>
    </div>
  </div><!-- .container -->
</section><!-- .sectionBlock -->
