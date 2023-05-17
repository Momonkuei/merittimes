<?php if(isset($pageinfo) and count($pageinfo) > 0):?>
<div class="col-md-12 text-center">
	<nav class="hidden-xs hidden-sm">
		<ul class="pagination">
			<?php if($pageinfo['pagination']['control']['prev'] != ''):?>
			<li><a href="<?php echo $pageinfo['pagination']['control']['first']?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
			<?php endif?>

			<?php foreach($pageinfo['pagination']['number'] as $k => $v):?>
				<?php if($v['name'] == $pageinfo['pagination']['control']['now']):?>
					<li class="active"><a href="javascript:;"><?php echo $v['name']?></a></li>
				<?php else:?>
					<li><a href="<?php echo $v['link']?>"><?php echo $v['name']?></a></li>
				<?php endif?>
			<?php endforeach?>

			<?php if($pageinfo['pagination']['control']['next'] != ''):?>
			<li><a href="<?php echo $pageinfo['pagination']['control']['next']?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
			<?php endif?>
		</ul>
	</nav>
	<nav>
		<ul class="pager">
			<?php if($pageinfo['pagination']['control']['prev'] != ''):?>
				<li class="previous"><a href="<?php echo $pageinfo['pagination']['control']['first']?>"><span aria-hidden="true">&larr;</span> Older</a></li>
			<?php else:?>
				<li class="previous disabled"><a href="javascript:;"><span aria-hidden="true">&larr;</span> Older</a></li>
			<?php endif?>

			<?php if($pageinfo['pagination']['control']['next'] != ''):?>
				<li class="next"><a href="<?php echo $pageinfo['pagination']['control']['next']?>">Newer <span aria-hidden="true">&rarr;</span></a></li>
			<?php else:?>
				<li class="next disabled"><a href="javascript:;">Newer <span aria-hidden="true">&rarr;</span></a></li>
			<?php endif?>
		</ul>
	</nav>
</div>
<?php endif?>

<?php if(isset($pageinfo) and count($pageinfo) > 0 and 0):?>
<div class="page">
<table border="0" align="center" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<?php if($pageinfo['pagination']['control']['first'] != ''):?>
			<td valign="middle" style="display:none"><a title="最前頁" href="<?php echo $pageinfo['pagination']['control']['first']?>"><img border="0" width="26" height="26" onmouseout="this.src='images/_pagi/news_30.jpg'" onmouseover="this.src='images/_pagi/newsb_30.jpg'" src="images/_pagi/news_30.jpg"></a></td>
			<?php endif?>

			<td width="4" valign="middle">&nbsp;</td>

			<?php if($pageinfo['pagination']['control']['prev'] != ''):?>
			<td align="left" width="30" valign="middle"><a style="border:0" title="前一頁" href="<?php echo $pageinfo['pagination']['control']['first']?>"><img border="0" widthg="26" heightg="26" onmouseoutg="this.src='images/_pagi/news_32.jpg'" onmouseoverg="this.src='images/_pagi/newsb_32.jpg'" src="images/ico_prev.png"></a></td>
			<?php endif?>

			<td align="center" valign="middle" height="20">
				<?php foreach($pageinfo['pagination']['number'] as $k => $v):?>
					<?php if($v['name'] == $pageinfo['pagination']['control']['now']):?>
						<span class="newslist03Copy"><?php echo $v['name']?></span>
					<?php else:?>
						<span class="newslist03"><a class="newslist03go" title="<?php echo $v['name']?>" href="<?php echo $v['link']?>"><?php echo $v['name']?></a></span>
					<?php endif?>
				<?php endforeach?>
			</td>

			<?php if($pageinfo['pagination']['control']['next'] != ''):?>
			<td align="right" width="30" valign="middle"><a style="border:0" title="後一頁" href="<?php echo $pageinfo['pagination']['control']['next']?>"><img border="0" widthg="26" heightg="26" onmouseoutg="this.src='images/_pagi/news_34.jpg'" onmouseoverg="this.src='images/_pagi/newsb_34.jpg'" srcg="images/_pagi/news_34.jpg" src="images/ico_next.png"></a></td>
			<?php endif?>

			<td width="4" valign="middle">&nbsp;</td>

			<?php if($pageinfo['pagination']['control']['last'] != ''):?>
			<td valign="middle" style="display:none"><a title="最後頁" href="<?php echo $pageinfo['pagination']['control']['last']?>"><img border="0" width="26" height="26" onmouseout="this.src='images/_pagi/news_36.jpg'" onmouseover="this.src='images/_pagi/newsb_36.jpg'" src="images/_pagi/news_36.jpg"></a></td>
			<?php endif?>
		</tr>
	</tbody>
</table>
</div>
<div class="page2">
共找到 <b><?php echo $pageinfo['pagination']['total']?></b> 筆符合  第<?php echo $pageinfo['pagination']['control']['now']?>/<?php echo $pageinfo['pagination']['number'][count($pageinfo['pagination']['number'])-1]['name']?>頁
</div>
<?php endif?>

<?php if(0):?>
	<div class="col-md-12 text-center">
		<nav class="hidden-xs hidden-sm">
			<ul class="pagination">
				<li><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
			</ul>
		</nav>
		<nav>
			<ul class="pager">
				<li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Older</a></li>
				<li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>
			</ul>
		</nav>
	</div>
<?php endif?>
