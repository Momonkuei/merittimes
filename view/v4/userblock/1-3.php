<section class="sectionBlock" id="userblock_<?php echo $_params_['id']?>">
  <div class="container">

    <div class="innerBlock">
      <div class="row">
        <div class="col-lg-6">
          <div class="blockTitle">
			<span><?php echo $data[$ID]['other1']?></span>
			<small><?php echo $data[$ID]['other2']?></small>
          </div>
		  <p><?php echo $data[$ID]['detail']?></p>
        </div>
        <div class="col-lg-6 text-center">
		  <img src="_i/assets/upload/<?php echo $data[$ID]['type']?>/<?php echo $data[$ID]['pic1']//690x520?>" alt="">
        </div>
      </div>
    </div><!-- .innerBlock -->

  </div><!-- .container -->
</section><!-- .sectionBlock -->
