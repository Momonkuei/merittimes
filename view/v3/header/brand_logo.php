<?php
$url = '/index_'.$this->data['ml_key'].'.php';

// SEO
$main_ml_key = '';
if($main_ml_key != '' and $this->data['ml_key'] != $main_ml_key){
	$url = $this->data['ml_key'];
}
?>
<div class="brandLogo"><a href="<?php echo $url?>"><img src="<?php echo L::imgt('images/'.$this->data['ml_key'].'/logo.png','.png')?>"></a></div>
