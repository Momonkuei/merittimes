<?php
	$query = "select (SELECT count('*') FROM  `customer` WHERE  `gender` = '1') as men,(SELECT count('*') as weman FROM  `customer` WHERE  `gender` = '2') as wemen";
	$data = $this->db->createCommand($query)->queryRow();
	//if(!$data or !isset($data['id'])){
	if(!$data or ($data['men'] == 0 and $data['wemen'] == 0)){
		echo 'no data';die;
	}
	//var_dump($data);
	//die;
	//$data = mysql_fetch_array(mysql_query($query, $link));
?>

<?php echo $this->renderPartial('//includes/search', $this->data)?>

<div class="row">
	<div class="col-md-12">
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
						<tr style="background-color:skyblue;">
							<td></td>
							<td align="center">男</td>
							<td align="center">女</td>
						</tr>
						<tr>
							<td align="center">人數</td>
							<td align="center"><?php echo $data['men']?></td>
							<td align="center"><?php echo $data['wemen']?></td>
						</tr>
						<tr>
							<td align="center">百分比</td>
							<td align="center"><?echo number_format($data['men']/($data['men']+$data['wemen'])*100,2) ?>%</td>
							<td align="center"><?echo number_format($data['wemen']/($data['men']+$data['wemen'])*100,2) ?>%</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<tr style="background-color:skyblue;">
							<td colspan="2" align="center">縣市</td>
							<td colspan="2" align="center">人數</td>
						</tr>
						<?
							$query = "SELECT `addr_zipcode` AS zip,count(`addr_zipcode`) as cnt FROM `customer` GROUP BY `zip`";
							$data = $this->db->createCommand($query)->queryAll();
							//$result = mysql_query($query, $link);
							//while ($row = mysql_fetch_object_s($result)) {
							$Taipei_city=$Keelung=$Taipei=$Ilan=$Hsinchu=$Taoyuan=$Miaoli=$Taichung_city=$Changhua=$Nantou=$Chiayi=$Yunlin=$Tainan=$Kaohsiung=$Penghu=$Pingtung=$Taitung=$Hualien=$Gammon=$Lianjiang=$South_Island=$Diaoyu_Islands = 0;
							foreach($data as $k => $v){
								$row = new stdClass();
								foreach ($v as $key => $value){
									$row->$key = $value;
								}
								if($row->zip >= 100 && $row->zip <= 116){
									$Taipei_city += $row->cnt;
								}else if($row->zip >= 200 && $row->zip <= 206){
									$Keelung += $row->cnt;
								}else if($row->zip >= 207 && $row->zip <= 208){
									$Taipei += $row->cnt;
								}else if($row->zip >= 213 && $row->zip <= 253){
									$Taipei += $row->cnt;
								}else if($row->zip >= 260 && $row->zip <= 272){
									$Ilan += $row->cnt;
								}else if($row->zip >= 300 && $row->zip <= 315){
									$Hsinchu += $row->cnt;
								}else if($row->zip >= 320 && $row->zip <= 338){
									$Taoyuan += $row->cnt;
								}else if($row->zip >= 350 && $row->zip <= 369){
									$Miaoli += $row->cnt;
								}else if($row->zip >= 400 && $row->zip <= 439){
									$Taichung_city += $row->cnt;
								}else if($row->zip >= 500 && $row->zip <= 530){
									$Changhua += $row->cnt;
								}else if($row->zip >= 540 && $row->zip <= 558){
									$Nantou += $row->cnt;
								}else if($row->zip >= 600 && $row->zip <= 625){
									$Chiayi += $row->cnt;
								}else if($row->zip >= 630 && $row->zip <= 655){
									$Yunlin += $row->cnt;
								}else if($row->zip >= 700 && $row->zip <= 745){
									$Tainan += $row->cnt;
								}else if($row->zip >= 800 && $row->zip <= 816){
									$Kaohsiung += $row->cnt;
								}else if($row->zip >= 820 && $row->zip <= 852){
									$Kaohsiung += $row->cnt;
								}else if($row->zip >= 880 && $row->zip <= 885){
									$Penghu += $row->cnt;
								}else if($row->zip >= 900 && $row->zip <= 947){
									$Pingtung += $row->cnt;
								}else if($row->zip >= 950 && $row->zip <= 966){
									$Taitung += $row->cnt;
								}else if($row->zip >= 970 && $row->zip <= 983){
									$Hualien += $row->cnt;
								}else if($row->zip >= 890 && $row->zip <= 896){
									$Gammon += $row->cnt;
								}else if($row->zip >= 209 && $row->zip <= 212){
									$Lianjiang += $row->cnt;
								}else if($row->zip >= 817 && $row->zip <= 819){
									$South_Island += $row->cnt;
								}else if($row->zip == 290){
									$Diaoyu_Islands += $row->cnt;
								}
							}
							$Taiwan = array("台北市","基隆市","新北市","宜蘭縣","新竹縣市","桃園縣","苗栗縣","台中市","彰化縣","南投縣","嘉義縣市","雲林縣","台南市","高雄縣市","澎湖縣","屏東縣","台東縣","花蓮縣","金門縣","連江縣","南海諸島","釣魚台列嶼");
							$Taiwan_en = array($Taipei_city,$Keelung,$Taipei,$Ilan,$Hsinchu,$Taoyuan,$Miaoli,$Taichung_city,$Changhua,$Nantou,$Chiayi,$Yunlin,$Tainan,$Kaohsiung,$Penghu,$Pingtung,$Taitung,$Hualien,$Gammon,$Lianjiang,$South_Island,$Diaoyu_Islands);
							$count_array = array_combine($Taiwan,$Taiwan_en);
							arsort($count_array);
							

							$ii=0;
							foreach ($count_array as $key =>$row_2){
								if($row_2 != "" || $row_2 != NULL){
						?>
							<tr <?if($ii%2 ==1)echo "style='background-color:#ccc;'"?>>
								<td align="center"><?=$key?></td>
								<td colspan="2" align="center"><?=$row_2?></td>
							</tr>
						<?
							$ii++;
								}
							}
						?>
						<tr>
							<td colspan="3" align="center">郵遞區號符合三碼才列入計算</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<?
							$query = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) < 21 ";
							$query_1 = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) between 21 and 30 ";
							$query_2 = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) between 31 and 40 ";
							$query_3 = "SELECT count(floor(datediff(CURDATE(),`birthday`)/365)) age FROM `customer` where floor(datediff(CURDATE(),`birthday`)/365) > 41 ";
							//$age = mysql_fetch_array(mysql_query($query, $link));
							//$age_1 = mysql_fetch_array(mysql_query($query_1, $link));
							//$age_2 = mysql_fetch_array(mysql_query($query_2, $link));
							//$age_3 = mysql_fetch_array(mysql_query($query_3, $link));

							$age = $this->db->createCommand($query)->queryRow();
							$age_1 = $this->db->createCommand($query_1)->queryRow();
							$age_2 = $this->db->createCommand($query_2)->queryRow();
							$age_3 = $this->db->createCommand($query_3)->queryRow();
						?>
						<tr style="background-color:skyblue;">
							<td align="center">年齡層分佈</td>
							<td align="center">人數</td>
							<td align="center">百分比</td>
						</tr>
						<tr>
							<td align="center">20以下</td>
							<td align="center"><?=$age['age']?></td>
							<td align="center"><?echo number_format($age['age']/($age['age']+$age_1['age']+$age_2['age']+$age_3['age'])*100,2) ?>%</td>
						</tr>
						<tr>
							<td align="center">21~30</td>
							<td align="center"><?=$age_1['age']?></td>
							<td align="center"><?echo number_format($age_1['age']/($age['age']+$age_1['age']+$age_2['age']+$age_3['age'])*100,2) ?>%</td>
						</tr>
						<tr>
							<td align="center">31~40</td>
							<td align="center"><?=$age_2['age']?></td>
							<td align="center"><?echo number_format($age_2['age']/($age['age']+$age_1['age']+$age_2['age']+$age_3['age'])*100,2) ?>%</td>
						</tr>
						<tr>
							<td align="center">41以上</td>
							<td align="center"><?=$age_3['age']?></td>
							<td align="center"><?echo number_format($age_3['age']/($age['age']+$age_1['age']+$age_2['age']+$age_3['age'])*100,2) ?>%</td>
						</tr>
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
