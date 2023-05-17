<?php if(isset($data[$ID])):?>
	<?php foreach($data[$ID] as $k => $v):?>
		<div class="down2">
			<div class="down2_pic"><a href="<?php echo $v['url1']?>"><img src="<?php echo $v['pic']?>" width="130" height="130" border="0" /><br /></a></div>
			<div class="down2_des">
				<div class="down2_name"><a href="<?php echo $v['url2']?>"><?php echo $v['name']?></a></div>
				<p>
					<small><? //substr($row->Active_Date,0,10)?></small>
					類型:<?php echo $v['file_type']?>  
<?php if(0):?>
					大小:<?=number_format($d_size =($row->download_size )/1000)?>KB
<?php endif?>
				</p>
				<a href="<?php echo $v['url2']?>"><img src="ctt/images/temp_a/ico_download.png" border="0" style=" float:right"/></a>
			</div>
		</div>
	<?php endforeach?>
<?php endif?>
