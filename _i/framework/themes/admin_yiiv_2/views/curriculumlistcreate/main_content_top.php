<?php
$product_article_maincontenttop = <<<XXX1
	var ahref = $('.shortcuts-edit a').attr('href');
	$('.shortcuts-edit a').attr('href', ahref+'-v{$random_id}');
	$('#main').attr('class', 'grid_11');
	$('#main .title').addClass('none');
XXX1;
Yii::app()->clientScript->registerScript('product_article_maincontenttop', $product_article_maincontenttop, CClientScript::POS_END);
?>
