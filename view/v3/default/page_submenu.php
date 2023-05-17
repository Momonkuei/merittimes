<?php
// http://網站的網址/_i/backend.php?r=datasource/update&param=v1693
// 懷舊次選單 - v3_source:menu/sub,
//
// 這裡支援編排頁 XXX_Y
// 沒編號的功能 AAA
// 有編號的功能 BBB__C
//
if(0){ // A方案
	$data[$ID] = $this->data['_sub'];

	// 懷舊次選單，改成顯示次類 #34606
	if(0){
		$row = $this->cidb->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->where('id',$_GET['id'])->get('producttype')->row_array();
		if($row and isset($row['id'])){
			if($row['pid'] > 0){
				$rowg = $this->cidb->where('ml_key',$this->data['ml_key'])->where('is_enable',1)->where('id',$row['pid'])->get('producttype')->row_array();
				$data[$ID] = $data[$ID][$rowg['sort_id']-1]['child'];
			} else {
?>
<script type="text/javascript" m="body_end">
	window.location.href='product_<?php echo $this->data['ml_key']?>.php?id=<?php echo $data[$ID][$row['sort_id']-1]['child'][0]['id']?>';
</script>
<?php
			}
		}
	} // 需要時在打開
} // A方案
?>

<?php if(isset($data[$ID])):// LayoutV3的版本?>
	<div class="text-center Bbox_1c">
		<ul class="menuListStyle_3">
			<?php foreach($data[$ID] as $k => $v):?>
				<?php if(isset($v['url']) and preg_match('/^(.*)_(..)_(.*)\.php$/', $v['url'], $matches)):// 編排頁?>
					<li id="navlight_left_<?php echo $matches[1]?>_<?php echo $matches[3]?>" ><a href="<?php echo $v['url']?>"><span class="text"><?php echo $v['name']?></span></a></li>
				<?php else:?>
					<li id="navlight_left_<?php echo $this->data['router_method']?><?php if(isset($v['id']) and $v['id'] > 0):?>__<?php echo $v['id']?><?php endif?>" ><a href="<?php echo $v['url']?>"><span class="text"><?php echo $v['name']?></span></a></li>
				<?php endif?>
			<?php endforeach?>
		</ul>
	</div>
<?php endif?>

<?php if(0):// 這裡是範例，如果要用，請打開我，並把我放到最下面?>
<script type="text/javascript" m="body_end">
<?php if(preg_match('/^(.*)_(.*)$/', $this->data['router_method'], $matches)):// 編排頁?>
	$('#navlight_left_<?php echo $this->data['router_method']?>').addClass('active');
	<?php if(0):// 2018-09-21 如果上面套的方式，不是用LayoutV3的方式，而是用V1第二版的方式，那這裡就要改用這一行?>
		$('#navlight_left_<?php echo $this->data['_breadcrumb'][2]['id']?>').addClass('active');
	<?php endif?>
<?php else:?>
	<?php if(isset($_GET['id']) and $_GET['id'] > 0):?>
		$('#navlight_left_<?php echo $this->data['router_method']?>__<?php echo $_GET['id']?>').addClass('active');
	<?php else:?>
		$('#navlight_left_<?php echo $this->data['router_method']?>__<?php echo $this->data['_breadcrumb'][2]['id']?>').addClass('active');
	<?php endif?>
<?php endif?>
</script>
<?php endif?>
