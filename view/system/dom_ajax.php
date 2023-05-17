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
		$('*[dom=multi]').each(function(index, element){
			var doms = $(this).attr('doms');
			var thishtml = $(this).html();
			$.ajax({
				type: "POST",
				data: {
					'html': thishtml,
					'doms': doms
				},
				url: 'dom.php',
				// url: 'http://customer.web.buyersline.com.tw/dom.php',
				success: function(response){
					$('*[dom=multi]').eq(index).html(response);
				}
			}); // ajax
		});

		$('*[dom=single]').each(function(index, element){
			var doms = $(this).attr('doms');
			var thishtml = $(this)[0].outerHTML;
			var thisobj = $(this);
			$.ajax({
				type: "POST",
				data: {
					'html2': thishtml,
					'doms': doms,
					'index': index
				},
				url: 'dom.php',
				// url: 'http://customer.web.buyersline.com.tw/dom.php',
				success: function(response){
					eval(response);
				}
			}); // ajax
		});
	});
</script>
<?php endif?><!-- body_end -->
