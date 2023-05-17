<?php
/*
 * 2018-07-18
 */

// 預設四個參數都是空白，使用前，請確定其它洞裡面，沒有$p1的變數，不然會被覆寫
$p1 = ''; // Bbox_1c, Bbox_view_full (滿版)

if(isset($_params_) and isset($_params_['p1']) and $_params_['p1'] != ''){
	$p1 = $_params_['p1'];
}
?>

<?php echo $__?>
<div class="<?php echo $p1?>">
	<div>
		<div>
			<?php echo $__?>
		</div>
	</div>
</div>			

<?php if(0):// 這個洞，是拿來放$側邊選單的，並且把它隱藏?>
	<?php echo $__?>
<?php endif?>
