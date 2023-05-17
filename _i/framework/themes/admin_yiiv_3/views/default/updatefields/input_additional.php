<?php // 這裡是模組欄位必要的程式碼?>
<?php $kk = $this->data['vv_type_kk']?>
<?php $vv = $this->data['vv_type_vv']?>

<?php if(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'js'):?>

<?php
		$tmp = <<<XXX
$('#{$kk}_anchor').toggle(
	function(){
		$('#{$kk}_iframebr').removeClass('hide');
		$('#{$kk}_iframe').removeClass('hide');
	},function(){
		$('#{$kk}_iframebr').addClass('hide');
		$('#{$kk}_iframe').addClass('hide');
});
XXX;
?>
	<?php echo $tmp?>

<?php elseif(isset($this->data['vv_type_select']) and $this->data['vv_type_select'] == 'view'):?>
	<?php // 這裡是模組欄位(view)必要的程式碼?>
	<?php $formattr = $this->data['vv_type_formattr']?>

	<?php if(isset($vv['other']['html_start'])):?><?php echo $vv['other']['html_start']?><?php endif?>
	<input <?php echo $formattr?> <?php if(!isset($vv['attr']['type'])):?>type="text"<?php endif?> <?php if(!isset($vv['attr']['value'])):?>value="<?php echo G::a($updatecontent, 'updatecontent.'.$kk)?>"<?php endif?> />
	<a id="<?php echo $vv['attr']['id']?>_anchor" href="#" style="font-size:18px"><i class="icon-list"></i></a>
<?php 
$iframeattr = '';
if(isset($vv['iframeattr'])){
	foreach($vv['iframeattr'] as $kkk => $vvv){
		$iframeattr .= ' '.$kkk.'="'.$vvv.'" ';
	}
}
?>
	<br id="<?php echo $vv['attr']['id']?>_iframebr" class="hide" />
	<iframe class="hide" id="<?php echo $vv['attr']['id']?>_iframe" <?php if(isset($vv['other']['iframecount']) and isset($vv['other']['iframe_px_height']) and isset($vv['other']['iframe_min_height'])):?> height="<?php echo $vv['other']['iframe_min_height'] + ($vv['other']['iframe_px_height']*($vv['other']['iframecount']+1))?>" <?php endif?> <?php echo $iframeattr?> frameborder="0" /></iframe>
	<?php if(isset($vv['other']['html_end'])):?><?php echo $vv['other']['html_end']?><?php endif?>
<?php endif?>
