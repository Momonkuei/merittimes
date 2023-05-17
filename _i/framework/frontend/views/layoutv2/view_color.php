<?php

$color1 = '003D79';
$color2 = 'FFAC55';
$color3 = '895117';

if(isset($this->data['layoutv2_param'][$this->data['section']['key']][1])){
	$color1 = $this->data['layoutv2_param'][$this->data['section']['key']][1];
}

if(isset($this->data['layoutv2_param'][$this->data['section']['key']][2])){
	$color2 = $this->data['layoutv2_param'][$this->data['section']['key']][2];
}

if(isset($this->data['layoutv2_param'][$this->data['section']['key']][3])){
	$color3 = $this->data['layoutv2_param'][$this->data['section']['key']][3];
}

$content = <<<XXX
\$cis-color-1: #$color1;
\$cis-color-2: #$color2;
\$cis-color-3: #$color3;
XXX;
//echo $content;
//die;

file_put_contents(_BASEPATH.'/../html/a/css/php.scss', $content);
?>
<div class="[OTHER]" [STYLEPOS1] >
[POS1]
</div>
