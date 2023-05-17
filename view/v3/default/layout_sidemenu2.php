<?php
/*
 * 2018-03-12 這個是整合所有側邊選單結構變化的結構
 * 
 * 沒滿版
 * 'file' => 'default/layout_sidemenu_left',   // 選單左 (1)
 * 'file' => 'default/layout_sidemenu_right',  // 選單右 (2)
 * 'file' => 'default/layout_normal',          // 無選單 (3)
 *
 * 滿版
 * 'file' => 'default/layout_sidemenu_left_full',   // 選單左 (4)
 * 'file' => 'default/layout_sidemenu_right_full',  // 選單右 (5)
 * 'file' => 'default/layout_normal_full',          // 無選單 (6)
 *
 * 因為執行的順序，所以這個layout撰寫的時候，沒有辦法用一般的邏輯撰寫
 * AA,BB,CC,DD的那些洞，只能出現一次，所以我想到用V1第二版的移動來解決這個問題
 * 2,3,5,6的部份混在一起撰寫應該沒有問題，而1,4的部份，用V1第二版的移動，應該可以解決換tag位置的問題
 *
 * 2018-04-26
 * 但這樣子的解決方式延申出新的問題，因為我讓主要區塊先執行，而不是側邊區塊，造成資料流執行順序的問題
 * 就算是排除了V1第二版的關係，如果側邊選單在右邊
 * 而且開啟 後台 / 前台主選單 / 資料表功能 / 其它選項 / 點擊分類的動作 / 遞迴顯示該層底下的物件 (含自己) *有參數
 * 問題依舊會產生，解決方式，打算建立一個空白的區塊，把側邊選單的資料流導到那裡
 */
?>
<?php
$_type = 1; // 預設選單左，沒滿版

// 後台 / LayoutV3 / 群組Group / 參數(json)所使用的
if(isset($_params_) and isset($_params_['type']) and $_params_['type'] > 0){
	$_type = $_params_['type'];
}

// 為了要讓一個群組，當做兩個群組在使用
if(isset($data[$ID]) and isset($data[$ID]['type']) and $data[$ID]['type'] > 0){
	$_type = $data[$ID]['type'];
}
?>

<?php echo $DD?>		
<?php echo $BB?>

<?php if(0):// debug?>
<?php // echo $CC?>
<?php // echo $AA?>
<?php endif?>

<?php if(in_array($_type,array(1,2,3))):?>
<div class="Bbox_1c">
<?php else:?>
<div class="Bbox_view_full">
<?php endif?>

<?php if(!in_array($_type,array(3,6))):?>
	<div>
	<?php if(in_array($_type,array(1,4))):?>
		<div class="Bbox_in_2c_L3">
	<?php elseif(in_array($_type,array(2,5))):?>
		<div class="Bbox_in_2c_L9">
	<?php endif?>
			<div>

	<?php if(in_array($_type,array(1,4))):?>
				<div class="sideMenu">
	<?php else:?>
				<div>
	<?php endif?>

<?php endif?>

<?php echo $__?>

<?php if(!in_array($_type,array(3,6))):?>
				</div>
	<?php if(in_array($_type,array(1,4))):?>
				<div>
	<?php else:?>
				<div class="sideMenu">
	<?php endif?>
<?php endif?>

<?php if(!in_array($_type,array(3,6))):?>
<?php echo $__?>
<?php endif?>

<?php if(!in_array($_type,array(3,6))):?>
				</div>

			</div>
		</div>		
	</div>
<?php endif?>

</div>	

<?php /////////////////////////////////////////////////////////////////// 底下僅參考用，沒有任何作用 ?>

<?php if(0 and $_type == 1):?>

<?php //echo $DD?>		
<?php //echo $BB?>

<div class="Bbox_1c">
	<div>	
		<div class="Bbox_in_2c_L3">
			<div>
				<div class="sideMenu">
<?php //echo $AA?>
				</div>

				<div>
<?php //echo $CC?>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php //elseif($_type == 2):?>

<?php // echo $DD?>		
<?php // echo $BB?>
<div class="Bbox_1c">
	<div>
		<div class="Bbox_in_2c_L9">
			<div>
				<div>
<?php //echo $CC?>
				</div>

				<div class="sideMenu">
<?php //echo $AA?>
				</div>
			</div>
		</div>		
	</div>
</div>	

<?php //elseif($_type == 3):?>

<?php //echo $DD?>		
<?php //echo $BB?>
<div class="Bbox_1c">
<?php //echo $CC?>
</div>			

<?php if(0)://會隱藏側邊選單，我是有作用的不要刪掉我哦?>
<?php //echo $AA?>
<?php endif?>

<?php //elseif($_type == 4):?>

<?php //echo $DD?>		
<?php //echo $BB?>
<div class="Bbox_view_full">
	<div>		
		<div class="Bbox_in_2c_L3">
			<div>
				<div class="sideMenu">
<?php //echo $AA?>
				</div>

				<div>
<?php //echo $CC?>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php //elseif($_type == 5):?>

<?php //echo $DD?>		
<?php //echo $BB?>
<div class="Bbox_view_full">
	<div>
		<div class="Bbox_in_2c_L9">
			<div>
				<div>
<?php //echo $CC?>
				</div>

				<div class="sideMenu">
<?php //echo $AA?>
				</div>
			</div>
		</div>		
	</div>
</div>	

<?php //elseif($_type == 6):?>

<?php //echo $DD?>		
<?php //echo $BB?>
<div class="Bbox_view_full">			
<?php //echo $CC?>
</div>			

<?php if(0)://會隱藏側邊選單，我是有作用的不要刪掉我哦?>
<?php //echo $AA?>
<?php endif?>

<?php endif?>

