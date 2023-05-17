<?php if($product and count($product) > 0):?>
	<?php foreach($product as $k => $v):?>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" id="product_and_service">
			<tbody>
				<tr>
					<td valign="top" align="left" height="3"></td>
					<td height="3"></td>
					<td valign="top" align="left" height="3"></td>
				</tr>
				<tr>
					<td width="168" valign="top" align="left">
						<img width="168" height="107" src="<?php echo $v['pic1']?>">

						<?php if(isset($product_tmp[$v['id']]) and count($product_tmp[$v['id']]) > 0):?>
							<p></p>
							<?php foreach($product_tmp[$v['id']] as $kk => $vv):?>
								<img width="45" height="45" src="<?php echo vir_path_c.$vv?>">
							<?php endforeach?>
						<?php endif?>
					</td>
					<td width="25">&nbsp;</td>
					<td valign="top" align="left">
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
									<td align="left" height="25"><?php echo $v['name']?></td>
								</tr>
								<tr>
									<td height="12"></td>
								</tr>
								<tr>
									<td valign="top" align="left"><?php echo nl2br($v['detail'])?></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left">&nbsp;</td>
					<td>&nbsp;</td>
					<td valign="top" align="left">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	<?php endforeach?>
<?php endif?>
