<?php

// 請參考w/winnie/RWDProject/ProjectC/Web/common/pagewidget.php
$group_struct = array(
	array(
		'hole' => array(
			// 購物
			//$widgetName='sideAD'; include 'common_widget.php'; 
			//$widgetName='sideCart'; include 'common_widget.php'; 
			//$widgetName='showCart'; include 'common_widget.php'; 
			//$widgetName='addCartPanel'; include 'common_widget.php'; 
			array('file' => 'v3/widget/login_panel'),
			array('file' => 'v3/widget/side_cart'),
			array('file' => 'v3/widget/side_ad'),
			array('file' => 'v3/widget/show_cart'),

			// array('file' => 'v3/widget/add_cart_panel'), // 其它的在共用的
			// array('file' => 'v3/widget/add_cart_panel'), // checkout/step1在用的，如果你不用，那就不要丟資料給它就沒事了~呵
		),
	),
);
