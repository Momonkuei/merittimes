<?php

// 從外面可以帶參數，來改變使用的場合
$parent_class = '';
$sub_class = '';
if(isset($_params_) and !empty($_params_)){
	if(isset($_params_['parent']) and $_params_['parent'] != ''){
		$parent_class = $_params_['parent'];
	}
	if(isset($_params_['sub']) and $_params_['sub'] != ''){
		$sub_class = $_params_['sub'];
	}
}

// 給底下的迴圈使用與組合
$data[$ID]['row_inherit_start'] = '<div class="'.$sub_class.'">';
$data[$ID]['row_inherit_end'] = '</div>';
?>

<?php 
$tmp = explode('.', $_SERVER['HTTP_HOST']);
if(ENVIRONMENT == 'development' && $tmp[0]=='shop_v3')://裝飾點綴，無功能?>
<a class="proTitleBlock1">產品特色</a>
<?php endif?>

<?php if(isset($data[$ID]['describe']) && $data[$ID]['describe']!='')://這塊給需要顯示簡述的地方?>
<div><?php echo $data[$ID]['describe']?></div>
<?php endif?>

<div class="<?php echo $parent_class?>">
	<div class="row">
<?php echo $__?>
	</div>
</div><!-- .spaceList -->
