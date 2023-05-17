<section class="sectionBlock" id="userblock_<?php echo $_params_['id']?>">
  <div class="blockTitle text-center">
	<span><?php echo $data[$ID]['other1']?></span>
	<small><?php echo $data[$ID]['other2']?></small>
  </div>
  <div class="small-gutters spaceList">
    <div class="row">
      <div class="col-lg-6">
        <div class="itemImg customSize">
		  <img src="_i/assets/upload/<?php echo $data[$ID]['type']?>/<?php echo $data[$ID]['pic1']//956x300?>" alt="">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="itemImg customSize">
		  <img src="_i/assets/upload/<?php echo $data[$ID]['type']?>/<?php echo $data[$ID]['pic2']//956x300?>" alt="">
        </div>
      </div>
    </div>
  </div><!-- .small-gutters -->
</section><!-- .sectionBlock -->
