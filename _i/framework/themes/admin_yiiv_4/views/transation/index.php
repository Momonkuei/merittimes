<?php 
	Yii::app()->clientScript->registerCoreScript('jquery.digits');
	//Yii::app()->clientScript->registerCoreScript('jquery.widget');
	Yii::app()->clientScript->registerCoreScript('jquery.datepicker');

	// 把欄位驗證帶過來
	$update_default_1 = $this->renderPartial('//includes/default_validate', $this->data)."\n";
	Yii::app()->clientScript->registerScript('update_default_1', $update_default_1, CClientScript::POS_END);

	//Yii::app()->clientScript->registerCoreScript('jquery.maskedinput');
?>

<?php echo $this->renderPartial('//includes/search', $this->data)?>

<div class="row-fluid">

	<?php if(count($this->data['tcofastmenus']) > 0):?>
	<div class="span10">
	<?php else:?>
	<div class="span12">
	<?php endif?>

	<div class="portlet box light-grey" style="border-style:none">

	<div class="portlet-body" style="padding:0px">

	<form id="form_data" action="<?php echo $current_url?>" method="post" name="form_data">
		<table width="98%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left" valign="top">
					<table width="100%" border="0" cellspacing="1" cellpadding="7" class="table1">
						<tbody>
							<tr class="bgcolor2">
								<td width="80" class="indexgo01">賣方帳戶</td>
								<td><?php if(!isset($updatecontent['sell_card_number'])):?><input name="sell_card_number" type="text" id="sell_card_number" value="" size="18" /><?php else:?><strong><?php echo Eobg::format_card($updatecontent['sell_card_number'])?></strong><input type="hidden" id="sell_card_number" name="sell_card_number" value="<?php echo $updatecontent['sell_card_number']?>" /><?php endif?><br />
									&nbsp;<span id="sell_company_name"><?php if(!isset($updatecontent['sell_company_name'])):?>&nbsp;<?php else:?><?php echo $updatecontent['sell_company_name']?><?php endif?></span></td>
							</tr>

<?php if(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '1'):?>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr class="bgcolor3">
								<td>&nbsp;</td>
								<td>服務費用</td>
							</tr>
							<tr class="bgcolor2">
								<td>現金</td>
								<td>
									<input name="sell_transation_cash_a" type="text" id="sell_transation_cash_a" class="inputgo01 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'sell_transation_cash_a')?>" size="12" />&nbsp;&nbsp;
									<input name="sell_transation_cash_b" type="text" id="sell_transation_cash_b" class="inputgo02 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'sell_transation_cash_b')?>" size="12" />
								</td>
							</tr>
							<tr class="bgcolor1">
								<td>交易幣</td>
								<td>
									<input name="sell_transation_eob_a" type="text" id="sell_transation_eob_a" class="inputgo01 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'sell_transation_eob_a')?>" size="12" />&nbsp;&nbsp;
									<input name="sell_transation_eob_b" type="text" id="sell_transation_eob_b" class="inputgo02 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'sell_transation_eob_b')?>" size="12" />
								</td>
							</tr>
							<tr class="bgcolor2">
								<td> 行政<br />
									交易幣收費 </td>
								<td>
									<input name="sell_administrative_eob_a" type="text" class="inputgo01 inputgo0n" id="sell_administrative_eob_a" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_eob_a')?>" size="12" />&nbsp;&nbsp;
									<input name="sell_administrative_eob_b" type="text" class="inputgo02 inputgo0n" id="sell_administrative_eob_b" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_eob_b')?>" size="12" />
								</td>
							</tr>
							<tr class="bgcolor1">
								<td> 行政現金費用 </td>
								<td>
									<input name="sell_administrative_cash_a" type="text" class="inputgo01 inputgo0n" id="sell_administrative_cash_a" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_cash_b')?>" size="12" />&nbsp;&nbsp;
									<input name="sell_administrative_cash_b" type="text" class="inputgo02 inputgo0n" id="sell_administrative_cash_b" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_cash_b')?>" size="12" />
								</td>
							</tr>
