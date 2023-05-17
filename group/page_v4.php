<?php

// 2020-07-29
// 當遇到左右、連絡我們、或是編排頁的情況，它們的上一層就是這裡
$group_struct = array(
	array(
		'file' => 'htmltags___div',
		'params' => array(
			'htmltags_1' => 'div',
			'class' => 'XXXContent',
		),
		'hole' => array(
			array(
				'hole' => array(
					array(
						'file' => 'htmltags___div',
						'params' => array(
							'htmltags_1' => 'div',
							'class' => 'container',
						),
						'hole' => array(
							array('file' => 'v4/widget/breadcrumb'),
						),
					),
					array('file' => '// HOLE'),
					// 因為連絡我們，和模組編排頁的sectionBlock與container，只是其中一個區塊而以

					array('file' => 'v4/widget/pageNumber'), // 分頁
				),
			),
		),
	),
);
