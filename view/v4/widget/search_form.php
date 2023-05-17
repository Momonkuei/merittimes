<div id="searchForm" class="modal modal_half">
  <div class="pageTitleStyle-1">
    <span><?php echo t('搜尋','tw')?></span>
  </div>
  <form class="cont_form" method="get" action="<?php echo $data[$ID]['url']?>">
    <div class="srh_content">
      <input type="text" name="q">
    </div>
    <div><button class="btn-cis1"><?php echo t('SEARCH','en')?></button></div>
  </form><!-- .cont_form -->
</div><!-- #searchForm_modal-->
