<script type="text/javascript">
$(document).ready(function() {
	$('.btn-large').after("&nbsp;<a href=\"<?php echo $class_url?>/export\" class=\"btn btn-large\">匯出</a>");
});
</script>

<?php if(!empty($classes)):?>
    <label for="class_id" style="width:40%;float:left;">
	功能列表:<select onchange="document.location.href='<?php echo $class_url?>/index&param=<?php echo $parameter['value']?>' + this.value;" id="class_id" name="class_id">
	<option value=""><?php G::te(null, 'Please Select', array(), '請選擇')?></option>
	<?php foreach($classes as $k => $v):?>
	<option value="<?php echo $v?>" <?php if($class_id == $v):?>selected<?php endif?> ><?php echo $v?></option>
	<?php endforeach?>
    </select></label>
<?php endif?>

<style type="text/css">
#datatable_length{
width:20%;
}
#datatable_filter{
width:30%;
}
</style>