<?php elseif(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '2'):?>
								<input name="sell_transation_cash_a" type="hidden" id="sell_transation_cash_a" value="<?php Eobg::_echo($updatecontent, 'sell_transation_cash_a')?>" />
								<input name="sell_transation_cash_b" type="hidden" id="sell_transation_cash_b" value="<?php Eobg::_echo($updatecontent, 'sell_transation_cash_b')?>" />
								<input name="sell_transation_eob_a" type="hidden" id="sell_transation_eob_a" value="<?php Eobg::_echo($updatecontent, 'sell_transation_eob_a')?>" />
								<input name="sell_transation_eob_b" type="hidden" id="sell_transation_eob_b" value="<?php Eobg::_echo($updatecontent, 'sell_transation_eob_b')?>" />
								<input name="sell_administrative_eob_a" type="hidden" id="sell_administrative_eob_a" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_eob_a')?>" />
								<input name="sell_administrative_eob_b" type="hidden" id="sell_administrative_eob_b" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_eob_b')?>" />
								<input name="sell_administrative_cash_a" type="hidden" id="sell_administrative_cash_a" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_cash_b')?>" />
								<input name="sell_administrative_cash_b" type="hidden" id="sell_administrative_cash_b" value="<?php Eobg::_echo($updatecontent, 'sell_administrative_cash_b')?>" />
<?php endif?>
							<tr>
								<td height="5"></td>
								<td height="5"></td>
							</tr>
							<tr class="bgcolor2">
								<td>交易幣餘額</td>
								<td><span class="w_date" id="sell_eob_last_balance"><?php Eobg::_echo($updatecontent, 'sell_eob_last_balance')?></span></td>
							</tr>
							<tr class="bgcolor1">
								<td> 可用餘額</td>
								<td><span class="w_date" id="sell_eob_canuse_balance"><?php Eobg::_echo($updatecontent, 'sell_eob_canuse_balance')?></span></td>
							</tr>
							<tr class="bgcolor2">
								<td>費用種類</td>
								<td><span class="w_date" id="sell_card_name"><?php Eobg::_echo($updatecontent, 'sell_card_name', '&nbsp;')?></span></td>
							</tr>
<?php if(!isset($updatecontent['id'])):?>
							<tr class="bgcolor1">
								<td>新交易幣餘額</td>
								<td><span id="sell_next_eob_last_balance"><?php Eobg::_echo($updatecontent, 'sell_next_eob_last_balance')?></span></td>
							</tr>
<?php endif?>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<table width="100%" border="0" cellspacing="0" cellpadding="7">
						<tr class="bgcolor3">
							<td align="center" valign="middle">賣方 帳戶現金餘額
								<?php if(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '1'):?>
								<a id="sell_prev" href="javascript:;">(◄ 向上調整)</a>
								<?php endif?>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="1" cellpadding="5" id="sell_abcde">
						<tr class="bgcolor2">
							<td align="center" valign="middle">0-29</td>
							<td align="center" valign="middle">30-59</td>
							<td align="center" valign="middle">60-89</td>
							<td align="center" valign="middle">90-119</td>
							<td align="center" valign="middle">120+</td>
							<td align="center" valign="middle">總</td>
						</tr>
						<tr class="bgcolor1">
							<td align="right" valign="middle">0<?php if(0):?><span class="w_date02">-100</span><?php endif?></td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
						</tr>
				</table></td>
				<td width="30">&nbsp;</td>
				<td width="200" align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="7">
						<?php if(isset($updatecontent['id'])):?>
						<tr>
							<td align="center" class="bgcolor3">交易編號</td>
						</tr>
						<tr>
							<td align="center" class="bgcolor1"><strong><?php echo $updatecontent['id']?><?php if($updatecontent['is_enable'] == '0'):?><?php echo '<span class="w_date02">(取消交易)</span>'?><?php endif?></strong></td>
						</tr>
						<tr>
							<td height="5" align="center"></td>
						</tr>
						<?php endif?>
						<tr>
							<td align="center" class="bgcolor3">交易金額</td>
						</tr>
						<tr>
						<td align="center" class="bgcolor1"><input name="transation_eob" type="text" class="inputgo01" id="transation_eob" value="<?php Eobg::_echo($updatecontent, 'transation_eob')?>" size="25" /></td>
						</tr>
						<tr>
							<td align="center" class="bgcolor1"><input name="transation_cash" type="text" class="inputgo02" id="transation_cash" value="<?php Eobg::_echo($updatecontent, 'transation_cash')?>" size="25" /></td>
						</tr>
						<tr>
							<td height="5" align="center"></td>
						</tr>
						<tr>
							<td align="center" class="bgcolor3">描述</td>
						</tr>
						<tr>
							<td align="center" class="bgcolor1"><textarea name="comments" cols="25" rows="4" class="w_text"><?php Eobg::_echo($updatecontent, 'comments', '', false)?></textarea></td>
						</tr>
						<tr>
							<td height="5" align="center"></td>
						</tr>
						<tr>
							<td align="center" class="bgcolor3">其它描述</td>
						</tr>
						<tr>
							<td align="center" class="bgcolor1"><textarea name="comments_other" cols="25" rows="4" class="w_text"><?php Eobg::_echo($updatecontent, 'comments_other', '', false)?></textarea></td>
						</tr>
						<tr>
							<td height="5" align="center"></td>
						</tr>
