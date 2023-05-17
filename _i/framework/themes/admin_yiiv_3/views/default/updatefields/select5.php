<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

	<?php // do nothing?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

<?php 

// 第一種情況
// <option>123</option>
// <option>456</option>
//
// 第二種情況
// <optgroup label="NFC EAST">
//		<option>Dallas Cowboys</option>
//		<option>New York Giants</option>
//		<option>Philadelphia Eagles</option>
//		<option>Washington Redskins</option>
// </optgroup>
?>
		<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
		<select  class="form-control input-large select2me" <?php echo $formattr?> data-placeholder="請選擇或搜尋123">
			<?php if(!empty($vv['other'])):?>
				<?php $isselectedvalue = ''?>
				<?php if($def['updatefield']['method'] == 'create'):?>
					<?php if(isset($vv['other']['default'])):?>
						<?php $isselectedvalue = $vv['other']['default']?>
					<?php endif?>
				<?php else:?>
					<?php if(isset($updatecontent[$kk])):?>
						<?php $isselectedvalue = $updatecontent[$kk]?>
					<?php endif?>
				<?php endif?>

				<?php if($isselectedvalue == ''):?>
					<?php $isselectedvalue = '0'?>
				<?php endif?>
				<?
				/*20230209 增加 最新消息單元的多檔案上傳 自動選分類功能*/ 
				if($isselectedvalue=='0' && stristr($_SESSION['funcfieldv3_router_class'],'other') && stristr($_SESSION['funcfieldv3_router_class'],'news') && isset($_SESSION[$_SESSION['funcfieldv3_router_class'].'_node'])){
					$isselectedvalue=$_SESSION[$_SESSION['funcfieldv3_router_class'].'_node']['value'];
				}?>
				<?php $tmp = false?>
				<?php if(!empty($vv['other']['values'])):?>
					<?php foreach($vv['other']['values'] as $kkk => $vvv):?>
						<?php if(!$tmp):?>
							<?php $tmp = true?>
						<?php endif?>
						<?php if(preg_match('/^xx/', $kkk) and $tmp):?>
							</optgroup>
						<?php endif?>
						<?php if(preg_match('/^xx/', $kkk)):?>
							<optgroup label="<?php echo $vvv?>">
							<?php continue?>
						<?php endif?>
						<?php if($isselectedvalue == $kkk):?>
							<option value="<?php echo $kkk?>" selected><?php echo $vvv?></option>
						<?php else:?>
							<option value="<?php echo $kkk?>"><?php echo $vvv?></option>
						<?php endif?>
					<?php endforeach?>
					<?php if(count($vv['other']['values']) > 0 and preg_match('/^xx/', $kkk)):?>
						</optgroup>
					<?php endif?>
				<?php endif?>
			<?php endif?>
		</select>
		<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
