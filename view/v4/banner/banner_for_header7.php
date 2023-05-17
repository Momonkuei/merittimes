  <div class="banner_result">
    <div class="bannerBlock">
      <!--bannerStyle-->
      <div class="bannerStyle12">
        <?php if(isset($data[$ID])):?>
          <?php foreach($data[$ID] as $k => $v):?>
        <div class="slidItem">
          <a href="">
            <img class="pc" src="<?php echo $v['pic1g']?>" alt="">
            <img class="mb" src="<?php echo $v['pic2g']?>" alt="">
          </a>
        </div>
          <?php endforeach?>
        <?php endif?>
       
      </div>
      <!--bannerStyle End-->
      <!-- <div class="scrollDown">
        <a href="#scrollDown">
          <img src="images_v4/icon/scrollDown.gif" alt="">
          <div class="scrollDown_txt">Scroll down</div>
        </a>
      </div> -->
    </div>
  </div>