<?php if(0):?>
						<tr>
							<td align="left" class="bgcolor1"><table width="100%" border="0" cellspacing="1" cellpadding="7" class="table1">
									<tbody>
										<tr class="bgcolor2">
											<td align="center" class="bgcolor3">帳單(發票)號碼</td>
											<td><input name="invoice_number" type="text" value="" size="10" /></td>
										</tr>
									</tbody>
							</table></td>
						</tr>
<?php endif?>
						<tr>
							<td height="5" align="center"></td>
						</tr>
<?php if(!isset($updatecontent['id'])):?>
						<tr id="confirm_button">
							<td align="center" valign="middle">
								<button class="btn_okgo btn blue"><i class="icon-ok"></i>確定交易</button>
							</td>
						</tr>
<?php endif?>
						<tr id="confirm_button_error" style="display:none;">
							<td align="center" valign="middle">
<!--
								<input type="submit" class="btn_okgo" onclick="return false;" value="請確認各欄位" style="background-color:#606060" />
-->
								<button class="btn_okgo btn red" onclick="return false;">請確認各欄位</button>
							</td>
						</tr>
<?php if(isset($updatecontent['id']) and $updatecontent['is_enable'] == '0'):?>
						<tr>
							<td align="center" class="bgcolor3">取消交易的原因</td>
						</tr>
						<tr>
						<td align="center" class="bgcolor1"><?php echo $updatecontent['delete_comments']?></td>
						</tr>
<?php endif?>

<?php if(isset($updatecontent['id']) and $updatecontent['is_enable'] == '1'):?>
						<tr>
							<td align="center" class="bgcolor3">取消交易的原因</td>
						</tr>
						<tr>
							<td align="center" class="bgcolor1"><textarea id="delete_comments" name="delete_comments" cols="25" rows="4" class="w_text"></textarea></td>
						</tr>
						<tr>
							<td align="center" valign="middle">
								<p class="text-error"><input type="checkbox" id="delete_transation" name="delete_transation" value="1" />取消此筆交易</p>
							</td>
						</tr>
						<tr>
							<?php // class=btn_okgo2 這是確定修改專用的class，但我改了一下?>
							<td align="center" valign="middle">
<!--
								<input type="submit" class="btn_okgo" id="button" value="確定修改">
-->
								<button class="btn_okgo btn green" id="button">確定修改</button>
							</td>
						</tr>
<?php endif?>
						<tr>
							<td align="center" valign="middle"><span id="other_error_message" class="w_date02"></span></td>
						</tr>
						<tr>
							<td align="center" valign="middle"><span id="sell_error_message" class="w_date02"></span></td>
						</tr>
						<tr>
							<td align="center" valign="middle"><span id="buy_error_message" class="w_date02"></span></td>
						</tr>
<?php if(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '1'):?>
						<tr>
							<td align="center" class="bgcolor3">買方簽訂費用</td>
						</tr>
