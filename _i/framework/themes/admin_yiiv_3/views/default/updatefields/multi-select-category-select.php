<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php
//2021/07/06 指定語系資料 by lota add
$_ml_key = $this->data['admin_switch_data_ml_key'];
if(isset($vv['other']['table_ml_key']) and $vv['other']['table_ml_key'] != ''){
	$_ml_key = $vv['other']['table_ml_key'];
}
?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php Yii::app()->clientScript->registerCoreScript('jquery.multi-select')?>

<?php
	
	$router_class = $this->data['router_class'];

	$random = $this->actionRegen(10,false);
	//echo $random.'ggggg';
	//unset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$kk]);
	//var_dump($updatecontent[$kk]);die;
	if(!empty($updatecontent[$kk])){
		foreach($updatecontent[$kk] as $kkk => $vvv){
			if(!isset($_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random])){
				$_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random] = array();
			}

			if(isset($vvv['is_selected'])){
				$_SESSION['updatefields_multi-select-category-select'][$this->data['router_class']][$random][$kkk] = '1';
			}
				
		}
	}

	$tmp = <<<XXX
// 這是多了搜尋的多選，左右各有一個搜尋欄位
// http://loudev.com
$('#{$kk}').multiSelect({
	selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
	selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
	afterInit: function (ms) {
		var that = this,
			\$selectableSearch = that.\$selectableUl.prev(),
			\$selectionSearch = that.\$selectionUl.prev(),
			selectableSearchString = '#' + that.\$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
			selectionSearchString = '#' + that.\$container.attr('id') + ' .ms-elem-selection.ms-selected';

		that.qs1 = \$selectableSearch.quicksearch(selectableSearchString)
			.on('keydown', function (e) {
				if (e.which === 40) {
					that.\$selectableUl.focus();
					return false;
				}
			});

		that.qs2 = \$selectionSearch.quicksearch(selectionSearchString)
			.on('keydown', function (e) {
				if (e.which == 40) {
					that.\$selectionUl.focus();
					return false;
				}
			});
	},
	afterSelect: function (values) {
		// alert("Select value: "+values);
		this.qs1.cache();
		this.qs2.cache();

		$.ajax({
			type: "POST",
			data: {
				'action': 'add',
				'random': '{$random}',
				'_ml_key': '{$_ml_key}',
				'id': values[0]
			},
			url: 'backend.php?r={$router_class}/updatefields_multi_select_category_select_save',
			success: function(response){
				// do nothing
				// alert(response);
				// eval(response);
			}
		}); // ajax
	},
	afterDeselect: function (values) {
		// alert("Deselect value: "+values);
		this.qs1.cache();
		this.qs2.cache();

		$.ajax({
			type: "POST",
			data: {
				'action': 'del',
				'random': '{$random}',
				'_ml_key': '{$_ml_key}',
				'id': values[0]
			},
			url: 'backend.php?r={$router_class}/updatefields_multi_select_category_select_save',
			success: function(response){
				// do nothing
				// alert(response);
				// eval(response);
			}
		}); // ajax
	}
});

$('#{$kk}_deselect_all').click(function(){
  $('#{$kk}').multiSelect('deselect_all');
  return false;
});

$("#{$kk}_itemlist_dropdown").change(function(){ 
	// alert('123');
	// var aaa = $(this).find('option:selected').attr("value"); 
	var aaa = $(this).val();

	$.ajax({
		type: "POST",
		data: {
			'random': '{$random}',
			'_ml_key': '{$_ml_key}',
			'id': aaa
		},
		url: 'backend.php?r={$router_class}/updatefields_multi_select_category_select_dropdown',
		success: function(response){
			// alert(response);
			// eval(response);

			$('#{$kk}').html(response);
			$('#{$kk}').multiSelect('refresh');
			
			$.ajax({
				type: "POST",
				data: {
					'random': '{$random}',
					'action': 'get',
					'_ml_key': '{$_ml_key}',
					'id': 0
				},
				url: 'backend.php?r={$router_class}/updatefields_multi_select_category_select_save',
				success: function(response){
					$('#{$kk}').multiSelect('select', response);
				}
			}); // ajax
		}
	}); // ajax
}); 

