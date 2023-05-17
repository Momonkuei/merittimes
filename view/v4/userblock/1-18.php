<section class="sectionBlock" id="userblock_<?php echo $_params_['id']?>">
  <div class="fullBlock_2c">
    <div class="row no-gutters">
      <div class="col-lg-6">
        <div class="inner_txtFrame">
          <div class="row colVCenter">
            <div class="col-lg-3 text-center"><img src="_i/assets/upload/<?php echo $row['type']?>/<?php echo $row['pic1']//210x280?>" alt=""></div>
            <div class="col-lg-9">
              <div class="subBlockTitle"><?php echo $row['other3']?></div>
			  <p><?php echo $row['other4']?></p>
            </div>
          </div>
        </div>
        <a class="bg_light" href="">
          <div class="blockTitle text-center">
			  <span><?php echo $row['other1']?></span>
			  <small><?php echo $row['other2']?></small>
          </div>
        </a>
      </div>
      <div class="col-lg-6">
        <div class="itemImg"><img src="_i/assets/upload/<?php echo $row['type']?>/<?php echo $row['pic2']//960x420?>" alt=""></div>
        <a class="bg_dark" href="">
          <div class="blockTitle text-center">
			  <span><?php echo $row['other5']?></span>
			  <small><?php echo $row['other6']?></small>
          </div>
        </a>
      </div>
    </div>
  </div><!-- .fullBlock_2c -->
</section><!-- .sectionBlock -->
