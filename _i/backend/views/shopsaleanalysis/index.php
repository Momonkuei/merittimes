<?php echo $this->renderPartial('//includes/search', $this->data)?>

<?php
	$year = '';
	if(isset($_GET["year"])){
		$year = $_GET["year"];
	}
	if(empty($_GET["year"])) $year = date("Y");
	//$month = 1;
	$month = 9; // 測試
	/*
		此處的邏輯是 1~12月分開
		每月再把不同訂單狀態的金額累加
		$pay_type 為 status 有效的狀態
		$nonpay_type 為status 無效的狀態
		判斷status 吻合後累加到變數
		$pay  已附款
		$nonpay 未付款
		裡面 再從表單抓出來
	*/
	$pay_type = array('paymented',"1","2","3");
	$nonpay_type = array("0","4","5","6");

	$total = array();
	$pay = array();
	$nonpay = array();

	for($ii=1;$ii<=12;$ii++){
		$start_date = $year."/".$month."/01";
		//$end_date = $year."/".($month+1)."/01";
		$end_date = $year."/".($month)."/31";
		
		$query = "SELECT order_status AS status,total AS amount, total FROM `".str_replace('saleanalysis','',$this->data['router_class'])."orderform` WHERE is_enable!=0 and `create_time` between '".$start_date."' and '".$end_date."'";
		$data = $this->db->createCommand($query)->queryAll();

		//var_dump($data);
		//die;

		//$result = mysql_query($query, $link);
		//while ($row = mysql_fetch_object_s($result)) {

		foreach($data as $k => $v){
			$row = new stdClass();
			foreach ($v as $key => $value){
				$row->$key = $value;
			}

			if(!isset($pay[$ii])) $pay[$ii] = 0;
			if(!isset($nonpay[$ii])) $nonpay[$ii] = 0;
			if(!isset($total[$ii])) $total[$ii] = 0;

			if(in_array($row->status,$pay_type)){
				$pay[$ii] += $row->amount;
			}else if(in_array($row->status,$nonpay_type)){
				$nonpay[$ii] += $row->amount;
			}

			$total[$ii] += $row->amount;
		}
		$month++;
	}
?>

<div class="row ">
   <div class="col-md-12 col-sm-12">
      <!-- BEGIN REGIONAL STATS PORTLET-->
      <div class="portlet">
   		<!--BODY-->
      <div class="portlet blue box">
         <div class="portlet-title">
            <div class="caption"><i class="icon-cogs"></i></div>
         </div>
         <div class="portlet-body">
            <div class="note note-info">
   			<!--contant-->
   				<table width="50%" border="0" cellpadding="0" cellspacing="0">
   					<tr>
   						<td colspan="2">
						<form action="<?php echo $this->createUrl('saleanalysis/index')?>" method="GET" enctype="multipart/form-data" name="member_type_calculate">
								<input type="hidden" name="r" value="saleanalysis/index" />
   								<input type="text" maxlength="4" name="year" style=" width:50px;">年
   								<!--<select name="month">
   									<option value="1">一月</option>
   									<option value="2">二月</option>
   									<option value="3">三月</option>
   									<option value="4">四月</option>
   									<option value="5">五月</option>
   									<option value="6">六月</option>
   									<option value="7">七月</option>
   									<option value="8">八月</option>
   									<option value="9">九月</option>
   									<option value="10">十月</option>
   									<option value="11">十一月</option>
   									<option value="12">十二月</option>
   								</select>-->
   								<input type="submit" value="送出">
   							</form>
   						</td>
   					</tr>
   					<tr>
   						<td colspan="2">
   							年份請輸入西元 EX:2013
   						</td>
   					</tr>
   					<tr>
   						<td colspan="2">&nbsp;</td>
   					</tr>
   					<tr>
   						<td colspan="2">&nbsp;</td>
   					</tr>

   					<tr style="background-color:skyblue;">
   						<td colspan="4" align="center"><?=$year?>年</td>
   					</tr>
   					<tr>
   						<td align="center"></td>
   						<td align="center">訂單總額</td>
   						<td align="center">已付</td>
   						<td align="center">未付</td>
   					</tr>
   					<?for($ii=1;$ii<=12;$ii++){ ?>
   					<tr <?if($ii%2 ==1)echo "style='background-color:#ccc;'"?>>
   						<td align="center"><?=$ii?>月</td>
						<td align="center"><?php if(isset($total[$ii])):?><?php echo $total[$ii]?><?php endif?></td>
						<td align="center"><?php if(isset($pay[$ii])):?><?php echo $pay[$ii]?><?php endif?></td>
						<td align="center"><?php if(isset($nonpay[$ii])):?><?php echo $nonpay[$ii]?><?php endif?></td>
   					</tr>
   					<? } ?>

   				</table>
   			<!--contant-->
            </div>
         </div>
      </div>
   		<!--BODY-->
      </div>
      <!-- END REGIONAL STATS PORTLET-->
   </div>

</div>