XXX;
?>
	<?php echo $tmp?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>

<?php
	$table_type = 'producttype';
	if(isset($vv['other']['table_type']) and $vv['other']['table_type'] != ''){
		$table_type = $vv['other']['table_type'];
	}	

	// $table = 'product';
	// if(isset($vv['other']['table']) and $vv['other']['table'] != ''){
	// 	$table = $vv['other']['table'];
	// }

	// // 判斷目前ID的層數 lota 2016/5/8
	if(!function_exists('judge_layer_g')){
		function judge_layer_g($pid = 0,$k = 0, $table_type,$_switch_data_ml_key = ''){
			if($_switch_data_ml_key ==''){
				$_switch_data_ml_key = $_SESSION['auth_admin_data_ml_key'];
			}
			$cidb = Yii::app()->params['cidb'];
			if ($pid != 0){
				//$rows = $this->db->createCommand()->select('id , pid')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'" and id ='.$pid)->queryRow();
				$rows = $cidb->select('id, pid')->where('is_enable',1)->where('ml_key',$_switch_data_ml_key)->where('id',$pid)->get($table_type)->row_array();
				//echo $table_type;die;
				if(isset($rows['pid']) and $rows['pid'] != 0){
					$kk = $k + 1;				
					return judge_layer_g($rows['pid'], $kk, $table_type);			
				}else{
					$arr['pid'] = $pid;
					$arr['k'] = $k;
					return $arr;
				}
			}else{
				$arr['pid'] = $pid;
				$arr['k'] = $k;
				return $arr;
			}
		}
	}

	// // 取得所有樹狀資料
	//$rows = $this->db->createCommand()->select('*, pid AS parent_id')->from($this->def['table'])->where('is_enable=1 and ml_key="'.$this->data['admin_switch_data_ml_key'].'"')->order('sort_id')->queryAll();
	$rows = $this->cidb->select('*, pid AS parent_id')->where('is_enable',1)->where('ml_key',$_ml_key)->order_by('sort_id')->get($table_type)->result_array();
	$tree = new Tree();
	$bbb = array();
	$current_row = array();
	$rows_ids = array();
	$bigid = 99999;

	if($rows){
		foreach($rows as $k => $v){
			// 要轉換一下
			$v['parentid'] = $v['pid'];
			
			//判斷目前ID的層數
			$ggg = judge_layer_g($v['id'], 0, $table_type,$_ml_key);
			$now_layer = $ggg['k'] + 1;
			
			$bbb[$v['id']] = $v;

		}

	}

	// 因為換回原本舊的Tree Class，所以特地加上這一段
	foreach($bbb as $k => $v){
		if(!isset($v['parentid'])){
			$v['parentid'] = 0;
		}
		$v['parent_id'] = $v['parentid']; // 轉換一下，因為Tree class的運算是用parent_id這個欄位名稱
		$bbb[$k] = $v;
	}

	$tree->init($bbb);

	// $str = "<div style='\$current2\$current_pid2'>\$spacer <a href='\$menu_url\$id'>\$name</a> \$add \$current \$current_pid \$more </div>";
	$str = "<option value='\$id'>\$spacer \$name</option>";
	$_render_tree = $tree->get_tree('0', $str);
?>

	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<select id="<?php echo $kk?>_itemlist_dropdown" class='form-control input select2me'>
		<option>請選擇分類</option>
		<?php echo $_render_tree?>
	</select>

	<p></p>

	<?php // form_component.html \ Multiple Select \ Searchable ?>
	<select multiple="multiple" <?php echo $formattr?> >
	<?php if(!empty($updatecontent[$kk])):?>
		<?php foreach($updatecontent[$kk] as $kkk => $vvv):?>
		<?php if(isset($vvv['is_selected']))://2021-06-30 為了大資料的載入速度，改為只顯示已選擇的選項 by lota?>
			<option value="<?php echo $kkk?>" <?php if(isset($vvv['is_selected'])) echo $vvv['is_selected']?> ><?php echo $vvv['value']?></option>
		<?php endif?>
		<?php endforeach?>
	<?php endif?>
	</select>
<?php endif?>
