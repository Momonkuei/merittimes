<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

		<?php Yii::app()->clientScript->registerCoreScript('jquery.multi-select')?>
<?php
		$tmp = <<<XXX
// 這是一般般的多選，有左右兩邊
//$('#{$kk}').multiSelect();

// 這是多了搜尋的多選，左右各有一個搜尋欄位
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
	afterSelect: function () {
		this.qs1.cache();
		this.qs2.cache();
	},
	afterDeselect: function () {
		this.qs1.cache();
		this.qs2.cache();
	}
});

XXX;
?>
<?php echo $tmp?>


<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php // form_component.html \ Multiple Select \ Searchable ?>
	<select multiple="multiple" <?php echo $formattr?> >
	<?php if(!empty($updatecontent[$kk])):?>
		<?php foreach($updatecontent[$kk] as $kkk => $vvv):?>
		<option value="<?php echo $kkk?>" <?php if(isset($vvv['is_selected'])) echo $vvv['is_selected']?> ><?php echo $vvv['value']?></option>
		<?php endforeach?>
	<?php endif?>
	</select>
<?php endif?>
