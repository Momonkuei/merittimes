<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'update_run_other_element'):?>
	<?php
		if(isset($array[$kk]) and count($array[$kk]) > 0){
			$array[$kk] = ','.implode(',', $array[$kk]).',';
		} else {
			$array[$kk] = '';
		}
	?>
<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'create_run_other_element'):?>
	<?php
		if(isset($array[$kk]) and count($array[$kk]) > 0){
			$array[$kk] = ','.implode(',', $array[$kk]).',';
		} else {
			$array[$kk] = '';
		}
	?>
<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php Yii::app()->clientScript->registerCoreScript('jquery.treeselect')?>
	<?php
		$tmp = <<<XXX
$('#{$vv['attr']['id']}').treeselect();
XXX;
?>
<?php echo $tmp?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

<?php 
/*
<select multiple="multiple" id="productGroup" name="productGroupen">
    <option value="1" selected="selected">Group 1</option>
    <option value="2" data-parent="1">Group 2</option>
    <option value="3" data-parent="2">Group 3</option>
    <option value="4">Group 4</option>
    <option value="5">Group 5</option>
</select>
 */

/*

取消$vv['other']['default']的使用

array(
	array(
		'id' => 3,
		'pid' => 2,
		'name' => 'ggg',
		'is_selected' => '1',
	),
)

 */
?>
		<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>

		<select  <?php echo $formattr?>  multiple="multiple" >
			<?php $relation = array()?>

			<?php $id = 'id'?>
			<?php $pid = 'pid'?>
			<?php $topic = 'name'?>
			<?php $is_selected = 'is_selected'?>

			<?php if(isset($vv['other']['id']) and $vv['other']['id'] != ''):?><?php $id = $vv['other']['id']?><?php endif?>
			<?php if(isset($vv['other']['pid']) and $vv['other']['pid'] != ''):?><?php $pid = $vv['other']['pid']?><?php endif?>
			<?php if(isset($vv['other']['name']) and $vv['other']['name'] != ''):?><?php $topic = $vv['other']['name']?><?php endif?>
			<?php if(isset($vv['other']['is_selected']) and $vv['is_selected'] != ''):?><?php $is_selected = $vv['other']['is_selected']?><?php endif?>

			<?php if(!isset($updatecontent[$kk]) or !is_array($updatecontent[$kk])):?>
				<?php $relation = array()?>
			<?php else:?>
				<?php $relation = $updatecontent[$kk]?>
			<?php endif?>

			<?php if(!is_array($relation) and $relation == ''):?>
			<?php endif?>

			<?php if(count($relation) > 0):?>
				<?php foreach($relation as $kkk => $vvv):?>
					<option value="<?php echo $vvv[$id]?>" 

					<?php if(isset($vvv[$is_selected]) and $vvv[$is_selected] == '1'):?>
						 selected="selected"
					<?php endif?>

					<?php if(isset($vvv[$pid]) and $vvv[$pid] > 0):?>
						data-parent="<?php echo $vvv[$pid]?>"
					<?php endif?>
					><?php echo $vvv[$topic]?></option>
				<?php endforeach?>
			<?php endif?>
		</select>

		<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>

<?php endif?>
