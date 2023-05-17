<section class="sectionBlock" id="userblock_<?php echo $_params_['id']?>">
  <div class="halfBgBlock halfBgBlock_rBlk halfBgBlock_rBlk_angle">
    <div>
      <div class="itemImg">
		<img src="_i/assets/upload/<?php echo $data[$ID]['type']?>/<?php echo $data[$ID]['pic1']//960x420?>" alt="">
      </div>
    </div>
    <div>
      <div class="halfBgBlock_inner">
        <div class="blockTitle">
			<span><?php echo $data[$ID]['other1']?></span>
			<small><?php echo $data[$ID]['other2']?></small>
        </div>
	    <p><?php echo $data[$ID]['detail']?></p>
      </div><!-- .halfBgBlock_inner -->
    </div>
  </div><!-- .half_bgColor -->
</section><!-- .sectionBlock -->
