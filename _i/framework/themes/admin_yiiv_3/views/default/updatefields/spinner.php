<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

		<?php Yii::app()->clientScript->registerCoreScript('jquery.spinner')?>
<?php //echo G::a($updatecontent, 'updatecontent.'.$kk).'ggg'.$kk?>
<?php
	$max = '999';
	if(isset($vv['attr']['maxlength'])){
		$max = str_repeat('9',$vv['attr']['maxlength']);
	}
	$tmp = <<<XXX
$('#{$kk}').spinner({min: 0, max: $max});
//$('#spinner2').spinner({disabled: true});
//$('#spinner3').spinner({value:0, min: 0, max: 10});
//$('#spinner4').spinner({value:0, step: 5, min: 0, max: 200});

XXX;
?>

<?php echo $tmp?>


<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php // form_component.html \ Spinners \ Spinner1 ?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>

	<div id="<?php echo $vv['attr']['id']?>" <?php if(isset($vv['attr']['style'])):?> style="<?php echo $vv['attr']['style']?>" <?php endif?> >
	   <div class="input-group input-small">
		  <input type="text" class="spinner-input form-control" <?php if(!isset($vv['attr']['maxlength'])):?> maxlength="10" <?php else:?>  maxlength="<?php echo $vv['attr']['maxlength']?>" <?php endif?> name="<?php echo $vv['attr']['name']?>" value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>" />
	      <div class="spinner-buttons input-group-btn btn-group-vertical">                   
	   	  <button type="button" class="btn spinner-up btn-xs blue">                       
	   	  <i class="icon-angle-up"></i>                    
	   	  </button>                     
	   	  <button type="button" class="btn spinner-down btn-xs blue">                        
	   	  <i class="icon-angle-down"></i>                     
	   	  </button>                  
	      </div>
	   </div>
	</div>

	<?php if(0):?>
		<span class="help-block">
		basic example
		</span>
	<?php endif?>

	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>

<?php endif?>
