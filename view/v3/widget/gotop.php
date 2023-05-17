<a id="gotop" class="gotop">
	<i class="fa fa-chevron-up"></i>
	<img src="images/<?php echo $this->data['ml_key']?>/gotop.svg">
</a>

<?php
//判斷SESSION是否有詢問資料，如有則顯示提示連結 by lota
if(isset($_SESSION['save'])){
	$_row = $_SESSION['save'];
}
//var_dump($_row);
$_inquiry = array();
if(isset($_row)){
	foreach ($_row as $key => $value) {
		if(preg_match('/^(.*)inquiry$/', $key, $matches)){
			$_count_key = count($value);
			if($_count_key > 0){
				$_check_ml_key = false;
				foreach ($value as $key1 => $value1) {
					if($value1['ml_key'] == $this->data['ml_key']){
						$_check_ml_key = true;
					}
				}
				if($_check_ml_key){
					$_inquiry[] = $matches[1];
				}					
			}					
		}
	}
}
$_count_inquiry = count($_inquiry);
?>
<?php if($_count_inquiry > 0):?>
	<?php foreach ($_inquiry as $key => $value):?>
		<a class="inquiry_info" href="<?php echo $value?>inquiry_<?php echo $this->data['ml_key']?>.php"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo t('詢問車','tw')?></a>
	<?php endforeach?>
<?php else:?>
	<a class="inquiry_info" href="" style="display:none"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo t('詢問車','tw')?></a>
<?php endif?>
