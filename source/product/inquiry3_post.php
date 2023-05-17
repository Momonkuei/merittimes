<?php

if(!empty($_POST)){

	// 2018-03-27 電子信箱的在次驗證
	if (isset($_POST['email'])){
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			// do nothing
		} else {
			$redirect_url = $this->data['router_method'].'_'.$this->data['ml_key'].'.php?status=2';
		 	G::alert_captcha(t('Incorrent format `Email`','en'), $redirect_url, $this->data);
		}
	}


	// if(!isset($_POST['captcha']) or Yii::app()->session['captcha'] != $_POST['captcha']){ // 疑似有問題 2017-08-28下午發現的
	if(!isset($_POST['captcha']) or $_POST['captcha'] == '' or !isset(Yii::app()->session['captcha']) or Yii::app()->session['captcha'] == '' or Yii::app()->session['captcha'] != $_POST['captcha']){
		$redirect_url = $url_prefix.$this->data['router_method'].$url_suffix.'?status2';
		//G::alert_and_redirect(G::t(null,'驗證碼錯誤'), $redirect_url, $this->data);
		G::alert_captcha(t('驗證碼錯誤'), $redirect_url, $this->data);
	}

	// 安全性
	Yii::app()->session['captcha'] = '';
	$_POST['captcha'] = '';

	$router_method = $this->data['router_method'];

	$savedata = $_POST;

	// 現在產品洽詢表單的功能己經改成多語系
	$savedata['ml_key'] = $this->data['ml_key'];

	//var_dump($_SESSION);die;

	// 寫入後，要回存回去的
	$tmp_message = '';
	$tmp_inquiry = '';

	/*
	 * 2018-11-08
	 */
	$items = array(); // 洽詢的東西，裡面是存放session save的東西

	// 2018-07-19 如果A方案，要使用V1第二版的Datasource方式掛載，請用LayoutV3，將這個掛載放到head_start去運行
	if(isset($_SESSION['save'][$this->data['router_method']]) and !empty($_SESSION['save'][$this->data['router_method']])){
		$items = $_SESSION['save'][$this->data['router_method']];
	}

	// 2019-10-25
	if(!empty($items)){
		foreach($items as $k => $v){
			if(isset($v['ml_key']) and $v['ml_key'] != '' and $v['ml_key'] != $this->data['ml_key']){
				unset($items[$k]);
			}
		}
	}

	if(empty($items)){
		// 沒有詢問物件的話就轉跳到有詢問的地方 by lota 2018/6/13
		if(1){
			$redirect_url = str_replace('inquiry','',$this->data['router_method']).$url_suffix;		
			G::alert_and_redirect(t('無詢問物件，請先加入詢問'), $redirect_url, $this->data, true);
		} else { // A方案
	?>
<script type="text/javascript" m="body_end">
	$(document).ready(function() {
		alert('<?php echo t('無詢問物件，請先加入詢問','tw')?>');
		window.location.href='index_<?php echo $this->data['ml_key']?>.php';
	});
</script>	
	<?php
		}
	}

	include _BASEPATH.'/../source/system/inquiry.php';

	if(count($items) > 0){
		$tmp_message = $savedata['detail'];
		$savedata['detail'] .= "\n\n".'洽詢商品：'."\n";
		foreach($items as $k => $v){

			$content1 = "\n\r <a href=\"http://".aaa_url."/".$table."detail_".$this->data['ml_key'].".php?id=".$v['id']."\" target=\"_blank\"><img src=\"/".$v['pic']."\" alt=\"".$v['name']."\" style=\"width: 50px;\">".$v['name'];
			$content2 = "\n\r <a href=\"http://".aaa_url."/".$table."detail_".$this->data['ml_key'].".php?id=".$v['id']."\" target=\"_blank\">".$v['name'];

			if(isset($v['amount'])){
				if($v['amount'] > 0){
					$content1 .= '*'.$v['amount'];
					$content2 .= '*'.$v['amount'];
				} else {
					// #25678 如果有數量，但為零，那就不加上這一筆
					continue;
				}
			}

			$content1 .= "</a>\n\r";
			$content2 .= "</a><br />\n\r";

			$savedata['detail'] .= $content1;
			$tmp_inquiry .= $content2;
			// }
		}
	} else {
		$redirect_url = $url_prefix.$router_method.$url_suffix.'?status=3';
		G::alert_captcha(t('請先加入產品到詢問車'), $redirect_url, $this->data);
	}

	if(isset($savedata['addr']) and $savedata['addr'] != ''){
		if(isset($savedata['district']) and $savedata['district'] != '') $savedata['addr'] = $savedata['district'].$savedata['addr'];
		if(isset($savedata['county']) and $savedata['county'] != '') $savedata['addr'] = $savedata['county'].$savedata['addr'];
		if(isset($savedata['zipcode']) and $savedata['zipcode'] != '') $savedata['addr'] = $savedata['zipcode'].$savedata['addr'];
	}

	$empty_orm_data = array(
		'table' => $router_method,
		'created_field' => 'create_time', 
		//'updated_field' => 'update_time',
		'primary' => 'id',
		'rules' => array(
			array('name, phone, email', 'required'),
		),
	);

	// 寫入驗證碼到該會員資料表
	// eval($this->data['empty_orm_eval']);
	// $u = new $name('insert', $empty_orm_data);
	// // 修改專用
	// //$u = $c::model()->findByPk($row['id']);
	// $u->setAttributes($savedata);
	// if(!$u->save()){
	// 	G::dbm($u->getErrors());
	// }

	$orm = new gorm($this->cidb, $empty_orm_data);
	$orm->data($savedata);
	$status = $orm->validate(); // 回傳true或false

	if($status === false){
		// var_dump($orm->message());
		$redirect_url = $url_prefix.$router_method.$url_suffix;
		G::alert_captcha(t('欄位資料驗證失敗'), $redirect_url, $this->data);
	}

	$status = $orm->insert(); // 回傳寫入狀態
	// $id = $db->insert_id();

	if($status === false){
		$redirect_url = $url_prefix.$router_method.$url_suffix;
		G::alert_captcha(t('寫入失敗'), $redirect_url, $this->data);
	}

	// 這個是寫入之後才做的東西
	// if(isset($savedata['gender']) and $savedata['gender'] > 0){
	// 	if($savedata['gender'] == '1'){
	// 		$savedata['gender'] = t('男');
	// 	} elseif($savedata['gender'] == '2'){
	// 		$savedata['gender'] = t('女');
	// 	}
	// }

	// 回存
	$savedata['detail'] = $tmp_message;
	$savedata['inquiry'] = $tmp_inquiry;

	/*
	 * 載入後台的產品洽詢，欄位的中文之接對應和取用
	 */
	$contentx = file_get_contents(_BASEPATH.ds('/backend').ds('/controllers/').ucfirst($router_method).'Controller.php');
	//$contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/backend').ds('/controllers/').ucfirst($router_method).'.php');
	$contentx = str_replace('<'.'?'.'php', '', $contentx);
	$contentx = str_replace('extends Controller', '', $contentx);
	$contentx = str_replace('protected $def', 'static public $def', $contentx);
	
	// 把懶人機制拿掉
	$contentx = str_replace('$tmps = explode(\'/\',__FILE__);', '', $contentx);
	$contentx = str_replace('$filename = str_replace(\'.php\',\'\',$tmps[count($tmps)-1]);', '', $contentx);
	$contentx = str_replace('eval(\'class \'.$filename.\' extends NonameController {}\');', '', $contentx);
	
	eval($contentx);

	//$admin_def = ProductinquiryController::$def;
	//eval('$admin_def = '.ucfirst($router_method).'Controller::$def;');
	eval('$admin_def = NonameController::$def;');

	$admin_def['updatefield']['sections'][1]['field']['inquiry'] = array(
		'label' => '詢問產品',
	);
	$to = $this->data['sys_configs']['service_admin_mail'];

	// 信件格式，目前只有用到標題
	$emailformat = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and other1=:topic',array(':topic'=>'商品洽詢',':type'=>'emailformat',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 主旨
	//$subject = $this->data['sys_configs']['admin_title'].' Contact Us 客戶聯絡信件';
	$subject = $this->data['sys_configs']['admin_title'].' 商品洽詢信件';

	// 信件格式，這裡只有用到信件的標題而以
	if($emailformat and isset($emailformat['id']) and $emailformat['topic'] != ''){
		$email_topic = $emailformat['topic'];
		$email_topic = str_replace('{AA}', $this->data['sys_configs']['admin_title'], $email_topic);
		// 記得最後要加上這一行，把多餘的額外欄位刪掉
		for($x=65;$x<=(65+26);$x++) $email_topic = str_replace('{'.chr($x).'}', '', $email_topic);
		$subject = $email_topic;
	}

	$aaa_url = aaa_url;
	$aaa_name = $this->data['sys_configs']['admin_title'];

	$body = '此信為系統發出，請勿回覆'."\n\n";
	//$body .= '123';

	$body_html_content = '';

	foreach(array(0,1) as $k => $section_id){
		$admin_field = $admin_def['updatefield']['sections'][$section_id]['field'];
		if(count($admin_field) > 0){
			$kk = 0;
			foreach($admin_field as $k => $v){
				if(isset($savedata[$k])){
					$field_name = '';
					if(isset($v['mlabel'][3]) and $v['mlabel'][3] != ''){
						$field_name = $v['mlabel'][3];
					}
					if(isset($v['label']) and $v['label'] != ''){
						$field_name = $v['label'];
					}
					$body .= $field_name.': '.strip_tags($savedata[$k])."\n";

					if(preg_match('/^(inquiry)$/', $k)){
						$field_data = $savedata[$k];
					} else {
						$field_data = strip_tags($savedata[$k]);
					}

					ob_start();
					//if($k%2 == 0){
					if($kk%2 == 0){ // 2016-11-18 小李建議的
?>
<tr bgcolor="#FBF0BD">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php if($k == 'detail_g'):?><?php echo $savedata[$k]?><?php else:?><?php echo $field_data?><?php endif?></td>
</tr>
<? } else { ?>		
<tr bgcolor="#FFFFFF">
	<td align="right"><p align="right"><?php echo $field_name?><br />
	</p></td>
	<td width="300"><?php if($k == 'detail_g'):?><?php echo $savedata[$k]?><?php else:?><?php echo $field_data?><?php endif?></td>
</tr>
<?php 
					}
					$body_html_content .= ob_get_clean();
					$kk++;
				}
			}
		}
	} // section_id

	$body_html = <<<XXX
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="0" cellpadding="4" cellspacing="1" bordercolorlight="#ffffff" bordercolordark="#666666" bgcolor="#CCCCCC" >
$body_html_content
</table>
<p style="font-size:13px;color:#999">$aaa_name $aaa_url</p>
XXX;

	//protected function email_send_to($to, $subject, $body, $body_html)

	// 找一下寄件人有沒有設定
	$from = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_home=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryRow();

	// 找一下收件人有沒有設定
	$tos = $this->db->createCommand()->select('*,topic as name,other1 as email')->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key and is_news=1',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();

	//設定cc收件者
	if(defined('CC_MAIL_OPEN') && CC_MAIL_OPEN==true)
		$cc_mail = $savedata['email'];
	else
		$cc_mail = NULL;

	// 詢問主題
	// $row = $this->cidb->select('*,other1 as email')->where('is_enable',1)->where('type','question')->where('ml_key',$this->data['ml_key'])->where('id',$savedata['class_id'])->get('html')->row_array();
	// if($row and isset($row['id'])){
	// 	$tos = array(
	// 		array(
	// 			'name' => '',
	// 			'email' => $row['email'],
	// 		),
	// 	);
	// }

	if($from and count($from) > 0 and isset($from['id']) and isset($from['email'])
		and $tos and count($tos) > 0 and isset($tos[0]['id'])){
		if(isset($this->data['sys_configs']['smtp_ssl']) and $this->data['sys_configs']['smtp_ssl'] == 'sendmail'){
			$this->email_send_to_by_sendmail($from,$tos, $subject, $body, $body_html,$cc_mail);
		} else {
			$this->email_send_to_v2($from,$tos, $subject, $body, $body_html,$cc_mail);
		}
	} else {	
		//$this->email_send_to($to, $subject, $body, $body_html,$cc_mail);//如果後台沒設定就不寄信
	}

	$redirect_url = $url_prefix.str_replace('inquiry','',$this->data['router_method']).$url_suffix;

	// 2019-10-25 李哥早上說，送出後會全清，維持現況
	$_SESSION['save'][$router_method] = array();
	unset($_SESSION['save'][$router_method]);
	unset(Yii::app()->session['save']);

	G::alert_and_redirect(t('送出成功'), $redirect_url, $this->data, true);
}
