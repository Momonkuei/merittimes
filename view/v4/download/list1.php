  <section class="col-12 col-sm-12 sectionBlock">
    <div>
      <?php /*
      <div class="pageTitleStyle-2 text-center">
        <span>DOWNLOAD</span>
        <small>檔案下載</small>
      </div>
      */?>

      <?php //$classificationMenu='classificationMenu_type1'; include 'view/widget/classificationMenu.php'; ?>

      <?php /* //分類的標題...不知道要不要
      <div class="blockTitle">
        <span>下載分類</span>
      </div>
      */?>

      <?php /* //這邊應該是分類的簡述
      <p>以下一般常見問題，如有其他問題請與我們聯絡，這裡是問與答表頭簡述文字，以下為非正式文字，北是走素線關們生，識合民後知去那刻在家場意一評，道高組非得小，安沒國美音晚球一意我社樹在有開後量。他利般土何器華認上他養投才帶明們提建小。港登具技如方原樣；過酒照響、來速研說。</p>
      */?>

    <?php if(isset($data[$ID])):?>
      <div class="responsive_tbl">
        <table class="dataTable">
          <thead>
            <tr>
              <th><?php echo t('檔案名稱','tw')?></th>
              <th><?php echo t('檔案大小','tw')?></th>
              <th><?php echo t('最後更新時間','tw')?></th>
              <th><?php echo t('下載','tw')?></th>
            </tr>
          </thead>
          <tbody>
        
          <?php foreach($data[$ID] as $k => $v):?>
            <tr>
              <td><?php echo $v['name']?></td>
              <td><?php echo $v['file_size']?></td>
              <td><?php echo $v['update_time']?></td>
              <td>
                <a class="btn-cis1" 
                  <?php if(isset($v['href1']) and $v['href1'] != ''):?> href="<?php echo $v['href1']?>" target="_blank" <?php endif?>
                  <?php if(isset($v['anchor1_class']) and $v['anchor1_class'] != ''):?> class="<?php echo $v['anchor1_class']?>" <?php endif?> 
                  <?php if(isset($v['anchor1_data_target']) and $v['anchor1_data_target'] != ''):?> data-target="<?php echo $v['anchor1_data_target']?>" <?php endif?> 
                ><i class="fa fa-download" aria-hidden="true"></i><?php echo t('DOWNLOAD','en')?></a></td>
            </tr>
             <?php endforeach?>
          </tbody>
        </table>
      </div><!-- .responsive_tbl -->
    <?php endif?>

    </div>
  </section><!-- .sectionBlock -->