<?php endif?>
					</table>

<?php if(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '1'):?>
					<table width="100%" border="0" cellspacing="1" cellpadding="4">
						<tr class="bgcolor2">
							<td width="52">入會費</td>
							<td>
								<input style="width:60px" name="buy_sign_marking_eob" type="text" class="inputgo01" id="buy_sign_marking_eob" value="<?php Eobg::_echo($updatecontent, 'buy_sign_marking_eob')?>" size="7" />&nbsp;&nbsp;
								<input style="width:60px" name="buy_sign_marking_cash" type="text" class="inputgo02" id="buy_sign_marking_cash" value="<?php Eobg::_echo($updatecontent, 'buy_sign_marking_cash')?>" size="7" />
							</td>
						</tr>
						<tr class="bgcolor1">
							<td>管理費</td>
							<td>
								<input style="width:60px" name="buy_sign_admin_eob" type="text" class="inputgo01" id="buy_sign_admin_eob" value="<?php Eobg::_echo($updatecontent, 'buy_sign_admin_eob')?>" size="7" />&nbsp;&nbsp;
								<input style="width:60px" name="buy_sign_admin_cash" type="text" class="inputgo02" id="buy_sign_admin_cash" value="<?php Eobg::_echo($updatecontent, 'buy_sign_admin_cash')?>" size="7" />
							</td>
						</tr>
						<tr class="bgcolor2">
							<td>備抵呆帳</td>
							<td>
								<input style="width:60px" name="buy_sign_debtres_eob" type="text" class="inputgo01" id="buy_sign_debtres_eob" value="<?php Eobg::_echo($updatecontent, 'buy_sign_debtres_eob')?>" size="7" />&nbsp;&nbsp;
								<input style="width:60px" name="buy_sign_debtres_cash" type="text" class="inputgo02" id="buy_sign_debtres_cash" value="<?php Eobg::_echo($updatecontent, 'buy_sign_debtres_cash')?>" size="7" />
							</td>
						</tr>
				</table>
<?php endif?>

<?php if(0):?>
                <table width="100%" border="0" cellspacing="1" cellpadding="7">
                  <tr>
                    <td height="5"></td>
                  </tr>
                  <tr>
                    <td align="center" class="bgcolor3">修改說明</td>
                  </tr>
                  <tr>
                    <td align="center" class="bgcolor1"><textarea name="textarea2" cols="25" rows="2" class="w_text" id="textarea"></textarea></td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle"><input name="button" type="submit" class="btn_okgo2" id="button" value="確定修改">取消交易不顯示此按鈕</td>
                  </tr>
                </table>
<?php endif?>
				</td>
				<td width="30">&nbsp;</td>
				<td align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="7" class="table1">
						<tbody>
							<tr class="bgcolor2">
								<td width="80" class="indexgo00">買方帳戶</td>
								<td><?php if(!isset($updatecontent['buy_card_number'])):?><input name="buy_card_number" type="text" id="buy_card_number" value="" size="18" /><?php else:?><strong><?php echo Eobg::format_card($updatecontent['buy_card_number'])?></strong><input type="hidden" id="buy_card_number" name="buy_card_number" value="<?php echo $updatecontent['buy_card_number']?>" /><?php endif?><br />
									&nbsp;<span id="buy_company_name"><?php if(!isset($updatecontent['buy_company_name'])):?>&nbsp;<?php else:?><?php echo $updatecontent['buy_company_name']?><?php endif?></span></td>
							</tr>
