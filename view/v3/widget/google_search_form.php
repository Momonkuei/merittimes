<div id="cse_searchForm" class="searchForm popBox">
	<div class="closeSpace closeBtn" data-target="#cse_searchForm"></div>
	<div class="boxContent">
		<a href="" class="closeBtn" data-target="#cse_searchForm"><i class="fa fa-check" aria-hidden="true"></i> <?php echo t('CLOSE','en')?></a>
		<div class="mainContent">
			<form id="googleSearchForm" onsubmit="">
			    <input type="text" id="googleSearchInput" size="25" autocomplete="off"/>
			    <button type="submit"><?php echo t('SEARCH','en')?></button>
				<gcse:searchresults-only></gcse:searchresults-only>
			</form>
		</div>
	</div>
</div>

<?php if(0):?><!-- body_end -->
	<!-- google search start-->
	<script type="text/javascript">  
	  function executeQuery() {
		var input = document.getElementById('googleSearchInput');
		var element = google.search.cse.element.getElement('searchresults-only0');
		if (input.value == '') {
		  element.clearAllResults();
		} else {
		  element.execute(input.value);
		}
		return false;
	  }
	  $('#googleSearchForm').on('submit',function(){
		return executeQuery();
	  });

	  (function() {
		<?php include _BASEPATH.'/../_i/config/google.php'?>
		var cx = '<?php echo $google_search_cse_cx?>';
		var gcse = document.createElement('script');
		gcse.type = 'text/javascript';
		gcse.async = true;
		gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(gcse, s);
	  })();
	</script>
	<!-- google search end-->
<?php endif?><!-- body_end -->
