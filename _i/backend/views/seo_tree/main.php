<?php $main_content_title_action = '';$_menu_data = $this->data['_menu_data'];

function show_child($data){

  $str = '<ul>';
  foreach ($data as $key => $value) {  

    $str .= '<li>';
    $str .= '<div class="entry">
                  <span class="btn_expand"><i class="fa fa-plus-square-o" aria-hidden="true"></i></span><a  data-src="#levelModal" data-modal="true" href="javascript:;" data-seo_type="'.$value['_router_method_revert'].'" data-seo_item_id="'.$value['seo_item_id'].'" id="'.$value['_router_method_revert'].'_'.$value['seo_item_id'].'"';
    if($value['_seo_data_true']){
      $str .= ' style="color:blue" ';
    }
    if($value['_router_method_revert']==''){
      $str .= ' style="color:red" ';
    }else{
      $str .= ' data-fancybox ';
    }

    $str .= '>'.$value['name'].'</a>
                </div>';
    if(isset($value['child'])){
      $str .= show_child($value['child']);
    }
    $str .='</li>';
  }               
  $str .= '</ul>';

  return $str;
}


?>

<!-- END BEGIN STYLE CUSTOMIZER -->   
    <h3 class="page-title">
      <?php echo $main_content_title?>
    </h3>

    <div class="breadcrumb">
      <i class="icon-home"></i>
      <a href="backend.php"><?php G::te($this->data['theme_lang'], 'Home', null, '首頁')?></a> 
      <span class="icon-angle-right"></span>

      <?php if($default_menu_title != ''):?>
        <a href="#"><?php echo $default_menu_title?></a> 
        <span class="icon-angle-right"></span>
      <?php endif?>

      <a href="#"><?php echo $main_content_title?></a> 
      <?php if($main_content_title_action != ''):?>
        <span class="icon-angle-right"></span>
      <?php endif?>

      <?php if($main_content_title_action != ''):?>
        <a href="#"><?php echo $main_content_title_action?></a> 
      <?php endif?>
    </div>   


	<div class="branch">
		<div>紅色字體為前台無此頁面</div>
		<ul class="tree">
			<li>
				<div class="entry">
				  <span class="btn_expand"><i class="fa fa-plus-square-o" aria-hidden="true"></i></span><a data-fancybox data-src="#levelModal" data-modal="true" href="javascript:;" data-seo_type="index" data-seo_item_id="0" id="index_0">首頁</a>
				</div>
				<!-- .tree -->
				<ul>
					<?php foreach ($_menu_data as $key => $value):?> 
						<?php
							$attr2 = '';
							if($value['_seo_data_true']){
								$attr2 = ' style="color:blue" ';
							}
							if($value['_router_method_revert']==''){
							  $attr2 .= ' style="color:red" ';
							}else{
							  $attr2 .= ' data-fancybox ';
							}
						?>          
						<li>
							<div class="entry">
								<span class="btn_expand"><i class="fa fa-plus-square-o" aria-hidden="true"></i></span><a data-src="#levelModal" data-modal="true" href="javascript:;" data-seo_type="<?php echo $value['_router_method_revert']?>" data-seo_item_id="0" id="<?php echo $value['_router_method_revert']?>_0" <?php echo $attr2?> ><?php echo $value['topic']?></a>
							</div>
							<?php if(isset($value['child'])):?>
								<?php echo show_child($value['child'])?>
							<?php endif?>
						</li>
					<?php endforeach?>
				</ul>
			</li>
       </ul><!-- .tree -->         
  </div><!-- .branch -->


  <div style="display: none;max-width:600px;" id="levelModal">
    <h2 id="_title">第幾層</h2>
    <form id="form_data" name="form_data" method="post" action="backend.php?r=seo/renew">
      <input type="hidden" id="seo_type" name="seo_type" value="">
      <input type="hidden" id="seo_item_id" name="seo_item_id" value="">
     視窗抬頭Title(若未填則預設使用全站title) <input id="seo_title" type="text" name="seo_title" value="">
     <?php if(preg_match('/^99999/', $this->data['admin_id'])):?>
      檔案名稱(靜態頁網址)(百邇來專用) <input id="seo_script_name" type="text" name="seo_script_name" value="">
     <?php endif?>
     網頁關鍵字keyword <textarea id="seo_meta_keyword" name="seo_meta_keyword" rows="8" cols="80"></textarea>
     網頁說明description <textarea id="seo_meta_description" name="seo_meta_description" rows="8" cols="80"></textarea>
      <button type="submit" type="button" name="submit">Submit</button>
      <button type="button" name="Delete" id="delete">Delete</button>
    </form>
  </div>

 
  <script src="backend/views/seo_tree/js/fancybox/jquery.fancybox.min.js"></script>
  <script src="backend/views/seo_tree/js/script.js"></script>
