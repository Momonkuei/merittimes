<?php
	// 如果預設值不是這樣子，請自己依照需求去修改！！
	// 別忘了要去改save.php最下面！！

	/* 價格篩選設定 */ 
	// 2017/6/28 加入價格動態起始篩選
	//$query = $this->cidb->select('min(price) as minPrice')->where('is_enable','1')->where('price > ','0')->get('shop');
	//$tmp = $query->row_array();

	$query = $this->cidb->select('max(price_search) as maxPrice')->where('is_enable','1')->where('price_search > ','0')->get('shop');
	$tmp1 = $query->row_array();
	
	//$priceFilter_min   = ($tmp['minPrice'])?$tmp['minPrice']:0;		//區間起始
	$priceFilter_min   = 0;
	$priceFilter_max   = ($tmp1['maxPrice'])?$tmp1['maxPrice']:1000; //區間結束
	//$priceFilter_start = 300; //預選起始
	//$priceFilter_end   = 800; // 預選結束
	$priceFilter_step  = 100; //移動一格 增/減 數量
	$priceFilter_pretxt= 'NT$'; //顯示時值的前綴字

	// 預設顯示的值
	$priceFilter_start = 0; //預選起始
	$priceFilter_end   = 1000; // 預選結束

	if(isset($_SESSION['save'][$this->data['router_method'].'_filter_price']['min']) and $_SESSION['save'][$this->data['router_method'].'_filter_price']['min'] >= 0){
		$priceFilter_start = $_SESSION['save'][$this->data['router_method'].'_filter_price']['min'];
	}

	if(isset($_SESSION['save'][$this->data['router_method'].'_filter_price']['max']) and $_SESSION['save'][$this->data['router_method'].'_filter_price']['max'] >= 0){
		$priceFilter_end = $_SESSION['save'][$this->data['router_method'].'_filter_price']['max'];
	}

	$priceFilter_start = ($priceFilter_start)?($priceFilter_start):'0';
	$priceFilter_end   = ($priceFilter_end)?($priceFilter_end):'1000';
	$priceFilter_default="[".$priceFilter_start.",".$priceFilter_end."]";
?>

<div class="">		
	<section>
		<?php // 2017-06-27早上,winnie修正後，樣式就不是使用ID了，因為這個欄位極有可能會有兩個(pc版和手機版)?> 
		<div idggg="priceFilter" class="priceFilter sliderFilter" data-start="<?php echo $priceFilter_default?>" data-min="<?php echo $priceFilter_min?>" data-max="<?php echo $priceFilter_max?>" data-step="<?php echo $priceFilter_step?>" data-pretxt="<?php echo $priceFilter_pretxt?>" ></div>
		<div idggg="showPrice" class="showPrice"><span class="minPrice"></span><span class="maxPrice"></span>
			<input type="hidden" id="minPrice" class="minPrice" name="min">
			<input type="hidden" id="maxPrice" class="maxPrice" name="max">
		</div>			
	</section>
</div>

<?php if(0):?><!-- head_end:nouislider -->
	<?php if(0)://因為它有特定的位置，所以這裡不用載入?>
	<link rel="stylesheet" href="jsnouislider/nouislider.min.css">
	<?php endif?>
<?php endif?><!-- head_end:nouislider -->

<?php if(0):?><!-- body_end:nouislider -->
<script src="js_v3/nouislider/nouislider.min.js"></script>
<script type="text/javascript">
// var profilter_init = 3;
function proFilterAjax(thisobj, minValue, maxValue){
	// alert(thisobj.attr('id'));
	// profilter_init = profilter_init - 1;
	// if(profilter_init == 0){
		$.ajax({
			type: "POST",
			data: {
				'id': '<?php echo str_replace('detail','',$this->data['router_method'])?>_filter_price',							
				'data_id':<?php echo (!isset($_GET['id']))?'0':intval($_GET['id'])?>,				
				'min': minValue,
				'max': maxValue
			},
			url: 'save.php',
			success: function(response){
				if(response != ''){
					eval(response);
				}
				// location.reload();
				// window.location.href='shop_<?php echo $this->data['ml_key']?>.php';
			}
		}); // ajax
	// }
}
</script>
<?php endif?><!-- body_end:nouislider -->

<?php if(0):?><!-- body_end -->
<?php endif?><!-- body_end -->
