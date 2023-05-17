<section id="main" class="grid_9 push_3">
	<article>
		<img src="<?php echo vir_path_c?>../assets/img/132763262010819155651_73.JPG" width="600" />
		<h2 style="margin-top:0px;">歡迎使用大衛美語(<?php echo $title ?>)後台管理系統</h2>
	</article>
</section>

<?php // 該分校功能選單，如果是在分校才會顯示?>
<?php echo $this->renderPartial('//includes/_function_list_menu', $this->data)?>