<?php if(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '1'):?>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr class="bgcolor3">
								<td>&nbsp;</td>
								<td>服務費用</td>
							</tr>
							<tr class="bgcolor2">
								<td>現金</td>
								<td>
									<input name="buy_transation_cash_a" type="text" id="buy_transation_cash_a" class="inputgo01 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'buy_transation_cash_a')?>" size="12" />&nbsp;&nbsp;
									<input name="buy_transation_cash_b" type="text" id="buy_transation_cash_b" class="inputgo02 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'buy_transation_cash_b')?>" size="12" />
								</td>
							</tr>
							<tr class="bgcolor1">
								<td>交易幣</td>
								<td>
									<input name="buy_transation_eob_a" type="text" id="buy_transation_eob_a" class="inputgo01 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'buy_transation_eob_a')?>" size="12" />&nbsp;&nbsp;
									<input name="buy_transation_eob_b" type="text" id="buy_transation_eob_b" class="inputgo02 inputgo0n" value="<?php Eobg::_echo($updatecontent, 'buy_transation_eob_b')?>" size="12" />
								</td>
							</tr>
							<tr class="bgcolor2">
								<td> 行政<br />
									交易幣收費 </td>
								<td>
								<input name="buy_administrative_eob_a" type="text" class="inputgo01 inputgo0n" id="buy_administrative_eob_a" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_eob_a')?>" size="12" />&nbsp;&nbsp;
									<input name="buy_administrative_eob_b" type="text" class="inputgo02 inputgo0n" id="buy_administrative_eob_b" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_eob_b')?>" size="12" />
								</td>
							</tr>
							<tr class="bgcolor1">
								<td> 行政現金費用 </td>
								<td>
									<input name="buy_administrative_cash_a" type="text" class="inputgo01 inputgo0n" id="buy_administrative_cash_a" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_cash_a')?>" size="12" />&nbsp;&nbsp;
									<input name="buy_administrative_cash_b" type="text" class="inputgo02 inputgo0n" id="buy_administrative_cash_b" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_cash_b')?>" size="12" />
								</td>
							</tr>
<?php elseif(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '2'):?>
							<input name="buy_transation_cash_a" type="hidden" id="buy_transation_cash_a" value="<?php Eobg::_echo($updatecontent, 'buy_transation_cash_a')?>" />
							<input name="buy_transation_cash_b" type="hidden" id="buy_transation_cash_b" value="<?php Eobg::_echo($updatecontent, 'buy_transation_cash_b')?>" />
							<input name="buy_transation_eob_a" type="hidden" id="buy_transation_eob_a" value="<?php Eobg::_echo($updatecontent, 'buy_transation_eob_a')?>" />
							<input name="buy_transation_eob_b" type="hidden" id="buy_transation_eob_b" value="<?php Eobg::_echo($updatecontent, 'buy_transation_eob_b')?>" />
							<input name="buy_administrative_eob_a" type="hidden" id="buy_administrative_eob_a" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_eob_a')?>" />
							<input name="buy_administrative_eob_b" type="hidden" id="buy_administrative_eob_b" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_eob_b')?>" />
							<input name="buy_administrative_cash_a" type="hidden" id="buy_administrative_cash_a" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_cash_a')?>" />
							<input name="buy_administrative_cash_b" type="hidden" id="buy_administrative_cash_b" value="<?php Eobg::_echo($updatecontent, 'buy_administrative_cash_b')?>" />
<?php endif?>
							<tr>
								<td height="5"></td>
								<td height="5"></td>
							</tr>
							<tr class="bgcolor2">
								<td>交易幣餘額</td>
								<td><span class="w_date" id="buy_eob_last_balance"><?php Eobg::_echo($updatecontent, 'buy_eob_last_balance')?></span></td>
							</tr>
							<tr class="bgcolor1">
								<td> 可用餘額</td>
								<td><span class="w_date" id="buy_eob_canuse_balance"><?php Eobg::_echo($updatecontent, 'buy_eob_canuse_balance')?></span></td>
							</tr>
							<tr class="bgcolor2">
								<td>費用種類</td>
								<td><span class="w_date" id="buy_card_name"><?php Eobg::_echo($updatecontent, 'buy_card_name', '&nbsp;')?></span></td>
							</tr>
<?php if(!isset($updatecontent['id'])):?>
							<tr class="bgcolor1">
								<td>新交易幣餘額</td>
								<td><span id="buy_next_eob_last_balance"><?php Eobg::_echo($updatecontent, 'buy_next_eob_last_balance')?></span></td>
							</tr>
