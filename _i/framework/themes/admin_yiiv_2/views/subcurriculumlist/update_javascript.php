<?php
$product_article_updatejavascript = <<<XXX1
	$('#main').attr('class', 'grid_8');
	$('#sidebar').remove();
	$('#main .title').addClass('none');
XXX1;
Yii::app()->clientScript->registerScript('product_article_updatejavascript', $product_article_updatejavascript, CClientScript::POS_END);
?>
