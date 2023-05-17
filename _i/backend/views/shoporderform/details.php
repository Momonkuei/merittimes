<table cellspacing="0" cellpadding="3" border="0" width="100%" align="center">
	<tbody>
		<tr>
			<td>
				<table class="table">
					<tbody>
						<tr>
							<td width="0" valign="middle" align="center">商品編號</td>
							<td width="0" align="center">訂購商品</td>
							<td width="0" align="center">規格</td>
							<td width="0" align="center">單價</td>
							<td width="0" align="center">訂購數量</td>
							<td width="0" align="center">小計</td>
						</tr>

						<?php //$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'productshopspec',':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll()?>
						<?php
						//$specs_tmp = array();
						//if($rows){
						//	foreach($rows as $k => $v){
						//		$specs_tmp[$v['id']] = $v;
						//	}
						//}
						?>

						<?php if(isset($this->data['updatecontent']['details']['car']) and count($this->data['updatecontent']['details']['car']) > 0):?>
							<?php foreach($this->data['updatecontent']['details']['car'] as $k => $v):?>
								<tr>
									<td valign="middle" height="25" align="center"><?php echo $v['item']['id']?></td>
									<td align="center">
										<?php echo $v['item']['name']?>
										<?php if(isset($v['item']['promotion'])):?>
											　<?php echo $v['item']['promotion_name']?><?php if(isset($v['item']['promotion']['match_log']) and isset($v['promotion_id'])):?><?php echo $v['item']['promotion']['match_log']?><?php endif?>
										<?php else:?>
										<?php endif?>
									</td>
<?php if(0):?>
									<td align="center"><?php if(isset($v['specs']) and !empty($v['specs'])):?><?php foreach($v['specs'] as $kk => $vv):?><?php echo $vv['name'].':'.$vv['value']?>, <?php endforeach?><?php endif?></td>
<?php endif?>
									<td align="center"><?php if(isset($v['spec']) and $v['spec'] != ''):?><?php echo $v['spec']?><?php endif?></td>
									<td align="center">$<?php echo $v['item']['price']?></td>
									<td align="center"><?php echo $v['amount']?></td>
									<td align="center">$<?php echo $v['item']['price'] * $v['amount']?></td>
								</tr>
							<?php endforeach?>
						<?php endif?>

						<tr>
							<td valign="middle" height="25" align="center" colspan="11">
								<?php if(isset($this->data['updatecontent']['details']['calculate_logs']) and count($this->data['updatecontent']['details']['calculate_logs'])):?>
									<?php foreach($this->data['updatecontent']['details']['calculate_logs'] as $k => $v):?>
										<?php echo $v[0]?>：<?php echo $v[1]?><br />
									<?php endforeach?>
								<?php endif?>

								<?php 
									//$car = new Shoppingcar;
									//$tmp = $car->total($this->data['updatecontent']['id']);
									// 消費總金額： $<?php echo $tmp['sum']?g> + $<?gpghp echo $tmp['shipment']?g> = $<?gphp echo $tmp['total']?g>gg 元
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
