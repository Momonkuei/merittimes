<?php
/*
 * 2018-07-18
 */

// 預設四個參數都是空白，使用前，請確定其它洞裡面，沒有$p1~4的變數，不然會被覆寫
$p1 = ''; // Bbox_1c, Bbox_view_full (滿版)
$p2 = ''; // Bbox_in_2c_L3 (左側選單), Bbox_in_2c_L9 (右側選單)
$p3 = ''; // sideMenu, 或空白
$p4 = ''; // sideMenu, 或空白

for($x=1;$x<=4;$x++){
	if(isset($_params_) and isset($_params_['p'.$x]) and $_params_['p'.$x] != ''){
		eval('$p'.$x.' = $_params_["p'.$x.'"];');
	}
}
?>

<?php echo $__?>
<div class="<?php echo $p1?>">
	<div>		
		<div class="<?php echo $p2?>">
			<div>
				<div class="<?php echo $p3?>">
<?php echo $__?>
				</div>

				<div class="<?php echo $p4?>">
<?php echo $__?>
				</div>
			</div>
		</div>
	</div>
</div>	
