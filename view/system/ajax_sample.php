<br /><br />
下拉範本(Sample1)：
<?php
// $rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('sample1')->result_array();
// $rows = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('type','sample1')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
$rows = array(
	array(
		'id' => 1,
		'name' => 'aaa',
	),
	array(
		'id' => 2,
		'name' => 'bbb',
	),
);
?>
<select id="sample1_">
    <option value="">請選擇</option>
	<?php if($rows):?>
		<?php foreach($rows as $k => $v):?>
			<option value="<?php echo $v['id']?>" <?php if(isset($_SESSION['save']['sample1']['sample1_id']) and $_SESSION['save']['sample1']['sample1_id'] == $v['id']):?> selected="selected"<?php endif?> ><?php echo $v['name']?></option>
		<?php endforeach?>
	<?php endif?>
</select>
<?php if(0):?><!-- body_end -->
<script type="text/javascript">
	$('body').on('change','#sample1_',function(){
		$.ajax({
			type: "POST",
			data: {
				'id': 'sample1',
				'sample1_id': $(this).val()
			},
			url: 'save.php',
			success: function(response){
				location.reload();
			}
		}); // ajax
	});
</script>
<?php endif?><!-- body_end -->

<br /><br />
文字欄位範本(Sample2)：
<div class="sample2">
	<input type="text" placeholder="請輸入關鍵字" value="<?php if(isset($_SESSION['save']['sample2']['sample2_value']) and $_SESSION['save']['sample2']['sample2_value'] != ''):?><?php echo $_SESSION['save']['sample2']['sample2_value']?><?php endif?>" />
</div>
<?php if(0):?><!-- body_end -->
<script type="text/javascript">
	$('.sample2 input[type=text]').change(function(){
		<?php // http://stackoverflow.com/questions/13833204/how-to-set-a-js-object-property-name-from-a-variable?>
		var jsonvariable = {};
		jsonvariable['id'] = 'sample2';
		jsonvariable['sample2_value'] = $(this).val();

		$.ajax({
			type: "POST",
			data: jsonvariable,
			url: 'save.php',
			success: function(response){
				location.reload();
			}
		}); // ajax
	});
</script>
<?php endif?><!-- body_end -->

<br /><br />
multi checkbox(Sample3)：
<?php 
$sample3 = array();
if(isset($_SESSION['save']['sample3']['sample3_ids']) and $_SESSION['save']['sample3']['sample3_ids'] != ''){
	$sample3 = explode('，',$_SESSION['save']['sample3']['sample3_ids']);
}
// $rows = $this->cidb->where('is_enable',1)->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('sample3')->result_array();
// $rows = $this->cidb->select('*,topic as name')->where('is_enable',1)->where('type','sample3')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
$rows = array(
	array(
		'id' => 1,
		'name' => 'aaa',
	),
	array(
		'id' => 2,
		'name' => 'bbb',
	),
);
?>
<div class="sample3">
	<?php if($rows):?>
		<?php foreach($rows as $k => $v):?>
			<div><input type="checkbox" id="sample3_<?php echo $k?>" value="<?php echo $v['id']?>" <?php if(in_array($v['id'],$sample3)):?> checked="checked" <?php endif?> ><label for="sample3_<?php echo $k?>"><?php echo $v['name']?></label></div>
		<?php endforeach?>
	<?php endif?>
