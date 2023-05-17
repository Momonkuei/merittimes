<?php

if(!empty($_POST)){
	$post = $_POST;
	$_SESSION['member_not']['atm_date']=$_POST['atm_date'];
	$_SESSION['member_not']['atm_bank']=$_POST['atm_bank'];
	$_SESSION['member_not']['atm_price']=$_POST['atm_price'];
	$_SESSION['member_not']['atm_number']=$_POST['atm_number'];
	$_SESSION['member_not']['atm_comment']=$_POST['atm_comment'];
	if($post['captcha'] != Yii::app()->session['captcha']){

	// 如果成功，就清session，很重要哦
	Yii::app()->session['captcha'] = '';

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('驗證碼錯誤')?>');
	window.location.href='membernoticepayment_<?php echo $this->data['ml_key']?>.php?order_number=<?php echo $post['order_number']?>';
</script>
<?php
		die;
	}

	// 如果驗證碼檢查通過，那就清session，很重要哦
	Yii::app()->session['captcha'] = '';

	$post['order_number'] = preg_replace("/[^A-Za-z0-9 ]/", "", $post['order_number']);

	// 找訂單的資料編號
	// $row = $this->db->createCommand()->select('id,total')->from('shoporderform')->where('order_number=:number and customer_id=:id',array(':number'=>$post['order_number'],':id'=>$this->data['admin_id']))->queryRow();
	$row = $this->cidb->select('id , total')
						->where('order_number' ,$post['order_number'] )
						->where('customer_id' ,$this->data['admin_id'] )
						->get('shoporderform')->row_array();
						
	if($row and isset($row['id'])){
		$update = array(
			'is_see' => 0,
			'atm_date' => $post['atm_date'],
			'atm_bank' => $post['atm_bank'],
			'atm_price' => $post['atm_price'],
			'atm_number' => $post['atm_number'],
			'atm_comment' => $post['atm_comment'],
			'order_status' => 11, // 己通知付款
		);
		//清除
		unset($_SESSION['member_not']);
		// 寫回訂單
		$this->cidb->where('id', $row['id']);
		$this->cidb->update('shoporderform', $update); 

		//寄信通知 - for 管理者	by lota

		// 信件格式
		$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>'匯款通知',':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 主旨
		$subject = $this->data['sys_configs']['admin_title'].' 匯款通知';

		if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
			$email_topic = $emailformat['topic'];
			$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
			// 記得最後要加上這一行，把多餘的額外欄位刪掉
			for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
			$subject = $email_topic;
		}
		
		$aaa_name = $_SESSION['authw_admin_name']; //購買者姓名
		$aaa_admin_title = $this->data['sys_configs']['admin_title'];

		//信件內容(TXT版)，由後台撈取
		if($emailformat and isset($emailformat['id']) and $emailformat['detail'] != ''){
			$email_content = $emailformat['detail'];
			
			$email_content = str_replace('{BB}', $aaa_name, $email_content);
			$email_content = str_replace('{CC}', $post['order_number'], $email_content);
			$email_content = str_replace('{DD}', $post['atm_date'], $email_content);
			$email_content = str_replace('{EE}', $row['total'], $email_content);
			$email_content = str_replace('{FF}', $post['atm_bank'], $email_content);
			$email_content = str_replace('{GG}', $post['atm_price'], $email_content);
			$email_content = str_replace('{HH}', $post['atm_number'], $email_content);
			$email_content = str_replace('{II}', $post['atm_comment'], $email_content);		

			// 記得最後要加上這一行，把多餘的額外欄位刪掉
			for($x=65;$x<=(65+26);$x++) $email_content = str_replace('{'.chr($x).'}', '', $email_content);

			$body = $email_content;
		}

		//信件內容(HTML版)，由後台撈取
		if($emailformat and isset($emailformat['id'])){
			if($emailformat['field_tmp'] != ''){
				$email_html_content = $emailformat['field_tmp'];

				$email_html_content = str_replace('{BB}', $aaa_name, $email_html_content);
				$email_html_content = str_replace('{CC}', $post['order_number'], $email_html_content);
				$email_html_content = str_replace('{DD}', $post['atm_date'], $email_html_content);
				$email_html_content = str_replace('{EE}', $row['total'], $email_html_content);
				$email_html_content = str_replace('{FF}', $post['atm_bank'], $email_html_content);
				$email_html_content = str_replace('{GG}', $post['atm_price'], $email_html_content);
				$email_html_content = str_replace('{HH}', $post['atm_number'], $email_html_content);
				$email_html_content = str_replace('{II}', $post['atm_comment'], $email_html_content);	


				// 記得最後要加上這一行，把多餘的額外欄位刪掉
				for($x=65;$x<=(65+26);$x++) $email_html_content = str_replace('{'.chr($x).'}', '', $email_html_content);

				$body_html = $email_html_content;
			} elseif($emailformat['field_tmp'] == '' and $emailformat['detail'] != ''){
				$body_html = nl2br($email_content);
			}
		}

		// 找一下寄件人有沒有設定
		$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

		// 找一下收件人有沒有設定
		$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

		if($from and count($from) > 0 and isset($from['id']) and isset($from['email']) and $tos and count($tos) > 0 and isset($tos[0]['id'])){ //後台信箱有設定才會寄信

			if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
				$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,null);
			} else {
				$this->email_send_to_v2($from,$tos, $subject, $body, $body_html,null);
			}
		}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('己通知付款')?>');
	window.location.href='membercenter_<?php echo $this->data['ml_key']?>.php';
</script>
<?php
		die; // 正常結束
	}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
	alert('<?php echo t('系統異常')?>');
	window.location.href='membercenter_<?php echo $this->data['ml_key']?>.php';
</script>
<?php

	die;

} // post

// 170215000001(12碼)
if(!isset($_GET['order_number']) or $_GET['order_number'] == ''){
	echo t('please define order_number field','en');
	die;
}
$order_number = preg_replace("/[^A-Za-z0-9 ]/", "", $_GET['order_number']);
$order_number = substr($order_number,0,12);

$updatecontent = $this->db->createCommand()->from('shoporderform')->where('order_number=:number and customer_id=:id',array(':number'=>$order_number,':id'=>$this->data['admin_id']))->queryRow();

//var_dump($updatecontent);
//die;

$data[$ID] = $updatecontent;
