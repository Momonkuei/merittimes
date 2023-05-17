<?php
$rowsg = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'templatetype'))->order('sort_id asc')->queryAll();
?>
<?php // 每個頁面的開頭，都加上版型的列表，這是demo在使用的?>
<style type="text/css">
#change_template_bar {
         padding-left:1px;position:absolute;z-index:99999;background-color:#eee;
}
#change_template_bar td {
         padding-left:2px;
}
</style>
<table id="change_template_bar" border="0">
	<tr>
		<?php if($rowsg and count($rowsg) > 0):?>
			<?php foreach($rowsg as $k => $v):?>
				<td>
					<a href="change_template.php?a=<?php echo $v['other2']?>"><b><?php echo $v['topic']?></b></a>
				</td>
			<?php endforeach?>
		<?php endif?>

		<?php if(isset($_SESSION['template_rulev1_group_edit']) and $_SESSION['template_rulev1_group_edit']):?>
			<td><a href="change_template.php?a=clearedit">[清除修改]</a></td>
		<?php else:?>
			<td><a href="change_template.php?a=edit">[修改]</a></td>
		<?php endif?>

		<?php // 清掉即時換版的記錄?>
		<td><a href="change_template.php?a=clear">[清除]</a></td>

<?php if(0):?>
		<td>
			<a href="change_template.php?a=theme_rwd05"><b>RWD05</b></a>
		</td>
		<td>
			<a href="change_template.php?a=theme_rwd15"><b>RWD15</b></a>
		</td>
		<td>
			<a href="change_template.php?a=theme_rwd152"><b>RWD152</b></a>
		</td>

		<?php // 暫時關閉toolbar?>
		<td onclick="javascript:$(\'#change_template_bar\').hide();">[X]</td>
<?php endif?>

	</tr>
</table>