</div>
<?php if(0):?><!-- body_end -->
<script type="text/javascript">
// https://www.nicesnippets.com/blog/jquery-get-all-checked-checkbox-values-in-array
$('body').on('change','.sample3 input[type=checkbox]',function(){
	var selected = new Array();
	$(".sample3 input[type=checkbox]:checked").each(function () {
		selected.push(this.value);
	});

	// Debug
	//if (selected.length > 0) {
	//	alert("Selected values: " + selected.join(","));
	//}

	var thisobj = $(this);
	//var field1 = thisobj.attr('name');
	//var field2 = thisobj.val();
	var field1 = 'sample3_ids';
	var field2 = selected.join("，");

	var json = {};
	json['id'] = 'sample3';
	//json['primary_key'] = thisobj.val();
	json[field1] = field2;

	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

<br /><br />
checkbox(Sample4)：
<div class="sample4">
	<label><input type="checkbox" name="sample4" value="1" <?php if(isset($_SESSION['save']['sample4']['sample4_id']) and $_SESSION['save']['sample4']['sample4_id'] == '1'):?> checked="checked" <?php endif?> />  <span>請勾選</span> </label>
</div>
<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('click','.sample4 input[type=checkbox]',function(){
	var sample4_id = '';
	if($('.sample4 input[type=checkbox]').is(':checked')){
		sample4_id = $('.sample4 input[type=checkbox]:checked').val();
	}
	$.ajax({
		type: "POST",
		data: {
			'id': 'sample4',
			'sample4_id':sample4_id
		},
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

<br /><br />
radio(Sample5)：
<?php
// $rows = $this->cidb->where('is_enable',1)->where('type','sample5')->where('ml_key',$this->data['ml_key'])->order_by('sort_id')->get('html')->result_array();
$rows = array(
	array(
		'id' => 1,
		'name' => 'aaa',
	),
	array(
		'id' => 2,
		'name' => 'bbb',
	),
);
?>
<div class="sample5">
	<?php if($rows):?>
		<?php foreach($rows as $k => $v):?>
			<label> <input type="radio" name="sample5_id" value="<?php echo $v['id']?>" <?php if(isset($_SESSION['save']['sample5']['sample5_id']) and $_SESSION['save']['sample5']['sample5_id'] == $v['id']):?> checked="checked" <?php endif?> > <span><?php echo $v['name']?></span> </label>
		<?php endforeach?>
	<?php endif?>
</div>
<?php if(0):?><!-- body_end -->
<script type="text/javascript">
$('body').on('change','.sample5 input[type=radio]',function(){
	var thisobj = $(this);
	var field1 = thisobj.attr('name');
	var field2 = thisobj.val();
	var json = {};
	json['id'] = 'sample5';
	//json['primary_key'] = thisobj.val();
	json[field1] = field2;
	$.ajax({
		type: "POST",
		data: json,
		url: 'save.php',
		success: function(response){
			location.reload();
		}
	}); // ajax
});
</script>
<?php endif?><!-- body_end -->

<?php if(0):?>
<!-- 詢問車新流程
<a href="javascript:;" class="itemAddCart addItemAddCart"><i class="fa fa-info-circle"></i> <span>加入詢問車</span></a>
-->
<?php endif?>
<script src="js_v3/toast/toast.min.js" m="body_end"></script>
<script text="text/javascript" m="body_end">
	$(".addItemAddCart").click(function(){	
	var _href = $(this).attr('href');		
	var _name = $(this).data('name');
	var _text1 = t.get('已加入詢問車','tw');	
	var _text2 = t.get('請點選這裡前往詢問車','tw');	
	// var _mod = '<?php echo $this->data['router_method'];?>';
	$.get(_href).done(function( data ) {
		$.toast({
		    heading:_name+' <br/>'+_text1,
		    // text:'<a href="'+_mod+'inquiry_'+ml_key+'.php">'+_text2+'</a>',
		    text:'<a href="productinquiry_'+ml_key+'.php">'+_text2+'</a>',
		    icon:'success',
		    loader:false,
		    hideAfter: 5000,
		    allowToastClose: true,
		    position: {
		      right:15,
		      bottom:30
		    }
		  });
		// $(".inquiry_info").attr('href',_mod+'inquiry_'+ml_key+'.php').show();		   
		$(".inquiry_info").attr('href','productinquiry_'+ml_key+'.php').show();		   
	});		 
	return false;
	});
</script>
