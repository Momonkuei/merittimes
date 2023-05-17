<?php
/*
 * 這裡ul的變化有：
 * <ul class="menuListStyle_1 togglearea" data-item="li" data-title="li>a" data-content="li>ul" data-nodefault="true" l="layer" ls="lll">
 * <ul class="menuListStyle_2">
 * <ul class="menuListStyle_3">
 * <ul class="menuListStyle_4">
 * lota 測試 ，目前menuListStyle_1有效，其他沒有 2021-12-15
 * 20220913 修改menuListStyle_1同層選單可以縮合 原data-content="li>ul"，改後data-content="ul"
 */
$_sidemenu_title = '我是側選單標題';
if($this->data['router_method']=='product'){
  $_sidemenu_title = t('Product Categories');
}
if($this->data['router_method']=='shop'){
  $_sidemenu_title = t('Shop Categories');
}
?>
<div class="boxTitle"><span><?php echo $_sidemenu_title?></span></div>
<ul class="menuListStyle_1 togglearea" data-item="li" data-title="li>a" data-content="ul" data-nodefault="true" l="layer" ls="lll">
	<li l="list" attr1="" <?php if(0):?> id="navlight_{/id/}" <?php endif?> ><a attr2="" >{/pic2_src/}{/name/}</a>
		{/child/}
	</li>
	<ul l="box">{split}</ul>
</ul>

<?php if(1):?>
<script type="text/javascript" m="body_end">
<?php if(preg_match('/^(.*)_(.*)$/', $this->data['router_method'], $matches)):// 編排頁?>
	$('#navlight_left_<?php echo $this->data['router_method']?>').addClass('active');
	<?php if(0):// 2018-09-21 如果上面套的方式，不是用LayoutV3的方式，而是用V1第二版的方式，那這裡就要改用這一行?>
		$('#navlight_left_<?php echo $this->data['_breadcrumb'][2]['id']?>').addClass('active');
	<?php endif?>
<?php else:?>
	<?php if(isset($_GET['id']) and $_GET['id'] > 0):?>
		$('#navlight_<?php echo $_GET['id']?>').addClass('active');
    $('#navlight_noname_<?php echo $_GET['id']?>').addClass('active');<?php //只有一層的選單，id會變化，所以補充一下 by lota?>

    <?php
      $_breadcrumb_num = count($this->data['_breadcrumb']);
      for ($i=2; $i < $_breadcrumb_num ; $i++):
    ?>
      $('#navlight_<?php echo $this->data['_breadcrumb'][$i]['id']?>').addClass('active');
    <?php endfor?>	

	<?php else:?>
		<?php if(isset($this->data['_breadcrumb'][2]['id'])):?>
			$('#navlight_<?php echo $this->data['_breadcrumb'][2]['id']?>').addClass('active');
		<?php endif?>
	<?php endif?>
<?php endif?>
</script>
<?php endif?>

<?php if(0):?>
 <li><a href="elements.php?a=0">選項一(2層)</a>
  <ul>
   <li><a href="elements.php?a=1">子選單一</a></li>
   <li><a href="elements.php?a=2">子選單二</a></li>
   <li><a href="elements.php?a=6">子選單三</a></li>
   <li><a href="elements.php?a=7">子選單四</a></li>
  </ul>
 </li>
 <li><a href="elements.php?a=33">選項一</a></li>
 <li><a href="elements.php?a=3">選項(3層)</a>
  <ul>
   <li><a href="elements.php?a=4">子選單一(子)</a>
    <ul>
     <li><a href="elements.php?a=4">子選單一</a></li>
     <li><a href="elements.php?a=5">子選單二</a></li>
     <li><a href="elements.php?a=11">子選單三</a></li>
     <li><a href="elements.php?a=12">子選單四</a></li>
    </ul>
   </li>
   <li><a href="elements.php?a=5">子選單二(子)</a>
    <ul>
     <li><a href="elements.php?a=4">子選單一</a></li>
     <li><a href="elements.php?a=5">子選單二</a></li>
     <li><a href="elements.php?a=11">子選單三</a></li>
     <li><a href="elements.php?a=12">子選單四</a></li>
    </ul>
   </li>
   <li><a href="elements.php?a=11">子選單三</a></li>
   <li><a href="elements.php?a=12">子選單四</a></li>
  </ul>
 </li>
 <li><a href="elements.php?a=8">選項一</a></li>
 <li><a href="elements.php?a=9">選項一</a></li>
<?php endif?>
