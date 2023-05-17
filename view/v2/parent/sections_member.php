<?php if(isset($this->data['layoutv2_sections_select'])):?>
	<?php if($this->data['layoutv2_sections_select'] == '1'):?><?php // 會員主選單?>
		<ul class="nav nav-pills nav-stacked text-left margin_base_b">
			<?php if(isset($this->data['layoutv2'][$this->data['section']['key']])):?>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']] as $k => $v):?>
					<li <?php if($v['url'] == 'index.php?r='.$this->data['router_class'].'/'.str_replace('detail','',$this->data['router_method'])):?>class="active"<?php endif?>><a href="<?php echo $v['url']?>"><?php echo G::t(null,$v['name'])?></a></li>
				<?php endforeach?>
			<?php endif?>
		</ul>
	<?php elseif($this->data['layoutv2_sections_select'] == '2'):?>
		<?php
			//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'paymenttype'))->order('sort_id asc')->queryAll();
			$rows = $this->db->createCommand()->from('payment_type')->where('is_enable=1')->order('sort_id asc')->queryAll();
			$paymenttype_tmp = array();
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					$paymenttype_tmp[$v['other1']] = $v['name'];
				}
			}
		?>
		<?php
			$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type', array(':type'=>'orderstatus'))->order('sort_id asc')->queryAll();
			$orderstatus_tmp = array();
			if($rows and count($rows) > 0){
				foreach($rows as $k => $v){
					$orderstatus_tmp[$v['other1']] = $v['topic'];
				}
			}
		?>
		<?php $rows = $this->db->createCommand()->from('orderform')->where('customer_id=:customer_id', array(':customer_id'=>$_SESSION['authw_admin_id']))->order('create_time desc')->queryAll()?>
		<table class="table table-hover text-center  margin_base_tb">
			<tr class="cis3-darker">
			  <td>訂單編號</td>
			  <td>訂單日期</td>
			  <td>訂單金額</td>
			  <td>付款方式</td>
			  <td>訂單明細</td>
			  <td>訂單狀態</td>
			</tr>
			<?php if($rows):?>
				<?php foreach($rows as $k => $v):?>
					<tr>
						<td><?php echo $v['order_number']?></td>
						<td><?php echo $v['create_time']?></td>
						<td>$<?php echo $v['total']?></td>
						<td><?php if(isset($paymenttype_tmp[$v['payment_type']])):?><?php echo $paymenttype_tmp[$v['payment_type']]?><?php endif?></td>
						<td><a class="btn btn-default btn-sm col-md-6 col-md-offset-3 col-sm-12" href="<?php echo $this->createUrl('member/orderdetail',array('id'=>$v['id']))?>">查詢</a></td>
						<?php if($v['order_status'] == 'nopayment'):?>
							<td class="cis2">未付款</td>
						<?php elseif($v['order_status'] == 'paymented'):?>
							<td class="cis3-darker">已付款</td>
						<?php else:?>
							<td>不支援的訂單編號</td>
						<?php endif?>
					</tr>
				<?php endforeach?>
			<?php endif?>
		</table>
	<?php elseif($this->data['layoutv2_sections_select'] == '3'):?>
	<?php elseif($this->data['layoutv2_sections_select'] == '4'):?>

		<?php $rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key', array(':type'=>'productshopspec',':ml_key'=>$this->data['ml_key']))->order('sort_id asc')->queryAll()?>
		<?php
		$specs_tmp = array();
		if($rows){
			foreach($rows as $k => $v){
				$specs_tmp[$v['id']] = $v;
			}
		}
		?>

		<?php if(isset($this->data['layoutv2'][$this->data['section']['key']]['car'])):?>
			<table class="table text-center margin_base_tb">
				<tbody><tr>
					<td class="col-xs-2"></td>
					<td class="col-xs-6 text-left">名稱</td>    
					<td class="col-xs-1">價格</td>
					<td class="col-xs-1">規格</td>
					<td class="col-xs-1">數量</td>
					<td class="col-xs-1">小計</td>
				</tr>
				<?php foreach($this->data['layoutv2'][$this->data['section']['key']]['car'] as $k => $v):?>
				<tr>
					<td><a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>"><img src="<?php echo '_i/assets/upload/productshop/'.$v['pic1']?>" class="img-responsive" ></a></td>
					<td class="text-left"><a href="<?php echo $this->createUrl('site/productshopdetail',array('id2'=>$k,'id'=>$v['class_id']))?>"><?php echo $v['name']?></a></td>
					<td valign="center">$<?php echo $v['price']?></td>
					<td><?php if(isset($specs_tmp[$v['spec_id']])):?><?php echo $specs_tmp[$v['spec_id']]['topic']?><?php endif?></td>
					<td><?php echo $v['amount']?></td>
					<td valign="center">$<?php echo $v['price']*$v['amount']?></td>                                                   
				</tr>
				<?php endforeach?>
				</tbody>
			</table>
		<?php endif?>
	<?php elseif($this->data['layoutv2_sections_select'] == '5'):?>
		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>

		<?php $total = $tmp['orderform']['total']?>

		<p class="title-sm"></p>
		<p>合計：$<?php echo $tmp['orderform']['sum']?></p>
		<p>運費：$<?php echo $tmp['orderform']['shipment']?></p>

		<?php if(0):?>
			<p>折扣：-$80</p>
		<?php endif?>

		<p>總計：<span class="cis2"><b>NTD.<?php echo $tmp['orderform']['total']?></b></span></p>
	<?php elseif($this->data['layoutv2_sections_select'] == '6'):?>

		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<?php echo $tmp['attr']['buyer']['raw']?>

		<?php if(0):?>
			<div>姓名：<span>xxxx</span></div>
			<div>電話：<span>0912-345678</span></div>
			<div>Email：<span>abc@buyersline.com.tw</span></div>
			<div>付款方式：<span>匯款.轉帳</span></div>
			<div>是否捐贈發票：<span>否</span></div>
			<div>統一編號：<span>否</span></div>
			<div>公司抬頭：<span>否</span></div>
			<div>發票寄送地址：<span>否</span></div>
		<?php endif?>

	<?php elseif($this->data['layoutv2_sections_select'] == '7'):?>

		<?php $tmp = $this->data['layoutv2'][$this->data['section']['key']]?>
		<?php echo $tmp['attr']['recipient']['raw']?>

		<?php if(0):?>
			<div>姓名：<span>xxxx</span></div>
			<div>電話：<span>0912-345678</span></div>
			<div>Email：<span>abc@buyersline.com.tw</span></div>
			<div>地址：<span>xxx</span><span>台中市大雅路123號</span></div>
			<div>備註：<span>蚵仔麵線不加蚵仔</span></div>
		<?php endif?>

	<?php endif?>
<?php endif?>