<?php endif?>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<table width="100%" border="0" cellspacing="0" cellpadding="7">
						<tr class="bgcolor3">
							<td align="center" valign="middle">買方 帳戶現金餘額
								<?php if(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '1'):?>
								<a id="buy_prev" href="javascript:;">(◄ 向上調整)</a>
								<?php endif?>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="1" cellpadding="5" id="buy_abcde">
						<tr class="bgcolor2">
							<td align="center" valign="middle">0-29</td>
							<td align="center" valign="middle">30-59</td>
							<td align="center" valign="middle">60-89</td>
							<td align="center" valign="middle">90-119</td>
							<td align="center" valign="middle">120+</td>
							<td align="center" valign="middle">總</td>
						</tr>
						<tr class="bgcolor1">
							<td align="right" valign="middle">0<?php if(0):?><span class="w_date02">-31,000</span><?php endif?></td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
							<td align="right" valign="middle">0</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="indexgo03">
			<button onclick="window.location.href='<?php echo $current_url?>';return false;" class="btn_delete btn red" id="cancel_button"><i class="icon-remove"></i>取消</button>
		</div>
		<?php if(isset($updatecontent['id']) and $updatecontent['is_enable'] == '1'):?>
			<input type="hidden" name="hidden_id" value="<?php echo $updatecontent['id']?>" />
		<?php endif?>
		<input type="hidden" name="prev_url" value="<?php if(isset($update_base64_url)){ echo $prev_url; }?>" />
	</form>
<table><tr><td>
	賣方：<br />
	<iframe id="iframe_sell" width="600" height="500" frameborder="0" src=""></iframe>
</td><td width="400">
&nbsp;
</td><td>
	買方：<br />
	<iframe id="iframe_buy" width="600" height="500" frameborder="0" src=""></iframe>
</td></tr></table>

	</div>


	</div> <!-- portlet box -->

	</div> <!-- span12 -->

	<?php echo $this->renderPartial('//includes/tcofastmenu', $this->data)?>

</div> <!-- row-fluid -->

<?php
$transation_index = <<<XXX1
$('.btn-large').remove(); // 新增按鈕
$('#searchFrm').remove(); // 搜尋表單

// 即時搜尋卡號或是公司名稱(賣方)
$('#sell_card_number').keypress(function(event){      
	if (event.keyCode == 13){
		$.ajax({
			type: "POST",
			data: {
				'search_keyword': $(this).attr('value')
			},
			url: '{$class_url}/eob__backend_transation_search_member_sell_json',
			success: function(response){
				//alert(response);
				if(response != ''){
					eval(response);
				}
				//var obj = jQuery.parseJSON(response);
				//alert(obj);
				//alert(obj.name);
			}
		}); // ajax
		return false;
	}
});
$('#sell_card_number').blur(function(){      
	$.ajax({
		type: "POST",
		data: {
			'search_keyword': $(this).attr('value')
		},
		url: '{$class_url}/eob__backend_transation_search_member_sell_json',
		success: function(response){
			//alert(response);
			if(response != ''){
				eval(response);
			}
			//var obj = jQuery.parseJSON(response);
			//alert(obj);
			//alert(obj.name);
		}
	}); // ajax
});

// 即時搜尋卡號或是公司名稱(買方)
$('#buy_card_number').keypress(function(event){      
	if (event.keyCode == 13){
		$.ajax({
			type: "POST",
			data: {
				'search_keyword': $(this).attr('value')
			},
			url: '{$class_url}/eob__backend_transation_search_member_buy_json',
			success: function(response){
				//alert(response);
				if(response != ''){
					eval(response);
				}
				//var obj = jQuery.parseJSON(response);
				//alert(obj);
				//alert(obj.name);
			}
		}); // ajax
		return false;
	}
});
$('#buy_card_number').blur(function(){      
	$.ajax({
		type: "POST",
		data: {
			'search_keyword': $(this).attr('value')
		},
		url: '{$class_url}/eob__backend_transation_search_member_buy_json',
		success: function(response){
			//alert(response);
			if(response != ''){
				eval(response);
			}
			//var obj = jQuery.parseJSON(response);
			//alert(obj);
			//alert(obj.name);
		}
	}); // ajax
});

