<?php
/*
 * 將這個區塊放到任何位置，就可以啟用Dom(V1)的Ajax的模式
 * 除此之外，不需要做任何其它的事
 * 2017-10-23 13:17 有跟李哥講解過這個功能
 */
?>

<?php if(0):?><!-- body_end -->
<script type="text/javascript">
	$(document).ready(function() {
		$('*[m=multi]').each(function(index, element){
			var ms = $(this).attr('ms');
			var thishtml = $(this).html();
			$.ajax({
				type: "POST",
				data: {
					'html': thishtml,
					'ms': ms
				},
				url: 'dom2.php',
				// url: 'http://customer.web.buyersline.com.tw/dom2.php',
				success: function(response){
					$('*[m=multi]').eq(index).html(response);
				}
			}); // ajax
		});

		$('*[d^="table"]').each(function(index, element){
			var ms = $(this).attr('d');
			var thishtml = $(this)[0].outerHTML;
			var thisobj = $(this);
			$.ajax({
				type: "POST",
				data: {
					'html2': thishtml,
					'ms': ms,
					'index': index
				},
				url: 'dom2.php',
				// url: 'http://customer.web.buyersline.com.tw/dom2.php',
				success: function(response){
					eval(response);
				}
			}); // ajax
		});
	});
</script>
<?php endif?><!-- body_end -->
