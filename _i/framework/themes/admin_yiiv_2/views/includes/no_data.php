<?php
if(!isset($type) or $type == ''){
	$type = 'area';
}
?>

<?php if($type == 'area'):?>
<div style="width:100%;background-color: #dddddd;text-align:center;color: #909090;height:32px;"><label style="display: inline-block;height: 20px;padding-left: 5px;padding-top: 5px;">=== <?php G::te($this->data['theme_lang'], 'No data', null, '無資料')?> ===</label></div>
<?php elseif($type == 'normal'):?>
=== <?php G::te($this->data['theme_lang'], 'No data', null, '無資料')?> ===
<?php endif?>