// 當管理者輸入了交易金額的時候(eob幣和現金)
$('#transation_eob').keypress(function(event){      
	if (event.keyCode == 13){
		$.ajax({
			type: "POST",
			data: {
				'value': $(this).attr('value')
			},
			url: '{$class_url}/eob__backend_transation_normal_eob_json',
			success: function(response){
				if(response != ''){
					eval(response);
				}
			}
		}); // ajax

		return false;
	}
});
$('#transation_eob').blur(function(){      
	$.ajax({
		type: "POST",
		data: {
			'value': $(this).attr('value')
		},
		url: '{$class_url}/eob__backend_transation_normal_eob_json',
		success: function(response){
			if(response != ''){
				eval(response);
			}
		}
	}); // ajax
});

$('#transation_cash').keypress(function(event){      
	if (event.keyCode == 13){
		$.ajax({
			type: "POST",
			data: {
				'value': $(this).attr('value')
			},
			url: '{$class_url}/eob__backend_transation_normal_cash_json',
			success: function(response){
				if(response != ''){
					eval(response);
				}
			}
		}); // ajax

		return false;
	}
});
$('#transation_cash').blur(function(){      
	$.ajax({
		type: "POST",
		data: {
			'value': $(this).attr('value')
		},
		url: '{$class_url}/eob__backend_transation_normal_cash_json',
		success: function(response){
			if(response != ''){
				eval(response);
			}
		}
	}); // ajax
});

// 當左邊按Enter的時候，存檔值，並觸發重新計算(只針對EOB)
$('#sell_transation_eob_a, #sell_transation_eob_b, #sell_administrative_eob_a, #sell_administrative_eob_b, #buy_transation_eob_a, #buy_transation_eob_b, #buy_administrative_eob_a, #buy_administrative_eob_b').keypress(function(event){
	if (event.keyCode == 13){
		$.ajax({
			type: "POST",
			data: {
				'value': $(this).attr('value'),
				'id': $(this).attr('id'),
				'type': 'sell'
			},
			url: '{$class_url}/eob__backend_transation_normal_calculate_json',
			success: function(response){
				if(response != ''){
					eval(response);
				}
			}
		}); // ajax

		return false;
	}
});
$('#sell_transation_eob_a, #sell_transation_eob_b, #sell_administrative_eob_a, #sell_administrative_eob_b, #buy_transation_eob_a, #buy_transation_eob_b, #buy_administrative_eob_a, #buy_administrative_eob_b').blur(function(event){
	$.ajax({
		type: "POST",
		data: {
			'value': $(this).attr('value'),
			'id': $(this).attr('id'),
			'type': 'sell'
		},
		url: '{$class_url}/eob__backend_transation_normal_calculate_json',
		success: function(response){
			if(response != ''){
				eval(response);
			}
		}
	}); // ajax
});

// 當右邊按Enter的時候，存檔值，並觸發重新計算(只針對EOB)
$('#buy_transation_eob_a, #buy_transation_eob_b, #buy_administrative_eob_a, #buy_administrative_eob_b').keypress(function(event){
	if (event.keyCode == 13){
		$.ajax({
			type: "POST",
			data: {
				'value': $(this).attr('value'),
				'id': $(this).attr('id'),
				'type': 'buy'
			},
			url: '{$class_url}/eob__backend_transation_normal_calculate_json',
			success: function(response){
				if(response != ''){
					eval(response);
				}
			}
		}); // ajax

		return false;
	}
});
$('#buy_transation_eob_a, #buy_transation_eob_b, #buy_administrative_eob_a, #buy_administrative_eob_b').blur(function(event){
	$.ajax({
		type: "POST",
		data: {
			'value': $(this).attr('value'),
			'id': $(this).attr('id'),
			'type': 'buy'
		},
		url: '{$class_url}/eob__backend_transation_normal_calculate_json',
		success: function(response){
			if(response != ''){
				eval(response);
			}
		}
	}); // ajax
});

