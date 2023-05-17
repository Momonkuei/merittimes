<?php if(0)://暫時先不套?>
<div class="pro_des"><?php // echo $rowCat->description?></div>
<?php endif?>

<div class="product_box">
	<?php if(isset($data[$ID])):?>
		<?php foreach($data[$ID] as $k => $v):?>
			<div class="pro">
				<div class="proimgfix"><a href="<?php echo $v['url1']?>"><img src="<?php echo $v['pic']?>" alt="<?php echo $v['img_alt']?>" border="0"/></a></div>
				<div class="prolist_description">
					<div class="pro_name"><a href="<?php echo $v['url1']?>"><?php echo $v['name2']?></a></div>
					<?php if(isset($v['url3']) and $v['url3'] != ''):?>
						<a href="<?php echo $v['url3']?>" class="InquirySel"><img src="ctt/images/ico_inquiry.gif" border="0" alt="inquiry" /></a>
					<?php endif?>
				</div>
			</div>
		<?php endforeach?>
	<?php endif?>
</div>