// 當中間按Enter的時候，存檔值，並觸發重新計算(只針對EOB)
$('#buy_sign_marking_eob, #buy_sign_admin_eob, #buy_sign_debtres_eob').keypress(function(event){
	if (event.keyCode == 13){
		$.ajax({
			type: "POST",
			data: {
				'value': $(this).attr('value'),
				'id': $(this).attr('id'),
				'type': 'buy'
			},
			url: '{$class_url}/eob__backend_transation_normal_calculate_json',
			success: function(response){
				if(response != ''){
					eval(response);
				}
			}
		}); // ajax

		return false;
	}
});
$('#buy_sign_marking_eob, #buy_sign_admin_eob, #buy_sign_debtres_eob').blur(function(event){
	$.ajax({
		type: "POST",
		data: {
			'value': $(this).attr('value'),
			'id': $(this).attr('id'),
			'type': 'buy'
		},
		url: '{$class_url}/eob__backend_transation_normal_calculate_json',
		success: function(response){
			if(response != ''){
				eval(response);
			}
		}
	}); // ajax
});

$('#sell_prev').click(function(){
	$.ajax({
		type: "POST",
		data: {
			'card_number': $('#sell_card_number').attr('value'),
			'type': 'sell'
		},
		url: '{$class_url}/eob__backend_abcde_prev',
		success: function(response){
			if(response != ''){
				eval(response);
			}
		}
	}); // ajax
	return false;
});

$('#buy_prev').click(function(){
	$.ajax({
		type: "POST",
		data: {
			'card_number': $('#buy_card_number').attr('value'),
			'type': 'buy'
		},
		url: '{$class_url}/eob__backend_abcde_prev',
		success: function(response){
			if(response != ''){
				eval(response);
			}
		}
	}); // ajax
	return false;
});

// 這裡按Enter，可不是送出哦，目的是要取消本頁的Enter按鈕
$('.inputgo0n, .inputgo01, .inputgo02').keypress(function(event){
	if (event.keyCode == 13){
		return false;
	}
});

// 只是試試看而以，能用，但套起來怪怪的
//$('#mask_card').mask("9999-9999-9999-9999");

XXX1;

//$transation_index .= <<<XXX1
//XXX1;

// 有錯誤訊息的時候，依角色的不同，有不同的狀況
if(isset($_SESSION['transation_point']) and $_SESSION['transation_point'] == '1'){
	$transation_index .= <<<XXX1

$('#form_data').submit(function(){
	if($('#sell_error_message').html() != '' || $('#buy_error_message').html() != ''){
		if(!confirm('有錯誤訊息，您確定要做這個動作嗎？')){
			return false;
		}
	}

	if($('#sell_card_number').attr('value') != '' && $('#sell_card_number').attr('value') == $('#buy_card_number').attr('value')){
		alert('共同的帳戶不能做交易');
		return false;
	}
});

XXX1;

} else {

	$transation_index .= <<<XXX1

$('#form_data').submit(function(){
	if($('#sell_error_message').html() != '' || $('#buy_error_message').html() != ''){
		alert('有錯誤訊息，無法執行這筆交易!');
		return false;
	}

	if($('#sell_card_number').attr('value') != '' && $('#sell_card_number').attr('value') == $('#buy_card_number').attr('value')){
		alert('共同的帳戶不能做交易');
		return false;
	}
});

XXX1;

}

Yii::app()->clientScript->registerScript('transation_index', $transation_index, CClientScript::POS_END);

	// 將優先權提到最高(拉到最下面)
	$delete_comments = <<<XXX3
$('#delete_transation').click(function(){
	if($(this).attr('checked')){
		if(!confirm('Are you sure?')){
			$(this).parent().attr('class', '');
			return false;
		}
		$('#delete_comments').removeClass('ignore');
		form_data_validate.rules = {"delete_comments":{"required":true}};

		// http://stackoverflow.com/questions/2853416/jquery-disable-rule-validation-on-a-single-field
		form_data_validate.ignore = ".ignore";
	} else {
		//form_data_validate.rules = {};
		$('#delete_comments').addClass('ignore');
	}
	$("#form_data").validate(form_data_validate);
});

XXX3;

Yii::app()->clientScript->registerScript('delete_comments', $delete_comments, CClientScript::POS_READY, 99);
?>
